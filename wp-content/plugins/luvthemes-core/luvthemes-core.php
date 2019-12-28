<?php
/**
 * Plugin Name: Luvthemes Core
 * Plugin URI: http://luvthemes.com
 * Description: Luvthemes core functions
 * Version: 1.2.4
 * Author: Luvthemes
 * Author URI: http://luvthemes.com
 **/

class Luvthemes_Core {

	public $localize = array(
		'backend' => array(),
		'frontend' => array()
	);

	/**
	 * Create Luvthemes Core object
	 */
	public function __construct() {
		global $luv_dynamic_inline_css;

		load_theme_textdomain( 'fevr', trailingslashit(get_template_directory()) . 'languages');


		// Define plugin url
		if (!defined('LUVTHEMES_CORE_URI')){
			define('LUVTHEMES_CORE_URI', plugins_url('', __FILE__) . '/');
		}

		// Define plugin url
		if (!defined('LUVTHEMES_CORE_PATH')){
			define('LUVTHEMES_CORE_PATH',  plugin_dir_path( __FILE__ ) . '/');
		}

		// Define version constant
		if (!defined('LUVTHEMES_CORE_VER')){
			define('LUVTHEMES_CORE_VER', '1.2.4');
		}

		// Dynamic inline CSS
		require_once LUVTHEMES_CORE_PATH . 'includes/dynamic-inline-css.inc.php';
		$luv_dynamic_inline_css = new LuvDynamicInlineCSS();

		// Performance module
		require_once  LUVTHEMES_CORE_PATH . '/includes/performance/performance.php';
		new Fevr_Performance();

		// Load the redux framework
		require_once LUVTHEMES_CORE_PATH . '/includes/framework/framework.php';

		// Load the redux framework config
		require_once LUVTHEMES_CORE_PATH . '/includes/framework/framework-config.php';

		// Redux Icon Select field
		add_filter( "redux/fevr_options/field/class/icon_select", array($this, "redux_icon_select_field_path")); // Adds the local field

		// Conditional Post Types
		add_action('init',array($this, 'create_conditional_post_types'));

		// Init meta fields
		add_action('init',array($this, 'init_meta_fields'));

		// Custom Post Types
		require_once LUVTHEMES_CORE_PATH . 'includes/post-types.inc.php';

		// Custom Taxonomies
		require_once LUVTHEMES_CORE_PATH . 'includes/taxonomies.inc.php';

		// Register Post Types
		add_action('init', array($this, 'register_post_types'));

		// Register Taxonomies
		add_action('init', array($this, 'register_taxonomies'));

		// Get Plugin's settings
		add_action('init',array($this, 'get_settings'),0);

		// Initialize Widgets
		add_action('init', array($this, 'widget_init'), 0);

		// Load shortcodes
		include_once LUVTHEMES_CORE_PATH . 'includes/shortcodes.inc.php';
		$this->Luv_Shortcode = new Luvthemes_Shortcodes($this);

		// Load iconsets
		include_once LUVTHEMES_CORE_PATH . 'includes/iconset.inc.php';

		// WC shortcode overwrites
		add_action('woocommerce_loaded', array($this, 'init_wc_shortcodes'));

		// Register scripts for theme
		add_action('wp_enqueue_scripts', array($this, 'register_frontend_scripts'),0);
		add_action('fevr_ajax_scripts', array($this, 'register_frontend_scripts'),0);

		// Enqueue JS and CSS
		add_action('admin_enqueue_scripts',array($this, 'enqueue_backend_scripts'));
		add_action('vc_backend_editor_render',array($this, 'enqueue_backend_scripts'));
		add_action('wp_enqueue_scripts',array($this, 'enqueue_frontend_scripts'),11);

		// Init fonts
		add_action('init',array($this, 'init_fonts'),0);

		//Add the button to editors
		add_filter('media_buttons_context', array($this, 'shortcode_generator_button'));

		// Add luv shortcode container to wp admin footer
		add_action('admin_footer', array($this, 'add_shortcode_generator_container'));

		//Ajax handler for load shortcode
		add_action('wp_ajax_load_luv_shortcode_generator_fields', array($this, 'load_shortcode_generator_fields'));

		// Load font variants
		add_action('wp_ajax_luv_font_variants', array($this, 'get_font_variants'));

		// Coming soon mode
		add_action('template_redirect', array($this, 'coming_soon'));

		// Custom login page
		add_action('init', array($this, 'custom_login_page'));

	}

	/**
	 * Initialize widgets
	 * All widget related files are located in luvthemes/widgets/
	 */
	public function widget_init(){
		//Flickr
		if (_check_luvoption('flickr-widget', 1)){
			require_once LUVTHEMES_CORE_PATH . 'widgets/flickr/widget.php';
		}

		//Twitter
		if (_check_luvoption('twitter-widget', 1)){
			require_once LUVTHEMES_CORE_PATH . 'widgets/twitter/widget.php';
		}

		//Instagram
		if (_check_luvoption('instagram-widget', 1)){
			require_once LUVTHEMES_CORE_PATH . 'widgets/instagram/widget.php';
		}

		//Text Box with Shortcode
		if (_check_luvoption('shortcode-widget', 1)){
			require_once LUVTHEMES_CORE_PATH . 'widgets/shortcode/widget.php';
		}
	}


	/**
	 * Include conditional post types
	 * CONDITIONS
	 * WooCommerce: collections, photo reviews
	 */
	public function create_conditional_post_types(){
		global $fevr_options;

		// Photo Reviews
		if(class_exists('woocommerce') && isset($fevr_options['woocommerce-photo-reviews']) && $fevr_options['woocommerce-photo-reviews'] == 1) {
			require_once LUVTHEMES_CORE_PATH . 'includes/meta/reviews-meta.php';
		}

		// Collections
		if(class_exists('woocommerce') && isset($fevr_options['woocommerce-collections']) && $fevr_options['woocommerce-collections'] == 1) {
			require_once LUVTHEMES_CORE_PATH . 'includes/meta/collection-meta.php';
		}
	}

	/**
	 * Include meta fields for backend editor
	 */
	public function init_meta_fields(){
		require_once LUVTHEMES_CORE_PATH . 'includes/meta/functions.php';
		require_once LUVTHEMES_CORE_PATH . 'includes/meta/post-meta.php';
		require_once LUVTHEMES_CORE_PATH . 'includes/meta/slider-meta.php';
		require_once LUVTHEMES_CORE_PATH . 'includes/meta/header-meta.php';
	}

	/**
	 * Register custom post types
	 * 		- Collections
	 * 		- Photo reviews
	 * 		- Portfolio
	 * 		- Snippets
	 * 		- Slider
	 */
	public function register_post_types() {
		global $luv_post_types;
		global $fevr_options;

		foreach($luv_post_types as $post_type) {

			// Skip collections post type if it isn't enabled in redux
			if($post_type['name'] == 'luv_collections' && (!class_exists('woocommerce') || !isset($fevr_options['woocommerce-collections']) || $fevr_options['woocommerce-collections'] != 1)) {
				continue;
			}

			// Skip photo reviews post type if it isn't enabled in redux
			if($post_type['name'] == 'luv_ext_reviews' && (!class_exists('woocommerce') || !isset($fevr_options['woocommerce-photo-reviews']) || $fevr_options['woocommerce-photo-reviews'] != 1)) {
				continue;
			}

			// Skip portfolio if it isn't enabled in redux
			if($post_type['name'] == 'luv_portfolio' && (!isset($fevr_options['module-portfolio']) || $fevr_options['module-portfolio'] != 1)) {
				continue;
			}

			// Skip snippets if it isn't enabled in redux
			if($post_type['name'] == 'luv_snippets' && (!isset($fevr_options['module-snippets']) || $fevr_options['module-snippets'] != 1)) {
				continue;
			}

			// Skip sliders if it isn't enabled in redux
			if($post_type['name'] == 'luv_slider' && (!isset($fevr_options['module-sliders']) || $fevr_options['module-sliders'] != 1)) {
				continue;
			}

			register_post_type( $post_type['name'], $post_type['args'] );
		}
	}

	/**
	 * Register taxonomies
	 * Taxonomies are defined in luvthemes/includes/taxonomies.inc.php
	 */
	public function register_taxonomies() {
		global $luv_taxonomies;

		foreach($luv_taxonomies as $taxonomy) {
			register_taxonomy( $taxonomy['name'], $taxonomy['post_type'], $taxonomy['args'] );
		}
	}

	/**
	 * Enqueue scripts and styles on backend
	 */
	public function enqueue_backend_scripts(){
		if (doing_action('admin_enqueue_scripts')){
			wp_enqueue_script('luvthemes-core', LUVTHEMES_CORE_URI . 'assets/js/admin.js', array('jquery'), LUVTHEMES_CORE_VER);
			wp_localize_script('luvthemes-core', 'luvthemes_core', $this->localize['backend']);
			wp_enqueue_style('luvthemes-core', LUVTHEMES_CORE_URI . 'assets/css/admin.css', array(), LUVTHEMES_CORE_VER);
			wp_deregister_style( 'font-awesome' );
			wp_enqueue_style('font-awesome', LUVTHEMES_CORE_URI . 'assets/css/font-awesome.min.css', array(), LUVTHEMES_CORE_VER);
			wp_enqueue_style('ionicons', LUVTHEMES_CORE_URI . 'assets/css/ionicons.min.css', array(), LUVTHEMES_CORE_VER);
			wp_enqueue_style('linea-icons', LUVTHEMES_CORE_URI . 'assets/css/linea-icons.css', array(), LUVTHEMES_CORE_VER);
		}
		else{
			wp_enqueue_script('luvthemes-coreviews', LUVTHEMES_CORE_URI . 'assets/js/vc-views.js', array('vc-backend-min-js'), LUVTHEMES_CORE_VER, true);
		}
	}

	/**
	 * Register frontend scripts
	 */
	public function register_frontend_scripts(){
		// Enqueue tilt.js if perspective hover animation is in use
		if(_check_luvoption('blog-masonry-hover-style', 'masonry-perspective') || _check_luvoption('portfolio-masonry-hover-style', 'masonry-perspective') || _check_luvoption('woocommerce-collections-masonry-hover-style', 'masonry-perspective')) {
			wp_enqueue_script('tilt', LUVTHEMES_CORE_URI.'assets/js/min/tilt-min.js', array(), LUVTHEMES_CORE_VER);
		}

		// Register Owl carousel
		wp_register_script( 'fevr-owlcarousel', LUVTHEMES_CORE_URI . 'assets/js/min/owl.carousel.min.js', array('jquery'), LUVTHEMES_CORE_VER, true );
	}

	/**
	 * Enqueue scripts and styles on frontend
	 */
	public function enqueue_frontend_scripts(){
		wp_enqueue_script('luvthemes-core', LUVTHEMES_CORE_URI . 'assets/js/min/core-min.js', array('jquery'), LUVTHEMES_CORE_VER, true);
		wp_localize_script('luvthemes-core', 'luvthemes_core', $this->localize['frontend']);
		wp_deregister_style( 'font-awesome' );
		if (_check_luvoption('smart-iconset-enqueue', 1, '!=')){
			wp_enqueue_style('font-awesome', LUVTHEMES_CORE_URI . 'assets/css/font-awesome.min.css', array(), LUVTHEMES_CORE_VER);
		}

		if ((function_exists('is_woocommerce') && is_woocommerce()) || luv_is_pajax()){
			wp_enqueue_script( 'fevr-owlcarousel' );
		}

		// Enqueue tilt.js if perspective hover animation is in use
		if(is_archive() && (_check_luvoption('blog-masonry-hover-style', 'masonry-perspective') || _check_luvoption('portfolio-masonry-hover-style', 'masonry-perspective') || _check_luvoption('woocommerce-collections-masonry-hover-style', 'masonry-perspective'))) {
			wp_enqueue_script('tilt', LUVTHEMES_CORE_URI.'assets/js/min/tilt-min.js', array(), LUVTHEMES_CORE_VER);
		}
	}

