<?php
 /*Template Name: WP-Editais SES-SP
 */
 
get_header();
wp_enqueue_style ('theme-style', plugin_dir_url( __FILE__ ) .'css/editais.css');
$site_lang = substr($current_language, 0,2);

if ( defined( 'POLYLANG_VERSION' ) ) {
    $default_language = pll_default_language();
    if ( $default_language == $site_lang ) $site_lang = '';
}

?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div id="primary" class="col-md-12 archive">
	<h2><?php the_title(); ?></h2>
	<div class="post">
		<small class="date_post"><?php the_date(); ?> </small>
		<div class="entry">
			<ul>
				<li>Objetivo: <?php echo get_post_meta($post->ID, 'objectives_editais', true)?></li>
				<li><?php echo get_the_term_list( $post->ID, 'agencias', 'Agência: ', ', ', ''); ?></li>
				<li>Valor do Fomento: <?php echo get_post_meta($post->ID, 'value_editais', true)?></li>
				<?php echo get_the_term_list( $post->ID, 'publicos', '<li>Público-Alvo: ', ', ', '</li>'); ?>
				<li>Data das inscrições: Início:  
											<strong><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'startDate_editais', true))); ?> </strong>
									- Fim: 
											<strong><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'endDate_editais', true))); ?> </strong>
				</li>
				<?php echo get_the_term_list( $post->ID, 'institutions', '<li>Instituição Responsável: ', ', ', '</li>'); ?>
				<?php echo get_the_term_list( $post->ID, 'researchLines', '<li>Linhas de Pesquisa: ', ', ', '</li>'); ?>
				<?php echo get_the_term_list( $post->ID, 'topics', '<li>Temas de Interesse: ', ', ', '</li>'); ?>
				<li>Link: <a href="<?php echo get_post_meta($post->ID, 'linkUrl_01_editais', true)?>"><?php echo get_post_meta($post->ID, 'linkText_01_editais', true)?> </a></li>
			</ul>
			<?php the_content(); ?>
			
		</div>
		<!-- Display a comma separated list of the Post's Categories. -->
						<p class="postmetadata"><?php _e( 'Categorias:' ); ?> <?php the_category( ', ' ); ?></p>
						</div> <!-- closes the first div box -->

						<!-- Stop The Loop (but note the "else:" - see next line). -->
						<div class="author_box">
							Escrito por: <br>
							<?php echo get_the_author_meta('display_name'); ?><br>
							<?php echo get_the_author_meta('description'); ?>
						</div>
	</div>
    
    
<?php endwhile; else: ?>
    <p><?php _e('OPS!.'); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>