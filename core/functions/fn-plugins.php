<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Specific functions for plugins.
 * Yoast SEO, Contact Form 7, Simple history, 
 * DK PDF and WPML
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0
 */

/********************************************************************************************
 __   _____    _    ____ _____   ____  _____ ___  
 \ \ / / _ \  / \  / ___|_   _| / ___|| ____/ _ \ 
  \ V / | | |/ _ \ \___ \ | |   \___ \|  _|| | | |
   | || |_| / ___ \ ___) || |    ___) | |__| |_| |
   |_| \___/_/   \_\____/ |_|   |____/|_____\___/ 

********************************************************************************************/

/**
 * Display Yoast SEO breadcrumbs.
 *
 * @return void
 */
function hap_breadcrumbs() {
	if( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
}

if( is_yoast_activated() ) {

	/**
	 * Yoast SEO override OG:Image Size.
	 *
	 * @return $sizes.
	 */
	function hap_yoast_override_images_size() {
		$sizes = [
			'social',
			'full-hd-thumb',
			'large'
		];
		return $sizes;
	}
	add_filter('wpseo_image_sizes', 'hap_yoast_override_images_size');
	
	/**
	 * Move Yoast postbox to bottom.
	 *
	 */
	function hap_yoast_to_bottom() {
		return 'low';
	}
	add_filter('wpseo_metabox_prio', 'hap_yoast_to_bottom');
	
	/**
	 * Exclude post types from XML sitemaps.
     * 
	 * https://developer.yoast.com/features/xml-sitemaps/api/#exclude-a-post-type
	 * https://wordpress.org/support/topic/exclude-multiple-post-types-from-sitemap/
	 *
	 * @param boolean $excluded  Whether the post type is excluded by default
	 * @param string  $post_type The post type to exclude
	 * @return bool Whether or not a given post type should be excluded
	 */
	/*function hap_exclude_sitemap_post_types( $excluded, $post_type ) {
		
		$excluded_post_types = array('example');

		if (in_array($post_type, $excluded_post_types) ) {
			 return true;
		}else{
			return false;
		}
			 
	}
	add_filter( 'wpseo_sitemap_exclude_post_type', 'hap_exclude_sitemap_post_types', 10, 2 );*/

}

/********************************************************************************************
   ____ _____ _____ 
  / ___|  ___|___  |
 | |   | |_     / / 
 | |___|  _|   / /  
  \____|_|    /_/   

********************************************************************************************/

if( is_cf7_activated() ) {
	// Remove autop from CF7 forms
	add_filter('wpcf7_autop_or_not','__return_false');
	// Optimize CF7 assets
	add_filter('wpcf7_load_js','__return_false');
	add_filter('wpcf7_load_css','__return_false');
	add_action('wp_enqueue_scripts','hap_cf7_optimization');
	// add_action('wp_print_scripts','hap_cf7_optimization'); !!! Verify this
	add_action('wp_enqueue_scripts','hap_cf7_recaptcha_no_refill', 15, 0);
	// Shortcodes
	add_filter('wpcf7_special_mail_tags','hap_cf7_email_signature', 10, 3);
	// Enable shortcodes inside CF7 forms
	add_filter('wpcf7_form_elements','do_shortcode' );
}

/**
 * Load CF7 assets only when needed.
 * 
 * @return void.
 */
function hap_cf7_optimization() {
    // Dequeue Google reCAPTCHA
    // Please note that this is necessary for best performance, 
    // although it is not recommended (see link)
    // https://contactform7.com/faq-about-recaptcha-v3/#stop-script-loading
    wp_dequeue_script('wpcf7-recaptcha');
    wp_dequeue_script('google-recaptcha');
	if( is_singular() ) {
		global $post;
		// Get optimization options (it is a grouped field)
		$cf7_optimization = get_field('optimization_contact_form_7','options');
		// Continue only if field has a value
		if( $cf7_optimization ) {
            // Get data
			$post_ids = [];
			$post_types = [];
			$post_templates = [];
            if( isset($cf7_optimization['optimization_contact_form_7_post_ids']) && !empty($cf7_optimization['optimization_contact_form_7_post_ids']) ) {
                $post_ids = $cf7_optimization['optimization_contact_form_7_post_ids'];
            }
            if( isset($cf7_optimization['optimization_contact_form_7_post_types']) && !empty($cf7_optimization['optimization_contact_form_7_post_types']) ) {
                $post_types = $cf7_optimization['optimization_contact_form_7_post_types'];
            }
            if( isset($cf7_optimization['optimization_contact_form_7_templates']) && !empty($cf7_optimization['optimization_contact_form_7_templates']) ) {
                $post_templates = $cf7_optimization['optimization_contact_form_7_templates'];   
            }
			// Include assets in selected posts 
			if( 
				in_array( $post->ID, $post_ids ) ||
				in_array( $post->post_type, $post_types ) ||
				is_page_template( $post_templates ) ||
				( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'contact-form-7') )
			) {
				wpcf7_enqueue_scripts();
                wp_enqueue_script( 'wpcf7-recaptcha' );
                wp_enqueue_script( 'google-recaptcha' );
				// Styles are included in frontend.css
				// wpcf7_enqueue_styles();
			}
		}else{
			// If the field is empty enqueue CF7 scipts on all singular templates
			wpcf7_enqueue_scripts();
		}
	}
}

