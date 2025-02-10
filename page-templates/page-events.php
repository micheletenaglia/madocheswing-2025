<?php

/**
 * Template name: Events 
 * 
 * */

// Get header
get_header();

// Get today date
$today = date('Y-m-d');

// Add 4 months
$six_months = strtotime($today . ' +6 months');

// First and last dates
$first_date = wp_date('l j F Y');
$last_date = wp_date('l j F Y',$six_months);

// Get events
$events = get_posts([
    'post_type'     =>  'event',
    'post_status'   =>  'publish',
    'numberposts'   =>  -1,
    'order'         =>  'ASC',
    'orderby'       =>  'meta_value',
    'meta_key'      =>  'date',
    'meta_type'     =>  'DATE',
    'meta_query'    =>  [
        [
            'key'       =>  'date',
            'type'      =>  'DATE',
            'value'     =>  [
                $today,
                date('Y-m-d',$six_months),
            ],
            'compare'   =>  'BETWEEN',

        ]
    ],
]);

// Default momths
$months = [];

// If events
if( $events ) {
    // Update first date
    $first_date = wp_date('l j F Y',strtotime(get_field('date',$events[0])));
    // Update last date
    $last_date = wp_date('l j F Y',strtotime(get_field('date',end($events))));
    // Loop events
    foreach( $events as $event ) {
        // Get timestamp
        $timestamp = strtotime(get_field('date',$event));
        // Get parent ID
        $parent_id = wp_get_post_parent_id($event);
        // Title
        $title = $parent_id ? get_the_title($parent_id): $event->post_title;
        // Get location
        $location = get_field('venue',$event);
        // Address
        $address = get_field('address',$location);
        // Address string
        $address_string = $address['street_name'] . ' ' . $address['street_number'] . ', ' . $address['city'];
        // Update array
        $months[wp_date('F',$timestamp)][] = [
            'id'        =>  $parent_id ? $parent_id : $event->ID,
            'title'     =>  $title,
            'subhead'   =>  get_field('subhead',$event),
            'timestamp' =>  $timestamp,
            'start_time'=>  get_field('start_time',$event),
            'end_time'  =>  get_field('end_time',$event),
            'venue'     =>  get_the_title($location),
            'address'   =>  $address_string,
        ];
    }
}

// Dates text
$dates_txt = sprintf(
    __('Events from %s to %s','project'),
    $first_date,
    $last_date
);

?>

<div class="pl-sm pb-sm pr-sm">
    <header class="container-sm  mb-sm text-center">
        <span class="eyelet">Mado' che eventi</span>
        <h1 class="title-xl mt-4 mb-4"><?php _e('Events','project'); ?></h1>
        <?php the_content(); ?>
        <p class="pb-0"><?php echo esc_html($dates_txt); ?></p>
    </header>
    <main>
        <?php foreach( $months as $month => $dates ) : ?> 
            <div class="mb-xs pt-xs border-bottom">
                <h4><?php echo $month; ?></h4>
                <?php foreach( $dates as $data ) : ?>
                    <ul class="grid-1-3-6 items-center border-top">
                        <li class="pt-2 pb-2 text-3xl font-black text-black">
                            <?php echo ucwords(wp_date('j',$data['timestamp'])); ?>
                        </li>
                        <li class="pt-2 pb-2">
                            <span class="block font-black text-black"><?php echo $data['title']; ?></span>
                            <span class="block text-xs"><?php echo $data['subhead']; ?></span>
                        </li>
                        <li class="pt-2 pb-2">
                            <?php echo ucwords(wp_date('d M Y',$data['timestamp'])); ?>
                            <span class="block text-xs"><?php echo $data['start_time'] . ' - ' . $data['end_time']; ?></span>
                        </li>
                        <li class="pt-2 pb-2 col-span-1-2">
                            <span class="block text-sm"><?php echo $data['venue']; ?></span>
                            <span class="block text-xs"><?php echo $data['address']; ?></span>
                        </li>
                        <li class="pt-2 pb-2">
                            <a class="button hollow small w-full" href="<?php echo get_the_permalink($data['id']); ?>"><?php _e('Details','project'); ?></a>
                        </li>
                    </ul>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </main>
</div>
<?php get_footer();