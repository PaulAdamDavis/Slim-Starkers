<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <!-- Meta Tags & Browser Stuff -->
    <meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="user-scalable=yes, width=device-width" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

    <!-- Make the HTML5 elements work in IE. -->
    <!--[if IE]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The mountain of stuff WP puts in -->
    <?php wp_head(); ?>

    <!-- CSS  -- Remove the 1st script tag to hide errors -->
    <link rel="stylesheet/less" href="<?php bloginfo('template_url'); ?>/css/less.less" type="text/css" />
    <script type="text/javascript">less = { env: 'development' };</script>
    <script src="<?php bloginfo('template_url'); ?>/js/less-1.2.2.min.js"></script>

	<?php $slim_ga_tracking_code = get_option('slim_ga_tracking_code'); if (slim_ga_tracking_code) : ?>
	<!-- GOOGLE ANALYTICS -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $slim_ga_tracking_code; ?>']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<?php endif; ?>
    
</head>
<body <?php body_class(); ?>>
 	
	<div class="wrapper">
	    		
	<header>
	    <a class="logo" href="<?php bloginfo('home'); ?>/"><?php bloginfo('name'); ?></a>
		<nav>
			<ul>
				<?php wp_nav_menu(array(
				    'sort_column' => 'menu_order',
				    'container_class' => 'menu-header',
				    'menu' => 'Header',
				    'container' => '',
				    'items_wrap' => '%3$s'
				)); ?>
			</ul>
		</nav>
	</header>