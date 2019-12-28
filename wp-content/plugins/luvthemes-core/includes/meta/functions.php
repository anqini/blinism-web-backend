<?php
//======================================================================
// Create Meta Box Function
//======================================================================

if(!function_exists('luv_create_meta_box_callback')):

/**
 * Create post/page metaboxes
* @param WP_Post object $post
* @param array $meta_box
*/
function luv_create_meta_box_callback($post, $meta_box) {
	global $luv_font_id;

	// Prevent Saving Meta Boxes What's Only for Preview of values
	$editor_only_prefix = (isset($meta_box['args']['editor_only']) && $meta_box['args']['editor_only'] ? '_' : '');

	wp_nonce_field( 'luv_meta_box', 'luv_meta_box_nonce' );

	echo '<div class="luv-meta-container '.(isset($meta_box['args']['tabs']) && !empty($meta_box['args']['tabs']) ? 'has-tabs' : '').'">';
	echo isset($meta_box['args']['desc']) && !empty($meta_box['args']['desc']) ? $meta_box['args']['desc'] : '';

	if(isset($meta_box['args']['tabs']) && !empty($meta_box['args']['tabs'])){
		echo '<ul class="luv-meta-tabs">';
		foreach($meta_box['args']['tabs'] as $tab){
			echo '<li '.(isset($tab['class']) && !empty($tab['class']) ? 'class="'.$tab['class'].'"' : '').' data-tab="'.$tab['id'].'">'.(isset($tab['icon']) && !empty($tab['icon']) ? '<i class="fa fa-'.$tab['icon'].'"></i> ' : '').$tab['title'].'</li>';
		}
		echo '</ul>';
	}

	if(isset($meta_box['args']['tabs']) && !empty($meta_box['args']['tabs'])) {
		echo '<div class="luv-meta-tab-content">';
	}

	foreach($meta_box['args']['fields'] as $field) {

		if(!empty($field) && is_array($field)) {
			$meta_value = get_post_meta( $post->ID, 'fevr_meta', true );
			$meta_value = is_array($meta_value) && isset($meta_value[$field['id']]) ? $meta_value[$field['id']] : '';
			$default_value = isset($field['default']) ? $field['default'] : '';

			echo '<div '.(isset($field['tab']) && $field['tab'] != '' ? 'data-tab="'.$field['tab'].'"' : '').' class="'. $field['id'] .'_container luv-meta-field-section '.(isset($field['required']) && $field['required'] != '' ? 'luv-required' : '').'"
				'.(isset($field['required']) && $field['required'] != '' ? 'style="display: none;"' : '').'
				'.(isset($field['required']) && $field['required'] != '' ? 'data-required-name="'.$editor_only_prefix.'fevr_meta['.$field['required'][0].']" data-required-compare="'.$field['required'][1].'" data-required-value="'.$field['required'][2].'"' : '').'>';

			echo '<label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong><span>'. (isset($field['desc']) ? $field['desc'] : '') .'</span></label>';

			echo '<div class="luv-meta-field-container">';

			switch( $field['type'] ){

				case 'text':
					echo '<input type="text" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'">';
					break;

				case 'luv_url':
					echo '<div class="luv-existing-content-outer">'.
							'<input type="url" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'">'.
							'<a href="#" class="luv-existing-content-switch">'.esc_html__('Or link an existing content', 'fevr').'</a>'.
							'<div class="luv-existing-content-container luv-hidden">'.
							'<input type="text" class="luv-existing-content-filter" placeholder="'.esc_html__('Search..', 'fevr').'">'.
							'<ul></ul>'.
							'</div>'.
							'</div>';
					break;


				case 'number':
					if (isset($field['extra']['responsive']) && $field['extra']['responsive'] === true){
						echo '<div class="responsive-number-set">';
						echo '<input type="hidden" class="responsive-number" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'" data-default="'. $default_value . '" ' . (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') . ' data-unit="' . (isset($field['extra']['unit'][0]) ? $field['extra']['unit'][0] : '') . '">';
						echo '<div class="responsive-field-icon"><i class="fa fa-desktop"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="desktop">';
						echo '<div class="responsive-field-icon"><i class="fa fa-laptop"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="laptop">';
						echo '<div class="responsive-field-icon"><i class="fa fa-tablet fa-rotate-90"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="tablet-landscape">';
						echo '<div class="responsive-field-icon"><i class="fa fa-tablet"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="tablet-portrait">';
						echo '<div class="responsive-field-icon"><i class="fa fa-mobile"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="mobile">';
						echo '</div>';
					}
					else{
						echo '<input type="number" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'"' . '" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'" data-default="'. $default_value . '" ' . (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') . ' data-unit="' . (isset($field['extra']['unit'][0]) ? $field['extra']['unit'][0] : '') . '">';
					}
					break;

				case 'color':
					echo '<input type="text" class="redux-color redux-color-init compiler wp-color-picker" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'">';
					break;

				case 'textarea':
					if (isset($field['shortcode'])){
						echo '<a href="#" class="button metafield-luv-shortcode-generator">'.esc_html__('Luvthemes Shortcodes', 'fevr').'</a>';
					}
					echo '<textarea name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'">'. esc_textarea(isset($meta_value) ? $meta_value : $default_value) .'</textarea>';
					break;

				case 'editor' :
					$settings = array(
					'textarea_name' => $editor_only_prefix.'fevr_meta['. $field['id'] .']',
					'editor_class' => '',
					'wpautop' => true,
					'drag_drop_upload' => true,
					'tinymce' => !(isset($field['disable_tinymce']) ? $field['disable_tinymce'] : false),
					);
					wp_editor($meta_value, $field['id'], $settings );
					break;

				case 'select':
				case 'clone-settings':
					if (isset($field['data'])){
						switch($field['data']){
							case 'nav_menu':
								$data = array_merge(array((object)array('slug' => '', 'name' => '')), wp_get_nav_menus());
								foreach((array)$data as $_data){
									$field['options'][$_data->slug] = $_data->name;
								}
								break;
								case 'page':
								  global $wpdb;
									$data = $wpdb->get_results('SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_type = "page" AND post_status IN ("publish", "draft")', ARRAY_A);
									foreach((array)$data as $_data){
										$field['options'][$_data['ID']] = $_data['post_title'];
									}
								break;
								case 'post':
									global $wpdb;
									$data = $wpdb->get_results('SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_type = "post" AND post_status IN ("publish", "draft")', ARRAY_A);
									foreach((array)$data as $_data){
										$field['options'][$_data['ID']] = $_data['post_title'];
									}
								break;
								case 'luv_portfolio':
									global $wpdb;
									$data = $wpdb->get_results('SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_type = "luv_portfolio" AND post_status IN ("publish", "draft")', ARRAY_A);
									foreach((array)$data as $_data){
										$field['options'][$_data['ID']] = $_data['post_title'];
									}
								break;
								case 'luv_snippet':
									global $wpdb;
									$data = $wpdb->get_results('SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_type = "luv_snippet" AND post_status IN ("publish", "draft")', ARRAY_A);
									foreach((array)$data as $_data){
										$field['options'][$_data['ID']] = $_data['post_title'];
									}
								break;
								case 'current':
									global $wpdb;
									$data = $wpdb->get_results($wpdb->prepare('SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_type = %s AND post_status IN ("publish", "draft")', get_post_type()), ARRAY_A);
									foreach((array)$data as $_data){
										$field['options'][$_data['ID']] = $_data['post_title'];
									}
								break;
						}
					}
					echo '<div class="luv-custom-select">';
					echo '<select name="'.$editor_only_prefix. ($field['type'] == 'clone-settings' ? '_' : '') .'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'">';
					foreach( $field['options'] as $key => $option ){
						echo '<option value="' . $key . '"';
						if (isset($meta_value) && !empty($meta_value)) {
							if ($meta_value == $key) echo ' selected="selected"';
						} else {
							if ($default_value == $key) echo ' selected="selected"';
						}
						echo '>'. $option .'</option>';
					}
					echo '</select>';
					echo '</div>';
					if ($field['type'] == 'clone-settings'){
						echo '<div class="clone-settings-container">';
						echo '<button class="luv-btn luv-btn-blue clone-settings">' . esc_html__('Clone Settings', 'fevr') . '</button>';
						echo '</div>';
					}
					break;

				case 'checkbox':
					$checked = '';
					if(!empty($meta_value)) {
						if($meta_value == 'enabled') {
							$checked = ' checked="checked"';
						}
					} else {
						if($default_value == 'enabled') {
							$checked = ' checked="checked"';
						}
					}

					echo '<input type="hidden" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" value="disabled"'. $checked .'><input type="checkbox" id="'. $field['id'] .'" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" value="enabled"'. $checked .' ' . (isset($field['class']) && !empty($field['class']) ? 'class="' . $field['class'] . '"' : '') . '><label for="' . $field['id'] . '" '. (isset($field['class']) && !empty($field['class']) ? 'class="' . $field['class'] . '"' : '') . '></label>';
					break;

				case 'file_img':

					// When the field is repeatable we have to add container
					if(isset($field['repeat']) && $field['repeat'] == true) {
						echo '<div class="luv-repeatable '.(isset($field['sortable']) && $field['sortable'] == true ? 'luv-sortable' : '').'">';

						if(empty($meta_value)) {
							echo '<div class="luv-media-upload-container media-image">';
							echo '<input type="hidden" id="'. $field['id'] .'" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .'][]" class="luv-media-upload-url" value="'. esc_attr(isset($_meta_value) ? $_meta_value : $default_value) .'">';
							echo '<div class="luv-gallery-img-container"><img src="'. esc_attr((isset($_meta_value) ? $_meta_value : $default_value)) .'" class="luv-media-upload-preview '. (isset($_meta_value) ? '' : 'is-hidden') .'"></div>';
							echo '<div class="luv-media-buttons">';
							echo '<span class="button media_upload_button luv-media-upload">'. (isset($_meta_value) ? esc_html__('Modify', 'fevr') : esc_html__('Upload', 'fevr')) .'</span>';
							echo '<span class="button remove-image luv-media-upload-reset '. (isset($_meta_value) ? '' : 'is-hidden') .'">Remove</span>';
							echo '<span class="button luv-repeat-field '. (isset($_meta_value) ? '' : 'is-hidden') .'">'.esc_html__('Add New', 'fevr').'</span>';
							echo '</div>';
							echo '</div>';
						} else {
							foreach ($meta_value as $_meta_value) {
								echo '<div class="luv-media-upload-container media-image">';
								echo '<input type="hidden" id="'. $field['id'] .'" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .'][]" class="luv-media-upload-url" value="'. esc_attr(isset($_meta_value) ? $_meta_value : $default_value) .'">';
								echo '<div class="luv-gallery-img-container"><img src="'. esc_attr(($_meta_value ? $_meta_value : $default_value)) .'" class="luv-media-upload-preview '. ($_meta_value ? '' : 'is-hidden') .'"></div>';
								echo '<div class="luv-media-buttons">';
								echo '<span class="button media_upload_button luv-media-upload">'. ($_meta_value ? esc_html__('Modify', 'fevr') : esc_html__('Upload', 'fevr')) .'</span>';
								echo '<span class="button remove-image luv-media-upload-reset '. ($_meta_value ? '' : 'is-hidden') .'">Remove</span>';
								echo '<span class="button luv-repeat-field '. ($_meta_value ? '' : 'is-hidden') .'">'.esc_html__('Add New', 'fevr').'</span>';
								echo '</div>';
								echo '</div>';
							}
						}
						echo '</div>';

					} else {

						echo '<div class="luv-media-upload-container media-image">';
						echo '<input type="hidden" id="'. $field['id'] .'" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" class="luv-media-upload-url" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'">';
						echo '<img src="'. esc_attr(($meta_value ? $meta_value : $default_value)) .'" class="luv-media-upload-preview '. ($meta_value ? '' : 'is-hidden') .'">';
						echo '<div class="luv-media-buttons">';
						echo '<span class="button media_upload_button luv-media-upload">'. (!empty($meta_value) ? esc_html__('Modify', 'fevr') : esc_html__('Upload', 'fevr')) .'</span>';
						echo '<span class="button remove-image luv-media-upload-reset '. (!empty($meta_value) ? '' : 'is-hidden') .'">Remove</span>';
						echo '</div>';
						echo '</div>';
					}

					break;

				case 'file':

					echo '<div class="luv-media-upload-container media-file">';
					echo '<input type="text" id="'. $field['id'] .'" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" class="luv-media-upload-url" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'">';
					echo '<div class="luv-media-buttons">';
					echo '<span class="button media_upload_button luv-media-upload">'. (!empty($meta_value) ? esc_html__('Modify', 'fevr') : esc_html__('Upload', 'fevr')) .'</span>';
					echo '<span class="button remove-image luv-media-upload-reset '. (!empty($meta_value) ? '' : 'is-hidden') .'">Remove</span>';
					echo '</div>';
					echo' </div>';

					break;

				case 'buttonset':
					echo '<div class="luv-buttonset">';
					foreach( $field['options'] as $key => $option ){

						echo '<input type="radio" id="'. $field['id'] .'_'. $key .'" data-id="'. $field['id'] .'" name="'.$editor_only_prefix.'fevr_meta['. $field["id"] .']" value="'. $key .'" ';
						if( !empty($meta_value) ){
							if($meta_value == $key) {
								echo ' checked="checked"';
							}
						} else {
							if($default_value == $key) {
								echo ' checked="checked"';
							}
						}
						echo '>';
						echo '<label for="'. $field['id'] .'_'. $key .'"> '.$option.'</label>';

					}
					echo '</div>';
					break;

				case 'luv_font':
					$luv_font_id = mt_rand(0,99999);
					echo '<div class="luv-custom-select"><select name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" class="luv-font" data-luv-font-id="'.$luv_font_id.'">';
					foreach( (array)$field['options'] as  $option => $key ){
						echo '<option value="' . $key . '"';
						if (isset($meta_value) && !empty($meta_value)) {
							if ($meta_value == $key) echo ' selected="selected"';
						} else {
							if ($default_value == $key) echo ' selected="selected"';
						}
						echo '>'. $option .'</option>';
					}
					echo '</select></div>'.
							'<div class="luv-font-preview">'.esc_html__('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'fevr').'</div>'.
							'<script>jQuery(\'.luv-font\').trigger(\'change\');</script>';
					break;

				case 'luv_font_weight':
					echo '<div class="luv-custom-select"><select name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" class="luv-font-weight-'.$luv_font_id.'" data-value="'.esc_attr($meta_value).'">';
					foreach( $field['options'] as  $option => $key ){
						echo '<option value="' . $key . '"';
						if (isset($meta_value) && !empty($meta_value)) {
							if ($meta_value == $key) echo ' selected="selected"';
						} else {
							if ($default_value == $key) echo ' selected="selected"';
						}
						echo '>'. $option .'</option>';
					}
					echo '</select></div>';
					break;
					case 'address_picker':
						@list($lat, $lon) = explode(',',($meta_value ? $meta_value : $default_value));
						wp_enqueue_script('google-maps', '//maps.google.com/maps/api/js?key='._get_luvoption('google-maps-api-key').'&v=3&libraries=places');
						wp_enqueue_script('luvthemes-locationpicker', LUVTHEMES_CORE_URI . 'assets/js/locationpicker.js', array('jquery'), LUVTHEMES_CORE_VER);
						echo '<input type="text" id="'. $field['id'] .'-holder"><div id="'.$field['id'] .'-container" style="width: 500px; height: 400px;"></div>';
						echo '<input type="hidden" name="'.$editor_only_prefix.'fevr_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. esc_attr($meta_value ? $meta_value : $default_value) .'">';
						echo '<script>jQuery(function(){jQuery("#'.$field['id'] .'-container").locationpicker({' . (!empty($lat) && !empty($lon) ? 'location: {latitude: '.esc_attr($lat).',longitude: '.esc_attr($lon) . '},' : '' ).'enableAutocomplete: true, radius: 1,inputBinding: {locationNameInput: jQuery("#'.$field['id'].'-holder")},onchanged: function (currentLocation, radius, isMarkerDropped) {jQuery("#'.$field['id'].'").val(currentLocation.latitude + "," + currentLocation.longitude);}})});;</script>';
					break;

			}

			echo '</div>'; // end of meta field container

			echo '</div>'; // end of meta field section
		}
	}
	if(isset($meta_box['args']['tabs']) && !empty($meta_box['args']['tabs'])) {
		echo '</div>'; // end of content tab
	}

	echo '</div>'; // end of meta box container

}
endif;

