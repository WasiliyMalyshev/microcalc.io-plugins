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

$string['accent'] = 'Цвет кнопок';
$string['accent_desc'] = 'Пусто — как на сервисе.';
$string['base'] = 'Адрес сервиса';
$string['base_desc'] = 'Оставьте пустым (https://microcalc.io/). Меняйте, только если сервис переедет на другой адрес.';
$string['cachedef_catalog'] = 'Список калькуляторов MicroCalc';
$string['cachedef_catalogstale'] = 'Последний загруженный список калькуляторов MicroCalc';
$string['consent'] = 'Принимаю условия';
$string['consent_desc'] = 'Виджет бесплатный. Под каждым виджетом фильтр выводит обычную ссылку на страницу калькулятора на сервисе. Ссылка должна быть открыта для поисковых систем: без неё виджет показывает ошибку и не считает. Пока условия не приняты, виджеты не показываются. Как вставить: {microcalc id=318} в любом тексте; можно добавить lang, theme, accent, width.';
$string['filtername'] = 'Виджеты MicroCalc';
$string['lang'] = 'Язык';
$string['lang_auto'] = 'Текущий язык Moodle';
$string['notice_catalog'] = 'Виджет MicroCalc: не удалось загрузить список калькуляторов.';
$string['notice_consent'] = 'Виджет MicroCalc скрыт: администратор должен принять условия в настройках фильтра MicroCalc.';
$string['notice_id'] = 'Виджет MicroCalc: укажите калькулятор, например {microcalc id=318}.';
$string['notice_notfound'] = 'Виджет MicroCalc: калькулятор не найден.';
$string['pluginname'] = 'Виджеты MicroCalc';
$string['privacy:metadata:microcalc'] = 'Виджет загружается с сервиса MicroCalc во фрейме; сервису передаётся адрес страницы с виджетом для проверки ссылки.';
$string['privacy:metadata:microcalc:pageurl'] = 'Адрес страницы с виджетом';
$string['theme'] = 'Тема';
$string['theme_auto'] = 'Как в системе';
$string['theme_dark'] = 'Тёмная';
$string['theme_light'] = 'Светлая';
