<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<section class="coordenadores-lilacs-section">
    <div class="container">
        <h2 class="section-title">Coordenadores da rede LILACS</h2>
        <p class="section-subtitle">Instituições coordenadoras da LILACS nos países e redes temáticas</p>

        <div class="logos-carousel-wrapper">
            <div class="logos-carousel">
                <!-- Repita este bloco 8 vezes (ou mais, dependendo do total de logos) -->
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/1.png" alt="Logo Instituição 1">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/2.png" alt="Logo Instituição 2">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/3.png" alt="Logo Instituição 3">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/4.png" alt="Logo Instituição 4">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/5-1.png" alt="Logo Instituição 5">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/6.png" alt="Logo Instituição 6">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/7.png" alt="Logo Instituição 7">
                </div>
                <div class="carousel-item">
                    <img src="https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/10/8.png" alt="Logo Instituição 8">
                </div>
              
            </div>
           
            <div class="carousel-dots"></div>
        </div>

    </div>
</section>

<!-- Inicialização do Slick para rotacionar automaticamente os slides -->
<script>
	(function($){
		$(function(){
			if (typeof $.fn.slick === 'function') {
				$('.logos-carousel').slick({
					slidesToShow: 4,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed: 3000,
					dots: true,
					appendDots: '.carousel-dots',
					arrows: true,
					infinite: true,
					responsive: [
						{ breakpoint: 992, settings: { slidesToShow: 3 } },
						{ breakpoint: 768, settings: { slidesToShow: 2 } },
						{ breakpoint: 480, settings: { slidesToShow: 1 } }
					]
				});
			} else {
				/* Diagnóstico rápido: se aparecer, o slick.js não foi carregado */
				/* Garanta que o Slick (CSS + JS) e o jQuery estejam enfileirados no tema */
				/* Ex.: wp_enqueue_script('slick', 'path/to/slick.min.js', ['jquery'], null, true); */
				console.warn('Slick não encontrado: verifique se slick.js foi enqueued no tema.');
			}
		});
	})(jQuery);
</script>