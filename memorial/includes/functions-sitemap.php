<?php
/**
 * Navigation map for the public Memorial website.
 */

defined('ABSPATH') || exit;

const MEMORIAL_SITEMAP_TEMPLATE = 'template-sitemap.php';

add_action('after_setup_theme', function () {
    register_nav_menu('memorial-sitemap-extra', __('Links adicionais do mapa do site', 'memorial'));
});

/**
 * Strings ship in all portal languages. Polylang can override the Portuguese
 * source strings through its String translations screen.
 */
function memorial_sitemap_strings() {
    return array(
        'title' => array(
            'pt' => __('Mapa do site', 'memorial'),
            'es' => __('Mapa del sitio', 'memorial'),
            'en' => __('Sitemap', 'memorial'),
        ),
        'intro' => array(
            'pt' => __('Encontre as principais páginas e seções do Memorial por área de navegação.', 'memorial'),
            'es' => __('Encuentre las principales páginas y secciones del Memorial por área de navegación.', 'memorial'),
            'en' => __('Find the Memorial’s main pages and sections by navigation area.', 'memorial'),
        ),
        'home' => array(
            'pt' => __('Página inicial', 'memorial'),
            'es' => __('Página de inicio', 'memorial'),
            'en' => __('Home', 'memorial'),
        ),
        'breadcrumb' => array(
            'pt' => __('Caminho de navegação', 'memorial'),
            'es' => __('Ruta de navegación', 'memorial'),
            'en' => __('Breadcrumb', 'memorial'),
        ),
    );
}

add_action('init', function () {
    if (function_exists('pll_register_string')) {
        foreach (memorial_sitemap_strings() as $key => $translations) {
            pll_register_string('memorial-sitemap-' . $key, $translations['pt'], 'Memorial — Mapa do site');
        }
    }
});

function memorial_sitemap_text($key) {
    $strings = memorial_sitemap_strings();
    $language = function_exists('pll_current_language') ? pll_current_language('slug') : '';
    $source = $strings[$key]['pt'];
    if ($language && function_exists('pll_translate_string')) {
        $translated = pll_translate_string($source, $language);
        if ($translated && $translated !== $source) {
            return $translated;
        }
    }
    if (!$language) {
        $language = substr(get_locale(), 0, 2);
    }
    return $strings[$key][$language] ?? $source;
}

function memorial_sitemap_home_url() {
    $url = function_exists('pll_home_url') ? pll_home_url() : '';
    return $url ?: home_url('/');
}

function memorial_sitemap_url() {
    static $resolved = array();
    $language = function_exists('pll_current_language') ? pll_current_language('slug') : '';
    $key = $language ?: '';
    if (isset($resolved[$key])) {
        return $resolved[$key];
    }
    // An active plugin with no resolved language must not link to another locale.
    if (!$language && function_exists('pll_current_language')) {
        return $resolved[$key] = '';
    }

    $args = array(
        'post_type'              => 'page',
        'post_status'            => 'publish',
        'has_password'           => false,
        'meta_key'               => '_wp_page_template',
        'meta_value'             => MEMORIAL_SITEMAP_TEMPLATE,
        'posts_per_page'         => 2,
        'update_post_term_cache' => false,
        'suppress_filters'       => false,
    );
    if ($language) {
        $args['lang'] = $language;
    }
    $pages = get_posts($args);
    if (count($pages) !== 1 || ($language && (
        !function_exists('pll_get_post_language') || pll_get_post_language($pages[0]->ID) !== $language
    ))) {
        // Unconfigured or ambiguous. Do not select an arbitrary page.
        return $resolved[$key] = '';
    }
    return $resolved[$key] = (string) get_permalink($pages[0]);
}

/**
 * Ignore the scheme, fragments and trailing slash for deduplication.
 * Preserve the query string because plain WordPress permalinks use it.
 */
function memorial_sitemap_url_key($url) {
    $parts = wp_parse_url($url);
    if (!$parts || empty($parts['host'])) {
        return '';
    }
    return strtolower($parts['host']) . (isset($parts['port']) ? ':' . $parts['port'] : '')
        . untrailingslashit($parts['path'] ?? '/')
        . (empty($parts['query']) ? '' : '?' . $parts['query']);
}

function memorial_sitemap_item_link($item, $archives, $language) {
    $label = $item->title;
    if ($item->type === 'taxonomy' && $item->object === 'category') {
        if ($language && (!function_exists('pll_get_term_language') || pll_get_term_language($item->object_id) !== $language)) {
            return null;
        }
        $term = get_term($item->object_id, 'category');
        $url = $term && !is_wp_error($term) ? get_term_link($term) : '';
        return $url && !is_wp_error($url) ? array($term->name, $url) : null;
    }
    if ($item->type === 'post_type_archive' && isset($archives[$item->object])) {
        return array($label, $archives[$item->object]);
    }

    $page_id = 0;
    if ($item->type === 'post_type' && $item->object === 'page') {
        $page_id = (int) $item->object_id;
    } elseif ($item->type === 'custom') {
        $url = trim($item->url);
        if (in_array($url, array('', '#', '#!'), true)) {
            return array($label, '');
        }

        $key = memorial_sitemap_url_key($url);
        foreach ($archives as $archive) {
            if ($key && $key === memorial_sitemap_url_key($archive)) {
                return array($label, $archive);
            }
        }
        // Some menus store the Home placeholder as an absolute URL.
        $home_key = memorial_sitemap_url_key(memorial_sitemap_home_url());
        if ($key && $key === $home_key) {
            return array($label, substr($url, -2) === '#!' ? '' : memorial_sitemap_home_url());
        }
        // Accept only the configured bibliographic search entry point, never its records.
        $bvs = esc_url_raw(get_option('memorial_bvs_base_url', ''), array('http', 'https'));
        $bvs_key = memorial_sitemap_url_key($bvs);
        if ($key && $bvs_key && $key === $bvs_key) {
            return array($label, $language ? add_query_arg('lang', $language, $bvs) : $bvs);
        }
        // Resolve local custom URLs to actual pages before including them.
        $page_id = url_to_postid($url);
    }
    if (!$page_id) {
        return null;
    }
    $page = get_post($page_id);
    if (!$page || $page->post_type !== 'page' || $page->post_status !== 'publish'
        || $page->post_password !== '' || get_page_template_slug($page) === MEMORIAL_SITEMAP_TEMPLATE
        || ($language && (!function_exists('pll_get_post_language') || pll_get_post_language($page_id) !== $language))
    ) {
        return null;
    }

    return array(get_the_title($page), get_permalink($page));
}

