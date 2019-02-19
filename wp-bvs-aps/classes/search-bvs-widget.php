<?php

class search_bvs_widget extends WP_Widget {
     
    function __construct() {
        parent::__construct(
             
            // base ID of the widget
            'search_bvs_widget',
             
            // name of the widget
            'Search BVS Widget',
             
            // widget options
            array (
                'description' => 'Multi-Pesquisa BVS'
            )
             
        );
    }
     
    function form( $instance ) {
     
        $defaults = array(
            'search_url' => '-1',
            'tutorial_url' => '-1',
            'tips_url' => '-1',
        );
        $search_url = $instance[ 'search_url' ];
        $tutorial_url = $instance[ 'tutorial_url' ];
        $tips_url = $instance[ 'tips_url' ];
         
        // markup for form ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'search_url' ); ?>">Search URL:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'search_url' ); ?>" name="<?php echo $this->get_field_name( 'search_url' ); ?>" value="<?php echo esc_attr( $search_url ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'tutorial_url' ); ?>">Tutorial URL:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'tutorial_url' ); ?>" name="<?php echo $this->get_field_name( 'tutorial_url' ); ?>" value="<?php echo esc_attr( $tutorial_url ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'tips_url' ); ?>">Dicas URL:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'tips_url' ); ?>" name="<?php echo $this->get_field_name( 'tips_url' ); ?>" value="<?php echo esc_attr( $tips_url ); ?>">
        </p>
                 
    <?php
    }
     
    function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;
        $instance[ 'search_url' ] = strip_tags( $new_instance[ 'search_url' ] );
        $instance[ 'tutorial_url' ] = strip_tags( $new_instance[ 'tutorial_url' ] );
        $instance[ 'tips_url' ] = strip_tags( $new_instance[ 'tips_url' ] );
        return $instance;
         
    }
     
    function widget( $args, $instance ) {
         
        // kick things off
        extract( $args );
        echo $before_widget;

        $tooltip = "<h4><span class='fas fa-lightbulb'></span>". __('Dica BVS-APS', 'bvs_lang') ."</h4>
                    <p>". __('Para buscar pelo nome do autor utilize', 'bvs_lang') ."</p>
                    <div class='alert alert-secondary' role='alert'>". __('au:(nome)', 'bvs_lang') ."</div>
                    <a target='_blank' href='". $instance[ 'tips_url' ] ."'>". __('Ver mais dicas de pesquisa', 'bvs_lang') ."</a>";
        ?>

        <script src="http://reddes.bvsalud.org/support/js/multisearch-widget.js"></script>
        <form class="vhl-search-form" action="<?php echo $instance[ 'search_url' ]; ?>" method="get" id="searchForm" onsubmit="if(searchForm.q.value=='<?php _e('Pesquisar', 'bvs_lang'); ?>') searchForm.q.value = '';">
            <?php if( function_exists('pll_current_language') ){ ?>
            <input type="hidden" name="lang" value="<?php echo pll_current_language(); ?>" />
            <?php } ?>

            <input type="hidden" name="home_url" value="<?php echo get_site_url(); ?>" />
            <input type="hidden" name="home_text" value="<?php echo get_bloginfo( 'name' ); ?>" />
            <label for="vhl-search-input" class="sr-only"><?php _e('Pesquisar', 'bvs_lang'); ?></label>

            <div class="input-group">
                <input type="text" id="vhl-search-input" class="vhl-search-input form-control" name="q" placeholder="<?php _e('Pesquisar', 'bvs_lang'); ?>" value="<?php _e('Pesquisar', 'bvs_lang'); ?>" onfocus="if(this.value=='<?php _e('Pesquisar', 'bvs_lang'); ?>') this.value = '';" onblur="if(this.value=='') this.value = '<?php _e('Pesquisar', 'bvs_lang'); ?>';" data-toggle="tooltip" data-html="true" title="<?php echo $tooltip; ?>" />
                <div class="input-group-append">
                    <button type="submit" class="vhl-search-submit submit btn btn-primary">
                        <span class="fas fa-search"></span>
                    </button>
                </div>
            </div>
            
            <a target='_blank' href="<?php echo $instance[ 'tutorial_url' ]; ?>" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="bottom" title="<?php _e('Acesse os tutoriais de como pesquisar na BVS APS', 'bvs_lang'); ?>">?</a>
        </form>
        <form style="display: none;" class="default-search-form" role="search" action="http://pesquisa.bvs.br/aps/" method="get" id="defaultSearchForm" onsubmit="if(defaultSearchForm.s.value=='<?php _e('Pesquisar', 'bvs_lang'); ?>') defaultSearchForm.s.value = '';">
            <?php if( function_exists('pll_current_language') ){ ?>
            <input type="hidden" name="lang" value="<?php echo pll_current_language(); ?>" />
	    <input type="hidden" name="filter[db][]" value="SOF" />
            <?php } ?>

            <input type="hidden" name="filter[db][]" value="SOF">
            
            <label for="s" class="sr-only"><?php _e('Pesquisar', 'bvs_lang'); ?></label>
            <div class="input-group">
                <input type="text" id="s" class="vhl-search-input form-control" name="q" placeholder="<?php _e('Pesquisar', 'bvs_lang'); ?>" value="<?php _e('Pesquisar', 'bvs_lang'); ?>" onfocus="if(this.value=='<?php _e('Pesquisar', 'bvs_lang'); ?>') this.value = '';" onblur="if(this.value=='') this.value = '<?php _e('Pesquisar', 'bvs_lang'); ?>';"/>
                <div class="input-group-append">
                    <button type="submit" class="vhl-search-submit submit btn btn-primary">
                        <span class="fas fa-search"></span>
                    </button>
                </div>
            </div>

            <a target='_blank' href="<?php echo $instance[ 'tutorial_url' ]; ?>" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="bottom" title="<?php _e('Acesse os tutoriais de como pesquisar na BVS APS', 'bvs_lang'); ?>">?</a>
        </form>
        <div class="searchItens">
            <input type="radio" name="engine" checked="checked" value="op2" id="search-op2" /> 
            <label for="search-op2"><?php _e('Coleção da SOF', 'bvs_lang'); ?></label>
            
            <input type="radio" name="engine" value="op1" id="search-op1" /> 
            <label for="search-op1"><?php _e('Toda a coleção', 'bvs_lang'); ?></label>
        </div>
        
        <?php 

        echo $after_widget;        
    }     
}