	/**
	 * Get the settings and merge them the default settings array
	 */
	public function get_settings(){
		// Get permalink
		$permalink = get_the_permalink();
		if (empty($permalink)){
			$permalink = 'http://' . (isset($_SERVER['HTTPS']) ? 's' : '') . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}

		// Localize script
		$locale = explode('_',get_locale());
		$this->localize =  array(
				'backend' => array(
						'i18n' => array(
								'Upload' => esc_html__('Upload', 'fevr'),
								'Modify' => esc_html__('Modify', 'fevr'),
								'Default' => esc_html__('Default', 'fevr'),
                'Current settings will be overwritten. Do you continue?' => esc_html__('Current settings will be overwritten. Do you continue?', 'fevr'),
						),
						'nonce' => wp_create_nonce('luv')
				),
				'frontend' => array(
						'ajax_url' => admin_url('admin-ajax.php'),
						'i18n' => array(
								'Years' => esc_html__('Years', 'fevr'),
								'Months' => esc_html__('Months', 'fevr'),
								'Days' => esc_html__('Days', 'fevr'),
								'Hours' => esc_html__('Hours', 'fevr'),
								'Minutes' => esc_html__('Minutes', 'fevr'),
								'Seconds' => esc_html__('Seconds', 'fevr'),
								'Successfull login' => esc_html__('Successfull login', 'fevr'),
								'Logout' => esc_html__('Logout', 'fevr'),
								'Unknown error' => esc_html__('Unknown error', 'fevr'),
						),
						'google_maps_api_key' => _get_luvoption('google-maps-api-key'),
						'google_maps_libraries' => apply_filters('luv_google_maps_libraries', ''),
						'locale_language' => esc_attr(urlencode($locale[0])),
						'locale_region' => esc_attr(urlencode($locale[1])),
						'google_maps_cluster_path' => apply_filters('luv_google_maps_cluster_path', LUVTHEMES_CORE_URI . 'images/clusters/m')
				)
		);

	}

	/**
	 * Icon select field for Redux
	 */
	public function redux_icon_select_field_path($field){
		return LUVTHEMES_CORE_PATH . 'includes/framework-extensions/field_icon_select.php';
	}

