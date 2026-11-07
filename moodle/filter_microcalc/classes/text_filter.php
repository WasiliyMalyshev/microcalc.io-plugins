<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

namespace filter_microcalc;

/**
 * Replaces {microcalc id=…} with the MicroCalc widget (Moodle 4.5+).
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */
class text_filter extends \core_filters\text_filter {
    /**
     * Apply the filter.
     *
     * @param string $text
     * @param array $options
     * @return string
     */
    public function filter($text, array $options = []) {
        return local\embed::filter($text, $this->context);
    }
}
