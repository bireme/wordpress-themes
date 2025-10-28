<?php
// Simulação de links de acesso rápido
$links_rapidos = [
    ['title' => 'Link Rápido 1', 'description' => 'Descrição do Link 1', 'icon_url' => '#'],
    ['title' => 'Link Rápido 2', 'description' => 'Descrição do Link 2', 'icon_url' => '#'],
    ['title' => 'Link Rápido 3', 'description' => 'Descrição do Link 3', 'icon_url' => '#'],
    ['title' => 'Link Rápido 4', 'description' => 'Descrição do Link 4', 'icon_url' => '#'],
];
?>
<section class="acesso-rapido-section">
    <div class="container">
        <h2 class="section-title">Acesso Rápido</h2>
        <div class="links-grid">
            <?php foreach ($links_rapidos as $link) : ?>
                <a href="#" class="acesso-link">
                    <div class="link-icon">
                        <img src="<?php echo $link['icon_url']; ?>" alt="Ícone">
                    </div>
                    <div class="link-content">
                        <h3 class="link-title"><?php echo $link['title']; ?></h3>
                        <p><?php echo $link['description']; ?></p>
                    </div>
                    <span class="link-arrow">-></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
