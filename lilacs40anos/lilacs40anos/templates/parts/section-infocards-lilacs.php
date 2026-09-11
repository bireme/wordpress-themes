<style>
.info-cards-section {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 40px 20px;
    background-color: #ffffff; /* Fundo branco */
    font-family: Arial, sans-serif;
}

.info-card {
    background-color: #f8f8f8; /* Fundo claro para o card */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    overflow: hidden;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.image-placeholder-small {
    width: 100%;
    height: 180px; /* Altura fixa para as imagens */
    background-color: #e0e0e0; /* Cor de fundo para o placeholder */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.image-placeholder-small img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Garante que a imagem cubra o espaço */
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.info-card p {
    padding: 15px;
    margin: 0;
    font-size: 1.1em;
    color: #333;
    font-weight: bold;
}

</style>
    <div class="info-cards-section">
        <div class="info-card">
            <div class="image-placeholder-small">
                <!-- Espaço para a imagem a ser preenchida manualmente -->
                <img src="<?php echo get_template_directory_uri('/images', 'infocard1'); ?>" alt="Site de comemoração de 35 anos">
            </div>
            <p>Site de comemoração de 35 anos</p>
        </div>
        <div class="info-card">
            <div class="image-placeholder-small">
                <!-- Espaço para a imagem a ser preenchida manualmente -->
                <img src="<?php echo get_template_directory_uri('/images', 'infocard2'); ?>" alt="Principais marcos históricos da LILACS">
            </div>
            <p>Principais marcos históricos da LILACS</p>
        </div>
        <div class="info-card">
            <div class="image-placeholder-small">
                <!-- Espaço para a imagem a ser preenchida manualmente -->
                <img src="<?php echo get_template_directory_uri('assets/images', 'infocard3'); ?>" alt="Referências sobre a LILACS">
            </div>
            <p>Referências sobre a LILACS</p>
        </div>
</div>
