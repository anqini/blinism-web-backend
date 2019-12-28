<?php

class LuvDynamicInlineCSS{

	public $inline_css = array();

	public $inline_data = array();

	public $style = '';

	public $is_login = false;

	public $meta = array();

	public $late_enqueued_style = array();


	/**
	 * Create LuvDynamicInlineCSS instance
	 */
	public function __construct(){
		add_action('login_head', array($this,'destroy'));

		add_action('init', array($this, 'init'));

		add_action('wp_footer', array(&$this, 'generate_css'), PHP_INT_MAX);

		if (luv_is_pajax()){
			add_action('wp_footer', array(&$this, 'print_placeholder'));
		}
		else{
			add_action('wp_head', array(&$this, 'print_placeholder'), 8);
		}
	}

	public function destroy(){
		$this->is_login = true;
	}

	/**
	 * Start output buffer to collect and put inline CSS in header, and print the placeholder
	 */
	function init(){
		global $fevr_options;

		if (isset($fevr_options['custom-css']) && !empty($fevr_options['custom-css'])){
			$this->style .= preg_replace("~\s+~", ' ', $fevr_options['custom-css']);
		}

		if (isset($fevr_options['accent-color-1']) && !empty($fevr_options['accent-color-1'])){
			$this->style .= '@-moz-keyframes loader-color {   100%, 0% {     stroke: '.$fevr_options['accent-color-1'].'; } } @-webkit-keyframes loader-color {   100%, 0% {     stroke: '.$fevr_options['accent-color-1'].'; } } @keyframes loader-color {   100%, 0% {     stroke: '.$fevr_options['accent-color-1'].'; } }';
			$this->style .= '#top-bar-icons li:before, #top-bar-menu li:before{background-color:' . _luv_adjust_brightness($fevr_options['accent-color-1'], 102) .'}';
			$this->style .= '.nav-cart-list .widget_shopping_cart_content #mini-cart-button-wrapper .button:hover, .nav-cart-list .widget_shopping_cart_content a.remove{color:'._luv_adjust_color_scheme($fevr_options['accent-color-1']).';}';
			$this->style .= '.btn-accent-1, .btn-accent-1:active{background-color:' . $fevr_options['accent-color-1'].';color:'._luv_adjust_color_scheme($fevr_options['accent-color-1']).' !important;}';
			$this->style .= '.nice-select.disabled,.nice-select .option.disabled{color:'. _luv_adjust_brightness($fevr_options['accent-color-1'], 51) .'}';
			$this->style .= '.nice-select .option:hover,.nice-select .option.focus,.nice-select .option.selected.focus{background-color:'. _luv_adjust_brightness($fevr_options['accent-color-1'], -51) .'}';
		}

		if (isset($fevr_options['accent-color-2']) && !empty($fevr_options['accent-color-2'])){
			$this->style .= '[data-header-position="default"] .nav-menu > li:not(.l-megamenu) > .sub-menu li{border-color:' . _luv_adjust_brightness($fevr_options['accent-color-2'], 26) .'}';
			$this->style .= '.nav-menu .sub-menu li:hover{background-color:' . _luv_adjust_brightness($fevr_options['accent-color-2'], -51) .'}';
			$this->style .= '.woocommerce .wc-style-3 .product-wrapper .luv-wc-wishlist, .woocommerce .wc-style-3 .product-wrapper .luv-product-quick-view{color:' . _luv_adjust_brightness($fevr_options['accent-color-2'], 153) .'}';
			$this->style .= '.woocommerce .wc-style-3 .product-wrapper .luv-wc-wishlist:hover, .woocommerce .wc-style-3 .product-wrapper .luv-product-quick-view:hover, .woocommerce .wc-style-3 .product-button-wrapper .add_to_cart_button:hover:hover{background-color:' . _luv_adjust_brightness($fevr_options['accent-color-2'], -51) .'}';
			$this->style .= '.woocommerce .wc-style-3 .product-button-wrapper .button, .woocommerce .wc-style-3 .product-button-wrapper .add_to_cart_button, .woocommerce .wc-style-3 .product-wrapper .luv-wc-wishlist, .woocommerce .wc-style-3 .item-wrapper h3{border-color:' . _luv_adjust_brightness($fevr_options['accent-color-2'], 51) .'}';
			$this->style .= '.nav-cart-list .widget_shopping_cart_content #mini-cart-button-wrapper{background-color:'._luv_adjust_brightness($fevr_options['accent-color-2'], -10).'}';
			$this->style .= '.nav-cart-list .widget_shopping_cart_content #mini-cart-button-wrapper .button{border-color:'._luv_adjust_brightness($fevr_options['accent-color-2'], 51).';color:'._luv_adjust_brightness($fevr_options['accent-color-2'], 51).';}';
			$this->style .= '.btn-accent-1:hover{background-color:' . $fevr_options['accent-color-2'].';color:'._luv_adjust_color_scheme($fevr_options['accent-color-1']).' !important;}';
		}

		if (isset($fevr_options['global-button-settings']) && $fevr_options['global-button-settings'] == 1){
			$btn_style = $btn_rounded = $btn_hover_style = '';
			if (isset($fevr_options['button-style']) && !empty($fevr_options['button-style'])){
				switch ($fevr_options['button-style']){
					case 'only_border':
						$btn_style 			= 'background-color: transparent;border: 2px solid ' . $fevr_options['accent-color-2'] . ';color: ' . $fevr_options['accent-color-2'].';';
						$btn_hover_style	= 'background-color: '. $fevr_options['accent-color-1'] . ';border-color: ' . $fevr_options['accent-color-1'].';';
						break;
					case 'full':
						$btn_style 			= 'color:#fff;border:0;background-color: ' . $fevr_options['accent-color-2'].';';
						$btn_hover_style	= 'background-color: '. $fevr_options['accent-color-1'].';';
						break;
					case '3d':
						$darker 			= _luv_adjust_brightness($fevr_options['accent-color-2'], -50);
						$btn_style 			= '-moz-box-shadow: 0 6px #000;-webkit-box-shadow: 0 6px #000;box-shadow: 0 6px #000;';
						$btn_hover_style	= 'top: 2px; -moz-box-shadow: 0 4px #000;-webkit-box-shadow: 0 4px #000;box-shadow: 0 4px #000;';
						$btn_active_style	= 'top: 6px;-moz-box-shadow: none;-webkit-box-shadow: none;box-shadow: none;';
						break;
				}

				if (isset($fevr_options['button-style-rounded']) && $fevr_options['button-style-rounded'] == 1){
					$btn_rounded = '-webkit-border-radius:100px;-moz-border-radius:100px;border-radius:100px;';
					$this->style .= '.tagcloud a, #project-tags li{-webkit-border-radius:100px;-moz-border-radius:100px;border-radius:100px;}';
				}

				$this->style .= '.btn-global, .widget_price_filter .price_slider_amount .button, .widget_product_search input[type="submit"]{'.$btn_style.$btn_rounded.'}.btn-global:hover, .widget_price_filter .price_slider_amount .button:hover, .widget_product_search input[type="submit"]:hover{'.$btn_hover_style.'}' . (!empty($btn_active_style) ? '.btn-global:active, .widget_price_filter .price_slider_amount .button:active, .widget_product_search input[type="submit"]:active{'.$btn_active_style.'}' :'');
			}
		}

		// Prepare for 3rd party style attribute removal exceptions
		if (isset($fevr_options['remove-inline-styles']) && $fevr_options['remove-inline-styles'] == 1 && !is_admin() && !$this->is_login){
			// Add extra class for cancel reply link
			add_filter('cancel_comment_reply_link', array($this, 'add_extra_class'));
		}

		ob_start(array(&$this, 'luv_dynamic_inline_css_callback'));
	}

