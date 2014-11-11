<?php
/**
 Template Name: List of Strategies
 */
//Start when it is necessary to redirect a RSS url from iah searcah strategy

	if (isset($_GET["redirect"]) && ($_GET["what"] == 'html' || $_GET["what"] == 'rss')  && strpos($_SERVER["SERVER_NAME"], "bvsalud.org")) {
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
	load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');
	get_header('list-strategies'); 

	if (!isset($_GET["myorderby"]) && !isset($_GET["myorder"])) {
		$ob = "title";
		$o = "ASC";
		//$ob can assume 'title' for alphanumeric order or 'date' for publication date order
		//$o can assume 'ASC' or 'DESC'
	} else {
		if ($_GET["myorderby"] == "date" && !isset($_GET["myorder"])) {
			$ob = "date";
			$o = "DESC";
		} else {
			$ob = $_GET["myorderby"];
			$o = $_GET["myorder"];
		}
	}
	if ($ob == "category") {
		switch ($site_lang) {
                	case 'pt_BR':
                                $mk = 'category_pt ';
                                break;
                        case 'es_ES':
                                $mk = 'category_es ';
                                break;
                        case 'en_US':
                                $mk = 'category_en ';
                                break;
                }
		$obm = "meta_value";
		if (!isset($_GET["myorder"])){
			$o = "ASC";
		}

	}
	if ($ob == "title") {
		switch ($site_lang) {
			case 'pt_BR':
				$mk .= 'title_pt';
				break;
			case 'es_ES':
				$mk .= 'title_es';
				break;
			case 'en_US':
				$mk .= 'title_en';
				break;
		}
		$obm = 'meta_value';
	}
	if ($ob == "vhl") {
		switch ($site_lang) {
			case 'pt_BR':
				$mk .= 'vhl_instance_pt';
				break;
			case 'es_ES':
				$mk .= 'vhl_instance_es';
				break;
			case 'en_US':
				$mk .= 'vhl_instance_en';
				break;
		}
		$obm = 'meta_value';
	}
?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<h1><?php the_title(); ?></h1>
			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array (
						'post_type' 	 => 'search_strategy',
						'posts_per_page' => '100',
						'paged' 	 => $paged,
						'orderby'	 => $ob,
						'order'		 => $o
					);
				if ($mk) {
					$args['meta_key'] = $mk;
					$args['orderby'] = $obm;
				}
				$loop = new WP_Query($args);
			?>
			<br/>
			<br/>
			<table>
				<tr>
					<th width="25%">
						<?php
							if ($ob == 'category' && $o == 'ASC') {
								$url = "?l=" . $site_lang . "&myorderby=category&myorder=DESC"; 
								$class = "orderBy ASC";
							} elseif ($ob == 'category' && $o == 'DESC') {
								$url = "?l=" . $site_lang . "&myorderby=category&myorder=ASC";
                                                                $class = "orderBy DESC";
							} elseif ($ob != 'category'){
								$url = "?l=" . $site_lang . "&myorderby=category&myorder=ASC";
								$class = "orderBy ASC";
							}
						?>
						<a href="<?php echo $url; ?>"><?php if ($ob == 'category') {?><i class="<?php echo $class ?>"></i><?php }?><?php echo _e('Categories', 'refnet'); ?></a>
					</th>
					<th width="50%">
						<?php
                                                        if ($ob == 'title' && $o == 'ASC') {
                                                                $url = "?l=" . $site_lang . "&myorderby=title&myorder=DESC";
                                                                $class = "orderBy ASC";
                                                        } elseif ($ob == 'title' && $o == 'DESC') {
                                                                $url = "?l=" . $site_lang . "&myorderby=title&myorder=ASC";
                                                                $class = "orderBy DESC";
                                                        } elseif ($ob != 'title'){
                                                                $url = "?l=" . $site_lang . "&myorderby=title&myorder=ASC";
                                                                $class = "orderBy ASC";
                                                        }
                                                ?>
						<a href="<?php echo $url; ?>"><?php if ($ob == 'title') {?><i class="<?php echo $class ?>"></i><?php }?><?php echo _e('Subjects', 'refnet'); ?></a>
					</th>
					<th width="15%">
						<?php
                                                        if ($ob == 'vhl' && $o == 'ASC') {
                                                                $url = "?l=" . $site_lang . "&myorderby=vhl&myorder=DESC";
                                                                $class = "orderBy ASC";
                                                        } elseif ($ob == 'vhl' && $o == 'DESC') {
                                                                $url = "?l=" . $site_lang . "&myorderby=vhl&myorder=ASC";
                                                                $class = "orderBy DESC";
                                                        } elseif ($ob != 'vhl'){
                                                                $url = "?l=" . $site_lang . "&myorderby=vhl&myorder=ASC";
                                                                $class = "orderBy ASC";
                                                        }
                                                ?>
						<a href="<?php echo $url; ?>"><?php if ($ob == 'vhl') {?><i class="<?php echo $class ?>"></i><?php }?><?php echo _e('VHL Instance', 'refnet'); ?></a>
					</th>
					<th width="10%"></th>
				</tr>
			<?php
				while ($loop->have_posts()) {
					$loop->the_post();
					$categories = get_the_category();
			?>
				<tr>
					<td>
			<?php
					if ($categories) {
						foreach ($categories as $category) {
							echo extract_text_by_language_markup($category->name);
							if (end($categories) != $category) {
								echo ", ";
							}
						}
					}
			?>
					</td>
					<td><a href="<?php the_permalink(); ?>"> <?php the_title();?></a></td>
					<td>
			<?php
					if (bir_has_no_empty_custom_field (get_the_ID(), array("vhl_instance"))) {
						echo trim(bir_show_custom_field_translated(get_the_ID(), "vhl_instance","","","",TRUE,",",FALSE,FALSE));
                                        }
			?>
					</td>
					<td>
			<?php
					if (bir_has_no_empty_custom_field (get_the_ID(), array("lilacs_iahx_search_expression"))) {
                                                echo bir_show_search_rss_buttons(get_the_ID(), "lilacs_iahx_search_expression", "link");
                                        } elseif (bir_has_no_empty_custom_field (get_the_ID(), array("lilacs_iah_search_expression")) && bir_has_no_empty_custom_field (get_the_ID(), array("url_to_search_result"))) {
                                                echo bir_show_search_rss_buttons_iah(get_the_ID(), "url_to_search_result", "link");
					}
			?>
					</td>
				</tr>
			<?php
				} 
			?>
			</table>
		</div><!-- #content -->
		<?php wp_pagenavi( array('query' => $loop )); ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
