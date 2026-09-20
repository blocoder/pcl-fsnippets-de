<?php
/**
 * Plugin Name:       PC’L Übersetzungen für FluentSnippets
 * Plugin URI:        https://github.com/blocoder/pcl-fsnippets-de
 * Update URI:        https://github.com/blocoder/pcl-fsnippets-de
 * Description:       Liefert die deutsche Übersetzung für FluentSnippets aus, in beiden Anreden (de_DE und de_DE_formal). Lädt sie vor allen anderen Katalogen und hält fremde deutsche Fassungen fern. Zeigt relative Zeiten in der Verwaltung deutsch an („vor 4 Tagen“). Der Katalog wird nur geladen, wenn FluentSnippets installiert ist.
 * Version:           1.2.1
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Author:            Peter Claus Lamprecht (PC’L)
 * Author URI:        https://barmbek-nerd.de/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pcl-fluentsnippets-de
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

// German relative times in the admin list, since 1.1.0.
require_once __DIR__ . '/relative-zeit-de.php';

/* -------------------------------------------------------------------------
 * Updates from GitHub (since 1.2.0)
 * ---------------------------------------------------------------------- */

/**
 * Same approach as pcl-fluent-de: a bundled copy of plugin-update-checker
 * (5.7, MIT, Janis Elsts) reads the latest release of the public repo, takes
 * the version from the tag (`v1.2.0` -> `1.2.0`) and installs the attached
 * ZIP. Pre-releases are skipped.
 *
 * Why a library and not the core route (`Update URI` plus the filter
 * `update_plugins_github.com`, WordPress 5.8+): someone has to hook into that
 * filter on every installation, and some of them have neither SSH nor
 * WP-CLI. A plugin that brings its own updates saves the FTP session there.
 *
 * The `Update URI` header stays anyway: without it WordPress asks
 * wordpress.org about every plugin and would offer a foreign update if a
 * plugin with the folder name `pcl-fluentsnippets-de` ever appeared there.
 *
 * The public repo is called `pcl-fsnippets-de`, the plugin folder stays
 * `pcl-fluentsnippets-de` (decision PC'L, 17.09.2026). The library gets the
 * slug separately, so the two names do not have to match.
 *
 * No signature or checksum check: WordPress only verifies downloads from
 * wordpress.org (`wp_signature_hosts`). What protects the package is HTTPS
 * and GitHub, as in pcl-fluent-de.
 */
require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

add_action('init', function () {
    // Not earlier: the library prints translated messages, and WordPress
    // 6.7+ complains about every load_textdomain() before init.
    $pruefer = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/blocoder/pcl-fsnippets-de/',
        __FILE__,
        'pcl-fluentsnippets-de'
    );

    // Without this the library downloads the source tarball: the .po files
    // but none of the .mo and .l10n.php that only package.sh builds. An
    // update from it would be an installation without translation.
    $pruefer->getVcsApi()->enableReleaseAssets('/\.zip($|[?&#])/i');
});

/**
 * Why this plugin?
 *
 * Same approach as `pcl-fluentcrm-de`, `pcl-fluent-de` and
 * `pcl-fluentcart-de`: the catalogues live in this plugin, are loaded on
 * `plugins_loaded` with priority 1 and therefore win against any later file
 * of the same text domain. WP_Translation_Controller takes the first file
 * that knows a string.
 *
 * FluentSnippets (folder and text domain `easy-code-manager`) ships only a
 * template, no German catalogue, and wordpress.org has no German language
 * pack (measured 17.09.2026 under 10.56). Its own
 * `load_plugin_textdomain('easy-code-manager', false, 'fluent-snippets/language')`
 * points at a folder that does not exist under that name and loads nothing.
 *
 * Three things to know:
 *
 * 1. Foreign German catalogues are kept away. None exists today, but a
 *    language pack can arrive with any update. It would fill every gap of
 *    this catalogue with a wording nobody reviewed.
 *
 * 2. `pcl-fluent-de` up to 1.5.3 blocks `easy-code-manager` (filter
 *    `pcl_fluent_de/blocked_domains`). This plugin removes its domain from
 *    that list while active. From 1.6.0 on the block is gone and the filter
 *    is never asked.
 *
 * 3. The snippet `pcl-textdomains-englisch` (retired on 17.09.2026) kept
 *    `easy-code-manager` English by default and skipped every domain for
 *    which an active `pcl-*` plugin ships a `.mo` in its `languages/`
 *    folder. The plugin list still reports it, should it come back.
 *
 * Two forms of address as in the sister plugins: `determine_locale()` yields
 * `de_DE` or `de_DE_formal`, the file name is built from it. If the file for
 * the locale is missing, nothing is loaded rather than falling back to the
 * other form.
 */

