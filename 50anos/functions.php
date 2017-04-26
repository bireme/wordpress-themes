<?php
/**
 *
 *
 *
 */

/* Remove a barra de Administração, com isso remove também a margin de 32px que ele insere no html*/ 
add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Section01', 'textdomain' ),
        'id'            => 'section-1',
        'description'   => __( 'Widgets aparecem na Primeira sessão do HotSite - Recomenda-se colocar depoimentos | Títulos não aparecem!', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="no-display">',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section02', 'textdomain' ),
        'id'            => 'section-2',
        'description'   => __( 'Widgets aparecem na Segunda sessão do HotSite - Cada Widget ocupa 50% da largura página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section03', 'textdomain' ),
        'id'            => 'section-3',
        'description'   => __( 'Widgets aparecem na Terceira sessão do HotSite - Cada Widget ocupa 100% da largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-12 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section04', 'textdomain' ),
        'id'            => 'section-4',
        'description'   => __( 'Widgets aparecem na Quarta sessão do HotSite - Cada Widget ocupa 50% da largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section05', 'textdomain' ),
        'id'            => 'section-5',
        'description'   => __( 'Widgets aparecem na Quarta sessão do HotSite - Cada Widget ocupa 50% a largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Footer', 'textdomain' ),
        'id'            => 'footer',
        'description'   => __( 'Widgets aparecem no rodapé do HotSite - Cada Widget ocupa 25% a largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="no-display">',
        'after_title'   => '</h2>',
    ) );
	}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );

if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 450, 250, true ); // default Post Thumbnail dimensions (cropped)

    // additional image sizes
    // delete the next line if you do not need additional image sizes
    add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
}
/**
 * RElated Videos Widget
 */
class relatedVideos_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function relatedVideos_widget() {
        parent::WP_Widget(false, $name = 'Videos Relacionados Widget');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $video_slug 	= $instance['video_slug'];
		$baseUrl = get_bloginfo( 'url' );
		$url	=	"$baseUrl/category/$video_slug";
		$url_link	=	"<a href='$url' alt='$video_slug'>";
        $close_link	=	"</a>";
        ?>
              <?php echo $before_widget; 
                        echo $before_title .$url_link . $title . $close_link . $after_title; ?>
					        	<!--?php query_posts("category_name=$video_slug"); ?-->
						<script>
							videoR = new Array(255);
							var xR = 0;
						</script>
						<?php
						 $countR=0;
						 ?>
						<!-- loop -->
						<?php query_posts("category_name=$video_slug"); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                    	<?php 
	                    		$countR++;
								$videoR[$countR]= get_field( "video_relacionado" );
								//echo $video[$count];
							?>
							<script>
								xR++;
								videoR[xR]="<? echo $videoR[$countR];?>";
								//document.write("JSVariavel - "+video[x]+"<br />")
							</script>
						 <?php endwhile; else: ?>
						 <?php endif; ?>
						<!-- video para troca -->
						<script language="javascript" type="text/javascript">
						var nextR=2;
						var previousR = xR;
						//x++;
						var lastR=xR;
						lastR--;
						//document.write(previous);
						//document.write(x);
						function nextVideoR(resultadoR){
							var idVideoR = nextR;
							var previousVideoR = previousR;
							++nextR;
							//previousVideo--;
							embedCodR= videoR[idVideoR];
							previousR=idVideoR;
							previousR--;
							if (previousR<1)
							  {
							  	previousR=xR;
							  }
							if (nextR>xR)
							  {
							  	nextR=1;
							  }
							  
							//document.getElementById("resultado").innerHTML = "Anterior="+previous+" Atual="+idVideo+" Proximo="+next+" --- Total="+x+"";
							document.getElementById("resultadoR").innerHTML = "<iframe class='video' src='https://www.youtube.com/embed/" + embedCodR +"?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>";
							//self.scrollTo(0,0);
						}
						function previousVideoR(resultadoR){
								var idVideoR = previousR;
								previousR--;
								embedCodR= videoR[idVideoR];
								nextR=idVideoR;
								nextR++;
								//next=previous;
								//var idVideo = previous;
								//--previous;
								if (previousR<1)
								  {
								  	previousR=x;
								  }
								if (nextR>xR)
								  {
								  	nextR=1;
								  }
								//document.getElementById("resultado").innerHTML = "Anterior="+previous+" Atual="+idVideo+" Proximo="+next+" --- Total="+x+"";
								//document.getElementById("resultado").innerHTML = embedCod;
								document.getElementById("resultadoR").innerHTML = "<iframe class='video' src='https://www.youtube.com/embed/" + embedCodR +"?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>";
								//self.scrollTo(0,0);
							}
						</script>
						
