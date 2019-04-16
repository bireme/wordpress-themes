<?php
 /*Template Name: WP-Editais SES-SP
 */
 
get_header();
$site_lang = substr($current_language, 0,2);

if ( defined( 'POLYLANG_VERSION' ) ) {
    $default_language = pll_default_language();
    if ( $default_language == $site_lang ) $site_lang = '';
}

?>
<div id="primary" class="col-md-12 archive">
	<h2><?php wp_title(' ', true, 'right'); ?></h2>
	<div class="search-edital">   
		<h3>Buscar Edital</h3>
		<form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
			<input class="searchInput" type="text" name="s" placeholder="Search Edital"/>
			<input type="hidden" name="post_type" value="edital" /> 
			<input class="searchButton" type="submit" alt="Search" value="Pesquisar" />
		</form>
	 </div>
	<? include 'part-archive-edital_order.php'; ?> 
</div>

<?php get_footer(); ?>