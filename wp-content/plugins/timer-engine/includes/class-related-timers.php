<?php
/**
 * Related Timers Computation
 *
 * Implements the Koray SCN internal linking rules:
 * - Minutes: neighbors (X±1), same-bucket populars (2–4), step links (X+5, X+10), global populars fallback
 * - Seconds: neighbors (X±1), popular seconds fallback
 * - Capped at 8–12 for minutes, 6–10 for seconds
 */

if (!defined('ABSPATH')) {
    exit;
}

class Timer_Related
{

    private static $instance = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get related timer posts for a given timer post.
     *
     * @param int|WP_Post $post Post object or ID.
     * @return array Array of related timer data: ['post' => WP_Post, 'value' => int, 'unit' => string, 'slug' => string]
     */
    public function get_related($post)
    {
        if (is_int($post))
            $post = get_post($post);
        if (!$post)
            return [];

        $value = (int) get_post_meta($post->ID, '_timer_value', true);
        $unit = get_post_meta($post->ID, '_timer_unit', true);

        if (!$value || !$unit)
            return [];

        if ($unit === 'minutes') {
            return $this->get_related_minutes($value, $post->ID);
        } else {
            return $this->get_related_seconds($value, $post->ID);
        }
    }

    /**
     * Compute related timers for minute-based timers.
     * Target: 8–12 links
     */
    private function get_related_minutes($value, $exclude_post_id)
    {
        $related_values = [];

        // 1. Neighbors: value - 1, value + 1
        if ($value > 1)
            $related_values[] = $value - 1;
        if ($value < 161)
            $related_values[] = $value + 1;

        // 2. Same-bucket populars (2–4)
        $loader = Timer_Content_Loader::get_instance();
        $bucket = $loader->get_bucket_for_timer($value, 'minutes');
        $dataset = $loader->get_dataset();
        $global_populars = $dataset['globalPopulars']['minutes'] ?? [];

        // Get populars in same bucket
        $bucket_defs = $dataset['taxonomies']['buckets']['minutes'] ?? [];
        $bucket_range = null;
        foreach ($bucket_defs as $b) {
            if ($b['id'] === $bucket) {
                $bucket_range = $b;
                break;
            }
        }

        if ($bucket_range) {
            $bucket_populars = array_filter($global_populars, function ($v) use ($bucket_range, $value) {
                return $v >= $bucket_range['min'] && $v <= $bucket_range['max'] && $v !== $value;
            });
            $bucket_populars = array_slice(array_values($bucket_populars), 0, 4);
            $related_values = array_merge($related_values, $bucket_populars);
        }

        // 3. Step links: X+5 and X+10 (if in range)
        if (($value + 5) <= 161 && !in_array($value + 5, $related_values)) {
            $related_values[] = $value + 5;
        }
        if (($value + 10) <= 161 && !in_array($value + 10, $related_values)) {
            $related_values[] = $value + 10;
        }

        // 4. Global populars fallback (fill up to 12)
        foreach ($global_populars as $pop) {
            if (count($related_values) >= 12)
                break;
            if ($pop !== $value && !in_array($pop, $related_values)) {
                $related_values[] = $pop;
            }
        }

        // Deduplicate and remove self
        $related_values = array_unique(array_filter($related_values, fn($v) => $v !== $value));

        // Cap at 12
        $related_values = array_slice(array_values($related_values), 0, 12);

        // Sort numerically
        sort($related_values);

        return $this->resolve_timer_posts($related_values, 'minutes', $exclude_post_id);
    }

