<?php
/**
 * DOBRA: Produções da sua instituição
 * Slug esperado pelo seu template: pagina-producoes_da_sua_instituicao
 * Arquivo: pagina-producoes_da_sua_instituicao.php
 */
if ( ! defined('ABSPATH') ) exit;

// Campos do layout (sub_fields)
$titulo    = get_sub_field('titulo');
$descricao = get_sub_field('descricao');

// Repeater SEM "name" no ACF -> usar a KEY do campo
$repeater_key = 'Campos';

/**
 * Fallback: cria um "badge" com 2 letras (ex: ai, af...)
 */
function lilacs_badge_letters_from_title($text){
  $text = trim( wp_strip_all_tags( (string)$text ) );
  if ($text === '') return 'li';

  // pega iniciais das 2 primeiras palavras, senão 2 primeiras letras
  $parts = preg_split('/\s+/', $text);
  if (count($parts) >= 2) {
    $a = mb_substr($parts[0], 0, 1, 'UTF-8');
    $b = mb_substr($parts[1], 0, 1, 'UTF-8');
    $out = mb_strtolower($a.$b, 'UTF-8');
  } else {
    $out = mb_strtolower(mb_substr($text, 0, 2, 'UTF-8'), 'UTF-8');
  }
  // remove acentos/símbolos básicos (não crítico)
  $out = preg_replace('/[^a-z0-9_]/i', '', $out);
  return $out ?: 'li';
}
?>

<section class="lilacs-prodinst">
  <div class="lilacs-prodinst__inner">

    <?php if ( ! empty($titulo) ) : ?>
      <h2 class="lilacs-prodinst__title"><?php echo esc_html($titulo); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty($descricao) ) : ?>
      <div class="lilacs-prodinst__desc">
        <?php
          // WYSIWYG do ACF (mantém links e formatação)
          echo wp_kses_post( $descricao );
        ?>
      </div>
    <?php endif; ?>

    <?php if ( have_rows( $repeater_key ) ) : ?>
      <div class="lilacs-prodinst__grid">
        <?php while ( have_rows( $repeater_key ) ) : the_row();

          $item_titulo   = get_sub_field('titulo');
          $item_desc     = get_sub_field('descricao');
          $item_icon_url = get_sub_field('imagemicone'); // return_format = url

          $badge_text = lilacs_badge_letters_from_title($item_titulo);
        ?>
          <article class="lilacs-prodinst__card">
            <div class="lilacs-prodinst__icon" aria-hidden="true">
              <?php if ( ! empty($item_icon_url) ) : ?>
                <img src="<?php echo esc_url($item_icon_url); ?>" alt="">
              <?php else : ?>
                <span><?php echo esc_html($badge_text); ?></span>
              <?php endif; ?>
            </div>

            <div class="lilacs-prodinst__content">
              <?php if ( ! empty($item_titulo) ) : ?>
                <h3 class="lilacs-prodinst__cardtitle"><?php echo esc_html($item_titulo); ?></h3>
              <?php endif; ?>

              <?php if ( ! empty($item_desc) ) : ?>
                <div class="lilacs-prodinst__carddesc">
                  <?php echo wp_kses_post( $item_desc ); ?>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
/* ========= Produções da sua instituição (layout igual ao print) ========= */
.lilacs-prodinst{
  background:#fff;
  padding: 22px 0 26px;
}

.lilacs-prodinst__inner{
  max-width: 1180px;
  margin: 0 auto;
  padding: 0 18px;
}

.lilacs-prodinst__title{
  margin: 0 0 6px;
  font-size: 32px;
  line-height: 1.2;
  font-weight: 800;
  color: #103A7A; /* azul do título no print */
  letter-spacing: -0.2px;
}

.lilacs-prodinst__desc{
  margin: 0 0 14px;
  font-size: 12px;
  line-height: 1.45;
  color: #6B7280;
}
.lilacs-prodinst__desc p{ margin: 0; font-size:16px;}
.lilacs-prodinst__desc a{
  color: #0B5BD3;
  text-decoration: underline;
  font-weight: 600;
  white-space: nowrap;
}

.lilacs-prodinst__grid{
  display: grid;
  grid-template-columns: 1fr 1fr; /* 2 colunas */
  gap: 12px 14px;                /* espaço entre cards */
  margin-top:30px;
}

.lilacs-prodinst__card{
  display: grid;
  grid-template-columns: 52px 1fr;
  gap: 12px;
  align-items: center;
  background: #F2F2F2; /* cinza claro do card */
  border-radius: 8px;
  padding: 12px 14px;
}

.lilacs-prodinst__icon{
  width: 44px;
  height: 44px;
  border-radius: 999px;
  background: #0B2F66; /* azul do badge */
  display: grid;
  place-items: center;
  overflow: hidden;
}

.lilacs-prodinst__icon img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  display:block;
}

.lilacs-prodinst__icon span{
  color: #fff;
  font-weight: 800;
  font-size: 12px;
  letter-spacing: 0.2px;
}

.lilacs-prodinst__cardtitle{
  margin: 0 0 4px;
  font-size: 16px;
  line-height: 1.25;
  font-weight: 800;
  color: #103A7A;
}

.lilacs-prodinst__carddesc{
  font-size: 10.5px;
  line-height: 1.35;
  color: #6B7280;
}
.lilacs-prodinst__carddesc p{ margin: 0;font-size:14px}
.lilacs-prodinst__carddesc a{
  color:#0B5BD3;
  text-decoration: underline;
  font-weight:600;
}

/* Responsivo: 1 coluna no mobile */
@media (max-width: 720px){
  .lilacs-prodinst__grid{ grid-template-columns: 1fr; }
}
</style>
