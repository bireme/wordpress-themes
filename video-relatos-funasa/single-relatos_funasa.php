<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php

    $current_language = strtolower(get_bloginfo('language'));
    $site_lang = substr($current_language, 0,2);

    if ($current_language != ''){
        $current_language = '_' . $current_language;
    }

    $level2 = "level2";

    if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
            $level2 .= $current_language;

?>
	<div class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>" class="home">Home</a> > <?php the_title(); ?></div>
	<div id="primary" class="site-content">
		<div id="content" class="single1column" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php if ( is_single() ) : ?>
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        <?php endif; // is_single() ?>
                        <?php if ( comments_open() ) : ?>
                            <div class="comments-link">
                                <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
                            </div><!-- .comments-link -->
                        <?php endif; // comments_open() ?>
                    </header><!-- .entry-header -->
                    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                        <?php if ( is_single() ) : ?>
                        <div class="entry-content">
                            <div class="r-block-title">Objetivo Geral</div>
                            <?php the_content(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if ( function_exists('pods_field') ) : ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'instituicao_executora', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Instituição Executora</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'coordenadora', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Coordenador(a) do Projeto de Pesquisa</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'curriculo_lattes', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Currículo Lattes</div>
                                <a href="<?php echo $pod; ?>" target="_blank"><?php echo $pod; ?></a>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'imagem', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block"><div class="r-block-title">Imagem</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'produto', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Produto</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'publicacao', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Publicação</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'links_relacionados', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Links Relacionados</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                        <?php $pod = pods_field( "relatos_funasa", $post->ID, 'documentos_na_bvs', true ); ?>
                        <?php if ( $pod ) : ?>
                            <div class="related_links r-block">
                                <div class="r-block-title">Documentos na BVS</div>
                                <?php echo $pod; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </article>
                <?php comments_template( '', true ); ?>
            <?php endwhile; // end of the loop. ?>
		</div><!-- #content --> 
		<div class="single2column">
			 <div class="related_links r-block">
                <div class="r-block-title">Projeto de pesquisa</div>
                    <?php //$key="links_relacionados"; echo get_post_meta($post->ID, $key, true); ?>
                    <?php echo get_the_term_list( $post->ID, 'projeto_de_pesquisa', ' ', ', ' ); ?>
                <div class="r-block-title">Edital</div>
                    <?php //$key="links_relacionados"; echo get_post_meta($post->ID, $key, true); ?>
                    <?php echo get_the_term_list( $post->ID, 'edital', ' ', ', ' ); ?>
             </div>                           
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>:
