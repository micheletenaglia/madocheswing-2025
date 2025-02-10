<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Remove useless and bloated stuff from backend.
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

// show_admin_bar( false );
add_filter('mce_buttons', 'hap_remove_tmce_buttons_line_1');
add_filter('mce_buttons_2', 'hap_remove_tmce_buttons_line_2');
add_filter('tiny_mce_before_init', 'hap_tinymce_cleanup');
add_filter('block_editor_settings_all', 'hap_block_editor_settings', 10, 2);
// More inside other functions

/* Actions ----------------------------------------------------------------------------*/

remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
add_action('admin_init', 'hap_remove_dashboard_meta');
add_action('admin_menu', 'hap_remove_menu_items', 99);
add_action('admin_menu', 'hap_remove_theme_customizer', 999);
add_action('admin_bar_menu', 'hap_remove_toolbar_nodes', 999);
add_action('init', 'hap_disable_emojis' );
add_action( 'admin_menu', 'hap_default_published_post' );
add_action( 'admin_menu', 'hap_default_published_custom_post_type' );
// Project logo in WP admin bar
// add_action('admin_head','hap_admin_logo');
// More inside other functions

/* Functions --------------------------------------------------------------------------*/

/**
 * Remove Admin Menu Link in theme customizer.
 *
 * @return void.
 */
function hap_remove_theme_customizer() {
	$customize_url_arr = array();
	$customize_url_arr[] = 'customize.php'; // 3.x
	$customize_url = esc_url(add_query_arg('return', urlencode(wp_unslash($_SERVER['REQUEST_URI'])), 'customize.php'));
	$customize_url_arr[] = $customize_url; // 4.0 & 4.1
	if( current_theme_supports('custom-header') && current_user_can('customize') ) {
		$customize_url_arr[] = esc_url(add_query_arg('autofocus[control]', 'header_image', $customize_url)); // 4.1
		$customize_url_arr[] = 'custom-header'; // 4.0
	}
	if( current_theme_supports('custom-background') && current_user_can('customize') ) {	
		$customize_url_arr[] = esc_url(add_query_arg('autofocus[control]', 'background_image', $customize_url)); // 4.1
		$customize_url_arr[] = 'custom-background'; // 4.0
	}
	foreach ($customize_url_arr as $customize_url) {
		remove_submenu_page('themes.php', $customize_url);
	}
}

/**
 * Remove options in tinymce line 1.
 *
 * @param array $buttons
 * @return array $buttons
 */
function hap_remove_tmce_buttons_line_1($buttons) {
	//Remove the format dropdown select and text color selector
	$remove = [
		// 'formatselect',
		//'bold',
		//'italic',
		//'bullist',
		//'numlist',
		//'blockquote',
		'alignleft',
		'aligncenter',
		'alignright',
		//'link',
		//'unlink',
		//'hr',
		//'charmap',
		'undo',
		'redo',
		'wp_more',
		// 'pastetext',
		// 'pasteword',
		'spellchecker',
		'dfw',
		'fullscreen',
		'wp_adv',
	];
	return array_diff( $buttons, $remove );
}

/**
 * Remove options in tinymce line 2.
 *
 * @param array $buttons
 * @return array $buttons
 */
function hap_remove_tmce_buttons_line_2($buttons) {
	//Remove the format dropdown select and text color selector
	$remove = [
		'strikethrough',
		//'hr',
		'forecolor',
		'pastetext',
		'removeformat',
		'charmap',
		'outdent',
		'indent',
		'undo',
		'redo',
		'wp_help',
	];
	return array_diff( $buttons, $remove );
}

/**
 * Tinymce cleanup.
 *
 * @param array $set
 * @return array $set
 */
function hap_tinymce_cleanup( $set ) {
	// $set['valid_elements'] = '*[id|class|style|href|target|rel|title|alt|src]';
	$set['valid_elements'] = '*[id|href|target|rel]';
	$set['invalid_styles'] = 'display position color font-family font-size text-align line-height top bottom left right margin margin-top margin-bottom margin-left margin-right border border-top border-bottom border-left border-right';
	return $set;
}

/**
 * Disable the emoji's.
 * 
 * @retrun void.
 */
