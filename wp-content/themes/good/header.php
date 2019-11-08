<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->


<?php wp_head(); ?>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js" type="text/javascript"></script>
<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js" type="text/javascript"></script>
<![endif]-->

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site boxed group">
	<?php do_action( 'before' ); ?>
	<aside id="main-sidebar" class="sticky-nav boxed">

		<div class="logo">
            <?php good_custom_logo(); ?>
		</div>

		<div id="main-search" class="boxed">
			<?php get_search_form(); ?>
		</div>

		<nav id="main-navigation" role="navigation" class="site-navigation group wrapper">
			<a href="#" class="icon-list expand-button"><?php _e('','good'); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'menu group' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->

	</aside><!-- #main-sidebar -->

	<div id="main-content" class="site-main boxed group">
	
