<?php

if ( function_exists('register_sidebar') )

register_sidebar(array('name'=>'Coluna_1',

        'before_widget' => '<div id="%1$s" class="widget %2$s">',

        'after_widget' => '</div>',

        'before_title' => '<h2 class="widgettitle">',

        'after_title' => '</h2>',

    ));

if ( function_exists('register_sidebar') )

register_sidebar(array('name'=>'Coluna_2',

        'before_widget' => '<div id="%1$s" class="widget %2$s">',

        'after_widget' => '</div>',

        'before_title' => '<h2 class="widgettitle">',

        'after_title' => '</h2>',

    ));

if ( function_exists('register_sidebar') )

register_sidebar(array('name'=>'Coluna_3',

        'before_widget' => '<div id="%1$s" class="widget %2$s">',

        'after_widget' => '</div>',

        'before_title' => '<h2 class="widgettitle">',

        'after_title' => '</h2>',

    ));



if (function_exists('add_theme_support')) {

        add_theme_support('post-thumbnails');

        set_post_thumbnail_size(195, 55, true);

        add_image_size('feature', 225, 132, true);

        add_image_size('mini_thumb', 100, 100, true);

}



function widget_topicwidget($args) {

      extract($args);

      ?>

              <?php echo $before_widget; ?>

                  <?php echo $before_title

                      . 'Topic-Specific Queries'

                      . $after_title; ?>



                      <div class="topicBox">

                <ul>

                    <?php query_posts('category_name=topic-specific-queries&showposts=2'); ?>

                    <?php if (have_posts()) : ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <li class="topic" id="post-<?php the_ID(); ?>">

                        <h4><?php the_title(); ?></h4>

                                <div class="thumb">

                                    <!--a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"-->

                                        <?php the_post_thumbnail(); ?>

                                    <!--/a-->

                                </div>

                                <span class="resumo">

                                    <a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">

                                        <?php the_content(); ?>

                                    </a>

                                </span>

                        </li>

                    <?php endwhile; else: ?>

                    <p><?php _e('Sorry, no posts matched your criteria.'); ?> </p>

                    <?php endif; ?>

                    <div class="spacer"></div>

                </ul><!--/highlight-->

        </div>



             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('Topic-Specific Queries',

          'widget_topicwidget');

function widget_temas_destaque($args) {

      extract($args);

      ?>

              <?php echo $before_widget; ?>

                  <?php echo $before_title

                      . 'Temas em Destaque'

                      . $after_title; ?>



                      <div class="topicBox">

                <ul>

                    <?php query_posts('category_name=temas-em-destaque&showposts=2'); ?>

                    <?php if (have_posts()) : ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <li class="topic" id="post-<?php the_ID(); ?>">

                        <h4><?php the_title(); ?></h4>

                                <div class="thumb">

                                    <!--a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"-->

                                        <?php the_post_thumbnail(); ?>

                                    <!--/a-->

                                </div>

                                <span class="resumo">

                                    <!--a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">



                                    </a-->         <?php the_content(); ?>

                                </span>

                        </li>

                    <?php endwhile; else: ?>

                    <p><?php _e('Sorry, no posts matched your criteria.'); ?> </p>

                    <?php endif; ?>

                    <div class="spacer"></div>

                </ul><!--/highlight-->

        </div>



             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('Temas em Destaque',

          'widget_temas_destaque');

function widget_temas_destacados($args) {

      extract($args);

      ?>

              <?php echo $before_widget; ?>

                  <?php echo $before_title

                      . 'Temas Destacados'

                      . $after_title; ?>



                      <div class="topicBox">

                <ul>

                    <?php query_posts('category_name=temas-destacados&showposts=2'); ?>

                    <?php if (have_posts()) : ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <li class="topic" id="post-<?php the_ID(); ?>">

                        <h4><?php the_title(); ?></h4>

                                <div class="thumb">

                                    <a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">

                                        <?php the_post_thumbnail(); ?>

                                    </a>

                                </div>

                                <span class="resumo">

                                    <a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">

                                        <?php the_content(); ?>

                                    </a>

                                </span>

                        </li>

                    <?php endwhile; else: ?>

                    <p><?php _e('Sorry, no posts matched your criteria.'); ?> </p>

                    <?php endif; ?>

                    <div class="spacer"></div>

                </ul><!--/highlight-->

        </div>



             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('Temas Destacados',

          'widget_temas_destacados');



function widget_PesquisaLILACSwidget($args) {

      extract($args);

      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . 'Pesquisa'
                      . $after_title; ?>

                      <form action="http://pesquisa.bvsalud.org/portal/" method="post" name="searchForm">
                          <input type="hidden" value="pt" name="lang">
                          <input type="hidden" name="home_url" value="<?php bloginfo('url') ?>">
                          <input type="hidden" name="home_text" value="Portal LILACS">
                          <input type="hidden" name="filter[db][]" value="LILACS">
                          <input type="text" value="" class="expression midium defaultValue" name="q" id="textEntry1">
                          <div style="display: inline;" id="search00">
                              <select name="index" class="inputText mini">
                                  <option value="" selected="true">Todos os índices</option>
                                  <option value="ti">Título</option>
                                  <option value="au">Autor</option>
                                  <option value="mh_words">Assunto</option>
                              </select>
                              <input type="submit" class="submit" name="submit" value="Pesquisar">
                          </div>
                          <div style="display: none;" id="search01">
                              <input type="submit" class="submit" name="submit" value="Pesquisar">
                          </div>
                          <div class="searchItens">
                          </div>
                          <div class="search_advanced"><a href="http://pesquisa.bvsalud.org/portal/advanced?lang=pt">Pesquisa avançada</a></div></form>

             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('Pesquisa na BVS',

          'widget_PesquisaLILACSwidget');


?>
