<?php 

//load_theme_textdomain('bvsaps', get_stylesheet_directory() . '/languages');

global $site_lang;
global $wp_query; 
$post_type = ($wp_query->query_vars['post_type'] == 'aps') ? __('SOF', 'bvsaps') : __('PEARL', 'bvsaps');

get_header(); ?>

<div class="single aps">
    
    <div class="container">
            
        <?php while(have_posts()): the_post(); ?>
            
            <div class="item">

                <!--h3 class="post-type"><?php _e("SOF", 'bvsaps'); ?></h3-->
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                
                
                
                <div class="dados">
                    <?php // Estes campos são os mesmos. Coloquei os dois pois há ambientes em que a taxonomy foi criada como area-tematica e outros
                    // em que a taxonomy foi criada com categoria-da-evidencia; ?>    
                    <?php if(taxonomy_exists('area-tematica')): ?>
                        <div class="category"><?php the_terms(get_the_ID(), 'area-tematica', '', ''); ?></div>
                    <?php endif; ?>

                    <?php if(taxonomy_exists('categoria-da-evidencia')): ?>
                        <div class="category"><?php the_terms(get_the_ID(), 'categoria-da-evidencia', '', ''); ?></div>
                    <?php endif; ?>
                    
                    <div class="thumb">
                        <?php if(taxonomy_exists('area-tematica')): ?>
                            <?php foreach (get_the_terms(get_the_ID(), 'area-tematica') as $cat): 
                                $src = z_taxonomy_image_url($cat->term_id, 'single-thumb-square'); 
                                if ( $src ): ?>
                                    <img src="<?php echo $src; ?>" />
                                <?php endif; 
                               break; endforeach; 
                        endif; ?>

                        <?php if(taxonomy_exists('categoria-da-evidencia')): ?>
                            <?php foreach (get_the_terms(get_the_ID(), 'categoria-da-evidencia') as $cat):
                                $src = z_taxonomy_image_url($cat->term_id, 'single-thumb-square'); 
                                if ( $src ): ?>
                                    <img src="<?php echo $src; ?>" />
                                <?php endif; 
                               break; endforeach; 
                        endif; ?>
                    </div>
                    <p>
                        <?php $term_content = get_the_terms(get_the_ID(), 'tipo-de-profissional'); if(!empty($term_content)): ?>
                            <b><?php _e('Profissional Solicitante', 'bvsaps'); ?>: </b><?php the_terms(get_the_ID(), 'tipo-de-profissional'); ?><br>
                        <?php endif; ?>
                        
                        <?php $term_content = get_the_terms(get_the_ID(), 'ciap2'); if(!empty($term_content)): ?>
                            <b><?php _e('CIAP2', 'bvsaps'); ?>: </b><?php the_terms(get_the_ID(), 'ciap2'); ?><br>
                        <?php endif; ?>

                        <?php if(function_exists('get_the_wpdecs_terms')): $wpdecs_terms = get_the_wpdecs_terms(); ?>
                            <?php if ( $wpdecs_terms ): ?>
                                <b><?php _e('DeCS/MeSH', 'bvsaps'); ?>: </b>
                                <?php
                                    $count = 0;
                                    foreach($wpdecs_terms as $term):
                                        $link = false;
                                        $name = $term['lang'][$wpdecs_array_locale[$site_lang]];
                                        if ( ! isset($name) ) $name = $term['term'];
                                        $term_obj = get_term_by('name', $name, 'decs');

                                        if($term_obj != false)
                                            $link = get_term_link($term_obj, 'decs');

                                        if($count > 0) print ", ";

                                        /* caso achar o link, printa o começo do <a> */
                                        if($link != false):
                                            echo '<a href="' . $link . '" title="' . $name . '">';
                                        endif;

                                        echo $name;

                                        $quals = array();
                                        foreach($term['qualifier'] as $qual) 
                                            $quals[] = $qual['name'];

                                        if(isset($term['qualifier']) and !empty($term['qualifier'])):
                                            echo " ("; print join($term["qualifier"], ", "); echo ")";
                                        endif;

                                        /* caso achar o link, printa o fim do <a> */
                                        if($link != false):
                                            echo "</a>";
                                        endif;

                                        $count++;
                                    endforeach;
                                ?>
                                <br>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php $term_content = get_the_terms(get_the_ID(), 'grau-da-evidencia'); if(!empty($term_content)): ?>
                            <b><?php _e('Grau da Evidência', 'bvsaps'); ?>: </b><?php the_terms(get_the_ID(), 'grau-da-evidencia'); ?><br>
                        <?php endif; ?>
                    </p>
                </div>

                
                <div class="content">
                    <p><?php the_content(); ?></p>
                </div>

                <div class="notices">
                    <p><?php the_field('observacoes'); ?></p>
                </div>

                <strong><?php _e('Bibliografia Selecionada', 'bvsaps'); ?></strong><br>
                <p><?php the_field('bibliografia_selecionada'); ?></p>

                <div class="clear"></div>
            </div>

        <?php endwhile; ?>
    
        <?php //kriesi_pagination(); ?>
    </div>
    
</div>

<?php get_footer(); ?>
