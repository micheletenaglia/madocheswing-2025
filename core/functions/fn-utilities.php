<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Constants and utility functions.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
   ____ ___  _   _ ____ _____  _    _   _ _____ ____  
  / ___/ _ \| \ | / ___|_   _|/ \  | \ | |_   _/ ___| 
 | |  | | | |  \| \___ \ | | / _ \ |  \| | | | \___ \ 
 | |__| |_| | |\  |___) || |/ ___ \| |\  | | |  ___) |
  \____\___/|_| \_|____/ |_/_/   \_\_| \_| |_| |____/ 

****************************************************************************************/

// Ajax Stuff
define('HAP_ADMIN_AJAX_URI', admin_url('admin-ajax.php'));

// Core Costants
define('HAP_CORE', get_template_directory() . '/core/');
define('HAP_CORE_URI', get_template_directory_uri() . '/core/');

define('HAP_CORE_FN', get_template_directory() . '/core/functions/');

define('HAP_CORE_TEMPLATES', get_template_directory() . '/core/templates/');

// define('HAP_CORE_CSS', get_template_directory() . '/core/assets/scss/');
define('HAP_CORE_CSS_URI', get_template_directory_uri() . '/core/assets/scss/');

define('HAP_CORE_JS', get_template_directory() . '/core/assets/js/');
define('HAP_CORE_JS_URI', get_template_directory_uri() . '/core/assets/js/');

define('HAP_CORE_IMG', get_template_directory() . '/core/assets/img/');
define('HAP_CORE_IMG_URI', get_template_directory_uri() . '/core/assets/img/');

define('HAP_CORE_BLOCKS', get_template_directory() . '/core/blocks/');
define('HAP_CORE_BLOCKS_URI', get_template_directory_uri() . '/core/blocks/');


// Project Costants
define('HAP_PROJECT', get_template_directory() . '/project/');
define('HAP_PROJECT_URI', get_template_directory_uri() . '/project/');

define('HAP_PROJECT_FN', get_template_directory() . '/project/functions/');

define('HAP_PROJECT_TEMPLATES', get_template_directory() . '/project/templates/');

define('HAP_PROJECT_CSS', get_template_directory() . '/project/assets/css/');
define('HAP_PROJECT_CSS_URI', get_template_directory_uri() . '/project/assets/css/');

define('HAP_PROJECT_JS', get_template_directory() . '/project/assets/js/');
define('HAP_PROJECT_JS_URI', get_template_directory_uri() . '/project/assets/js/');

define('HAP_PROJECT_IMG', get_template_directory() . '/project/assets/img/');
define('HAP_PROJECT_IMG_URI', get_template_directory_uri() . '/project/assets/img/');

define('HAP_PROJECT_BLOCKS', get_template_directory() . '/project/blocks/');
define('HAP_PROJECT_BLOCKS_URI', get_template_directory_uri() . '/project/blocks/');

// Server IP !!! Check
add_action('wp_ajax_hap_server_ip', 'hap_server_ip', 10, 1);
add_action('wp_ajax_nopriv_hap_server_ip', 'hap_server_ip', 10, 1);

// Update all posts !!! Check
add_action('wp_ajax_hap_update_all_posts', 'hap_update_all_posts', 10, 2);
add_action('wp_ajax_nopriv_hap_update_all_posts', 'hap_update_all_posts', 10, 2);

// add_action('wp_footer', 'hap_show_wp_load_stats');

/****************************************************************************************
  ____  _    _   _  ____ ___ _   _ ____  
 |  _ \| |  | | | |/ ___|_ _| \ | / ___| 
 | |_) | |  | | | | |  _ | ||  \| \___ \ 
 |  __/| |__| |_| | |_| || || |\  |___) |
 |_|   |_____\___/ \____|___|_| \_|____/ 
                                         
****************************************************************************************/

/**
 * Check if ACF is activated.
 *
 * @return boolean.
 */
function is_acf_activated() {
	return class_exists('acf') ? true : false;
}

/**
 * Check if WooCommerce is activated.
 *
 * @return boolean.
 */
function is_woocommerce_activated() {
	return class_exists('woocommerce') ? true : false;
}

/**
 * Check if WooCommerce Membership is activated.
 *
 * @return boolean.
 */
function is_woocommerce_membership_activated() {
	return class_exists('wc_memberships') ? true : false;
}

/**
 * Check if WooCommerce Subscription is activated.
 *
 * @return boolean.
 */
function is_woocommerce_subscription_activated() {
	return class_exists('wc_subscriptions') ? true : false;
}

/**
 * Check if FacetWP is activated.
 *
 * @return boolean.
 */
function is_facetwp_activated() {
	return class_exists('FacetWP') ? true : false;
}

/**
 * Check if WPML is activated.
 *
 * @return boolean.
 */
function is_wpml_activated() {
	return function_exists('icl_object_id') ? true : false;
}

/**
 * Check if Yoast Seo is activated.
 *
 * @return boolean.
 */
function is_yoast_activated() {
	return in_array('wordpress-seo/wp-seo.php', apply_filters( 'active_plugins', get_option( 'active_plugins') ) ) ? true : false;
}

/**
 * Check if Iubenda is activated.
 *
 * @return boolean.
 */
function is_iubenda_activated() {
	return in_array('iubenda-cookie-law-solution/iubenda_cookie_solution.php', apply_filters( 'active_plugins', get_option( 'active_plugins') ) ) ? true : false;
}

/**
 * Check if Contact Form 7 is activated.
 *
 * @return boolean.
 */
function is_cf7_activated() {
	return class_exists('WPCF7') ? true : false;
}

/**
 * Check if DK-PDF is activated.
 *
 * @return boolean.
 */
function is_dkpdf_activated() {
	return class_exists('DKPDF') ? true : false;
}

/**
 * Check if SG Security is activated.
 *
 * @return boolean.
 */
function is_sg_security_activated() {
	// if( class_exists('SG_Security') ) { 
    return is_plugin_active( 'sg-security/sg-security.php' ) ? true : false;
}

/**
 * Check if SG Supercacher is activated.
 *
 * @return boolean.
 */
function is_sg_supercacher_activated() {
	// if( class_exists('Supercacher') ) { 
    return is_plugin_active( 'sg-cachepress/sg-cachepress.php' ) ? true : false;
}

/**
 * Check if WP Rocket is activated.
 *
 * @return boolean.
 */
function is_wp_rocket_activated() {
	return is_plugin_active( 'wp-rocket/wp-rocket.php' ) ? true : false;
}

/**
 * Check if WP Supercache is activated.
 *
 * @return boolean.
 */
function is_wp_supercache_activated() {
	return function_exists('wpsc_init') ? true : false;
}

/**
 * Check if Wordfence is activated.
 *
 * @return boolean.
 */
function is_wordfence_activated() {
	return class_exists('wfWAFIPBlocksController') ? true : false;
}

/**
 * Check if Limit Login Attempts Reloaded is activated.
 *
 * @return boolean.
 */
function is_limit_login_attempts_activated() {
	// if( class_exists('Supercacher') ) { 
    return is_plugin_active( 'limit-login-attempts-reloaded/limit-login-attempts-reloaded.php' ) ? true : false;
}

/**
 * Check if Flamingo is activated.
 *
 * @return boolean.
 */
function is_flamingo_activated() {
	return class_exists('Flamingo_Contact') ? true : false;
}

/**
 * Check if GTM4WP is activated.
 *
 * @return boolean.
 */
function is_gtm4wp_activated() {
	return function_exists('gtm4wp_init') ? true : false;	
}

//======================================================================
// Media
//======================================================================

// !!! Read this https://wordpress.stackexchange.com/questions/312625/escaping-svg-with-kses

/**
 * Get SVG icon.
 * 
 * @param string $name
 * @param string $css_classes
 * @param string $path
 * @return string $svg
 */
function get_svg_icon( $name, $css_classes = 'svg-icon fill-current h-4', $path = 'core' ) {
	// Empty var
	$svg = '';
	// 1. Check if file exists 	
	if( $path == 'uploads' ) {
		// Set uploads directory path
		$path = ABSPATH . 'wp-content/uploads/';
	}elseif( $path == 'block-core' ) {
		// Set core block icons path
		$path = HAP_CORE . 'blocks/' . str_replace( '-preview', '', $name ) . '/';
	}elseif( $path == 'block-project' ) {
		// Set project block icons path
		$path = HAP_PROJECT . 'blocks/' . str_replace( '-preview', '', $name ) . '/';
	}elseif( $path == 'project' ) {
		// Set path to project
		$path = HAP_PROJECT . 'assets/icons/';
	}elseif( $path == 'core' ) {
		// Set default path
		$path = HAP_CORE . 'assets/icons/';
	}
	// Check if file exists
	if( file_exists( $path . $name . '.svg' ) ) {
		$svg = file_get_contents( $path . $name . '.svg' );
        // Sanitize attributes
        $svg = hap_sanitize_attrs($svg);
        // if string contains not allowed code
        if( !$svg ) {
            return;
        }
	}else{
		return;
	}
    // Remove unwanted content
    $svg = strstr( $svg, '<svg');
    // Add class attribute
    $attr = '<svg class="' . esc_attr($css_classes) . '"';
    $svg = str_replace( '<svg', $attr, $svg );
	return $svg;
}

/**
 * Get SVG img.
 * 
 * @param string $name
 * @param string $css_classes
 * @return string $svg
 */
function get_svg_img( $svg_id, $css_classes = 'svg-icon fill-current h-4' ) {
	// Check if file exists
	if( file_exists( wp_get_original_image_path($svg_id) ) ) {
		$svg = file_get_contents( wp_get_original_image_path($svg_id) );
        // Sanitize attributes
        $svg = hap_sanitize_attrs($svg);
        // if string contains not allowed code
        if( !$svg ) {
            return;
        }
	}else{
		return;
	}
    // Remove unwanted content
    $svg = strstr( $svg, '<svg');
    // Add class attribute
    $attr = '<svg class="' . esc_attr($css_classes) . '"';
    $svg = str_replace( '<svg', $attr, $svg );
	return $svg;
}

//======================================================================
// Custom locate template
//======================================================================

/**
 * Cascading template path.
 *
 * @param string $template_name
 * @param array $args
 * @return void
 */
function hap_get_template( $template_name, $args = [] ) {
	/*if( file_exists( HAP_PROJECT_TEMPLATES . $template_name . '.php' ) ) {
		include( HAP_PROJECT_TEMPLATES . $template_name . '.php' );
	}elseif( file_exists( HAP_CORE_TEMPLATES . $template_name . '.php' ) ) {	
		include( HAP_CORE_TEMPLATES . $template_name . '.php' );
	}*/
	if( file_exists( HAP_PROJECT_TEMPLATES . $template_name . '.php' ) ) {
		get_template_part( 'project/templates/' . $template_name, null, $args );
	}elseif( file_exists( HAP_CORE_TEMPLATES . $template_name . '.php' ) ) {
		get_template_part( 'core/templates/' . $template_name, null, $args );
	}
}

/**
 * This is used to verify attributes inside HTML tags.
 * !!! There is no common way to do this so this maybe not
 * the most secure solution to avoid XSS.
 *
 * @param string $string
 * @return string $string
 */
function hap_sanitize_attrs($string) {
    // Lowercase for better search
    $str_low = strtolower($string);
    // Check for malicious strings
    if( 
        // HTML tags
        str_contains( $str_low, '<html' )
        || str_contains( $str_low, '<body' )
        || str_contains( $str_low, '<script' )
        || str_contains( $str_low, '<object' )
        || str_contains( $str_low, '<iframe' )
        || str_contains( $str_low, '<applet' )
        || str_contains( $str_low, '<embed' )
        || str_contains( $str_low, '<form' )
        || str_contains( $str_low, '<input' )
        || str_contains( $str_low, '<button' )
        // PHP tags
        || str_contains( $str_low, '<?php' )
        // HTML attributes
        || str_contains( $str_low, 'onclick=' )
        || str_contains( $str_low, 'src=' )
        // Javascript
        || str_contains( $str_low, '$' )
        || str_contains( $str_low, '.write' )
        || str_contains( $str_low, 'function' )
        // Other
        || str_contains( $str_low, 'hidden' )
        || str_contains( $str_low, '"submit' )
        || str_contains( $str_low, 'entity' )
    ) {
        // Dump error
        write_log('Bad code in hap_sanitize_attrs(): ' . $string );
        $string = '';
    }
    // return htmlspecialchars( $string, ENT_NOQUOTES );
    return $string;
}

