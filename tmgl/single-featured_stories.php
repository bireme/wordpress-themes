<?php get_header(); ?>
<?php
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (function_exists('have_rows')) {
	if (have_rows('first_session')) : 
		while (have_rows('first_session')) : the_row(); 
			$first_background = get_sub_field('background');
			$first_content = get_sub_field('content');
			$first_imagem = get_sub_field('imagem');
			if ($first_imagem) {
				$first_imagem_url = wp_get_attachment_url($first_imagem);
			}
		endwhile;
	endif;
}
if (function_exists('have_rows')) {
	if (have_rows('second_session')) : 
		while (have_rows('second_session')) : the_row(); 
			$second_background = get_sub_field('background');
			$second_imagem = get_sub_field('imagem');
			$second_content = get_sub_field('content');
		endwhile;
	endif;
}
if (function_exists('have_rows')) {
	if (have_rows('third_session')) : 
		while (have_rows('third_session')) : the_row(); 
			$third_content = get_sub_field('content');
			$third_imagem = get_sub_field('imagem');
			if ($third_imagem) {
				$third_imagem_url = wp_get_attachment_url($third_imagem);
			}
		endwhile;
	endif;
}
?>
<section id="header-title" style="background-image: linear-gradient(to right, rgba(0, 0, 0, .8), rgba(0, 0, 0, 0)), url(<?= $thumbnail_url ?>); background-attachment: scroll; background-position:center ;">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<div class="header-box">
			<h3 class="title1"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt=""> TM Featured Storie</h3>
			<h1 class="title1"><?= the_title(); ?></h1>
			<div class="font-3"><?php the_excerpt(); ?></div>
		</div>
	</div>
</section>

<section id="fs-1" style="background-color:<?= $first_background; ?>; background-image: url('<?= $first_imagem_url; ?>');">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?= $first_content; ?>
			</div>
			<div class="col-md-4">

			</div>
		</div>
	</div>
</section>

<section id="fs-2" style="background:<?= $second_background; ?>;">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?= $second_content; ?>
			</div>
			<div class="col-md-3 offset-md-1">
				<div class="sticky-top">
					<?php
					if ($second_imagem) {
						echo wp_get_attachment_image($second_imagem, 'full', false, array('class' => 'img-fluid rounded-16'));
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="evidence-maps" class="related">
	<div class="container">
		<h4 class="font-2 mb-4">Evidence Maps</h4>
		<div class="row">
			<article class="col-lg-4 mb-5">
				<div class="card card-trend h-100">
					<div class="card-body">
						<h5 class="card-title">Guia das Parteiras Tradicionais na Amazônia</h5>
						<p class="card-text">Schweickardt, Júlio Cesar; Melo, Camila Pimentel Lopes de; Moraes, Inna Silva de; Souza, Lupuna Corrêa de.</p>
					</div>
					<div class="card-footer text-end">
						<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
					</div>
				</div>
			</article>

			<article class="col-lg-4 mb-5">
				<div class="card card-trend h-100">
					<div class="card-body">
						<h5 class="card-title">Spirituality and Well-Being: Theory, Science, and the Nature Connection.</h5>
						<p class="card-text">Ryff, Carol D.</p>
					</div>
					<div class="card-footer text-end">
						<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
					</div>
				</div>
			</article>


			<article class="col-lg-4 mb-5">
				<div class="card card-trend h-100">
					<div class="card-body">
						<h5 class="card-title">Use of traditional medication on the health of women and children of the Togutil tribe in North Moluccas Province.</h5>
						<p class="card-text">Taib, Zulkiflia; Sibarani, Robert; Zuska, Fikarwin.</p>
					</div>
					<div class="card-footer text-end">
						<small class="text-body-secondary"><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
					</div>
				</div>
			</article>
		</div>
		<p class=" text-end"><?php _e( 'Explore more articles', 'tmgl' ); ?> <a href="<?= $url_news;?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></p>
	</div>
</section>

<section id="fs-3" style="background-image: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0.7) 60%, rgba(0,0,0,0.3) 100%), url(<?= $third_imagem['url'] ?>);">	
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<?= $third_content; ?>
			</div>
		</div>
	</div>
</section>


<main id="main_container" class="padding1 d-none">
	<div class="container">
		<?php the_content(); ?>
	</div>
</main>
<?php get_template_part('includes/related-videos'); ?>
<?php get_template_part('includes/recommended-articles'); ?>
<?php get_footer(); ?>