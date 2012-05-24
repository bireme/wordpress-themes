<?php
/**
 * Single.php
 * O single é utilizado para exibição de posts e post-types, caso necessite um arquivo específico
 * para seu post-type copie esse arquivo como single-$posttype.php e faça as mudanças necessárias
 * Apresentação em 1 coluna com BreadCrumb
 */
get_header(); ?>
                        <div class="content index">
                                <div class="breadCrumb">
                                        <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a><span class="active"><?php wp_title('/',true,''); ?></span>
                                </div><!--/breadCrumb-->
                                <div class="spacer"></div><!--/spacer -->
                                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                                <h2><?php the_title(); ?></h3>
                                                <div class="the_content">
                                                         <?php the_content(); ?> 
                                                </div><!-- .the_contentt -->
                                                <? wp_list_pages("title_li=&post_type=vhl_collection&child_of=" . get_the_ID()); ?>
                                        </div><!-- #post-## -->
                                        <?php endwhile; // end of the loop. ?>
                        </div><!--/content -->
                        <div class="footer">
                                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
                                <?php endif; ?>
                        </div><!--/footer -->
                </div><!-- /container -->
        </body> 
</html>

