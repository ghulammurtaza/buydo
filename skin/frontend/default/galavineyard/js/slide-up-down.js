jQuery.noConflict();
;(function($) {
	$.fn.slideUpDown = function(params) {
		var defaults = { 
			imgSelector : 	'a.product-image img',
			divHover	:	'.hover-slide',
			speed		:	200
		}
		var opts = $.extend({}, defaults, params);
		var timeout = new Array($(this).length);
		
		$(this).find(opts.divHover).hide();
		$(this).find(opts.imgSelector).bind('mouseover', function(){
			showDetail($(this).parent().parent().children('.js-addcart-fix-shop').children('.js-addcart-fix').find(opts.divHover),opts.speed);
		}).bind('click', function(){
			showDetail($(this).parent().parent().children('.js-addcart-fix-shop').children('.js-addcart-fix').find(opts.divHover),opts.speed);
		}).bind('mouseout', function(){
			hideDetail($(this).parent().parent().children('.js-addcart-fix-shop').children('.js-addcart-fix').find(opts.divHover),opts.speed);
		});

		$(this).children('.js-addcart-fix-shop').children('.js-addcart-fix').find(opts.divHover).bind('mouseover', function(){
			showDetail($(this),opts.speed);
		}).bind('click', function(){
			hideDetail($(this),opts.speed);
		}).bind('mouseout', function(){
			hideDetail($(this),opts.speed);
		});

		//var timeout = null;
		var hideDetail = function (element,speed) {
			if (timeout[element.attr('name')])
				clearTimeout(timeout[element.attr('name')]);
			timeout[element.attr('name')] = setTimeout(function() {
				timeout[element.attr('name')] = null;
				element.fadeOut('fast');
			}, speed);
		}

		var showDetail = function (element,speed) {
			if (timeout[element.attr('name')])
				clearTimeout(timeout[element.attr('name')]);
			timeout[element.attr('name')] = setTimeout(function() {
				timeout[element.attr('name')] = null;
				element.fadeIn('fast');
			}, speed);
		}
	}
})(jQuery);