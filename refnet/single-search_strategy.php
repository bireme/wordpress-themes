<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

//Start when it is necessary to redirect a RSS url from iah searcah strategy

        if (isset($_GET["redirect"]) && ($_GET["what"] == 'html' || $_GET["what"] == 'rss')  && strpos($_SERVER["SERVER_NAME"], "bvsalud.org") >= 0) {
                if (bir_has_no_empty_custom_field ($_GET["redirect"], array("url_to_search_result"))) {
                        $href = bir_extract_url_iah_search_expression($_GET["redirect"], "url_to_search_result");
                        if ($href) {
                                $href = bir_resolve_link_from_url_shortner($href);
                                if (strlen(urlencode($href)) < 7500){
                                        if (is_page('lista-de-temas')) {
                                                $iahx_other_params = "&source=bir-qsl";
                                        }
                                        if (is_single()) {
                                                if ($_GET["source"] == 'bir-qsl') {
                                                        $iahx_other_params = "&source=bir-ss-qsl";
                                                } else {
                                                        $iahx_other_params = "&source=bir-ss";
                                                }
                                        }
                                        if ($_GET["what"] == 'rss') {
                                                $iahx_other_params .= "&output=rss";
                                        }
                                        header('Location: ' . $href . $iahx_other_params);
                                }
                        }
                }
        }

//End

