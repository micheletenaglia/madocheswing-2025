(function($) {

	// Map
	function new_map( $el ) {
        // Vars
		var $markers = $el.find('.marker');
		var args = {
			zoom				:	14,
			center				:	new google.maps.LatLng(0,0),
			mapTypeId			:	google.maps.MapTypeId.ROADMAP,
			zoomControl			:	true,
			mapTypeControl		:	false,
			scaleControl		:	true,
			streetViewControl	:	false,
			rotateControl		:	false,
			fullscreenControl	:	false,
			styles: mapStyle
		};
		var map = new google.maps.Map( $el[0], args);
		map.markers = [];
		$markers.each(function(){		
			add_marker( $(this), map );
		});
		center_map( map );
		return map;
	}

    // Default infowindows 
    var infowindows = [];
	// Add markers
	function add_marker( $marker, map ) {
        // Vars
		var icon = $marker.attr('data-geoicon');
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			icon 		: icon
		});
		map.markers.push( marker );
		// if marker contains HTML, add it to an infoWindow
		if( $marker.html() ) {
			// Create info window
			var infowindow = new google.maps.InfoWindow({
				content : $marker.html(),
				maxWidth : 300,
			});
            // Push infowindow
			infowindows.push(infowindow);
            // On click
			google.maps.event.addListener(marker, 'click', function() {
            	// Close all
            	for (var i = 0; i < infowindows.length; i++) {
                	infowindows[i].close();
            	}
            	infowindow.open( map, marker );
       		});
            // Related element outside of the map
			liTag = $("body").find("[data-lat='" + $marker.attr('data-lat') + "'] .map-button");
			// Close on click
			$("body .map-button").click(function() {
				infowindow.close();
			});
            // Set content and open on click
			$(liTag).click(function() {
				infowindow.setContent($marker.html());
				infowindow.open(map, marker);
			});
            // Add class to element
	        // google.maps.event.addDomListener(marker, "click", () => {
            map.addListener(marker, "click", () => {
	        	$("body").find("[data-lat='" + $marker.attr('data-lat') + "'] .map-button").addClass('open');
	        });
			// Close info window when map is clicked
			google.maps.event.addListener(map, 'click', function(event) {
				if(infowindow) {
					infowindow.close();
				}
			});
		} // End if marker
	} // End add marker

	// Center map
	function center_map( map ) {
        // Get bounds
		var bounds = new google.maps.LatLngBounds();
		// Loop markers
		$.each( map.markers, function( i, marker ){
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		});
        // Handle one or multiple markers map center
		if( map.markers.length == 1 ) {
			map.setCenter( bounds.getCenter() );
			map.setZoom( 14 );
		} else {
			map.fitBounds( bounds );
		}
	}

    // Map
	var map = null;
    // Create map
	// $(document).ready(function(){
		$('.acf-map').each(function(){
			map = new_map( $(this) );
		});
        // Show map and delete loader
		google.maps.event.addListenerOnce(map, 'tilesloaded', function(){
			$('.marker').css('display','block');
			$('.map-loader').addClass('loaded');
			$('.map-wrap').removeClass('loading');
		});
	// });

})(jQuery);