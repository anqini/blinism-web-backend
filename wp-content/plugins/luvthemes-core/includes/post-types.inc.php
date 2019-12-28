<?php

	add_action('init', 'luv_prepare_post_types');

	/**
	 * Set custom post types in global $luv_post_types array
	 */
	function luv_prepare_post_types() {
		global $fevr_options;
		global $luv_post_types;

		$luv_post_types = array (

			'portfolio' => array (
				'name' => 'luv_portfolio',
				'args' => array (
					'labels' => array (
						'name'               => esc_html__( 'Portfolio', 'fevr' ),
						'singular_name'      => esc_html__( 'Portfolio', 'fevr' ),
						'menu_name'          => esc_html__( 'Portfolio', 'fevr' ),
						'name_admin_bar'     => esc_html__( 'Project', 'fevr' ),
						'add_new'            => esc_html__( 'Add New', 'fevr' ),
						'add_new_item'       => esc_html__( 'Add New Project', 'fevr' ),
						'new_item'           => esc_html__( 'New Project', 'fevr' ),
						'edit_item'          => esc_html__( 'Edit Project', 'fevr' ),
						'view_item'          => esc_html__( 'View Project', 'fevr' ),
						'all_items'          => esc_html__( 'All Projects', 'fevr' ),
						'search_items'       => esc_html__( 'Search Projects', 'fevr' ),
						'parent_item_colon'  => esc_html__( 'Parent Project:', 'fevr' ),
						'not_found'          => esc_html__( 'No project found.', 'fevr' ),
						'not_found_in_trash' => esc_html__( 'No project found in Trash.', 'fevr' )
				),
			      'description'        => esc_html__( 'Description.', 'fevr' ),
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => true,
					'rewrite'            => array( 'slug' => (isset($fevr_options['custom-portfolio-slug']) && !empty($fevr_options['custom-portfolio-slug']) ? $fevr_options['custom-portfolio-slug'] : 'portfolio'), 'with_front' => apply_filters('portfolio_slug_with_front', false) ),
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => null,
					'menu_icon'			 => 'dashicons-images-alt',
					'supports'           => array( 'title', 'editor', 'thumbnail', 'comments' )
				),
			),

			'snippets' => array (
				'name' => 'luv_snippets',
				'args' => array (
					'labels' => array (
						'name'               => esc_html__( 'Snippets', 'fevr' ),
						'singular_name'      => esc_html__( 'Snippet', 'fevr' ),
						'menu_name'          => esc_html__( 'Snippets', 'fevr' ),
						'name_admin_bar'     => esc_html__( 'Snippet', 'fevr' ),
						'add_new'            => esc_html__( 'Add New', 'fevr' ),
						'add_new_item'       => esc_html__( 'Add New Snippet', 'fevr' ),
						'new_item'           => esc_html__( 'New Snippet', 'fevr' ),
						'edit_item'          => esc_html__( 'Edit Snippet', 'fevr' ),
						'view_item'          => esc_html__( 'View Snippet', 'fevr' ),
						'all_items'          => esc_html__( 'All Snippet', 'fevr' ),
						'search_items'       => esc_html__( 'Search Snippet', 'fevr' ),
						'parent_item_colon'  => esc_html__( 'Parent Snippet:', 'fevr' ),
						'not_found'          => esc_html__( 'No snippet found.', 'fevr' ),
						'not_found_in_trash' => esc_html__( 'No snippet found in Trash.', 'fevr' )
				),
			      'description'        => esc_html__( 'Description.', 'fevr' ),
					'public'             => apply_filters('luv_snippets_is_public',true),
					'exclude_from_search' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => false,
					'rewrite'            => array( 'slug' => 'snippets'),
					'has_archive'        => false,
					'hierarchical'       => false,
					'menu_position'      => null,
					'menu_icon'			 => 'dashicons-editor-code',
					'supports'           => array( 'title', 'editor')
				),
			),

			'collections' => array (
				'name' => 'luv_collections',
				'args' => array (
					'labels' => array (
						'name'               => esc_html__( 'Collections', 'fevr' ),
						'singular_name'      => esc_html__( 'Collection', 'fevr' ),
						'menu_name'          => esc_html__( 'Collections', 'fevr' ),
						'name_admin_bar'     => esc_html__( 'Collection', 'fevr' ),
						'add_new'            => esc_html__( 'Add New', 'fevr' ),
						'add_new_item'       => esc_html__( 'Add New Collection', 'fevr' ),
						'new_item'           => esc_html__( 'New Collection', 'fevr' ),
						'edit_item'          => esc_html__( 'Edit Collection', 'fevr' ),
						'view_item'          => esc_html__( 'View Collection', 'fevr' ),
						'all_items'          => esc_html__( 'Collections', 'fevr' ),
						'search_items'       => esc_html__( 'Search Collection', 'fevr' ),
						'parent_item_colon'  => esc_html__( 'Parent Collection:', 'fevr' ),
						'not_found'          => esc_html__( 'No collection found.', 'fevr' ),
						'not_found_in_trash' => esc_html__( 'No collection found in Trash.', 'fevr' )
				),
			      'description'        => esc_html__( 'Description.', 'fevr' ),
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => 'edit.php?post_type=product',
					'query_var'          => true,
					'rewrite'            => array( 'slug' => (isset($fevr_options['woocommerce-collections-custom-slug']) && !empty($fevr_options['woocommerce-collections-custom-slug']) ? $fevr_options['woocommerce-collections-custom-slug'] : 'collections'), 'with_front' => false ),
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => null,
					'supports'           => array( 'title', 'editor', 'thumbnail' ),
					'capabilities' => array(
							'edit_post'          => 'manage_woocommerce',
							'read_post'          => 'manage_woocommerce',
							'delete_post'        => 'manage_woocommerce',
							'edit_posts'         => 'manage_woocommerce',
							'edit_others_posts'  => 'manage_woocommerce',
							'delete_posts'       => 'manage_woocommerce',
							'publish_posts'      => 'manage_woocommerce',
							'read_private_posts' => 'manage_woocommerce'
					),
				),
			),

			'photo_reviews' => array (
				'name' => 'luv_ext_reviews',
				'args' => array (
					'labels' => array (
					'name'               => esc_html__( 'Photo Reviews', 'fevr' ),
					'singular_name'      => esc_html__( 'Photo Review', 'fevr' ),
					'menu_name'          => esc_html__( 'Photo Reviews', 'fevr' ),
					'name_admin_bar'     => esc_html__( 'Review', 'fevr' ),
					'add_new'            => esc_html__( 'Add New', 'fevr' ),
					'add_new_item'       => esc_html__( 'Add New Review', 'fevr' ),
					'new_item'           => esc_html__( 'New Review', 'fevr' ),
					'edit_item'          => esc_html__( 'Edit Review', 'fevr' ),
					'view_item'          => esc_html__( 'View Review', 'fevr' ),
					'all_items'          => esc_html__( 'Photo Reviews', 'fevr' ),
					'search_items'       => esc_html__( 'Search Review', 'fevr' ),
					'parent_item_colon'  => esc_html__( 'Parent Review:', 'fevr' ),
					'not_found'          => esc_html__( 'No review found.', 'fevr' ),
					'not_found_in_trash' => esc_html__( 'No review found in Trash.', 'fevr' )
				),
			      'description'        => esc_html__( 'Description.', 'fevr' ),
					'public'             => true,
					'publicly_queryable' => true,
					'exclude_from_search' => true,
					'show_ui'            => true,
					'show_in_menu'       => 'edit.php?post_type=product',
					'query_var'          => true,
					'rewrite'            => array( 'slug' => (isset($fevr_options['woocommerce-photo-reviews-custom-slug']) && !empty($fevr_options['woocommerce-photo-reviews-custom-slug']) ? $fevr_options['woocommerce-photo-reviews-custom-slug'] : 'reviews'), 'with_front' => apply_filters('photo_reviews_slug_with_front', false) ),
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => null,
					'supports'           => array( 'title', 'editor', 'comments' ),
					'capabilities' => array(
							'edit_post'          => 'manage_woocommerce',
							'read_post'          => 'manage_woocommerce',
							'delete_post'        => 'manage_woocommerce',
							'edit_posts'         => 'manage_woocommerce',
							'edit_others_posts'  => 'manage_woocommerce',
							'delete_posts'       => 'manage_woocommerce',
							'publish_posts'      => 'manage_woocommerce',
							'read_private_posts' => 'manage_woocommerce'
					),
				),
			),

			'slider' => array (
				'name' => 'luv_slider',
				'args' => array (
					'labels'  => array (
					'name'               => esc_html__( 'Slider', 'fevr' ),
					'singular_name'      => esc_html__( 'Slider', 'fevr' ),
					'menu_name'          => esc_html__( 'Luv Slider', 'fevr' ),
					'name_admin_bar'     => esc_html__( 'Slider', 'fevr' ),
					'add_new'            => esc_html__( 'Add New', 'fevr' ),
					'add_new_item'       => esc_html__( 'Add New Slider', 'fevr' ),
					'new_item'           => esc_html__( 'New Slider', 'fevr' ),
					'edit_item'          => esc_html__( 'Edit Slider', 'fevr' ),
					'view_item'          => esc_html__( 'View Slider', 'fevr' ),
					'all_items'          => esc_html__( 'All Slider', 'fevr' ),
					'search_items'       => esc_html__( 'Search Slider', 'fevr' ),
					'parent_item_colon'  => esc_html__( 'Parent Slider:', 'fevr' ),
					'not_found'          => esc_html__( 'No slider found.', 'fevr' ),
					'not_found_in_trash' => esc_html__( 'No slider found in Trash.', 'fevr' )
				),
			      'description'       	   => esc_html__( 'Description.', 'fevr' ),
					'public'             => false,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => false,
					'rewrite'            => array( 'slug' => 'slider', 'with_front' => false ),
					'has_archive'        => false,
					'hierarchical'       => false,
					'menu_position'      => null,
					'menu_icon'		   => 'dashicons-slides',
					'supports'           => array( 'title' )
				),
			),

		);
	}
?>