	/**
	 * Replace placeholder with generated CSS
	 * @param unknown $buffer
	 */
	public function luv_dynamic_inline_css_callback($buffer){
		global $fevr_options, $luv_enqueued_inline_fonts;

		if (isset($_GET['infinite-inline-css'])){
				$buffer = 'LUVTHEMES_DYNAMIC_INLINE_CSS_PLACEHOLDER';
		}

		// Remove all inline style attribute
		if (isset($fevr_options['remove-inline-styles']) && $fevr_options['remove-inline-styles'] == 1 && !is_admin() && !$this->is_login){

			// Remove 3rd party inline style attributes
			$buffer = preg_replace_callback('~(\s?class=(\'|")([^\'"]*)(\'|")([^>]*))?\s+style=(\'|")([^\'"]*)(\'|")(([^>]*)\s?class=(\'|")([^\'"]*)(\'|"))?~', array($this, 'get_rid_style_callback'), $buffer);

			$this->generate_css();

		}

		// Prepare arrays for fonts
		$load_fonts = array();
		$subsets = array();

		// Collect all enqueued google fonts
		if (_check_luvoption('merge-google-fonts', 1)){
			preg_match_all('~fonts\.googleapis\.com/css\?family=([^\'"]*)~', $buffer, $google_fonts);
			foreach ((array)$google_fonts[1] as $font){
				preg_match('~&#038;subset=([^&"\']*)~',$font,$_subset);
				$__subset = (isset($_subset[1]) ? $_subset[1] : '');
				$subsets = array_merge($subsets,explode(',',urldecode($__subset)));

				$font = preg_replace('~&#038;subset=([^&"\']*)~','',$font);
				$font = preg_replace('~&#038;ver=(\d*)~','',$font);
				foreach (explode('|',urldecode($font)) as $_font){
					@list($font_family, $font_sizes) = explode(':', $_font);
					if (isset($load_fonts[$font_family])){
						$load_fonts[$font_family] = array_unique((array)array_merge((array)$load_fonts[$font_family], (array)$font_sizes));
					}
					else{
						$load_fonts[$font_family] = explode(',',$font_sizes);
					}
				}
			}

			// Remove every enqueued google fonts
			$buffer = preg_replace("~<([^>]*)fonts\.googleapis\.com/css\?family([^>]*)>\n?~",'',$buffer);
		}

		// Add inline fonts
		foreach ((array)$luv_enqueued_inline_fonts as $font_family => $weight){
			if (isset($load_fonts[$font_family])){
				$load_fonts[$font_family] = array_unique(array_merge($load_fonts[$font_family], $weight));
			}
			else{
				$load_fonts[$font_family] = is_array($weight) ? $weight : array($weight);
			}
		}

		// Merge every enqueued google fonts to one request
		if (!empty($load_fonts)){
			$_load_fonts = array();
			foreach ((array)$load_fonts as $load_font => $weights){
				$_load_fonts[] = $load_font . (!empty($weights) ? ':' . implode(',',$weights) : '');
			}
			$subset = trim(implode(',',array_unique($subsets)),',');
			if (_check_luvoption('merge-styles', 1) && _check_luvoption('merge-styles-include-google-fonts', 1)){
				$GLOBALS['luv_merge_styles']['all'][] = '//fonts.googleapis.com/css?family='.urlencode(implode('|',$_load_fonts)).'&#038;subset='.$subset.'&#038;ver='.hash('crc32',implode('',$_load_fonts));
			}
			else{
				if (_check_luvoption('defer-google-fonts',1)){
					_luv_late_enqueue_style('//fonts.googleapis.com/css?family='.urlencode(implode('|',$_load_fonts)).'&#038;subset='.$subset.'&#038;ver='.hash('crc32',implode('',$_load_fonts)), 'defer');
					$this->style .= '<noscript><link rel=\'stylesheet\' href=\'//fonts.googleapis.com/css?family='.urlencode(implode('|',$_load_fonts)).'&#038;subset='.$subset.'&#038;ver='.hash('crc32',implode('',$_load_fonts)).'\' type=\'text/css\' media=\'all\' /></noscript>' . "\n" . $this->style;
				}
				else{
					_luv_late_enqueue_style('//fonts.googleapis.com/css?family='.urlencode(implode('|',$_load_fonts)).'&#038;subset='.$subset.'&#038;ver='.hash('crc32',implode('',$_load_fonts)));
				}
			}
		}


		// Smart enqueue iconsets
		if (_check_luvoption('smart-iconset-enqueue', 1)){
			// Font Awsome
			if(strpos($buffer, 'luv-product-quick-view') !== false || (function_exists('luv_is_pajax') && luv_is_pajax()) || preg_match_all('~fa fa-([a-z-]+)~i', $buffer, $matches)){
				$fa_icon_file = 'font-awesome-critical';
				foreach ((array)$matches[0] as $icon){
					if (!in_array($icon,
						apply_filters('luv_fontawesome_critical_classes', array(
							'fa fa-angle-down',
							'fa fa-angle-up',
							'fa fa-book',
							'fa fa-cloud-upload',
							'fa fa-desktop',
							'fa fa-external-link',
							'fa fa-facebook',
							'fa fa-google-plus',
							'fa fa-heart',
							'fa fa-heart-o',
							'fa fa-laptop',
							'fa fa-leaf',
							'fa fa-link',
							'fa fa-linkedin',
							'fa fa-long-arrow-down',
							'fa fa-long-arrow-left',
							'fa fa-long-arrow-leftion-volume-mute',
							'fa fa-long-arrow-right',
							'fa fa-long-arrow-up',
							'fa fa-minus',
							'fa fa-mobile',
							'fa fa-pinterest',
							'fa fa-plus',
							'fa fa-quote-right',
							'fa fa-rocket',
							'fa fa-search',
							'fa fa-spinner',
							'fa fa-support',
							'fa fa-tablet',
							'fa fa-thumbs-o-down',
							'fa fa-thumbs-o-up',
							'fa fa-times',
							'fa fa-twitter',
							'fa fa-vimeo',
						))
					)){
						$fa_icon_file = 'font-awesome.min';
						break;
					}
				}
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/'.$fa_icon_file.'.css');
			}

			// Ion icons
			if((function_exists('luv_is_pajax') && luv_is_pajax()) || preg_match_all('~(\s|"|\')(ion-([a-z-]+))~i', $buffer, $matches)){
				$ion_icon_file = 'ionicons-critical';
				foreach ((array)$matches[2] as $icon){
					if (!in_array($icon,
						apply_filters('luv_ionicons_critical_classes', array(
							'ion-android-apps',
							'ion-bag',
							'ion-chevron-down',
							'ion-chevron-left',
							'ion-chevron-right',
							'ion-close',
							'ion-icon',
							'ion-ios-arrow-down',
							'ion-ios-arrow-left',
							'ion-ios-arrow-right',
							'ion-ios-keypad',
							'ion-navicon-round',
							'ion-search',
							'ion-volume-high',
							'ion-volume-mute',
						))
					)){
						$ion_icon_file = 'ionicons.min';
						break;					}
				}
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/'.$ion_icon_file.'.css');
			}

			// Linea icons
			if(strpos($buffer, 'linea-icon') !== false || (function_exists('luv_is_pajax') && luv_is_pajax())){
				_luv_late_enqueue_style(LUVTHEMES_CORE_URI . 'assets/css/linea-icons.css');
			}
		}

		// Replace or remove the placeholder
		$header_content = implode("\n",$this->late_enqueued_style) . "\n" . $this->style . implode("\n",$this->meta);
		return str_replace('LUVTHEMES_DYNAMIC_INLINE_CSS_PLACEHOLDER', $header_content, $buffer);
	}

