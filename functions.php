<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The main PHP file of the theme
 *
 */

// This line requires the main configuration file 
// of the theme, do not delete.
require_once('core/functions/fn-config.php');

// Project fields
require_once('project/functions/fn-acf-fields-project.php');

// Register custom post types and taxonomies
add_action('init','mcs_register_cpts');

// Register custom taxonomy Location categories
add_action('init','mcs_register_taxes');

// Create children classes or events on save
add_action('acf/save_post','mcs_insert_post_children');

// Redirect to parent all child dance classes and events
add_action('template_redirect','mcs_children_redirect');

// Exclude children posts from search and avoid search of short strings
add_action('pre_get_posts','mcs_search_query');

// Contact Form 7
add_filter('wpcf7_form_tag_data_option','mcs_cf7_dance_classes',10,3);
add_filter('wpcf7_special_mail_tags','mcs_cf7_email_start', 10, 3);
add_filter('wpcf7_special_mail_tags','mcs_cf7_email_end', 10, 3);

// Load Google Maps style only when needed
add_filter('mkt_map_style_inclusion','mcs_google_map_optimization');

/**
 * Generate children dance classes on post save.
 *
 * @param integer $post_id
 * @return void
 */
function mcs_insert_post_children( $post_id ) {
    // Get post type
    $post_type = get_post_type($post_id);
    // Bail out early 1
    if( !in_array($post_type,['dance-class','event']) ) {
        return;
    }
    // Bail out early 2
    if( 
        !get_field('generate_children',$post_id) 
        || !get_field('date',$post_id) 
        || !get_field('end_date',$post_id) 
    ) {
        return;
    }
    // Reset "generate_children" field in parent post
    update_field('generate_children',null,$post_id);
    // Index
    $index = 0;
    // Start date
    $start = new DateTime(get_field('date',$post_id));
    // End date
    $end = new DateTime(get_field('end_date',$post_id));
    // Add one day to end date
    $end->modify('+1 day');
    // Get period
    $period = new DatePeriod(
        $start,
        new DateInterval('P7D'),
        $end
    );
    // Loop weeks
    foreach( $period as $date ) {
        // Title
        $title = get_the_title($post_id) . ' - ' . $date->format('Y/m/d');
        // Check if post already exists
        $check = mkt_get_page_by_title($title,$post_type);
        // If so, skip week
        if( $check ) {
            continue;
        }
        // Skip also first iteration because it has the same date of the parent
        if( $date->format('Ymd') == get_field('date',$post_id) ) {
            continue;
        }
        // Increment index for menu_order
        $index++;
        // Insert post
        $new_id = wp_insert_post([
            'post_type'     =>  $post_type,
            'post_title'    =>  $title,
            'post_status'   =>  'publish',
            'post_parent'   =>  $post_id,
            'menu_order'    =>  $index,
        ]);
        // Update fields
        $fields = [
            'dance-class' => [
                'date'          =>  $date->format('Ymd'),
                'style'         =>  get_field('style',$post_id),
                'level'         =>  get_field('level',$post_id),
                'teachers'      =>  get_field('teachers',$post_id),
                'time'          =>  get_field('time',$post_id),
                'location'      =>  get_field('location',$post_id),
                'class_type'    =>  get_field('class_type',$post_id),
            ],
            'event' => [
                'date'          =>  $date->format('Ymd'),
                'start_time'    =>  get_field('start_time',$post_id),
                'end_time'      =>  get_field('end_time',$post_id),
                'subhead'       =>  get_field('subhead',$post_id),
                'venue'         =>  get_field('venue',$post_id),
            ],
        ];
        foreach( $fields[$post_type] as $key => $value ) {
            update_field($key,$value,$new_id);
        }
        // Update Yoast SEO meta
        // No index
        update_post_meta($new_id,'_yoast_wpseo_meta-robots-noindex',1);
        // No follow
        update_post_meta($new_id,'_yoast_wpseo_meta-robots-nofollow',1);
        // Adv
        update_post_meta($new_id,'_yoast_wpseo_meta-robots-adv','noimageindex,noarchive,nosnippet');
        // Canonical
        update_post_meta($new_id,'_yoast_wpseo_canonical',get_the_permalink($post_id));
    }
}

/**
 * Get the list of dance classes for CF7 forms.
 *
 * @param array $data
 * @param array $options
 * @param array $args
 * @return array $data
 */
function mcs_cf7_dance_classes($data, $options, $args) {
	$data = [];
	foreach( $options as $option ) {
		if( $option === 'dance_classes') {
            // Get dance classes
            $dance_classes = get_posts([
                'post_type'     =>  'dance-class',
                'numberposts'   =>  -1,
                'order'         =>  'ASC',
                'orderby'       =>  'meta_value',
                'meta_key'      =>  'level',
                'meta_query'    =>  [
                    [
                        'key'   =>  'registration',
                        'value' =>  'open',
                    ]
                ],
            ]);
            if( $dance_classes ) {
                $dance_classes = wp_list_pluck($dance_classes,'post_title');
                $data = array_merge($data,$dance_classes);
            }
		}
	}
	return $data;
}