	/**
	 * Init font arrays
	 */
	public function init_fonts(){
		global $fevr_vc_font_family_list;

		$fevr_vc_font_family_list = array('Default' => '');
		$fonts = json_decode('[{"font-family":"font-family: \'ABeeZee\'","font-name":"ABeeZee"},{"font-family":"font-family: \'Abel\'","font-name":"Abel"},{"font-family":"font-family: \'Abril Fatface\'","font-name":"Abril Fatface"},{"font-family":"font-family: \'Aclonica\'","font-name":"Aclonica"},{"font-family":"font-family: \'Acme\'","font-name":"Acme"},{"font-family":"font-family: \'Actor\'","font-name":"Actor"},{"font-family":"font-family: \'Adamina\'","font-name":"Adamina"},{"font-family":"font-family: \'Advent Pro\'","font-name":"Advent Pro"},{"font-family":"font-family: \'Aguafina Script\'","font-name":"Aguafina Script"},{"font-family":"font-family: \'Akronim\'","font-name":"Akronim"},{"font-family":"font-family: \'Aladin\'","font-name":"Aladin"},{"font-family":"font-family: \'Aldrich\'","font-name":"Aldrich"},{"font-family":"font-family: \'Alef\'","font-name":"Alef"},{"font-family":"font-family: \'Alegreya\'","font-name":"Alegreya"},{"font-family":"font-family: \'Alegreya SC\'","font-name":"Alegreya SC"},{"font-family":"font-family: \'Alegreya Sans\'","font-name":"Alegreya Sans"},{"font-family":"font-family: \'Alegreya Sans SC\'","font-name":"Alegreya Sans SC"},{"font-family":"font-family: \'Alex Brush\'","font-name":"Alex Brush"},{"font-family":"font-family: \'Alfa Slab One\'","font-name":"Alfa Slab One"},{"font-family":"font-family: \'Alice\'","font-name":"Alice"},{"font-family":"font-family: \'Alike\'","font-name":"Alike"},{"font-family":"font-family: \'Alike Angular\'","font-name":"Alike Angular"},{"font-family":"font-family: \'Allan\'","font-name":"Allan"},{"font-family":"font-family: \'Allerta\'","font-name":"Allerta"},{"font-family":"font-family: \'Allerta Stencil\'","font-name":"Allerta Stencil"},{"font-family":"font-family: \'Allura\'","font-name":"Allura"},{"font-family":"font-family: \'Almendra\'","font-name":"Almendra"},{"font-family":"font-family: \'Almendra Display\'","font-name":"Almendra Display"},{"font-family":"font-family: \'Almendra SC\'","font-name":"Almendra SC"},{"font-family":"font-family: \'Amarante\'","font-name":"Amarante"},{"font-family":"font-family: \'Amaranth\'","font-name":"Amaranth"},{"font-family":"font-family: \'Amatic SC\'","font-name":"Amatic SC"},{"font-family":"font-family: \'Amethysta\'","font-name":"Amethysta"},{"font-family":"font-family: \'Amiri\'","font-name":"Amiri"},{"font-family":"font-family: \'Amita\'","font-name":"Amita"},{"font-family":"font-family: \'Anaheim\'","font-name":"Anaheim"},{"font-family":"font-family: \'Andada\'","font-name":"Andada"},{"font-family":"font-family: \'Andika\'","font-name":"Andika"},{"font-family":"font-family: \'Angkor\'","font-name":"Angkor"},{"font-family":"font-family: \'Annie Use Your Telescope\'","font-name":"Annie Use Your Telescope"},{"font-family":"font-family: \'Anonymous Pro\'","font-name":"Anonymous Pro"},{"font-family":"font-family: \'Antic\'","font-name":"Antic"},{"font-family":"font-family: \'Antic Didone\'","font-name":"Antic Didone"},{"font-family":"font-family: \'Antic Slab\'","font-name":"Antic Slab"},{"font-family":"font-family: \'Anton\'","font-name":"Anton"},{"font-family":"font-family: \'Arapey\'","font-name":"Arapey"},{"font-family":"font-family: \'Arbutus\'","font-name":"Arbutus"},{"font-family":"font-family: \'Arbutus Slab\'","font-name":"Arbutus Slab"},{"font-family":"font-family: \'Architects Daughter\'","font-name":"Architects Daughter"},{"font-family":"font-family: \'Archivo Black\'","font-name":"Archivo Black"},{"font-family":"font-family: \'Archivo Narrow\'","font-name":"Archivo Narrow"},{"font-family":"font-family: \'Arimo\'","font-name":"Arimo"},{"font-family":"font-family: \'Arizonia\'","font-name":"Arizonia"},{"font-family":"font-family: \'Armata\'","font-name":"Armata"},{"font-family":"font-family: \'Artifika\'","font-name":"Artifika"},{"font-family":"font-family: \'Arvo\'","font-name":"Arvo"},{"font-family":"font-family: \'Arya\'","font-name":"Arya"},{"font-family":"font-family: \'Asap\'","font-name":"Asap"},{"font-family":"font-family: \'Asar\'","font-name":"Asar"},{"font-family":"font-family: \'Asset\'","font-name":"Asset"},{"font-family":"font-family: \'Astloch\'","font-name":"Astloch"},{"font-family":"font-family: \'Asul\'","font-name":"Asul"},{"font-family":"font-family: \'Atomic Age\'","font-name":"Atomic Age"},{"font-family":"font-family: \'Aubrey\'","font-name":"Aubrey"},{"font-family":"font-family: \'Audiowide\'","font-name":"Audiowide"},{"font-family":"font-family: \'Autour One\'","font-name":"Autour One"},{"font-family":"font-family: \'Average\'","font-name":"Average"},{"font-family":"font-family: \'Average Sans\'","font-name":"Average Sans"},{"font-family":"font-family: \'Averia Gruesa Libre\'","font-name":"Averia Gruesa Libre"},{"font-family":"font-family: \'Averia Libre\'","font-name":"Averia Libre"},{"font-family":"font-family: \'Averia Sans Libre\'","font-name":"Averia Sans Libre"},{"font-family":"font-family: \'Averia Serif Libre\'","font-name":"Averia Serif Libre"},{"font-family":"font-family: \'Bad Script\'","font-name":"Bad Script"},{"font-family":"font-family: \'Balthazar\'","font-name":"Balthazar"},{"font-family":"font-family: \'Bangers\'","font-name":"Bangers"},{"font-family":"font-family: \'Basic\'","font-name":"Basic"},{"font-family":"font-family: \'Battambang\'","font-name":"Battambang"},{"font-family":"font-family: \'Baumans\'","font-name":"Baumans"},{"font-family":"font-family: \'Bayon\'","font-name":"Bayon"},{"font-family":"font-family: \'Belgrano\'","font-name":"Belgrano"},{"font-family":"font-family: \'Belleza\'","font-name":"Belleza"},{"font-family":"font-family: \'BenchNine\'","font-name":"BenchNine"},{"font-family":"font-family: \'Bentham\'","font-name":"Bentham"},{"font-family":"font-family: \'Berkshire Swash\'","font-name":"Berkshire Swash"},{"font-family":"font-family: \'Bevan\'","font-name":"Bevan"},{"font-family":"font-family: \'Bigelow Rules\'","font-name":"Bigelow Rules"},{"font-family":"font-family: \'Bigshot One\'","font-name":"Bigshot One"},{"font-family":"font-family: \'Bilbo\'","font-name":"Bilbo"},{"font-family":"font-family: \'Bilbo Swash Caps\'","font-name":"Bilbo Swash Caps"},{"font-family":"font-family: \'Biryani\'","font-name":"Biryani"},{"font-family":"font-family: \'Bitter\'","font-name":"Bitter"},{"font-family":"font-family: \'Black Ops One\'","font-name":"Black Ops One"},{"font-family":"font-family: \'Bokor\'","font-name":"Bokor"},{"font-family":"font-family: \'Bonbon\'","font-name":"Bonbon"},{"font-family":"font-family: \'Boogaloo\'","font-name":"Boogaloo"},{"font-family":"font-family: \'Bowlby One\'","font-name":"Bowlby One"},{"font-family":"font-family: \'Bowlby One SC\'","font-name":"Bowlby One SC"},{"font-family":"font-family: \'Brawler\'","font-name":"Brawler"},{"font-family":"font-family: \'Bree Serif\'","font-name":"Bree Serif"},{"font-family":"font-family: \'Bubblegum Sans\'","font-name":"Bubblegum Sans"},{"font-family":"font-family: \'Bubbler One\'","font-name":"Bubbler One"},{"font-family":"font-family: \'Buda\'","font-name":"Buda"},{"font-family":"font-family: \'Buenard\'","font-name":"Buenard"},{"font-family":"font-family: \'Butcherman\'","font-name":"Butcherman"},{"font-family":"font-family: \'Butterfly Kids\'","font-name":"Butterfly Kids"},{"font-family":"font-family: \'Cabin\'","font-name":"Cabin"},{"font-family":"font-family: \'Cabin Condensed\'","font-name":"Cabin Condensed"},{"font-family":"font-family: \'Cabin Sketch\'","font-name":"Cabin Sketch"},{"font-family":"font-family: \'Caesar Dressing\'","font-name":"Caesar Dressing"},{"font-family":"font-family: \'Cagliostro\'","font-name":"Cagliostro"},{"font-family":"font-family: \'Calligraffitti\'","font-name":"Calligraffitti"},{"font-family":"font-family: \'Cambay\'","font-name":"Cambay"},{"font-family":"font-family: \'Cambo\'","font-name":"Cambo"},{"font-family":"font-family: \'Candal\'","font-name":"Candal"},{"font-family":"font-family: \'Cantarell\'","font-name":"Cantarell"},{"font-family":"font-family: \'Cantata One\'","font-name":"Cantata One"},{"font-family":"font-family: \'Cantora One\'","font-name":"Cantora One"},{"font-family":"font-family: \'Capriola\'","font-name":"Capriola"},{"font-family":"font-family: \'Cardo\'","font-name":"Cardo"},{"font-family":"font-family: \'Carme\'","font-name":"Carme"},{"font-family":"font-family: \'Carrois Gothic\'","font-name":"Carrois Gothic"},{"font-family":"font-family: \'Carrois Gothic SC\'","font-name":"Carrois Gothic SC"},{"font-family":"font-family: \'Carter One\'","font-name":"Carter One"},{"font-family":"font-family: \'Catamaran\'","font-name":"Catamaran"},{"font-family":"font-family: \'Caudex\'","font-name":"Caudex"},{"font-family":"font-family: \'Caveat\'","font-name":"Caveat"},{"font-family":"font-family: \'Caveat Brush\'","font-name":"Caveat Brush"},{"font-family":"font-family: \'Cedarville Cursive\'","font-name":"Cedarville Cursive"},{"font-family":"font-family: \'Ceviche One\'","font-name":"Ceviche One"},{"font-family":"font-family: \'Changa One\'","font-name":"Changa One"},{"font-family":"font-family: \'Chango\'","font-name":"Chango"},{"font-family":"font-family: \'Chau Philomene One\'","font-name":"Chau Philomene One"},{"font-family":"font-family: \'Chela One\'","font-name":"Chela One"},{"font-family":"font-family: \'Chelsea Market\'","font-name":"Chelsea Market"},{"font-family":"font-family: \'Chenla\'","font-name":"Chenla"},{"font-family":"font-family: \'Cherry Cream Soda\'","font-name":"Cherry Cream Soda"},{"font-family":"font-family: \'Cherry Swash\'","font-name":"Cherry Swash"},{"font-family":"font-family: \'Chewy\'","font-name":"Chewy"},{"font-family":"font-family: \'Chicle\'","font-name":"Chicle"},{"font-family":"font-family: \'Chivo\'","font-name":"Chivo"},{"font-family":"font-family: \'Chonburi\'","font-name":"Chonburi"},{"font-family":"font-family: \'Cinzel\'","font-name":"Cinzel"},{"font-family":"font-family: \'Cinzel Decorative\'","font-name":"Cinzel Decorative"},{"font-family":"font-family: \'Clicker Script\'","font-name":"Clicker Script"},{"font-family":"font-family: \'Coda\'","font-name":"Coda"},{"font-family":"font-family: \'Coda Caption\'","font-name":"Coda Caption"},{"font-family":"font-family: \'Codystar\'","font-name":"Codystar"},{"font-family":"font-family: \'Combo\'","font-name":"Combo"},{"font-family":"font-family: \'Comfortaa\'","font-name":"Comfortaa"},{"font-family":"font-family: \'Coming Soon\'","font-name":"Coming Soon"},{"font-family":"font-family: \'Concert One\'","font-name":"Concert One"},{"font-family":"font-family: \'Condiment\'","font-name":"Condiment"},{"font-family":"font-family: \'Content\'","font-name":"Content"},{"font-family":"font-family: \'Contrail One\'","font-name":"Contrail One"},{"font-family":"font-family: \'Convergence\'","font-name":"Convergence"},{"font-family":"font-family: \'Cookie\'","font-name":"Cookie"},{"font-family":"font-family: \'Copse\'","font-name":"Copse"},{"font-family":"font-family: \'Corben\'","font-name":"Corben"},{"font-family":"font-family: \'Courgette\'","font-name":"Courgette"},{"font-family":"font-family: \'Cousine\'","font-name":"Cousine"},{"font-family":"font-family: \'Coustard\'","font-name":"Coustard"},{"font-family":"font-family: \'Covered By Your Grace\'","font-name":"Covered By Your Grace"},{"font-family":"font-family: \'Crafty Girls\'","font-name":"Crafty Girls"},{"font-family":"font-family: \'Creepster\'","font-name":"Creepster"},{"font-family":"font-family: \'Crete Round\'","font-name":"Crete Round"},{"font-family":"font-family: \'Crimson Text\'","font-name":"Crimson Text"},{"font-family":"font-family: \'Croissant One\'","font-name":"Croissant One"},{"font-family":"font-family: \'Crushed\'","font-name":"Crushed"},{"font-family":"font-family: \'Cuprum\'","font-name":"Cuprum"},{"font-family":"font-family: \'Cutive\'","font-name":"Cutive"},{"font-family":"font-family: \'Cutive Mono\'","font-name":"Cutive Mono"},{"font-family":"font-family: \'Damion\'","font-name":"Damion"},{"font-family":"font-family: \'Dancing Script\'","font-name":"Dancing Script"},{"font-family":"font-family: \'Dangrek\'","font-name":"Dangrek"},{"font-family":"font-family: \'Dawning of a New Day\'","font-name":"Dawning of a New Day"},{"font-family":"font-family: \'Days One\'","font-name":"Days One"},{"font-family":"font-family: \'Dekko\'","font-name":"Dekko"},{"font-family":"font-family: \'Delius\'","font-name":"Delius"},{"font-family":"font-family: \'Delius Swash Caps\'","font-name":"Delius Swash Caps"},{"font-family":"font-family: \'Delius Unicase\'","font-name":"Delius Unicase"},{"font-family":"font-family: \'Della Respira\'","font-name":"Della Respira"},{"font-family":"font-family: \'Denk One\'","font-name":"Denk One"},{"font-family":"font-family: \'Devonshire\'","font-name":"Devonshire"},{"font-family":"font-family: \'Dhurjati\'","font-name":"Dhurjati"},{"font-family":"font-family: \'Didact Gothic\'","font-name":"Didact Gothic"},{"font-family":"font-family: \'Diplomata\'","font-name":"Diplomata"},{"font-family":"font-family: \'Diplomata SC\'","font-name":"Diplomata SC"},{"font-family":"font-family: \'Domine\'","font-name":"Domine"},{"font-family":"font-family: \'Donegal One\'","font-name":"Donegal One"},{"font-family":"font-family: \'Doppio One\'","font-name":"Doppio One"},{"font-family":"font-family: \'Dorsa\'","font-name":"Dorsa"},{"font-family":"font-family: \'Dosis\'","font-name":"Dosis"},{"font-family":"font-family: \'Dr Sugiyama\'","font-name":"Dr Sugiyama"},{"font-family":"font-family: \'Droid Sans\'","font-name":"Droid Sans"},{"font-family":"font-family: \'Droid Sans Mono\'","font-name":"Droid Sans Mono"},{"font-family":"font-family: \'Droid Serif\'","font-name":"Droid Serif"},{"font-family":"font-family: \'Duru Sans\'","font-name":"Duru Sans"},{"font-family":"font-family: \'Dynalight\'","font-name":"Dynalight"},{"font-family":"font-family: \'EB Garamond\'","font-name":"EB Garamond"},{"font-family":"font-family: \'Eagle Lake\'","font-name":"Eagle Lake"},{"font-family":"font-family: \'Eater\'","font-name":"Eater"},{"font-family":"font-family: \'Economica\'","font-name":"Economica"},{"font-family":"font-family: \'Eczar\'","font-name":"Eczar"},{"font-family":"font-family: \'Ek Mukta\'","font-name":"Ek Mukta"},{"font-family":"font-family: \'Electrolize\'","font-name":"Electrolize"},{"font-family":"font-family: \'Elsie\'","font-name":"Elsie"},{"font-family":"font-family: \'Elsie Swash Caps\'","font-name":"Elsie Swash Caps"},{"font-family":"font-family: \'Emblema One\'","font-name":"Emblema One"},{"font-family":"font-family: \'Emilys Candy\'","font-name":"Emilys Candy"},{"font-family":"font-family: \'Engagement\'","font-name":"Engagement"},{"font-family":"font-family: \'Englebert\'","font-name":"Englebert"},{"font-family":"font-family: \'Enriqueta\'","font-name":"Enriqueta"},{"font-family":"font-family: \'Erica One\'","font-name":"Erica One"},{"font-family":"font-family: \'Esteban\'","font-name":"Esteban"},{"font-family":"font-family: \'Euphoria Script\'","font-name":"Euphoria Script"},{"font-family":"font-family: \'Ewert\'","font-name":"Ewert"},{"font-family":"font-family: \'Exo\'","font-name":"Exo"},{"font-family":"font-family: \'Exo 2\'","font-name":"Exo 2"},{"font-family":"font-family: \'Expletus Sans\'","font-name":"Expletus Sans"},{"font-family":"font-family: \'Fanwood Text\'","font-name":"Fanwood Text"},{"font-family":"font-family: \'Fascinate\'","font-name":"Fascinate"},{"font-family":"font-family: \'Fascinate Inline\'","font-name":"Fascinate Inline"},{"font-family":"font-family: \'Faster One\'","font-name":"Faster One"},{"font-family":"font-family: \'Fasthand\'","font-name":"Fasthand"},{"font-family":"font-family: \'Fauna One\'","font-name":"Fauna One"},{"font-family":"font-family: \'Federant\'","font-name":"Federant"},{"font-family":"font-family: \'Federo\'","font-name":"Federo"},{"font-family":"font-family: \'Felipa\'","font-name":"Felipa"},{"font-family":"font-family: \'Fenix\'","font-name":"Fenix"},{"font-family":"font-family: \'Finger Paint\'","font-name":"Finger Paint"},{"font-family":"font-family: \'Fira Mono\'","font-name":"Fira Mono"},{"font-family":"font-family: \'Fira Sans\'","font-name":"Fira Sans"},{"font-family":"font-family: \'Fjalla One\'","font-name":"Fjalla One"},{"font-family":"font-family: \'Fjord One\'","font-name":"Fjord One"},{"font-family":"font-family: \'Flamenco\'","font-name":"Flamenco"},{"font-family":"font-family: \'Flavors\'","font-name":"Flavors"},{"font-family":"font-family: \'Fondamento\'","font-name":"Fondamento"},{"font-family":"font-family: \'Fontdiner Swanky\'","font-name":"Fontdiner Swanky"},{"font-family":"font-family: \'Forum\'","font-name":"Forum"},{"font-family":"font-family: \'Francois One\'","font-name":"Francois One"},{"font-family":"font-family: \'Freckle Face\'","font-name":"Freckle Face"},{"font-family":"font-family: \'Fredericka the Great\'","font-name":"Fredericka the Great"},{"font-family":"font-family: \'Fredoka One\'","font-name":"Fredoka One"},{"font-family":"font-family: \'Freehand\'","font-name":"Freehand"},{"font-family":"font-family: \'Fresca\'","font-name":"Fresca"},{"font-family":"font-family: \'Frijole\'","font-name":"Frijole"},{"font-family":"font-family: \'Fruktur\'","font-name":"Fruktur"},{"font-family":"font-family: \'Fugaz One\'","font-name":"Fugaz One"},{"font-family":"font-family: \'GFS Didot\'","font-name":"GFS Didot"},{"font-family":"font-family: \'GFS Neohellenic\'","font-name":"GFS Neohellenic"},{"font-family":"font-family: \'Gabriela\'","font-name":"Gabriela"},{"font-family":"font-family: \'Gafata\'","font-name":"Gafata"},{"font-family":"font-family: \'Galdeano\'","font-name":"Galdeano"},{"font-family":"font-family: \'Galindo\'","font-name":"Galindo"},{"font-family":"font-family: \'Gentium Basic\'","font-name":"Gentium Basic"},{"font-family":"font-family: \'Gentium Book Basic\'","font-name":"Gentium Book Basic"},{"font-family":"font-family: \'Geo\'","font-name":"Geo"},{"font-family":"font-family: \'Geostar\'","font-name":"Geostar"},{"font-family":"font-family: \'Geostar Fill\'","font-name":"Geostar Fill"},{"font-family":"font-family: \'Germania One\'","font-name":"Germania One"},{"font-family":"font-family: \'Gidugu\'","font-name":"Gidugu"},{"font-family":"font-family: \'Gilda Display\'","font-name":"Gilda Display"},{"font-family":"font-family: \'Give You Glory\'","font-name":"Give You Glory"},{"font-family":"font-family: \'Glass Antiqua\'","font-name":"Glass Antiqua"},{"font-family":"font-family: \'Glegoo\'","font-name":"Glegoo"},{"font-family":"font-family: \'Gloria Hallelujah\'","font-name":"Gloria Hallelujah"},{"font-family":"font-family: \'Goblin One\'","font-name":"Goblin One"},{"font-family":"font-family: \'Gochi Hand\'","font-name":"Gochi Hand"},{"font-family":"font-family: \'Gorditas\'","font-name":"Gorditas"},{"font-family":"font-family: \'Goudy Bookletter 1911\'","font-name":"Goudy Bookletter 1911"},{"font-family":"font-family: \'Graduate\'","font-name":"Graduate"},{"font-family":"font-family: \'Grand Hotel\'","font-name":"Grand Hotel"},{"font-family":"font-family: \'Gravitas One\'","font-name":"Gravitas One"},{"font-family":"font-family: \'Great Vibes\'","font-name":"Great Vibes"},{"font-family":"font-family: \'Griffy\'","font-name":"Griffy"},{"font-family":"font-family: \'Gruppo\'","font-name":"Gruppo"},{"font-family":"font-family: \'Gudea\'","font-name":"Gudea"},{"font-family":"font-family: \'Gurajada\'","font-name":"Gurajada"},{"font-family":"font-family: \'Habibi\'","font-name":"Habibi"},{"font-family":"font-family: \'Halant\'","font-name":"Halant"},{"font-family":"font-family: \'Hammersmith One\'","font-name":"Hammersmith One"},{"font-family":"font-family: \'Hanalei\'","font-name":"Hanalei"},{"font-family":"font-family: \'Hanalei Fill\'","font-name":"Hanalei Fill"},{"font-family":"font-family: \'Handlee\'","font-name":"Handlee"},{"font-family":"font-family: \'Hanuman\'","font-name":"Hanuman"},{"font-family":"font-family: \'Happy Monkey\'","font-name":"Happy Monkey"},{"font-family":"font-family: \'Headland One\'","font-name":"Headland One"},{"font-family":"font-family: \'Henny Penny\'","font-name":"Henny Penny"},{"font-family":"font-family: \'Herr Von Muellerhoff\'","font-name":"Herr Von Muellerhoff"},{"font-family":"font-family: \'Hind\'","font-name":"Hind"},{"font-family":"font-family: \'Hind Siliguri\'","font-name":"Hind Siliguri"},{"font-family":"font-family: \'Hind Vadodara\'","font-name":"Hind Vadodara"},{"font-family":"font-family: \'Holtwood One SC\'","font-name":"Holtwood One SC"},{"font-family":"font-family: \'Homemade Apple\'","font-name":"Homemade Apple"},{"font-family":"font-family: \'Homenaje\'","font-name":"Homenaje"},{"font-family":"font-family: \'IM Fell DW Pica\'","font-name":"IM Fell DW Pica"},{"font-family":"font-family: \'IM Fell DW Pica SC\'","font-name":"IM Fell DW Pica SC"},{"font-family":"font-family: \'IM Fell Double Pica\'","font-name":"IM Fell Double Pica"},{"font-family":"font-family: \'IM Fell Double Pica SC\'","font-name":"IM Fell Double Pica SC"},{"font-family":"font-family: \'IM Fell English\'","font-name":"IM Fell English"},{"font-family":"font-family: \'IM Fell English SC\'","font-name":"IM Fell English SC"},{"font-family":"font-family: \'IM Fell French Canon\'","font-name":"IM Fell French Canon"},{"font-family":"font-family: \'IM Fell French Canon SC\'","font-name":"IM Fell French Canon SC"},{"font-family":"font-family: \'IM Fell Great Primer\'","font-name":"IM Fell Great Primer"},{"font-family":"font-family: \'IM Fell Great Primer SC\'","font-name":"IM Fell Great Primer SC"},{"font-family":"font-family: \'Iceberg\'","font-name":"Iceberg"},{"font-family":"font-family: \'Iceland\'","font-name":"Iceland"},{"font-family":"font-family: \'Imprima\'","font-name":"Imprima"},{"font-family":"font-family: \'Inconsolata\'","font-name":"Inconsolata"},{"font-family":"font-family: \'Inder\'","font-name":"Inder"},{"font-family":"font-family: \'Indie Flower\'","font-name":"Indie Flower"},{"font-family":"font-family: \'Inika\'","font-name":"Inika"},{"font-family":"font-family: \'Inknut Antiqua\'","font-name":"Inknut Antiqua"},{"font-family":"font-family: \'Irish Grover\'","font-name":"Irish Grover"},{"font-family":"font-family: \'Istok Web\'","font-name":"Istok Web"},{"font-family":"font-family: \'Italiana\'","font-name":"Italiana"},{"font-family":"font-family: \'Italianno\'","font-name":"Italianno"},{"font-family":"font-family: \'Itim\'","font-name":"Itim"},{"font-family":"font-family: \'Jacques Francois\'","font-name":"Jacques Francois"},{"font-family":"font-family: \'Jacques Francois Shadow\'","font-name":"Jacques Francois Shadow"},{"font-family":"font-family: \'Jaldi\'","font-name":"Jaldi"},{"font-family":"font-family: \'Jim Nightshade\'","font-name":"Jim Nightshade"},{"font-family":"font-family: \'Jockey One\'","font-name":"Jockey One"},{"font-family":"font-family: \'Jolly Lodger\'","font-name":"Jolly Lodger"},{"font-family":"font-family: \'Josefin Sans\'","font-name":"Josefin Sans"},{"font-family":"font-family: \'Josefin Slab\'","font-name":"Josefin Slab"},{"font-family":"font-family: \'Joti One\'","font-name":"Joti One"},{"font-family":"font-family: \'Judson\'","font-name":"Judson"},{"font-family":"font-family: \'Julee\'","font-name":"Julee"},{"font-family":"font-family: \'Julius Sans One\'","font-name":"Julius Sans One"},{"font-family":"font-family: \'Junge\'","font-name":"Junge"},{"font-family":"font-family: \'Jura\'","font-name":"Jura"},{"font-family":"font-family: \'Just Another Hand\'","font-name":"Just Another Hand"},{"font-family":"font-family: \'Just Me Again Down Here\'","font-name":"Just Me Again Down Here"},{"font-family":"font-family: \'Kadwa\'","font-name":"Kadwa"},{"font-family":"font-family: \'Kalam\'","font-name":"Kalam"},{"font-family":"font-family: \'Kameron\'","font-name":"Kameron"},{"font-family":"font-family: \'Kanit\'","font-name":"Kanit"},{"font-family":"font-family: \'Kantumruy\'","font-name":"Kantumruy"},{"font-family":"font-family: \'Karla\'","font-name":"Karla"},{"font-family":"font-family: \'Karma\'","font-name":"Karma"},{"font-family":"font-family: \'Kaushan Script\'","font-name":"Kaushan Script"},{"font-family":"font-family: \'Kavoon\'","font-name":"Kavoon"},{"font-family":"font-family: \'Kdam Thmor\'","font-name":"Kdam Thmor"},{"font-family":"font-family: \'Keania One\'","font-name":"Keania One"},{"font-family":"font-family: \'Kelly Slab\'","font-name":"Kelly Slab"},{"font-family":"font-family: \'Kenia\'","font-name":"Kenia"},{"font-family":"font-family: \'Khand\'","font-name":"Khand"},{"font-family":"font-family: \'Khmer\'","font-name":"Khmer"},{"font-family":"font-family: \'Khula\'","font-name":"Khula"},{"font-family":"font-family: \'Kite One\'","font-name":"Kite One"},{"font-family":"font-family: \'Knewave\'","font-name":"Knewave"},{"font-family":"font-family: \'Kotta One\'","font-name":"Kotta One"},{"font-family":"font-family: \'Koulen\'","font-name":"Koulen"},{"font-family":"font-family: \'Kranky\'","font-name":"Kranky"},{"font-family":"font-family: \'Kreon\'","font-name":"Kreon"},{"font-family":"font-family: \'Kristi\'","font-name":"Kristi"},{"font-family":"font-family: \'Krona One\'","font-name":"Krona One"},{"font-family":"font-family: \'Kurale\'","font-name":"Kurale"},{"font-family":"font-family: \'La Belle Aurore\'","font-name":"La Belle Aurore"},{"font-family":"font-family: \'Laila\'","font-name":"Laila"},{"font-family":"font-family: \'Lakki Reddy\'","font-name":"Lakki Reddy"},{"font-family":"font-family: \'Lancelot\'","font-name":"Lancelot"},{"font-family":"font-family: \'Lateef\'","font-name":"Lateef"},{"font-family":"font-family: \'Lato\'","font-name":"Lato"},{"font-family":"font-family: \'League Script\'","font-name":"League Script"},{"font-family":"font-family: \'Leckerli One\'","font-name":"Leckerli One"},{"font-family":"font-family: \'Ledger\'","font-name":"Ledger"},{"font-family":"font-family: \'Lekton\'","font-name":"Lekton"},{"font-family":"font-family: \'Lemon\'","font-name":"Lemon"},{"font-family":"font-family: \'Libre Baskerville\'","font-name":"Libre Baskerville"},{"font-family":"font-family: \'Life Savers\'","font-name":"Life Savers"},{"font-family":"font-family: \'Lilita One\'","font-name":"Lilita One"},{"font-family":"font-family: \'Lily Script One\'","font-name":"Lily Script One"},{"font-family":"font-family: \'Limelight\'","font-name":"Limelight"},{"font-family":"font-family: \'Linden Hill\'","font-name":"Linden Hill"},{"font-family":"font-family: \'Lobster\'","font-name":"Lobster"},{"font-family":"font-family: \'Lobster Two\'","font-name":"Lobster Two"},{"font-family":"font-family: \'Londrina Outline\'","font-name":"Londrina Outline"},{"font-family":"font-family: \'Londrina Shadow\'","font-name":"Londrina Shadow"},{"font-family":"font-family: \'Londrina Sketch\'","font-name":"Londrina Sketch"},{"font-family":"font-family: \'Londrina Solid\'","font-name":"Londrina Solid"},{"font-family":"font-family: \'Lora\'","font-name":"Lora"},{"font-family":"font-family: \'Love Ya Like A Sister\'","font-name":"Love Ya Like A Sister"},{"font-family":"font-family: \'Loved by the King\'","font-name":"Loved by the King"},{"font-family":"font-family: \'Lovers Quarrel\'","font-name":"Lovers Quarrel"},{"font-family":"font-family: \'Luckiest Guy\'","font-name":"Luckiest Guy"},{"font-family":"font-family: \'Lusitana\'","font-name":"Lusitana"},{"font-family":"font-family: \'Lustria\'","font-name":"Lustria"},{"font-family":"font-family: \'Macondo\'","font-name":"Macondo"},{"font-family":"font-family: \'Macondo Swash Caps\'","font-name":"Macondo Swash Caps"},{"font-family":"font-family: \'Magra\'","font-name":"Magra"},{"font-family":"font-family: \'Maiden Orange\'","font-name":"Maiden Orange"},{"font-family":"font-family: \'Mako\'","font-name":"Mako"},{"font-family":"font-family: \'Mallanna\'","font-name":"Mallanna"},{"font-family":"font-family: \'Mandali\'","font-name":"Mandali"},{"font-family":"font-family: \'Marcellus\'","font-name":"Marcellus"},{"font-family":"font-family: \'Marcellus SC\'","font-name":"Marcellus SC"},{"font-family":"font-family: \'Marck Script\'","font-name":"Marck Script"},{"font-family":"font-family: \'Margarine\'","font-name":"Margarine"},{"font-family":"font-family: \'Marko One\'","font-name":"Marko One"},{"font-family":"font-family: \'Marmelad\'","font-name":"Marmelad"},{"font-family":"font-family: \'Martel\'","font-name":"Martel"},{"font-family":"font-family: \'Martel Sans\'","font-name":"Martel Sans"},{"font-family":"font-family: \'Marvel\'","font-name":"Marvel"},{"font-family":"font-family: \'Mate\'","font-name":"Mate"},{"font-family":"font-family: \'Mate SC\'","font-name":"Mate SC"},{"font-family":"font-family: \'Maven Pro\'","font-name":"Maven Pro"},{"font-family":"font-family: \'McLaren\'","font-name":"McLaren"},{"font-family":"font-family: \'Meddon\'","font-name":"Meddon"},{"font-family":"font-family: \'MedievalSharp\'","font-name":"MedievalSharp"},{"font-family":"font-family: \'Medula One\'","font-name":"Medula One"},{"font-family":"font-family: \'Megrim\'","font-name":"Megrim"},{"font-family":"font-family: \'Meie Script\'","font-name":"Meie Script"},{"font-family":"font-family: \'Merienda\'","font-name":"Merienda"},{"font-family":"font-family: \'Merienda One\'","font-name":"Merienda One"},{"font-family":"font-family: \'Merriweather\'","font-name":"Merriweather"},{"font-family":"font-family: \'Merriweather Sans\'","font-name":"Merriweather Sans"},{"font-family":"font-family: \'Metal\'","font-name":"Metal"},{"font-family":"font-family: \'Metal Mania\'","font-name":"Metal Mania"},{"font-family":"font-family: \'Metamorphous\'","font-name":"Metamorphous"},{"font-family":"font-family: \'Metrophobic\'","font-name":"Metrophobic"},{"font-family":"font-family: \'Michroma\'","font-name":"Michroma"},{"font-family":"font-family: \'Milonga\'","font-name":"Milonga"},{"font-family":"font-family: \'Miltonian\'","font-name":"Miltonian"},{"font-family":"font-family: \'Miltonian Tattoo\'","font-name":"Miltonian Tattoo"},{"font-family":"font-family: \'Miniver\'","font-name":"Miniver"},{"font-family":"font-family: \'Miss Fajardose\'","font-name":"Miss Fajardose"},{"font-family":"font-family: \'Modak\'","font-name":"Modak"},{"font-family":"font-family: \'Modern Antiqua\'","font-name":"Modern Antiqua"},{"font-family":"font-family: \'Molengo\'","font-name":"Molengo"},{"font-family":"font-family: \'Molle\'","font-name":"Molle"},{"font-family":"font-family: \'Monda\'","font-name":"Monda"},{"font-family":"font-family: \'Monofett\'","font-name":"Monofett"},{"font-family":"font-family: \'Monoton\'","font-name":"Monoton"},{"font-family":"font-family: \'Monsieur La Doulaise\'","font-name":"Monsieur La Doulaise"},{"font-family":"font-family: \'Montaga\'","font-name":"Montaga"},{"font-family":"font-family: \'Montez\'","font-name":"Montez"},{"font-family":"font-family: \'Montserrat\'","font-name":"Montserrat"},{"font-family":"font-family: \'Montserrat Alternates\'","font-name":"Montserrat Alternates"},{"font-family":"font-family: \'Montserrat Subrayada\'","font-name":"Montserrat Subrayada"},{"font-family":"font-family: \'Moul\'","font-name":"Moul"},{"font-family":"font-family: \'Moulpali\'","font-name":"Moulpali"},{"font-family":"font-family: \'Mountains of Christmas\'","font-name":"Mountains of Christmas"},{"font-family":"font-family: \'Mouse Memoirs\'","font-name":"Mouse Memoirs"},{"font-family":"font-family: \'Mr Bedfort\'","font-name":"Mr Bedfort"},{"font-family":"font-family: \'Mr Dafoe\'","font-name":"Mr Dafoe"},{"font-family":"font-family: \'Mr De Haviland\'","font-name":"Mr De Haviland"},{"font-family":"font-family: \'Mrs Saint Delafield\'","font-name":"Mrs Saint Delafield"},{"font-family":"font-family: \'Mrs Sheppards\'","font-name":"Mrs Sheppards"},{"font-family":"font-family: \'Muli\'","font-name":"Muli"},{"font-family":"font-family: \'Mystery Quest\'","font-name":"Mystery Quest"},{"font-family":"font-family: \'NTR\'","font-name":"NTR"},{"font-family":"font-family: \'Neucha\'","font-name":"Neucha"},{"font-family":"font-family: \'Neuton\'","font-name":"Neuton"},{"font-family":"font-family: \'New Rocker\'","font-name":"New Rocker"},{"font-family":"font-family: \'News Cycle\'","font-name":"News Cycle"},{"font-family":"font-family: \'Niconne\'","font-name":"Niconne"},{"font-family":"font-family: \'Nixie One\'","font-name":"Nixie One"},{"font-family":"font-family: \'Nobile\'","font-name":"Nobile"},{"font-family":"font-family: \'Nokora\'","font-name":"Nokora"},{"font-family":"font-family: \'Norican\'","font-name":"Norican"},{"font-family":"font-family: \'Nosifer\'","font-name":"Nosifer"},{"font-family":"font-family: \'Nothing You Could Do\'","font-name":"Nothing You Could Do"},{"font-family":"font-family: \'Noticia Text\'","font-name":"Noticia Text"},{"font-family":"font-family: \'Noto Sans\'","font-name":"Noto Sans"},{"font-family":"font-family: \'Noto Serif\'","font-name":"Noto Serif"},{"font-family":"font-family: \'Nova Cut\'","font-name":"Nova Cut"},{"font-family":"font-family: \'Nova Flat\'","font-name":"Nova Flat"},{"font-family":"font-family: \'Nova Mono\'","font-name":"Nova Mono"},{"font-family":"font-family: \'Nova Oval\'","font-name":"Nova Oval"},{"font-family":"font-family: \'Nova Round\'","font-name":"Nova Round"},{"font-family":"font-family: \'Nova Script\'","font-name":"Nova Script"},{"font-family":"font-family: \'Nova Slim\'","font-name":"Nova Slim"},{"font-family":"font-family: \'Nova Square\'","font-name":"Nova Square"},{"font-family":"font-family: \'Numans\'","font-name":"Numans"},{"font-family":"font-family: \'Nunito\'","font-name":"Nunito"},{"font-family":"font-family: \'Odor Mean Chey\'","font-name":"Odor Mean Chey"},{"font-family":"font-family: \'Offside\'","font-name":"Offside"},{"font-family":"font-family: \'Old Standard TT\'","font-name":"Old Standard TT"},{"font-family":"font-family: \'Oldenburg\'","font-name":"Oldenburg"},{"font-family":"font-family: \'Oleo Script\'","font-name":"Oleo Script"},{"font-family":"font-family: \'Oleo Script Swash Caps\'","font-name":"Oleo Script Swash Caps"},{"font-family":"font-family: \'Open Sans\'","font-name":"Open Sans"},{"font-family":"font-family: \'Open Sans Condensed\'","font-name":"Open Sans Condensed"},{"font-family":"font-family: \'Oranienbaum\'","font-name":"Oranienbaum"},{"font-family":"font-family: \'Orbitron\'","font-name":"Orbitron"},{"font-family":"font-family: \'Oregano\'","font-name":"Oregano"},{"font-family":"font-family: \'Orienta\'","font-name":"Orienta"},{"font-family":"font-family: \'Original Surfer\'","font-name":"Original Surfer"},{"font-family":"font-family: \'Oswald\'","font-name":"Oswald"},{"font-family":"font-family: \'Over the Rainbow\'","font-name":"Over the Rainbow"},{"font-family":"font-family: \'Overlock\'","font-name":"Overlock"},{"font-family":"font-family: \'Overlock SC\'","font-name":"Overlock SC"},{"font-family":"font-family: \'Ovo\'","font-name":"Ovo"},{"font-family":"font-family: \'Oxygen\'","font-name":"Oxygen"},{"font-family":"font-family: \'Oxygen Mono\'","font-name":"Oxygen Mono"},{"font-family":"font-family: \'PT Mono\'","font-name":"PT Mono"},{"font-family":"font-family: \'PT Sans\'","font-name":"PT Sans"},{"font-family":"font-family: \'PT Sans Caption\'","font-name":"PT Sans Caption"},{"font-family":"font-family: \'PT Sans Narrow\'","font-name":"PT Sans Narrow"},{"font-family":"font-family: \'PT Serif\'","font-name":"PT Serif"},{"font-family":"font-family: \'PT Serif Caption\'","font-name":"PT Serif Caption"},{"font-family":"font-family: \'Pacifico\'","font-name":"Pacifico"},{"font-family":"font-family: \'Palanquin\'","font-name":"Palanquin"},{"font-family":"font-family: \'Palanquin Dark\'","font-name":"Palanquin Dark"},{"font-family":"font-family: \'Paprika\'","font-name":"Paprika"},{"font-family":"font-family: \'Parisienne\'","font-name":"Parisienne"},{"font-family":"font-family: \'Passero One\'","font-name":"Passero One"},{"font-family":"font-family: \'Passion One\'","font-name":"Passion One"},{"font-family":"font-family: \'Pathway Gothic One\'","font-name":"Pathway Gothic One"},{"font-family":"font-family: \'Patrick Hand\'","font-name":"Patrick Hand"},{"font-family":"font-family: \'Patrick Hand SC\'","font-name":"Patrick Hand SC"},{"font-family":"font-family: \'Patua One\'","font-name":"Patua One"},{"font-family":"font-family: \'Paytone One\'","font-name":"Paytone One"},{"font-family":"font-family: \'Peddana\'","font-name":"Peddana"},{"font-family":"font-family: \'Peralta\'","font-name":"Peralta"},{"font-family":"font-family: \'Permanent Marker\'","font-name":"Permanent Marker"},{"font-family":"font-family: \'Petit Formal Script\'","font-name":"Petit Formal Script"},{"font-family":"font-family: \'Petrona\'","font-name":"Petrona"},{"font-family":"font-family: \'Philosopher\'","font-name":"Philosopher"},{"font-family":"font-family: \'Piedra\'","font-name":"Piedra"},{"font-family":"font-family: \'Pinyon Script\'","font-name":"Pinyon Script"},{"font-family":"font-family: \'Pirata One\'","font-name":"Pirata One"},{"font-family":"font-family: \'Plaster\'","font-name":"Plaster"},{"font-family":"font-family: \'Play\'","font-name":"Play"},{"font-family":"font-family: \'Playball\'","font-name":"Playball"},{"font-family":"font-family: \'Playfair Display\'","font-name":"Playfair Display"},{"font-family":"font-family: \'Playfair Display SC\'","font-name":"Playfair Display SC"},{"font-family":"font-family: \'Podkova\'","font-name":"Podkova"},{"font-family":"font-family: \'Poiret One\'","font-name":"Poiret One"},{"font-family":"font-family: \'Poller One\'","font-name":"Poller One"},{"font-family":"font-family: \'Poly\'","font-name":"Poly"},{"font-family":"font-family: \'Pompiere\'","font-name":"Pompiere"},{"font-family":"font-family: \'Pontano Sans\'","font-name":"Pontano Sans"},{"font-family":"font-family: \'Poppins\'","font-name":"Poppins"},{"font-family":"font-family: \'Port Lligat Sans\'","font-name":"Port Lligat Sans"},{"font-family":"font-family: \'Port Lligat Slab\'","font-name":"Port Lligat Slab"},{"font-family":"font-family: \'Pragati Narrow\'","font-name":"Pragati Narrow"},{"font-family":"font-family: \'Prata\'","font-name":"Prata"},{"font-family":"font-family: \'Preahvihear\'","font-name":"Preahvihear"},{"font-family":"font-family: \'Press Start 2P\'","font-name":"Press Start 2P"},{"font-family":"font-family: \'Princess Sofia\'","font-name":"Princess Sofia"},{"font-family":"font-family: \'Prociono\'","font-name":"Prociono"},{"font-family":"font-family: \'Prosto One\'","font-name":"Prosto One"},{"font-family":"font-family: \'Puritan\'","font-name":"Puritan"},{"font-family":"font-family: \'Purple Purse\'","font-name":"Purple Purse"},{"font-family":"font-family: \'Quando\'","font-name":"Quando"},{"font-family":"font-family: \'Quantico\'","font-name":"Quantico"},{"font-family":"font-family: \'Quattrocento\'","font-name":"Quattrocento"},{"font-family":"font-family: \'Quattrocento Sans\'","font-name":"Quattrocento Sans"},{"font-family":"font-family: \'Questrial\'","font-name":"Questrial"},{"font-family":"font-family: \'Quicksand\'","font-name":"Quicksand"},{"font-family":"font-family: \'Quintessential\'","font-name":"Quintessential"},{"font-family":"font-family: \'Qwigley\'","font-name":"Qwigley"},{"font-family":"font-family: \'Racing Sans One\'","font-name":"Racing Sans One"},{"font-family":"font-family: \'Radley\'","font-name":"Radley"},{"font-family":"font-family: \'Rajdhani\'","font-name":"Rajdhani"},{"font-family":"font-family: \'Raleway\'","font-name":"Raleway"},{"font-family":"font-family: \'Raleway Dots\'","font-name":"Raleway Dots"},{"font-family":"font-family: \'Ramabhadra\'","font-name":"Ramabhadra"},{"font-family":"font-family: \'Ramaraja\'","font-name":"Ramaraja"},{"font-family":"font-family: \'Rambla\'","font-name":"Rambla"},{"font-family":"font-family: \'Rammetto One\'","font-name":"Rammetto One"},{"font-family":"font-family: \'Ranchers\'","font-name":"Ranchers"},{"font-family":"font-family: \'Rancho\'","font-name":"Rancho"},{"font-family":"font-family: \'Ranga\'","font-name":"Ranga"},{"font-family":"font-family: \'Rationale\'","font-name":"Rationale"},{"font-family":"font-family: \'Ravi Prakash\'","font-name":"Ravi Prakash"},{"font-family":"font-family: \'Redressed\'","font-name":"Redressed"},{"font-family":"font-family: \'Reenie Beanie\'","font-name":"Reenie Beanie"},{"font-family":"font-family: \'Revalia\'","font-name":"Revalia"},{"font-family":"font-family: \'Rhodium Libre\'","font-name":"Rhodium Libre"},{"font-family":"font-family: \'Ribeye\'","font-name":"Ribeye"},{"font-family":"font-family: \'Ribeye Marrow\'","font-name":"Ribeye Marrow"},{"font-family":"font-family: \'Righteous\'","font-name":"Righteous"},{"font-family":"font-family: \'Risque\'","font-name":"Risque"},{"font-family":"font-family: \'Roboto\'","font-name":"Roboto"},{"font-family":"font-family: \'Roboto Condensed\'","font-name":"Roboto Condensed"},{"font-family":"font-family: \'Roboto Mono\'","font-name":"Roboto Mono"},{"font-family":"font-family: \'Roboto Slab\'","font-name":"Roboto Slab"},{"font-family":"font-family: \'Rochester\'","font-name":"Rochester"},{"font-family":"font-family: \'Rock Salt\'","font-name":"Rock Salt"},{"font-family":"font-family: \'Rokkitt\'","font-name":"Rokkitt"},{"font-family":"font-family: \'Romanesco\'","font-name":"Romanesco"},{"font-family":"font-family: \'Ropa Sans\'","font-name":"Ropa Sans"},{"font-family":"font-family: \'Rosario\'","font-name":"Rosario"},{"font-family":"font-family: \'Rosarivo\'","font-name":"Rosarivo"},{"font-family":"font-family: \'Rouge Script\'","font-name":"Rouge Script"},{"font-family":"font-family: \'Rozha One\'","font-name":"Rozha One"},{"font-family":"font-family: \'Rubik\'","font-name":"Rubik"},{"font-family":"font-family: \'Rubik Mono One\'","font-name":"Rubik Mono One"},{"font-family":"font-family: \'Rubik One\'","font-name":"Rubik One"},{"font-family":"font-family: \'Ruda\'","font-name":"Ruda"},{"font-family":"font-family: \'Rufina\'","font-name":"Rufina"},{"font-family":"font-family: \'Ruge Boogie\'","font-name":"Ruge Boogie"},{"font-family":"font-family: \'Ruluko\'","font-name":"Ruluko"},{"font-family":"font-family: \'Rum Raisin\'","font-name":"Rum Raisin"},{"font-family":"font-family: \'Ruslan Display\'","font-name":"Ruslan Display"},{"font-family":"font-family: \'Russo One\'","font-name":"Russo One"},{"font-family":"font-family: \'Ruthie\'","font-name":"Ruthie"},{"font-family":"font-family: \'Rye\'","font-name":"Rye"},{"font-family":"font-family: \'Sacramento\'","font-name":"Sacramento"},{"font-family":"font-family: \'Sahitya\'","font-name":"Sahitya"},{"font-family":"font-family: \'Sail\'","font-name":"Sail"},{"font-family":"font-family: \'Salsa\'","font-name":"Salsa"},{"font-family":"font-family: \'Sanchez\'","font-name":"Sanchez"},{"font-family":"font-family: \'Sancreek\'","font-name":"Sancreek"},{"font-family":"font-family: \'Sansita One\'","font-name":"Sansita One"},{"font-family":"font-family: \'Sarala\'","font-name":"Sarala"},{"font-family":"font-family: \'Sarina\'","font-name":"Sarina"},{"font-family":"font-family: \'Sarpanch\'","font-name":"Sarpanch"},{"font-family":"font-family: \'Satisfy\'","font-name":"Satisfy"},{"font-family":"font-family: \'Scada\'","font-name":"Scada"},{"font-family":"font-family: \'Scheherazade\'","font-name":"Scheherazade"},{"font-family":"font-family: \'Schoolbell\'","font-name":"Schoolbell"},{"font-family":"font-family: \'Seaweed Script\'","font-name":"Seaweed Script"},{"font-family":"font-family: \'Sevillana\'","font-name":"Sevillana"},{"font-family":"font-family: \'Seymour One\'","font-name":"Seymour One"},{"font-family":"font-family: \'Shadows Into Light\'","font-name":"Shadows Into Light"},{"font-family":"font-family: \'Shadows Into Light Two\'","font-name":"Shadows Into Light Two"},{"font-family":"font-family: \'Shanti\'","font-name":"Shanti"},{"font-family":"font-family: \'Share\'","font-name":"Share"},{"font-family":"font-family: \'Share Tech\'","font-name":"Share Tech"},{"font-family":"font-family: \'Share Tech Mono\'","font-name":"Share Tech Mono"},{"font-family":"font-family: \'Shojumaru\'","font-name":"Shojumaru"},{"font-family":"font-family: \'Short Stack\'","font-name":"Short Stack"},{"font-family":"font-family: \'Siemreap\'","font-name":"Siemreap"},{"font-family":"font-family: \'Sigmar One\'","font-name":"Sigmar One"},{"font-family":"font-family: \'Signika\'","font-name":"Signika"},{"font-family":"font-family: \'Signika Negative\'","font-name":"Signika Negative"},{"font-family":"font-family: \'Simonetta\'","font-name":"Simonetta"},{"font-family":"font-family: \'Sintony\'","font-name":"Sintony"},{"font-family":"font-family: \'Sirin Stencil\'","font-name":"Sirin Stencil"},{"font-family":"font-family: \'Six Caps\'","font-name":"Six Caps"},{"font-family":"font-family: \'Skranji\'","font-name":"Skranji"},{"font-family":"font-family: \'Slabo 13px\'","font-name":"Slabo 13px"},{"font-family":"font-family: \'Slabo 27px\'","font-name":"Slabo 27px"},{"font-family":"font-family: \'Slackey\'","font-name":"Slackey"},{"font-family":"font-family: \'Smokum\'","font-name":"Smokum"},{"font-family":"font-family: \'Smythe\'","font-name":"Smythe"},{"font-family":"font-family: \'Sniglet\'","font-name":"Sniglet"},{"font-family":"font-family: \'Snippet\'","font-name":"Snippet"},{"font-family":"font-family: \'Snowburst One\'","font-name":"Snowburst One"},{"font-family":"font-family: \'Sofadi One\'","font-name":"Sofadi One"},{"font-family":"font-family: \'Sofia\'","font-name":"Sofia"},{"font-family":"font-family: \'Sonsie One\'","font-name":"Sonsie One"},{"font-family":"font-family: \'Sorts Mill Goudy\'","font-name":"Sorts Mill Goudy"},{"font-family":"font-family: \'Source Code Pro\'","font-name":"Source Code Pro"},{"font-family":"font-family: \'Source Sans Pro\'","font-name":"Source Sans Pro"},{"font-family":"font-family: \'Source Serif Pro\'","font-name":"Source Serif Pro"},{"font-family":"font-family: \'Special Elite\'","font-name":"Special Elite"},{"font-family":"font-family: \'Spicy Rice\'","font-name":"Spicy Rice"},{"font-family":"font-family: \'Spinnaker\'","font-name":"Spinnaker"},{"font-family":"font-family: \'Spirax\'","font-name":"Spirax"},{"font-family":"font-family: \'Squada One\'","font-name":"Squada One"},{"font-family":"font-family: \'Sree Krushnadevaraya\'","font-name":"Sree Krushnadevaraya"},{"font-family":"font-family: \'Stalemate\'","font-name":"Stalemate"},{"font-family":"font-family: \'Stalinist One\'","font-name":"Stalinist One"},{"font-family":"font-family: \'Stardos Stencil\'","font-name":"Stardos Stencil"},{"font-family":"font-family: \'Stint Ultra Condensed\'","font-name":"Stint Ultra Condensed"},{"font-family":"font-family: \'Stint Ultra Expanded\'","font-name":"Stint Ultra Expanded"},{"font-family":"font-family: \'Stoke\'","font-name":"Stoke"},{"font-family":"font-family: \'Strait\'","font-name":"Strait"},{"font-family":"font-family: \'Sue Ellen Francisco\'","font-name":"Sue Ellen Francisco"},{"font-family":"font-family: \'Sumana\'","font-name":"Sumana"},{"font-family":"font-family: \'Sunshiney\'","font-name":"Sunshiney"},{"font-family":"font-family: \'Supermercado One\'","font-name":"Supermercado One"},{"font-family":"font-family: \'Sura\'","font-name":"Sura"},{"font-family":"font-family: \'Suranna\'","font-name":"Suranna"},{"font-family":"font-family: \'Suravaram\'","font-name":"Suravaram"},{"font-family":"font-family: \'Suwannaphum\'","font-name":"Suwannaphum"},{"font-family":"font-family: \'Swanky and Moo Moo\'","font-name":"Swanky and Moo Moo"},{"font-family":"font-family: \'Syncopate\'","font-name":"Syncopate"},{"font-family":"font-family: \'Tangerine\'","font-name":"Tangerine"},{"font-family":"font-family: \'Taprom\'","font-name":"Taprom"},{"font-family":"font-family: \'Tauri\'","font-name":"Tauri"},{"font-family":"font-family: \'Teko\'","font-name":"Teko"},{"font-family":"font-family: \'Telex\'","font-name":"Telex"},{"font-family":"font-family: \'Tenali Ramakrishna\'","font-name":"Tenali Ramakrishna"},{"font-family":"font-family: \'Tenor Sans\'","font-name":"Tenor Sans"},{"font-family":"font-family: \'Text Me One\'","font-name":"Text Me One"},{"font-family":"font-family: \'The Girl Next Door\'","font-name":"The Girl Next Door"},{"font-family":"font-family: \'Tienne\'","font-name":"Tienne"},{"font-family":"font-family: \'Tillana\'","font-name":"Tillana"},{"font-family":"font-family: \'Timmana\'","font-name":"Timmana"},{"font-family":"font-family: \'Tinos\'","font-name":"Tinos"},{"font-family":"font-family: \'Titan One\'","font-name":"Titan One"},{"font-family":"font-family: \'Titillium Web\'","font-name":"Titillium Web"},{"font-family":"font-family: \'Trade Winds\'","font-name":"Trade Winds"},{"font-family":"font-family: \'Trocchi\'","font-name":"Trocchi"},{"font-family":"font-family: \'Trochut\'","font-name":"Trochut"},{"font-family":"font-family: \'Trykker\'","font-name":"Trykker"},{"font-family":"font-family: \'Tulpen One\'","font-name":"Tulpen One"},{"font-family":"font-family: \'Ubuntu\'","font-name":"Ubuntu"},{"font-family":"font-family: \'Ubuntu Condensed\'","font-name":"Ubuntu Condensed"},{"font-family":"font-family: \'Ubuntu Mono\'","font-name":"Ubuntu Mono"},{"font-family":"font-family: \'Ultra\'","font-name":"Ultra"},{"font-family":"font-family: \'Uncial Antiqua\'","font-name":"Uncial Antiqua"},{"font-family":"font-family: \'Underdog\'","font-name":"Underdog"},{"font-family":"font-family: \'Unica One\'","font-name":"Unica One"},{"font-family":"font-family: \'UnifrakturCook\'","font-name":"UnifrakturCook"},{"font-family":"font-family: \'UnifrakturMaguntia\'","font-name":"UnifrakturMaguntia"},{"font-family":"font-family: \'Unkempt\'","font-name":"Unkempt"},{"font-family":"font-family: \'Unlock\'","font-name":"Unlock"},{"font-family":"font-family: \'Unna\'","font-name":"Unna"},{"font-family":"font-family: \'VT323\'","font-name":"VT323"},{"font-family":"font-family: \'Vampiro One\'","font-name":"Vampiro One"},{"font-family":"font-family: \'Varela\'","font-name":"Varela"},{"font-family":"font-family: \'Varela Round\'","font-name":"Varela Round"},{"font-family":"font-family: \'Vast Shadow\'","font-name":"Vast Shadow"},{"font-family":"font-family: \'Vesper Libre\'","font-name":"Vesper Libre"},{"font-family":"font-family: \'Vibur\'","font-name":"Vibur"},{"font-family":"font-family: \'Vidaloka\'","font-name":"Vidaloka"},{"font-family":"font-family: \'Viga\'","font-name":"Viga"},{"font-family":"font-family: \'Voces\'","font-name":"Voces"},{"font-family":"font-family: \'Volkhov\'","font-name":"Volkhov"},{"font-family":"font-family: \'Vollkorn\'","font-name":"Vollkorn"},{"font-family":"font-family: \'Voltaire\'","font-name":"Voltaire"},{"font-family":"font-family: \'Waiting for the Sunrise\'","font-name":"Waiting for the Sunrise"},{"font-family":"font-family: \'Wallpoet\'","font-name":"Wallpoet"},{"font-family":"font-family: \'Walter Turncoat\'","font-name":"Walter Turncoat"},{"font-family":"font-family: \'Warnes\'","font-name":"Warnes"},{"font-family":"font-family: \'Wellfleet\'","font-name":"Wellfleet"},{"font-family":"font-family: \'Wendy One\'","font-name":"Wendy One"},{"font-family":"font-family: \'Wire One\'","font-name":"Wire One"},{"font-family":"font-family: \'Work Sans\'","font-name":"Work Sans"},{"font-family":"font-family: \'Yanone Kaffeesatz\'","font-name":"Yanone Kaffeesatz"},{"font-family":"font-family: \'Yantramanav\'","font-name":"Yantramanav"},{"font-family":"font-family: \'Yellowtail\'","font-name":"Yellowtail"},{"font-family":"font-family: \'Yeseva One\'","font-name":"Yeseva One"},{"font-family":"font-family: \'Yesteryear\'","font-name":"Yesteryear"},{"font-family":"font-family: \'Zeyada\'","font-name":"Zeyada"}]',true);

		foreach ($fonts as $font){
			$fevr_vc_font_family_list[$font['font-name']] = $font['font-name'];
		}
	}

