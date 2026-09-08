<?php
/**
 * DOBRA: Etapas (passo a passo)
 * Slug: pagina-etapas_step_by_step.php
 *
 * Campos ACF:
 * - titulo
 * - etapas (repeater): icone, titulo, descricao
 * O número da etapa é gerado automaticamente pela ordem do repeater.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titulo = (string) get_sub_field( 'titulo' );
$etapas = get_sub_field( 'etapas' );

if ( ! is_array( $etapas ) || empty( $etapas ) ) {
	return;
}

$uid = 'lilacs-etapas-' . get_the_ID() . '-' . get_row_index();

if ( ! function_exists( 'lilacs_etapas_icon_url' ) ) {
	/**
	 * Extrai URL de um campo de imagem ACF.
	 *
	 * @param mixed $icon Campo image (array, URL ou ID).
	 * @return string
	 */
	function lilacs_etapas_icon_url( $icon ) {
		if ( is_array( $icon ) ) {
			return (string) ( $icon['url'] ?? '' );
		}
		if ( is_numeric( $icon ) ) {
			return (string) wp_get_attachment_image_url( (int) $icon, 'thumbnail' );
		}
		if ( is_string( $icon ) ) {
			return $icon;
		}
		return '';
	}
}

$items = [];
foreach ( $etapas as $row ) {
	if ( ! is_array( $row ) ) {
		continue;
	}
	$title = trim( (string) ( $row['titulo'] ?? '' ) );
	$desc  = trim( (string) ( $row['descricao'] ?? '' ) );
	$icon  = lilacs_etapas_icon_url( $row['icone'] ?? null );
	if ( $title === '' && $desc === '' && $icon === '' ) {
		continue;
	}
	$items[] = [
		'titulo'    => $title,
		'descricao' => $desc,
		'icone'     => $icon,
	];
}

if ( empty( $items ) ) {
	return;
}

static $lilacs_etapas_css_printed = false;
$count = count( $items );
?>

<section class="lilacs-etapas" id="<?php echo esc_attr( $uid ); ?>"<?php echo $titulo !== '' ? ' aria-labelledby="' . esc_attr( $uid ) . '-title"' : ''; ?>>
	<div class="lilacs-etapas__container">
		<?php if ( $titulo !== '' ) : ?>
			<h2 class="lilacs-etapas__heading" id="<?php echo esc_attr( $uid ); ?>-title"><?php echo esc_html( $titulo ); ?></h2>
		<?php endif; ?>

		<ol class="lilacs-etapas__box" style="--etapas-count: <?php echo (int) $count; ?>;">
			<?php foreach ( $items as $i => $item ) : ?>
				<li class="lilacs-etapas__step">
					<div class="lilacs-etapas__head">
						<span class="lilacs-etapas__num" aria-hidden="true"><?php echo (int) ( $i + 1 ); ?></span>
						<?php if ( $item['titulo'] !== '' ) : ?>
							<h3 class="lilacs-etapas__title"><?php echo esc_html( $item['titulo'] ); ?></h3>
						<?php endif; ?>
					</div>
					<div class="lilacs-etapas__body">
						<?php if ( $item['icone'] !== '' ) : ?>
							<span class="lilacs-etapas__icon" aria-hidden="true">
								<img src="<?php echo esc_url( $item['icone'] ); ?>" alt="">
							</span>
						<?php endif; ?>
						<?php if ( $item['descricao'] !== '' ) : ?>
							<p class="lilacs-etapas__desc"><?php echo esc_html( $item['descricao'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<?php if ( ! $lilacs_etapas_css_printed ) :
	$lilacs_etapas_css_printed = true;
	?>
	<style>
		.lilacs-etapas{
			--navy:#0C4380;
			--navy-900:#082A53;
			padding: 36px 20px 48px;
			background: #fff;
			font-family: "Noto Sans", system-ui, sans-serif;
		}
		.lilacs-etapas__container{
			max-width: 1180px;
			margin: 0 auto;
		}
		.lilacs-etapas__heading{
			margin: 0 0 18px;
			color: var(--navy);
			font-size: clamp(20px, 2.2vw, 28px);
			line-height: 1.25;
			font-weight: 800;
			letter-spacing: -0.2px;
		}
		.lilacs-etapas__box{
			list-style: none;
			margin: 0;
			padding: 22px 20px 20px;
			display: grid;
			grid-template-columns: repeat(var(--etapas-count, 4), minmax(0, 1fr));
			gap: 0;
			background: #fff;
			border: 1px solid #E6EEF6;
			border-radius: 16px;
			box-shadow: 0 8px 24px rgba(12, 67, 128, 0.05);
			box-sizing: border-box;
		}
		.lilacs-etapas__step{
			position: relative;
			padding: 0 28px 0 8px;
			min-width: 0;
		}
		.lilacs-etapas__step:not(:last-child)::after{
			content: "→";
			position: absolute;
			top: 2px;
			right: 4px;
			color: var(--navy);
			font-size: 18px;
			font-weight: 700;
			line-height: 1;
			pointer-events: none;
		}
		.lilacs-etapas__head{
			display: flex;
			align-items: center;
			gap: 8px;
			margin: 0 0 10px;
		}
		.lilacs-etapas__num{
			flex: 0 0 22px;
			width: 22px;
			height: 22px;
			border-radius: 50%;
			background: var(--navy);
			color: #fff;
			font-size: 12px;
			font-weight: 800;
			line-height: 22px;
			text-align: center;
		}
		.lilacs-etapas__title{
			margin: 0;
			color: var(--navy-900);
			font-size: 15px;
			line-height: 1.2;
			font-weight: 800;
		}
		.lilacs-etapas__body{
			display: flex;
			align-items: flex-start;
			gap: 10px;
		}
		.lilacs-etapas__icon{
			flex: 0 0 28px;
			width: 28px;
			height: 28px;
			margin-top: 1px;
		}
		.lilacs-etapas__icon img{
			width: 100%;
			height: 100%;
			object-fit: contain;
		}
		.lilacs-etapas__desc{
			margin: 0;
			color: var(--navy);
			font-size: 13px;
			line-height: 1.45;
			font-weight: 400;
		}
		@media (max-width: 980px){
			.lilacs-etapas__box{
				grid-template-columns: 1fr 1fr;
				row-gap: 22px;
			}
			.lilacs-etapas__step:nth-child(2n)::after{ content: none; }
		}
		@media (max-width: 640px){
			.lilacs-etapas{ padding: 28px 16px 36px; }
			.lilacs-etapas__box{
				grid-template-columns: 1fr;
				padding: 18px 16px;
				row-gap: 18px;
			}
			.lilacs-etapas__step{
				padding: 0 0 18px;
			}
			.lilacs-etapas__step:not(:last-child){
				border-bottom: 1px solid #E6EEF6;
			}
			.lilacs-etapas__step::after{ content: none !important; }
		}
	</style>
<?php endif; ?>
