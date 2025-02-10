<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The template for displaying the Google Map.
 *
 * @param array $locations
 * @param string $wrap_style
 * @param string $map_style
 */
extract($args);

// Bail out if no locations
if( !$locations ) {
	return;
}

?>
<div class="map-wrap loading <?php echo esc_attr($wrap_style); ?>">
	<div class="map-loader">
		<div class="map-loader-bar">
		</div>
	</div>
	<div class="acf-map <?php echo esc_attr($map_style); ?>" data-zoom="16">
		<?php foreach( $locations as $location ) {
				// Get template
				mkt_get_template(
					'map/map-card', 
					[
						'post_id' => $location, 
					]
				); 
			}
		?>
	</div>
</div>