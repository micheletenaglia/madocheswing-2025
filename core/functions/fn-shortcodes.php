<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Register theme shortcodes.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

 /****************************************************************************************
  ____  _   _  ___  ____ _____ 
 / ___|| | | |/ _ \|  _ \_   _|
 \___ \| |_| | | | | |_) || |  
  ___) |  _  | |_| |  _ < | |  
 |____/|_|_|_|\___/|_|_\_\|_|  
  / ___/ _ \|  _ \| ____/ ___| 
 | |  | | | | | | |  _| \___ \ 
 | |__| |_| | |_| | |___ ___) |
  \____\___/|____/|_____|____/ 

****************************************************************************************/

add_shortcode('login_form', 'hap_wp_login_form_shortcode');
add_shortcode('home_url', 'hap_home_url');
add_shortcode('site_name', 'hap_site_name');
add_shortcode('post_url', 'hap_post_permalink');
add_shortcode('term_url', 'hap_term_permalink');
add_shortcode('company_name', 'hap_get_company_name');
add_shortcode('company_legal_representative', 'hap_get_company_legal_representative');
add_shortcode('company_address', 'hap_get_company_address');
add_shortcode('company_postcode', 'hap_get_company_postcode');
add_shortcode('company_city', 'hap_get_company_city');
add_shortcode('company_region', 'hap_get_company_region');
add_shortcode('company_country', 'hap_get_company_country');
add_shortcode('company_email', 'hap_get_company_email');
add_shortcode('company_pec_email', 'hap_get_company_pec_email');
add_shortcode('company_phone', 'hap_get_company_phone');
add_shortcode('company_mobile_phone', 'hap_get_company_mobile_phone');
add_shortcode('company_toll_free_phone', 'hap_get_company_toll_free_phone');
add_shortcode('company_vat_number', 'hap_get_company_vat');
add_shortcode('company_cf_number', 'hap_get_company_cf');
add_shortcode('company_share_capital', 'hap_get_company_share_capital');
add_shortcode('company_rea_number', 'hap_get_company_rea_number');
add_shortcode('get_logo', 'hap_logo_shortcode');
add_shortcode('get_social_link', 'hap_get_social_link');
add_shortcode('icon', 'hap_icon_shortcode');

/**
 * Login form shortcode.
 *
 * @return string
 */
function hap_wp_login_form_shortcode() {
	$args = [
		'echo'				=> true,
		'redirect'			=> get_the_permalink(get_the_ID()),
		'remember'			=> true,
		'value_remember'	=> true,
	];
	return wp_login_form( $args );
}

/**
 * Home url shortcode.
 *
 * @param array $atts
 * @return string
 */
function hap_home_url( $atts = '') {
	return home_url();
}

/**
 * Sitename shortcode.
 *
 * @return string.
 */
function hap_site_name() {
	return bloginfo('name');
}

/**
 * Post permalink shortcode.
 *
 * @param array $atts
 * @return string
 */
function hap_post_permalink( $atts ) {
	// Check if $id exists.
	$id = intval( $atts['id'] );
	if($id <= 0) {
		return;
	}
	// Check id $id has a URL.
	$post_url = get_the_permalink($id);
	if('' != $post_url) {
		return $post_url;
	}
}

/**
 * Term permalink shortcode.
 *
 * @param array $atts
 * @return string
 */
function hap_term_permalink( $atts ) {
	$term_url = null;
	extract(
		shortcode_atts(
			[
				'name'	=> '',
				'tax'	=> 'category',
			], 
		$atts
		)
	);
	$term = get_term_by( 'name', $name, $tax ); 
	if( $term ) {
		$term_url = get_term_link( $term->term_id );
	}
	return $term_url;
}

//======================================================================
// Custom options
//======================================================================

/**
 * Company name shortcode.
 *
 * @return string
 */
function hap_get_company_name() {
	return get_field('company_name', 'options');
}

/**
 * Legal representative shortcode.
 *
 * @return string
 */
function hap_get_company_legal_representative() {
	return get_field('legal_representative', 'options');
}

/**
 * Company address shortcode.
 *
 * @return string
 */
function hap_get_company_address() {
	return get_field('address', 'options');
}

/**
 * Company postcode shortcode.
 *
 * @return string
 */
function hap_get_company_postcode() {
	return get_field('postcode', 'options');
}

/**
 * Company address shortcode.
 *
 * @return string
 */
function hap_get_company_city() {
	return get_field('city', 'options');
}

/**
 * Company region shortcode.
 *
 * @return string
 */