/**
 * Shortcode to generate Contact Form 7 email start html output.
 *
 * @param string $output
 * @param string $name
 * @param string $html
 * @return string $output
 */
function mcs_cf7_email_start( $output, $name, $html ) {
	if( 'mcs_email_start' == $name ) {
		$output = '<div style="background-color: rgb(250,250,250); padding: 20px; font-size: 18px; color: #646464; margin-bottom: 5px;">';
	}
	return $output;
}

/**
 * Shortcode to generate Contact Form 7 email end html output.
 *
 * @param string $output
 * @param string $name
 * @param string $html
 * @return string $output
 */
function mcs_cf7_email_end( $output, $name, $html ) {
	if( 'mcs_email_end' == $name ) {
        $output = '</div>';
        $output .= mkt_get_email_signature('img_url');
	}
	return $output;
}

/**
 * Redirect to parent all child dance classes and events.
 *
 * @return void
 */
function mcs_children_redirect() {
    // Bail out early
    if( !is_singular(['dance-class','event']) ) {
        return;
    }
    // Get post
    global $post;
    // Get parent
    $parent_id = wp_get_post_parent_id($post->ID);
    // If has parent
    if( $parent_id ) {
        // Redirect
        wp_safe_redirect(
            get_the_permalink($parent_id),
            301,
            'madocheswing.com'
        );
        // Exit
        exit;
    }
}

/**
 * Load Google Maps style only when needed.
 *
 * @return boolean
 */
function mcs_google_map_optimization() {
    // Pages "Corsi di ballo" and "Contatti"
    // Single "Dance class" and "Event"
    if( 
        is_page([748,719]) 
        || is_singular(['dance-class','event'])
    ) {
        return true;
    }else{
        return false;
    }
}

/**
 * Exclude children posts from search
 * and avoid search of short strings.
 *
 * @param object $query
 * @return void
 */
function mcs_search_query( $query ) {
    if( !is_admin() && $query->is_main_query() ) {
        // If is search result page
        if( is_search() ) {
            if( strlen(get_query_var('s')) < 3 ) {
                $query->set('s','');
            }
            $query->set('post_parent',0);
        }
    }
}

/**
 * Register custom post types and taxonomies.
 *
 * @return void
 */
