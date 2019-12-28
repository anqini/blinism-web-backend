<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $media_bg_url
 * @var $media_bg_url_ogv
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$output = $after_output = $popup_wrapper = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper

// Tracking
if ($atts['ga_inview'] == 'true'){
	$css_classes[]	= 'luv-ga-inview';
	$wrapper_attributes[]		= 'data-event-category="'.$atts['ga_event_category'].'"';
	$wrapper_attributes[]		= 'data-event-action="'.$atts['ga_event_action'].'"';
	$wrapper_attributes[]		= 'data-event-label="'.$atts['ga_event_label'].'"';
	$wrapper_attributes[]		= 'data-event-value="'.$atts['ga_event_value'].'"';
}

// Welcome popup
if (isset($atts['welcome_popup']) && $atts['welcome_popup'] == 'true'){
	$popup_wrapper	= '<div class="luv-popup luv-welcome-popup" data-welcome-popup-delay="'.(isset($atts['welcome_popup_delay']) ? (int)$atts['welcome_popup_delay'] : 0).'">';
	$after_output	= '</div>';
}

// Exit popup
if (isset($atts['exit_popup']) && $atts['exit_popup'] == 'true') {
	$popup_wrapper	= '<div class="luv-popup luv-exit-popup">';
	$after_output	= '</div>';
}

// Header skin
if (isset($atts['header_skin']) && !empty($atts['header_skin'])) {
	$wrapper_attributes[] = 'data-midnight="'.$atts['header_skin'].'"';
}


if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = ' vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = ' vc_row-o-columns-' . $columns_placement;
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = ' vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_image = $video_bg_url;
	$css_classes[] = ' vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

$has_media_bg = ( ! empty( $video_bg ) && (!empty( $media_bg_url ) || ! empty( $media_bg_url_ogv ) ));

if ( $has_media_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_image = $media_bg_url;
	$css_classes[] = ' vc_media-bg-container';
}


if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="1.5"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= $popup_wrapper;
$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
if ($has_media_bg){
	$mp4_tag = (!empty($media_bg_url) ? '<source src="'.esc_url($media_bg_url).'">'  : '');
	$ogv_tag = (!empty($media_bg_url_ogv) ? '<source src="'.esc_url($media_bg_url_ogv).'">'  : '');
	$output .= '<video preload="auto" autoplay loop muted webkit-playsinline class="vc-media-bg">'.$mp4_tag.$ogv_tag.esc_html__('Your browser does not support the video tag.', 'fevr').'</video>';
}
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= $after_output;

echo $output;
