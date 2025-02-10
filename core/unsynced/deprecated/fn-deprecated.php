<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit; 
}

// Add preload to stylesheets
add_filter('style_loader_tag', 'hap_webfonts_add_preload_attr', 10, 2);

/**
 * Add preload to included styles via wp_register_style & wp_enqueue_script wp functions.
 *
 * @inspired by https://matthewhorne.me/defer-async-wordpress-scripts/
 * @param string $tag
 * @param string $handle
 * @return string $tag
 */
function hap_webfonts_add_preload_attr( $tag, $handle ) {
	// If is not the backend
	if( !is_admin() ) {
		
		if( false !== strpos($handle, 'preload') ) {
			
			$tag = str_replace("rel='stylesheet'", "rel='stylesheet preload' crossorigin='true' as='font'", $tag);
			
			return $tag;
		
		}elseif( false !== strpos($handle, 'woff') ) {
			
			$clean = str_replace("type='text/css' media='all'", "", $tag);
			return str_replace("rel='stylesheet'", "rel='stylesheet preload' as='font' type='font/woff2'", $clean);
		
		}else{

			return $tag;
		
		}
		
	}else{
		
		return $tag;
	}
}

// Defer scripts
add_filter('script_loader_tag','hap_defer_scripts',10,3);
/**
 * Defer scripts.
 * !!! This is deprecated, the same can be achieved
 * with default wp_register_script last argument.
 *
 * @param string $tag.
 * @param string $handle.
 * @param string $src.
 * @return string $tag.
 */
function hap_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array('map_google','map');
    if( in_array( $handle, $defer_scripts) ) {
        return '<script id="' . $handle . '-js" defer src="' . $src . '"></script>' . "\n";
    }
    return $tag;
}

/*
array(
    'key'				=> 'field_6600225d6da76',
    'label'				=> __('Primary font name','hap'),
    'name'				=> 'name',
    'type'				=> 'text',
    'instructions'		=> __('Enter the exact font name.','hap'),
    'placeholder'		=> __('Ex.','hap') . 'Lexia',
),
array(
    'key'				=> 'field_6600225c6da74',
    'label'				=> __('Secondary font name','hap'),
    'name'				=> 'name',
    'type'				=> 'text',
    'instructions'		=> __('Enter the exact font name.','hap'),
    'placeholder'		=> __('Ex.','hap') . 'Lexia',
),
array(
    'key'				=> 'field_6600225c6da73',
    'label'				=> __('Extra font name','hap'),
    'name'				=> 'name',
    'type'				=> 'text',
    'instructions'		=> __('Enter the exact font name.','hap'),
    'placeholder'		=> __('Ex.','hap') . 'Lexia',
),
*/

/**
 * Get Google font name and weights from url.
 *
 * @param string $key
 * @return array $font_data
 */
function hap_get_google_font_name( $url ) {
	
	$parsed_url = parse_url( $url );
	
	parse_str( $parsed_url['query'], $output );
	
	$output = explode( ':', $output['family'] );
	
	// Diepnde dalla string, funxiona solo se è un font variabile
	$font_weights = explode( ';', str_replace( 'wght@', null, $output[1] ) );
	
	$font_data = [
		'font_name'		=>	$output[0],
		'font_weights'	=>	$font_weights
	];
	
	return $font_data;
	
}

if( !is_user_logged_in() ) {
	// add_action('template_redirect', 'hap_maintenance_mode', 10);
}

/**
 * Set website offline when maintenance mode is activated.
 * Hooked to "template_redirect".
 * !!! Sistemare token e cookie
 *
 * @return void.
 */
