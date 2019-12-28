<?php
class Fevr_Performance {

	/**
	 * Create instance
	 */
	public function __construct() {
		// Init performance
		add_action('init', array($this, 'init'),9);

		// Get image sizes
		add_action('init', array($this,'get_image_sizes'));

	}

	/**
	 * Init performance module
	 */
	public function init() {
		if (!defined('FEVR_THEME_VER')){
			return;
		}

		// Admin menus
		if (current_user_can('manage_options')){
			add_action('admin_bar_menu', array($this, 'toolbar_items'),100);
		}

		// Merge CSS files
		if (fevr_check_luvoption('merge-styles', 1) && !$this->is_admin()){
			ob_start(array($this, 'collect_styles'));
			add_action('wp_print_styles', array($this, 'merge_styles_placeholder'));

			if (fevr_check_luvoption('async-merged-css', 1)){
				add_filter( 'body_class', array($this, 'add_is_loading_class'));
			}
		}

		// Move scripts to footer
		if (fevr_check_luvoption('scripts-to-footer', 1) && !$this->is_admin()){
			ob_start(array($this, 'collect_scripts'));
			add_action('wp_footer', array($this, 'scripts_to_footer_placeholder'), PHP_INT_MAX);
		}

		// Include MaxCDN
		if (fevr_check_luvoption('maxcdn-alias', '','!=') && fevr_check_luvoption('maxcdn-key', '','!=') && fevr_check_luvoption('maxcdn-secret', '','!=')){
			require_once 'maxcdn.php';
		}

		// Manage CDN
		if (fevr_check_luvoption('enable-cdn',1)){
			include_once 'cdn-manager.php';
			$this->cdn_manager = new Fevr_CDN_Manager();

			if (isset($_REQUEST['purge-luv-cdn'])){
				$this->purge_cdn();
			}
		}

		// Clear cache
		if ((fevr_check_luvoption('merge-styles', 1) || fevr_check_luvoption('scripts-to-footer', 1)) && is_user_logged_in() && current_user_can('manage_options')){
			if (isset($_GET['clear-luv-cache'])){
				$this->clear_cache();
			}
		}

		// Defer footer scripts
		if (fevr_check_luvoption('defer-footer-scripts', 1) && !$this->is_admin()){
			add_filter('script_loader_tag', array($this, 'defer_footer_scrpits'), 10, 2);
		}

		// Remove version query string from static resources
		if (fevr_check_luvoption('normalize-static-resources', 1) && !$this->is_admin()){
			add_filter('style_loader_src', array($this, 'remove_static_ver'), 10, 2);
			add_filter('script_loader_src', array($this, 'remove_static_ver'), 10, 2);
			add_filter('get_post_metadata', array($this, 'normalize_vc_custom_css'), 10, 4);
		}

		// Lazy load images
		if (fevr_check_luvoption('lazy-load-images', 1) && !$this->is_admin()){
			add_filter('wp_get_attachment_image_attributes', array($this, 'lazy_load_images'), 10, 3);
		}

		// Instant click
		if(fevr_check_luvoption('instantclick', 1)){
			$this->instant_click();
			add_filter('script_loader_tag', array($this, 'no_instant_scripts'), 10, 2);
			add_filter('woocommerce_cart_item_remove_link', array($this, 'no_instant_data'));
			add_filter('woocommerce_loop_add_to_cart_link', array($this, 'no_instant_data'));
		}
	}

