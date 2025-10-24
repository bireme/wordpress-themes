<?php
if (!defined('ABSPATH')) exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<script>
(function(){
  const nav = document.getElementById('site-navigation');
  const ul  = document.getElementById('primary-menu');
  const btn = document.querySelector('.menu-toggle');
  if(!nav || !ul || !btn) return;

  // abre/fecha menu (mobile)
  btn.addEventListener('click', function(){
    const open = ul.classList.toggle('is-open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  // cria botões de toggle p/ itens com filhos (mobile)
  const parents = ul.querySelectorAll('li.menu-item-has-children');
  parents.forEach(li => {
    // acessibilidade no desktop via teclado: abrir submenu ao focar link
    const a = li.querySelector(':scope > a');
    a && a.setAttribute('aria-haspopup','true');

    // botão extra só no mobile
    const toggle = document.createElement('button');
    toggle.className = 'submenu-toggle';
    toggle.type = 'button';
    toggle.setAttribute('aria-label','Abrir submenu');
    toggle.textContent = '▸';
    a && a.after(toggle);

    toggle.addEventListener('click', function(e){
      e.preventDefault();
      const isOpen = li.classList.toggle('menu-open');
      // seta setinha
      this.textContent = isOpen ? '▾' : '▸';
      // fecha irmãos
      [...li.parentElement.children].forEach(sib=>{
        if(sib !== li) { sib.classList.remove('menu-open'); const t = sib.querySelector(':scope > .submenu-toggle'); if(t) t.textContent='▸'; }
      });
    });
  });

  // fecha menu ao clicar fora (mobile)
  document.addEventListener('click', (e)=>{
    if(window.matchMedia('(max-width: 992px)').matches){
      if(!nav.contains(e.target) && !btn.contains(e.target)){
        ul.classList.remove('is-open');
        btn.setAttribute('aria-expanded','false');
      }
    }
  });
})();
</script>

<style>/* ====== BARRA E MENU PRINCIPAL ====== */
.navwrap { background:#082b61; position:relative; z-index:50; }
.navwrap__inner { display:flex; align-items:center; justify-content:space-between; min-height:56px; }

.menu--primary {
  list-style:none; margin:0; padding:0;
  display:flex; gap:28px; align-items:center;
}
.menu--primary > li { position:relative; }
.menu--primary > li > a {
  color:#fff; text-decoration:none;
  display:flex; align-items:center; gap:6px;
  padding:18px 0; font-weight:700; line-height:1;
}
.menu--primary > li.menu-item-has-children > a::after {
  content:"▾"; font-size:.8rem; opacity:.8; transform:translateY(-1px);
}

/* ====== SUBMENU (DROPDOWN PRINCIPAL) ====== */
.menu--primary .sub-menu {
  list-style:none; margin:0; padding:16px 20px;
  position:absolute; left:0; top:100%;
  min-width:520px;
  background:#fff; color:#0c1524;
  border-radius:12px; box-shadow:0 12px 24px rgba(0,0,0,.12);
  display:none; opacity:0; transform:translateY(8px);
  transition:opacity .18s ease, transform .18s ease;
  z-index:999;
}

/* Mostrar o dropdown no hover/focus */
.menu--primary > li:hover > .sub-menu,
.menu--primary > li:focus-within > .sub-menu {
  display:block; opacity:1; transform:translateY(0);
}

/* Itens do submenu */
.menu--primary .sub-menu > li {
  position:relative; margin:6px 0;
}
.menu--primary .sub-menu > li > a {
  display:block;
  padding:4px 0;
  font-weight:600;
  color:#0c1524;
  text-decoration:none;
}
.menu--primary .sub-menu > li > a:hover {
  color:#082b61;
}

/* ====== SUBGRUPOS (3º NÍVEL SEMPRE VISÍVEL) ====== */
.menu--primary .sub-menu .sub-menu {
  position:static;
  display:block;
  opacity:1; transform:none;
  background:transparent;
  box-shadow:none; border-radius:0;
  padding:0 0 8px 0;
  margin:4px 0 10px 0;
}

/* Título do grupo */
.menu--primary .sub-menu > li.menu-item-has-children > a {
    display: block;
    padding: 6px 0;
    font-weight: 800;
    font-family: 'Poppins';
    color: #000000;
}

/* Remove setinhas nos grupos */
.menu--primary .sub-menu > li.menu-item-has-children > a::after { content:none; }

/* Links do 3º nível */
.menu--primary .sub-menu .sub-menu > li > a {
  display:block; padding:3px 0;
  font-weight:600; color:#6c7887;
  text-decoration:none;
}
.menu--primary .sub-menu .sub-menu > li > a:hover {
  color:#082b61;
}

/* ====== MOBILE ====== */
.menu-toggle {
  background:transparent; border:0;
  width:40px; height:40px; display:none; color:#fff;
}
.menu-toggle .hamburger,
.menu-toggle .hamburger::before,
.menu-toggle .hamburger::after {
  content:""; display:block; height:2px;
  background:#fff; margin:7px 0; transition:.2s;
}

@media (max-width:992px){
  .menu-toggle { display:block; }
  #site-navigation { width:100%; }

  .menu--primary {
    position:absolute; left:0; right:0; top:100%;
    background:#082b61; display:none; flex-direction:column; gap:0;
    padding:8px 16px 12px;
  }
  .menu--primary.is-open { display:flex; }

  .menu--primary > li > a { padding:12px 0; }

  /* Submenu no mobile: vira acordeão */
  .menu--primary .sub-menu {
    position:static; min-width:0; width:100%;
    box-shadow:none; border-radius:6px;
    background:#0e3a80; padding:8px 12px;
    display:none; opacity:1; transform:none;
  }
  .menu--primary .sub-menu li a {
    color:#e8efff;
  }
  .menu--primary .sub-menu li a:hover {
    color:#fff;
  }

  /* Botão de abrir submenu */
  .submenu-toggle {
    background:transparent; border:0; color:#cfe0ff;
    margin-left:6px; font-size:.9rem;
  }

  .menu--primary > li.menu-open > .sub-menu { display:block; }

  /* 3º nível no mobile: apenas indentado */
  .menu--primary .sub-menu .sub-menu {
    padding-left:14px;
    border-left:2px solid rgba(255,255,255,.15);
    margin:6px 0 10px;
  }
  .menu--primary .sub-menu > li.menu-item-has-children > a { color:#fff; }
  .menu--primary .sub-menu .sub-menu > li > a { color:#cfe0ff; }
  .menu--primary .sub-menu .sub-menu > li > a:hover { color:#fff; }
}
/* --- FORÇAR 3º NÍVEL SEMPRE VISÍVEL DENTRO DO DROPDOWN (DESKTOP) --- */
.navwrap .menu--primary .sub-menu .sub-menu{
  display:block !important;
  position:static !important;
  opacity:1 !important;
  transform:none !important;
  visibility:visible !important;
  background:transparent;
  box-shadow:none;
  border-radius:0;
  padding:0 0 8px 0;
  margin:4px 0 10px 0;
}

/* quando o 2º nível estiver aberto por hover/focus, garanta que o 3º nível também apareça */
.navwrap .menu--primary > li:hover > .sub-menu .sub-menu,
.navwrap .menu--primary > li:focus-within > .sub-menu .sub-menu{
  display:block !important;
}

/* títulos de grupo não são dropdown */
.navwrap .menu--primary .sub-menu > li.menu-item-has-children > a::after{ content:none; }
.navwrap .menu--primary .sub-menu > li.menu-item-has-children > a{
  font-weight:800;
}

/* estilização dos links do 3º nível */
.navwrap .menu--primary .sub-menu .sub-menu > li > a{
display: block;
    padding: 3px 0;
    font-weight: 400;
    color: #5E5E5E;
    text-decoration: none;
    font-family: 'Poppins';
}
.navwrap .menu--primary .sub-menu .sub-menu > li > a:hover{ color:#082b61; }

/* --- MOBILE: mantém acordeão; 3º nível apenas indentado --- */
@media (max-width:992px){
  .navwrap .menu--primary .sub-menu{ display:none; }
  .navwrap .menu--primary > li.menu-open > .sub-menu{ display:block; }
  .navwrap .menu--primary .sub-menu .sub-menu{
    display:block !important;   /* sempre visível dentro do 2º nível aberto */
    padding-left:14px;
    border-left:2px solid rgba(255,255,255,.15);
    margin:6px 0 10px;
  }
}

</style>
<header class="site-header" role="banner">
  <!-- TOPBAR: acessibilidade / idiomas -->
  <div class="topbar">
    <div class="container topbar__inner">
      <div class="topbar__left">
        <nav class="top-links" aria-label="Links rápidos">
          <a href="#site-content">Conteúdo Principal</a>
          <a href="#menu">Menu</a>
          <a href="#search">Pesquisa</a>
          <a href="#footer">Rodapé</a>
        </nav>
      </div>

      <div class="topbar__right">
        <div class="accessibility">
          <button class="text-resize" data-action="increase">+A</button>
          <button class="text-resize" data-action="decrease">-A</button>
          <button class="toggle-contrast" title="Alto contraste">Alto Contraste</button>
        </div>

        <div class="lang-switcher" aria-label="Idiomas">
          <a href="<?php echo esc_url( add_query_arg('lang','pt') ); ?>" class="active">Português</a>
          <a href="<?php echo esc_url( add_query_arg('lang','en') ); ?>">English</a>
          <a href="<?php echo esc_url( add_query_arg('lang','es') ); ?>">Español</a>
        </div>
      </div>
    </div>
  </div>

  <!-- AREA DE LOGOS -->
  <div class="brandbar">
    <div class="container brandbar__inner">
      <div class="brand-left">
        <?php
        // Logo BVS - se você tem um logo secundário, troque pelo ACF ou URL fixa
        // Exemplo com imagem estática no tema:
        $bvs_logo = get_template_directory_uri() . '/assets/images/logo-bvs.svg';
        ?>
        <a class="logo-bvs" href="<?php echo esc_url( home_url('/') ); ?>">
          <img src="<?php echo esc_attr($bvs_logo); ?>" alt="BVS Biblioteca Virtual" />
        </a>
        
         <?php
        // LILACS (logo principal) - usa custom logo se disponível, senão imagem de tema
        if ( function_exists('the_custom_logo') && has_custom_logo() ) {
          the_custom_logo();
        } else {
          $lilacs_logo = get_template_directory_uri() . '/assets/images/logo-lilacs.png';
          ?>
          <a class="logo-lilacs" href="<?php echo esc_url( home_url('/') ); ?>">
            <img src="<?php echo esc_attr($lilacs_logo); ?>" alt="<?php bloginfo('name'); ?>" />
          </a>
        <?php } ?>
      </div>

      <div class="brand-center">
       
      </div>

      <div class="brand-right">
        <!-- espaço para ícones/ações (opcional) -->
      </div>
    </div>
  </div>

  <!-- NAV -->
  <div class="navwrap">
    <div class="container navwrap__inner">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Abrir menu">
        <span class="hamburger"></span>
      </button>

      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Menu principal">
<?php
wp_nav_menu([
  'theme_location' => 'primary',
  'container'      => false,
  'menu_class'     => 'menu menu--primary',
  'menu_id'        => 'primary-menu',
  'fallback_cb'    => 'wp_page_menu',
  'depth'          => 3, // precisa do 3º nível para os subgrupos
]);

?>


      </nav>
    </div>
  </div>
</header>

<div id="site-content" class="site-content">
