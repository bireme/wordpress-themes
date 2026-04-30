<?php
/**
 * DOBRA: pagina-lilacs_em_dados_e_indicadores
 * Layout ACF: lilacs_em_dados_e_indicadores
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo                = (string) get_sub_field( 'titulo' );
$descricao             = (string) get_sub_field( 'descricao' );
$texto_botao_ver_todos = (string) get_sub_field( 'texto_botao_ver_todos' );
$link_botao_ver_todos  = (string) get_sub_field( 'link_botao_ver_todos' );
$indicadores           = get_sub_field( 'indicadores' );

if ( ! is_array( $indicadores ) ) {
	$indicadores = [];
}

if ( empty( $titulo ) && empty( $descricao ) && empty( $indicadores ) ) {
	return;
}

$uid = 'lilacs-indicadores-' . wp_unique_id();

/**
 * Ícone fallback (SVG)
 */
function lilacs_indicadores_fallback_svg() {
	return '
	<svg width="34" height="34" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
		<path d="M4 19h16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		<path d="M7 16V10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		<path d="M12 16V6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		<path d="M17 16v-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
	</svg>';
}
?>

<section class="lilacs-em-dados" id="<?php echo esc_attr( $uid ); ?>">
	<div class="lilacs-em-dados__container">

		<div class="lilacs-em-dados__header">
			<?php if ( ! empty( $titulo ) ) : ?>
				<h2 class="lilacs-em-dados__title"><?php echo esc_html( $titulo ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $descricao ) ) : ?>
				<div class="lilacs-em-dados__desc"><?php echo wp_kses_post( nl2br( esc_html( $descricao ) ) ); ?></div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $indicadores ) ) : ?>
			<div class="lilacs-em-dados__grid" role="list" aria-label="<?php echo esc_attr( $titulo ?: 'Indicadores' ); ?>">
				<?php foreach ( $indicadores as $item ) :

					$titulo_indicador    = (string) ( $item['titulo_do_indicador'] ?? '' );
					$descricao_indicador = (string) ( $item['descricao_do_indicador'] ?? '' );
					$link_indicador      = (string) ( $item['link_do_indicador'] ?? '' );
					$tags_indicador      = (string) ( $item['tags_do_indicador'] ?? '' );
					$imagemicone         = (string) ( $item['imagemicone'] ?? '' );
					$cor_do_fundo        = (string) ( $item['cor_do_fundo'] ?? '' );

					if ( empty( $titulo_indicador ) && empty( $descricao_indicador ) && empty( $imagemicone ) ) {
						continue;
					}

					$tag           = ! empty( $link_indicador ) ? 'a' : 'div';
					$card_classes  = 'lilacs-em-dados__card' . ( ! empty( $link_indicador ) ? ' is-link' : '' );
					$card_style    = ! empty( $cor_do_fundo ) ? ' style="background:' . esc_attr( $cor_do_fundo ) . ';"' : '';
					$card_attrs    = ! empty( $link_indicador )
						? 'href="' . esc_url( $link_indicador ) . '" class="' . esc_attr( $card_classes ) . '" role="listitem"' . $card_style
						: 'class="' . esc_attr( $card_classes ) . '" role="listitem"' . $card_style;
				?>
					<<?php echo $tag; ?> <?php echo $card_attrs; ?>>

						<div class="lilacs-em-dados__icon-wrap">
							<span class="lilacs-em-dados__icon" aria-hidden="true">
								<?php if ( ! empty( $imagemicone ) ) : ?>
									<img src="<?php echo esc_url( $imagemicone ); ?>" alt="" loading="lazy">
								<?php else : ?>
									<?php echo lilacs_indicadores_fallback_svg(); ?>
								<?php endif; ?>
							</span>
						</div>

						<div class="lilacs-em-dados__content">
							<?php if ( ! empty( $titulo_indicador ) ) : ?>
								<h3 class="lilacs-em-dados__card-title"><?php echo esc_html( $titulo_indicador ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $descricao_indicador ) ) : ?>
								<div class="lilacs-em-dados__card-desc">
									<?php echo wp_kses_post( $descricao_indicador ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $tags_indicador ) ) : ?>
								<div class="lilacs-em-dados__tags">
									<?php echo esc_html( $tags_indicador ); ?>
								</div>
							<?php endif; ?>
						</div>

					</<?php echo $tag; ?>>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $texto_botao_ver_todos ) ) : ?>
			<div class="lilacs-em-dados__footer">
				<?php if ( ! empty( $link_botao_ver_todos ) ) : ?>
					<a class="lilacs-em-dados__all-btn" href="<?php echo esc_url( $link_botao_ver_todos ); ?>">
						<?php echo esc_html( $texto_botao_ver_todos ); ?>
					</a>
				<?php else : ?>
					<span class="lilacs-em-dados__all-btn">
						<?php echo esc_html( $texto_botao_ver_todos ); ?>
					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
