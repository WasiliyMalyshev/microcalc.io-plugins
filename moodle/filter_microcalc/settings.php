<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

/**
 * Settings.
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('filter_microcalc/consent',
        get_string('consent', 'filter_microcalc'), get_string('consent_desc', 'filter_microcalc'), 0));
    $settings->add(new admin_setting_configselect('filter_microcalc/lang',
        get_string('lang', 'filter_microcalc'), '', 'auto',
        ['auto' => get_string('lang_auto', 'filter_microcalc'), 'ru' => 'Русский', 'en' => 'English', 'fr' => 'Français']));
    $settings->add(new admin_setting_configselect('filter_microcalc/theme',
        get_string('theme', 'filter_microcalc'), '', 'light',
        ['light' => get_string('theme_light', 'filter_microcalc'), 'dark' => get_string('theme_dark', 'filter_microcalc'),
         'auto' => get_string('theme_auto', 'filter_microcalc')]));
    $settings->add(new admin_setting_configcolourpicker('filter_microcalc/accent',
        get_string('accent', 'filter_microcalc'), get_string('accent_desc', 'filter_microcalc'), ''));
    $settings->add(new admin_setting_configtext('filter_microcalc/base',
        get_string('base', 'filter_microcalc'), get_string('base_desc', 'filter_microcalc'), '', PARAM_URL));
}
