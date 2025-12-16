<?php
/**
 * Dobra: Próximas Capacitações (RSS)
 * Slug: pagina-proximas_sessoes_rss
 *
 * OBS: Este arquivo é uma DOBRA (sem header/footer).
 */

if ( ! defined('ABSPATH') ) exit;

/**
 * Título via ACF
 */
$titulo = get_sub_field('titulo');

/**
 * CONFIG
 */
$rss_url       = 'https://red.bvsalud.org/eventos-rede-BVS/events-feed?q=&filter=descriptor%3A%22LILACS%22';
$cache_key     = 'lilacs_proximas_sessoes_rss_v1';
$cache_seconds = 15 * MINUTE_IN_SECONDS;
$max_cards     = 6;

/**
 * Helpers
 */
function lilacs_rss_ddmmyyyy_to_ts( $date_str ) {
	if ( preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $date_str, $m) ) {
		return strtotime("{$m[3]}-{$m[2]}-{$m[1]}");
	}
	return 0;
}

function lilacs_rss_parse_desc( $desc ) {
	$raw = trim( wp_strip_all_tags( (string)$desc ) );

	$out = [
		'raw'      => $raw,
		'start'    => '',
		'end'      => '',
		'place'    => '',
		'start_ts' => 0,
	];

	if ( preg_match('/(\d{2}\/\d{2}\/\d{4})\s*-\s*(\d{2}\/\d{2}\/\d{4})/', $raw, $m) ) {
		$out['start']    = $m[1];
		$out['end']      = $m[2];
		$out['start_ts'] = lilacs_rss_ddmmyyyy_to_ts($m[1]);
	}

	if ( strpos($raw, '.') !== false ) {
		$parts = explode('.', $raw, 2);
		$out['place'] = trim($parts[1]);
	}

	return $out;
}

/**
 * Fetch + cache
 */
$items = get_transient($cache_key);

if ( false === $items ) {
	$items = [];

	$response = wp_remote_get($rss_url, ['timeout' => 12]);

	if ( ! is_wp_error($response) ) {
		$body = wp_remote_retrieve_body($response);
		if ( $body ) {
			libxml_use_internal_errors(true);
			$xml = simplexml_load_string($body);

			if ( $xml && isset($xml->channel->item) ) {
				foreach ( $xml->channel->item as $it ) {
					$meta = lilacs_rss_parse_desc((string)$it->description);
					$items[] = [
						'title'    => (string)$it->title,
						'link'     => (string)$it->link,
						'start'    => $meta['start'],
						'end'      => $meta['end'],
						'place'    => $meta['place'],
						'start_ts' => $meta['start_ts'],
					];
				}
			}
			libxml_clear_errors();
		}
	}
	set_transient($cache_key, $items, $cache_seconds);
}

/**
 * Futuros ordenados
 */
$today_ts = strtotime( wp_date('Y-m-d') );

$futuros = array_filter($items, fn($e) => !empty($e['start_ts']) && $e['start_ts'] >= $today_ts);
usort($futuros, fn($a,$b) => $a['start_ts'] <=> $b['start_ts']);
?>

<section id="cap-proximas-sessoes">
<style>
#cap-proximas-sessoes{
	background:#fff;
	padding:10px 0 26px;
	font-family:"Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
}
.cap-wrap{max-width:1180px;margin:0 auto;}
.cap-title{text-align:center;font-size:26px;font-weight:800;color:#163b72;margin-bottom:43px;}

.cap-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.cap-card{
	background:#fff;border:1px solid #e6edf8;border-radius:12px;
	padding:18px;box-shadow:0 10px 24px rgba(12,49,116,.06);
	display:flex;flex-direction:column;justify-content:space-between;
}
.cap-card h3{font-size:16px;font-weight:800;color:#163b72;margin-bottom:12px;}

.cap-badges{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;}
.cap-badge{
	font-size:12px;font-weight:700;padding:4px 10px;border-radius:999px;
}
.cap-badge-date{background:#e8f0ff;color:#2a57ad;}
.cap-badge-place{background:#f1f5f9;color:#4f5b75;}

.cap-btn{
	align-self:center;margin-top:auto;
	padding:9px 14px;border-radius:8px;
	font-size:14px;font-weight:800;
	color:#2a57ad;background:#fff;
	border:2px solid rgba(51,102,204,.30);
	text-decoration:none;
}
.cap-btn:hover{background:#f3f7ff;border-color:rgba(51,102,204,.55);}
@media(max-width:980px){.cap-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.cap-grid{grid-template-columns:1fr;}}
</style>

<div class="cap-wrap">
	<h2 class="cap-title"><?php echo esc_html($titulo ?: 'Próximas Capacitações'); ?></h2>

	<div class="cap-grid">
	<?php foreach($futuros as $ev): ?>
		<article class="cap-card">
			<h3><?php echo esc_html($ev['title']); ?></h3>

			<div class="cap-badges">
				<?php if($ev['start']): ?>
					<span class="cap-badge cap-badge-date">
						<?php echo esc_html($ev['start'] . ($ev['end'] ? ' – '.$ev['end'] : '')); ?>
					</span>
				<?php endif; ?>
				<?php if($ev['place']): ?>
					<span class="cap-badge cap-badge-place">
						<?php echo esc_html($ev['place']); ?>
					</span>
				<?php endif; ?>
			</div>

			<a class="cap-btn" href="<?php echo esc_url($ev['link']); ?>">
				<?php esc_html_e('Inscreva-se','lilacs'); ?>
			</a>
		</article>
	<?php endforeach; ?>
	</div>
</div>
</section>
