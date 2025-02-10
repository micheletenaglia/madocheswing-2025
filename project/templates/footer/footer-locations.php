<?php
    
/**
 * List of locations in footer.
 * 
 */

 // Get locations
 $locations = get_posts([
    'post_type'     =>  'location',
    'numberposts'   =>  -1,
    'post_status'   =>  'publish',
    'order'         =>  'DESC',
    'orderby'       =>  'meta_value',
    'meta_key'      =>  'type',
 ]);

 // If any result
 if( $locations ) :
    ?>
    <ul>
        <?php foreach( $locations as $location ) : 
            // Get address data
            $address = get_field('address',$location);
            ?>
            <li data-lat="<?php echo esc_attr($address['lat']); ?>">
                <a href="#mappa" class="map-button"><?php echo $location->post_title; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif;