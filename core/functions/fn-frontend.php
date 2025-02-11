<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Assets, customizations, optimizations and more for the frontend
new mktFrontend();

// Remove useless and bloated stuff from frontend
new mktFrontendClean();

// Manintenance mode functions
new mktMaintenance();

// Error pages
new mktErrorPages();

// Page maintenance mode
add_action('mkt_container_start','mkt_page_maintenance',99);

/*---------------------------------------------------------------------------------------
  ____ _   _ ____ _____ ___  __  __ ___ __________ 
 / ___| | | / ___|_   _/ _ \|  \/  |_ _|__  / ____|
| |   | | | \___ \ | || | | | |\/| || |  / /|  _|  
| |___| |_| |___) || || |_| | |  | || | / /_| |___ 
 \____|\___/|____/ |_| \___/|_|  |_|___/____|_____|

---------------------------------------------------------------------------------------*/

/**
 * Assets, customizations, optimizations and more for the frontend.
 *
 */
class mktFrontend{

	/**
	 * Actions and filters.
	 * 
	 */
	public function __construct() {

		/* Filters ----------------------------------------------------------------------------*/

		// Custom login url and text in login page
		add_filter('login_headerurl',[$this,'login_headerurl']);
		add_filter('login_headertext',[$this,'login_headertext']);

		// Add onload to stylesheets
		add_filter('style_loader_tag',[$this,'webfonts_attr_onload'],10,4);

		// Remove version in CSS and JS        
		add_filter('style_loader_src',[$this,'remove_css_js_wp_version'],10,2);
		add_filter('script_loader_src',[$this,'remove_css_js_wp_version'],10,2);

		// Add body class to handle menu position upon user field choice
		add_filter('body_class',[$this,'desktop_nav_body_class']);

		// Add post category names to body class
		add_filter('body_class',[$this,'add_post_category_names_to_body_class']);

		// Add page slug to body class
		add_filter('body_class',[$this,'add_page_slug_to_body_class']);

		// Add user role to body class
		add_filter('body_class',[$this,'add_user_role_to_body_class']);

		// Remove Jetpack styles
		add_filter( 'jetpack_sharing_counts','__return_false',99);
		add_filter( 'jetpack_implode_frontend_css','__return_false',99);

		/* Actions ----------------------------------------------------------------------------*/

		// Archives redirects
		add_action('template_redirect',[$this,'disable_archives']);

		// Set default cookie
		add_action('init',[$this,'default_cookie']);

		// Enqueue login stylesheet
		add_action('login_enqueue_scripts',[$this,'login_enqueue_scripts']);

		// Custom CSS for login page
		add_action('login_head',[$this,'login_head']);

		// Enqueue styles
		add_action('wp_enqueue_scripts',[$this,'register_styles']);

		// Enqueue scripts
		add_action('wp_enqueue_scripts',[$this,'register_scripts']);
		add_action('wp_enqueue_scripts',[$this,'scripts_optimize'],100);

		// Add CSS font name reference for Woff files
		add_action('wp_head',[$this,'font_face']);

		// Print favicons in header
		add_action('wp_head',[$this,'favicons']);

		// Add preconnections
		add_action('wp_head',[$this,'resource_hints'],2);

		// Print JS vars in header
		add_action('wp_head',[$this,'js_vars'],PHP_INT_MAX);

		// Print custom scripts in header
		add_action('wp_head',[$this,'header_scripts'],PHP_INT_MAX);

		// Print custom inlines CSS in header
		add_action('wp_head',[$this,'css_inline'],PHP_INT_MAX);

		// Add optional custom CSS in post and page header
		add_action('wp_head',[$this,'post_custom_css_in_head'],PHP_INT_MAX);

		// Add Google Maps JSON style
		add_action('wp_footer',[$this,'google_map_style']);

		/* Custom hooks -----------------------------------------------------------------------*/

		// Body
		add_action('mkt_body_start',[$this,'body_scripts'],10);
		add_action('mkt_body_start',[$this,'display_nav_menus'],11);

		// Footer
		add_action('mkt_footer',[$this,'footer_blocks']);
		add_action('mkt_footer_after',[$this,'footer_scripts'],10);

        /*----------------------------------------------------------------------------*/
        // Media

		// Add lazy loading to iframes
		add_filter('wp_iframe_tag_add_loading_attr','__return_true');

		// !!! This works only sometimes
		add_filter('wp_lazy_loading_enabled','__return_true');

	}

	/**
	 * Custom url in login page.
	 */
	public function login_headerurl() : string {
		// Get home URL
		$home_url = get_home_url();
		return $home_url;
	}

	/**
	 * Custom link text in login page.
	 */
	public function login_headertext() : string {
		// Get site name
		$site_name = get_option('blogname');
		return $site_name;
	}

	/**
	 * Enqueue login stylesheet.
	 */
	public function login_enqueue_scripts() : void {
		// Register style
		wp_register_style(
			'login-style', 
			get_template_directory_uri() . '/project/assets/css/login.css'
		);
		// Enqueue style
		wp_enqueue_style(
			'login-style'
		);
	}

	/**
	 * Add custom CSS to login page.
	 */
	public function login_head() : void {
		// Default style value
		$style = '<style>';
		// $font_name = strtok( str_replace( 'https://fonts.googleapis.com/css2?family=', '', $font ), ':' );
		// 1. Embed fonts
		/*-------------------------------------------------------------------------------------*/
		// Custom Google font
		if( 
			isset(get_field('google_fonts','options')['url']) 
			&& !empty(get_field('google_fonts','options')['url']) 
		) {
			// Get font stylesheet
			$font = get_field('google_fonts','options')['url'];
			// Preconnect stylesheet host
			echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
			// Preconnect fonts host (crossorigin is needed for fonts)
			echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
			// Preload
			echo '<link rel="preload" crossorigin="anonymous" as="style" href="' . esc_url($font) . '">';
			// Embed stylesheet
			echo '<link rel="stylesheet" href="' . esc_url($font) . '" media="print" onload="this.media=\'all\'">';
		}
		/*-------------------------------------------------------------------------------------*/
		// Custom WOFF font
		elseif( 
			isset(get_field('primary_font_woff','options')['url']) 
			&& !empty(get_field('primary_font_woff','options')['url']) 
		) {
			// Get font URL
			$font = get_field('primary_font_woff', 'options')['url'];
			// Woff font
			echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url($font) . '">';
			$style .= '@font-face{font-family:"Primary Font";src:url("' . esc_url($font) . ' format("woff");}';
		}
		/*-------------------------------------------------------------------------------------*/
		// Adobe font
		elseif( 
			isset(get_field('adobe_fonts','options')['url']) 
			&& !empty(get_field('adobe_fonts','options')['url']) 
		) {
			// Get font stylesheet
			$font = get_field('adobe_fonts', 'options')['url'];
			// Preconnect
			echo '<link rel="preconnect" href="https://use.typekit.net" crossorigin>';
			echo '<link rel="preconnect" href="https://p.typekit.net" crossorigin>';
			// Preload
			echo '<link rel="preload" as="style" href="' . esc_url($font) . '">';
			// Embed stylesheet
			echo '<link rel="stylesheet" href="' . esc_url($font) . '"  media="print" onload="this.media=\'all\'">';
		}
		/*-------------------------------------------------------------------------------------*/
		// Default font
		else{
			// Default font stylesheet
			$font = 'https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,400;1,400;1,700&display=swap';
			// Preconnect stylesheet host
			echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
			// Preconnect fonts host (crossorigin is needed for fonts)
			echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
			// Preload
			echo '<link rel="preload" crossorigin="anonymous" as="style" href="' . esc_url($font) . '">';
			// Embed stylesheet
			echo '<link rel="stylesheet" href="' . esc_url($font) . '" media="print" onload="this.media=\'all\'">';
		}
		/*-------------------------------------------------------------------------------------*/
		// 2. Logo and custom style
		// Default logo values
		$logo_url = get_template_directory_uri() . '/core/assets/icons/mkt.svg';
		$logo_width = '60px';
		$logo_height = '60px';
		// Custom logo
		$logo_custom = get_field('logo_other_version', 'options');
		// Get custom logo
		if( isset($logo_custom['img']) && !empty($logo_custom['img']) ) {
			// Update logo values
			$logo_url = wp_get_attachment_url( $logo_custom['img'] );
			$logo_width = $logo_custom['width'] . 'px ';
			$logo_height = $logo_custom['height'] . 'px ';
		}
		// Add logo URL and sizes variables to style var
		$style .= ':root {--logo-width: ' . $logo_width . ';--logo-height: ' . $logo_height . ';}#login h1 a {background-image: url(' . $logo_url . ');}
		';
		// Custom style
		if( get_field('login_style_css', 'options') ) {
			// Add custom rules to style var
			$style .= get_field('login_style_css', 'options');
		}
		$style .= '</style>';
		/*-------------------------------------------------------------------------------------*/
		echo $style;
	}

