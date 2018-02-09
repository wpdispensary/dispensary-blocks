( function( blocks, components, i18n, element ) {
	var el = element.createElement;
	var children = blocks.source.children;
	var BlockControls = wp.blocks.BlockControls;
	var AlignmentToolbar = wp.blocks.AlignmentToolbar;
	var InspectorControls = wp.blocks.InspectorControls;
	var TextControl = wp.blocks.InspectorControls.TextControl;
    var ToggleControl = wp.blocks.InspectorControls.ToggleControl;

	/**
	 * Example of a custom SVG path taken from fontastic
	*/
	const iconWPD = el('svg', { width: 20, height: 20 },
	  el('path', { d: "M12.5,12H12v-0.5c0-0.3-0.2-0.5-0.5-0.5H11V6h1l1-2c-1,0.1-2,0.1-3,0C9.2,3.4,8.6,2.8,8,2V1.5C8,1.2,7.8,1,7.5,1 S7,1.2,7,1.5V2C6.4,2.8,5.8,3.4,5,4C4,4.1,3,4.1,2,4l1,2h1v5c0,0-0.5,0-0.5,0C3.2,11,3,11.2,3,11.5V12H2.5C2.2,12,2,12.2,2,12.5V13 h11v-0.5C13,12.2,12.8,12,12.5,12z M7,11H5V6h2V11z M10,11H8V6h2V11z" } )
	);

	blocks.registerBlockType( 'wp-dispensary/flowers-block', { // The name of our block. Must be a string with prefix. Example: my-plugin/my-custom-block.
		title: i18n.__( 'Flowers' ), // The title of our block.
		icon: iconWPD, // Dashicon icon for our block. Custom icons can be added using inline SVGs.
		category: 'common', // The category of the block.
		attributes: { // Necessary for saving block content.
			menuTitle: {
				type: 'array',
				source: 'children',
				selector: 'h3'
			},
			alignment: {
				type: 'string',
				default: 'center'
			},
			flowersCount: {
				type: 'number',
				default: 3
			},
            displayImage: {
                type: 'bool',
            },
            displayName: {
                type: 'bool',
            },
            displayPrice: {
                type: 'bool',
            },
            displayTHC: {
                type: 'bool',
            },
            displayTHCA: {
                type: 'bool',
            },
            displayCBD: {
                type: 'bool',
            },
            displayCBA: {
                type: 'bool',
            },
            displayCBN: {
                type: 'bool',
            },
		},

		edit: function( props ) {

			var focus = props.focus;
			var focusedEditable = props.focus ? props.focus.editable || 'menuTitle' : null;
			var alignment = props.attributes.alignment;
			var attributes = props.attributes;

			var flowersCount = props.attributes.flowersCount;
			var displayImage = props.attributes.displayImage;
			var displayName = props.attributes.displayName;
			var displayPrice = props.attributes.displayPrice;
			var displayTHC = props.attributes.displayTHC;
			var displayTHCA = props.attributes.displayTHCA;
			var displayCBD = props.attributes.displayCBD;
			var displayCBA = props.attributes.displayCBA;
			var displayCBN = props.attributes.displayCBN;

			var onSelectImage = function( media ) {
				return props.setAttributes( {
					mediaURL: media.url,
					mediaID: media.id,
				} );
			};

			function onChangeAlignment( newAlignment ) {
				props.setAttributes( { alignment: newAlignment } );
			}

			return [
				!! focus && el( // Display controls when the block is clicked on.
					blocks.BlockControls,
					{ key: 'controls' },
					el(
						blocks.AlignmentToolbar,
						{
							value: alignment,
							onChange: onChangeAlignment,
						}
					),
					el( 'div', { className: 'components-toolbar' },
						el(
							blocks.MediaUpload,
							{
								onSelect: onSelectImage,
								type: 'image',
								render: function( obj ) {
									return el( components.Button, {
										className: 'components-icon-button components-toolbar__control',
										onClick: obj.open
										},
										el( 'svg', { className: 'dashicon dashicons-edit', width: '20', height: '20' },
											el( 'path', { d: "M2.25 1h15.5c.69 0 1.25.56 1.25 1.25v15.5c0 .69-.56 1.25-1.25 1.25H2.25C1.56 19 1 18.44 1 17.75V2.25C1 1.56 1.56 1 2.25 1zM17 17V3H3v14h14zM10 6c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zm3 5s0-6 3-6v10c0 .55-.45 1-1 1H5c-.55 0-1-.45-1-1V8c2 0 3 4 3 4s1-3 3-3 3 2 3 2z" } )
										)
									);
								}
							},
						)
					)
				),
				
				// This adds the inspector controls when you click into your Flowers Block.

				!! focus && el(
					blocks.InspectorControls,
					{ key: 'inspector' },

					el( 'div', { className: 'components-block-description' }, // A brief description of our block in the inspector.
						el( 'p', {}, i18n.__( 'Edit the WP Dispensary Flowers block' ) ),
					),

					el( 'h2', {}, i18n.__( 'Block Options' ) ), // A title for our block options.

					el(
						TextControl,
						{
							type: 'number',
							label: i18n.__( 'Items to display' ),
							value: flowersCount,
							onChange: function( newCount ) {
								props.setAttributes( { flowersCount: newCount } );
							},
						}
					),

                    el(
                        ToggleControl,
                        {
                            label: 'Display Image',
                            checked: displayImage,
                            instanceId: 'wpd-blocks-flowers-display-image',
                            onChange: function ( event ) {
                                props.setAttributes( { displayImage: ! props.attributes.displayImage } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display Name',
                            checked: displayName,
                            instanceId: 'wpd-blocks-flowers-display-name',
                            onChange: function ( event ) {
                                props.setAttributes( { displayName: ! props.attributes.displayName } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display Price',
                            checked: displayPrice,
                            instanceId: 'wpd-blocks-flowers-display-price',
                            onChange: function ( event ) {
                                props.setAttributes( { displayPrice: ! props.attributes.displayPrice } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display THC%',
                            checked: displayTHC,
                            instanceId: 'wpd-blocks-flowers-display-thc',
                            onChange: function ( event ) {
                                props.setAttributes( { displayTHC: !props.attributes.displayTHC } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display THCA%',
                            checked: displayTHCA,
                            instanceId: 'wpd-blocks-flowers-display-thca',
                            onChange: function ( event ) {
                                props.setAttributes( { displayTHCA: !props.attributes.displayTHCA } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display CBD%',
                            checked: displayCBD,
                            instanceId: 'wpd-blocks-flowers-display-cbd',
                            onChange: function ( event ) {
                                props.setAttributes( { displayCBD: !props.attributes.displayCBD } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display CBA%',
                            checked: displayCBA,
                            instanceId: 'wpd-blocks-flowers-display-cba',
                            onChange: function ( event ) {
                                props.setAttributes( { displayCBA: !props.attributes.displayCBA } );
                            }
                        }
                    ),

                    el(
                        ToggleControl,
                        {
                            label: 'Display CBN%',
                            checked: displayCBN,
                            instanceId: 'wpd-blocks-flowers-display-cbn',
                            onChange: function ( event ) {
                                props.setAttributes( { displayCBN: !props.attributes.displayCBN } );
                            }
                        }
                    ),

				),

				// This is the visible part of the block in the editor screen

				el( 'div', { className: props.className },

					el( 'div', {
						className: 'wpd-blocks-content', style: { textAlign: alignment } },
						// This is an editable part of the block, where the TITLE of the block should show up
						el( blocks.Editable, {
							tagName: 'h3',
							inline: false,
							placeholder: i18n.__( 'Menu - Flowers' ),
							value: attributes.menuTitle,
							onChange: function( newTitle ) {
								props.setAttributes( { menuTitle: newTitle } );
							},
							focus: focusedEditable === 'menuTitle' ? focus : null,
							onFocus: function( focus ) {
								props.setFocus( _.extend( {}, focus, { editable: 'menuTitle' } ) );
							},
						} ),
						// These elements are only editable via the sidebar area of the editor screen
						el( 'div', { className: 'wpd-blocks-flowers' },

							attributes.flowersCount &&
							el( 'a', {
									className: 'social-link',
									href: attributes.flowersCount, // this is the # of posts we'll be displaying in the output based on user input
									target: '_blank',
								},
								el( 'i', { className: 'fa fa-facebook', } ),
							),
							/** This code is only here to see that the on/off switch for "displayPrice" works on the backend */
							attributes.displayPrice &&
							el( 'a', {
									className: 'social-link',
									href: attributes.displayPrice,
									target: '_blank',
								},
								el( 'i', { className: 'fa fa-youtube', } ),
							),

						),
					),
				)
			];
		},
		save: function() {
			// Rendering in PHP
			return null;
		},
	} );

} )(
	window.wp.blocks,
	window.wp.components,
	window.wp.i18n,
	window.wp.element,
);
