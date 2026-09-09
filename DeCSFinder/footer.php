	<?php $lang = pll_current_language(); ?>
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<ul type="none"><?php dynamic_sidebar('footer') ?></ul>
				</div>
				<div class="col-md-4" id="footer-logo-bir">
					<a href="https://www.bireme.org/<?php echo $lang === 'pt' ? '' : $lang; ?>" target="_blank"><img src="http://logos.bireme.org/img/<?php echo $lang; ?>/v_bir_white.svg" class="img-fluid" alt=""></a>
				</div>
			</div>
			<hr>
		</div>
	</footer>
	<div id="powered">
		<div class="container">
			<a href="https://www.bireme.org/<?php echo $lang === 'pt' ? '' : $lang; ?>" target="_blank"><img src="<?php bloginfo('template_directory') ;?>/img/powered.svg" alt="BIREME"></a><br>
			<small>© <?php pll_e('All rights are reserved'); ?></small> <br>
		</div>
	</div>
	<?php wp_footer(); ?>
	</body>
</html>