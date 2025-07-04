( function( wp ) {
	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/#registering-a-block
	 */
	var registerBlockType = wp.blocks.registerBlockType;
	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/packages/packages-element/
	 */
	var el = wp.element.createElement;
	/**
	 * Retrieves the translation of text.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/packages/packages-i18n/
	 */
	var __ = wp.i18n.__;
	var SelectControl = wp.components.SelectControl;
	var CheckboxControl = wp.components.CheckboxControl;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var useSelect = wp.data.useSelect;

	/**
	 * Every block starts by registering a new block type definition.
	 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/#registering-a-block
	 */
	registerBlockType( 'eifu-test/eifu-doc-block', {
		/**
		 * This is the display title for your block, which can be translated with `i18n` functions.
		 * The block inserter will show this name.
		 */
		title: __( 'EIFU Document Block', 'eifu-test' ),

		/**
		 * Blocks are grouped into categories to help users browse and discover them.
		 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
		 */
		category: 'layout',

		/**
		 * Optional block extended support features.
		 */
		supports: {
			// Removes support for an HTML mode.
			html: false,
		},

		/**
		 * The edit function describes the structure of your block in the context of the editor.
		 * This represents what the editor will render when the block is used.
		 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-edit-save/#edit
		 *
		 * @param {Object} [props] Properties passed from the editor.
		 * @return {Element}       Element to render.
		 */
		edit: function( props ) {
			return el(
				'p',
				{ className: props.className },
				__( 'Hello from the editor!', 'eifu-test' )
			);
		},

		/**
		 * The save function defines the way in which the different attributes should be combined
		 * into the final markup, which is then serialized by Gutenberg into `post_content`.
		 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/block-api/block-edit-save/#save
		 *
		 * @return {Element}       Element to render.
		 */
		save: function() {
			return el(
				'p',
				{},
				__( 'Hello from the saved content!', 'eifu-test' )
			);
		}
	} );

	registerBlockType('eifu-test/product-documents', {
		title: __('Product Documents', 'eifu-test'),
		category: 'woocommerce',
		icon: 'media-document',
		supports: {
			html: false,
		},
		attributes: {
			productId: {
				type: 'number',
				default: 0
			},
			showThumbnails: {
				type: 'boolean',
				default: true
			},
			layout: {
				type: 'string',
				default: 'list'
			}
		},

		edit: function(props) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;

			// Get products for selection
			var products = useSelect(function(select) {
				return select('core').getEntityRecords('postType', 'product', {
					per_page: -1,
					status: 'publish'
				});
			}, []);

			var productOptions = products ? products.map(function(product) {
				return {
					label: product.title.rendered,
					value: product.id
				};
			}) : [];

			productOptions.unshift({
				label: __('Select a product...', 'eifu-test'),
				value: 0
			});

			return el('div', {
				className: props.className
			}, [
				el(InspectorControls, {},
					el('div', { style: { padding: '16px' } }, [
						el(SelectControl, {
							label: __('Select Product', 'eifu-test'),
							value: attributes.productId,
							options: productOptions,
							onChange: function(value) {
								setAttributes({ productId: parseInt(value) });
							}
						}),
						el(CheckboxControl, {
							label: __('Show Thumbnails', 'eifu-test'),
							checked: attributes.showThumbnails,
							onChange: function(value) {
								setAttributes({ showThumbnails: value });
							}
						}),
						el(SelectControl, {
							label: __('Layout', 'eifu-test'),
							value: attributes.layout,
							options: [
								{ label: __('List', 'eifu-test'), value: 'list' },
								{ label: __('Grid', 'eifu-test'), value: 'grid' },
								{ label: __('Cards', 'eifu-test'), value: 'cards' }
							],
							onChange: function(value) {
								setAttributes({ layout: value });
							}
						})
					])
				),
				el('div', {
					className: 'eifu-product-documents-preview'
				}, 
					attributes.productId > 0 
						? __('Product Documents for Product ID: ', 'eifu-test') + attributes.productId
						: __('Select a product to display its documents', 'eifu-test')
				)
			]);
		},

		save: function(props) {
			return null; // Render via PHP
		}
	});

	// Document Categories Block
	registerBlockType('eifu-test/document-categories', {
		title: __('Document Categories', 'eifu-test'),
		category: 'widgets',
		icon: 'category',
		
		edit: function(props) {
			return el('div', {
				className: props.className
			}, __('Document Categories will be displayed here', 'eifu-test'));
		},

		save: function() {
			return null; // Render via PHP
		}
	});
} )(
	window.wp
);
