<!DOCTYPE html>
<?php 

get_header();?> 
<div id="primary" class="col-md-12 archive archive_portfolio">
	<h2><?php single_term_title(''); ?></h2>
	<? include 'portfolio_archive_newpart.php'; ?>
</div>
<?php
get_footer(); 
?>

