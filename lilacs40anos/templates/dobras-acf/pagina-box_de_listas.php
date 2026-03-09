<?php
/**
 * Dobra: Box de Listas
 * Arquivo: templates/dobras-acf/pagina-box_de_listas.php
 * Layout ACF esperado:
 * - titulo
 * - boxes (repeater)
 *   - titulo_box
 *   - titulo_box_copiar (repeater)
 *     - titulo_do_link
 *     - link_do_titulo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Campo principal da seção
$titulo = (string) get_sub_field( 'titulo' );
$imagem_de_fundo = get_sub_field( 'imagem_de_fundo_' );

// Repeater principal
$boxes = get_sub_field( 'box' );
if ( ! is_array( $boxes ) ) {
	$boxes = [];
}

// Helpers
$esc  = function( $v ) { return esc_html( (string) $v ); };
$escu = function( $v ) { return esc_url( (string) $v ); };

// ID único da seção para evitar conflito entre dobras
$uid = 'lilacs-boxlistas-' . wp_unique_id();
?>

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-boxlistas" style="background-image: url('<?php echo $imagem_de_fundo; ?>');">
	<div class="lilacs-boxlistas__inner">

		<?php if ( $titulo ) : ?>
			<header class="lilacs-boxlistas__header">
				<h2 class="lilacs-boxlistas__title"><?php echo $esc( $titulo ); ?></h2>
			</header>
		<?php endif; ?>

		<?php if ( ! empty( $boxes ) ) : ?>
			<div class="lilacs-boxlistas__grid">
				<?php foreach ( $boxes as $box ) : 
					$box_titulo = $box['titulo_box'] ?? '';
					$itens      = $box['titulo_box_copiar'] ?? [];
					$itens      = is_array( $itens ) ? $itens : [];
					
					// quebra opcional do título para layout parecido com a referência
					$prefixo = '';
					$titulo_principal = $box_titulo;

					if ( stripos( $box_titulo, 'Para sua ' ) === 0 ) {
						$prefixo = 'Para sua';
						$titulo_principal = trim( str_ireplace( 'Para sua', '', $box_titulo ) );
					}
				?>
					<article class="lilacs-boxlistas__card">
						<?php if ( $box_titulo ) : ?>
							<div class="lilacs-boxlistas__card-head">
								<?php if ( $prefixo ) : ?>
									<div class="lilacs-boxlistas__eyebrow"><?php echo $esc( $prefixo ); ?></div>
								<?php endif; ?>

								<h3 class="lilacs-boxlistas__card-title">
									<?php echo $esc( $titulo_principal ); ?>
								</h3>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $itens ) ) : ?>
							<ul class="lilacs-boxlistas__list">
								<?php foreach ( $itens as $item ) : 
									$item_titulo = $item['titulo_do_link'] ?? '';
									$item_link   = $item['link_do_titulo'] ?? '';
									if ( ! $item_titulo ) continue;
								?>
									<li class="lilacs-boxlistas__item">
										<?php if ( $item_link ) : ?>
											<a class="lilacs-boxlistas__link" href="<?php echo $escu( $item_link ); ?>">
												<span class="lilacs-boxlistas__bullet" aria-hidden="true"></span>
												<span class="lilacs-boxlistas__text"><?php echo $esc( $item_titulo ); ?></span>
											</a>
										<?php else : ?>
											<div class="lilacs-boxlistas__link lilacs-boxlistas__link--nolink">
												<span class="lilacs-boxlistas__bullet" aria-hidden="true"></span>
												<span class="lilacs-boxlistas__text"><?php echo $esc( $item_titulo ); ?></span>
											</div>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</section>

<style>
	#<?php echo esc_attr( $uid ); ?>{
		position: relative;
		padding: 64px 0 72px;
		background:
			radial-gradient(circle at 8% 22%, rgba(30, 94, 255, 0.15) 0%, rgba(30, 94, 255, 0) 20%),
			radial-gradient(circle at 90% 15%, rgba(0, 84, 255, 0.10) 0%, rgba(0, 84, 255, 0) 18%),
			linear-gradient(180deg, #02206F 0%, #001A66 100%);
		overflow: hidden;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__inner{
		width: min(1280px, calc(100% - 64px));
		margin: 0 auto;
		position: relative;
		z-index: 2;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__header{
		margin-bottom: 36px;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__title{
		margin: 0;
		color: #ffffff;
		font-size: clamp(34px, 4vw, 36px);
		line-height: 1.05;
		font-weight: 700;
		letter-spacing: -0.02em;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__grid{
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		gap: 24px;
		align-items: stretch;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__card{
		background: #F3F3F3;
		border-radius: 14px;
		padding: 28px 18px 22px;
		box-shadow: 0 10px 24px rgba(0,0,0,.08);
		min-height: 335px;
		display: flex;
		flex-direction: column;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__card-head{
		margin-bottom: 18px;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__eyebrow{
		margin: 0 0 -4px;
		color: #F36B21;
		font-size: clamp(16px, 1.5vw, 20px);
		line-height: 1;
		font-weight: 700;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__card-title{
		margin: 0;
		color: #F36B21;
		font-size: clamp(30px, 2.4vw, 36px);
		line-height: .95;
		font-weight: 800;
		letter-spacing: -0.02em;
		word-break: break-word;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__list{
		list-style: none;
		margin: 0;
		padding: 0;
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__item{
		margin: 0;
		padding: 0;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__link{
		display: flex;
		align-items: flex-start;
		gap: 10px;
		text-decoration: none;
		color: #2E3D57;
		font-size: clamp(18px, 1.35vw, 21px);
		line-height: 1.45;
		font-weight: 400;
		transition: opacity .2s ease, transform .2s ease, color .2s ease;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__link:hover{
		opacity: .86;
		transform: translateX(2px);
		color: #17315d;
	}

    #<?php echo esc_attr( $uid ); ?> h1, 
    #<?php echo esc_attr( $uid ); ?> h2, 
    #<?php echo esc_attr( $uid ); ?> h3, 
    #<?php echo esc_attr( $uid ); ?> h4, 
    #<?php echo esc_attr( $uid ); ?> h5, 
    #<?php echo esc_attr( $uid ); ?> h6{
                                       font-family: "Noto Sans" !important;  
    }

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__link--nolink{
		cursor: default;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__bullet{
		width: 0;
		height: 0;
		margin-top: 10px;
		flex: 0 0 auto;
		border-top: 5px solid transparent;
		border-bottom: 5px solid transparent;
		border-left: 6px solid #173B7A;
	}

	#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__text{
		flex: 1 1 auto;
        font-size: 18px;
	}

	@media (max-width: 1100px){
		#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__grid{
			grid-template-columns: 1fr;
		}

		#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__card{
			min-height: auto;
		}
	}

	@media (max-width: 767px){
		#<?php echo esc_attr( $uid ); ?>{
			padding: 44px 0 52px;
		}

		#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__inner{
			width: min(100%, calc(100% - 24px));
		}

		#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__card{
			padding: 22px 16px 18px;
			border-radius: 12px;
		}

		#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__link{
			font-size: 17px;
			line-height: 1.4;
		}

		#<?php echo esc_attr( $uid ); ?> .lilacs-boxlistas__bullet{
			margin-top: 8px;
		}
	}
</style>