	/**
	 * Get rid 3rd party inline styles
	 * @param array $matches
	 * @return string
	 */
	public function get_rid_style_callback($matches){
		$_classes = (isset($matches[3]) ? $matches[3] : '') . (isset($matches[12]) ? $matches[12] : '');
		if (preg_match('~(wp-audio-shortcode|cancel-reply-link|ls-wp-fullwidth-container|ls-wp-container|ls-l|rev_slider|tp-resizeme|tp-caption|vc_progress_bar|vc_single_bar|vc_bar)~', $_classes)){
			return $matches[0];
		}
		if (isset($matches[3]) && !empty($matches[3])){
			return ' class='.$matches[6].$matches[3] . ' ' ._luv_enqueue_inline_css(array('style' => $matches[7])).$matches[6] . $matches[5];
		}
		else if (isset($matches[12]) && !empty($matches[12])){
			return ' class='.$matches[6].$matches[12] . ' ' ._luv_enqueue_inline_css(array('style' => $matches[7])).$matches[6] . $matches[10];
		}
		else{
			return ' class='.$matches[6]._luv_enqueue_inline_css(array('style' => $matches[7])).$matches[6];
		}

	}

	public function add_extra_class($tag){
		// Cancel reply link
		$tag = str_replace('id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="cancel-reply-link"', $tag);

		return $tag;
	}

