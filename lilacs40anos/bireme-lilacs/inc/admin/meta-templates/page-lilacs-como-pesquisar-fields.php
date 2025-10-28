<?php
/**
 * Campos do template: page-lilacs-como-pesquisar.php
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

/** Enqueue media para o seletor de imagem (somente na tela de edição) */
add_action('admin_enqueue_scripts', function($hook){
  // carrega apenas em post.php / post-new.php
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
});

/** Metabox com ABAS (padrão semelhante à home) */
add_action('add_meta_boxes', function () {
  add_meta_box(
    'bireme_lilacs_cp_box',
    __('LILACS – Como Pesquisar', 'bireme'),
    'bireme_lilacs_cp_render_metabox',
    'page',
    'normal',
    'high'
  );
});

function bireme_lilacs_cp_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $img    = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : '';
  $faq_items  = get_post_meta($post->ID, BIREME_LILACS_CP_META_FAQ_ITEMS, true);
  $faq_items  = is_array($faq_items) ? $faq_items : [];
  $faq_updated = get_post_meta($post->ID, BIREME_LILACS_CP_META_FAQ_UPDATED, true);

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
    .img-picker{display:flex;gap:12px;align-items:flex-start}
    .img-picker .preview img{max-width:200px;height:auto;border-radius:6px;background:#f3f4f6;display:block}
    @media(min-width:900px){.rep-grid{grid-template-columns:1fr 320px;}}
  </style>

  <div class="lilacs-tabs" data-tabs>
    <div class="lilacs-tabs__nav">
      <button type="button" class="lilacs-tabs__btn is-active" data-tab-target="#tab-banner"><?php _e('Banner principal', 'bireme'); ?></button>
      <button type="button" class="lilacs-tabs__btn" data-tab-target="#tab-faq"><?php _e('Perguntas frequentes', 'bireme'); ?></button>
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


    <div id="tab-faq" class="lilacs-tab">
      <div class="field">
        <label for="lilacs_cp_faq_updated"><?php _e('Última atualização (texto livre)', 'bireme'); ?></label>
        <input type="text" id="lilacs_cp_faq_updated" name="lilacs_cp_faq_updated" value="<?php echo esc_attr($faq_updated); ?>" placeholder="DD/MM/AAAA">
      </div>

      <div class="rep" data-rep>
        <?php
        if (!$faq_items) $faq_items = [[]]; // inicia com 1 item vazio
        foreach ($faq_items as $i => $it) :
          $title = $it['title'] ?? '';
          $body  = $it['body']  ?? '';
          $img_id= (int)($it['img_id'] ?? 0);
          $img   = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : includes_url('images/media/default.png');
        ?>
        <div class="rep-item" data-item>
          <div class="rep-head">
            <span class="rep-ttl"><?php echo esc_html($title ?: sprintf(__('Tópico %d', 'bireme'), $i+1)); ?></span>
            <div class="rep-actions">
              <button class="button" type="button" data-move-up>&uarr;</button>
              <button class="button" type="button" data-move-down>&darr;</button>
              <button class="button button-link-delete" type="button" data-remove><?php _e('Remover', 'bireme'); ?></button>
            </div>
          </div>

          <div class="rep-grid">
            <div>
              <label><?php _e('Título do tópico', 'bireme'); ?></label>
              <input type="text" name="faq_title[]" value="<?php echo esc_attr($title); ?>">

              <label style="margin-top:8px;"><?php _e('Conteúdo', 'bireme'); ?></label>
              <?php
              // editor WYSIWYG “leve”
              wp_editor($body, 'faq_body_'.$i, [
                'textarea_name' => 'faq_body[]',
                'media_buttons' => false,
                'teeny' => true,
                'textarea_rows' => 8,
                'quicktags' => true
              ]);
              ?>
            </div>

            <div>
              <label><?php _e('Imagem (opcional)', 'bireme'); ?></label>
              <div class="img-picker" data-img-picker>
                <div class="preview">
                  <img src="<?php echo esc_url($img); ?>" alt="" <?php echo $img_id ? '' : 'style="opacity:.4"'; ?>>
                </div>
                <div class="actions">
                  <input type="hidden" name="faq_img_id[]" value="<?php echo esc_attr($img_id); ?>">
                  <button type="button" class="button" data-img-select><?php _e('Selecionar', 'bireme'); ?></button>
                  <button type="button" class="button" data-img-remove><?php _e('Remover', 'bireme'); ?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <p><button type="button" class="button button-primary" data-add-item><?php _e('Adicionar tópico', 'bireme'); ?></button></p>
    </div>
            </div>
            <script>
  (function($){
    // Debug: mostra erros no console se houver
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

      // Media picker (delegado)
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
          frame.on('select', function(){
            var att = frame.state().get('selection').first().toJSON();
            $hid.val(att.id);
            $picker.find('img').attr('src', att.sizes?.medium?.url || att.url).css('opacity',1);
          });
        }
        frame.open();
      });
      $(document).on('click','[data-img-remove]',function(e){
        e.preventDefault();
        var $picker = $(this).closest('[data-img-picker]');
        $picker.find('input[type=hidden]').val('');
        $picker.find('img').attr('src','<?php echo esc_js( includes_url('images/media/default.png') ); ?>').css('opacity',.4);
      });

      // Repetidor: template e ações (adicionar / remover / mover)
      const tmpl = `
      <div class="rep-item" data-item>
        <div class="rep-head">
          <span class="rep-ttl"><?php echo esc_html__('Novo tópico', 'bireme'); ?></span>
          <div class="rep-actions">
            <button class="button" type="button" data-move-up>&uarr;</button>
            <button class="button" type="button" data-move-down>&darr;</button>
            <button class="button button-link-delete" type="button" data-remove"><?php echo esc_html__('Remover', 'bireme'); ?></button>
          </div>
        </div>
        <div class="rep-grid">
          <div>
            <label><?php echo esc_html__('Título do tópico', 'bireme'); ?></label>
            <input type="text" name="faq_title[]" value="">
            <label style="margin-top:8px;"><?php echo esc_html__('Conteúdo', 'bireme'); ?></label>
            <textarea name="faq_body[]" rows="8"></textarea>
          </div>
          <div>
            <label><?php echo esc_html__('Imagem (opcional)', 'bireme'); ?></label>
            <div class="img-picker" data-img-picker>
              <div class="preview"><img src="<?php echo esc_js( includes_url('images/media/default.png') ); ?>" style="opacity:.4"></div>
              <div class="actions">
                <input type="hidden" name="faq_img_id[]" value="">
                <button type="button" class="button" data-img-select><?php echo esc_html__('Selecionar', 'bireme'); ?></button>
                <button type="button" class="button" data-img-remove><?php echo esc_html__('Remover', 'bireme'); ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>`;

      $(document).on('click','[data-add-item]',function(e){
        e.preventDefault();
        console.log('Adicionar tópico clicado'); // debug
        const $rep = $('[data-rep]');
        if (!$rep.length) {
          console.warn('Container [data-rep] não encontrado');
          return;
        }
        const $item = $(tmpl);
        $rep.append($item);
        // opcional: rolar até o novo item
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
      $(document).on('input','input[name="faq_title[]"]',function(){
        $(this).closest('[data-item]').find('.rep-ttl').text(this.value || '<?php echo esc_js(__('Novo tópico','bireme')); ?>');
      });

    } catch(err) {
      console.error('Erro no script do metabox LILACS:', err);
    }
  })(jQuery);
  </script>


  </div>

  <script>
    (function($){
      // Tabs simples (mesmo comportamento usado na home)
      $(document).on('click', '.lilacs-tabs__btn', function(){
        var $btn = $(this), $wrap = $btn.closest('[data-tabs]');
        $wrap.find('.lilacs-tabs__btn').removeClass('is-active');
        $btn.addClass('is-active');
        var target = $btn.data('tab-target');
        $wrap.find('.lilacs-tab').removeClass('is-active');
        $wrap.find(target).addClass('is-active');
      });

      // Media picker
      $(function(){
        var frame;
        $('[data-img-select]').on('click', function(e){
          e.preventDefault();
          if (frame) { frame.open(); return; }
          frame = wp.media({
            title: '<?php echo esc_js(__('Selecionar imagem', 'bireme')); ?>',
            button: { text: '<?php echo esc_js(__('Usar esta imagem', 'bireme')); ?>' },
            multiple: false
          });
          frame.on('select', function(){
            var att = frame.state().get('selection').first().toJSON();
            $('#lilacs_cp_banner_img_id').val(att.id);
            $('[data-img-picker] .preview img').attr('src', att.sizes?.medium_large?.url || att.url).css('opacity', 1);
          });
          frame.open();
        });

        $('[data-img-remove]').on('click', function(e){
          e.preventDefault();
          $('#lilacs_cp_banner_img_id').val('');
          $('[data-img-picker] .preview img')
            .attr('src', '<?php echo esc_js( includes_url('images/media/default.png') ); ?>')
            .css('opacity', .4);
        });
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
  if (!current_user_can('edit_post', $post_id)) return;

  $title  = isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field($_POST['lilacs_cp_banner_title']) : '';
  $desc   = isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post($_POST['lilacs_cp_banner_desc']) : '';
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  $title);
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   $desc);
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);
 if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  // FAQ - coleta arrays paralelos
  $titles = isset($_POST['faq_title']) ? (array) $_POST['faq_title'] : [];
  $bodies = isset($_POST['faq_body'])  ? (array) $_POST['faq_body']  : [];
  $imgs   = isset($_POST['faq_img_id'])? (array) $_POST['faq_img_id']: [];

  $items = [];
  $n = max(count($titles), count($bodies), count($imgs));
  for ($i=0; $i<$n; $i++){
    $t = isset($titles[$i]) ? sanitize_text_field($titles[$i]) : '';
    $b = isset($bodies[$i]) ? wp_kses_post($bodies[$i]) : '';
    $id= isset($imgs[$i])   ? (int) $imgs[$i] : 0;
    if (!$t && !$b && !$id) continue;

    $url = $id ? wp_get_attachment_image_url($id, 'large') : '';
    $items[] = ['title'=>$t,'body'=>$b,'img_id'=>$id,'img_url'=>$url];
  }
  update_post_meta($post_id, BIREME_LILACS_CP_META_FAQ_ITEMS, $items);

  $upd = isset($_POST['lilacs_cp_faq_updated']) ? sanitize_text_field($_POST['lilacs_cp_faq_updated']) : '';
  update_post_meta($post_id, BIREME_LILACS_CP_META_FAQ_UPDATED, $upd);
}, 10, 1);
