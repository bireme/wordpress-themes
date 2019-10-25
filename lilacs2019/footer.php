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
	
		<?php wp_footer(); ?>
	</body>
<style>

iframe.twitter-timeline .timeline-TweetList li {
    border: 1px solid red !important;
    width: 33% !important;
    float: left !important;
}
</style>
</html>
