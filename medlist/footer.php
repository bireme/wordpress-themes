<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="footer_text">
					<?php $idioma = pll_current_language(); ?>
					<img src="<?php bloginfo('template_directory')?>/img/<?php echo $idioma; ?>/rodape.png"" alt="">
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- seta up -->
<div id="to-top" class="to-top">
	<i class="rt-icon fas fa-angle-up"></i>
</div>
<?php wp_footer(); ?>