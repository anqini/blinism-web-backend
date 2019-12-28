<?php
	
	add_action('init', 'luv_prepare_taxonomies');
	
	/**
	 * Set custom taxonomies in global $luv_taxonomies array
	 */
	function luv_prepare_taxonomies() {
		global $fevr_options;
		global $luv_taxonomies;
		
		$luv_taxonomies = array (
			
			'portfolio_categories' => array (
				'name' => 'luv_portfolio_categories',
				'post_type' => 'luv_portfolio',
				'args' => array(
					'hierarchical'      => true,
					'labels'            => array (
											'name'              => esc_html_x( 'Portfolio Categories', 'taxonomy general name', 'fevr' ),
											'singular_name'     => esc_html_x( 'Portfolio Categories', 'taxonomy singular name', 'fevr' ),
											'search_items'      => esc_html__( 'Search Category', 'fevr' ),
											'all_items'         => esc_html__( 'All Categories', 'fevr' ),
											'parent_item'       => esc_html__( 'Parent Category', 'fevr' ),
											'parent_item_colon' => esc_html__( 'Parent Category:', 'fevr' ),
											'edit_item'         => esc_html__( 'Edit Category', 'fevr' ),
											'update_item'       => esc_html__( 'Update Category', 'fevr' ),
											'add_new_item'      => esc_html__( 'Add New Category', 'fevr' ),
											'new_item_name'     => esc_html__( 'New Category', 'fevr' ),
											'menu_name'         => esc_html__( 'Portfolio Categories', 'fevr' ),	
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'portfolio-category', 'with_front' => false ),
				)
			),
			
			'portfolio_tags' => array (
				'name' => 'luv_portfolio_tags',
				'post_type' => 'luv_portfolio',
				'args' => array(
					'hierarchical'      => true,
					'labels'            => array (
											'name'              => esc_html_x( 'Portfolio Tags', 'taxonomy general name', 'fevr' ),
											'singular_name'     => esc_html_x( 'Portfolio Tags', 'taxonomy singular name', 'fevr' ),
											'search_items'      => esc_html__( 'Search Tag', 'fevr' ),
											'all_items'         => esc_html__( 'All Tags', 'fevr' ),
											'parent_item'       => esc_html__( 'Parent Tag', 'fevr' ),
											'parent_item_colon' => esc_html__( 'Parent Tag:', 'fevr' ),
											'edit_item'         => esc_html__( 'Edit Tag', 'fevr' ),
											'update_item'       => esc_html__( 'Update Tag', 'fevr' ),
											'add_new_item'      => esc_html__( 'Add New Tag', 'fevr' ),
											'new_item_name'     => esc_html__( 'New Tag', 'fevr' ),
											'menu_name'         => esc_html__( 'Portfolio Tags', 'fevr' ),	
					),
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'portfolio-tag', 'with_front' => false ),
				)
			),
			
		);
		
	}
?>