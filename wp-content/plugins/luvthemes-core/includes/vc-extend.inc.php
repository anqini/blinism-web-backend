<?php
// Extend Luv Container Shortcodes
if (class_exists ( 'WPBakeryShortCodesContainer' )) {
	class WPBakeryShortCode_Luv_Testimonials extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Pricing_Table extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Gmap extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Animated_List extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Page_Submenu extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Custom_Grid extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Multiscroll extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Multiscroll_Inner extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Multiscroll_Section extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Perspective_Box extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Luv_Image_Slide_Box extends WPBakeryShortCodesContainer {}

}

// Extend Luv Inner Shortcodes
if (class_exists ( 'WPBakeryShortCode' )) {
	class WPBakeryShortCode_Luv_Testimonials_Inner extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Pricing_Column extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Gmap_Address extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Animated_List_Inner extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Page_Submenu_Item extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Grid_Filter extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Perspective_Image extends WPBakeryShortCode {}
	class WPBakeryShortCode_Luv_Image_Slide_Box_Image extends WPBakeryShortCode {}
}

if (class_exists('VcShortcodeAutoloader')){
	/**
	 *  Accordion
	 */
	VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );
	class WPBakeryShortCode_Luv_Accordion extends WPBakeryShortCode_VC_Tta_Accordion {}

	VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Section' );
	class WPBakeryShortCode_Luv_Accordion_Inner extends WPBakeryShortCode_VC_Tta_Section {
		protected $controls_css_settings = 'tc vc_control-container';
		protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
		protected $backened_editor_prepend_controls = false;
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		public function contentAdmin( $atts, $content = null ) {
			$width = $el_class = '';

			$atts = shortcode_atts( $this->predefined_atts, $atts );
			extract( $atts );
			$this->atts = $atts;
			$output = '';

			for ( $i = 0; $i < count( $width ); $i ++ ) {
				$output .= '<div ' . $this->mainHtmlBlockParams( $width, $i ) . '>';
				if ( $this->backened_editor_prepend_controls ) {
					$output .= $this->getColumnControls( $this->settings( 'controls' ) );
				}
				$output .= '<div class="wpb_element_wrapper">';

				if ( isset( $this->settings['custom_markup'] ) && '' !== $this->settings['custom_markup'] ) {
					$markup = $this->settings['custom_markup'];
					$output .= $this->customMarkup( $markup );
				} else {
					$output .= $this->paramsHtmlHolders( $atts );
					$output .= '<div ' . $this->containerHtmlBlockParams( $width, $i ) . '>';
					$output .= do_shortcode( shortcode_unautop( $content ) );
					$output .= '</div>';
				}

				$output .= '</div>';
				if ( $this->backened_editor_prepend_controls ) {
					$output .= $this->getColumnControls( 'add', 'bottom-controls' );

				}
				$output .= '</div>';
			}

			return $output;
		}
	}

	/**
	 * Tabs
	 */
	VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Tabs' );
	class WPBakeryShortCode_Luv_Tab extends WPBakeryShortCode_VC_Tta_Tabs {}

	class WPBakeryShortCode_Luv_Tab_Inner extends WPBakeryShortCode_VC_Tta_Section {
		protected $controls_css_settings = 'tc vc_control-container';
		protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
		protected $backened_editor_prepend_controls = false;
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		public function contentAdmin( $atts, $content = null ) {
			$width = $el_class = '';

			$atts = shortcode_atts( $this->predefined_atts, $atts );
			extract( $atts );
			$this->atts = $atts;
			$output = '';

			for ( $i = 0; $i < count( $width ); $i ++ ) {
				$output .= '<div ' . $this->mainHtmlBlockParams( $width, $i ) . '>';
				if ( $this->backened_editor_prepend_controls ) {
					$output .= $this->getColumnControls( $this->settings( 'controls' ) );
				}
				$output .= '<div class="wpb_element_wrapper">';

				if ( isset( $this->settings['custom_markup'] ) && '' !== $this->settings['custom_markup'] ) {
					$markup = $this->settings['custom_markup'];
					$output .= $this->customMarkup( $markup );
				} else {
					$output .= $this->paramsHtmlHolders( $atts );
					$output .= '<div ' . $this->containerHtmlBlockParams( $width, $i ) . '>';
					$output .= do_shortcode( shortcode_unautop( $content ) );
					$output .= '</div>';
				}

				$output .= '</div>';
				if ( $this->backened_editor_prepend_controls ) {
					$output .= $this->getColumnControls( 'add', 'bottom-controls' );

				}
				$output .= '</div>';
			}

			return $output;
		}
	}

	/**
	 * Carousel
	 */
	class WPBakeryShortCode_Luv_Carousel extends WPBakeryShortCode_VC_Tta_Tabs {}

	class WPBakeryShortCode_Luv_Carousel_Slide extends WPBakeryShortCode_VC_Tta_Section {
		protected $controls_css_settings = 'tc vc_control-container';
		protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
		protected $backened_editor_prepend_controls = false;
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		public function contentAdmin( $atts, $content = null ) {
			$width = $el_class = '';

			$atts = shortcode_atts( $this->predefined_atts, $atts );
			extract( $atts );
			$this->atts = $atts;
			$output = '';

			for ( $i = 0; $i < count( $width ); $i ++ ) {
				$output .= '<div ' . $this->mainHtmlBlockParams( $width, $i ) . '>';
				if ( $this->backened_editor_prepend_controls ) {
					$output .= $this->getColumnControls( $this->settings( 'controls' ) );
				}
				$output .= '<div class="wpb_element_wrapper">';

				if ( isset( $this->settings['custom_markup'] ) && '' !== $this->settings['custom_markup'] ) {
					$markup = $this->settings['custom_markup'];
					$output .= $this->customMarkup( $markup );
				} else {
					$output .= $this->paramsHtmlHolders( $atts );
					$output .= '<div ' . $this->containerHtmlBlockParams( $width, $i ) . '>';
					$output .= do_shortcode( shortcode_unautop( $content ) );
					$output .= '</div>';
				}

				$output .= '</div>';
				if ( $this->backened_editor_prepend_controls ) {
					$output .= $this->getColumnControls( 'add', 'bottom-controls' );

				}
				$output .= '</div>';
			}

			return $output;
		}
	}
}

?>
