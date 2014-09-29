<?php
/**
 Template Name: List of Strategies
 */
	load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');
	get_header(); 
	echo create_bread_crumb(get_the_title());
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
	if ($ob == "title") {
		switch ($site_lang) {
			case 'pt_BR':
				$mk = 'title_pt';
				break;
			case 'es_ES':
				$mk = 'title_es';
				break;
			case 'en_US':
				$mk = 'title_en';
				break;
		}
		$ob = 'meta_value';
	}
?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<h4><?php the_title(); ?></h4>
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
				}
				$loop = new WP_Query($args);
			?>
			<table>
				<tr>
					<th width="25%"><?php echo _e('Categories', 'refnet'); ?></th>
					<th width="60%"><?php echo _e('Subjects of search', 'refnet'); ?></th>
					<th width="15%"><?php echo _e('Access'); ?></th>
				</tr>
			<?php
				while ($loop->have_posts()) {
					$loop->the_post();
					$categories = get_the_category();
			?>
				<tr>
			<?php
					echo "<td>";
					if ($categories) {
						foreach ($categories as $category) {
							echo extract_text_by_language_markup($category->name);
							if (end($categories) != $category) {
								echo ", ";
							}
						}
					}
					echo "</td>";
			?>
					<td><a href="<?php the_permalink(); ?>"> <?php the_title();?></a></td>
			<?php
					echo "<td>";
					if (bir_has_no_empty_custom_field (get_the_ID(), array("lilacs_iahx_search_expression"))) {
                                                echo bir_show_search_rss_buttons(get_the_ID(), "lilacs_iahx_search_expression", "link");
                                        }
					if (bir_has_no_empty_custom_field (get_the_ID(), array("medline_iahx_search_expression"))) {
                                                echo " | " . bir_show_search_rss_buttons(get_the_ID(), "medline_iahx_search_expression", "link");
                                        }
					if (bir_has_no_empty_custom_field (get_the_ID(), array("cochrane_iahx_search_expression"))) {
                                                echo " | " . bir_show_search_rss_buttons(get_the_ID(), "cochrane_iahx_search_expression", "link");
                                        }
					echo "</td>";
				}
			?>
				</tr>
			</table>
		</div><!-- #content -->
		<?php wp_pagenavi( array('query' => $loop )); ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
