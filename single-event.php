<?php

/**
 * The template for post type "event".
 *
 */

// Get header
get_header();

// Get post ID
$post_id = get_the_ID();

// Get timestamp
$timestamp = strtotime(get_field('date'));

// Get timestamp
$end_timestamp = get_field('end_date') ? strtotime(get_field('end_date')) : null;

// Get location
$location = get_field('location');

// Map arguments
$map_args = [
    'locations'     =>  [$location],
    'wrap_style'    =>  '',
    'map_style'     =>  '',
];

// Get address data
$address_data = mkt_address_data(get_field('address',$location));

?>
<div class="pl-sm pb-sm pr-sm">
    <header class="container-sm mb-sm text-center">
        <a href="<?php echo get_the_permalink(898); ?>" class="eyelet">Mado' che eventi</a>
        <h1 class="title-xl mt-4 mb-4"><?php the_title(); ?></h1>
        <h2><?php echo esc_html(get_field('subhead')); ?></h2>
    </header>
    <?php if( get_the_content() ) : ?>
        <div class="container-sm mb-sm text-center">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>
    <div class="grid-1-3">
        <div>
            <?php mkt_get_template('map/map',$map_args); ?>
        </div>
        <div class="bg-gray-50 p-xs">
            <h3 class="h4"><?php _e('When','project'); ?></h3>
            <?php if( $end_timestamp ) : ?>
                <p><?php echo sprintf(__('Every %s from %s to %s.','project'),wp_date('l',$timestamp),wp_date('j F Y',$timestamp),wp_date('j F Y',$end_timestamp)); ?></p>
            <?php else : ?>
                <p><?php echo ucwords(wp_date('l j F Y',$timestamp)); ?></p>
            <?php endif; ?>
            <h3 class="h4"><?php _e('Where','project'); ?></h3>
            <strong><?php echo get_the_title($location); ?></strong>
            <ul>
                <?php foreach( $address_data as $item ) : ?>
                    <li><?php echo $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="bg-gray-50 p-xs">
            <div>
                <h3 class="h4"><?php _e('Entrance','project'); ?></h3>
                <?php echo get_field('entrance') ? esc_html(get_field('entrance')) : __('Not available.','project'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();