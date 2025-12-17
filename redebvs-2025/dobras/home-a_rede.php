<?php  
if ( ! defined( 'ABSPATH' ) ) exit;

// Campos da layout "a_rede" (ACF Flexible)
$bg_image        = get_sub_field('imagem_de_fundo'); // return_format: url
$mostrar_linhas  = get_sub_field('mostrar_linhas'); // não será mais usado, mas deixei aqui caso use no futuro
$tipo_linha      = get_sub_field('tipo_linha');      // idem
$titulo          = get_sub_field('titulo');
$descricao       = get_sub_field('descricao_'); // nome está assim no seu group
$cor_de_fundo    = get_sub_field('cor_do_fundo');
$cor_do_titulo   = get_sub_field('cor_do_titulo');
$cor_destaque    = get_sub_field('cor_destaque');
$cor_contraste_destaque = get_sub_field('cor_contraste_destaque');

// Repetidor: Redes relacionadas
$redes_items = array();
if ( have_rows('redes_relacionadas') ) {
	while ( have_rows('redes_relacionadas') ) : the_row();
		$nome_rede = trim( (string) get_sub_field('nome_da_rede') );
		$link_rede = trim( (string) get_sub_field('link_da_rede') );
		if ( $nome_rede !== '' ) {
			$redes_items[] = array(
				'nome' => $nome_rede,
				'link' => $link_rede,
			);
		}
	endwhile;
}

// Repetidor: países e links
$paises_links = array();
if ( have_rows('paises_e_links') ) {
	while ( have_rows('paises_e_links') ) : the_row();
		$pais_nome = trim( (string) get_sub_field('pais') );
		$pais_link = trim( (string) get_sub_field('link') );
		if ( $pais_nome !== '' ) {
			$paises_links[] = array(
				'pais' => $pais_nome,
				'link' => $pais_link,
			);
		}
	endwhile;
}

// Quebra a lista de países em duas colunas para os dois "blocos" da direita
$col1 = array();
$col2 = array();

// LÓGICA (sequencial): primeiro enche a col1, depois a col2 (sem zig-zag)
$total = count($paises_links);
$half  = (int) ceil($total / 2);

$col1 = array_slice($paises_links, 0, $half);
$col2 = array_slice($paises_links, $half);

$bg_style = '';
if ( ! empty( $bg_image ) ) {
	// imagem de fundo alinhada à direita
	$bg_style = sprintf(
		'style="background-image:url(%s);"',
		esc_url( $bg_image )
	);
}
?>
<style>
/* DOBRA A REDE (layout 'a_rede') */

.home-a-rede-hero {
        background-position: center;
    background-size: contain;
	position: relative;
	padding: 0px 0;
	background-color: <?= esc_attr( $cor_de_fundo ); ?>;
	background-repeat: no-repeat;
    min-height: 75vh;
    display: flex;
}

.home-a-rede-inner {
	max-width: 1180px;
	margin: 0 auto;
	padding: 0 16px;
	display: grid;
	grid-template-columns: minmax(0, 620px) minmax(0, 1fr);
	gap: 40px;
	align-items: center;
}

.home-a-rede-col-left h1 {
	font-size: 26px;
	margin: 0 0 16px;
	color: <?= esc_attr( $cor_do_titulo ); ?>;
	font-weight: 700;
}

.home-a-rede-desc {
	font-size: 24px;
	line-height: 1.4;
	color: <?= esc_attr( $cor_do_titulo ); ?>;
	max-width: 500px;
	margin: -6px 0 28px;
	font-weight: 400;
}

/* Bloco de busca */

.home-a-rede-search-block {
	max-width: 520px;
}

.home-a-rede-search-form {
	display: grid;
	grid-template-columns: 1fr auto auto;
	border-radius: 8px;
	overflow: hidden;
	background: #ffffff;
	box-shadow: 0 4px 16px rgba(0,0,0,0.06);
	margin-bottom: 10px;
}

.home-a-rede-search-input {
	border: none;
	padding: 12px 14px;
	font-size: 14px;
	outline: none;
}

.home-a-rede-search-mic,
.home-a-rede-search-submit {
	border: none;
	background: #ffffff;
	padding: 0 12px;
	cursor: pointer;
	font-size: 16px;
}

