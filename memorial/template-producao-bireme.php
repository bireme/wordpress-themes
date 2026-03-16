<?php /* Template Name: Produções BIREME */ ?>
<?php get_header('interno'); ?>
<main id="prodct-section" class="prodct-wrapper py-5">
    <div class="container">
        <div class="breadcrumb">
            <?php if (function_exists('bcn_display')) { bcn_display(); } ?>
        </div>
        <h1 class="title"><?php  the_title(); ?></h1>
        <div class="mt-5 mb-5">    
            <?php  the_content(); ?>
        </div>
        <div class="row align-items-stretch prodct-layout">
            <!-- COLUNA ESQUERDA -->
            <div class="col-12 col-lg-4 order-2 order-lg-1">
                <div class="prodct-cards-stack prodct-cards-left">
                    <?php if (have_rows('cards_esquerda')): ?>
                        <?php while (have_rows('cards_esquerda')): the_row();
                            $titulo = get_sub_field('titulo');
                            $descricao = get_sub_field('descricao');
                            $link = get_sub_field('link');
                            ?>
                            <div class="prodct-info-card">
                                <?php if($titulo): ?>
                                    <h3 class="prodct-card-title">
                                        <?php echo esc_html($titulo); ?>
                                    </h3>
                                <?php endif; ?>
                                <?php if($descricao): ?>
                                    <div class="prodct-card-description">
                                        <?php echo wp_kses_post($descricao); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($link): ?>
                                    <a href="<?php echo esc_url($link); ?>">
                                        <img src="<?php bloginfo('template_directory'); ?>/img/icon-right.svg" class="btn-more"  >
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
                <!-- CENTRO -->
                <div class="col-12 col-lg-4 order-1 order-lg-2">
                    <div class="prodct-center-wrapper">
                        <div class="prodct-center-image">
                            <?php $area_central = get_field('secao_titulo');
                            $imagem_central = $area_central['imagem_central'] ?? null;
                            $texto_central  = $area_central['texto_central'] ?? ''; ?>
                            <?php if ($imagem_central): ?>
                                <img
                                src="<?php echo esc_url($imagem_central['url']); ?>"
                                alt="<?php echo esc_attr($imagem_central['alt']); ?>"
                                >
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- COLUNA DIREITA -->
                <div class="col-12 col-lg-4 order-3">
                    <div class="prodct-cards-stack prodct-cards-right">
                        <?php if (have_rows('cards_direita')): ?>
                            <?php while (have_rows('cards_direita')): the_row();
                                $titulo = get_sub_field('titulo');
                                $descricao = get_sub_field('descricao');
                                $link = get_sub_field('link');
                                ?>
                                <div class="prodct-info-card">
                                    <?php if($titulo): ?>
                                        <h3 class="prodct-card-title">
                                            <?php echo esc_html($titulo); ?>
                                        </h3>
                                    <?php endif; ?>
                                    <?php if($descricao): ?>
                                        <div class="prodct-card-description">
                                            <?php echo wp_kses_post($descricao); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($link): ?>
                                     <a href="<?php echo esc_url($link); ?>">
                                        <img src="<?php bloginfo('template_directory'); ?>/img/icon-right.svg" class="btn-more"  >
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
    <?php get_footer(); ?>