//======================================================================
// Save Meta box Function
//======================================================================

add_action( 'save_post', 'luv_save_meta_box_data' );

/**
 * Save custom post meta
 * @param id $post_id
 */
function luv_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['luv_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['luv_meta_box_nonce'], 'luv_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Remove empty elements in gallery
	if (isset($_POST['fevr_meta']['post-gallery-slider'])) {
		$_POST['fevr_meta']['post-gallery-slider'] = luv_remove_empty_elements( $_POST['fevr_meta']['post-gallery-slider'] );
	}

	// Remove empty elements in collections
	if (isset($_POST['fevr_meta']['collection-items'])) {
		$_POST['fevr_meta']['collection-items'] = luv_remove_empty_elements( $_POST['fevr_meta']['collection-items'] );
	}

	// Remove empty elements in slider
	if (isset($_POST['fevr_meta']['slider'])){
		while ($_POST['fevr_meta']['slider'] != luv_remove_empty_elements( $_POST['fevr_meta']['slider'] )){
			$_POST['fevr_meta']['slider'] = luv_remove_empty_elements( $_POST['fevr_meta']['slider'] );
		}
	}

	// Convert JSON strings to array for slider parallax layers
	if (isset($_POST['fevr_meta']['slider'])){
		foreach ((array)$_POST['fevr_meta']['slider'] as $key=>$slider){
			if (isset($_POST['fevr_meta']['slider'][$key]['slide-parallax-layer-list'])){
				$_POST['fevr_meta']['slider'][$key]['slide-parallax-layer-list'] = json_decode(stripslashes($slider['slide-parallax-layer-list']), true);
			}
		}
	}

	// update_post_meta( $post_id, 'fevr_meta', $_POST['fevr_meta'] );
	update_post_meta( $post_id, 'fevr_meta', isset($_POST['fevr_meta']) ? $_POST['fevr_meta'] : array() );
	// Clone settings
  if (isset($_POST['luv-clone-settings']) && $_POST['luv-clone-settings'] == 'true' && isset($_POST['_fevr_meta']['clone-settings']) && !empty($_POST['_fevr_meta']['clone-settings'])){
			update_post_meta( $post_id, 'fevr_meta', get_post_meta($_POST['_fevr_meta']['clone-settings'], 'fevr_meta', true));
	}
}

/**
 * Recursive remove empty elements from array
 * @param array
 * @return array
 */
function luv_remove_empty_elements($array){
	foreach ((array)$array as $key=>$value){
		if (is_array($value)){
			if (empty($value)){
				unset($array[$key]);
			} else {
				$array[$key] = luv_remove_empty_elements($value);
			}
		} else {
			if (empty($value)){
				unset($array[$key]);
			}
		}
	}
	return $array;
}
?>
