<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

$wrapper_attributes = array();

// Tracking
if ($atts['ga_inview'] == 'true'){
	$css_classes[]	= 'luv-ga-inview';
	$wrapper_attributes[]		= 'data-event-category="'.$atts['ga_event_category'].'"';
	$wrapper_attributes[]		= 'data-event-action="'.$atts['ga_event_action'].'"';
	$wrapper_attributes[]		= 'data-event-label="'.$atts['ga_event_label'].'"';
	$wrapper_attributes[]		= 'data-event-value="'.$atts['ga_event_value'].'"';
}

// Hover effect
$column_overlay = $luv_hover_styles = $has_column = '';
if (isset($atts['column_overlay']) && $atts['column_overlay'] == 'true'){
	$has_column = ' has-column-overlay';
	if (!empty($atts['column_effect_text_hover'])){
		$css_classes[] = _luv_enqueue_inline_css(array(
			'parent' => 'html .wpb_column.vc_column_container',
			'child' => array(':hover *' => (!empty($atts['column_effect_text_hover']) ? 'color:' . $atts['column_effect_text_hover'] . ' !important' : '')),
		));
	}
	$column_overlay = '<div class="luv-column-overlay ' . _luv_enqueue_inline_css(array(
			'style' => (!empty($atts['column_effect_default']) ? 'background:' . $atts['column_effect_default'] : ''),
			'child' => array(
					':hover' => (!empty($atts['column_effect_hover']) ? 'background:' . $atts['column_effect_hover'] : '')
			)
	)) .' '. _luv_enqueue_inline_css(array(
			'parent' => '.vc_column-inner:hover > ',
			'style' => (!empty($atts['column_effect_hover']) ? 'background:' . $atts['column_effect_hover'] : '')
	)) . '"></div>';

}

// Column link
$column_link_open = $column_link_close = '';
if (isset($atts['column_link']) && !empty($atts['column_link'])){
	$column_link_open	= '<a href="'.esc_url($atts['column_link']).'" class="'._luv_enqueue_inline_css(array('style' => 'width:100%', 'child' => array(' *' => 'cursor: pointer !important;'))).'">';
	$column_link_close	= '</a>';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= $column_link_open;
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . $has_column . '">';
$output .= $column_overlay;
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= $column_link_close;
$output .= '</div>';

echo $output;
