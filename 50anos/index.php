<?php
/**
 * Index template
 */

get_header(); ?>
<?php 
	$hotsite_lang = pll_current_language(slug); //pega o idioma do template
	include "vars_$hotsite_lang.php" //carrega as variaveis com o idioma selecionado;
?>
			<!-- Header -->
			<header>
				<div class="container" id="maincontent" tabindex="-1">
					<div class="row">
						<div class="col-lg-12 banner">
							<img class="img-responsive banner" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/<?php echo $bir50_banner_img; ?>" alt="<?php echo $bir50_banner_alt; ?>">
							<div class="intro-text">
								<span class="tagline"><?php bloginfo( 'description' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</header>
			
			<?php if ( is_active_sidebar( 'section-1' ) ) { ?>
				<section id="depoimentos" class="">
					<div class="col-lg-12">
						<h2><?php echo $bir50_depoimento; ?></h2>
					</div>
					<div class="row participate">
						<div class="col-lg-6 text-right">
							<span>
								<a href="<?php echo $bir50_verTodos_link; ?>">
									<?php echo $bir50_verTodos; ?> 
								</a>
							</span>
						</div>
						<div class="col-lg-6 text-right">
							<span>
								<a href="<?php echo $bir50_verTodosVideos_link; ?>">
									<?php echo $bir50_verTodosVideos; ?> 
								</a>
							</span>
						</div>
					</div>
					<div class="row">
						<?php dynamic_sidebar( 'section-1' ); ?>
					</div> <!-- /row -->
				</section> <!-- /section -->
			<?php } /* fecha section-1 sidebar */ ?>
			<?php if ( is_active_sidebar( 'section-2' ) ) { ?>
				<section id="section-2">
					<div class="row">
						<?php dynamic_sidebar( 'section-2' ); ?>
					</div> <!-- /row -->
				</section> <!-- /section -->
			<?php } /* fecha section-2 sidebar */ ?>
			<?php if ( is_active_sidebar( 'section-3' ) ) { ?>
				<section id="section-3">
					<div class="row">
						<?php dynamic_sidebar( 'section-3' ); ?>
					</div> <!-- /row -->
				</section> <!-- /section-3 -->
			<?php } /* fecha section-3 sidebar */ ?>
			<?php if ( is_active_sidebar( 'section-4' ) ) { ?>
				<section id="section-4">
					<div class="row">
						<?php dynamic_sidebar( 'section-4' ); ?>
					</div> <!-- /row -->
				</section> <!-- /section-4 -->
			<?php } /* fecha section-4 sidebar */ ?>
			<?php if ( is_active_sidebar( 'section-5' ) ) { ?>
				<section id="section-5">
					<div class="row">
						<?php dynamic_sidebar( 'section-5' ); ?>
					</div> <!-- /row -->
				</section> <!-- /section-5 -->
			<?php } /* fecha section-5 sidebar */ ?>

<?php get_footer(); ?>