/**
 * Shortcode to generate Contact Form 7 email signature html output.
 *
 * @param string $output
 * @param string $name
 * @param string $html
 * @return string $output
 */
function hap_cf7_email_signature( $output, $name, $html ) {
	if( 'signature' == $name ) {
		$output = hap_get_email_signature();
	}
	return $output;
}

/**
 * Disable refill function in WPCF7 if Recaptcha is in use.
 *
 * https://gist.github.com/sitoexpress/428d4edf96b301ce5afad0512ae1bdc5
 */
function hap_cf7_recaptcha_no_refill() {
	$service = WPCF7_RECAPTCHA::get_instance();
	if( !$service->is_active() ) {
		return;
	}
	wp_add_inline_script('contact-form-7', 'wpcf7.cached = 0;', 'before' );
}

/********************************************************************************************
  ____ ___ __  __ ____  _     _____    
 / ___|_ _|  \/  |  _ \| |   | ____|   
 \___ \| || |\/| | |_) | |   |  _|     
  ___) | || |  | |  __/| |___| |___    
 |____/___|_|__|_|_|__ |_____|_____| __
 | | | |_ _/ ___|_   _/ _ \|  _ \ \ / /
 | |_| || |\___ \ | || | | | |_) \ V / 
 |  _  || | ___) || || |_| |  _ < | |  
 |_| |_|___|____/ |_| \___/|_| \_\|_|  

********************************************************************************************/

/**
 * Change capability required to view main simple history page.
 * 
 */
function hap_simple_history_capability( $capability ) {
	$capability = 'manage_options';
	return $capability;
}
add_filter('simple_history/view_history_capability', 'hap_simple_history_capability');

/********************************************************************************************
  ____  _  __  ____  ____  _____ 
 |  _ \| |/ / |  _ \|  _ \|  ___|
 | | | | ' /  | |_) | | | | |_   
 | |_| | . \  |  __/| |_| |  _|  
 |____/|_|\_\ |_|   |____/|_|    

********************************************************************************************/

/**
 * Set custom options for DKPDF plugin.
 * 
 * @param string $font_dir
 * @return string $font_dir
 */
function hap_dkpdf_setup() {
	/*if( !function_exists('is_plugin_active') ) {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }	
	if( is_plugin_active( 'dk-pdf/dk-pdf.php' ) ) {*/
	if( is_dkpdf_activated() ) {
		add_filter('dkpdf_mpdf_font_dir', 'hap_dkpdf_custom_font_dir');
		add_filter('dkpdf_mpdf_font_data', 'hap_dkpdf_custom_font_data');
		add_filter('dkpdf_pdf_filename', 'hap_dkpdf_custom_filename');
	}
}
add_action('acf/init', 'hap_dkpdf_setup');

/**
 * Set custom PDF font.
 * 
 * @param string $font_dir
 * @return string $font_dir
 */
function hap_dkpdf_custom_font_dir( $font_dir ) {
	$wp_content_dir = trailingslashit( WP_CONTENT_DIR ) . 'uploads';
	// $fonts_path = HAP_CORE . 'assets/fonts';
	array_push( $font_dir, $wp_content_dir );
	return $font_dir;
}

/**
 * Set custom PDF font data.
 * 
 * @param array $font_data
 * @return array $font_data
 */
