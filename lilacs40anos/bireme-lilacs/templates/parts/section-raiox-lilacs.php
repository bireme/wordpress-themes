<?php
// Lê as metas da aba RAIO-X (criada antes)
$pid = get_queried_object_id() ?: get_the_ID();
$rx  = function_exists('bireme_get_lilacs_rx_meta') ? bireme_get_lilacs_rx_meta($pid) : ['chart1'=>[],'chart2'=>[]];

// Paletas (iguais às do template)
$colorsBlue   = ['#8FBDD4','#7A9DB3','#3174A2','#085697','#00205C'];
$colorsOrange = ['#6c2207','#FFBC80','#FF9E4D','#085697','#B34F00'];

// Fallback se não houver nada no admin (mesmos números/ordem do HTML de referência)
if (empty($rx['chart1'])) {
  $rx['chart1'] = [
    ['label'=>'+1.130 milhão registros',   'value'=>10],
    ['label'=>'+707 mil textos completos', 'value'=>25],
    ['label'=>'+2600 revistas',            'value'=>15],
    ['label'=>'30 países',                 'value'=>20],
    ['label'=>'9 idiomas',                 'value'=>30],
  ];
}
if (empty($rx['chart2'])) {
  $rx['chart2'] = [
    ['label'=>'+2.800 milhões registros',   'value'=>30],
    ['label'=>'+1.500 milhão textos completos','value'=>20],
    ['label'=>'+21.000 revistas',           'value'=>25],
    ['label'=>'146 países',                 'value'=>15],
    ['label'=>'44 idiomas',                 'value'=>10],
  ];
}