/**
 * The text domains this plugin ships catalogues for.
 *
 * Key is the text domain, value the folder below wp-content/plugins/. Both
 * are `easy-code-manager` for FluentSnippets; the map keeps the shape of the
 * sister plugins.
 */
function pcl_fluentsnippets_de_domains() {
    return apply_filters('pcl_fluentsnippets_de/domains', array(
        'easy-code-manager' => 'easy-code-manager',
    ));
}

/**
 * Normalises the domain map. A filter may return a plain list; then the key is
 * numeric and domain equals folder.
 */
function pcl_fluentsnippets_de_domain_map() {
    $map = array();
    foreach (pcl_fluentsnippets_de_domains() as $domain => $slug) {
        $map[is_int($domain) ? $slug : $domain] = $slug;
    }
    return $map;
}

function pcl_fluentsnippets_de_languages_dir() {
    return plugin_dir_path(__FILE__) . 'languages/';
}

/**
 * Loads our catalogues before anyone else asks for them.
 *
 * @param string $locale Optional. Empty means the current locale. On
 *                       `change_locale` WordPress passes the new one.
 */
function pcl_fluentsnippets_de_load($locale = '') {
    $locale = $locale ? $locale : determine_locale();
    $dir    = pcl_fluentsnippets_de_languages_dir();

    foreach (pcl_fluentsnippets_de_domain_map() as $domain => $slug) {
        // No catalogue for a plugin that is not there.
        if (!is_dir(WP_PLUGIN_DIR . '/' . $slug)) {
            continue;
        }

        $eigen = $dir . $domain . '-' . $locale . '.mo';

        if (!is_readable($eigen)) {
            continue;
        }

        // load_textdomain() instead of load_plugin_textdomain(): the latter
        // would look into WP_LANG_DIR first and restore exactly the order this
        // plugin exists to avoid.
        load_textdomain($domain, $eigen, $locale);
    }
}
add_action('plugins_loaded', 'pcl_fluentsnippets_de_load', 1);

/**
 * And again when WordPress switches the language mid-request.
 *
 * On a switch WordPress drops the loaded catalogues and reloads them, but only
 * from WP_LANG_DIR and the plugin's own Domain Path. Our languages/ folder is
 * neither; without this hook FluentSnippets would fall back to English after
 * `switch_to_locale()` (measured in the FluentCart project, 03.08.2026).
 */
add_action('change_locale', 'pcl_fluentsnippets_de_load', 1);

/**
 * Lift the block in `pcl-fluent-de` up to 1.5.3 for our domain.
 *
 * Stays as long as installations with an older version may run. From 1.6.0
 * on the filter is never applied and costs nothing.
 * The filter is asked on every load attempt, so being registered when this
 * file is included is early enough.
 */
function pcl_fluentsnippets_de_unblock($blocked) {
    if (!is_array($blocked)) {
        return $blocked;
    }
    return array_values(array_diff($blocked, array_keys(pcl_fluentsnippets_de_domain_map())));
}
add_filter('pcl_fluent_de/blocked_domains', 'pcl_fluentsnippets_de_unblock', 20);

/**
 * Do not let foreign German catalogues load for our domains.
 *
 * load_textdomain() asks this filter before reading. `true` means "handled":
 * the file is not read. Only files of our domains are hit whose name is a
 * German locale and that do not come from our languages/ folder - a language
 * pack in WP_LANG_DIR, Loco's folder, a future file in FluentSnippets'
 * language/. Other languages stay untouched.
 *
 * Priority 1 as in the sister plugins: a late `true` would come too late if
 * another callback in the filter already loads the file itself.
 *
 * Can be switched off via `pcl_fluentsnippets_de/keep_foreign_german`.
 */
