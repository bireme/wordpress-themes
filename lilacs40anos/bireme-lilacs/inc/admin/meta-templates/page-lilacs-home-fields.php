<?php
if (!defined('ABSPATH')) exit;

const BIREME_LILACS_HOME_NONCE = 'bireme_lilacs_home_save';
const BIREME_LILACS_HOME_SLUG  = 'page-lilacs-home.php';

/** Helper: verifica se a página atual usa este template */
function bireme_lilacs_home_matches_template($post_id){
    return get_page_template_slug($post_id) === BIREME_LILACS_HOME_SLUG;
}


/** === REGISTRO DA METABOX (apenas quando o template bate) === */
/**
 * Registra o metabox — usa o objeto $post quando disponível para ser
 * compatível com o Editor Clássico e com Gutenberg.
 */
function bireme_lilacs_home_add_meta_box( $post_type, $post ){
  $post_id = 0;
  if (!empty($post) && !empty($post->ID)) {
    $post_id = (int) $post->ID;
  } elseif (!empty($_GET['post'])) {
    $post_id = (int) $_GET['post'];
  } elseif (!empty($_POST['post_ID'])) {
    $post_id = (int) $_POST['post_ID'];
  }

  if (!$post_id || !bireme_lilacs_home_matches_template($post_id)) return;

  add_meta_box(
    'bireme_lilacs_home_tabs',
    'LILACS Home – Campos por Dobra',
    'bireme_lilacs_home_metabox_tabs_render',
    'page',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'bireme_lilacs_home_add_meta_box', 10, 2);

/** === CSS/JS das abas (carrega somente quando necessário) === */
add_action('admin_enqueue_scripts', function($hook){
  if (!in_array($hook, ['post.php','post-new.php'], true)) return;

  // Tenta obter o post via objeto global quando disponível (mais confiável)
  $post_id = 0;
  global $post;
  if (!empty($post) && !empty($post->ID)) {
    $post_id = (int) $post->ID;
  } elseif (!empty($_GET['post'])) {
    $post_id = (int) $_GET['post'];
  } elseif (!empty($_POST['post_ID'])) {
    $post_id = (int) $_POST['post_ID'];
  }

  if ($post_id && bireme_lilacs_home_matches_template($post_id)) {
        wp_enqueue_media();
             // CSS leve
       // CSS leve (NOWDOC evita interpolação)
$css = <<<'CSS'
.bireme-tabs{margin-top:8px}
.bireme-tabs__nav{display:flex;gap:8px;border-bottom:1px solid #e2e2e2;margin-bottom:12px}
.bireme-tabs__nav a{padding:8px 12px;border:1px solid #e2e2e2;border-bottom:none;background:#f7f7f7;border-radius:6px 6px 0 0;text-decoration:none}
.bireme-tabs__nav a.is-active{background:#fff;font-weight:600}
.bireme-tab{display:none;background:#fff;border:1px solid #e2e2e2;border-radius:0 6px 6px 6px;padding:14px}
.bireme-tab.is-active{display:block}
.bireme-field{margin:12px 0}
.bireme-field label{display:block;font-weight:600;margin-bottom:6px}
.bireme-flex{display:flex;gap:16px;align-items:center}
.bireme-preview img{max-width:360px;height:auto;border:1px solid #ddd;border-radius:6px}
.bireme-two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media (max-width: 1100px){.bireme-two-col{grid-template-columns:1fr}}

/* [NOVO] Estilos para repetidor */
.bireme-repeater{border:1px solid #e6e6e6;border-radius:6px}
.bireme-repeater__head{display:flex;justify-content:space-between;align-items:center;background:#fafafa;border-bottom:1px solid #e6e6e6;padding:8px 10px;border-radius:6px 6px 0 0}
.bireme-repeater__rows{padding:8px}
.bireme-repeater__row{display:flex;gap:8px;align-items:center;margin:6px 0}
.bireme-repeater__row input[type="text"]{flex:1}
.bireme-repeater__row .button{vertical-align:middle}
.bireme-hint{color:#666;font-size:12px}
.bireme-card-grid{display:grid;grid-template-columns:1fr;gap:18px;margin-top:10px}
.bireme-card{border:1px solid #e6e6e6;border-radius:8px;padding:12px}
.bireme-card h4{margin:0 0 8px}
.bireme-source-toggle{margin:12px 0;padding:10px;background:#f9f9f9;border-radius:6px}
.bireme-source-toggle label{display:block;margin:6px 0}
.bireme-manual-fields,.bireme-rss-fields{margin-top:12px}
.bireme-rss-test{margin-top:8px}
CSS;

wp_register_style('bireme_lilacs_tabs_css', false);
wp_enqueue_style('bireme_lilacs_tabs_css');
wp_add_inline_style('bireme_lilacs_tabs_css', $css);

// JS leve (NOWDOC também)
$js = <<<'JS'
(function($){
  $(document).on('click','.bireme-tabs__nav a',function(e){
    e.preventDefault();
    var id = $(this).attr('href');
    $(this).closest('.bireme-tabs__nav').find('a').removeClass('is-active');
    $(this).addClass('is-active');
    $(id).closest('.bireme-tabs').find('.bireme-tab').removeClass('is-active');
    $(id).addClass('is-active');
  });

  // Seletor de mídia genérico
  window.biremePickImage = function(btnSel, inputSel, previewSel){
    var frame = wp.media({ title:'Selecionar imagem', button:{text:'Usar esta imagem'}, library:{type:'image'}, multiple:false });
    frame.on('select', function(){
      var att = frame.state().get('selection').first().toJSON();
      $(inputSel).val(att.id);
      var url = (att.sizes && (att.sizes.medium_large ? att.sizes.medium_large.url : (att.sizes.large ? att.sizes.large.url : null))) || att.url;
      $(previewSel).html('<img src="'+url+'" alt="">');
    });
    frame.open();
  };

  // Repetidor genérico
  $(document).on('click','[data-repeater-add]',function(e){
    e.preventDefault();
    var box = $(this).closest('.bireme-repeater');
    var proto = box.find('[data-repeater-proto] .bireme-repeater__row').first().clone();
    proto.find('input[type="text"], input[type="url"]').val('');
    proto.find('input[type="checkbox"]').prop('checked', false);
    box.find('.bireme-repeater__rows').append(proto);
  });

  $(document).on('click','[data-repeater-del]',function(e){
    e.preventDefault();
    var row = $(this).closest('.bireme-repeater__row');
    var box = $(this).closest('.bireme-repeater');
    var total = box.find('.bireme-repeater__row').length;
    if(total > 1){ row.remove(); } else { row.find('input').val(''); row.find('input[type="checkbox"]').prop('checked', false); }
  });

  // Picker por linha do slide
  $(document).on('click', '.bireme-pick', function(e){
    e.preventDefault();
    var $row = $(this).closest('.bireme-slide-row');
    var $input = $row.find('input[name="bireme_slider_items[id][]"]');
    var $preview = $row.find('.bireme-slide-preview');

    var frame = wp.media({ title:'Selecionar imagem do slide', button:{text:'Usar esta imagem'}, library:{type:'image'}, multiple:false });
    frame.on('select', function(){
      var att = frame.state().get('selection').first().toJSON();
      $input.val(att.id);
      var url = (att.sizes && (att.sizes.large || att.sizes.medium_large || att.sizes.full));
      url = (url && url.url) ? url.url : att.url;
      $preview.html('<img src="'+url+'" alt="">');
    });
    frame.open();
  });

  $(document).on('click', '.bireme-clear', function(e){
    e.preventDefault();
    var $row = $(this).closest('.bireme-slide-row');
    $row.find('input[name="bireme_slider_items[id][]"]').val('0');
    $row.find('.bireme-slide-preview').html('<em>Sem imagem.</em>');
  });

  // Toggle para RSS/Manual
  $(document).on('change', 'input[name="bireme_rc_source_type"]', function(){
    var type = $(this).val();
    if(type === 'rss') {
      $('.bireme-rss-fields').show();
      $('.bireme-manual-fields').hide();
    } else {
      $('.bireme-rss-fields').hide();
      $('.bireme-manual-fields').show();
    }
  });

  // Inicializar toggle na carga
  $(document).ready(function(){
    var type = $('input[name="bireme_rc_source_type"]:checked').val();
    if(type === 'rss') {
      $('.bireme-rss-fields').show();
      $('.bireme-manual-fields').hide();
    } else {
      $('.bireme-rss-fields').hide();
      $('.bireme-manual-fields').show();
    }
  });

  // Testar RSS
  $(document).on('click', '.bireme-test-rss', function(e){
    e.preventDefault();
    var url = $('input[name="bireme_rc_rss_url"]').val();
    if(!url) {
      alert('Insira uma URL RSS primeiro.');
      return;
    }
    
    var $btn = $(this);
    var $result = $('.bireme-rss-test-result');
    
    $btn.prop('disabled', true).text('Testando...');
    $result.html('<em>Testando conexão RSS...</em>');
    
    $.post(ajaxurl, {
      action: 'bireme_test_rss',
      rss_url: url,
      nonce: '<?php echo wp_create_nonce("bireme_test_rss"); ?>'
    }, function(response) {
      $btn.prop('disabled', false).text('Testar RSS');
      if(response.success) {
        $result.html('<strong style="color:green;">✓ RSS válido!</strong><br>' + response.data.items + ' itens encontrados.<br><small>Primeiro item: ' + response.data.first_title + '</small>');
      } else {
        $result.html('<strong style="color:red;">✗ Erro:</strong> ' + response.data);
      }
    }).fail(function(){
      $btn.prop('disabled', false).text('Testar RSS');
      $result.html('<strong style="color:red;">✗ Erro de conexão</strong>');
    });
  });
})(jQuery);
JS;

wp_register_script('bireme_lilacs_tabs_js', false);
wp_enqueue_script('bireme_lilacs_tabs_js');
wp_add_inline_script('bireme_lilacs_tabs_js', $js);


        

    }
});

/** === RENDER DA METABOX COM ABAS === */
function bireme_lilacs_home_metabox_tabs_render($post){
    if (!bireme_lilacs_home_matches_template($post->ID)) {
        echo '<p>Esta caixa só é usada no template <code>'.esc_html(BIREME_LILACS_HOME_SLUG).'</code>.</p>';
        return;
    }

    wp_nonce_field(BIREME_LILACS_HOME_NONCE, 'bireme_lilacs_home_nonce');

    // --- já existia: metas Dobras 1–3 ---
    $hero_title = get_post_meta($post->ID, '_bireme_hero_title', true);
    $hero_desc  = get_post_meta($post->ID, '_bireme_hero_desc',  true);
    $hero_img   = (int) get_post_meta($post->ID, '_bireme_hero_img_id', true);
    $hero_url   = $hero_img ? wp_get_attachment_image_url($hero_img, 'large') : '';
  // Links do hero (novos): texto e URL para os 3 botões/âncoras
  $hero_link1_text = get_post_meta($post->ID, '_bireme_hero_link1_text', true);
  $hero_link1_url  = get_post_meta($post->ID, '_bireme_hero_link1_url', true);
  $hero_link2_text = get_post_meta($post->ID, '_bireme_hero_link2_text', true);
  $hero_link2_url  = get_post_meta($post->ID, '_bireme_hero_link2_url', true);
  $hero_link3_text = get_post_meta($post->ID, '_bireme_hero_link3_text', true);
  $hero_link3_url  = get_post_meta($post->ID, '_bireme_hero_link3_url', true);

    $cta_sub    = get_post_meta($post->ID, '_bireme_cta_subtitle', true);
    $cta_txt    = get_post_meta($post->ID, '_bireme_cta_button_text', true);
    $cta_url    = get_post_meta($post->ID, '_bireme_cta_button_url',  true);
    $cta_img    = (int) get_post_meta($post->ID, '_bireme_cta_bg_img_id', true);
    $cta_bg     = $cta_img ? wp_get_attachment_image_url($cta_img, 'large') : '';

    $extras     = get_post_meta($post->ID, '_bireme_extras_html', true);

    // [NOVO] Dobra 4 (Acessos rápidos – 3 cards)
    $aud_title  = get_post_meta($post->ID, '_bireme_aud_title', true);

    // Card 1
    $aud1_kicker = get_post_meta($post->ID, '_bireme_aud_1_kicker', true);
    $aud1_title  = get_post_meta($post->ID, '_bireme_aud_1_title', true);
    $aud1_icon   = (int) get_post_meta($post->ID, '_bireme_aud_1_icon_id', true);
    $aud1_icon_url = $aud1_icon ? wp_get_attachment_image_url($aud1_icon, 'medium') : '';
  $aud1_items  = get_post_meta($post->ID, '_bireme_aud_1_items', true);
  if(!is_array($aud1_items)) $aud1_items = [];
  // Normaliza versões antigas (lista de strings) para array de ['label'=>..., 'url'=> '']
  $aud1_items = array_map(function($it){ if (is_array($it)) return $it; return ['label'=>$it, 'url'=>'']; }, $aud1_items);
    $aud1_more_t = get_post_meta($post->ID, '_bireme_aud_1_more_text', true);
    $aud1_more_u = get_post_meta($post->ID, '_bireme_aud_1_more_url',  true);

    // Card 2
    $aud2_kicker = get_post_meta($post->ID, '_bireme_aud_2_kicker', true);
    $aud2_title  = get_post_meta($post->ID, '_bireme_aud_2_title', true);
    $aud2_icon   = (int) get_post_meta($post->ID, '_bireme_aud_2_icon_id', true);
    $aud2_icon_url = $aud2_icon ? wp_get_attachment_image_url($aud2_icon, 'medium') : '';
  $aud2_items  = get_post_meta($post->ID, '_bireme_aud_2_items', true);
  if(!is_array($aud2_items)) $aud2_items = [];
  $aud2_items = array_map(function($it){ if (is_array($it)) return $it; return ['label'=>$it, 'url'=>'']; }, $aud2_items);
    $aud2_more_t = get_post_meta($post->ID, '_bireme_aud_2_more_text', true);
    $aud2_more_u = get_post_meta($post->ID, '_bireme_aud_2_more_url',  true);

    // Card 3
    $aud3_kicker = get_post_meta($post->ID, '_bireme_aud_3_kicker', true);
    $aud3_title  = get_post_meta($post->ID, '_bireme_aud_3_title', true);
    $aud3_icon   = (int) get_post_meta($post->ID, '_bireme_aud_3_icon_id', true);
    $aud3_icon_url = $aud3_icon ? wp_get_attachment_image_url($aud3_icon, 'medium') : '';
  $aud3_items  = get_post_meta($post->ID, '_bireme_aud_3_items', true);
  if(!is_array($aud3_items)) $aud3_items = [];
  $aud3_items = array_map(function($it){ if (is_array($it)) return $it; return ['label'=>$it, 'url'=>'']; }, $aud3_items);
    $aud3_more_t = get_post_meta($post->ID, '_bireme_aud_3_more_text', true);
    $aud3_more_u = get_post_meta($post->ID, '_bireme_aud_3_more_url',  true);
    
    
    // Dobra 5 — Revistas indexadas
    $jr_title   = get_post_meta($post->ID, '_bireme_jr_title', true);
    $jr_sub     = get_post_meta($post->ID, '_bireme_jr_sub', true);
    $jr_items   = get_post_meta($post->ID, '_bireme_jr_items', true);
    if(!is_array($jr_items)) $jr_items = [];
    
    // Dobra 6 — Banner (slides)
    $sl_items = get_post_meta($post->ID, '_bireme_slider_items', true);
    if (!is_array($sl_items)) $sl_items = [];


    // Dobra 7 — Publicações recentes
    $rc_title = get_post_meta($post->ID, '_bireme_rc_title', true);
    $rc_sub   = get_post_meta($post->ID, '_bireme_rc_sub', true);
    $rc_items = get_post_meta($post->ID, '_bireme_rc_items', true);
    if (!is_array($rc_items)) $rc_items = [];
    
    // Campos RSS
    $rc_source_type = get_post_meta($post->ID, '_bireme_rc_source_type', true) ?: 'manual';
    $rc_rss_url = get_post_meta($post->ID, '_bireme_rc_rss_url', true);
    $rc_rss_limit = get_post_meta($post->ID, '_bireme_rc_rss_limit', true) ?: 5;


// Dobra 8 — Dados e Indicadores (4 caixas fixas)
$di_title   = get_post_meta($post->ID, '_bireme_di_title', true);
$di_sub     = get_post_meta($post->ID, '_bireme_di_sub', true);
$di_btn_txt = get_post_meta($post->ID, '_bireme_di_btn_txt', true);
$di_btn_url = get_post_meta($post->ID, '_bireme_di_btn_url', true);

$di = [];
for ($i=1; $i<=4; $i++){
  $icon_id = (int) get_post_meta($post->ID, "_bireme_di_{$i}_icon_id", true);
  $di[$i] = [
    'title'    => get_post_meta($post->ID, "_bireme_di_{$i}_title", true),
    'url'      => get_post_meta($post->ID, "_bireme_di_{$i}_url", true),
    'icon_id'  => $icon_id,
    'icon_url' => $icon_id ? wp_get_attachment_image_url($icon_id, 'medium') : '',
  ];
}

// Dobra 9 — Depoimentos
$dep_title = get_post_meta($post->ID, '_bireme_dep_title', true);
$dep_items = get_post_meta($post->ID, '_bireme_dep_items', true);
if (!is_array($dep_items)) $dep_items = [];




    ?>

    <div class="bireme-tabs">
<div class="bireme-tabs__nav">
  <a href="#bireme-tab-1" class="is-active">Dobra 1 — Banner</a>
  <a href="#bireme-tab-2rx">Dobra 2 — Raio-X da LILACS</a>
  <a href="#bireme-tab-2">Dobra 3 — CTA</a>
  <a href="#bireme-tab-3">Dobra 4 — Extras</a>
  <a href="#bireme-tab-4">Dobra 5 — Acessos rápidos</a>
  <a href="#bireme-tab-5">Dobra 6 — Revistas indexadas</a>
  <a href="#bireme-tab-6">Dobra 7 — Banner (slides)</a>
  <a href="#bireme-tab-7">Dobra 8 — Publicações recentes</a>
  <a href="#bireme-tab-8">Dobra 9 — Dados e indicadores</a>
  <a href="#bireme-tab-9">Dobra 10 — Depoimentos</a>
</div>


     <!-- Dobra 1 — Banner -->
<div class="bireme-tab is-active" id="bireme-tab-1">
  <div class="bireme-field">
    <label for="bireme_hero_title">Título do banner</label>
    <input type="text" id="bireme_hero_title" name="bireme_hero_title" class="widefat" value="<?php echo esc_attr($hero_title); ?>">
  </div>
  <div class="bireme-field">
    <label for="bireme_hero_desc">Descrição do banner</label>
    <textarea id="bireme_hero_desc" name="bireme_hero_desc" class="widefat" rows="3"><?php echo esc_textarea($hero_desc); ?></textarea>
  </div>
  <div class="bireme-field">
    <label>Imagem do banner</label>
    <div class="bireme-two-col">
      <div class="bireme-preview" id="bireme_hero_preview">
        <?php echo $hero_url ? '<img src="'.esc_url($hero_url).'" alt="">' : '<em>Nenhuma imagem selecionada.</em>'; ?>
      </div>
      <div>
        <input type="hidden" id="bireme_hero_img_id" name="bireme_hero_img_id" value="<?php echo esc_attr($hero_img); ?>">
        <button type="button" class="button" onclick="biremePickImage(this,'#bireme_hero_img_id','#bireme_hero_preview')">Selecionar imagem</button>
        <button type="button" class="button link-delete" onclick="jQuery('#bireme_hero_img_id').val('');jQuery('#bireme_hero_preview').html('<em>Nenhuma imagem selecionada.</em>')">Remover</button>
        <p class="description" style="margin-top:8px">Recomendado: largura cheia (≥ 1920px).</p>
      </div>
    </div>
  </div>
</div>

  <!-- Novos campos: personalizar textos e links rápidos do hero -->
  <div class="bireme-field" style="margin-top:12px">
    <label>Links rápidos (texto e URL)</label>
    <div style="display:grid;gap:8px;margin-top:6px">
      <div class="bireme-two-col">
        <input type="text" name="bireme_hero_link1_text" class="widefat" placeholder="Texto do link 1" value="<?php echo esc_attr($hero_link1_text); ?>">
        <input type="text" name="bireme_hero_link1_url"  class="widefat" placeholder="URL do link 1 (ex: #busca-avancada ou https://...)" value="<?php echo esc_attr($hero_link1_url); ?>">
      </div>
      <div class="bireme-two-col">
        <input type="text" name="bireme_hero_link2_text" class="widefat" placeholder="Texto do link 2" value="<?php echo esc_attr($hero_link2_text); ?>">
        <input type="text" name="bireme_hero_link2_url"  class="widefat" placeholder="URL do link 2 (ex: #decs or https://...)" value="<?php echo esc_attr($hero_link2_url); ?>">
      </div>
      <div class="bireme-two-col">
        <input type="text" name="bireme_hero_link3_text" class="widefat" placeholder="Texto do link 3" value="<?php echo esc_attr($hero_link3_text); ?>">
        <input type="text" name="bireme_hero_link3_url"  class="widefat" placeholder="URL do link 3 (ex: #como-pesquisar or https://...)" value="<?php echo esc_attr($hero_link3_url); ?>">
      </div>
    </div>
  </div>

<!-- Dobra 2 — Raio-X da LILACS -->
<div class="bireme-tab" id="bireme-tab-2rx">
  <?php
  // Metas atuais
  $rx_title   = get_post_meta($post->ID, '_bireme_rx_title', true);
  $rx_left_h  = get_post_meta($post->ID, '_bireme_rx_left_title', true);
  $rx_left_p  = get_post_meta($post->ID, '_bireme_rx_left_text',  true);
  $rx_mid_num = get_post_meta($post->ID, '_bireme_rx_center_number', true);
  $rx_mid_lab = get_post_meta($post->ID, '_bireme_rx_center_label',  true);
  $rx_right_h = get_post_meta($post->ID, '_bireme_rx_right_title', true);
  $rx_right_p = get_post_meta($post->ID, '_bireme_rx_right_text',  true);

  $rx_chart1  = get_post_meta($post->ID, '_bireme_rx_chart1', true);
  $rx_chart2  = get_post_meta($post->ID, '_bireme_rx_chart2', true);
  if(!is_array($rx_chart1)) $rx_chart1 = [];
  if(!is_array($rx_chart2)) $rx_chart2 = [];
  ?>

  <div class="bireme-field">
    <label for="bireme_rx_title">Título da seção</label>
    <input type="text" id="bireme_rx_title" name="bireme_rx_title" class="widefat"
           value="<?php echo esc_attr($rx_title ?: 'Raio-X da LILACS'); ?>">
  </div>

  <div class="bireme-two-col">
    <div class="bireme-field">
      <label for="bireme_rx_left_title">Bloco esquerdo — Título</label>
      <input type="text" id="bireme_rx_left_title" name="bireme_rx_left_title" class="widefat"
             value="<?php echo esc_attr($rx_left_h ?: 'LILACS'); ?>">
      <label style="margin-top:6px" for="bireme_rx_left_text">Bloco esquerdo — Texto</label>
      <textarea id="bireme_rx_left_text" name="bireme_rx_left_text" class="widefat" rows="3"><?php
        echo esc_textarea($rx_left_p ?: 'A ciência em saúde com identidade latino-americana.'); ?></textarea>
    </div>

    <div class="bireme-field">
      <label for="bireme_rx_right_title">Bloco direito — Título</label>
      <input type="text" id="bireme_rx_right_title" name="bireme_rx_right_title" class="widefat"
             value="<?php echo esc_attr($rx_right_h ?: 'LILACS Plus'); ?>">
      <label style="margin-top:6px" for="bireme_rx_right_text">Bloco direito — Texto</label>
      <textarea id="bireme_rx_right_text" name="bireme_rx_right_text" class="widefat" rows="3"><?php
        echo esc_textarea($rx_right_p ?: 'A ciência latino-americana no cenário global.'); ?></textarea>
    </div>
  </div>

  <div class="bireme-two-col">
    <div class="bireme-field">
      <label>Número central</label>
      <input type="text" name="bireme_rx_center_number" class="widefat"
             value="<?php echo esc_attr($rx_mid_num ?: '40'); ?>">
      <label style="margin-top:6px">Rótulo do número</label>
      <input type="text" name="bireme_rx_center_label" class="widefat"
             value="<?php echo esc_attr($rx_mid_lab ?: 'anos'); ?>">
    </div>
  </div>

  <hr>

  <h3 style="margin-top:10px">Gráfico 1 (donut azul)</h3>
  <p class="bireme-hint">Edite os segmentos (rótulo, valor numérico e cor). Você pode adicionar quantos precisar.</p>
  <div class="bireme-repeater" data-repeater>
    <div class="bireme-repeater__head">
      <strong>Segmentos</strong>
      <button type="button" class="button button-small" data-repeater-add>+ Adicionar</button>
    </div>
    <div class="bireme-repeater__rows">
      <?php
      $rows = !empty($rx_chart1) ? $rx_chart1 : [
        ['label'=>'A','value'=>1,'color'=>'#8fbdd4'],
        ['label'=>'B','value'=>2,'color'=>'#799db3'],
        ['label'=>'C','value'=>4,'color'=>'#3073a0'],
        ['label'=>'D','value'=>7,'color'=>'#085696'],
        ['label'=>'E','value'=>10,'color'=>'#00205b'],
      ];
      foreach($rows as $r){
        $lab = esc_attr($r['label'] ?? '');
        $val = esc_attr($r['value'] ?? '');
        $col = esc_attr($r['color'] ?? '#085696');
        echo '
        <div class="bireme-repeater__row" style="flex-wrap:wrap">
          <input type="text" name="bireme_rx_chart1[label][]" value="'.$lab.'" placeholder="Rótulo" style="min-width:220px">
          <input type="text" name="bireme_rx_chart1[value][]" value="'.$val.'" placeholder="Valor" style="width:140px">
          <input type="text" name="bireme_rx_chart1[color][]" value="'.$col.'" placeholder="#RRGGBB" style="width:140px">
          <button type="button" class="button button-link-delete" data-repeater-del>Remover</button>
        </div>';
      }
      ?>
    </div>
    <div data-repeater-proto style="display:none">
      <div class="bireme-repeater__row" style="flex-wrap:wrap">
        <input type="text" name="bireme_rx_chart1[label][]" value="" placeholder="Rótulo">
        <input type="text" name="bireme_rx_chart1[value][]" value="" placeholder="Valor">
        <input type="text" name="bireme_rx_chart1[color][]" value="#085696" placeholder="#RRGGBB">
        <button type="button" class="button button-link-delete" data-repeater-del>Remover</button>
      </div>
    </div>
  </div>

  <h3 style="margin-top:18px">Gráfico 2 (donut laranja)</h3>
  <div class="bireme-repeater" data-repeater>
    <div class="bireme-repeater__head">
      <strong>Segmentos</strong>
      <button type="button" class="button button-small" data-repeater-add>+ Adicionar</button>
    </div>
    <div class="bireme-repeater__rows">
      <?php
      $rows = !empty($rx_chart2) ? $rx_chart2 : [
        ['label'=>'Registros','value'=>10,'color'=>'#6c2207'],
        ['label'=>'Textos Completos','value'=>7,'color'=>'#bf4611'],
        ['label'=>'Revistas','value'=>4,'color'=>'#f96a1e'],
        ['label'=>'Países','value'=>2,'color'=>'#edaa8d'],
        ['label'=>'Idiomas','value'=>1,'color'=>'#ffbaa0'],
      ];
      foreach($rows as $r){
        $lab = esc_attr($r['label'] ?? '');
        $val = esc_attr($r['value'] ?? '');
        $col = esc_attr($r['color'] ?? '#f96a1e');
        echo '
        <div class="bireme-repeater__row" style="flex-wrap:wrap">
          <input type="text" name="bireme_rx_chart2[label][]" value="'.$lab.'" placeholder="Rótulo" style="min-width:220px">
          <input type="text" name="bireme_rx_chart2[value][]" value="'.$val.'" placeholder="Valor" style="width:140px">
          <input type="text" name="bireme_rx_chart2[color][]" value="'.$col.'" placeholder="#RRGGBB" style="width:140px">
          <button type="button" class="button button-link-delete" data-repeater-del>Remover</button>
        </div>';
      }
      ?>
    </div>
    <div data-repeater-proto style="display:none">
      <div class="bireme-repeater__row" style="flex-wrap:wrap">
        <input type="text" name="bireme_rx_chart2[label][]" value="" placeholder="Rótulo">
        <input type="text" name="bireme_rx_chart2[value][]" value="" placeholder="Valor">
        <input type="text" name="bireme_rx_chart2[color][]" value="#f96a1e" placeholder="#RRGGBB">
        <button type="button" class="button button-link-delete" data-repeater-del>Remover</button>
      </div>
    </div>
  </div>
</div>


<!-- Dobra 2 — CTA -->
<div class="bireme-tab" id="bireme-tab-2">
  <div class="bireme-field">
    <label for="bireme_cta_subtitle">Subtítulo / texto de apoio</label>
    <input type="text" id="bireme_cta_subtitle" name="bireme_cta_subtitle" class="widefat" value="<?php echo esc_attr($cta_sub); ?>">
  </div>
  <div class="bireme-two-col">
    <div class="bireme-field">
      <label for="bireme_cta_button_text">Texto do botão</label>
      <input type="text" id="bireme_cta_button_text" name="bireme_cta_button_text" class="widefat" value="<?php echo esc_attr($cta_txt); ?>">
    </div>
    <div class="bireme-field">
      <label for="bireme_cta_button_url">URL do botão</label>
      <!-- trocar para text para evitar validação HTML5 bloqueando o submit no Classic Editor -->
      <input type="text" id="bireme_cta_button_url" name="bireme_cta_button_url" class="widefat" value="<?php echo esc_attr($cta_url); ?>">
    </div>
  </div>
  <div class="bireme-field">
    <label>Imagem de fundo (CTA)</label>
    <div class="bireme-two-col">
      <div class="bireme-preview" id="bireme_cta_bg_preview">
        <?php echo $cta_bg ? '<img src="'.esc_url($cta_bg).'" alt="">' : '<em>Nenhuma imagem selecionada.</em>'; ?>
      </div>
      <div>
        <input type="hidden" id="bireme_cta_bg_img_id" name="bireme_cta_bg_img_id" value="<?php echo esc_attr($cta_img); ?>">
        <button type="button" class="button" onclick="biremePickImage(this,'#bireme_cta_bg_img_id','#bireme_cta_bg_preview')">Selecionar imagem</button>
        <button type="button" class="button link-delete" onclick="jQuery('#bireme_cta_bg_img_id').val('');jQuery('#bireme_cta_bg_preview').html('<em>Nenhuma imagem selecionada.</em>')">Remover</button>
      </div>
    </div>
  </div>
</div>

<!-- Dobra 3 — Extras -->
<div class="bireme-tab" id="bireme-tab-3">
  <div class="bireme-field">
    <label for="bireme_extras_html">Conteúdo extra (HTML simples permitido)</label>
    <textarea id="bireme_extras_html" name="bireme_extras_html" class="widefat" rows="6"><?php echo esc_textarea($extras); ?></textarea>
    <p class="description">Use para um parágrafo, badges, mini-lista, etc.</p>
  </div>
</div>


      <!-- [NOVO] Dobra 4 -->
      <div class="bireme-tab" id="bireme-tab-4">
        <div class="bireme-field">
          <label for="bireme_aud_title">Título da seção</label>
          <input type="text" id="bireme_aud_title" name="bireme_aud_title" class="widefat" value="<?php echo esc_attr($aud_title ?: 'Acesso rápido'); ?>">
          <p class="bireme-hint">Ex.: “Acesso rápido” ou “Para quem é a LILACS”.</p>
        </div>

        <div class="bireme-card-grid">
          <!-- CARD 1 -->
          <div class="bireme-card">
            <h4>Card 1</h4>
            <div class="bireme-two-col">
              <div class="bireme-field">
                <label for="bireme_aud_1_kicker">Kicker (linha de topo)</label>
                <input type="text" id="bireme_aud_1_kicker" name="bireme_aud_1_kicker" class="widefat" value="<?php echo esc_attr($aud1_kicker ?: 'Para você'); ?>">
              </div>
              <div class="bireme-field">
                <label for="bireme_aud_1_title">Título do card</label>
                <input type="text" id="bireme_aud_1_title" name="bireme_aud_1_title" class="widefat" value="<?php echo esc_attr($aud1_title ?: 'Usuário'); ?>">
              </div>
            </div>

            <div class="bireme-two-col">
              <div class="bireme-field">
                <label>Ícone (opcional)</label>
                <div class="bireme-flex">
                  <input type="hidden" id="bireme_aud_1_icon_id" name="bireme_aud_1_icon_id" value="<?php echo esc_attr($aud1_icon); ?>">
                  <button type="button" class="button" onclick="biremePickImage(this,'#bireme_aud_1_icon_id','#bireme_aud_1_icon_prev')">Selecionar</button>
                  <button type="button" class="button link-delete" onclick="jQuery('#bireme_aud_1_icon_id').val('');jQuery('#bireme_aud_1_icon_prev').html('<em>Sem ícone.</em>')">Remover</button>
                </div>
                <div class="bireme-preview" id="bireme_aud_1_icon_prev"><?php echo $aud1_icon_url?'<img src="'.esc_url($aud1_icon_url).'" alt="">':'<em>Sem ícone.</em>';?></div>
              </div>
              <div class="bireme-field">
                <label for="bireme_aud_1_more_text">Link — texto</label>
                <input type="text" id="bireme_aud_1_more_text" name="bireme_aud_1_more_text" class="widefat" value="<?php echo esc_attr($aud1_more_t ?: 'Outras informações'); ?>">
                <label for="bireme_aud_1_more_url" style="margin-top:8px">Link — URL</label>
                <input type="text" id="bireme_aud_1_more_url" name="bireme_aud_1_more_url" class="widefat" value="<?php echo esc_attr($aud1_more_u); ?>">
              </div>
            </div>

            <!-- Repetidor -->
            <div class="bireme-field">
              <label>Linhas do card (repetidor)</label>
              <div class="bireme-repeater" data-repeater>
                <div class="bireme-repeater__head">
                  <strong>Itens</strong>
                  <button class="button button-small" data-repeater-add type="button">+ Adicionar linha</button>
                </div>
                <div class="bireme-repeater__rows">
                  <?php
                  $rows = !empty($aud1_items) ? $aud1_items : [''];
                  foreach($rows as $r){
                      $lab = esc_attr($r['label'] ?? '');
                      $url = esc_attr($r['url'] ?? '');
                      echo '<div class="bireme-repeater__row">
                              <input type="text" name="bireme_aud_1_items[label][]" value="'.$lab.'" placeholder="Ex.: Pesquise na LILACS" style="flex:1; min-width:220px">
                              <input type="text" name="bireme_aud_1_items[url][]"   value="'.$url.'" placeholder="URL (opcional)" style="width:260px">
                              <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
                            </div>';
                  }
                  ?>
                </div>
                <!-- protótipo oculto -->
                <div data-repeater-proto style="display:none">
                  <div class="bireme-repeater__row">
                    <input type="text" name="bireme_aud_1_items[label][]" value="" placeholder="Ex.: Pesquise na LILACS" style="flex:1; min-width:220px">
                    <input type="text" name="bireme_aud_1_items[url][]"   value="" placeholder="URL (opcional)" style="width:260px">
                    <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- CARD 2 -->
          <div class="bireme-card">
            <h4>Card 2</h4>
            <div class="bireme-two-col">
              <div class="bireme-field">
                <label for="bireme_aud_2_kicker">Kicker (linha de topo)</label>
                <input type="text" id="bireme_aud_2_kicker" name="bireme_aud_2_kicker" class="widefat" value="<?php echo esc_attr($aud2_kicker ?: 'Para sua'); ?>">
              </div>
              <div class="bireme-field">
                <label for="bireme_aud_2_title">Título do card</label>
                <input type="text" id="bireme_aud_2_title" name="bireme_aud_2_title" class="widefat" value="<?php echo esc_attr($aud2_title ?: 'Revista'); ?>">
              </div>
            </div>

            <div class="bireme-two-col">
              <div class="bireme-field">
                <label>Ícone (opcional)</label>
                <div class="bireme-flex">
                  <input type="hidden" id="bireme_aud_2_icon_id" name="bireme_aud_2_icon_id" value="<?php echo esc_attr($aud2_icon); ?>">
                  <button type="button" class="button" onclick="biremePickImage(this,'#bireme_aud_2_icon_id','#bireme_aud_2_icon_prev')">Selecionar</button>
                  <button type="button" class="button link-delete" onclick="jQuery('#bireme_aud_2_icon_id').val('');jQuery('#bireme_aud_2_icon_prev').html('<em>Sem ícone.</em>')">Remover</button>
                </div>
                <div class="bireme-preview" id="bireme_aud_2_icon_prev"><?php echo $aud2_icon_url?'<img src="'.esc_url($aud2_icon_url).'" alt="">':'<em>Sem ícone.</em>';?></div>
              </div>
              <div class="bireme-field">
                <label for="bireme_aud_2_more_text">Link — texto</label>
                <input type="text" id="bireme_aud_2_more_text" name="bireme_aud_2_more_text" class="widefat" value="<?php echo esc_attr($aud2_more_t ?: 'Outras informações'); ?>">
                <label for="bireme_aud_2_more_url" style="margin-top:8px">Link — URL</label>
                <input type="text" id="bireme_aud_2_more_url" name="bireme_aud_2_more_url" class="widefat" value="<?php echo esc_attr($aud2_more_u); ?>">
              </div>
            </div>

            <div class="bireme-field">
              <label>Linhas do card (repetidor)</label>
              <div class="bireme-repeater" data-repeater>
                <div class="bireme-repeater__head">
                  <strong>Itens</strong>
                  <button class="button button-small" data-repeater-add type="button">+ Adicionar linha</button>
                </div>
                <div class="bireme-repeater__rows">
                  <?php
                  $rows = !empty($aud2_items) ? $aud2_items : [''];
                  foreach($rows as $r){
                      $lab = esc_attr($r['label'] ?? '');
                      $url = esc_attr($r['url'] ?? '');
                      echo '<div class="bireme-repeater__row">
                              <input type="text" name="bireme_aud_2_items[label][]" value="'.$lab.'" placeholder="Ex.: Indexe sua revista" style="flex:1; min-width:220px">
                              <input type="text" name="bireme_aud_2_items[url][]"   value="'.$url.'" placeholder="URL (opcional)" style="width:260px">
                              <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
                            </div>';
                  }
                  ?>
                </div>
                <div data-repeater-proto style="display:none">
                  <div class="bireme-repeater__row">
                    <input type="text" name="bireme_aud_2_items[label][]" value="" placeholder="Ex.: Indexe sua revista" style="flex:1; min-width:220px">
                    <input type="text" name="bireme_aud_2_items[url][]"   value="" placeholder="URL (opcional)" style="width:260px">
                    <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- CARD 3 -->
          <div class="bireme-card">
            <h4>Card 3</h4>
            <div class="bireme-two-col">
              <div class="bireme-field">
                <label for="bireme_aud_3_kicker">Kicker (linha de topo)</label>
                <input type="text" id="bireme_aud_3_kicker" name="bireme_aud_3_kicker" class="widefat" value="<?php echo esc_attr($aud3_kicker ?: 'Para sua'); ?>">
              </div>
              <div class="bireme-field">
                <label for="bireme_aud_3_title">Título do card</label>
                <input type="text" id="bireme_aud_3_title" name="bireme_aud_3_title" class="widefat" value="<?php echo esc_attr($aud3_title ?: 'Instituição'); ?>">
              </div>
            </div>

            <div class="bireme-two-col">
              <div class="bireme-field">
                <label>Ícone (opcional)</label>
                <div class="bireme-flex">
                  <input type="hidden" id="bireme_aud_3_icon_id" name="bireme_aud_3_icon_id" value="<?php echo esc_attr($aud3_icon); ?>">
                  <button type="button" class="button" onclick="biremePickImage(this,'#bireme_aud_3_icon_id','#bireme_aud_3_icon_prev')">Selecionar</button>
                  <button type="button" class="button link-delete" onclick="jQuery('#bireme_aud_3_icon_id').val('');jQuery('#bireme_aud_3_icon_prev').html('<em>Sem ícone.</em>')">Remover</button>
                </div>
                <div class="bireme-preview" id="bireme_aud_3_icon_prev"><?php echo $aud3_icon_url?'<img src="'.esc_url($aud3_icon_url).'" alt="">':'<em>Sem ícone.</em>';?></div>
              </div>
              <div class="bireme-field">
                <label for="bireme_aud_3_more_text">Link — texto</label>
                <input type="text" id="bireme_aud_3_more_text" name="bireme_aud_3_more_text" class="widefat" value="<?php echo esc_attr($aud3_more_t ?: 'Outras informações'); ?>">
                <label for="bireme_aud_3_more_url" style="margin-top:8px">Link — URL</label>
                <input type="text" id="bireme_aud_3_more_url" name="bireme_aud_3_more_url" class="widefat" value="<?php echo esc_attr($aud3_more_u); ?>">
              </div>
            </div>

            <div class="bireme-field">
              <label>Linhas do card (repetidor)</label>
              <div class="bireme-repeater" data-repeater>
                <div class="bireme-repeater__head">
                  <strong>Itens</strong>
                  <button class="button button-small" data-repeater-add type="button">+ Adicionar linha</button>
                </div>
                <div class="bireme-repeater__rows">
                  <?php
                  $rows = !empty($aud3_items) ? $aud3_items : [''];
                  foreach($rows as $r){
                      $lab = esc_attr($r['label'] ?? '');
                      $url = esc_attr($r['url'] ?? '');
                      echo '<div class="bireme-repeater__row">
                              <input type="text" name="bireme_aud_3_items[label][]" value="'.$lab.'" placeholder="Ex.: Quero me tornar um Centro Cooperante" style="flex:1; min-width:220px">
                              <input type="text" name="bireme_aud_3_items[url][]"   value="'.$url.'" placeholder="URL (opcional)" style="width:260px">
                              <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
                            </div>';
                  }
                  ?>
                </div>
                <div data-repeater-proto style="display:none">
                  <div class="bireme-repeater__row">
                    <input type="text" name="bireme_aud_3_items[label][]" value="" placeholder="Ex.: Quero me tornar um Centro Cooperante" style="flex:1; min-width:220px">
                    <input type="text" name="bireme_aud_3_items[url][]"   value="" placeholder="URL (opcional)" style="width:260px">
                    <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- /CARD 3 -->
        </div><!-- /grid -->
      </div><!-- /tab-4 -->
      
      
      <!-- Dobra 5 — Revistas indexadas -->
<div class="bireme-tab" id="bireme-tab-5">
  <div class="bireme-field">
    <label for="bireme_jr_title">Título da seção</label>
    <input type="text" id="bireme_jr_title" name="bireme_jr_title" class="widefat"
           value="<?php echo esc_attr($jr_title ?: 'Revistas indexadas na LILACS'); ?>">
  </div>
  <div class="bireme-field">
    <label for="bireme_jr_sub">Subtítulo / descrição</label>
    <textarea id="bireme_jr_sub" name="bireme_jr_sub" class="widefat" rows="2"><?php echo esc_textarea($jr_sub ?: 'Consulte os periódicos científicos de referência da América Latina e Caribe...'); ?></textarea>
  </div>

  <div class="bireme-field">
    <label>Itens (repetidor de pílulas)</label>
    <div class="bireme-repeater" data-repeater>
      <div class="bireme-repeater__head">
        <strong>País / Total / Link / Destaque</strong>
        <button class="button button-small" data-repeater-add type="button">+ Adicionar item</button>
      </div>
      <div class="bireme-repeater__rows">
        <?php
        $rows = !empty($jr_items) ? $jr_items : [
          ['label'=>'Total Geral','total'=>'934','url'=>'','accent'=>0],
          ['label'=>'Argentina','total'=>'128','url'=>'','accent'=>0],
          ['label'=>'Bolívia','total'=>'14','url'=>'','accent'=>0],
          ['label'=>'Brasil','total'=>'316','url'=>'','accent'=>0],
          ['label'=>'Ver mais','total'=>'','url'=>'','accent'=>1],
        ];
        foreach($rows as $r){
          $label  = esc_attr($r['label'] ?? '');
          $total  = esc_attr($r['total'] ?? '');
          $url    = esc_url($r['url'] ?? '');
          $accent = !empty($r['accent']) ? 'checked' : '';
          echo '
          <div class="bireme-repeater__row" style="flex-wrap:wrap">
            <input type="text" name="bireme_jr_items[label][]" value="'.$label.'" placeholder="Rótulo (ex.: Brasil)" style="min-width:220px">
            <input type="text" name="bireme_jr_items[total][]" value="'.$total.'" placeholder="Total (ex.: 316)" style="width:140px">
            <input type="text" name="bireme_jr_items[url][]" value="'.$url.'" placeholder="URL" style="min-width:260px;flex:1">
            <label style="display:flex;align-items:center;gap:6px">
              <input type="checkbox" name="bireme_jr_items[accent][]" value="1" '.$accent.'>
              Destaque (laranja)
            </label>
            <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
          </div>';
        }
        ?>
      </div>

      <!-- Protótipo oculto -->
      <div data-repeater-proto style="display:none">
        <div class="bireme-repeater__row" style="flex-wrap:wrap">
          <input type="text" name="bireme_jr_items[label][]" value="" placeholder="Rótulo">
          <input type="text" name="bireme_jr_items[total][]" value="" placeholder="Total">
          <input type="text"  name="bireme_jr_items[url][]"   value="" placeholder="URL" style="min-width:260px;flex:1">
          <label style="display:flex;align-items:center;gap:6px">
            <input type="checkbox" name="bireme_jr_items[accent][]" value="1">
            Destaque (laranja)
          </label>
          <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
        </div>
      </div>
    </div>
    <p class="bireme-hint">Marque “Destaque” para gerar a pílula laranja (ex.: “Ver mais”).</p>
  </div>
</div>


<!-- Dobra 6 — Banner (slides) -->
<div class="bireme-tab" id="bireme-tab-6">
  <div class="bireme-field">
    <p class="bireme-hint">Cadastre apenas imagens. Opcionalmente informe a URL de destino ao clicar e o texto ALT.</p>
  </div>

  <div class="bireme-repeater" data-repeater>
    <div class="bireme-repeater__head">
      <strong>Slides</strong>
      <button class="button button-small" data-repeater-add type="button">+ Adicionar slide</button>
    </div>

    <div class="bireme-repeater__rows">
      <?php
      $rows = !empty($sl_items) ? $sl_items : [
        // Exemplo inicial vazio
        ['id' => 0, 'url' => '', 'alt' => ''],
      ];
      foreach ($rows as $r) {
        $img_id  = (int)($r['id'] ?? 0);
        $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'large') : '';
        $url     = esc_url($r['url'] ?? '');
        $alt     = esc_attr($r['alt'] ?? '');
        ?>
        <div class="bireme-repeater__row bireme-slide-row" style="flex-wrap:wrap">
          <div class="bireme-preview bireme-slide-preview" style="min-width:260px">
            <?php echo $img_url ? '<img src="'.esc_url($img_url).'" alt="">' : '<em>Sem imagem.</em>'; ?>
          </div>
          <div style="flex:1; min-width:280px">
            <input type="hidden" name="bireme_slider_items[id][]" value="<?php echo esc_attr($img_id); ?>">
            <div class="bireme-flex" style="margin:6px 0">
              <button type="button" class="button bireme-pick">Selecionar imagem</button>
              <button type="button" class="button link-delete bireme-clear">Remover imagem</button>
            </div>
            <label>URL (opcional)</label>
            <input type="text" name="bireme_slider_items[url][]" class="widefat" value="<?php echo esc_attr($url); ?>" placeholder="https://...">
            <label style="margin-top:6px">ALT (opcional)</label>
            <input type="text" name="bireme_slider_items[alt][]" class="widefat" value="<?php echo $alt; ?>" placeholder="Texto alternativo da imagem">
          </div>
          <button class="button button-link-delete" data-repeater-del type="button">Excluir slide</button>
        </div>
      <?php } ?>
    </div>

    <!-- Protótipo oculto -->
    <div data-repeater-proto style="display:none">
      <div class="bireme-repeater__row bireme-slide-row" style="flex-wrap:wrap">
        <div class="bireme-preview bireme-slide-preview" style="min-width:260px"><em>Sem imagem.</em></div>
        <div style="flex:1; min-width:280px">
          <input type="hidden" name="bireme_slider_items[id][]" value="0">
          <div class="bireme-flex" style="margin:6px 0">
            <button type="button" class="button bireme-pick">Selecionar imagem</button>
            <button type="button" class="button link-delete bireme-clear">Remover imagem</button>
          </div>
          <label>URL (opcional)</label>
          <input type="text" name="bireme_slider_items[url][]" class="widefat" value="">
          <label style="margin-top:6px">ALT (opcional)</label>
          <input type="text" name="bireme_slider_items[alt][]" class="widefat" value="">
        </div>
        <button class="button button-link-delete" data-repeater-del type="button">Excluir slide</button>
      </div>
    </div>
  </div>
</div>


<!-- Dobra 7 — Publicações recentes -->
<div class="bireme-tab" id="bireme-tab-7">
  <div class="bireme-field">
    <label for="bireme_rc_title">Título da seção</label>
    <input type="text" id="bireme_rc_title" name="bireme_rc_title" class="widefat"
           value="<?php echo esc_attr($rc_title ?: 'Publicações recentes em saúde'); ?>">
  </div>
  <div class="bireme-field">
    <label for="bireme_rc_sub">Subtítulo / descrição</label>
    <textarea id="bireme_rc_sub" name="bireme_rc_sub" class="widefat" rows="2"><?php
      echo esc_textarea($rc_sub ?: 'Acompanhe os conteúdos disponibilizados continuamente pela LILACS, refletindo a produção científica da América Latina e Caribe.'); ?></textarea>
  </div>

  <!-- Seletor de fonte -->
  <div class="bireme-source-toggle">
    <strong>Fonte dos dados:</strong>
    <label>
      <input type="radio" name="bireme_rc_source_type" value="manual" <?php checked($rc_source_type, 'manual'); ?>>
      Inserção manual (lista personalizada)
    </label>
    <label>
      <input type="radio" name="bireme_rc_source_type" value="rss" <?php checked($rc_source_type, 'rss'); ?>>
      RSS Feed automático
    </label>
  </div>

  <!-- Campos RSS -->
  <div class="bireme-rss-fields" style="display:none;">
    <div class="bireme-field">
      <label for="bireme_rc_rss_url">URL do RSS Feed</label>
      <input type="url" id="bireme_rc_rss_url" name="bireme_rc_rss_url" class="widefat"
             value="<?php echo esc_attr($rc_rss_url); ?>"
             placeholder="https://pesquisa.bvsalud.org/portal/...">
      <p class="description">Cole aqui a URL do feed RSS que contém as publicações da LILACS.</p>
    </div>
    
    <div class="bireme-field">
      <label for="bireme_rc_rss_limit">Número máximo de itens</label>
      <input type="number" id="bireme_rc_rss_limit" name="bireme_rc_rss_limit" 
             value="<?php echo esc_attr($rc_rss_limit); ?>" min="1" max="20" style="width:80px;">
      <p class="description">Quantos itens do RSS exibir (máximo 20).</p>
    </div>

    <div class="bireme-rss-test">
      <button type="button" class="button bireme-test-rss">Testar RSS</button>
      <div class="bireme-rss-test-result" style="margin-top:8px;"></div>
    </div>
  </div>

  <!-- Campos manuais -->
  <div class="bireme-manual-fields">
    <div class="bireme-field">
      <label>Itens (repetidor de publicações)</label>
      <div class="bireme-repeater" data-repeater>
        <div class="bireme-repeater__head">
          <strong>Título + URL</strong>
          <button class="button button-small" data-repeater-add type="button">+ Adicionar item</button>
        </div>

        <div class="bireme-repeater__rows">
          <?php
          $rows = !empty($rc_items) ? $rc_items : [
            ['title'=>'O processo de desinstitucionalização...', 'url'=>''],
            ['title'=>'Impact of the armed conflict on victims...', 'url'=>''],
            ['title'=>'Methemoglobinemia secundária...', 'url'=>''],
          ];
          foreach($rows as $r){
            $t = esc_attr($r['title'] ?? '');
            $u = esc_url($r['url'] ?? '');
            echo '
            <div class="bireme-repeater__row" style="flex-wrap:wrap">
              <input type="text" name="bireme_rc_items[title][]" value="'.$t.'" placeholder="Título da publicação" style="flex:1; min-width:280px">
              <input type="text"  name="bireme_rc_items[url][]"   value="'.$u.'" placeholder="URL" style="flex:1; min-width:260px">
              <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
            </div>';
          }
          ?>
        </div>

        <!-- Protótipo oculto -->
        <div data-repeater-proto style="display:none">
          <div class="bireme-repeater__row" style="flex-wrap:wrap">
            <input type="text" name="bireme_rc_items[title][]" value="" placeholder="Título da publicação" style="flex:1; min-width:280px">
            <input type="text"  name="bireme_rc_items[url][]"   value="" placeholder="URL" style="flex:1; min-width:260px">
            <button class="button button-link-delete" data-repeater-del type="button">Remover</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Dobra 8 — Dados e indicadores -->
        <div class="bireme-tab" id="bireme-tab-8">
          <div class="bireme-field">
            <label for="bireme_di_title">Título da seção</label>
            <input type="text" id="bireme_di_title" name="bireme_di_title" class="widefat"
                  value="<?php echo esc_attr($di_title ?: 'LILACS em dados e indicadores'); ?>">
          </div>
          <div class="bireme-field">
            <label for="bireme_di_sub">Subtítulo / descrição</label>
            <textarea id="bireme_di_sub" name="bireme_di_sub" class="widefat" rows="2"><?php
              echo esc_textarea($di_sub ?: 'Os números que expressam o alcance, a relevância e o desenvolvimento da ciência em saúde na América Latina e Caribe.'); ?></textarea>
          </div>

          <div class="bireme-two-col">
            <div class="bireme-field">
              <label for="bireme_di_btn_txt">Botão — texto</label>
              <input type="text" id="bireme_di_btn_txt" name="bireme_di_btn_txt" class="widefat"
                    value="<?php echo esc_attr($di_btn_txt ?: 'Ver todos'); ?>">
            </div>
            <div class="bireme-field">
      <label for="bireme_di_btn_url">Botão — URL</label>
      <input type="text" id="bireme_di_btn_url" name="bireme_di_btn_url" class="widefat"
        value="<?php echo esc_attr($di_btn_url); ?>">
            </div>
          </div>
        <div class="bireme-card-grid" style="grid-template-columns:1fr; gap:20px">
          <?php for($i=1;$i<=4;$i++): ?>
            <div class="bireme-card">
              <h4>Caixa <?php echo $i; ?></h4>
              <div class="bireme-two-col">
                <div class="bireme-field">
                  <label for="bireme_di_<?php echo $i; ?>_title">Título da caixa</label>
                  <input type="text" id="bireme_di_<?php echo $i; ?>_title" name="bireme_di_<?php echo $i; ?>_title" class="widefat"
                        value="<?php echo esc_attr($di[$i]['title']); ?>">
                </div>
                <div class="bireme-field">
      <label for="bireme_di_<?php echo $i; ?>_url">URL da caixa</label>
      <input type="text" id="bireme_di_<?php echo $i; ?>_url" name="bireme_di_<?php echo $i; ?>_url" class="widefat"
        value="<?php echo esc_attr($di[$i]['url']); ?>">
                </div>
              </div>

              <div class="bireme-field">
                <label>Ícone (imagem)</label>
                <div class="bireme-two-col">
                  <div class="bireme-preview" id="bireme_di_<?php echo $i; ?>_icon_prev">
                    <?php echo $di[$i]['icon_url'] ? '<img src="'.esc_url($di[$i]['icon_url']).'" alt="">' : '<em>Sem ícone.</em>'; ?>
                  </div>
                  <div>
                    <input type="hidden" id="bireme_di_<?php echo $i; ?>_icon_id" name="bireme_di_<?php echo $i; ?>_icon_id"
                          value="<?php echo esc_attr($di[$i]['icon_id']); ?>">
                    <button type="button" class="button"
                      onclick="biremePickImage(this,'#bireme_di_<?php echo $i; ?>_icon_id','#bireme_di_<?php echo $i; ?>_icon_prev')">Selecionar</button>
                    <button type="button" class="button link-delete"
                      onclick="jQuery('#bireme_di_<?php echo $i; ?>_icon_id').val('');jQuery('#bireme_di_<?php echo $i; ?>_icon_prev').html('<em>Sem ícone.</em>')">Remover</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endfor; ?>
        </div>

</div>

<!-- Dobra 9 — Depoimentos -->
<div class="bireme-tab" id="bireme-tab-9">
  <div class="bireme-field">
    <label for="bireme_dep_title">Título da seção</label>
    <input type="text" id="bireme_dep_title" name="bireme_dep_title" class="widefat"
           value="<?php echo esc_attr($dep_title ?: 'Depoimentos'); ?>">
  </div>

  <div class="bireme-field">
    <label>Itens (repetidor)</label>
    <div class="bireme-repeater" data-repeater>
      <div class="bireme-repeater__head">
        <strong>Avatar, Nome, Profissão e Texto</strong>
        <button class="button button-small" data-repeater-add type="button">+ Adicionar</button>
      </div>

      <div class="bireme-repeater__rows">
        <?php
        $rows = !empty($dep_items) ? $dep_items : [
          ['avatar'=>0,'name'=>'','role'=>'','text'=>''],
          ['avatar'=>0,'name'=>'','role'=>'','text'=>''],
        ];
        foreach($rows as $r):
          $id  = (int)($r['avatar'] ?? 0);
          $url = $id ? wp_get_attachment_image_url($id,'thumbnail') : '';
          $name = esc_attr($r['name'] ?? '');
          $role = esc_attr($r['role'] ?? '');
          $text = esc_textarea($r['text'] ?? '');
        ?>
        <div class="bireme-repeater__row bireme-dep-row" style="flex-wrap:wrap;align-items:flex-start">
          <div class="bireme-preview bireme-dep-avatar-prev" style="min-width:82px">
            <?php echo $url?'<img src="'.esc_url($url).'" alt="" style="width:72px;height:72px;border-radius:50%;object-fit:cover">':'<em>Sem avatar.</em>'; ?>
          </div>
          <div style="flex:1;min-width:280px">
            <input type="hidden" name="bireme_dep_items[avatar][]" value="<?php echo esc_attr($id); ?>">
            <div class="bireme-flex" style="margin:6px 0">
              <button type="button" class="button bireme-pick-avatar">Selecionar avatar</button>
              <button type="button" class="button link-delete bireme-clear-avatar">Remover</button>
            </div>
            <div class="bireme-two-col">
              <div class="bireme-field">
                <label>Nome</label>
                <input type="text" name="bireme_dep_items[name][]" class="widefat" value="<?php echo $name; ?>">
              </div>
              <div class="bireme-field">
                <label>Profissão</label>
                <input type="text" name="bireme_dep_items[role][]" class="widefat" value="<?php echo $role; ?>">
              </div>
            </div>
            <div class="bireme-field">
              <label>Texto</label>
              <textarea name="bireme_dep_items[text][]" class="widefat" rows="3"><?php echo $text; ?></textarea>
            </div>
          </div>
          <button class="button button-link-delete" data-repeater-del type="button">Excluir</button>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Protótipo -->
      <div data-repeater-proto style="display:none">
        <div class="bireme-repeater__row bireme-dep-row" style="flex-wrap:wrap;align-items:flex-start">
          <div class="bireme-preview bireme-dep-avatar-prev" style="min-width:82px"><em>Sem avatar.</em></div>
          <div style="flex:1;min-width:280px">
            <input type="hidden" name="bireme_dep_items[avatar][]" value="0">
            <div class="bireme-flex" style="margin:6px 0">
              <button type="button" class="button bireme-pick-avatar">Selecionar avatar</button>
              <button type="button" class="button link-delete bireme-clear-avatar">Remover</button>
            </div>
            <div class="bireme-two-col">
              <div class="bireme-field">
                <label>Nome</label>
                <input type="text" name="bireme_dep_items[name][]" value="">
              </div>
              <div class="bireme-field">
                <label>Profissão</label>
                <input type="text" name="bireme_dep_items[role][]" value="">
              </div>
            </div>
            <div class="bireme-field">
              <label>Texto</label>
              <textarea name="bireme_dep_items[text][]" rows="3"></textarea>
            </div>
          </div>
          <button class="button button-link-delete" data-repeater-del type="button">Excluir</button>
        </div>
      </div>
    </div>
  </div>
</div>



    </div>
    <?php
}


/** === SALVAMENTO === */
add_action('save_post_page', function($post_id){
    if (!bireme_lilacs_home_matches_template($post_id)) return;

    if (!isset($_POST['bireme_lilacs_home_nonce']) || !wp_verify_nonce($_POST['bireme_lilacs_home_nonce'], BIREME_LILACS_HOME_NONCE)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_page', $post_id)) return;

    // Dobra 1
    update_post_meta($post_id, '_bireme_hero_title', sanitize_text_field($_POST['bireme_hero_title'] ?? ''));
    update_post_meta($post_id, '_bireme_hero_desc',  wp_kses_post($_POST['bireme_hero_desc'] ?? ''));
    update_post_meta($post_id, '_bireme_hero_img_id', (int) ($_POST['bireme_hero_img_id'] ?? 0));

    // Dobra 2
    update_post_meta($post_id, '_bireme_cta_subtitle',      sanitize_text_field($_POST['bireme_cta_subtitle'] ?? ''));
    update_post_meta($post_id, '_bireme_cta_button_text',   sanitize_text_field($_POST['bireme_cta_button_text'] ?? ''));
    update_post_meta($post_id, '_bireme_cta_button_url',    esc_url_raw($_POST['bireme_cta_button_url'] ?? ''));
    update_post_meta($post_id, '_bireme_cta_bg_img_id',     (int) ($_POST['bireme_cta_bg_img_id'] ?? 0));
    

    // Dobra 3
    update_post_meta($post_id, '_bireme_extras_html', wp_kses_post($_POST['bireme_extras_html'] ?? ''));
    
    
        // [NOVO] Dobra 4 — Acessos rápidos
    update_post_meta($post_id, '_bireme_aud_title', sanitize_text_field($_POST['bireme_aud_title'] ?? ''));
    
    // Card 1
    update_post_meta($post_id, '_bireme_aud_1_kicker',     sanitize_text_field($_POST['bireme_aud_1_kicker'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_1_title',      sanitize_text_field($_POST['bireme_aud_1_title'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_1_icon_id',    (int) ($_POST['bireme_aud_1_icon_id'] ?? 0));
  // Card 1 — aceita label + url (paralelos)
  $aud1_labels = (array)($_POST['bireme_aud_1_items']['label'] ?? []);
  $aud1_urls   = (array)($_POST['bireme_aud_1_items']['url']   ?? []);
  $aud1_items = [];
  $max = max(count($aud1_labels), count($aud1_urls));
  for($i=0;$i<$max;$i++){
    $label = sanitize_text_field($aud1_labels[$i] ?? '');
    $url   = esc_url_raw($aud1_urls[$i] ?? '');
    if ($label === '') continue;
    $aud1_items[] = ['label'=>$label, 'url'=>$url];
  }
  update_post_meta($post_id, '_bireme_aud_1_items', $aud1_items);
    update_post_meta($post_id, '_bireme_aud_1_more_text',  sanitize_text_field($_POST['bireme_aud_1_more_text'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_1_more_url',   esc_url_raw($_POST['bireme_aud_1_more_url'] ?? ''));
    
    // Card 2
    update_post_meta($post_id, '_bireme_aud_2_kicker',     sanitize_text_field($_POST['bireme_aud_2_kicker'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_2_title',      sanitize_text_field($_POST['bireme_aud_2_title'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_2_icon_id',    (int) ($_POST['bireme_aud_2_icon_id'] ?? 0));
  // Card 2 — aceita label + url (paralelos)
  $aud2_labels = (array)($_POST['bireme_aud_2_items']['label'] ?? []);
  $aud2_urls   = (array)($_POST['bireme_aud_2_items']['url']   ?? []);
  $aud2_items = [];
  $max = max(count($aud2_labels), count($aud2_urls));
  for($i=0;$i<$max;$i++){
    $label = sanitize_text_field($aud2_labels[$i] ?? '');
    $url   = esc_url_raw($aud2_urls[$i] ?? '');
    if ($label === '') continue;
    $aud2_items[] = ['label'=>$label, 'url'=>$url];
  }
  update_post_meta($post_id, '_bireme_aud_2_items', $aud2_items);
    update_post_meta($post_id, '_bireme_aud_2_more_text',  sanitize_text_field($_POST['bireme_aud_2_more_text'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_2_more_url',   esc_url_raw($_POST['bireme_aud_2_more_url'] ?? ''));
    
    // Card 3
    update_post_meta($post_id, '_bireme_aud_3_kicker',     sanitize_text_field($_POST['bireme_aud_3_kicker'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_3_title',      sanitize_text_field($_POST['bireme_aud_3_title'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_3_icon_id',    (int) ($_POST['bireme_aud_3_icon_id'] ?? 0));
  // Card 3 — aceita label + url (paralelos)
  $aud3_labels = (array)($_POST['bireme_aud_3_items']['label'] ?? []);
  $aud3_urls   = (array)($_POST['bireme_aud_3_items']['url']   ?? []);
  $aud3_items = [];
  $max = max(count($aud3_labels), count($aud3_urls));
  for($i=0;$i<$max;$i++){
    $label = sanitize_text_field($aud3_labels[$i] ?? '');
    $url   = esc_url_raw($aud3_urls[$i] ?? '');
    if ($label === '') continue;
    $aud3_items[] = ['label'=>$label, 'url'=>$url];
  }
  update_post_meta($post_id, '_bireme_aud_3_items', $aud3_items);
    update_post_meta($post_id, '_bireme_aud_3_more_text',  sanitize_text_field($_POST['bireme_aud_3_more_text'] ?? ''));
    update_post_meta($post_id, '_bireme_aud_3_more_url',   esc_url_raw($_POST['bireme_aud_3_more_url'] ?? ''));

  // Hero quick links (novo)
  update_post_meta($post_id, '_bireme_hero_link1_text', sanitize_text_field($_POST['bireme_hero_link1_text'] ?? ''));
  update_post_meta($post_id, '_bireme_hero_link1_url',  esc_url_raw($_POST['bireme_hero_link1_url'] ?? ''));
  update_post_meta($post_id, '_bireme_hero_link2_text', sanitize_text_field($_POST['bireme_hero_link2_text'] ?? ''));
  update_post_meta($post_id, '_bireme_hero_link2_url',  esc_url_raw($_POST['bireme_hero_link2_url'] ?? ''));
  update_post_meta($post_id, '_bireme_hero_link3_text', sanitize_text_field($_POST['bireme_hero_link3_text'] ?? ''));
  update_post_meta($post_id, '_bireme_hero_link3_url',  esc_url_raw($_POST['bireme_hero_link3_url'] ?? ''));
    
    
    // Dobra 5 — Revistas indexadas
    update_post_meta($post_id, '_bireme_jr_title', sanitize_text_field($_POST['bireme_jr_title'] ?? ''));
    update_post_meta($post_id, '_bireme_jr_sub',   sanitize_text_field($_POST['bireme_jr_sub'] ?? ''));


    // Dobra 6 — Banner (slides)
    $ids = (array)($_POST['bireme_slider_items']['id']  ?? []);
    $urls= (array)($_POST['bireme_slider_items']['url'] ?? []);
    $alts= (array)($_POST['bireme_slider_items']['alt'] ?? []);

    $slides = [];
    $max = max(count($ids), count($urls), count($alts));
    for ($i=0; $i<$max; $i++){
        $id  = (int) ($ids[$i]  ?? 0);
        $url = esc_url_raw($urls[$i] ?? '');
        $alt = sanitize_text_field($alts[$i] ?? '');
        // mantém só linhas com imagem selecionada
        if ($id > 0) {
            $slides[] = ['id' => $id, 'url' => $url, 'alt' => $alt];
        }
    }
    update_post_meta($post_id, '_bireme_slider_items', $slides);


    // Dobra 9 — Depoimentos
    update_post_meta($post_id, '_bireme_dep_title', sanitize_text_field($_POST['bireme_dep_title'] ?? ''));

    $av = (array)($_POST['bireme_dep_items']['avatar'] ?? []);
    $nm = (array)($_POST['bireme_dep_items']['name']   ?? []);
    $rl = (array)($_POST['bireme_dep_items']['role']   ?? []);
    $tx = (array)($_POST['bireme_dep_items']['text']   ?? []);
    $items = [];
    $max = max(count($av), count($nm), count($rl), count($tx));
    for($i=0;$i<$max;$i++){
      $name = sanitize_text_field($nm[$i] ?? '');
      $role = sanitize_text_field($rl[$i] ?? '');
      $text = sanitize_textarea_field($tx[$i] ?? '');
      $id   = (int)($av[$i] ?? 0);
      if($name==='' && $text==='') continue; // evita linhas vazias
      $items[] = ['avatar'=>$id, 'name'=>$name, 'role'=>$role, 'text'=>$text];
    }
    update_post_meta($post_id, '_bireme_dep_items', $items);


    // === Raio-X da LILACS ===
update_post_meta($post_id, '_bireme_rx_title',          sanitize_text_field($_POST['bireme_rx_title'] ?? ''));
update_post_meta($post_id, '_bireme_rx_left_title',     sanitize_text_field($_POST['bireme_rx_left_title'] ?? ''));
update_post_meta($post_id, '_bireme_rx_left_text',      sanitize_text_field($_POST['bireme_rx_left_text'] ?? ''));
update_post_meta($post_id, '_bireme_rx_center_number',  sanitize_text_field($_POST['bireme_rx_center_number'] ?? ''));
update_post_meta($post_id, '_bireme_rx_center_label',   sanitize_text_field($_POST['bireme_rx_center_label'] ?? ''));
update_post_meta($post_id, '_bireme_rx_right_title',    sanitize_text_field($_POST['bireme_rx_right_title'] ?? ''));
update_post_meta($post_id, '_bireme_rx_right_text',     sanitize_text_field($_POST['bireme_rx_right_text'] ?? ''));

// Normaliza cores (#RRGGBB)
$norm_hex = function($c){
  $c = trim((string)$c);
  if ($c === '') return '';
  if ($c[0] !== '#') $c = '#'.$c;
  if (preg_match('/^#[0-9a-fA-F]{6}$/',$c)) return strtoupper($c);
  return '#000000';
};

// Chart 1
$c1_lab = (array)($_POST['bireme_rx_chart1']['label'] ?? []);
$c1_val = (array)($_POST['bireme_rx_chart1']['value'] ?? []);
$c1_col = (array)($_POST['bireme_rx_chart1']['color'] ?? []);
$items1 = [];
$max = max(count($c1_lab), count($c1_val), count($c1_col));
for($i=0;$i<$max;$i++){
  $lab = sanitize_text_field($c1_lab[$i] ?? '');
  $val = floatval($c1_val[$i] ?? 0);
  $col = $norm_hex($c1_col[$i] ?? '');
  if($lab==='') continue;
  $items1[] = ['label'=>$lab,'value'=>$val,'color'=>$col];
}
update_post_meta($post_id, '_bireme_rx_chart1', $items1);

// Chart 2
$c2_lab = (array)($_POST['bireme_rx_chart2']['label'] ?? []);
$c2_val = (array)($_POST['bireme_rx_chart2']['value'] ?? []);
$c2_col = (array)($_POST['bireme_rx_chart2']['color'] ?? []);
$items2 = [];
$max = max(count($c2_lab), count($c2_val), count($c2_col));
for($i=0;$i<$max;$i++){
  $lab = sanitize_text_field($c2_lab[$i] ?? '');
  $val = floatval($c2_val[$i] ?? 0);
  $col = $norm_hex($c2_col[$i] ?? '');
  if($lab==='') continue;
  $items2[] = ['label'=>$lab,'value'=>$val,'color'=>$col];
}
update_post_meta($post_id, '_bireme_rx_chart2', $items2);




// Normaliza arrays paralelos vindos do repetidor
$lab = (array)($_POST['bireme_jr_items']['label']  ?? []);
$tot = (array)($_POST['bireme_jr_items']['total']  ?? []);
$url = (array)($_POST['bireme_jr_items']['url']    ?? []);
$acc = (array)($_POST['bireme_jr_items']['accent'] ?? []);

$items = [];
$max = max(count($lab), count($tot), count($url));
for($i=0;$i<$max;$i++){
    $label  = sanitize_text_field($lab[$i] ?? '');
    $total  = sanitize_text_field($tot[$i] ?? '');
    $link   = esc_url_raw($url[$i] ?? '');
    $accent = !empty($acc[$i]) ? 1 : 0;
    if($label==='') continue; // ignora vazios
    $items[] = ['label'=>$label,'total'=>$total,'url'=>$link,'accent'=>$accent];
}
update_post_meta($post_id, '_bireme_jr_items', $items);

// Dobra 7 — Publicações recentes
update_post_meta($post_id, '_bireme_rc_title', sanitize_text_field($_POST['bireme_rc_title'] ?? ''));
update_post_meta($post_id, '_bireme_rc_sub',   sanitize_text_field($_POST['bireme_rc_sub'] ?? ''));

// Campos RSS
update_post_meta($post_id, '_bireme_rc_source_type', sanitize_text_field($_POST['bireme_rc_source_type'] ?? 'manual'));
update_post_meta($post_id, '_bireme_rc_rss_url', esc_url_raw($_POST['bireme_rc_rss_url'] ?? ''));
update_post_meta($post_id, '_bireme_rc_rss_limit', max(1, min(20, (int)($_POST['bireme_rc_rss_limit'] ?? 5))));

$tt = (array)($_POST['bireme_rc_items']['title'] ?? []);
$uu = (array)($_POST['bireme_rc_items']['url']   ?? []);
$items = [];
$max = max(count($tt), count($uu));
for($i=0; $i<$max; $i++){
  $title = sanitize_text_field($tt[$i] ?? '');
  $url   = esc_url_raw($uu[$i] ?? '');
  if($title==='') continue;
  $items[] = ['title'=>$title, 'url'=>$url];
}
update_post_meta($post_id, '_bireme_rc_items', $items);

// Dobra 8 — Dados e indicadores
update_post_meta($post_id, '_bireme_di_title',   sanitize_text_field($_POST['bireme_di_title'] ?? ''));
update_post_meta($post_id, '_bireme_di_sub',     sanitize_text_field($_POST['bireme_di_sub'] ?? ''));
update_post_meta($post_id, '_bireme_di_btn_txt', sanitize_text_field($_POST['bireme_di_btn_txt'] ?? ''));
update_post_meta($post_id, '_bireme_di_btn_url', esc_url_raw($_POST['bireme_di_btn_url'] ?? ''));

for($i=1;$i<=4;$i++){
  update_post_meta($post_id, "_bireme_di_{$i}_title",   sanitize_text_field($_POST["bireme_di_{$i}_title"] ?? ''));
  update_post_meta($post_id, "_bireme_di_{$i}_url",     esc_url_raw($_POST["bireme_di_{$i}_url"] ?? ''));
  update_post_meta($post_id, "_bireme_di_{$i}_icon_id", (int) ($_POST["bireme_di_{$i}_icon_id"] ?? 0));
}



}, 10, 1);

/** === HELPERS PARA O FRONT === */
if (!function_exists('bireme_get_lilacs_hero_meta')){
    function bireme_get_lilacs_hero_meta($post_id){
        $img_id  = (int) get_post_meta($post_id, '_bireme_hero_img_id', true);
    // Links rápidos do hero (se não definidos, mantém valores sensatos)
    $l1t = get_post_meta($post_id, '_bireme_hero_link1_text', true);
    $l1u = get_post_meta($post_id, '_bireme_hero_link1_url', true);
    $l2t = get_post_meta($post_id, '_bireme_hero_link2_text', true);
    $l2u = get_post_meta($post_id, '_bireme_hero_link2_url', true);
    $l3t = get_post_meta($post_id, '_bireme_hero_link3_text', true);
    $l3u = get_post_meta($post_id, '_bireme_hero_link3_url', true);

    return [
      'title'   => get_post_meta($post_id, '_bireme_hero_title', true),
      'desc'    => get_post_meta($post_id, '_bireme_hero_desc',  true),
      'img_id'  => $img_id,
      'img_url' => $img_id ? wp_get_attachment_image_url($img_id, 'full') : '',
      'links'   => [
        [ 'text' => $l1t ?: 'Busca avançada', 'url' => $l1u ?: '#busca-avancada' ],
        [ 'text' => $l2t ?: 'Busca com DeCS / MeSH', 'url' => $l2u ?: '#decs' ],
        [ 'text' => $l3t ?: 'Como pesquisar', 'url' => $l3u ?: '#como-pesquisar' ],
      ],
    ];
    }
}
if (!function_exists('bireme_get_lilacs_cta_meta')){
    function bireme_get_lilacs_cta_meta($post_id){
        $img_id  = (int) get_post_meta($post_id, '_bireme_cta_bg_img_id', true);
        return [
            'subtitle' => get_post_meta($post_id, '_bireme_cta_subtitle', true),
            'btn_text' => get_post_meta($post_id, '_bireme_cta_button_text', true),
            'btn_url'  => get_post_meta($post_id, '_bireme_cta_button_url', true),
            'img_id'   => $img_id,
            'img_url'  => $img_id ? wp_get_attachment_image_url($img_id, 'full') : '',
        ];
    }
}
if (!function_exists('bireme_get_lilacs_audiences_meta')){
    function bireme_get_lilacs_audiences_meta($post_id){
        $mk = function($k){ return get_post_meta($post_id, $k, true); };
        $mk_arr = function($k){ $v = get_post_meta($post_id, $k, true); return is_array($v)? $v : []; };

        $cards = [];
        for($i=1;$i<=3;$i++){
            $icon_id = (int) $mk("_bireme_aud_{$i}_icon_id");
            $cards[] = [
                'kicker'    => $mk("_bireme_aud_{$i}_kicker"),
                'title'     => $mk("_bireme_aud_{$i}_title"),
                'icon_id'   => $icon_id,
                'icon_url'  => $icon_id ? wp_get_attachment_image_url($icon_id, 'medium') : '',
                // Normaliza items: suporta formato antigo (strings) e novo (['label','url'])
                'items'     => array_map(function($it){ return is_array($it) ? ($it['label'] ?? '') : (string)$it; }, $mk_arr("_bireme_aud_{$i}_items")),
                // items_linked preserva label+url quando disponível (novo formato)
                'items_linked' => array_map(function($it){ if(is_array($it)) return ['label'=>($it['label'] ?? ''),'url'=>($it['url'] ?? '')]; return ['label'=>$it,'url'=>'']; }, $mk_arr("_bireme_aud_{$i}_items")),
                'more_text' => $mk("_bireme_aud_{$i}_more_text"),
                'more_url'  => $mk("_bireme_aud_{$i}_more_url"),
            ];
        }

        return [
            'section_title' => $mk('_bireme_aud_title'),
            'cards'         => $cards,
        ];
    }
}
if(!function_exists('bireme_get_lilacs_journals_meta')){
  function bireme_get_lilacs_journals_meta($post_id){
    $title = get_post_meta($post_id, '_bireme_jr_title', true);
    $sub   = get_post_meta($post_id, '_bireme_jr_sub', true);
    $items = get_post_meta($post_id, '_bireme_jr_items', true);
    if(!is_array($items)) $items = [];
    return [
      'title'   => $title,
      'subtitle'=> $sub,
      'items'   => $items
    ];
  }
}
if (!function_exists('bireme_get_lilacs_slider_meta')){
  function bireme_get_lilacs_slider_meta($post_id){
    $items = get_post_meta($post_id, '_bireme_slider_items', true);
    if (!is_array($items)) $items = [];
    // resolve URLs das imagens
    foreach ($items as &$it){
      $id = (int)($it['id'] ?? 0);
      $it['img_url'] = $id ? wp_get_attachment_image_url($id, 'full') : '';
    }
    return ['items' => $items];
  }
}
if (!function_exists('bireme_get_lilacs_recent_meta')){
  function bireme_get_lilacs_recent_meta($post_id){
    $source_type = get_post_meta($post_id, '_bireme_rc_source_type', true) ?: 'manual';
    $items = [];
    
    if ($source_type === 'rss') {
      $rss_url = get_post_meta($post_id, '_bireme_rc_rss_url', true);
      $rss_limit = (int) get_post_meta($post_id, '_bireme_rc_rss_limit', true) ?: 5;
      
      if ($rss_url) {
        $items = bireme_fetch_rss_items($rss_url, $rss_limit);
      }
    } else {
      $items = get_post_meta($post_id, '_bireme_rc_items', true);
      if(!is_array($items)) $items = [];
    }
    
    $title = get_post_meta($post_id, '_bireme_rc_title', true);
    $sub   = get_post_meta($post_id, '_bireme_rc_sub', true);
    return ['title'=>$title, 'subtitle'=>$sub, 'items'=>$items, 'source_type'=>$source_type];
  }
}
if (!function_exists('bireme_get_lilacs_di_meta')){
  function bireme_get_lilacs_di_meta($post_id){
    $res = [
      'title'   => get_post_meta($post_id, '_bireme_di_title', true),
      'subtitle'=> get_post_meta($post_id, '_bireme_di_sub', true),
      'btn_txt' => get_post_meta($post_id, '_bireme_di_btn_txt', true),
      'btn_url' => get_post_meta($post_id, '_bireme_di_btn_url', true),
      'boxes'   => []
    ];
    for ($i=1; $i<=4; $i++){
      $icon_id = (int) get_post_meta($post_id, "_bireme_di_{$i}_icon_id", true);
      $res['boxes'][] = [
        'title'    => get_post_meta($post_id, "_bireme_di_{$i}_title", true),
        'url'      => get_post_meta($post_id, "_bireme_di_{$i}_url", true),
        'icon_id'  => $icon_id,
        'icon_url' => $icon_id ? wp_get_attachment_image_url($icon_id, 'medium') : '',
      ];
    }
    return $res;
  }
}

if (!function_exists('bireme_get_lilacs_dep_meta')){
  function bireme_get_lilacs_dep_meta($post_id){
    $title = get_post_meta($post_id, '_bireme_dep_title', true);
    $items = get_post_meta($post_id, '_bireme_dep_items', true);
    if(!is_array($items)) $items = [];
    foreach($items as &$it){
      $id = (int)($it['avatar'] ?? 0);
      $it['avatar_url'] = $id ? wp_get_attachment_image_url($id, 'medium') : '';
    }
    return ['title'=>$title, 'items'=>$items];
  }
}

/** === FUNÇÕES RSS === */
if (!function_exists('bireme_fetch_rss_items')){
  function bireme_fetch_rss_items($rss_url, $limit = 5) {
    // Cache por 30 minutos
    $cache_key = 'bireme_rss_' . md5($rss_url . $limit);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
      return $cached;
    }

    $items = [];
    
    // Usar SimplePie (incluído no WordPress)
    $rss = fetch_feed($rss_url);
    
    if (is_wp_error($rss)) {
      error_log('BIREME RSS Error: ' . $rss->get_error_message());
      return [];
    }

    $maxitems = $rss->get_item_quantity($limit);
    $rss_items = $rss->get_items(0, $maxitems);

    foreach ($rss_items as $item) {
      $title = $item->get_title();
      $link = $item->get_link();
      $author = $item->get_author();
      $description = $item->get_description();
      
      // Extrair dados específicos do formato LILACS
      $source = '';
      if ($description) {
        // Tentar extrair source do CDATA
        if (preg_match('/Source:\s*<!\[CDATA\[\s*(.+?)\s*\]\]>/', $description, $matches)) {
          $source = trim($matches[1]);
        }
      }
      
      $items[] = [
        'title' => $title ?: 'Sem título',
        'url' => $link ?: '',
        'author' => $author ? $author->get_name() : '',
        'source' => $source,
        'description' => wp_trim_words(strip_tags($description), 30)
      ];
    }

    // Cache por 30 minutos
    set_transient($cache_key, $items, 30 * MINUTE_IN_SECONDS);
    
    return $items;
  }
}

// AJAX para testar RSS
add_action('wp_ajax_bireme_test_rss', 'bireme_test_rss_callback');
function bireme_test_rss_callback() {
  // Verificar nonce
  if (!wp_verify_nonce($_POST['nonce'] ?? '', 'bireme_test_rss')) {
    wp_die('Nonce inválido');
  }

  if (!current_user_can('edit_posts')) {
    wp_die('Permissões insuficientes');
  }

  $rss_url = sanitize_url($_POST['rss_url'] ?? '');
  
  if (empty($rss_url)) {
    wp_send_json_error('URL não fornecida');
  }

  // Testar o RSS
  $rss = fetch_feed($rss_url);
  
  if (is_wp_error($rss)) {
    wp_send_json_error($rss->get_error_message());
  }

  $maxitems = $rss->get_item_quantity(5);
  $rss_items = $rss->get_items(0, $maxitems);
  
  if (empty($rss_items)) {
    wp_send_json_error('Nenhum item encontrado no RSS');
  }

  $first_item = $rss_items[0];
  
  wp_send_json_success([
    'items' => count($rss_items),
    'first_title' => $first_item->get_title()
  ]);
}
