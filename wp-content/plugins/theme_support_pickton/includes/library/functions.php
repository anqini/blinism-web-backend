<?php
if( !function_exists('_WSH') ) {
	function _WSH()
	{
		return $GLOBALS['_bunch_base'];
	}
}
function bunch_font_awesome( $code = false )
{
	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	$subject = @file_get_contents(BUNCH_TH_ROOT.'/includes/vafpress/public/css/vendor/font-awesome.css');
	if( !$subject ) return array();
	
	preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
	$icons = array();
	
	$icons[0] = __('No Icon', BUNCH_NAME);
	
	
	foreach($matches as $match){
		$value = str_replace( 'icon-', '', $match[1] );
		$newcode = $match[1];//str_replace('fa-', '', $match[1]);
		
		if( $code ) $icons[$match[1]] = stripslashes($match[2]);
		else $icons[$newcode] = ucwords(str_replace('fa-', ' ', $newcode));//$match[2];
	}
	
	return $icons;
}
if( !function_exists( 'bunch_theme_color_scheme' ) )
{
	function bunch_theme_color_scheme()
	{	
		$options = _WSH()->option();
		$dir = BUNCH_TH_ROOT;
		include_once($dir.'/includes/thirdparty/lessc.inc.php');
		$styles = _WSH()->option('custom_color_scheme');
		
		if( ! $styles ) return;	
		
		$transient = get_transient( '_bunch_color_scheme' );
		
	
		$update = ( $styles != $transient ) ? true : false;
		if(bunch_set($options, 'color_scheme') == 'custom') wp_enqueue_style( 'custom_colors', _WSH()->includes( 'assets/css/colors.css', true ) );
		//echo '<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/css/colors.css" />';
		
		//if( !$update ) return;
	
		set_transient( '_bunch_color_scheme', $styles, DAY_IN_SECONDS );
		
		$less = new lessc;
	
		$less->setVariables(array(
		  "bunch_color" => $styles,
		));
		
		// create a new cache object, and compile
		$cache = $less->cachedCompile( _WSH()->includes("/assets/css/color.less" ) );
	
		file_put_contents( _WSH()->includes('/assets/css/colors.css'), $cache["compiled"]);
		
	}
}
function bunch_get_categories($arg = false, $by_slug = false, $show_all = true)
{
	global $wp_taxonomies;
	if( ! empty($arg['taxonomy']) && ! isset($wp_taxonomies[$arg['taxonomy']]))
	{
		
	}
	
	$categories = get_terms(bunch_set( $arg, 'taxonomy', 'category' ), $arg);
	$cats = array();
	if( $show_all ) $cats[] = esc_html__( 'All Categories', 'carshire' );
	
	if( !is_wp_error( $categories ) ) {
	foreach($categories as $category)
	{
		if( $by_slug ) $cats[$category->slug] = $category->name;
		else $cats[$category->term_id] = $category->name;
	}
	}
	return $cats;
}
function bunch_get_sidebars($multi = false)
{
	global $wp_registered_sidebars;
	$sidebars = !($wp_registered_sidebars) ? get_option('wp_registered_sidebars') : $wp_registered_sidebars;
	if( $multi ) $data[] = array('value'=>'', 'label' => 'No Sidebar');
	else $data = array('' => esc_html__('No Sidebar', 'carshire'));
	foreach( (array)$sidebars as $sidebar)
	{
		if( $multi ) $data[] = array( 'value'=> bunch_set($sidebar, 'id'), 'label' => bunch_set( $sidebar, 'name') );
		else $data[bunch_set($sidebar, 'id')] = bunch_set($sidebar, 'name');
	}
	return $data;
}
if( !function_exists( 'bunch_set' ) ) {
	function bunch_set( $var, $key, $def = '' )
	{
		if( !$var ) return false;
	
		if( is_object( $var ) && isset( $var->$key ) ) return $var->$key;
		elseif( is_array( $var ) && isset( $var[$key] ) ) return $var[$key];
		elseif( $def ) return $def;
		else return false;
	}
}
function bunch_get_posts_array( $post_type = 'post', $flip = false )
{
	global $wpdb;
	$res = $wpdb->get_results( "SELECT `ID`, `post_title` FROM `" .$wpdb->prefix. "posts` WHERE `post_type` = '$post_type' AND `post_status` = 'publish' ", ARRAY_A );
	
	$return = array();
	foreach( $res as $k => $r) {
		if( $flip ) {
			if( isset( $return[bunch_set($r, 'post_title')] ) ) $return[bunch_set($r, 'post_title').$k] = bunch_set($r, 'ID');
			else $return[bunch_set($r, 'post_title')] = bunch_set( $r, 'ID' );
		}
		else $return[bunch_set($r, 'ID')] = bunch_set($r, 'post_title');
	}
	return $return;
}
function bunch_base_decode($string){
	return urldecode(base64_decode($string));
}

function bunch_user_extra( $extras = array() )
{

	_WSH()->extras = $extras;

	add_filter('user_contactmethods', 'bunch_newuserfilter' );

}

function bunch_newuserfilter($old)
{

	$array = _WSH()->extras;

	

	$new = array_merge($array, $old);

	return $new;

}
function bunch_get_font_settings( $FontSettings = array(), $StyleBefore = '', $StyleAfter = '' )
{
	$i = 1;
	$settings = _WSH()->option();
	$Style = '';
	foreach( $FontSettings as $k => $v )
	{
		if( $i == 1 || $i == 5 )
		{
			$Style .= ( bunch_set( $settings, $k )  ) ? $v.':'.bunch_set( $settings, $k ).'px;': '';
		}
		else
		{
			$Style .= ( bunch_set( $settings, $k  )  ) ? $v.':'.bunch_set( $settings, $k ).' !important;': '';
		}
		$i++;
	}
	return ( !empty( $Style ) ) ? $StyleBefore.$Style.$StyleAfter: '';
}
function bunch_share_us($PostID = '', $PostName = '')
{ ?>
	<ul class="pull-right social-icon-three clearfix">
        <li class="share"><?php esc_html_e('Share', 'pickton'); ?> <span class="fa fa-share-alt"></span></li>
        <li><a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url(get_permalink($PostID));?>"><span class="fa fa-facebook-f"></span></a></li>
        <li><a href="https://twitter.com/share?url=<?php echo esc_url(get_permalink($PostID));?>&text=<?php echo esc_attr($post_slug=$PostName); ?>"><span class="fa fa-twitter"></span></a></li>
        <li><a href="http://www.linkedin.com/shareArticle?url=<?php echo esc_url(get_permalink($PostID));?>&title=<?php echo esc_attr($post_slug=$PostName); ?>"><span class="fa fa-linkedin"></span></a></li>
        <li><a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink($PostID));?>"><span class="fa fa-google-plus"></span></a></li>
    </ul>
<?php }