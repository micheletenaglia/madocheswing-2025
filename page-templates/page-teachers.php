<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Template name: Teachers 
 * 
 * */

// Get header
get_header();

// Get teachers
$teachers = get_posts([
    'post_type'     =>  'teacher',
    'post_status'   =>  'publish',
    'numberposts'   =>  -1,
    'order'         =>  'ASC',
    'orderby'       =>  'menu_order'
]);

?>
<div class="pl-sm pb-sm pr-sm">
    <header class="container-sm  mb-sm text-center">
        <span class="eyelet">Mado' che squadra</span>
        <h1 class="title-xl mb-4"><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </header>
    <main>
        <?php foreach( $teachers as $teacher ) : 
            // Get styles
            $styles = get_field('styles',$teacher);
            $teacher_styles = [];
            foreach( $styles as $style ) {
                $teacher_styles[] = '<a href="' . get_the_permalink($style) . '">' . get_the_title($style) . '</a>';
            }
            // Get email
            $email = get_field('email',$teacher);
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
                        'key'       =>  'teachers',
                        'value'     =>  '"' . $teacher->ID . '"',
                        'compare'   =>  'LIKE',
                    ]
                ]
            ]);
            ?>
            <div id="<?php echo sanitize_title(get_the_title($teacher)); ?>" class="grid-1-3 gap-4-8-16 mb-sm pt-sm border-top">
                <div>
                    <?php echo get_the_post_thumbnail($teacher,'full',['class'=>'block']); ?>
                </div>
                <div>
                    <h2><?php echo get_the_title($teacher); ?></h2>
                    <div class="mb-4 text-sm font-bold">
                        <?php echo implode(' | ',$teacher_styles); ?>
                        <?php if( $email ) : ?>
                            <div class="mt-2 text-xs">
                                <a href="<?php echo esc_url('mailto:' . $email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if( $teacher->post_content ) : ?>
                        <?php echo apply_filters('the_content',$teacher->post_content); ?>
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
                                    <a class="block" href="<?php echo get_the_permalink($dance_class); ?>"><?php _e('Details','project'); ?></a>
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