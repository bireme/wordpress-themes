<?php
// pega o ID do post/página atual (admin ou frontend)
$post_id = get_queried_object_id() ?: ( isset($post->ID) ? $post->ID : 0 );

// --- NOVO: cor de fundo (Cards) ---
$bg_cards = $post_id ? get_post_meta( $post_id, '_lilacs_bg_cards', true ) : '';
$section_style = '';
if ( $bg_cards ) {
	$section_style = 'background-color:' . esc_attr( $bg_cards ) . ';';
}
?>
<section class="lilacs-cards" <?php if ( $section_style ) : ?> style="<?php echo esc_attr( $section_style ); ?>"<?php endif; ?>>
  <div class="container features" style="margin-top:0">
    <!-- Seção: Características principais -->
        <?php
        $features = [];
        for ( $f = 1; $f <= 3; $f++ ) {
        	$features[$f] = [
        		'title' => $post_id ? get_post_meta( $post_id, "_lilacs_feature_{$f}_title", true ) : '',
        		'text'  => $post_id ? get_post_meta( $post_id, "_lilacs_feature_{$f}_text", true ) : '',
        	];
        }
        
        // defaults (keeps original copy if no meta provided)
        $default_features = [
        	1 => ['title'=>'Base cooperativa', 'text'=>'Com mais de 1,13 milhão de registros, 2.600 revistas e 9 idiomas representados.'],
        	2 => ['title'=>'Rede colaborativa', 'text'=>'Mais de 30 países participam da Rede LILACS, integrando bibliotecas, editores e centros cooperantes.'],
        	3 => ['title'=>'Ciência aberta e regional', 'text'=>'Promove a democratização do conhecimento científico e técnico em saúde com foco na equidade.'],
        ];
        for ($f=1;$f<=3;$f++){
        	if ( ! $features[$f]['title'] ) $features[$f]['title'] = $default_features[$f]['title'];
        	if ( ! $features[$f]['text'] )  $features[$f]['text']  = $default_features[$f]['text'];
        }
        ?>
        <?php foreach ( $features as $feat ) : ?>
        <div class="feature-card">
            <div class="feature-icon">
                <!-- kept original svg icon for consistency -->
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
                </svg>
            </div>
            <h3><?php echo esc_html( $feat['title'] ); ?></h3>
            <p><?php echo wp_kses_post( wpautop( $feat['text'] ) ); ?></p>
        </div>
        <?php endforeach; ?>
  </div>
</section>