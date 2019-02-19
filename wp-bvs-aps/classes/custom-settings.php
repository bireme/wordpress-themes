<?php

$custom_settings = new custom_settings();
 
class custom_settings {

 	function custom_settings(){
 		add_filter( 'admin_init' , array( $this , 'register_fields' ) );
 	}

 	function register_fields(){
 		register_setting( 'general', 'url_video_home', 'esc_attr' );
 		add_settings_field('url_video_home', '<label for="url_video_home">'.__('URL Video Home' , 'bvs_lang').'</label>' , array($this, 'fields_html_url_video') , 'general' ); 		
 	}	

 	function fields_html_url_video(){
 		$value = get_option( 'url_video_home', '' );
 		echo '<input id="url_video_home" name="url_video_home" value="' . $value . '" type="text" size="75">';
 		echo '<p><small>'. __('Digite a URL para o vídeo no YouTube, Vimeo ou DailyMotion', 'bvs_lang') .'.</small></p>';
 	}
}