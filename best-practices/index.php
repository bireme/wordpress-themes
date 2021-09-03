<?php get_header(); ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<section class="padding2 color1">
	<div class="container">
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas facere id tenetur numquam cumque unde amet ab accusantium libero architecto accusamus exercitationem magnam similique reprehenderit, nesciunt voluptate itaque? Expedita, animi.</p>
		<a href="https://admin.bestpractices.bvsalud.org" class="alert-link"  target="_blank"><?php _e('Click here and register your Best Practice', 'bp'); ?></a>
	</div>
</section>
<section class="padding1">
	<div class="container">
		<?php if ( is_active_sidebar( 'bp-sidebar' ) ) : ?>
		    <div id="bp-sidebar">
		        <?php dynamic_sidebar( 'bp-sidebar' ); ?>
		    </div>
	    <?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
