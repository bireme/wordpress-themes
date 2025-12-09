<?php get_header();
$lang = get_current_language();
?>

<!-- Section 1 -->
<?php
    $first_section_title = esc_html(get_option($lang . '_first_section_title'));
    $first_section_subtitle = esc_html(get_option($lang . '_first_section_subtitle'));
    $first_section_button_text = esc_html(get_option($lang . '_first_section_button_text'));
    $first_section_button_link = esc_url(get_option($lang . '_first_section_button_link'));
?>
<section id="main-banner" class="bg-image-1 d-flex flex-column justify-content-center">
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2><?php echo $first_section_title; ?></h2>
                <p><?php echo $first_section_subtitle; ?></p>
                <a href="<?php echo $first_section_button_link; ?>" class="btn btn-primary btn-lg"><?php echo $first_section_button_text; ?> <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Section 2 -->
<section id="search-bvs" class="d-flex align-items-center">
    <!-- Section 1.5 -->
    <aside id="main-cards" class="cards-floating">
        <div class="container">
            <div class="row text-center flex-nowrap overflow-auto">
                <?php
                    $page_map_nes_link = esc_url(get_option($lang . '_page_map_nes_link'));
                    $page_members_link = esc_url(get_option($lang . '_page_members_link'));
                ?>
                <div class="col-10 col-sm-6 col-md-3">
                    <a href="<?php echo $page_map_nes_link; ?>" class="card">
                        <div class="card-body">
                            <div class="bg-icon"><img src="<?php echo get_template_directory_uri(); ?>/inc/assets/imgs/icons/map-outline.svg" alt="<?php _e("Icone Mapa NES", "bvs-ecos"); ?>" />
                            </div>
                            <h5 class="card-title"><?php _e("Mapa NES", "bvs-ecos"); ?></h5>
                            <p class="card-text"><?php _e("Núcleos de Economia da Saúde da Rede Ecos", "bvs-ecos"); ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-10 col-sm-6 col-md-3">
                    <a href="<?php echo $page_members_link; ?>" class="card">
                        <div class="card-body">
                            <div class="bg-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/imgs/icons/people-outline.svg" alt="<?php _e("Icone Membros", "bvs-ecos"); ?>" />
                            </div>
                            <h5 class="card-title"><?php _e("Membros", "bvs-ecos"); ?></h5>
                            <p class="card-text"><?php _e("Conheça o perfil de quem faz a Rede Ecos", "bvs-ecos"); ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-10 col-sm-6 col-md-3">
                    <a href="<?php echo home_url(get_option( '_bbp_root_slug', 'forums' )); ?>" class="card">
                        <div class="card-body">
                            <div class="bg-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/imgs/icons/forum-outline.svg" alt="<?php _e("Icone Fóruns Temáticos", "bvs-ecos"); ?>" />
                            </div>
                            <h5 class="card-title"><?php _e("Fóruns Temáticos", "bvs-ecos"); ?></h5>
                            <p class="card-text"><?php _e("Temas relevantes sobre Economia da Saúde", "bvs-ecos"); ?></p>
                        </div>
                    </a>
                </div>
                <div class="col-10 col-sm-6 col-md-3">
                    <a href="<?php echo get_post_type_archive_link('podcast'); ?>" class="card">
                        <div class="card-body">
                            <div class="bg-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/imgs/icons/podcast-outline.svg" alt="<?php _e("Icone Podcasts e Webcasts", "bvs-ecos"); ?>" />
                            </div>
                            <h5 class="card-title"><?php _e("Podcasts e Webcasts", "bvs-ecos"); ?></h5>
                            <p class="card-text"><?php _e("Temas apresentados de forma envolvente", "bvs-ecos"); ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 section-2-content">
                <h2><?php _e("Pesquisa na BVS Ecos", "bvs-ecos"); ?></h2>
                <p><?php _e("Busca em bases de dados especializadas em economia da saúde", "bvs-ecos"); ?></p>

                <div class="form-bg">
                    <?php get_template_part( 'template-parts/form-search-bvs' ); ?>
                </div>
            </div>

            <?php
                $section_2_image_1 = esc_url(get_option($lang . '_section_2_image'));
                $section_2_button_text_1 = esc_html(get_option($lang . '_section_2_button_text'));
                $section_2_button_link_1 = esc_url(get_option($lang . '_section_2_button_link'));

                $section_2_image_2 = esc_url(get_option($lang . '_section_2_image_2'));
                $section_2_button_text_2 = esc_html(get_option($lang . '_section_2_button_text_2'));
                $section_2_button_link_2 = esc_url(get_option($lang . '_section_2_button_link_2'));
            ?>
            <div class="col-lg-6">
                <div class="row justify-content-center">

                    <?php if(!empty($section_2_image_1) && !empty($section_2_button_text_1)){ ?>
                    <div class="col-6 col-md-6 col-lg-4 section-2-secondary-content">
                        <a href="<?php echo $section_2_button_link_1; ?>">
                            <div class="img-section-2" style="background-image: url('<?php echo $section_2_image_1; ?>');"></div>
                        </a>
                        <a href="<?php echo $section_2_button_link_1; ?>">
                            <p>                            
                                <?php echo $section_2_button_text_1; ?>                            
                            </p>
                        </a>
                    </div>                    
                    <?php } 
                    if(!empty($section_2_image_2) && !empty($section_2_button_text_2)){ ?>
                    <div class="col-6 col-md-6 col-lg-4 section-2-secondary-content">
                        <a href="<?php echo $section_2_button_link_2; ?>">
                            <div class="img-section-2" style="background-image: url('<?php echo $section_2_image_2; ?>');"></div>
                        </a>
                        <a href="<?php echo $section_2_button_link_2; ?>">
                            <p>                            
                                <?php echo $section_2_button_text_2; ?>                            
                            </p>
                        </a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 3 -->
<?php
    $section_3_title = esc_html(get_option($lang . '_section_3_title'));
    $section_3_subtitle = esc_html(get_option($lang . '_section_3_subtitle'));
    $section_3_description = esc_html(get_option($lang . '_section_3_description'));
    $section_3_button_text = esc_html(get_option($lang . '_section_3_button_text'));
    $section_3_button_link = esc_url(get_option($lang . '_section_3_button_link'));

    $section_3_img_src = esc_url(get_option($lang . '_section_3_image'));
    $section_3_img_link = esc_url(get_option($lang . '_section_3_image_link'));
?>
<section id="section-network" class="bg-section-3">
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="section-3-content">
            <div class="row">
                <div class="text-content col-lg-7">
                    <h2><?php echo $section_3_title; ?></h2>
                    <p class="lead"><?php echo $section_3_subtitle; ?></p>
                    <p><?php echo $section_3_description; ?></p>
                    <a href="<?php echo $section_3_button_link; ?>" class="btn btn-primary btn-lg">
                        <?php echo $section_3_button_text; ?> <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            <?php if(!empty($section_3_img_src)){ ?>
                <div class="image-content col-lg-5">
                    <a href="<?php echo $section_3_img_link; ?>">
                        <img src="<?php echo $section_3_img_src; ?>" alt="<?php echo $section_3_title; ?>" class="img-fluid" />
                    </a>

                    <a href="<?php echo $section_3_button_link; ?>" class="btn btn-primary btn-lg">
                        <?php echo $section_3_button_text; ?> <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
            
        </div>
    </div>
</section>

<!-- Section 4 -->
<section id="section-news">
    <div class="container">
        <h2 class="title-section"><?php _e("Notícias", "bvs-ecos"); ?></h2>
        <h3 class="subtitle-section"><?php _e("Mantenha-se atualizado com as notícias de economia da saúde", "bvs-ecos"); ?></h3>
        <div class="row">
        <?php
        $new_query = new WP_Query( array(
            'posts_per_page' => 3,
            'post_type'      => 'post',
            'paged'          => 1,
            'category_name'  => 'noticias',
        ) );
                
        while( $new_query->have_posts() ){
            $new_query->the_post();
            
            get_template_part( 'template-parts/items/item-news', 'home' );

        }
        wp_reset_postdata(); 
        ?>
            

        </div>
        <div class="row see-more">
            <div class="col-md-12 text-center">
                <p><?php _e("Veja mais notícias", "bvs-ecos"); ?> <a href="<?php echo get_post_type_archive_link('post'); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
                </p>
            </div>
        </div>

    </div>
</section>

<!-- Section 5 -->
<section id="section-schedule">
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="section-5-content">
            <h2><?php _e("Atualize a sua agenda", "bvs-ecos"); ?></h2>
            <div class="row">
                <div class="col-md-6 courses-schedule">
                    <h3><?php _e("Cursos e Capacitações", "bvs-ecos"); ?></h3>

                    <div class="content-schedule">
                        <?php
                        $new_query = new WP_Query( array(
                            'posts_per_page' => 3,
                            'post_type'      => 'course',
                            'paged'          => 1
                        ) );
                        
                        if($new_query->have_posts()){
                            while( $new_query->have_posts() ){
                                $new_query->the_post(); 
                                
                                get_template_part( 'template-parts/items/item-course', 'home' ); 
                                
                            }
                            wp_reset_postdata();
                        } else{
                            echo '<p>' . __("Nenhum curso encontrado", "bvs-ecos") . '</p>';
                        } ?>
                    </div>
                    
                    <?php if($new_query->found_posts > 0){ ?>
                    <div class="mt-3 see-more">
                        <p><?php _e("Veja todos os cursos", "bvs-ecos"); ?> 
                        <a href="<?php echo get_post_type_archive_link('course'); ?>" class="btn btn-icon btn-primary">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        </p>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-6 next-events-schedule">
                    <h3><?php _e("Próximos Eventos", "bvs-ecos"); ?></h3>
                    
                    <div class="content-schedule" id="event-items-container">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <!-- Os itens dos eventos serão carregados aqui via AJAX -->
                    </div>

                    <div id="see-more-events-grid" class="mt-3 see-more" style="display: none;">
                        <p><?php _e("Veja todos os eventos", "bvs-ecos"); ?> 
                            <a href="<?php echo esc_url(get_base_url_direve()); ?>" class="btn btn-icon btn-primary">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section 6 -->
<?php get_template_part( 'template-parts/newsletter' ); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Faz a requisição AJAX
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            method: 'POST',
            data: {
                action: 'get_event_items_direve',
                limit: 3
            },
            success: function(response) {
                $('#event-items-container').html(response);

                if($('#event-items-container .item-schedule').length){
                    $('#see-more-events-grid').show();
                }
            },
            error: function() {
                $('#event-items-container').html('<p><?php _e("Erro ao carregar os eventos.", "bvs-ecos"); ?></p>');
            }
        });
    });
</script>

<?php get_footer(); ?>