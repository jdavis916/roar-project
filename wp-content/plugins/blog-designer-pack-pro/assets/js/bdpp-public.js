/* JQuery Inview */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(d){var c,h,i,s=[],u=document,p=window,g=u.documentElement;function t(){if(s.length){var e,t,n=0,i=d.map(s,function(e){var t=e.data.selector,e=e.$element;return t?e.find(t):e});for(c=c||((t={height:p.innerHeight,width:p.innerWidth}).height||!(e=u.compatMode)&&d.support.boxModel||(t={height:(e="CSS1Compat"===e?g:u.body).clientHeight,width:e.clientWidth}),t),h=h||{top:p.pageYOffset||g.scrollTop||u.body.scrollTop,left:p.pageXOffset||g.scrollLeft||u.body.scrollLeft};n<s.length;n++)if(d.contains(g,i[n][0])){var o=d(i[n]),f=o[0].offsetHeight,l=o[0].offsetWidth,r=o.offset(),a=o.data("inf_inview");if(!h||!c)return;r.top+f>h.top&&r.top<h.top+c.height&&r.left+l>h.left&&r.left<h.left+c.width?a||o.data("inf_inview",!0).trigger("inf_inview",[!0]):a&&o.data("inf_inview",!1).trigger("inf_inview",[!1])}}}d.event.special.inf_inview={add:function(e){s.push({data:e,$element:d(this),element:this}),!i&&s.length&&(i=setInterval(t,250))},remove:function(e){for(var t=0;t<s.length;t++){var n=s[t];if(n.element===this&&n.data.guid===e.guid){s.splice(t,1);break}}s.length||(clearInterval(i),i=null)}},d(p).on("scroll resize scrollstop",function(){c=h=null}),!g.addEventListener&&g.attachEvent&&g.attachEvent("onfocusin",function(){h=null})});