function hap_disable_emojis() {
    // Remove actions
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	// Remove filters
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    // Add filters
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}else{
		return [];
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints
 * @param string $relation_type The relation type the URLs are printed for
 * @return array Difference betwen the two arrays
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}

/**
 * Remove toolbar items.
 * 
 * @return void.
 */
function hap_remove_toolbar_nodes($wp_admin_bar) {
	// Remove nodes
	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('comments');
	$wp_admin_bar->remove_node('customize');
	$wp_admin_bar->remove_node('customize-background');
	$wp_admin_bar->remove_node('customize-header');
	// $wp_admin_bar->remove_node('new-content');
	// $wp_admin_bar->remove_node('view'); 
}

/**
 * Remove menu items according to current user role.
 *
 * @return void.
 */
function hap_remove_menu_items() {
	// Get menu
	global $menu;
	// Define roles
	$roles = [
		'administrator',
		'shop_manager',
		'editor',
		// 'website_manager',
	];
	// Add filter to manipulate array
	$roles = apply_filters( 'hap_remove_menu_items', $roles );
    // If role is not included
	if( !in_array( get_user_role(), $roles ) ) {
		// remove_menu_page( 'posts' );
		// remove_menu_page( 'edit-comments.php' );
		remove_menu_page('wpcf7');
		remove_menu_page('jetpack');
		remove_submenu_page('jetpack', 'jetpack');
        // Restricted items
		$restricted = [
			__('Posts'),
			__('Media'),
			__('Links'),
			__('Pages'),
			__('Comments'),
			__('Appearance'),
			__('Plugins'),
			__('Users'),
			__('Tools'),
			__('Settings'),
			__('options'),
		];
        // Get last element in meni
		end($menu);
		// Loop
		while (prev($menu)) {
			$value = explode(' ', $menu[key($menu)][0]);
			if (in_array(null != $value[0] ? $value[0] : '', $restricted)) {
				unset($menu[key($menu)]);
			}
		} 
	}
}

/**
 * Remove some dashboard meta.
 *
 * @return void
 */
function hap_remove_dashboard_meta() {
    // If current user is an administrator
	if( current_user_can('manage_options') ) {
        // Remove meta boxes
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
		remove_meta_box('dashboard_primary', 'dashboard', 'normal');
		remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
		remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');	
	}
}

/**
 * Show published posts by default in admin.
 *
 * https://www.tutorialswebsite.com/how-to-display-only-published-posts-by-default-in-the-admin-area/
 * @return void
 */
function hap_default_published_post() {
	// Only for administrators
	if( !current_user_can('manage_options') ) {
		return;
	}
    // Get global
	global $submenu;
	// Posts
	foreach( $submenu['edit.php'] as $key => $value ) {
		if( in_array( 'edit.php', $value ) ) {
			$submenu['edit.php'][ $key ][2] = 'edit.php?post_status=publish&post_type=post';
		}
	}
}

/**
 * Show published posts for all custom post types and paged by default in admin.
 *
 * https://www.tutorialswebsite.com/how-to-display-only-published-posts-by-default-in-the-admin-area/
 * @return void
 */
function hap_default_published_custom_post_type() {
	// Only for administrators
	if( !current_user_can('manage_options') ) {
		return;
	}
    // Get global
	global $submenu;
	// Get all not bultin queryable post types
	$cpt = get_post_types([
		'_builtin'				=>	false,
		'publicly_queryable'	=>	true,
	]);
	// Add page post type to array
	$cpt['page'] = 'page';
	// Remove some post type
	$cpt_removed = [
		'acf-field-group',
		'acf-field',
		'wpcf7_contact_form',
		'flamingo_contact',
		'flamingo_inbound',
		'flamingo_outbound',
		'iubenda_form',
	];
	$cpt = array_diff( $cpt, $cpt_removed );
    // Loop
	foreach( $cpt as $pt ) {
		// Loop
        foreach( $submenu[ 'edit.php?post_type=' . $pt ] as $key => $value ) {
			if( in_array( 'edit.php?post_type=' . $pt, $value ) ) {
				$submenu[ 'edit.php?post_type='.$pt ][ $key ][2] = 'edit.php?post_status=publish&post_type=' . $pt;
			}
		}
	}
}

