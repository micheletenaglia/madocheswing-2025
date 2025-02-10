<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Setup and customization of WordPress backend.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
  ____    _    ____ _  _______ _   _ ____  
 | __ )  / \  / ___| |/ / ____| \ | |  _ \ 
 |  _ \ / _ \| |   | ' /|  _| |  \| | | | |
 | |_) / ___ \ |___| . \| |___| |\  | |_| |
 |____/_/   \_\____|_|\_\_____|_| \_|____/ 

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Autoupdate plugin
add_filter('auto_update_plugin', '__return_true');
add_filter('auto_plugin_update_send_email', '__return_false');

// Autoupdate theme
add_filter('auto_update_theme', '__return_true');
add_filter('auto_theme_update_send_email', '__return_false');

// WP Default sitemap
add_filter('wp_sitemaps_enabled', '__return_false');

// Custom footer admin
add_filter('admin_footer_text', 'hap_footer_admin');

// Google Maps Api key in backend
add_filter('acf/fields/google_map/api', 'hap_acf_google_map_api_backend');

// Notes column
add_filter('manage_page_posts_columns', 'hap_notes_field_backend_admin');

// Add featured thumbnail to admin post columns
if( function_exists('add_theme_support') ) {
	add_filter('manage_posts_columns', 'hap_add_thumbnail_columns');
	add_action('manage_posts_custom_column', 'hap_add_thumbnail_columns_data', 10, 2);
	add_filter('manage_pages_columns', 'hap_add_thumbnail_columns');
	add_action('manage_pages_custom_column', 'hap_add_thumbnail_columns_data', 10, 2);
}

// Print terms as css classes in Admin posts table
add_filter('post_class', 'hap_admin_posts_lists_print_terms_css_classes');

// Taxonomy columns
$manage_cpt_columns = 'manage_' . get_current_post_type() . '_posts_columns';
add_filter( $manage_cpt_columns, 'hap_taxonomy_columns', 10 );

$manage_cpt_sortable_columns = 'manage_edit-' . get_current_post_type() . '_sortable_columns';
add_filter( $manage_cpt_sortable_columns, 'hap_taxonomy_columns' );
add_filter( 'manage_edit-page_columns', 'hap_taxonomy_columns' );
// add_filter('manage_edit-page_sortable_columns', 'hap_taxonomy_columns');

// Add class to admin body
add_filter('admin_body_class', 'hap_admin_body_classes');

// Add custom post states
add_filter('display_post_states', 'hap_custom_post_states', 10, 2);

/* Actions ----------------------------------------------------------------------------*/

// Add custom pages in admin
add_action( 'admin_menu', 'hap_admin_menu_pages' );

// Switch theme
add_action('after_setup_theme','hap_add_theme_support');
add_action('after_setup_theme', 'hap_remove_theme_support', PHP_INT_MAX);

// Register menus
add_action('after_setup_theme','hap_menus');

// Load project fonts in admin (used in Gutenberg Blocks preview)
add_action('admin_enqueue_scripts','hap_admin_fonts');
add_action('admin_head','hap_admin_fonts_woff');

// Load custom CSS and JS in admin
add_action('admin_enqueue_scripts', 'hap_custom_admin_assets');

// Log user last login
add_action('wp_login', 'hap_user_last_login', 10, 2);

// Theme dashicon
add_action('admin_head', 'hap_dashicon');

// Notes column
add_action('manage_page_posts_custom_column', 'hap_notes_field_backend_admin_column', 10, 2);

// Deregister jQuery Migrate
add_action('wp_default_scripts', 'hap_deregister_jquery_migrate_backend');

// Order by menu_order in backend
add_action('pre_get_posts', 'hap_sort_pages_menu_order');

// Taxonomy filters in Admin
add_action('restrict_manage_posts', 'hap_add_taxonomy_filters');

// Taxonomy columns row
$manage_cpt_columns_row = 'manage_' . get_current_post_type() . '_posts_custom_column';
add_action( $manage_cpt_columns_row, 'hap_taxonomy_columns_row', 10, 2 );
add_action( 'manage_page_posts_custom_column', 'hap_taxonomy_columns_row', 10, 2);

// Modals UI
add_action('admin_footer', 'hap_admin_footer');

// Disable comments
if( get_option('disable_all_comments') ) {
	// Disable comments
	add_action( 'admin_init','hap_disable_comments' );
	// Close comments on the front-end
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);
	// Hide existing comments
	add_filter('comments_array', '__return_empty_array', 10, 2);
	// Remove comments page in menu
	add_action('admin_menu', 'hap_remove_comments_page');
	// Remove comments links from admin bar
	add_action('admin_menu', 'hap_remove_comments_link');
}