.home-a-rede-search-submit {
	background: #233a8b;
	color: #ffffff;
}

/* Filtro "Buscar em" */

.home-a-rede-search-filter {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 8px;
	font-size: 13px;
	color: #555;
	margin-top: 4px;
}

.home-a-rede-chip {
	border-radius: 999px;
	padding: 6px 14px;
	font-size: 12px;
	border: 1px solid #233a8b;
	background: transparent;
	color: #233a8b;
	cursor: pointer;
}

.home-a-rede-chip.is-primary {
	background: #233a8b;
	color: #ffffff;
}
.bvs-search-target.is-active {
	background: <?= esc_attr( $cor_destaque ); ?> !important;
	color: <?= esc_attr( $cor_contraste_destaque ); ?> !important;
	border-color: #ffffff;
	font-weight: 500;
}
.bvs-search-submit {
	background: #28367D !important;   
}
.bvs-search-target-label {
	color: <?= esc_attr( $cor_do_titulo ); ?> !important;
}
.bvs-search-target {
	color: <?= esc_attr( $cor_do_titulo ) ; ?> !important;
	border:1px solid #28367D !important
}

/* COLUNA DIREITA – NOVO LAYOUT (sem mapa) */

.home-a-rede-col-right {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	justify-content: center;
	gap: 20px;
}

/* Container geral dos "blocs" de países */
.home-a-rede-country-layout {
	display: flex;
	flex-direction: column;
	gap: 18px;
}

/* Linha superior com 2 cartões de países */
.home-a-rede-country-row {
	display: flex;
	flex-wrap: wrap;
	flex-direction: row;
}

/* Cartões de países */
.home-a-rede-country-card {
    background: #28367dcf;
    border-radius: 10px 60px 10px 10px;
    margin-right: 20px;
    padding: 20px 26px;
    display: flex;
    min-width: 187px;
    max-width: 194px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    font-size: 14px;
    color: #233a8b;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.home-a-rede-country-card ul {
	list-style: none;
	margin: 0;
	padding: 0;
}

.home-a-rede-country-card li {
	display: flex;
	align-items: center;
	gap: 6px;
	margin-bottom: 3px;
	white-space: nowrap;
	color:#fff;
}

.home-a-rede-country-card li::before {
	content: "›";
	font-size: 11px;
	opacity: 0.9;
}

/* links de países */
.home-a-rede-country-card a {
	color: #fff;
	text-decoration: none;
}

.home-a-rede-country-card a:hover {
	text-decoration: underline;
}

/* CARD DE REDES RELACIONADAS (bolha inferior) */

.home-a-rede-networks-wrapper {
	margin-top: 10px;
}

.home-a-rede-network-card {
	display: inline-block;
	background: #233a8b;
	border-radius: 10px 60px 10px 10px;
	padding: 14px 22px 16px;
	box-shadow: 0 8px 20px rgba(0,0,0,0.18);
	color: #ffffff;
}

.home-a-rede-network-card-title {
	font-size: 11px;
	text-transform: uppercase;
	letter-spacing: 0.1em;
	color: #e1e7ff;
	margin: 0 0 8px;
}

