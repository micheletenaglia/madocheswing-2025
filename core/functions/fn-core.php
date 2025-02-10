<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Include ACF and some security functions.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
     _    ____ _____ 
    / \  / ___|  ___|
   / _ \| |   | |_   
  / ___ \ |___|  _|  
 /_/   \_\____|_|
 
****************************************************************************************/

// Include assets to check plugin activations
if( !function_exists( 'is_plugin_active' ) ) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// Check if ACF PRO is active and MY_ACF_PATH is not defined
if( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) && !defined( 'MY_ACF_PATH' ) ) {
    // Define path and URL to the ACF plugin.
    define('HAP_ACF_PATH', get_template_directory() . '/core/acf/');
    define('HAP_ACF_URL', get_template_directory_uri() . '/core/acf/');
    // Include the ACF plugin.
    include_once HAP_ACF_PATH . 'acf.php';
    // Include ACF plugin files
    add_filter('acf/settings/url', 'hap_acf_settings_url');
}

/**
 * Customize the url setting to fix incorrect asset URLs.
 * 
 * @param string $url
 * @return string MY_ACF_URL
 */
function hap_acf_settings_url( $url ) {
	return HAP_ACF_URL;
}

/****************************************************************************************
  ____  _____ ____ _   _ ____  ___ _______   __
 / ___|| ____/ ___| | | |  _ \|_ _|_   _\ \ / /
 \___ \|  _|| |   | | | | |_) || |  | |  \ V / 
  ___) | |__| |___| |_| |  _ < | |  | |   | |  
 |____/|_____\____|\___/|_| \_\___| |_|   |_|  

****************************************************************************************/

// Security
add_filter('wp_headers', 'hap_set_security_headers', 999);

// Disable json endpoints
add_filter('rest_endpoints','hap_disable_rest_endpoints');

/**
 * Set security headers.
 *
 * https://www.xlr8r.cloud/wordpress-security-headers/
 * @param array $headers
 * @return array $headers
 */
function hap_set_security_headers( $headers ) {
    // If is frontend
	if( !is_admin() ) {
        // Add Strict-Transport-Security
		if( !isset( $headers['Strict-Transport-Security'] ) ) {
			$headers['Strict-Transport-Security'] = 'max-age=63072000; includeSubDomains; preload';
		}
        // Add X-Content-Type-Options
		if( !isset( $headers['X-Content-Type-Options'] ) ) {
			$headers['X-Content-Type-Options'] = 'nosniff';
		}
        // Add X-Frame-Options
		if( !isset( $headers['X-Frame-Options'] ) ) {
			$headers['X-Frame-Options'] = 'SAMEORIGIN';
		}
        // Add Access-Control-Allow-Origin
		if( !isset( $headers['Access-Control-Allow-Origin'] ) ) {
			$headers['Access-Control-Allow-Origin'] = '*';
		}
		/* Modifiche Iubenda: https://www.iubenda.com/it/help/12347-come-configurare-il-content-security-policy-per-consentire-lesecuzione-degli-script-di-iubenda
		if( !isset( $headers['Content-Security-Policy'] ) ) {
			$headers['Content-Security-Policy'] = "default-src 'self'; script-src 'self' 'unsafe-inline' *.iubenda.com cdnjs.cloudflare.com cdn.jsdelivr.net unpkg.com connect.facebook.net player.vimeo.com c0.wp.com ajax.googleapis.com maps.googleapis.com www.googleadservices.com www.google-analytics.com www.googletagmanager.com www.google.com www.gstatic.com googleads.g.doubleclick.net usercontent.one; connect-src *.iubenda.com; font-src 'self' data: fonts.gstatic.com fonts.googleapis.com use.typekit.net; object-src 'none'; style-src 'unsafe-inline' *.iubenda.com; frame-src *.iubenda.com; img-src *.iubenda.com data:;";
		}*/
		// Add "data:" (yes with two points) in font-src if you need to apply CSP to backend)
		/*if( !isset( $headers['Content-Security-Policy'] ) ) {
			$headers['Content-Security-Policy'] = "script-src 'self' 'unsafe-inline' www.iubenda.com hits-i.iubenda.com cdn.iubenda.com cdnjs.cloudflare.com cdn.jsdelivr.net unpkg.com connect.facebook.net player.vimeo.com c0.wp.com ajax.googleapis.com maps.googleapis.com www.googleadservices.com www.google-analytics.com www.googletagmanager.com www.google.com www.gstatic.com googleads.g.doubleclick.net usercontent.one; font-src 'self' data: fonts.gstatic.com fonts.googleapis.com use.typekit.net; object-src 'none';";
		}
		// Add "data:" (yes with two points) in font-src if you need to apply CSP to backend)
		*/
        /*
		Removed according to https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
		if( !isset( $headers['X-XSS-Protection'] ) ) {
			$headers['X-XSS-Protection'] = '1; mode=block';
		}*/
        // Unset unsafe headers
		unset($headers['X-XSS-Protection']);
		unset($headers['X-Powered-By']);
	}
	return $headers;	
}

