<?php
/**
 * DOBRA: O que você precisa fazer?
 * Slug: pagina-o_que_voce_precisa_fazer.php
 *
 * Campos ACF:
 * - titulo
 * - precisa_cards (repeater; legado: cards): icone, titulo, descricao, link
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titulo = (string) lilacs_fc_get_sub( array( 'field_precisa_titulo', 'titulo' ) );
$cards  = lilacs_fc_get_repeater(
	array(
		'field_precisa_cards',
		'precisa_cards',
		'cards',
	)
);

if ( empty( $cards ) ) {
	return;
}

$uid = 'lilacs-precisa-' . (int) get_the_ID() . '-' . ( function_exists( 'get_row_index' ) ? (int) get_row_index() : 0 );

static $lilacs_precisa_css_printed = false;
?>

<section class="lilacs-precisa" id="<?php echo esc_attr( $uid ); ?>"<?php echo $titulo !== '' ? ' aria-labelledby="' . esc_attr( $uid ) . '-title"' : ''; ?>>
	<div class="lilacs-precisa__container">
		<?php if ( $titulo !== '' ) : ?>
			<h2 class="lilacs-precisa__heading" id="<?php echo esc_attr( $uid ); ?>-title"><?php echo esc_html( $titulo ); ?></h2>
		<?php endif; ?>

		<div class="lilacs-precisa__grid">
			<?php foreach ( $cards as $card ) :
				if ( ! is_array( $card ) ) {
					continue;
				}

				$c_title = trim( (string) ( $card['titulo'] ?? $card['field_precisa_card_titulo'] ?? '' ) );
				$c_desc  = trim( (string) ( $card['descricao'] ?? $card['field_precisa_card_desc'] ?? '' ) );
				$c_link  = trim( (string) ( $card['link'] ?? $card['field_precisa_card_link'] ?? '' ) );
				$icon    = lilacs_acf_image_url( $card['icone'] ?? $card['field_precisa_card_icone'] ?? null );

				if ( $c_title === '' && $c_desc === '' && $icon === '' ) {
					continue;
				}

				$is_link = $c_link !== '';
			?>
				<?php if ( $is_link ) : ?>
					<a class="lilacs-precisa__card" href="<?php echo esc_url( $c_link ); ?>">
				<?php else : ?>
					<article class="lilacs-precisa__card">
				<?php endif; ?>

					<?php if ( $icon !== '' ) : ?>
						<span class="lilacs-precisa__icon" aria-hidden="true">
							<img src="<?php echo esc_url( $icon ); ?>" alt="">
						</span>
					<?php endif; ?>

					<?php if ( $c_title !== '' ) : ?>
						<h3 class="lilacs-precisa__title"><?php echo esc_html( $c_title ); ?></h3>
					<?php endif; ?>

					<?php if ( $c_desc !== '' ) : ?>
						<p class="lilacs-precisa__desc"><?php echo esc_html( $c_desc ); ?></p>
					<?php endif; ?>

					<?php if ( $is_link ) : ?>
						<span class="lilacs-precisa__arrow" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
					<?php endif; ?>

				<?php if ( $is_link ) : ?>
					</a>
				<?php else : ?>
					</article>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ( ! $lilacs_precisa_css_printed ) :
	$lilacs_precisa_css_printed = true;
	?>
	<style>
		.lilacs-precisa{
			--navy:#0C4380;
			--navy-900:#082A53;
			--purple:#7A3EA8;
			--text:#355472;
			--bg:#F4F7FB;
			padding: 48px 20px 56px;
			background: var(--bg);
			font-family: "Noto Sans", system-ui, sans-serif;
		}
		.lilacs-precisa__container{
			max-width: 1180px;
			margin: 0 auto;
		}
		.lilacs-precisa__heading{
			margin: 0 0 28px;
			text-align: center;
			color: var(--navy);
			font-size: clamp(22px, 2.4vw, 32px);
			line-height: 1.2;
			font-weight: 800;
			letter-spacing: -0.3px;
		}
		.lilacs-precisa__grid{
			display: grid;
			grid-template-columns: repeat(6, minmax(0, 1fr));
			gap: 16px;
			align-items: stretch;
		}
		.lilacs-precisa__card{
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			min-height: 168px;
			padding: 18px 16px 16px;
			background: #fff;
			border-radius: 16px;
			box-shadow: 0 10px 28px rgba(12, 67, 128, 0.08);
			text-decoration: none;
			color: inherit;
			transition: transform .15s ease, box-shadow .15s ease;
			box-sizing: border-box;
		}
		a.lilacs-precisa__card:hover{
			transform: translateY(-3px);
			box-shadow: 0 14px 34px rgba(12, 67, 128, 0.14);
		}
		.lilacs-precisa__icon{
			display: flex;
			width: 36px;
			height: 36px;
			margin-bottom: 12px;
			color: var(--purple);
		}
		.lilacs-precisa__icon img{
			width: 100%;
			height: 100%;
			object-fit: contain;
		}
		.lilacs-precisa__title{
			margin: 0 0 8px;
			color: var(--navy-900);
			font-size: 15px;
			line-height: 1.25;
			font-weight: 800;
		}
		.lilacs-precisa__desc{
			margin: 0;
			color: var(--text);
			font-size: 13px;
			line-height: 1.45;
			font-weight: 400;
		}
		.lilacs-precisa__arrow{
			display: flex;
			margin-top: auto;
			margin-left: auto;
			padding-top: 14px;
			color: var(--purple);
		}
		.lilacs-precisa__arrow svg{
			width: 22px;
			height: 22px;
		}
		@media (max-width: 1100px){
			.lilacs-precisa__grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
		}
		@media (max-width: 700px){
			.lilacs-precisa__grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
			.lilacs-precisa{ padding: 36px 16px 44px; }
		}
		@media (max-width: 420px){
			.lilacs-precisa__grid{ grid-template-columns: 1fr; }
		}
	</style>
<?php endif; ?>
