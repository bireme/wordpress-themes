<?php
/*
Template Name: Evid@Easy Template
*/

$lang = get_locale();
$site_lang = substr($lang, 0,2);

//include scripts for template page
function load_scripts_evideasy_template() {
  if ( is_page_template( 'template-evideasy.php' ) ) {
    wp_enqueue_style('evideasy-gfonts', 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap', false);
    wp_enqueue_style('bootstrap-evideasy-style', get_stylesheet_directory_uri() .'/assets-evideasy/css/bootstrap.min.css');
    wp_enqueue_style('evideasy-style', get_stylesheet_directory_uri() .'/assets-evideasy/css/style.css', array('bootstrap-evideasy-style', 'evideasy-gfonts'));
    wp_enqueue_script('evideasy-script', get_stylesheet_directory_uri() .'/assets-evideasy/js/scripts.js', array('jquery'), '1.0', false);
        //wp_enqueue_script('evideasy-responsivity-script', get_stylesheet_directory_uri() .'/assets-evideasy/js/responsivity.js', array('jquery'), '1.0', false);
  }
}
add_action( 'wp_enqueue_scripts', 'load_scripts_evideasy_template' );
get_header();
get_template_part('includes/nav');

if($site_lang == 'pt'){
  $subtitle = 'Evidências para apoiar suas decisões de saúde';    
  $label_selections = 'Suas seleções';
}
elseif($site_lang == 'en'){
  $subtitle = 'Evidence to support your health decisions';
  $label_selections = 'Your selections';
}
elseif($site_lang == 'fr'){
  $subtitle = 'Des preuves pour étayer vos décisions en matière de santé';
  $label_selections = 'Vos sélections';
}
else{ //es
  $subtitle = 'Evidencia para respaldar sus decisiones en salud';
  $label_selections = 'Sus selecciones';
}
?>

<section class="container padding1">
  <div class="middle">
    <div class="row d-none">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row grid-evid-easy" style="margin">
      <div class="col-md-12">
        <a href="#">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets-evideasy/img/evid-easy.png" alt="Evid@Easy Logo" class="img-fluid">
        </a>
        <p><?php echo $subtitle; ?></p>
      </div>
    </div>

    <div class="row grid-content-search">
      <div class="col-md-9">
        <h1 id="main-question"></h1>

        <div class="card grid-options">
          <div class="card-body">
            <ul></ul>
          </div>
        </div>

      </div>
      <div class="col-md-3">

        <div class="grid-selected-options">
          <label style="display: none;"><?php echo $label_selections; ?></label>
          <ul></ul>
        </div>
        <div class="grid-buttons" style="display: none;">
          <button id="btn-reset" type="button" class="btn btn-outline-primary">Cancelar</button>
          <button id="btn-search" type="button" class="btn btn-primary">Buscar</button>
        </div>

      </div>      
    </div>

    <?php if(!empty(get_the_content())){ ?>
      <div class="row">
        <div class="col-md-12">
          <?php the_content(); ?>
        </div>
      </div>
    <?php } ?>

    <br>

  </div>

  <div id="loader-spinner">
    <div class="spinner-border"></div>
  </div>
  <div id="loader-spinner-search" style="display: none;">
    <div class="spinner-border"></div>
  </div>
</section>
<?php get_footer(); ?>
