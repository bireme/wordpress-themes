<?php
/** Publications archive with reusable components and native WordPress filtering. */
get_header();
$types = array();
$publication_ids = get_posts( array( 'post_type' => 'publicacao', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids', 'suppress_filters' => false ) );
$years = array();
foreach ( $publication_ids as $publication_id ) {
 $type = get_post_meta( $publication_id, 'publication_type', true );
 if ( is_string( $type ) && $type !== '' ) { $types[ $type ] = $type; }
 $year = get_the_date( 'Y', $publication_id );
 if ( $year ) { $years[ $year ] = $year; }
}
natcasesort( $types ); rsort( $years );
$areas = get_posts( array( 'post_type' => 'area_tematica', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
$selected_type = observatorio_publication_filter_values( 'publication_type' );
$selected_area = observatorio_publication_filter_values( 'publication_area' );
$selected_year = observatorio_publication_filter_values( 'publication_year' );
$sort = isset( $_GET['publication_sort'] ) ? sanitize_key( wp_unslash( $_GET['publication_sort'] ) ) : 'newest'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<main id="main-content" class="site-main publications-archive">
<?php get_template_part( 'template-parts/components/page-hero', null, array( 'kicker' => __( 'Publicações', 'observatorio' ), 'title' => __( 'Evidências e análises para apoiar decisões em saúde', 'observatorio' ), 'description' => __( 'Policy briefs, análises rápidas e outros materiais técnicos que reúnem evidências, dados e experiências sobre políticas, sistemas e inovação em saúde.', 'observatorio' ), 'image' => function_exists( 'get_field' ) ? ( get_field( 'publications_hero_image', 'option' ) ?: '' ) : '' ) ); ?>
<section class="container publication-results-section"><div class="publication-results-layout">
<aside class="publication-filters"><form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'publicacao' ) ); ?>" id="publication-filters-form">
<div class="publication-filters__heading"><h2><?php esc_html_e( 'Filtrar resultados', 'observatorio' ); ?></h2><a href="<?php echo esc_url( get_post_type_archive_link( 'publicacao' ) ); ?>"><?php esc_html_e( 'Limpar filtros', 'observatorio' ); ?></a></div>
<fieldset><legend><?php esc_html_e( 'Tipo de conteúdo', 'observatorio' ); ?></legend>
<?php foreach ( $types as $type ) : ?><label><input type="checkbox" name="publication_type[]" value="<?php echo esc_attr( $type ); ?>" <?php checked( in_array( $type, $selected_type, true ) ); ?>> <?php echo esc_html( $type ); ?></label><?php endforeach; ?>
</fieldset><fieldset><legend><?php esc_html_e( 'Área temática', 'observatorio' ); ?></legend>
<?php foreach ( $areas as $area ) : ?><label><input type="checkbox" name="publication_area[]" value="<?php echo esc_attr( $area->ID ); ?>" <?php checked( in_array( (string) $area->ID, $selected_area, true ) ); ?>> <?php echo esc_html( $area->post_title ); ?></label><?php endforeach; ?>
</fieldset><fieldset><legend><?php esc_html_e( 'Ano', 'observatorio' ); ?></legend>
<?php foreach ( $years as $year ) : ?><label><input type="radio" name="publication_year[]" value="<?php echo esc_attr( $year ); ?>" <?php checked( in_array( (string) $year, $selected_year, true ) ); ?>> <?php echo esc_html( $year ); ?></label><?php endforeach; ?>
</fieldset>
<?php if ( function_exists( 'pll_languages_list' ) ) : $languages = pll_languages_list( array( 'fields' => 'slug' ) ); if ( count( $languages ) > 1 ) : ?>
<fieldset><legend><?php esc_html_e( 'Idioma', 'observatorio' ); ?></legend><p class="publication-filters__hint"><?php esc_html_e( 'Selecione o idioma pelo menu de idiomas do site.', 'observatorio' ); ?></p></fieldset>
<?php endif; endif; ?>
<input type="hidden" name="publication_sort" value="<?php echo esc_attr( $sort ); ?>"><button class="btn btn-primary w-100" type="submit"><?php esc_html_e( 'Aplicar filtros', 'observatorio' ); ?></button>
</form></aside>
<div class="publication-results"><div class="publication-results__toolbar"><span><?php printf( esc_html( _n( '%s resultado', '%s resultados', $wp_query->found_posts, 'observatorio' ) ), esc_html( number_format_i18n( $wp_query->found_posts ) ) ); ?></span>
<label><?php esc_html_e( 'Ordenar por', 'observatorio' ); ?> <select id="publication-sort" aria-label="<?php esc_attr_e( 'Ordenar publicações', 'observatorio' ); ?>"><option value="newest" <?php selected( $sort, 'newest' ); ?>><?php esc_html_e( 'Mais recentes', 'observatorio' ); ?></option><option value="oldest" <?php selected( $sort, 'oldest' ); ?>><?php esc_html_e( 'Mais antigos', 'observatorio' ); ?></option><option value="title" <?php selected( $sort, 'title' ); ?>><?php esc_html_e( 'Título A–Z', 'observatorio' ); ?></option></select></label></div>
<?php if ( have_posts() ) : ?><div class="publication-results__cards"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/publications/publication-card' ); endwhile; ?></div>
<div class="archive-pagination mt-4"><?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '←', 'next_text' => '→', 'add_args' => array_filter( array( 'publication_type' => $selected_type, 'publication_area' => $selected_area, 'publication_year' => $selected_year, 'publication_sort' => $sort ) ) ) ); ?></div>
<?php else : ?><p class="publication-empty"><?php esc_html_e( 'Nenhuma publicação encontrada para os filtros selecionados.', 'observatorio' ); ?></p><?php endif; ?>
</div></div></section>
<?php get_template_part( 'template-parts/components/newsletter-banner' ); ?>
</main>
<script>document.addEventListener('DOMContentLoaded',function(){var select=document.getElementById('publication-sort'),form=document.getElementById('publication-filters-form');if(select&&form){select.addEventListener('change',function(){form.querySelector('[name="publication_sort"]').value=this.value;form.submit();});}});</script>
<?php get_footer();
