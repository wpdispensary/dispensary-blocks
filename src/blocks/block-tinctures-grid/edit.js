/**
 * External dependencies
 */

import get from 'lodash/get';
import isUndefined from 'lodash/isUndefined';
import pickBy from 'lodash/pickBy';
import moment from 'moment';
import classnames from 'classnames';
import { stringify } from 'querystringify';

const { Component, Fragment } = wp.element;

const { __ } = wp.i18n;

const { decodeEntities } = wp.htmlEntities;

const { apiFetch } = wp;

const {
	registerStore,
	withSelect,
} = wp.data;

const {
	PanelBody,
	Placeholder,
	QueryControls,
	RangeControl,
	SelectControl,
	Spinner,
	TextControl,
	ToggleControl,
	Toolbar,
	withAPIData,
} = wp.components;

const {
	InspectorControls,
	BlockAlignmentToolbar,
	BlockControls,
} = wp.editor;

const MAX_POSTS_COLUMNS = 5;

class WPDProductsBlock extends Component {
	constructor() {
		super( ...arguments );

		this.toggleDisplayProductTitle = this.toggleDisplayProductTitle.bind( this );
		this.toggleDisplayProductImage = this.toggleDisplayProductImage.bind( this );
		this.toggleDisplayProductPrice = this.toggleDisplayProductPrice.bind( this );
		this.toggleDisplayProductDetails = this.toggleDisplayProductDetails.bind( this );
	}

	// Product image toggle.
	toggleDisplayProductImage() {
		const { displayProductImage } = this.props.attributes;
		const { setAttributes } = this.props;

		setAttributes( { displayProductImage: ! displayProductImage } );
	}

	// Product title toggle.
	toggleDisplayProductTitle() {
		const { displayProductTitle } = this.props.attributes;
		const { setAttributes } = this.props;

		setAttributes( { displayProductTitle: ! displayProductTitle } );
	}

	// Product prices toggle.
	toggleDisplayProductPrice() {
		const { displayProductPrice } = this.props.attributes;
		const { setAttributes } = this.props;

		setAttributes( { displayProductPrice: ! displayProductPrice } );
	}

	// Product details toggle.
	toggleDisplayProductDetails() {
		const { displayProductDetails } = this.props.attributes;
		const { setAttributes } = this.props;

		setAttributes( { displayProductDetails: ! displayProductDetails } );
	}

