<?php get_header(); ?>

    <div class='content intern'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='breadcrumb'>
                        <a href="<?php bloginfo('wpurl'); ?>">Home</a> >
                        <a href="<?php the_permalink(); ?>" class='active'>Erro</a> 
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <div class='title'>
                        <h2>404 - Página não encontrada</h2>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <div class='content'>A página que você procura não foi encontrada. Por favor entre em contato com nossos administradores.</div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>