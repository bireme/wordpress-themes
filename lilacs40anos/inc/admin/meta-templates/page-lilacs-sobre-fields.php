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
	// novo campo: Missão (campo de texto)
	$intro_missao = get_post_meta( $post->ID, '_lilacs_intro_missao', true );

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
	
	// --- NOVO: metas para as 3 DOBRAS com nuvem ---
    // REDES
    $redes_title   = get_post_meta( $post->ID, '_lilacs_redes_title', true );
    $redes_desc    = get_post_meta( $post->ID, '_lilacs_redes_desc', true );
    $redes_words   = get_post_meta( $post->ID, '_lilacs_redes_words', true );
    $bg_redes      = get_post_meta( $post->ID, '_lilacs_bg_redes', true );
    $redes_mt      = get_post_meta( $post->ID, '_lilacs_redes_spacing_top', true );
    $redes_mb      = get_post_meta( $post->ID, '_lilacs_redes_spacing_bottom', true );
    
    // LILACS PLUS
    $plus_title    = get_post_meta( $post->ID, '_lilacs_plus_title', true );
    $plus_desc     = get_post_meta( $post->ID, '_lilacs_plus_desc', true );
    $plus_words    = get_post_meta( $post->ID, '_lilacs_plus_words', true );
    $bg_plus       = get_post_meta( $post->ID, '_lilacs_bg_plus', true );
    $plus_mt       = get_post_meta( $post->ID, '_lilacs_plus_spacing_top', true );
    $plus_mb       = get_post_meta( $post->ID, '_lilacs_plus_spacing_bottom', true );
    
    // ECOSSISTEMA
    $ecos_title    = get_post_meta( $post->ID, '_lilacs_ecos_title', true );
    $ecos_desc     = get_post_meta( $post->ID, '_lilacs_ecos_desc', true );
    $ecos_words    = get_post_meta( $post->ID, '_lilacs_ecos_words', true );
    $bg_ecos       = get_post_meta( $post->ID, '_lilacs_bg_ecos', true );
    $ecos_mt       = get_post_meta( $post->ID, '_lilacs_ecos_spacing_top', true );
    $ecos_mb       = get_post_meta( $post->ID, '_lilacs_ecos_spacing_bottom', true );



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
		<div class="lilacs-tab" data-tab="redes" role="tab">Redes Nacionais & Temáticas</div>
<div class="lilacs-tab" data-tab="plus" role="tab">LILACS Plus</div>
<div class="lilacs-tab" data-tab="ecos" role="tab">Ecossistema</div>
<div class="lilacs-tab" data-tab="promo" role="tab">Links + Banner + Boxes</div>

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
	</div>

	<!-- painel "O QUE É" (se já presente) -->
	<div class="lilacs-tab-panel" data-panel="sobre" role="tabpanel">
		<div class="lilacs-row">
			<label for="lilacs_intro_title">Título (seção "O que é")</label>
			<input id="lilacs_intro_title" name="lilacs_intro_title" class="lilacs-input" type="text" value="<?php echo esc_attr( $intro_title ); ?>">
		</div>

		<div class="lilacs-row">
			<label for="lilacs_intro_missao">Missão</label>
			<input id="lilacs_intro_missao" name="lilacs_intro_missao" class="lilacs-input" type="text" value="<?php echo esc_attr( $intro_missao ); ?>">
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
						<input id="lilacs_voice_<?php echo $v; ?>_avatar" name="lilacs_voice_<?php echo $v; ?>_avatar" class="lilacs-input" type="text" value="<?php echo esc_attr( $voices[$v]['avatar'] ); ?>">
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	
	
	
	<!-- REDES NACIONAIS & TEMÁTICAS -->
