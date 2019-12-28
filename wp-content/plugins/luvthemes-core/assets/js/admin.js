jQuery(function(){
	/*----------------------------------------------------------------------------------*/
	/* Visual Composer Editor hacks
	/*----------------------------------------------------------------------------------*/
	jQuery('.wpb_element_wrapper i[name="icon"]').each(function(){
		jQuery(this).attr('class', jQuery(this).text()).empty();
	});

	jQuery(document).on('dblclick','.wpb_element_wrapper', function(){
  		jQuery(this).find('.vc_control-btn-edit').click();
	});

	/*----------------------------------------------------------------------------------*/
	/* Luv Shortcode generator
	/*----------------------------------------------------------------------------------*/

	// Open shortcode generator
	jQuery(document).on('click','.luv-shortcode-generator', function(e){
		e.preventDefault();
		window.luv_shortcode_generator_target = jQuery(this).closest('.wp-editor-tools').siblings('.wp-editor-container').find('.wp-editor-area');
		jQuery('#luv-shortcode-generator-container').removeClass('luv-hidden');
	});

	jQuery(document).on('click','.metafield-luv-shortcode-generator', function(e){
		e.preventDefault();
		window.luv_shortcode_generator_target = jQuery(this).parent().find('textarea');
		jQuery('#luv-shortcode-generator-container').removeClass('luv-hidden');
	});

	jQuery(document).on('click','.redux-luv-shortcode-generator', function(e){
		e.preventDefault();
		window.luv_shortcode_generator_target = jQuery(this).parents('fieldset').find('textarea');
		jQuery('#luv-shortcode-generator-container').removeClass('luv-hidden');
	});

	// Open shortcode editor
	jQuery(document).on('click','.luv-shortcode-tile', function(e){
		var shortcode = jQuery(this).attr('data-shortcode');
		var shortcode_container = jQuery('.luv-shortcode-container[data-type="' + shortcode + '"]');

		// Loading
		jQuery(shortcode_container).empty().append(
			jQuery('<div>',{
				'class' : 'luv-shortcode-generator-loading'
			}).append(
				jQuery('<i>', {
					'class':'fa fa-spinner fa-spin'
				})
			)
		).removeClass('luv-hidden');

		// Load editor
		jQuery.post(ajaxurl, {action: 'load_luv_shortcode_generator_fields', shortcode: shortcode}, function(response){
			jQuery(shortcode_container).html(response).addClass('luv-shortcode-selected');
			init_luv_required();
			jQuery('.wp-color-picker').wpColorPicker();
		});
		jQuery('.luv-shortcode-navigation').addClass('luv-hidden');
		jQuery('.luv-button-container button').removeClass('luv-hidden');
	});

	// Insert shortcode
	jQuery(document).on('click','.insert-luv-shortcode', function(){
		var attr = '';
		var base = 'luv_' + jQuery('.luv-shortcode-selected').attr('data-type');
		var content = null;
		jQuery('.luv-shortcode-selected input[id^="shortcode-"], .luv-shortcode-selected textarea[id^="shortcode-"], .luv-shortcode-selected select[id^="shortcode-"]').each(function(){
			if (jQuery(this).attr('data-attr') == 'content' || jQuery(this).hasClass('wp-editor-content')){
				content = jQuery(this).val();
			}
			else{
				if ((jQuery(this).prop('type') !== 'checkbox' && jQuery(this).prop('type') !== 'radio') || jQuery(this).prop('checked')){
					if (jQuery(this).closest('.luv-shortcode-field-section').css('display') != 'none' && jQuery(this).val() != ''){
						attr += jQuery(this).attr('data-attr') + '="' + jQuery(this).val() + '" ';
					}
				}
			}
		});
		var shortcode = '[' + base + ' ' + attr.trim() + ']' + (content != null ? content + '[/' + base + ']' : '');
		try{
			tinymce.get(jQuery(luv_shortcode_generator_target).attr('id')).execCommand('mceInsertContent', false, shortcode);
		}
		catch(e){
			jQuery(window.luv_shortcode_generator_target).smartInsert(shortcode);
		}

		reset_shortcode_editor(true);
	});

	// Close shortcode editor
	jQuery(document).on('click','.close-luv-shortcode-container', function(){
		reset_shortcode_editor(true);
	});

	// Back to main screen in shortcode editor
	jQuery(document).on('click','.cancel-luv-shortcode-container', function(){
		reset_shortcode_editor(false);
	});

	function reset_shortcode_editor(close){
		jQuery('.cancel-luv-shortcode-container, .insert-luv-shortcode').addClass('luv-hidden');

		close = close || false;
		// Reset editor
		jQuery('.luv-shortcode-selected input[id^="shortcode-"], .luv-shortcode-selected textarea[id^="shortcode-"], .luv-shortcode-selected select[id^="shortcode-"]').each(function(){
			if (jQuery(this).prop('type') == 'checkbox' || jQuery(this).prop('type') == 'radio'){
				jQuery('[value="' + jQuery(this).attr('data-default') + '"]').prop('checked', true);
			}
			else{
				jQuery(this).val(jQuery(this).attr('data-default'));
			}
			jQuery(this).trigger('change');
		});

		if (close){
			jQuery('#luv-shortcode-generator-container').addClass('luv-hidden');
		}
		jQuery('.luv-shortcode-selected').addClass('luv-hidden');
		jQuery('.luv-shortcode-navigation').removeClass('luv-hidden');
		jQuery('.luv-shortcode-selected').removeClass('luv-shortcode-selected');

		//Reset iconset
		jQuery('#luv-shortcode-generator-container .luv-iconset li').removeClass('active');
	}

	/*----------------------------------------------------------------------------------*/
	/* Photo URL field
	/*----------------------------------------------------------------------------------*/

	jQuery(document).on('click','.luv-existing-content-switch',function(e){
		e.preventDefault();
		jQuery(this).next().toggleClass('luv-hidden').find('.luv-existing-content-filter').trigger('change');
	});

	jQuery(document).on('keyup change','.luv-existing-content-filter',function(){
		var that = jQuery(this);
		setTimeout(function(){
			jQuery(that).next().load(ajaxurl, {'action' : 'luv_existing_content_list', 'nonce' : luvthemes_core.nonce, 'keyword' : jQuery(that).val()});
		},100);
	});

	jQuery(document).on('click','.luv-existing-url-link', function(e){
		e.preventDefault();
		jQuery(this).closest('.luv-existing-content-outer').find('input[type=url]').val(jQuery(this).attr('data-url'));
		jQuery(this).closest('.luv-existing-content-container').addClass('luv-hidden');
	});

	/*----------------------------------------------------------------------------------*/
	/* Multiselect
	/*----------------------------------------------------------------------------------*/

	// Main functionality
	jQuery(document).on('change','.luv-multiselect-checkbox',function(){
		var csl = jQuery(this).closest('ul').siblings('input.luv-multiselect-csl');
		var values = (jQuery(csl).val() == '' ? [] : jQuery(csl).val().split(','));
		if (jQuery(this).prop('checked')){
			values.push(jQuery(this).val().toLowerCase());
		}
		else{
			delete(values[values.indexOf(jQuery(this).val().toLowerCase())]);
		}
		jQuery(csl).val('');
		jQuery.each(luv_array_unique(values), function(index, value){
			if (typeof value !== 'undefined' && value != ''){
				jQuery(csl).val((jQuery(csl).val() + ',' + value).replace(/(^,)|(,$)/g, ''));
			}
		});
	});

	// Check all
	jQuery(document).on('click','.luv-multiselect-check-all',function(e){
		e.preventDefault();
		jQuery(this).siblings('ul.luv-multiselect').find('input[type="checkbox"]').each(function(){
			jQuery(this).prop('checked','checked');
			jQuery(this).trigger('change');
		});
	});

	jQuery(document).on('click','.luv-multiselect-clear',function(e){
		e.preventDefault();
		jQuery(this).siblings('ul.luv-multiselect').find('input[type="checkbox"]').each(function(){
			jQuery(this).removeProp('checked');
			jQuery(this).trigger('change');
		});
	});

	/*----------------------------------------------------------------------------------*/
	/* Iconset
	/*----------------------------------------------------------------------------------*/

	// Iconset selector
	jQuery(document).on('change','.luv-iconset-filter',function(){
		jQuery(this).parent().siblings('.luv-iconset').addClass('luv-hidden');
		jQuery(this).parent().siblings('.luv-iconset[data-iconset="' + jQuery(this).val() + '"]').removeClass('luv-hidden');
	});

	// Icon filter
	jQuery(document).on('keypress','.luv-icon-filter',function(){
		var search = jQuery(this);
		setTimeout(function(){
			jQuery(search).siblings('.luv-iconset').find('i').each(function(){
				if (jQuery(this).attr('class').match(jQuery(search).val())){
					jQuery(this).parent().removeClass('luv-hidden');
				}
				else{
					jQuery(this).parent().addClass('luv-hidden');
				}
			});
		},200);
	});


	// Iconset
	jQuery(document).on('click', '.luv-iconset li', function(){
		if (jQuery(this).hasClass('active')){
			jQuery(this).closest('.luv-iconset').children('li').removeClass('active');
			jQuery(this).closest('.luv-iconset').siblings('.icon-holder').val('');

			if (jQuery(this).hasClass('redux')){
				jQuery(this).closest('fieldset').find('.icon-preview i').attr('class', jQuery(this).closest('fieldset').find('.icon-preview').attr('data-default'));
				jQuery(this).closest('.luv-iconset').siblings('.icon-holder').val(jQuery(this).closest('fieldset').find('.icon-preview').attr('data-default'));
			}
		}
		else{
			jQuery(this).closest('.luv-iconset').children('li').removeClass('active');
			jQuery(this).addClass('active');
			jQuery(this).closest('.luv-iconset').siblings('.icon-holder').val(jQuery(this).children('i').attr('class'));
			if (jQuery(this).hasClass('redux')){
				jQuery(this).closest('fieldset').find('.icon-preview i').attr('class', jQuery(this).find('i').attr('class'));
			}
		}
		jQuery(this).closest('.luv-iconset').siblings('.icon-holder').trigger('change');
	});

	// Icon select
	jQuery(document).on('click', '.luv-icon-select li', function(){
		if (jQuery(this).hasClass('active')){
			jQuery(this).closest('.luv-icon-select').children('li').removeClass('active');
			jQuery(this).closest('.luv-icon-select').siblings('.icon-holder').val('');
		}
		else{
			jQuery(this).closest('.luv-icon-select').children('li').removeClass('active');
			jQuery(this).addClass('active');
			jQuery(this).closest('.luv-icon-select').siblings('.icon-holder').val(jQuery(this).children('i').attr('data-value'));
		}
		jQuery(this).closest('.luv-icon-select').siblings('.icon-holder').trigger('change');
	});

	// Switch style fix
	jQuery(document).on('change','.luv_switch_checkbox', function(){
		if (jQuery(this).prop('checked')){
			jQuery(this).prev().val('true').trigger('change');
		}
		else{
			jQuery(this).prev().val('false').trigger('change');;
		}
	});


	/*----------------------------------------------------------------------------------*/
	/* Responsive Number fields
	/*----------------------------------------------------------------------------------*/

	jQuery(document).on('change blur', '[data-responsive]', function(){
		var that = jQuery(this);
		var data = {};
		jQuery(this).nextAll('[data-responsive]').each(function(){
			if (jQuery(this).val() == ''){
				jQuery(this).val(jQuery(that).val());
			}
		});
		jQuery(this).closest('.responsive-number-set').find('[data-responsive]').each(function(){
			data[jQuery(this).attr('data-responsive')] = jQuery(this).val();
		});
		jQuery(this).closest('.responsive-number-set').find('.responsive-number').val(JSON.stringify(data).replace(/"/g,"'"));
	});

	// Load values to editor
	jQuery('.responsive-number-set').each(function(){
		try{
			var values = JSON.parse(jQuery(this).find('.responsive-number').val().replace(/'/g,'"'));
			jQuery(this).find('[data-responsive]').each(function(){
				jQuery(this).val(values[jQuery(this).attr('data-responsive')]);
			});
		}
		catch(e){
			// do nothing;
		}
	});


	/*----------------------------------------------------------------------------------*/
	/* Margin set
	/*----------------------------------------------------------------------------------*/

	jQuery(document).on('change blur', '[data-luv_design]', function(){
		var that = jQuery(this);
		var data = {};
		jQuery(this).nextAll('[data-luv_design]').each(function(){
			if (jQuery(this).val() == ''){
				jQuery(this).val(jQuery(that).val());
			}
		});
		jQuery(this).closest('.margin-set').find('[data-luv_design]').each(function(){
			data[jQuery(this).attr('data-luv_design')] = jQuery(this).val();
		});
		jQuery(this).closest('.margin-set').find('.luv_design-margin').val(JSON.stringify(data).replace(/"/g,"'"));
	});

	/*----------------------------------------------------------------------------------*/
	/* Key-value fields
	/*----------------------------------------------------------------------------------*/
	jQuery(document).on('keyup','.luv_vc_key_value', function(){
		var container = jQuery(this).closest('.luv_key_value_container');
		setTimeout(function(){
			luv_regenerate_key_value_field(container);
		},200);
	});

	jQuery(document).on('click', '.luv_remove_vc_key_value', function(e){
		e.preventDefault();
		var container = jQuery(this).closest('.luv_key_value_container');
		jQuery(this).parent().remove();
		luv_regenerate_key_value_field(container);
	});

	jQuery(document).on('click', '.luv_add_vc_key_value', function(e){
		e.preventDefault();
		var kv = jQuery(this).parent().clone();
		jQuery(kv).find('input').val('');
		jQuery(this).closest('.luv_key_value_container').append(kv);
	});

	function luv_regenerate_key_value_field(container){
		var holder = jQuery(container).find('textarea');
		jQuery(holder).val('');
		jQuery(container).find('.luv_key_value_fields_container').each(function(){
			if (jQuery(this).find('[data-type="key"]').val() != ''){
				jQuery(holder).val(
						jQuery(holder).val() +
						jQuery(this).find('[data-type="key"]').val() + '=' +
						jQuery(this).find('[data-type="value"]').val() + "\n"
				);
			}
		});
	}

	/*----------------------------------------------------------------------------------*/
	/* Media Uploader
	/*----------------------------------------------------------------------------------*/

	jQuery(document).on('click', '.luv-media-upload', function(){
		luv_media_upload(jQuery(this), false);
	});

	jQuery(document).on('click', '.luv-media-upload-by-id', function(){
		luv_media_upload(jQuery(this), true);
	});

	jQuery(document).on('click', '.luv-media-upload-reset', function(){
		jQuery(this).closest('.luv-media-upload-container').find('.luv-media-upload-url, .luv-media-upload-by-id').val('').trigger('change');
        jQuery(this).closest('.luv-media-upload-container').find('.luv-media-upload-preview').attr('src', '').addClass('luv-hidden');
        jQuery(this).addClass('luv-hidden');
        jQuery(this).closest('.luv-media-upload-container').find('.luv-media-upload, .luv-media-upload-by-id').text(__('Upload'));
        jQuery(this).closest('.luv-media-upload-container').find('.luv-repeat-field').addClass('luv-hidden');
	});

	/*----------------------------------------------------------------------------------*/
	/* Carousel type callback
	/*----------------------------------------------------------------------------------*/
	jQuery(document).on('click change','[data-vc-shortcode="luv_carousel_slide"] [name="type"]', function(){
		var editor	= jQuery(this).parents('.vc_ui-panel-content');
		var type	= jQuery(editor).find('[name="type"]').val();

		setTimeout(function(){
			if (type == 'Anything'){
				jQuery(editor).find('.luv-media-upload-reset').click();
				jQuery(editor).find('.vc_icon-remove').click();
			}

			else if (type == 'Image'){
				jQuery(editor).find('.luv-media-upload-reset').click();
				try {
					tinymce.get(jQuery('#wpb_tinymce_content').attr('id')).setContent('');
				} catch(e){
					//Silent fail if tinyMCE isn't present
				}
				jQuery('#wpb_tinymce_content').val('');
			}

			else if (type == 'Video'){
				jQuery(editor).find('.vc_icon-remove').click();
				try {
					tinymce.get(jQuery('#wpb_tinymce_content').attr('id')).setContent('');
				} catch(e){
					//Silent fail if tinyMCE isn't present
				}
				jQuery('#wpb_tinymce_content').val('');
			}
		},200);

	});

	/*----------------------------------------------------------------------------------*/
	/* Tokenfields
	/*----------------------------------------------------------------------------------*/


	jQuery(document).on('focus', '.vc_tokenfield_block .autocomplete', function(){
		var autocomplete = jQuery(this).next('.vc_tokenlist');
		jQuery(autocomplete).css('width',jQuery(this).css('width'));
		jQuery(this).trigger('keypress');
	});

	jQuery(document).on('blur', '.vc_tokenfield_block .autocomplete', function(){
		var autocomplete = jQuery(this).next('.vc_tokenlist');
		setTimeout(function(){
			jQuery(autocomplete).css('display','none');
		},100);
	});


	jQuery(document).on('keypress', '.vc_tokenfield_block .autocomplete', function(event){
		var that = jQuery(this);
		var autocomplete = jQuery(this).siblings('.vc_tokenlist');

		jQuery(autocomplete).css('display','block');

		//Filter the options
		if (event.keyCode != 40 && event.keyCode != 38){
			setTimeout(function(){
				jQuery(autocomplete).find('li.state-hidden').removeClass('state-hidden');
				jQuery(autocomplete).find('li:not(.pseudo-element)').each(function(){
					if (!jQuery(this).text().toLowerCase().match(jQuery(that).val().toLowerCase()) || jQuery.inArray(jQuery(this).text(), jQuery(this).parent().siblings('input.vc_tokenfield').val().split(',')) != -1 ){
						jQuery(this).addClass('state-hidden');
					}
				});
				//Pseudo element for custom value
				if(jQuery(that).val() == ''){
					jQuery(autocomplete).find('.pseudo-element').addClass('state-hidden');
				}
				jQuery(autocomplete).find('.pseudo-element').text(jQuery(that).val());
			},100);
		}

		if (event.keyCode == 40){
			var active = jQuery(autocomplete).find('li.state-focus').length > 0 && jQuery(autocomplete).find('li.state-focus').nextAll('li:not(.state-hidden):first').length > 0 ? jQuery(autocomplete).find('li.state-focus').nextAll('li:not(.state-hidden):first') : jQuery(autocomplete).find('li:not(.state-hidden):first');
			//Reset selected
			jQuery(autocomplete).find('li.state-focus').removeClass('state-focus');

			//Highlight selected
			jQuery(active).addClass('state-focus');
			jQuery(autocomplete).scrollTop(jQuery(active).offset().top - jQuery(autocomplete).offset().top + jQuery(autocomplete).scrollTop());
		}
		else if (event.keyCode == 38){
			var active = jQuery(autocomplete).find('li.state-focus').length > 0 && jQuery(autocomplete).find('li.state-focus').prevAll('li:not(.state-hidden):first').length > 0 ? jQuery(autocomplete).find('li.state-focus').prevAll('li:not(.state-hidden):first') : jQuery(autocomplete).find('li:not(.state-hidden):last');

			//Reset selected
			jQuery(autocomplete).find('li.state-focus').removeClass('state-focus');

			//Highlight selected
			jQuery(active).addClass('state-focus');
			jQuery(autocomplete).scrollTop(jQuery(active).offset().top - jQuery(autocomplete).offset().top + jQuery(autocomplete).scrollTop());
		}
		else if (event.keyCode == 9 || event.keyCode == 13){
			if (jQuery(autocomplete).find('li.state-focus').length > 0){
				event.preventDefault();
				jQuery(this).val('');
				jQuery(this).siblings('input.vc_tokenfield').val((jQuery(this).siblings('input.vc_tokenfield').val() + ',' + jQuery(autocomplete).find('li.state-focus:not(.state-hidden)').text()).replace(/^,(.*)/,"$1"));
				jQuery(this).siblings('input.vc_tokenfield').trigger('change');

				jQuery(this).trigger('blur');
				return false;
			}
		}
		else if (event.keyCode == 27){
			jQuery(this).trigger('blur');
		}

	});

	jQuery(document).on('mouseover', '.vc_tokenfield_block .vc_tokenlist li', function(){
		jQuery(this).addClass('state-focus');
		jQuery(this).siblings('*').removeClass('state-focus');

	});

	jQuery(document).on('mouseout', '.vc_tokenfield_block .vc_tokenlist li', function(){
		jQuery(this).removeClass('state-focus');
	});

	jQuery(document).on('click', '.vc_tokenfield_block .vc_tokenlist li', function(){
		jQuery(this).parent().siblings('input.vc_tokenfield').val((jQuery(this).parent().siblings('input.vc_tokenfield').val() + ',' + jQuery(this).text()).replace(/^,(.*)/,"$1"));
		jQuery(this).parent().siblings('input.vc_tokenfield').trigger('change');

		jQuery(this).parent().siblings('input.autocomplete').val('');
	});

	jQuery(document).on('click', '.vc_tokenfield_block .tokenfield .token .remove', function(e){
		e.preventDefault();
		jQuery(this).closest('.tokenfield').siblings('input.vc_tokenfield').val(jQuery(this).closest('.tokenfield').siblings('input.vc_tokenfield').val().replace(new RegExp('(([^,]*),)?' + jQuery(this).siblings('.token-label').text().toLowerCase()),'$2'));
		jQuery(this).closest('.tokenfield').siblings('input.vc_tokenfield').trigger('change');
	});

	jQuery(document).on('change','input.vc_tokenfield',function(){
		var vc_tokenfield = jQuery(this);

		jQuery(vc_tokenfield).siblings('.vc_tokenlist li').removeClass('state-focus');

		var tokens = jQuery(vc_tokenfield ).val().split(',');
		jQuery(vc_tokenfield ).siblings('.tokenfield').empty();
		for (var i in tokens){
			if (typeof tokens[i] == 'string' && tokens[i] != ''){
			jQuery(vc_tokenfield).siblings('.tokenfield').append(
						jQuery('<span>',{
							'class'	: 'token',
						}).append(
								jQuery('<span>',{
									'class'	: 'token-label',
									'text'	: tokens[i]
								}),
								jQuery('<a>',{
									'class'	: 'remove',
									'href'	: '#',
									'text'	: 'x'
								})
							)
					);
			}
		}
		jQuery(vc_tokenfield).siblings('.autocomplete').focus();
	});


	/*----------------------------------------------------------------------------------*/
	/* Clone Meta Settings (fevr_meta)
	/*----------------------------------------------------------------------------------*/
	jQuery(document).on('click', '.clone-settings', function(e){
		if (!confirm(__('Current settings will be overwritten. Do you continue?'))){
			e.preventDefault();
			return false;
		}
		else {
			jQuery(this).closest('form').append(jQuery('<input>', {'type' : 'hidden', 'name' : 'luv-clone-settings', 'value' : 'true'}));
		}
	});

	init_luv_required();
});

/*----------------------------------------------------------------------------------*/
/* Font selector
/*----------------------------------------------------------------------------------*/

	var luv_fonts_loaded = []
	jQuery(document).on('change click keyup', '.luv-font', function(){
		var font_selector = jQuery(this);
		var font_weight	  = jQuery('.luv-font-weight-' + jQuery(font_selector).attr('data-luv-font-id'));
		if (jQuery(this).val() !== '' && typeof luv_fonts_loaded[jQuery(this).val()] === 'undefined'){
			luv_fonts_loaded[jQuery(this).val()] = 1
			jQuery('head').append("<link rel='stylesheet'  href='//fonts.googleapis.com/css?family=" + encodeURIComponent(jQuery(this).val()) + "&subset=latin,latin-ext&#038;ver=27d3eeda' type='text/css' media='all' />");
		}
		jQuery(this).parent().next().css('font-family',jQuery(this).val());

		// Update font weights
		if (jQuery(font_weight).length > 0){
			jQuery.post(ajaxurl, {'action': 'luv_font_variants', 'font': jQuery(font_selector).val()}, function(response){
				jQuery(font_weight).empty();
				jQuery(font_weight).append(jQuery('<option>',{
					'value' : '',
					'text'  : __('Default')
				}));
				for (var i in response){
					if (i != 0){
						jQuery(font_weight).append(jQuery('<option>',{
							'value' : i,
							'text'  : i
						}));
					}
				}
				jQuery(font_weight).val(jQuery(font_weight).attr('data-value'));
			});
		}

	});

/*----------------------------------------------------------------------------------*/
/* "Radio" checkboxes
/*----------------------------------------------------------------------------------*/


jQuery(document).on('change','.wpb_vc_param_value.social_locker.checkbox, .wpb_vc_param_value.exit_popup.checkbox, .wpb_vc_param_value.welcome_popup.checkbox', function(){
	var that = jQuery(this);
	jQuery(this).closest('.vc_edit-form-tab').find('.wpb_vc_param_value.social_locker.checkbox, .wpb_vc_param_value.exit_popup.checkbox, .wpb_vc_param_value.welcome_popup.checkbox').each(function(){
		if (jQuery(this).attr('class') != jQuery(that).attr('class') && jQuery(that).prop('checked')){
			jQuery(this).removeAttr('checked').trigger('change');
		}
	});
});


/*----------------------------------------------------------------------------------*/
/* Functions
/*----------------------------------------------------------------------------------*/


/**
 * Change preview image, draw points and render input fields for interactive image editor
 * @param object container
 */
function luv_interactive_image_editor(container){
	var img		= jQuery(container).find('.gallery_widget_attached_images img').attr('src');
	var json	= {};
	var points	= [];
	jQuery(container).find('.luv-interactive-image-holder span').remove();
	jQuery(container).find('.luv-interactive-image-points div').each(function(index){
		jQuery(this).find('span').text(index + 1);
		jQuery(this).closest('[data-vc-shortcode="luv_interactive_image"]').find('.luv-interactive-image-holder').append(jQuery('<span>',{
			'text'	: index + 1,
			'style' : 'left:' + jQuery(this).find('input').attr('data-x') + '%;top:' + jQuery(this).find('input').attr('data-y') + '%'
		}));
		points[index] = jQuery(this).find('input').val();
	});

	json	= {'image' : img, 'points': points};

	jQuery(container).find('.luv-interactive-image-picker img').attr('src', img);

	jQuery(container).find('.wpb_vc_param_value').val(JSON.stringify(json));
}


/**
 * Media uploader
 * @param target
 * @param byid use attachment id instead of URL. Default false
 */
function luv_media_upload(target, _byid) {
	byid = _byid || false;
    media_uploader = wp.media({
        frame:    "post",
        state:    "insert",
        multiple: false
    });

    media_uploader.on("insert", function(){
        var json = media_uploader.state().get("selection").first().toJSON();
        var image_url = byid === true ? json.id : json.url;
        var preview = json.url;
        target.closest('.luv-media-upload-container').find('.luv-media-upload-url').val(image_url).trigger('change');
        target.closest('.luv-media-upload-container.media-image').find('.luv-media-upload-preview').attr('src', preview).removeClass('luv-hidden').removeClass('is-hidden');
        target.next().removeClass('luv-hidden').removeClass('is-hidden');
        target.next().next().removeClass('luv-hidden').removeClass('is-hidden');
        target.text(__('Modify'));
    });

    media_uploader.open();
}

/**
 * Required Meta Box Fields
 */

function init_luv_required(){
	var fields	= jQuery('.luv-required:not(.initialized)').addClass('initialized').addClass('luv-hidden');
	var total 	= fields.length;
	var event	= new Event('luvchange');

	var iterate_fields = function(){
		var current_field = fields.get(0);
		fields = fields.slice(1);

		if (jQuery('#loader-overlay').length > 0){
			jQuery('#loader-overlay .message-text').text(__('Loading') + ' ' + (parseInt(100-(fields.length/total)*100)) + '%');
		}

		var required_name = jQuery(current_field).attr('data-required-name');
		var required_value = jQuery(current_field).attr('data-required-value');
		var compare = jQuery(current_field).attr('data-required-compare');

		jQuery(document).on('click change keyup', '[name="' + required_name + '"]', function(){
			if((jQuery(this).prop('type') !== 'checkbox' && jQuery(this).prop('type') !== 'radio') || jQuery(this).prop('checked')) {
				if(compare === '=' && required_value === jQuery(this).val() && !jQuery(this).is(':disabled')) {
					jQuery(current_field).stop(true, true).fadeIn(400).css('display', 'table').addClass('luv-required-on');
					jQuery(current_field).find('input, select').each(function(){
						if (jQuery(this).prop('disabled')){
							jQuery(this).removeProp('disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				} else if (compare === '!=' && required_value !== jQuery(this).val() && !jQuery(this).is(':disabled')) {
					jQuery(current_field).stop(true, true).fadeIn(400).css('display', 'table').addClass('luv-required-on');;
					jQuery(current_field).find('input, select').each(function(){
						if (jQuery(this).prop('disabled')){
							jQuery(this).removeProp('disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				} else {
					jQuery(current_field).stop(true, true).hide().removeClass('luv-required-on');
					jQuery(current_field).find('input, select').each(function(){
						if (!jQuery(this).prop('disabled')){
							jQuery(this).prop('disabled','disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				}
			} else if (jQuery(this).prop('type') === 'checkbox') {
				if (compare === '!=') {
					jQuery(current_field).stop(true, true).fadeIn(400).css('display', 'table').addClass('luv-required-on');;
					jQuery(current_field).find('input, select').each(function(){
						if (jQuery(this).prop('disabled')){
							jQuery(this).removeProp('disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				} else {	
					jQuery(current_field).stop(true, true).hide().removeClass('luv-required-on');
					jQuery(current_field).find('input, select').each(function(){
						if (!jQuery(this).prop('disabled')){
							jQuery(this).prop('disabled','disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				}
			}
		});

		// Run script on document load
		jQuery('[name="' + required_name + '"]').each(function(){
			if((jQuery(this).prop('type') !== 'checkbox' && jQuery(this).prop('type') !== 'radio') || jQuery(this).prop('checked')) {
				if(compare === '=' && required_value === jQuery(this).val() && !jQuery(this).is(':disabled')) {
					jQuery(current_field).stop(true, true).fadeIn(400).css('display', 'table').addClass('luv-required-on');
					jQuery(current_field).find('input, select').each(function(){
						if (jQuery(this).prop('disabled')){
							jQuery(this).removeProp('disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				} else if (compare === '!=' && required_value !== jQuery(this).val() && !jQuery(this).is(':disabled')) {
					jQuery(current_field).stop(true, true).fadeIn(400).css('display', 'table').addClass('luv-required-on');;
					jQuery(current_field).find('input, select').each(function(){
						if (jQuery(this).prop('disabled')){
							jQuery(this).removeProp('disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				} else {
					jQuery(current_field).stop(true, true).hide().removeClass('luv-required-on');
					jQuery(current_field).find('input, select').each(function(){
						if (!jQuery(this).prop('disabled')){
							jQuery(this).prop('disabled','disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				}
			} else if (jQuery(this).prop('type') === 'checkbox') {
				if (compare === '!=') {
					jQuery(current_field).stop(true, true).fadeIn(400).css('display', 'table').addClass('luv-required-on');;
					jQuery(current_field).find('input, select').each(function(){
						if (jQuery(this).prop('disabled')){
							jQuery(this).removeProp('disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				} else {	
					jQuery(current_field).stop(true, true).hide().removeClass('luv-required-on');
					jQuery(current_field).find('input, select').each(function(){
						if (!jQuery(this).prop('disabled')){
							jQuery(this).prop('disabled','disabled');
							if (jQuery('[data-required-name="'+jQuery(this).attr('name')+'"]').length > 0){
								jQuery(this).trigger('change');
							}
						}
					});
				}
			}
		});

		if (fields.length > 0){
			iterate_fields();
		}
		else{
			jQuery('.luv-required.initialized').removeClass('luv-hidden');
			if (jQuery('ul#menu-to-edit').length > 0){
				jQuery('#loader-overlay').remove();
			}
		}
	}

	// Loading overlay for menu editor
	if (jQuery('ul#menu-to-edit').length > 0){
		jQuery('body').append('<div id="loader-overlay"><p class="message-text">' + __('Loading') + '</p><div class="loader"><svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div></div>');
	}
	iterate_fields();

	window._onbeforeunload = window.onbeforeunload;
	jQuery(document).on('mousedown', '#menu-settings-column, #menu-management-liquid',function(){
		window.onbeforeunload = window._onbeforeunload;
	});
}


/**
 * Initialize ajax loaded WP Editors
 * @param DOM_object container
 */
function reinit_wp_editors(container){
	jQuery(container).find('textarea').each(function(){
		// Init Quicktag
		var editor_id = jQuery(this).attr('id');
		if ( _.isUndefined( tinyMCEPreInit.qtInit[ editor_id ] ) ) {
			window.tinyMCEPreInit.qtInit[ editor_id ] = _.extend( {},
				window.tinyMCEPreInit.qtInit[ window.wpActiveEditor ],
				{ id: editor_id } );
		}
		// Init tinymce
		if ( window.tinyMCEPreInit && window.tinyMCEPreInit.mceInit[ window.wpActiveEditor ] ) {
			window.tinyMCEPreInit.mceInit[ editor_id ] = _.extend(
				{},
				window.tinyMCEPreInit.mceInit[ window.wpActiveEditor ],
				{
					resize: 'vertical',
					height: 200,
					id: editor_id,
					setup: function ( ed ) {
						ed.on( 'init', function ( ed ) {
							ed.target.focus();
							window.wpActiveEditor = editor_id;
						} );
						ed.on('change keyup',function(){
							jQuery('#' + editor_id).val(ed.getContent());
							jQuery('#' + editor_id).trigger('change');
						});
					}
				} );
		}
		quicktags( window.tinyMCEPreInit.qtInit[ editor_id ] );
		if ( window.tinymce ) {
			window.switchEditors && window.switchEditors.go( editor_id, 'tmce' );
			tinymce.execCommand( 'mceAddEditor', true, editor_id );
		}
		window.wpActiveEditor = editor_id;
	});
}


/**
 * Insert at caret in WP editor
 */
jQuery.fn.smartInsert = function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      var sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  });
};


/**
 * Get array with unique elements
 * @param array that
 * @return array
 */
function luv_array_unique(that){
 	   var u = {}, a = [];
	   for(var i = 0, l = that.length; i < l; ++i){
	      if(u.hasOwnProperty(that[i])) {
	         continue;
	      }
	      a.push(that[i]);
	      u[that[i]] = 1;
	   }
	   return a;
}

/**
 * Localize strings
 * @param string
 * @return string
 */
 function __(string){
	return (typeof luvthemes_core.i18n[string] !== 'undefined' ? luvthemes_core.i18n[string] : string);
}
