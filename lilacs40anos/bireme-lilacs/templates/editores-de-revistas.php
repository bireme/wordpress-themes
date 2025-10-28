<?php
/*
Template Name: Editores de revistas
Template Post Type: page
*/

// Variáveis do Banner de Destaque LILACS
$titulo = "EDITORES DE REVISTAS";
$texto = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
$aba_texto = ""; // 
$imagem_url = "#";  //colocar dps 

$cor_fundo = "#E9E6DF"; // Bege/cinza muito claro
$cor_titulo = "#f78c3c"; // Laranja LILACS
$cor_aba = "#004a8f"; // Azul escuro LILACS
$cor_texto = "#00205C"; 

// Novo texto a ser exibido abaixo do banner
$after_banner_text = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.";



get_header(); // Inclui o cabeçalho do tema WordPress?>




	<style>
		
	/* ========================================
	   Estilos para o Banner de Destaque LILACS
	   ======================================== */
	
	/* Container Principal do Banner */
	.lilacs-banner {
	    display: flex;
		    min-height: 500px; /* Altura reduzida a pedido do usuário */
	    background-color: <?php echo $cor_fundo; ?>;
	    position: relative;
	    box-sizing: border-box;
	    overflow: hidden; /* Para garantir que a imagem não vaze */
	}
	
	/* Estrutura de Conteúdo */
	.lilacs-banner-content {
	    display: flex;
	    width: 100%;
	    max-width: 1200px; /* Limite de largura para o conteúdo */
	    margin: 0 auto;
	    padding: 50px 20px;
	    box-sizing: border-box;
	    align-items: center; /* Centralizar verticalmente o conteúdo */
	}
	
	/* Coluna de Texto */
	.text-column {
	    flex: 1;
	    padding-right: 40px;
	    max-width: 50%; /* Ocupar metade da largura */
		    padding-left: 0; /* Remover o espaçamento da aba lateral removida */
	}
	
	/* Título */
	.text-column h1 {
	    font-size: 3.5rem;
	    color: <?php echo $cor_titulo; ?>;
	    font-weight: bold;
	    text-transform: uppercase;
	    margin-bottom: 20px;
	    line-height: 1.1;
	    text-align: left; /* Garantir alinhamento à esquerda */
	}
	
/* Parágrafo */
.text-column p {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 0;
    color: <?php echo $cor_texto; ?>; /* Cor do texto do banner (parágrafo) */
}
	
	/* Coluna de Imagem */
	.image-column {
	    flex: 1;
	    display: flex;
	    justify-content: flex-end;
	    align-items: flex-end; /* Alinhar a imagem ao fundo do banner */
	    max-width: 50%; /* Ocupar metade da largura */
	}
	
	.image-column img {
	    max-width: 100%;
		    max-height: 500px; /* Limitar a altura da imagem à altura do banner */
	    object-fit: contain;
	    display: block;
	}
	
	/* Aba Lateral Vertical */
		.vertical-tab {
		    display: none; /* Elemento removido a pedido do usuário */
		}
	
	/* Responsividade */
	@media (max-width: 992px) {
		    .lilacs-banner-content {
		        flex-direction: column;
		        align-items: flex-start;
		        padding-top: 50px; /* Ajustar padding para nova altura */
		        padding-bottom: 50px; /* Ajustar padding para nova altura */
		    }
	
	    .text-column, .image-column {
	        max-width: 100%;
	        padding-right: 0;
	        padding-left: 0;
	        text-align: center;
	    }
	
	    .text-column h1 {
	        font-size: 2.5rem;
	        text-align: center;
	    }
	
	    .image-column {
	        margin-top: 30px;
	        justify-content: center;
	    }
	    
		    .vertical-tab {
		        display: none; /* Elemento removido a pedido do usuário */
		    }
	}
	
	@media (max-width: 576px) {
	    .text-column h1 {
	        font-size: 2rem;
	    }
	    .text-column p {
	        font-size: 1rem;
	    }
	}
	
	/* Estilos para o Bloco de Texto Abaixo do Banner (Não alterados) */
