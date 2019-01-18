<?php

$custom_settings = new custom_settings();
 
class custom_settings {

 	function custom_settings(){
 		add_filter( 'admin_init' , array( $this , 'register_fields' ) );
 	}

 	function register_fields(){
 		register_setting( 'general', 'url_video_home', 'esc_attr' );
 		add_settings_field('url_video_home', '<label for="url_video_home">'.__('URL Video Home' , 'bvs_lang').'</label>' , array($this, 'fields_html_url_video') , 'general' );

 		//order browse sof
 		register_setting( 'general', 'order_browse_sof_categoria', 'esc_attr' );
 		register_setting( 'general', 'order_browse_sof_profissional', 'esc_attr' );
 		register_setting( 'general', 'order_browse_sof_teleconsultor', 'esc_attr' );
 		
 		add_settings_field('order_browse_sof_categoria', '<label for="order_categoria_evidencia">'.__('Ordem Categoria da Evidência' , 'bvs_lang').'</label>' , array($this, 'fields_html_order_browse_sof_categoria') , 'general' );

 		add_settings_field('order_browse_sof_profissional', '<label for="order_profissional">'.__('Ordem Tipo de Profissional' , 'bvs_lang').'</label>' , array($this, 'fields_html_order_browse_sof_profissional') , 'general' );

 		add_settings_field('order_browse_sof_teleconsultor', '<label for="order_teleconsultor">'.__('Ordem Teleconsultor' , 'bvs_lang').'</label>' , array($this, 'fields_html_order_browse_sof_teleconsultor') , 'general' );

 		//labels browse sof
 		register_setting( 'general', 'label_browse_sof_categoria', 'esc_attr' );
 		register_setting( 'general', 'label_browse_sof_profissional', 'esc_attr' );
 		register_setting( 'general', 'label_browse_sof_teleconsultor', 'esc_attr' );

 		add_settings_field('label_browse_sof_categoria', '<label for="label_categoria_evidencia">'.__('Label Categoria da Evidência' , 'bvs_lang').'</label>' , array($this, 'fields_html_label_browse_sof_categoria') , 'general' );

 		add_settings_field('label_browse_sof_profissional', '<label for="label_profissional">'.__('Label Tipo de Profissional' , 'bvs_lang').'</label>' , array($this, 'fields_html_label_browse_sof_profissional') , 'general' );

 		add_settings_field('label_browse_sof_teleconsultor', '<label for="label_teleconsultor">'.__('Label Teleconsultor' , 'bvs_lang').'</label>' , array($this, 'fields_html_label_browse_sof_teleconsultor') , 'general' );
 	}

 	function fields_html_url_video(){
 		$value = get_option( 'url_video_home', '' );
 		echo '<input id="url_video_home" name="url_video_home" value="' . $value . '" type="text" size="75">';
 		echo '<p><small>'. __('Digite a URL para o vídeo no YouTube, Vimeo ou DailyMotion', 'bvs_lang') .'.</small></p>';
 	}

 	function fields_html_order_browse_sof_categoria(){
 		$value = get_option( 'order_browse_sof_categoria', '1' );
 		echo '<input id="order_categoria_evidencia" name="order_browse_sof_categoria" type="number" min="1" max="3" value="'.$value.'" />'; 		 		
 	}

 	function fields_html_order_browse_sof_profissional(){
 		$value = get_option( 'order_browse_sof_profissional', '2' );
 		echo '<input id="order_profissional" name="order_browse_sof_profissional" type="number" min="1" max="3" value="'.$value.'" />';
 	}

 	function fields_html_order_browse_sof_teleconsultor(){
		$value = get_option( 'order_browse_sof_teleconsultor', '3' );
 		echo '<input id="order_teleconsultor" name="order_browse_sof_teleconsultor" type="number" min="1" max="3" value="'.$value.'" />';
 	}

 	function fields_html_label_browse_sof_categoria(){
 		$value = get_option( 'label_browse_sof_categoria', 'Quais as Áreas Temáticas?' );
 		echo '<input id="label_categoria_evidencia" name="label_browse_sof_categoria" type="text" value="'.$value.'" size="50" />';
 	}

 	function fields_html_label_browse_sof_profissional(){
 		$value = get_option( 'label_browse_sof_profissional', 'Quem Perguntou?' );
 		echo '<input id="label_profissional" name="label_browse_sof_profissional" type="text" value="'.$value.'" size="50" />';
 	}

 	function fields_html_label_browse_sof_teleconsultor(){
 		$value = get_option( 'label_browse_sof_teleconsultor', 'Quem Respondeu?' );
 		echo '<input id="label_teleconsultor" name="label_browse_sof_teleconsultor" type="text" value="'.$value.'" size="50" />';
 	}
}