<?php

/**
 * Newsletter template subscribe feedback page
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<div id="main" class="site-main" role="main">
			
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>			
                <li class="breadcrumb-item active" aria-current="page"><?php _e("Boletim da Rede Ecos", "bvs-ecos"); ?></li>
            </ol>
        </nav>
		
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="title"><?php _e("Boletim da Rede Ecos", "bvs-ecos"); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <div class="row">
                    <div class="col-md-12">
                        <div id="newsletter-card" class="row">
                            <div class="col-12 col-md-auto text-center">
                                <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/imgs/newsletter.png" class="img-fluid" alt="feedback newsletter" />
                            </div>
                            <div class="col-12 col-md align-content-center">
                                <h2 class="title-card"><?php _e("Obrigado por inscrever-se no Boletim da Rede Ecos", "bvs-ecos"); ?></h2>
                                <p class="text-card"><?php _e("Você agora conta com um resumo das informações mais relevantes sobre Economia da Saúde, mensalmente em seu email.", "bvs-ecos"); ?></p>
                                <p class="text-card"><?php _e("O que você deseja ver agora?", "bvs-ecos"); ?></p>

                                <div class="btns-grid">
                                    <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' )); ?>">
                                        <?php _e("Voltar para a Página Inicial", "bvs-ecos"); ?> <i class="bi bi-arrow-right"></i>
                                    </a>
                                    <a class="btn btn-primary" href="<?php echo get_post_type_archive_link('post'); ?>">
                                        <?php _e("Ver Notícias da Rede Ecos", "bvs-ecos"); ?> <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

	</div><!-- #main -->

</section><!-- #primary -->

<?php
get_footer();