	/**
	 * Collect <script> tags in source
	 * @param string $buffer
	 */
	public function collect_scripts($buffer){
		// Collect scripts
		$buffer = preg_replace_callback('~(<!--\[if([^\]]*)\]>)?\s?(<script((?!type)[^>])*>|<script (data-cfasync="false" )?type=("|\')text/javascript("|\')([^>]*)>)((?!</script>)(?!CDATA).)*</script>\s?(<!\[endif\]-->)?\n?~is', array($this, 'register_script'), $buffer);

		// Put all scripts to footer
		if (isset($GLOBALS['fevr_scripts_to_footer'])){

			// Merge scripts
			if (fevr_check_luvoption('merge-scripts',1)){
				do_action('fevr_merge_scripts');
				$block = $defer = $block_md5 = $defer_md5 = '';
				$no_instant = (fevr_check_luvoption('instantclick', 1) ? ' data-no-instant' : '');

				$to_merge	= array('defer' => array(), 'block' => array());
				$site_url 	= preg_replace('~https?://~', '', esc_url(apply_filters('script_loader_src', site_url())));
				$cache_dir 	= WP_CONTENT_DIR . '/cache/fevr';
				$cache_url	= preg_replace('~https?://~', '//', WP_CONTENT_URL . '/cache/fevr');

				if (!file_exists($cache_dir)){
					@mkdir($cache_dir, 0777, true);
				}

				foreach ($GLOBALS['fevr_scripts_to_footer'] as $key => $script){
					preg_match('~src=(\'|")([^\'"]*)(\'|")~', $script, $src);
					if (isset($src[2]) && strpos($src[2], $site_url) !== false && strpos($script, 'if lt ') === false && strpos($script, 'defer ') !== false){
							$defer_md5	.= $GLOBALS['fevr_scripts_to_footer'][$key];
							$to_merge['defer'][] = $src[2];
							unset ($GLOBALS['fevr_scripts_to_footer'][$key]);
					}
					else if (isset($src[2]) && strpos($src[2], $site_url) !== false && strpos($script, 'if lt ') === false ){
							$block_md5	.= $GLOBALS['fevr_scripts_to_footer'][$key];
							$to_merge['block'][] = array('type' => 'embed', 'source' => $src[2]);
							unset ($GLOBALS['fevr_scripts_to_footer'][$key]);
					}
					else if (!isset($src[2]) || empty($src[2]) && strpos($script, 'if lt ') === false ){
						$block_md5	.= $GLOBALS['fevr_scripts_to_footer'][$key];
						$to_merge['block'][] = array('type' => 'inline', 'source' => $GLOBALS['fevr_scripts_to_footer'][$key]);
						unset ($GLOBALS['fevr_scripts_to_footer'][$key]);
					}
				}

				// Render blocking scripts
				$block_md5 = md5($block_md5);
				if (!empty($to_merge['block'])){
					foreach ($to_merge['block'] as $script){
						if ($script['type'] == 'embed'){
							$script['source'] = (preg_match('~^//~', $script['source']) ? 'http' . (is_ssl() ? 's' : '') . ':' . $script['source'] : $script['source']);
							$response 	= wp_remote_get($script['source'], array('sslverify' => false));
							if (!is_wp_error($response)){
								$block .= "\ntry{\n". $response['body'] . "\n}catch(e){console.log(e.message)}\n";
							}
						}
						else{
							$snippet = preg_replace('~^(\s)*<script([^>]*)>~','',$script['source']);
							$snippet = preg_replace('~</script>(\s)*$~','',$snippet);

							$block  .= "\ntry{\n". $snippet . "\n}catch(e){console.log(e.message)}\n";
						}
					}

					if (!file_exists($cache_dir . '/' . $block_md5 . '.js')){
						file_put_contents($cache_dir . '/' . $block_md5 . '.js', $block);
					}
					$GLOBALS['fevr_scripts_to_footer'][] = '<script src="'.esc_url(apply_filters('script_loader_src', $cache_url, 'luv-merged')). '/' . $block_md5 . '.js"'.$no_instant.'></script>';
				}

				// Defered scripts
				$defer_md5 = md5($defer_md5);
				if (!empty($to_merge['defer'])){
					foreach ($to_merge['defer'] as $src){
						$src = (preg_match('~^//~', $src) ? 'http' . (is_ssl() ? 's' : '') . ':' . $src : $src);
						$response 	= wp_remote_get($src, array('sslverify' => false));
						if (!is_wp_error($response)){
							$defer .= "\ntry{\n". $response['body'] . "\n}catch(e){console.log(e.message)}\n";
						}
					}

					if (!file_exists($cache_dir . '/' . $defer_md5 . '.js')){
						file_put_contents($cache_dir . '/' . $defer_md5 . '.js', $defer);
					}
					$GLOBALS['fevr_scripts_to_footer'][] = '<script defer src="'.esc_url(apply_filters('script_loader_src', $cache_url, 'luv-merged-defer')) . '/' . $defer_md5 . '.js"'.$no_instant.'></script>';
				}
			}

			$buffer = str_replace('FEVR_SCRIPTS_TO_FOOTER_PLACEHOLDER', implode("\n",$GLOBALS['fevr_scripts_to_footer']), $buffer);
		}

		return $buffer;
	}

