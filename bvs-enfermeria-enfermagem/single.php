<?php 

$is_page = false;
$is_vhl = false;
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php 
        // verifica se é post ou page
        $post_type = get_post_type(); 
        if((strpos($post_type, 'page') !== false) or (strpos($post_type, 'vhl') !== false)) {
            $is_page = true;

            if(strpos($post_type, 'vhl') !== false) {
                $is_vhl = true;
            }

        }
    ?>

    <div class='content intern'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='breadcrumb'>
                        <a href="<?php bloginfo('wpurl'); ?>">Home</a> >
                        <?php if($is_page): ?>
                            <a href="<?php the_permalink(); ?>" class='active'><?php the_title(); ?></a> 
                        <?php else: ?>
                            <a href="<?php the_permalink(); ?>" class='active'>Notícia</a> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <div class='title'>
                        <h2><?php the_title(); ?></h2>
                    </div>

                    <?php if(!$is_page): ?>
                        <div class='subtitle'>
                            <div class='data'><?php the_date(); ?></div>
                            <div class='categorias'>
                                <!-- <ul>
                                    <li><a href="#">Categoria 1,</a></li>
                                    <li><a href="#">Categoria 2</a></li>
                                </ul> -->
                                <?php the_category(); ?>
                            </div>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <div class='content'><?php the_content(); ?></div>
                </div>
            </div>

            <?php if($is_vhl): ?>
                <ul>
                    <?php wp_list_pages("post_type=" . $post_type. "&title_li=&child_of=" . get_the_ID()); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>