						<button id="previousVideoR" class="previous_btn btn btn-default" onclick="previousVideoR(previousR);">
							<div class="fa fa-fw fa-angle-left"></div>
						</button>
						<button id="nextVideoR" class="next_btn btn btn-default" onclick="nextVideoR(nextR);">
							<div class="fa fa-fw fa-angle-right"></div>	
						</button>
						<div id="videoCode" class="youtube_video">
							<div id="resultadoR">
								<script>
									var StartR = videoR[1];
									//document.write(Start);				
									document.write("<iframe class='video' src='https://www.youtube.com/embed/" + StartR +"?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>" );				
								</script>	
							</div>
						</div>
						<?php wp_reset_query(); ?>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['video_slug'] = strip_tags($new_instance['video_slug']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $video_slug	= esc_attr($instance['video_slug']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('video_slug'); ?>"><?php _e('Categoria dos Vídeos'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('video_slug'); ?>" name="<?php echo $this->get_field_name('video_slug'); ?>" type="text" value="<?php echo $video_slug; ?>" />
        </p>
        <?php 
    }
 
 
} // end class relatedVideos_widget
add_action('widgets_init', create_function('', 'return register_widget("relatedVideos_widget");'));

/**
 * Testimonial Videos Widget
 * Exibe depoimentos em vídeo
 */
class testimonialVideos_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function testimonialVideos_widget() {
        parent::WP_Widget(false, $name = 'Testimonial Video Widget');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $testimonialVideo_slug 	= $instance['video_slug'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
                        <script>
							video= new Array(255);
							var x = 0;
						</script>
						<?php
						 $count=0;
						 ?>
						<!-- loop -->
						<?php query_posts("post_type=testimonial&testimonial_category=$testimonialVideo_slug"); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                    	<?php 
	                    		$count++;
								$video[$count]= get_field( "youtube_video_code" );
								//echo $video[$count];
							?>
							<script>
								x++;
								video[x]="<? echo $video[$count];?>";
								//document.write("JSVariavel - "+video[x]+"<br />")
							</script>
						 <?php endwhile; else: ?>
						 <?php endif; ?>
						<!-- video para troca -->
						<script language="javascript" type="text/javascript">
						var next=2;
						var previous = x;
						//x++;
						var last=x;
						last--;
						//document.write(previous);
						//document.write(x);
						function nextVideo(resultado){
							var idVideo = next;
							var previousVideo = previous;
							++next;
							//previousVideo--;
							embedCod= video[idVideo];
							previous=idVideo;
							previous--;
							if (previous<1)
							  {
							  	previous=x;
							  }
							if (next>x)
							  {
							  	next=1;
							  }
							  
							//document.getElementById("resultado").innerHTML = "Anterior="+previous+" Atual="+idVideo+" Proximo="+next+" --- Total="+x+"";
							document.getElementById("resultado").innerHTML = "<iframe class='video' src='https://www.youtube.com/embed/" + embedCod +"?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>";
							//self.scrollTo(0,0);
						}
						function previousVideo(resultado){
								var idVideo = previous;
								previous--;
								embedCod= video[idVideo];
								next=idVideo;
								next++;
								//next=previous;
								//var idVideo = previous;
								//--previous;
								if (previous<1)
								  {
								  	previous=x;
								  }
								if (next>x)
								  {
								  	next=1;
								  }
								//document.getElementById("resultado").innerHTML = "Anterior="+previous+" Atual="+idVideo+" Proximo="+next+" --- Total="+x+"";
								//document.getElementById("resultado").innerHTML = embedCod;
								document.getElementById("resultado").innerHTML = "<iframe class='video' src='https://www.youtube.com/embed/" + embedCod +"?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>";
								//self.scrollTo(0,0);
							}
						</script>
						
						<button id="previousVideo" class="previous_btn btn btn-default" onclick="previousVideo(previous);">
							<div class="fa fa-fw fa-angle-left"></div>
						</button>
						<button id="nextVideo" class="next_btn btn btn-default" onclick="nextVideo(next);">
							<div class="fa fa-fw fa-angle-right"></div>	
						</button>
						<div id="videoCode" class="youtube_video">
							<div id="resultado">
								<script>
									var Start = video[1];
									//document.write(Start);				
									document.write("<iframe class='video' src='https://www.youtube.com/embed/" + Start +"?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>" );				
								</script>	
							</div>
						</div>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['video_slug'] = strip_tags($new_instance['video_slug']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $video_slug	= esc_attr($instance['video_slug']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('video_slug'); ?>"><?php _e('Categoria dos Vídeos'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('video_slug'); ?>" name="<?php echo $this->get_field_name('video_slug'); ?>" type="text" value="<?php echo $video_slug; ?>" />
        </p>
        <?php 
    }
 
 
} // end class testimonialVideos_widget
add_action('widgets_init', create_function('', 'return register_widget("testimonialVideos_widget");'));

/**
 * Testimonial Slider
 * Exibe depoimentos em Slider
 */
class testimonialSlider_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function testimonialSlider_widget() {
        parent::WP_Widget(false, $name = 'Testimonial Slider');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $category_slug 	= $instance['category_slug'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
						    <div class="resCarousel" data-items="1,1,1,1" data-slide="1">
						        <div class="resCarousel-inner" >
						        	<?php query_posts("post_type=testimonial&testimonial_category=$category_slug"); ?>
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						                <div class="item testimonial_slider">
						                	<div class="texto_depoimento">
						                		
							                	<span class="message">
							                		<?php the_excerpt();?>
							                	</span>
						                    	<span class="author_name text-right"><?php echo get_post_meta(get_the_ID(), 'testimonial_client_name', true);?></span>
						                    	<span class="author_channel text-right"><?php echo get_post_meta(get_the_ID(), 'testimonial_client_company_name', true);?></span>
						                	</div>
						                </div>
									 <?php endwhile; else: ?>
									 <?php endif; ?>
						        </div>
						        <button class='btn btn-default leftLst leftTestimonial'><div class="fa fa-fw fa-angle-left"></div></button>
								<button class='btn btn-default rightLst rightTestimonial'><div class="fa fa-fw fa-angle-right"></div></button>
						    </div>
							<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/carousel.css" rel="stylesheet" type="text/css">
							<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/resCarousel.js"></script>		
								
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category_slug'] = strip_tags($new_instance['category_slug']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $category_slug	= esc_attr($instance['category_slug']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('category_slug'); ?>"><?php _e('Categoria dos Depoimentos'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('category_slug'); ?>" name="<?php echo $this->get_field_name('category_slug'); ?>" type="text" value="<?php echo $category_slug; ?>" />
        </p>
        <?php 
    }
 
 
} // end class testimonialSlider_widget
add_action('widgets_init', create_function('', 'return register_widget("testimonialSlider_widget");'));
?>