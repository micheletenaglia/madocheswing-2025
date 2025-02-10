<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Dance class card.
 * 
 * @param integer $post_id
 */
extract($args);

// Get style
$style = get_field('style',$post_id);

// Get level
$level = get_field('level',$post_id);

// Get teachers
$teachers = get_field('teachers',$post_id);

// Get location
$location = get_field('location',$post_id);

// Address
$address = get_field('address',$location);

// Address string
$address_string = $address['street_name'] . ' ' . $address['street_number'] . ', ' . $address['city'];

?>
<a href="<?php echo get_the_permalink($post_id); ?>" class="card-dance-class">
    <div class="card-label">
        <span><?php echo get_the_title($style); ?></span>
    </div>
    <div class="teachers-thumbs">
        <?php foreach( $teachers as $teacher ) : ?>
            <span class="block">
                <?php echo wp_get_attachment_image( get_field('profile_image',$teacher),'full'); ?>
                <?php echo esc_html(get_field('first_name',$teacher)); ?>
            </span>
        <?php endforeach; ?>
    </div>
    <span class="card-title"><?php echo get_the_title($post_id); ?></span>
    <ul>
        <li class="pb-1">
            <?php echo esc_html(get_field('label',$level)); ?>
        </li>
        <li class="pb-1">
            <?php echo ucwords(wp_date('l',strtotime(get_field('date',$post_id)))) . ' - ' . esc_html(get_field('time',$post_id)); ?>
        </li>
        <li class="pb-1">
            <?php echo get_the_title($location); ?>
            <span class="block text-xs"><?php echo esc_html($address_string); ?></span>
        </li>
    </ul>
</a>