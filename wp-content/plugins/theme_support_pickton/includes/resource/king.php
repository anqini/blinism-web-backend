<?php
/**
 * Kingcomposer array
 *
 * @package Student WP
 * @author Shahbaz Ahmed <shahbazahmed9@hotmail.com>
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
}

$orderby = array(
				"type"			=>	"select",
				"label"			=>	esc_html__("Order By", BUNCH_NAME),
				"name"			=>	"sort",
				'options'		=>	array('date'=>esc_html__('Date', BUNCH_NAME),'title'=>esc_html__('Title', BUNCH_NAME) ,'name'=>esc_html__('Name', BUNCH_NAME) ,'author'=>esc_html__('Author', BUNCH_NAME),'comment_count' =>esc_html__('Comment Count', BUNCH_NAME),'random' =>esc_html__('Random', BUNCH_NAME) ),
				"description"	=>	esc_html__("Enter the sorting order.", BUNCH_NAME)
			);
$order = array(
				"type"			=>	"select",
				"label"			=>	esc_html__("Order", BUNCH_NAME),
				"name"			=>	"order",
				'options'		=>	(array('ASC'=>esc_html__('Ascending', BUNCH_NAME),'DESC'=>esc_html__('Descending', BUNCH_NAME) ) ),			
				"description"	=>	esc_html__("Enter the sorting order.", BUNCH_NAME)
			);
$number = array(
				"type"			=>	"text",
				"label"			=>	esc_html__('Number', BUNCH_NAME ),
				"name"			=>	"num",
				"description"	=>	esc_html__('Enter Number of posts to Show.', BUNCH_NAME )
			);
$text_limit = array(
				"type"			=>	"text",
				"label"			=>	esc_html__('Text Limit', BUNCH_NAME ),
				"name"			=>	"text_limit",
				"description"	=>	esc_html__('Enter text limit of posts to Show.', BUNCH_NAME )
			);
$title = array(
				"type"			=>	"text",
				"label"			=>	esc_html__('Title', BUNCH_NAME ),
				"name"			=>	"title",
				"description"	=>	esc_html__('Enter section title.', BUNCH_NAME )
			);
$sub_title = array(
				"type"			=>	"text",
				"label"			=>	esc_html__('Sub-Title', BUNCH_NAME ),
				"name"			=>	"sub_title",
				"description"	=>	esc_html__('Enter section subtitle.', BUNCH_NAME )
			);
$text  = array(
				"type"			=>	"textarea",
				"label"			=>	esc_html__('Text', BUNCH_NAME ),
				"name"			=>	"text",
				"description"	=>	esc_html__('Enter text to show.', BUNCH_NAME )
			);
$btn_title = array(
				"type"			=>	"text",
				"label"			=>	esc_html__('Button Title', BUNCH_NAME ),
				"name"			=>	"btn_title",
				"description"	=>	esc_html__('Enter section Button title.', BUNCH_NAME )
			);
$btn_link = array(
				"type"			=>	"text",
				"label"			=>	esc_html__('Button Link', BUNCH_NAME ),
				"name"			=>	"btn_link",
				"description"	=>	esc_html__('Enter section Button Link.', BUNCH_NAME )
			);
$bg_img = array(
				"type"			=>	"attach_image_url",
				"label"			=>	esc_html__('Background Image', BUNCH_NAME ),
				"name"			=>	"bg_img",
				'admin_label' 	=> 	false,
				"description"	=>	esc_html__('Choose Background image Url.', BUNCH_NAME )
			);

$options = array();


// Revslider Start.
$options['bunch_revslider']	=	array(
					'name' => esc_html__('Revslider', BUNCH_NAME),
					'base' => 'bunch_revslider',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show  Revolution slider.', BUNCH_NAME),
					'params' => array(
								array(
									'type' => 'dropdown',
									'label' => esc_html__('Choose Slider', BUNCH_NAME ),
									'name' => 'slider_slug',
									'options' => bunch_get_rev_slider( 0 ),
									'description' => esc_html__('Choose Slider', BUNCH_NAME )
								),
							),
						);
//Our Welcome 
$options['bunch_our_welcome']	=	array(
					'name' => esc_html__('Our Welcome', BUNCH_NAME),
					'base' => 'bunch_our_welcome',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Welcome.', BUNCH_NAME),
					'params' => array(
								$title,
								$text,
								$number,
								$text_limit,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'services_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Funfacts
$options['bunch_funfacts']	=	array(
					'name' => esc_html__('Funfacts', BUNCH_NAME),
					'base' => 'bunch_funfacts',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show Funfacts.', BUNCH_NAME),
					'params' => array(
								array(
									'type' => 'group',
									'label' => esc_html__( 'Our Funfacts', BUNCH_NAME ),
									'name' => 'funfact',
									'description' => esc_html__( 'Enter the Our Funfacts.', BUNCH_NAME ),
									'params' => array(
												array(
													'type' => 'icon_picker',
													'label' => esc_html__( 'Icon', BUNCH_NAME ),
													'name' => 'icons',
													'description' => esc_html__( 'Enter The Icon.', BUNCH_NAME ),
												),
												array(
													"type"			=>	"text",
													"label"			=>	esc_html__('Counter Start', BUNCH_NAME ),
													"name"			=>	"counter_start",
													"description"	=>	esc_html__('Enter The Counter Start.', BUNCH_NAME )
												),
												array(
													"type"			=>	"text",
													"label"			=>	esc_html__('Counter Stop', BUNCH_NAME ),
													"name"			=>	"counter_stop",
													"description"	=>	esc_html__('Enter The Counter Stop.', BUNCH_NAME )
												),
												array(
													"type"			=>	"text",
													"label"			=>	esc_html__('Plus Sign', BUNCH_NAME ),
													"name"			=>	"plus_sign",
													"description"	=>	esc_html__('Enter The Plus Sign.', BUNCH_NAME )
												),
												array(
													"type"			=>	"text",
													"label"			=>	esc_html__('Title', BUNCH_NAME ),
													"name"			=>	"title",
													"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
												),
											),
										),
									),
								);
//Why Choose Us
$options['bunch_why_choose_us']	=	array(
					'name' => esc_html__('Why Choose Us', BUNCH_NAME),
					'base' => 'bunch_why_choose_us',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Why Choose Us.', BUNCH_NAME),
					'params' => array(
								$bg_img,
								$title,
								$text,
								$number,
								$text_limit,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'services_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//About Our Company
$options['bunch_about_our_company']	=	array(
					'name' => esc_html__('About Our Company', BUNCH_NAME),
					'base' => 'bunch_about_our_company',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The About Our Company.', BUNCH_NAME),
					'params' => array(
								$title,
								array(
									"type"			=>	"attach_image_url",
									"label"			=>	esc_html__('About Image', BUNCH_NAME ),
									"name"			=>	"about_img",
									'admin_label' 	=> 	false,
									"description"	=>	esc_html__('Choose About image Url.', BUNCH_NAME )
								),
								array(
									"type"			=>	"textarea",
									"label"			=>	esc_html__('Sub Title', BUNCH_NAME ),
									"name"			=>	"sub_title",
									"description"	=>	esc_html__('Enter The Sub Title.', BUNCH_NAME )
								),
								$text,
								$btn_title,
								$btn_link,
								array(
									"type"			=>	"attach_image_url",
									"label"			=>	esc_html__('Chart Image', BUNCH_NAME ),
									"name"			=>	"chart_img",
									'admin_label' 	=> 	false,
									"description"	=>	esc_html__('Choose Chart image Url.', BUNCH_NAME )
								),
							),
						);
//Call To Action
$options['bunch_call_to_action']	=	array(
					'name' => esc_html__('Call To Action', BUNCH_NAME),
					'base' => 'bunch_call_to_action',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Call To Action.', BUNCH_NAME),
					'params' => array(
								array(
									"type"			=>	"textarea",
									"label"			=>	esc_html__('Text', BUNCH_NAME ),
									"name"			=>	"text",
									"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
								),
							),
						);
//Latest Projects
$options['bunch_latest_projects']	=	array(
					'name' => esc_html__('Latest Projects', BUNCH_NAME),
					'base' => 'bunch_latest_projects',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Latest Projects.', BUNCH_NAME),
					'params' => array(
								$title,
								$btn_title,
								$btn_link,
								$number,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'projects_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Our Testimonials
$options['bunch_our_testimonials']	=	array(
					'name' => esc_html__('Our Testimonials', BUNCH_NAME),
					'base' => 'bunch_our_testimonials',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Testimonials.', BUNCH_NAME),
					'params' => array(
								$title,
								$number,
								$text_limit,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'testimonials_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
								array(
									"type"			=>	"checkbox",
									"label"			=>	esc_html__('Style Two', BUNCH_NAME ),
									"name"			=>	"style_two",
									'options' => array(
										'option_1' => 'Style Two',
									),
									"description"	=>	esc_html__('Choose whether you want to show The Background Color.', BUNCH_NAME  )
								),
							),
						);
//Latest News
$options['bunch_latest_news']	=	array(
					'name' => esc_html__('Latest News', BUNCH_NAME),
					'base' => 'bunch_latest_news',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Latest News.', BUNCH_NAME),
					'params' => array(
								$title,
								$btn_title,
								$btn_link,
								$number,
								$text_limit,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Our Business
$options['bunch_our_business']	=	array(
					'name' => esc_html__('Our Business', BUNCH_NAME),
					'base' => 'bunch_our_business',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show Our Business.', BUNCH_NAME),
					'params' => array(
								array(
									"type"			=>	"editor",
									"label"			=>	esc_html__('Title', BUNCH_NAME ),
									"name"			=>	"title",
									"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
								),
								$text,
								array(
									'type' => 'group',
									'label' => esc_html__( 'Business Information', BUNCH_NAME ),
									'name' => 'business_info',
									'description' => esc_html__( 'Enter the Business Information.', BUNCH_NAME ),
									'params' => array(
												array(
													"type"			=>	"attach_image_url",
													"label"			=>	esc_html__('Image', BUNCH_NAME ),
													"name"			=>	"image",
													'admin_label' 	=> 	false,
													"description"	=>	esc_html__('Choose image Url.', BUNCH_NAME )
												),
												array(
													"type"			=>	"textarea",
													"label"			=>	esc_html__('Text', BUNCH_NAME ),
													"name"			=>	"text1",
													"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
												),
											),
										),
										$btn_title,
										$btn_link,
									),
								);
//Newsletter
$options['bunch_newsletter']	=	array(
					'name' => esc_html__('Newsletter', BUNCH_NAME),
					'base' => 'bunch_newsletter',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Newsletter.', BUNCH_NAME),
					'params' => array(
								$bg_img,
								$title,
								$text,
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('FeedBurner ID', BUNCH_NAME ),
									"name"			=>	"id",
									"description"	=>	esc_html__('Enter The FeedBurner ID.', BUNCH_NAME ),
									'value' => 'themeforest',
								),
							),
						);
//About Us
$options['bunch_about_us']	=	array(
					'name' => esc_html__('About Us', BUNCH_NAME),
					'base' => 'bunch_about_us',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The About Us.', BUNCH_NAME),
					'params' => array(
								esc_html__( 'About Our Company', BUNCH_NAME ) => array(
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Image', BUNCH_NAME ),
										"name"			=>	"image",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose image Url.', BUNCH_NAME )
									),
									$title,
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Sub Title', BUNCH_NAME ),
										"name"			=>	"sub_title",
										"description"	=>	esc_html__('Enter The Sub Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Text', BUNCH_NAME ),
										"name"			=>	"text",
										"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
									),	
									$btn_title,
									$btn_link,
								),
								esc_html__( 'Our Mission', BUNCH_NAME ) => array(
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Image', BUNCH_NAME ),
										"name"			=>	"image1",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose image Url.', BUNCH_NAME )
									),
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('External Link', BUNCH_NAME ),
										"name"			=>	"btn_link1",
										"description"	=>	esc_html__('Enter The External Link.', BUNCH_NAME )
									),
									array(
										'type' => 'group',
										'label' => esc_html__( 'Our Services', BUNCH_NAME ),
										'name' => 'services',
										'description' => esc_html__( 'Enter the Our Services.', BUNCH_NAME ),
										'params' => array(
													array(
														'type' => 'icon_picker',
														'label' => esc_html__( 'Icon', BUNCH_NAME ),
														'name' => 'icons',
														'description' => esc_html__( 'Enter The Icon.', BUNCH_NAME ),
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('Title', BUNCH_NAME ),
														"name"			=>	"title1",
														"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('Sub Title', BUNCH_NAME ),
														"name"			=>	"sub_title1",
														"description"	=>	esc_html__('Enter The Counter Stop.', BUNCH_NAME )
													),
													array(
														"type"			=>	"textarea",
														"label"			=>	esc_html__('Text', BUNCH_NAME ),
														"name"			=>	"text1",
														"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('External Link', BUNCH_NAME ),
														"name"			=>	"ext_url",
														"description"	=>	esc_html__('Enter The External Link.', BUNCH_NAME )
													),
												),
											),
										),
									),
								);
//Funfacts and Services
$options['bunch_funfacts_and_services']	=	array(
					'name' => esc_html__('Funfacts and Services', BUNCH_NAME),
					'base' => 'bunch_funfacts_and_services',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show Funfacts and Services.', BUNCH_NAME),
					'params' => array(
								esc_html__( 'General', BUNCH_NAME ) => array(
									$bg_img,
								),
								esc_html__( 'Funfacts', BUNCH_NAME ) => array(
									array(
										'type' => 'group',
										'label' => esc_html__( 'Our Funfacts', BUNCH_NAME ),
										'name' => 'funfact',
										'description' => esc_html__( 'Enter the Our Funfacts.', BUNCH_NAME ),
										'params' => array(
													array(
														'type' => 'icon_picker',
														'label' => esc_html__( 'Icon', BUNCH_NAME ),
														'name' => 'icons',
														'description' => esc_html__( 'Enter The Icon.', BUNCH_NAME ),
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('Counter Start', BUNCH_NAME ),
														"name"			=>	"counter_start",
														"description"	=>	esc_html__('Enter The Counter Start.', BUNCH_NAME )
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('Counter Stop', BUNCH_NAME ),
														"name"			=>	"counter_stop",
														"description"	=>	esc_html__('Enter The Counter Stop.', BUNCH_NAME )
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('Plus Sign', BUNCH_NAME ),
														"name"			=>	"plus_sign",
														"description"	=>	esc_html__('Enter The Plus Sign.', BUNCH_NAME )
													),
													array(
														"type"			=>	"text",
														"label"			=>	esc_html__('Title', BUNCH_NAME ),
														"name"			=>	"title",
														"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
													),
												),
											),
										),
										esc_html__( 'Our Services', BUNCH_NAME ) => array(
											array(
												'type' => 'group',
												'label' => esc_html__( 'Our Services', BUNCH_NAME ),
												'name' => 'services',
												'description' => esc_html__( 'Enter the Our Services.', BUNCH_NAME ),
												'params' => array(
															array(
																'type' => 'icon_picker',
																'label' => esc_html__( 'Icon', BUNCH_NAME ),
																'name' => 'ser_icons',
																'description' => esc_html__( 'Enter The Icon.', BUNCH_NAME ),
															),
															array(
																"type"			=>	"text",
																"label"			=>	esc_html__('Title', BUNCH_NAME ),
																"name"			=>	"ser_title",
																"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
															),
															array(
																"type"			=>	"textarea",
																"label"			=>	esc_html__('Text', BUNCH_NAME ),
																"name"			=>	"ser_text",
																"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
															),
															array(
																"type"			=>	"text",
																"label"			=>	esc_html__('External Link', BUNCH_NAME ),
																"name"			=>	"ext_url",
																"description"	=>	esc_html__('Enter The External Link.', BUNCH_NAME )
															),
														),
													),
												),
											),
										);
//History In Words
$options['bunch_history_in_words']	=	array(
					'name' => esc_html__('History In Words', BUNCH_NAME),
					'base' => 'bunch_history_in_words',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show History In Words.', BUNCH_NAME),
					'params' => array(
								$title,
								array(
									 'type' => 'group',
									 'label' => esc_html__( 'History Tab', BUNCH_NAME ),
									 'name' => 'history_tab',
									 'description' => esc_html__( 'Enter History Tab Info.', BUNCH_NAME ),
									 'params' => array(
											array(
												 'type' => 'text',
												 'label' => esc_html__( 'Year', BUNCH_NAME ),
												 'name' => 'years',
												 'description' => esc_html__( 'Enter The Year.', BUNCH_NAME ),
											),
											$text_limit,
											$number,
											array(
												"type" => "dropdown",
												"label" => __( 'Category', BUNCH_NAME),
												"name" => "cat",
												"options" =>  bunch_get_categories(array( 'taxonomy' => 'history_category'), true),
												"description" => __( 'Choose Category.', BUNCH_NAME)
											),
											$order,
											$orderby,
										),
									),
								),
							);
//Our Team
$options['bunch_our_team']	=	array(
					'name' => esc_html__('Our Team', BUNCH_NAME),
					'base' => 'bunch_our_team',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Team.', BUNCH_NAME),
					'params' => array(
								$title,
								$btn_title,
								$btn_link,
								$number,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'team_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Our Team 2
$options['bunch_our_team2']	=	array(
					'name' => esc_html__('Our Team 2', BUNCH_NAME),
					'base' => 'bunch_our_team2',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Team 2.', BUNCH_NAME),
					'params' => array(
								$number,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'team_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Our Projects
$options['bunch_our_projects']	=	array(
					'name' => esc_html__('Our Projects', BUNCH_NAME),
					'base' => 'bunch_our_projects',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Projects.', BUNCH_NAME),
					'params' => array(
								$number,
								array(
								   "type" => "textfield",
								   "label" => __('Excluded Categories ID', BUNCH_NAME ),
								   "name" => "exclude_cats",
								   "description" => __('Enter Excluded Categories ID seperated by commas(13,14).', BUNCH_NAME )
								),
								$order,
								$orderby,
							),
						);
//Faqs Tab
$options['bunch_our_faqs']	=	array(
					'name' => esc_html__('Faqs Tab', BUNCH_NAME),
					'base' => 'bunch_our_faqs',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show Faqs Tab.', BUNCH_NAME),
					'params' => array(
								array(
									 'type' => 'group',
									 'label' => esc_html__( 'Faqs Tab', BUNCH_NAME ),
									 'name' => 'faq_tab',
									 'description' => esc_html__( 'Enter Faq Tab Info.', BUNCH_NAME ),
									 'params' => array(
											array(
												 'type' => 'text',
												 'label' => esc_html__( 'Title', BUNCH_NAME ),
												 'name' => 'list_title',
												 'description' => esc_html__( 'Enter Title of Faq Tab.', BUNCH_NAME ),
											),
											$text_limit,
											$number,
											array(
												"type" => "dropdown",
												"label" => __( 'Category', BUNCH_NAME),
												"name" => "cat",
												"options" =>  bunch_get_categories(array( 'taxonomy' => 'faqs_category'), true),
												"description" => __( 'Choose Category.', BUNCH_NAME)
											),
											$order,
											$orderby,
										),
									),
								),
							);
//Faqs Form
$options['bunch_faqs_form']	=	array(
					'name' => esc_html__('Faqs Form', BUNCH_NAME),
					'base' => 'bunch_faqs_form',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Faqs Form.', BUNCH_NAME),
					'params' => array(
								$title,
								array(
									"type"			=>	"textarea",
									"label"			=>	esc_html__('Contact Form', BUNCH_NAME ),
									"name"			=>	"contact_form",
									"description"	=>	esc_html__('Enter The Contact Form.', BUNCH_NAME )
								),
							),
						);
//Our Testimonials 2
$options['bunch_our_testimonials_2']	=	array(
					'name' => esc_html__('Our Testimonials 2', BUNCH_NAME),
					'base' => 'bunch_our_testimonials_2',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Testimonials 2.', BUNCH_NAME),
					'params' => array(
								$number,
								$text_limit,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'testimonials_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Free Consultation Form
$options['bunch_free_consultation_form']	=	array(
					'name' => esc_html__('Free Consultation Form', BUNCH_NAME),
					'base' => 'bunch_free_consultation_form',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Free Consultation Form.', BUNCH_NAME),
					'params' => array(
								$bg_img,
								$title,
								array(
									"type"			=>	"textarea",
									"label"			=>	esc_html__('Contact Form', BUNCH_NAME ),
									"name"			=>	"contact_form",
									"description"	=>	esc_html__('Enter The Contact Form.', BUNCH_NAME )
								),
							),
						);
//Our Services
$options['bunch_our_services']	=	array(
					'name' => esc_html__('Our Services', BUNCH_NAME),
					'base' => 'bunch_our_services',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Our Services.', BUNCH_NAME),
					'params' => array(
								$number,
								$text_limit,
								array(
									"type" => "dropdown",
									"label" => __( 'Category', BUNCH_NAME),
									"name" => "cat",
									"options" =>  bunch_get_categories(array( 'taxonomy' => 'services_category'), true),
									"description" => __( 'Choose Category.', BUNCH_NAME)
								),
								$order,
								$orderby,
							),
						);
//Service Single One
$options['bunch_service_single1']	=	array(
					'name' => esc_html__('Service Single One', BUNCH_NAME),
					'base' => 'bunch_service_single1',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Service Single One.', BUNCH_NAME),
					'params' => array(
								esc_html__( 'Left Sidebar', BUNCH_NAME ) => array(
								   array(
									   'type' => 'dropdown',
									   'label' => esc_html__( 'Choose Sidebar', BUNCH_NAME ),
									   'name' => 'sidebar_slug',
									   'options' => pickton_bunch_get_sidebars(),
									   'description' => esc_html__( 'Choose Sidebar.', BUNCH_NAME ),
								   ),
								),
								esc_html__( 'Introduction', BUNCH_NAME ) => array(
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Service Image', BUNCH_NAME ),
										"name"			=>	"image",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose Service Image Url.', BUNCH_NAME )
									),
									$title,
									$text,
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Quote Text', BUNCH_NAME ),
										"name"			=>	"quote_text",
										"description"	=>	esc_html__('Enter The Quote Text.', BUNCH_NAME )
									),
								),
								esc_html__( 'Benefits Of Service', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title1",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Text', BUNCH_NAME ),
										"name"			=>	"text1",
										"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Feature List', BUNCH_NAME ),
										"name"			=>	"feature_str",
										"description"	=>	esc_html__('Enter The Feature List.', BUNCH_NAME )
									),
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Video Image', BUNCH_NAME ),
										"name"			=>	"video_image",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose Video Image Url.', BUNCH_NAME )
									),
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Video Link', BUNCH_NAME ),
										"name"			=>	"video_link",
										"description"	=>	esc_html__('Enter The Video Link.', BUNCH_NAME )
									),
								),
								esc_html__( 'Business Strategies', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title2",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Text', BUNCH_NAME ),
										"name"			=>	"text2",
										"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
									),
									array(
										'type' => 'group',
										'label' => esc_html__( 'Our Tabs', BUNCH_NAME ),
										'name' => 'tabs',
										'description' => esc_html__( 'Enter Our Tabs.', BUNCH_NAME ),
										'params' => array(
											array(
												'type' => 'text',
												'label' => esc_html__( 'Button Title', BUNCH_NAME ),
												'name' => 'button_title',
												'description' => esc_html__( 'Enter The Button Title.', BUNCH_NAME ),
											),
											array(
												"type"			=>	"attach_image_url",
												"label"			=>	esc_html__('Image', BUNCH_NAME ),
												"name"			=>	"tab_image",
												'admin_label' 	=> 	false,
												"description"	=>	esc_html__('Choose Image Url.', BUNCH_NAME )
											),
											array(
												'type' => 'textarea',
												'label' => esc_html__( 'Tab Description', BUNCH_NAME ),
												'name' => 'tab_des',
												'description' => esc_html__( 'Enter The Tab Description.', BUNCH_NAME ),
											),
										),
									),
								),
								esc_html__( 'Consultation Form', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title3",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Contact Form', BUNCH_NAME ),
										"name"			=>	"contact_form",
										"description"	=>	esc_html__('Enter The Contact Form.', BUNCH_NAME )
									),
								),
							),
						);
//Service Single Two
$options['bunch_service_single2']	=	array(
					'name' => esc_html__('Service Single Two', BUNCH_NAME),
					'base' => 'bunch_service_single2',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Service Single Two.', BUNCH_NAME),
					'params' => array(
								esc_html__( 'Left Sidebar', BUNCH_NAME ) => array(
								   array(
									   'type' => 'dropdown',
									   'label' => esc_html__( 'Choose Sidebar', BUNCH_NAME ),
									   'name' => 'sidebar_slug',
									   'options' => pickton_bunch_get_sidebars(),
									   'description' => esc_html__( 'Choose Sidebar.', BUNCH_NAME ),
								   ),
								),
								esc_html__( 'Service Overview', BUNCH_NAME ) => array(
									$title,
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Sub Title', BUNCH_NAME ),
										"name"			=>	"sub_title",
										"description"	=>	esc_html__('Enter The Sub Title.', BUNCH_NAME )
									),
									$text,
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Service Image', BUNCH_NAME ),
										"name"			=>	"image",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose Service Image Url.', BUNCH_NAME )
									),
								),
								esc_html__( 'Research Analysis', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title1",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Text', BUNCH_NAME ),
										"name"			=>	"text1",
										"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
									),
									array(
										'type' => 'group',
										'label' => esc_html__( 'Our Analysis', BUNCH_NAME ),
										'name' => 'analysis',
										'description' => esc_html__( 'Enter Our Analysis.', BUNCH_NAME ),
										'params' => array(
											array(
												"type"			=>	"attach_image_url",
												"label"			=>	esc_html__('Analysis Image', BUNCH_NAME ),
												"name"			=>	"analysis_image",
												'admin_label' 	=> 	false,
												"description"	=>	esc_html__('Choose Analysis Image Url.', BUNCH_NAME )
											),
											array(
												'type' => 'text',
												'label' => esc_html__( 'Title', BUNCH_NAME ),
												'name' => 'analysis_title',
												'description' => esc_html__( 'Enter The Title.', BUNCH_NAME ),
											),
										),
									),
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title2",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Text', BUNCH_NAME ),
										"name"			=>	"text2",
										"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
									),
								),
							),
						);
//Service Single Three
$options['bunch_service_single3']	=	array(
					'name' => esc_html__('Service Single Three', BUNCH_NAME),
					'base' => 'bunch_service_single3',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Service Single Three.', BUNCH_NAME),
					'params' => array(
								esc_html__( 'Left Sidebar', BUNCH_NAME ) => array(
								   array(
									   'type' => 'dropdown',
									   'label' => esc_html__( 'Choose Sidebar', BUNCH_NAME ),
									   'name' => 'sidebar_slug',
									   'options' => pickton_bunch_get_sidebars(),
									   'description' => esc_html__( 'Choose Sidebar.', BUNCH_NAME ),
								   ),
								),
								esc_html__( 'Service Overview', BUNCH_NAME ) => array(
									$title,
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Service Image One', BUNCH_NAME ),
										"name"			=>	"image1",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose Service Image Url.', BUNCH_NAME )
									),
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Service Image Two', BUNCH_NAME ),
										"name"			=>	"image2",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose Service Image Url.', BUNCH_NAME )
									),
									$text,
								),
								esc_html__( 'Profit Improvement', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title1",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Text', BUNCH_NAME ),
										"name"			=>	"text1",
										"description"	=>	esc_html__('Enter The Text.', BUNCH_NAME )
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Feature List', BUNCH_NAME ),
										"name"			=>	"feature_str",
										"description"	=>	esc_html__('Enter The Feature List.', BUNCH_NAME )
									),
									array(
										"type"			=>	"attach_image_url",
										"label"			=>	esc_html__('Graph Image', BUNCH_NAME ),
										"name"			=>	"graph_image",
										'admin_label' 	=> 	false,
										"description"	=>	esc_html__('Choose Graph Image Url.', BUNCH_NAME )
									),
								),
								esc_html__( 'What We Offer', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title2",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										'type' => 'group',
										'label' => esc_html__( 'Our Services', BUNCH_NAME ),
										'name' => 'services',
										'description' => esc_html__( 'Enter Our Services.', BUNCH_NAME ),
										'params' => array(
											array(
												'type' => 'icon_picker',
												'label' => esc_html__( 'Icon', BUNCH_NAME ),
												'name' => 'icons',
												'description' => esc_html__( 'Enter The Icon.', BUNCH_NAME ),
											),
											array(
												'type' => 'text',
												'label' => esc_html__( 'Title', BUNCH_NAME ),
												'name' => 'ser_title',
												'description' => esc_html__( 'Enter The Title.', BUNCH_NAME ),
											),
											array(
												'type' => 'textarea',
												'label' => esc_html__( 'Description', BUNCH_NAME ),
												'name' => 'ser_text',
												'description' => esc_html__( 'Enter The Description.', BUNCH_NAME ),
											),
											array(
												'type' => 'text',
												'label' => esc_html__( 'External Link', BUNCH_NAME ),
												'name' => 'link',
												'description' => esc_html__( 'Enter The External Link.', BUNCH_NAME ),
											),
										),
									),
								),
								esc_html__( 'Strategies of Service', BUNCH_NAME ) => array(
									array(
										"type"			=>	"text",
										"label"			=>	esc_html__('Title', BUNCH_NAME ),
										"name"			=>	"title3",
										"description"	=>	esc_html__('Enter The Title.', BUNCH_NAME )
									),
									array(
										'type' => 'group',
										'label' => esc_html__( 'Our Accordion', BUNCH_NAME ),
										'name' => 'accordion',
										'description' => esc_html__( 'Enter Our Accordion.', BUNCH_NAME ),
										'params' => array(
											array(
												'type' => 'text',
												'label' => esc_html__( 'Title', BUNCH_NAME ),
												'name' => 'acc_title',
												'description' => esc_html__( 'Enter The Title.', BUNCH_NAME ),
											),
											array(
												'type' => 'textarea',
												'label' => esc_html__( 'Description', BUNCH_NAME ),
												'name' => 'acc_text',
												'description' => esc_html__( 'Enter The Description.', BUNCH_NAME ),
											),
										),
									),
								),
							),
						);
//Blog Grid View
$options['bunch_blog_grid_view']	=	array(
					'name' => esc_html__('Blog Grid View', BUNCH_NAME),
					'base' => 'bunch_blog_grid_view',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Blog Grid View.', BUNCH_NAME),
					'params' => array(
								esc_html__( 'Our Blog', BUNCH_NAME ) => array(
									$number,
									$text_limit,
									array(
										"type" => "dropdown",
										"label" => __( 'Category', BUNCH_NAME),
										"name" => "cat",
										"options" =>  bunch_get_categories(array( 'taxonomy' => 'category'), true),
										"description" => __( 'Choose Category.', BUNCH_NAME)
									),
									$order,
									$orderby,
								),
								esc_html__( 'Right Sidebar', BUNCH_NAME ) => array(
								   array(
									   'type' => 'dropdown',
									   'label' => esc_html__( 'Choose Sidebar', BUNCH_NAME ),
									   'name' => 'sidebar_slug',
									   'options' => pickton_bunch_get_sidebars(),
									   'description' => esc_html__( 'Choose Sidebar.', BUNCH_NAME ),
								   ),
								),
							),
						);
//Contact Us
$options['bunch_contact_us']	=	array(
					'name' => esc_html__('Contact Us', BUNCH_NAME),
					'base' => 'bunch_contact_us',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Contact Us.', BUNCH_NAME),
					'params' => array(
								$title,
								$text,
								array(
									"type"			=>	"textarea",
									"label"			=>	esc_html__('Address', BUNCH_NAME ),
									"name"			=>	"address",
									"description"	=>	esc_html__('Enter The Address.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Phone Number', BUNCH_NAME ),
									"name"			=>	"phone",
									"description"	=>	esc_html__('Enter The Phone Number.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Email', BUNCH_NAME ),
									"name"			=>	"email",
									"description"	=>	esc_html__('Enter The Email.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Opening Hours', BUNCH_NAME ),
									"name"			=>	"opening_hours",
									"description"	=>	esc_html__('Enter The Opening Hours.', BUNCH_NAME )
								),
								array(
									 'type' => 'group',
									 'label' => esc_html__( 'Social Icons', BUNCH_NAME ),
									 'name' => 'socials',
									 'description' => esc_html__( 'Enter Social Icons.', BUNCH_NAME ),
									 'params' => array(
											array(
												'type' => 'icon_picker',
												'label' => esc_html__( 'Icon', BUNCH_NAME ),
												'name' => 'icons',
												'description' => esc_html__( 'Enter The Icon.', BUNCH_NAME ),
											),
											array(
												'type' => 'text',
												'label' => esc_html__( 'External Link', BUNCH_NAME ),
												'name' => 'link',
												'description' => esc_html__( 'Enter The External Link.', BUNCH_NAME ),
											),
										),
									),
									array(
										"type"			=>	"textarea",
										"label"			=>	esc_html__('Contact Form', BUNCH_NAME ),
										"name"			=>	"contact_form",
										"description"	=>	esc_html__('Enter The Contact Form.', BUNCH_NAME )
									),
								),
							);
//Google Map
$options['bunch_google_map']	=	array(
					'name' => esc_html__('Google Map', BUNCH_NAME),
					'base' => 'bunch_google_map',
					'class' => '',
					'category' => esc_html__('Triumph', BUNCH_NAME),
					'icon' => 'fa-briefcase' ,
					'description' => esc_html__('Show The Google Map.', BUNCH_NAME),
					'params' => array(
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Latitude', BUNCH_NAME ),
									"name"			=>	"lat",
									"description"	=>	esc_html__('Enter The Latitude.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Longitude', BUNCH_NAME ),
									"name"			=>	"long",
									"description"	=>	esc_html__('Enter The Longitude.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Mark Title', BUNCH_NAME ),
									"name"			=>	"title",
									"description"	=>	esc_html__('Enter The Mark Title.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Address', BUNCH_NAME ),
									"name"			=>	"address",
									"description"	=>	esc_html__('Enter The Address.', BUNCH_NAME )
								),
								array(
									"type"			=>	"text",
									"label"			=>	esc_html__('Email Address', BUNCH_NAME ),
									"name"			=>	"email",
									"description"	=>	esc_html__('Enter The Email Address.', BUNCH_NAME )
								),
								array(
									"type"			=>	"attach_image_url",
									"label"			=>	esc_html__('Marker Image', BUNCH_NAME ),
									"name"			=>	"img",
									'admin_label' 	=> 	false,
									"description"	=>	esc_html__('Choose Marker image Url.', BUNCH_NAME )
								),
							),
						);




return $options;