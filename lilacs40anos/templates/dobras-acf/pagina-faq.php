<?php
/**
 * Dobra: FAQ (Centro Cooperantes)
 * Slug esperado: pagina-faq
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Como é uma dobra do Flexible, usamos get_sub_field()
$perguntas_destaque = get_sub_field( 'escolha_as_perguntas_em_destaque' ) ?: [];
$categorias_lista   = get_sub_field( 'escolha_as_categorias_para_listar_as_perguntas' ) ?: [];
$tituloFaq          = get_sub_field( 'titulo_do_faq' );

// NOVOS CAMPOS – primeiro conteúdo
$primeiro_titulo    = get_sub_field( 'titulo_primeiro_conteudo' );
$primeiro_texto     = get_sub_field( 'descricao_primeiro_conteudo' );
$primeiro_imagem    = get_sub_field( 'imagem_primeiro_conteudo' );

// ID único para evitar conflitos
$faq_uid = 'lilacs-faq-' . get_the_ID() . '-' . get_row_index();
?>

<style>
/* ----------------------------- */
/* LAYOUT GERAL DA DOBRA         */
/* ----------------------------- */
#<?php echo esc_attr( $faq_uid ); ?> {
    max-width: 1180px;
    margin: 40px auto 60px;
    padding: 0 16px;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-toolbar-title {
    font-size: 30px;
    font-weight: 700;
    color: #0b2c68;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-wrapper {
    display: grid;
    grid-template-columns: 320px 18px minmax(0, 1fr); /* sidebar | handle | conteúdo */
    gap: 0;
    align-items: stretch;
}

/* Wrapper quando sidebar estiver recolhida */
#<?php echo esc_attr( $faq_uid ); ?> .faq-wrapper.is-collapsed {
    grid-template-columns: 0 18px minmax(0, 1fr);
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-wrapper.is-collapsed .faq-sidebar {
    opacity: 0;
    pointer-events: none;
}

/* ----------------------------- */
/* HANDLE ENTRE AS COLUNAS       */
/* ----------------------------- */

