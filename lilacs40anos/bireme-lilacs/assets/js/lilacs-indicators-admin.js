jQuery(function($){
  const $wrap = $('#lilacs-indicators-wrap');
  const $origTemplate = $('#lilacs-indicator-template');

  // if template exists, clone it (do NOT remove id from original before cloning)
  let $template;
  if ($origTemplate.length) {
    $template = $origTemplate.clone();
    // keep original hidden so it's available if needed
    $origTemplate.hide();
  } else {
    // fallback: create a minimal template from the last existing row or an empty structure
    const $last = $wrap.find('.lilacs-indicator-row').last();
    if ($last.length) {
      $template = $last.clone();
    } else {
      $template = $('<div class="lilacs-indicator-row" style="display:none;"><p><label>Título:<br/><input type="text" class="widefat" name="lilacs_indicators[__INDEX__][title]" value=""/></label></p><p><label>Conteúdo:<br/><textarea class="widefat lilacs-indicator-content" name="lilacs_indicators[__INDEX__][content]" rows="6"></textarea></label></p><p><button type="button" class="button lilacs-remove-indicator">Remover</button></p></div>');
    }
  }

  $template.removeAttr('id').attr('data-template','1').find('textarea').attr('data-template-textarea','1').hide();

  function nextIndex(){
    let max = -1;
    $wrap.find('.lilacs-indicator-row').each(function(){
      const id = $(this).attr('id')||'';
      const m = id.match(/lilacs-indicator-(\d+)/);
      if (m) max = Math.max(max, parseInt(m[1],10));
    });
    return max+1;
  }

  // add new
  $('#lilacs-add-indicator').on('click', function(e){
    e.preventDefault();
    const idx = nextIndex();
    const $row = $template.clone().removeAttr('data-template').show();

    // update names and ids
    $row.find('input, textarea').each(function(){
      const name = $(this).attr('name') || '';
      $(this).attr('name', name.replace('__INDEX__', idx));
    });

    // ensure textarea has unique id for wp.editor
    const $ta = $row.find('textarea.lilacs-indicator-content');
    const taId = 'lilacs_indicators_new_' + idx;
    $ta.attr('id', taId);
    $row.attr('id','lilacs-indicator-'+idx);
    $wrap.append($row);

    // initialize WP editor for the new textarea (if available)
    if (typeof wp !== 'undefined' && wp.editor && typeof wp.editor.initialize === 'function'){
      try{
        wp.editor.initialize(taId, window.lilacsIndicatorsAdmin?.editorSettings || {});
      }catch(err){
        // silently fail, textarea stays plain
        console.warn('wp.editor.initialize failed', err);
      }
    }
  });

  // remove
  $wrap.on('click', '.lilacs-remove-indicator', function(e){
    e.preventDefault();
    const $r = $(this).closest('.lilacs-indicator-row');
    const ta = $r.find('textarea').attr('id');
    if (ta && typeof wp !== 'undefined' && wp.editor && typeof wp.editor.remove === 'function'){
      try{ wp.editor.remove(ta); }catch(e){ }
    }
    $r.remove();
  });

  // ensure template is available in DOM (hidden) so cloning works later if needed
  if (!$('#lilacs-indicator-template').length && !$wrap.find('[data-template]').length){
    $wrap.append($template);
  }
});