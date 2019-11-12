<?php
    $idioma = pll_current_language();
	$survey = array(
		'pt' => 'https://forms.gle/NYvzGoTt8wWz28PJ7',
		'es' => 'https://forms.gle/c9S4JJ4TRfdUYgYE7',
		'en' => 'https://forms.gle/M6ixsLd8h5adDN947',
	);
?>
		<div class="spacer"> </div>
		<!-- Footer -->
		<footer id="footer">
			<?php dynamic_sidebar( 'footer' ); ?>
		</footer>
		<!-- Bootstrap core JavaScript -->
		<script src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/js/jquery/jquery.min.js"></script>
		<script src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/js/bootstrap/bootstrap.bundle.min.js"></script>
		<script src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/js/counter.js"></script>  
        <script src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/js/cookie.js"></script>
        <script src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/js/accessibility.js"></script> 
         <script src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/js/feedback.js"></script>   
	
		<?php wp_footer(); ?>
	</body>
    <!-- aba feedback -->
<div id="iconeFeedback">
	<a href="<?php echo $survey[$idioma]; ?>" target="_blank"><img src=" <?php bloginfo('template_directory'); ?>/images/iconFeedback<?php echo $idioma; ?>.svg" alt=""></a>
</div>
<style>

iframe.twitter-timeline .timeline-TweetList li {
    border: 1px solid red !important;
    width: 33% !important;
    float: left !important;
}


</style>
</html>

