<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Conditionally register post type, taxonomy, 
 * capabilities and php class for Stores.
 * ACF fieds for this post type are registered 
 * in fn-acf-fields-theme.php
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

 /****************************************************************************************
  ____ _____ ___  ____  _____ ____  
 / ___|_   _/ _ \|  _ \| ____/ ___| 
 \___ \ | || | | | |_) |  _| \___ \ 
  ___) || || |_| |  _ <| |___ ___) |
 |____/ |_| \___/|_| \_\_____|____/ 

****************************************************************************************/


if( is_acf_activated() ) {
	if( get_field('cpt_store','options') ) {
		add_action('init', 'hap_register_cpt_stores');
		add_action('init', 'hap_register_tax_store_category');
		add_action('admin_init', 'hap_add_caps_stores');
	}
}

/**
 * Register new custom post type: Stores.
 *
 * @return void.
 */
function hap_register_cpt_stores() {

	$labels = [
		'name'						=> esc_html__( 'Stores', 'hap' ),
		'singular_name'				=> esc_html__( 'Store', 'hap' ),
		'menu_name'					=> esc_html__( 'Stores', 'hap' ),
	];

	$args = [
		'label'						=> esc_html__( 'Stores', 'hap' ),
		'labels'					=> $labels,
		'description'				=> __('Custom post type to add stores to the website.','hap'),
		'public'					=> true,
		'publicly_queryable'		=> true,
		'show_ui'					=> true,
		'show_in_rest'				=> true, 
		'rest_base'					=> '',
		'rest_controller_class'		=> 'WP_REST_Posts_Controller',
		'rest_namespace'			=> 'wp/v2',
		'has_archive'				=> false,
		'show_in_menu'				=> true,
		'show_in_nav_menus'			=> true,
		'delete_with_user'			=> false,
		'exclude_from_search'		=> false,
		'capability_type'			=> [
			'post', 
			'posts'
		],
		'map_meta_cap'				=> true,
		'hierarchical'				=> false,
		'can_export'				=> false,
		'rewrite'					=> [ 
			'slug'			=> 'store', 
			'with_front'	=> true 
		],
		'query_var'					=> true,
		'menu_icon'					=> 'dashicons-store',
		'supports'					=> [ 
			'title', 
			'editor',
			'custom-fields', 
			'thumbnail', 
			'author'
		],
		'show_in_graphql'			=> false,
	];

	register_post_type( 'store', $args );

}

/**
 * Register new taxonomy: Store category.
 *
 * @return void.
 */
function hap_register_tax_store_category() {

	$labels = [
		'name'							=> esc_html__( 'Store categories', 'hap' ),
		'singular_name'					=> esc_html__( 'Store category', 'hap' ),
		'menu_name'						=> esc_html__( 'Store category', 'hap' ),
	];		

	$args = [
		'label'							=> esc_html__( 'Store category', 'hap' ),
		'labels'						=> $labels,
		'public'						=> false,
		'publicly_queryable'			=> true,
		'hierarchical'					=> true,
		'show_ui'						=> true,
		'show_in_menu'					=> true,
		'show_in_nav_menus'				=> true,
		'query_var' 					=> true,
		'rewrite' 						=> [
			'slug'			=> 'store-category', 
			'with_front'	=> true,
		],
		'show_admin_column'				=> true,
		'show_in_rest'					=> true,
		'show_tagcloud'					=> false,
		'rest_base'						=> 'store-category',
		'rest_controller_class'			=> 'WP_REST_Terms_Controller',
		'rest_namespace'				=> 'wp/v2',
		'show_in_quick_edit'			=> true,
		'sort'							=> false,
		'show_in_graphql'				=> false,

	];

	register_taxonomy('store-category', ['store'], $args);

}

/**
 * Add custom capability to admins for stores.
 *
 * @return void.
 */
function hap_add_caps_stores() {

	// Gets the administrator role
	$admins = get_role( 'administrator' );

	// Read
	$admins->add_cap( 'read_store' ); 
	$admins->add_cap( 'read_private_stores' ); 

	// Edit
	$admins->add_cap( 'edit_store' ); 
	$admins->add_cap( 'edit_stores' ); 
	$admins->add_cap( 'edit_other_stores' ); 
	$admins->add_cap( 'edit_published_stores' ); 
	$admins->add_cap( 'edit_private_stores' ); 

	// Publish
	$admins->add_cap( 'publish_stores' ); 

	// Delete
	$admins->add_cap( 'delete_store' ); 
	$admins->add_cap( 'delete_stores' ); 
	$admins->add_cap( 'delete_others_stores' ); 
	$admins->add_cap( 'delete_published_stores' ); 
	$admins->add_cap( 'delete_private_stores' ); 

}

/**
 * Store class.
 * All data and meta about queried store.
 * 
 * @return object.
 */
class hap_store {

    // PHP 8 fix
    public $id;
    public $title;
    public $url;
    public $slug;
    public $post_type;
    public $post_type_name;
    public $category;
    public $name;
    public $referent;
    public $address;
    public $email_1;
    public $email_2;
    public $pec_email;
    public $phone_1;
    public $phone_2;
    public $toll_free_phone;
    public $whatsapp;
    public $telegram;
    public $website_url;
    public $cf7_form;