	/**
	 * Collect styles tags in source
	 * @param string $buffer
	 */
	public function collect_styles($buffer){
		$styles		= array();
		$asyncjs = '';
		$cache_dir 	= WP_CONTENT_DIR . '/cache/fevr';
		$cache_url	= preg_replace('~https?://~', '//', WP_CONTENT_URL . '/cache/fevr');

		// Collect styles
		$buffer = preg_replace_callback("~<link rel='stylesheet'([^>]*)>\n?~i", array($this, 'register_style'), $buffer);

		if (!file_exists($cache_dir)){
			@mkdir($cache_dir, 0777, true);
		}

		global $luv_merge_styles;

		if (fevr_check_luvoption('async-merged-css', 1)){
			$styles[] = '<style>'.file_get_contents(trailingslashit(get_template_directory()) . 'css/style-minimal.css').'</style>';
		}

		foreach ((array)$luv_merge_styles as $media => $_styles){
			$file = md5(maybe_serialize($_styles)) . '.css';
			if (!file_exists($cache_dir . '/' . $file)){
				$css = '';
				foreach ($_styles as $style){
					$style = (preg_match('~^//~', $style) ? 'http' . (is_ssl() ? 's' : '') . ':' . $style : $style);
					$response 	= wp_remote_get($style, array('sslverify' => false));
					if (!is_wp_error($response)){
						$GLOBALS['fevr_css_realpath_basepath'] = $style;
						$response['body'] = preg_replace_callback('~@import url\((\'|")?([^\("\']*)(\'|")?\)~', array($this, 'bypass_css_import'), $response['body']);
						$response['body'] = preg_replace_callback('~url\((\'|")?([^\("\']*)(\'|")?\)~', array($this, 'css_realpath_url'), $response['body']);
						$response['body'] = preg_replace_callback('~(\.\./)+~', array($this, 'css_realpath'), $response['body']);
						$response['body'] = preg_replace('~/\*.*?\*/~s', '', $response['body']);
						$response['body'] = preg_replace('~\r?\n~', '', $response['body']);
						$response['body'] = preg_replace('~(\s{2,}|\t)~', ' ', $response['body']);
						$css .= $response['body'];
					}
				}

				file_put_contents($cache_dir . '/' . $file, $css);
			}

			if ($media == 'all' && fevr_check_luvoption('async-merged-css', 1)){
				$styles[] = "<link rel='stylesheet' id='luv-merged-async-css'  href='".esc_url(apply_filters('style_loader_src', $cache_url . '/' . $file, 'luv-merged-async')) . "' type='text/css' media='async' />";
				$asyncjs = "<script>setTimeout(function(){try{var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],y=w.innerHeight||e.clientHeight||g.clientHeight,ph=document.querySelector('#page-header-wrapper[data-full-height-header=\"true\"]');if(ph){ph.style.height=y+'px';}}catch(e){console.log(e.message)}},20);setTimeout(function(){document.getElementById('luv-merged-async-css').media='all';},0);</script>";
			}
			else{
				$styles[] = "<link rel='stylesheet' id='luv-merged-".$media."-css'  href='".esc_url(apply_filters('style_loader_src', $cache_url . '/' . $file, 'luv-merged-'.$media)). "' type='text/css' media='".$media."' />";
			}
		}

		$buffer = str_replace('FEVR_MERGE_CSS_PLACEHOLDER', implode("\n", $styles).$asyncjs, $buffer);

		return $buffer;
	}

	/**
	 * Register script for later use
	 * @param array $matches
	 */
	public function register_script($matches){
		$GLOBALS['fevr_scripts_to_footer'][] = $matches[0];
		return '';
	}

