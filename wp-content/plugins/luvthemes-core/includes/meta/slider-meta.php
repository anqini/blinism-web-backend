<?php

//======================================================================
// Meta boxes for Collection
//======================================================================

add_action( 'add_meta_boxes', 'luv_slider_meta_box' );

/**
 * Add "Slider settings" meta box to Post editor for Slider post type
 */
function luv_slider_meta_box() {
	global $luv_hidden_slider_meta_box, $fevr_vc_font_family_list;
	
	$font_weight_list = array(
			esc_html__( 'Default', 'fevr' ) => '',
			esc_html__( '100', 'fevr' ) => '100',
			esc_html__( '200', 'fevr' ) => '200',
			esc_html__( '300', 'fevr' ) => '300',
			esc_html__( '400', 'fevr' ) => '400',
			esc_html__( '500', 'fevr' ) => '500',
			esc_html__( '600', 'fevr' ) => '600',
			esc_html__( '700', 'fevr' ) => '700',
			esc_html__( '800', 'fevr' ) => '800',
			esc_html__( '900', 'fevr' ) => '900'
	);
	
	$text_transform_list = array(
			esc_html__('None', 'fevr') => '',
			esc_html__('Lowercase', 'fevr') => 'lowercase',
			esc_html__('Uppercase', 'fevr') => 'uppercase',
			esc_html__('Capitalize', 'fevr') => 'capitalize',
			esc_html__('Initial', 'fevr') => 'initial',
	);
	
	
	// Add New Slide Meta Box
	
	add_meta_box(
		'luv-slide-previews',
		esc_html__('Slide Previews', 'fevr'),
		'luv_create_slider_meta_box_callback',
		'luv_slider',
		'normal',
		'high'
	);
	
	// Single Slide Settings

	$meta_box = $luv_hidden_slider_meta_box = array(
		'id' => 'slide-meta-boxes',
		'title' =>  esc_html__('Slide Settings', 'fevr'),
		'description' => esc_html__('Here you can find settings related to the slide.', 'fevr'),
		'post_type' => 'luv_slider',
		'context' => 'normal',
		'priority' => 'high',
		'editor_only' => true,
		'fields' => array(
			array( 
				'name' => esc_html__('Slide Type', 'fevr'),
				'desc' => esc_html__('Would you like to display a video or an image on the slide?', 'fevr'),
				'id' => 'slide-type',
				'type' => 'buttonset',
				'options' => array(
					'image' => esc_html__('Image', 'fevr'),
					'video' => esc_html__('Video', 'fevr'),
				),
				'default' => 'image'
			),
			array( 
				'name' => esc_html__('Image', 'fevr'),
				'desc' => esc_html__('For best results it is recommended to upload an image with the width of 1800px and the height of 400px. A larger size image can influence the load time of the page.', 'fevr'),
				'id' => 'slide-image',
				'type' => 'file_img',
				'default' => '',
				'required' => array ('slide-type', '=', 'image'),
			),
			array( 
				'name' => esc_html__('Overlay Color', 'fevr'),
				'desc' => esc_html__('Set a custom color for transparent layer.', 'fevr'),
				'id' => 'slide-overlay-color',
				'type' => 'color',
				'default' => '',
			),
			array( 
				'name' => esc_html__('Overlay Transparency', 'fevr'),
				'desc' => esc_html__('Opacity for overlay color. eg. 0.8', 'fevr'),
				'id' => 'slide-overlay-color-opacity',
				'type' => 'text',
				'default' => '0.8',
			),
			array( 
				'name' => esc_html__('Filter', 'fevr'),
				'desc' => esc_html__('By setting the filter the image will not be modified, it will appear with the selected filter.', 'fevr'),
				'id' => 'slide-filter',
				'type' => 'select',
				'options' => array(
					'' => '',
					'filter-xpro2' => 'X-Pro 2',
					'filter-willow' => 'Willow',
					'filter-walden' => 'Walden',
					'filter-valencia' => 'Valencia',
					'filter-toaster' => 'Toaster',
					'filter-sutro' => 'Sutro',
					'filter-sierra' => 'Sierra',
					'filter-rise' => 'Rise',
					'filter-nashville' => 'Nashville',
					'filter-mayfair' => 'Mayfair',
					'filter-lo-fi' => 'Lo-Fi',
					'filter-kelvin' => 'Kelvin',
					'filter-inkwell' => 'Inkwell',
					'filter-hudson' => 'Hudson',
					'filter-hefe' => 'Hefe',
					'filter-earlybird' => 'Earlybird',
					'filter-brannan' => 'Brannan',
					'filter-amaro' => 'Amaro',
					'filter-1977' => '1977',
				),
				'required' => array('slide-type', '=', 'image'),
			),
			array( 
				'name' => esc_html__('MP4 File URL', 'fevr'),
				'desc' => esc_html__('Please upload the MP4 file. The upload of OGV format is also recommended.', 'fevr'),
				'id' => 'slide-video-mp4',
				'type' => 'file',
				'default' => '',
				'required' => array ('slide-type', '=', 'video'),
			),
			array( 
				'name' => esc_html__('OGV File URL', 'fevr'),
				'desc' => esc_html__('Please upload the OGV file. The upload of MP4 format is also recommended.', 'fevr'),
				'id' => 'slide-video-ogv',
				'type' => 'file',
				'default' => '',
				'required' => array ('slide-type', '=', 'video'),
			),
			array( 
				'name' => esc_html__('Embedded Video', 'fevr'),
				'desc' => esc_html__('Please provide the embedded code. For best results it is recommended to host the MP4 and OGV formats on an own server.', 'fevr'),
				'id' => 'slide-video-embedded',
				'type' => 'textarea',
				'default' => '',
				'required' => array ('slide-type', '=', 'video'),
			),
			array(
				'name' =>  esc_html__('Layers', 'fevr'),
				'desc' => esc_html__('Several layers can be uploaded which will be moved by moving the mouse or the device.', 'fevr'),
				'id' => 'slide-parallax-layers',
				'type' => 'buttonset',
				'options' => array(
					'enabled' => esc_html__('Enabled', 'fevr'),
					'disabled' => esc_html__('Disabled', 'fevr'),
				),
				'default' => 'disabled',
				'required' => array ('slide-type', '=', 'image'),
			),
			array( 
				'name' => esc_html__('Add Layers', 'fevr'),
				'desc' => esc_html__('For best results it is recommended to upload images with the same resolution.', 'fevr'),
				'id' => 'slide-parallax-layer-list',
				'type' => 'file_img',
				'repeat' => true,
				'sortable' => true,
				'required' => array('slide-parallax-layers', '=', 'enabled'),
			),
			array( 
				'name' => esc_html__('Slide Skin', 'fevr'),
				'desc' => esc_html__('The slide skin influences the color of the items appearing on the slide. E.g.: arrows, dots, logo.', 'fevr'),
				'id' => 'slide-skin',
				'type' => 'select',
				'options' => array(
					'default' => esc_html__('Default', 'fevr'),
					'dark' => esc_html__('Dark', 'fevr'),
					'light' => esc_html__('Light', 'fevr'),
				),
				'default' => 'default',
			),
/*
			array(
				'name' =>  esc_html__('Custom Skin', 'fevr'),
				'desc' => esc_html__('Enable if you would like custom colors for header.', 'fevr'),
				'id' => 'slide-custom-skin',
				'type' => 'buttonset',
				'options' => array(
					'enabled' => esc_html__('Enabled', 'fevr'),
					'disabled' => esc_html__('Disabled', 'fevr'),
				),
				'default' => 'disabled',
				'required' => array ('slide-skin', '!=', 'default'),
			),
			array(
					'name' => esc_html__('Custom Light Color', 'fevr'),
					'desc' => esc_html__('Please select a valid color for the light skin.', 'fevr'),
					'id' => 'skin-custom-light-color',
					'type' => 'color',
					'required' => array ('slide-custom-skin', '=', 'enabled'),
			),
			array(
					'name' => esc_html__('Custom Dark Color', 'fevr'),
					'desc' => esc_html__('Please select a valid color for the dark skin.', 'fevr'),
					'id' => 'skin-custom-dark-color',
					'type' => 'color',
					'required' => array ('slide-custom-skin', '=', 'enabled'),
			),
*/
			array( 
				'name' => esc_html__('Content Alignment', 'fevr'),
				'id' => 'slide-content-alignment',
				'type' => 'select',
				'options' => array(
					'is-left' => esc_html__('Left', 'fevr'),
					'is-center' => esc_html__('Center', 'fevr'),
					'is-right' => esc_html__('Right', 'fevr'),
				),
				'default' => 'center',
			),
			array( 
					'name' => esc_html__('Scroll Arrow', 'fevr'),
					'desc' => esc_html__('Enable if you would like an animated arrow. By clicking on this the browser will immediately scroll to the content.', 'fevr'),
					'id' => 'slide-mouse-icon',
					'type' => 'checkbox',
					'class' => 'switch-style',
					'default' => 'enabled'
			),
			array( 
					'name' => esc_html__('Scroll Arrow Type', 'fevr'),
					'id' => 'slide-mouse-icon-type',
					'type' => 'select',
					'options' => array(
						'mouse' => 'Mouse',
						'arrow2' => 'Arrow',
						'arrow' => 'Arrow (pulse)',
					),
					'default' => 'arrow',
					'required' => array('slide-mouse-icon', '=', 'enabled'),
			),
			array( 
					'name' => esc_html__('Animation', 'fevr'),
					'desc' => esc_html__('What effect should the content be displayed with?', 'fevr'),
					'id' => 'slide-effect',
					'type' => 'select',
					'options' => array(
						'none' => 'None',
						'from-top' => 'From Top',
						'from-left' => 'From Left',
						'from-right' => 'From Right',
						'from-bottom' => 'From Bottom',
						'zoom-out' => 'Zoom Out',
					),
					'default' => 'none'
			),
			array( 
				'name' => esc_html__('Heading', 'fevr'),
				'desc' => esc_html__('Please provide the heading for the slide.', 'fevr'),
				'id' => 'slide-heading',
				'type' => 'text',
			),
			array(
					'name' => esc_html__('Heading Font Family', 'fevr'),
					'id' => 'slide-heading-font-family',
					'type' => 'luv_font',
					'options' => $fevr_vc_font_family_list,
					'required' => array('slide-heading', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Heading Font Size', 'fevr'),
					'desc' => esc_html__('You can specify custom font size for heading, eg: 38px or 2em.', 'fevr'),
					'id' => 'slide-heading-font-size',
					'required' => array('slide-heading', '!=', ''),
					'type' => 'text',
					'default' => '',
			),
			array(
					'name' => esc_html__('Responsive Font Size', 'fevr'),
					'id' => 'slide-heading-responsive-font-size',
					'type' => 'checkbox',
					'desc' => esc_html__('Automatically calculate font Sizing for smaller screens', 'fevr'),
					'class' => 'switch-style',
					'required' => array('slide-heading-font-size', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Heading Line Height', 'fevr'),
					'desc' => esc_html__('You can specify custom line height for heading, eg: eg: 22px or 1.2em.', 'fevr'),
					'id' => 'slide-heading-line-height',
					'required' => array('slide-heading', '!=', ''),
					'type' => 'text',
					'default' => '',
			),
			array(
					'name' => esc_html__('Heading Font Style', 'fevr'),
					'id' => 'slide-heading-font-weight',
					'type' => 'luv_font_weight',
					'options' => array_flip($font_weight_list),
					'required' => array('slide-heading', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Heading Text Transform', 'fevr'),
					'id' => 'slide-heading-text-transform',
					'type' => 'select',
					'options' => array_flip($text_transform_list),
					'required' => array('slide-heading', '!=', ''),
					'default' => '',
			),				
			array( 
				'name' => esc_html__('Caption', 'fevr'),
				'desc' => esc_html__('Please provide a caption for the slide.', 'fevr'),
				'id' => 'slide-caption',
				'type' => 'text',
			),
			array(
					'name' => esc_html__('Caption Font Family', 'fevr'),
					'id' => 'slide-caption-font-family',
					'type' => 'luv_font',
					'options' => $fevr_vc_font_family_list,
					'required' => array('slide-caption', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Caption Font Size', 'fevr'),
					'desc' => esc_html__('You can specify custom font size for caption, eg: 38px or 2em.', 'fevr'),
					'id' => 'slide-caption-font-size',
					'required' => array('slide-caption', '!=', ''),
					'type' => 'text',
					'default' => '',
			),
			array(
					'name' => esc_html__('Responsive Font Size', 'fevr'),
					'id' => 'slide-caption-responsive-font-size',
					'type' => 'checkbox',
					'desc' => esc_html__('Automatically calculate font Sizing for smaller screens', 'fevr'),
					'class' => 'switch-style',
					'required' => array('slide-caption-font-size', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Caption Line Height', 'fevr'),
					'desc' => esc_html__('You can specify custom line height for caption, eg: eg: 22px or 1.2em.', 'fevr'),
					'id' => 'slide-caption-line-height',
					'required' => array('slide-caption', '!=', ''),
					'type' => 'text',
					'default' => '',
			),				
			array(
					'name' => esc_html__('Caption Font Style', 'fevr'),
					'id' => 'slide-caption-font-weight',
					'type' => 'luv_font_weight',
					'options' => array_flip($font_weight_list),
					'required' => array('slide-caption', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Caption Text Transform', 'fevr'),
					'id' => 'slide-caption-text-transform',
					'type' => 'select',
					'options' => array_flip($text_transform_list),
					'required' => array('slide-caption', '!=', ''),
					'default' => '',
			),				
			array( 
				'name' => esc_html__('Full Slide Link', 'fevr'),
				'desc' => esc_html__('Enable it if you would like the entire slide to be clickable. If disabled, the link can be placed in the content box with a button shortcode.', 'fevr'),
				'id' => 'slide-full-link',
				'type' => 'checkbox',
				'class' => 'switch-style',
			),
			array( 
				'name' => esc_html__('Slide URL', 'fevr'),
				'desc' => esc_html__('Please provide the URL.', 'fevr'),
				'id' => 'slide-link',
				'type' => 'text',
				'required' => array('slide-full-link', '=', 'enabled'),
			),
			array( 
					'name' => esc_html__('Slide Content', 'fevr'),
					'desc' => esc_html__('Please provide the content of the slide. This can be simple text or a shortcode.', 'fevr'),
					'id' => 'slide-content',
					'type' => 'editor',
					'disable_tinymce' => true,
			),
			array(
					'name' => esc_html__('Content Font Family', 'fevr'),
					'id' => 'slide-content-font-family',
					'type' => 'luv_font',
					'options' => $fevr_vc_font_family_list,
					'required' => array('slide-content', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Content Font Size', 'fevr'),
					'desc' => esc_html__('You can specify custom font size for heading, eg: 38px or 2em.', 'fevr'),
					'id' => 'slide-content-font-size',
					'required' => array('slide-content', '!=', ''),
					'type' => 'text',
					'default' => '',
			),
			array(
					'name' => esc_html__('Responsive Font Size', 'fevr'),
					'id' => 'slide-content-responsive-font-size',
					'type' => 'checkbox',
					'desc' => esc_html__('Automatically calculate font Sizing for smaller screens', 'fevr'),
					'class' => 'switch-style',
					'required' => array('slide-content-font-size', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Content Font Style', 'fevr'),
					'id' => 'slide-content-font-weight',
					'type' => 'luv_font_weight',
					'options' => array_flip($font_weight_list),
					'required' => array('slide-content', '!=', ''),
					'default' => '',
			),
			array(
					'name' => esc_html__('Content Text Transform', 'fevr'),
					'id' => 'slide-content-text-transform',
					'type' => 'select',
					'options' => array_flip($text_transform_list),
					'required' => array('slide-content', '!=', ''),
					'default' => '',
			),				
			array( 
					'name' => esc_html__('Text Color', 'fevr'),
					'desc' => esc_html__('Please provide the color of the text on the slide.', 'fevr'),
					'id' => 'slide-text-color',
					'type' => 'color',
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
	
	// Global Slide Settings

	$meta_box = array(
		'id' => 'slider-meta-boxes',
		'title' =>  esc_html__('Slider Settings', 'fevr'),
		'description' => esc_html__('Settings related to the slider can be found here.', 'fevr'),
		'post_type' => 'luv_slider',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array( 
					'name' => esc_html__('Slider Height', 'fevr'),
					'id' => 'slider-height',
					'type' => 'buttonset',
					'options' => array(
						'custom' => esc_html__('Custom', 'fevr'),
						'full_height' => esc_html__('Full Height', 'fevr'),
					),
					'default' => 'custom',
			),
			array( 
					'name' => esc_html__('Custom Slider Height', 'fevr'),
					'desc' => esc_html__('The height of the slider in pixels. Please only provide the number, without the "px". E.g.: 450', 'fevr'),
					'id' => 'slider-height-custom',
					'type' => 'text',
					'default' => '450',
					'required' => array('slider-height', '=', 'custom'),
			),
			array( 
					'name' => esc_html__('Transition Type', 'fevr'),
					'desc' => esc_html__('What type of transition should the sliders have?', 'fevr'),
					'id' => 'slider-transition-type',
					'type' => 'select',
					'options' => array(
						'slide' => 'Slide',
						'fadeOut' => 'Fade Out',
						'flipInX' => 'flipInX',
					),
					'default' => 'slide',
			),
			array(
					'name' =>  esc_html__('Parallax', 'fevr'),
					'id' => 'slider-parallax',
					'type' => 'buttonset',
					'options' => array(
						'parallax-enabled' => esc_html__('Enabled', 'fevr'),
						'parallax-disabled' => esc_html__('Disabled', 'fevr'),
					),
					'default' => 'parallax-enabled',
			),
			array( 
					'name' => esc_html__('Infinite Slider', 'fevr'),
					'desc' => esc_html__('When your slideshow reaches the last slide, it will automatically loop back to the beginning', 'fevr'),
					'id' => 'slider-infinite',
					'type' => 'checkbox',
					'class' => 'switch-style',
					'default' => 'enabled',
			),
			array( 
					'name' => esc_html__('Navigation', 'fevr'),
					'id' => 'slider-nav',
					'type' => 'checkbox',
					'class' => 'switch-style',
					'default' => 'enabled',
			),
			array( 
					'name' => esc_html__('Dots', 'fevr'),
					'id' => 'slider-dots',
					'type' => 'checkbox',
					'class' => 'switch-style',
			),
			array( 
					'name' => esc_html__('Autoplay', 'fevr'),
					'id' => 'slider-autoplay',
					'type' => 'checkbox',
					'class' => 'switch-style',
					'default' => 'enabled',
			),
			array( 
					'name' => esc_html__('Autoplay Timeout', 'fevr'),
					'desc' => esc_html__('Please provide the transition time between slides. Provide only numbers without "ms".', 'fevr'),
					'id' => 'slider-autoplay-timeout',
					'type' => 'text',
					'default' => '3000',
					'required' => array('slider-autoplay', '=', 'enabled')
			),
			array( 
					'name' => esc_html__('Autoplay Pause on Hover', 'fevr'),
					'id' => 'slider-autoplay-pause',
					'type' => 'checkbox',
					'class' => 'switch-style',
					'required' => array('slider-autoplay', '=', 'enabled')
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
};

if(!function_exists('luv_create_slider_meta_box_callback')):
/**
 * Add Slide meta box to Post editor for Slider post type
 */
function luv_create_slider_meta_box_callback($post) {
	global $luv_hidden_slider_meta_box;
	
	wp_nonce_field( 'luv_meta_box', 'luv_meta_box_nonce' );
	
	$meta_value = get_post_meta( $post->ID, 'fevr_meta', true );
	
	echo '<ul class="luv-slides-container luv-clearfix">';
	
		$args = array(
			'post_type' => 'luv_slider',
			'p' => $post->ID,
		);
		
		$slides_query = new WP_Query( $args );
		
		if ( $slides_query->have_posts() ) : while ( $slides_query->have_posts() ) : $slides_query->the_post();
		
			$meta_value = get_post_meta( $post->ID, 'fevr_meta', true );
			
			if(isset($meta_value['slider'])):
				$i = 0;
				foreach((array)$meta_value['slider'] as $slide):
					$i++;
					$slide_image_styles = '';
					// If the slide is a video we use a play icon
					if((isset($slide['slide-video-mp4']) && !empty($slide['slide-video-mp4'])) || (isset($slide['slide-video-ogv']) && !empty($slide['slide-video-ogv'])) || (isset($slide['slide-video-embedded']) && !empty($slide['slide-video-embedded']))) {
						$slide_image_styles = 'background: url('.trailingslashit(get_template_directory_uri()).'luvthemes/assets/images/slider_play_icon.png) #4D5156; background-repeat: no-repeat; background-size: 50px 50px; background-position: center;';
					} else if(isset($slide['slide-image'])) {
						$slide_image_styles = 'background-image: url('.$slide['slide-image'].')';
					}
			?>
			<li data-slide="<?php echo $i; ?>" style="<?php echo $slide_image_styles; ?>">
				<?php foreach($luv_hidden_slider_meta_box['fields'] as $field): ?>
					<?php
						//Convert array to JSON 
						if (isset($slide[$field['id']]) && is_array($slide[$field['id']])){
							$slide[$field['id']] = json_encode($slide[$field['id']]);
						}
					?>
					<?php if(isset($slide[$field['type']]) && $slide[$field['type']] == 'editor'): ?>
						<textarea class="luv-<?php echo $field['id']; ?>" type="hidden" name="fevr_meta[slider][][<?php echo $field['id']; ?>]"><?php echo isset($slide[$field['id']]) ? htmlentities($slide[$field['id']]) : ''; ?></textarea>
					<?php else: ?>
						<input class="luv-<?php echo $field['id']; ?>" type="hidden" name="fevr_meta[slider][][<?php echo $field['id']; ?>]" value="<?php echo isset($slide[$field['id']]) ? htmlentities($slide[$field['id']]) : ''; ?>">
					<?php endif; ?>
				<?php endforeach; ?>
			</li>
			
			<?php
				endforeach;
			endif;
		endwhile;
		endif;
		echo '<li class="is-hidden">';
				foreach($luv_hidden_slider_meta_box['fields'] as $field) {
					echo '<input class="luv-'.$field['id'].'" type="hidden" name="fevr_meta[slider][]['.$field['id'].']">';
				}	
		echo '</li>';
	echo '</ul>';
	echo '<div class="luv-slider-buttons">';
		echo '<a class="add-new-slide luv-btn-green luv-btn" href="#">'.esc_html__('Add New', 'fevr').'</a> <a class="remove-slide luv-btn-red luv-btn" href="#">'.esc_html__('Remove', 'fevr').'</a>';
	echo '</div>';
}	
endif;

?>