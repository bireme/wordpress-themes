<?php
/* Template Name: Novelty */
?>
<?php get_template_part('includes/topAcessibility') ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<div class="titulo1 text-center">
	<h2><?php the_title(); ?></h2>
</div>

<main id="main_container" class="padding2">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
			</ol>
		</nav>
		<div id="main_container">
			<div class="accordion" id="accordionExample">
				<?php 
				$x = get_the_title();
				$News = new WP_Query(array(
					'post_type' => 'News',
					'orderby' => 'title',
					'order'   => 'DESC'
				));
				$i = 0; 
				while($News->have_posts()) : $News->the_post();
					if(get_the_title()==$x){$News->the_post();}
					?>
					<div class="card">
						<div class="card-header" id="heading<?= $i ?>">
							<h2 class="mb-0">
								<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $i ?>" aria-expanded="true" aria-controls="collapse<?= $i ?>">
									<?php the_title(); ?>
								</button>
							</h2>
						</div>
						<div id="collapse<?= $i ?>" class="collapse <?php echo $i == 0 ? "show": ""; ?>" aria-labelledby="heading<?= $i ?>" data-parent="#accordionExample">
							<div class="card-body">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
					<?php $i++; ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>





