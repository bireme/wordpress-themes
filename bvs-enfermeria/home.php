<?php 

get_header(); 
global $mlf_activate, $current_language;

//Set default variables related to current language when multi-language-framework is not installed
    $top_bar = "top_sidebar";
    $footer_bar = "footer_sidebar";

    if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
            $top_bar .= $current_language;
            $footer_bar .= $current_language;
    }

    if ($top_sidebar == true){
?>
    <div class='container'>
        <div class='row'>
            <div class="top_sidebar">
                <?php dynamic_sidebar( $top_bar ); ?>
            </div>  
        </div>
    </div>
<?php   
    }
?>

<div class="clear"></div>

<div class='container home'>
    <div class='row'>
        <div class='col-md-9 column-1'>

            <?php 

            $column = 'column-1';
            if($mlf_activate) {
                $column .= $current_language;
            }
            
            dynamic_sidebar( $column ); 
            ?>

        </div>

        <div class='col-md-3'>

            <?php 

            $column = 'column-2';
            if($mlf_activate) {
                $column .= $current_language;
            }
            
            dynamic_sidebar( $column ); 
            ?>

        </div>
    </div>
</div>

<div class="clear"></div>

<?php 
    if ($footer_sidebar == true){
    ?>
    <div class='container'>
        <div class='row'>
            <div class="footer_sidebar">
                <?php dynamic_sidebar( $footer_bar ); ?>
            </div>  
        </div>
    </div>
    <div class="spacer"></div>  
    <?php   
    }
?>


<?php get_footer(); ?>