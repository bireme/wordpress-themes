<?php 
	$hotsite_lang = pll_current_language(slug); //pega o idioma do template
	include "vars_$hotsite_lang.php" //carrega as variaveis com o idioma selecionado;
?>
			<footer class="text-center">
					<div class="footer-above">
						<div class="container">
							<div class="row">
								<div class="footer-col col-md-6">
									<?php dynamic_sidebar( 'footer' ); ?>				  
								</div>
								<div class="footer-col col-md-6">
									<a href="http://www.paho.org/bireme">
										<img class="img-responsive" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/<?php echo $bir50_instituion_img; ?>" alt="<?php echo $bir50_institution; ?>">									</a>
								</div>
							</div>
						</div>
					</div>
				</footer>
		</div> <?/* /wp-site aberto em header.php */ ?>
	<?php wp_footer(); ?>
	</body> <?/* /body aberto em header.php */ ?>
    <!-- Theme JavaScript -->
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bireme50.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/masonry.pkgd.min.js"></script>
	<script>
	  $(function(){
		
		$('#grid').masonry({
		  itemSelector: '.grid-item',
		  columnWidth: 0
		});
		
	  });
	</script>
</html> <?/* /html aberto em header.php */ ?>