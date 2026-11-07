<?php
// This file is part of the MicroCalc filter for Moodle - https://microcalc.io/
// License: GNU GPL v2 or later.

namespace filter_microcalc\local;

/**
 * Builds the MicroCalc widget markup on the server (spec/embed.md, section 2):
 * the link must be visible to search robots.
 *
 * @package    filter_microcalc
 * @copyright  2026 MicroCalc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */
class embed {
    /** Service address by default: defined only here, can be changed in the filter settings. */
    const BASE = 'https://microcalc.io/';

    /** Catalog format version. */
    const VERSION = 1;

    /** @var bool widget.js already printed on this page */
    private static $scriptprinted = false;

    /** @var array catalogs loaded during this request */
    private static $catalogs = [];

    /**
     * Replace {microcalc id=318 lang=ru theme=dark} in the text.
     *
     * @param string $text
     * @param \context $context
     * @return string
     */
    public static function filter($text, $context) {
        if (!is_string($text) || stripos($text, '{microcalc') === false) {
            return $text;
        }
        // Editors wrap the tag in <p>: a div inside p is invalid, so the paragraph is replaced as a whole.
        return preg_replace_callback('~(?:<p[^>]*>\s*)?\{microcalc\s+([^}]*)\}(?:\s*</p>)?~i', function($m) use ($context) {
            return self::render(self::attributes($m[1]), $context);
        }, $text);
    }

    /**
     * Attributes key=value or key="value".
     *
     * @param string $raw
     * @return array
     */
    private static function attributes($raw) {
        $attrs = [];
        preg_match_all('~(\w+)\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s"\']+))~u', html_entity_decode($raw), $m, PREG_SET_ORDER);
        foreach ($m as $pair) {
            $value = (string)($pair[2] ?? '');
            $value = $value !== '' ? $value : (string)($pair[3] ?? '');
            $value = $value !== '' ? $value : (string)($pair[4] ?? '');
            $attrs[strtolower($pair[1])] = trim($value);
        }
        return $attrs;
    }

    /**
     * Widget HTML, or a hint for teachers explaining why there is no widget.
     *
     * @param array $atts
     * @param \context $context
     * @return string
     */
    private static function render(array $atts, $context) {
        if (!get_config('filter_microcalc', 'consent')) {
            return self::notice(get_string('notice_consent', 'filter_microcalc'), $context);
        }
        $id = (int)($atts['id'] ?? 0);
        if ($id <= 0) {
            return self::notice(get_string('notice_id', 'filter_microcalc'), $context);
        }
        $lang = self::lang($atts['lang'] ?? '');
        $catalog = self::catalog($lang);
        $item = null;
        foreach ($catalog['items'] ?? [] as $row) {
            if ((int)$row['id'] === $id) {
                $item = $row;
                break;
            }
        }
        if (!$item) {
            return self::notice(get_string($catalog ? 'notice_notfound' : 'notice_catalog', 'filter_microcalc'), $context);
        }

        $query = self::style_query($atts);
        $query['src'] = 'moodle';
        // разделитель задан явно: Moodle задаёт arg_separator.output = &amp;, и адрес экранировался бы дважды
        $src = $item['widget_src'] . (strpos($item['widget_src'], '?') === false ? '?' : '&') . http_build_query($query, '', '&');
        $width = max(0, (int)($atts['width'] ?? 0));

        $html = '<div class="calc-widget" data-src="' . s($src) . '"' . ($width ? ' style="max-width:' . $width . 'px"' : '') . '></div>' . "\n"
            . '<p class="calc-widget-link"><a href="' . s($item['page_url']) . '">' . s($item['name']) . '</a> — ' . s($catalog['site']['name']) . '</p>' . "\n";
        if (!self::$scriptprinted) {
            self::$scriptprinted = true;
            $html .= '<script src="' . s($catalog['site']['script']) . '" async></script>' . "\n";
        }
        return $html;
    }

    /**
     * Service address with a trailing slash.
     *
     * @return string
     */
    private static function base() {
        $base = trim((string)get_config('filter_microcalc', 'base'));
        return rtrim(($base !== '' && strpos($base, 'https://') === 0) ? $base : self::BASE, '/') . '/';
    }

    /**
     * Widget language: attribute, setting, then the current Moodle language.
     *
     * @param string $lang
     * @return string
     */
    private static function lang($lang) {
        $allowed = ['ru', 'en', 'fr'];
        if (in_array($lang, $allowed, true)) {
            return $lang;
        }
        $setting = (string)get_config('filter_microcalc', 'lang');
        if (in_array($setting, $allowed, true)) {
            return $setting;
        }
        $current = substr(current_language(), 0, 2);
        return in_array($current, $allowed, true) ? $current : 'en';
    }