<div class="lilacs-tab-panel" data-panel="redes" role="tabpanel">
  <div class="lilacs-row">
    <label for="lilacs_redes_title">Título (Redes)</label>
    <input id="lilacs_redes_title" name="lilacs_redes_title" class="lilacs-input" type="text" value="<?php echo esc_attr($redes_title); ?>">
  </div>
  <div class="lilacs-row">
    <label for="lilacs_redes_desc">Descrição (Redes)</label>
    <textarea id="lilacs_redes_desc" name="lilacs_redes_desc" rows="3" class="lilacs-textarea"><?php echo esc_textarea($redes_desc); ?></textarea>
  </div>
  <div class="lilacs-row">
    <label for="lilacs_redes_words">Palavras da Nuvem (CSV ou uma por linha)</label>
    <textarea id="lilacs_redes_words" name="lilacs_redes_words" rows="4" class="lilacs-textarea"><?php echo esc_textarea($redes_words); ?></textarea>
  </div>
  <div class="lilacs-row">
    <label for="lilacs_bg_redes">Cor de fundo (hex, rgb ou nome CSS)</label>
    <input id="lilacs_bg_redes" name="lilacs_bg_redes" class="lilacs-input" type="text" placeholder="#f7f7f7" value="<?php echo esc_attr($bg_redes); ?>">
  </div>
  <div class="lilacs-row">
    <label>Espaçamentos (px)</label>
    <div style="display:flex; gap:8px">
      <input name="lilacs_redes_spacing_top" class="lilacs-input" type="number" placeholder="Topo" value="<?php echo esc_attr($redes_mt); ?>">
      <input name="lilacs_redes_spacing_bottom" class="lilacs-input" type="number" placeholder="Base" value="<?php echo esc_attr($redes_mb); ?>">
    </div>
  </div>
</div>

<!-- LILACS PLUS -->
<div class="lilacs-tab-panel" data-panel="plus" role="tabpanel">
  <div class="lilacs-row">
    <label for="lilacs_plus_title">Título (LILACS Plus)</label>
    <input id="lilacs_plus_title" name="lilacs_plus_title" class="lilacs-input" type="text" value="<?php echo esc_attr($plus_title); ?>">
  </div>
  <div class="lilacs-row">
    <label for="lilacs_plus_desc">Descrição (LILACS Plus)</label>
    <textarea id="lilacs_plus_desc" name="lilacs_plus_desc" rows="3" class="lilacs-textarea"><?php echo esc_textarea($plus_desc); ?></textarea>
  </div>
  <div class="lilacs-row">
    <label for="lilacs_plus_words">Palavras da Nuvem (CSV ou uma por linha)</label>
    <textarea id="lilacs_plus_words" name="lilacs_plus_words" rows="4" class="lilacs-textarea"><?php echo esc_textarea($plus_words); ?></textarea>
  </div>
  <div class="lilacs-row">
    <label for="lilacs_bg_plus">Cor de fundo</label>
    <input id="lilacs_bg_plus" name="lilacs_bg_plus" class="lilacs-input" type="text" placeholder="#ffffff" value="<?php echo esc_attr($bg_plus); ?>">
  </div>
  <div class="lilacs-row">
    <label>Espaçamentos (px)</label>
    <div style="display:flex; gap:8px">
      <input name="lilacs_plus_spacing_top" class="lilacs-input" type="number" placeholder="Topo" value="<?php echo esc_attr($plus_mt); ?>">
      <input name="lilacs_plus_spacing_bottom" class="lilacs-input" type="number" placeholder="Base" value="<?php echo esc_attr($plus_mb); ?>">
    </div>
  </div>
</div>

<!-- ECOSSISTEMA -->
<div class="lilacs-tab-panel" data-panel="ecos" role="tabpanel">
  <div class="lilacs-row">
    <label for="lilacs_ecos_title">Título (Ecossistema)</label>
    <input id="lilacs_ecos_title" name="lilacs_ecos_title" class="lilacs-input" type="text" value="<?php echo esc_attr($ecos_title); ?>">
  </div>
  <div class="lilacs-row">
    <label for="lilacs_ecos_desc">Descrição (Ecossistema)</label>
    <textarea id="lilacs_ecos_desc" name="lilacs_ecos_desc" rows="3" class="lilacs-textarea"><?php echo esc_textarea($ecos_desc); ?></textarea>
  </div>
  <div class="lilacs-row">
    <label for="lilacs_ecos_words">Palavras da Nuvem (CSV ou uma por linha)</label>
    <textarea id="lilacs_ecos_words" name="lilacs_ecos_words" rows="4" class="lilacs-textarea"><?php echo esc_textarea($ecos_words); ?></textarea>
  </div>
  <div class="lilacs-row">
    <label for="lilacs_bg_ecos">Cor de fundo</label>
    <input id="lilacs_bg_ecos" name="lilacs_bg_ecos" class="lilacs-input" type="text" placeholder="#ffffff" value="<?php echo esc_attr($bg_ecos); ?>">
  </div>
  <div class="lilacs-row">
    <label>Espaçamentos (px)</label>
    <div style="display:flex; gap:8px">
      <input name="lilacs_ecos_spacing_top" class="lilacs-input" type="number" placeholder="Topo" value="<?php echo esc_attr($ecos_mt); ?>">
      <input name="lilacs_ecos_spacing_bottom" class="lilacs-input" type="number" placeholder="Base" value="<?php echo esc_attr($ecos_mb); ?>">
    </div>
  </div>