	/**
	 * Generate inline style
	 */
	public function generate_css(){
		global $fevr_options;

		// Generate classes
		foreach ((array)$this->inline_css as $class => $styles){
			if (!empty($styles)){
				$parent = (!empty($styles['parent']) ? $styles['parent'] : 'html ') . '.';
				$media = $_media = '';
				if(!empty($styles['media'])){
					$media = ' @media' . $styles['media'] . '{';
					$_media = '}';
				}
				if (!empty($styles['style'])){
					$this->style .=  $media . $parent . $class.'{'.$styles['style'].'}' . $_media;
				}
				foreach ((array)$styles['child'] as $key => $style){
					$this->style .= $media . $parent . $class.$key.'{'.$style.'}' . $_media;
				}
				unset($this->inline_css[$class]);
			}
		}

		// Put <style></style> tags if style isn't empty
		if (!doing_action('wp_footer') || (!isset($fevr_options['remove-inline-styles']) || $fevr_options['remove-inline-styles'] != 1)){
			$this->style = (!empty($this->style) ? '<style>'.$this->style.'</style>' : '');
		}
	}


	/**
	 * Print the placeholder
	 */
	public function print_placeholder(){
		echo "\nLUVTHEMES_DYNAMIC_INLINE_CSS_PLACEHOLDER\n";
	}
}

