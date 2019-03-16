<?php
/**
 * Getting Started page
 *
 * @package Dispensary Blocks
 */

/**
 * Load Getting Started styles in the admin
 *
 * since 1.0.0
 */
function dispensary_blocks_start_load_admin_scripts( $hook ) {

	if ( ! ( 'wp-dispensary_page_dispensary-blocks' == $hook ) ) {
		return;
	}

	$postfix = ( SCRIPT_DEBUG == true ) ? '' : '.min';

	/**
	 * Load scripts and styles
	 *
	 * @since 1.0
	 */

	// Getting Started javascript
	wp_enqueue_script( 'dispensary-blocks-getting-started', plugins_url( 'getting-started/getting-started.js', dirname( __FILE__ ) ), array( 'jquery' ), '1.0.0', true );

	// Getting Started styles
	wp_register_style( 'dispensary-blocks-getting-started', plugins_url( 'getting-started/getting-started.css', dirname( __FILE__ ) ), false, '1.0.0' );
	wp_enqueue_style( 'dispensary-blocks-getting-started' );

	// FontAwesome
	wp_register_style( 'dispensary-blocks-fontawesome', plugins_url( '/assets/fontawesome/css/all' . $postfix . '.css', dirname( __FILE__ ) ), false, '1.0.0' );
	wp_enqueue_style( 'dispensary-blocks-fontawesome' );
}
add_action( 'admin_enqueue_scripts', 'dispensary_blocks_start_load_admin_scripts' );


/**
 * Adds a menu item for the Getting Started page.
 *
 * since 1.0.0
 */
function dispensary_blocks_getting_started_menu() {

	add_submenu_page(
		'wpd-settings',
		__( 'WP Dispensary Product Blocks', 'dispensary-blocks' ),
		__( 'Product Blocks', 'dispensary-blocks' ),
		'manage_options',
		'dispensary-blocks',
		'dispensary_blocks_getting_started_page'
	);

}
add_action( 'admin_menu', 'dispensary_blocks_getting_started_menu' );


/**
 * Outputs the markup used on the Getting Started
 *
 * since 1.0.0
 */
function dispensary_blocks_getting_started_page() {

	/**
	 * Create recommended plugin install URLs
	 *
	 * since 1.0.0
	 */
	$gberg_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'gutenberg'
			),
			admin_url( 'update.php' )
		),
		'install-plugin_gutenberg'
	);

	$wpd_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'dispensary-blocks'
			),
			admin_url( 'update.php' )
		),
		'install-plugin_dispensary-blocks'
	);

	$wpd_theme_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-theme',
				'theme' => 'dispensary-blocks'
			),
			admin_url( 'update.php' )
		),
		'install-theme_dispensary-blocks'
	);
?>
	<div class="wrap wpd-getting-started">
		<div class="intro-wrap">
			<div class="intro">
				<a href="<?php echo esc_url('https://www.wpdispensary.com/'); ?>"><img class="dispensary-logo" src="<?php echo esc_url( plugins_url( 'logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit WP Dispensary', 'dispensary-blocks' ); ?>" /></a>
				<h3><?php printf( esc_html__( 'Getting started with', 'dispensary-blocks' ) ); ?> <strong><?php printf( esc_html__( 'Dispensary Blocks', 'dispensary-blocks' ) ); ?></strong></h3>
			</div>
		</div>

		<div class="panels">
			<div id="panel" class="panel">
				<div id="dispensary-blocks-panel" class="panel-left visible">
					<div class="wpd-block-split clearfix">
						<div class="wpd-block-split-left">
							<div class="wpd-titles">
								<h2><?php esc_html_e( 'Welcome to the future of cannabis website design with WP Dispensary\'s Product Blocks for Gutenberg!', 'dispensary-blocks' ); ?></h2>
								<p><?php esc_html_e( 'The Dispensary Blocks collection makes it a breeze to add and style your menu. Simply search for "dispensary" or "products" in the block inserter to display Dispensary Blocks.', 'dispensary-blocks' ); ?></p>
							</div>
						</div>
						<div class="wpd-block-split-right">
							<div class="wpd-block-theme">
								<img src="<?php echo esc_url( plugins_url( 'theme.jpg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Dispensary Blocks', 'dispensary-blocks' ); ?>" />
							</div>
						</div>
					</div>

					<div class="wpd-block-feature-wrap clear">
					<img src="<?php echo esc_url( plugins_url( 'images/wpd-icon.png', __FILE__ ) ) ?>" class="wpd-icon" alt="<?php esc_html_e( 'Dispensary Blocks', 'dispensary-blocks' ); ?>" />
						<h2><?php esc_html_e( 'Available Dispensary Blocks', 'dispensary-blocks' ); ?></h2>
						<p><?php esc_html_e( 'The following blocks are available in Dispensary Blocks. More blocks are on the way so stay tuned!', 'dispensary-blocks' ); ?></p>

						<div class="wpd-block-features">
							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/flowers-product-block.jpg', __FILE__ ) ) ?>" alt="Post Grid Block" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Flowers Block', 'dispensary-blocks' ); ?></h3>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/concentrates-product-block.jpg', __FILE__ ) ) ?>" alt="Container Block" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Concentrates Block', 'dispensary-blocks' ); ?></h3>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/edibles-product-block.jpg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Call To Action Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Edibles Block', 'dispensary-blocks' ); ?></h3>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/prerolls-product-block.jpg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Testimonials Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Pre-rolls Block', 'dispensary-blocks' ); ?></h3>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/topicals-product-block.jpg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Inline Notices Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Topicals Block', 'dispensary-blocks' ); ?></h3>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/growers-product-block.jpg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Author Profile Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Growers Block', 'dispensary-blocks' ); ?></h3>
								</div>
							</div>

						</div><!-- .wpd-block-features -->
					</div><!-- .wpd-block-feature-wrap -->
				</div><!-- .panel-left -->

				<div class="footer-wrap">
					<div class="wpd-footer">
						<div class="wpd-footer-links">
							<a href="https://www.wpdispensary.com/"><?php esc_html_e( 'WP Dispensary', 'dispensary-blocks' ); ?></a>
							<a href="https://www.wpdispensary.com/blog/"><?php esc_html_e( 'Blog', 'dispensary-blocks' ); ?></a>
							<a href="https://www.wpdispensary.com/documentation/"><?php esc_html_e( 'Docs', 'dispensary-blocks' ); ?></a>
							<a href="https://twitter.com/wpdispensary"><?php esc_html_e( 'Twitter', 'dispensary-blocks' ); ?></a>
						</div>
					</div>
				</div><!-- .footer-wrap -->
			</div><!-- .panel -->
		</div><!-- .panels -->
	</div><!-- .getting-started -->
<?php
}