	/**
	 * Register style for later use
	 * @param array $matches
	 */
	public function register_style($matches){
		$site_url 	= apply_filters('style_loader_src', site_url(), '');

		if (strpos($matches[0], $site_url) || (_check_luvoption('merge-styles-include-google-fonts', 1) && strpos($matches[0], 'fonts.googleapis.com'))){
			preg_match("~href='([^']*)'~", $matches[0], $_href);
			preg_match("~media='([^']*)'~", $matches[0], $_media);

			$media = (!empty($_media[1]) ? $_media[1] : 'all');

			$GLOBALS['luv_merge_styles'][$media][] = $_href[1];
			return '';
		}
		return $matches[0];
	}

	/**
	 * Change relative paths to absolute one
	 */
	public function css_realpath($matches){
		$url = parse_url($GLOBALS['fevr_css_realpath_basepath']);
		return $url['scheme'] . '://' . $url['host'] . trailingslashit(dirname($url['path'])) . $matches[0];
	}

	/**
	 * Change relative paths to absolute one for urls
	 */
	public function css_realpath_url($matches){
		if (preg_match('~^(http|//|\.|data)~',$matches[2])){
			return $matches[0];
		}
		$url = parse_url($GLOBALS['fevr_css_realpath_basepath']);
		return 'url(' . $matches[1] . $url['scheme'] . '://' . $url['host'] . trailingslashit(dirname($url['path'])) . trim($matches[2],"'") . $matches[1] . ')';
	}

	/**
	 * Include imported CSS
	 */
	public function bypass_css_import($matches){
		if (preg_match('~^(http|//|\.|data)~',$matches[2])){
			return $matches[0];
		}
		$url = parse_url($GLOBALS['fevr_css_realpath_basepath']);

		$response 	= wp_remote_get($url['scheme'] . '://' . $url['host'] . trailingslashit(dirname($url['path'])) . trim($matches[2],"'"), array('sslverify' => false));
		if (!is_wp_error($response)){
			$response['body'] = preg_replace_callback('~@import url\((\'|")?([^\("\']*)(\'|")?\)~', array($this, 'bypass_css_import'), $response['body']);
			$response['body'] = preg_replace_callback('~url\((\'|")?([^\("\']*)(\'|")?\)~', array($this, 'css_realpath_url'), $response['body']);
			$response['body'] = preg_replace_callback('~(\.\./)+~', array($this, 'css_realpath'), $response['body']);
			$response['body'] = preg_replace('~/\*.*?\*/~s', '', $response['body']);
			$response['body'] = preg_replace('~\r?\n~', '', $response['body']);
			$response['body'] = preg_replace('~(\s{2,}|\t)~', ' ', $response['body']);
			return $response['body'];
		}
	}


	/**
	 * Print Footer scripts placeholder
	 */
	public function scripts_to_footer_placeholder(){
		echo 'FEVR_SCRIPTS_TO_FOOTER_PLACEHOLDER';
	}

	/**
	 * Print Merge styles placeholder
	 */
	public function merge_styles_placeholder(){
		echo 'FEVR_MERGE_CSS_PLACEHOLDER';
	}

	/**
	 * Add defer attribute for footer scripts if it was set in Theme options
	 * @param string $tag
	 * @param srting $handle
	 * @return string
	 */
	public function defer_footer_scrpits($tag, $handle) {
		// Don't defer script if it is a dependency of an other script
		if ($this->is_dependency($handle)){
			return $tag;
		}

		// Skip only jQuery if scripts to footer is enabled
		if (fevr_check_luvoption('scripts-to-footer', 1)){
			return str_replace( ' src=', ' defer src=', $tag );
		}
		// If scripts to footer is disabled defer only footer scritps
		else if (doing_action('wp_footer')){
			return str_replace( ' src=', ' defer src=', $tag );
		}
		return $tag;
	}

