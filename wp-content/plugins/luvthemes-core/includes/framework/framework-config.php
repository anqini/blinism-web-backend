<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "fevr_options";

    //Dynamic fields
    $fevr_social_media = apply_filters('fevr_social_media', array('Facebook' => 'facebook', 'Twitter' => 'twitter', 'Google+' => 'google-plus', 'LinkedIn' => 'linkedin', 'Instagram' => 'instagram', 'Pinterest' => 'pinterest', 'Youtube' => 'youtube', 'Vine' => 'vine', 'Vimeo' => 'vimeo-square', 'Dribbble' => 'dribbble', 'Behance' => 'behance', 'Flickr' => 'flickr', 'GitHub' => 'github', 'StackExchange' => 'stack-exchange', 'SoundCloud' => 'soundcloud', 'VK' => 'vk', 'Android' => 'android', 'Apple' => 'apple'));
    foreach ($fevr_social_media as $key=>$value){
    	//Social media urls
    	$fevr_dynamic_redux_fields['social-media-urls'][] =
    	array(
    			'id'       => 'social-media-urls-'.$value,
    			'type'     => 'text',
    			'title'    => $key,
    	);

    	//Header icons
    	$fevr_dynamic_redux_fields['social-media-icons'][$value] = $key;
    }

   add_filter('redux/options/' . $opt_name . '/sections', 'fevr_dynamic_section');

    function fevr_dynamic_section($sections){
    	global $opt_name;
    	$fevr_options = get_option($opt_name);

    	foreach (get_post_types(array('exclude_from_search' => false)) as $post_type){
    		$search_filter_post_types[$post_type] = ucfirst($post_type);
    		$search_filter_post_types_defaults[$post_type] = 1;
    	}

    	// Add portfolio
    	if (isset($fevr_options['module-portfolio']) && $fevr_options['module-portfolio'] == 1){
	    	$search_filter_post_types['luv_portfolio'] = 'Portfolio';
	    	$search_filter_post_types_defaults['luv_portfolio'] = 1;
    	}

    	// Add WooCommerce Product
    	if (luv_is_plugin_active('woocommerce/woocommerce.php')){
    		$search_filter_post_types['product'] = 'Product';
    		$search_filter_post_types_defaults['product'] = 1;
    	}

    	// Add collection
    	if (luv_is_plugin_active('woocommerce/woocommerce.php') && isset($fevr_options['woocommerce-collections']) && $fevr_options['woocommerce-collections'] == 1){
	    	$search_filter_post_types['luv_collections'] = 'Collections';
	    	$search_filter_post_types_defaults['luv_collections'] = 1;
    	}

    	// Create options and default array
    	if (isset($sections[30]['fields'])){
	    	foreach ((array)$sections[30]['fields'] as $key=>$field){
	    		if ($field['id'] == 'search-filter-post-types'){
	    			$sections[30]['fields'][$key]['options'] = $search_filter_post_types;
	    			$sections[30]['fields'][$key]['default'] = $search_filter_post_types_defaults;
	    		}
	    	}
    	}
    	return $sections;
    }


    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( LUVTHEMES_CORE_PATH . '/includes/framework/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( LUVTHEMES_CORE_PATH . '/includes/framework/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    add_filter('redux/options/' . $opt_name . '/args', 'fevr_change_arguments' );


    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'fevr' ),
        'page_title'           => esc_html__( 'Theme Options', 'fevr'),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-settings',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 83,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'fevr-dashboard',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => LUVTHEMES_CORE_PATH . '/includes/framework/assets/img/luvthemes/menu_icon.png',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'theme-options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => false,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
         'footer_credit'     => esc_html__('Luvthemes - Themes with love', 'fevr'),                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'system_info'          => false,
        // REMOVE

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'fevr' ),
            'content' => esc_attr__( '<p>This is the tab content, HTML is allowed.</p>', 'fevr' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'fevr' ),
            'content' => esc_attr__( '<p>This is the tab content, HTML is allowed.</p>', 'fevr' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_attr__( '<p>This is the sidebar content, HTML is allowed.</p>', 'fevr' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields

    //======================================================================
    // General Settings
    //======================================================================

	Redux::setSection( $opt_name, array(
	    'title'  => esc_html__( 'General Settings', 'fevr' ),
	    'id'   	 => 'general-settings-tab',
	    'icon'   => 'el el-home',
	    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	    'fields' => array(
			array(
        		'id'	=> 'one-page-navigation',
        		'type'	=> 'checkbox',
        		'title'	=> esc_html__( 'One Page Navigation', 'fevr' ),
        		'subtitle' => esc_html__('Enable animated one page navigation', 'fevr'),
        		'default' => 1
	        ),
              array(
                  'id'       => 'one-page-navigation-speed',
                  'type'	   => 'text',
                  'title'    => esc_html__( 'One Page Navigation Animation Speed', 'fevr' ),
                  'subtitle' => esc_html__( 'Navigation speed in milliseconds.', 'fevr' ),
                      'default'  => '500',
                      'required' => array(
                            array('one-page-navigation', '=', 1),
                        )
              ),
	        array(
	            'id'       => 'back-to-top-btn',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Back to Top Button', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this option if you\'d like a back to top button.', 'fevr' ),
	            'default' => '1'
	        ),
	        array(
	            'id'       => 'back-to-top-btn-img',
	            'type'     => 'media',
	            'title'    => esc_html__( 'Custom Back to Top Button', 'fevr' ),
	            'required' => array( 'image-for-logo', "=", '1' ),
	            'mode'     => false,
	            'subtitle' => esc_html__( 'Upload your own if you would like to use custom back to top button.', 'fevr' ),
	            'required' => array('back-to-top-btn', '=', '1'),
	        ),
	        array(
	            'id'       => 'nice-scroll',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Smooth Scrolling', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this function if you\'d like smooth scrolling and styled scrollbar.', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'loading-animation',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Loading Animation', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable for an animated loading icon during page loading.', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'global-button-settings',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Global Button Settings', 'fevr' ),
	            'subtitle' => esc_html__( 'Button style that can be set globally. After setting, the setting can be overridden with the help of shortcodes.', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'button-style',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Button Style', 'fevr' ),
	            'subtitle' => esc_html__('Please choose between the options.', 'fevr'),
	            'options'  => array(
	                'only_border' => array(
	                    'alt' => esc_html__('Only Border', 'fevr' ),
	                	'title' => esc_html__('Only Border', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/default-button.png'
	                ),
	           		'boxed' => array(
	           			'alt' => esc_html__('Full', 'fevr' ),
	           			'title' => esc_html__('Full', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/full-button.png'
	           		),
	           		'3d' => array(
	           			'alt' => esc_html__('3D', 'fevr' ),
	           			'title' => esc_html__('3D', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/3d-button.png'
	           		),
				),
	            'required' => array('global-button-settings', '=', '1'),
	        ),
	        array(
	            'id'       => 'button-style-rounded',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Rounded Buttons', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable for rounded buttons.', 'fevr' ),
	            'required' => array('global-button-settings', '=', '1'),
	        ),
	        array(
	        	'id'       => 'custom-footer-html',
	        	'type'     => 'ace_editor',
	        	'title'    => esc_html__( 'Custom Footer HTML', 'fevr' ),
	        	'subtitle' => esc_html__( 'Paste your tracking code (e.g.: Google Analytics) here.', 'fevr' ),
	        	'mode'     => 'html',
	        	'theme'    => 'monokai',
	        ),
    		array(
    				'id'       => 'custom-after-body-html',
    				'type'     => 'ace_editor',
    				'title'    => esc_html__( 'HTML after &lt;body&gt;', 'fevr' ),
    				'subtitle' => esc_html__( 'Paste your tracking code (e.g.: Google Tag Manager) here.', 'fevr' ),
    				'mode'     => 'html',
    				'theme'    => 'monokai',
    		),
	        array(
	        	'id'       => 'custom-css',
	        	'type'     => 'ace_editor',
	        	'title'    => esc_html__( 'Custom CSS Code', 'fevr' ),
	        	'subtitle' => esc_html__('Paste your custom CSS code here.', 'fevr'),
	        	'mode'     => 'css',
	        	'theme'    => 'monokai',
	        ),
	    ),
	));

	//======================================================================
	// Modules
	//======================================================================
	global $woocommerce;

	Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Modules', 'fevr' ),
        'desc'  => esc_html__( 'Modules available here can be enabled/disabled according to your preferences. For instance, if you don\'t need the portfolio module, you can disable it and it will no longer appear in the left side WordPress navigation.', 'fevr' ),
        'id'    => 'modules-tab',
        'icon'  => 'el el-check',
        'fields' => array(
	        array(
	        		'id'       => 'module-portfolio',
	        		'type'     => 'checkbox',
	        		'title'    => esc_html__( 'Portfolio', 'fevr' ),
	        		'subtitle' => esc_html__( 'Enable Portfolio', 'fevr' ),
	        		'default' => '1',
	        ),
	        array(
	            'id'       => 'module-snippets',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Snippets', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable Snippets', 'fevr' ),
                'default' => '1',
	        ),
	        array(
        		'id'       => 'module-sliders',
        		'type'     => 'checkbox',
        		'title'    => esc_html__( 'Slider', 'fevr' ),
        		'subtitle' => esc_html__( 'Enable Sliders', 'fevr' ),
        		'default' => '1',
	        ),
	        array(
        		'id'       => 'module-luvstock',
        		'type'     => 'checkbox',
        		'title'    => esc_html__( 'LuvStock', 'fevr' ),
        		'subtitle' => esc_html__( 'Enable LuvStock', 'fevr' ),
        		'default' => '1',
	        ),
		),
    ) );

	//======================================================================
	// Color Settings
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Colors', 'fevr' ),
		'id'     => 'accent-colors-tab',
	    'icon'   => 'el el-brush',
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'General', 'fevr' ),
		'desc'  => esc_html__( 'The main colors of the theme can be set here. These settings can be overwritten for each and every section. For example, if you would like an entirely different color for the off canvas menu, you can overwrite it at the custom color settings.', 'fevr' ),
		'id'     => 'accent-colors-tab-general',
	    'subsection' => 'true',
	    'fields' => array(
	        array(
			    'id'       => 'accent-color-1',
			    'type'     => 'color',
			    'title'    => esc_html__('Accent Color #1', 'fevr'),
			    'subtitle' => esc_html__('The base color of the theme. Links, button hover events, top bar, etc. have this color.', 'fevr'),
			    'validate' => 'color',
			    'default' => '#f04649',
			    'compiler'    => array(
				    'border-top-color'		=> '.luv-testimonials.has-image.has-arrow .luv-testimonials-content:after',
			        'background-color' 		=> '.wc-style-5 ul.products li .product-wrapper .item-wrapper > a:hover, #content-wrapper .masonry-standard article.hentry .post-meta-cat.post-meta span > *:hover, #content-wrapper .timeline article.hentry .post-meta-cat.post-meta span > *:hover, .btn:active, .luv-testimonials.has-image .luv-testimonials-content, .social-share-container .luv-social-buttons a.luv-liked span,.social-share-container .luv-social-buttons a.luv-liked:hover span, .social-share-container .luv-social-buttons a.luv-liked,.social-share-container .luv-social-buttons a.luv-liked:hover,.style-cross .nav-menu > li > a > span:nth-child(1):before, .style-cross .nav-menu > li > a > span:nth-child(1):after, .style-expand-center .nav-menu > li > a > span:nth-child(1):after, .style-expand-left .nav-menu > li > a > span:nth-child(1):after, .style-bottom-border .nav-menu > li > a > span:nth-child(1):after, .widget_price_filter .price_slider_amount .button:hover, .widget_product_search input[type="submit"]:hover , .woocommerce .product .onsale , .woocommerce .product-wrapper .luv-wc-btn:hover , .wc-style-1 ul.products li > .title-wrapper .button .btn-cart-text,.wc-style-1 ul.products li > .meta-wrapper .button .btn-cart-text , .woocommerce .product-add-to-cart-container .add-to-cart-inner .single_add_to_cart_button , .widget_price_filter .ui-slider .ui-slider-range ,  .nav-cart span[data-count]:after , .nav-cart-list .widget_shopping_cart_content a.remove , .photo-reviews-container article.hentry .photo-review-overlay , .photo-review-popup #photo-review-upload-form:hover, .photo-review-popup #photo-review-upload-form.active-field , .masonry-style-title-bottom .post-content , #top-bar , #off-canvas-menu , .comment-body .reply a:hover , .comment-navigation a:hover , .bbp-pagination-links .page-numbers:hover, .bbp-pagination-links .page-numbers.current,.page-numbers .page-numbers:hover,.page-numbers .page-numbers.current,.pagination-container .page-numbers:hover,.pagination-container .page-numbers.current , article.hentry .mejs-controls .mejs-time-rail .mejs-time-current , article.hentry .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current , article.hentry.luv_portfolio .portfolio-overlay , .btn:hover , .pricing-table-colorful .pricing-table-item , .pricing-table-action , .icon-box.icon-box-circle:hover .icon-box-icon, .icon-box.icon-box-square:hover .icon-box-icon, .luv-dropcaps.luv-dropcaps-rounded , .luv-dropcaps.luv-dropcaps-square, .luv-accordion .luv-accordion-item.accordion-item-active > a, mark',
			        'color'            		=> '.post-meta .luv-social-buttons a.luv-like::before, .post-title .luv-social-buttons a.luv-like:before, .post-meta-bottom .luv-social-buttons a.luv-like:before, .post-meta .luv-social-buttons a.luv-like:hover i, .post-meta .luv-social-buttons a.luv-like.luv-liked i, .post-title .luv-social-buttons a.luv-like:hover i, .post-title .luv-social-buttons a.luv-like.luv-liked i, .post-meta-bottom .luv-social-buttons a.luv-like:hover i, .post-meta-bottom .luv-social-buttons a.luv-like.luv-liked i, .woocommerce-account .woocommerce-MyAccount-navigation>ul li.is-active a,.woocommerce-account .woocommerce-MyAccount-navigation>ul li a:hover,.luv-breadcrumbs a:hover, .post-meta .luv-social-buttons a.luv-like:hover i,.post-meta .luv-social-buttons a.luv-like.luv-liked i,.post-meta .luv-social-buttons a.luv-like:before,.social-share-container .luv-social-buttons a.luv-like:before, .post-meta .luv-social-buttons a i, #bbpress-forums .bbp-forum-title:hover,#bbpress-forums .bbp-topic-permalink:hover , .woocommerce .star-rating span:before , .woocommerce .price , p.stars a.star-1:hover:after, p.stars a.star-1.active:after, p.stars a.star-2:hover:after, p.stars a.star-2.active:after, p.stars a.star-3:hover:after, p.stars a.star-3.active:after, p.stars a.star-4:hover:after, p.stars a.star-4.active:after, p.stars a.star-5:hover:after, p.stars a.star-5.active:after , .nav-cart-list .widget_shopping_cart_content .cart_list a , .nav-cart-list.cart-style-2 .cart_list a:hover, a, body:not([data-header-position="left"]) .nav-menu .l-megamenu .l-megamenu-widget a:hover , [data-mobile-nav-position="left"] #mobile-nav .mobile-nav-trigger:hover , #mobile-nav ul a:hover , #mobile-nav ul li.current-menu-item a , #mobile-nav ul .submenu-opened > a , #mobile-nav-search .mobile-nav-search-trigger:hover , .social-share-container .luv-social-buttons a:hover, #footer-widgets a:hover , .widget li a:hover , .tagcloud a:hover , #wp-calendar tbody td#today , #wp-calendar tbody td a , #wp-calendar tfoot a:hover , article.hentry .post-title a:hover , article.hentry .post-tags a:hover , .pricing-table-price , .pricing-table-colorful .pricing-table-action , .icon-box:hover .icon-box-icon, .luv-tabs ul li.active-tab a , .luv-tabs ul a:hover, .luv-team-member .luv-team-member-social a:hover',
			        'border-color'			=> '#content-wrapper .masonry-standard article.hentry .post-meta-cat.post-meta span > *:hover, #content-wrapper .timeline article.hentry .post-meta-cat.post-meta span > *:hover, .social-share-container .luv-social-buttons a.luv-liked,.social-share-container .luv-social-buttons a.luv-liked:hover,#bbp-single-user-details #bbp-user-navigation ul li.current , .woocommerce .product .woocommerce-tabs .tabs li.active , .comment-body .reply a:hover , .comment-navigation a:hover, .tagcloud a:hover , footer#footer .tagcloud a:hover , #wp-calendar tbody td:hover , #wp-calendar tbody td#today , article.hentry .post-tags a:hover , .btn:hover , .pricing-table-light .pricing-table-title , .icon-box.icon-box-circle:hover .icon-box-icon:after, .icon-box.icon-box-square:hover .icon-box-icon:after , .luv-tabs ul li.active-tab ,  .luv-tabs.luv-tabs-left ul li.active-tab, .luv-tabs.luv-tabs-right ul li.active-tab ,  .luv-tabs.luv-tabs-right ul li.active-tab, .style-circle .nav-menu > li > a > span:nth-child(1):before, .style-circle .nav-menu > li > a > span:nth-child(1):after',
			    )
			),
			array(
			    'id'       => 'accent-color-2',
			    'type'     => 'color',
			    'title'    => esc_html__('Accent Color #2', 'fevr'),
			    'subtitle' => esc_html__('The main elements of the theme have this color. For example, buttons, icons, the backgrounds of different post formats, the background of the drop-down navigation, etc.', 'fevr'),
			    'validate' => 'color',
			    'default'  => '#1B1D1F',
			    'compiler'    => array(
			        'background-color' 	=> '#bbpress-forums ul>.bbp-header, .widget_price_filter .price_slider_amount .button,.widget_product_search input[type="submit"], .woocommerce .product-wrapper .luv-wc-btn, .woocommerce .luv-wc-qty-icons, .wc-style-1 ul.products li>.title-wrapper .button i,.wc-style-1 ul.products li>.meta-wrapper .button i, .wc-style-2 ul.products li>.cart-wrapper a:hover, .woocommerce .wc-style-3 .item-wrapper, .woocommerce .wc-style-3 .product-button-wrapper, .woocommerce-cart .woocommerce>form table thead, .woocommerce-account #main-content table thead, #main-content .woocommerce .shop_table.order_details thead, .widget_products .remove,.widget_shopping_cart .remove,.widget_top_rated_products .remove,.widget_recently_viewed_products .remove,.widget_recent_reviews .remove,.widget_layered_nav .remove, @media (min-width: 769px), .photo-review-popup #photo-review-image-container .photo-review-image-inner .remove-photo-review-image, #masonry-filter.has-background, .nav-menu>li>.sub-menu, .nav-menu>li:not(.l-megamenu) .sub-menu, [data-transparent-menu="false"] .nav-menu>li:hover,[data-transparent-menu="false"] .nav-menu>li.one-page-active,[data-transparent-menu="false"] .nav-menu>li.current-menu-item, [data-transparent-menu="false"][data-header-position="left"] .nav-menu li a:hover, [data-transparent-menu="false"][data-header-position="left"] .nav-menu li.current-menu-item a, #page-bottom-nav, .bbp-pagination-links .page-numbers,.page-numbers .page-numbers,.pagination-container .page-numbers, .posts-container:not(.masonry-meta-overlay) article.hentry.format-quote .post-content,.posts-container:not(.masonry-meta-overlay) article.hentry.format-link .post-content,.posts-container:not(.masonry-meta-overlay) article.hentry.format-status .post-content,.single-post article.hentry.format-quote .post-content,.single-post article.hentry.format-link .post-content,.single-post article.hentry.format-status .post-content, article.hentry .mejs-container,article.hentry .mejs-embed,article.hentry .mejs-embed body,article.hentry .mejs-container .mejs-controls, .btn-full, .pricing-table-dark .pricing-table-item, #instantclick-bar',
			        'color'            	=> '.widget_price_filter .price_slider_amount .button,.widget_product_search input[type="submit"], .woocommerce .wc-style-3 .product-details-wrapper .product-categories a, .woocommerce .wc-style-3 .star-rating:before,.woocommerce .wc-style-3 .star-rating span:before, .wc-style-4 ul.products li .price, .wc-style-4 ul.products li .price span, .wc-style-4 ul.products li del span, .wc-style-4 ul.products li .product-wrapper .product-categories a, .wc-style-4 ul.products li .star-rating:before,.wc-style-4 ul.products li .star-rating span:before, .nav-cart-list.cart-style-2, .nav-cart-list.cart-style-2 li, .nav-cart-list.cart-style-2 .cart_list a, a:hover, [data-transparent-menu="false"][data-header-position="left"] .nav-menu>li:hover>a, .nav-menu li a, body[data-header-position="left"] .nav-menu .sub-menu li a, header#main-header .social-media-icons a, .nav-buttons>li>a, #left-header-search:before, #left-header-search input[type="text"], #left-header-search input[type="text"]:-moz-placeholder, #left-header-search input[type="text"]::-moz-placeholder, #left-header-search input[type="text"]:-ms-input-placeholder, #left-header-search input[type="text"]::-webkit-input-placeholder, .comment-body .reply a, .comment-navigation a, .tagcloud a, article.hentry .post-tags a, .posts-container:not(.masonry-meta-overlay) article.hentry.format-quote .post-content:hover,.posts-container:not(.masonry-meta-overlay) article.hentry.format-link .post-content:hover,.posts-container:not(.masonry-meta-overlay) article.hentry.format-status .post-content:hover,.single-post article.hentry.format-quote .post-content:hover,.single-post article.hentry.format-link .post-content:hover,.single-post article.hentry.format-status .post-content:hover, #project-tags li, .btn',
			        'border-color'		=> '.woocommerce-cart .cart_totals h2, .comment-body .reply a, .comment-navigation a, .tagcloud a, article.hentry .post-tags a, #project-tags li, .btn, .btn.btn-handdrawn',

			    )
			),
			array(
			    'id'       => 'additional-color-1',
			    'type'     => 'color',
			    'title'    => esc_html__('Additional Color #1', 'fevr'),
			    'subtitle' => esc_html__('When editing content, there is the possibility to use the color set here for different elements.', 'fevr'),
			    'validate' => 'color',
			    'compiler'    => array(
					'background-color' => '.btn-color-1, .btn-color-1:hover',
					'border-color' => '.btn-color-1',
				)
			),
			array(
			    'id'       => 'additional-color-2',
			    'type'     => 'color',
			    'title'    => esc_html__('Additional Color #2', 'fevr'),
			    'subtitle' => esc_html__('When editing content, there is the possibility to use the color set here for different elements.', 'fevr'),
			    'validate' => 'color',
			    'compiler'    => array(
					'background-color' => '.btn-color-2, .btn-color-2:hover',
					'border-color' => '.btn-color-2',
				)
			),
			array(
			    'id'       => 'additional-color-3',
			    'type'     => 'color',
			    'title'    => esc_html__('Additional Color #3', 'fevr'),
			    'subtitle' => esc_html__('When editing content, there is the possibility to use the color set here for different elements.', 'fevr'),
			    'validate' => 'color',
			    'compiler'    => array(
					'background-color' => '.btn-color-3, .btn-color-3:hover',
					'border-color' => '.btn-color-3',
				)
			),
			array(
	            'id'       => 'custom-general-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'General Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for general elements.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-general-title-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#page-header-default .page-header-title, .woocommerce h1.product_title'),
	            'title'    => esc_html__( 'Default Page Title Color', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	       		'id'       => 'body-background-color',
	       		'type'     => 'color',
	       		'mode'	   => 'background-color',
	       		'compiler' => array('#content-wrapper'),
	       		'title'    => esc_html__( 'Main Background Color', 'fevr' ),
	       		'subtitle' => esc_html__( 'Pick a background color for the theme (default: #F8F8F8).', 'fevr' ),
	        	'default'  => '#F8F8F8',
	        	'validate' => 'color',
	        	'transparent' => false,
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	       		'id'       => 'body-text-color',
	       		'type'     => 'color',
	       		'mode'	   => 'color',
	       		'compiler' => array('body'),
	       		'title'    => esc_html__( 'Text Color', 'fevr' ),
	       		'subtitle' => esc_html__( 'Pick a general text color for the theme (default: #5d5d5d).', 'fevr' ),
	        	'default'  => '#5d5d5d',
	        	'validate' => 'color',
	        	'transparent' => false,
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-breadcrumbs-background',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('.luv-breadcrumbs.luv-breadcrumbs-bg'),
	            'title'    => esc_html__( 'Breadcrumbs Background Color', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-breadcrumbs-text',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('.luv-breadcrumbs'),
	            'title'    => esc_html__( 'Breadcrumbs Text Color', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-breadcrumbs-border',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('.luv-breadcrumbs'),
	            'title'    => esc_html__( 'Breadcrumbs Border Color', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-bottom-pagination-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#page-bottom-nav'),
	            'title'    => esc_html__( 'Bottom Pagination Background Color on Single Page', 'fevr' ),
	            'subtitle' => esc_html__( 'Pick a background color for the bottom pagination on single pages. (portfolio, blog, etc.)', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-bottom-pagination-icon-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#page-bottom-nav i'),
	            'title'    => esc_html__( 'Bottom Pagination Icon Color on Single Page', 'fevr' ),
	            'subtitle' => esc_html__( 'Pick a text color for the bottom pagination on single pages. (portfolio, blog, etc.)', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
		)
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Top Bar', 'fevr' ),
		'id'     => 'accent-colors-tab-topbar',
	    'subsection' => 'true',
	    'fields' => array(
			array(
	            'id'       => 'custom-top-bar-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Top Bar Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for top bar.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-top-bar-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#top-bar'),
	            'title'    => esc_html__( 'Background Color', 'fevr' ),
	            'required' => array( 'custom-top-bar-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-top-bar-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'background-color',
	            'compiler' => array('body #top-bar-icons li:before, body #top-bar-menu li:before'),
	            'title'    => esc_html__( 'Border Color', 'fevr' ),
	            'required' => array( 'custom-top-bar-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-top-bar-link-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#top-bar-menu a, #top-bar-icons a, #top-bar'),
	            'title'    => esc_html__( 'Text/Link Color', 'fevr' ),
	            'required' => array( 'custom-top-bar-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-top-bar-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#top-bar-menu a:hover, #top-bar-icons a:hover'),
	            'title'    => esc_html__( 'Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-top-bar-colors', "=", 1 ),
	        ),
	    )
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Header', 'fevr' ),
		'id'     => 'accent-colors-tab-header',
	    'subsection' => 'true',
	    'fields' => array(
	        // header colors
			array(
	            'id'       => 'custom-header-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Header Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for header.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-header-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('header#main-header'),
	            'title'    => esc_html__( 'Background Color', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-sticky-header-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('.small-header header#main-header'),
	            'title'    => esc_html__( 'Background Color for Sticky Header', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'border-color',
	            'compiler' => array('.nav-buttons > li, header#main-header'),
	            'title'    => esc_html__( 'Border Color', 'fevr' ),
	            'subtitle'    => esc_html__( 'You need to enable "Navigation Borders" for this setting.', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-link-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('.nav-menu li a, .nav-buttons > li > a, body[data-header-position="left"] .nav-menu .sub-menu li a'),
	            'title'    => esc_html__( 'Link Color', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-sticky-header-link-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('.small-header .nav-menu li a, .small-header .nav-buttons > li > a'),
	            'title'    => esc_html__( 'Link Color for Sticky Header', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-link-color-hover',
	            'type'     => 'color',
	            'transparent' => false,
	            'compiler' => array(

	            				'color' => 'body[data-transparent-menu="true"]:not([data-header-position="left"]) .nav-menu > li:hover > a, body[data-transparent-menu="true"]:not([data-header-position="left"]) .nav-menu > li.one-page-active > a, body[data-transparent-menu="true"]:not([data-header-position="left"]) .nav-menu > li.current-menu-item > a, [data-transparent-menu="true"] .nav-buttons > li > a:hover, [data-header-position="left"] .nav-buttons > li > a:hover, [data-transparent-menu="true"][data-header-position="left"] .nav-menu li a:hover, [data-header-position="left"] .nav-menu .sub-menu li a:hover, [data-transparent-menu="true"][data-header-position="left"] .nav-menu .sub-menu li a:hover, [data-transparent-menu="false"][data-header-position="left"] .nav-menu li a:hover, [data-transparent-menu="false"] .nav-menu>li:hover>a, [data-transparent-menu="false"] .nav-menu>li.one-page-active>a, [data-transparent-menu="false"] .nav-menu >li.current-menu-item > a, [data-transparent-menu="false"] .nav-menu > li:hover > a, [data-transparent-menu="false"]:not([data-header-position="left"]) .nav-buttons>li:hover>a, [data-transparent-menu="false"][data-header-position="left"] .nav-menu .sub-menu li a:hover, [data-transparent-menu="false"][data-header-position="left"] .nav-menu .sub-menu li a.current-menu-item, [data-transparent-menu="false"][data-header-position="left"] .nav-menu li.current-menu-item a',
	            				'background' => 'header #nav-primary .nav-menu > li > a > span:nth-child(1):after',
	            ),
	            'title'    => esc_html__( 'Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-sticky-header-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('body[data-transparent-menu="true"]:not([data-header-position="left"]).small-header .nav-menu > li:hover > a, body[data-transparent-menu="true"]:not([data-header-position="left"]).small-header .nav-menu > li.one-page-active > a, body[data-transparent-menu="true"]:not([data-header-position="left"]).small-header .nav-menu > li.current-menu-item > a, [data-transparent-menu="true"].small-header .nav-buttons > li > a:hover, [data-transparent-menu="false"].small-header .nav-menu>li:hover>a, [data-transparent-menu="false"].small-header .nav-menu>li.one-page-active>a, [data-transparent-menu="false"].small-header .nav-menu >li.current-menu-item > a, [data-transparent-menu="false"].small-header .nav-menu > li:hover > a, [data-transparent-menu="false"]:not([data-header-position="left"]).small-header .nav-buttons>li:hover>a'),
	            'title'    => esc_html__( 'Link Color for Sticky Header (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-menu-background-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('[data-transparent-menu="false"][data-header-position="left"] .nav-menu li a:hover, [data-transparent-menu="false"][data-header-position="left"] .nav-menu li.current-menu-item a, [data-transparent-menu="false"] .nav-menu>li:hover, [data-transparent-menu="false"] .nav-menu>li.one-page-active, [data-transparent-menu="false"] .nav-menu>li.current-menu-item, [data-transparent-menu="false"]:not([data-header-position="left"]) .nav-buttons>li:hover, [data-transparent-menu="false"][data-header-position="left"] .nav-menu li.current-menu-item a'),
	            'title'    => esc_html__( 'Menu Background Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-submenu-background-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('[data-header-position="default"] .nav-menu > li > .sub-menu, [data-header-position="default"] .nav-menu > li:not(.l-megamenu) .sub-menu'),
	            'title'    => esc_html__( 'Sub Menu Background Color', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-submenu-background-color-hover',
	            'type'     => 'color_rgba',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('body .nav-menu .sub-menu li:hover, body .nav-menu .sub-menu li.current-menu-item'),
	            'title'    => esc_html__( 'Sub Menu Background Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-submenu-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'border-color',
	            'compiler' => array('body:not([data-header-position="left"]) .nav-menu .l-megamenu > .sub-menu li:not(.l-megamenu-widget):not(.menu-item-has-children) a, html body[data-header-position="default"] .nav-menu>li:not(.l-megamenu)>.sub-menu li, body:not([data-header-position="left"]) .nav-menu .l-megamenu>.sub-menu li[class*="l-megamenu-"]:not(.l-megamenu-12)'),
	            'title'    => esc_html__( 'Sub Menu Border Color', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-submenu-link-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('[data-header-position="default"] .nav-menu .sub-menu li a, .nav-menu .sub-menu li.menu-item-has-children:hover > a'),
	            'title'    => esc_html__( 'Sub Menu Link Color', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-submenu-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('[data-header-position="default"] .nav-menu .sub-menu li a:hover, [data-header-position="default"] .nav-menu .sub-menu li.current-menu-item a'),
	            'title'    => esc_html__( 'Sub Menu Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-social-media-link-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('header#main-header .social-media-icons a'),
	            'title'    => esc_html__( 'Social Media Icon Color', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-header-social-media-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('header#main-header .social-media-icons a:hover'),
	            'title'    => esc_html__( 'Social Media Icon Color (hover state)', 'fevr' ),
	            'required' => array( 'custom-header-colors', "=", 1 ),
	        ),
	    )
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Mobile Navigation', 'fevr' ),
		'id'     => 'accent-colors-tab-mobile-nav',
	    'subsection' => 'true',
	    'fields' => array(
	        // mobile navigation colors
			array(
	            'id'       => 'custom-mobile-nav-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Mobile Navigation Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for mobile navigation.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-mobile-nav-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#mobile-nav'),
	            'title'    => esc_html__( 'Background Color', 'fevr' ),
	            'required' => array( 'custom-mobile-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-mobile-nav-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'border-color',
	            'compiler' => array('#mobile-nav ul a, #mobile-nav-search input[type="text"]'),
	            'title'    => esc_html__( 'Border Color', 'fevr' ),
	            'required' => array( 'custom-mobile-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-mobile-nav-link-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#mobile-nav ul a, .mobile-nav-search-title, #mobile-nav-search .mobile-nav-search-trigger'),
	            'title'    => esc_html__( 'Link Color', 'fevr' ),
	            'required' => array( 'custom-mobile-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-mobile-nav-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#mobile-nav ul a:hover, #mobile-nav-search .mobile-nav-search-trigger:hover, #mobile-nav ul .submenu-opened > a, #mobile-nav ul li.current-menu-item a'),
	            'title'    => esc_html__( 'Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-mobile-nav-colors', "=", 1 ),
	        ),
	    )
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Footer', 'fevr' ),
		'id'     => 'accent-colors-tab-footer',
	    'subsection' => 'true',
	    'fields' => array(
	        // footer colors
			array(
	            'id'       => 'custom-footer-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Footer Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for footer.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-footer-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('footer#footer'),
	            'title'    => esc_html__( 'Background Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-copyright-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#footer-copyright, body'),
	            'title'    => esc_html__( 'Copyright Background Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-copyright-text-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#footer-copyright a:hover, #footer-copyright a, #footer-copyright'),
	            'title'    => esc_html__( 'Copyright Text Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'border-color',
	            'compiler' => array('footer#footer .widget_display_topics li, footer#footer .widget_display_replies li, footer#footer .widget li a, footer#footer .widget_recent_entries li'),
	            'title'    => esc_html__( 'Border Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-widget-heading-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('footer#footer .widget .widget-title'),
	            'title'    => esc_html__( 'Widget Heading Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-widget-text-color',
	            'type'     => 'color',
	            'transparent' => false,
	            'compiler' => array(
	            					'color' => '#footer-widgets, #footer-widgets a',
									'border-color' => '#footer-widgets .tagcloud a'
	            			),
	            'title'    => esc_html__( 'Link/Text Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-text-secondary-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('footer#footer .widget_display_topics li div, footer#footer .widget_display_replies li div, footer#footer .widget_recent_entries span'),
	            'title'    => esc_html__( 'Secondary Text Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#footer-widgets a:hover, #footer-widgets a:active'),
	            'title'    => esc_html__( 'Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-label-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#footer-widgets form label'),
	            'title'    => esc_html__( 'Form Label Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-input-border-color',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('#footer-widgets textarea, #footer-widgets input[type="text"], #footer-widgets input[type="password"], #footer-widgets input[type="email"], #footer-widgets input[type="tel"], #footer-widgets input[type="number"], #footer-widgets input[type="url"], #footer-widgets input[type="search"], #footer-widgets select'),
	            'title'    => esc_html__( 'Form Element Border Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-input-border-color-focus',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('#footer-widgets textarea:focus, #footer-widgets input[type="text"]:focus, #footer-widgets input[type="password"]:focus, #footer-widgets input[type="email"]:focus, #footer-widgets input[type="tel"]:focus, #footer-widgets input[type="number"]:focus, #footer-widgets input[type="url"]:focus, #footer-widgets input[type="search"]:focus, #footer-widgets select:focus'),
	            'title'    => esc_html__( 'Form Element Border Color (focus state)', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-input-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#footer-widgets textarea, #footer-widgets input[type="text"], #footer-widgets input[type="password"], #footer-widgets input[type="email"], #footer-widgets input[type="tel"], #footer-widgets input[type="number"], #footer-widgets input[type="url"], #footer-widgets input[type="search"], #footer-widgets select'),
	            'title'    => esc_html__( 'Form Element Background Color', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-footer-input-background-color-focus',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#footer-widgets textarea:focus, #footer-widgets input[type="text"]:focus, #footer-widgets input[type="password"]:focus, #footer-widgets input[type="email"]:focus, #footer-widgets input[type="tel"]:focus, #footer-widgets input[type="number"]:focus, #footer-widgets input[type="url"]:focus, #footer-widgets input[type="search"]:focus, #footer-widgets select:focus'),
	            'title'    => esc_html__( 'Form Element Background Color (focus state)', 'fevr' ),
	            'required' => array( 'custom-footer-colors', "=", 1 ),
	        ),
	    )
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Off Canvas Navigation', 'fevr' ),
		'id'     => 'accent-colors-tab-offcanvasnav',
	    'subsection' => 'true',
	    'fields' => array(
			array(
	            'id'       => 'custom-off-nav-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Off-Canvas Navigation Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for off-canvas navigation.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-off-nav-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu'),
	            'title'    => esc_html__( 'Background Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'border-color',
	            'compiler' => array('#off-canvas-menu .widget li a, #off-canvas-menu .widget_products li, #off-canvas-menu .widget_shopping_cart li, #off-canvas-menu .widget_top_rated_products li, #off-canvas-menu .widget_recently_viewed_products li, #off-canvas-menu .widget_recent_reviews li, #off-canvas-menu .widget_layered_nav li, #off-canvas-menu .widget_recent_entries li'),
	            'title'    => esc_html__( 'Border Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-widget-heading-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu .widget .widget-title'),
	            'title'    => esc_html__( 'Widget Heading Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-link-color',
	            'type'     => 'color',
	            'transparent' => false,
	            'compiler' => array(
	            					'color' => '#off-canvas-menu #off-canvas-menu-inner a, #off-canvas-menu, .woocommerce .star-rating span::before, #off-canvas-menu #off-canvas-menu-inner .off-canvas-menu-trigger',
									'border-color' => '#off-canvas-menu .tagcloud a'
	            			),
	            'title'    => esc_html__( 'Link/Text Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-text-secondary-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu .widget_recent_entries span'),
	            'title'    => esc_html__( 'Secondary Text Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu #off-canvas-menu-inner a:hover'),
	            'title'    => esc_html__( 'Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-label-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu form label'),
	            'title'    => esc_html__( 'Form Label Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-input-border-color',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu textarea, #off-canvas-menu input[type="text"], #off-canvas-menu input[type="password"], #off-canvas-menu input[type="email"], #off-canvas-menu input[type="tel"], #off-canvas-menu input[type="number"], #off-canvas-menu input[type="url"], #off-canvas-menu input[type="search"], #off-canvas-menu select'),
	            'title'    => esc_html__( 'Form Element Border Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-input-border-color-focus',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu textarea:focus, #off-canvas-menu input[type="text"]:focus, #off-canvas-menu input[type="password"]:focus, #off-canvas-menu input[type="email"]:focus, #off-canvas-menu input[type="tel"]:focus, #off-canvas-menu input[type="number"]:focus, #off-canvas-menu input[type="url"]:focus, #off-canvas-menu input[type="search"]:focus, #off-canvas-menu select:focus'),
	            'title'    => esc_html__( 'Form Element Border Color (focus state)', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-input-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu textarea, #off-canvas-menu input[type="text"], #off-canvas-menu input[type="password"], #off-canvas-menu input[type="email"], #off-canvas-menu input[type="tel"], #off-canvas-menu input[type="number"], #off-canvas-menu input[type="url"], #off-canvas-menu input[type="search"], #off-canvas-menu select'),
	            'title'    => esc_html__( 'Form Element Background Color', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-off-nav-input-background-color-focus',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#off-canvas-menu textarea:focus, #off-canvas-menu input[type="text"]:focus, #off-canvas-menu input[type="password"]:focus, #off-canvas-menu input[type="email"]:focus, #off-canvas-menu input[type="tel"]:focus, #off-canvas-menu input[type="number"]:focus, #off-canvas-menu input[type="url"]:focus, #off-canvas-menu input[type="search"]:focus, #off-canvas-menu select:focus'),
	            'title'    => esc_html__( 'Form Element Background Color (focus state)', 'fevr' ),
	            'required' => array( 'custom-off-nav-colors', "=", 1 ),
	        ),
	    )
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Overlay Navigation', 'fevr' ),
		'id'     => 'accent-colors-tab-overlaynav',
	    'subsection' => 'true',
	    'fields' => array(
	        // overlay navigation colors
			array(
	            'id'       => 'custom-overlay-nav-colors',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Overlay Navigation Colors', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like custom colors for overlay navigation.', 'fevr' ),
	        ),
			array(
	            'id'       => 'custom-overlay-nav-background-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation-overlay'),
	            'title'    => esc_html__( 'Background Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-border-color',
	            'type'     => 'color_rgba',
	            'mode'     => 'border-color',
	            'compiler' => array('#overlay-navigation .widget li a, #overlay-navigation .widget_products li, #overlay-navigation .widget_shopping_cart li, #overlay-navigation .widget_top_rated_products li, #overlay-navigation .widget_recently_viewed_products li, #overlay-navigation .widget_recent_reviews li, #overlay-navigation .widget_layered_nav li, #overlay-navigation .widget_recent_entries li'),
	            'title'    => esc_html__( 'Border Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-widget-heading-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation .widget .widget-title'),
	            'title'    => esc_html__( 'Widget Heading Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-link-color',
	            'type'     => 'color',
	            'transparent' => false,
	            'compiler' => array(
	            					'color' => '#overlay-navigation-inner a, #overlay-navigation, #overlay-navigation .overlay-navigation-trigger',
									'border-color' => '#overlay-navigation .tagcloud a'
	            			),
	            'title'    => esc_html__( 'Link/Text Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-text-secondary-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation .widget_recent_entries span'),
	            'title'    => esc_html__( 'Secondary Text Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-link-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation-inner a:hover'),
	            'title'    => esc_html__( 'Link Color (hover and active state)', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-label-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation form label'),
	            'title'    => esc_html__( 'Form Label Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-input-border-color',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation textarea, #overlay-navigation input[type="text"], #overlay-navigation input[type="password"], #overlay-navigation input[type="email"], #overlay-navigation input[type="tel"], #overlay-navigation input[type="number"], #overlay-navigation input[type="url"], #overlay-navigation input[type="search"], #overlay-navigation select'),
	            'title'    => esc_html__( 'Form Element Border Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-input-border-color-focus',
	            'type'     => 'color',
	            'mode'     => 'border-color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation textarea:focus, #overlay-navigation input[type="text"]:focus, #overlay-navigation input[type="password"]:focus, #overlay-navigation input[type="email"]:focus, #overlay-navigation input[type="tel"]:focus, #overlay-navigation input[type="number"]:focus, #overlay-navigation input[type="url"]:focus, #overlay-navigation input[type="search"]:focus, #overlay-navigation select:focus'),
	            'title'    => esc_html__( 'Form Element Border Color (focus state)', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-input-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation textarea, #overlay-navigation input[type="text"], #overlay-navigation input[type="password"], #overlay-navigation input[type="email"], #overlay-navigation input[type="tel"], #overlay-navigation input[type="number"], #overlay-navigation input[type="url"], #overlay-navigation input[type="search"], #overlay-navigation select'),
	            'title'    => esc_html__( 'Form Element Background Color', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-overlay-nav-input-background-color-focus',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('#overlay-navigation textarea:focus, #overlay-navigation input[type="text"]:focus, #overlay-navigation input[type="password"]:focus, #overlay-navigation input[type="email"]:focus, #overlay-navigation input[type="tel"]:focus, #overlay-navigation input[type="number"]:focus, #overlay-navigation input[type="url"]:focus, #overlay-navigation input[type="search"]:focus, #overlay-navigation select:focus'),
	            'title'    => esc_html__( 'Form Element Background Color (focus state)', 'fevr' ),
	            'required' => array( 'custom-overlay-nav-colors', "=", 1 ),
	        ),
	    )
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Blog', 'fevr' ),
		'id'     => 'accent-colors-tab-blog',
	    'subsection' => 'true',
	    'fields' => array(
	        array(
	            'id'       => 'custom-post-format-text-color',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('.posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-quote .post-content, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-link .post-content, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-status .post-content, .single-post article.hentry.format-quote .post-content, .single-post article.hentry.format-link .post-content, .single-post article.hentry.format-status .post-content'),
	            'title'    => esc_html__( 'Link/Quote/Status Post Format Text Color', 'fevr' ),
	        ),
	        array(
	            'id'       => 'custom-post-format-text-color-hover',
	            'type'     => 'color',
	            'mode'     => 'color',
	            'transparent' => false,
	            'compiler' => array('.posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-quote .post-content:hover, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-link .post-content:hover, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-status .post-content:hover, .single-post article.hentry.format-quote .post-content:hover, .single-post article.hentry.format-link .post-content:hover, .single-post article.hentry.format-status .post-content:hover'),
	            'title'    => esc_html__( 'Link/Quote/Status Post Format Text Color (hover)', 'fevr' ),
	            'required' => array( 'custom-general-colors', "=", 1 ),
	        ),
	        array(
	            'id'       => 'custom-post-format-background-color',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('.posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-quote .post-content, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-link .post-content, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-status .post-content, .single-post article.hentry.format-quote .post-content, .single-post article.hentry.format-link .post-content, .single-post article.hentry.format-status .post-content'),
	            'title'    => esc_html__( 'Link/Quote/Status Post Format Background Color', 'fevr' ),
	        ),
	        array(
	            'id'       => 'custom-post-format-background-color-hover',
	            'type'     => 'color',
	            'mode'     => 'background-color',
	            'transparent' => false,
	            'compiler' => array('.posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-quote .post-content:hover, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-link .post-content:hover, .posts-container:not(.masonry-meta-overlay):not(.search-results) article.hentry.format-status .post-content:hover, .single-post article.hentry.format-quote .post-content:hover, .single-post article.hentry.format-link .post-content:hover, .single-post article.hentry.format-status .post-content:hover'),
	            'title'    => esc_html__( 'Link/Quote/Status Post Format Background Color', 'fevr' ),
	        ),
	    )
	));

	//======================================================================
	// Typography Settings
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Typography', 'fevr' ),
		'desc'  => esc_html__( 'The typography can be set here.', 'fevr' ),
		'id'     => 'typography-colors-tab',
	    'icon'   => 'el el-fontsize',
	    'fields' => array(
			array(
			    'id'          => 'font-body',
			    'type'        => 'typography',
			    'title'       => esc_html__('Body', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('body'),
			    'text-align' => false,
			    'color'		=> false,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '400',
			        'font-family' => 'Open Sans',
			        'google'      => true,
			        'font-size'   => '1.4em',
			        'line-height' => '1.714',
			    ),
			),
			array(
			    'id'          => 'font-logo',
			    'type'        => 'typography',
			    'title'       => esc_html__('Logo', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.main-header-logo'),
			    'text-align' => false,
			    'color'		=> false,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '400',
			        'font-family' => 'Open Sans',
			        'google'      => true,
			        'font-size'   => '2em',
			    ),
			    'required' => array( 'image-for-logo', "!=", '1' ),
			),
			array(
			    'id'         	=> 'font-navigation',
			    'type'        	=> 'typography',
			    'title'       	=> esc_html__('Navigation', 'fevr'),
			    'google'		=> true,
			    'text-transform' => true,
			    'compiler'      => array('.nav-menu > li, [data-header-position="left"] .nav-menu > li'),
			    'text-align' => false,
			    'color'		=> false,
			    'line-height'	=> false,
			    'default'     => array(
			        'font-family' => 'Open Sans',
			        'google'      => true,
			        'font-weight' => '700',
			        'font-size'   => '12px',
			    ),
			),
			array(
			    'id'          => 'font-navigation-submenu',
			    'type'        => 'typography',
			    'title'       => esc_html__('Navigation (sub menu)', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.nav-menu .sub-menu li, [data-header-position="default"] .nav-menu .sub-menu li, [data-header-position="left"] .nav-menu .sub-menu li'),
			    'text-align' => false,
			    'text-transform' => true,
			    'color'		=> false,
			    'line-height'   => false,
			    'default'     => array(
			        'font-family' => 'Open Sans',
			        'google'      => true,
			        'font-size'   => '12px',
			    ),
			),
			array(
			    'id'          => 'font-luv-slider-heading',
			    'type'        => 'typography',
			    'title'       => esc_html__('Luv Slider Heading', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.luv-slider-wrapper .luv-slider-item h3'),
			    'text-align' => false,
			    'text-transform' => true,
			    'color'		=> false,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '6.875em',
			        'line-height' => '1.1'
			    ),
			),
			array(
			    'id'          => 'font-luv-slider-caption',
			    'type'        => 'typography',
			    'title'       => esc_html__('Luv Slider Caption', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.luv-slider-wrapper .luv-slider-item .luv-slider-caption'),
			    'text-align' => false,
			    'text-transform' => true,
			    'color'		=> false,
			    'units'       =>'em',
			    'default'     => array(
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-weight' => '300',
			        'font-size'   => '3.4em',
			        'line-height' => '1'
			    ),
			),
			array(
			    'id'          => 'font-page-heading',
			    'type'        => 'typography',
			    'title'       => esc_html__('Page Heading', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('#page-header-default .page-header-title, .woocommerce h1.page-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'units'       =>'em',
			    'text-transform' => true,
			    'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '3.8em',
			        'line-height' => '1.143em'
			    ),
			),
			array(
			    'id'          => 'font-page-heading-custom',
			    'type'        => 'typography',
			    'title'       => esc_html__('Page Custom Heading', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('#page-header-custom .page-header-title, .typed-cursor'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '5.714em',
			        'line-height' => '1.143em'
			    ),
			),
			array(
			    'id'          => 'font-page-subtitle',
			    'type'        => 'typography',
			    'title'       => esc_html__('Page Subtitle', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('#page-header-custom .page-header-subtitle'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-weight' => '300',
			        'font-size'   => '1.571em',
			        'line-height' => '1.143em'
			    ),
			),
			array(
			    'id'          => 'font-post-title',
			    'type'        => 'typography',
			    'title'       => esc_html__('Post Title', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('article.hentry .post-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '2.143em',
			        'line-height' => '1.267'
			    ),
			),
			array(
			    'id'          => 'font-portfolio-title',
			    'type'        => 'typography',
			    'title'       => esc_html__('Portfolio Title', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('article.hentry.luv_portfolio .post-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.429em',
			        'line-height' => '1.267'
			    ),
			),
			array(
			    'id'          => 'font-product-archive-title',
			    'type'        => 'typography',
			    'title'       => esc_html__('Product Archive Title', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.woocommerce ul.products li h3, .woocommerce ul.products li h2'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '500',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.429em',
			        'line-height' => '1.267'
			    ),
			),
			array(
			    'id'          => 'font-product-single-title',
			    'type'        => 'typography',
			    'title'       => esc_html__('Product Single Title', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.woocommerce h1.product_title'),
			    'text-align' => false,
			    'color'		=> false,
			    'units'       =>'em',
			    'text-transform' => true,
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '2.8em',
			        'line-height' => '1.4'
			    ),
			),
			array(
			    'id'          => 'font-reviews-title',
			    'type'        => 'typography',
			    'title'       => esc_html__('Review Title', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('@media (min-width: 769px) { .photo-reviews-container article.hentry .post-title }'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.429em',
			        'line-height' => '1.267'
			    ),
			),
			array(
			    'id'          => 'font-collections-title',
			    'type'        => 'typography',
			    'title'       => esc_html__('Collection Title', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.collections-container article.hentry .post-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.429em',
			        'line-height' => '1.267'
			    ),
			),
			array(
			    'id'          => 'font-sidebar-widget-header',
			    'type'        => 'typography',
			    'title'       => esc_html__('Sidebar Widget Header', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('aside#sidebar .widget .widget-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1em',
			        'line-height' => '1',
			    ),
			),
			array(
			    'id'          => 'font-footer-widget-header',
			    'type'        => 'typography',
			    'title'       => esc_html__('Footer Widget Header', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('footer#footer .widget .widget-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Open Sans',
			        'google'      => true,
			        'font-size'   => '1em',
			        'line-height' => '1',
			    ),
			),
			array(
			    'id'          => 'font-overlay-navigation-header',
			    'type'        => 'typography',
			    'title'       => esc_html__('Overlay Navigation Widget Header', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('#overlay-navigation .widget .widget-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '3em',
			        'line-height' => '1'
			    ),
			),
			array(
			    'id'          => 'font-overlay-navigation-item',
			    'type'        => 'typography',
			    'title'       => esc_html__('Overlay Navigation Item', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('#overlay-nav-container ul li'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '700',
			        'font-family' => 'Open Sans',
			        'google'      => true,
			        'font-size'   => '1em',
			        'line-height' => '1.2em'
			    ),
			),
			array(
			    'id'          => 'font-off-canvas-navigation-header',
			    'type'        => 'typography',
			    'title'       => esc_html__('Off-Canvas Navigation Widget Header', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('#off-canvas-menu .widget .widget-title'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.2em',
			        'line-height' => '1',
			    ),
			),
			array(
			    'id'          => 'font-buttons',
			    'type'        => 'typography',
			    'title'       => esc_html__('Button', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('.btn'),
			    'text-align' => false,
			    'color'		=> false,
			    'line-height'   => false,
			    'font-style' => false,
			    'font-size'   => false,
			    'units'       =>'em',
			    'default'     => array(
			        'font-family' => 'Open Sans',
			        'font-weight'  => '600',
			        'google'      => true,
			    ),
			),
			array(
			    'id'          => 'font-blockquote',
			    'type'        => 'typography',
			    'title'       => esc_html__('Blockquote', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('blockquote'),
			    'text-align' => false,
			    'color'		=> false,
			    'line-height'   => false,
			    'font-style' => false,
			    'font-size'   => false,
			    'default'     => array(
			        'font-family' => 'Playfair Display',
			    ),
			),
			// Headings
			array(
			    'id'          => 'font-heading-1',
			    'type'        => 'typography',
			    'title'       => esc_html__('Heading 1', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('h1'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '2.714em',
			        'line-height' => '1.267em'
			    ),
			),
			array(
			    'id'          => 'font-heading-2',
			    'type'        => 'typography',
			    'title'       => esc_html__('Heading 2', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('h2, #respond h3'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '2.286em',
			        'line-height' => '1.267em'
			    ),
			),
			array(
			    'id'          => 'font-heading-3',
			    'type'        => 'typography',
			    'title'       => esc_html__('Heading 3', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('h3, .vc_pie_chart h4'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.857em',
			        'line-height'   => '1.267em',
			    ),
			),
			array(
			    'id'          => 'font-heading-4',
			    'type'        => 'typography',
			    'title'       => esc_html__('Heading 4', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('h4'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.429em',
			        'line-height'   => '1.267em',
			    ),
			),
			array(
			    'id'          => 'font-heading-5',
			    'type'        => 'typography',
			    'title'       => esc_html__('Heading 5', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('h5, .woocommerce-account .woocommerce-MyAccount-content legend'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1.143em',
			        'line-height'   => '1.267em',
			    ),
			),
			array(
			    'id'          => 'font-heading-6',
			    'type'        => 'typography',
			    'title'       => esc_html__('Heading 6', 'fevr'),
			    'google'      => true,
			    'compiler'      => array('h6'),
			    'text-align' => false,
			    'color'		=> false,
			    'text-transform' => true,
			    'letter-spacing' => true,
			    'units'       =>'em',
			    'default'     => array(
			        'font-weight'  => '600',
			        'font-family' => 'Poppins',
			        'google'      => true,
			        'font-size'   => '1em',
			        'line-height'   => '1.267em',
			    ),
			),
	    )
	));

	//======================================================================
	// Layout Settings
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Layout', 'fevr' ),
		'desc'  => esc_html__( 'The layout style can be set here. The page can appear in full width or boxed layout.', 'fevr' ),
		'id'     => 'layout-settings-tab',
	    'icon'   => 'el el-screen',
	    'fields' => array(
	        array(
	            'id'       => 'page-layout',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Page Layout', 'fevr' ),
	            'options'  => array(
	                'default' => array(
	                    'alt' => esc_html__('Default Layout', 'fevr'),
	                	'title' => esc_html__('Default Layout', 'fevr'),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/default-layout.png'
	                ),
	           		'boxed' => array(
	           			'alt' => esc_html__('Boxed', 'fevr'),
	           			'title' => esc_html__('Boxed', 'fevr'),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/boxed-layout.png'
	           		),
				),
	            'default'  => 'default'
	        ),
	        array(
	        	'id'       => 'body-background-image',
	        	'type'     => 'background',
	       		'title'    => esc_html__( 'Background Image', 'fevr' ),
	       		'compiler'   => array( 'body' ),
	       		'background-color' => false,
	       		'mode'	   => 'background-image',
	       		'subtitle' => esc_html__( 'If you want to set a background image for the page, you can set it here. If you want to set a color, you can set it under the Colors menu.', 'fevr' ),
	       		'default'  => array(
			        'background-repeat' => 'no-repeat',
			        'background-size' => 'cover',
			        'background-attachment' => 'fixed',
			        'background-position' => 'center center',
			    ),
	       		'required' => array('page-layout', '=', 'boxed')
	        ),
	        array(
	            'id'       => 'layout-whitespace',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Whitespace Around Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like whitespace around the whole page.', 'fevr' ),
                'default'  => '0',
	        ),
	        array(
			    'id'       => 'layout-whitespace-color',
			    'type'     => 'color',
			    'title'    => esc_html__('Whitespace Color', 'fevr'),
			    'validate' => 'color',
			    'default' => '#fff',
			    'required' => array('layout-whitespace', '=', 1),
			    'compiler'    => array(
			        'border-color' => 'body[data-whitespace="true"]',
			        'background-color' => 'body[data-whitespace="true"]:after, body[data-whitespace="true"]:before',
			    ),
			),
	    )
	));

	//======================================================================
	// Top Bar
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'     => esc_html__( 'Top Bar', 'fevr' ),
        'desc'      => esc_html__( 'The top bar is a thin bar appearing on the top of the page. Icons, custom text, menus can be set here.', 'fevr' ),
        'id'   		=> 'top-bar-tab',
        'icon'      => 'el el-arrow-up',
		'fields'	=> array(
			array(
	            'id'       => 'top-bar',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Top Bar', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a top bar.', 'fevr' ),
                'default'  => '0',
	        ),
	        array(
	            'id'       => 'top-bar-content',
	            'type'     => 'editor',
	            'required' => array( 'top-bar', '=', '1' ),
	            'title'    => esc_html__( 'Content', 'fevr' ),
	            'subtitle' => esc_html__( 'You can use shortcodes in this field text, eg: [wpml_language_selector] [site_url] [login_url] [logout_url] [site_title] [site_tagline] [current_year]', 'fevr' ),
	            'args'     => array(
			        'textarea_rows'    => 3,
			        'media_buttons'	   => false,
			    ),
	        ),
	        array(
	            'id'       => 'top-bar-enable-social-icons',
	            'type'     => 'checkbox',
	            'required' => array( 'top-bar', '=', '1' ),
	            'title'    => esc_html__( 'Social Media', 'fevr' ),
	            'subtitle' => esc_html__( 'If you would like social media icons in the top bar, you can enable this option. After this, you can select what you would like to be displayed.', 'fevr' ),
	        ),
	        array(
                'id'       => 'top-bar-social-media',
                'type'     => 'sortable',
                'mode'     => 'checkbox',
                'title'    => esc_html__( 'Social Media Icons', 'fevr' ),
                'subtitle' => esc_html__( 'Select which icons you want to display.', 'fevr' ),
                'options'  => $fevr_dynamic_redux_fields['social-media-icons'],
                'required' => array( 'top-bar-enable-social-icons', "=", 1 ),
            ),
	        array(
	            'id'       => 'top-bar-close',
	            'type'     => 'checkbox',
	            'required' => array( 'top-bar', '=', '1' ),
	            'title'    => esc_html__( 'Close Button', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the option to close the top bar.', 'fevr' ),
	        ),
	        array(
	            'id'       => 'top-bar-hide-on-small',
	            'type'     => 'checkbox',
	            'required' => array( 'top-bar', '=', '1' ),
	            'title'    => esc_html__( 'Hide on Small Devices', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like to hide the top bar on small devices.', 'fevr' ),
	        ),
	        array(
        		'id'       => 'top-bar-display-wpml',
        		'type'     => 'checkbox',
        		'title'    => esc_html__( 'WPML Language Selector', 'fevr' ),
        		'subtitle' => esc_html__( 'Display WPML language selector in top bar.', 'fevr' ),
        		'default'  => '1',
	        	'required' => array( 'top-bar', '=', '1' ),
	        ),
	    )
	));

	//======================================================================
	// Header Settings
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Header', 'fevr' ),
		'desc'   => esc_html__( 'Settings for the header can be found here.', 'fevr' ),
		'id'    => 'header-tab',
	    'icon'   => 'el el-website',
	));

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Appearance', 'fevr' ),
		'id'    => 'header-tab-appearance',
	    'subsection'       => true,
	    'fields' => array(
			array(
	            'id'       => 'header-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Header Style', 'fevr' ),
	            'subtitle' => esc_html__( 'After selection, further settings options become available.', 'fevr' ),
	            'options'  => array(
	                'default' => array(
	                    'alt' => esc_html__('Default Header', 'fevr' ),
	                	'title' => esc_html__('Default Header', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/default-header.png'
	                ),
	           		'left' => array(
	           			'alt' => esc_html__('Left Header', 'fevr' ),
	           			'title' => esc_html__('Left Header', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-header.png'
	           		),
				),
	            'default'  => 'default'
	        ),
	        array(
	            'id'       => 'header-layout',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Header Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose between the three header options.', 'fevr' ),
	            'options'  => array(
	                'default' => array(
	                    'alt' => esc_html__('Default', 'fevr'),
	                	'title' => esc_html__('Default', 'fevr'),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/header-layout-default.png'
	                ),
	            	'centered-logo' => array(
	           			'alt' => esc_html__('Centered Logo', 'fevr'),
	           			'title' => esc_html__('Centered Logo', 'fevr'),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/header-layout-centered.png'
	           		),
	           		'nav-under-logo' => array(
	           			'alt' => esc_html__('Navigation Under Logo', 'fevr'),
	           			'title' => esc_html__('Navigation Under Logo', 'fevr'),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/header-layout-under-logo.png'
	           		),
				),
	            'default'  => 'default',
	            'required' => array('header-position','=','default'),
	        ),
	        array(
	            'id'       => 'header-full-width',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Full Width Header', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like your header to be full width of the page. By default the header will be placed in a grid with a specific width.', 'fevr' ),
	            'required' => array('header-position','=','default'),
	        ),
	        array(
                'id'            => 'header-height',
                'type'          => 'dimensions',
                'title'         => esc_html__( 'Header Height', 'fevr' ),
                'subtitle'      => esc_html__( 'The default height of the header in pixels.', 'fevr' ),
				'units'   		=> 'px',
				'width'			=> false,
				'default'  		=> array(
			        'height' 	=> '90px',
			    ),
                'required' => array(
                	array('header-position','=','default'),
					array('header-layout', "!=", 'nav-under-logo'),
                )
            ),
	        array(
	            'id'       => 'header-sticky',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Sticky Header', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the header to be continuously visible while scrolling.', 'fevr' ),
	            'default' => 1,
	            'required' => array(
                	array('header-position','=','default'),
					array('header-layout', "!=", 'nav-under-logo'),
                )
	        ),
	        array(
        		'id'       => 'header-sticky-type',
        		'type'     => 'select',
        		'title'    => esc_html__( 'Sticky Header Type', 'fevr' ),
        		'options'  => array(
        				'header-sticky-always' => esc_html__('Always Visible', 'fevr'),
        				'header-sticky-on-scroll' => esc_html__('Visible on Scroll Up', 'fevr'),
        		),
        		'default' => 'header-sticky-always',
        		'required' => array(
        				array('header-position','=','default'),
        				array('header-sticky','=',1),
        		)
	        ),
	        array(
	            'id'       => 'header-sticky-mobile',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Sticky Header for Mobile', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the header to be continuously visible while scrolling on mobile devices.', 'fevr' ),
	            'default' => 0,
	        ),

	        // Left Header Settings
	        array(
	       		'id'       => 'header-left-background-image',
	        	'type'     => 'background',
	       		'title'    => esc_html__( 'Background Image for Left Header', 'fevr' ),
	       		'compiler'   => array( 'header#main-header' ),
	       		'background-color' => false,
	       		'mode'	   => 'background-image',
	       		'subtitle' => esc_html__( 'If you would like to set a background image for the left side navigation, you can here. If you want to set a color, select under the Colors menu.', 'fevr' ),
	       		'required' => array('header-position','=','left'),
	        ),
	        array(
        		'id'       => 'header-skin',
        		'type'     => 'select',
        		'title'    => esc_html__( 'Header Skin', 'fevr' ),
        		'subtitle' => esc_html__( 'The default header skin operates in case of a transparent header. This setting can be overwritten separately on each page.', 'fevr' ),
        		'options'  => array(
        				'dark' => esc_html__('Dark', 'fevr'),
        				'light' => esc_html__('Light', 'fevr'),
        		),
        		'required' => array( 'header-position', "=", 'default' ),
	        ),
    		array(
    			'id'       => 'automatic-header-skin',
    			'type'     => 'checkbox',
    			'title'    => esc_html__( 'Automatic Header Skin', 'fevr' ),
    			'subtitle' => esc_html__( 'If this option is active, the header skin will dynamically changed based on the content underneath it', 'fevr' ),
        		'required' => array(
        				array('header-position','=','default'),
        				array('header-sticky','=',1),
        				array('header-layout', "!=", 'nav-under-logo'),
        		)
    		),
	        array(
	            'id'       => 'transparent-header',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Transparent Header', 'fevr' ),
	            'subtitle' => esc_html__( 'If this option is active, by default the header will always be transparent. The setting can be overwritten on every page.', 'fevr' ),
	            'required' => array( 'header-position', "=", 'default' ),
	        ),
	      )
	    ));

	    Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Navigation', 'fevr' ),
		'id'    => 'header-tab-navigation',
	    'subsection'       => true,
	    'fields' => array(
	        // Navigation Settings
			array(
	        		'id'       => 'header-nav-disable',
	        		'type'     => 'checkbox',
	        		'title'    => esc_html__( 'Disable Main Navigation', 'fevr' ),
	        		'subtitle' => esc_html__( 'By disabling the navigation, the main navigation will no longer appear next to the logo. This option may be useful if you would only like to use an off canvas navigation.', 'fevr' ),
	        		'default' => 0,
	        		'required' => array('header-position', "=", 'default'),
	        ),
			array(
	            'id'       => 'header-nav-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Navigation Item Position', 'fevr' ),
	            'subtitle' => esc_html__( 'Please select where to display the menu items.', 'fevr' ),
	            'options'  => array(
	                'left' => array(
	                    'alt' => esc_html__('Left', 'fevr'),
	                	'title' => esc_html__('Left', 'fevr'),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/header-nav-position-left.png'
	                ),
	            	'center' => array(
	           			'alt' => esc_html__('Center', 'fevr'),
	           			'title' => esc_html__('Center', 'fevr'),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/header-nav-position-center.png'
	           		),
	           		'right' => array(
	           			'alt' => esc_html__('Right', 'fevr'),
	           			'title' => esc_html__('Right', 'fevr'),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/header-nav-position-right.png'
	           		),
				),
	            'default'  => 'right',
	            'required' => array(
				    array('header-position', '=', 'default'),
				    array('header-layout', '=', 'default'),
				    array('header-nav-disable', '!=', 1)

				)
	        ),
	        array(
	            'id'       => 'mobile-navigation-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Mobile Navigation', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose how the mobile navigation should open.', 'fevr' ),
	            'options'  => array(
	                'default' => array(
	                    'alt' => esc_html__('Default', 'fevr' ),
	                	'title' => esc_html__('Default', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/default-mobile-nav.gif'
	                ),
	           		'left' => array(
	           			'alt' => esc_html__('Slides from Left', 'fevr' ),
	           			'title' => esc_html__('Slides from Left', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-mobile-nav.gif'
	           		),
				),
	            'default'  => 'default'
	        ),
	        array(
	        	'id'       => 'navigation-link-style',
                'type'	   => 'select',
                'title'    => esc_html__( 'Link Hover Effect', 'fevr' ),
                'options'  => array(
	                'none' => esc_html__('None', 'fevr' ),
			        'bottom-border' => esc_html__('Bottom Border', 'fevr' ),
			        'expand-left' => esc_html__('Expand - Left', 'fevr' ),
			        'expand-center' => esc_html__('Expand - Center', 'fevr' ),
			        'cross' => esc_html__('Cross', 'fevr' ),
			        'circle' => esc_html__('Circle', 'fevr' ),
			    ),
			    'default' => 'none',
			    'required' => array( 'transparent-navigation', "=", '1' ),
			),
	        array(
	            'id'       => 'transparent-navigation',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Transparent Navigation Items', 'fevr' ),
	            'subtitle' => esc_html__( 'If this option is active,  the navigation elements will not receive a background color upon hovering.', 'fevr' ),
				'default' => '1',
	        ),
	        array(
	            'id'       => 'border-on-transparent-header',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Navigation Borders', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a border between navigation elements.', 'fevr' ),
	            'required' => array( 'header-position', "=", 'default' ),
	        ),
	      )
	    ));

	    Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Logo', 'fevr' ),
		'id'    => 'header-tab-logo',
	    'subsection'       => true,
	    'fields' => array(
	        array(
	            'id'       => 'image-for-logo',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Image for Logo', 'fevr' ),
	            'subtitle' => esc_html__( 'If this is not enabled, plain text will appear in the place of the logo.', 'fevr' ),
	            'default' => '1'
	        ),
	        array(
	            'id'       => 'header-logo',
	            'type'     => 'media',
	            'title'    => esc_html__( 'Logo (default)', 'fevr' ),
	            'required' => array( 'image-for-logo', "=", '1' ),
	            'mode'     => false,
	            'subtitle' => esc_html__( 'Default logo. This logo will appear when the header is not transparent and when scrolling if the sticky header is not active.', 'fevr' ),
	        ),
	        array(
	            'id'       => 'header-logo-dark',
	            'type'     => 'media',
	            'title'    => esc_html__( 'Logo (dark)', 'fevr' ),
	            'required' => array( 'image-for-logo', "=", '1' ),
	            'mode'     => false,
	            'subtitle' => esc_html__( 'This logo will appear if the transparent header is enabled, when the skin is set to "Dark".', 'fevr' ),
	        ),
	        array(
	            'id'       => 'header-logo-light',
	            'type'     => 'media',
	            'title'    => esc_html__( 'Logo (light)', 'fevr' ),
	            'required' => array( 'image-for-logo', "=", '1' ),
	            'mode'     => false,
	            'subtitle' => esc_html__( 'This logo will appear if the transparent header is enabled, when the skin is set to "Light".', 'fevr' ),
	        ),
	        array(
	            'id'       => 'header-logo-sticky',
	            'type'     => 'media',
	            'title'    => esc_html__( 'Logo (for sticky header)', 'fevr' ),
	            'required' => array( 'image-for-logo', "=", '1' ),
	            'mode'     => false,
	            'subtitle' => esc_html__( 'This logo will appear if the sticky header option is active.', 'fevr' ),
	        ),
	        array(
	            'id'       => 'header-logo-mobile',
	            'type'     => 'media',
	            'title'    => esc_html__( 'Logo (for mobile)', 'fevr' ),
	            'required' => array( 'image-for-logo', "=", '1' ),
	            'mode'     => false,
	            'subtitle' => esc_html__( 'This logo will appear only on mobile devices. By default the theme uses the default logo.', 'fevr' ),
	        ),
	        array(
                'id'            => 'logo-height',
                'type'          => 'dimensions',
                'title'         => esc_html__( 'Logo Height', 'fevr' ),
                'subtitle'      => esc_html__( 'Height of the default logo.', 'fevr' ),
				'units'   		=> array('px'),
				'width'			=> false,
				'default'  		=> array(
			        'height' 	=> '56',
			    ),
			    'compiler'    => array(
			        'height' => '.main-header-logo img',
			    ),
                'required' => array( 'image-for-logo', "=", '1' ),
            ),
            array(
                'id'            => 'logo-height-shrinked',
                'type'          => 'dimensions',
                'title'         => esc_html__( 'Shrinked Logo Height', 'fevr' ),
                'subtitle'      => esc_html__( 'Height of the logo for use with sticky header.', 'fevr' ),
				'units'   		=> array('px'),
				'width'			=> false,
				'default'  		=> array(
			        'height' 	=> '50',
			    ),
			    'compiler'    => array(
			        'height' => '.small-header:not([data-auto-header-skin="true"]) .main-header-logo img',
			    ),
                'required' => array(
				    array('image-for-logo', '=', '1'),
				    array('header-sticky', '=', '1'),
					array('header-layout', "!=", 'nav-under-logo'),
				)
            ),
            array(
	        		'id'       => 'header-logo-right',
	        		'type'     => 'checkbox',
	        		'title'    => esc_html__( 'Logo on the Right', 'fevr' ),
	        		'subtitle' => esc_html__( 'Enable to position the logo on the right.', 'fevr' ),
	        		'required' => array(
	        			array('header-position', "=", 'default'),
	        			array('header-layout', "!=", 'nav-under-logo'),
	        		),
	        	)
	        ),
        ));

        Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Overlay Navigation', 'fevr' ),
		'id'    => 'header-tab-overlaynavigation',
	    'subsection'       => true,
	    'fields' => array(
            array(
	            'id'       => 'overlay-navigation',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Overlay Navigation', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like to activate the overlay navigation. Widgets can be placed in the overlay navigation and also menus in the columns.', 'fevr' ),
	        ),
	        array(
	            'id'       => 'overlay-navigation-only-nav',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Overlay Navigation as Primary Navigation', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the overlay navigation as the primary navigation.', 'fevr' ),
	        ),
	        array(
                'id'            => 'overlay-navigation-columns',
                'type'          => 'slider',
                'title'         => esc_html__( 'Number of columns', 'fevr' ),
                'subtitle'      => esc_html__( 'How many columns should be displayed in the overlay navigation', 'fevr' ),
                'default'       => 3,
                'min'           => 1,
                'step'          => 1,
                'max'           => 4,
                'display_value' => 'label',
                'required' => array(
                	array( 'overlay-navigation', "=", 1 ),
                	array( 'overlay-navigation-only-nav', "!=", 1 ),
                ),
              ),
              array(
                 'id'       => 'overlay-menu-icon',
                 'type'     => 'icon_select',
                 'title'    => esc_html__( 'Menu Icon', 'fevr' ),
                 'subtitle' => esc_html__( 'Select an icon for Overlay menu trigger.', 'fevr' ),
                 'required' => array( 'overlay-navigation', "=", 1 ),
                 'default'  => 'ion-navicon-round',
              ),
          )
        ));

        Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Off Canvas Navigation', 'fevr' ),
		'id'    => 'header-tab-offcanvasnav',
	    'subsection'       => true,
	    'fields' => array(
	        array(
	            'id'       => 'off-canvas-menu',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Off-Canvas Menu', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a menu which slides from the right. Any widget can be placed in the menu, even a "Menu widget", whereby a primary navigation can be created as well.', 'fevr' ),
	        ),
	        array(
	            'id'       => 'off-canvas-menu-btn-nav',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Button on the Navigation', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a button in the header, which will open the off canvas navigation.', 'fevr' ),
	            'required' => array( 'off-canvas-menu', "=", 1 ),
	        ),
	        array(
	            'id'       => 'off-canvas-menu-btn-tb',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Button in Top Bar', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a button in the top bar, which will open the off canvas navigation.', 'fevr' ),
	            'required' => array( 'off-canvas-menu', "=", 1 ),
	        ),
	        array(
	            'id'       => 'off-canvas-menu-close-btn',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Display Close Button', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a close button. If disabled, it can only be closed by clicking on the overlay.', 'fevr' ),
	            'required' => array( 'off-canvas-menu', "=", 1 ),
	        ),
              array(
                 'id'       => 'off-canvas-menu-icon',
                 'type'     => 'icon_select',
                 'title'    => esc_html__( 'Menu Icon', 'fevr' ),
                 'subtitle' => esc_html__( 'Select an icon for Off Canvas menu trigger.', 'fevr' ),
                 'required' => array( 'off-canvas-menu', "=", 1 ),
                 'default'     => 'ion-ios-keypad',
              ),
	      )
        ));

        Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Tweaks', 'fevr' ),
		'id'    => 'header-tab-tweaks',
	    'subsection'       => true,
	    'fields' => array(
	        array(
	            'id'       => 'header-search',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Header Search', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a search icon in the header.', 'fevr' ),
	        ),

	        array(
	            'id'       => 'header-enable-social-media',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Social Media', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this option if you would like social media icons in the header. After enabling, you will be able to choose the items you want to display.', 'fevr' ),
	        ),
            array(
                'id'       => 'header-social-media',
                'type'     => 'sortable',
                'mode'     => 'checkbox',
                'title'    => esc_html__( 'Social Media Icons', 'fevr' ),
                'subtitle' => esc_html__( 'Select which icons you want to display.', 'fevr' ),
                'options'  => $fevr_dynamic_redux_fields['social-media-icons'],
                'required' => array( 'header-enable-social-media', "=", 1 ),
            ),
	    )
	));


	//======================================================================
    // Footer
    //======================================================================

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Footer', 'fevr' ),
        'desc'  => esc_html__( 'Settings related to the footer can be found here.', 'fevr' ),
        'id'    => 'footer-tab',
        'icon'  => 'el el-arrow-down',
        'fields'     => array(
	        array(
	       		'id'       => 'footer-background-image',
	        	'type'     => 'background',
	       		'title'    => esc_html__( 'Background Image for Footer', 'fevr' ),
	       		'compiler'   => array( 'footer#footer' ),
	       		'background-color' => false,
	       		'mode'	   => 'background-image',
	       		'subtitle' => esc_html__( 'If you would like to set a background image to the footer, you can do it here. If you want to set a color, you can do that under the Colors menu.', 'fevr' ),
	        ),
	        array(
	            'id'       => 'footer-custom',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Custom Footer Content', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like custom content above the footer widgets. Content that is placed here can be simple text or even a shortcode.', 'fevr' ),
                'default'  => '0',
	        ),
	        array(
	            'id'       => 'footer-custom-content',
	            'type'     => 'editor',
	            'title'    => esc_html__( 'Content', 'fevr' ),
	            'subtitle' => esc_html__( 'Content set here will appear on top of the footer, above the widgets.', 'fevr' ),
				'args'     => array(
			        'textarea_rows'    => 3,
			        'media_buttons'	   => false,
			    ),
			    'required' => array( 'footer-custom', "=", 1 ),
	        ),
	        array(
	            'id'       => 'footer-custom-content-grid',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Show Footer Content in Grid', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like custom content visible in the default container. If disabled content will be displayed full width.', 'fevr' ),
                'default'  => '0',
                'required' => array( 'footer-custom', "=", 1 ),
	        ),
	        array(
	            'id'       => 'footer-content',
	            'type'     => 'editor',
	            'title'    => esc_html__( 'Copyright Content', 'fevr' ),
	            'subtitle' => esc_html__( 'You can use the following shortcodes in this field text: [site_url] [login_url] [logout_url] [site_title] [site_tagline] [current_year]', 'fevr' ),
				'default'  => '&copy; [current_year] [site_title]. All Rights Reserved. - Made with <a href="http://fevr.luvthemes.com">Fevr</a>',
				'args'     => array(
			        'textarea_rows'    => 3,
			        'media_buttons'	   => false,
			    ),
	        ),
	        array(
	        		'id'       => 'footer-enable-social-media',
	        		'type'     => 'checkbox',
	        		'title'    => esc_html__( 'Social Media', 'fevr' ),
	        		'subtitle' => esc_html__( 'If you would like to add social media icons in the footer, enable this option. Once enabled, select the icons you would like to display.', 'fevr' ),
	        ),
	        array(
	        		'id'       => 'footer-social-media',
	        		'type'     => 'sortable',
	        		'mode'     => 'checkbox',
	        		'title'    => esc_html__( 'Social Media Icons', 'fevr' ),
	        		'subtitle' => esc_html__( 'Select which icons you want to display.', 'fevr' ),
	        		'options'  => $fevr_dynamic_redux_fields['social-media-icons'],
	        		'required' => array( 'footer-enable-social-media', "=", 1 ),
	        ),
	        array(
	            'id'       => 'footer-widgets',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Footer Widgets', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like to place widgets in the footer.', 'fevr' ),
                'default'  => '1',
	        ),
            array(
                'id'            => 'footer-widget-columns',
                'type'          => 'slider',
                'title'         => esc_html__( 'Widget columns', 'fevr' ),
                'subtitle'      => esc_html__( 'How many columns to display', 'fevr' ),
                'default'       => 4,
                'min'           => 1,
                'step'          => 1,
                'max'           => 6,
                'display_value' => 'label',
                'required'		=> array( 'footer-widgets', "=", 1 ),
            ),
            array(
	            'id'       => 'footer-under-the-rug',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( '"Under the rug" Footer', 'fevr' ),
                'default'  => '0',
	        ),
        )
    ) );

    //======================================================================
    // Widgets
    //======================================================================

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Widgets', 'fevr' ),
        'desc'  => esc_html__( 'You can enable/disable widgets built into the widget menu, and also create custom widget areas.', 'fevr' ),
        'id'    => 'widget-area-tab',
        'icon'  => 'el el-lines',
        'fields'     => array(
	        array(
	       		'id'		=> 'twitter-widget',
	       		'type'		=> 'checkbox',
	        	'title'		=> esc_html__( 'Twitter Widget', 'fevr' ),
	        	'default'	=> 1
	        ),
	        array(
	       		'id'		=> 'flickr-widget',
	       		'type'		=> 'checkbox',
	        	'title'		=> esc_html__( 'Flickr Widget', 'fevr' ),
	        	'default'	=> 1
	        ),
	        array(
	       		'id'		=> 'instagram-widget',
	       		'type'		=> 'checkbox',
	        	'title'		=> esc_html__( 'Instagram Widget', 'fevr' ),
	        	'default'	=> 1
	        ),
       		array(
       			'id'		=> 'shortcode-widget',
        		'type'		=> 'checkbox',
        		'title'		=> esc_html__( 'Text Box Widget', 'fevr' ),
        		'default'	=> 1
        	),
            array(
                'id'       => 'custom-widgets',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Custom Widget Areas', 'fevr' ),
                'subtitle' => esc_html__( 'Add/Remove custom widget areas.', 'fevr' ),
            ),
        )
    ) );

	//======================================================================
	// Blog
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'     => esc_html__( 'Blog', 'fevr' ),
        'desc'		=> esc_html__( 'Settings related to the blog can be found here.', 'fevr' ),
        'id'    	=> 'blog-tab',
        'icon'      => 'el el-list',
		'fields'	=> array(
			array(
	            'id'       => 'blog-sidebar-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Sidebar Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Sidebar settings.', 'fevr' ),
	            'options'  => array(
	                'left-sidebar' => array(
	                    'alt' => esc_html__('Left Sidebar', 'fevr' ),
	                	'title' => esc_html__('Left Sidebar', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-sidebar.png'
	                ),
	           		'right-sidebar' => array(
	           			'alt' => esc_html__('Right Sidebar', 'fevr' ),
	           			'title' => esc_html__('Right Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/right-sidebar.png'
	           		),
	           		'no-sidebar' => array(
	           			'alt' => esc_html__('No Sidebar', 'fevr' ),
	           			'title' => esc_html__('No Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/no-sidebar.png'
	           		),
				),
	            'default'  => 'right-sidebar'
	        ),
			array(
                'id'       => 'blog-sidebar',
                'type'	   => 'select',
                'title'    => esc_html__( 'Sidebar', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose which sidebar you would like to display.', 'fevr' ),
                'data'     => 'sidebars',
                'default'  => 'blog-sidebar',
                'required' => array('blog-sidebar-position', '!=', 'no-sidebar'),
            ),
            array(
	            'id'       => 'blog-sidebar-single',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Sidebar on Single Post', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a sidebar only on the single page.', 'fevr' ),
	            'default' => '0',
	            'required' => array('blog-sidebar-position', '!=', 'no-sidebar'),
	        ),
	        array(
                'id'       => 'blog-full-width',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Full Width Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the blog in full width layout. If disabled, the page will be in a grid format to a specified width.', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'blog-layout-style',
                'type'	   => 'image_select',
                'title'    => esc_html__( 'Layout Style', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose between the options.', 'fevr' ),
			    'options'  => array(
	                'standard' => array(
	                    'alt' => esc_html__('Standard', 'fevr' ),
	                	'title' => esc_html__('Standard', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/blog-standard.png'
	                ),
	           		'masonry' => array(
	           			'alt' => esc_html__('Masonry', 'fevr' ),
	           			'title' => esc_html__('Masonry', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/blog-masonry.png'
	           		),
	           		'timeline' => array(
	           			'alt' => esc_html__('Timeline', 'fevr' ),
	           			'title' => esc_html__('Timeline', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/blog-timeline.png'
	           		),
	           		'alternate' => array(
	           			'alt' => esc_html__('Alternate', 'fevr' ),
	           			'title' => esc_html__('Alternate', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/blog-alternate.png'
	           		),
				),
	            'default'  => 'standard'
            ),
            array(
                'id'       => 'blog-alternate-same-column',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Show Images in Line', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like featured images to be displayed in a column. If this is not enabled, every second image will appear on the right.', 'fevr' ),
			    'default'  => '0',
			    'required' => array('blog-layout-style', '=', 'alternate'),
            ),
            array(
                'id'       => 'blog-page',
                'type'     => 'select',
                'title'    => esc_html__( 'Page to Display Blog Archive', 'fevr' ),
                'subtitle'     => esc_html__( 'Please select a page for blog archive if not set on the "Reading" page.', 'fevr' ),
                'data' 	   => 'page',
            ),
            array(
	            'id'       => 'blog-columns',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Columns', 'fevr' ),
	            'subtitle' => esc_html__( 'How many columns should the archive page be divided into?', 'fevr' ),
	            'options'  => array(
	           		'two-columns' => array(
	           			'alt' => esc_html__('Two Columns', 'fevr' ),
	           			'title' => esc_html__('Two Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/two-columns.png'
	           		),
	           		'three-columns' => array(
	           			'alt' => esc_html__('Three Columns', 'fevr' ),
	           			'title' => esc_html__('Three Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/three-columns.png'
	           		),
	           		'four-columns' => array(
	           			'alt' => esc_html__('Four Columns', 'fevr' ),
	           			'title' => esc_html__('Four Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/four-columns.png'
	           		),
	           		'auto-columns' => array(
	           			'alt' => esc_html__('Viewport Based Columns', 'fevr' ),
	           			'title' => esc_html__('Viewport Based Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/auto-columns.png'
	           		),
				),
	            'default'  => 'four-columns',
	            'required' => array('blog-layout-style', '=', 'masonry'),
	        ),
            array(
                'id'       => 'blog-masonry-layout',
                'type'	   => 'select',
                'title'    => esc_html__( 'Masonry Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'In "Standard" layout the title, content and meta data will appear below the image. if the "Overlay" is selected, the title and the meta data will appear upon hovering.', 'fevr' ),
                'options'  => array(
	                'standard' => esc_html__('Standard', 'fevr' ),
			        'meta-overlay' => esc_html__('Overlay', 'fevr' ),
			    ),
			    'default'  => 'standard',
			    'required' => array('blog-layout-style', '=', 'masonry'),
            ),
			array(
				'id'       => 'blog-automatic-metro-layout',
				'type'	   => 'checkbox',
				'title'    => esc_html__( 'Automatic Metro Layout', 'fevr' ),
				'default'  => 0,
				'required' => array(
						array('blog-layout-style', '=', 'masonry'),
						array('blog-masonry-layout', '=', 'meta-overlay'),
				)
			),
            array(
                'id'       => 'blog-masonry-hover-style',
                'type'	   => 'select',
                'title'    => esc_html__( 'Masonry Hover Style', 'fevr' ),
	            'subtitle' => esc_html__( 'In what style should the masonry appearance be?', 'fevr' ),
	            'options'  => array(
	                'masonry-style-zoom' 		=> esc_html__('Zoom In', 'fevr' ),
	                'masonry-style-zoom-out' 	=> esc_html__('Zoom Out', 'fevr' ),
	                'masonry-style-title-bottom'=> esc_html__('Title from Bottom', 'fevr' ),
	                'masonry-style-title-left'	=> esc_html__('Title from Left', 'fevr' ),
	                'masonry-style-solid'		=> esc_html__('Solid Border', 'fevr' ),
	                'masonry-style-gradient'	=> esc_html__('Dark Gradient', 'fevr' ),
	                'masonry-box-shadow'		=> esc_html__('Box Shadow', 'fevr' ),
	                'masonry-box-border'		=> esc_html__('Box Border', 'fevr' ),
	                'masonry-shine'				=> esc_html__('Shine Effect', 'fevr' ),
	                'masonry-color-overlay'		=> esc_html__('Color Overlay', 'fevr' ),
	                'masonry-color-overlay-text'		=> esc_html__('Color Overlay with Text', 'fevr' ),
	                'masonry-perspective'		=> esc_html__('Perspective', 'fevr' ),
			    ),
	            'default'  => 'masonry-style-zoom',
	            'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				    array('blog-masonry-layout', '=', 'meta-overlay'),
				)
            ),
            array(
                'id'       => 'blog-masonry-content',
                'type'	   => 'select',
                'title'    => esc_html__( 'Visible Content on Archive', 'fevr' ),
	            'subtitle' => esc_html__( 'Please select the data you want to be displayed.', 'fevr' ),
			    'options'  => array(
	                'title' 		=> esc_html__('Post Title', 'fevr' ),
			        'title-date' 	=> esc_html__('Post Title & Date', 'fevr' ),
			        'title-category'=> esc_html__('Post Title & Category', 'fevr' ),
			        'title-excerpt' => esc_html__('Post Title & Excerpt', 'fevr' ),
			    ),
			    'default'  => 'title-date',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				    array('blog-masonry-layout', '=', 'meta-overlay'),
				)
            ),
            array(
                'id'       => 'blog-masonry-auto-text-color',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Automatic Title Color', 'fevr' ),
	            'subtitle' => esc_html__( 'Enabling will give text on images a light/dark color.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				    array('blog-masonry-layout', '=', 'meta-overlay'),
				    array('blog-masonry-hover-style', '!=', 'masonry-style-title-bottom'),
				),
            ),
            array(
                'id'       => 'blog-masonry-gutter',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
	            'subtitle' => esc_html__( 'If you do not want a margin between the items, select this option.', 'fevr' ),
			    'default'  => '1',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				    array('blog-masonry-layout', '=', 'meta-overlay'),
				)
            ),
			array(
				'id'       => 'blog-item-padding',
				'type'	   => 'text',
				'title'    => esc_html__( 'Extra Padding Between Items', 'fevr' ),
				'subtitle' => esc_html__( 'You can specify extra padding, eg: 5px or 2%', 'fevr' ),
				'required' => array(
						array('blog-layout-style', '=', 'masonry'),
						array('blog-masonry-layout', '=', 'meta-overlay'),
						array('blog-masonry-gutter', '!=', '1'),
				)
			),
            array(
                'id'       => 'blog-masonry-filter',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Enable Filter on Masonry Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like a filter above the items.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				)
            ),
            array(
                'id'       => 'blog-masonry-rounded-corners',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Rounded Corners', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like rounded corners.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				)
            ),
            array(
                'id'       => 'blog-masonry-shadows',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Box Shadow', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like shadow around the cards.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				    array('blog-masonry-layout', '=', 'standard'),
				)
            ),
            array(
                'id'       => 'blog-masonry-equal-height',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Equal Height Columns', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like the equal height for the cards.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				    array('blog-masonry-layout', '=', 'standard'),
				)
            ),
            array(
                'id'       => 'blog-masonry-filter-background',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Background Color for Filter', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like to set a background color for the filter.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-masonry-filter', '=', '1'),
				)
            ),
            array(
                'id'       => 'blog-masonry-crop-images',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Crop Images', 'fevr' ),
	            'subtitle' => esc_html__( 'This function crops the images to the same size.', 'fevr' ),
			    'default'  => '1',
			    'required' => array(
				    array('blog-layout-style', '=', 'masonry'),
				)
            ),
            array(
            	'id'       => 'blog-animation',
            	'type'	   => 'select',
           		'title'    => esc_html__( 'Item Display Animation', 'fevr' ),
           		'default'  => '',
           		'options'	=> array(
           				''							=> esc_html__('None', 'fevr'),
           				'c-animate-fade-in'			=> esc_html__('Fade in', 'fevr'),
           				'c-animate-top'				=> esc_html__('Fade in from top', 'fevr'),
           				'c-animate-bottom'			=> esc_html__('Fade in from bottom', 'fevr'),
           				'c-animate-left'			=> esc_html__('Fade in from left', 'fevr'),
           				'c-animate-right'			=> esc_html__('Fade in from right', 'fevr'),
           				'c-animate-zoom-in'			=> esc_html__('Zoom in', 'fevr'),
           				'c-animate-zoom-in-spin'	=> esc_html__('Zoom in & Spin', 'fevr'),
           		)
            ),
            array(
                'id'       => 'blog-excerpt',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Excerpt', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this function if you want to display excerpts instead of the full content.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('blog-masonry-layout', '!=', 'meta-overlay'),
				)
            ),
            array(
                'id'       => 'blog-excerpt',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Excerpt', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this function if you want to display excerpts instead of the full content.', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'blog-excerpt-length',
                'type'	   => 'text',
                'title'    => esc_html__( 'Excerpt Length', 'fevr' ),
	            'subtitle' => esc_html__( 'Number of words to display as excerpt.', 'fevr' ),
			    'default'  => '35',
			    'required' => array(
				    array('blog-excerpt', '=', 1),
				)
            ),
            array(
                'id'       => 'blog-breadcrumbs',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Breadcrumbs', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'blog-pagination',
                'type'	   => 'select',
                'title'    => esc_html__( 'Pagination', 'fevr' ),
	            'subtitle' => esc_html__( 'Select the type of pagination.', 'fevr' ),
                'options'  => array(
	                'standard' => esc_html__('Standard Pagination', 'fevr' ),
			        'prev-next' => esc_html__('Previous/Next Links', 'fevr' ),
			        'infinite-scroll' => esc_html__('Infinite Scroll', 'fevr' ),
			    ),
			    'default'  => 'standard',
            ),
            array(
                'id'       => 'hide-blog-pagination',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Hide Previous/Next Links on Single Page', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'blog-pagination-position',
                'type'	   => 'select',
                'title'    => esc_html__( 'Previous/Next Links Position on Single Page', 'fevr' ),
                'options'  => array(
	                'header' => esc_html__('Header', 'fevr' ),
			        'under-content' => esc_html__('Under Content', 'fevr' ),
			    ),
			    'default'  => 'header',
			    'required' => array('hide-blog-pagination', '=', 0),
            ),
	        array(
	            'id'       => 'blog-author-bio',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Author\'s Bio on Single Post', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-featured-image',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Main Element on Single Post', 'fevr' ),
	            'subtitle' => esc_html__('Eg. featured image, audio player, video, gallery', 'fevr'),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-comments-feature',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Disable Comments Feature', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-comments-meta',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Hide Comments', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Don\'t Hide', 'fevr' ),
	                'hide-on-archive' => esc_html__('Hide on Archive', 'fevr' ),
			        'hide-on-single' => esc_html__('Hide on Single', 'fevr' ),
			        'hide-on-both' => esc_html__('Hide on Both', 'fevr' ),
			    ),
	            'default' => '0',
	            'required' => array('blog-comments-feature', '!=', 1),
	        ),
            array(
	            'id'       => 'blog-author-meta',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Hide Author', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Don\'t Hide', 'fevr' ),
	                'hide-on-archive' => esc_html__('Hide on Archive', 'fevr' ),
			        'hide-on-single' => esc_html__('Hide on Single', 'fevr' ),
			        'hide-on-both' => esc_html__('Hide on Both', 'fevr' ),
			    ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-likes-meta',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Hide Likes', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Don\'t Hide', 'fevr' ),
	                'hide-on-archive' => esc_html__('Hide on Archive', 'fevr' ),
			        'hide-on-single' => esc_html__('Hide on Single', 'fevr' ),
			        'hide-on-both' => esc_html__('Hide on Both', 'fevr' ),
			    ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-social-meta',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Share Icons on Single Page', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-categories-meta',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Hide Categories', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Don\'t Hide', 'fevr' ),
	                'hide-on-archive' => esc_html__('Hide on Archive', 'fevr' ),
			        'hide-on-single' => esc_html__('Hide on Single', 'fevr' ),
			        'hide-on-both' => esc_html__('Hide on Both', 'fevr' ),
			    ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-tags-meta',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Tags', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'blog-date-meta',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Hide Date', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Don\'t Hide', 'fevr' ),
	                'hide-on-archive' => esc_html__('Hide on Archive', 'fevr' ),
			        'hide-on-single' => esc_html__('Hide on Single', 'fevr' ),
			        'hide-on-both' => esc_html__('Hide on Both', 'fevr' ),
			    ),
	            'default' => '0'
	        ),
	    )
	) );

	//======================================================================
	// Portfolio
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'     => esc_html__( 'Portfolio', 'fevr' ),
        'desc'		=> esc_html__( 'Settings related to the portfolio can be found here.', 'fevr' ),
        'id'    	=> 'portfolio-tab',
        'icon'      => 'el el-th',
		'fields'	=> array(
			array(
	            'id'       => 'portfolio-sidebar-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Sidebar Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Sidebar settings.', 'fevr' ),
	            'options'  => array(
	                'left-sidebar' => array(
	                    'alt' => esc_html__('Left Sidebar', 'fevr' ),
	                	'title' => esc_html__('Left Sidebar', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-sidebar.png'
	                ),
	           		'right-sidebar' => array(
	           			'alt' => esc_html__('Right Sidebar', 'fevr' ),
	           			'title' => esc_html__('Right Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/right-sidebar.png'
	           		),
	           		'no-sidebar' => array(
	           			'alt' => esc_html__('No Sidebar', 'fevr' ),
	           			'title' => esc_html__('No Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/no-sidebar.png'
	           		),
				),
	            'default'  => 'right-sidebar'
	        ),
			array(
                'id'       => 'portfolio-sidebar',
                'type'	   => 'select',
                'title'    => esc_html__( 'Sidebar', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose which sidebar you would like to display.', 'fevr' ),
                'data'     => 'sidebars',
                'default'  => '',
                'required' => array('portfolio-sidebar-position', '!=', 'no-sidebar'),
            ),
            array(
                'id'       => 'portfolio-full-width',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Full Width Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the portfolio to be full page width. If disabled the page will appear in a grid with a specified width.', 'fevr' ),
			    'default'  => '0',
            ),
			array(
                'id'       => 'portfolio-page',
                'type'     => 'select',
                'title'    => esc_html__( 'Page to Display Portfolio Archive', 'fevr' ),
                'subtitle'     => esc_html__( 'You can create a new page, on which you can set a custom header and content. In this case, on the archive page the set custom header and custom content will appear above the items.', 'fevr' ),
                'data' 	   => 'page',
                'flush_permalinks' => 'true',
            ),
            array(
                'id'       => 'custom-portfolio-slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Portfolio Slug', 'fevr' ),
                'subtitle'     => esc_html__( 'Here you can change the custom link of the portfolio. The default is currently set to "portfolio".', 'fevr' ),
                'validate' => 'unique_slug',
                'validate' => 'no_special_chars',
                'flush_permalinks' => 'true',
            ),
            array(
	            'id'       => 'portfolio-columns',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Columns', 'fevr' ),
	            'subtitle' => esc_html__( 'How many columns should the archive page be divided into?', 'fevr' ),
	            'options'  => array(
	                'one-column' => array(
	                    'alt' => esc_html__('One Column', 'fevr' ),
	                	'title' => esc_html__('One Column', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/one-column.png'
	                ),
	           		'two-columns' => array(
	           			'alt' => esc_html__('Two Columns', 'fevr' ),
	           			'title' => esc_html__('Two Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/two-columns.png'
	           		),
	           		'three-columns' => array(
	           			'alt' => esc_html__('Three Columns', 'fevr' ),
	           			'title' => esc_html__('Three Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/three-columns.png'
	           		),
	           		'four-columns' => array(
	           			'alt' => esc_html__('Four Columns', 'fevr' ),
	           			'title' => esc_html__('Four Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/four-columns.png'
	           		),
	           		'auto-columns' => array(
	           			'alt' => esc_html__('Viewport Based Columns', 'fevr' ),
	           			'title' => esc_html__('Viewport Based Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/auto-columns.png'
	           		),
				),
	            'default'  => 'four-columns'
	        ),
	        array(
                'id'       => 'portfolio-masonry-layout',
                'type'	   => 'select',
                'title'    => esc_html__( 'Masonry Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'For the "Standard" option the title and meta data will appear under the image.  The "Overlay" option will show the title and meta data upon hovering.', 'fevr' ),
                'options'  => array(
	                'standard' => esc_html__('Standard', 'fevr' ),
			        'meta-overlay' => esc_html__('Overlay', 'fevr' ),
			    ),
			    'default'  => 'standard',
            ),
			array(
					'id'       => 'portfolio-automatic-metro-layout',
					'type'	   => 'checkbox',
					'title'    => esc_html__( 'Automatic Metro Layout', 'fevr' ),
					'default'  => 0,
					'required' => array(
							array('portfolio-masonry-layout', '=', 'meta-overlay'),
					)
			),
            array(
                'id'       => 'portfolio-masonry-hover-style',
                'type'	   => 'select',
                'title'    => esc_html__( 'Masonry Hover Style', 'fevr' ),
	            'subtitle' => esc_html__( 'In what style should the masonry\'s appearance be?', 'fevr' ),
			    'options'  => array(
	                'masonry-style-zoom' => esc_html__('Zoom In', 'fevr' ),
	                'masonry-style-zoom-out' => esc_html__('Zoom Out', 'fevr' ),
	                'masonry-style-title-bottom' => esc_html__('Title from Bottom', 'fevr' ),
	                'masonry-style-title-left' => esc_html__('Title from Left', 'fevr' ),
	                'masonry-style-solid' => esc_html__('Solid Border', 'fevr' ),
	                'masonry-style-gradient' => esc_html__('Dark Gradient', 'fevr' ),
	                'masonry-box-shadow'		=> esc_html__('Box Shadow', 'fevr' ),
	                'masonry-box-border'		=> esc_html__('Box Border', 'fevr' ),
	                'masonry-shine'				=> esc_html__('Shine Effect', 'fevr' ),
	                'masonry-color-overlay'		=> esc_html__('Color Overlay', 'fevr' ),
	                'masonry-color-overlay-text'		=> esc_html__('Color Overlay with Text', 'fevr' ),
	                'masonry-perspective'		=> esc_html__('Perspective', 'fevr' ),
			    ),
	            'default'  => 'masonry-style-zoom',
	            'required' => array('portfolio-masonry-layout', '=', 'meta-overlay'),
            ),
            array(
                'id'       => 'portfolio-item-overlay',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Item Overlay', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like an overlay when hovering. The overlay contains a button with the help of which the image can be enlarged and the video can be played.', 'fevr' ),
			    'default'  => '1',
			    'required' => array('portfolio-masonry-layout', '=', 'standard'),
            ),
            array(
                'id'       => 'portfolio-masonry-content',
                'type'	   => 'select',
                'title'    => esc_html__( 'Visible Content on Archive', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose the data you want to be displayed.', 'fevr' ),
			    'options'  => array(
	                'title' => esc_html__('Portfolio Title', 'fevr' ),
			        'title-date' => esc_html__('Portfolio Title & Date', 'fevr' ),
			        'title-category' => esc_html__('Portfolio Title & Category', 'fevr' ),
			        'title-excerpt' => esc_html__('Portfolio Title & Excerpt', 'fevr' ),
			    ),
			    'default'  => 'title-category',
            ),
            array(
                'id'       => 'portfolio-masonry-auto-text-color',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Automatic Title Color', 'fevr' ),
	            'subtitle' => esc_html__( 'Enabling it will give the texts on the images a light/dark color.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('portfolio-masonry-hover-style', '!=', 'masonry-style-title-bottom'),
				    array('portfolio-masonry-layout', '=', 'meta-overlay'),
				)

            ),
	        array(
                'id'       => 'portfolio-masonry-gutter',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
	            'subtitle' => esc_html__( 'If you wouldn\'t like a margin between the items, select this option.', 'fevr' ),
			    'default'  => '1',
			    'required' => array(
				    array('portfolio-masonry-layout', '=', 'meta-overlay'),
				    array('portfolio-columns', '!=', 'one-column'),
				)
            ),
			array(
				'id'       => 'portfolio-item-padding',
				'type'	   => 'text',
				'title'    => esc_html__( 'Extra Padding Between Items', 'fevr' ),
				'subtitle' => esc_html__( 'You can specify extra padding, eg: 5px or 2%', 'fevr' ),
				'required' => array(
						array('portfolio-masonry-gutter', '!=', '1'),
				)
			),
            array(
                'id'       => 'portfolio-masonry-filter',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Enable Filter on Masonry Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like a filter above the items.', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'portfolio-masonry-filter-background',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Background Color for Filter', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like to set a background color for the filter.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('portfolio-masonry-filter', '=', '1'),
				)
            ),
            array(
                'id'       => 'portfolio-masonry-rounded-corners',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Rounded Corners', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like rounded corners.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('portfolio-masonry-layout', '=', 'meta-overlay'),
				)
            ),
            array(
                'id'       => 'portfolio-masonry-shadows',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Box Shadow', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like shadow around the cards.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('portfolio-masonry-layout', '=', 'meta-overlay'),
				)
            ),
	        array(
                'id'       => 'portfolio-masonry-crop-images',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Crop Images', 'fevr' ),
	            'subtitle' => esc_html__( 'This function crops the images to the same size.', 'fevr' ),
			    'default'  => '1',
            ),
            array(
            		'id'       => 'portfolio-animation',
            		'type'	   => 'select',
            		'title'    => esc_html__( 'Item Display Animation', 'fevr' ),
            		'default'  => '',
            		'options'	=> array(
            				''							=> esc_html__('None', 'fevr'),
            				'c-animate-fade-in'			=> esc_html__('Fade in', 'fevr'),
            				'c-animate-top'				=> esc_html__('Fade in from top', 'fevr'),
            				'c-animate-bottom'			=> esc_html__('Fade in from bottom', 'fevr'),
            				'c-animate-left'			=> esc_html__('Fade in from left', 'fevr'),
            				'c-animate-right'			=> esc_html__('Fade in from right', 'fevr'),
            				'c-animate-zoom-in'			=> esc_html__('Zoom in', 'fevr'),
            				'c-animate-zoom-in-spin'	=> esc_html__('Zoom in & Spin', 'fevr'),
            		)
            ),
            array(
                'id'       => 'portfolio-breadcrumbs',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Breadcrumbs', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'portfolio-pagination',
                'type'	   => 'select',
                'title'    => esc_html__( 'Pagination', 'fevr' ),
	            'subtitle' => esc_html__( 'Select the type of pagination.', 'fevr' ),
                'options'  => array(
	                'standard' => esc_html__('Standard Pagination', 'fevr' ),
			        'prev-next' => esc_html__('Previous/Next Links', 'fevr' ),
			        'infinite-scroll' => esc_html__('Infinite Scroll', 'fevr' ),
			    ),
			    'default'  => 'standard',
            ),
            array(
                'id'       => 'hide-portfolio-pagination',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Hide Previous/Next Links on Single Page', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'portfolio-pagination-position',
                'type'	   => 'select',
                'title'    => esc_html__( 'Previous/Next Links Position on Single Page', 'fevr' ),
                'options'  => array(
	                'header' => esc_html__('Header', 'fevr' ),
			        'under-content' => esc_html__('Under Content', 'fevr' ),
			    ),
			    'default'  => 'header',
			    'required' => array('hide-portfolio-pagination', '=', 0),
            ),
            array(
	            'id'       => 'portfolio-featured-image',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Featured Image on Single Page', 'fevr' ),
	            'default' => '0'
	        ),
            array(
	            'id'       => 'portfolio-comments-feature',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Disable Comments Feature', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'portfolio-tags-meta',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Tags', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'portfolio-likes-meta',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Hide Likes', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Don\'t Hide', 'fevr'),
	                'hide-on-archive' => esc_html__('Hide on Archive', 'fevr'),
			        'hide-on-single' => esc_html__('Hide on Single', 'fevr'),
			        'hide-on-both' => esc_html__('Hide on Both', 'fevr'),
			    ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'portfolio-social-meta',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Share Icons on Single Page', 'fevr' ),
	            'default' => '0'
	        ),
	        array(
	            'id'       => 'portfolio-social-position',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Position of Like/Social Icons on Single Page', 'fevr' ),
	            'options'  => array(
		            '0' => esc_html__('Under Content', 'fevr' ),
	                '1' => esc_html__('Sidebar', 'fevr' ),
			    ),
			    'default'  => '0',
	        ),
	    )
	) );

	//======================================================================
	// Social Media
	//======================================================================

	Redux::setSection( $opt_name, array(
        'title'     => esc_html__( 'Social Media', 'fevr' ),
        'desc'  	=> esc_html__( 'Settings related to social media.', 'fevr' ),
        'id'    	=> 'social-media-tab',
        'icon'      => 'el el-group',
        'fields'    => array_merge($fevr_dynamic_redux_fields['social-media-urls'], array(


			array(
                'id'       => 'social-media-share',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Social Media Share', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like share buttons on pages. This option can be enabled/disabled for each and every post type.', 'fevr' ),
			    'default'  => '1',
            ),

			array(
                'id'       => 'social-media-share-icons',
                'type'     => 'sortable',
                'mode'     => 'checkbox',
                'title'    => esc_html__( 'Social Media Share Icons', 'fevr' ),
                'subtitle' => esc_html__( 'Please select the icons you want to display.', 'fevr' ),
                'options'  => array(
	                'facebook' => esc_html__('Facebook', 'fevr' ),
	                'twitter' => esc_html__('Twitter', 'fevr' ),
	                'google-plus' => esc_html__('Google+', 'fevr' ),
	                'linkedin' => esc_html__('LinkedIn', 'fevr' ),
	                'pinterest' => esc_html__('Pinterest', 'fevr' ),
                ),
                'required' => array( 'social-media-share', "=", 1 ),
            ),
        	array(
        		'id'       => 'facebook-app-id',
        		'type'	   => 'text',
        		'title'    => esc_html__( 'Facebook Application ID', 'fevr' ),
        		'subtitle' => esc_html__( 'Set Facebook app id for Facebook SDK init', 'fevr' ),
        	),
            array(
            		'id'       => 'facebook-comments',
            		'type'	   => 'checkbox',
            		'title'    => esc_html__( 'Enable Facebook Comments', 'fevr' ),
            		'subtitle' => esc_html__( 'Use Facebook Comments instead of WordPress default comments system', 'fevr' ),
            		'default'  => '0',
            ),
            array(
            		'id'       => 'facebook-comments-numposts',
            		'type'	   => 'text',
            		'title'    => esc_html__( 'Number of Comments', 'fevr' ),
            		'subtitle' => esc_html__( 'The number of comments to show by default. The minimum value is 1.', 'fevr' ),
            		'default'  => '5',
            		'required' => array(
            			'facebook-comments',
            			'=',
            			'1'
            		)
            ),
            array(
            		'id'       => 'facebook-comments-order',
            		'type'	   => 'select',
            		'title'    => esc_html__( 'Comments Order', 'fevr' ),
            		'subtitle' => esc_html__( 'The order to use when displaying comments', 'fevr' ),
            		'default'  => 'social',
            		'options'  => array(
            			'social'		=> esc_html__('Social', 'fevr'),
            			'time'			=> esc_html__('Time', 'fevr'),
            			'reverse_time'	=> esc_html__('Reverse time', 'fevr'),
            		),
            		'required' => array(
            				'facebook-comments',
            				'=',
            				'1'
            		)
            ),
            array(
            		'id'       => 'facebook-comments-admins',
            		'type'	   => 'multi_text',
            		'title'    => esc_html__( 'Moderator Facebook IDs', 'fevr' ),
            		'subtitle' => esc_html__( 'Assign Facebook Accounts to be admins of Facebook Comments', 'fevr' ),
            		'required' => array(
            			'facebook-comments',
            			'=',
            			'1'
            		)
            ),
        	array(
        		'id'       => 'enqueue-facebook-sdk',
        		'type'	   => 'checkbox',
        		'title'    => esc_html__( 'Enqueue Facebook SDK', 'fevr' ),
        		'subtitle' => esc_html__( 'Turn on this option if you would like to use Facebook Comments or WooCommerce Facebook tab', 'fevr' ),
        		'default'  => '1',
        	),
        )),
    ) );

    //======================================================================
    // WooCommerce
    //======================================================================

    global $woocommerce;

    // The tab is only visible when WooCommerce activated
    if(luv_is_plugin_active('woocommerce/woocommerce.php')):

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'WooCommerce', 'fevr' ),
        'desc'  => esc_html__( 'WooCommerce settings.', 'fevr' ),
        'id'    => 'woocommerce-tab',
        'icon'  => 'el el-shopping-cart',
    ) );

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'General', 'fevr' ),
        'desc'  => esc_html__( 'WooCommerce settings.', 'fevr' ),
        'id'    => 'woocommerce-tab-general',
        'subsection'       => true,
        'fields'     => array(
	        array(
	            'id'       => 'woocommerce-photo-reviews',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Photo Reviews', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable Photo Reviews.', 'fevr' ),
                'default'  => '1',
	        ),
	        array(
	        		'id'       => 'woocommerce-collections',
	        		'type'     => 'checkbox',
	        		'title'    => esc_html__( 'Collections', 'fevr' ),
	        		'subtitle' => esc_html__( 'Enable WooCommerce Colections.', 'fevr' ),
	        		'default'  => '1',
	        ),
	        array(
	            'id'       => 'woocommerce-sidebar-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Sidebar Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Sidebar settings.', 'fevr' ),
	            'options'  => array(
	                'left-sidebar' => array(
	                    'alt' => esc_html__('Left Sidebar', 'fevr' ),
	                	'title' => esc_html__('Left Sidebar', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-sidebar.png'
	                ),
	           		'right-sidebar' => array(
	           			'alt' => esc_html__('Right Sidebar', 'fevr' ),
	           			'title' => esc_html__('Right Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/right-sidebar.png'
	           		),
	           		'no-sidebar' => array(
	           			'alt' => esc_html__('No Sidebar', 'fevr' ),
	           			'title' => esc_html__('No Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/no-sidebar.png'
	           		),
				),
	            'default'  => 'right-sidebar'
	        ),
			array(
                'id'       => 'woocommerce-sidebar',
                'type'	   => 'select',
                'title'    => esc_html__( 'Sidebar', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose which sidebar you would like to display.', 'fevr' ),
                'data'     => 'sidebars',
                'default'  => '',
                'required' => array('woocommerce-sidebar-position', '!=', 'no-sidebar'),
            ),
            array(
	            'id'       => 'woocommerce-sidebar-single',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Sidebar on Single Product Page', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a sidebar only on the single product page.', 'fevr' ),
	            'default' => '0',
	            'required' => array('woocommerce-sidebar-position', '!=', 'no-sidebar'),
	        ),
            array(
                'id'       => 'woocommerce-full-width',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Full Width Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the archive page in full width. If disabled the page will be placed in a grid of a specific width.', 'fevr' ),
			    'default'  => '0',
            ),
            array(
	            'id'       => 'woocommerce-columns',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Columns', 'fevr' ),
	            'subtitle' => esc_html__( 'How many columns should the archive page be divided into?', 'fevr' ),
	            'options'  => array(
	           		'two-columns' => array(
	           			'alt' => esc_html__('Two Columns', 'fevr' ),
	           			'title' => esc_html__('Two Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/two-columns.png'
	           		),
	           		'three-columns' => array(
	           			'alt' => esc_html__('Three Columns', 'fevr' ),
	           			'title' => esc_html__('Three Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/three-columns.png'
	           		),
	           		'four-columns' => array(
	           			'alt' => esc_html__('Four Columns', 'fevr' ),
	           			'title' => esc_html__('Four Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/four-columns.png'
	           		),
				),
	            'default'  => 'three-columns',
	        ),
	        array(
                'id'       => 'woocommerce-two-columns-on-mobile',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Show Two Columns on Mobile', 'fevr' ),
                'subtitle' => esc_html__( 'Enable if you would like to show two products per row on mobile devices.', 'fevr' ),
			    'default'  => '0',
            ),
	        array(
                'id'       => 'woocommerce-posts-per-page',
                'type'	   => 'text',
                'title'    => esc_html__( 'Products Per Page on Shop Archive', 'fevr' ),
	        'default'  => get_option('posts_per_page')
            ),

	        array(
                'id'       => 'woocommerce-product-box-style',
                'type'	   => 'select',
                'title'    => esc_html__( 'Product Box Style', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose the style in which you would like to display your products.', 'fevr' ),
			    'options'  => array(
	                'wc-style-1' => esc_html__('Style 1', 'fevr' ),
			        'wc-style-2' => esc_html__('Style 2', 'fevr' ),
			        'wc-style-3' => esc_html__('Style 3', 'fevr' ),
			        'wc-style-4' => esc_html__('Style 4', 'fevr' ),
			        'wc-style-5' => esc_html__('Style 5', 'fevr' ),
			        'wc-style-6' => esc_html__('Style 6', 'fevr' ),
			    ),
			    'default'  => 'wc-style-1',
            ),
            array(
                'id'       => 'woocommerce-breadcrumbs',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Breadcrumbs', 'fevr' ),
			    'default'  => '0',
            ),
            array(
                'id'       => 'woocommerce-product-gutter',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Disable Gutter Between Items', 'fevr' ),
	            'subtitle' => esc_html__( 'If you do not want a margin between the items, select this option.', 'fevr' ),
			    'default'  => '0',
			    'required' => array(
				    array('woocommerce-product-box-style', '!=', 'wc-style-1'),
				    array('woocommerce-product-box-style', '!=', 'wc-style-2'),
				    array('woocommerce-product-box-style', '!=', 'wc-style-4'),
				    array('woocommerce-product-box-style', '!=', 'wc-style-5'),
				)
            ),
            array(
                'id'       => 'woocommerce-cart-style',
                'type'	   => 'select',
                'title'    => esc_html__( 'Header Cart Style', 'fevr' ),
	            'subtitle' => esc_html__( 'The "default" cart style will position the cart on the right side in the menu upon hovering.  The "full width" style will position the cart menu on the full width of the page, below the header.', 'fevr' ),
			    'options'  => array(
	                'cart-style-1' => esc_html__('Default', 'fevr' ),
			        'cart-style-2' => esc_html__('Full Width', 'fevr' ),
			    ),
			    'default'  => 'cart-style-1',
            ),
            array(
            	'id'       => 'woocommerce-animation',
            	'type'	   => 'select',
           		'title'    => esc_html__( 'Item Display Animation', 'fevr' ),
           		'default'  => '',
           		'options'	=> array(
           				''							=> esc_html__('None', 'fevr'),
           				'c-animate-fade-in'			=> esc_html__('Fade in', 'fevr'),
           				'c-animate-top'				=> esc_html__('Fade in from top', 'fevr'),
           				'c-animate-bottom'			=> esc_html__('Fade in from bottom', 'fevr'),
           				'c-animate-left'			=> esc_html__('Fade in from left', 'fevr'),
           				'c-animate-right'			=> esc_html__('Fade in from right', 'fevr'),
           				'c-animate-zoom-in'			=> esc_html__('Zoom in', 'fevr'),
           				'c-animate-zoom-in-spin'	=> esc_html__('Zoom in & Spin', 'fevr'),
           		)
            ),
	      array(
	            'id'       => 'woocommerce-cart-icon-top-bar',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Cart Icon in Top Bar', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the cart icon to appear in the top bar.', 'fevr' ),
                'default'  => '0',
	      ),
	      array(
	            'id'       => 'woocommerce-cart-icon-header',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Cart Icon in Header', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the cart icon to appear in the header.', 'fevr' ),
                'default'  => '1',
	      ),
            array(
                  'id'       => 'woocommerce-wishlist-icon-top-bar',
                  'type'     => 'checkbox',
                  'title'    => esc_html__( 'Wishlist Icon in Top Bar', 'fevr' ),
                  'subtitle' => esc_html__( 'Enable if you would like the wishlist icon to appear in the top bar.', 'fevr' ),
                'default'  => '0',
            ),
            array(
                  'id'       => 'woocommerce-wishlist-icon-header',
                  'type'     => 'checkbox',
                  'title'    => esc_html__( 'Wishlist Icon in Header', 'fevr' ),
                  'subtitle' => esc_html__( 'Enable if you would like the wishlist icon to appear in the header.', 'fevr' ),
                'default'  => '1',
            ),
        	array(
      		'id'       => 'woocommerce-disable-wishlist',
       		'type'     => 'checkbox',
      		'title'    => esc_html__( 'Hide Wishlist', 'fevr' ),
        		'subtitle' => esc_html__( 'Disable wishlist option', 'fevr' ),
        		'default' => '0'
        	),
	      array(
	            'id'       => 'woocommerce-magnifier-image',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Magnifier Effect', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like a magnifier effect upon hovering, on the single page of the product.', 'fevr' ),
                  'default'  => '1',
	      ),
	      array(
	            'id'       => 'woocommerce-social-meta',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Share Icons on Single Page', 'fevr' ),
	            'default' => '0'
	        ),
        	array(
        		'id'       => 'woocommerce-disable-reviews',
       			'type'     => 'checkbox',
        		'title'    => esc_html__( 'Hide Reviews', 'fevr' ),
        		'subtitle' => esc_html__( 'Hide product reviews tab on product page', 'fevr' ),
       			'default' => '0'
        	),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Photo Reviews', 'fevr' ),
        'desc'  => esc_html__( 'Using the Photo Reviews, a customer can upload a photo with a description after they purchase for more detailed feedback. Customers may be sent coupons in exchange after their review is submitted.', 'fevr' ),
        'id'    => 'woocommerce-tab-reviews',
        'subsection'       => true,
        'fields'     => array(
	        array(
	        		'id'       => 'woocommerce-photo-reviews-disabled',
	        		'type'	   => 'info',
	        		'title'    => esc_html__( 'Woocommerce Reviews are currently disabled', 'fevr' ),
	        		'desc'	   => esc_html__( 'Please enable Photo Reviews in WooCommerce General section.', 'fevr' ),
	        		'required' => array('woocommerce-photo-reviews', '!=', 1),
	        		'style'	   => 'warning'
	        ),
	        array(
	            'id'       => 'woocommerce-photo-reviews-sidebar-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Sidebar Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Sidebar settings.', 'fevr' ),
	            'options'  => array(
	                'left-sidebar' => array(
	                    'alt' => esc_html__('Left Sidebar', 'fevr' ),
	                	'title' => esc_html__('Left Sidebar', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-sidebar.png'
	                ),
	           		'right-sidebar' => array(
	           			'alt' => esc_html__('Right Sidebar', 'fevr' ),
	           			'title' => esc_html__('Right Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/right-sidebar.png'
	           		),
	           		'no-sidebar' => array(
	           			'alt' => esc_html__('No Sidebar', 'fevr' ),
	           			'title' => esc_html__('No Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/no-sidebar.png'
	           		),
				),
	            'default'  => 'right-sidebar',
	            'required' => array('woocommerce-photo-reviews', '=', 1),
	        ),
			array(
                'id'       => 'woocommerce-photo-reviews-sidebar',
                'type'	   => 'select',
                'title'    => esc_html__( 'Sidebar', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose which sidebar you would like to display.', 'fevr' ),
                'data'     => 'sidebars',
                'default'  => '',
                'required' => array(
                	array('woocommerce-photo-reviews-sidebar-position', '!=', 'no-sidebar'),
                	array('woocommerce-photo-reviews', '=', 1),
                )
            ),
            array(
                'id'       => 'woocommerce-photo-reviews-full-width',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Full Width Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the reviews page to be full page width. If not, the page will be placed in a grid with a specific width.', 'fevr' ),
			    'default'  => '0',
			    'required' => array('woocommerce-photo-reviews', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-photo-reviews-page',
                'type'     => 'select',
                'title'    => esc_html__( 'Page to Display Photo Reviews Archive', 'fevr' ),
                'desc'     => esc_html__( 'You can create a new page, on which you can set a custom header and content. In this case, on the archive page the set custom header and custom content will appear above the items.', 'fevr' ),
                'data' 	   => 'page',
                'flush_permalinks' => 'true',
                'required' => array('woocommerce-photo-reviews', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-photo-reviews-custom-slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Photo Review Slug', 'fevr' ),
                'desc'     => esc_html__( 'Here you can change the custom slug of the review. The default is currently set to "reviews".', 'fevr' ),
                'validate' => 'unique_slug',
                'validate' => 'no_special_chars',
                'flush_permalinks' => 'true',
                'required' => array('woocommerce-photo-reviews', '=', 1),
            ),
            array(
	            'id'       => 'woocommerce-photo-reviews-columns',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Columns', 'fevr' ),
	            'subtitle' => esc_html__( 'How many columns should the archive page be divided into?', 'fevr' ),
	            'options'  => array(
	           		'two-columns' => array(
	           			'alt' => esc_html__('Two Columns', 'fevr' ),
	           			'title' => esc_html__('Two Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/two-columns.png'
	           		),
	           		'three-columns' => array(
	           			'alt' => esc_html__('Three Columns', 'fevr' ),
	           			'title' => esc_html__('Three Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/three-columns.png'
	           		),
	           		'four-columns' => array(
	           			'alt' => esc_html__('Four Columns', 'fevr' ),
	           			'title' => esc_html__('Four Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/four-columns.png'
	           		),
				),
	            'default'  => 'three-columns',
	            'required' => array('woocommerce-photo-reviews', '=', 1),
	        ),
	        array(
	            'id'       => 'woocommerce-photo-reviews-coupon',
	            'type'     => 'select',
	            'title'    => esc_html__( 'Photo Review Coupon', 'fevr' ),
	            'subtitle' => esc_html__( 'The coupon set here will be sent to the customer after his review is approved.', 'fevr' ),
	            'data' => 'post',
                'args' => array('post_type' => array('shop_coupon')),
                'required' => array('woocommerce-photo-reviews', '=', 1),
	        ),
	        array(
	        		'id'       => 'woocommerce-photo-reviews-animation',
	        		'type'	   => 'select',
	        		'title'    => esc_html__( 'Item Display Animation', 'fevr' ),
	        		'default'  => '',
	        		'options'	=> array(
	        				''							=> esc_html__('None', 'fevr'),
	        				'c-animate-fade-in'			=> esc_html__('Fade in', 'fevr'),
	        				'c-animate-top'				=> esc_html__('Fade in from top', 'fevr'),
	        				'c-animate-bottom'			=> esc_html__('Fade in from bottom', 'fevr'),
	        				'c-animate-left'			=> esc_html__('Fade in from left', 'fevr'),
	        				'c-animate-right'			=> esc_html__('Fade in from right', 'fevr'),
	        				'c-animate-zoom-in'			=> esc_html__('Zoom in', 'fevr'),
	        				'c-animate-zoom-in-spin'	=> esc_html__('Zoom in & Spin', 'fevr'),
	        		)
	        ),
	        array(
                'id'       => 'woocommerce-photo-reviews-breadcrumbs',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Breadcrumbs', 'fevr' ),
			    'default'  => '0',
            ),
	        array(
                'id'       => 'woocommerce-photo-reviews-pagination',
                'type'	   => 'select',
                'title'    => esc_html__( 'Pagination', 'fevr' ),
	            'subtitle' => esc_html__( 'Select the type of pagination.', 'fevr' ),
                'options'  => array(
	                'standard' => esc_html__('Standard Pagination', 'fevr' ),
			        'prev-next' => esc_html__('Previous/Next Links', 'fevr' ),
			        'infinite-scroll' => esc_html__('Infinite Scroll', 'fevr' ),
			    ),
			    'default'  => 'standard',
			    'required' => array('woocommerce-photo-reviews', '=', 1),
            ),
            array(
	            'id'       => 'woocommerce-photo-reviews-rating',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Rating Option', 'fevr' ),
	            'default' => '0',
            	'required' => array('woocommerce-photo-reviews', '=', 1),
	        ),
	        array(
	            'id'       => 'woocommerce-photo-reviews-date',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Date', 'fevr' ),
	            'default' => '0',
	            'required' => array('woocommerce-photo-reviews', '=', 1)
	        ),
	        array(
	            'id'       => 'woocommerce-photo-reviews-likes',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Likes', 'fevr' ),
	            'default' => '0',
	            'required' => array('woocommerce-photo-reviews', '=', 1)
	        ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Collections', 'fevr' ),
        'desc'  => esc_html__( 'Settings related to the collection can be found here.', 'fevr' ),
        'id'    => 'woocommerce-tab-collections',
        'subsection'       => true,
        'fields'     => array(
	        array(
	        		'id'       => 'woocommerce-collections-disabled',
	        		'type'	   => 'info',
	        		'title'    => esc_html__( 'Woocommerce Collections are currently disabled', 'fevr' ),
	        		'desc'	   => esc_html__( 'Please enable Collections in WooCommerce General section.', 'fevr' ),
	        		'required' => array('woocommerce-collections', '!=', 1),
	        		'style'	   => 'warning'
	        ),
	        array(
	            'id'       => 'woocommerce-collections-sidebar-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Sidebar Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Sidebar settings.', 'fevr' ),
	            'options'  => array(
	                'left-sidebar' => array(
	                    'alt' => esc_html__('Left Sidebar', 'fevr' ),
	                	'title' => esc_html__('Left Sidebar', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-sidebar.png'
	                ),
	           		'right-sidebar' => array(
	           			'alt' => esc_html__('Right Sidebar', 'fevr' ),
	           			'title' => esc_html__('Right Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/right-sidebar.png'
	           		),
	           		'no-sidebar' => array(
	           			'alt' => esc_html__('No Sidebar', 'fevr' ),
	           			'title' => esc_html__('No Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/no-sidebar.png'
	           		),
				),
	            'default'  => 'right-sidebar',
	            'required' => array('woocommerce-collections', '=', 1),
	        ),
			array(
                'id'       => 'woocommerce-collections-sidebar',
                'type'	   => 'select',
                'title'    => esc_html__( 'Sidebar', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose which sidebar you would like to display.', 'fevr' ),
                'data'     => 'sidebars',
                'default'  => '',
                'required' => array(
                	array('woocommerce-collections-sidebar-position', '!=', 'no-sidebar'),
                	array('woocommerce-collections', '=', 1)
                )
            ),
            array(
	            'id'       => 'woocommerce-collections-sidebar-single',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Sidebar on Single Page', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like a sidebar only on the archive page.', 'fevr' ),
	            'default' => '1',
	            'required' => array(
	            	array('woocommerce-collections-sidebar-position', '!=', 'no-sidebar'),
	            	array('woocommerce-collections', '=', 1)
            	)
	        ),
	        array(
                'id'       => 'woocommerce-collections-full-width',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Full Width Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable if you would like the collections in full width layout. If disabled, the page will be in a grid with a specific width.', 'fevr' ),
			    'default'  => '0',
			    'required' => array('woocommerce-collections', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-collections-page',
                'type'     => 'select',
                'title'    => esc_html__( 'Page to display collections archive', 'fevr' ),
                'subtitle'     => esc_html__( 'You can create a new page, on which you can set a custom header and content. In this case, on the archive page the set custom header and custom content will appear above the items.', 'fevr' ),
                'data' 	   => 'page',
                'flush_permalinks' => 'true',
                'required' => array('woocommerce-collections', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-collections-custom-slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Collections Slug', 'fevr' ),
                'subtitle'     => esc_html__( 'Here you can change the custom slug of the collections. Default is currently set to "collections".', 'fevr' ),
                'validate' => 'unique_slug',
                'validate' => 'no_special_chars',
                'flush_permalinks' => 'true',
                'required' => array('woocommerce-collections', '=', 1),
            ),
            array(
	            'id'       => 'woocommerce-collections-columns',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Columns', 'fevr' ),
	            'subtitle' => esc_html__( 'How many columns should the archive page be divided into?', 'fevr' ),
	            'options'  => array(
	           		'two-columns' => array(
	           			'alt' => esc_html__('Two Columns', 'fevr' ),
	           			'title' => esc_html__('Two Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/two-columns.png'
	           		),
	           		'three-columns' => array(
	           			'alt' => esc_html__('Three Columns', 'fevr' ),
	           			'title' => esc_html__('Three Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/three-columns.png'
	           		),
	           		'four-columns' => array(
	           			'alt' => esc_html__('Four Columns', 'fevr' ),
	           			'title' => esc_html__('Four Columns', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/four-columns.png'
	           		),
				),
	            'default'  => 'three-columns',
	            'required' => array('woocommerce-collections', '=', 1),
	        ),
	        array(
                'id'       => 'woocommerce-collections-masonry-hover-style',
                'type'	   => 'select',
                'title'    => esc_html__( 'Masonry Hover Style', 'fevr' ),
	            'subtitle' => esc_html__( 'In what style should the masonry\'s appearance be?', 'fevr' ),
	            'options'  => array(
	                'masonry-style-zoom' 		=> esc_html__('Zoom In', 'fevr' ),
	                'masonry-style-zoom-out' 	=> esc_html__('Zoom Out', 'fevr' ),
	                'masonry-style-title-bottom'=> esc_html__('Title from Bottom', 'fevr' ),
	                'masonry-style-title-left'	=> esc_html__('Title from Left', 'fevr' ),
	                'masonry-style-solid'		=> esc_html__('Solid Border', 'fevr' ),
	                'masonry-style-gradient'	=> esc_html__('Dark Gradient', 'fevr' ),
	                'masonry-box-shadow'		=> esc_html__('Box Shadow', 'fevr' ),
	                'masonry-box-border'		=> esc_html__('Box Border', 'fevr' ),
	                'masonry-shine'				=> esc_html__('Shine Effect', 'fevr' ),
	                'masonry-color-overlay'		=> esc_html__('Color Overlay', 'fevr' ),
	                'masonry-color-overlay-text'		=> esc_html__('Color Overlay with Text', 'fevr' ),
	                'masonry-perspective'		=> esc_html__('Perspective', 'fevr' ),
			    ),
	            'default'  => 'masonry-style-zoom',
	            'required' => array('woocommerce-collections', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-collections-masonry-content',
                'type'	   => 'select',
                'title'    => esc_html__( 'Visible Content on Archive', 'fevr' ),
	            'subtitle' => esc_html__( 'Please select the data you want to be displayed.', 'fevr' ),
			    'options'  => array(
	                'title' 		=> esc_html__('Title', 'fevr' ),
			        'title-excerpt' => esc_html__('Title & Excerpt', 'fevr' ),
			    ),
			    'default'  => 'title-excerpt',
            ),
            array(
            		'id'       => 'woocommerce-collections-animation',
            		'type'	   => 'select',
            		'title'    => esc_html__( 'Item Display Animation', 'fevr' ),
            		'default'  => '',
            		'options'	=> array(
            				''							=> esc_html__('None', 'fevr'),
            				'c-animate-fade-in'			=> esc_html__('Fade in', 'fevr'),
            				'c-animate-top'				=> esc_html__('Fade in from top', 'fevr'),
            				'c-animate-bottom'			=> esc_html__('Fade in from bottom', 'fevr'),
            				'c-animate-left'			=> esc_html__('Fade in from left', 'fevr'),
            				'c-animate-right'			=> esc_html__('Fade in from right', 'fevr'),
            				'c-animate-zoom-in'			=> esc_html__('Zoom in', 'fevr'),
            				'c-animate-zoom-in-spin'	=> esc_html__('Zoom in & Spin', 'fevr'),
            		)
            ),
            array(
                'id'       => 'woocommerce-collections-breadcrumbs',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Breadcrumbs', 'fevr' ),
			    'default'  => '0',
            ),
	        array(
                'id'       => 'woocommerce-collections-pagination',
                'type'	   => 'select',
                'title'    => esc_html__( 'Pagination', 'fevr' ),
	            'subtitle' => esc_html__( 'Select the type of pagination.', 'fevr' ),
                'options'  => array(
	                'standard' => esc_html__('Standard Pagination', 'fevr' ),
			        'prev-next' => esc_html__('Previous/Next Links', 'fevr' ),
			        'infinite-scroll' => esc_html__('Infinite Scroll', 'fevr' ),
			    ),
			    'default'  => 'standard',
			    'required' => array('woocommerce-collections', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-hide-collections-pagination',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Hide Previous/Next Links on Single Page', 'fevr' ),
			    'default'  => '0',
			    'required' => array('woocommerce-collections', '=', 1),
            ),
            array(
                'id'       => 'woocommerce-collections-pagination-position',
                'type'	   => 'select',
                'title'    => esc_html__( 'Previous/Next Links Position on Single Page', 'fevr' ),
                'options'  => array(
	                'header' => esc_html__('Header', 'fevr' ),
			        'under-content' => esc_html__('Under Content', 'fevr' ),
			    ),
			    'default'  => 'header',
			    'required' => array(
			    	array('woocommerce-hide-collections-pagination', '=', 0),
			    	array('woocommerce-collections', '=', 1),
			    )
            ),
            array(
	            'id'       => 'woocommerce-collections-social-meta',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Share/Like Icons on Single Page', 'fevr' ),
	            'default' => '0',
				'required' => array('woocommerce-collections', '=', 1),
	        ),
        )
    ) );

    endif;

    //======================================================================
    // bbPress
    //======================================================================


    // The tab is only visible when WooCommerce activated
    if(luv_is_plugin_active('bbpress/bbpress.php')):

    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'bbPress', 'fevr' ),
        'desc'  => esc_html__( 'Settings related to the bbPress can be found here.', 'fevr' ),
        'id'    => 'bbpress-tab',
        'icon'  => 'el el-comment-alt',
        'fields'     => array(
	        array(
	            'id'       => 'bbpress-sidebar-position',
	            'type'     => 'image_select',
	            'title'    => esc_html__( 'Sidebar Layout', 'fevr' ),
	            'options'  => array(
	                'left-sidebar' => array(
	                    'alt' => esc_html__('Left Sidebar', 'fevr' ),
	                	'title' => esc_html__('Left Sidebar', 'fevr' ),
	                    'img' => ReduxFramework::$_url . 'assets/img/luvthemes/left-sidebar.png'
	                ),
	           		'right-sidebar' => array(
	           			'alt' => esc_html__('Right Sidebar', 'fevr' ),
	           			'title' => esc_html__('Right Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/right-sidebar.png'
	           		),
	           		'no-sidebar' => array(
	           			'alt' => esc_html__('No Sidebar', 'fevr' ),
	           			'title' => esc_html__('No Sidebar', 'fevr' ),
	           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/no-sidebar.png'
	           		),
				),
	            'default'  => 'right-sidebar'
	        ),
			array(
                'id'       => 'bbpress-sidebar',
                'type'	   => 'select',
                'title'    => esc_html__( 'Sidebar', 'fevr' ),
	            'subtitle' => esc_html__( 'Please choose which sidebar you would like to display.', 'fevr' ),
                'data'     => 'sidebars',
                'default'  => '',
                'required' => array('bbpress-sidebar-position', '!=', 'no-sidebar'),
            ),
            array(
	            'id'       => 'bbpress-sidebar-single',
	            'type'     => 'checkbox',
	            'title'    => esc_html__( 'Hide Sidebar on Topic Page', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable this if you would like a sidebar only on the forum page.', 'fevr' ),
	            'default' => '1',
	            'required' => array('bbpress-sidebar-position', '!=', 'no-sidebar'),
	        ),
	        array(
                'id'       => 'bbpress-full-width',
                'type'	   => 'checkbox',
                'title'    => esc_html__( 'Full Width Layout', 'fevr' ),
	            'subtitle' => esc_html__( 'Enable it if you would like the forums to be in full width of the page. If disabled the page will appear in a grid with a specified width.', 'fevr' ),
			    'default'  => '0',
            ),
	        array(
                'id'       => 'bbpress-page',
                'type'     => 'select',
                'title'    => esc_html__( 'Page to Display Forums', 'fevr' ),
                'subtitle'     => esc_html__( 'You can create a new page, on which you can set a custom header and content. In this case, on the archive page the set custom header will appear above the items.', 'fevr' ),
                'data' 	   => 'page',
                'flush_permalinks' => 'true',
            ),
        )
    ) );

    endif;

    //======================================================================
    // Search
    //======================================================================

    Redux::setSection ( $opt_name, array (
    		'title' => esc_html__( 'Search', 'fevr' ),
    		'desc' => esc_html__( 'You can modify the look of the search results with options below.', 'fevr' ),
    		'id' => 'search-tab',
    		'icon' => 'el el-search',
    		'fields'     => array(
		        array(
		            'id'       => 'search-columns',
		            'type'     => 'image_select',
		            'title'    => esc_html__( 'Columns', 'fevr' ),
		            'subtitle' => esc_html__( 'How many columns should the search page be divided into?', 'fevr' ),
		            'options'  => array(
		           		'two-columns' => array(
		           			'alt' => esc_html__('Two Columns', 'fevr' ),
		           			'title' => esc_html__('Two Columns', 'fevr' ),
		           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/two-columns.png'
		           		),
		           		'three-columns' => array(
		           			'alt' => esc_html__('Three Columns', 'fevr' ),
		           			'title' => esc_html__('Three Columns', 'fevr' ),
		           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/three-columns.png'
		           		),
		           		'four-columns' => array(
		           			'alt' => esc_html__('Four Columns', 'fevr' ),
		           			'title' => esc_html__('Four Columns', 'fevr' ),
		           			'img' => ReduxFramework::$_url . 'assets/img/luvthemes/four-columns.png'
		           		),
					),
		            'default'  => 'four-columns',
		        ),
		        array(
                	'id'       => 'search-equal-height',
	                'type'	   => 'checkbox',
	                'title'    => esc_html__( 'Equal Height Columns', 'fevr' ),
		            'subtitle' => esc_html__( 'Enable it if you would like the equal height for the cards.', 'fevr' ),
				    'default'  => '0',
	            ),
		        array(
            		'id'       => 'search-posts-per-page',
            		'type'	   => 'text',
            		'title'    => esc_html__( 'Number of Results', 'fevr' ),
            		'subtitle' => esc_html__( 'The number of posts to show.', 'fevr' ),
            		'default'  => '12',
				),
				array(
		            'id'       => 'search-filter',
		            'type'     => 'checkbox',
		            'title'    => esc_html__( 'Search Filter', 'fevr' ),
		            'subtitle' => esc_html__( 'Enable for a filter above the search. With this option the user can choose on what pages to search. e.g. product, post, etc.', 'fevr' ),
		            'default'  => '1'
		        ),
	    		array(
	    			'id'       => 'search-filter-post-types',
	    			'type'     => 'checkbox',
	    			'title'    => esc_html__( 'Search Filter', 'fevr' ),
	    			'subtitle' => esc_html__( 'Select post types for search filter', 'fevr' ),
	    			'required' => array(
	    					'search-filter',
	    					'=',
	    					'1'
	    			)
	    		),
	    		array(
						'id'	=> 'search-guess-typo',
						'type'	=> 'checkbox',
						'class' => 'switch_style',
						'title'	=> esc_html__( 'Search Tips', 'fevr' ),
						'subtitle' => esc_html__('Show "Did you mean" recommendations for search', 'fevr'),
						'default' => 0
				),
				array(
						'id'	=> 'search-hide-pt',
						'type'	=> 'checkbox',
						'class' => 'switch_style',
						'title'	=> esc_html__( 'Hide Post Type', 'fevr' ),
						'subtitle' => esc_html__('Enable to hide the tag with the post type on the search results page.', 'fevr'),
						'default' => 0
				),
	        )
    ));

    //======================================================================
    // Performance
    //======================================================================

    Redux::setSection ( $opt_name, array (
    		'title' => esc_html__( 'Performance', 'fevr' ),
    		'desc' => esc_html__( 'You can improve the performance of the site with options below.', 'fevr' ),
    		'id' => 'performance-tab',
    		'icon' => 'el el-dashboard',
    ));

	Redux::setSection ( $opt_name, array (
			'title' => esc_html__( 'General', 'fevr' ),
			'id' => 'performance-general-tab',
			'subsection' => true,
			'fields' => array (
					array(
							'id'	=> 'optimize-uploaded-images',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Optimize Images', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like to optimize the images during the upload using the Luvthemes Image Optimization API service.', 'fevr'),
							'default' => 0
					),
					array(
							'id'	=> 'instantclick',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'InstantClick', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like to preload pages on hover/touchstart for better performance.', 'fevr'),
							'default' => 0
					),
					array(
							'id'	=> 'lazy-load-images',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Lazy Load', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like lazy load for images.', 'fevr'),
							'default' => 0
					),
					array(
							'id'	=> 'inline-css',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Dynamic Inline CSS', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like to print the dynamic css into the head, instead of a seperated CSS file.', 'fevr'),
							'default' => 1
					),
		            array(
		            		'id'	=> 'remove-inline-styles',
		            		'type'	=> 'checkbox',
		            		'title'	=> esc_html__( 'Remove Inline Style', 'fevr' ),
		            		'subtitle' => esc_html__('Enable if you would like to remove all style="" attribute from them DOM.', 'fevr'),
		            		'default' => 0
		            ),
					array(
							'id'	=> 'scripts-to-footer',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Scripts in Footer', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like to move all javascript to the footer.', 'fevr'),
							'default' => 0
					),
					array(
							'id'	=> 'merge-scripts',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Merge Scripts', 'fevr' ),
							'subtitle' => esc_html__('Merge javascript files to reduce number of HTML requests', 'fevr'),
							'default' => 0,
							'required' => array('scripts-to-footer', '=', 1)
					),
					array(
							'id'	=> 'merge-styles',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Merge Styles', 'fevr' ),
							'subtitle' => esc_html__('Merge CSS files to reduce number of HTML requests', 'fevr'),
							'default' => 0,
					),
					array(
							'id'	=> 'merge-styles-include-google-fonts',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Include Google Fonts', 'fevr' ),
							'subtitle' => esc_html__('Add Google Fonts CSS to merged styles', 'fevr'),
							'required' => array('merge-styles', '=', 1),
							'default' => 0,
					),
					array(
							'id'	=> 'async-merged-css',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Async merged CSS', 'fevr' ),
							'subtitle' => esc_html__('Load merged CSS files asynchronously', 'fevr'),
							'default' => 0,
							'required' => array('merge-styles', '=', 1)
					),
					array(
							'id'	=> 'normalize-static-resources',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Normalize Static Resources', 'fevr' ),
							'subtitle' => esc_html__('Remove unnecessary query string from CSS, JS and image files.', 'fevr'),
							'default' => 0
					),
		            array(
		            		'id'	=> 'defer-footer-scripts',
		            		'type'	=> 'checkbox',
		            		'title'	=> esc_html__( 'Defer footer scripts', 'fevr' ),
		            		'subtitle' => esc_html__('Enable if you would like to defer all scripts what are located in the footer.', 'fevr'),
		            		'default' => 0
		            ),
					array(
							'id'	=> 'merge-google-fonts',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Merge Google Fonts', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like to merge all Google Fonts request', 'fevr'),
							'default' => 0
					),
					array(
							'id'	=> 'defer-google-fonts',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Defer Google Fonts', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like to defer Google Fonts.', 'fevr'),
							'default' => 0
					),
		            array(
		            		'id'	=> 'smart-iconset-enqueue',
		            		'type'	=> 'checkbox',
		            		'title'	=> esc_html__( 'Smart Iconset Loading', 'fevr' ),
		            		'subtitle' => esc_html__('Enable if you would like to load iconsets only if they are used on the current page.', 'fevr'),
		            		'default' => 1
		            ),
			)
	) );

	Redux::setSection ( $opt_name, array (
			'title' => esc_html__( 'CDN', 'fevr' ),
			'desc' => _luv_kses(__('Speed up your website with', 'fevr').' <a href="//tracking.maxcdn.com/c/258716/3968/378" target="_blank">MaxCDN</a>'),
			'id' => 'performance-cdn-tab',
			'subsection' => true,
			'fields' => array (
				array(
						'id'	=> 'enable-cdn',
						'type'	=> 'checkbox',
						'title'	=> esc_html__( 'Enable CDN', 'fevr' ),
						'default' => 0
				),
				array(
						'id'	=> 'cdn-hostname-master',
						'type'	=> 'text',
						'title'	=> esc_html__( 'CDN Hostname', 'fevr' ),
						'required' => array('enable-cdn', '=', 1)
				),
				array(
						'id'	=> 'cdn-hostname-slot-1',
						'type'	=> 'text',
						'title'	=> esc_html__( 'CDN Hostname for Javascript ', 'fevr' ),
						'required' => array('cdn-hostname-master', '!=', ''),
						'subtitle' => esc_html__('Use different hostname for javascript files', 'fevr'),
				),
				array(
						'id'	=> 'cdn-hostname-slot-2',
						'type'	=> 'text',
						'title'	=> esc_html__( 'CDN Hostname for Media files', 'fevr' ),
						'required' => array('cdn-hostname-slot-1', '!=', ''),
						'subtitle' => esc_html__('Use different hostname for media files', 'fevr'),
				),
				array(
						'id'	=> 'enable-cdn-ssl',
						'type'	=> 'checkbox',
						'title'	=> esc_html__( 'Enable', 'fevr' ),
						'default' => 0,
						'subtitle' => esc_html__('Enable CDN for SSL. You can specify different hostname(s) for SSL, or leave them blank for use the same host on HTTP and SSL', 'fevr'),
						'required' => array('enable-cdn', '=', 1)
				),
				array(
						'id'	=> 'cdn-hostname-master-ssl',
						'type'	=> 'text',
						'title'	=> esc_html__( 'CDN Hostname', 'fevr' ),
						'required' => array('enable-cdn-ssl', '=', 1)
				),
				array(
						'id'	=> 'cdn-hostname-slot-1-ssl',
						'type'	=> 'text',
						'title'	=> esc_html__( 'CDN Hostname for Javascript ', 'fevr' ),
						'required' => array('cdn-hostname-master-ssl', '!=', ''),
						'subtitle' => esc_html__('Use different hostname for javascript files', 'fevr'),
				),
				array(
						'id'	=> 'cdn-hostname-slot-2-ssl',
						'type'	=> 'text',
						'title'	=> esc_html__( 'CDN Hostname for Media files', 'fevr' ),
						'required' => array('cdn-hostname-slot-1-ssl', '!=', ''),
						'subtitle' => esc_html__('Use different hostname for media files', 'fevr'),
				),
				array(
						'id'	=> 'maxcdn-alias',
						'type'	=> 'text',
						'title'	=> esc_html__( 'MAXCDN Alias', 'fevr' ),
						'required' => array('enable-cdn', '=', 1),
				),
				array(
						'id'	=> 'maxcdn-key',
						'type'	=> 'text',
						'title'	=> esc_html__( 'MAXCDN Consumer Key', 'fevr' ),
						'required' => array('enable-cdn', '=', 1),
				),
				array(
						'id'	=> 'maxcdn-secret',
						'type'	=> 'text',
						'title'	=> esc_html__( 'MAXCDN Consumer Secret', 'fevr' ),
						'required' => array('enable-cdn', '=', 1),
				),
			)
	));

	//======================================================================
	// Tweaks
	//======================================================================

	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Tweaks', 'fevr' ),
		'id'     => 'tweaks-tab',
	    'icon'   => 'el el-wrench',
	));

	Redux::setSection ( $opt_name, array (
			'title' => esc_html__( 'General', 'fevr' ),
			'desc' => esc_html__( 'By using these functions you can make small modifications to your page', 'fevr' ),
			'id' => 'tweaks-tab-general',
			'icon' => 'el el-wrench',
			'subsection' => 'true',
			'fields' => array (
					array(
							'id'	=> 'enable-mobile-app',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Enable Fevr Mobile', 'fevr' ),
							'subtitle' => esc_html__('Enable this option if you would like to use Fevr HTML5 mobile app', 'fevr'),
							'required' => array('disabled-enable-mobile-app', '=',1),
							'default' => 0
					),
					array(
						'id'	=> 'mobile-app-home',
						'type'     => 'select',
		                'title'    => esc_html__( 'Mobile App Homepage', 'fevr' ),
		                'subtitle' => esc_html__( 'Select homepage for Fevr Mobile App', 'fevr' ),
		                'data' 	   => 'page',
						'required' => array('enable-mobile-app', '=',1),
		                'flush_permalinks' => 'true',
					),
					array(
							'id'	=> 'mobile-app-force-login',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Force Login for Fevr Mobile', 'fevr' ),
							'subtitle' => esc_html__('Enable this option if you would like to force users to login in Fevr Mobile', 'fevr'),
							'required' => array('enable-mobile-app', '=',1),
							'default' => 0
					),
                              array(
                  			'id'	=> 'custom-404',
                  			'type'	=> 'select',
                  			'data'	=> 'page',
                  			'title'	=> esc_html__( '404 Page', 'fevr' ),
                  			'subtitle' => esc_html__( 'For 404 pages you can use custom content too.', 'fevr' ),
                  		),
					array(
							'id'	=> 'coming-soon-mode',
							'type'	=> 'checkbox',
							'default' => 0,
							'title'	=> esc_html__( 'Coming Soon Mode', 'fevr' ),
					),
					array(
							'id'	=> 'coming-soon-page',
							'type'	=> 'select',
							'data'	=> 'page',
							'title'	=> esc_html__( 'Coming Soon Page', 'fevr' ),
							'required' => array('coming-soon-mode', '=',1),
					),
					array(
							'id'	=> 'sounds-like-404',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Sounds Like Redirect', 'fevr' ),
							'subtitle' => 'If the visitor mistypes the URL WordPress will try to find the best matching permalink  and redirect to the requested page.',
							'default' => 0
					),
					array(
							'id'	=> 'custom-image-sizes',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Custom Image Sizes', 'fevr' ),
							'subtitle' => _luv_kses(__('These settings affect the display and dimensions of images on the entire site - the display on the front-end will still be affected by CSS styles. After changing these settings you may need to <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a>.', 'fevr')),
							'default' => 0
					),
					array(
							'id'             => 'custom-image-sizes-general',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Masonry - Standard', 'fevr' ),
							'units'          => false,
							'default'        => array(
									'width'  => 1000,
									'height' => 620,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'             => 'custom-image-sizes-normal',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Masonry - Normal', 'fevr' ),
							'units'          => false,
							'default'        => array(
									'width'  => 500,
									'height' => 500,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'             => 'custom-image-sizes-wide',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Masonry - Wide', 'fevr' ),
							'units'          => false,
							'default'        => array(
									'width'  => 1000,
									'height' => 500,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'             => 'custom-image-sizes-tall',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Masonry - Tall', 'fevr' ),
							'units'          => false,
							'default'        => array(
									'width'  => 500,
									'height' => 1000,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'             => 'custom-image-sizes-wide-tall',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Masonry - Wide & Tall', 'fevr' ),
							'units'          => false,
							'default'        => array(
									'width'  => 1000,
									'height' => 1000,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'             => 'custom-image-sizes-full',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Masonry - Full', 'fevr' ),
							'units'          => false,
							'height'		 => false,
							'default'        => array(
									'width'  => 2000,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'             => 'custom-image-sizes-featured',
							'type'           => 'dimensions',
							'title'          => esc_html__( 'Featured Image for Posts', 'fevr' ),
							'units'          => false,
							'default'        => array(
									'width'  => 2000,
									'height' => 800,
							),
							'required' => array('custom-image-sizes', '=', 1),
					),
					array(
							'id'       => 'google-maps-api-key',
							'type'     => 'text',
							'title'    => esc_html__( 'Google Maps API Key', 'fevr' ),
							'subtitle'     => _luv_kses(__( 'See instructions <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>.', 'fevr' )),
					),
					array(
							'id'	=> 'ga-dashboard-widget',
							'type'	=> 'checkbox',
							'title'	=> esc_html__( 'Google Analytics Dashboard Widget', 'fevr' ),
							'subtitle' => esc_html__('Enable if you would like Google Analytics quick report on WordPress Dashboard.', 'fevr'),
							'default' => 0
					),
					array(
							'id'       => 'ga-cid',
							'type'     => 'text',
							'title'    => esc_html__( 'Google Analytics Client ID', 'fevr' ),
							'subtitle'     => _luv_kses(__( 'See instructions <a href="https://developers.google.com/api-client-library/javascript/start/start-js#setup" target="_blank">here</a>.', 'fevr' )),
							'required' => array('ga-dashboard-widget', '=', 1),
					),
					array(
							'id'       => 'ga-vid',
							'type'     => 'text',
							'title'    => esc_html__( 'Google Analytics View ID', 'fevr' ),
							'subtitle'     => esc_html__( 'You can find your View ID in Google Analytics > Admin > Select Property > View Settings.', 'fevr' ),
							'required' => array('ga-dashboard-widget', '=', 1),
					),

			),
	) );

	//======================================================================
    // Custom Page Header
    //======================================================================

    Redux::setSection ( $opt_name, array (
    		'title' => esc_html__( 'Custom Page Header', 'fevr' ),
    		'desc' => esc_html__( 'You can set a custom header for the archive pages with options below. In this case, on the archive page the set custom header will appear above the content.', 'fevr' ),
    		'id' => 'custom-header-tab',
    		'icon' => 'el el-website',
    		'subsection' => 'true',
    		'fields'     => array(
	    		array(
                          'id'    => 'custom-header-info',
                          'type'  => 'info',
                          'style' => 'info',
                          'desc'  => __( 'You can find header options for <a href="'.get_admin_url().'admin.php?page=theme-options&tab=24">portfolio</a>, <a href="'.get_admin_url().'admin.php?page=theme-options&tab=28">photo reviews</a>, <a href="'.get_admin_url().'admin.php?page=theme-options&tab=29">collections</a>, <a href="'.get_admin_url().'admin.php?page=theme-options&tab=30">bbpress</a> on their dedicated pages.', 'fevr' )
                  ),
                  array(
                    'id'       => 'custom-header-default',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Default Custom Header', 'fevr' ),
                    'data' 	   => 'page',
                    'flush_permalinks' => 'true',
                  ),
      	    	array(
                    'id'       => 'custom-header-author',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Author Archive', 'fevr' ),
                    'data' 	   => 'page',
                    'flush_permalinks' => 'true',
                  ),
                  array(
                    'id'       => 'custom-header-category',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Category Archive', 'fevr' ),
                    'data' 	   => 'page',
                    'flush_permalinks' => 'true',
                  ),
                  array(
                    'id'       => 'custom-header-tag',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Tag Archive', 'fevr' ),
                    'data' 	   => 'page',
                    'flush_permalinks' => 'true',
                  ),
                  array(
                    'id'       => 'custom-header-date',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Daily/monthly/yearly Archive', 'fevr' ),
                    'data' 	   => 'page',
                    'flush_permalinks' => 'true',
                  ),
            )
    ));

    //======================================================================
    // Custom Page Header
    //======================================================================

    Redux::setSection ( $opt_name, array (
    		'title' => esc_html__( 'Lightbox Settings', 'fevr' ),
    		'desc' => esc_html__( 'Customize lightbox look and behavior', 'fevr' ),
    		'id' => 'lightbox-settings',
    		'icon' => 'el el-photo',
    		'subsection' => 'true',
    		'fields'     => array(
    				array(
    						'id'       => 'lightbox-portfolio-enabled',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Enable lightbox for Portfolio', 'fevr' ),
    						'subtitle' 	   => esc_html__( 'Enable lightbox on portfolio archive pages', 'fevr' ),
    						'default'  => '1'
    				),
    				array(
    						'id'       => 'lightbox-woocommerce-enabled',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Enable lightbox for WooCommerce', 'fevr' ),
    						'subtitle'	   => esc_html__( 'Enable lightbox on WooCommerce product pages', 'fevr' ),
    						'default'  => '1'
    				),
    				array(
    						'id'       => 'lightbox-photoreview-enabled',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Enable lightbox for Photo Reviews', 'fevr' ),
    						'subtitle'	   => esc_html__( 'Enable lightbox on Photo Reviews archive pages', 'fevr' ),
    						'default'  => '1'
    				),
    				array(
    						'id'       => 'lightbox-attachment-enabled',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Enable lightbox for Attachments', 'fevr' ),
    						'subtitle' 	   => esc_html__( 'Enable lightbox for images in posts/pages', 'fevr' ),
    						'default'  => '1'
    				),
    				array(
    						'id'       => 'lightbox-gallery-enabled',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Enable lightbox for Galleries', 'fevr' ),
    						'subtitle' 	   => esc_html__( 'Enable lightbox for images in WordPress galleries', 'fevr' ),
    						'default'  => '1'
    				),
    				array(
    						'id'       => 'lightbox-skin',
    						'type'     => 'select',
    						'title'    => esc_html__( 'Lightbox Skin', 'fevr' ),
    						'subtitle' => esc_html__( 'Skin for lightbox', 'fevr' ),
    						'options'  => array(
    								'dark'			=> esc_html__('Dark', 'fevr'),
    								'light'			=> esc_html__('Light', 'fevr'),
    								'mac'			=> esc_html__('Mac', 'fevr'),
    								'metro-white'	=> esc_html__('Metro White', 'fevr'),
    								'metro-black'	=> esc_html__('Metro Black', 'fevr'),
    								'parade'		=> esc_html__('Parade', 'fevr'),
    								'smooth' 		=> esc_html__('Smooth', 'fevr'),
    						),
    						'default'  => 'dark',
    				),
    				array(
    						'id'       => 'lightbox-path',
    						'type'     => 'select',
    						'title'    => esc_html__( 'Path', 'fevr' ),
    						'subtitle' => esc_html__( 'Lightbox path', 'fevr' ),
    						'options'  => array(
    								'vertical'			=> esc_html__('Vertical', 'fevr'),
    								'horizontal'		=> esc_html__('Horizontal', 'fevr'),
    						),
    						'default'  => 'vertical'
    				),
    				array(
    						'id'       => 'lightbox-inner-toolbar',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Inner Toolbar', 'fevr' ),
    						'subtitle' => esc_html__( 'Use inner toolbar for lightbox', 'fevr' ),
    						'default'  => '0'
    				),
    				array(
    						'id'       => 'lightbox-arrows',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Arrow', 'fevr' ),
    						'subtitle' => esc_html__( 'Enable the arrow buttons', 'fevr' ),
    						'default'  => '0'
    				),
    				array(
    						'id'       => 'lightbox-slideshow',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Slideshow', 'fevr' ),
    						'subtitle' => esc_html__( 'Enable the slideshow button', 'fevr' ),
    						'default'  => '0'
    				),
    				array(
    						'id'       => 'lightbox-fullscreen',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Fullscreen', 'fevr' ),
    						'subtitle' => esc_html__( 'Sets the fullscreen button', 'fevr' ),
    						'default'  => '0'
    				),
    				array(
    						'id'       => 'lightbox-thumbnail',
    						'type'     => 'checkbox',
    						'title'    => esc_html__( 'Thumbnail', 'fevr' ),
    						'subtitle' => esc_html__( 'Sets the thumbnail navigation', 'fevr' ),
    						'default'  => '0'
    				),
    		)
    ));

	//======================================================================
	// Whitelabel
	//======================================================================
	Redux::setSection ( $opt_name, array (
			'title' => esc_html__( 'Whitelabel', 'fevr' ),
			'desc' => esc_html__( 'By using these options you can change theme name and other theme details', 'fevr' ),
			'id' => 'whitelabel-tab',
			'icon' => 'el el-barcode',
			'fields' => array (
					array(
							'id'	=> 'whitelabel-theme-name',
							'type'	=> 'text',
							'title'	=> esc_html__( 'Theme Name', 'fevr' ),
					),
					array(
							'id'	=> 'whitelabel-screenshot',
							'type'     => 'media',
							'title'    => esc_html__( 'Theme Screenshot', 'fevr' ),
					),
					array(
							'id'	=> 'whitelabel-description',
							'type'     => 'text',
							'title'    => esc_html__( 'Theme Description', 'fevr' ),
					),
					array(
							'id'	=> 'whitelabel-author',
							'type'     => 'text',
							'title'    => esc_html__( 'Theme Author', 'fevr' ),
					),
					array(
							'id'	=> 'whitelabel-author-uri',
							'type'     => 'text',
							'title'    => esc_html__( 'Theme Author URI', 'fevr' ),
					),
					array(
							'id'	=> 'whitelabel-version',
							'type'     => 'text',
							'title'    => esc_html__( 'Theme Version', 'fevr' ),
					),
					array(
							'id'	=> 'whitelabel-menu-icon',
							'type'     => 'media',
							'title'    => esc_html__( 'Dashboard Menu Icon', 'fevr' ),
					),
					array(
							'id'	=> 'custom-login-page',
							'type'     => 'select',
							'title'    => esc_html__( 'Custom Login Page', 'fevr' ),
							'subtitle' => esc_html__( 'Change the default wp-login.php page with any page', 'fevr' ),
							'data'	=> 'page'
					),
			)
	));

	if (defined('FEVR_WHITELABEL')){
		Redux::hideSection ($opt_name, 'whitelabel-tab');
	}

    /*
     * <--- END SECTIONS
     */

    /**
     * Redux compiler action to generate dynamic CSS file
     * @param array $options
     * @param string $css
     * @param array $changed_values
     */
    function compiler_action($options, $css, $changed_values) {
    	WP_Filesystem();
    	global $wp_filesystem;

    	update_option('fevr_dynamic_css', $css);

    	$wp_filesystem->put_contents(trailingslashit(get_template_directory()) . 'css/dynamic.css', $css, FS_CHMOD_FILE);
    }


    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'fevr_purchase_validate_callback_function' ) ) {
        function fevr_purchase_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;

			$response = wp_remote_post ( FEVR_API_URL . 'validate/', array (
					'timeout' => 60,
					'sslverify' => false,
					'user-agent' => 'luv',
					'headers' => array (
							'X-ENVATO-PURCHASE-KEY' => trim ( $value )
					),
					'body' => array (
							'site' => home_url ()
					)
			) );

            if (is_wp_error($response)) {
                $error = true;
                $message = esc_html__('Couldn\'t connect to server, please try again.', 'fevr');
                $value = $existing_value;
            }
            else{
            	$response = json_decode($response['body'],true);
            	if ($response['error'] === true){
            		$error = true;
            		$message = $response['response'];
            		$value = $existing_value;
            	}
            }

            $return['value'] = $value;

            if ( $error == true ) {
            	$field['msg']    = $message;
                $return['error'] = $field;
            }

            return $return;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    function fevr_change_arguments( $args ) {
    	//If dynamic CSS not writable use inline CSS in header
    	if (!file_exists(trailingslashit(get_template_directory()) . 'css/dynamic.css') || !is_writable(trailingslashit(get_template_directory()) . 'css/dynamic.css')){
    		$args['output_tag'] = true;
    	}

        return $args;
    }
