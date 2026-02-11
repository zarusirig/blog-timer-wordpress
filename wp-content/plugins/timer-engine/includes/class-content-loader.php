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
     * Get dataset path — tries multiple locations.
     */
    private function get_datasets_path()
    {
        // Docker volume mount (preferred)
        $paths = [
            '/var/www/datasets/',                    // Docker volume mount
            ABSPATH . '../datasets/',                // Docker: relative to web root
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
