<?php

//======================================================================
// Register 
//======================================================================

// Create ajax hook for get collection items
add_action('wp_ajax_get_collection_items', 'luv_get_collection_items');

/**
 * Get Collection items via ajax
 */
function luv_get_collection_items() {
	// Verify nonce
	if ( ! isset( $_POST['wp_nonce'] ) || !wp_verify_nonce( $_POST['wp_nonce'], 'fevr' ) ) {
		die;
	}

	// Check permissions
	if ( ! current_user_can( 'edit_posts' ) ) {
		die;
	}
	
	$paged = ( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;
	$exclude = isset($_POST['exclude']) ? explode(',', trim($_POST['exclude'], ',')) : array();
	$filter = isset($_POST['s']) ? $_POST['s'] : '';
	$prod_cat = isset($_POST['prod_cat']) && !empty($_POST['prod_cat']) ? explode(',', trim($_POST['prod_cat'], ',')) : array();
	
	// Arguments
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 15,
		'paged' => $paged,
		'post__not_in' => $exclude,
		's' => $filter,
	);

	if(!empty($prod_cat)) {
		//$args['tax_query'] = array();
		$args['tax_query'][] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $prod_cat,
			)
		);
	}
	
	// Query
	$products_query = new WP_Query( $args );

	echo '<ul class="luv-clearfix luv-product-container">';
	
	if ( $products_query->have_posts() ) : while ( $products_query->have_posts() ) : $products_query->the_post();
	?>
	
	<li data-product-id="<?php the_ID(); ?>" class="luv-items">
		<span class="luv-product-title"><?php the_title(); ?></span>
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail('shop_single'); } ?>
	</li>
	
	<?php 
		endwhile;
	else:
		esc_html_e('Sorry, no products matched your criteria.', 'fevr');
	endif;
	echo '</ul>';
	wp_reset_postdata();
	echo '<ul class="collection-pages luv-clearfix">';
	for($i = 1; $i <= $products_query->max_num_pages; $i++) {
		echo '<li '.($i == $paged ? 'class="selected-page"' : '').'><a href="#" data-page="'.$i.'">'.$i.'</a></li>';
	}
	echo '</ul>';
	wp_die();
}

//======================================================================
// Meta box for Collection
//======================================================================

add_action( 'add_meta_boxes', 'luv_collection_meta_box' );

/**
 * Add collection meta boxes to Post editor for Collection post type
 */
function luv_collection_meta_box() {
	add_meta_box(
		'luv-collection-main',
		esc_html__('Drag & Drop Collection Builder', 'fevr'),
		'luv_create_collection_meta_box_callback',
		'luv_collections',
		'normal',
		'high'
	);
}

