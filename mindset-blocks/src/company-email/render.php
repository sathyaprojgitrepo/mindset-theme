<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>

<address <?php echo get_block_wrapper_attributes(); ?>>
	<?php if ( $attributes['svgIcon'] ) : ?>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24" role="img" aria-label="Email Icon">
			<path d="M256 64C150 64 64 150 64 256s86 192 192 192c17.7 0 32 14.3 32 32s-14.3 32-32 32C114.6 512 0 397.4 0 256S114.6 0 256 0 512 114.6 512 256l0 32c0 53-43 96-96 96-29.3 0-55.6-13.2-73.2-33.9-22.8 21-53.3 33.9-86.8 33.9-70.7 0-128-57.3-128-128s57.3-128 128-128c27.9 0 53.7 8.9 74.7 24.1 5.7-5 13.1-8.1 21.3-8.1 17.7 0 32 14.3 32 32l0 112c0 17.7 14.3 32 32 32s32-14.3 32-32l0-32c0-106-86-192-192-192zm64 192a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/>
		</svg>
	<?php endif; ?>
	<p>
		<a href="mailto:<?php echo esc_attr( get_post_meta( 156, 'company_email', true ) ); ?>">
			<?php echo esc_html( get_post_meta( 156, 'company_email', true ) ); ?>
		</a>
	</p>
</address>
					
					
