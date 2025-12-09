  <!-- Fixed Side Element "Queremos sua opinião" -->
  <div class="fixed-side">Queremos sua opinião</div>

  <!-- Hero Section -->
    <?php
    $hero = bireme_get_lilacs_hero_meta($post_id);
    // Fallbacks simples
    $hero_title = $hero['title'] ?: 'Explore a produção científica em saúde da América Latina e Caribe';
    $hero_desc  = $hero['desc']  ?: 'Pesquise com palavras simples ou construa consultas avançadas para acessar artigos, periódicos e informações regionais em saúde.';
    $hero_img   = $hero['img_url'] ?: ''; // url completa ou string vazia
    ?>
    
    <!-- Fixed Side Element "Queremos sua opinião" -->
    <div class="fixed-side">Queremos sua opinião</div>
    
    <!-- Hero Section (dinâmico) -->
    <section class="hero"<?php if ($hero_img): ?> style="--hero-bg: url('<?php echo esc_url($hero_img); ?>')"<?php endif; ?>>
      <!-- Background Pattern / imagem (usa CSS variável inline para flexibilidade) -->
      <div class="hero__bg" style="background-image:url('<?=$hero_img?>');" aria-hidden="true"></div>
    
      <!-- Main Content -->
      <div class="container hero__content">
        <!-- Main Heading -->
        <h1 class="hero__title"><?php echo esc_html($hero_title); ?></h1>
    
        <!-- Subtitle -->
        <p class="hero__subtitle"><?php echo wp_kses_post( wpautop( $hero_desc ) ); ?></p>
    
        <!-- Search Container -->
        <div class="search">
          <div class="search__bar">
            <input type="text" placeholder="Insira sua pesquisa aqui" class="search__input" />
            <button class="btn-mic" aria-label="Ativar microfone">
              <!-- ícone -->
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                <line x1="12" y1="19" x2="12" y2="23"></line>
                <line x1="8" y1="23" x2="16" y2="23"></line>
              </svg>
            </button>
    
            <button class="btn-search" aria-label="Pesquisar">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
              </svg>
            </button>
          </div>
        </div>
    
        <!-- Action Buttons -->
        <div class="actions">
          <button class="btn-pill">Busca avançada</button>
          <button class="btn-pill">Busca com DeCS / MeSH</button>
          <button class="btn-pill">Como pesquisar</button>
        </div>
      </div>
    </section>



  <!-- Cards Section -->
  <section class="cards-section">
    <div class="container cards-grid">
      
      <!-- Card Usuário -->
      <div class="card">
        <div class="card__header">
          <div class="card__icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#001452" stroke-width="2">
              <path d="M3 3v5h5"></path>
              <path d="M3 21v-6h5"></path>
              <path d="M21 3v5h-5"></path>
              <path d="M21 21v-6h-5"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </div>
          <div>
            <p class="card__eyebrow">Para você</p>
            <h3 class="card__title">Usuário</h3>
          </div>
        </div>
        <ul class="card__list">
          <li class="card_item"><span class="card_bullet">▶</span><span>Primeiro acesso</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Tutorial</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Guia rápido</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Documentos mais pesquisados</span></li>
          <li class="card_item"><span class="cardbullet">▶</span><span class="card_link">Outras informações</span></li>
        </ul>
      </div>

      <!-- Card Editor -->
      <div class="card">
        <div class="card__header">
          <div class="card__icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#001452" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
          </div>
          <div>
            <p class="card__eyebrow">Para você</p>
            <h3 class="card__title">Editor</h3>
          </div>
        </div>
        <ul class="card__list">
          <li class="card_item"><span class="card_bullet">▶</span><span>Indexe seu periódico</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Lista de periódicos indexados</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Consulte o seu código de editor</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Status de atualização</span></li>
          <li class="card_item"><span class="cardbullet">▶</span><span class="card_link">Outras informações</span></li>
        </ul>
      </div>

      <!-- Card Centro Cooperante -->
      <div class="card">
        <div class="card__header">
          <div class="card__icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#001452" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </div>
          <div>
            <p class="card__eyebrow">Para você</p>
            <h3 class="card__title">Centro Cooperante</h3>
          </div>
        </div>
        <ul class="card__list">
          <li class="card_item"><span class="card_bullet">▶</span><span>Quero me tornar um Centro Cooperante</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Estatísticas de contribuição</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Atualização de dados cadastrais</span></li>
          <li class="card_item"><span class="card_bullet">▶</span><span>Diretório da rede</span></li>
          <li class="card_item"><span class="cardbullet">▶</span><span class="card_link">Outras informações</span></li>
        </ul>
      </div>

    </div>
  </section>

  <!-- Carousel Section - 40 anos da LILACS -->
  <!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<section class="carousel-40">
  <div class="container carousel-40__inner">

    <!-- Slides -->
    <div class="carousel-40__content">
      <div><img src="/1.png" alt="Banner"></div>
      <div><img src="/2.png" alt="Banner"></div>
      <div><img src="/3.png" alt="Banner"></div>
      <div><img src="/4.png" alt="Banner"></div>
      <div><img src="/5.png" alt="Banner"></div>
      <div><img src="/6.png" alt="Banner"></div>
    </div>

  </div>
