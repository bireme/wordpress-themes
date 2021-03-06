<?php /* Template Name: Countries */ ?>
<?php get_header('in'); ?>
<main class="padding2 " role="main">
	<div class="container" id="main_container">
		<h1><?php the_title(); ?></h1>
		<hr />
	</div>
</main>

<?php while(have_posts()) : the_post();
	$introduction = get_field('introduction'); 
	$statistic = get_field('statistic'); 
	$twitter = get_field('twitter'); 
	$network_1 = get_field('network_1'); 
	$network_2 = get_field('network_2');
	?>
	<section class="sectionsCountries">
		<div class="container">	
			<?php echo $introduction ?>
		</div>
	</section>

	<section class="sectionsCountries <?php echo $statistic==''?'d-none':''; ?>">
		<div class="container">		
			<h3><?php pll_e('Statistic'); ?></h3>
			<?php echo $statistic ?>
		</div>
	</section>
<?php  endwhile; ?>

<?php if( have_rows('group_video') ): while ( have_rows('group_video') ) : the_row(); $videos = get_sub_field('url_video_1'); endwhile; endif; ?>
<section class="sectionsCountries <?php echo $videos==''?'d-none':''; ?>">
	<div class="container">		
		<h3><?php pll_e('Videos'); ?></h3>
		<div class="row">
			<?php if( have_rows('group_video') ): ?>
				<?php while( have_rows('group_video') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php $url_video = get_sub_field('url_video_'.$loop); ?>
						<?php if ( $url_video ) : ?>

							<div class="col-12 col-md-6 margin1">
								<div class="embed-responsive embed-responsive-16by9">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo get_video_code($url_video);  ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							</div>

						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>


<?php if( have_rows('group_depositions') ): while ( have_rows('group_depositions') ) : the_row(); $depositions = get_sub_field('name_1'); endwhile; endif; ?>
<section class="sectionsCountries <?php echo $depositions==''?'d-none':''; ?>">
	<div class="container">		
		<h3><?php pll_e('Depositions'); ?></h3>
		<div class="card-columns">
			<?php if( have_rows('group_depositions') ): ?>
				<?php while( have_rows('group_depositions') ): the_row(); $row = get_row(); $count = count($row)/3; $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php
						$text = get_sub_field('text_'.$loop);
						$name = get_sub_field('name_'.$loop);
						$image = get_sub_field('image_'.$loop);
						?>
						<?php if ( $text ) : ?>

							<div class="card mb-1">
								<div class="card-body">
									<p class="card-text"><?php echo $text; ?></p>
									<p class="card-text"><cite><?php echo $name; ?></cite></p>
								</div>
							</div>

						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>


<?php if( have_rows('group_partners') ): while ( have_rows('group_partners') ) : the_row(); $partners = get_sub_field('partners_1'); endwhile; endif; ?>
<section class="sectionsCountries <?php echo $partners==''?'d-none':''; ?>">
	<div class="container">		
		<!--h3><?php pll_e('Partners'); ?></h3-->
		<div class="row" >
			<?php if( have_rows('group_partners') ): ?>
				<?php while( have_rows('group_partners') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php $partners = get_sub_field('partners_'.$loop); ?>
						<?php if ( $partners ) : ?>
							<div class="col-6 col-md-4 margin1">
								<img src="<?php echo esc_url( $partners['url'] ); ?>" alt="<?php echo esc_attr( $partners['alt'] ); ?>" class="img-fluid" />
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="sectionsCountries <?php echo $twitter=='yes'?'':'d-none'; ?>">
	<div class="container">		
		<h3><?php pll_e('Social Networks'); ?></h3>
		<div id="iframeSocial">
			<div class="row">
				<div class="col-md-6">
					<?php echo $network_1 ?>
				</div>
				<div class="col-md-6">
					<?php echo $network_2 ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_template_part('includes/stores') ?>
<?php get_footer(); ?>
<?php get_template_part('includes/modais') ?>