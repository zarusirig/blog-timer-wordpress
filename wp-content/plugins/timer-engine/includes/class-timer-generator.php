<?php
/**
 * Timer Generator — WP-CLI Command
 *
 * Usage: wp timer generate --path=/var/www/html
 * Idempotent: safe to run multiple times, updates existing posts instead of creating duplicates.
 */

if (!defined('ABSPATH')) {
    exit;
}

class Timer_Generator_Command
{

    /**
     * Generate all timer posts from the dataset.
     *
     * ## OPTIONS
     *
     * [--dry-run]
     * : Show what would be created/updated without making changes.
     *
     * ## EXAMPLES
     *
     *     wp timer generate
     *     wp timer generate --dry-run
     *
     * @when after_wp_load
     */
    public function generate($args, $assoc_args)
    {
        $dry_run = isset($assoc_args['dry-run']);

        WP_CLI::log('Timer Generator — starting...');

        $loader = Timer_Content_Loader::get_instance();
        $dataset = $loader->get_dataset();

        if (empty($dataset)) {
            WP_CLI::error('Could not load timers.dataset.json. Check the datasets/ directory.');
            return;
        }

        // Ensure taxonomy terms exist
        $this->ensure_taxonomies($dataset, $dry_run);

        // Generate timer posts
        $timers = $dataset['timers'] ?? [];
        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($timers as $timer_entry) {
            $result = $this->ensure_timer_post($timer_entry, $dataset, $dry_run);
            switch ($result) {
                case 'created':
                    $created++;
                    break;
                case 'updated':
                    $updated++;
                    break;
                case 'skipped':
                    $skipped++;
                    break;
            }
        }

        // Create hub pages
        $this->ensure_hub_pages($dataset, $dry_run);

        WP_CLI::success("Timer generation complete. Created: $created, Updated: $updated, Skipped: $skipped");

        // Flush rewrite rules
        if (!$dry_run) {
            flush_rewrite_rules();
            WP_CLI::log('Rewrite rules flushed.');
        }
    }

    /**
     * Ensure all taxonomy terms exist.
     */
    private function ensure_taxonomies($dataset, $dry_run)
    {
        // Units
        foreach ($dataset['taxonomies']['units'] as $unit) {
            if (!term_exists($unit, 'timer_unit')) {
                if (!$dry_run) {
                    wp_insert_term(ucfirst($unit), 'timer_unit', ['slug' => $unit]);
                }
                WP_CLI::log("[taxonomy] Created unit term: $unit");
            }
        }

        // Buckets
        foreach ($dataset['taxonomies']['buckets'] as $unit_key => $buckets) {
            foreach ($buckets as $bucket) {
                if (!term_exists($bucket['id'], 'timer_bucket')) {
                    if (!$dry_run) {
                        wp_insert_term($bucket['label'], 'timer_bucket', [
                            'slug' => $bucket['id'],
                            'description' => $bucket['description'],
                        ]);
                    }
                    WP_CLI::log("[taxonomy] Created bucket term: {$bucket['id']}");
                }
            }
        }

        // Use cases
        foreach ($dataset['taxonomies']['useCases'] as $uc) {
            if ($uc['enabled'] && !term_exists($uc['id'], 'timer_usecase')) {
                if (!$dry_run) {
                    wp_insert_term($uc['label'], 'timer_usecase', [
                        'slug' => $uc['id'],
                        'description' => $uc['description'],
                    ]);
                }
                WP_CLI::log("[taxonomy] Created use case term: {$uc['id']}");
            }
        }
    }

    /**
     * Create or update a single timer post.
     * Idempotent: looks up by _timer_id meta.
     */
    private function ensure_timer_post($entry, $dataset, $dry_run)
    {
        $timer_id = $entry['id'];
        $value = $entry['value'];
        $unit = $entry['unit'];
        $slug = $entry['slug'];

        // Check if post already exists by _timer_id
        $existing = get_posts([
            'post_type' => 'timer',
            'posts_per_page' => 1,
            'meta_key' => '_timer_id',
            'meta_value' => $timer_id,
            'post_status' => 'any',
        ]);

        // Get content from loader
        $loader = Timer_Content_Loader::get_instance();
        $title_key = "timer.title.{$unit}";
        $title = $loader->get_string($title_key, ['value' => $value]);
        if (!$title) {
            $title = "Set Timer for {$value} " . ucfirst($unit);
        }

        // Determine bucket
        $bucket = $loader->get_bucket_for_timer($value, $unit);

        $post_data = [
            'post_title' => $title,
            'post_name' => $slug,
            'post_type' => 'timer',
            'post_status' => 'publish',
            'post_content' => '', // Content is rendered by template, not stored in post
        ];

        if (!empty($existing)) {
            // Update existing
            $post_id = $existing[0]->ID;
            $post_data['ID'] = $post_id;

            if ($dry_run) {
                WP_CLI::log("[dry-run] Would update: $title (post ID: $post_id)");
                return 'updated';
            }

            wp_update_post($post_data);
            WP_CLI::log("[updated] $title (post ID: $post_id)");
            $result = 'updated';
        } else {
            // Create new
            if ($dry_run) {
                WP_CLI::log("[dry-run] Would create: $title");
                return 'created';
            }

            $post_id = wp_insert_post($post_data);
            if (is_wp_error($post_id)) {
                WP_CLI::warning("Failed to create: $title — " . $post_id->get_error_message());
                return 'skipped';
            }
            WP_CLI::log("[created] $title (post ID: $post_id)");
            $result = 'created';
        }

        // Update meta fields
        update_post_meta($post_id, '_timer_id', $timer_id);
        update_post_meta($post_id, '_timer_value', $value);
        update_post_meta($post_id, '_timer_unit', $unit);
        update_post_meta($post_id, '_timer_is_popular', $entry['isPopular'] ? 1 : 0);

        // Assign taxonomy terms
        wp_set_object_terms($post_id, $unit, 'timer_unit');
        if ($bucket) {
            wp_set_object_terms($post_id, $bucket, 'timer_bucket');
        }
        if (!empty($entry['useCases'])) {
            wp_set_object_terms($post_id, $entry['useCases'], 'timer_usecase');
        }

        return $result;
    }

    /**
     * Create hub pages if they don't exist.
     */
    private function ensure_hub_pages($dataset, $dry_run)
    {
        $hubs = $dataset['hubs'] ?? [];
        $loader = Timer_Content_Loader::get_instance();

        foreach ($hubs as $hub) {
            $slug = $hub['slug'];
            $title_key = $hub['titleKey'];
            $title = $loader->get_string($title_key) ?: $slug;

            // Check if page exists
            $existing = get_page_by_path($slug);
            if ($existing) {
                WP_CLI::log("[hub] Page already exists: $title ($slug)");
                continue;
            }

            if ($dry_run) {
                WP_CLI::log("[dry-run] Would create hub page: $title ($slug)");
                continue;
            }

            $page_id = wp_insert_post([
                'post_title' => $title,
                'post_name' => $slug,
                'post_type' => 'page',
                'post_status' => 'publish',
                'post_content' => '',
                'page_template' => $hub['template'] ?? '',
            ]);

            if (is_wp_error($page_id)) {
                WP_CLI::warning("Failed to create hub page: $title — " . $page_id->get_error_message());
            } else {
                // Set page template
                if (!empty($hub['template'])) {
                    update_post_meta($page_id, '_wp_page_template', $hub['template']);
                }
                WP_CLI::log("[hub][created] $title (page ID: $page_id)");
            }
        }
    }
}

WP_CLI::add_command('timer', 'Timer_Generator_Command');
