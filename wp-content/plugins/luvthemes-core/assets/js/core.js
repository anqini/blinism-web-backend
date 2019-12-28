(function(){

	// If force redirect is present on page
	if (jQuery('[data-force-redirect]').length > 0){
		jQuery.post(luvthemes_core.ajax_url, {action : 'luv_force_redirect', nonce : jQuery('[data-force-redirect]').attr('data-force-redirect-nonce')}, function(response){
			if (response == 1){
				document.location.href = jQuery('[data-force-redirect]').attr('data-force-redirect');
			}
		});
	}

	var luv_core_initial_width	= jQuery(window).width();
	var luv_core_initial_height	= jQuery(window).height();
	var luv_animated_svg = [];
	/**
	 * Check is element in viewport
	 * @param that
	 * @returns boolean
	 */

	function luv_viewport_check(that){
		return jQuery(that).offset().top < (jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop()) + jQuery(window).height();
	}

	/**
	 * Check did element leave viewport
	 * @param that
	 * @returns boolean
	 */

	function luv_left_viewport_check(that){
		return jQuery(that).offset().top + jQuery(that).outerHeight() < (jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop());
	}

	/**
	 * Luv counter
	 */

	jQuery.fn.luvcounter = function(options){
	    jQuery(this).addClass('luv-counter-fired');

		if (jQuery(this).hasClass('luv-counter-normal')){
		    var that 	= jQuery(this);
		    var text 	= jQuery(that).attr('data-text');
		    var target	= text.match(/(\d+)/g);
		    var counter = 0;

			jQuery(this).text(jQuery(this).text().replace(/(\d+)/,'0'));

		    // Use data attributes if defined
		    options = jQuery.extend(options, jQuery(this).data());

			// Create the settings object and use defaults if value isn't set
		    var settings = jQuery.extend({
		    	speed		: 50,
		    	step		: 1,
		    }, options );

		    var speed		= settings.speed * 1 || jQuery(this).attr('data-speed') * 1 || 5;
		    var step		= settings.step * 1 || jQuery(this).attr('data-step') * 1 || 1;
		    var delay		= speed*1000/(target/step);

			var interval = setInterval(function(){
				var s = jQuery(that).text().replace(/(\d+)/,'[%d]');
		        if (counter + step <= target){
		            counter += step;
		            jQuery(that).text(s.replace('[%d]',counter));
		        }
		        else{
		        	jQuery(that).text(s.replace('[%d]',target));
		            clearInterval(interval);
		        }
		    },delay);
		}
		else if (jQuery(this).hasClass('luv-counter-bounce-from-top') && !jQuery(this).hasClass('luv-counter-prepared')){
			var html = '';
			var text = jQuery(this).text();
			for (i in text){
				html += '<span class="c-has-animation c-animate-motion-blur">' + text[i] + '</span>';
			}
			jQuery(this).addClass('luv-counter-prepared');
			jQuery(this).html(html);
		}

	};

	/**
	 * Simple countdown
	 */
	jQuery.fn.luvcountdown = function(options){
		var that 		= jQuery(this);
		var countdown	= jQuery(this).attr('data-countdown');
		var animation	= jQuery(this).attr('data-animation') || '';

		var callback 	= options.callback || null;
		var clockface	= options.clockface || 'minute	';
		var show_labels = Boolean(options.show_labels) || true;

		// Set initial value
		var years	= (countdown >= 31536000 ? parseInt(countdown/31536000) : 0);
		var months	= (countdown >= 2592000 ? parseInt((countdown-(years*31536000))/2592000) : 0);
		var days	= (countdown >= 86400 ? parseInt((countdown-(years*31536000)-(months*2592000))/86400) : 0);
		var hours	= (countdown >= 3600 ? parseInt((countdown-(years*31536000)-(months*2592000)-(days*86400))/3600) : 0);
		var minutes = (countdown >= 60 ? parseInt((countdown-(years*31536000)-(months*2592000)-(days*86400)-(hours*3600))/60) : 0);
		var seconds = (countdown-(years*31536000)-(months*2592000)-(days*86400)-(hours*3600)-(minutes*60))%60;

		// Build clock
		var container	= jQuery(that).empty();
		var section		= jQuery('<div>',{'class' : 'luv-countdown-section'});
		var _section;

		if (clockface == 'year'){
			 _section = jQuery(section).clone().appendTo(jQuery(container));
			var _years = jQuery('<div>').appendTo(_section);
			if (show_labels){
				jQuery('<div>',{'class':'luv-countdown-label', 'text': __('Years')}).appendTo(_section);
			}
		}
		if (clockface == 'month' || clockface == 'year'){
			 _section = jQuery(section).clone().appendTo(jQuery(container));
			var _months = jQuery('<div>').appendTo(_section);
			if (show_labels){
				jQuery('<div>',{'class':'luv-countdown-label', 'text': __('Months')}).appendTo(_section);
			}
		}
		if (clockface == 'day' || clockface == 'month' || clockface == 'year'){
			 _section = jQuery(section).clone().appendTo(jQuery(container));
			var _days = jQuery('<div>').appendTo(_section);
			if (show_labels){
				jQuery('<div>',{'class':'luv-countdown-label', 'text': __('Days')}).appendTo(_section);
			}
		}
		if (clockface == 'hour' || clockface == 'day' || clockface == 'month' || clockface == 'year'){
			_section = jQuery(section).clone().appendTo(jQuery(container));
			var _hours = jQuery('<div>').appendTo(_section);
			if (show_labels){
				jQuery('<div>',{'class':'luv-countdown-label', 'text': __('Hours')}).appendTo(_section);
			}
		}
		if (clockface == 'minute' || clockface == 'hour' || clockface == 'day' || clockface == 'month' || clockface == 'year'){
			_section = jQuery(section).clone().appendTo(jQuery(container));
			var _minutes = jQuery('<div>').appendTo(_section);
			if (show_labels){
				jQuery('<div>',{'class':'luv-countdown-label', 'text': __('Minutes')}).appendTo(_section);
			}
		}

		_section = jQuery(section).clone().appendTo(jQuery(container));
		var _seconds	= jQuery('<div>').appendTo(_section);
		if (show_labels){
			jQuery('<div>',{'class':'luv-countdown-label', 'text': __('Seconds')}).appendTo(_section);
		}

		//Animation
		if (animation != ''){
			jQuery(container).find('.swift-countdown-section').each(function(){
				jQuery(this).find('div:first').addClass(animation).addClass('animated');
			});
		}

		var formatNumber = function(num){
			return (num >= 10 ? num : '0' + num);
		};

		var refreshClock = function(item, value){
			value = formatNumber(value);
			if (jQuery(item).text() != value){
				if (animation != ''){
					jQuery(item).removeClass('animated').removeClass(animation);
					setTimeout(function(){
						jQuery(item).addClass('animated').addClass(animation);
					},100);
				}
				jQuery(item).text(value);
			}
		};

		var setClock = function(){
			// Years
			if (clockface == 'year'){
				var years = (countdown >= 31536000 ? parseInt(countdown/31536000) : 0);
			}
			else{
				var years = 0;
			}

			// Months
			if (clockface == 'month' || clockface == 'year'){
				var months = (countdown >= 2592000 ? parseInt((countdown-(years*31536000))/2592000) : 0);
			}
			else{
				var months = 0;
			}

			// Days
			if (clockface == 'day' || clockface == 'month' || clockface == 'year'){
				var days = (countdown >= 86400 ? parseInt((countdown-(years*31536000)-(months*2592000))/86400) : 0);
			}
			else{
				var days = 0;
			}

			// Hours
			if (clockface == 'hour' || clockface == 'day' || clockface == 'month' || clockface == 'year'){
				var hours = (countdown >= 3600 ? parseInt((countdown-(years*31536000)-(months*2592000)-(days*86400))/3600) : 0);
			}
			else{
				var hours = 0;
			}

			// Minutes
			if (clockface == 'minute' || clockface == 'hour' || clockface == 'day' || clockface == 'month' || clockface == 'year'){
				var minutes = (countdown >= 60 ? parseInt((countdown-(years*31536000)-(months*2592000)-(days*86400)-(hours*3600))/60) : 0);
			}
			else{
				var minutes = 0;
			}

			// Seconds
			if (clockface != 'second'){
				var seconds = (countdown-(years*31536000)-(months*2592000)-(days*86400)-(hours*3600)-(minutes*60))%60;
			}
			else{
				var seconds = countdown;
			}

			if (typeof _seconds !== 'undefined'){
				refreshClock(_seconds,seconds);
			}
			if (typeof _minutes !== 'undefined'){
				refreshClock(_minutes,minutes);
			}
			if (typeof _hours !== 'undefined'){
				refreshClock(_hours,hours);
			}
			if (typeof _days !== 'undefined'){
				refreshClock(_days,days);
			}
			if (typeof _months !== 'undefined'){
				refreshClock(_months,months);
			}
			if (typeof _years !== 'undefined'){
				refreshClock(_years,years);
			}
		};


		// Start countdown
		setClock();
		var interval = setInterval(function(){
	        if (countdown - 1 > 0){
	        	countdown--;
	        	setClock();
	        }
	        else{
	        	countdown = 0;
	        	setClock();
	            clearInterval(interval);
	            if (typeof callback === 'function'){
	            	callback();
	            }
	        }
	    },1000);
	};

	/**
	 * Cookie getter/setter
	 * @param name
	 * @param value
	 * @param options
	 * @returns string
	 */
	function luv_cookie(name, value, options)
	{
	    if (typeof value === "undefined") {
	        var n, v,
	            cookies = document.cookie.split(";");
	        for (var i = 0; i < cookies.length; i++) {
	            n = jQuery.trim(cookies[i].substr(0,cookies[i].indexOf("=")));
	            v = cookies[i].substr(cookies[i].indexOf("=")+1);
	            if (n === name){
	                return unescape(v);
	            }
	        }
	    } else {
	        options = options || {};
	        if (!value) {
	            value = "";
	            options.expires = -365;
	        } else {
	            value = escape(value);
	        }
	        if (options.expires) {
	            var d = new Date();
	            d.setDate(d.getDate() + options.expires);
	            value += "; expires=" + d.toUTCString();
	        }
	        if (options.domain) {
	            value += "; domain=" + options.domain;
	        }
	        if (options.path) {
	            value += "; path=" + options.path;
	        }
	        document.cookie = name + "=" + value;
	    }
	}

	/**
	 * Init Luv counters
	 */
	function luv_counter_init(){
		jQuery('.luv-counter:not(.luv-counter-fired)').each(function(){
			jQuery(this).attr('data-text',jQuery(this).text());
			if ((jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop()) + jQuery(window).height() > jQuery(this).offset().top){
				jQuery(this).luvcounter();
			}
		});
	}

	/**
	 * Page submenu init
	 */
	function luv_page_submenu() {
		if(jQuery('.page-submenu.page-submenu-onpage').length > 0) {

			var header_margin = jQuery('body[data-sticky-header-type="always"] #main-header').outerHeight()*1 + (jQuery('#wpadminbar').outerHeight()*1);
			var submenu = jQuery('.page-submenu.page-submenu-onpage');
			var container = jQuery('.page-submenu-container');
			var page_submenu_position = submenu.offset().top;
			var scroll_top = jQuery(window).scrollTop();

			if (!submenu.hasClass('page-submenu-sticky')){
				jQuery('.page-submenu.page-submenu-onpage').attr('data-submenu-position', jQuery('.page-submenu.page-submenu-onpage').offset().top);
			}

			if(scroll_top + header_margin >= jQuery('.page-submenu.page-submenu-onpage').attr('data-submenu-position')) {
				submenu.addClass('page-submenu-sticky');
				submenu.css({
					'top' :  header_margin + 'px',
				});
				container.css({
					'height' : submenu.outerHeight()+'px',
				});
			} else {
				submenu.removeClass('page-submenu-sticky');
				container.removeAttr('style');
			}
		}
	}

	/**
	 * Init Carousel
	 */
	function luv_carousel_init() {
		jQuery('.luv-carousel').each(function(){
			var infinite = jQuery(this).attr('data-luv-carousel-infinite') === 'true' ? true : false;
			var nav = jQuery(this).attr('data-luv-carousel-nav') === 'true' ? true : false;
			var dots = jQuery(this).attr('data-luv-carousel-dots') === 'true' ? true : false;
			var autoplay = jQuery(this).attr('data-luv-carousel-autoplay') === 'true' ? true : false;
			var autoplay_timeout = jQuery(this).attr('data-luv-carousel-autoplay_timeout') || 5000;
			var autoplay_pause = jQuery(this).attr('data-luv-carousel-autoplay_pause') === 'true' ? true : false;
			var transition_type = jQuery(this).attr('data-luv-carousel-transition_type') || null;
			var margin = parseInt(jQuery(this).attr('data-luv-carousel-margin')) || 0;
			var center = jQuery(this).attr('data-luv-carousel-center') === 'true' ? true : false;
			var items = jQuery(this).attr('data-luv-carousel-items') || "{'mobile' : '1'}";

			try{
				items = JSON.parse(items.replace(/'/g, '"'));

				items['desktop'] = (typeof items['desktop'] == 'undefined' ? 1 : items['desktop']);
				items['laptop'] = (typeof items['laptop'] == 'undefined' ? items['desktop'] : items['laptop']);
				items['tablet-landscape'] = (typeof items['tablet-landscape'] == 'undefined' ? items['laptop'] : items['tablet-landscape']);
				items['tablet-portrait'] = (typeof items['tablet-portrait'] == 'undefined' ? items['tablet-landscape'] : items['tablet-portrait']);
				items['mobile'] = (typeof items['mobile'] == 'undefined' ? items['tablet-landscape'] : items['mobile']);

			}
			catch (e){
				items = {
						"desktop" : "1",
						"laptop" : "1",
						"tablet-landscape" : "1",
						"tablet-portrait" : "1",
						"mobile" : "1",
				};
			}

			var carousel = jQuery(this);

			jQuery(carousel).owlCarousel({
	            responsive :{
	            	0 : {
	            		items : parseInt(items['mobile'])
	            	},
	            	460 : {
	            		items: parseInt(items['tablet-portrait'])
	            	},
	            	768 : {
	            		items: parseInt(items['tablet-landscape'])
	            	},
	            	992 : {
	            		items: parseInt(items['laptop'])
	            	},
	            	1200 : {
	            		items: parseInt(items['desktop'])
	            	},
	            },
	            margin: margin,
	            loop: infinite,
	            nav: nav,
	            dots: dots,
	            center: center,
	            autoplay: autoplay,
	            autoplayTimeout: autoplay_timeout,
	            autoplayHoverPause: autoplay_pause,
	            animateOut: transition_type,
	            navText: [],
	            autoplaySpeed: 700,
	            smartSpeed: 700,
	            baseClass: 'luv-carousel',
	            themeClass: 'luv-theme',
				itemClass: 'luv-carousel-item',
				centerClass: 'item-active',
				controlsClass: 'luv-carousel-controls',
				navContainerClass: 'luv-carousel-nav',
				dotClass: 'luv-carousel-dot',
				dotsClass: 'luv-carousel-dots',
				autoHeightClass: 'luv-carousel-height',
				onInitialized: init
			});

			function init(){
				jQuery(carousel).css('display','block');
			}

			carousel.on('change.owl.carousel', function(event){
				jQuery(carousel).find('video').each(function(){
					jQuery(this).get(0).pause();
				});

				setTimeout(function(){
					if (jQuery(carousel).find('.active video').length > 0 && jQuery(carousel).find('.active video').prop('autoplay')){
						jQuery(carousel).find('.active video').get(0).play();
					}
				},300);

			});

			luv_parallax_carousel(carousel);
			luv_full_height_carousel();
		});
	}

	/**
	 * Parralax carousel
	 * @param object carousel
	 */
	function luv_parallax_carousel(carousel) {

		var header_height = jQuery('header#main-header').outerHeight();

		jQuery('[data-luv-carousel-parallax="true"]').each(function(){
			var wrapper = jQuery(this).parent('.luv-carousel-wrapper');
			var content = jQuery(this).find('.luv-carousel-inner');

			var carousel_height = jQuery(wrapper).outerHeight();
			var carousel_content_height = jQuery(content).outerHeight();
			var scroll_top = jQuery(window).scrollTop();

			if(jQuery(wrapper).offset().top-scroll_top <= 0) {
				jQuery(content).css({
					'opacity' : 1-(1/(carousel_height+(carousel_content_height/2)))*scroll_top
				});

				jQuery(this).stop(true, true).transition({
					y: (scroll_top-jQuery(wrapper).offset().top)*0.5
				},0);
			} else {
				jQuery(this).stop(true, true).transition({
					y: 0
				},0);

				jQuery(content).css({
					'opacity' : 1
				});
			}
		});
	}

	/**
	 * Full height carousel
	 */
	function luv_full_height_carousel() {
		// If the header is full height we should set it to the window's height
		if(jQuery('[data-luv-carousel-full_height="true"]').length > 0) {
			jQuery('[data-luv-carousel-full_height="true"]').each(function(){
				// The size is reduced with the height of the elements above
				var header_margin = jQuery('#main-header').outerHeight() + (jQuery('#wpadminbar').outerHeight()*1);
				var height 		  = (jQuery(window).height() - header_margin);
				jQuery(this).find('.luv-carousel-item, .luv-carousel-item > .container').css({
					'height' : height,
					'max-height' : height,
				});
			});
		}
	}

	/**
	 * Multi scroll
	 */

	function luv_multiscroll(){
		if (jQuery('.luv-multiscroll').length > 0){
			jQuery('.luv-multiscroll').multiscroll({
		        verticalCentered : true,
		        scrollingSpeed: 700,
		        easing: 'easeInQuart',
		        menu: false,
		        sectionsColor: [],
		        navigation: true,
		        navigationPosition: 'right',
		        navigationColor: '#000',
		        navigationTooltips: [],
		        loopBottom: false,
		        loopTop: false,
		        css3: false,
		        paddingTop: 0,
		        paddingBottom: 0,
		        normalScrollElements: null,
		        keyboardScrolling: true,
		        touchSensitivity: 5,

		        // Custom selectors
		        sectionSelector: '.luv-multiscroll-section',
		        leftSelector: '.luv-multiscroll-left',
		        rightSelector: '.luv-multiscroll-right',

		        //events
		        onLeave: function(index, nextIndex, direction){},
		        afterLoad: function(anchorLink, index){
		        	jQuery('.luv-multiscroll').find('.c-animated').removeClass('c-animation-queued').removeClass('c-animated').addClass('c-has-animation');
		        	luv_play_c_animation();
		        },
		        afterRender: function(){},
		        afterResize: function(){},
		    });

		}
	}

	/**
	 * Play icon animations
	 */
	function luv_play_icon_animations(){
		if (jQuery('.luv-animated-svg:not(.icon-animation-queued)').length != 0){
			var index = 0;
			jQuery('.luv-animated-svg:not(.icon-animation-queued)').each(function(){

				if (jQuery(this).parent().offset().top < (jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop()) + jQuery(window).height()){
					if (jQuery(this).parent().offset().top + jQuery(this).height() < (jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop())){
						var delay = 0;
					}
					else{
						var delay =  index * 300;
						index++;
					}

					var that = jQuery(this);
					var type = jQuery(this).attr('data-type') || 'oneByOne';
					jQuery(that).addClass('icon-animation-queued');
					try{
						setTimeout(function(){
							jQuery(that).addClass('icon-animation-fired');
							luv_animated_svg[jQuery(that).attr('id')] = new Vivus(jQuery(that).attr('id'), {type: type, start: 'manual', animTimingFunction: Vivus.EASE, duration: 100}).play();
							// Add color
							try{
								if (jQuery(that).attr('data-color') != ''){
									var svgElement	= jQuery(that)[0];
									var svgColor	= jQuery(that).attr('data-color');
									setTimeout(function(){
										var svgDoc = svgElement.contentDocument;
										var styleElement = svgDoc.createElementNS('http://www.w3.org/2000/svg', 'style');
										styleElement.textContent = '* { stroke: ' + svgColor + '}';
										svgDoc.getElementsByTagName('svg')[0].appendChild(styleElement);
									},100);
								}
							}catch(e){
								console.log(e.message);
							}
						},delay);
					}
					catch(e){
						jQuery(that).addClass('icon-animation-fired');
						luv_animated_svg[jQuery(that).attr('id')] = new Vivus(jQuery(that).attr('id'), {type: type, start: 'manual', animTimingFunction: Vivus.EASE, duration: 100}).play();
						// Add color
						try{
							if (jQuery(that).attr('data-color') != ''){
								var svgElement	= jQuery(that)[0];
								var svgColor	= jQuery(that).attr('data-color');
								setTimeout(function(){
									var svgDoc = svgElement.contentDocument;
									var styleElement = svgDoc.createElementNS('http://www.w3.org/2000/svg', 'style');
									styleElement.textContent = '* { stroke: ' + svgColor + '}';
									svgDoc.getElementsByTagName('svg')[0].appendChild(styleElement);
								},100);
							}
						}catch(e){
							console.log(e.message);
						}
					}
				}
			});
		}
	}

	/**
	 * Play column animations
	 */
	function luv_play_c_animation(){
		if (jQuery('body.is-loading').length > 0){
			return;
		}
		var now = Date.now();
		var last = 0;
		var delay = 0;
		var step = window.luv_c_animation_step || 300;

		jQuery('.c-has-animation.c-animation-queued').each(function(i){
			if (luv_left_viewport_check(jQuery(this))){
				jQuery('.c-has-animation.c-animation-queued').each(function(){
					jQuery(this).removeAttr('data-c-animation-ends');
					jQuery(this).removeClass('c-animation-queued');
					clearTimeout(jQuery(this).luv_animation);
				});
				jQuery(this).removeClass('c-has-animation');
				jQuery(this).addClass('c-animated appended');
			}

			if (luv_viewport_check(jQuery(this))){
				last = (parseInt(jQuery(this).attr('data-c-animation-ends')) > last ? parseInt(jQuery(this).attr('data-c-animation-ends')) : last);
			}
		});

		delay = (last == 0 ? 100 : Math.abs(last-now));

		jQuery('.c-has-animation:not(.c-animation-queued)').each(function(i){
			var that = jQuery(this);
			delay += step;
			if (luv_viewport_check(jQuery(that))){
				jQuery(that).addClass('c-animation-queued');
				jQuery(that).attr('data-c-animation-ends', now + delay);
				jQuery(that).luv_animation = setTimeout(function(){
					if (jQuery(that).hasClass('c-has-animation')){
						jQuery(that).removeClass('c-has-animation');
						jQuery(that).addClass('c-animated appended');
						// Hit lazy load again
						if (typeof fevr_lazy_load_images === 'function'){
							fevr_lazy_load_images();
						}
						setTimeout(luv_counter_init, 1000);
						jQuery(that).find('.icon-animation-fired').removeClass('icon-animation-fired').removeClass('icon-animation-queued');
						luv_play_icon_animations();
					}
				},delay);
			}
		});
	}

	/**
	 * Play background animations
	 */
	function luv_play_bg_animation(){
		if (jQuery('.luv-bg-animation').length != 0){
			jQuery('.luv-bg-animation').each(function(){
				var that	= jQuery(this);
				var i 		= (jQuery(that).hasClass('luv-bg-animation-left-to-right') ? 20000 : -20000);
				var speed	= (jQuery(that).hasClass('luv-bg-animation-slow') ? 1500 : (jQuery(that).hasClass('luv-bg-animation-fast') ? 700 : 1000));

				jQuery(that).attr('current-bg-position', i);
				jQuery(that)[0].style.setProperty('background-position', i + 'px 50%', 'important');

				setInterval(function(){
					var cur = jQuery(that).attr('current-bg-position')*1 || 0
					jQuery(that).attr('current-bg-position', cur + i);
					jQuery(that)[0].style.setProperty('background-position', (cur + i) + 'px 50%', 'important');
				},speed*1000);
			});
		}
	}

	/**
	 * Init animated lists
	 */
	function luv_init_animated_list(){
		jQuery('.luv-animated-list:not(.c-animation-queued)').each(function(){
			if (jQuery(this).offset().top + jQuery(this).height() < (jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop()) + jQuery(window).height()){
				var list = jQuery(this);
				jQuery(this).addClass('c-animation-queued');
				jQuery(list).find('li').removeClass('c-animation-queued');
			}
		});
		luv_play_c_animation();
	}

	/**
	 * Social Share
	 */

	jQuery('.social-share-popup').click(function(e){
		e.preventDefault();
		jQuery(this).trigger('blur');
		window.open (jQuery(this).attr('href'), '_blank', 'height=400,width=660,menubar=0,status=0,resizable=0,toolbar=0,location=0,scrollbars=0');
	});

	/**
	 * Load share counts
	 */
	jQuery('[data-luv-share-count]').each(function(){
		var channel = jQuery(this).attr('data-luv-share-count');
		var url		= jQuery(this).attr('data-luv-share-url');
		var that 	= jQuery(this);
		// Use pinterest JSONP API
		if (channel == 'pinterest'){
			jQuery.getJSON('//widgets.pinterest.com/v1/urls/count.json?source=6&url=' + url + '&callback=?', function(data){
				try{
					var count = (data.count > 1000000 ? (parseInt(data.count/100000)/10) + 'M' : (count > 1000 ? (parseInt(data.count/100)/10) + 'k' : data.count));
					jQuery(that).empty().text(data.count);
				}
				catch(e){
					// Silent fail on parse error
				}
			});
		}
		// Use bypassed APIs for everything else
		else{
			jQuery(this).load(luvthemes_core.ajax_url, {'action': 'luv_share_count', 'channel' : channel, 'url' : url});
		}
	});


	/**
	 * Google Analytics inview event
	 */
	function luv_ga_inview(){
		if (jQuery('.luv-ga-inview').length > 0){
			jQuery('.luv-ga-inview').each(function(){
				if (!jQuery(this).hasClass('ga-event-sent') && jQuery(this).css('visibility') != 'hidden' && ((jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop()) + jQuery(window).height() > jQuery(this).offset().top)){
					var event_category	= jQuery(this).attr('data-event-category') || '';
					var event_action	= jQuery(this).attr('data-event-action') || '';
					var event_label		= jQuery(this).attr('data-event-label') || '';
					var event_value 	= jQuery(this).attr('data-event-value') || '';

					if (typeof ga === 'function'){
						ga('send', 'event', event_category, event_action, event_label, event_value);
						jQuery(this).addClass('ga-event-sent');
					}
				}
			});
		}
	}

	/**
	 * Perspective select
	 */

	function luv_init_perspective_select(){
		jQuery('.luv-perspective-select').each(function(){
			jQuery(this).css('margin', '-' + (jQuery(this).height()/4) + 'px auto');
		});
	}

	/**
	 * Init image slide boxes
	 */
	function luv_init_slide_boxes(){
		jQuery('.luv-image-slide-box').each(function(){
		  var center = jQuery(this).find('li:nth-child(' + (parseInt(jQuery(this).find('li').length/2)+1)+')').addClass('center');
		  jQuery(this).find('img').css('max-width', (jQuery(this).parent().width()/((jQuery(this).find('li').length+1)/2)) + 'px');
		  jQuery(center).find('img').width(jQuery(center).find('img').attr('width') + 'px');

		  var width  = jQuery(center).find('img').width();
		  var height = jQuery(center).find('img').attr('height')/jQuery(center).find('img').attr('width')*width;
		  jQuery(this).height(height + 'px');

		  jQuery(center).css({
		    'left': (jQuery(center).parent().width()/2) - width/2,
		    'z-index' : 101
		  });
		  jQuery(center).find('img').height(height);

		  jQuery(center).prevAll('li').each(function(index){
		    jQuery(this).addClass('left');
		    jQuery(this).css({
		      'width': (width*(Math.pow(0.9, index+1))) + 'px',
		      'left': jQuery(this).next().position().left,
		      'z-index':  100 - index
		    });
		    jQuery(this).find('img').css({
		    	'width' : (width*(Math.pow(0.9, index+1))) + 'px',
		    	'height' : 'auto'
		    });
		  });

		  jQuery(center).nextAll('li').each(function(index){
		    jQuery(this).addClass('right');
		    jQuery(this).css({
		      'width' : (width*(Math.pow(0.9, index+1))) + 'px',
		      'left': jQuery(this).prev().position().left + parseInt(jQuery(this).prev().width()) -parseInt(jQuery(this).width()),
		      'z-index': 100-index
		    });
		    jQuery(this).find('img').css({
		    	'width' : (width*(Math.pow(0.9, index+1))) + 'px',
		    	'height' : 'auto'
		    });
		  });
		});
		luv_animate_slide_boxes();
	}

	/**
	 * Animate image slide boxes
	 */
	function luv_animate_slide_boxes(){
	  jQuery('.luv-image-slide-box').each(function(){
	    var scroll = (jQuery('html').scrollTop() > 0 ? jQuery('html').scrollTop() : jQuery('body').scrollTop()) - jQuery(this).offset().top + jQuery(window).height()*0.66;
	    var center = jQuery(this).find('.center');

	    jQuery(jQuery(this).find('.left').get().reverse()).each(function(){
	      if ((parseInt(jQuery(this).next().position().left) - scroll > parseInt(jQuery(this).next().position().left) + parseInt(jQuery(this).next().width()/2) - parseInt(jQuery(this).width())) && (parseInt(jQuery(this).next().position().left) - scroll < jQuery(this).next().position().left)){
	        var pos = jQuery(this).next().position().left - scroll;
	      }
	      else if (parseInt(jQuery(this).next().position().left) - scroll > jQuery(this).next().position().left){
	        var pos = jQuery(this).next().position().left;
	      }
	      else{
	        var pos = parseInt(jQuery(this).next().position().left) + parseInt(jQuery(this).next().width()/2) - parseInt(jQuery(this).width());
	      }
	      jQuery(this).css({
	        left: pos
	      });
	    });

	    jQuery(this).find('.right').each(function(){
	      if ((jQuery(this).prev().position().left + scroll + jQuery(this).prev().width() - jQuery(this).width() < parseInt(jQuery(this).prev().position().left) + parseInt(jQuery(this).prev().width()/2)) && (parseInt(jQuery(this).prev().position().left) + scroll - jQuery(this).width() > jQuery(this).prev().position().left - jQuery(this).prev().width())){
	        var pos = jQuery(this).prev().position().left + scroll + jQuery(this).prev().width() - jQuery(this).width();
	      }
	      else if (parseInt(jQuery(this).prev().position().left) + scroll + jQuery(this).width() < jQuery(this).prev().position().left + jQuery(this).prev().width()){
	        var pos = jQuery(this).prev().position().left + jQuery(this).prev().width() - jQuery(this).width();
	      }
	      else{
	        var pos = parseInt(jQuery(this).prev().position().left) + parseInt(jQuery(this).prev().width()/2);
	      }
	      jQuery(this).css({
	        left: pos
	      });
	    });

	  });
	}


	/**
	 *  Init sticky columns
	 */
	function init_sticky_columns(){
		jQuery(function() {
			jQuery('.luv-sticky-column').each(function() {
				if (jQuery(this).css('position') != 'fixed' && jQuery(this).css('position') != 'absolute'){
					jQuery(this).attr('data-top', jQuery(this).offset().top);
					jQuery(this).attr('data-left', jQuery(this).offset().left);
					jQuery(this).attr('data-width', jQuery(this).width());
				}
			});
		});
	}

	/**
	 * Animate sticky columns
	 */
	function animate_sticky_columns(){
		jQuery('.luv-sticky-column').each(function(){
			var parent = jQuery(this).attr('data-parent') || (jQuery(this).closest('.vc_row').length > 0 ? jQuery(this).closest('.vc_row') : jQuery(this).closest('.container'));
		    	if (jQuery(window).width() > 768 && (jQuery(this).attr('data-top') < jQuery(window).scrollTop() + jQuery('#main-header-outer').outerHeight())){
			      if(jQuery(window).scrollTop() + jQuery('#main-header-outer').outerHeight() + jQuery(this).outerHeight() < jQuery(parent).offset().top + jQuery(parent).height()){
			          var top = jQuery('#main-header-outer').outerHeight();
			          var pos = 'fixed';
			      }
			      else{
			          var top = jQuery('#main-header-outer').outerHeight() - (jQuery(window).scrollTop() + jQuery('#main-header-outer').outerHeight() + jQuery(this).outerHeight() - (jQuery(parent).offset().top + jQuery(parent).height()));
			      }
			      jQuery(this).css({
			        'position' : pos,
			        'top' : top,
			        'left': (parseInt(jQuery(this).attr('data-left')) + parseInt(jQuery(this).css('padding-left').replace(/(\D+)/,''))) + 'px',
			        'width' : jQuery(this).attr('data-width')
			      });
		    	}
			else{
		 		jQuery(this).css({
			            'position' : 'static'
			      });
			}
		});
	}


	// Set global scope for luvthemes init.js
	window.fevr_play_c_animation = luv_play_c_animation;
	window.fevr_carousel_init = luv_carousel_init;
	window.fevr_animate_slide_boxes = luv_animate_slide_boxes;
	window.fevr_init_slide_boxes = luv_init_slide_boxes;

// Bindings
jQuery(function(){

		// Button animation
		jQuery('.btn-hover-animation').on('mouseenter', function(){
			var that = jQuery(this);
			jQuery(that).removeClass('animated').removeClass(jQuery(that).attr('data-animation'));
			setTimeout(function(){
				jQuery(that).addClass('animated').addClass(jQuery(that).attr('data-animation'));
			},100);
		});

		// Tooltip
		if (jQuery('.luv-tooltip').length > 0){
			jQuery('.luv-tooltip').each(function(){
				jQuery(this).tipso({
					 background: jQuery(this).attr('data-tooltip-background-color'),
					 color: jQuery(this).attr('data-tooltip-color'),
				});
			});
		}

		// Message box shortcode
		jQuery(document).on('click', '.luv-message-box-close-trigger', function() {
			var animation	= jQuery(this).attr('data-animation') || 'hide';
			var duration 	= (animation == 'hide' ? 0 : 1000);
			jQuery(this).parent()[animation](duration);
		});

		// Accordion shortcode
		jQuery(document).on('click', '.luv-accordion-item a.luv-accordion-title', function(e) {
			e.preventDefault();
			if (!jQuery(this).closest('li').hasClass('accordion-item-active')){
				var target_tab = jQuery(this).attr('href').slice(1);
				// we remove all active states and close the contents
				jQuery(this).closest('.luv-accordion-items').find('li').removeClass('accordion-item-active');
				jQuery(this).closest('.luv-accordion-items').find('.luv-accordion-content').slideUp();

				jQuery(this).parent().addClass('accordion-item-active');
				jQuery(this).next().slideDown().find('.luv-slider-wrapper').css({'min-height' : '1px', 'height' : 'auto'});

				// Play animations
				jQuery(this).next().find('.c-animated').removeClass('c-animation-queued').removeClass('c-animated').addClass('c-has-animation');
				luv_play_c_animation();

				//Renit inner sliders/carousels
				window.dispatchEvent(new Event('resize'));
			}
		});

		// Tabs shortcode
		jQuery(document).on('click', '.luv-tabs-nav a', function(e) {
			e.preventDefault();
			var target_tab = jQuery(this).attr('href').slice(1);
			// we remove all active states
			jQuery(this).closest('.luv-tabs-nav').find('li').removeClass('active-tab');

			// ..and we add for the clicked element
			jQuery(this).parent().addClass('active-tab');

			// Same with the contents
			jQuery(this).closest('.luv-tabs').find('.luv-tabs-content').removeClass('active-content');
			jQuery(this).closest('.luv-tabs').find('.'+target_tab).addClass('active-content');

			// Play animations
			jQuery(this).closest('.luv-tabs').find('.'+target_tab).find('.c-animated').removeClass('c-animation-queued').removeClass('c-animated').addClass('c-has-animation');
			luv_play_c_animation();

			//Reinit inner sliders/carousels
			window.dispatchEvent(new Event('resize'));
		});

		// Ajax search
		var luv_ajax_search_timeout;
		jQuery(document).on('keyup click', '.luv-search-ajax', function(e) {
			var that = jQuery(this);

			if (jQuery(that).val() != ''){
				jQuery(that).next('.luv-ajax-results').empty().append(
					jQuery('<div>',
						{'class' : 'luv-ajax-loader'}).append(
						jQuery('<i>', {
							'class': 'fa fa-spinner fa-spin'
						})
					)
				).removeClass('luv-hidden').stop().fadeIn(400);
			}

			try{
				if ((e.type == 'keyup' && (e.key.match(/^(\w|\s){1}$/) || e.keyCode == 8 || e.keyCode == 46))){
					luv_ajax_search_timeout = setTimeout(function(){luv_ajax_search(that);},500);
				}
				else if (e.type == 'click'){
					luv_ajax_search(that);
				}
			}
			catch(e){
				luv_ajax_search(that);
			}
		});

		// Clear timeout on typing
		jQuery(document).on('keydown', '.luv-search-ajax', function() {
			clearTimeout(luv_ajax_search_timeout);
		});

		// Hide search
		jQuery(document).on('blur keypress', '.luv-search-ajax', function(e) {
			if (e.type != 'keypress' || e.keyCode == 27){
				jQuery(this).next('.luv-ajax-results').stop().fadeOut(400);
				clearTimeout(luv_ajax_search_timeout);
			}
		});

		// Load search results
		function luv_ajax_search(that){
			var result_container = jQuery(that).next('.luv-ajax-results');
			if (jQuery(that).val() == ''){
				jQuery(result_container).stop().fadeOut(400);
				setTimeout(function(){jQuery(result_container).empty();},400);
			}
			else{
				var search_data = 'action=luv_ajax_search&' + jQuery(that).closest('form').serialize();
				jQuery.post(luvthemes_core.ajax_url, search_data, function(response){
					jQuery(result_container).empty().append(response);
				});
			}
		}

		// Ajax login
		jQuery(document).on('submit','.luv-ajax-login',function(e){
			e.preventDefault();
			var that = jQuery(this);
			jQuery(that).parent().addClass('luv-ajax-login-loading');
			jQuery(that).parent().removeClass('error').removeClass('success');
			jQuery(that).parent().children('.luv-ajax-login-message').empty();
			jQuery.post(luvthemes_core.ajax_url, jQuery(that).serialize(), function(response){
				jQuery(that).parent().removeClass('luv-ajax-login-loading');
				try{
					if (response['status'] == 1){
						jQuery(that).parent().children('.luv-ajax-login-message').text(__('Successfull login'));
						jQuery(that).parent().addClass('success');
						setTimeout(function(){
							jQuery(that).closest('.luv-ajax-login-container').replaceWith(jQuery('<a>',{
								'href' : jQuery(that).closest('.luv-ajax-login-container').attr('data-logout-url'),
								'text' : __('Logout')
							}));
						},1500);
						if (response['redirect_to'] != ''){
							document.location.href = response['redirect_to'];
						}
					}
					else if (response['status'] == 2){
						jQuery(that).parent().children('.luv-ajax-login-message').text(response['message']);
						jQuery(that).parent().addClass('success');
						jQuery(that).closest('.luv-ajax-login-container').find('.luv-password-recovery-trigger').trigger('click');
					}
					else{
						jQuery(that).parent().addClass('error');
						jQuery(that).parent().children('.luv-ajax-login-message').text(response['message']);
					}
				}
				catch(e){
					jQuery(that).parent().addClass('error');
					jQuery(that).parent().children('.luv-ajax-login-message').text(__('Unknown error'));
				}
			});
		});

		jQuery(document).on('click', '.luv-password-recovery-trigger, .luv-back-to-login-trigger', function(e){
			e.preventDefault();
			jQuery(this).closest('.luv-ajax-login-container').find('form').toggleClass('is-hidden');
		});

		// Ajax register
		jQuery(document).on('submit','.luv-ajax-register',function(e){
			e.preventDefault();
			var that = jQuery(this);
			jQuery(that).parent().addClass('luv-ajax-register-loading');
			jQuery(that).parent().removeClass('error').removeClass('success');
			jQuery(that).parent().children('.luv-ajax-register-message').empty();
			jQuery.post(luvthemes_core.ajax_url, jQuery(that).serialize(), function(response){
				jQuery(that).parent().removeClass('luv-ajax-register-loading');
				try{
					if (response['status'] == 1){
						jQuery(that).parent().children('.luv-ajax-register-message').text(response['message']);
						jQuery(that).parent().addClass('success');
						if (response['redirect_to'] != ''){
							document.location.href = response['redirect_to'];
						}
					}
					else{
						jQuery(that).parent().addClass('error');
						jQuery(that).parent().children('.luv-ajax-register-message').text(response['message']);
					}
				}
				catch(e){
					jQuery(that).parent().addClass('error');
					jQuery(that).parent().children('.luv-ajax-register-message').text(__('Unknown error'));
				}
			});
		});

		// Expandable row
		jQuery(document).on('click', '.luv-expandable-row', function(e){
			e.preventDefault();
			var that = jQuery(this);
			jQuery(that).css('max-height', '1000px').addClass('expanded');
			setTimeout(function(){
				jQuery(that).css('max-height','unset');
			},2000);
		});


		// Load lazy load snippets
		if (jQuery('.luv-lazy-snippet:not(.loaded)').length > 0){
			jQuery('.luv-lazy-snippet:not(.loaded)').each(function(){
				var that = jQuery(this);
				setTimeout(function() {
					jQuery(that).load(luvthemes_core.ajax_url + '?action=luv_load_snippet', {id: jQuery(that).attr('data-snippet')}, function(){
						jQuery(that).addClass('loaded');
						//Renit inner sliders/carousels
						window.dispatchEvent(new Event('resize'));
					});
				},100);
			});
		}

		// Init popups

		// Welcome popup
		if (jQuery('.luv-welcome-popup').length > 0){
			jQuery('.luv-welcome-popup').each(function(){
				setTimeout(luv_welcome_popup, jQuery(this).attr('data-welcome-popup-delay')*1000);
			});
		}

		// Exit popup
		if (jQuery('.luv-exit-popup').length > 0){
			// Bind touch devices
			if (true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch)){
				jQuery(window).on('load',function(){
					setTimeout(function(){
						history.pushState(null, null, '');
						window.addEventListener('popstate', luv_exit_popup);
					},1000);
				});
			}

			// Bind mouse event after 1 sec
			setTimeout(function(){
				// Exit intent
				function addEvent(obj, evt, fn) {
				    if (obj.addEventListener) {
				        obj.addEventListener(evt, fn, false);
				    }
				    else if (obj.attachEvent) {
				        obj.attachEvent("on" + evt, fn);
				    }
				}
				// Exit intent trigger
				addEvent(document, 'mouseout', function(evt) {
				    if (evt.toElement == null && evt.relatedTarget == null ) {
							luv_exit_popup();
				    }
				});
			},1000);
		}

		// Show popups

		// Welcome popup
		function luv_welcome_popup() {
			if (jQuery('.luv-popup-overlay').length == 0 && jQuery('.luv-welcome-popup:not(.luv-popup-closed)').length > 0){
				// Show the welcome popup
				var overlay = jQuery('<div>',{
					'class' : 'luv-popup-overlay'
				}).appendTo('body');
				var popup = jQuery('.luv-welcome-popup:not(.luv-popup-closed):first');
				jQuery(overlay).css('display','block').fadeIn();
				jQuery(popup).children('.vc_row').prepend(jQuery('<a>',{
					'class' : 'luv-popup-close',
					'html'	: '<i class="fa fa-times"></i>',
					'href'	: '#'
				}));
				jQuery(popup).addClass('luv-visible');
				// Play animations
				jQuery(popup).find('.c-animated').removeClass('c-animation-queued').removeClass('c-animated').addClass('c-has-animation');
				luv_play_c_animation();
				// Enable scroll for smaller screens
				if (jQuery(window).height() < jQuery(popup).outerHeight()){
					if (jQuery(window).width() < 768){
						jQuery(popup).css('width','100%').css('overflow','hidden');
					}
					jQuery(popup).get(0).style.setProperty('position','absolute','important');
					jQuery('html, body').stop().animate({scrollTop : jQuery(popup).offset().top + 'px'}, 1000);
				}

				// Tracking
				luv_ga_inview();
			}
			else if (jQuery('.luv-popup-overlay').length > 0 && jQuery('.luv-welcome-popup:not(.luv-popup-closed)').length > 0){
				setTimeout(luv_welcome_popup, 5000);
			}
	    }


		// Exit popup
		function luv_exit_popup() {
			if (jQuery('.luv-popup-overlay').length == 0 && jQuery('.luv-exit-popup:not(.luv-popup-closed)').length > 0){
					// Show the exit popup
					var overlay = jQuery('<div>',{
						'class' : 'luv-popup-overlay'
					}).appendTo('body');
					var popup = jQuery('.luv-exit-popup:not(.luv-popup-closed):first');
					jQuery(overlay).css('display','block').fadeIn();
					jQuery(popup).children('.vc_row').prepend(jQuery('<a>',{
						'class' : 'luv-popup-close',
						'html'	: '<i class="fa fa-times"></i>',
						'href'	: '#'
					}));
					jQuery(popup).addClass('luv-visible');
					// Play animations
					jQuery(popup).find('.c-animated').removeClass('c-animation-queued').removeClass('c-animated').addClass('c-has-animation');
					luv_play_c_animation();
					// Enable scroll for smaller screens
					if (jQuery(window).height() < jQuery(popup).outerHeight()){
						if (jQuery(window).width() < 768){
							jQuery(popup).css('width','100%').css('overflow','hidden');
						}
						jQuery(popup).get(0).style.setProperty('position','absolute','important');
						jQuery('html, body').stop().animate({scrollTop : jQuery(popup).offset().top + 'px'}, 1000);
					}

					// Tracking
					luv_ga_inview();
			}
	    }

		// Close popups
		jQuery(document).on('click', '.luv-popup-overlay, .luv-popup-close', function(e){
			e.preventDefault();
			var overlay = jQuery('.luv-popup-overlay').addClass('luv-overlay-hidden');
			jQuery('.luv-popup.luv-visible').addClass('luv-popup-closed').removeClass('luv-visible');
			setTimeout(function(){
				jQuery(overlay).remove();
			},999);
		});

		// Init countdowns
		if (jQuery('.luv-countdown').length > 0){
			jQuery('.luv-countdown').each(function(){
				var clockface = jQuery(this).attr('data-clockface') || 'day';
				var show_labels = jQuery(this).attr('data-labels') || 'false';
				jQuery(this).luvcountdown({'clockface':clockface, 'show_labels' : show_labels});
			});
		}

		// Luv Custom Grid Filter
		var custom_grid_timeout;
		jQuery(document).on('change keyup','.luv-custom-grid-filter, .luv-custom-grid-container .page-numbers',function(e){
			// Silent fail for clearTimeout
			try{
				clearTimeout(custom_grid_timeout);
			}
			catch(e){
				console.log(e.message);
			}
			var data = jQuery(this).closest('.luv-custom-grid').data();
			data.filters = [];
			data.paged = 1;
			jQuery(this).closest('.luv-custom-grid').find('.luv-custom-grid-filter').each(function(){
				if ((jQuery(this).prop('type') != 'radio' && jQuery(this).prop('type') != 'checkbox') || jQuery(this).prop('checked')){
					var options = jQuery(this).data();
					options.value = jQuery(this).val();
					data.filters.push(options);
				}
			});

			// Load content
			var that = jQuery(this);
			var timeout = e.type == 'keyup' ? (window.luv_custom_grid_type_delay || 500) : 0;
			custom_grid_timeout = setTimeout(function(){
				// Add overlay while loading
				jQuery(that).closest('.luv-custom-grid').find('.luv-custom-grid-overlay').remove();
				jQuery(that).closest('.luv-custom-grid').find('.luv-custom-grid-container').prepend(
						jQuery('<div>', {
							'class' : 'luv-custom-grid-overlay'
						}).append(jQuery('<i>', {
							'class' : 'fa fa-spinner fa-pulse'
						}))
				);

				jQuery(that).closest('.luv-custom-grid').find('.luv-custom-grid-container').load(luvthemes_core.ajax_url + '?action=custom_grid_filter', {'grid_data' : data});
			}, timeout);
		});

		// Custom grid filter pagination
		jQuery(document).on('click','.luv-custom-grid-container .page-numbers',function(e){
			e.preventDefault();
			var data = jQuery(this).closest('.luv-custom-grid').data();
			var page = (typeof jQuery(this).attr('href') !== 'undefined' ? (jQuery(this).attr('href').match(/paged=(\d*)/) ? jQuery(this).attr('href').match(/paged=(\d*)/) : jQuery(this).attr('href').match(/page\/(\d*)/)) : 1);
			data.paged = (page === null ? 1 : page[1]);
			data.filters = [];
			jQuery(this).closest('.luv-custom-grid').find('.luv-custom-grid-filter').each(function(){
				if ((jQuery(this).prop('type') != 'radio' && jQuery(this).prop('type') != 'checkbox') || jQuery(this).prop('checked')){
					var options = jQuery(this).data();
					options.value = jQuery(this).val();
					data.filters.push(options);
				}
			});

			// Add overlay while loading
			jQuery(this).closest('.luv-custom-grid').find('.luv-custom-grid-overlay').remove();
			jQuery(this).closest('.luv-custom-grid').find('.luv-custom-grid-container').prepend(
					jQuery('<div>', {
						'class' : 'luv-custom-grid-overlay'
					}).append(jQuery('<i>', {
						'class' : 'fa fa-spinner fa-pulse'
					}))
			);

			// Load content
			jQuery(this).closest('.luv-custom-grid').find('.luv-custom-grid-container').load(luvthemes_core.ajax_url + '?action=custom_grid_filter', {'grid_data' : data});
		});
		
		//  Perspective hover animation
		if(jQuery('.masonry-perspective').length > 0) {
			var tiltSettings =
			{
				imgWrapper : {
					translation : {x: 10, y: 10, z: 30},
					rotation : {x: 0, y: -10, z: 0},
					reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
				},
				lines : {
					translation : {x: 10, y: 10, z: [0,70]},
					rotation : {x: 0, y: 0, z: -2},
					reverseAnimation : {duration : 2000, easing : 'easeOutExpo'}
				},
				caption : {
					rotation : {x: 0, y: 0, z: 2},
					reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
				},
				overlay : {
					translation : {x: 10, y: -10, z: 0},
					rotation : {x: 0, y: 0, z: 2},
					reverseAnimation : {duration : 2000, easing : 'easeOutExpo'}
				},
				shine : {
					translation : {x: 100, y: 100, z: 0},
					reverseAnimation : {duration : 200, easing : 'easeOutQuad'}
				}
			};
			
			jQuery('.masonry-perspective').each(function(){
				new TiltFx(jQuery(this)[0], tiltSettings);
			});
		}

		// Same height carousel slides
		function luv_equal_height(){
			if (jQuery('.luv-same-height').length > 0){
				jQuery('.luv-same-height').each(function(){
					var height = 0;
					var content_alignment = jQuery(this).attr('data-content-alignment');
					jQuery(this).find('li').each(function(){
						if (typeof jQuery(this).attr('data-padding-top') === 'undefined'){
							jQuery(this).attr('data-padding-top',jQuery(this).css('padding-top').replace(/(\D*)/g,''));
							jQuery(this).attr('data-padding-bottom',jQuery(this).css('padding-bottom').replace(/(\D*)/g,''));
							jQuery(this).css('overflow','auto');
						}

						jQuery(this).css('padding-top',0).css('padding-bottom',0);

						if (jQuery(this).outerHeight() > height){
							height = jQuery(this).outerHeight();
						}
					});
					jQuery(this).find('li').each(function(){
						var diff = height - jQuery(this).outerHeight();
						if (diff > 0){
							if (content_alignment == 'top'){
								jQuery(this).css('padding-top', (diff + parseInt(jQuery(this).attr('data-padding-top'))) + 'px');
							}
							else if (content_alignment == 'bottom'){
								jQuery(this).css('padding-top', (diff + parseInt(jQuery(this).attr('data-padding-bottom'))) + 'px');
							}
							else{
								if (diff%2 == 0){
									var diff_top = diff_bottom = diff/2;
								}
								else{
									var diff_top = parseInt(diff/2);
									var	diff_bottom = parseInt(diff/2)+1;
								}
								this.style.setProperty('padding-top', (diff_top + parseInt(jQuery(this).attr('data-padding-top'))) + 'px', 'important');
								this.style.setProperty('padding-bottom', (diff_bottom + parseInt(jQuery(this).attr('data-padding-bottom'))) + 'px', 'important');
							}
						}
					});
				});
			}
		}

		/*
		 * Google Analytics Event module
		 */

		// Handle click events
		jQuery(document).on('click', '.luv-ga-click', function(e){
			e.preventDefault();
			var href = (jQuery(this).hasClass('social-share-popup') ? false : jQuery(this).attr('href'));
			var event_category = jQuery(this).attr('data-event-category') || '';
			var event_action = jQuery(this).attr('data-event-action') || '';
			var event_label = jQuery(this).attr('data-event-label') || '';
			var event_value = jQuery(this).attr('data-event-value') || '';

			if (typeof ga === 'function'){
				ga('send', 'event', event_category, event_action, event_label, event_value, {
					'hitCallback': function(){
						if (!href.match(/^#/) && href != false){
							if (jQuery(this).prop('target') == '_blank'){
								window.open(href);
							}
							else if (jQuery(this).prop('target') == '_top'){
								top.location.href=href;
							}
							else if (jQuery(this).prop('target') == '_self'){
								self.location.href=href;
							}
							else if (jQuery(this).prop('target') == '_parent'){
								parent.location.href=href;
							}
							else{
								window.location.href=href;
							}
						}
					}
				});
			}
		});

		// Init perspective selects
		luv_init_perspective_select();

		// Init submenus
		setTimeout(luv_page_submenu, 1000);

		// Init luv counters
		if (jQuery('.luv-counter').length > 0){
			jQuery(window).on('scroll', luv_counter_init);
			luv_counter_init();
		}

		// Init same height carousel slides
		luv_equal_height();

		// Init TwentyTwenty
		if (jQuery('.luv-before-after').length > 0){
			jQuery(window).on('load', function(){
				jQuery('.luv-before-after').twentytwenty();
			});
		}

		// Init sticky columns
		init_sticky_columns();
		animate_sticky_columns();

		// Run after window loaded
		jQuery(window).load(function(){
			// Play animations
			luv_play_icon_animations();
			luv_init_animated_list();
			luv_play_c_animation();
			luv_play_bg_animation();

			// Multiscroll
			luv_multiscroll();

			// Google Analytics inview
			luv_ga_inview();

			// Init carousel
			if(jQuery('.luv-carousel').length > 0 && jQuery('[data-vc-full-width="true"]').length == 0) {
				luv_carousel_init();
			}

			// Init Image Slide Box
			if(jQuery('.luv-image-slide-box').length > 0 && jQuery('[data-vc-full-width="true"]').length == 0) {
				luv_init_slide_boxes();
			}

		});

		// Scroll bindings
		jQuery(window).on('scroll', function(){
			luv_counter_init();
			luv_page_submenu();
			luv_play_icon_animations();
			luv_init_animated_list();
			luv_play_c_animation();
			luv_ga_inview();
			luv_animate_slide_boxes();
			animate_sticky_columns();
		});

		jQuery(window).resize(function(){
			// Resize on scroll fix
			if (luv_core_initial_width != jQuery(window).width() || luv_core_initial_height != jQuery(window).height()){

				// Reset current sizes
				luv_core_initial_width	= jQuery(window).width();
				luv_core_initial_height	= jQuery(window).height();

				// Fire functions
				luv_counter_init();
			}
			luv_page_submenu();
			luv_play_icon_animations();
			luv_init_animated_list();
			luv_play_c_animation();
			setTimeout(luv_equal_height,300);
			luv_ga_inview();
			init_sticky_columns();
		});

		window.addEventListener('orientationchange', function() {
			luv_counter_init();
			luv_page_submenu();
			luv_play_icon_animations();
			luv_init_animated_list();
			luv_play_c_animation();
			setTimeout(luv_equal_height,300);
			luv_ga_inview();
			init_sticky_columns();
		});

	});

	/**
	 * Translations
	 */
	function __(string){
		return (typeof luvthemes_core.i18n[string] !== 'undefined' ? luvthemes_core.i18n[string] : string);
	}
})();