/**
 * Retain menu order and nesting. When the same link appears more than once,
 * keep the first link and retain the later entry only if it has children.
 */
function memorial_sitemap_branch($by_parent, $parent, $archives, $language, &$seen) {
    $branch = array();
    foreach ($by_parent[$parent] ?? array() as $item) {
        if (!empty($item->_invalid) || in_array('sitemap-exclude', (array) $item->classes, true)) {
            continue;
        }
        $link = memorial_sitemap_item_link($item, $archives, $language);
        if (!$link) {
            continue;
        }
        list($label, $url) = $link;
        $key = memorial_sitemap_url_key($url);
        if ($key && isset($seen[$key])) {
            $url = '';
        } elseif ($key) {
            $seen[$key] = true;
        }
        $children = memorial_sitemap_branch($by_parent, (int) $item->ID, $archives, $language, $seen);
        if ($label && ($url || $children)) {
            $branch[] = array('label' => $label, 'url' => $url, 'children' => $children);
        }
    }
    return $branch;
}

/**
 * Core can return the default-language URL for a post type archive.
 * Rebase only links under the WordPress home onto the Polylang home.
 */
function memorial_sitemap_archive_url($type, $language) {
    $url = get_post_type_archive_link($type);
    if (!$url || !$language) {
        return $url;
    }
    if (!function_exists('pll_home_url') || !function_exists('pll_is_translated_post_type')
        || !pll_is_translated_post_type($type)
    ) {
        return '';
    }

    $target_home = pll_home_url($language);
    $archive = wp_parse_url($url);
    $target = wp_parse_url($target_home);
    if (empty($archive['host']) || empty($target['host'])) {
        return '';
    }

    $path = trailingslashit($archive['path'] ?? '/');
    $site_home = get_option('home');
    $default_home = function_exists('pll_default_language')
        ? pll_home_url(pll_default_language()) : $site_home;
    foreach (array($target_home, $default_home, $site_home) as $home) {
        $base = wp_parse_url($home);
        $prefix = trailingslashit($base['path'] ?? '/');
        if (strcasecmp($archive['host'], $base['host'] ?? '') !== 0 || strpos($path, $prefix) !== 0) {
            continue;
        }
        $relative_path = substr($path, strlen($prefix));
        $destination = trailingslashit(explode('?', $target_home, 2)[0]) . $relative_path;
        if (!empty($target['query'])) {
            wp_parse_str($target['query'], $target_query);
            $destination = add_query_arg($target_query, $destination);
        }
        if (!empty($archive['query'])) {
            wp_parse_str($archive['query'], $query);
            unset($query['lang']);
            $destination = add_query_arg($query, $destination);
        }
        return $destination;
    }

    return '';
}

function memorial_sitemap_tree() {
    $home = memorial_sitemap_home_url();
    $tree = array(array('label' => memorial_sitemap_text('home'), 'url' => $home, 'children' => array()));
    $seen = array(memorial_sitemap_url_key($home) => true);
    $language = function_exists('pll_current_language') ? pll_current_language('slug') : '';
    if (!$language && (function_exists('pll_current_language') || !memorial_sitemap_url())) {
        return $tree;
    }

    $archives = array();
    // These theme post types have public index pages. Their individual items
    // and the Tainacan records are intentionally outside the navigation map.
    foreach (array('colecoes', 'aspas') as $type) {
        $archive = memorial_sitemap_archive_url($type, $language);
        if ($archive) {
            $archives[$type] = $archive;
        }
    }

    // Polylang resolves the registered menu locations for the current language.
    $locations = get_nav_menu_locations();
    foreach (array('main-nav', 'memorial-sitemap-extra') as $location) {
        if (empty($locations[$location])) {
            continue;
        }
        $by_parent = array();
        foreach (wp_get_nav_menu_items($locations[$location]) ?: array() as $item) {
            $by_parent[(int) $item->menu_item_parent][] = $item;
        }
        $tree = array_merge($tree, memorial_sitemap_branch($by_parent, 0, $archives, $language, $seen));
    }
    return $tree;
}

function memorial_sitemap_render($nodes, $root = false) {
    if (!$nodes) {
        return;
    }
    ?>
    <ul<?php if ($root) : ?> class="row list-unstyled mb-0"<?php endif; ?>>
        <?php foreach ($nodes as $node) : ?>
            <li<?php if ($root) : ?> class="col-12 col-md-6 col-lg-4 mb-3"<?php endif; ?>>
                <?php if ($root) : ?><h2 class="h5 mb-2"><?php endif; ?>
                <?php if ($node['url']) : ?>
                    <a href="<?php echo esc_url($node['url']); ?>"><?php echo esc_html($node['label']); ?></a>
                <?php else : ?>
                    <span><?php echo esc_html($node['label']); ?></span>
                <?php endif; ?>
                <?php if ($root) : ?></h2><?php endif; ?>
                <?php memorial_sitemap_render($node['children']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
}