//======================================================================
// Arrays
//======================================================================

/**
 * Sanitize array.
 * 
 * @param array $array
 * @param string $type
 * @return array $sanitized_array
 */
function hap_sanitize_array( $array, $type = 'simple' ) {
	
	$sanitized_array = [];
	
	if( $type == 'simple' ) {
		foreach( $array as $item ) {
			$sanitized_array[] = sanitize_text_field($item);
		}
	}elseif( $type = 'indexed' ) {
		foreach( $array as $index => $value ) {
			$sanitized_array[sanitize_text_field($index)] = sanitize_text_field($value);
		}
	}

    return $sanitized_array;

}

/**
 * Check if all values in array are null.
 * 
 * @param array $array
 * @param string $type
 * @return boolean
 */
function hap_check_array_all_null( $array, $type = 'simple' ) {
	
	$check = 0;
	
	if( $type = 'simple' ) {
		foreach( $array as $item ) {
			if( $item ) {
				$check++;
			}
		}
	}elseif( $type = 'indexed' ) {
		foreach( $array as $index => $value ) {
			if( $value ) {
				$check++;
			}
		}
	}
	
	if( $check > 0 ) {
		$empty = false;
	}else{
		$empty = true;
	}

    return $empty;
	
}

/**
 * Remove keys from simple array.
 *
 * @param array $array
 * @param array $new_array
 * @return array $array
 */
function hap_remove_array_keys( $array, $new_array ) {
	
	if( $new_array ) {
		
		foreach( $new_array as $item ) {
			
			// Remove key
			if( ( $key = array_search( $item, $array ) ) !== false ) {
				unset( $array[$key] );
			}
			
		} 
	
	}
	
	return $array;
	
}

/**
 * Insert key in array in specific position.
 *
 * @param array $array
 * @param integer $position
 * @param mixed $value
 * @return array $new_array
 */
function hap_insert_key_in_position( $array, $position, $value ) {
		
	$new_array = array_merge(
		array_slice(
			$array, 
			0, 
			$position
		), 
		array(
			$value
		), 
		array_slice(
			$array, 
			$position
		)
	);

	return $new_array;
	
}

/**
 * Remove default files from an array of files created with scandir().
 *
 * @param array $values
 * @return array $clean_array
 */
function hap_scandir_remove_defaults( $values ) {
	
	$clean_array = [];
	
	$default_values = [
		'.',
		'..',
		'.DS_Store',
		'index.php'
	];
	
	// If array is not empty
	if( $values ) {
		// Loop through array
		foreach( $values as $value ) {
			// If current value is not in default values
			if( !in_array( $value, $default_values ) ) {
				// Add value to clean array
				$clean_array[] = $value;
			}
		}
	}
	
	return $clean_array;
	
}

/**
 * Check if array is simple or associative.
 *
 * @param array $array
 * @return boolean
 */
function has_string_keys( array $array ) {
	
	return count( array_filter(array_keys( $array ), 'is_string' ) ) > 0;

}

//======================================================================
// ACF
//======================================================================

/**
 * Array of ACF map data.
 *
 * @param array $address
 * @return array $address_data
 */
function hap_address_data( $address ) {

	$address_data = [
		$address['street_name'] . ' ' . $address['street_number'],
		$address['post_code'] . ' ' . $address['city'] . ' (' . $address['state_short'] . ')',
		$address['country'] . ' (' . $address['country_short'] . ')',
		'<a target="_blank" rel="noopener noreferrer nofollow" href="https://www.google.it/maps/place/' . $address['lat'] . ',' . $address['lng'] . '">' . __('Get directions','hap') . '</a>',
	];
	
	return $address_data;

}

//======================================================================
// Get data
//======================================================================

/**
 * Get logo.
 *
 * @param string $css_classes
 * @param string $version
 * @return string $logo
 */
function hap_get_logo( $css_classes = 'default', $version = 'light' ) {
	// Default value
	$logo = '';
	// Get field
	$field = 'logo_' . $version . '_mode';
	$logo_data = get_field($field,'options'); 
	// If field
	if( $logo_data ) {
		// Get CSS classes
		$logo_classes = ( $css_classes == 'default' ) ? $logo_data['css_classes'] : $css_classes;
		// If SVG file
		if( $logo_data['img']['subtype'] == 'svg' || $logo_data['img']['subtype'] == 'svg+xml' && $logo_data['svg_inline'] ) {
			$logo_file_name = get_file_name( $logo_data['img']['filename'] );
			$logo = get_svg_icon( $logo_file_name, esc_attr($logo_classes), 'uploads' );
		}else{
            $logo = hap_thumb( 
                $logo_data['img']['id'], 
                'full', 
                [
                    'return'    =>  true,
                    'lazy'      =>  false,
                    'img_class' =>  esc_attr($logo_classes),
                ] 
            );
		}
	}
	return $logo;
}

/**
 * Conditionally render blocks or post_content.
 *
 * @param integer $post_id
 * @return void
 */
function hap_get_content( $post_id ) {
	
	$object = get_post($post_id);
		
	if( $object ) {
		
		$blocks = parse_blocks( $object->post_content );
		
		if( $blocks ) {
			
			foreach( $blocks as $block ) {

				echo render_block( $block );
    
			}

		}else{
			
			echo $object->post_content;
		}
				
	}
	
}

/**
 * Get array of social media icons with links.
 *
 * @param string $style
 * @return array $icons
 */
function hap_get_social_media( $style = '' ) {

	$icons = [];

	$socials = [
		'facebook',
		'instagram',
		'tiktok',
		'youtube',
		'linkedin'
	];

	foreach( $socials as $social ) {

		if( get_field( $social, 'options' ) ) {

			$icons[] = '<a target="_blank" rel="noopener noreferrer nofollow" title="' . ucfirst( $social ) . '" href="' . esc_url( get_field( $social, 'options' ) ) . '">' . get_svg_icon( $social, $style ) . '</a>';

		}

	}

	return $icons;

}

/**
 * Get url from string.
 * 
 * @param string $string
 * @return string
 */ 
function hap_get_url_from_string( $string ) {

    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string, $match);

	return $match[0][0];
	
}

/**
 * Get post by slug.
 *
 * @param string $slug
 * @param string $post_type
 * @return object $post
 */
function hap_get_post_by_slug($slug, $post_type = 'page') {
	if( !$slug ) {
		return;
	}
	$post = get_posts([
		'numberposts'	=>	1,
		'name'			=>	$slug,
		'post_type'		=>	$post_type,
	]);
	if( $post ) {
		$post = $post[0];
	}else{
		$post = null;
	}
	return $post;
}

/**
 * Get public post types.
 *
 * @param string $format
 * @return array $cpts
 */
function hap_get_cpts( $format = 'objects' ) {
	// Default value
	$cpts = [];
    /*------------------------------------------------------*/
	// 1a. Args to get the list custom post types
	$cpt_args = [
		'public'                => true,
		'publicly_queryable'    => true,
		// 'exclude_from_search'	=> false,
		// 'show_in_rest'			=> true,
		// '_builtin'              => true, 
		// 'capability_type'    =>  true,
	];
	// 1b. Get the custom post type list (array of objects)
	$cpts = get_post_types( $cpt_args, 'objects' );
    /*------------------------------------------------------*/
	// 2a. Args to get the "page" post type which would otherwise be excluded
	$page_args = [
		'name' => 'page',
	];
	// 2b. Get the "page" post type (array of objects)
	$pages = get_post_types( $page_args, 'objects' );
    /*------------------------------------------------------*/
	// 3. Merge arrays
	$cpts = array_merge( $cpts, $pages );
    /*------------------------------------------------------*/
	// 4. Exclude media (attachemnts)
	unset( $cpts['attachment'] );
    /*------------------------------------------------------*/
	// Sort array by key
	ksort( $cpts );
    /*------------------------------------------------------*/
    // Return
	if( $format == 'string' ) {
		// Get labels
		$cpt_slug_label = [];
		foreach( $cpts as $slug => $object ) {
			$cpt_slug_label[$object->name] = $object->label;
		} 
		$cpts = $cpt_slug_label;
	}
	return $cpts;
}

/**
 * Get all theme templates.
 *
 * @return array $templates.
 */
function hap_get_all_templates() {
	// Default value
	$templates = [];
	// Get public post types
	$post_types = hap_get_cpts('string');
	// Loop posy types
	foreach( $post_types as $slug => $label ) {
		// Get post type templates
		$cpt_templates = wp_get_theme()->get_page_templates( null, $slug );
        // Add to main array
		$templates = array_merge( $cpt_templates, $templates );
	}
	// Sort array
	asort($templates);
	return $templates;
}

/**
 * Get script source by handle.
 *
 * https://stackoverflow.com/questions/56314360/get-scripts-url-by-handle-in-wordpress
 * 
 * @param string $handle
 * @return string $src
 */
function hap_get_script_src_by_handle( $handle ) {
    // Get enqueued scripts
	global $wp_scripts;
	// Default value
	$src = null;
    // If handle is in array
	if( in_array( $handle, $wp_scripts->queue ) ) {
        // Get source
		$src = $wp_scripts->registered[$handle]->src;
	}
	return $src;
}

/**
 * Get style source by handle.
 *
 * https://stackoverflow.com/questions/56314360/get-scripts-url-by-handle-in-wordpress
 * 
 * @param string $handle
 * @return string $src
 */
function hap_get_style_src_by_handle( $handle ) {
    // Get enqueued styles
	global $wp_styles;
	// Default value
	$src = null;
    // If handle is in array
	if( in_array( $handle, $wp_styles->queue ) ) {
        // Get source
		$src = $wp_styles->registered[$handle]->src;
	}
	return $src;
}

/**
 * Get WP roles.
 * 
 * @param string $role
 * @return string $selected_role
 */
function hap_get_role( $role ) {
	// Default role
	$selected_role = $role;
	// Default list of roles
	$roles = [
		// Default
		'administrator'	=>	__('Administrator','hap'),
		'editor'		=>	__('Editor','hap'),
		'author'		=>	__('Author','hap'),
		'contributor'	=>	__('Contributor','hap'),
		'subscriber'	=>	__('Subscriber','hap'),
		// Yoast
		'wpseo_editor'	=>	__('SEO Editor','hap'),
		'wpseo_manager'	=>	__('SEO Manager','hap'),	
		// Woocommerce
		'shop_manager'	=>	__('Shop Manager','hap'),
		'customer'		=>	__('Customer','hap'),
		'wpseo_editor'	=>	__('SEO Editor','hap'),
	];
	// Allow a filter to add other custom roles
	$roles = apply_filters('hap_get_roles',$roles);
	// If role exists
	if( array_key_exists( $role, $roles ) ) {
        // Update role
		$selected_role = $roles[$role];
	}
	return $selected_role;
}

/**
 * Get percentage.
 *
 * @param integer $total
 * @param integer $part
 * @param string $symbol
 * @return integer $percent
 */
function hap_get_percent( $total, $part, $symbol = '' ) {
    // Handle null values
	if( $total === 0 || $part === 0 ) {
        // Set default value
		$percent = 0;
	}else{
        // Calculate percentage
		$percent = ($part * 100) / $total;
	}
    // Handle errors
	if( is_infinite($percent) || is_nan($percent) ) {
        // Set default value
		$percent = 0;
    }else{
        // Format number
        $percent = number_format((float)$percent, 2, '.', '') . $symbol;
    }
	return $percent;
}

