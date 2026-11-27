<?php
defined('ABSPATH') || exit;

/** Editorial labels; page names, destinations and excerpts come from WordPress. */
function memorial_sitemap_copy($key) {
    $copy = array(
        'intro' => array('Encontre seu caminho pelo Memorial', 'Encuentre su camino por el Memorial', 'Find your way around the Memorial'),
        'search' => array('Buscar páginas e seções no mapa', 'Buscar páginas y secciones en el mapa', 'Search pages and sections in the sitemap'),
        'clear' => array('Limpar', 'Borrar', 'Clear'),
        'guidance' => array('Consulte a estrutura do portal ou busque diretamente pela página que deseja acessar.', 'Consulte la estructura del portal o busque directamente la página a la que desea acceder.', 'Browse the portal structure or search directly for the page you want to visit.'),
        'placeholder' => array('Buscar páginas e seções...', 'Buscar páginas y secciones...', 'Search pages and sections...'),
        'learn' => array('Conheça o Memorial', 'Conozca el Memorial', 'Learn about the Memorial'),
        'summary' => array(
            'O Memorial acolhe, preserva e dá acesso a registros da pandemia de COVID-19 e seus desdobramentos, reconhecendo a memória coletiva como fonte de aprendizado, justiça e cidadania.',
            'El Memorial reúne, preserva y facilita el acceso a los registros de la pandemia de COVID-19 y sus consecuencias. Reconoce la memoria colectiva como fuente de aprendizaje, justicia y ciudadanía.',
            'The Memorial collects, preserves and provides access to records of the COVID-19 pandemic and its aftermath. It recognizes collective memory as a source of learning, justice and civic participation.'
        ),
        'navigation' => array('Navegação do portal', 'Navegación del portal', 'Explore the portal'),
        'empty' => array('Nenhuma página ou seção encontrada.', 'No se encontraron páginas ni secciones.', 'No pages or sections found.'),
        'found' => array('Resultados da busca atualizados.', 'Resultados de búsqueda actualizados.', 'Search results updated.'),
        'about' => array('Sobre o Memorial', 'Acerca del Memorial', 'About the Memorial'),
        'help' => array('Precisa de ajuda?', '¿Necesita ayuda?', 'Need help?'),
        'contact' => array('Entre em contato com a equipe do Memorial.', 'Póngase en contacto con el equipo del Memorial.', 'Contact the Memorial team.'),
        'support' => array('Orientação e atalhos', 'Orientación y accesos directos', 'Guidance and shortcuts'),
    );
    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : substr(get_locale(), 0, 2);
    $index = array('pt' => 0, 'es' => 1, 'en' => 2);
    return $copy[$key][$index[$lang] ?? 0];
}

function memorial_sitemap_icon($type) {
    $paths = array(
        'close' => 'm4 4 8 8m0-8-8 8',
        'arrow' => 'm4 12 8-8M6 4h6v6',
        'search' => 'M11 11l3 3M12 7a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z',
    );
    printf('<svg class="sitemap-icon" aria-hidden="true" focusable="false" width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="%s"/></svg>', esc_attr($paths[$type]));
}

function memorial_sitemap_link_index($nodes) {
    $links = array();
    foreach ($nodes as $node) {
        if ($node['url']) {
            $links[memorial_sitemap_url_key($node['url'])] = $node;
        }
        $links += memorial_sitemap_link_index($node['children']);
    }
    return $links;
}

function memorial_sitemap_support($tree) {
    $links = memorial_sitemap_link_index($tree);
    $language = function_exists('pll_current_language') ? pll_current_language('slug') : '';
    $targets = array();
    // Stable source slugs, independent of the environment and database IDs.
    foreach (array('about' => 'sobre-o-memorial', 'exhibition' => 'exposicoes', 'contact' => 'contato-e-suporte') as $role => $slug) {
        $source = get_page_by_path($slug);
        if (!$source) {
            continue;
        }
        $id = $language && function_exists('pll_get_post') ? pll_get_post($source->ID, $language) : $source->ID;
        if ($id) {
            $key = memorial_sitemap_url_key(get_permalink($id));
            if (isset($links[$key])) {
                $targets[$role] = $links[$key];
                $targets[$role]['id'] = $id;
            }
        }
    }
    if (!isset($targets['about']) && !isset($targets['contact'])) {
        return;
    }
    ?>
    <aside class="sitemap-support" aria-label="<?php echo esc_attr(memorial_sitemap_copy('support')); ?>">
        <?php if (isset($targets['about'])) : ?>
            <section>
                <h2><?php echo esc_html(memorial_sitemap_copy('about')); ?></h2>
                <?php
                $image_id = get_post_thumbnail_id(get_queried_object_id())
                    ?: get_post_thumbnail_id($targets['about']['id'])
                    ?: (isset($targets['exhibition']) ? get_post_thumbnail_id($targets['exhibition']['id']) : 0);
                if ($image_id && wp_attachment_is_image($image_id)) {
                    echo wp_get_attachment_image($image_id, 'large', array('class' => 'sitemap-support__image'));
                }
                ?>
                <p><?php echo esc_html(memorial_sitemap_copy('summary')); ?></p>
                <?php memorial_sitemap_support_link($targets['about'], memorial_sitemap_copy('learn')); ?>
            </section>
        <?php endif; ?>
        <?php if (isset($targets['contact'])) : ?>
            <section>
                <h2><?php echo esc_html(memorial_sitemap_copy('help')); ?></h2>
                <p><?php echo esc_html(memorial_sitemap_copy('contact')); ?></p>
                <?php memorial_sitemap_support_link($targets['contact'], $targets['contact']['label']); ?>
            </section>
        <?php endif; ?>
    </aside>
    <?php
}

function memorial_sitemap_support_link($node, $label) {
    ?>
    <a href="<?php echo esc_url($node['url']); ?>">
        <?php echo esc_html($label); ?>
        <?php memorial_sitemap_icon('arrow'); ?>
    </a>
    <?php
}
