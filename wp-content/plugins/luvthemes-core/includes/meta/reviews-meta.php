<?php

//======================================================================
// Meta boxes for Reviews
//======================================================================
 
add_action( 'add_meta_boxes', 'luv_reviews_meta_box' );

/**
 * Add Photo review attachment meta box to Post editor for Photo review post type
 */
function luv_reviews_meta_box() {
	add_meta_box(
		'luv-reviews-main',
		esc_html__('Review Attachments', 'fevr'),
		'luv_create_reviews_meta_box_callback',
		'luv_ext_reviews',
		'normal',
		'high'
	);
}

if(!function_exists('luv_create_reviews_meta_box_callback')):

	function luv_create_reviews_meta_box_callback() {
		$images = get_attached_media('image');
		echo '<ul id="luv-review-attachments">';
		
		foreach($images as $image) {
			echo '<li>
					'.wp_get_attachment_image($image->ID, 'thumbnail').'
					<a class="remove-photo-review-image luv-btn-red luv-btn" data-id="'.$image->ID.'" href="#">Remove</a>
				</li>';
		}
		
		echo '</ul>';
	}
	
endif;
		
?>