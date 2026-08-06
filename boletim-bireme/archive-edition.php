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

<main id="main-content" class="site-main" role="main">

	<div class="container">

		<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
			<?php
			if ( function_exists( 'bcn_display' ) ) {
				bcn_display();
			}
			?>
		</div>

		<?php if ( have_posts() ) : ?>

			<?php
			$year        = '';
			$month       = '';
			$year_index  = 0;
			$year_opened = false;
			?>

			<header class="page-header">
				<h1 class="page-title">
					<?php esc_html_e( 'All editions', 'odin' ); ?>
				</h1>
			</header>

			<div class="editions-by-year">

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
						/*
						 * Fecha o bloco do ano anterior.
						 */
						if ( $year_opened ) :
							?>
								</div>
							</section>
							<?php
						endif;

						$year        = $current_year;
						$month       = '';
						$year_index++;
						$year_opened = true;

						$collapse_id = 'editions-year-' . $year_index;
						$is_open     = 1 === $year_index;
						?>

						<section class="edition-year">

							<h2 class="year-title">
								<button
									type="button"
									class="year-collapse-button"
									aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
									aria-controls="<?php echo esc_attr( $collapse_id ); ?>"
									data-collapse-target="<?php echo esc_attr( $collapse_id ); ?>"
								>
									<span class="year-label">
										<?php echo esc_html( $year ); ?>
									</span>

									<span class="collapse-icon" aria-hidden="true">
										<?php echo $is_open ? '−' : '+'; ?>
									</span>
								</button>
							</h2>

							<div
								id="<?php echo esc_attr( $collapse_id ); ?>"
								class="year-collapse-content"
								<?php echo $is_open ? '' : 'hidden'; ?>
							>

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

				<?php
				/*
				 * Fecha o último bloco de ano.
				 */
				if ( $year_opened ) :
					?>
						</div>
					</section>
					<?php
				endif;
				?>

			</div>

			<div class="editions-pagination">
				<?php odin_paging_nav(); ?>
			</div>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</div>

</main>

<style>
	.editions-by-year {
		margin-top: 30px;
	}

	.edition-year {
		margin-bottom: 15px;
		border: 1px solid #ddd;
		border-radius: 4px;
		overflow: hidden;
	}

	.year-title {
		margin: 0;
		font-size: 24px;
	}

	.year-collapse-button {
		display: flex;
		align-items: center;
		justify-content: space-between;
		width: 100%;
		padding: 15px 20px;
		border: 0;
		background-color: #f2f2f2;
		color: inherit;
		font: inherit;
		font-weight: 700;
		text-align: left;
		cursor: pointer;
		transition: background-color 0.2s ease;
	}

	.year-collapse-button:hover,
	.year-collapse-button:focus {
		background-color: #e7e7e7;
	}

	.year-collapse-button:focus-visible {
		outline: 2px solid currentColor;
		outline-offset: -3px;
	}

	.year-label {
		display: inline-block;
	}

	.collapse-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 30px;
		height: 30px;
		margin-left: 15px;
		font-size: 26px;
		font-weight: 400;
		line-height: 1;
	}

	.year-collapse-content {
		padding: 10px 20px 25px;
	}

	.year-collapse-content[hidden] {
		display: none;
	}

	.month-title {
		margin-top: 25px;
		margin-bottom: 10px;
		padding-bottom: 8px;
		border-bottom: 1px solid #ddd;
		font-size: 20px;
	}

	.month-title:first-child {
		margin-top: 10px;
	}

	.edition-item {
		margin-bottom: 8px;
	}

	.edition-item a {
		display: inline-block;
		text-decoration: none;
	}

	.edition-item a:hover,
	.edition-item a:focus {
		text-decoration: underline;
	}

	.editions-pagination {
		margin-top: 30px;
		margin-bottom: 30px;
	}

	@media screen and (max-width: 767px) {
		.year-collapse-button {
			padding: 12px 15px;
		}

		.year-collapse-content {
			padding: 10px 15px 20px;
		}

		.year-title {
			font-size: 21px;
		}

		.month-title {
			font-size: 18px;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		var collapseButtons = document.querySelectorAll(
			'.year-collapse-button[data-collapse-target]'
		);

		collapseButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				var targetId = button.getAttribute('data-collapse-target');
				var content = document.getElementById(targetId);
				var icon = button.querySelector('.collapse-icon');
				var isExpanded;

				if (!content) {
					return;
				}

				isExpanded = button.getAttribute('aria-expanded') === 'true';

				button.setAttribute(
					'aria-expanded',
					isExpanded ? 'false' : 'true'
				);

				content.hidden = isExpanded;

				if (icon) {
					icon.textContent = isExpanded ? '+' : '−';
				}
			});
		});
	});
</script>

<?php
get_footer();