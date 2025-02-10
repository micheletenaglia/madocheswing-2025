<?php

/**
 * The template for post type "dance-class".
 *
 */

// Get header
get_header();

// Get post ID
$post_id = get_the_ID();

// Get style
$style = get_field('style');

// Get style
$level = get_field('level');

// Get teachers
$teachers = get_field('teachers');

// Get location
$location = get_field('location');

// Start time
$start_time = get_field('time');

// End time
$end_timestamp = strtotime($start_time) + 60*60;

// Default months
$months = [];

// Get children
$children = get_posts([
    'post_type'     =>  'dance-class',
    'post_status'   =>  'publish',
    'numberposts'   =>  -1,
    'post_parent'   =>  $post_id,
    'fields'        =>  'ids',
    'order'         =>  'ASC',
    'orderby'       =>  'meta_value',
    'meta_key'      =>  'date',
    'meta_type'     =>  'DATE',
]);

// Default month
if( $children ) {
    $children = array_merge([$post_id],$children);
}else{
    // $children = [$post_id]; // Uncomment this to enable the dates
}
foreach( $children as $child ) {
    // Get timestamp
    $timestamp = strtotime(get_field('date',$child));
    $months[wp_date('F',$timestamp)][] = [
        'id'        =>  $child,
        'timestamp' =>  $timestamp,
    ];
}

// Index
$index = 0;

// Labels
$labels = [
    'open'          =>  __('Open','project'),
    'closed'        =>  __('Closed','project'),
    'quarterly'     =>  __('Quarterly','project') . '*',
    'monthly'       =>  __('Monthly','project') . '**',
    'early_birds'   =>  'Early birds***',
];

// Map arguments
$map_args = [
    'locations'     =>  [$location],
    'wrap_style'    =>  '',
    'map_style'     =>  '',
];

?>

<div class="pl-sm pb-sm pr-sm">
    <header class="container-sm mb-sm text-center">
        <span class="eyelet"><?php _e('Dance classes','project'); ?></span>
        <h1 class="title-xl mb-4"><?php the_title(); ?></h1>
        <h2><?php echo get_field('label',$level); if( get_field('subhead') ) { echo ' / ' . get_field('subhead'); } ?></h2>
        <div class="teachers-thumbs">
            <?php foreach( $teachers as $teacher ) : ?>
                <span class="block">
                    <?php echo wp_get_attachment_image( get_field('profile_image',$teacher),'full'); ?>
                    <?php echo get_field('first_name',$teacher); ?>
                </span>
            <?php endforeach; ?>
        </div>
    </header>
    <ul class="grid-2-4-8 mb-sm text-center">
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Style','project'); ?></h6>
            <?php echo get_the_title($style); ?>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Level','project'); ?></h6>
            <?php echo get_field('label',$level); ?>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Teachers','project'); ?></h6>
            <ul class="list-inline-comma">
                <?php foreach( $teachers as $teacher ) {
                    echo '<li>' . get_field('first_name',$teacher) . '</li>';
                } ?>
            </ul>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Start','project'); ?></h6>
            <?php echo ucwords(wp_date('F Y',strtotime(get_field('date')))); ?>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('End','project'); ?></h6>
            <?php echo ucwords(wp_date('F Y',strtotime(get_field('end_date')))); ?>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Time','project'); ?></h6>
            <?php echo get_field('time') . ' - ' . date('H:i',$end_timestamp); ?>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Venue','project'); ?></h6>
            <?php echo get_the_title($location); ?>
        </li>
        <li class="pb-1">
            <h6 class="mb-0"><?php _e('Registration','project'); ?></h6>
            <?php echo $labels[get_field('registration')]; ?>
        </li>
    </ul>
    <div class="grid-1-3">
        <div>
            <?php hap_get_template('map/map',$map_args); ?>
        </div>
        <div class="bg-gray-50 p-xs flex flex-col justify-between">
            <div>
                <h3 class="h4"><?php _e('Registration','project'); ?></h3>
                <ul>
                    <li class="pb-1">
                        <h6 class="mb-0"><?php echo $labels['quarterly']; ?></h6>
                        <?php echo euro_format(get_field('fee_quarterly')); ?>
                    </li>
                    <li class="pb-1">
                        <h6 class="mb-0"><?php echo $labels['monthly']; ?></h6>
                        <?php echo euro_format(get_field('fee_monthly')); ?>
                    </li>
                    <?php if( get_field('early_birds_date') ) : ?>
                        <li class="pb-1">
                            <h6 class="mb-0"><?php echo $labels['early_birds']; ?></h6>
                            <strong class="font-black text-primary"><?php echo euro_format(get_field('early_birds_fee')); ?></strong>
                            <div class="text-xs"><?php echo __('Until','project') . ' ' . wp_date('d/m/Y',strtotime(get_field('early_birds_date'))); ?></div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <?php if( get_field('registration') == 'open' ) : ?>
                    <a href="<?php echo esc_url(get_the_permalink(748) . '#iscrizione'); ?>" class="button"><?php _e('Sign up now','project'); ?></a>
                <?php else : ?>
                    <strong class="text-black"><?php _e('Registrations are closed','project'); ?></strong>
                <?php endif; ?>
            </div>
        </div>
        <div class="bg-gray-50 p-xs flex flex-col justify-between">
            <div>
                <h3 class="h4"><?php _e('Description','project'); ?></h3>
                <?php if( get_the_content() ) : ?>
                    <?php the_content(); ?>
                <?php else : ?>
                    <p><?php _e('Description not available.','project'); ?></p>
                <?php endif; ?>
            </div>
            <div>
                <a href="<?php echo get_the_permalink(713) . '#' . sanitize_title(get_the_title($level)); ?>" class="button"><?php _e('More info','project'); ?></a>
            </div>
        </div>
    </div>
    <?php if( $months ) : ?>
        <div class="container-sm mt-md">
            <h3><?php echo __('Dates','project') . ' (' . sprintf(_n('%s Lesson','%s Lessons',count($children),'project'),count($children)) . ')'; ?></h3>
            <?php foreach( $months as $month => $dates ) : ?>
                <div class="mb-xs pt-xs border-bottom">
                    <h4><?php echo $month; ?></h4>
                    <?php foreach( $dates as $data ) :
                        $index++;
                        ?>
                        <ul class="pt-2 grid-1-2-4 items-center border-top">
                            <li class="text-3xl font-black text-black">
                                <?php echo ucwords(wp_date('j',$data['timestamp'])); ?>
                            </li>
                            <li>
                                <?php echo ucwords(wp_date('d/m/Y',$data['timestamp'])); ?>
                            </li>
                            <li>
                                <?php echo __('Lesson','project') . ' ' . $index; ?>
                            </li>
                            <?php if( get_field('trial_lesson',$data['id']) ) : ?>
                                <li>
                                    <strong class="text-primary"><?php _e('Trial lesson','project'); ?></strong>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>            
        </div>
    <?php endif; ?>
</div>
<?php get_footer();