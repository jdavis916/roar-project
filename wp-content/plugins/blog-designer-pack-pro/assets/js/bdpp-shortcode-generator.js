var timer;
var timeOut_Val = 300;  
var timeOut = timeOut_Val; /* delay after last change to execute filter */
var tmpl_id = jQuery('.bdpp-customizer').attr('data-template');
var preview_shortcode = jQuery('.bdpp-customizer').attr('data-shortcode');

var checked_show_dep	= [];
var dep_wrap 			= '.bdpp-shrt-fields-panel';
var dependency 			= jQuery(dep_wrap +' .bdpp-cust-dependency').attr('data-dependency');
dependency 				= dependency ? JSON.parse( dependency ) : false;

jQuery( document ).ready(function($) {

	$(document).on('click', '.bdpp-shrt-dwp', function() {
		$('body').toggleClass('bdpp-shrt-full-preview');
		$(this).toggleClass( 'bdpp-shrt-dwp-active' );
	});

	/* Customizer Accordian */
	$( "#bdpp-shrt-accordion" ).accordion({
		collapsible: true,
		heightStyle: "content",
		icons : {
				header: "dashicons dashicons-arrow-down-alt2",
				activeHeader: "dashicons dashicons-arrow-up-alt2"
	    }
	});

	/* Color Picker */
    if( $('.bdpp-cust-color-box').length > 0 ) {
        $('.bdpp-cust-color-box').wpColorPicker({
        	change: function(event, ui) {
        		bdpp_generate_shortcode_preview();
        	},
        	clear: function() {
        		bdpp_generate_shortcode_preview();
        	}
        });
    }

	/* Generate Shortcode */
    $(document).on('change', '.bdpp-shrt-fields-panel select, .bdpp-shrt-fields-panel input[type="number"]', function() {
    	field_timeout 	= $(this).attr('data-timeout');
    	timeOut 		= (typeof(field_timeout) !== 'undefined') ? field_timeout : timeOut_Val;

    	bdpp_generate_shortcode_preview();
	});

	$(document).on('keyup', '.bdpp-shrt-fields-panel input[type="text"], .bdpp-shrt-fields-panel input[type="number"]', function() {
    	field_timeout 	= $(this).attr('data-timeout');
    	timeOut 		= (typeof(field_timeout) !== 'undefined') ? field_timeout : timeOut_Val;

    	bdpp_generate_shortcode_preview();
	});

    /* On Change of Customizer Shortcode */
	$(document).on('change', '.bdpp-shrt-switcher', function() {
		redirect = $(this).find(":selected").attr('data-url');

		if( typeof(redirect) !== 'undefined' && redirect != '' ) {
			window.location = redirect;
		}
	});

	/* Tweak - An extra care that form should not be refresh */
	jQuery('#bdpp-customizer-shrt-form').on("submit", function( event ) {
    	var form_target = $(this).attr('target');

    	if( typeof(form_target) == 'undefined' || form_target == '' ) {
    		return false;
    	}
    });

	/* On Click of Preview Generate Button */
	$(document).on('click', '.bdpp-cust-shrt-generate', function() {

		var main_ele	= '.bdpp-shrt-fields-panel';
		var data		= bdpp_check_valid_shortcode();

		/* If wrong shortcode then simply return */
		if( data && data.numeric[0] && data.numeric[0] !== preview_shortcode ) {
			alert( Bdpp_Shrt_Generator.shortcode_err );
			return false;
		}

		if( data.named ) {
			$.each( data.named, function( shrt_param, shrt_param_val ) {
				if( shrt_param ) {
					$(main_ele+' .bdpp-'+shrt_param).val( shrt_param_val ).trigger('change').trigger('keyup');
				}
			});
		}
	});

	/* Template id is set then run it's shortcode */
	if( tmpl_id != '' ) {
		$('.bdpp-cust-shrt-generate').trigger('click');
	}

	/* Shortcode Customizer Dependency */
	if( dependency ) {
		$.each( dependency, function( key, dependency_val ) {

			if( key ) {

				/* Dependency on page load */
				setTimeout(function() {
					if( $.inArray( key, checked_show_dep ) == -1 ) {
			        	$(dep_wrap+' .bdpp-'+key+'').trigger('change');
			    	}
			    }, 10);

				$(document).on('change keyup', dep_wrap+' .bdpp-'+key+'', function() {
			    	
			    	var input_val = $(this).val();

			    	/* Show Dependency */
			    	if( dependency_val.show ) {
			    		$.each( dependency_val.show, function( sub_key, sub_dep_val ) {
			    			$(dep_wrap+' .bdpp-'+sub_key+'').closest('.bdpp-customizer-row').hide();
			    			$(dep_wrap+' .bdpp-'+sub_key+'').addClass('bdpp-cust-hidden-field');

			    			/* If value is present then show */
			    			if( ( $.inArray( input_val, sub_dep_val ) !== -1 ) ) {
			    				$(dep_wrap+' .bdpp-'+sub_key+'').closest('.bdpp-customizer-row').show();
			    				$(dep_wrap+' .bdpp-'+sub_key+'').removeClass('bdpp-cust-hidden-field');
			    			}

			    			/* Check if reference dependency is there then hide it's element also */
			    			bdpp_check_ref_dependency( sub_key );
			    		});
			    	}

			    	/* Hide Dependency */
			    	if( dependency_val.hide ) {
			    		$.each( dependency_val.hide, function( sub_key, sub_dep_val ) {

			    			$(dep_wrap+' .bdpp-'+sub_key+'').closest('.bdpp-customizer-row').show();
			    			$(dep_wrap+' .bdpp-'+sub_key+'').removeClass('bdpp-cust-hidden-field');

			    			if( ( $.inArray( input_val, sub_dep_val ) !== -1 ) ) {
			    				$(dep_wrap+' .bdpp-'+sub_key+'').closest('.bdpp-customizer-row').hide();
			    				$(dep_wrap+' .bdpp-'+sub_key+'').addClass('bdpp-cust-hidden-field');
			    			}

			    			/* Check if reference dependency is there then hide it's element also */
			    			bdpp_check_hide_ref_dependency( sub_key );
			    		});
			    	}
				});
			}
		});
	} else {
		bdpp_generate_shortcode_preview();
	}
	/* Shortcode Customizer Dependency */

	/* Shortcode Template Popup */
	$(document).on('click', '.bdpp-shrt-tmpl-gen', function() {

		var data = bdpp_check_valid_shortcode();

		/* If valid shortcode is there */
		if( data && data.numeric[0] && data.numeric[0] == preview_shortcode ) {
			
			$('.bdpp-popup-wrp').show();
			$('.bdpp-popup-overlay').fadeIn();
			$('body').addClass('bdpp-no-overflow');

			$('.bdpp-popup-wrp .bdpp-hide').hide();
			$('.bdpp-add-shrt-tmpl-popup-wrp input[type="text"]').val('');

			var shrt_val = $('.bdpp-shrt-box').val();
			$('.bdpp-popup-wrp .bdpp-tmpl-shrt-preview').text( shrt_val );

		} else {
			alert( Bdpp_Shrt_Generator.shortcode_err );
			return false;
		}
	});

	/* Close Popup */
	$(document).on('click', '.bdpp-popup-close', function(){
		bdpp_hide_popup();
	});

	/*`Esc` key is pressed*/
	$(document).on('keyup', function(e) {
		if (e.keyCode == 27) {
			bdpp_hide_popup();
		}
	});

	/* Save shortcode template */
	$(document).on('click', '.bdpp-shrt-tmpl-save', function(){
		
		var curr_obj 	= $(this);
		var cls_ele		= curr_obj.closest('.bdpp-popup-wrp');
		var shrt_val 	= $('.bdpp-shrt-box').val();

		cls_ele.find('.bdpp-popup-notice').hide().removeClass('bdpp-popup-notice-err');
		cls_ele.find('.bdpp-popup-spinner').css('visibility', 'visible');
		curr_obj.attr('disabled', 'disabled');

		var data = {
			action 		: 'bdpp_save_shortcode_tmpl',
			form_data	: curr_obj.closest('form').serialize(),
			shortcode	: shrt_val,
			type		: preview_shortcode,
			tmpl_id		: tmpl_id,
		};

		$.post(ajaxurl, data, function(result) {

			if( result.success == 0 ) {
				cls_ele.find('.bdpp-popup-notice').addClass('bdpp-popup-notice-err');
			} else {
				if( result.redirect_url != '' ) {
					window.location.href = result.redirect_url;
				}
			}

			cls_ele.find('.bdpp-popup-notice').html( result.msg ).show();
			cls_ele.find('.bdpp-popup-spinner').css('visibility', 'hidden');
			curr_obj.removeAttr('disabled', 'disabled');
		});
	});
});