	/**
	 * Change media attribute and add onload attribute.
	 * @inspired by https://matthewhorne.me/defer-async-wordpress-scripts/
	 * @param string $tag
	 * @param string $handle
	 */
	public function webfonts_attr_onload( $tag, $handle, $href, $media ) : string {
		// If is not the backend
		if( !is_admin() ) {
			if( str_contains($handle,'font-google') ) {
				$tag = '<link rel="stylesheet" id="font-google-css" href="' . esc_url($href) . '" media="print"  onload="this.media=\'all\'" />';
			/* !!! For some reasons this doesn't work
			}elseif(str_contains( $handle,'font-adobe') ) {
				$tag = '<link rel="stylesheet" id="font-adobe-css" href="' . esc_url($href) . '" media="print" onload="this.media=\'all\'" />';
			*/
			}
		}
		return $tag;
	}

	/**
	 * Remove version from JS scripts and CSS files.
	 * @param string $src
	 */
	public function remove_css_js_wp_version( $src ) : string {
		// Bail out early
		if( is_admin() ) {
			return $src;
		}
		// If versions
		if(str_contains($src,'ver=')) {   
			$src = remove_query_arg('ver', $src);
		}
		return $src;
	}

	/**
	 * Custom navigation position with CSS class in pages.
	 * @param array $classes
	 */
	public function desktop_nav_body_class( $classes ) : array {
		// Bail out early if this is not a page
		if( is_page() ) {
			// Get global
			global $post;
			// If page
			if( get_post_type($post) == 'page' ) {
				// Add classes
				$classes[] = get_field('desktop_navigation', $post->ID);
			}
		}
		return $classes;
	}

	/**
	 * Add categories to body class.
	 * @param array $classes
	 */
	public function add_post_category_names_to_body_class( $classes ) : array {
		// Bail out early if this is not a post
		if( !is_singular('post') ) {
			return $classes;
		}
		// Get post    
		global $post;
		// Get categories
		$categories = get_the_category($post->ID);
		// Loop categories
		foreach( $categories as $category ) {
			$classes[] = 'cat-' . $category->slug;
		}
		return $classes;
	}

	/**
	 * Add page slug to body class.
	 * @param array $classes
	 */
	public function add_page_slug_to_body_class( $classes ) : array {
		if( is_page() ) {
			// Get post
			global $post;
			if( $post ) {
				$classes[] = 'page-' . $post->post_name;
			}
		}
		return $classes;
	}

	/**
	 * Add user role to body class.
	 * @param array $classes
	 */
	public function add_user_role_to_body_class( $classes ) : array {
		// Bail out early if user is not logged in
		if( !is_user_logged_in() ) {
			return $classes;
		}
		// Add user role as body class
		$user_role = get_user_role(get_current_user_id());
		$classes[] = 'role-' . $user_role;
		// Add mkt-user as body class
		if( current_user_can('manage_mkt_options') ) {
			$classes[] = 'mkt-user';
		}
		return $classes;
	}

	/**
	 * Conditionally disable archives.
	 * - Date
	 * - Author
	 * - Category
	 * - Tag
	 */
	public function disable_archives() : void {
		// Date archive
		if( get_field('disable_date_archive','options') ) {
			// Get global
			global $wp_query;
			// If this a date archive
			if($wp_query->is_date) {
				// Redirect to homepage
				wp_safe_redirect(get_bloginfo('url'),301);
				exit;
			}
		}
		// Author archive
		if( get_field('disable_author_archive','options') ) {
			// Get global
			global $wp_query;
			// If this an author archive
			if($wp_query->is_author) {
				// Redirect to homepage
				wp_safe_redirect(get_bloginfo('url'),301);
				exit;
			}
		}
		// Category archive
		if( get_field( 'disable_category_archive', 'options' ) ) {
			// Get global
			global $wp_query;
			// If this a category archive
			if($wp_query->is_category) {
				// Redirect to homepage
				wp_safe_redirect(get_bloginfo('url'),301);
				exit;
			}
		}
		// Tag archive
		if( get_field( 'disable_tag_archive', 'options' ) ) {
			// Get global
			global $wp_query;
			// If this a tag archive
			if($wp_query->is_tag) {
				// Redirect to homepage
				wp_safe_redirect(get_bloginfo('url'),301);
				exit;
			}
		}
	}

	/**
	 * Set Mkt default cookie.
	 */
	public function default_cookie() : void {
		// Cookie name
		$name = parse_url(home_url());
		$name = $name['host']; 
		// Set default cookie
		if( !isset($_COOKIE[$name]) ) {
			// One month
			mkt_cookie(
				$name,
				time(),
				MONTH_IN_SECONDS
			);
		}
	}

