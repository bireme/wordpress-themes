<?php
/** Shared visual header: args override page ACF fields. */
$defaults = array( 'kicker'=>'', 'title'=>'', 'description'=>'', 'image'=>'', 'position'=>'center' );
$hero = wp_parse_args( $args ?? array(), $defaults );
if ( is_page() ) {
 $id = get_queried_object_id();
 if ( function_exists( 'get_field' ) ) {
  foreach ( array('kicker'=>'page_hero_kicker','title'=>'page_hero_title','description'=>'page_hero_description','image'=>'page_hero_image','position'=>'page_hero_position') as $key=>$field ) {
   $value = get_field( $field, $id );
   if ( $value ) { $hero[$key] = $value; }
  }
 }
 if ( ! $hero['title'] ) { $hero['title'] = get_the_title( $id ); }
}
$image = is_array( $hero['image'] ) ? ( $hero['image']['url'] ?? '' ) : $hero['image'];
$position = in_array( $hero['position'], array('center','left','right'), true ) ? $hero['position'] : 'center';
?>
<header class="inner-page-hero inner-page-hero--<?php echo esc_attr($position); ?>"<?php if ($image): ?> style="--inner-hero-image:url('<?php echo esc_url($image); ?>')"<?php endif; ?>>
 <div class="container inner-page-hero__content">
 <?php if ($hero['kicker']): ?><span class="inner-page-hero__kicker"><?php echo esc_html($hero['kicker']); ?></span><?php endif; ?>
 <h1><?php echo esc_html($hero['title']); ?></h1>
 <?php if ($hero['description']): ?><p><?php echo esc_html($hero['description']); ?></p><?php endif; ?>
 </div>
</header>

<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
