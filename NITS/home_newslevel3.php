<?php
// Widget News Home by Category Level 3

class SESSP3_widget_news3_categories extends WP_Widget {

    // Use __construct for the widget class constructor
    function __construct() {
        $widget_ops2 = array( 
            'classname' => 'widget_news3_categories', 
            'description' => __( "Widget com posts por Categorias level 3" ) 
        );
        parent::__construct('level3_categories', __('Home News Category Level 3 Widget'), $widget_ops2);
    }

    // Define the widget output
    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title']);
        $category_slug = $instance['category_slug'];
        $x_posts = $instance['x_posts'];

        echo $before_widget;
?>
        <!-- HTML for your widget output -->
        <div class="container">
            <div class="Highlight-level3">
                <div class="row">
                    <h2><?php echo $title ?></h2>
                </div>
                <?php
                // Looop Wordpress com definições do plugin
                query_posts( array(
                    'category_name'  => $category_slug,
                    'posts_per_page' => $x_posts
                ));

                if (have_posts()) {
                    while (have_posts()) : the_post();
                        // Display posts here
                    endwhile;
                }
                ?>
            </div>
        </div>
<?php
        echo $after_widget;
    }

    // Optionally: Form and update functions if your widget has options
}

