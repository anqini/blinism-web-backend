<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css_animation
 * @var $css
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_text
 */
$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrapper_attributes = $css_classes = array();

// Tooltip
if ($atts['tooltip'] == 'true'){
	global $luvthemes_core;
	
	$tooltip_custom_color = ($atts['tooltip_color_scheme'] != 'default' ? true : false);
	
	if (in_array($atts['tooltip_color_scheme'], array('accent-color-1','accent-color-2','additional-color-1','additional-color-2','additional-color-3'))){
		$atts['tooltip_background_color'] = _get_luvoption($atts['tooltip_color_scheme']);
		$atts['tooltip_color'] = _luv_adjust_color_scheme($atts['tooltip_background_color']);
	}
	
	wp_enqueue_script('tipso', LUVTHEMES_CORE_URI . 'assets/js/min/tipso.min.js', array('jquery'), LUVTHEMES_CORE_VER, true);
	$css_classes[]	= 'luv-tooltip';
	$wrapper_attributes[]		= 'data-tipso="'.$atts['tooltip_text'].'"';
	
	if ($tooltip_custom_color){
		$wrapper_attributes[]		= 'data-tooltip-background-color="'.$atts['tooltip_background_color'].'"';
		$wrapper_attributes[]		= 'data-tooltip-color="'.$atts['tooltip_color'].'"';
	}
}

// Tracking
if ($atts['ga_inview'] == 'true'){
	$css_classes[]	= 'luv-ga-inview';
	$wrapper_attributes[]		= 'data-event-category="'.$atts['ga_event_category'].'"';
	$wrapper_attributes[]		= 'data-event-action="'.$atts['ga_event_action'].'"';
	$wrapper_attributes[]		= 'data-event-label="'.$atts['ga_event_label'].'"';
	$wrapper_attributes[]		= 'data-event-value="'.$atts['ga_event_value'].'"';
}

$class_to_filter = 'wpb_text_column wpb_content_element ' . $this->getCSSAnimation( $css_animation );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$class_to_filter .= implode(' ', $css_classes);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output = '<div ' . implode( ' ', $wrapper_attributes ) . '>		
		<div class="wpb_wrapper">
			' . wpb_js_remove_wpautop( $content, true ) . '
		</div>
	</div>
';

echo $output;