	/**
	 * Extend an array object
	 * @param array $pairs
	 * @param array $atts
	 */
	public function extend( $pairs, $atts) {
		$atts = (array)$atts;
		$out = array();
		foreach ($pairs as $name => $default) {
			if ( array_key_exists($name, $atts) )
				$out[$name] = $atts[$name];
				else
					$out[$name] = $default;
		}
		return $out;
	}

	/**
	 * Override WooCommerce Shortcodes
	 */
	public function init_wc_shortcodes(){
		if (class_exists('WC_Shortcodes')){
			include_once LUVTHEMES_CORE_PATH . 'includes/woocommerce.inc.php';
			remove_action('init',array('WC_Shortcodes','init'));
			add_action('init',array('Luv_WC_Shortcodes','init'),11);
		}
	}

	/**
	 * Display shortcode generator in media buttons context
	 * @param string $button_set
	 * @return string
	 */
	public function shortcode_generator_button($button_set){
		$button_set .= '<a href="#" class="button luv-shortcode-generator">Luvthemes Shortcodes</a>';
		return $button_set;
	}

	/**
	 * Create luv shortcode generator container
	 */
	public function add_shortcode_generator_container() {
		$navigation = '';

		echo '<div id="luv-shortcode-generator-container" class="luv-hidden">';
		echo '<div class="luv-popup-header"><img src="'.esc_url(LUVTHEMES_CORE_URI . '/assets/images/menu_icon.png').'">LUV Shortcode Generator</div>';
		foreach ((array)$this->Luv_Shortcode->shortcodes as $key=>$shortcode){
			if  (luv_is_shortcode_available($shortcode) &&
				(!isset($shortcode['vc_only']) || $shortcode['vc_only'] == false) &&
				(!isset($shortcode['content_element']) || $shortcode['content_element'] == true)
			){

				// Print shortcode field containers
				echo '<div class="luv-shortcode-container luv-hidden" data-type="'.$key.'"></div>';

				$icon = '';
				if (isset($shortcode['icon']) && !empty($shortcode['icon'])){
					$icon = '<img src="'.esc_url($shortcode['icon']).'" height="34px">';
				}

				$navigation .= '<li class="luv-shortcode-tile" data-shortcode="'.$key.'"><span class="luv-shortcode-icon">'.$icon.'</span><span class="luv-shortcode-title">'.$shortcode['name'].'</span>'.(!empty($shortcode['subtitle']) ? '<span class="luv-shortcode-subtitle">'.$shortcode['subtitle'].'</span></li>' : '').'</li>';
			}
		}
		echo '<ul class="luv-shortcode-navigation">'.$navigation.'</ul><div class="luv-button-container"><button class="luv-btn luv-btn-blue close-luv-shortcode-container">'.esc_html__('Close', 'fevr').'</button><button class="luv-btn luv-btn-blue cancel-luv-shortcode-container luv-hidden">'.esc_html__('Cancel', 'fevr').'</button><button class="luv-btn luv-btn-green insert-luv-shortcode luv-hidden">'.esc_html__('Insert', 'fevr').'</button></div></div>';
	}

