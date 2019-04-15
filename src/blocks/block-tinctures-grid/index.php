<?php
/**
 * Server-side rendering for the products block
 *
 * @since 	1.0.0
 * @package Dispensary Blocks
 */

/**
 * Renders the products block on server.
 */
function dispensary_blocks_render_block_core_latest_tinctures( $attributes ) {

	// Get categories (if any).
	$categories = isset( $attributes['categories'] ) ? $attributes['categories'] : '';

	// Create empty tax query.
	$tax_query = array();

	// Add categories to tax query.
	if ( '' !== $categories ) {
		$tax_query[] = array(
			'taxonomy' => 'wpd_tinctures_category',
			'field'    => 'term_id',
			'terms'    => $categories
		);
	}

	// Get products.
	$recent_products = wp_get_recent_posts( array(
		'post_status'      => 'publish',
		'post_type'        => 'tinctures',
		'numberposts'      => $attributes['postsToShow'],
		'order'            => $attributes['order'],
		'orderby'          => $attributes['orderBy'],
		'tax_query'        => $tax_query
	), 'OBJECT' );

	// Start item markup.
	$list_items_markup = '';

	// Recent products check.
	if ( $recent_products ) {
		// Product loop
		foreach ( $recent_products as $product ) {
			// Get the post ID.
			$product_id = $product->ID;

			// Get the post thumbnail.
			$product_thumb_id = get_post_thumbnail_id( $product_id );

			// Add has-thumb class if there's a thumbnail image.
			if ( $product_thumb_id && isset( $attributes['displayProductImage'] ) && $attributes['displayProductImage'] ) {
				$product_thumb_class = 'has-thumb';
			} else {
				$product_thumb_class = 'no-thumb';
			}

			// Start the markup for the post.
			$list_items_markup .= sprintf(
				'<article class="%1$s">',
				esc_attr( $product_thumb_class )
			);

			$list_items_markup .= do_action( 'wpd_shortcode_inside_top' );

			// Get the featured image.
			if ( isset( $attributes['displayProductImage'] ) && $attributes['displayProductImage'] ) {
				if ( 'landscape' === $attributes['imageCrop'] ) {
					$product_thumb_size = 'dispensary-image';
				} else {
					$product_thumb_size = 'wpd-small';
				}

				$list_items_markup .= sprintf(
					'<div class="wpd-block-product-grid-image"><a href="%1$s" rel="bookmark">%2$s</a></div>',
					esc_url( get_permalink( $product_id ) ),
					get_wpd_product_image( $product_id, $product_thumb_size )
				);
			}

			// Wrap the text content.
			$list_items_markup .= sprintf(
				'<div class="wpd-block-product-grid-text">'
			);

				// Get the product title.
				$title = get_the_title( $product_id );

				if ( ! $title ) {
					$title = __( 'Products', 'dispensary-blocks' );
				}

				if ( isset( $attributes['displayProductTitle'] ) && $attributes['displayProductTitle'] ) {
					$list_items_markup .= sprintf(
						'<h2 class="wpd-block-product-grid-title"><a href="%1$s" rel="bookmark">%2$s</a></h2>',
						esc_url( get_permalink( $product_id ) ),
						esc_html( $title )
					);
				}

				// Wrap content.
				$list_items_markup .= sprintf(
					'<div class="wpd-block-product-grid-byline">'
				);

					// Product Price.
					if ( isset( $attributes['displayProductPrice'] ) && $attributes['displayProductPrice'] ) {
						$list_items_markup .= sprintf(
							'<div class="wpd-block-product-grid-author">%1$s</div>',
							get_wpd_all_prices_simple( $product_id, TRUE )
						);
					}

					// Display product details.
					$product_details = array(
						'thc'         => 'show',
						'thca'        => '',
						'cbd'         => '',
						'cba'         => '',
						'cbn'         => '',
						'cbg'         => '',
						'seed_count'  => 'show',
						'clone_count' => 'show',
						'total_thc'   => 'show',
						'size'        => 'show',
						'servings'    => 'show',
						'weight'      => 'show'
					);

					// Filter product details.
					$product_details = apply_filters( 'wpd_tinctures_block_product_details', $product_details );

					// Product Details.
					if ( isset( $attributes['displayProductDetails'] ) && $attributes['displayProductDetails'] ) {
						$list_items_markup .= get_wpd_product_details( $product_id, $product_details );
					}

					//var_dump( wpd_product_details( $product_id, $product_details ) );

				// Close the byline content
				$list_items_markup .= sprintf(
					'</div>'
				);

				// Wrap the excerpt content
				$list_items_markup .= sprintf(
					'<div class="wpd-block-product-grid-excerpt">'
				);

					// Get the excerpt
					$excerpt = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $product_id, 'display' ) );

					if ( empty( $excerpt ) ) {
						$excerpt = apply_filters( 'the_excerpt', wp_trim_words( $product->post_content, 55 ) );
					}

					if ( ! $excerpt ) {
						$excerpt = null;
					}

				// Close the excerpt content
				$list_items_markup .= sprintf(
					'</div>'
				);

				// Display eCommerce product buttons.
				if ( function_exists( 'get_wpd_ecommerce_product_buttons' ) ) {
					// Get WPD settings from General tab.
					$wpdas_general = get_option( 'wpdas_general' );

					// Check if user is required to be logged in to shop.
					if ( isset( $wpdas_general['wpd_ecommerce_cart_require_login_to_shop'] ) ) {
						$login_to_shop = $wpdas_general['wpd_ecommerce_cart_require_login_to_shop'];
					} else {
						$login_to_shop = NULL;
					}

					// Check if user is required to login to shop.
					if ( ! is_user_logged_in() && 'on' == $login_to_shop ) {
						// Do nothing.
					} else {
						// Add buttons to the various shortcodes, archives, and widgets..
						$list_items_markup .= get_wpd_ecommerce_product_buttons( $product_id );
					}
				}

			// Wrap the text content
			$list_items_markup .= sprintf(
				'</div>'
			);

			// Close the markup for the post
			$list_items_markup .= "</article>\n";
		}
	}

	// Build the classes
	$class = "wpd-block-product-grid align{$attributes['align']}";

	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
	}

	$grid_class = 'wpd-block-product-grid';

	if ( isset( $attributes['postLayout'] ) && 'list' === $attributes['postLayout'] ) {
		$grid_class .= ' is-list';
	} else {
		$grid_class .= ' is-grid';
	}

	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
		$grid_class .= ' columns-' . $attributes['columns'];
	}

	// Output the post markup
	$block_content = sprintf(
		'<div class="%1$s"><div class="%2$s">%3$s</div></div>',
		esc_attr( $class ),
		esc_attr( $grid_class ),
		$list_items_markup
	);

	return $block_content;
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function dispensary_blocks_register_block_core_latest_tinctures() {

	// Check if the register function exists
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type( 'dispensary-blocks/wpd-tinctures-grid', array(
		'attributes' => array(
			'categories' => array(
				'type' => 'string',
			),
			'className' => array(
				'type' => 'string',
			),
			'postsToShow' => array(
				'type'    => 'number',
				'default' => 9,
			),
			'displayProductDetails' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'displayProductExcerpt' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'displayProductPrice' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'displayProductImage' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'displayProductLink' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'displayProductTitle' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'postLayout' => array(
				'type'    => 'string',
				'default' => 'grid',
			),
			'columns' => array(
				'type'    => 'number',
				'default' => 2,
			),
			'align' => array(
				'type'    => 'string',
				'default' => 'center',
			),
			'width' => array(
				'type'    => 'string',
				'default' => 'wide',
			),
			'order' => array(
				'type'    => 'string',
				'default' => 'desc',
			),
			'orderBy' => array(
				'type'    => 'string',
				'default' => 'date',
			),
			'imageCrop' => array(
				'type'    => 'string',
				'default' => 'square',
			),
		),
		'render_callback' => 'dispensary_blocks_render_block_core_latest_tinctures',
	) );
}
add_action( 'init', 'dispensary_blocks_register_block_core_latest_tinctures' );

/**
 * Create API fields for additional info
 */
function dispensary_blocks_register_tinctures_rest_fields() {
	// Add landscape featured image source.
	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback'    => 'dispensary_blocks_get_tinctures_image_src_landscape',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	// Add square featured image source.
	register_rest_field(
		'post',
		'featured_image_src_square',
		array(
			'get_callback'    => 'dispensary_blocks_get_tinctures_image_src_square',
			'update_callback' => null,
			'schema'          => null,
		)
	);

}
add_action( 'rest_api_init', 'dispensary_blocks_register_tinctures_rest_fields' );


/**
 * Get landscape featured image source for the rest field
 */
function dispensary_blocks_get_tinctures_image_src_landscape( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'dispensary-image',
		false
	);
	return $feat_img_array[0];
}

/**
 * Get square featured image source for the rest field
 */
function dispensary_blocks_get_tinctures_image_src_square( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'wpd-small',
		false
	);
	return $feat_img_array[0];
}