( function($) {

	'use strict';

	Bdpp_Window_Resise();

	/* Trending Post Views Count Ajax */
	if( Bdpp.trend_post != 0 ) {
		var data = {
						action	: 'bdpp_trending_post_count',
						post_id	: Bdpp.trend_post
					};
		$.post(Bdpp.ajax_url, data, function(result) {
		});
	}

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

	/* Widget Slider */
	bdpp_init_widget_slider();
	
	/* Widget Scrolling */
	bdpp_init_vertical_scrolling_wdgt();

	/* Tooltip */
	bdpp_tooltip();

	/* Load More */
	$( '.bdpp-post-load-more' ).each(function( index ) {

		var current_obj	= $(this);
		var cls_ele		= current_obj.closest('.bdpp-post-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-post-data-wrap').find('.bdpp-post-data-inr-wrap');
		var shrt_param	= current_obj.attr('data-conf');
		var paged		= current_obj.attr('data-paged');

		if( cls_ele.hasClass('bdpp-post-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		$(this).on("click", function() {

			if( $(this).hasClass('bdpp-load-more-disabled') ) {
				return false;
			}

			current_obj.addClass('bdpp-load-more-disabled');
			current_obj.find('.bdpp-load-more-icon').hide();
			current_obj.find('.bdpp-loader').css('display', 'inline-block');

			paged = paged ? ( parseInt(paged) + 1) : 2;
			var data = {
							action		: 'bdpp_load_more_posts',
							shrt_param	: shrt_param,
							paged		: paged,
							count		: current_obj.attr('data-count')
						};
			$.post(Bdpp.ajax_url, data, function(result) {

				if( result.status == 1 && result.data != '' ) {

					if( masonry ) {
						var obj_id		= cls_ele.attr('id');
						var msnry_id	= $('#'+obj_id+' .bdpp-post-masonry-inr-wrap');
						var $content	= $( result.data );
						
						$content.hide();

						msnry_id.append($content).imagesLoaded(function() {
							$content.show();
							msnry_id.append( $content ).masonry( 'appended', $content );
						});
					} else {
						cnt_ele.append( result.data );
						current_obj.attr( 'data-count', result.count );
					}

					if( result.last_page == 1 ) {
						current_obj.closest('.bdpp-paging').hide();
					}

				} else if(result.data == '') {

					current_obj.closest('.bdpp-paging').hide();
					var msg_info = '<div class="bdpp-info">'+Bdpp.no_post_found_msg+'</div>';

					cnt_ele.after( msg_info );
					setTimeout(function() {
						$(".bdpp-info").fadeOut("normal", function() {
							$(this).remove();
						});
					}, 3000 );
				}

				bdpp_tooltip();
				current_obj.find('.bdpp-load-more-icon').show();
				current_obj.find('.bdpp-loader').hide();
				current_obj.removeClass('bdpp-load-more-disabled');
			});
		});
	});

	/* Numeric Ajax */
	$( '.bdpp-numeric-post-ajax' ).each(function( index ) {

		var current_obj	= $(this);
		var btn			= current_obj.find('.page-numbers');
		var cls_ele		= current_obj.closest('.bdpp-post-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-post-data-wrap').find('.bdpp-post-data-inr-wrap');
		var cls_id		= cls_ele.attr('id');
		var shrt_param	= current_obj.attr('data-conf');

		if( cls_ele.hasClass('bdpp-post-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		$('#'+cls_id).on("click", '.bdpp-numeric-post-ajax .page-numbers', function() {

			var btn_href = $(this).attr('href');

			if( typeof(btn_href) == 'undefined' || btn_href == '' ) {
				return false;
			}

			if( $(this).hasClass('bdpp-ajax-disabled') ) {
				return false;
			}

			btn.addClass('bdpp-ajax-disabled');
			cls_ele.find('.bdpp-loader').css('display', 'inline-block');

			var data = {
							action			: 'bdpp_load_more_posts',
							shrt_param		: shrt_param,
							href			: btn_href,
							pagination_type	: 'numeric-ajax',
							count			: 0
						};
			$.post(Bdpp.ajax_url, data, function(result) {

				if( result.status == 1 && result.data != '' ) {

					if( masonry ) {
						var obj_id		= cls_ele.attr('id');
						var msnry_id	= $('#'+obj_id+' .bdpp-post-masonry-inr-wrap');
						var $content	= $( result.data );

						$content.hide();

						msnry_id.html($content).imagesLoaded(function() {
							$content.show();
							msnry_id.masonry('reloadItems');
							msnry_id.masonry( 'layout' );
						});
					} else {
						cnt_ele.html( result.data );
					}

					current_obj.html( result.pagination_html );

				} else if(result.data == '') {

					current_obj.closest('.bdpp-paging').hide();
					var msg_info = '<div class="bdpp-info">'+Bdpp.no_post_found_msg+'</div>';

					cnt_ele.after( msg_info );
					setTimeout(function() {
						$(".bdpp-info").fadeOut("normal", function() {
							$(this).remove();
						});
					}, 3000 );
				}

				bdpp_tooltip();
				btn.removeClass('bdpp-ajax-disabled');
				cls_ele.find('.bdpp-loader').hide();
			});

			return false;
		});
	});

	/* Prev - Next Ajax */
	$( '.bdpp-prev-next-post-ajax' ).each(function( index ) {

		var current_obj	= $(this);
		var btn			= current_obj.find('.bdpp-ajax-pagi-btn');
		var cls_ele		= current_obj.closest('.bdpp-post-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-post-data-wrap').find('.bdpp-post-data-inr-wrap');
		var shrt_param	= current_obj.attr('data-conf');
		var paged		= current_obj.attr('data-paged');

		if( cls_ele.hasClass('bdpp-post-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		btn.on("click", function() {

			if( $(this).hasClass('bdpp-ajax-disabled') ) {
				return false;
			}

			btn.addClass('bdpp-ajax-disabled');
			current_obj.find('.bdpp-loader').css('display', 'inline-block');

			if( $(this).hasClass('bdpp-ajax-prev-page') ) {
				var type	= 'prev';
				paged		= paged ? ( parseInt(paged) - 1 ) : 1;
			} else {
				var type	= 'next';
				paged		= paged ? ( parseInt(paged) + 1 ) : 2;
			}
			paged = ( paged > 0 ) ? paged : 1;

			var data = {
							action		: 'bdpp_load_more_posts',
							shrt_param	: shrt_param,
							paged		: paged,
							count		: 0
						};
			$.post(Bdpp.ajax_url, data, function(result) {

				if( result.status == 1 && result.data != '' ) {

					if( masonry ) {
						var obj_id		= cls_ele.attr('id');
						var msnry_id	= $('#'+obj_id+' .bdpp-post-masonry-inr-wrap');
						var $content	= $( result.data );

						$content.hide();

						msnry_id.html($content).imagesLoaded(function() {
							$content.show();
							msnry_id.masonry('reloadItems');
							msnry_id.masonry( 'layout' );
						});
					} else {
						cnt_ele.html( result.data );
					}

				} else if(result.data == '') {

					current_obj.closest('.bdpp-paging').hide();
					var msg_info = '<div class="bdpp-info">'+Bdpp.no_post_found_msg+'</div>';

					cnt_ele.after( msg_info );
					setTimeout(function() {
						$(".bdpp-info").fadeOut("normal", function() {
							$(this).remove();
						});
					}, 3000 );
				}

				bdpp_tooltip();
				btn.removeClass('bdpp-ajax-disabled');
				current_obj.find('.bdpp-loader').hide();

				if( paged == 1 ) {
					current_obj.find('.bdpp-ajax-prev-page').addClass('bdpp-ajax-disabled');
				} else if( result.last_page == 1 ) {
					current_obj.find('.bdpp-ajax-next-page').addClass('bdpp-ajax-disabled');
				}
			});
		});
	});

	/* Infinite Pagination */
	$( '.bdpp-post-infinite-pagi' ).each(function( index ) {
		
		var current_obj	= $(this);
		var cls_ele		= current_obj.closest('.bdpp-post-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-post-data-wrap').find('.bdpp-post-data-inr-wrap');
		var shrt_param	= current_obj.attr('data-conf');
		var paged		= current_obj.attr('data-paged');

		if( cls_ele.hasClass('bdpp-post-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		$(this).on('inf_inview', function (event, visible) {
			if (visible == true) {

				if( current_obj.hasClass('bdpp-infinite-disabled') ) {
					return false;
				}

				current_obj.addClass('bdpp-infinite-disabled');
				current_obj.find('.bdpp-loader').css('display', 'inline-block');

				paged = paged ? ( parseInt(paged) + 1) : 2;

				var data = {
								action		: 'bdpp_load_more_posts',
								shrt_param	: shrt_param,
								paged		: paged,
								count		: current_obj.attr('data-count')
							};
				$.post(Bdpp.ajax_url, data, function(result) {

					if( result.status == 1 && result.data != '' ) {

						if( masonry ) {
							var obj_id		= cls_ele.attr('id');
							var msnry_id	= $('#'+obj_id+' .bdpp-post-masonry-inr-wrap');
							var $content	= $( result.data );
							
							$content.hide();

							msnry_id.append($content).imagesLoaded(function() {
								$content.show();
								msnry_id.append( $content ).masonry( 'appended', $content );
							});
						} else {
							cnt_ele.append( result.data );
							current_obj.attr( 'data-count', result.count );
						}

						if( result.last_page == 1 ) {
							current_obj.closest('.bdpp-paging').hide();
						}

					} else if(result.data == '') {

						current_obj.closest('.bdpp-paging').hide();
						var msg_info = '<div class="bdpp-info">'+Bdpp.no_post_found_msg+'</div>';

						cnt_ele.after( msg_info );
						setTimeout(function() {
							$(".bdpp-info").fadeOut("normal", function() {
								$(this).remove();
							});
						}, 3000 );
					}

					bdpp_tooltip();
					current_obj.find('.bdpp-loader').hide();
					current_obj.removeClass('bdpp-infinite-disabled');
				});
			}
		});
	});
	/* Infinite Pagination Ends */

	/* Load More Terms Start */
	$( '.bdpp-term-load-more' ).each(function( index ) {

		var current_obj	= $(this);
		var cls_ele		= current_obj.closest('.bdpp-term-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-term-data-wrap').find('.bdpp-term-data-inr-wrap');
		var shrt_param	= current_obj.attr('data-conf');
		var paged		= current_obj.attr('data-paged');

		if( cls_ele.hasClass('bdpp-term-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		$(this).on("click", function() {

			if( $(this).hasClass('bdpp-load-more-disabled') ) {
				return false;
			}

			current_obj.addClass('bdpp-load-more-disabled');
			current_obj.find('.bdpp-load-more-icon').hide();
			current_obj.find('.bdpp-loader').css('display', 'inline-block');

			paged = paged ? ( parseInt(paged) + 1) : 2;
			var data = {
							action		: 'bdpp_load_more_terms',
							shrt_param	: shrt_param,
							paged		: paged,
							count		: current_obj.attr('data-count')
						};
			$.post(Bdpp.ajax_url, data, function(result) {

				if( result.status == 1 && result.data != '' ) {

					if( masonry ) {
						var obj_id		= cls_ele.attr('id');
						var msnry_id	= $('#'+obj_id+' .bdpp-term-masonry-inr-wrap');
						var $content	= $( result.data );
						
						$content.hide();

						msnry_id.append($content).imagesLoaded(function() {
							$content.show();
							msnry_id.append( $content ).masonry( 'appended', $content );
						});
					} else {
						cnt_ele.append( result.data );
						current_obj.attr( 'data-count', result.count );
					}

					if( result.last_page == 1 ) {
						current_obj.closest('.bdpp-paging').hide();
					}

				} else if(result.data == '') {

					current_obj.closest('.bdpp-paging').hide();
					var msg_info = '<div class="bdpp-info">'+Bdpp.no_term_found_msg+'</div>';

					cnt_ele.after( msg_info );
					setTimeout(function() {
						$(".bdpp-info").fadeOut("normal", function() {
							$(this).remove();
						});
					}, 3000 );
				}

				bdpp_tooltip();
				current_obj.find('.bdpp-load-more-icon').show();
				current_obj.find('.bdpp-loader').hide();
				current_obj.removeClass('bdpp-load-more-disabled');
			});
		});
	});
	/* Load More Terms Ends */

	/* Taxonomy Prev - Next Ajax Start */
	$( '.bdpp-prev-next-term-ajax' ).each(function( index ) {

		var current_obj	= $(this);
		var btn			= current_obj.find('.bdpp-ajax-pagi-btn');
		var cls_ele		= current_obj.closest('.bdpp-term-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-term-data-wrap').find('.bdpp-term-data-inr-wrap');
		var shrt_param	= current_obj.attr('data-conf');
		var paged		= current_obj.attr('data-paged');

		if( cls_ele.hasClass('bdpp-term-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		btn.on("click", function() {

			if( $(this).hasClass('bdpp-ajax-disabled') ) {
				return false;
			}

			btn.addClass('bdpp-ajax-disabled');
			current_obj.find('.bdpp-loader').css('display', 'inline-block');

			if( $(this).hasClass('bdpp-ajax-prev-page') ) {
				var type	= 'prev';
				paged		= paged ? ( parseInt(paged) - 1 ) : 1;
			} else {
				var type	= 'next';
				paged		= paged ? ( parseInt(paged) + 1 ) : 2;
			}
			paged = ( paged > 0 ) ? paged : 1;

			var data = {
							action		: 'bdpp_load_more_terms',
							shrt_param	: shrt_param,
							paged		: paged,
							count		: 0
						};
			$.post(Bdpp.ajax_url, data, function(result) {

				if( result.status == 1 && result.data != '' ) {

					if( masonry ) {
						var obj_id		= cls_ele.attr('id');
						var msnry_id	= $('#'+obj_id+' .bdpp-term-masonry-inr-wrap');
						var $content	= $( result.data );

						$content.hide();

						msnry_id.html($content).imagesLoaded(function() {
							$content.show();
							msnry_id.masonry('reloadItems');
							msnry_id.masonry( 'layout' );
						});
					} else {
						cnt_ele.html( result.data );
					}

				} else if(result.data == '') {

					current_obj.closest('.bdpp-paging').hide();
					var msg_info = '<div class="bdpp-info">'+Bdpp.no_term_found_msg+'</div>';

					cnt_ele.after( msg_info );
					setTimeout(function() {
						$(".bdpp-info").fadeOut("normal", function() {
							$(this).remove();
						});
					}, 3000 );
				}

				btn.removeClass('bdpp-ajax-disabled');
				current_obj.find('.bdpp-loader').hide();

				if( paged == 1 ) {
					current_obj.find('.bdpp-ajax-prev-page').addClass('bdpp-ajax-disabled');
				} else if( result.last_page == 1 ) {
					current_obj.find('.bdpp-ajax-next-page').addClass('bdpp-ajax-disabled');
				}
			});
		});
	});
	/* Taxonomy Prev - Next Ajax End */

	/* Term Infinite Pagination Start */
	$( '.bdpp-term-infinite-pagi' ).each(function( index ) {
		
		var current_obj	= $(this);
		var cls_ele		= current_obj.closest('.bdpp-term-data-wrap');
		var cnt_ele		= current_obj.closest('.bdpp-term-data-wrap').find('.bdpp-term-data-inr-wrap');
		var shrt_param	= current_obj.attr('data-conf');
		var paged		= current_obj.attr('data-paged');

		if( cls_ele.hasClass('bdpp-term-masonry-wrap') ) {
			var masonry = true;
		} else {
			var masonry = false;
		}

		$(this).on('inf_inview', function (event, visible) {
			if (visible == true) {
		
				if( current_obj.hasClass('bdpp-infinite-disabled') ) {
					return false;
				}

				current_obj.addClass('bdpp-infinite-disabled');
				current_obj.find('.bdpp-loader').css('display', 'inline-block');

				paged = paged ? ( parseInt(paged) + 1) : 2;

				var data = {
								action		: 'bdpp_load_more_terms',
								shrt_param	: shrt_param,
								paged		: paged,
								count		: current_obj.attr('data-count')
							};
				$.post(Bdpp.ajax_url, data, function(result) {

					if( result.status == 1 && result.data != '' ) {

						if( masonry ) {
							var obj_id		= cls_ele.attr('id');
							var msnry_id	= $('#'+obj_id+' .bdpp-term-masonry-inr-wrap');
							var $content	= $( result.data );
							
							$content.hide();

							msnry_id.append($content).imagesLoaded(function() {
								$content.show();
								msnry_id.append( $content ).masonry( 'appended', $content );
							});
						} else {
							cnt_ele.append( result.data );
							current_obj.attr( 'data-count', result.count );
						}

						if( result.last_page == 1 ) {
							current_obj.closest('.bdpp-paging').hide();
						}

					} else if(result.data == '') {

						current_obj.closest('.bdpp-paging').hide();
						var msg_info = '<div class="bdpp-info">'+Bdpp.no_term_found_msg+'</div>';

						cnt_ele.after( msg_info );
						setTimeout(function() {
							$(".bdpp-info").fadeOut("normal", function() {
								$(this).remove();
							});
						}, 3000 );
					}

					bdpp_tooltip();
					current_obj.find('.bdpp-loader').hide();
					current_obj.removeClass('bdpp-infinite-disabled');
				});
			}
		});
	});
	/* Term Infinite Pagination Ends */

	/* Creative Design 1 */
	$(document).on('mouseover touchstart', '.bdpp-post-ctv1-wrap .bdpp-post-grid', function() {
		var cls_ele	= $(this).closest('.bdpp-post-ctv1-wrap');
		var bg_no	= $(this).attr('data-count');
		var bg_img	= $(this).attr('data-bg');

		if( ! cls_ele.find('.bdpp-post-ctv1-thumb-'+bg_no).hasClass('bdpp-post-ctv1-thumb-active') ) {

			if( bg_img ) {
				cls_ele.find('.bdpp-post-ctv1-thumb-'+bg_no).css('background-image', 'url(' + bg_img + ')');
			}

			cls_ele.find('.bdpp-post-ctv1-thumb').stop().fadeOut().removeClass('bdpp-post-ctv1-thumb-active');
			cls_ele.find('.bdpp-post-ctv1-thumb-'+bg_no).stop().fadeIn().addClass('bdpp-post-ctv1-thumb-active');
		}
	});

	/* Window Resize Function Start */
	$(window).on( "resize", function() {
		Bdpp_Window_Resise();
	});
	/* Window Resize Function Ends */
})( jQuery );

