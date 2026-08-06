<?php
/**
 * Template do arquivo de edições.
 *
 * Arquivo: archive-edition.php
 *
 * @package Odin
 */

get_header();
?>

<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
	<?php
	if ( function_exists( 'bcn_display' ) ) {
		bcn_display();
	}
	?>
</div>

<?php if ( have_posts() ) : ?>

	<?php
	$year  = '';
	$month = '';
	?>

	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'All editions', 'odin' ); ?>
		</h1>
	</header>

	<div class="editions-list">

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php
			$date_field = get_field( 'date' );
			$date       = $date_field ? strtotime( $date_field ) : false;

			if ( ! $date ) {
				continue;
			}

			$current_year  = date( 'Y', $date );
			$current_month = date( 'm', $date );
			?>

			<?php if ( $current_year !== $year ) : ?>

				<?php
				$year  = $current_year;
				$month = '';
				?>

				<h2 class="year-title">
					<?php echo esc_html( $year ); ?>
				</h2>

			<?php endif; ?>

			<?php if ( $current_month !== $month ) : ?>

				<?php $month = $current_month; ?>

				<h3 class="month-title">
					<?php echo esc_html( date_i18n( 'F', $date ) ); ?>
				</h3>

			<?php endif; ?>

			<article
				id="post-<?php the_ID(); ?>"
				<?php post_class( 'edition-item' ); ?>
			>
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo esc_html( get_the_title() ); ?>
				</a>
			</article>

		<?php endwhile; ?>

	</div>

	<div class="editions-pagination">
		<?php odin_paging_nav(); ?>
	</div>

<?php else : ?>

	<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>

<?php
get_footer();
?>