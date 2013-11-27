<?php $myOptions = get_option('myOptions'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
        <head>
                <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
                <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
                <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
                <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
                <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
                <?php wp_head(); ?>
                <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.min.js"></script>
                <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/unobtrusivelib.js"></script>
                <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prettify.js"></script>
                <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.carousel.pack.js"></script>
                <script type="text/javascript">

                  var _gaq = _gaq || [];
                  _gaq.push(['_setAccount', 'UA-10789823-11']);
                  _gaq.push(['_trackPageview']);

                  (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                  })();

                </script>

<body>
	<div class="container">
		<div class="banner">
			<div class="identification">
				<span class="VHLLink"><a href="http://bvsalud.org/php/index.php?lang=en"></a></span>
				<h1><a href="<?php echo get_option('home'); ?>/"><span><?php bloginfo('name'); ?></span></a></h1>
			</div><!-- /identification -->
                 <div style="display: block;" class="bar">
                <a href="/es">espa&ntilde;ol</a>
                <a href="/">portugu&ecirc;s</a>
		</div>
		</div> <!-- /banner -->
<?php wp_head(); ?>

		
