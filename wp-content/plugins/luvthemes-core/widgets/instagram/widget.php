<?php

/**
 * Extend WP_Widget
 */
class Luv_Instagram_Widget extends WP_Widget {
 
    function __construct() {         
    	$widget_ops = array( 'classname' => 'instagram_widget', 'description' => esc_html__('Show your favorite Instagram photos!', 'fevr' ) );
    	parent::__construct( 'luv-instagram-widget', esc_html__( 'Luvthemes Instagram Widget', 'fevr' ), $widget_ops );
    }
 
    /**
     * Widget settings form
     * @param object $instance
     */
    function form($instance) {
    	$instance = wp_parse_args( (array) $instance, array('title' => 'Instagram Photos', 'limit' => 5, '' => '', 'client_id' => '') );
    	
    	$title = esc_attr($instance['title']);
    	$client_id = isset($instance['client_id']) ? $instance['client_id'] : '';
    	$access_token = isset($instance['access_token']) ? $instance['access_token'] : '';
    	$user = isset($instance['user']) ? $instance['user'] : '';
    	$limit = isset($instance['limit']) ? absint($instance['limit']) : 5;
    	
    	?>
    	            <p>
    	                <label for="<?php echo $this->get_field_id('title'); ?>">
    	                   <?php esc_html_e('Title:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    	            </p>
    	            <p>
    	                <label for="<?php echo $this->get_field_id('client_id'); ?>">
    	                   <?php esc_html_e('Client ID:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('client_id'); ?>" name="<?php echo $this->get_field_name('client_id'); ?>" type="text" value="<?php echo $client_id; ?>" />
    	 
    	            </p>
					<p>
    	                <label for="<?php echo $this->get_field_id('access_token'); ?>">
    	                   <?php esc_html_e('Access token:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo $access_token; ?>" />
    	 
    	            </p>
    	            <p>
    	                <label for="<?php echo $this->get_field_id('user'); ?>">
    	                   <?php esc_html_e('User ID:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo $user; ?>" />
    	 
    	            </p>   	 
    	            <p>
    	 
    	            <p>
    	                <label for="<?php echo $this->get_field_id('limit'); ?>">
    	                   <?php esc_html_e('Number of Photos:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="1" value="<?php echo $limit; ?>" />
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
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['client_id']=$new_instance['client_id'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['user']=$new_instance['user'];
		$instance['limit']=$new_instance['limit'];
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
		$client_id = trim($instance['client_id']);
		$access_token = trim($instance['access_token']);
		$user = trim($instance['user']);
		$limit = absint( $instance['limit'] );
		
		echo $before_widget;
			 
		if(!empty($title)){
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		
		wp_enqueue_script( 'instafeed', trailingslashit(get_template_directory_uri()) . 'js/instafeed.js', array('jquery'), LUVTHEMES_CORE_VER, true );
		wp_enqueue_script( 'instawidget', trailingslashit(get_template_directory_uri()) . 'js/instawidget.js', array('jquery'), LUVTHEMES_CORE_VER, true );
		
		echo '<div id="luv-instagram-'.hash('crc32', serialize($args)).'" class="luv-instawidget" data-client-id="'.esc_attr($client_id).'" data-token="'.esc_attr($access_token).'" data-user="'.esc_attr($user).'" data-limit="'.(int)$limit.'"></div>';
		
		echo $after_widget;
    }
 
}
 
 
add_action( 'widgets_init', 'luv_instagram_widget' );
function luv_instagram_widget() {
    register_widget('Luv_Instagram_Widget');
}
?>