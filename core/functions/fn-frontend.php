<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Assets, customizations, optimizations and more for the frontend.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
  _____ ____   ___  _   _ _____ _____ _   _ ____  
 |  ___|  _ \ / _ \| \ | |_   _| ____| \ | |  _ \ 
 | |_  | |_) | | | |  \| | | | |  _| |  \| | | | |
 |  _| |  _ <| |_| | |\  | | | | |___| |\  | |_| |
 |_|   |_| \_\\___/|_| \_| |_| |_____|_| \_|____/  

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Custom login url and text in login page
add_filter('login_headerurl','hap_login_url');
add_filter('login_headertext','hap_login_url_text');

// Add onload to stylesheets
add_filter('style_loader_tag', 'hap_webfonts_attr_onload', 10, 4);

// Remove version in CSS and JS
add_filter('style_loader_src', 'hap_remove_css_js_wp_version', 10, 2);
add_filter('script_loader_src', 'hap_remove_css_js_wp_version', 10, 2);

// Add body class to handle menu position upon user field choice
add_filter('body_class', 'hap_desktop_nav_body_class');

// Add post category names to body class
add_filter('body_class', 'hap_add_post_category_names_to_body_class');

// Add page slug to body class
add_filter('body_class', 'hap_add_page_slug_to_body_class');

// Add user role to body class
add_filter('body_class', 'hap_add_user_role_to_body_class');

// Remove Jetpack styles
add_filter( 'jetpack_sharing_counts', '__return_false', 99 );
add_filter( 'jetpack_implode_frontend_css', '__return_false', 99 );

/* Actions ----------------------------------------------------------------------------*/

// Archives redirects
add_action('template_redirect','disable_date_archive');
add_action('template_redirect','disable_author_archive');
add_action('template_redirect','disable_category_archive');
add_action('template_redirect','disable_tag_archive');

// Custom template for 401 and 403 error pages
add_action('wp','hap_custom_error_pages');

// Set default cookie
add_action('init','hap_default_cookie');

// Enqueue login stylesheet
add_action('login_enqueue_scripts','hap_login_style');

// Custom CSS for login page
add_action('login_head', 'hap_custom_login');

// Enqueue styles
add_action('wp_enqueue_scripts', 'hap_register_styles');

// Enqueue scripts
add_action('wp_enqueue_scripts','hap_scripts');
add_action('wp_enqueue_scripts','hap_scripts_optimize',100);

// Add CSS font name reference for Woff files
add_action('wp_head', 'hap_font_face');

// Print favicons in header
add_action('wp_head','hap_favicons');

// Add preconnections
add_action('wp_head', 'hap_resource_hints', 2);

// Print JS vars in header
add_action('wp_head','hap_js_vars', PHP_INT_MAX);

// Print CSS urls in header
add_action('wp_head','hap_css_urls', PHP_INT_MAX);

// Print custom scripts in header
add_action('wp_head', 'hap_header_scripts', PHP_INT_MAX);

// Print custom inlines CSS in header
add_action('wp_head', 'hap_css_inline', PHP_INT_MAX);

// Add optional custom CSS in post and page header
add_action('wp_head','hap_post_custom_css_in_head', PHP_INT_MAX);

// Maintenance mode
// Set HTTP response to 503
add_filter( 'wp_headers', 'hap_maintenance_status', 1 );
// Set page-lp.php template to all pages when maintenance mode is activated
add_filter('template_include', 'hap_maintenance_page_template', 99);
// Set custom content
add_filter( 'the_content', 'hap_maintenance_page_content', 1 );
// Page maintenance mode
add_action('hap_container_start', 'hap_page_maintenance_mode', 99);

// Add Google Maps JSON style
add_action('wp_footer','hap_google_map_style');

/* Custom hooks -----------------------------------------------------------------------*/

// Body start
add_action('hap_body_start', 'hap_body_scripts', 10);
add_action('hap_body_start','hap_display_nav_menus', 11);

add_action('hap_footer', 'hap_footer_blocks');

// Body end
add_action('hap_footer_after', 'hap_footer_scripts', 10);

/* Functions --------------------------------------------------------------------------*/

/**
 * Set Hap default cookie.
 *
 * @return void
 */
function hap_default_cookie() {
    // Set default cookie
	if( !isset( $_COOKIE['haps'] ) ) {
        // One month
		hap_cookie( 'hap', 'ok', MONTH_IN_SECONDS );
	}
    // If maintenance is active
    if( is_maintenance_mode_activated() ) {
        // Get cookie
        $cookie = hap_get_cookie('hap_skip_token');
        // If no cookie
        if( !$cookie && isset($_GET['skip_token']) && !empty($_GET['skip_token']) ) {
            // Get token
            $token = sanitize_text_field($_GET['skip_token']);
            // Check token
            if( get_field('maintenance_mode','options')['token'] == $token ) {
                // Set cookie
                $nonce = wp_create_nonce('hap_skip_token');
                hap_cookie( 'hap_skip_token', $nonce, DAY_IN_SECONDS );
            }
        }
    }
}

