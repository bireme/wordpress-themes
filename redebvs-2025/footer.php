<?php
/**
 * Footer do tema – modelo BVS
 */
?>
        <footer id="site-footer" class="bvs-footer">
            <style>
                .bvs-footer {
                    background-color: #00205C;
                    color: #ffffff;
                    margin-top: 40px;
                    font-size: 13px;
                    line-height: 1.5;
                }

                .bvs-footer a {
                    color: #ffffff;
                    text-decoration: none;
                }

                .bvs-footer a:hover {
                    text-decoration: underline;
                }

                .bvs-footer-inner {
                    max-width: 1180px;
                    margin: 0 auto;
                    padding: 0;
                }

                /* Topo com logo/box + texto */
                .bvs-footer-top {
                    padding: 32px 0 24px;
                }

                .bvs-footer-top-row {
                    display: flex;
                    gap: 32px;
                    align-items: flex-start;
                }

                .bvs-footer-logo-box {
                    background-color: #ffffff;
                    color: #003c80;
                    padding: 16px 24px;
                    min-width: 220px;
                    display: inline-block;
                    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.04);
                    font-size: 14px;
                    font-weight: 600;
                    text-align: left;
                }

                .bvs-footer-logo-box img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                }

                .bvs-footer-description {
                    color: #fff;
                    flex: 1;
                    font-size: 16px;
                    max-width: 760px;
                }
                .bvs-footer-description p{
                    color:#fff !important;
                }

                /* Linha divisória entre topo e colunas */
                .bvs-footer-divider {
                    border-top: 1px solid #fff;
                    margin-top: 24px;
                }

                /* Colunas de menus (dinâmico por pais com filhos) */
                .bvs-footer-menus {
                    padding: 24px 0 28px;
                }

                .bvs-footer-menus-row {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                    gap: 32px;
                }

                .bvs-footer-menu-column-title {
                    font-size: 18px;
                    font-weight: 600;
                    margin-bottom: 6px;
                }

                .bvs-footer-menu-list {
                    list-style: disc;
                    padding-left: 16px;
                    margin: 0;
                }

                .bvs-footer-menu-list li {
                    margin-bottom: 2px;
                }

                .bvs-footer-menu-list li a {
                    font-size: 16px;
                    color: #e5efff;
                }

                .bvs-footer-menu-list li a:hover {
                    color: #ffffff;
                }

                /* Barra "Powered by" */
                .bvs-footer-powered-wrap {
                    padding: 0;
                    text-align: center;
                }

                .bvs-footer-powered {
                    display: inline-block;
                    font-size: 11px;
                    color: #d0e1ff;
                    margin-top: 15px;
                    margin-bottom: 15px;
                }

                /* Barra de créditos inferior */
                .bvs-footer-bottom {
                    background-color: #3D5162;
                    text-align: center;
                    padding: 6px 0 8px;
                    font-size: 11px;
                    color: #d0e1ff;
                }

                /* Responsivo */
                @media (max-width: 960px) {
                    .bvs-footer-top-row {
                        flex-direction: column;
                        align-items: stretch;
                    }
                    .bvs-footer-logo-box {
                        max-width: 260px;
                    }
                }

                @media (max-width: 600px) {
                    .bvs-footer {
                        font-size: 12px;
                    }
                }
            </style>

            <?php
            // pega texto + logo + copyright dinamicamente por idioma
            $bvs_footer_text = function_exists( 'rede_bvs_get_footer_text' ) ? rede_bvs_get_footer_text() : '';
            $bvs_footer_logo = function_exists( 'rede_bvs_get_footer_logo_url' ) ? rede_bvs_get_footer_logo_url() : '';
            $bvs_footer_copy = function_exists( 'rede_bvs_get_footer_copyright' ) ? rede_bvs_get_footer_copyright() : '© Todos os direitos são reservados';

            // 1 menu footer por idioma
            $footer_menu_id  = function_exists('rede_bvs_get_footer_menu_id_current') ? rede_bvs_get_footer_menu_id_current() : 0;

            // monta colunas: "pais com filhos"
            $footer_columns = array(); // [parent_id => ['title' => '', 'children' => [item, item...]]]

            if ( $footer_menu_id ) {
                $items = wp_get_nav_menu_items( $footer_menu_id );

                if ( ! empty($items) && ! is_wp_error($items) ) {
                    $children_map = array();
                    foreach ($items as $it) {
                        $parent_id = (int) $it->menu_item_parent;
                        if ( $parent_id > 0 ) {
                            if ( ! isset($children_map[$parent_id]) ) $children_map[$parent_id] = array();
                            $children_map[$parent_id][] = $it;
                        }
                    }

                    // colunas = TODO TOP-LEVEL (com filhos OU sozinho)
                    foreach ($items as $it) {
                        $id     = (int) $it->ID;
                        $is_top = ((int)$it->menu_item_parent === 0);

                        if ( $is_top ) {
                            $has_children = ! empty($children_map[$id]);

                            $footer_columns[$id] = array(
                                'title'    => $it->title,
                                'url'      => $it->url,
                                'children' => $has_children ? $children_map[$id] : array(),
                            );
                        }
                    }
                }
            }
            ?>

            <div class="bvs-footer-top">
                <div class="bvs-footer-inner">
                    <div class="bvs-footer-top-row">
                        <div class="bvs-footer-logo-box">
                            <?php if ( ! empty( $bvs_footer_logo ) ) : ?>
                                <img
                                    src="<?php echo esc_url( $bvs_footer_logo ); ?>"
                                    alt="<?php esc_attr_e( 'Portal da Rede BVS', 'rede-bvs' ); ?>"
                                >
                            <?php else : ?>
                                Portal da Rede BVS
                            <?php endif; ?>
                        </div>

                        <div class="bvs-footer-description">
                            <?php
                            if ( ! empty( $bvs_footer_text ) ) {
                                echo wp_kses_post( wpautop( $bvs_footer_text ) );
                            } else {
                                echo wp_kses_post( wpautop( 'A BVS é um produto colaborativo, coordenado pela BIREME/OPAS/OMS. Como biblioteca, oferece acesso abrangente à informação científica e técnica em saúde. A BVS coleta, indexa e armazena citações de documentos publicados por diversas organizações. A inclusão de qualquer artigo, documento ou citação na coleção da BVS não implica endosso ou concordância da BIREME/OPAS/OMS com o seu conteúdo.' ) );
                            }
                            ?>
                        </div>
                    </div>
                    <div class="bvs-footer-divider"></div>
                </div>
            </div>

            <?php if ( ! empty($footer_columns) ) : ?>
                <div class="bvs-footer-menus">
                    <div class="bvs-footer-inner">
                        <div class="bvs-footer-menus-row">

                            <?php foreach ( $footer_columns as $col ) : ?>
                                <div class="bvs-footer-menu-column">
                                    <div class="bvs-footer-menu-column-title">
                                        <?php echo esc_html( $col['title'] ); ?>
                                    </div>

                                    <ul class="bvs-footer-menu-list">
                                        <?php if ( ! empty( $col['children'] ) ) : ?>
                                            <?php foreach ( $col['children'] as $child ) : ?>
                                                <li>
                                                    <a href="<?php echo esc_url( $child->url ); ?>">
                                                        <?php echo esc_html( $child->title ); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <li>
                                                <a href="<?php echo esc_url( $col['url'] ); ?>">
                                                    <?php echo esc_html( $col['title'] ); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="bvs-footer-powered-wrap">
                <div class="bvs-footer-inner" style="border-top: 1px solid #fff;">
                    <div class="bvs-footer-powered">
                        <img
                            src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/powered.png' ); ?>"
                            alt="<?php esc_attr_e('Portal da Rede BVS', 'rede-bvs'); ?>"
                        >
                    </div>
                </div>
            </div>

            <div class="bvs-footer-bottom">
                <?php echo wp_kses_post( $bvs_footer_copy ); ?>
            </div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
