<?php
add_action('after_setup_theme', 'pickton_bunch_theme_setup');
function pickton_bunch_theme_setup()
{
	global $wp_version;
	if(!defined('PICKTON_VERSION')) define('PICKTON_VERSION', '1.0');
	if( !defined( 'PICKTON_ROOT' ) ) define('PICKTON_ROOT', get_template_directory().'/');
	if( !defined( 'PICKTON_URL' ) ) define('PICKTON_URL', get_template_directory_uri().'/');	
	include_once get_template_directory() . '/includes/loader.php';
	
	
	load_theme_textdomain('pickton', get_template_directory() . '/languages');
	
	//ADD THUMBNAIL SUPPORT
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support('automatic-feed-links'); //Enables post and comment RSS feed links to head.
	add_theme_support('widgets'); //Add widgets and sidebar support
	add_theme_support( "title-tag" );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	/** Register wp_nav_menus */
	if(function_exists('register_nav_menu'))
	{
		register_nav_menus(
			array(
				/** Register Main Menu location header */
				'main_menu' => esc_html__('Main Menu', 'pickton'),
				'footer_menu' => esc_html__('Footer Menu', 'pickton'),
			)
		);
	}
	if ( ! isset( $content_width ) ) $content_width = 960;
	add_image_size( 'pickton_370x220', 370, 220, true ); // 'pickton_370x220 Welcome Services'
	add_image_size( 'pickton_570x250', 570, 250, true ); // 'pickton_570x250 Latest Projects'
	add_image_size( 'pickton_270x250', 270, 250, true ); // 'pickton_270x250 Latest Projects'
	add_image_size( 'pickton_80x80', 80, 80, true ); // 'pickton_80x80 Our Testimonials'
	add_image_size( 'pickton_270x235', 270, 235, true ); // 'pickton_270x235 Our Team'
	add_image_size( 'pickton_370x275', 370, 275, true ); // 'pickton_370x275 Our Team'
	add_image_size( 'pickton_85x85', 85, 85, true ); // 'pickton_85x85 Our Testimonials 2'
	add_image_size( 'pickton_370x210', 370, 210, true ); // 'pickton_370x210 Blog Grid View'
	add_image_size( 'pickton_1170x420', 1170, 420, true ); // 'pickton_1170x420 Our Blog'
	add_image_size( 'pickton_90x90', 90, 90, true ); // 'pickton_90x90 Popular Post Widget'
	add_image_size( 'pickton_67x64', 67, 64, true ); // 'pickton_67x64 Team Widget'
	add_image_size( 'pickton_1170x570', 1170, 570, true ); // 'pickton_1170x570 Project Single'
}

function pickton_gutenberg_editor_palette_styles() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'strong yellow', 'pickton' ),
            'slug' => 'strong-yellow',
            'color' => '#f7bd00',
        ),
        array(
            'name' => esc_html__( 'strong white', 'pickton' ),
            'slug' => 'strong-white',
            'color' => '#fff',
        ),
		array(
            'name' => esc_html__( 'light black', 'pickton' ),
            'slug' => 'light-black',
            'color' => '#242424',
        ),
        array(
            'name' => esc_html__( 'very light gray', 'pickton' ),
            'slug' => 'very-light-gray',
            'color' => '#797979',
        ),
        array(
            'name' => esc_html__( 'very dark black', 'pickton' ),
            'slug' => 'very-dark-black',
            'color' => '#000000',
        ),
    ) );
	
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => esc_html__( 'Small', 'pickton' ),
			'size' => 10,
			'slug' => 'small'
		),
		array(
			'name' => esc_html__( 'Normal', 'pickton' ),
			'size' => 15,
			'slug' => 'normal'
		),
		array(
			'name' => esc_html__( 'Large', 'pickton' ),
			'size' => 24,
			'slug' => 'large'
		),
		array(
			'name' => esc_html__( 'Huge', 'pickton' ),
			'size' => 36,
			'slug' => 'huge'
		)
	) );
	
}
add_action( 'after_setup_theme', 'pickton_gutenberg_editor_palette_styles' );

