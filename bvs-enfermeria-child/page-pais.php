<?php 
	/* Template Name: PagePais */
	/* Template para a página de País da Rede BVS Enfermagem */
	/* Usar apenas para apresentação dos países da Rede */
	get_header(); 
?>
    <div class='container page_network'>
        <div class='row'>
            <div class="top_sidebar">
                <?php dynamic_sidebar( top_sidebar ); ?>
            </div>  
        </div>
		<div class='content content_page'>
				<?php if(have_posts()): while(have_posts()): the_post(); ?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='title'>
								<h2><?php the_title(); ?></h2>
							</div>
						</div>
					</div>

					<div class='row'>
						<div class='col-md-12'>
							<div class='content'><?php the_content(); ?></div>
						</div>
					</div>
				<?php endwhile; endif; ?>
		</div>
    </div>
<?php get_footer(); ?>