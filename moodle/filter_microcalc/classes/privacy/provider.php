<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

namespace filter_microcalc\privacy;

/**
 * The plugin stores no personal data; the page address is sent to the MicroCalc service.
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */
class provider implements \core_privacy\local\metadata\provider {
    /**
     * Data sent to the external service.
     *
     * @param \core_privacy\local\metadata\collection $collection
     * @return \core_privacy\local\metadata\collection
     */
    public static function get_metadata(\core_privacy\local\metadata\collection $collection): \core_privacy\local\metadata\collection {
        $collection->add_external_location_link('microcalc', ['pageurl' => 'privacy:metadata:microcalc:pageurl'], 'privacy:metadata:microcalc');
        return $collection;
    }
}
