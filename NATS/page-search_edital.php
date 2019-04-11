<!DOCTYPE html>
<?php 

get_header();?> 
	<div id="primary" class="col-md-12 single_post">
	<div>   
		<h3>Search Edital</h3>
		<form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
		<input type="text" name="s" placeholder="Search Edital"/>
		<input type="hidden" name="post_type" value="edital" /> <!-- // hidden 'edital' value -->
		<input type="submit" alt="Search" value="Search" />
	</form>
 </div>

 </div><!-- #primary -->

<?php
get_footer(); 
?>
