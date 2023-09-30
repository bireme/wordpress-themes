<section id="ultimas-sofs" class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if ( is_active_sidebar( 'last-sof' ) ) : ?>
                    <?php dynamic_sidebar( 'last-sof' ); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php
                global $sof;
                $response = file_get_contents('https://aps-repo.bvs.br/wp-json/wp/v2/aps?per_page=4');
                $sofs = json_decode($response);
            ?>

            <?php if ( $sofs ) :
                foreach ($sofs as $sof) :

                    get_template_part('template-parts/item-sof', 'home');

                endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-md-8">
                <p class="feed-rss"><?php _e('Quero receber as <b>últimas SOF</b> por', 'bvs_lang'); ?> <a target="_blank" href="https://aps-repo.bvs.br/feed/?post_type=aps"><u>RSS</u> <span class="fas fa-rss-square"></span></a></p>
            </div>
            <div class="col-md-4 grid-btn">
                <a href="https://aps-repo.bvs.br/aps/" class="btn btn-primary btn-sm">
                    <?php _e('Veja mais', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
                </a>
            </div>
        </div>
    </div>
</section>
