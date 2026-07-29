<?php
/**
 * Dobra: RSS Multimídia / Sessões
 * Slug: pagina-proximas_sessoes_rss
 *
 * Campos ACF: titulo, rss_link, rss_max_itens
 * Feed padrão: https://lilacs.bvsalud.org/multimedia/multimedia-feed?q=&filter=LILACS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$default_rss = 'https://lilacs.bvsalud.org/multimedia/multimedia-feed?q=&filter=LILACS';

$titulo   = function_exists( 'get_sub_field' ) ? (string) get_sub_field( 'titulo' ) : '';
$rss_link = function_exists( 'get_sub_field' ) ? (string) get_sub_field( 'rss_link' ) : '';
$rss_max  = function_exists( 'get_sub_field' ) ? (int) get_sub_field( 'rss_max_itens' ) : 6;

if ( $titulo === '' ) {
	$titulo = __( 'Multimídia LILACS', 'lilacs' );
}
if ( $rss_link === '' ) {
	$rss_link = $default_rss;
}
if ( $rss_max < 1 ) {
	$rss_max = 6;
}

$cache_key     = 'lilacs_proximas_sessoes_rss_' . md5( $rss_link . '|' . $rss_max );
$cache_seconds = 15 * MINUTE_IN_SECONDS;

$items = get_transient( $cache_key );

if ( false === $items || ! is_array( $items ) ) {
	$items    = [];
	$response = wp_remote_get(
		$rss_link,
		[
			'timeout' => 12,
			'headers' => [
				'Accept' => 'application/rss+xml, application/xml, text/xml, */*;q=0.1',
			],
		]
	);

	if ( ! is_wp_error( $response ) ) {
		$body = wp_remote_retrieve_body( $response );
		if ( $body ) {
			libxml_use_internal_errors( true );
			$xml = simplexml_load_string( $body );

			if ( $xml && isset( $xml->channel->item ) ) {
				$count = 0;
				foreach ( $xml->channel->item as $it ) {
					if ( $count >= $rss_max ) {
						break;
					}

					$title = trim( (string) $it->title );
					$link  = trim( (string) $it->link );
					$desc  = trim( wp_strip_all_tags( (string) $it->description ) );

					if ( $title === '' && $link === '' ) {
						continue;
					}

					$items[] = [
						'title'       => $title,
						'link'        => $link,
						'description' => $desc,
					];
					$count++;
				}
			}
			libxml_clear_errors();
		}
	}

	set_transient( $cache_key, $items, $cache_seconds );
}
?>

<section id="cap-proximas-sessoes" class="cap-rss" aria-label="<?php echo esc_attr( $titulo ); ?>">
<style>
#cap-proximas-sessoes{
	background:#fff;
	padding:10px 0 26px;
	font-family:"Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
}
.cap-wrap{max-width:1180px;margin:0 auto;padding:0 16px;}
.cap-title{text-align:center;font-size:26px;font-weight:800;color:#163b72;margin-bottom:43px;}

.cap-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.cap-card{
	background:#fff;border:1px solid #e6edf8;border-radius:12px;
	padding:18px;box-shadow:0 10px 24px rgba(12,49,116,.06);
	display:flex;flex-direction:column;justify-content:space-between;
	gap:12px;
}
.cap-card h3{font-size:16px;font-weight:800;color:#163b72;margin:0;}
.cap-card h3 a{color:inherit;text-decoration:none;}
.cap-card h3 a:hover{text-decoration:underline;}
.cap-card p{
	margin:0;
	font-size:14px;
	line-height:1.45;
	color:#4f5b75;
	display:-webkit-box;
	-webkit-line-clamp:4;
	-webkit-box-orient:vertical;
	overflow:hidden;
}

.cap-btn{
	align-self:flex-start;margin-top:auto;
	padding:9px 14px;border-radius:8px;
	font-size:14px;font-weight:800;
	color:#2a57ad;background:#fff;
	border:2px solid rgba(51,102,204,.30);
	text-decoration:none;
}
.cap-btn:hover{background:#f3f7ff;border-color:rgba(51,102,204,.55);}
.cap-rss-empty{
	text-align:center;
	color:#4f5b75;
	padding:24px 12px;
	border:1px dashed #d5e0f2;
	border-radius:12px;
}
@media(max-width:980px){.cap-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.cap-grid{grid-template-columns:1fr;}}
</style>

<div class="cap-wrap">
	<h2 class="cap-title"><?php echo esc_html( $titulo ); ?></h2>

	<?php if ( ! empty( $items ) ) : ?>
		<div class="cap-grid">
			<?php foreach ( $items as $ev ) :
				$item_title = (string) ( $ev['title'] ?? '' );
				$item_link  = (string) ( $ev['link'] ?? '' );
				$item_desc  = (string) ( $ev['description'] ?? '' );
				if ( $item_title === '' ) {
					continue;
				}
				?>
				<article class="cap-card">
					<h3>
						<?php if ( $item_link !== '' ) : ?>
							<a href="<?php echo esc_url( $item_link ); ?>" target="_blank" rel="noopener">
								<?php echo esc_html( $item_title ); ?>
							</a>
						<?php else : ?>
							<?php echo esc_html( $item_title ); ?>
						<?php endif; ?>
					</h3>

					<?php if ( $item_desc !== '' ) : ?>
						<p><?php echo esc_html( $item_desc ); ?></p>
					<?php endif; ?>

					<?php if ( $item_link !== '' ) : ?>
						<a class="cap-btn" href="<?php echo esc_url( $item_link ); ?>" target="_blank" rel="noopener">
							<?php esc_html_e( 'Assistir / Acessar', 'lilacs' ); ?> →
						</a>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<div class="cap-rss-empty">
			<?php esc_html_e( 'Não foi possível carregar os itens do feed multimídia no momento.', 'lilacs' ); ?>
		</div>
	<?php endif; ?>
</div>
</section>
