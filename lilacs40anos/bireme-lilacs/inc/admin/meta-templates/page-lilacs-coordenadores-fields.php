<?php
/**
 * Campos do template: page-lilacs-coodenadores.php
 * Abas:
 *  - Banner principal: Título, Descrição, Imagem
 */
if (!defined('ABSPATH')) exit;

const BIREME_LILACS_CP_FIELDS_NONCE   = 'bireme_lilacs_cp_fields_nonce';
const BIREME_LILACS_CP_FIELDS_ACTION  = 'bireme_lilacs_cp_fields_action';

const BIREME_LILACS_CP_META_TITLE     = '_lilacs_cp_banner_title';
const BIREME_LILACS_CP_META_DESC      = '_lilacs_cp_banner_desc';
const BIREME_LILACS_CP_META_IMG_ID    = '_lilacs_cp_banner_img_id';

const BIREME_LILACS_CP_META_FAQ_ITEMS   = '_lilacs_cp_faq_items';
const BIREME_LILACS_CP_META_FAQ_UPDATED = '_lilacs_cp_faq_updated_at';

// Novos meta keys para a aba "Atuação"
const BIREME_LILACS_CP_META_ATUACAO_SECTION_TITLE = '_lilacs_cp_atuacao_section_title';
const BIREME_LILACS_CP_META_ATUACAO_ITEMS = '_lilacs_cp_atuacao_items';

/** Enqueue media para o seletor de imagem (somente na tela de edição) */
add_action('admin_enqueue_scripts', function($hook){
  // carrega apenas em post.php / post-new.php
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
});


add_action('add_meta_boxes', function ($post_type, $post) {
  // só para post type page
  if ($post_type !== 'page' || ! $post) return;

  $tpl = get_page_template_slug($post->ID); // retorna o caminho/arquivo do template
  $tpl_basename = $tpl ? wp_basename($tpl) : '';

  // aceita as variações de nome de template (com e sem prefixo "lilacs")
  $allowed = [
    'page-lilacs-coordenadores.php',
  ];

  if (!in_array($tpl_basename, $allowed, true)) return;

  add_meta_box(
    'bireme_lilacs_cp_box',
    __('Campos da página.', 'bireme'),
    'bireme_lilacs_cp_render_metabox',
    'page',
    'normal',
    'high'
  );
}, 10, 2);

