<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

/**
 * Strings.
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['accent'] = 'Button color';
$string['accent_desc'] = 'Empty — service default.';
$string['base'] = 'Service address';
$string['base_desc'] = 'Leave empty (https://microcalc.io/). Change only if the service moves to another address.';
$string['cachedef_catalog'] = 'MicroCalc calculator list';
$string['cachedef_catalogstale'] = 'Last loaded MicroCalc calculator list';
$string['consent'] = 'Accept the terms';
$string['consent_desc'] = 'The widget is free. Under each widget the filter shows a regular link to the calculator page on the service. The link must stay open to search engines: without it the widget shows an error and does not calculate. Until you accept, widgets are not shown. Usage: {microcalc id=318} in any text; optional lang, theme, accent, width.';
$string['filtername'] = 'MicroCalc widgets';
$string['lang'] = 'Language';
$string['lang_auto'] = 'Current Moodle language';
$string['notice_catalog'] = 'MicroCalc widget: could not load the calculator list.';
$string['notice_consent'] = 'MicroCalc widget is hidden: the administrator has to accept the terms in the MicroCalc filter settings.';
$string['notice_id'] = 'MicroCalc widget: specify the calculator, for example {microcalc id=318}.';
$string['notice_notfound'] = 'MicroCalc widget: calculator not found.';
$string['pluginname'] = 'MicroCalc widgets';
$string['privacy:metadata:microcalc'] = 'The widget is loaded from the MicroCalc service in a frame; the address of the page with the widget is sent to check the link to the service.';
$string['privacy:metadata:microcalc:pageurl'] = 'Address of the page with the widget';
$string['theme'] = 'Theme';
$string['theme_auto'] = 'System';
$string['theme_dark'] = 'Dark';
$string['theme_light'] = 'Light';
