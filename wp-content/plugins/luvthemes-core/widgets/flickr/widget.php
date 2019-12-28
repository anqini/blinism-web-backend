<?php

/**
 * Extend WP_Widget
 * @author null
 *
 */
class Luv_Flickr_Widget extends WP_Widget {
 
    function __construct() {         
    	$widget_ops = array( 'classname' => 'flickr_widget', 'description' => esc_html__('Show your favorite Flickr photos!', 'fevr') );
    	parent::__construct( 'luv-flickr-widget', esc_html__( 'Luvthemes Flickr Widget', 'fevr' ), $widget_ops );
    }
 
    /**
     * Widget settings form
     * @param object $instance
     */
    function form($instance) {
    	$instance = wp_parse_args( (array) $instance, array('title' => 'Flickr Photos', 'number' => 5, 'flickr_id' => '') );
    	
    	$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    	$flickr_id = isset($instance['flickr_id']) ? $instance['flickr_id'] : '';
    	$flickr_api_key = isset($instance['flickr_api_key']) ? $instance['flickr_api_key'] : '';
    	$number = isset($instance['number']) ? absint($instance['number']) : '';
    	
    	?>
    	            <p>
    	                <label for="<?php echo $this->get_field_id('title'); ?>">
    	                   <?php esc_html_e('Title:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    	            </p>
    	 
    	 
    	 
    	            <p>
    	                <label for="<?php echo $this->get_field_id('flickr_id'); ?>">
    	                   <?php esc_html_e('Flickr username:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" />
    	 
    	            </p>
     	            <p>
    	                <label for="<?php echo $this->get_field_id('flickr_api_key'); ?>">
    	                   <?php esc_html_e('Flickr API key:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('flickr_api_key'); ?>" name="<?php echo $this->get_field_name('flickr_api_key'); ?>" type="text" value="<?php echo $flickr_api_key; ?>" />
    	 
    	            </p>   	 
    	            <p>
    	 
    	            <p>
    	                <label for="<?php echo $this->get_field_id('number'); ?>">
    	                   <?php esc_html_e('Number of Photos:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" min="1" value="<?php echo $number; ?>" />
    	            </p>
    	 
    	 
    	    <?php
    }
 
    /**
     * Update settings
     * @param object $new_instance
     * @param object $old_instance
     * @return object
     */
    function update($new_instance, $old_instance) {
		$instance=$old_instance;
		
		$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$instance['flickr_id']= isset($new_instance['flickr_id']) ? $new_instance['flickr_id'] : '';
		$instance['flickr_api_key']= isset($new_instance['flickr_api_key']) ? $new_instance['flickr_api_key'] : '';
		$instance['number'] = isset($new_instance['number']) ? absint($new_instance['number']) : '';
		return $instance;
    }
 
    /**
     * Display widget
     * @param array $args
     * @param object $instance
     */
    function widget($args, $instance) {
		extract($args);
		
		$title = apply_filters('widget_title', $instance['title']);
		$flickr_id = trim($instance['flickr_id']);
		$flickr_api_key = trim($instance['flickr_api_key']);
		$number = absint( $instance['number'] );
		
		echo $before_widget;
			 
		if(!empty($title)){
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		
		wp_enqueue_script( 'flickr', trailingslashit(get_template_directory_uri()) . 'js/flickr.js', array('jquery'), LUVTHEMES_CORE_VER, true );
		
		echo '<div class="luv-flickr-container" data-username="'.esc_attr($flickr_id).'" data-api-key="'.esc_attr($flickr_api_key).'" data-items="'.(int)$number.'"></div>';
		
		echo $after_widget;
    }

 
}
 
 
add_action( 'widgets_init', 'luv_flickr_widget' );
function luv_flickr_widget() {
    register_widget('Luv_Flickr_Widget');
}
?>