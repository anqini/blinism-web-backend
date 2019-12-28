<?php


//======================================================================
// Meta boxes for Posts
//======================================================================

add_action( 'add_meta_boxes', 'luv_post_meta_box' );

/**
 * Add Conditional post settings - based on post type - meta box to Post editor
 */
function luv_post_meta_box() {

	//======================================================================
	// Audio Post Format
	//======================================================================
	$meta_box = array(
		'id' => 'luv-post-format-meta-box-audio',
		'title' =>  esc_html__('Audio Settings', 'fevr'),
		'desc' => esc_html__('The settings related to the audio post format can be found here.', 'fevr'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Audio Source', 'fevr'),
				'id' => 'post-audio-source',
				'type' => 'buttonset',
				'options' => array(
					'file' => 'File',
					'embedded' => 'Embedded',
				),
				'default' => 'file'
			),
			array(
				'name' => esc_html__('MP3 File URL', 'fevr'),
				'desc' => esc_html__('Please upload the MP3 file or write the URL here.', 'fevr'),
				'id' => 'post-audio-mp3',
				'type' => 'file',
				'default' => '',
				'required' => array('post-audio-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('OGA File URL', 'fevr'),
				'desc' => esc_html__('Please upload the OGA file or write the URL here.', 'fevr'),
				'id' => 'post-audio-ogg',
				'type' => 'file',
				'default' => '',
				'required' => array('post-audio-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('Embedded Audio', 'fevr'),
				'desc' => esc_html__('Please provide the embedded code. E.g.: Soundcloud', 'fevr'),
				'id' => 'post-audio-embedded',
				'type' => 'textarea',
				'default' => '',
				'required' => array('post-audio-source', '=', 'embedded'),
			),
		)
	);

	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);

	//======================================================================
	// Video Post Format
	//======================================================================
	$meta_box = array(
		'id' => 'luv-post-format-meta-box-video',
		'title' =>  esc_html__('Video Settings', 'fevr'),
		'desc' => esc_html__('The settings related to the video post format can be found here.', 'fevr'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Video Source', 'fevr'),
				'id' => 'post-video-source',
				'type' => 'buttonset',
				'options' => array(
					'file' => 'File',
					'embedded' => 'Embedded',
				),
				'default' => 'file'
			),
			array(
				'name' => esc_html__('MP4 File URL', 'fevr'),
				'desc' => esc_html__('Please upload the MP4 file. The upload of OGV format is also recommended.', 'fevr'),
				'id' => 'post-video-mp4',
				'type' => 'file',
				'default' => '',
				'required' => array('post-video-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('OGV File URL', 'fevr'),
				'desc' => esc_html__('Please upload the OGV file. The upload of MP4 format is also recommended.', 'fevr'),
				'id' => 'post-video-ogv',
				'type' => 'file',
				'default' => '',
				'required' => array('post-video-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('Autoplay', 'fevr'),
				'id' => 'post-video-autoplay',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('post-video-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('Loop', 'fevr'),
				'id' => 'post-video-loop',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('post-video-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('Mute', 'fevr'),
				'id' => 'post-video-mute',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('post-video-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('Controls', 'fevr'),
				'id' => 'post-video-controls',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled',
				'required' => array('post-video-source', '=', 'file'),
			),
			array(
				'name' => esc_html__('Embedded Video', 'fevr'),
				'id' => 'post-video-embedded',
				'type' => 'textarea',
				'default' => '',
				'required' => array('post-video-source', '=', 'embedded'),
			),
		)
	);

	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);

	//======================================================================
	// Quote Post Format
	//======================================================================
	$meta_box = array(
		'id' => 'luv-post-format-meta-box-quote',
		'title' =>  esc_html__('Quote Settings', 'fevr'),
		'desc' => esc_html__('The settings related to quote post format can be found here.', 'fevr'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Author', 'fevr'),
				'desc' => esc_html__('The name of the author can be provided here. The quote can be written in the content editor.', 'fevr'),
				'id' => 'post-quote-author',
				'type' => 'text',
				'default' => ''
			),
		)
	);

	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);

	//======================================================================
	// Gallery Post Format
	//======================================================================
	$meta_box = array(
		'id' => 'luv-post-format-meta-box-gallery',
		'title' =>  esc_html__('Gallery Settings', 'fevr'),
		'desc' => esc_html__('The settings related to the gallery post format can be found here.', 'fevr'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Gallery', 'fevr'),
				'desc' => esc_html__('Please upload the elements of the gallery.', 'fevr'),
				'id' => 'post-gallery',
				'type' => 'file_img',
				'repeat' => true,
				'sortable' => true,
				'default' => ''
			),
			array(
				'name' => esc_html__('Autoplay', 'fevr'),
				'id' => 'post-gallery-autoplay',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled'
			),
			array(
				'name' => esc_html__('Show Arrows', 'fevr'),
				'id' => 'post-gallery-arrows',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled'
			),
			array(
				'name' => esc_html__('Show Dots', 'fevr'),
				'id' => 'post-gallery-dots',
				'type' => 'checkbox',
				'class' => 'switch-style',
				'default' => 'enabled'
			),
		)
	);

	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);

	//======================================================================
	// Link Post Format
	//======================================================================
	$meta_box = array(
		'id' => 'luv-post-format-meta-box-link',
		'title' =>  esc_html__('Link Settings', 'fevr'),
		'desc' => esc_html__('The settings related to the link post format can be found here.', 'fevr'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Link URL', 'fevr'),
				'desc' => esc_html__('Please provide the URL. Include http:// or https://', 'fevr'),
				'id' => 'post-link',
				'type' => 'text',
			),
		)
	);

	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);

	//======================================================================
	// Expiring Post Format
	//======================================================================
	$meta_box = array(
		'id' => 'luv-post-format-meta-box-aside',
		'title' =>  esc_html__('Expiration Settings', 'fevr'),
		'desc' => esc_html__('You can find the settings related to the expiring post format. The expiring post format is a special post format. You can set an expiry date for the post, and when the post expires the visitor will see an expiry message.', 'fevr'),
		'post_type' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Expiration Date', 'fevr'),
				'desc' => esc_html__('Please provide the date with the help of the datepicker.', 'fevr'),
				'id' => 'post-expiration-date',
				'type' => 'text',
			),
			array(
				'name' => esc_html__('Message when the post expired', 'fevr'),
				'desc' => esc_html__('Please provide the message that will appear once the post expires.', 'fevr'),
				'id' => 'post-expiration-message',
				'type' => 'text',
			),
		)
	);

	add_meta_box(
		$meta_box['id'],
		$meta_box['title'],
		'luv_create_meta_box_callback',
		$meta_box['post_type'],
		$meta_box['context'],
		$meta_box['priority'],
		$meta_box
	);
}

?>
