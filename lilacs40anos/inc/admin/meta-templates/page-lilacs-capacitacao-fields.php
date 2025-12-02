<?php
/**
 * Campos do template: page-lilacs-capacitacao.php
 * Abas: Banner | O que oferecemos (repeater) | Cursos em destaque (repeater)
 */
if (!defined('ABSPATH')) exit;

/* Nonces globais (mesmas chaves do projeto) */
if (!defined('BIREME_LILACS_CP_FIELDS_NONCE'))  define('BIREME_LILACS_CP_FIELDS_NONCE',  'bireme_lilacs_cp_fields_nonce');
if (!defined('BIREME_LILACS_CP_FIELDS_ACTION')) define('BIREME_LILACS_CP_FIELDS_ACTION', 'bireme_lilacs_cp_fields_action');

/* Banner – usa as MESMAS chaves já existentes */
if (!defined('BIREME_LILACS_CP_META_TITLE'))   define('BIREME_LILACS_CP_META_TITLE',   '_lilacs_cp_banner_title');
if (!defined('BIREME_LILACS_CP_META_DESC'))    define('BIREME_LILACS_CP_META_DESC',    '_lilacs_cp_banner_desc');
if (!defined('BIREME_LILACS_CP_META_IMG_ID'))  define('BIREME_LILACS_CP_META_IMG_ID',  '_lilacs_cp_banner_img_id');

/** Media */
add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
  wp_enqueue_script('jquery');
});

