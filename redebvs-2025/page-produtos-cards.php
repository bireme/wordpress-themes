<?php 
/**
 * Template Name: Arquivo de Produtos (Cards – Logo acima + Título + Preview do Flexible)
 * Description: Lista o CPT "produtos" em cards minimalistas exibindo o logo (ACF: logo_do_produto) acima do título,
 * e um preview em texto corrido extraído do ACF Flexible "layout" (igual o single-produto).
 */

if ( ! defined('ABSPATH') ) exit;
get_header();

// ================================
// Helpers (preview do Flexible ACF)
// ================================
if ( ! function_exists('bvs_produto_preview_from_flexible') ) {
  function bvs_produto_preview_from_flexible( $post_id, $limit = 220 ) {

    if ( ! function_exists('get_field') ) return '';

    $rows = get_field('layout', $post_id);
    if ( ! is_array($rows) || empty($rows) ) return '';

    $parts = [];

    foreach ( $rows as $row ) {
      if ( ! is_array($row) ) continue;

      foreach ( $row as $key => $val ) {
        // pula metadado do flexible
        if ( $key === 'acf_fc_layout' ) continue;

        // aceita somente strings (text/textarea/wysiwyg normalmente chegam aqui como string)
        if ( is_string($val) ) {
          $txt = wp_strip_all_tags( $val );
          $txt = preg_replace('/\s+/u', ' ', trim($txt));
          if ( $txt !== '' ) $parts[] = $txt;
        }
      }

      // se já juntou bastante, pode parar cedo (performance)
      if ( mb_strlen( implode(' ', $parts) ) >= ($limit * 2) ) break;
    }

    $text = trim( implode(' ', $parts) );
    if ( $text === '' ) return '';

    // limita e adiciona ...
    if ( mb_strlen($text) > $limit ) {
      $text = mb_substr($text, 0, $limit);
      // evita cortar no meio de palavra (suaviza)
      $text = preg_replace('/\s+\S*$/u', '', $text);
      $text = rtrim($text, " \t\n\r\0\x0B.,;:-");
      $text .= '...';
    } else {
      // mesmo sem corte, você pediu "..." ao final
      $text .= '...';
    }

    return $text;
  }
}

// ================================
// Inputs
// ================================
$paged  = max(1, (int) get_query_var('paged'));
$search = isset($_GET['s']) ? sanitize_text_field( wp_unslash($_GET['s']) ) : '';
$sort   = isset($_GET['sort']) ? sanitize_text_field( wp_unslash($_GET['sort']) ) : 'recent';

$orderby = 'date';
$order   = 'DESC';
if ($sort === 'az') { $orderby = 'title'; $order = 'ASC'; }
if ($sort === 'za') { $orderby = 'title'; $order = 'DESC'; }

// ================================
// Query
// ================================
$q = new WP_Query([
  'post_type'      => 'produtos',
  'post_status'    => 'publish',
  'posts_per_page' => 12,
  'paged'          => $paged,
  's'              => $search,
  'orderby'        => $orderby,
  'order'          => $order,
]);
?>
<style>
:root{
  --bg:#fff;--text:#111827;--muted:#6b7280;
  --border:#e5e7eb;--soft:#f9fafb;--focus:#2563eb;
  --radius:18px;
  --shadow:0 8px 26px rgba(17,24,39,.08);
  --shadow2:0 10px 30px rgba(17,24,39,.12);
  --font:"Noto Sans",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
}

.bvs-page{font-family:var(--font);background:var(--bg);color:var(--text);}
.bvs-wrap{max-width:1200px;margin:0 auto;padding:28px 18px 48px;}

