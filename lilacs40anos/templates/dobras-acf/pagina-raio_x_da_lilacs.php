<?php
/**
 * Dobra: Raio-X da LILACS
 * Arquivo: templates/pagina-raio_x_da_lilacs.php
 * Layout ACF: raio_x_da_lilacs (layout_69a993e6f666b)
 *
 * Observação: o gráfico é SVG (você vai colar depois). Aqui só reservamos o espaço.
 */
?>
<style>
    @font-face {
    font-family: 'Pennypacker-Light';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/fonnts.com-Pennypacker_Light.otf') format('opentype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}

    @font-face {
    font-family: 'Pennypacker-Book';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/fonnts.com-Pennypacker_Condensed_Book.otf') format('opentype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}

    @font-face {
    font-family: 'Pennypacker';
    src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/fonnts.com-Pennypacker_Regular.otf') format('opentype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}



</style>
<?php
if (!defined('ABSPATH'))
    exit;

// Campos do layout (sub_fields)
$titulo = (string) get_sub_field('titulo');
$esq = (array) get_sub_field('esquerda');
$dir = (array) get_sub_field('direita');
$fundo = get_sub_field('imagem_de_fundo'); // return_format = url
// Helpers
$esc = function ($v) {
    return esc_html((string) $v);
};

// Esquerda
$esq_num = $esq['texto_destaque_numero'] ?? '';
$esq_titpos = $esq['titulo_apos_numero'] ?? '';
$esq_desc = $esq['descricao_inferior'] ?? '';
$esq_svg = (array) ($esq['svg_grafico'] ?? []);
$esq_regs = $esq_svg['registros'] ?? '';
$esq_idi = $esq_svg['idiomas'] ?? '';
$esq_paises = $esq_svg['paises'] ?? '';
$esq_rev = $esq_svg['revistas'] ?? '';
$esq_txtc = $esq_svg['textos_completos'] ?? '';

// Direita
$dir_num = $dir['texto_destaque_numero'] ?? '';
$dir_titpos = $dir['titulo_apos_numero'] ?? '';
$dir_desc = $dir['descricao_inferior'] ?? '';
$dir_svg = (array) ($dir['svg_grafico'] ?? []);
$dir_regs = $dir_svg['registros'] ?? '';
$dir_idi = $dir_svg['idiomas'] ?? '';
$dir_paises = $dir_svg['paises'] ?? '';
$dir_rev = $dir_svg['revistas'] ?? '';
$dir_txtc = $dir_svg['textos_completos'] ?? '';



function lilacs_svg_apply_tokens(string $svg, array $map): string
{
    foreach ($map as $token => $value) {
        $svg = str_replace('{{' . $token . '}}', esc_html((string) $value), $svg);
    }
    return $svg;
}
?>

<section class="lilacs-raiox" style="background-image: url('<?php echo esc_url($fundo); ?>');">
    <div class="lilacs-raiox__inner">

        <?php if ($titulo): ?>
            <h2 class="lilacs-raiox__title"><?php echo $esc($titulo); ?></h2>
        <?php endif; ?>

        <div class="lilacs-raiox__grid">
            <div class="lilacs-raio-x-footer-left">
                <div class="lilacs-left-inner">
                    <div class="lilacs-raiox__foot lilacs-raiox__foot--left">
                        <div class="lilacs-raiox__big"><?php echo $esc($esq_num); ?> <small style="font-size: 16px;font-weight: 400;color: #00205C;font-weight: 400;font-family: 'Noto Sans';">anos</small></div>
                        <div class="lilacs-raiox__bigtitle"><?php echo $esc($esq_titpos); ?></div>
                        <div class="lilacs-raiox__desc"><?php echo nl2br($esc($esq_desc)); ?></div>
                    </div>
                </div>
            </div>
            <!-- COL ESQUERDA -->
            <article class="lilacs-raiox__col lilacs-raiox__col--left">
                <div class="lilacs-raiox__chart">
                    <!-- RESERVA PARA SVG (colar aqui depois) -->
                    <div class="lilacs-raiox__svg-slot" aria-label="Gráfico LILACS (SVG)">
                        <?php
                        // 2) SVG bruto (o seu, com tokens {{PAISES}}, {{IDIOMAS}}, {{REVISTAS}}, {{REGISTROS}}, {{TEXTOS_COMPLETOS}})
                        $svg_left_raw = <<<'SVG'
