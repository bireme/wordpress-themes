<?php
/** Filter the publication archive using existing ACF fields. GET forms keep links shareable. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
function observatorio_publication_filter_values( $key ) {
 $raw = isset( $_GET[ $key ] ) ? wp_unslash( $_GET[ $key ] ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
 return array_filter( array_map( 'sanitize_text_field', is_array( $raw ) ? $raw : array( $raw ) ) );
}
function observatorio_publication_archive_query( $query ) {
 if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'publicacao' ) ) { return; }
 $meta = array( 'relation' => 'AND' );
 $types = observatorio_publication_filter_values( 'publication_type' );
 if ( $types ) { $meta[] = array( 'key' => 'publication_type', 'value' => $types, 'compare' => 'IN' ); }
 $areas = array_filter( array_map( 'absint', observatorio_publication_filter_values( 'publication_area' ) ) );
 if ( $areas ) { $meta[] = array( 'key' => 'publication_thematic_area', 'value' => $areas, 'compare' => 'IN' ); }
 if ( count( $meta ) > 1 ) { $query->set( 'meta_query', $meta ); }
 $years = array_filter( array_map( 'absint', observatorio_publication_filter_values( 'publication_year' ) ) );
 if ( $years ) { $query->set( 'date_query', array( array( 'year' => $years[0] ) ) ); }
 $sort = isset( $_GET['publication_sort'] ) ? sanitize_key( wp_unslash( $_GET['publication_sort'] ) ) : 'newest'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
 if ( 'oldest' === $sort ) { $query->set( 'order', 'ASC' ); }
 if ( 'title' === $sort ) { $query->set( 'orderby', 'title' ); $query->set( 'order', 'ASC' ); }
 $query->set( 'posts_per_page', 15 );
}
add_action( 'pre_get_posts', 'observatorio_publication_archive_query' );