/* Slider */
function bdpp_init_post_slider() {
	jQuery( '.bdpp-post-slider-wrap' ).each(function( index ) {

		var slider_id 	= jQuery(this).attr('id');
		var slider		= jQuery('#'+slider_id);
		var thumbnail	= jQuery(this).parent().find('.bdpp-thumb-slider');
		var conf 		= JSON.parse( jQuery(this).attr('data-conf') );
		var hash 		= location.hash;
		var flag		= false;

		slider.owlCarousel({
				loop 			: conf.loop,
				margin 			: parseInt(conf.slide_margin),
				items 			: 1,
				nav 			: conf.arrows,
				dots 			: conf.dots,
				autoplay 		: conf.autoplay,
				startPosition 	: (conf.url_hash_listener && hash != '') ? 'URLHash' : parseInt(conf.start_position),
				lazyLoad		: conf.lazyload,
				lazyLoadEager	: ( conf.lazyload ) ? 1 : 0,
				autoplayTimeout	: parseInt( conf.autoplay_interval ),
				autoplaySpeed	: (conf.speed == 'false') ? false : parseInt( conf.speed ),
				autoHeight 		: conf.auto_height,
				URLhashListener : conf.url_hash_listener,
				navText 		: conf.nav_text,
				stagePadding 	: conf.stage_padding,
				navElement 		: 'span',
				rtl				: ( Bdpp.is_rtl == 1 ) ? true : false,
				autoplayHoverPause : conf.autoplay_hover_pause,
		});

		/* Slider Thumbnail */
		if( conf.show_thumbnail ) {

			thumbnail.on('initialized.owl.carousel', function(e) {
				bdpp_set_current_thumb( e, parseInt(conf.start_position) );
			}).owlCarousel({
				nav				: false,
				navText			: false,
				dots			: false,
				navRewind		: false,
				items			: 7,
				margin			: 10,
				lazyLoad		: conf.lazyload,
				lazyLoadEager	: ( conf.lazyload ) ? 1 : 0,
				startPosition 	: (conf.url_hash_listener && hash != '') ? 'URLHash' : parseInt(conf.start_position),
				rtl				: ( Bdpp.is_rtl == 1 ) ? true : false,
				responsiveClass : true,
				responsive:{
					0:{
						items 	: ( conf.thumbnail < 2 ) ? conf.thumbnail : 2,
					},
					376:{
						items : ( conf.thumbnail < 3 ) ? conf.thumbnail : 3,
					},
					568:{
						items : ( conf.thumbnail < 5 ) ? conf.thumbnail : 5,
					},
					812:{
						items : ( conf.thumbnail < 6 ) ? conf.thumbnail : 6,
					},
					1023:{
						items : conf.thumbnail,
					}
				}
			});

			slider.on('changed.owl.carousel', function(e) {
				var target = e.relatedTarget.relative(e.property.value, true);
				if ( ! flag ) {
					flag = true;
					thumbnail.trigger('to.owl.carousel', [target, parseInt( conf.speed ), true]);
					flag = false;
				}

				bdpp_set_current_thumb(e, false);
			});

			thumbnail.on('changed.owl.carousel', function (e) {
				if ( ! flag ) {
					flag = true;
					jQuery(slider).trigger('to.owl.carousel', e.item.index, parseInt( conf.speed ), true);
					flag = false;
				}
			}).on('click', '.owl-item', function (e) {
				e.preventDefault();
				jQuery(slider).trigger('to.owl.carousel', jQuery(this).index(), parseInt( conf.speed ), true);
			});
		}

		/* Set current thumbnail for slider */
		function bdpp_set_current_thumb(e, current) {
			var current = current ? current : e.relatedTarget.relative(e.item.index);
			var items = thumbnail.find('.owl-stage').children();

			items.removeClass('bdpp-current-thumb');
			items.eq(e.relatedTarget.normalize(current)).toggleClass('bdpp-current-thumb');
		}
	});
}