</div>

<!-- LINKS RÁPIDOS + BANNER + BOXES -->
<?php
// ler valores atuais (se preferir, já estava no front; repetimos no admin)
$quick = []; for($i=1;$i<=4;$i++){
  $quick[$i] = [
    'title' => get_post_meta($post->ID, "_lilacs_quick_{$i}_title", true),
    'url'   => get_post_meta($post->ID, "_lilacs_quick_{$i}_url",   true),
    'icon'  => get_post_meta($post->ID, "_lilacs_quick_{$i}_icon",  true),
  ];
}
$slides = []; for($s=1;$s<=3;$s++){
  $slides[$s] = [
    'title'   => get_post_meta($post->ID, "_lilacs_banner_{$s}_title", true),
    'desc'    => get_post_meta($post->ID, "_lilacs_banner_{$s}_desc",  true),
    'btn_txt' => get_post_meta($post->ID, "_lilacs_banner_{$s}_btn_txt", true),
    'btn_url' => get_post_meta($post->ID, "_lilacs_banner_{$s}_btn_url", true),
    'img_id'  => (int) get_post_meta($post->ID, "_lilacs_banner_{$s}_img_id", true),
  ];
}
$boxes = []; for($b=1;$b<=3;$b++){
  $boxes[$b] = [
    'title'  => get_post_meta($post->ID, "_lilacs_box_{$b}_title", true),
    'url'    => get_post_meta($post->ID, "_lilacs_box_{$b}_url",   true),
    'img_id' => (int) get_post_meta($post->ID, "_lilacs_box_{$b}_img_id", true),
  ];
}
?>
<div class="lilacs-tab-panel" data-panel="promo" role="tabpanel">
  <!-- 4 CARDS -->
  <div class="lilacs-row"><strong>Links rápidos (4 cards)</strong></div>
  <div class="lilacs-stats-grid">
    <?php for($i=1;$i<=4;$i++): ?>
      <div class="lilacs-stat">
        <label for="lilacs_quick_<?php echo $i; ?>_title">Título #<?php echo $i; ?></label>
        <input class="lilacs-input" id="lilacs_quick_<?php echo $i; ?>_title" name="lilacs_quick_<?php echo $i; ?>_title" type="text" value="<?php echo esc_attr($quick[$i]['title']); ?>">
        <label for="lilacs_quick_<?php echo $i; ?>_url" style="margin-top:6px">URL #<?php echo $i; ?></label>
	<input class="lilacs-input" id="lilacs_quick_<?php echo $i; ?>_url" name="lilacs_quick_<?php echo $i; ?>_url" type="text" value="<?php echo esc_attr($quick[$i]['url']); ?>">
        <label for="lilacs_quick_<?php echo $i; ?>_icon" style="margin-top:6px">Ícone (opcional)</label>
        <input class="lilacs-input" id="lilacs_quick_<?php echo $i; ?>_icon" name="lilacs_quick_<?php echo $i; ?>_icon" type="text" placeholder="dashicons-arrow-right-alt2 ou SVG simples" value="<?php echo esc_attr($quick[$i]['icon']); ?>">
      </div>
    <?php endfor; ?>
  </div>

  <hr>

  <!-- BANNER ROTATIVO -->
  <div class="lilacs-row"><strong>Banner rotativo (até 3 slides)</strong></div>
  <?php for($s=1;$s<=3;$s++):
    $thumb = $slides[$s]['img_id'] ? wp_get_attachment_image_url($slides[$s]['img_id'], 'medium') : '';
  ?>
  <div class="lilacs-row" style="border:1px solid #eee;padding:10px;border-radius:8px;margin-bottom:10px">
    <label>Slide #<?php echo $s; ?> — imagem de fundo</label>
    <div class="lilacs-upload-wrap">
      <img src="<?php echo esc_url($thumb ?: ''); ?>" class="lilacs-upload-thumb" id="lilacs_banner_<?php echo $s; ?>_thumb">
      <input type="hidden" id="lilacs_banner_<?php echo $s; ?>_img_id" name="lilacs_banner_<?php echo $s; ?>_img_id" value="<?php echo esc_attr($slides[$s]['img_id']); ?>">
      <button type="button" class="button lilacs-media-btn" data-target="lilacs_banner_<?php echo $s; ?>_img_id" data-thumb="lilacs_banner_<?php echo $s; ?>_thumb">Selecionar</button>
      <button type="button" class="button lilacs-media-rm"   data-target="lilacs_banner_<?php echo $s; ?>_img_id" data-thumb="lilacs_banner_<?php echo $s; ?>_thumb">Remover</button>
    </div>

    <label style="margin-top:8px">Título</label>
    <input class="lilacs-input" name="lilacs_banner_<?php echo $s; ?>_title" type="text" value="<?php echo esc_attr($slides[$s]['title']); ?>">
    <label style="margin-top:6px">Descrição</label>
    <textarea class="lilacs-textarea" name="lilacs_banner_<?php echo $s; ?>_desc" rows="2"><?php echo esc_textarea($slides[$s]['desc']); ?></textarea>
    <div style="display:flex;gap:8px;margin-top:6px">
      <input class="lilacs-input" style="flex:1" name="lilacs_banner_<?php echo $s; ?>_btn_txt" type="text" placeholder="Texto do botão" value="<?php echo esc_attr($slides[$s]['btn_txt']); ?>">
	<input class="lilacs-input" style="flex:2" name="lilacs_banner_<?php echo $s; ?>_btn_url" type="text"  placeholder="URL do botão" value="<?php echo esc_attr($slides[$s]['btn_url']); ?>">
    </div>
  </div>
  <?php endfor; ?>

  <hr>

  <!-- 3 BOXES -->
  <div class="lilacs-row"><strong>Boxes inferiores (3)</strong></div>
  <div class="lilacs-stats-grid">
    <?php for($b=1;$b<=3;$b++):
      $thumb = $boxes[$b]['img_id'] ? wp_get_attachment_image_url($boxes[$b]['img_id'], 'medium') : '';
    ?>
    <div class="lilacs-stat">
      <label>Imagem box #<?php echo $b; ?></label>
      <div class="lilacs-upload-wrap">
        <img src="<?php echo esc_url($thumb ?: ''); ?>" class="lilacs-upload-thumb" id="lilacs_box_<?php echo $b; ?>_thumb">
        <input type="hidden" id="lilacs_box_<?php echo $b; ?>_img_id" name="lilacs_box_<?php echo $b; ?>_img_id" value="<?php echo esc_attr($boxes[$b]['img_id']); ?>">
        <button type="button" class="button lilacs-media-btn" data-target="lilacs_box_<?php echo $b; ?>_img_id" data-thumb="lilacs_box_<?php echo $b; ?>_thumb">Selecionar</button>
        <button type="button" class="button lilacs-media-rm"  data-target="lilacs_box_<?php echo $b; ?>_img_id" data-thumb="lilacs_box_<?php echo $b; ?>_thumb">Remover</button>
      </div>
      <label style="margin-top:6px">Título</label>
      <input class="lilacs-input" name="lilacs_box_<?php echo $b; ?>_title" type="text" value="<?php echo esc_attr($boxes[$b]['title']); ?>">
      <label style="margin-top:6px">URL</label>
	<input class="lilacs-input" name="lilacs_box_<?php echo $b; ?>_url" type="text" value="<?php echo esc_attr($boxes[$b]['url']); ?>">
    </div>
    <?php endfor; ?>
  </div>