if(!function_exists('luv_create_collection_meta_box_callback')):
	
	function luv_create_collection_meta_box_callback($post) {
		wp_nonce_field( 'luv_meta_box', 'luv_meta_box_nonce' );
		
		$meta_value = get_post_meta( $post->ID, 'fevr_meta', true );
		
		echo '<div class="luv-meta-container">';
		
			echo '<div class="luv-selected-items">';
			
				echo '<ul class="luv-clearfix">';
					echo '<li class="luv-dummy-item" data-product-id="">
							<span class="luv-product-title"></span>
							<input type="hidden" name="fevr_meta[collection-items][]" value="">
							<a href="#" class="remove-product luv-btn-red luv-btn" data-product-id="">'.esc_html__('Remove', 'fevr').'</a>
						</li>';
					echo '<li class="luv-drop-zone"><span class="dashicons dashicons-plus-alt"></span></li>';
				
				if(isset($meta_value['collection-items']) && !empty($meta_value['collection-items'])) {
					// Arguments
					$args = array(
						'post_type' => 'product',
						'post__in' => $meta_value['collection-items'],
						'orderby' => 'post__in'
					);
					
					// Query
					$selected_products_query = new WP_Query( $args );
					
					if ( $selected_products_query->have_posts() ) : while ( $selected_products_query->have_posts() ) : $selected_products_query->the_post();
					?>
					
					<li data-product-id="<?php the_ID(); ?>">
						<span class="luv-product-title"><?php the_title(); ?></span>
						<input type="hidden" name="fevr_meta[collection-items][]" value="<?php the_ID(); ?>">
						<a href="#" class="remove-product luv-btn-red luv-btn" data-product-id="<?php the_ID(); ?>"><?php esc_html_e('Remove', 'fevr'); ?></a>
						<?php if ( has_post_thumbnail() ) { the_post_thumbnail('shop_single'); } ?>
					</li>
					
					<?php 
						endwhile;
					endif;
				}
				
				echo '</ul>';
				
			echo '</div>';
			echo '<div class="luv-products">';
				echo '<input type="text" class="luv-product-search" placeholder="'.esc_html__('Start typing..', 'fevr').'">';
				$product_categories = get_terms('product_cat', 'orderby=name');

				echo '<div class="luv-category-container">';
					echo '<a href="#" class="category-dropdown-toggle">'.esc_html__('Select a category..', 'fevr').'</a>';
					echo '<ul>';
						foreach($product_categories as $category) {
							echo '<li><input id="prod_cat_'.$category->term_id.'" type="checkbox" name="luvthemes_product_cat[]" value="'.$category->term_id.'"><label for="prod_cat_'.$category->term_id.'"><span class="dashicons dashicons-yes"></span> '.$category->name.'</label></li>';
						}
					echo '</ul>';
				echo '</div>';
				echo '<div class="luv-clearfix"></div>';
				
				echo '<div class="luv-product-outer luv-clearfix" data-paged="1">';
					echo '<ul class="luv-clearfix luv-product-container">';
					
						// Arguments
						$args = array(
							'post_type' => 'product',
							'posts_per_page' => 15,
							'post__not_in' => isset($meta_value['collection-items']) ? $meta_value['collection-items'] : ''
						);
						
						// Query
						$products_query = new WP_Query( $args );
						
						if ( $products_query->have_posts() ) : while ( $products_query->have_posts() ) : $products_query->the_post();
						?>
						
						<li data-product-id="<?php the_ID(); ?>" class="luv-items">
							<span class="luv-product-title"><?php the_title(); ?></span>
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail('shop_single'); } ?>
						</li>
						
						<?php 
							endwhile;
						
						else:
							esc_html_e('Sorry, no products matched your criteria.', 'fevr');
						endif;
						wp_reset_postdata();
					
					echo '</ul>';
					
					echo '<ul class="collection-pages luv-clearfix">';
					for($i = 1; $i <= $products_query->max_num_pages; $i++) {
						echo '<li '.($i == 1 ? 'class="selected-page"' : '').'><a href="#" data-page="'.$i.'">'.$i.'</a></li>';
					}
					echo '</ul>';
				echo '</div>';
				
			echo '</div>';
		
		echo '</div>';
	}
	
endif;

//======================================================================
// Meta Fields for Display
//======================================================================

add_action( 'add_meta_boxes', 'luv_collection_display_meta_box' );

/**
 * Display meta boxes
 */
function luv_collection_display_meta_box() {
	
	global $fevr_options;

	$vertical_alignment = array( 
		'name' => esc_html__('Vertical Text Alignment', 'fevr'),
		'id' => 'collections-masonry-v-text-alignment',
		'type' => 'buttonset',
		'options' => array(
			'vertical-top' => esc_html__('Top', 'fevr'),
			'vertical-center' => esc_html__('Center', 'fevr'),
			'vertical-bottom' => esc_html__('Bottom', 'fevr'),
		),
		'default' => 'vertical-center'
	);

	$meta_box = array(
		'id' => 'luv-collection-settings',
		'title' =>  esc_html__('Display Settings', 'fevr'),
		'desc' => 'Item display settings',
		'post_type' => 'luv_collections',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
				'name' => esc_html__('Horizontal Text Alignment', 'fevr'),
				'id' => 'collections-masonry-h-text-alignment',
				'type' => 'buttonset',
				'options' => array(
					'is-left' => esc_html__('Left', 'fevr'),
					'is-center' => esc_html__('Center', 'fevr'),
					'is-right' => esc_html__('Right', 'fevr'),
				),
				'default' => 'is-center'
			),
			$vertical_alignment,
			array( 
				'name' => esc_html__('Accent Color', 'fevr'),
				'desc' => esc_html__('Main color that influences some parts of the item.', 'fevr'),
				'id' => 'collections-masonry-accent-color',
				'type' => 'color',
			),
			array( 
				'name' => esc_html__('Text Color', 'fevr'),
				'desc' => esc_html__('Select the most appropriate text color for the item', 'fevr'),
				'id' => 'collections-masonry-text-color',
				'type' => 'color',
			),
			array( 
				'name' => esc_html__('Collection Excerpt', 'fevr'),
				'desc' => esc_html__('Short description about the collection. The content will appear on the archive page, if set in "Theme Options".', 'fevr'),
				'id' => 'collections-excerpt',
				'type' => 'text',
				'default' => ''
			),
		)
	);
	
	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);
}

?>