function mcs_register_cpts() {

    /*----------------------------------------/
     ____  _   _ ____  _     ___ ____ 
    |  _ \| | | | __ )| |   |_ _/ ___|
    | |_) | | | |  _ \| |    | | |    
    |  __/| |_| | |_) | |___ | | |___ 
    |_|    \___/|____/|_____|___\____|
                                    
    /----------------------------------------*/

	/**
	 * Post Type: Dance classes.
     * Public post type.
     * 
	 */
    // Labels
	$labels = [
		'name'          => esc_html__('Dance classes','project'),
		'singular_name' => esc_html__('Dance class','project'),
		'menu_name'     => esc_html__('Dance classes','project'),
	];
    // Args
	$args = [
		'label'                 => esc_html__('Dance classes','project'),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_namespace'        => 'wp/v2',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => true,
		'can_export'            => false,
		'rewrite'               => [ 
            'slug'          => 'corsi-ballo-swing', 
            'with_front'    => true 
        ],
		'query_var'             => true,
		'menu_position'         => 31,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'supports'              => [ 
            'title', 
            'editor', 
            'thumbnail', 
            'custom-fields', 
            'author', 
            'page-attributes' 
        ],
		'show_in_graphql'       => false,
	];
	register_post_type('dance-class',$args);

	/**
	 * Post Type: Events.
     * Public post type.
     * 
	 */
    // Labels
	$labels = [
		'name'          => esc_html__('Events','project'),
		'singular_name' => esc_html__('Event','project'),
		'menu_name'     => esc_html__('Events','project'),
    ];
    // Args
	$args = [
		'label'                 => esc_html__('Events','project'),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_namespace'        => 'wp/v2',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => false,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => true,
		'can_export'            => false,
		'rewrite'               => [ 'slug' => 'eventi-swing', 'with_front' => true ],
		'query_var'             => true,
		'menu_position'         => 36,
		'menu_icon'             => 'dashicons-calendar-alt',
		'supports'              => [ 
            'title', 
            'editor', 
            'thumbnail', 
            'custom-fields', 
            'author', 
            'page-attributes' 
        ],
		'show_in_graphql' => false,
	];
	register_post_type('event',$args);

	/**
	 * Post Type: Styles.
     * Public post type.
     * 
	 */
    // Labels
	$labels = [
		'name'          => esc_html__('Styles','project'),
		'singular_name' => esc_html__('Style','project'),
		'menu_name'     => esc_html__('Styles','project'),
	];
    // Args
	$args = [
		'label'                 => esc_html__('Styles','project'),
		'labels' => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_namespace'        => 'wp/v2',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'can_export'            => false,
		'rewrite'               => [ 'slug' => 'stili-ballo-swing', 'with_front' => true ],
		'query_var'             => true,
		'menu_position'         => 32,
		'menu_icon'             => 'dashicons-album',
		'supports'              => [ 
            'title', 
            'editor', 
            'thumbnail', 
            'custom-fields', 
            'author', 
            'page-attributes'
        ],
		'show_in_graphql'       => false,
	];
	register_post_type('style',$args);

    /*----------------------------------------/
     ____  ____  _____     ___  _____ _____ 
    |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
    | |_) | |_) || | \ \ / / _ \ | | |  _|  
    |  __/|  _ < | |  \ V / ___ \| | | |___ 
    |_|   |_| \_\___|  \_/_/   \_\_| |_____|
                                            
    /----------------------------------------*/
	/**
	 * Post Type: Levels.
     * Private post type.
     * 
	 */
    // Labels
	$labels = [
		'name'          => esc_html__('Levels','project'),
		'singular_name' => esc_html__('Level','project'),
		'menu_name'     => esc_html__('Levels','project'),
	];
    // Args
	$args = [
		'label'                 => esc_html__('Levels','project'),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_namespace'        => 'wp/v2',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => false,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => true,
		'can_export'            => false,
		'rewrite'               => [ 
            'slug'          => 'level', 
            'with_front'    => true 
        ],
		'query_var'             => true,
		'menu_position'         => 33,
		'menu_icon'             => 'dashicons-editor-ol',
		'supports'              => [ 
            'title', 
            'editor', 
            'thumbnail', 
            'custom-fields', 
            'author', 
            'page-attributes' 
        ],
		'show_in_graphql'       => false,
	];
	register_post_type('level',$args);

	/**
	 * Post Type: Teachers.
     * Private post type.
     * 
	 */
    // Labels
	$labels = [
		'name'          => esc_html__('Teachers','project'),
		'singular_name' => esc_html__('Teacher','project'),
		'menu_name'     => esc_html__('Teachers','project'),
	];
    // Args
	$args = [
		'label'                 => esc_html__('Teachers','project'),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_namespace'        => 'wp/v2',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => false,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'can_export'            => false,
		'rewrite'               => [ 
            'slug'          => 'teacher', 
            'with_front'    => true 
        ],
		'query_var'             => true,
		'menu_position'         => 34,
		'menu_icon'             => 'dashicons-admin-users',
		'supports'              => [ 
            'title', 
            'editor', 
            'thumbnail', 
            'custom-fields', 
            'author', 
            'page-attributes' 
        ],
		'show_in_graphql'       => false,
	];
	register_post_type('teacher',$args);

	/**
	 * Post Type: Locations.
     * Private post type.
     * 
	 */
    // Labels
	$labels = [
		'name'          => esc_html__('Locations','project'),
		'singular_name' => esc_html__('Location','project'),
		'menu_name'     => esc_html__('Locations','project'),
	];
    // Args
	$args = [
		'label'                 => esc_html__('Locations','project'),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_namespace'        => 'wp/v2',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => false,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'can_export'            => false,
		'rewrite'               => [ 
            'slug'          => 'location', 
            'with_front'    => true 
        ],
		'query_var'             => true,
		'menu_position'         => 35,
		'menu_icon'             => 'dashicons-location',
		'supports'              => [
            'title', 
            'editor', 
            'thumbnail', 
            'custom-fields',
            'author',
             'page-attributes' 
        ],
		'show_in_graphql' => false,
	];
	register_post_type('location',$args);

}

/**
 * Register taxonomy: Location categories.
 */
function mcs_register_taxes() {
    // Labels
	$labels = [
		'name'          => esc_html__('Location categories','project'),
		'singular_name' => esc_html__('Location category','project'),
	];
    // Args
	$args = [
		'label'                 => esc_html__('Location categories','project'),
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => false,
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => false,
		'query_var'             => true,
		'rewrite'               => [ 
            'slug'          => 'location_category', 
            'with_front'    => true, 
        ],
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'show_tagcloud'         => false,
		'rest_base'             => 'location_category',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rest_namespace'        => 'wp/v2',
		'show_in_quick_edit'    => true,
		'sort'                  => true,
		'show_in_graphql'       => false,
	];
	register_taxonomy('location_category',['location'],$args);
}