function hap_dkpdf_custom_font_data( $font_data ) {
	$dk_pdf = get_field( 'dk_pdf', 'options' );
	$font_data['hap-font'] = [
		'R'	=>	$dk_pdf['pdf_font_one']['filename'],
		'I'	=>	$dk_pdf['pdf_font_two']['filename'],
	];
	return $font_data;
};

/**
 * Set custom PDF filename.
 * 
 * @param string $filename
 * @return string $filename
 */
function hap_dkpdf_custom_filename( $filename ) {
	$dk_pdf = get_field( 'dk_pdf', 'options' );
	$filename = sanitize_title( $dk_pdf['pdf_filename'] . '-' . get_the_title() );
	return $filename;
}

/********************************************************************************************
 __        ______  __  __ _     
 \ \      / /  _ \|  \/  | |    
  \ \ /\ / /| |_) | |\/| | |    
   \ V  V / |  __/| |  | | |___ 
    \_/\_/  |_|   |_|  |_|_____|

********************************************************************************************/

//  Do not load WPML CSS on frontend.
add_action('wp_enqueue_scripts','wpml_optimization',PHP_INT_MAX);

/**
 * Do not load WPML CSS on frontend.
 * 
 */
function wpml_optimization() {
    if( is_wpml_activated() ) {
        wp_dequeue_style('wpml-blocks');
    }
}

/**
 * Do not load WPML CSS on frontend.
 * This is the official way but doesn't work.
 * https://wpml.org/forums/topic/dequeue-styles/
 */
/*
if( is_wpml_activated() ) {
    define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS',true);
}
*/

/**
 * Get the languages used on this website.
 * It would be better using the native WPML function
 * apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
 * but it doesn't always work when used in hooks.
 *
 * @return array $languages
 */
if( !function_exists( 'hap_get_languages' ) ) {
    function hap_get_languages( $output = 'full' ) {
        $languages = [
            'it'	=>	'Italiano',
            'en'	=>	'English',
            'de'	=>	'Deutsch',
            'fr'	=>	'Français',
        ];
        $languages = apply_filters( 'hap_get_languages', $languages );
        if( $output == 'keys' ) {
            $languages = array_keys( $languages );
        }
        return $languages;
    }
}

/**
 * WPML Custom language switcher
 *
 * @return void
 */
function hap_wpml_switcher() {
    // Bail out early
    if( !is_wpml_activated() ) {
        return;
    }
    // Default value of post ID
    $post_id = null;
    // If is singular
    if( is_singular() ) {
        global $post;
        $post_id = $post->ID;
    }
    // Get site URL
    $siteurl = get_option('siteurl');
    // Get home URL in current language
    $home_url = apply_filters( 'wpml_home_url', get_option( 'home' ) );
    // Get languages
    $languages = hap_get_languages();
    // Get current language
    $current_lang = apply_filters( 'wpml_current_language', null );
    // Get default language
    $default_lang = apply_filters('wpml_default_language', NULL );	
    ?>
    <div class="hap-wpml-switcher-wrap">
        <span class="js-wpml-switcher"><?php echo $current_lang; ?></span>
        <?php if( 
                apply_filters( 'wpml_is_translated_post_type', NULL, get_post_type($post_id) ) ||
                is_404() ||
                is_search()
            ) : ?>
            <div class="hap-wpml-switcher">
                <?php do_action('wpml_add_language_selector'); ?>
            </div>
        <?php else : ?>
            <div class="hap-wpml-switcher">
                <div class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-list-horizontal">
                    <ul>
                        <?php $index = 0; foreach( $languages as $code => $label ) : $index++; ?>
                            <?php $url = 
                                str_replace( 
                                    $home_url, 
                                    ($siteurl . '/' . esc_attr($code) . '/' ),
                                    get_current_url()
                                );
                                if( $code == $default_lang ) {
                                    $url = str_replace( 
                                        '/' . $code . '/',
                                        '/',
                                        $url
                                    );
                                }
                                $current = ( $code == $current_lang ) ? 'wpml-ls-current-language' : null;
                                $first = ( $index == 1 ) ? 'wpml-ls-first-item' : null;
                            ?>
                            <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-<?php echo esc_attr($code); ?> <?php echo esc_attr($current); ?> <?php echo esc_attr($first); ?> wpml-ls-item-legacy-list-horizontal">
                                <a href="<?php echo esc_url($url); ?>" class="wpml-ls-link">
                                    <span class="wpml-ls-native" lang="<?php echo esc_attr($code); ?>"><?php echo esc_html($label); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php
}