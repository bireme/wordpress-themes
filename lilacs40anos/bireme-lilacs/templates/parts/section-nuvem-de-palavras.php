<style>
    /* ------------------------------------------------------------------- */
    /* CSS ISOLADO para a seção da Nuvem de Palavras - Evita quebra do site */
    /* ------------------------------------------------------------------- */

    /* Container Principal */
    .lilacs-wordcloud-wrapper .section-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .lilacs-wordcloud-wrapper .lilacs-section {
        padding: 60px 0; 
        background-color: #ffffff; /* Cor de fundo padrão */
    }

    .lilacs-wordcloud-wrapper .lilacs-section:nth-child(even) {
        background-color: #f8f9fa; /* Fundo alternado */
    }

    .lilacs-wordcloud-wrapper .section-header {
        margin-bottom: 40px;
    }

    /* Títulos e Descrições */
    .lilacs-wordcloud-wrapper .section-title {
        font-size: clamp(24px, 4vw, 36px);
        font-weight: 700;
        color: #003d7a; 
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .lilacs-wordcloud-wrapper .section-description {
        font-size: clamp(14px, 1.8vw, 16px);
        color: #4a5568;
        line-height: 1.6;
        max-width: 800px;
    }

    /* Estilos da Nuvem de Palavras */
    .lilacs-wordcloud-wrapper .cloud-container {
        background-color: white;
        padding: 60px 40px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 30px; 
        /* Propriedades para a Animação de Entrada */
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .lilacs-wordcloud-wrapper .word-cloud {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        align-items: center;
    }

    .lilacs-wordcloud-wrapper .word {
        padding: 8px 16px;
        background-color: #f0f0f0;
        color: #003d7a;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        white-space: nowrap; /* Impede quebras de linha em palavras */
    }

    .lilacs-wordcloud-wrapper .word:hover,
    .lilacs-wordcloud-wrapper .word.active {
        background-color: #003d7a;
        color: white;
        transform: scale(1.1);
        border-color: #003d7a;
    }

    /* Classes de Tamanho para as Palavras */
    .lilacs-wordcloud-wrapper .word.large {
        font-size: 1.3rem;
        font-weight: 700;
    }
    .lilacs-wordcloud-wrapper .word.medium {
        font-size: 1.1rem;
        font-weight: 600;
    }
    .lilacs-wordcloud-wrapper .word.small {
        font-size: 0.85rem;
        font-weight: 400;
    }

    /* Tooltip */
    .lilacs-wordcloud-wrapper .tooltip {
        position: absolute;
        background-color: #003d7a;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        pointer-events: none;
        z-index: 1000;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Mídia Queries */
    @media (max-width: 768px) {
        .lilacs-wordcloud-wrapper .lilacs-section {
            padding: 40px 0;
        }
        .lilacs-wordcloud-wrapper .cloud-container {
            padding: 40px 20px;
            min-height: 250px;
        }
    }
    @media (max-width: 480px) {
        .lilacs-wordcloud-wrapper .lilacs-section {
            padding: 30px 0;
        }
        .lilacs-wordcloud-wrapper .cloud-container {
            padding: 30px 15px;
            min-height: 200px;
        }
    }
</style>

<div class="lilacs-wordcloud-wrapper">
    <div class="container">
        <section class="lilacs-section" aria-label="Redes Nacionais e Temáticas da LILACS" data-cloud-id="wordCloud1">
            <div class="section-container">
                <div class="section-header">
                    <h2 class="section-title">Revistas Indexadas na LILACS</h2>
                    <p class="section-description">As revistas científicas indexadas na LILACS representam a diversidade e a relevância da produção em saúde da América Latina e Caribe.</p>
                </div>
                <div class="cloud-container">
                    <div class="word-cloud" id="wordCloud1">
                        </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    /* ------------------------------------------------------------- */
    /* JAVASCRIPT ISOLADO - Interage apenas com .lilacs-wordcloud-wrapper */
    /* ------------------------------------------------------------- */

    (function() {
        const wrapperSelector = '.lilacs-wordcloud-wrapper';
        const wrapper = document.querySelector(wrapperSelector);

        if (!wrapper) {
            console.warn("LILACS Word Cloud: Elemento wrapper não encontrado. Inicialização cancelada.");
            return;
        }

        // Dados de palavras para cada nuvem
        const cloudData = {
            wordCloud1: [
                { text: 'Redes Nacionais', frequency: 95 },
                { text: 'Redes Temáticas', frequency: 90 },
                { text: 'Comunidades de Prática', frequency: 88 },
                { text: 'Gestão da Informação', frequency: 85 },
                { text: 'Países', frequency: 82 },
                { text: 'Saúde', frequency: 80 },
                { text: 'Cooperação', frequency: 75 },
                { text: 'América Latina', frequency: 70 }
            ]
        };

        // Função para gerar uma única nuvem de palavras
        function generateWordCloud(cloudId, words) {
            const cloudContainer = document.getElementById(cloudId);
            if (!cloudContainer) return;

            cloudContainer.innerHTML = '';
            
            const frequencies = words.map(w => w.frequency);
            if (frequencies.length === 0) return;

            const minFreq = Math.min(...frequencies);
            const maxFreq = Math.max(...frequencies);
            const range = maxFreq - minFreq;
            
            const shuffledWords = [...words].sort(() => Math.random() - 0.5);
            
            shuffledWords.forEach(word => {
                let normalized = (range > 0) ? (word.frequency - minFreq) / range : 0.5;
                
                let sizeClass = 'small';
                if (normalized >= 0.66) {
                    sizeClass = 'large';
                } else if (normalized >= 0.33) {
                    sizeClass = 'medium';
                }
                
                const wordElement = document.createElement('span');
                wordElement.className = `word ${sizeClass}`;
                wordElement.textContent = word.text;
                wordElement.setAttribute('data-frequency', word.frequency);
                
                // Evento de clique
                wordElement.addEventListener('click', function() {
                    handleWordClick(this);
                });
                
                // Evento de hover para mostrar frequência
                wordElement.addEventListener('mouseenter', function() {
                    showTooltip(this, word.frequency);
                });
                
                cloudContainer.appendChild(wordElement);
            });
        }

        // Função para lidar com clique em palavra
        function handleWordClick(element) {
            // Remove classe ativa em todos os elementos da mesma nuvem
            element.closest('.word-cloud').querySelectorAll('.word').forEach(el => {
                el.classList.remove('active');
            });
            element.classList.add('active');
        }

        // Função para mostrar tooltip com frequência
        function showTooltip(element, frequency) {
            // Remove tooltips existentes APENAS DENTRO DO WRAPPER (ou globalmente se necessário)
            document.querySelectorAll('.tooltip').forEach(t => t.remove());

            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = `Frequência: ${frequency}`;
            
            // Adiciona o tooltip ao corpo do documento para posicionamento absoluto
            document.body.appendChild(tooltip); 
            
            // Posicionar tooltip
            const rect = element.getBoundingClientRect();
            const scrollY = window.scrollY || window.pageYOffset;
            
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = (rect.top + scrollY - tooltip.offsetHeight - 10) + 'px';
            
            // Remove tooltip no mouseleave do elemento
            element.addEventListener('mouseleave', function() {
                tooltip.remove();
            }, { once: true });
            
            // Remove tooltip no scroll (para melhor UX)
            let scrollHandler = () => tooltip.remove();
            window.addEventListener('scroll', scrollHandler, { once: true });
        }

        // Animação de entrada suave usando Intersection Observer
        function animateOnScroll() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null, // viewport
                threshold: 0.1
            });
            
            // Observar apenas os containers de nuvem de palavras DENTRO do wrapper
            wrapper.querySelectorAll('.cloud-container').forEach(element => {
                observer.observe(element);
            });
            
            // Se as seções lilacs-section também precisarem de animação
            wrapper.querySelectorAll('.lilacs-section').forEach(element => {
                observer.observe(element);
            });
        }

        // Inicializar todas as nuvens de palavras
        function initAllWordClouds() {
            for (const id in cloudData) {
                generateWordCloud(id, cloudData[id]);
            }
        }

        // Inicialização principal
        document.addEventListener('DOMContentLoaded', function() {
            initAllWordClouds();
            animateOnScroll();
        });

    })(); /* Função auto-executável para isolar variáveis globais */

</script>