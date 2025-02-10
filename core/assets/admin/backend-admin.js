jQuery(document).ready(function($) {

	// Progress status in post table
    jQuery('#the-list td.Progress').each(function() {

        jQuery(this).html('<div class="status-bar"><div></div></div>');

    });
	
	// Utilities
	$(document).on('click', '.js-toggle-slide-next', function(event) {

        event.preventDefault();

        $(this).next('div,li,ul').slideToggle();

    });
	
	// Hide notices
	$(document).on('click', '.js-ajax-notice button', function(event) {

        event.preventDefault();

        $(this).parent('.js-ajax-notice').fadeOut();

    });
	
	// Get table of contents
	$(document).on('click', '.js-toc', function(event) {

        event.preventDefault();

		// Var to store toc preview
		let tableOfContents = '';
		
		// Var to store toc text to be copied
		let copyText = '';
		
		// Get all h2 tags in Gutenberg editor
		$('.editor-styles-wrapper h2').each(function() {

			// Get text
			let text = $(this).html();
			
			// Sanitize text to build anchor (sometimes can be wrong)
			let anchor = text.replace(/\s+/g, '-');
			
			// Replace all 1), 2), 1., 2., etc.
			// https://ibnuhx.com/regex-generator/?ref=madewithvuejs.com
			text = text.replace(/[1-9][\)\.] /g,''); 
			// text = text.replace(/1\) |2\) |3\) |4\) |5\) |6\) |7\) |8\) |9\) |10\) /g,''); 
			// text = text.replace(/1\. |2\. |3\. |4\. |5\. |6\. |7\. |8\. |9\. |10\. /g,''); 

			// Create list item
			tableOfContents += '<li><a href="#' + anchor + '">' + text + '</a></li>';
			
			// Create link item
			copyText += '<a href="#' + anchor + '">' + text + '</a>\n';

		});
				
		// Create modal
		let tocModal = '<div class="mkcb-modal"><div class="mkcb-modal-content"><div class="js-copy-toc close"></div><h2>Table of contents</h2><ol style="margin-bottom: 1rem;">' + tableOfContents + '</ol><a class="js-copy-toc button-primary">Copy</a></div></div>'
		
		// Fade in alpha layer
		$('.dummy-layer').fadeIn();
		// Append modal
		$('.mkcb-modals').append(tocModal);
		// Show modal
		$('.mkcb-modals').find('.mkcb-modal').addClass('open');
		// Copy text in clipboard
		navigator.clipboard.writeText(copyText);
		
	});

	// Copy table of contents
	$(document).on('click', '.js-copy-toc, .dummy-layer', function(event) {

		event.preventDefault();
		// Just give the illusion of copying and close modal
		$('.mkcb-modals').find('.mkcb-modal').removeClass('open');
		$('.dummy-layer').fadeOut();

	});
	
});