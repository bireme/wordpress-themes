<?php get_header(); ?>

<main>
    
    <h1>Exemplo</h1>
    <p>Teste</p>
    
</main>


<?php 
    if(have_posts()) :
        while(have_posts()) : the_post();
        the_title("<h1>", "</h1>");
        the_content();
        endwhile;
    endif;
?>

<?php get_footer(); ?>
