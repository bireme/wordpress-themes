<?php
/**
 * Home PrePrint and experience reports section.
 *
 * @package Observatorio
 */

$blocks = array(
 array(
  'title' => __( 'PrePrint', 'observatorio' ),
  'description' => function_exists( 'get_field' ) ? get_field( 'preprint_description', 'option' ) : '',
  'image' => function_exists( 'get_field' ) ? (int) get_field( 'preprint_image', 'option' ) : 0,
  'button' => function_exists( 'get_field' ) ? get_field( 'preprint_button', 'option' ) : array(),
  'class' => 'preprint-block',
 ),
 array(
  'title' => __( 'Relatos de Experiência', 'observatorio' ),
  'description' => function_exists( 'get_field' ) ? get_field( 'experience_reports_description', 'option' ) : '',
  'image' => function_exists( 'get_field' ) ? (int) get_field( 'experience_reports_image', 'option' ) : 0,
  'button' => function_exists( 'get_field' ) ? get_field( 'experience_reports_button', 'option' ) : array(),
  'class' => 'experience-reports-block',
 ),
);

$has_content = false;
foreach ( $blocks as $block ) {
 if ( $block['description'] || $block['image'] || ( is_array( $block['button'] ) && ! empty( $block['button']['url'] ) ) ) {
  $has_content = true;
  break;
 }
}
if ( ! $has_content ) {
 return;
}
?>
<section id="preprint" class="preprint-section">
 <div class="container">
  <div class="row g-3">
   <?php foreach ( $blocks as $block ) : ?>
    <?php
    $background = $block['image'] ? wp_get_attachment_image_url( $block['image'], 'full' ) : '';
    $style = $background ? '--preprint-image: url(\'' . esc_url( $background ) . '\');' : '';
    ?>
    <div class="col-lg-6">
     <div class="preprint-panel <?php echo esc_attr( $block['class'] ); ?>"<?php echo $style ? ' style="' . esc_attr( $style ) . '"' : ''; ?>>
      <div class="preprint-content">
       <h2><?php echo esc_html( $block['title'] ); ?></h2>
       <?php if ( $block['description'] ) : ?>
        <div class="preprint-description"><?php echo wp_kses_post( $block['description'] ); ?></div>
       <?php endif; ?>
       <?php if ( is_array( $block['button'] ) && ! empty( $block['button']['url'] ) && ! empty( $block['button']['title'] ) ) : ?>
        <a class="btn btn-outline-light mt-3" href="<?php echo esc_url( $block['button']['url'] ); ?>"<?php echo ! empty( $block['button']['target'] ) ? ' target="' . esc_attr( $block['button']['target'] ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $block['button']['title'] ); ?></a>
       <?php endif; ?>
      </div>
     </div>
    </div>
   <?php endforeach; ?>
  </div>
 </div>
</section>
