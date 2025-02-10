<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The template for displaying the infowindows inside Google Maps.
 *
 * @param integer $post_id
 */
extract($args);

// Address
$address = get_field( 'address', $post_id );

// Bail out if no address
if( $address ) {
    return;
}

// Marker
$marker = get_field('google_maps_marker','options') ? get_field('google_maps_marker','options') : get_template_directory_uri() . '/core/assets/img/marker.png';

// Address data
$address_data = mkt_address_data($address);

?>
<div class="marker" data-geoicon="<?php echo $marker; ?>" data-lat="<?php echo esc_attr($address['lat']); ?>" data-lng="<?php echo esc_attr($address['lng']); ?>">
    <h4><?php echo get_the_title( $post_id ); ?></h4>
    <ul>
        <?php echo '<li>' . implode( '</li><li>', $address_data ) . '</li>'; ?>
    </ul>
</div>