<?php
/**
 * JM back compat functionality
 *
 * Prevents JM from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage JM
 * @since JM 1.0
 */

/**
 * Prevent switching to JM on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since JM 1.0
 */
function jm_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'jm_upgrade_notice' );
}
add_action( 'after_switch_theme', 'jm_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * JM on WordPress versions prior to 4.7.
 *
 * @since JM 1.0
 *
 * @global string $wp_version WordPress version.
 */
function jm_upgrade_notice() {
	$message = sprintf( __( 'JM requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'jm' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since JM 1.0
 *
 * @global string $wp_version WordPress version.
 */
function jm_customize() {
	wp_die( sprintf( __( 'JM requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'jm' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'jm_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since JM 1.0
 *
 * @global string $wp_version WordPress version.
 */
function jm_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'JM requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'jm' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'jm_preview' );