?>
	<?php 
		load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');
		get_header(); 
		echo create_bread_crumb(get_the_title()); 
	?>
	<div id="primary" class="site-content">
		<div id="content" class="single1column" role="main">
			<div class="search-strategy-data">
				<?php
					$terms = wp_get_post_terms(get_the_ID(), 'status');
				?>
				<h4><?php the_title(); ?></h4>
				<?php
					if ($terms) {
						switch($terms[0]->name) {
							case "In review":
								echo '<span class="in_review">' . bir_translate_custom_field_values($terms[0]->name) . '</span>';
								break;
							case "Reviewed":
								echo '<span class="reviewed">' . bir_translate_custom_field_values($terms[0]->name) . '</span>';
								break;
							default:
								break;
						}
					}
					$custom_field_keys = array ("description_of_the_search", "main_subject_of_the_search","secondary_subject_of_the_search");
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
				echo bir_show_custom_field_translated(get_the_ID(), 'description_of_the_search', __('Description','refnet'), $html4label, $html4custom_field);
				echo bir_show_custom_field_translated(get_the_ID(), 'main_subject_of_the_search', __('Main subjects','refnet'), $html4label, $html4custom_field);
				echo bir_show_custom_field_translated(get_the_ID(), 'secondary_subject_of_the_search', __('Secondary subjects','refnet'), $html4label, $html4custom_field);
				echo bir_show_custom_field_translated(get_the_ID(), 'type_of_search_strategy', __('Scope','refnet'), $html4label, $html4custom_field);
				echo bir_show_custom_field_translated(get_the_ID(), 'url_to_search_result', __('Search result','refnet'), $html4label, $html4custom_field);
			?>
				</dl>
				<?php 
					$custom_field_keys = array ("publication_year", "country_or_region_of_publication", "country_or_region_as_subject", "text_language", "other_text_language", "publication_type", "other_publication_type", "conditions", "other_conditions");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='filters'></i>";
						_e('Filters','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					$text2show =  bir_show_custom_field_translated(get_the_ID(), 'text_language', __('Text language','refnet'), $html4label, $html4custom_field);
					echo preg_replace("/other_to_replace/", bir_show_custom_field_translated(get_the_ID(), 'other_text_language',"","","",TRUE,",",FALSE,TRUE), $text2show);	
					$text2show =  bir_show_custom_field_translated(get_the_ID(), 'publication_type', __('Publication type','refnet'), $html4label, $html4custom_field);
					echo preg_replace("/other_to_replace/", bir_show_custom_field_translated(get_the_ID(), 'other_publication_type',"","","",TRUE,",",FALSE,TRUE), $text2show);	
					echo bir_show_custom_field_translated(get_the_ID(), 'publication_year', __('Publication year','refnet'), $html4label, $html4custom_field);
					$text2show = bir_show_custom_field_translated(get_the_ID(), 'limits', __('Limits','refnet'), $html4label, $html4custom_field);
					echo preg_replace("/other_to_replace/", bir_show_custom_field_translated(get_the_ID(), 'other_conditions',"","","",TRUE,",",FALSE,TRUE), $text2show);	
					echo bir_show_custom_field_translated(get_the_ID(), 'country_of_publication', __('Publication country','refnet'), $html4label, $html4custom_field);
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("lilacs_iah_search_expression", "lilacs_iahx_search_expression", "lilacs_url_to_search_results");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='databases'></i>";
						_e('Search strategy','refnet');
						echo "</h5>";
					}
				?>
				<dl class="expr">
				<?php
					echo bir_show_custom_field_translated(get_the_ID(), 'search_strategy_I_observations', __('Observation','refnet'), $html4label, $html4custom_field);
					if (bir_has_no_empty_custom_field (get_the_ID(), array("lilacs_iahx_search_expression"))) {
						echo bir_show_search_rss_buttons(get_the_ID(), "lilacs_iahx_search_expression");
                                        }
					echo bir_show_custom_field_translated(get_the_ID(), 'lilacs_iahx_search_expression', __('iAHx search strategy','refnet'), $html4label, $html4custom_field);
					if (bir_has_no_empty_custom_field (get_the_ID(), array("lilacs_iah_search_expression"))) {
						echo bir_show_search_rss_buttons_iah(get_the_ID(), "url_to_search_result");
					}
					echo bir_show_custom_field_translated(get_the_ID(), 'lilacs_iah_search_expression', __('iAH search strategy','refnet'), $html4label, $html4custom_field);
					$text2show = bir_show_custom_field_translated(get_the_ID(), 'search_strategy_I_databases', __('Databases','refnet'), $html4label, $html4custom_field);
					echo preg_replace("/other_to_replace/", bir_show_custom_field_translated(get_the_ID(), 'search_strategy_I_other_databases',"","","",TRUE,",",FALSE,TRUE), $text2show);	
				?>
				</dl>
				<?php 
					/*
					$custom_field_keys = array ("medline_iah_search_expression", "medline_iahx_search_expression", "medline_url_to_search_results");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='databases'></i>";
						_e('Search strategy II','refnet');
						echo "</h5>";
					}
					*/
				?>
				<dl class="expr">
				<?php
					/*
					echo bir_show_custom_field_translated(get_the_ID(), 'search_strategy_II_observations', __('Observations','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field_translated(get_the_ID(), 'medline_iah_search_expression', __('iAH search strategy','refnet'), $html4label, $html4custom_field);
					if (bir_has_no_empty_custom_field (get_the_ID(), array("medline_iahx_search_expression"))) {
						echo bir_show_search_rss_buttons(get_the_ID(), "medline_iahx_search_expression");
                                        }
					echo bir_show_custom_field_translated(get_the_ID(), 'medline_iahx_search_expression', __('iAHx search strategy','refnet'), $html4label, $html4custom_field);
					$text2show = bir_show_custom_field_translated(get_the_ID(), 'search_strategy_II_databases', __('Databases','refnet'), $html4label, $html4custom_field);
					echo preg_replace("/other_to_replace/", bir_show_custom_field_translated(get_the_ID(), 'search_strategy_II_other_databases',"","","",TRUE,",",FALSE,TRUE), $text2show);	
					*/
				?>
				</dl>
				<?php 
					/*
					$custom_field_keys = array ("cochrane_iah_search_expression", "cochrane_iahx_search_expression", "cochrane_url_to_search_results");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='databases'></i>";
						_e('Search strategy III','refnet');
						echo "</h5>";
					}
					*/
				?>
				<dl class="expr">
				<?php
					/*
					echo bir_show_custom_field_translated(get_the_ID(), 'search_strategy_III_observations', __('Observations','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field_translated(get_the_ID(), 'cochrane_iah_search_expression', __('iAH search strategy','refnet'), $html4label, $html4custom_field);
					if (bir_has_no_empty_custom_field (get_the_ID(), array("cochrane_iahx_search_expression"))) {
						echo bir_show_search_rss_buttons(get_the_ID(), "cochrane_iahx_search_expression");
                                        }
					echo bir_show_custom_field_translated(get_the_ID(), 'cochrane_iahx_search_expression', __('iAHx search strategy','refnet'), $html4label, $html4custom_field);
					$text2show = bir_show_custom_field_translated(get_the_ID(), 'search_strategy_III_databases', __('Databases','refnet'), $html4label, $html4custom_field);
					echo preg_replace("/other_to_replace/", bir_show_custom_field_translated(get_the_ID(), 'search_strategy_III_other_databases',"","","",TRUE,",",FALSE,TRUE), $text2show);	
					*/
				?>
				</dl>
				<?php 
					$custom_field_keys = array ("search_details","vhl_instance");
					if (bir_has_no_empty_custom_field (get_the_ID(), $custom_field_keys)) {
						echo "<h5>";
						echo "<i class='subject'></i>";
						_e('More information','refnet');
						echo "</h5>";
					}
				?>
				<dl>
				<?php
					echo bir_show_custom_field_translated(get_the_ID(), 'vhl_instance', __('VHL instance','refnet'), $html4label, $html4custom_field);
					echo bir_show_custom_field_translated(get_the_ID(), 'search_details', __('Search details','refnet'), $html4label, $html4custom_field);
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
