<?php

class Luvthemes_Shortcodes{
	/**
	 * Contains shortcode editor fields
	 * @var array
	 */
	public $shortcodes = array ();

	/**
	 * Animation array for dropdowns
	 * @var array
	 */
	public $luv_vc_animations = array();

	/**
	 * Font style list for shortcode editors
	 * @var array
	 */
	public $luv_vc_font_weight_list = array();


	public function __construct(){
		// Init properties
		add_action ( 'init', array($this, 'init'), 0 );

		add_action ( 'vc_before_init', array($this, 'set_post_types'));

		// Visual Composer integration
		add_action( 'vc_before_init', array($this, 'init_shortcode_editors') );
		add_action( 'vc_mapper_init_after', array($this, 'integrate_to_VC'),11 );

		// Remove unnecessary shortcodes
		add_action( 'vc_before_init', array($this, 'remove_vc_elements') );

		// Extend default VC rows and columns
		if (!defined('FEVR_DISABLE_EXTEND_VC')){
			add_action( 'vc_before_init', array($this, 'extend_vc_elements') );
		}

		// Extend WooCommerce shortcodes
		add_action ( 'vc_after_mapping', array($this, 'extend_wc_shortcodes'),11);

		/*
		 * Add Shortcodes
		 */

		// Extend VC Shortcode
		require_once 'vc-extend.inc.php';

		// Init Blog
		add_shortcode ( 'luv_blog', array($this, 'blog_shortcode') );

		// Init Portfolio
		add_shortcode ( 'luv_portfolio', array($this, 'portfolio_shortcode') );

		// Init Collection
		add_shortcode ( 'luv_collection', array($this, 'collection_shortcode') );

		// Init Photo Reviews
		add_shortcode ( 'luv_reviews', array($this, 'reviews_shortcode') );

		// Init Before-After
		add_shortcode ( 'luv_before_after', array($this, 'before_after_shortcode') );

		// Slider
		add_shortcode ( 'luv_slider', array($this, 'slider_shortcode'));

		// Snippet
		add_shortcode ( 'luv_snippet', array($this, 'snippet_shortcode'));
		add_action ( 'wp_ajax_luv_load_snippet', array($this, 'ajax_lazyload_snippet'));
		add_action ( 'wp_ajax_nopriv_luv_load_snippet', array($this, 'ajax_lazyload_snippet'));

		// Init Carousel Shortcode
		add_shortcode ( 'luv_carousel', array($this, 'carousel_shortcode') );
		add_shortcode ( 'luv_carousel_slide', array($this, 'carousel_slide_shortcode') );

		// Tab Shortcode
		add_shortcode ( 'luv_tab', array($this, 'tab_shortcode') );
		add_shortcode ( 'luv_tab_inner', array($this, 'tab_inner_shortcode') );

		// Accordion Shortcode
		add_shortcode ( 'luv_accordion', array($this, 'accordion_shortcode') );
		add_shortcode ( 'luv_accordion_inner', array($this, 'accordion_inner_shortcode') );

		// Multiscroll Shortcode
		add_shortcode ( 'luv_multiscroll', array($this, 'multiscroll_shortcode') );
		add_shortcode ( 'luv_multiscroll_inner', array($this, 'multiscroll_inner_shortcode') );
		add_shortcode ( 'luv_multiscroll_section', array($this, 'multiscroll_section_shortcode') );

		// Testimonials Shortcode
		add_shortcode ( 'luv_testimonials', array($this, 'testimonials_shortcode') );
		add_shortcode ( 'luv_testimonials_inner', array($this, 'testimonials_inner_shortcode') );

		// Button Shortcode
		add_shortcode ( 'luv_button', array($this, 'button_shortcode') );

		// Pricing Shortcode
		add_shortcode ( 'luv_pricing_table', array($this, 'pricing_table_shortcode') );
		add_shortcode ( 'luv_pricing_column', array($this, 'pricing_column_shortcode') );

		// Share Shortcode
		add_shortcode ( 'luv_share', array($this, 'share_shortcode') );

		// Social Sidebar
		add_shortcode ( 'luv_social_sidebar', array($this, 'social_sidebar_shortcode') );

		// Create share count ajax hook
		add_action('wp_ajax_luv_share_count', array($this, 'ajax_load_share_count'));
		add_action('wp_ajax_nopriv_luv_share_count', array($this, 'ajax_load_share_count'));

		// Counter Shortcode
		add_shortcode ( 'luv_counter', array($this, 'counter_shortcode') );

		// Countdown Shortcode
		add_shortcode ( 'luv_countdown', array($this, 'countdown_shortcode') );

		// Google Maps
		add_shortcode ( 'luv_gmap', array($this, 'gmap_shortcode') );
		add_shortcode ( 'luv_gmap_address', array($this, 'gmap_address_shortcode') );

		// Animated List Shortcode
		add_shortcode ( 'luv_animated_list', array($this, 'animated_list_shortcode') );
		add_shortcode ( 'luv_animated_list_inner', array($this, 'animated_list_inner_shortcode') );

		// Page Section Shortcode
		add_shortcode ( 'luv_page_section', array($this, 'page_section_shortcode') );

		// Page Submenu Shortcode
		add_shortcode ( 'luv_page_submenu', array($this, 'page_submenu_shortcode') );
		add_shortcode ( 'luv_page_submenu_item', array($this, 'page_submenu_item_shortcode') );

		// Heading Shortcode
		add_shortcode ( 'luv_heading', array($this, 'heading_shortcode') );

		// Separator Shortcode
		add_shortcode ( 'luv_separator', array($this, 'separator_shortcode') );

		// Icon Box Shortcode
		add_shortcode ( 'luv_icon_box', array($this, 'icon_box_shortcode') );

		// Icon Shortcode
		add_shortcode ( 'luv_icon', array($this, 'icon_shortcode') );

		// Dropcaps Shortcode
		add_shortcode ( 'luv_dropcaps', array($this, 'dropcaps_shortcode') );

		// Message box Shortcode
		add_shortcode ( 'luv_message_box', array($this, 'message_box_shortcode') );

		// Team Shortcode
		add_shortcode ( 'luv_team', array($this, 'team_shortcode') );

		// AJAX Search Shortcode
		add_shortcode ( 'luv_search', array($this, 'search_shortcode') );
		add_action('wp_ajax_luv_ajax_search', array($this, 'ajax_search'));
		add_action('wp_ajax_nopriv_luv_ajax_search', array($this, 'ajax_search'));

		// AJAX Login Shortcode
		add_shortcode ( 'luv_login', array($this, 'login_shortcode') );
		add_action ( 'wp_ajax_luv_ajax_login',  array($this, 'ajax_login'));
		add_action ( 'wp_ajax_nopriv_luv_ajax_login',  array($this, 'ajax_login'));
		add_action ( 'wp_ajax_luv_ajax_retrieve_password',  array($this, 'ajax_retrieve_password'));
		add_action ( 'wp_ajax_nopriv_luv_ajax_retrieve_password',  array($this, 'ajax_retrieve_password'));


		//Ajax Register Shortcode
		add_shortcode ( 'luv_register', array($this, 'register_shortcode') );
		add_action ( 'wp_ajax_luv_ajax_register',  array($this, 'ajax_register'));
		add_action ( 'wp_ajax_nopriv_luv_ajax_register',  array($this, 'ajax_register'));
		add_action ( 'wp_ajax_luv_force_redirect',  array($this, 'force_redirect'));
		add_action ( 'wp_ajax_nopriv_luv_force_redirect',  array($this, 'force_redirect'));

		// Custom AJAX Grid Shortcode
		add_shortcode ( 'luv_custom_grid', array($this, 'custom_grid'));
		add_shortcode ( 'luv_custom_grid_filter', array($this, 'custom_grid_filter'));
		add_action ( 'wp_ajax_custom_grid_filter',  array($this, 'ajax_custom_grid'));
		add_action ( 'wp_ajax_nopriv_custom_grid_filter',  array($this, 'ajax_custom_grid'));

		// Facebook comments Shortcode
		add_shortcode ( 'luv_facebook_comments', array($this, 'facebook_comments_shortcode') );

		// Video
		add_shortcode ( 'luv_video', array($this, 'video_shortcode') );

		// Perspective box
		add_shortcode ( 'luv_perspective_box', array($this, 'perspective_box_shortcode') );
		add_shortcode ( 'luv_perspective_image', array($this, 'perspective_image_shortcode') );

		// Image slide box
		add_shortcode ( 'luv_image_slide_box', array($this, 'image_slide_box_shortcode') );
		add_shortcode ( 'luv_image_slide_box_image', array($this, 'image_slide_box_image_shortcode') );

		// Image box
		add_shortcode ( 'luv_image_box', array($this, 'image_box_shortcode') );

		// Lipsum
		add_shortcode ( 'luv_lipsum', array($this, 'lipsum') );

		// WPML language selector
		add_shortcode( 'wpml_language_selector', array($this, 'wpml_language_selector_shortcode') );

		// Current year shortcode
		add_shortcode( 'current_year', array($this, 'current_year_shortcode') );

		// Site title shortcode
		add_shortcode( 'site_title', array($this, 'site_title_shortcode') );

		// Site tagline shortcode
		add_shortcode( 'site_tagline', array($this, 'site_tagline_shortcode') );

		// Site URL shortcode
		add_shortcode( 'site_url', array($this, 'site_url_shortcode') );

		// Login URL shortcode
		add_shortcode( 'login_url', array($this, 'login_url_shortcode') );

		// Logout URL shortcode
		add_shortcode( 'logout_url', array($this, 'logout_url_shortcode') );

		// Enqueue Facebook SDK
		add_shortcode ( 'luv_enqueue_facebook_sdk', array($this, 'enqueue_fb_sdk') );

		/*
		 * Extend VC custom CSS
		 */

		if (defined ( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' )) {
			add_filter ( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array($this, 'vc_custom_css'), 10, 3 );
		}

		/*
		 * Helpers
		 */

		// Print footer assets
		add_action ( 'wp_footer', array($this, 'print_footer_assets') );

		// Existing content list ajax hook for luv_url field
		add_action ('wp_ajax_luv_existing_content_list', array($this,'ajax_existing_content_list'));

		// Autocomplete
		if (defined('DOING_AJAX') && DOING_AJAX){
			require_once 'helpers/vc-autocomplete.inc.php';
		}


	}

	/**
	 * Init properties
	 */
	public function init(){
		// Luv animations
		$this->luv_vc_animations = array (
				esc_html__( 'None', 'fevr' ) => '',
				esc_html__( 'Fade in', 'fevr' ) => 'c-animate-fade-in',
				esc_html__( 'Fade in from top', 'fevr' ) => 'c-animate-top',
				esc_html__( 'Fade in from bottom', 'fevr' ) => 'c-animate-bottom',
				esc_html__( 'Fade in from left', 'fevr' ) => 'c-animate-left',
				esc_html__( 'Fade in from right', 'fevr' ) => 'c-animate-right',
				esc_html__( 'Zoom in', 'fevr' ) => 'c-animate-zoom-in',
				sprintf(esc_html__( 'Zoom in %s Spin', 'fevr' ),'&') => 'c-animate-zoom-in-spin'
		);

		// Prepare roles
		global $wp_roles;
		$this->roles = array(
				esc_html__('All', 'fevr') 		 => 'all',
				esc_html__('Logged in', 'fevr') => 'logged-in'
		);

		foreach ($wp_roles->get_names() as $key=>$value){
			$this->roles[$value] = $key;
		}

		//Prepare caps
		$this->allcaps = array(
				'manage_network',
				'manage_sites',
				'manage_network_users',
				'manage_network_plugins',
				'manage_network_themes',
				'manage_network_options',
				'activate_plugins',
				'delete_others_pages',
				'delete_others_posts',
				'delete_pages',
				'delete_posts',
				'delete_private_pages',
				'delete_private_posts',
				'delete_published_pages',
				'delete_published_posts',
				'edit_dashboard',
				'edit_others_pages',
				'edit_others_posts',
				'edit_pages',
				'edit_posts',
				'edit_private_pages',
				'edit_private_posts',
				'edit_published_pages',
				'edit_published_posts',
				'edit_theme_options',
				'export',
				'import',
				'list_users',
				'manage_categories',
				'manage_links',
				'manage_options',
				'moderate_comments',
				'promote_users',
				'publish_pages',
				'publish_posts',
				'read_private_pages',
				'read_private_posts',
				'read',
				'remove_users',
				'switch_themes',
				'upload_files',
				'update_core',
				'update_plugins',
				'update_themes',
				'install_plugins',
				'install_themes',
				'delete_themes',
				'delete_plugins',
				'edit_plugins',
				'edit_themes',
				'edit_files',
				'edit_users',
				'create_users',
				'delete_users',
				'unfiltered_html'
		);


		// Font styles
		$this->luv_vc_font_weight_list = array (
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

		// Carousel settings
		$this->carousel_params = array(
				array (
						'type' 			=> 'luv_switch',
						'heading' 		=> esc_html__( 'Carousel', 'fevr'),
						'param_name' 	=> 'luv_carousel',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Arrows', 'fevr'),
						'param_name'	=> 'nav',
						'type'			=> 'luv_switch',
						"dependency" 	=> array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Dots', 'fevr'),
						'param_name'	=> 'dots',
						'type'			=> 'luv_switch',
						"dependency" 	=> array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Infinite', 'fevr'),
						'param_name'	=> 'infinite',
						'type'			=> 'luv_switch',
						"dependency" 	=> array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Autoplay', 'fevr'),
						'param_name'	=> 'autoplay',
						'type'		=> 'luv_switch',
						"dependency" => array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Autoplay Timeout', 'fevr'),
						'param_name'	=> 'autoplay_timeout',
						'type'			=> 'number',
						'std'		=> '5000',
						'extra'			=> array('min' => 0),
						"dependency"	=> array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Pause Autoplay on Hover', 'fevr'),
						'param_name'	=> 'autoplay_pause',
						'type'			=> 'luv_switch',
						"dependency"	=> array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Full Height', 'fevr'),
						'param_name'	=> 'full_height',
						'type'		=> 'luv_switch',
						"dependency" => array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Margin Between Items', 'fevr'),
						'param_name'	=> 'margin',
						'type'			=> 'number',
						'value'			=> 10,
						'extra'			=> array('min' => 0),
						"dependency" => array("element" => "luv_carousel", "value" => array("true")),
						'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Transition Type', 'fevr'),
						'param_name'	=> 'transition_type',
						'type'			=> 'dropdown',
						'value'			=> array(
								'Slide'		=> 'slide',
								'Fade Out'	=> 'fadeOut',
								'flipInX'	=> 'flipInX',
						),
						"dependency"	 => array("element" => "luv_carousel", "value" => array("true")),
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
				array(
						'heading'		=> esc_html__('Items', 'fevr'),
						'param_name'	=> 'items',
						'type'			=> 'number',
						'value'			=> 1,
						'extra'			=> array('min' => 1, 'responsive' => true),
						"dependency" 	=> array("element" => "luv_carousel", "value" => array("true")),
						'group'			=> esc_html__( 'Carousel', 'fevr')
				),
		);

		// WooCommerce product box styles
		$this->wc_styles = array(
				esc_html__('Default', 'fevr') => '',
				esc_html__('Style 1', 'fevr') => 'wc-style-1',
				esc_html__('Style 2', 'fevr') => 'wc-style-2',
				esc_html__('Style 3', 'fevr') => 'wc-style-3',
				esc_html__('Style 4', 'fevr') => 'wc-style-4',
				esc_html__('Style 5', 'fevr') => 'wc-style-5',
				esc_html__('Style 6', 'fevr') => 'wc-style-6',
		);

		$this->intermediate_image_sizes = array(
			esc_html__('Original', 'fevr') => 'full'
		);

		$image_sizes = get_intermediate_image_sizes();

		foreach ($image_sizes as $key=>$value){
			$this->intermediate_image_sizes[ucfirst(str_replace('_', ' ', $value))] = $value;
		}
	}

	/**
	 * Set available post types
	 */
	public function set_post_types(){
		// Prepare post types
		foreach(get_post_types() as $post_type){
			if (!in_array($post_type, array('revision', 'nav_menu_item')) && post_type_supports($post_type, 'editor')){
				$this->post_types[] = $post_type;
			}
		}
	}

	/**
	 * Custom Properties for Visual Composer elements
	 * @param string $classes
	 * @param string $base
	 * @param array $atts
	 * @return string
	 */
	public function vc_custom_css($classes, $base = '', $atts = array()) {
		global $luv_enqueued_inline_fonts;
		$luv_classes = $luv_child_classes = $luv_landscape_media_classes = $luv_landscape_media_child_classes = $luv_portrait_media_classes = $luv_portrait_media_child_classes = $luv_mobile_media_classes = $luv_mobile_media_child_classes = array ();

		// Text alignment
		if (isset($atts['luv_text_alignment']) && !empty($atts['luv_text_alignment'])){
			$luv_classes[] = 'text-align:' . $atts['luv_text_alignment'] . ' !important';
		}

		// Text transform
		if (isset($atts['text_transform']) && !empty($atts['text_transform'])){
			$luv_classes[] = 'text-transform:' . $atts['text_transform'] . ' !important';
		}

		// Font style
		if (isset($atts['font_weight'] ) && !empty($atts['font_weight'] )) {
			preg_match('~(\d*)([a-z]*)?~',$atts['font_weight'], $font_style);
			$luv_classes[] = 'font-weight:' . $font_style[1] . ' !important';
			if (isset($font_style[2])){
				$luv_classes[] = 'font-style:' . $font_style[2] . ' !important';
			}
		}

		// Font family
		if (isset($atts['font_family'] ) && !empty($atts['font_family'] )) {
			$luv_classes[] = 'font-family: \''.$atts['font_family'] . '\' !important;';
			$luv_child_classes[' .fa'] = 'font-family: \'FontAwesome\' !important;';
			$luv_child_classes[' [class^="ion-"]'] = 'font-family: \'Ionicons\' !important;';
			$luv_child_classes[' [class^="linea-"]'] = 'font-family: \'linea\' !important;';
			$weight = (!empty($atts['font_weight']) ? $atts['font_weight'] : 'regular');
			$luv_enqueued_inline_fonts[$atts['font_family']][$weight] = $weight;
		}

		// Line height
		if (isset($atts['line_height'] ) && !empty($atts['line_height'] )) {
			$luv_classes[] = 'line-height:' . $atts['line_height'] . ' !important';
		}

		// Font color
		if (isset($atts['font_color'] ) && !empty($atts['font_color'] )) {
			$luv_classes[] = 'color:' . $atts['font_color'] . ' !important';
		}

		// Set child classes
		if (!empty($luv_classes )) {
			$luv_child_classes[' *'] = implode ( ';', $luv_classes );
		}

		if (!empty($luv_mobile_media_classes )) {
			$luv_mobile_media_child_classes[' *'] = implode ( ';', $luv_mobile_media_classes );
		}

		if (!empty($luv_portrait_media_classes )) {
			$luv_portrait_media_child_classes[' *'] = implode ( ';', $luv_portrait_media_classes );
		}

		if (!empty($luv_landscape_media_classes )) {
			$luv_landscape_media_child_classes[' *'] = implode ( ';', $luv_landscape_media_classes );
		}

		// Font size after child classess (we use always 1em in childs)
		if (isset($atts['font_size'] ) && !empty($atts['font_size'])) {
			preg_match('~([\d\.]+)(\D+)?~',$atts['font_size'], $_font_atts);
			$_font_atts[2] = (isset($_font_atts[2]) && !empty($_font_atts[2]) ? $_font_atts[2] : 'px');

			// Responsive font sizes
			if (isset($atts['responsive_font_size']) && $atts['responsive_font_size'] == 'true'){
				// Use smaller responsive fonts for header subtitle and slider caption
				if (in_array($base, array('page_header_subtitle', 'slide_caption'))){
					$_xs = 0.4;
					$_s = 0.6;
				}
				else{
					$_xs = ($_font_atts[1] >= 100 ? 0.4 : 0.65);
					$_s = ($_font_atts[1] >= 100 ? 0.6 : 0.85);
				}

				$font_size_xs	= (round($_font_atts[1] * $_xs) >= 14 ? round($_font_atts[1] * $_xs) : 14);
				$font_size_s	= (round($_font_atts[1] * $_s)	>= 14 ? round($_font_atts[1] * $_s) : 14);

				$luv_mobile_media_classes[] = 'font-size:' . $font_size_xs . $_font_atts[2] . ' !important';
				$luv_portrait_media_classes[] = 'font-size:' . $font_size_s . $_font_atts[2] . ' !important';
				$luv_landscape_media_classes[] = 'font-size:' . $_font_atts[1] . $_font_atts[2] . ' !important';

				$luv_mobile_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] = (isset($luv_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)']) ? $luv_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] . ';' : '') . 'font-size:1em !important;';
				$luv_portrait_media_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] = (isset($luv_portrait_media_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)']) ? $luv_portrait_media_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] . ';' : '') . 'font-size:1em !important;';
				$luv_landscape_media_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] = (isset($luv_landscape_media_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)']) ? $luv_landscape_media_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] . ';' : '') . 'font-size:1em !important;';
			}
			// Non-responsive font size
			else{
				$luv_classes[] = 'font-size:' . $_font_atts[1] . $_font_atts[2] . ' !important';
			}

			$luv_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] = (isset($luv_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)']) ? $luv_child_classes[' *:not(.icon-box-icon):not(.luv-message-box-icon)'] . ';' : '') . 'font-size:1em !important;';
		}

		// Link color
		if (isset($atts['link_color'] ) && !empty($atts['link_color'] )) {
			$luv_child_classes[' a'] = 'color:' . $atts['link_color'] . ' !important';
		}

		// Full height column
		if (isset($atts['full_height_column'] ) && $atts['full_height_column'] == 'true') {
			$classes .= ' full_height_column';
		}

		// Animation
		if (isset($atts['luv_animation'] ) && !empty($atts['luv_animation'])) {
			$classes .= ' c-has-animation ' . $atts['luv_animation'];
		}

		// Background animation
		if (isset($atts['luv_background_animation']) && !empty($atts['luv_background_animation'])){
			$classes .= ' luv-bg-animation luv-bg-animation-' . $atts['luv_background_animation'];
			if (isset($atts['luv_background_animation_speed']) && !empty($atts['luv_background_animation_speed'])){
				$classes .= ' ' . $atts['luv_background_animation_speed'];
			}
		}

		// Extra margin on small devices
		if (isset($atts['luv_has_column_margin']) && $atts['luv_has_column_margin'] == 'true' && isset($atts['luv_column_margin'])){
			$luv_mobile_media_child_classes[' .wpb_column.vc_column_container:not(:last-child)'] = $luv_portrait_media_child_classes[' .wpb_column.vc_column_container:not(:last-child)'] = 'margin-bottom: ' . (int)$atts['luv_column_margin'] . 'px !important;';
		}

		// Columns for Text Blocks
		if (isset($atts['luv_columns']) && !empty($atts['luv_columns'])){
			$luv_columns_portrait = ($atts['luv_columns'] >= 2 ? 2 : $atts['luv_columns']);

			$luv_landscape_media_child_classes[' .wpb_wrapper'] = '-webkit-columns: ' . $atts['luv_columns'].';-moz-columns: ' . $atts['luv_columns'].';columns: ' . $atts['luv_columns'].';';
			$luv_portrait_media_child_classes[' .wpb_wrapper'] = '-webkit-columns: '.$luv_columns_portrait.';-moz-columns:  '.$luv_columns_portrait.';columns:  '.$luv_columns_portrait.';';
			$luv_mobile_media_child_classes[' .wpb_wrapper'] = '-webkit-columns: initial;-moz-columns: initial;columns: initial;';
		}

		// Floating animation
		if (isset($atts['luv_floating']) && $atts['luv_floating'] == 'true'){
			$classes .= ' luv-floating-image';
		}

		// Sticky column
		if (isset($atts['luv_sticky_column']) && $atts['luv_sticky_column'] == 'true'){
			$classes .= ' luv-sticky-column';
		}

		// Expandable Row
		if (isset($atts['luv_expandable_row']) && $atts['luv_expandable_row'] == 'true'){
			$classes .= ' luv-expandable-row';

			$expandable_row_max_height	= (isset($atts['luv_expandable_row_height']) ? (int)$atts['luv_expandable_row_height'] : 100);
			$expandable_row_colors		= str_split((isset($atts['luv_expandable_row_color']) ? str_replace('#','',$atts['luv_expandable_row_color']) : 'F8F8F8'), 2);


			foreach ($expandable_row_colors as $exp_color_key => $exp_color_val){
				$expandable_row_colors[$exp_color_key] = hexdec($exp_color_val);
			}

			$classes .= ' ' . _luv_enqueue_inline_css(array(
					'style' => 'max-height: ' . $expandable_row_max_height . 'px',
					'child' => array(':not(.expanded):after' =>
						'background: -moz-linear-gradient(top,  rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',0) 0%, rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',1) 90%, rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',1) 99%);'.
						'background: -webkit-linear-gradient(top,  rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',0) 0%,rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',1) 90%,rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',1) 99%);'.
						'background: linear-gradient(to bottom,  rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',0) 0%,rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',1) 90%,rgba(' . $expandable_row_colors[0] . ',' . $expandable_row_colors[1] . ',' . $expandable_row_colors[2] . ',1) 99%);'.
						'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#' . (isset($atts['expandable_row_max_color']) ? (int)$atts['expandable_row_max_color'] : 'F8F8F8') . '\', endColorstr=\'#' . (isset($atts['expandable_row_max_color']) ? (int)$atts['expandable_row_max_color'] : 'F8F8F8') . '\',GradientType=0 );'
					)
			));

		}

		// Custom css
		if (isset($atts['luv_custom_css']) && !empty($atts['luv_custom_css'])){
			$classes .= ' ' . _luv_enqueue_inline_css(array('style' => strip_tags($atts['luv_custom_css'])));
		}


		if ($base == 'vc_row_inner'){
			$parent = 'html .vc_inner';
		}
		else if ($base == 'vc_column_text'){
			$parent = 'html .wpb_text_column.wpb_content_element';
		}
		else if ($base == 'luv_icon_box_title'){
			$parent = 'html body .icon-box .icon-box-content ';
		}
		else if ($base == 'page_header_title'){
			$parent = 'html #page-header-custom .page-header-title';
		}
		else if ($base == 'page_header_subtitle'){
			$parent = 'html #page-header-custom .page-header-subtitle';
		}
		else if ($base == 'page_header_content'){
			$parent = 'html #page-header-custom .page-header-content';
		}
		else if ($base == 'slide_heading' || $base == 'slide_caption'){
			$parent = 'html body #l-wrapper ';
		}
		else{
			$parent = 'html ';
		}

		return $classes . ' ' . _luv_enqueue_inline_css (
				array (
							'parent'	=> $parent,
							'style'		=> implode ( ';', $luv_classes),
							'child'		=> $luv_child_classes,
					)
				) . ' ' . _luv_enqueue_inline_css (
				array (
							'parent'	=> $parent,
							'style' 	=> implode ( ';', $luv_mobile_media_classes),
							'child' 	=> $luv_mobile_media_child_classes,
							'media' 	=> '(max-width: 459px)'
					)
				) . ' ' . _luv_enqueue_inline_css (
				array (
							'parent'	=> $parent,
							'style'		=> implode ( ';', $luv_portrait_media_classes),
							'child'		=> $luv_portrait_media_child_classes,
							'media'		=> '(min-width: 460px) and (max-width: 767px)'
					)
				) . ' ' . _luv_enqueue_inline_css (
				array (
							'parent'	=> $parent,
							'style'		=> implode ( ';', $luv_landscape_media_classes),
							'child'		=> $luv_landscape_media_child_classes,
							'media'		=> '(min-width: 768px)'
					)
				);
	}

	/**
	 * Remove unnecessary elements from Visual Composer
	 */
	public function remove_vc_elements(){
		if (apply_filters('luv_disable_vc_message', true)){
			vc_remove_element( "vc_message" );
		}
		if (apply_filters('luv_disable_vc_icon', true)){
			vc_remove_element( "vc_icon" );
		}
		if (apply_filters('luv_disable_vc_tta_tour', true)){
			vc_remove_element( "vc_tta_tour" );
		}
		if (apply_filters('luv_disable_vc_tta_accordion', true)){
			vc_remove_element( "vc_tta_accordion" );
		}
		if (apply_filters('luv_disable_vc_tta_tabs', true)){
			vc_remove_element( "vc_tta_tabs" );
		}
		if (apply_filters('luv_disable_vc_custom_heading', true)){
			vc_remove_element( "vc_custom_heading" );
		}
		if (apply_filters('luv_disable_vc_empty_space', true)){
			vc_remove_element( "vc_empty_space" );
		}
		if (apply_filters('luv_disable_vc_gmaps', true)){
			vc_remove_element( "vc_gmaps" );
		}
		if (apply_filters('luv_disable_vc_separator', true)){
			vc_remove_element( "vc_separator" );
		}
	}

	/**
	 * Extend Visual Composer Design Settings
	 * Add:
	 * 		- Typography
	 * 		- Animations
	 * 		- Full height column
	 * 		- Text alignment
	 */
	public function extend_vc_elements() {
		// Fonts
		global $fevr_vc_font_family_list;

		// VC column width
		$luv_vc_column_width_list = array (
				esc_html__( '1 column - 1/12', 'js_composer' ) => '1/12',
				esc_html__( '2 columns - 1/6', 'js_composer' ) => '1/6',
				esc_html__( '3 columns - 1/4', 'js_composer' ) => '1/4',
				esc_html__( '4 columns - 1/3', 'js_composer' ) => '1/3',
				esc_html__( '5 columns - 5/12', 'js_composer' ) => '5/12',
				esc_html__( '6 columns - 1/2', 'js_composer' ) => '1/2',
				esc_html__( '7 columns - 7/12', 'js_composer' ) => '7/12',
				esc_html__( '8 columns - 2/3', 'js_composer' ) => '2/3',
				esc_html__( '9 columns - 3/4', 'js_composer' ) => '3/4',
				esc_html__( '10 columns - 5/6', 'js_composer' ) => '5/6',
				esc_html__( '11 columns - 11/12', 'js_composer' ) => '11/12',
				esc_html__( '12 columns - 1/1', 'js_composer' ) => '1/1'
		);

		// Column settings
		vc_map ( array (
				'name' => __( 'Column', 'js_composer' ),
				'base' => 'vc_column',
				'icon' => 'icon-wpb-row',
				'html_template' => LUVTHEMES_CORE_PATH . 'includes/vc/vc_column.php',
				'is_container' => true,
				'content_element' => false,
				'description' => __( 'Place content elements inside the column', 'js_composer' ),
				'params' => array (
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Full height column', 'fevr' ),
								'param_name' => 'full_height_column',
								'description' => __( 'If checked column will be set to full height.', 'fevr' ),
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Sticky column', 'fevr' ),
								'param_name' => 'luv_sticky_column',
								'description' => __( 'If checked column will be sticky.', 'fevr' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr' ),
								"std" => ''
						),
						array (
								'type' => 'luv_url',
								'heading' => esc_html__( 'Column Link', 'fevr' ),
								'param_name' => 'column_link',
								'description' => __( 'Set link for the column', 'fevr' )
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text alignment', 'fevr' ),
								'param_name' => 'luv_text_alignment',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Inherit') => '',
										esc_html__('Left', 'fevr') => 'left',
										esc_html__('Center', 'fevr') => 'center',
										esc_html__('Right', 'fevr') => 'right',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation', 'fevr' ),
								'param_name' => 'luv_background_animation',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Left to Right', 'fevr') => 'left-to-right',
										esc_html__('Right to left', 'fevr') => 'right-to-left',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation speed', 'fevr' ),
								'param_name' => 'luv_background_animation_speed',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Slow', 'fevr') => 'luv-bg-animation-slow',
										esc_html__('Normal', 'fevr') => 'luv-bg-animation-normal',
										esc_html__('Fast', 'fevr') => 'luv-bg-animation-fast'
								),
								'std' => 'luv-bg-animation-normal',
								'dependency' => array('element' => 'luv_background_animation', 'not_empty' => true),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Column overlay', 'fevr' ),
								'param_name' => 'column_overlay',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Default overlay color', 'fevr' ),
								'param_name' => 'column_effect_default',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'dependency' => array('element' => 'column_overlay', 'value' => array('true')),
								'description' => __('Default state box color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param'
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Hover overlay color', 'fevr' ),
								'param_name' => 'column_effect_hover',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'dependency' => array('element' => 'column_overlay', 'value' => array('true')),
								'description' => __('Hovered state box color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param'
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Hover text color', 'fevr' ),
								'param_name' => 'column_effect_text_hover',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'dependency' => array('element' => 'column_overlay', 'value' => array('true')),
								'description' => __('Hovered state box color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param'
						),
						array (
								'type' => 'textarea',
								'heading' => esc_html__( 'Custom CSS', 'fevr' ),
								'param_name' => 'luv_custom_css',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'description' => __('Custom CSS for this column', 'fevr'),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Width', 'js_composer' ),
								'param_name' => 'width',
								'value' => $luv_vc_column_width_list,
								'group' => esc_html__( 'Responsive Options', 'js_composer' ),
								'description' => __( 'Select column width.', 'js_composer' ),
								'std' => '1/1'
						),
						array (
								'type' => 'column_offset',
								'heading' => esc_html__( 'Responsiveness', 'js_composer' ),
								'param_name' => 'offset',
								'group' => esc_html__( 'Responsive Options', 'js_composer' ),
								'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'js_composer' )
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								"dependency" 	=> array("element" => "font_size", "not_empty" => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'description' => __( 'Font color for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'description' => __( 'Link color for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Google Analytics InView', 'fevr' ),
								'param_name' => 'ga_inview',
								'std' => 'false',
								'description' => __( 'Send an event to Google Analytics when element is in viewport', 'fevr' ),
								'group' => esc_html__( 'Tracking', 'fevr' )
						),
						array (
								'heading' => esc_html__( 'Event Category', 'fevr' ),
								'param_name' => 'ga_event_category',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Action', 'fevr' ),
								'param_name' => 'ga_event_action',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Label', 'fevr' ),
								'param_name' => 'ga_event_label',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Value', 'fevr' ),
								'param_name' => 'ga_event_value',
								'type' => 'number',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
				),
				'js_view' => 'VcColumnView'
		) );

		// Inner Column Settings
		vc_map ( array (
				'name' => __( 'Inner Column', 'js_composer' ),
				'base' => 'vc_column_inner',
				'icon' => 'icon-wpb-row',
				'html_template' => LUVTHEMES_CORE_PATH . 'includes/vc/vc_column_inner.php',
				'class' => '',
				'wrapper_class' => '',
				'controls' => 'full',
				'allowed_container_element' => false,
				'content_element' => false,
				'is_container' => true,
				'description' => __( 'Place content elements inside the inner column', 'js_composer' ),
				'params' => array (
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'value' => '',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr' ),
								"std" => ''
						),
						array (
								'type' => 'luv_url',
								'heading' => esc_html__( 'Column Link', 'fevr' ),
								'param_name' => 'column_link',
								'description' => __( 'Set link for the column', 'fevr' )
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text alignment', 'fevr' ),
								'param_name' => 'luv_text_alignment',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Inherit') => '',
										esc_html__('Left', 'fevr') => 'left',
										esc_html__('Center', 'fevr') => 'center',
										esc_html__('Right', 'fevr') => 'right',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation', 'fevr' ),
								'param_name' => 'luv_background_animation',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Left to Right', 'fevr') => 'left-to-right',
										esc_html__('Right to left', 'fevr') => 'right-to-left',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation speed', 'fevr' ),
								'param_name' => 'luv_background_animation_speed',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Slow', 'fevr') => 'luv-bg-animation-slow',
										esc_html__('Normal', 'fevr') => 'luv-bg-animation-normal',
										esc_html__('Fast', 'fevr') => 'luv-bg-animation-fast'
								),
								'std' => 'luv-bg-animation-normal',
								'dependency' => array('element' => 'luv_background_animation', 'not_empty' => true),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Column overlay', 'fevr' ),
								'param_name' => 'column_overlay',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Default overlay color', 'fevr' ),
								'param_name' => 'column_effect_default',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'dependency' => array('element' => 'column_overlay', 'value' => array('true')),
								'description' => __('Default state box color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param'
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Hover overlay color', 'fevr' ),
								'param_name' => 'column_effect_hover',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'dependency' => array('element' => 'column_overlay', 'value' => array('true')),
								'description' => __('Hovered state box color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param'
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Hover text color', 'fevr' ),
								'param_name' => 'column_effect_text_hover',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'dependency' => array('element' => 'column_overlay', 'value' => array('true')),
								'description' => __('Hovered state box color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param'
						),
						array (
								'type' => 'textarea',
								'heading' => esc_html__( 'Custom CSS', 'fevr' ),
								'param_name' => 'luv_custom_css',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'description' => __('Custom CSS for this column', 'fevr'),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Width', 'js_composer' ),
								'param_name' => 'width',
								'value' => $luv_vc_column_width_list,
								'group' => esc_html__( 'Responsive Options', 'js_composer' ),
								'description' => __( 'Select column width.', 'js_composer' ),
								'std' => '1/1'
						),
						array (
								'type' => 'column_offset',
								'heading' => esc_html__( 'Responsiveness', 'js_composer' ),
								'param_name' => 'offset',
								'group' => esc_html__( 'Responsive Options', 'js_composer' ),
								'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'js_composer' )
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								"dependency" 	=> array("element" => "font_size", "not_empty" => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'description' => __( 'Font color for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'description' => __( 'Link color for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Google Analytics InView', 'fevr' ),
								'param_name' => 'ga_inview',
								'std' => 'false',
								'description' => __( 'Send an event to Google Analytics when element is in viewport', 'fevr' ),
								'group' => esc_html__( 'Tracking', 'fevr' )
						),
						array (
								'heading' => esc_html__( 'Event Category', 'fevr' ),
								'param_name' => 'ga_event_category',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Action', 'fevr' ),
								'param_name' => 'ga_event_action',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Label', 'fevr' ),
								'param_name' => 'ga_event_label',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Value', 'fevr' ),
								'param_name' => 'ga_event_value',
								'type' => 'number',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
				),
				'js_view' => 'VcColumnView'
		) );

		// Row settings
		vc_map ( array (
				'name' => __( 'Row', 'js_composer' ),
				'base' => 'vc_row',
				'is_container' => true,
				'icon' => 'icon-wpb-row',
				'html_template' => LUVTHEMES_CORE_PATH . 'includes/vc/vc_row.php',
				'show_settings_on_create' => false,
				'category' => esc_html__( 'Content', 'js_composer' ),
				'description' => __( 'Place content elements inside the row', 'js_composer' ),
				'params' => array (
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Row stretch', 'js_composer' ),
								'param_name' => 'full_width',
								'value' => array (
										esc_html__( 'Default', 'js_composer' ) => '',
										esc_html__( 'Stretch row', 'js_composer' ) => 'stretch_row',
										esc_html__( 'Stretch row and content', 'js_composer' ) => 'stretch_row_content',
										esc_html__( 'Stretch row and content (no paddings)', 'js_composer' ) => 'stretch_row_content_no_spaces'
								),
								'description' => __( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'js_composer' )
						),
						array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Columns gap', 'js_composer' ),
								'param_name' => 'gap',
								'value' => array(
										'0px' => '0',
										'1px' => '1',
										'2px' => '2',
										'3px' => '3',
										'4px' => '4',
										'5px' => '5',
										'10px' => '10',
										'15px' => '15',
										'20px' => '20',
										'25px' => '25',
										'30px' => '30',
										'35px' => '35',
								),
								'std' => '0',
								'description' => __( 'Select gap between columns in row.', 'js_composer' ),
						),
						array (
								'type' => 'checkbox',
								'heading' => esc_html__( 'Full height row?', 'js_composer' ),
								'param_name' => 'full_height',
								'description' => __( 'If checked row will be set to full height.', 'js_composer' ),
								'value' => array (
										esc_html__( 'Yes', 'js_composer' ) => 'yes'
								)
						),
						array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Columns position', 'js_composer' ),
								'param_name' => 'columns_placement',
								'value' => array(
										esc_html__( 'Middle', 'js_composer' ) => 'middle',
										esc_html__( 'Top', 'js_composer' ) => 'top',
										esc_html__( 'Bottom', 'js_composer' ) => 'bottom',
										esc_html__( 'Stretch', 'js_composer' ) => 'stretch',
								),
								'description' => __( 'Select columns position within row.', 'js_composer' ),
								'dependency' => array(
										'element' => 'full_height',
										'not_empty' => true,
								),
						),
						array(
								'type' => 'checkbox',
								'heading' => esc_html__( 'Equal height', 'js_composer' ),
								'param_name' => 'equal_height',
								'description' => __( 'If checked columns will be set to equal height.', 'js_composer' ),
								'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' )
						),
						array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Content position', 'js_composer' ),
								'param_name' => 'content_placement',
								'value' => array(
										esc_html__( 'Default', 'js_composer' ) => '',
										esc_html__( 'Top', 'js_composer' ) => 'top',
										esc_html__( 'Middle', 'js_composer' ) => 'middle',
										esc_html__( 'Bottom', 'js_composer' ) => 'bottom',
								),
								'description' => __( 'Select content position within columns.', 'js_composer' ),
						),
						array (
								'type' => 'checkbox',
								'heading' => esc_html__( 'Use video background?', 'js_composer' ),
								'param_name' => 'video_bg',
								'description' => __( 'If checked, video will be used as row background.', 'js_composer' ),
								'value' => array (
										esc_html__( 'Yes', 'js_composer' ) => 'yes'
								)
						),
						array (
								'type' => 'attach_media',
								'heading' => esc_html__( 'Media file', 'fevr' ),
								'param_name' => 'media_bg_url',
								'description' => __( 'Add MP4 video.', 'fevr' ),
								'dependency' => array (
										'element' => 'video_bg',
										'not_empty' => true
								)
						),
						array (
								'type' => 'attach_media',
								'heading' => esc_html__( 'Media file', 'fevr' ),
								'param_name' => 'media_bg_url_ogv',
								'description' => __( 'Add OGV video.', 'fevr' ),
								'dependency' => array (
										'element' => 'video_bg',
										'not_empty' => true
								)
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'YouTube link', 'js_composer' ),
								'param_name' => 'video_bg_url',
								'description' => __( 'Add YouTube link.', 'js_composer' ),
								'dependency' => array (
										'element' => 'video_bg',
										'not_empty' => true
								)
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Parallax', 'js_composer' ),
								'param_name' => 'video_bg_parallax',
								'value' => array (
										esc_html__( 'None', 'js_composer' ) => '',
										esc_html__( 'Simple', 'js_composer' ) => 'content-moving',
										esc_html__( 'With fade', 'js_composer' ) => 'content-moving-fade'
								),
								'description' => __( 'Add parallax type background for row.', 'js_composer' ),
								'dependency' => array (
										'element' => 'video_bg',
										'not_empty' => true
								)
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Parallax', 'js_composer' ),
								'param_name' => 'parallax',
								'value' => array (
										esc_html__( 'None', 'js_composer' ) => '',
										esc_html__( 'Simple', 'js_composer' ) => 'content-moving',
										esc_html__( 'With fade', 'js_composer' ) => 'content-moving-fade'
								),
								'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'js_composer' ),
								'dependency' => array (
										'element' => 'video_bg',
										'is_empty' => true
								)
						),
						array (
								'type' => 'attach_image',
								'heading' => esc_html__( 'Image', 'js_composer' ),
								'param_name' => 'parallax_image',
								'value' => '',
								'description' => __( 'Select image from media library.', 'js_composer' ),
								'dependency' => array (
										'element' => 'parallax',
										'not_empty' => true
								)
						),
						array (
								'type' => 'el_id',
								'heading' => esc_html__( 'Row ID', 'js_composer' ),
								'param_name' => 'el_id',
								'description' => sprintf ( esc_html__( 'Enter row ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'js_composer' ), '<a href="http://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr' ),
								"std" => ''
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Header skin', 'fevr' ),
								'param_name' => 'header_skin',
								'description' => __( 'Header skin operates in case of a transparent header. This setting can be overwritten separately on each page.', 'fevr' ),
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Dark', 'fevr') => 'dark',
										esc_html__('Light', 'fevr') => 'light',
								)
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text alignment', 'fevr' ),
								'param_name' => 'luv_text_alignment',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Inherit') => '',
										esc_html__('Left', 'fevr') => 'left',
										esc_html__('Center', 'fevr') => 'center',
										esc_html__('Right', 'fevr') => 'right',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation', 'fevr' ),
								'param_name' => 'luv_background_animation',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Left to Right', 'fevr') => 'left-to-right',
										esc_html__('Right to left', 'fevr') => 'right-to-left',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation speed', 'fevr' ),
								'param_name' => 'luv_background_animation_speed',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Slow', 'fevr') => 'luv-bg-animation-slow',
										esc_html__('Normal', 'fevr') => 'luv-bg-animation-normal',
										esc_html__('Fast', 'fevr') => 'luv-bg-animation-fast'
								),
								'std' => 'luv-bg-animation-normal',
								'dependency' => array('element' => 'luv_background_animation', 'not_empty' => true),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'textarea',
								'heading' => esc_html__( 'Custom CSS', 'fevr' ),
								'param_name' => 'luv_custom_css',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'description' => __('Custom CSS for this row', 'fevr'),
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the row', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for the row, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								"dependency" 	=> array("element" => "font_size", "not_empty" => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height for the row, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the row', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'description' => __( 'Font color for the row', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'description' => __( 'Link color for the row', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Expandable Row', 'fevr' ),
								'param_name' => 'luv_expandable_row',
								'std' => 'false',
								'group' => esc_html__( 'Extra', 'fevr' )
						),
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Initial height', 'fevr' ),
								'param_name' => 'luv_expandable_row_height',
								'std' => '100',
								'group' => esc_html__( 'Extra', 'fevr' ),
								'description' => __( 'Initial height for expandable row (px)', 'fevr' ),
								'dependency' => array('element' => 'luv_expandable_row',  'value' => array('true')),
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Gradient Color', 'fevr' ),
								'param_name' => 'luv_expandable_row_color',
								'description' => __( 'Gradient color for expandable row', 'fevr' ),
								'group' => esc_html__( 'Extra', 'fevr' ),
								'std' => _get_luvoption('body-background-color'),
								'dependency' => array('element' => 'luv_expandable_row',  'value' => array('true')),
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Exit popup', 'fevr' ),
								'param_name' => 'exit_popup',
								'std' => 'false',
								'description' => __( 'Use this row as exit popup', 'fevr' ),
								'group' => esc_html__( 'Extra', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Welcome popup', 'fevr' ),
								'param_name' => 'welcome_popup',
								'std' => 'false',
								'description' => __( 'Use this row as welcome popup', 'fevr' ),
								'group' => esc_html__( 'Extra', 'fevr' )
						),
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Welcome popup delay', 'fevr' ),
								'param_name' => 'welcome_popup_delay',
								'description' => __( 'Set delay for welcome popup (seconds)', 'fevr' ),
								'group' => esc_html__( 'Extra', 'fevr' ),
								'dependency' => array('element' => 'welcome_popup',  'value' => array('true')),
								'std' => '0'
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Google Analytics InView', 'fevr' ),
								'param_name' => 'ga_inview',
								'std' => 'false',
								'description' => __( 'Send an event to Google Analytics when element is in viewport', 'fevr' ),
								'group' => esc_html__( 'Tracking', 'fevr' )
						),
						array (
								'heading' => esc_html__( 'Event Category', 'fevr' ),
								'param_name' => 'ga_event_category',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Action', 'fevr' ),
								'param_name' => 'ga_event_action',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Label', 'fevr' ),
								'param_name' => 'ga_event_label',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Value', 'fevr' ),
								'param_name' => 'ga_event_value',
								'type' => 'number',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Column Spacing', 'fevr' ),
								'param_name' => 'luv_has_column_margin',
								'std' => 'false',
								'description' => __( 'Extra spacing between columns on small devices', 'fevr' ),
								'group' => esc_html__( 'Responsive Options', 'js_composer' )
						),
						array (
								'heading' => esc_html__( 'Margin', 'fevr' ),
								'param_name' => 'luv_column_margin',
								'type' => 'number',
								'dependency' => array('element' => 'luv_has_column_margin', 'value' => array('true')),
								'description' => __( 'You can specify some extra spacing between columns (px)', 'fevr' ),
								'group' => esc_html__( 'Responsive Options', 'js_composer' )
						),
				),
				'js_view' => 'VcRowView'
		) );

		// Inner Row Settings
		vc_map ( array (
				'name' => __( 'Inner Row', 'js_composer' ), // Inner Row
				'base' => 'vc_row_inner',
				'content_element' => false,
				'is_container' => true,
				'icon' => 'icon-wpb-row',
				'html_template' => LUVTHEMES_CORE_PATH . 'includes/vc/vc_row_inner.php',
				'weight' => 1000,
				'show_settings_on_create' => false,
				'description' => __( 'Place content elements inside the inner row', 'js_composer' ),
				'params' => array (
						array (
								'type' => 'el_id',
								'heading' => esc_html__( 'Row ID', 'js_composer' ),
								'param_name' => 'el_id',
								'description' => sprintf ( esc_html__( 'Enter optional row ID. Make sure it is unique, and it is valid as w3c specification: %s (Must not have spaces)', 'js_composer' ), '<a target="_blank" href="http://www.w3schools.com/tags/att_global_id.asp">' . esc_html__( 'link', 'js_composer' ) . '</a>' )
						),
						array(
								'type' => 'checkbox',
								'heading' => esc_html__( 'Equal height', 'js_composer' ),
								'param_name' => 'equal_height',
								'description' => __( 'If checked columns will be set to equal height.', 'js_composer' ),
								'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' )
						),
						array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Content position', 'js_composer' ),
								'param_name' => 'content_placement',
								'value' => array(
										esc_html__( 'Default', 'js_composer' ) => '',
										esc_html__( 'Top', 'js_composer' ) => 'top',
										esc_html__( 'Middle', 'js_composer' ) => 'middle',
										esc_html__( 'Bottom', 'js_composer' ) => 'bottom',
								),
								'description' => __( 'Select content position within columns.', 'js_composer' ),
						),
						array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Columns gap', 'js_composer' ),
								'param_name' => 'gap',
								'value' => array(
										'0px' => '0',
										'1px' => '1',
										'2px' => '2',
										'3px' => '3',
										'4px' => '4',
										'5px' => '5',
										'10px' => '10',
										'15px' => '15',
										'20px' => '20',
										'25px' => '25',
										'30px' => '30',
										'35px' => '35',
								),
								'std' => '0',
								'description' => __( 'Select gap between columns in row.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr' ),
								"std" => ''
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Header skin', 'fevr' ),
								'param_name' => 'header_skin',
								'description' => __( 'Header skin operates in case of a transparent header. This setting can be overwritten separately on each page.', 'fevr' ),
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Dark', 'fevr') => 'dark',
										esc_html__('Light', 'fevr') => 'light',
								)
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
												array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text alignment', 'fevr' ),
								'param_name' => 'luv_text_alignment',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Inherit') => '',
										esc_html__('Left', 'fevr') => 'left',
										esc_html__('Center', 'fevr') => 'center',
										esc_html__('Right', 'fevr') => 'right',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation', 'fevr' ),
								'param_name' => 'luv_background_animation',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Left to Right', 'fevr') => 'left-to-right',
										esc_html__('Right to left', 'fevr') => 'right-to-left',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation speed', 'fevr' ),
								'param_name' => 'luv_background_animation_speed',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Slow', 'fevr') => 'luv-bg-animation-slow',
										esc_html__('Normal', 'fevr') => 'luv-bg-animation-normal',
										esc_html__('Fast', 'fevr') => 'luv-bg-animation-fast'
								),
								'std' => 'luv-bg-animation-normal',
								'dependency' => array('element' => 'luv_background_animation', 'not_empty' => true),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'textarea',
								'heading' => esc_html__( 'Custom CSS', 'fevr' ),
								'param_name' => 'luv_custom_css',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'description' => __('Custom CSS for this row', 'fevr'),
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the row', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for the row, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								"dependency" 	=> array("element" => "font_size", "not_empty" => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height for the row, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the row', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'description' => __( 'Font color for the row', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'description' => __( 'Link color for the row', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Expandable Row', 'fevr' ),
								'param_name' => 'luv_expandable_row',
								'std' => 'false',
								'group' => esc_html__( 'Extra', 'fevr' )
						),
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Initial height', 'fevr' ),
								'param_name' => 'luv_expandable_row_height',
								'std' => '100',
								'group' => esc_html__( 'Extra', 'fevr' ),
								'description' => __( 'Initial height for expandable row (px)', 'fevr' ),
								'dependency' => array('element' => 'luv_expandable_row',  'value' => array('true')),
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Gradient Color', 'fevr' ),
								'param_name' => 'luv_expandable_row_color',
								'description' => __( 'Gradient color for expandable row', 'fevr' ),
								'group' => esc_html__( 'Extra', 'fevr' ),
								'std' => _get_luvoption('body-background-color'),
								'dependency' => array('element' => 'luv_expandable_row',  'value' => array('true')),
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Google Analytics InView', 'fevr' ),
								'param_name' => 'ga_inview',
								'std' => 'false',
								'description' => __( 'Send an event to Google Analytics when element is in viewport', 'fevr' ),
								'group' => esc_html__( 'Tracking', 'fevr' )
						),
						array (
								'heading' => esc_html__( 'Event Category', 'fevr' ),
								'param_name' => 'ga_event_category',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Action', 'fevr' ),
								'param_name' => 'ga_event_action',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Label', 'fevr' ),
								'param_name' => 'ga_event_label',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Value', 'fevr' ),
								'param_name' => 'ga_event_value',
								'type' => 'number',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Column Spacing', 'fevr' ),
								'param_name' => 'luv_has_column_margin',
								'std' => 'false',
								'description' => __( 'Extra spacing between columns on small devices', 'fevr' ),
								'group' => esc_html__( 'Responsive Options', 'js_composer' )
						),
						array (
								'heading' => esc_html__( 'Margin', 'fevr' ),
								'param_name' => 'luv_column_margin',
								'type' => 'number',
								'dependency' => array('element' => 'luv_has_column_margin', 'value' => array('true')),
								'description' => __( 'You can specify some extra spacing between columns (px)', 'fevr' ),
								'group' => esc_html__( 'Responsive Options', 'js_composer' )
						),
				),
				'js_view' => 'VcRowView'
		) );


		// Text Block Settings
		vc_map ( array (
				'name' => __( 'Text Block', 'js_composer' ),
				'base' => 'vc_column_text',
				'icon' => 'icon-wpb-layer-shape-text',
				'html_template' => LUVTHEMES_CORE_PATH . 'includes/vc/vc_column_text.php',
				'wrapper_class' => 'clearfix',
				'category' => esc_html__( 'Content', 'js_composer' ),
				'description' => __( 'A block of text with WYSIWYG editor', 'js_composer' ),
				'params' => array (
						array (
								'type' => 'textarea_html',
								'holder' => 'div',
								'heading' => esc_html__( 'Text', 'js_composer' ),
								'param_name' => 'content',
								'value' => _luv_kses(__( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' ))
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr' ),
								'std' => '',
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' )
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation', 'fevr' ),
								'param_name' => 'luv_background_animation',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Left to Right', 'fevr') => 'left-to-right',
										esc_html__('Right to left', 'fevr') => 'right-to-left',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'fevr' ),
								'param_name' => 'luv_columns',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'std' => '',
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Background animation speed', 'fevr' ),
								'param_name' => 'luv_background_animation_speed',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Slow', 'fevr') => 'luv-bg-animation-slow',
										esc_html__('Normal', 'fevr') => 'luv-bg-animation-normal',
										esc_html__('Fast', 'fevr') => 'luv-bg-animation-fast'
								),
								'std' => 'luv-bg-animation-normal',
								'dependency' => array('element' => 'luv_background_animation', 'not_empty' => true),
								'edit_field_class' => 'vc_col-xs-12 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'textarea',
								'heading' => esc_html__( 'Custom CSS', 'fevr' ),
								'param_name' => 'luv_custom_css',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'description' => __('Custom CSS for this text block', 'fevr'),
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'js_composer' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the text block', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for the text block, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								"dependency" 	=> array("element" => "font_size", "not_empty" => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height for the text block, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the text block', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'description' => __( 'Font color for the text block', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'description' => __( 'Link color for the text block', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Tooltip', 'fevr' ),
								'param_name' => 'tooltip',
								'std' => 'false',
								'description' => __( 'Set a tooltip for the text block', 'fevr' ),
								'group' => esc_html__( 'Tooltip', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Tooltip text', 'fevr' ),
								'param_name' => 'tooltip_text',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array(
										'element' => 'tooltip',
										'value' => 'true'
								)
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'tooltip_color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array(
										'element' => 'tooltip',
										'value' => 'true'
								)
						),
						array (
								'heading' => esc_html__( 'Text Color', 'fevr' ),
								'param_name' => 'tooltip_color',
								'type' => 'colorpicker',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array (
										'element' => 'tooltip_color_scheme',
										'value' => array('custom-color')
								)
						),
						array (
								'heading' => esc_html__( 'Background Color', 'fevr' ),
								'param_name' => 'tooltip_background_color',
								'type' => 'colorpicker',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array (
										'element' => 'tooltip_color_scheme',
										'value' => array('custom-color')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Google Analytics InView', 'fevr' ),
								'param_name' => 'ga_inview',
								'std' => 'false',
								'description' => __( 'Send an event to Google Analytics when element is in viewport', 'fevr' ),
								'group' => esc_html__( 'Tracking', 'fevr' )
						),
						array (
								'heading' => esc_html__( 'Event Category', 'fevr' ),
								'param_name' => 'ga_event_category',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Action', 'fevr' ),
								'param_name' => 'ga_event_action',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Label', 'fevr' ),
								'param_name' => 'ga_event_label',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Value', 'fevr' ),
								'param_name' => 'ga_event_value',
								'type' => 'number',
								'dependency' => array('element' => 'ga_inview', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
				)
		) );


		// Single Image Shortcode
		vc_map(array(
			'name' => __( 'Single Image', 'js_composer' ),
			'base' => 'vc_single_image',
			'html_template' => LUVTHEMES_CORE_PATH . 'includes/vc/vc_single_image.php',
			'icon' => 'icon-wpb-single-image',
			'category' => esc_html__( 'Content', 'js_composer' ),
			'description' => __( 'Simple image with CSS animation', 'js_composer' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'js_composer' ),
					'param_name' => 'title',
					'description' => __( 'Enter text used as widget title (Note: located above content element).', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image source', 'js_composer' ),
					'param_name' => 'source',
					'value' => array(
						esc_html__( 'Media library', 'js_composer' ) => 'media_library',
						esc_html__( 'External link', 'js_composer' ) => 'external_link',
						esc_html__( 'Featured Image', 'js_composer' ) => 'featured_image',
					),
					'std' => 'media_library',
					'description' => __( 'Select image source.', 'js_composer' ),
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'js_composer' ),
					'param_name' => 'image',
					'value' => '',
					'description' => __( 'Select image from media library.', 'js_composer' ),
					'dependency' => array(
						'element' => 'source',
						'value' => 'media_library',
					),
					'admin_label' => true
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'External link', 'js_composer' ),
					'param_name' => 'custom_src',
					'description' => __( 'Select external link.', 'js_composer' ),
					'dependency' => array(
						'element' => 'source',
						'value' => 'external_link',
					),
					'admin_label' => true
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image size', 'js_composer' ),
					'param_name' => 'img_size',
					'value' => $this->intermediate_image_sizes,
					'dependency' => array(
						'element' => 'source',
						'value' => array( 'media_library', 'featured_image' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'js_composer' ),
					'param_name' => 'external_img_size',
					'value' => '',
					'description' => __( 'Enter image size in pixels. Example: 200x100 (Width x Height).', 'js_composer' ),
					'dependency' => array(
						'element' => 'source',
						'value' => 'external_link',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Caption', 'js_composer' ),
					'param_name' => 'caption',
					'description' => __( 'Enter text for image caption.', 'js_composer' ),
					'dependency' => array(
						'element' => 'source',
						'value' => 'external_link',
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add caption?', 'js_composer' ),
					'param_name' => 'add_caption',
					'description' => __( 'Add image caption.', 'js_composer' ),
					'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' ),
					'dependency' => array(
						'element' => 'source',
						'value' => array( 'media_library', 'featured_image' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image alignment', 'js_composer' ),
					'param_name' => 'alignment',
					'value' => array(
						esc_html__( 'Left', 'js_composer' ) => 'left',
						esc_html__( 'Right', 'js_composer' ) => 'right',
						esc_html__( 'Center', 'js_composer' ) => 'center',
					),
					'description' => __( 'Select image alignment.', 'js_composer' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image style', 'js_composer' ),
					'param_name' => 'style',
					'value' => getVcShared( 'single image styles' ),
					'description' => __( 'Select image display style.', 'js_comopser' ),
					'dependency' => array(
						'element' => 'source',
						'value' => array( 'media_library', 'featured_image' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image style', 'js_composer' ),
					'param_name' => 'external_style',
					'value' => getVcShared( 'single image external styles' ),
					'description' => __( 'Select image display style.', 'js_comopser' ),
					'dependency' => array(
						'element' => 'source',
						'value' => 'external_link',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Border color', 'js_composer' ),
					'param_name' => 'border_color',
					'value' => getVcShared( 'colors' ),
					'std' => 'grey',
					'dependency' => array(
						'element' => 'style',
						'value' => array(
							'vc_box_border',
							'vc_box_border_circle',
							'vc_box_outline',
							'vc_box_outline_circle',
							'vc_box_border_circle_2',
							'vc_box_outline_circle_2',
						),
					),
					'description' => __( 'Border color.', 'js_composer' ),
					'param_holder_class' => 'vc_colored-dropdown',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Border color', 'js_composer' ),
					'param_name' => 'external_border_color',
					'value' => getVcShared( 'colors' ),
					'std' => 'grey',
					'dependency' => array(
						'element' => 'external_style',
						'value' => array(
							'vc_box_border',
							'vc_box_border_circle',
							'vc_box_outline',
							'vc_box_outline_circle',
						),
					),
					'description' => __( 'Border color.', 'js_composer' ),
					'param_holder_class' => 'vc_colored-dropdown',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'On click action', 'js_composer' ),
					'param_name' => 'onclick',
					'value' => array(
						esc_html__( 'None', 'js_composer' ) => '',
						esc_html__( 'Link to large image', 'js_composer' ) => 'img_link_large',
						esc_html__( 'Open iLightBox', 'fevr' ) => 'luv-lightbox',
						esc_html__( 'Open prettyPhoto', 'js_composer' ) => 'link_image',
						esc_html__( 'Open custom link', 'js_composer' ) => 'custom_link',
						esc_html__( 'Zoom', 'js_composer' ) => 'zoom',
					),
					'description' => __( 'Select action for click action.', 'js_composer' ),
					'std' => '',
				),
				array(
					'type' => 'href',
					'heading' => esc_html__( 'Image link', 'js_composer' ),
					'param_name' => 'link',
					'description' => __( 'Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'js_composer' ),
					'dependency' => array(
						'element' => 'onclick',
						'value' => 'custom_link',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Link Target', 'js_composer' ),
					'param_name' => 'img_link_target',
					'value' => array(
						esc_html__( 'Same window', 'js_composer' ) => '_self',
						esc_html__( 'New window', 'js_composer' ) => '_blank',
					),
					'dependency' => array(
						'element' => 'onclick',
						'value' => array( 'custom_link', 'img_link_large' ),
					),
				),
				array (
						'type' => 'dropdown',
						'heading' => esc_html__( 'Animation', 'fevr' ),
						'param_name' => 'luv_animation',
						'value' => $this->luv_vc_animations,
						'description' => __( 'Animation of the column.', 'fevr'),
						"std" => ''
				),
				array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Floating effect', 'fevr' ),
						'param_name' => 'luv_floating',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'js_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'js_composer' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'js_composer' ),
				),
				// backward compatibility. since 4.6
				array(
					'type' => 'hidden',
					'param_name' => 'img_link_large',
				),
			)
		)
	);

	}

	public function extend_wc_shortcodes() {
		// Skip if WooCommerce isn't activated
		if (!class_exists('WooCommerce')){
			return;
		}

		$order_by_values = array(
				'',
				esc_html__( 'Date', 'js_composer' ) => 'date',
				esc_html__( 'ID', 'js_composer' ) => 'ID',
				esc_html__( 'Author', 'js_composer' ) => 'author',
				esc_html__( 'Title', 'js_composer' ) => 'title',
				esc_html__( 'Modified', 'js_composer' ) => 'modified',
				esc_html__( 'Random', 'js_composer' ) => 'rand',
				esc_html__( 'Comment count', 'js_composer' ) => 'comment_count',
				esc_html__( 'Menu order', 'js_composer' ) => 'menu_order',
		);

		$order_way_values = array(
				'',
				esc_html__( 'Descending', 'js_composer' ) => 'DESC',
				esc_html__( 'Ascending', 'js_composer' ) => 'ASC',
		);

		$pagination = array(
			array(
					'heading'		=> esc_html__('Pagination', 'fevr'),
					'param_name'	=> 'woocommerce_pagination',
					'type'		=> 'dropdown',
					'value'		=> array(
							esc_html__('None', 'fevr') 				=> '',
							esc_html__('Standard Pagination', 'fevr') 	=> 'standard',
							esc_html__('Previous/Next Links', 'fevr') 	=> 'prev-next',
					),
					'admin_label' => true
			),
			array(
					'heading'		=> esc_html__( 'Previous/Next Links Position', 'fevr' ),
					'param_name'	=> 'woocommerce_pagination_position',
					'type'		=> 'dropdown',
					'std'			=> 'under-content',
					'value'	=> array(
							esc_html__('Above Content', 'fevr') 	=> 'above-content',
							esc_html__('Under Content', 'fevr') 	=> 'under-content',
							esc_html__('Both', 'fevr') 			=> 'both',
					),
					'std'  => 'under-content',
					'dependency' => array(
						'element'	=> 'woocommerce_pagination',
						'value' 	=> array('standard', 'prev-next')
					),
			)
		);

		// Recent Products
		vc_map ( array (
				'name' => __( 'Recent products', 'js_composer' ),
				'base' => 'recent_products',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'Lists recent products', 'js_composer' ),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'save_always' => true,
								'param_name' => 'per_page',
								'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Featured Products
		vc_map ( array (
				'name' => __( 'Featured products', 'js_composer' ),
				'base' => 'featured_products',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => _luv_kses(__( 'Display products set as "featured"', 'js_composer' )),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'param_name' => 'per_page',
								'save_always' => true,
								'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Product category
		$args = array(
				'type' => 'post',
				'child_of' => 0,
				'parent' => '',
				'orderby' => 'id',
				'order' => 'ASC',
				'hide_empty' => false,
				'hierarchical' => 1,
				'exclude' => '',
				'include' => '',
				'number' => '',
				'taxonomy' => 'product_cat',
				'pad_counts' => false,

		);
		$categories = get_categories( $args );

		$product_categories_dropdown = array();
		$this->get_category_childs_full( 0, 0, $categories, 0, $product_categories_dropdown );

		vc_map ( array (
				'name' => __( 'Product category', 'js_composer' ),
				'base' => 'product_category',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'Show multiple products in a category', 'js_composer' ),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'save_always' => true,
								'param_name' => 'per_page',
								'description' => __( 'How much items per page to show', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Category', 'js_composer' ),
								'value' => $product_categories_dropdown,
								'param_name' => 'category',
								'save_always' => true,
								'description' => __( 'Product category list', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Products
		vc_map ( array (
				'name' => __( 'Products', 'js_composer' ),
				'base' => 'products',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'Show multiple products by ID or SKU.', 'js_composer' ),
				'params' => array_merge(array (
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'std' => 'title',
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s. Default by Title', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s. Default by ASC', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'autocomplete',
								'heading' => esc_html__( 'Products', 'js_composer' ),
								'param_name' => 'ids',
								'settings' => array (
										'multiple' => true,
										'sortable' => true,
										'unique_values' => true
										// In UI show results except selected. NB! You should manually check values in backend
								),
								'save_always' => true,
								'description' => __( 'Enter List of Products', 'js_composer' )
						),
						array (
								'type' => 'hidden',
								'param_name' => 'skus'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Sale products
		vc_map ( array (
				'name' => __( 'Sale products', 'js_composer' ),
				'base' => 'sale_products',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'List all products on sale', 'js_composer' ),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'save_always' => true,
								'param_name' => 'per_page',
								'description' => __( 'How much items per page to show', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Best selling products
		vc_map ( array (
				'name' => __( 'Best Selling Products', 'js_composer' ),
				'base' => 'best_selling_products',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'List best selling products on sale', 'js_composer' ),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'param_name' => 'per_page',
								'save_always' => true,
								'description' => __( 'How much items per page to show', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Top Rated Products
		vc_map ( array (
				'name' => __( 'Top Rated Products', 'js_composer' ),
				'base' => 'top_rated_products',
				'icon' => 'icon-wpb-woocommerce',
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'List all products on sale', 'js_composer' ),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'param_name' => 'per_page',
								'save_always' => true,
								'description' => __( 'How much items per page to show', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params,
					$pagination
				)
		) );

		// Related products
		/* we need to detect post type to show this shortcode */
		global $post, $typenow, $current_screen;
		$post_type = '';

		if ( $post && $post->post_type ) {
			//we have a post so we can just get the post type from that
			$post_type = $post->post_type;
		} elseif ( $typenow ) {
			//check the global $typenow - set in admin.php
			$post_type = $typenow;
		} elseif ( $current_screen && $current_screen->post_type ) {
			//check the global $current_screen object - set in sceen.php
			$post_type = $current_screen->post_type;

		} elseif ( isset($_REQUEST['post_type'] ) ) {
			//lastly check the post_type querystring
			$post_type = sanitize_key( $_REQUEST['post_type'] );
			//we do not know the post type!
		}

		vc_map ( array (
				'name' => __( 'Related Products', 'js_composer' ),
				'base' => 'related_products',
				'icon' => 'icon-wpb-woocommerce',
				'content_element' => 'product' === $post_type,
				// disable showing if not product type
				'category' => esc_html__( 'WooCommerce', 'js_composer' ),
				'description' => __( 'List related products', 'js_composer' ),
				'params' => array_merge(array (
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Per page', 'js_composer' ),
								'value' => 12,
								'save_always' => true,
								'param_name' => 'per_page',
								'description' => __( 'Please note: the "per_page" shortcode argument will determine how many products are shown on a page. This will not add pagination to the shortcode. ', 'js_composer' )
						),
						array(
								'type' => 'number',
								'heading' => esc_html__( 'Columns', 'js_composer' ),
								'value' => 4,
								'param_name' => 'columns',
								'save_always' => true,
								'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Order by', 'js_composer' ),
								'param_name' => 'orderby',
								'value' => $order_by_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Sort order', 'js_composer' ),
								'param_name' => 'order',
								'value' => $order_way_values,
								'save_always' => true,
								'description' => sprintf ( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'luv_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the column.', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Product Box Style', 'fevr' ),
								'param_name' => 'wc_style',
								'value' => $this->wc_styles,
								'description' => __( 'Override active product box style', 'fevr'),
								"std" => ''
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
								'param_name' => 'wc_gutter',
								'dependency' => array(
										'element' => 'wc_style',
										'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Masonry', 'fevr' ),
								'param_name' => 'wc_masonry',
								'dependency' => array(
									'element' => 'wc_style',
									'value'	=> array('wc-style-3', 'wc-style-6')
								)
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Automatic Metro Layout', 'fevr' ),
								'param_name' => 'wc_masonry_automatic_metro',
								'dependency' => array(
										'element' => 'wc_masonry',
										'value'	=> array('true')
								)
						),
					),
					$this->carousel_params
				)
		) );
	}

	public function get_category_childs_full( $parent_id, $pos, $array, $level, &$dropdown ) {

		for ( $i = $pos; $i < count( $array ); $i ++ ) {
			if ( $array[ $i ]->category_parent == $parent_id ) {
				$name = str_repeat( '- ', $level ) . $array[ $i ]->name;
				$value = $array[ $i ]->slug;
				$dropdown[] = array( 'label' => $name, 'value' => $value );
				$this->get_category_childs_full( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
			}
		}
	}

	/**
	 * Integrate Shortcodes to Visual Composer
	 */
	public function integrate_to_VC(){
		global $vc_params_list;
		// Remove default dropdown to be able to override it
		unset($vc_params_list[array_search('dropdown', $vc_params_list)]);

		// Create custom editor field
		vc_add_shortcode_param('wp_category', array($this, 'create_vc_wp_category'));
		vc_add_shortcode_param('luv_url', array($this, 'create_vc_url'));
		vc_add_shortcode_param('luv_switch', array($this, 'create_vc_switch'));
		vc_add_shortcode_param('number', array($this, 'create_vc_number'));
		vc_add_shortcode_param('luv_design', array($this, 'create_vc_luv_design'));
		vc_add_shortcode_param('posts', array($this, 'create_vc_posts'));
		vc_add_shortcode_param('iconset', array($this, 'create_vc_iconset'));
		vc_add_shortcode_param('luv_icon_select', array($this, 'create_vc_icon_select'));
		vc_add_shortcode_param('key_value', array($this, 'create_key_value'));
		vc_add_shortcode_param('attach_media', array($this, 'create_attach_media'));
		vc_add_shortcode_param('tokenfield', array($this, 'create_vc_tokenfield'));
		vc_add_shortcode_param('luv_font', array($this, 'create_vc_luv_font'));
		vc_add_shortcode_param('luv_font_weight', array($this, 'create_vc_luv_font_weight'));
		vc_add_shortcode_param('dropdown', array($this, 'create_vc_luv_dropdown'));
		vc_add_shortcode_param('luv_radio', array($this, 'create_vc_luv_radio'));
		vc_add_shortcode_param('luv_warning', array($this, 'create_vc_luv_warning'));
		vc_add_shortcode_param('luv_hidden', '__return_false');


		// Map shortcodes
		ksort($this->shortcodes);
		foreach ($this->shortcodes as $shortcode){
			if ($this->is_shortcode_available($shortcode)){
				vc_map($shortcode);
			}
		}

	}

	/**
	 * Init shortcode editors
	 */
	public function init_shortcode_editors(){
		global $fevr_vc_font_family_list;

			// Blog shortcode
			$this->shortcodes['blog'] = array(
				'name'	=>  esc_html__('Blog', 'fevr'),
				'base'	=> 'luv_blog',
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_blog.png',
				'category' => esc_html__( 'Fevr', 'fevr'),
				'description'	=> esc_html__('Blog shortcode', 'fevr'),
				'params' => array_merge(
					array(
						array(
								'heading'		=> esc_html__('List Posts by', 'fevr'),
								'param_name'	=> 'posts_by',
								'type'			=> 'dropdown',
								'save_always'	=> true,
								'value'		=> array(
										esc_html__('Category', 'fevr') => 'category',
										esc_html__('IDs', 'fevr') => 'ids',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Categories', 'fevr'),
								'param_name'	=> 'blog_category',
								'type'			=> 'wp_category',
								'dependency'	=> array('element' => 'posts_by', 'value' => array('category')),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Order', 'fevr'),
								'param_name'	=> 'blog_orderby',
								'type'			=> 'dropdown',
								'value'		=> array(
										esc_html__('Newest first', 'fevr') => 'newest',
										esc_html__('Oldest first', 'fevr') => 'oldest',
										esc_html__('A-Z', 'fevr') => 'a-z',
										esc_html__('Z-A', 'fevr') => 'z-a',
								),
								'dependency' => array('element' => 'posts_by', 'value' => array('category'))
						),
						array (
								'type' => 'autocomplete',
								'heading' => esc_html__( 'Posts', 'fevr' ),
								'param_name' => 'ids',
								'settings' => array (
										'multiple' => true,
										'sortable' => true,
										'unique_values' => true
								),
								'save_always' => true,
								'description' => __( 'Enter List of Posts', 'fevr' ),
								'dependency'  => array('element' => 'posts_by', 'value' => array('ids')),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Style', 'fevr'),
								'param_name'	=> 'blog_layout_style',
								'type'			=> 'dropdown',
								'value'	=> array(
										esc_html__('Standard', 'fevr') 	=> 'standard',
										esc_html__('Masonry', 'fevr')		=> 'masonry',
										esc_html__('Timeline', 'fevr') 	=> 'timeline',
										esc_html__('Alternate', 'fevr') 	=> 'alternate',
										esc_html__('Titles only', 'fevr') 	=> 'titles-only',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Display Featured Image', 'fevr'),
								'param_name'	=> 'blog_display_featured_image',
								'type'			=> 'luv_switch',
								'dependency'	=> array(
										'element' 	=> 'blog_layout_style',
										'value' 	=> array('titles-only')
								),
						),
						array(
								'heading'		=> esc_html__('Columns', 'fevr'),
								'param_name' 	=> 'blog_columns',
								'type'			=> 'dropdown',
								'std'			=> 'two-columns',
								'value'			=> array(
										esc_html__('Two columns', 'fevr') 		=> 'two-columns',
										esc_html__('Three columns', 'fevr') 	=> 'three-columns',
										esc_html__('Four columns', 'fevr') 	=> 'four-columns',
										esc_html__('Viewport based', 'fevr') 	=> 'auto-columns',
								),
								'dependency' 	=> array(
										'element'	=> 'blog_layout_style',
										'value' 	=> array('masonry')
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Masonry Layout', 'fevr'),
								'param_name'	=> 'blog_masonry_layout',
								'type'			=> 'dropdown',
								'value'			=> array(
										esc_html__('Standard', 'fevr') 	=> 'standard',
										esc_html__('Meta Overlay', 'fevr')	=> 'meta-overlay'
								),
								'dependency'	=> array(
										'element'	=> 'blog_layout_style',
										'value'		=> array('masonry')
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Equal Height Columns'),
								'param_name'	=> 'blog_masonry_equal_height',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('standard')
								)
						),
						array(
								'heading'		=> esc_html__('Rounded Corners'),
								'param_name'	=> 'blog_masonry_rounded_corners',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=> 'blog_layout_style',
										'value'		=> array('masonry')
								)
						),
						array(
								'heading'		=> esc_html__('Box Shadow'),
								'param_name'	=> 'blog_masonry_shadows',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=> 'blog_layout_style',
										'value'		=> array('masonry')
								)
						),
						array(
								'heading'		=> esc_html__('Masonry Hover Style', 'fevr'),
								'param_name'	=> 'blog_masonry_hover_style',
								'type'			=> 'dropdown',
								'save_always'	=> true,
								'value'  		=> array(
						                esc_html__('Zoom In', 'fevr' ) => 'masonry-style-zoom',
						                esc_html__('Zoom Out', 'fevr' ) => 'masonry-style-zoom-out',
						                esc_html__('Title from Bottom', 'fevr' ) => 'masonry-style-title-bottom',
						                esc_html__('Title from Left', 'fevr' ) => 'masonry-style-title-left',
						                esc_html__('Solid Border', 'fevr' ) => 'masonry-style-solid',
						                esc_html__('Dark Gradient', 'fevr' ) => 'masonry-style-gradient',
						                esc_html__('Box Shadow', 'fevr' ) => 'masonry-box-shadow',
						                esc_html__('Box Border', 'fevr' ) => 'masonry-box-border',
								    esc_html__('Shine Effect', 'fevr' ) => 'masonry-shine',
								    esc_html__('Color Overlay', 'fevr' ) => 'masonry-color-overlay',
								    esc_html__('Color Overlay with Text', 'fevr' ) => 'masonry-color-overlay-text',
								    esc_html__('Perspective', 'fevr' ) => 'masonry-perspective'
							    ),
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'blog_masonry_overlay_icon',
								'type' => 'iconset',
								'dependency' => array('element' => 'blog_masonry_hover_style', 'value' => array('masonry-color-overlay'))
						),
						array(
								'heading'		=> esc_html__('Masonry Content', 'fevr'),
								'param_name'	=> 'blog_masonry_content',
								'type'			=> 'dropdown',
							    'value' 		=> array(
					                esc_html__('Post Title', 'fevr' ) 				=> 'title',
							        sprintf(esc_html__('Post Title %s Date', 'fevr' ),'&') => 'title-date',
							        sprintf(esc_html__('Post Title %s Category', 'fevr' ),'&') 	=> 'title-category',
							        sprintf(esc_html__('Post Title %s Excerpt', 'fevr' ),'&') 	=> 'title-excerpt'
							    ),
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Automatic Metro Layout', 'fevr'),
								'param_name'	=> 'blog_automatic_metro_layout',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Override Content Alignment', 'fevr'),
								'param_name'	=> 'blog_override_position',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Vertical', 'fevr'),
								'param_name'	=> 'blog_override_vertical_position',
								'type'			=> 'dropdown',
								'dependency'	=> array(
										'element'	=>'blog_override_position',
										'value' 	=> array('true')
								),
								'value'			=> array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Top', 'fevr') => 'vertical-top',
										esc_html__('Middle', 'fevr') => 'vertical-center',
										esc_html__('Bottom', 'fevr') => 'vertical-bottom',
								)
						),
						array(
								'heading'		=> esc_html__('Horizontal', 'fevr'),
								'param_name'	=> 'blog_override_horizontal_position',
								'type'			=> 'dropdown',
								'dependency'	=> array(
										'element'	=>'blog_override_position',
										'value' 	=> array('true')
								),
								'value'			=> array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Left', 'fevr') => 'is-left',
										esc_html__('Center', 'fevr') => 'is-center',
										esc_html__('Right', 'fevr') => 'is-right',
								)
						),
						array(
								'heading'		=> esc_html__('Automatic Title Color', 'fevr'),
								'param_name'	=> 'blog_masonry_auto_text_color',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Item Padding', 'fevr'),
								'param_name'	=> 'blog_item_padding',
								'type'			=> 'textfield',
								'description' => __( 'You can specify extra padding, eg: 5px or 2%', 'fevr' ),
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								)
						),
						array(
								'heading'			=> esc_html__( 'Enable Filter on Masonry Layout', 'fevr' ),
								'param_name'	=> 'blog_masonry_filter',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								)
						),
						array(
								'heading'			=> esc_html__( 'Background Color for Filter', 'fevr' ),
								'param_name'	=> 'blog_masonry_filter_background',
								'type'			=> 'luv_switch',
								'dependency'	=> array(
										'element'	=> 'blog_layout_style',
										'value'		=> array('masonry')
								)
						),
						array(
								'heading'		=> esc_html__( 'Crop Images', 'fevr' ),
								'param_name'	=> 'blog_masonry_crop_images',
								'type'			=> 'luv_switch',
								'dependency'	=> array(
										'element'	=> 'blog_layout_style',
										'value'		=> array('masonry')
								)
						),
						array(
								'heading'		=> esc_html__( 'Show Images in Line', 'fevr' ),
								'param_name'	=> 'blog_alternate_same_column',
								'type'			=> 'luv_switch',
								'dependency'	=> array(
										'element'	=> 'blog_layout_style',
										'value'		=> array('alternate')
								)
						),
						array(
								'heading'		=> esc_html__('Posts per page', 'fevr'),
								'param_name'	=> 'blog_posts_per_page',
								'type'			=> 'number',
								'std'			=> get_option('posts_per_page'),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Pagination', 'fevr'),
								'param_name'	=> 'blog_pagination',
								'type'		=> 'dropdown',
								'value'		=> array(
										esc_html__('None', 'fevr') 				=> '',
										esc_html__('Standard Pagination', 'fevr') 	=> 'standard',
										esc_html__('Previous/Next Links', 'fevr') 	=> 'prev-next',
										esc_html__('Infinite Scroll', 'fevr') 	=> 'infinite-scroll',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__( 'Previous/Next Links Position', 'fevr' ),
								'param_name'	=> 'blog_pagination_position',
								'type'			=> 'dropdown',
								'std'			=> 'under-content',
								'value'	=> array(
										esc_html__('Above Content', 'fevr') 	=> 'above-content',
										esc_html__('Under Content', 'fevr') 	=> 'under-content',
										esc_html__('Both', 'fevr') 			=> 'both',
								),
								'std'  => 'under-content',
								'dependency' => array(
										'element'		=> 'blog_pagination',
										'value' 	=> array('standard', 'prev-next')
								),
						),
						array(
								'heading'		=> esc_html__( 'Excerpt', 'fevr' ),
								'param_name'	=> 'blog_excerpt',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Excerpt Length', 'fevr' ),
								'param_name'	=> 'blog_excerpt_length',
								'type'			=> 'number',
								'description'	=> esc_html__('Number of words to display as excerpt.', 'fevr' ),
								'dependency'	=> array('element' => 'blog_excerpt', 'value' => array('true')),
								'std'			=> 35,

						),
						array(
								'heading'		=> esc_html__( 'Hide Author', 'fevr' ),
								'param_name'		=> 'blog_author_meta',
								'type'		=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Hide Likes', 'fevr' ),
								'param_name'	=> 'blog_likes_meta',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Hide Categories', 'fevr' ),
								'param_name'	=> 'blog_categories_meta',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Hide Date', 'fevr' ),
								'param_name'	=> 'blog_date_meta',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Hide Comments', 'fevr' ),
								'param_name'	=> 'blog_comments_meta',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Animation', 'fevr' ),
								'param_name'	=> 'blog_animation',
								'type'		=> 'dropdown',
								'value'	=> $this->luv_vc_animations,
								'admin_label' => true
						),
						array(
								'heading'			=> esc_html__('Distinct Group', 'fevr'),
								'param_name'	=> 'distinct_group',
								'type'			=> 'textfield',
								'description'	=> esc_html__('You can create distinct groups. Posts won\'t be repeated in the same group', 'fevr')
						),
					),
					$this->carousel_params,
					array(
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'title_font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'admin_label' => true
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'title_font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'title_responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								"dependency" 	=> array("element" => "title_font_size", "not_empty" => true),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text transform', 'fevr' ),
								'param_name' => 'title_text_transform',
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Lowercase', 'fevr') => 'lowercase',
										esc_html__('Uppercase', 'fevr') => 'uppercase',
										esc_html__('Capitalize', 'fevr') => 'capitalize',
										esc_html__('Initial', 'fevr') => 'initial',
								)
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'title_font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'title_font_color',
								'description' => __( 'Font color for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array(
								'heading'		=> sprintf(esc_html__('Override Text %s Accent Colors', 'fevr'),'&'),
								'param_name'	=> 'blog_override_colors',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'blog_masonry_layout',
										'value' 	=> array('meta-overlay')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Accent Color', 'fevr'),
								'param_name'	=> 'blog_override_accent_color',
								'type'			=> 'colorpicker',
								'dependency'	=> array(
										'element'	=>'blog_override_colors',
										'value' 	=> array('true')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Text Color', 'fevr'),
								'param_name'	=> 'blog_override_text_color',
								'type'			=> 'colorpicker',
								'dependency'	=> array(
										'element'	=>'blog_override_colors',
										'value' 	=> array('true')
								),
								'group' => esc_html__('Color', 'fevr')
						),
					)
				)
		);

		// Portfolio Shortcode
		$this->shortcodes['portfolio'] = array(
				'name' => __( 'Portfolio', 'fevr' ),
				'base' => 'luv_portfolio',
				'category' => esc_html__( 'Fevr', 'fevr'),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_portfolio.png',
				'description' => __( 'Portfolio shortcode', 'fevr' ),
				'params' => array_merge(
					array (
						array(
								'heading'		=> esc_html__('List Projects by', 'fevr'),
								'param_name'	=> 'posts_by',
								'type'			=> 'dropdown',
								'save_always'	=> true,
								'value'		=> array(
										esc_html__('Category', 'fevr') => 'category',
										esc_html__('IDs', 'fevr') => 'ids',
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Categories', 'fevr' ),
								'param_name' => 'portfolio_category',
								'type' => 'wp_category',
								'extra' => array('taxonomy' => 'luv_portfolio_categories'),
								'dependency' => array('element' => 'posts_by', 'value' => array('category')),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Order', 'fevr'),
								'param_name'	=> 'portfolio_orderby',
								'type'			=> 'dropdown',
								'value'		=> array(
										esc_html__('Newest first', 'fevr') => 'newest',
										esc_html__('Oldest first', 'fevr') => 'oldest',
										esc_html__('A-Z', 'fevr') => 'a-z',
										esc_html__('Z-A', 'fevr') => 'z-a',
								),
								'dependency' => array('element' => 'posts_by', 'value' => array('category'))
						),
						array (
								'type' => 'autocomplete',
								'heading' => esc_html__( 'Projects', 'fevr' ),
								'param_name' => 'ids',
								'settings' => array (
										'multiple' => true,
										'sortable' => true,
										'unique_values' => true
								),
								'save_always' => true,
								'description' => __( 'Enter List of Projects', 'fevr' ),
								'dependency' => array('element' => 'posts_by', 'value' => array('ids')),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Columns', 'fevr' ),
								'param_name' => 'portfolio_columns',
								'type' => 'dropdown',
								'std' => 'auto-columns',
								'value' => array (
										esc_html__( 'One column', 'fevr' ) => 'one-column',
										esc_html__( 'Two columns', 'fevr' ) => 'two-columns',
										esc_html__( 'Three columns', 'fevr' ) => 'three-columns',
										esc_html__( 'Four columns', 'fevr' ) => 'four-columns',
										esc_html__( 'Viewport based', 'fevr' ) => 'auto-columns'
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Masonry Layout', 'fevr' ),
								'param_name' => 'portfolio_masonry_layout',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Standard', 'fevr' ) => 'standard',
										esc_html__( 'Overlay', 'fevr' ) => 'meta-overlay'
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Rounded Corners'),
								'param_name'	=> 'portfolio_masonry_rounded_corners',
								'type'			=> 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Box Shadow'),
								'param_name'	=> 'portfolio_masonry_shadows',
								'type'			=> 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Item Overlay'),
								'param_name'	=> 'portfolio_item_overlay',
								'type'			=> 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('standard')
								)
						),
						array (
								'heading' => esc_html__( 'Masonry Hover Style', 'fevr' ),
								'param_name' => 'portfolio_masonry_hover_style',
								'type' => 'dropdown',
								'save_always'=> true,
								'value' => array (
										esc_html__( 'Zoom In', 'fevr' ) => 'masonry-style-zoom',
										esc_html__( 'Zoom Out', 'fevr' ) => 'masonry-style-zoom-out',
										esc_html__( 'Title from Bottom', 'fevr' ) => 'masonry-style-title-bottom',
										esc_html__( 'Title from Left', 'fevr' ) => 'masonry-style-title-left',
										esc_html__( 'Solid Border', 'fevr' ) => 'masonry-style-solid',
										esc_html__( 'Dark Gradient', 'fevr' ) => 'masonry-style-gradient',
										esc_html__('Box Shadow', 'fevr' ) => 'masonry-box-shadow',
										esc_html__('Box Border', 'fevr' ) => 'masonry-box-border',
										esc_html__('Shine Effect', 'fevr' ) => 'masonry-shine',
										esc_html__('Color Overlay', 'fevr' ) => 'masonry-color-overlay',
										esc_html__('Color Overlay with Text', 'fevr' ) => 'masonry-color-overlay-text',
										esc_html__('Perspective', 'fevr' ) => 'masonry-perspective'
								),
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'portfolio_masonry_overlay_icon',
								'type' => 'iconset',
								'dependency' => array('element' => 'portfolio_masonry_hover_style', 'value' => array('masonry-color-overlay'))
						),
						array (
								'heading' => esc_html__( 'Masonry Content', 'fevr' ),
								'param_name' => 'portfolio_masonry_content',
								'type' => 'dropdown',
								'value' => array (
									esc_html__( 'Post Title', 'fevr' ) => 'title',
								        sprintf(esc_html__('Post Title %s Date', 'fevr' ),'&') => 'title-date',
								        sprintf(esc_html__('Post Title %s Category', 'fevr' ),'&') 	=> 'title-category',
								        sprintf(esc_html__('Post Title %s Excerpt', 'fevr' ),'&') 	=> 'title-excerpt'
									),
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Automatic Metro Layout', 'fevr'),
								'param_name'		=> 'portfolio_automatic_metro_layout',
								'type'		=> 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								)
						),
						array(
								'heading'		=> sprintf(esc_html__('Override Text %s Accent Colors', 'fevr'),'&'),
								'param_name'		=> 'portfolio_override_colors',
								'type'		=> 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Accent Color', 'fevr'),
								'param_name'		=> 'portfolio_override_accent_color',
								'type'		=> 'colorpicker',
								'dependency'	=> array(
										'element' => 'portfolio_override_colors',
										'value' => array('true')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Text Color', 'fevr'),
								'param_name'		=> 'portfolio_override_text_color',
								'type'		=> 'colorpicker',
								'dependency'	=> array(
										'element' => 'portfolio_override_colors',
										'value' => array('true')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Override Content Alignment', 'fevr'),
								'param_name'	=> 'portfolio_override_position',
								'type'			=> 'luv_switch',
								'dependency' 	=> array(
										'element'	=>'portfolio_masonry_layout',
										'value' 	=> array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Vertical', 'fevr'),
								'param_name'	=> 'portfolio_override_vertical_position',
								'type'			=> 'dropdown',
								'dependency'	=> array(
										'element'	=>'portfolio_override_position',
										'value' 	=> array('true')
								),
								'value'			=> array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Top', 'fevr') => 'vertical-top',
										esc_html__('Middle', 'fevr') => 'vertical-center',
										esc_html__('Bottom', 'fevr') => 'vertical-bottom',
								)
						),
						array(
								'heading'		=> esc_html__('Horizontal', 'fevr'),
								'param_name'	=> 'portfolio_override_horizontal_position',
								'type'			=> 'dropdown',
								'dependency'	=> array(
										'element'	=>'portfolio_override_position',
										'value' 	=> array('true')
								),
								'value'			=> array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Left', 'fevr') => 'is-left',
										esc_html__('Center', 'fevr') => 'is-center',
										esc_html__('Right', 'fevr') => 'is-right',
								)
						),
						array (
								'heading' => esc_html__( 'Automatic Title Color', 'fevr' ),
								'param_name' => 'portfolio_masonry_auto_text_color',
								'type' => 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('meta-overlay')
								)
						),
						array(
								'heading'		=> esc_html__('Item Padding', 'fevr'),
								'param_name'	=> 'portfolio_item_padding',
								'type'			=> 'textfield',
								'description' => __( 'You can specify extra padding, eg: 5px or 2%', 'fevr' ),
						),
						array (
								'heading' => esc_html__( 'Enable Masonry Filter', 'fevr' ),
								'type' => 'luv_switch',
								'param_name' => 'portfolio_masonry_filter',
						),
						array (
								'heading' => esc_html__( 'Background Color for Filter', 'fevr' ),
								'type' => 'luv_switch',
								'param_name' => 'portfolio_masonry_filter_background',
						),
						array (
								'heading' => esc_html__( 'Crop Images', 'fevr' ),
								'type' => 'luv_switch',
								'param_name' => 'portfolio_masonry_crop_images',
						),
						array (
								'heading' => esc_html__( 'Posts per page', 'fevr' ),
								'param_name' => 'portfolio_posts_per_page',
								'type' => 'number',
								'std' => get_option ( 'posts_per_page' ),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Pagination', 'fevr' ),
								'param_name' => 'portfolio_pagination',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'None', 'fevr' ) => '',
										esc_html__( 'Standard Pagination', 'fevr' ) => 'standard',
										esc_html__( 'Previous/Next Links', 'fevr' ) => 'prev-next',
										esc_html__('Infinite Scroll', 'fevr') 	=> 'infinite-scroll',
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Previous/Next Links Position', 'fevr' ),
								'param_name' => 'portfolio_pagination_position',
								'type' => 'dropdown',
								'value' => array (
										esc_html__('Above Content', 'fevr' ) => 'above-content',
										esc_html__('Under Content', 'fevr' ) => 'under-content',
										esc_html__('Both', 'fevr' ) => 'both'
								),
								'std' => 'under-content',
								'dependency' => array (
										'element' => 'portfolio_pagination',
										'value' => array('standard', 'prev-next')
								)
						),
						array (
								'heading' => esc_html__( 'Hide Likes', 'fevr' ),
								'param_name' => 'portfolio_likes_meta',
								'type' => 'luv_switch',
								'dependency' => array (
										'element' => 'portfolio_masonry_layout',
										'value' => array('standard')
								)
						),
						array(
								'heading'		=> esc_html__( 'Animation', 'fevr' ),
								'param_name'		=> 'portfolio_animation',
								'type'		=> 'dropdown',
								'value'	=> $this->luv_vc_animations,
								'admin_label' => true
						),
					),
					$this->carousel_params,
					array(
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'title_font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'admin_label' => true
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'title_font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'title_responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								"dependency" 	=> array("element" => "title_font_size", "not_empty" => true),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text transform', 'fevr' ),
								'param_name' => 'title_text_transform',
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Lowercase', 'fevr') => 'lowercase',
										esc_html__('Uppercase', 'fevr') => 'uppercase',
										esc_html__('Capitalize', 'fevr') => 'capitalize',
										esc_html__('Initial', 'fevr') => 'initial',
								)
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'title_font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'title_font_color',
								'description' => __( 'Font color for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
					)

				)
		);

		// Collection shortcode
		$this->shortcodes['collection'] = array(
				'name'	=>  esc_html__('Collection', 'fevr'),
				'base'	=> 'luv_collection',
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_collections.png',
				'category' => esc_html__( 'WooCommerce', 'fevr'),
				'description'	=> esc_html__('Collection shortcode', 'fevr'),
				'depends' => array('check' => 'class_exists', 'condition' => 'woocommerce'),
				'params' => array_merge(
					array(
						array(
								'heading'		=> esc_html__('Columns', 'fevr'),
								'param_name' 	=> 'woocommerce_collections_columns',
								'type'			=> 'dropdown',
								'std'			=> 'two-columns',
								'value'			=> array(
										esc_html__('Two columns', 'fevr') 		=> 'two-columns',
										esc_html__('Three columns', 'fevr') 	=> 'three-columns',
										esc_html__('Four columns', 'fevr') 	=> 'four-columns',
										esc_html__('Viewport based', 'fevr') 	=> 'auto-columns',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Masonry Hover Style', 'fevr'),
								'param_name'	=> 'woocommerce_collections_masonry_hover_style',
								'type'			=> 'dropdown',
								'save_always'	=> true,
								'value'  		=> array(
										esc_html__('Zoom In', 'fevr' ) => 'masonry-style-zoom',
										esc_html__('Zoom Out', 'fevr' ) => 'masonry-style-zoom-out',
										esc_html__('Title from Bottom', 'fevr' ) => 'masonry-style-title-bottom',
										esc_html__('Title from Left', 'fevr' ) => 'masonry-style-title-left',
										esc_html__('Solid Border', 'fevr' ) => 'masonry-style-solid',
										esc_html__('Dark Gradient', 'fevr' ) => 'masonry-style-gradient',
										esc_html__('Box Shadow', 'fevr' ) => 'masonry-box-shadow',
										esc_html__('Box Border', 'fevr' ) => 'masonry-box-border',
										esc_html__('Shine Effect', 'fevr' ) => 'masonry-shine',
										esc_html__('Color Overlay', 'fevr' ) => 'masonry-color-overlay',
										esc_html__('Color Overlay with Text', 'fevr' ) => 'masonry-color-overlay-text',
								    		esc_html__('Perspective', 'fevr' ) => 'masonry-perspective'
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'woocommerce_collections_masonry_overlay_icon',
								'type' => 'iconset',
								'dependency' => array('element' => 'woocommerce_collections_masonry_hover_style', 'value' => array('masonry-color-overlay'))
						),
						array(
								'heading'		=> sprintf(esc_html__('Override Text %s Accent Colors', 'fevr'),'&'),
								'param_name'	=> 'woocommerce_collections_override_colors',
								'type'			=> 'luv_switch',
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Accent Color', 'fevr'),
								'param_name'	=> 'woocommerce_collections_override_accent_color',
								'type'			=> 'colorpicker',
								'dependency'	=> array(
										'element'	=>'woocommerce_collections_override_colors',
										'value' 	=> array('true')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Text Color', 'fevr'),
								'param_name'	=> 'woocommerce_collections_override_text_color',
								'type'			=> 'colorpicker',
								'dependency'	=> array(
										'element'	=>'woocommerce_collections_override_colors',
										'value' 	=> array('true')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array(
								'heading'		=> esc_html__('Automatic Title Color', 'fevr'),
								'param_name'	=> 'woocommerce_collections_masonry_auto_text_color',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__('Posts per page', 'fevr'),
								'param_name'	=> 'woocommerce_collections_posts_per_page',
								'type'			=> 'number',
								'std'			=> get_option('posts_per_page'),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Order', 'fevr'),
								'param_name'	=> 'woocommerce_collections_orderby',
								'type'			=> 'dropdown',
								'value'		=> array(
										esc_html__('Newest first', 'fevr') => 'newest',
										esc_html__('Oldest first', 'fevr') => 'oldest',
										esc_html__('A-Z', 'fevr') => 'a-z',
										esc_html__('Z-A', 'fevr') => 'z-a',
								)
						),
						array(
								'heading'		=> esc_html__('Pagination', 'fevr'),
								'param_name'	=> 'woocommerce_collections_pagination',
								'type'			=> 'dropdown',
								'value'			=> array(
										esc_html__('None', 'fevr') 				=> '',
										esc_html__('Standard Pagination', 'fevr') 	=> 'standard',
										esc_html__('Previous/Next Links', 'fevr') 	=> 'prev-next',
										esc_html__('Infinite Scroll', 'fevr') 	=> 'infinite-scroll',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__( 'Previous/Next Links Position', 'fevr' ),
								'param_name'	=> 'woocommerce_collections_pagination_position',
								'type'			=> 'dropdown',
								'std'			=> 'under-content',
								'value'	=> array(
										esc_html__('Above Content', 'fevr') 	=> 'above-content',
										esc_html__('Under Content', 'fevr') 	=>	'under-content',
										esc_html__('Both', 'fevr') 			=> 'both',
								),
								'std'  => 'under-content',
								'dependency' => array(
										'element'		=> 'woocommerce_collections_pagination',
										'value' => array('standard', 'prev-next')
								),
						),
						array(
								'heading'		=> esc_html__( 'Animation', 'fevr' ),
								'param_name'	=> 'woocommerce_collections_animation',
								'type'		=> 'dropdown',
								'value'	=> $this->luv_vc_animations,
								'admin_label' => true
						),
						array(
								'heading'			=> esc_html__('Distinct Group', 'fevr'),
								'param_name'	=> 'distinct_group',
								'type'			=> 'textfield',
								'description'	=> esc_html__('You can create distinct groups. Posts won\'t be repeated in the same group', 'fevr')
						),
					),
					$this->carousel_params,
					array(
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'title_font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'title_font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'title_responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								"dependency" 	=> array("element" => "title_font_size", "not_empty" => true),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text transform', 'fevr' ),
								'param_name' => 'title_text_transform',
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Lowercase', 'fevr') => 'lowercase',
										esc_html__('Uppercase', 'fevr') => 'uppercase',
										esc_html__('Capitalize', 'fevr') => 'capitalize',
										esc_html__('Initial', 'fevr') => 'initial',
								)
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'title_font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'title_font_color',
								'description' => __( 'Font color for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
					)
				)
		);

		// Collection shortcode
		$this->shortcodes['reviews'] = array(
				'name'	=>  esc_html__('Photo Reviews', 'fevr'),
				'base'	=> 'luv_reviews',
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_reviews.png',
				'category' => esc_html__( 'WooCommerce', 'fevr'),
				'description'	=> esc_html__('Photo Reviews shortcode', 'fevr'),
				'depends' => array('check' => 'class_exists', 'condition' => 'woocommerce'),
				'params' => array_merge(
					array(
						array(
								'heading'		=> esc_html__('Columns', 'fevr'),
								'param_name' 	=> 'woocommerce_photo_reviews_columns',
								'type'			=> 'dropdown',
								'std'			=> 'two-columns',
								'value'			=> array(
										esc_html__('Two columns', 'fevr') 		=> 'two-columns',
										esc_html__('Three columns', 'fevr') 	=> 'three-columns',
										esc_html__('Four columns', 'fevr') 	=> 'four-columns',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Posts per page', 'fevr'),
								'param_name'	=> 'woocommerce_photo_reviews_posts_per_page',
								'type'			=> 'number',
								'std'			=> get_option('posts_per_page'),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Order', 'fevr'),
								'param_name'	=> 'woocommerce_photo_reviews_orderby',
								'type'			=> 'dropdown',
								'value'		=> array(
										esc_html__('Newest first', 'fevr') => 'newest',
										esc_html__('Oldest first', 'fevr') => 'oldest',
										esc_html__('A-Z', 'fevr') => 'a-z',
										esc_html__('Z-A', 'fevr') => 'z-a',
								)
						),
						array(
								'heading'		=> esc_html__('Pagination', 'fevr'),
								'param_name'	=> 'woocommerce_photo_reviews_pagination',
								'type'			=> 'dropdown',
								'value'			=> array(
										esc_html__('None', 'fevr') 				=> '',
										esc_html__('Standard Pagination', 'fevr') 	=> 'standard',
										esc_html__('Previous/Next Links', 'fevr') 	=> 'prev-next',
										esc_html__('Infinite Scroll', 'fevr') 	=> 'infinite-scroll',
								),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__( 'Previous/Next Links Position', 'fevr' ),
								'param_name'	=> 'woocommerce_photo_reviews_pagination_position',
								'type'			=> 'dropdown',
								'std'			=> 'under-content',
								'value'	=> array(
										esc_html__('Above Content', 'fevr') 	=> 'above-content',
										esc_html__('Under Content', 'fevr') 	=>	'under-content',
										esc_html__('Both', 'fevr') 			=> 'both',
								),
								'std'  => 'under-content',
								'dependency' => array(
										'element'		=> 'woocommerce_photo_reviews_pagination',
										'value' => array('standard', 'prev-next')
								),
						),
						array(
								'heading'		=> esc_html__( 'Hide Rating', 'fevr' ),
								'param_name'	=> 'woocommerce_photo_reviews_rating',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Hide Likes', 'fevr' ),
								'param_name'	=> 'woocommerce_photo_reviews_likes_meta',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Hide Date', 'fevr' ),
								'param_name'	=> 'woocommerce_photo_reviews_date_meta',
								'type'			=> 'luv_switch',
						),
						array(
								'heading'		=> esc_html__( 'Animation', 'fevr' ),
								'param_name'	=> 'woocommerce_photo_reviews_animation',
								'type'			=> 'dropdown',
								'value'			=> $this->luv_vc_animations,
								'admin_label' 	=> true
						),
						array(
								'heading'			=> esc_html__('Distinct Group', 'fevr'),
								'param_name'	=> 'distinct_group',
								'type'			=> 'textfield',
								'description'	=> esc_html__('You can create distinct groups. Posts won\'t be repeated in the same group', 'fevr')
						),
					),
					$this->carousel_params,
					array(
						array (
								'type' 			=> 'luv_font',
								'heading' 		=> esc_html__( 'Font family', 'fevr' ),
								'param_name' 	=> 'title_font_family',
								'value' 		=> $fevr_vc_font_family_list,
								'description' 	=> esc_html__( 'Font family for the column', 'fevr' ),
								'group' 		=> esc_html__( 'Title typography', 'fevr' ),
								'admin_label' 	=> true
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'title_font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'title_responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								"dependency" 	=> array("element" => "title_font_size", "not_empty" => true),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text transform', 'fevr' ),
								'param_name' => 'title_text_transform',
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Lowercase', 'fevr') => 'lowercase',
										esc_html__('Uppercase', 'fevr') => 'uppercase',
										esc_html__('Capitalize', 'fevr') => 'capitalize',
										esc_html__('Initial', 'fevr') => 'initial',
								)
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'title_font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'title_font_color',
								'description' => __( 'Font color for the column', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
					)
				)
		);

		// Before-After Image
		$this->shortcodes['before_after'] = array(
				"name" => esc_html__('Before/After Image', 'fevr'),
				"base" => "luv_before_after",
				"description" => esc_html__( "Before-After Image shortcode", 'fevr'),
				"category" => esc_html__( "Fevr", 'fevr'),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_before_after_image.png',
				"params" => array(
						array (
								'heading' => esc_html__( 'Before', 'fevr' ),
								'param_name' => 'before',
								'type' => 'attach_image',
								'holder' => 'img',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_attach_image vc_wrapper-param-type-attach_image vc_shortcode-param vc_column-with-padding'
						),
						array (
								'heading' => esc_html__( 'After', 'fevr' ),
								'param_name' => 'after',
								'type' => 'attach_image',
								'holder' => 'img',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_attach_image vc_wrapper-param-type-attach_image vc_shortcode-param'
						),
				)
		);

		// Luv editor for slider shortcode
		$this->shortcodes['slider'] = array(
				'base'			=> 'luv_slider',
				'name'			=>  esc_html__('Slider', 'fevr'),
				'icon'			=> LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_slider.png',
				'description'	=> esc_html__('Slider shortcode', 'fevr'),
				'category'		=> 'Fevr',
				'params'		=> array(
						array(
								'heading'		=> esc_html__('Slider', 'fevr'),
								'param_name'	=> 'id',
								'type'			=> 'posts',
								'extra'			=> array('post_type' => 'luv_slider'),
								'admin_label' => true
						),
				)
		);

		// Luv editor for snippet shortcode
		$this->shortcodes['snippet'] = array(
				'base'			=> 'luv_snippet',
				'name'			=>  esc_html__('Snippet', 'fevr'),
				'icon'			=> LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_snippet.png',
				'description'	=> esc_html__('Snippet shortcode', 'fevr'),
				'category'		=> 'Fevr',
				'params'		=> array(
						array(
								'heading'		=> esc_html__('Snippet', 'fevr'),
								'param_name'	=> 'id',
								'type'		=> 'posts',
								'extra'		=> array('post_type' => 'luv_snippets'),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Lazyload', 'fevr'),
								'param_name'	=> 'lazyload',
								'type'		=> 'luv_switch',
						),
				)
		);


		// Editor for carousel shortcode
		$this->shortcodes['carousel'] = array (
				'base' => 'luv_carousel',
				'name' => __( 'Carousel', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_carousel.png',
				'description' => __( 'Carousel shortcode', 'fevr' ),
				'is_container' => true,
				'as_parent' => array (
						'only' => 'luv_carousel_slide'
				),
				'show_settings_on_create' => true,
				'category' => 'Fevr',
				'vc_only' => true,
				'params' => array (
						array (
								'heading' => esc_html__( 'Arrows', 'fevr' ),
								'param_name' => 'nav',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param vc_column-with-padding'
						),
						array (
								'heading' => esc_html__( 'Dots', 'fevr' ),
								'param_name' => 'dots',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Infinite', 'fevr' ),
								'param_name' => 'infinite',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Autoplay', 'fevr' ),
								'param_name' => 'autoplay',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Autoplay timeout', 'fevr' ),
								'param_name' => 'autoplay_timeout',
								'type' => 'number',
								'std' => '5000',
								'extra' => array (
										'min' => 0
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Margin Between Items', 'fevr' ),
								'param_name' => 'margin',
								'save_always' => true,
								'type' => 'number',
								'std' => 10,
								'extra' => array (
										'min' => 0
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Autoplay Pause on Hover', 'fevr' ),
								'param_name' => 'autoplay_pause',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Full height', 'fevr' ),
								'param_name' => 'full_height',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Same height slides', 'fevr' ),
								'param_name' => 'same_height',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Transition type', 'fevr' ),
								'param_name' => 'transition_type',
								'type' => 'dropdown',
								'std' => 'slide',
								'value' => array (
										esc_html__( 'Slide', 'fevr' ) => 'slide',
										esc_html__( 'Fade Out', 'fevr' ) => 'fadeOut',
										esc_html__( 'flipInX', 'fevr' ) => 'flipInX'
								)
						),
						array (
								'heading' => esc_html__( 'Items', 'fevr' ),
								'param_name' => 'items',
								'type' => 'number',
								'std' => 1,
								'extra' => array (
										'min' => 1,
										'responsive' => true
								)
						),
						array (
								'heading' => esc_html__( 'Content alignment', 'fevr' ),
								'param_name' => 'vertical_alignment',
								'type' => 'dropdown',
								'std' => 'slide',
								'value' => array (
										esc_html__( 'Top', 'fevr' ) => 'top',
										esc_html__( 'Middle', 'fevr' ) => 'middle',
										esc_html__( 'Bottom', 'fevr' ) => 'bottom'
								),
								'dependency' => array('element' => 'same_height', 'value'=>array('true')),
						),
				),
				'custom_markup' => '
				<div class="vc_tta-container" data-vc-action="collapse">
					<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
						<div class="vc_tta-tabs-container">'
						. '<ul class="vc_tta-tabs-list">'
							. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
						. '</ul>
						</div>
						<div class="vc_tta-panels vc_clearfix {{container-class}}">
						  {{ content }}
						</div>
					</div>
				</div>',
				'default_content' =>
					'[luv_carousel_slide title="'.esc_html__('Slide', 'fevr').'"][/luv_carousel_slide]' .
					'[luv_carousel_slide title="'.esc_html__('Slide', 'fevr').'"][/luv_carousel_slide]',
				'js_view' => 'LuvCarouselView'
		);

		$this->shortcodes['carousel_slide'] = array (
				'base' => 'luv_carousel_slide',
				'name' => __( 'Carousel slide', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_carousel.png',
				'description' => __( 'Carousel shortcode', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_carousel'
				),
				'is_container' => true,
				'content_element' => false,
				'params' => array(
						array (
							'heading' 		=> esc_html__( 'Title', 'fevr' ),
							'param_name'	=> 'title',
							'type' 			=> 'textfield',
							'std' 			=> 'Slide',
							'admin_label' => true
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text alignment', 'fevr' ),
								'param_name' => 'luv_text_alignment',
								'group' => esc_html__( 'Design Options', 'js_composer' ),
								'value' => array(
										esc_html__('Inherit') => '',
										esc_html__('Left', 'fevr') => 'left',
										esc_html__('Center', 'fevr') => 'center',
										esc_html__('Right', 'fevr') => 'right',
								),
								'std' => '',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
				),
				'custom_markup' => '
				<div class="vc_tta-panel-heading">
				    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
				</div>
				<div class="vc_tta-panel-body">
					{{ editor_controls }}
					<div class="{{ container-class }}">
					{{ content }}
					</div>
				</div>',
				'default_content' => '',
				'js_view' => 'LuvCarouselSlideView',
		);

		// Editor for tab shortcode
		$this->shortcodes['tab'] = array (
				'base' => 'luv_tab',
				'name' => __( 'Tabs', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_tab.png',
				'description' => __( 'Tab shortcode', 'fevr' ),
				'is_container' => true,
				'as_parent' => array (
						'only' => 'luv_tab_inner'
				),
				'show_settings_on_create' => false,
				'category' => 'Fevr',
				'vc_only' => true,
				'params' => array (
						array (
								'heading' => esc_html__( 'Layout', 'fevr' ),
								'param_name' => 'layout',
								'type' => 'dropdown',
								'std' => 'default',
								'value' => array (
										esc_html__( 'Default', 'fevr' ) => 'default',
										esc_html__( 'Center', 'fevr' ) => 'center',
										esc_html__( 'Left', 'fevr' ) => 'left',
										esc_html__( 'Right', 'fevr' ) => 'right'
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						)
				),
				'custom_markup' => '
				<div class="vc_tta-container" data-vc-action="collapse">
					<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
						<div class="vc_tta-tabs-container">'
					                   . '<ul class="vc_tta-tabs-list">'
					                   . '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
					                   . '</ul>
						</div>
						<div class="vc_tta-panels vc_clearfix {{container-class}}">
						  {{ content }}
						</div>
					</div>
				</div>',
				'default_content' =>
				'[luv_tab_inner title="' . esc_html__('Tab 1', 'fevr') . '"][/luv_tab_inner]' .
				'[luv_tab_inner title="' . esc_html__('Tab 2', 'fevr') . '"][/luv_tab_inner]',
				'js_view' => 'LuvTabView'
		);

		$this->shortcodes['tab_inner'] = array (
				'base' => 'luv_tab_inner',
				'name' => __( 'Tab', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_tab.png',
				'description' => __( 'Tab section', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_tab'
				),
				'is_container' => true,
				'content_element' => false,
				'show_settings_on_create' => false,
				'params' => array(
						array (
								'heading' 		=> esc_html__( 'Heading', 'fevr' ),
								'param_name' 	=> 'heading',
								'type' 			=> 'dropdown',
								'value' 		=> array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Icon', 'fevr') => 'icon',
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'dependency' => array('element' => 'heading', 'value' => array('')),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'icon',
								'type' => 'iconset',
								'dependency' => array('element' => 'heading', 'value' => array('icon'))
						),

				),
				'custom_markup' => '
				<div class="vc_tta-panel-heading">
				    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
				</div>
				<div class="vc_tta-panel-body">
					{{ editor_controls }}
					<div class="{{ container-class }}">
					{{ content }}
					</div>
				</div>',
				'default_content' => '',
				'js_view' => 'LuvTabInnerView',
		);

		// Editor for accordion shortcode
		$this->shortcodes['accordion'] = array (
				'base' => 'luv_accordion',
				'name' => __( 'Accordion', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_accordion.png',
				'description' => __( 'Accordion shortcode', 'fevr' ),
				'is_container' => true,
				'as_parent' => array (
						'only' => 'luv_accordion_inner'
				),
				'show_settings_on_create' => false,
				'category' => 'Fevr',
				'vc_only' => true,
				'params' => array (
						array (
							'heading' => esc_html__( 'Color Scheme', 'fevr' ),
							'param_name' => 'color_scheme',
							'type' => 'dropdown',
							'std' => '',
							'value' => array(
									esc_html__('Default', 'fevr') => 'default',
									esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
									esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
									esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
									esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
									esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
									esc_html__('Custom Color', 'fevr') => 'custom-color',

							),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Title font color', 'fevr' ),
							'param_name' => 'title_color',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
							'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Title background color', 'fevr' ),
							'param_name' => 'title_background_color',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Active title font color', 'fevr' ),
							'param_name' => 'active_title_color',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Active title background color', 'fevr' ),
							'param_name' => 'active_title_background_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text font color', 'fevr' ),
							'param_name' => 'text_color',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Text background color', 'fevr' ),
							'param_name' => 'text_background_color',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
								'type' 		=> 'luv_font',
								'heading' 		=> esc_html__( 'Font family', 'fevr' ),
								'param_name' 	=> 'title_font_family',
								'value' 		=> $fevr_vc_font_family_list,
								'description' 	=> esc_html__( 'Font family for the column', 'fevr' ),
								'group' 		=> esc_html__( 'Title typography', 'fevr' ),
								'admin_label' 	=> true
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'title_font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'title_responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Title typography', 'fevr' ),
								"dependency" 	=> array("element" => "title_font_size", "not_empty" => true),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Text transform', 'fevr' ),
								'param_name' => 'title_text_transform',
								'group' => esc_html__( 'Title typography', 'fevr' ),
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Lowercase', 'fevr') => 'lowercase',
										esc_html__('Uppercase', 'fevr') => 'uppercase',
										esc_html__('Capitalize', 'fevr') => 'capitalize',
										esc_html__('Initial', 'fevr') => 'initial',
								)
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'title_font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'description' => __( 'Font style for the column', 'fevr' ),
								"std" => '',
								'group' => esc_html__( 'Title typography', 'fevr' )
						),
						array (
							'heading' => esc_html__( 'Icon', 'fevr' ),
							'param_name' => 'icon',
							'type' => 'iconset'
						),
						array (
								'heading' => esc_html__( 'Active icon', 'fevr' ),
								'param_name' => 'active_icon',
								'type' => 'iconset'
						),
				),
				'custom_markup' => '
				<div class="vc_tta-container" data-vc-action="collapseAll">
					<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
					   <div class="vc_tta-panels vc_clearfix {{container-class}}">
					      {{ content }}
					      <div class="vc_tta-panel vc_tta-section-append">
					         <div class="vc_tta-panel-heading">
					            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
					               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
					                   <span class="vc_tta-title-text">' . esc_html__( 'Add Section', 'js_composer' ) . '</span>
					                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
									</a>
					            </h4>
					         </div>
					      </div>
					   </div>
					</div>
				</div>',
				'default_content' =>
					'[luv_accordion_inner title="' . esc_html__('Section 1', 'fevr') . '"][/luv_accordion_inner]' .
					'[luv_accordion_inner title="' . esc_html__('Section 2', 'fevr') . '"][/luv_accordion_inner]',
				'js_view' => 'LuvAccordionView'
		);

		$this->shortcodes['accordion_inner'] = array (
				'base' => 'luv_accordion_inner',
				'name' => __( 'Accordion section', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_accordion.png',
				'description' => __( 'Accordion section', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_accordion'
				),
				'is_container' => true,
				'content_element' => false,
				'show_settings_on_create' => false,
				'params' => array(
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'holder' => 'h3'
						),
				),
				'custom_markup' => '
				<div class="vc_tta-panel-heading">
				    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
				</div>
				<div class="vc_tta-panel-body">
					{{ editor_controls }}
					<div class="{{ container-class }}">
					{{ content }}
					</div>
				</div>',
				'default_content' => '',
				'js_view' => 'LuvAccordionInnerView',
		);

		// Editor for multiscroll shortcode
		$this->shortcodes['multiscroll'] = array (
				'base' => 'luv_multiscroll',
				'name' => __( 'Multi Scroll', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_multiscroll.png',
				'description' => __( 'Multi Scroll shortcode', 'fevr' ),
				'is_container' => true,
				'as_parent' => array (
						'only' => 'luv_multiscroll_inner'
				),
				'show_settings_on_create' => false,
				'category' => 'Fevr',
				'vc_only' => true,
				'params' => array (),
				'default_content' =>
				'[luv_multiscroll_inner side="left"][/luv_multiscroll_inner]' .
				'[luv_multiscroll_inner side="right"][/luv_multiscroll_inner]',
				'js_view' => 'VcColumnView'
		);

		// Editor for multiscroll inner
		$this->shortcodes['multiscroll_inner'] = array (
				'base' => 'luv_multiscroll_inner',
				'name' => __( 'Multi Scroll inner', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_multiscroll.png',
				'description' => __( 'Multi Scroll Side', 'fevr' ),
				'as_parent' => array (
						'only' => 'luv_multiscroll_section'
				),
				'is_container' => true,
				'content_element' => false,
				'show_settings_on_create' => false,
				'params' => array(
				),
				'js_view' => 'VcColumnView',
		);

		// Editor for multiscroll section
		$this->shortcodes['multiscroll_section'] = array (
				'base' => 'luv_multiscroll_section',
				'name' => __( 'Multi Scroll section', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_multiscroll.png',
				'description' => __( 'Multi Scroll Section', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_multiscroll_inner'
				),
				'as_parent' => array (
						'except' => 'luv_multiscroll'
				),
				'is_container' => true,
				'vc_only' => true,
				'show_settings_on_create' => false,
				'params' => array(
				),
				'js_view' => 'VcColumnView',
		);

		// Editor for testimonials shortcode
		$this->shortcodes['testimonials'] = array (
				'base' => 'luv_testimonials',
				'name' => __( 'Testimonials', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_testimonials.png',
				'description' => __( 'Testimonials shortcode', 'fevr' ),
				'is_container' => true,
				'js_view' => 'VcColumnView',
				'as_parent' => array (
						'only' => 'luv_testimonials_inner'
				),
				'show_settings_on_create' => false,
				'category' => 'Fevr',
				'vc_only' => true,
				'params' => array (
						array(
								'heading'		=> esc_html__('Columns', 'fevr'),
								'param_name'	=> 'columns',
								'type'			=> 'number',
								'extra'			=> array('min' => 1, 'responsive' => true, 'bootstrap' => true),
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Style', 'fevr'),
								'param_name'	=> 'style',
								'type'			=> 'dropdown',
								'value'			=> array(
										esc_html__('Simple', 'fevr') => 'simple',
										esc_html__('Modern', 'fevr') => 'modern',
								),
								'std'			=> 'simple',
								'admin_label' => true
						),
						array(
								'heading'		=> esc_html__('Bubble Arrows', 'fevr'),
								'param_name'	=> 'bubble_arrows',
								'type'			=> 'luv_switch',
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Border radius', 'fevr' ),
								'param_name' => 'border_radius',
								'type' => 'number',
								'std' => '0',
								'extra' => array('min' => 0, 'max' => 50),
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Hover Animation', 'fevr' ),
								'param_name' => 'hover_animation',
								'type' => 'luv_switch',
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Shadow on Hover', 'fevr' ),
								'param_name' => 'shadow_on_hover',
								'type' => 'luv_switch',
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Transparent Items', 'fevr' ),
								'param_name' => 'opacity',
								'type' => 'luv_switch',
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Center Item is Active', 'fevr' ),
								'param_name' => 'center_is_active',
								'description' => __('Only available if the number of the items are odd', 'fevr'),
								'type' => 'luv_switch',
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Hide Faces by Default', 'fevr' ),
								'param_name' => 'hide_faces',
								'description' => __('Enable this option if you would like to show the images only on hover.', 'fevr'),
								'type' => 'luv_switch',
								'dependency'	=> array('element' => 'style', 'value' => 'modern')
						),
						array (
								'heading' => esc_html__( 'Autoplay', 'fevr' ),
								'param_name' => 'autoplay',
								'type' => 'luv_switch',
						),
						array(
								'heading'		=> esc_html__('Autoplay timeout', 'fevr'),
								'param_name'	=> 'autoplay_timeout',
								'type'			=> 'number',
								'std'		=> '5000',
								'extra'			=> array('min' => 0),
								"dependency"	=> array("element" => "autoplay", "value" => array("true")),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr'),
						),
						array (
								'heading' => esc_html__( 'Text color', 'fevr' ),
								'param_name' => 'text_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
						),
						array (
								'heading' => esc_html__( 'Quote color', 'fevr' ),
								'param_name' => 'quote_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
						),
						array (
								'heading' => esc_html__( 'Name color', 'fevr' ),
								'param_name' => 'name_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
						),
						array (
								'heading' => esc_html__( 'Position color', 'fevr' ),
								'param_name' => 'position_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
						),
						array (
								'heading' => esc_html__( 'Background color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
						),
				)
		);

		$this->shortcodes['testimonials_inner'] = array (
				'base' => 'luv_testimonials_inner',
				'name' => __( 'Testimonial', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_testimonials.png',
				'description' => __( 'Testimonial element', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_testimonials'
				),
				'show_settings_on_create' => true,
				'category' => 'Fevr',
				'subtitle' => esc_html__( 'Testimonial Inner', 'fevr' ),
				'params' => array(
						array (
							'heading' => esc_html__( 'Image', 'fevr' ),
							'param_name' => 'image',
							'type' => 'attach_image',
							'holder' => 'img'
						),
						array (
							'heading' => esc_html__( 'Name', 'fevr' ),
							'param_name' => 'name',
							'type' => 'textfield',
							'admin_label' => true
						),
						array (
							'heading' => esc_html__( 'Position', 'fevr' ),
							'param_name' => 'position',
							'type' => 'textfield',
							'admin_label' => true
						),
						array (
							'heading' => esc_html__( 'Content', 'fevr' ),
							'param_name' => 'content',
							'type' => 'textarea_html',
							'admin_label' => true
						),

				)
		);

		// Editor for button shortcode
		$this->shortcodes['button'] = array (
				'base' => 'luv_button',
				'name' => __( 'Button', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_button.png',
				'description' => __( 'Button shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Link URL', 'fevr' ),
								'param_name' => 'href',
								'type' => 'luv_url',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Button text', 'fevr' ),
								'param_name' => 'text',
								'type' => 'textfield',
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param',
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Open link in', 'fevr' ),
								'param_name' => 'target',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'New window', 'fevr' ) => '_blank',
										esc_html__( 'Same window', 'fevr' ) => '_self',
										esc_html__( 'Top window', 'fevr' ) => '_top',
										esc_html__( 'Parent window', 'fevr' ) => '_parent'
								),
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'save_always' => true,
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Size', 'fevr' ),
								'param_name' => 'size',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Normal', 'fevr' ) => '',
										esc_html__( 'S', 'fevr' ) => 'btn-s',
										esc_html__( 'L', 'fevr' ) => 'btn-l',
										esc_html__( 'XL', 'fevr' ) => 'btn-xl',
										esc_html__( 'XXL', 'fevr' ) => 'btn-xxl'
								),
								'admin_label' => true,
								'save_always' => true,
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'icon',
								'type' => 'iconset'
						),
						array (
								'heading' => esc_html__( 'Icon display effect', 'fevr' ),
								'param_name' => 'icon_display_effect',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Icon only', 'fevr') => 'btn-icon-only',
										esc_html__('Default - Left', 'fevr') => 'btn-icon-default-left',
										esc_html__('Default - Right', 'fevr') =>  'btn-icon-default-right',
										esc_html__('Slide - Left', 'fevr') =>  'btn-icon-slide-left',
										esc_html__('Slide - Right', 'fevr') =>  'btn-icon-slide-right',
										esc_html__('Push - Top', 'fevr') =>  'btn-icon-push-top',
										esc_html__('Push - Left', 'fevr') =>  'btn-icon-push-left',
								),
								'dependency' => array('element' => 'icon', 'not_empty' => true),
								'std' => 'btn-icon-default-left',
								'save_always' => true,
						),
						array (
								'heading' => esc_html__( 'Border Style', 'fevr' ),
								'param_name' => 'border_style',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Default', 'fevr' ) => '',
										esc_html__( 'Hand-drawn - Lined - Thick', 'fevr' ) => 'btn-handdrawn lined-thick',
										esc_html__( 'Hand-drawn - Dotted - Thick', 'fevr' ) => 'btn-handdrawn dotted-thick',
										esc_html__( 'Hand-drawn - Dashed - Thick', 'fevr' ) => 'btn-handdrawn dashed-thick',
										esc_html__( 'Hand-drawn - Lined - Thin', 'fevr' ) => 'btn-handdrawn lined-thin',
										esc_html__( 'Hand-drawn - Dotted - Thin', 'fevr' ) => 'btn-handdrawn dotted-thin',
										esc_html__( 'Hand-drawn - Dashed - Thin', 'fevr' ) => 'btn-handdrawn dashed-thin',
								),
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Hover effect', 'fevr' ),
								'param_name' => 'hover_effect',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Fade', 'fevr' ) => '',
										esc_html__( 'Fill - from Top', 'fevr' ) => 'btn-hover-fill-top',
										esc_html__( 'Fill - from Right', 'fevr' ) => 'btn-hover-fill-right',
										esc_html__( 'Fill - from Bottom', 'fevr' ) => 'btn-hover-fill-bottom',
										esc_html__( 'Fill - from Left', 'fevr' ) => 'btn-hover-fill-left',
										esc_html__( 'Expand - Horizontal', 'fevr' ) => 'btn-hover-expand-horizontal',
										esc_html__( 'Expand - Vertical', 'fevr' ) => 'btn-hover-expand-vertical',
										esc_html__( 'Expand - Diagonal', 'fevr' ) => 'btn-hover-expand-diagonal',
								),
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Hover animation', 'fevr' ),
								'param_name' => 'hover_animation',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'None', 'fevr' ) => '',
										esc_html__( 'Bounce', 'fevr' ) => 'bounce',
										esc_html__( 'Shake', 'fevr' ) => 'shake',
										esc_html__( 'Rubber', 'fevr' ) => 'rubberBand',
										esc_html__( 'Swing', 'fevr' ) => 'swing',
										esc_html__( 'Pulse', 'fevr' ) => 'pulse',
										esc_html__( 'Tada', 'fevr' ) => 'tada',
										esc_html__( 'Wobble', 'fevr' ) => 'wobble',
										esc_html__( 'Jello', 'fevr' ) => 'jello',
								),
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( '3D', 'fevr' ),
								'param_name' => 'is_3d',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Only Border', 'fevr' ),
								'param_name' => 'only_border',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Full width', 'fevr' ),
								'param_name' => 'block',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Rounded', 'fevr' ),
								'param_name' => 'is_rounded',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Border radius', 'fevr' ),
								'param_name' => 'border_radius',
								'type' => 'number',
								'std' => '50',
								'extra' => array('min' => 0, 'max' => 50),
								'dependency' => array('element' => 'is_rounded', 'value' => 'true')
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr'),
						),
						array (
								'heading' => esc_html__( 'Text color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Background color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Border color', 'fevr' ),
								'param_name' => 'border_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Hover text color', 'fevr' ),
								'param_name' => 'hover_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Hover background color', 'fevr' ),
								'param_name' => 'hover_background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Hover border color', 'fevr' ),
								'param_name' => 'hover_border_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr'),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Margin', 'fevr' ),
								'param_name' => 'design',
								'type' => 'luv_design',
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Tooltip', 'fevr' ),
								'param_name' => 'tooltip',
								'std' => 'false',
								'description' => __( 'Set a tooltip for the text block', 'fevr' ),
								'group' => esc_html__( 'Tooltip', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Tooltip text', 'fevr' ),
								'param_name' => 'tooltip_text',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array(
										'element' => 'tooltip',
										'value' => 'true'
								)
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'tooltip_color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array(
										'element' => 'tooltip',
										'value' => 'true'
								)
						),
						array (
								'heading' => esc_html__( 'Text Color', 'fevr' ),
								'param_name' => 'tooltip_color',
								'type' => 'colorpicker',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array (
										'element' => 'tooltip_color_scheme',
										'value' => array('custom-color')
								)
						),
						array (
								'heading' => esc_html__( 'Background Color', 'fevr' ),
								'param_name' => 'tooltip_background_color',
								'type' => 'colorpicker',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array (
										'element' => 'tooltip_color_scheme',
										'value' => array('custom-color')
								)
						),
						array (
								'heading' => esc_html__( 'Enable Tracking', 'fevr' ),
								'param_name' => 'ga_tracking',
								'type' => 'luv_switch',
								'description' => 'Enable Google Analytics Event tracking',
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Category', 'fevr' ),
								'param_name' => 'ga_event_category',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Action', 'fevr' ),
								'param_name' => 'ga_event_action',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Label', 'fevr' ),
								'param_name' => 'ga_event_label',
								'type' => 'textfield',
								'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Event Value', 'fevr' ),
								'param_name' => 'ga_event_value',
								'type' => 'number',
								'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
								'group' => esc_html__('Tracking', 'fevr')
						),
				)
		);

		// Pricing table
		$this->shortcodes['pricing_table'] = array (
				'base' => 'luv_pricing_table',
				'name' => __( 'Pricing table', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_pricing_table.png',
				'description' => __( 'Pricing table shortcode', 'fevr' ),
				'is_container' => true,
				'js_view' => 'VcColumnView',
				'as_parent' => array (
						'only' => 'luv_pricing_column'
				),
				'show_settings_on_create' => true,
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Rounded', 'fevr' ),
								'param_name' => 'rounded',
								'type' => 'luv_switch',
						),
						array (
								'heading' => esc_html__( 'Gutter', 'fevr' ),
								'param_name' => 'gutter',
								'type' => 'luv_switch',
						),
						array (
							'heading' => esc_html__( 'Color Scheme', 'fevr' ),
							'param_name' => 'color_scheme',
							'type' => 'dropdown',
							'std' => '',
							'value' => array(
									esc_html__('Light', 'fevr') => 'light',
									esc_html__('Dark', 'fevr') => 'dark',
									esc_html__('Colorful', 'fevr') => 'colorful',
									esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
									esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
									esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
									esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
									esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
									esc_html__('Custom Color', 'fevr') => 'custom-color',

							),
							'std' => 'colorful',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Column background color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Title color', 'fevr' ),
								'param_name' => 'title_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Title background color', 'fevr' ),
								'param_name' => 'title_background_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Price color', 'fevr' ),
								'param_name' => 'price_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Price background color', 'fevr' ),
								'param_name' => 'price_background_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Description color', 'fevr' ),
								'param_name' => 'description_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Description background color', 'fevr' ),
								'param_name' => 'description_background_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Features color', 'fevr' ),
								'param_name' => 'features_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Features background color', 'fevr' ),
								'param_name' => 'features_background_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => array('custom-color')),
								'group' => esc_html__('Color', 'fevr')
						)
				)
		);

		// Editor for pricing table column shortcode
		$this->shortcodes['pricing_table_column'] = array (
				'base' => 'luv_pricing_column',
				'name' => __( 'Pricing table column', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_pricing_table.png',
				'description' => __( 'Pricing table shortcode', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_pricing_column'
				),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Featured', 'fevr' ),
								'param_name' => 'featured',
								'type' => 'luv_switch',
						),
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-8 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param'
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'title_font_family',
								'value' => $fevr_vc_font_family_list,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Currency', 'fevr' ),
								'param_name' => 'currency',
								'type' => 'textfield',
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-8 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param'
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'currency_font_family',
								'value' => $fevr_vc_font_family_list,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Price', 'fevr' ),
								'param_name' => 'price',
								'type' => 'textfield',
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-8 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param'
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'price_font_family',
								'value' => $fevr_vc_font_family_list,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Period', 'fevr' ),
								'param_name' => 'period',
								'type' => 'textfield',
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-8 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param'
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'period_font_family',
								'value' => $fevr_vc_font_family_list,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Description', 'fevr' ),
								'param_name' => 'description',
								'type' => 'textarea',
								'admin_label' => true
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Description font family', 'fevr' ),
								'param_name' => 'description_font_family',
								'value' => $fevr_vc_font_family_list,
						),
						array (
								'heading' => esc_html__( 'Features', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textarea_html',
								'admin_label' => true
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Features font family', 'fevr' ),
								'param_name' => 'features_font_family',
								'value' => $fevr_vc_font_family_list
						)
				)
		);

		// Editor for share shortcode
		$this->shortcodes['share'] = array (
				'base' => 'luv_share',
				'name' => __( 'Share', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_share.png',
				'description' => __( 'Social share shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Channel', 'fevr' ),
								'param_name' => 'channel',
								'type' => 'luv_icon_select',
								'value' => array(
										'fa fa-facebook' => 'facebook',
										'fa fa-twitter' => 'twitter',
										'fa fa-google-plus' => 'google_plus',
										'fa fa-linkedin' => 'linkedin',
										'fa fa-pinterest' => 'pinterest'
								),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Size', 'fevr' ),
								'param_name' => 'size',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Normal', 'fevr' ) => '',
										esc_html__( 'S', 'fevr' ) => 'btn-s',
										esc_html__( 'L', 'fevr' ) => 'btn-l',
										esc_html__( 'XL', 'fevr' ) => 'btn-xl',
										esc_html__( 'XXL', 'fevr' ) => 'btn-xxl'
								)
						),
						array (
								'heading' => esc_html__( 'Icon display style', 'fevr' ),
								'param_name' => 'icon_display_style',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Icon with count', 'fevr') => 'btn-icon-count',
										esc_html__('Icon only', 'fevr') => 'btn-icon-only',
										esc_html__('Default - Left', 'fevr') => 'btn-icon-default-left',
										esc_html__('Default - Right', 'fevr') =>  'btn-icon-default-right',
										esc_html__('Slide - Left', 'fevr') =>  'btn-icon-slide-left',
										esc_html__('Slide - Right', 'fevr') =>  'btn-icon-slide-right',
										esc_html__('Push - Top', 'fevr') =>  'btn-icon-push-top',
										esc_html__('Push - Left', 'fevr') =>  'btn-icon-push-left',
								),
								'save_always' => true,
						),
						array (
								'heading' => esc_html__( 'Button text', 'fevr' ),
								'param_name' => 'text',
								'type' => 'textfield',
								'admin_label' => true,
								'edit_field_class' => 'vc_col-xs-8 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param',
								'dependency' => array('element' => 'icon_display_effect', 'value' => array('btn-icon-default-left','btn-icon-default-right','btn-icon-slide-left','btn-icon-slide-right','btn-icon-push-top','btn-icon-push-left'))
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'dependency' => array('element' => 'icon_display_effect', 'value' => array('btn-icon-default-left','btn-icon-default-right','btn-icon-slide-left','btn-icon-slide-right','btn-icon-push-top','btn-icon-push-left'))
						),
						array (
								'heading' => esc_html__( 'Hover effect', 'fevr' ),
								'param_name' => 'hover_effect',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Fade', 'fevr' ) => '',
										esc_html__( 'Fill - from Top', 'fevr' ) => 'btn-hover-fill-top',
										esc_html__( 'Fill - from Right', 'fevr' ) => 'btn-hover-fill-right',
										esc_html__( 'Fill - from Bottom', 'fevr' ) => 'btn-hover-fill-bottom',
										esc_html__( 'Fill - from Left', 'fevr' ) => 'btn-hover-fill-left',
										esc_html__( 'Expand - Horizontal', 'fevr' ) => 'btn-hover-expand-horizontal',
										esc_html__( 'Expand - Vertical', 'fevr' ) => 'btn-hover-expand-vertical',
										esc_html__( 'Expand - Diagonal', 'fevr' ) => 'btn-hover-expand-diagonal',
								)
						),
						array (
								'heading' => esc_html__( 'Hover animation', 'fevr' ),
								'param_name' => 'hover_animation',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'None', 'fevr' ) => '',
										esc_html__( 'Bounce', 'fevr' ) => 'bounce',
										esc_html__( 'Shake', 'fevr' ) => 'shake',
										esc_html__( 'Rubber', 'fevr' ) => 'rubberBand',
										esc_html__( 'Swing', 'fevr' ) => 'swing',
										esc_html__( 'Pulse', 'fevr' ) => 'pulse',
										esc_html__( 'Tada', 'fevr' ) => 'tada',
										esc_html__( 'Wobble', 'fevr' ) => 'wobble',
										esc_html__( 'Jello', 'fevr' ) => 'jello',
								)
						),
						array (
								'heading' => esc_html__( '3D', 'fevr' ),
								'param_name' => 'is_3d',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Only Border', 'fevr' ),
								'param_name' => 'only_border',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Full width', 'fevr' ),
								'param_name' => 'block',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Rounded', 'fevr' ),
								'param_name' => 'is_rounded',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Border radius', 'fevr' ),
								'param_name' => 'border_radius',
								'type' => 'number',
								'std' => '50',
								'extra' => array('min' => 0, 'max' => 50),
								'dependency' => array('element' => 'is_rounded', 'value' => 'true'),
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Text color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Background color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Border color', 'fevr' ),
								'param_name' => 'border_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Hover text color', 'fevr' ),
								'param_name' => 'hover_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Hover background color', 'fevr' ),
								'param_name' => 'hover_background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Hover border color', 'fevr' ),
								'param_name' => 'hover_border_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Margin', 'fevr' ),
								'param_name' => 'design',
								'type' => 'luv_design'
						),
						array (
							'heading' => esc_html__( 'Enable Tracking', 'fevr' ),
							'param_name' => 'ga_tracking',
							'type' => 'luv_switch',
							'description' => 'Enable Google Analytics Event tracking',
							'group' => esc_html__('Tracking', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Event Category', 'fevr' ),
							'param_name' => 'ga_event_category',
							'type' => 'textfield',
							'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
							'group' => esc_html__('Tracking', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Event Action', 'fevr' ),
							'param_name' => 'ga_event_action',
							'type' => 'textfield',
							'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
							'group' => esc_html__('Tracking', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Event Label', 'fevr' ),
							'param_name' => 'ga_event_label',
							'type' => 'textfield',
							'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
							'group' => esc_html__('Tracking', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Event Value', 'fevr' ),
							'param_name' => 'ga_event_value',
							'type' => 'textfield',
							'dependency' => array('element' => 'ga_tracking', 'value' => array('true')),
							'group' => esc_html__('Tracking', 'fevr')
						),
				)
		);

		// Editor for social sidebar shortcode
		$this->shortcodes['social_sidebar'] = array (
				'base' => 'luv_social_sidebar',
				'name' => __( 'Social Sidebar', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_social_sidebar.png',
				'description' => __( 'Social sidebar shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array(
								'heading'		=> esc_html__('Position', 'fevr'),
								'param_name'	=> 'position',
								'type'			=> 'dropdown',
								'value'			=> array(
										esc_html__('Left', 'fevr')	=> 'left',
										esc_html__('Right', 'fevr')	=> 'right',
								),
								'std'			=> 'left',
								'save_always'	=> true,
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Animation', 'fevr' ),
								'param_name' => 'animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation of the buttons.', 'fevr' ),
								"std" => '',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Filter', 'fevr' ),
								'param_name' => 'filter',
								'value' => array(
										esc_html__('None', 'fevr') => '',
										esc_html__('Grayscale', 'fevr') => 'grayscale',
										esc_html__('Pastel', 'fevr') => 'pastel',
								),
								"std" => '',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( '3D', 'fevr' ),
								'param_name' => 'is_3d',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						),
						array(
								'heading'		=> esc_html__('Facebook', 'fevr'),
								'param_name'	=> 'facebook',
								'type'			=> 'checkbox',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_checkbox vc_wrapper-param-type-checkbox vc_shortcode-param'
						),
						array(
								'heading'		=> esc_html__('Twitter', 'fevr'),
								'param_name'	=> 'twitter',
								'type'			=> 'checkbox',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_checkbox vc_wrapper-param-type-checkbox vc_shortcode-param'
						),
						array(
								'heading'		=> esc_html__('Google+', 'fevr'),
								'param_name'	=> 'google_plus',
								'type'			=> 'checkbox',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_checkbox vc_wrapper-param-type-checkbox vc_shortcode-param'
						),
						array(
								'heading'		=> esc_html__('LinkedIn', 'fevr'),
								'param_name'	=> 'linkedin',
								'type'			=> 'checkbox',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_checkbox vc_wrapper-param-type-checkbox vc_shortcode-param'
						),
						array(
								'heading'		=> esc_html__('Pinterest', 'fevr'),
								'param_name'	=> 'pinterest',
								'type'			=> 'checkbox',
								'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_checkbox vc_wrapper-param-type-checkbox vc_shortcode-param'
						),
				)
			);

		// Counter Shortcode
		$this->shortcodes['counter'] = array (
				'base' => 'luv_counter',
				'name' => __( 'Counter', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_counter.png',
				'description' => __( 'Animated counter shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Type', 'fevr'),
								'param_name' => 'type',
								'value' => array(
										esc_html__('Normal', 'fevr') => 'normal',
										esc_html__('Fade in from top', 'fevr') => 'bounce-from-top',
								),
								'std' => 'normal',
								'save_always' => true,
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Text', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Timeout', 'fevr' ),
								'param_name' => 'timeout',
								'type' => 'number',
								'std' => '5',
								'dependency' => array('element' => 'type', 'value' => 'normal'),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Step', 'fevr' ),
								'param_name' => 'step',
								'type' => 'number',
								'std' => '1',
								'dependency' => array('element' => 'type', 'value' => 'normal'),
								'admin_label' => true
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								"dependency" 	=> array("element" => "font_size", "not_empty" => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								"std" => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'group' => esc_html__( 'Typography', 'fevr' )
						)
				)
		);

		// Countdown Shortcode
		$this->shortcodes['countdown'] = array (
				'base' => 'luv_countdown',
				'name' => __( 'Countdown', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_countdown.png',
				'description' => __( 'Animated countdown shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
					array (
						'type' => 'textfield',
						'heading' => esc_html__( 'Time', 'fevr'),
						'param_name' => 'time',
						'description' => __( 'Set the countdown, eg: 10 September 2020, +1 week, or +5 minutes, etc...', 'fevr' ),
						'admin_label' => true
					),
					array (
						'type' => 'dropdown',
						'heading' => esc_html__( 'Clockface', 'fevr'),
						'param_name' => 'clockface',
						'value' => array(
								esc_html__('Seconds','fevr') => 'second',
								esc_html__('Minutes','fevr') => 'minute',
								esc_html__('Hours','fevr') => 'hour',
								esc_html__('Days','fevr') => 'day',
								esc_html__('Months','fevr') => 'month',
								esc_html__('Years','fevr') => 'year',
						),
						'save_always' => true,
						'admin_label' => true
					),
					array (
							'type' => 'dropdown',
							'heading' => esc_html__( 'Style', 'fevr'),
							'param_name' => 'style',
							'value' => array(
									esc_html__('Default') => '',
									esc_html__('Square') => 'square',
									esc_html__('Rounded') => 'rounded',
									esc_html__('Circle') => 'circle',
									esc_html__('Dotted') => 'dotted',
									esc_html__('Dashed') => 'dashed',
									esc_html__('Underlined') => 'underlined',
									esc_html__('3D') => '3D',
							),
							'std' => '',
							'admin_label' => true
					),
					array (
							'type' => 'dropdown',
							'heading' => esc_html__( 'Animation', 'fevr'),
							'param_name' => 'animation',
							'value' => array(
									esc_html__('None') => '',
									esc_html__('Rubber') => 'rubberBand',
									esc_html__('Pulse') => 'pulse',
									esc_html__('Tada') => 'tada',
									esc_html__('Jello') => 'jello',
							),
							'std' => '',
							'admin_label' => true
					),
					array (
							'type' => 'luv_font',
							'heading' => esc_html__( 'Font family', 'fevr' ),
							'param_name' => 'font_family',
							'value' => $fevr_vc_font_family_list,
							'group' => esc_html__( 'Typography', 'fevr' )
					),
					array (
							'type' => 'textfield',
							'heading' => esc_html__( 'Font size', 'fevr' ),
							'param_name' => 'font_size',
							'description' => __( 'Font size, eg: 24px or 1.3em', 'fevr' ),
							'group' => esc_html__( 'Typography', 'fevr' )
					),
					array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Responsive font size', 'fevr' ),
							'param_name' => 'responsive_font_size',
							'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
							'group' => esc_html__( 'Typography', 'fevr' ),
							'dependency' 	=> array('element' => 'font_size', 'not_empty' => true),
					),
					array (
							'type' => 'textfield',
							'heading' => esc_html__( 'Line height', 'fevr' ),
							'param_name' => 'line_height',
							'description' => __( 'Line height, eg: 24px or 1.3em', 'fevr' ),
							'group' => esc_html__( 'Typography', 'fevr' )
					),
					array (
							'type' => 'luv_font_weight',
							'heading' => esc_html__( 'Font style', 'fevr' ),
							'param_name' => 'font_weight',
							'value' => $this->luv_vc_font_weight_list,
							'std' => '',
							'group' => esc_html__( 'Typography', 'fevr' )
					),
					array (
							'type' => 'colorpicker',
							'heading' => esc_html__( 'Font color', 'fevr' ),
							'param_name' => 'font_color',
							'group' => esc_html__( 'Typography', 'fevr' )
					),
					array (
							'heading' => esc_html__( 'Border color', 'fevr' ),
							'param_name' => 'color',
							'type' => 'colorpicker',
							'group' => esc_html__( 'Typography', 'fevr' )

					),
				)
		);

		// Editor for icon shortcode
		$this->shortcodes['gmap'] = array (
				'base' => 'luv_gmap',
				'name' => __( 'Google Maps', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_map.png',
				'description' => __( 'Google Maps shortcode', 'fevr' ),
				'is_container' => true,
				'js_view' => 'VcColumnView',
				'as_parent' => array (
						'only' => 'luv_gmap_address'
				),
				'show_settings_on_create' => true,
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Google Maps API Key is missing', 'fevr' ),
								'message' => sprintf(esc_html__('Click %shere%s to set an API key', 'fevr' ), '<a href="'.esc_url(add_query_arg(array('page' => 'theme-options', 'tab' => 35),admin_url('admin.php'))).'" target="_blank">', '</a>'),
								'param_name' => 'infobox',
								'type' => (_check_luvoption('google-maps-api-key', '') ? 'luv_warning' : 'luv_hidden')
						),
						array (
								'heading' => esc_html__( 'Width', 'fevr' ),
								'description' => 'Eg: 300px or 100%',
								'param_name' => 'width',
								'type' => 'textfield',
								'std' => '300px',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param vc_column-with-padding',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Height', 'fevr' ),
								'description' => 'Eg: 180px',
								'param_name' => 'height',
								'type' => 'textfield',
								'std' => '180px',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Zoom', 'fevr' ),
								'param_name' => 'zoom',
								'type' => 'number',
								'std' => 12,
								'extra' => array (
										'min' => 1,
										'max' => 21
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Map type', 'fevr' ),
								'param_name' => 'type',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Roadmap', 'fevr' ) => 'roadmap',
										esc_html__( 'Satellite', 'fevr' ) => 'satellite',
										esc_html__( 'Hybrid', 'fevr' ) => 'hybrid',
										esc_html__( 'Terrarin', 'fevr' ) => 'terrarin',
										esc_html__( 'Panorama', 'fevr' ) => 'panorama'
								),
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Marker Animation', 'fevr' ),
								'param_name' => 'marker_animation',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'None', 'fevr' ) => '',
										esc_html__( 'Drop', 'fevr' ) => 'drop',
										esc_html__( 'Bounce', 'fevr' ) => 'bounce'
								),
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'admin_label' => true,
								'save_always' => true,
								'std' => 'drop'
						),
						array (
								'heading' => esc_html__( 'Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Default', 'fevr' ) => '',
										esc_html__( 'Preset', 'fevr' ) => 'preset',
										esc_html__( 'JSON', 'fevr' ) => 'json',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__( 'Custom', 'fevr' ) => 'custom-color'
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param vc_column-with-padding',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Color', 'fevr' ),
								'param_name' => 'hue',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Preset', 'fevr' ),
								'param_name' => 'preset',
								'type' => 'dropdown',
								'save_always' => true,
								'value' => array (
										'Apple Maps Esque' => 'apple-maps-esque',
										'Avocado World' => 'avocado-world',
										'Becomeadinosaur' => 'becomeadinosaur',
										'Black & White' => 'black-white',
										'Blue Essence' => 'blue-essence',
										'Blue Water' => 'blue-water',
										'Cool Grey' => 'cool-grey',
										'Flat Map' => 'flat-map',
										'Greyscale' => 'greyscale',
										'Light Dream' => 'light-dream',
										'Light Monochrome' => 'light-monochrome',
										'MapBox' => 'mapbox',
										'Midnight Commander' => 'midnight-commander',
										'Neutral Blue' => 'neutral-blue',
										'Pale Down' => 'pale-down',
										'Paper' => 'paper',
										'Retro' => 'retro',
										'Shades of Grey' => 'shades-of-grey',
										'Subtle Grayscale' => 'subtle-grayscale',
										'Ultra Light with Labels' => 'ultra-light-with-labels',
										'Unsaturated Browns' => 'unsaturated-browns'
								),
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => 'preset'
								),
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'JSON', 'fevr' ),
								'description' => sprintf(esc_html__('Use exported JSON for map style. See map presets %shere%s', 'fevr'),'<a href="https://snazzymaps.com/" target="_blank">', '</a>'),
								'param_name' => 'json',
								'type' => 'textarea_raw_html',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => 'json'
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Disable UI', 'fevr' ),
								'param_name' => 'disable_ui',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Disable Scroll Wheel', 'fevr' ),
								'param_name' => 'disable_scrollwheel',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
								'heading' => esc_html__( 'Draggable', 'fevr' ),
								'param_name' => 'draggable',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
								'std' => 'true',
								'save_always' => true
						),
						array (
								'heading' => esc_html__( 'Use Clusters', 'fevr' ),
								'param_name' => 'use_clusters',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
				)
		);

		// Editor for Google map address shortcode
		$this->shortcodes['gmap_address'] = array (
				'base' => 'luv_gmap_address',
				'name' => __( 'Google Map Address', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_map.png',
				'description' => __( 'Address for Google Map shortcode', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_gmap_address'
				),
				'category' => 'Fevr',
				'subtitle' => esc_html__( 'Google Maps Inner', 'fevr' ),
				'params' => array (
						array (
								'heading' => esc_html__( 'Address', 'fevr' ),
								'param_name' => 'address',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Pin', 'fevr' ),
								'param_name' => 'image',
								'type' => 'attach_image',
								'holder' => 'img'
						),
						array (
								'heading' => esc_html__( 'Info', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textarea_html',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Open info window on load', 'fevr' ),
								'param_name' => 'open_info_window',
								'type' => 'luv_switch',
						),
				)
		);

		// Editor for animated list shortcode
		$this->shortcodes['animated_list'] = array (
				'base' => 'luv_animated_list',
				'name' => __( 'Animated List', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_animated_list.png',
				'description' => __( 'Animated List shortcode', 'fevr' ),
				'is_container' => true,
				'js_view' => 'VcColumnView',
				'as_parent' => array (
						'only' => 'luv_animated_list_inner'
				),
				'show_settings_on_create' => true,
				'category' => 'Fevr',
				'params' => array (
					array (
							'heading' => esc_html__( 'Icon size', 'fevr' ),
							'param_name' => 'icon_size',
							'type' => 'number',
							'std' => '24'
					),
					array (
							'type' => 'dropdown',
							'heading' => esc_html__( 'Icon Animation', 'fevr' ),
							'param_name' => 'animation',
							'value' => $this->luv_vc_animations,
							'description' => __( 'Animation for the icon.', 'fevr' ),
							"std" => ''
					),
					array (
						'heading' => esc_html__( 'Color Scheme', 'fevr' ),
						'param_name' => 'color_scheme',
						'type' => 'dropdown',
						'std' => '',
						'value' => array(
								esc_html__('Default', 'fevr') => 'default',
								esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
								esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
								esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
								esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
								esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
								esc_html__('Custom Color', 'fevr') => 'custom-color',

						),
						'group' => esc_html__('Color', 'fevr')
					),
					array (
						'heading' => esc_html__( 'Text Color', 'fevr' ),
						'param_name' => 'color',
						'type' => 'colorpicker',
						'dependency' => array (
								'element' => 'color_scheme',
								'value' => array('custom-color')
						),
						'group' => esc_html__('Color', 'fevr')
					),
					array (
						'heading' => esc_html__( 'Icon color', 'fevr' ),
						'param_name' => 'icon_color',
						'type' => 'colorpicker',
						'dependency' => array (
								'element' => 'color_scheme',
								'value' => array('custom-color')
						),
						'group' => esc_html__('Color', 'fevr')
					),
				)
		);

		// Editor for animated list shortcode
		$this->shortcodes['animated_list_inner'] = array (
				'base' => 'luv_animated_list_inner',
				'name' => __( 'Animated List Element', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_animated_list.png',
				'description' => __( 'Element for animated list', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_animated_list'
				),
				'category' => 'Fevr',
				'subtitle' => esc_html__( 'Animated List Inner', 'fevr' ),
				'params' => array (
						array (
							'heading' => esc_html__( 'Content', 'fevr' ),
							'param_name' => 'content',
							'type' => 'textarea',
							'admin_label' => true
						),
						array (
							'heading' => esc_html__( 'Icon', 'fevr' ),
							'param_name' => 'icon',
							'type' => 'iconset',
							'extra' => array (
									'svg' => true
							)
						),
				)
		);

		// Page section editor
		$this->shortcodes['page_section'] = array (
				'base' => 'luv_page_section',
				'name' => __( 'Page Section', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_one_page_section.png',
				'description' => __( 'One Page Section', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'description' => __( 'Title of the section.', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'ID', 'fevr' ),
								'description' => __( 'ID of the section. You can put this link in your navigation menu, eg: #this-is-the-first-section', 'fevr' ),
								'param_name' => 'id',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Node', 'fevr' ),
								'description' => __( 'HTML element node', 'fevr' ),
								'param_name' => 'node',
								'type' => 'dropdown',
								'std' => 'h2',
								'value' => array(
										'H1' => 'h1',
										'H2' => 'h2',
										'H3' => 'h3',
										'H4' => 'h4',
										'H5' => 'h5',
										'H6' => 'h6',
										'DIV' => 'div',
										'SPAN' => 'span',
								),
						),
						array (
								'heading' => esc_html__( 'Hide side dot', 'fevr' ),
								'param_name' => 'hide_dot',
								'type' => 'luv_switch',
						)
				)
		);

		// Editor for page submenu shortcode
		$this->shortcodes['page_submenu'] = array (
				'base' => 'luv_page_submenu',
				'name' => __( 'Page Submenu', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_page_submenu.png',
				'description' => __( 'Page Submenu shortcode', 'fevr' ),
				'is_container' => true,
				'js_view' => 'VcColumnView',
				'as_parent' => array (
						'only' => 'luv_page_submenu_item'
				),
				'show_settings_on_create' => true,
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Sticky', 'fevr' ),
								'param_name' => 'sticky',
								'type' => 'luv_switch',
								'std' => 'true',
								'save_always' => true
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Menu Background Color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Link Color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Sticky Menu Background Color', 'fevr' ),
								'param_name' => 'sticky_background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Sticky Link Color', 'fevr' ),
								'param_name' => 'sticky_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						)
				)
		);

		// Editor for pricing column shortcode
		$this->shortcodes['page_submenu_item'] = array (
				'base' => 'luv_page_submenu_item',
				'name' => __( 'Page Submenu Item', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_page_submenu.png',
				'description' => __( 'Page Submenu Item', 'fevr' ),
				'as_child' => array (
						'only' => 'luv_page_submenu'
				),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Link text', 'fevr' ),
								'param_name' => 'text',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Link URL', 'fevr' ),
								'param_name' => 'href',
								'type' => 'luv_url',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Open link in', 'fevr' ),
								'param_name' => 'target',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'New window', 'fevr' ) => '_blank',
										esc_html__( 'Same window', 'fevr' ) => '_self',
										esc_html__( 'Top window', 'fevr' ) => '_top',
										esc_html__( 'Parent window', 'fevr' ) => '_parent'
								)
						)
				)
		);

		// Heading Shortcode editor
		$this->shortcodes['heading'] = array (
				'base' => 'luv_heading',
				'name' => __( 'Heading', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_one_page_section.png',
				'description' => __( 'Heading shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'description' => __( 'Title of the section.', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'holder' => 'h2'
						),
						array (
								'heading' => esc_html__( 'Node', 'fevr' ),
								'description' => __( 'HTML element node', 'fevr' ),
								'param_name' => 'node',
								'type' => 'dropdown',
								'std' => 'h2',
								'value' => array(
										'H1' => 'h1',
										'H2' => 'h2',
										'H3' => 'h3',
										'H4' => 'h4',
										'H5' => 'h5',
										'H6' => 'h6',
										'DIV' => 'div',
										'SPAN' => 'span',
								)
						),
						array (
								'heading' => esc_html__( 'Border Style', 'fevr' ),
								'param_name' => 'style',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'None', 'fevr' ) => '',
										esc_html__( 'Bordered', 'fevr' ) => 'bordered',
										esc_html__( 'Left Border', 'fevr' ) => 'left',
										esc_html__( 'Right Border', 'fevr' ) => 'right'
								)
						),
						array (
								'heading' => esc_html__( 'Border Weight', 'fevr' ),
								'param_name' => 'border_weight',
								'type' => 'number',
								'extra' => array (
										'min' => 0
								)
						),
						array (
								'heading' => esc_html__( 'Background Color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Border Color', 'fevr' ),
								'param_name' => 'border_color',
								'type' => 'colorpicker',
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for the column', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for the column, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								'dependency' 	=> array('element' => 'font_size', 'not_empty' => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'std' => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
				)
		);

		// Separator Shortcode editor
		$this->shortcodes['separator'] = array (
				'base' => 'luv_separator',
				'name' => __( 'Separator', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_separator.png',
				'description' => __( 'Separator', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Width', 'fevr' ),
								'description' => __( 'Separator width. Eg: 200px or 100%', 'fevr' ),
								'param_name' => 'width',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Height', 'fevr' ),
								'description' => __( 'Separator height. Eg: 200px', 'fevr' ),
								'param_name' => 'height',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Block', 'fevr' ),
								'param_name' => 'block',
								'type' => 'luv_switch'
						),
						array (
								'type' => 'css_editor',
								'heading' => esc_html__( 'CSS box', 'js_composer' ),
								'param_name' => 'css',
								'group' => esc_html__( 'Design Options', 'js_composer' )
						),
				)
		);

		// Editor for icon box shortcode
		$this->shortcodes['icon_box'] = array (
				'base' => 'luv_icon_box',
				'name' => __( 'Icon Box', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_icon_box.png',
				'description' => __( 'Text block with icon', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Title Tag', 'fevr' ),
								'param_name' => 'title_tag',
								'type' => 'dropdown',
								'value' => array(
										'H1' => 'h1',
										'H2' => 'h2',
										'H3' => 'h3',
										'H4' => 'h4',
										'H5' => 'h5',
										'H6' => 'h6',
								),
								'std' => 'h4'
						),
						array (
								'heading' => esc_html__( 'Content', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textarea_html',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Icon type', 'fevr' ),
								'param_name' => 'icon_type',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Icon', 'fevr') => 'icon-font',
										esc_html__('Image', 'fevr') => 'image',
								),
								'std' => 'icon-font'
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'icon',
								'type' => 'iconset',
								'extra' => array (
										'svg' => true
								),
								'dependency' => array(
										'element' => 'icon_type',
										'value' => array('icon-font')
								),
						),
						array (
								'heading' => esc_html__( 'Image', 'fevr' ),
								'param_name' => 'image',
								'type' => 'attach_image',
								'dependency' => array(
										'element' => 'icon_type',
										'value' => array('image')
								),
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Icon Animation', 'fevr' ),
								'param_name' => 'icon_animation',
								'value' => $this->luv_vc_animations,
								'description' => __( 'Animation for the icon.', 'fevr' ),
								"std" => ''
						),
						array (
								'heading' => esc_html__( 'Icon Style', 'fevr' ),
								'param_name' => 'style',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Default', 'fevr' ) => '',
										esc_html__( 'Square', 'fevr' ) => 'icon-box-square',
										esc_html__( 'Rounded', 'fevr' ) => 'icon-box-circle'
								)
						),
						array (
								'heading' => esc_html__( 'Icon size', 'fevr' ),
								'description' => __( 'Icon size in pixels', 'fevr' ),
								'param_name' => 'icon_size',
								'type' => 'number',
								'std' => '24'
						),
						array (
								'heading' => esc_html__( 'Layout', 'fevr' ),
								'param_name' => 'layout',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Left', 'fevr' ) => '',
										esc_html__( 'Right', 'fevr' ) => 'icon-box-right',
										esc_html__( 'Top', 'fevr' ) => 'icon-box-top'
								)
						),
						array (
								'heading' => esc_html__( 'Spinning', 'fevr' ),
								'description' => __( 'Spinning effect on hover', 'fevr' ),
								'param_name' => 'spinning',
								'type' => 'luv_switch'
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Icon Color', 'fevr' ),
								'param_name' => 'icon_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Icon Background Color', 'fevr' ),
								'param_name' => 'icon_background_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Icon Hover Color', 'fevr' ),
								'param_name' => 'icon_hover_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Icon Background Hover Color', 'fevr' ),
								'param_name' => 'icon_background_hover_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Border Color', 'fevr' ),
								'param_name' => 'icon_border_color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'title_font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for icon box title', 'fevr' ),
								'group' => esc_html__( 'Title Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'title_font_size',
								'description' => __( 'Font size for icon box title', 'fevr' ),
								'group' => esc_html__( 'Title Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'title_responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Title Typography', 'fevr' ),
								'dependency' 	=> array('element' => 'title_font_size', 'not_empty' => true),
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'title_font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'std' => '',
								'group' => esc_html__( 'Title Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'title_font_color',
								'group' => esc_html__( 'Title Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for icon box content', 'fevr' ),
								'group' => esc_html__( 'Content Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size for icon box content', 'fevr' ),
								'group' => esc_html__( 'Content Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Content Typography', 'fevr' ),
								'dependency' 	=> array('element' => 'font_size', 'not_empty' => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Content Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'std' => '',
								'group' => esc_html__( 'Content Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'group' => esc_html__( 'Content Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'group' => esc_html__( 'Content Typography', 'fevr' )
						),
				)
		);

		// Editor for icon shortcode
		$this->shortcodes['icon'] = array (
				'base' => 'luv_icon',
				'name' => __( 'Icon', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_icon.png',
				'description' => __( 'Icon shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'icon',
								'type' => 'iconset',
								'extra' => array (
										'svg' => true
								)
						),
						array (
								'heading' => esc_html__( 'Icon size', 'fevr' ),
								'param_name' => 'icon_size',
								'type' => 'number',
								'std' => '24'
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Icon color', 'fevr' ),
								'param_name' => 'icon_color',
								'type' => 'colorpicker',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Tooltip', 'fevr' ),
								'param_name' => 'tooltip',
								'std' => 'false',
								'description' => __( 'Set a tooltip for the text block', 'fevr' ),
								'group' => esc_html__( 'Tooltip', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Tooltip text', 'fevr' ),
								'param_name' => 'tooltip_text',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array(
										'element' => 'tooltip',
										'value' => 'true'
								)
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'tooltip_color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array(
										'element' => 'tooltip',
										'value' => 'true'
								)
						),
						array (
								'heading' => esc_html__( 'Text Color', 'fevr' ),
								'param_name' => 'tooltip_color',
								'type' => 'colorpicker',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array (
										'element' => 'tooltip_color_scheme',
										'value' => array('custom-color')
								)
						),
						array (
								'heading' => esc_html__( 'Background Color', 'fevr' ),
								'param_name' => 'tooltip_background_color',
								'type' => 'colorpicker',
								'group' => esc_html__( 'Tooltip', 'fevr' ),
								'dependency' => array (
										'element' => 'tooltip_color_scheme',
										'value' => array('custom-color')
								)
						)
				)
		);

		// Editor for dropcaps shortcode
		$this->shortcodes['dropcaps'] = array (
				'base' => 'luv_dropcaps',
				'name' => __( 'Dropcaps', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_dropcaps.png',
				'description' => __( 'Icon shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Letter', 'fevr' ),
								'param_name' => 'letter',
								'type' => 'textfield',
								'holder' => 'h2'
						),
						array (
								'heading' => esc_html__( 'Style', 'fevr' ),
								'param_name' => 'style',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Default', 'fevr' ) => '',
										esc_html__( 'Square', 'fevr' ) => 'luv-dropcaps-square',
										esc_html__( 'Rounded', 'fevr' ) => 'luv-dropcaps-rounded'
								)
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'description' => __( 'Font family for dropcaps', 'fevr' ),
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Background Color', 'fevr' ),
								'param_name' => 'background',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'color_scheme',
										'value' => array('custom-color')
								),
								'group' => esc_html__('Color', 'fevr')
						)
				)
		);

		// Editor for message box shortcode
		$this->shortcodes['message_box'] = array (
				'base' => 'luv_message_box',
				'name' => __( 'Message box', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_message_box.png',
				'description' => __( 'Message box shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Close button', 'fevr' ),
								'param_name' => 'close',
								'type' => 'luv_switch',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Close animation', 'fevr' ),
								'param_name' => 'animation',
								'type' => 'dropdown',
								'std' => 'slideUp',
								'value' => array (
										esc_html__( 'None', 'fevr' ) => 'hide',
										esc_html__( 'Slide up', 'fevr' ) => 'slideUp',
										esc_html__( 'Fade out', 'fevr' ) => 'fadeOut'
								),
								'dependency' => array (
										'element' => 'close',
										'value' => array('true')
								),
								'edit_field_class' => 'vc_col-xs-8 vc_column wpb_el_type_dropdown vc_wrapper-param-type-dropdown vc_shortcode-param',
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'icon',
								'type' => 'iconset',
								'extra' => array(
										'svg' => true
								)
						),
						array (
								'type' => 'number',
								'heading' => esc_html__( 'Icon size', 'fevr' ),
								'param_name' => 'icon_size',
								'description' => __('Icon size in pixels', 'fevr'),
								'dependency' => array('element' => 'icon', 'not_empty' => true),
								'std' => '24'
						),
						array (
								'heading' => esc_html__( 'Message', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textarea_html',
								'admin_label' => true
						),
						array (
							'heading' => esc_html__( 'Color Scheme', 'fevr' ),
							'param_name' => 'color_scheme',
							'type' => 'dropdown',
							'std' => '',
							'value' => array(
									esc_html__('Default', 'fevr') => 'default',
									esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
									esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
									esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
									esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
									esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
									esc_html__('Custom Color', 'fevr') => 'custom-color',

							),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Border color', 'fevr' ),
								'param_name' => 'border_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Text color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Background color', 'fevr' ),
								'param_name' => 'background_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
				)

		);

		// Editor for team member shortcode
		$this->shortcodes['team'] = array (
				'base' => 'luv_team',
				'name' => __( 'Team member', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_team.png',
				'description' => __( 'Icon shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Image Style', 'fevr' ),
								'param_name' => 'style',
								'type' => 'dropdown',
								'value' => array (
										esc_html__( 'Square', 'fevr' ) => 'luv-team-member-square',
										esc_html__( 'Rounded', 'fevr' ) => 'luv-team-member-rounded'
								)
						),
						array (
								'heading' => esc_html__( 'Style', 'fevr' ),
								'param_name' => 'overlay',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Overlay', 'fevr') => 'overlay',
										esc_html__('Overlay + Hover Effect', 'fevr') => 'hover-overlay',
								)
						),
						array (
								'heading' => esc_html__( 'Text color', 'fevr' ),
								'param_name' => 'color',
								'type' => 'colorpicker',
								'dependency' => array (
										'element' => 'overlay',
										'value' => array('overlay', 'hover-overlay')
								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Image', 'fevr' ),
								'param_name' => 'image',
								'type' => 'attach_image',
								'holder' => 'img'
						),
						array (
								'heading' => esc_html__( 'Name', 'fevr' ),
								'param_name' => 'name',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Position', 'fevr' ),
								'param_name' => 'position',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Description', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textarea',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Facebook', 'fevr' ),
								'param_name' => 'facebook',
								'type' => 'textfield'
						),
						array (
								'heading' => esc_html__( 'LinkedIn', 'fevr' ),
								'param_name' => 'linkedin',
								'type' => 'textfield'
						),
						array (
								'heading' => esc_html__( 'Twitter', 'fevr' ),
								'param_name' => 'twitter',
								'type' => 'textfield'
						),
						array (
								'heading' => esc_html__( 'Google+', 'fevr' ),
								'param_name' => 'googleplus',
								'type' => 'textfield'
						)
				)
		);

		// Ajax Search Shortcode
		$this->shortcodes['search'] = array (
				'base' => 'luv_search',
				'name' => __( 'Search Field', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_search.png',
				'description' => __( 'Search field shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
							'heading' => esc_html__( 'Border radius', 'fevr' ),
							'param_name' => 'border_radius',
							'type' => 'number',
							'std' => '0',
							'extra' => array('min' => 0, 'max' => 50),
						),
						array (
							'heading' => esc_html__( 'Ajax results', 'fevr' ),
							'param_name' => 'ajax',
							'type' => 'luv_switch',
						),
						array (
							'heading' => esc_html__( 'Posts per Page', 'fevr' ),
							'param_name' => 'posts_per_page',
							'type' => 'number',
							'dependency' => array('element'=>'ajax', 'value'=> array('true')),
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide title', 'fevr' ),
							'param_name' => 'hide_title',
							'std' => 'false',
							'dependency' => array('element'=>'ajax', 'value'=> array('true')),
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide excerpt', 'fevr' ),
							'param_name' => 'hide_excerpt',
							'std' => 'false',
							'dependency' => array('element'=>'ajax', 'value'=> array('true')),
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide featured image', 'fevr' ),
							'param_name' => 'hide_featured_image',
							'std' => 'false',
							'dependency' => array('element'=>'ajax', 'value'=> array('true')),
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide date', 'fevr' ),
							'param_name' => 'hide_date',
							'std' => 'false',
							'dependency' => array('element'=>'ajax', 'value'=> array('true')),
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'heading' => esc_html__( 'Color Scheme', 'fevr' ),
							'param_name' => 'color_scheme',
							'type' => 'dropdown',
							'std' => '',
							'value' => array(
									esc_html__('Default', 'fevr') => 'default',
									esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
									esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
									esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
									esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
									esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
									esc_html__('Custom Color', 'fevr') => 'custom-color',

							),
							'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Field Background Color', 'fevr' ),
								'param_name' => 'field_background_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Field Border Color', 'fevr' ),
								'param_name' => 'field_border_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Field Text Color', 'fevr' ),
								'param_name' => 'field_text_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
				)
		);

		// Ajax Login Shortcode
		$this->shortcodes['ajax_login'] = array (
				'base' => 'luv_login',
				'name' => __( 'Ajax Login', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_login.png',
				'description' => __( 'Ajax login shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
							'heading' => esc_html__( 'Login redirect', 'fevr' ),
							'param_name' => 'login_redirect',
							'description' => __( 'Redirect user after login. Leave it blank for no redirect', 'fevr' ),
							'type' => 'luv_url',
						),
						array (
							'heading' => esc_html__( 'Logout redirect', 'fevr' ),
							'param_name' => 'logout_redirect',
							'description' => __( 'Redirect user after logout. Leave it blank for no redirect', 'fevr' ),
							'type' => 'luv_url',
						),
						array (
								'heading' => esc_html__( 'Password Recovery', 'fevr' ),
								'param_name' => 'password_recovery',
								'description' => __( 'Add password recovery option', 'fevr' ),
								'type' => 'luv_switch',
						),
						array (
								'heading' => esc_html__( 'Layout', 'fevr' ),
								'param_name' => 'layout',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Horizontal', 'fevr') => 'horizontal',
										esc_html__('Vertical', 'fevr') => 'vertical'
								)
						),
						array (
							'heading' => esc_html__( 'Label style', 'fevr' ),
							'param_name' => 'label_style',
							'type' => 'dropdown',
							'value' => array(
									esc_html__('Label', 'fevr') => 'label',
									esc_html__('Placeholder', 'fevr') => 'placeholder'
							)
						),
						array (
							'heading' => esc_html__( 'Background color', 'fevr' ),
							'param_name' => 'background_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Text color', 'fevr' ),
							'param_name' => 'color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Error message color', 'fevr' ),
							'param_name' => 'error_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Success message color', 'fevr' ),
							'param_name' => 'success_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								'dependency' 	=> array('element' => 'font_size', 'not_empty' => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'std' => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
				)
		);

		// Ajax Register Shortcode
		$this->shortcodes['ajax_register'] = array (
				'base' => 'luv_register',
				'name' => __( 'Ajax Register', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_register.png',
				'description' => __( 'Ajax register shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
							'heading' => esc_html__( 'Redirect', 'fevr' ),
							'param_name' => 'redirect',
							'description' => __( 'Redirect user after registered. If you leave it blank it will redirect to the homepage', 'fevr' ),
							'type' => 'luv_url',
						),
						array (
							'heading' => esc_html__( 'Already logged in redirect', 'fevr' ),
							'param_name' => 'logged_in_redirect',
							'description' => __( 'Redirect if the user is already logged in.  If you leave it blank it will redirect to the homepage', 'fevr' ),
							'type' => 'luv_url',
						),
						array (
								'heading' => esc_html__( 'Layout', 'fevr' ),
								'param_name' => 'layout',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Horizontal', 'fevr') => 'horizontal',
										esc_html__('Vertical', 'fevr') => 'vertical'
								)
						),
						array (
							'heading' => esc_html__( 'Label style', 'fevr' ),
							'param_name' => 'label_style',
							'type' => 'dropdown',
							'value' => array(
									esc_html__('Label', 'fevr') => 'label',
									esc_html__('Placeholder', 'fevr') => 'placeholder'
							)
						),
						array (
							'heading' => esc_html__( 'Background color', 'fevr' ),
							'param_name' => 'background_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Text color', 'fevr' ),
							'param_name' => 'color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Error message color', 'fevr' ),
							'param_name' => 'error_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
							'heading' => esc_html__( 'Success message color', 'fevr' ),
							'param_name' => 'success_color',
							'type' => 'colorpicker',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param',
							'group' => esc_html__('Color', 'fevr')
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								'dependency' 	=> array('element' => 'font_size', 'not_empty' => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'std' => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
				)
		);

		// Custom Ajax Grid Shortcode
		$this->shortcodes['custom_grid'] = array (
				'base' => 'luv_custom_grid',
				'name' => __( 'Custom Grid', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_custom_grid.png',
				'is_container' => true,
				'js_view' => 'VcColumnView',
				'as_parent' => array (
						'only' => 'luv_custom_grid_filter'
				),
				'description' => __( 'Custom grid with ajax filtering', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
							'type' => 'tokenfield',
							'heading' => esc_html__( 'Post types', 'fevr' ),
							'param_name' => 'post_types',
							'tokens' => $this->post_types,
							'admin_label' => true
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Box style', 'fevr' ),
								'param_name' => 'box_style',
								'value' => array(
										esc_html__('Default', 'fevr' ) => '',
										esc_html__('Card style', 'fevr' ) => 'luv-card-style',
								),
								'std' => ''
						),
						array (
							'type' => 'dropdown',
							'heading' => esc_html__( 'Pagination', 'fevr' ),
							'param_name' => 'pagination',
							'value' => array(
									esc_html__('None', 'fevr' ) => '',
									esc_html__('Above Content', 'fevr' ) => 'above',
									esc_html__('Under Content', 'fevr' ) => 'under',
									esc_html__('Both', 'fevr' ) => 'both',
							),
							'std' => '',
							'admin_label' => true
						),
						array (
							'type' => 'number',
							'heading' => esc_html__( 'Posts per Pages', 'fevr' ),
							'param_name' => 'posts_per_page',
							'std' => '12',
							'admin_label' => true
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide title', 'fevr' ),
							'param_name' => 'hide_title',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide excerpt', 'fevr' ),
							'param_name' => 'hide_excerpt',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide featured image', 'fevr' ),
							'param_name' => 'hide_featured_image',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide date', 'fevr' ),
							'param_name' => 'hide_date',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide author', 'fevr' ),
							'param_name' => 'hide_author',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide category', 'fevr' ),
							'param_name' => 'hide_category',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array (
							'type' => 'luv_switch',
							'heading' => esc_html__( 'Hide tags', 'fevr' ),
							'param_name' => 'hide_tags',
							'std' => 'false',
							'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
						),
						array(
							'heading'		=> esc_html__('Columns', 'fevr'),
							'param_name'	=> 'columns',
							'type'			=> 'number',
							'extra'			=> array('min' => 1, 'responsive' => true, 'bootstrap' => true),
							'vc_col-xs-12 vc_column wpb_el_type_number vc_wrapper-param-type-number vc_shortcode-param vc_column-with-padding',
							'admin_label' => true
						),
						array (
								'type' => 'luv_font',
								'heading' => esc_html__( 'Font family', 'fevr' ),
								'param_name' => 'font_family',
								'value' => $fevr_vc_font_family_list,
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Font size', 'fevr' ),
								'param_name' => 'font_size',
								'description' => __( 'Font size, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_switch',
								'heading' => esc_html__( 'Responsive font size', 'fevr' ),
								'param_name' => 'responsive_font_size',
								'description' => __( 'Automatically calculate font sizes for smaller screens', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' ),
								'dependency' 	=> array('element' => 'font_size', 'not_empty' => true),
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Line height', 'fevr' ),
								'param_name' => 'line_height',
								'description' => __( 'Line height, eg: 24px or 1.3em', 'fevr' ),
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'luv_font_weight',
								'heading' => esc_html__( 'Font style', 'fevr' ),
								'param_name' => 'font_weight',
								'value' => $this->luv_vc_font_weight_list,
								'std' => '',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Font color', 'fevr' ),
								'param_name' => 'font_color',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
						array (
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Link color', 'fevr' ),
								'param_name' => 'link_color',
								'group' => esc_html__( 'Typography', 'fevr' )
						),
				)
		);

		// Custom Ajax Grid Shortcode
		$this->shortcodes['custom_grid_filter'] = array (
				'base' => 'luv_custom_grid_filter',
				'name' => __( 'Custom Grid Filter', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_custom_grid_filter.png',
				'as_child' => array (
						'only' => 'luv_custom_grid'
				),
				'description' => __( 'Filter element for Custom grid', 'fevr' ),
				'category' => 'Fevr',
				'subtitle' => esc_html__( 'Custom Grid Inner', 'fevr' ),
				'params' => array (
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Label', 'fevr' ),
								'param_name' => 'label',
								'admin_label' => true
						),
						array (
							'type' => 'dropdown',
							'heading' => esc_html__( 'Type', 'fevr' ),
							'param_name' => 'type',
							'value'	=> array(
									esc_html__('Text', 'fevr') => 'text',
									esc_html__('Checkbox', 'fevr') => 'checkbox',
									esc_html__('Radio', 'fevr') => 'radio',
									esc_html__('Dropdown', 'fevr') => 'dropdown',
									esc_html__('Hidden', 'fevr') => 'hidden',
							),
							'std' => 'text',
							'admin_label' => true
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Search in', 'fevr' ),
								'param_name' => 'in',
								'value'	=> array(
										esc_html__('Post content', 'fevr' ) => 'content',
										esc_html__('Category', 'fevr' ) => 'category',
										esc_html__('Post meta', 'fevr' ) => 'meta',
								),
								'std' => 'content',
								'admin_label' => true
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Meta key', 'fevr' ),
								'param_name' => 'meta_key',
								'dependency' => array('element' => 'in', 'value' => 'meta')
						),
						array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Value', 'fevr' ),
								'param_name' => 'value',
								'dependency' => array('element' => 'type', 'value' => array('text','checkbox','radio','hidden'))
						),
						array (
								'type' => 'key_value',
								'heading' => esc_html__( 'Values', 'fevr' ),
								'param_name' => 'content',
								'dependency' => array('element' => 'type', 'value' => 'dropdown')
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Meta type', 'fevr' ),
								'param_name' => 'meta_type',
								'dependency' => array('element' => 'in', 'value' => 'meta'),
								'value' => array(
										esc_html__('CHAR', 'fevr') => 'CHAR',
										esc_html__('NUMERIC', 'fevr') => 'NUMERIC',
										esc_html__('BINARY', 'fevr') => 'BINARY',
										esc_html__('DATE', 'fevr') => 'DATE',
										esc_html__('DATETIME', 'fevr') => 'DATETIME',
										esc_html__('DECIMAL', 'fevr') => 'DECIMAL',
										esc_html__('SIGNED', 'fevr') => 'SIGNED',
										esc_html__('UNSIGNED', 'fevr') => 'UNSIGNED',
										esc_html__('TIME', 'fevr') => 'TIME',
								),
								'std' => 'CHAR'
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Compare', 'fevr' ),
								'param_name' => 'compare',
								'value'	=> array(
										esc_html__('LIKE', 'fevr') => 'IN',
										esc_html__('NOT LIKE', 'fevr') => 'NOT_IN',
										esc_html__('EQUALS', 'fevr') => 'EQUALS',
								),
								'std' => 'IN',
								'dependency' => array('element' => 'in', 'value' => 'content'),
								'admin_label' => true
						),
						array (
								'type' => 'dropdown',
								'heading' => esc_html__( 'Compare', 'fevr' ),
								'param_name' => 'meta_compare',
								'value'	=> array(
										esc_html__('LIKE', 'fevr') => 'LIKE',
										esc_html__('NOT LIKE', 'fevr') => 'NOT LIKE',
										esc_html__('>', 'fevr') => '>',
										esc_html__('<', 'fevr') => '<',
										esc_html__('>=', 'fevr') => '>=',
										esc_html__('<=', 'fevr') => '<=',
										esc_html__('=', 'fevr') => '=',
										esc_html__('!=', 'fevr') => '!=',
								),
								'std' => 'LIKE',
								'dependency' => array('element' => 'in', 'value' => 'meta'),
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Width', 'fevr' ),
								'param_name' => 'width',
								'type' => 'textfield',
								'description' => 'Eg: 300px or 100%',
								'group' => esc_html__('Design Options', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Block element', 'fevr' ),
								'param_name' => 'is_block',
								'type' => 'luv_switch',
								'group' => esc_html__('Design Options', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Margin', 'fevr' ),
								'param_name' => 'design',
								'type' => 'luv_design',
								'group' => esc_html__('Design Options', 'fevr'),
								'description' => __('Margin in pixels', 'fevr'),
						)
				)

		);

		// Facebook comments
		$this->shortcodes['facebook_comments'] = array (
				'base' => 'luv_facebook_comments',
				'name' => __( 'Facebook Comments', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_facebook_comments.png',
				'description' => __( 'Facebook comments shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Order', 'fevr' ),
								'param_name' => 'order',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Social', 'fevr') => 'social',
										esc_html__('Time', 'fevr') => 'time',
										esc_html__('Reverse time', 'fevr') => 'reverse_time',
								)
						),
						array (
								'heading' => esc_html__( 'Number of Comments', 'fevr' ),
								'param_name' => 'numposts',
								'type' => 'number',
								'std' => 5
						)
				)
		);

		// Perspective Box
		$this->shortcodes['perspective_box'] = array (
				'base' => 'luv_perspective_box',
				'name' => __( 'Perspective Box', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_perspective_box.png',
				'description' => __( 'Perspective Box shortcode', 'fevr' ),
				'category' => 'Fevr',
				'show_settings_on_create' => false,
				'as_parent' => array (
						'only' => 'luv_perspective_image'
				),
				'params' => array (),
				'is_container' => true,
				'js_view' => 'VcColumnView',
		);

		// Perspective Box Image
		$this->shortcodes['perspective_image'] = array (
				'base' => 'luv_perspective_image',
				'name' => __( 'Perspective Image', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_perspective_box.png',
				'description' => __( 'Perspective Image shortcode', 'fevr' ),
				'category' => 'Fevr',
				'as_child' => array (
						'only' => 'luv_perspective_box'
				),
				'params' => array (
						array (
								'heading' => esc_html__( 'Link URL', 'fevr' ),
								'param_name' => 'href',
								'type' => 'luv_url'
						),
						array (
								'heading' => esc_html__( 'Image', 'fevr' ),
								'param_name' => 'image',
								'type' => 'attach_image',
								'holder' => 'img',
						),
				),
		);


		// Image Slide Box
		$this->shortcodes['image_slide_box'] = array (
				'base' => 'luv_image_slide_box',
				'name' => __( 'Image Slide Box', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_image_slide_box.png',
				'description' => __( 'Image Slide Box shortcode', 'fevr' ),
				'category' => 'Fevr',
				'show_settings_on_create' => false,
				'as_parent' => array (
						'only' => 'luv_image_slide_box_image'
				),
				'params' => array (
						array (
							'heading' => esc_html__( 'Images max-width', 'fevr' ),
							'param_name' => 'max_width',
							'description' => __('Images max width in px'),
							'type' => 'number'
						),
				),
				'is_container' => true,
				'js_view' => 'VcColumnView',
		);

		// Perspective Box Image
		$this->shortcodes['image_slide_box_image'] = array (
				'base' => 'luv_image_slide_box_image',
				'name' => __( 'Image Slide Box Element', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_image_slide_box.png',
				'description' => __( 'Image Slide Box Element shortcode', 'fevr' ),
				'category' => 'Fevr',
				'as_child' => array (
						'only' => 'luv_image_slide_box'
				),
				'params' => array (
						array (
								'heading' => esc_html__( 'Link URL', 'fevr' ),
								'param_name' => 'href',
								'type' => 'luv_url'
						),
						array (
								'heading' => esc_html__( 'Image', 'fevr' ),
								'param_name' => 'image',
								'type' => 'attach_image',
								'holder' => 'img',
						),
						array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Image size', 'fevr' ),
								'param_name' => 'image_size',
								'value' => $this->intermediate_image_sizes,
						),
				),
		);

		// Image Box
		$this->shortcodes['image_box'] = array (
				'base' => 'luv_image_box',
				'name' => __( 'Image Box', 'fevr' ),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_image_box.png',
				'description' => __( 'Image Box shortcode', 'fevr' ),
				'category' => 'Fevr',
				'params' => array (
						array (
								'heading' => esc_html__( 'Style', 'fevr' ),
								'param_name' => 'style',
								'type' => 'dropdown',
								'value' => array(
										esc_html__('Default', 'fevr') => '',
										esc_html__('Bottom title', 'fevr') => 'bottom-title',
								)
						),
						array (
								'heading' => esc_html__( 'Image', 'fevr' ),
								'param_name' => 'image',
								'type' => 'attach_image',
								'holder' => 'img'
						),
						array (
								'heading' => esc_html__( 'Minimum Height', 'fevr' ),
								'param_name' => 'min_height',
								'type' => 'number'
						),
						array (
								'heading' => esc_html__( 'Title', 'fevr' ),
								'param_name' => 'title',
								'type' => 'textfield',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Content', 'fevr' ),
								'param_name' => 'content',
								'type' => 'textarea',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Link', 'fevr' ),
								'param_name' => 'href',
								'type' => 'luv_url',
								'admin_label' => true
						),
						array (
								'heading' => esc_html__( 'Icon', 'fevr' ),
								'param_name' => 'icon',
								'type' => 'iconset',
								'extra' => array (
										'svg' => true
								),
								'dependency' => array('element' => 'style', 'value' => 'bottom-title'),
						),
						array (
								'heading' => esc_html__( 'Color Scheme', 'fevr' ),
								'param_name' => 'color_scheme',
								'type' => 'dropdown',
								'std' => '',
								'value' => array(
										esc_html__('Default', 'fevr') => 'default',
										esc_html__('Accent Color #1', 'fevr') => 'accent-color-1',
										esc_html__('Accent Color #2', 'fevr') => 'accent-color-2',
										esc_html__('Additional Color #1', 'fevr') => 'additional-color-1',
										esc_html__('Additional Color #2', 'fevr') => 'additional-color-2',
										esc_html__('Additional Color #3', 'fevr') => 'additional-color-3',
										esc_html__('Custom Color', 'fevr') => 'custom-color',

								),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Title Color', 'fevr' ),
								'param_name' => 'title_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Content Color', 'fevr' ),
								'param_name' => 'content_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
						array (
								'heading' => esc_html__( 'Base Color', 'fevr' ),
								'param_name' => 'base_color',
								'type' => 'colorpicker',
								'edit_field_class' => 'vc_col-xs-4 vc_column wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column-with-padding',
								'dependency' => array('element' => 'color_scheme', 'value' => 'custom-color'),
								'group' => esc_html__('Color', 'fevr')
						),
				),
		);

		// Video shortcode
		$this->shortcodes['video'] = array(
				'name' => __('Video', 'fevr'),
				'base' => 'luv_video',
				'description' => __( 'Video shortcode', 'fevr'),
				'category' => esc_html__( 'Fevr', 'fevr'),
				'icon' => LUVTHEMES_CORE_URI . 'assets/images/luv_shortcode_video.png',
				'params' => array(
					array (
							'heading' => esc_html__( 'Source', 'fevr' ),
							'param_name' => 'video',
							'type' => 'attach_media',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param vc_column-with-padding',
							'admin_label' => true
					),
					array (
							'heading' => esc_html__( 'Width', 'fevr' ),
							'param_name' => 'width',
							'type' => 'textfield',
							'description' => 'Eg: 300px or 100%',
							'edit_field_class' => 'vc_col-xs-6 vc_column wpb_el_type_textfield vc_wrapper-param-type-textfield vc_shortcode-param'
					),
					array (
							'heading' => esc_html__( 'Autoplay', 'fevr' ),
							'param_name' => 'video_autoplay',
							'type' => 'luv_switch',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
					),
					array (
							'heading' => esc_html__( 'Loop', 'fevr' ),
							'param_name' => 'video_loop',
							'type' => 'luv_switch',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
					),
					array (
							'heading' => esc_html__( 'Mute', 'fevr' ),
							'param_name' => 'video_mute',
							'type' => 'luv_switch',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
					),
					array (
							'heading' => esc_html__( 'Controls', 'fevr' ),
							'param_name' => 'video_controls',
							'type' => 'luv_switch',
							'edit_field_class' => 'vc_col-xs-3 vc_column wpb_el_type_luv_switch vc_wrapper-param-type-luv_switch vc_shortcode-param'
					),
				)
		);
	}
	//****************************************************
	// Shortcodes
	//****************************************************

	public function blog_shortcode( $atts ) {
		$luv_shortcode_atts = shortcode_atts( array(
				'posts_by' => 'category',
				'blog_category' => '__all',
				'blog_orderby' => 'newest',
				'ids' => '',
				'blog_layout_style' => 'standard',
				'blog_automatic_metro_layout' => 'false',
				'blog_columns' => 'two-columns',
				'blog_masonry_layout' => 'standard',
				'blog_masonry_rounded_corners' => 'false',
				'blog_masonry_shadow' => 'false',
				'blog_masonry_hover_style' => 'masonry-style-zoom',
				'blog_masonry_overlay_icon' => '',
				'blog_masonry_content' => 'title',
				'blog_override_colors' => 'false',
				'blog_override_accent_color' => '',
				'blog_override_text_color' => '',
				'blog_override_position' => 'false',
				'blog_override_horizontal_position' => '',
				'blog_override_vertical_position' => '',
				'blog_masonry_auto_text_color' => 'false',
				'blog_masonry_gutter' => 'false',
				'blog_item_padding' => '',
				'blog_masonry_crop_images' => 'false',
				'blog_masonry_filter' => 'false',
				'blog_masonry_filter_background' => 'false',
				'blog_alternate_same_column' => 'false',
				'blog_masonry_equal_height' => 'false',
				'blog_excerpt' => 'false',
				'blog_excerpt_length' => 35,
				'blog_author_meta' => 'false',
				'blog_likes_meta' => 'false',
				'blog_categories_meta' => 'false',
				'blog_tags_meta' => 'false',
				'blog_date_meta' => 'false',
				'blog_comments_meta' => 'false',
				'blog_posts_per_page' => '',
				'blog_pagination'	=> '',
				'blog_pagination_position' => 'under-content',
				'blog_animation' => '',
				'blog_display_featured_image' => 'false',
				'luv_carousel' => 'false',
				'infinite' => 'false',
				'nav' => 'false',
				'dots' => 'false',
				'autoplay' => 'false',
				'autoplay_timeout' => '5000',
				'autoplay_pause' => 'false',
				'transition_type' => '',
				'items' => "{'desktop':'1','laptop':'1','tablet-landscape':'1','tablet-portrait':'1','mobile':'1',}",
				'margin' => '',
				'parallax' => 'false',
				'full_height' => 'false',
				'distinct_group' => '',
				'title_font_family' => '',
				'title_font_size' => '',
				'title_responsive_font_size' => '',
				'title_text_transform' => '',
				'title_font_weight' => '',
				'title_font_color' => ''
		), $atts, 'luv_blog' );

		// Enqueue tilt.js if perspective hover animation is in use
		if($luv_shortcode_atts['blog_masonry_hover_style'] == 'masonry-perspective') {
			wp_enqueue_script('tilt', LUVTHEMES_CORE_URI.'assets/js/min/tilt-min.js', array(), LUVTHEMES_CORE_VER);
		}

		// Convert shortcode atts to be compatible with fevr_options
		$luv_shortcode_atts['blog_author_meta'] = ($luv_shortcode_atts['blog_author_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['blog_likes_meta'] = ($luv_shortcode_atts['blog_likes_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['blog_categories_meta'] = ($luv_shortcode_atts['blog_categories_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['blog_tags_meta'] = ($luv_shortcode_atts['blog_tags_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['blog_date_meta'] = ($luv_shortcode_atts['blog_date_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['blog_comments_meta'] = ($luv_shortcode_atts['blog_comments_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['shortcode_masonry_filter_background']	= $luv_shortcode_atts['blog_masonry_filter_background'];

		global $fevr_blog_title_typography_classes;
		$fevr_blog_title_typography_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_blog_title', array(
				'font_family' => $luv_shortcode_atts['title_font_family'],
				'font_size' => $luv_shortcode_atts['title_font_size'],
				'responsive_font_size' => $luv_shortcode_atts['title_responsive_font_size'],
				'font_weight' => $luv_shortcode_atts['title_font_weight'],
				'text_transform' => $luv_shortcode_atts['title_text_transform'],
				'font_color' => $luv_shortcode_atts['title_font_color'],
		));

		global $luv_blog_shortcode_atts;
		$luv_blog_shortcode_atts = $luv_shortcode_atts;

		global $is_luv_shortcode;
		$is_luv_shortcode = true;

		global $luv_blog_distinct;

		// Categories
		global $fevr_shortcode_categories, $fevr_shortcode_taxonomy;
		$fevr_shortcode_categories = array();
		$fevr_shortcode_taxonomy = 'category';
		if(!empty($luv_shortcode_atts['blog_category']) && $luv_shortcode_atts['blog_category'] != '__all'){
			foreach(explode(',',$luv_shortcode_atts['blog_category']) as $cat){
				$cat = trim($cat);
				if ($cat == '__related'){
					$post_categories = wp_get_post_categories(get_the_ID());
					foreach($post_categories as $c){
						$_cat = get_category( $c );
						$fevr_shortcode_categories[] = $_cat->name;
					}

				}
				else{
					$fevr_shortcode_categories[] = $cat;
				}
			}
		}
		else{
			$fevr_shortcode_categories = array();
			foreach(get_categories(array('taxonomy' => 'category')) as $category) {
				$fevr_shortcode_categories[] = $category->name;
			}
		}

		/*
		 * Blog Query
		 */

		// Paged
		global $wp_query;
		$paged = (isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 0);

		if ($luv_shortcode_atts['posts_by'] == 'category'){
			// Categories
			$tax_query = array();
			if ($luv_shortcode_atts['blog_category'] != '__all' && !empty($luv_shortcode_atts['blog_category'])){
				$tax_query = array(
						array(
								'taxonomy' => 'category',
								'field'    => 'name',
								'terms'    => $fevr_shortcode_categories,
								'operator' => 'IN'
						)
				);
			}

			//Distinct Groups
			$post_not_in = array(get_the_ID());
			if (!empty($luv_shortcode_atts['distinct_group'])){
				$post_not_in = array_merge(
						$post_not_in,
						(array)$luv_blog_distinct[$luv_shortcode_atts['distinct_group']]
				);
			}

			// Order by
			switch($luv_shortcode_atts['blog_orderby']){
				case 'oldest':
					$orderby = array(
						'orderby' => 'date',
						'order'   => 'ASC',
					);
					break;
				case 'a-z':
					$orderby = array(
					'orderby' => 'title',
					'order'   => 'ASC',
					);
					break;
				case 'z-a':
					$orderby = array(
					'orderby' => 'title',
					'order'   => 'DESC',
					);
					break;
				case 'newest':
				default:
					$orderby = array();
				break;
			}

			$blog_args = array_merge(array(
					'post__not_in' => $post_not_in,
					'post_type' => 'post',
					'tax_query' => $tax_query,
					'posts_per_page' => $luv_shortcode_atts['blog_posts_per_page'],
					'paged' => !empty($paged) ? $paged : 1
			), $orderby);
		}
		else if ($luv_shortcode_atts['posts_by'] == 'ids'){
			$ids = array_merge(array(-1), explode(',',trim($luv_shortcode_atts['ids'])));
			$portfolio_args = array(
					'post_type' => 'post',
					'post__in' => $ids,
					'posts_per_page' => $luv_shortcode_atts['blog_posts_per_page'],
					'paged'	=> !empty($paged) ? $paged : 1
			);

			// Filter order by
			global $luv_loop_orderby_filter;
			$luv_loop_orderby_filter = $luv_shortcode_atts['ids'];
			add_filter('posts_orderby', array($this, 'loop_orderby_filter'));

		}

		$blog_query = new WP_Query( $blog_args );

		// Remove order by filter after query
		remove_filter('posts_orderby', array($this, 'loop_orderby_filter'));

		ob_start();

	// Use shortcode settings instead global fevr_options
	global $fevr_options;
	luv_core_set_fevr_options($luv_shortcode_atts);

	//Backup meta fields
	luv_core_backup_fevr_meta();

	// Before content navigaiton
	if (!empty($luv_shortcode_atts['blog_pagination']) && $luv_shortcode_atts['blog_pagination_position'] == 'above-content' || $luv_shortcode_atts['blog_pagination_position'] == 'both'){
		$this->shortcode_pagination($blog_query, $luv_shortcode_atts);
	}

	// Classes for .container
	$luv_container_classes = array();
	// Full width content
	if (isset($fevr_options['blog-full-width']) && $fevr_options['blog-full-width'] == 1) {
		$luv_container_classes[] = 'container-fluid';
	}

	// Classes for .l-grid-row
	$luv_grid_classes = array();
	// Sidebar
	if(isset($fevr_options['blog-sidebar-position']) && $fevr_options['blog-sidebar-position'] != 'no-sidebar') {
		$luv_grid_classes[] = 'has-sidebar';
	}

	// Sidebar position
	if(isset($fevr_options['blog-sidebar-position']) && $fevr_options['blog-sidebar-position'] == 'left-sidebar') {
		$luv_grid_classes[] = $fevr_options['blog-sidebar-position'];
	}

	// Classes for .posts-container and #content-wrapper
	$luv_posts_container_classes = array();
	$luv_content_wrapper_classes = array();

	// Carousel
	if($luv_shortcode_atts['luv_carousel'] == 'true') {
		wp_enqueue_script( 'fevr-owlcarousel' );
		$luv_posts_container_classes[] = 'luv-carousel';
	}

	// Columns
	if(isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-columns']) && !empty($fevr_options['blog-columns'])) {
		$luv_posts_container_classes[] = $fevr_options['blog-columns'];
	}

	// Alternate layout
	if(isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'alternate' && isset($fevr_options['blog-alternate-same-column']) && $fevr_options['blog-alternate-same-column'] == 0) {
		$luv_posts_container_classes[] = 'varied-columns';
	}

	// Layout Style (alternate, standard, masonry)
	if(isset($fevr_options['blog-layout-style']) && !empty($fevr_options['blog-layout-style'])) {
		$luv_posts_container_classes[] = $fevr_options['blog-layout-style'];
	}

	// Gutter when we use masonry layout
	if(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry') {
		$luv_posts_container_classes[] = 'masonry-no-gap';
	}

	// Add margin if custom item padding is set
	if (_check_luvoption('blog-item-padding','','!=')){
		$luv_posts_container_classes[] = _luv_enqueue_inline_css(array('style' => 'margin-left:-' . _get_luvoption('blog-item-padding') . ' !important;' . 'margin-right:-' . _get_luvoption('blog-item-padding') . ' !important;'));
	}

	// Wrapper Class
	if(!(isset($fevr_options['blog-masonry-gutter']) && $fevr_options['blog-masonry-gutter'] == 1 && isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry')) {
		$luv_content_wrapper_classes[] = 'wrapper-padding';
	}

	// Masonry layout style
	if(isset($fevr_options['blog-masonry-layout']) && !empty($fevr_options['blog-masonry-layout']) && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry') {
		$luv_posts_container_classes[] = 'masonry-'.$fevr_options['blog-masonry-layout'];
	}

	// Masonry rounded corners
	if(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-masonry-rounded-corners']) && $fevr_options['blog-masonry-rounded-corners'] == 1) {
		$luv_posts_container_classes[] = 'masonry-rounded-corners';
	}

	// Masonry equal height
	if(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-masonry-equal-height']) && $fevr_options['blog-masonry-equal-height'] == 1) {
		$luv_posts_container_classes[] = 'masonry-equal-height';
	}

	// Masonry shadows
	if(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-masonry-shadows']) && $fevr_options['blog-masonry-shadows'] == 1) {
		$luv_posts_container_classes[] = 'masonry-shadows';
	}

	// Masonry equal height
	$masonry_equal_height = false;
	if(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-masonry-equal-height']) && $fevr_options['blog-masonry-equal-height'] == 1) {
		$luv_posts_container_classes[] = 'masonry-equal-height';
		$masonry_equal_height = true;
	}

	// Data for .posts-container
	$luv_posts_container_data = array();
	// Data crop images (data-crop-images="")
	if(isset($fevr_options['blog-masonry-crop-images']) && $fevr_options['blog-masonry-crop-images'] == 1) {
		$luv_posts_container_data[] = 'data-crop-images="true"';
	} else {
		$luv_posts_container_data[] = 'data-crop-images="false"';
	}

	// Carousel
	if ($luv_shortcode_atts['luv_carousel'] == 'true'){
		$carousel_settings = array('infinite', 'nav', 'dots', 'autoplay', 'autoplay_timeout', 'autoplay_pause', 'transition_type', 'items', 'margin', 'parallax', 'full_height');
		foreach ($carousel_settings as $key){
			if (!empty($luv_shortcode_atts[$key])){
				$luv_posts_container_data[] = 'data-luv-carousel-' . $key . '="'.$luv_shortcode_atts[$key].'"';
			}
		}
	}

	// Background Check (data-bg-check="")
	if(isset($fevr_options['blog-masonry-auto-text-color']) && $fevr_options['blog-masonry-auto-text-color'] == 1 && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' && isset($fevr_options['blog-masonry-hover-style']) && $fevr_options['blog-masonry-hover-style'] != 'masonry-style-title-bottom') {
		$luv_posts_container_data[] = 'data-bg-check="true"';
	}

	// Automatic Metro Layout
	if (isset($fevr_options['blog-automatic-metro-layout']) && $fevr_options['blog-automatic-metro-layout'] == 1){
		$fevr_masonry_size_overrides = array();

		switch ($fevr_options['blog-columns']){
			case 'auto-columns':
				$columns = 5;
				break;
			case 'four-columns':
				$columns = 4;
				break;
			case 'three-columns':
				$columns = 3;
				break;
			case 'two-columns':
				$columns = 2;
				break;
			case 'one-column':
				$columns = 1;
				break;
		}
		$remand = (int)$blog_query->post_count % $columns;
		$count	= (int)$blog_query->post_count;

		if ($columns == 5 && $blog_query->post_count >= $columns){
			if ($remand == 0){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_wide';
				$fevr_masonry_size_overrides[$blog_query->posts[2]->ID] = 'fevr_wide_tall';
			}
			else if ($remand == 1){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[5]->ID] = 'fevr_wide';
			}
			else if ($remand == 2){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide_tall';
				if ($count >= 8){
					$fevr_masonry_size_overrides[$blog_query->posts[3]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$blog_query->posts[5]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$blog_query->posts[4]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-2]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-5]->ID] = 'fevr_tall';
				}
			}
			else if ($remand == 3){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_wide';
				if ($count >= 8){
					$fevr_masonry_size_overrides[$blog_query->posts[$count-4]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-5]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-8]->ID] = 'fevr_wide_tall';
				}
			}
			else if ($remand == 4){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[5]->ID] = 'fevr_wide_tall';
			}
		}

		if ($columns == 4 && $blog_query->post_count >= $columns){
			if ($remand == 0){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_wide';
				if ($count >= 8){
					$fevr_masonry_size_overrides[$blog_query->posts[$count-1]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-3]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-4]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$blog_query->posts[$count-5]->ID] = 'fevr_tall';
				}
			}
			else if ($remand == 1){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[$count-2]->ID] = 'fevr_wide_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[$count-3]->ID] = 'fevr_tall';
			}
			else if ($remand == 2){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_wide';
			}
			else if ($remand == 3){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide';
			}
		}

		if ($columns == 3 && $blog_query->post_count >= $columns){
			if ($remand == 0){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide_tall';
			}
			else if ($remand == 1){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_tall';
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_wide';
			}
			else if ($remand == 2){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide';
			}
		}

		if ($columns == 2 && $blog_query->post_count >= $columns){
			if ($remand == 0){
				$fevr_masonry_size_overrides[$blog_query->posts[0]->ID] = 'fevr_wide';
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_tall';
			}
			else if ($remand == 1){
				$fevr_masonry_size_overrides[$blog_query->posts[1]->ID] = 'fevr_wide';
			}
		}
	}

?>

				<?php
					// Enable Masonry Filter
					if(isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' && isset($fevr_options['blog-masonry-filter']) && $fevr_options['blog-masonry-filter'] == 1) {
						get_template_part( 'luvthemes/luv-templates/masonry-filter' );
					}
				?>

				<div class="posts-container item-grid-container <?php echo implode(' ', $luv_posts_container_classes); ?>" <?php echo implode(' ', $luv_posts_container_data); ?>>
				<?php
					if ( $blog_query->have_posts() ) :
						while ( $blog_query->have_posts() ) : $blog_query->the_post();
							global $fevr_meta_fields;
							$fevr_meta_fields = get_post_meta( get_the_ID(), 'fevr_meta', true);

							// Distinct Group
							if (!empty($luv_shortcode_atts['distinct_group'])){
								$luv_blog_distinct[$luv_shortcode_atts['distinct_group']][] = get_the_ID();
							}


							// Automatic Metro Layout
							if (isset($fevr_options['blog-automatic-metro-layout']) && $fevr_options['blog-automatic-metro-layout'] == 1){
								if (isset($fevr_masonry_size_overrides[get_the_ID()])){
									$fevr_meta_fields['post-masonry-size'] = $fevr_masonry_size_overrides[get_the_ID()];
								}
								else{
									$fevr_meta_fields['post-masonry-size'] = 'fevr_normal';
								}
							}

							// Article classes
							$luv_article_classes = array();

							// Expired
							if(isset($fevr_meta_fields['post-expiration-date']) && !empty($fevr_meta_fields['post-expiration-date']) && strtotime($fevr_meta_fields['post-expiration-date']) < time()){
								$luv_article_classes[] = 'expired-post';
								$expiration_message = isset($fevr_meta_fields['post-expiration-message']) ? $fevr_meta_fields['post-expiration-message'] : '';
							}

							// Set masonry size
							if (isset($fevr_meta_fields['post-masonry-size']) && !empty($fevr_meta_fields['post-masonry-size']) &&
								isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' &&
								isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry')
							{
								$luv_article_classes[] = 'masonry-size-'.$fevr_meta_fields['post-masonry-size'];
							} elseif(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' &&
									isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry') {
								$luv_article_classes[] = 'masonry-size-fevr_normal';
							}

							// Masonry Style for Standard Layout
							if (isset($fevr_meta_fields['post-masonry-style']) && !empty($fevr_meta_fields['post-masonry-style']) &&
								isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' &&
								isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry')
							{
								$luv_article_classes['background-image-style'] = 'masonry-style-'.$fevr_meta_fields['post-masonry-style'];

								if($fevr_meta_fields['post-masonry-style'] == 'background-image' || ($masonry_equal_height && in_array(get_post_format(), array('gallery', 'image')) && $fevr_meta_fields['post-masonry-style'] != 'featured') ) {
									if(has_post_thumbnail()) {
										$background_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'fevr_tall');
										$luv_article_classes[] = _luv_enqueue_inline_css(array('style' => 'background-image: url('.$background_image[0].');'));
										$luv_article_classes['background-image-style'] = 'masonry-style-background-image';
									}
								}

								if($fevr_meta_fields['post-masonry-style'] == 'featured') {
									$luv_article_classes[] = 'masonry-size-fevr_wide';
								}
							}

							// When masonry is active without custom content we display the style for the hover effect. If we have custom content and the style is still masonry we add a helper class to disable the effects
							if (isset($fevr_options['blog-masonry-hover-style']) && !empty($fevr_options['blog-masonry-hover-style']) &&
								isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' &&
	 							isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' &&
								(!isset($fevr_meta_fields['post-masonry-show-content']) || $fevr_meta_fields['post-masonry-show-content'] != 'enabled'))
							{
								$luv_article_classes[] = $fevr_options['blog-masonry-hover-style'];
							}
							else if (isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' &&
								isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry' &&
								isset($fevr_meta_fields['post-masonry-show-content']) && $fevr_meta_fields['post-masonry-show-content'] == 'enabled')
							{
								$luv_article_classes[] = 'masonry-custom-content';
							}

							// Masonry Overlay Icon
							if (!empty($luv_shortcode_atts['blog_masonry_overlay_icon'])){
								$fevr_meta_fields['post-masonry-overlay-icon'] = $luv_shortcode_atts['blog_masonry_overlay_icon'];
							}

							// Animation
							if(isset($fevr_options['blog-animation']) && !empty($fevr_options['blog-animation'])){
								$luv_article_classes[] = 'c-has-animation ' . $fevr_options['blog-animation'];
							}

							// Carousel
							if($luv_shortcode_atts['luv_carousel'] == 'true' && empty($luv_shortcode_atts['blog_animation']) && $luv_shortcode_atts['blog_layout_style'] == 'masonry') {
								$luv_article_classes[] = 'appended-item';
							}

						    // Hide thumbnail/video/audio if background image is in use
						    global $fevr_show_thumbnail;
						    $fevr_show_thumbnail = true;

						    if(isset($fevr_meta_fields['post-masonry-style']) && $fevr_meta_fields['post-masonry-style'] == 'background-image' &&
					    		isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' &&
					    		isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry') {
					    		$fevr_show_thumbnail = false;
				    		}

				    		if($masonry_equal_height && in_array(get_post_format(), array('gallery', 'image'))) {
				    			$fevr_show_thumbnail = false;
				    		}

							// Background image for featured masonry style
							global $fevr_featured_class;
							$fevr_featured_class = '';
							if(isset($fevr_meta_fields['post-masonry-style']) && $fevr_meta_fields['post-masonry-style'] == 'featured' &&
						            isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'standard' &&
						            isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry') {

								$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'fevr_wide_tall' );
								$fevr_featured_class = _luv_enqueue_inline_css(array('style' => 'background-image: url('.$image[0].');'));
							}

							// Override text and background colors
							if ($luv_shortcode_atts['blog_override_colors'] == 'true'){
								if (!empty($luv_shortcode_atts['blog_override_accent_color'])){
									$fevr_meta_fields['blog-masonry-auto-text-color'] = 0;
									$fevr_meta_fields['post-masonry-accent-color'] = $luv_shortcode_atts['blog_override_accent_color'];
								}
								if (!empty($luv_shortcode_atts['blog_override_text_color'])){
									$fevr_meta_fields['post-masonry-text-color'] = $luv_shortcode_atts['blog_override_text_color'];
								}
							}

							// Override text and background colors
							if ($luv_shortcode_atts['blog_override_position'] == 'true'){
								if (!empty($luv_shortcode_atts['blog_override_horizontal_position'])){
									$fevr_meta_fields['post-masonry-h-text-alignment'] = $luv_shortcode_atts['blog_override_horizontal_position'];
								}
								if (!empty($luv_shortcode_atts['blog_override_vertical_position'])){
									$fevr_meta_fields['post-masonry-v-text-alignment'] = $luv_shortcode_atts['blog_override_vertical_position'];
								}
							}

				?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $luv_article_classes)); ?>>
							<?php
								if(isset($fevr_options['blog-masonry-layout']) && $fevr_options['blog-masonry-layout'] == 'meta-overlay' && isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'masonry') {
									get_template_part( 'luvthemes/post-templates/post', 'masonry' );
								} elseif(isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'alternate') {
									get_template_part( 'luvthemes/post-templates/post', 'alternate' );
								} elseif(isset($fevr_options['blog-layout-style']) && $fevr_options['blog-layout-style'] == 'titles-only') {
									get_template_part( 'luvthemes/post-templates/post', 'title' );
								}
								else {
									get_template_part( 'luvthemes/post-templates/post', get_post_format() );
								}
							?>
						</article>
				<?php
						endwhile;

					else:
						esc_html_e('No posts were found', 'fevr');
					endif;
				?>
				</div>

		<?php

		// After content pagination
		if (!empty($luv_shortcode_atts['blog_pagination']) && $luv_shortcode_atts['blog_pagination_position'] == 'under-content' ||  $luv_shortcode_atts['blog_pagination_position'] == 'both'){
			$this->shortcode_pagination($blog_query, $luv_shortcode_atts);
		}

		wp_reset_postdata();
		luv_core_reset_fevr_options();
		luv_core_reset_fevr_meta();

		return apply_filters('luv_blog_shortcode', ob_get_clean(), $atts);
	}

	/**
	 * Portfolio shortcode
	 * @param array $atts
	 */
	public function portfolio_shortcode( $atts ) {
		$luv_shortcode_atts = shortcode_atts( array(
				'posts_by' => 'category',
				'portfolio_category' => '__all',
				'portfolio_orderby' => 'newest',
				'ids' => '',
				'portfolio_columns' => 'auto-columns',
				'portfolio_masonry_layout' => 'standard',
				'portfolio_automatic_metro_layout' => 'false',
				'portfolio_masonry_rounded_corners' => 'false',
				'portfolio_masonry_shadow' => 'false',
				'portfolio_item_overlay' => 'false',
				'portfolio_masonry_hover_style' => 'masonry-style-zoom',
				'portfolio_masonry_overlay_icon' => '',
				'portfolio_masonry_content' => 'title',
				'portfolio_override_colors' => 'false',
				'portfolio_override_accent_color' => '',
				'portfolio_override_text_color' => '',
				'portfolio_override_position' => 'false',
				'portfolio_override_horizontal_position' => '',
				'portfolio_override_vertical_position' => '',
				'portfolio_masonry_auto_text_color' => 'false',
				'portfolio_masonry_gutter' => 'false',
				'portfolio_item_padding' => '',
				'portfolio_masonry_filter' => 'false',
				'portfolio_masonry_filter_background' => 'false',
				'portfolio_masonry_crop_images' => 'false',
				'portfolio_likes_meta' => 'false',
				'portfolio_posts_per_page' => '',
				'portfolio_order' => 'newest',
				'portfolio_pagination'	=> '',
				'portfolio_pagination_position' => 'under-content',
				'portfolio_animation' => '',
				'luv_carousel' => 'false',
				'infinite' => 'false',
				'nav' => 'false',
				'dots' => 'false',
				'autoplay' => 'false',
				'autoplay_timeout' => '5000',
				'autoplay_pause' => 'false',
				'transition_type' => '',
				'items' => "{'desktop':'1','laptop':'1','tablet-landscape':'1','tablet-portrait':'1','mobile':'1',}",
				'margin' => '',
				'parallax' => 'false',
				'full_height' => 'false',
				'title_font_family' => '',
				'title_font_size' => '',
				'title_responsive_font_size' => '',
				'title_text_transform' => '',
				'title_font_weight' => '',
				'title_font_color' => '',
		), $atts, 'luv_portfolio' );

		// Enqueue tilt.js if perspective hover animation is in use
		if($luv_shortcode_atts['portfolio_masonry_hover_style'] == 'masonry-perspective') {
			wp_enqueue_script('tilt', LUVTHEMES_CORE_URI.'assets/js/min/tilt-min.js', array(), LUVTHEMES_CORE_VER);
		}

		// Override portfolio posts per pages for pesudo page
		if (is_post_type_archive('luv_portfolio')){
			$luv_shortcode_atts['portfolio_posts_per_page'] = get_option('posts_per_page');
		}

		// Convert shortcode atts to be compatible with templates
		$luv_shortcode_atts['portfolio_likes_meta']					= ($luv_shortcode_atts['portfolio_likes_meta'] == 'true' ? 'hide-on-archive' : '');
		$luv_shortcode_atts['shortcode_masonry_filter_background']	= $luv_shortcode_atts['portfolio_masonry_filter_background'];

		global $fevr_portfolio_title_typography_classes;
		$fevr_portfolio_title_typography_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_portfolio_title', array(
				'font_family' => $luv_shortcode_atts['title_font_family'],
				'font_size' => $luv_shortcode_atts['title_font_size'],
				'responsive_font_size' => $luv_shortcode_atts['title_responsive_font_size'],
				'font_weight' => $luv_shortcode_atts['title_font_weight'],
				'text_transform' => $luv_shortcode_atts['title_text_transform'],
				'font_color' => $luv_shortcode_atts['title_font_color'],
		));

		global $luv_portfolio_shortcode_atts;
		$luv_portfolio_shortcode_atts = $luv_shortcode_atts;

		global $is_luv_shortcode;
		$is_luv_shortcode = true;

		global $luv_shortcode_post_type;
		$luv_shortcode_post_type= 'luv_portfolio';

		global $fevr_shortcode_categories, $fevr_shortcode_taxonomy;
		$fevr_shortcode_categories = array();
		$fevr_shortcode_taxonomy = 'luv_portfolio_categories';
		if(!empty($luv_shortcode_atts['portfolio_category']) && $luv_shortcode_atts['portfolio_category'] != '__all'){
	 		foreach(explode(',',$luv_shortcode_atts['portfolio_category']) as $cat){
	 			$cat = trim($cat);
				if ($cat == '__related'){
					$post_categories = wp_get_post_categories(get_the_ID());
					foreach($post_categories as $c){
						$_cat = get_category( $c );
						$fevr_shortcode_categories[] = $_cat->name;
					}

				}
				else{
					$fevr_shortcode_categories[] = $cat;
				}
	 		}
	 	}
	 	else{
			$fevr_shortcode_categories = array();
			foreach(get_categories(array('taxonomy' => 'luv_portfolio_categories')) as $category) {
				$fevr_shortcode_categories[] = $category->name;
			}
		}

		/*
		 * Portfolio Query
		 */

		// Paged
		global $wp_query;
		$paged = (isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 0);

		if ($luv_shortcode_atts['posts_by'] == 'category'){
			$tax_query = array();
			if ($luv_shortcode_atts['portfolio_category'] != '__all' && !empty($luv_shortcode_atts['portfolio_category'])){
				$tax_query = array(
						array(
								'taxonomy' => 'luv_portfolio_categories',
								'field'    => 'name',
								'terms'    => $fevr_shortcode_categories,
								'operator' => 'IN'
						)
				);
			}

			// Order by
			switch($luv_shortcode_atts['portfolio_orderby']){
				case 'oldest':
					$orderby = array(
					'orderby' => 'date',
					'order'   => 'ASC',
					);
					break;
				case 'a-z':
					$orderby = array(
					'orderby' => 'title',
					'order'   => 'ASC',
					);
					break;
				case 'z-a':
					$orderby = array(
					'orderby' => 'title',
					'order'   => 'DESC',
					);
					break;
				case 'newest':
				default:
					$orderby = array();
					break;
			}


			$portfolio_args = array_merge(array(
				'post_type' => 'luv_portfolio',
				'tax_query' => $tax_query,
				'posts_per_page' => $luv_shortcode_atts['portfolio_posts_per_page'],
				'paged'	=> !empty($paged) ? $paged : 1
			), $orderby);
		}
		else if ($luv_shortcode_atts['posts_by'] == 'ids'){
			$ids = array_merge(array(-1), explode(',',trim($luv_shortcode_atts['ids'])));
			$portfolio_args = array(
					'post_type' => 'luv_portfolio',
					'post__in' => $ids,
					'posts_per_page' => $luv_shortcode_atts['portfolio_posts_per_page'],
					'paged'	=> !empty($paged) ? $paged : 1
			);

			// Filter order by
			global $luv_loop_orderby_filter;
			$luv_loop_orderby_filter = $luv_shortcode_atts['ids'];
			add_filter('posts_orderby', array($this, 'loop_orderby_filter'));

		}

		$portfolio_query = new WP_Query( $portfolio_args );

		// Remove order by filter after query
		remove_filter('posts_orderby', array($this, 'loop_orderby_filter'));

		ob_start();

		// Use shortcode settings instead global fevr_options
		luv_core_set_fevr_options($luv_shortcode_atts);

		//Backup meta fields
		luv_core_backup_fevr_meta();

		// Before content navigaiton
		if (!empty($luv_shortcode_atts['portfolio_pagination']) && $luv_shortcode_atts['portfolio_pagination_position'] == 'above-content' || $luv_shortcode_atts['portfolio_pagination_position'] == 'both'){
			$this->shortcode_pagination($portfolio_query, $luv_shortcode_atts);
		}

		// Classes for .container
		$luv_container_classes = array();
		// Full width content
		if(isset($luv_shortcode_atts['portfolio_full_width']) && $luv_shortcode_atts['portfolio_full_width'] == 'true') {
			$luv_container_classes[] = 'container-fluid';
		}

		// Classes for .l-grid-row
		$luv_grid_classes = array();
		// Sidebar
		if(isset($luv_shortcode_atts['portfolio_sidebar_position']) && $luv_shortcode_atts['portfolio_sidebar_position'] != 'no-sidebar') {
			$luv_grid_classes[] = 'has-sidebar';
		}

		// Sidebar position
		if(isset($luv_shortcode_atts['portfolio_sidebar_position']) && $luv_shortcode_atts['portfolio_sidebar_position'] == 'left-sidebar') {
			$luv_grid_classes[] = $luv_shortcode_atts['portfolio_sidebar_position'];
		}

		// Classes for .portfolio-container
		$luv_portfolio_container_classes = array();

		// Carousel
		if($luv_shortcode_atts['luv_carousel'] == 'true') {
			wp_enqueue_script( 'fevr-owlcarousel' );
			$luv_portfolio_container_classes[] = 'luv-carousel';
		}

		// Columns
		if(isset($luv_shortcode_atts['portfolio_columns']) && $luv_shortcode_atts['portfolio_columns'] != 'one-column' && $luv_shortcode_atts['luv_carousel'] != 'true') {
			$luv_portfolio_container_classes[] = $luv_shortcode_atts['portfolio_columns'].' masonry';
		}

		// Masonry layout
		if(isset($luv_shortcode_atts['portfolio_masonry_layout']) && $luv_shortcode_atts['portfolio_masonry_layout'] != 'standard') {
			$luv_portfolio_container_classes[] = 'masonry-'.$luv_shortcode_atts['portfolio_masonry_layout'];
		}

		// Gutter
		if(isset($luv_shortcode_atts['portfolio_columns']) && $luv_shortcode_atts['portfolio_columns'] != 'one-column' && isset($luv_shortcode_atts['portfolio_masonry_layout']) && $luv_shortcode_atts['portfolio_masonry_layout'] != 'standard') {
			$luv_portfolio_container_classes[] = 'masonry-no-gap';
		}

		// Add margin if custom item padding is set
		if (_check_luvoption('portfolio-item-padding','','!=')){
			$luv_portfolio_container_classes[] = _luv_enqueue_inline_css(array('style' => 'margin-left:-' . _get_luvoption('portfolio-item-padding') . ' !important;' . 'margin-right:-' . _get_luvoption('portfolio-item-padding') . ' !important;'));
		}

		// Data for .portfolio-container
		$luv_portfolio_container_data = array();

		// Carousel
		if ($luv_shortcode_atts['luv_carousel'] == 'true'){
			$carousel_settings = array('infinite', 'nav', 'dots', 'autoplay', 'autoplay_timeout', 'autoplay_pause', 'transition_type', 'items', 'margin', 'parallax', 'full_height');
			foreach ($carousel_settings as $key){
				if (!empty($luv_shortcode_atts[$key])){
					$luv_portfolio_container_data[] = 'data-luv-carousel-' . $key . '="'.$luv_shortcode_atts[$key].'"';
				}
			}
		}

		// Data crop images (data-crop-images="")
		if(isset($luv_shortcode_atts['portfolio_masonry_crop_images']) && $luv_shortcode_atts['portfolio_masonry_crop_images'] == 'true') {
			$luv_portfolio_container_data[] = 'data-crop-images="true"';
		} else {
			$luv_portfolio_container_data[] = 'data-crop-images="false"';
		}

		// Background Check (data-bg-check="")
		if(isset($luv_shortcode_atts['portfolio_masonry_auto_text_color']) && $luv_shortcode_atts['portfolio_masonry_auto_text_color'] == 'true' && isset($luv_shortcode_atts['portfolio_masonry_layout']) && $luv_shortcode_atts['portfolio_masonry_layout'] == 'meta-overlay' && isset($luv_shortcode_atts['portfolio_masonry_hover_style']) && $luv_shortcode_atts['portfolio_masonry_hover_style'] != 'masonry-style-title-bottom') {
			$luv_portfolio_container_data[] = 'data-bg-check="true"';
		}

		// Automatic Metro Layout
		if ($luv_shortcode_atts['portfolio_automatic_metro_layout'] == 'true'){
			$fevr_masonry_size_overrides = array();

			switch ($luv_shortcode_atts['portfolio_columns']){
				case 'auto-columns':
					$columns = 5;
					break;
				case 'four-columns':
					$columns = 4;
					break;
				case 'three-columns':
					$columns = 3;
					break;
				case 'two-columns':
					$columns = 2;
					break;
				case 'one-column':
					$columns = 1;
					break;
			}
			$remand = (int)$portfolio_query->post_count % $columns;
			$count	= (int)$portfolio_query->post_count;

			if ($columns == 5 && $portfolio_query->post_count >= $columns){
				if ($remand == 0){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$portfolio_query->posts[2]->ID] = 'fevr_wide_tall';
				}
				else if ($remand == 1){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[5]->ID] = 'fevr_wide';
				}
				else if ($remand == 2){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide_tall';
					if ($count >= 8){
						$fevr_masonry_size_overrides[$portfolio_query->posts[3]->ID] = 'fevr_wide';
						$fevr_masonry_size_overrides[$portfolio_query->posts[5]->ID] = 'fevr_wide';
						$fevr_masonry_size_overrides[$portfolio_query->posts[4]->ID] = 'fevr_tall';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-2]->ID] = 'fevr_wide';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-5]->ID] = 'fevr_tall';
					}
				}
				else if ($remand == 3){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_wide';
					if ($count >= 8){
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-4]->ID] = 'fevr_tall';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-5]->ID] = 'fevr_tall';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-8]->ID] = 'fevr_wide_tall';
					}
				}
				else if ($remand == 4){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[5]->ID] = 'fevr_wide_tall';
				}
			}

			if ($columns == 4 && $portfolio_query->post_count >= $columns){
				if ($remand == 0){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_wide';
					if ($count >= 8){
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-1]->ID] = 'fevr_wide';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-3]->ID] = 'fevr_wide';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-4]->ID] = 'fevr_tall';
						$fevr_masonry_size_overrides[$portfolio_query->posts[$count-5]->ID] = 'fevr_tall';
					}
				}
				else if ($remand == 1){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[$count-2]->ID] = 'fevr_wide_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[$count-3]->ID] = 'fevr_tall';
				}
				else if ($remand == 2){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_wide';
				}
				else if ($remand == 3){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide';
				}
			}

			if ($columns == 3 && $portfolio_query->post_count >= $columns){
				if ($remand == 0){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide_tall';
				}
				else if ($remand == 1){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_tall';
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_wide';
				}
				else if ($remand == 2){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide';
				}
			}

			if ($columns == 2 && $portfolio_query->post_count >= $columns){
				if ($remand == 0){
					$fevr_masonry_size_overrides[$portfolio_query->posts[0]->ID] = 'fevr_wide';
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_tall';
				}
				else if ($remand == 1){
					$fevr_masonry_size_overrides[$portfolio_query->posts[1]->ID] = 'fevr_wide';
				}
			}
		}

		?>


					<?php
						// Enable Masonry Filter
						if(isset($luv_shortcode_atts['portfolio_masonry_filter']) && $luv_shortcode_atts['portfolio_masonry_filter'] == 'true') {
							$this->get_template_part( 'luvthemes/luv-templates/masonry-filter' );
						}
					?>

					<div class="portfolio-container <?php echo implode(' ', $luv_portfolio_container_classes); ?>" <?php echo implode(' ', $luv_portfolio_container_data); ?>>

					<?php
						if ( $portfolio_query->have_posts() ) :
							while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
							global $fevr_meta_fields;
							$fevr_meta_fields = get_post_meta( get_the_ID(), 'fevr_meta', true);

							// Automatic Metro Layout
							if ($luv_shortcode_atts['portfolio_automatic_metro_layout'] == 'true'){
								if (isset($fevr_masonry_size_overrides[get_the_ID()])){
									$fevr_meta_fields['portfolio-masonry-size'] = $fevr_masonry_size_overrides[get_the_ID()];
								}
								else{
									$fevr_meta_fields['portfolio-masonry-size'] = 'fevr_normal';
								}
							}

							// Article classes
							$luv_article_classes = array();

							// Set masonry size
							if (isset($fevr_meta_fields['portfolio-masonry-size']) && !empty($fevr_meta_fields['portfolio-masonry-size']) &&
								isset($luv_shortcode_atts['portfolio_masonry_layout']) && $luv_shortcode_atts['portfolio_masonry_layout'] == 'meta-overlay')
							{
								$luv_article_classes[] = 'masonry-size-'.$fevr_meta_fields['portfolio-masonry-size'];
							}
							else {
								$luv_article_classes[] = 'masonry-size-fevr_normal';
							}

							// When masonry is active without custom content we display the style for the hover effect. If we have custom content and the style is still masonry we add a helper class to disable the effects
							if (isset($luv_shortcode_atts['portfolio_masonry_hover_style']) && !empty($luv_shortcode_atts['portfolio_masonry_hover_style']) &&
								isset($luv_shortcode_atts['portfolio_masonry_layout']) && $luv_shortcode_atts['portfolio_masonry_layout'] == 'meta-overlay' &&
								(!isset($fevr_meta_fields['portfolio_masonry_show_content']) || $fevr_meta_fields['portfolio_masonry_show_content'] != 'enabled'))
							{
								$luv_article_classes[] = $luv_shortcode_atts['portfolio_masonry_hover_style'];
							}
							else if(isset($luv_shortcode_atts['portfolio_masonry_layout']) && $luv_shortcode_atts['portfolio_masonry_layout'] == 'meta-overlay' &&
								isset($fevr_meta_fields['portfolio_masonry_show_content']) && $fevr_meta_fields['portfolio_masonry_show_content'] == 'enabled')
							{
								$luv_article_classes[] = 'masonry-custom-content';
							}

							// Masonry Overlay Icon
							if (!empty($luv_shortcode_atts['portfolio_masonry_overlay_icon'])){
								$fevr_meta_fields['portfolio-masonry-overlay-icon'] = $luv_shortcode_atts['portfolio_masonry_overlay_icon'];
							}

							// Animation
							if(!empty($luv_shortcode_atts['portfolio_animation'])){
								$luv_article_classes[] = 'c-has-animation ' . $luv_shortcode_atts['portfolio_animation'];
							}

							// Carousel
							if($luv_shortcode_atts['luv_carousel'] == 'true' && empty($luv_shortcode_atts['portfolio_animation'])) {
								$luv_article_classes[] = 'appended-item';
							}

							// Override text and background colors
							if ($luv_shortcode_atts['portfolio_override_colors'] == 'true'){
								if (!empty($luv_shortcode_atts['portfolio_override_accent_color'])){
									$fevr_meta_fields['portfolio-masonry-auto-text-color'] = 0;
									$fevr_meta_fields['portfolio-masonry-accent-color'] = $luv_shortcode_atts['portfolio_override_accent_color'];
								}
								if (!empty($luv_shortcode_atts['portfolio_override_text_color'])){
									$fevr_meta_fields['portfolio-masonry-text-color'] = $luv_shortcode_atts['portfolio_override_text_color'];
								}
							}

							// Override position
							if ($luv_shortcode_atts['portfolio_override_position'] == 'true'){
								if (!empty($luv_shortcode_atts['portfolio_override_horizontal_position'])){
									$fevr_meta_fields['portfolio-masonry-h-text-alignment'] = $luv_shortcode_atts['portfolio_override_horizontal_position'];
								}
								if (!empty($luv_shortcode_atts['portfolio_override_vertical_position'])){
									$fevr_meta_fields['portfolio-masonry-v-text-alignment'] = $luv_shortcode_atts['portfolio_override_vertical_position'];
								}
							}

					?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $luv_article_classes)); ?>>
							<?php $this->get_template_part( 'luvthemes/post-templates/portfolio' ); ?>
						</article>
					<?php
							endwhile;

						else:
							esc_html_e('No posts were found', 'fevr');
						endif;
					?>
					</div>

		<?php

		// Under content navigaiton
		if (!empty($luv_shortcode_atts['portfolio_pagination']) && $luv_shortcode_atts['portfolio_pagination_position'] == 'under-content' || $luv_shortcode_atts['portfolio_pagination_position'] == 'both'){
			$this->shortcode_pagination($portfolio_query, $luv_shortcode_atts);
		}

		wp_reset_postdata();
		luv_core_reset_fevr_options();
		luv_core_reset_fevr_meta();

		return apply_filters('luv_portfolio_shortcode', ob_get_clean(), $atts);
	}

	/**
	 * Collection shortcode
	 * @param array $atts
	 * @return string
	 */
	public function collection_shortcode( $atts ) {
		$luv_shortcode_atts = shortcode_atts( array(
				'woocommerce_collections_columns' => 'two-columns',
				'woocommerce_collections_masonry_hover_style' => 'masonry-style-zoom',
				'woocommerce_collections_masonry_overlay_icon' => '',
				'woocommerce_collections_override_colors' => 'false',
				'woocommerce_collections_override_accent_color' => '',
				'woocommerce_collections_override_text_color' => '',
				'woocommerce_collections_likes_meta' => 'false',
				'woocommerce_collections_posts_per_page' => '',
				'woocommerce_collections_order' => 'newest',
				'woocommerce_collections_pagination'	=> '',
				'woocommerce_collections_pagination_position' => 'under-content',
				'woocommerce_collections_orderby' => 'newest',
				'luv_carousel' => 'false',
				'infinite' => 'false',
				'nav' => 'false',
				'dots' => 'false',
				'autoplay' => 'false',
				'autoplay_timeout' => '5000',
				'autoplay_pause' => 'false',
				'transition_type' => '',
				'items' => "{'desktop':'1','laptop':'1','tablet-landscape':'1','tablet-portrait':'1','mobile':'1',}",
				'margin' => '',
				'parallax' => 'false',
				'full_height' => 'false',
				'title_font_family' => '',
				'title_font_size' => '',
				'title_responsive_font_size' => '',
				'title_text_transform' => '',
				'title_font_weight' => '',
				'title_font_color' => '',
		), $atts, 'luv_collections' );

		// Enqueue tilt.js if perspective hover animation is in use
		if($luv_shortcode_atts['woocommerce_collections_masonry_hover_style'] == 'masonry-perspective') {
			wp_enqueue_script('tilt', LUVTHEMES_CORE_URI.'assets/js/min/tilt-min.js', array(), LUVTHEMES_CORE_VER);
		}

		// Convert shortcode atts to be compatible with templates
		$luv_shortcode_atts['woocommerce_collections_likes_meta'] = ($luv_shortcode_atts['woocommerce_collections_likes_meta'] == 'true' ? 'hide-on-archive' : '');

		global $fevr_collections_title_typography_classes;
		$fevr_collections_title_typography_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_collections_title', array(
				'font_family' => $luv_shortcode_atts['title_font_family'],
				'font_size' => $luv_shortcode_atts['title_font_size'],
				'responsive_font_size' => $luv_shortcode_atts['title_responsive_font_size'],
				'font_weight' => $luv_shortcode_atts['title_font_weight'],
				'text_transform' => $luv_shortcode_atts['title_text_transform'],
				'font_color' => $luv_shortcode_atts['title_font_color'],
		));

		global $luv_collection_shortcode_atts;
		$luv_collection_shortcode_atts = $luv_shortcode_atts;

		global $is_luv_shortcode;
		$is_luv_shortcode = true;

		global $luv_shortcode_post_type;
		$luv_shortcode_post_type= 'luv_collection';

		/*
		 * Collection Query
		 */

		// Paged
		global $wp_query;
		$paged = (isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 0);

		// Order by
		switch($luv_shortcode_atts['woocommerce_collections_orderby']){
			case 'oldest':
				$orderby = array(
				'orderby' => 'date',
				'order'   => 'ASC',
				);
				break;
			case 'a-z':
				$orderby = array(
				'orderby' => 'title',
				'order'   => 'ASC',
				);
				break;
			case 'z-a':
				$orderby = array(
				'orderby' => 'title',
				'order'   => 'DESC',
				);
				break;
			case 'newest':
			default:
				$orderby = array();
				break;
		}

		$collection_args = array_merge(array(
				'post_type' => 'luv_collections',
				'posts_per_page' => $luv_shortcode_atts['woocommerce_collections_posts_per_page'],
				'paged'	=> !empty($paged) ? $paged : 1
		), $orderby);

		$collection_query = new WP_Query( $collection_args );

		ob_start();

		// Use shortcode settings instead global fevr_options
		luv_core_set_fevr_options($luv_shortcode_atts);

		//Backup meta fields
		luv_core_backup_fevr_meta();

		// Before content navigaiton
		if (!empty($luv_shortcode_atts['woocommerce_collections_pagination']) && $luv_shortcode_atts['woocommerce_collections_pagination_position'] == 'above-content' || $luv_shortcode_atts['woocommerce_collections_pagination_position'] == 'both'){
			$this->shortcode_pagination($collection_query, $luv_shortcode_atts);
		}

		// Classes for .collections-container
		$luv_collections_container_classes = array();

		// Carousel
		if($luv_shortcode_atts['luv_carousel'] == 'true') {
			wp_enqueue_script( 'fevr-owlcarousel' );
			$luv_collections_container_classes[] = 'luv-carousel masonry-meta-overlay';
		}

		// Columns
		if($luv_shortcode_atts['woocommerce_collections_columns'] != 'one-column' && $luv_shortcode_atts['luv_carousel'] != 'true') {
			$luv_collections_container_classes[] = $luv_shortcode_atts['woocommerce_collections_columns'].' masonry masonry-meta-overlay';
		}

		// Data for .collections-container
		$luv_collections_container_data = array();

		// Carousel
		if ($luv_shortcode_atts['luv_carousel'] == 'true'){
			$carousel_settings = array('infinite', 'nav', 'dots', 'autoplay', 'autoplay_timeout', 'autoplay_pause', 'transition_type', 'items', 'margin', 'parallax', 'full_height');
			foreach ($carousel_settings as $key){
				if (!empty($luv_shortcode_atts[$key])){
					$luv_collections_container_data[] = 'data-luv-carousel-' . $key . '="'.$luv_shortcode_atts[$key].'"';
				}
			}
		}
		?>

			<div class="collections-container item-grid-container <?php echo implode(' ', $luv_collections_container_classes); ?>" <?php echo implode(' ', $luv_collections_container_data)?>>
			<?php
				if ( $collection_query->have_posts() ) :
					while ( $collection_query->have_posts() ) : $collection_query->the_post();
					global $fevr_meta_fields;
					$fevr_meta_fields = get_post_meta( get_the_ID(), 'fevr_meta', true);

					// Article classes
					$luv_article_classes = array();

					// Hover effect style
					if(!empty($luv_shortcode_atts['woocommerce_collections_masonry_hover_style'])) {
						$luv_article_classes[] = $luv_shortcode_atts['woocommerce_collections_masonry_hover_style'];
					}

					// Masonry Overlay Icon
					if (!empty($luv_shortcode_atts['woocommerce_collections_masonry_overlay_icon'])){
						$fevr_meta_fields['collections-masonry-overlay-icon'] = $luv_shortcode_atts['woocommerce_collections_masonry_overlay_icon'];
					}

					// Animation
					if(!empty($luv_shortcode_atts['woocommerce_collections_animation'])){
						$luv_article_classes[] = 'c-has-animation ' . $luv_shortcode_atts['woocommerce_collections_animation'];
					}

					// Carousel
					if($luv_shortcode_atts['luv_carousel'] == 'true' && empty($luv_shortcode_atts['woocommerce_collections_animation'])) {
						$luv_article_classes[] = 'appended-item';
					}

					// Override text and background colors
					if ($luv_shortcode_atts['woocommerce_collections_override_colors'] == 'true'){
						if (!empty($luv_shortcode_atts['woocommerce_collections_override_accent_color'])){
							$fevr_meta_fields['collections-masonry-accent-color'] = $luv_shortcode_atts['woocommerce_collections_override_accent_color'];
						}
						if (!empty($luv_shortcode_atts['woocommerce_collections_override_text_color'])){
							$fevr_meta_fields['collections-masonry-text-color'] = $luv_shortcode_atts['woocommerce_collections_override_text_color'];
						}
					}

			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $luv_article_classes)); ?>>
					<?php $this->get_template_part( 'luvthemes/post-templates/collections' ); ?>
				</article>
			<?php
					endwhile;

				else:
					esc_html_e('No posts were found', 'fevr');
				endif;
			?>
			</div>
		<?php

		// Under content navigaiton
		if (!empty($luv_shortcode_atts['woocommerce_collections_pagination']) && $luv_shortcode_atts['woocommerce_collections_pagination_position'] == 'under-content' || $luv_shortcode_atts['woocommerce_collections_pagination_position'] == 'both'){
			$this->shortcode_pagination($collection_query, $luv_shortcode_atts);
		}

		wp_reset_postdata();
		luv_core_reset_fevr_options();
		luv_core_reset_fevr_meta();

		return apply_filters('luv_collection_shortcode', ob_get_clean(), $atts);
	}

	public function reviews_shortcode( $atts ) {
		$luv_shortcode_atts = shortcode_atts( array(
				'woocommerce_photo_reviews_columns' => 'two-columns',
				'woocommerce_photo_reviews_masonry_hover_style' => 'masonry-style-zoom',
				'woocommerce_photo_reviews_rating' => 'false',
				'woocommerce_photo_reviews_likes_meta' => 'false',
				'woocommerce_photo_reviews_posts_per_page' => '',
				'woocommerce_photo_reviews_pagination'	=> '',
				'woocommerce_photo_reviews_orderby' => 'newest',
				'woocommerce_photo_reviews_pagination_position' => 'under-content',
				'woocommerce_photo_reviews_animation' => '',
				'luv_carousel' => 'false',
				'infinite' => 'false',
				'nav' => 'false',
				'dots' => 'false',
				'autoplay' => 'false',
				'autoplay_timeout' => '5000',
				'autoplay_pause' => 'false',
				'transition_type' => '',
				'items' => "{'desktop':'1','laptop':'1','tablet-landscape':'1','tablet-portrait':'1','mobile':'1',}",
				'margin' => '',
				'parallax' => 'false',
				'full_height' => 'false',
				'title_font_family' => '',
				'title_font_size' => '',
				'title_responsive_font_size' => '',
				'title_text_transform' => '',
				'title_font_weight' => '',
				'title_font_color' => '',
		), $atts, 'luv_reviews' );

		wp_enqueue_script( 'fevr-owlcarousel' );

		// Convert shortcode atts to be compatible with templates
		$luv_shortcode_atts['woocommerce_photo_reviews_likes_meta'] = ($luv_shortcode_atts['woocommerce_photo_reviews_likes_meta'] == 'true' ? 'hide-on-archive' : '');

		global $fevr_reviews_title_typography_classes;
		$fevr_reviews_title_typography_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_reviews_title', array(
				'font_family' => $luv_shortcode_atts['title_font_family'],
				'font_size' => $luv_shortcode_atts['title_font_size'],
				'responsive_font_size' => $luv_shortcode_atts['title_responsive_font_size'],
				'font_weight' => $luv_shortcode_atts['title_font_weight'],
				'text_transform' => $luv_shortcode_atts['title_text_transform'],
				'font_color' => $luv_shortcode_atts['title_font_color'],
		));

		global $luv_collection_shortcode_atts;
		$luv_collection_shortcode_atts = $luv_shortcode_atts;

		global $is_luv_shortcode;
		$is_luv_shortcode = true;

		global $luv_shortcode_post_type;
		$luv_shortcode_post_type= 'luv_collection';

		/*
		 * Reviews Query
		 */

		// Paged
		global $wp_query;
		$paged = (isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 0);

		// Order by
		// Order by
		switch($luv_shortcode_atts['woocommerce_photo_reviews_orderby']){
			case 'oldest':
				$orderby = array(
				'orderby' => 'date',
				'order'   => 'ASC',
				);
				break;
			case 'a-z':
				$orderby = array(
				'orderby' => 'title',
				'order'   => 'ASC',
				);
				break;
			case 'z-a':
				$orderby = array(
				'orderby' => 'title',
				'order'   => 'DESC',
				);
				break;
			case 'newest':
			default:
				$orderby = array();
				break;
		}

		$collection_args = array_merge(array(
				'post_type' => 'luv_ext_reviews',
				'posts_per_page' => $luv_shortcode_atts['woocommerce_photo_reviews_posts_per_page'],
				'paged'	=> !empty($paged) ? $paged : 1
		), $orderby);

		$reviews_query = new WP_Query( $collection_args );

		ob_start();

		// Use shortcode settings instead global fevr_options
		luv_core_set_fevr_options($luv_shortcode_atts);

		//Backup meta fields
		luv_core_backup_fevr_meta();

		// Before content navigaiton
		if (!empty($luv_shortcode_atts['woocommerce_photo_reviews_pagination']) && $luv_shortcode_atts['woocommerce_photo_reviews_pagination_position'] == 'above-content' || $luv_shortcode_atts['woocommerce_photo_reviews_pagination_position'] == 'both'){
			$this->shortcode_pagination($reviews_query, $luv_shortcode_atts);
		}

		// Classes for .photo-reviews-container
		$luv_reviews_container_classes = array();

		// Carousel
		if($luv_shortcode_atts['luv_carousel'] == 'true') {
			$luv_reviews_container_classes[] = 'luv-carousel';
		}

		// Columns
		if($luv_shortcode_atts['woocommerce_photo_reviews_columns'] != 'one-column' && $luv_shortcode_atts['luv_carousel'] != 'true') {
			$luv_reviews_container_classes[] = $luv_shortcode_atts['woocommerce_photo_reviews_columns'].' masonry';
		}


		// Data for .reviews-container
		$luv_reviews_container_data = array();

		// Carousel
		if ($luv_shortcode_atts['luv_carousel'] == 'true'){
			$carousel_settings = array('infinite', 'nav', 'dots', 'autoplay', 'autoplay_timeout', 'autoplay_pause', 'transition_type', 'items', 'margin', 'parallax', 'full_height');
			foreach ($carousel_settings as $key){
				if (!empty($luv_shortcode_atts[$key])){
					$luv_reviews_container_data[] = 'data-luv-carousel-' . $key . '="'.$luv_shortcode_atts[$key].'"';
				}
			}
		}
		?>

				<div class="photo-reviews-container item-grid-container <?php echo implode(' ', $luv_reviews_container_classes); ?>" <?php echo implode(' ', $luv_reviews_container_data)?>>
				<?php
					if ( $reviews_query->have_posts() ) :
						while ( $reviews_query->have_posts() ) : $reviews_query->the_post();

					// Animation
					$luv_article_classes = array();
					if(!empty($luv_shortcode_atts['woocommerce_photo_reviews_animation'])){
						$luv_article_classes[] = 'c-has-animation ' . $luv_shortcode_atts['woocommerce_photo_reviews_animation'];
					}

					// Carousel
					if($luv_shortcode_atts['luv_carousel'] == 'true' && empty($luv_shortcode_atts['woocommerce_photo_reviews_animation'])) {
						$luv_article_classes[] = 'appended-item';
					}
				?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(implode(' ', $luv_article_classes)); ?>>
						<?php $this->get_template_part( 'luvthemes/post-templates/photo-reviews' ); ?>
					</article>
				<?php
						endwhile;
					else:
						esc_html_e('No posts were found', 'fevr');
					endif;
				?>
				</div>
		<?php

		// Under content navigaiton
		if (!empty($luv_shortcode_atts['woocommerce_photo_reviews_pagination']) && $luv_shortcode_atts['woocommerce_photo_reviews_pagination_position'] == 'under-content' || $luv_shortcode_atts['woocommerce_photo_reviews_pagination_position'] == 'both'){
			$this->shortcode_pagination($reviews_query, $luv_shortcode_atts);
		}

		wp_reset_postdata();
		luv_core_reset_fevr_options();
		luv_core_reset_fevr_meta();

		return apply_filters('luv_photo_reviews_shortcode', ob_get_clean(), $atts);
	}

	/**
	 * Before-After Image Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function before_after_shortcode($atts, $content = '') {
		// Enqueue TwentyTwenty
		wp_enqueue_script('event-move', LUVTHEMES_CORE_URI . 'assets/js/jquery.event.move.js', array('jquery'), LUVTHEMES_CORE_VER, true);
		wp_enqueue_script('twentytwenty', LUVTHEMES_CORE_URI . 'assets/js/jquery.twentytwenty.js', array('jquery'), LUVTHEMES_CORE_VER, true);
		_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/twentytwenty.css');

		$before_after_atts = shortcode_atts ( array (
				'before' => '',
				'after' => '',
		), $atts, 'luv_before_after' );

		return  apply_filters('luv_before_after_shortcode', '<div class="luv-before-after">'.
 				wp_get_attachment_image($before_after_atts ['before'], 'full').
 				wp_get_attachment_image($before_after_atts ['after'], 'full').
				'</div>', $atts);
	}

	/**
	 * Slider Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function slider_shortcode($atts) {
		global $fevr_slider_atts;

		wp_enqueue_script( 'fevr-owlcarousel' );

		$fevr_slider_atts = shortcode_atts( array(
				'id' => '',
		), $atts, 'luv_slider' );

		ob_start();

		$this->get_template_part('luvthemes/luv-templates/slider');

		return apply_filters('luv_slider_shortcode', ob_get_clean(), $atts);
	}

	/**
	 * Snippet Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function snippet_shortcode($atts) {
		$atts = shortcode_atts( array(
				'id' => '0',
				'lazyload' => 'false'
		), $atts, 'luv_snippet' );

		if ($atts['lazyload'] == 'true'){
			return apply_filters('luv_snippet_shortcode', '<div class="luv-lazy-snippet" data-snippet="'.esc_attr($atts['id']).'"></div>', $atts);
		}

		$html = '';

		if(is_numeric($atts['id'])) {
			$id = $atts['id'];
		} else {
			global $wpdb;
			$id = $wpdb->get_var($wpdb->prepare('SELECT ID FROM ' . $wpdb->posts . ' WHERE post_name = %s AND post_type = "luv_snippets" LIMIT 1', $atts['id']));
		}

		if (function_exists('icl_object_id')){
			$id = icl_object_id($id, 'luv_snippets', true);
		}

		if (get_the_ID() != $id && !empty($id)){
			$snippet = get_post($id);
			// Add VC custom css
			$vc_css = get_post_meta($id, '_wpb_post_custom_css', true);
			$vc_css .= get_post_meta($id, '_wpb_shortcodes_custom_css', true);
			_luv_late_add_header_style($vc_css);
			$html = apply_filters('the_content', $snippet->post_content);
		}

		return apply_filters('luv_snippet_shortcode', $html, $atts);
	}

	/**
	 * Carousel Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function carousel_shortcode($atts, $content = '') {
		// Enqueue Owl Carousel
		wp_enqueue_script('fevr-owlcarousel', LUVTHEMES_CORE_URI . 'assets/js/min/owl.carousel.min.js', array('jquery'), LUVTHEMES_CORE_VER, true);

		$luv_carousel_atts = shortcode_atts ( array (
				'infinite' => 'false',
				'nav' => 'false',
				'dots' => 'false',
				'autoplay' => 'false',
				'autoplay_timeout' => '5000',
				'autoplay_pause' => 'false',
				'transition_type' => '',
				'items' => "{'desktop':'1','laptop':'1','tablet-landscape':'1','tablet-portrait':'1','mobile':'1',}",
				'margin' => '',
				'parallax' => 'false',
				'full_height' => 'false',
				'same_height' => 'false',
				'vertical_alignment' => 'middle'
		), $atts, 'luv_carousel' );

		$data = $classes = array ();
		foreach ( $luv_carousel_atts as $key => $value ) {
			if (!empty( $value )) {
				$data [] = 'data-luv-carousel-' . $key . '="' . $value . '"';
			}
		}

		if ($luv_carousel_atts['full_height'] == 'true'){
			$wrapper_s = '<div class="luv-carousel-wrapper">';
			$wrapper_e = '</div>';
		}
		else{
			$wrapper_s = $wrapper_e = '';
		}

		if ($luv_carousel_atts['same_height'] == 'true'){
			$classes[]	= 'luv-same-height';
			$data[]		= 'data-vertical-alignment="' . $luv_carousel_atts['vertical_alignment'] . '"';
		}

		$html = do_shortcode ( $wrapper_s . '<ul class="luv-carousel '.implode(' ', $classes).'" ' . implode ( ' ', $data ) . '>' . $content . '</ul>' . $wrapper_e );
		return apply_filters('luv_carousel_shortcode', $html, $atts, $content);
	}

	/**
	 * Display carousel slide
	 * @param $atts array
	 * @param $content string
	 * @return string
	 */
	public function carousel_slide_shortcode($atts, $content = ''){
		$css_classes = array();

		if (!empty($atts['css'])){
			$css_classes[] = esc_attr( trim( vc_shortcode_custom_css_class( $atts['css'] ) ) );
		}

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), 'luv_carousel_slide', $atts );
		$html = do_shortcode('<li class="'.$classes.'">' . do_shortcode($content) . '</li>');
		return apply_filters('luv_carousel_slide_shortcode', $html, $atts, $content);
	}

	/**
	 * Display video slide
	 * @param $atts array
	 * @param $content string
	 * @return string
	 */
	public function video_shortcode($atts, $content = ''){
		$video_atts = shortcode_atts ( array (
				'video' 			=> '',
				'width' 			=> '100%',
				'video_autoplay'	=> 'false',
				'video_loop'		=> 'false',
				'video_mute'		=> 'false',
				'video_controls'	=> 'false'
		), $atts, 'luv_video' );

		// Attributes for <video>
		$video_attributes = array();

		// Autoplay
		if($video_atts['video_autoplay'] == 'true') {
			$video_attributes[] = 'autoplay';
		}

		// Loop
		if($video_atts['video_loop'] == 'true') {
			$video_attributes[] = 'loop';
		}

		// Mute
		if($video_atts['video_mute'] == 'true') {
			$video_attributes[] = 'muted';
		}

		// Controls
		if($video_atts['video_controls'] == 'true') {
			$video_attributes[] = 'controls';
		}

		$html = '<video preload="auto" playsinline webkit-playsinline '. implode(' ', $video_attributes).' width="'.esc_attr($video_atts['width']).'">'.
					'<source src="'.esc_url($video_atts['video']).'">'.
					esc_html__('Your browser does not support the video tag.', 'fevr').
				'</video>';

		return apply_filters('luv_video_shortcode', $html, $atts, $content);

	}

	/**
	 * Display tab shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function tab_shortcode($atts, $content = '') {
		global $luv_tab_shortcode_tabs;
		$luv_tab_shortcode_tabs = array ();

		$luv_tabs_atts = shortcode_atts ( array (
				'layout' => 'default',
				'color_scheme' => 'default',
				'color' => ''
		), $atts, 'luv_tabs' );

		$custom_color = ($luv_tabs_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($luv_tabs_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$luv_tabs_atts['color'] = _get_luvoption($luv_tabs_atts['color_scheme']);
		}

		$layout = $luv_tabs_atts ['layout'] != 'default' ? ' luv-tabs-' . $luv_tabs_atts ['layout'] : '';

		$classes = array ();
		if ($custom_color && !empty( $luv_tabs_atts ['color'] )) {
			$classes[] = _luv_enqueue_inline_css ( array (
					'child' => array (
							' a:hover' => 'color:' . $luv_tabs_atts ['color'] . ' !important',
							' li.active-tab' => 'border-color:' . $luv_tabs_atts ['color'] . ' !important',
							' li.active-tab a' => 'color:' . $luv_tabs_atts ['color'] . ' !important'
					)
			) );
		}

		$tabs = do_shortcode ( $content );

		$nav = '';
		foreach ( $luv_tab_shortcode_tabs as $key => $tab ) {
			$nav .= '<li' . ($key == 0 ? ' class="active-tab"' : '') . '><a href="#luv-tab' . ($key + 1) . '">' . $tab . '</a></li>';
		}

		$html = '<div class="luv-tabs' . $layout . ' ' . implode ( ' ', $classes ) . '">' . '<ul class="luv-tabs-nav">' . $nav . '</ul>' . $tabs . '</div>	';

		return apply_filters('luv_tab_shortcode', $html, $atts, $content);

	}


	/**
	 * Tab shortcode inner
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function tab_inner_shortcode($atts, $content = '') {
		global $luv_tab_shortcode_tabs;
		$luv_tab_inner_atts = shortcode_atts ( array (
				'heading' => '',
				'title' => '',
				'icon' => '',
		), $atts, 'luv_tab_inner' );

		$classes = array();

		//Icon
		if ($luv_tab_inner_atts['heading'] == 'icon'){
			$classes[] = 'has-icon';
			$title = $this->icon_shortcode(array('icon' => $luv_tab_inner_atts['icon']));
		}
		else{
			$title = $luv_tab_inner_atts['title'];
		}

		// Select first tab
		if(count ( $luv_tab_shortcode_tabs ) == 0){
			$classes[] = 'active-content';
		}

		$luv_tab_shortcode_tabs[] = $title;
		$content = do_shortcode ( $content );
		$html = '<div class="luv-tab' . count ( $luv_tab_shortcode_tabs ) . ' luv-tabs-content ' . implode(' ', $classes) . '">' . do_shortcode($content) . '</div>';

		return apply_filters('luv_tab_inner_shortcode', $html, $atts, $content);
	}

	/**
	 * Display accordion shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 *
	 */
	public function accordion_shortcode($atts, $content = '') {
		global $luv_accordion_atts, $luv_accordion_titles, $luv_enqueued_inline_fonts;
		$luv_accordion_atts = shortcode_atts ( array (
				'color_scheme' => 'default',
				'title_color' => '',
				'title_background_color' => '',
				'active_title_color' => '',
				'active_title_background_color' => '',
				'title_font_family' => '',
				'title_font_size' => '',
				'title_responsive_font_size' => '',
				'title_font_weight' => '',
				'title_text_transform' => '',
				'icon' => '',
				'active_icon' => '',
				'text_color' => '',
				'text_background_color' => '',
				'text_font_family' => '',
		), $atts, 'luv_accordion' );

		$classes = array ();
		$luv_accordion_titles = array ();

		// Custom color
		$custom_color = ($luv_accordion_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($luv_accordion_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$luv_accordion_atts['active_title_background_color'] = _get_luvoption($luv_accordion_atts['color_scheme']);
			$luv_accordion_atts['active_title_color'] = _luv_adjust_color_scheme(_get_luvoption($luv_accordion_atts['color_scheme']));
		}

		$styles[' li.luv-accordion-item.accordion-item-active > a'] = '';
		$styles[' li.luv-accordion-item > a'] = '';
		$styles[' .accordion-icon-default'] = '';
		$styles[' .accordion-icon-active'] = '';
		$styles[' .luv-accordion-item > a::after'] = '';
		$styles[' .luv-accordion-item.accordion-item-active > a::after'] = '';
		$styles[' li.luv-accordion-item .luv-accordion-content'] = '';

		// Custom icon
		if (!empty($luv_accordion_atts['icon']) || !empty($luv_accordion_atts['active_icon'])){
			$classes[] =  'luv-accordion-custom-icon';
		}

		// Title styles
		if (!empty($luv_accordion_atts['title_background_color'])) {
			$styles[' li.luv-accordion-item > a'] .= 'background-color:' . $luv_accordion_atts['title_background_color'] . ' !important;';
		}
		if (!empty($luv_accordion_atts['title_color'])) {
			$styles[' li.luv-accordion-item > a']			.= 'color:' . $luv_accordion_atts['title_color'] . ' !important;';
			$styles[' .accordion-icon-default'] 		.= 'color:' . $luv_accordion_atts['title_color'] . ' !important;';
			$styles[' .luv-accordion-item > a::after']	.= 'color:' . $luv_accordion_atts['title_color'] . ' !important;';
		}
		if (!empty($luv_accordion_atts['active_title_background_color'])) {
			$styles[' li.luv-accordion-item.accordion-item-active > a'] .= 'background-color:' . $luv_accordion_atts['active_title_background_color'] . ' !important;';
		}
		if (!empty($luv_accordion_atts['active_title_color'])) {
			$styles[' li.luv-accordion-item.accordion-item-active > a']		.= 'color:' . $luv_accordion_atts['active_title_color'] . ' !important;';
			$styles[' .accordion-icon-active'] 								.= 'color:' . $luv_accordion_atts['active_title_color'] . ' !important;';
			$styles[' .luv-accordion-item.accordion-item-active > a::after']	.= 'color:' . $luv_accordion_atts['active_title_color'] . ' !important;';
		}
		if (!empty($luv_accordion_atts['title_font_family'])){
			$luv_enqueued_inline_fonts[$luv_accordion_atts['title_font_family']]['regular'] = 'regular';
			$styles[' li.luv-accordion-item > a'] .= 'font-family:' . $luv_accordion_atts['title_font_family'] . ' !important;';
		}

		// Text styles
		if (!empty($luv_accordion_atts['text_background_color'])) {
			$styles[' li.luv-accordion-item .luv-accordion-content'] .= 'background-color:' . $luv_accordion_atts['text_background_color'] . ' !important;';
		}
		if (!empty($luv_accordion_atts['text_color'])) {
			$styles[' li.luv-accordion-item .luv-accordion-content'] .= 'color:' . $luv_accordion_atts['text_color'] . ' !important;';
		}
		if (!empty($luv_accordion_atts['text_font_family'])){
			$luv_enqueued_inline_fonts[$luv_accordion_atts['text_font_family']]['regular'] = 'regular';
			$styles[' li.luv-accordion-item .luv-accordion-content'] .= 'font-family:' . $luv_accordion_atts['text_font_family'] . ' !important;';
		}

		$classes[] = _luv_enqueue_inline_css ( array (
				'child' => $styles
		));

		$html = '<div class="luv-accordion ' . (!empty( $classes ) ? ' ' . implode(' ', $classes) : '') . '"><ul class="luv-accordion-items">' . do_shortcode ( $content ) . '</ul></div>';

		return apply_filters('luv_accordion_shortcode', $html, $atts, $content);
	}

	/**
	 * Accordion shortcode inner
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 *
	 */
	public function accordion_inner_shortcode($atts, $content = '') {
		global $luv_accordion_titles, $luv_accordion_atts;
		$luv_accordion_inner_atts = shortcode_atts ( array (
				'title' => ''
		), $atts, 'luv_accordion_inner' );

		$icon = '';
		$child_classes = array();
		if (!empty($luv_accordion_atts['icon']) || !empty($luv_accordion_atts['active_icon'])){
			// Late enqueue ionicons
			if (preg_match ( '~ion-~', $luv_accordion_atts ['icon'] ) || preg_match ( '~ion-~', $luv_accordion_atts ['active_icon'] )) {
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/ionicons.min.css');
			}
			else if (preg_match ( '~linea-~', $luv_accordion_atts ['icon'] ) || preg_match ( '~linea-~', $luv_accordion_atts ['active_icon'] )) {
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/linea-icons.css');
			}

			if (empty($luv_accordion_atts ['icon'])){
				$luv_accordion_atts ['icon'] = $luv_accordion_atts ['active_icon'];
			}
			else if (empty($luv_accordion_atts ['active_icon'])){
				$luv_accordion_atts ['active_icon'] = $luv_accordion_atts ['icon'];
			}

			$icon = '<i class="accordion-icon-default ' . $luv_accordion_atts ['icon'] . '"></i><i class="accordion-icon-active ' . $luv_accordion_atts ['active_icon'] . '"></i>';
		}

		$title_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_accordion_inner', array(
				'font_family' => isset($luv_accordion_atts['title_font_family']) ? $luv_accordion_atts['title_font_family'] : '',
				'font_size' => isset($luv_accordion_atts['title_font_size']) ? $luv_accordion_atts['title_font_size'] : '',
				'responsive_font_size' => isset($luv_accordion_atts['title_responsive_font_size']) ? $luv_accordion_atts['title_responsive_font_size'] : '',
				'font_weight' => isset($luv_accordion_atts['title_font_weight']) ? $luv_accordion_atts['title_font_weight'] : '',
				'text_transform' => isset($luv_accordion_atts['title_text_transform']) ? $luv_accordion_atts['title_text_transform'] : '',
		));

		$luv_accordion_titles[] = $luv_accordion_inner_atts['title'];
		$html = '<li class="luv-accordion-item' . (count ( $luv_accordion_titles ) == 1 ? ' accordion-item-active' : '') . '"><a class="luv-accordion-title '.$title_classes.'" href="#luv-accordion' . count ( $luv_accordion_titles ) . '">' . end ( $luv_accordion_titles ) . $icon . '</a><div class="luv-accordion-content luv-accordion' . count ( $luv_accordion_titles ) . ' ' . (count ( $luv_accordion_titles ) == 1 ? ' ' . _luv_enqueue_inline_css ( array (
				'parent' => 'html .luv-accordion .luv-accordion-item .luv-accordion-content',
				'style' => 'display:block;',
				'child' => array(' .luv-slider-wrapper' => 'min-height:1px;height:auto;')
		) ) : '') . '">' . do_shortcode($content) . '</div></li>';

		return apply_filters('luv_accordion_inner_shortcode', $html, $atts, $content);
	}

	/**
	 * Multi Scroll Shortcode
	 * @param array $atts
	 * @param string $content
	 */
	public function multiscroll_shortcode($atts, $content = ''){
		if (is_singular()){
			_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/jquery.multiscroll.css');
			wp_enqueue_script('easing', LUVTHEMES_CORE_URI . 'assets/js/min/jquery.easings.min.js', array('jquery'), LUVTHEMES_CORE_VER, true);
			wp_enqueue_script('multiscroll', LUVTHEMES_CORE_URI . 'assets/js/jquery.multiscroll.js', array('jquery'), LUVTHEMES_CORE_VER, true);
		}
		$html = '<div class="luv-multiscroll">' . do_shortcode($content) . '</div>';

		return apply_filters('luv_multiscroll_shortcode', $html, $atts, $content);
	}

	/**
	 * Multi Scroll Inner Shortcode
	 * @param array $atts
	 * @param string $content
	 */
	public function multiscroll_inner_shortcode($atts, $content = ''){
		$side = (isset($atts['side']) && !empty($atts['side']) ? $atts['side'] : 'left');
		$html = '<div class="luv-multiscroll-'.$side.'">' . do_shortcode($content) . '</div>';
		return apply_filters('luv_multiscroll_inner_shortcode', $html, $atts, $content);
	}

	/**
	 * Multi Scroll Section Shortcode
	 * @param array $atts
	 * @param string $content
	 */
	public function multiscroll_section_shortcode($atts, $content = ''){
		$html = '<div class="luv-multiscroll-section">' . do_shortcode($content) . '</div>';
		return apply_filters('luv_multiscroll_section_shortcode', $html, $atts, $content);
	}


	/**
	 * Testimonials Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function testimonials_shortcode($atts, $content = '') {
		global $luv_testimonials_count;
		// Enqueue Owl Carousel
		wp_enqueue_script('fevr-owlcarousel', LUVTHEMES_CORE_URI . 'assets/js/min/owl.carousel.min.js', array('jquery'), LUVTHEMES_CORE_VER, true);

		$luv_testimonials_atts = shortcode_atts ( array (
				'columns' => '{\'mobile\' : \'1\'}',
				'style' => 'simple',
				'bubble_arrows' => 'false',
				'border_radius' => '0',
				'autoplay' => 'false',
				'autoplay_timeout' => '5000',
				'hide_faces' => 'false',
				'hover_animation' => 'false',
				'shadow_on_hover' => 'false',
				'opacity' => 'false',
				'center_is_active' => 'false',
				'color_scheme' => 'default',
				'text_color' => '',
				'quote_color' => '',
				'name_color' => '',
				'position_color' => '',
				'background_color' => '',

		), $atts, 'luv_testimonials' );

		$classes = $style = $child_styles = array();

		// Show images
		if ($luv_testimonials_atts['style'] == 'modern'){
			$classes[] = 'has-image';
		}

		// Bubble arrows
		if ($luv_testimonials_atts['bubble_arrows'] == 'true'){
			$classes[] = 'has-arrow';
		}

		// Hover animation
		if ($luv_testimonials_atts['hover_animation'] == 'true'){
			$classes[] = 'has-hover-animation';
		}

		// Hover shadow
		if ($luv_testimonials_atts['shadow_on_hover'] == 'true'){
			$classes[] = 'has-shadow';
		}

		// Opacity
		if ($luv_testimonials_atts['opacity'] == 'true'){
			$classes[] = 'has-opacity';
		}

		// Hide faces
		if ($luv_testimonials_atts['hide_faces'] == 'true'){
			$classes[] = 'hide-faces';
		}

		// Border radius
		if (!empty($luv_testimonials_atts['border_radius'])){
			$child_styles['.has-image li .luv-testimonials-content'] = '-webkit-border-radius: '.$luv_testimonials_atts['border_radius'].'px;-moz-border-radius: '.$luv_testimonials_atts['border_radius'].'px;border-radius: '.$luv_testimonials_atts['border_radius'].'px; !important;';
		}

		// Custom color
		$custom_color = ($luv_testimonials_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($luv_testimonials_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$luv_testimonials_atts['background_color'] = _get_luvoption($luv_testimonials_atts['color_scheme']);
			$luv_testimonials_atts['text_color'] = $luv_testimonials_atts['quote_color'] = _luv_adjust_color_scheme(_get_luvoption($luv_testimonials_atts['color_scheme']));
		}

		// add color scheme to classes
		if ($custom_color) {

			if (!empty($luv_testimonials_atts['text_color'])){
				$child_styles[' .luv-testimonials-content'] = 'color:' . $luv_testimonials_atts['text_color'] . ' !important;';
			}

			if (!empty($luv_testimonials_atts['background_color'])){
				$child_styles[' li .luv-testimonials-content'] = 'background-color:' . $luv_testimonials_atts['background_color'] . ' !important;';
				$child_styles[' li .luv-testimonials-content::after'] = 'border-color:' . $luv_testimonials_atts['background_color'] . ' transparent transparent !important;';
			}

			if (!empty($luv_testimonials_atts['quote_color'])){
				$child_styles[' .luv-testimonials-content::before'] = 'color:' . $luv_testimonials_atts['quote_color'] . ' !important;';
			}

			if (!empty($luv_testimonials_atts['name_color'])){
				$child_styles[' .luv-testimonials-name'] = 'color:' . $luv_testimonials_atts['name_color'] . ' !important;';
			}

			if (!empty($luv_testimonials_atts['position_color'])){
				$child_styles[' .luv-testimonials-position'] = 'color:' . $luv_testimonials_atts['position_color'] . ' !important;';
			}

			$classes[] = _luv_enqueue_inline_css(array(
				'style' => implode(';',$style),
				'child' => $child_styles
			));
		}

		$luv_testimonials_count = 0;
		$content = do_shortcode($content);

		// Set infinite to true if it contains more than one testimonials
		$luv_testimonials_is_infinite = $luv_testimonials_count > 1 ? 'true' : 'false';

		$html = '<ul class="luv-testimonials luv-carousel '.implode(' ', $classes).'" '.
				'data-luv-carousel-autoplay="' . $luv_testimonials_atts ['autoplay'] . '" data-autoplay-timeout="'.$luv_testimonials_atts ['autoplay_timeout'].'" data-luv-carousel-center="' . $luv_testimonials_atts ['center_is_active'] . '" data-luv-carousel-margin="30" data-luv-carousel-nav="false" data-luv-carousel-infinite="'.$luv_testimonials_is_infinite.'" data-luv-carousel-dots="false" data-luv-carousel-items="'.$luv_testimonials_atts['columns'].'"'.
				'>'.$content.'</ul>';

		return apply_filters('luv_testimonials_shortcode', $html, $atts, $content);
	}

	/**
	 * Testimonials shortcode inner
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 *
	 */
	public function testimonials_inner_shortcode($atts, $content = '') {
		global $luv_enqueued_inline_fonts, $luv_testimonials_count;
		$testimonials_inner_atts = shortcode_atts ( array (
				'image' => '',
				'name' => '',
				'position' => '',

		), $atts, 'luv_testimonials_inner' );

		$html = '<li><div class="luv-testimonials-content">
					'.do_shortcode($content).'
				</div>
				<div class="luv-testimonials-author">
					'.($testimonials_inner_atts['image'] > 0 ? '<img src="'.esc_url(wp_get_attachment_thumb_url($testimonials_inner_atts['image'])).'">' : '').
					'<span class="luv-testimonials-name">'._luv_kses($testimonials_inner_atts['name']).'</span><span class="luv-testimonials-position">'._luv_kses($testimonials_inner_atts['position']).'</span>
				</div></li>';

		$luv_testimonials_count++;

		return apply_filters('luv_testimonials_inner_shortcode', $html, $atts, $content);
	}

	/**
	 * Button Shortcode
	 * @param array $atts
	 * @return string
	 */
	function button_shortcode($atts) {
		global $luv_enqueued_inline_fonts;
		$luv_shortcode_atts = shortcode_atts ( array (
				'href' => '',
				'text' => '',
				'font_family' => '',
				'icon' => '',
				'icon_display_effect' => '',
				'hover_effect' => '',
				'hover_animation' => '',
				'target' => '',
				'size' => '',
				'is_3d' => 'false',
				'is_rounded' => 'false',
				'border_radius' => '50',
				'only_border' => 'false',
				'block' => 'false',
				'color_scheme' => 'default',
				'color' => 'unset',
				'background_color' => 'unset',
				'border_color' => 'unset',
				'border_style' => '',
				'hover_color' => 'unset',
				'hover_background_color' => 'unset',
				'hover_border_color' => 'unset',
				'box_shadow' => 'false',
				'box_shadow_h' => '0',
				'box_shadow_v' => '0',
				'box_shadow_inset' => 'false',
				'box_shadow_color' => 'rgba(0, 0, 0, 0.1)',
				'box_shadow_blur' => '5',
				'design' => '',
				'tooltip' => 'false',
				'tooltip_color_scheme' => 'default',
				'tooltip_background_color' => '',
				'tooltip_color' => '',
				'tooltip_text' => '',
				'ga_tracking' => 'false',
				'ga_event_category' => '',
				'ga_event_action' => '',
				'ga_event_label' => '',
				'ga_event_value' => '',
		), $atts, 'luv_button' );

		$classes = $style = $style_child = $effect_child = $data = array ();

		// Shadow
		if ($luv_shortcode_atts['box_shadow'] == 'true'){
			$inset = ($luv_shortcode_atts['box_shadow_inset'] == 'true' ? 'inset ' : '');
			$classes[] 	= ' '._luv_enqueue_inline_css(array(
							'style' =>
								'-webkit-box-shadow: '. $inset .$luv_shortcode_atts['box_shadow_h'].'px '.$luv_shortcode_atts['box_shadow_v'].'px '.$luv_shortcode_atts['box_shadow_blur'].'px '.$luv_shortcode_atts['box_shadow_color'] . ';' .
								'-moz-box-shadow: '. $inset .$luv_shortcode_atts['box_shadow_h'].'px '.$luv_shortcode_atts['box_shadow_v'].'px '.$luv_shortcode_atts['box_shadow_blur'].'px '.$luv_shortcode_atts['box_shadow_color'] . ';' .
								'box-shadow: '. $inset .$luv_shortcode_atts['box_shadow_h'].'px '.$luv_shortcode_atts['box_shadow_v'].'px '.$luv_shortcode_atts['box_shadow_blur'].'px '.$luv_shortcode_atts['box_shadow_color'] . ';'
						));
		}

		// Font family
		if (!empty($luv_shortcode_atts['font_family'])){
			$luv_enqueued_inline_fonts[$luv_shortcode_atts['font_family']]['regular'] = 'regular';
			$classes[] = _luv_enqueue_inline_css(array(
							'style' => 'font-family:' . $luv_shortcode_atts['font_family'] . ' !important'
						));
		}

		// add 3d to classes
		if ($luv_shortcode_atts['is_3d'] == 'true') {
			$classes[] = 'btn-3d';
		}

		// add rounded to classes
		if ($luv_shortcode_atts['is_rounded'] == 'true') {
			$classes[] = 'btn-rounded';
			if ($luv_shortcode_atts['border_radius'] != 50){
				$classes[] = _luv_enqueue_inline_css(array(
					'style' => '-webkit-border-radius: '.$luv_shortcode_atts['border_radius'].'px;-moz-border-radius: '.$luv_shortcode_atts['border_radius'].'px;border-radius: '.$luv_shortcode_atts['border_radius'].'px;'
				));
			}
		}

		// add only border
		if ($luv_shortcode_atts ['only_border'] == "false") {
			$classes[] = 'btn-full';
		}

		// add full width
		if ($luv_shortcode_atts ['block'] == "true") {
			$classes[] = 'btn-block';
		}

		// add size to classes(btn-s, btn-l, btn-xl, btn-xxl)
		if (!empty( $luv_shortcode_atts ['size'] )) {
			$classes[] = $luv_shortcode_atts ['size'];
		}

		// Icon
		if (!empty( $luv_shortcode_atts ['icon'] )) {
			// Late enqueue ionicons
			if (preg_match ( '~ion-~', $luv_shortcode_atts ['icon'] )) {
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/ionicons.min.css');
			}
			else if (preg_match ( '~linea-~', $luv_shortcode_atts ['icon'] )) {
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/linea-icons.css');
			}
			$classes[] = 'btn-icon';

			if (!empty( $luv_shortcode_atts['icon_display_effect'] )){
				$classes[] = $luv_shortcode_atts['icon_display_effect'];
			}
		}

		// Border Style
		if (!empty($luv_shortcode_atts['border_style'])){
			$classes[] = $luv_shortcode_atts['border_style'];
		}

		// Hover Effect
		if (!empty($luv_shortcode_atts['hover_effect'])){
			$classes[] = $luv_shortcode_atts['hover_effect'];
		}

		// Hover Animation
		if (!empty($luv_shortcode_atts['hover_animation'])){
			$classes[]	= 'btn-hover-animation';
			$data[]		= 'data-animation="'.$luv_shortcode_atts['hover_animation'].'"';
		}

		// Luv Design options
		if (!empty( $luv_shortcode_atts['design'] )) {
			$styles = '';
			foreach ( json_decode ( str_replace ( "'", '"', $luv_shortcode_atts ['design'] ), true ) as $key => $value ) {
				$styles .= $key . ':' . ( int ) $value . 'px;';
			}
			$classes [] = _luv_enqueue_inline_css ( array (
					'style' => $styles
			) );
		}

		// Custom color
		$custom_color = ($luv_shortcode_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($luv_shortcode_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$luv_shortcode_atts['background_color'] = $luv_shortcode_atts ['border_color'] = _get_luvoption($luv_shortcode_atts['color_scheme']);
			$luv_shortcode_atts['color'] = _luv_adjust_color_scheme(_get_luvoption($luv_shortcode_atts['color_scheme']));

			$luv_shortcode_atts['hover_background_color'] = $luv_shortcode_atts ['hover_border_color'] = _luv_adjust_brightness(_get_luvoption($luv_shortcode_atts['color_scheme']), 50);
			$luv_shortcode_atts['hover_color'] = _luv_adjust_color_scheme(_luv_adjust_brightness(_get_luvoption($luv_shortcode_atts['color_scheme']),50));

		}

		// add color scheme to classes
		if ($custom_color) {
				$style_child[':hover'] = $style_child[':hover *'] = '';
				// Color & background
				if (!empty( $luv_shortcode_atts ['color'] )) {
					$style [] = 'color:' . $luv_shortcode_atts ['color'] . ' !important;';
					$style_child [' *'] = 'color:' . $luv_shortcode_atts ['color'] . ' !important;';
				}
				if (!empty( $luv_shortcode_atts ['background_color'] )) {
					$style [] = 'background-color:' . $luv_shortcode_atts ['background_color'] . ' !important;';
				}
				if (!empty( $luv_shortcode_atts ['border_color'] )) {
					$style [] = 'border: 2px solid ' . $luv_shortcode_atts ['border_color'] . ' !important;';
				}

				// Hover color and hover background
				if (!empty( $luv_shortcode_atts ['hover_color'] )) {
					$style_child[':hover'] .= 'color:' . $luv_shortcode_atts ['hover_color'] . ' !important;';
					$style_child[':hover *'] .= 'color:' . $luv_shortcode_atts ['hover_color'] . ' !important;';
				}
				if (!empty( $luv_shortcode_atts ['hover_background_color'] )) {
					// Don't set hover if hover effect has been set
					if (empty($luv_shortcode_atts['hover_effect'])){
						$style_child[':hover']	.= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
					}
					else{
						$style_child['.btn-hover-fill-right::after']			= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-fill-left::after']			= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-fill-top::after']			= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-fill-bottom::after']			= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-expand-vertical:after']		= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-expand-horizontal:after']	= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-expand-diagonal:after'] 		= 'background-color:' . $luv_shortcode_atts ['hover_background_color'] . ' !important;';
					}

				}
				if (!empty( $luv_shortcode_atts ['hover_border_color'] )) {
					$style_child[':hover'] .= 'border-color:' . $luv_shortcode_atts ['hover_border_color'] . ' !important;';
				}
		}

		if (!empty( $style ) || !empty( $style_child )) {
			$classes[] = _luv_enqueue_inline_css ( array (
					'parent' => 'html body .btn',
					'style' => implode ( ';', $style ),
					'child' => $style_child
			) );
		}

		// Add icon tag
		$icon_tag = '';
		if (!empty($luv_shortcode_atts['icon'])){
			if (in_array($luv_shortcode_atts['icon_display_effect'], array('btn-icon-default-left', 'btn-icon-default-right'))){
				$icon_tag = '<span><i class="' . $luv_shortcode_atts['icon'].'"></i></span>';
			}
			else{
				$icon_tag = '<i class="' . $luv_shortcode_atts['icon'].'"></i>';
			}
		}

		// Tooltip
		if ($luv_shortcode_atts['tooltip'] == 'true'){

			$tooltip_custom_color = ($luv_shortcode_atts['tooltip_color_scheme'] != 'default' ? true : false);

			if (in_array($luv_shortcode_atts['tooltip_color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
				$luv_shortcode_atts['tooltip_background_color'] = _get_luvoption($luv_shortcode_atts['tooltip_color_scheme']);
				$luv_shortcode_atts['tooltip_color'] = _luv_adjust_color_scheme($luv_shortcode_atts['tooltip_background_color']);
			}


			wp_enqueue_script('tipso', LUVTHEMES_CORE_URI . 'assets/js/min/tipso.min.js', array('jquery'), LUVTHEMES_CORE_VER, true);

			$classes[]	= 'luv-tooltip';
			$data[]		= 'data-tipso="'.$luv_shortcode_atts['tooltip_text'].'"';

			if ($tooltip_custom_color){
				$data[]		= 'data-tooltip-background-color="'.$luv_shortcode_atts['tooltip_background_color'].'"';
				$data[]		= 'data-tooltip-color="'.$luv_shortcode_atts['tooltip_color'].'"';
			}
		}

		// Tracking
		if ($luv_shortcode_atts['ga_tracking'] == 'true'){
			$classes[]	= 'luv-ga-click';
			$data[]		= 'data-event-category="'.$luv_shortcode_atts['ga_event_category'].'"';
			$data[]		= 'data-event-action="'.$luv_shortcode_atts['ga_event_action'].'"';
			$data[]		= 'data-event-label="'.$luv_shortcode_atts['ga_event_label'].'"';
			$data[]		= 'data-event-value="'.$luv_shortcode_atts['ga_event_value'].'"';
		}

		// Build button text
		if ($luv_shortcode_atts['icon_display_effect'] == 'btn-icon-default-left'){
			$button_text = $icon_tag . '<span>' . do_shortcode ( $luv_shortcode_atts ['text'] ) . '</span>';
		}
		else{
			$button_text = '<span>' . do_shortcode ( $luv_shortcode_atts ['text'] ) . '</span>' . $icon_tag;
		}

		$html = '<a href="' . esc_attr($luv_shortcode_atts ['href']) . '" target="' . esc_attr($luv_shortcode_atts ['target']) . '" class="btn btn-shortcode' . (!empty( $classes ) ? ' ' . esc_attr(implode ( ' ', $classes )) : '') . '" ' . implode(' ', $data).'>'._luv_kses($button_text).'</a>';

		return apply_filters('luv_button_shortcode', $html, $atts);
	}

	/**
	 * Pricing table container
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function pricing_table_shortcode($atts, $content = '') {
		global $luv_pricing_table_atts, $luv_pricing_table_items;
		$luv_pricing_table_atts = shortcode_atts ( array (
				'rounded' => 'false',
				'gutter' => 'false',
				'color_scheme' => 'colorful',
				'background_color' => '',
				'title_color' => '',
				'title_background_color' => '',
				'price_color' => '',
				'price_background_color' => '',
				'description_color' => '',
				'description_background_color' => '',
				'features_color' => '',
				'features_background_color' => '',
		), $atts, 'luv_pricing_table' );

		$luv_pricing_table_items = 0;
		$classes = array ();

		if ($luv_pricing_table_atts ['rounded'] == 'true') {
			$classes [] = 'pricing-table-rounded';
		}

		if ($luv_pricing_table_atts ['gutter'] != 'true') {
			$classes [] = 'pricing-table-no-gutter';
		}

		if (in_array($luv_pricing_table_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
				$luv_pricing_table_atts['background_color'] = $luv_pricing_table_atts['title_background_color'] = $luv_pricing_table_atts['price_background_color'] = $luv_pricing_table_atts['features_background_color'] = $luv_pricing_table_atts['description_background_color'] = _get_luvoption($luv_pricing_table_atts['color_scheme']);
				$luv_pricing_table_atts['title_color'] = $luv_pricing_table_atts['price_color'] = $luv_pricing_table_atts['description_color'] =  $luv_pricing_table_atts['features_color'] =  _luv_adjust_color_scheme(_get_luvoption($luv_pricing_table_atts['color_scheme']));
		}
		else if (in_array($luv_pricing_table_atts['color_scheme'], array('colorful', 'light', 'dark'))){
			$classes [] = 'pricing-table-' . $luv_pricing_table_atts['color_scheme'];
		}

		$content	= do_shortcode ( $content );

		$html = '<div class="pricing-table ' . implode ( ' ', $classes ) . '" data-pricing-table-columns="' . $luv_pricing_table_items . '">' . $content . '</div>';

		return apply_filters('luv_pricing_table_shortcode', $html, $atts, $content);
	}

	/**
	 * Column for pricing table
	 * @param array $atts
	 * @param string $content
	 */
	public function pricing_column_shortcode($atts, $content = '') {
		global $luv_enqueued_inline_fonts, $luv_pricing_table_atts, $luv_pricing_table_items;
		$luv_pricing_column_atts = shortcode_atts ( array (
				'title' => '',
				'title_font_family' => '',
				'currency' => '',
				'currency_font_family' => '',
				'price' => 0,
				'price_font_family' => '',
				'period' => '',
				'period_font_family' => '',
				'description' => '',
				'description_font_family' => '',
				'features_font_family' => '',
				'featured' => 'false',
				'featured_font_family' => ''
		), $atts, 'luv_pricing_column' );

		$luv_pricing_table_items++;

		// Column styles
		$column_styles = array();
		if (!empty($luv_pricing_table_atts['background_color'])){
			$column_styles[] = 'background-color: ' . $luv_pricing_table_atts['background_color'] . ' !important';
		}
		$column_styles = implode(';',$column_styles);

		// Title styles
		$title_styles = array();
		if (!empty($luv_pricing_table_atts['title_color'])){
			$title_styles[] = 'color: ' . $luv_pricing_table_atts['title_color'] . ' !important;border-color: ' . $luv_pricing_table_atts['title_color'] . ' !important';
		}
		if (!empty($luv_pricing_table_atts['title_color'])){
			$title_styles[] = 'background-color: ' . $luv_pricing_table_atts['title_background_color'] . ' !important';
		}
		if (!empty($luv_pricing_column_atts['title_font_family'])){
			$luv_enqueued_inline_fonts[$luv_pricing_column_atts['title_font_family']]['regular'] = 'regular';
			$title_styles[] = 'font-family:' . $luv_pricing_column_atts['title_font_family'] . ' !important';
		}
		$title_styles = implode(';',$title_styles);

		// Pricing styles
		$price_styles = array();
		if (!empty($luv_pricing_table_atts['price_color'])){
			$price_styles[] = 'color: ' . $luv_pricing_table_atts['price_color'] . ' !important';
		}
		if (!empty($luv_pricing_table_atts['price_background_color'])){
			$price_styles[] = 'background-color: ' . $luv_pricing_table_atts['price_background_color'] . ' !important';
		}
		if (!empty($luv_pricing_column_atts['price_font_family'])){
			$luv_enqueued_inline_fonts[$luv_pricing_column_atts['price_font_family']]['regular'] = 'regular';
			$price_styles[] = 'font-family:' . $luv_pricing_column_atts['price_font_family'] . ' !important';
		}
		$price_styles = implode(';',$price_styles);

		// Description styles
		$description_styles = array();
		if (!empty($luv_pricing_table_atts['description_color'])){
			$description_styles[] = 'color: ' . $luv_pricing_table_atts['description_color'] . ' !important';
		}
		if (!empty($luv_pricing_table_atts['description_background_color'])){
			$description_styles[] = 'background-color: ' . $luv_pricing_table_atts['description_background_color'] . ' !important';
		}
		if (!empty($luv_pricing_column_atts['description_font_family'])){
			$luv_enqueued_inline_fonts[$luv_pricing_column_atts['description_font_family']]['regular'] = 'regular';
			$description_styles[] = 'font-family:' . $luv_pricing_column_atts['description_font_family'] . ' !important';
		}
		$description_styles = implode(';',$description_styles);

		// Features styles
		$features_styles = array();
		if (!empty($luv_pricing_table_atts['features_color'])){
			$features_styles[] = 'color: ' . $luv_pricing_table_atts['features_color'] . ' !important';
		}
		if (!empty($luv_pricing_table_atts['features_background_color'])){
			$features_styles[] = 'background-color: ' . $luv_pricing_table_atts['features_background_color'] . ' !important';
		}
		if (!empty($luv_pricing_column_atts['features_font_family'])){
			$luv_enqueued_inline_fonts[$luv_pricing_column_atts['features_font_family']]['regular'] = 'regular';
			$features_styles[] = 'font-family:' . $luv_pricing_column_atts['features_font_family'] . ' !important';
		}
		$features_styles = implode(';',$features_styles);


		$html=  '<div class="pricing-table-item' . ($luv_pricing_column_atts ['featured'] == 'true' ? ' pricing-table-item-featured' : '') . ' ' . _luv_enqueue_inline_css(array('style' => $column_styles)) . '">' .
				'<h3 class="pricing-table-title ' . _luv_enqueue_inline_css(array('style' => $title_styles)) . '">' . $luv_pricing_column_atts ['title'] . '</h3>' .
				'<div class="pricing-table-price ' ._luv_enqueue_inline_css(array('style' => $price_styles)) . '"><span class="pricing-currency">' . $luv_pricing_column_atts ['currency'] . '</span>' . do_shortcode ( $luv_pricing_column_atts ['price'] ) .
				'<span class="pricing-table-period ' ._luv_enqueue_inline_css(array('style' => $price_styles)) . '">' . $luv_pricing_column_atts ['period'] . '</span></div>' .
				'<p class="pricing-table-sentence ' ._luv_enqueue_inline_css(array('style' => $description_styles)) . '">' . $luv_pricing_column_atts ['description'] . '</p>' .
				'<div class="pricing-table-feature-list ' ._luv_enqueue_inline_css(array('style' => $features_styles)) . '">' . do_shortcode ( $content ) . '</div>' . '</div>';

		return apply_filters('luv_pricing_column_shortcode', $html, $atts, $content);
	}

	/**
	 * Share Shortcode
	 * @param array $atts
	 */
	public function share_shortcode($atts) {
		global $luv_enqueued_inline_fonts;
		$share_atts = shortcode_atts ( array (
				'channel' => 'facebook',
				'text' => '',
				'font_family' => '',
				'icon' => '',
				'icon_display_style' => 'btn-icon-only',
				'hover_effect' => '',
				'hover_animation' => '',
				'size' => '',
				'is_3d' => 'false',
				'is_rounded' => 'false',
				'border_radius' => '50',
				'only_border' => 'false',
				'block' => 'false',
				'color_scheme' => 'default',
				'color' => 'unset',
				'background_color' => 'unset',
				'border_color' => 'unset',
				'hover_color' => 'unset',
				'hover_background_color' => 'unset',
				'hover_border_color' => 'unset',
				'design' => '',
				'ga_tracking' => 'false',
				'ga_event_category' => '',
				'ga_event_action' => '',
				'ga_event_label' => '',
				'ga_event_value' => '',
		), $atts, 'luv_share' );

		$permalink = esc_attr ( get_permalink () );
		$html = '';

		$classes = $style = $style_child = $data = array ();

		if ($share_atts ['channel'] == 'facebook') {
			$classes[] = 'luv-share-facebook';
			$share_url = 'http://www.facebook.com/share.php?u=' . urlencode ( $permalink );
			$icon = 'fa fa-facebook';
		}
		if ($share_atts ['channel'] == 'twitter') {
			$classes[] = 'luv-share-twitter';
			$share_url = 'http://twitter.com/intent/tweet?text=' . urlencode ( get_the_title () . ' ' . $permalink );
			$icon = 'fa fa-twitter';
		}
		if ($share_atts ['channel'] == 'google_plus') {
			$classes[] = 'luv-share-google-plus';
			$share_url = 'https://plus.google.com/share?url=' . urlencode ( $permalink );
			$icon = 'fa fa-google-plus';
		}
		if ($share_atts ['channel'] == 'linkedin') {
			$classes[] = 'luv-share-linkedin';
			$share_url = 'http://www.linkedin.com/shareArticle?mini=true&url=' . urlencode ( $permalink ) . '&title=' . urlencode ( get_the_title () );
			$icon = 'fa fa-linkedin';
		}
		if ($share_atts ['channel'] == 'pinterest') {
			$classes[] = 'luv-share-pinterest';
			$image = wp_get_attachment_image_src ( get_post_thumbnail_id ( get_the_ID () ), 'full' );
			$share_url = 'http://pinterest.com/pin/create/button/?url=' . urlencode ( $permalink ) . '&media=' . urlencode ( $image [0] ) . '&description=' . urlencode ( get_the_title () );
			$icon = 'fa fa-pinterest';
		}

		// Font family
		if (!empty($share_atts['font_family'])){
			$luv_enqueued_inline_fonts[$share_atts['font_family']]['regular'] = 'regular';
			$classes[] = _luv_enqueue_inline_css(array(
					'style' => 'font-family:' . $share_atts['font_family'] . ' !important'
			));
		}

		// add 3d to classes
		if ($share_atts['is_3d'] == 'true') {
			$classes[] = 'btn-3d';
		}

		// add rounded to classes
		if ($share_atts['is_rounded'] == 'true') {
			$classes[] = 'btn-rounded';
			if ($share_atts['border_radius'] != 50){
				$classes[] = _luv_enqueue_inline_css(array(
						'style' => '-webkit-border-radius: '.$share_atts['border_radius'].'px;-moz-border-radius: '.$share_atts['border_radius'].'px;border-radius: '.$share_atts['border_radius'].'px;'
				));
			}
		}

		// add only border
		if ($share_atts ['only_border'] == "false") {
			$classes[] = 'btn-full';
		}

		// add full width
		if ($share_atts ['block'] == "true") {
			$classes[] = 'btn-block';
		}

		// add size to classes(btn-s, btn-l, btn-xl, btn-xxl)
		if (!empty( $share_atts ['size'] )) {
			$classes[] = $share_atts ['size'];
		}

		// Icon display effect
		if (!empty( $share_atts['icon_display_style'] )){
			$classes[] = $share_atts['icon_display_style'];
		}

		// Hover effect
		if (!empty($share_atts['hover_effect'])){
			$classes[] = $share_atts['hover_effect'];
		}

		// Hover animation
		if (!empty($share_atts['hover_animation'])){
			$classes[]	= 'btn-hover-animation';
			$data[]		= 'data-animation="'.$share_atts['hover_animation'].'"';
		}

		// Luv Design options
		if (!empty( $share_atts['design'] )) {
			$styles = '';
			foreach ( json_decode ( str_replace ( "'", '"', $share_atts ['design'] ), true ) as $key => $value ) {
				$styles .= $key . ':' . ( int ) $value . 'px;';
			}
			$classes [] = _luv_enqueue_inline_css ( array (
					'style' => $styles
			) );
		}

		// Custom color
		$custom_color = ($share_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($share_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$share_atts['background_color'] = $share_atts ['border_color'] = _get_luvoption($share_atts['color_scheme']);
			$share_atts['color'] = _luv_adjust_color_scheme(_get_luvoption($share_atts['color_scheme']));

			$share_atts['hover_background_color'] = $share_atts ['hover_border_color'] = _luv_adjust_brightness(_get_luvoption($share_atts['color_scheme']), 50);
			$share_atts['hover_color'] = _luv_adjust_color_scheme(_luv_adjust_brightness(_get_luvoption($share_atts['color_scheme']),50));

		}

		// add color scheme to classes
		if ($custom_color == 'true') {
			$style_child[':hover'] = '';
			// Color & background
			if (!empty( $share_atts ['color'] )) {
				$style [] = 'color:' . $share_atts ['color'] . ' !important';
			}
			if (!empty( $share_atts ['background_color'] )) {
				$style [] = 'background-color:' . $share_atts ['background_color'] . ' !important';
			}
			if (!empty( $share_atts ['border_color'] )) {
				$style [] = 'border: 2px solid ' . $share_atts ['border_color'] . ' !important';
			}

			// Hover color and hover background
			if (!empty( $share_atts ['hover_color'] )) {
				$style_child[':hover'] .= 'color:' . $share_atts ['hover_color'] . ' !important;';
			}
			if (!empty( $share_atts ['hover_background_color'] )) {
					// Don't set hover if hover effect has been set
					if (empty($share_atts['hover_effect'])){
						$style_child[':hover']	.= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
					}
					else{
						$style_child['.btn-hover-fill-right::after']			= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-fill-left::after']			= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-fill-top::after']			= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-fill-bottom::after']			= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-expand-vertical:after']		= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-expand-horizontal:after']	= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
						$style_child['.btn-hover-expand-diagonal:after'] 		= 'background-color:' . $share_atts ['hover_background_color'] . ' !important;';
					}

			}
			if (!empty( $share_atts ['hover_border_color'] )) {
				$style_child[':hover'] .= 'border-color:' . $share_atts ['hover_border_color'] . ' !important;';
			}
		}

		if (!empty( $style ) || !empty( $style_child )) {
			$classes[] = _luv_enqueue_inline_css ( array (
					'style' => implode ( ';', $style ),
					'child' => $style_child
			) );
		}

		// Icon tag
		if (in_array($share_atts['icon_display_style'], array('btn-icon-default-left', 'btn-icon-default-right', 'btn-icon-count', 'btn-icon-only'))){
			$icon_tag = '<span><i class="' . $icon.'"></i></span>';
		}
		else{
			$icon_tag = '<i class="' . $icon.'"></i>';
		}

		// Count placeholder
		if ($share_atts['icon_display_style'] == 'btn-icon-count'){
			$share_atts['text'] = '0';
			$classes[] = 'btn-icon-default-left';
		}


		// Tracking
		if ($share_atts['ga_tracking'] == 'true'){
			$classes[]	= 'luv-ga-click';
			$data[]		= 'data-event-category="'.$share_atts['ga_event_category'].'"';
			$data[]		= 'data-event-action="'.$share_atts['ga_event_action'].'"';
			$data[]		= 'data-event-label="'.$share_atts['ga_event_label'].'"';
			$data[]		= 'data-event-value="'.$share_atts['ga_event_value'].'"';
		}

		// Build button text
		if (in_array($share_atts['icon_display_style'], array('btn-icon-default-left','btn-icon-count'))){
			 $button_text = $icon_tag . ($share_atts['icon_display_style'] != 'btn-icon-only' ? '<span'.($share_atts['icon_display_style'] == 'btn-icon-count' ? ' data-luv-share-count="'.$share_atts['channel'].'" data-luv-share-url="'.$permalink.'"' : '').'>' . do_shortcode ( $share_atts['text'] ) . '</span>' : '');
		}
		else{
			$button_text = ($share_atts['icon_display_style'] != 'btn-icon-only' ? '<span>' . do_shortcode ( $share_atts['text'] ) . '</span>' : '') . $icon_tag;
		}

		$html = '<a href="' . esc_url($share_url) . '" class="social-share-popup btn btn-shortcode btn-icon' . (!empty( $classes ) ? ' ' . esc_attr(implode ( ' ', $classes )) : '') . '" ' . implode(' ', $data).'>'.$button_text.'</a>';

		return apply_filters('luv_share_shortcode', $html, $atts);
	}

	public function social_sidebar_shortcode($atts){
		$sidebar_atts = shortcode_atts( array(
				'position'		=> 'left',
				'animation'		=> '',
				'filter'		=> '',
				'is_3d'			=> 'false',
				'facebook' 		=> 'false',
				'twitter'		=> 'false',
				'google_plus'	=> 'false',
				'linkedin'		=> 'false',
				'pinterest'		=> 'false',
				'ga_tracking'	=> 'false',
				'ga_event_category' => '',
				'ga_event_action' => '',
				'ga_event_label' => '',
				'ga_event_value' => '',
		), $atts, 'luv_social_sidebar' );

		$permalink = esc_attr(get_permalink());
		$html = '';
		$classes = $link_classes = $data = array();


		// Animation
		if (!empty($sidebar_atts['animation'])) {
			$link_classes[] = ' c-has-animation ' . $sidebar_atts['animation'];
		}

		// 3D
		if($sidebar_atts['is_3d'] == 'true'){
			$link_classes[] = 'btn-3d';
		}

		// Filter
		if (!empty($sidebar_atts['filter'])) {
			$classes[] = $sidebar_atts['filter'];
		}

		// Tracking
		if ($sidebar_atts['ga_tracking'] == 'true'){
			$classes[]	= 'luv-ga-click';
			$data[]		= 'data-event-category="'.$sidebar_atts['ga_event_category'].'"';
			$data[]		= 'data-event-action="'.$sidebar_atts['ga_event_action'].'"';
			$data[]		= 'data-event-label="'.$sidebar_atts['ga_event_label'].'"';
			$data[]		= 'data-event-value="'.$sidebar_atts['ga_event_value'].'"';
		}

		if ($sidebar_atts['facebook'] == 'true'){
			$share_url	 = 'http://www.facebook.com/share.php?u='.urlencode($permalink);
			$html		.= '<a href="'.esc_url($share_url).'" target="_blank" class="btn btn-icon luv-share-facebook btn-full btn-icon-only social-share-popup '.implode(' ', $link_classes).'" '.implode(' ', $data).'><span><i class="fa fa-facebook"></i></span></a>';
		}
		if ($sidebar_atts['twitter'] == 'true'){
			$share_url	 = 'http://twitter.com/intent/tweet?text='.urlencode(get_the_title().' '.$permalink);
			$html		.= '<a href="'.esc_url($share_url).'" target="_blank" class="btn btn-icon luv-share-twitter btn-full btn-icon-only social-share-popup'.implode(' ', $link_classes).'" '.implode(' ', $data).'><span><i class="fa fa-twitter"></i></span></a>';
		}
		if ($sidebar_atts['google_plus'] == 'true'){
			$share_url	 = 'https://plus.google.com/share?url='.urlencode($permalink);
			$html		.= '<a href="'.esc_url($share_url).'" target="_blank" class="btn btn-icon luv-share-google-plus btn-full btn-icon-only social-share-popup'.implode(' ', $link_classes).'" '.implode(' ', $data).'><span><i class="fa fa-google-plus"></i></span></a>';
		}
		if ($sidebar_atts['linkedin'] == 'true'){
			$share_url	 = 'http://www.linkedin.com/shareArticle?mini=true&url='.urlencode($permalink).'&title='.urlencode(get_the_title());
			$html		.= '<a href="'.esc_url($share_url).'" target="_blank" class="btn btn-icon luv-share-linkedin btn-full btn-icon-only social-share-popup'.implode(' ', $link_classes).'" '.implode(' ', $data).'><span><i class="fa fa-linkedin"></i></span></a>';
		}
		if ($sidebar_atts['pinterest'] == 'true'){
			$image		 = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
			$share_url	 = 'http://pinterest.com/pin/create/button/?url='.urlencode($permalink).'&media='.urlencode($image[0]).'&description='.urlencode(get_the_title());
			$html		.= '<a href="'.esc_url($share_url).'" target="_blank" class="btn btn-icon luv-share-pinterest btn-full btn-icon-only social-share-popup'.implode(' ', $link_classes).'" '.implode(' ', $data).'><span><i class="fa fa-pinterest"></i></span></a>';
		}

		$classes[] = 'social-sidebar-'.esc_attr($sidebar_atts['position']);

		$html = '<div class="luv-social-sidebar '.implode(' ', $classes).'">' . $html . '</div>';

		return apply_filters('luv_social_sidebar_shortcode', $html, $atts);
	}

	/**
	 * Counter Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function counter_shortcode($atts, $content = '') {
		$luv_counter_atts = shortcode_atts ( array (
				'type' => 'normal',
				'timeout' => '5',
				'step' => '1'
		), $atts, 'luv_counter' );

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_counter', $atts );

		$html = '<span class="luv-counter luv-counter-' . $luv_counter_atts['type'] . (!empty($classes) ? ' ' . $classes : '').'" data-speed="' . $luv_counter_atts ['timeout'] . '" data-step="' . $luv_counter_atts ['step'] . '">' . $content . '</span>';

		return apply_filters('luv_counter_shortcode', $html, $atts, $content);
	}

	public function countdown_shortcode($atts){
		$countdown_atts = shortcode_atts ( array (
				'time' => 0,
				'labels' => 'true',
				'clockface' => 'minutes',
				'style'	=> '',
				'animation' => '',
				'color' => '#000'
		), $atts, 'luv_countdown' );

		$countdown =  (strtotime($countdown_atts['time']) - time());
		$classes = '';

		// Add style
		if (!empty($countdown_atts['style'])){
			switch ($countdown_atts['style']){
				case 'square':
					$style = 'border: 2px solid '.$countdown_atts['color'].';';
					break;
				case 'rounded':
					$style = 'border: 2px solid '.$countdown_atts['color'].';-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;';
					break;
				case 'circle':
					$style = 'border: 2px solid '.$countdown_atts['color'].';-webkit-border-radius: 30px;-moz-border-radius: 30px;border-radius: 30px;';
					break;
				case 'dotted':
					$style = 'border: 2px dotted '.$countdown_atts['color'].';-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;';
					break;
				case 'dashed':
					$style = 'border: 2px dashed '.$countdown_atts['color'].';-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;';
					break;
				case 'underlined':
					$style = 'border-bottom: 2px solid '.$countdown_atts['color'].'';
					break;
				case '3D':
					$style = 'border-width: 1px 1px 2px 2px;border-color: '.$countdown_atts['color'].';border-style: solid;-webkit-box-shadow: -1px 1px 1px 0px rgba(0,0,0,0.75);-moz-box-shadow: -1px 1px 1px 0px rgba(0,0,0,0.75);box-shadow: -1px 1px 1px 0px rgba(0,0,0,0.75);';
					break;
			}

			$classes = _luv_enqueue_inline_css(array(
					'child' => array(' .luv-countdown-section div:first-child' => $style)
			));
		}

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $classes, 'luv_countdown', $atts );

		$html = '<div class="luv-countdown'.(!empty($classes) ? ' ' . $classes : '').'"'.
				'data-labels="'.$countdown_atts['labels'].'"'.
				'data-clockface="'.$countdown_atts['clockface'].'"'.
				'data-countdown="'.($countdown > 0 ? $countdown : 0).'"'.
				'data-animation="'.$countdown_atts['animation'].'">'.
				'</div>';

		return apply_filters('luv_countdown_shortcode', $html, $atts);
	}

	/**
	 * Google Maps Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function gmap_shortcode($atts, $content = '') {
		$luv_gmap_atts = shortcode_atts ( array (
				'width' => '300px',
				'height' => '180px',
				'type' => 'roadmap',
				'marker_animation' => 'drop',
				'tilt' => '45',
				'zoom' => '12',
				'disable_ui' => 'false',
				'disable_scrollwheel' => 'false',
				'draggable' => 'false',
				'use_clusters' => 'false',
				'color_scheme' => 'default',
				'hue' => '',
				'preset' => '',
				'json' => ''
		), $atts, 'luv_gmap' );

		$presets = array (
				'apple-maps-esque' => '[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}]',
				'avocado-world' => '[{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#aee2e0"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#abce83"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#769E72"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#7B8758"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#EBF4A4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#8dab68"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#5B5B3F"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ABCE83"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#A4C67D"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#9BBF72"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#EBF4A4"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#87ae79"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#7f2200"},{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"visibility":"on"},{"weight":4.1}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#495421"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"visibility":"off"}]}]',
				'becomeadinosaur' => '[{"elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#f5f5f2"},{"visibility":"on"}]},{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","stylers":[{"visibility":"off"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"visibility":"simplified"},{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"color":"#ffffff"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#71c8d4"}]},{"featureType":"landscape","stylers":[{"color":"#e5e8e7"}]},{"featureType":"poi.park","stylers":[{"color":"#8ba129"}]},{"featureType":"road","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"color":"#c7c7c7"},{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#a0d3d3"}]},{"featureType":"poi.park","stylers":[{"color":"#91b65d"}]},{"featureType":"poi.park","stylers":[{"gamma":1.51}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","stylers":[{"visibility":"simplified"}]},{"featureType":"road"},{"featureType":"road"},{},{"featureType":"road.highway"}]',
				'black-white' => '[{"featureType":"road","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"weight":1}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"weight":0.8}]},{"featureType":"landscape","stylers":[{"color":"#ffffff"}]},{"featureType":"water","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"elementType":"labels","stylers":[{"visibility":"off"}]},{"elementType":"labels.text","stylers":[{"visibility":"on"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#000000"}]},{"elementType":"labels.icon","stylers":[{"visibility":"on"}]}]',
				'blue-essence' => '[{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]',
				'blue-water' => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]',
				'cool-grey' => '[{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}]',
				'flat-map' => '[{"featureType":"all","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f3f4f4"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"weight":0.9},{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#83cead"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#7fc8ed"}]}]',
				'greyscale' => '[{"featureType":"all","elementType":"all","stylers":[{"saturation":-100},{"gamma":0.5}]}]',
				'light-dream' => '[{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}]',
				'light-monochrome' => '[{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}]',
				'mapbox' => '[{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]',
				'midnight-commander' => '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"transit","elementType":"all","stylers":[{"color":"#146474"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#021019"}]}]',
				'neutral-blue' => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]',
				'pale-down' => '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]',
				'paper' => '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"simplified"},{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"off"},{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]}]',
				'retro' => '[{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","stylers":[{"color":"#84afa3"},{"lightness":52}]},{"stylers":[{"saturation":-17},{"gamma":0.36}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#3f518c"}]}]',
				'shades-of-grey' => '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
				'subtle-grayscale' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
				'ultra-light-with-labels' => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]',
				'unsaturated-browns' => '[{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]'
		);

		// Set width and height
		$luv_gmap_atts ['width'] = (! preg_match ( '~(px|%)$~', $luv_gmap_atts ['width'] ) ? $luv_gmap_atts ['width'] . 'px' : $luv_gmap_atts ['width']);
		$luv_gmap_atts ['height'] = (! preg_match ( '~(px|%)$~', $luv_gmap_atts ['height'] ) ? $luv_gmap_atts ['height'] . 'px' : $luv_gmap_atts ['height']);

		// Custom color
		$custom_color = (!in_array($luv_gmap_atts['color_scheme'], array('default', 'preset', 'json')) ? true : false);

		if (in_array($luv_gmap_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$luv_gmap_atts['hue'] = _get_luvoption($luv_gmap_atts['color_scheme']);
		}


		$map_style = '';
		if ($custom_color) {
			$hue = $luv_gmap_atts['hue'];
			$map_style = '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"' . $hue . '"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"' . _luv_adjust_brightness ( $hue, 51 ) . '"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"' . _luv_adjust_brightness ( $hue, 51 ) . '"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"' . _luv_adjust_brightness ( $hue, 51 ) . '"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"' . _luv_adjust_brightness ( $hue, 51 ) . '"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"' . $hue . '"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"' . _luv_adjust_brightness ( $hue, 51 ) . '"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"' . _luv_adjust_brightness ( $hue, 51 ) . '"}]}]';
		} else if ($luv_gmap_atts ['color_scheme'] == 'preset') {
			$map_style = $presets [$luv_gmap_atts ['preset']];
		} else if ($luv_gmap_atts ['color_scheme'] == 'json') {
			$map_style = preg_replace('~\s+~','',urldecode(base64_decode($luv_gmap_atts ['json'])));
		}

		// Enqueue map js
		wp_enqueue_script ( 'luv-map', apply_filters('luv_gmap_script_src', LUVTHEMES_CORE_URI . 'assets/js/min/map-min.js'), array ('luvthemes-core'), false, true );

		// Enqueue markerclusters js
		if ($luv_gmap_atts['use_clusters'] == 'true'){
			wp_enqueue_script ( 'markercluster', LUVTHEMES_CORE_URI . 'assets/js/min/markercluster-min.js', array ('luv-map'), false, true );
		}

		$addresses = do_shortcode ( $content );

		$html = '<ul class="luvmap ' . _luv_enqueue_inline_css ( array (
				'style' => 'width: ' . $luv_gmap_atts ['width'] . '; height: ' . $luv_gmap_atts ['height']
		) ) . '" data-type="' . $luv_gmap_atts ['type'] . '" data-animation="' . $luv_gmap_atts['marker_animation'] . '" data-zoom="' . $luv_gmap_atts ['zoom'] . '" data-disable-ui="' . ($luv_gmap_atts ['disable_ui'] == 'true' ? 'true' : 'false') . '" data-scrollwheel="' . ($luv_gmap_atts ['disable_scrollwheel'] == 'true' ? 'false' : 'true') . '" data-draggable="' . ($luv_gmap_atts ['draggable'] == 'true' ? 'true' : 'false') . '" ' . (!empty( $map_style ) ? 'data-map-style="' . urlencode ( $map_style ) . '"' : '') . ' data-use-clusters="'. $luv_gmap_atts['use_clusters'] .'">' . $addresses . '</ul>';

		return apply_filters('luv_gmap_shortcode', $html, $atts, $content);
	}

	/**
	 * Google Map Address Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function gmap_address_shortcode($atts, $content = '') {
		$luv_gmap_address_atts = shortcode_atts ( array (
				'address' => '',
				'image' => '',
				'open_info_window' => 'false',
		), $atts, 'luv_gmap_address' );


		$luv_gmap_address_atts ['image'] = wp_get_attachment_url ( $luv_gmap_address_atts ['image'] );

		$html = '<li class="luvmap-address'.($luv_gmap_address_atts['open_info_window'] == 'true' ? ' auto-open' : '').'">' . esc_html($luv_gmap_address_atts ['address']) . (!empty( $luv_gmap_address_atts ['image'] ) ? '<img class="luvmap-icon" src="' . esc_attr($luv_gmap_address_atts ['image']) . '">' : '') . (!empty( $content ) ? '<span class="luvmap-info">' . _luv_kses($content) . '</span>' : '') . "</li>\n";

		return apply_filters('luv_gmap_address_shortcode', $html, $atts, $content);
	}

	/**
	 * Animated List Inner
	 * @param array $atts
	 * @param string $content
	 */
	public function animated_list_shortcode($atts, $content = '') {
		global $luv_animated_list_element_atts;
		$list_atts = shortcode_atts ( array (
				'color_scheme' => 'default',
				'color' => '',
				'icon_color' => '',
				'icon_size' => '14',
				'animation' => ''
		), $atts, 'luv_animated_list' );

		$classes = array();

		// Set list element atts
		$luv_animated_list_element_atts = array(
				'icon_color' => $list_atts['icon_color'],
				'icon_size' => $list_atts['icon_size'],
				'animation' => $list_atts['animation']
		);

		// Custom color
		$custom_color = ($list_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($list_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$list_atts['color'] = _get_luvoption($list_atts['color_scheme']);
			$luv_animated_list_element_atts['icon_color'] = _get_luvoption($list_atts['color_scheme']);
		}

		// Classes
		if ($custom_color) {
			if (!empty( $list_atts ['color'] )) {
				$classes[] = _luv_enqueue_inline_css(array('style' => 'color:' . $list_atts ['color'] . ' !important'));
			}
		}

		$html = '<ul class="luv-animated-list '.implode(' ', $classes).'">'.do_shortcode($content).'</ul>';

		return apply_filters('luv_animated_list_shortcode', $html, $atts, $content);
	}

	/**
	 * Animated List Inner
	 * @param array $atts
	 * @param string $content
	 */
	public function animated_list_inner_shortcode($atts = array(), $content = '') {
		global $luv_animated_list_element_atts;

		$atts = array_merge((array)$luv_animated_list_element_atts, (array)$atts);

		$animation = (!empty($atts['animation']) ? ' c-has-animation c-animation-queued ' . $atts['animation'] : '');

		$html = '<li class="luv-animated-list-icon'.$animation.'">'.$this->icon_shortcode($atts).' '.$content.'</li>';

		return apply_filters('luv_animated_list_inner_shortcode', $html, $atts, $content);
	}


	/**
	 * Page Section Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function page_section_shortcode($atts = array()) {
		global $luv_one_page_sections;
		$title = (isset ( $atts ['title'] ) ? $atts ['title'] : '');
		$hide_dot = (isset ( $atts ['hide_dot'] ) ? $atts ['hide_dot'] : 'false');
		$node = (isset ( $atts ['node'] ) ? $atts ['node'] : 'h2');
		$anchor = (isset ( $atts ['id'] ) ? $atts ['id'] : preg_replace ( '/[^A-Za-z0-9-]+/', '-', (!empty( $title ) ? strtolower ( $title ) : 'section' . mt_rand ( 0, PHP_INT_MAX )) ));

		if ($hide_dot != 'true') {
			$luv_one_page_sections [] = '#' . $anchor;
		}

		$html = '<' . $node . ' id="' . $anchor . '" class="one-page-section">' . $title . '</' . $node . '>';

		return apply_filters('luv_page_section_shortcode', $html, $atts);
	}

	/**
	 * Page Submenu Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function page_submenu_shortcode($atts, $content = '') {
		$page_submenu_atts = shortcode_atts ( array (
				'sticky' => 'true',
				'color_scheme' => 'default',
				'background_color' => '',
				'color' => '',
				'sticky_background_color' => '',
				'sticky_color' => ''
		), $atts, 'luv_page_submenu' );


		// Custom color
		$custom_color = ($page_submenu_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($page_submenu_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$page_submenu_atts['background_color'] = _get_luvoption($page_submenu_atts['color_scheme']);
			$page_submenu_atts['color'] = _luv_adjust_color_scheme(_get_luvoption($page_submenu_atts['color_scheme']));
		}

		// Inline styles
		$styles = $child_styles = array ();
		if ($custom_color) {
			if (!empty( $page_submenu_atts ['color'] )) {
				$styles [] = 'color:' . $page_submenu_atts ['color'];
				$child_styles [' a'] = 'color:' . $page_submenu_atts ['color'];
			}

			if (!empty( $page_submenu_atts ['background_color'] )) {
				$styles [] = 'background-color:' . $page_submenu_atts ['background_color'];
			}

			if (!empty( $page_submenu_atts ['sticky_color'] )) {
				$child_styles ['.page-submenu-sticky a'] = 'color:' . $page_submenu_atts ['sticky_color'];
			}

			if (!empty( $page_submenu_atts ['background_color'] )) {
				$child_styles ['.page-submenu-sticky'] = 'background-color:' . $page_submenu_atts ['sticky_background_color'];
			}
		}

		$html = '<div class="page-submenu-container"><nav class="page-submenu' . ($page_submenu_atts ['sticky'] == 'true' ? ' page-submenu-onpage' : '') . ' ' . _luv_enqueue_inline_css ( array (
				'style' => implode ( ';', $styles ),
				'child' => $child_styles
		) ) . '"><ul>' . do_shortcode ( $content ) . '</ul></nav></div>';

		return apply_filters('luv_page_submenu_shortcode', $html, $atts, $content);
	}

	/**
	 * Page Submenu Item
	 * @param unknown $atts
	 * @param unknown $content
	 */
	public function page_submenu_item_shortcode($atts, $content = '') {
		$luv_page_submenu_item_atts = shortcode_atts ( array (
				'href' => '',
				'text' => '',
				'target' => '_blank'
		), $atts, 'luv_page_submenu_item' );

		$html = '<li class="menu-item"><a href="' . esc_attr($luv_page_submenu_item_atts ['href']) . '" target="' . esc_attr($luv_page_submenu_item_atts ['target']) . '">' . _luv_kses($luv_page_submenu_item_atts ['text']) . "</a></li>\n";
		return apply_filters('luv_page_submenu_item_shortcode', $html, $atts, $content);
	}

	/**
	 * Heading Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function heading_shortcode($atts = array()) {
		$luv_heading_atts = shortcode_atts ( array (
				'title' => '',
				'node' => 'h2',
				'text_color' => '',
				'style' => '',
				'background_color' => '',
				'border_color' => '#000',
				'border_weight' => '1'
		), $atts, 'luv_heading' );

		$styles = array ();
		if (!empty( $luv_heading_atts ['text_color'] )) {
			$styles [] = 'color:' . $luv_heading_atts ['text_color'];
		}

		if (!empty( $luv_heading_atts ['background_color'] )) {
			$styles [] = 'background-color:' . $luv_heading_atts ['background_color'];
		}

		if (!empty( $luv_heading_atts ['style'] )) {
			switch ($luv_heading_atts ['style']) {
				case 'left' :
					$styles [] = 'border-left:' . ( int ) $luv_heading_atts ['border_weight'] . 'px solid ' . $luv_heading_atts ['border_color'];
					break;
				case 'right' :
					$styles [] = 'border-right:' . ( int ) $luv_heading_atts ['border_weight'] . 'px solid ' . $luv_heading_atts ['border_color'];
					break;
				case 'bordered' :
				default :
					$styles [] = 'border:' . ( int ) $luv_heading_atts ['border_weight'] . 'px solid ' . $luv_heading_atts ['border_color'];
					break;
			}
		}

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, _luv_enqueue_inline_css ( array ('style' => implode ( ';', $styles ) )), 'luv_heading', $atts );


		$html = '<' . $luv_heading_atts ['node'] . ' class="' . $classes . '">' . $luv_heading_atts ['title'] . '</' . $luv_heading_atts ['node'] . '>';

		return apply_filters('luv_heading_shortcode', $html, $atts);
	}


	/**
	 * Separator
	 * @param array $atts
	 * @return string
	 */
	public function separator_shortcode($atts = array()) {
		$luv_separator_atts = shortcode_atts ( array (
				'width' => '100%',
				'height' => '1em',
				'block' => 'false',
				'css'	=> '',
				'background' => '', //Depricated since 1.1.2
		), $atts, 'luv_separator' );

		$styles = array ();
		if (!empty( $luv_separator_atts ['width'] )) {
			$styles [] = 'width:' . $luv_separator_atts ['width'];
		}

		if (!empty( $luv_separator_atts ['height'] )) {
			$styles [] = 'height:' . $luv_separator_atts ['height'];
		}

		if ($luv_separator_atts ['block'] == 'true') {
			$styles [] = 'display:block;';
		}

		// Depricated since 1.1.2 (we use Design options instead)
		if (!empty( $luv_separator_atts ['background'] )) {
			$styles [] = 'background:' . $luv_separator_atts ['background'];
		}

		$css_classes = array();
		if (!empty($luv_separator_atts['css'])){
			$css_classes[] = esc_attr( trim( vc_shortcode_custom_css_class( $atts['css'] ) ) );
		}

		$classes = ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), 'luv_separator', $atts );

		$html = '<div class="luv-separator ' . _luv_enqueue_inline_css ( array (
				'style' => implode ( ';', $styles )
		) ) . $classes . '"></div>';

		return apply_filters('luv_separator_shortcode', $html, $atts);
	}

	/**
	 * Icon Box Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function icon_box_shortcode($atts, $content = '') {
		$icon_box_atts = shortcode_atts ( array (
				'title' => '',
				'title_tag' => 'h4',
				'icon' => '',
				'icon_size' => '24',
				'style' => '',
				'title' => '',
				'layout' => 'left',
				'spinning' => 'false',
				'color_scheme' => 'default',
				'icon_type' => 'icon-font',
				'image' => '',
				'icon_animation' => '',
				'icon_color' => '',
				'icon_hover_color' => '',
				'icon_border_color' => '',
				'icon_background_color' => '',
				'icon_background_hover_color' => '',
				'title_font_family' => '',
				'title_font_size' => '',
				'title_responsive_font_size' => '',
				'title_font_weight' => '',
				'title_font_color' => '',
		), $atts, 'luv_icon_box' );

		$icon_styles = $child_styles = $classes = array ();

		$content_padding = $icon_box_atts['icon_size'] + 25;

		if (!empty( $icon_box_atts ['icon_size'] )) {
			$icon_styles [] = 'font-size:' . $icon_box_atts ['icon_size'] . 'px !important';
		}

		// Custom color
		$custom_color = ($icon_box_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($icon_box_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$icon_box_atts['icon_color'] = _get_luvoption($icon_box_atts['color_scheme']);
			$icon_box_atts['icon_hover_color'] = _luv_adjust_brightness(_get_luvoption($icon_box_atts['color_scheme']),50);
		}

		// Icon styles
		if ($custom_color) {
			$hover_styles = array ();
			$icon_hover_styles = array();
			if (!empty( $icon_box_atts ['icon_color'] )) {
				$icon_styles [] = 'color:' . $icon_box_atts ['icon_color'];
			}

			if (!empty( $icon_box_atts ['icon_hover_color'] )) {
				$hover_styles [] = $icon_hover_styles[] =  'color:' . $icon_box_atts ['icon_hover_color'] . ' !important';

			}

			if (!empty( $icon_box_atts ['icon_border_color'] )) {
				$child_styles [':hover .icon-box-icon:after'] = 'border-color:' . $icon_box_atts ['icon_border_color'] . ' !important';
			}

			if (!empty( $icon_box_atts ['icon_background_color'] )) {
				$icon_styles [] = 'background-color:' . $icon_box_atts ['icon_background_color'];
			}

			if (!empty( $icon_box_atts ['icon_background_hover_color'] )) {
				$hover_styles [] = 'background-color:' . $icon_box_atts ['icon_background_hover_color'] . ' !important';
			}

			$child_styles [':hover .icon-box-icon'] = implode ( ';', $hover_styles );
			$child_styles [':hover .icon-box-icon *'] = implode ( ';', $icon_hover_styles );
		}

		// Box classes
		if (!empty( $icon_box_atts ['style'] )) {
			$classes [] = $icon_box_atts ['style'];
			$content_padding = 100;
		}

		if (!empty( $icon_box_atts ['layout'] )) {
			$classes [] = $icon_box_atts ['layout'];
		}

		if ($icon_box_atts ['spinning'] == 'true') {
			$classes [] = 'icon-box-spinning';
		}

		if ($icon_box_atts['icon_type'] == 'icon-font'){
			$icon = $this->icon_shortcode($icon_box_atts);
		}
		else{
			$icon = '<img src="' . esc_url(wp_get_attachment_url ( $icon_box_atts['image'] )) . '" width="'.esc_attr($icon_box_atts['icon_size']).'px">';
		}

		$animation = '';
		if (!empty($icon_box_atts['icon_animation'])){
			$animation = ' c-has-animation ' . $icon_box_atts['icon_animation'];
		}

		$classes[] = _luv_enqueue_inline_css(array('child' => $child_styles));

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $classes ) ), 'luv_icon_box', $atts );

		$title_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'luv_icon_box_title', array(
				'font_family' => $icon_box_atts['title_font_family'],
				'font_size' => $icon_box_atts['title_font_size'],
				'responsive_font_size' => $icon_box_atts['title_responsive_font_size'],
				'font_color' => $icon_box_atts['title_font_color'],
				'font_weight' => $icon_box_atts['title_font_weight']
		));

		$html = '<div class="icon-box' . (!empty( $classes ) ? ' ' . $classes : '') . '">' .
				'<div class="icon-box-icon' . $animation . ' ' . _luv_enqueue_inline_css ( array (
					'style' => implode ( ';', $icon_styles ),
				) ) . '">' . $icon . '</div>' .
				'<div class="icon-box-content '._luv_enqueue_inline_css ( array ('style' => 'padding-left:' . $content_padding . 'px !important')).'">' .
				(!empty($icon_box_atts['title']) ? '<'.$icon_box_atts['title_tag'].' class="'. $title_classes .'">'.$icon_box_atts['title'].'</'.$icon_box_atts['title_tag'].'>' : '').
				'<p>' . do_shortcode ( $content ) . '</p>'.
				'</div>' . '</div>';

		return apply_filters('luv_icon_box_shortcode', $html, $atts, $content);
	}


	/**
	 * Icon Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function icon_shortcode($atts = array()) {
		$icon_atts = shortcode_atts ( array (
				'icon' => '',
				'icon_color' => '',
				'icon_size' => 24,
				'tooltip' => 'false',
				'tooltip_text' => '',
				'color_scheme' => 'default',
				'tooltip' => 'false',
				'tooltip_color_scheme' => 'default',
				'tooltip_background_color' => '',
				'tooltip_color' => '',
				'tooltip_text' => '',
				'extra_class' => ''
		), $atts, 'luv_icon' );

		$classes = $data = array();

		if (!empty($icon_atts['extra_class'])){
			$classes[] = $icon_atts['extra_class'];
		}

		// Custom color
		$custom_color = ($icon_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($icon_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$icon_atts['icon_color'] = _get_luvoption($icon_atts['color_scheme']);
		}

		// Icon color
		if (!empty( $icon_atts ['icon_color'] )) {
			$style [] = 'color:' . $icon_atts ['icon_color'] . ' !important';
		}

		// Icon size
		if (!empty( $icon_atts ['icon_size'] )) {
			$style [] = 'font-size:' . $icon_atts ['icon_size'] . 'px';
		}

		// MS Edge fix
		if (preg_match('~edge~i',$_SERVER['HTTP_USER_AGENT'])){
			$icon_atts ['icon'] = str_replace('luv-svg-icon ','', $icon_atts ['icon']);
		}

		if (preg_match ( '~luv-svg-icon~', $icon_atts ['icon'] )) {
			wp_enqueue_script('pathformer', LUVTHEMES_CORE_URI . 'assets/js/min/pathformer-min.js', array('jquery'));
			wp_enqueue_script('vivus', LUVTHEMES_CORE_URI . 'assets/js/min/vivus-min.js', array('jquery','pathformer'));

			if (!empty( $icon_atts ['icon_size'] )) {
				$classes[] = $wrapper_class = _luv_enqueue_inline_css(array('style' => 'height:' . $icon_atts ['icon_size'] . 'px !important;width:' . $icon_atts ['icon_size'] . 'px !important;'));
			}
			$icon_file = str_replace ( 'luv-svg-icon linea-icon-', '', $icon_atts ['icon'] );
			return '<div class="'.$wrapper_class.'"><object id="svg-icon-'.hash('crc32',mt_rand(0,PHP_INT_MAX)).'" type="image/svg+xml" data="' . LUVTHEMES_CORE_URI . 'images/svg/' . $icon_file . '.svg" class="luv-animated-svg fitvidsignore ' . implode(' ', $classes) . '" data-color="'.$icon_atts ['icon_color'].'" '.implode(' ', $data).'></object></div>';
		} else {

			// Tooltip
			if ($icon_atts['tooltip'] == 'true'){

				$tooltip_custom_color = ($icon_atts['tooltip_color_scheme'] != 'default' ? true : false);

				if (in_array($icon_atts['tooltip_color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
					$icon_atts['tooltip_background_color'] = _get_luvoption($icon_atts['tooltip_color_scheme']);
					$icon_atts['tooltip_color'] = _luv_adjust_color_scheme($icon_atts['tooltip_background_color']);
				}

				wp_enqueue_script('tipso', LUVTHEMES_CORE_URI . 'assets/js/min/tipso.min.js', array('jquery'), LUVTHEMES_CORE_VER, true);

				$classes[]	= 'luv-tooltip';
				$data[]		= 'data-tipso="'.$icon_atts['tooltip_text'].'"';

				if ($tooltip_custom_color){
					$data[]		= 'data-tooltip-background-color="'.$icon_atts['tooltip_background_color'].'"';
					$data[]		= 'data-tooltip-color="'.$icon_atts['tooltip_color'].'"';
				}
			}

			// Inline styles
			if (!empty( $style )){
				$classes[] = _luv_enqueue_inline_css(array('parent' => 'html body ','style' => implode ( ';', $style )));
			}

			// Late enqueue ionicons
			if (preg_match ( '~ion-~', $icon_atts ['icon'] )) {
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/ionicons.min.css');
			}
			else if (preg_match ( '~linea-~', $icon_atts ['icon'] )) {
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/linea-icons.css');
			}
			$classes[] = $icon_atts ['icon'];
			$html = '<i class="' . implode(' ', $classes) . '" '.implode(' ', $data).'></i>';

			return apply_filters('luv_icon_shortcode', $html, $atts);
		}
	}


	/**
	 * Dropcaps Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function dropcaps_shortcode($atts = array()) {
		global $luv_enqueued_inline_fonts;
		$dropcaps_atts = shortcode_atts ( array (
				'letter' => '',
				'style' => '',
				'font_family' => '',
				'color_scheme' => 'default',
				'color' => '',
				'background' => ''
		), $atts, 'luv_dropcaps' );

		$styles = array();
		$classes[] = $dropcaps_atts['style'];

		// Custom color
		$custom_color = ($dropcaps_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($dropcaps_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$dropcaps_atts['background'] = _get_luvoption($dropcaps_atts['color_scheme']);
			$dropcaps_atts['color'] = _luv_adjust_color_scheme(_get_luvoption($dropcaps_atts['color_scheme']));
		}

		// Color
		if ($custom_color) {
			if (!empty( $dropcaps_atts['color'] )){
				$styles[] = 'color: ' . $dropcaps_atts['color'] . ' !important';
			}
			if (!empty( $dropcaps_atts['background'] )){
				$styles[] = 'background-color:' . $dropcaps_atts['background'] . ' !important';
			}
		}

		// Font family
		if (!empty($dropcaps_atts['font_family'])){
			$luv_enqueued_inline_fonts[$dropcaps_atts['font_family']]['regular'] = 'regular';
			$styles[] = 'font-family:' . $dropcaps_atts['font_family'] . ' !important';
		}

		$classes[] = _luv_enqueue_inline_css (array(
				'style' => implode(';',$styles)
		));

		$html = '<span class="luv-dropcaps ' . implode ( ' ', $classes ) . '">' . $dropcaps_atts ['letter'] . '</span>';

		return apply_filters('luv_dropcaps_shortcode', $html, $atts, $content);
	}


	/**
	 * Message Box Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function message_box_shortcode($atts = array(), $content) {
		$luv_shortcode_atts = shortcode_atts ( array (
				'border_color' => '',
				'color_scheme' => 'default',
				'color' => '',
				'background_color' => '',
				'close' => 'false',
				'icon' => '',
				'icon_color' => '',
				'icon_size' => '24',
				'animation' => 'slideUp'
		), $atts, 'luv_message_box' );

		$close = '';
		$classes = $icon_classes = array ();
		if ($luv_shortcode_atts ['close'] == 'true') {
			_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/ionicons.min.css');
			$classes [] = 'luv-message-box-close';
			$close = '<span class="luv-message-box-close-trigger" data-animation="' . $luv_shortcode_atts ['animation'] . '"><i class="ion-close"></i></span>';
		}

		if (!empty( $luv_shortcode_atts ['icon_size'] )) {
			$icon_classes[] = _luv_enqueue_inline_css(array('style'=> 'font-size:' . $luv_shortcode_atts ['icon_size'] . 'px !important'));
		}

		$custom_color = ($luv_shortcode_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($luv_shortcode_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$luv_shortcode_atts['color'] = $luv_shortcode_atts ['border_color'] = _get_luvoption($luv_shortcode_atts['color_scheme']);
		}


		// Styles
		$styles = array();
		if (!empty( $luv_shortcode_atts['border_color'] )) {
			$styles[] = 'border-color:' . $luv_shortcode_atts ['border_color'] . ' !important';
		}
		if (!empty( $luv_shortcode_atts['color'] )) {
			$styles[] = 'color:' . $luv_shortcode_atts ['color'] . ' !important';
		}
		if (!empty( $luv_shortcode_atts['background_color'] )) {
			$styles[] = 'background-color:' . $luv_shortcode_atts ['background_color'] . ' !important';
		}

		// Icon
		$icon = '';
		if (!empty( $luv_shortcode_atts['icon'])){
			$classes[] = 'has-icon';
			$icon = $this->icon_shortcode(array_merge($atts, array('extra_class' => 'luv-message-box-icon')));
		}

		$classes [] = _luv_enqueue_inline_css ( array (
				'style' => implode(';', $styles)
		) );

		$html = '<div class="luv-message-box ' . implode ( ' ', $classes ) . '">' . $icon . $close . do_shortcode ( $content ) . '</div>';

		return apply_filters('luv_message_box_shortcode', $html, $atts, $content);
	}

	/**
	 * Team Member Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function team_shortcode($atts = array(), $content = '') {
		$luv_team_atts = shortcode_atts ( array (
				'image' => '',
				'name' => '',
				'position' => '',
				'style' => '',
				'overlay' => '',
				'color' => '',
				'facebook' => '',
				'linkedin' => '',
				'twitter' => '',
				'googleplus' => ''
		), $atts, 'luv_team' );

		$classes [] = $luv_team_atts ['style'];

		if ($luv_team_atts ['overlay'] == 'overlay') {
			$classes [] = 'luv-team-member-overlay';
		}
		else if ($luv_team_atts ['overlay'] == 'hover-overlay') {
			$classes [] = 'luv-team-member-hover-overlay';
		}

		$content_class = '';
		if (!empty( $luv_team_atts ['color'] ) && $luv_team_atts ['overlay'] == 'true') {
			$content_class = ' ' . _luv_enqueue_inline_css ( 'color:' . $luv_team_atts ['color'] . ' !important' );
		}

		$image = wp_get_attachment_image ( $luv_team_atts ['image'] , 'full');

		$social = (!empty( $luv_team_atts ['facebook'] ) ? '<a href="' . esc_url($luv_team_atts ['facebook']) . '"><i class="fa fa-facebook"></i></a> ' : '');
		$social .= (!empty( $luv_team_atts ['linkedin'] ) ? '<a href="' . esc_url($luv_team_atts ['linkedin']) . '"><i class="fa fa-linkedin"></i></a> ' : '');
		$social .= (!empty( $luv_team_atts ['twitter'] ) ? '<a href="' . esc_url($luv_team_atts ['twitter']) . '"><i class="fa fa-twitter"></i></a> ' : '');
		$social .= (!empty( $luv_team_atts ['googleplus'] ) ? '<a href="' . esc_url($luv_team_atts ['googleplus']) . '"><i class="fa fa-google-plus"></i></a> ' : '');

		if (!empty($social)){
			$social = '<span class="luv-team-member-social">' . $social . '</span>';
		}

		$html = '<div class="luv-team-member ' . implode ( ' ', $classes ) . '">' . '<div class="luv-team-member-img">'.$image.'</div>' . '<div class="luv-team-member-details">' . '<h3 class="luv-team-member-name">' . $luv_team_atts ['name'] . '</h4>' . '<span class="luv-team-member-position">' . $luv_team_atts ['position'] . '</span>' . ($luv_team_atts ['overlay'] == 'true' ? '' : '<div class="luv-team-member-description' . $content_class . '">' . $content . '</div>') . $social . '</div>' . '</div>';

		return apply_filters('luv_team_shortcode', $html, $atts, $content);
	}



	/**
	 * Search Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function search_shortcode($atts = array()) {
		$search_atts = shortcode_atts ( array (
				'border_radius' => '0',
				'ajax' => 'false',
				'hide_date' => 'false',
				'hide_excerpt' => 'false',
				'hide_title' => 'false',
				'hide_featured_image' => 'false',
				'posts_per_page' => 5,
				'color_scheme' => 'default',
				'field_background_color' => '',
				'field_border_color' => '',
				'field_text_color' => '',

		), $atts, 'luv_search' );

		$form_elements = '';
		$styles = $classes = array();

		// Colors
		$custom_color = ($search_atts['color_scheme'] != 'default' ? true : false);

		if (in_array($search_atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$search_atts['field_border_color'] = _get_luvoption($atts['color_scheme']);
			$search_atts['field_background_color'] = 'rgba(255,255,255,0.8)';
			$search_atts['field_text_color'] = '#000';
		}

		if (!empty($search_atts['field_border_color'])){
			$styles[] = 'border-color: ' . $search_atts['field_border_color'] . ' !important';
		}
		if (!empty($search_atts['field_background_color'])){
			$styles[] = 'background-color: ' . $search_atts['field_background_color'] . ' !important';
		}
		if (!empty($search_atts['field_text_color'])){
			$styles[] = 'color: ' . $search_atts['field_text_color'] . ' !important';
		}
		if (!empty($search_atts['border_radius'])){
			$styles[] = '-webkit-border-radius: ' . $search_atts['border_radius'] . 'px !important';
			$styles[] = '-moz-border-radius: ' . $search_atts['border_radius'] . 'px !important';
			$styles[] = 'border-radius: ' . $search_atts['border_radius'] . 'px !important';
		}

		$classes[] = _luv_enqueue_inline_css(array('style' => implode(';',$styles)));

		// Set class for jQuery binding and append the hidden result form
		if ($search_atts ['ajax'] == 'true') {
			$classes[] = 'luv-search-ajax';
			$form_elements = '<div class="luv-hidden luv-ajax-results"></div>';
		}

		$html = '<form class="luv-ajax-search-container" action="' . trailingslashit(site_url ()) . '">'.
				'<input type="hidden" name="hide_date" value="'.esc_attr($search_atts['hide_date']).'">'.
				'<input type="hidden" name="hide_excerpt" value="'.esc_attr($search_atts['hide_excerpt']).'">'.
				'<input type="hidden" name="hide_title" value="'.esc_attr($search_atts['hide_title']).'">'.
				'<input type="hidden" name="post_per_page" value="'.esc_attr($search_atts['posts_per_page']).'">'.
				'<input type="hidden" name="hide_featured_image" value="'.esc_attr($search_atts['hide_featured_image']).'">'.
				'<input class="luv-search ' . implode(' ',$classes) . '" autocomplete="off" type="text" name="s" placeholder="' . esc_html__( 'Start typing..', 'fevr' ) . '">'.
				$form_elements.
				'</form>';

		return apply_filters('luv_search_shortcode', $html, $atts);
	}

	/**
	 * Ajax Login Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function login_shortcode($atts = array()) {
		$login_atts = shortcode_atts ( array (
				'login_redirect' => '',
				'logout_redirect' => '',
				'password_recovery' => 'false',
				'layout' => 'horizontal',
				'label_style' => 'label',
				'background_color' => '',
				'color' => '',
				'error_color' => '',
				'success_color' => ''
		), $atts, 'luv_login' );

		$html = '';

		// Redirects
		if (!empty($login_atts['login_redirect'])){
			$login_atts['login_redirect'] = (preg_match('~^http~', $login_atts['login_redirect']) ? $login_atts['login_redirect'] :  site_url($login_atts['login_redirect']));
		}

		if (isset($_GET['redirect_to'])){
			$login_atts['login_redirect'] = $_GET['redirect_to'];
		}

		if (!empty($login_atts['logout_redirect'])){
			$login_atts['logout_redirect'] = (preg_match('~^http~', $login_atts['logout_redirect']) ? $login_atts['logout_redirect'] :  site_url($login_atts['logout_redirect']));
		}

		$classes = $child_classes = $input_classes = $labels = $placeholders = array();

		// Form style
		if ($login_atts['label_style'] == 'label'){
			$labels['username'] = apply_filters('luv_login_label_username', esc_html__('Username:', 'fevr'));
			$labels['password'] = apply_filters('luv_login_label_password', esc_html__('Password:', 'fevr'));
		}
		else{
			$placeholders['username'] = apply_filters('luv_login_placeholder_username', esc_html__('Username', 'fevr'));
			$placeholders['password'] = apply_filters('luv_login_placeholder_password', esc_html__('Password', 'fevr'));
		}

		// Colors

		if (!empty($login_atts['background_color'])){
			$classes[] = 'background-color:' . $login_atts['background_color'] . ' !important';
		}

		if (!empty($login_atts['color'])){
			$classes[] = 'color:' . $login_atts['color'] . ' !important';
		}

		if (!empty($login_atts['error_color'])){
			$child_classes['.error .luv-ajax-login-message'] = 'color:' . $login_atts['error_color'] . ' !important;';
		}

		if (!empty($login_atts['success_color'])){
			$child_classes['.success .luv-ajax-login-message'] = 'color:' . $login_atts['success_color'] . ' !important;';
		}

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, _luv_enqueue_inline_css(array('style' => implode(';',$classes), 'child' => $child_classes)), 'luv_custom_grid', $atts );

		// Layout
		$classes .= ' form-' . $login_atts['layout'];

		if (!is_user_logged_in()){
			$html = '<div class="luv-ajax-login-container '.$classes.'" data-logout-url="'.esc_url(wp_logout_url($login_atts['logout_redirect'])).'">'.
					'<div class="luv-ajax-login-overlay"></div>'.
					'<div class="luv-ajax-login-message"></div>'.
					'<form class="luv-ajax-login" action="' . admin_url('admin-ajax.php') . '">'.
					'<div class="l-grid-row">'.
					(isset($labels['username']) ? '<div class="l-grid-4"><label>' . $labels['username'] . '</label></div>' : '').
					'<div class="'.(isset($labels['username']) ? 'l-grid-8' : 'l-grid-12').'"><input type="text" name="username" '.(isset($placeholders['username']) ? 'placeholder="' . $placeholders['username'] . '"' : '').'></div>'.
					(isset($labels['password']) ? '<div class="l-grid-4"><label>' . $labels['password'] . '</label></div>' : '').
					'<div class="'.(isset($labels['password']) ? 'l-grid-8' : 'l-grid-12').'"><input type="password" name="password" '.(isset($placeholders['password']) ? 'placeholder="' . $placeholders['password'] . '"' : '').'></div>'.
					'<input type="hidden" name="redirect_to" value="'.esc_url($login_atts['login_redirect']).'">'.
					'<input type="hidden" name="action" value="luv_ajax_login">'.
					wp_nonce_field( 'ajax-login-nonce', 'luv-vc-addons', true, false).
					'<div class="'.(isset($labels['username']) ? 'l-grid-offset-4 l-grid-8' : 'l-grid-12').'"><button class="btn btn-full">'.apply_filters('luv_login_button_text', esc_html__('Login', 'fevr')).'</button>'.($login_atts['password_recovery'] == 'true' ? ' <a href="#" class="luv-login-action-link luv-password-recovery-trigger">'.apply_filters('luv_login_lost_password_link_text', esc_html__('Lost your password?', 'fevr')).'</a>' : '').'</div>'.
					'</div>'.
					'</form>';

				if ($login_atts['password_recovery'] == 'true'){
					$html .= '<form class="luv-ajax-login is-hidden" action="' . admin_url('admin-ajax.php') . '">'.
							 '<div class="l-grid-row">'.
							 (isset($labels['username']) ? '<div class="l-grid-4"><label>' . $labels['username'] . '</label></div>' : '').
							 '<div class="'.(isset($labels['username']) ? 'l-grid-8' : 'l-grid-12').'"><input type="text" name="username" '.(isset($placeholders['username']) ? 'placeholder="' . $placeholders['username'] . '"' : '').'></div>'.
							 '<input type="hidden" name="action" value="luv_ajax_retrieve_password">'.
							 wp_nonce_field( 'ajax-login-nonce', 'luv-vc-addons', true, false).
						 	 '<div class="'.(isset($labels['username']) ? 'l-grid-offset-4 l-grid-8' : 'l-grid-12').'"><button class="btn btn-full">'.apply_filters('luv_recover_password_button_text', esc_html__('Get New Password', 'fevr')).'</button><a href="#" class="luv-login-action-link luv-back-to-login-trigger">'.apply_filters('luv_login_back_to_login_link_text', esc_html__('Go back to Login', 'fevr')).'</a></div>'.
						 	 '</div>'.
							 '</form>';
				}

				$html .= 	'</div>';
		}
		else{
			$current_user = wp_get_current_user();
			$html = '<div class="'.$classes.'">'.sprintf(esc_html__('You are logged in as %s'), $current_user->display_name).' <a href="'.esc_url(wp_logout_url($login_atts['logout_redirect'])).'">'.esc_html__('Logout', 'fevr').'</a></div>';
		}

		return apply_filters('luv_login_shortcode', $html, $atts);
	}

	/**
	 * Register Shortcode
	 * @param array $atts
	 * @return string
	 */
	public function register_shortcode($atts = array()) {
		$register_atts = shortcode_atts ( array (
				'redirect' => '',
				'logged_in_redirect' => '',
				'layout' => 'horizontal',
				'label_style' => 'label',
				'background_color' => '',
				'color' => '',
				'error_color' => '',
				'success_color' => ''
		), $atts, 'luv_register' );

		$html = '';

		// Redirects
		$redirect= (!empty($register_atts['redirect']) ? $register_atts['redirect'] : site_url('login'));
		$redirect = (preg_match('~^http~', $redirect) ? $redirect :  site_url($redirect));

		$logged_in_redirect= (!empty($register_atts['logged_in_redirect']) ? $register_atts['logged_in_redirect'] : site_url());
		$logged_in_redirect = (preg_match('~^http~', $logged_in_redirect) ? $logged_in_redirect :  site_url($logged_in_redirect));

		$classes = $child_classes = $input_classes = $labels = $placeholders = array();

		// Form style
		if ($register_atts['label_style'] == 'label'){
			$labels['username'] = apply_filters('luv_register_label_username', esc_html__('Username:', 'fevr'));
			$labels['email'] = apply_filters('luv_register_label_email', esc_html__('E-mail:', 'fevr'));
			$labels['password'] = apply_filters('luv_register_label_password', esc_html__('Password:', 'fevr'));
			$labels['password-repeat'] = apply_filters('luv_register_label_password_repeat', esc_html__('Repeat Password:', 'fevr'));
		}
		else{
			$placeholders['username'] = apply_filters('luv_register_placeholder_username', esc_html__('Username', 'fevr'));
			$placeholders['email'] = apply_filters('luv_register_placeholder_email', esc_html__('E-mail', 'fevr'));
			$placeholders['password'] = apply_filters('luv_register_placeholder_password', esc_html__('Password', 'fevr'));
			$placeholders['password-repeat'] = apply_filters('luv_register_placeholder_password_repeat', esc_html__('Repeat Password', 'fevr'));
		}

		// Colors

		if (!empty($register_atts['background_color'])){
			$classes[] = 'background-color:' . $register_atts['background_color'] . ' !important';
		}

		if (!empty($register_atts['color'])){
			$classes[] = 'color:' . $register_atts['color'] . ' !important';
		}

		if (!empty($register_atts['error_color'])){
			$child_classes['.error .luv-ajax-register-message'] = 'color:' . $register_atts['error_color'] . ' !important;';
		}

		if (!empty($register_atts['success_color'])){
			$child_classes['.success .luv-ajax-register-message'] = 'color:' . $register_atts['success_color'] . ' !important;';
		}

		$classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, _luv_enqueue_inline_css(array('style' => implode(';',$classes), 'child' => $child_classes)), 'luv_custom_grid', $atts );

		// Layout
		$classes .= ' form-' . $register_atts['layout'];

		if (!is_user_logged_in()){
			$html = '<div class="luv-ajax-register-container '.$classes.'">'.
					'<div class="luv-ajax-register-overlay"></div>'.
					'<div class="luv-ajax-register-message"></div>'.
					'<form class="luv-ajax-register" action="' . admin_url('admin-ajax.php') . '">'.
					'<div class="l-grid-row">'.
					(isset($labels['username']) ? '<div class="l-grid-4"><label>' . $labels['username'] . '</label></div>' : '').
					'<div class="'.(isset($labels['username']) ? 'l-grid-8' : 'l-grid-12').'"><input type="text" name="username" '.(isset($placeholders['username']) ? 'placeholder="' . $placeholders['username'] . '"' : '').'></div>'.
					(isset($labels['email']) ? '<div class="l-grid-4"><label>' . $labels['email'] . '</label></div>' : '').
					'<div class="'.(isset($labels['email']) ? 'l-grid-8' : 'l-grid-12').'"><input type="text" name="email" '.(isset($placeholders['email']) ? 'placeholder="' . $placeholders['email'] . '"' : '').'></div>'.
					(isset($labels['password']) ? '<div class="l-grid-4"><label>' . $labels['password'] . '</label></div>' : '').
					'<div class="'.(isset($labels['password']) ? 'l-grid-8' : 'l-grid-12').'"><input type="password" name="password" '.(isset($placeholders['password']) ? 'placeholder="' . $placeholders['password'] . '"' : '').'></div>'.
					(isset($labels['password-repeat']) ? '<div class="l-grid-4"><label>' . $labels['password-repeat'] . '</label></div>' : '').
					'<div class="'.(isset($labels['password-repeat']) ? 'l-grid-8' : 'l-grid-12').'"><input type="password" name="password-repeat" '.(isset($placeholders['password-repeat']) ? 'placeholder="' . $placeholders['password-repeat'] . '"' : '').'></div>'.
					'<input type="hidden" name="redirect_to" value="'.esc_url($redirect).'">'.
					'<input type="hidden" name="action" value="luv_ajax_register">'.
					wp_nonce_field( 'ajax-register-nonce', 'luv-vc-addons', true, false).
					'<div class="'.(isset($labels['username']) ? 'l-grid-offset-4 l-grid-8' : 'l-grid-12').'"><button class="btn btn-full">'.apply_filters('luv_register_button_text', esc_html__('Register', 'fevr')).'</button></div>'.
					'</div>'.
					'</form>'.
					'</div>';

			$html = apply_filters('luv_register_shortcode_html', $html, $atts);
		}
		else{
			$current_user = wp_get_current_user();
			$html = apply_filters('luv_register_shortcode_already_logged_in_html', '<div class="' . esc_attr($classes) . '" data-force-redirect="'.esc_attr($logged_in_redirect).'" data-force-redirect-nonce="'.wp_create_nonce('luv-force-redirect').'">'.sprintf(esc_html__('You are already logged in as %s'), $current_user->display_name) . ' ' . sprintf(esc_html__('You will be redirected to %s'), ' <a href="'.esc_url($logged_in_redirect) . '">' . esc_url($logged_in_redirect) . '</a>') . '</div>', $atts);
		}

		return apply_filters('luv_register_shortcode', $html, $atts);
	}

	/**
	 * Custom grid shortcode
	 */
	public function custom_grid($atts = array(), $content = ''){
		global $fevr_custom_grid_atts, $post_classes;
		$_luv_custom_grid_atts = $atts;

		$fevr_custom_grid_atts = shortcode_atts ( array (
				'post_types' 			=> '',
				'box_style'				=> '',
				'pagination' 			=> '',
				'posts_per_page' 		=> '12',
				'columns'				=> '',
				'hide_featured_image'	=> 'false',
				'hide_title'			=> 'false',
				'hide_excerpt'			=> 'false',
				'hide_date'				=> 'false',
				'hide_author' 			=> 'false',
				'hide_category'			=> 'false',
				'hide_tags'				=> 'false',
		), $atts, 'luv_custom_grid' );

		$post_classes = array();
		if (!empty($fevr_custom_grid_atts['box_style'])){
			$post_classes[] = $fevr_custom_grid_atts['box_style'];
		}
		$fevr_custom_grid_atts['post_classes'] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $post_classes ) ), 'luv_custom_grid', $atts );

		$content = do_shortcode($content);

		add_filter('posts_where', array($this, 'custom_post_type_where_filter'));
		add_filter('posts_join', array($this, 'custom_post_type_join_filter'));

		ob_start();
		include apply_filters('luv_custom_grid_template_path', LUVTHEMES_CORE_PATH . 'templates/custom-grid.php');
		$grid = ob_get_clean();

		remove_filter('posts_where', array($this, 'custom_post_type_where_filter'));
		remove_filter('posts_join', array($this, 'custom_post_type_join_filter'));

		$data_attributes = array();
		foreach ($fevr_custom_grid_atts as $key=>$attribute){
			if ($key != 'filters'){
				$data_attributes[] = 'data-' . $key . '="' . $attribute . '"';
			}
		}

		$data_attributes[] = 'data-post_classes="'.$fevr_custom_grid_atts['post_classes'].'"';

		$html = '<div class="luv-custom-grid" ' . implode(' ', $data_attributes) . '>' . $content . '<div class="vc_row luv-custom-grid-container">' . $grid . '</div></div>';

		return apply_filters('luv_custom_grid_shortcode', $html, $atts, $content);
	}

	/**
	 * Custom grid filter shortcode
	 */
	public function custom_grid_filter($atts = array(), $content = ''){
		global $fevr_custom_grid_atts;
		$filter_atts = shortcode_atts ( array (
				'label'		=> '',
				'type'		=> 'text',
				'compare' 		=> 'LIKE',
				'meta_compare'	=> 'LIKE',
				'in'			=> 'content',
				'meta_key'		=> '',
				'value'		=> '',
				'meta_type'		=> 'CHAR',
				'radio_group'	=> '',
				'width'		=> '',
				'is_block'		=> 'false',
				'design'		=> ''
		), $atts, 'custom_grid_filter' );

		$styles = array();
		if (!empty($filter_atts['width'])){
			$styles[] = 'width: ' .$filter_atts['width'];
		}

		if ($filter_atts['is_block'] == 'true'){
			$styles[] = 'display: block !important';
		}

		if (!empty( $filter_atts['design'] )) {
			foreach ( json_decode ( str_replace ( "'", '"', $filter_atts['design'] ), true ) as $key => $value ) {
				$styles[] = $key . ':' . ( int ) $value . 'px';
			}
		}

		$compare = ($filter_atts['in'] == 'content' ? $filter_atts['compare'] : $filter_atts['meta_compare']);

		if (!in_array($filter_atts['type'], array('checkbox', 'radio'))){

			if ($filter_atts['type'] == 'dropdown'){
				preg_match('~=(.*)~', $content, $matches);
				$value = strip_tags($matches[1]);
			}
			else{
				$value = $filter_atts['value'];
			}

			$fevr_custom_grid_atts['filters'][] = array(
					'compare' => $compare,
					'meta_key' => $filter_atts['meta_key'],
					'value' => $value,
					'meta_type' => $filter_atts['meta_type'],
					'in' => $filter_atts['in']
			);
		}

		$id = hash('crc32',mt_rand(0,PHP_INT_MAX));

		$label = (!empty($filter_atts['label']) ? '<label for="'.$id.'">' . $filter_atts['label'] . '</label>' : '');

		switch ($filter_atts['type']){
			case 'dropdown':
				$options = '';
				foreach(explode("\n", $content) as $_option){
					@list($option, $value) = explode('=', $_option);
					if (!empty($option)){
						$options .= '<option value="'.(strpos($_option, '=') !== false ? esc_attr(strip_tags($value)) : esc_attr(strip_tags($option))).'">'.esc_attr(strip_tags($option)).'</option>';
					}
				}
				$html = '<div class="luv-custom-grid-filter-container '._luv_enqueue_inline_css(array('style'=>implode(';', $styles))).'">'.$label . '<div class="luv-custom-select"><select class="luv-custom-grid-filter" data-compare="'.$compare.'" data-in="'.$filter_atts['in'].'"'.($filter_atts['in'] == 'meta' ? ' data-meta_key="'.$filter_atts['meta_key'].'" data-meta_type="'.$filter_atts['meta_type'].'"' : '').'>'.$options.'</select></div></div>';
				break;
			default:
				$html = '<div class="luv-custom-grid-filter-container '._luv_enqueue_inline_css(array('style'=>implode(';', $styles))).'">'.$label . '<input id="'.$id.'"'.($filter_atts['type'] == 'radio' ? ' name=' . $filter_atts['radio_group'] . '"' : '').' class="luv-custom-grid-filter" type="'.$filter_atts['type'].'" value="'.$filter_atts['value'].'" data-compare="'.$compare.'" data-in="'.$filter_atts['in'].'"'.($filter_atts['in'] == 'meta' ? ' data-meta_key="'.$filter_atts['meta_key'].'" data-meta_type="'.$filter_atts['meta_type'].'"' : '').'></div>';
		}

		return apply_filters('luv_custom_grid_filter_shortcode', $html, $atts, $content);
	}

	/**
	 * Facebook comments shortcode
	 * @param array $atts
	 * @return string
	 */
	public function facebook_comments_shortcode($atts = array()) {
		$this->enqueue_fb_sdk();
		if (_check_luvoption('facebook-app-id', '', '!=')){
			_luv_late_add_header_meta('<meta property="fb:app_id" content="'._get_luvoption('facebook-app-id').'" />');
		}

		$facebook_comments_atts = shortcode_atts ( array (
				'order'	=> 'social',
				'numposts'	=> 5
		), $atts, 'facebook_comments' );

		$html = '<div class="fb-comments" data-href="'.esc_attr(get_the_permalink()).'" data-width="100%" data-order-by="'.esc_attr($facebook_comments_atts['order']).'" data-numposts="'.esc_attr($facebook_comments_atts['numposts']).'"></div>';

		return apply_filters('luv_facebook_comments_shortcode', $html, $atts);
	}

	/**
	 * Download Locker
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function download_locker_shortcode( $atts = array(), $content = ''){
		$atts = shortcode_atts(array(
			'href'				=> '',
			'user_role'			=> 'all',
			'exclude_user_role'	=> '',
			'user_can'			=> '',
			'user_can_not'		=> '',
			'user_can_not'		=> '',
			'expiry'			=> '',
			'target'			=> '_blank',
			'class'				=> '',
			'fallback'			=> ''
		), $atts);

		//Calculate expiry
		$atts['expiry'] = strtotime($atts['expiry']);

		//Remove inner links from content
		$content = preg_replace('~<a([^>]*)>(.*)</a>~',"$2",$content);


		//Add dummy random padding to atts to prevent bruteforce
		for ($i=0;$i<3;$i++){
			$atts[strtolower(wp_generate_password(mt_rand(1,10)))] = wp_generate_password(mt_rand(1,10));
		}
		ksort($atts);
		//Add padding to atts to prevent easy bypass password
		$atts = array_merge(
				array(strtolower(wp_generate_password(mt_rand(1,10))) => wp_generate_password(mt_rand(1,10))),
				$atts,
				array(strtolower(wp_generate_password(mt_rand(1,10))) => wp_generate_password(mt_rand(1,10)))
		);

		$link = site_url() . '?download-locker=' . $this->luv_vc_addons->crypt->encrypt(json_encode($atts));
		$html = '<a href=" ' . esc_url($link) . '" target="'.esc_attr($atts['target']).'"'.(!empty($atts['class']) ? ' class="'.esc_attr($atts['class']).'"' : '').'>'._luv_kses((empty($content) ? $link : $content)).'</a>';

		return apply_filters('luv_download_locker_shortcode', $html, $atts, $content);
	}

	/**
	 * Perspective Box Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function perspective_box_shortcode($atts = array(), $content = ''){
		$html = '<div class="luv-perspective-select-wrapper">'.
				'<ul class="luv-perspective-select">'.
				do_shortcode($content).
				'</ul>'.
				'</div>';

		return apply_filters('luv_perspective_box_shortcode', $html, $atts, $content);
	}

	/**
	 * Perspective Box Image
	 * @param array $atts
	 * @return string
	 */
	public function perspective_image_shortcode($atts = array()){
		$atts = shortcode_atts(array(
				'href'	=> '',
				'image'	=> '',
		), $atts);

		if (empty($atts['href'])){
			$html = '<li><div>'.wp_get_attachment_image((int)$atts['image'], 'large').'</div></li>';
		}
		else{
			$html = '<li><a href="'.esc_attr($atts['href']).'">'.wp_get_attachment_image((int)$atts['image'], 'large').'</a></li>';
		}
		return apply_filters('luv_perspective_image_shortcode', $html, $atts);
	}

	/**
	 * Image Slide Box Shortcode
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function image_slide_box_shortcode($atts, $content = ''){
		$atts = shortcode_atts(array(
				'max_width'	=> '500',
		), $atts);

		$html = '<ul class="luv-image-slide-box '._luv_enqueue_inline_css(array('child' => array(' li' => 'max-width:'.$atts['max_width'].'px !important;'))).'">'.
			   do_shortcode($content).
			   '</ul>';

		return apply_filters('luv_slider_box_shortcode', $html, $atts, $content);
	}

	/**
	 * Image Slide Box Element
	 * @param array $atts
	 * @return string
	 */
	public function image_slide_box_image_shortcode($atts = array()){
		$atts = shortcode_atts(array(
				'href'	=> '',
				'image'	=> '',
				'image_size' => 'full'
		), $atts);


		$html = '<li><a href="'.esc_attr($atts['href']).'">'.wp_get_attachment_image((int)$atts['image'], $atts['image_size']).'</a></li>';

		return apply_filters('luv_image_slide_box_image_shortcode', $html, $atts);
	}

	/**
	 * Image box
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function image_box_shortcode($atts, $content = ''){
		$atts = shortcode_atts(array(
				'style' => '',
				'title' => '',
				'image' => '',
				'min_height'	=> '200',
				'href' => '',
				'icon' => '',
				'color_scheme' => '',
				'title_color' => '',
				'content_color'	=> '',
				'base_color' => '',
		), $atts);

		$styles = $html = '';
		$child_styles = array();

		// Image
		$image	= wp_get_attachment_image_src($atts['image'], 'large');

		// Colors
		$custom_color = ($atts['color_scheme'] != 'default' ? true : false);

		if (in_array($atts['color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
			$atts['base_color'] = _get_luvoption($atts['color_scheme']);
			if ($atts['style'] == 'bottom-title'){
				$atts['title_color'] = _luv_adjust_color_scheme($atts['base_color']);
			}
		}

		$child_styles[' .luv-image-box-img'] = $child_styles[' .luv-image-box-title'] = $child_styles[':after'] = $child_styles[' .luv-image-box-content'] = $child_styles[' .luv-image-box-title'] = '';

		if ($custom_color){
			if (!empty($atts['title_color'])){
				$child_styles[' .luv-image-box-title']		.= 'color: ' . $atts['title_color'] . '!important;';
			}
			if (!empty($atts['content_color'])){
				$child_styles[' .luv-image-box-content']	.= 'color: ' . $atts['content_color'] . '!important;';
			}
			if (!empty($atts['base_color'])){
				$child_styles[':after'] 					.= 'background: ' . $atts['base_color'] . '!important;';
				if ($atts['style'] == 'bottom-title'){
					$child_styles[' .luv-image-box-title']		.= 'background: ' . $atts['base_color'] . '!important;';
				}
			}
		}

		// Styles
		$styles = 'min-height: '. $atts['min_height'] . 'px';
		$child_styles[' .luv-image-box-img'] .= 'background-image: url('.$image[0].');';

		$classes[] = _luv_enqueue_inline_css(array('style' => $styles, 'child' => $child_styles));

		// HTML
		if ($atts['style'] == 'bottom-title'){

			$icon = '';
			if ($atts['icon'] != ''){
				$icon = $this->icon_shortcode(array(
						'icon' => $atts['icon']
				));
			}

			$classes[] = 'luv-image-box-title-bottom';
			$html .= (!empty($content) ? '<div class="luv-image-box-inner"><div class="luv-image-box-content">'.do_shortcode($content).'</div></div>' : '');
			$html .= '<h4 class="luv-image-box-title">'.$atts['title'] . $icon .'</h4>';
		}
		else{
			$html .= '<div class="luv-image-box-inner">';
			$html .= (!empty($atts['title']) ? '<h4 class="luv-image-box-title">'.$atts['title'].'</h4>' : '');
			$html .= (!empty($content) ? '<div class="luv-image-box-content">'.do_shortcode($content).'</div>' : '');
			$html .= '</div>';
		}

		$html .= (!empty($atts['href']) ? '<a class="luv-image-box-link" href="'.esc_attr($atts['href']).'"></a>' : '');

		$html = '<div class="luv-image-box '.esc_attr(implode(' ', $classes)).'">'.
				'<div class="luv-image-box-img"></div>'.
				$html.
				'</div>';

		return apply_filters('luv_image_box_shortcode', $html, $atts, $content);

	}

	/**
	 * Generate dummy text
	 * @return string
	 */
	public function lipsum($atts) {
		$atts = shortcode_atts(array(
				'unit' => 'words',
				'count' => 1,
		), $atts);
		include_once LUVTHEMES_CORE_PATH . 'includes/lipsum.class.php';
		$lipsum = new Luv_Lipsum();
		$html = $lipsum->{$atts['unit']}($atts['count']);

		return apply_filters('luv_lipsum_shortcode', $html, $atts);
	}


	/**
	 * WPML Language Selector shortcode
	 * @return string
	 */
	public function wpml_language_selector_shortcode() {
		ob_start();
		do_action('icl_language_selector');
		return ob_get_clean();
	}

	/**
	 * Current year Shortcode
	 * @return string
	 */
	public function current_year_shortcode() {
		return date('Y');
	}

	/**
	 * Site Title Shortcode
	 * @return string
	 */
	public function site_title_shortcode() {
		return get_bloginfo();
	}

	/**
	 * Site Tagline Shortcode
	 * @return string
	 */
	public function site_tagline_shortcode() {
		return get_bloginfo('description');
	}

	/**
	 * Site URL Shortcode
	 * @return string
	 */
	public function site_url_shortcode($atts) {
		if (isset($atts['nolink'])){
			return trailingslashit(site_url());
		}
		return '<a href="'.esc_url(trailingslashit(site_url())).'">'.get_bloginfo().'</a>';
	}

	/**
	 * Login URL Shortcode
	 * @return string
	 */
	public function login_url_shortcode() {
		if (isset($atts['nolink'])){
			return wp_login_url();
		}

		return '<a href="'.esc_url(wp_login_url()).'">'.esc_html__('Login', 'fevr').'</a>';
	}

	/**
	 * Logout URL Shortcode
	 * @return string
	 */
	public function logout_url_shortcode() {
		if (isset($atts['nolink'])){
			return wp_logout_url();
		}
		return '<a href="'.esc_url(wp_logout_url()).'">'.esc_html__('Logout', 'fevr').'</a>';
	}



	//****************************************************
	// Custom fields for VC
	//****************************************************

	/**
	 * Create multiselect field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	function create_vc_wp_category($settings, $value ) {
		$options = '';
		$_value = explode(',',$value);

		$taxonomy = (isset($settings['extra']['taxonomy']) ? array('taxonomy' => $settings['extra']['taxonomy']) : array());

		foreach(get_categories($taxonomy) as $category) {
			$options .= '<li><label><input type="checkbox" class="luv-multiselect-checkbox" value="'.$category->name.'"'.(in_array(strtolower($category->name), $_value) ? ' checked="checked"' : '').'>'.$category->name.'</label></li>';
		}

		return '<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput luv-multiselect-csl ' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' .
				'<a href="#" class="luv-multiselect-check-all luv-multiselect-button">'.esc_html__('Check all', 'fevr').'</a>'.
				'<a href="#" class="luv-multiselect-clear luv-multiselect-button">'.esc_html__('Clear', 'fevr').'</a>'.
				'<ul class="luv-multiselect">' .
				'<li><label><input type="checkbox" class="luv-multiselect-checkbox" value="__related"'.(in_array(strtolower('__related'), $_value) ? ' checked="checked"' : '').'>'.esc_html__('Related', 'fevr').'</label></li>'.
				'<li><hr></li>'.
				$options .
				'</ul>';
	}


	/**
	 * Create url field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_url($settings, $value ) {
		return  '<div class="luv-existing-content-outer">'.
				'<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value ' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field" type="url" value="'.$value.'" />'.
				'<a href="#" class="luv-existing-content-switch">'.esc_html__('Or link an existing content', 'fevr').'</a>'.
				'<div class="luv-existing-content-container luv-hidden">'.
				'<input type="text" class="luv-existing-content-filter" placeholder="'.esc_html__('Search..', 'fevr').'">'.
				'<ul></ul>'.
				'</div>'.
				'</div>';
	}

	/**
	 * Create switch field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_switch($settings, $value ) {
		$id = 'luv_temp_id-' . mt_rand(0,PHP_INT_MAX);

		return  '<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value ' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field" type="hidden" value="'.$value.'" />'.
				'<input id="'.$id.'" type="checkbox" class="luv_switch_checkbox" '.checked($value,'true').'>'.
				'<label for="'.$id.'"></label>';
	}

	/**
	 * Create number field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_number($settings, $value ) {
		$value = isset($settings['value']) && is_null($value) ? $settings['value'] : $value;

		if (isset($settings['extra']['responsive']) && $settings['extra']['responsive'] === true){
			$responseive_values = json_decode(str_replace("'",'"',$value),true);
			$html = '<div class="responsive-number-set">'.
					'<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput responsive-number ' .
					esc_attr($settings['param_name'] ) . ' ' .
					esc_attr($settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .'/>'.
					'<div class="responsive-field-icon"><i class="fa fa-desktop"></i></div><input type="number" value="'.esc_attr($responseive_values['desktop']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-responsive="desktop">'.
					(!isset($settings['extra']['bootstrap']) || $settings['extra']['bootstrap'] != true ? '<div class="responsive-field-icon"><i class="fa fa-laptop"></i></div><input type="number" value="'.esc_attr($responseive_values['laptop']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-responsive="laptop">' : '').
					'<div class="responsive-field-icon"><i class="fa fa-tablet fa-rotate-90"></i></div><input type="number" value="'.esc_attr($responseive_values['tablet-landscape']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-responsive="tablet-landscape">'.
					'<div class="responsive-field-icon"><i class="fa fa-tablet"></i></div><input type="number" value="'.esc_attr($responseive_values['tablet-portrait']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-responsive="tablet-portrait">'.
					'<div class="responsive-field-icon"><i class="fa fa-mobile"></i></div><input type="number" value="'.esc_attr($responseive_values['mobile']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-responsive="mobile">'.
					'</div>';
		}
		else{
			$html = '<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
					esc_attr($settings['param_name'] ) . ' ' .
					esc_attr($settings['type'] ) . '_field" type="number" value="' . esc_attr( $value ) . '"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .'/>';
		}

		return $html;
	}

	/**
	 * Create luv_design field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_luv_design($settings, $value ) {
		$value = empty($value) && isset($settings['value']) ? $settings['value'] : $value;

		$margin_values = json_decode(str_replace("'",'"',$value),true);
		$html = '<div class="margin-set">'.
				'<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput luv_design-margin ' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .'/>'.
				'<div class="luv_design-field-icon"><i class="fa fa-long-arrow-up"></i></div><input type="number" value="'.esc_attr($margin_values['margin-top']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-luv_design="margin-top">'.
				'<div class="luv_design-field-icon"><i class="fa fa-long-arrow-right"></i></div><input type="number" value="'.esc_attr($margin_values['margin-right']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-luv_design="margin-right">'.
				'<div class="luv_design-field-icon"><i class="fa fa-long-arrow-down"></i></div><input type="number" value="'.esc_attr($margin_values['margin-bottom']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-luv_design="margin-bottom">'.
				'<div class="luv_design-field-icon"><i class="fa fa-long-arrow-left"></i></div><input type="number" value="'.esc_attr($margin_values['margin-left']).'"'. (isset($settings['extra']['min']) ? ' min="' . $settings['extra']['min'] . '"' : '') . (isset($settings['extra']['max']) ? ' max="' . $settings['extra']['max'] . '"' : '') .' data-luv_design="margin-left">'.
				'</div>';

				return $html;
	}

	/**
	 * Create iconset field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_iconset($settings, $value){
		global $luv_iconset;

		$options = '';
		$icons = '';

		$iconset_id = array(
				'FontAwesome'	=> array('name' => 'Font Awesome', 'class' => 'fa'),
				'IonIcons'		=> array('name' => 'IonIcons', 'class' => 'ion'),
				'LineaIcons'	=> array('name' => 'Linea Icons', 'class' => 'linea'),

		);

		if (isset($settings['extra']['svg']) && $settings['extra']['svg'] == true){
			global $luv_svg_iconset;
			$luv_iconset = array_merge(apply_filters('luv_iconset', $luv_iconset), apply_filters('luv_svg_iconset', $luv_svg_iconset));
			$iconset_id['SVGLineaIcons'] =  array('name' => 'Animated Linea Icons', 'class' => 'luv-svg-icon');
		}
		foreach($luv_iconset as $key=>$iconset){
			$options .= '<option value=' . $key . ' '.(preg_match('~^'.$iconset_id[$key]['class'].'~', $value) ? 'selected="selected"' : '').'>' . $iconset_id[$key]['name'] . '</option>';
			$icons .= '<ul class="luv-iconset' . ((empty($value) && !isset($not_first) || preg_match('~^'.$iconset_id[$key]['class'].'~', $value)) ? '' : ' luv-hidden') .'" data-iconset="'.$key.'">';
			foreach ($iconset as $icon){
				$icons .= '<li'.($value == $icon ? ' class="active"' : '').'><i class="'.$icon.'"></i></li>';
			}
			$icons .= '</ul>';
			$not_first = true;
		}

		return '<div class="luv-custom-select"><select class="luv-iconset-filter">'.
				$options.
				'</select></div>'.
				'<input type="text" class="luv-icon-filter" placeholder="' . esc_html__('Search for icons', 'fevr') . '">'.
				$icons.
				'<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field icon-holder" type="hidden" value="' . esc_attr( $value ) . '" />';

	}

	/**
	 * Create icon_select field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_icon_select($settings, $value){

		$icons = '';
		foreach ((array)$settings['value'] as $icon=>$val){
			$icons .= '<li'.($value == $val ? ' class="active"' : '').'><i class="'.$icon.'" data-value="'.$val.'"></i></li>';
		}

		return  '<ul class="luv-icon-select">'.
				$icons.
				'</ul>'.
				'<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field icon-holder" type="hidden" value="' . esc_attr( $value ) . '" />';

	}

	/**
	 * Create key_value field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_key_value($settings, $value){

		$fields = '';
		foreach(explode("\n", trim($value)) as $option){
			@list($label, $val) = explode('=', $option);
			$fields .=	'<div class="luv_key_value_fields_container">'.
						'<input type="text" class="luv_vc_key_value" data-type="key" value="'.$label.'">'.
						'<input type="text" class="luv_vc_key_value" data-type="value" value="'.$val.'">'.
						'<a href="#" class="luv_remove_vc_key_value"><i class="fa fa-times"></i></a>'.
						'<a href="#" class="luv_add_vc_key_value"><i class="fa fa-plus"></i></a>'.
						'</div>';
		}

		$fields .=  '<div class="luv_key_value_fields_container">'.
					'<input type="text" class="luv_vc_key_value" data-type="key">'.
					'<input type="text" class="luv_vc_key_value" data-type="value">'.
					'<a href="#" class="luv_remove_vc_key_value"><i class="fa fa-times"></i></a>'.
					'<a href="#" class="luv_add_vc_key_value"><i class="fa fa-plus"></i></a>'.
					'</div>';


		return  '<div class="luv_key_value_container">'.
				'<textarea name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field icon-holder luv-hidden">' . esc_textarea( $value ) . '</textarea>'.
				'<div class="luv_vc_key_value_title">'.esc_html__('Label', 'fevr').'</div>'.
				'<div class="luv_vc_key_value_title">'.esc_html__('Value', 'fevr').'</div>'.
				$fields.
				'</div>';
	}


	/**
	 * Create attach media field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_attach_media($settings, $value){

		return '<div class="luv-media-upload-container media-file">'.
				'<input name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field icon-holder luv-media-upload-url" type="text" value="' . esc_attr( $value ) . '" />'.
				'<div class="luv-media-buttons">'.
				'<span class="button media_upload_button luv-media-upload">'. (!empty($value) ? 'Modify' : 'Upload') .'</span>'.
				'<span class="button remove-image luv-media-upload-reset '. (!empty($value) ? '' : 'luv-hidden') .'">Remove</span>'.
				'</div>'.
				'</div>';
	}

	/**
	 * Create tokenfield for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_tokenfield( $settings, $value ) {
		$tokens = '';
		$inputs = '';

		foreach ($settings['tokens'] as $key=>$input){
			$inputs .= '<li>'.$input.'</li>';
		}
		foreach (explode(',',$value) as $_value){
			if (!empty($_value)){
				$tokens .= '<span class="token"><span class="token-label">'.$_value.'</span><a class="remove" href="#">x</a></span>';
			}
		}

		return '<div class="vc_tokenfield_block">'
				.'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput vc_tokenfield ' .
				esc_attr( $settings['param_name'] ) . ' ' .
				esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' .
				'<div class="tokenfield">'.$tokens.'</div>'.
				'<input type="text" class="autocomplete">'.
				'<ul class="vc_tokenlist">'.$inputs.'<li class="pseudo-element"></li></ul>'.
				'</div>';
	}

	/**
	 * Create font field for VC
	 * @param unknown $settings
	 * @param unknown $value
	 */
	public function create_vc_luv_font( $settings, $value ) {
		global $luv_font_id;

		$luv_font_id = mt_rand(0,PHP_INT_MAX);

		$options = '';
		if (isset($settings['value'])){
			foreach ((array)$settings['value'] as $font){
				$options .= '<option value="'.$font.'" '.selected($font, $value).'>'.$font.'</option>';
			}
		}


		return '<div class="luv-custom-select"><select name="' . esc_attr( $settings['param_name'] ) . '" data-luv-font-id="'.$luv_font_id.'" class="wpb_vc_param_value wpb-dropdown luv-font ' .
				esc_attr( $settings['param_name'] ) . ' ' .
				esc_attr( $settings['type'] ) . '_field">' .
				$options .
				'</select></div><div class="luv-font-preview">'.esc_html__('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'fevr').'</div>'.
				'<script>jQuery(\'.luv-font\').trigger(\'change\');</script>';
	}

	/**
	 * Create font weight select field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_luv_font_weight($settings, $value){
		global $luv_font_id;
		$output = '';
		$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );
		$output .= '<div class="luv-custom-select"><select name="'
				. $settings['param_name']
				. '" class="wpb_vc_param_value wpb-input wpb-select luv-font-weight-' . $luv_font_id . ' '
						. $settings['param_name']
						. ' ' . $settings['type']
						. ' ' . $css_option
						. '" data-option="' . $css_option . '" data-value="'.$value.'">';
						if ( is_array( $value ) ) {
							$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
						}
						if ( ! empty( $settings['value'] ) ) {
							foreach ( $settings['value'] as $index => $data ) {
								if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
									$option_label = $data;
									$option_value = $data;
								} elseif ( is_numeric( $index ) && is_array( $data ) ) {
									$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
									$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
								} else {
									$option_value = $data;
									$option_label = $index;
								}
								$selected = '';
								$option_value_string = (string) $option_value;
								$value_string = (string) $value;
								if ( '' !== $value && $option_value_string === $value_string ) {
									$selected = ' selected="selected"';
								}
								$option_class = str_replace( '#', 'hash-', $option_value );
								$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
										. htmlspecialchars( $option_label ) . '</option>';
							}
						}
						$output .= '</select></div>';

						return $output;
	}

	/**
	 * Create post selector field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_posts($settings, $value){
		$options = '';
		foreach( get_posts(array('post_type' => $settings['extra']['post_type'], 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC')) as $option ){
			$options .= '<option value="' . $option->ID . '"' . selected($value, $option->ID) . '>'. (!empty($option->post_title) ? $option->post_title : esc_html__('No title', 'fevr')) .'</option>';
		}
		return	'<div class="luv-custom-select"><select name="' . esc_attr($settings['param_name'] ) . '" class="wpb_vc_param_value wpb-dropdown' .
				esc_attr($settings['param_name'] ) . ' ' .
				esc_attr($settings['type'] ) . '_field" >'.
				$options.
				'</select></div>';
	}

	/**
	 * Create custom select field for VC
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	public function create_vc_luv_dropdown($settings, $value){
			$output = '';
			$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );
			$output .= '<div class="luv-custom-select"><select name="'
			           . $settings['param_name']
			           . '" class="wpb_vc_param_value wpb-input wpb-select '
			           . $settings['param_name']
			           . ' ' . $settings['type']
			           . ' ' . $css_option
			           . '" data-option="' . $css_option . '">';
			if ( is_array( $value ) ) {
				$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
			}
			if ( ! empty( $settings['value'] ) ) {
				foreach ( $settings['value'] as $index => $data ) {
					if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
						$option_label = $data;
						$option_value = $data;
					} elseif ( is_numeric( $index ) && is_array( $data ) ) {
						$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
						$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
					} else {
						$option_value = $data;
						$option_label = $index;
					}
					$selected = '';
					$option_value_string = (string) $option_value;
					$value_string = (string) $value;
					if ( '' !== $value && $option_value_string === $value_string ) {
						$selected = ' selected="selected"';
					}
					$option_class = str_replace( '#', 'hash-', $option_value );
					$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
					           . htmlspecialchars( $option_label ) . '</option>';
				}
			}
			$output .= '</select></div>';

			return $output;
	}

	/**
	 * Create info box for VC editor
	 */
	public function create_vc_luv_warning($settings, $value){
		return '<p>' . $settings['message'] . '</p>';
	}

	//****************************************************
	// Helpers
	//****************************************************

	/**
	 * Get template part, or silent fail
	 * @param string $slug
	 * @param string $name
	 */
	public function get_template_part($slug, $name = ''){
		$_name = !empty($name) ? '-' . $name : '';
		if (locate_template($slug . $_name . '.php') != '') {
			// load the page template
			get_template_part($slug, $name);
		}
	}

	/**
	 * Get pagination links for shortcodes
	 * @param WP_Query object $query
	 * @param array $luv_shortcode_atts
	 */
	public function shortcode_pagination($query, $atts = array()){
		// Backup original global query
		global $wp_query, $fevr_pagination_shortcode_atts, $fevr_meta_fields;

		$fevr_pagination_shortcode_atts = $atts;

		$_wp_query = $wp_query;
		$wp_query = $query;

		$this->get_template_part( 'luvthemes/luv-templates/pagination' );

		// Restore original global query
		$wp_query = $_wp_query;

	}


	/**
	 * Enqueue Facebook SDK for later use
	 */
	public function enqueue_fb_sdk(){
		if (_check_luvoption('enqueue-facebook-sdk', 1)){
			global $fevr_footer_assets;
			$async_init = '';
			if (_check_luvoption('facebook-app-id', '', '!=')){
				$async_init = 'window.fbAsyncInit = function() {'."\n".
						'	FB.init({'."\n".
						'	appId: "'._get_luvoption('facebook-app-id').'",'."\n".
						'   version : "v2.5",'.
						'	status: true,'."\n".
						'	cookie: true,'."\n".
						'	xfbml: true,'."\n".
						'	oauth: true'."\n".
						'	});'."\n".
						"}\n";
			}
			$fevr_footer_assets['luv_vca_fb_sdk'] =  '<div id="fb-root"></div>'.
					'<script>'.
					'(function(d, s, id) {'.
					'var js, fjs = d.getElementsByTagName(s)[0];'.
					'if (d.getElementById(id)) return;'.
					'js = d.createElement(s); js.id = id;'.
					'js.src = "//connect.facebook.net/'.get_locale().'/sdk.js#xfbml=1&version=v2.5";'.
					'fjs.parentNode.insertBefore(js, fjs);'.
					'}(document, \'script\', \'facebook-jssdk\'));'.$async_init.'</script>';
		}
	}

	/**
	 * Print Enqueued SDKs in the footer
	 */
	public function print_footer_assets(){
		global $fevr_footer_assets, $luv_one_page_sections;
		if (!empty($luv_one_page_sections) && is_singular()){
			echo '<ul class="one-page-slide-dots">';
			foreach((array)$luv_one_page_sections as $section){
				 	echo '<li class="one-page-slide-dot"><a href="'.esc_attr($section).'"></a></li>';
			}
			echo '</ul>';
		}
		echo implode("\n",(array)$fevr_footer_assets);
	}

	/**
	 * Check dependencies (eg: plugins)
	 * @param array $shortcode
	 */
	public function is_shortcode_available($shortcode){
		if (isset($shortcode['depends'])){
			switch($shortcode['depends']['check']){
				case 'class_exists':
				default:
					if (!class_exists($shortcode['depends']['condition'])){
						return false;
					}
			}
		}
		return true;
	}

	/**
	 * Returns the capabilities of the current user
	 *
	 * @return array capability list
	 **/
	public function get_current_caps() {
		global $wp_roles;
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		return $roles;
	}

	/**
	 * Add filter to wp_query where to alter search
	 * @param string $where
	 */
	public function custom_post_type_where_filter($where){
		global $fevr_custom_grid_atts, $wpdb;
		if (isset($fevr_custom_grid_atts['filters'])){
			foreach ((array)$fevr_custom_grid_atts['filters'] as $filter){
				if ($filter['in'] == 'content'){
					if ($filter['compare'] == 'LIKE'){
						$where .= ' AND ('.$wpdb->posts.'.post_title LIKE "%'.trim(esc_sql($filter['value'])).'%" OR '.$wpdb->posts.'.post_content LIKE "%'.trim(esc_sql($filter['value'])).'%")';
					}
					else if ($filter['compare'] == 'NOT LIKE'){
						$where .= ' AND ('.$wpdb->posts.'.post_title NOT LIKE "%'.trim(esc_sql($filter['value'])).'%" AND '.$wpdb->posts.'.post_content NOT LIKE "%'.trim(esc_sql($filter['value'])).'%")';
					}
					else if ($filter['compare'] == 'EQUALS'){
						$where .= ' AND ('.$wpdb->posts.'.post_title = "%'.trim(esc_sql($filter['value'])).'%" OR '.$wpdb->posts.'.post_content = "%'.trim(esc_sql($filter['value'])).'%")';
					}
				}
				else if ($filter['in'] == 'category'){
					if ($fevr_custom_grid_atts['post_types'] == 'product'){
						$taxonomy = get_term_by('name', $filter['value'], 'product_cat');
					}
					else{
						$taxonomy = get_term_by('name', $filter['value'], 'category');
					}
					if ($taxonomy !== false){
						$id = 'a' . hash('crc32', serialize($filter));
						$where .= ' AND ( '.$id.'.term_taxonomy_id IN ('.$taxonomy->term_id.') ) ';
					}
					else{
						$where .= ' AND 1=2';
					}
				}
			}
		}
		return $where;
	}

	/**
	 * Add filter to wp_query join to alter search
	 * @param string $where
	 */
	public function custom_post_type_join_filter($join){
		global $fevr_custom_grid_atts, $wpdb;
		if (isset($fevr_custom_grid_atts['filters'])){
			foreach ((array)$fevr_custom_grid_atts['filters'] as $filter){
				if ($filter['in'] == 'category'){
					$id = 'a' . hash('crc32', serialize($filter));
					$join .= 'INNER JOIN ' . $wpdb->term_relationships . ' ' . $id .' ON (' . $wpdb->posts . '.ID = '.$id.'.object_id) ';
				}
			}
		}
		return $join;
	}

	/**
	 * Override order by for portfolio, blog shortcodes if query runs by ID list
	 */
	public function loop_orderby_filter($orderby_statement) {
		global $luv_loop_orderby_filter;
		$orderby_statement = "FIELD(ID, ".esc_sql($luv_loop_orderby_filter).")";
		return $orderby_statement;
	}

	/**
	 * Remove shortcodes from exceprts
	 * @param string $content
	 * @return string
	 */
	public function remove_shortcode_from_excerpt($content) {
		$content = preg_replace('~\[([^\]]*)\]~','', $content );
		return $content;
	}

	//****************************************************
	// AJAX functions
	//****************************************************

	/**
	 * Reteive search results via AJAX
	 */
	public function ajax_search(){
		$args = array(
				's'					=> (isset($_POST['s']) ? $_POST['s'] : ''),
				'post_type'			=> (isset($_POST['post_type']) ? $_POST['post_type'] : null),
				'posts_per_page'	=> (isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] : 5),
		);

		add_filter('the_excerpt', array($this,'remove_shortcode_from_excerpt'));

		$search_query = new WP_Query( $args );
		if ( $search_query->have_posts() ) {
			while ( $search_query->have_posts() ) {
				$search_query->the_post();
				include LUVTHEMES_CORE_PATH . 'templates/ajax-search.php' ;
			}
		}
		else{
			echo '<div class="luv-ajax-result">' . esc_html__( 'Sorry, no posts matched your criteria.', 'fevr') . '</div>';
		}
		wp_die();
	}

	/**
	 * AJAX login function
	 */
	public function ajax_login() {
		check_ajax_referer( 'ajax-login-nonce', 'luv-vc-addons' );

		// Nonce is checked, get the POST data and sign user on
		$info = array();
		$info['user_login'] = (isset($_POST['username']) ? $_POST['username'] : '');
		$info['user_password'] = (isset($_POST['password']) ? $_POST['password'] : '');
		$info['remember'] = true;

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error($user_signon) ){
			$response = (array('status'=>0, 'message'=>esc_html__('Wrong username or password.', 'fevr')));
		} else {
			$response = (array('status'=>1, 'redirect_to' => isset($_POST['redirect_to']) ? $_POST['redirect_to'] : ''));
		}

		wp_send_json($response);
	}

	public function ajax_retrieve_password(){
		global $wpdb, $wp_hasher;

		$errors = new WP_Error();
		$error  = '';

		if ( empty( $_POST['username'] ) ) {
			$error = esc_html__('<strong>ERROR</strong>: Enter a username or email address.');
		} elseif ( strpos( $_POST['username'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( $_POST['username'] ) );
			if ( empty( $user_data ) ){
				$error = esc_html__('<strong>ERROR</strong>: There is no user registered with that email address.');
			}
		} else {
			$login = trim($_POST['username']);
			$user_data = get_user_by('login', $login);
		}
		/**
		 * Fires before errors are returned from a password reset request.
		 *
		 * @since 2.1.0
		 * @since 4.4.0 Added the `$errors` parameter.
		 *
		 * @param WP_Error $errors A WP_Error object containing any errors generated
		 *                         by using invalid credentials.
		 */
		do_action( 'lostpassword_post', $errors );

		if ( $errors->get_error_code() ){
			$error = $errors->get_error_message();
		}

		if ( !$user_data ) {
			$error = esc_html__('<strong>ERROR</strong>: Invalid username or email.');
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$key = get_password_reset_key( $user_data );

		if ( is_wp_error( $key ) ) {
			return $key;
		}

		$message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";

		if ( is_multisite() ){
			$blogname = $GLOBALS['current_site']->site_name;
		}
		else{
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		}
		$title = sprintf( __('[%s] Password Reset'), $blogname );

		/**
		 * Filter the subject of the password reset email.
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $title      Default email title.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

		/**
		 * Filter the message body of the password reset mail.
		 *
		 * @since 2.8.0
		 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $message    Default mail message.
		 * @param string  $key        The activation key.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

		if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ){
			$error = esc_html__('The email could not be sent.') . "\n" . esc_html__('Possible reason: your host may have disabled the mail() function.');
		}

		if ( !empty($error) ){
			$response = ( array('status'=>0, 'message'=>$error) );
		} else {
			$response = ( array('status'=>2, 'message' => esc_html('Please check your e-mail address', 'fevr')) );
		}

		wp_send_json($response);
  	}

  	/**
	 * AJAX register function
	 */
	 public function ajax_register() {
			check_ajax_referer( 'ajax-register-nonce', 'luv-vc-addons' );

			// Validations
			$error = '';
			if (apply_filters('luv_register_shortcode_check_username', true) && empty($_POST['username'])){
				$error = esc_html__('Username can not be empty', 'fevr');
			}
			else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$error = esc_html__('E-mail address is invalid', 'fevr');
			}
			else if (empty($_POST['password'])){
				$error = esc_html__('Password can not be empty', 'fevr');
			}
			else if ($_POST['password'] != $_POST['password-repeat']){
				$error = esc_html__('Password doesn not match the confirm password', 'fevr');
			}

			/**
			 * This filter can be used for custom validation
			 */
			$error = apply_filters('luv_register_shortcode_error', $error, $user_id);

			// Nonce is checked, get the POST data and sign user on
			$info = array();
			$info['email'] = (isset($_POST['email']) ? $_POST['email'] : '');
			$info['user_login'] = (isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : $info['email']);
			$info['password'] = (isset($_POST['password']) ? $_POST['password'] : '');
			$info['password_repeat'] = (isset($_POST['password-repeat']) ? $_POST['password-repeat'] : '');

			if (empty($error)){
				if (!username_exists( $info['user_login'] ) && !email_exists($info['email'])) {
					$user_id = wp_create_user( $info['user_login'], $info['password'], $info['email'] );

					// Set nickname
					wp_update_user(
					  apply_filters('luv_register_shortcode_update_user',
						  array(
						    'ID'       => $user_id,
						    'nickname' => $info['user_login']
						  ),
							$user_id
						)
					);

					// Add user role
					$user = new WP_User( $user_id );
					$user->set_role( get_option('default_role') );

					$email_subject = apply_filters('luv_register_shortcode_email_subject', esc_html__('Successfull Registration', 'fevr'));

					ob_start();
					include apply_filters('luv_register_shortcode_email_template', LUVTHEMES_CORE_PATH . 'templates/registration-email.php');
					$email_message = apply_filters('luv_register_shortcode_email_message', ob_get_clean());

					// Set headers
					$headers[] = 'Content-Type: text/html; charset=UTF-8';

					wp_mail( $info['email'], $email_subject, $email_message, apply_filters('luv_register_shortcode_email_headers', $headers), apply_filters('luv_register_shortcode_email_attachments', array()) );
				} else {
					$error = esc_html__('User already exists', 'fevr');
				}
			}

			if (!empty($error)){
				$response = (array('status'=>0, 'message'=>$error));
			} else {
				$response = (array('status'=>1, 'message'=> esc_html__('Registration was successfull'), 'redirect_to' => isset($_POST['redirect_to']) ? $_POST['redirect_to'] : site_url()));
			}

			wp_send_json($response);
	}

	/**
	 * Display custom grid via AJAX
	 * @param array $atts
	 */
	public function ajax_custom_grid($atts = array()) {
		global $fevr_custom_grid_atts;

		if (isset($_POST['grid_data'])){
			foreach((array)$_POST['grid_data'] as $key=>$value){
				$fevr_custom_grid_atts[$key]=$value;
			}
		}

		add_filter('posts_where', array($this, 'custom_post_type_where_filter'));
		add_filter('posts_join', array($this, 'custom_post_type_join_filter'));

		include apply_filters('luv_ajax_custom_grid_template', LUVTHEMES_CORE_PATH . 'templates/custom-grid.php');

		remove_filter('posts_where', array($this, 'custom_post_type_where_filter'));
		remove_filter('posts_join', array($this, 'custom_post_type_join_filter'));

		wp_die();
	}

	/**
	 * Load existing content selector
	 * @param array $atts
	 */
	public function ajax_existing_content_list() {
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'luv')){
			wp_die();
		}

		$args = array(
				'post_type'			=> array('page'),
				'posts_per_page'	=> 15,
				's'					=> $_POST['keyword']
		);
		$query = new WP_Query( $args );
		if ($query->have_posts()){
			while ($query->have_posts()){
				$query->the_post();
				echo '<li><a href="#" class="luv-existing-url-link" data-url="'.esc_url(get_the_permalink()).'">'.esc_html(get_the_title()).'</a></li>';
			}
		}
		else{
			esc_html_e( 'Sorry, no posts matched your criteria.', 'fevr' );
		}

		wp_die();
	}

	/**
	 * Load share count via ajax for given URL
	 * This function uses $_POST['url'] to determine URL and $_POST['channel'] to determine social channel
	 */
	public function ajax_load_share_count(){
		$url		= isset($_POST['url']) ? $_POST['url'] : site_url();
		$channel	= isset($_POST['channel']) ? $_POST['channel'] : '';
		switch($channel){
			case 'facebook':
				$response = wp_remote_get('http://graph.facebook.com/?id='.$url.'&format=json');
				if (!is_wp_error($response)){
					$response = json_decode($response['body'], true);
					$count = (isset($response['share']['share_count']) ? $response['share']['share_count'] : 0);
					$count = ($count > 1000000 ? (intval($count/100000)/10) . 'M' : ($count > 1000 ? (intval($count/100)/10) . 'k' : $count));
					echo $count;
				}
				else{
					echo 0;
				}
				break;
			case 'twitter':
				// Get counts is removed and no direct replacement at the current time.
				return 0;
				$response = wp_remote_get('http://urls.api.twitter.com/1/urls/count.json?url='.urlencode($url));
				if (!is_wp_error($response)){
					$response = json_decode($response['body'], true);
					$count = (isset($response['count']) ? $response['count'] : 0);
					$count = ($count > 1000000 ? (intval($count/100000)/10) . 'M' : ($count > 1000 ? (intval($count/100)/10) . 'k' : $count));
					echo $count;
				}
				else{
					echo 0;
				}
				break;
			case 'google-plus':
				$args = array(
				'body'		=> '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.urldecode($url).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]',
				'timeout'	=> 5,
				'headers'	=> array('Content-type' => 'application/json'),
				'sslverify'	=> false
				);
				$response = wp_remote_post('https://clients6.google.com/rpc', $args);
				if (!is_wp_error($response)){
					$response = json_decode($response['body'], true);
					$count = (isset($response[0]['result']['metadata']['globalCounts']['count']) ? round($response[0]['result']['metadata']['globalCounts']['count']) : 0);
					$count = ($count > 1000000 ? (intval($count/100000)/10) . 'M' : ($count > 1000 ? (intval($count/100)/10) . 'k' : $count));
					echo $count;
				}
				else{
					echo 0;
				}
				break;
			case 'linkedin':
				$response = wp_remote_get('https://www.linkedin.com/countserv/count/share?url='.urlencode($url).'&format=json');
				if (!is_wp_error($response)){
					$response = json_decode($response['body'], true);
					$count = (isset($response['count']) ? $response['count'] : 0);
					$count = ($count > 1000000 ? (intval($count/100000)/10) . 'M' : ($count > 1000 ? (intval($count/100)/10) . 'k' : $count));
					echo $count;
				}
				else{
					echo 0;
				}
				break;
		}

		wp_die();
	}

	/**
	 * Load snippets via AJAX
	 */
	public function ajax_lazyload_snippet(){
		if(is_numeric($_POST['id'])) {
			$id = $_POST['id'];
		} else {
			global $wpdb;
			$id = $wpdb->get_var($wpdb->prepare('SELECT ID FROM ' . $wpdb->posts . ' WHERE post_name = %s AND post_type = "luv_snippets" LIMIT 1', $_POST['id']));
		}

		if (get_the_ID() != $id && !empty($id)){
			global $wp_scripts;

			WPBMap::addAllMappedShortcodes();
			$snippet = get_post($id);
			// Add VC custom css
			$vc_css = get_post_meta($id, '_wpb_post_custom_css', true);
			$vc_css .= get_post_meta($id, '_wpb_shortcodes_custom_css', true);
			_luv_late_add_header_style($vc_css);
			$html = apply_filters('the_content', $snippet->post_content);

			if (isset($wp_scripts->registered['fevr-owlcarousel'])){
				$html.= apply_filters('script_loader_tag', '<script src="' . apply_filters('script_loader_src', $wp_scripts->registered['fevr-owlcarousel']->src) . '"></script>');
			}

			echo apply_filters('luv_lazyload_snippet_html', $html);
		}
		wp_die();
	}

  /**
	 * Check nonce before force redirect
	 */
	public function force_redirect(){
		echo (wp_verify_nonce($_POST['nonce'], 'luv-force-redirect') ? 1 : -1);
		wp_die();
	}

}
?>