/**
 * Remove some options from core blocks.
 *
 * https://github.com/WordPress/gutenberg/issues/19796
 * @param array $editor_settings
 * @param mixed $editor_context
 * @return array $editor_settings
 */
function hap_block_editor_settings( $editor_settings, $editor_context ) {
	// Color
	$editor_settings['__experimentalFeatures']['color']['background'] = false;
	$editor_settings['__experimentalFeatures']['color']['customDuotone'] = false;
	$editor_settings['__experimentalFeatures']['color']['defaultGradients'] = false;
	$editor_settings['__experimentalFeatures']['color']['defaultPalette'] = false;
	$editor_settings['__experimentalFeatures']['color']['duotone'] = [];
	$editor_settings['__experimentalFeatures']['color']['gradients'] = [];
	$editor_settings['__experimentalFeatures']['color']['palette'] = [];
	$editor_settings['__experimentalFeatures']['color']['link'] = false;
	$editor_settings['__experimentalFeatures']['color']['text'] = false;
	// Colors
	$editor_settings['__experimentalFeatures']['colors'] = [];
	// Gradients
	$editor_settings['__experimentalFeatures']['gradients'] = [];
	// Font sizes
	$editor_settings['__experimentalFeatures']['fontSizes'] = [];
	// Spacing
	$editor_settings['__experimentalFeatures']['spacing'] = [];
	// Border
	$editor_settings['__experimentalFeatures']['border']['color'] = false;
	$editor_settings['__experimentalFeatures']['border']['radius'] = false;
	$editor_settings['__experimentalFeatures']['border']['style'] = false;
	$editor_settings['__experimentalFeatures']['border']['width'] = false;
	// Typography
	$editor_settings['__experimentalFeatures']['typography']['dropCap'] = false;
	$editor_settings['__experimentalFeatures']['typography']['fontSizes'] = [];
	$editor_settings['__experimentalFeatures']['typography']['fontStyle'] = false;
	$editor_settings['__experimentalFeatures']['typography']['fontWeight'] = false;
	$editor_settings['__experimentalFeatures']['typography']['letterSpacing'] = false;
	$editor_settings['__experimentalFeatures']['typography']['textDecoration'] = false;
	$editor_settings['__experimentalFeatures']['typography']['textTransform'] = false;
	$editor_settings['__experimentalFeatures']['typography']['fontFamilies'] = [];
	// Block / Button
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['border']['radius'] = false;
	// Block / Pullquote
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['color'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['radius'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['style'] = false;
	$editor_settings['__experimentalFeatures']['blocks']['core/pullquote']['border']['width'] = false;
	// Block / Image
	/**$editor_settings['defaultEditorStyles']['disableCustomColors'] = true;
	$editor_settings['defaultEditorStyles']['disableCustomFontSizes'] = true;
	$editor_settings['defaultEditorStyles']['disableCustomGradients'] = true;
	$editor_settings['defaultEditorStyles']['enableCustomLineHeight'] = true;
	$editor_settings['defaultEditorStyles']['enableCustomSpacing'] = false;
	$editor_settings['defaultEditorStyles']['enableCustomUnits'] = false;
	$editor_settings['defaultEditorStyles']['imageDefaultSize'] = 'full';
	$editor_settings['defaultEditorStyles']['disablePostFormats'] = true;
	$editor_settings['defaultEditorStyles']['autosaveInterval'] = 180;*/
	return $editor_settings;
}

/**
 * Project logo in WP admin bar.
 *
 * @return void
 */
function hap_admin_logo() {
    // Bail out early
    if( !get_field('favicons','options') ) {
        return;
    }
    // Get favicons
    $favicons = get_field('favicons','options');
    ?>
    <style>
        .wp-admin #wpadminbar #wp-admin-bar-site-name > .ab-item:before {
            content: '' !important;
            width: 20px;
            height: 20px;
            background-image: url(<?php echo wp_get_attachment_url($favicons['favicon_svg']); ?>) !important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 90% auto;
        }
    </style>
    <?php
}