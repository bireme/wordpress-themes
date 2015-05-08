<?php
/**
 * Settings Theme Page
 */

require_once(dirname(__FILE__) . "/default.php");
include(TEMPLATEPATH . "/bireme_archives/palettes.php");

add_action( 'init', 'wp_bvs_admin_init' );
add_action( 'admin_menu', 'wp_bvs_settings_page_init' );

function wp_bvs_admin_init() {
    global $palettes_configs;
	$settings = get_option("wp_bvs_theme_settings");
    $palettes = get_option("wp_bvs_palettes_settings");
	if ( empty( $settings ) ) {
		$settings = $default_settings;
		add_option( "wp_bvs_theme_settings", $settings, '', 'yes' );
	}
    if ( empty( $palettes ) ) {
        $palettes = $palettes_configs;
        add_option( "wp_bvs_palettes_settings", $palettes, '', 'yes' );
    }
}

function wp_bvs_settings_page_init() {
	$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
	$settings_page = add_theme_page( __('Theme Options','vhl'), __('Theme Options', 'vhl'), 'edit_theme_options', 'theme-settings', 'wp_bvs_settings_page' );
	add_action( "load-{$settings_page}", 'wp_bvs_load_settings_page' );
}

function wp_bvs_load_settings_page() {

	if ( $_POST["wp_bvs-settings-submit"] == 'Y' ) {
		check_admin_referer( "wp_bvs-settings-page" );
		wp_bvs_save_theme_settings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('themes.php?page=theme-settings&'.$url_parameters));
		exit;
	}
}

function wp_bvs_save_theme_settings() {

	global $pagenow;
	$settings = get_option("wp_bvs_theme_settings");
    $palettes = get_option("wp_bvs_palettes_settings");

	if ($pagenow == 'themes.php' && $_GET['page'] == 'theme-settings'){

		if ( isset ( $_GET['tab'] ) )
	        $tab = $_GET['tab'];
	    else
			$tab = "layout";


	    switch ( $tab ){

			case 'header' :
				$settings['header']  = $_POST['header'];
			break;

			case 'colors' :
				if($_POST['colors']['palette'] == "bireme_default") {

                    $settings['colors'] = $palettes["bireme_default"];
                    $settings['colors'] = array( "palette" => "bireme_default" ) + $settings['colors'];

                } else {

					if($_POST['submit-palette'] == "Y") {

                        $settings['colors'] = $palettes[$_POST['colors']['palette']];
                        $settings['colors'] = array( "palette" => $_POST['colors']['palette'] ) + $settings['colors'];

					} elseif($_POST['submit-palette'] == "R") {

                        $settings['colors'] = $palettes["bireme_default"];
                        $settings['colors'] = array( "palette" => $_POST['colors']['palette'] ) + $settings['colors'];
                        $palettes[$_POST['colors']['palette']] = $palettes["bireme_default"];


					} else {

                       $settings['colors'] = $_POST['colors'];
                       unset($_POST['colors']['palette']);
                       $palettes[$settings['colors']['palette']] = $_POST['colors'];

					}
                }
			break;

			case 'layout' :
				$settings['layout'] = $_POST['layout'];
			break;
	    }
	}

	if( !current_user_can( 'unfiltered_html' ) ){
		if ( $settings['wp_bvs_ga']  )
			$settings['wp_bvs_ga'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['wp_bvs_ga'] ) ) );
		if ( $settings['wp_bvs_intro'] )
			$settings['wp_bvs_intro'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['wp_bvs_intro'] ) ) );
		if ( $settings['wp_bvs_BVSLogo'] )
			$settings['wp_bvs_BVSLogo'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['wp_bvs_BVSLogo'] ) ) );
		if ( $settings['wp_bvs_BVSBanner'] )
			$settings['wp_bvs_BVSBanner'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['wp_bvs_BVSBanner'] ) ) );
	}
	
    update_option( "wp_bvs_theme_settings", $settings );
    update_option( "wp_bvs_palettes_settings", $palettes );
}

function wp_bvs_admin_tabs( $current = 'layout' ) {

    $tabs = array('header' => __('Header','vhl'), 'colors' => __('Colors','vhl'), 'layout' => __('Layout','vhl') );
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=theme-settings&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}

function wp_bvs_settings_page() {
	global $pagenow;
	$settings = get_option( "wp_bvs_theme_settings" );
	$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
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

			if ( isset ( $_GET['tab'] ) ) wp_bvs_admin_tabs($_GET['tab']); else wp_bvs_admin_tabs('layout');
		?>

		<div id="poststuff">
			<form method="post" action="<?php admin_url( 'themes.php?page=theme-settings' ); ?>">
				<?php
				wp_nonce_field( "wp_bvs-settings-page" );

				if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ){

					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
					else $tab = 'homepage';

					echo '<table class="form-table">';
					switch ( $tab ){
						case 'header' : include(TEMPLATEPATH . "/bireme_archives/admin/header.php"); break;
						case 'colors' : include(TEMPLATEPATH . "/bireme_archives/admin/colors.php"); break;
						case 'layout': default: include(TEMPLATEPATH . "/bireme_archives/admin/layout.php"); break;

					}
					echo '</table>';
				}
				?>
				<p class="submit" style="clear: both;">
					<input type="submit" name="Submit"  class="button-primary" value="<?php echo __('Update'); ?>" onclick="document.getElementById('imgLoading3').style.display='inline'" />
					<input type="hidden" name="wp_bvs-settings-submit" value="Y" />
					<span id="imgLoading3"><img src="<?php echo get_template_directory_uri() . '/bireme_archives/default/load.gif' ?>"/></span>
				</p>
			</form>

		</div>

	</div>
<?php
}
