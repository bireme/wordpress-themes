<?php
/**
 * DOBRA: Sua revista na LILACS
 * Slug: pagina-sua_revista_na_lilacs.php
 *
 * Campos ACF:
 * - titulo, descricao
 * - cards (repeater, arrastável):
 *     tipo, titulo, descricao, texto_do_botao, link_do_botao
 *     (+ titulo_2, descricao_2, texto_do_botao_2, link_do_botao_2 se tipo=atualize)
 *
 * Fallback (conteúdo antigo): groups periodicos_indexados_na_lilacs,
 * portal_de_revistas_cientificas, atualize_os_dados_do_seu_periodico
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo    = get_sub_field( 'titulo' );
$descricao = get_sub_field( 'descricao' );

$perfil_link = 'https://lilacs.bvsalud.org/indicadores-lilacs/#perfil-periodicos';

/**
 * Monta lista de cards na ordem definida no painel (repeater "cards").
 * Aceita tambem o formato antigo de flexible content (acf_fc_layout).
 */
$cards     = [];
$cards_raw = get_sub_field( 'cards' );

if ( is_array( $cards_raw ) && ! empty( $cards_raw ) ) {
	foreach ( $cards_raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		// Repeater usa "tipo"; flexible antigo usava "acf_fc_layout"
		$type = (string) ( $row['tipo'] ?? $row['acf_fc_layout'] ?? '' );
		if ( $type === '' ) {
			continue;
		}
		$cards[] = [
			'type'             => $type,
			'titulo'           => (string) ( $row['titulo'] ?? '' ),
			'descricao'        => (string) ( $row['descricao'] ?? '' ),
			'texto_do_botao'   => (string) ( $row['texto_do_botao'] ?? '' ),
			'link_do_botao'    => (string) ( $row['link_do_botao'] ?? '' ),
			'titulo_2'         => (string) ( $row['titulo_2'] ?? '' ),
			'descricao_2'      => (string) ( $row['descricao_2'] ?? '' ),
			'texto_do_botao_2' => (string) ( $row['texto_do_botao_2'] ?? '' ),
			'link_do_botao_2'  => (string) ( $row['link_do_botao_2'] ?? '' ),
		];
	}
}

// Fallback: groups antigos (ordem fixa) — só se ainda não houver cards no flexible
if ( empty( $cards ) ) {
	$g_periodicos = (array) get_sub_field( 'periodicos_indexados_na_lilacs' );
	$g_portal     = (array) get_sub_field( 'portal_de_revistas_cientificas' );
	$g_atualize   = (array) get_sub_field( 'atualize_os_dados_do_seu_periodico' );

	$cards = [
		[
			'type'           => 'periodicos_indexados',
			'titulo'         => (string) ( $g_periodicos['titulo'] ?? '' ),
			'descricao'      => (string) ( $g_periodicos['descricao'] ?? '' ),
			'texto_do_botao' => (string) ( $g_periodicos['texto_do_botao'] ?? '' ),
			'link_do_botao'  => (string) ( $g_periodicos['link_do_botao'] ?? '' ),
		],
		[
			'type'           => 'portal_revistas',
			'titulo'         => (string) ( $g_portal['titulo'] ?? '' ),
			'descricao'      => (string) ( $g_portal['descricao'] ?? '' ),
			'texto_do_botao' => (string) ( $g_portal['texto_do_botao'] ?? '' ),
			'link_do_botao'  => (string) ( $g_portal['link_do_botao'] ?? '' ),
		],
		[
			'type'             => 'atualize_periodico',
			'titulo'           => (string) ( $g_atualize['titulo'] ?? '' ),
			'descricao'        => (string) ( $g_atualize['descricao'] ?? '' ),
			'texto_do_botao'   => (string) ( $g_atualize['texto_do_botao'] ?? '' ),
			'link_do_botao'    => (string) ( $g_atualize['link_do_botao'] ?? '' ),
			'titulo_2'         => (string) ( $g_atualize['titulo_2'] ?? '' ),
			'descricao_2'      => (string) ( $g_atualize['descricao_2'] ?? '' ),
			'texto_do_botao_2' => (string) ( $g_atualize['texto_do_botao_2'] ?? '' ),
			'link_do_botao_2'  => (string) ( $g_atualize['link_do_botao_2'] ?? '' ),
		],
	];
}

