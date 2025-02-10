<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Levels
$levels = get_posts([
    'post_type'     =>  'level',
    'numberposts'   =>  -1,
    'fields'        =>  'ids',
    'order'         =>  'ASC',
    'orderby'       =>  'menu_order',
]);

if( $levels ) :
    foreach( $levels as $level ) :
        $dance_classes = get_posts([
            'post_type'     =>  'dance-class',
            'numberposts'   =>  -1,
            'order'         =>  'ASC',
            'orderby'       =>  'meta_value',
            'meta_key'      =>  'date',
            'meta_type'     =>  'DATE',
            'meta_query'    =>  [
                [
                    'key'   =>  'level',
                    'value' =>  $level,
                ]
            ],
        ]);
        if( $dance_classes ) : ?>
            <div class="">
                <h3><?php echo get_the_title($level); ?></h3>
                <div class="">
                    <?php foreach( $dance_classes as $class ) : ?>
                        <div>
                            <?php echo $class->post_title; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif;
    endforeach;
endif;