<?php 
if (!defined('ABSPATH')) exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
    <style>
/* ---------------------------------- */
/* HEADER MOBILE / OFFCANVAS          */
/* ---------------------------------- */

/* Botão hambúrguer (esconde no desktop por padrão) */
.bvs-mobile-toggle {
    display: none;
    align-items: center;
    gap: 6px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    padding: 6px 10px;
    border-radius: 999px;
    cursor: pointer;
    font-size: 13px;
    color: #003366;
}

.bvs-mobile-toggle-bar {
    width: 16px;
    height: 2px;
    border-radius: 999px;
    background: #003366;
    display: block;
}

.bvs-mobile-toggle-label {
    margin-left: 2px;
}

/* Container offcanvas + overlay */
.bvs-mobile-offcanvas {
    position: fixed;
    inset: 0;
    z-index: 9999;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.bvs-mobile-offcanvas::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    opacity: 0;
    transition: opacity 0.25s ease;
}

.bvs-mobile-offcanvas-panel {
    position: absolute;
    top: 0;
    right: 0;
    width: 82%;
    max-width: 320px;
    height: 100%;
    background: #ffffff;
    box-shadow: -4px 0 16px rgba(15, 23, 42, 0.25);
    transform: translateX(100%);
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
}

/* Estado aberto */
.bvs-mobile-offcanvas.is-open {
    pointer-events: auto;
    opacity: 1;
}

.bvs-mobile-offcanvas.is-open::before {
    opacity: 1;
}

.bvs-mobile-offcanvas.is-open .bvs-mobile-offcanvas-panel {
    transform: translateX(0);
}

.bvs-mobile-offcanvas-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid #e5e7eb;
}

.bvs-mobile-offcanvas-title {
    font-size: 15px;
    font-weight: 600;
    color: #003366;
}

.bvs-mobile-close {
    border: none;
    background: transparent;
    font-size: 24px;
    line-height: 1;
    cursor: pointer;
    color: #111827;
}

.bvs-mobile-offcanvas-body {
    padding: 12px 16px 24px;
    overflow-y: auto;
}

/* Idiomas mobile */
.bvs-lang-switcher--mobile {
    display: none;
    margin-bottom: 16px;
}

/* Menu mobile */
.bvs-mobile-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.bvs-mobile-menu > li > a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e5e7eb;
    text-decoration: none;
    font-size: 16px;
    color: #003366;
    font-weight: 500;
}

.bvs-mobile-menu > li:last-child > a {
    border-bottom: none;
}

