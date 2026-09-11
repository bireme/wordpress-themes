<section class="coordenacao-atua-section">
    <div class="container">
        <?php
        $post_id = get_queried_object_id() ?: (isset($post->ID) ? $post->ID : 0);
        $section_title = $post_id ? get_post_meta($post_id, '_lilacs_cp_atuacao_section_title', true) : '';
        $items = $post_id ? get_post_meta($post_id, '_lilacs_cp_atuacao_items', true) : [];
        if (!$section_title) {
            $section_title = 'A coordenação atua:'; // fallback
        }
        ?>
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>

        <?php if (!empty($items) && is_array($items)): ?>
        <div class="cards-grid">
            <?php foreach ($items as $it): 
                $img = '';
                if (!empty($it['img_id'])) {
                  $img = wp_get_attachment_image_url((int)$it['img_id'], 'medium');
                } elseif (!empty($it['img_url'])) {
                  $img = esc_url($it['img_url']);
                }
                $title = $it['title'] ?? '';
                $desc  = $it['desc']  ?? '';
            ?>
            <div class="card">
                <?php if ($img): ?>
                <div class="card-icon">
                    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>">
                </div>
                <?php endif; ?>
                <div class="card-content">
                    <?php if ($title): ?><h3 class="card-title"><?php echo esc_html($title); ?></h3><?php endif; ?>
                    <?php if ($desc): ?><p><?php echo wp_kses_post($desc); ?></p><?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Se não houver itens, mantém o HTML estático antigo ou mostra nada -->
        <div class="cards-grid">
            <p><?php echo esc_html__('Nenhuma informação cadastrada em Atuação.', 'bireme'); ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>