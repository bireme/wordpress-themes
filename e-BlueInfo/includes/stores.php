<?php
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'gonative') === false ) {
		$home = new WP_Query([ 'post_type' => 'Home']);
		while($home->have_posts()):$home->the_post();
			while(have_rows('grupo')):the_row(); 
				$sub_title = get_sub_field('sub_title'); 
				?>
				<section id="footerStores">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<?php echo $sub_title ?>
							</div>
							<div class="col-md-6 text-center">
								<a href="#" data-toggle="modal" data-target="#googlePlay" role="button"><img src="<?php bloginfo('template_directory') ?>/img/googlePlay.png" alt="Google Play"></a>
								<a href="#" data-toggle="modal" data-target="#appleStore" role="button"><img src="<?php bloginfo('template_directory') ?>/img/appleStore.png" alt="Apple Store" ></a>
							</div>
						</div>
					</div>
				</section>
				<?php
			endwhile;
		endwhile;
	}
?>