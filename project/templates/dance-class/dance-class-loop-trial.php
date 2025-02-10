<?php
    
/**
 * List of trial lessons.
 * 
 */

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
            'key'       =>  'trial_lesson',
        ]
    ]
]);

// Table headers
$headers = [
    'style' =>  __('Style','project'),
    'level' =>  __('Level','project'),
    'date'  =>  __('Date','project'),
    'venue' =>  __('Venue','project'),
];

// If any result
if( $dance_classes ) :
    ?>
    <ul class="classes-table">
        <li class="classes-table-header grid-1-2-4 border-bottom p-2 font-black text-xs">
            <?php foreach( $headers as $header ) : ?>
                <div>
                    <?php echo $header; ?>
                </div>
            <?php endforeach; ?>
        </li>
        <?php foreach( $dance_classes as $dance_class ) : 
            // Get style
            $style = get_field('style',$dance_class);
            // Get level
            $level = get_field('level',$dance_class);
            // Get location
            $location = get_field('location',$dance_class);
            // Get address
            $address = get_field('address',$location);
            ?>
            <li class="grid-1-2-4 border-bottom p-2" data-lat="<?php echo esc_attr($address['lat']); ?>">
                <div>
                    <span class="break-3-max"><?php echo $headers['style']; ?></span>
                    <strong class="font-black text-black"><?php echo get_the_title($style); ?></strong>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['level']; ?></span>
                    <?php echo get_field('label',$level); ?>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['date']; ?></span>
                    <?php echo wp_date('j F Y',strtotime(get_field('date',$dance_class))) . ' - ' . get_field('time',$dance_class); ?>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['venue']; ?></span>
                    <a href="<?php echo get_the_permalink(748); ?>#mappa" class="map-button"><?php echo get_the_title($location); ?></a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif;