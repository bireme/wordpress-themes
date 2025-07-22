<?php

function frontpage_settings_scripts() {
    if ( is_admin() ) {
        $file_dir = get_template_directory_uri();
        
        wp_enqueue_style( 'adm-bvs-ecos-bootstrap-css', get_template_directory_uri() . '/inc/assets/libs/bootstrap-5.3.3/css/bootstrap.min.css' );
        wp_enqueue_style( 'adm-bvs-ecos-fontawesome-css', get_template_directory_uri() . '/inc/assets/libs/fontawesome-6.6.0/css/all.min.css' );
        wp_enqueue_script('adm-bvs-ecos-popper', get_template_directory_uri() . '/inc/assets/libs/bootstrap-5.3.3/js/popper.min.js', array(), '2.11.8', true );
        wp_enqueue_script('adm-bvs-ecos-bootstrapjs', get_template_directory_uri() . '/inc/assets/libs/bootstrap-5.3.3/js/bootstrap.min.js', array(), '5.3.3', true );

        // Image uploader requires these files
        wp_enqueue_media();
    }
}

add_action('admin_menu', 'custom_frontpage_settings_menu');
function custom_frontpage_settings_menu() {
    // Add a new menu item to the WordPress admin sidebar
    $menu = add_menu_page(
        __("Configurações Página Inicial", "bvs-ecos"),        // Page title
        __("Página Inicial", "bvs-ecos"),        // Menu title
        'manage_options',             // Capability required to see the menu
        'frontpage-settings',         // Menu slug (used in the URL)
        'custom_frontpage_settings_page', // Function to display the page
        'dashicons-schedule',    // Menu icon
        3                          // Menu position
    );

    add_action( 'admin_print_styles-' . $menu, 'frontpage_settings_scripts' );
}

