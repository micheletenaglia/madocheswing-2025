$(document).ready(function() {

	// Menu mobile
	/*
	$('#nav-mt-icon,#mt-close-menu,#menu-overlay li a').click(function(){
		$('#nav-mt-icon,.mt-slide-menu').toggleClass('open');
	});*/
/*	$(document).on("click","#nav-mt-icon,#mt-close-menu,#menu-overlay li a", function () {
		$('#nav-mt-icon,.mt-slide-menu').toggleClass('open');
	});
*/

		$( "#nav-mt-icon,#mt-close-menu,.mt-nav-mobile a" ).on( "click", function() {
			$('#nav-mt-icon,.mt-slide-menu').toggleClass('open');
		});

	// Search overlay
	$('.mt-search-trigger').click(function(){
		$('.mt-search-overlay-wrapper').fadeToggle('slow');
	});

	// Hide menu on scroll
    var c, currentScrollTop = 0,
    navbar = $('header.mt-header');

    $(window).scroll(function () {
        var a = $(window).scrollTop();
        var b = navbar.height();
     
        currentScrollTop = a;
     
        if (c < currentScrollTop && a > b + b) {
            navbar.addClass("scrollup");
            navbar.removeClass("scrolldown");
            navbar.removeClass("scrollstart");
        }else if(c > currentScrollTop && !(a <= b)) {
            navbar.removeClass("scrollup");
            navbar.addClass("scrolldown");
            navbar.removeClass("scrollstart");
        }else if(a == 0 ) {
            navbar.removeClass("scrolldown");
            navbar.addClass("scrollstart");
        }
        c = currentScrollTop;
    });

	// Menu sticky
	var header = $(".mt-sticky");
	$(window).scroll(function() {
	    var scroll = $(window).scrollTop();
	    if (scroll >= 150) {
	        header.addClass('scrolled');
		} else {
	        header.removeClass('scrolled');
	    }
	});

	// Scroll top
	var top_btn = $(".mt-scroll-top");
	$(window).scroll(function() {
	    var scroll = $(window).scrollTop();
	    if (scroll >= 150) {
	        top_btn.addClass('scrolled');
	    } else {
	        top_btn.removeClass('scrolled');
	    }
	});

	// Smooth anchor
	$("a").on('click', function(event) {
		if (this.hash !== "") {
	      	event.preventDefault();
	    	var hash = this.hash;
	  		$('html, body').animate({
	        	scrollTop: $(hash).offset().top
	      	}, 800, function(){
	    	window.location.hash = hash;
	  		});
	    }
	});

	// Validate
	/*$(document).ready(function() {
		$('form.mt-form').simpleValidate({
			errorElement: 'em',
		});
	});*/

	// Iframe
    $('.mt-content iframe[src*="youtube.com"]').wrap( "<div class='mt-embed-container'></div>" );
    $('.mt-content iframe[src*="vimeo.com"]').wrap( "<div class='mt-embed-container'></div>" );

});


document.addEventListener('swup:animationInDone', function () {
	//$(document).ready(function() {
		// Menu mobile
		/*$( "#nav-mt-icon,#mt-close-menu,#menu-overlay li a" ).on( "click", function() {
			$('#nav-mt-icon,.mt-slide-menu').toggleClass('open');
		});*/

		/*$(document).on("click","#nav-mt-icon,#mt-close-menu,#menu-overlay li a", function () {
			$('#nav-mt-icon,.mt-slide-menu').toggleClass('open');
		});*/
		
		/*var menu = document.querySelectorAll('#nav-mt-icon,#mt-close-menu,#menu-overlay li a');
		menu.classList.toggle('#nav-mt-icon,.mt-slide-menu');*/
		
	//});
});
    document.addEventListener('swup:contentReplaced', function () {
		$( "#nav-mt-icon,#mt-close-menu,#menu-overlay li a" ).on( "click", function() {
			$('#nav-mt-icon,.mt-slide-menu').toggleClass('open');
		});
    });