$icons = [
	'periodicos_indexados' => '<svg viewBox="0 0 24 24" fill="none"><path d="M8 6h13M8 12h13M8 18h13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M3.5 6h.01M3.5 12h.01M3.5 18h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"/></svg>',
	'portal_revistas'      => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" stroke="currentColor" stroke-width="2"/><path d="M2 12h20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M12 2c3.5 3 3.5 17 0 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M12 2c-3.5 3-3.5 17 0 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
	'atualize_periodico'   => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
];

$defaults = [
	'periodicos_indexados' => [
		'titulo' => 'Periódicos indexados na LILACS',
		'desc'   => 'Consulte a lista atual de periódicos indexados na LILACS.',
		'btn'    => 'Acessar periódicos',
	],
	'portal_revistas' => [
		'titulo' => 'Portal de Revistas Científicas',
		'desc'   => 'Verifique as informações do seu periódico no Portal de Revistas em Ciências da Saúde.',
		'btn'    => 'Acessar portal',
	],
	'atualize_periodico' => [
		'titulo' => 'Atualize os dados do seu periódico',
		'desc'   => 'Mantenha as informações corretas e atualizadas para melhor visibilidade e gestão.',
		'btn'    => 'Atualizar agora',
	],
];

// CSS só uma vez por página
static $lilacs_revista_css_printed = false;
if ( ! $lilacs_revista_css_printed ) :
	$lilacs_revista_css_printed = true;
	?>
	<style>
		.lilacs-journal{
			--blue-900:#002A4D;
			--blue-800:#003C71;
			--blue-50:#F5F9FF;
			--stroke:#D6E2F1;
			padding: 44px 20px;
			background: linear-gradient(180deg, var(--blue-50), #ffffff);
		}
		.lilacs-container{ max-width:1180px; margin:0 auto; }
		.lilacs-head h2{
			margin:0 0 10px;
			font-size:30px; line-height:1.2;
			color:var(--blue-800);
			letter-spacing:-0.3px;
		}
		.lilacs-head p{
			margin:0 0 22px;
			color:#355472;
			font-size:15px; line-height:1.6;
			max-width:78ch;
		}
		.lilacs-grid{
			display:grid;
			grid-template-columns: 1fr 1fr 1.2fr;
			gap:16px;
			align-items:stretch;
		}
		.lilacs-card{
			background:#fff;
			border:1px solid var(--stroke);
			border-radius:18px;
			padding:18px;
			box-shadow: 0 10px 30px rgba(0, 60, 113, 0.08);
			display:flex;
			gap:14px;
			transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
		}
		.lilacs-card:hover{
			transform: translateY(-2px);
			border-color:#BFD4EC;
			box-shadow: 0 14px 40px rgba(0, 60, 113, 0.12);
		}
		.lilacs-card__icon{
			width:44px; height:44px;
			border-radius:14px;
			background:#EAF2FB;
			color:#003C71;
			display:grid; place-items:center;
			flex:0 0 44px;
		}
		.lilacs-card__icon svg{ width:22px; height:22px; }
		.lilacs-card__body{
			display:flex;
			flex-direction:column;
			align-items:flex-start;
			width:100%;
		}
		.lilacs-card__body h3{
			margin:2px 0 8px;
			font-size:18px;
			color:var(--blue-900);
			letter-spacing:-0.2px;
		}
		.lilacs-card__body p{
			margin:0 0 14px;
			color:#355472;
			font-size:14px;
			line-height:1.55;
		}
		.lilacs-card__body .lilacs-btn{ margin-top:auto; }

		.lilacs-card--featured{
			border-color:#BFD4EC;
			background: linear-gradient(180deg, #ffffff, #FAFCFF);
		}

		.lilacs-btn{
			display:inline-flex;
			align-items:center;
			justify-content:space-between;
			gap:10px;
			padding:12px 18px;
			border-radius:999px;
			text-decoration:none;
			font-weight:700;
			font-size:14px;
			line-height:1;
			background:#082A53;
			color:#fff;
			border:none;
			min-width:220px;
			box-shadow:0 6px 16px rgba(8, 42, 83, 0.25);
			transition: transform .12s ease, background .12s ease;
			user-select:none;
		}
		.lilacs-btn:hover{ background:#0A3568; transform: translateY(-1px); }
		.lilacs-btn__arrow{ font-weight:900; }

		.lilacs-note{
			margin-top:14px;
			padding-top:14px;
			border-top:1px dashed #CFE0F3;
			width:100%;
		}
		.lilacs-note strong{ color:var(--blue-900); font-size:14px; }
		.lilacs-note p{ margin:6px 0 0; }

		.lilacs-btn--disabled{
			margin-top:10px;
			background:#D1DBE8;
			color:#6B7C93;
			box-shadow:none;
			cursor:not-allowed;
			pointer-events:none;
			min-width:220px;
		}
		.lilacs-wysiwyg > .lilacs-card{ border:none; }

		.lilacs-card__body .lilacs-wysiwyg{ color:#355472; font-size:14px; line-height:1.6; }
		.lilacs-card__body .lilacs-wysiwyg p{ margin:0 0 12px; }
		.lilacs-card__body .lilacs-wysiwyg a{ color:#0A3568; text-decoration:underline; }

		@media (max-width:980px){
			.lilacs-grid{ grid-template-columns:1fr; }
			.lilacs-btn{ min-width: 100%; }
		}
	</style>
<?php endif; ?>

<section class="lilacs-journal">
	<div class="lilacs-container">
		<header class="lilacs-head">
			<?php if ( ! empty( $titulo ) ) : ?>
				<h2><?php echo esc_html( $titulo ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $descricao ) ) : ?>
				<p><?php echo esc_html( $descricao ); ?></p>
			<?php endif; ?>
		</header>

		<div class="lilacs-grid">
			<?php foreach ( $cards as $card ) :
				$type     = $card['type'] ?? '';
				$def      = $defaults[ $type ] ?? [ 'titulo' => '', 'desc' => '', 'btn' => 'Acessar' ];
				$is_feat  = ( $type === 'atualize_periodico' );
				$icon_svg = $icons[ $type ] ?? $icons['periodicos_indexados'];
				$c_titulo = $card['titulo'] ?? '';
				$c_desc   = $card['descricao'] ?? '';
				$c_btn    = $card['texto_do_botao'] ?? '';
				$c_link   = $card['link_do_botao'] ?? '';
			?>
				<article class="lilacs-card<?php echo $is_feat ? ' lilacs-card--featured' : ''; ?>">
					<div class="lilacs-card__icon" aria-hidden="true">
						<?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="lilacs-card__body">
						<h3><?php echo esc_html( $c_titulo !== '' ? $c_titulo : $def['titulo'] ); ?></h3>

						<?php if ( $c_desc !== '' ) : ?>
							<div class="lilacs-wysiwyg"><?php echo wp_kses_post( $c_desc ); ?></div>
						<?php else : ?>
							<p><?php echo esc_html( $def['desc'] ); ?></p>
						<?php endif; ?>

						<?php if ( $c_link !== '' ) : ?>
							<a class="lilacs-btn"
							   href="<?php echo esc_url( $c_link ); ?>"
							   target="_blank" rel="noopener">
								<?php echo esc_html( $c_btn !== '' ? $c_btn : $def['btn'] ); ?>
								<span class="lilacs-btn__arrow" aria-hidden="true">→</span>
							</a>
						<?php endif; ?>

						<?php if ( $is_feat ) :
							$t2 = $card['titulo_2'] ?? '';
							$d2 = $card['descricao_2'] ?? '';
							$b2 = $card['texto_do_botao_2'] ?? '';
							$l2 = $card['link_do_botao_2'] ?? '';
							if ( $t2 !== '' || $d2 !== '' || $l2 !== '' ) :
						?>
							<div class="lilacs-note" role="note">
								<strong><?php echo esc_html( $t2 !== '' ? $t2 : 'Avaliação de permanência na coleção' ); ?></strong>

								<?php if ( $d2 !== '' ) : ?>
									<div class="lilacs-wysiwyg" style="margin-top:6px;"><?php echo wp_kses_post( $d2 ); ?></div>
								<?php else : ?>
									<p style="margin:6px 0 0; margin-bottom: 21px;">Acesse o Perfil de Periódicos LILACS quando o serviço estiver disponível.</p>
								<?php endif; ?>

								<?php if ( $l2 !== '' ) : ?>
									<a class="lilacs-btn"
									   href="<?php echo esc_url( $l2 ); ?>"
									   target="_blank" rel="noopener">
										<?php echo esc_html( $b2 !== '' ? $b2 : 'Acessar' ); ?>
										<span class="lilacs-btn__arrow" aria-hidden="true">→</span>
									</a>
								<?php else : ?>
									<a class="lilacs-btn lilacs-btn--disabled"
									   href="<?php echo esc_url( $perfil_link ); ?>"
									   aria-disabled="true"
									   tabindex="-1"
									   title="Temporariamente indisponível">
										Perfil de periódicos (indisponível)
									</a>
								<?php endif; ?>
							</div>
						<?php
							endif;
						endif;
						?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