function custom_frontpage_settings_page() {
    // Check if the current user has permission to manage options
    if (!current_user_can('manage_options')) {
        return;
    }

    $lang = get_current_language(); // Get the current language

    // Check if the form was submitted
    if (isset($_POST['save-frontpage-settings'])) {
        // Check if footer description is empty
        if (empty($_POST[$lang . '_footer_description'])) {
            echo '<div class="notice notice-error is-dismissible"><p>' . __("Atenção o campo de Descrição do Rodapé esta vazio.", "bvs-ecos") . '</p></div>';
        }

        $count = 0;
        // Loop through each POST request field and save the values
        foreach ($_POST as $key => $value) {
            if ($key != 'save-frontpage-settings') {
                if (update_option($key, $value)) {
                    $count++;
                }
            }
        }

        // Display success message or no changes made
        if ($count > 0) {
            echo '<div class="notice notice-success is-dismissible"><p>' . __("Alterações salvas com sucesso.", "bvs-ecos") . '</p></div>';
        } else {
            echo '<div class="notice notice-info is-dismissible"><p>' . __("Nenhuma alteração feita.", "bvs-ecos") . '</p></div>';
        }
    }

    $url_img_info = get_template_directory_uri() . '/inc/assets/imgs/infos-frontpage/';
    ?>

    <!-- Configuration form for the front page section -->
    <div class="wrap">
        <?php if(empty($lang)){ ?>
            <h1><?php _e("Configurações Página Inicial", "bvs-ecos"); ?></h1>
            <h5 class="text-danger"><?php _e( "Selecione o idioma no menu superior.", "bvs-ecos" ); ?></h5>
        <?php } else{ ?>
            <h1><?php _e("Configurações Página Inicial", "bvs-ecos"); ?></h1>
            <form method="POST" class="row">
                <!-- BEGIN: section 1 -->
                <h3><?php _e("Seção 1 - Banner", "bvs-ecos"); ?></h3>
                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_first_section_title">
                        <?php _e("Título:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section1-title.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_first_section_title" value="<?php echo esc_attr(get_option($lang . '_first_section_title')); ?>" class="form-control" required />
                </div>

                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_first_section_subtitle">
                        <?php _e("Subtítulo:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section1-subtitle.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_first_section_subtitle" value="<?php echo esc_attr(get_option($lang . '_first_section_subtitle')); ?>" class="form-control" required />
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_first_section_button_text">
                        <?php _e("Texto do Botão:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section1-btn.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_first_section_button_text" value="<?php echo esc_attr(get_option($lang . '_first_section_button_text')); ?>" class="form-control" required />
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_first_section_button_link">
                        <?php _e("Link do Botão:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section1-btn.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_first_section_button_link" value="<?php echo esc_attr(get_option($lang . '_first_section_button_link')); ?>" class="form-control" required />
                </div>
                <!-- END: section 1 -->


                <!-- BEGIN: section 1.5 - Cards -->
                <h3><?php _e("Seção 1.5 - Cards", "bvs-ecos"); ?></h3>

                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_page_map_nes_link">
                        <?php _e("Link da Página do Mapa NES:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'card-map-nes.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_page_map_nes_link" value="<?php echo esc_attr(get_option($lang . '_page_map_nes_link')); ?>" class="form-control" required />
                </div>

                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_page_members_link">
                        <?php _e("Link da Página de Membros:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'card-members.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_page_members_link" value="<?php echo esc_attr(get_option($lang . '_page_members_link')); ?>" class="form-control" required />
                </div>
                <!-- END: section 1.5 - Cards -->



                <!-- BEGIN: section 2 -->
                <h3><?php _e("Seção 2 - Pesquisa", "bvs-ecos"); ?></h3>
                <!-- link pesquisa avançada -->
                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_2_link_advanced_search">
                        <?php _e("Link Pesquisa Avançada:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info . 'section2-link-advanced-search.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_link_advanced_search" value="<?php echo esc_attr(get_option($lang . '_section_2_link_advanced_search')); ?>" class="form-control" />
                </div>

                <!-- botao 1 -->
                <div class="row">
                    <div class="col-md-6 grid-form-group">
                        <label for="<?php echo esc_attr($lang); ?>_section_2_image">
                            <?php _e("Imagem lateral 1:", "bvs-ecos"); ?>
                            <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section2-img-1.jpg'; ?>"></i>
                        </label>            

                        <?php $thumb_section_2_src = esc_attr(get_option($lang . '_section_2_image')); ?>
                        <div class="d-block">
                            <img src="<?php echo ($thumb_section_2_src)? $thumb_section_2_src : 'https://placehold.co/600x400'; ?>" alt="thumbnail" class="img-thumbnail" style="max-width: 200px;"/>
                        </div>
                        <div class="input-group">
                            <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_image" value="<?php echo esc_attr(get_option($lang . '_section_2_image')); ?>" class="form-control" />
                            <button class="button btn-upload-file"><?php _e("Upload", "bvs-ecos"); ?></button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_2_button_text">
                        <?php _e("Texto de Chamada 1:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section2-text-1.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_button_text" value="<?php echo esc_attr(get_option($lang . '_section_2_button_text')); ?>" class="form-control" />
                </div>
                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_2_button_link">
                        <?php _e("Link 1:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section2-img-1.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_button_link" value="<?php echo esc_attr(get_option($lang . '_section_2_button_link')); ?>" class="form-control" />
                </div>

                <!-- botao 2 -->
                <div class="row">
                    <div class="col-md-6 grid-form-group">
                        <label for="<?php echo esc_attr($lang); ?>_section_2_image_2">
                            <?php _e("Imagem lateral 2:", "bvs-ecos"); ?>
                            <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info . 'section2-img-2.jpg'; ?>"></i>
                        </label>

                        <?php $thumb_section_2_src = esc_attr(get_option($lang . '_section_2_image_2')); ?>
                        <div class="d-block">
                            <img src="<?php echo ($thumb_section_2_src) ? $thumb_section_2_src : 'https://placehold.co/600x400'; ?>" alt="thumbnail" class="img-thumbnail" style="max-width: 200px;" />
                        </div>
                        <div class="input-group">
                            <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_image_2" value="<?php echo esc_attr(get_option($lang . '_section_2_image_2')); ?>" class="form-control" />
                            <button class="button btn-upload-file"><?php _e("Upload", "bvs-ecos"); ?></button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_2_button_text_2">
                        <?php _e("Texto de Chamada 2:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info . 'section2-text-2.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_button_text_2" value="<?php echo esc_attr(get_option($lang . '_section_2_button_text_2')); ?>" class="form-control" />
                </div>
                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_2_button_link_2">
                        <?php _e("Link 2:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info . 'section2-img-2.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_2_button_link_2" value="<?php echo esc_attr(get_option($lang . '_section_2_button_link_2')); ?>" class="form-control" />
                </div>
                <!-- END: section 2 -->

                <!-- BEGIN: section 3 -->
                <h3><?php _e("Seção 3 - Rede", "bvs-ecos"); ?></h3>
                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_3_title">
                        <?php _e("Título:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-title.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_3_title" value="<?php echo esc_attr(get_option($lang . '_section_3_title')); ?>" class="form-control" required />
                </div>

                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_3_subtitle">
                        <?php _e("Subtítulo:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-subtitle.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_3_subtitle" value="<?php echo esc_attr(get_option($lang . '_section_3_subtitle')); ?>" class="form-control" required />
                </div>

                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_3_description">
                        <?php _e("Descrição:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-description.jpg'; ?>"></i>
                    </label>
                    <textarea name="<?php echo esc_attr($lang); ?>_section_3_description" class="form-control" required><?php echo esc_textarea(get_option($lang . '_section_3_description')); ?></textarea>
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_3_button_text">
                        <?php _e("Texto do Botão:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-btn.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_3_button_text" value="<?php echo esc_attr(get_option($lang . '_section_3_button_text')); ?>" class="form-control" required />
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_3_button_link">
                        <?php _e("Link do Botão:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-btn.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_3_button_link" value="<?php echo esc_attr(get_option($lang . '_section_3_button_link')); ?>" class="form-control" required />
                </div>

                <div class="row">            
                    <div class="col-md-6 grid-form-group">
                        <label for="<?php echo esc_attr($lang); ?>_section_3_image">
                            <?php _e("Imagem lateral:", "bvs-ecos"); ?>
                            <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-img.jpg'; ?>"></i>
                        </label>
                        <?php $thumb_section_3_src = esc_attr(get_option($lang . '_section_3_image')); ?>
                        <div class="d-block">
                            <img src="<?php echo ($thumb_section_3_src)? $thumb_section_3_src : 'https://placehold.co/600x400'; ?>" alt="thumbnail" class="img-thumbnail" style="max-width: 200px;" />
                        </div>
                        <div class="input-group">
                            <input type="text" name="<?php echo esc_attr($lang); ?>_section_3_image" value="<?php echo esc_attr(get_option($lang . '_section_3_image')); ?>" class="form-control" />
                            <button class="button btn-upload-file"><?php _e("Upload", "bvs-ecos"); ?></button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_3_image_link">
                        <?php _e("Link da Imagem:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'section3-img.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_3_image_link" value="<?php echo esc_attr(get_option($lang . '_section_3_image_link')); ?>" class="form-control" />
                </div>
                <!-- END: section 3 -->

                <!-- BEGIN: section newsletter -->
                <h3><?php _e("Seção Newsletter", "bvs-ecos"); ?></h3>
                <p><?php _e("(Deixe os campos em branco para desabilitar esta seção)", "bvs-ecos"); ?></p>
                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_newsletter_title">
                        <?php _e("Título de Chamada:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'newsletter-text.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_newsletter_title" value="<?php echo esc_attr(get_option($lang . '_section_newsletter_title')); ?>" class="form-control" />
                </div>
                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_section_newsletter_shortcode_link">
                        <?php _e("Shortcode do formulário ou Link para uma página:", "bvs-ecos"); ?>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_section_newsletter_shortcode_link" value="<?php echo esc_attr(get_option($lang . '_section_newsletter_shortcode_link')); ?>" class="form-control" />

                    <div class="row mt-2">
                        <?php $type_btn_value = get_option($lang . '_type_btn_newsletter');
                        $default_type_newsletter = (empty($type_btn_value))? 'checked' : ''; ?>
                        <div class="col-auto form-check form-check-inline d-flex align-items-center">
                            <input type="radio" name="<?php echo esc_attr($lang); ?>_type_btn_newsletter" id="type-btn-newsletter-shortcode" value="shortcode" <?php checked( $type_btn_value, 'shortcode' ); ?> required />
                            <label for="type-btn-newsletter-shortcode">Shortcode</label>
                        </div>
                        <div class="col-auto form-check form-check-inline d-flex align-items-center">
                            <input type="radio" name="<?php echo esc_attr($lang); ?>_type_btn_newsletter" id="type-btn-newsletter-link" value="link" <?php checked( $type_btn_value, 'link' ); echo $default_type_newsletter; ?> required />
                            <label for="type-btn-newsletter-link">Link</label>
                        </div>
                    </div>

                </div>
                <!-- END: section newsletter -->

                <!-- BEGIN: Footer Section -->
                <h3><?php _e("Configurações do Rodapé", "bvs-ecos"); ?></h3>
                
                <!-- BEGIN: footer titles -->
                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_footer_title_1">
                        <?php _e("Título 1:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'footer-title-1.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_footer_title_1" value="<?php echo esc_attr(get_option($lang . '_footer_title_1')); ?>" class="form-control" required />
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_footer_title_2">
                        <?php _e("Título 2:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'footer-title-2.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_footer_title_2" value="<?php echo esc_attr(get_option($lang . '_footer_title_2')); ?>" class="form-control" required />
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_footer_subtitle_1">
                        <?php _e("Subtítulo 1:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'footer-subtitle-1.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_footer_subtitle_1" value="<?php echo esc_attr(get_option($lang . '_footer_subtitle_1')); ?>" class="form-control" required />
                </div>

                <div class="col-md-6 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_footer_subtitle_2">
                        <?php _e("Subtítulo 2:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'footer-subtitle-2.jpg'; ?>"></i>
                    </label>
                    <input type="text" name="<?php echo esc_attr($lang); ?>_footer_subtitle_2" value="<?php echo esc_attr(get_option($lang . '_footer_subtitle_2')); ?>" class="form-control" required />
                </div>
                <!-- END: footer titles -->

                <div class="col-md-12 grid-form-group">
                    <label for="<?php echo esc_attr($lang); ?>_footer_description">
                        <?php _e("Descrição:", "bvs-ecos"); ?>
                        <i class="fas fa-info-circle" data-bs-toggle="modal" data-bs-target="#infoModal" data-image="<?php echo $url_img_info .'footer-text.jpg'; ?>"></i>
                    </label>
                    <?php
                    // Add WordPress editor for the footer description
                    wp_editor(
                        stripslashes(htmlspecialchars_decode(get_option($lang . '_footer_description'))), // The value saved in the option
                        $lang . '_footer_description', // The name of the field (with language prefix)
                        array(
                            'textarea_name' => $lang . '_footer_description',
                            'media_buttons' => false, // Allow media uploads
                            'textarea_rows' => 10, // Number of rows in the editor
                            'teeny'         => false, // Full editor
                        )
                    );
                    ?>
                </div>
                <!-- END: Footer Section -->

                <!-- BEGIN: button submit -->
                <div class="col-md-12 grid-form-group text-end">
                    <input type="submit" name="save-frontpage-settings" value="<?php _e("Salvar Alterações", "bvs-ecos"); ?>" class="btn btn-primary" />
                </div>
                <!-- END: button submit -->
            </form>
        <?php } //--- end else ?>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel"><?php _e("Mais Informações", "bvs-ecos"); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        .grid-form-group {
            margin-bottom: 30px;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {
            $('.fas.fa-info-circle').on('click', function() {
                var imageUrl = $(this).data('image');
                $('#modalImage').attr('src', imageUrl);
            });

            $('.btn-upload-file').on('click', function(e) {
                var btn = $(this);

                e.preventDefault();
                var image = wp.media({
                    title: 'Escolha uma Imagem',
                    button: {
                        text: 'Usar esta imagem'
                    },
                    multiple: false
                }).open().on('select', function(e) {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    
                    $(btn).parent().find('input[type="text"]').val(image_url);
                    $(btn).parent().parent().find('.img-thumbnail').attr("src", image_url);
                });
            });
        });
    </script>

    <?php
}