	/**
	 * Load luv shortcode generator fields
	 */
	public function load_shortcode_generator_fields(){
		$this->get_shortcode_generator_fields($this->Luv_Shortcode->shortcodes[$_POST['shortcode']]);
		wp_die();
	}

	/**
	 * Print shortcode generator fields for shortcode
	 * @param string $shortcode
	 */
	public function get_shortcode_generator_fields($shortcode) {
		global $luv_iconset;

		echo isset($shortcode['as_parent']) ? '<input type="hidden" id="shortcode-pseudo-content" name="content" data-attr="content">' : '';
		echo isset($shortcode['args']['desc']) && !empty($shortcode['args']['desc']) ? $shortcode['args']['desc'] : '';

		foreach($shortcode['params'] as $field) {

			$default_value = isset($field['std']) ? $field['std'] : '';

			echo '<div class="shortcode-'. $field['param_name'] .'_container luv-shortcode-field-section '.(isset($field['dependency']) && $field['dependency'] != '' ? 'luv-required' : '').'"
				'.(isset($field['dependency']) && !empty($field['dependency']) ? 'style="display: none;"' : '').'
				'.(isset($field['dependency']) && !empty($field['dependency']) ? 'data-required-name="'.$field['dependency']['element'].'" data-required-compare="'.(isset($field['dependency']['not_empty']) ? '!=' : '=').'" data-required-value="'.(isset($field['dependency']['value']) && is_array($field['dependency']['value']) ? $field['dependency']['value'][0] : (isset($field['dependency']['value']) ? $field['dependency']['value'] : '')).'"' : '').'>';

			echo '<label for="shortcode-'. $field['param_name'] .'"><strong>'. $field['heading'] .'</strong><span>'. (isset($field['description']) ? $field['description'] : '') .'</span></label>';

			echo '<div class="luv-shortcode-field-container">';

			switch( $field['type'] ){

				case 'textfield':
				case 'autocomplete':
					echo '<input type="text" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value .'">';
					break;

				case 'luv_url':
					echo '<div class="luv-existing-content-outer">'.
						 '<input type="url" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value .'">'.
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
						echo '<input type="hidden" class="responsive-number" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value . '" ' . (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') . ' data-unit="' . (isset($field['extra']['unit'][0]) ? $field['extra']['unit'][0] : '') . '">';
						echo '<div class="responsive-field-icon"><i class="fa fa-desktop"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="desktop">';
						echo '<div class="responsive-field-icon"><i class="fa fa-laptop"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="laptop">';
						echo '<div class="responsive-field-icon"><i class="fa fa-tablet fa-rotate-90"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="tablet-landscape">';
						echo '<div class="responsive-field-icon"><i class="fa fa-tablet"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="tablet-portrait">';
						echo '<div class="responsive-field-icon"><i class="fa fa-mobile"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-responsive="mobile">';
						echo '</div>';
					}
					else{
						echo '<input type="number" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value . '" ' . (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') . ' data-unit="' . (isset($field['extra']['unit'][0]) ? $field['extra']['unit'][0] : '') . '">';
					}
					break;

				case 'colorpicker':
					echo '<input type="text" class="wp-color-picker" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value .'">';
					break;

				case 'textarea':
					echo '<textarea name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'">'. $default_value .'</textarea>';
					break;

				case 'textarea_html' :
					$_id = 'shortcode-' . $field['param_name'];
					$settings = array(
					'textarea_name' => $field['param_name'] ,
					'editor_class' => 'luv-shortcode-editor-field wp-editor-content',
					'wpautop' => true,
					'drag_drop_upload' => true,
					);
					wp_editor($default_value, $_id , $settings );
					echo '<script>reinit_wp_editors("#wp-'.$_id .'-editor-container")</script>';
					break;

				case 'dropdown':
					echo '<div class="luv-custom-select"><select name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'">';
					foreach( $field['value'] as  $option => $key ){
						echo '<option value="' . $key . '"' . selected($default_value, $key, false) . '>'. $option .'</option>';
					}
					echo '</select></div>';
					break;

				case 'posts':
					echo '<div class="luv-custom-select"><select name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'">';
					foreach( get_posts(array('post_type' => $field['extra']['post_type'], 'posts_per_page' => -1)) as $option ){
						echo '<option value="' . $option->ID . '"' . selected($default_value, $option->ID, false) . '>'. $option->post_title .'</option>';
					}
					echo '</select></div>';
					break;

				case 'checkbox':
				case 'luv_switch':
					$checked = ($default_value == 'true') ? ' checked="checked"' : '';

					echo '<input type="hidden" name="'.$field['param_name']  .'" value="false"'. $checked .'><input type="checkbox" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" name="'.$field['param_name']  .'" value="true"'. $checked .' ' . (isset($field['class']) && !empty($field['class']) ? 'class="' . $field['class'] . '"' : '') . '><label for="shortcode-'. $field['param_name'] . '" '. (isset($field['class']) && !empty($field['class']) ? 'class="' . $field['class'] . '"' : '') . '></label>';
					break;

				case 'tokenfield':
					$inputs = '';

					foreach ($field['tokens'] as $key=>$input){
						$inputs .= '<li>'.$input.'</li>';
					}

					echo 	'<div class="vc_tokenfield_block">'.
							'<input type="hidden" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value .'" class="vc_tokenfield">'.
							'<div class="tokenfield"></div>'.
							'<input type="text" class="autocomplete">'.
							'<ul class="vc_tokenlist">'.$inputs.'<li class="pseudo-element"></li></ul>'.
							'</div>';
					break;

				case 'attach_image':
					echo '<div class="luv-media-upload-container media-image">';
					echo '<input type="hidden" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" name="'.$field['param_name']  .'" class="luv-media-upload-url" value="'. $default_value .'" data-default="'. $default_value .'">';
					echo '<img src="" class="luv-media-upload-preview is-hidden">';
					echo '<div class="luv-media-buttons">';
					echo '<span class="button media_upload_button luv-media-upload-by-id">Upload</span>';
					echo '<span class="button remove-image luv-media-upload-reset is-hidden">Remove</span>';
					echo '</div>';
					echo '</div>';
					break;

				case 'attach_media':

					echo '<div class="luv-media-upload-container media-file">';
					echo '<input type="text" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" name="'.$field['param_name']  .'" class="luv-media-upload-url" value="'. $default_value .'" data-default="'. $default_value .'">';
					echo '<div class="luv-media-buttons">';
					echo '<span class="button media_upload_button luv-media-upload">'. (!empty($meta_value) ? 'Modify' : 'Upload') .'</span>';
					echo '<span class="button remove-image luv-media-upload-reset '. (!empty($meta_value) ? '' : 'is-hidden') .'">Remove</span>';
					echo '</div>';
					echo' </div>';

					break;

				case 'buttonset':
					echo '<div class="luv-buttonset">';
					foreach( $field['options'] as $key => $option ){

						echo '<input type="radio" id="shortcode-'. $field['param_name'] .'_'. $key .'" data-id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" name="'. $field["id"] .'" value="'. $key .'" data-default="'. $default_value .'" >';
						echo '<label for="shortcode-'. $field['param_name'] .'_'. $key .'"> '.$option.'</label>';

					}
					echo '</div>';
					break;

				case 'iconset':
					$options = '';
					$icons = '';
					if (isset($field['extra']['svg']) && $field['extra']['svg'] == true){
						global $luv_svg_iconset;
						$luv_iconset = array_merge(apply_filters('luv_iconset', $luv_iconset), apply_filters('luv_svg_iconset', $luv_svg_iconset));
					}
					foreach($luv_iconset as $key=>$iconset){
						$options .= '<option value=' . $key . '>' . $key . '</option>';
						$icons .= '<ul class="luv-iconset' . (isset($not_first) ? ' luv-hidden' : '') .'" data-iconset="'.$key.'">';
						foreach ($iconset as $icon){
							$icons .= '<li><i class="'.$icon.'"></i></li>';
						}
						$icons .= '</ul>';
						$not_first = true;
					}

					echo '<div class="luv-custom-select"><select class="luv-iconset-filter">';
					echo $options;
					echo '</select></div>';
					echo '<input type="text" class="luv-icon-filter" placeholder="' . esc_html__('Search for icons', 'fevr') . '">';

					echo $icons;

					echo '<input type="hidden" class="icon-holder" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'">';
					break;

				case 'wp_category':
					$taxonomy = (isset($field['extra']['taxonomy']) ? array('taxonomy' => $field['extra']['taxonomy']) : array());
					echo '<input type="hidden" class="luv-multiselect-csl" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'">';
					echo '<a href="#" class="luv-multiselect-check-all luv-multiselect-button">'.esc_html__('Check all', 'fevr').'</a>';
					echo '<a href="#" class="luv-multiselect-clear luv-multiselect-button">'.esc_html__('Clear', 'fevr').'</a>';
					echo '<ul class="luv-multiselect">';
					echo '<li><label><input type="checkbox" class="luv-multiselect-checkbox" value="__related">'.esc_html__('Related', 'fevr').'</label></li>';
					echo '<li><hr></li>';
					foreach(get_categories($taxonomy) as $category) {
						echo '<li><label><input type="checkbox" class="luv-multiselect-checkbox" value="'.$category->name.'">'.$category->name.'</label></li>';
					}
					echo '</ul>';
					break;

				case 'luv_design':
					echo '<div class="margin-set">';
					echo '<input type="hidden" class="luv_design-margin" name="'.$field['param_name']  .'" id="shortcode-'. $field['param_name'] .'" data-attr="'.$field['param_name'].'" value="'. $default_value .'" data-default="'. $default_value . '" ' . (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') . ' data-unit="' . (isset($field['extra']['unit'][0]) ? $field['extra']['unit'][0] : '') . '">';
					echo '<div class="luv_design-field-icon"><i class="fa fa-long-arrow-up"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-luv_design="margin-top">';
					echo '<div class="luv_design-field-icon"><i class="fa fa-long-arrow-right"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-luv_design="margin-right">';
					echo '<div class="luv_design-field-icon"><i class="fa fa-long-arrow-down"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-luv_design="margin-bottom">';
					echo '<div class="luv_design-field-icon"><i class="fa fa-long-arrow-left"></i></div><input type="number"'. (isset($field['extra']['min']) ? ' min="' . $field['extra']['min'] . '"' : '') . (isset($field['extra']['max']) ? ' max="' . $field['extra']['max'] . '"' : '') .' data-luv_design="margin-left">';
					echo '</div>';
					break;

				case 'luv_font':
					global $luv_font_id;
					$luv_font_id = mt_rand(0,999999);

					echo '<div class="luv-custom-select"><select name="' . $field['param_name'] . '" id="shortcode-'. $field['param_name'] .'" data-luv-font-id="'.$luv_font_id.'" data-attr="'.$field['param_name'].'" class="luv-font">';
					foreach( $field['value'] as  $option => $key ){
						echo '<option value="' . $key . '"' . selected($default_value, $key, false) . '>'. $option .'</option>';
					}
					echo '</select></div>'.
						 '<div class="luv-font-preview">'.esc_html__('Grumpy wizards make toxic brew for the evil Queen and Jack.', 'fevr').'</div>'.
						 '<script>jQuery(\'.luv-font\').trigger(\'change\');</script>';
					break;

				case 'luv_font_weight':
					global $luv_font_id;

					echo '<div class="luv-custom-select"><select name="' . $field['param_name'] . '" id="shortcode-'. $field['param_name'] .'" class="luv-font-weight-'.$luv_font_id.'">';
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
			}

			echo '</div>'; // end of shortcode field container

			echo '</div>'; // end of shortcode field section
		}
	}