/* Carousel Slider */
function bdpp_init_post_carousel() {
	jQuery( '.bdpp-post-carousel-wrap' ).each(function( index ) {

		var carousel_id 	= jQuery(this).attr('id');		
		var conf 			= JSON.parse( jQuery(this).attr('data-conf') );
		var hash 			= location.hash;
		var items			= parseInt( conf.slide_show );
		var slide_scroll	= parseInt( conf.slide_scroll );

		jQuery('#'+carousel_id).owlCarousel({
			items 			: items,
			loop 			: conf.loop,
			slideBy 		: slide_scroll,
			margin 			: parseInt( conf.slide_margin ),
			nav 			: conf.arrows,
			dots 			: conf.dots,
			autoplay 		: conf.autoplay,
			startPosition 	: (conf.url_hash_listener && hash != '') ? 'URLHash' : parseInt(conf.start_position),
			lazyLoad		: conf.lazyload,
			lazyLoadEager	: ( conf.lazyload ) ? 1 : 0,
			autoplayTimeout	: parseInt( conf.autoplay_interval ),
			autoplaySpeed	: (conf.speed == 'false') ? false : parseInt( conf.speed ),
			URLhashListener : conf.url_hash_listener,
			navText 		: conf.nav_text,
			stagePadding 	: conf.stage_padding,
			center 			: conf.center,
			autoHeight 		: conf.auto_height,
			navElement 		: 'span',
			rtl				: ( Bdpp.is_rtl == 1 ) ? true : false,
			autoplayHoverPause : conf.autoplay_hover_pause,
			responsiveClass : true,
			responsive:{
				0:{
					items 	: 1,
					slideBy : 1,
					dots 	: false,
					stagePadding: 0,
				},
				568:{
					slideBy : ( slide_scroll >= 2 ) ? 2 : slide_scroll,
					items : ( items >= 2 ) ? 2 : items,
					stagePadding: 0,
				},
				768:{
					items	 : ( items >= 3 ) ? 3 : items,
					slideBy : ( slide_scroll >= 3 ) ? 3 : slide_scroll,
				},
				1024:{
					items : items,
				}
			}
		});
	});
}

