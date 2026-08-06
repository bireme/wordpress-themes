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
	<?php
$paged = max( 1, get_query_var( 'paged' ) );

$boletins_query = new WP_Query(
	array(
		'post_type'      => 'post', // Troque pelo post type dos boletins.
		'posts_per_page' => 20,
		'paged'          => $paged,
		'meta_key'       => 'date',
		'orderby'        => 'meta_value',
		'order'          => 'DESC',
	)
);
?>

<main
	id="content"
	class="<?php echo esc_attr( odin_classes_page_sidebar() ); ?>"
	tabindex="-1"
	role="main"
>
	<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
		<?php
		if ( function_exists( 'bcn_display' ) ) {
			bcn_display();
		}
		?>
	</div>

	<?php if ( $boletins_query->have_posts() ) : ?>

		<?php
		$year  = '';
		$month = '';
		?>

		<header class="page-header">
			<h1><?php esc_html_e( 'All editions', 'odin' ); ?></h1>
		</header>

		<div class="boletins-list">

			<?php while ( $boletins_query->have_posts() ) : ?>
				<?php
				$boletins_query->the_post();

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

				<div class="edition-item">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>

					<span class="edition-date">
						<?php echo esc_html( date_i18n( 'd/m/Y', $date ) ); ?>
					</span>
				</div>

			<?php endwhile; ?>

		</div>

		<nav class="boletins-pagination" aria-label="<?php esc_attr_e( 'Pagination', 'odin' ); ?>">
			<?php
			echo paginate_links(
				array(
					'base'      => str_replace(
						999999999,
						'%#%',
						esc_url( get_pagenum_link( 999999999 ) )
					),
					'format'    => '?paged=%#%',
					'current'   => $paged,
					'total'     => $boletins_query->max_num_pages,
					'mid_size'  => 2,
					'end_size'  => 1,
					'prev_text' => esc_html__( 'Anterior', 'odin' ),
					'next_text' => esc_html__( 'Próxima', 'odin' ),
				)
			);
			?>
		</nav>

		<?php wp_reset_postdata(); ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

</main>

<?php
//get_sidebar();
get_footer();
