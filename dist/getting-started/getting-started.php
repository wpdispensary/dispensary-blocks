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

	if ( ! ( 'toplevel_page_dispensary-blocks' == $hook ) ) {
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

	add_menu_page(
		__( 'Dispensary Blocks', 'dispensary-blocks' ),
		__( 'Dispensary Blocks', 'dispensary-blocks' ),
		'manage_options',
		'dispensary-blocks',
		'dispensary_blocks_getting_started_page',
		'dashicons-screenoptions'
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
				<a href="<?php echo esc_url('https://goo.gl/NfXcof'); ?>"><img class="dispensary-logo" src="<?php echo esc_url( plugins_url( 'logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit Dispensary Blocks', 'dispensary-blocks' ); ?>" /></a>
				<h3><?php printf( esc_html__( 'Getting started with', 'dispensary-blocks' ) ); ?> <strong><?php printf( esc_html__( 'Dispensary Blocks', 'dispensary-blocks' ) ); ?></strong></h3>
			</div>

			<ul class="inline-list">
				<li class="current"><a id="dispensary-blocks-panel" href="#"><i class="fa fa-check"></i> <?php esc_html_e( 'Getting Started', 'dispensary-blocks' ); ?></a></li>
				<li><a id="plugin-help" href="#"><i class="fa fa-plug"></i> <?php esc_html_e( 'Plugin Help File', 'dispensary-blocks' ); ?></a></li>
				<?php if( function_exists( 'dispensary_blocks_setup' ) ) { ?>
					<li><a id="theme-help" href="#"><i class="fa fa-desktop"></i> <?php esc_html_e( 'Theme Help File', 'dispensary-blocks' ); ?></a></li>
				<?php } ?>
			</ul>
		</div>

		<div class="panels">
			<div id="panel" class="panel">
				<div id="dispensary-blocks-panel" class="panel-left visible">
					<div class="wpd-block-split clearfix">
						<div class="wpd-block-split-left">
							<div class="wpd-titles">
								<h2><?php esc_html_e( 'Welcome to the future of site building with Gutenberg and Dispensary Blocks!', 'dispensary-blocks' ); ?></h2>
								<p><?php esc_html_e( 'The Dispensary Blocks collection is now ready to use in your posts and pages. Simply search for "dispensary" or "product" in the block inserter to display the Dispensary Blocks collection. Check out the help file link ove for detailed instructions!', 'dispensary-blocks' ); ?></p>
							</div>
						</div>
						<div class="wpd-block-split-right">
							<div class="wpd-block-theme">
								<img src="<?php echo esc_url( plugins_url( 'images/build-content.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Dispensary Blocks Theme', 'dispensary-blocks' ); ?>" />
							</div>
						</div>
					</div>

					<div class="wpd-block-feature-wrap clear">
						<i class="fas fa-cube"></i>
						<h2><?php esc_html_e( 'Available Dispensary Blocks', 'dispensary-blocks' ); ?></h2>
						<p><?php esc_html_e( 'The following blocks are available in Dispensary Blocks. More blocks are on the way so stay tuned!', 'dispensary-blocks' ); ?></p>

						<div class="wpd-block-features">
							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc26.svg', __FILE__ ) ) ?>" alt="Post Grid Block" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Post Grid Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an eye-catching, full-width section with a big title, paragraph text, and a customizable button.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc430.svg', __FILE__ ) ) ?>" alt="Container Block" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Container Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Wrap several blocks into a section and add padding, margins, background colors and images.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc41.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Call To Action Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Call-To-Action Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an eye-catching, full-width section with a big title, paragraph text, and a customizable button.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc4.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Testimonials Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Testimonial Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a customer or client testimonial to your site with an avatar, text, citation and more.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc184.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Inline Notices Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Inline Notice Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a colorful notice or message to your site with text, a title and a dismiss icon.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc50.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Sharing Icons Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Sharing Icons Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add social sharing icons to your page with size, shape, color and style options.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc94-f.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Author Profile Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Author Profile Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a user profile box to your site with a title, bio info, an avatar and social media links.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc115.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Accordion Toggle', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Accordion Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an accordion text toggle with a title and descriptive text. Includes font size and toggle options.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc45.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Customizable Button Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Customizable Button', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a fancy stylized button to your post or page with size, shape, target, and color options.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc38.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Drop Cap Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Drop Cap Block', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a stylized drop cap to the beginning of your paragraph. Choose from three different styles.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>

							<div class="wpd-block-feature">
								<div class="wpd-block-feature-icon"><img src="<?php echo esc_url( plugins_url( 'images/cc402.svg', __FILE__ ) ) ?>" alt="<?php esc_html_e( 'Spacer and Divider Block', 'dispensary-blocks' ); ?>" /></div>
								<div class="wpd-block-feature-text">
									<h3><?php esc_html_e( 'Spacer & Divider', 'dispensary-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an adjustable spacer between your blocks with an optional divider with styling options.', 'dispensary-blocks' ); ?></p>
								</div>
							</div>
						</div><!-- .wpd-block-features -->
					</div><!-- .wpd-block-feature-wrap -->
				</div><!-- .panel-left -->

				<!-- Plugin help file panel -->
				<div id="plugin-help" class="panel-left">
					<!-- Grab feed of help file -->
					<?php
						$plugin_help = get_transient( 'dispensary-blocks-plugin-help-feed' );

						if( false === $plugin_help ) {
							$plugin_feed = wp_remote_get( 'https://www.wpdispensary.com/plugin-help-file//?dispensaryblocks_api=post_content' );

							if( ! is_wp_error( $plugin_feed ) && 200 === wp_remote_retrieve_response_code( $plugin_feed ) ) {
								$plugin_help = json_decode( wp_remote_retrieve_body( $plugin_feed ) );
								set_transient( 'dispensary-blocks-plugin-help-feed', $plugin_help, DAY_IN_SECONDS );
							} else {
								$plugin_help = __( 'This help file feed seems to be temporarily down. You can always view the help file on the Dispensary Blocks site in the meantime.', 'dispensary-blocks' );
								set_transient( 'dispensary-blocks-plugin-help-feed', $plugin_help, MINUTE_IN_SECONDS * 5 );
							}
						}

						echo $plugin_help;
						?>
				</div>

				<!-- Theme help file panel -->
				<?php if( function_exists( 'dispensary_blocks_setup' ) ) { ?>
					<div id="theme-help" class="panel-left">
						<!-- Grab feed of help file -->
						<?php
							$theme_help = get_transient( 'dispensary-blocks-theme-help-feed' );

							if ( false === $theme_help ) {
								$theme_feed = wp_remote_get( 'https://www.wpdispensary.com/theme-help-file/?dispensaryblocks_api=post_content' );

								if ( ! is_wp_error( $theme_feed ) && 200 === wp_remote_retrieve_response_code( $theme_feed ) ) {
									$theme_help = json_decode( wp_remote_retrieve_body( $theme_feed ) );
									set_transient( 'dispensary-blocks-theme-help-feed', $theme_help, DAY_IN_SECONDS );
								} else {
									$theme_help = __( 'This help file feed seems to be temporarily down. You can always view the help file on the Dispensary Blocks site in the meantime.', 'dispensary-blocks' );
									set_transient( 'dispensary-blocks-theme-help-feed', $theme_help, MINUTE_IN_SECONDS * 5 );
								}
							}

							echo $theme_help;
							?>
					</div><!-- #theme-help -->
				<?php } ?>

				<div class="panel-right">

					<?php if( ! function_exists( 'gutenberg_init' ) || ! function_exists( 'dispensary_blocks_loader' ) ) { ?>
					<div class="panel-aside panel-wpd-plugin panel-club wpd-quick-start">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-check"></i> <?php esc_html_e( 'Quick Start Checklist', 'dispensary-blocks' ); ?></h3>
							</div>

							<ul>
							<li class="cell <?php if( function_exists( 'gutenberg_init' ) ) { echo 'step-complete'; } ?>">
									<strong><?php esc_html_e( '1. Install the Gutenberg plugin.', 'dispensary-blocks' ); ?></strong>
									<p><?php esc_html_e( 'Gutenberg adds the new block-based editor to WordPress. You will need this to work with the Dispensary Blocks plugin.', 'dispensary-blocks' ); ?></p>

									<?php if( ! array_key_exists( 'gutenberg/gutenberg.php', get_plugins() ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( $gberg_install_url ); ?>"><?php esc_html_e( 'Install Gutenberg now', 'dispensary-blocks' ); ?> &rarr;</a>
									<?php } else if ( array_key_exists( 'gutenberg/gutenberg.php', get_plugins() ) && ! is_plugin_active( 'gutenberg/gutenberg.php' ) ) { ?>
										<?php activate_plugin( 'gutenberg/gutenberg.php' ); ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'dispensary-blocks' ); ?></strong>
									<?php } else { ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'dispensary-blocks' ); ?></strong>
									<?php } ?>
								</li>

								<li class="cell <?php if( function_exists( 'dispensary_blocks_loader' ) ) { echo 'step-complete'; } ?>">
									<strong><?php esc_html_e( '2. Install the Dispensary Blocks plugin.', 'dispensary-blocks' ); ?></strong>
									<p><?php esc_html_e( 'Dispensary Blocks adds several handy content blocks to the Gutenberg block editor.', 'dispensary-blocks' ); ?></p>

									<?php if( ! array_key_exists( 'dispensary-blocks/dispensaryblocks.php', get_plugins() ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( $wpd_install_url ); ?>"><?php esc_html_e( 'Install Dispensary Blocks now', 'dispensary-blocks' ); ?> &rarr;</a>
									<?php } else if ( array_key_exists( 'dispensary-blocks/dispensaryblocks.php', get_plugins() ) && ! is_plugin_active( 'dispensary-blocks/dispensaryblocks.php' ) ) { ?>
										<?php activate_plugin( 'dispensary-blocks/dispensaryblocks.php' ); ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'dispensary-blocks' ); ?></strong>
									<?php } else { ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'dispensary-blocks' ); ?></strong>
									<?php } ?>
								</li>
							</ul>
						</div>
					</div>
					<?php } ?>

					<?php if( ! function_exists( 'dispensary_blocks_setup' ) ) { ?>
					<div class="panel-aside panel-wpd-plugin panel-club">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-download"></i> <?php esc_html_e( 'Free Theme Download', 'dispensary-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell">
									<p><a class="wpd-theme-image" href="<?php echo esc_url('https://goo.gl/FCT6xS'); ?>"><img src="<?php echo esc_url( plugins_url( 'theme.jpg', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit Dispensary Blocks', 'dispensary-blocks' ); ?>" /></a></p>

									<p><?php esc_html_e( 'Download our FREE Dispensary Blocks theme to help you get started with the Dispensary Blocks plugin and the new WordPress block editor.', 'dispensary-blocks' ); ?></p>

									<a class="button-primary club-button" target="_blank" href="<?php echo esc_url( $wpd_theme_install_url ); ?>"><?php esc_html_e( 'Install Now', 'dispensary-blocks' ); ?> &rarr;</a>
								</li>
							</ul>
						</div>
					</div>
					<?php } ?>

					<div class="panel-aside panel-wpd-plugin panel-club">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-envelope"></i> <?php esc_html_e( 'Stay Updated', 'dispensary-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell">
								<p><?php esc_html_e( 'Join the newsletter to receive emails when we add new blocks, release plugin and theme updates, send out free resources, and more!', 'dispensary-blocks' ); ?></p>

									<a class="button-primary club-button" target="_blank" href="<?php echo esc_url( 'https://goo.gl/3pC6LE' ); ?>"><?php esc_html_e( 'Subscribe Now', 'dispensary-blocks' ); ?> &rarr;</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="panel-aside panel-wpd-plugin panel-club">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-arrow-circle-down"></i> <?php esc_html_e( 'Free Blocks & Tutorials', 'dispensary-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell">
									<p><?php esc_html_e( 'Check out the Dispensary Blocks site to find block editor tutorials, free blocks and updates about the Dispensary Blocks plugin and theme!', 'dispensary-blocks' ); ?></p>
									<a class="button-primary club-button" target="_blank" href="<?php echo esc_url( 'https://goo.gl/xpujKp' ); ?>"><?php esc_html_e( 'Visit DispensaryBlocks.com', 'dispensary-blocks' ); ?> &rarr;</a>
								</li>
							</ul>
						</div>
					</div>
				</div><!-- .panel-right -->

				<div class="footer-wrap">
					<h2 class="visit-title"><?php esc_html_e( 'Free Blocks and Resources', 'dispensary-blocks' ); ?></h2>

					<div class="wpd-block-footer">
						<div class="wpd-block-footer-column">
							<i class="far fa-envelope"></i>
							<h3><?php esc_html_e( 'Blocks In Your Inbox', 'dispensary-blocks' ); ?></h3>
							<p><?php esc_html_e( 'Join the newsletter to receive emails when we add new blocks, release plugin and theme updates, send out free resources, and more!', 'dispensary-blocks' ); ?></p>
							<a class="button-primary" href="https://www.wpdispensary.com/subscribe?utm_source=WPD%20Theme%20GS%20Page%20Footer%20Subscribe"><?php esc_html_e( 'Subscribe Today', 'dispensary-blocks' ); ?></a>
						</div>

						<div class="wpd-block-footer-column">
							<i class="far fa-edit"></i>
							<h3><?php esc_html_e( 'Articles & Tutorials', 'dispensary-blocks' ); ?></h3>
							<p><?php esc_html_e( 'Check out the Dispensary Blocks site to find block editor tutorials, free blocks and updates about the Dispensary Blocks plugin and theme!', 'dispensary-blocks' ); ?></p>
							<a class="button-primary" href="https://www.wpdispensary.com/blog?utm_source=WPD%20Theme%20GS%20Page%20Footer%20Blog"><?php esc_html_e( 'Visit the Blog', 'dispensary-blocks' ); ?></a>
						</div>

						<div class="wpd-block-footer-column">
							<i class="far fa-newspaper"></i>
							<h3><?php esc_html_e( 'Gutenberg News', 'dispensary-blocks' ); ?></h3>
							<p><?php esc_html_e( 'Stay up to date with the new WordPress editor. Gutenberg News curates Gutenberg articles, tutorials, videos and more free resources.', 'dispensary-blocks' ); ?></p>
							<a class="button-primary" href="http://gutenberg.news/?utm_source=WPD%20Theme%20GS%20Page%20Footer%20Gnews"><?php esc_html_e( 'Visit Gutenberg News', 'dispensary-blocks' ); ?></a>
						</div>
					</div>

					<div class="wpd-footer">
						<p><?php echo sprintf( esc_html__( 'Made by the fine folks at %1$s and %2$s.', 'dispensary-blocks' ), '<a href=" ' . esc_url( 'https://studiopress.com/' ) . ' ">StudioPress</a>', '<a href=" ' . esc_url( 'https://wpengine.com/' ) . ' ">WP Engine</a>' ); ?></p>
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
