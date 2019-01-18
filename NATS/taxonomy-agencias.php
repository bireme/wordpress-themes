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
	<? include 'part-archive-edital.php'; ?> 
</div>

<?php get_footer(); ?>