<?php
// Widget Slider by Category Posts
/* 
*/

class My_Widget_Slider_Categories extends WP_Widget {

    function My_Widget_Slider_Categories() {
        $widget_ops = array( 'classname' => 'widget_slider_categories', 'description' => __( "Slider de posts feito em Bootstrap por categoria" ) );
        $this->WP_Widget('my_categories', __('Home Slider Category Widget'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title']);
        $category_slug = $instance['category_slug'];
        $x_posts = $instance['x_posts'];

        echo $before_widget;
?>	
	
		<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
			<?php 
				query_posts( array(
					'category_name'  => $category_slug,
					'posts_per_page' => $x_posts
				) );
				$num_posts=0;
				if ( have_posts() ) : while ( have_posts() ) : the_post();
			?>
			  <li data-target="#carouselIndicators" data-slide-to="<? echo $num_posts;?>"></li>
			<?php
				$num_posts ++;
			?>
			
			<?php endwhile; endif; ?>
			</ol>
			
			<div class="carousel-inner" role="listbox">
			<?php 
				$active="active";
				$default_image = "/images/default01.jpg";
			?>
			<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<?php 
				if ( has_post_thumbnail() ) {
					?>
					<div class="carousel-item <?php echo $active; ?>" style="background-image: url('<?php the_post_thumbnail_url( 'slider' ); ?>')">
					<?
					} 
					else {
						?>
					<div class="carousel-item <?php echo $active; ?>" style="background-image: url('<?php echo get_bloginfo( 'stylesheet_directory' );?>/images/default01.jpg')">
						<?
					}
				?>
					<div class="carousel_highlight">
						<span class=""><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></span>
					</div>
				</div>
				<?php 
					$active="zero";
				?>
			<?php endwhile; endif; ?>		
				
			</div>
			<a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	<?php wp_reset_postdata();
	
       echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category_slug'] = strip_tags($new_instance['category_slug']);
        $instance['x_posts'] = strip_tags($new_instance['x_posts']);

        return $instance;
    }

    function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = esc_attr( $instance['title'] );
        $category_slug = esc_attr( $instance['category_slug'] );
        $x_posts = esc_attr( $instance['x_posts'] );
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>Configure a categoria de posts para aparecer no slide</br>
		Exemplo: <i>destaques</i></br>
        <label for="<?php echo $this->get_field_id('category_slug'); ?>"><?php _e( 'Category Slug:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('category_slug'); ?>" name="<?php echo $this->get_field_name('category_slug'); ?>" type="text" value="<?php echo $category_slug; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('x_posts'); ?>"><?php _e( 'Número de Posts: (Min=1 - Max=5)' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('x_posts'); ?>" name="<?php echo $this->get_field_name('x_posts'); ?>" type="text" value="<?php echo $x_posts; ?>" /></p>
		
<?php
    }

}

add_action('widgets_init', create_function('', "register_widget('My_Widget_Slider_Categories');"));


?>