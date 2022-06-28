<?php get_header(); ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<section class="padding2 color1">
	<div class="container">
		<?php if ( is_active_sidebar( 'bp-sidebar-1' ) ) : ?>
		    <div id="bp-sidebar">
		        <?php dynamic_sidebar( 'bp-sidebar-1' ); ?>
		    </div>
		<?php endif; ?>
		<a href="https://admin.bestpractices.bvsalud.org" class="alert-link"  target="_blank"><?php _e('Click here and register your Best Practice', 'best-practices'); ?></a>
	</div>
</section>
<section class="padding1">
	<div class="container">
		<?php if ( is_active_sidebar( 'bp-sidebar-2' ) ) : ?>
		    <div id="bp-sidebar">
		        <?php dynamic_sidebar( 'bp-sidebar-2' ); ?>
		    </div>
	    <?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
