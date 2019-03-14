<?php
/**
 * Server-side rendering for the post grid block
 *
 * @since 	1.1.7
 * @package Dispensary Blocks
 */

/**
 * Renders the post grid block on server.
 */
function dispensary_blocks_render_block_core_latest_posts( $attributes ) {

	$categories = isset( $attributes['categories'] ) ? $attributes['categories'] : '';

	$recent_posts = wp_get_recent_posts( array(
		'post_type'   => 'flowers',
		'numberposts' => $attributes['postsToShow'],
		'post_status' => 'publish',
		'order'       => $attributes['order'],
		'orderby'     => $attributes['orderBy'],
		'category'    => $categories,
	), 'OBJECT' );

	$list_items_markup = '';

	if ( $recent_posts ) {
		foreach ( $recent_posts as $post ) {
			// Get the post ID
			$post_id = $post->ID;

			// Get the post thumbnail
			$post_thumb_id = get_post_thumbnail_id( $post_id );

			if ( $post_thumb_id && isset( $attributes['displayProductImage'] ) && $attributes['displayProductImage'] ) {
				$post_thumb_class = 'has-thumb';
			} else {
				$post_thumb_class = 'no-thumb';
			}

			// Start the markup for the post
			$list_items_markup .= sprintf(
				'<article class="%1$s">',
				esc_attr( $post_thumb_class )
			);

			$list_items_markup .= do_action( 'wpd_shortcode_inside_top' );

			// Get the featured image
			if ( isset( $attributes['displayProductImage'] ) && $attributes['displayProductImage'] && $post_thumb_id ) {
				if ( 'landscape' === $attributes['imageCrop'] ) {
					$post_thumb_size = 'dispensary-image';
				} else {
					$post_thumb_size = 'wpd-small';
				}

				$list_items_markup .= sprintf(
					'<div class="wpd-block-product-grid-image"><a href="%1$s" rel="bookmark">%2$s</a></div>',
					esc_url( get_permalink( $post_id ) ),
					wp_get_attachment_image( $post_thumb_id, $post_thumb_size )
				);
			}

			// Wrap the text content
			$list_items_markup .= sprintf(
				'<div class="wpd-block-product-grid-text">'
			);

				// Get the post title
				$title = get_the_title( $post_id );

				if ( ! $title ) {
					$title = __( 'Products', 'dispensary-blocks' );
				}

				if ( isset( $attributes['displayProductTitle'] ) && $attributes['displayProductTitle'] ) {
					$list_items_markup .= sprintf(
						'<h2 class="wpd-block-product-grid-title"><a href="%1$s" rel="bookmark">%2$s</a></h2>',
						esc_url( get_permalink( $post_id ) ),
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
							get_wpd_all_prices_simple( $post_id, TRUE )
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

					// Product Details.
					if ( isset( $attributes['displayProductDetails'] ) && $attributes['displayProductDetails'] ) {
						$list_items_markup .= get_wpd_product_details( $post_id, $product_details );
					}

					//var_dump( wpd_product_details( $post_id, $product_details ) );

				// Close the byline content
				$list_items_markup .= sprintf(
					'</div>'
				);

				// Wrap the excerpt content
				$list_items_markup .= sprintf(
					'<div class="wpd-block-product-grid-excerpt">'
				);

					// Get the excerpt
					$excerpt = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post_id, 'display' ) );

					if ( empty( $excerpt ) ) {
						$excerpt = apply_filters( 'the_excerpt', wp_trim_words( $post->post_content, 55 ) );
					}

					if ( ! $excerpt ) {
						$excerpt = null;
					}

					if ( isset( $attributes['displayProductExcerpt'] ) && $attributes['displayProductExcerpt'] ) {
						$list_items_markup .=  wp_kses_post( $excerpt );
					}

					if ( isset( $attributes['displayProductLink'] ) && $attributes['displayProductLink'] ) {
						$list_items_markup .= sprintf(
							'<p><a class="wpd-block-product-grid-link wpd-text-link" href="%1$s" rel="bookmark">%2$s</a></p>',
							esc_url( get_permalink( $post_id ) ),
							esc_html( $attributes['readMoreText'] )
						);
					}

				// Close the excerpt content
				$list_items_markup .= sprintf(
					'</div>'
				);

				$list_items_markup .= get_wpd_ecommerce_product_buttons( $post_id );

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
function dispensary_blocks_register_block_core_latest_posts() {

	// Check if the register function exists
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type( 'dispensary-blocks/wpd-product-grid', array(
		'attributes' => array(
			'categories' => array(
				'type' => 'string',
			),
			'className' => array(
				'type' => 'string',
			),
			'postsToShow' => array(
				'type' => 'number',
				'default' => 6,
			),
			'displayProductDetails' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displayProductExcerpt' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displayProductPrice' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displayProductImage' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displayProductLink' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displayProductTitle' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'postLayout' => array(
				'type' => 'string',
				'default' => 'grid',
			),
			'columns' => array(
				'type' => 'number',
				'default' => 2,
			),
			'align' => array(
				'type' => 'string',
				'default' => 'center',
			),
			'width' => array(
				'type' => 'string',
				'default' => 'wide',
			),
			'order' => array(
				'type' => 'string',
				'default' => 'desc',
			),
			'orderBy'  => array(
				'type' => 'string',
				'default' => 'date',
			),
			'imageCrop'  => array(
				'type' => 'string',
				'default' => 'landscape',
			),
			'readMoreText'  => array(
				'type' => 'string',
				'default' => 'Continue Reading',
			),
		),
		'render_callback' => 'dispensary_blocks_render_block_core_latest_posts',
	) );
}

add_action( 'init', 'dispensary_blocks_register_block_core_latest_posts' );


/**
 * Create API fields for additional info
 */
function dispensary_blocks_register_rest_fields() {
	// Add landscape featured image source
	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback'    => 'dispensary_blocks_get_image_src_landscape',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	// Add square featured image source
	register_rest_field(
		'post',
		'featured_image_src_square',
		array(
			'get_callback'    => 'dispensary_blocks_get_image_src_square',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	// Add author info
	register_rest_field(
		'post',
		'author_info',
		array(
			'get_callback'    => 'dispensary_blocks_get_author_info',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}
add_action( 'rest_api_init', 'dispensary_blocks_register_rest_fields' );


/**
 * Get landscape featured image source for the rest field
 */
function dispensary_blocks_get_image_src_landscape( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'wpd-small',
		false
	);
	return $feat_img_array[0];
}

/**
 * Get square featured image source for the rest field
 */
function dispensary_blocks_get_image_src_square( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'wpd-small',
		false
	);
	return $feat_img_array[0];
}

/**
 * Get author info for the rest field
 */
function dispensary_blocks_get_author_info( $object, $field_name, $request ) {
	// Get the author name
	$author_data['display_name'] = get_the_author_meta( 'display_name', $object['author'] );

	// Get the author link
	$author_data['author_link'] = get_author_posts_url( $object['author'] );

	// Return the author data
	return $author_data;
}
