<?php
if (function_exists('have_rows')) {
	if (have_rows('events')) : 
		while (have_rows('events')) : the_row(); 
            // Obtém os valores dos campos
			$events_title = get_sub_field('title');
			$events_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
	$url_events = get_field('url_events');
}
?>
<div class="container mt-5">
	<h2 class="title1">
		<img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" alt="">
		<?php _e( 'Events', 'tmgl' ); ?>
	</h2>
</div>
<section id="events">
	<div class="container">
		<div id="box-events">
			<h3 class="title1"><?= esc_html($events_title);?></h3>
			<p><?= $events_subtitle;?></p>
		</div>

		<div class="pb-5">
			<?php _e( 'Explore all events', 'tmgl' ); ?> <small class="text-body-secondary"><a href="<?= $url_events;?>" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></a></small>
		</div>
	</div>
</section>