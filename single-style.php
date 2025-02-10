<?php

/**
 * The template for post type "style".
 *
 */

// Get header
get_header();

// Get post ID
$post_id = get_the_ID();

// Get dance classes
$dance_classes = get_posts([
    'post_type'     =>  'dance-class',
    'post_status'   =>  'publish',
    'post_parent'   =>  0,
    'numberposts'   =>  -1,
    'order'         =>  'ASC',
    'orderby'       =>  [
        'date_clause'   => 'ASC',
        'level_clause'  => 'ASC',
    ],
    'meta_query'    =>  [
        'relation'  => 'AND',
        'level_clause'  =>  [
            'key'       =>  'level',
        ],
        'date_clause'   =>  [
            'key'       =>  'date',
            'type'      =>  'DATE',
        ],
        [
            'key'       =>  'style',
            'value'     =>  $post_id,
        ]
    ]
]);

?>
<div class="pl-sm pb-sm pr-sm">
    <header class="container-sm mb-sm text-center">
        <span class="eyelet"><?php _e('Dance styles','project'); ?></span>
        <h1 class="title-xl mb-4"><?php the_title(); ?></h1>
        <h2><?php echo esc_html(get_field('subhead')); ?></h2>
    </header>
    <div class="mb-sm">
        <?php the_post_thumbnail('full',['class'=>'block']); ?>
        <span class="block text-xs mt-4"><?php echo esc_html(get_the_post_thumbnail_caption()); ?></span>
    </div>
    <?php if( get_the_content() ) : ?>
        <div class="container-sm mb-sm">
            <?php the_content(); ?>
        </div>
    <?php endif;
    if( $dance_classes ) : ?>
        <section>
            <div class="text-center mb-sm">
                <span class="block h2"><?php _e('Dance classes','project'); ?></span>
            </div>
            <div class="flex-1-3">
                <?php foreach( $dance_classes as $dance_class ) {
                    mkt_get_template('dance-class/dance-class-card',['post_id'=>$dance_class->ID]);
                } ?>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php get_footer();