// Add custom admin color scheme.
add_action('admin_init', 'hap_admin_color_scheme');

/* Functions --------------------------------------------------------------------------*/

/**
 * Add theme support.
 *
 * @return void.
 */
function hap_add_theme_support() {
    // Add excerpts to cpt page
    add_post_type_support('page','excerpt');
    // Add menus support
    add_theme_support('menus');
    // Add post thumbnails support
    add_theme_support('post-thumbnails');
    // Add support for title tag
    add_theme_support('title-tag');
    // Add support for responsive embeds.
    add_theme_support('responsive-embeds');
    // Disable stuff
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('editor-font-sizes', []);
    add_theme_support('disable-custom-colors');
    add_theme_support('editor-color-palette', []);
    add_theme_support('disable-custom-gradients');
    add_theme_support('editor-gradient-presets', []);
    add_theme_support('custom-units', []);
    // Switch default core markup for search form, comment form, and comments to output valid HTML5
    add_theme_support(
		'html5', [
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'search-form',
			'style',
			'script',
			'navigation-widgets',
		]
	);
}

/**
 * Remove theme support.
 * !!! Non funziona
 * @return void.
 */
function hap_remove_theme_support() {
	remove_theme_support('post-formats',['post']);
}

/**
 * Custom footer admin.
 *
 * @return void.
 */
function hap_footer_admin() {
	
	$footer = '';
	$logo = get_field('logo_other_version','options');
	
	if( isset( $logo['img'] ) ) {
		$footer .= wp_get_attachment_image( $logo['img'],'medium');
	}
	$footer .= ' <span>';
	$footer .= wp_get_theme()->name;
	$footer .= ', ' . sprintf( __('a theme by <a href="%s" target="_blank" rel="noopener noreferrer nofollow">Tenaglia Studio</a>','hap'), 'https://micheletenaglia.com/' );
	$footer .= '</span>';
	
	echo $footer;
    
}

/**
 * Hap dashicon.
 * 
 * @return void
 */
function hap_dashicon() { ?>

	<style>
		.dashicons-hap {
			background-image: url("<?php echo HAP_CORE_URI; ?>assets/icons/hap-icon.svg");
			background-repeat: no-repeat;
			background-position: center;
			background-size: 16px 16px;
		}
		#wpadminbar .admin-bar-icon-hap {
			display: inline-block;
			width: 12px;
			height: 12px;
			background-image: url("<?php echo HAP_CORE_URI; ?>assets/icons/hap-icon.svg");
			background-repeat: no-repeat;
			background-position: center;
			background-size: 12px 12px;
		}
	</style>

<?php
}

/**
 * Load project fonts in admin.
 * This is used in Gutenberg Blocks preview.
 * This function is used for Google and Adobe fonts,
 * see hap_admin_fonts_woff for WOFF fonts.
 * The 2 functions use different hooks.
 *
 * @return void.
 */
function hap_admin_fonts( $hook_suffix ) {
	// Load font only if in edit post screen
	if( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
        // Get global
        global $post;
		// Load font s only if post type is not ACF (otherwise this will throw an error)
		if( 'acf-field-group' !== $post->post_type ) { 
			// Google fonts
			$google_fonts = get_field('google_fonts', 'options');
            // If Google fonts
			if( isset($google_fonts['url']) && !empty($google_fonts['url']) ) {
                // Register style
				wp_register_style(
					'font-google', 
					$google_fonts['url']
				);
                // Enqueue style
				wp_enqueue_style(
					'font-google'
				);
			}
			// Adobe fonts
			$adobe_fonts = get_field('adobe_fonts', 'options');
            // If Adobe font
			if( isset($adobe_fonts['url']) && !empty($adobe_fonts['url']) ) {
                // Register style
				wp_register_style(
					'font-adobe', 
					$adobe_fonts['url']
				);
                // Enqueue style
				wp_enqueue_style('font-adobe');
			}
		}
	}
}

/**
 * Load project fonts in admin.
 * This is used in Gutenberg Blocks preview.
 * This function is used for WOFF fonts,
 * see hap_admin_fonts for Google and Adobe fonts.
 * The 2 functions use different hooks.
 *
 * @return void
 */
