<?php
/** Publication detail, related content and native share action. */
get_header();
?>
<main id="main-content" class="site-main publication-detail-v4">
<?php while ( have_posts() ) : the_post();
$id = get_the_ID();
$type = function_exists('get_field') ? get_field('publication_type') : '';
$file = function_exists('get_field') ? get_field('publication_file') : null;
$link = function_exists('get_field') ? get_field('publication_external_link') : null;
$area = function_exists('get_field') ? get_field('publication_thematic_area') : null;
$area_id = is_object($area) ? (int)$area->ID : (int)$area;
?>
<article <?php post_class('publication-detail'); ?>>
<header class="publication-detail-heading unified-inner-hero"><div class="container">
<span class="section-kicker"><?php echo esc_html($type ?: __('Publicação','observatorio')); ?></span>
<h1><?php the_title(); ?></h1>
<?php if (has_excerpt()) : ?><p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
</div></header>
<?php get_template_part('template-parts/components/breadcrumbs'); ?>
<div class="container publication-detail-content"><div class="row g-5"><div class="col-lg-8">
<?php if(has_post_thumbnail()): ?><figure class="publication-featured-image mb-4"><?php the_post_thumbnail('large',array('class'=>'img-fluid rounded-4')); ?></figure><?php endif; ?>
<div class="entry-content"><?php the_content(); ?></div>
<div class="publication-share"><strong><?php esc_html_e('Compartilhar:', 'observatorio'); ?></strong>
<a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer" href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url='.rawurlencode(get_permalink())); ?>">LinkedIn</a>
<a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer" href="<?php echo esc_url('https://api.whatsapp.com/send?text='.rawurlencode(get_the_title().' '.get_permalink())); ?>">WhatsApp</a>
<button type="button" class="btn btn-outline-primary btn-sm publication-copy-link" data-url="<?php echo esc_attr(get_permalink()); ?>"><?php esc_html_e('Copiar link','observatorio'); ?></button>
</div></div><aside class="col-lg-4"><div class="publication-info-card">
<h2 class="h4"><?php esc_html_e('Sobre a publicação','observatorio'); ?></h2>
<?php if($type): ?><p><strong><?php esc_html_e('Tipo:','observatorio'); ?></strong><br><?php echo esc_html($type); ?></p><?php endif; ?>
<?php if($area_id): ?><p><strong><?php esc_html_e('Área temática:','observatorio'); ?></strong><br><a href="<?php echo esc_url(get_permalink($area_id)); ?>"><?php echo esc_html(get_the_title($area_id)); ?></a></p><?php endif; ?>
<p><strong><?php esc_html_e('Publicado em:','observatorio'); ?></strong><br><?php echo esc_html(get_the_date()); ?></p>
<?php if(is_array($file) && !empty($file['url'])): ?><a class="btn btn-primary w-100 mb-2" href="<?php echo esc_url($file['url']); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Abrir publicação','observatorio'); ?></a><?php endif; ?>
<?php if(is_array($link) && !empty($link['url'])): ?><a class="btn btn-outline-primary w-100" href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($link['title'] ?: __('Acessar publicação','observatorio')); ?></a><?php endif; ?>
</div></aside></div></div></article>
<?php
$meta_query = array('relation'=>'OR');
if($area_id) $meta_query[] = array('key'=>'publication_thematic_area','value'=>(string)$area_id,'compare'=>'=');
if($type) $meta_query[] = array('key'=>'publication_type','value'=>$type,'compare'=>'=');
$related_args = array('post_type'=>'publicacao','post_status'=>'publish','post__not_in'=>array($id),'posts_per_page'=>3,'ignore_sticky_posts'=>true);
if(count($meta_query)>1) $related_args['meta_query']=$meta_query;
else $related_args['post__in']=array(0); // No category or type: no unrelated suggestions.
$related = new WP_Query($related_args);
if($related->have_posts()): ?>
<section class="publication-related"><div class="container"><h2><?php esc_html_e('Outras publicações relacionadas','observatorio'); ?></h2><div class="row g-4">
<?php while($related->have_posts()): $related->the_post(); ?><div class="col-md-4"><article class="publication-related-card">
<?php if(has_post_thumbnail()): ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large'); ?></a><?php endif; ?>
<div class="publication-related-card__body"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><a class="card-action-arrow" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ver publicação: %s', 'observatorio' ), get_the_title() ) ); ?>"><span aria-hidden="true">→</span></a></div></article></div>
<?php endwhile; ?></div></div></section>
<?php endif; wp_reset_postdata(); ?>
<?php endwhile; ?>
</main>
<?php get_footer();
