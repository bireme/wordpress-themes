<?php get_header(); ?>
<?php get_template_part('includes/search') ?>

<div id="notfound">
	<div class="notfound">
		<div class="notfound-404">
			<h1>404</h1>
		</div>
		<h2><?php _e('We are sorry, Page not found!', 'best-practices'); ?></h2>
		<p><?php _e('The page you are looking for might have been removed had its name changed or is temporarily unavailable.', 'best-practices'); ?></p>
		<a href="<?php echo get_bloginfo('home'); ?>"><?php _e('Back to homepage', 'best-practices'); ?></a>
	</div>
</div>

<?php get_footer(); ?>
