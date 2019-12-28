<?php
class BUNCH_Shortcodes
{

	/**
	 * [$keys description]
	 *
	 * @var [type]
	 */
	public $keys;

	/**
	 * [$base description]
	 *
	 * @var string
	 */
	protected $base = '';

	/**
	 * [$_dir description]
	 *
	 * @var string
	 */
	protected $_dir = '';

	/**
	 * [$_s_dir description]
	 *
	 * @var string
	 */
	protected $_s_dir = '';

	/**
	 * [$_wp_head description]
	 *
	 * @var string
	 */
	protected $_wp_head = '';


	/**
	 * [__construct description]
	 */
	function __construct() {

		$this->king_add();

		$this->_dir = get_template_directory();
		$this->_s_dir = get_stylesheet_directory();

	}


	/**
	 * [add description]
	 */
	function add() {

		$this->keys = include( BUNCH_TH_ROOT.'/includes/resource/shortcodes.php' );

		foreach ( $this->keys as $key => $value ) {

			if ( function_exists( 'vc_map' ) ) {
				vc_map( $value );
			}

			if ( function_exists( '_wow_themes_add_stcode' ) ) {
				_wow_themes_add_stcode( $key, array( $this, 'vc_add' ) );
			}
		}
	}

	/**
	 * [king_add description]
	 *
	 * @return void [description]
	 */
	function king_add() {

		global $kc;

		$this->keys = include( BUNCH_TH_ROOT.'/includes/resource/king.php' );

		$this->keys = apply_filters( 'rofayda_king_shortcodes_array', $this->keys );

		foreach ( $this->keys as $key => $value ) {

			
			add_shortcode( $key, array( $this, 'king_add_stcode' ) );
			

			if ( is_object( $kc ) ) {
				$this->king( $key, $value );
			}
		}

	}

	function vc_add( $atts, $contents = null, $tag )
	{
		//echo $tag;
		$tag_attr = bunch_set(bunch_set($this->keys, $tag), 'params' );

		$vars = array();

		if( $tag_attr )
		foreach( $tag_attr as $k => $v )
		{
			$vars[bunch_set($v, 'param_name')] = (bunch_set($v, 'param_name') !== 'checkbox' && !is_array(bunch_set($v, 'value')) ) ? bunch_set($v, 'value') : '';
		}

		extract( shortcode_atts( $vars, $atts ) );

		ob_start();

		$file = locate_template('includes/modules/shortcodes/'.str_replace('bunch_', '', $tag).'.php');
		//$file = locate_template('includes/modules/shortcodes/'.$tag.'.php');
		echo $file;exit;
		if($file && file_exists($file) ) 
		include( $file );

		return ob_get_clean();

	}


	/**
	 * [king_add_stcode description]
	 *
	 * @param  [type] $atts     [description].
	 * @param  [type] $contents [description].
	 * @param  [type] $tag      [description].
	 * @return [type]           [description]
	 */
	function king_add_stcode( $atts, $contents = null, $tag ) {

		add_action( 'wp_enqueue_scripts', array( $this, 'wp_head' ) );
		$tag_attr = bunch_set( bunch_set( $this->keys, $tag ), 'params' );

		$mytage = $tag;

		$vars = array();

		if ( $tag_attr ) {
		   foreach ( $tag_attr as $k => $v ) {
		
			if ( ! is_integer( $k ) ) {
			 foreach( $v as $child_array ) {
			  $vars[ bunch_set( $child_array, 'name' ) ] = ( bunch_set( $child_array, 'name' ) !== 'checkbox' && ! is_array( bunch_set( $child_array, 'value' ) ) ) ? bunch_set( $child_array, 'value' ) : '';
			 }
			} else {
			 $vars[ bunch_set( $v, 'name' ) ] = ( bunch_set( $v, 'name' ) !== 'checkbox' && ! is_array( bunch_set( $v, 'value' ) ) ) ? bunch_set( $v, 'value' ) : '';
			}
		   }
		  }

		extract( shortcode_atts( $vars, $atts ) );

		ob_start();

		$file = locate_template( 'includes/modules/shortcodes/'.str_replace( 'bunch_', '', $mytage ).'.php' );

		if ( $file && file_exists( $file ) ) {
			include( $file );
		}

		return ob_get_clean();

	}


	/**
	 * [excerpt description]
	 *
	 * @param  [type]  $str [description].
	 * @param  integer $len [description].
	 * @return [type]       [description]
	 */
	function excerpt( $str, $len = 35 ) {
		return sh_trim( $str , $len );
	}

	/**
	 * [king description]
	 *
	 * @param  [type] $key   [description].
	 * @param  [type] $array [description].
	 * @return void        [description]
	 */
	function king( $key, $array ) {
		global $kc;

		$kc->add_map( array( $key => $array ) );
	}

	/**
	 * [set_wp_head description]
	 *
	 * @param string $tag [description].
	 */
	function set_wp_head( $tag ) {

		$end = end( $this->keys );

		if ( $end === $tag ) {
			add_action( 'wp_head', array( $this, 'wp_head' ) );
		}

	}
	/**
	 * [wp_head description]
	 *
	 * @return [type] [description]
	 */
	function wp_head() {

		printr($this->_wp_head);
		if ( ! $this->_wp_head ) {
			return;
		}

		wp_add_inline_style( 'main_style', $this->_wp_head );
	}

	/**
	 * [add_style description]
	 *
	 * @param string $style [description].
	 */
	function add_style( $style = '' ) {

		if ( $style ) {
			$this->_wp_head .= "\n" . $style;
		}
	}
}
