(function($){
	'use strict';

	$(document).on('ready',function(){
		if($('.main-h-bottom-w').hasClass('__layout8-helper') && $('.main-h-bottom').hasClass('js--fixed-header')){
			var offset_left  = $('.icon-menu').offset().left + $('.icon-menu').outerWidth();
			var window_width = $(window).width();
			var offset_right = window_width - offset_left;
			$('.icon-menu').html('<span class="icon-menu2"></span>');
			$('.icon-menu2').css({'top':$('.icon-menu').offset().top, 'right':offset_right});
		}
	}).on('click','.icon-menu2, .js--show-next',function(){
		if(!$(this).parents().hasClass('minicart')){
			$('body').addClass('__overflow-hide');
		}
	}).on('click','.js--hide-me',function(){
		$('body').removeClass('__overflow-hide');
	}).on('focus','.nf-element',function(){
		if(!$(this).parents().hasClass('__nf_light_scheme')){
			$(this).parent().siblings().addClass('__nf_focus');
		}
	}).on('focusout','.nf-element',function(){
		$(this).parent().siblings().removeClass('__nf_focus');
	});
	$(window).on('resize',function(){
		if($('.main-h-bottom-w').hasClass('__layout8-helper') && $('.main-h-bottom').hasClass('js--fixed-header')){
			setTimeout(function(){
				var offset_left  = $('.icon-menu').offset().left + $('.icon-menu').outerWidth();
				var window_width = $(window).width();
				var offset_right = window_width - offset_left;
				$('.icon-menu2').css({'top':$('.icon-menu').offset().top, 'right':offset_right});
			}, 100);
		}
	}).on('load',function(){
		$('.__avenue_preloader_wrapper').fadeOut(500,function(){
			$('body').removeClass('__avenue_preload');
			$(this).remove();
		});
	});
})(jQuery);