/* GridBox Slider */
function bdpp_init_post_gridbox_slider() {
	jQuery( '.bdpp-gridbox-slider-wrap' ).each(function( index ) {

		var slider_id 	= jQuery(this).attr('id');		
		var conf 		= JSON.parse( jQuery(this).attr('data-conf') );
		var hash 		= location.hash;

		jQuery('#'+slider_id).owlCarousel({
				loop 			: conf.loop,
				margin 			: parseInt(conf.slide_margin),
				items 			: 1,
				nav 			: conf.arrows,
				dots 			: conf.dots,
				autoplay 		: conf.autoplay,
				startPosition 	: (conf.url_hash_listener && hash != '') ? 'URLHash' : parseInt(conf.start_position),
				lazyLoad		: conf.lazyload,
				lazyLoadEager	: ( conf.lazyload ) ? 1 : 0,
				autoplayTimeout	: parseInt( conf.autoplay_interval ),
				autoplaySpeed	: (conf.speed == 'false') ? false : parseInt( conf.speed ),
				URLhashListener : conf.url_hash_listener,
				navText 		: conf.nav_text,
				autoHeight 		: conf.auto_height,
				stagePadding 	: conf.stage_padding,
				navElement 		: 'span',
				rtl				: ( Bdpp.is_rtl == 1 ) ? true : false,
				autoplayHoverPause : conf.autoplay_hover_pause,
		});
	});
}