/** Metabox apenas para o template */
add_action('add_meta_boxes', function ($post_type, $post) {
  if ($post_type !== 'page' || ! $post) return;
  $tpl = get_post_meta($post->ID, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-capacitacao.php') return;

  add_meta_box(
    'bireme_lilacs_capacitacao_box',
    __('LILACS – Capacitação (Banner, Oferecemos, Cursos)', 'bireme'),
    'bireme_lilacs_capacitacao_render_metabox',
    'page',
    'normal',
    'high'
  );
}, 10, 2);

/** Render */
function bireme_lilacs_capacitacao_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  // Banner
  $banner_title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $banner_desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $banner_img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $banner_img    = $banner_img_id ? wp_get_attachment_image_url($banner_img_id, 'medium_large') : includes_url('images/media/default.png');

  // Repeater: O que oferecemos
  $oferecemos = get_post_meta($post->ID, '_cap_oferecemos', true);
  if (!is_array($oferecemos)) $oferecemos = [];

  // Repeater: Cursos em destaque
  $cursos = get_post_meta($post->ID, '_cap_cursos', true);
  if (!is_array($cursos)) $cursos = [];

  ?>
  <style>
    .lil-tabs{margin-top:8px}
    .lil-tabs__nav{display:flex;gap:6px;border-bottom:1px solid #dcdcdc;margin-bottom:10px}
    .lil-tabs__btn{background:#f6f7f7;border:1px solid #d0d0d0;border-bottom:none;padding:8px 12px;cursor:pointer;font-weight:600}
    .lil-tabs__btn.is-active{background:#fff;border-bottom:1px solid #fff}
    .lil-tab{display:none;background:#fff;padding:12px;border:1px solid #d0d0d0}
    .lil-tab.is-active{display:block}

    .lilacs-fields .field{margin:12px 0}
    .lilacs-fields label{display:block;font-weight:600;margin-bottom:6px}
    .lilacs-fields input[type=text],.lilacs-fields input[type=url],.lilacs-fields textarea{width:100%}
    .img-picker{display:flex;gap:12px;align-items:flex-start}
    .img-picker .preview img{max-width:120px;height:auto;border-radius:6px;background:#f3f4f6;display:block}

    .rep-list{display:flex;flex-direction:column;gap:10px}
    .rep-item{border:1px solid #e5e7eb;border-radius:10px;background:#fff;padding:12px}
    .rep-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px}
    .rep-title{font-weight:700}
    .rep-actions .button{margin-left:4px}
    .muted{color:#6b7280;font-size:12px}
  </style>

  <div class="lil-tabs" data-tabs>
    <div class="lil-tabs__nav">
      <button type="button" class="lil-tabs__btn is-active" data-tab="#tab-banner">Banner</button>
      <button type="button" class="lil-tabs__btn" data-tab="#tab-oferecemos">O que oferecemos</button>
      <button type="button" class="lil-tabs__btn" data-tab="#tab-cursos">Cursos em destaque</button>
    </div>

    <!-- Banner -->
    <div id="tab-banner" class="lil-tab is-active">
      <div class="lilacs-fields">
        <div class="field">
          <label>Título do banner</label>
          <input type="text" name="lilacs_cp_banner_title" value="<?php echo esc_attr($banner_title); ?>">
          <p class="muted">Se vazio, usa o título da página.</p>
        </div>
        <div class="field">
          <label>Descrição do banner</label>
          <textarea name="lilacs_cp_banner_desc" rows="4"><?php echo esc_textarea($banner_desc); ?></textarea>
        </div>
        <div class="field">
          <label>Imagem do banner</label>
          <div class="img-picker" data-img-picker>
            <div class="preview">
              <img src="<?php echo esc_url($banner_img); ?>" style="<?php echo $banner_img_id?'':'opacity:.4'; ?>">
            </div>
            <div class="actions">
              <input type="hidden" name="lilacs_cp_banner_img_id" value="<?php echo esc_attr($banner_img_id); ?>">
              <button type="button" class="button button-primary" data-img-select>Selecionar</button>
              <button type="button" class="button" data-img-remove>Remover</button>
              <p class="muted">Recomendado: 1600×600+.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- O que oferecemos (repeater) -->
    <div id="tab-oferecemos" class="lil-tab">
      <p class="muted">Cards com ícone/imagem, título e texto.</p>
      <div id="rep-oferecemos" class="rep-list" data-repeater="oferecemos">
        <?php foreach($oferecemos as $i => $it):
          $icon_id = isset($it['icon_id']) ? (int)$it['icon_id'] : 0;
          $icon    = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : includes_url('images/media/default.png');
          $title   = $it['title'] ?? '';
          $text    = $it['text']  ?? '';
        ?>
        <div class="rep-item" data-item>
          <div class="rep-head">
            <span class="rep-title"><?php echo esc_html($title ?: 'Card '.($i+1)); ?></span>
            <div class="rep-actions">
              <button type="button" class="button" data-move-up>&uarr;</button>
              <button type="button" class="button" data-move-down>&darr;</button>
              <button type="button" class="button button-link-delete" data-remove>Remover</button>
            </div>
          </div>

          <div class="field">
            <label>Ícone/Imagem</label>
            <div class="img-picker" data-img-picker>
              <div class="preview"><img src="<?php echo esc_url($icon); ?>" style="<?php echo $icon_id?'':'opacity:.4'; ?>"></div>
              <div class="actions">
                <input type="hidden" name="cap_oferecemos[<?php echo esc_attr($i); ?>][icon_id]" value="<?php echo esc_attr($icon_id); ?>">
                <button type="button" class="button button-primary" data-img-select>Selecionar</button>
                <button type="button" class="button" data-img-remove>Remover</button>
              </div>
            </div>
          </div>

          <p class="field">
            <label>Título</label>
            <input type="text" name="cap_oferecemos[<?php echo esc_attr($i); ?>][title]" value="<?php echo esc_attr($title); ?>">
          </p>
          <p class="field">
            <label>Texto</label>
            <textarea rows="3" name="cap_oferecemos[<?php echo esc_attr($i); ?>][text]"><?php echo esc_textarea($text); ?></textarea>
          </p>
        </div>
        <?php endforeach; ?>
      </div>
      <p><button type="button" class="button button-primary" data-add-oferecemos>Adicionar card</button></p>
    </div>

    <!-- Cursos em destaque (repeater) -->
    <div id="tab-cursos" class="lil-tab">
      <p class="muted">Cards de curso com ícone, título, resumo, botão e link.</p>
      <div id="rep-cursos" class="rep-list" data-repeater="cursos">
        <?php foreach($cursos as $i => $it):
          $icon_id = isset($it['icon_id']) ? (int)$it['icon_id'] : 0;
          $icon    = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : includes_url('images/media/default.png');
          $title   = $it['title'] ?? '';
          $excerpt = $it['excerpt'] ?? '';
          $btn     = $it['button'] ?? '';
          $link    = $it['link'] ?? '';
        ?>
        <div class="rep-item" data-item>
          <div class="rep-head">
            <span class="rep-title"><?php echo esc_html($title ?: 'Curso '.($i+1)); ?></span>
            <div class="rep-actions">
              <button type="button" class="button" data-move-up>&uarr;</button>
              <button type="button" class="button" data-move-down>&darr;</button>
              <button type="button" class="button button-link-delete" data-remove>Remover</button>
            </div>
          </div>

          <div class="field">
            <label>Ícone/Imagem</label>
            <div class="img-picker" data-img-picker>
              <div class="preview"><img src="<?php echo esc_url($icon); ?>" style="<?php echo $icon_id?'':'opacity:.4'; ?>"></div>
              <div class="actions">
                <input type="hidden" name="cap_cursos[<?php echo esc_attr($i); ?>][icon_id]" value="<?php echo esc_attr($icon_id); ?>">
                <button type="button" class="button button-primary" data-img-select>Selecionar</button>
                <button type="button" class="button" data-img-remove>Remover</button>
              </div>
            </div>
          </div>

          <p class="field">
            <label>Título</label>
            <input type="text" name="cap_cursos[<?php echo esc_attr($i); ?>][title]" value="<?php echo esc_attr($title); ?>">
          </p>
          <p class="field">
            <label>Resumo</label>
            <textarea rows="5" name="cap_cursos[<?php echo esc_attr($i); ?>][excerpt]"><?php echo esc_textarea($excerpt); ?></textarea>
          </p>
          <div class="field">
            <label>Texto do botão</label>
            <input type="text" name="cap_cursos[<?php echo esc_attr($i); ?>][button]" value="<?php echo esc_attr($btn ?: 'Ver mais'); ?>">
          </div>
          <div class="field">
            <label>Link</label>
            <input type="url" name="cap_cursos[<?php echo esc_attr($i); ?>][link]" value="<?php echo esc_attr($link); ?>" placeholder="https://...">
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <p><button type="button" class="button button-primary" data-add-cursos>Adicionar curso</button></p>
    </div>
  </div>

  <!-- Templates escondidos -->
  <template id="tpl-oferecemos">
    <div class="rep-item" data-item>
      <div class="rep-head">
        <span class="rep-title">Novo card</span>
        <div class="rep-actions">
          <button type="button" class="button" data-move-up>&uarr;</button>
          <button type="button" class="button" data-move-down>&darr;</button>
          <button type="button" class="button button-link-delete" data-remove>Remover</button>
        </div>
      </div>
      <div class="field">
        <label>Ícone/Imagem</label>
        <div class="img-picker" data-img-picker>
          <div class="preview"><img src="<?php echo esc_js(includes_url('images/media/default.png')); ?>" style="opacity:.4"></div>
          <div class="actions">
            <input type="hidden" name="cap_oferecemos[__I__][icon_id]" value="">
            <button type="button" class="button button-primary" data-img-select>Selecionar</button>
            <button type="button" class="button" data-img-remove>Remover</button>
          </div>
        </div>
      </div>
      <p class="field">
        <label>Título</label>
        <input type="text" name="cap_oferecemos[__I__][title]" value="">
      </p>
      <p class="field">
        <label>Texto</label>
        <textarea rows="3" name="cap_oferecemos[__I__][text]"></textarea>
      </p>
    </div>
  </template>

  <template id="tpl-cursos">
    <div class="rep-item" data-item>
      <div class="rep-head">
        <span class="rep-title">Novo curso</span>
        <div class="rep-actions">
          <button type="button" class="button" data-move-up>&uarr;</button>
          <button type="button" class="button" data-move-down>&darr;</button>
          <button type="button" class="button button-link-delete" data-remove>Remover</button>
        </div>
      </div>
      <div class="field">
        <label>Ícone/Imagem</label>
        <div class="img-picker" data-img-picker>
          <div class="preview"><img src="<?php echo esc_js(includes_url('images/media/default.png')); ?>" style="opacity:.4"></div>
          <div class="actions">
            <input type="hidden" name="cap_cursos[__I__][icon_id]" value="">
            <button type="button" class="button button-primary" data-img-select>Selecionar</button>
            <button type="button" class="button" data-img-remove>Remover</button>
          </div>
        </div>
      </div>
      <p class="field">
        <label>Título</label>
        <input type="text" name="cap_cursos[__I__][title]" value="">
      </p>
      <p class="field">
        <label>Resumo</label>
        <textarea rows="5" name="cap_cursos[__I__][excerpt]"></textarea>
      </p>
      <div class="field">
        <label>Texto do botão</label>
        <input type="text" name="cap_cursos[__I__][button]" value="Ver mais">
      </div>
      <div class="field">
        <label>Link</label>
        <input type="url" name="cap_cursos[__I__][link]" value="" placeholder="https://...">
      </div>
    </div>
  </template>

  <script>
  (function($){
    // Tabs
    $(document).on('click','.lil-tabs__btn',function(){
      var $b=$(this), $w=$b.closest('[data-tabs]');
      $w.find('.lil-tabs__btn').removeClass('is-active'); $b.addClass('is-active');
      $w.find('.lil-tab').removeClass('is-active'); $($b.data('tab')).addClass('is-active');
    });

    // Media picker (reutiliza um frame)
    let frame;
    $(document).on('click','[data-img-select]',function(e){
      e.preventDefault();
      const $picker=$(this).closest('[data-img-picker]');
      const $hid=$picker.find('input[type=hidden]');
      if(!frame){
        frame = wp.media({title:'Selecionar imagem', button:{text:'Usar esta imagem'}, multiple:false});
      }
      frame.off('select');
      frame.on('select', function(){
        const att=frame.state().get('selection').first().toJSON();
        $hid.val(att.id);
        $picker.find('img').attr('src',(att.sizes?.thumbnail?.url||att.sizes?.medium?.url||att.url)).css('opacity',1);
      });
      frame.open();
    });
    $(document).on('click','[data-img-remove]',function(e){
      e.preventDefault();
      const $p=$(this).closest('[data-img-picker]');
      $p.find('input[type=hidden]').val('');
      $p.find('img').attr('src','<?php echo esc_js(includes_url('images/media/default.png')); ?>').css('opacity',.4);
    });

    // Helpers de índice
    function nextIndex($wrap){
      let max=-1;
      $wrap.children('[data-item]').each(function(){
        const h=$(this).find('input[type=hidden],input[type=text],textarea').first().attr('name')||'';
        const m=h.match(/\[(\d+)\]/); if(m) max=Math.max(max, parseInt(m[1],10));
      });
      return max+1;
    }
    function replaceIndex(html, i, key){ return html.replaceAll('[__I__]', '['+i+']').replaceAll('__I__', i).replaceAll('__KEY__', key); }

    // Add Oferecemos
    $(document).on('click','[data-add-oferecemos]',function(e){
      e.preventDefault();
      const $wrap=$('#rep-oferecemos'); const i=nextIndex($wrap);
      const tpl=document.getElementById('tpl-oferecemos').innerHTML;
      $wrap.append(replaceIndex(tpl, i, 'oferecemos'));
    });

    // Add Cursos
    $(document).on('click','[data-add-cursos]',function(e){
      e.preventDefault();
      const $wrap=$('#rep-cursos'); const i=nextIndex($wrap);
      const tpl=document.getElementById('tpl-cursos').innerHTML;
      $wrap.append(replaceIndex(tpl, i, 'cursos'));
    });

    // Remove / mover itens
    $(document).on('click','[data-remove]',function(){ $(this).closest('[data-item]').remove(); });
    $(document).on('click','[data-move-up]',function(){
      const $el=$(this).closest('[data-item]'); $el.prev('[data-item]').before($el);
    });
    $(document).on('click','[data-move-down]',function(){
      const $el=$(this).closest('[data-item]'); $el.next('[data-item]').after($el);
    });

    // Atualiza título da “capa” ao digitar
    $(document).on('input','[data-item] input[type=text]',function(){
      const $it=$(this).closest('[data-item]'); const ttl=$it.find('input[type=text]').first().val()||'Item';
      $it.find('.rep-title').text(ttl);
    });
  })(jQuery);
  </script>
  <?php
}

/** Save */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $tpl = get_post_meta($post_id, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-capacitacao.php') return;

  // Banner (mantém as MESMAS chaves)
  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field(wp_unslash($_POST['lilacs_cp_banner_title'])) : '');
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post(wp_unslash($_POST['lilacs_cp_banner_desc'])) : '');
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0);

  // Repeater: O que oferecemos
  $of_in = isset($_POST['cap_oferecemos']) && is_array($_POST['cap_oferecemos']) ? $_POST['cap_oferecemos'] : [];
  $of_clean = [];
  foreach ($of_in as $it){
    $icon_id = isset($it['icon_id']) ? (int)$it['icon_id'] : 0;
    $title   = isset($it['title'])   ? sanitize_text_field(wp_unslash($it['title'])) : '';
    $text    = isset($it['text'])    ? wp_kses_post(wp_unslash($it['text'])) : '';
    if ($title!=='' || $text!=='' || $icon_id){
      $of_clean[] = ['icon_id'=>$icon_id, 'title'=>$title, 'text'=>$text];
    }
  }
  update_post_meta($post_id, '_cap_oferecemos', $of_clean);

  // Repeater: Cursos
  $cu_in = isset($_POST['cap_cursos']) && is_array($_POST['cap_cursos']) ? $_POST['cap_cursos'] : [];
  $cu_clean = [];
  foreach ($cu_in as $it){
    $icon_id = isset($it['icon_id']) ? (int)$it['icon_id'] : 0;
    $title   = isset($it['title'])   ? sanitize_text_field(wp_unslash($it['title'])) : '';
    $excerpt = isset($it['excerpt']) ? wp_kses_post(wp_unslash($it['excerpt'])) : '';
    $button  = isset($it['button'])  ? sanitize_text_field(wp_unslash($it['button'])) : '';
    $link    = isset($it['link'])    ? esc_url_raw(wp_unslash($it['link'])) : '';
    if ($title!=='' || $excerpt!=='' || $icon_id || $link!==''){
      $cu_clean[] = ['icon_id'=>$icon_id, 'title'=>$title, 'excerpt'=>$excerpt, 'button'=>$button, 'link'=>$link];
    }
  }
  update_post_meta($post_id, '_cap_cursos', $cu_clean);
}, 10, 1);
