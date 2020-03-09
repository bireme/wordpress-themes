<?php
	/*
		template name: Contact
	*/
?>
<?php get_header(); ?>
<main class="padding1" id="main_container" role="main">
	<div class="container">
		<h2 class="titulo1"><?php the_title(); ?></h2>
		<div class="row">
			<div class="col-md-6">
				<img src="<?php bloginfo( 'template_directory'); ?>/img/contato.jpg" alt="" class="img-fluid rounded"> <br> <br>
				<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae, ex. Nostrum alias explicabo molestiae in eligendi. Vitae modi harum cumque earum repudiandae ipsa autem sapiente ab, consectetur doloribus possimus? Accusantium.</p> -->
			</div>
			<div class="col-md-6">
				<?php while(have_posts()) : the_post();
					the_content();
				endwhile ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
<!-- 
<label class='formLabel'> Seu nome: (obrigatório) [text* your-name] </label>
<label class='formLabel'> Seu e-mail: (obrigatório)[email* your-email] </label>
<label class='formLabel'> Assunto: [text your-subject] </label>
<label class='formLabel'> Sua mensagem: [textarea your-message] </label>
[submit  "Enviar"] -->