/**
 * Custom url in login page.
 *
 * @return string $home_url
 */
function hap_login_url() {
	// Get home URL
	$home_url = get_home_url();
	return $home_url;
}

/**
 * Custom link text in login page.
 *
 * @return $site_name
 */
function hap_login_url_text() {
    // Get site name
    $site_name = get_option('blogname');
    return $site_name;
}

/**
 * Enqueue login stylesheet.
 *
 * @return void
 */
function hap_login_style() {
	// Register style
	wp_register_style(
		'hap-login', 
        HAP_PROJECT_CSS_URI . 'login.css'
	);
    // Enqueue style
	wp_enqueue_style(
		'hap-login'
	);
}

/**
 * Add custom CSS to login page.
 *
 * @return void
 */
function hap_custom_login() {
    // Default style value
    $style = '<style>';
    // $font_name = strtok( str_replace( 'https://fonts.googleapis.com/css2?family=', '', $font ), ':' );
    // 1. Embed fonts
    // If custom Google font
    if( isset( get_field('google_fonts', 'options')['url'] ) && !empty( get_field('google_fonts', 'options')['url'] ) ) {
        // Get font stylesheet
        $font = get_field('google_fonts', 'options')['url'];
        // Preconnect stylesheet host
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
        // Preconnect fonts host (crossorigin is needed for fonts)
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
        // Preload
        echo '<link rel="preload" crossorigin="anonymous" as="style" href="' . esc_url($font) . '">';
        // Embed stylesheet
        echo '<link rel="stylesheet" href="' . esc_url($font) . '" media="print" onload="this.media=\'all\'">';
    }elseif( isset( get_field('primary_font_woff', 'options')['url'] ) && !empty( get_field('primary_font_woff', 'options')['url'] ) ) {
        // Get font URL
        $font = get_field('primary_font_woff', 'options')['url'];
        // Woff font
        echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url($font) . '">';
        $style .= '@font-face{font-family:"Primary Font";src:url("' . esc_url($font) . ' format("woff");}';
    }elseif( isset( get_field('adobe_fonts', 'options')['url'] ) && !empty( get_field('adobe_fonts', 'options')['url'] ) ) {
        // Get font stylesheet
        $font = get_field('adobe_fonts', 'options')['url'];
        // Preconnect
        echo '<link rel="preconnect" href="https://use.typekit.net" crossorigin>';
        echo '<link rel="preconnect" href="https://p.typekit.net" crossorigin>';
        // Preload
        echo '<link rel="preload" as="style" href="' . esc_url($font) . '">';
        // Embed stylesheet
        echo '<link rel="stylesheet" href="' . esc_url($font) . '"  media="print" onload="this.media=\'all\'">';
    }else{
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
    // 2. Logo and custom style
	// Default logo values
    $logo_url = HAP_CORE_URI . 'assets/icons/hap.svg';
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
    echo $style;
}

/********************************************************************************************
	 _ ____  
	| / ___| 
  _ | \___ \ 
| |_| |___) |
 \___/|____/ 

********************************************************************************************/

/**
 * Enqueue scripts and stylesheets in frontend.
 *
 * @return void
 */
function hap_scripts() {
    
    //======================================================================
    // Register scripts
    //======================================================================

    // jQuery
    if( !function_exists('boost_frontend_scripts') ) {
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
    }
    // Deregister jQuery and jQuery Migrate
    wp_deregister_script('jquery-migrate');
    // wp_deregister_script('wp-embed');

	// Minified suffix
	$min = '.min';
	if( get_field('dev_mode','boost-options') ) {
		$min = null;
	}

	// Translation dependency
	$lang_deps = null;
	if( is_wpml_activated() ) {
		$lang_deps = 'wp-i18n';
	}
    
    // Register custom version of jQuery Migrate
    /*wp_register_script(
        'jquery-migrate', 
        'https://code.jquery.com/jquery-migrate-3.1.0.min.js', 
        [], 
        null, 
        true
    );*/

    // Register theme JS file
    // If the frontend.js file in project is not available
    // load core-frontend.js file from core.
    $theme_js_file = HAP_PROJECT_JS . 'frontend.js';
    // Check file
    if( file_exists( $theme_js_file  ) ) {
        // Regsiter script from project
        wp_register_script( 
            'hap', 
            HAP_PROJECT_JS_URI . 'frontend' . $min . '.js', 
            // ['jquery',$lang_deps], 
            ['jquery'], 
            null, 
            true
        );
        
    }else{
        // Regsiter script from core
        wp_register_script( 
            'hap', 
            HAP_CORE_JS_URI . 'core-frontend.js', 
            // ['jquery',$lang_deps], 
            ['jquery'], 
            null, 
            true
        );

    }
	
    //======================================================================
    // Block scripts
    // These scripts that can eventually be enqueued in functions.php
    //======================================================================

	// Photoswipe
    wp_register_script( 
        'photoswipe', 
        'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.3.8/umd/photoswipe.umd.min.js', 
        [], 
        null, 
        true
    );

	// Photoswipe Lightbox
    wp_register_script( 
        'photoswipe-lightbox', 
        'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.3.8/umd/photoswipe-lightbox.umd.min.js', 
        ['photoswipe'], 
        null, 
        false
    );
    
    //======================================================================
    // Plugin script 
    // These scripts that can eventually be enqueued in functions.php
    // !!! Lottie and Paroller (or similar) are missing
    //======================================================================

	// Vimeo
    wp_register_script( 
        'vimeo', 
        'https://player.vimeo.com/api/player.js', 
        array(), 
        null, 
        true
    );

    // Hammer - Swipe for mobile
    wp_register_script( 
        'hammer', 
        'https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js',
        [], 
        null, 
        true
    );

    // Hammer jQuery extension (jsdelivr)
    wp_register_script( 
        'hammer-jquery', 
        'https://cdn.jsdelivr.net/npm/jquery-hammerjs@2.0.0/jquery.hammer.min.js',
        ['jquery','hammer'], 
        null, 
        true
    );

    // Hammer touch emulator (jsdelivr)
    wp_register_script( 
        'hammer-jquery', 
        'https://cdn.jsdelivr.net/npm/hammer-touchemulator@0.0.2/touch-emulator.min.js',
        ['jquery','hammer','hammer-jquery'], 
        null, 
        true
    );
    
    // Swiper
    wp_register_script( 
        'swiper', 
        'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js',
		// 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js',
        [], 
        null, 
        true
    );

    // Masonry
    wp_register_script( 
        'salvattore', 
        'https://cdnjs.cloudflare.com/ajax/libs/salvattore/1.0.9/salvattore.min.js', 
        [], 
        null, 
        true
    );

    // Sal (jsdelivr)
    wp_register_script(
        'sal', 
        'https://cdn.jsdelivr.net/npm/sal@1.2.1/index.min.js',
        [], 
        null, 
        true
    );

    // Light Gallery - Image and video lightbox js
    wp_register_script(
        'light-gallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js',
        [],
        null,
        // filemtime(HAP_PROJECT_JS . 'light-gallery/lightgallery.min.js'),
        false
    );

    // Video Gallery - Light gallery video lightbox js
    wp_register_script(
        'video-gallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/video/lg-video.min.js',
        ['light-gallery'],
        null,
        // filemtime(HAP_PROJECT_JS . 'light-gallery/lg-video.min.js'),
        true
    );
    
    // Export CSV
    wp_register_script(
        'xlsx-core',
        'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.core.min.js',
        ['jquery'],
        null,
        // filemtime(HAP_PROJECT_JS . 'xlsx.core.min.js'),
        true
    );
    
    // Needed for xlsx-core
    wp_register_script(
        'file-saver',
        'https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js',
        ['jquery','xlsx-core'],
        null,
        // filemtime(HAP_PROJECT_JS . 'FileSaver.min.js'),
        true
    );
    
    // Needed for xlsx-core
    wp_register_script(
        'table-export',
        'https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js',
        ['jquery','xlsx-core','file-saver'],
        null,
        // filemtime(HAP_PROJECT_JS . 'tableexport.min.js'),
        true
    );
        
    //======================================================================
    // Enqueue scripts
    //======================================================================

	// Conditionally enqueue script only in development mode
	// It the script will be used in production they must be optimized
	// Other scripts must be enqueued before frontend.js
	if( get_field('dev_mode','boost-options') ) {
		
		// Sal JS
		if( get_field('sal_js','options') ) {
			wp_enqueue_script('sal'); 	
		}
	}
	
	// Theme JS file is the last to be enqueued
	wp_enqueue_script('hap');   
    
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
 * Print JS scripts in header.
 *
 * @return void
 */
function hap_header_scripts() {
    // If header scripts
    if( get_field('scripts_head', 'options') ) {
        // Minify scripts
        echo hap_minifier(get_field('scripts_head', 'options'));
    }
}

/**
 * Print JS scripts in body.
 *
 * @return void
 */
function hap_body_scripts() {
    // If body scripts
    if( get_field('scripts_body', 'options') ) {
        // Minify scripts
        echo hap_minifier(get_field('scripts_body', 'options'));
    }
}

/**
 * Print JS scripts in footer.
 *
 * @return void
 */
function hap_footer_scripts() {
    // If footer scripts
    if( get_field('scripts_footer', 'options') ) {
        // Minify scripts
        echo hap_minifier(get_field('scripts_footer', 'options'));
    }
	// If this is a post
	if( is_singular() ) {
		// Get post
		global $post;
		// Photoswipe
		if( has_block( 'acf/photoswipe-gallery', $post->ID ) ) { ?>
			<script type="text/javascript">
				var lightbox = new PhotoSwipeLightbox({
					gallery: '.hap-gallery',
					children: 'a',
					pswpModule: PhotoSwipe 
				});
				lightbox.init();
			</script>
		<?php }
	}
}

/**
 * Load JS variables to be used in other JS files.
 * !!! This should a unique JSON file.
 * - themeUrl
 * - siteUrl
 * - ajaxUrl
 * - months
 * - weekdays
 *
 * @return void
 */
function hap_js_vars() {
    // Weekdays
    $weekdays = array_values(hap_get_weekdays());
    // Months
    $months = array_values(hap_get_months());
    // Variables
    $vars = [
        'themeUrl'          =>  'var themeUrl = "' . get_template_directory_uri() . '/";',
        'siteUrl'           =>  'var siteUrl = "' . get_home_url() . '/";',
        'ajaxUrl'           =>  'var ajaxUrl = "' . get_admin_url() . 'admin-ajax.php";',
        'jsUrl'           	=>  'var jsUrl = "' . HAP_CORE_JS_URI . '";',
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
		if( file_exists( HAP_PROJECT_JS . 'map.js' ) ) {
			// Map JS       
			$vars['mapUrl'] = 'var mapUrl = "' . HAP_PROJECT_JS_URI . 'map.js";';
		}elseif( file_exists( HAP_CORE_JS . 'map.js' ) ) {
			// Map JS       
			$vars['mapUrl'] = 'var mapUrl = "' . HAP_CORE_JS_URI . 'map.js";';
		}
    }
    // !!! This colud also be a JSON object
    echo '<script>' . implode( ' ', $vars ) . '</script>' . PHP_EOL;
}

/**
 * Load JS variable used as map style.
 *
 * @param boolean $map_inclusion
 * @return void
 */
function hap_google_map_style( $map_inclusion ) { 
    // Default value
    $map_inclusion = true;
    // Filter for custom conditions
    $map_inclusion = apply_filters( 'hap_map_style_inclusion', $map_inclusion );
    // Check if post has block map
    if( is_singular() ) {
        // Get post
        global $post;
        // If has map block
        if( has_block( 'acf/map', $post->ID ) ) {
            $map_inclusion = true;
        }
    }
    // Bail out early
    if( !$map_inclusion ) {
        return;
    }
    // If custom style
    if( get_field( 'google_maps_style', 'options') ) : ?>
        <script>var mapStyle = <?php echo get_field( 'google_maps_style', 'options'); ?>;</script>
    <?php else :
        // Light color
        $color_light = '#ffffff';
        // Dark color
        $color_dark = '#999999';
        // If custom light color
        if( get_field( 'map_color_light', 'options') ) {
            $color_light = get_field( 'map_color_light', 'options');
        }
        // If custom dark color
        if( get_field( 'map_color_dark', 'options') ) {
            $color_dark = get_field( 'map_color_dark', 'options');
        }
		// If dev mode
        if( get_field('dev_mode','boost-options') ) : ?>
			<script>
				var mapStyle = [
					{
						"featureType": "administrative",
						"elementType": "geometry.stroke",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "<?php echo $color_dark; ?>"
							},
							{
								"weight": "0.30"
							},
						]
					},
					{
						"featureType": "administrative",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"color": "<?php echo $color_dark; ?>"
							},
						]
					},
					{
						"featureType": "administrative",
						"elementType": "labels.text.stroke",
						"stylers": [
							{
								"color": "<?php echo $color_light; ?>"
							},
							{
								"visibility": "on"
							},
							{
								"weight": "6"
							},
						]
					},
					{
						"featureType": "administrative",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "<?php echo $color_dark; ?>"
							},
							{
								"weight": "1"
							}
						]
					},
					{
						"featureType": "landscape",
						"elementType": "all",
						"stylers": [
							{
								"color": "<?php echo $color_light; ?>"
							},
						]
					},
					{
						"featureType": "poi",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "road",
						"elementType": "all",
						"stylers": [
							{
								"color": "<?php echo $color_dark; ?>"
							},
							{
								"visibility": "simplified"
							},
						]
					},
					{
						"featureType": "road",
						"elementType": "labels.text",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "<?php echo $color_light; ?>"
							},
							{
								"weight": 8
							},
						]
					},
					{
						"featureType": "road",
						"elementType": "labels.text.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "<?php echo $color_dark; ?>"
							},
							{
								"weight": 8
							},
						]
					},
					{
						"featureType": "road",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					},
					{
						"featureType": "transit",
						"elementType": "all",
						"stylers": [
							{
								"visibility": "simplified"
							},
							{
								"color": "<?php echo $color_dark; ?>"
							},
						]
					},
					{
						"featureType": "water",
						"elementType": "geometry.fill",
						"stylers": [
							{
								"visibility": "on"
							},
							{
								"color": "<?php echo $color_dark; ?>"
							},
						]
					},
					{
						"featureType": "water",
						"elementType": "labels.text",
						"stylers": [
							{
								"visibility": "simplified"
							},
							{
								"color": "<?php echo $color_light; ?>"
							},
						]
					},
					{
						"featureType": "water",
						"elementType": "labels.icon",
						"stylers": [
							{
								"visibility": "off"
							}
						]
					}
				];
			</script>
		<?php else : // Minificated version ?>
			<script>var mapStyle=[{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"<?php echo $color_dark; ?>"},{"weight":"0.30"},]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"<?php echo $color_dark; ?>"},]},{"featureType":"administrative","elementType": "labels.text.stroke","stylers":[{"color":"<?php echo $color_light; ?>"},{"visibility": "on"},{"weight": "6"},]},{"featureType":"administrative","elementType":"labels.icon","stylers":[{"visibility":"on"},{"color":"<?php echo $color_dark; ?>"},{"weight":"1"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"<?php echo $color_light; ?>"},]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"color":"<?php echo $color_dark; ?>"},{"visibility":"simplified"},]},{"featureType":"road","elementType":"labels.text","stylers":[{"visibility":"on"},{"color":"<?php echo $color_light; ?>"},{"weight":8},]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"<?php echo $color_dark; ?>"},{"weight":8},]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"<?php echo $color_dark; ?>"},]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"<?php echo $color_dark; ?>"},]},{"featureType":"water","elementType":"labels.text","stylers":[{"visibility":"simplified"},{"color":"<?php echo $color_light; ?>"},]},{"featureType":"water","elementType":"labels.icon","stylers":[{"visibility":"off"}]}];</script>
		<?php endif; 
    endif;    
}

