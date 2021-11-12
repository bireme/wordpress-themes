<?php /* Template Name: Fichas */ ?>
<?php
global $wp;
$current_url = home_url(add_query_arg(array(),$wp->request ));
$country = (isset($_GET['country']) ) ? $_GET['country'] : '';
?>
<?php get_header(); ?>
<main id="main_container" class="padding1 bg">
  <div class="container-fluid">
    <h1 class="title1">
      <?php pll_e('Ficha técnica del país'); ?>
    </h1>
    <div class="row mb-3">
      <label for="pais" class="col-sm-4 col-md-3 col-lg-2 col-form-label"><b><?php pll_e('Seleccionar país'); ?>:</b></label>
      <div class="col-sm-8 col-md-9 col-lg-10">
        <form action="">
          <select class="form-control" id="country" onchange="countryRedirect('<?php echo $current_url;?>');">
            <option value=""><?php pll_e('Seleccionar país'); ?></option>
            <?php 
            $fichas = new WP_Query([
              'post_type'         => 'fichas',
              'orderby'           =>'title',
              'order'             =>'ASC',
              'posts_per_page'    => -1,
            ]);
            while($fichas->have_posts()) : $fichas->the_post();
              $pais = get_field('pais');
              ?>
              <option value="<?php echo $pais; ?>" <?php echo ( $pais == $country ) ? 'selected' : ''; ?>><?php echo $pais; ?></option>
            <?php  endwhile; ?>
          </select>
        </form>
      </div>
    </div>
    <hr>
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
              <a href="#marcoLegal" data-toggle="modal"><?php pll_e('Marco legal y dependencia'); ?></a> <br>
              <a href="#estructura" data-toggle="modal"><?php pll_e('Estructura y Recursos'); ?></a>  <br>
              <a href="#redesColaboradores" data-toggle="modal"><?php pll_e('Redes y Colaboradores'); ?></a>
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
          <div class="card border-info bg2 divRelative m70">
            <div id="arrow2">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <a href="" data-toggle="modal" data-target="#priorizacion"><?php pll_e('Priorización de TS a evaluar'); ?></a>
            </div>
          </div>
        </div>

        <div class="col-12 col-md">
          <div class="card border-info bg2 bgW2 divRelative">
            <div id="arrow3">
              <img src="<?php bloginfo('template_directory'); ?>/img/arrowLeft.svg" alt="">
            </div>
            <div class="card-header">
              <a href="" data-toggle="modal" data-target="#evaluacion"> <?php pll_e('Evaluación de Tecnologías de Salud'); ?></a>
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
              <a href="" data-toggle="modal" data-target="#produtosETS"> <?php pll_e('Productos de ETS'); ?></a>
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
              <a href="#mecanismos" data-toggle="modal"><?php pll_e('Mecanismos de incorporación de TS'); ?></a>
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
              <a href="#tsincorporadas" data-toggle="modal"><?php pll_e('TS incorporadas'); ?></a>
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
              <a href="#!" data-toggle="modal"><?php pll_e('Uso de las Tecnologías de Salud'); ?></a>
            </div>
            <div class="card-body collapse" id="area4">
              <a href="#usoRacional" data-toggle="modal"><?php pll_e('Uso Racional'); ?></a> <br>
              <a href="#gpc" data-toggle="modal"><?php pll_e('GPC'); ?></a> <br>
              <a href="#monitoreo" data-toggle="modal"><?php pll_e('Monitoreo'); ?></a>
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
              <a href="#directrices" data-toggle="modal"><?php pll_e('Directrices y aspectos a evaluar'); ?></a> <br>
              <a href="#produccion" data-toggle="modal"><?php pll_e('Producción y ejecución'); ?></a> <br>
              <a href="#participacion" data-toggle="modal"><?php pll_e('Participación social'); ?></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md"></div>
        <div class="col-12 col-md">
          <div class="card border-info bg1">
            <div class="card-header">
              <a href="#procesos" data-toggle="modal"><?php pll_e('Procesos de desinversión'); ?></a>
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
              <a href="" data-toggle="modal" data-target="#autorizacion"><?php pll_e('Autorización de Mercado'); ?></a>
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







  <div id="mobile" class="d-md-none">
    <div class="row">
      
      <div class="col-12 mb1">
        <div class="card border-info bg4 arrowTop">
          <div class="card-header">
            <a href="" data-toggle="modal" data-target="#autorizacion"><?php pll_e('Autorización de Mercado'); ?></a>
          </div>
        </div>
      </div>

      <div class="col-12 mb1">
        <div class="card border-info bg2 divRelative">
          <div class="card-header">
            <a href="" data-toggle="modal" data-target="#priorizacion"><?php pll_e('Priorización de TS a evaluar'); ?></a>
          </div>
        </div>
      </div>

      <div class="col-12 mb1">
        <div class="card border-info bg2">
          <div class="card-header">
            <div class="float-right"><button type="button" data-target="#area1" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button ></div>
            <a href="#!"><?php pll_e('Configuración institucional y Gobernanza'); ?>: </a>
          </div>
          <div class="card-body collapse" id="area1">
            <a href="#marcoLegal" data-toggle="modal"><?php pll_e('Marco legal y dependencia'); ?></a> <br>
            <a href="#estructura" data-toggle="modal"><?php pll_e('Estructura y Recursos'); ?></a>  <br>
            <a href="#redesColaboradores" data-toggle="modal"><?php pll_e('Redes y Colaboradores'); ?></a>
          </div>
        </div>
      </div>


      <div class="col-12 mb1">
        <div class="card border-info bg2 bgW2 divRelative">

          <div class="card-header align-middle">
            <a href="" data-toggle="modal" data-target="#evaluacion"> <?php pll_e('Evaluación de Tecnologías de Salud'); ?></a>
          </div>
        </div>
      </div>


      <div class="col-12 mb1">
        <div class="card border-info bg2">
          <div class="card-header">
            <div class="float-right"><button type="button" data-target="#area5" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button></div>
            <a href="#!"><?php pll_e('Aspectos metodológicos y procedimentales'); ?></a>
          </div>
          <div class="card-body collapse" id="area5">
            <a href="#directrices" data-toggle="modal"><?php pll_e('Directrices y aspectos a evaluar'); ?></a>
            <a href="#produccion" data-toggle="modal"><?php pll_e('Producción y ejecución'); ?></a>
            <a href="#participacion" data-toggle="modal"><?php pll_e('Participación social'); ?></a>
          </div>
        </div>
      </div>




      <div class="col-12 mb1">
        <div class="card border-info bg2 divRelative m70">
          <div class="card-header">
            <a href="" data-toggle="modal" data-target="#produtosETS"> <?php pll_e('Productos de ETS'); ?></a>
          </div>
        </div>
      </div>




      <div class="col-12 mb1">
        <div class="card border-info bg3 bgW2 divRelative">
          <div class="card-header">
            <div class="float-right"><button type="button" data-target="#area2" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button ></div>
            <a href="#!"> <?php pll_e('Toma de decisiones en salud'); ?></a>
          </div>
          <div class="card-body collapse" id="area2">
            <a href="#mecanismos" data-toggle="modal"><?php pll_e('Mecanismos de incorporación de TS'); ?></a>
          </div>
        </div>
      </div>



      <div class="col-12 mb1">
        <div class="card border-info bg1 bgW1 divRelative">
          <div class="card-header">
            <div class="float-right"><button type="button" data-target="#area3" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button></div>
            <a href="#!"><div class="p20"><?php pll_e('Cobertura en salud'); ?></div></a>
          </div>
          <div class="card-body collapse" id="area3">
            <a href="#tsincorporadas" data-toggle="modal"><?php pll_e('TS incorporadas'); ?></a>
          </div>
        </div>
      </div>


      <div class="col-12 mb1">
        <div class="card border-info bg1 bgW1 divRelative">
          <div class="card-header">
            <div class="float-right"><button type="button" data-target="#area4" data-toggle="collapse" class="btn btn-sm btn-outline-light btnPlus"><i class="fas fa-chevron-down"></i></button></div>
            <a href="#!" data-toggle="modal"><?php pll_e('Uso de las Tecnologías de Salud'); ?></a>
          </div>
          <div class="card-body collapse" id="area4">
            <a href="#usoRacional" data-toggle="modal"><?php pll_e('Uso Racional'); ?></a> 
            <a href="#gpc" data-toggle="modal"><?php pll_e('GPC'); ?></a> 
            <a href="#monitoreo" data-toggle="modal"><?php pll_e('Monitoreo'); ?></a>
          </div>
        </div>
      </div>


      <div class="col-12 mb1">
        <div class="card border-info bg1">
          <div class="card-header">
            <a href="#procesos" data-toggle="modal"><?php pll_e('Procesos de desinversión'); ?></a>
          </div>
        </div>
      </div>



      





    </div>
  </div>
</main>


<?php get_template_part('includes/modais') ?>
<?php get_footer(); ?> 