	/**
	 * Register and enqueue frontend stylesheets.
	 */
	public function register_styles() : void {
		/*-------------------------------------------------------------------------------------*/
		// Google fonts
		$google_fonts = get_field('google_fonts', 'options');
		// If Google fonts
		if( isset($google_fonts['url']) && !empty($google_fonts['url']) ) {
			// Add preload to handle
			// $handle = ( $google_fonts['preload'] ) ? 'font-google-preload' : 'font-google';
			// Register style
			wp_register_style(
				'font-google', 
				$google_fonts['url'],
				[],
				null, // https://core.trac.wordpress.org/ticket/49742
				'all'
			);
			// Enqueue style
			wp_enqueue_style(
				'font-google'
			);
		}
		/*-------------------------------------------------------------------------------------*/
		// Adobe fonts
		$adobe_fonts = get_field('adobe_fonts', 'options');
		// If Adobe fonts
		if( isset($adobe_fonts['url']) && !empty($adobe_fonts['url']) ) {
			// Add preload to handle
			// $handle = ( $google_fonts['preload'] ) ? 'font-google-preload' : 'font-google';
			// Register style
			wp_register_style(
				'font-adobe', 
				$adobe_fonts['url']
			);
			// Enqueue style
			wp_enqueue_style(
				'font-adobe'
			);
		}
		/*-------------------------------------------------------------------------------------*/
		// Woff fonts
		$primary_font_woff = get_field('primary_font_woff', 'options');
		$secondary_font_woff = get_field('secondary_font_woff', 'options');
		$extra_font_woff = get_field('extra_font_woff', 'options');
		// If WOFF primary font
		if( isset($primary_font_woff['url']) && !empty($primary_font_woff['url']) ) {
			// Add preload to handle
			// $handle = ( $primary_font_woff['preload'] ) ? 'primary-font-woff-preload' : 'primary-font-woff';
			// Register style
			wp_register_style(
				'primary-font-woff', 
				$primary_font_woff['url']
			);
			// Enqueue style
			wp_enqueue_style(
				'primary-font-woff'
			);		
		}
		/*-------------------------------------------------------------------------------------*/
		// If WOFF secondary font
		if( isset($secondary_font_woff['url']) && !empty($secondary_font_woff['url']) ) {
			// Add preload to handle
			// $handle = ( $secondary_font_woff['preload'] ) ? 'secondary-font-woff-preload' : 'secondary-font-woff';
			// Register style
			wp_register_style(
				'secondary-font-woff', 
				$secondary_font_woff['url']
			);
			// Enqueue style
			wp_enqueue_style(
				'secondary-font-woff' 
			);		
		}
		/*-------------------------------------------------------------------------------------*/
		// If WOFF extra font
		if( isset($extra_font_woff['url']) && !empty($extra_font_woff['url']) ) {
			// Add preload to handle
			// $handle = ( $extra_font_woff['preload'] ) ? 'extra-font-woff-preload' : 'extra-font-woff';
			// Register style
			wp_register_style(
				'extra-font-woff', 
				$extra_font_woff['url']
			);
			// Enqueue style
			wp_enqueue_style(
				'extra-font-woff' 
			);		
		}
		/*-------------------------------------------------------------------------------------*/
		// Register theme CSS file
		wp_register_style( 
			'theme-frontend', 
			get_template_directory_uri() . '/project/assets/css/frontend.css',
			false,
			null,
			'all'
		);
		/*-------------------------------------------------------------------------------------*/
		// Register custom CSS file for quick changes
		wp_register_style( 
			'frontend-custom', 
			get_template_directory_uri() . '/project/assets/css/custom.css',
			false,
			null,
			'all'
		);
		/*-------------------------------------------------------------------------------------*/
		// Plugin CSS
		// Register script that can eventually be enqueued in functions.php
		// The best-practice is to import the css fiel directly into main stylesheet (see project/assets/scss/frontend.scss)
		// Swiper
		wp_register_style(
			'swiper',
			'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css',
			// 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css',
			false,
			null,
			'all'
		);
		// Sal
		wp_register_style(
			'sal',
			get_template_directory_uri() . '/core/assets/js/libraries/sal/sal.css',
			false,
			null,
			'all'
		);
		// Photoswipe - Image lightbox css
		wp_register_style(
			'photoswipe',
			'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.3.4/photoswipe.min.css',
			false,
			null,
			'all'
		);
		// Light Gallery - Image and video lightbox css
		wp_register_style(
			'light-gallery',
			'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lightgallery.min.css',
			false,
			null,
			'all'
		);
		// Video gallery - Light gallery video lightbox css
		wp_register_style(
			'video-gallery',
			'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lg-video.min.css',
			false,
			null,
			'all'
		);
		/*-------------------------------------------------------------------------------------*/
		// Enqueue styles
		wp_enqueue_style('theme-frontend');
		/*-------------------------------------------------------------------------------------*/
		// Conditionally enqueue style
		if( get_field('custom_css','options') ) {
			wp_enqueue_style('frontend-custom');
		}
	}