/* Check Valid Shortcode */
function bdpp_check_valid_shortcode() {
	var shrt_val 	= jQuery('.bdpp-shrt-box').val();
		shrt_val 	= shrt_val.trim();
	var first_char 	= shrt_val.substr(0, 1);
	var last_char 	= shrt_val.substr(-1);

	/* Simply return if blank value */
	if( shrt_val == '' ) {
		return false;
	}

	if( first_char == '[' && last_char == ']' ) {
		shrt_val = shrt_val.slice(1, -1);
		shrt_val = shrt_val.trim();

		first_char 	= shrt_val.substr(0, 1);
		last_char 	= shrt_val.substr(-1);
	}

	if( first_char != '[' ) {
		shrt_val = '[' + shrt_val;
	}
	if( last_char != ']' ) {
		shrt_val = shrt_val + ']';
	}

	jQuery('.bdpp-shrt-box').val( shrt_val );

	temp_shrt_val = shrt_val.slice(1, -1);
	temp_shrt_val = temp_shrt_val.trim();
	var data = wp.shortcode.attrs( temp_shrt_val );

	return data;
}

/* Function to generate shortcode preview */
function bdpp_generate_shortcode_preview() {

	/* Taking some variables */
    var shortcode_val   = '';
    var main_ele		= jQuery('.bdpp-customizer');
    var cls_ele         = jQuery('.bdpp-shrt-fields-panel');
    var shortcode_name  = preview_shortcode;

	clearTimeout(timer); /* if we pressed the key, it will clear the previous timer and wait again */
    timer = setTimeout(function() {

    	main_ele.find('.bdpp-shrt-loader').fadeIn();

        shortcode_val += '['+shortcode_name;

        /* Loop of form element */
        cls_ele.find('input[type="text"], input[type="checkbox"]:checked, input[type="radio"], input[type="number"], textarea, select').each(function(i, field){

        	if( jQuery(this).hasClass('bdpp-cust-hidden-field') ) {
        		return;
        	}

            var field_val	= jQuery(this).val();
            var field_name  = jQuery(this).attr('name');
            var default_val	= jQuery(this).attr('data-default');
            var allow_empty	= jQuery(this).attr('data-empty');            

            if( typeof(field_val) != 'undefined' && ( field_val != '' || allow_empty ) && field_val != default_val ) {
                shortcode_val += ' '+field_name+'='+'"'+field_val+'"';
            }
        });

        shortcode_val += ']';

        /* Append shortcode */
        main_ele.find('.bdpp-shrt-box').val(shortcode_val);

        jQuery('#bdpp-customizer-shrt-form').trigger("submit");

        main_ele.find('.bdpp-shrt-preview-frame').on("load", function() {
			main_ele.find('.bdpp-shrt-loader').fadeOut();
		});

    }, timeOut);
}