	/**
	 * Get font variants
	 */
	public function get_font_variants(){
		global $fevr_font_variants;
		if (isset($fevr_font_variants[$_REQUEST['font']])){
			$variants = array();
			foreach ($fevr_font_variants[$_REQUEST['font']] as $variant){
				$variants[$variant] = $variant;
			}
			wp_send_json($variants);
		}
		wp_send_json(array(
				esc_html__( '100', 'fevr' ) => '100',
				esc_html__( '200', 'fevr' ) => '200',
				esc_html__( '300', 'fevr' ) => '300',
				esc_html__( '400', 'fevr' ) => '400',
				esc_html__( '500', 'fevr' ) => '500',
				esc_html__( '600', 'fevr' ) => '600',
				esc_html__( '700', 'fevr' ) => '700',
				esc_html__( '800', 'fevr' ) => '800',
				esc_html__( '900', 'fevr' ) => '900'
		));
	}

	/**
	 * Coming soon mode
	 */
	public function coming_soon() {
		global $wp_query, $post, $pagenow, $fevr_options;

		if (_check_luvoption('custom-login-page', '', '!=')){
			$page_id = _get_luvoption('custom-login-page');
			$is_login_page = (in_array( $pagenow, array( 'wp-login.php', 'wp-register.php' )) || get_the_ID() == $page_id);
		}
		else{
			$is_login_page = in_array( $pagenow, array( 'wp-login.php', 'wp-register.php' ));
		}

		if (!is_user_logged_in() && !$is_login_page && _check_luvoption('coming-soon-mode', 1) && _check_luvoption('coming-soon-page', '', '!=')){
			global $fevr_meta_fields;
			$fevr_meta_fields = get_post_meta( _get_luvoption('coming-soon-page'), 'fevr_meta', true);
			remove_action('fevr_nav_primary','fevr_nav_primary');
			$wp_query = new WP_Query('page_id='._get_luvoption('coming-soon-page'));
			$post = $wp_query->post;
		}
	}

