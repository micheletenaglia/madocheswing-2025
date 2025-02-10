<?php

/**
 * Template name: Levels 
 * 
 * */

// Get header
get_header();

// Get levels
$levels = get_posts([
    'post_type'     =>  'level',
    'post_status'   =>  'publish',
    'numberposts'   =>  -1,
    'order'         =>  'ASC',
    'orderby'       =>  'menu_order'
]);

?>

<div class="pl-sm pb-sm pr-sm">
    <header class="container-sm  mb-sm text-center">
        <span class="eyelet"><?php _e('Dance classes','project'); ?></span>
        <h1 class="title-xl mb-4"><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </header>
    <main>
        <?php foreach( $levels as $level ) : 
            // Get style
            $style = get_field('style',$level);
            // Get dance classes
            $dance_classes = get_posts([
                'post_type'     =>  'dance-class',
                'post_status'   =>  'publish',
                'post_parent'   =>  0,
                'numberposts'   =>  -1,
                'order'         =>  'ASC',
                'orderby'       =>  'menu_value',
                'meta_key'      =>  'date',
                'meta_type'     =>  'DATE',
                'meta_query'    =>  [
                    [
                        'key'   =>  'level',
                        'value' =>  $level->ID,
                    ]
                ]
            ]);
            ?>
            <div id="<?php echo sanitize_title(get_the_title($level)); ?>" class="grid-1-3 mb-sm pt-sm border-top">
                <div class="col-span-1-2">
                    <h2><span class="text-primary font-black"><?php echo get_the_title($style); ?></span> <?php echo get_field('label',$level); ?></h2>
                    <p><strong><?php echo get_field('short_description',$level); ?></strong></p>
                    <?php if( $level->post_content ) : ?>
                        <?php echo apply_filters('the_content',$level->post_content); ?>
                    <?php else : ?>
                        <p><?php _e('Description not available.','project'); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <strong class="text-black"><?php _e('Dance classes','project'); ?></strong>
                    <?php if( $dance_classes ) : ?>
                        <ul>
                            <?php foreach( $dance_classes as $dance_class ) : ?>
                                <li class="mt-4 text-xs">
                                    <strong class="text-black block"><?php echo $dance_class->post_title; ?></strong>
                                    <span><?php echo get_field('subhead',$dance_class); ?></span>
                                    <a class="block mt-2 text-xs" href="<?php echo get_the_permalink($dance_class); ?>"><?php _e('Details','project'); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p><?php _e('No classes at this time.','project'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
</div>
<?php get_footer();