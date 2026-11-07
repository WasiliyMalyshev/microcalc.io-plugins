<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

/**
 * Filter class for Moodle 4.1–4.4; Moodle 4.5+ uses classes/text_filter.php.
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

defined('MOODLE_INTERNAL') || die();

if (class_exists('\core_filters\text_filter')) {
    class_alias(\filter_microcalc\text_filter::class, 'filter_microcalc');
} else {
    /**
     * Replaces {microcalc id=…} with the MicroCalc widget.
     */
    class filter_microcalc extends moodle_text_filter {
        /**
         * Apply the filter.
         *
         * @param string $text
         * @param array $options
         * @return string
         */
        public function filter($text, array $options = []) {
            return \filter_microcalc\local\embed::filter($text, $this->context);
        }
    }
}
