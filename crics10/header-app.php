<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--meta name="viewport" content="width=device-width, initial-scale=1"-->
    <meta http-equiv="Expires" content="-1" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="robots" content="all" />
    <meta name="MSSmartTagsPreventParsing" content="true" />

    <!-- === Page Title === -->
    <title><?php echo get_bloginfo('name'); ?></title>

    <!-- === Embedding style.css === -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/style-app.css'; ?>" type="text/css" media="all"/>

    <!-- === Embedding script for YouTube Video === -->
    <!-- <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/video.js'; ?>"></script> -->

</head>
<body>
