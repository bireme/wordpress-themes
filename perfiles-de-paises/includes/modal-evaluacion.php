<!------------------ Evaluación de Tecnologías de Salud: -->
<div class="modal fade" id="evaluacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php pll_e('Evaluación de Tecnologías de Salud'); ?>:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $country = ( isset($_GET['country']) && !empty($_GET['country']) ) ? $_GET['country'] : '';
        $cmp = ( isset($_GET['country']) && !empty($_GET['country']) ) ? '=' : '!=';
        $fichas = new WP_Query(array(
          'post_type'       => 'fichas',
          'post_status'     => 'publish',
          'orderby'         => 'title',
          'order'           => 'asc',
          'posts_per_page'  => -1,
          'meta_query'      => array(
            array(
              'key'         => 'pais',
              'value'       => $country,
              'compare'     => $cmp,
            ),
          ),
        ));
        while($fichas->have_posts()) : $fichas->the_post();
          $pais = get_field('pais');
          $bandera = get_field('bandera');
          $text = get_field('evaluacion_de_tecnologias_de_salud');
          ?>
          <div class="<?php echo $text == '' ? "d-none" : ""; ?>">
            <img src="<?= esc_url($bandera['sizes']['flag']); ?>" alt="<?= $bandera['alt'] ?>" class="thumbnail-flag"> <b><?=$pais; ?></b> <hr> 
            <?=$text; ?>
            <hr><br><br>
          </div>
          <?php 
        endwhile; 
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>