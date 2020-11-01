$(window).on("load", function() {
	
	window.cookieconsent.initialise({
	  	"palette": {
	    	"popup": {
	      		"background": "#3c404d",
	      		"text": "white"
	    },
	    "button": {
	    	"background": "transparent",
	    	"text": "#26A69A",
	    	"border": "#26A69A"
	    }
  	},
  	"type": "opt-out",
  	"content": {
	  	"header": "Cookies used on the Website!",
	    "message": "This website uses cookies to ensure you get the best experience on our website!",
	    "dismiss": "Got It!",
	    "allow": "Allow Cookies",
	    "deny": "Decline",
	    "link": "Learn More",
	     "href": "dataprotection.php",
	    "target": "_blank"
  	}
});
	$(document).ready(function(){

		// Hamburger And Mobile Menu
	  	$hamburger = $('.hamburger');
	  	$mobileNavigation = $('.mobile-navigation');
	  	$header = $('header');
      	$hamburger.on('click', function(e) {

	        if ($hamburger.hasClass('is-active')) {
	         	$hamburger.toggleClass('is-active');
	      		$mobileNavigation.hide();
	      		$header.css({
	             	"height": "80px"
	          	});
	        } else {
	        	$hamburger.toggleClass('is-active');
	      		$mobileNavigation.show();
	      		$header.css({
	             	"height": "auto"
	          	});
	        }
      	});


	    // CarouselSlider
	    $carouselSlider = $('.carousel.carousel-slider');
	      $carouselSlider.carousel({
	      	fullWidth: true,
	          indicators: true
	    	});

	    // Carousel Autoplay
	    setInterval(function(){
	      $carouselSlider.carousel('next');
	    }, 6000);

	    // ArrowPrev
	    $arrowPrev = $('.prev');
	      $arrowPrev.on('click', function(e) {
	      	$carouselSlider.carousel('prev');
	    });

	    // ArrowNext
	    $arrowNext = $('.next');
	    	$arrowNext.on('click', function(e) {
	      	$carouselSlider.carousel('next');
	    });

		// FAQ Aus- und Einfahren
	    $collapheader = $('div.collapsible-header');
	    $colapsible = $('.collapsible');
	    $collapslist = $colapsible.find('li');
	    $materialicon = $colapsible.find('.material-icons');

	    // Faq Aus und Einklappen
    	$collapheader.on('click', function(evt) {
		    $colapsible.collapsible();
		    $e = $(evt.currentTarget);

		    $materialicon.html('&plus;');

		    $collapslist.css({
		          "marginRight": "50px",
		          "marginLeft": "50px"
		      });

		    if ($e.parent().hasClass('active')) {
		      $e.children().children().html('&plus;');
		      $e.parent().css({
		          "marginRight": "50px",
		          "marginLeft": "50px"
		      });
		    } else {
		      $e.children().children().html('&minus;');
		      $e.parent().css({
		          "marginRight": "50px",
		          "marginLeft": "50px"
		      });
		    }
	    });

    	// Extra Menu Ein und AUsklappen
    	$btnMenuFirst = $('.btnMenuFirst');
    	$btnMenuSecond = $('.btnMenuSecond');
    	$btnMenuThree = $('.btnMenuThree');

    	$btnMenuThree.fadeOut();
    	$btnMenuSecond.fadeOut();

    	$btnMenuFirst.click(function(evt) {
    		$btnMenuSecond.fadeIn(600);
    		$btnMenuThree.fadeIn(600);
    		$btnMenuSecond.delay(3500).fadeOut(600);
    		$btnMenuThree.delay(3500).fadeOut(600);
    	});






      	console.log("Document Ready");
    });
    console.log("Window Loaded");
});