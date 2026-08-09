<?php
/**
 * Timer Content Loader
 * Loads and rotates content from copyblocks.json and strings.en.json
 */

if (!defined('ABSPATH')) {
    exit;
}

class Timer_Content_Loader
{

    private static $instance = null;
    private $strings = null;
    private $copyblocks = null;
    private $dataset = null;
    private $duration_facts = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        // Lazy load on first use
    }

    /**
     * Load strings file.
     */
    private function load_strings()
    {
        if ($this->strings !== null)
            return;
        $file = $this->get_datasets_path() . 'strings.en.json';
        if (file_exists($file)) {
            $this->strings = json_decode(file_get_contents($file), true);
        }
        if (!$this->strings)
            $this->strings = [];
    }

    /**
     * Load copyblocks file.
     */
    private function load_copyblocks()
    {
        if ($this->copyblocks !== null)
            return;
        $file = $this->get_datasets_path() . 'copyblocks.json';
        if (file_exists($file)) {
            $this->copyblocks = json_decode(file_get_contents($file), true);
        }
        if (!$this->copyblocks)
            $this->copyblocks = [];
    }

    /**
     * Load dataset file.
     */
    private function load_dataset()
    {
        if ($this->dataset !== null)
            return;
        $file = $this->get_datasets_path() . 'timers.dataset.json';
        if (file_exists($file)) {
            $this->dataset = json_decode(file_get_contents($file), true);
        }
        if (!$this->dataset)
            $this->dataset = [];
    }

    /**
     * Load duration facts file.
     */
    private function load_duration_facts()
    {
        if ($this->duration_facts !== null)
            return;
        $file = $this->get_datasets_path() . 'duration-facts.json';
        if (file_exists($file)) {
            $this->duration_facts = json_decode(file_get_contents($file), true);
        }
        if (!$this->duration_facts)
            $this->duration_facts = [];
    }

    /**
     * Get dataset path — tries multiple locations.
     */
    private function get_datasets_path()
    {
        // Docker volume mount (preferred)
        $paths = [
            '/var/www/datasets/',                    // Docker volume mount
            ABSPATH . '../datasets/',                // Docker: relative to web root
            ABSPATH . 'datasets/',                   // Cloudways: within public_html
            TIMER_ENGINE_PATH . '../../datasets/',   // relative from plugin
        ];
        foreach ($paths as $path) {
            if (is_dir($path))
                return $path;
        }
        return ABSPATH . '../datasets/';
    }

    /**
     * Get an individual localized string with placeholder substitution.
     */
    public function get_string($key, $replacements = [])
    {
        $this->load_strings();
        $value = $this->strings[$key] ?? null;
        if ($value === null)
            return null;

        foreach ($replacements as $placeholder => $replacement) {
            $value = str_replace('{' . $placeholder . '}', $replacement, $value);
        }
        return $value;
    }

    /**
     * Get intro text for a timer post.
     * Rotates variant by timer value to ensure uniqueness.
     */
    public function get_intro($post)
    {
        $this->load_copyblocks();
        $this->load_dataset();

        $value = (int) get_post_meta($post->ID, '_timer_value', true);
        $unit = get_post_meta($post->ID, '_timer_unit', true);
        $bucket = $this->get_bucket_for_timer($value, $unit);

        if (!$bucket)
            return '';

        // Get variants for this bucket
        $variant_keys = $this->dataset['contentLibraries']['introVariants'][$unit][$bucket] ?? [];
        if (empty($variant_keys))
            return '';

        // Rotate by value
        $variant_key = $variant_keys[$value % count($variant_keys)];
        $intro_text = $this->copyblocks['intros'][$variant_key]['en'] ?? '';

        // Replace {value} placeholder
        $intro_text = str_replace('{value}', $value, $intro_text);

        return $intro_text;
    }

    /**
     * Get FAQ entries for a timer post.
     * Returns array of ['q' => ..., 'a' => ...] entries, rotated by timer value.
     */
    public function get_faqs($post, $count = 4)
    {
        $this->load_copyblocks();

        $value = (int) get_post_meta($post->ID, '_timer_value', true);
        $all_faqs = $this->copyblocks['faqs'] ?? [];

        // Collect timer_core FAQs
        $faq_entries = [];
        foreach ($all_faqs as $key => $faq) {
            if (strpos($key, 'faq_timer_') === 0) {
                $faq_entries[] = $faq['en'];
            }
        }

        if (empty($faq_entries))
            return [];

        // Rotate starting position by value
        $offset = $value % count($faq_entries);
        $rotated = array_merge(
            array_slice($faq_entries, $offset),
            array_slice($faq_entries, 0, $offset)
        );

        return array_slice($rotated, 0, $count);
    }

    /**
     * Get Pomodoro FAQs.
     */
    public function get_pomodoro_faqs()
    {
        $this->load_copyblocks();
        $faqs = [];
        foreach ($this->copyblocks['faqs'] as $key => $faq) {
            if (strpos($key, 'faq_pomo_') === 0) {
                $faqs[] = $faq['en'];
            }
        }
        return $faqs;
    }

    /**
     * Get quick use ideas for a timer post.
     */
    public function get_quick_use_ideas($post, $count = 6)
    {
        $this->load_copyblocks();

        $value = (int) get_post_meta($post->ID, '_timer_value', true);
        $unit = get_post_meta($post->ID, '_timer_unit', true);
        $bucket = $this->get_bucket_for_timer($value, $unit);

        if (!$bucket)
            return [];

        $ideas = $this->copyblocks['quickUseIdeas'][$unit][$bucket] ?? [];
        if (empty($ideas))
            return [];

        // Rotate by value for variety
        $offset = $value % count($ideas);
        $rotated = array_merge(
            array_slice($ideas, $offset),
            array_slice($ideas, 0, $offset)
        );

        return array_slice($rotated, 0, $count);
    }

    /**
     * Determine bucket ID for a given timer value and unit.
     */
    public function get_bucket_for_timer($value, $unit)
    {
        $this->load_dataset();
        $buckets = $this->dataset['taxonomies']['buckets'][$unit] ?? [];
        foreach ($buckets as $bucket) {
            if ($value >= $bucket['min'] && $value <= $bucket['max']) {
                return $bucket['id'];
            }
        }
        return null;
    }

    /**
     * Get the "About this duration" facts for a timer value/unit.
     * Facts are precomputed conversions and verified anchors from duration-facts.json.
     * Returns an array of plain-text sentences (possibly empty).
     */
    public function get_duration_facts($value, $unit)
    {
        $this->load_duration_facts();
        $facts = $this->duration_facts[$unit][(string) $value] ?? [];
        if (!is_array($facts))
            return [];
        return array_values(array_filter($facts, 'is_string'));
    }

    /**
     * Get semantically adjacent timers for a value/unit from the dataset.
     * Candidates: direct neighbors, the two nearest multiples of five in each
     * direction (nearest known values for the sparse hours list), plus the
     * half and double durations. Only durations present in timers.dataset.json
     * are returned, so no link can point to a non-existent timer page.
     * Returns array of ['value' => int, 'unit' => string, 'slug' => string].
     */
    public function get_nearby_timers($value, $unit)
    {
        $this->load_dataset();

        $value = (int) $value;
        $slug_map = [];
        foreach ($this->dataset['timers'] ?? [] as $t) {
            if (($t['unit'] ?? '') === $unit && !empty($t['slug'])) {
                $slug_map[(int) $t['value']] = $t['slug'];
            }
        }
        if (empty($slug_map))
            return [];

        $candidates = [];
        if ($unit === 'hours') {
            // Sparse list: take the two nearest known values in each direction
            $known = array_keys($slug_map);
            sort($known);
            $below = array_values(array_filter($known, fn($v) => $v < $value));
            $above = array_values(array_filter($known, fn($v) => $v > $value));
            $candidates = array_merge(array_slice($below, -2), array_slice($above, 0, 2));
        } else {
            // Direct neighbors
            $candidates[] = $value - 1;
            $candidates[] = $value + 1;
            // Two nearest multiples of five below and above
            $down = (int) (floor(($value - 1) / 5) * 5);
            $candidates[] = $down;
            $candidates[] = $down - 5;
            $up = (int) (ceil(($value + 1) / 5) * 5);
            $candidates[] = $up;
            $candidates[] = $up + 5;
        }

        // Half and double durations where those pages exist
        $candidates[] = (int) floor($value / 2);
        $candidates[] = $value * 2;

        $nearby = [];
        foreach ($candidates as $cv) {
            if ($cv === $value || $cv <= 0)
                continue;
            if (!isset($slug_map[$cv]))
                continue;
            $nearby[$cv] = [
                'value' => $cv,
                'unit' => $unit,
                'slug' => $slug_map[$cv],
            ];
        }
        ksort($nearby);

        return array_values($nearby);
    }

    /**
     * Get the full dataset array.
     */
    public function get_dataset()
    {
        $this->load_dataset();
        return $this->dataset;
    }

    /**
     * Get all timer entries from dataset.
     */
    public function get_all_timer_entries()
    {
        $this->load_dataset();
        return $this->dataset['timers'] ?? [];
    }

    /**
     * Get popular timer entries from dataset.
     */
    public function get_popular_timers($unit = null)
    {
        $timers = $this->get_all_timer_entries();
        $populars = array_filter($timers, function ($t) use ($unit) {
            if (!$t['isPopular'])
                return false;
            if ($unit && $t['unit'] !== $unit)
                return false;
            return true;
        });
        return array_values($populars);
    }

    /**
     * Get hub definitions from dataset.
     */
    public function get_hubs()
    {
        $this->load_dataset();
        return $this->dataset['hubs'] ?? [];
    }

    /**
     * Get bucket definitions for a unit.
     */
    public function get_buckets($unit)
    {
        $this->load_dataset();
        return $this->dataset['taxonomies']['buckets'][$unit] ?? [];
    }

    /**
     * Get use case definitions.
     */
    public function get_use_cases()
    {
        $this->load_dataset();
        return $this->dataset['taxonomies']['useCases'] ?? [];
    }
}
