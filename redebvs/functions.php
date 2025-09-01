<?php
/*
Tema Portal de Rede da BVS
*/
/**
 * Widget BreadCrumb do Portal da Rede BVS
 * Exibe uma breadcrumb personalizada do portal da rede BVS
 */
class breadcrumb_widget extends WP_Widget {

    /** Constructor - Corrected */
    function __construct() {
        parent::__construct(
            'breadcrumb_widget', // Widget ID
            __('BreadCrumb do Portal da Rede BVS', 'text_domain'), // Widget name
            array('description' => __('Displays the breadcrumb of the network', 'text_domain')) // Widget options
        );
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        extract($args);
        if (function_exists('portal_breadcrumb')) { 
            portal_breadcrumb(); 
        }
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
        ?>
        <p>
            Exibe a breadcrumb da Rede <br>
            Displays the breadcrumb of the network<br>
            Muestra la breadcrumb de la red
        </p>
        <?php
    }
} // end class breadcrumb_widget

// Register the widget
add_action('widgets_init', function() {
    register_widget('breadcrumb_widget');
});


// breadcrumb portal da rede bvs 
function portal_breadcrumb() { ?>
		<div class="breadcrumb breadcrumb-rede">
				 <?php if ( is_multisite() ) { 
					switch_to_blog(1);
					$site_title = get_bloginfo( 'name' );
					$site_url = network_site_url( '/' );
					restore_current_blog();
					echo "<span class='multisiteName'>";
					echo "<a href='$site_url' class='section'>$site_title </a>"; 
					echo "<i class='fa fa-angle-double-right' aria-hidden='true'></i>"; 
					echo "</span>";
					} 
				 ?> 
				<?php
				if ( is_home() ) { ?>
					<span class="active section"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span>
				<?php } else { ?>
					<a href="<?php echo esc_attr( get_bloginfo( 'wpurl', 'display' ) ); ?>" class="section"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
					<?php 
						if( is_page() ) { 
							global $post;
								/* Get an array of Ancestors and Parents if they exist */
							$parents = get_post_ancestors( $post->ID );
								/* Get the top Level page->ID count base 1, array base 0 so -1 */ 
							$postid = get_the_ID();
							$id = ($parents) ? $parents[count($parents)-1]: $post->ID;
							/* Get the parent and set the $class with the page slug (post_name) */
								$parent = get_post( $id );
								$parent_page = $parent->post_title;
								//$parent_slug = $parent->post_name;
								$parent_url = esc_attr( get_bloginfo( 'wpurl', 'display' ) ) . "/" . $parent->post_name;
								if ($postid != $id){
									echo "<a href='$parent_url'>";
									echo $parent_page;
									echo " <i class='fa fa-angle-double-right' aria-hidden='true'></i>";
									echo "</a>";
								}
						}
					?>
					<span class="active section"><?php the_title(); ?></span>
				<?php }
				?>
		</div>
<?php }


// Hotjar no tema filho (insere dentro de <head> via wp_head)
function redbvs_add_hotjar_tag() {
  // Evita carregar no admin e, se quiser, para administradores logados
  if ( is_admin() ) return;
  if ( current_user_can('manage_options') ) return;

  // OPCIONAL: desabilitar em ambiente de desenvolvimento
  // if ( defined('WP_ENV') && WP_ENV !== 'production' ) return;

  ?>
  <!-- Hotjar Tracking Code -->
  <script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid: SEU_ID_AQUI, hjsv: 6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
  </script>
  <?php
}
add_action('wp_head', 'redbvs_add_hotjar_tag', 20);


?>
