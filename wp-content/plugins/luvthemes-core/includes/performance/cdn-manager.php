<?php
class Fevr_CDN_Manager{

	public $cdn = array();
	
	public $site_url = '';
	
	public function __construct(){
		//Use CDN only on frontend
		if (is_admin()){
			return false;
		}
		
		$this->site_url = preg_replace('~http(s)?://~','',site_url());

		// Set CDN hostnames
		$this->cdn['css']	= preg_replace('~http(s)?://~','',fevr_get_luvoption('cdn-hostname-master'));
		$this->cdn['js']	= (fevr_check_luvoption('cdn-hostname-slot-1','','!=') ? preg_replace('~http(s)?://~','',fevr_get_luvoption('cdn-hostname-slot-1')) : $this->cdn['css']);
		$this->cdn['media']	= (fevr_check_luvoption('cdn-hostname-slot-2','','!=') ? preg_replace('~http(s)?://~','',fevr_get_luvoption('cdn-hostname-slot-2')) : $this->cdn['css']);

		if (isset($_SERVER['HTTPS'])){
			if (fevr_check_luvoption('enable-cdn-ssl','1','!=')){
				return false;
			}
			
			$ssl_master = false;
			if (fevr_check_luvoption('cdn-hostname-master-ssl','','!=')){
				$this->cdn['css'] = preg_replace('~http(s)?://~','',fevr_get_luvoption('cdn-hostname-master-ssl'));
				$ssl_master = true;
			}
			
			$ssl_slot_1 = false;
			if (fevr_check_luvoption('cdn-hostname-slot-1-ssl','','!=')){
				$this->cdn['js'] = preg_replace('~http(s)?://~','',fevr_get_luvoption('cdn-hostname-slot-1-ssl'));
				$ssl_slot_1 = true;
			}
			else if($ssl_master){
				$this->cdn['js'] = $this->cdn['css'];
			}
		
			if (fevr_check_luvoption('cdn-hostname-slot-2-ssl','','!=')){
				$this->cdn['media'] = preg_replace('~http(s)?://~','',fevr_get_luvoption('cdn-hostname-slot-2-ssl'));
			}
			else if($ssl_slot_1){
				$this->cdn['media'] = $this->cdn['js'];
			}
			else if ($ssl_master){
				$this->cdn['media'] = $this->cdn['css'];
			}
		}
		
		if (empty($this->cdn['css'])){
			return false;
		}
		
		add_filter('script_loader_src', array($this, 'js'),0,2);
		add_filter('style_loader_src', array($this, 'css'),0,2);
		add_action('init', array($this, 'media'));
	}

	/**
	 * Start output buffering for media files
	 */
	public function media(){
		ob_start(array($this, 'media_callback'));
	}
	
	/**
	 * Replace media files callback
	 */
	public function media_callback($buffer){
		return preg_replace('~'.$this->site_url.'([^"\'\s]*)\.(jpe?g|png|gif|swf|flv|mpeg|mpg|mpe|3gp|mov|avi|wav|flac|mp2|mp3|m4a|mp4|m4p|aac)~i', $this->cdn['media']."$1.$2", $buffer);
	}	

	/**
	 * Change hostname for js files
	 */
	public function js($url, $handle = ''){
		return str_replace($this->site_url, $this->cdn['js'], $url);
	}
	
	/**
	 * Change hostname for css files
	 */
	public function css($url, $handle = ''){
		return str_replace($this->site_url, $this->cdn['css'], $url);
	}

}
?>