<?php
/*
Template Name: Memórias
Template Post Type: colecoes
*/
if (!defined('ABSPATH')) { exit; }
get_header("interno");
if (have_posts()) :
	while (have_posts()) : the_post();
		$post_id = get_the_ID();
// Metabox
		$tainacan_url  = get_post_meta($post_id, '_memorial_tainacan_collection_url', true);
		$tainacan_slug = get_post_meta($post_id, '_memorial_tainacan_collection_slug', true);
		$perpage       = (int) get_post_meta($post_id, '_memorial_itens_por_pagina', true);

		if ($perpage <= 0) {
			$perpage = 6;
		}
// Banner
		$banner_url = get_the_post_thumbnail_url($post_id, 'full');

// Página (opcional via querystring)
		$page = isset($_GET['pg']) ? (int) $_GET['pg'] : 1;
		if ($page < 1) { $page = 1; }

// Consumir itens via integração
		$items = [];
		$error = null;

		if (!empty($tainacan_slug) && function_exists('memorial_tainacan_get_collection_items')) {
			$resp  = memorial_tainacan_get_collection_items($tainacan_slug, $page, $perpage);
			$items = $resp['items'] ?? [];
			$error = $resp['error'] ?? null;
		} else {
			if (empty($tainacan_slug)) {
				$error = 'Slug do Tainacan não informado no metabox desta coleção.';
			} elseif (!function_exists('memorial_tainacan_get_collection_items')) {
				$error = 'Função memorial_tainacan_get_collection_items não encontrada. Verifique se o arquivo de integração foi incluído no functions.php (require_once).';
			}
		}
		?>
		<main id="main_container" class="container">
			<div class="breadcrumb mt-3">
				<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
			</div>
			<header class="mb-4">
				<div class="row">
					<h1 class="title"><?php the_title(); ?></h1>
					<div class="col-md-8">
						<?php if (!empty($banner_url)) : ?>
							<img
							src="<?php echo esc_url($banner_url); ?>"
							alt="<?php echo esc_attr(get_the_title()); ?>"
							class="img-fluid rounded d-block d-md-none mb-5"
							loading="lazy"
							/>
						<?php endif; ?>
						<?php
						$sobre_a_colecao = function_exists('get_field') ? get_field('sobre_a_colecao', $post_id) : '';
						$sobre_o_projeto = function_exists('get_field') ? get_field('sobre_o_projeto', $post_id) : '';
						?>
						<?php if (!empty($sobre_a_colecao)) : ?>
							<h2 class="">Sobre a coleção</h2>
							<div class="mb-4">
								<?php echo wp_kses_post($sobre_a_colecao); ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($sobre_o_projeto)) : ?>
							<h2 class="">Sobre o projeto</h2>
							<div class="mb-4">
								<?php echo wp_kses_post($sobre_o_projeto); ?>
							</div>
						<?php endif; ?>
						<?php the_content(); ?>
					</div>
					<div class="col-md-4">
						<div class="mb-4 sticky-top">
							<?php if (!empty($banner_url)) : ?>
								<img
								src="<?php echo esc_url($banner_url); ?>"
								alt="<?php echo esc_attr(get_the_title()); ?>"
								class="img-fluid rounded d-none d-md-block"
								loading="lazy"
								/>
							<?php endif; ?>

							<?php if( have_rows('citacoes') ): ?>
								<?php while( have_rows('citacoes') ): the_row(); 
									$frase = get_sub_field('frase');
									$autor = get_sub_field('autor');
									?>
									<blockquote class="">
										<p><?php echo esc_html($frase); ?></p>
										<footer><?php echo esc_html($autor); ?></footer>
									</blockquote>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</header>
		</main>
		<?php
	endwhile;
endif;
get_footer();
?>