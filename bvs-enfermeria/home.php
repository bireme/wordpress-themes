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

    if (vhl_get_top_auxiliary_sidebar_status()){
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

        <?php 

        // pega o total de colunas
        $total_columns = vhl_get_total_columns(); 

        // cria um array que dirá qual a ordem dos col-md, de acordo com a quantidade selecionada
        $columns = array();

        if((int) $total_columns == 1) {
            $columns[] = 'col-md-12';

        } elseif ((int) $total_columns == 2) {
            $columns[] = 'col-md-9';
            $columns[] = 'col-md-3';

        } elseif ((int) $total_columns == 3) {
            $columns[] = 'col-md-4';
            $columns[] = 'col-md-4';
            $columns[] = 'col-md-4';
        
        } elseif ((int) $total_columns == 4) {
            $columns[] = 'col-md-3';
            $columns[] = 'col-md-3';
            $columns[] = 'col-md-3';
            $columns[] = 'col-md-3';
        }

        ?>

        <?php $count = 0; foreach($columns as $column): $count += 1; ?>

            <?php 
                // dá o nome da coluna e appenda o mlf, caso tenha
                $column_name = 'column-' . $count;
                if($mlf_activate) {
                    $column .= $current_language;
                }
            ?>
            
            <!-- coluna <?= $count; ?> -->
            <div class='<?= $column; ?> <?= $column_name; ?>'>
                <?php dynamic_sidebar( $column_name ); ?>
            </div>

        <?php endforeach; ?>
    </div>
</div>

<div class="clear"></div>

<?php 
    if (vhl_get_footer_auxiliary_sidebar_status()){
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