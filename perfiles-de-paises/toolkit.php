<?php /* Template Name: Toolkit */ ?>
<?php 
$home = new WP_Query([
  'post_type' => 'page',
  'pagename' => 'toolkit'
]);
while($home->have_posts()) : $home->the_post();
  $link_autorizacion_de_mercado = get_field('link_autorizacion_de_mercado');
  $link_priorizacion_de_ts_a_evaluar = get_field('link_priorizacion_de_ts_a_evaluar'); 
  $link_monitereo_del_horizonte_tecnologico = get_field('link_monitereo_del_horizonte_tecnologico');
  $link_marco_legal_y_dependencia = get_field('link_marco_legal_y_dependencia');
  $link_estructura_y_recursos = get_field('link_estructura_y_recursos');
  $link_redes_y_colaboradores = get_field('link_redes_y_colaboradores');
  $link_evaluacion_de_tecnologias_de_salud = get_field('link_evaluacion_de_tecnologias_de_salud');
  $link_directrices_y_aspectos_a_evaluar = get_field('link_directrices_y_aspectos_a_evaluar');
  $link_produccion_y_ejecucion = get_field('link_produccion_y_ejecucion');
  $link_participacion_social = get_field('link_participacion_social');
  $link_productos_de_ets = get_field('link_productos_de_ets');
  $link_mecanismos_de_incorporacion_de_ts = get_field('link_mecanismos_de_incorporacion_de_ts');
  $link_ts_incorporadas = get_field('link_ts_incorporadas');
  $link_procesos_de_desinversion = get_field('link_procesos_de_desinversion');
  $link_uso_racional = get_field('link_uso_racional');
  $link_gpc = get_field('link_gpc');
  $link_monitoreo = get_field('link_monitoreo');
endwhile;
?>