function pcl_fluentsnippets_de_block_foreign($override, $domain, $mofile = '') {
    if ($override || !$mofile) {
        return $override;
    }

    $map = pcl_fluentsnippets_de_domain_map();
    if (!isset($map[$domain])) {
        return $override;
    }

    $name = basename($mofile);
    if (strpos($name, $domain . '-de_') !== 0) {
        return $override;
    }

    $eigen = wp_normalize_path(pcl_fluentsnippets_de_languages_dir());
    if (strpos(wp_normalize_path($mofile), $eigen) === 0) {
        return $override;
    }

    if (apply_filters('pcl_fluentsnippets_de/keep_foreign_german', false, $domain, $mofile)) {
        return $override;
    }

    return true;
}
add_filter('override_load_textdomain', 'pcl_fluentsnippets_de_block_foreign', 1, 3);

/* -------------------------------------------------------------------------
 * Quellcode-Installation erkennen
 * ---------------------------------------------------------------------- */

/**
 * Stammt dieses Plugin aus dem Quellcode-Archiv statt aus dem Release?
 *
 * Im Repo stehen nur die `.po`; `.mo` und `.l10n.php` entstehen beim Bauen und
 * liegen allein im Release-Archiv. Wer auf der Repo-Startseite „Code → Download
 * ZIP“ nimmt, bekommt deshalb ein Plugin, das vollständig aussieht – der Ordner
 * `languages/` ist ja gefüllt – und trotzdem nichts übersetzt. Von außen ist
 * das nicht zu sehen; gemeldet von einem Nutzer am 20.09.2026, bei drei von
 * vier Plugins auf einmal.
 *
 * Erkennungszeichen ist der Ordner als Ganzes, nicht die Datei zur aktuellen
 * Locale: mindestens eine `.po`, aber kein einziger gebauter Katalog. Eine
 * fehlende Datei zu genau einer Locale ist etwas anderes und hat ihren eigenen
 * Hinweis.
 *
 * Kein `glob()`: Eckige Klammern im Installationspfad wären dort ein Muster.
 */
function pcl_fluentsnippets_de_quellinstallation() {
    static $ergebnis = null;

    if (null !== $ergebnis) {
        return $ergebnis;
    }

    $ergebnis = false;
    $dir      = pcl_fluentsnippets_de_languages_dir();

    if (!is_dir($dir)) {
        return $ergebnis;
    }

    $dateien = scandir($dir);

    if (!$dateien) {
        return $ergebnis;
    }

    $po = false;

    foreach ($dateien as $datei) {
        if (substr($datei, -3) === '.mo' || substr($datei, -9) === '.l10n.php') {
            return $ergebnis;
        }
        if (substr($datei, -3) === '.po') {
            $po = true;
        }
    }

    $ergebnis = $po;

    return $ergebnis;
}

/**
 * Der Link auf die Releases, aus denen das fertige Paket kommt.
 */
function pcl_fluentsnippets_de_release_link() {
    return sprintf(
        '<a href="https://github.com/blocoder/pcl-fsnippets-de/releases/latest" target="_blank" rel="noopener">%s</a>',
        esc_html__('Releases', 'pcl-fluentsnippets-de')
    );
}

/**
 * Hinweis im Backend, solange die gebauten Kataloge fehlen.
 *
 * Auf jeder Seite der Verwaltung und ohne Wegklicken: Das Plugin tut in diesem
 * Zustand gar nichts, und wer es installiert hat, merkt das sonst erst, wenn
 * ihm die englische Oberfläche auffällt. Zu sehen bekommt den Hinweis nur, wer
 * Plugins aktualisieren darf – alle anderen können ohnehin nichts ausrichten.
 */
