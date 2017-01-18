<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php cultura_body_tag_schema(); ?> <?php body_class(); ?>>
<div id="page" class="site">

	<header itemscope itemtype="http://schema.org/WPHeader" id="masthead" class="site-header">
		<a href="#menu" id="top-menu-mobile" data-url="<?php echo esc_url( home_url( '/' ) ); ?>"><span></span></a>
		<div class="site-branding">
			<?php $schema_prop 		= "itemscope itemtype='http://schema.org/Organization'"; ?>
			<?php $tag_data 		= $schema_prop." id='logo'"  ?>
			<?php $tag_logo_open 	= ( is_front_page() )?"<h1 ".$tag_data.">":"<figure ".$tag_data.">"; ?>
			<?php $tag_logo_close 	= ( is_front_page() )?"</h1>":"</figure>"; ?>

			<?php echo $tag_logo_open; ?>
			<?php the_custom_logo(); ?>
			<span itemprop="legalName"><?php bloginfo( 'name' ); ?></span>
			<?php echo $tag_logo_close; ?>
		</div><!-- .site-branding -->

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<div id="site-header-menu" class="site-header-menu">
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class'     => 'primary-menu',
						 ) );
					?>
				</nav><!-- .main-navigation -->

				<div style="overflow:hidden; height:0;">
	                <nav id="menu">
	                    <?php 
                    	wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class'     => 'nav-menu-respon',
							'container' 	=> 'div'
				 		) ); ?>
	                </nav>
	            </div>
			</div><!-- .site-header-menu -->

		<?php endif; ?>

	</header><!-- #masthead -->

	<div class="site-content-contain">
		<div id="content" class="site-content">
