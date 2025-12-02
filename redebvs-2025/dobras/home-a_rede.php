<?php  
if ( ! defined( 'ABSPATH' ) ) exit;

// Campos da layout "a_rede" (ACF Flexible)
$bg_image        = get_sub_field('imagem_de_fundo'); // return_format: url
$mostrar_linhas  = get_sub_field('mostrar_linhas');
$tipo_linha      = get_sub_field('tipo_linha');      // tipo da linha (continua | tracejada)
$titulo          = get_sub_field('titulo');
$descricao       = get_sub_field('descricao_'); // nome está assim no seu group

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

// Repetidor: países e links para o mapa
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
    position: relative;
    padding: 0px 0;
    background-color: #f4f6fb;
    background-repeat: no-repeat;
    background-position: right center;
    background-size: contain;
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
    color: #003c71;
    font-weight: 700;
}

.home-a-rede-desc {
    font-size: 24px;
    line-height: 1.4;
    color: #25334a;
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
.bvs-search-target.is-active{
    background: #28367D !important;
    color: #fff !important;
    border-color: #ffffff;
    font-weight: 500;
}

/* Coluna direita com MAPA 2D */

.home-a-rede-col-right {
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.bvs-search-submit{
    background: #28367D !important;   
}
.bvs-search-target-label{
    color:#28367D !important;
}
.bvs-search-target{
    color:#28367D !important;
    border:1px solid #28367D !important
}

.home-a-rede-map {
    width: 100%;
    max-width: 420px;
    aspect-ratio: 4 / 3;
    border-radius: 16px;
    overflow: hidden;
}

/* Ajustes Leaflet dentro do container (mantido) */

.home-a-rede-map .leaflet-container {
    width: 100%;
    height: 100%;
}

/* ---------- CARD + BADGES DE REDES RELACIONADAS ---------- */

.home-a-rede-networks-wrapper {
    margin-top: 22px;
}

.home-a-rede-network-card {
    display: inline-block;
    background: #e2e7f7;
    border-radius: 18px;
    padding: 14px 18px 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

.home-a-rede-network-card-title {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #233a8b;
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
    background: #4a5590;
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
    background: #36407a;
    text-decoration: none;
}

/* esconder a versão do card que está na coluna esquerda */
.home-a-rede-col-left .home-a-rede-networks-wrapper {
    display: none;
}

/* Pequeno glow nos markers para deixar mais "vivo" */
.jvm-marker circle {
    transition: r 0.2s ease, filter 0.2s ease;
    filter: drop-shadow(0 0 4px rgba(0,0,0,0.25));
}
.jvm-marker:hover circle {
    r: 9;
    filter: drop-shadow(0 0 8px rgba(40,54,125,0.9));
}

/* ----------------- RESPONSIVO ----------------- */

@media (max-width: 900px) {
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

    /* mapa ocupando bem a largura no mobile */
    #map {
        width: 100% !important;
        height: 320px !important;
        max-width: 100% !important;
    }

    .home-a-rede-network-card {
        width: 100%;
        box-sizing: border-box;
    }

    .home-a-rede-search-form {
        grid-template-columns: 1fr auto;
        grid-template-rows: auto auto;
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

    #map {
        height: 260px !important;
    }

    .home-a-rede-network-badge {
        font-size: 11px;
        padding: 6px 10px;
    }
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.6.0/dist/css/jsvectormap.min.css" />

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
                <?= do_shortcode('[bvs_busca_repositorio]') ?>
            </div>

            <!-- CARD DE REDES RELACIONADAS -->
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

        <!-- Coluna direita com MAPA -->
        <div class="home-a-rede-col-right" aria-hidden="true">
        <div class="home-a-rede-col-right" aria-hidden="true">
            <div id="map" style="width:750px;height:520px;"></div>

            <!-- CARD DE REDES RELACIONADAS ABAIXO DO MAPA -->
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

<!-- Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/jsvectormap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>
<script>
// ====== dados vindos do ACF para os países do mapa ======
const paisesLinks = <?php echo wp_json_encode( $paises_links ); ?> || [];

// Configuração fixa de coordenadas + offsets dos países
// offsets  -> posição do círculo
// labelOffsets -> posição do texto (label) em relação ao círculo
const countryConfig = {
  "Brasil":               { coords: [-14.2350, -51.9253], offsets: [10, 0],   labelOffsets: [8, -4] },
  "Argentina":            { coords: [-38.4161, -63.6167], offsets: [10, 4],   labelOffsets: [8, 0] },
  "Paraguai":             { coords: [-23.4425, -58.4438], offsets: [8, -10],  labelOffsets: [8, -14] },
  "Uruguai":              { coords: [-32.5228, -55.7658], offsets: [8, 0],    labelOffsets: [8, -4] },
  "Chile":                { coords: [-35.6751, -71.5430], offsets: [10, 0],   labelOffsets: [10, -4] },
  "Bolívia":              { coords: [-16.2902, -63.5887], offsets: [8, -10],  labelOffsets: [8, -14] },
  "Peru":                 { coords: [-9.1900, -75.0152], offsets: [8, -10],   labelOffsets: [8, -14] },
  "Equador":              { coords: [-1.8312, -78.1834], offsets: [8, -10],   labelOffsets: [8, -14] },
  "Colômbia":             { coords: [4.5709, -74.2973],  offsets: [8, -8],    labelOffsets: [8, -12] },
  "Venezuela":            { coords: [6.4238, -66.5897],  offsets: [8, -8],    labelOffsets: [8, -12] },

  "México":               { coords: [23.6345, -102.5528], offsets: [8, -10],  labelOffsets: [-26, -10] },
  "Guatemala":            { coords: [15.7835, -90.2308],  offsets: [-40, -10],labelOffsets: [-52, -12] },
  "El Salvador":          { coords: [13.7942, -88.8965],  offsets: [-10, 8],  labelOffsets: [20, -4] },
  "Honduras":             { coords: [15.2000, -86.2419],  offsets: [10, -12], labelOffsets: [-10, -18] },
  "Nicarágua":            { coords: [12.8654, -85.2072],  offsets: [12, 8],   labelOffsets: [-72, 14] },
  "Costa Rica":           { coords: [9.7489, -83.7534],   offsets: [12, 0],   labelOffsets: [12, -4] },
  "Panamá":               { coords: [8.5380, -80.7821],   offsets: [12, 6],   labelOffsets: [-12, 12] },

  "Cuba":                 { coords: [21.5218, -77.7812],  offsets: [10, -10], labelOffsets: [-10, -14] },
  "República Dominicana": { coords: [18.7357, -70.1627],  offsets: [10, 0],   labelOffsets: [-10, -10] },
  "Porto Rico":           { coords: [18.2208, -66.5901],  offsets: [10, 8],   labelOffsets: [10, 0] },
  "Haiti":                { coords: [18.9712, -72.2852],  offsets: [-40, 0],  labelOffsets: [0, -32] },

  "Moçambique":           { coords: [-18.6657, 35.5296],  offsets: [10, 0],   labelOffsets: [10, -4] },
};

// Paleta por país (inspirada na bandeira)
const flagPalette = {
  "Brasil":               "#1B9A5A",
  "Argentina":            "#5DADE2",
  "Paraguai":             "#E57373",
  "Uruguai":              "#64B5F6",
  "Chile":                "#1976D2",
  "Bolívia":              "#F39C12",
  "Peru":                 "#E74C3C",
  "Equador":              "#F1C40F",
  "Colômbia":             "#F4B400",
  "Venezuela":            "#F39C12",

  "México":               "#2E7D32",
  "Guatemala":            "#4FC3F7",
  "El Salvador":          "#42A5F5",
  "Honduras":             "#64B5F6",
  "Nicarágua":            "#1E88E5",
  "Costa Rica":           "#EF5350",
  "Panamá":               "#29B6F6",

  "Cuba":                 "#C62828",
  "República Dominicana": "#1565C0",
  "Porto Rico":           "#D32F2F",
  "Haiti":                "#283593",

  "Moçambique":           "#00897B"
};

const defaultMarkerColor = "#3b82f6";

// Monta markers dinamicamente a partir do repeater paises_e_links
const markers = paisesLinks
  .map(item => {
    const name = item.pais || "";
    if (!name || !countryConfig[name]) return null;
    const cfg   = countryConfig[name];
    const color = flagPalette[name] || defaultMarkerColor;

    return {
      name: name,
      coords: cfg.coords,
      url: item.link || "",
      offsets: cfg.offsets || [0, 0],                    // posição do círculo
      labelOffsets: cfg.labelOffsets || cfg.offsets || [0, 0], // posição do label
      style: {
        initial: {
          fill: color,
          stroke: "#ffffff",
          strokeWidth: 3
        },
        hover: {
          fill: "#28367D",
          stroke: "#111827",
          strokeWidth: 3
        }
      }
    };
  })
  .filter(Boolean);

// ACF: mostrar_linhas (php -> js)
const mostrarLinhas = "<?php echo esc_js( $mostrar_linhas ); ?>";

// ACF: tipo_linha (continua | tracejada)
const tipoLinha  = "<?php echo esc_js( $tipo_linha ); ?>";
const strokeDash = (tipoLinha === "continua") ? "" : "6 3";

// ---------------- NOVA LÓGICA DE LINHAS ALEATÓRIAS ----------------
// Cada país terá ao menos 1 conexão aleatória com outro país (não ele mesmo).
let lines = [];
if (mostrarLinhas === "sim" && markers.length > 1) {
  const names = markers.map(m => m.name);

  // Para evitar duplicar muito (Brasil–Argentina e Argentina–Brasil),
  // usamos um set com chave ordenada.
  const usedPairs = new Set();

  const pairKey = (a, b) => {
    return (a < b) ? `${a}__${b}` : `${b}__${a}`;
  };

  markers.forEach((marker) => {
    const from = marker.name;
    // lista de possíveis destinos (todos menos ele mesmo)
    const destinos = names.filter(n => n !== from);
    if (!destinos.length) return;

    const randomIndex = Math.floor(Math.random() * destinos.length);
    const to = destinos[randomIndex];

    const key = pairKey(from, to);
    if (!usedPairs.has(key)) {
      usedPairs.add(key);
      lines.push({ from, to });
    }
  });
}
// ---------------- FIM NOVA LÓGICA ----------------

const mapElement = document.getElementById('map');

if (mapElement) {
  // Só deixa o jsVectorMap receber o scroll se CTRL estiver pressionado
  mapElement.addEventListener('wheel', function (e) {
    if (!e.ctrlKey) {
      e.stopImmediatePropagation();
    }
  });

  const map = new jsVectorMap({
    selector: "#map",
    map: "world",

    focusOn: {
      regions: [
        "BR","AR","PE","CL","CO","VE","UY","PY","BO","EC","SR","GY",
        "GT","SV","HN","NI","CR","PA","CU","DO","HT","PR","MX"
      ],
      scale: 2.2
    },

    zoomOnScroll: true,
    markers,
    lines,

    markerStyle: {
      initial: {
        fill: defaultMarkerColor,
        stroke: "#ffffff",
        strokeWidth: 3
      },
      hover: {
        fill: "#28367D",
        stroke: "#111827",
        strokeWidth: 3
      }
    },

    markerLabelStyle: {
      initial: {
        fontFamily: "`Segoe UI`, sans-serif",
        fontSize: 12,
        cursor: "pointer",
      },
      hover: {
        cursor: "pointer",
      },
    },

    labels: {
      markers: {
        render(marker) {
          return marker.name || marker.labelName || "N/A";
        },
        offsets(index) {
          // agora o label usa deslocamento próprio por país
          return markers[index].labelOffsets || [0, 0];
        },
      },
    },

    lineStyle: {
      stroke: "#3b82f6",
      strokeWidth: 1.5,
      strokeOpacity: 0.7,
      strokeDasharray: strokeDash,
      animation: true,
      curvature: -0.4,
    },

    onMarkerClick(event, index) {
      const marker = markers[index];
      if (marker && marker.url) {
        window.open(marker.url, "_blank");
      }
    },
  });
}
</script>
