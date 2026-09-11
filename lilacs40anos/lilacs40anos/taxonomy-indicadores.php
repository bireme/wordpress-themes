<?php
/**
 * Template: Taxonomy indicadores
 * Mostra cards do CPT "indicador" filtrados pelo termo atual da taxonomia "indicadores"
 */
if (!defined('ABSPATH')) exit;

get_header();

$term = get_queried_object();
$term_name = ($term && !is_wp_error($term)) ? $term->name : 'Nome do arquivo';
$term_desc = ($term && !is_wp_error($term)) ? term_description($term) : '';

$view   = (isset($_GET['view']) && $_GET['view'] === 'list') ? 'list' : 'grid';
$search = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
$paged  = max(1, (int) get_query_var('paged'));

// Link "Indicadores" no breadcrumb (archive do CPT)
$indicadores_url = get_post_type_archive_link('indicador');
if (empty($indicadores_url)) {
  $indicadores_url = home_url('/indicador/');
}

$args = [
  'post_type'      => 'indicador',
  'post_status'    => 'publish',
  'paged'          => $paged,
  's'              => $search,
  'tax_query'      => [
    [
      'taxonomy' => 'indicadores',
      'field'    => 'term_id',
      'terms'    => $term ? (int) $term->term_id : 0,
    ]
  ],
];

$q = new WP_Query($args);
?>

<section class="lilacs-archive-indicadores">
  <div class="lai-container">

    <div class="lai-top">
      <div class="lai-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span class="lai-sep">-</span>
        <a href="<?php echo esc_url($indicadores_url); ?>">Indicadores</a>
        <span class="lai-sep">-</span>
        <span class="lai-crumb-current"><?php echo esc_html($term_name); ?></span>
      </div>

      <div class="lai-header">
        <div>
          <h1 class="lai-title"><?php echo esc_html($term_name); ?></h1>
          <?php if (!empty($term_desc)) : ?>
            <div class="lai-desc"><?php echo wp_kses_post($term_desc); ?></div>
          <?php endif; ?>
        </div>

        <div class="lai-view">
          <a class="lai-viewbtn <?php echo $view==='grid'?'is-active':''; ?>"
             href="<?php echo esc_url(add_query_arg(['view'=>'grid'], remove_query_arg('paged'))); ?>">
            Grade
          </a>
          <a class="lai-viewbtn <?php echo $view==='list'?'is-active':''; ?>"
             href="<?php echo esc_url(add_query_arg(['view'=>'list'], remove_query_arg('paged'))); ?>">
            Lista
          </a>
        </div>
      </div>

      <form class="lai-filters" method="get" action="">
        <div class="lai-search">
          <input type="search" name="s" value="<?php echo esc_attr($search); ?>"
                 placeholder="Buscar por painel, tema, palavra-chave..." />
        </div>

        <input type="hidden" name="view" value="<?php echo esc_attr($view); ?>" />
        <button class="lai-submit" type="submit">Buscar</button>
      </form>

      <div class="lai-meta">
        <span><?php echo (int) $q->found_posts; ?> resultados</span>
      </div>
    </div>

    <?php if ($q->have_posts()) : ?>
      <div class="lai-grid <?php echo $view === 'list' ? 'is-list' : 'is-grid'; ?>" role="list">
        <?php while ($q->have_posts()) : $q->the_post();

          $link    = get_permalink();
          $title   = get_the_title();
          $updated = get_the_modified_date('d/m/Y');

          // (Opcional) tags via ACF, se existir no post
          $tags_text = function_exists('get_field') ? (string) get_field('tags_do_indicador') : '';
          $tags = array_filter(array_map('trim', preg_split('/[,;|]/', $tags_text)));
        ?>
          <article class="lai-card" role="listitem">
            <div class="lai-card-top">
              <div class="lai-card-meta">
                <span class="lai-card-type">Indicador</span>
                <span class="lai-dot">•</span>
                <span class="lai-card-date">Atualizado em <?php echo esc_html($updated); ?></span>
              </div>

              <a class="lai-card-action" href="<?php echo esc_url($link); ?>">
                Acessar
                <span aria-hidden="true">↗</span>
              </a>
            </div>

            <h2 class="lai-card-title">
              <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
            </h2>

            <div class="lai-card-excerpt">
              <?php
                echo wp_kses_post(
                  wpautop(
                    wp_trim_words(
                      get_the_excerpt() ?: wp_strip_all_tags(get_the_content()),
                      26
                    )
                  )
                );
              ?>
            </div>

            <?php if (!empty($tags)) : ?>
              <div class="lai-tags">
                <?php foreach ($tags as $t) : ?>
                  <span class="lai-tag"><?php echo esc_html($t); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <div class="lai-pagination">
        <?php
        echo paginate_links([
          'total'   => (int) $q->max_num_pages,
          'current' => $paged,
          'type'    => 'list',
        ]);
        ?>
      </div>

    <?php else : ?>
      <div class="lai-empty">
        Nenhum resultado encontrado para este termo.
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
/* Font global do template */
.lilacs-archive-indicadores,
.lilacs-archive-indicadores *{
  font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      
}

