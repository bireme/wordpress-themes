<?php
// Simulação de dados de publicações
$publications = [
    ['title' => 'Publicação 1', 'image_url' => '#'],
    ['title' => 'Publicação 2', 'image_url' => '#'],
    ['title' => 'Publicação 3', 'image_url' => '#'],
    ['title' => 'Publicação 4', 'image_url' => '#'],
    ['title' => 'Publicação 5', 'image_url' => '#'],
];
?>
<section class="publications-section">
    <div class="publications-header">
        <h2>Publicações em Destaque</h2>
        <p>Confira os últimos artigos e documentos importantes.</p>
    </div>
    <div class="carousel-container">
        <div class="carousel-wrapper">
            <?php foreach ($publications as $pub) : ?>
                <a href="#" class="carousel-item">
                    <div class="carousel-item-image">
                        <img src="<?php echo $pub['image_url']; ?>" alt="<?php echo $pub['title']; ?>">
                    </div>
                    <div class="carousel-item-content">
                        <h3 class="carousel-item-title"><?php echo $pub['title']; ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="carousel-nav">
            <button class="carousel-btn prev-btn"><</button>
            <button class="carousel-btn next-btn">></button>
        </div>
    </div>
</section>
<script>
    // Script básico para simular a funcionalidade do carrossel (deve ser movido para um arquivo JS)
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.querySelector('.carousel-wrapper');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        const scrollAmount = 300; // Ajuste conforme o tamanho do item

        if (prevBtn && nextBtn && wrapper) {
            prevBtn.addEventListener('click', () => {
                wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });

            nextBtn.addEventListener('click', () => {
                wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }
    });
</script>
