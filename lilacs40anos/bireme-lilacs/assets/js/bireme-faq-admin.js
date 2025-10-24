(function($){
  $(function(){

    // Select2 AJAX para buscar ufaq
    const $sel = $('#faq-featured-add');
    if ($sel.length){
      $sel.select2({
        placeholder: $sel.data('placeholder') || 'Buscar perguntas…',
        allowClear: true,
        ajax: {
          url: BIREME_FAQ_ADMIN.ajax,
          dataType: 'json',
          delay: 250,
          data: params => ({ action: 'bireme_faq_search', nonce: BIREME_FAQ_ADMIN.nonce, q: params.term || '' }),
          processResults: data => ({ results: data })
        },
        minimumInputLength: 2,
        width: 'resolve'
      });

      $sel.on('select2:select', function(e){
        const id = e.params.data.id, text = e.params.data.text;
        if (!id) return;

        // Evita duplicados
        if ($('#faq-featured-list li[data-id="'+id+'"]').length) {
          $sel.val(null).trigger('change'); return;
        }

        $('#faq-featured-list').append(
          '<li data-id="'+id+'"><span>'+text+'</span> '+
          '<button class="button button-small rm" type="button">Remover</button>'+
          '<input type="hidden" name="lilacs_faq_featured[]" value="'+id+'"></li>'
        );
        $sel.val(null).trigger('change');
      });

      $(document).on('click', '#faq-featured-list .rm', function(){
        $(this).closest('li').remove();
      });

      $('#faq-featured-list').sortable({
        axis: 'y',
        handle: 'li',
        containment: 'parent'
      });
    }

  });
})(jQuery);
