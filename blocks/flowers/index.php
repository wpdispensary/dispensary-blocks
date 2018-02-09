<?php
/**
 * BLOCK: Flowers
 *
 * Gutenberg Custom Flowers Block assets.
 *
 * @since   1.0.0
 * @package WPD_Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the block's assets for the editor.
 *
 * `wp-blocks`: Includes block type registration and related functions.
 * `wp-element`: Includes the WordPress Element abstraction for describing the structure of your blocks.
 * `wp-i18n`: To internationalize the block's text.
 *
 * @since 1.0.0
 */
function wpd_blocks_editor_assets() {
	// Scripts.
	wp_enqueue_script(
		'wpd-blocks', // Handle.
		plugins_url( 'block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ) // filemtime — Gets file modification time.
	);

	// Styles.
	wp_enqueue_style(
		'wpd-blocks-editor', // Handle.
		plugins_url( 'editor.css', __FILE__ ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // filemtime — Gets file modification time.
	);
} // End function wpd_blocks_editor_assets().

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'wpd_blocks_editor_assets' );

/**
 * Enqueue the block's assets for the frontend.
 *
 * @since 1.0.0
 */
function wpd_blocks_block_assets() {
	// Styles.
	wp_enqueue_style(
		'wpd-blocks-frontend', // Handle.
		plugins_url( 'style.css', __FILE__ ), // Block frontend CSS.
		array( 'wp-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' ) // filemtime — Gets file modification time.
	);
	wp_enqueue_style(
		'wpd-blocks-fontawesome', // Handle.
		plugins_url( 'font-awesome.css', __FILE__ ) // Font Awesome for social media icons.
	);
} // End function wpd_blocks_block_assets().

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'wpd_blocks_block_assets' );

/**
 * Save function for Flowers block
 */
