<?php

// Exit if accessed directly
if( ! defined('ABSPATH') ) {
	exit;
}

// Get the ID
$post_id = get_the_ID();

// Get address
$address = get_field('address',$post_id);
$address_data = hap_address_data($address);

?>

<div data-lat="<?php echo esc_attr($address['lat']); ?>" class="bg-black isdark p-sm flex flex-col justify-between">
    <div>
        <h2 class="h4"><?php the_title(); ?></h2>
        <ul>
            <?php foreach(  $address_data as $item ) : ?>
                <li class="mb-1">
                    <?php echo $item; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="mt-2">
        <a href="#mappa" class="map-button button hollow light"><?php _e('View on map','project'); ?></a>
    </div>
</div>