	public function __construct($post_id) {

		// Handle errors
		if( !post_type_exists( 'store' ) ) {

			$this->error = __('Error! The post type "store" is not active. This class is available only for the post type "store".','hap');

		}elseif( get_post_type( $post_id ) != 'store' ) {

			$this->error = sprintf( __('Error! You have entered the id of a post of type "%s" but this function can only be used for posts of type "store".','hap'), get_post_type( $post_id ) );
			return;

		}

		// Vars
		if( taxonomy_exists( 'store-category' ) ) {

			$category = get_the_terms( $post_id, 'store-category' );

		}

		// ID
		$this->id = $post_id;
		// Title
		$this->title = get_the_title($this->id);
		// Url
		$this->url = get_the_permalink($this->id);
		// Slug
		$this->slug = get_post_field( 'post_name', $this->id );

		// Post type
			// Post type slug
			$this->post_type = 'store';
			// Post type name
			$this->post_type_name = __('Store','hap');

		// Taxonomies
		$this->category = ( $category ) ? $category : null;	

		// Store fields
		$this->name = get_field( 'store_name', $this->id );
		$this->referent = get_field( 'store_referent', $this->id );
		$this->address = get_field( 'store_address', $this->id );
		$this->email_1 = get_field( 'store_email_1', $this->id );
		$this->email_2 = get_field( 'store_email_2', $this->id );
		$this->pec_email = get_field( 'store_pec_email', $this->id );
		$this->phone_1 = get_field( 'store_phone_1', $this->id );
		$this->phone_2 = get_field( 'store_phone_2', $this->id );
		$this->toll_free_phone = get_field( 'store_toll_free_phone', $this->id );
		$this->whatsapp = get_field( 'store_whatsapp', $this->id );
		$this->telegram = get_field( 'store_telegram', $this->id );
		$this->website_url = get_field( 'store_website_url', $this->id );
		$this->cf7_form = get_field( 'store_cf7_form', $this->id );

	}

    /**
     * Get opening hours
     *
     * @return array $hours
     */
	public function hours() {
		$hours = get_field( 'store_hours', $this->id );
		return $hours;
	}

    /**
     *  Get formatted address
     *
     * @param string $format
     * @return string $address
     */
	public function address( $format = 'default' ) {
		$address = null;
		if( $format == 'short' ) {
			$address = $this->address['street_name'] . ' ' . $this->address['street_number'];
		}else {
			$address = $this->address['street_name'] . ' ' . $this->address['street_number'] . ' - ' . $this->address['city'];
		}
		return $address;
	}
	
	/**
     * Get Google Maps link
     *
     * @return string
     */
	public function gmap_link() {
		return get_gmap_link( $this->address );
	}
	
	/**
     * Get services
     *
     * @return array $services
     */
	public function services() {
		$services = get_field( 'store_services', $this->id );
		return $services;
	}
	
	/**
     * Get form shortcode
     *
     * @return string $form_shortcode
     */
	public function form_shortcode() {
		$form_shortcode = do_shortcode( '[contact-form-7 id="' . $this->cf7_form . '"]' );
		return $form_shortcode;
	}

	/**
     * Get gallery
     *
     * @return array $gallery
     */
	public function gallery() {
		$gallery = get_field( 'store_photo_gallery', $this->id );
		return $gallery;
	}

	/**
     * Get links
     *
     * @param string $key
     * @return string
     */
	public function links( $key ) {
		$links = [
			'email_1'		=>	'<a href="' .  esc_url( 'mailto:' . $this->email_1 ) . '">' . $this->email_1 . '</a>',
			'email_2'		=>	'<a href="' . esc_url( 'mailto:' . $this->email_2 ) . '">' . $this->email_2 . '</a>',
			'pec_email'		=>	'<a href="' . esc_url( 'mailto:' . $this->pec_email ) . '">' . $this->pec_email . '</a>',
			'phone_1'		=>	'<a href="tel:' . $this->phone_1 . '">' . $this->phone_1 . '</a>',
			'phone_2'		=>	'<a href="tel:' . $this->phone_2 . '">' . $this->phone_2 . '</a>',
			'toll_free_phone'=>	'<a href="tel:' . $this->toll_free_phone . '">' . $this->toll_free_phone . '</a>',
			'whatsapp'		=>	'<a href="' . esc_url( 'https://wa.me/' . $this->whatsapp ) . '">Whatsapp</a>',
			'telegram'		=>	'<a href="' .  esc_url( 'https://telegram.me/' . $this->telegram ) . '">Telegram</a>',
			'website_url'	=>	'<a href="' . esc_url( $this->website_url ) . '">' . hap_url_label( $this->email_1 ) . '</a>',
		];
		return $links[ $key ];
	}

    /**
     * Get category terms names
     * 
     * @param string $separator
     * @return array $names
     */
	public function cat_names( $separator = ', ' ) {
		if( !taxonomy_exists( 'store-category' ) ) {
			return;
		}
		$names = null;
		if( $this->category) {
			$names = implode( $separator, wp_list_pluck( $this->category, 'name' ) ); 
		}
		return $names;
	}

}

/**
 * Create a new store object.
 * 
 * @return object.
 */
function hap_get_store($post_id) {
	$store = new hap_store($post_id);
	return $store;
}