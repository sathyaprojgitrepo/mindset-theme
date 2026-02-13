 <?php

/**
 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
 * based on the registered block metadata. Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function mindset_blocks_mindset_blocks_block_init() {
	wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
}
add_action( 'init', 'mindset_blocks_mindset_blocks_block_init' );



	/**
	* Registers the custom fields for some blocks.
	*
	* @see https://developer.wordpress.org/reference/functions/register_post_meta/
	*/
	function mindset_register_custom_fields() {
		register_post_meta(
			'page',
			'company_email',
			array(
			'type'         => 'string',
			'show_in_rest' => true,
			'single'       => true
		)
	);
			register_post_meta(
				'page',
				'company_address',
	 	     	array(
				'type'         => 'string',
				'show_in_rest' => true,
				'single'       => true
			)
		);
	}
		add_action( 'init', 'mindset_register_custom_fields' );
	
	function mindset_blocks_render_callbacks( $args, $name ) {
    
    if ( 'mindset-blocks/services' === $name ) {
        $args['render_callback'] = 'fwd_render_service_posts';
    }

    return $args;
}

add_filter( 'register_block_type_args', 'mindset_blocks_render_callbacks', 10, 2 );

function fwd_render_service_posts( $attributes ) {

    ob_start();
    ?>

    <div <?php echo get_block_wrapper_attributes(); ?>>

        <?php
        // FIRST QUERY — navigation links
        $nav_query = new WP_Query(array(
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        if ( $nav_query->have_posts() ) : ?>
            <nav class="services-nav">
                <?php while ( $nav_query->have_posts() ) : $nav_query->the_post(); ?>
                    <a href="#post-<?php echo esc_attr( get_the_ID() ); ?>">
                        <?php echo esc_html( get_the_title() ); ?>
                    </a>
                <?php endwhile; ?>
            </nav>
        <?php endif;

        wp_reset_postdata();


        // Services grouped by taxonomy
        $taxonomy = 'service-type';

        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));

        if ( $terms && ! is_wp_error( $terms ) ) :
            foreach ( $terms as $term ) :

                $query = new WP_Query(array(
                    'post_type' => 'service',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'term_id',
                            'terms' => array( $term->term_id ),

                        )
                    ),
                ));
              

                if ( $query->have_posts() ) :
        ?>

            <section>
                <h2><?php echo esc_html( $term->name ); ?></h2>

                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <article id="post-<?php echo esc_attr( get_the_ID() ); ?>">
                        <h3><?php echo esc_html( get_the_title() ); ?></h3>
                        <?php the_content(); ?>
                    </article>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </section>

        <?php
                endif;
            endforeach;
        endif;
        ?>

    </div>

    <?php
    return ob_get_clean();
}