.lilacs-archive-indicadores{ background:#ebebeb; padding:26px 0 40px;min-height: 500px;}
.lai-container{ width:min(1200px, calc(100% - 48px)); margin:0 auto; }

.lai-top{ border:1px solid #e6eef6; border-radius:14px; padding:16px 18px; background:#fff; }
.lai-breadcrumb{
  font-size:12px; color:#64748b; display:flex; gap:8px; align-items:center; margin-bottom:10px;
  flex-wrap:wrap;
}
.lai-breadcrumb a{ color:#64748b; text-decoration:none; }
.lai-breadcrumb a:hover{ text-decoration:underline; }
.lai-sep{ opacity:.8; }
.lai-crumb-current{ color:#0b2f57; font-weight:700; }

.lai-header{ display:flex; align-items:flex-start; justify-content:space-between; gap:14px; }
.lai-title{ margin:0; font-size:20px; font-weight:800; color:#0b2f57; }
.lai-desc{ margin-top:6px; color:#64748b; font-size:12px; line-height:1.6; }

.lai-view{ display:flex; gap:8px; }
.lai-viewbtn{
  display:inline-flex; align-items:center; justify-content:center;
  padding:6px 10px; border-radius:8px; border:1px solid #e6eef6;
  color:#0b2f57; text-decoration:none; font-size:12px; font-weight:700;
}
.lai-viewbtn.is-active{ background:#0b2f57; color:#fff; border-color:#0b2f57; }

.lai-filters{ margin-top:12px; display:flex; gap:10px; align-items:center; }
.lai-search{ flex:1 1 auto; }
.lai-search input{
  width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e6eef6;
  font-size:12px; outline:none;
}
.lai-submit{
  padding:10px 12px; border-radius:10px; border:0; cursor:pointer;
  background:#082A53; color:#fff; font-weight:800; font-size:12px;
}
.lai-meta{ margin-top:10px; color:#64748b; font-size:12px; }

.lai-grid{ margin-top:16px; display:grid; gap:14px; }
.lai-grid.is-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
.lai-grid.is-list{ grid-template-columns: 1fr; }

.lai-card{
  border:1px solid #e6eef6; border-radius:12px; padding:14px 14px 12px;
  box-shadow:0 10px 24px rgba(8,42,83,.06);
  background:#fff;
}
.lai-card-top{ display:flex; align-items:center; justify-content:space-between; gap:12px; }
.lai-card-meta{ font-size:11px; color:#64748b; display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
.lai-card-type{ font-weight:800; color:#0b2f57; }
.lai-dot{ opacity:.6; }

.lai-card-action{
  font-size:11px; font-weight:800; text-decoration:none;
  border:1px solid #e6eef6; border-radius:8px; padding:6px 10px; display:inline-flex; gap:8px; align-items:center;
  
  color: #fff;
    display: inline-flex;
    gap: 8px;
    align-items: center;
    background: #f96a1e;
}
.lai-card-action:hover{ border-color:rgba(8,42,83,.3); }

/* TITULO DO CARD (16px) */
.lai-card-title{
  margin:10px 0 6px;
  font-size:16px;
  line-height:1.3;
  font-weight:900;
  color:#0b2f57;
}
.lai-card-title a{ color:inherit; text-decoration:none; }
.lai-card-title a:hover{ text-decoration:underline; }

.lai-card-excerpt{ color:#64748b; font-size:12px; line-height:1.55; }
.lai-tags{ margin-top:10px; display:flex; gap:8px; flex-wrap:wrap; }
.lai-tag{ font-size:10px; font-weight:800; color:#0b2f57; background:#eef4fb; padding:4px 8px; border-radius:999px; }

.lai-pagination{ margin-top:18px; }
.lai-pagination ul{ list-style:none; display:flex; gap:8px; padding:0; margin:0; flex-wrap:wrap; }
.lai-pagination a, .lai-pagination span{
  display:inline-flex; padding:8px 10px; border-radius:10px; border:1px solid #e6eef6;
  text-decoration:none; font-size:12px; color:#0b2f57;
}
.lai-pagination .current{ background:#0b2f57; color:#fff; border-color:#0b2f57; }

.lai-empty{ margin-top:16px; padding:18px; border:1px dashed #e6eef6; border-radius:12px; color:#64748b; }

@media (max-width: 920px){
  .lai-grid.is-grid{ grid-template-columns: 1fr; }
  .lai-filters{ flex-direction:column; align-items:stretch; }
  .lai-submit{ width:100%; }
}
</style>

<?php get_footer(); ?>
