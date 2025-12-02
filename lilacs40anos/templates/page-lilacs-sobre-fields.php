<?php
/**
 * Campos meta para o template "page-lilacs-sobre.php"
 * - Adiciona metabox com abas (cada "part" pode ser uma aba). Aqui: aba "Hero".
 * - Salva metadados: hero_title, hero_desc, hero_bg_image_id, stat_{n}_number, stat_{n}_label
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// registra metabox
add_action( 'add_meta_boxes', function() {
	add_meta_box(
		'lilacs_sobre_fields',
		'Opções LILACS (page-lilacs-sobre)',
		'lilacs_render_sobre_metabox',
		'page',
		'normal',
		'high'
	);
});

// enfileira media scripts quando necessário
add_action( 'admin_enqueue_scripts', function( $hook ) {
	// carregar apenas nas telas de edição de post/page
	if ( in_array( $hook, ['post.php','post-new.php'], true ) ) {
		wp_enqueue_media();
		// pequeno CSS para abas
		wp_add_inline_style( 'wp-admin', '
			/* tabs: allow wrapping or horizontal scroll so all tabs are reachable in narrow admin panels */
			.lilacs-tabs{
				display:flex;
				gap:8px;
				margin-bottom:12px;
				flex-wrap:wrap;        /* allow tabs to flow to next line */
				max-width:100%;
				overflow-x:auto;       /* horizontal scroll if needed */
				padding-bottom:6px;
			}
			/* ensure individual tab labels do not wrap internally */
			.lilacs-tab{white-space:nowrap}
			.lilacs-tab{padding:8px 12px;background:#f3f4f6;border-radius:6px;cursor:pointer}
			.lilacs-tab.is-active{background:#00205C;color:#fff}
			.lilacs-tab-panel{display:none;padding:12px;border:1px solid #e6e6e6;border-radius:6px;background:#fff}
			.lilacs-tab-panel.is-active{display:block}
			.lilacs-row{margin-bottom:10px}
			.lilacs-row label{display:block;font-weight:600;margin-bottom:6px}
			.lilacs-input, .lilacs-textarea{width:100%;box-sizing:border-box;padding:8px;border:1px solid #ddd;border-radius:6px}
			.lilacs-stats-grid{display:flex;flex-wrap:wrap;gap:12px}
			.lilacs-stat{flex:1;min-width:140px}
			.lilacs-upload-wrap{display:flex;gap:8px;align-items:center}
			.lilacs-upload-thumb{width:72px;height:48px;object-fit:cover;border:1px solid #ddd;border-radius:4px}
		' );
	}
});

// --- adicionado: helper robusto para detectar template da página no admin ---
if ( ! function_exists( 'lilacs_get_admin_page_template' ) ) {
	function lilacs_get_admin_page_template( $post = null ) {
		// 1) se veio via POST (ao salvar)
		if ( ! empty( $_POST['_wp_page_template'] ) ) {
			return sanitize_text_field( wp_unslash( $_POST['_wp_page_template'] ) );
		}
		// 2) se o $post foi passado ou disponível
		if ( $post && is_object( $post ) && ! empty( $post->ID ) ) {
			$meta = get_post_meta( $post->ID, '_wp_page_template', true );
			if ( $meta ) return $meta;
			$slug = get_page_template_slug( $post );
			if ( $slug ) return $slug;
		}
		// 3) tentativa por query (edição via GET/post)
		$post_id = 0;
		if ( ! empty( $_GET['post'] ) ) {
			$post_id = intval( $_GET['post'] );
		} elseif ( ! empty( $_POST['post_ID'] ) ) {
			$post_id = intval( $_POST['post_ID'] );
		}
		if ( $post_id ) {
			$meta = get_post_meta( $post_id, '_wp_page_template', true );
			if ( $meta ) return $meta;
			$slug = get_page_template_slug( $post_id );
			if ( $slug ) return $slug;
		}
		return ''; // não definido
	}
}

// render da metabox
function lilacs_render_sobre_metabox( $post ) {
	// verificar template da página: só exibe se template for page-lilacs-sobre.php

	// obter valores atuais
	$hero_title = get_post_meta( $post->ID, '_lilacs_hero_title', true );
	$hero_desc  = get_post_meta( $post->ID, '_lilacs_hero_desc', true );
	$hero_img   = intval( get_post_meta( $post->ID, '_lilacs_hero_bg_image_id', true ) );
	$hero_img_url = $hero_img ? wp_get_attachment_image_url( $hero_img, 'medium' ) : '';

	$stats = [];
	for ( $i = 1; $i <= 5; $i++ ) {
		$stats[$i] = [
			'number' => get_post_meta( $post->ID, "_lilacs_stat_{$i}_number", true ),
			'label'  => get_post_meta( $post->ID, "_lilacs_stat_{$i}_label", true ),
		];
	}

	// --- NOVO: metas para "O que é" (caso já precise) ---
	$intro_title = get_post_meta( $post->ID, '_lilacs_intro_title', true );
	$intro_p1    = get_post_meta( $post->ID, '_lilacs_intro_p1', true );
	$intro_p2    = get_post_meta( $post->ID, '_lilacs_intro_p2', true );
	$intro_p3    = get_post_meta( $post->ID, '_lilacs_intro_p3', true );

	// --- NOVO: metas para NUVENS (indexed) ---
	$indexed_title = get_post_meta( $post->ID, '_lilacs_indexed_title', true );
	$indexed_desc  = get_post_meta( $post->ID, '_lilacs_indexed_desc', true );
	$wordcloud     = get_post_meta( $post->ID, '_lilacs_wordcloud_words', true );

	// --- NOVO: metas para CARDS (até 4) ---
	$cards = [];
	for ( $c = 1; $c <= 4; $c++ ) {
		$cards[$c] = [
			'title' => get_post_meta( $post->ID, "_lilacs_card_{$c}_title", true ),
			'text'  => get_post_meta( $post->ID, "_lilacs_card_{$c}_text", true ),
		];
	}

	// --- NOVO: metas para REUNIÕES (meetings) ---
	$meetings_title = get_post_meta( $post->ID, '_lilacs_meetings_title', true );
	$meetings_desc  = get_post_meta( $post->ID, '_lilacs_meetings_desc', true );
	$meetings = [];
	for ( $m = 1; $m <= 3; $m++ ) {
		$meetings[$m] = [
			'title' => get_post_meta( $post->ID, "_lilacs_meeting_{$m}_title", true ),
			'text'  => get_post_meta( $post->ID, "_lilacs_meeting_{$m}_text", true ),
		];
	}

	// --- NOVO: metas para VOZES DA REDE (voices) ---
	$voices_title = get_post_meta( $post->ID, '_lilacs_voices_title', true );
	$voices = [];
	for ( $v = 1; $v <= 6; $v++ ) {
		$voices[$v] = [
			'name'   => get_post_meta( $post->ID, "_lilacs_voice_{$v}_name", true ),
			'role'   => get_post_meta( $post->ID, "_lilacs_voice_{$v}_role", true ),
			'text'   => get_post_meta( $post->ID, "_lilacs_voice_{$v}_text", true ),
			'avatar' => get_post_meta( $post->ID, "_lilacs_voice_{$v}_avatar", true ),
		];
	}

	// --- NOVO: metas de cor de fundo por seção ---
	$bg_hero     = get_post_meta( $post->ID, '_lilacs_bg_hero', true );
	$bg_oque     = get_post_meta( $post->ID, '_lilacs_bg_oque', true );
	$bg_nuvens   = get_post_meta( $post->ID, '_lilacs_bg_nuvens', true );
	$bg_cards    = get_post_meta( $post->ID, '_lilacs_bg_cards', true );
	$bg_meetings = get_post_meta( $post->ID, '_lilacs_bg_meetings', true );
	$bg_voices   = get_post_meta( $post->ID, '_lilacs_bg_voices', true );

	// --- NOVO: metas para SESSÕES EXTRAS (array JSON) ---
	$extra_sections_raw = get_post_meta( $post->ID, '_lilacs_extra_sections', true );
	$extra_sections = [];
	if ( ! empty( $extra_sections_raw ) ) {
		$decoded = json_decode( $extra_sections_raw, true );
		if ( is_array( $decoded ) ) {
			$extra_sections = $decoded;
		}
	}

	wp_nonce_field( 'lilacs_sobre_save_meta', 'lilacs_sobre_nonce' );

	// Abas: Hero + "O que é" pode existir + Nuvens + Cards + Reuniões
	?>
	<div class="lilacs-tabs" role="tablist" aria-label="LILACS page parts">
		<div class="lilacs-tab is-active" data-tab="hero" role="tab">Hero</div>
		<div class="lilacs-tab" data-tab="sobre" role="tab">O que é</div>
		<div class="lilacs-tab" data-tab="nuvens" role="tab">Nuvens</div>
		<div class="lilacs-tab" data-tab="cards" role="tab">Cards</div>
		<div class="lilacs-tab" data-tab="meetings" role="tab">Reuniões</div>
		<div class="lilacs-tab" data-tab="voices" role="tab">Vozes</div>
		<div class="lilacs-tab" data-tab="extras" role="tab">Sessões</div>
	</div>

	<!-- painel HERO (existing) -->
	<div class="lilacs-tab-panel is-active" data-panel="hero" role="tabpanel">
		<div class="lilacs-row">
			<label for="lilacs_hero_title">Título (hero)</label>
			<input id="lilacs_hero_title" name="lilacs_hero_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $hero_title ); ?>">
		</div>

		<div class="lilacs-row">
			<label for="lilacs_hero_desc">Descrição (hero)</label>
			<textarea id="lilacs_hero_desc" name="lilacs_hero_desc" rows="4" class="lilacs-textarea"><?php echo esc_textarea( $hero_desc ); ?></textarea>
		</div>

		<div class="lilacs-row">
			<label>Imagem de fundo (hero)</label>
			<div class="lilacs-upload-wrap">
				<img src="<?php echo esc_url( $hero_img_url ?: '' ); ?>" alt="" class="lilacs-upload-thumb" id="lilacs-hero-thumb-<?php echo esc_attr($post->ID); ?>">
				<input type="hidden" id="lilacs_hero_bg_image_id" name="lilacs_hero_bg_image_id" value="<?php echo esc_attr( $hero_img ); ?>">
				<button type="button" class="button" id="lilacs_hero_upload_btn">Selecionar imagem</button>
				<button type="button" class="button" id="lilacs_hero_remove_btn">Remover</button>
			</div>
		</div>

		<div class="lilacs-row">
			<label>Estatísticas (até 5)</label>
			<div class="lilacs-stats-grid">
				<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<div class="lilacs-stat">
						<label for="lilacs_stat_<?php echo $i; ?>_number">Número #<?php echo $i; ?></label>
						<input id="lilacs_stat_<?php echo $i; ?>_number" name="lilacs_stat_<?php echo $i; ?>_number" class="lilacs-input" type="text" value="<?php echo esc_attr( $stats[$i]['number'] ); ?>">
						<label for="lilacs_stat_<?php echo $i; ?>_label" style="margin-top:6px">Rótulo #<?php echo $i; ?></label>
						<input id="lilacs_stat_<?php echo $i; ?>_label" name="lilacs_stat_<?php echo $i; ?>_label" class="lilacs-input" type="text" value="<?php echo esc_attr( $stats[$i]['label'] ); ?>">
					</div>
				<?php endfor; ?>
			</div>
		</div>

		<div class="lilacs-row">
			<label for="lilacs_bg_hero">Cor de fundo (hero)</label>
			<input id="lilacs_bg_hero" name="lilacs_bg_hero" type="color" value="<?php echo esc_attr( $bg_hero ); ?>" class="lilacs-input" style="width:92px;padding:4px;">
		</div>
	</div>

	<!-- painel "O QUE É" (se já presente) -->
	<div class="lilacs-tab-panel" data-panel="sobre" role="tabpanel">
		<div class="lilacs-row">
			<label for="lilacs_intro_title">Título (seção "O que é")</label>
			<input id="lilacs_intro_title" name="lilacs_intro_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $intro_title ); ?>">
		</div>
		<div class="lilacs-row">
			<label for="lilacs_intro_p1">Parágrafo 1</label>
			<textarea id="lilacs_intro_p1" name="lilacs_intro_p1" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $intro_p1 ); ?></textarea>
		</div>
		<div class="lilacs-row">
			<label for="lilacs_intro_p2">Parágrafo 2</label>
			<textarea id="lilacs_intro_p2" name="lilacs_intro_p2" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $intro_p2 ); ?></textarea>
		</div>
		<div class="lilacs-row">
			<label for="lilacs_intro_p3">Parágrafo 3</label>
			<textarea id="lilacs_intro_p3" name="lilacs_intro_p3" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $intro_p3 ); ?></textarea>
		</div>

		<div class="lilacs-row">
			<label for="lilacs_bg_oque">Cor de fundo (O que é)</label>
			<input id="lilacs_bg_oque" name="lilacs_bg_oque" type="color" value="<?php echo esc_attr( $bg_oque ); ?>" class="lilacs-input" style="width:92px;padding:4px;">
		</div>
	</div>

	<!-- NUVENS (indexed journals) -->
	<div class="lilacs-tab-panel" data-panel="nuvens" role="tabpanel">
		<div class="lilacs-row">
			<label for="lilacs_indexed_title">Título (Revistas indexadas)</label>
			<input id="lilacs_indexed_title" name="lilacs_indexed_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $indexed_title ); ?>">
		</div>
		<div class="lilacs-row">
			<label for="lilacs_indexed_desc">Descrição (Revistas indexadas)</label>
			<textarea id="lilacs_indexed_desc" name="lilacs_indexed_desc" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $indexed_desc ); ?></textarea>
		</div>
		<div class="lilacs-row">
			<label for="lilacs_wordcloud_words">Palavras para Word Cloud (CSV ou uma por linha)</label>
			<textarea id="lilacs_wordcloud_words" name="lilacs_wordcloud_words" rows="4" class="lilacs-textarea" placeholder="Saúde, Pesquisa, Revistas, ..."><?php echo esc_textarea( $wordcloud ); ?></textarea>
		</div>

		<div class="lilacs-row">
			<label for="lilacs_bg_nuvens">Cor de fundo (Nuvens)</label>
			<input id="lilacs_bg_nuvens" name="lilacs_bg_nuvens" type="color" value="<?php echo esc_attr( $bg_nuvens ); ?>" class="lilacs-input" style="width:92px;padding:4px;">
		</div>
	</div>

	<!-- CARDS -->
	<div class="lilacs-tab-panel" data-panel="cards" role="tabpanel">
		<div class="lilacs-row">
			<label>Cards (até 4)</label>
			<div class="lilacs-stats-grid">
				<?php for ( $c = 1; $c <= 4; $c++ ) : ?>
					<div class="lilacs-stat">
						<label for="lilacs_card_<?php echo $c; ?>_title">Título card #<?php echo $c; ?></label>
						<input id="lilacs_card_<?php echo $c; ?>_title" name="lilacs_card_<?php echo $c; ?>_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $cards[$c]['title'] ); ?>">
						<label for="lilacs_card_<?php echo $c; ?>_text" style="margin-top:6px">Texto card #<?php echo $c; ?></label>
						<textarea id="lilacs_card_<?php echo $c; ?>_text" name="lilacs_card_<?php echo $c; ?>_text" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $cards[$c]['text'] ); ?></textarea>
					</div>
				<?php endfor; ?>
			</div>
		</div>

		<div class="lilacs-row">
			<label for="lilacs_bg_cards">Cor de fundo (Cards)</label>
			<input id="lilacs_bg_cards" name="lilacs_bg_cards" type="color" value="<?php echo esc_attr( $bg_cards ); ?>" class="lilacs-input" style="width:92px;padding:4px;">
		</div>
	</div>

	<!-- REUNIÕES e CAPACITAÇÕES -->
	<div class="lilacs-tab-panel" data-panel="meetings" role="tabpanel">
		<div class="lilacs-row">
			<label for="lilacs_meetings_title">Título (Reuniões e capacitações)</label>
			<input id="lilacs_meetings_title" name="lilacs_meetings_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $meetings_title ); ?>">
		</div>
		<div class="lilacs-row">
			<label for="lilacs_meetings_desc">Descrição (Reuniões e capacitações)</label>
			<textarea id="lilacs_meetings_desc" name="lilacs_meetings_desc" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $meetings_desc ); ?></textarea>
		</div>
		<div class="lilacs-row">
			<label>Itens (até 3)</label>
			<div class="lilacs-stats-grid">
				<?php for ( $m = 1; $m <= 3; $m++ ) : ?>
					<div class="lilacs-stat">
						<label for="lilacs_meeting_<?php echo $m; ?>_title">Título #<?php echo $m; ?></label>
						<input id="lilacs_meeting_<?php echo $m; ?>_title" name="lilacs_meeting_<?php echo $m; ?>_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $meetings[$m]['title'] ); ?>">
						<label for="lilacs_meeting_<?php echo $m; ?>_text" style="margin-top:6px">Texto #<?php echo $m; ?></label>
						<textarea id="lilacs_meeting_<?php echo $m; ?>_text" name="lilacs_meeting_<?php echo $m; ?>_text" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $meetings[$m]['text'] ); ?></textarea>
					</div>
				<?php endfor; ?>
			</div>
		</div>

		<div class="lilacs-row">
			<label for="lilacs_bg_meetings">Cor de fundo (Reuniões)</label>
			<input id="lilacs_bg_meetings" name="lilacs_bg_meetings" type="color" value="<?php echo esc_attr( $bg_meetings ); ?>" class="lilacs-input" style="width:92px;padding:4px;">
		</div>
	</div>

	<!-- VOZES DA REDE -->
	<div class="lilacs-tab-panel" data-panel="voices" role="tabpanel">
		<div class="lilacs-row">
			<label for="lilacs_voices_title">Título (Vozes da Rede)</label>
			<input id="lilacs_voices_title" name="lilacs_voices_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $voices_title ); ?>">
		</div>
		<div class="lilacs-row">
			<label>Itens (até 6) — Nome / Cargo / Texto / Avatar (URL)</label>
			<div class="lilacs-stats-grid">
				<?php for ( $v = 1; $v <= 6; $v++ ) : ?>
					<div class="lilacs-stat">
						<label for="lilacs_voice_<?php echo $v; ?>_name">Nome #<?php echo $v; ?></label>
						<input id="lilacs_voice_<?php echo $v; ?>_name" name="lilacs_voice_<?php echo $v; ?>_name" class="lilacs-input" type="text" value="<?php echo esc_attr( $voices[$v]['name'] ); ?>">
						<label for="lilacs_voice_<?php echo $v; ?>_role" style="margin-top:6px">Cargo/Instituição #<?php echo $v; ?></label>
						<input id="lilacs_voice_<?php echo $v; ?>_role" name="lilacs_voice_<?php echo $v; ?>_role" class="lilacs-input" type="text" value="<?php echo esc_attr( $voices[$v]['role'] ); ?>">
						<label for="lilacs_voice_<?php echo $v; ?>_text" style="margin-top:6px">Texto #<?php echo $v; ?></label>
						<textarea id="lilacs_voice_<?php echo $v; ?>_text" name="lilacs_voice_<?php echo $v; ?>_text" rows="3" class="lilacs-textarea"><?php echo esc_textarea( $voices[$v]['text'] ); ?></textarea>
						<label for="lilacs_voice_<?php echo $v; ?>_avatar" style="margin-top:6px">Avatar URL #<?php echo $v; ?></label>
						<input id="lilacs_voice_<?php echo $v; ?>_avatar" name="lilacs_voice_<?php echo $v; ?>_avatar" class="lilacs-input" type="url" value="<?php echo esc_attr( $voices[$v]['avatar'] ); ?>">
					</div>
				<?php endfor; ?>
			</div>
		</div>

		<div class="lilacs-row">
			<label for="lilacs_bg_voices">Cor de fundo (Vozes)</label>
			<input id="lilacs_bg_voices" name="lilacs_bg_voices" type="color" value="<?php echo esc_attr( $bg_voices ); ?>" class="lilacs-input" style="width:92px;padding:4px;">
		</div>
	</div>

	<!-- PAINEL: Sessões dinâmicas -->
	<div class="lilacs-tab-panel" data-panel="extras" role="tabpanel">
		<div class="lilacs-row">
			<label>Sessões adicionais (cada sessão: título, descrição, palavras)</label>
			<div id="lilacs-extra-sections">
				<!-- Existing sections will be rendered here by PHP -->
				<?php
				if ( ! empty( $extra_sections ) && is_array( $extra_sections ) ) :
					foreach ( $extra_sections as $idx => $es ) :
						$es_title = isset( $es['title'] ) ? $es['title'] : '';
						$es_desc  = isset( $es['desc'] ) ? $es['desc'] : '';
						$es_words = isset( $es['words'] ) ? $es['words'] : '';
				?>
				<div class="lilacs-extra-item" data-index="<?php echo esc_attr( $idx ); ?>" style="border:1px solid #eee;padding:10px;border-radius:6px;margin-bottom:8px">
					<label>Título</label>
					<input type="text" class="lilacs-input lilacs-extra-title" value="<?php echo esc_attr( $es_title ); ?>">
					<label style="margin-top:6px">Descrição</label>
					<textarea class="lilacs-textarea lilacs-extra-desc" rows="3"><?php echo esc_textarea( $es_desc ); ?></textarea>
					<label style="margin-top:6px">Palavras (CSV ou 1 por linha)</label>
					<textarea class="lilacs-textarea lilacs-extra-words" rows="3"><?php echo esc_textarea( $es_words ); ?></textarea>
					<div style="margin-top:8px">
						<button type="button" class="button lilacs-extra-remove">Remover</button>
					</div>
				</div>
				<?php
					endforeach;
				endif;
				?>
			</div>

			<p style="margin-top:8px">
				<button type="button" class="button" id="lilacs-extra-add">Adicionar sessão</button>
				<span class="description" style="margin-left:8px">Use para criar seções personalizadas com título, descrição e palavras.</span>
			</p>

			<!-- campo oculto que será salvo como JSON -->
			<input type="hidden" id="lilacs_extra_sections" name="lilacs_extra_sections" value="<?php echo esc_attr( wp_json_encode( $extra_sections ) ); ?>">
		</div>
	</div>

	<script>
	// abas simples
	(function(){
		const tabs = document.querySelectorAll('.lilacs-tab');
		const panels = document.querySelectorAll('.lilacs-tab-panel');
		tabs.forEach(t => t.addEventListener('click', ()=> {
			tabs.forEach(x=>x.classList.remove('is-active'));
			panels.forEach(p=>p.classList.remove('is-active'));
			t.classList.add('is-active');
			const panel = document.querySelector('.lilacs-tab-panel[data-panel="' + t.dataset.tab + '"]');
			if(panel) panel.classList.add('is-active');
		}));
	})();

