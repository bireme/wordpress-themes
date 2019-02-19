<?php

    if( class_exists('Poll') ) {
        // instantiate the Poll class
        $survey = new Poll();
    }

    class Poll {
        public function __construct() {
            //add_action( 'admin_head', array( __CLASS__, 'yop_polls_custom_actions' ) );
            add_action( $hook = 'add_meta_boxes', array(__CLASS__, $hook) );
            add_action( $hook = 'save_post', array(__CLASS__, $hook) );
            add_action( $hook = 'admin_menu', array(__CLASS__, $hook) );
            add_action( 'admin_head', array(__CLASS__, 'yop_polls_results_ptype' ) );
            add_action( 'wp_enqueue_scripts', array(__CLASS__, 'yop_polls_custom_scripts' ) );
            add_action( 'wp_ajax_yop_poll_do_vote', array(__CLASS__, 'yop_poll_add_post_meta' ), 1 );
            add_action( 'wp_ajax_nopriv_yop_poll_do_vote', array(__CLASS__, 'yop_poll_add_post_meta' ), 1 );
            add_filter( 'the_content', array( __CLASS__, 'remove_yop_poll_from_content' ) );
            add_filter( 'set-screen-option', array( __CLASS__, 'result_ptype_set_screen_option' ), 10, 3);
        }
        
        static function add_meta_boxes() {
            $post_types = get_post_types(array('public' => true));
            foreach ($post_types as $pt) {
                if ($pt == 'attachment') continue;
                add_meta_box('yop_poll', 'YOP Poll Shortcode', array(__CLASS__, 'render_meta_box'), $pt, 'normal', 'high');
            }
        }
        
        static function get_meta($post_id) {
            $meta = get_post_meta($post_id, 'yop_poll_shortcode', true);
            $is_shortcode = self::detect_shortcode($meta);
            $meta = isset( $meta ) && $is_shortcode ? esc_attr( $meta ) : '';
            return $meta;
        }
        
        static function render_meta_box() {
            global $post;
            $meta = self::get_meta($post->ID);
            ?>
            <p>
                <label for="yop_poll_shortcode">Insert here the YOP Poll shortcode</label><br />
                <input name="yop_poll_shortcode" type="text" id="yop_poll_shortcode" value="<?php echo $meta; ?>" style="width: 95%">
            </p>
            <?php
        }
        
        static function save_post($post_id) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            $shortcode = '';
            $is_shortcode = self::detect_shortcode($_POST['yop_poll_shortcode']);
            if (isset($_POST['yop_poll_shortcode']) && !empty($_POST['yop_poll_shortcode']) && $is_shortcode) $shortcode = $_POST['yop_poll_shortcode'];
            update_post_meta($post_id, 'yop_poll_shortcode', $shortcode);
        }

        static function detect_shortcode($shortcode){
            $len = strlen($shortcode) - 1;
            $pos = strrpos($shortcode, "]");
            return ( 0 === strpos($shortcode, '[yop_poll') && $len === $pos ) ? true : false;
        }

        // add post meta data from Yop Poll plugin
        static function yop_poll_add_post_meta(){
            if ( $_POST ) {
                $success = '';
                $error = '';
                $message = '';
                $url = wp_get_referer();
                $post_id = url_to_postid( $url );
                $pt = get_post_type( $post_id );
                $poll_id = $_POST['poll_id'];
                $answer_id = $_POST['yop_poll_answer'][$poll_id];
                $poll = get_post_meta( $post_id, 'yop_poll_'.$poll_id, true );

                if ( self::custom_cookie_exists($post_id) ) {
                    switch ($pt) {
                        case 'aps':
                            $error = __('Desculpe, você já avaliou essa SOF.');
                            break;

                        case 'pearl':
                            $error = __('Desculpe, você já avaliou essa Pearl.');
                            break;
                        
                        default:
                            $error = __('Desculpe, você já avaliou essa enquete.');
                            break;
                    }
                    self::print_ajax_response( $error, $success, $message );
                }
                else {
                    if( !class_exists('YOP_POLL_Poll_Model') ) {
                        require_once( YOP_POLL_MODELS . 'poll_model.php' );
                    }
                    $unique_id = isset ( $_REQUEST ['unique_id'] ) ? $_REQUEST ['unique_id'] : null;
                    $unique_id = strip_tags(xss_clean($unique_id));
                    $yop_poll_model            = new YOP_POLL_Poll_Model ( $poll_id );
                    $yop_poll_model->unique_id = $unique_id;
                    $poll_html                 = $yop_poll_model->register_vote( $_REQUEST );
                    $error = $yop_poll_model->error;

                    if ( $poll_html ) {
                        if ( empty( $poll ) ) {
                            $poll = array(
                                    'id'    => $poll_id,
                                    'votes' => 0
                                );
                        }

                        if ( !array_key_exists( 'answer_'.$answer_id, $poll ) ) {
                            $poll['answer_'.$answer_id] = array(
                                    'id'    => $answer_id,
                                    'votes' => 0
                                );
                        }

                        $poll['votes']++;
                        $poll['answer_'.$answer_id]['votes']++;
                        update_post_meta( $post_id, 'yop_poll_'.$poll_id, $poll );
                        self::set_yop_poll_custom_cookie( $post_id, json_encode($_POST) );
                        
                        switch ($pt) {
                            case 'aps':
                                $success = __('Obrigado! SOF avaliada.');
                                break;

                            case 'pearl':
                                $success = __('Obrigado! Pearl avaliada.');
                                break;
                            
                            default:
                                $success = __('Obrigado! Enquete avaliada.');
                                break;
                        }
                        $message = $poll_html;
                    }

                    unset ( $yop_poll_model );
                    self::print_ajax_response( $error, $success, $message );
                }
            }
        }

        static function print_ajax_response( $error = '', $success = '', $message = '' ) {
            print '[ajax-response]' . json_encode( array(
                    'error'   => $error,
                    'success' => $success,
                    'message' => $message
                ) ) . '[/ajax-response]';
            die;
        }

        /**
         * Removing the yop_poll from the main content since
         */
        static function remove_yop_poll_from_content( $content = null ){
            global $post;

            //if( is_single() && is_main_query() && $post->post_type == 'post' )
            if( is_single() && is_main_query() ){
                $pattern = get_shortcode_regex();
                preg_match('/'.$pattern.'/s', $content, $matches);
                if ( isset($matches[2]) && is_array($matches) && $matches[2] == 'yop_poll') {
                    //shortcode is being used
                    $content = str_replace( $matches['0'], '', $content );
                }
            }
            return $content;
        }

        static function render_bulk_shortcode_page() {
            if (isset($_POST['yop_polls']) && is_array($_POST['yop_polls'])) {
                $ops = $_POST['yop_polls'];
                self::yop_polls_checker($ops);
                ?><div class="updated"><p><strong>Options saved.</strong></p></div><?php
            }
            
            global $wpdb;
            $sql = $wpdb->prepare( "SELECT * FROM $wpdb->yop_poll_questions" );
            $polls = $wpdb->get_results( $sql );
            $post_types = get_post_types(array('public' => true));
            $ops = get_option('yop_polls_extra_options');

            function yop_polls_get_option($options, $option_name) {
                if (is_array($options))
                    return isset($options[$option_name]) && !empty($options[$option_name]) ? $options[$option_name] : '';
                return '';
            }
            ?>
            <div class="wrap">
                <div class="section">
                    <form action="" method="POST">
                        <h2>Add Polls to all articles</h2>
                        <hr />
                        <h3><label for="pt-id">Configure Poll</label></h3>
                        <select name="yop_polls[id]" id="pt-id">
                            <option value=""></option>
                                <?php foreach ($polls as $poll) { ?>
                                    <option <?php selected( yop_polls_get_option($ops, 'id'), $poll->ID ); ?> value="<?php echo $poll->ID; ?>"><?php echo $poll->question; ?></option>
                                <?php } ?>
                        </select>
                        <br />
                        <h3>Where to add:</h3>
                        <div class="chkboxs" style="background-color: #FFF; border: 1px solid #DDD; padding: 5px 20px 5px 10px; display: inline-block;">
                            <?php foreach ($post_types as $pt) { ?>
                                <?php
                                    if ($pt == 'attachment') continue;
                                    $is_checked = false;
                                    if (is_array(yop_polls_get_option($ops, 'post_types'))) {
                                        $post_types = yop_polls_get_option($ops, 'post_types');
                                        if (in_array($pt, $post_types)) $is_checked = true;
                                    }
                                    $obj = get_post_type_object( $pt );
                                    $label = $obj->labels->name;
                                ?>
                                <label for="pt-<?php _e($pt); ?>"><input type="checkbox" name="yop_polls[post_types][]" value="<?php _e($pt); ?>" id="pt-<?php _e($pt); ?>" <?php _e($is_checked ? 'checked="checked"' : ''); ?> />&nbsp;&nbsp;&nbsp;<?php _e($label); ?></label><br />
                            <?php } ?>
                        </div>
                        <p class="submit"><input type="submit" class="button button-primary" value="Save Changes"></p>
                    </form>
                </div>
            </div>
            <?php
        }

        static function admin_menu() {
            if( function_exists( 'add_submenu_page' ) ) {
                if( current_user_can( 'manage_yop_polls_options' ) ) {
                    global $result_ptype;
                    add_submenu_page( 'yop-polls', __( 'Bulk Shortcode' ), __( 'Bulk Shortcode' ), 'manage_yop_polls_options', 'bulk-shortcode', array( __CLASS__, 'render_bulk_shortcode_page' ) );
                    $result_ptype = add_submenu_page( 'yop-polls', __( 'Results by Post Type' ), __( 'Results by Post Type' ), 'manage_yop_polls_options', 'result-ptype', array( __CLASS__, 'render_results_ptype_page' ) );
                    if ( $result_ptype ) {
                        add_action( "load-$result_ptype", array( __CLASS__, 'result_ptype_screen_options' ) );
                        add_action( "admin_print_styles-$result_ptype", array( __CLASS__, 'yop_polls_custom_scripts' ) );
                    }
                }
            }
        }

        static function result_ptype_screen_options() {
 
            global $result_ptype;
            $screen = get_current_screen();
         
            // get out of here if we are not on our settings page
            if( !is_object($screen) || $screen->id != $result_ptype ) return;
         
            $args = array(
                'label' => __('Rows'),
                'default' => 10,
                'option' => 'limit'
            );
            add_screen_option( 'per_page', $args );
        }

        function result_ptype_set_screen_option($status, $option, $value) {
            if ( 'limit' == $option ) return $value;
        }

        static function yop_polls_checker($ops) {
            global $wpdb;
            $post_types = get_post_types(array('public' => true));

            if ( array_key_exists( "id", $ops ) ) {
                if ( isset($ops['id']) && !empty($ops['id']) ) {
                    $sql = $wpdb->prepare( "SELECT ID FROM $wpdb->yop_polls WHERE ID = %d", $ops['id'] );
                    $result = $wpdb->get_results( $sql );
                    if ( count($result) > 0 ) {
                        $shortcode = '[yop_poll id="' . $ops['id'] . '"]';
                        if ( array_key_exists( "post_types", $ops ) ) {
                            $post_types = array_diff($post_types, $ops['post_types']);

                            foreach ($ops['post_types'] as $pt) {
                                $sql = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = '%s'", $pt );
                                $posts = $wpdb->get_results( $sql );

                                foreach ($posts as $post) {
                                        update_post_meta($post->ID, 'yop_poll_extra_shortcode', $shortcode);
                                }
                            }
                        }

                        foreach ($post_types as $pt) {
                            if ($pt == 'attachment') continue;
                            $sql = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = '%s'", $pt );
                            $posts = $wpdb->get_results( $sql );

                            foreach ($posts as $post) {
                                delete_post_meta($post->ID, 'yop_poll_extra_shortcode');
                            }
                        }                        
                    }
                }
            }

            update_option('yop_polls_extra_options', $ops);
        }

        static function yop_polls_custom_actions() {
            global $pagenow;
            $page = $_GET['page'];
            $action = $_GET['action'];
            if (is_admin() && !isset($action) && $page == 'yop-polls' && $pagenow == 'admin.php') {
                echo "<script type='text/javascript'>
                        jQuery(document).ready( function($) {
                            $('.submitvotes').parent().after( '<span class=\"results\"><a href=\"#\" class=\"votesptype\">Results by post type</a> |</span>' );
                            $('.votesptype').hover( function() {
                                var id = $(this).closest('tr.alternate').attr('id');
                                var arr = id.split('-');
                                var range = arr[arr.length-1]
                                $(this).attr( 'href', '/wp-admin/admin.php?page=result-ptype' );
                            });
                        });
                    </script>
                ";
            }
        }

        static function yop_polls_custom_scripts() {
            wp_register_style( 'yop-poll-custom-styles',  get_stylesheet_directory_uri() . '/poll/yop_poll.css' );
            wp_enqueue_style( 'yop-poll-custom-styles' );
        }

        static function custom_cookie_exists($post_id) {
            $options = get_option( 'yop_poll_options' );
            if ( $options ) {
                if ( in_array('cookie', $options['blocking_voters']) ) {
                    if( isset( $_COOKIE['yop_poll_custom_cookie_' . $post_id] ) )
                        return true;
                }
            }
            return false;
        }

        static function set_yop_poll_custom_cookie( $post_id, $vote_details = array() ) {
            
            $expire_cookie = 0;
            $value         = 30;
            $unit          = 'days';
            $options = get_option( 'yop_poll_options' );

            if ( $options ) {
                if( isset( $options['blocking_voters_interval_value'] ) ) {
                    $value = $options['blocking_voters_interval_value'];
                }
                if( isset( $options['blocking_voters_interval_unit'] ) ) {
                    $unit = $options['blocking_voters_interval_unit'];
                }
            }

            switch( $unit ) {

                case 'seconds' :
                    $expire_cookie = time() + $value;
                    break;

                case 'minutes' :
                    $expire_cookie = time() + ( 60 * $value );
                    break;

                case 'hours' :
                    $expire_cookie = time() + ( 60 * 60 * $value );
                    break;

                case 'days' :
                    $expire_cookie = time() + ( 60 * 60 * 24 * $value );
                    break;
            }

            setcookie( 'yop_poll_custom_cookie_' . $post_id, $vote_details, $expire_cookie, COOKIEPATH, COOKIE_DOMAIN, false );

        }

        static function render_results_ptype_page() {
            global $wpdb;
            $sql = $wpdb->prepare( "SELECT * FROM $wpdb->yop_poll_questions" );
            $polls = $wpdb->get_results( $sql );
            $post_types = get_post_types(array('public' => true));
            $id = '';
            $ptype = '';
            $nonce = '';
            $question = '';
            $answers = array();

            if (!empty($_GET['id']) && !empty($_GET['post-type'])) {
                $id = $_GET['id'];
                $ptype = $_GET['post-type'];
                $sql = $wpdb->prepare( "SELECT * FROM $wpdb->yop_poll_questions WHERE ID = '%d'", $id );
                $result = $wpdb->get_results( $sql );
                if ( count($result) > 0 ) {
                    $question = $result[0]->question;
                    $sql = $wpdb->prepare( "SELECT * FROM $wpdb->yop_poll_answers WHERE poll_id = '%d' ORDER BY $wpdb->yop_poll_answers.ID", $id );
                    $answers = $wpdb->get_results( $sql );
                }
            }

            $s = '';
            $expr = '';
            if ( !empty( $_GET['s'] ) ) {
                $s = esc_attr( $_GET['s'] );
                $expr = "AND $wpdb->posts.post_title LIKE '%$s%'";
            }

            $count = "
                SELECT COUNT(ID)
                FROM $wpdb->posts
                INNER JOIN $wpdb->postmeta m1
                  ON ( $wpdb->posts.ID = m1.post_id )
                WHERE
                    $wpdb->posts.post_type = '$ptype'
                    $expr
                    AND ( m1.meta_key = 'yop_poll_$id' )
            ";

            $query = "
                SELECT ID
                FROM $wpdb->posts
                INNER JOIN $wpdb->postmeta m1
                  ON ( $wpdb->posts.ID = m1.post_id )
                WHERE
                    $wpdb->posts.post_type = '$ptype'
                    $expr
                    AND ( m1.meta_key = 'yop_poll_$id' )
                GROUP BY $wpdb->posts.ID
                ORDER BY $wpdb->posts.post_date
                DESC
            ";

            $user = get_current_user_id();
            $screen = get_current_screen();
            $screen_option = $screen->get_option('per_page', 'option');
            $limit = get_user_meta($user, $screen_option, true);
            if ( empty ( $limit ) || $limit < 1 ) {
                $limit = $screen->get_option( 'per_page', 'default' );
            }

            $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
            $offset = ( $pagenum - 1 ) * $limit;
            $rows = $wpdb->get_var( $count );
            $num_of_pages = ceil( $rows / $limit );
            $sql = $wpdb->prepare( $query );
            $entries = $wpdb->get_results( "$query LIMIT $offset, $limit" );

            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '&laquo;', 'aag' ),
                'next_text' => __( '&raquo;', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            ?>
                <div class="wrap">
                    <h2><?php _e( "Results by Post Type" ); ?></h2>
                </div>

                <form method="get">
                    <input type="hidden" name="page" value="result-ptype"/>
                    <div class="tablenav top">
                        <div class="actions">
                            <div style="display:inline; float:left; margin:7px;"><?php _e( "Poll" ); ?>:</div>
                            <select name="id">
                                <option value=""></option>
                                <?php foreach ($polls as $poll) { ?>
                                    <option <?php selected( $id, $poll->ID ); ?> value="<?php echo $poll->ID; ?>"><?php echo $poll->question; ?></option>
                                <?php } ?>
                            </select>
                            <div style="display:inline; float:left; margin:7px;"><?php _e( "Post Type" ); ?>:</div>
                            <select name="post-type">
                                <option value=""></option>
                                <?php foreach ($post_types as $pt) { if ($pt == 'attachment') continue; ?>
                                    <?php
                                        $obj = get_post_type_object( $pt );
                                        $label = $obj->labels->singular_name;
                                    ?>
                                    <option <?php selected( $ptype, $pt ); ?> value="<?php echo $pt; ?>"><?php _e($label); ?></option>
                                <?php } ?>
                            </select>

                            <span style="line-height: 2.1em;">&nbsp;| &nbsp;</span>

                            <label for="filter" class="button-secondary"><?php _e( "Filter" ); ?></label>
                            <input type="submit" value='<?php _e( "Filter" ); ?>' style="display: none" class="button-secondary action" id="filter">
                            
                            <p class="search-box">
                                <label class="screen-reader-text" for="post-search-input"><?php _e( "Search" ); ?></label>
                                <input type="search" id="post-search-input" name="s" value="<?php echo $s; ?>">
                                <label for="search-submit" class="button-secondary"><?php _e( "Search" ); ?></label>
                                <input type="submit" id="search-submit" class="button" value="<?php _e( "Search" ); ?>" style="display: none">
                            </p>
                        </div>
                    </div>
                </form>

                <?php if ( $page_links ) { ?>
                    <div class="tablenav" style="margin-top: 20px; margin-bottom: -5px;">
                        <div class="tablenav-pages tablenav-yop-poll">                                
                            <span class="displaying-num"><?php echo $rows; ?> itens</span>
                            <?php echo $page_links; ?>
                        </div>
                    </div>
                <?php } ?>

                <div style="position: relative">

                    <div id="container" style="overflow-x: hidden;"></div>

                    <div id="poststuff">
                        <div id="post-body" class="metabox-holder columns-1">
                            <div class="meta-box-sortables ui-sortable">
                                <div class="postbox-container content">
                                    <div class="postbox stuffbox" style="margin-bottom: 2px;">
                                        <div title='<?php _e("Click to toggle"); ?>' class="handlediv"><br/></div>
                                        <h3 class="hndle">
                                            <span><?php _e("Question"); ?>:
                                                <span class="yop-poll-question-order-span"><?php echo $question; ?></span>
                                            </span>
                                        </h3>

                                        <div class = "inside" style = "padding: 0px;">
                                            <div id = "poststuff">
                                                <div class = "yop-poll-subsection postbox">
                                                    <table class="wp-list-table widefat fixed" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <?php if ( count($answers) > 0 ) { ?>
                                                                    <th id="" class="column-title" style="width: 30%;" scope="col"><strong><?php _e("Title"); ?></strong></th>
                                                                    <?php foreach ($answers as $answer) : ?>
                                                                        <th id="" class="column-answer" style="width: 10%; text-align: center;" scope="col"><?php echo $answer->answer; ?></th>
                                                                    <?php endforeach; ?>
                                                                    <th id="" class="column-total" style="width: 10%; text-align: center;" scope="col"><strong><?php _e("TOTAL"); ?></strong></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                                if ( count($entries) > 0 ) {
                                                                    foreach ($entries as $post) :
                                                                        $title = get_the_title( $post->ID );
                                                                        $meta = get_post_meta( $post->ID, 'yop_poll_'.$id, true );
                                                                    ?>
                                                                        <tr>
                                                                            <th><?php echo $title; ?></th>
                                                                            <?php
                                                                                if ( count($answers) > 0 ) {
                                                                                    foreach ($answers as $answer) :
                                                                                        $votes = 0;
                                                                                        if ( array_key_exists( "answer_".$answer->ID, $meta ) ) {
                                                                                            $votes = $meta['answer_'.$answer->ID]['votes'];
                                                                                            //$percent = ( $votes / $meta['votes'] ) * 100;
                                                                                            //$percent = round($percent, 1);
                                                                                        }
                                                                                    ?>
                                                                                        <th style="text-align: center;"><?php echo $votes; ?></th>
                                                                                    <?php endforeach;
                                                                                } ?>
                                                                            <th style="text-align: center;"><?php echo $meta['votes']; ?></th>
                                                                        </tr>
                                                                    <?php endforeach;
                                                                } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ( $page_links ) { ?>
                    <div class="tablenav" style="margin-top: 0; margin-bottom: 0;">
                        <div class="tablenav-pages tablenav-yop-poll">
                            <span class="displaying-num"><?php echo $rows; ?> itens</span>
                            <?php echo $page_links; ?></div>
                    </div>
                <?php } ?>                
            <?php
        }
    }

    if ( !function_exists('show_yop_poll_template') ) {
        function show_yop_poll_template() {
            $poll = get_post_meta( get_the_ID(), 'yop_poll_shortcode', true );
            
            if ( empty($poll) )
                $poll = get_post_meta( get_the_ID(), 'yop_poll_extra_shortcode', true );

            if ( !empty($poll) ):
            ?>
                <div class="yop-poll">
                    <?php echo do_shortcode( $poll ); ?>
                </div>
            <?php endif;
        }
    }

?>