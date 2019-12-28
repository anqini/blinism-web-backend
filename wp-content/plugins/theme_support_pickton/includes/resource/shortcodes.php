<?php
$bunch_sc = array();

$bunch_sc['bunch_services_4_column']	=	array(
					"name" => __("Services 4 Col", BUNCH_NAME),
					"base" => "bunch_services_4_column",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Services 4 Col.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'services_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_what_we_do']	=	array(
					"name" => __("What We Do", BUNCH_NAME),
					"base" => "bunch_what_we_do",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show What We Do.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Features Text", BUNCH_NAME),
						   "param_name" => "feature_str",
						   "description" => __("Enter the Section Features to show.", BUNCH_NAME)
						),
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Image", BUNCH_NAME),
						   "param_name" => "img",
						   "description" => __("Enter the Section Image to show.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_fun_facts']	=	array(
			"name" => __("Fun Facts", BUNCH_NAME),
			"base" => "bunch_fun_facts",
			"class" => "",
			"category" => __('Ecomanic', BUNCH_NAME),
			"icon" => 'icon-wpb-layer-shape-text' ,
			"as_parent" => array('only' => 'bunch_fun_fact'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => false,
			'description' => __('Add Fun Facts to theme', BUNCH_NAME),
			"params" => array(
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Bg Image', BUNCH_NAME ),
						   "param_name" => "bg_img",
						   "description" => __('Enter section Background Image To Show', BUNCH_NAME )
						),
			
			),
			"js_view" => 'VcColumnView'
		);
$bunch_sc['bunch_fun_fact']	=	array(
			"name" => __("Fact Counter", BUNCH_NAME),
			"base" => "bunch_fun_fact",
			"class" => "",
			"category" => __('Ecomanic', BUNCH_NAME),
			"icon" => 'icon-wpb-layer-shape-text' ,
			"as_child" => array('only' => 'bunch_fun_facts'),// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => true,
			'description' => __('Add Fact Counter.', BUNCH_NAME),
			"params" => array(
				array(
				   "type" => "textfield",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Number", BUNCH_NAME),
				   "param_name" => "num",
				   "description" => __("Enter the Number to show.", BUNCH_NAME)
				),
				array(
				   "type" => "textfield",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Number Stop", BUNCH_NAME),
				   "param_name" => "num_stop",
				   "description" => __("Enter the Number Stop to show.", BUNCH_NAME)
				),
				array(
				   "type" => "textfield",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Text", BUNCH_NAME),
				   "param_name" => "text",
				   "default"  => "",
				   "description" => __("Enter the Section Text to show.", BUNCH_NAME)
				),
				
			),
		);				
$bunch_sc['bunch_gallery']	=	array(
					"name" => __("Gallery", BUNCH_NAME),
					"base" => "bunch_gallery",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Gallery.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'gallery_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_blog']	=	array(
					"name" => __("Our Blog", BUNCH_NAME),
					"base" => "bunch_blog",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Blog Post.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Text Limit to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);	
$bunch_sc['bunch_clients']	=	array(
					"name" => __("Clients", BUNCH_NAME),
					"base" => "bunch_clients",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Clients.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Describtion', BUNCH_NAME ),
						   "param_name" => "describtion",
						   "description" => __('Enter The Description for Own Help.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_services_3_column']	=	array(
					"name" => __("Services 3 Col", BUNCH_NAME),
					"base" => "bunch_services_3_column",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Services 3 Col.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'services_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "checkbox",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Padding Adjustment', BUNCH_NAME ),
						   "param_name" => "no_padding",
						   'value' => array(__('Padding Adjustment', BUNCH_NAME )=>true),
						   "description" => __('Choose whether you want to show No Padding at Top', BUNCH_NAME )
						),
					)
				);	