	/**
	 * Custom login page
	 */

	public function custom_login_page(){
		global $pagenow;

		// Run only on login page and only for non logged-in users
		if (is_user_logged_in() || !in_array( $pagenow, array( 'wp-login.php', 'wp-register.php' ))){
			return;
		}

		if (_check_luvoption('custom-login-page', '', '!=')){
			$page_id = _get_luvoption('custom-login-page');
			$page	 = get_post($page_id);
			if (is_object($page) && strpos($page->post_content, '[luv_login')){
				$login_page = get_permalink($page_id);
				if (isset($_GET['redirect_to'])){
					$login_page = add_query_arg('redirect_to', $_GET['redirect_to'], $login_page);
				}
				wp_redirect(esc_url($login_page));
			}
		}
	}

}

global $luvthemes_core;
$luvhtemes_core = new Luvthemes_Core();


//======================================================================
// Helpers
//======================================================================

/**
 * Bypass base64 encode
 * @param string $string
 * @return string
 */
function luv_b64encode($string){
	return call_user_func('base64_'.'encode', $string);
}

/**
 * Bypass base64 decode
 * @param string $string
 * @return string
 */
function luv_b64decode($string){
	return call_user_func('base64_'.'decode', $string);
}

/**
 * Get luvoption
 * Return empty string if option doesn't exists
 * @param string $key
 * @return array|string
 */