// Media uploader for hero image
(function($){
	var frame;
	$('#lilacs_hero_upload_btn').on('click', function(e){
		e.preventDefault();
		if ( frame ) { frame.open(); return; }
		frame = wp.media({
			title: 'Selecionar imagem do hero',
			button: { text: 'Usar esta imagem' },
			multiple: false
		});
		frame.on('select', function(){
			var attachment = frame.state().get('selection').first().toJSON();
			$('#lilacs_hero_bg_image_id').val(attachment.id);
			$('#lilacs-hero-thumb-<?php echo esc_js($post->ID); ?>').attr('src', attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url );
		});
		frame.open();
	});

	$('#lilacs_hero_remove_btn').on('click', function(){
		$('#lilacs_hero_bg_image_id').val('');
		$('#lilacs-hero-thumb-<?php echo esc_js($post->ID); ?>').attr('src','');
	});
})(jQuery);
	</script>
	<?php
}

// salvamento dos metadados
add_action( 'save_post', function( $post_id ) {
	// verificação básica
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['lilacs_sobre_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['lilacs_sobre_nonce'], 'lilacs_sobre_save_meta' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	// apenas para páginas com template page-lilacs-sobre.php
	$template = isset( $_POST['_wp_page_template'] ) ? sanitize_text_field( wp_unslash( $_POST['_wp_page_template'] ) ) : get_page_template_slug( $post_id );
	if ( 'page-lilacs-sobre.php' !== $template && 'templates/page-lilacs-sobre.php' !== $template ) {
		// ainda assim salvamos, mas é ok ignorar caso prefira
		// return;
	}

	// campos hero
	if ( isset( $_POST['lilacs_hero_title'] ) ) {
		update_post_meta( $post_id, '_lilacs_hero_title', sanitize_text_field( wp_unslash( $_POST['lilacs_hero_title'] ) ) );
	}
	if ( isset( $_POST['lilacs_hero_desc'] ) ) {
		update_post_meta( $post_id, '_lilacs_hero_desc', wp_kses_post( wp_unslash( $_POST['lilacs_hero_desc'] ) ) );
	}
	if ( isset( $_POST['lilacs_hero_bg_image_id'] ) ) {
		update_post_meta( $post_id, '_lilacs_hero_bg_image_id', intval( $_POST['lilacs_hero_bg_image_id'] ) );
	}

	// estatísticas
	for ( $i = 1; $i <= 5; $i++ ) {
		if ( isset( $_POST["lilacs_stat_{$i}_number"] ) ) {
			update_post_meta( $post_id, "_lilacs_stat_{$i}_number", sanitize_text_field( wp_unslash( $_POST["lilacs_stat_{$i}_number"] ) ) );
		}
		if ( isset( $_POST["lilacs_stat_{$i}_label"] ) ) {
			update_post_meta( $post_id, "_lilacs_stat_{$i}_label", sanitize_text_field( wp_unslash( $_POST["lilacs_stat_{$i}_label"] ) ) );
		}
	}

	// --- NOVO: salvar campos da seção "O que é" ---
	if ( isset( $_POST['lilacs_intro_title'] ) ) {
		update_post_meta( $post_id, '_lilacs_intro_title', sanitize_text_field( wp_unslash( $_POST['lilacs_intro_title'] ) ) );
	}
	if ( isset( $_POST['lilacs_intro_p1'] ) ) {
		update_post_meta( $post_id, '_lilacs_intro_p1', wp_kses_post( wp_unslash( $_POST['lilacs_intro_p1'] ) ) );
	}
	if ( isset( $_POST['lilacs_intro_p2'] ) ) {
		update_post_meta( $post_id, '_lilacs_intro_p2', wp_kses_post( wp_unslash( $_POST['lilacs_intro_p2'] ) ) );
	}
	if ( isset( $_POST['lilacs_intro_p3'] ) ) {
		update_post_meta( $post_id, '_lilacs_intro_p3', wp_kses_post( wp_unslash( $_POST['lilacs_intro_p3'] ) ) );
	}

	// --- NOVO: salvar campos NUVENS (indexed) ---
	if ( isset( $_POST['lilacs_indexed_title'] ) ) {
		update_post_meta( $post_id, '_lilacs_indexed_title', sanitize_text_field( wp_unslash( $_POST['lilacs_indexed_title'] ) ) );
	}
	if ( isset( $_POST['lilacs_indexed_desc'] ) ) {
		update_post_meta( $post_id, '_lilacs_indexed_desc', wp_kses_post( wp_unslash( $_POST['lilacs_indexed_desc'] ) ) );
	}
	if ( isset( $_POST['lilacs_wordcloud_words'] ) ) {
		update_post_meta( $post_id, '_lilacs_wordcloud_words', sanitize_textarea_field( wp_unslash( $_POST['lilacs_wordcloud_words'] ) ) );
	}

	// --- NOVO: salvar CARDS ---
	for ( $c = 1; $c <= 4; $c++ ) {
		if ( isset( $_POST["lilacs_card_{$c}_title"] ) ) {
			update_post_meta( $post_id, "_lilacs_card_{$c}_title", sanitize_text_field( wp_unslash( $_POST["lilacs_card_{$c}_title"] ) ) );
		}
		if ( isset( $_POST["lilacs_card_{$c}_text"] ) ) {
			update_post_meta( $post_id, "_lilacs_card_{$c}_text", wp_kses_post( wp_unslash( $_POST["lilacs_card_{$c}_text"] ) ) );
		}
	}

	// --- NOVO: salvar REUNIÕES / CAPACITAÇÕES ---
	if ( isset( $_POST['lilacs_meetings_title'] ) ) {
		update_post_meta( $post_id, '_lilacs_meetings_title', sanitize_text_field( wp_unslash( $_POST['lilacs_meetings_title'] ) ) );
	}
	if ( isset( $_POST['lilacs_meetings_desc'] ) ) {
		update_post_meta( $post_id, '_lilacs_meetings_desc', wp_kses_post( wp_unslash( $_POST['lilacs_meetings_desc'] ) ) );
	}
	for ( $m = 1; $m <= 3; $m++ ) {
		if ( isset( $_POST["lilacs_meeting_{$m}_title"] ) ) {
			update_post_meta( $post_id, "_lilacs_meeting_{$m}_title", sanitize_text_field( wp_unslash( $_POST["lilacs_meeting_{$m}_title"] ) ) );
		}
		if ( isset( $_POST["lilacs_meeting_{$m}_text"] ) ) {
			update_post_meta( $post_id, "_lilacs_meeting_{$m}_text", wp_kses_post( wp_unslash( $_POST["lilacs_meeting_{$m}_text"] ) ) );
		}
	}

	// --- NOVO: salvar VOZES DA REDE ---
	if ( isset( $_POST['lilacs_voices_title'] ) ) {
		update_post_meta( $post_id, '_lilacs_voices_title', sanitize_text_field( wp_unslash( $_POST['lilacs_voices_title'] ) ) );
	}
	for ( $v = 1; $v <= 6; $v++ ) {
		if ( isset( $_POST["lilacs_voice_{$v}_name"] ) ) {
			update_post_meta( $post_id, "_lilacs_voice_{$v}_name", sanitize_text_field( wp_unslash( $_POST["lilacs_voice_{$v}_name"] ) ) );
		}
		if ( isset( $_POST["lilacs_voice_{$v}_role"] ) ) {
			update_post_meta( $post_id, "_lilacs_voice_{$v}_role", sanitize_text_field( wp_unslash( $_POST["lilacs_voice_{$v}_role"] ) ) );
		}
		if ( isset( $_POST["lilacs_voice_{$v}_text"] ) ) {
			update_post_meta( $post_id, "_lilacs_voice_{$v}_text", wp_kses_post( wp_unslash( $_POST["lilacs_voice_{$v}_text"] ) ) );
		}
		if ( isset( $_POST["lilacs_voice_{$v}_avatar"] ) ) {
			update_post_meta( $post_id, "_lilacs_voice_{$v}_avatar", esc_url_raw( wp_unslash( $_POST["lilacs_voice_{$v}_avatar"] ) ) );
		}
	}

	// --- NOVO: salvar SESSÕES EXTRAS (JSON) ---
	if ( isset( $_POST['lilacs_extra_sections'] ) ) {
		$raw = wp_unslash( $_POST['lilacs_extra_sections'] );
		$decoded = json_decode( $raw, true );
		$clean = [];
		if ( is_array( $decoded ) ) {
			foreach ( $decoded as $item ) {
				if ( ! is_array( $item ) ) continue;
				$title = isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
				$desc  = isset( $item['desc'] ) ? wp_kses_post( $item['desc'] ) : '';
				$words = isset( $item['words'] ) ? sanitize_textarea_field( $item['words'] ) : '';
				if ( $title || $desc || $words ) {
					$clean[] = [ 'title' => $title, 'desc' => $desc, 'words' => $words ];
				}
			}
		}
		if ( ! empty( $clean ) ) {
			update_post_meta( $post_id, '_lilacs_extra_sections', wp_json_encode( $clean ) );
		} else {
			delete_post_meta( $post_id, '_lilacs_extra_sections' );
		}
	}

	// salvar cores de fundo (hex)
	if ( isset( $_POST['lilacs_bg_hero'] ) ) {
		update_post_meta( $post_id, '_lilacs_bg_hero', sanitize_hex_color( wp_unslash( $_POST['lilacs_bg_hero'] ) ) );
	}
	if ( isset( $_POST['lilacs_bg_oque'] ) ) {
		update_post_meta( $post_id, '_lilacs_bg_oque', sanitize_hex_color( wp_unslash( $_POST['lilacs_bg_oque'] ) ) );
	}
	if ( isset( $_POST['lilacs_bg_nuvens'] ) ) {
		update_post_meta( $post_id, '_lilacs_bg_nuvens', sanitize_hex_color( wp_unslash( $_POST['lilacs_bg_nuvens'] ) ) );
	}
	if ( isset( $_POST['lilacs_bg_cards'] ) ) {
		update_post_meta( $post_id, '_lilacs_bg_cards', sanitize_hex_color( wp_unslash( $_POST['lilacs_bg_cards'] ) ) );
	}
	if ( isset( $_POST['lilacs_bg_meetings'] ) ) {
		update_post_meta( $post_id, '_lilacs_bg_meetings', sanitize_hex_color( wp_unslash( $_POST['lilacs_bg_meetings'] ) ) );
	}
	if ( isset( $_POST['lilacs_bg_voices'] ) ) {
		update_post_meta( $post_id, '_lilacs_bg_voices', sanitize_hex_color( wp_unslash( $_POST['lilacs_bg_voices'] ) ) );
	}

}, 10, 1 );
