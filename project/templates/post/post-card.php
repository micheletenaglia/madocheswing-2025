<?php

/**
 * Post card.
 * 
 */

// Get post ID
$post_id = get_the_ID();

// Get categories
$category = get_the_category($post_id);
$category = $category[0];

?>

<a href="<?php echo get_the_permalink($post_id); ?>" class="card-dance-class">
    <div class="card-label">
        <span><?php echo $category->name; ?></span>
    </div>
    <span class="text-xs"><?php echo get_the_date('j F Y',$post_id); ?></span>
    <span class="card-title"><?php echo get_the_title($post_id); ?></span>
    <span class="block mt-2 text-xs"><?php echo __('By','project') . ' ' . get_the_author_meta('first_name',$post->post_author); ?></span>
</a>