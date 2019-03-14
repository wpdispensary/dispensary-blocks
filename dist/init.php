<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since 	1.0.0
 * @package Dispensary Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue assets for frontend and backend
 *
 * @since 1.0.0
 */
function dispensary_blocks_block_assets() {

	$postfix = ( SCRIPT_DEBUG == true ) ? '' : '.min';

	// Load the compiled styles
	wp_enqueue_style(
		'dispensary-blocks-style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks.style.build.css' )
	);

	// Load the FontAwesome icon library
	wp_enqueue_style(
		'dispensary-blocks-fontawesome',
		plugins_url( 'dist/assets/fontawesome/css/all' . $postfix . '.css', dirname( __FILE__ ) ),
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'assets/fontawesome/css/all.css' )
	);
}
add_action( 'init', 'dispensary_blocks_block_assets' );


/**
 * Enqueue assets for backend editor
 *
 * @since 1.0.0
 */
function dispensary_blocks_editor_assets() {

	// Load the compiled blocks into the editor
	wp_enqueue_script(
		'dispensary-blocks-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element' , 'wp-components' , 'wp-editor' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks.build.js' )
	);

	// Load the compiled styles into the editor
	wp_enqueue_style(
		'dispensary-blocks-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks.editor.build.css' )
	);

	// Pass in REST URL
	wp_localize_script(
		'dispensary-blocks-block-js',
		'dispensary_globals',
		array(
			'rest_url' => esc_url( rest_url() )
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'dispensary_blocks_editor_assets' );


/**
 * Enqueue assets for frontend
 *
 * @since 1.0.0
 */
function dispensary_blocks_frontend_assets() {
	// Load the dismissable notice js
	wp_enqueue_script(
		'dispensary-blocks-dismiss-js',
		plugins_url( '/dist/assets/js/dismiss.js', dirname( __FILE__ ) ),
		array( 'jquery' ),
		filemtime( plugin_dir_path( __FILE__ ) . '/assets/js/dismiss.js' )
	);
}
add_action( 'wp_enqueue_scripts', 'dispensary_blocks_frontend_assets' );


// Add custom block category
add_filter( 'block_categories', function( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'dispensary-blocks',
				'title' => __( 'Dispensary Blocks', 'dispensary-blocks' ),
			),
		)
	);
}, 10, 2 );
