document.addEventListener('DOMContentLoaded', function() {
    const carouselWrapper = document.getElementById('carouselWrapper');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const scrollAmount = 300; // Quantidade de pixels para rolar

    if (carouselWrapper && prevBtn && nextBtn) {
        // Função para rolar o carrossel
        function scrollCarousel(direction) {
            carouselWrapper.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
            updateButtonStates();
        }

        // Função para atualizar o estado dos botões (habilitado/desabilitado)
        function updateButtonStates() {
            // Desabilita o botão anterior se estiver no início
            prevBtn.disabled = carouselWrapper.scrollLeft === 0;
            
            // Desabilita o botão próximo se estiver no final
            const maxScroll = carouselWrapper.scrollWidth - carouselWrapper.clientWidth;
            // 10px de tolerância para evitar problemas de arredondamento de float
            nextBtn.disabled = carouselWrapper.scrollLeft >= maxScroll - 10; 
        }

        // Adiciona os event listeners aos botões
        prevBtn.addEventListener('click', function() {
            scrollCarousel(-1);
        });
        nextBtn.addEventListener('click', function() {
            scrollCarousel(1);
        });

        // Adiciona o event listener para scroll manual (mouse, touch)
        carouselWrapper.addEventListener('scroll', updateButtonStates);

        // Atualiza o estado dos botões ao carregar a página
        updateButtonStates();
    }
});