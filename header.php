<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tom_s
 *
 * <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'tom_s' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="/wp-content/themes/tom_s/images/TR.svg" onerror="this.onerror=null; this.src='/wp-content/themes/tom_s/images/TR.gif'" alt="Counterpoint MTC Ltd" height="131" width="176" /></a>			
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'tom_s' ); ?></button>			
			<div id="primary-menu" class="menu">
				<ul aria-expanded="false" class=" nav-menu">
					<li class="page_item"><a href="/">About</a></li>
					<li class="page_item"><a href="/#portfolio">Portfolio</a></li>
					<li class="page_item"><a href="/#contact">Contact</a></li>
				</ul>
			</div>
		</nav><!-- #site-navigation -->		
	</header><!-- #masthead -->	
	<div id="content" class="site-content">
