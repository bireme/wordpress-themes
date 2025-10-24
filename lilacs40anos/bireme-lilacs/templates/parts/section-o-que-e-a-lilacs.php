<style>

/* Seção: O que é a LILACS */
.lilacs-intro {
    padding: 60px 0;
}

.lilacs-intro h1 {
    font-size: 2.5rem;
    color: #003d7a;
    margin-bottom: 30px;
    font-weight: 700;
}

.lilacs-intro p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 20px;
    text-align: justify;
    line-height: 1.8;
}

/* Seção: Características (Features) */
.features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin: 60px 0;
    padding: 40px 20px;
    border-radius: 8px;
}

.feature-card {
    background-color: #F1F1F1;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: left;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background-color: #003d7a;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
}

.feature-icon svg {
    width: 32px;
    height: 32px;
}

.feature-card h3 {
    font-size: 1.3rem;
    color: #003d7a;
    margin-bottom: 15px;
    font-weight: 600;
}

.feature-card p {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.6;
}

/* Seção: Revistas Indexadas */
.lilacs-wordcloud .container {
    max-width: 1200px;
    margin: 0 auto;
}
.indexed-journals {
    padding: 60px 0;
}

.indexed-journals h2 {
    font-size: 2rem;
    color: #003d7a;
    margin-bottom: 15px;
    font-weight: 700;
}

.indexed-journals > p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 40px;
    text-align: justify;
}