/********************************************************************************************
   ____ ____ ____  
  / ___/ ___/ ___| 
 | |   \___ \___ \ 
 | |___ ___) |__) |
  \____|____/____/ 

********************************************************************************************/

/**
 * Register CSS stylesheets.
 * 
 * 
 */
function hap_register_styles() {
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
    // Register theme CSS file
    wp_register_style( 
        'hap', 
        HAP_PROJECT_CSS_URI . 'frontend.css',
        false,
        null,
        'all'
    );
    // Register custom CSS file for quick changes
    wp_register_style( 
        'hap-custom', 
        HAP_PROJECT_CSS_URI . 'custom.css',
        false,
        null,
        'all'
    );
	//======================================================================
    // Plugin CSS
    // Register script that can eventually be enqueued in functions.php
    // The best-practice is to import the css fiel directly into main stylesheet (see project/assets/scss/frontend.scss)
    //======================================================================
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
        HAP_CORE_JS_URI . 'libraries/sal/sal.css',
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
    //======================================================================
    // Enqueue styles
    //======================================================================
    wp_enqueue_style('hap');
    // Conditionally enqueue style
    if( get_field('custom_css','options') ) {
        wp_enqueue_style( 'hap-custom');
    }
}

/**
 * This function is loaded very late to avoid loading unwanted scripts and styles.
 *
 * @return void
 */