<svg id="Camada_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 401.29 467.29">
  <!-- Generator: Adobe Illustrator 29.8.4, SVG Export Plug-In . SVG Version: 2.1.1 Build 6)  -->
  <defs>
    <style>
      .st0, .st1 { font-size: 34.46px; }
      .st0, .st1, .st2, .st3 { fill: #fff; }
      .st0, .st2 { font-family: Pennypacker-Light, Pennypacker; font-weight: 300; }
      .st4 { fill: #085695; }
      .st1, .st3 { font-family: Pennypacker-Book, Pennypacker; }
      .st5 { fill: #799eb2; }
      .st6 { fill: #3073a0; }
      .st2, .st3 { font-size: 20.68px; }
      .st7 { fill: #00205c; }
      .st8 { fill: #8dbdd3; }
      .st9 { fill: #fafffb; }
    </style>
  </defs>
  <g>
    <path class="st5" d="M231.76,438.81c72.34,0,133.71-46.97,155.28-112.08l-155.28-51.48v163.56Z"/>
    <path class="st8" d="M367.41,320.24c4.69-14.14,7.23-29.26,7.23-44.97,0-48.43-24.1-91.22-60.95-117.07l-81.93,117.07,135.65,44.97Z"/>
    <path class="st6" d="M52.3,334.78c24.94,75.23,95.86,129.5,179.46,129.5v-189.04l-179.46,59.53Z"/>
    <path class="st7" d="M389.67,49.73C344.99,18.4,290.57,0,231.85,0S118.39,18.5,73.64,50l158.21,225.25L389.67,49.73Z"/>
    <path class="st4" d="M0,275.22c0,25.5,4.13,50.04,11.74,72.99l220.02-72.99L98.55,85.56C38.95,127.5,0,196.8,0,275.22Z"/>
    <circle class="st9" cx="231.65" cy="275.25" r="38.38"/>
  </g>

  <g>
    <text class="st1" transform="translate(264.2 360.78)"><tspan x="0" y="0">{{PAISES}}</tspan></text>
    <text class="st3" transform="translate(254.65 379.62)"><tspan x="0" y="0">países</tspan></text>
  </g>
  <g>
    <text class="st1" transform="translate(305.03 247.9)"><tspan x="0" y="0">{{IDIOMAS}}</tspan></text>
    <text class="st3" transform="translate(279.06 266.73)"><tspan x="0" y="0">idiomas</tspan></text>
  </g>
  <g>
    <text class="st1" transform="translate(87.21 368.9)"><tspan x="0" y="0">{{REVISTAS}}</tspan></text>
    <text class="st2" transform="translate(115.51 388.65)"><tspan x="0" y="0">revistas</tspan></text>
  </g>
  <g>
    <text class="st0" transform="translate(203.21 90.18)"><tspan x="0" y="0">{{REGISTROS}}</tspan><tspan x="-22.59" y="32.37">milhão</tspan></text>
    <text class="st2" transform="translate(188.87 148.8)"><tspan x="0" y="0">registros</tspan></text>
  </g>
  <g>
    <text class="st0" transform="translate(29.83 232.35)"><tspan x="0" y="0">{{TEXTOS_COMPLETOS}}</tspan></text>
    <text class="st2" transform="translate(20.99 256.93)"><tspan x="0" y="0">textos completos</tspan></text>
  </g>

  <!-- resto do SVG (paths/ícones) -->
  <g>
    <path class="st6" d="M36.1,370.55c-.64-.16-1.16-.4-1.58-.92-1.22-1.52-.09-3.83,1.89-3.33.77.19,1.44.99,1.44,1.8v.74h12.29v1.71h-14.05Z"/>
    <path class="st6" d="M51.63,349.2v18.24h-12.43v-18.24h12.43ZM49.74,351.18h-8.78v8.42h8.78v-8.42ZM49.7,361.22h-8.69v1.4h8.69v-1.4ZM49.7,364.15h-8.69v1.35h8.69v-1.35Z"/>
    <path class="st6" d="M37.85,365.46s-.41-.23-.48-.26c-1.34-.63-2.8-.33-3.85.67v-16.28c0-.49.56-1.41.95-1.71,1.25-.95,3.37.04,3.37,1.57v16.01Z"/>
    <path class="st6" d="M48.39,352.53v3.6l-1.55-1.39c-.07,0-.94.67-1.11.74-.06.02-.11.03-.16-.01l-2.02-1.8-1.24.85v-1.98h6.08ZM45.8,353.19c-1.08,0-.74,1.74.28,1.29.7-.31.42-1.29-.28-1.29Z"/>
    <path class="st6" d="M48.39,358.25h-4.41l2.73-1.76c.58.45,1.09.98,1.65,1.46l.04.3Z"/>
    <polygon class="st6" points="42.31 357.67 42.31 356.14 43.45 355.42 44.43 356.29 42.31 357.67"/>
  </g>

  <g>
    <path class="st4" d="M56.55,91.89l-.1-.25.03-23.59.23-.1c4.64.04,9.3-.06,13.94.05l4.34,4.35.02,3.34-.23.37-6.85,8.72c-.18,1.27-.54,2.69-.62,3.96-.05.7.33,1.11,1.04,1.04l3.83-1.55c1-1.03,1.78-2.33,2.73-3.39.03-.03,0-.09.11-.06v6.85s-.14.25-.14.25h-18.33ZM59.42,72.69c-.46.49-.16,1.36.52,1.43h10.66c.97-.18.98-1.52,0-1.68l-10.86.04c-.07.02-.28.16-.32.21ZM59.42,77.76c.05.05.26.19.32.21l10.86.04c.98-.16.97-1.51,0-1.68h-10.66c-.68.08-.98.94-.52,1.43ZM59.85,80.22c-1.05.35-.78,1.73.32,1.72,2.06-.13,4.32.17,6.36,0,1.2-.1,1.36-1.36.28-1.72h-6.95ZM59.9,84.1c-.99.22-.91,1.59.09,1.71,1.36-.09,3,.17,4.33,0,1.03-.12,1.12-1.45.13-1.71h-4.56Z"/>
    <polygon class="st4" points="78.38 77.63 71.91 85.91 70.25 84.64 76.7 76.39 78.38 77.63"/>
    <polygon class="st4" points="78.36 74.27 80 75.58 79.46 76.3 77.77 74.99 78.36 74.27"/>
    <polygon class="st4" points="70.57 87.08 69.22 87.59 69.4 86.14 70.57 87.08"/>
  </g>

  <g>
    <path class="st7" d="M347.25,139.38s.18.09.27.07c1.54,1.92,2.63,4.19,3.25,6.57h-8.68c.53-1.9,1.35-3.92,2.48-5.54.27-.39.6-.92,1.03-1.09.52.05,1.14-.06,1.65,0Z"/>
    <path class="st7" d="M341.01,153.05c.06-1.79.25-3.58.63-5.33h9.58c.39,1.75.58,3.54.63,5.33h-10.84Z"/>
    <path class="st7" d="M351.85,154.75c-.05,1.79-.25,3.58-.63,5.32h-9.58c-.38-1.75-.57-3.53-.63-5.32h10.84Z"/>
    <path class="st7" d="M350.77,161.79c-.62,2.38-1.71,4.65-3.25,6.57-.2.12-1.86.1-2.1,0-.33-.15-1.31-1.71-1.53-2.1-.77-1.37-1.4-2.94-1.81-4.46h8.68Z"/>
    <path class="st7" d="M359.62,147.72c.14.46.35.88.51,1.33.45,1.29.72,2.64.79,4h-7.38c-.03-1.79-.27-3.57-.57-5.33h6.64Z"/>
    <path class="st7" d="M339.87,147.72c-.29,1.77-.53,3.54-.57,5.33h-7.38c.14-1.84.52-3.71,1.39-5.33h6.56Z"/>
    <path class="st7" d="M339.3,154.75c.04,1.79.28,3.57.57,5.33h-6.56c-.87-1.63-1.26-3.5-1.39-5.33h7.38Z"/>
    <path class="st7" d="M360.93,154.75c-.07,1.36-.34,2.71-.79,4-.16.45-.38.88-.51,1.33h-6.64c.29-1.76.54-3.54.57-5.33h7.38Z"/>
    <path class="st7" d="M334.25,146.02c1.73-2.76,4.63-4.99,7.75-5.96.07-.02.97-.28.94-.2-.9,1.42-1.6,2.95-2.16,4.54-.19.53-.28,1.12-.54,1.62h-5.99Z"/>
    <path class="st7" d="M358.6,146.02h-5.99c-.27-.62-.42-1.31-.65-1.96-.52-1.47-1.2-2.89-2.04-4.2-.03-.1,1.03.23,1.11.25,2.67.86,5.05,2.6,6.8,4.77l.77,1.13Z"/>
    <path class="st7" d="M340.24,161.79c.1.03.46,1.4.54,1.62.55,1.59,1.25,3.12,2.16,4.54.03.09-.86-.17-.94-.2-3.12-.97-6.02-3.2-7.75-5.96h5.99Z"/>
    <path class="st7" d="M358.6,161.79l-.77,1.13c-1.75,2.17-4.14,3.91-6.8,4.77-.08.03-1.14.36-1.11.25.84-1.31,1.52-2.73,2.04-4.2.23-.65.38-1.34.65-1.96h5.99Z"/>
  </g>

  <path class="st5" d="M245.39,467.29h-.28c-1.92-1.88-3.74-3.95-5.27-6.16-2.78-4.01-5.1-8.82-2.24-13.49,3.37-5.51,11.35-5.74,15.04-.42,3.27,4.73.93,9.75-1.96,13.91-1.53,2.21-3.35,4.28-5.27,6.16ZM244.87,448.23c-3.19.28-4.82,4-2.91,6.57,1.79,2.41,5.57,2.1,6.95-.57,1.49-2.9-.8-6.29-4.04-6Z"/>

  <g>
    <path class="st8" d="M401.29,304.61v1.3c-.12.97-.33,1.96-.71,2.87-.12.29-.57,1.01-.59,1.24,0,.08.01.14.02.22.17.87.84,1.97.98,2.82.06.41-.17.68-.58.68l-3.47-.67c-.25.01-1.71.82-1.8.72,1.17-2.45,1.47-5.21.69-7.82-1.26-4.22-5.1-7.3-9.53-7.51,1.87-1.76,4.54-2.5,7.08-2.2,4.18.49,7.62,4.08,7.87,8.28l.04.08Z"/>
    <path class="st8" d="M384.93,299.96c8.05-.59,12.88,8.61,7.73,14.84-2.67,3.23-7.03,4.03-10.83,2.36-.44-.19-.49-.39-1.04-.33-1.02.11-2.26.59-3.25.65-.37.02-.62-.27-.58-.63.09-.79.82-2.02.98-2.86.01-.08.03-.14.02-.22-.02-.25-.58-1.2-.71-1.55-2.12-5.54,1.75-11.82,7.67-12.26ZM382.72,305.63c-.3.06-.54.34-.56.64.12,1.73-.16,3.68,0,5.39.09.95,1.37.92,1.49,0-.1-1.69.15-3.57,0-5.24-.04-.52-.38-.88-.93-.78ZM388.44,306.35c-.29.05-.54.32-.61.59.09,1.28-.13,2.73,0,3.99.09.89,1.36.92,1.49,0-.07-1.22.11-2.59,0-3.8-.04-.47-.37-.86-.88-.78ZM379.98,307.17c-.27.03-.6.28-.65.55-.08.38-.06,1.96-.01,2.39.08.81,1.21.93,1.44.14.11-.36.09-1.83.05-2.26-.04-.47-.31-.88-.83-.83ZM385.65,307.17c-.27.03-.6.28-.65.55-.08.38-.06,1.96-.01,2.39.08.85,1.29.92,1.47.07.08-.39.06-1.8.02-2.24s-.35-.83-.83-.78ZM391.18,307.79c-.23.05-.45.29-.49.51-.06.3-.06,1.27.07,1.52.31.59,1.21.43,1.36-.18.06-.23.06-.96.03-1.21-.07-.49-.49-.74-.97-.64Z"/>
  </g>
</svg>
SVG;

                        // 3) Mapa de replaces usando seus campos ACF já carregados
                        $svg_left = lilacs_svg_apply_tokens($svg_left_raw, [
                            'PAISES' => $esq_paises,
                            'IDIOMAS' => $esq_idi,
                            'REVISTAS' => $esq_rev,
                            'REGISTROS' => $esq_regs,
                            'TEXTOS_COMPLETOS' => $esq_txtc,
                        ]);

                        // 4) Echo final (onde você quer renderizar o SVG)
                        echo $svg_left;

                        ?>
                    </div>

                    <!-- Valores (opcional: úteis como fallback/acessibilidade) -->
                    <div class="lilacs-raiox__legend" aria-hidden="true">
                        <?php if ($esq_regs): ?><span
                                data-kpi="registros"><?php echo $esc($esq_regs); ?></span><?php endif; ?>
                        <?php if ($esq_txtc): ?><span
                                data-kpi="textos"><?php echo $esc($esq_txtc); ?></span><?php endif; ?>
                        <?php if ($esq_idi): ?><span
                                data-kpi="idiomas"><?php echo $esc($esq_idi); ?></span><?php endif; ?>
                        <?php if ($esq_paises): ?><span
                                data-kpi="paises"><?php echo $esc($esq_paises); ?></span><?php endif; ?>
                        <?php if ($esq_rev): ?><span
                                data-kpi="revistas"><?php echo $esc($esq_rev); ?></span><?php endif; ?>
                    </div>
                </div>

        
            </article>

            <!-- COL DIREITA -->
            <article class="lilacs-raiox__col lilacs-raiox__col--right">
                <div class="lilacs-raiox__chart">
                    <!-- RESERVA PARA SVG (colar aqui depois) -->
                    <div class="lilacs-raiox__svg-slot" aria-label="Gráfico LILACS Plus (SVG)">
                        <?php

                        $svg_right_raw = <<<'SVG'
<?xml version="1.0" encoding="UTF-8"?>
<svg id="Camada_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 404.07 467.29">
  <defs>
    <style>
      .lilacs-raiox__col--right .st0, .lilacs-raiox__col--right .st1 { font-size: 34.46px; }
      .lilacs-raiox__col--right .st0, .lilacs-raiox__col--right .st1, .lilacs-raiox__col--right .st2, .lilacs-raiox__col--right .st3 { fill: #fff; }
      .lilacs-raiox__col--right .st0, .lilacs-raiox__col--right .st2 { font-family: Pennypacker-Light, Pennypacker; font-weight: 300; }
      .lilacs-raiox__col--right .st1, .lilacs-raiox__col--right .st3 { font-family: Pennypacker-Book, Pennypacker; }
      .lilacs-raiox__col--right .st2, .st3 { font-size: 20.68px; }
      .lilacs-raiox__col--right .st4 { fill: #ffba9f; }
      .lilacs-raiox__col--right .st5 { fill: #6b2307; }
      .lilacs-raiox__col--right .st6 { fill: #bf4610; }
      .lilacs-raiox__col--right .st7 { fill: #fafffb; }
      .lilacs-raiox__col--right .st8 { fill: #edaa8c; }
      .lilacs-raiox__col--right .st9 { fill: #f96a1e; }
    </style>
  </defs>

  <g>
    <path class="st8" d="M172.3,438.81c-72.34,0-133.71-46.97-155.28-112.08l155.28-51.48v163.56Z"/>
    <path class="st4" d="M36.65,320.24c-4.69-14.14-7.23-29.26-7.23-44.97,0-48.43,24.1-91.22,60.95-117.07l81.93,117.07-135.65,44.97Z"/>
    <path class="st9" d="M351.76,334.78c-24.94,75.23-95.86,129.5-179.46,129.5v-189.04s179.46,59.53,179.46,59.53Z"/>
    <path class="st5" d="M14.39,49.73C59.08,18.4,113.5,0,172.22,0c58.89,0,113.45,18.5,158.21,50l-158.21,225.25L14.39,49.73Z"/>
    <path class="st6" d="M404.07,275.22c0,25.5-4.13,50.04-11.74,72.99l-220.02-72.99,133.22-189.66c59.6,41.94,98.55,111.25,98.55,189.66Z"/>
    <circle class="st7" cx="172.42" cy="275.25" r="38.38"/>
  </g>

  <g>
    <text class="st1" transform="translate(60.74 247.9)"><tspan x="0" y="0">{{IDIOMAS}}</tspan></text>
    <text class="st3" transform="translate(45.59 266.73)"><tspan x="0" y="0">idiomas</tspan></text>
  </g>

  <g>
    <text class="st1" transform="translate(82.29 360.78)"><tspan x="0" y="0">{{PAISES}}</tspan></text>
    <text class="st3" transform="translate(80.26 379.62)"><tspan x="0" y="0">países</tspan></text>
  </g>

  <g>
    <text class="st1" transform="translate(195.25 368.9)"><tspan x="0" y="0">{{REVISTAS}}</tspan></text>
    <text class="st2" transform="translate(214.16 388.65)"><tspan x="0" y="0">revistas</tspan></text>
  </g>

  <g>
    <text class="st0" transform="translate(129.3 88.61)">
      <tspan x="0" y="0">{{REGISTROS}}</tspan><tspan x="-20.14" y="32.37">milhões</tspan>
    </text>
    <text class="st2" transform="translate(125.95 150.37)"><tspan x="0" y="0">registros</tspan></text>
  </g>

  <g>
    <text class="st0" transform="translate(274.2 215.63)">
      <tspan x="0" y="0">{{TEXTOS_COMPLETOS}}</tspan><tspan x="-17.75" y="32.37">milhão</tspan>
    </text>
    <text class="st2" transform="translate(227.79 273.65)"><tspan x="0" y="0">textos completos</tspan></text>
  </g>

  <!-- resto do SVG (ícones/paths) -->
  <g>
    <path class="st9" d="M358.11,370.97c-.66-.16-1.2-.42-1.63-.96-1.26-1.57-.09-3.97,1.96-3.45.8.2,1.49,1.03,1.49,1.87v.77h12.75v1.77h-14.57Z"/>
    <path class="st9" d="M374.22,348.84v18.91h-12.89v-18.91h12.89ZM372.26,350.89h-9.1v8.73h9.1v-8.73ZM372.21,361.3h-9.01v1.45h9.01v-1.45ZM372.21,364.34h-9.01v1.4h9.01v-1.4Z"/>
    <path class="st9" d="M359.93,365.69s-.42-.24-.5-.27c-1.39-.65-2.9-.35-3.99.69v-16.88c0-.51.58-1.46.98-1.77,1.3-.99,3.5.04,3.5,1.63v16.6Z"/>
    <path class="st9" d="M370.86,352.29v3.73l-1.61-1.44c-.07,0-.97.7-1.15.76-.07.03-.11.03-.17-.01l-2.09-1.87-1.28.88v-2.05h6.3ZM368.17,352.97c-1.11,0-.76,1.8.29,1.34.73-.32.44-1.34-.29-1.34Z"/>
    <path class="st9" d="M370.86,358.22h-4.58l2.83-1.82c.6.46,1.13,1.01,1.71,1.51l.04.31Z"/>
    <polygon class="st9" points="364.55 357.62 364.55 356.03 365.74 355.29 366.75 356.19 364.55 357.62"/>
  </g>

  <g>
    <path class="st6" d="M327.14,91.89l-.1-.25.03-23.59.23-.1c4.64.04,9.3-.06,13.94.05l4.34,4.35.02,3.34-.23.37-6.85,8.72c-.18,1.27-.54,2.69-.62,3.96-.05.7.33,1.11,1.04,1.04l3.83-1.55c1-1.03,1.78-2.33,2.73-3.39.03-.03,0-.09.11-.06v6.85s-.14.25-.14.25h-18.33ZM330.01,72.69c-.46.49-.16,1.36.52,1.43h10.66c.97-.18.98-1.52,0-1.68l-10.86.04c-.07.02-.28.16-.32.21ZM330.01,77.76c.05.05.26.19.32.21l10.86.04c.98-.16.97-1.51,0-1.68h-10.66c-.68.08-.98.94-.52,1.43ZM330.45,80.22c-1.05.35-.78,1.73.32,1.72,2.06-.13,4.32.17,6.36,0,1.2-.1,1.36-1.36.28-1.72h-6.95ZM330.5,84.1c-.99.22-.91,1.59.09,1.71,1.36-.09,3,.17,4.33,0,1.03-.12,1.12-1.45.13-1.71h-4.56Z"/>
    <polygon class="st6" points="348.97 77.63 342.5 85.91 340.84 84.64 347.29 76.39 348.97 77.63"/>
    <polygon class="st6" points="348.95 74.27 350.59 75.58 350.05 76.3 348.37 74.99 348.95 74.27"/>
    <polygon class="st6" points="341.17 87.08 339.81 87.59 340 86.14 341.17 87.08"/>
  </g>

  <g>
    <path class="st5" d="M58.4,139.38s.18.09.27.07c1.54,1.92,2.63,4.19,3.25,6.57h-8.68c.53-1.9,1.35-3.92,2.48-5.54.27-.39.6-.92,1.03-1.09.52.05,1.14-.06,1.65,0Z"/>
    <path class="st5" d="M52.16,153.05c.06-1.79.25-3.58.63-5.33h9.58c.39,1.75.58,3.54.63,5.33h-10.84Z"/>
    <path class="st5" d="M63,154.75c-.05,1.79-.25,3.58-.63,5.32h-9.58c-.38-1.75-.57-3.53-.63-5.32h10.84Z"/>
    <path class="st5" d="M61.92,161.79c-.62,2.38-1.71,4.65-3.25,6.57-.2.12-1.86.1-2.1,0-.33-.15-1.31-1.71-1.53-2.1-.77-1.37-1.4-2.94-1.81-4.46h8.68Z"/>
    <path class="st5" d="M70.78,147.72c.14.46.35.88.51,1.33.45,1.29.72,2.64.79,4h-7.38c-.03-1.79-.27-3.57-.57-5.33h6.64Z"/>
    <path class="st5" d="M51.02,147.72c-.29,1.77-.53,3.54-.57,5.33h-7.38c.14-1.84.52-3.71,1.39-5.33h6.56Z"/>
    <path class="st5" d="M50.46,154.75c.04,1.79.28,3.57.57,5.33h-6.56c-.87-1.63-1.26-3.5-1.39-5.33h7.38Z"/>
    <path class="st5" d="M72.08,154.75c-.07,1.36-.34,2.71-.79,4-.16.45-.38.88-.51,1.33h-6.64c.29-1.76.54-3.54.57-5.33h7.38Z"/>
    <path class="st5" d="M45.41,146.02c1.73-2.76,4.63-4.99,7.75-5.96.07-.02.97-.28.94-.2-.9,1.42-1.6,2.95-2.16,4.54-.19.53-.28,1.12-.54,1.62h-5.99Z"/>
    <path class="st5" d="M69.76,146.02h-5.99c-.27-.62-.42-1.31-.65-1.96-.52-1.47-1.2-2.89-2.04-4.2-.03-.1,1.03.23,1.11.25,2.67.86,5.05,2.6,6.8,4.77l.77,1.13Z"/>
    <path class="st5" d="M51.39,161.79c.1.03.46,1.4.54,1.62.55,1.59,1.25,3.12,2.16,4.54.03.09-.86-.17-.94-.2-3.12-.97-6.02-3.2-7.75-5.96h5.99Z"/>
    <path class="st5" d="M69.76,161.79l-.77,1.13c-1.75,2.17-4.14,3.91-6.8,4.77-.08.03-1.14.36-1.11.25.84-1.31,1.52-2.73,2.04-4.2.23-.65.38-1.34.65-1.96h5.99Z"/>
  </g>

  <path class="st8" d="M156.67,467.29h-.28c-1.92-1.88-3.74-3.95-5.27-6.16-2.78-4.01-5.1-8.82-2.24-13.49,3.37-5.51,11.35-5.74,15.04-.42,3.27,4.73.93,9.75-1.96,13.91-1.53,2.21-3.35,4.28-5.27,6.16ZM156.15,448.23c-3.19.28-4.82,4-2.91,6.57,1.79,2.41,5.57,2.1,6.95-.57,1.49-2.9-.8-6.29-4.04-6Z"/>

  <g>
    <path class="st4" d="M24.61,304.61v1.3c-.12.97-.33,1.96-.71,2.87-.12.29-.57,1.01-.59,1.24,0,.08.01.14.02.22.17.87.84,1.97.98,2.82.06.41-.17.68-.58.68l-3.47-.67c-.25.01-1.71.82-1.8.72,1.17-2.45,1.47-5.21.69-7.82-1.26-4.22-5.1-7.3-9.53-7.51,1.87-1.76,4.54-2.5,7.08-2.2,4.18.49,7.62,4.08,7.87,8.28l.04.08Z"/>
    <path class="st4" d="M8.26,299.96c8.05-.59,12.88,8.61,7.73,14.84-2.67,3.23-7.03,4.03-10.83,2.36-.44-.19-.49-.39-1.04-.33-1.02.11-2.26.59-3.25.65-.37.02-.62-.27-.58-.63.09-.79.82-2.02.98-2.86.01-.08.03-.14.02-.22-.02-.25-.58-1.2-.71-1.55-2.12-5.54,1.75-11.82,7.67-12.26ZM6.04,305.63c-.3.06-.54.34-.56.64.12,1.73-.16,3.68,0,5.39.09.95,1.37.92,1.49,0-.1-1.69.15-3.57,0-5.24-.04-.52-.38-.88-.93-.78ZM11.76,306.35c-.29.05-.54.32-.61.59.09,1.28-.13,2.73,0,3.99.09.89,1.36.92,1.49,0-.07-1.22.11-2.59,0-3.8-.04-.47-.37-.86-.88-.78ZM3.3,307.17c-.27.03-.6.28-.65.55-.08.38-.06,1.96-.01,2.39.08.81,1.21.93,1.44.14.11-.36.09-1.83.05-2.26-.04-.47-.31-.88-.83-.83ZM8.98,307.17c-.27.03-.6.28-.65.55-.08.38-.06,1.96-.01,2.39.08.85,1.29.92,1.47.07.08-.39.06-1.8.02-2.24s-.35-.83-.83-.78ZM14.5,307.79c-.23.05-.45.29-.49.51-.06.3-.06,1.27.07,1.52.31.59,1.21.43,1.36-.18.06-.23.06-.96.03-1.21-.07-.49-.49-.74-.97-.64Z"/>
  </g>
</svg>
SVG;

                        // 2) aplica os replaces (use as variáveis ACF que você já tem pro “lado direito”)
                        $svg_right = lilacs_svg_apply_tokens($svg_right_raw, [
                            'PAISES' => $dir_paises,
                            'IDIOMAS' => $dir_idi,
                            'REVISTAS' => $dir_rev,
                            'REGISTROS' => $dir_regs,
                            'TEXTOS_COMPLETOS' => $dir_txtc,
                        ]);

                        // 3) echo final
                        echo $svg_right;
                        ?>
                    </div>

                    <!-- Valores (opcional: úteis como fallback/acessibilidade) -->
                    <div class="lilacs-raiox__legend" aria-hidden="true">
                        <?php if ($dir_regs): ?><span
                                data-kpi="registros"><?php echo $esc($dir_regs); ?></span><?php endif; ?>
                        <?php if ($dir_txtc): ?><span
                                data-kpi="textos"><?php echo $esc($dir_txtc); ?></span><?php endif; ?>
                        <?php if ($dir_idi): ?><span
                                data-kpi="idiomas"><?php echo $esc($dir_idi); ?></span><?php endif; ?>
                        <?php if ($dir_paises): ?><span
                                data-kpi="paises"><?php echo $esc($dir_paises); ?></span><?php endif; ?>
                        <?php if ($dir_rev): ?><span
                                data-kpi="revistas"><?php echo $esc($dir_rev); ?></span><?php endif; ?>
                    </div>
                </div>

            </article>

            

            <div class="lilacs-raio-x-footer-right">
                   <div class="lilacs-right-inner">
                        <div class="lilacs-raiox__foot lilacs-raiox__foot--right">
                            <div class="lilacs-raiox__big"><?php echo $esc($dir_num); ?> <small style="font-size: 16px;font-weight: 400;color:#6C2207;font-weight: 400;font-family: 'Noto Sans';">bases de dados</small></div>
                            <div class="lilacs-raiox__bigtitle"><?php echo $esc($dir_titpos); ?></div>
                            <div class="lilacs-raiox__desc"><?php echo nl2br($esc($dir_desc)); ?></div>
                        </div>
                        </div>
            </div>  

                        </div>
    </div>
       <div class="lilcas-raio-x-footer">





        </div>
</section>
<style>
    @font-face {
    font-family: 'Pennypacker-Light';
    src: url('/assets/fonts/Pennypacker_Light.otf') format('opentype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}
    /* =========================
   RAIO-X DA LILACS
   ========================= */
    .lilacs-raiox {
        position: relative;
        padding: 46px 0 34px;
        background: #F4F7F6;
        overflow: hidden;
  
        background-position: top right !important;
    background-repeat: no-repeat !important;
    }

    /* leve padrão geométrico ao fundo (sem dependência externa) */
    .lilacs-raiox::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(135deg, rgba(0, 0, 0, .03), transparent 60%),
            repeating-linear-gradient(0deg, rgba(255, 255, 255, .35), rgba(255, 255, 255, .35) 1px, transparent 1px, transparent 72px),
            repeating-linear-gradient(90deg, rgba(255, 255, 255, .35), rgba(255, 255, 255, .35) 1px, transparent 1px, transparent 72px);
        opacity: .35;
        pointer-events: none;
    }
    .lilacs-raiox__foot--left{
        width:50%;
        float:left;
    }

    .lilacs-raiox__inner {
        position: relative;
        width: 100% !important;
        margin: 0 auto;
    }

    .lilacs-raiox__title {
        text-align: center;
        font-size: clamp(34px, 2.6vw, 28px);
        line-height: 1.1;
        font-weight: 700;
        color: #0b2b4b;
        margin: 0 0 28px;
       font-family: "Poppins", sans-serif;
    }
.lilacs-raiox__grid{
display: grid;
    grid-template-columns: 15% 35% 35% 15%;
    align-items: start;
    align-items: end;
}




/* ajustar alinhamento/width internos pra não “estourar” */
.lilacs-left-inner,
.lilacs-right-inner{
  width: 100%;
  display: flex;
}

.lilacs-raiox__foot--left,
.lilacs-raiox__foot--right{
 
  float: none;
}

.lilacs-raio-x-footer-right .lilacs-right-inner{
    flex-direction: row-reverse;
}
    .lilacs-raiox__svg-slot::after {
        display: none;
    }

    /* remove o fixo */

    .lilacs-raiox__col {
        position: relative;
        min-height: 520px;
        display: grid;
        grid-template-rows: 1fr auto;
        align-items: end;
    }

    .lilacs-raiox__chart {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px 0 8px;
    }

    .lilacs-raiox__svg-slot {
        width: min(480px, 100%);
        aspect-ratio: 1 / 1;
        border-radius: 14px;
        position: relative;
    }
    .lilacs-left-inner{
            display: flex;
    text-align: right;
    width: 405px;
    }

   

    /* legenda (fica escondida por padrão; útil p/ SEO/a11y caso queira mostrar depois) */
    .lilacs-raiox__legend {
        display: none;
    }

    .lilacs-raiox__foot {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 10px 6px 0;
    }

    .lilacs-raiox__foot--left {
        align-items: flex-start;
    }

    .lilacs-raiox__foot--right {
        display: flex;
    max-width: 200px;
    width: 356px;
    text-align: left;   
    }

    .lilacs-raiox__big {
        font-size: clamp(36px, 3.2vw, 54px);
        line-height: 1;
        font-weight: 700;
        color: #0b2b4b;
        width:100%;
    }

   .lilacs-raiox__foot--left .lilacs-raiox__big{
        font-size: 45px;
    color: #00205C;
        font-family: "Noto Sans", sans-serif;
        font-weight:400;
    }


       .lilacs-raiox__foot--right .lilacs-raiox__big{
        font-size: 45px;
    color: #6C2207;
    font-family: "Noto Sans", sans-serif;
     font-weight:400;
    }

    .lilacs-raiox__bigtitle {
   font: 700 32px / 1.3 "Poppins";
    color: #00205C;
    border-bottom: 1px solid #00205C;
    width: 100%;
}

     .lilacs-raiox__foot--right   .lilacs-raiox__bigtitle {
   font: 700 32px / 1.3 "Poppins";
    color: #6C2207;
    border-bottom: 1px solid #6C2207;
    width: 100%;
}
   .lilacs-raiox__foot--right   .lilacs-raiox__big,   .lilacs-raiox__foot--right   .lilacs-raiox__desc{
    color: #6C2207;
}


    .lilacs-raiox__foot--left .lilacs-raiox__desc{
       margin: 0;
    font: 400 18px / 1.5 "Poppins";
    color: #3b4a5c;
}


    .lilacs-raiox__desc {
       margin: 0;
    font: 400 18px / 1.5 "Poppins";
    color: #3b4a5c;

    }

    /* responsivo */
    @media (max-width: 980px) {
        .lilacs-raiox__grid {
            grid-template-columns: 1fr;
        }

        .lilacs-raiox__col {
            min-height: unset;
        }

        .lilacs-raiox__foot--right {
            align-items: flex-start;
            text-align: left;
        }

        .lilacs-raiox__desc {
            max-width: 520px;
        }
    }
</style>