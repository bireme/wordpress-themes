<?php get_header(); ?>
<main class="padding1">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo rtrim($home_url, '/'); ?>">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Taxonomia</li>
			</ol>
		</nav>
		<div>
			<h1><?php $taxonomy = get_queried_object(); echo  $taxonomy->name; ?></h1>
			<?php 
			while(have_posts()) : the_post();?>
				<a href="<?php permalink_link(); ?>">
					<div class="card margin2">
						<div class="card-body">
							<h5 class="title1 title3"><b><?php the_title(); ?></b></h5>
							<p><?php the_excerpt(); ?></p>
						</div>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
		<div class="text-center">
			<hr>	
			<?php the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => 'Anterior',
				'next_text' => 'Próximo',
			) ); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>