.bvs-hero{
  border:1px solid var(--border);
  border-radius:var(--radius);
  background:linear-gradient(180deg,var(--soft),#fff);
  padding:20px;
  box-shadow:var(--shadow);
}
.bvs-hero h1{margin:0;font-size:24px;letter-spacing:-.02em}

.bvs-controls{display:flex;gap:12px;flex-wrap:wrap;margin-top:14px}
.bvs-search{
  flex:1 1 320px;display:flex;gap:10px;align-items:center;
  border:1px solid var(--border);border-radius:999px;padding:10px 12px;background:#fff;
}
.bvs-search input{border:0;outline:0;width:100%;font-size:14px}
.bvs-select,.bvs-btn{
  border:1px solid var(--border);border-radius:999px;
  padding:10px 14px;font-size:13px;cursor:pointer
}

.bvs-grid{
  display:grid;grid-template-columns:repeat(12,1fr);
  gap:14px;margin-top:18px
}
.bvs-card{
  grid-column:span 12;background:#fff;border:1px solid var(--border);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  transition:.18s;
  overflow:hidden;
}
@media(min-width:740px){.bvs-card{grid-column:span 6}}
@media(min-width:1024px){.bvs-card{grid-column:span 4}}
.bvs-card:hover{transform:translateY(-2px);box-shadow:var(--shadow2)}

.bvs-card-link{
  display:flex;
  flex-direction:column;
  gap:12px;
  padding:18px 18px 20px;
  text-decoration:none;
  color:var(--text);
  height:100%;
}

.bvs-logo-wrap{
  height:56px;
  display:flex;
  align-items:center;
  justify-content:flex-start;
}
.bvs-card:not(.has-logo) .bvs-logo-wrap{display:none}

.bvs-logo{
  max-height:56px;
  max-width:100%;
  width:auto;
  object-fit:contain;
  display:block;
}

.bvs-title{
  margin:0;
  font-size:16px;
  line-height:1.35;
  letter-spacing:-.01em;
}
.bvs-card-link:hover .bvs-title{color:#0050A0;}

.bvs-preview{
  font-size:14px;
  line-height:1.55;
  color:var(--muted);
}
</style>

<div class="bvs-page">
  <div class="bvs-wrap">

    <section class="bvs-hero">
      <h1><?php the_title(); ?></h1>

      <form class="bvs-controls" method="get">
        <div class="bvs-search">
          <input type="search" name="s" placeholder="Buscar produto…" value="<?php echo esc_attr($search); ?>">
        </div>

        <select class="bvs-select" name="sort" onchange="this.form.submit()">
          <option value="recent" <?php selected($sort,'recent'); ?>>Mais recentes</option>
          <option value="az" <?php selected($sort,'az'); ?>>A–Z</option>
          <option value="za" <?php selected($sort,'za'); ?>>Z–A</option>
        </select>

        <button class="bvs-btn" type="submit">Aplicar</button>
      </form>
    </section>

    <?php if ($q->have_posts()): ?>
      <div class="bvs-grid">
        <?php while ($q->have_posts()): $q->the_post();

          // ACF: logo_do_produto (retorna URL)
          $logo_url = '';
          if ( function_exists('get_field') ) {
            $logo_url = trim( (string) get_field('logo_do_produto', get_the_ID()) );
          }

          // Preview baseado no Flexible "layout" (igual single-produto)
          $preview = bvs_produto_preview_from_flexible( get_the_ID(), 220 );

          $card_class = $logo_url ? 'bvs-card has-logo' : 'bvs-card';
        ?>
          <article class="<?php echo esc_attr($card_class); ?>">
            <a class="bvs-card-link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

              <div class="bvs-logo-wrap" aria-hidden="true">
                <?php if ( $logo_url ) : ?>
                  <img class="bvs-logo" src="<?php echo esc_url($logo_url); ?>" alt="">
                <?php endif; ?>
              </div>

              <h2 class="bvs-title"><?php the_title(); ?></h2>

              <?php if ( $preview ) : ?>
                <div class="bvs-preview"><?php echo esc_html( $preview ); ?></div>
              <?php endif; ?>

            </a>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php endif; ?>

  </div>
</div>

<?php get_footer(); ?>