#<?php echo esc_attr( $faq_uid ); ?> .faq-collapse-col {
    display: flex;
    align-items: stretch;
    justify-content: flex-start;
    flex-direction: column;
}
.ewd-ufaq-faq-title-text, .ewd-ufaq-post-margin-symbol.ewd-ufaq-, .ewd-ufaq-faq-categories{
    display:none;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-collapse-toggle {
margin: 0 auto;
    align-self: center;
    height: 25px;
    width: 25px !important;
    border-radius: 999px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 17px;
    color: #111827;
    transition: background 0.15s 
ease, border-color 0.15s 
ease, transform 0.2s 
ease;
    z-index: 999;
    align-content: center;
    margin-left: -13px;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-wrapper.is-collapsed .faq-collapse-toggle {
    transform: rotate(180deg);
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-collapse-toggle:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
}

/* ----------------------------- */
/* SIDEBAR ESQUERDA              */
/* ----------------------------- */

#<?php echo esc_attr( $faq_uid ); ?> .faq-sidebar {
    border-right: 1px solid #e5e7eb;
    padding-right: 20px;
    padding-left: 0;
    max-height: 72vh;
    overflow-y: auto;
    transition: opacity 0.2s ease;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-search {
    position: relative;
    margin-bottom: 16px;
}

/* input com espaço para o ícone de lupa à direita */
#<?php echo esc_attr( $faq_uid ); ?> .faq-search input {
    width: 82%;
    padding: 9px 38px 9px 12px; /* mais espaço à direita para a lupa */
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    background: #F1F1F1;
}

/* ícone de lupa à direita */
#<?php echo esc_attr( $faq_uid ); ?> .faq-search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: #6b7280;
    pointer-events: none;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-block-title {
    font-size: 14px;
    font-weight: 700;
    letter-spacing: .02em;
    text-transform: uppercase;
    color: #4b5563;
    margin: 18px 0 8px;
}

/* Perguntas da lista */
#<?php echo esc_attr( $faq_uid ); ?> .faq-item {
    padding: 10px 10px;
    border-radius: 8px;
    background: #ffffff;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    border: 1px solid transparent;
    font-size: 14px;
    color: #111827;
    transition: background 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-item:hover {
    background: #f3f4ff;
    border-color: #d4d4ff;
    box-shadow: 0 1px 3px rgba(15,23,42,0.12);
}

/* Estado ativo – sem borda azul forte */
#<?php echo esc_attr( $faq_uid ); ?> .faq-item.is-active {
    background: #f9fafb;
    border-color: #cbd5e1;
    box-shadow: 0 1px 2px rgba(15,23,42,0.08);
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-item-label {
    flex: 1 1 auto;
    padding-right: 8px;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-star {
    color: #f59e0b;
    font-size: 16px;
}

/* ----------------------------- */
/* CATEGORIAS LISTADAS           */
/* ----------------------------- */

#<?php echo esc_attr( $faq_uid ); ?> .faq-category {
    margin-top: 12px;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-category-header {
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    color: #0A2C5C;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 10px;
    background: #fff;
    margin-bottom: 0;
    border-top: 1px solid #EFF2F6;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-category-header-title {
    flex: 1;
}

/* Chevron SVG */
#<?php echo esc_attr( $faq_uid ); ?> .faq-category-chevron {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-category-chevron.is-open {
    transform: rotate(180deg); /* abre para cima */
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-category-items {
    display: none;
    padding: 4px 0 8px 4px;
}

/* ----------------------------- */
/* ÁREA DE CONTEÚDO (DIREITA)    */
/* ----------------------------- */

#<?php echo esc_attr( $faq_uid ); ?> .faq-content-area {
    background: #ffffff;
    padding: 28px 32px 32px;
    min-height: auto;
    border-radius: 12px;
    overflow: auto;
}

/* CONTEÚDO INICIAL (primeiro conteúdo) */
#<?php echo esc_attr( $faq_uid ); ?> .faq-initial-content {
    display: flex;
    gap: 40px;
    align-items: center;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-initial-figure {
    flex: 0 0 40%;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-initial-figure img {
    max-width: 100%;
    height: auto;
    display: block;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-initial-text {
    flex: 1 1 auto;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-initial-title {
    font-size: 28px;
    font-weight: 700;
    color: #0b2c68;
    margin-bottom: 16px;
}

/* barra com data e link (abaixo do título, direita) */
#<?php echo esc_attr( $faq_uid ); ?> .faq-content-meta {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: -8px;
    margin-bottom: 16px;
    font-size: 13px;
    color: #6b7280;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-content-meta-right {
display: flex;
    gap: 12px;
    align-items: center;
    flex-direction: column;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-date {
    font-weight: 500;
}

#<?php echo esc_attr( $faq_uid ); ?> a.faq-single-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
}

#<?php echo esc_attr( $faq_uid ); ?> a.faq-single-link:hover {
    text-decoration: underline;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-content-area h1,
#<?php echo esc_attr( $faq_uid ); ?> .faq-content-area h2 {
    font-size: 24px;
    margin-bottom: 12px;
    color: #f97316;
}

#<?php echo esc_attr( $faq_uid ); ?> .faq-content-area p {
    font-size: 15px;
    line-height: 1.7;
}

/* Responsivo */
@media (max-width: 900px) {
    #<?php echo esc_attr( $faq_uid ); ?> .faq-wrapper,
    #<?php echo esc_attr( $faq_uid ); ?> .faq-wrapper.is-collapsed {
        grid-template-columns: minmax(0, 1fr);
    }

    #<?php echo esc_attr( $faq_uid ); ?> .faq-sidebar {
        max-height: none;
        border-right: none;
        padding-right: 0;
        margin-bottom: 20px;
    }

    #<?php echo esc_attr( $faq_uid ); ?> .faq-collapse-col {
        display: none;
    }

    #<?php echo esc_attr( $faq_uid ); ?> .faq-initial-content {
        flex-direction: column;
        gap: 24px;
    }

    #<?php echo esc_attr( $faq_uid ); ?> .faq-initial-figure {
        flex: 0 0 auto;
        width: 100%;
    }
}
</style>