function bireme_lilacs_cp_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $img    = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : '';

  // Atuação
  $atuacao_section_title = get_post_meta($post->ID, BIREME_LILACS_CP_META_ATUACAO_SECTION_TITLE, true);
  $atuacao_items = get_post_meta($post->ID, BIREME_LILACS_CP_META_ATUACAO_ITEMS, true);
  $atuacao_items = is_array($atuacao_items) ? $atuacao_items : [];

  ?>
  <style>
  
    .lilacs-tabs{margin-top:8px;}
    .lilacs-tabs__nav{display:flex;gap:6px;border-bottom:1px solid #dcdcdc;margin-bottom:10px;}
    .lilacs-tabs__btn{background:#f6f7f7;border:1px solid #d0d0d0;border-bottom:none;padding:8px 12px;cursor:pointer;font-weight:600;}
    .lilacs-tabs__btn.is-active{background:#fff;border-bottom:1px solid #fff;}
    .lilacs-tab{display:none;background:#fff;padding:12px;border:1px solid #d0d0d0;}
    .lilacs-tab.is-active{display:block;}
    .lilacs-fields .field{margin:12px 0;}
    .lilacs-fields label{display:block;font-weight:600;margin-bottom:6px;}
    .lilacs-fields input[type=text]{width:100%;}
    .lilacs-fields textarea{width:100%;min-height:110px;}
    .lilacs-help{color:#666;margin:4px 0 0;font-size:12px;}
    .img-picker{display:flex;gap:12px;align-items:flex-start;}
    .img-picker .preview img{max-width:220px;height:auto;border-radius:6px;display:block;background:#f3f4f6;}
    .img-picker .actions button{margin:0 6px 0 0;}
    .rep{display:flex;flex-direction:column;gap:14px;margin-top:6px}
    .rep-item{border:1px solid #e5e7eb;border-radius:10px;background:#fff;padding:12px}
    .rep-head{display:flex;gap:10px;align-items:center;justify-content:space-between}
    .rep-ttl{font-weight:700}
    .rep-actions .button{margin-left:6px}
    .rep-grid{display:grid;grid-template-columns:1fr;gap:10px;margin-top:10px}
    @media(min-width:900px){.rep-grid{grid-template-columns:1fr 320px;}}
  </style>

  <div class="lilacs-tabs" data-tabs>
    <div class="lilacs-tabs__nav">
      <button type="button" class="lilacs-tabs__btn is-active" data-tab-target="#tab-banner"><?php _e('Banner principal', 'bireme'); ?></button>
      <button type="button" class="lilacs-tabs__btn" data-tab-target="#tab-atuacao"><?php _e('Atuação', 'bireme'); ?></button>
    </div>

    <div id="tab-banner" class="lilacs-tab is-active">
      <div class="lilacs-fields">
        <div class="field">
          <label for="lilacs_cp_banner_title"><?php _e('Título do banner', 'bireme'); ?></label>
          <input type="text" id="lilacs_cp_banner_title" name="lilacs_cp_banner_title"
                 value="<?php echo esc_attr($title); ?>"
                 placeholder="<?php esc_attr_e('Ex.: Como pesquisar na LILACS?', 'bireme'); ?>">
          <p class="lilacs-help"><?php _e('Se vazio, utiliza o título da página.', 'bireme'); ?></p>
        </div>

        <div class="field">
          <label for="lilacs_cp_banner_desc"><?php _e('Descrição do banner', 'bireme'); ?></label>
          <textarea id="lilacs_cp_banner_desc" name="lilacs_cp_banner_desc"
            placeholder="<?php esc_attr_e('Ex.: Acesse artigos, periódicos científicos e documentos técnicos…', 'bireme'); ?>"><?php
              echo esc_textarea($desc);
          ?></textarea>
        </div>

        <div class="field">
          <label><?php _e('Imagem do banner', 'bireme'); ?></label>
          <div class="img-picker" data-img-picker>
            <div class="preview">
              <?php if ($img): ?>
                <img src="<?php echo esc_url($img); ?>" alt="">
              <?php else: ?>
                <img src="<?php echo esc_url(includes_url('images/media/default.png')); ?>" alt="" style="opacity:.4">
              <?php endif; ?>
            </div>
            <div class="actions">
              <input type="hidden" id="lilacs_cp_banner_img_id" name="lilacs_cp_banner_img_id" value="<?php echo esc_attr($img_id); ?>">
              <button type="button" class="button button-primary" data-img-select><?php _e('Selecionar imagem', 'bireme'); ?></button>
              <button type="button" class="button" data-img-remove><?php _e('Remover', 'bireme'); ?></button>
              <p class="lilacs-help"><?php _e('Recomendado: imagem horizontal grande (ex.: 1600×600+).', 'bireme'); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="tab-atuacao" class="lilacs-tab">
      <div class="lilacs-fields">
        <div class="field">
          <label for="atuacao_section_title"><?php _e('Título da seção "Atuação"', 'bireme'); ?></label>
          <input type="text" id="atuacao_section_title" name="atuacao_section_title" value="<?php echo esc_attr($atuacao_section_title); ?>" placeholder="<?php esc_attr_e('Ex.: A coordenação atua:', 'bireme'); ?>">
        </div>

        <div class="rep" data-rep>
          <?php
          if (!$atuacao_items) $atuacao_items = [[]];
          foreach ($atuacao_items as $i => $it) :
            $it_title = $it['title'] ?? '';
            $it_desc  = $it['desc']  ?? '';
            $it_img_id= (int)($it['img_id'] ?? 0);
            $it_img   = $it_img_id ? wp_get_attachment_image_url($it_img_id, 'medium') : includes_url('images/media/default.png');
          ?>
          <div class="rep-item" data-item>
            <div class="rep-head">
              <span class="rep-ttl"><?php echo esc_html($it_title ?: sprintf(__('Item %d', 'bireme'), $i+1)); ?></span>
              <div class="rep-actions">
                <button class="button" type="button" data-move-up>&uarr;</button>
                <button class="button" type="button" data-move-down>&darr;</button>
                <button class="button button-link-delete" type="button" data-remove><?php _e('Remover', 'bireme'); ?></button>
              </div>
            </div>

            <div class="rep-grid">
              <div>
                <label><?php _e('Título', 'bireme'); ?></label>
                <input type="text" name="atuacao_item_title[]" value="<?php echo esc_attr($it_title); ?>">

                <label style="margin-top:8px;"><?php _e('Descrição', 'bireme'); ?></label>
                <textarea name="atuacao_item_desc[]" rows="4"><?php echo esc_textarea($it_desc); ?></textarea>
              </div>

              <div>
                <label><?php _e('Imagem (opcional)', 'bireme'); ?></label>
                <div class="img-picker" data-img-picker>
                  <div class="preview">
                    <img src="<?php echo esc_url($it_img); ?>" alt="" <?php echo $it_img_id ? '' : 'style="opacity:.4"'; ?>>
                  </div>
                  <div class="actions">
                    <input type="hidden" name="atuacao_item_img_id[]" value="<?php echo esc_attr($it_img_id); ?>">
                    <button type="button" class="button" data-img-select><?php _e('Selecionar', 'bireme'); ?></button>
                    <button type="button" class="button" data-img-remove><?php _e('Remover', 'bireme'); ?></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <p><button type="button" class="button button-primary" data-add-item><?php _e('Adicionar item', 'bireme'); ?></button></p>
      </div>
    </div>

  </div>

  <script>
  (function($){
    try {
      // Tabs
      $(document).on('click', '.lilacs-tabs__btn', function(){
        var $btn = $(this), $wrap = $btn.closest('[data-tabs]');
        $wrap.find('.lilacs-tabs__btn').removeClass('is-active');
        $btn.addClass('is-active');
        var target = $btn.data('tab-target');
        $wrap.find('.lilacs-tab').removeClass('is-active');
        $wrap.find(target).addClass('is-active');
      });

      // Media picker (delegado) - corrige uso do frame compartilhado para atualizar picker correto
      var frame;
      $(document).on('click','[data-img-select]', function(e){
        e.preventDefault();
        var $picker = $(this).closest('[data-img-picker]');
        var $hid = $picker.find('input[type=hidden]');

        if (!frame) {
          frame = wp.media({
            title: '<?php echo esc_js(__('Selecionar imagem', 'bireme')); ?>',
            button: { text: '<?php echo esc_js(__('Usar esta imagem', 'bireme')); ?>' },
            multiple: false
          });
        }

        // remove handler anterior e cria novo que "captura" o picker atual
        frame.off('select');
        frame.on('select', function(){
          var att = frame.state().get('selection').first().toJSON();
          $hid.val(att.id);
          $picker.find('img').attr('src', (att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url)).css('opacity',1);
        });

        frame.open();
      });

      $(document).on('click','[data-img-remove]',function(e){
        e.preventDefault();
        var $picker = $(this).closest('[data-img-picker]');
        $picker.find('input[type=hidden]').val('');
        $picker.find('img').attr('src','<?php echo esc_js( includes_url('images/media/default.png') ); ?>').css('opacity',.4);
      });

      // Repetidor
      const tmpl = `
      <div class="rep-item" data-item>
        <div class="rep-head">
          <span class="rep-ttl"><?php echo esc_html__('Novo item', 'bireme'); ?></span>
          <div class="rep-actions">
            <button class="button" type="button" data-move-up>&uarr;</button>
            <button class="button" type="button" data-move-down>&darr;</button>
            <button class="button button-link-delete" type="button" data-remove"><?php echo esc_html__('Remover', 'bireme'); ?></button>
          </div>
        </div>
        <div class="rep-grid">
          <div>
            <label><?php echo esc_html__('Título', 'bireme'); ?></label>
            <input type="text" name="atuacao_item_title[]" value="">
            <label style="margin-top:8px;"><?php echo esc_html__('Descrição', 'bireme'); ?></label>
            <textarea name="atuacao_item_desc[]" rows="4"></textarea>
          </div>
          <div>
            <label><?php echo esc_html__('Imagem (opcional)', 'bireme'); ?></label>
            <div class="img-picker" data-img-picker>
              <div class="preview"><img src="<?php echo esc_js( includes_url('images/media/default.png') ); ?>" style="opacity:.4"></div>
              <div class="actions">
                <input type="hidden" name="atuacao_item_img_id[]" value="">
                <button type="button" class="button" data-img-select><?php echo esc_html__('Selecionar', 'bireme'); ?></button>
                <button type="button" class="button" data-img-remove><?php echo esc_html__('Remover', 'bireme'); ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>`;

      $(document).on('click','[data-add-item]',function(e){
        e.preventDefault();
        const $rep = $(this).closest('.lilacs-tab').find('[data-rep]');
        if (!$rep.length) return;
        const $item = $(tmpl);
        $rep.append($item);
        $('html,body').animate({scrollTop: $item.offset().top - 80}, 200);
      });

      $(document).on('click','[data-remove]',function(){
        $(this).closest('[data-item]').remove();
      });
      $(document).on('click','[data-move-up]',function(){
        const $it = $(this).closest('[data-item]');
        $it.prev('[data-item]').before($it);
      });
      $(document).on('click','[data-move-down]',function(){
        const $it = $(this).closest('[data-item]');
        $it.next('[data-item]').after($it);
      });

      // Atualiza título do card com o valor do input
      $(document).on('input','input[name="atuacao_item_title[]"]',function(){
        $(this).closest('[data-item]').find('.rep-ttl').text(this.value || '<?php echo esc_js(__('Novo item','bireme')); ?>');
      });

    } catch(err) {
      console.error('Erro no script do metabox LILACS:', err);
    }
  })(jQuery);
  </script>

  <?php
}

/** Salvamento */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  // Banner
  $title  = isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field($_POST['lilacs_cp_banner_title']) : '';
  $desc   = isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post($_POST['lilacs_cp_banner_desc']) : '';
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  $title);
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   $desc);
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);

  // Atuação - coleta arrays paralelos
  $section_title = isset($_POST['atuacao_section_title']) ? sanitize_text_field($_POST['atuacao_section_title']) : '';
  $titles = isset($_POST['atuacao_item_title']) ? (array) $_POST['atuacao_item_title'] : [];
  $descs  = isset($_POST['atuacao_item_desc'])  ? (array) $_POST['atuacao_item_desc']  : [];
  $imgs   = isset($_POST['atuacao_item_img_id'])? (array) $_POST['atuacao_item_img_id']: [];

  $items = [];
  $n = max(count($titles), count($descs), count($imgs));
  for ($i=0; $i<$n; $i++){
    $t = isset($titles[$i]) ? sanitize_text_field($titles[$i]) : '';
    $d = isset($descs[$i]) ? wp_kses_post($descs[$i]) : '';
    $id= isset($imgs[$i])   ? (int) $imgs[$i] : 0;
    if (!$t && !$d && !$id) continue;
    $url = $id ? wp_get_attachment_image_url($id, 'large') : '';
    $items[] = ['title'=>$t,'desc'=>$d,'img_id'=>$id,'img_url'=>$url];
  }
  update_post_meta($post_id, BIREME_LILACS_CP_META_ATUACAO_ITEMS, $items);
  update_post_meta($post_id, BIREME_LILACS_CP_META_ATUACAO_SECTION_TITLE, $section_title);

}, 10, 1);