/**
 * Array key replace.
 *
 * @param string $item
 * @param string $replace_with
 * @param array $array
 * @return array $updated_array
 */
function array_key_replace( $item, $replace_with, $array ) {
	
	$updated_array = [];

	foreach ( $array as $key => $value ) {

		if( !is_array($value) && $key == $item ) {

			$updated_array = array_merge($updated_array, [$replace_with => $value]);

			continue;
		}

		$updated_array = array_merge($updated_array, [$key => $value]);
	}

	return $updated_array;

}

/**
 * Get the current time in unix format.
 * !!! This is really useless
 *
 * @param string $format
 * @return object $now
 */
function hap_get_current_time_unix( $format = 'Y-m-d H:i:s' ) {
    // Get timestamp
	$now = strtotime(current_time($format));
	return $now;
}

/**
 * Return author ID from display_name field.
 *
 * @param string $display_name
 * @return integer $user_id
 */
function hap_get_user_id_by_display_name( $display_name ) {
	// Get database global
	global $wpdb;
    // MySql query
	$query = "SELECT ID FROM {$wpdb->prefix}users WHERE `display_name` = '{$display_name}'";
	// Get user ID
	$user_id = (int)$wpdb->get_var( $wpdb->prepare( $query ) );
	return $user_id;
}

/**
 * Get JSON from url.
 * !!! It's better using wp_remote_get()
 *
 * @param string $url
 * @return object $obj
 */
function hap_get_json( $url ) {
    // Default value
	$obj  = null;
	// Get fiel content
	$json = file_get_contents( $url );
	// If content
	if( $json ) {
        // Convert in PHP
		$obj = json_decode($json);
	}	
	return $obj;
}

/**
 * Get file extension.
 *
 * @param string $file
 * @return string $extension
 */
function get_file_extension( $file = '' ) {
	// Convert string to array
	$tmp = explode('.', $file);
    // Get last item in array
	$extension = end($tmp);
	return $extension ? $extension : false;
}

/**
 * Get the file extension without period.
 * !!! Almost same as above, is this really needed?
 *
 * @param string $filename
 * @return string $extension
 */
function get_file_ext( $filename ) {
	$extension = preg_match('/\./', $filename) ? preg_replace('/^.*\./', '', $filename) : '';
	return $extension;
}

/**
 * Get file name without the extension.
 * !!! Probably basename() can do this job
 *
 * @param string $filename
 * @return string $filename_clean
 */
function get_file_name( $filename ) {
	$filename_clean = preg_replace('/.[^.]*$/', '', $filename);
	return $filename_clean;
}

/**
 * Get current url.
 * !!! This is not accurate
 *
 * @link https://wordpress.stackexchange.com/questions/274569/how-to-get-url-of-current-page-displayed
 * @return string $current_url.
 */
function get_current_url() {
	// Get WP
	global $wp;
	// Get URL
	$current_url = home_url(
        add_query_arg(
            [], 
            $wp->request
        )
    );
	return esc_url($current_url);	
}

/**
 * Get url from an img tag.
 * !!! To be verified
 *
 * @param string $input
 * @return string $source
 */
