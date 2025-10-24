<?php
// pega o ID do post/página atual (admin ou frontend)
$post_id = get_queried_object_id() ?: ( isset($post->ID) ? $post->ID : 0 );

// --- NOVO: cor de fundo (Reuniões) ---
$bg_meetings = $post_id ? get_post_meta( $post_id, '_lilacs_bg_meetings', true ) : '';
$section_style = '';
if ( $bg_meetings ) {
	$section_style = 'background-color:' . esc_attr( $bg_meetings ) . ';';
}
?>
<section class="lilacs-meetings" <?php if ( $section_style ) : ?> style="<?php echo esc_attr( $section_style ); ?>"<?php endif; ?>>
  <div class="container">
    <!-- ...existing markup... -->
  </div>
</section>