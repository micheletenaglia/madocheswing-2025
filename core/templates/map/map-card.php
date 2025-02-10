<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The template for displaying the infowindows inside Google Maps.
 *
 * Do not edit directly!
 * If you need to change this file copy 
 * and paste it in project/templates/map/.
 * 
 * @since Hap Studio 1.0.0
 */

// Extract variables from $args array passed by hap_get_template function
extract( $args );
// $post_id

$address = get_field( 'address', $post_id );
$marker = ( get_field('google_maps_marker','options') ) ? get_field('google_maps_marker','options') : HAP_CORE_IMG_URI . 'marker.png';
$address_data = hap_address_data($address);

if( $address ) : ?>

	<div class="marker" data-geoicon="<?php echo $marker; ?>" data-lat="<?php echo esc_attr($address['lat']); ?>" data-lng="<?php echo esc_attr($address['lng']); ?>">

		<h4><?php echo get_the_title( $post_id ); ?></h4>
		<?php echo '<ul><li>' . implode( '</li><li>', $address_data ) . '</li></ul>'; ?>

	</div>

<?php endif;