    /**
     * Style parameters: attribute, otherwise setting; only allowed values and only differences from defaults.
     *
     * @param array $atts
     * @return array
     */
    private static function style_query(array $atts) {
        $q = [];
        $theme = ($atts['theme'] ?? '') !== '' ? $atts['theme'] : (string)get_config('filter_microcalc', 'theme');
        if (in_array($theme, ['dark', 'auto'], true)) {
            $q['theme'] = $theme;
        }
        if (($atts['accent'] ?? '') === '') {
            $atts['accent'] = (string)get_config('filter_microcalc', 'accent');
        }
        foreach (['accent', 'bg', 'text', 'border', 'link'] as $key) {
            $v = strtolower(ltrim(trim((string)($atts[$key] ?? '')), '#'));
            if (preg_match('/^([0-9a-f]{3}|[0-9a-f]{6})$/', $v)) {
                $q[$key] = $v;
            }
        }
        foreach (['radius' => [0, 24, 6], 'size' => [12, 20, 16], 'pad' => [0, 40, 12]] as $key => $r) {
            $v = $atts[$key] ?? '';
            if (is_numeric($v) && (int)$v >= $r[0] && (int)$v <= $r[1] && (int)$v !== $r[2]) {
                $q[$key] = (int)$v;
            }
        }
        $fonts = ['inter', 'arial', 'verdana', 'tahoma', 'georgia', 'times', 'mono'];
        if (in_array($atts['font'] ?? '', $fonts, true)) {
            $q['font'] = $atts['font'];
        }
        foreach (['head', 'frame'] as $key) {
            if (($atts[$key] ?? '') === '0') {
                $q[$key] = 0;
            }
        }
        return $q;
    }

    /**
     * Calculator list (spec/embed.md, section 1): cache for 12 hours, the last good copy when the service is down.
     *
     * @param string $lang
     * @return array|null
     */
    private static function catalog($lang) {
        global $CFG;
        if (array_key_exists($lang, self::$catalogs)) {
            return self::$catalogs[$lang];
        }
        $base = self::base();
        $key = $lang . '_' . md5($base);
        $cache = \cache::make('filter_microcalc', 'catalog');
        $data = $cache->get($key);
        if (is_array($data)) {
            return self::$catalogs[$lang] = $data;
        }

        require_once($CFG->libdir . '/filelib.php');
        $curl = new \curl();
        $body = $curl->get($base . 'calc/widget_catalog.php', ['v' => self::VERSION, 'lang' => $lang], ['CURLOPT_TIMEOUT' => 10]);
        $info = $curl->get_info();
        $fresh = (!$curl->get_errno() && (int)($info['http_code'] ?? 0) === 200) ? self::validate(json_decode((string)$body, true), $base) : null;

        $stale = \cache::make('filter_microcalc', 'catalogstale');
        if ($fresh) {
            $cache->set($key, $fresh);
            $stale->set($key, $fresh);
            return self::$catalogs[$lang] = $fresh;
        }
        $old = $stale->get($key);
        return self::$catalogs[$lang] = is_array($old) ? $old : null;
    }

    /**
     * Catalog addresses must lead to the configured service.
     *
     * @param mixed $data
     * @param string $base
     * @return array|null
     */
    private static function validate($data, $base) {
        if (!is_array($data) || (int)($data['version'] ?? 0) !== self::VERSION || empty($data['items'])) {
            return null;
        }
        $starts = function($url) use ($base) {
            return is_string($url) && strpos($url, $base) === 0;
        };
        if (!$starts($data['site']['script'] ?? '')) {
            return null;
        }
        $items = [];
        foreach ($data['items'] as $item) {
            if (isset($item['id'], $item['name']) && $starts($item['page_url'] ?? '') && $starts($item['widget_src'] ?? '')) {
                $items[] = [
                    'id' => (int)$item['id'],
                    'name' => strip_tags((string)$item['name']),
                    'page_url' => (string)$item['page_url'],
                    'widget_src' => (string)$item['widget_src'],
                ];
            }
        }
        return [
            'site' => ['name' => strip_tags((string)($data['site']['name'] ?? '')), 'script' => (string)$data['site']['script']],
            'items' => $items,
        ];
    }

    /**
     * Hint only for those who can edit the course; students see nothing.
     *
     * @param string $text
     * @param \context $context
     * @return string
     */
    private static function notice($text, $context) {
        if (!$context || !has_capability('moodle/course:manageactivities', $context)) {
            return '';
        }
        return '<p style="border:1px dashed #ca3120;padding:8px 12px;color:#ca3120">' . s($text) . '</p>';
    }
}
