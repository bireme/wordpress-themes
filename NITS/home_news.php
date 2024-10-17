<?php
// Widget News Home by Category

class SESSP_Widget_News_Categories extends WP_Widget {

    // Use __construct for the widget class constructor
    function __construct() {
        $widget_ops2 = array( 
            'classname' => 'widget_news_categories', 
            'description' => __( "Widget com posts por Categrias" ) 
        );
        parent::__construct('level_categories', __('Home News Category Widget'), $widget_ops2);
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
            <div class="row news_highlight">
                <?php
                // Your widget's custom logic here
                $md = (int)(12 / $x_posts);
                // More HTML and PHP logic to display posts by category
                ?>
            </div>
        </div>
<?php
        echo $after_widget;
    }

    // Optionally: Form and update functions if your widget has options
}

