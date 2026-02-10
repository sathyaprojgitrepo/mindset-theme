<?php
	function mindset_enqueues() {

		wp_enqueue_style( 
			'mindset-normalize', 
			'https://unpkg.com/@csstools/normalize.css', 
			array(), 
			'12.1.0'
		);

		// Load style.css on the front-end
		// Parameters: Unique handle, Source, Dependencies, Version number, Media
			wp_enqueue_style( 
				'mindset-style',
				get_stylesheet_uri(),
				array(),
				wp_get_theme()->get( 'Version' ),
				'all'
			);

             wp_enqueue_script(
                'mindset-scroll-to-top', 
                 get_theme_file_uri( 'assets/js/scroll-to-top.js' ), 
                 array(), 
                 wp_get_theme()->get( 'Version' ), 
                 array( 'strategy' => 'defer' ) 
               );
		
			wp_enqueue_script(
				'mindset-script',
				get_template_directory_uri(). '/js/mindset.js',
				array(),
				'1.0.0',
				true
			
			);

	}

	add_action( 'wp_enqueue_scripts', 'mindset_enqueues' );
	
    function mindset_setup() {

	// load style.css in the block editor

		// Crop images to 400px by 500px
				add_image_size( '400x500', 400, 500, true );
    	// Crop images to 200px by 250px
			add_image_size( '200x250', 200, 250, true );

			add_image_size( '800x400', 800, 400, true );
			add_image_size( '400x200', 400, 200, true );

	
			add_editor_style( get_stylesheet_uri() );
		}
		add_action( 'after_setup_theme', 'mindset_setup' );

    // Make custom sizes selectable from WordPress admin.
		function mindset_add_custom_image_sizes( $size_names ) {
			$new_sizes = array(

		    	'800x400' => __( '800x400', 'mindset-theme' ),
                '400x200' => __( '400x200', 'mindset-theme' ),

				'400x500' => __( '400x500', 'mindset-theme' ),	
				'200x250' => __( '200x250', 'mindset-theme' ),
			);
				return array_merge( $size_names, $new_sizes );
		}
			add_filter( 'image_size_names_choose', 'mindset_add_custom_image_sizes' );

	// Load custom blocks.
	require get_theme_file_path() . '/mindset-blocks/mindset-blocks.php';

/**
	* Custom Post Types & Custom Taxonomies
	*/
	require get_template_directory() . '/inc/post-types-taxonomies.php';

	function mindset_enqueue_contact_scroll_script() {

    if ( is_page( 156 ) ) {
        wp_enqueue_script(
            'mindset-contact-scripts', // Handle for new JS
            get_theme_file_uri( 'assets/js/contact-scroll.js' ), // Path to the new JS
            array( 'mindset-scroll-to-top' ), // Make the original Scroll-to-Top JS a dependency
            wp_get_theme()->get( 'Version' ),
            true // Load in footer
        );
    }
}
add_action( 'wp_enqueue_scripts', 'mindset_enqueue_contact_scroll_script' );

function mindset_register_service_cpt() {

    $args = array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array(
            'title',
            'editor',
        ),
        'show_in_rest' => true
    );

    register_post_type( 'service', $args );
}

add_action( 'init', 'mindset_register_service_cpt' );


       
	
                        