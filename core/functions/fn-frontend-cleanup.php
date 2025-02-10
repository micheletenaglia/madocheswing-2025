<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Remove useless and bloated stuff from frontend.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
   ____ _     _____    _    _   _ _   _ ____  
  / ___| |   | ____|  / \  | \ | | | | |  _ \ 
 | |   | |   |  _|   / _ \ |  \| | | | | |_) |
 | |___| |___| |___ / ___ \| |\  | |_| |  __/ 
  \____|_____|_____/_/   \_\_| \_|\___/|_|

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Filters the canonical URL if is paged.
add_filter( 'wpseo_canonical', 'hap_yoast_paged_filter_canonical' );

// Remove Yoast SEO Prev/Next URL from all pages
// add_filter( 'wpseo_next_rel_link', '__return_false' );
// add_filter( 'wpseo_prev_rel_link', '__return_false' );

/* Actions ----------------------------------------------------------------------------*/

// Cleanup stuff
add_action('after_setup_theme', 'hap_start_cleanup');

// Deregister unnecessary styles
add_action( 'wp_enqueue_scripts', 'hap_deregister_classic_theme_styles', 20 );

// Uncomment or copy and past into functions.php if you want to disable WP Rest Api
// add_action( 'after_setup_theme', 'hap_remove_json_api' );
// add_action( 'after_setup_theme', 'hap_disable_json_api' );

/* Functions --------------------------------------------------------------------------*/

/**
 * Series of actions and filters hooke after setup theme to clean up frontend head.
 *
 * @return void
 */
function hap_start_cleanup() {
	// Launching operation cleanup.
	add_action('init', 'hap_cleanup_head');
	// Remove WP version from RSS.
	add_filter('the_generator', 'hap_remove_rss_version');
	// Remove pesky injected css for recent comments widget.
	add_filter('wp_head', 'hap_remove_wp_widget_recent_comments_style', 1);
	// Clean up comment styles in the head.
	add_action('wp_head', 'hap_remove_recent_comments_style', 1);
	// Remove inline width attribute from figure tag
	add_filter('img_caption_shortcode', 'hap_remove_figure_inline_style', 10, 3);
	// Remove post-formats theme support
	remove_theme_support('post-formats');
}

//======================================================================
// Clean head
//======================================================================

/**
 * Create a clean wordpress head and remove unnecessary clutter.
 *
 * https://gist.github.com/Auke1810/f2a4cf04f2c07c74a393a4b442f22267
 * @return void
 */
function hap_cleanup_head() {
	// Edit URI link.
	remove_action('wp_head', 'rsd_link');
	// Category feed links.
	remove_action('wp_head', 'feed_links_extra', 3);
	// Post and comment feed links.
	remove_action('wp_head', 'feed_links', 2);
	// Windows Live Writer.
	remove_action('wp_head', 'wlwmanifest_link');
	// Index link.
	remove_action('wp_head', 'index_rel_link');
	// Previous link.
	remove_action('wp_head', 'parent_post_rel_link', 10);
	// Start link.
	remove_action('wp_head', 'start_post_rel_link', 10);
	// Canonical.
	remove_action('wp_head', 'rel_canonical', 10);
	// Shortlink.
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	// Links for adjacent posts.
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	// WP version.
	remove_action('wp_head', 'wp_generator');
	// Emoji detection script.
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	// Emoji styles.
	remove_action('wp_print_styles', 'print_emoji_styles');
}

/**
 * Remove WP version from RSS.
 *
 * @return boolean
 */
function hap_remove_rss_version() {
	return null;
}

/**
 * Remove injected CSS for recent comments widget.
 *
 * @return void
 */
function hap_remove_wp_widget_recent_comments_style() {
	if( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style');
	}
}

/**
 * Remove injected CSS from recent comments widget.
 *
 * @return void
 */
function hap_remove_recent_comments_style() {
    // Get global
	global $wp_widget_factory;
	if( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
		remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
	}
}

/**
 * Remove inline width attribute from figure tag causing images wider than 100% of its container.
 *
 * @param string $output
 * @param array $attr
 * @param object $content
 * @return void
 */
function hap_remove_figure_inline_style( $output, $attr, $content ) {
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
	if( current_theme_supports('html5', 'caption') ) {
		return '<figure ' . $atts['id'] . ' class="' . esc_attr($class) . '">'
			. do_shortcode($content) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
	}
}

/**
 * Remove classic-theme-styles CSS file.
 * This file appeared in WP 6.1 Version, it maybe a bug
 * and could be fixed in the future.
 * @return void
*/
function hap_deregister_classic_theme_styles() {
	wp_dequeue_style( 'classic-theme-styles' );
}

/**
 * Remove JSON API links in html head.
 *
 * @return void
*/
function hap_remove_json_api() {
	// Remove the REST API lines from the HTML Header
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
	// Remove the REST API endpoint.
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	// Turn off oEmbed auto discovery.
	add_filter( 'embed_oembed_discover', '__return_false' );
	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	// Remove all embeds rewrite rules.
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}

/**
 * Filters the canonical URL if is paged.
 *
 * @param string $canonical The current page's generated canonical URL
 * @return string The filtered canonical URL
 */
function hap_yoast_paged_filter_canonical( $canonical ) {
    // Bail out early
    if( !is_archive() ) {
        return $canonical;
    }
    // If this page 2, 3, etc. of an archive
    if( is_paged() ) {
        // Get object
        $object = get_queried_object();
        if( isset( $object->term_id ) ) {
            // If this is a term archive
            $canonical = get_term_link($object->term_id);
        }elseif( isset( $object->has_archive ) ) {
            // If this is a post type archive
            $canonical = get_post_type_archive_link( $object->name );
        }
    }
    return $canonical;
}