function hap_maintenance_mode() {

	// Bail out early if user is logged in
	if( is_user_logged_in() ) {
		return;
	}

	// Get maintenance options (grouped field)
    $maintenance_mode = get_field('maintenance_mode', 'options');
	
	// If maintenance is active field exists
	if( $maintenance_mode ) {
		
		// Get maintenance option (boolean field)
		$maintenance_page = $maintenance_mode['maintenance_mode_page'];
		// Get cookie and privacy policies pages because
		// they will be excluded from the maintenance
		$cookie_page = get_field('cookie_policy_page', 'options');
		$privacy_page = get_field('privacy_policy_page', 'options');

		// If maintenance is active
		if( $maintenance_mode['maintenance_mode_option'] ) {

			// Get URL parameter (token) to allow viewing the site
			$token = null;
			if( isset( $_GET['token'] ) && !empty( $_GET['token'] ) ) {
				$token = sanitize_text_field( $_GET['token'] );
			}

			// Check if the cookie hap_bypass_token is set
			$token_cookie = null;
			if( isset($_COOKIE['hap_bypass_token'] ) ) {
				$token_cookie = hap_cookie('hap_bypass_token');
			}

			// If the token (URL) is equal to the token set in the backend
			if( $token == $maintenance_mode['token'] && !isset($_COOKIE['hap_bypass_token'] ) ) {
				// Set a cookie that allows to bypass the maintenance mode for 24 hours
				hap_cookie( 'hap_bypass_token', $maintenance_mode['token'], DAY_IN_SECONDS );
			}

			// If the token (URL) is equal to the token set in the backend
			// or the cookie token is equal to the token set in the backend
			/*if( $token == $maintenance_mode['token'] || $token_cookie == $maintenance_mode['token'] ) {
				// If we are visiting the maintenance mode page 
				// redirect to the homepage
				if( is_page($maintenance_mode['maintenance_mode_page']) ) {

					wp_redirect(home_url(), 302);
					exit();

				}

			}else{*/

				// If we are visitng a page that is not the maintenance mode page 
				// neither the cookie policy page nor the privacy policy page
				// let's redirect the user on the maintenance page
				if( !is_page($maintenance_page) && !is_page($cookie_page) && !is_page($privacy_page) ) {

                    // If manintenance page is set
                    if( $maintenance_mode['maintenance_mode_page'] ) {
    					$redirect_url = get_the_permalink($maintenance_mode['maintenance_mode_page']);
                    }else{
    					$redirect_url = esc_url(add_query_arg( 'maintenance',1,get_home_url()));
                    }
					wp_redirect($redirect_url, 302);
					exit();

				}

			// }

		}
		
	}

}

// Remove type attribute from scripts
// add_filter('style_loader_tag','hap_remove_type_attr',10,2);
// add_filter('script_loader_tag','hap_remove_type_attr',10,2);
/**
 * Remove attr from Css and Js.
 *
 * @param string $tag
 * @param string $handle
 * @return string $tag
 */
function hap_remove_type_attr( $tag, $handle ) {
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

// Menu items
// add_filter('wp_nav_menu_items','hap_custom_menu_item',10,2);
/**
 * Add cart icon in menu.
 *
 * @param string $items
 * @param object $args
 * @return string $items
 */
function hap_custom_menu_item( $items, $args ) {
	if( is_woocommerce_activated() ) {
		if ( $args->theme_location == 'primary-menu' ) {
			$items .= '<li class="menu-item"><span class="block mr-4">' . get_svg_icon( 'search' ) . '</span></li>';
		}
		return $items;
	}
}

// if( get_field('google_analytics_id','options) ) {
//	add_action('wp_head', 'hap_google_analytics_header', 90);
// }

/* Print facebook app ID if defined in theme options
if( get_field('facebook_app_id','options') ) {

	add_action('wp_head', function () {
		echo '<meta property="fb:app_id" content="' . esc_attr( get_field('facebook_app_id','options') ) . '" />';
	}, 91);
}
*/

// Load textdomain to provide translations
// load_textdomain( 'hap', get_template_directory() . '/languages/it_IT.mo' );


/**
 * Set capabilities for custom post type common_blocks (admnistrator & editor).
 * !!! Rivedere
 *
 * @return void.
 */
/* 
function hap_cpt_capabilities() {
    $roles = array('editor', 'administrator');
    foreach( $roles as $the_role ) {
        $role = get_role($the_role);
        // Common_blocks
        $role->add_cap('read_common_block');
        $role->add_cap('read_private_common_blocks');
        $role->add_cap('edit_common_block');
        $role->add_cap('edit_common_blocks');
        $role->add_cap('edit_others_common_blocks');
        $role->add_cap('edit_published_common_blocks');
        $role->add_cap('publish_common_blocks');
        $role->add_cap('delete_common_blocks');
        $role->add_cap('delete_others_common_blocks');
        $role->add_cap('delete_private_common_blocks');
        $role->add_cap('delete_published_common_blocks');
    }
}
// Set capabilities for common blocks
add_action('init', 'hap_cpt_capabilities');
*/

// Set jpg compression quality
// add_filter('jpeg_quality', function ($arg) { return 82; });
