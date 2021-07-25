(function ($) {
	"use strict";

	var BdppElementorInit = function () {

		/* Slider */
		bdpp_init_post_slider();

		/* Carousel Slider */
		bdpp_init_post_carousel();

		/* GridBox Slider */
		bdpp_init_post_gridbox_slider();

		/* Taxonomy Slider */
		bdpp_init_cat_slider();

		/* Ticker */
		bdpp_init_post_ticker();

		/* Masonry */
		bdpp_init_post_masonry();

		/* Tooltip */
		bdpp_tooltip();
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/shortcode.default', BdppElementorInit);
		
		elementorFrontend.hooks.addAction('frontend/element_ready/text-editor.default', BdppElementorInit);
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-slider-widget.default', function( $scope ) {
			
			var widget_id = $scope.attr('data-id');
			widget_id = widget_id +'-'+ $.now();

			$scope.find('.bdpp-post-slider-wdgt').attr('id', widget_id);

			bdpp_init_widget_slider();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-slider-swdgt.default', function( $scope ) {
			
			var widget_id = $scope.attr('data-id');
			widget_id = widget_id +'-'+ $.now();

			$scope.find('.bdpp-post-slider-wrap').attr('id', widget_id);

			bdpp_init_post_slider();
			bdpp_tooltip();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-carousel-swdgt.default', function( $scope ) {
			
			var widget_id = $scope.attr('data-id');
			widget_id = widget_id +'-'+ $.now();

			$scope.find('.bdpp-post-carousel-wrap').attr('id', widget_id);

			bdpp_init_post_carousel();
			bdpp_tooltip();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-gridbox-slider-swdgt.default', function( $scope ) {
			
			var widget_id = $scope.attr('data-id');
			widget_id = widget_id +'-'+ $.now();

			$scope.find('.bdpp-gridbox-slider-wrap').attr('id', widget_id);

			bdpp_init_post_gridbox_slider();
			bdpp_tooltip();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-taxonomy-slider-swdgt.default', function( $scope ) {
			
			var widget_id = $scope.attr('data-id');
			widget_id = widget_id +'-'+ $.now();

			$scope.find('.bdpp-term-slider-wrap').attr('id', widget_id);

			bdpp_init_cat_slider();
		});

		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-masonry-swdgt.default', function( $scope ) {
			
			var widget_id = $scope.attr('data-id');
			widget_id = widget_id +'-'+ $.now();

			$scope.find('.bdpp-post-masonry-wrap').attr('id', widget_id);

			bdpp_init_post_masonry();
			bdpp_tooltip();
		});

		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-ticker-swdgt.default', function( $scope ) {
			bdpp_init_post_ticker();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-grid-swdgt.default', function( $scope ) {
			bdpp_tooltip();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-list-swdgt.default', function( $scope ) {
			bdpp_tooltip();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-gridbox-swdgt.default', function( $scope ) {
			bdpp_tooltip();
		});
		
		elementorFrontend.hooks.addAction('frontend/element_ready/wp-widget-bdpp-post-timeline-swdgt.default', function( $scope ) {
			bdpp_tooltip();
		});
		
		/* Tabs Element */
		elementorFrontend.hooks.addAction( 'frontend/element_ready/tabs.default', function($scope) {
			
			$scope.find('.bdpp-post-slider-wrap').each(function( index ) {
				var slider_id = $(this).attr('id');
				$('#'+slider_id).css({'visibility': 'hidden', 'opacity': 0});

				bdpp_init_post_slider();					

				setTimeout(function() {
					if( typeof(slider_id) !== 'undefined' && slider_id != '' ) {
						$('#'+slider_id).trigger('refresh.owl.carousel');
						$('#'+slider_id).css({'visibility': 'visible', 'opacity': 1});
					}
				}, 300);
			});	
		});
	});
}(jQuery));