/*
(function() {
	tinymce.PluginManager.add('custom_mce_button', function( editor, url ) {
		editor.addButton('custom_mce_button', {
			text: 'TAGS',
			icon: false,
			onclick: function() {
				editor.insertContent('Nullam at lorem sagittis, maximus ante non, egestas mauris. Maecenas vel dolor dui. Nulla porta metus a sem tempor, ut iaculis justo ultrices. Sed sagittis lacinia molestie. In et porta quam. Suspendisse potenti. Morbi mattis ut quam vitae malesuada.');
			}
		});
	});
})();
*/
(function() {
	tinymce.PluginManager.add('custom_mce_button', function( editor, url ) {
		editor.addButton( 'custom_mce_button', {
			text: 'TAGS',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text: 'pt_BR',
					onclick: function() {
						if ( editor.selection.getContent() ) {
        					editor.selection.setContent('[pt_BR]'+editor.selection.getContent()+'[/pt_BR]');
						}
					}
				},
				{
					text: 'es_ES',
					onclick: function() {
						if ( editor.selection.getContent() ) {
        					editor.selection.setContent('[es_ES]'+editor.selection.getContent()+'[/es_ES]');
						}
					}
				},
				{
					text: 'en_US',
					onclick: function() {
						if ( editor.selection.getContent() ) {
        					editor.selection.setContent('[en_US]'+editor.selection.getContent()+'[/en_US]');
						}
					}
				}
			]
		});
	});
})();