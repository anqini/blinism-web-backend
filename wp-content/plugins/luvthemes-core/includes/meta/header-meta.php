<?php

add_action( 'add_meta_boxes', 'luv_header_meta_box');

/**
 * Add "Header page settings" meta box to Post editor
 */
function luv_header_meta_box() {
	global $fevr_vc_font_family_list;

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

	// Add empty field
	$header_sliders[0] = NULL;

	// Header Slider Data
	foreach(get_posts( 'sort_column=title&sort_order=asc&post_type=luv_slider&posts_per_page=-1&post_status=publish' ) as $header_slider) {
		$header_sliders[$header_slider->post_name] = (isset($header_slider->post_title) && !empty($header_slider->post_title) ? $header_slider->post_title : esc_html__('(no title)', 'fevr'));
	}
	wp_reset_postdata();

	// Add empty field
	$header_snippets[0] = NULL;

	// Header Slider Data
	foreach(get_posts( 'sort_column=title&sort_order=asc&post_type=luv_snippets&posts_per_page=-1&post_status=publish' ) as $header_snippet) {
		$header_snippets[$header_snippet->ID] = (isset($header_snippet->post_title) && !empty($header_snippet->post_title) ? $header_snippet->post_title : esc_html__('(no title)', 'fevr'));
	}
	wp_reset_postdata();


	// Sidebars

	global $wp_registered_sidebars;

	// Add empty field
	$sidebars[0] = NULL;

	foreach($wp_registered_sidebars as $sidebar) {
		$sidebars[$sidebar['id']] = $sidebar['name'];
	}

	//======================================================================
	// Tabs
	//======================================================================

	$tabs = array(
		array(
			'title' => esc_html__('Header', 'fevr'),
			'icon' => '',
			'class' => 'divider',
			'id' => 'header-divider',
		),
		array(
			'title' => esc_html__('Appearance', 'fevr'),
			'icon' => 'columns',
			'id' => 'header-appearance',
		),
		array(
			'title' => esc_html__('Background', 'fevr'),
			'icon' => 'image',
			'id' => 'header-background',
		),
		array(
			'title' => esc_html__('Colors', 'fevr'),
			'icon' => 'paint-brush',
			'id' => 'header-colors',
		),
		array(
			'title' => esc_html__('Sizing', 'fevr'),
			'icon' => 'arrows-v',
			'id' => 'header-sizing',
		),
		array(
			'title' => esc_html__('Title', 'fevr'),
			'icon' => 'font',
			'id' => 'header-title',
		),
		array(
			'title' => esc_html__('Content', 'fevr'),
			'icon' => 'align-left',
			'id' => 'header-content',
		),
		array(
			'title' => esc_html__('Promo Effect', 'fevr'),
			'icon' => 'magic',
			'id' => 'header-promo',
		),
		array(
			'title' => esc_html__('Page', 'fevr'),
			'icon' => '',
			'class' => 'divider',
			'id' => 'page-divider',
		),
		array(
			'title' => esc_html__('General', 'fevr'),
			'icon' => 'gear',
			'id' => 'page-general',
		),
		array(
			'title' => esc_html__('Sidebar', 'fevr'),
			'icon' => 'columns',
			'id' => 'page-sidebar',
		),
	);

	// Add background image section if boxed page layout was set
	if (_check_luvoption('page-layout', 'boxed')){
			$tabs[] = array(
				'title' => esc_html__('Background', 'fevr'),
				'icon' => 'image',
				'id' => 'page-background',
			);
	}


	//======================================================================
	// Conditional Fields
	//======================================================================

	$masonry = $portfolio = false;

	if(get_post_type() == 'post') {
		$hide_featured = array(
			'name' => esc_html__('Hide Main Element on Single Post', 'fevr'),
			'desc' => esc_html__('Eg. featured image, audio player, video, gallery', 'fevr'),
			'id' => 'blog-hide-featured-image',
			'type' => 'checkbox',
			'class' => 'switch-style',
			'tab' => 'page-general',
		);

		$masonry = true;

		// blog fields
		$conditional_fields = array(
			array(
				'name' => esc_html__('Item Size', 'fevr'),
				'desc' => esc_html__('What size should the item have?', 'fevr'),
				'id' => 'post-masonry-size',
				'type' => 'select',
				'options' => array(
					'fevr_normal' => esc_html__('Normal', 'fevr'),
					'fevr_wide' => esc_html__('Wide', 'fevr'),
					'fevr_tall' => esc_html__('Tall', 'fevr'),
					'fevr_wide_tall' => esc_html__('Wide & Tall', 'fevr'),
					'fevr_full_size' => esc_html__('Full', 'fevr'),
				),
				'default' => 'fevr_normal',
				'tab' => 'masonry-sizing-style',
			),
			array(
				'name' => esc_html__('Item Display Style', 'fevr'),
				'desc' => esc_html__('Which style should the item have for masonry standard view?', 'fevr'),
				'id' => 'post-masonry-style',
				'type' => 'select',
				'options' => array(
					'default' => esc_html__('Default', 'fevr'),
					'background-image' => esc_html__('Default + Background Image', 'fevr'),
					'featured' => esc_html__('Featured', 'fevr'),
				),
				'default' => 'normal',
				'tab' => 'masonry-sizing-style',
			),
			array(
				'name' => esc_html__('Show Content in Box', 'fevr'),
				'desc' => esc_html__('Enable it if you would like to display a certain content in the box. E.g.; Next link to a external website, social media links, etc.', 'fevr'),
				'id' => 'post-masonry-show-content',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'masonry-content',
			),
			array(
				'name' => esc_html__('Box Content', 'fevr'),
				'desc' => esc_html__('In this field you can place links, shortcodes or simple texts.', 'fevr'),
				'id' => 'post-masonry-content',
				'type' => 'editor',
				'required' => array('post-masonry-show-content', '=', 'enabled'),
				'tab' => 'masonry-content',
			),
			array(
				'name' => esc_html__('Horizontal Text Alignment', 'fevr'),
				'id' => 'post-masonry-h-text-alignment',
				'type' => 'buttonset',
				'options' => array(
					'is-left' => esc_html__('Left', 'fevr'),
					'is-center' => esc_html__('Center', 'fevr'),
					'is-right' => esc_html__('Right', 'fevr'),
				),
				'default' => 'is-center',
				'tab' => 'masonry-alignment',
			),
			array(
				'name' => esc_html__('Vertical Text Alignment', 'fevr'),
				'id' => 'post-masonry-v-text-alignment',
				'type' => 'buttonset',
				'options' => array(
					'vertical-top' => esc_html__('Top', 'fevr'),
					'vertical-center' => esc_html__('Middle', 'fevr'),
					'vertical-bottom' => esc_html__('Bottom', 'fevr'),
				),
				'default' => 'vertical-center',
				'tab' => 'masonry-alignment',
			),
			array(
				'name' => esc_html__('Excerpt', 'fevr'),
				'desc' => esc_html__('Short description for the post. The content provided here will appear on the archive page, if this was set in the "Theme Options".', 'fevr'),
				'id' => 'blog-excerpt',
				'type' => 'text',
				'tab' => 'masonry-content',
			),
			array(
				'name' => esc_html__('Accent Color', 'fevr'),
				'desc' => esc_html__('Main color that influences some parts of the item.', 'fevr'),
				'id' => 'post-masonry-accent-color',
				'type' => 'color',
				'tab' => 'masonry-colors',
			),
			array(
				'name' => esc_html__('Text Color', 'fevr'),
				'desc' => esc_html__('Select the most appropriate text color for the item.', 'fevr'),
				'id' => 'post-masonry-text-color',
				'type' => 'color',
				'tab' => 'masonry-colors',
			),
		);

	} elseif(get_post_type() == 'luv_portfolio') {
		$hide_featured = array(
			'name' => esc_html__('Hide Featured Image/Video on Single Page', 'fevr'),
			'desc' => esc_html__('Enable if you would like to hide the image/video on the project page.', 'fevr'),
			'id' => 'portfolio-hide-featured-image',
			'type' => 'checkbox',
			'class' => 'switch-style',
			'default' => 'disabled',
			'tab' => 'page-general',
		);

		$masonry = $portfolio = true;

		// portfolio fields
		$conditional_fields = array(
			array(
				'name' => esc_html__('Item Size', 'fevr'),
				'desc' => esc_html__('What size should the item have?', 'fevr'),
				'id' => 'portfolio-masonry-size',
				'type' => 'select',
				'options' => array(
					'fevr_normal' => esc_html__('Normal', 'fevr'),
					'fevr_wide' => esc_html__('Wide', 'fevr'),
					'fevr_tall' => esc_html__('Tall', 'fevr'),
					'fevr_wide_tall' => 'Wide & Tall',
					'fevr_full_size' => esc_html__('Full', 'fevr'),
				),
				'default' => 'fevr_normal',
				'tab' => 'masonry-sizing-style',
			),
			array(
				'name' => esc_html__('Show Content in Box', 'fevr'),
				'desc' => esc_html__('Enable if you would like to display certain content in the box. E.g. Next link to a external website, social media links, etc.', 'fevr'),
				'id' => 'portfolio-masonry-show-content',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'masonry-content',
			),
			array(
				'name' => esc_html__('Box Content', 'fevr'),
				'desc' => esc_html__('In this field you can enter a link, shortcode or simple text.', 'fevr'),
				'id' => 'portfolio-masonry-content',
				'type' => 'editor',
				'required' => array('portfolio-masonry-show-content', '=', 'enabled'),
				'tab' => 'masonry-content',
			),
			array(
				'name' => esc_html__('Custom Project Link', 'fevr'),
				'desc' => esc_html__('If you want to use an external link on the archive page, by clicking on the item the user will arrive to the provided link. This can be useful if you want to send the user to your external portfolio (Behance, Dribble, etc) link.', 'fevr'),
				'id' => 'portfolio-custom-link',
				'type' => 'luv_url',
				'default' => '',
				'tab' => 'project-general',
			),
			array(
					'name' => esc_html__('Open Project Link in', 'fevr'),
					'id' => 'portfolio-link-target',
					'type' => 'select',
					'default' => '_self',
					'options' => array(
							'_blank' => esc_html__('New window', 'fevr'),
							'_self' => esc_html__('Same Window', 'fevr'),
							'_top' => esc_html__('Top Window', 'fevr'),
							'_parent' => esc_html__('Parent Window', 'fevr'),
					),
					'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Horizontal Text Alignment', 'fevr'),
				'id' => 'portfolio-masonry-h-text-alignment',
				'type' => 'buttonset',
				'options' => array(
					'is-left' => esc_html__('Left', 'fevr'),
					'is-center' => esc_html__('Center', 'fevr'),
					'is-right' => esc_html__('Right', 'fevr'),
				),
				'default' => 'is-center',
				'tab' => 'masonry-alignment',
			),
			array(
				'name' => esc_html__('Vertical Text Alignment', 'fevr'),
				'id' => 'portfolio-masonry-v-text-alignment',
				'type' => 'buttonset',
				'options' => array(
					'vertical-top' => esc_html__('Top', 'fevr'),
					'vertical-center' => esc_html__('Middle', 'fevr'),
					'vertical-bottom' => esc_html__('Bottom', 'fevr'),
				),
				'default' => 'vertical-center',
				'tab' => 'masonry-alignment',
			),
			array(
				'name' => esc_html__('Accent Color', 'fevr'),
				'desc' => esc_html__('Main color that influences some parts of the item.', 'fevr'),
				'id' => 'portfolio-masonry-accent-color',
				'type' => 'color',
				'tab' => 'masonry-colors',
			),
			array(
				'name' => esc_html__('Text Color', 'fevr'),
				'desc' => esc_html__('Select the most appropriate text color for the item.', 'fevr'),
				'id' => 'portfolio-masonry-text-color',
				'type' => 'color',
				'tab' => 'masonry-colors',
			),
			array(
				'name' => esc_html__('Sidebar', 'fevr'),
				'id' => 'portfolio-sidebar',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Sidebar Position', 'fevr'),
				'desc' => esc_html__('Where should the sidebar appear?', 'fevr'),
				'id' => 'portfolio-sidebar-position',
				'type' => 'select',
				'options' => array(
					'portfolio-sidebar-left' => esc_html__('Left', 'fevr'),
					'portfolio-sidebar-right' => esc_html__('Right', 'fevr'),
					'portfolio-sidebar-bottom' => esc_html__('Bottom', 'fevr'),
				),
				'default' => 'portfolio-sidebar-right',
				'required' => array('portfolio-sidebar', '=', 'enabled'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Project Details', 'fevr'),
				'desc' => esc_html__('Short description about the project. This content will appear in the sidebar, in the chosen position.', 'fevr'),
				'id' => 'portfolio-details',
				'type' => 'editor',
				'default' => '',
				'required' => array('portfolio-sidebar', '=', 'enabled'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Color Palette', 'fevr'),
				'desc' => esc_html__('If you enable this option, a small "widget" will appear, which contains the main colors of the featured image.', 'fevr'),
				'id' => 'portfolio-color-palette',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'required' => array('portfolio-sidebar', '=', 'enabled'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Project Excerpt', 'fevr'),
				'desc' => esc_html__('Short description about the project. The content will appear on the archive page, if set in "Theme Options".', 'fevr'),
				'id' => 'portfolio-excerpt',
				'type' => 'text',
				'default' => '',
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Use Video Instead of Featured Image', 'fevr'),
				'desc' => esc_html__('Enable if you would like to use a video instead of the featured image.', 'fevr'),
				'id' => 'portfolio-video',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Video Source', 'fevr'),
				'desc' => esc_html__('What kind of video would you like?', 'fevr'),
				'id' => 'portfolio-video-source',
				'type' => 'buttonset',
				'options' => array(
					'file' => esc_html__('File', 'fevr'),
					'embedded' => esc_html__('Embedded', 'fevr'),
				),
				'default' => 'file',
				'required' => array('portfolio-video', '=', 'enabled'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('MP4 File URL', 'fevr'),
				'desc' => esc_html__('Please upload the MP4 file. The upload of OGV format is also recommended.', 'fevr'),
				'id' => 'portfolio-video-mp4',
				'type' => 'file',
				'default' => '',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('OGV File URL', 'fevr'),
				'desc' => esc_html__('Please upload the OGV file. The upload of MP4 format is also recommended.', 'fevr'),
				'id' => 'portfolio-video-ogv',
				'type' => 'file',
				'default' => '',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Autoplay', 'fevr'),
				'id' => 'portfolio-video-autoplay',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Loop', 'fevr'),
				'id' => 'portfolio-video-loop',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Mute', 'fevr'),
				'id' => 'portfolio-video-mute',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Controls', 'fevr'),
				'id' => 'portfolio-video-controls',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Preview Image', 'fevr'),
				'desc' => esc_html__('The image set here will be displayed on mobile devices, when autoplay is not allowed. ', 'fevr'),
				'id' => 'portfolio-video-preview',
				'type' => 'file_img',
				'required' => array('portfolio-video-source', '=', 'file'),
				'tab' => 'project-general',
			),
			array(
				'name' => esc_html__('Embedded Video', 'fevr'),
				'desc' => esc_html__('Please provide the embedded code. For best results it is recommended to host the MP4 and OGV formats on an own server.', 'fevr'),
				'id' => 'portfolio-video-embedded',
				'type' => 'textarea',
				'default' => '',
				'required' => array('portfolio-video-source', '=', 'embedded'),
				'tab' => 'project-general',
			),
		);
	} else {
		$hide_featured = $conditional_fields = array();
	}


	//======================================================================
	// Header & Page Settings
	//======================================================================
	$fields = array(
		array(
				'name' => esc_html__('Hide Title', 'fevr'),
				'desc' => esc_html__('Enable if you\'d like to completely hide the header.', 'fevr'),
				'id' => 'page-header-hide-title',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-appearance',
				'default' => 'disabled'
		),
		array(
				'name' => esc_html__('Slider', 'fevr'),
				'desc' => esc_html__('If you want a slider on the page, select it here.', 'fevr'),
				'id' => 'page-header-slider',
				'type' => 'select',
				'tab' => 'header-appearance',
				'options' => $header_sliders,
		),
		array(
				'name' => esc_html__('Hide Slider on Small Devices', 'fevr'),
				'id' => 'page-header-slider-hide-s',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-appearance',
				'default' => 'disabled',
				'required' => array ('page-header-slider', '!=', '0'),
		),
		array(
				'name' => esc_html__('Snippet', 'fevr'),
				'desc' => esc_html__('If you want to show a snippet in the header, select it here.', 'fevr'),
				'id' => 'page-header-snippet',
				'type' => 'select',
				'tab' => 'header-appearance',
				'options' => $header_snippets,
		),
		array(
				'name' => esc_html__('Skin', 'fevr'),
				'desc' => esc_html__('If a transparent header is set, the header skin will influence the color of the logo and the menu.', 'fevr'),
				'id' => 'page-header-skin',
				'type' => 'select',
				'options' => array(
					'default' => esc_html__('Default', 'fevr'),
					'dark' => esc_html__('Dark', 'fevr'),
					'light' => esc_html__('Light', 'fevr'),
				),
				'tab' => 'header-appearance',
				'default' => 'default',
		),
		array(
				'name' => esc_html__('Transparent Header', 'fevr'),
				'desc' => esc_html__('Setting the transparency of the header. The global settings can be overwritten, therefore you can decide on every page whether the header should be transparent or not.', 'fevr'),
				'id' => 'page-header-transparency',
				'type' => 'select',
				'options' => array(
					'0' => esc_html__('Default', 'fevr'),
					'1' => esc_html__('Transparent', 'fevr'),
					'2' => esc_html__('Non-Transparent', 'fevr'),
				),
				'tab' => 'header-appearance',
				'default' => 'default',
		),
		array(
				'name' => esc_html__('Navigation Borders', 'fevr'),
				'desc' => esc_html__('Setting the border visibility of the navigation. The global settings can be overwritten, therefore, on every page you can decide whether the navigation should be with border or not.', 'fevr'),
				'id' => 'page-header-nav-borders',
				'type' => 'select',
				'options' => array(
					'0' => esc_html__('Default', 'fevr'),
					'1' => esc_html__('Border', 'fevr'),
					'2' => esc_html__('No Border', 'fevr'),
				),
				'tab' => 'header-appearance',
				'default' => 'default',
		),
		array(
				'name' => esc_html__('Background Type', 'fevr'),
				'id' => 'header-background-type',
				'type' => 'buttonset',
				'options' => array(
					'image' => esc_html__('Image', 'fevr'),
					'gradient' => esc_html__('Gradient', 'fevr'),
					'video' => esc_html__('Video', 'fevr'),
				),
				'tab' => 'header-background',
				'default' => 'image'
		),
		array(
				'name' => esc_html__('Image', 'fevr'),
				'desc' => esc_html__('For best results it is recommended to upload an image with the width of 1800px and the height of 400px. A larger size image can influence the load time of the page.', 'fevr'),
				'id' => 'page-header-bg',
				'type' => 'file_img',
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'image'),
		),
		array(
				'name' => esc_html__('Gradient Color 1', 'fevr'),
				'id' => 'page-header-gradient-color-1',
				'type' => 'color',
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'gradient'),
		),
		array(
				'name' => esc_html__('Gradient Color 2', 'fevr'),
				'id' => 'page-header-gradient-color-2',
				'type' => 'color',
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'gradient'),
		),
		array(
				'name' => esc_html__('Gradient Direction', 'fevr'),
				'id' => 'page-header-gradient-direction',
				'type' => 'select',
				'options' => array(
					'left-to-right' => esc_html__('Left to Right', 'fevr'),
					'top-to-bottom' => esc_html__('Top to Bottom', 'fevr'),
					'left-top-to-right-bottom' => esc_html__('Left Top to Right Bottom', 'fevr'),
					'left-bottom-to-right-top' => esc_html__('Left Bottom to Right Top', 'fevr'),
					'ellipse' => esc_html__('Ellipse', 'fevr'),
				),
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'gradient'),
		),
		array(
				'name' => esc_html__('Image Filter', 'fevr'),
				'desc' => esc_html__('By setting the filter the image will not be modified, it will appear with the selected filter.', 'fevr'),
				'id' => 'page-header-filter',
				'type' => 'select',
				'options' => array(
					'' => esc_html('None', 'fevr'),
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
				'default' => '',
				'tab' => 'header-background',
				'required' => array('page-header-bg', '!=', ''),
		),
		array(
				'name' => esc_html__('MP4 File URL', 'fevr'),
				'desc' => esc_html__('Please upload the MP4 file. The upload of OGV format is also recommended.', 'fevr'),
				'id' => 'header-video-mp4',
				'type' => 'file',
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'video'),
		),
		array(
				'name' => esc_html__('OGV File URL', 'fevr'),
				'desc' => esc_html__('Please upload the OGV file. The upload of MP4 format is also recommended.', 'fevr'),
				'id' => 'header-video-ogv',
				'type' => 'file',
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'video'),
		),
		array(
				'name' => esc_html__('Embedded Video', 'fevr'),
				'desc' => esc_html__('Please provide the embedded code. For best results it is recommended to host the MP4 and OGV formats on your own server.', 'fevr'),
				'id' => 'header-video-embedded',
				'type' => 'textarea',
				'default' => '',
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'video'),
		),
		array(
			'name' => esc_html__('Preview Image', 'fevr'),
			'desc' => esc_html__('The image set here will be displayed on mobile devices, because autoplay is not allowed on these. ', 'fevr'),
			'id' => 'header-video-preview',
			'type' => 'file_img',
			'default' => '',
			'tab' => 'header-background',
			'required' => array ('header-background-type', '=', 'video'),
		),
		array(
				'name' => esc_html__('Pause Video on Click', 'fevr'),
				'id' => 'page-header-pause-video',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-background',
				'default' => 'disabled',
				'required' => array ('header-background-type', '=', 'video'),
		),
		array(
				'name' => esc_html__('Mute Video', 'fevr'),
				'id' => 'page-header-mute-video',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-background',
				'default' => 'enabled',
				'required' => array ('header-background-type', '=', 'video'),
		),
		array(
				'name' =>  esc_html__('Mute/Unmute Icon Position', 'fevr'),
				'id' => 'page-header-mute-position',
				'type' => 'select',
				'options' => array(
					'' => esc_html__('None', 'fevr'),
					'left' => esc_html__('Left', 'fevr'),
					'right' => esc_html__('Right', 'fevr'),
				),
				'tab' => 'header-background',
				'required' => array ('header-background-type', '=', 'video'),
		),
		array(
				'name' =>  esc_html__('Parallax Header Style', 'fevr'),
				'id' => 'page-header-parallax',
				'type' => 'select',
				'options' => array(
					'' => esc_html__('None', 'fevr'),
					'standard-parallax' => esc_html__('Standard', 'fevr'),
					'zoom-out-parallax' => esc_html__('Zoom Out', 'fevr'),
				),
				'tab' => 'header-background',
		),
		array(
				'name' =>  esc_html__('Layers', 'fevr'),
				'desc' => esc_html__('Several layers can be uploaded which will be moved by moving the mouse or the device.', 'fevr'),
				'id' => 'page-header-parallax-layers',
				'type' => 'buttonset',
				'options' => array(
					'enabled' => esc_html__('Enabled', 'fevr'),
					'disabled' => esc_html__('Disabled', 'fevr'),
				),
				'tab' => 'header-background',
				'default' => 'disabled',
		),
		array(
				'name' => esc_html__('Add Layers', 'fevr'),
				'desc' => esc_html__('For best results it is recommended to upload images with the same resolution.', 'fevr'),
				'id' => 'page-header-parallax-layer-list',
				'type' => 'file_img',
				'repeat' => true,
				'sortable' => true,
				'tab' => 'header-background',
				'required' => array('page-header-parallax-layers', '=', 'enabled'),
		),
		array(
				'name' => esc_html__('Overlay', 'fevr'),
				'desc' => esc_html__('Enable if for a transparent layer above the image/video.', 'fevr'),
				'id' => 'page-header-overlay',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-appearance',
				'default' => 'disabled'
		),
		array(
				'name' => esc_html__('Overlay Color', 'fevr'),
				'desc' => esc_html__('Set a custom color for transparent layer.', 'fevr'),
				'id' => 'page-header-overlay-color',
				'type' => 'color',
				'default' => '',
				'tab' => 'header-appearance',
				'required' => array('page-header-overlay', '=', 'enabled'),
		),
		array(
				'name' => esc_html__('Overlay Transparency', 'fevr'),
				'desc' => esc_html__('Opacity for overlay color. eg. 0.8', 'fevr'),
				'id' => 'page-header-overlay-color-opacity',
				'type' => 'text',
				'default' => '0.8',
				'tab' => 'header-appearance',
				'required' => array('page-header-overlay', '=', 'enabled'),
		),
		array(
				'name' => esc_html__('Scroll Arrow', 'fevr'),
				'desc' => esc_html__('Enable if you would like an animated arrow. By clicking on this the browser will immediately scroll to the content.', 'fevr'),
				'id' => 'header-mouse-icon',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-appearance',
				'default' => 'disabled'
		),
		array(
				'name' => esc_html__('Scroll Arrow Type', 'fevr'),
				'id' => 'header-mouse-icon-type',
				'type' => 'select',
				'options' => array(
					'mouse' => 'Mouse',
					'arrow2' => 'Arrow',
					'arrow' => 'Arrow (pulse)',
				),
				'default' => 'arrow',
				'tab' => 'header-appearance',
				'required' => array('header-mouse-icon', '=', 'enabled'),
		),
		array(
				'name' => esc_html__('Use Original Aspect Ratio', 'fevr'),
				'desc' => esc_html__('Enable if you would like to use your image\'s original aspect ratio.', 'fevr'),
				'id' => 'page-header-original-aspect-ratio',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-sizing',
				'default' => 'disabled'
		),
		array(
				'name' => esc_html__('Height', 'fevr'),
				'id' => 'page-header-height',
				'type' => 'buttonset',
				'options' => array(
					'custom' => esc_html__('Custom', 'fevr'),
					'full_height' => esc_html__('Full Height', 'fevr'),
				),
				'tab' => 'header-sizing',
				'default' => 'custom',
 				'required' => array('page-header-original-aspect-ratio', '!=', 'enabled'),
		),
		array(
				'name' => esc_html__('Custom Header Height', 'fevr'),
				'desc' => esc_html__('The height of the header in pixels. Please only provide the number, without the "px". E.g.: 450. This setting operate will only if a background color exists or a background image is set.', 'fevr'),
				'id' => 'page-header-height-custom',
				'type' => 'text',
				'default' => '',
				'tab' => 'header-sizing',
				'required' => array('page-header-height', '=', 'custom'),
		),
		array(
				'name' => esc_html__('Custom Responsive Header Height', 'fevr'),
				'desc' => esc_html__('Set custom header height for smaller devices.', 'fevr'),
				'id' => 'page-responsive-header-height-custom',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'tab' => 'header-sizing',
				'required' => array('page-header-height', '=', 'custom'),
		),
		array(
				'name' => esc_html__('Responsive Header Heights', 'fevr'),
				'desc' => esc_html__('The height of the header in pixels. Please only provide the number, without the "px". E.g.: 450. This setting operate will only if a background color exists or a background image is set.', 'fevr'),
				'id' => 'page-responsive-header-heights',
				'type' => 'number',
				'extra' => array('responsive' => true),
				'tab' => 'header-sizing',
				'required' => array('page-responsive-header-height-custom', '=', 'enabled'),
		),
		array(
				'name' => esc_html__('Title', 'fevr'),
				'desc' => esc_html__('Please write the header title here.', 'fevr'),
				'id' => 'page-header-title',
				'type' => 'text',
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Title Font Family', 'fevr'),
				'id' => 'page-header-title-font-family',
				'type' => 'luv_font',
				'options' => $fevr_vc_font_family_list,
				'required' => array('page-header-title', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Title Font Size', 'fevr'),
				'desc' => esc_html__('You can specify custom font size for header title, eg: 38px or 2em.', 'fevr'),
				'id' => 'page-header-title-font-size',
				'required' => array('page-header-title', '!=', ''),
				'type' => 'text',
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Responsive Font Size', 'fevr'),
				'id' => 'page-header-title-responsive-font-size',
				'type' => 'checkbox',
				'desc' => esc_html__('Automatically calculate font Sizing for smaller screens', 'fevr'),
				'class' => 'switch-style',
				'required' => array('page-header-title-font-size', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Title Line Height', 'fevr'),
				'desc' => esc_html__('You can specify custom line height for header title, eg: eg: 22px or 1.2em.', 'fevr'),
				'id' => 'page-header-title-line-height',
				'required' => array('page-header-title', '!=', ''),
				'type' => 'text',
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Title Font Style', 'fevr'),
				'id' => 'page-header-title-font-weight',
				'type' => 'luv_font_weight',
				'options' => array_flip($font_weight_list),
				'required' => array('page-header-title', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Title Text Transform', 'fevr'),
				'id' => 'page-header-title-text-transform',
				'type' => 'select',
				'options' => array_flip($text_transform_list),
				'required' => array('page-header-title', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Subtitle', 'fevr'),
				'desc' => esc_html__('Enter the subtitle for header.', 'fevr'),
				'id' => 'page-header-subtitle',
				'type' => 'text',
				'tab' => 'header-title',
				'default' => ''
		),
		array(
				'name' => esc_html__('Subtitle Font Family', 'fevr'),
				'id' => 'page-header-subtitle-font-family',
				'type' => 'luv_font',
				'options' => $fevr_vc_font_family_list,
				'required' => array('page-header-subtitle', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Subitle Font Size', 'fevr'),
				'desc' => esc_html__('You can specify custom font size for header subtitle, eg: 22px or 1.2em.', 'fevr'),
				'id' => 'page-header-subtitle-font-size',
				'required' => array('page-header-subtitle', '!=', ''),
				'type' => 'text',
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Subitle Line Height', 'fevr'),
				'desc' => esc_html__('You can specify custom line height for header subtitle, eg: 22px or 1.2em.', 'fevr'),
				'id' => 'page-header-subtitle-line-height',
				'required' => array('page-header-subtitle', '!=', ''),
				'type' => 'text',
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Responsive Font Size', 'fevr'),
				'id' => 'page-header-subtitle-responsive-font-size',
				'type' => 'checkbox',
				'desc' => esc_html__('Automatically calculate font Sizing for smaller screens', 'fevr'),
				'class' => 'switch-style',
				'required' => array('page-header-subtitle-font-size', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Subtitle Font Style', 'fevr'),
				'id' => 'page-header-subtitle-font-weight',
				'type' => 'luv_font_weight',
				'options' => array_flip($font_weight_list),
				'required' => array('page-header-subtitle', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Subtitle Text Transform', 'fevr'),
				'id' => 'page-header-subtitle-text-transform',
				'type' => 'select',
				'options' => array_flip($text_transform_list),
				'required' => array('page-header-subtitle', '!=', ''),
				'tab' => 'header-title',
				'default' => '',
		),
		array(
				'name' => esc_html__('Content', 'fevr'),
				'desc' => esc_html__('The header can contain shortcodes, e.g. [luv_button].', 'fevr'),
				'id' => 'page-header-content',
				'type' => 'textarea',
				'tab' => 'header-content',
				'shortcode' => true
		),
		array(
				'name' => esc_html__('Content Font Family', 'fevr'),
				'id' => 'page-header-content-font-family',
				'type' => 'luv_font',
				'options' => $fevr_vc_font_family_list,
				'required' => array('page-header-content', '!=', ''),
				'tab' => 'header-content',
				'default' => '',
		),
		array(
				'name' => esc_html__('Content Font Size', 'fevr'),
				'desc' => esc_html__('You can specify custom font size for header content, eg: 18px or 1.1em.', 'fevr'),
				'id' => 'page-header-content-font-size',
				'required' => array('page-header-content', '!=', ''),
				'type' => 'text',
				'tab' => 'header-content',
				'default' => '',
		),
		array(
				'name' => esc_html__('Content Line Height', 'fevr'),
				'desc' => esc_html__('You can specify custom line height for header content, eg: 18px or 1.1em.', 'fevr'),
				'id' => 'page-header-content-line-height',
				'required' => array('page-header-content', '!=', ''),
				'type' => 'text',
				'tab' => 'header-content',
				'default' => '',
		),
		array(
				'name' => esc_html__('Responsive Font Size', 'fevr'),
				'id' => 'page-header-content-responsive-font-size',
				'type' => 'checkbox',
				'desc' => esc_html__('Automatically calculate font Sizing for smaller screens', 'fevr'),
				'class' => 'switch-style',
				'required' => array('page-header-content-font-size', '!=', ''),
				'tab' => 'header-content',
				'default' => '',
		),
		array(
				'name' => esc_html__('Content Font Style', 'fevr'),
				'id' => 'page-header-content-font-weight',
				'type' => 'luv_font_weight',
				'options' => array_flip($font_weight_list),
				'required' => array('page-content-subtitle', '!=', ''),
				'tab' => 'header-content',
				'default' => '',
		),
		array(
				'name' => esc_html__('Display Effect', 'fevr'),
				'desc' => esc_html__('What effect should the content be displayed with?', 'fevr'),
				'id' => 'page-header-title-effect',
				'type' => 'select',
				'options' => array(
					'none' => 'None',
					'zoom-out' => 'Zoom Out',
					'from-top' => 'From Top',
					'from-left' => 'From Left',
					'from-right' => 'From Right',
					'from-bottom' => 'From Bottom',
					'typewriter' => 'Typewriter',
					'pulse' => 'Pulse',
					'rubberBand' => 'Rubber',
					'swing' => 'Swing',
					'bounceIn' => 'Bounce',
					'flip' => 'Flip',
				),
				'tab' => 'header-appearance',
				'default' => 'none'
		),
		array(
				'name' => esc_html__('Text Alignment', 'fevr'),
				'id' => 'page-header-alignment',
				'type' => 'buttonset',
				'options' => array(
					'left' => esc_html__('Left', 'fevr'),
					'center' => esc_html__('Center', 'fevr'),
					'right' => esc_html__('Right', 'fevr'),
				),
				'tab' => 'header-appearance',
				'default' => 'left'
		),
		array(
				'name' => esc_html__('Content Width', 'fevr'),
				'id' => 'page-header-content-width',
				'type' => 'buttonset',
				'options' => array(
					'default' => esc_html__('Default', 'fevr'),
					'full_width' => esc_html__('Full Width', 'fevr'),
				),
				'tab' => 'header-appearance',
				'default' => 'default'
		),
		array(
				'name' => esc_html__('Background Color', 'fevr'),
				'desc' => esc_html__('If you\'re not using a picture, you can provide a background color.', 'fevr'),
				'id' => 'page-header-bg-color',
				'type' => 'color',
				'default' => '',
				'tab' => 'header-colors',
				'required' => array ('header-background-type', '!=', 'gradient'),
		),
		array(
				'name' => esc_html__('Font Color', 'fevr'),
				'desc' => esc_html__('Please select a valid color for the header.', 'fevr'),
				'id' => 'page-header-font-color',
				'type' => 'color',
				'tab' => 'header-colors',
				'default' => ''
		),
		array(
				'name' => esc_html__('Custom Light Color', 'fevr'),
				'desc' => esc_html__('Please select a valid color for the light skin.', 'fevr'),
				'id' => 'page-header-custom-light-color',
				'type' => 'color',
				'tab' => 'header-colors',
				'default' => ''
		),
		array(
				'name' => esc_html__('Custom Dark Color', 'fevr'),
				'desc' => esc_html__('Please select a valid color for the dark skin.', 'fevr'),
				'id' => 'page-header-custom-dark-color',
				'type' => 'color',
				'tab' => 'header-colors',
				'default' => ''
		),

		// Promo effect

		array(
				'name' => esc_html__('Background Image', 'fevr'),
				'desc' => esc_html__('The image set here will be displayed as background. The screen has to be centered vertically and horizontally.', 'fevr'),
				'id' => 'page-promo-bg-img',
				'type' => 'file_img',
				'tab' => 'header-promo',
			),
		array(
			'name' => esc_html__('Screen\'s Content', 'fevr'),
			'desc' => esc_html__('The image set here will be displayed as the content of the screen on the background. The aspect ratio should match with the screen on the background image.', 'fevr'),
			'id' => 'page-promo-content-img',
			'type' => 'file_img',
			'tab' => 'header-promo',
		),
		array(
			'name' => esc_html__('Slide Screen on Scroll', 'fevr'),
			'desc' => esc_html__('Enable it if you\'d like sliding screen content.', 'fevr'),
			'id' => 'page-promo-sliding-content',
			'type' => 'checkbox',
			'class' => 'switch-style',
			'tab' => 'header-promo',
		),


		// Additional settings
		$hide_featured,
		array(
				'name' => esc_html__('Breadcrumbs', 'fevr'),
				'desc' => esc_html__('Enable it if you\'d like breadcrumbs on the page.', 'fevr'),
				'id' => 'page-breadcrumbs',
				'type' => 'select',
				'options' => array(
					'default' => esc_html__('Default', 'fevr'),
					'enabled' => esc_html__('Show', 'fevr'),
					'disabled' => esc_html__('Hide', 'fevr'),
				),
				'default' => 'default',
				'tab' => 'page-general',
		),
		array(
				'name' => esc_html__('Hide Top Bar', 'fevr'),
				'desc' => esc_html__('Enable if you\'d like to hide the top bar.', 'fevr'),
				'id' => 'page-hide-top-bar',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'page-general',
		),
		array(
				'name' => esc_html__('Hide Header', 'fevr'),
				'desc' => esc_html__('Enable it if you\'d like to hide the header completely.', 'fevr'),
				'id' => 'page-header-hide',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'page-general',
		),
		array(
				'name' => esc_html__('Hide Footer', 'fevr'),
				'desc' => esc_html__('Enable it if you\'d like to hide the footer completely.', 'fevr'),
				'id' => 'page-footer-hide',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'page-general',
		),
		array(
				'name' => esc_html__('Hide Widget Area', 'fevr'),
				'desc' => esc_html__('Enable it if you\'d like to hide the widget area.', 'fevr'),
				'id' => 'page-footer-hide-widgets',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'disabled',
				'tab' => 'page-general',
		),
		array(
				'name' => esc_html__('Custom Navigation Menu', 'fevr'),
				'id' => 'custom-nav-menu',
				'type' => 'select',
				'data'	=> 'nav_menu',
				'default' => '',
				'tab' => 'page-general',
		),

		// Sidebars
		array(
			'name' => esc_html__('Sidebar', 'fevr'),
			'desc' => esc_html__('Please select which sidebar you want to be displayed. Custom sidebars can be created under the related menu in the "Theme Options".', 'fevr'),
			'id' => 'page-sidebar',
			'type' => 'select',
			'options' => $sidebars,
			'tab' => 'page-sidebar',
		),
		array(
			'name' => esc_html__('Sidebar Position', 'fevr'),
			'desc' => esc_html__('On which side should the sidebar appear on?', 'fevr'),
			'id' => 'page-sidebar-position',
			'type' => 'select',
			'options' => array(
				'left-sidebar' => esc_html__('Left', 'fevr'),
				'right-sidebar' => esc_html__('Right', 'fevr'),
			),
			'default' => 'right-sidebar',
			'tab' => 'page-sidebar',
		),

		array(
			'name' => esc_html__('Clone Settings', 'fevr'),
			'id' => 'clone-settings',
			'type' => 'clone-settings',
			'data' => 'current',
			'default' => 'fixed',
			'tab' => 'other-import-settings',
			'editor_only' => true
		),

		// Background color
		array(
				'name' => esc_html__('Background Color', 'fevr'),
				'desc' => esc_html__('Set custom background color for the current page', 'fevr'),
				'id' => 'page-background-color',
				'type' => 'color',
				'tab' => 'page-background',
		),

		// Background image for boxed
		array(
				'name' => esc_html__('Image', 'fevr'),
				'desc' => esc_html__('Set custom background image for the current page', 'fevr'),
				'id' => 'page-background-image',
				'type' => 'file_img',
				'default' => '',
				'tab' => 'page-background',
		),
		array(
			'name' => esc_html__('Background Repeat', 'fevr'),
			'id' => 'page-background-repeat',
			'type' => 'select',
			'options' => array(
				'no-repeat' => esc_html__('No repeat', 'fevr'),
				'repeat' => esc_html__('Repeat All', 'fevr'),
				'repeat-x' => esc_html__('Repeat Horizontally', 'fevr'),
				'repeat-y' => esc_html__('Repeat Vertically', 'fevr'),
			),
			'default' => 'no-repeat',
			'tab' => 'page-background',
			'required' => array ('page-background-image', '!=', ''),
		),
		array(
			'name' => esc_html__('Background Size', 'fevr'),
			'id' => 'page-background-size',
			'type' => 'select',
			'options' => array(
				'cover' => esc_html__('Cover', 'fevr'),
				'contain' => esc_html__('Contain', 'fevr'),
			),
			'default' => 'cover',
			'tab' => 'page-background',
			'required' => array ('page-background-image', '!=', ''),
		),
		array(
			'name' => esc_html__('Background Attachment', 'fevr'),
			'id' => 'page-background-attachment',
			'type' => 'select',
			'options' => array(
				'fixed' => esc_html__('Fixed', 'fevr'),
				'scroll' => esc_html__('Scroll', 'fevr'),
			),
			'default' => 'fixed',
			'tab' => 'page-background',
			'required' => array ('page-background-image', '!=', ''),
		),
		array(
			'name' => esc_html__('Background Position', 'fevr'),
			'id' => 'page-background-position',
			'type' => 'select',
			'options' => array(
				'left top' => esc_html__('Left Top', 'fevr'),
				'left center' => esc_html__('Left Center', 'fevr'),
				'left bottom' => esc_html__('Left Top', 'fevr'),
				'center top' => esc_html__('Center Top', 'fevr'),
				'center center' => esc_html__('Center Center', 'fevr'),
				'center bottom' => esc_html__('Center Top', 'fevr'),
				'right top' => esc_html__('Right Top', 'fevr'),
				'right center' => esc_html__('Right Center', 'fevr'),
				'right bottom' => esc_html__('Right Top', 'fevr'),
			),
			'default' => 'fixed',
			'tab' => 'page-background',
			'required' => array ('page-background-image', '!=', ''),
		),
	);

	//======================================================================
	// Conditional Tabs
	//======================================================================

	if($masonry) {
		$tabs[] = array (
			'title' => esc_html__('Masonry', 'fevr'),
			'class' => 'divider',
			'id' => 'masonry-divider',
		);

		$tabs[] = array(
			'title' => esc_html__('Sizing & Style', 'fevr'),
			'icon' => 'arrows-v',
			'id' => 'masonry-sizing-style',
		);

		$tabs[] = array(
			'title' => esc_html__('Content', 'fevr'),
			'icon' => 'align-left',
			'id' => 'masonry-content',
		);

		$tabs[] = array(
			'title' => esc_html__('Alignment', 'fevr'),
			'icon' => 'arrows-h',
			'id' => 'masonry-alignment',
		);

		$tabs[] = array(
			'title' => esc_html__('Colors', 'fevr'),
			'icon' => 'paint-brush',
			'id' => 'masonry-colors',
		);
	}

	if($portfolio) {
		$tabs[] = array (
			'title' => esc_html__('Project', 'fevr'),
			'class' => 'divider',
			'id' => 'project-divider',
		);
		$tabs[] = array (
			'title' => esc_html__('General', 'fevr'),
			'icon' => 'gear',
			'id' => 'project-general',
		);
	}

	//======================================================================
	// Other tab
	//======================================================================
	$tabs[] = array(
		'title' => esc_html__('Other', 'fevr'),
		'icon' => '',
		'class' => 'divider',
		'id' => 'other-divider',
	);
	$tabs[] = array(
		'title' => esc_html__('Clone Settings', 'fevr'),
		'icon' => 'copy',
		'id' => 'other-import-settings',
	);

	// Merge fields
	$fields = array_merge($fields, $conditional_fields);

	//======================================================================
	// Header Settings
	//======================================================================

	$meta_box = array(
		'id' => 'luv-header-meta-box',
		'title' => esc_html__('Page Settings', 'fevr'),
		'post_type' => array('page', 'post', 'luv_portfolio', 'luv_collections', 'product'),
		'context' => 'normal',
		'tabs' => $tabs,
		'priority' => 'low',
		'fields' => $fields,
	);

	foreach($meta_box['post_type'] as $post_type) {
		add_meta_box(
			$meta_box['id'],
			$meta_box['title'],
			'luv_create_meta_box_callback',
			$post_type,
			$meta_box['context'],
			$meta_box['priority'],
			$meta_box
		);

	}
}

?>
