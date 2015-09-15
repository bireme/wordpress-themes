<?php

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_theme_support( 'post-thumbnails' );
// add_filter( 'pre_option_link_manager_enabled', '__return_true' );

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    add_image_size('enfermeria-highlights', 260, 150, true);
}

// config parameters
$top_sidebar = true;
$footer_sidebar = true;
$mlf_activate = false;
$total_columns = 2;

// languages
$mlf_options = get_option('mlf_config');
$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);

if ($current_language != ''){
   $current_language = '_' . $current_language;
}

if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
    $mlf_activate = true;
}
$variables_mlf = array (
            'header' => "header",
            'top_sidebar' => "top_sidebar",
            'footer_sidebar' => "footer_sidebar",
            'footer' => "footer",
            'level2' => "level2",
        );
if($mlf_activate) {
    foreach ($variables_mlf as $vmlf) {
        $variables_mlf [$vmlf] = $vmlf . $current_language;
    }
}

register_nav_menu( 'menu', 'Menu' );

// sidebars do template
register_sidebar( array(
    'name' => __('Header','vhl'),
    //'id' => 'header' . $current_language,
    'id' => $variables_mlf['header'],
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

// SIDEBARS
//SideBar Auxiliar Top só aparece se ativado
if ($top_sidebar == true){
    register_sidebar( array(
    'name' => __('Top Auxiliary SideBar','vhl'),
    //'id' => 'top_sidebar' . $current_language,
    'id' => $variables_mlf['top_sidebar'],
    'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}
// gerando as sidebars dinamicamente
for($i=1; $i <= $total_columns; $i++) {
    $column = "column-" . $i;
    if($mlf_activate) {
      $column .= $current_language;
    }
    register_sidebar( array(
    'name' => __('Column', 'vhl') . ' ' . $i,
    //'id' => 'column-' . $i . $current_language,
    'id' => $column,
    'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );

}
//SideBar Auxiliar Footer só aparece se ativado
if ($footer_sidebar == true){
    register_sidebar( array(
    'name' => __('Footer Auxiliary SideBar','vhl'),
    //'id' => 'footer_sidebar' . $current_language,
    'id' => $variables_mlf['footer_sidebar'],
    'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

register_sidebar( array(
    'name' => __('Footer','vhl'),
    //'id' => 'footer' . $current_language,
    'id' => $variables_mlf['footer'],
    'description' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

register_sidebar( array(
    'name' => __('Level 2','vhl'),
    //'id' => 'level2' . $current_language,
    'id' => $variables_mlf['level2'],
    'description' => 'Widgets que aparecerão em segundo nível',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<strong class="widget-title">',
    'after_title' => '</strong>',
) );

add_action( 'init', 'wp_bvs_enfermeria_admin_init' );
add_action( 'admin_menu', 'wp_bvs_enfermeria_settings_page_init' );

function wp_bvs_enfermeria_admin_init() {
    global $palettes_configs;
    $settings = get_option("wp_bvs_enfermeria_settings");
    $palettes = get_option("wp_bvs_palettes_settings");
    if ( empty( $settings ) ) {
        $settings = $default_settings;
        add_option( "wp_bvs_enfermeria_settings", $settings, '', 'yes' );
    }
    if ( empty( $palettes ) ) {
        $palettes = $palettes_configs;
        add_option( "wp_bvs_palettes_settings", $palettes, '', 'yes' );
    }
}

function wp_bvs_enfermeria_settings_page_init() {
    $settings_page = add_theme_page( __('Theme Options','vhl'), __('Theme Options', 'vhl'), 'edit_theme_options', 'theme-settings', 'wp_bvs_enfermeria_settings_page' );
    add_action( "load-{$settings_page}", 'wp_bvs_enfermeria_load_settings_page' );
}

function wp_bvs_enfermeria_load_settings_page() {

    if ( $_POST["wp_bvs-enfermeria-submit"] == 'Y' ) {
        check_admin_referer( "wp_bvs-enfermeria-page" );
        wp_bvs_enfermeria_save_theme_settings();
        $url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
        wp_redirect(admin_url('themes.php?page=theme-settings&'.$url_parameters));
        exit;
    }
}

function wp_bvs_enfermeria_save_theme_settings() {

    $settings = get_option("wp_bvs_enfermeria_settings");

    $settings['iahx_url'] = $_POST['iahx_url'];
    $settings['header'] = $_POST['header'];
    
    update_option( "wp_bvs_enfermeria_settings", $settings );
}

function wp_bvs_enfermeria_settings_page() {

    global $site_lang;
    
    $settings = get_option( "wp_bvs_enfermeria_settings" );
    $theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
    $header = $settings['header'];

    ?>

    <style type="text/css">
        #imgLoading1, #imgLoading2, #imgLoading3 {
            display: none;
            position: absolute;
            padding: 5px;
        }
        #poststuff h3.title {
            font-size: 125%;
            font-family: "Open Sans", sans-serif;
            text-transform: uppercase;
            text-decoration: underline;
        }
    </style>

    <div class="wrap">
        <h2><?php echo __('Theme Options','vhl'); ?></h2>

        <?php
            if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>' . __('Theme options updated','vhl') . '</p></div>';
        ?>

        <div id="poststuff">
            <form method="post" action="<?php admin_url( 'themes.php?page=theme-settings' ); ?>">
                <?php wp_nonce_field( "wp_bvs-enfermeria-page" ); ?>

                <?php 
                // print '<pre>'; var_dump($settings); 
                ?>

                <table class="form-table permalink-structure">
                    <tbody>
                        <tr>
                            <th><?= __('iAHx URL', 'vhl') ;?></th>
                            <td><input type="text" name="iahx_url" value="<?php echo $settings['iahx_url'] ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><hr/></td>
                        </tr>
                        <tr>
                            <th></th>
                            <th><?php echo __('Image URL','vhl');?></th>
                            <th><?php echo __('Link','vhl');?></th>
                        </tr>
                        <tr>
                            <th><label><?php echo strtoupper(__('Logo','vhl'));?></label></th>
                            <td><input id="header[logo-<?php echo $site_lang; ?>]" name="header[logo-<?php echo $site_lang; ?>]" placeholder="<?php echo __('Paste the URL','vhl');?>" type="text" class="regular-text code header-logo" value="<?php echo esc_html( stripslashes( $header["logo-" . $site_lang] ) ); ?>"></td>
                            <td><input id="header[linkLogo-<?php echo $site_lang; ?>]" name="header[linkLogo-<?php echo $site_lang; ?>]" placeholder="<?php echo __('Paste the link','vhl');?>" type="text" class="regular-text code header-logo-link" value="<?php echo esc_html( stripslashes( $header["linkLogo-" . $site_lang] ) ); ?>"><br/></td>
                        </tr>
                        <tr>
                            <td colspan="3"><hr/></td>
                        </tr>
                        <tr>
                            <th></th>
                            <th><?php echo __('Image URL','vhl');?></th>
                            <th><?php echo __('Link','vhl');?></th>
                        </tr>
                        <tr>
                            <th><label><?php echo strtoupper(__('Banner','vhl'));?></label></th>
                            <td><input id="header[banner-<?php echo $site_lang; ?>]" name="header[banner-<?php echo $site_lang; ?>]" placeholder="<?php echo __('Paste the URL','vhl');?>" type="text" class="regular-text code header-banner" value="<?php echo esc_html( stripslashes( $header["banner-" . $site_lang] ) ); ?>"></td>
                            <td><input id="header[bannerLink-<?php echo $site_lang; ?>]" name="header[bannerLink-<?php echo $site_lang; ?>]" placeholder="<?php echo __('Paste the link','vhl');?>" type="text" class="regular-text code header-banner-link" value="<?php echo esc_html( stripslashes( $header["bannerLink-" . $site_lang] ) ); ?>"></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><input id="header[title_view]" name="header[title_view]" type="checkbox" class="" value="true" <?php if($header['title_view'] == 'true') { echo "checked"; } ?> > <?php echo __('Check to display title on banner','vhl');?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>




                <p class="submit" style="clear: both;">
                    <input type="submit" name="Submit"  class="button-primary" value="<?php echo __('Update'); ?>" onclick="document.getElementById('imgLoading3').style.display='inline'" />
                    <input type="hidden" name="wp_bvs-enfermeria-submit" value="Y" />
                    <span id="imgLoading3"><img src="<?php echo get_template_directory_uri() . '/bireme_archives/default/load.gif' ?>"/></span>
                </p>
            </form>

        </div>

    </div>
<?php
}