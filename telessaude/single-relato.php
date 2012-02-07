<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="middle wrapper">
	<div class="post single">
	<div class="breadCrumb"><a href="<?php bloginfo('home'); ?>">Home</a> / <span class="active"><?php the_title(); ?></span></div>
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <h3 class="storytitle"><?php the_title(); ?></h3>
		<div class="mediaplayer">
			<?php echo get_post_meta($post->ID, 'relatos_video_code', true) ?>
		</div>
        <div class="storycontent">
			<h4>Descrição</h4>
            <?php the_content(__('(more...)')); ?>
			<h4>Assuntos Abordados</h4>
			<?php echo get_post_meta($post->ID, 'relatos_assuntos', true) ?>
		</div>
		<div class="childPages">
			<ul>                
			  <?php
				 global $id;
				 $post_type = get_post_type( $id );
				 wp_list_pages("post_type=" . $post_type. "&title_li=&child_of=" . $id);
			  ?>
			</ul>
		</div>
		<hr/>
        <?php comments_template( '', true ); ?>
        <!--div class="feedback">
            <?php wp_link_pages(); ?>
            <?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
        </div-->
    </div>
	</div>
    <?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
	<div class="thirdColumn">
		<div class="storyrelatedcontent">
			<div class="storymoreinfo">
				<h3>Saiba Mais</h3>
				<div class="storyaboutperson">
					<h4>Sobre a Pessoa</h4>
					<div class="storyimage">
						<?php
							$fotourl= get_post_meta($post->ID, 'relatos_foto', true);
							echo wp_get_attachment_image( $fotourl );
						?>
					</div>
					<?php echo get_post_meta($post->ID, 'relatos_sobre', true) ?>
				</div>
				<div class="storylinksperson">
					<h4>Publicações</h4>
					<?php echo get_post_meta($post->ID, 'relatos_links', true) ?>
				</div>
				<div class="storyliterature">
					<h4>Literatura Relacionada</h4>
					<?php echo get_post_meta($post->ID, 'relatos_literatura', true) ?>
				</div>
			</div>
			<div class="storyrelatedlinks">
				<h3>Links Relacionados</h3>
				<?php echo get_post_meta($post->ID, 'relatos_linksRelacionados', true) ?>
			</div>
		</div>		
		<div class="spacer"> </div>
	</div><!--/thirdColumn-->
    <?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?>

	<div class="spacer"> </div>
</div>
<?php get_footer(); ?>
