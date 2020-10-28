<?php /* Template Name: Countries */ ?>
<?php get_header('in'); ?>
<main class="padding1 " role="main">
	<div class="container" id="main_container">
		<h1><?php the_title(); ?></h1>
		<hr />
	</div>
</main>

<?php while(have_posts()) : the_post();
	$introduction = get_field('introduction'); 
	$statistic = get_field('statistic'); 
	?>
	<section class="sectionsCountries">
		<div class="container">	
			<?php echo $introduction ?>
		</div>
	</section>

	<section class="sectionsCountries">
		<div class="container">		
			<h3>Estatística</h3>
			<?php echo $statistic ?>
		</div>
	</section>
<?php  endwhile; ?>

<section class="sectionsCountries">
	<div class="container">		
		<h3>Vídeos</h3>
		<div class="row">
			<?php if( have_rows('group_video') ): ?>
				<?php while( have_rows('group_video') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php $url_video = get_sub_field('url_video_'.$loop); ?>
						<?php if ( $url_video ) : ?>

							<div class="col-md-4 margin1">
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

<section class="sectionsCountries">
	<div class="container">		
		<h3>Depoimentos</h3>
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

							<div class="card mb-4">
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

<section class="sectionsCountries">
	<div class="container">		
		<h3>Parceiros</h3>
		<div class="row" >
			<?php if( have_rows('group_partners') ): ?>
				<?php while( have_rows('group_partners') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
					<?php while ($count > $loop) : $loop++; ?>
						<?php $partners = get_sub_field('partners_'.$loop); ?>
						<?php if ( $partners ) : ?>

							<div class="col-md-4 margin1">
								<img src="<?php echo esc_url( $partners['url'] ); ?>" alt="<?php echo esc_attr( $partners['alt'] ); ?>" class="img-fluid" />
							</div>

						<?php endif; ?>
					<?php endwhile; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>