/* Function to check reference dependency */
function bdpp_check_ref_dependency( sub_key ) {

	ref_dep = sub_key in dependency;

	if( ref_dep ) {

		var ref_input_val = jQuery(dep_wrap+' .bdpp-'+sub_key+'').val();

		jQuery.each( dependency[sub_key]['show'], function( ref_key, ref_dep_val ) {

			jQuery(dep_wrap+' .bdpp-'+ref_key+'').closest('.bdpp-customizer-row').hide();
			jQuery(dep_wrap+' .bdpp-'+ref_key+'').addClass('bdpp-cust-hidden-field');

			if( jQuery.inArray( ref_input_val, ref_dep_val ) !== -1 && (!jQuery(dep_wrap+' .bdpp-'+sub_key+'').hasClass('bdpp-cust-hidden-field')) ) {
				jQuery(dep_wrap+' .bdpp-'+ref_key+'').closest('.bdpp-customizer-row').show();
				jQuery(dep_wrap+' .bdpp-'+ref_key+'').removeClass('bdpp-cust-hidden-field');
			}

			/* Check if reference dependency is there then hide it's element also */
			bdpp_check_ref_dependency( ref_key );
		});

		checked_show_dep.push( sub_key ); /* Log checked show dependency */
	}
}

/* Function to check hide reference dependency */
function bdpp_check_hide_ref_dependency( sub_key ) {

	ref_dep = sub_key in dependency;

	if( ref_dep ) {

		var ref_input_val = jQuery(dep_wrap+' .bdpp-'+sub_key+'').val();

		jQuery.each( dependency[sub_key]['hide'], function( ref_key, ref_dep_val ) {

			jQuery(dep_wrap+' .bdpp-'+ref_key+'').closest('.bdpp-customizer-row').hide();
			jQuery(dep_wrap+' .bdpp-'+ref_key+'').addClass('bdpp-cust-hidden-field');

			if( jQuery.inArray( ref_input_val, ref_dep_val ) == -1 && (!jQuery(dep_wrap+' .bdpp-'+sub_key+'').hasClass('bdpp-cust-hidden-field')) ) {
				jQuery(dep_wrap+' .bdpp-'+ref_key+'').closest('.bdpp-customizer-row').show();
				jQuery(dep_wrap+' .bdpp-'+ref_key+'').removeClass('bdpp-cust-hidden-field');
			}

			/* Check if reference dependency is there then hide it's element also */
			bdpp_check_hide_ref_dependency( ref_key );
		});
	}
}

/* Function to hide popup */
function bdpp_hide_popup() {
	jQuery('.bdpp-popup-wrp').hide();
	jQuery('.bdpp-popup-overlay').hide();
	jQuery('body').removeClass('bdpp-no-overflow');
}