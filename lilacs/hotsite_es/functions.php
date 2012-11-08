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

                                    <a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">

                                        <?php the_post_thumbnail(); ?>

                                    </a>

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

      register_sidebar_widget('Temas Destacados',

          'widget_temas_destacados');
  


function widget_PesquisaLILACSwidget($args) {

      extract($args);

      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . 'Pesquisa'
                      . $after_title; ?>

                      <form action="http://pesquisa.bvsalud.org/regional/" method="get" name="searchForm"><input type="hidden" value="pt" name="lang"><input type="hidden" name="home_url" value="<?php bloginfo('url') ?>"><input type="hidden" name="home_text" value="Portal LILACS"><input type="hidden" value="" name="_charset_"><input type="text" value="" class="expression midium defaultValue" name="q" id="textEntry1"><div style="display: inline;" id="search00"><select name="index" class="inputText mini"><option value="" selected="true">Todos os índices</option><option value="ti">Título</option><option value="au">Autor</option><option value="mh_words">Assunto</option></select><select name="where" class="inputText mini"><option value="ALL">Todas as fontes</option><option value="GENERAL">Ciências da Saúde em Geral</option><option value="LILACS" class="subGroup" selected="true">LILACS</option><option value="IBECS" class="subGroup">IBECS</option><option value="MEDLINE" class="subGroup">MEDLINE</option><option value="COCHRANE">Biblioteca Cochrane</option><option value="SPECIALIZED">Áreas Especializadas</option><option value="CIDSAUDE" class="subGroup">CidSaúde</option><option value="DESASTRES" class="subGroup">DESASTRES</option><option value="MEDCARIB" class="subGroup">MedCarib</option><option value="REPIDISCA" class="subGroup">REPIDISCA</option><option value="INTERNATIONAL">Organismos Internacionais</option><option value="PAHO" class="subGroup">PAHO</option><option value="WHOLIS" class="subGroup">WHOLIS</option><option value="SITES">LIS - Localizador de Informação em Saúde</option><option value="DECS">DeCS - Descritores em Ciências da Saúde</option><option value="CVSP">Repositório CVSP</option><option value="COCHRANE-REVIEWS" class="subGroup">Revisões sistemáticas da Cochrane</option><option value="COCHRANE-PROTOCOLS" class="subGroup">Protocolos de revisões sistemáticas da Cochrane</option><option value="COCHRANE-CENTRAL" class="subGroup">CENTRAL - Registro de ensaios clinicos controlados</option><option value="COCHRANE-CMR" class="subGroup">Registro Cochrane de metodologia</option><option value="COCHRANE-HTA" class="subGroup">Resumos do INAHTA e de outras agências</option><option value="COCHRANE-EED_BIBLIO" class="subGroup">Outros estudos econômicos NHS-EED</option><option value="COCHRANE-EED_ABSTRACTS" class="subGroup">Avaliações econômicas revisadas NHS-EED</option><option value="COCHRANE-DARE_ABSTRACTS" class="subGroup">Resumos de revisões sistemáticas com qualidade avaliada</option><option value="COCHRANE-AGENCIAS" class="subGroup">Agências Ibero-americanas de Avaliação de Tecnologias Sanitárias</option><option value="COCHRANE-BANDOLIER" class="subGroup">Bandolier</option><option value="COCHRANE-CLIBPLUSREFS" class="subGroup">Registro de Ensaios Clínicos Ibero-americanos</option><option value="COCHRANE-EVIDARGENT" class="subGroup">Evidência. Atualização na prática ambulatória</option><option value="COCHRANE-GESTION" class="subGroup">Relatórios de gestão clínica e sanitária</option><option value="COCHRANE-KOVACS" class="subGroup">Estudos sobre dor nas costas</option></select><input type="submit" class="submit" name="submit" value="Pesquisar"></div><div style="display: none;" id="search01"><input type="submit" class="submit" name="submit" value="Pesquisar"></div><div class="searchItens"></div><div class="search_advanced"><a href="http://bases.bireme.br/cgi-bin/wxislind.exe/iah/online/?IsisScript=iah/iah.xis&base=LILACS&lang=p&form=A">Pesquisa via formulário iAH</a></div></form>

             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('Pesquisa na BVS',

          'widget_PesquisaLILACSwidget');

function widget_PesquisaLILACS_ES_widget($args) {

      extract($args);

      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . 'Búsqueda'
                      . $after_title; ?>

			<form name="searchForm" action="http://pesquisa.bvsalud.org/regional/" method="get"><input type="hidden" value="pt" name="lang"><input type="hidden" name="home_url" value="<?php bloginfo('url') ?>"><input type="hidden" name="lang" value="es"><input type="hidden" name="_charset_" value=""><input type="text" id="textEntry1" name="q" class="expression midium defaultValue" value=""><div id="search00" style="display: inline;"><select class="inputText mini" name="index"><option selected="true" value="">Todos los índices</option><option value="ti">Título</option><option value="au">Autor</option><option value="mh_words">Asunto</option></select><select class="inputText mini" name="where"><option value="ALL">Todas las fuentes</option><option value="GENERAL">Ciencias de la Salud en General</option><option class="subGroup" value="LILACS" selected="true">LILACS</option><option class="subGroup" value="IBECS">IBECS</option><option class="subGroup" value="MEDLINE">MEDLINE</option><option value="COCHRANE">Biblioteca Cochrane</option><option value="SPECIALIZED">Áreas Especializadas</option><option class="subGroup" value="CIDSAUDE">CidSaúde</option><option class="subGroup" value="DESASTRES">DESASTRES</option><option class="subGroup" value="MEDCARIB">MedCarib</option><option class="subGroup" value="REPIDISCA">REPIDISCA</option><option value="INTERNATIONAL">Organismos Internacionales</option><option class="subGroup" value="PAHO">PAHO</option><option class="subGroup" value="WHOLIS">WHOLIS</option><option value="SITES">LIS - Localizador de Información en Salud</option><option value="DECS">DeCS - Descriptores en Ciencias de la Salud</option><option value="CVSP">Repositorio CVSP</option><option class="subGroup" value="COCHRANE-REVIEWS">Revisiones Sistemáticas de la Cochrane</option><option class="subGroup" value="COCHRANE-PROTOCOLS">Protocolos de Revisiones Sistemática de la Cochrane</option><option class="subGroup" value="COCHRANE-CENTRAL">CENTRAL - Registro de ensayos clínicos controlados</option><option class="subGroup" value="COCHRANE-CMR">Registro Cochrane de metodologia</option><option class="subGroup" value="COCHRANE-HTA">Resúmenes del INAHTA</option><option class="subGroup" value="COCHRANE-EED_BIBLIO">Otros estudios económicos NHS-EED</option><option class="subGroup" value="COCHRANE-EED_ABSTRACTS">Resumenes de evaluación económica NHS-EED</option><option class="subGroup" value="COCHRANE-DARE_ABSTRACTS">Resumenes de revisión sistemática con calidad evaluada DARE</option><option class="subGroup" value="COCHRANE-AGENCIAS">Agencias Iberoamericanas de Evaluación de Tecnologías Sanitarias</option><option class="subGroup" value="COCHRANE-BANDOLIER">Bandolier</option><option class="subGroup" value="COCHRANE-CLIBPLUSREFS">Registro de ensayos clínicos Iberoamericanos</option><option class="subGroup" value="COCHRANE-EVIDARGENT">Evidencia. Actualización en la práctica ambulatoria</option><option class="subGroup" value="COCHRANE-GESTION">Informes de Gestión Clínica y Sanitaria</option><option class="subGroup" value="COCHRANE-KOVACS">Estudios sobre las dolencias de espalda</option></select><input type="submit" value="Buscar" name="submit" class="submit"></div><div id="search01" style="display: none;"><input type="submit" value="Buscar" name="submit" class="submit"></div><div class="search_advanced"><a href="http://bases.bireme.br/cgi-bin/wxislind.exe/iah/online/?IsisScript=iah/iah.xis&base=LILACS&lang=e&form=A">Búsqueda via formulario iAH</a></div></form>

             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('Búsqueda en la BVS',

          'widget_PesquisaLILACS_ES_widget');


function widget_PesquisaLILACS_EN_widget($args) {

      extract($args);

      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . 'Search'
                      . $after_title; ?>

			<form name="searchForm" action="http://search.bvsalud.org/regional/" method="get"><input type="hidden" value="pt" name="lang"><input type="hidden" name="home_url" value="<?php bloginfo('url') ?>"><input type="hidden" name="lang" value="en"><input type="hidden" name="_charset_" value=""><input type="text" id="textEntry1" name="q" class="expression midium defaultValue" value=""><div id="search00" style="display: inline;"><select class="inputText mini" name="index"><option selected="true" value="">All indexes</option><option value="ti">Title</option><option value="au">Author</option><option value="mh_words">Subject</option></select><select class="inputText mini" name="where"><option value="ALL">All sources</option><option value="GENERAL">General Health Sciences</option><option class="subGroup" value="LILACS" selected="true">LILACS</option><option class="subGroup" value="IBECS">IBECS</option><option class="subGroup" value="MEDLINE">MEDLINE</option><option value="COCHRANE">Cochrane Library</option><option value="SPECIALIZED">Specialized Areas</option><option class="subGroup" value="CIDSAUDE">CidSaúde</option><option class="subGroup" value="DESASTRES">DESASTRES</option><option class="subGroup" value="MEDCARIB">MedCarib</option><option class="subGroup" value="REPIDISCA">REPIDISCA</option><option value="INTERNATIONAL">International Agencies</option><option class="subGroup" value="PAHO">PAHO</option><option class="subGroup" value="WHOLIS">WHOLIS</option><option value="SITES">HIL- Health Information Locator</option><option value="DECS">DeCS - Health Sciences Descriptores</option><option value="CVSP">VCHP Repository</option><option class="subGroup" value="COCHRANE-REVIEWS">Cochrane systematic reviews</option><option class="subGroup" value="COCHRANE-PROTOCOLS">Protocols of Cochrane systematic reviews</option><option class="subGroup" value="COCHRANE-CENTRAL">CENTRAL-The Cochrane controlled trials register</option><option class="subGroup" value="COCHRANE-CMR">The Cochrane Methodology Register</option><option class="subGroup" value="COCHRANE-HTA">Abstracts by INAHTA and other healthcare technology agencies</option><option class="subGroup" value="COCHRANE-EED_BIBLIO">Other economic studies NHS-EED</option><option class="subGroup" value="COCHRANE-EED_ABSTRACTS">Critically appraised economic evaluations NHS-EED</option><option class="subGroup" value="COCHRANE-DARE_ABSTRACTS">Abstracts of quality assessed systematic reviews</option><option class="subGroup" value="COCHRANE-AGENCIAS">Ibero-American Agencies of Assessment of Health Technologies</option><option class="subGroup" value="COCHRANE-BANDOLIER">Bandolier</option><option class="subGroup" value="COCHRANE-CLIBPLUSREFS">Ibero-American Clinical Trials Registry</option><option class="subGroup" value="COCHRANE-EVIDARGENT">Evidence. Updating in ambulatory practice</option><option class="subGroup" value="COCHRANE-GESTION">Reports on Clinical and Health Management</option><option class="subGroup" value="COCHRANE-KOVACS">Trials on spinal pathologies - Kovacs</option></select><input type="submit" value="Search" name="submit" class="submit"></div><div id="search01" style="display: none;"><input type="submit" value="Search" name="submit" class="submit"></div><div class="search_advanced"><a href="http://bases.bireme.br/cgi-bin/wxislind.exe/iah/online/?IsisScript=iah/iah.xis&base=LILACS&lang=e&form=A">Search by iAH form</a></div></form>

             <?php echo $after_widget; ?>

      <?php

      }

      register_sidebar_widget('VHL Search',

          'widget_PesquisaLILACS_EN_widget');



?>