function wpd_render_block_flowers( $attributes ) {
	
	/**
	 * WP Dispensary Block - Begin menu item build
	 */
	$recent_flowers = wp_get_recent_posts( array(
		'numberposts' => $attributes['flowersCount'],
		'post_status' => 'publish',
		'post_type'   => 'flowers',
		//'order'       => $attributes['order'],
		//'orderby'     => $attributes['orderBy'],
		//'category'    => $attributes['categories'],
	) );

	/**
	 * WP Dispensary Block - Begin output
	 */
	$list_items_markup = '';

	/**
	 * WP Dispensary Block - Main title
	 */
	if ( isset( $attributes['menuTitle'] ) ) {
		$list_items_markup .= '<h2 class="wpd-title">' . $attributes['menuTitle'] . '</h2>';
	}

	/**
	 * WP Dispensary Block - Block
	 */
	foreach ( $recent_flowers as $flower ) {

		$flower_id = $flower['ID'];
		$imagesize = 'dispensary-image';
		$title     = get_the_title( $flower_id );

		if ( ! $title ) {
			$title = __( '(Untitled)', 'wpd-blocks' );
		}

		$thumbnail_id        = get_post_thumbnail_id( $flower_id );
		$thumbnail_url_array = wp_get_attachment_image_src( $thumbnail_id, $imagesize, false );
		$thumbnail_url       = $thumbnail_url_array[0];
		$querytitle          = get_the_title( $flower_id );

		/** Get the pricing for Flowers */

		$priceGram      = get_post_meta( $flower_id, '_gram', true );
		$priceEighth    = get_post_meta( $flower_id, '_eighth', true );
		$priceQuarter   = get_post_meta( $flower_id, '_quarter', true );
		$priceHalfOunce = get_post_meta( $flower_id, '_halfounce', true );
		$priceOunce     = get_post_meta( $flower_id, '_ounce', true );

		$wp_dispensary_options = get_option( 'wp_dispensary_option_name' ); // Array of All Options.
		if ( ! isset( $wp_dispensary_options['wpd_hide_details'] ) ) {
			$wpd_hide_details = '';
		} else {
			$wpd_hide_details = $wp_dispensary_options['wpd_hide_details'];
		}
		if ( ! isset( $wp_dispensary_options['wpd_hide_pricing'] ) ) {
			$wpd_hide_pricing = '';
		} else {
			$wpd_hide_pricing = $wp_dispensary_options['wpd_hide_pricing'];
		}
		if ( ! isset( $wp_dispensary_options['wpd_content_placement'] ) ) {
			$wpd_content_placement = '';
		} else {
			$wpd_content_placement = $wp_dispensary_options['wpd_content_placement'];
		}
		if ( null === $wp_dispensary_options['wpd_currency'] ) {
			$wpd_currency = 'USD';
		} else {
			$wpd_currency = $wp_dispensary_options['wpd_currency'];
		}
		if ( null === $wp_dispensary_options['wpd_cost_phrase'] ) {
			$wpd_cost_phrase = 'Price';
		} else {
			$wpd_cost_phrase = $wp_dispensary_options['wpd_cost_phrase']; // costphrase.
		}

		$currency_symbols = array(
			'AED' => '&#1583;.&#1573;', // ?
			'AFN' => '&#65;&#102;',
			'ALL' => '&#76;&#101;&#107;',
			'AMD' => '',
			'ANG' => '&#402;',
			'AOA' => '&#75;&#122;', // ?
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'AWG' => '&#402;',
			'AZN' => '&#1084;&#1072;&#1085;',
			'BAM' => '&#75;&#77;',
			'BBD' => '&#36;',
			'BDT' => '&#2547;', // ?
			'BGN' => '&#1083;&#1074;',
			'BHD' => '.&#1583;.&#1576;', // ?
			'BIF' => '&#70;&#66;&#117;', // ?
			'BMD' => '&#36;',
			'BND' => '&#36;',
			'BOB' => '&#36;&#98;',
			'BRL' => '&#82;&#36;',
			'BSD' => '&#36;',
			'BTN' => '&#78;&#117;&#46;', // ?
			'BWP' => '&#80;',
			'BYR' => '&#112;&#46;',
			'BZD' => '&#66;&#90;&#36;',
			'CAD' => '&#36;',
			'CDF' => '&#70;&#67;',
			'CHF' => '&#67;&#72;&#70;',
			'CLF' => '', // ?
			'CLP' => '&#36;',
			'CNY' => '&#165;',
			'COP' => '&#36;',
			'CRC' => '&#8353;',
			'CUP' => '&#8396;',
			'CVE' => '&#36;', // ?
			'CZK' => '&#75;&#269;',
			'DJF' => '&#70;&#100;&#106;', // ?
			'DKK' => '&#107;&#114;',
			'DOP' => '&#82;&#68;&#36;',
			'DZD' => '&#1583;&#1580;', // ?
			'EGP' => '&#163;',
			'ETB' => '&#66;&#114;',
			'EUR' => '&#8364;',
			'FJD' => '&#36;',
			'FKP' => '&#163;',
			'GBP' => '&#163;',
			'GEL' => '&#4314;', // ?
			'GHS' => '&#162;',
			'GIP' => '&#163;',
			'GMD' => '&#68;', // ?
			'GNF' => '&#70;&#71;', // ?
			'GTQ' => '&#81;',
			'GYD' => '&#36;',
			'HKD' => '&#36;',
			'HNL' => '&#76;',
			'HRK' => '&#107;&#110;',
			'HTG' => '&#71;', // ?
			'HUF' => '&#70;&#116;',
			'IDR' => '&#82;&#112;',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'IQD' => '&#1593;.&#1583;', // ?
			'IRR' => '&#65020;',
			'ISK' => '&#107;&#114;',
			'JEP' => '&#163;',
			'JMD' => '&#74;&#36;',
			'JOD' => '&#74;&#68;', // ?
			'JPY' => '&#165;',
			'KES' => '&#75;&#83;&#104;', // ?
			'KGS' => '&#1083;&#1074;',
			'KHR' => '&#6107;',
			'KMF' => '&#67;&#70;', // ?
			'KPW' => '&#8361;',
			'KRW' => '&#8361;',
			'KWD' => '&#1583;.&#1603;', // ?
			'KYD' => '&#36;',
			'KZT' => '&#1083;&#1074;',
			'LAK' => '&#8365;',
			'LBP' => '&#163;',
			'LKR' => '&#8360;',
			'LRD' => '&#36;',
			'LSL' => '&#76;', // ?
			'LTL' => '&#76;&#116;',
			'LVL' => '&#76;&#115;',
			'LYD' => '&#1604;.&#1583;', // ?
			'MAD' => '&#1583;.&#1605;.', // ?
			'MDL' => '&#76;',
			'MGA' => '&#65;&#114;', // ?
			'MKD' => '&#1076;&#1077;&#1085;',
			'MMK' => '&#75;',
			'MNT' => '&#8366;',
			'MOP' => '&#77;&#79;&#80;&#36;', // ?
			'MRO' => '&#85;&#77;', // ?
			'MUR' => '&#8360;', // ?
			'MVR' => '.&#1923;', // ?
			'MWK' => '&#77;&#75;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'MZN' => '&#77;&#84;',
			'NAD' => '&#36;',
			'NGN' => '&#8358;',
			'NIO' => '&#67;&#36;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'OMR' => '&#65020;',
			'PAB' => '&#66;&#47;&#46;',
			'PEN' => '&#83;&#47;&#46;',
			'PGK' => '&#75;', // ?
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#71;&#115;',
			'QAR' => '&#65020;',
			'RON' => '&#108;&#101;&#105;',
			'RSD' => '&#1044;&#1080;&#1085;&#46;',
			'RUB' => '&#1088;&#1091;&#1073;',
			'RWF' => '&#1585;.&#1587;',
			'SAR' => '&#65020;',
			'SBD' => '&#36;',
			'SCR' => '&#8360;',
			'SDG' => '&#163;', // ?
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'SHP' => '&#163;',
			'SLL' => '&#76;&#101;', // ?
			'SOS' => '&#83;',
			'SRD' => '&#36;',
			'STD' => '&#68;&#98;', // ?
			'SVC' => '&#36;',
			'SYP' => '&#163;',
			'SZL' => '&#76;', // ?
			'THB' => '&#3647;',
			'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
			'TMT' => '&#109;',
			'TND' => '&#1583;.&#1578;',
			'TOP' => '&#84;&#36;',
			'TRY' => '&#8356;', // New Turkey Lira (old symbol used).
			'TTD' => '&#36;',
			'TWD' => '&#78;&#84;&#36;',
			'TZS' => '',
			'UAH' => '&#8372;',
			'UGX' => '&#85;&#83;&#104;',
			'USD' => '&#36;',
			'UYU' => '&#36;&#85;',
			'UZS' => '&#1083;&#1074;',
			'VEF' => '&#66;&#115;',
			'VND' => '&#8363;',
			'VUV' => '&#86;&#84;',
			'WST' => '&#87;&#83;&#36;',
			'XAF' => '&#70;&#67;&#70;&#65;',
			'XCD' => '&#36;',
			'XDR' => '',
			'XOF' => '',
			'XPF' => '&#70;',
			'YER' => '&#65020;',
			'ZAR' => '&#82;',
			'ZMK' => '&#90;&#75;', // ?
			'ZWL' => '&#90;&#36;',
		);

		if ( '' === $priceEighth && '' === $priceQuarter && '' === $priceHalfOunce && '' === $priceOunce ) {
			$pricing = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_gram', true ) . ' per gram';
		} elseif ( '' === $priceGram && '' === $priceQuarter && '' === $priceHalfOunce && '' === $priceOunce ) {
			$pricing = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_eighth', true ) . ' per eighth';
		} elseif ( '' === $priceGram && '' === $priceEighth && '' === $priceHalfOunce && '' === $priceOunce ) {
			$pricing = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_quarter', true ) . ' per quarter ounce';
		} elseif ( '' === $priceGram && '' === $priceEighth && '' === $priceQuarter && '' === $priceOunce ) {
			$pricing = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_halfounce', true ) . ' per half ounce';
		} elseif ( '' === $priceGram && '' === $priceEighth && '' === $priceQuarter && '' === $priceHalfOunce ) {
			$pricing = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_ounce', true ) . ' per ounce';
		} else {
			$pricing = '';
		}

		if ( '' === $priceGram && '' === $priceEighth && '' === $priceQuarter && '' === $priceHalfOunce && '' === $priceOunce ) {
			$pricing = ' ';
		}

		if ( get_post_meta( $flower_id, '_gram', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_gram', true );
		} elseif ( get_post_meta( $flower_id, '_eighth', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_eighth', true );
		} elseif ( get_post_meta( $flower_id, '_quarter', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_quarter', true );
		} elseif ( get_post_meta( $flower_id, '_halfounce', true ) ) {
			$pricinglow = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_halfounce', true );
		}

		$pricingsep = ' - ';

		if ( get_post_meta( $flower_id, '_ounce', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_ounce', true );
		} elseif ( get_post_meta( $flower_id, '_halfounce', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_halfounce', true );
		} elseif ( get_post_meta( $flower_id, '_quarter', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_quarter', true );
		} elseif ( get_post_meta( $flower_id, '_eighth', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_eighth', true );
		} elseif ( get_post_meta( $flower_id, '_gram', true ) ) {
			$pricinghigh = $currency_symbols[ $wpd_currency ] . '' . get_post_meta( $flower_id, '_gram', true );
		}

		if ( true === $attributes['displayPrice'] ) {
			if ( empty( $pricing ) ) {
				$showpricing = '<span class="wpd-productinfo pricing"><strong>' . $wpd_cost_phrase . ':</strong> ' . $pricinglow . '' . $pricingsep . '' . $pricinghigh . '</span>';
			} elseif ( ' ' === $pricing ) {
				$showpricing = ' ';
			} else {
				$showpricing = '<span class="wpd-productinfo pricing"><strong>' . $wpd_cost_phrase . ':</strong> ' . $pricing . '</span>';
			}
		} else {
			$showpricing = '';
		}

		if ( true === $attributes['displayTHC'] ) {
			if ( get_post_meta( $flower_id, '_thc', true ) ) {
				$thcinfo = '<span class="wpd-productinfo thc"><strong>THC: </strong>' . get_post_meta( $flower_id, '_thc', true ) . '%</span>';
			} else {
				$thcinfo = '';
			}
		} else {
			$thcinfo = '';
		}

		if ( true === $attributes['displayTHCA'] ) {
			if ( get_post_meta( $flower_id, '_thca', true ) ) {
				$thcainfo = '<span class="wpd-productinfo thca"><strong>THCA: </strong>' . get_post_meta( $flower_id, '_thca', true ) . '%</span>';
			} else {
				$thcainfo = '';
			}
		} else {
			$thcainfo = '';
		}

		if ( true === $attributes['displayTHCA'] ) {
			if ( get_post_meta( $flower_id, '_cbd', true ) ) {
				$cbdinfo = '<span class="wpd-productinfo cbd"><strong>CBD: </strong>' . get_post_meta( $flower_id, '_cbd', true ) . '%</span>';
			} else {
				$cbdinfo = '';
			}
		} else {
			$cbdinfo = '';
		}

		if ( true === $attributes['displayCBA'] ) {
			if ( get_post_meta( $flower_id, '_cba', true ) ) {
				$cbainfo = '<span class="wpd-productinfo cba"><strong>CBA: </strong>' . get_post_meta( $flower_id, '_cba', true ) . '%</span>';
			} else {
				$cbainfo = '';
			}
		} else {
			$cbainfo = '';
		}

		if ( true === $attributes['displayCBN'] ) {
			if ( get_post_meta( $flower_id, '_cbn', true ) ) {
				$cbninfo = '<span class="wpd-productinfo cbn"><strong>CBN: </strong>' . get_post_meta( $flower_id, '_cbn', true ) . '%</span>';
			} else {
				$cbninfo = '';
			}
		} else {
			$cbninfo = '';
		}

		if ( null === $thumbnail_url && 'full' === $imagesize ) {
			$wpd_shortcodes_default_image = site_url() . '/wp-content/plugins/wp-dispensary/public/images/wpd-large.jpg';
			$defaultimg                   = apply_filters( 'wpd_shortcodes_default_image', $wpd_shortcodes_default_image );
			$showimage                    = '<a href="' . get_permalink( $flower_id ) . '"><img src="' . $defaultimg . '" alt="Menu - Flower" /></a>';
		} elseif ( null !== $thumbnail_url ) {
			$showimage = '<a href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="Menu - Flower" /></a>';
		} else {
			$wpd_shortcodes_default_image = site_url() . '/wp-content/plugins/wp-dispensary/public/images/' . $imagesize . '.jpg';
			$defaultimg                   = apply_filters( 'wpd_shortcodes_default_image', $wpd_shortcodes_default_image );
			$showimage                    = '<a href="' . get_permalink( $flower_id ) . '"><img src="' . $defaultimg . '" alt="Menu - Flower" /></a>';
		}

		/** Wrap start */
		$list_items_markup .= '<div class="wpdshortcode wpd-flowers">';
		
		/** Image */
		$list_items_markup .= $showimage;

		/** Title */
		if ( true === $attributes['displayName'] ) {
			$list_items_markup .= '<p class="wpd-producttitle"><strong><a href="' . esc_url( get_permalink( $flower_id ) ) . '">' . esc_html( $title ) . '</a></strong></p>';
		}

		$list_items_markup .= $showpricing . '' . $thcinfo . '' . $thcainfo . '' . $cbdinfo . '' . $cbainfo . '' . $cbninfo;

		/** Wrap end */
		$list_items_markup .= '</div>';

	}

	$class = "wp-block-latest-posts align{$attributes['align']}";
	if ( isset( $attributes['layout'] ) && 'grid' === $attributes['layout'] ) {
		$class .= ' is-grid';
	}

	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['layout'] ) {
		$class .= ' columns-' . $attributes['columns'];
	}

	$block_content = sprintf(
		'<div class="wpdispensary %1$s">%2$s</div>',
		esc_attr( $class ),
		$list_items_markup
	);

	return $block_content;
	
}

register_block_type( 'wp-dispensary/flowers-block', array(
	'render_callback' => 'wpd_render_block_flowers',
) );