	render() {
		const { attributes, categoriesList, setAttributes, latestProducts } = this.props;
		const { displayProductDetails, displayProductPrice, displayProductImage, displayProductTitle, align, postLayout, columns, order, orderBy, categories, postsToShow, imageCrop } = attributes;

		// Thumbnail options
		const imageCropOptions = [
			{ value: 'landscape', label: __( 'Landscape' ) },
			{ value: 'square', label: __( 'Square' ) },
		];

		const isLandscape = imageCrop === 'landscape';

		const inspectorControls = (
			<InspectorControls>
				<PanelBody title={ __( 'Block Settings' ) }>
					<QueryControls
						{ ...{ order, orderBy } }
						numberOfItems={ postsToShow }
						categoriesList={ categoriesList }
						selectedCategoryId={ categories }
						onOrderChange={ ( value ) => setAttributes( { order: value } ) }
						onOrderByChange={ ( value ) => setAttributes( { orderBy: value } ) }
						onCategoryChange={ ( value ) => setAttributes( { categories: '' !== value ? value : undefined } ) }
						onNumberOfItemsChange={ ( value ) => setAttributes( { postsToShow: value } ) }
					/>
					{ postLayout === 'grid' &&
						<RangeControl
							label={ __( 'Columns' ) }
							value={ columns }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
							min={ 2 }
							max={ ! hasProducts ? MAX_POSTS_COLUMNS : Math.min( MAX_POSTS_COLUMNS, latestProducts.length ) }
						/>
					}
					<ToggleControl
						label={ __( 'Display Featured Image' ) }
						checked={ displayProductImage }
						onChange={ this.toggleDisplayProductImage }
					/>
					{ displayProductImage &&
						<SelectControl
							label={ __( 'Featured Image Style' ) }
							options={ imageCropOptions }
							value={ imageCrop }
							onChange={ ( value ) => this.props.setAttributes( { imageCrop: value } ) }
						/>
					}
					<ToggleControl
						label={ __( 'Display Product Title' ) }
						checked={ displayProductTitle }
						onChange={ this.toggleDisplayProductTitle }
					/>
					<ToggleControl
						label={ __( 'Display Product Price' ) }
						checked={ displayProductPrice }
						onChange={ this.toggleDisplayProductPrice }
					/>
					<ToggleControl
						label={ __( 'Display Product Details' ) }
						checked={ displayProductDetails }
						onChange={ this.toggleDisplayProductDetails }
					/>
				</PanelBody>
			</InspectorControls>
		);

		const hasProducts = Array.isArray( latestProducts ) && latestProducts.length;
		if ( ! hasProducts ) {
			return (
				<Fragment>
					{ inspectorControls }
					<Placeholder
						icon="grid-view"
						label={ __( 'WP Dispensary Products' ) }
					>
						{ ! Array.isArray( latestProducts ) ?
							<Spinner /> :
							__( 'No products found.' )
						}
					</Placeholder>
				</Fragment>
			);
		}

		// Removing posts from display should be instant.
		const displayProducts = latestProducts.length > postsToShow ?
			latestProducts.slice( 0, postsToShow ) :
			latestProducts;

		const layoutControls = [
			{
				icon: 'grid-view',
				title: __( 'Grid View' ),
				onClick: () => setAttributes( { postLayout: 'grid' } ),
				isActive: postLayout === 'grid',
			},
			{
				icon: 'list-view',
				title: __( 'List View' ),
				onClick: () => setAttributes( { postLayout: 'list' } ),
				isActive: postLayout === 'list',
			},
		];

		return (
			<Fragment>
				{ inspectorControls }
				<BlockControls>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) => {
							setAttributes( { align: value } );
						} }
						controls={ [ 'center', 'wide' ] }
					/>
					<Toolbar controls={ layoutControls } />
				</BlockControls>
				<div
					className={ classnames(
						this.props.className,
						'wpd-block-product-grid',
					) }
				>
					<div
						className={ classnames( {
							'is-grid': postLayout === 'grid',
							'is-list': postLayout === 'list',
							[ `columns-${ columns }` ]: postLayout === 'grid',
							'wpd-block-product-grid' : 'wpd-block-product-grid'
						} ) }
					>
						{ displayProducts.map( ( product, i ) =>
							<article
								key={ i }
								className={ classnames(
									product.featured_image_small && displayProductImage ? 'has-thumb' : 'no-thumb'
								) }
							>
								{
									displayProductImage && product.featured_image_small !== undefined && product.featured_image_small ? (
										<div className="wpd-block-product-grid-image">
											<img
												src={ isLandscape ? product.featured_image_default : product.featured_image_small }
												alt={ decodeEntities( product.title.rendered.trim() ) || __( '(Untitled)' ) }
											/>
										</div>
									) : (
										null
									)
								}

								<div className="wpd-block-product-grid-text">
									{ displayProductTitle &&
										<h2 className="entry-title"><a href={ product.link } target="_blank" rel="bookmark">{ decodeEntities( product.title.rendered.trim() ) || __( '(Untitled)' ) }</a></h2>
									}

									<div className="wpd-block-product-grid-byline">
										{ displayProductPrice && product.prices &&
											<span dangerouslySetInnerHTML={ { __html: product.prices } } />
										}

										{ displayProductDetails && product.details &&
											<span dangerouslySetInnerHTML={ { __html: product.details } } />
										}
									</div>
								</div>
							</article>
						) }
					</div>
				</div>
			</Fragment>
		);
	}
}

export default withSelect( ( select, props ) => {
	const { postsToShow, order, orderBy, categories } = props.attributes;
	const { getEntityRecords } = select( 'core' );
	const latestProductsQuery = pickBy( {
		wpd_tinctures_category: categories,
		order,
		orderby: orderBy,
		per_page: postsToShow,
	}, ( value ) => ! isUndefined( value ) );

	const categoriesListQuery = {
		per_page: 100,
	};
	return {
		latestProducts: getEntityRecords( 'postType', 'tinctures', latestProductsQuery ),
		categoriesList: getEntityRecords( 'taxonomy', 'wpd_tinctures_category', categoriesListQuery ),
	};
} )( WPDProductsBlock );