<?php get_header('secondary'); ?>
<main id="main_container" class="padding1 bg">
  <div class="container-fluid">
    <h1 class="title1"><?php pll_e('Toolkit'); ?></h1>
    <div id="desktop" class="d-none d-md-block">
      <!-- Linha 1 -->
      <div class="row dimension">
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md">
          <div class="card border-info bg2">
            <div class="card-header">
              <div class="float-right"><button type="button" data-target="#area1" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button ></div>
              <a href="#!"><?php pll_e('Configuración institucional y Gobernanza'); ?>: </a>
            </div>
            <div class="card-body collapse" id="area1">
              <a href="<?php echo $link_marco_legal_y_dependencia; ?>"><?php pll_e('Marco legal y dependencia'); ?></a> <br>
              <a href="<?php echo $link_estructura_y_recursos; ?>"><?php pll_e('Estructura y Recursos'); ?></a>  <br>
              <a href="<?php echo $link_redes_y_colaboradores; ?>"><?php pll_e('Redes y Colaboradores'); ?></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
      </div>
      <!-- Linha 2 -->
      <div class="row dimension">

        <div class="col-12 col-md">
          <div class="card border-info bg2 divRelative">
            <div id="arrow2">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <a href="<?php echo $link_monitereo_del_horizonte_tecnologico; ?>"><?php pll_e('Monitoreo del horizonte tecnológico'); ?></a>
            </div>
          </div>

          <div class="card border-info bg2 divRelative m30">
            <div id="arrow2">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <a href="<?php echo $link_priorizacion_de_ts_a_evaluar; ?>"><?php pll_e('Priorización de TS a evaluar'); ?></a>
            </div>
          </div>
        </div>

        <div class="col-12 col-md">
          <div class="card border-info bg2 bgW2 divRelative">
            <div id="arrow3">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <a href="<?php echo $link_evaluacion_de_tecnologias_de_salud; ?>"> <?php pll_e('Evaluación de Tecnologías de Salud'); ?></a>
            </div>
            <div class="card-body collapse">
            </div>
          </div>
        </div>
        <div class="col-12 col-md">
          <div class="card border-info bg2 bgW1 divRelative">
            <div id="arrow4">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header p30">
              <a href="<?php echo $link_productos_de_ets; ?>"> <?php pll_e('Productos de ETS'); ?></a>
            </div>
            <div class="card-body collapse">
            </div>
          </div>
        </div>
        <div class="col-12 col-md">
          <div class="card border-info bg3 bgW2 divRelative">
            <div id="arrow5">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div id="arrow5B">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <div class="float-right"><button type="button" data-target="#area2" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button ></div>
              <a href="#!"> <?php pll_e('Toma de decisiones en salud'); ?></a>
            </div>
            <div class="card-body collapse" id="area2">
              <a href="<?php echo $link_mecanismos_de_incorporacion_de_ts; ?>"><?php pll_e('Mecanismos de incorporación de TS'); ?></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md">
          <div class="card border-info bg1 bgW1 divRelative">
            <div id="arrow6">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <div class="float-right"><button type="button" data-target="#area3" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button></div>
              <a href="#!"><div class="p20"><?php pll_e('Cobertura en salud'); ?></div></a>
            </div>
            <div class="card-body collapse" id="area3">
              <a href="<?php echo $link_ts_incorporadas; ?>"><?php pll_e('TS incorporadas'); ?></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md">
          <div class="card border-info bg1 bgW1 divRelative">
            <div id="arrow7">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowRight.svg" alt="">
            </div>
            <div class="card-header">
              <div class="float-right"><button type="button" data-target="#area4" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button></div>
              <a href="#!"><?php pll_e('Uso de las Tecnologías de Salud'); ?></a>
            </div>
            <div class="card-body collapse" id="area4">
              <a href="<?php echo $link_uso_racional; ?>"><?php pll_e('Uso Racional'); ?></a> <br>
              <a href="<?php echo $link_gpc; ?>"><?php pll_e('GPC'); ?></a> <br>
              <a href="<?php echo $link_monitoreo; ?>"><?php pll_e('Monitoreo'); ?></a>
            </div>
          </div>
        </div>
      </div>
      <!-- linha 3 -->
      <div class="row dimension">
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md">
          <div class="card border-info bg2">
            <div class="card-header">
              <div class="float-right"><button type="button" data-target="#area5" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button></div>
              <a href="#!"><?php pll_e('Aspectos metodológicos y procedimentales'); ?></a>
            </div>
            <div class="card-body collapse" id="area5">
              <a href="<?php echo $link_directrices_y_aspectos_a_evaluar; ?>"><?php pll_e('Directrices y aspectos a evaluar'); ?></a> <br>
              <a href="<?php echo $link_produccion_y_ejecucion; ?>"><?php pll_e('Producción y ejecución'); ?></a> <br>
              <a href="<?php echo $link_participacion_social; ?>"><?php pll_e('Participación social'); ?></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md">
          <div class="card border-info bg1">
            <div class="card-header">
              <a href="<?php echo $link_procesos_de_desinversion; ?>"><?php pll_e('Procesos de desinversión'); ?></a>
            </div>
            <div class="card-body collapse">
            </div>
          </div>
        </div>
        <div class="col-12 col-md"></div>
      </div>
      <!-- linha 4 -->
      <div class="row dimension">
        <div class="col-12 col-md divRelative">
          <div id="arrow1">
            <img src="<?php bloginfo('template_directory'); ?>/img/arrowUp.svg" alt="">
          </div>
          <div class="card border-info bg4 arrowTop">
            <div class="card-header">
              <a href="<?php echo $link_autorizacion_de_mercado; ?>"><?php pll_e('Autorización de Mercado'); ?></a>
            </div>
            <div class="card-body collapse">
            </div>
          </div>
        </div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
      </div>
    </div>
  </div>
</main>


<?php get_template_part('includes/modais') ?>
<?php get_footer(); ?> 