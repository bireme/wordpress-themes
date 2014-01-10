<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<?php 
		load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');
		get_header(); 
		echo create_bread_crumb(get_the_title()); 
	?>
	<div id="primary" class="site-content">
		<div id="content" class="single1column" role="main">
			<div class="search-strategy-data">
				<h4><?php the_title(); ?></h4>
				<?php 
					$custom_field_keys = array ("description_of_the_search", "responsible", "deadlines");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='about'></i>";
						_e('About the search','refnet');
						echo "</h5>";
					}
				?>
				<dl>
			<?php
				$html4label = "<dt>label</dt>";
				$html4custom_field = "<dd>custom_field</dd><br/>";
				echo bir_show_custom_field(get_the_ID(), 'description_of_the_search', __('Description of the search','refnet'), $html4label, $html4custom_field);
				echo bir_show_custom_field(get_the_ID(), 'url_to_search_result', __('URL to Search Results','refnet'), $html4label, $html4custom_field);
				//echo bir_show_custom_field(get_the_ID(), 'responsible', __('Responsible','refnet'), $html4label, $html4custom_field);
				//echo bir_show_custom_field(get_the_ID(), 'deadlines', __('Deadlines','refnet'), $html4label, $html4custom_field);
			?>
				</dl>
				<?php 
					$custom_field_keys = array ("main_subject_of_the_search", "secondary_subject_of_the_search", "other_secondary_subject_of_the_search");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='subject'></i>";
						_e('Search subject','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'main_subject_of_the_search', __('Main subject of the search','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'secondary_subject_of_the_search', __('Secondary subject of the search','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'other_secondary_subject_of_the_search', __('Other secondary subject of the search','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("vhls_databases", "other_vhls_databases", "other_databases", "more_other_databases");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='databases'></i>";
						_e('Databases','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'vhls_databases', __('VHLs Databases','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'other_vhls_databases', __('Other VHLs Databases','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'other_databases', __('Other Databases','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'more_other_databases', __('More Other Databases','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("publication_year", "country_or_region_of_publication", "country_or_region_as_subject", "text_language", "other_text_language", "publication_type", "other_publication_type", "conditions", "other_conditions");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='filters'></i>";
						_e('General Search Filters','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'publication_year', __('Publication year','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'country_or_region_of_publication', __('Country or Region of publication','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'country_or_region_as_subject', __('Country or Region as subject','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'text_language', __('Text language','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'other_text_language', __('Other Text language','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'publication_type', __('Publication type','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'other_publication_type', __('Other Publication type','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'conditions', __('Conditions: gender, age etc','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'other_conditions', __('Other Conditions','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("vhl_instance", "type_of_search_strategy");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='vhl-instance'></i>";
						_e('Search Strategy Scope','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'vhl_instance', __('VHL instance','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'type_of_search_strategy', __('Type of search strategy','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("lilacs_iah_search_expression", "lilacs_iahx_search_expression", "lilacs_url_to_search_results");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='lilacs-strategy'></i>";
						_e('LILACS Strategy','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'lilacs_iah_search_expression', __('iAH Search Expression','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'lilacs_iahx_search_expression', __('iAHx Search Expression','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'lilacs_url_to_search_results', __('URL to Search Results','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("medline_iah_search_expression", "medline_iahx_search_expression", "medline_url_to_search_results");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='medline-strategy'></i>";
						_e('MEDLINE Strategy','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'medline_iah_search_expression', __('iAH Search Expression','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'medline_iahx_search_expression', __('iAHx Search Expression','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'medline_url_to_search_results', __('URL to Search Results','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("cochrane_iah_search_expression", "cochrane_iahx_search_expression", "cochrane_url_to_search_results");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='cochrane-strategy'></i>";
						_e('Cochrane Strategy','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field(get_the_ID(), 'cochrane_iah_search_expression', __('iAH Search Expression','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'cochrane_iahx_search_expression', __('iAHx Search Expression','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field(get_the_ID(), 'cochrane_url_to_search_results', __('URL to Search Results','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
			</div>
			<?php comments_template(''); ?>
			
			
			<?php while ( have_posts() ) : the_post(); ?>
				<?php echo "<div class='revisions'>"; ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php echo "</div>"; ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	<div class="single2column">
		<?php dynamic_sidebar( 'level2' ); ?>
	</div>
	</div><!-- #primary -->
<?php get_footer(); ?>