/* Ticker */
function bdpp_init_post_ticker() {
	jQuery( '.bdpp-ticker-wrp' ).each(function( index ) {

		var ticker_id   = jQuery(this).attr('id');
		var ticker_conf = JSON.parse( jQuery(this).attr('data-conf') );

		if( typeof(ticker_id) != 'undefined' && ticker_id != '' ) {
			jQuery("#"+ticker_id).breakingNews({
				effect			: ticker_conf.ticker_effect,
				play			: ticker_conf.autoplay,
				scrollSpeed		: parseInt(ticker_conf.scroll_speed),
				stopOnHover		: ticker_conf.hover_stop,
				position		: ticker_conf.position,
				delayTimer		: parseInt(ticker_conf.speed),
				height			: parseInt(ticker_conf.height),
				borderWidth		: 2,
				radius			: '0px',
				direction		: ( Bdpp.is_rtl == 1 ) ? "rtl" : "ltr",
			});
		}
	});
}

/* Taxonomy Slider */
function bdpp_init_cat_slider() {
	jQuery( '.bdpp-term-slider-wrap' ).each(function( index ) {

		var carousel_id 	= jQuery(this).attr('id');		
		var conf 			= JSON.parse( jQuery(this).attr('data-conf') );
		var hash 			= location.hash;
		var items			= parseInt( conf.slide_show );
		var slide_scroll	= parseInt( conf.slide_scroll );

		jQuery('#'+carousel_id).owlCarousel({
			items 			: items,
			loop 			: conf.loop,
			slideBy 		: slide_scroll,
			margin 			: parseInt( conf.slide_margin ),
			nav 			: conf.arrows,
			dots 			: conf.dots,
			autoplay 		: conf.autoplay,
			startPosition 	: (conf.url_hash_listener && hash != '') ? 'URLHash' : parseInt(conf.start_position),
			lazyLoad		: conf.lazyload,
			lazyLoadEager	: ( conf.lazyload ) ? 1 : 0,
			autoplayTimeout	: parseInt( conf.autoplay_interval ),
			autoplaySpeed	: (conf.speed == 'false') ? false : parseInt( conf.speed ),
			URLhashListener : conf.url_hash_listener,
			navText 		: conf.nav_text,
			stagePadding 	: conf.stage_padding,
			center 			: conf.center,
			autoHeight 		: conf.auto_height,
			navElement 		: 'span',
			rtl				: ( Bdpp.is_rtl == 1 ) ? true : false,
			autoplayHoverPause : conf.autoplay_hover_pause,
			responsiveClass : true,
			responsive:{
				0:{
					items 	: 1,
					slideBy : 1,
					dots 	: false,
				},
				568:{
					slideBy : ( slide_scroll >= 2 ) ? 2 : slide_scroll,
					items : ( items >= 2 ) ? 2 : items,
				},
				768:{
					items : items,
				}
			}
		});
	});
}

