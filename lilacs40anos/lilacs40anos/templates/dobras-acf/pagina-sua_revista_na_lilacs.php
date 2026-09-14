<?php
/**
 * DOBRA: Sua revista na LILACS
 * Slug: pagina-sua_revista_na_lilacs.php
 *
 * Campos ACF:
 * - titulo, descricao
 * - cards (repeater, arrastável):
 *     tipo, titulo, descricao, texto_do_botao, link_do_botao
 *     titulo_2, descricao_2, texto_do_botao_2, link_do_botao_2
 *     botoes_adicionais (repeater)
 *
 * Fallback (conteúdo antigo): groups periodicos_indexados_na_lilacs,
 * portal_de_revistas_cientificas, atualize_os_dados_do_seu_periodico
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo    = get_sub_field( 'titulo' );
$descricao = get_sub_field( 'descricao' );

$perfil_link = 'https://lilacs.bvsalud.org/indicadores-lilacs/#perfil-periodicos';

if ( ! function_exists( 'lilacs_revista_normalize_extras' ) ) {
	/**
	 * Normaliza o repeater de botões extras de um card/grupo.
	 *
	 * @param mixed $raw Repeater ACF.
	 * @return array<int, array{titulo:string, descricao:string, texto_do_botao:string, link_do_botao:string}>
	 */
	function lilacs_revista_normalize_extras( $raw ) {
		$extras = [];
		if ( ! is_array( $raw ) || empty( $raw ) ) {
			return $extras;
		}
		foreach ( $raw as $extra ) {
			if ( ! is_array( $extra ) ) {
				continue;
			}
			$extras[] = [
				'titulo'         => (string) ( $extra['titulo'] ?? '' ),
				'descricao'      => (string) ( $extra['descricao'] ?? '' ),
				'texto_do_botao' => (string) ( $extra['texto_do_botao'] ?? '' ),
				'link_do_botao'  => (string) ( $extra['link_do_botao'] ?? '' ),
			];
		}
		return $extras;
	}
}

if ( ! function_exists( 'lilacs_revista_card_from_row' ) ) {
	/**
	 * Monta um card a partir de uma linha de repeater ou group ACF.
	 *
	 * @param array  $row  Linha ACF.
	 * @param string $type Tipo/ícone do card.
	 * @return array
	 */
	function lilacs_revista_card_from_row( array $row, $type ) {
		return [
			'type'              => (string) $type,
			'titulo'            => (string) ( $row['titulo'] ?? '' ),
			'descricao'         => (string) ( $row['descricao'] ?? '' ),
			'texto_do_botao'    => (string) ( $row['texto_do_botao'] ?? '' ),
			'link_do_botao'     => (string) ( $row['link_do_botao'] ?? '' ),
			'titulo_2'          => (string) ( $row['titulo_2'] ?? '' ),
			'descricao_2'       => (string) ( $row['descricao_2'] ?? '' ),
			'texto_do_botao_2'  => (string) ( $row['texto_do_botao_2'] ?? '' ),
			'link_do_botao_2'   => (string) ( $row['link_do_botao_2'] ?? '' ),
			'botoes_adicionais' => lilacs_revista_normalize_extras( $row['botoes_adicionais'] ?? [] ),
		];
	}
}

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
		$cards[] = lilacs_revista_card_from_row( $row, $type );
	}
}

