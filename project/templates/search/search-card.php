<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Get post ID
$post_id = get_the_ID();

// Get post type
$post_type = get_post_type();

// Custom URLs for private post types
switch ($post_type) {
    case 'level':
        $url_id = 713; // Page "Livelli"
        break;
    case 'teacher':
        $url_id = 735; // Page "Insegnanti"
        break;
    case 'location':
        $url_id = 719; // Page "Contatti"
        break;
    default :
        $url_id = $post_id;
}

// Get description
$description = null;
$meta_description = get_post_meta(get_the_ID(),'_yoast_wpseo_metadesc',1);
if( $meta_description ) {
    $description = $meta_description;
}elseif( get_the_excerpt() ) {
    $description = get_the_excerpt();
}

?>
<article class="search-card">		
	<h2><?php echo strip_tags(get_the_title()); ?></h2>
	<?php if( $description ) : ?>
		<p class="truncate-2-lines"><?php echo esc_html($description); ?></p>
	<?php endif; ?>
	<a href="<?php the_permalink($url_id); ?>"><?php echo get_svg_icon('icon-link','inline-block fill-current h-2 w-auto'); ?> <?php echo hap_url_label(get_the_permalink($url_id)); ?></a>

</article>