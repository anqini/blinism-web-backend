<?php

/**
 * Extend WP_Widget
 * @author null
 *
 */
class Luv_Shortcode_Widget extends WP_Widget {
 
    function __construct() {         
    	$widget_ops = array( 'classname' => 'shortcode_widget', 'description' => esc_html__('Luvthemes Text Box', 'fevr') );
    	parent::__construct( 'luv-shortcode-widget', esc_html__( 'Luvthemes Text Box', 'fevr' ), $widget_ops );
    }
 
    /**
     * Widget settings form
     * @param object $instance
     */
    function form($instance) {
    	$instance = wp_parse_args( (array) $instance, array('title' => 'Text Box', 'content' => '') );
    	
    	$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    	$content = isset($instance['content']) ? $instance['content'] : '';
    	
    	?>
    	            <p>
    	                <label for="<?php echo $this->get_field_id('title'); ?>">
    	                   <?php esc_html_e('Title:', 'fevr');?>
    	                </label>
    	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    	            </p>
    	 
    	  			<p>
    	                <label for="<?php echo $this->get_field_id('content'); ?>">
    	                   <?php esc_html_e('Content:', 'fevr');?>
    	                </label>
    	                <a href="#" class="button metafield-luv-shortcode-generator"><?php esc_html_e('Luvthemes Shortcodes', 'fevr')?></a>
    	                <textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
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
		
		$instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';
		$instance['content'] = isset($new_instance['content']) ? $new_instance['content'] : '';
		return $instance;
    }
 
    /**
     * Display widget
     * @param array $args
     * @param object $instance
     */
    function widget($args, $instance) {
		extract($args);
		
		$title 		= apply_filters('widget_title', $instance['title']);
		$content	= $instance['content'];
		
		echo $before_widget;
			 
		if(!empty($title)){
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		
		echo '<div class="luv-shortcode-widget">'.do_shortcode($content).'</div>';
		
		echo $after_widget;
    }

 
}
 
 
add_action( 'widgets_init', 'luv_shortcode_widget' );
function luv_shortcode_widget() {
    register_widget('Luv_Shortcode_Widget');
}
?>