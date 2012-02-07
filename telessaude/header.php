<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
	
	<?php wp_head(); ?>
</head>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js_carousel/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js_carousel/unobtrusivelib.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js_carousel/prettify.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js_carousel/jquery.carousel.pack.js"></script>
<script type="text/javascript">
	$(function(){
		$.unobtrusivelib();
		prettyPrint();
		$("div.slider").carousel({ pagination: true, autoSlide: true, loop: true, autoSlideInterval: " 9000 ", effect: "fade"});
	});
</script>

<body>
    <div class="container">

        <!--div class="bar">
        	<div class="wrapper">
	            <div id="otherVersions">
	            	<?php mlf_links_to_languages(); ?>
	            </div>
	            <div id="contact"> 
	                <span><a href="../php/contact.php?lang=pt">Contato</a></span>
	            </div>
        	</div>
        </div-->
        <div class="top">
            <div id="parent">
            	<a href="/" alt="<?php bloginfo('name'); ?>">
	                <img src="<?php bloginfo('template_url') ?>/images/pt/logoTelessaude.jpg" alt="<?php bloginfo('name'); ?>"/>
        		</a>
            </div>
			<div class="institutions">
				<a href="http://portalsaude.saude.gov.br/" class="MS" title="Ministério da Saúde" alt="Ministério da Saúde"><span>Ministério da Saúde</span></a>
			</div>
        </div>
		<div class="spacer"></div>
    	<div class="search_IAHx">
			<form action="/iahx/">
                <input type="hidden" name="lang" value="pt"/>
				<div class="searchInput">                    
					<input id="textEntry" type="text" name="q" value="" />
				</div>
				<input id="submit" type="submit" value="PESQUISAR" />
			</form>
		</div>
<!-- end header -->