function hap_admin_fonts_woff() {
    // Default value
    $style = null;
    // Woff fonts
    $primary_font_woff = get_field('primary_font_woff', 'options');
    $secondary_font_woff = get_field('secondary_font_woff', 'options');
    $extra_font_woff = get_field('extra_font_woff', 'options');
    // If primary font
    if( isset($primary_font_woff['url']) && !empty($primary_font_woff['url']) ) {
            // Add font to style var
        $style .= '@font-face{font-family:"Primary Font";src:url("' . esc_url($primary_font_woff['url']) . ' format("woff");}';
    }
    // If secondary font
    if( isset($secondary_font_woff['url']) && !empty($secondary_font_woff['url']) ) {
        // Add font to style var
        $style .= '@font-face{font-family:"Secondary Font";src:url("' . esc_url($secondary_font_woff['url']) . ' format("woff");}';
    }
    // If extra font
    if( isset($extra_font_woff['url']) && !empty($extra_font_woff['url']) ) {
        // Add font to style var
        $style .= '@font-face{font-family:"Extra Font";src:url("' . esc_url($extra_font_woff['url']) . ' format("woff");}';
    }
    // If any font
    if( $style ) {
        echo '<style>' . $style . '</style>';
    }
}

/**
 * Register menus.
 *
 * @return void.
 */
function hap_menus() {
	// menus
	register_nav_menus([
        'primary-menu'		=>	__('Primary Menu','hap'),
        'secondary-menu'	=>	__('Secondary Menu','hap'),
        'mobile-menu'		=>	__('Mobile Menu','hap'),
	]);
}

/**
 * Load Google Maps API Key in backend.
 * 
 * @param array $api
 * @return array $api
 */
function hap_acf_google_map_api_backend( $api ) {
	// If API key is set
	if( get_field( 'google_maps_api_key', 'options') ) {
		$api['key'] = get_field('google_maps_api_key','options');
		return $api;
	}
}

/**
 * Load custom CSS and JS in admin.
 * 
 * @return void.
 */
function hap_custom_admin_assets() {
	// Register styles and scripts
	// Register backend CSS file (all roles)
	wp_register_style( 
		'hap-admin', 
		HAP_PROJECT_URI . '/assets/css/backend-admin.css',
		false,
		null,
		'all'
	);
	// Register backend CSS file (editor and downwards)
	wp_register_style( 
		'hap-admin-editor', 
		HAP_PROJECT_URI . '/assets/admin/backend-admin-editor.css',
		false,
		null,
		'all'
	);
	// Register backend JS file
	wp_register_script(
		'hap-admin', 
		HAP_CORE_URI . '/assets/admin/backend-admin.js', 
		['jquery'], 
		'1.0.0',
		true
	);
	// Register Rainbow JS
	wp_register_script(
		'hap-rainbow', 
		HAP_CORE_URI . '/assets/admin/rainbow/rainbow-custom.min.js', 
		[], 
		null,
		true
	);
	// Enqueue styles and scripts
	wp_enqueue_style('hap-admin');
	wp_enqueue_script('hap-admin');
	wp_enqueue_script('hap-rainbow');
    // If current user is not an administrator
	if( !current_user_can( 'manage_options') ) {
		wp_enqueue_style('hap-admin-editor');
	}
}

/****************************************************************************************
  _   _ ____  _____ ____  
 | | | / ___|| ____|  _ \ 
 | | | \___ \|  _| | |_) |
 | |_| |___) | |___|  _ < 
  \___/|____/|_____|_| \_\
                                                         
****************************************************************************************/

/**
 * Update user meta when user login.
 * 
 * @param string $user_login
 * @param object $user
 * @return void
 */
function hap_user_last_login( $user_login, $user ) {
	// User last login
	update_user_meta( $user->ID, 'last_login', time() );
}

/**
 * A div to create modals.
 *
 * @return void
 */
function hap_admin_footer() {
    // HTML
	echo '<div class="dummy-layer"></div><div class="hap-modals"></div>';
}

/****************************************************************************************
  ____   ___  ____ _____   _____  _    ____  _     _____ 
 |  _ \ / _ \/ ___|_   _| |_   _|/ \  | __ )| |   | ____|
 | |_) | | | \___ \ | |     | | / _ \ |  _ \| |   |  _|  
 |  __/| |_| |___) || |     | |/ ___ \| |_) | |___| |___ 
 |_|    \___/|____/ |_|     |_/_/   \_\____/|_____|_____|
                                                         
****************************************************************************************/

/**
 * Order post table by menu order.
 *
 * @param object $query
 * @return object $query
 */
function hap_sort_pages_menu_order( $query ) {
	// Bail out early
	if( !is_admin() ) {
		return;
	}
    // Check query
	if( $query->is_main_query() && in_array( $query->query_vars['post_type'], ['page'] ) ) {
		$query->set('order', 'ASC');
		$query->set('orderby', 'menu_order');
	}
	return $query;
}

//======================================================================
// Featured image columns
//======================================================================

/**
 * Add featured thumbnail to admin post columns.
 *
 * @param array $columns
 * @return array $columns
 */
function hap_add_thumbnail_columns( $columns ) {
	// Default post type
	$post_type = null;
    // If URL parameter
	if( isset($_GET['post_type']) && !empty($_GET['post_type']) ) {
		$post_type = sanitize_text_field( $_GET['post_type'] );
	}
    // If post tyoe
	if( $post_type ) {
		// Add the image column only if the post type supports thumbnails
		if( post_type_supports( $post_type, 'thumbnail' ) ) {
			// Create a copy of $columns
			$temp_columns = $columns;
			// Get the first key value (the checkbox) in a variable
			$checkbox = $columns['cb'];
			// Unset the first key (the checkbox)
			unset( $temp_columns['cb'] );
			// Create a new array withe checkbox and a new key for the image
			$new_columns = [
				'cb'				=>	$checkbox,
				'featured_thumb'	=>	__('Image', 'hap'),
			];
			// Merge the new array with $columns
			$columns = array_merge( $new_columns, $columns );
		}
	}
	return $columns;
}

/**
 * The content of the preview image in backend post tables.
 * We are using a div with a background to allow the correct
 * visualization of SVG images.
 *
 * @param string $column
 * @param integer $post_id
 * @return void
 */
function hap_add_thumbnail_columns_data( $column, $post_id ) {
	// Swithc
	switch( $column ) {
		case 'featured_thumb':
			echo '<a href="' . get_edit_post_link() . '">';
			if( has_post_thumbnail() ) {
				echo '<div style="background-image: url(' . get_the_post_thumbnail_url( $post_id, 'admin-list-thumb' ) . ');"></div>';
			}
			echo '</a>';
			break;
	}
}

//======================================================================
// Get the current post type in Admin
//======================================================================

/**
 * Get the current post type in Admin.
 * 
 * https://gist.github.com/bradvin/1980309
 * https://gist.github.com/DomenicF/3ebcf7d53ce3182854716c4d8f1ab2e2
 */
function get_current_post_type() {
	// Get globals
	global $post, $typenow, $current_screen;
    // If post and post type are set
	if( $post && $post->post_type ) {
		// We have a post so we can just get the post type from that
		return $post->post_type;
	}elseif( $typenow) {
		// Check the global $typenow - set in admin.php
		return $typenow;
	}elseif ($current_screen && $current_screen->post_type) {
		// Check the global $current_screen object - set in sceen.php
		return $current_screen->post_type;
	}
	// We do not know the post type!
	return null;
}

//======================================================================
// Taxonomy columns
//======================================================================

/*
 * Taxonomy filters in Admin.
 * Print filters and columns of a list of custom post types in backend.
 *
 */
function hap_add_taxonomy_filters() {
	// Get current post type
	$post_type = get_current_post_type();
	// Get globals
	global $wp_query, $post, $typenow, $current_screen;
    // Get taxonomies
	$taxonomies = get_object_taxonomies($post_type, 'objects');
	//print_r($taxonomies);
    // Loop taxonomies
	foreach( $taxonomies as $taxonomy ) {
		// Vars
		$tax_name = $taxonomy->name;
		$tax_slug = $tax_name;
		$tax_label = $taxonomy->label;
		$terms = get_terms($tax_name);
		if( 
			'product_cat' != $tax_name && 
			'product_tag' != $tax_name && 
			'product_type' != $tax_name &&
			'category' != $tax_name 
			&& count($terms) > 0 
		) {
			echo "<select name='{$tax_name}' id='{$tax_name}' class='postform'>";
			echo "<option value=''>Mostra {$tax_label}</option>";
			// Loop terms
			foreach ($terms as $term) {
				$selected = null;
				if( isset( $_GET[$tax_slug] ) ) {
					if( $_GET[$tax_slug]  == $term->slug ) {
						$selected = 'selected="selected"';
					}
				}
				echo '<option value=' . $term->slug . ' ' . $selected . '>' . $term->name . '</option>';
			}
			echo '</select>';
		}
	}
}

