<?php
/**
 * Template: Single Coleções
 * CPT: colecoes
 */

if (!defined('ABSPATH')) {
	exit;
}

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

        // Consumir itens via integração
		$items = [];
		$error = null;

		if (!empty($tainacan_slug) && function_exists('memorial_tainacan_get_collection_items')) {
			$resp = memorial_tainacan_get_collection_items($tainacan_slug, 1, $perpage);
			$items = $resp['items'] ?? [];
			$error = $resp['error'] ?? null;
		}
		?>

		<main class="container">
			<div class="breadcrumb mt-3">
				<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
			</div>
			<!-- Header -->
			<header class="mb-4">
				<h1 class="mb-3"><?php the_title(); ?></h1>

				<?php if (!empty($banner_url)) : ?>
					<div class="mb-4">
						<img
						src="<?php echo esc_url($banner_url); ?>"
						alt="<?php echo esc_attr(get_the_title()); ?>"
						class="img-fluid rounded"
						loading="lazy"
						/>
					</div>
				<?php endif; ?>

				<div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
					<div class="text-muted">
						<?php if (!empty($tainacan_slug)) : ?>
							Coleção vinculada: <strong><?php echo esc_html($tainacan_slug); ?></strong>
						<?php endif; ?>
					</div>

					<?php if (!empty($tainacan_url)) : ?>
						<a class="btn btn-outline-primary" href="<?php echo esc_url($tainacan_url); ?>" target="_self" rel="noopener">
							Ver todos no Tainacan
						</a>
					<?php endif; ?>
				</div>
			</header>

			<!-- Conteúdo editorial -->
			<section class="mb-5">
				<div class="content">
					<?php the_content(); ?>
				</div>
			</section>

			<!-- Itens -->
			<section class="mb-5">
				<div class="d-flex align-items-center justify-content-between mb-3">
					<h2 class="h4 mb-0">Itens da coleção</h2>

					<?php if (!empty($tainacan_url)) : ?>
						<a href="<?php echo esc_url($tainacan_url); ?>" class="text-decoration-none">
							Ver todos →
						</a>
					<?php endif; ?>
				</div>

				<?php if (!empty($error)) : ?>
					<div class="alert alert-warning">
						<?php echo esc_html($error); ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($items) && is_array($items)) : ?>
				<div class="row g-4">
					<?php foreach ($items as $item) :
						if (!function_exists('memorial_tainacan_normalize_item_to_card')) {
							continue;
						}

						$card = memorial_tainacan_normalize_item_to_card($item);

						$card_title = $card['title'] ?? '';
						$card_desc  = $card['description'] ?? '';
						$card_thumb = $card['thumb'] ?? '';
						$card_url   = $card['url'] ?? '';

						if (empty($card_url)) {
							continue;
						}
						?>
						<div class="col-12 col-md-6 col-lg-4">
							<article class="card h-100 shadow-sm">
								<?php if (!empty($card_thumb)) : ?>
									<a href="<?php echo esc_url($card_url); ?>" class="text-decoration-none">
										<img
										src="<?php echo esc_url($card_thumb); ?>"
										class="card-img-top"
										alt="<?php echo esc_attr($card_title); ?>"
										loading="lazy"
										style="object-fit: cover; height: 200px;"
										/>
									</a>
								<?php endif; ?>

								<div class="card-body d-flex flex-column">
									<h3 class="h6 card-title">
										<a href="<?php echo esc_url($card_url); ?>" class="text-decoration-none">
											<?php echo esc_html($card_title); ?>
										</a>
									</h3>

									<?php if (!empty($card_desc)) : ?>
										<p class="card-text text-muted small">
											<?php echo esc_html(wp_trim_words($card_desc, 18, '…')); ?>
										</p>
									<?php endif; ?>

									<div class="mt-auto">
										<a href="<?php echo esc_url($card_url); ?>" class="btn btn-sm btn-primary">
											Ver item
										</a>
									</div>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="text-muted">
					Nenhum item disponível para exibição no momento.
				</p>
			<?php endif; ?>
		</section>

	</main>

	<?php
endwhile;
endif;

get_footer();
