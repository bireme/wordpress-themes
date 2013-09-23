<?php

/**
 * Registra os widgets personalizados
 * 
 */
function panamazonica_register_widgets() {
	
	register_widget( 'Widget_Acontece_Rede' );
	register_widget( 'Widget_Documentos' );
	register_widget( 'Widget_Agenda' );
	register_widget( 'Widget_Usuarios_Grupo' );
	register_widget( 'Widget_Recent_Posts' );
	
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
}

add_action( 'widgets_init', 'panamazonica_register_widgets' );


/**
 * Widget Acontece na Rede
 *
 */
class Widget_Acontece_Rede extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Widget_Acontece_Rede() {	
		$widget_ops = array( 'classname' => 'widget_acontece_rede', 'description' => __( 'Display the latest posts from all Network',  'panamazonica' ) );
		$this->WP_Widget( 'widget_acontece_rede', __( 'Network Now', 'panamazonica' ), $widget_ops );
		$this->alt_option_name = 'widget_acontece_rede';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		global $wpdb, $blog_id;
		
		$cache = wp_cache_get( 'widget_acontece_rede', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __('Latest news', 'panamazonica') : $instance['title'], $instance, $this->id_base );

		// Número de posts
		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '3';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 3;
 		
 		// Parâmetros iniciais
 		$args = array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $number,
			'post_status' 		=> 'publish',
		);
		
		
 		if ( $blog_id > 1 ) {
 		
 			$current_blog = $blog_id;
 			
 			$args['meta_query'] = array(
 				array(
 					'key'		=> '_original_blog_id',
 					'value'		=> $current_blog,
 					'compare'	=> '!='
 				)
 			);
 			
 			switch_to_blog(1);
 			
 		}
		
		// Excluindo na mão os posts destaque. Definir uma front page, por exemplo, já muda a main query
		if ( $blog_id == 1 && ( is_front_page() || is_home() ) )
		{
	    	$exclude = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_home' AND meta_value = '1'" );
	    	$args['post__not_in'] = $exclude;
	    }
	    
		$acontece_rede = new WP_Query( $args );
	
		if ( $acontece_rede->have_posts() ) :
			echo $before_widget;
			
			echo $before_title;
			echo $title;
			echo $after_title;
	    	
	    	while ( $acontece_rede->have_posts() ) : $acontece_rede->the_post();
	    	?>
	        <article>				        	
	        	<h2 class="entry-title">
	        		<a href="<?php the_permalink(); ?>">
	        			<?php the_title(); ?>
	        			
	        			<small>
	        			<?php
	        			$original_blog_id = ( $original_ids = panamazonica_get_original_ids() ) ? $original_ids['blog_id'] : 1;
	        			
	        			/* translators: author and blog name (example: Por Leonardo em Telessaúde) */
		        		printf( __( 'By %1$s in %2$s', 'panamazonica' ), get_the_author(), get_blog_details( $original_ids['blog_id'] )->blogname );
	        			?>
	        			</small>
	        		</a>
	        	</h2>				        	
	        </article>	
			<?php
			endwhile;
		
			// Final do widget
			echo $after_widget;

			// Reinicia o postdata
			wp_reset_postdata();
		
		endif; // if ( have_posts() )
		
		restore_current_blog();

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_acontece_rede', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_acontece_rede'] ) )
			delete_option( 'widget_acontece_rede' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_acontece_rede', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		?>
		
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'panamazonica' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts:', 'panamazonica' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		
	<?php
	}
}


/**
 * Widget dos Documentos
 *
 */
class Widget_Documentos extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Widget_Documentos() {
		$widget_ops = array( 'classname' => 'widget_documentos', 'description' => __( 'Display the latest Documents',  'panamazonica' ) );
		$this->WP_Widget( 'widget_documentos', __( 'Documents', 'panamazonica' ), $widget_ops );
		$this->alt_option_name = 'widget_documentos';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_documentos', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __('Published Documents', 'panamazonica') : $instance['title'], $instance, $this->id_base );

		// Número de posts
		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '3';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 3;
		
		$args = array(
			'post_type'			=> 'documento',
			'posts_per_page'	=> $number,
			'post_status' 		=> 'publish'
		);
		
		$documentos = new WP_Query( $args );
	
		if ( $documentos->have_posts() ) :
			echo $before_widget;
			