</section>

<style>
#<?php echo esc_attr( $uid ); ?>.lilacs-em-dados{
	width:100%;
	padding:75px 0 75px;
	background:#f3f3f3;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__container{
	width:min(1200px, calc(100% - 32px));
	margin:0 auto;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__header{
	margin-bottom:42px;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__title{
	margin:0 0 8px;
	font-family:'Noto Sans', sans-serif;
	font-size:36px;
	line-height:1.15;
	font-weight:700;
	color:#0B2C68;
	letter-spacing:-0.02em;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__desc{
	margin:0;
	font-family:'Noto Sans', sans-serif;
	font-size:18px;
	line-height:1.4;
	font-weight:400;
	color:#284B7A;
	max-width:100%;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__grid{
	display:grid;
	grid-template-columns:repeat(4, minmax(0, 1fr));
	gap:12px;
	align-items:stretch;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__card{
	position:relative;
	display:flex;
	flex-direction:column;
	align-items:center;
	justify-content:flex-start;
	min-height:118px;
	padding:80px 12px 16px;
	border-radius:6px;
	box-shadow:0 8px 18px rgba(8, 42, 83, .10);
	text-decoration:none;
	color:#fff;
	transition:transform .15s ease, box-shadow .15s ease, filter .15s ease;
	overflow:visible;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__card.is-link:hover{
	transform:translateY(-2px);
	box-shadow:0 14px 30px rgba(8, 42, 83, .16);
	filter:brightness(1.02);
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__icon-wrap{
	position:absolute;
	top:-28px;
	left:50%;
	transform:translateX(-50%);
	width:75px;
	height:75px;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__icon{
	width:75px;
	height:75px;
	border-radius:999px;
	background:#fff;
	box-shadow:0 4px 10px rgba(0,0,0,.12);
	display:flex;
	align-items:center;
	justify-content:center;
	color:#4f46b8;
	overflow:hidden;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__icon img{
	width:28px;
	height:28px;
	object-fit:contain;
	display:block;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__content{
	display:flex;
	flex-direction:column;
	align-items:center;
	justify-content:center;
	text-align:center;
	width:100%;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__card-title{
margin: 0;
    font-family: 'Noto Sans', sans-serif;
    font-size: 24px;
    font-weight: 400;
    line-height: 115.99%;
    color: #fff;
    max-width: 100%;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__card-desc{
	display:none;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__card-desc p{
	margin:0;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__tags{
	margin-top:2px;
	font-family:'Noto Sans', sans-serif;
	font-size:12px;
	line-height:1.15;
	font-weight:700;
	color:#ffe600;
	text-align:center;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__footer{
	display:flex;
	justify-content:center;
	margin-top:28px;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__all-btn{
	display:inline-flex;
	align-items:center;
	justify-content:center;
	min-width:240px;
	height:48px;
	padding:0 36px;
	border-radius:999px;
	background:#F97316;
	color:#fff;
	font-family:'Noto Sans', sans-serif;
	font-size:16px;
	font-weight:700;
	line-height:1;
	text-decoration:none;
	box-shadow:none;
}

#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__all-btn:hover{
	filter:brightness(1.03);
}

@media (max-width: 900px){
	#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__grid{
		grid-template-columns:repeat(2, minmax(0, 1fr));
	}
}

@media (max-width: 520px){
	#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados{
		padding:28px 0 32px;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__container{
		width:min(100%, calc(100% - 24px));
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__grid{
		grid-template-columns:1fr;
		gap:38px;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-em-dados__header{
		margin-bottom:34px;
	}
}
</style>