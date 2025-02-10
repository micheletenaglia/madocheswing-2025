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
			$(this).closest('.hap-block').css('z-index','auto');
		}else{
			$(this).closest('.hap-block').css('z-index','48');			
		}

		$(modalForm).toggleClass('open');
		$(modalLayer).fadeToggle();
		$('.wpcf7-response-output').addClass('hap-cf7-modal-in-modal');
		
	});

	// Contact Form 7 on submit
	$(document).on('click', '.wpcf7-submit', function() {

		var loader = '<div id="hap-cf-7-loader" class="ajax-loader loading"><div class="lds-ring"><div></div><div></div><div></div></div></div>';

		$(this).closest('.wpcf7').append(loader);

	});

	// On error
	document.addEventListener( 'wpcf7invalid', function( event ) {
		$('.wpcf7').find('#hap-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('hap-cf7-modal hap-cf7-verify');
	}, false );

	// On fail
	document.addEventListener( 'wpcf7mailfailed', function( event ) {
		$('.wpcf7').find('#hap-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('hap-cf7-modal hap-cf7-verify');
	}, false );

	// On spam
	document.addEventListener( 'wpcf7spam', function( event ) {
		$('.wpcf7').find('#hap-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('hap-cf7-modal hap-cf7-verify');
	}, false );

	// On success
	document.addEventListener( 'wpcf7mailsent', function( event ) {
		$('.wpcf7').find('#hap-cf-7-loader').remove();
		$('.wpcf7-response-output').addClass('hap-cf7-modal').removeClass('hap-cf7-verify');
	}, false );

	// Dismiss modal
	$(document).on('click', '.hap-cf7-modal', function() {
		$('.wpcf7-response-output').removeClass('hap-cf7-modal').empty();
		if( $('.wpcf7-response-output').hasClass('hap-cf7-modal-in-modal') && !$(this).hasClass('hap-cf7-verify') ) {
			$(this).closest('.hap-block').css('z-index','auto');
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

/**
 * Get data for Whatsapp button.
 * 
 */

// Default value
var whatsappMsg = '';

// Whatsapp message
$(document).on('change', '.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea', function() {
    // Default URL
    var wTel = $('.js-whatsapp-button').data('tel');
    const inputs = {};
    // Count required inputs
    var requiredInputs = 0; 
    // Handle multiple choices repeating names
    var repeatingNames = [];
    // Count required inputs
    $('.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea').each(function() {
        // Name
        const inputName = $(this).attr('name');
        const inputType = $(this).attr('type');
        if( 
            $(this).attr('type') == 'hidden'
            || inputType == 'submit'
            || inputType == 'button'
            || repeatingNames.includes(inputName)
        ) {
            return; // Continue doesn't work with each
        }
        if(
            $(this).prop('required')
            || $(this).attr('aria-required') == 'true' // Fix for CF7
            || $(this).hasClass('wpcf7-validates-as-required') // Fix for CF7
            || $(this).closest('.wpcf7-form-control-wrap').find('.wpcf7-validates-as-required').length // Fix for CF7
            || inputType == 'radio' // Fix for CF7
            || inputName == 'gdpr' // Fix for CF7
        ){
            // Increment required inputs count
            requiredInputs++;
            // Push attr name into array
            repeatingNames.push(inputName); 
        }
    });
    // Populate variable
    $('.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea').each(function() {
        const inputType = $(this).attr('type');
        if( 
            inputType != 'hidden'
            && inputType != 'submit'
            && inputType != 'button'
        ) {
            // Name
            const inputName = $(this).attr('name');
            // Label
            const inputLabel = $('label[for="' + inputName + '"]').html();
            // Value
            var inputValue = $(this).val();
            // Handle required inputs
            var inputRequired = 0;
            if( 
                $(this).prop('required')
                || $(this).attr('aria-required') == 'true' // Fix for CF7
                || inputName == 'gdpr' // Fix for CF7
            ){
                inputRequired = 1;
            }
            // Handle radios and gdpr (Fix for CF7)
            if( $(this).is(':radio') || inputName == 'gdpr' ) {
                inputValue = $('input[name="' + inputName + '"]:checked').val();
            }else if( $(this).is(':checkbox') && inputName != 'gdpr' ) {
                // Temporary array
                var tempValue = [];
                // Pusch checked values into array
                $('input[name="' + inputName + '"]:checked').each(function() {
                    tempValue.push($(this).val()); 
                });
                // Array to string
                inputValue = tempValue.toString();
            }else if( $(this).is('select') ) {
                inputValue = $('input[name="' + inputName + '"]:selected').val();
            }else if( $(this).is('textarea') ) {
                // Nothing
            }
            inputs[inputName] = {
                'label'     :   inputLabel,
                'value'     :   inputValue,
                'required'  :   inputRequired,
            };
        }
    });
    // Count elements in inputs object
    const countInputs = Object.keys(inputs);
    // Validate Whatsapp message
    var dataCheck = 0;
    // Message
    whatsappMsg = 'Ciao, vorrei informazioni sui corsi. Ecco i miei dati:' + '\n';
    // Loop and populate message
    for( const [key, values] of Object.entries(inputs)) {
        if( values.value != '' ) {
            if( key == 'gdpr' ) {
                // Handle GDPR
                if( values.value > 0 ) {
                    whatsappMsg += 'GDPR: Autorizzo il trattamento dei miei dati personali ai sensi dell’art. 13 Dlgs 196 del 30 giugno 2003 e dell’art. 13 GDPR (Regolamento UE 2016/679).' + '\n';
                    whatsappMsg += privacyUrl; // From PHP
                    // Increment check value
                    dataCheck++;
                }
            }else if( Array.isArray(values.value) ) {
                // Handle arrays
                whatsappMsg += values.label + ': ' + values.value.toString() + '\n';
                // Increment check value
                dataCheck++;
            }else{
                whatsappMsg += values.label + ': ' + values.value + '\n';
                if( key != 'notes' ) {
                    // Increment check value of not required values
                    dataCheck++;
                }
            }
        }
    }
    // Encode message
    whatsappMsg = encodeURIComponent(whatsappMsg);
    // Update URL
    newUrl = 'https://wa.me/' + wTel + '/?text=' + whatsappMsg;
    // Update href
    $('.js-whatsapp-button').attr('href',newUrl);
    // Check if all required inputs have been filled in
    // We add 1 because "notes" is not a required input
    if( (dataCheck + 1) == countInputs.length ) {
        $('.js-whatsapp-button').removeClass('disabled');
    }else{
        $('.js-whatsapp-button').addClass('disabled');
    }
});

// Prevent Whatsapp button link if not enough data
$(document).on('click', '.button.disabled', function(event) {
    event.preventDefault();
});

/**
 * Example of CF7 HTML markup
 * 
<div class="js-whatsapp grid-1">
    <div class="col-span-1-2 grid-1-2">
        <div class="">
            <label for="f_name" class="required-input">Nome</label>
            [text* f_name autocomplete:given-name placeholder "Nome"]
        </div>
        <div class="">
            <label for="l_name" class="required-input">Cognome</label>
            [text* l_name autocomplete:family-name placeholder "Cognome"]
        </div>
        <div class="">
            <label for="phone" class="required-input">Telefono</label>
            [text* phone autocomplete:tel placeholder "Telefono"]
        </div>
        <div>
            <label for="email" class="required-input">Email</label>
            [email* email autocomplete:email placeholder "Email"]
        </div>
    </div>
    <div class="col-span-1-2 grid-1-2-4">
        <div>
            <label for="dance_classes[]" class="required-input">Corsi</label>
            [checkbox* dance_classes use_label_element data:dance_classes]
        </div>
        <div>
            <label for="bundle" class="required-input">Pacchetto</label>
            [radio bundle use_label_element default:1 "Trimestrale" "Mensile" "Lezione di prova"]
        </div>
        <div>
            <label for="roles[]" class="required-input">Ruolo</label>
            [checkbox* roles use_label_element "Solo" "Follower" "Leader"]
        </div>
        <div>
            <label for="sex" class="required-input">Sesso</label>
            [radio sex use_label_element default:1 "Donna" "Uomo" "Altro"]
        </div>
    </div>
    <div class="col-span-1-2">
        <label for="notes">Note</label>
        [textarea notes x2 placeholder "Aggiungi una nota"]
    </div>
    <div class="flex justify-between">
        <div>
            <label for="gdpr" style="display: none;">GDPR</label>
            [acceptance gdpr] Autorizzo il trattamento dei miei dati personali ai sensi dell’art. 13 Dlgs 196 del 30 giugno 2003 e dell’art. 13 GDPR (Regolamento UE 2016/679). <a href="http://localhost:8888/mcs/privacy-policy/" target="_blank" rel="noopener">Informativa privacy</a> [/acceptance]
        </div>
        <div>
            <a class="button js-whatsapp-button w-full disabled" target="_blank" rel="noopener" data-tel="393514150480" href="https:wa.me/393514150480">Whatsapp</a>
            [submit class:w-full "Invia email"]
        </div>
    </div>
</div>
*/

// Backup of Whatsapp message
/*
$(document).on('change', '.js-whatsapp input, .js-whatsapp select, .js-whatsapp textarea', function() {
    // Default URL
    var wTel = $('.js-whatsapp-button').data('tel');
    // Inputs
    var inputs = {
        'f_name' : {
            'value' :   $('.js-whatsapp [name="f_name"]').val(),
            'label' :   $('label[for="f_name"]').html(),
        },
        'l_name' : {
            'value' :   $('.js-whatsapp [name="l_name"]').val(),
            'label' :   $('label[for="l_name"]').html(),
        },
        'phone' : {
            'value' :   $('.js-whatsapp [name="phone"]').val(),
            'label' :   $('label[for="phone"]').html(),
        },
        'email' : {
            'value' :   $('.js-whatsapp [name="email"]').val(),
            'label' :   $('label[for="email"]').html(),
        },
        'bundle' : {
            'value' :   $('.js-whatsapp [name="bundle"]:checked').val(),
            'label' :   $('label[for="bundle"]').html(),
        },
        'roles' : {
            'value' :   [],
            'label' :   $('label[for="roles[]"]').html(),
        },
        'dance_classes' : {
            'value' :   [],
            'label' :   $('label[for="dance_classes[]"]').html(),
        },
        'sex' : {
            'value' :   $('.js-whatsapp [name="sex"]:checked').val(),
            'label' :   $('label[for="sex"]').html(),
        },
        'notes' : {
            'value' :   $('.js-whatsapp [name="notes"]').val(),
            'label' :   $('label[for="notes"]').html(),
        },
        'gdpr' : {
            'value' :   $('.js-whatsapp [name="gdpr"]:checked').val(),
            'label' :   $('label[for="gdpr"]').html(),
        }
    };
    // Handle multiple choices
    $('.js-whatsapp [name="dance_classes[]"]:checked').each(function() {
        inputs.dance_classes.value.push($(this).val()); 
    });
    $('.js-whatsapp [name="roles[]"]:checked').each(function() {
        inputs.roles.value.push($(this).val()); 
    });
    // Count elements in inputs object
    const countInputs = Object.keys(inputs);
    // Validate Whatsapp message
    var dataCheck = 0;
    // Message
    whatsappMsg = 'Ciao, vorrei informazioni sui corsi. Ecco i miei dati:' + '\n';
    // Loop and populate message
    for( const [key, values] of Object.entries(inputs)) {
        if( values.value != '' ) {
            if( key == 'gdpr' ) {
                // Handle GDPR
                if( values.value > 0 ) {
                    whatsappMsg += 'GDPR: Autorizzo il trattamento dei miei dati personali ai sensi dell’art. 13 Dlgs 196 del 30 giugno 2003 e dell’art. 13 GDPR (Regolamento UE 2016/679).' + '\n';
                    whatsappMsg += 'http://localhost:8888/mcs/privacy-policy/'; // !!! Fare con PHP
                    // Increment check value
                    dataCheck++;
                }
            }else if( Array.isArray(values.value) ) {
                // Handle arrays
                whatsappMsg += values.label + ': ' + values.value.toString() + '\n';
                // Increment check value
                dataCheck++;
            }else{
                whatsappMsg += values.label + ': ' + values.value + '\n';
                if( key != 'notes' ) {
                    // Increment check value of not required values
                    dataCheck++;
                }
            }
        }
    }
    // Encode message
    whatsappMsg = encodeURIComponent(whatsappMsg);
    // Update URL
    newUrl = 'https://wa.me/' + wTel + '/?text=' + whatsappMsg;
    // Update href
    $('.js-whatsapp-button').attr('href',newUrl);
    // Check if all required inputs have been filled in
    // We add 1 because "notes" is not a required input
    if( (dataCheck + 1) == countInputs.length ) {
        $('.js-whatsapp-button').removeClass('disabled');
    }else{
        $('.js-whatsapp-button').addClass('disabled');
    }
});
*/