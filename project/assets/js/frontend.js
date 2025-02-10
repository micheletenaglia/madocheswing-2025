jQuery(document).ready(function($) {


	//======================================================================
	// Numbers
	//======================================================================
	var numbers = [];
	for (var i = 1; i <= 40; i++) {
		numbers.push(i);
	}

	//======================================================================
	// Viewport check
	//======================================================================
    $.fn.isInViewport = function() {
		
		var elementTop = $(this).offset().top;
		var elementBottom = elementTop + $(this).outerHeight();

		var viewportTop = $(window).scrollTop();
		var viewportBottom = viewportTop + $(window).height();

		return elementBottom > viewportTop && elementTop < viewportBottom;
		
	};
    /*
    function isInViewport(entries) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    console.log('Yes');
                    return true;
                } else {
                    console.log('No');
                    return false;
                }    
            })
        });
    }*/

	$(document).on('click', '.js-menu-mobile-toggle', function(event) {
		
        event.preventDefault();
		const menuMobileDefault = document.querySelectorAll('div.menu-mobile-default').length > 0;

		if( menuMobileDefault ) {
						
			var layer = '<div id="menu-mobile-layer" class="js-menu-mobile-toggle" style="position: fixed; z-index: 30; left:0; top: 0; width: 10%; height: 100%; background-color: rgba(0,0,0,.5); cursor: pointer; display: none;"></div>';
			
			if( $('.js-menu-mobile').hasClass('open') ) {
				
				$('#menu-mobile-layer').fadeOut( function() {
					
					$('#menu-mobile-layer').remove();
				
				});
				
			}else{
				
				$('body').append(layer);
				setTimeout(function(){ 
					$('body').find('#menu-mobile-layer').fadeIn();
				}, 200);
				
			}
			
		}
	
		$('.js-menu-mobile').toggleClass('open');
		
	});

	$.each(numbers, function(i) {

		$('.tab-button-' + i).click(function() {

			var tabsWrap = $(this).closest('.tabs-wrap');
			
			// Reset all
			$(tabsWrap).find('.tab').removeClass('open');
			$(tabsWrap).find('.tab-button').removeClass('open');

			// Set open class to selected
			$(tabsWrap).find('.tab-' + i).addClass('open');
			$(this).addClass('open');
			
		});

	});

	//======================================================================
	// Redirect to URL on select change
	//======================================================================

	$(document).on('change', '.js-select-redirect', function() {

		var url = $(this).val();
		if( url ) {
			window.location = url;
		}
		
		return false;
	
	});

	// Responsive iframe
	$('.content iframe[src*="youtube.com"]').wrap( "<div class='oembed'></div>" );
	$('.content iframe[src*="vimeo.com"]').wrap( "<div class='oembed'></div>" );

	// https://contactform7.com/dom-events/
	// Contact Form 7 modal
	$(document).on('click', '.js-cf7-modal-form', function() {

		const modalFormId = $(this).data('form');
		const modalForm = $('[data-form-id="' + modalFormId + '"].cf7-modal-form');
		const modalLayer = $('[data-form-id="' + modalFormId + '"].cf7-modal-form-layer');
		
		if( $(modalForm).hasClass('open') ) {
			$(this).closest('.mkcf-block').css('z-index','auto');
		}else{
			$(this).closest('.mkcf-block').css('z-index','48');			
		}

		$(modalForm).toggleClass('open');
		$(modalLayer).fadeToggle();
		$('.wpcf7-response-output').addClass('mkcf-cf7-modal-in-modal');
		
	});

	// Contact Form 7 on submit
	$(document).on('click', '.wpcf7-submit', function() {

		var loader = '<div id="mkcf-cf-7-loader" class="ajax-loader loading"><div class="lds-ring"><div></div><div></div><div></div></div></div>';

		$(this).closest('.wpcf7').append(loader);

	});

	// On error
	document.addEventListener( 'wpcf7invalid', function( event ) {
		$('.wpcf7').find('#mkcf-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('mkcf-cf7-modal mkcf-cf7-verify');
	}, false );

	// On fail
	document.addEventListener( 'wpcf7mailfailed', function( event ) {
		$('.wpcf7').find('#mkcf-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('mkcf-cf7-modal mkcf-cf7-verify');
	}, false );

	// On spam
	document.addEventListener( 'wpcf7spam', function( event ) {
		$('.wpcf7').find('#mkcf-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('mkcf-cf7-modal mkcf-cf7-verify');
	}, false );

	// On success
	document.addEventListener( 'wpcf7mailsent', function( event ) {
		$('.wpcf7').find('#mkcf-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('mkcf-cf7-modal').removeClass('mkcf-cf7-verify');
	}, false );

	// Dismiss modal
	$(document).on('click', '.mkcf-cf7-modal', function() {
		$('.wpcf7-response-output').removeClass('mkcf-cf7-modal').empty();
		if( $('.wpcf7-response-output').hasClass('mkcf-cf7-modal-in-modal') && !$(this).hasClass('mkcf-cf7-verify') ) {
			$(this).closest('.mkcf-block').css('z-index','auto');
			$('.cf7-modal-form').removeClass('open');
			$('.cf7-modal-form-layer').fadeOut();
		}
	});

	/* Multistep form
	 *
	 */

	// Get multistep form
	const multiStep = $('.multistep-form');

	// If multistep form exists
	// Build multistep form navigation bar
	if( $(multiStep).length ) {
		
		// Count screens	
		const multiStepScreens = $(multiStep).find('.multistep-screen').length;
		// Start building the navigation bar
		var multiStepBar = '<div class="multistep-form-bar">';
		// Loop and add a number for each screen
		for( let i = 0; i < multiStepScreens; i++ ) {
			// If is first screen add active class
			if( i == 0 ) {
				multiStepBar += '<div class="multistep-number active">' + (i+1) + '</div>';
			}else{
				multiStepBar += '<div class="multistep-number">' + (i+1) + '</div>';
			}
		}
		// Close div of navigation bar
		multiStepBar += '</div>';
		// Append navigation bar to main div
		$(multiStep).prepend(multiStepBar);

	}
	
	// Next screen button
	$(document).on('click', '.js-multistep-next', function() {

		// Get current screen
		let currentScreen = $(this).closest('.multistep-screen');
		// Get next screen
		let nextScreen = $(currentScreen).next('.multistep-screen');
		// Get next screen index
		let number = $(nextScreen).data('step');
		// Get current screen radio input
		let radio = $(currentScreen).find('input[type="radio"]');
		// Error message
		const error = '<div class="multistep-error font-bold text-error">Scegli un\'opzione!</div>';

		if( $(radio).length ) {
			
			if( $(radio).is(':checked') ) {
				$('.multistep-error').remove();
				$(currentScreen).addClass('left-out').removeClass('current');
				$(nextScreen).removeClass('right-out').addClass('current');
				// Update navigation bar
				multistep_loading_bar( number );
			}else{
				$('.multistep-error').remove();
				$(currentScreen).find('.wpcf7-form-control-wrap').append(error);
			}	
			
		}else{
			$(currentScreen).addClass('left-out').removeClass('current');
			$(nextScreen).removeClass('right-out').addClass('current');
			// Update navigation bar
			multistep_loading_bar( number );			
		}
		
	});

	// On input change go to next screen
	$(document).on('change', '.multistep-form input[type="radio"], .multistep-form textarea', function() {

		// Get current screen
		let currentScreen = $(this).closest('.multistep-screen');
		// Get next screen
		let nextScreen = $(currentScreen).next('.multistep-screen');
		// Get next screen index
		let number = $(nextScreen).data('step');

		// Remove error (if any)
		$('.multistep-error').remove();
		// Slide out current
		$(currentScreen).addClass('left-out').removeClass('current');
		// Slide in next screen
		$(nextScreen).removeClass('right-out').addClass('current');
		// Update navigation bar
		multistep_loading_bar( number );	
		
	});

	// Previous screen button
	$(document).on('click', '.js-multistep-prev', function() {

		// Get current screen
		var currentScreen = $(this).closest('.multistep-screen');
		// Get previous screen
		let prevScreen = $(currentScreen).prev('.multistep-screen');
		// Get previous screen index
		let number = $(prevScreen).data('step');

		// Slide out current screen
		$(currentScreen).addClass('right-out').removeClass('current');
		// Slide in previous screen
		$(prevScreen).removeClass('left-out').addClass('current');
		// Update navigation bar
		multistep_loading_bar( number );

	});

    // Get input value and add as HTML in related "data-js-name"
    $(document).on('input', '.wpcf7 input', function(event) {

        var thisData = $(this).attr('name');
        var thisVal = $(this).val();
        var otherData = $(this).closest('.wpcf7').find('[data-js-name="' + thisData + '"]');

        if( otherData.length ) {
            $(otherData).html(thisVal);
        }

    });

	/* Get current screen and add "active" class
	 * to all navigation bar element with a value 
	 * less or equal to current screen.
	 *
	 */
	function multistep_loading_bar( number ) {
		
		// Get the numbers elements in navigation bar
		const loadingBar = $('.multistep-form-bar .multistep-number');
		
		// Loop each number
		$(loadingBar).each(function( index ) {
			if( $(this).text() <= number ) {
				// If current screen value is less or equal to current number
				// add "active" class
				$(this).addClass('active');
			}else{
				// Else remove "active" class
				$(this).removeClass('active');
			}
		});

	}

	//======================================================================
	// Get map script
	// If any '.acf-map' in DOM, get relative JS files
    // !!! There is a new native way by Google to do this
	//======================================================================
	// Get map
	let mapCheck = $('.acf-map');
    // const mapCheck = document.getElementsByClassName('acf-map');
	// If map
	if( mapCheck.length ) {
        // Load variable
		let googleMapLoaded = false;
		// On resize and scroll
        window.addEventListener('scroll', function() {
		// $(window).on('resize scroll', function() {
			// If map is not loaded and is in viewport
			if( googleMapLoaded == false && $(mapCheck).isInViewport() ) {
				// Get Google Maps JS
				$.getScript( mapKeyUrl, function() {
					// After get map JS
					$.getScript( mapUrl );
				});
                // Update value
				googleMapLoaded = true;
			}
		});
	}

	// Hide menu on scroll
	var c, currentScrollTop = 0,
	navbar = $('.desktop-nav');

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

});