function pickton_bunch_widget_init()
{
	global $wp_registered_sidebars;
	$theme_options = _WSH()->option();
	register_sidebar(array(
	  'name' => esc_html__( 'Default Sidebar', 'pickton' ),
	  'id' => 'default-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'pickton' ),
	  'before_widget'=>'<div id="%1$s" class="widget sidebar-widget %2$s">',
	  'after_widget'=>'</div>',
	  'before_title' => '<div class="sidebar-title"><h2>',
	  'after_title' => '</h2></div>'
	));
	register_sidebar(array(
	  'name' => esc_html__( 'Footer Sidebar', 'pickton' ),
	  'id' => 'footer-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown in Footer Area.', 'pickton' ),
	  'before_widget'=>'<div class="footer-column col-md-4 col-sm-6 col-xs-12"><div id="%1$s"  class="footer-widget %2$s">',
	  'after_widget'=>'</div></div>',
	  'before_title' => '<h2>',
	  'after_title' => '</h2>'
	));
	
	register_sidebar(array(
	  'name' => esc_html__( 'Blog Listing', 'pickton' ),
	  'id' => 'blog-sidebar',
	  'description' => esc_html__( 'Widgets in this area will be shown on the right-hand side.', 'pickton' ),
	  'before_widget'=>'<div id="%1$s" class="widget sidebar-widget %2$s">',
	  'after_widget'=>'</div>',
	  'before_title' => '<div class="sidebar-title"><h2>',
	  'after_title' => '</h2></div>'
	));
	if( !is_object( _WSH() )  )  return;
	$sidebars = pickton_set(pickton_set( $theme_options, 'dynamic_sidebar' ) , 'dynamic_sidebar' ); 
	foreach( array_filter((array)$sidebars) as $sidebar)
	{
		if(pickton_set($sidebar , 'topcopy')) continue ;
		
		$name = pickton_set( $sidebar, 'sidebar_name' );
		
		if( ! $name ) continue;
		$slug = pickton_bunch_slug( $name ) ;
		
		register_sidebar( array(
			'name' => $name,
			'id' =>  sanitize_title( $slug ) ,
			'before_widget' => '<div id="%1$s" class="side-bar widget sidebar-widget %2$s">',
			'after_widget' => "</div>",
			'before_title' => '<div class="sidebar-title"><h2>',
			'after_title' => '</h2></div>',
		) );		
	}
	
	update_option('wp_registered_sidebars' , $wp_registered_sidebars) ;
}
add_action( 'widgets_init', 'pickton_bunch_widget_init' );
// Update items in cart via AJAX
function pickton_load_head_scripts() {
	$options = _WSH()->option();
    if ( !is_admin() ) {
		$protocol = is_ssl() ? 'https://' : 'http://';
		if( pickton_set($options, 'map_api_key') ){
		$map_path = '?key='.pickton_set($options, 'map_api_key');
		wp_enqueue_script( 'pickton-map-api', ''.$protocol.'maps.google.com/maps/api/js'.$map_path, array(), false, false );}
	}
}
add_action( 'wp_enqueue_scripts', 'pickton_load_head_scripts' );
//global variables
function pickton_bunch_global_variable() {
    global $wp_query;
}