/* Masonry */
function bdpp_init_post_masonry() {
	jQuery('.bdpp-post-masonry-wrap').each(function( index ) {

		var obj_id		= jQuery(this).attr('id');
		var msnry_id	= jQuery('#'+obj_id+' .bdpp-post-masonry-inr-wrap');

		/* Creating object */
		var masonry_param_obj = {itemSelector: '.bdpp-post-grid'};

		if( !jQuery(this).hasClass('bdpp-effect-1') ) {
			masonry_param_obj['transitionDuration'] = 0;
		}

		msnry_id.imagesLoaded(function() {
			msnry_id.masonry(masonry_param_obj);
		});
	});
}

/* Widget Slider */
function bdpp_init_widget_slider() {
	jQuery( '.bdpp-post-slider-wdgt' ).each(function( index ) {

		var slider_id 	= jQuery(this).attr('id');
		var conf 		= JSON.parse( jQuery(this).attr('data-conf') );

		jQuery('#'+slider_id).owlCarousel({
				loop 			: conf.loop,
				items 			: 1,
				nav 			: conf.arrows,
				dots 			: conf.dots,
				autoplay 		: conf.autoplay,
				lazyLoad		: conf.lazyload,
				lazyLoadEager	: ( conf.lazyload ) ? 1 : 0,
				autoplayTimeout	: parseInt( conf.autoplay_interval ),
				autoplaySpeed	: (conf.speed == 'false') ? false : parseInt( conf.speed ),
				autoHeight 		: conf.auto_height,
				navElement 		: 'span',
				rtl				: ( Bdpp.is_rtl == 1 ) ? true : false,
				autoplayHoverPause : conf.autoplay_hover_pause,
		});
	});
}