/**
 * Taxonomy columns.
 * Register and create columns of a list of custom post types in backend.
 *
 * @param array $columns
 * @return array $columns
 */
function hap_taxonomy_columns($columns) {
	// Get post type
	$post_type = get_current_post_type();
	// Get globals
	global $post, $typenow, $current_screen;
    // Get taxonomies
	$taxonomies = get_object_taxonomies($post_type, 'objects');
    // If post type is not "product"
	if( 'product' != $post_type ) {
		// Loop taxonomies
		foreach ($taxonomies as $taxonomy) {
			$columns[$taxonomy->label] = $taxonomy->label;
			unset($columns['comments']);
		}
		return $columns;
	}
}

/*
 * Taxonomy columns row.
 * Populate rows  of columns of a list of custom post types in backend.
 *
 */
function hap_taxonomy_columns_row( $column_name, $post_ID ) {
	// Get globals
	global $post, $current_screen;
	// Get post type
	$post_type = get_current_post_type();
    // Get taxonomies
	$taxonomies = get_object_taxonomies($post_type, 'objects');
    // If post type is not "product" and "post"
	if( 'post' != $post_type && 'product' != $post_type ) {
        // Loop taxonomies
		foreach( $taxonomies as $taxonomy ) {
			if( $column_name == $taxonomy->label ) {
				$terms = wp_get_post_terms($post->ID, $taxonomy->name);
				$html = [];
                // Loop terms
				foreach ($terms as $term) {
					$html[] = $term->name; //do something here
				
				}
				echo implode(', ', $html);
			}
		}
	}
}

/**
 * Deregister jQuery Migrate in admin.
 *
 * @param object $scripts
 * @return void
 */
function hap_deregister_jquery_migrate_backend( $scripts ) {
	// If jQuery Migrate
    if( !empty($scripts->registered['jquery']) ) {
		// Deregister script
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
	}
}

/**
 * Add custom post states in page table.
 * Label for "Cookie Policy Page"
 * Label for "Terms &amp; Conditions Page"
 * Label for "Contacts Page"
 *
 * @param array $post_states
 * @param integer $post
 * @return array $post_states
 */
function hap_custom_post_states( $post_states, $post ) {
	// Index
	$pages = [
		__('Cookie Policy Page','hap')	=>	'',
		__('Contacts Page','hap')		=>	'',
	];
	// Get cookie policy page by template
	$cookie_policy = get_posts([
		'post_type'		=>	'page',
		'numberposts'	=>	1,
		'fields'		=>	'ids',
		'nopaging'		=>	true,
		'meta_key'		=>	'_wp_page_template',
		'meta_value'	=>	'page-templates/page-cookie-policy.php'
	]);
    // If cookie policy page
	if( $cookie_policy ) {
		if( $cookie_policy[0] === $post->ID ) {
			$post_states['cookie-policy-page'] = __('Cookie Policy Page','hap');
		}
	}
	// Get terms and conditions page by template
	$terms_conditions = get_posts([
		'post_type'		=>	'page',
		'numberposts'	=>	1,
		'fields'		=>	'ids',
		'nopaging'		=>	true,
		'meta_key'		=>	'_wp_page_template',
		'meta_value'	=>	'page-templates/page-terms-conditions.php'
	]);
    // If terms and condition page
	if( $terms_conditions ) {
		if( $terms_conditions[0] === $post->ID ) {
			$post_states['terms-conditions-page'] = __('Terms &amp; Conditions Page','hap');
		}
	}
	// Get contacts page by template
	$contacts = get_posts([
		'post_type'		=>	'page',
		'numberposts'	=>	1,
		'fields'		=>	'ids',
		'nopaging'		=>	true,
		'meta_key'		=>	'_wp_page_template',
		'meta_value'	=>	'page-templates/page-contacts.php'
	]);
    // If contacts page
	if( $contacts ) {
		if( $contacts[0] === $post->ID ) {	
			$post_states['contacts-page'] = __('Contacts Page','hap');
		}
	}
	return $post_states;
}
	
/**
 * Print terms as css classes in Admin posts table.
 *
 * @param array $classes
 * @return array $classes
 */