// Fallback: groups antigos (ordem fixa) — só se ainda não houver cards no flexible
if ( empty( $cards ) ) {
	$g_periodicos = (array) get_sub_field( 'periodicos_indexados_na_lilacs' );
	$g_portal     = (array) get_sub_field( 'portal_de_revistas_cientificas' );
	$g_atualize   = (array) get_sub_field( 'atualize_os_dados_do_seu_periodico' );

	$cards = [
		lilacs_revista_card_from_row( $g_periodicos, 'periodicos_indexados' ),
		lilacs_revista_card_from_row( $g_portal, 'portal_revistas' ),
		lilacs_revista_card_from_row( $g_atualize, 'atualize_periodico' ),
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
			grid-template-columns: repeat(3, minmax(0, 1fr));
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
			min-width:0;
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
		.lilacs-card__actions{
			margin-top:auto;
			display:flex;
			flex-direction:column;
			align-items:flex-start;
			gap:10px;
			width:100%;
		}

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
			margin-top:4px;
			padding-top:14px;
			border-top:1px dashed #CFE0F3;
			width:100%;
		}
		.lilacs-note strong{ color:var(--blue-900); font-size:14px; }
		.lilacs-note p{ margin:6px 0 0; }
		.lilacs-note .lilacs-btn{ margin-top:10px; }

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

				$extras = [];

				$t2 = (string) ( $card['titulo_2'] ?? '' );
				$d2 = (string) ( $card['descricao_2'] ?? '' );
				$b2 = (string) ( $card['texto_do_botao_2'] ?? '' );
				$l2 = (string) ( $card['link_do_botao_2'] ?? '' );
				if ( $t2 !== '' || $d2 !== '' || $b2 !== '' || $l2 !== '' ) {
					$extras[] = [
						'titulo'         => $t2,
						'descricao'      => $d2,
						'texto_do_botao' => $b2,
						'link_do_botao'  => $l2,
						'legacy_feat'    => $is_feat,
					];
				}

				foreach ( (array) ( $card['botoes_adicionais'] ?? [] ) as $extra ) {
					if ( ! is_array( $extra ) ) {
						continue;
					}
					$extras[] = $extra;
				}
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

						<div class="lilacs-card__actions">
							<?php if ( $c_link !== '' ) : ?>
								<a class="lilacs-btn"
								   href="<?php echo esc_url( $c_link ); ?>"
								   target="_blank" rel="noopener">
									<?php echo esc_html( $c_btn !== '' ? $c_btn : $def['btn'] ); ?>
									<span class="lilacs-btn__arrow" aria-hidden="true">→</span>
								</a>
							<?php endif; ?>

							<?php foreach ( $extras as $extra ) :
								$et = (string) ( $extra['titulo'] ?? '' );
								$ed = (string) ( $extra['descricao'] ?? '' );
								$eb = (string) ( $extra['texto_do_botao'] ?? '' );
								$el = (string) ( $extra['link_do_botao'] ?? '' );
								$legacy_feat = ! empty( $extra['legacy_feat'] );
								$has_copy    = ( $et !== '' || $ed !== '' );

								if ( ! $has_copy && $el === '' && ! $legacy_feat ) {
									continue;
								}

								if ( $has_copy || $legacy_feat ) :
							?>
								<div class="lilacs-note" role="note">
									<?php if ( $et !== '' ) : ?>
										<strong><?php echo esc_html( $et ); ?></strong>
									<?php elseif ( $legacy_feat ) : ?>
										<strong><?php echo esc_html( 'Avaliação de permanência na coleção' ); ?></strong>
									<?php endif; ?>

									<?php if ( $ed !== '' ) : ?>
										<div class="lilacs-wysiwyg" style="margin-top:6px;"><?php echo wp_kses_post( $ed ); ?></div>
									<?php elseif ( $legacy_feat ) : ?>
										<p style="margin:6px 0 0; margin-bottom: 21px;">Acesse o Perfil de Periódicos LILACS quando o serviço estiver disponível.</p>
									<?php endif; ?>

									<?php if ( $el !== '' ) : ?>
										<a class="lilacs-btn"
										   href="<?php echo esc_url( $el ); ?>"
										   target="_blank" rel="noopener">
											<?php echo esc_html( $eb !== '' ? $eb : 'Acessar' ); ?>
											<span class="lilacs-btn__arrow" aria-hidden="true">→</span>
										</a>
									<?php elseif ( $legacy_feat ) : ?>
										<a class="lilacs-btn lilacs-btn--disabled"
										   href="<?php echo esc_url( $perfil_link ); ?>"
										   aria-disabled="true"
										   tabindex="-1"
										   title="Temporariamente indisponível">
											Perfil de periódicos (indisponível)
										</a>
									<?php endif; ?>
								</div>
							<?php else : ?>
								<a class="lilacs-btn"
								   href="<?php echo esc_url( $el ); ?>"
								   target="_blank" rel="noopener">
									<?php echo esc_html( $eb !== '' ? $eb : 'Acessar' ); ?>
									<span class="lilacs-btn__arrow" aria-hidden="true">→</span>
								</a>
							<?php
								endif;
							endforeach; ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
