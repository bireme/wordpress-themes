<?php
/**
 * DOBRA: pagina-comunicacao_cientifica_em_saude
 * Renderiza seção “Cursos de Comunicação Científica em Ciências da Saúde”
 * Fundo 100% (full-bleed) + conteúdo encaixotado (container).
 */

if ( ! defined('ABSPATH') ) exit;

// =====================
// CAMPOS (ACF) - conforme layout comunicacao_cientifica_em_saude
// =====================
$bg_color      = get_sub_field('cor_de_fundo');        // color_picker
$top_title     = get_sub_field('titulo');              // text (título do topo)
$card_image    = get_sub_field('imagem_lateral');      // image (array)
$title         = get_sub_field('titulo_lateral');      // text (título da direita)
$desc          = get_sub_field('descricao_lateral');   // wysiwyg

$btn1_text     = get_sub_field('texto_botao_1');       // text
$btn2_text     = get_sub_field('texto_botao_2');       // text
$btn1_link     = get_sub_field('link_botao_1');        // text (URL)
$btn2_link     = get_sub_field('link_botao_2');        // text (URL)

// =====================
// STYLE FUNDO (100%)
// =====================
$style = '';
if ( ! empty($bg_color) ) {
  $style .= 'background-color:' . esc_attr($bg_color) . ';';
}
?>

<section class="lilacs-ccsa" style="<?php echo esc_attr($style); ?>">
  <div class="lilacs-ccsa__container">

    <?php if ( ! empty($top_title) ) : ?>
      <h2 class="lilacs-ccsa__top-title"><?php echo esc_html($top_title); ?></h2>
    <?php endif; ?>

    <div class="lilacs-ccsa__grid">

      <?php if ( ! empty($card_image) ) : ?>
        <?php
          $card_url = is_array($card_image) && ! empty($card_image['url']) ? $card_image['url'] : $card_image;
          $card_alt = is_array($card_image) && ! empty($card_image['alt']) ? $card_image['alt'] : ($title ?: 'Curso');
        ?>
        <div class="lilacs-ccsa__card">
          <img class="lilacs-ccsa__card-img" src="<?php echo esc_url($card_url); ?>" alt="<?php echo esc_attr($card_alt); ?>">
        </div>
      <?php endif; ?>

      <div class="lilacs-ccsa__content">

        <?php if ( ! empty($title) ) : ?>
          <h3 class="lilacs-ccsa__title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>

        <?php if ( ! empty($desc) ) : ?>
          <div class="lilacs-ccsa__desc"><?php echo wp_kses_post($desc); ?></div>
        <?php endif; ?>

        <?php
          // Botões fixos (renderiza só se tiver texto + link)
          $has_btn1 = ! empty($btn1_text) && ! empty($btn1_link);
          $has_btn2 = ! empty($btn2_text) && ! empty($btn2_link);
        ?>

        <?php if ( $has_btn1 || $has_btn2 ) : ?>
          <div class="lilacs-ccsa__actions">
            <?php if ( $has_btn1 ) : ?>
              <a class="lilacs-ccsa__btn" href="<?php echo esc_url($btn1_link); ?>">
                <?php echo esc_html($btn1_text); ?>
              </a>
            <?php endif; ?>

            <?php if ( $has_btn2 ) : ?>
              <a class="lilacs-ccsa__btn" href="<?php echo esc_url($btn2_link); ?>">
                <?php echo esc_html($btn2_text); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<style>
/* Fundo 100% */
.lilacs-ccsa{
  width:100%;
  padding:28px 0;
}

/* Conteúdo encaixotado */
.lilacs-ccsa__container{
  width:min(1200px, calc(100% - 48px));
  margin:0 auto;
}

/* Título superior */
.lilacs-ccsa__top-title{
  margin:0 0 18px 0;
  font-size:24px;
  line-height:1.2;
  font-weight:700;
  color:#fff;
}

/* Grid */
.lilacs-ccsa__grid{
  display:flex;
  gap:28px;
  align-items:center;
}

/* Card esquerdo */
.lilacs-ccsa__card{
  width:360px;
  flex:0 0 360px;
  border-radius:16px;
  overflow:hidden;
  background:rgba(0,0,0,.12);
  box-shadow:0 12px 28px rgba(0,0,0,.18);
}

.lilacs-ccsa__card-img{
  display:block;
  width:100%;
  height:auto;
}

/* Conteúdo */
.lilacs-ccsa__content{
  flex:1 1 auto;
  min-width:240px;
}

.lilacs-ccsa__title{
  margin:0 0 10px 0;
  font-size:20px;
  line-height:1.25;
  font-weight:700;
  color:#fff;
}

.lilacs-ccsa__desc{
  margin:0 0 14px 0;
  font-size:14px;
  line-height:1.6;
  color:rgba(255,255,255,.92);
}

.lilacs-ccsa__actions{
  display:flex;
  gap:14px;
  flex-wrap:wrap;
}

.lilacs-ccsa__btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:10px 18px;
  border-radius:999px;
  background:#fff;
  color:#0b3d74;
  font-size:13px;
  font-weight:700;
  text-decoration:none;
  transition:transform .12s ease, opacity .12s ease;
}

.lilacs-ccsa__btn:hover{
  transform:translateY(-1px);
  opacity:.95;
}

@media (max-width: 820px){
  .lilacs-ccsa__grid{ flex-direction:column; align-items:flex-start; }
  .lilacs-ccsa__card{ width:220px; flex-basis:auto; }
}
</style>
