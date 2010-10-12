<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <!-- Meta Tags & Browser Stuff -->
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

    <!-- Make the HTML5 elements work in IE. I know HTML5 doesn't need script types, but IE need it to download the script to let us not need them later! -->
    <!--[if IE]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The mountain of stuff WP puts in -->
    <?php wp_head(); ?>

    <!-- Favicon -->
    <link rel="shortcut icon" href="http://codebymonkey.com/wp-content/themes/CodeByMonkey/images/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />

    <!-- JavaScript -->
    <script src="http://code.jquery.com/jquery-1.4.2.min.js"></script> 
    <script src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>
    
</head>
<body <?php body_class(); ?>>
	
	<div class="wrapper">
		
	<header>
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<h2><?php bloginfo('description'); ?></h2>
		<nav>
			<ul>
				<?php wp_list_pages('title_li=' ); ?>
			</ul>
		</nav>
	</header>
	