    /**
     * Compute related timers for second-based timers.
     * Target: 6–10 links
     */
    private function get_related_seconds($value, $exclude_post_id)
    {
        $related_values = [];
        $second_values = [1, 5, 10, 30, 60];

        // 1. Neighbors
        $current_index = array_search($value, $second_values);
        if ($current_index !== false) {
            if ($current_index > 0) {
                $related_values[] = $second_values[$current_index - 1];
            }
            if ($current_index < count($second_values) - 1) {
                $related_values[] = $second_values[$current_index + 1];
            }
        }

        // 2. All other second timers
        foreach ($second_values as $sv) {
            if ($sv !== $value && !in_array($sv, $related_values)) {
                $related_values[] = $sv;
            }
        }

        // 3. Cross-link to popular minute timers (fill up to 10)
        $loader = Timer_Content_Loader::get_instance();
        $dataset = $loader->get_dataset();
        $minute_populars = $dataset['globalPopulars']['minutes'] ?? [];
        foreach ($minute_populars as $mp) {
            if (count($related_values) >= 10)
                break;
            $related_values[] = ['value' => $mp, 'unit' => 'minutes'];
        }

        // Resolve posts
        $results = [];
        foreach ($related_values as $rv) {
            if (is_array($rv)) {
                $timer_post = $this->find_timer_post($rv['value'], $rv['unit']);
            } else {
                $timer_post = $this->find_timer_post($rv, 'seconds');
            }
            if ($timer_post && $timer_post->ID !== $exclude_post_id) {
                $results[] = [
                    'post' => $timer_post,
                    'value' => is_array($rv) ? $rv['value'] : $rv,
                    'unit' => is_array($rv) ? $rv['unit'] : 'seconds',
                    'slug' => $timer_post->post_name,
                ];
            }
        }

        return array_slice($results, 0, 10);
    }

    /**
     * Resolve an array of timer values into post objects.
     */
    private function resolve_timer_posts($values, $unit, $exclude_post_id)
    {
        $results = [];
        foreach ($values as $val) {
            $timer_post = $this->find_timer_post($val, $unit);
            if ($timer_post && $timer_post->ID !== $exclude_post_id) {
                $results[] = [
                    'post' => $timer_post,
                    'value' => $val,
                    'unit' => $unit,
                    'slug' => $timer_post->post_name,
                ];
            }
        }
        return $results;
    }

    /**
     * Find a timer post by value and unit.
     * Uses a cached transient lookup for performance.
     */
    private function find_timer_post($value, $unit)
    {
        $cache_key = "timer_post_{$unit}_{$value}";
        $cached = wp_cache_get($cache_key, 'timer_engine');
        if ($cached !== false)
            return $cached;

        $query = new WP_Query([
            'post_type' => 'timer',
            'posts_per_page' => 1,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_timer_value',
                    'value' => $value,
                    'type' => 'NUMERIC',
                ],
                [
                    'key' => '_timer_unit',
                    'value' => $unit,
                ],
            ],
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        $post = $query->have_posts() ? $query->posts[0] : null;
        wp_cache_set($cache_key, $post, 'timer_engine', 3600);

        return $post;
    }

    /**
     * Get popular timer posts for a given unit.
     * Returns array of timer data.
     */
    public function get_popular_posts($unit = null, $limit = 12)
    {
        $args = [
            'post_type' => 'timer',
            'posts_per_page' => $limit,
            'meta_query' => [
                [
                    'key' => '_timer_is_popular',
                    'value' => '1',
                ],
            ],
            'orderby' => 'meta_value_num',
            'meta_key' => '_timer_value',
            'order' => 'ASC',
        ];

        if ($unit) {
            $args['meta_query'][] = [
                'key' => '_timer_unit',
                'value' => $unit,
            ];
            $args['meta_query']['relation'] = 'AND';
        }

        $query = new WP_Query($args);
        $results = [];
        foreach ($query->posts as $post) {
            $results[] = [
                'post' => $post,
                'value' => (int) get_post_meta($post->ID, '_timer_value', true),
                'unit' => get_post_meta($post->ID, '_timer_unit', true),
                'slug' => $post->post_name,
            ];
        }
        return $results;
    }

    /**
     * Get all timer posts for a unit, ordered by value.
     */
    public function get_all_by_unit($unit, $bucket = null)
    {
        $args = [
            'post_type' => 'timer',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_timer_unit',
                    'value' => $unit,
                ],
            ],
            'orderby' => 'meta_value_num',
            'meta_key' => '_timer_value',
            'order' => 'ASC',
        ];

        if ($bucket) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'timer_bucket',
                    'field' => 'slug',
                    'terms' => $bucket,
                ],
            ];
        }

        $query = new WP_Query($args);
        $results = [];
        foreach ($query->posts as $post) {
            $results[] = [
                'post' => $post,
                'value' => (int) get_post_meta($post->ID, '_timer_value', true),
                'unit' => get_post_meta($post->ID, '_timer_unit', true),
                'slug' => $post->post_name,
            ];
        }
        return $results;
    }
}
