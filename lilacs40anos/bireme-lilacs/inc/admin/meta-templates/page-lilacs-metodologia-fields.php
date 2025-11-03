<?php
if (!defined('ABSPATH')) exit;

/** Constantes comuns */
if (!defined('BIREME_LILACS_CP_FIELDS_NONCE'))  define('BIREME_LILACS_CP_FIELDS_NONCE',  'bireme_lilacs_cp_fields_nonce');
if (!defined('BIREME_LILACS_CP_FIELDS_ACTION')) define('BIREME_LILACS_CP_FIELDS_ACTION', 'bireme_lilacs_cp_fields_action');

add_action('add_meta_boxes_page', function($post){
  if (!$post) return;
  $tpl = get_post_meta($post->ID, '_wp_page_template', true);
  if (basename($tpl) !== 'page-lilacs-metodologia.php') return;

  add_meta_box(
    'bireme_lilacs_metodologia_box',
    __('LILACS – Metodologia (Conteúdos)', 'bireme'),
    'bireme_lilacs_metodologia_metabox_cb',
    'page',
    'normal',
    'high'
  );
}, 10, 1);

function bireme_lilacs_metodologia_metabox_cb($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  // --- Banner
  $banner_title  = get_post_meta($post->ID, '_metod_banner_title', true);
  $banner_desc   = get_post_meta($post->ID, '_metod_banner_desc', true);
  $banner_img_id = (int) get_post_meta($post->ID, '_metod_banner_img', true);
  $banner_img    = $banner_img_id ? wp_get_attachment_image_url($banner_img_id, 'medium_large') : includes_url('images/media/default.png');

  // --- Guia de Seleção
  $guia_title = get_post_meta($post->ID, '_metod_guia_title', true);
  $guia_desc  = get_post_meta($post->ID, '_metod_guia_desc', true);
  $guia_btn   = get_post_meta($post->ID, '_metod_guia_btn', true);
  $guia_link  = get_post_meta($post->ID, '_metod_guia_link', true);

  // --- Critérios
  $crit_title     = get_post_meta($post->ID, '_metod_crit_title', true);
  $crit_btn1_text = get_post_meta($post->ID, '_metod_crit_btn1_text', true);
  $crit_btn1_link = get_post_meta($post->ID, '_metod_crit_btn1_link', true);
  $crit_btn2_text = get_post_meta($post->ID, '_metod_crit_btn2_text', true);
  $crit_btn2_link = get_post_meta($post->ID, '_metod_crit_btn2_link', true);
  
  // --- Padrões Internacionais (título + até 8 logos)
$padroes_title = get_post_meta($post->ID, '_metod_padroes_title', true);
$padroes_logos = [];
for ($i=1; $i<=8; $i++){
  $id  = (int) get_post_meta($post->ID, "_metod_padroes_logo_{$i}_id",  true);
  $url =        get_post_meta($post->ID, "_metod_padroes_logo_{$i}_url", true);
  $alt =        get_post_meta($post->ID, "_metod_padroes_logo_{$i}_alt", true);
  $thumb = $id ? wp_get_attachment_image_url($id, 'medium') : includes_url('images/media/default.png');
  $padroes_logos[$i] = ['id'=>$id,'url'=>$url,'alt'=>$alt,'thumb'=>$thumb];
}

  ?>

  <style>
    .lil-tabs{margin-top:8px}
    .lil-tabs__nav{display:flex;gap:6px;border-bottom:1px solid #ccc;margin-bottom:10px}
    .lil-tabs__btn{background:#f1f1f1;border:1px solid #ccc;border-bottom:none;padding:6px 10px;cursor:pointer}
    .lil-tabs__btn.is-active{background:#fff;border-bottom:1px solid #fff;font-weight:600}
    .lil-tab{display:none;border:1px solid #ccc;padding:12px;background:#fff}
    .lil-tab.is-active{display:block}
    .lilacs-fields .field{margin:10px 0;}
    .lilacs-fields label{display:block;font-weight:600;margin-bottom:4px;}
    .lilacs-fields input[type=text], .lilacs-fields textarea{width:100%;}
    .img-picker{display:flex;gap:12px;align-items:flex-start;}
    .img-picker .preview img{max-width:220px;height:auto;border-radius:6px;background:#f3f4f6;}
  </style>

  <div class="lil-tabs" data-tabs>
    <div class="lil-tabs__nav">
      <button type="button" class="lil-tabs__btn is-active" data-tab="#tab-banner">Banner</button>
      <button type="button" class="lil-tabs__btn" data-tab="#tab-guia">Guia de Seleção</button>
      <button type="button" class="lil-tabs__btn" data-tab="#tab-criterios">Critérios</button>
        <!-- Guias & FAQ -->
      <button type="button" class="lil-tabs__btn" data-tab="#tab-guiasfaq">Guias & FAQ</button>
      <button type="button" class="lil-tabs__btn" data-tab="#tab-padroes">Padrões Internacionais</button>

    </div>
    <!-- Banner -->
    <div id="tab-banner" class="lil-tab is-active">
      <div class="lilacs-fields">
        <div class="field">
          <label>Título</label>
          <input type="text" name="metod_banner_title" value="<?php echo esc_attr($banner_title); ?>">
        </div>
        <div class="field">
          <label>Descrição</label>
          <textarea name="metod_banner_desc"><?php echo esc_textarea($banner_desc); ?></textarea>
        </div>
        <div class="field">
          <label>Imagem</label>
          <div class="img-picker" data-img-picker>
            <div class="preview">
              <img src="<?php echo esc_url($banner_img); ?>" style="<?php echo $banner_img_id ? '' : 'opacity:.4'; ?>">
            </div>
            <div class="actions">
              <input type="hidden" name="metod_banner_img" value="<?php echo esc_attr($banner_img_id); ?>">
              <button type="button" class="button button-primary" data-img-select>Selecionar</button>
              <button type="button" class="button" data-img-remove>Remover</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Guia -->
    <div id="tab-guia" class="lil-tab">
      <div class="lilacs-fields">
        <div class="field"><label>Título</label>
          <input type="text" name="metod_guia_title" value="<?php echo esc_attr($guia_title); ?>">
        </div>
        <div class="field"><label>Descrição</label>
          <textarea name="metod_guia_desc"><?php echo esc_textarea($guia_desc); ?></textarea>
        </div>
        <div class="field"><label>Texto do botão</label>
          <input type="text" name="metod_guia_btn" value="<?php echo esc_attr($guia_btn); ?>">
        </div>
        <div class="field"><label>Link do botão</label>
          <input type="text" name="metod_guia_link" value="<?php echo esc_attr($guia_link); ?>">
        </div>
      </div>
    </div>

    <!-- Critérios -->
    <div id="tab-criterios" class="lil-tab">
      <div class="lilacs-fields">
        <div class="field"><label>Título</label>
          <input type="text" name="metod_crit_title" value="<?php echo esc_attr($crit_title); ?>">
        </div>
        <div class="field"><label>Botão 1 - Texto</label>
          <input type="text" name="metod_crit_btn1_text" value="<?php echo esc_attr($crit_btn1_text); ?>">
        </div>
        <div class="field"><label>Botão 1 - Link</label>
          <input type="text" name="metod_crit_btn1_link" value="<?php echo esc_attr($crit_btn1_link); ?>">
        </div>
        <div class="field"><label>Botão 2 - Texto</label>
          <input type="text" name="metod_crit_btn2_text" value="<?php echo esc_attr($crit_btn2_text); ?>">
        </div>
        <div class="field"><label>Botão 2 - Link</label>
          <input type="text" name="metod_crit_btn2_link" value="<?php echo esc_attr($crit_btn2_link); ?>">
        </div>
      </div>
    </div>
  </div>
  


   <!-- GUIAS & FAQ -->
<div id="tab-guiasfaq" class="lil-tab">
  <div class="lilacs-fields">
    <h3 style="margin-top:0">🧭 Guias (lado esquerdo)</h3>
    <?php
    $guias = [
      'gestao'        => 'Manual de gestão',
      'descricao'     => 'Manual de descrição',
      'indexacao'     => 'Manual de indexação',
      'filtros'       => 'Filtros de busca',
      'nota_tecnica'  => 'Nota técnica',
      'boas_praticas' => 'Guia de boas práticas editoriais LILACS'
    ];
    foreach ($guias as $key => $label):
      $text    = get_post_meta($post->ID, "_metod_{$key}_label", true);
      $link    = get_post_meta($post->ID, "_metod_{$key}_link",  true);
      $icon_id = (int) get_post_meta($post->ID, "_metod_{$key}_icon_id", true);
      $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : includes_url('images/media/default.png');
    ?>
    <fieldset style="border:1px solid #ddd;padding:10px;margin-bottom:10px;border-radius:6px;">
      <legend><strong><?php echo esc_html($label); ?></strong></legend>

      <div class="field">
        <label>Ícone (imagem da biblioteca)</label>
        <div class="img-picker" data-img-picker>
          <div class="preview">
            <img src="<?php echo esc_url($icon_url); ?>" alt="" style="max-width:72px; height:auto; border-radius:6px; <?php echo $icon_id ? '' : 'opacity:.4'; ?>">
          </div>
          <div class="actions">
            <input type="hidden" name="metod_<?php echo $key; ?>_icon_id" value="<?php echo esc_attr($icon_id); ?>">
            <button type="button" class="button button-primary" data-img-select>Selecionar imagem</button>
            <button type="button" class="button" data-img-remove>Remover</button>
            <p class="lilacs-help">Sugestão: PNG/SVG quadrado ~64–96px.</p>
          </div>
        </div>
      </div>

      <div class="field">
        <label>Texto do botão</label>
        <input type="text" name="metod_<?php echo $key; ?>_label" value="<?php echo esc_attr($text); ?>" placeholder="<?php echo esc_attr($label); ?>">
      </div>

      <div class="field">
        <label>Link</label>
        <input type="url" name="metod_<?php echo $key; ?>_link" value="<?php echo esc_attr($link); ?>" placeholder="https://...">
      </div>
    </fieldset>
    <?php endforeach; ?>

    <h3>💬 FAQ (lado direito)</h3>
    <?php for ($i=1; $i<=4; $i++):
      $faq_title = get_post_meta($post->ID, "_metod_faq{$i}_title", true);
      $faq_text  = get_post_meta($post->ID, "_metod_faq{$i}_text",  true);
    ?>
    <fieldset style="border:1px solid #ddd;padding:10px;margin-bottom:10px;border-radius:6px;">
      <legend><strong>FAQ <?php echo $i; ?></strong></legend>
      <div class="field">
        <label>Título</label>
        <input type="text" name="metod_faq<?php echo $i; ?>_title" value="<?php echo esc_attr($faq_title); ?>" placeholder="Ex.: FI-Admin">
      </div>
      <div class="field">
        <label>Descrição</label>
        <textarea name="metod_faq<?php echo $i; ?>_text" rows="3" placeholder="Texto da resposta..."><?php echo esc_textarea($faq_text); ?></textarea>
      </div>
    </fieldset>
    <?php endfor; ?>
  </div>
</div>


<!-- Padrões Internacionais -->
<div id="tab-padroes" class="lil-tab">
  <div class="lilacs-fields">
    <div class="field">
      <label>Título da seção</label>
      <input type="text" name="metod_padroes_title" value="<?php echo esc_attr($padroes_title); ?>"
             placeholder="Padrões internacionais que são a base da Metodologia LILACS">
    </div>

    <div class="field">
      <label>Logos (até 8)</label>
      <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">
        <?php for ($i=1; $i<=8; $i++): $L=$padroes_logos[$i]; ?>
          <fieldset style="border:1px solid #ddd;border-radius:8px;padding:10px;">
            <legend><strong>Logo <?php echo $i; ?></strong></legend>

            <div class="img-picker" data-img-picker>
              <div class="preview">
                <img src="<?php echo esc_url($L['thumb']); ?>"
                     style="max-width:160px;height:auto;border-radius:6px;<?php echo $L['id']?'':'opacity:.4'; ?>">
              </div>
              <div class="actions">
                <input type="hidden" name="metod_padroes_logo_<?php echo $i; ?>_id"
                       value="<?php echo esc_attr($L['id']); ?>">
                <button type="button" class="button button-primary" data-img-select>Selecionar imagem</button>
                <button type="button" class="button" data-img-remove>Remover</button>
                <p class="lilacs-help">PNG/SVG, fundo transparente de preferência.</p>
              </div>
            </div>

            <div class="field" style="margin-top:8px;">
              <label>Link (opcional)</label>
              <input type="url" name="metod_padroes_logo_<?php echo $i; ?>_url"
                     value="<?php echo esc_attr($L['url']); ?>" placeholder="https://...">
            </div>

            <div class="field">
              <label>Texto alternativo (alt)</label>
              <input type="text" name="metod_padroes_logo_<?php echo $i; ?>_alt"
                     value="<?php echo esc_attr($L['alt']); ?>" placeholder="Nome do padrão (ex.: DOI)">
            </div>
          </fieldset>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</div>


<script>
(function($){
  // Reutiliza um único frame de mídia para todos os pickers
  let frame;
  $(document).on('click','[data-img-select]', function(e){
    e.preventDefault();
    const $picker = $(this).closest('[data-img-picker]');
    const $hid    = $picker.find('input[type=hidden]');

    if(!frame){
      frame = wp.media({
        title: 'Selecionar imagem',
        button: { text: 'Usar esta imagem' },
        multiple: false
      });
    }
    frame.off('select');
    frame.on('select', function(){
      const att = frame.state().get('selection').first().toJSON();
      $hid.val(att.id);
      $picker.find('img')
        .attr('src', (att.sizes && (att.sizes.thumbnail?.url || att.sizes.medium?.url)) ? (att.sizes.thumbnail?.url || att.sizes.medium?.url) : att.url)
        .css('opacity', 1);
    });
    frame.open();
  });

  $(document).on('click','[data-img-remove]', function(e){
    e.preventDefault();
    const $picker = $(this).closest('[data-img-picker]');
    $picker.find('input[type=hidden]').val('');
    $picker.find('img')
      .attr('src','<?php echo esc_js( includes_url("images/media/default.png") ); ?>')
      .css('opacity', .4);
  });
})(jQuery);
</script>



  <script>
  (function($){
    // Tabs
    $(document).on('click', '.lil-tabs__btn', function(){
      var $b=$(this), $w=$b.closest('[data-tabs]');
      $w.find('.lil-tabs__btn').removeClass('is-active');
      $w.find('.lil-tab').removeClass('is-active');
      $b.addClass('is-active');
      $($b.data('tab')).addClass('is-active');
    });

    // Media picker
    let frame;
    $(document).on('click','[data-img-select]',function(e){
      e.preventDefault(); const $p=$(this).closest('[data-img-picker]'); const $hid=$p.find('input[type=hidden]');
      if(!frame){ frame=wp.media({title:'Selecionar imagem', button:{text:'Usar'}, multiple:false}); }
      frame.off('select'); frame.on('select',function(){
        const att=frame.state().get('selection').first().toJSON();
        $hid.val(att.id); $p.find('img').attr('src',(att.sizes?.medium_large?.url||att.url)).css('opacity',1);
      }); frame.open();
    });
    $(document).on('click','[data-img-remove]',function(e){
      e.preventDefault(); const $p=$(this).closest('[data-img-picker]');
      $p.find('input[type=hidden]').val(''); $p.find('img').attr('src','<?php echo esc_js(includes_url('images/media/default.png')); ?>').css('opacity',.4);
    });
  })(jQuery);
  </script>
  <?php
}

/** Salvamento */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  $tpl = get_post_meta($post_id, '_wp_page_template', true);
  if (basename($tpl) !== 'page-lilacs-metodologia.php') return;

  $fields = [
    '_metod_banner_title' => 'metod_banner_title',
    '_metod_banner_desc'  => 'metod_banner_desc',
    '_metod_banner_img'   => 'metod_banner_img',
    '_metod_guia_title'   => 'metod_guia_title',
    '_metod_guia_desc'    => 'metod_guia_desc',
    '_metod_guia_btn'     => 'metod_guia_btn',
    '_metod_guia_link'    => 'metod_guia_link',
    '_metod_crit_title'   => 'metod_crit_title',
    '_metod_crit_btn1_text'=> 'metod_crit_btn1_text',
    '_metod_crit_btn1_link'=> 'metod_crit_btn1_link',
    '_metod_crit_btn2_text'=> 'metod_crit_btn2_text',
    '_metod_crit_btn2_link'=> 'metod_crit_btn2_link',
        // --- Guias
    '_metod_gestao_icon'        => 'metod_gestao_icon',
    '_metod_gestao_label'       => 'metod_gestao_label',
    '_metod_gestao_link'        => 'metod_gestao_link',
    '_metod_descricao_icon'     => 'metod_descricao_icon',
    '_metod_descricao_label'    => 'metod_descricao_label',
    '_metod_descricao_link'     => 'metod_descricao_link',
    '_metod_indexacao_icon'     => 'metod_indexacao_icon',
    '_metod_indexacao_label'    => 'metod_indexacao_label',
    '_metod_indexacao_link'     => 'metod_indexacao_link',
    '_metod_filtros_icon'       => 'metod_filtros_icon',
    '_metod_filtros_label'      => 'metod_filtros_label',
    '_metod_filtros_link'       => 'metod_filtros_link',
    '_metod_nota_tecnica_icon'  => 'metod_nota_tecnica_icon',
    '_metod_nota_tecnica_label' => 'metod_nota_tecnica_label',
    '_metod_nota_tecnica_link'  => 'metod_nota_tecnica_link',
    '_metod_boas_praticas_icon' => 'metod_boas_praticas_icon',
    '_metod_boas_praticas_label'=> 'metod_boas_praticas_label',
    '_metod_boas_praticas_link' => 'metod_boas_praticas_link',

    // --- FAQ
    '_metod_faq1_title' => 'metod_faq1_title',
    '_metod_faq1_text'  => 'metod_faq1_text',
    '_metod_faq2_title' => 'metod_faq2_title',
    '_metod_faq2_text'  => 'metod_faq2_text',
    '_metod_faq3_title' => 'metod_faq3_title',
    '_metod_faq3_text'  => 'metod_faq3_text',
    '_metod_faq4_title' => 'metod_faq4_title',
    '_metod_faq4_text'  => 'metod_faq4_text',

  ];

  foreach($fields as $meta => $post_key){
    if (isset($_POST[$post_key])) {
      update_post_meta($post_id, $meta, sanitize_text_field($_POST[$post_key]));
    }
  }
  
  // --- Padrões Internacionais
if (isset($_POST['metod_padroes_title'])) {
  update_post_meta($post_id, '_metod_padroes_title', sanitize_text_field( wp_unslash($_POST['metod_padroes_title']) ));
}
for ($i=1; $i<=8; $i++){
  $k_id  = "metod_padroes_logo_{$i}_id";
  $k_url = "metod_padroes_logo_{$i}_url";
  $k_alt = "metod_padroes_logo_{$i}_alt";

  if (isset($_POST[$k_id])) {
    update_post_meta($post_id, "_metod_padroes_logo_{$i}_id",  (int) $_POST[$k_id]);
  }
  if (isset($_POST[$k_url])) {
    update_post_meta($post_id, "_metod_padroes_logo_{$i}_url", esc_url_raw( wp_unslash($_POST[$k_url]) ));
  }
  if (isset($_POST[$k_alt])) {
    update_post_meta($post_id, "_metod_padroes_logo_{$i}_alt", sanitize_text_field( wp_unslash($_POST[$k_alt]) ));
  }
}

$__guides_keys = ['gestao','descricao','indexacao','filtros','nota_tecnica','boas_praticas'];
foreach ($__guides_keys as $g) {
  // ícone: id da mídia vindo do admin
  if (isset($_POST["metod_{$g}_icon_id"])) {
    $icon_id = (int) $_POST["metod_{$g}_icon_id"];
    update_post_meta($post_id, "_metod_{$g}_icon_id", $icon_id);          // meta nova (usada no front)
    update_post_meta($post_id, "_metod_{$g}_icon",    $icon_id);          // mantém a meta antiga (back-compat)
  }
  // label e link já são salvos no foreach($fields...), mas se quiser garantir:
  if (isset($_POST["metod_{$g}_label"])) {
    update_post_meta($post_id, "_metod_{$g}_label", sanitize_text_field($_POST["metod_{$g}_label"]));
  }
  if (isset($_POST["metod_{$g}_link"])) {
    update_post_meta($post_id, "_metod_{$g}_link", esc_url_raw(wp_unslash($_POST["metod_{$g}_link"])));
  }
}


}, 10, 1);