			echo $before_title;
			echo '<a href="' . get_post_type_archive_link( 'documento' ) . '" title="' . __('See all Published Documents', 'panamazonica') . '">' . $title . '</a>';
			echo $after_title;
		
			while ( $documentos->have_posts() ) : $documentos->the_post(); ?>
    	
			<article>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
						<?php if ( $autor = panamazonica_get_documento_meta( '_pan_autor' ) ) : ?><small><?php printf( __( 'By %s', 'panamazonica' ), $autor ); ?></small><?php endif; ?>
					</a>
					
				</h2>
			</article>
		    	
			<?php endwhile; ?>
			
			<a href="<?php echo get_post_type_archive_link( 'documento' ); ?>" class="read-more"><?php _e('See all Published Documents', 'panamazonica'); ?></a>
			
			<?php
			// Final do widget
			echo $after_widget;

			// Reinicia o postdata
			wp_reset_postdata();
		
		endif; // if ( have_posts() )

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_documentos', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_documentos'] ) )
			delete_option( 'widget_documentos' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_documentos', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		?>
		
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'panamazonica' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of documents:', 'panamazonica' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		
	<?php
	}
}


/**
 * Widget da Agenda
 *
 * Mostra tanto os eventos quanto as reuniões
 *
 */
class Widget_Agenda extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Widget_Agenda() {
		$widget_ops = array( 'classname' => 'widget_agenda', 'description' => __( 'Display the group Agenda',  'panamazonica' ) );
		$this->WP_Widget( 'widget_agenda', __( 'Agenda', 'panamazonica' ), $widget_ops );
		$this->alt_option_name = 'widget_agenda';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		global $post;
		
		$cache = wp_cache_get( 'widget_agenda', 'widget' );
		

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Agenda' : $instance['title'], $instance, $this->id_base );

		// Número de posts
		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '3';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 3;
		
		$args = array(
			'post_type'			=> 'agenda',
			'posts_per_page'	=> $number,
			'post_status' 		=> 'publish'
		);
		
		$args_evento = array_merge( $args, array( 'agenda_tipo' => 'evento' ) );
		$args_reuniao = array_merge( $args, array( 'agenda_tipo' => 'reuniao' ) );
		
		$eventos = new WP_Query( $args_evento );
		$reunioes = new WP_Query( $args_reuniao );
		
		echo $before_widget; ?>
		
		<div class="tabs-agenda">
		    <ul>
		        <li><a href="#eventos"><?php _e( 'Events', 'panamazonica' ); ?></a></li>
		        <li><a href="#reunioes"><?php _e( 'Meetings', 'panamazonica' ); ?></a></li>
		    </ul>
		
		    <?php if ( $eventos->have_posts() ) : ?>
		    <div id="eventos">
			    <?php while ( $eventos->have_posts() ) : $eventos->the_post(); ?>
				<article>
					<h2 class="entry-title"> 
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
							<small><?php echo panamazonica_get_agenda_date( $post->ID ); ?></small>
						</a>
					</h2>
				</article>
				<?php endwhile; ?>
		    </div><!-- /eventos -->
			<?php endif; ?>
				
			<?php if ( $reunioes->have_posts() ) : ?>
		    <div id="reunioes">
			    <?php while ( $reunioes->have_posts() ) : $reunioes->the_post(); ?>
				<article>
					<h2 class="entry-title"> 
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
							<small><?php echo panamazonica_get_agenda_date( $post->ID ); ?></small>
						</a>
					</h2>
				</article>
				<?php endwhile; ?>
		    </div><!-- /eventos -->
			<?php endif; ?>	
			
			<a href="<?php echo get_post_type_archive_link( 'agenda' ); ?>" class="read-more"><?php _e( 'See the Agenda', 'panamazonica' ); ?></a>
			<?php
			// Reinicia o postdata
			wp_reset_postdata();
		
			?>
			
		</div><!-- /tabs-agenda -->		
		
		<?php
		// Final do widget
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_agenda', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_agenda'] ) )
			delete_option( 'widget_agenda' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_agenda', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		?>
		
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'panamazonica' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of events:', 'panamazonica' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		
	<?php
	}
}


/**
 * Widget dos Usuários
 *
 */
