/**
 * BLOCK: Dispensary Blocks Page Grid
 */

// Import block dependencies and components
import classnames from 'classnames';
import edit from './edit';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block controls
const {
	registerBlockType,
} = wp.blocks;

// Register alignments
const validAlignments = [ 'center', 'wide' ];

// Register the block
registerBlockType( 'dispensary-blocks/wpd-growers-grid', {
	title: __( 'WP Dispensary Growers', 'dispensary-blocks' ),
	description: __( 'Add a grid or list of customizable products to your page.', 'dispensary-blocks' ),
	icon: 'grid-view',
	category: 'dispensary-blocks',
	keywords: [
		__( 'products', 'dispensary-blocks' ),
		__( 'grid', 'dispensary-blocks' ),
		__( 'dispensary', 'dispensary-blocks' ),
	],

	getEditWrapperProps( attributes ) {
		const { align } = attributes;
		if ( -1 !== validAlignments.indexOf( align ) ) {
			return { 'data-align': align };
		}
	},

	edit,

	// Render via PHP
	save() {
		return null;
	},
} );