	/**
	 * Register and enqueue frontend scripts.
	 */
	public function register_scripts() : void {
		/*-------------------------------------------------------------------------------------*/
		// Register scripts
		/*-------------------------------------------------------------------------------------*/
		// jQuery
		wp_deregister_script('jquery');
		// Register custom version of jQuery
		wp_register_script(
			'jquery', 
			'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js',
			[], 
			null, 
			true 
		);
		// jQuery
		wp_enqueue_script('jquery');
		// Deregister jQuery and jQuery Migrate
		wp_deregister_script('jquery-migrate');
		// wp_deregister_script('wp-embed');
		/*-------------------------------------------------------------------------------------*/
		// Translation dependency
		$lang_deps = null;
		if( mkt_plugin_active('wpml') ) {
			$lang_deps = 'wp-i18n';
		}
		/*-------------------------------------------------------------------------------------*/
		// Minified suffix
		$min = '.min';
		if( get_field('dev_mode','boost-options') ) {
			$min = null;
		}
		/*-------------------------------------------------------------------------------------*/
		// Register theme JS file
		// If the frontend.js file in project is not available
		// load core-frontend.js file from core.
		$project_js_file = get_template_directory() . '/project/assets/js/frontend.js';
		// Check file
		$theme_js_file = file_exists($project_js_file) ? 'project' : 'core';
		// Regsiter script from project
		wp_register_script( 
			'theme-frontend', 
			get_template_directory_uri() . '/' . $theme_js_file . '/assets/js/frontend' . $min . '.js', 
			// ['jquery',$lang_deps], 
			['jquery'], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Block scripts
		// These scripts that can eventually be enqueued in functions.php
		// Photoswipe
		wp_register_script( 
			'photoswipe', 
			'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.3.8/umd/photoswipe.umd.min.js', 
			[], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Photoswipe Lightbox
		wp_register_script( 
			'photoswipe-lightbox', 
			'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.3.8/umd/photoswipe-lightbox.umd.min.js', 
			['photoswipe'], 
			null, 
			false
		);
		/*-------------------------------------------------------------------------------------*/
		// Plugin script 
		// These scripts that can eventually be enqueued in functions.php
		// !!! Lottie and Paroller (or similar) are missing
		/*-------------------------------------------------------------------------------------*/
		// Vimeo
		wp_register_script( 
			'vimeo', 
			'https://player.vimeo.com/api/player.js', 
			array(), 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Hammer - Swipe for mobile
		wp_register_script( 
			'hammer', 
			'https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js',
			[], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Hammer jQuery extension (jsdelivr)
		wp_register_script( 
			'hammer-jquery', 
			'https://cdn.jsdelivr.net/npm/jquery-hammerjs@2.0.0/jquery.hammer.min.js',
			['jquery','hammer'], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Hammer touch emulator (jsdelivr)
		wp_register_script( 
			'hammer-jquery', 
			'https://cdn.jsdelivr.net/npm/hammer-touchemulator@0.0.2/touch-emulator.min.js',
			['jquery','hammer','hammer-jquery'], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Swiper
		wp_register_script( 
			'swiper', 
			'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js',
			// 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js',
			[], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Masonry
		wp_register_script( 
			'salvattore', 
			'https://cdnjs.cloudflare.com/ajax/libs/salvattore/1.0.9/salvattore.min.js', 
			[], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Sal (jsdelivr)
		wp_register_script(
			'sal', 
			'https://cdn.jsdelivr.net/npm/sal@1.2.1/index.min.js',
			[], 
			null, 
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Light Gallery - Image and video lightbox js
		wp_register_script(
			'light-gallery',
			'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js',
			[],
			null,
			// filemtime(get_template_directory() . '/project/assets/js/'light-gallery/lightgallery.min.js'),
			false
		);
		/*-------------------------------------------------------------------------------------*/
		// Video Gallery - Light gallery video lightbox js
		wp_register_script(
			'video-gallery',
			'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/video/lg-video.min.js',
			['light-gallery'],
			null,
			// filemtime(get_template_directory() . '/project/assets/js/light-gallery/lg-video.min.js'),
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Export CSV
		wp_register_script(
			'xlsx-core',
			'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.core.min.js',
			['jquery'],
			null,
			// filemtime(get_template_directory() . '/project/assets/js/xlsx.core.min.js'),
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Needed for xlsx-core
		wp_register_script(
			'file-saver',
			'https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js',
			['jquery','xlsx-core'],
			null,
			// filemtime(get_template_directory() . '/project/assets/js/FileSaver.min.js'),
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Needed for xlsx-core
		wp_register_script(
			'table-export',
			'https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js',
			['jquery','xlsx-core','file-saver'],
			null,
			// filemtime(get_template_directory() . '/project/assets/js/tableexport.min.js'),
			true
		);
		/*-------------------------------------------------------------------------------------*/
		// Enqueue scripts
		/*-------------------------------------------------------------------------------------*/
		// Conditionally enqueue script only in development mode
		// It the script will be used in production they must be optimized
		// Other scripts must be enqueued before frontend.js
		if( get_field('dev_mode','boost-options') ) {
			
			// Sal JS
			if( get_field('sal_js','options') ) {
				wp_enqueue_script('sal'); 	
			}
		}
		/*-------------------------------------------------------------------------------------*/
		// Theme JS file is the last to be enqueued
		wp_enqueue_script('theme-frontend');   
		/*-------------------------------------------------------------------------------------*/
		// Blocks
		if( is_singular() ) {
			// Get post
			global $post;
			// Photoswipe
			if( has_block( 'acf/photoswipe-gallery', $post->ID ) ) {
				wp_enqueue_script('photoswipe');
				wp_enqueue_script('photoswipe-lightbox');
			}
		}
	}

	/**
	 * This function is loaded very late 
	 * to avoid loading unwanted scripts and styles.
	 *
	 * @return void
	 */
	public function scripts_optimize() {
		// Dequeue Gutenberg styles
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		// Remove Woocommerce Block CSS
		wp_dequeue_style( 'wc-block-style' );
		// Remove theme.json
		wp_dequeue_style( 'global-styles' );
		// Enqueue Vimeo JS only on singular templates
		if( is_singular() && get_field('vimeo_player','options') ) {
			wp_enqueue_script('vimeo');
		}
	}

	/**
	 * Register font face for custom static 
	 * fonts loaded from Page Options.
	 * Font Names are: 
	 * - Primary Font
	 * - Secondary Font
	 * - Extra Font
	 */
	public function font_face()  : void {
		// Check
		$check = 0;
		// Woff fonts
		$primary_font_woff = get_field('primary_font_woff', 'options');
		$secondary_font_woff = get_field('secondary_font_woff', 'options');
		$extra_font_woff = get_field('extra_font_woff', 'options');
		/*-------------------------------------------------------------------------------------*/
		$html = '<style>';
		/*-------------------------------------------------------------------------------------*/
		if( isset($primary_font_woff['url']) && !empty($primary_font_woff['url']) ) {
			$check++;
			$url = $primary_font_woff['url'];
			$extension = get_file_extension( $url );
			$html .= '@font-face { font-family: "Primary Font"; src: url("' . esc_url($url) . '") format("' . $extension . '"); }';
		}
		/*-------------------------------------------------------------------------------------*/
		if( isset($secondary_font_woff['url']) && !empty($secondary_font_woff['url']) ) {
			$check++;
			$url = $secondary_font_woff['url'];
			$extension = get_file_extension( $url );
			$html .= '@font-face { font-family: "Secondary Font"; src: url("' . esc_url($url) . '") format("' . $extension . '"); }';
		}
		/*-------------------------------------------------------------------------------------*/
		if( isset($extra_font_woff['url']) && !empty($extra_font_woff['url']) ) {
			$check++;
			$url = $extra_font_woff['url'];
			$extension = 'woff';
			$extension = get_file_extension( $url );
			$html .= '@font-face { font-family: "Extra Font"; src: url("' . esc_url($url) . '") format("' . $extension . '"); }';	
		}
		/*-------------------------------------------------------------------------------------*/
		$html .= '</style>';
		/*-------------------------------------------------------------------------------------*/
		if( $check > 0 ) {
			echo $html;
		}
	}

	/**
	 * Add favicon and configuration files in webiste head.
	 */
	public function favicons() : void {
		// Get favicon field
		$favicons = get_field('favicons','options');
		// Check that value is not null
		if( is_array( $favicons ) ) {
			// Get favicon code
			if( $favicons['favicon_code'] ) {
				echo $favicons['favicon_code'];
			}
		}
	}

	/**
	 * Resource hints in head.
	 */
	public function resource_hints() : void { 
		// Only for posts
		if( is_singular() ) {
			// Get post
			global $post;
			// If preload image
			if( get_field( 'preload_image', $post->ID ) ) {
				echo '<link rel="preload" as="image" href="' . wp_get_attachment_url( get_field( 'preload_image', $post->ID ) ) . '">' . PHP_EOL;
			}
		}
		// Print resource hints
		echo get_field( 'resource_hints', 'boost-options' );
	}

	/**
	 * Load JS variables to be used in other JS files.
	 * !!! This should be a unique JSON file.
	 * - themeUrl
	 * - siteUrl
	 * - ajaxUrl
	 * - months
	 * - weekdays
	 */
	public function js_vars() : void {
		// Weekdays
		$weekdays = array_values(mkt_get_weekdays());
		// Months
		$months = array_values(mkt_get_months());
		// Variables
		$vars = [
			'themeUrl'          =>  'var themeUrl = "' . get_template_directory_uri() . '/";',
			'siteUrl'           =>  'var siteUrl = "' . get_home_url() . '/";',
			'ajaxUrl'           =>  'var ajaxUrl = "' . get_admin_url() . 'admin-ajax.php";',
			'jsUrl'           	=>  'var jsUrl = "' . get_template_directory_uri() . '/core/assets/js/";',
			'months'            =>  'var months = ' . json_encode($months) . ';',
			'weekdays'          =>  'var weekdays = ' . json_encode($weekdays) . ';',
			'privacyUrl'        =>  'var privacyUrl = "' . get_privacy_policy_url() . '";',
		];  
		// Variables for Google Maps
		if( get_field('google_maps_api_key','options') ) {
			// Get field
			$google_maps_api_key = get_field( 'google_maps_api_key', 'options' );
			// Api Key
			$vars['google_maps_api_key'] = 'var mapKey = "' . $google_maps_api_key . '";';
			// Api Key URL
			$vars['google_maps_api_key_url'] = 'var mapKeyUrl = "https://maps.googleapis.com/maps/api/js?key=' . $google_maps_api_key . '";';
			// If map JS file exists (project or core)
			if( file_exists( get_template_directory() . '/project/assets/js/map.js' ) ) {
				// Map JS       
				$vars['mapUrl'] = 'var mapUrl = "' . get_template_directory_uri() . '/project/assets/js/map.js";';
			}elseif( file_exists( get_template_directory() . '/core/assets/js/map.js' ) ) {
				// Map JS       
				$vars['mapUrl'] = 'var mapUrl = "' . get_template_directory_uri() . '/core/assets/js/map.js";';
			}
		}
		// !!! This colud also be a JSON object
		echo '<script>' . implode( ' ', $vars ) . '</script>' . PHP_EOL;
	}

	/**
	 * Print JS scripts in header.
	 */
	public function header_scripts() : void {
		// If header scripts
		if( get_field('scripts_head','options') ) {
			// Minify scripts
			echo mkt_minifier(get_field('scripts_head', 'options'));
		}
	}

	/**
	 * Print inline CSS in header.
	 */
	public function css_inline() : void {
		// If CSS inline
		if (get_field('css_inline','options')) {
			echo '<style>' . mkt_minifier(get_field('css_inline', 'options')) . '</style>';
		}
	}

	/**
	 * Add optional custom CSS in post and page header.
	 */
	public function post_custom_css_in_head() : void {
		// Bail out early
		if( !is_singular() ) {
			return;
		}
		// Get post
		global $post;
		// Bail out if no options
		if( !get_field('page_custom_css',$post->ID) ) {
			return;
		}
		// HTML
		echo '<style>' . get_field( 'page_custom_css', $post->ID ) . '</style>';
	}

	/**
	 * Load JS variable used as map style.
	 * @param boolean $map_inclusion
	 */
	public function google_map_style( $map_inclusion ) : void { 
		// Default value
		$map_inclusion = true;
		// Filter for custom conditions
		$map_inclusion = apply_filters('mkt_map_style_inclusion',$map_inclusion);
		// Check if post has block map
		if( is_singular() ) {
			// Get post
			global $post;
			// If has map block
			if( has_block('acf/map',$post->ID) ) {
				$map_inclusion = true;
			}
		}
		// Bail out early
		if( !$map_inclusion ) {
			return;
		}
		// If custom style
		$map_style = get_field('google_maps_style','options');
		// Default values
		if( !$map_style ) {
			// Light color
			$color_light = get_field('map_color_light','options');
			// If custom light color
			$color_light = $color_light ? $color_light : '#ffffff';
			// Dark color
			$color_dark = get_field('map_color_dark','options');
			// If custom dark color
			$color_dark = $color_dark ? $color_dark : '#999999';
			// Map style array
			$map_style = [
				// Administrative / Geometry stroke
				[
					'featureType'   =>  'administrative',
					'elementType'   =>  'geometry.stroke',
					'stylers'       =>  [
						['visibility'    =>  'on'],
						['color'         =>  $color_dark],
						['weight'        =>  '0.30'],
					]
				],
				// Administrative / Labels text fill
				[
					'featureType'   =>  'administrative',
					'elementType'   =>  'labels.text.fill',
					'stylers'       =>  [
						['color' =>  $color_dark],
					]
		
				],
				// Administrative / Labels text stroke
				[
					'featureType'   =>  'administrative',
					'elementType'   =>  'labels.text.stroke',
					'stylers'       =>  [
						['visibility'    =>  'on'],
						['color'         =>  $color_light],
						['weight'        =>  '6'],
					]
				],
				// Administrative / Labels icon
				[
					'featureType'   =>  'administrative',
					'elementType'   =>  'labels.icon',
					'stylers'       =>  [
						['visibility'    =>  'on'],
						['color'         =>  $color_dark],
						['weight'        =>  '1'],
					]
				],
				// Landscape / All
				[
					'featureType'   =>  'landscape',
					'elementType'   =>  'all',
					'stylers'       =>  [
						['color'         =>  $color_light],
					]
				],
				// Points of interest / All
				[
					'featureType'   =>  'poi',
					'elementType'   =>  'all',
					'stylers'       =>  [
						['visibility'   =>  'off'],
					]
				],
				// Road / All
				[
					'featureType'   =>  'road',
					'elementType'   =>  'all',
					'stylers'       =>  [
						['visibility'   =>  'simplified'],
						['color'        =>  $color_dark],
					]
				],
				// Road / Labels text
				[
					'featureType'   =>  'road',
					'elementType'   =>  'labels.text',
					'stylers'       =>  [
						['visibility'   =>  'on'],
						['color'        =>  $color_light],
						['weight'       =>  '8'],
					]
				],
				// Road / Labels text fill
				[
					'featureType'   =>  'road',
					'elementType'   =>  'labels.text',
					'stylers'       =>  [
						['visibility'   =>  'on'],
						['color'        =>  $color_dark],
						['weight'       =>  '8'],
					]
				],
				// Road / Labels text icon
				[
					'featureType'   =>  'road',
					'elementType'   =>  'labels.text',
					'stylers'       =>  [
						['visibility'   =>  'off'],
					]
				],
				// Transit / Labels text icon
				[
					'featureType'   =>  'transit',
					'elementType'   =>  'all',
					'stylers'       =>  [
						['visibility'   =>  'off'],
						// ['visibility'   =>  'simplified'],
						// ['color'        =>  $color_dark],
					]
				],
				// Water / Geometry fill
				[
					'featureType'   =>  'water',
					'elementType'   =>  'geometry.fill',
					'stylers'       =>  [
						['visibility'   =>  'on'],
						['color'        =>  $color_dark],
					]
				],
				// Water / Labels text
				[
					'featureType'   =>  'water',
					'elementType'   =>  'labels.text',
					'stylers'       =>  [
						['visibility'   =>  'simplified'],
						['color'        =>  $color_light],
					]
				],
				// Water / Labels icon
				[
					'featureType'   =>  'water',
					'elementType'   =>  'labels.text',
					'stylers'       =>  [
						['visibility'   =>  'off'],
					]
				],
			];
			// Encode JSON
			$map_style = json_encode($map_style);
		} 
		echo '<script>var mapStyle = ' . $map_style . ';</script>';
	}

	/**
	 * Print JS scripts in body.
	 */
	public function body_scripts() : void {
		// If body scripts
		if( get_field('scripts_body','options') ) {
			// Minify scripts
			echo mkt_minifier(get_field('scripts_body', 'options'));
		}
	}

	/**
	 * Display desktop and mobile navigation menus.
	 */
	public function display_nav_menus() : void {
		// If this is a single
		if( is_singular() ) {
			// Get post
			global $post;
			// If navigation hidden options
			if( get_field('toggle_main_nav',$post) ) {
				// Add filter
				add_filter('mkt_wrap_class_filter',function( $classes ) {
					// Add class to array
					$classes[] = 'no-nav';
					return $classes;
				});
				return;
			}
		}
		/*$desktop_menu = ( get_field('menu_desktop','option) ) ? get_field('menu_desktop','option) : 'default';
		get_template_part( 'core/menus/menu-desktop', $desktop_menu );
		$mobile_menu = ( get_field('menu_mobile','options') ) ? get_field('menu_mobile','options') : 'default';
		get_template_part( 'core/menus/menu-mobile', $mobile_menu );*/
		// Get desktop menu options
		$desktop_menu = get_field('menu_desktop','options');
		// If any value
		if( $desktop_menu ) {
			if( $desktop_menu == 'block' ) {
				// If "block" render the custom block
				mkt_get_content( get_field('menu_block','options') );
			}elseif( $desktop_menu == 'template' ) {
				// If template get the custom template
				get_template_part(get_field('menu_template','options'));
			}else{
				// Else get get one of the default templates
				get_template_part('core/menus/menu-desktop',$desktop_menu);
			}
		}else{
			// If no value selected use default desktop menu
			get_template_part('core/menus/menu-desktop', 'default');
		}
		// Get mobile menu option
		if( $desktop_menu != 'block' ) {
			// Get mobile menu template
			get_template_part('core/menus/menu-mobile','default');
		}
	}

	/**
	 * Render reusable blocks in footer.
	 */
	public function footer_blocks() : void {
		// Get footer blocks
		$footer_blocks = get_field('footer_common_blocks','options');
		// If footer blocks
		if( $footer_blocks ) {
			// Loop blocks
			foreach( $footer_blocks as $footer_block ) {
				// Parse blocks
				mkt_get_content( $footer_block );
			}
		}
	}

	/**
	 * Print JS scripts in footer.
	 */
	public function footer_scripts() : void {
		// If footer scripts
		if( get_field('scripts_footer','options') ) {
			// Minify scripts
			echo mkt_minifier(get_field('scripts_footer', 'options'));
		}
		// If this is a post
		if( is_singular() ) {
			// Get post
			global $post;
			// Photoswipe
			if( has_block( 'acf/photoswipe-gallery', $post->ID ) ) { ?>
				<script type="text/javascript">
					var lightbox = new PhotoSwipeLightbox({
						gallery: '.mkcf-gallery',
						children: 'a',
						pswpModule: PhotoSwipe 
					});
					lightbox.init();
				</script>
			<?php }
		}
	}

}

/*---------------------------------------------------------------------------------------
  ____ _     _____    _    _   _ _   _ ____  
 / ___| |   | ____|  / \  | \ | | | | |  _ \ 
| |   | |   |  _|   / _ \ |  \| | | | | |_) |
| |___| |___| |___ / ___ \| |\  | |_| |  __/ 
 \____|_____|_____/_/   \_\_| \_|\___/|_|

---------------------------------------------------------------------------------------*/

/**
 * Remove useless and bloated stuff from frontend.
 *
 */
class mktFrontendClean{

	/**
	 * Actions and filters.
	 * 
	 */
	public function __construct() {
		
		// Cleanup stuff
		add_action('after_setup_theme',[$this,'start_cleanup']);
		
		// Deregister unnecessary styles
		add_action('wp_enqueue_scripts',[$this,'dequeue_classic_theme_styles'],20);

	}

	/**
	 * Series of actions and filters hooke after setup theme to clean up frontend head.
	 */
	public function start_cleanup() : void {

		// Launching operation cleanup.
		add_action('init',[$this,'cleanup_head']);
		
		// Remove WP version from RSS.
		add_filter('the_generator','__return_false');
		
		// Remove pesky injected css for recent comments widget.
		add_filter('wp_head',[$this,'remove_wp_widget_recent_comments_style'],1);
		
		// Clean up comment styles in the head.
		add_action('wp_head',[$this,'remove_recent_comments_style'], 1);
		
		// Remove inline width attribute from figure tag
		add_filter('img_caption_shortcode',[$this,'remove_figure_inline_style'],10,3);
		
		// Remove post-formats theme support
		remove_theme_support('post-formats');
	
	}

	/**
	 * Create a clean wordpress head and remove unnecessary clutter.
	 * @link https://gist.github.com/Auke1810/f2a4cf04f2c07c74a393a4b442f22267
	 */
	public function cleanup_head() : void {

		// Edit URI link.
		remove_action('wp_head','rsd_link');
		
		// Category feed links.
		remove_action('wp_head','feed_links_extra',3);
		
		// Post and comment feed links.
		remove_action('wp_head','feed_links',2);
		
		// Windows Live Writer.
		remove_action('wp_head','wlwmanifest_link');
		
		// Index link.
		remove_action('wp_head','index_rel_link');
		
		// Previous link.
		remove_action('wp_head','parent_post_rel_link',10);
		
		// Start link.
		remove_action('wp_head','start_post_rel_link',10);
		
		// Canonical.
		remove_action('wp_head','rel_canonical',10);
		
		// Shortlink.
		remove_action('wp_head','wp_shortlink_wp_head',10);
		
		// Links for adjacent posts.
		remove_action('wp_head','adjacent_posts_rel_link_wp_head',10);
		
		// WP version.
		remove_action('wp_head','wp_generator');
		
		// Emoji detection script.
		remove_action('wp_head','print_emoji_detection_script',7);
		
		// Emoji styles.
		remove_action('wp_print_styles','print_emoji_styles');
	}

	/**
	 * Remove injected CSS for recent comments widget.
	 */
	public function remove_wp_widget_recent_comments_style() : void {
		if( has_filter('wp_head','wp_widget_recent_comments_style') ) {
			remove_filter('wp_head','wp_widget_recent_comments_style');
		}
	}

	/**
	 * Remove injected CSS from recent comments widget.
	 */
	public function remove_recent_comments_style() : void {
		// Get global
		global $wp_widget_factory;
		if( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
			remove_action('wp_head',[$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],'recent_comments_style']);
		}
	}

	/**
	 * Remove inline width attribute 
	 * from figure tag causing images 
	 * wider than 100% of its container.
	 * @param string $output
	 * @param array $attr
	 * @param object $content
	 */
	public function remove_figure_inline_style( $output, $attr, $content ) : string {
		// Attributes
		$atts = shortcode_atts(
			[
				'id'		=> '',
				'align'		=> 'alignnone',
				'width'		=> '',
				'caption'	=> '',
				'class'		=> '',
			],
			$attr,
			'caption'
		);
		// Width
		$atts['width'] = (int) $atts['width'];
		// Check width
		if( $atts['width'] < 1 || empty($atts['caption']) ) {
			return $content;
		}
		// If ID
		if( !empty($atts['id']) ) {
			$atts['id'] = 'id="' . esc_attr($atts['id']) . '" ';
		}
		// Align and class
		$class = trim('wp-caption ' . $atts['align'] . ' ' . $atts['class']);
		// If HTML5 or captions
		if( current_theme_supports('html5','caption') ) {
			return '<figure ' . $atts['id'] . ' class="' . esc_attr($class) . '">'
				. do_shortcode($content) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
		}
	}

	/**
	 * Remove classic-theme-styles CSS file.
	 * This file appeared in WP 6.1 Version, it maybe a bug and could be fixed in the future.
	*/
	public function dequeue_classic_theme_styles() : void {
		wp_dequeue_style('classic-theme-styles');
	}

}

/*---------------------------------------------------------------------------------------
 __  __ _   _ _____   __  __  ___  ____  _____ 
|  \/  | \ | |_   _| |  \/  |/ _ \|  _ \| ____|
| |\/| |  \| | | |   | |\/| | | | | | | |  _|  
| |  | | |\  | | |_  | |  | | |_| | |_| | |___ 
|_|  |_|_| \_| |_(_) |_|  |_|\___/|____/|_____|

---------------------------------------------------------------------------------------*/

/**
 * Manintenance mode functions.
 * 
 */
 class mktMaintenance{

	/**
	 * Actions and filters.
	 * 
	 */
	public function __construct() {

		// Add actions and filters only
		// when maintenance is active
		if( $this->check() ) {    

			// Set HTTP response to 503
			add_filter('wp_headers',[$this,'status'],1);

			// Set cookie
			add_action('init',[$this,'cookie']);

			// Set page-lp.php template to all pages when maintenance mode is activated
			add_filter('template_include',[$this,'page_template'],99);
			
			// Set custom content
			add_filter('the_content',[$this,'page_content'],1);

		}
		
	}

	/**
	 * Check if maintenance mode is activated.
	 * Exlude logged users.
	 */
	private function check() : bool {
		// Bail out early
		if( is_user_logged_in() ) {
			return false;
		}
		// Get field
		$mnt_mode = get_option('options_maintenance_mode_maintenance_mode_option'); // Yes, this is correct
		// Get cookie
		$cookie = mkt_get_cookie('skip_token');
		// Return true or false
		if( $mnt_mode && !$cookie ) {
			return true;
		}else{
			return false;
		}
		/* Old method with get field
		if( 
			isset($mnt_mode['maintenance_mode_option']) 
			&& !empty($mnt_mode['maintenance_mode_option'])
			&& !$cookie ) {
			return true;
		}else{
			return false;
		}*/
	}

	/**
	 * Set maintenance cookie.
	 */
	public function cookie() : void {
		// Get cookie
		$cookie = mkt_get_cookie('skip_token');
		// If no cookie
		if( !$cookie && isset($_GET['skip_token']) && !empty($_GET['skip_token']) ) {
			// Get token
			$token = sanitize_text_field($_GET['skip_token']);
			// Check token
			if( get_field('maintenance_mode','options')['token'] == $token ) {
				// Set cookie
				$nonce = wp_create_nonce('skip_token');
				mkt_cookie('skip_token',$nonce,DAY_IN_SECONDS);
			}
		}
	}

	/**
	 * Set HTTP response to 503.
	 * @link https://yoast.com/http-503-site-maintenance-seo/
	 * @link https://yoast.com/http-503-site-maintenance-seo/
	 * @param array $headers
	 */
	public function status( $headers ) : array {
		// Bail out early
		if( is_admin() ) {
			return $headers;
		}
		$headers[$_SERVER['SERVER_PROTOCOL']] = 503;
		return $headers;
	}

	/**
	 * Set page-lp.php template to all pages 
	 * when maintenance mode is activated.
	 * @param string $template
	 */
	public function page_template( $template ) : string {
		// Get landing page template
		$landing_page = locate_template(['page-lp.php']);
		// If template is found
		if( '' != $landing_page ) {
			return $landing_page;
		}
		return $template;
	}

	/**
	 * Filter the content.
	 * @param string $content
	 */
	public function page_content( $content ) : string {
		// Default post ID
		$post_id = 0;
		// If is singular
		if( is_singular() ) {
			global $post;
			$post_id = $post->ID;
		}
		// Get cookie and privacy policies pages because
		// they will be excluded from the maintenance
		$excluded_pages = [
			get_field('cookie_policy_page', 'options'),
			get_field('privacy_policy_page', 'options')
		];
		// Get any other excluded page
		$other_pages = get_field('maintenance_excluded_posts', 'options') ? get_field('maintenance_excluded_posts','options') : [];
		// Merge array
		$excluded_pages = array_merge($excluded_pages,$other_pages );
		// If this not an excluded page
		if( !in_array( $post_id, $excluded_pages ) ) {
			// Get maintance fields
			$maintenance = get_field('maintenance_mode','options');
			// If custom content
			if( isset($maintenance['maintenance_custom_content']) && !empty($maintenance['maintenance_custom_content']) ) {
				// Parse blocks
				$content = mkt_get_content($maintenance['maintenance_custom_content']);
			}else{
				// Default maintenance page content
				$logo = get_field('logo_light_mode','options');
				$content = '<div class="p-sm flex flex-col justify-center items-center min-h-screen">';
				$content .= '<div class="container-sm text-center">';
				$content .= wp_get_attachment_image( 
					$logo['img']['id'], 
					'full', 
					false, 
					['class'=>'h-16 w-auto inline-block'] 
				);
				$content .= '<h1 class="h2">' . __('Maintenance in progress','mklang') . '</h1>';
				$content .= '<p>' . __('The site is temporarily under maintenance. We will be back online shortly. We apologize for the inconvenience.','mklang') . '</p>';
				$content .= '</div>';
				$content .= '</div>';
			}
		}
		return $content;
	}

	/**
	 * Print credits and other data in the footer.
	 * This used only on maintenanace mode page footer.
	 * !!! This is actually used by Tools Booster on frontend style page, check and decide what to do with this function.
	 */
	public function print_footer_credits() : void {
		// Default value
		$items = [];
		// Get cookie page
		$cookie = get_field('cookie_policy_page','options');
		if( $cookie ) {
			$items['cookie'] = '<a href="' . get_the_permalink($cookie) . '">' . __('Cookie policy','mklang') . '</a>';
		}
		// Get privacy page
		$privacy = get_field('privacy_policy_page','options');
		if( $privacy ) {
			$items['privacy'] = '<a href="' . get_the_permalink($privacy) . '">' . __('Privacy policy','mklang') . '</a>';
		}
		// Cookie preferences
		if( mkt_plugin_active('iubenda') ) {
			$items['cookie-preferences'] = '<a href="#" class="iubenda-cs-preferences-link">' . __('Update cookie tracking preferences','mklang') . '</a>';
		}
		// Copyright
		$copyright_year = ( get_field('copyright_year','options') ) ? get_field('copyright_year','options') :  date( 'Y' );
		$items['copyright'] = '&copy; ' . $copyright_year . '/' . date( 'Y' ) . ', ' . get_bloginfo( 'name' );
		$items['copyright-statement'] = __('All rights reserved','mklang');
		// Credits
		if( !get_field('hide_credit','options') ) {
			$items['credits'] = 'Design &amp; code by <a target="_blank" rel="noopener noreferrer nofollow" title="Tenaglia Studio" href="https://micheletenaglia.com/">Tenaglia Studio</a>';
		}
		// Allow a filter
		$items = apply_filters('mkt_footer_credits_filter',$items);
		// Start HTML
		echo '<div class="footer-credits">';
		echo '<ul>';
		foreach( $items as $name => $value ) {
			echo '<li class="' . $name . '">' . $value . '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}

}

/**
 * Local option for pages. In case you need to hide the content of the page. This function hides the page content by replacing it with a default or custom message.
 */
function mkt_page_maintenance() : void {
	// Bail out early
	if( !is_page() ) {
		return;
	}
	// Get post
	global $post;
	// If page is in maintenance
	if( get_field('page_maintenance_mode_toggle',$post->ID) ) {
		// If a block template is set
		if( get_field('page_maintenance_mode_common_block', $post->ID) ) {
			// Get template
			mkt_get_content(get_field('page_maintenance_mode_common_block',$post->ID));
		}
		// Or display default template
		else {
			?>	
			<div class="default-404">
				<div>
					<h1 class="h2"><?php echo $post->post_title; ?></h1>
					<p><?php _e('This page is briefly unavailable.','mklang'); ?></p>
				</div>
			</div>
		<?php }
		// Get footer
		get_footer(); 
		// Exit
		exit; 
	}
}

/*---------------------------------------------------------------------------------------
 _  _    ___  _    ___  _    ___ _____ 
| || |  / _ \/ |  / / || |  / _ \___ / 
| || |_| | | | | / /| || |_| | | ||_ \ 
|__   _| |_| | |/ / |__   _| |_| |__) |
   |_|  \___/|_/_/     |_|  \___/____/ 

---------------------------------------------------------------------------------------*/
	
/**
 * Error pages.mktErrorPages
 * 
 */
class mktErrorPages{

	/**
	 * Actions and filters.
	 * 
	 */
	public function __construct() {
		
		// Custom template for 401 and 403 error pages
		add_action('wp',[$this,'custom_error_pages']);

	}

	/**
	 * Custom template for 401 and 403 error pages
	 * This function only works if you add these lines at the end of the .htaccess file in the root directory.
	 * - ErrorDocument 401 /index.php?status=401
	 * - ErrorDocument 403 /index.php?status=403
	 * 
	 * @link https://websistent.com/wordpress-custom-403-401-error-page/
	 */
	public function custom_error_pages() : void {
		// Get query
		global $wp_query;
		// 403
		if( isset($_REQUEST['status']) && $_REQUEST['status'] == 403 ) {
			// This a fix that does nothing for the purpose
			// of this function but prevents PHP errors in 
			// the debug.log file. The WP function get_body_class() 
			// expects a post object if $wp_query->is_page is true 
			// or $wp_query->is_singular is true.
			// Get random post
			$random_post = get_posts([
				'post_type'     =>  'page',
				'numberposts'   =>  1,
				'orderby'       =>  'rand',
			]);
			// Add random post object as queried object
			$wp_query->queried_object = $random_post[0];
			// And after do the real job
			$wp_query->is_404 = FALSE;
			$wp_query->is_page = TRUE;
			$wp_query->is_singular = TRUE;
			$wp_query->is_single = FALSE;
			$wp_query->is_home = FALSE;
			$wp_query->is_archive = FALSE;
			$wp_query->is_category = FALSE;
			add_filter('wp_title',[$this,'custom_error_title'],65000,2);
			add_filter('body_class',[$this,'custom_error_class']);
			status_header(403);
			get_template_part('core/templates/error-pages/error-page');
			exit;
		}
		// 401
		if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401) {
			// This a fix that does nothing for the purpose
			// of this function but prevents PHP errors in 
			// the debug.log file. The WP function get_body_class() 
			// expects a post object if $wp_query->is_page is true 
			// or $wp_query->is_singular is true.
			// Get random post
			$random_post = get_posts([
				'post_type'     =>  'page',
				'numberposts'   =>  1,
				'orderby'       =>  'rand',
			]);
			// Add random post object as queried object
			$wp_query->queried_object = $random_post[0];
			// And after do the real job
			$wp_query->is_404 = FALSE;
			$wp_query->is_page = TRUE;
			$wp_query->is_singular = TRUE;
			$wp_query->is_single = FALSE;
			$wp_query->is_home = FALSE;
			$wp_query->is_archive = FALSE;
			$wp_query->is_category = FALSE;
			add_filter('wp_title',[$this,'custom_error_title'],65000,2);
			add_filter('body_class',[$this,'custom_error_class']);
			status_header(401);
			get_template_part('core/templates/error-pages/error-page');
			exit;
		}
	}
	
	/**
	 * Custom title for 401 and 403 error pages.
	 * @param string $title
	 * @param string $sep
	 */
	public function custom_error_title( $title, $sep ) : string {
		// 403
		if( isset($_REQUEST['status']) && $_REQUEST['status'] == 403 ) {
			return __('Forbidden','mklang') . ' ' . $sep . ' ' . get_bloginfo('name');
		}
		// 401
		if( isset($_REQUEST['status']) && $_REQUEST['status'] == 401 ) {
			return __('Unauthorized','mklang') . ' ' . $sep . ' ' . get_bloginfo('name');
		}
	}

	/**
	 * Custom body class for 401 and 403 error pages.
	 * @param array $classes
	 */
	public function custom_error_class( $classes ) : array {
		// 403
		if(isset($_REQUEST['status']) && $_REQUEST['status'] == 403) {
			$classes = ['error403'];
			return $classes;
		}
		// 401
		if(isset($_REQUEST['status']) && $_REQUEST['status'] == 401) {
			$classes = ['error401'];
			return $classes;
		}
	}

}

/**
 * Add custom class to wrap class (#top).
 * Inspired by WP built-in function body_class().
 * @link https://developer.wordpress.org/reference/functions/body_class/
 *
 * @param array $classes
 */
function mkt_wrap_class( $classes = [] ) : void {
	// Allow a filter
	$classes = apply_filters('mkt_wrap_class_filter',$classes);
	// Separates class names with a single space, collates class names for body element.
	echo 'class="' . esc_attr(implode(' ',$classes)) . '"';
}