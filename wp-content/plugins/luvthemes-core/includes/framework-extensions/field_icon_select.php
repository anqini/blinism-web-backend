<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'ReduxFramework_icon_select' ) ) {
    class ReduxFramework_icon_select {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since ReduxFramework 1.0.0
         */
        function __construct( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field  = $field;
            $this->value  = $value;
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since ReduxFramework 1.0.0
         */
        function render() {
            global $luv_iconset;

            if ( ! empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
                if ( empty( $this->field['args'] ) ) {
                    $this->field['args'] = array();
                }

                $this->field['options'] = $this->parent->get_wordpress_data( $this->field['data'], $this->field['args'] );
                $this->field['class'] .= " hasOptions ";
            }

            if ( empty( $this->value ) && ! empty( $this->field['data'] ) && ! empty( $this->field['options'] ) ) {
                $this->value = $this->field['options'];
            }

            $icons = $options = '';
            foreach(apply_filters('luv_iconset', $luv_iconset) as $key=>$iconset){
                    $options .= '<option value=' . $key . '>' . $key . '</option>';
                    $icons .= '<ul class="luv-iconset' . (isset($not_first) ? ' luv-hidden' : '') .'" data-iconset="'.$key.'">';
                    foreach ($iconset as $icon){
                          $icons .= '<li class="redux"><i class="'.$icon.'"></i></li>';
                    }
                    $icons .= '</ul>';
                    $not_first = true;
             }

             if (!empty($this->value)){
                   $current = '<div class="icon-preview" data-default="'.(isset($this->field['default']) ? esc_attr($this->field['default']) : '').'"><i class="'.esc_attr($this->value).'"></i></div>';
             }
             else if (isset($this->field['default'])){
                   $current = '<div class="icon-preview" data-default="'.esc_attr($this->field['default']).'"><i class="'.esc_attr($this->field['default']).'"></i></div>';
             }
             else {
                   $current =  '<div class="icon-preview" data-default="'.(isset($this->field['default']) ? esc_attr($this->field['default']) : '').'"><i class=""></i></div>';;
             }

             echo '<div class="input_wrapper">';
             echo $current;
             echo '<select class="luv-iconset-filter">';
             echo $options;
             echo '</select></div>';
             echo '<input type="text" class="luv-icon-filter" placeholder="' . esc_html__('Search for icons', 'fevr') . '">';

             echo $icons;

             echo '<input type="hidden" class="icon-holder" id="' . $this->field['id'].'" name="' . $this->field['name'] . $this->field['name_suffix'].'" value="' . esc_attr( $this->value ) . '">';
             echo '</div>';
      }

    }
}