/* Botão de toggle de submenu */
.bvs-submenu-toggle {
    border: none;
    background: transparent;
    margin-left: 8px;
    width: 32px;
    height: 32px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.bvs-submenu-toggle-icon {
    position: relative;
    width: 14px;
    height: 14px;
}

.bvs-submenu-toggle-icon::before,
.bvs-submenu-toggle-icon::after {
    content: "";
    position: absolute;
    background: #003366;
    border-radius: 999px;
}

.bvs-submenu-toggle-icon::before {
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    transform: translateY(-50%);
}

.bvs-submenu-toggle-icon::after {
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    transform: translateX(-50%);
}

/* Quando aberto, vira apenas "-" */
.bvs-mobile-menu li.is-open > .bvs-submenu-toggle .bvs-submenu-toggle-icon::after {
    display: none;
}

/* Submenu em lista recolhível */
.bvs-mobile-menu li.menu-item-has-children > ul.sub-menu {
    list-style: none;
    margin: 0 0 6px;
    padding: 0 0 6px 12px;
    max-height: 0;
    overflow: hidden;
    border-left: 1px solid #e5e7eb;
    transition: max-height 0.25s ease;
}

.bvs-mobile-menu li.menu-item-has-children.is-open > ul.sub-menu {
    max-height: 500px; /* suficiente para alguns níveis */
}

.bvs-mobile-menu li.menu-item-has-children > ul.sub-menu > li > a {
    display: block;
    padding: 6px 0;
    font-size: 14px;
    color: #1e293b;
    border-bottom: none;
}

/* Bloqueia scroll do body quando menu está aberto */
.bvs-mobile-menu-open {
    overflow: hidden;
}

/* ---------------------------------- */
/* AJUSTES GERAIS PARA MOBILE         */
/* ---------------------------------- */

@media (max-width: 768px) {

    .bvs-topbar-inner {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    /* Header em linha: logo + título + botão */
    .bvs-header-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .bvs-brand {
        gap: 10px;
    }

    .bvs-brand-logo img {
        height: 64px;
        max-height: none;
    }

    .bvs-brand-title {
        font-size: 16px;
    }

    /* Esconde idiomas desktop e mostra mobile */
    .bvs-lang-switcher--desktop {
        display: none;
    }

    .bvs-lang-switcher--mobile {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .bvs-mobile-toggle {
        display: flex;
    }

    /* Esconde menu desktop no mobile */
    .bvs-main-nav {
        display: none;
    }

    /* Conteúdos não relacionados ao header continuam como estavam */
    .home-sobre-inner {
        flex-direction: column;
    }
}

/* ---------------------------------- */
/* DESKTOP – SUBMENU DROPDOWN         */
/* ---------------------------------- */

/* Apenas garante que os itens tenham contexto para o dropdown */
.bvs-main-menu > li {
    position: relative;
}

/* Setinha nos itens que têm filhos */
.bvs-main-menu > li.menu-item-has-children > a {
    position: relative;
    padding-right: 18px; /* espaço pra seta */
}

.bvs-main-menu > li.menu-item-has-children > a::after {
    content: "";
    position: absolute;
    right: 0;
    top: 50%;
    width: 7px;
    height: 7px;
    border-right: 2px solid #003366;
    border-bottom: 2px solid #003366;
    transform: translateY(-60%) rotate(45deg);
    transition: transform 0.2s ease, border-color 0.2s ease;
}

/* Seta dá uma "abaixadinha" no hover */
.bvs-main-menu > li.menu-item-has-children:hover > a::after,
.bvs-main-menu > li.menu-item-has-children:focus-within > a::after {
    transform: translateY(-30%) rotate(45deg);
    border-color: #0050a0;
}

/* Submenu base (dropdown) */
.bvs-main-menu .sub-menu {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translate(-50%, 10px);
    min-width: 220px;
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
    padding: 8px 0;
    list-style: none;
    margin: 0;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s ease;
    z-index: 20;
}

/* Exibe submenu ao passar mouse no pai (UX clássico de navbar) */
.bvs-main-menu > li:hover > .sub-menu,
.bvs-main-menu > li:focus-within > .sub-menu {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate(-50%, 4px);
}

/* Itens internos do submenu */
.bvs-main-menu .sub-menu > li > a {
    display: block;
    padding: 8px 14px;
    font-size: 14px;
    color: #1f2937;
    text-decoration: none;
    white-space: nowrap;
}

.bvs-main-menu .sub-menu > li > a:hover,
.bvs-main-menu .sub-menu > li.current-menu-item > a,
.bvs-main-menu .sub-menu > li.current_page_item > a {
    background: #f1f5f9;
    color: #003366;
}

/* Submenu de segundo nível (cascata para a direita) */
.bvs-main-menu .sub-menu li.menu-item-has-children {
    position: relative;
}

.bvs-main-menu .sub-menu li.menu-item-has-children > a {
    padding-right: 20px;
}

.bvs-main-menu .sub-menu li.menu-item-has-children > a::after {
    content: "";
    position: absolute;
    right: 10px;
    top: 50%;
    width: 6px;
    height: 6px;
    border-top: 2px solid #64748b;
    border-right: 2px solid #64748b;
    transform: translateY(-50%) rotate(45deg);
}

/* Submenu de segundo nível abre lateralmente */
.bvs-main-menu .sub-menu .sub-menu {
    top: 0;
    left: 100%;
    transform: translate(8px, 0);
}

/* Exibe submenu de segundo nível */
.bvs-main-menu .sub-menu li.menu-item-has-children:hover > .sub-menu,
.bvs-main-menu .sub-menu li.menu-item-has-children:focus-within > .sub-menu {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

/* Garante que esses estilos só atuem no desktop */
@media (max-width: 768px) {
    .bvs-main-menu .sub-menu {
        opacity: 1;
        visibility: visible;
        position: static;
        transform: none;
        box-shadow: none;
        border: none;
        padding: 0;
    }
}
    </style>

<header id="topo-site" class="bvs-site-header">

    <!-- BARRA SUPERIOR -->
    <div class="bvs-topbar">
        <div class="bvs-topbar-inner">

            <ul class="bvs-skip-links">
                <li><a href="#conteudo-principal">Conteúdo Principal</a></li>
                <li><a href="#menu-principal">Menu</a></li>
                <li><a href="#busca">Pesquisa</a></li>
                <li><a href="#rodape">Rodapé</a></li>
            </ul>

            <div class="bvs-accessibility">
                <span>A-</span>
                <span>A</span>
                <span>A+</span>
                <span>|</span>
                <span>Alto Contraste</span>
            </div>

        </div>
    </div>

    <!-- HEADER PRINCIPAL -->
    <div class="bvs-header-main">
        <div class="bvs-header-inner">

            <!-- LOGO + TÍTULO -->
            <div class="bvs-brand">
                <div class="bvs-brand-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img 
                            src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo-bvs-pt.png' ); ?>"
                            alt="<?php esc_attr_e('Portal da Rede BVS', 'rede-bvs'); ?>"
                        >
                    </a>
                </div>

                <div class="bvs-brand-title">
                    Portal da Rede BVS
                </div>
            </div>

            <!-- IDIOMAS – VERSÃO DESKTOP -->
            <div class="bvs-lang-switcher bvs-lang-switcher--desktop">
                <button type="button" class="bvs-lang is-active">Português</button>
                <a href="#" class="bvs-lang">English</a>
                <a href="#" class="bvs-lang">Español</a>
            </div>

            <!-- BOTÃO MOBILE (HAMBÚRGUER) -->
            <button 
                class="bvs-mobile-toggle" 
                type="button" 
                aria-label="Abrir menu"
                aria-controls="bvs-mobile-nav"
                aria-expanded="false"
            >
                <span class="bvs-mobile-toggle-bar"></span>
                <span class="bvs-mobile-toggle-bar"></span>
                <span class="bvs-mobile-toggle-bar"></span>
                <span class="bvs-mobile-toggle-label">Menu</span>
            </button>

        </div>

        <!-- MENU DESKTOP (INALTERADO) -->
        <nav class="bvs-main-nav" id="menu-principal">
            
            <?php
    // Define o location do menu conforme o idioma atual do Polylang
    $menu_location = 'primary'; // padrão (português)

    if ( function_exists( 'pll_current_language' ) ) {
        $lang = pll_current_language( 'slug' ); // ex: 'pt', 'en', 'es'

        if ( $lang === 'en' ) {
            $menu_location = 'primary_en';
        } elseif ( $lang === 'es' ) {
            $menu_location = 'primary_es';
        } else {
            $menu_location = 'primary'; // pt / default
        }
    }
?>


            <?php
wp_nav_menu([
    'theme_location' => $menu_location,
    'container'      => false,
    'menu_class'     => 'bvs-main-menu',
    'fallback_cb'    => false,
]);

            ?>
        </nav>

    </div>

    <!-- MENU MOBILE OFFCANVAS -->
    <div 
        class="bvs-mobile-offcanvas" 
        id="bvs-mobile-nav" 
        aria-hidden="true"
    >
        <div class="bvs-mobile-offcanvas-panel">

            <div class="bvs-mobile-offcanvas-header">
                <span class="bvs-mobile-offcanvas-title">Menu</span>
                <button 
                    type="button" 
                    class="bvs-mobile-close" 
                    aria-label="Fechar menu"
                >
                    &times;
                </button>
            </div>

            <div class="bvs-mobile-offcanvas-body">

                <!-- IDIOMAS – VERSÃO MOBILE -->
                <div class="bvs-lang-switcher bvs-lang-switcher--mobile">
                    <button type="button" class="bvs-lang is-active">Português</button>
                    <a href="#" class="bvs-lang">English</a>
                    <a href="#" class="bvs-lang">Español</a>
                </div>

                <nav class="bvs-mobile-menu-wrap" aria-label="Menu principal">
                    <?php
          wp_nav_menu([
    'theme_location' => $menu_location,
    'container'      => false,
    'menu_class'     => 'bvs-mobile-menu',
    'fallback_cb'    => false,
]);

                    ?>
                </nav>
            </div>

        </div>
    </div>

</header>

<!-- SCRIPT DO MENU MOBILE / OFFCANVAS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle   = document.querySelector('.bvs-mobile-toggle');
    var offcanvas = document.getElementById('bvs-mobile-nav');
    var closeBtn = document.querySelector('.bvs-mobile-close');

    if (!toggle || !offcanvas) return;

    function openMenu() {
        offcanvas.classList.add('is-open');
        document.body.classList.add('bvs-mobile-menu-open');
        toggle.setAttribute('aria-expanded', 'true');
        offcanvas.setAttribute('aria-hidden', 'false');
    }

    function closeMenu() {
        offcanvas.classList.remove('is-open');
        document.body.classList.remove('bvs-mobile-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
        offcanvas.setAttribute('aria-hidden', 'true');
    }

    toggle.addEventListener('click', function () {
        if (offcanvas.classList.contains('is-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeMenu);
    }

    // Fecha ao clicar no fundo escuro
    offcanvas.addEventListener('click', function (e) {
        if (e.target === offcanvas) {
            closeMenu();
        }
    });

    // Fecha com ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && offcanvas.classList.contains('is-open')) {
            closeMenu();
        }
    });

    // SUBMENUS MOBILE: cria botão de toggle para itens com filhos
    var submenuParents = offcanvas.querySelectorAll('.bvs-mobile-menu li.menu-item-has-children');

    submenuParents.forEach(function (li) {
        var link = li.querySelector('a');
        if (!link) return;

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'bvs-submenu-toggle';
        btn.setAttribute('aria-expanded', 'false');
        btn.innerHTML = '<span class="bvs-submenu-toggle-icon"></span>';

        // insere o botão logo depois do link
        if (link.nextSibling) {
            li.insertBefore(btn, link.nextSibling);
        } else {
            li.appendChild(btn);
        }

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var isOpen = li.classList.toggle('is-open');
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        // Evita que o clique no link feche/abra de forma estranha
        link.addEventListener('click', function (e) {
            // se quiser que o link apenas abra o submenu quando ainda estiver fechado:
            if (!li.classList.contains('is-open')) {
                e.preventDefault();
                li.classList.add('is-open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>
