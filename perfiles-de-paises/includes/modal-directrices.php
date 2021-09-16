<!------------------ Aspectos metodológicos y de procedimientos - Directrices y aspectos a evaluar: -->
<div class="modal fade" id="directrices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><small class="badge bg-light text-dark"><?php pll_e('Aspectos metodológicos y procedimentales'); ?></small> > <?php pll_e('Directrices y aspectos a evaluar'); ?>:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        $fichas = new WP_Query([
          'post_type' => 'fichas',
          'posts_per_page' => '-1'
        ]);
        while($fichas->have_posts()) : $fichas->the_post();
          $pais = get_field('pais');
          $bandera = get_field('bandera');
          $text = get_field('directrices_y_aspectos_a_evaluar');
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