function hap_scripts_optimize() {
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
 * Register font face for custom static fonts loaded from Page Options.
 * Font Names are: Primary Font; Secondary Font; Extra Font
 *
 * @return void
 */
function hap_font_face() {
    // Check
	$check = 0;
	// Google fonts
	$google_fonts = get_field('google_fonts', 'options');
	// Woff fonts
	$primary_font_woff = get_field('primary_font_woff', 'options');
	$secondary_font_woff = get_field('secondary_font_woff', 'options');
	$extra_font_woff = get_field('extra_font_woff', 'options');
	$html = '<style>';
	if( isset($primary_font_woff['url']) && !empty($primary_font_woff['url']) ) {
        $check++;
		$url = $primary_font_woff['url'];
        $extension = get_file_extension( $url );
		$html .= '@font-face { font-family: "Primary Font"; src: url("' . esc_url($url) . '") format("' . $extension . '"); }';
	}
	if( isset($secondary_font_woff['url']) && !empty($secondary_font_woff['url']) ) {
		$check++;
		$url = $secondary_font_woff['url'];
        $extension = get_file_extension( $url );
		$html .= '@font-face { font-family: "Secondary Font"; src: url("' . esc_url($url) . '") format("' . $extension . '"); }';
	}
	if( isset($extra_font_woff['url']) && !empty($extra_font_woff['url']) ) {
		$check++;
		$url = $extra_font_woff['url'];
		$extension = 'woff';
        $extension = get_file_extension( $url );
		$html .= '@font-face { font-family: "Extra Font"; src: url("' . esc_url($url) . '") format("' . $extension . '"); }';	
	}
	$html .= '</style>';
	if( $check > 0 ) {
		echo $html;
	}
}

/**
 * Print inline CSS in header.
 *
 * @return void
 */
function hap_css_inline() {
    // If CSS inline
    if (get_field('css_inline', 'options')) {
        echo '<style>' . hap_minifier(get_field('css_inline', 'options')) . '</style>';
    }
}

/**
 * Change media attribute and add onload attribute.
 *
 * @inspired by https://matthewhorne.me/defer-async-wordpress-scripts/
 * @param string $tag
 * @param string $handle
 * @return string $tag
 */
function hap_webfonts_attr_onload( $tag, $handle, $href, $media ) {
	// If is not the backend
	if( !is_admin() ) {
		if( str_contains( $handle, 'font-google' ) ) {
            $tag = '<link rel="stylesheet" id="font-google-css" href="' . esc_url($href) . '" media="print"  onload="this.media=\'all\'" />';
        /* !!! This for some reasons it doesn't work
        }elseif( str_contains( $handle, 'font-adobe' ) ) {
            $tag = '<link rel="stylesheet" id="font-adobe-css" href="' . esc_url($href) . '" media="print" onload="this.media=\'all\'" />';
        */
        }
	}
    return $tag;
}

/**
 * Add favicon and configuration files in webiste head.
 *
 * @return void
 */
function hap_favicons() {
    // Get favicon field
	$favicons = get_field( 'favicons', 'options' );
	// Check that value is not null
    if( is_array( $favicons ) ) {
		// Get favicon code
		if( $favicons['favicon_code'] ) {
			echo $favicons['favicon_code'];
		}
	}
}

/**
 * Generate css variables for urls.
 * !!! Deprecated ???
 *
 * @return void
 */
function hap_css_urls() {
?>
<style>:root {--icon_close_url: url("<?php echo get_template_directory_uri(); ?>/core/icons/close.svg");}</style>
<?php 
}

/**
 * Remove version from JS scripts and CSS files.
 *
 * @param string $src
 * @return string $src
 */
function hap_remove_css_js_wp_version( $src ) {
    // Bail out early
	if( is_admin() ) {
		return $src;
	}
    // If versions
    if( strpos($src, 'ver=') ) {   
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

/**
 * Resource hints in head.
 *
 * @return void
 */
function hap_resource_hints() { 
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
 * Disable date archive.
 *
 * @return void
 */
function disable_date_archive() {
    // If disable archive is set
	if( get_field( 'disable_date_archive', 'options' ) ) {
        // Get global
        global $wp_query;
        // If this a date archive
        if($wp_query->is_date) {
            // Redirect to homepage
            wp_safe_redirect(get_bloginfo('url'),301);
            exit;
        }
    }
}

/**
 * Disable author archive.
 *
 * @return void
 */
function disable_author_archive() {
    // If disable author is set
	if( get_field( 'disable_author_archive', 'options' ) ) {
		// Get global
		global $wp_query;
        // If this an author archive
		if($wp_query->is_author) {
            // Redirect to homepage
			wp_safe_redirect(get_bloginfo('url'),301);
			exit;
		}
	}
}

/**
 * Disable category archive.
 *
 * @return void
 */
function disable_category_archive() {
	// If disable category is set
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
}

/**
 * Disable tag archive.
 *
 * @return void
 */
function disable_tag_archive() {
    // If disable category is set
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
 * Custom navigation position with CSS class in pages.
 *
 * @param array $classes
 * @return array $classes
 */
function hap_desktop_nav_body_class( $classes ) {
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
 *
 * @param array $classes
 * @return array $classes
 */
function hap_add_post_category_names_to_body_class( $classes ) {
    // Bail out early if this is not a post
    if( !is_singular('post') ) {
        return $classes;
    }
    // Get post    
    global $post;
    // Get categories
    $categories = get_the_category($post->ID);
    // Loop categories
    // !!! We can use list pluck here
    foreach( $categories as $category ) {
        $classes[] = 'cat-' . $category->slug;
    }
    return $classes;
}

/**
 * Add page slug to body class.
 *
 * @param array $classes
 * @return array $classes
 */
function hap_add_page_slug_to_body_class( $classes ) {
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
 *
 * @param array $classes
 * @return array $classes
 */
function hap_add_user_role_to_body_class( $classes ) {
	// Bail out early if user is not logged in
    if( !is_user_logged_in() ) {
        return $classes;
    }
    // Add user role as body class
    $user_role = get_user_role(get_current_user_id());
    $classes[] = 'role-' . $user_role;
    // Add hap-user as body class
    if( current_user_can('manage_hap_options') ) {
        $classes[] = 'hap-user';
    }
	return $classes;
}

/**
 * Add custom class to wrap class (<div id="top">).
 * Inspired by WP built in body_class()
 * https://developer.wordpress.org/reference/functions/body_class/
 *
 * @param array $classes
 * @return void
 */
function hap_wrap_class( $classes = [] ) {
    // Allow a filter
	$classes = apply_filters( 'hap_wrap_class_filter', $classes );
	// Separates class names with a single space, collates class names for body element.
	echo 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
}

/**
 * Display desktop and mobile navigation menus.
 *
 * @return void
 */
function hap_display_nav_menus() {
	// If this is a single
	if( is_singular() ) {
        // Get post
		global $post;
        // If navigation hidden options
		if( get_field('toggle_main_nav',$post) ) {
			// Add filter
			add_filter( 'hap_wrap_class_filter', function( $classes ) {
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
			hap_get_content( get_field('menu_block','options') );
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
 * Add optional custom CSS in post and page header.
 *
 * @return void
 */
function hap_post_custom_css_in_head() {
	// Bail out early
    if( !is_singular() ) {
        return;
    }
    // Get post
	global $post;
	// Bail out if no options
	if( !get_field( 'page_custom_css', $post->ID ) ) {
		return;
	}
	// HTML
	echo '<style>' . get_field( 'page_custom_css', $post->ID ) . '</style>';
}

/**
 * Render reusable blocks in footer.
 *
 * @return void
 */
function hap_footer_blocks() {
	// Get footer blocks
	$footer_blocks = get_field('footer_common_blocks','options');
	// If footer blocks
	if( $footer_blocks ) {
		// Loop blocks
		foreach( $footer_blocks as $footer_block ) {
			// Parse blocks
			hap_get_content( $footer_block );
		}
	}
}

/****************************************************************************************
  __  __ _   _ _____   __  __  ___  ____  _____ 
 |  \/  | \ | |_   _| |  \/  |/ _ \|  _ \| ____|
 | |\/| |  \| | | |   | |\/| | | | | | | |  _|  
 | |  | | |\  | | |_  | |  | | |_| | |_| | |___ 
 |_|  |_|_| \_| |_(_) |_|  |_|\___/|____/|_____|

 Other related actions in
 hap_default_cookie()
 is_maintenance_mode_activated()

****************************************************************************************/

/**
 * Maintenance mode
 * Set HTTP response to 503
 *
 * https://yoast.com/http-503-site-maintenance-seo/
 * https://yoast.com/http-503-site-maintenance-seo/
 * 
 * @param array $headers
 * @return array $headers
 */
function hap_maintenance_status( $headers ) {
    // Bail out early
    if( is_admin() ) {
        return $headers;
    }
    // If maintenance mode is active
    if( is_maintenance_mode_activated() ) {
        $headers[$_SERVER['SERVER_PROTOCOL']] = 503;
    }
    return $headers;
}

/**
 * Maintenance mode
 * Set page-lp.php template to all pages when maintenance mode is activated.
 *
 * @param string $template
 * @return string $template
 */
function hap_maintenance_page_template( $template ) {
    // Bail out early
    if( !is_maintenance_mode_activated() ) {
        return $template;
    }
    // Get landing page template
    $landing_page = locate_template(['page-lp.php']);
    // If template is found
    if( '' != $landing_page ) {
        return $landing_page;
    }
    return $template;
}

/**
 * Maintenance mode
 * Filter the content
 *
 * @param string $content
 * @return string $content
 */
function hap_maintenance_page_content( $content ) {
    // Bail out early
    if( !is_maintenance_mode_activated() ) {
        return $content;
    }
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
    $other_pages = get_field('maintenance_excluded_posts', 'options') ? get_field('maintenance_excluded_posts', 'options') : [];
    // Merge array
    $excluded_pages = array_merge( $excluded_pages, $other_pages );
    // If this not an excluded page
    if( !in_array( $post_id, $excluded_pages ) ) {
        // Get maintance fields
        $maintenance = get_field('maintenance_mode','options');
        // If custom content
        if( isset($maintenance['maintenance_custom_content']) && !empty($maintenance['maintenance_custom_content']) ) {
            // Parse blocks
            $content = hap_get_content($maintenance['maintenance_custom_content']);
        }else{
            // Default maintenance page content
            $logo = get_field('logo_light_mode','options');
            $content = '<div class="p-sm flex flex-col justify-center items-center min-h-screen">';
            $content .= '<div class="container-sm text-center">';
            $content .= wp_get_attachment_image( 
                $logo['img']['id'], 
                'full', 
                false, 
                ['class'=>'h-16 w-full'] 
            );
            $content .= '<h1 class="h2">' . __('Maintenance in progress','hap') . '</h1>';
            $content .= '<p>' . __('The site is temporarily under maintenance. We will be back online shortly. We apologize for the inconvenience.','hap') . '</p>';
            $content .= '</div>';
            $content .= '</div>';
        }
    }
    return $content;
}

/**
 * Local option for pages. In case you need to hide the content
 * of the page. This function hides the page content by replacing it
 * with a default or custom message.
 *
 * @return void
 */
function hap_page_maintenance_mode() {
	// Bail out early
	if( !is_page() ) {
		return;
	}
    // Get post
	global $post;
	?>
	<?php if( get_field('page_maintenance_mode_toggle', $post->ID) ) : ?>
		<?php if( get_field('page_maintenance_mode_common_block', $post->ID) ) : ?>
			<?php hap_get_content( get_field('page_maintenance_mode_common_block', $post->ID) ); ?>
		<?php else : ?>	
			<div class="default-404">
				<div>
					<h1 class="h2"><?php echo $post->post_title; ?></h1>
					<p><?php _e('This page is briefly unavailable.', 'hap'); ?></p>
				</div>
			</div>
		<?php endif; ?>
		<?php get_footer(); exit; ?>
	<?php endif;
}

/**
 * Icon link
 * A link with an icon
 *
 * @param array $link
 * @param string $class
 * @param string $icon
 * @return string $html
 */
function hap_icon_link( $link, $class = null, $icon = null ) {
	// Default value
	$html = null;
	// If link is set
	if( $link ) {
		// Default icon
		if( !$icon ) {
			$icon = get_svg_icon( 'icon-link', 'svg-icon fill-current h-4', 'core' );
		}
		// Start HTML
		$html = '<a href="' . $link['url'] . '" ';
		$html .= ( array_key_exists( 'target', $link ) ) ? 'target="' . $link['target'] . '" ' : null;
		$html .= ' class="icon-link ' . esc_attr($class) . '">';
		$html .= $icon;
		$html .= $link['title'];
		$html .= '</a>';
	}
	return $html;
}

/**
 * Custom template for 401 and 403 error pages
 * This function only works if you add these lines
 * at the end of the .htaccess file in the root directory.
 * 
 * ErrorDocument 401 /index.php?status=401
 * ErrorDocument 403 /index.php?status=403
 * 
 * https://websistent.com/wordpress-custom-403-401-error-page/
 *
 * @return void
 */
function hap_custom_error_pages() {
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
        add_filter('wp_title','hap_custom_error_title',65000,2);
        add_filter('body_class','hap_custom_error_class');
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
        add_filter('wp_title','hap_custom_error_title',65000,2);
        add_filter('body_class','hap_custom_error_class');
        status_header(401);
        get_template_part('core/templates/error-pages/error-page');
        exit;
    }
}
 
/**
 * Custom title for 401 and 403 error pages
 *
 * @param string $title
 * @param string $sep
 * @return void
 */
function hap_custom_error_title( $title, $sep ) {
    // 403
    if( isset($_REQUEST['status']) && $_REQUEST['status'] == 403 ) {
        return __('Forbidden','hap') . ' ' . $sep . ' ' . get_bloginfo('name');
    }
    // 401
    if( isset($_REQUEST['status']) && $_REQUEST['status'] == 401 ) {
        return __('Unauthorized','hap') . ' ' . $sep . ' ' . get_bloginfo('name');
    }
}

/**
 * Custom body class for 401 and 403 error pages
 *
 * @param array $classes
 * @return array $classes
 */
function hap_custom_error_class( $classes ) {
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

/**
 * Print credits and other data in the footer.
 * This used only on maintenanace mode page footer.
 *
 * @return void
 */
function hap_print_footer_credits() {
	// Default value
	$items = [];
	// Get cookie page
	$cookie = get_field('cookie_policy_page','options');
	if( $cookie ) {
		$items['cookie'] = '<a href="' . get_the_permalink($cookie) . '">' . __('Cookie policy','hap') . '</a>';
	}
	// Get privacy page
	$privacy = get_field('privacy_policy_page','options');
	if( $privacy ) {
		$items['privacy'] = '<a href="' . get_the_permalink($privacy) . '">' . __('Privacy policy','hap') . '</a>';
	}
	// Cookie preferences
	if( is_iubenda_activated() ) {
		$items['cookie-preferences'] = '<a href="#" class="iubenda-cs-preferences-link">' . __('Update cookie tracking preferences','hap') . '</a>';
	}
	// Copyright
	$copyright_year = ( get_field('copyright_year','options') ) ? get_field('copyright_year','options') :  date( 'Y' );
	$items['copyright'] = '&copy; ' . $copyright_year . '/' . date( 'Y' ) . ', ' . get_bloginfo( 'name' );
	$items['copyright-statement'] = __('All rights reserved','hap');
	// Credits
	if( !get_field('hide_credit','options') ) {
		$items['credits'] = 'Design &amp; code by <a target="_blank" rel="noopener noreferrer nofollow" title="Tenaglia Studio" href="https://micheletenaglia.com/">Tenaglia Studio</a>';
	}
	// Allow a filter
	$items = apply_filters( 'hap_footer_credits_filter', $items );
    // Start HTML
	echo '<div class="footer-credits">';
	echo '<ul>';
	foreach( $items as $name => $value ) {
		echo '<li class="' . $name . '">' . $value . '</li>';
	}
	echo '</ul>';
	echo '</div>';
}