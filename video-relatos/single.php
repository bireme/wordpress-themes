<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php

    $current_language = strtolower(get_bloginfo('language'));
    $site_lang = substr($current_language, 0,2);

    if ($current_language != ''){
        $current_language = '_' . $current_language;
    }

    $level2 = "level2";

    if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
            $level2 .= $current_language;

?>
	<div class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>" class="home">Home</a> > <?php the_title(); ?></div>
	<div id="primary" class="site-content">
		<div id="content" class="single1column" role="main">
			<?php while ( have_posts() ) : the_post(); ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                        <header class="entry-header">
                                                <?php if ( is_single() ) : ?>
                                                        <h1 class="entry-title"><?php the_title(); ?></h1>
                                                <?php endif; // is_single() ?>
                                                <?php if ( comments_open() ) : ?>
                                                        <div class="comments-link">
                                                                <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
                                                        </div><!-- .comments-link -->
                                                <?php endif; // comments_open() ?>
                                        </header><!-- .entry-header -->
                                        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                                                <?php if ( is_single() ) : ?>
                                                <div class="entry-content">
                                                        <?php the_content(); ?>
                                                </div>
                                                <?php endif; ?>
                                        </div>
					<footer>
						<div class="thematic_area">
							<?php echo get_the_term_list( $post->ID, 'thematic_area', 'Temas: ', ', ' ); ?>
						</div>
						<div class="tags">
							<?php echo get_the_term_list($post->ID, 'post_tag', 'Tags: ', ', ',''); ?>
						</div>
					</footer>
                                </article>
                                <?php comments_template( '', true ); ?>
                        <?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
		<div class="single2column">
			<div class="whois r-block">
				<div class="r-block-title">Quem é</div>
				<div class="whois-name"><?php $key="autor"; echo get_post_meta($post->ID, $key, true); ?></div>
				<div class="whois-filiation"><?php $key="filiation"; echo get_post_meta($post->ID, $key, true); ?></div>
				<div class="whois-thumb">
					<?php the_post_thumbnail('thumbnail'); ?>
				</div>
				<?php $cv_link = get_post_meta($post->ID, 'curriculum', true);?>
					<?php
						if (!empty($cv_link)) {
						echo '<div class="cv-author">';
           	 				echo '<a href="' . get_post_meta($post->ID, 'curriculum', true) . '" target="_blank" >Veja curriculum Vitae</a> ';
						echo '</div>';
           				}
				?>
			</div>
			<div class="related_links r-block">
				<div class="r-block-title">Links Relacionados</div>
				<?php //$key="links_relacionados"; echo get_post_meta($post->ID, $key, true); ?>
				<?php
					$postmeta = get_post_meta($post->ID, 'links_relacionados', true);
					$doc = new DOMDocument();
					$doc->loadHTML($postmeta);
					$size = $doc->getElementsByTagName('a')->length;
					foreach($doc->getElementsByTagName('a') as $index => $href) { $index++;
						echo utf8_decode($doc->saveHTML($href));
						if ( $size > 5 && $index == 5 ) echo '<div style="display: none;">';
						if ( $size > 5 && $index == $size ) echo '</div><a class="more_like_that" style="display: block; text-align: right; text-decoration: underline; cursor: pointer;">>> Mostrar mais</a>';
					}
				?>
			</div>
			<div class="saiba_mais r-block">
                                <div class="r-block-title">Saiba Mais</div>
				<?php //$key="saiba_mais"; echo get_post_meta($post->ID, $key, true); ?>
				<?php
					$postmeta = get_post_meta($post->ID, 'saiba_mais', true);
					$doc = new DOMDocument();
					$doc->loadHTML($postmeta);
					$size = $doc->getElementsByTagName('a')->length;
					foreach($doc->getElementsByTagName('a') as $index => $href) { $index++;
						echo utf8_decode($doc->saveHTML($href));
						if ( $size > 5 && $index == 5 ) echo '<div style="display: none;">';
						if ( $size > 5 && $index == $size ) echo '</div><a class="more_like_that" style="display: block; text-align: right; text-decoration: underline; cursor: pointer;">>> Mostrar mais</a>';
					}
				?>
                        </div>
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>:
