(function ( $ ) {

	window.luvmaps = [];

	//Callback function to init maps
	window.init_luvmaps = function(){
		jQuery(function(){
		    jQuery('.luvmap').each(function(){
		    	jQuery(this).luvmap();
			jQuery(this).trigger('luvmap-init');
		    });
		});
	};

	//Load google map js API if it isn't present yet
	if (typeof google === 'undefined'){
    	$.getScript('//maps.google.com/maps/api/js?key=' + luvthemes_core['google_maps_api_key'] + '&v=3&callback=init_luvmaps&libraries=' + luvthemes_core['google_maps_libraries']);
	}
	else{
		init_luvmaps();
	}

	//Pseudo jQuery plugin to prepare map elements before Google Maps API has been loaded
    $.fn.luvmap = function() {
		//TODO directions

    	$(this).each(function(){
			//Use data attributes if defined
			var settings = $(this).data();

			//Create the settings object and use defaults if value isn't set
			settings = $.extend({
			type				: 'roadmap',	// ROADMAP|SATELLITE|HYBRID|TERRAIN|PANORAMA
		    	search			: true,			// boolean
		    	center			: null,
		    	addresses			: null,
		    	animation			: 'drop',
		    	delay				: 1000,
		    	zoom				: null,
		    	tilt				: null,
		    	controls			: false,		// boolean
		    	disableUi			: false,		// boolean
		    	useClusters			: false,		// boolean
		    	panorama			: false,		// boolean
		    	scrollwheel			: true,		// boolean
			draggable			: true,		// boolean
		    	panoramaHeading		: 0,
		    	panoramaPitch		: 0,
		    	panoramaControls		: true,		// boolean
		    	panoramaEffect		: 'slideLeft',
		    	mapStyle			: null
			}, settings );

			if (settings['addresses'] == null){
				settings['addresses'] = [];
				$(this).children('.luvmap-address').each(function(){
					var _address = $(this).clone().children().remove().end();
					if ($(this).children('.luvmap-info').length > 0){
						var _info = $(this).children('.luvmap-info');
						$(_info).find('.luvmap-street_view').each(function(){
								$(this).attr('href', $(_address).text());
						});
						var info = _info.html();
					}
					var auto_open = ($(this).hasClass('auto-open') ? true : false);
					settings['addresses'].push({address: $(_address).text(), icon: $(this).children('.luvmap-icon').attr('src'), info: info, auto_open: auto_open});
					$(this).remove();
				})
			}
			else{
				settings['addresses'] = settings['addresses'].replace(/\s+/,'').split(',');
			}


			var map;
			var panorama;
			var markers = [];
			var pins = [];
			var bounds;
			var that = $(this);
			var panorama_margin;

		 	var geocoder = new google.maps.Geocoder();

				// Check if address is coordinates xx.xx,xx.xx in format
				var maybe_coordinate = function(address){
					var coordinate = address.match(/([\d\.-]+),([\d\.-]+)/);
					if (coordinate !== null && coordinate.length == 3 && !isNaN(coordinate[1]) && !isNaN(coordinate[2])){
						return new google.maps.LatLng(
        						parseFloat(coordinate[1]), parseFloat(coordinate[2])
									);
					}
					return false;
				};


		    //Init the addresses, calls plugin init on finish
		    var init_addresses = function (c){
		    	c = c || 0;
		    	try{
						var coordinate = maybe_coordinate(settings['addresses'][c]['address']);
						if (coordinate !== false){
							pins.push({
								position : coordinate,
								icon : settings['addresses'][c]['icon'],
								info: new google.maps.InfoWindow({
									content: settings['addresses'][c]['info']
								}),
								auto_open: settings['addresses'][c]['auto_open']
							});

							//After last address call the plugin init
							if (typeof settings['addresses'][c+1] === 'undefined'){
								 init(that[0]);
							}
							//Address geocode loop
							else{
								c++;
								init_addresses(c);
							}
						}
						else{
				    	geocoder.geocode( { 'address': settings['addresses'][c]['address']}, function(results, status) {
							   if (status == google.maps.GeocoderStatus.OK) {
								   pins.push({
									   position : results[0].geometry.location,
									   icon : settings['addresses'][c]['icon'],
									   info: new google.maps.InfoWindow({
										   content: settings['addresses'][c]['info']
									   }),
									   auto_open: settings['addresses'][c]['auto_open']
								   });

								   //After last address call the plugin init
								   if (typeof settings['addresses'][c+1] === 'undefined'){
									  	init(that[0]);
								   }
								   //Address geocode loop
								   else{
									   c++;
									   init_addresses(c);
								   }
							   }
							   else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
								   setTimeout(function(){init_addresses(c)},1000);
							   }
							});
						}
		    	}
		    	catch (e){
		    		init(that[0]);
		    	}
		    }

		    //Plugin init
		    var init = function(container) {
		    	//Calculate center
		    	if (settings['center'] == null && pins.length > 0){
		    		bounds = new google.maps.LatLngBounds();
		    		for (var i in pins) {
		    		    bounds.extend(pins[i]['position']);
		    		}
		    		var center = bounds.getCenter();
		    	}

		    	if (settings['type'].match(/^panorama$/i)){
		    		//Init panorama
				     panorama = new google.maps.StreetViewPanorama(
				    		container, {
					        position: center,
					        addressControlOptions: {
					          position: google.maps.ControlPosition.BOTTOM_CENTER
					        },
					        disableDefaultUI: !settings['panoramaControls'],
					  });
		    	}
		    	else{
			    	//Init the map
			      	map = new google.maps.Map(container, {
				        zoom: settings['zoom'] || 12,
				        center: center,
				        mapTypeControl: settings['controls'],
				        disableDefaultUI: settings['disableUi'],
				        scrollwheel: settings['scrollwheel'],
				        draggable: settings['draggable'],
				        styles:  JSON.parse(decodeURIComponent(settings['mapStyle'])),
				        mapTypeId: google.maps.MapTypeId[settings['type'].toUpperCase()]
					});

			      	window.luvmaps.push(map);

					//Handle goto links
					$(document).on('click','.luvmap-goto',function(e){
						e.preventDefault();

						geocoder.geocode( { 'address': $(this).attr('href')}, function(results, status) {
							   if (status == google.maps.GeocoderStatus.OK) {
								   map.setCenter(results[0].geometry.location);
							   }
						});
					});

			    	//Panorama (street view)
			      	if (settings['panorama'] == true){
						//Set margin based on selected show/hide effect
			      		if (settings['panoramaEffect'].match(/^slide/)){
			      			if (settings['panoramaEffect'] == 'slideLeft'){
			      				panorama_margin = '0 0 0 ' + $(that).css('width');
			      			}
			      			else if (settings['panoramaEffect'] == 'slideRight'){
			      				panorama_margin = '0 0 0 -' + $(that).css('width');
			      			}
			      			else if (settings['panoramaEffect'] == 'slideUp'){
			      				panorama_margin = $(that).css('height') + ' 0 0 0';
			      			}
			      			else if (settings['panoramaEffect'] == 'slideDown'){
			      				panorama_margin = '-' + $(that).css('height') + ' 0 0 0';
			      			}
			      		}
			      		else{
			      			panorama_margin = '0';
			      		}
				      	var panorama_pseudo = $('<div>',{'class':'panorama-pseudo-container','style':'position:absoulute;top:0px;left:-0px;z-index:1;width:100%;height:100%;transition: margin 0.8s ease;margin:' + panorama_margin}).prependTo($(that)).get(0);

					    //Init panorama
					     panorama = new google.maps.StreetViewPanorama(
					    		panorama_pseudo, {
						        position: center,
						        addressControlOptions: {
						          position: google.maps.ControlPosition.BOTTOM_CENTER
						        },
						        disableDefaultUI: !settings['panoramaControls'],
						  });

					   //Set the control
			      		  var panoramaCenterControl = document.createElement('div');
						  var panoramaControl = new CreateControl('panoramaSlideOut', panoramaCenterControl, panorama);

						  panorama.controls[google.maps.ControlPosition.TOP_RIGHT].push(panoramaCenterControl);

						//Handle street view links
							$(document).on('click','.luvmap-street_view',function(e){
								e.preventDefault();

								geocoder.geocode( { 'address': $(this).attr('href')}, function(results, status) {
									   if (status == google.maps.GeocoderStatus.OK) {
										   panorama.setPosition(results[0].geometry.location);
										   $(that).find('.panorama-pseudo-container').css('margin','0');
									   }
								});
							});
						}
					//Fit bounds if zoom isn't set
					if (settings['zoom'] == null){
					 	map.fitBounds(bounds);
					}

					//Set tilt
					if (settings['tilt'] != null){
						//TODO setTilt
						map.setTilt(settings['tilt']);
					}
		      	}

					if (pins.length > 0){
					   setTimeout(render, settings['delay']);
					}

		    };

				//Start address geocode loop
				init_addresses(0);


		    //Render markers
		    var render = function() {
		  	  clearMarkers();
		  	  for (var i in pins) {
			  		if (settings['animation'] != 'none'){
			  	    	addMarkerWithTimeout(pins[i], i * 200);
			  		}
			  		else{
			  			addMarker(pins[i]);
			  		}
		  	  }
		  	  if (settings['useClusters'] == true){
						if(settings['animation'] != 'none'){
						  setTimeout(function(){
						          var markerCluster = new MarkerClusterer(map, markers, {imagePath: luvthemes_core['google_maps_cluster_path']});
						  }, pins.length * 200);
						}
						else{
							  var markerCluster = new MarkerClusterer(map, markers, {imagePath: luvthemes_core['google_maps_cluster_path']});
						}
		  	  }
		  	};

		  	//Add marker to specific position with specific icon
		  	var addMarker = function(pin) {
		  		var _marker = new google.maps.Marker({
			  	      position: pin.position,
			  	      map	: map,
			  	      icon	: pin.icon,
			  	      info	: pin.info
				});
				markers.push(_marker);

				if (pin.auto_open){
  			    		pin.info.open(map, _marker);
  			      }

				//Add info window
				if (typeof pin.info.content != 'undefined'){
					_marker.addListener('click', function() {
						pin.info.open(map, _marker);
					});
				}
		  	};

		  	//Add marker to specific position with specific icon, uses the specified animation
		  	var addMarkerWithTimeout = function(pin, timeout) {
		  	  window.setTimeout(function() {
		  		var _marker = new google.maps.Marker({
			  	      position	: pin.position,
			  	      map		: map,
			  	      animation	: google.maps.Animation[settings['animation'].toUpperCase()],
			  	      icon	: pin.icon,
			  	      info	: pin.info
		  	    });
		  	    markers.push(_marker);

			    if (pin.auto_open){
			    		setTimeout(function(){
						pin.info.open(map, _marker);
					},500);
			    }

				//Add info window
				if (typeof pin.info.content != 'undefined'){
					_marker.addListener('click', function() {
						pin.info.open(map, _marker);
			 	  	});
				}
		  	  }, timeout);
		  	};

		  	//Clear all markers
		  	var clearMarkers = function() {
			  for (var i = 0; i < markers.length; i++) {
			    markers[i].setMap(null);
			  }
			  markers = [];
			};

			//Create control
			var CreateControl = function(type, controlDiv, container) {

				  // Set CSS for the control border.
				  var controlUI = document.createElement('div');
				  var controlUI = $('<div>',{
					  'style' : 'background: #fff;border: 2px solid #fff;border-radius:3px;box-shadow:0 2px 6px rgba(0,0,0,.3);cursor:pointer;margin:0 0 22px 0 text-align:center;'
				  }).appendTo($(controlDiv));

				  var controlText = $('<div>',{
					  'style' : 'color:rgb(25,25,25);font-family:Roboto,Arial,sans-serif;font-size:16px;line-height:38px;padding: 0 5px 0 5px'
				  }).appendTo($(controlUI));

				  // Set event and labels
				  if (type == 'panoramaSlideIn'){
					  $(controlText).text('Street view');
					  $(controlUI).on('click', function() {
					    	$(that).find('.panorama-pseudo-container').css('margin','0');
					  });
				  }
				  else if (type == 'panoramaSlideOut'){
					  $(controlText).text('X');
					  $(controlUI).on('click', function() {
							  $(that).find('.panorama-pseudo-container').css('margin', panorama_margin);
					  });
				  }

				};
		});
	};
}( jQuery ));
