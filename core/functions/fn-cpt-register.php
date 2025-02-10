<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Register taxonomies and post types.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

 /****************************************************************************************
   ____ ____ _____           _____  _    __  __
  / ___|  _ \_   _|    _    |_   _|/ \   \ \/ /
 | |   | |_) || |    _| |_    | | / _ \   \  / 
 | |___|  __/ | |   |_   _|   | |/ ___ \  /  \ 
  \____|_|    |_|     |_|     |_/_/   \_\/_/\_\
 
****************************************************************************************/

/* Actions ----------------------------------------------------------------------------*/

// TAX: progress_status
add_action('init', 'hap_register_tax_progress_status');

// TAX: page_category
add_action('init', 'hap_register_tax_page_category');

/* Functions --------------------------------------------------------------------------*/

/**
 * Register new taxonomy: Progress Status.
 *
 * @return void.
 */
function hap_register_tax_progress_status() {
    // Labels
    $labels = [
        'name'							=> esc_html__( 'Progress', 'hap' ),
        'singular_name'					=> esc_html__( 'Progress', 'hap' ),
        'menu_name'						=> esc_html__( 'Progress', 'hap' ),
    ];
    // Args
    $args = [
        'label'							=> esc_html__( 'Progress', 'hap' ),
        'labels'						=> $labels,
        'public'						=> false,
        'publicly_queryable'			=> false,
        'hierarchical'					=> true,
        'show_ui'						=> true,
        'show_in_menu'					=> true,
        'show_in_nav_menus'				=> true,
        'query_var' 					=> true,
        'capabilities'				=> [
            'manage_terms'	=>	'manage_options',
            'edit_terms'	=>	'manage_options',
            'delete_terms'	=>	'manage_options',
            'assign_terms'	=>	'manage_options',
        ],
        'rewrite' 						=> [
            'slug'			=> 'progress_status', 
            'with_front'	=> true,
        ],
        'show_admin_column'				=> true,
        'show_in_rest'					=> false,
        'show_tagcloud'					=> false,
        'rest_base'						=> 'progress_status',
        'rest_controller_class'			=> 'WP_REST_Terms_Controller',
        'rest_namespace'				=> 'wp/v2',
        'show_in_quick_edit'			=> true,
        'sort'							=> false,
        'show_in_graphql'				=> false,
    ];
    // Register only for custom post types, pages and posts
    $post_types = get_post_types(['_builtin' => false]);
    // Delete element by value
    if( ($key = array_search('acf-field-group', $post_types)) !== false ) {
        unset($post_types[$key]);
    }
    register_taxonomy('progress_status', array_merge(['page', 'post'], $post_types), $args);

}

/**
 * Register new taxonomy: Page categories.
 *
 * @return void.
 */
function hap_register_tax_page_category() {
    // Labels
    $labels = [
        'name'							=> esc_html__( 'Page categories', 'hap' ),
        'singular_name'					=> esc_html__( 'Page category', 'hap' ),
        'menu_name'						=> esc_html__( 'Page categories', 'hap' ),
    ];
    // Args
    $args = [
        'label'							=> esc_html__( 'Page categories', 'hap' ),
        'labels'						=> $labels,
        'public'						=> false,
        'publicly_queryable'			=> false,
        'hierarchical'					=> true,
        'show_ui'						=> true,
        'show_in_menu'					=> true,
        'show_in_nav_menus'				=> true,
        'query_var' 					=> true,
        'rewrite'						=> [ 'slug' => 'page_category', 'with_front' => true, ],
        'show_admin_column'				=> true,
        'show_in_rest'					=> false,
        'show_tagcloud'					=> false,
        'rest_base'						=> 'page_category',
        'rest_controller_class'			=> 'WP_REST_Terms_Controller',
        'rest_namespace'				=> 'wp/v2',
        'show_in_quick_edit'			=> true,
        'sort'							=> false,
        'show_in_graphql'				=> false,
    ];
    // Register taxonomy
    register_taxonomy( 'page_category', [ 'page' ], $args );
}