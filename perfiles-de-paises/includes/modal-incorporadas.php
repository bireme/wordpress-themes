<!------------------ Cobertura en salud - TS incorporadas:-->
<div class="modal fade" id="tsincorporadas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title"><small class="badge bg-light text-dark"><?php pll_e('Cobertura en salud'); ?></small> > <?php pll_e('TS incorporadas'); ?>:</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <?php
      $country = (isset($_GET['country']) ) ? $_GET['country'] : '';
      $cmp = ( isset($_GET['country']) ) ? '=' : '!=';
      $fichas = new WP_Query(array(
        'post_type' => 'fichas',
        'post_status' => 'publish',
        'orderby' => 'title',
          'order'   => 'asc',
        'posts_per_page' => -1,
        'meta_query' => array(
          array(
            'key' => 'pais',
            'value' => $country,
            'compare' => $cmp,
          ),
        ),
      ));
      while($fichas->have_posts()) : $fichas->the_post();
        $pais = get_field('pais');
        $bandera = get_field('bandera');
        $text = get_field('ts_incorporadas');
        ?>
        <div class="<?php echo $text == '' ? "d-none" : ""; ?>">
          <img src="<?= esc_url($bandera['sizes']['flag']); ?>" alt="<?= $bandera['alt'] ?>"> <b><?=$pais; ?></b> <hr> 
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