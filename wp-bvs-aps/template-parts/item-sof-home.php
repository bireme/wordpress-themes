<?php
    global $sof;
    $response = file_get_contents('https://aps-repo.bvs.br/wp-json/wp/v2/teleconsultor?post='.$sof->id);
    $json = json_decode($response, true);
    $terms = wp_list_pluck( $json, 'name' ); 
?>
<div class="col-md-3 item-sof-home">
    <div class="content-sof">
        <label class="date-sof"><?php echo date_i18n('d M Y', strtotime($sof->date)); ?></label>
        <?php if ( $terms ) : ?>
            <label class="nucleo-sof"><?php echo implode(', ', $terms); ?></label>
        <?php endif; ?>
        <h3 class="title-sof"><a href="<?php echo $sof->link; ?>"><?php echo $sof->title->rendered; ?></a></h3>
        <div class="excerpt-sof">
            <?php crop_text(wp_strip_all_tags($sof->content->rendered), 130); ?>
        </div>
    </div>
</div>