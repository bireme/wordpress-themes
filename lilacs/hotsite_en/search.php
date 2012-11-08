<?php
$myOptions = get_option('myOptions');

$search_lang = $myOptions['theme_search_lang'];

get_header(); 

$query = $_GET[s];
$query = preg_replace('/\\\"/','%22',$query);

?>
	<div id="content" class="narrowcolumn" role="main">
		<iframe src="http://pesquisa.bvsalud.org/regional/index.php?home_text=<?php bloginfo('name'); ?>&home_url=<?php echo get_option('home'); ?>&display_banner=false&q=<?php echo $query ?>&lang=<?php echo $myOptions['theme_search_lang'];?>&filter=<?php echo "$_GET[filter]" ?>&filterLabel=<?php echo "$_GET[filterLabel]" ?>" width="100%" height="1500" ></iframe>
	</div>


<?php get_footer(); ?>
