<?php
    
// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * List of dance classes fees.
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
    ]
]);

// Table headers
$headers = [
    'style'         =>  __('Style','project'),
    'level'         =>  __('Level','project'),
    'day'           =>  __('Day','project') . '*',
    'quarterly'     =>  __('Quarterly','project') . '**',
    'monthly'       =>  __('Monthly','project') . '***',
    'early_birds'   =>  'Early birds****',
];

// Legend
$legend = [
    '*'      =>  __('Classes are always held on the same day at the same time. The duration is one hour.','project'),
    '**'     =>  __('Quarterly','project') . ': ' . sprintf(__('%s Consecutive lessons.','project'),12),
    '***'    =>  __('Monthly','project') . ': ' . sprintf(__('%s Consecutive lessons.','project'),4),
    '****'   =>  'Early birds: ' . sprintf(__('%s Consecutive lessons.','project'),12) . ' ' . __('For the first trimester only. The offer is valid for one dance class only.','project'),
];

// If any result
if( $dance_classes ) :
    ?>
    <ul class="classes-table">
        <li class="classes-table-header grid-1-3-6 border-bottom p-2 font-black text-xs">
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
            // Get early birds
            $early_birds = get_field('early_birds_date',$dance_class);
            ?>
            <li class="grid-1-3-6 border-bottom p-2 <?php if( $early_birds ) { echo 'early-birds'; } ?>" <?php if( $early_birds ) { echo 'data-label="' . __('Promo','project') . '"'; } ?>>
                <div>
                    <span class="break-3-max"><?php echo $headers['style']; ?></span>
                    <strong class="font-black text-black"><?php echo get_the_title($style); ?></strong>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['level']; ?></span>
                    <?php echo get_field('label',$level); ?>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['day']; ?></span>
                    <?php echo ucfirst(wp_date('l',strtotime(get_field('date',$dance_class)))); ?>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['quarterly']; ?></span>
                    <?php echo euro_format(get_field('fee_quarterly',$dance_class)); ?>
                </div>
                <div>
                    <span class="break-3-max"><?php echo $headers['monthly']; ?></span>
                    <?php echo euro_format(get_field('fee_monthly',$dance_class)); ?>
                </div>
                <div>
                    <?php if( get_field('early_birds_date',$dance_class) ) : ?>
                        <strong class="font-black text-primary"><?php echo euro_format(get_field('early_birds_fee',$dance_class)); ?></strong>
                        <div class="text-xs"><?php echo __('Until','project') . ' ' . wp_date('d/m/Y',strtotime(get_field('early_birds_date',$dance_class))); ?></div>
                    <?php else : ?>
                        &mdash;
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <ul class="text-center text-xs list-inline mt-xs">
        <?php foreach( $legend as $key => $value ) : ?>
            <li>
                (<?php echo $key; ?>) <?php echo $value; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif;