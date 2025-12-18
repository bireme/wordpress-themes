<?php 
if (!defined('ABSPATH')) exit;

// Campos da layout "reunioes"
$titulo     = get_sub_field('titulo');
$descricao  = get_sub_field('descricao');
$rss_url    = get_sub_field('url_do_rss');
$modo       = get_sub_field('modo_'); // checkbox (array ou string)
$modo_array = is_array($modo) ? $modo : ( $modo ? array($modo) : array() );
$is_manual  = in_array('Manual', $modo_array, true);

define('BVS_RSS_USER', 'admin-tst');
define('BVS_RSS_PASS', 'bireme123');

// Limites / cache
$rss_limit        = 3;
$rss_cache_secs   = 0 * MINUTE_IN_SECONDS;

/**
 * Lê RSS e retorna array padronizado:
 * [
 *   ['title' => '...', 'link' => '...', 'desc' => '...'],
 * ]
 */
function bvs_reunioes_get_rss_items($rss_url, $limit = 3, $cache_secs = 600, &$debug_out = '') {
    $items = [];
    $debug = [];

    $rss_url = trim((string)$rss_url);
    if (empty($rss_url)) {
        $debug[] = 'rss_url empty';
        $debug_out = implode(' | ', $debug);
        return $items;
    }

    $cache_key = 'bvs_reunioes_rss_' . md5($rss_url . '|' . (int)$limit);
    $cached = get_transient($cache_key);
    if (is_array($cached)) {
        $debug[] = 'cache hit';
        $debug_out = implode(' | ', $debug);
        return $cached;
    }

    // 1) Tenta wp_remote_get (mais previsível)
  $auth = '';
if (defined('BVS_RSS_USER') && defined('BVS_RSS_PASS') && BVS_RSS_USER && BVS_RSS_PASS) {
    $auth = 'Basic ' . base64_encode(BVS_RSS_USER . ':' . BVS_RSS_PASS);
}

$resp = wp_remote_get($rss_url, [
    'timeout'   => 15,
    'sslverify' => false, // staging; em produção prefira true
    'headers'   => array_filter([
        'Accept'        => 'application/rss+xml, application/xml, text/xml;q=0.9,*/*;q=0.8',
        'User-Agent'    => 'WordPress/' . get_bloginfo('version') . '; ' . home_url('/'),
        'Authorization' => $auth, // <- AQUI
    ]),
]);


    if (is_wp_error($resp)) {
        $debug[] = 'wp_remote_get wp_error: ' . $resp->get_error_message();
    } else {
        $code = (int) wp_remote_retrieve_response_code($resp);
        $debug[] = 'wp_remote_get code=' . $code;

        $body = wp_remote_retrieve_body($resp);
        $debug[] = 'body_len=' . strlen((string)$body);

        if ($code >= 200 && $code < 300 && !empty($body)) {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($body);

            if (!$xml) {
                $debug[] = 'simplexml_load_string failed';
            } else {
                // RSS 2.0 típico: <rss><channel><item>...</item></channel></rss>
                $rss_items = [];
                if (!empty($xml->channel->item)) {
                    $rss_items = $xml->channel->item;
                } elseif (!empty($xml->entry)) {
                    // caso Atom
                    $rss_items = $xml->entry;
                }

                $count = 0;
                foreach ($rss_items as $it) {
                    // RSS
                    $title = isset($it->title) ? (string)$it->title : '';
                    $link  = isset($it->link)  ? (string)$it->link  : '';
                    $desc  = isset($it->description) ? (string)$it->description : '';

                    // Atom fallback
                    if (empty($link) && isset($it->link)) {
                        // Atom: <link href="..."/>
                        $attrs = $it->link->attributes();
                        if (!empty($attrs['href'])) $link = (string)$attrs['href'];
                    }
                    if (empty($desc) && isset($it->summary)) {
                        $desc = (string)$it->summary;
                    }

                    $items[] = [
                        'title' => wp_strip_all_tags($title),
                        'link'  => esc_url_raw($link),
                        'desc'  => wp_strip_all_tags($desc),
                    ];

                    $count++;
                    if ($count >= (int)$limit) break;
                }

                $debug[] = 'parsed_items=' . count($items);
            }
        }
    }

    // 2) Se não conseguiu, tenta fetch_feed (SimplePie)
    if (empty($items) && function_exists('fetch_feed')) {
        include_once ABSPATH . WPINC . '/feed.php';
        $feed = fetch_feed($rss_url);

        if (is_wp_error($feed)) {
            $debug[] = 'fetch_feed wp_error: ' . $feed->get_error_message();
        } else {
            $max = (int) $feed->get_item_quantity((int)$limit);
            $rss_items = $feed->get_items(0, $max);
            foreach ($rss_items as $it) {
                $items[] = [
                    'title' => wp_strip_all_tags((string)$it->get_title()),
                    'link'  => esc_url_raw((string)$it->get_link()),
                    'desc'  => wp_strip_all_tags((string)$it->get_description()),
                ];
            }
            $debug[] = 'fetch_feed_items=' . count($items);
        }
    }

    // Cacheia mesmo vazio por pouco tempo (evita bater toda hora)
    set_transient($cache_key, $items, (int)$cache_secs);

    $debug_out = implode(' | ', $debug);
    return $items;
}
?>
<style>
/* REUNIÕES */