<section id="<?php echo esc_attr( $faq_uid ); ?>" class="lilacs-faq">
    <div class="faq-toolbar">
        <div class="faq-toolbar-title">
            <?= $tituloFaq; ?>
        </div>
    </div>

    <div class="faq-wrapper">

        <!-- ========================= -->
        <!--        SIDEBAR ESQ        -->
        <!-- ========================= -->
        <aside class="faq-sidebar">

            <div class="faq-search">
                <input type="text" placeholder="<?php esc_attr_e( 'Pesquise no FAQ', 'rede-bvs' ); ?>" id="<?php echo esc_attr( $faq_uid ); ?>-search">
                <span class="faq-search-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"></circle>
                        <path d="M20 20L16.5 16.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </span>
            </div>

            <!-- ⭐ Perguntas em destaque -->
            <?php if ( $perguntas_destaque ) : ?>
                <?php foreach ( $perguntas_destaque as $row ) :
                    $post_obj = isset( $row['pergunta_destaque'] ) ? $row['pergunta_destaque'] : null;
                    if ( ! $post_obj ) {
                        continue;
                    }
                ?>
                    <div class="faq-item" data-id="<?php echo esc_attr( $post_obj->ID ); ?>">
                        <span class="faq-item-label"><?php echo esc_html( get_the_title( $post_obj ) ); ?></span>
                        <span class="faq-star">★</span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- ▼ Categorias -->
            <?php if ( $categorias_lista ) : ?>
                <?php foreach ( $categorias_lista as $cat_row ) :
                    $cat_id = isset( $cat_row['categoria'] ) ? (int) $cat_row['categoria'] : 0;
                    if ( ! $cat_id ) {
                        continue;
                    }

                    $cat = get_term( $cat_id, 'ufaq-category' );
                    if ( ! $cat || is_wp_error( $cat ) ) {
                        continue;
                    }

                    $perguntas_da_cat = get_posts( [
                        'post_type'      => 'ufaq',
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                        'tax_query'      => [
                            [
                                'taxonomy' => 'ufaq-category',
                                'field'    => 'term_id',
                                'terms'    => $cat_id,
                            ],
                        ],
                    ] );
                    if ( ! $perguntas_da_cat ) {
                        continue;
                    }
                ?>
                    <div class="faq-category">
                        <div class="faq-category-header">
                            <span class="faq-category-header-title"><?php echo esc_html( $cat->name ); ?></span>
                            <span class="faq-category-chevron" aria-hidden="true">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 10l4 4 4-4" stroke="#0b2144" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </div>

                        <div class="faq-category-items">
                            <?php foreach ( $perguntas_da_cat as $p ) : ?>
                                <div class="faq-item" data-id="<?php echo esc_attr( $p->ID ); ?>">
                                    <span class="faq-item-label"><?php echo esc_html( get_the_title( $p ) ); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </aside>

        <!-- ====== HANDLE ENTRE SIDEBAR E CONTEÚDO ====== -->
        <div class="faq-collapse-col">
            <button type="button" class="faq-collapse-toggle" aria-label="<?php esc_attr_e( 'Recolher / expandir menu', 'rede-bvs' ); ?>">
                ‹
            </button>
        </div>

        <!-- ========================= -->
        <!--     ÁREA DE CONTEÚDO      -->
        <!-- ========================= -->
        <section class="faq-content-area" id="<?php echo esc_attr( $faq_uid ); ?>-content">
            <?php if ( $primeiro_titulo || $primeiro_texto || $primeiro_imagem ) : ?>
                <div class="faq-initial-content">
                    <?php if ( $primeiro_imagem ) : ?>
                        <div class="faq-initial-figure">
                            <?php echo wp_kses_post( $primeiro_imagem ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="faq-initial-text">
                        <?php if ( $primeiro_titulo ) : ?>
                            <h2 class="faq-initial-title">
                                <?php echo esc_html( $primeiro_titulo ); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ( $primeiro_texto ) : ?>
                            <?php echo wp_kses_post( $primeiro_texto ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <p><?php esc_html_e( 'Selecione uma pergunta à esquerda para visualizar o conteúdo.', 'rede-bvs' ); ?></p>
            <?php endif; ?>
        </section>

    </div>
</section>

<script>
(function() {
    const wrapper      = document.querySelector('#<?php echo esc_js( $faq_uid ); ?> .faq-wrapper');
    const toggleBtn    = document.querySelector('#<?php echo esc_js( $faq_uid ); ?> .faq-collapse-toggle');
    const searchInput  = document.getElementById('<?php echo esc_js( $faq_uid ); ?>-search');
    const contentArea  = document.getElementById('<?php echo esc_js( $faq_uid ); ?>-content');
    const faqItems     = document.querySelectorAll('#<?php echo esc_js( $faq_uid ); ?> .faq-item');
    const catBlocks    = document.querySelectorAll('#<?php echo esc_js( $faq_uid ); ?> .faq-category');

    if (!wrapper) return;

    /* Collapse sidebar */
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            wrapper.classList.toggle('is-collapsed');
        });
    }

    /* Toggle de categorias (abrir/fechar manualmente) */
    document.querySelectorAll('#<?php echo esc_js( $faq_uid ); ?> .faq-category-header').forEach(function(header){
        header.addEventListener('click', function() {
            const box = header.nextElementSibling;
            const chevron = header.querySelector('.faq-category-chevron');
            const isVisible = box.style.display === 'block';

            box.style.display = isVisible ? 'none' : 'block';

            if (chevron) {
                if (!isVisible) {
                    chevron.classList.add('is-open');   // aberto = seta para cima
                } else {
                    chevron.classList.remove('is-open'); // fechado = seta para baixo
                }
            }
        });
    });

    /* Carregar pergunta na área de conteúdo */
    function loadFaq(postId, itemEl) {
        if (!postId) return;

        // remove active de todos
        faqItems.forEach(function(el){ el.classList.remove('is-active'); });
        if (itemEl) itemEl.classList.add('is-active');

        fetch('<?php echo esc_url( site_url( '/wp-json/wp/v2/ufaq/' ) ); ?>' + postId)
            .then(function(res){ return res.json(); })
            .then(function(data){
                if (!data || !data.content) return;

                // Formata data (dd/mm/aaaa)
                var formattedDate = '';
                if (data.date) {
                    var d = new Date(data.date);
                    if (!isNaN(d.getTime())) {
                        var day   = ('0' + d.getDate()).slice(-2);
                        var month = ('0' + (d.getMonth() + 1)).slice(-2);
                        var year  = d.getFullYear();
                        formattedDate = day + '/' + month + '/' + year;
                    }
                }

                contentArea.innerHTML = `
                    <h2>${data.title.rendered}</h2>
                    <div class="faq-content-meta">
                        <div class="faq-content-meta-right">
                            ${formattedDate ? `<span class="faq-date">${formattedDate}</span>` : ''}
                            <a href="${data.link}" class="faq-single-link" target="_blank" rel="noopener">
                                <?php echo esc_js( __( 'Ver pergunta completa', 'rede-bvs' ) ); ?>
                            </a>
                        </div>
                    </div>
                    ${data.content.rendered}
                `;

                // rola suavemente até a área de conteúdo
                contentArea.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // adiciona / atualiza o identificador da pergunta na URL (?faq=ID)
                try {
                    var url = new URL(window.location.href);
                    url.searchParams.set('faq', postId);
                    window.history.replaceState(null, '', url.toString());
                } catch (e) {
                    // fallback simples com hash, se URL() não estiver disponível
                    window.location.hash = 'faq-' + postId;
                }
            })
            .catch(function(){
                contentArea.innerHTML = '<p><?php echo esc_js( __( 'Não foi possível carregar esta pergunta no momento.', 'rede-bvs' ) ); ?></p>';
            });
    }

    faqItems.forEach(function(item){
        item.addEventListener('click', function(){
            const id = item.getAttribute('data-id');
            loadFaq(id, item);
        });
    });

    /* Filtro de busca na coluna esquerda
       - Aplica nas perguntas
       - Abre automaticamente as categorias com resultados
    */
    if (searchInput) {
        searchInput.addEventListener('input', function(){
            const term = this.value.toLowerCase().trim();

            // filtra perguntas em destaque e das categorias
            faqItems.forEach(function(item){
                const text = item.textContent.toLowerCase();
                const match = !term || text.indexOf(term) !== -1;
                item.style.display = match ? 'flex' : 'none';
            });

            // trata categorias (abrir se tiver resultados visíveis)
            catBlocks.forEach(function(cat){
                const header   = cat.querySelector('.faq-category-header');
                const itemsBox = cat.querySelector('.faq-category-items');
                const chevron  = header ? header.querySelector('.faq-category-chevron') : null;

                let hasVisible = false;
                cat.querySelectorAll('.faq-item').forEach(function(i){
                    if (i.style.display !== 'none') {
                        hasVisible = true;
                    }
                });

                if (term) {
                    cat.style.display = hasVisible ? '' : 'none';

                    if (itemsBox && chevron) {
                        if (hasVisible) {
                            itemsBox.style.display = 'block';
                            chevron.classList.add('is-open');
                        } else {
                            itemsBox.style.display = 'none';
                            chevron.classList.remove('is-open');
                        }
                    }
                } else {
                    // sem termo: mostra todas as categorias, volta para estado "fechado" padrão
                    cat.style.display = '';
                    if (itemsBox) itemsBox.style.display = 'none';
                    if (chevron) chevron.classList.remove('is-open');
                }
            });
        });
    }

    /* Abrir pergunta automaticamente via parâmetro de URL (?faq=ID) ou hash (#faq-ID) */
    (function initFromUrl() {
        var initialId = null;

        try {
            var url = new URL(window.location.href);
            var param = url.searchParams.get('faq');
            if (param) {
                initialId = param;
            }
        } catch (e) {
            // fallback se URL() não existir
        }

        if (!initialId && window.location.hash && window.location.hash.indexOf('#faq-') === 0) {
            initialId = window.location.hash.replace('#faq-', '');
        }

        if (!initialId) return;

        // encontra o item correspondente
        var itemEl = document.querySelector('#<?php echo esc_js( $faq_uid ); ?> .faq-item[data-id="' + initialId + '"]');
        if (!itemEl) return;

        // se estiver dentro de uma categoria colapsada, abre essa categoria
        var categoryItems = itemEl.closest('.faq-category-items');
        if (categoryItems && categoryItems.style.display !== 'block') {
            categoryItems.style.display = 'block';
            var header = categoryItems.previousElementSibling;
            if (header && header.classList.contains('faq-category-header')) {
                var chevron = header.querySelector('.faq-category-chevron');
                if (chevron) chevron.classList.add('is-open');
            }
        }

        // garante que o item fique visível na sidebar
        itemEl.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        loadFaq(initialId, itemEl);
    })();

})();
</script>
