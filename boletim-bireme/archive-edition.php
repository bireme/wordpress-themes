<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 2.2.0
 */

global $wp_query;

$args = $wp_query->query_vars;

$args['nopaging'] = true;
$args['posts_per_page'] = -1;
$args['posts_per_archive_page'] = -1;

$args['meta_key'] = 'date';
$args['orderby'] = 'meta_value';
$args['order'] = 'DESC';

unset( $args['paged'] );
unset( $args['page'] );

query_posts( $args );

$wp_query->is_search = false;

get_header(); ?>
	<main
	id="content"
	class="<?php echo esc_attr( odin_classes_page_sidebar() ); ?>"
	tabindex="-1"
	role="main"
>
	<div
		class="breadcrumbs"
		typeof="BreadcrumbList"
		vocab="https://schema.org/"
	>
		<?php
		if ( function_exists( 'bcn_display' ) ) {
			bcn_display();
		}
		?>
	</div>

	<?php if ( have_posts() ) : ?>

		<?php
		$first = true;
		$year  = null;
		$month = null;
		?>

		<header class="page-header">
			<h1><?php esc_html_e( 'All editions', 'odin' ); ?></h1>
		</header>

		<?php while ( have_posts() ) : ?>
			<?php
			the_post();

			$date_field = get_field( 'date' );
			$date       = $date_field ? strtotime( $date_field ) : false;

			if ( ! $date ) {
				continue;
			}

			$current_year  = date( 'Y', $date );
			$current_month = date( 'm', $date );
			$class         = '';
			?>

			<?php if ( $current_year !== $year ) : ?>
				<?php
				$year  = $current_year;
				$month = null;
				$class = $first ? 'first' : '';
				$first = false;
				?>

				<div
					class="year <?php echo esc_attr( $class ); ?>"
					data-year="<?php echo esc_attr( $year ); ?>"
				>
					<h2>
						<button type="button">
							<?php
							printf(
								'%s %s',
								esc_html__( 'Year', 'odin' ),
								esc_html( $year )
							);
							?>
						</button>
					</h2>
				</div>
			<?php endif; ?>

			<?php if ( $current_month !== $month ) : ?>
				<?php $month = $current_month; ?>

				<div
					class="month year-<?php echo esc_attr( $year ); ?> <?php echo esc_attr( $class ); ?>"
					data-month="<?php echo esc_attr( $month ); ?>"
					data-year="<?php echo esc_attr( $year ); ?>"
				>
					<h3>
						<button type="button">
							<?php echo esc_html( date_i18n( 'F', $date ) ); ?>
						</button>
					</h3>
				</div>
			<?php endif; ?>

			<div
				class="edition month-<?php echo esc_attr( $month ); ?> year-<?php echo esc_attr( $year ); ?> <?php echo esc_attr( $class ); ?>"
			>
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php
					printf(
						'%s - %s',
						esc_html( get_the_title() ),
						esc_html( date_i18n( 'd/F/Y', $date ) )
					);
					?>
				</a>
			</div>

		<?php endwhile; ?>

		<?php odin_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>
</main>

<?php
//get_sidebar();
get_footer();
