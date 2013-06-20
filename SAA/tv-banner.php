<div id="tv-banner-load" class="tv-main-banner-padding">
	<?php query_posts('showposts=1&category_name=Noticias&offset=0');?>
	<?php if (have_posts()): while (have_posts()) : the_post();?>	
	<div class="tv-row-fluid">
		<div class="tv-main-banner-image">
			<img src="<?php echo get_settings('home');?>/<?php $key="img"; echo get_post_meta($post->ID,$key,true);?>" alt="<?php the_title();?>">
		</div>

		<div class="tv-main-banner-content">
			<h2 class="tv-categoria"><?php the_category(', ');?></h2>
			<h1 class="tv-main-banner-content-tit"><?php the_title();?></h1>
			<p class="tv-main-banner-content-p"><?php wp_limit_post(224,' [...]',true);?></p>
		</div>
	</div>
	
	<div class="tv-row-fluid">
		<div class="tv-main-banner-qrcode">
			<img src="http://qrfree.kaywa.com/?l=1&s=8&d=www.wesleyamaro.com.br" alt="QRCode">
			<p class="tv-main-banner-qrcode-p">Leia a matéria completa <br>escaneando o QRcode ao lado</p>
		</div>

		<div class="tv-main-banner-author">
			por: <?php the_author();?><br>
			<?php the_time('d/m/Y');?> - <?php the_time('G\hi'); ?>
		</div>
	</div>
	<?php endwhile; else:?>
	<?php endif;?>
</div>