/**
 * This snippet completely disables the REST API and shows 
 * {"code":"rest_disabled","message":"The REST API is disabled on this site."} 
 * when visiting http://example.com/wp-json/
 *
 * @return void
*/
function hap_disable_json_api() {
	// Filters for WP-API version 1.x
	add_filter('json_enabled', '__return_false');
	add_filter('json_jsonp_enabled', '__return_false');
	// Filters for WP-API version 2.x
	add_filter('rest_enabled', '__return_false');
	add_filter('rest_jsonp_enabled', '__return_false');
}

/**
 * Define nonce constant for content security policy.
 * The nonce is used to whitelist scripts in content security policy.
 * !!! Da terminare, vedi funzione successiva
 * !!! Al momento la funzione non è hookata
 *
 * @return void
 */
function hap_csp_nonce() {
	define('CSP_NONCE', random_int( 1, 999999999999 ) );
}
// add_action('init','hap_csp_nonce');

/**
 * Add nonce to script tag.
 * The nonce is used to whitelist scripts in content security policy.
 * !!! Da terminare, manca la gestione di Iubenda
 * !!! Gestire anche script inline e cambiare unsafe-inline in strict-dynamic
 * !!! Al momento la funzione non è hookata
 *
 * @param string $tag
 * @param string $handle
 * @return string $tag
 */
function hap_add_csp_nonce( $tag, $handle ) {
    // If is frontend
	if (!is_admin()) {
		return str_replace( '<script ', '<script nonce="' . CSP_NONCE . '" ', $tag);
	} else {
		return $tag;
	}
}
// add_filter('script_loader_tag', 'hap_add_csp_nonce', 10, 2);

function csp_iubenda( $output ) {
	$output = str_replace( '<script ', '<script nonce="123"', $output );
	return $output;
}
// add_filter('iubenda_final_output','csp_iubenda',PHP_INT_MAX);

/**
 * Disable json endpoints (users rest-api).
 *
 * @param array $endpoints
 * @return array $endpoints
 */
if( !function_exists('hap_disable_rest_endpoints') ) {
	function hap_disable_rest_endpoints($endpoints) {
		$whitelist = ['127.0.0.1', '::1'];
		if( !in_array($_SERVER['REMOTE_ADDR'], $whitelist) ) {
			if (isset($endpoints['/wp/v2/users'])) {
				unset($endpoints['/wp/v2/users']);
			}
			if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
				unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
			}
		}
		return $endpoints;
	}
	if( !is_user_logged_in() ) {	
		add_filter('rest_endpoints', 'hap_disable_rest_endpoints');
	}
}

/****************************************************************************************
 _        _    _   _  ____ _   _   _    ____ _____ 
| |      / \  | \ | |/ ___| | | | / \  / ___| ____|
| |     / _ \ |  \| | |  _| | | |/ _ \| |  _|  _|  
| |___ / ___ \| |\  | |_| | |_| / ___ \ |_| | |___ 
|_____/_/   \_\_| \_|\____|\___/_/   \_\____|_____|

****************************************************************************************/
// Load theme textdoamain
add_action('init','hap_text_domain',10,2);

/**
 * Load theme textdoamain.
 * This is hooked to init since WP 6.7.1.
 *
 * @return void
 */
function hap_text_domain() {
    // Load text domain for translations
    load_theme_textdomain('hap',HAP_CORE . 'languages');
    load_theme_textdomain('project',HAP_PROJECT . 'languages');
}