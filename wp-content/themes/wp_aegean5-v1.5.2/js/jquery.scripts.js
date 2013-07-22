jQuery(window).load(function() {
	// Homepage Slider
	
	jQuery('#home-slider').flexslider({
		controlNav: false,
		start: function(slider){
			var src = slider.slides.eq(0).find('img').attr('alt');
			jQuery('.flex-captions p').text(src);
			jQuery('.flex-captions').fadeOut(0).fadeIn(0);
		},
		after: function(slider){
			var src = slider.slides.eq(slider.currentSlide).find('img').attr('alt');
			jQuery('.flex-captions p').text(src);
		}
	});
	
	jQuery('#home-slider .flex-direction-nav, #home-slider .flex-captions').wrapAll('<div class="flex-utils container" />');
	
	jQuery('#news-carousel').flexslider({
		animation: "slide",
		animationLoop: false,
		slideshow: false,
		itemWidth: 460,		
		controlNav: false,
		
	});

	jQuery('#room-carousel').flexslider({
		animation: "slide",
		animationLoop: false,
		slideshow: false,
		itemWidth: 223,		
		asNavFor: '#room-gallery'
	});
	
	jQuery('#room-gallery').flexslider({
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#room-carousel"
	});	
});

jQuery(document).ready(function($) {	
	//Submenu
	$('.nav').superfish({
        animation: {
            opacity: "show"
        },
        speed: "fast",
        delay: 250
    });    
    	
	//Datepickers
	$('.calendar').datepicker({dateFormat: 'yy/mm/dd'});
	
	// Responsive Menu
    // Create the dropdown base
    $("<select class='alt-nav' />").appendTo("#navigation");

    // Create default option "Go to..."
    $("<option />", {
       "selected": "selected",
       "value"   : "",
       "text"    : "Go to..."
    }).appendTo("#navigation select");

    // Populate dropdown with menu items
    $("#navigation a").each(function() {
     var el = jQuery(this);
     $("<option />", {
         "value"   : el.attr("href"),
         "text"    : el.text()
     }).appendTo("nav select");
    });

    $("#navigation select").change(function() {
      window.location = jQuery(this).find("option:selected").val();
    });
	
	// Weather
    var location = ThemeOption.weather_code; 
    var unit = ThemeOption.weather_unit;

    var wq = "SELECT * FROM weather.forecast WHERE location='" + location + "' AND u='" + unit + "'";
    var cb = Math.floor((new Date().getTime()) / 1200 / 1000);
    var wu = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent(wq) + '&format=json&_nocache=' + cb;

    window['ywcb'] = function(data) {
        var info = data.query.results.channel.item.condition;
        var city = data.query.results.channel.location.city;
        var country = data.query.results.channel.location.country;
        $('#ywloc').html(city + ", " + country);
        $('#ywtem').html(info.temp + '<span>' + '&deg;' + (unit.toUpperCase()) + '</span>');
    };

    $.ajax({
        url: wu,
        dataType: 'jsonp',
        cache: true,
        jsonpCallback: 'ywcb'
    });
    
	// Google Maps code
	if( $('#map').length > 0)
	{
		var firstLocation = new google.maps.LatLng(36.23,25.27);
		//center map to first event
		var myOptions = {
			zoom: 8,
			center: firstLocation,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			mapTypeControl: false
		};
		var map = new google.maps.Map(document.getElementById("map"), myOptions);
	} //end if( jQuery('.map').length > 0)
	
	//Fancybox
	if( $('.fb').length > 0) {
		$(".fb").fancybox({
			padding 	: 0,
			helpers	: {
				title	: {
					type: 'outside'
				},
				overlay	: {
					opacity : 0.8,
					css : {
						'background-color' : '#000'
					}
				},
				thumbs	: {
					width	: 50,
					height	: 50
				}
			},
			fitToView: true,
			nextEffect: 'fade',
			prevEffect: 'fade'
		});
	}
	
	//Block hover
	if( $('.block .fb').length > 0) {
	$(".block .fb").hover(
	  function () {
	  	var o = $(this).find('.overlay');
	  	o.fadeIn('fast');
	  },
	  function () {
	    $(this).find('.overlay').fadeOut('fast');
	  });	
	 }
	 
	 //Room hover
	if( $('.slides .fb').length > 0) {
	$(".slides .fb").hover(
	  function () {
	  	var o = $(this).find('.overlay2');
	  	o.fadeIn('fast');
	  },
	  function () {
	    $(this).find('.overlay2').fadeOut('fast');
	  });	
	 }


	$("select#room_select").dropkick({
		change: function(value, label) {
			$(this).change();
		}
	});

});