function hap_get_company_region() {
	return get_field('region', 'options');
}

/**
 * Company country shortcode.
 *
 * @return string
 */
function hap_get_company_country() {
	return get_field('country', 'options');
}

/**
 * Company email shortcode.
 *
 * @return string
 */
function hap_get_company_email() {
	return get_field('email', 'options');
}

/**
 * Company PEC email shortcode.
 *
 * @return string
 */
function hap_get_company_pec_email() {
	return get_field('pec_email', 'options');
}

/**
 * Company phone shortcode.
 *
 * @return string
 */
function hap_get_company_phone() {
	return get_field('phone', 'options');
}

/**
 * Company mobile phone shortcode.
 *
 * @return string
 */
function hap_get_company_mobile_phone() {
	return get_field('mobile_phone', 'options');
}

/**
 * Company toll free phone shortcode.
 *
 * @return string
 */
function hap_get_company_toll_free_phone() {
	return get_field('toll_free_phone', 'options');
}

/**
 * Company VAT number shortcode.
 *
 * @return string
 */
function hap_get_company_vat() {
	return get_field('vat_number', 'options');
}

/**
 * Company fiscal code shortcode.
 *
 * @return string
 */
function hap_get_company_cf() {
	return get_field('cf_number', 'options');
}

/**
 * Company share capital shortcode.
 *
 * @return string
 */
function hap_get_company_share_capital() {
	return get_field('share_capital', 'options');
}

/**
 * Company REA number shortcode.
 *
 * @return string
 */
function hap_get_company_rea_number() {
	return get_field('rea_number', 'options');
}

//======================================================================
// Logo
//======================================================================

/**
 * Logo.
 *
 * @param array $atts
 * @return string $logo
 */
function hap_logo_shortcode( $atts = [] ) {
	// Extract vars
	extract(
		shortcode_atts(
			[
				'class'			=> 'h-8 w-auto',
				'version'		=> 'light',
			], 
		$atts
		)
	);
    // Get logo
    $logo = hap_get_logo($class,$version);
	return $logo;
}

//======================================================================
// Social
//======================================================================

/**
 * Social links from theme options.
 *
 * @param array $atts
 * @return string $html
 */
function hap_get_social_link( $atts = [] ) {
	// Extract vars
	extract(
		shortcode_atts(
			[
				'name'			=> 'facebook',
				'icon'			=> 'show',
				'icon_classes'	=> 'svg-icon fill-current h-4',
				'a_classes'		=> '',
				'path'			=> 'core'
			], 
		$atts
		)
	);
    // Deafult value
	$html = null;
    $get_icon = null;
    $label = null;
	// Get URL
	$url = get_field($name,'options');
	// If URL
	if( $url ) {
        // Handle icon
		if( $icon == 'show' || $icon == 'both' ) {
            // Add custom classes
			if( $icon_classes ) {
                // Get icon
				$get_icon = get_svg_icon( 
					str_replace( '_', '-', esc_attr($name) ), 
					esc_attr($icon_classes),
					esc_attr($path) 
				);
			}else{
                // Get icon with default classes
				$get_icon = get_svg_icon( 
					str_replace( '_', '-', esc_attr($name) ),
					'svg-icon fill-current h-4',
					esc_attr($path)
				);
			}
        }
        // Handle label
        if( $icon != 'show' || $icon == 'both' ) {
            $label = ucfirst( esc_attr($name) );
            if( $label == 'Mailchimp' ) {
                $label = 'Newsletter';
            }
        }
        // Handle URLs
        if( $name == 'whatsapp' ) {
            // Whatsapp
            $url = 'https://wa.me/' . str_replace('+','',$url);
        }elseif( $name == 'telegram' ) {
            // Telegram
            $url = 'https://t.me/' . $url;
        }if( $name == 'signal' ) {
            // Signal
            $url = 'https://signal.me/#p/' . $url;
        }
        // HTML code
        $html = '<a aria-label="' . ucfirst($name) . '" class="' . esc_attr('cta-social ' . esc_attr($name) . ' ' . esc_attr($a_classes)) . '" href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer nofollow">' . $get_icon . ' ' . $label . '</a>';
    }
    return $html;
}

/**
 * Get svg shortcode.
 *
 * @param array $atts
 * @return string
 */
function hap_icon_shortcode( $atts ) {
	extract(
		shortcode_atts(
			[
				'name'			=> '',
				'icon_classes'	=> 'svg-icon fill-current h-4',
				'path'			=> 'core',
			], 
			$atts
		) 
	);
	return get_svg_icon( $name, $icon_classes, $path );
}