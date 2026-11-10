<?php
/** One publication in archive. */
$type = function_exists( 'get_field' ) ? get_field( 'publication_type' ) : '';
$area = function_exists( 'get_field' ) ? get_field( 'publication_thematic_area' ) : 0;
$area_name = $area ? get_the_title( $area ) : '';
?>
<article <?php post_class( 'archive-publication-card' ); ?>>
 <div class="archive-publication-card__image">
 <?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>"><?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?></a><?php endif; ?>
 <?php if ( $type ) : ?><span class="archive-publication-card__badge"><?php echo esc_html( $type ); ?></span><?php endif; ?>
 </div>
 <div class="archive-publication-card__body">
 <?php if ( $area_name ) : ?><span class="archive-publication-card__area"><?php echo esc_html( $area_name ); ?></span><?php endif; ?>
 <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
 <p><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 34 ) ); ?></p>
 <div class="archive-publication-card__footer"><span>▢ <?php echo esc_html( get_the_date( 'F Y' ) ); ?></span>
 <a href="<?php the_permalink(); ?>" class="card-action-arrow" aria-label="<?php echo esc_attr( sprintf( __( 'Ver publicação: %s', 'observatorio' ), get_the_title() ) ); ?>"><span aria-hidden="true">→</span></a></div>
 </div>
</article>
