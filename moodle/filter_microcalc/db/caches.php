<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

/**
 * Caches: calculator list (12 hours) and the last good copy for when the service is down.
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

defined('MOODLE_INTERNAL') || die();

$definitions = [
    'catalog' => [
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true,
        'ttl' => 43200,
    ],
    'catalogstale' => [
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true,
    ],
];
