<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://www.wpdispensary.com
 * @since             1.0.0
 * @package           WPD_Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       WP Dispensary's Gutenberg Blocks
 * Plugin URI:        https://www.wpdispensary.com/gutenberg-blocks
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            WP Dispensary
 * Author URI:        https://www.wpdispensary.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpd-blocks
 * Domain Path:       /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define global constants.
 *
 * @since 1.0.0
 */
// Plugin version.
if ( ! defined( 'WPD_BLOCKS_VERSION' ) ) {
	define( 'WPD_BLOCKS_VERSION', '1.0.0' );
}

if ( ! defined( 'WPD_BLOCKS_NAME' ) ) {
	define( 'WPD_BLOCKS_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}

if ( ! defined( 'WPD_BLOCKS_DIR' ) ) {
	define( 'WPD_BLOCKS_DIR', WP_PLUGIN_DIR . '/' . WPD_BLOCKS_NAME );
}

if ( ! defined( 'WPD_BLOCKS_URL' ) ) {
	define( 'WPD_BLOCKS_URL', WP_PLUGIN_URL . '/' . WPD_BLOCKS_NAME );
}

/**
 * BLOCK: Flowers Block.
 */
require_once( WPD_BLOCKS_DIR . '/blocks/flowers/index.php' );
