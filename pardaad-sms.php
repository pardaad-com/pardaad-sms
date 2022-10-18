<?php
/**
 * Plugin Name: Pardaad Elementor SMS AddOn
 * Description: This plugin add an action to elementor form to send sms after sms form submit
 * Plugin URI: https://github.com/pardaad/elementor-form-sms/
 * Author: Mehdi Sharif
 * Version: 1.0.0
 * Author URI: https://github.com/pardaad
 *
 * Text Domain: sunway
 * Requires at least: 5.2
 * Requires PHP: 7.0
 * @package Pardaad Elementor SMS AddOn
 * @category Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SUNWAY_VERSION', '1.0.0' );

define( 'SUNWAY__FILE__', __FILE__ );
define( 'SUNWAY_PLUGIN_BASE', plugin_basename( SUNWAY__FILE__ ) );
define( 'SUNWAY_PATH', plugin_dir_path( SUNWAY__FILE__ ) );

add_action( 'plugins_loaded', 'sunway_load_plugin_textdomain' );

if ( ! version_compare( PHP_VERSION, '7.0', '>=' ) ) {
	add_action( 'admin_notices', 'sunway_fail_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '5.2', '>=' ) ) {
	add_action( 'admin_notices', 'sunway_fail_wp_version' );
} else {
	require SUNWAY_PATH . 'includes/plugin.php';
}

/**
 * Load SunWay textdomain.
 *
 * Load gettext translate for SunWay text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sunway_load_plugin_textdomain() {
	load_plugin_textdomain( 'sunway', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

/**
 * SunWay admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sunway_fail_php_version() {
	/* translators: %s: PHP version. */
	$message = sprintf( __( 'SunWay requires PHP version %s+, plugin is currently NOT RUNNING.', 'sunway' ), '7.0' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * SunWay admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sunway_fail_wp_version() {
	/* translators: %s: WordPress version. */
	$message = sprintf( __( 'SunWay requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'sunway' ), '5.2' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