.home-a-rede-network-badges {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.home-a-rede-network-badge {
	display: inline-flex;
	align-items: center;
	padding: 6px 14px;
	border-radius: 999px;
	background: rgba(255,255,255,0.12);
	color: #ffffff;
	font-size: 12px;
	font-weight: 500;
	text-decoration: none;
	white-space: nowrap;
}

.home-a-rede-network-badge::before {
	content: "▶";
	font-size: 9px;
	margin-right: 6px;
	transform: translateY(1px);
}

.home-a-rede-network-badge:hover {
	background: rgba(255,255,255,0.25);
	text-decoration: none;
}

/* esconder a versão do card que está na coluna esquerda (se quiser manter só na direita) */
.home-a-rede-col-left .home-a-rede-networks-wrapper {
	display: none;
}
.home-a-rede-hero {
	position: relative; /* já tem, mas reforçando que é importante */
	overflow: hidden;   /* garante que o overlay não “vaze” pra fora */
}

/* Conteúdo acima do overlay */
.home-a-rede-inner {
	position: relative;
	z-index: 1;
}

/* ----------------- RESPONSIVO (MOBILE) ----------------- */

@media (max-width: 900px) {

	/* Fade no fundo da sessão toda (apenas mobile) */

	.home-a-rede-inner {
		grid-template-columns: 1fr;
		gap: 24px;
	}

	.home-a-rede-hero {
		background-position: center bottom;
		background-size: 80%;
		padding-bottom: 160px;
		padding-top: 20px;
	}

	.home-a-rede-col-left {
		order: 1;
	}

	.home-a-rede-col-right {
		order: 2;
		width: 100%;
		margin-top: 10px;
	}

	.home-a-rede-country-row {
		flex-direction: column;
	}

	.home-a-rede-country-card,
	.home-a-rede-network-card {
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
		border-radius: 32px;
	}

	/* Respiro real: não encosta nas bordas do mobile */
	.home-a-rede-col-right {
		padding: 0 12px;
		box-sizing: border-box;
	}

	/* Caixas de países NÃO podem “colar” nas bordas (e evita parecer 100% colado) */
	.home-a-rede-country-card {
		margin-right: 0;
		margin-left: 0;
		margin-top: 0;
		margin-bottom: 12px;
		width: calc(100% - 16px);
		max-width: calc(100% - 16px);
		margin-inline: 8px;
		box-sizing: border-box;
	}

	/* ===== Corrige overflow horizontal do input de busca no mobile ===== */
	.home-a-rede-search-block {
		max-width: 100%;
		width: 100%;
		box-sizing: border-box;
	}

	.home-a-rede-search-form {
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
		grid-template-columns: minmax(0, 1fr) auto;
		overflow: hidden;
	}

	.home-a-rede-search-input {
		min-width: 0;
		width: 100%;
		box-sizing: border-box;
	}

	.home-a-rede-search-submit {
		white-space: nowrap;
	}

	.home-a-rede-search-form * {
		max-width: 100%;
		box-sizing: border-box;
	}

	.home-a-rede-search-mic {
		display: none;
	}

	.home-a-rede-search-input {
		padding: 10px 12px;
		font-size: 14px;
	}

	.home-a-rede-col-left h1 {
		font-size: 22px;
	}

	.home-a-rede-desc {
		font-size: 16px;
		margin-bottom: 20px;
		max-width: 100%;
	}
}

@media (max-width: 600px) {
	.home-a-rede-inner {
		padding: 0 12px;
	}

	.home-a-rede-col-left h1 {
		font-size: 20px;
	}

	.home-a-rede-desc {
		font-size: 15px;
	}

	.home-a-rede-network-badge {
		font-size: 11px;
		padding: 6px 10px;
	}

	/* Um pouco mais de respiro nas laterais em telas bem pequenas */
	.home-a-rede-col-right {
		padding: 0 14px;
	}

	.home-a-rede-country-card {
		width: calc(100% - 20px);
		max-width: calc(100% - 20px);
		margin-inline: 10px;
	}
}

/* ================= AJUSTE DEFINITIVO MOBILE (ANTI OVERFLOW) ================= */
@media (max-width: 900px) {

  /* trava qualquer estouro horizontal */
  .home-a-rede-hero,
  .home-a-rede-inner {
    overflow-x: hidden;
  }

  /* container mobile com respiro REAL */
  .home-a-rede-inner {
    padding-left: 16px;
    padding-right: 16px;
    box-sizing: border-box;
  }

  /* garante que nada dentro passe de 100vw */
  .home-a-rede-inner * {
    max-width: 100%;
    box-sizing: border-box;
    max-width: 86vw;
  }

  /* ===== BUSCA (corrige estouro do input) ===== */
  .home-a-rede-search-block {
    width: 100%;
    max-width: 100%;
  }

  .home-a-rede-search-form {
    width: 100%;
    max-width: 100%;
    grid-template-columns: minmax(0, 1fr) auto;
    overflow: hidden;
  }

  .home-a-rede-search-input {
    width: 100%;
    min-width: 0;
  }

  /* ===== COLUNA DIREITA ===== */
  .home-a-rede-col-right {
    width: 100%;
    padding: 0;
  }

  /* wrapper cria o respiro, NÃO o card */
  .home-a-rede-country-layout {
    padding-left: 8px;
    padding-right: 8px;
  }

  /* cards agora respeitam o padding */
  .home-a-rede-country-card {
    width: 100%;
    max-width: 100%;
    margin: 0 0 12px 0;
    border-radius: 28px;
    max-width: 86vw;
  }

  /* evita texto longo empurrar largura */
  .home-a-rede-country-card li {
    white-space: normal;
    word-break: break-word;
  }
}

/* telas muito pequenas */
@media (max-width: 600px) {
  .home-a-rede-country-layout {
    padding-left: 12px;
    padding-right: 12px;
  }
}

</style>

<section class="home-a-rede-hero" <?php echo $bg_style; ?>>
	<div class="home-a-rede-inner">

		<div class="home-a-rede-col-left">
			<?php if ( $titulo ) : ?>
				<h1><?php echo esc_html( $titulo ); ?></h1>
			<?php endif; ?>

			<?php if ( $descricao ) : ?>
				<p class="home-a-rede-desc">
					<?php echo esc_html( $descricao ); ?>
				</p>
			<?php endif; ?>

			<!-- Bloco de busca -->
			<div class="home-a-rede-search-block">
				<?= do_shortcode('[bvs_busca_repositorio]'); ?>
			</div>

			<!-- (Opcional) card de redes relacionadas também aqui, mas escondido via CSS em desktop -->
			<?php if ( ! empty( $redes_items ) ) : ?>
				<div class="home-a-rede-networks-wrapper">
					<div class="home-a-rede-network-card">
						<p class="home-a-rede-network-card-title">Redes relacionadas</p>
						<div class="home-a-rede-network-badges">
							<?php foreach ( $redes_items as $rede ) : 
								$nome = esc_html( $rede['nome'] );
								$link = esc_url( $rede['link'] );
								?>
								<?php if ( ! empty( $link ) ) : ?>
									<a class="home-a-rede-network-badge" href="<?php echo $link; ?>" target="_blank" rel="noopener">
										<?php echo $nome; ?>
									</a>
								<?php else : ?>
									<span class="home-a-rede-network-badge">
										<?php echo $nome; ?>
									</span>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>

		<!-- Coluna direita – NOVO LAYOUT SEM MAPA -->
		<div class="home-a-rede-col-right" aria-hidden="true">
			
			<div class="home-a-rede-country-layout">
				<div class="home-a-rede-country-row">
					
					<!-- Cartão 1 de países -->
					<?php if ( ! empty( $col1 ) ) : ?>
						<div class="home-a-rede-country-card">
							<ul>
								<?php foreach ( $col1 as $item ) : 
									$nome = esc_html( $item['pais'] );
									$link = esc_url( $item['link'] );
								?>
									<li>
										<?php if ( ! empty( $link ) ) : ?>
											<a href="<?php echo $link; ?>" target="_blank" rel="noopener">
												<?php echo $nome; ?>
											</a>
										<?php else : ?>
											<span><?php echo $nome; ?></span>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<!-- Cartão 2 de países -->
					<?php if ( ! empty( $col2 ) ) : ?>
						<div class="home-a-rede-country-card">
							<ul>
								<?php foreach ( $col2 as $item ) : 
									$nome = esc_html( $item['pais'] );
									$link = esc_url( $item['link'] );
								?>
									<li>
										<?php if ( ! empty( $link ) ) : ?>
											<a href="<?php echo $link; ?>" target="_blank" rel="noopener">
												<?php echo $nome; ?>
											</a>
										<?php else : ?>
											<span><?php echo $nome; ?></span>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

				</div>

				<!-- CARD DE REDES RELACIONADAS (bolha inferior à direita) -->
				<?php if ( ! empty( $redes_items ) ) : ?>
					<div class="home-a-rede-networks-wrapper">
						<div class="home-a-rede-network-card">
							<p class="home-a-rede-network-card-title">Redes relacionadas</p>
							<div class="home-a-rede-network-badges">
								<?php foreach ( $redes_items as $rede ) : 
									$nome = esc_html( $rede['nome'] );
									$link = esc_url( $rede['link'] );
								?>
									<?php if ( ! empty( $link ) ) : ?>
										<a class="home-a-rede-network-badge" href="<?php echo $link; ?>" target="_blank" rel="noopener">
											<?php echo $nome; ?>
										</a>
									<?php else : ?>
										<span class="home-a-rede-network-badge">
											<?php echo $nome; ?>
										</span>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>

		</div>

	</div>
</section>