</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Slick JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
  $(document).ready(function(){
    $('.carousel-40__content').slick({
      dots: true,          // ativa os dots
      infinite: true,      // loop infinito
      speed: 500,          // velocidade da transição
      slidesToShow: 1,     // quantos slides aparecem
      slidesToScroll: 1,   // quantos slides rolam por vez
      autoplay: true,      // autoplay ativado
      autoplaySpeed: 3000, // tempo entre os slides
      arrows: false         // setas de navegação
    });
  });
</script>


  <!-- Últimas Publicações Section -->
  <section class="pubs-section">
    <div class="container">
      <div class="pubs-grid">
        
        <!-- Left Content -->
        <div class="pubs-left">
          <h2 class="section-title">Últimas publicações</h2>
          <p class="pubs-text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
          </p>

          <!-- Navigation Arrows -->
          <div class="pubs-nav">
            <button class="nav-arrow" aria-label="Anterior">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15,18 9,12 15,6"></polyline>
              </svg>
            </button>
            <button class="nav-arrow" aria-label="Próximo">
              <svg width="20" height="20" viewBox="0 0 24 24  " fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9,18 15,12 9,6"></polyline>
              </svg>
            </button>
          </div>
        </div>

        <!-- Right Content - Publication Cards -->
        <div class="pubs-right">
          <!-- Publication Card 1 -->
          <div class="pub-card">
            <h3 class="pub-card__title">
              O processo de desinstitucionalização da loucura e de implantação dos serviços substitutivos no Amazonas
            </h3>
            <button class="pub-card__btn" aria-label="Abrir publicação">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9,18 15,12 9,6"></polyline>
              </svg>
            </button>
          </div>

          <!-- Publication Card 2 -->
          <div class="pub-card">
            <h3 class="pub-card__title">
              Impact of the armed conflict on victims and support workers' mental health in Soacha, Colombia
            </h3>
            <button class="pub-card__btn" aria-label="Abrir publicação">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9,18 15,12 9,6"></polyline>
              </svg>
            </button>
          </div>

          <!-- Publication Card 3 -->
          <div class="pub-card">
            <h3 class="pub-card__title">
              Metanálise sobre segurança primária em pediatria
            </h3>
            <button class="pub-card__btn" aria-label="Abrir publicação">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9,18 15,12 9,6"></polyline>
              </svg>
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Depoimentos Section -->
  <section class="testimonials-section">
    <div class="container">
      <h2 class="section-title section-title--center">Depoimentos</h2>

      <div class="testimonials-grid">
        <!-- Depoimento 1 -->
        <div class="testimonial-card">
          <div class="testimonial__header">
            <div class="avatar"></div>
            <div>
              <h3 class="testimonial__name">Nome e sobrenome</h3>
              <p class="testimonial__role">Profissão</p>
            </div>
          </div>
          <p class="testimonial__text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
          </p>
        </div>

        <!-- Depoimento 2 -->
        <div class="testimonial-card">
          <div class="testimonial__header">
            <div class="avatar"></div>
            <div>
              <h3 class="testimonial__name">Nome e sobrenome</h3>
              <p class="testimonial__role">Profissão</p>
            </div>
          </div>
          <p class="testimonial__text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- JavaScript para o carrossel (mesma lógica, seletor atualizado para classes) -->
  <script>
    let currentSlide = 0;
    const dots = document.querySelectorAll('.carousel-dot');

    function updateCarousel(index) {
      dots.forEach((dot, i) => {
        dot.classList.toggle('is-active', i === index);
      });
    }

    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        currentSlide = index;
        updateCarousel(currentSlide);
      });
    });

    setInterval(() => {
      currentSlide = (currentSlide + 1) % dots.length;
      updateCarousel(currentSlide);
    }, 5000);
  </script>
