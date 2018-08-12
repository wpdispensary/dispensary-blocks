<?php
/**
 * Plugin Name: WP Dispensary's Gutenberg Blocks
 * Plugin URI: https://www.wpdispensary.com/
 * Description: Custom Gutenberg Blocks for your WP Dispensary powered marijuana menu.
 * Author: deviodigital, wpdispensary
 * Author URI: https://wpdispensary.com/
 * Version: 0.0.1
 * License: GPL3+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package WPDGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
