<?php
// Widget News Home by Category
class SESSP3_widget_news3_categories extends WP_Widget {

    function __construct() {
        parent::__construct(
            'level3_categories', // Base ID
            __('Home News Category Level 3 Widget', 'text_domain'), // Name
            array('description' => __('Widget com posts por Categrias level 3', 'text_domain')) // Args
        );
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
            <div class="Highlight-level3">
                <div class="row">
                    <h2><?php echo $title ?></h2>
                </div>
                <?php
                    // Use WP_Query to fetch posts
                    $query = new WP_Query( array(
                        'category_name'  => $category_slug,
                        'posts_per_page' => $x_posts
                    ) );
                    $position = 'esquerda'; // Define o primeiro post com thumb a esquerda
                ?>
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="row news_level3"><!-- Noticia de Nivel 3 -->
                    <?php 
                    if ($position == 'direita') {
                        $position = 'esquerda';
                    ?>
                    <div class="col-lg-4 thumbnail">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img src="<?php the_post_thumbnail_url( 'news_level_3'); ?>" alt="<?php the_title(); ?>" style="width:100%">
                        </a>
                    </div><!-- /thumbnail -->
                    <div class="col-lg-8">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                        </a>
                    </div><!--/col-md-8-->
                    <?php 
                    } else {
                            $position = 'direita';
                        ?>
                        <div class="col-lg-8">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <h3><?php the_title(); ?></h3>
                                <?php the_excerpt(); ?>
                            </a>
                        </div><!-- /col-lg-8 -->
                        <div class="col-lg-4 thumbnail">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php if (has_post_thumbnail()) { ?>
                                    <img src="<?php the_post_thumbnail_url('news_level_3'); ?>" alt="<?php the_title(); ?>" style="width:100%">
                                <?php } else { ?>
                                    <img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/default_news3.jpg" alt="<?php the_title(); ?>" style="width:100%">
                                <?php } ?>
                                        <!-- other position logic can be added here -->
                    <?php } ?>
                </div>
                <?php endwhile; endif; ?>
            </div> <!-- /Highlight-level3 -->
        </div>
        <!-- /HTML -->
<?php
        wp_reset_postdata();

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
        // Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
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

add_action('widgets_init', function() { register_widget('SESSP3_widget_news3_categories'); });
?>
