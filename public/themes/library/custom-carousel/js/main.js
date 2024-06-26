(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	var carousel = function() {
		$('.featured-carousel').owlCarousel({
	    loop:false,
	    autoplay: true,
	    margin:30,
	    animateOut: 'fadeOut',
	    animateIn: 'fadeIn',
	    nav:true,
	    dots: true,
	    autoplayHoverPause: false,
	    items: 1,
	    navText : ["<span class='text-dark ion-ios-arrow-forward'></span>","<span class='ion-ios-arrow-back text-dark'></span>"],
	    responsive:{
	      0:{
	        items:1
	      },
		  500:{
	        items:2
	      },
		  700:{
	        items:3
	      },
		  900:{
	        items:3
	      },
		  1000:{
	        items:5
	      },
	      1100:{
	        items:5
	      },
		  1500:{
	        items:5
	      }
	    }
		});

	};
	carousel();

})(jQuery);
