<?php
/*
Plugin Name: Theme Support
Plugin URI: http://themeforest.net/
Description: This plugin is compatible with this wordpress themes. 
Author: Muhibbur Rashid
Author URI: http://themebunch.com
Version: 1.0
Text Domain: BUNCH_NAME
*/
if( !defined( 'BUNCH_TH_ROOT' ) ) define('BUNCH_TH_ROOT', plugin_dir_path( __FILE__ ));
if( !defined( 'BUNCH_TH_URL' ) ) define( 'BUNCH_TH_URL', plugins_url( '', __FILE__ ) );
if( !defined( 'BUNCH_NAME' ) ) define( 'BUNCH_NAME', 'pickton' );
include_once( 'includes/loader.php' );
function pickton_bunch_widget_init2()
{
	global $wp_registered_sidebars;
	$theme_options = _WSH()->option();
	if( class_exists( 'Bunch_About_us' ) )register_widget( 'Bunch_About_us' );
	if( class_exists( 'Bunch_Latest_News' ) )register_widget( 'Bunch_Latest_News' );
	if( class_exists( 'Bunch_Popular_Post' ) )register_widget( 'Bunch_Popular_Post' );
	if( class_exists( 'Bunch_servies' ) )register_widget( 'Bunch_servies' );
	if( class_exists( 'Bunch_Brochures' ) )register_widget( 'Bunch_Brochures' );
	if( class_exists( 'Bunch_Our_Team' ) )register_widget( 'Bunch_Our_Team' );
}
add_action( 'widgets_init', 'pickton_bunch_widget_init2' );	