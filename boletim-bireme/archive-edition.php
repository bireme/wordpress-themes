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
$args = array_merge( $wp_query->query_vars, array( 'orderby' => 'meta_value', 'meta_key' => 'date' ) );
query_posts($args);
$wp_query->is_search = false;

get_header(); ?>

	<main id="content" class="<?php echo odin_classes_page_sidebar(); ?>" tabindex="-1" role="main">
			<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                <?php if ( function_exists( 'bcn_display' ) ) bcn_display(); ?>
            </div>
			<?php if ( have_posts() ) : $first = true; $class = ''; ?>

				<header class="page-header">
					<h1><?php _e( 'All editions', 'odin' ) ?></h1>
				</header><!-- .page-header -->

				<?php while ( have_posts() ) : the_post(); // Start the Loop. ?>

					<?php $date = strtotime( get_field( 'date' ) ); ?>

					<?php
						if ( ! isset($year) || date( "Y", $date ) != $year ) :
                        	$year = date( "Y", $date );
                        	$class = $first ? 'first' : '';
                        	$first = false;
                    ?>
						<div class="year" data-year="<?php echo $year; ?>">
				        	<h2><a href="#"><?php echo __( 'Year', 'odin' ) . ' ' . date( "Y", $date ); ?></a></h2>
				        </div>
				    <?php endif; ?>

		        	<?php
						if ( ! isset($month) || date( "m", $date ) != $month ) :
                        	$month = date( "m", $date );
                    ?>
		                <div class="month year-<?php echo $year; ?> <?php echo $class; ?>" data-month="<?php echo $month; ?>" data-year="<?php echo $year; ?>">
		                	<h3><a href="#"><?php echo date_i18n( 'F', $date ); ?></a></h3>
		                </div>
			        <?php endif; ?>

			            <div class="edition month-<?php echo $month; ?> year-<?php echo $year; ?> <?php echo $class; ?>"><a href="<?php the_permalink(); ?>"><?php echo get_the_title() . ' - ' . date_i18n( "d/F/Y", $date ); ?></a></div>

			    <?php endwhile;

					// Page navigation.
					odin_paging_nav();

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>

	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
