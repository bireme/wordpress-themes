<div class="<?php echo is_front_page()? 'col':'col-md-3'; ?> item-calculadora">
	<div class="row">
		<?php if( has_post_thumbnail(get_the_ID()) ){ ?>
			<div class="col-3 col-sm-3 col-md-12">
				<a href="<?php echo the_permalink(get_the_ID()); ?>">
					<img src="<?php echo get_the_post_thumbnail_url( get_the_ID() ); ?>" alt="<?php the_title(); ?>" class="img-fluid img-calculadora" />
				</a>
			</div>
		<?php } ?>

		<div class="col-9 col-sm-9 col-md-12">
			<h3 class="title-calculadora"><a href="<?php echo the_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h3>
			<div class="excerpt-calculadora">
				<?php crop_text(get_the_excerpt(get_the_ID()), 130); ?>
			</div>
		</div>
	</div>
</div>