// Converte para o formato esperado pelo JS (somente name/value; cores virão da paleta no JS)
$jsBlue   = array_map(fn($i)=> ['name'=>(string)$i['label'],'value'=>(float)$i['value'],'area'=>0,'label'=>['rotate'=>30]], $rx['chart1']);
$jsOrange = array_map(fn($i)=> ['name'=>(string)$i['label'],'value'=>(float)$i['value'],'area'=>0,'label'=>['rotate'=>30]], $rx['chart2']);
?>
<section id="raiox-lilacs" aria-label="Raio-X da LILACS">
    <div class="raiox-lilacs__overlay" aria-hidden="true">
    <style>
        /* ===== Layout geral ===== */
        #raiox-lilacs{
            position: relative;
            padding-top: 20px;
            background: #F3F4F6;
            padding-left: 0 !important;
            padding-right: 0 !important;
            background: url(https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/fundo_.jpg);
            background-size: cover;
            background-position: center;
        }
        #raiox-lilacs .raiox-lilacs__overlay{
            background-size: contain;
            background-position: center;
           animation: mover-fundo 40s linear infinite;
                }
                @keyframes mover-fundo { from{background-position:0 0} to{background-position:-1000px 0} }

        #raiox-lilacs .rx-title{
            max-width: 1380px;
            margin: 0 auto 12px;
            font: 800 28px / 1.2 "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: #082a53;
            letter-spacing: .2px;
            font-family: 'Noto Sans';
            font-size: 36px;
        }
        #raiox-lilacs .rx-wrap{
            max-width: 100%;
            margin: 0 auto;
            padding: 12px 0 8px;
            display: grid;
            grid-template-columns: 220px 1fr 1fr 220px;
            gap: 24px;
            align-items: end;
        }
    #chart-orange canvas, #chart-blue canvas{ margin-top: -31px !important; }
    /* quando usarmos imagens em vez de gráficos, garanta que não sejam rotacionadas */
    #chart-blue, #chart-orange { transform: none !important; }
    .rx-chart img { width: 100%; height: auto; display: block;max-width: 478px;}
        /* ===== Sidebars ===== */
        #raiox-lilacs .rx-side{ align-self: stretch; display:flex; flex-direction:column; justify-content:flex-end; padding-bottom:8px; }
        .rx-card{ padding-left:0; padding-right:0; border-radius:12px; text-align:right; }
        .rx-side.right .rx-card{ text-align:left !important; }
        #raiox-lilacs .rx-card h3{ margin:0 0 6px; font:700 32px/1.3 "Poppins"; color:#00205C; border-bottom:1px solid #00205C; }
        #raiox-lilacs .rx-card p{ margin:0; font:400 18px/1.5 "Poppins"; color:#3b4a5c; }
        #raiox-lilacs .rx-side.right .rx-card h3,#raiox-lilacs .rx-side.right .rx-card p{ color:#6C2207; }
        .rx-40-anos span{ font-size:45px; color:#00205C; }
        .rx-badge span{ font-size:45px; }
        .rx-40-anos{ color:#00205C; font-weight:400; }
        #raiox-lilacs .rx-badge{ margin-top:10px; font:400 18px/1 "Poppins"; color:#a3470a; padding:8px 0; display:inline-block; position:static; }

        /* ===== Gráficos ===== */
        #raiox-lilacs .rx-chart{     height: 650px;
    min-width: 600px;
    overflow: hidden;
    display: flex
;
    align-content: center;
    justify-content: center;
    align-items: center; }
        .registros{ top:7vw; left:28vw; position:absolute; z-index:999; color:#fff; font-family:'Noto Sans'; }
        .registros h4{ font-size:60px; line-height:1; font-weight:100; margin:0; margin-left:-30px; }
        .registros span{ font-size:22px; line-height:1; width:100%; display:flex; text-align:center; font-weight:100; }
        .textos_completos{ position:absolute; top:315px; left:425px; z-index:999; color:#fff; font-family:'Poppins'; font-weight:100; }
        .textos_completos h4{ margin:0; text-align:center; font-size:31px; font-weight:100; }
        .textos_completos span{ margin:0; text-align:center; font-size:16px; font-weight:100; }
        .idiomas{ position:absolute; left:646px; z-index:999; color:#fff; top:309px; font-family:'Poppins'; }
        .idiomas h4{ margin:0; text-align:center; font-size:60px; line-height:1; font-weight:100; }
        .paises{ position:absolute; top:426px; z-index:9999; left:627px; text-align:center; color:#fff; }
        .paises h4{ font-size:60px; line-height:1; margin:0; font-weight:100; color:#fff; }
        .revistas{ position:absolute; bottom:205px; left:438px; z-index:999; color:#fff; font-weight:100; text-align:center; }
        .revistas h4{ font-size:45px; font-weight:100; margin:0; line-height:1; }
        #chart-orange{ transform: rotate(328deg); }
        .registros_plus{ position:absolute; top:144px; color:#fff; right:506px; text-align:center; }
        .registros_plus h4{ font-size:60px; font-weight:100; margin:0; line-height:1; }
        .registros_plus span{ width:100%; display:block; font-size:22px; font-weight:100; }
        .textos_completos_plus{ position:absolute; right:417px; text-align:center; color:#fff; top:320px; }
        .textos_completos_plus h4{ font-size:41px; margin:0; line-height:1; font-weight:100; }
        .textos_completos_plus span{ width:100%; display:block; font-size:16px; font-weight:100; }
        .revistas_plus{ position:absolute; right:440px; color:#fff; text-align:center; font-weight:100; top:476px; z-index:9999; }
        .revistas_plus h4{ font-size:43px; margin:0; line-height:1; font-weight:100; }
        .paises_plus{ position:absolute; right:650px; bottom:259px; text-align:center; color:#fff; font-weight:100; }
        .paises_plus h4{ margin:0; line-height:1; font-size:40px; font-weight:100; }
        .idiomas_plus{ position:absolute; bottom:355px; right:650px; text-align:center; color:#fff; }
        .idiomas_plus h4{ margin:0; line-height:1; font-size:45px; font-weight:100; }
        @media (max-width:1200px){ #raiox-lilacs .rx-wrap{ grid-template-columns:200px 1fr 1fr 200px; } }
        @media (max-width:980px){
          #raiox-lilacs .rx-wrap{ grid-template-columns:1fr; gap:18px;        display: flex
; flex-direction: column; flex-direction: column;
        align-items: center;
        align-content: center;
        justify-content: center;}
          #raiox-lilacs .rx-side{order:1} #raiox-lilacs #chart-blue{order:2} #raiox-lilacs #chart-orange{order:3}
          #raiox-lilacs .rx-side.right{order:4} #raiox-lilacs .rx-chart{height:420px}
            .rx-chart img{max-width:315px;}
            #raiox-lilacs .rx-card h3,#raiox-lilacs .rx-card p,#raiox-lilacs .rx-badge,.rx-40-anos{
                padding-left:10px !important;
                padding-right:10px !important;
            }
            #raiox-lilacs .rx-title{
                text-align: center;
            }
       
            
        }
        @media (max-width:640px){ #raiox-lilacs .rx-chart{height:360px}   #raiox-lilacs .rx-chart{  min-width: auto; }  }
    </style>

    <h2 class="rx-title">Raio-X da LILACS</h2>

    <div class="rx-wrap">
        <!-- Coluna ESQUERDA (LILACS) -->
        <aside class="rx-side left" aria-label="Resumo LILACS">
            <div class="rx-card">
                <span class="rx-40-anos"><span>40</span> anos </span>
                <h3>LILACS</h3>
                <p>A ciência em saúde com identidade</br> latino-americana.</p>
            </div>
            <div class="blocos_texto_grafico" style="display:none;">
                <div class="registros"><h4>+1.130</h4><span>milhão</span><span>registros</span></div>
                <div class="textos_completos"><h4>+707 mil</h4><span>textos completos</span></div>
                <div class="idiomas"><h4>9</h4><span>Idiomas</span></div>
                <div class="paises"><h4>30</h4><span>países</span></div>
                <div class="revistas"><h4>+2.600</h4><span>Revistas</span></div>
            </div>
        </aside>

        <!-- Gráfico ESQUERDO (imagem LILACS) -->
        <div id="chart-blue" class="rx-chart" role="img" aria-label="Imagem LILACS (Azul)">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/lilacs.png' ); ?>" alt="LILACS" />
        </div>

        <!-- Gráfico DIREITO (imagem LILACS Plus) -->
        <div id="chart-orange" class="rx-chart" role="img" aria-label="Imagem LILACS Plus (Laranja)">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/lilacsplus.png' ); ?>" alt="LILACS Plus" />
        </div>

        <!-- Coluna DIREITA (LILACS Plus) -->
        <aside class="rx-side right" aria-label="Resumo LILACS Plus">
            <div class="rx-card">
                <span class="rx-badge"><span>34</span> bases de dados</span>
                <h3>LILACS Plus</h3>
                <p>A ciência latino-americana</br> no cenário global.</p>
                <div class="blocos_texto_grafico" style="display:none;" > 
                    <div class="registros_plus"><h4>+2.800</h4><span>milhões</span><span>registros</span></div>
                    <div class="textos_completos_plus"><h4>+1.500</h4><span>milhão</span><span>textos completos</span></div>
                    <div class="revistas_plus"><h4>+21.000</h4><span>revistas</span></div>
                    <div class="paises_plus"><h4>146</h4><span>países</span></div>
                    <div class="idiomas_plus"><h4>44</h4><span>idomas</span></div>
                </div>
            </div>
        </aside>
    </div>

    <!-- substituído: os gráficos foram trocados por imagens estáticas -->
    </div>
</section>
