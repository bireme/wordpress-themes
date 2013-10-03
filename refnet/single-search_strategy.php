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
				<h5><?php _e('About the search','refnet');?></h5>
				<dl>
					<dt><?php echo __('Description of the search','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'description_of_the_search'); ?></dd>
					<dt><?php echo __('Responsible','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'responsible'); ?></dd>
					<dt><?php echo __('Deadlines','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'deadlines'); ?></dd>
				</dl>
				<h5><?php echo __('Search subject','refnet');?></h5>
				<dl>
					<dt><?php echo __('Main subject of the search','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'main_subject_of_the_search'); ?></dd>
					<dt><?php echo __('Secondary subject of the search','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'secondary_subject_of_the_search'); ?></dd>
					<dt><?php echo __('Other secondary subject of the search','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'other_secondary_subject_of_the_search'); ?></dd>
				</dl>
				<h5><?php echo __('Databases','refnet');?></h5>
				<dl>
					<dt><?php echo __('VHLs Databases','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'vhls_databases'); ?></dd>
					<dt><?php echo __('Other VHLs Databases','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'other_vhls_databases'); ?></dd>
					<dt><?php echo __('Other Databases','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'other_databases'); ?></dd>
					<dt><?php echo __('More Other Databases','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'more_other_databases'); ?></dd>
				</dl>
				<h5><?php echo __('General Search Filters','refnet');?></h5>
				<dl>
					<dt><?php echo __('Publication year','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'publication_year'); ?></dd>
					<dt><?php echo __('Country or Region of publication','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'country_or_region_of_publication'); ?></dd>
					<dt><?php echo __('Country or Region as subject','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'country_or_region_as_subject'); ?></dd>
					<dt><?php echo __('Text language','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'text_language'); ?></dd>
					<dt><?php echo __('Other Text language','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'other_text_language'); ?></dd>
					<dt><?php echo __('Publication type','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'publication_type'); ?></dd>
					<dt><?php echo __('Other Publication type','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'other_publication_type'); ?></dd>
					<dt><?php echo __('Conditions: gender, age etc','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'conditions'); ?></dd>
					<dt><?php echo __('Other Conditions','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'other_conditions'); ?></dd>
				</dl>
				<h5><?php echo __('Search Strategy Scope','refnet');?></h5>
				<dl>
					<dt><?php echo __('VHL instance','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'vhl_instance'); ?></dd>
					<dt><?php echo __('Type of search strategy','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'type_of_search_strategy'); ?></dd>
				</dl>
				<h5><?php echo __('LILACS Strategy','refnet');?></h5>
				<dl>
					<dt><?php echo __('iAH Search Expression','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'lilacs_iah_search_expression'); ?></dd>
					<dt><?php echo __('iAHx Search Expression','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'lilacs_iahx_search_expression'); ?></dd>
					<dt><?php echo __('URL to Search Results','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'lilacs_url_to_search_results'); ?></dd>
				</dl>
				<h5><?php echo __('MEDLINE Strategy','refnet');?></h5>
				<dl>
					<dt><?php echo __('iAH Search Expression','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'medline_iah_search_expression'); ?></dd>
					<dt><?php echo __('iAHx Search Expression','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'medline_iahx_search_expression'); ?></dd>
					<dt><?php echo __('URL to Search Results','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'medline_url_to_search_results'); ?></dd>
				</dl>
				<h5><?php echo __('Cochrane Strategy','refnet');?></h5>
				<dl>
					<dt><?php echo __('iAH Search Expression','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'cochrane_iah_search_expression'); ?></dd>
					<dt><?php echo __('iAHx Search Expression','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'cochrane_iahx_search_expression'); ?></dd>
					<dt><?php echo __('URL to Search Results','refnet');?></dt>
					<dd><?php echo bir_show_custom_field(get_the_ID(), 'cochrane_url_to_search_results'); ?></dd>
				</dl>
			</div>
			<?php comments_template( '', true ); ?>
			
			
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	<div class="single2column">
		<?php dynamic_sidebar( 'level2' ); ?>
	</div>
	</div><!-- #primary -->
<?php get_footer(); ?>
