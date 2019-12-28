<?php


class Luv_VC_Autocomplete {
	
	/**
	 * Add filters for VC autocomplete
	 */
	public function __construct() {
		//Filters For autocomplete params:
		
		// Blog
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_luv_blog_ids_callback', array(
				&$this,
				'postIdAutocompleteSuggester',
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_luv_blog_ids_render', array(
				&$this,
				'idAutocompleteRender',
		), 10, 1 ); // Render exact product. Must return an array (label,value)
		
		
		//Portfolio
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_luv_portfolio_ids_callback', array(
				&$this,
				'projectIdAutocompleteSuggester',
		), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_luv_portfolio_ids_render', array(
				&$this,
				'idAutocompleteRender',
		), 10, 1 ); // Render exact product. Must return an array (label,value)
	}
	
	/**
	 * Suggester for autocomplete by id/name/title
	 * @param $query
	 * @return array - id's from projects with title
	 */
	public function postIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
				FROM {$wpdb->posts}
				WHERE post_type = 'post' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ) ), ARRAY_A );
	
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}
	
		return $results;
	}
	
	/**
	 * Suggester for autocomplete by id/name/title
	 * @param $query
	 * @return array - id's from projects with title
	 */
	public function projectIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT ID AS id, post_title AS title
				FROM {$wpdb->posts} 
				WHERE post_type = 'luv_portfolio' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ) ), ARRAY_A );
	
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' . $value['title'] : '' );
				$results[] = $data;
			}
		}
	
		return $results;
	}
	
	/**
	 * Find post by id
	 * @param $query
	 * @return bool|array
	 */
	public function idAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get project
			$project_object = get_post( (int) $query );
			if ( is_object( $project_object ) ) {

				$product_title_display = '';
				if ( ! empty( $project_object->post_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' . $project_object->post_title;
				}
	
				$product_id_display = esc_html__( 'Id', 'js_composer' ) . ': ' . $project_object->ID;
	
				$data = array();
				$data['value'] = $project_object->ID;
				$data['label'] = $product_id_display . $product_title_display;
	
				return ! empty( $data ) ? $data : false;
			}
	
			return false;
		}
	
		return false;
	}
	
}

new Luv_VC_Autocomplete();