function _get_luvoption($key, $default = ''){
	if (function_exists('fevr_get_luvoption')){
		return fevr_get_luvoption($key, $default);
	}
	else{
		return '';
	}
}

/**
 * Luv Kses
 * Return empty string if option doesn't exists
 * @param string $key
 * @return array|string
 */
function _luv_kses($string){
	if (function_exists('fevr_kses')){
		return fevr_kses($string);
	}
	else {
		return $string;
	}
}

/**
 * Check luvoption against given value
 * Return true if condition is true false otherwise
 * @param string $key
 * @param string $value
 * @return boolean
 */
function _check_luvoption($key, $value = '', $condition = '='){
	if (function_exists('fevr_check_luvoption')){
		return fevr_check_luvoption($key, $value, $condition);
	}
	else{
		return false;
	}
}

/**
 * Backup the global $fevr_options and override it with shortcode atts
 * @param array $options
 */
function luv_core_set_fevr_options($options = array()){
	global $fevr_options, $__fevr_options;
	$__fevr_options = $fevr_options;
	foreach ($options as $key=>$option){
		if  ($option === 'true'){
			$option = 1;
		}
		else if  ($option === 'false'){
			$option = 0;
		}

		$fevr_options[str_replace('_', '-', $key)] = $option;
	}
}

/**
 * Restore global $fevr_options after luv_core_set_fevr_options()
 */
function luv_core_reset_fevr_options(){
	global $fevr_options, $__fevr_options;
	if (!empty($__fevr_options)){
		$fevr_options = $__fevr_options;
		$__fevr_options = array();
	}
}

/**
 * Backup the global $fevr_options and override it with shortcode atts
 * @param array $options
 */
function luv_core_backup_fevr_meta(){
	global $fevr_meta_fields, $_fevr_meta_fields;
	$_fevr_meta_fields = $fevr_meta_fields;
}

/**
 * Restore global $fevr_options after luv_core_set_fevr_options()
 */
function luv_core_reset_fevr_meta(){
	global $fevr_meta_fields, $_fevr_meta_fields;
	$fevr_meta_fields = $_fevr_meta_fields;
}

/**
 * Returns true if we are in shortcode, otherwise it returns false
 * @return boolean
 */
function _is_luv_shortcode() {
	global $is_luv_shortcode;

	return $is_luv_shortcode == true ? true : false;
}

if (!function_exists('luv_is_shortcode_available')):
/**
 * Check dependencies (eg: plugins)
*/
function luv_is_shortcode_available($shortcode) {
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
endif;


/**
 * Check is plugin active
 * @param string $slug
 * @return boolean
 */
function luv_is_plugin_active($slug){
	return in_array($slug, get_option('active_plugins', array()));
}

/**
 * Check if request is PAJAX
 */
function luv_is_pajax(){
	return (isset($_SERVER['HTTP_IS_PAJAX']) && $_SERVER['HTTP_IS_PAJAX'] == 'true');
}

?>