function get_img_src( $input ) {
	preg_match_all("/<img[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $input, $output);
	$return = [];
	if (isset($output[1][0])) {
		$return = $output[1];
	}
	foreach( (array) $return as $source ) {
		return $source . PHP_EOL;
	}
}

/**
 * Get url from an iframe.
 * !!! To be verified
 *
 * @param string $input
 * @return string $source
 */
function get_iframe_src( $input ) {
	preg_match_all('/<iframe[^>]+src="([^"]+)"/', $input, $output);
	$return = [];
	if (isset($output[1][0])) {
		$return = $output[1];
	}
	foreach ((array) $return as $source) {
		return $source . PHP_EOL;
	}
}

/**
 * Get youtube video image thumb URL from embed URL.
 *
 * @param string $url
 * @param string $size
 * @return string $img_url
 */
function get_youtube_thumb( $url, $size = 'hqdefault' ) {
    // Build image URL
    $img_url = esc_url( 'http://img.youtube.com/vi/' . str_replace('https://www.youtube.com/watch?v=','',$url ) . '/' . esc_attr($size) . '.jpg' );
    return $img_url;
}

/**
 * Get youtube video data URL from embed URL.
 *
 * @param string $url
 * @return null/array $data
 */
function get_youtube_data( $url ) {
    // Add arg to URL
    // https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=mIRhWB5XPLc&format=json
    $url = esc_url(add_query_arg(
        [
            'url'       =>  $url,
            'format'    =>  'json'
        ],
        'https://www.youtube.com/oembed'
    ));
    // Get JSON data
    $remote = wp_remote_get(
        $url,
        array(
            'timeout' => 10,
            'headers' => array(
                'Accept' => 'application/json'
            )
        )
    );
    // Check data
    if(
        is_wp_error( $remote )
        || 200 !== wp_remote_retrieve_response_code( $remote )
        || empty( wp_remote_retrieve_body( $remote ) )
    ) {
        return null;
    }
    // Convert JSON to PHP array
    $data = (array) json_decode($remote['body']);
    // Set minimum dimensions
    if( $data['width'] < 1920 ) {
        $height = intval( ( 1920 * $data['height'] ) / $data['width'] );
        $data['width'] = 1920;
        $data['height'] = $height;
    }
    return $data;
}

/**
 * Get true category set by Yoast
 *
 * @param integer $post_id
 * @return object $category
 */
function hap_yoast_true_category( $post_id ) {
	// Get true category asked by Yoast
	// if more than 1 term is set to the post
	$true_category = get_post_meta( $post_id, '_yoast_wpseo_primary_category',1 );

	// Conditionally get category
	if( $true_category ) {
		// Get category by true category field
		$category = get_term($true_category);
	}else{
		// Get normal category
		$category = get_the_terms( $post_id, 'category' );
		if( $category ) {
			$category = $category[0];
		}
	}
	return $category;
}

/**
 * Get WP table prefix.
 *
 * @return string $table_prefix.
 */
function hap_get_table_prefix() {
	// Get WP
	global $wpdb;
    // Get database prefix
	$table_prefix = $wpdb->prefix;
	return $table_prefix;
}

/**
 * Get an array of weekdays.
 *
 * @return string $weekdays.
 */
function hap_get_weekdays() {
    // List of weekdays
    $weekdays = [
		'monday'	=>	__('Monday','hap'),
        'tuesday'	=>	__('Tuesday','hap'),
        'wednesday'	=>	__('Wednesday','hap'),
        'thursday'	=>	__('Thursday','hap'),
        'friday'	=>	__('Friday','hap'),
        'saturday'	=>	__('Saturday','hap'),
        'sunday'	=>	__('Sunday','hap'),
    ];
	return $weekdays;
}

/**
 * Get an array of months.
 *
 * @return string $months.
 */
function hap_get_months() {
    // Months
    $months = [
        1   =>  __('January','hap'),
        2   =>  __('February','hap'),
        3   =>  __('March','hap'),
        4   =>  __('April','hap'),
        5   =>  __('May','hap'),
        6   =>  __('June','hap'),
        7   =>  __('July','hap'),
        8   =>  __('August','hap'),
        9   =>  __('September','hap'),
        10  =>  __('October','hap'),
        11  =>  __('November','hap'),
        12  =>  __('December','hap'),
    ];
	return $months;
}

/**
 * Get email signature.
 *
 * @return string $signature.
 */
function hap_get_email_signature( $logo_format = 'base64' ) {
    // Default value
	$signature = '';
	// Get logo
	$logo = get_field('logo_other_version','options');
    // If logo
	if( isset( $logo['img'] ) && !empty( $logo['img'] ) ) {
		// Get home URL
		$home_url = get_home_url();
		// Formats
		if( $logo_format == 'base64' ) {
            // Base 64
			$logo_img = hap_img_to_base64( $logo['img'] );
		}else{
			// Image
			$logo_img = wp_get_attachment_url( $logo['img'] );
		}
		// Start HTML
		$signature .= '<table class="cf7-signature" style="border: none; margin-top: 60px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 18px; color: #646464;">';
			$signature .= '<tbody>';
				$signature .= '<tr style="border: none;">';
					// Left cell
					$signature .= '<td style="padding: 0; border: none; vertical-align: top; width: ' . ( $logo['width'] + 40 ) . 'px">';
						// Logo
						$signature .= '<a href="' . $home_url . '" target="_blank" rel="noopener noreferrer nofollow">';
							$signature .= '<img width="' . $logo['width'] . '" height="' . $logo['height'] . '" src="' . $logo_img. '" style="width:' . $logo['width'] . 'px; height: ' . $logo['height'] . 'px;" />';
						$signature .= '</a>';
					$signature .= '</td>';
					// Right cell
					$signature .= '<td style="padding: 0; border: none;">';
						// Company name
						$signature .= ( get_field('company_name','options') ) ? '<strong style="color: #000;">' . get_field('company_name','options') . '</strong><br>' : null;
						// Address
						$signature .= ( get_field('address','options') ) ? get_field('address','options') . '<br>' : null;
						// City
						$signature .= ( get_field('city','options') ) ? get_field('city','options') . '<br>' : null;
						// Phone
						$signature .= ( get_field('phone','options') ) ? '<a style="color: #000; text-decoration: none;" href="tel:' . get_field('phone','options') . '">T. ' . get_field('phone','options') . '</a><br>' : null;
						// Mobile
						$signature .= ( get_field('mobile_phone','options') ) ? '<a style="color: #000; text-decoration: none;" href="tel:' . get_field('mobile_phone','options') . '">M. ' . get_field('mobile_phone','options') . '</a><br>' : null;
						// Website
						$signature .= '<a href="' . $home_url . '" target="_blank" rel="noopener noreferrer nofollow" style="color: #000; text-decoration: none; font-weight: bold;">' . hap_url_label($home_url) . '</a>';
					$signature .= '</td>';
				$signature .= '</tr>';
			$signature .= '</tbody>';
		$signature .= '</table>';
		// Discalimer
		if( get_field('email_disclaimer','options') ) {
			$signature .= '<p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #efefef; font-size: 12px; line-height: 18px;">' . get_field('email_disclaimer','options') . '</p>';
		}
	}
	return $signature;
}

/**
 * Get an array of continents names and codes.
 *
 * @return array/string $continents/$key.
 */
function hap_get_continents( $key = null) {
    // Continents
	$continents = [
		'AF' => __('Africa','hap'),
		'AS' => __('Asia','hap'),
		'AM' => __('America','hap'),
		'NA' => __('North America','hap'),
		'SA' => __('South America','hap'),
		'EU' => __('Europe','hap'),
		'OC' => __('Oceania','hap'),
		'AN' => __('Antarctica','hap'),
	];
	// If $key
	if( $key ) {	
		// // If $key exists in array
		if( array_key_exists( $key, $continents ) ) {
			// Return name
			return $continents[$key];
		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $continents;
	}
}

/**
 * Get an array of countries names and codes.
 *
 * @return $countries.
 */
function hap_get_countries( $key = null ) {
    // Countries
	$countries = [
		'AE' => __('United Arab Emirates','hap'),
		'AF' => __('Afghanistan','hap'),
		'AL' => __('Albania','hap'),
		'DZ' => __('Algeria','hap'),
		'AS' => __('American Samoa','hap'),
		'AD' => __('Andorra','hap'),
		'AO' => __('Angola','hap'),
		'AI' => __('Anguilla','hap'),
		'AQ' => __('Antarctica','hap'),
		'AG' => __('Antigua and Barbuda','hap'),
		'AR' => __('Argentina','hap'),
		'AM' => __('Armenia','hap'),
		'AW' => __('Aruba','hap'),
		'AU' => __('Australia','hap'),
		'AT' => __('Austria','hap'),
		'AZ' => __('Azerbaijan','hap'),
		'BS' => __('Bahamas','hap'),
		'BH' => __('Bahrain','hap'),
		'BD' => __('Bangladesh','hap'),
		'BB' => __('Barbados','hap'),
		'BY' => __('Belarus','hap'),
		'BE' => __('Belgium','hap'),
		'BZ' => __('Belize','hap'),
		'BJ' => __('Benin','hap'),
		'BM' => __('Bermuda','hap'),
		'BT' => __('Bhutan','hap'),
		'BO' => __('Bolivia','hap'),
		'BA' => __('Bosnia and Herzegovina','hap'),
		'BW' => __('Botswana','hap'),
		'BV' => __('Bouvet Island','hap'),
		'BR' => __('Brazil','hap'),
		'IO' => __('British Indian Ocean Territory','hap'),
		'BN' => __('Brunei Darussalam','hap'),
		'BG' => __('Bulgaria','hap'),
		'BF' => __('Burkina Faso','hap'),
		'BI' => __('Burundi','hap'),
		'KH' => __('Cambodia','hap'),
		'CM' => __('Cameroon','hap'),
		'CA' => __('Canada','hap'),
		'CV' => __('Cape Verde','hap'),
		'KY' => __('Cayman Islands','hap'),
		'CF' => __('Central African Republic','hap'),
		'TD' => __('Chad','hap'),
		'CL' => __('Chile','hap'),
		'CN' => __('China','hap'),
		'CX' => __('Christmas Island','hap'),
		'CC' => __('Cocos (Keeling) Islands','hap'),
		'CO' => __('Colombia','hap'),
		'KM' => __('Comoros','hap'),
		'CG' => __('Congo','hap'),
		'CD' => __('Democratic Republic of the Congo','hap'),
		'CK' => __('Cook Islands','hap'),
		'CR' => __('Costa Rica','hap'),
		'CI' => __('Ivory Coast','hap'),
		'HR' => __('Croatia','hap'),
		'CU' => __('Cuba','hap'),
		'CY' => __('Cyprus','hap'),
		'CZ' => __('Czech Republic','hap'),
		'DK' => __('Denmark','hap'),
		'DJ' => __('Djibouti','hap'),
		'DM' => __('Dominica','hap'),
		'DO' => __('Dominican Republic','hap'),
		'EC' => __('Ecuador','hap'),
		'EG' => __('Egypt','hap'),
		'SV' => __('El Salvador','hap'),
		'GQ' => __('Equatorial Guinea','hap'),
		'ER' => __('Eritrea','hap'),
		'EE' => __('Estonia','hap'),
		'ET' => __('Ethiopia','hap'),
		'FK' => __('Falkland Islands (Malvinas)','hap'),
		'FO' => __('Faroe Islands','hap'),
		'FJ' => __('Fiji','hap'),
		'FI' => __('Finland','hap'),
		'FR' => __('France','hap'),
		'GF' => __('French Guiana','hap'),
		'PF' => __('French Polynesia','hap'),
		'TF' => __('French Southern Territories','hap'),
		'GA' => __('Gabon','hap'),
		'GM' => __('Gambia','hap'),
		'GE' => __('Georgia','hap'),
		'DE' => __('Germany','hap'),
		'GB' => __('United Kingdom','hap'),
		'GH' => __('Ghana','hap'),
		'GI' => __('Gibraltar','hap'),
		'GR' => __('Greece','hap'),
		'GL' => __('Greenland','hap'),
		'GD' => __('Grenada','hap'),
		'GP' => __('Guadeloupe','hap'),
		'GU' => __('Guam','hap'),
		'GT' => __('Guatemala','hap'),
		'GN' => __('Guinea','hap'),
		'GW' => __('Guinea-Bissau','hap'),
		'GY' => __('Guyana','hap'),
		'HT' => __('Haiti','hap'),
		'HM' => __('Heard Island and Mcdonald Islands','hap'),
		'VA' => __('Vatican City State','hap'),
		'HN' => __('Honduras','hap'),
		'HK' => __('Hong Kong','hap'),
		'HU' => __('Hungary','hap'),
		'IS' => __('Iceland','hap'),
		'IN' => __('India','hap'),
		'ID' => __('Indonesia','hap'),
		// 'IR' => __('Iran, Islamic Republic of','hap'),
		'IR' => __('Iran','hap'),
		'IQ' => __('Iraq','hap'),
		'IE' => __('Ireland','hap'),
		'IL' => __('Israel','hap'),
		'IT' => __('Italy','hap'),
		'JM' => __('Jamaica','hap'),
		'JP' => __('Japan','hap'),
		'JO' => __('Jordan','hap'),
		'KZ' => __('Kazakhstan','hap'),
		'KE' => __('Kenya','hap'),
		'KI' => __('Kiribati','hap'),
		// 'KP' => __('Korea, Democratic People\'s Republic of','hap'),
		'KP' => __('North Korea','hap'),
		// 'KR' => __('Korea, Republic of','hap'),
		'KR' => __('South Korea','hap'),
		'KW' => __('Kuwait','hap'),
		'KG' => __('Kyrgyzstan','hap'),
		// 'LA' => __('Lao People\'s Democratic Republic','hap'),
		'LA' => __('Laos','hap'),
		'LV' => __('Latvia','hap'),
		'LB' => __('Lebanon','hap'),
		'LS' => __('Lesotho','hap'),
		'LR' => __('Liberia','hap'),
		'LY' => __('Libyan Arab Jamahiriya','hap'),
		'LI' => __('Liechtenstein','hap'),
		'LT' => __('Lithuania','hap'),
		'LU' => __('Luxembourg','hap'),
		'MO' => __('Macao','hap'),
		// 'MK' => __('Macedonia, the Former Yugoslav Republic of','hap'),
		// 'MK' => __('Republic of North Macedonia','hap'),
		'MK' => __('North Macedonia','hap'),
		'MG' => __('Madagascar','hap'),
		'MW' => __('Malawi','hap'),
		'MY' => __('Malaysia','hap'),
		'MV' => __('Maldives','hap'),
		'ML' => __('Mali','hap'),
		'MT' => __('Malta','hap'),
		'MH' => __('Marshall Islands','hap'),
		'MQ' => __('Martinique','hap'),
		'MR' => __('Mauritania','hap'),
		'MU' => __('Mauritius','hap'),
		'YT' => __('Mayotte','hap'),
		'MX' => __('Mexico','hap'),
		// 'FM' => __('Micronesia, Federated States of','hap'),
		'FM' => __('Federated States of Micronesia','hap'),
		// 'MD' => __('Moldova, Republic of','hap'),
		'MD' => __('Moldova','hap'),
		'MC' => __('Monaco','hap'),
		'MN' => __('Mongolia','hap'),
		'MS' => __('Montserrat','hap'),
		'MA' => __('Morocco','hap'),
		'MZ' => __('Mozambique','hap'),
		'MM' => __('Myanmar','hap'),
		'NA' => __('Namibia','hap'),
		'NR' => __('Nauru','hap'),
		'NP' => __('Nepal','hap'),
		'NL' => __('Netherlands','hap'),
		'AN' => __('Netherlands Antilles','hap'),
		'NC' => __('New Caledonia','hap'),
		'NZ' => __('New Zealand','hap'),
		'NI' => __('Nicaragua','hap'),
		'NE' => __('Niger','hap'),
		'NG' => __('Nigeria','hap'),
		'NU' => __('Niue','hap'),
		'NF' => __('Norfolk Island','hap'),
		'MP' => __('Northern Mariana Islands','hap'),
		'NO' => __('Norway','hap'),
		'OM' => __('Oman','hap'),
		'PK' => __('Pakistan','hap'),
		'PW' => __('Palau','hap'),
		// 'PS' => __('Palestinian Territory, Occupied','hap'),
		// 'PS' => __('Palestine, State of','hap'),
		'PS' => __('Palestine','hap'),
		'PA' => __('Panama','hap'),
		'PG' => __('Papua New Guinea','hap'),
		'PY' => __('Paraguay','hap'),
		'PE' => __('Peru','hap'),
		'PH' => __('Philippines','hap'),
		'PN' => __('Pitcairn','hap'),
		'PL' => __('Poland','hap'),
		'PT' => __('Portugal','hap'),
		'PR' => __('Puerto Rico','hap'),
		'QA' => __('Qatar','hap'),
		'RE' => __('Reunion','hap'),
		'RO' => __('Romania','hap'),
		'RU' => __('Russian Federation','hap'),
		'RW' => __('Rwanda','hap'),
		'SH' => __('Saint Helena','hap'),
		'KN' => __('Saint Kitts and Nevis','hap'),
		'LC' => __('Saint Lucia','hap'),
		'PM' => __('Saint Pierre and Miquelon','hap'),
		'VC' => __('Saint Vincent and the Grenadines','hap'),
		'WS' => __('Samoa','hap'),
		'SM' => __('San Marino','hap'),
		'ST' => __('Sao Tome and Principe','hap'),
		'SA' => __('Saudi Arabia','hap'),
		'SN' => __('Senegal','hap'),
		'CS' => __('Serbia and Montenegro','hap'),
		'SC' => __('Seychelles','hap'),
		'SL' => __('Sierra Leone','hap'),
		'SG' => __('Singapore','hap'),
		'SK' => __('Slovakia','hap'),
		'SI' => __('Slovenia','hap'),
		'SB' => __('Solomon Islands','hap'),
		'SO' => __('Somalia','hap'),
		'ZA' => __('South Africa','hap'),
		'GS' => __('South Georgia and the South Sandwich Islands','hap'),
		'ES' => __('Spain','hap'),
		'LK' => __('Sri Lanka','hap'),
		'SD' => __('Sudan','hap'),
		'SR' => __('Suriname','hap'),
		'SJ' => __('Svalbard and Jan Mayen','hap'),
		'SZ' => __('Swaziland','hap'),
		'SE' => __('Sweden','hap'),
		'CH' => __('Switzerland','hap'),
		// 'SY' => __('Syrian Arab Republic','hap'),
		'SY' => __('Syria','hap'),
		'TW' => __('Taiwan','hap'),
		// 'TW' => __('Taiwan, Province of China','hap'),
		'TJ' => __('Tajikistan','hap'),
		'TZ' => __('Tanzania, United Republic of','hap'),
		'TH' => __('Thailand','hap'),
		'TL' => __('Timor-Leste','hap'),
		'TG' => __('Togo','hap'),
		'TK' => __('Tokelau','hap'),
		'TO' => __('Tonga','hap'),
		'TT' => __('Trinidad and Tobago','hap'),
		'TN' => __('Tunisia','hap'),
		'TR' => __('Turkey','hap'),
		'TM' => __('Turkmenistan','hap'),
		'TC' => __('Turks and Caicos Islands','hap'),
		'TV' => __('Tuvalu','hap'),
		'UG' => __('Uganda','hap'),
		'UA' => __('Ukraine','hap'),
		'US' => __('United States','hap'),
		'UM' => __('United States Minor Outlying Islands','hap'),
		'UY' => __('Uruguay','hap'),
		'UZ' => __('Uzbekistan','hap'),
		'VU' => __('Vanuatu','hap'),
		'VE' => __('Venezuela','hap'),
		'VN' => __('Viet Nam','hap'),
		'VG' => __('Virgin Islands, British','hap'),
		'VI' => __('Virgin Islands, US','hap'),
		'WF' => __('Wallis and Futuna','hap'),
		'EH' => __('Western Sahara','hap'),
		'YE' => __('Yemen','hap'),
		'ZM' => __('Zambia','hap'),
		'ZW' => __('Zimbabwe','hap'),
	];
	// If $key
	if( $key ) {
		// // If $key exists in array
		if( array_key_exists( $key, $countries ) ) {
			// Return name
			return $countries[$key];

		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $countries;
	}
}

/**
 * Get an array of italian regions.
 *
 * @return $regions.
 */
function hap_get_italian_regions( $key = null ) {
    // Regions
	$regions = [
		'abruzzo'				=> __('Abruzzo','hap'), 
		'basilicata'			=> __('Basilicata','hap'), 
		'calabria'				=> __('Calabria','hap'), 
		'campania'				=> __('Campania','hap'), 
		'emilia-romagna'		=> __('Emilia-Romagna','hap'), 
		'friuli-venezia-giulia'	=> __('Friuli Venezia Giulia','hap'), 
		'lazio'					=> __('Lazio','hap'), 
		'liguria'				=> __('Liguria','hap'), 
		'lombardia'				=> __('Lombardy','hap'), 
		'marche'				=> __('Marche','hap'), 
		'molise'				=> __('Molise','hap'), 
		'piemonte'				=> __('Piedmont','hap'), 
		'puglia'				=> __('Apulia','hap'), 
		'sardegna'				=> __('Sardinia','hap'), 
		'sicilia'				=> __('Sicily','hap'), 
		'toscana'				=> __('Tuscany','hap'), 
		'umbria'				=> __('Umbria','hap'), 
		'valle-d-aosta'			=> __('Aosta Valley','hap'),  
		'veneto'				=> __('Veneto', 'hap'), 
		'trentino-alto-adige'	=> __('Trentino-Alto Adige','hap'), 
	];
	// If $key
	if( $key ) {	
		// // If $key exists in array
		if( array_key_exists( $key, $regions ) ) {
			// Return name
			return $regions[$key];
		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $regions;
	}
}

/**
 * Get an array of italian provinces.
 *
 * @return $provinces.
 */
function hap_get_italian_provinces( $key = null ) {
	// Provinces
	$provinces = [
		'AG'	=> __('Agrigento','hap'),
		'AL'	=> __('Alessandria','hap'),
		'AN'	=> __('Ancona','hap'),
		'AO'	=> __('Aosta','hap'),
		'AR'	=> __('Arezzo','hap'),
		'AP'	=> __('Ascoli Piceno','hap'),
		'AT'	=> __('Asti','hap'),
		'AV'	=> __('Avellino','hap'),
		'BA'	=> __('Bari','hap'),
		'BT'	=> __('Barletta-Andria-Trani','hap'),
		'BL'	=> __('Belluno','hap'),
		'BN'	=> __('Benevento','hap'),
		'BG'	=> __('Bergamo','hap'),
		'BI'	=> __('Biella','hap'),
		'BO'	=> __('Bologna','hap'),
		'BZ'	=> __('Bolzano','hap'),
		'BS'	=> __('Brescia','hap'),
		'BR'	=> __('Brindisi','hap'),
		'CA'	=> __('Cagliari','hap'),
		'CL'	=> __('Caltanissetta','hap'),
		'CB'	=> __('Campobasso','hap'),
		'CE'	=> __('Caserta','hap'),
		'CT'	=> __('Catania','hap'),
		'CZ'	=> __('Catanzaro','hap'),
		'CH'	=> __('Chieti','hap'),
		'CO'	=> __('Como','hap'),
		'CS'	=> __('Cosenza','hap'),
		'CR'	=> __('Cremona','hap'),
		'KR'	=> __('Crotone','hap'),
		'CN'	=> __('Cuneo','hap'),
		'EN'	=> __('Enna','hap'),
		'FM'	=> __('Fermo','hap'),
		'FE'	=> __('Ferrara','hap'),
		'FI'	=> __('Florence','hap'),
		'FG'	=> __('Foggia','hap'),
		'FC'	=> __('Forlì-Cesena','hap'),
		'FR'	=> __('Frosinone','hap'),
		'GE'	=> __('Genova','hap'),
		'GO'	=> __('Gorizia','hap'),
		'GR'	=> __('Grosseto','hap'),
		'IM'	=> __('Imperia','hap'),
		'IS'	=> __('Isernia','hap'),
		'SP'	=> __('La Spezia','hap'),
		'AQ'	=> __('L\'Aquila','hap'),
		'LT'	=> __('Latina','hap'),
		'LE'	=> __('Lecce','hap'),
		'LC'	=> __('Lecco','hap'),
		'LI'	=> __('Livorno','hap'),
		'LO'	=> __('Lodi','hap'),
		'LU'	=> __('Lucca','hap'),
		'MC'	=> __('Macerata','hap'),
		'MN'	=> __('Mantua','hap'),
		'MS'	=> __('Massa and Carrara','hap'),
		'MT'	=> __('Matera','hap'),
		'ME'	=> __('Messina','hap'),
		'MI'	=> __('Milan','hap'),
		'MO'	=> __('Modena','hap'),
		'MB'	=> __('Monza and Brianza','hap'),
		'NA'	=> __('Naples','hap'),
		'NO'	=> __('Novara','hap'),
		'NU'	=> __('Nuoro','hap'),
		'OR'	=> __('Oristano','hap'),
		'PD'	=> __('Padua','hap'),
		'PA'	=> __('Palermo','hap'),
		'PR'	=> __('Parma','hap'),
		'PV'	=> __('Pavia','hap'),
		'PG'	=> __('Perugia','hap'),
		'PU'	=> __('Pesaro and Urbino','hap'),
		'PE'	=> __('Pescara','hap'),
		'PC'	=> __('Piacenza','hap'),
		'PI'	=> __('Pisa','hap'),
		'PT'	=> __('Pistoia','hap'),
		'PN'	=> __('Pordenone','hap'),
		'PZ'	=> __('Potenza','hap'),
		'PO'	=> __('Prato','hap'),
		'RG'	=> __('Ragusa','hap'),
		'RA'	=> __('Ravenna','hap'),
		'RC'	=> __('Reggio Calabria','hap'),
		'RE'	=> __('Reggio Emilia','hap'),
		'RI'	=> __('Rieti','hap'),
		'RN'	=> __('Rimini','hap'),
		'RM'	=> __('Rome','hap'),
		'RO'	=> __('Rovigo','hap'),
		'SA'	=> __('Salerno','hap'),
		'SS'	=> __('Sassari','hap'),
		'SV'	=> __('Savona','hap'),
		'SI'	=> __('Siena','hap'),
		'SR'	=> __('Syracuse','hap'),
		'SO'	=> __('Sondrio','hap'),
		'SU'	=> __('South Sardinia','hap'),
		'TA'	=> __('Taranto','hap'),
		'TE'	=> __('Teramo','hap'),
		'TR'	=> __('Terni','hap'),
		'TO'	=> __('Turin','hap'),
		'TP'	=> __('Trapani','hap'),
		'TN'	=> __('Trento','hap'),
		'TV'	=> __('Treviso','hap'),
		'TS'	=> __('Trieste','hap'),
		'UD'	=> __('Udine','hap'),
		'VA'	=> __('Varese','hap'),
		'VE'	=> __('Venice','hap'),
		'VB'	=> __('Verbano-Cusio-Ossola','hap'),
		'VC'	=> __('Vercelli','hap'),
		'VR'	=> __('Verona','hap'),
		'VV'	=> __('Vibo Valentia','hap'),
		'VI'	=> __('Vicenza','hap'),
		'VT'	=> __('Viterbo','hap'),
	];
	// If $key
	if( $key ) {	
		// // If $key exists in array
		if( array_key_exists( $key, $provinces ) ) {
			// Return name
			return $provinces[$key];
		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $provinces;
	}
}

//======================================================================
// Check data
//======================================================================

/**
 * Check if a url is from youtube, vimeo or facebook.
 *
 * @param string $url
 * @param string $provider
 * @return boolean
 */
function is_url_from($url, $provider = 'youtube') {
	
	if (strpos($url, $provider) > 0) {
	
		return true;
	
	}

}

/**
 * Check if a value of a key is in an array.
 *
 * @param string $array_key
 * @param string $value
 * @param array $array
 * @return boolean
 */
function is_in_array( $array_key, $value, $array) {
	
	foreach( $array as $key => $val ) {
		
		if ($val[$array_key] === $value) {
			
			return true;
		
		}
	
	}

	return null;

}

/**
 * Check if a date is a weekend day.
 *
 * @param object $date
 * @return boolean
 */
function is_weekend( $date ) {
	
	return ( date('N', strtotime($date) ) >= 6) ? true : false;

}


/**
 * Check if a date is saturday.
 *
 * !!! Fare come funzione is_weekend
 *
 * @param object $date
 * @return boolean
 */
function is_saturday( $date ) {
	
	$weekday = date('l', strtotime($date));

	return ( 'Saturday' == $weekday ) ? true : false;
	
}

/**
 * Check if a date is sunday.
 *
 * !!! Fare come funzione is_weekend
 *
 * @param object $date
 * @return boolean
 */
function is_sunday( $date ) {
	
	$weekday = date('l', strtotime($date));

	return ('Sunday' == $weekday) ? true : false;

}

/**
 * Get number of months between two dates.
 *
 * @param string $date1
 * @param string $date2
 * @return integer $counter
 */
function hap_months_counter( $date_1, $date_2 ) {
	
	$start = new DateTime( $date_1 );
	$end = new DateTime( $date_2 );
	$end = $end->modify( '+1 month' );

	$interval = DateInterval::createFromDateString('1 month');

	$period = new DatePeriod( $start, $interval, $end );
	$counter = 0;
	
	foreach( $period as $dt ) {
		
		++$counter;

	}

	return $counter;
	
}

/**
 * Check if post is in a menu.
 *
 * @param integer $menu: int post object id of page
 * @param  integer $object_id: int post object id of page
 * @return boolean true if object is in menu
 */
function hap_post_is_in_menu( $menu = null, $object_id = null ) {

    // Get menu object
    $menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );

    // Stop if there isn't a menu
    if( ! $menu_object )
        return false;

    // Get the object_id field out of the menu object
    $menu_items = wp_list_pluck( $menu_object, 'object_id' );

    // Use the current post if object_id is not specified
    if( !$object_id ) {
        global $post;
        $object_id = get_queried_object_id();
    }

    // Test if the specified page is in the menu or not. return true or false.
    return in_array( (int) $object_id, $menu_items );

}

//======================================================================
// Format data
//======================================================================

/**
 * Implode array of post IDs in list items 
 * or string separated by custom glyph.
 *
 * @param array $ids
 * @param string $format
 * @param string $field
 * @return string $list
 */
function hap_ids_to_list( $ids, $format, $field = null ) {
			
	$list = [];
	if( $ids ) { 
		foreach( $ids as $item ) { 
			if( $field ) {
				$list[] = get_field( $field, $item );				
			}else{
				$list[] = get_the_title( $item );
			}
		}
		if( $format == 'list' ) {
			$list = '<li>' . implode( '</li><li>', $list ) . '</li>';
		}else {
			$list = implode( $format, $list );
		}
	}else{
		$list = '<span class="text-error font-bold">' . __('Error! No data.','hap') . '</span>';
	}
	
	return $list;

}

/**
 * Get term list in array.
 * 
 * @param integer $post_id
 * @param string/array $tax
 * @return array $list
 */ 
function get_term_list( $post_id, $tax ) {
	
	$terms = get_the_terms( $post_id, $tax );
	
	$list = [];
	
	if( $terms ) {
		
		foreach( $terms as $term ) {
			
			$list['names'] = $term->name;
			$list['slugs'] = $term->slug;

		}
		
	}
	
	return $list;

}

/**
 * Extract acronym with first letters of a string.
 *
 * @param array $words
 * @return string $acronym
 */
function hap_acronym( $words ) {
	
	$words = explode(' ',$words);
	$acronym = "";
	foreach ($words as $w) {
		$acronym .= mb_substr($w, 0, 1);
	}
	
	return $acronym;
	
}

/**
 * Money format 10,00 €.
 * 
 * @param integer $value
 * @param string $language
 * @param string $currency
 * @return string $formatted_value
 */ 
function euro_format( $value, $language = 'it_IT', $currency = 'EUR' ) {
    // If value is zero
	if( $value == 0 ) {
		// !!! This should be handled better
		$formatted_value = '0,00 ' . $currency;
	}else{
        // Format number class
		$fmt = new NumberFormatter( $language, NumberFormatter::CURRENCY );
        // FOrmat number
		$formatted_value = $fmt->formatCurrency( $value, $currency);
	}
	return $formatted_value;
}

/**
 * Return url without http, https and www.
 *
 * @return $url.
 */
function hap_url_label($url) {
	// Find in string
	$find = [
		'https',
		'http',
		'://',
		'www.'
	];
	// Replace each with
	$replace = [
		'',
		'',
		'',
		''		
	];
	// Manipulate string
	$url = str_replace( $find, $replace, $url );
	// Remove last '/'
	$url = rtrim( $url, '/');
	return $url;
}

/**
 * Format phone number.
 *
 * @param string $number
 * @param integer $local_prefix_size
 * @param integer $prefix_int
 * @return object $phone
 */
function hap_phone_format( $number, $local_prefix_size = 3, $prefix_int = '' ) {
	// URL ofr links
	$url = 'tel:' . $number;
	// Label
	// Remove international prefix
	$label = str_replace( $prefix_int, '', $number );
	// Format local prefix
	$label = substr( $label, 0, $local_prefix_size ) . ' ' . substr( $label, $local_prefix_size );
	// Retuen values
	$phone = [
		'url'	=>	$url,
		'label'	=>	$label,
	];
	return (object) $phone;
}

/**
 * Format file size according to size.
 *
 *
 * @param integer $file_size
 * @return string $formatted_value
 */
function hap_format_file_size( $file_size ) {
    // Default value
	$formatted_value = null;
    if( $file_size < 1024 ) {
        // Bytes
        $formatted_value = $file_size . 'bytes';
    }else if( $file_size < 1024000 ) {
        // Kilobytes
		$formatted_value =  round( ( $file_size / 1024 ), 1 ) . 'kb';
    }else{
        // Megabytes
        $formatted_value =  round( ( $file_size / 1024000 ), 1 ) . 'Mb';
    }
	return $formatted_value;
}

/**
 * Convert a string to float and replace commas with dots.
 *
 * Example:
 * 10,0 -> 10.0
 *
 * @return $value
 */
function string_to_float_comma_to_dot( $value ) {
    // Convert string to float and replace dots with commas
	$float = (float)str_replace(',', '.', $value);
	return $float;
}

/**
 * Generate random string of a given number of characters.
 *
 * @param integer $length
 * @return string $randomString
 */
function hap_generate_random_string( $length = 25 ) {
	// Set of characters
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // String length
	$charactersLength = strlen($characters);
    // Default value
	$randomString = '';
    // Loop
	for( $i = 0; $i < $length; $i++ ) {
        // Build random string
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

/**
 * Minify HTML output code.
 *
 * @param string $buffer
 * @return string $buffer
 */
function hap_minifier( $buffer ) {
    // Search
    $search = [
        '/\>[^\S ]+/s',     // Strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // Strip whitespaces before tags, except space
        '/(\s)+/s',         // Shorten multiple whitespace sequences
        // '/<!--(.|\s)*?-->/' // Remove HTML comments
    ];
    // Replace
    $replace = [
        '>',
        '<',
        '\\1',
        ''
    ];
    // Replace
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

/**
 * Convert an image to base64.
 *
 * https://stackoverflow.com/questions/3967515/how-to-convert-an-image-to-base64-encoding
 * @param integer $img_id
 * @param string $path
 * @return string $base64
 *
 * Example:
 * <img src="<?php echo hap_img_to_base64(123); ?>" width="" height="" alt="" style="" />
 */
function hap_img_to_base64( $img_id = null, $path = null) {
	// Default value
	$base64 = null;
	// If $img_id get attachment path
	if( $img_id ) {
		$path = get_attached_file( $img_id );
	}
	// Get file extension
	$type = pathinfo($path, PATHINFO_EXTENSION);
	// Get file content
	$data = file_get_contents($path);
	// If is a SVG file
	if( $type === 'svg' ) {
		$base64 = 'data:image/svg+xml;base64,' . base64_encode($data); 
	// If is a PNG or JPG file
	}else{
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	}
	return $base64;
}

/**
 * Transform HTML table to PHP array
 *
 * @param string $table
 * @param integer $start
 * @param integer $end
 * @return array $new_data
 */
function html_table_to_array( $table, $start = 0, $end = null ) {
    // Create new HTML document
    $dom = new DOMDocument();
    // Add meta to preserve the original characters
    $content_type = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    // Load HTML
    $dom->loadHTML( $content_type . $table );
    // Save HTML
    $dom->saveHTML();
    // Get table th
    $ths = $dom->getElementsByTagName('th');
    // Get table td
    $tds = $dom->getElementsByTagName('td');
    // Get header name of the table
    foreach( $ths as $node_header ) {
        $data[] = trim($node_header->textContent);
    }
    // Get row data/detail table without header name as key
    $i = 0;
    $j = 0;
    // Default values
    $new_data = [];
    $temp_data = [];
    foreach( $tds as $node_detail ) {
        $new_data[$j][] = trim($node_detail->textContent);
        $i = $i + 1;
        $j = $i % count($data) == 0 ? $j + 1 : $j;
        // Increment index
    }
    // Index
    $index = 0;
    // Get row data/detail table with header name as key and outer array index as row number
    for( $i = 0; $i < count($new_data); $i++ ) {
        // Check and skip iteration
        if( $start > $index ) {
            $index++;
            continue;
        }
        for($j = 0; $j < count($data); $j++) {
            $temp_data[$i][$data[$j]] = $new_data[$i][$j];
        }
        $index++;
        // Check and break loop
        if( $end !== null && $end < $index ) {
            break;
        }
    }
    // Clean new data
    $new_data = $temp_data; 
    unset($temp_data);
    return $new_data;
}

//======================================================================
// APIs
//======================================================================

/**
 * Get Google Maps object.
 * Requested through Google Maps Web Service.
 *
 * https://stackoverflow.com/questions/23212681/php-get-latitude-longitude-from-an-address
 * See answer by FahadKhan
 *
 * @param string $address
 * @return array $acf_map
 */
function hap_get_gmap_object($address) {

	// Default value
	$acf_map = null;
	
	// Prepare address string to be emebedded in url by replacing spaces with plus
	$prepAddr = str_replace(' ','+',$address); // !!! This is not used anywhere
	
	// Get Google Maps APi Key
	// The key must have set IP address as restriction,
	// it won't work with restriction by HTTP referrer,
	// this means that you need two different Api Keys.
	// Places API must be activated.
	$apiKey = get_field('google_maps_api_key_web_service','options');

	// Request data
	$geocode = file_get_contents(
		'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=' . $apiKey
	);

	// Decode json
	$output = json_decode($geocode);
	
	if( $output->results ) {
		
		$map_data = $output->results[0];

		// Populate array for ACF map
		$acf_map = [
			'address'			=>	$map_data->formatted_address,
			'lat'				=>	$map_data->geometry->location->lat,
			'lng'				=>	$map_data->geometry->location->lng,
			'zoom'				=>	14,
			'place_id'			=>	$map_data->place_id,
			'street_number'		=>	$map_data->address_components[0]->long_name,
			'street_name'		=>	$map_data->address_components[1]->long_name,
			'street_name_short' =>	$map_data->address_components[1]->short_name,
			'city'				=>	$map_data->address_components[2]->long_name,
			'state'				=>	$map_data->address_components[4]->long_name,
			'state_short'		=>	$map_data->address_components[4]->short_name,
			'post_code'			=>	$map_data->address_components[7]->long_name,
			'country'			=>	$map_data->address_components[6]->long_name,
			'country_short'		=>	$map_data->address_components[6]->short_name,
		];
		
	}

	return $acf_map;

}

//======================================================================
// Cookies
//======================================================================

/**
 * Get/set a cookie in WordPress.
 *
 * This function returns a cookie value when only the $key is passed, 
 * or sets a cookie when both the $key and $value are passed.
 *
 *
 * @param string $key The cookie name/key
 * @param string $value Optional. The cookie value
 * @param string|int $expiration  Optional. Timestamp when the cookie expires
 * @return boolean|string|int The cookie value if only the $key is passed, true is successfully set a cookie, false otherwise
 */
function hap_cookie( $key, $value = false, $expiration = false ) {

   if ( $value ) {

	   // Set a cookie
	   if( !is_admin() ) {

		   setcookie( 
			   $key, 
			   $value, 
               [
				   'expires'	=>	time()+$expiration,
				   'path'		=>	COOKIEPATH,
				   'domain'		=>	COOKIE_DOMAIN,
				   'secure'		=>	true,
				   'httponly'	=>	true,
				   'samesite'	=>	'None',
				]
			);
		   
	   }

   }else{
	   
	   return isset( $_COOKIE[ $key ] ) ? $_COOKIE[ $key ] : false;
   
   }


   // Example usage to return a cookie's value.
   // echo hap_cookie( 'my_cookie' );
   // and then blow it away
   // unset( $_COOKIE[ 'my_cookie' ] );

}

/**
 * Get a cookie in WordPress.
 *
 * This function returns a cookie value when the $key is passed
 *
 *
 * @param string $key The cookie name/key
 * @param string $value Optional. The cookie value
 * @param string|int $expiration  Optional. Timestamp when the cookie expires
 * @return boolean|string|int The cookie value if only the $key is passed, true is successfully set a cookie, false otherwise
 */
function hap_get_cookie( $key ) {

   return isset( $_COOKIE[ $key ] ) ? $_COOKIE[ $key ] : false;

   // Example usage to return a cookie's value.
   // echo canva_get_cookie( 'my_cookie' );
   // and then blow it away
   // unset( $_COOKIE[ 'my_cookie' ] );

}

/**
 * Set a cookie in WordPress.
 *
 * This function sets a cookie when both the $key and $value are passed.
 *
 * @param string $key The cookie name/key
 * @param string $value The cookie value
 * @param string|int $expiration Timestamp when the cookie expires
 * @return boolean True is successfully set a cookie, false otherwise
 */
function hap_set_cookie( $key, $value, $expiration ) {
    // Set cookie
    hap_cookie( $key, $value, $expiration );
}

//======================================================================
// Users, roles and login
//======================================================================

/**
 * Get user last login datetime.
 * 
 * @param integer $user_id
 * @return string $the_login_date
 */
function hap_get_last_login( $user_id ) {
	
	$the_login_date = __('Never logged in','hap');
	
	$last_login = get_user_meta( $user_id, 'last_login', true );

	if( $last_login ) {
		$the_login_date = date('l j F Y, H:i', $last_login);
	}
	
	return $the_login_date;

}

/**
 * Get user role.
 *
 * @param integer $user_id
 * @return array user roles
 */
function get_user_role( $user_id = 0 ) {
	
	$user = ($user_id) ? get_userdata($user_id) : wp_get_current_user();

	return current($user->roles);
	
}

/**
 * Check user role.
 *
 * @param integer $role
 * @return boolean
 */
function is_user_role( $role = 'administrator' ) {
	
	$current_user = wp_get_current_user();

	if( is_user_logged_in() && get_user_role($current_user->ID) == $role ) {
		
		return true;
	
	}else{
	
		return false;
	
	}

}

/**
 * Get all editable roles.
 * 
 * @return $editable_roles.
 */ 
function hap_get_editable_roles() {
	
    global $wp_roles;

    $all_roles = $wp_roles->roles;
    $editable_roles = apply_filters('editable_roles', $all_roles);

    return $editable_roles;
	
}

/**
 * Get role capabilities.
 * 
 * @param string $role
 * @return $role_caps // !!! Maybe $capabilities
 */ 
function hap_get_role_caps( $role ) {

	$capabilities = [];
	
	$get_role = get_role( $role );
	
	if( $get_role ) {
		
		$role_caps = $get_role->capabilities;
		
		foreach( wp_roles()->role_objects as $item ) {
			
			$capabilities[] = $item;
		}

	}
	
	return $role_caps; // !!! Maybe $capabilities

}

//======================================================================
// Urls and IPs
//======================================================================

/**
 * Check if url is external.
 *
 * @param string $url
 * @return boolean
 */
function is_url_local( $url ) {
	
	if( empty( $url ) ) {
		return false;
	}

	$urlParsed = parse_url($url);
	$host = $urlParsed['host'];

	if( empty( $host ) ) {
		
		// Maybe we have a relative link like: /wp-content/uploads/image.jpg
		// Add absolute path to begin and check if file exists
		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		$maybefile = $doc_root . $url;
		
		// Check if file exists
		$fileexists = file_exists($maybefile);
		
		if( $fileexists ) {
		
			// Maybe you want to convert to full url?
			return true;
			
		}
		
	}

	// Strip www. if exists
	$host = str_replace('www.', '', $host);
	$thishost = $_SERVER['HTTP_HOST'];

	// Strip www. if exists
	$thishost = str_replace('www.', '', $thishost);
	
	if ($host == $thishost) {
		return true;
	}

	return false;
	
}


/**
 * Returns the client ip address.
 *
 * @return $ipaddress.
 */
function get_client_ip() {
	
	$ipaddress = '';

	if( getenv('HTTP_CLIENT_IP') ) {
		
		$ipaddress = getenv('HTTP_CLIENT_IP');
	
	}elseif( getenv('HTTP_X_FORWARDED_FOR') ) {
		
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		
	}elseif( getenv('HTTP_X_FORWARDED') ) {
	
		$ipaddress = getenv('HTTP_X_FORWARDED');
	
	}elseif( getenv('HTTP_FORWARDED_FOR') ) {
	
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	
	}elseif( getenv('HTTP_FORWARDED') ) {
	
		$ipaddress = getenv('HTTP_FORWARDED');
	
	}elseif( getenv('REMOTE_ADDR') ) {

		$ipaddress = getenv('REMOTE_ADDR');
	
	} else {

		$ipaddress = 'UNKNOWN';
	
	}

	return $ipaddress;
}

//======================================================================
// More utilities
//======================================================================

/**
 * Check if maintenance mode is activated.
 * Exlude logged users.
 *
 * @return boolean
 */
function is_maintenance_mode_activated() {
    // Bail out early
    if( is_user_logged_in() ) {
        return false;
    }
	// Get field
	$maintenance_mode = get_field('maintenance_mode','options');
    // Get cookie
    $cookie = hap_get_cookie('hap_skip_token');
    // Return true or false
	if( 
        isset($maintenance_mode['maintenance_mode_option']) 
        && !empty($maintenance_mode['maintenance_mode_option'])
        && !$cookie ) {
		return true;
	}else{
		return false;
	}
}

/**
 * Check if there is at least one post published in a post type.
 *
 * @param string $post_type
 * @param string $taxonomy
 * @param string $term
 * @return boolean
 */
function is_there_any_post( $post_type = 'post', $taxonomy = 'category', $term = '' ) {
	
	$query = get_posts([
		'post_type'		=>	$post,
		'numberposts'	=>	-1,
		'tax_query'		=>	[
			[
				'taxonomy'	=>	$taxonomy,
				'terms'		=>	$term,
			],
		],
	]);

	if( $query ) {
		
		return true;
	
	}

	return false;
	
}

//======================================================================
// Maps
//======================================================================

/**
 * Get Google Maps link.
 *
 * @param array $address
 * @return string $text
 */
function get_gmap_link( $address, $text = null ) {

	if( !$text ) {
		$text = __('Get directions','hap');
	}
	
	$html = '<a target="_blank" rel="nofollow noopener nofollow" href="https://www.google.it/maps/place/';
	$html .= str_replace( ' ', '+', $address['address'] );
	$html .= '/">';
	$html .= $text;
	$html .= '</a>';

	return $html;
	
}

//======================================================================
// Emails
//======================================================================

/**
 * Markup of first part of emails.
 *
 * @return void
 */
function hap_email_body_start() {
	
	$body_start = '<div style="background-color: rgb(250,250,250); padding: 20px; font-size: 18px; color: #646464; margin-bottom: 5px;">';
	
	return $body_start;
	
}

/**
 * Markup of last part of emails.
 *
 * @return void
 */
function hap_email_body_end() {
		
	$body_end = '</div>';

	$body_end .= hap_get_email_signature('img_url');

	return $body_end;
}

/**
 * Email body buttons.
 *
 * @param string $button_link
 * @param string $button_text
 * @return string $button
 */
function hap_email_body_button( $button_link, $button_text ) {

	$button = '<a style="text-decoration: none; background-color: #2196F3; color: #ffffff; font-weight: 400; display: inline-block; padding: 20px 40px 16px 40px; font-size: 16px; margin: 0 10px 10px 0;" target="_blank" href="' . $button_link . '">' . $button_text . '</a>';
	
	return $button;

}

/**
 * Delete text between 2 strings.
 *
 * @param string $beginning
 * @param string $end
 * @param string $string
 * @return string
 */
function delete_all_between( $beginning, $end, $string ) {
	
	$beginningPos = strpos($string, $beginning);
	
	$endPos = strpos($string, $end);
	if ($beginningPos === false || $endPos === false) {
		return $string;
	}

	$textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

	// Recursion to ensure all occurrences are replaced
	return delete_all_between($beginning, $end, str_replace($textToDelete, '', $string));

}

//======================================================================
// Charts
//======================================================================

/**
 * Generate a pie chart.
 * 
 * https://codeburst.io/how-to-pure-css-pie-charts-w-css-variables-38287aea161e
 * @param array $values
 * @param string $css_classes
 * @param array $colors
 * @param integer $size
 * @return string $html
 */
function hap_pie_chart( $values, $css_classes = null, $colors = [], $size = 200 ) {

	if( !$colors ) {

		$colors = hap_color_palette();

	}

	$index = 0;
	$offset = 0;

	$html = '<div class="stats_pie ' .  $css_classes . '" style="--size: ' . $size . ';">';

	foreach( $values as $value ) :
	
		$html .= '<div class="pie__segment" style="';
		$html .= '--offset: ' . $offset . ';';
		$html .= '--value: ' . $value . ';';
		$html .= '--bg: ' . $colors[$index] . ';';
		if( $value > 50 ) {
			$html .= '--over50: 1;';
		}
		$html .= '"></div>';

		$index++;
		$offset += $value;

	endforeach;

	$html .= '</div>';

	return $html;

}

/**
 * A set of default colors with a filter.
 *
 * https://gist.github.com/Njengah/415fa17bd93d5520b263434a7ee3f314
 *
 * @return array $colors.
 */
function hap_color_palette() {

	$colors = [
		'var(--color-primary)',
		'var(--color-secondary)',
		'var(--color-accent)',
	];
	
	// Filter to add other custom colors
	$colors = apply_filters( 'hap_color_palette', $colors );
	
	return $colors;

}

/**
 * Function to replace the deprecated WordPress function get_page_by_title()
 * https://make.wordpress.org/core/2023/03/06/get_page_by_title-deprecated/
 *
 * @param string $page_title
 * @param string $post_type
 * @param boolean $filters
 * @param string/array $status
 * @return object $page_got_by_title
 */
function hap_get_page_by_title( $page_title, $post_type = 'page', $filters = false, $status = '' ) {
    // Args
	$query_args = [
		'post_type'              => $post_type,
		'title'                  => $page_title,
		'post_status'            => $status,
		'numberposts'        	 => 1,
		/*'no_found_rows'          => true,
		'ignore_sticky_posts'    => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'orderby'                => 'post_date ID',
		'order'                  => 'ASC',*/
	];
    // If status
    if( $status && $post_type != 'attachment' ) {
        $query_args['post_status'] = $status;
    }
    // Suppress filters (useful for queries with WPML)
    if( $filters ) {
        $query_args['suppress_filters'] = false;
    }
	/* if( $post_type == 'attachment' ) {
		unset($query_args['post_status']);
	} */
	$query = get_posts($query_args);
    // If results
	if( $query ) {
		$page_got_by_title = $query[0];
	} else {
		$page_got_by_title = null;
	}
	return $page_got_by_title;
}

/**
 * Add stats about server performances below everything.
 *
 * @return void
 */
function hap_show_wp_load_stats() {

	if( !current_user_can('manage_hap_options') ) {
		return;
	}

	echo '<div id="admin-query" class="text-center text-sm">';
	echo get_num_queries();
	echo __(' queries in ','hap');
	timer_stop(3);
	echo __(' seconds','hap');
	echo '</div>';

}

/**
 * Write errors in debug.log.
 *
 * https://wordpress.stackexchange.com/questions/260236/how-to-put-logs-in-wordpress
 * @param mixed $log
 * @return void
 */
if( !function_exists('write_log') ) {

    function write_log( $log ) {
		
        if( true === WP_DEBUG ) {
        
			if( is_array( $log ) || is_object( $log ) ) {
            
				error_log( print_r( $log, true ) );
            
			}else{
				
				error_log( $log );

			}

		}

	}

}

/**
 * Get server time.
 *
 * @return string
 */
function hap_server_time() {
	
	echo wp_date('Y-m-d H:i:s', hap_get_current_time());
	
}

/**
 * Get server public ip address.
 *
 * @return void.
 */
function hap_server_ip() {
    // Bail out early
	if( !is_admin() ) {
		exit;
	}
    // Init cUrl
	$curl = curl_init();
    // Fetch data
	curl_setopt_array($curl, array(
		CURLOPT_URL				=> 'https://ipinfo.io/ip',
		CURLOPT_RETURNTRANSFER	=> true,
		CURLOPT_CUSTOMREQUEST	=> 'GET'
	));
    // Print value
	echo 'curl https://ipinfo.io/ip = ' . curl_exec($curl);
    // Ajax
	wp_die();
}

/**
 * Useful to re-save posts by post type.
 *
 * @param string $content
 * @param integer $trim
 * @return void
 */
function hap_update_all_posts( $vars = [], $by = 'field' ) {

	extract($vars);

	if( $by === 'field' ) {
		
		$args = array(
			'post_type'			=> esc_attr($post_type),
			'posts_per_page'	=> -1,
			'meta_key'          => esc_attr($meta_key),
			'meta_value'        => $meta_value,
		);
		
	}else{
		
		$args = array(
			'post_type'			=> esc_attr($post_type),
			'posts_per_page'	=> -1,
			'tax_query'			=> array(
				'taxonomy'	=> esc_attr($taxonomy),
				'field'		=> esc_attr($field),
            	'terms'		=> $terms
			),
		);
		
	}

	$all_posts = get_posts( $args );

	foreach( $all_posts as $single_post ) {
		
		$single_post->post_title = $single_post->post_title . '';
		
		wp_update_post($single_post);
	
	}

	wp_die();

}

//======================================================================
// ACF Blocks
//======================================================================

/** 
 * Array of values to be used in block fields.
 *
 * @param string $key
 * @return array $data
 */
function hap_block_values( $key ) {
	
	$values = [
	
		'display' => [
			'block'	=> 'Block',
			'flex'	=> 'Flex',
			'grid'	=> 'Grid',
		],
	
		'justify_content' => [
			'justify-start'		=> 'Flex start',
			'justify-end'		=> 'Flex end',
			'justify-center'	=> 'Center',
			'justify-between'	=> 'Space between',
			'justify-around'	=> 'Space around',
			'justify-evenly'	=> 'Space evenly',	
		],
	
		'align_items' => [
			'items-start'		=> 'Start',
			'items-end'			=> 'End',
			'items-center'		=> 'Center',
			'items-baseline'	=> 'Baseline',
			'items-stretch'		=> 'Stretch',		
		],
	
		'grid' => [
			'grid'			=> 'S1 M1 L1',
			'grid-1-2'		=> 'S1 M2 L2',
			'grid-1-1-2'	=> 'S1 M1 L2',
			'grid-1-1-3'	=> 'S1 M1 L3',
			'grid-1-1-4'	=> 'S1 M1 L4',
			'grid-1-2-3'	=> 'S1 M2 L3',
			'grid-1-2-4'	=> 'S1 M2 L4',
			'grid-1-2-6'	=> 'S1 M2 L6',
			'grid-1-3'		=> 'S1 M3 L3',
			'grid-1-3-4'	=> 'S1 M3 L4',
			'grid-1-3-6'	=> 'S1 M3 L6',
			'grid-2'		=> 'S2 M2 L2',
			'grid-2-4'		=> 'S2 M4 L4',
			'grid-2-4-6'	=> 'S2 M4 L6',
			'grid-2-4-8'	=> 'S2 M4 L8',
		],
	
		'gap' => [
			'gap-0'				=> 'S0 M0 L0',
			'gap-2-4-4'			=> 'S2 M4 L4',
			'gap-2-4-8'			=> 'S2 M4 L8',
			'gap-4-8-8'			=> 'S4 M8 L8',
			'gap-4-8-16'		=> 'S4 M8 L16',
		],
		'container' => [
			'w-full'		=> '100%',
			'container-sm'	=> 'S',
			'container-md'	=> 'M',
			'container-lg'	=> 'L',
		],
	
		'padding' => [
			'p-xs'	=> 'XS',
			'p-sm'	=> 'S',
			'p-md'	=> 'M',
			'p-lg'	=> 'L',
			'p-xl'	=> 'XL',
		],

		'padding_t' => [
			'pt-xs'	=> 'XS',
			'pt-sm'	=> 'S',
			'pt-md'	=> 'M',
			'pt-lg'	=> 'L',
			'pt-xl'	=> 'XL',
		],

		'padding_b' => [
			'pb-xs'	=> 'XS',
			'pb-sm'	=> 'S',
			'pb-md'	=> 'M',
			'pb-lg'	=> 'L',
			'pb-xl'	=> 'XL',
		],

		'padding_l' => [
			'pl-xs'	=> 'XS',
			'pl-sm'	=> 'S',
			'pl-md'	=> 'M',
			'pl-lg'	=> 'L',
			'pl-xl'	=> 'XL',
		],
		
		'padding_r' => [
			'pr-xs'	=> 'XS',
			'pr-sm'	=> 'S',
			'pr-md'	=> 'M',
			'pr-lg'	=> 'L',
			'pr-xl'	=> 'XL',
		],
		
		'margin' => [
			'm-xs'	=> 'XS',
			'm-sm'	=> 'S',
			'm-md'	=> 'M',
			'm-lg'	=> 'L',
			'm-xl'	=> 'XL',
		],
		
		'margin_t' => [
			'mt-xs'	=> 'XS',
			'mt-sm'	=> 'S',
			'mt-md'	=> 'M',
			'mt-lg'	=> 'L',
			'mt-xl'	=> 'XL',
		],

		'margin_b' => [
			'mb-xs'	=> 'XS',
			'mb-sm'	=> 'S',
			'mb-md'	=> 'M',
			'mb-lg'	=> 'L',
			'mb-xl'	=> 'XL',
		],
		
		'margin_l' => [
			'ml-xs'	=> 'XS',
			'ml-sm'	=> 'S',
			'ml-md'	=> 'M',
			'ml-lg'	=> 'L',
			'ml-xl'	=> 'XL',
		],
		
		'margin_r' => [
			'mr-xs'	=> 'XS',
			'mr-sm'	=> 'S',
			'mr-md'	=> 'M',
			'mr-lg'	=> 'L',
			'mr-xl'	=> 'XL',
		],
		
		'bg_color' => [
			'bg-default'		=> __('Transparent','hap'),
			'bg-primary'		=> __('Primary color','hap'),
			'bg-secondary'		=> __('Secondary color','hap'),
			'bg-accent'			=> __('Accent color','hap'),
			'bg-white'			=> __('White','hap'),
			'bg-black'			=> __('Black','hap'),
			'bg-gray-50'		=> __('Gray','hap') . ' 50',
			'bg-gray-100'		=> __('Gray','hap') . ' 100',
			'bg-gray-200'		=> __('Gray','hap') . ' 200',
			'bg-gray-300'		=> __('Gray','hap') . ' 300',
			'bg-gray-400'		=> __('Gray','hap') . ' 400',
			'bg-gray-500'		=> __('Gray','hap') . ' 500',
			'bg-gray-600'		=> __('Gray','hap') . ' 600',
			'bg-gray-700'		=> __('Gray','hap') . ' 700',
			'bg-gray-800'		=> __('Gray','hap') . ' 800',
			'bg-gray-900'		=> __('Gray','hap') . ' 900',
		],
		
		'paragraph' => [
			'text-left'		=> __('Left','hap'),
			'text-right'	=> __('Right','hap'),
			'text-center'	=> __('Center','hap'),
		],
		
		'text_color' => [
			'islight'		=> __('Dark','hap'),
			'isdark'		=> __('Light','hap'),
		],
		
		'button_style' => [
			'primary'			=> __('Primary','hap'),
			'secondary'			=> __('Secondary','hap'),
			'secondary light'	=> __('Secondary light','hap'),
			'hollow'			=> __('Hollow','hap'),
			'hollow light'		=> __('Hollow light','hap'),
		],

		'button_size' => [
			'w-auto'			=> __('Auto','hap'),
			'w-full'			=> __('Full width','hap'),
			'small'				=> __('Small','hap'),
			'small w-full'		=> __('Small full width','hap'),
		],
		
		'semantic_tag' => [
			'div'		=> 'div (default)',
			'main'		=> 'main',
			'aside'		=> 'aside',
			'article'	=> 'article',
			'section'	=> 'section',
			'header'	=> 'header',
			'footer'	=> 'footer',
			'nav'		=> 'nav',
			'address'	=> 'address',
			'ul'		=> 'ul',
			'ol'		=> 'ol',
			'li'		=> 'li',
		],
		
		'col_span' => [
			'col-span-1-1-2'	=>	'S1 M1 L2',
			'col-span-1-1-3'	=>	'S1 M1 L3',
			'col-span-1-2-2'	=>	'S1 M2 L2',
			'col-span-1-2-3'	=>	'S1 M2 L3',
			'col-span-1-2-4'	=>	'S1 M2 L4',
			'col-span-1-3-3'	=>	'S1 M3 L3',
			'col-span-1-3-6'	=>	'S1 M3 L6',
		],
		
		'bg_blend_mode' => [
			'bg-blend-normal'		=>	'Normal',
			'bg-blend-multiply'		=>	'Multiply',
			'bg-blend-screen'		=>	'Screen',
			'bg-blend-overlay'		=>	'Overlay',
			'bg-blend-darken'		=>	'Darken',
			'bg-blend-lighten'		=>	'Lighten',
			'bg-blend-color-dodge'	=>	'Color dodge',
			'bg-blend-color-burn'	=>	'Color burn',
			'bg-blend-hard-light'	=>	'Hard light',
			'bg-blend-soft-light'	=>	'Soft light',
			'bg-blend-difference'	=>	'Difference',
			'bg-blend-exclusion'	=>	'Exclusion',
			'bg-blend-hue'			=>	'Hue',
			'bg-blend-saturation'	=>	'Saturation',
			'bg-blend-color'		=>	'Color',
			'bg-blend-luminosity'	=>	'Luminosity',
		],
		
		'mix_blend_mode' => [
			'mix-blend-normal'		=>	'Normal',
			'mix-blend-multiply'	=>	'Multiply',
			'mix-blend-screen'		=>	'Screen',
			'mix-blend-overlay'		=>	'Overlay',
			'mix-blend-darken'		=>	'Darken',
			'mix-blend-lighten'		=>	'Lighten',
			'mix-blend-color-dodge'	=>	'Color dodge',
			'mix-blend-color-burn'	=>	'Color burn',
			'mix-blend-hard-light'	=>	'Hard light',
			'mix-blend-soft-light'	=>	'Soft light',
			'mix-blend-difference'	=>	'Difference',
			'mix-blend-exclusion'	=>	'Exclusion',
			'mix-blend-hue'			=>	'Hue',
			'mix-blend-saturation'	=>	'Saturation',
			'mix-blend-color'		=>	'Color',
			'mix-blend-luminosity'	=>	'Luminosity',
		],

		'height' => [
			'h-full'		=>	'100%',
			'h-screen'		=>	'100vh',
			'h-screen-menu'	=>	'100vh - nav',
			'h-1/4'			=>	'1/4',
			'h-2/4'			=>	'1/2',
			'h-3/4'			=>	'3/4',
			'h-1/5'			=>	'1/5',
			'h-2/5'			=>	'2/5',
			'h-3/5'			=>	'3/5',
			'h-4/5'			=>	'4/5',
			'h-1/6'			=>	'1/6',
			'h-2/6'			=>	'1/3',
			'h-4/6'			=>	'2/3',
			'h-5/6'			=>	'5/6',
		],

		'min_height' => [
			'min-h-full'		=>	'100%',
			'min-h-screen'		=>	'100vh',
			'min-h-screen-menu'	=>	'100vh - nav',
			'min-h-75vh'		=>	'75vh',
			'min-h-50vh'		=>	'50vh',
			'min-h-33vh'		=>	'33vh',
			'min-h-25vh'		=>	'25vh',
			'min-h-100vw'		=>	'100vw',
			'min-h-75vw'		=>	'75vw',
			'min-h-50vw'		=>	'50vv',
			'min-h-33vw'		=>	'33vw',
			'min-h-25vw'		=>	'25vw',
			'min-h-0'			=>	'0',
		],
		
		'flex_direction' => [
			'flex-row'			=>	'row',
			'flex-row-reverse'	=>	'row-reverse',
			'flex-col'			=>	'column',
			'flex-col-reverse'	=>	'column-reverse',
		],
		
		'post_types' => [
			'post'	=>	__('Post','hap'),
			'page'	=>	__('Page','hap'),
		],
		
	];
	
	$values = apply_filters( 'hap_block_values', $values );
	
	$data = null;
	
	if( $key == 'all' ) {
		
		$data = $values;
	
	}else{
		
		$data = $values[ $key ];
	}
	
	return $data;
	
}

/**
 * Get time ago message based on seconds.
 * https://gist.github.com/mokoshalb/8e2e1224cc3fb1f2c82c0d383ad67240
 *
 * @param integer $sec
 * @return string $label
 */
function hap_time_ago( $sec ) {
    // Default value
    $label = '';
    // Starting seconds
    $date1 = new DateTime("@0");
	// Ending seconds
    $date2 = new DateTime("@$sec");
    // The time difference
	$interval = date_diff($date1, $date2);
	// Convert into Years, Months, Days, Hours, Minutes and Seconds
    $years = intval($interval->format('%y'));
    $months = intval($interval->format('%m'));
    $days = intval($interval->format('%d'));
    $hours = intval($interval->format('%h'));
    $minutes = intval($interval->format('%i'));
    $seconds = intval($interval->format('%s'));
    // Return value accroding to time
    if( $years > 0 ) {
        $label = sprintf(__('%s Years, %s months and %s days ago.','hap'),$years,$months,$days);
    }elseif( $months > 0 ) {
        $label = sprintf(__('%s Months and %s days ago.','hap'),$months,$days);
    }elseif( $days > 0 ) {
        $label = sprintf(__('%s Days and %s hours ago.','hap'),$days,$hours);
    }elseif( $hours > 0 ) {
        $label = sprintf(__('%s Hours and %s minutes ago.','hap'),$hours,$minutes);
    }elseif( $minutes > 0 ) {
        $label = sprintf(__('%s Minutes and %s seconds ago.','hap'),$minutes,$seconds);
    }elseif( $seconds > 0 ) {
        $label = sprintf(__('%s Seconds ago.','hap'),$seconds);
    }
    return $label;    
}