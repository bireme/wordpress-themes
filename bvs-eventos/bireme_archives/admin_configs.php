<?php 
    $current_language = strtolower(get_bloginfo('language'));
    $site_lang = substr($current_language, 0,2);

    $settings = get_option( "wp_bvs_theme_settings" );
    $layout = $settings['layout'];
    $header = $settings['header'];
    $colors = $settings['colors'];
    $total_columns = $layout['total'];
    $languages = $header['language'];//$settings['header'][language];
    $title = $header['title_view'];//$settings['header'][title_view];
    $logo = $header['logo-'.$site_lang];//$settings['header']['logo'];
    $linkLogo = $header['linkLogo-'.$site_lang];    
    $header_banner = $header['banner-'.$site_lang];
    $bannerLink = $header['bannerLink-'.$site_lang];
    $contactPage = $header['contactPage'];
    $general_background = $colors['general-background'];//$settings['colors']['general-background'];
    $general_container = $colors['general-container'];//$settings['colors']['general-container'];
    $general_title_first = $colors['general-title-first'];//$settings['colors']['general-title-first'];
    $general_title_second = $colors['general-title-second'];//$settings['colors']['general-title-second'];
    $general_title_third = $colors['general-title-third'];//$settings['colors']['general-title-third'];
    $general_background_img = $layout['background'];//$settings['layout']['background'];
    $general_color = $colors['general-text'];//$settings['colors']['general-text'];
    $general_link_active = $colors['general-link-active'];//$settings['colors']['general-link-active'];
    $general_link_visited = $colors['general-link-visited'];//$settings['colors']['general-link-visited'];
    $header_background_color = $colors['header-background'];//$settings['colors']['header-background']; 
    $header_title_color = $colors['header-title-frist'];//$settings['colors']['header-title-first'];
    $header_link_color = $colors['header-link-active'];//$settings['colors']['header-link-active'];
    $top_sidebar = $layout['top-sidebar'];//$settings['layout']['top-sidebar'];
    $footer_sidebar = $layout['footer-sidebar'];//$settings['layout']['footer-sidebar'];
    $language_position = $header['language-position'];//$settings['header']['language-position'];
?>

<link rel='stylesheet' id='generic_css'  href='<?php echo get_template_directory_uri(); ?>/bireme_archives/css/generic.css' type='text/css' media='all' />
<link rel='stylesheet' id='columns'  href='<?php echo get_template_directory_uri(); ?>/bireme_archives/css/<?php echo $total_columns; ?>_columns.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/bireme_archives/custom/custom.css' type='text/css' media='all' />

<style>
    body {
        background: #<?php echo $general_background;?> !important;  
        color: #<?php echo $general_color;?>;
        background-image: url('<?php echo $general_background_img;?>') !important;
        background-position: top center !important;
    }
    a {
        color: #<?php echo $general_link_active;?>;     
        }
    a:visited {
        color: #<?php echo $general_link_visited;?>;        
        }
    .container {
        background: #<?php echo $general_container;?> !important;   
    }
    .bar a {
        color: #<?php echo $header_link_color;?>;   
    }
    .header {
        background: <?php if($header_background_color) echo '#' . $header_background_color;?> url(<?php echo $header_banner;?>)top left no-repeat;    
    }
    .header h1 a {
        color: #<?php echo $header_title_color;?>;
    }
    #content h1, .content h1 a {
        color: #<?php echo $general_title_first;?> !important;
    }
    #content h2, .content h2 a {
        color: #<?php echo $general_title_second;?> !important;
    }
    #content h3, .content h3 a {
        color: #<?php echo $general_title_third;?> !important;
    }
<?php 
    if ($language_position == 2) {
?>
    .bar {
        margin-top: 96px;
        position: absolute;
        width: 1000px;  
    }
<?php
    }
?>          
</style>