	/**
	 * Remove query string from JS/CSS
	 * @param string $tag
	 * @param srting $handle
	 * @return string
	 */
	public function remove_static_ver( $src ) {
		if( strpos( $src, '?ver=' ) ){
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}

	/**
	 * Remove query string from images
	 * @param string $css
	 * @return string
	 */
	public function normalize_vc_custom_css($meta_value, $object_id, $meta_key, $single ){
		global $fevr_get_metadata_filtering;
		if ($fevr_get_metadata_filtering !== true && ($meta_key == '_wpb_shortcodes_custom_css' || $meta_key == '_wpb_post_custom_css')){
			$fevr_get_metadata_filtering = true;
			$meta_value = preg_replace('~\.(jpe?g|gif|png)\?id=(\d*)~',".$1", get_post_meta( $object_id, $meta_key, true ));
			$fevr_get_metadata_filtering = false;
			return $meta_value;
		}
		return $meta_value;
	}

	/**
	 * Check is given handle dependency of an other script
	 * use for defer footer scripts
	 */
	public function is_dependency($handle){
		global $wp_scripts;

		foreach ($wp_scripts->registered as $script){
			if (in_array($handle, $script->deps)){
				return true;
			}
		}

		return false;
	}

	/**
	 * Lazy load images
	 * @param array $args
	 * @return array
	 */
	public function lazy_load_images($args, $attachment, $size){
		$upload_dir = wp_upload_dir();
		$lazy_load_src = wp_get_attachment_image_src(fevr_get_attachment_id($args['src']), 'fevr_lazyload');
		if (!file_exists(str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $lazy_load_src[0]))){
			return $args;
		}
		$size = (is_array($size) ? $size : (isset($this->image_sizes[$size]) ? $this->image_sizes[$size] : array('width' => 'auto', 'height' => 'auto')));

		$args['data-src'] = $args['src'];
		$args['data-srcset'] = (isset($args['srcset']) ? $args['srcset'] : '');
		$args['data-sizes'] = (isset($args['sizes']) ? $args['sizes'] : '');
		$args['src'] = $lazy_load_src[0];
		$args['data-luv-lazy-load'] = 'true';
		$args['class'] = (isset($args['class']) ? $args['class'] : '') . ' ' . _luv_enqueue_inline_css(array('parent' => '[data-luv-lazy-load]','style' => 'width:' . $size['width'] . 'px !important;height:' . $size['height'] . 'px !important;'));
		unset($args['srcset']);
		unset($args['sizes']);
		return $args;
	}


	/**
	 * Init instant click
	 */
	function instant_click(){
			global $fevr_options;
			$fevr_options['custom-footer-html'] .=
			'<script src="'.esc_url(trailingslashit(get_template_directory_uri()).'/js/min/instantclick.min.js') . '" data-no-instant></script>'."\n".
			'<script data-no-instant>'."\n".
			'		InstantClick.on(\'change\', function() {'."\n".
			'			var evt_load = document.createEvent(\'Event\');'."\n".
			'			var evt_ready = document.createEvent(\'Event\');'."\n".
			'			evt_load.initEvent(\'load\', false, false);'."\n".
			'			evt_ready.initEvent(\'ready\', false, false);'."\n".
			'			window.dispatchEvent(evt_load);'."\n".
			'			document.dispatchEvent(evt_ready);'."\n".
			'		});'."\n".
			'		InstantClick.on(\'wait\', function() {'."\n".
			'			jQuery(\'body\').prepend(\'	<div id="loader-overlay"><div class="loader"><svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div></div>\')'."\n".
			'		});'."\n".
			'		InstantClick.init();'."\n".
			'</script>';
	}

	/**
	 * Add data-no-instant attribute for scripts
	 * @param string $tag
	 * @param srting $handle
	 * @return string
	 */
	public function  no_instant_scripts($tag, $handle) {
		if (in_array($handle, array(
				'isotope-pkgd',
				'packer-pkgd',
				'imagesloaded-pkgd',
				'wp-util',
				'wc-add-to-cart-variation',
				'woocommerce-scripts'
		))){
			return str_replace( ' src=', ' data-no-instant src=', $tag );
		}
		return $tag;
	}

	/**
	 * Add no instant attribute to links
	 * @param string $link
	 * @return string
	 */
	public function no_instant_data($link) {
		return str_replace(' href=', ' data-no-instant href=', $link);
	}

