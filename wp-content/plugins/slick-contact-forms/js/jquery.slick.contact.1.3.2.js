/**
* hoverIntent r5 // 2007.03.27 // jQuery 1.1.2+
* <http://cherne.net/brian/resources/jquery.hoverIntent.html>
* 
* @param  f  onMouseOver function || An object with configuration options
* @param  g  onMouseOut function  || Nothing (use configuration options object)
* @author    Brian Cherne <brian@cherne.net>
*/
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright � 2008 George McGinley Smith
 * All rights reserved.
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});

/*
 * DC jQuery Slick Contact Forms
 * Copyright (c) 2011 Design Chemical
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */

(function($){

	//define the new for the plugin ans how to call it
	$.fn.dcSlickContact = function(options) {

		//set default options
		var defaults = {
			classWrapper: 'dc-floater',
			classContent: 'dc-floater-content',
			width: 260,
			idWrapper: 'dc-floater-'+$(this).index(),
			location: 'top', // top, bottom
			align: 'left', // left, right
			offsetLocation: 10,
			offsetAlign: 10,
			speedFloat: 1500,
			speedContent: 600,
			tabText: '',
			event: 'click',
			classTab: 'tab',
			autoClose: true,
			easing: 'easeOutQuint',
			classForm: 'slick-form',
			method: 'stick', // stick or float
			linkOpen: 'dcscf-open',
			linkClose: 'dcscf-close',
			linkToggle: 'dcscf-link',
			loadOpen: false,
			animateError: true,
			ajaxSubmit: true
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		
		//act upon the element that is passed into the design    
		return this.each(function(options){

			// declare common var
			var width = defaults.width,
			location = defaults.location,
			align = defaults.align,
			speed = defaults.speedContent,
			tabText = defaults.tabText,
			autoClose = defaults.autoClose,
			idWrapper = defaults.idWrapper,
			linkOpen = defaults.linkOpen,
			linkClose = defaults.linkClose,
			linkToggle = defaults.linkToggle,
			loadOpen = defaults.loadOpen,
			ajaxSubmit = defaults.ajaxSubmit
			
			if(defaults.method == 'stick'){
			
				$(this).dcSlickContactStick({
					width: width,
					location:  location,
					align: align,
					offset: defaults.offsetLocation+'px',
					speed: speed,
					tabText: tabText,
					autoClose: autoClose,
					idWrapper: idWrapper,
					classOpen: linkOpen,
					classClose: linkClose,
					classToggle: linkToggle,
					loadOpen: loadOpen
				});
				var errorAlign = defaults.location;
                if((defaults.location == 'top') || (defaults.location == 'bottom')){
                    errorAlign = defaults.align;
                }

			} else {
				$(this).dcSlickContactFloat({
					width: width,
					location: location,
					align: align,
					offsetLocation: defaults.offsetLocation,
					offsetAlign: defaults.offsetAlign,
					speedFloat: defaults.speedFloat,
					speedContent: speed,
					tabText: tabText,
					autoClose: autoClose,
					easing: defaults.easing,
					event: defaults.event,
					idWrapper: idWrapper,
					classOpen: linkOpen,
					classClose: linkClose,
					classToggle: linkToggle,
					loadOpen: loadOpen
				});
				var errorAlign = align;

			}

			$('#'+defaults.idWrapper+' .slick-form').dcSlickForms({
				align: errorAlign,
				animateError: defaults.animateError,
				ajaxSubmit: ajaxSubmit
			});
			
		});
	};
})(jQuery);

/*

 * DC jQuery Slick - jQuery Slick
 * Copyright (c) 2011 Design Chemical
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */

(function($){

	//define the new for the plugin ans how to call it
	$.fn.dcSlickContactStick = function(options) {

		//set default options
		var defaults = {
			classWrapper: 'dc-contact-slick',
			classContent: 'dc-contact-content',
			width: 260,
			idWrapper: 'dc-contact-'+$(this).index(),
			location: 'left',
			align: 'top',
			offset: '100px',
			speed: 'slow',
			tabText: '',
			classTab: 'tab',
			classOpen: 'dc-open',
			classClose: 'dc-close',
			classToggle: 'dc-toggle',
			autoClose: true,
			loadOpen: false
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		var $dcSlickObj = this;
		//act upon the element that is passed into the design
		return $dcSlickObj.each(function(options){

			var slickHtml = $dcSlickObj.html();
			var slickTab = '<div class="'+defaults.classTab+'"><span>'+defaults.tabText+'</span></div>';
			$(this).hide();
			var idWrapper = defaults.idWrapper;
			var slider = '<div id="'+idWrapper+'" class="'+defaults.classWrapper+'">'+slickTab+'<div class="'+defaults.classContent+'">'+slickHtml+'</div></div>';
			$('body').append(slider);
			var $slider = $('#'+idWrapper);
			$slider.css('width',defaults.width+'px');
			var $tab = $('.'+defaults.classTab,$slider);
			$tab.css({position: 'absolute'});
			var linkOpen = $('.'+defaults.classOpen);
			var linkClose = $('.'+defaults.classClose);
			var linkToggle = $('.'+defaults.classToggle);
			
			// Get container dimensions
			var height = $slider.height();
			var outerW = $slider.outerWidth();
			var widthPx = outerW+'px';
			var outerH = $slider.outerHeight();
			var padH = outerH - height;
			var heightPx = outerH+'px';
			var bodyHeight = $(window).height();
			
			slickSetup($slider);
			
			if(defaults.autoClose == true){
				$('body').mouseup(function(e){
					if($slider.hasClass('active')){
						if(!$(e.target).parents('#'+defaults.idWrapper+'.'+defaults.classWrapper).length){
							slickClose();
						}
					}
				});
			}
			
			$tab.click(function(){
				if($slider.hasClass('active')){
					slickClose();
				} else {
					slickOpen();
				}
			});
			
			$(linkOpen).click(function(e){
				slickOpen();
				e.preventDefault();
			});
			
			$(linkClose).click(function(e){
				if($slider.hasClass('active')){
					slickClose();
				}
				e.preventDefault();
			});
			
			$(linkToggle).click(function(e){
				if($slider.hasClass('active')){
					slickClose();
				} else {
					slickOpen();
				}
				e.preventDefault();
			});
			
			if(defaults.loadOpen == true){
				slickOpen();
			}
	
			function slickOpen(){
			
				$('.'+defaults.classWrapper).css({zIndex: 10000});
				if(defaults.location == 'bottom'){
					$slider.animate({marginBottom: "-=5px"}, "fast").animate({marginBottom: 0}, defaults.speed);
				}
				if(defaults.location == 'top'){
					$slider.animate({marginTop: "-=5px"}, "fast").animate({marginTop: 0}, defaults.speed);
				}
				if(defaults.location == 'left'){
					$slider.animate({marginLeft: "-=5px"}, "fast").animate({marginLeft: 0}, defaults.speed);
				}
				if(defaults.location == 'right'){
					$slider.animate({marginRight: "-=5px"}, "fast").animate({marginRight: 0}, defaults.speed);
				}
				$slider.addClass('active');$slider.css({zIndex: 10001});
			}
			
			function slickClose(){
			
			$slider.css({zIndex: 10000});
			if($slider.hasClass('active')){
				var param = {"marginBottom": "-"+heightPx};
				if(defaults.location == 'top'){
					var param = {"marginTop": "-"+heightPx};
				}
				if(defaults.location == 'left'){
					var param = {"marginLeft": "-"+widthPx};
				}
				if(defaults.location == 'right'){
					var param = {"marginRight": "-"+widthPx};
				}
				$slider.removeClass('active');
			}
			$slider.animate(param, defaults.speed,function(){
				$slider.dcFormReset();
			});
			}
			
			function slickSetup(obj){
				var $container = $('.'+defaults.classContent,obj);
				// Get slider border
				var bdrTop = $slider.css('border-top-width');
				var bdrRight = $slider.css('border-right-width');
				var bdrBottom = $slider.css('border-bottom-width');
				var bdrLeft = $slider.css('border-left-width');
				// Get tab dimension
				var tabWidth = $tab.outerWidth();
				var tabWidthPx = tabWidth+'px';
				var tabHeight = $tab.outerHeight();
				var tabHeightPx = tabHeight+'px';
				// Calc max container dimensions
				var containerH = $container.height();
				var containerPad = $container.outerHeight()-containerH;
				var maxHeight = bodyHeight - tabHeight;
				$(obj).addClass(defaults.location).addClass('align-'+defaults.align).css({position: 'fixed', zIndex: 10000});
				if(outerH > maxHeight){
					containerH = maxHeight - padH - containerPad;
					heightPx = maxHeight+'px';
				}
				$container.css({height: containerH+'px'});
				if(defaults.location == 'left'){
					$(obj).css({marginLeft: '-'+widthPx, top: defaults.offset});
					$tab.css({marginRight: '-'+tabWidthPx});
				}
				
				if(defaults.location == 'right'){
					$(obj).css({marginRight: '-'+widthPx});
					$tab.css({marginLeft: '-'+tabWidthPx});
					$(obj).css({top: defaults.offset});
				}
				
				if(defaults.location == 'top'){
					$(obj).css({marginTop: '-'+heightPx});
					$tab.css({marginBottom: '-'+tabHeightPx});
					
					if(defaults.align == 'left'){
						$(obj).css({left: defaults.offset});
						$tab.css({left: 0});
					} else {
						$(obj).css({right: defaults.offset});
						$tab.css({right: 0});
					}
				}
				
				if(defaults.location == 'bottom'){
					$(obj).css({marginBottom: '-'+heightPx});
					$tab.css({marginTop: '-'+tabHeightPx});
					
					if(defaults.align == 'left'){
						$(obj).css({left: defaults.offset});
						$tab.css({left: 0});
					} else {
						$(obj).css({right: defaults.offset});
						$tab.css({right: 0});
					}
				}
			}
		});
	};
})(jQuery);

/*
 * DC jQuery Floater - jQuery Floater
 * Copyright (c) 2011 Design Chemical
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */

(function($){

	//define the new for the plugin ans how to call it
	$.fn.dcSlickContactFloat = function(options) {

		//set default options
		var defaults = {
			classWrapper: 'dc-contact-float',
			classContent: 'dc-contact-content',
			width: 260,
			idWrapper: 'dc-contact-'+$(this).index(),
			location: 'top', // top, bottom
			align: 'left', // left, right
			offsetLocation: 10,
			offsetAlign: 10,
			speedFloat: 1500,
			speedContent: 600,
			tabText: '',
			event: 'click',
			classTab: 'tab',
			classOpen: 'dc-open',
			classClose: 'dc-close',
			classToggle: 'dc-toggle',
			autoClose: true,
			easing: 'easeOutQuint',
			loadOpen: false
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		
		//act upon the element that is passed into the design    
		return this.each(function(options){

			var floatHtml = $(this).html();
			var floatTab = '<div class="'+defaults.classTab+'"><span>'+defaults.tabText+'</span></div>';
			$(this).hide();
			var idWrapper = defaults.idWrapper;
			if(defaults.location == 'bottom'){
				var objHtml = '<div id="'+idWrapper+'" class="'+defaults.classWrapper+' '+defaults.location+' '+defaults.align+'"><div class="'+defaults.classContent+'">'+floatHtml+'</div>'+floatTab+'</div>';
			} else {
				var objHtml = '<div id="'+idWrapper+'" class="'+defaults.classWrapper+' '+defaults.align+'">'+floatTab+'<div class="'+defaults.classContent+'">'+floatHtml+'</div></div>';
			}
			$('body').append(objHtml);
			
			//cache vars
			var $floater = $('#'+idWrapper);
			var $tab = $('.'+defaults.classTab,$floater);
			var $content = $('.'+defaults.classContent,$floater);
			var linkOpen = $('.'+defaults.classOpen);
			var linkClose = $('.'+defaults.classClose);
			var linkToggle = $('.'+defaults.classToggle);
			
			$floater.css({width: defaults.width+'px', position: 'absolute', zIndex: 10000});
			
			var h_c = $content.outerHeight(true);
			var h_f = $floater.outerHeight();
			var h_t = $tab.outerHeight();
			$content.hide();
			
			floaterSetup($floater);
		
			var start = $('#'+idWrapper).position().top;
			
			floatObj();
			
			$(window).scroll(function(){
				floatObj();
			});
			
			// If using hover event
			if(defaults.event == 'hover'){
				// HoverIntent Configuration
				var config = {
					sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
					interval: 100, // number = milliseconds for onMouseOver polling interval
					over: floatOpen, // function = onMouseOver callback (REQUIRED)
					timeout: 400, // number = milliseconds delay before onMouseOut
					out: floatClose // function = onMouseOut callback (REQUIRED)
				};
				$floater.hoverIntent(config);
			}
			
			// If using click event
			if(defaults.event == 'click'){
				
				$tab.click(function(e){
					if($floater.hasClass('active')){
						floatClose();
					} else {
						floatOpen();
					}
					e.preventDefault();
				});
				
				$(linkOpen).click(function(){
					floatOpen();
				});
				
				$(linkClose).click(function(){
					if($floater.hasClass('active')){
						floatClose();
					}
				});
				
				$(linkToggle).click(function(e){
					if($floater.hasClass('active')){
						floatClose();
					} else {
						floatOpen();
					}
					e.preventDefault();
				});
			}
			
			// Auto-close
			if(defaults.autoClose == true){
	
				$('body').mouseup(function(e){
					if($floater.hasClass('active')){
						if(!$(e.target).parents('#'+defaults.idWrapper+'.'+defaults.classWrapper).length){
							floatClose();
						}
					}
				});
			}
			
			if(defaults.loadOpen == true){
				floatOpen();
			}
			
			function floatOpen(){
			
				$('.'+defaults.classWrapper).css({zIndex: 10000});
				$floater.css({zIndex: 10001});
				var h_fpx = h_c+'px';
				
				if(defaults.location == 'bottom'){
					$content.animate({marginTop: '-'+h_fpx}, defaults.speed).slideDown(defaults.speedContent);
				} else {
					$content.slideDown(defaults.speedContent);
				}
				$floater.addClass('active');
			}
			
			function floatClose(){
				$content.slideUp(defaults.speedContent, function(){
					$floater.removeClass('active').dcFormReset();
				});
			}
			
			function floatObj(){
			
				var scroll = $(document).scrollTop();
				var moveTo = start + scroll;
				var h_b = $('body').height();
				var h_f = $floater.height();
				var h_c = $content.height();
				if (h_b < h_f + h_c){
					$floater.css("top",start);
				} else {
					$floater.stop().animate({top: moveTo}, defaults.speedFloat, defaults.easing);
				}
			}
			
			// Set up positioning
			function floaterSetup(obj){
				
				var location = defaults.location;
				var align = defaults.align;
				var offsetL = defaults.offsetLocation;
				var offsetA = defaults.offsetAlign;
				
				if(location == 'top'){
					$(obj).css({top: offsetL});
				} else {
					$(obj).css({bottom: offsetL});
				}
				
				if(align == 'left'){
					$(obj).css({left: offsetA});
				} else {
					$(obj).css({right: offsetA});
				}
			}	
			
		});
	};
})(jQuery);

// Form Reset
(function($){

	$.fn.dcFormReset = function(){
   
		return this.each(function(options){
		
			defaulttextFunction();
			$('li',this).removeClass('error');
			$('span.error',this).fadeOut().remove();
			if($('form',this).hasClass('dcscf-submit')){
				var $input = $('.text-input',this);
				var $textarea = $('.text-area',this);
				$('fieldset',this).show();
				$($input).each(function(){
					$(this).val('');
				});
				$textarea.val('');
				defaulttextFunction(this);
				$('.dcscf-submit',this).removeClass('dcscf-submit');
				$('.slick-response',this).text('').hide();
			}
				
	function defaulttextFunction(obj){
				var $defaultText = $(".defaultText",obj);
				$defaultText.focus(function(srcc) {
					if ($(this).val() == $(this)[0].title) {
						$(this).removeClass("defaultTextActive");
						$(this).val("");
					}
				});
				$defaultText.blur(function() {
					if ($(this).val() == "") {
						$(this).addClass("defaultTextActive");
						$(this).val($(this)[0].title);
					}
				});
				$defaultText.addClass("defaultTextActive").blur();
			}
  });
	};
})(jQuery);

/*
 * DC jQuery Slick Forms - jQuery Slick Forms
 * Copyright (c) 2011 Design Chemical
 * http://www.designchemical.com
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */

(function($){

	//define the plugin
	$.fn.dcSlickForms = function(options) {

		//set default options
		var defaults = {
			classError: 'error',
			classForm: 'slick-form',
			align: 'left',
			animateError: true,
			animateD: 10,
			ajaxSubmit: true
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		
		//act upon the element that is passed into the design    
		return this.each(function(options){
			
			// Declare the function variables:
			var formAction = $(this).attr('action');
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			var $error = $('<span class="error"></span>');
			var $formId = this;
			var $loading = $('<div class="loading">Processing ...</div>');
			var errorText = $('#v-error').val();
			var emailText = $('#v-email').val();
			
			defaulttextFunction(this);
			$('.'+defaults.classForm+' label').hide();
			
			// Form submit & Validation
			$(this).submit(function(){

				// Prepare the form for validation - remove previous errors
				formReset($formId);
				defaulttextRemove($formId);

				// Validate all inputs with the class "required"
				$('.required',$formId).each(function(){
					var label = $(this).attr('title');
					var inputVal = $(this).val();
					var $parentTag = $(this).parent();
					if(inputVal == ''){
						$parentTag.addClass('error').append($error.clone().text(errorText+' - '+label));
					}
			
					// Run the email validation using the regex for those input items also having class "email"
					if($(this).hasClass('email') == true){
						if(!emailReg.test(inputVal)){
							$parentTag.addClass('error').append($error.clone().text(emailText));
						}
					}
				});

				// All validation complete - Check if any errors exist
				// If has errors
				if ($('span.error',$formId).length > 0) {
			
					$('span.error',$formId).each(function(){
				
						if(defaults.animateError == true){
							// Get the error dimensions
							var width = $(this).outerWidth();
							// Calculate starting position
							var start = width + defaults.animateD;
						
						if(defaults.align == 'left'){
				
							// Set the initial CSS
							$(this).show().css({
								display: 'block',
								opacity: 0,
								right: -start+'px'
							})
							// Animate the error message
							.animate({
								right: -width+'px',
								opacity: 1
							}, 'slow');
							
						} else {
						
							// Set the initial CSS
							$(this).show().css({
								display: 'block',
								opacity: 0,
								left: -start+'px'
							})
							// Animate the error message
							.animate({
								left: -width+'px',
								opacity: 1
							}, 'slow');
						}
						}
				});
				} else {
					if(defaults.ajaxSubmit == true){
						var $response = $('.slick-response',this);
						$(this).addClass('dcscf-submit').prepend($loading.clone());
						defaulttextRemove($formId);
						$('fieldset',this).hide();
						$.post(formAction, $(this).serialize(),function(data){
							$('.loading').remove();
							$response.html(data).fadeIn();
						});
					} else {
						$(this).submit();
					}
				}
				// Prevent form submission
				return false;
			});
	
		// Fade out error message when input field gains focus
			$('input, textarea').focus(function(){
				var $parent = $(this).parent();
				$parent.addClass('focus');
				$parent.removeClass('error');
				
			});
			$('input, textarea').blur(function(){
				var $parent = $(this).parent();
				var checkVal = $(this).attr('title');
				if (!$(this).val() == checkVal){
					$(this).removeClass('defaulttextActive');
				}
				$parent.removeClass('error focus');
				$('span.error',$parent).hide();
			});
			
			function formReset(obj){
				$('li',obj).removeClass('error');
				$('span.error',obj).remove();
			}
			function defaulttextFunction(obj){
				var $defaultText = $(".defaultText",obj);
				$defaultText.focus(function(srcc) {
					if ($(this).val() == $(this)[0].title) {
						$(this).removeClass("defaultTextActive");
						$(this).val("");
					}
				});
				$defaultText.blur(function() {
					if ($(this).val() == "") {
						$(this).addClass("defaultTextActive");
						$(this).val($(this)[0].title);
					}
				});
				$defaultText.addClass("defaultTextActive").blur();
			}
			
			function defaulttextRemove(obj){
				$('.defaultText',obj).each(function(){
					var checkVal = $(this).attr('title');
					if ($(this).val() == checkVal){
						$(this).val('');
					}
				});
			}
			
		});
	};
})(jQuery);