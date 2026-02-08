
	/**
	* Retrieves the translation of text.
	*
	* @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
	*/
	import { __ } from '@wordpress/i18n';

	/**
	* Provides utilities to interact with block props and render block content.
	* - useBlockProps: Handles block wrapper attributes like className and styles.
	* - RichText: A component for rich text editing within blocks.
	* - InspectorControls: Allows adding custom controls to the block editor sidebar.
	* 
	* @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/
	*/
	import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';

	/**
	* Enables interaction with WordPress entities (e.g., posts, users) using the core data store.
	* - useEntityProp: Allows easy access to WordPress custom fields.
	* 
	* @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-core-data/#useentityprop
	*/
	import { useEntityProp } from '@wordpress/core-data';

	/**
	* Provides pre-built UI components for creating block settings in the editor.
	* - PanelBody: Groups settings into collapsible panels.
	* - PanelRow: Lays out content or controls in rows within a panel.
	* - ToggleControl: A toggle switch control for boolean settings.
	* 
	* @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/
	* @see https://developer.wordpress.org/block-editor/reference-guides/components/toggle-control/
	*/
	import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';

	/**
	* The edit function describes the structure of your block in the context of the
	* editor. This represents what the editor will render when the block is used.
	*
	* @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
	*
	* @return {Element} Element to render.
	*/
	export default function Edit( {attributes, setAttributes} ) {

		// Set the post ID of your Contact Page
		const postID = 156;
		
		// Fetch meta data as an object and the setMeta function
		const [meta, setMeta] = useEntityProp('postType', 'page', 'meta', postID);

		// Destructure all our meta data for ease of use
		const { company_email } = meta;

		// Flexible helper for setting a single meta value w/o mutating state
		const updateMeta = ( key, value ) => {
			setMeta( { ...meta, [key]: value } );
		};

		const { svgIcon } = attributes;

return (
	<>
		<div { ...useBlockProps() }>
			<address>
				{ svgIcon && (
					<svg
						xmlns="http://www.w3.org/2000/svg"
						viewBox="0 0 512 512"
						width="24"
						height="24"
						fill="currentColor"
						aria-hidden="true"
					>
						<path d="M256 64C150 64 64 150 64 256s86 192 192 192c17.7 0 32 14.3 32 32s-14.3 32-32 32C114.6 512 0 397.4 0 256S114.6 0 256 0 512 114.6 512 256v32c0 53-43 96-96 96-29.3 0-55.6-13.2-73.2-33.9-22.8 21-53.3 33.9-86.8 33.9-70.7 0-128-57.3-128-128s57.3-128 128-128c27.9 0 53.7 8.9 74.7 24.1 5.7-5 13.1-8.1 21.3-8.1 17.7 0 32 14.3 32 32v112c0 17.7 14.3 32 32 32s32-14.3 32-32v-32c0-106-86-192-192-192zm64 192a64 64 0 1 0-128 0 64 64 0 1 0 128 0z" />
					</svg>
				) }

				<RichText
					tagName="p"
					placeholder={ __( 'Enter email here...', 'company-email' ) }
					value={ company_email }
					onChange={ ( nextValue ) =>
						updateMeta( 'company_email', nextValue )
					}
				/>
			</address>
		</div>

		<InspectorControls>
			<PanelBody title={ __( 'Settings', 'company-address' ) }>
				<PanelRow>
					<ToggleControl
						label={ __( 'Show SVG Icon', 'company-email' ) }
						checked={ svgIcon }
						onChange={ ( value ) =>
							setAttributes( { svgIcon: value } )
						}
						help={ __(
							'Display an SVG icon next to the email.',
							'company-email'
						) }
					/>
				</PanelRow>
			</PanelBody>
		</InspectorControls>
	</>
);
}