<?php
/**
 * O modelo para exibir o rodapé do site
 */
?>

	<footer id="colophon" class="site-footer">

		<div class="footer-container">
            
            <div class="footer-info-text">
                <p>A BVS é um produto colaborativo, coordenado pela BIREME/OPAS/OMS. Como biblioteca, oferece acesso abrangente à informação científica e técnica em saúde. A BVS coleta, indexa e armazena citações de documentos publicados por diversas organizações. A inclusão de qualquer artigo, documento ou citação na coleção da BVS não implica endosso ou concordância da BIREME/OPAS/OMS com o seu conteúdo.</p>
            </div>
            
			<div class="footer-main-content">
				<div class="footer-logos">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-lilacs">
						<img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/logo.png" alt="Logo LILACS">
					</a>
					<div class="logos-secondary">
						<a href="#">
						   <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/opas__bireme.png" alt="Logos OPAS e BIREME">
						</a>
					</div>
				</div>

				<div class="footer-navigation">
					<nav class="footer-nav-grid">
						<div class="nav-column">
							<h3 class="nav-title"><a href="#">Home</a></h3>
							<h3 class="nav-title"><a href="#">Sobre</a></h3>
							<ul>
								<li><a href="#">Sobre a LILACS</a></li>
								<li><a href="#">Metodologia LILACS (guias, manuais e normas técnicas)</a></li>
								<li><a href="#">Indicadores da LILACS</a></li>
								<li><a href="#">Marcos históricos</a></li>
								<li><a href="#">40 anos da LILACS</a></li>
								<li><a href="#">Site de comemoração de 35 anos</a></li>
								<li><a href="#">Principais marcos históricos da LILACS</a></li>
								<li><a href="#">Referências sobre a LILACS</a></li>
							</ul>
						</div>
						<div class="nav-column">
							<h3 class="nav-title"><a href="#">Rede LILACS</a></h3>
							<ul>
								<li><a href="#">Menu Rede</a></li>
								<li><a href="#">Coordenadores temáticos</a></li>
								<li><a href="#">Coordenadores nacionais</a></li>
								<li><a href="#">Áreas de atuação</a></li>
								<li><a href="#">Especialistas/Especialidades</a></li>
								<li><a href="#">Como ser membro da Rede</a></li>
								<li><a href="#">Reuniões e capacitações: Sessões Virtuais da LILACS (agenda e documentação)</a></li>
							</ul>
						</div>
						<div class="nav-column">
							<h3 class="nav-title"><a href="#">Revistas</a></h3>
							<ul>
								<li><a href="#">Critérios de seleção e permanência de periódicos LILACS</a></li>
								<li><a href="#">Como faço para minha revista ser indexada na LILACS</a></li>
								<li><a href="#">Lista de periódicos indexados na LILACS</a></li>
								<li><a href="#">Acompanhe a indexação da sua revista</a></li>
								<li><a href="#">Perfil de periódicos da LILACS</a></li>
							</ul>
							<h3 class="nav-title"><a href="#">Indicadores</a></h3>
							<h3 class="nav-title"><a href="#">Contato</a></h3>
						</div>
					</nav>
				</div>
			</div>

			<div class="footer-bottom">
				<div class="powered-by">
					<a href="#">
						<img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/powered_by.png" alt="Logo BIREME">
					</a>
				</div>
				<div class="copyright">
					<p>&copy; <?php echo date('Y'); ?> Todos os direitos são reservados</p>
				</div>
			</div>
		</div></footer><?php wp_footer(); ?>