<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The main PHP file of the theme.
 *
 * Prefixes.
 * - text_domain:   mklang
 * - CSS backend:   mkcb-
 * - CSS frontend:  mkcf-
 * - PHP functions: mkt_
 * - PHP constants: MKT_
 * - Cookie: sitename, time
 * 
 * Note: Alternative way to get fields from options page
 * get_field('xxx', 'options') = get_option('options_xxx')
 */

// Utility functions
require_once(get_template_directory() . '/core/functions/fn-utilities.php');

// Theme custom fields
require_once(get_template_directory() . '/core/functions/fn-acf-fields-theme.php');

// Backend functions
require_once(get_template_directory() . '/core/functions/fn-backend.php');

// Blocks functions
require_once(get_template_directory() . '/core/functions/fn-acf-register-blocks.php');
require_once(get_template_directory() . '/project/blocks/fn-acf-register-blocks.php');

// Block fields functions
require_once(get_template_directory() . '/core/functions/fn-acf-fields-blocks.php');
require_once(get_template_directory() . '/project/blocks/fn-acf-fields-blocks.php');

// Frontend functions
require_once(get_template_directory() . '/core/functions/fn-frontend.php');

// Plugins and shortcodes functions
require_once(get_template_directory() . '/core/functions/fn-plugins-shortcodes.php');

// License functions
require_once(get_template_directory() . '/core/functions/fn-license.php');

// Main congiguration of the theme
new mktConfig();

/**
 * Main congiguration of the theme.
 *
 */
class mktConfig{

    /**
     * Actions and filters.
     * 
     */
    public function __construct() {

		/*-------------------------------------------------------------------------------------*/
		// Load theme text domain
		add_action('init',[$this,'text_domain']);

		/*-------------------------------------------------------------------------------------*/
		// ACF
		// Include assets to check plugin activations
		if( !function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		// Check if ACF PRO is active and MY_ACF_PATH is not defined
		if( !is_plugin_active('advanced-custom-fields-pro/acf.php') && !defined('MY_ACF_PATH') ) {
			// Define path and URL to the ACF plugin.
			define('MKT_ACF_PATH', get_template_directory() . '/core/acf/');
			define('MKT_ACF_URL', get_template_directory_uri() . '/core/acf/');
			// Include the ACF plugin.
			include_once MKT_ACF_PATH . 'acf.php';
			// Include ACF plugin files
			add_filter('acf/settings/url',function() {
				return MKT_ACF_URL;
			});
		}

		/*-------------------------------------------------------------------------------------*/
		// Security
		// HTTP Security headers
		add_filter('wp_headers',[$this,'security_headers'],999);
		// Disable json endpoints
		add_filter('rest_endpoints',[$this,'disable_rest_endpoints']);

		/*-------------------------------------------------------------------------------------*/
		// Iubenda
		// add_action('init',[$his,'csp_nonce']);
		// add_filter('script_loader_tag',[$his,'add_csp_nonce'],10,2);
		// add_filter('iubenda_final_output',[$his,'csp_iubenda'],PHP_INT_MAX);

	}

	/**
	 * Load theme text domain.
	 * This is hooked to init since WP 6.7.1.
	 */
	public function text_domain() : void {
		// Load text domain for translations
		load_theme_textdomain('mklang',get_template_directory() . '/core/languages');
		load_theme_textdomain('project',get_template_directory() . '/project/languages');
	}

	/**
	 * Set security headers.
	 * @link https://www.xlr8r.cloud/wordpress-security-headers/
	 * @param array $headers
	 */
	public function security_headers( $headers ) : array {
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
	 * Disable json endpoints (users rest-api).
	 * @param array $endpoints
	 */
	public function disable_rest_endpoints( $endpoints ) : array {
		// Bail out if user is logged
		if( is_user_logged_in() ) {
			return $endpoints;
		}
		// Whitelist
		$whitelist = ['127.0.0.1', '::1'];
		// Conditions
		if( !in_array($_SERVER['REMOTE_ADDR'],$whitelist) ) {
			if (isset($endpoints['/wp/v2/users'])) {
				unset($endpoints['/wp/v2/users']);
			}
			if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
				unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
			}
		}
		return $endpoints;
	}

	/**
	 * Define nonce constant for content security policy.
	 * The nonce is used to whitelist scripts in content security policy.
	 * !!! To be completed, see next function.
	 * !!! Not hooked at the moment.
	 */
	public function csp_nonce() : void {
		define('CSP_NONCE',random_int(1,999999999999) );
	}

	/**
	 * Add nonce to script tag.
	 * The nonce is used to whitelist scripts in content security policy.
	 * !!! To be completed, Iubenda management is missing.
	 * !!! Also manage inline scripts and change unsafe-inline to strict-dynamic.
	 * !!! Not hooked at the moment.
	 * @param string $tag
	 * @param string $handle
	 */
	function add_csp_nonce( $tag, $handle ) : string {
		// If is frontend
		if (!is_admin()) {
			return str_replace( '<script ', '<script nonce="' . CSP_NONCE . '" ', $tag);
		} else {
			return $tag;
		}
	}

	/**
	 * Iubenda content security policy.
	 * @param string $output
	 */
	public function csp_iubenda( $output ) : string {
		$output = str_replace( '<script ', '<script nonce="123"', $output );
		return $output;
	}
	
}