var bdpp_timer = null;

( function($) {

	'use strict';

	/* Post Sorting */
	if( BdppAdmin.post_sorting == 1 ) {

		$( 'table.widefat tbody th, table.widefat tbody td' ).css( 'cursor', 'move' );

		$( 'table.widefat tbody' ).sortable({
			items 	: 'tr:not(.inline-edit-row)',
			cursor 	: 'move',
			axis 	: 'y',
			containment 		: '.wrap form#posts-filter',
			scrollSensitivity 	: 40,
			placeholder 		: "ui-state-highlight",
			helper: function( event, ui ) {
				return ui;
			},
			start: function( event, ui ) {
				if ( ! ui.item.hasClass( 'alternate' ) ) {
					ui.item.css( 'background-color', '#ffffff' );
				}
			},
			stop: function( event, ui ) {
			},
			update: function( event, ui ) {
				if ( ! ui.item.hasClass( 'alternate' ) ) {
					ui.item.css( 'background-color', '' );
				}
			}
		});

		/* Save Post Order */
		$(document).on('click', '.bdpp-post-save-order', function(){

			var current_obj = $(this);
			current_obj.attr('disabled', 'disabled');
			current_obj.parent().find('.bdpp-spinner').css('visibility', 'visible');
			$('.bdpp-notice').remove();

			var data = {
							action      : 'bdpp_update_post_order',
							form_data   : current_obj.closest('form#posts-filter').serialize()
						};
			$.ajax({
				type	: "POST",
				data	: data,
				url		: ajaxurl,
				success	: function (result) {
					
					if( result.success == 1 ) {
						current_obj.closest('.wrap').find('h1:first').after('<div class="updated notice notice-success is-dismissible bdpp-notice"><p><strong>'+result.msg+'</strong></p></div>');
					} else if( result.success == 0 ) {
						current_obj.closest('.wrap').find('h1:first').after('<div class="error notice notice-error is-dismissible bdpp-notice"><p><strong>'+result.msg+'</strong></p></div>');
					}
					
					current_obj.prop("disabled", false);
					current_obj.parent().find('.bdpp-spinner').css('visibility', 'hidden');
				}
			});
		});
	}

	/* Media Uploader */
	$( document ).on( 'click', '.bdpp-img-upload', function() {

		var imgfield, showfield, file_frame;
		var ele_obj		= jQuery(this);
		imgfield		= ele_obj.parent().find('.bdpp-img-upload-input');
		showfield		= ele_obj.parent().find('.bdpp-img-preview');

		/* new media uploader */
		var button = jQuery(this);
	
		/* If the media frame already exists, reopen it. */
		if ( file_frame ) {
			file_frame.open();
		  return;
		}

		/* Create the media frame. */
		file_frame = wp.media.frames.file_frame = wp.media({
			frame: 'post',
			state: 'insert',
			title: button.data( 'uploader-title' ),
			button: {
				text: button.data( 'uploader-button-text' ),
			},
			multiple: false  /* Set to true to allow multiple files to be selected */
		});

		file_frame.on( 'menu:render:default', function(view) {
			/* Store our views in an object. */
			var views = {};

			/* Unset default menu items */
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');
			view.unset('playlist');
			view.unset('video-playlist');

			/* Initialize the views in our view object. */
			view.set(views);
		});

		/* When an image is selected, run a callback. */
		file_frame.on( 'insert', function() {

			/* Get selected size from media uploader */
			var selected_size = $('.attachment-display-settings .size').val();
			
			var selection = file_frame.state().get('selection');
			selection.each( function( attachment, index ) {
				attachment = attachment.toJSON();

				/* Selected attachment url from media uploader */
				var attachment_url = attachment.sizes[selected_size].url;

				imgfield.val(attachment_url);
				ele_obj.parent().find('.bdpp-thumb-id').val( attachment.id );
				showfield.html('<img src="'+attachment_url+'" alt="" />');
			});
		});

		/* Finally, open the modal */
		file_frame.open();
	});

	/* Clear Media */
	$( document ).on( 'click', '.bdpp-image-clear', function() {
		$(this).parent().find('.bdpp-thumb-id').val('');
		$(this).parent().find('.bdpp-img-preview').html('');
	});

	/* Vertical Tab */
	$( document ).on( "click", ".bdpp-vtab-nav a", function() {

		$(".bdpp-vtab-nav").removeClass('bdpp-active-vtab');
		$(this).parent('.bdpp-vtab-nav').addClass("bdpp-active-vtab");

		var selected_tab = $(this).attr("href");
		$('.bdpp-vtab-cnt').hide();

		/* Show the selected tab content */
		$(selected_tab).show();

		/* Pass selected tab */
		$('.bdpp-selected-tab').val(selected_tab);
		return false;
	});

	/* Remain selected tab for user */
	if( $('.bdpp-selected-tab').length > 0 ) {

		var sel_tab = $('.bdpp-selected-tab').val();

		if( typeof(sel_tab) !== 'undefined' && $(sel_tab).length > 0  ) {
			$('.bdpp-vtab-nav [href="'+sel_tab+'"]').click();
		} else {
			$('.bdpp-vtab-nav:first-child a').click();
		}
	}

	/* Clear Media After Term Added */
	if ( typeof(adminpage) !== 'undefined' && adminpage == 'edit-tags-php' ) {
		$( document ).ajaxComplete( function( event, request, options ) {
			if ( request && 4 === request.readyState && 200 === request.status
				&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

				var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
				if ( ! res || res.errors ) {
					return;
				}

				$('#addtag').find('.bdpp-thumb-id').val('');
				$('#addtag').find('.bdpp-img-preview').html('');
				$('#addtag').find('.bdpp-term-clr-wrap .wp-picker-clear').trigger('click');
				return;
			}
		});
	}

	/* Color Picker */
    if( $('.bdpp-color-box').length > 0 ) {
        $('.bdpp-color-box').wpColorPicker();
    }

    /* Widget Color Picker */
	if( $('#widgets-right .widget .bdpp-wcolor-box').length > 0 ) {
		$('#widgets-right .widget .bdpp-wcolor-box').wpColorPicker({
			change: function(event, ui) {
				$(this).closest('form').find('.widget-control-save').prop("disabled", false);
			},
			clear: function() {
				$(this).closest('form').find('.widget-control-save').prop("disabled", false);
			}
		});
	}

	/* CSS Editor */
	if( BdppAdmin.syntax_highlighting == 'true' && $('.bdpp-cust-css').length > 0 ) {
		var editor = wp.codeEditor.initialize( 'bdpp-cust-css' );

		$(document).on('postbox-toggled', function( event, ele ) {
			if( $(ele).attr('id') == 'bdpp-css-sett' ) {
				editor.codemirror.refresh();
			}
		});
	}

	/* Seting Page Toggle */
	if( $('.bdpp-sett-content-wrp').length > 0 ) {
		$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
		postboxes.add_postbox_toggles( 'toplevel_page_bdpp-settings' );
	}

	/* Seting Page Toggle Tweak */
	if( $('.bdpp-closed-sett-box').length > 0 ) {
		var sett_box		= [];
		var page_sett_box 	= [];
		var saved_sett_box 	= $('.bdpp-closed-sett-box').data('sett');

		$( '.bdpp-sett-content-wrp .postbox' ).each(function( index ) {
			page_sett_box.push( $(this).attr('id') );
		});

		$.each(saved_sett_box, function( index, value ) {
			if( $.inArray( value, page_sett_box ) == -1 ) {
				sett_box.push( value );
			}
		});

		$('.bdpp-closed-sett-box .postbox').attr('id', sett_box.join(',') );
	}

	/* Alert Confirmation */
	$('.bdpp-confirm').on('click', function() {
		if( confirm( BdppAdmin.confirm_msg ) ) {
			return true;
		}
		return false;
	});

	/* Reset confirmation */
	jQuery( document ).on( "click", ".bdpp-reset-button", function() {
		var ans;
		ans = confirm( BdppAdmin.reset_msg );
		if(ans) {
			return true;
		} else {
			return false;
		}
	});

	/* Featured Post */
	$(document).on('click', '.wp-list-table .bdpp-post-feat', function() {

		var current_obj = $(this);

		clearTimeout(bdpp_timer);

		$('.bdpp-screen-loader').remove();
		$('body').append('<div class="bdpp-screen-loader">'+BdppAdmin.wait_msg+'</div>');
		$('.bdpp-screen-loader').animate({bottom: '50px'}, 400);

		var data = {
						action	: 'bdpp_featured_post',
						post_id	: current_obj.data('id'),
						is_feat	: current_obj.hasClass('dashicons-star-filled') ? 1 : 0,
					};
		$.post(ajaxurl, data, function(result) {
			if( result.success == 1 ) {

				if( result.feat_val == 1 ) {
					current_obj.removeClass('dashicons-star-empty').addClass('dashicons-star-filled');
				} else {
					current_obj.removeClass('dashicons-star-filled').addClass('dashicons-star-empty');
				}

				$(".bdpp-screen-loader").text(result.msg);

			} else {
				$(".bdpp-screen-loader").addClass('bdpp-screen-loader-err').text(result.msg);
			}

			bdpp_timer = setTimeout(function() {
				$(".bdpp-screen-loader").fadeOut("normal", function() {
					$(this).remove();
				});
			}, 3000 );
		});
	});

	/* Reset Post View Count Ajax */
	$( document ).on( 'click', '.bdpp-reset-post-count', function() {

		var current_obj = $(this);
		var ans;

		clearTimeout(bdpp_timer);

		ans = confirm( BdppAdmin.reset_post_view_msg );

		if(ans == 1) {

			/* Initialize Loader */
			current_obj.attr('disabled', 'disabled');
			$('.bdpp-screen-loader').remove();
			$('body').append('<div class="bdpp-screen-loader">'+BdppAdmin.wait_msg+'</div>');
			$('.bdpp-screen-loader').animate({bottom: '50px'}, 400);

			var data = {
						action      : 'bdpp_reset_post_view_count',                      
						post_id 	: BdppAdmin.post_id,
					};

			 $.post(ajaxurl, data, function(result) {

				if( result.status == 1 ) {

					$('.bdpp-post-count-view').html('0');
					current_obj.remove();
					$('.bdpp-screen-loader').html(result.msg);

				} else {
					current_obj.prop("disabled", false);
					$('.bdpp-screen-loader').addClass('bdpp-screen-loader-err').html(result.msg);
				}

				bdpp_timer = setTimeout(function() {
					$(".bdpp-screen-loader").fadeOut("normal", function() {
						$(this).remove();
					});
				}, 3000 );
			});
		}
	});

	/* Widget Accordian */
	$(document).on('click', '.bdpp-widget-acc', function() {
		var target		= $(this).attr('data-target');
		var cls_ele		= $(this).closest('form');
		var target_open	= cls_ele.find('.bdpp-widget-'+target).is(":visible");

		cls_ele.find('.bdpp-widget-acc-cnt-wrap').slideUp();
		cls_ele.find('.bdpp-widget-sel-tab').val('');

		if( ! target_open ) {
			cls_ele.find('.bdpp-widget-'+target).slideDown();
			cls_ele.find('.bdpp-widget-sel-tab').val( target );
		}
	});

	/***** Ajax Get Taxonomy *****/
	$( document ).on( 'change', '.bdpp-reg-post-types', function() {
		var cls_ele 	= $(this).closest('form');
		var post_type 	= $(this).val();
		
		cls_ele.find('.bdpp-widget-loader').show();

		var data = {
						action		: 'bdpp_ajax_get_post_taxonomy',
						post_type	: post_type
					};

		$.post(ajaxurl, data, function( result ) {
			cls_ele.find(".bdpp-reg-taxonomy").html('');
			cls_ele.find(".bdpp-reg-taxonomy").html(result.taxonomy);
			cls_ele.find('.bdpp-widget-loader').hide();
		});
	});

	/***** Ajax Get Post Types for Trending Display Type *****/
	$( document ).on( 'change', '.bdpp-post-display-types', function() {
		var cls_ele 	= $(this).closest('form');
		var type 		= $(this).val();

		cls_ele.find('.bdpp-widget-loader').show();

		var data = {
						action	: 'bdpp_ajax_get_post_types',
						type	: type
					};

		$.post(ajaxurl, data, function( result ) {
			cls_ele.find(".bdpp-reg-post-types").html(result.post_type);
			cls_ele.find( '.bdpp-reg-post-types' ).trigger('change');
			cls_ele.find('.bdpp-widget-loader').hide();
		});
	});

	/* Social Sharing Service Add */
	$(document).on('click', '.bdpp-social-service-add', function() {
		var current_obj = $(this);
		var cls_ele		= current_obj.closest('.bdpp-social-service-wrap');
		var clone_ele	= current_obj.closest('.bdpp-social-service-row').clone();

		clone_ele.find('select').val('');
		cls_ele.append( clone_ele );
	});

	/* Social Sharing Service Remove */
	$(document).on('click', '.bdpp-social-service-del', function() {
		var current_obj = $(this);
		var wrap_ele	= current_obj.closest('.bdpp-social-service-wrap');
		var cls_ele		= current_obj.closest('.bdpp-social-service-row');
		var row_count	= wrap_ele.find('.bdpp-social-service-row').length;

		if( row_count > 1 ) {
			current_obj.closest('.bdpp-social-service-row').remove();
		} else {
			cls_ele.find('select').val('');
		}
	});

	/* Elementor Widget Option Loaded */
	if( BdppAdmin.elementor == 1 ) {
		elementor.hooks.addAction( 'panel/widgets/wp-widget-bdpp-post-ticker-swdgt/controls/wp_widget/loaded', function( panel ) {
			if( $('.bdpp-wcolor-box').length > 0 ) {

				setTimeout(function() {
					jQuery(panel.$el).find('.bdpp-widget-refresh-inp').val( $.now() ).trigger('change');
				}, 50);

				$('.bdpp-wcolor-box').wpColorPicker({
					change: function(event, ui) {
						setTimeout(function() {
							jQuery(panel.$el).find('.bdpp-widget-title-inp').trigger('change');
						}, 1);
					},
					clear: function(event, ui) {
						setTimeout(function() {
							jQuery(panel.$el).find('.bdpp-widget-title-inp').trigger('change');
						}, 1);
					}
				});
			}
		});
	}
})( jQuery );

jQuery(document).on('widget-added widget-updated', bdpp_on_update_widget);
function bdpp_on_update_widget( event, widget ) {
	if( widget.find( '.bdpp-wcolor-box' ).length > 0 ) {
		widget.find( '.bdpp-wcolor-box' ).wpColorPicker({
			change: function(event, ui) {
				widget.find('.widget-control-save').prop("disabled", false);
			},
			clear: function() {
				widget.find('.widget-control-save').prop("disabled", false);
			}
		});
	}
}