/* Word Cloud */
.cloud-container {
    background-color: white;
    padding: 60px 40px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.word-cloud {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
    align-items: center;
}

.word {
    padding: 8px 16px;
    background-color: #f0f0f0;
    color: #003d7a;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.word:hover {
    background-color: #003d7a;
    color: white;
    transform: scale(1.1);
    border-color: #003d7a;
}

.word.large {
    font-size: 1.3rem;
    font-weight: 700;
}

.word.medium {
    font-size: 1.1rem;
    font-weight: 600;
}

.word.small {
    font-size: 0.85rem;
    font-weight: 400;
}

/* Responsividade */
@media (max-width: 768px) {
    .lilacs-intro h1 {
        font-size: 2rem;
    }

    .indexed-journals h2 {
        font-size: 1.5rem;
    }

    .features {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 30px 15px;
    }

    .cloud-container {
        padding: 40px 20px;
        min-height: 250px;
    }

    .word-cloud {
        gap: 10px;
    }

    .word {
        padding: 6px 12px;
        font-size: 0.85rem;
    }

    .word.large {
        font-size: 1.1rem;
    }

    .word.medium {
        font-size: 0.95rem;
    }

    .word.small {
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 15px;
    }

    .lilacs-intro {
        padding: 40px 0;
    }

    .lilacs-intro h1 {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .lilacs-intro p {
        font-size: 0.95rem;
        margin-bottom: 15px;
    }

    .indexed-journals {
        padding: 40px 0;
    }

    .indexed-journals h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .indexed-journals > p {
        font-size: 0.9rem;
        margin-bottom: 30px;
    }

    .feature-card {
        padding: 20px;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
    }

    .feature-icon svg {
        width: 28px;
        height: 28px;
    }

    .feature-card h3 {
        font-size: 1.1rem;
    }

    .feature-card p {
        font-size: 0.9rem;
    }

    .cloud-container {
        padding: 30px 15px;
    }

    .word {
        padding: 5px 10px;
        font-size: 0.8rem;
    }
}
</style>
<?php
// --- Dynamic data: read metas for "O que é a LILACS" (fallback to previous static text) ---
$post_id = get_queried_object_id() ?: ( isset($post->ID) ? $post->ID : 0 );

$intro_title = $post_id ? get_post_meta( $post_id, '_lilacs_intro_title', true ) : '';
$intro_p1    = $post_id ? get_post_meta( $post_id, '_lilacs_intro_p1', true ) : '';
$intro_p2    = $post_id ? get_post_meta( $post_id, '_lilacs_intro_p2', true ) : '';
$intro_p3    = $post_id ? get_post_meta( $post_id, '_lilacs_intro_p3', true ) : '';

$features = [];
for ( $f = 1; $f <= 3; $f++ ) {
	$features[$f] = [
		'title' => $post_id ? get_post_meta( $post_id, "_lilacs_feature_{$f}_title", true ) : '',
		'text'  => $post_id ? get_post_meta( $post_id, "_lilacs_feature_{$f}_text", true ) : '',
	];
}

// defaults (keeps original copy if no meta provided)
$default_intro_title = 'O que é a LILACS';
$default_intro_p1 = 'A LILACS é a principal e mais abrangente base de dados especializada em saúde da América Latina e do Caribe. Reúne literatura científica e técnica de 30 países, com acesso livre e gratuito, incluindo artigos revisados por pares, teses, dissertações,documentos governamentais, anais e livros. São mais de um milhão de registros, sendo mais de 700 mil com link direto para o texto completo em acesso aberto. Mantida e atualizada por uma rede de mais de 900 instituições de ensino, pesquisa e governo em saúd, coordenada pela BIREME/OPAS/OMS.';
$default_intro_p2 = 'A metodologia LILACS utiliza o DeCS – Descritores em Ciências da Saúde, que contextualiza a produção científica e potencializa a recuperação da informação.';
$default_intro_p3 = 'Reconhecida pela Cochrane Collaboration como essencial para revisões sistemáticas baseadas na América Latina e no Caribe, a LILACS é fonte de informação regional do Global Index Medicus da OMS e complementa as buscas realizadas em MEDLINE/PubMed.';

if ( ! $intro_title ) $intro_title = $default_intro_title;
if ( ! $intro_p1 ) $intro_p1 = $default_intro_p1;
if ( ! $intro_p2 ) $intro_p2 = $default_intro_p2;
if ( ! $intro_p3 ) $intro_p3 = $default_intro_p3;

// features defaults (if meta not set)
$default_features = [
	1 => ['title'=>'Base cooperativa', 'text'=>'Com mais de 1,13 milhão de registros, 2.600 revistas e 9 idiomas representados.'],
	2 => ['title'=>'Rede colaborativa', 'text'=>'Mais de 30 países participam da Rede LILACS, integrando bibliotecas, editores e centros cooperantes.'],
	3 => ['title'=>'Ciência aberta e regional', 'text'=>'Promove a democratização do conhecimento científico e técnico em saúde com foco na equidade.'],
];
for ($f=1;$f<=3;$f++){
	if ( ! $features[$f]['title'] ) $features[$f]['title'] = $default_features[$f]['title'];
	if ( ! $features[$f]['text'] )  $features[$f]['text']  = $default_features[$f]['text'];
}

// wordcloud: read meta (CSV or newline); build words array with simple deterministic frequency
$wordcloud_raw = $post_id ? get_post_meta( $post_id, '_lilacs_wordcloud_words', true ) : '';
if ( $wordcloud_raw ) {
	// split by comma or newline
	$parts = preg_split('/[\r\n,]+/', $wordcloud_raw);
	$words_list = array_filter(array_map('trim', $parts));
} else {
	$words_list = [
		'Saúde','América Latina','Pesquisa','Ciência Aberta','Base de Dados',
		'Acesso Livre','Revistas','Conhecimento','Colaboração','Equidade',
		'Informação','Caribe','Indexação','Artigos','DeCS','MEDLINE','OMS','Cochrane','Dissertações','Teses'
	];
}
// normalize and build objects with frequency
$words_js = [];
$base = 60;
$idx = 0;
foreach( $words_list as $w ){
	if ( $w === '' ) continue;
	$freq = $base + ($idx % 10) * 3; // deterministic variability
	$words_js[] = ['text' => $w, 'frequency' => intval($freq)];
	$idx++;
}
$words_json = wp_json_encode( $words_js );

// --- NOVO: espaçamento entre sections (px) ---
$spacing_top    = $post_id ? intval( get_post_meta( $post_id, '_lilacs_section_spacing_top', true ) ) : 0;
$spacing_bottom = $post_id ? intval( get_post_meta( $post_id, '_lilacs_section_spacing_bottom', true ) ) : 0;
$section_style = '';
if ( $spacing_top || $spacing_bottom ) {
	$section_style = 'margin-top:' . $spacing_top . 'px; margin-bottom:' . $spacing_bottom . 'px;';
}

// --- NOVO: cor de fundo (O que é) ---
$bg_oque = $post_id ? get_post_meta( $post_id, '_lilacs_bg_oque', true ) : '';
if ( $bg_oque ) {
	$section_style .= ' background-color:' . esc_attr( $bg_oque ) . ';';
}
?>
<div class="lilacs-wordcloud">
    <div class="container">
        <!-- Seção: O que é a LILACS -->
        <section class="lilacs-intro" style="<?php echo esc_attr( $section_style ); ?>">
            <h1><?php echo esc_html( $intro_title ); ?></h1>
            <p><?php echo wp_kses_post( wpautop( $intro_p1 ) ); ?></p>
            <p><?php echo wp_kses_post( wpautop( $intro_p2 ) ); ?></p>
            <p><?php echo wp_kses_post( wpautop( $intro_p3 ) ); ?></p>
        </section>
        <!-- Seção: Características principais -->
        <section class="features" style="<?php echo esc_attr( $section_style ); ?>">
            <?php foreach ( $features as $feat ) : ?>
            <div class="feature-card">
                <div class="feature-icon">
                    <!-- kept original svg icon for consistency -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
                    </svg>
                </div>
                <h3><?php echo esc_html( $feat['title'] ); ?></h3>
                <p><?php echo wp_kses_post( wpautop( $feat['text'] ) ); ?></p>
            </div>
            <?php endforeach; ?>
        </section>
        <!-- Seção: Revistas Indexadas -->
        <section class="indexed-journals" style="<?php echo esc_attr( $section_style ); ?>">
            <h2>Revistas Indexadas na LILACS</h2>
            <p>As revistas científicas indexadas na LILACS representam a diversidade e a relevância da produção em saúde da América Latina e Caribe.</p>
            
            <div class="cloud-container">
                <div class="word-cloud" id="wordCloud">
                    <!-- Palavras serão geradas por JavaScript -->
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    // Dados de palavras para a nuvem de palavras (gerados pelo PHP)
const words = <?php echo $words_json; ?>;

// Função para gerar a nuvem de palavras
function generateWordCloud() {
    const cloudContainer = document.getElementById('wordCloud');
    
    // Limpar container
    cloudContainer.innerHTML = '';
    
    // Encontrar min e max de frequência
    const frequencies = words.map(w => w.frequency);
    const minFreq = Math.min(...frequencies);
    const maxFreq = Math.max(...frequencies);
    
    // Embaralhar palavras para melhor visualização
    const shuffledWords = [...words].sort(() => Math.random() - 0.5);
    
    // Criar elementos de palavras
    shuffledWords.forEach(word => {
        // Calcular tamanho relativo
        const normalized = (word.frequency - minFreq) / (maxFreq - minFreq);
        
        // Classificar em categorias de tamanho
        let sizeClass = 'small';
        if (normalized >= 0.66) {
            sizeClass = 'large';
        } else if (normalized >= 0.33) {
            sizeClass = 'medium';
        }
        
        // Criar elemento
        const wordElement = document.createElement('span');
        wordElement.className = `word ${sizeClass}`;
        wordElement.textContent = word.text;
        wordElement.setAttribute('data-frequency', word.frequency);
        
        // Adicionar evento de clique
        wordElement.addEventListener('click', function() {
            handleWordClick(word.text, this);
        });
        
        // Adicionar evento de hover para mostrar frequência
        wordElement.addEventListener('mouseenter', function() {
            showTooltip(this, word.frequency);
        });
        
        cloudContainer.appendChild(wordElement);
    });
}

// Função para lidar com clique em palavra
function handleWordClick(word, element) {
    // Remover classe ativa de outros elementos
    document.querySelectorAll('.word.active').forEach(el => {
        el.classList.remove('active');
    });
    
    // Adicionar classe ativa ao elemento clicado
    element.classList.add('active');
    
    // Mostrar mensagem (opcional)
    console.log(`Palavra selecionada: ${word}`);
}

// Função para mostrar tooltip com frequência
function showTooltip(element, frequency) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = `Frequência: ${frequency}`;
    tooltip.style.position = 'absolute';
    tooltip.style.backgroundColor = '#003d7a';
    tooltip.style.color = 'white';
    tooltip.style.padding = '5px 10px';
    tooltip.style.borderRadius = '4px';
    tooltip.style.fontSize = '0.8rem';
    tooltip.style.pointerEvents = 'none';
    tooltip.style.zIndex = '1000';
    tooltip.style.whiteSpace = 'nowrap';
    
    document.body.appendChild(tooltip);
    
    // Posicionar tooltip
    const rect = element.getBoundingClientRect();
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
    
    // Remover tooltip ao sair do elemento
    element.addEventListener('mouseleave', function() {
        tooltip.remove();
    }, { once: true });
}

// Animação de entrada suave
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
        threshold: 0.1
    });
    
    // Observar seções
    document.querySelectorAll('section').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
}

