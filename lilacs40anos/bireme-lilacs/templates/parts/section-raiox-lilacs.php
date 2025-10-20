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
             background: url(https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/1c0fe26d-1874-4f70-a5f2-c02dd2c26f8f-removebg-preview.png);
            background-size: contain;
            background-position: center;
           animation: mover-fundo 40s linear infinite; /* controla a velocidade e repetição */
                }

                /* Animação do movimento */
                @keyframes mover-fundo {
                    from {
                        background-position: 0 0;
                    }
                    to {
                        background-position: -1000px 0; /* ajusta o deslocamento conforme o padrão da imagem */
                    }
                }

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
            grid-template-columns: 220px 1fr 1fr 220px; /* esquerda | gráfico azul | gráfico laranja | direita */
            gap: 24px;
            align-items: end; /* tudo encosta no “chão” */
        }
        #chart-orange canvas, #chart-blue canvas{
            margin-top: -31px !important;
        }
        #chart-blue{
                transform: rotate(33deg);
        }
        /* ===== Sidebars ===== */
        #raiox-lilacs .rx-side{
            align-self: stretch;                /* ocupa a coluna toda */
            display: flex;
            flex-direction: column;
            justify-content: flex-end;     /* cola o box no chão */
            padding-bottom: 8px;                /* leve respiro do chão */
        }
        #raiox-lilacs .rx-side.left{

        }
        .rx-card{
            padding-left: 0;
            padding-right: 0;
            border-radius: 12px;
            text-align: right;
        }
        .rx-side.right .rx-card{
            text-align: left !important;
        }
        #raiox-lilacs .rx-card h3{
            margin: 0 0 6px;
            font: 700 32px / 1.3 "Poppins";
            color: #00205C;
            border-bottom: 1px solid #00205C;
        }
        #raiox-lilacs .rx-card p{
            margin:0;
            font: 400 18px/1.5 "Poppins";
            color:#3b4a5c;
        }
        #raiox-lilacs .rx-side.right .rx-card h3,#raiox-lilacs .rx-side.right .rx-card p {
            color:#6C2207;
        }
        .rx-40-anos span{
            font-size:45px;
            color:#00205C;
        }
        .rx-badge span{
            font-size:45px;
        }
        .rx-40-anos{
            color:#00205C;
            font-weight:400;
        }
        /* Badge simples (ex.: “34 bases de dados”) */
        #raiox-lilacs .rx-badge{
            margin-top: 10px;
                font: 400 18px / 1 "Poppins";
                color: #a3470a;
                padding: 8px 0px;
                display: inline-block;
                position: static;
        }

        /* ===== Gráficos ===== */
        #raiox-lilacs .rx-chart{
            height: 650px;          /* Aumente se quiser mais impacto */
            min-width: 600px;
            overflow:hidden;
        }

        /* ===== Responsivo ===== */
        @media (max-width: 1200px){
            #raiox-lilacs .rx-wrap{
                grid-template-columns: 200px 1fr 1fr 200px;
            }
        }
        @media (max-width: 980px){
            #raiox-lilacs .rx-wrap{
                grid-template-columns: 1fr; /* empilha tudo */
                gap: 18px;
            }
            #raiox-lilacs .rx-side{order:1}
            #raiox-lilacs #chart-blue{order:2}
            #raiox-lilacs #chart-orange{order:3}
            #raiox-lilacs .rx-side.right{order:4}
            #raiox-lilacs .rx-chart{height: 420px}
        }
        @media (max-width: 640px){
            #raiox-lilacs .rx-chart{height: 360px}
        }
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
        </aside>

        <!-- Gráfico ESQUERDO (tons de azul) -->
        <div id="chart-blue" class="rx-chart" role="img" aria-label="Gráfico LILACS (Azul)"></div>

        <!-- Gráfico DIREITO (tons de laranja) -->
        <div id="chart-orange" class="rx-chart" role="img" aria-label="Gráfico LILACS Plus (Laranja)"></div>

        <!-- Coluna DIREITA (LILACS Plus) -->
        <aside class="rx-side right" aria-label="Resumo LILACS Plus">
            <div class="rx-card">
                <span class="rx-badge"><span>34</span> bases de dados</span>
                <h3>LILACS Plus</h3>
                <p>A ciência latino-americana</br> no cenário global.</p>
                
            </div>
        </aside>
    </div>

    <!-- Se já existir o import do ECharts na página, pode remover esta linha -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
    <script>
        /* ===== Dados base (exemplo) ===== */
        const dataBlue = [
            { name: '9 idiomas', value: 10, area: 0, labelParts: ['9', 'idiomas'], label: { rotate: 40 } },
            { name: '30 países', value: 15, area: 0, labelParts: ['30', 'países'], label: { rotate: 0 } },
            { name: '+2600 revistas', value: 25, area: 0, labelParts: ['+2600', 'revistas'], label: { rotate: 6 } },
            { name: '+707 mil textos completos', value: 20, area: 0, labelParts: ['+707 mil', 'textos completos'], label: { rotate: 30 } },
            { name: '+1.130 milhão registros', value: 30, area: 0, labelParts: ['+1.130', 'milhão', 'registros'], label: { rotate: 33 } }
        ];
        const dataOrange = [
            { name: '+2.800 milhões registros', value: 220, area: 400, labelParts: ['+2.800 milhões', 'registros'], label: { rotate: -6 } },
            { name: '+1.500 milhão textos completos', value: 160, area: 2000, labelParts: ['+1.500 milhão', 'textos completos'], label: { rotate: 4 } },
            { name: '934 periódicos', value: 140, area: 600, labelParts: ['934', 'periódicos'], label: { rotate: 0 } },
            { name: '146 países', value: 130, area: 800, labelParts: ['146', 'países'], label: { rotate: 8 } },
            { name: '44 idiomas', value: 250, area: 1000, labelParts: ['44', 'idiomas'], label: { rotate: -10 } }
        ];

        // Paletas
        const colorsBlue   = ['#8FBDD4','#7A9DB3','#3174A2','#085697','#00205C'];
        const colorsOrange = ['#6c2207','#FFBC80','#FF9E4D','#085697','#B34F00'];

        // Quebra de linha inteligente nos rótulos
        function wrapText(text, maxCharsPerLine) {
            const words = text.split(' ');
            const lines = [];
            let line = '';
            for (const w of words) {
                if ((line + ' ' + w).trim().length <= maxCharsPerLine) {
                    line = (line ? line + ' ' : '') + w;
                } else {
                    if (line) lines.push(line);
                    line = w;
                }
            }
            if (line) lines.push(line);
            return lines.join('\n');
        }

        function createNightingaleChart(roseType, elId, palette, seriesData) {
            // base rich styles used for all labels
            const baseRich = {
                name: {
                    fontSize: 35,
                    fontWeight: 300,
                    lineHeight: 35,
                    color: '#fff',
                    align: 'left',
                    width: 120,
                    padding: [0,4,0,4]
                },
                last: {
                    fontSize: 24,
                    fontWeight: 300,
                    lineHeight: 20,
                    color: '#FFD966',
                    align: 'left',
                    width: 120,
                    padding: [2,0,0,0]
                },
                val: {
                    fontSize: 24,
                    fontWeight: 300,
                    lineHeight: 16,
                    color: '#fff',
                    align: 'center',
                    padding: [6,0,0,0],
                    width: 120
                }
            };

            // adiciona estilos "img{i}" para cada item que tenha img (pequena caixa à esquerda)
            seriesData.forEach((d, i) => {
                if (d.img) {
                    baseRich['img' + i] = {
                        // tamanho da imagem (ajuste conforme precisar)
                        width: 20,
                        height: 20,
                        // backgroundColor aceita { image: 'url' } no ECharts para desenhar a imagem
                        backgroundColor: { image: d.img },
                        // garante espaçamento entre imagem e texto
                        padding: [0, 6, 0, 0],
                        align: 'left'
                    };
                } else {
                    // fallback vazio (não ocupa espaço)
                    baseRich['img' + i] = { width: 0, height: 0, padding: 0 };
                }
            });

            const options = {
                backgroundColor: 'transparent',
                tooltip: {
                    trigger: 'item',
                    formatter: ({ name, value, percent }) => `${name}<br/>Valor: ${value} (${percent}%)`
                },
                series: [{
                    name: 'LILACS',
                    type: 'pie',
                    radius: ['8%', '92%'],
                    roseType,
                    minAngle: 3,
                    avoidLabelOverlap: true,
                    stillShowZeroSum: false,
                    itemStyle: {
                        borderRadius: 0,
                        borderWidth: 0,
                        shadowBlur: 18,
                        shadowColor: 'rgba(0,0,0,0.18)'
                    },
                    label: {
                        show: true,
                        position: 'inside',
                        formatter: (params) => {
                            const maxChars =
                                params.percent >= 30 ? 20 :
                                params.percent >= 18 ? 16 :
                                params.percent >= 12 ? 14 : 12;

                            // extrai até 3 partes (labelParts array é preferido)
                            const raw = (params.data && params.data.name) ? params.data.name : params.name;
                            let parts = ['', '', ''];

                            if (params.data && Array.isArray(params.data.labelParts)) {
                                for (let i = 0; i < 3; i++) {
                                    parts[i] = (params.data.labelParts[i] || '').trim();
                                }
                            } else if (raw.includes('||')) {
                                const sa = raw.split('||').map(s => s.trim());
                                for (let i = 0; i < 3; i++) parts[i] = sa[i] || '';
                            } else {
                                const words = raw.trim().split(/\s+/);
                                if (words.length <= 2) {
                                    parts[0] = words.join(' ');
                                } else if (words.length <= 4) {
                                    parts[0] = words.slice(0, words.length - 1).join(' ');
                                    parts[1] = words.slice(-1).join(' ');
                                } else {
                                    const third = words.pop();
                                    const first = words.shift();
                                    parts[0] = first + (words.length ? ' ' + words.slice(0, Math.ceil(words.length/2)).join(' ') : '');
                                    parts[1] = words.length ? words.slice(0).join(' ') : '';
                                    parts[2] = third;
                                }
                            }

                            const firstWrapped  = parts[0] ? wrapText(parts[0], maxChars) : '';
                            const secondWrapped = parts[1] ? wrapText(parts[1], Math.max(8, Math.floor(maxChars*0.9))) : '';
                            const thirdText     = parts[2] || '';

                            const imgToken = `{img${params.dataIndex}|}`;
                            const lines = [];

                            if (firstWrapped) {
                                lines.push(`${imgToken}{name|${firstWrapped}}`);
                            }
                            if (secondWrapped) {
                                lines.push(`{second|${secondWrapped}}`);
                            } else if (!firstWrapped && parts[1]) {
                                lines.push(`${imgToken}{second|${parts[1]}}`);
                            }
                            if (thirdText) lines.push(`{third|${thirdText}}`);

                            // removido: linha com o valor numérico
                            return lines.join('\n');
                        },
                        rich: Object.assign({}, baseRich, {
                            second: {
                                fontSize: 22,
                                fontWeight: 300,
                                lineHeight: 22,
                                color: '#FFD966',
                                align: 'center',
                                width: 140,
                                padding: [2,4,0,4]
                            },
                            third: {
                                fontSize: 22,
                                fontWeight: 300,
                                lineHeight: 22,
                                color: '#FFFFFF',
                                align: 'center',
                                width: 140,
                                padding: [0,4,0,4]
                            }
                        })
                    },
                    labelLine: { show: false },
                    labelLayout: () => ({ moveOverlap: 'shiftY' }),
                    data: seriesData.map((item, i) => ({
                        ...item,
                        itemStyle: { color: palette[i % palette.length] },
                        label: { ...(item.label || {}) }
                    }))
                }]
            };

            const chart = echarts.init(document.getElementById(elId));
            chart.setOption(options);
            window.addEventListener('resize', () => chart.resize());
        }

        // Renderiza
        createNightingaleChart('area',   'chart-blue',   colorsBlue,   dataBlue);
        createNightingaleChart('radius', 'chart-orange', colorsOrange, dataOrange);
    </script>
    </div>
</section>