.manus-after-banner-section {
    /* Seção para o texto abaixo do banner */
    padding: 40px 0; /* Espaçamento vertical */
    display: flex;
    justify-content: center;
}

.manus-after-banner-content {
    /* Limita a largura do conteúdo de texto (o mesmo max-width do banner) */
    max-width: 1440px; /* Ajustado para a largura do Figma */
    width: 90%;
    margin: 0 auto;
}

.manus-after-banner-text {
    /* Estilo do Texto Abaixo do Banner */
    font-family: sans-serif;
    font-size: 16px;
    color: <?php echo $cor_texto; ?>;
    line-height: 1.8;
}


/* Responsividade */
@media (max-width: 1024px) {
    .manus-text-column {
        max-width: 60%; /* Mais espaço para o texto em telas menores */
    }
    .manus-image-column {
        width: 40%;
    }
}

@media (max-width: 768px) {
    .manus-banner-container {
        /* Remove a correção de full-width em telas pequenas */
        width: 100%;
        position: static;
        left: auto;
        right: auto;
        margin-left: 0;
        margin-right: 0;
        height: auto; /* Altura automática para acomodar o conteúdo */
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .manus-banner-content {
        flex-direction: column; /* Empilha o texto e a imagem */
        padding: 0 20px;
        width: 100%;
    }

    .manus-text-column {
        max-width: 100%;
        padding-right: 0;
        padding-bottom: 20px;
        order: 1; /* Texto primeiro */
    }

    .manus-image-column {
        position: relative;
        width: 100%;
        height: 200px; /* Altura fixa para a imagem no mobile */
        order: 2; /* Imagem depois do texto */
    }

    .manus-image-column img {
        position: relative;
        height: 100%;
        width: 100%;
        object-fit: contain; /* Garante que a imagem inteira seja visível */
        right: auto;
        bottom: auto;
    }

    .manus-banner-title {
        font-size: 32px;
    }

    .manus-side-tab {
        display: none; /* Esconde a aba lateral no mobile para economizar espaço */
    }
}
	
	
	
/* Estilos para a seção Acesso Rápido - Baseado na estrutura do usuário */
.acesso-rapido-section {
    padding: 40px 0;
    /* max-width: 1200px; - Removido, o container deve cuidar disso */
    margin: 0 auto;
    padding-left: 15px;
    padding-right: 15px;
}

.acesso-rapido-section .container {
    max-width: 1200px; /* Definindo o container */
    margin: 0 auto;
}

.section-title {
    font-size: 28px;
    font-weight: bold;
    color: #000; /* Cor do título */
    margin-bottom: 30px;
}

.links-grid {
    display: grid;
    /* Mantendo o layout em duas colunas, com ajuste automático para telas menores */
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.acesso-link {
    background-color: #0d2c67; /* Azul escuro do Figma */
    border-radius: 10px;
    padding: 20px;
    color: #ffffff;
    display: flex;
    align-items: center; /* Alinha o conteúdo verticalmente */
    text-decoration: none; /* Remove sublinhado do link */
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.acesso-link:hover {
    background-color: #1a418a; /* Um pouco mais claro no hover */
}

.link-icon {
    /* Estilo para o container do ícone (imagem) */
    width: 40px; /* Aumentando o tamanho para acomodar a imagem */
    height: 40px;
    min-width: 40px;
    margin-right: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.link-icon img {
    max-width: 100%;
    height: auto;
}

.link-content {
    flex-grow: 1;
}

.link-title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    line-height: 1.3;
    color: #ffffff; /* Garante que o título seja branco */
}

.link-content p {
    font-size: 14px;
    opacity: 0.8;
    color: #ffffff;
    margin: 0; /* Remove margem padrão do parágrafo */
}

.link-arrow {
    margin-left: auto; /* Empurra para a direita */
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Ajuste para telas menores */
@media (max-width: 768px) {
    .links-grid {
        grid-template-columns: 1fr; /* Coluna única no mobile */
    }
    .acesso-rapido-section {
        padding: 20px 15px;
    }
}

/* ========================================
   Estilos para a seção de Cursos 
   ======================================== */
.course-section {
    background-color: #004a8f;
    border-radius: 12px;
    padding: 40px;
    max-width: 1000px;
    margin: 0 auto;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.course-header {
    color: #ffffff;
    margin-bottom: 30px;
}

.course-header h1 {
    font-size: 32px;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 20px;
}

.course-content {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.course-image-container {
    flex-shrink: 0;
    width: 200px;
    min-width: 200px;
}

.course-image-container img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    display: block;
}

.course-info {
    flex: 1;
    color: #ffffff;
}

.course-info h2 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.3;
}

.course-info p {
    font-size: 14px;
    line-height: 1.6;
    opacity: 0.95;
    margin-bottom: 20px;
    text-align: justify;
}

.course-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: center; 
}

.btn {
    padding: 12px 28px;
    border: none;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block; 
    transition: all 0.3s ease;
    text-align: center;
    
    white-space: normal;
    word-wrap: break-word; 
}

.btn-basic {
    background-color: #ffffff;
    color: #004a8f;
    border: 2px solid transparent;
}

.btn-basic:hover {
    background-color: #f0f0f0;
    color: #004a8f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-advanced {
    background-color: #ffffff;
    color: #004a8f;
    border: 2px solid transparent;
}

.btn-advanced:hover {
    background-color: #f0f0f0;
    color: #004a8f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Responsivo para tablets */
@media (max-width: 768px) {
    .course-section {
        padding: 30px 20px;
    }

    .course-header h1 {
        font-size: 24px;
    }

    .course-content {
        flex-direction: column;
        gap: 20px;
    }

    .course-image-container {
        width: 100%;
        max-width: 250px;
        margin: 0 auto;
    }

    .course-buttons {
        justify-content: center;
    }
}

/* Responsivo para mobile */
@media (max-width: 480px) {
    .course-section {
        padding: 20px 15px;
    }

    .course-header h1 {
        font-size: 20px;
    }

    .course-info h2 {
        font-size: 16px;
    }

    .course-info p {
        font-size: 13px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 13px;
     
    }
}
/* ========================================
   Estilos para a seção de Publicações (Carrossel)
   ======================================== */

.publications-section {
    background-color: #ffffff;
    padding: 60px 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.publications-header {
    text-align: center;
    margin-bottom: 50px;
}

.publications-header p {
    font-size: 16px;
    color: #333333;
    line-height: 1.6;
    max-width: 900px;
    margin: 0 auto;
}

.carousel-container {
    position: relative;
    overflow: hidden;
}

.carousel-wrapper {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 20px 0;
    scrollbar-width: none;
}

.carousel-wrapper::-webkit-scrollbar {
    display: none;
}

.carousel-item {
    flex: 0 0 280px;
    min-width: 280px;
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.carousel-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.carousel-item-image {
    width: 100%;
    height: 200px;
    background-color: #e0e0e0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.carousel-item-content {
    padding: 20px;
    background-color: #0d2c67;
    color: #ffffff;
    text-align: center;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-item-title {
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
    color: #ffffff;
}

.carousel-nav {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 30px;
}

.carousel-btn {
    width: 40px;
    height: 40px;
    border: 2px solid #0d2c67;
    background-color: #ffffff;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #0d2c67;
    transition: all 0.3s ease;
}

.carousel-btn:hover {
    background-color: #0d2c67;
    color: #ffffff;
}

.carousel-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsivo para tablets - Carrossel */
@media (max-width: 768px) {
    .publications-section {
        padding: 40px 15px;
    }

    .publications-header p {
        font-size: 15px;
    }

    .carousel-item {
        flex: 0 0 250px;
        min-width: 250px;
    }

    .carousel-item-image {
        height: 180px;
    }
}

/* Responsivo para mobile - Carrossel */
@media (max-width: 480px) {
    .publications-section {
        padding: 30px 15px;
    }

    .publications-header p {
        font-size: 14px;
    }

    .carousel-item {
        flex: 0 0 220px;
        min-width: 220px;
    }

    .carousel-item-image {
        height: 160px;
    }

    .carousel-item-title {
        font-size: 14px;
    }

    .carousel-item-content {
        padding: 15px;
        min-height: 70px;
    }
}

/* ========================================
   Estilos para a seção de Dois Cards (Representatividade e Blogs)
   ======================================== */

.two-cards-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.cards-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

.card-representatividade {
    background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
    color: #ffffff;
    display: flex;
    flex-direction: column;
    padding: 40px;
    position: relative;
    overflow: hidden;
}

.card-representatividade::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    pointer-events: none;
}

.card-image-container {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
    min-height: 200px;
}

.card-image-container img {
    max-width: 100%;
    height: auto;
    display: block;
}

.card-content {
    position: relative;
    z-index: 1;
}

.card-title {
    font-size: 24px;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 15px;
}

.card-description {
    font-size: 14px;
    line-height: 1.6;
    opacity: 0.95;
    margin-bottom: 25px;
    text-align: justify;
}

.card-button {
    display: inline-block;
    padding: 12px 32px;
    background-color: #ffffff;
    color: #8B5CF6;
    border: none;
    border-radius: 50px; /* Mais arredondado para formato pílula */
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    width: fit-content;
}

.card-button:hover {
    background-color: #f0f0f0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card-blogs {
    background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
    color: #ffffff;
    display: flex;
    flex-direction: column;
    padding: 40px;
    position: relative;
    overflow: hidden;
}

.card-blogs::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    pointer-events: none;
}

.blogs-title {
    font-size: 24px;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.blogs-description {
    font-size: 14px;
    line-height: 1.6;
    opacity: 0.95;
    margin-bottom: 30px;
    text-align: justify;
    position: relative;
    z-index: 1;
}

.blogs-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    position: relative;
    z-index: 1;
}

.blog-tag {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ffffff;
    color: #8B5CF6;
    border: none;
    border-radius: 50px; /* Mais arredondado para formato pílula */
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.blog-tag:hover {
    background-color: #f0f0f0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Responsivo para tablets - Dois Cards */
@media (max-width: 768px) {
    .two-cards-section {
        padding: 40px 15px;
    }

    .cards-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .card-representatividade,
    .card-blogs {
        padding: 30px;
    }

    .card-title,
    .blogs-title {
        font-size: 20px;
    }

    .card-description,
    .blogs-description {
        font-size: 13px;
    }

    .blog-tag {
        font-size: 12px;
        padding: 8px 16px;
    }
}

/* Responsivo para mobile - Dois Cards */
@media (max-width: 480px) {
    .two-cards-section {
        padding: 30px 15px;
    }

    .cards-grid {
        gap: 15px;
    }

    .card-representatividade,
    .card-blogs {
        padding: 20px;
    }

    .card-image-container {
        margin-bottom: 20px;
        min-height: 150px;
    }

    .card-title,
    .blogs-title {
        font-size: 18px;
        margin-bottom: 12px;
    }

    .card-description,
    .blogs-description {
        font-size: 12px;
        margin-bottom: 20px;
    }

    .blog-tag {
        font-size: 11px;
        padding: 8px 14px;
    }

    .blogs-tags {
        gap: 10px;
    }
}

/* ========================================
   Estilos para a seção de Normas e Diretrizes
   ======================================== */

.guidelines-section {
    background-color: #f5f5f5;
    padding: 60px 20px;
    border-top: 3px solid #0d2c67;
}

.guidelines-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 40px;
}

.guidelines-title {
    font-size: 24px;
    font-weight: 700;
    color: #0d2c67;
    line-height: 1.3;
    min-width: 250px;
    white-space: nowrap;
}

.guidelines-logos {
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    flex: 1;
}

.guidelines-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.guidelines-logo img {
    max-height: 60px;
    max-width: 120px;
    object-fit: contain;
    display: block;
}

.guidelines-logo a {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-decoration: none;
}

.guidelines-logo:hover {
    transform: scale(1.05);
    opacity: 0.8;
}

/* Responsivo para tablets - Normas e Diretrizes */
@media (max-width: 768px) {
    .guidelines-section {
        padding: 40px 15px;
    }

    .guidelines-container {
        flex-direction: column;
        gap: 30px;
    }

    .guidelines-title {
        white-space: normal;
        text-align: center;
        min-width: auto;
        font-size: 22px;
    }

    .guidelines-logos {
        justify-content: center;
        gap: 20px;
    }

    .guidelines-logo {
        height: 50px;
    }

    .guidelines-logo img {
        max-height: 50px;
        max-width: 100px;
    }
}

/* Responsivo para mobile - Normas e Diretrizes */
@media (max-width: 480px) {
    .guidelines-section {
        padding: 30px 15px;
    }

    .guidelines-container {
        gap: 20px;
    }

    .guidelines-title {
        font-size: 18px;
    }

    .guidelines-logos {
        gap: 15px;
    }

    .guidelines-logo {
        height: 45px;
    }

    .guidelines-logo img {
        max-height: 45px;
        max-width: 80px;
    }
}
</style>




<!-- BANNER DE DESTAQUE LILACS - INÍCIO -->
<div class="lilacs-banner">
    
    <div class="lilacs-banner-content">
        <div class="text-column">
            <h1><?php echo $titulo; ?></h1>
            <p><?php echo $texto; ?></p>
        </div>
        <div class="image-column">
            <!-- O usuário deve garantir que a imagem esteja no local correto -->
            <img src="<?php echo $imagem_url; ?>" alt="Mulher sorrindo com laptop, representando Editores de Revistas">
        </div>
    </div>
</div>
<!-- BANNER DE DESTAQUE LILACS - FIM -->

	    <!-- SEÇÃO DE TEXTO ABAIXO DO BANNER -->
    <section class="manus-after-banner-section">
        <div class="manus-after-banner-content">
            <p class="manus-after-banner-text"><?php echo $after_banner_text; ?></p>
        </div>
    </section>


<section class="acesso-rapido-section">
    <div class="container">
        <h2 class="section-title">Acesso rápido</h2>
        <div class="links-grid">
            
            <!-- Card 1: Status da sua revista na LILACS -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/diversity_3-1.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">Status da sua revista na LILACS</h3>
                    <p>Verifique se seu periódico já está indexado na LILACS:</p>
                </div>
               <div class="link-arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

            <!-- Card 2: LILACS-Express -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/acute-1.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">LILACS-Express</h3>
                    <p><!-- Sem descrição visível no Figma --></p>
                </div>
              <div class="link-arrow">
    
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

            <!-- Card 3: Indexe seu periódico -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/drive_folder_upload.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">Indexe seu periódico</h3>
                    <p>Garanta que todos os artigos da sua revista estejam rapidamente indexados na LILACS!</p>
                </div>
               <div class="link-arrow">
    
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

            <!-- Card 4: Processo de Avaliação e Seleção de Periódicos LILACS Brasil -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/star_half.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">Processo de Avaliação e Seleção de Periódicos LILACS Brasil</h3>
                    <p><!-- Sem descrição visível no Figma --></p>
                </div>
               <div class="link-arrow">
    
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

            <!-- Card 5: Atualização cadastral -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/demography-1.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">Atualização cadastral</h3>
                    <p>Mantenha seu cadastro atualizado!</p>
                </div>
              <div class="link-arrow">
    
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

            <!-- Card 6: Reavaliação de permanência na coleção -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/news-1.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">Reavaliação de permanência na coleção</h3>
                    <p><!-- Sem descrição visível no Figma --></p>
                </div>
              <div class="link-arrow">
    
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

            <!-- Card 7: Processos anteriores -->
            <a href="#" class="acesso-link">
                <div class="link-icon">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/document_search-1.png" alt="Ícone" width="40" height="40">
                </div>
                <div class="link-content">
                    <h3 class="link-title">Processos anteriores</h3>
                    <p><!-- Sem descrição visível no Figma --></p>
                </div>
             <div class="link-arrow">
    
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 18 16 12 8 6"></polyline></svg>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- Seção de Cursos de Comunicação Científica -->
<section class="course-section">
    <div class="container">
        <div class="course-header">
            <h2>Cursos de Comunicação Científica em Ciências da Saúde</h2>
        </div>

        <div class="course-content">
            <div class="course-image-container">
                <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Curso-avanzado-1.png" alt="Cursos de Comunicação Científica em Ciências da Saúde">
            </div>

            <div class="course-info">
                <h3>Curso de Comunicação Científica em Ciências da Saúde</h3>
                <p>Curso de nível básico e outro avançado em Comunicação Científica para pesquisadores, profissionais da saúde, editores científicos e alunos de graduação e pós-graduação em ciências da saúde.</p>

                <div class="course-buttons">
                    <a href="#" class="btn btn-basic">Curso de nível Básico</a>
                    <a href="#" class="btn btn-advanced">Curso de nível Avançado</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Seção de Publicações (Carrossel) -->
<section class="publications-section">
    <div class="publications-header">
        <p>Conheça publicações sobre temas importantes da comunicação científica para editores científicos e equipes editoriais</p>
    </div>

    <div class="carousel-container">
        <div class="carousel-wrapper" id="carouselWrapper">
            <!-- Card 1 -->
            <div class="carousel-item">
                <div class="carousel-item-image">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Rectangle-27.png" alt="Acesso Aberto">
                </div>
                <div class="carousel-item-content">
                    <h3 class="carousel-item-title">Acesso Aberto</h3>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="carousel-item">
                <div class="carousel-item-image">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Rectangle-27-1.png" alt="Avaliação por pares">
                </div>
                <div class="carousel-item-content">
                    <h3 class="carousel-item-title">Avaliação por pares</h3>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="carousel-item">
                <div class="carousel-item-image">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Rectangle-27-2.png" alt="Políticas editoriais">
                </div>
                <div class="carousel-item-content">
                    <h3 class="carousel-item-title">Políticas editoriais</h3>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="carousel-item">
                <div class="carousel-item-image">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Rectangle-27-3.png" alt="Preprints">
                </div>
                <div class="carousel-item-content">
                    <h3 class="carousel-item-title">Preprints</h3>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="carousel-item">
                <div class="carousel-item-image">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Rectangle-27-4.png" alt="Inteligência artificial na Publicação">
                </div>
                <div class="carousel-item-content">
                    <h3 class="carousel-item-title">Inteligência artificial na Publicação</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="carousel-nav">
        <button class="carousel-btn" id="prevBtn" onclick="scrollCarousel(-1)">‹</button>
        <button class="carousel-btn" id="nextBtn" onclick="scrollCarousel(1)">›</button>
    </div>
</section>

<script>
    const carouselWrapper = document.getElementById('carouselWrapper');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const scrollAmount = 300; // Quantidade de pixels para rolar

    function scrollCarousel(direction) {
        carouselWrapper.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
        updateButtonStates();
    }

    function updateButtonStates() {
        // Desabilita o botão anterior se estiver no início
        prevBtn.disabled = carouselWrapper.scrollLeft === 0;
        
        // Desabilita o botão próximo se estiver no final
        const maxScroll = carouselWrapper.scrollWidth - carouselWrapper.clientWidth;
        nextBtn.disabled = carouselWrapper.scrollLeft >= maxScroll - 10; // 10px de tolerância
    }

    // Atualiza o estado dos botões ao carregar a página
    updateButtonStates();

    // Atualiza o estado dos botões ao fazer scroll manual
    carouselWrapper.addEventListener('scroll', updateButtonStates);
</script>

<!-- Seção de Dois Cards: Representatividade e Blogs -->
<section class="two-cards-section">
    <div class="cards-grid">
        <!-- Card 1: Representatividade -->
        <div class="card card-representatividade">
            <div class="card-image-container">
                <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/8749-Convertido-1.png" alt="Representatividade de periódicos científicos">
            </div>
            <div class="card-content">
                <h2 class="card-title">Representatividade de periódicos científicos em ciências da saúde em bases de dados</h2>
                <p class="card-description">Planilha Excel armazenada em Google Docs contendo a situação de indexação de periódicos científicos em saúde e áreas correlatas da América Latina, Portugal e Espanha nas bases de dados LILACS, SciELO, MEDLINE, Web of Science, Journal Citation Reports e Scopus. É possível fazer download, e selecionar os periódicos por país e base de indexação, utilizando mais de um filtro simultaneamente.</p>
                <a href="#" class="card-button">Acesse aqui</a>
            </div>
        </div>

        <!-- Card 2: Blogs -->
        <div class="card card-blogs">
            <h2 class="blogs-title">Blogs sobre Comunicação Científica</h2>
            <p class="blogs-description">Os blogs de comunicação científica trazem o que há de mais inovador e atual nos debates da comunidade científica em todo o mundo. Permitem comparar diferentes aspectos e posicionamentos sobre práticas inovadoras na publicação científica, expondo prós e contras, para que os distintos atores envolvidos tomem decisões informadas e se mantenham a par das últimas tendências sobre o tema. Relacionamos os blogs mais relevantes internacionalmente para que você participe do debate, já que muitos deles permitem comentários dos leitores.</p>
            <div class="blogs-tags">
                <a href="#" class="blog-tag">The Scholarly Kitchen</a>
                <a href="#" class="blog-tag">LSE Impact Blog</a>
                <a href="#" class="blog-tag">JISC News</a>
                <a href="#" class="blog-tag">Leiden Madtrics</a>
                <a href="#" class="blog-tag">Operas Hypotheses</a>
                <a href="#" class="blog-tag">The conversation</a>
                <a href="#" class="blog-tag">Europe of Knowledge</a>
                <a href="#" class="blog-tag">SciELO em perspectiva</a>
                <a href="#" class="blog-tag">Ithaka SR</a>
                <a href="#" class="blog-tag">Editage insights</a>
                <a href="#" class="blog-tag">Digital Science blog</a>
                <a href="#" class="blog-tag">Research Trends</a>
            </div>
        </div>
    </div>
</section>

<!-- Seção de Normas e Diretrizes em Comunicação Científica -->
<section class="guidelines-section">
    <div class="guidelines-container">
        <h2 class="guidelines-title">Normas e diretrizes em <br> comunicação científica</h2>
        <div class="guidelines-logos">
            <!-- Logo 1 -->
            <div class="guidelines-logo">
                <a href="#" title="Logo 1">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/8749-Convertido-1.png" alt="Logo 1">
                </a>
            </div>
            
            <!-- Logo 2 -->
            <div class="guidelines-logo">
                <a href="#" title="Logo 2">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/ISSN.png" alt="Logo 2">
                </a>
            </div>
            
            <!-- Logo 3 -->
            <div class="guidelines-logo">
                <a href="#" title="Logo 3">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/ictrp.png" alt="Logo 3">
                </a>
            </div>
            
            <!-- Logo 4 -->
            <div class="guidelines-logo">
                <a href="#" title="Logo 4">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/Open-Archives.png" alt="Logo 4">
                </a>
            </div>
            
            <!-- Logo 5 -->
            <div class="guidelines-logo">
                <a href="#" title="Logo 5">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/nih_nlm.png" alt="Logo 5">
                </a>
            </div>
            
            <!-- Logo 6 -->
            <div class="guidelines-logo">
                <a href="#" title="Logo 6">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/icmje.png" alt="Logo 6">
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); // Inclui o rodapé do tema WordPress ?>