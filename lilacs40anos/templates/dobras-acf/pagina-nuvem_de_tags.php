<?php
/**
 * DOBRA: Nuvem de tags
 * Slug: pagina-nuvem_de_tags.php
 *
 * Campos ACF:
 * - titulo
 * - descricao (wysiwyg)
 * - tags (repeater): texto, tamanho, link
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titulo    = (string) lilacs_fc_get_sub( array( 'field_nuvem_tags_titulo', 'titulo' ) );
$descricao = (string) lilacs_fc_get_sub( array( 'field_nuvem_tags_desc', 'descricao' ) );
$tags      = lilacs_fc_get_repeater(
	array(
		'field_nuvem_tags_items',
		'tags',
	)
);

$items = array();
foreach ( $tags as $row ) {
	if ( ! is_array( $row ) ) {
		continue;
	}
	$texto = trim( (string) ( $row['texto'] ?? $row['field_nuvem_tag_texto'] ?? '' ) );
	if ( $texto === '' ) {
		continue;
	}
	$tamanho = (string) ( $row['tamanho'] ?? $row['field_nuvem_tag_tamanho'] ?? 'media' );
	if ( ! in_array( $tamanho, array( 'pequena', 'media', 'grande' ), true ) ) {
		$tamanho = 'media';
	}
	$items[] = array(
		'texto'   => $texto,
		'tamanho' => $tamanho,
		'link'    => trim( (string) ( $row['link'] ?? $row['field_nuvem_tag_link'] ?? '' ) ),
	);
}

if ( $titulo === '' && $descricao === '' && empty( $items ) ) {
	return;
}

$uid = 'lilacs-nuvem-tags-' . (int) get_the_ID() . '-' . ( function_exists( 'get_row_index' ) ? (int) get_row_index() : 0 );

static $lilacs_nuvem_tags_css_printed = false;
?>

<section class="lilacs-nuvem-tags" id="<?php echo esc_attr( $uid ); ?>"<?php echo $titulo !== '' ? ' aria-labelledby="' . esc_attr( $uid ) . '-title"' : ''; ?>>
	<div class="lilacs-nuvem-tags__container">
		<?php if ( $titulo !== '' ) : ?>
			<h2 class="lilacs-nuvem-tags__heading" id="<?php echo esc_attr( $uid ); ?>-title"><?php echo esc_html( $titulo ); ?></h2>
		<?php endif; ?>

		<?php if ( $descricao !== '' ) : ?>
			<div class="lilacs-nuvem-tags__desc"><?php echo wp_kses_post( $descricao ); ?></div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="lilacs-nuvem-tags__cloud">
				<?php foreach ( $items as $item ) :
					$classes = 'lilacs-nuvem-tags__pill is-' . $item['tamanho'];
					$is_link = $item['link'] !== '';
				?>
					<?php if ( $is_link ) : ?>
						<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo esc_url( $item['link'] ); ?>">
							<?php echo esc_html( $item['texto'] ); ?>
						</a>
					<?php else : ?>
						<span class="<?php echo esc_attr( $classes ); ?>">
							<?php echo esc_html( $item['texto'] ); ?>
						</span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! $lilacs_nuvem_tags_css_printed ) :
	$lilacs_nuvem_tags_css_printed = true;
	?>
	<style>
		.lilacs-nuvem-tags{
			--navy:#0C4380;
			--navy-900:#082A53;
			--text:#3D4F63;
			padding: 40px 20px 52px;
			background: #fff;
			font-family: "Noto Sans", system-ui, sans-serif;
		}
		.lilacs-nuvem-tags__container{
			max-width: 1180px;
			margin: 0 auto;
		}
		.lilacs-nuvem-tags__heading{
			margin: 0 0 16px;
			color: var(--navy);
			font-size: clamp(22px, 2.4vw, 32px);
			line-height: 1.2;
			font-weight: 800;
			letter-spacing: -0.3px;
		}
		.lilacs-nuvem-tags__desc{
			max-width: 78ch;
			margin: 0 0 22px;
			color: var(--text);
			font-size: 15px;
			line-height: 1.65;
		}
		.lilacs-nuvem-tags__desc p{
			margin: 0 0 12px;
		}
		.lilacs-nuvem-tags__desc p:last-child{
			margin-bottom: 0;
		}
		.lilacs-nuvem-tags__cloud{
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			gap: 10px 12px;
			padding: 28px 22px;
			background: #F4F7FB;
			border-radius: 18px;
			box-shadow: 0 10px 28px rgba(12, 67, 128, 0.06);
			box-sizing: border-box;
		}
		.lilacs-nuvem-tags__pill{
			display: inline-flex;
			align-items: center;
			padding: 7px 16px;
			border-radius: 999px;
			background: #fff;
			color: var(--navy);
			text-decoration: none;
			box-shadow: 0 2px 8px rgba(12, 67, 128, 0.06);
			line-height: 1.2;
			white-space: nowrap;
		}
		a.lilacs-nuvem-tags__pill:hover{
			transform: translateY(-1px);
			box-shadow: 0 6px 14px rgba(12, 67, 128, 0.12);
		}
		.lilacs-nuvem-tags__pill.is-pequena{
			font-size: 13px;
			font-weight: 500;
			color: #4A6580;
			padding: 6px 14px;
		}
		.lilacs-nuvem-tags__pill.is-media{
			font-size: 16px;
			font-weight: 700;
		}
		.lilacs-nuvem-tags__pill.is-grande{
			font-size: 22px;
			font-weight: 800;
			color: var(--navy-900);
			padding: 8px 20px;
		}
		@media (max-width: 700px){
			.lilacs-nuvem-tags{ padding: 28px 16px 40px; }
			.lilacs-nuvem-tags__cloud{ padding: 18px 14px; gap: 8px; }
			.lilacs-nuvem-tags__pill.is-grande{ font-size: 18px; }
		}
	</style>
<?php endif; ?>