class Widget_Usuarios_Grupo extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function widget_usuarios_grupo() {
		$widget_ops = array( 'classname' => 'widget_usuarios_grupo', 'description' => __( 'Display the users',  'panamazonica' ) );
		$this->WP_Widget( 'widget_usuarios_grupo', __( 'Group Users', 'panamazonica' ), $widget_ops );
		$this->alt_option_name = 'widget_usuarios_grupo';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_usuarios_grupo', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Usuários' : $instance['title'], $instance, $this->id_base );

		// Número de posts
		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '4';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 4;
		
		$args = array(
			//'blog_id' => $GLOBALS['blog_id'],
			'role' => '',
			'meta_key' => '',
			'meta_value' => '',
			'meta_compare' => '',
			'meta_query' => array(),
			'include' => array(),
			'exclude' => array(),
			'orderby' => 'display_name',
			'order' => 'ASC',
			'offset' => '',
			'search' => '',
			'number' => $number,
			'count_total' => false,
			'fields' => 'all',
			'who' => 'authors'
		 );
		 
		$usuarios = get_users( $args );
		
		if ( $usuarios ) :
		
			echo $before_widget;
			
			echo $before_title;
			echo $title;
			echo $after_title;
			
			echo '<ul>';
		
			foreach( $usuarios as $usuario ) :
				$usermeta = get_userdata( $usuario->ID );
				?>
				<li>
					<a href="<?php echo get_author_posts_url( $usuario->ID ); ?>" title="<?php echo $usermeta->display_name; ?>">
						<?php echo get_avatar( $usuario->ID, 70 ); ?>
						<span class="nome-usuario"><?php echo $usermeta->display_name; ?></span>
					</a>
				</li>
				<?php
			endforeach;
			
			echo '</ul>';
		
			// Final do widget
			echo $after_widget;
		
		endif; // if ( have_posts() )

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_usuarios_grupo', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_usuarios_grupo'] ) )
			delete_option( 'widget_usuarios_grupo' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_usuarios_grupo', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		?>
		
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'panamazonica' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of users:', 'panamazonica' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		
	<?php
	}
}

/**
 * Recent_Posts widget class extended for Rede Panamazônica
 *
 */
class Widget_Recent_Posts extends WP_Widget {

        function __construct() {
                $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
                parent::__construct('recent-posts', __('Recent Posts'), $widget_ops);
                $this->alt_option_name = 'widget_recent_entries';

                add_action( 'save_post', array($this, 'flush_widget_cache') );
                add_action( 'deleted_post', array($this, 'flush_widget_cache') );
                add_action( 'switch_theme', array($this, 'flush_widget_cache') );
        }

        function widget($args, $instance) {
                $cache = wp_cache_get('widget_recent_posts', 'widget');

                if ( !is_array($cache) )
                        $cache = array();

                if ( ! isset( $args['widget_id'] ) )
                        $args['widget_id'] = $this->id;

                if ( isset( $cache[ $args['widget_id'] ] ) ) {
                        echo $cache[ $args['widget_id'] ];
                        return;
                }

                ob_start();
                extract($args);
                
                $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
                if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
                        $number = 10;
                $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

                $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
                if ($r->have_posts()) :
?>
                <?php echo $before_widget; ?>
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                <ul>
                <?php while ( $r->have_posts() ) : $r->the_post();   ?>
                        <li>
                                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?>
                                	<small><?php printf( __( 'By %s', 'panamazonica' ), get_the_author() ); ?></small>
                                </a>
                                
                        <?php if ( $show_date ) : ?>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                        </li>
                <?php endwhile; ?>
                </ul>
                <?php echo $after_widget; ?>
<?php
                // Reset the global $the_post as this query will have stomped on it
                wp_reset_postdata();

                endif;

                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set('widget_recent_posts', $cache, 'widget');
        }

        function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['number'] = (int) $new_instance['number'];
                $instance['show_date'] = (bool) $new_instance['show_date'];
                $this->flush_widget_cache();

                $alloptions = wp_cache_get( 'alloptions', 'options' );
                if ( isset($alloptions['widget_recent_entries']) )
                        delete_option('widget_recent_entries');

                return $instance;
        }

        function flush_widget_cache() {
                wp_cache_delete('widget_recent_posts', 'widget');
        }

        function form( $instance ) {
                $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
                $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
                $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
                <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

                <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
                <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

                <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
        }
}
?>