function pcl_fluentsnippets_de_quellinstallation_hinweis() {
    if (!current_user_can('update_plugins') || !pcl_fluentsnippets_de_quellinstallation()) {
        return;
    }

    printf(
        '<div class="notice notice-warning"><p>%s</p></div>',
        wp_kses(
            sprintf(
                /* translators: %s: link to the releases page */
                __('<strong>PC’L Übersetzungen für FluentSnippets:</strong> Die gebauten Kataloge fehlen, das Plugin übersetzt deshalb nichts. Es stammt offenbar aus dem Quellcode-Archiv von GitHub („Code → Download ZIP“); darin stehen nur die Ausgangsdateien. Bitte das ZIP aus den %s herunterladen und unter Plugins → Installieren → Plugin hochladen darüberspielen.', 'pcl-fluentsnippets-de'),
                pcl_fluentsnippets_de_release_link()
            ),
            array(
                'strong' => array(),
                'a'      => array('href' => array(), 'target' => array(), 'rel' => array()),
            )
        )
    );
}
add_action('admin_notices', 'pcl_fluentsnippets_de_quellinstallation_hinweis');

/**
 * Note in the plugin list which catalogues actually apply.
 *
 * With two forms of address a file name that does not match the locale is the
 * most likely mistake, and invisible from outside otherwise.
 */
function pcl_fluentsnippets_de_row_meta($links, $file) {
    if (plugin_basename(__FILE__) !== $file) {
        return $links;
    }

    // Fehlt der ganze Satz gebauter Kataloge, ist die Locale nicht die
    // Ursache. Dann hilft nur der Hinweis auf das Release-Archiv.
    if (pcl_fluentsnippets_de_quellinstallation()) {
        $links[] = sprintf(
            /* translators: %s: link to the releases page */
            __('Kompilierte Kataloge fehlen – aus dem Quellcode-Archiv installiert, bitte das ZIP aus den %s einspielen', 'pcl-fluentsnippets-de'),
            pcl_fluentsnippets_de_release_link()
        );

        return $links;
    }

    $locale  = determine_locale();
    $dir     = pcl_fluentsnippets_de_languages_dir();
    $geladen = array();
    $fehlend = array();

    foreach (pcl_fluentsnippets_de_domain_map() as $domain => $slug) {
        if (!is_dir(WP_PLUGIN_DIR . '/' . $slug)) {
            continue;
        }
        if (is_readable($dir . $domain . '-' . $locale . '.mo')) {
            $geladen[] = $domain;
        } else {
            $fehlend[] = $domain;
        }
    }

    $links[] = $geladen
        ? sprintf(
            /* translators: 1: locale, 2: comma separated list of text domains */
            esc_html__('Aktiv für %1$s: %2$s', 'pcl-fluentsnippets-de'),
            esc_html($locale),
            esc_html(implode(', ', $geladen))
        )
        : sprintf(
            /* translators: %s: locale */
            esc_html__('Keine Kataloge für %s gefunden', 'pcl-fluentsnippets-de'),
            esc_html($locale)
        );

    if ($fehlend) {
        $links[] = sprintf(
            /* translators: 1: comma separated list of text domains, 2: locale */
            esc_html__('Installiert, aber ohne Katalog: %1$s (keine Datei für %2$s)', 'pcl-fluentsnippets-de'),
            esc_html(implode(', ', $fehlend)),
            esc_html($locale)
        );
    }

    $gesperrt = array();
    if (function_exists('pcl_fluent_de_blocked_domains')) {
        $gesperrt = array_intersect(pcl_fluent_de_blocked_domains(), array_keys(pcl_fluentsnippets_de_domain_map()));
    }
    if (function_exists('pcl_textdomains_englisch')) {
        $gesperrt = array_merge($gesperrt, array_intersect(pcl_textdomains_englisch(), array_keys(pcl_fluentsnippets_de_domain_map())));
    }
    if ($gesperrt) {
        $links[] = sprintf(
            /* translators: %s: comma separated list of text domains */
            esc_html__('Achtung: Eine Sperre hält weiterhin %s englisch', 'pcl-fluentsnippets-de'),
            esc_html(implode(', ', array_unique($gesperrt)))
        );
    }

    return $links;
}
add_filter('plugin_row_meta', 'pcl_fluentsnippets_de_row_meta', 10, 2);