function hap_admin_posts_lists_print_terms_css_classes( $classes ) {
	// Get globals
	global $post, $typenow, $current_screen;
    // Get post type
	$post_type = get_current_post_type();
    // Get taxonomies
	$taxonomies = get_object_taxonomies($post_type, 'objects');
    // Loop taxonomies
	foreach ($taxonomies as $taxonomy) {
        // Get terms in taxonomy
		$terms = wp_get_post_terms($post->ID, $taxonomy->name);
        // Default value
		$html = [];
        // Loop terms
        if( $terms ) {
            foreach ($terms as $term) {
                $classes[] = $term->slug;
            }
        }
	}
	return $classes;
}

//======================================================================
// Notes columns
//======================================================================

/**
 * Add column for Notes.
 *
 * @param array $columns
 * @return array $columns
 */
function hap_notes_field_backend_admin( $columns ) {
	// Add notes column
	return array_merge( $columns, array(
		'backend_notes'    =>    __('Notes','hap'),
	));
}

/**
 * Populate column for Notes.
 *
 * @param string $column
 * @param integer $post_id
 * @return void
 */
function hap_notes_field_backend_admin_column( $column, $post_id ) {
	// Switch
	switch ($column) {
		case 'backend_notes':
			$notes = get_post_meta( $post_id, 'backend_notes', true );
			echo $notes;
			break;
	}
}

/**
 * Add custom pages in admin.
 * !!! This can be removed becuase now 
 * WP adds the link by default under 
 * the Appearance menu
 *
 * @return void
 */
function hap_admin_menu_pages() {
	// Patterns
	add_menu_page( 
		__('Patterns','hap'),
		__('Patterns','hap'), 
		'edit_pages', // Editor
		'edit.php?post_type=wp_block', 
		'', 
		'dashicons-block-default', 
		22 
	);
}

//======================================================================
// Disable all comments
// https://www.wpbeginner.com/wp-tutorials/how-to-completely-disable-comments-in-wordpress/
//======================================================================

/**
 * Redirect any user trying to access comments page.
 * Remove recent comments from dashboard.
 * Remove comment support for all post types.
 *
 * @return void.
 */
function hap_disable_comments() {
	// Redirect to homepage
	global $pagenow;
    // If this is comment age in admin
	if( $pagenow === 'edit-comments.php' ) {
        // Redirect to frontend
		wp_safe_redirect(home_url());
		exit;
	}
	// Remove comments metabox from dashboard
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	// Create an array to store all post type taht support comments
	// in case we need to restore comments
	$cpt_comments_backup = [];
	// Disable support for comments and trackbacks in all post types
	foreach( get_post_types() as $post_type ) {
		if( post_type_supports( $post_type, 'comments' ) ) {
			$cpt_comments_backup[] = $post_type; 
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
	// Create an option with a backup of post types taht support comments
	if( get_option('cpt_comments_backup') ) {
		update_option( 'cpt_comments_backup', $cpt_comments_backup );
	}else{
		add_option( 'cpt_comments_backup', $cpt_comments_backup );
	}
}

/**
 * Remove comments page in menu.
 *
 * @return void.
 */
function hap_remove_comments_page() {
    // Remove menu page
	remove_menu_page('edit-comments.php');
}

/**
 * Remove comments links from admin bar.
 *
 * @return void.
 */
function hap_remove_comments_link() {
    // Remove menu page
	remove_menu_page('edit-comments.php');

}

/**
 * Add class to admin body.
 * 
 * @param string $classes
 * @return string $classes
 */
function hap_admin_body_classes( $classes ) {
	// Get global
	global $pagenow;
    // Default value
	$page_param = null;
    // Get URL parameter
	if( isset($_GET['page']) && !empty($_GET['page']) ) {
        // New value
		$page_param = $_GET['page'];
	}
    // Custom pages
	$custom_acf_pages = [
		'options',
		'options-layout',
		'options-other',
	];
    // Add "hap-page-acf" as body class to custom pages
	if( ( $pagenow == 'admin.php' ) && ( in_array( $page_param, $custom_acf_pages ) ) ) {	
		$classes .= ' hap-page-acf';
	}
	// Add user role as body class
	$user_role = get_user_role(get_current_user_id());
	$classes .= ' role-' . $user_role;
	// Add hap-user as body class
	if( current_user_can('manage_hap_options') ) {
		$classes .= ' hap-user';
	}
	return $classes;
}

/**
 * Add custom admin color scheme.
 *
 * @return void
 */
function hap_admin_color_scheme() {
    // Add custom color scheme in backend
    wp_admin_css_color( 
        'hap', 
        'Hap',
        HAP_CORE_URI . 'assets/color-scheme/hap-color-scheme.css',
        ['#263238','#455a64','#b0bec5','#ff5722',]
    );
}  