(function($){
	window.LuvAccordionView = window.VcBackendTtaAccordionView.extend( {
		addSection: function ( prepend ) {
			var newTabTitle, params, shortcode;

			newTabTitle = this.defaultSectionTitle;
			params = {
				shortcode: 'luv_accordion_inner',
				params: { title: newTabTitle },
				parent_id: this.model.get( 'id' ),
				order: (_.isBoolean( prepend ) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder()),
				prepend: prepend // used in notifySectionRendered to create in correct place tab
			};
			shortcode = vc.shortcodes.create( params );

			return shortcode;
		},
	} );
	
	window.LuvAccordionInnerView = window.VcBackendTtaSectionView.extend( {
		parentObj: null,
		events: {
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-prepend': 'addElement',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-edit': 'editElement',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-clone': 'clone',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_empty-container': 'addToEmpty'
		},
	} );
	
	window.LuvTabView = window.VcBackendTtaTabsView.extend( {
		addSection: function ( prepend ) {
			var newTabTitle, params, shortcode;

			newTabTitle = this.defaultSectionTitle;
			params = {
				shortcode: 'luv_tab_inner',
				params: { title: newTabTitle },
				parent_id: this.model.get( 'id' ),
				order: (_.isBoolean( prepend ) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder()),
				prepend: prepend // used in notifySectionRendered to create in correct place tab
			};
			shortcode = vc.shortcodes.create( params );

			return shortcode;
		},
	} );
	
	window.LuvTabInnerView = window.VcBackendTtaSectionView.extend( {
		parentObj: null,
		events: {
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-prepend': 'addElement',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-edit': 'editElement',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-clone': 'clone',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_empty-container': 'addToEmpty'
		},
	} );
	
	window.LuvCarouselView = window.VcBackendTtaTabsView.extend( {
		addSection: function ( prepend ) {
			var newTabTitle, params, shortcode;

			newTabTitle = this.defaultSectionTitle;
			params = {
				shortcode: 'luv_carousel_slide',
				params: {},
				parent_id: this.model.get( 'id' ),
				order: (_.isBoolean( prepend ) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder()),
				prepend: prepend // used in notifySectionRendered to create in correct place tab
			};
			shortcode = vc.shortcodes.create( params );

			return shortcode;
		},
	} );
	
	window.LuvCarouselSlideView = window.VcBackendTtaSectionView.extend( {
		parentObj: null,
		events: {
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-prepend': 'addElement',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-edit': 'editElement',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_control-btn-clone': 'clone',
			'click > .wpb_element_wrapper > .vc_tta-panel-body > .vc_empty-container': 'addToEmpty'
		}
	} );
})(jQuery);