<?php
// Widget News Home by Category
/* 
*/

class SESSP_Widget_News_Categories extends WP_Widget {

    function SESSP_Widget_News_Categories() {
        $widget_ops2 = array( 'classname' => 'widget_news_categories', 'description' => __( "Widget com posts por Categrias" ) );
        $this->WP_Widget('level_categories', __('Home News Category Widget'), $widget_ops2);
    }

    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title']);
        $category_slug = $instance['category_slug'];
        $x_posts = $instance['x_posts'];

        echo $before_widget;
?>
		<!-- HTML -->
		<div class="container">
			<div class="row news_highlight">
				<?	
					// Pega a quantidade de posts definida no plugin e divide pelas 12 colunas
					// o resultado é classe utilizada para manter o layout *bootstrap
					// col-md-1 - col-md-2 - col-md-3 - col-md-4 
					$md = (int)(12 / $x_posts);
					//Looop Wordpress com definições do plugin
					query_posts( array(
						'category_name'  => $category_slug,
						'posts_per_page' => $x_posts
					) );
				?>
				<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="col-md-12 col-lg-<? echo $md;?> col-xl-<? echo $md;?>">
					<div class="thumbnail">
					  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php 
						if ( has_post_thumbnail() ) {
							?>
							<img src="<?php the_post_thumbnail_url( 'news'); ?>" alt="<?php the_title(); ?>" style="width:100%">
							<?
							} 
							else {
								?>
							<img src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/images/default_news.jpg" alt="<?php the_title(); ?>" style="width:100%">
								<?
							}
						?>
						<div class="caption">
						  <p><?php the_title(); ?></p>
						</div>
					  </a>
					</div>
				</div>
				<?php endwhile; endif; ?>
			</div>
		</div>
		<!-- /HTML -->
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
		
		<p><label for="<?php echo $this->get_field_id('x_posts'); ?>"><?php _e( 'Número de Posts: (Min=2 - Max=6)' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('x_posts'); ?>" name="<?php echo $this->get_field_name('x_posts'); ?>" type="text" value="<?php echo $x_posts; ?>" /></p>
		
<?php
    }

}

add_action('widgets_init', create_function('', "register_widget('SESSP_Widget_News_Categories');"));


?>