/**
 * Add meta tag to header after wp_head
 * @param string $meta
 */
function _luv_late_add_header_meta($meta){
	global $luv_dynamic_inline_css;
	$luv_dynamic_inline_css->meta[] = $meta;
}

/**
 * Add style tag to header after wp_head
 * @param string $css
 */
function _luv_late_add_header_style($css){
	global $luv_dynamic_inline_css;
	$luv_dynamic_inline_css->style .= $css;
}

/**
 * Enqueue css files after wp_head
 * @param string $path
 */
function _luv_late_enqueue_style($path, $media = 'all'){
	global $luv_dynamic_inline_css;
	$site_url 	= apply_filters('style_loader_src', site_url(), '');

	if (_check_luvoption('merge-styles', 1) && (strpos($path, $site_url) || (_check_luvoption('merge-styles-include-google-fonts', 1) && strpos($path, 'fonts.googleapis.com')))){
		$GLOBALS['luv_merge_styles'][$media][] = $path;
	}
	else{
		$css = apply_filters('style_loader_tag','<link rel=\'stylesheet\' href=\''.esc_url(apply_filters('style_loader_src', $path, md5($path . $media))).'\' type=\'text/css\' media=\''.$media.'\' />', '');
		$luv_dynamic_inline_css->late_enqueued_style[md5($path . $media)] = $css;
	}
}

/**
 * Enqueue dynamic inline css and return the class name
 * @param array $args Associative array which contains parent selector, element and child elements styles
 * @return string
 */
function _luv_enqueue_inline_css($args){
	global $luv_dynamic_inline_css;

	$media		= isset($args['media']) ? $args['media'] : '';
	$parent		= isset($args['parent']) ? $args['parent'] : '';
	$style		= isset($args['style']) ? $args['style'] : '';
	$child		= isset($args['child']) ? $args['child'] : array();

	// Don't create empty styles
	if (empty($style) && empty($child)){
		return '';
	}

	// Create class name
	$_style = explode(';', $style);
	sort($_style);

	$class = 'luv_dynamic-'.hash('crc32', serialize(array($parent, $_style, $child, $media)));
	$luv_dynamic_inline_css->inline_css[$class] = array('media' => $media,'parent' => $parent, 'style' => $style, 'child' => $child);


	return $class;
}

/**
 * Set brightness for color
 * @param string $hex
 * @param int $steps
 * @return string
 */
function _luv_adjust_brightness($hex, $steps) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(-255, min(255, $steps));

	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return = '#';

	foreach ((array)$color_parts as $color) {
		$color   = hexdec($color); // Convert to decimal
		$color   = max(0,min(255,$color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}

/**
 * Returns text color based on given background color
 * @param string $hex
 * @return string
 */
function _luv_adjust_color_scheme($hex) {
	$hex = str_replace('#', '', $hex);

	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return ((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000) > 130 ? '#000' : '#fff';
}

?>