function pickton_enqueue_scripts() {
    //styles
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/css/owl.css' );
	wp_enqueue_style( 'jquery-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css' );
	wp_enqueue_style( 'hover', get_template_directory_uri() . '/css/hover.css' );
	wp_enqueue_style( 'gui', get_template_directory_uri() . '/css/gui.css' );
	wp_enqueue_style( 'jquery-bootstrap-touchspin', get_template_directory_uri() . '/css/jquery.bootstrap-touchspin.css' );
	wp_enqueue_style( 'default-theme', get_template_directory_uri() . '/css/color-themes/default-theme.css' );
	wp_enqueue_style( 'pickton-main-style', get_stylesheet_uri() );
	wp_enqueue_style( 'pickton-custom-style', get_template_directory_uri() . '/css/custom.css' );
	wp_enqueue_style( 'pickton-gutenberg', get_template_directory_uri() . '/css/gutenberg.css' );
	wp_enqueue_style( 'pickton-responsive', get_template_directory_uri() . '/css/responsive.css' );
	if(class_exists('woocommerce')) wp_enqueue_style( 'pickton_woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	
    //scripts
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array(), false, true );
	wp_enqueue_script( 'jquery-fancybox-pack', get_template_directory_uri().'/js/jquery.fancybox.pack.js', array('jquery'), '2.1.2', true );
	wp_enqueue_script( 'jquery-fancybox-media', get_template_directory_uri().'/js/jquery.fancybox-media.js', array('jquery'), '2.1.2', true );
	wp_enqueue_script( 'owl', get_template_directory_uri().'/js/owl.js', array(), false, true );
	wp_enqueue_script( 'appear', get_template_directory_uri().'/js/appear.js', array(), false, true );
	wp_enqueue_script( 'wow', get_template_directory_uri().'/js/wow.js', array(), false, true );
	wp_enqueue_script( 'isotope', get_template_directory_uri().'/js/isotope.js', array(), false, true );
	wp_enqueue_script( 'mixitup', get_template_directory_uri().'/js/mixitup.js', array(), false, true );
    wp_enqueue_script( 'custom-ui', get_template_directory_uri().'/js/custom-ui.js', array(), false, true );
	wp_enqueue_script( 'map-script', get_template_directory_uri().'/js/map-script.js', array(), false, true );
	wp_enqueue_script( 'pickton-main-script', get_template_directory_uri().'/js/script.js', array(), false, true );
	if( is_singular() ) wp_enqueue_script('comment-reply');
	
}
add_action( 'wp_enqueue_scripts', 'pickton_enqueue_scripts' );

/*-------------------------------------------------------------*/
function pickton_theme_slug_fonts_url() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $hind = _x( 'on', 'Hind font: on or off', 'pickton' );
	$poppins = _x( 'on', 'Poppins font: on or off', 'pickton' );
	
    if ( 'off' !== $hind || 'off' !== $poppins ) {
        $font_families = array();
 
        if ( 'off' !== $hind ) {
            $font_families[] = 'Hind:300,400,500,600,700';
        }
		
		if ( 'off' !== $poppins ) {
            $font_families[] = 'Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
        }
		
        $opt = get_option('pickton'.'_theme_options');
		if ( pickton_set( $opt, 'body_custom_font' ) ) {
			if ( $custom_font = pickton_set( $opt, 'body_font_family' ) )
				$font_families[] = $custom_font . ':300,300i,400,400i,600,700';
		}
		if ( pickton_set( $opt, 'use_custom_font' ) ) {
			$font_families[] = pickton_set( $opt, 'h1_font_family' ) . ':300,300i,400,400i,600,700';
			$font_families[] = pickton_set( $opt, 'h2_font_family' ) . ':300,300i,400,400i,600,700';
			$font_families[] = pickton_set( $opt, 'h3_font_family' ) . ':300,300i,400,400i,600,700';
			$font_families[] = pickton_set( $opt, 'h4_font_family' ) . ':300,300i,400,400i,600,700';
			$font_families[] = pickton_set( $opt, 'h5_font_family' ) . ':300,300i,400,400i,600,700';
			$font_families[] = pickton_set( $opt, 'h6_font_family' ) . ':300,300i,400,400i,600,700';
		}
		$font_families = array_unique( $font_families);
        
		$query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}
function pickton_theme_slug_scripts_styles() {
    wp_enqueue_style( 'pickton-theme-slug-fonts', pickton_theme_slug_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'pickton_theme_slug_scripts_styles' );
/*---------------------------------------------------------------------*/
function pickton_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'pickton_add_editor_styles' );
/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 
function pickton_woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'pickton_jk_related_products_args' );
  function pickton_jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}