$bunch_sc['bunch_history']	=	array(
					"name" => __("Our History", BUNCH_NAME),
					"base" => "bunch_history",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Our History.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Sub Title', BUNCH_NAME ),
						   "param_name" => "sub_title",
						   "description" => __('Enter The Sub Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Content', BUNCH_NAME ),
						   "param_name" => "content",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link2",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text2",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Image', BUNCH_NAME ),
						   "param_name" => "img",
						   "description" => __('Enter The Image to Show.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_checkout_services']	=	array(
					"name" => __("Checkout Services", BUNCH_NAME),
					"base" => "bunch_checkout_services",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Checkout Services.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Image', BUNCH_NAME ),
						   "param_name" => "img",
						   "description" => __('Enter The Section Image to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'services_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);	
$bunch_sc['bunch_appointment']	=	array(
					"name" => __("Appointment", BUNCH_NAME),
					"base" => "bunch_appointment",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Appointment.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Image', BUNCH_NAME ),
						   "param_name" => "img",
						   "description" => __('Enter The Section Image to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Appointment Title', BUNCH_NAME ),
						   "param_name" => "title2",
						   "description" => __('Enter The Appointment Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Appointment Text', BUNCH_NAME ),
						   "param_name" => "text2",
						   "description" => __('Enter The Appointment Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea_raw_html",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Contact Form7 Shortcode', BUNCH_NAME ),
						   "param_name" => "appointment_form",
						   "description" => __('Enter Contact Form7 Shortcode', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Street Address', BUNCH_NAME ),
						   "param_name" => "street_address",
						   "description" => __('Enter The Street Address to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Address', BUNCH_NAME ),
						   "param_name" => "address",
						   "description" => __('Enter The Address to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Phone', BUNCH_NAME ),
						   "param_name" => "phone",
						   "description" => __('Enter The Phone Number to Show.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_gallery_slider']	=	array(
					"name" => __("Gallery Slider", BUNCH_NAME),
					"base" => "bunch_gallery_slider",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Gallery Slider.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'gallery_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);	
$bunch_sc['bunch_feature_services']	=	array(
					"name" => __("Features Services", BUNCH_NAME),
					"base" => "bunch_feature_services",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Features Services.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Sub Title', BUNCH_NAME ),
						   "param_name" => "sub_title",
						   "description" => __('Enter The Sub Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Features Text", BUNCH_NAME),
						   "param_name" => "feature_str",
						   "description" => __("Enter the Section Features to show.", BUNCH_NAME)
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link2",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text2",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Image", BUNCH_NAME),
						   "param_name" => "img",
						   "description" => __("Enter the Section Image to show.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_our_services']	=	array(
					"name" => __("Our Services", BUNCH_NAME),
					"base" => "bunch_our_services",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Our Services.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'services_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);	
$bunch_sc['bunch_banner']	=	array(
					"name" => __("Banner", BUNCH_NAME),
					"base" => "bunch_banner",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Banner.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Sub Title', BUNCH_NAME ),
						   "param_name" => "sub_title",
						   "description" => __('Enter The Sub Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Image', BUNCH_NAME ),
						   "param_name" => "img",
						   "description" => __('Enter The Image to Show.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_testimonial']	=	array(
					"name" => __("Testimonial", BUNCH_NAME),
					"base" => "bunch_testimonial",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Testimonial.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'testimonials_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);	
$bunch_sc['bunch_team']	=	array(
					"name" => __("Team", BUNCH_NAME),
					"base" => "bunch_team",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Team.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'team_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_banner_two']	=	array(
					"name" => __("Services Banner", BUNCH_NAME),
					"base" => "bunch_banner_two",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Services Page Banner.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Image', BUNCH_NAME ),
						   "param_name" => "img",
						   "description" => __('Enter The Image to Show.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_banner_three']	=	array(
					"name" => __("Services Banner V2", BUNCH_NAME),
					"base" => "bunch_banner_three",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Services Page Banner V2.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Image', BUNCH_NAME ),
						   "param_name" => "img",
						   "description" => __('Enter The Image to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Sub Title', BUNCH_NAME ),
						   "param_name" => "sub_title",
						   "description" => __('Enter The Sub Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link2",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text2",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
					)
				);				
$bunch_sc['bunch_we_can_do']	=	array(
					"name" => __("Growing Plants", BUNCH_NAME),
					"base" => "bunch_we_can_do",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Growing Plants.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Sub Title', BUNCH_NAME ),
						   "param_name" => "sub_title",
						   "description" => __('Enter The Sub Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_accordian']	=	array(
					"name" => __("Accordian", BUNCH_NAME),
					"base" => "bunch_accordian",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Accordian.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'services_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_skills']	=	array(
			"name" => __("Skills", BUNCH_NAME),
			"base" => "bunch_skills",
			"class" => "",
			"category" => __('Ecomanic', BUNCH_NAME),
			"icon" => 'icon-wpb-layer-shape-text' ,
			"as_parent" => array('only' => 'bunch_skill_graph'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => false,
			'description' => __('Add Skills to theme', BUNCH_NAME),
			"params" => array(
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter section Title To Show', BUNCH_NAME )
						),
			
			),
			"js_view" => 'VcColumnView'
		);
$bunch_sc['bunch_skill_graph']	=	array(
			"name" => __("Skill Graph", BUNCH_NAME),
			"base" => "bunch_skill_graph",
			"class" => "",
			"category" => __('Ecomanic', BUNCH_NAME),
			"icon" => 'icon-wpb-layer-shape-text' ,
			"as_child" => array('only' => 'bunch_skills'),// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => true,
			'description' => __('Add Skill Graph.', BUNCH_NAME),
			"params" => array(
				array(
				   "type" => "textfield",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Title", BUNCH_NAME),
				   "param_name" => "title",
				   "description" => __("Enter the Title to show.", BUNCH_NAME)
				),
				array(
				   "type" => "textfield",
				   "holder" => "div",
				   "class" => "",
				   "heading" => __("Number", BUNCH_NAME),
				   "param_name" => "num",
				   "description" => __("Enter the Number to fill bar to show.", BUNCH_NAME)
				),
				
			),
		);				
$bunch_sc['bunch_our_services_v2']	=	array(
					"name" => __("Our Services V2", BUNCH_NAME),
					"base" => "bunch_our_services_v2",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Our Services V2.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Limit Of Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'services_category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);	
$bunch_sc['bunch_feature_services_2']	=	array(
					"name" => __("Features Services V2", BUNCH_NAME),
					"base" => "bunch_feature_services_2",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Features Services V2.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "attach_image",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Image", BUNCH_NAME),
						   "param_name" => "img",
						   "description" => __("Enter the Section Image to show.", BUNCH_NAME)
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Sub Title', BUNCH_NAME ),
						   "param_name" => "sub_title",
						   "description" => __('Enter The Sub Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Features Text", BUNCH_NAME),
						   "param_name" => "feature_str",
						   "description" => __("Enter the Section Features to show.", BUNCH_NAME)
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Link', BUNCH_NAME ),
						   "param_name" => "btn_link2",
						   "description" => __('Enter The Button Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Button Text', BUNCH_NAME ),
						   "param_name" => "btn_text2",
						   "description" => __('Enter The Button Text to Show.', BUNCH_NAME )
						),
						
					)
				);
$bunch_sc['bunch_gallery_project']	=	array(
					"name" => __("Gallery Project", BUNCH_NAME),
					"base" => "bunch_gallery_project",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Gallery Project.', BUNCH_NAME),
					"params" => array(
					
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Projects to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Excluded Categories ID', BUNCH_NAME ),
						   "param_name" => "exclude_cats",
						   "description" => __('Enter Excluded Categories ID seperated by commas(13,14).', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						
					)
				);
$bunch_sc['bunch_map']	=	array(
					"name" => __("Google map", BUNCH_NAME),
					"base" => "bunch_map",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Google map.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Lattitude', BUNCH_NAME ),
						   "param_name" => "lat",
						   "description" => __('Enter Lattitude for map', BUNCH_NAME ),
						   "default" => '-37.817085',
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Longitude', BUNCH_NAME ),
						   "param_name" => "long",
						   "description" => __('Enter Longitude for map', BUNCH_NAME ),
						   "default" => '144.955631',
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Mark Lattitude', BUNCH_NAME ),
						   "param_name" => "mark_lat",
						   "description" => __('Enter Mark Lattitude for map', BUNCH_NAME ),
						   "default" => '-37.817085',
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Mark Longitude', BUNCH_NAME ),
						   "param_name" => "mark_long",
						   "description" => __('Enter Mark Longitude for map', BUNCH_NAME ),
						   "default" => '144.955631',
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Mark Title', BUNCH_NAME ),
						   "param_name" => "mark_title",
						   "description" => __('Enter Mark Title for map', BUNCH_NAME ),
						   "default" => 'Envato',
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Mark Address', BUNCH_NAME ),
						   "param_name" => "mark_address",
						   "description" => __('Enter Mark Address for map', BUNCH_NAME ),
						   "default" => ' Melbourne VIC 3000, Australia',
						),
					)
				);	
$bunch_sc['bunch_contact_form']	=	array(
					"name" => __("Contact Form", BUNCH_NAME),
					"base" => "bunch_contact_form",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Contact Form.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Form Title', BUNCH_NAME ),
						   "param_name" => "form_title",
						   "description" => __('Enter The Form Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea_raw_html",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Contact Form7 Shortcode', BUNCH_NAME ),
						   "param_name" => "contact_form",
						   "description" => __('Enter Contact Form7 Shortcode', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Section Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textarea",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text', BUNCH_NAME ),
						   "param_name" => "text",
						   "description" => __('Enter The Section Text to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Email Link', BUNCH_NAME ),
						   "param_name" => "email_link",
						   "description" => __('Enter The Email Link to Show.', BUNCH_NAME )
						),
						
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Email Address', BUNCH_NAME ),
						   "param_name" => "email",
						   "description" => __('Enter The Email Address to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Phone', BUNCH_NAME ),
						   "param_name" => "phone",
						   "description" => __('Enter The Phone to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Fax', BUNCH_NAME ),
						   "param_name" => "fax",
						   "description" => __('Enter The Fax Number to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Website Link', BUNCH_NAME ),
						   "param_name" => "web_link",
						   "description" => __('Enter The Website Link to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Website Address', BUNCH_NAME ),
						   "param_name" => "website",
						   "description" => __('Enter The Website Address to Show.', BUNCH_NAME )
						),
					)
				);
$bunch_sc['bunch_blog_2_col']	=	array(
					"name" => __("Blog 2 Col", BUNCH_NAME),
					"base" => "bunch_blog_2_col",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Show Blog 2 Col.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Text Limit', BUNCH_NAME ),
						   "param_name" => "text_limit",
						   "description" => __('Enter The Text Limit to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'category', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);
$bunch_sc['bunch_product_carousel']	=	array(
					"name" => __("Product Carousel", BUNCH_NAME),
					"base" => "bunch_product_carousel",
					"class" => "",
					"category" => __('Ecomanic', BUNCH_NAME),
					"icon" => 'fa-briefcase' ,
					'description' => __('Product Carousel.', BUNCH_NAME),
					"params" => array(
					   	
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Title', BUNCH_NAME ),
						   "param_name" => "title",
						   "description" => __('Enter The Title to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "textfield",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __('Number', BUNCH_NAME ),
						   "param_name" => "num",
						   "description" => __('Enter Number of Slides to Show.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __( 'Category', BUNCH_NAME ),
						   "param_name" => "cat",
						   "value" => array_flip( (array)bunch_get_categories( array( 'taxonomy' => 'product_cat', 'hide_empty' => FALSE ), true ) ),
						   "description" => __( 'Choose Category.', BUNCH_NAME )
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order By", BUNCH_NAME),
						   "param_name" => "sort",
						   'value' => array_flip( array('select'=>__('Select Options', BUNCH_NAME),'date'=>__('Date', BUNCH_NAME),'title'=>__('Title', BUNCH_NAME) ,'name'=>__('Name', BUNCH_NAME) ,'author'=>__('Author', BUNCH_NAME),'comment_count' =>__('Comment Count', BUNCH_NAME),'random' =>__('Random', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
						array(
						   "type" => "dropdown",
						   "holder" => "div",
						   "class" => "",
						   "heading" => __("Order", BUNCH_NAME),
						   "param_name" => "order",
						   'value' => array_flip(array('select'=>__('Select Options', BUNCH_NAME),'ASC'=>__('Ascending', BUNCH_NAME),'DESC'=>__('Descending', BUNCH_NAME) ) ),			
						   "description" => __("Enter the sorting order.", BUNCH_NAME)
						),
					)
				);
																																																																
/*----------------------------------------------------------------------------*/
$bunch_sc = apply_filters( '_bunch_shortcodes_array', $bunch_sc );
	
return $bunch_sc;