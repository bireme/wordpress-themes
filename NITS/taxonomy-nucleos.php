<!DOCTYPE html>
<?php 

get_header();?> 
<div id="primary" class="col-md-12 archive archive_portfolio">
	<h2>Portfólio <?php wp_title(' - ', true, 'right'); ?></h2>
	<? include 'portfolio_archive_part.php'; ?>
</div>
<?php
get_footer(); 
?>