// Função para adicionar efeito de scroll suave
function smoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Função para adicionar interatividade aos cards de features
function initFeatureCards() {
    const cards = document.querySelectorAll('.feature-card');
    
    cards.forEach((card, index) => {
        // Adicionar delay de animação
        card.style.animationDelay = `${index * 0.1}s`;
        
        // Adicionar evento de clique
        card.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
}

// Função para responsividade
function handleResponsive() {
    const width = window.innerWidth;
    
    // Ajustar tamanhos de fonte em telas pequenas
    if (width < 480) {
        document.documentElement.style.fontSize = '14px';
    } else if (width < 768) {
        document.documentElement.style.fontSize = '15px';
    } else {
        document.documentElement.style.fontSize = '16px';
    }
}

// Inicializar ao carregar o DOM
document.addEventListener('DOMContentLoaded', function() {
    generateWordCloud();
    animateOnScroll();
    smoothScroll();
    initFeatureCards();
    handleResponsive();
});

// Regenerar nuvem de palavras ao redimensionar
window.addEventListener('resize', function() {
    handleResponsive();
});

// Adicionar evento para regenerar nuvem periodicamente (opcional)
setInterval(function() {
    // Descomente a linha abaixo para regenerar a nuvem a cada 30 segundos
    // generateWordCloud();
}, 30000);


</script>
