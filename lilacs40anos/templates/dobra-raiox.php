<section class="raioX">
        <div class="container">
            <div class="chart">
                <canvas id="doughnut" width="300" height="300"></canvas>
            </div>
            <div class="chart">
                <canvas id="doughnutPro" width="300" height="300"></canvas>
            </div>
        </div>
        <div class="conteudo">
            <div class="raioX-title">
                <h2>Raio-X da Lilacs</h2>
            </div>
            <div class="raioX-info">
                <div class="info normal">
                    <h2>LILACS</h2>
                    <p>A ciência em saúde com identidade latino-americana.</p>
                </div>
                <h2 class="centro"><strong>40</strong> anos</h2>
                <div class="info pro">
                    <h2>LILACS Plus</h2>
                    <p>A ciência latino-americana no cenário global.</p>
                </div>
            </div>
        </div>
    </section>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .raioX {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            background: transparent;
        }

        .container {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
        }

        .chart {
            display: flex;
            justify-content: center;
            min-width: 55%;
            height: 400px;
        }

        .conteudo {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            height: 80vh;
            padding: 50px 80px;
        }

        .raioX-title {
            font-size: 24px;
            color: #011d5a;
        }

        .raioX-info {
            display: flex;
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
            align-items: center;
        }

        .raioX-info .centro {
            font-size: 30px;
            font-weight: 300;
            color: #011d5a;
        }

        .info {
            width: 150px;

        }

        .info h2 {
            font-size: 24px;
            font-weight: 600;            
        }

        .info p {
            font-size: 16px;
            font-weight: 500;
        }

        .info.normal {
            color: #011d5a;
            gap: 10px 10px;
            text-align: right;
        }

        .info.pro {
            color: #6c2207;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const optionsBase = {
            responsive: true,
            plugins: {
                legend: {
                    display: false, // sem legenda (opcional)
                },
                tooltip: {
                    enabled: true // mantém os tooltips
                }
            },
            layout: {
                padding: 0
            },
            elements: {
                arc: {
                    borderWidth: 0, // sem borda nas fatias
                }
            },
            scales: {
                x: { display: false }, // remove eixo X
                y: { display: false }  // remove eixo Y
            }
        };

        // === Gráfico 1 ===
        new Chart(document.getElementById('doughnut'), {
            type: 'doughnut',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
                datasets: [{
                    data: [1, 2, 4, 7, 10],
                    backgroundColor: [
                        '#8fbdd4',
                        '#799db3',
                        '#3073a0',
                        '#085696',
                        '#00205b'
                    ]
                }]
            },
            options: optionsBase
        });

        // === Gráfico 2 ===
        new Chart(document.getElementById('doughnutPro'), {
            type: 'doughnut',
            data: {
                labels: ['Registros', 'Textos Completos', 'Revistas', 'Países', 'Idiomas'],
                datasets: [{
                    data: [10, 7, 4, 2, 1],
                    backgroundColor: [
                        '#6c2207',
                        '#bf4611',
                        '#f96a1e',
                        '#edaa8d',
                        '#ffbaa0'
                    ]
                }]
            },
            options: optionsBase
        });
    </script>