	/**
	 * Add clear cache option
	 * @param WP_Admin_Bar $admin_bar
	 */
	public function toolbar_items($admin_bar){
		$current_page = site_url(str_replace(site_url(), '', 'http'.(isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));

		if (fevr_check_luvoption('merge-styles', 1) || fevr_check_luvoption('merge-scripts', 1)){
		$admin_bar->add_menu(array(
			'id'    => 'clear-luv-cache',
			'parent' => 'site-name',
			'title' => esc_html__('Clear Performance Cache', 'fevr'),
			'href'  => esc_url(wp_nonce_url(add_query_arg('clear-luv-cache', 1, $current_page), 'clear-luv-cache')),
		 ));
		}
		if (fevr_check_luvoption('enable-cdn',1) && fevr_check_luvoption('maxcdn-alias', '','!=') && fevr_check_luvoption('maxcdn-key', '','!=') && fevr_check_luvoption('maxcdn-secret', '','!=')){
			$admin_bar->add_menu(array(
					'id'    => 'purge-luv-cdn',
					'parent' => 'site-name',
					'title' => esc_html__('Purge CDN (All zones)', 'fevr'),
					'href'  => esc_url(wp_nonce_url(add_query_arg('purge-luv-cdn', 1, $current_page), 'purge-luv-cdn')),
			));
		}
	}

	/**
	 * Clear cache
	 */
	public function clear_cache(){
		global $fevr_admin_notices;
		if (!isset($_GET['_wpnonce']) || (!wp_verify_nonce($_GET['_wpnonce'], 'clear-luv-cache') && !wp_verify_nonce($_REQUEST['_wpnonce'], 'purge-luv-cdn')) || !current_user_can('manage_options')) {
			return;
		}

		$files = glob(WP_CONTENT_DIR .'/cache/fevr/*');
		foreach((array)$files as $file){
			if(is_file($file)){
				@unlink($file);
			}
		}

		$fevr_admin_notices[] = array(
				'class' => 'info',
				'message' => esc_html__('Cache cleared', 'fevr')
		);

	}

	/**
	 * Purge CDN
	 * Currently supports MAXCDN only
	 */
	public function purge_cdn(){
		global $fevr_admin_notices;
		if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'purge-luv-cdn') || !current_user_can('manage_options')) {
			return;
		}

		// Clear cache as well
		$this->clear_cache();

		if (fevr_check_luvoption('maxcdn-alias', '','!=') && fevr_check_luvoption('maxcdn-key', '','!=') && fevr_check_luvoption('maxcdn-secret', '','!=')){
			try {
				$maxcdn = new Fevr_MaxCDN(fevr_get_luvoption('maxcdn-alias'),fevr_get_luvoption('maxcdn-key'),fevr_get_luvoption('maxcdn-secret'));

				if (!isset($_REQUEST['zone-id']) || empty($_REQUEST['zone-id'])){
				$response = json_decode($maxcdn->get('/zones.json'),true);
					if ($response['code'] == '200'){
						$zones = $response['data']['zones'];
					}
				}
				else{
					$zones = array(
							array('id' => (int)$_REQUEST['zone-id'])
					);
				}

				foreach ((array)$zones as $zone){
					$response = json_decode($maxcdn->delete('/zones/pull.json/'.$zone['id'].'/cache'));
					if (isset($response->code) && $response->code == '200'){
						$fevr_admin_notices[] = array(
								'class' => 'success',
								'message' => sprintf(esc_html__('Purge Cache: Zone Purged [id: %s]', 'fevr'), $zone['id'])
						);
					}
					else if (isset($response->error->message) && !empty($response->error->message)){
						$fevr_admin_notices[] = array(
								'class' => 'warning',
								'message' => $response->error->message
						);
					}
					else{
						$fevr_admin_notices[] = array(
								'class' => 'error',
								'message' => sprintf(esc_html__('Purge Cache: Unknown error[id: %s]', 'fevr'), $zone['id'])
						);
					}
				}
			}
			catch(Exception $e){
				$fevr_admin_notices[] = array(
						'class' => 'error',
						'message' => $e->getMessage()
				);
			}
		}
	}

	/**
	 * Add is-loading class to body
	 * @param array $classes
	 * @return array
	 */
	public function add_is_loading_class( $classes ) {
		$classes[] = 'is-loading';
		return $classes;
	}

	/**
	 * Extend is_admin to check if current page is login or register page
	 */
	public function is_admin() {
    	return (is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' )) || (isset($_GET['vc_editable']) && $_GET['vc_editable'] == 'true') );
	}

	/**
	 * Get image sizes
	 */
	public function get_image_sizes() {
		global $_wp_additional_image_sizes;

		$this->image_sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$this->image_sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$this->image_sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$this->image_sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$this->image_sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}
	}


}

?>
