<?php
/**
 * Guide Generator — WP-CLI Command
 *
 * Usage: wp guide generate
 * Idempotent: safe to run multiple times, updates existing posts instead of creating duplicates.
 */

if (!defined('ABSPATH')) {
    exit;
}

class Guide_Generator_Command
{

    /**
     * Generate all guide posts from the dataset.
     *
     * ## OPTIONS
     *
     * [--dry-run]
     * : Show what would be created/updated without making changes.
     *
     * ## EXAMPLES
     *
     *     wp guide generate
     *     wp guide generate --dry-run
     *
     * @when after_wp_load
     */
    public function generate($args, $assoc_args)
    {
        $dry_run = isset($assoc_args['dry-run']);

        WP_CLI::log('Guide Generator — starting...');

        // Load dataset manually since it's a separate file
        $dataset_path = TIMER_ENGINE_DATASETS . 'guides.dataset.json';
        if (!file_exists($dataset_path)) {
            WP_CLI::error('Could not find datasets/guides.dataset.json');
            return;
        }

        $dataset = json_decode(file_get_contents($dataset_path), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            WP_CLI::error('Invalid JSON in guides.dataset.json');
            return;
        }

        $guides = $dataset['guides'] ?? [];
        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($guides as $guide) {
            $result = $this->ensure_guide_post($guide, $dry_run);
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

        WP_CLI::success("Guide generation complete. Created: $created, Updated: $updated, Skipped: $skipped");

        if (!$dry_run) {
            flush_rewrite_rules();
            WP_CLI::log('Rewrite rules flushed.');
        }
    }

    /**
     * Create or update a single guide post.
     */
    private function ensure_guide_post($entry, $dry_run)
    {
        $guide_id = $entry['id'];
        $slug = $entry['slug'];
        $title = $entry['title'];
        $cluster = $entry['cluster'];

        // Check if post already exists by guide_id meta
        $existing = get_posts([
            'post_type' => 'guide',
            'posts_per_page' => 1,
            'meta_key' => 'guide_id',
            'meta_value' => $guide_id,
            'post_status' => 'any',
        ]);

        $post_data = [
            'post_title' => $title,
            'post_name' => $slug,
            'post_type' => 'guide',
            'post_status' => 'publish',
            'post_excerpt' => $entry['excerpt'] ?? '',
        ];

        // Content — normally we'd generate this or leave it to the template.
        // For this task, the content is dynamic in the template, so we leave post_content empty or minimal.
        // But to avoid "empty content" issues, we can set a placeholder or summary.
        // Let's set the excerpt as content for now if empty.
        $post_data['post_content'] = '<!-- Guide content rendered via template -->';

        if (!empty($existing)) {
            $post_id = $existing[0]->ID;
            $post_data['ID'] = $post_id;

            if ($dry_run) {
                WP_CLI::log("[dry-run] Would update: $title (ID: $post_id)");
                return 'updated';
            }

            wp_update_post($post_data);
            WP_CLI::log("[updated] $title (ID: $post_id)");
            $result = 'updated';
        } else {
            if ($dry_run) {
                WP_CLI::log("[dry-run] Would create: $title");
                return 'created';
            }

            $post_id = wp_insert_post($post_data);
            if (is_wp_error($post_id)) {
                WP_CLI::warning("Failed to create: $title — " . $post_id->get_error_message());
                return 'skipped';
            }
            WP_CLI::log("[created] $title (ID: $post_id)");
            $result = 'created';
        }

        // Update meta
        update_post_meta($post_id, 'guide_id', $guide_id);
        update_post_meta($post_id, 'guide_primary_hub', $entry['primaryHub']);
        update_post_meta($post_id, 'guide_timers', $entry['timers']);
        update_post_meta($post_id, 'guide_related', $entry['relatedGuides']);
        update_post_meta($post_id, 'guide_faqs', $entry['faqs'] ?? []);

        // Set Cluster taxonomy
        if ($cluster) {
            wp_set_object_terms($post_id, ucfirst($cluster), 'guide_cluster');
        }

        return $result;
    }
}

WP_CLI::add_command('guide', 'Guide_Generator_Command');