</div>

<script>
(function($){
  $(document).on('click','.lilacs-media-btn',function(e){
    e.preventDefault();
    const tgt = $(this).data('target');
    const th  = $(this).data('thumb');
    // criar um media frame novo para cada clique para garantir que o callback capture
    // corretamente o target/thumbnail atuais
    const frame = wp.media({
      title: 'Selecionar imagem',
      button: { text: 'Usar imagem' },
      multiple: false
    });
    frame.on('select', function(){
      const at = frame.state().get('selection').first().toJSON();
      $('#' + tgt).val(at.id);
      $('#' + th).attr('src', (at.sizes && at.sizes.medium ? at.sizes.medium.url : at.url));
    });
    frame.open();
  });
   $(document).on('click','.lilacs-media-rm',function(){
     const tgt = $(this).data('target');
     const th  = $(this).data('thumb');
     $('#'+tgt).val(''); $('#'+th).attr('src','');
   });
 })(jQuery);
</script>



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
	// salvar Missão
	if ( isset( $_POST['lilacs_intro_missao'] ) ) {
		update_post_meta( $post_id, '_lilacs_intro_missao', sanitize_text_field( wp_unslash( $_POST['lilacs_intro_missao'] ) ) );
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
	
	// --- NOVO: salvar REDES ---
if ( isset($_POST['lilacs_redes_title']) )
	update_post_meta($post_id, '_lilacs_redes_title', sanitize_text_field( wp_unslash($_POST['lilacs_redes_title']) ));
if ( isset($_POST['lilacs_redes_desc']) )
	update_post_meta($post_id, '_lilacs_redes_desc', wp_kses_post( wp_unslash($_POST['lilacs_redes_desc']) ));
if ( isset($_POST['lilacs_redes_words']) )
	update_post_meta($post_id, '_lilacs_redes_words', sanitize_textarea_field( wp_unslash($_POST['lilacs_redes_words']) ));
if ( isset($_POST['lilacs_bg_redes']) )
	update_post_meta($post_id, '_lilacs_bg_redes', sanitize_text_field( wp_unslash($_POST['lilacs_bg_redes']) ));
if ( isset($_POST['lilacs_redes_spacing_top']) )
	update_post_meta($post_id, '_lilacs_redes_spacing_top', intval($_POST['lilacs_redes_spacing_top']));
if ( isset($_POST['lilacs_redes_spacing_bottom']) )
	update_post_meta($post_id, '_lilacs_redes_spacing_bottom', intval($_POST['lilacs_redes_spacing_bottom']));

// --- NOVO: salvar LILACS PLUS ---
if ( isset($_POST['lilacs_plus_title']) )
	update_post_meta($post_id, '_lilacs_plus_title', sanitize_text_field( wp_unslash($_POST['lilacs_plus_title']) ));
if ( isset($_POST['lilacs_plus_desc']) )
	update_post_meta($post_id, '_lilacs_plus_desc', wp_kses_post( wp_unslash($_POST['lilacs_plus_desc']) ));
if ( isset($_POST['lilacs_plus_words']) )
	update_post_meta($post_id, '_lilacs_plus_words', sanitize_textarea_field( wp_unslash($_POST['lilacs_plus_words']) ));
if ( isset($_POST['lilacs_bg_plus']) )
	update_post_meta($post_id, '_lilacs_bg_plus', sanitize_text_field( wp_unslash($_POST['lilacs_bg_plus']) ));
if ( isset($_POST['lilacs_plus_spacing_top']) )
	update_post_meta($post_id, '_lilacs_plus_spacing_top', intval($_POST['lilacs_plus_spacing_top']));
if ( isset($_POST['lilacs_plus_spacing_bottom']) )
	update_post_meta($post_id, '_lilacs_plus_spacing_bottom', intval($_POST['lilacs_plus_spacing_bottom']));

// --- NOVO: salvar ECOSSISTEMA ---
if ( isset($_POST['lilacs_ecos_title']) )
	update_post_meta($post_id, '_lilacs_ecos_title', sanitize_text_field( wp_unslash($_POST['lilacs_ecos_title']) ));
if ( isset($_POST['lilacs_ecos_desc']) )
	update_post_meta($post_id, '_lilacs_ecos_desc', wp_kses_post( wp_unslash($_POST['lilacs_ecos_desc']) ));
if ( isset($_POST['lilacs_ecos_words']) )
	update_post_meta($post_id, '_lilacs_ecos_words', sanitize_textarea_field( wp_unslash($_POST['lilacs_ecos_words']) ));
if ( isset($_POST['lilacs_bg_ecos']) )
	update_post_meta($post_id, '_lilacs_bg_ecos', sanitize_text_field( wp_unslash($_POST['lilacs_bg_ecos']) ));
if ( isset($_POST['lilacs_ecos_spacing_top']) )
	update_post_meta($post_id, '_lilacs_ecos_spacing_top', intval($_POST['lilacs_ecos_spacing_top']));
if ( isset($_POST['lilacs_ecos_spacing_bottom']) )
	update_post_meta($post_id, '_lilacs_ecos_spacing_bottom', intval($_POST['lilacs_ecos_spacing_bottom']));


// === LINKS RÁPIDOS (4)
for($i=1;$i<=4;$i++){
  if (isset($_POST["lilacs_quick_{$i}_title"]))
    update_post_meta($post_id, "_lilacs_quick_{$i}_title", sanitize_text_field( wp_unslash($_POST["lilacs_quick_{$i}_title"]) ));
  if (isset($_POST["lilacs_quick_{$i}_url"]))
    update_post_meta($post_id, "_lilacs_quick_{$i}_url", esc_url_raw( wp_unslash($_POST["lilacs_quick_{$i}_url"]) ));
  if (isset($_POST["lilacs_quick_{$i}_icon"]))
    update_post_meta($post_id, "_lilacs_quick_{$i}_icon", sanitize_text_field( wp_unslash($_POST["lilacs_quick_{$i}_icon"]) ));
}

// === BANNER (3 slides)
for($s=1;$s<=3;$s++){
  if (isset($_POST["lilacs_banner_{$s}_img_id"]))
    update_post_meta($post_id, "_lilacs_banner_{$s}_img_id", intval($_POST["lilacs_banner_{$s}_img_id"]));
  if (isset($_POST["lilacs_banner_{$s}_title"]))
    update_post_meta($post_id, "_lilacs_banner_{$s}_title", sanitize_text_field( wp_unslash($_POST["lilacs_banner_{$s}_title"]) ));
  if (isset($_POST["lilacs_banner_{$s}_desc"]))
    update_post_meta($post_id, "_lilacs_banner_{$s}_desc", wp_kses_post( wp_unslash($_POST["lilacs_banner_{$s}_desc"]) ));
  if (isset($_POST["lilacs_banner_{$s}_btn_txt"]))
    update_post_meta($post_id, "_lilacs_banner_{$s}_btn_txt", sanitize_text_field( wp_unslash($_POST["lilacs_banner_{$s}_btn_txt"]) ));
  if (isset($_POST["lilacs_banner_{$s}_btn_url"]))
    update_post_meta($post_id, "_lilacs_banner_{$s}_btn_url", esc_url_raw( wp_unslash($_POST["lilacs_banner_{$s}_btn_url"]) ));
}

// === BOXES (3)
for($b=1;$b<=3;$b++){
  if (isset($_POST["lilacs_box_{$b}_img_id"]))
    update_post_meta($post_id, "_lilacs_box_{$b}_img_id", intval($_POST["lilacs_box_{$b}_img_id"]));
  if (isset($_POST["lilacs_box_{$b}_title"]))
    update_post_meta($post_id, "_lilacs_box_{$b}_title", sanitize_text_field( wp_unslash($_POST["lilacs_box_{$b}_title"]) ));
  if (isset($_POST["lilacs_box_{$b}_url"]))
    update_post_meta($post_id, "_lilacs_box_{$b}_url", esc_url_raw( wp_unslash($_POST["lilacs_box_{$b}_url"]) ));
}


}, 10, 1 );
