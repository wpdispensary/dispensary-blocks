<?php
/**
 * Plugin Name: WP Dispensary's Product Blocks
 * Plugin URI:  https://www.wpdispensary.com/product-blocks-for-wp-dispensary/
 * Description: Display your WP Dispensary products with the new Gutenberg editor for WordPress
 * Author:      WP Dispensary
 * Author URI:  https://www.wpdispensary.com/
 * Version:     1.1
 * License:     GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package DISPENSARY BLOCKS
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize the blocks
 */
function dispensary_blocks_loader() {
	/**
	 * Load the blocks functionality
	 */
	require_once plugin_dir_path( __FILE__ ) . 'dist/init.php';

	/**
	 * Load Getting Started page
	 */
	require_once plugin_dir_path( __FILE__ ) . 'dist/getting-started/getting-started.php';

	/**
	 * Load Product Grids PHP
	 */
	require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-flowers-grid/index.php';
	require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-concentrates-grid/index.php';
	require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-edibles-grid/index.php';
	require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-prerolls-grid/index.php';
	require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-topicals-grid/index.php';
	require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-growers-grid/index.php';

	// Load Gear block.
	if ( function_exists( 'run_wpd_gear' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-gear-grid/index.php';
	}

	// Load Tinctures block.
	if ( function_exists( 'run_wpd_tinctures' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'src/blocks/block-tinctures-grid/index.php';
	}
}
add_action( 'plugins_loaded', 'dispensary_blocks_loader' );


/**
 * Load the plugin textdomain
 */
function dispensary_blocks_init() {
	load_plugin_textdomain( 'dispensary-blocks', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'dispensary_blocks_init' );


/**
 * Add a check for our plugin before redirecting
 */
function dispensary_blocks_activate() {
    add_option( 'dispensary_blocks_do_activation_redirect', true );
}
register_activation_hook( __FILE__, 'dispensary_blocks_activate' );


/**
 * Redirect to the Dispensary Blocks Getting Started page on single plugin activation
 */
function dispensary_blocks_redirect() {
    if ( get_option( 'dispensary_blocks_do_activation_redirect', false ) ) {
        delete_option( 'dispensary_blocks_do_activation_redirect' );
        if ( ! isset( $_GET['activate-multi'] ) ) {
            wp_redirect( "admin.php?page=dispensary-blocks" );
        }
    }
}
add_action( 'admin_init', 'dispensary_blocks_redirect' );


/**
 * Add image sizes
 */
function dispensary_blocks_image_sizes() {
	// Post Grid Block
	add_image_size( 'wpd-block-product-grid-landscape', 600, 400, true );
	add_image_size( 'wpd-block-product-grid-square', 600, 600, true );
}
add_action( 'after_setup_theme', 'dispensary_blocks_image_sizes' );