/* Vertical Scrolling Widget */
function bdpp_init_vertical_scrolling_wdgt() {
	jQuery( '.bdpp-vticker-scroling-wdgt-js' ).each(function( index ) {
		var ticker_id	= jQuery(this).attr('id');
		var conf		= JSON.parse( jQuery(this).attr('data-conf') );

		if( typeof(ticker_id) != 'undefined' && ticker_id != '' ) {

			jQuery('#'+ticker_id).vTicker({
				speed		: parseInt(conf.speed),
				pause		: parseInt(conf.pause),
				showItems	: parseInt(conf.show_items),
				height		: ( conf.height > 0 ) ? parseInt(conf.height) : '',
				direction	: conf.direction,
				mousePause	: conf.autoplay_hover_pause,
				isPaused	: conf.autoplay,
			});
		}
	});
}

/* Tooltip */
function bdpp_tooltip() {
	if( jQuery('.bdpp-tooltip:not(.tooltipstered)').length > 0 ) {
		jQuery('.bdpp-tooltip:not(.tooltipstered)').each( function() {

			var tooltip_trigger		= jQuery(this).attr('data-trigger');
			var tooltip_cnt         = jQuery(this).attr('data-tooltip-content');
			var tooltip_theme       = jQuery(this).attr('data-tooltip-theme');
			var tooltip_side        = jQuery(this).attr('data-tooltip-side');
			var tooltip_min_width   = jQuery(this).attr('data-tooltip-min-width');

			tooltip_cnt			= ( jQuery('#'+tooltip_cnt).length > 0 ) ? jQuery('#'+tooltip_cnt) : jQuery(this).parent().find('.bdpp-tooltip-cnt');
			tooltip_theme       = tooltip_theme     ? tooltip_theme     : 'bdpp-tooltipster tooltipster-noir';
			tooltip_side        = tooltip_side      ? tooltip_side      : 'top';
			tooltip_min_width   = tooltip_min_width ? tooltip_min_width : false;
			tooltip_trigger		= tooltip_trigger	? tooltip_trigger	: 'hover';

			jQuery(this).tooltipster({
				maxWidth: 300,
				content: tooltip_cnt,
				contentCloning: true,
				animation: 'fade',
				theme: tooltip_theme,
				interactive: true,
				repositionOnScroll: true,
				minWidth: tooltip_min_width,
				side:tooltip_side,
				trigger: ( Bdpp.is_mobile == 1 ) ? 'click' : tooltip_trigger,
			});
		});
	}
}

/* Resize Function */
function Bdpp_Window_Resise() {
	var window_width = jQuery(window).width();

	jQuery( '.bdpp-post-ctv1-wrap' ).each(function( index ) {

		var slider_screen	= jQuery(this).attr('data-slider-screen');
		slider_screen		= slider_screen ? slider_screen : 640;

		if( window_width <= slider_screen ) {
			jQuery(this).find( '.bdpp-post-grid' ).each(function( index ) {
				var bg_img	= jQuery(this).attr('data-bg');

				if( bg_img ) {
					jQuery(this).css('background-image', 'url(' + bg_img + ')');
				}
			});
		} else {
			jQuery(this).find( '.bdpp-post-grid' ).css('background-image', '');
		}
	});
}