.home-reunioes {
    padding: 40px 0;
    background: #F1F1F1;
}

.home-reunioes-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px 30px;
}

/* Header */
.home-reunioes-header {
    margin-bottom: 24px;
}

.home-reunioes-header h2 {
    font-size: 32px;
    color: #003c71;
    margin: 0 0 6px;
    font-weight: 700;
}

.home-reunioes-header p {
    margin: 0;
    max-width: 100%;
    font-size: 16px;
    color: #28367D;
}

/* Cards */
.home-reunioes-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.reuniao-card {
    flex: 1 1 calc(33.333% - 20px);
    min-width: 260px;
}

.reuniao-card-inner {
background: #ffffff;
    border-radius: 10px 30px 10px 10px;
    padding: 18px 22px;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.02);
    min-height: 133px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.reuniao-card-title {
    font-size: 16px;
    font-weight: 600;
    color: #28367D;
    line-height: 1.5;
    margin: 0 0 8px;
}

.reuniao-card-meta {
    font-size: 11px;
    color: #777;
    margin: 0;
}

/* Footer com botão Ver todos */
.home-reunioes-footer {
    margin-top: 20px;
    text-align: right;
}

.home-reunioes-ver-todos {
    display: inline-block;
    padding: 8px 45px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
}

/* Responsivo */
@media (max-width: 768px) {
    .reuniao-card {
        flex: 1 1 100%;
    }
}
</style>

<section class="home-reunioes">
    <div class="home-reunioes-inner">

        <header class="home-reunioes-header">
            <?php if ($titulo): ?>
                <h2><?php echo esc_html($titulo); ?></h2>
            <?php endif; ?>

            <?php if ($descricao): ?>
                <p><?php echo esc_html($descricao); ?></p>
            <?php endif; ?>
        </header>

        <?php if ( $is_manual && have_rows('url_do_rss_copiar') ) : ?>

            <div class="home-reunioes-cards">
                <?php while ( have_rows('url_do_rss_copiar') ) : the_row();
                    $titulo_card = get_sub_field('titulo');
                    $linha_inf   = get_sub_field('linha_inferior');
                    $linha_link   = get_sub_field('link_do_rss');
                ?>
                    <article class="reuniao-card">
                        <a style="text-decoration:none;" href="<?php echo esc_url($linha_link); ?>">
                        <div class="reuniao-card-inner">
                            <?php if ( $titulo_card ) : ?>
                                <h3 class="reuniao-card-title">
                                    <?php echo esc_html( $titulo_card ); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ( $linha_inf ) : ?>
                                <p class="reuniao-card-meta">
                                    <?php echo esc_html( $linha_inf ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="home-reunioes-footer">
                <a href="<?php echo esc_url($rss_url); ?>" class="home-reunioes-ver-todos">
                    Ver todos
                </a>
            </div>

        <?php else : ?>

            <?php
            global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_bvs_reunioes_rss_%'");

                $debug_rss = '';
                $rss_items = bvs_reunioes_get_rss_items($rss_url, $rss_limit, $rss_cache_secs, $debug_rss);
                // debug fica no view-source:
                echo "\n<!-- REUNIOES_RSS_DEBUG: " . esc_html($debug_rss) . " -->\n";
            ?>

            <?php if (!empty($rss_items)) : ?>

                <div class="home-reunioes-cards">
                    <?php foreach ($rss_items as $it) : 
                        $titulo_card = $it['title'] ?? '';
                        $linha_inf   = $it['desc'] ?? '';
                        $linha_link  = $it['link'] ?? '';
                    ?>
                        <article class="reuniao-card">
                            <a style="text-decoration:none;" href="<?php echo esc_url($linha_link); ?>">
                                <div class="reuniao-card-inner">
                                    <?php if ($titulo_card) : ?>
                                        <h3 class="reuniao-card-title">
                                            <?php echo esc_html($titulo_card); ?>
                                        </h3>
                                    <?php endif; ?>

                                    <?php if ($linha_inf) : ?>
                                        <p class="reuniao-card-meta">
                                            <?php echo esc_html($linha_inf); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="home-reunioes-footer">
                    <a href="<?php echo esc_url($rss_url); ?>" target="_blank" class="home-reunioes-ver-todos">
                        Ver todos
                    </a>
                </div>

            <?php else : ?>

                <!-- Se cair aqui, o RSS não foi lido/parseado -->
                <?php if ( $rss_url ): ?>
                    <a href="<?php echo esc_url($rss_url); ?>" target="_blank" class="home-reunioes-ver-todos">
                        Ver RSS
                    </a>
                <?php else: ?>
                    <p>Em breve: listagem das últimas reuniões via RSS.</p>
                <?php endif; ?>

            <?php endif; ?>

        <?php endif; ?>

    </div>
</section>
