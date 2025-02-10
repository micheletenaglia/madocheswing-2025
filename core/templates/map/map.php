<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The template for displaying the Google Map.
 *
 * Do not edit directly!
 * If you need to change this file copy 
 * and paste it in project/templates/map/.
 * 
 * @since Hap Studio 1.0.0
 */

// Extract variables from $args array passed by hap_get_template function
extract( $args );
// $locations
// $wrap_style
// $map_style

if ( $locations ) : ?>

	<div class="map-wrap loading <?php echo $wrap_style; ?>">

		<div class="map-loader">
			<div class="map-loader-bar">
			</div>
		</div>

		<div class="acf-map <?php echo $map_style; ?>" data-zoom="16">
			<?php 
			
				foreach( $locations as $location ) {
					
					// Args for map-card
					$args = [ 
						'post_id'	=> $location, 
					];
				
					hap_get_template( 'map/map-card', $args ); 
			
				}
			?>
		</div>

	</div>

<?php endif;