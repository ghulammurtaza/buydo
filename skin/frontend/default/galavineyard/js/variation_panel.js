/**
 * EMThemes
 *
 * @license commercial software
 * @copyright (c) 2012 Codespot Software JSC - EMThemes.com. (http://www.emthemes.com)
 */
jQuery(function($) {
	var panel = $('#demotool_variation').css({'left':'-100%', 'position':'absolute'});
	
	$('a.btn-toggle').click(function () {
		if (!panel.hasClass('show')) {
			$('.variation-cp').show();
			panel.css('top', Math.max($(document).scrollTop(), Math.min($(this).offset().top, $(document).scrollTop() + $(window).height() - panel.outerHeight())) + 'px')
				.addClass('show')
				.animate({'left':$(this).width() + 1 + 'px'});
		} else {
			panel.removeClass('show')
				.animate({'left':-$(this).width() - panel.outerWidth() - 10 + 'px'}, 
				500, function () {
					$('.variation-cp').hide();
				});
			
		}
		return false;
	});

	// toogle section content-title
	$('#demotool_variation .content-title').click(function() {
		$(this).next('.wrapper-content').slideToggle('fast');
	}).trigger('click').first().trigger('click');
	

	// toggle box content
	$('#demotool_variation .box .title').click(function () {
		var box = $(this).parent();

		if (box.children('.content').is(':visible')) {
			box.children('.content').slideUp('fast');
			box.addClass('close');
		} else {
			box.children('.content').slideDown('fast');
			box.removeClass('close');
		}
			
	});
	
    function colorToHex(color) {
        if (color.substr(0, 1) === '#') {
            return color;
        }
        var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);
        
        var red = parseInt(digits[2]);
        var green = parseInt(digits[3]);
        var blue = parseInt(digits[4]);
        
        var rgb = blue | (green << 8) | (red << 16);
        return digits[1] + '#' + rgb.toString(16);
    };

	
	var oldCss = $('#emcssvariation').attr('href');
	
	$('#demotool_variation .btn-apply').click(function() {
		$('#emcssvariation').attr('href', $('#emvariationform').attr('action') + '?' + $('#emvariationform').serialize());
        
        // box/wide mode
        var mode = $('#em_box_wide').val();
        if(mode == 'box'){
            $('#emoption_wideslideshow').hide();
            $('.wrapper').addClass('em-box-custom');
            $('#container_slideshow').removeClass('em-wide-custom');
        }else{
            $('.wrapper').removeClass('em-box-custom');
            $('#emoption_wideslideshow').show();
            if ($('#wide_full').is(':checked')){
                $('#container_slideshow').addClass('em-wide-custom');
            }else{
                $('#container_slideshow').removeClass('em-wide-custom');
            }            
        }
		return false;
	});
    
	$('#demotool_variation .btn-reset').click(function() {
		$('#emcssvariation').attr('href', oldCss);
		$('#demotool_variation input[type=text], #demotool_variation select, #demotool_variation input[type=hidden]').val('').css('background-color', '');
              
		return false;
	});


	// load google fonts
	var fontLoaded = {};
	$('#em_variation_google_font').after('<p id="em_variation_google_font_preview" style="font-size:20px;padding:10px 0"></p>')
		.bind('change', function() {
			var font = $(this).val();
			if (font.length > 0) {
				font = font[font.length-1];
				if (typeof fontLoaded[font] == 'undefined') {
					$('head').append('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='+encodeURIComponent(font)+':400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext"></link>');
					$('#em_variation_google_font_preview').html(font)
						.css('font-family', font);
				}
			}
		});
		
	// stripes pattern
	$('#demotool_variation a.head_bg_image').click(function() {
		$('#demotool_variation a.head_bg_image').removeClass('selected');
		$(this).addClass('selected');
		$('#demotool_variation input[name=head_bg_image]').val('url(../images/stripes/' + $(this).data('input-value') + ')');
		return false;
	});
    
    // stripes pattern
	$('#demotool_variation a.bd_bg_image').click(function() {
		$('#demotool_variation a.bd_bg_image').removeClass('selected');
		$(this).addClass('selected');
		$('#demotool_variation input[name=bd_bg_image]').val('url(../images/stripes/' + $(this).data('input-value') + ')');
		return false;
	});
    
    // stripes pattern
	$('#demotool_variation a.foot_bg_image').click(function() {
		$('#demotool_variation a.foot_bg_image').removeClass('selected');
		$(this).addClass('selected');
		$('#demotool_variation input[name=foot_bg_image]').val('url(../images/stripes/' + $(this).data('input-value') + ')');
		return false;
	});
    
    // stripes pattern
	$('#demotool_variation a.page_bg_image').click(function() {
		$('#demotool_variation a.page_bg_image').removeClass('selected');
		$(this).addClass('selected');
		$('#demotool_variation input[name=page_bg_image]').val('url(../images/stripes/' + $(this).data('input-value') + ')');
		return false;
	});
    
    $('#em_box_wide').change(function(){
        var modevalue = $('#em_box_wide').val();
        if(modevalue == 'box'){
            $('#emoption_wideslideshow').hide();
            $('#page_boxconfig').show();
        }else{
            $('#emoption_wideslideshow').show();
            $('#page_boxconfig').hide();       
        }
    });
    
    $(document).ready(function(){
        var b = $('#em_box_wide').val();
        if(b=='wide'){
            $('#emoption_wideslideshow').show();
            $('#page_boxconfig').hide();
        }else{
            $('#emoption_wideslideshow').hide();
            $('#page_boxconfig').show();
        }
        
    });    
    
});