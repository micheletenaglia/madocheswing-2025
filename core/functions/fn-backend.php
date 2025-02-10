<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Remove useless and bloated stuff from backend and also add customization to backend
new mktBackend();

/**
 * Setup and customization of WordPress backend.
 * Remove useless and bloated stuff from backend.
 *
 */
class mktBackend{

    /**
     * Actions and filters.
     * 
     */
    public function __construct() {

        /*----------------------------------------------------------------------------*/
        // Cleanup filters
        // show_admin_bar( false );
        add_filter('mce_buttons',[$this,'remove_tmce_buttons_line_1']);
        add_filter('mce_buttons_2',[$this,'remove_tmce_buttons_line_2']);
        add_filter('tiny_mce_before_init',[$this,'tinymce_cleanup']);
        add_filter('block_editor_settings_all',[$this,'block_editor_settings'],10,2);
        // More inside other functions

        /*----------------------------------------------------------------------------*/
        // Cleanup actions
        remove_action('admin_color_scheme_picker',[$this,'admin_color_scheme_picker']);
        add_action('admin_init',[$this,'remove_dashboard_meta']);
        add_action('admin_menu',[$this,'remove_menu_items'],99);
        add_action('admin_menu',[$this,'remove_theme_customizer'],999);
        add_action('admin_bar_menu',[$this,'remove_toolbar_nodes'],999);
        add_action('init',[$this,'disable_emojis']);
        add_action('admin_menu',[$this,'default_published_post']);
        add_action('admin_menu',[$this,'default_published_custom_post_type']);
        // Project logo in WP admin bar
        // add_action('admin_head',[$this,'admin_logo']);
        // More inside other functions

        /*----------------------------------------------------------------------------*/
        // Custom filters

        // Autoupdate plugin
        add_filter('auto_update_plugin','__return_true');
        add_filter('auto_plugin_update_send_email','__return_false');

        // Autoupdate theme
        add_filter('auto_update_theme','__return_true');
        add_filter('auto_theme_update_send_email','__return_false');

        // WP Default sitemap
        add_filter('wp_sitemaps_enabled','__return_false');

        // Custom footer admin
        add_filter('admin_footer_text',[$this,'admin_footer_text']);

        // Google Maps Api key in backend
        add_filter('acf/fields/google_map/api',[$this,'acf_google_map_api_backend']);

        // Notes column
        add_filter('manage_page_posts_columns',[$this,'notes_field_backend_admin']);

        // Add featured thumbnail to admin post columns
        if( function_exists('add_theme_support') ) {
            add_filter('manage_posts_columns',[$this,'add_thumbnail_columns']);
            add_action('manage_posts_custom_column',[$this,'add_thumbnail_columns_data'],10,2);
            add_filter('manage_pages_columns',[$this,'add_thumbnail_columns']);
            add_action('manage_pages_custom_column',[$this,'add_thumbnail_columns_data'],10,2);
        }

        // Print terms as css classes in Admin posts table
        add_filter('post_class',[$this,'admin_posts_lists_print_terms_css_classes']);

        // Taxonomy columns
        $manage_cpt_columns = 'manage_' . get_current_post_type() . '_posts_columns';
        add_filter($manage_cpt_columns,[$this,'taxonomy_columns'],10);

        $manage_cpt_sortable_columns = 'manage_edit-' . get_current_post_type() . '_sortable_columns';
        add_filter($manage_cpt_sortable_columns,[$this,'taxonomy_columns']);
        add_filter('manage_edit-page_columns',[$this,'taxonomy_columns']);
        // add_filter('manage_edit-page_sortable_columns',[$this,'taxonomy_columns']);

        // Add class to admin body
        add_filter('admin_body_class',[$this,'admin_body_classes']);

        // Add custom post states
        add_filter('display_post_states',[$this,'custom_post_states'],10,2);

        /*----------------------------------------------------------------------------*/
        // Custom actions

        // Add custom pages in admin
        add_action('admin_menu',[$this,'admin_menu_pages']);

        // After setup theme
        add_action('after_setup_theme',[$this,'add_theme_support']);
        add_action('after_setup_theme',[$this,'remove_theme_support'],PHP_INT_MAX);

        // Register menus
        add_action('after_setup_theme',[$this,'menus']);

        // Load project fonts in admin (used in Gutenberg Blocks preview)
        add_action('admin_enqueue_scripts',[$this,'admin_fonts']);
        add_action('admin_head',[$this,'admin_fonts_woff']);

        // Load custom CSS and JS in admin
        add_action('admin_enqueue_scripts',[$this,'custom_admin_assets']);

        // Log user last login
        add_action('wp_login',[$this,'user_last_login'],10,2);

        // Theme dashicon
        add_action('admin_head',[$this,'dashicon']);

        // Notes column
        add_action('manage_page_posts_custom_column',[$this,'notes_field_backend_admin_column'],10,2);

        // Deregister jQuery Migrate
        add_action('wp_default_scripts',[$this,'deregister_jquery_migrate_backend']);

        // Order by menu_order in backend
        add_action('pre_get_posts',[$this,'sort_pages_menu_order']);

        // Taxonomy filters in Admin
        add_action('restrict_manage_posts',[$this,'add_taxonomy_filters']);

        // Taxonomy columns row
        $manage_cpt_columns_row = 'manage_' . get_current_post_type() . '_posts_custom_column';
        add_action($manage_cpt_columns_row,[$this,'taxonomy_columns_row'],10,2);
        add_action('manage_page_posts_custom_column',[$this,'taxonomy_columns_row'],10,2);

        // Modals UI
        add_action('admin_footer',[$this,'admin_footer']);

        // Disable comments
        if( get_option('disable_all_comments') ) {
            // Disable comments
            add_action('admin_init',[$this,'disable_comments']);
            // Close comments on the front-end
            add_filter('comments_open','__return_false',20,2);
            add_filter('pings_open','__return_false', 20, 2);
            // Hide existing comments
            add_filter('comments_array','__return_empty_array',10,2);
            // Remove comments page in menu
            add_action('admin_menu',[$this,'remove_comments_page']);
            // Remove comments links from admin bar
            add_action('admin_menu',[$this,'remove_comments_link']);
        }

        // Add custom admin color scheme.
        add_action('admin_init',[$this,'admin_color_scheme']);

        // Register taxonomies.
        add_action('init',[$this,'register_taxonomies']);

        /*----------------------------------------------------------------------------*/
        // Media

        // Unset default "Organize my uploads into month- and year-based folders"
        add_filter('option_uploads_use_yearmonth_folders','__return_false',100);

        // Add mime types to media upload
        add_filter('upload_mimes',[$this,'upload_mimes']);

        // Set largest image threshold
        add_filter('big_image_size_threshold',[$this,'big_image_size_threshold'],10,4);

        // Set the maximum image size of the images uploaded in WP Media Library
        add_filter('wp_handle_upload_prefilter',[$this,'wp_handle_upload_prefilter']);

        // Set default values in media uploader
        add_action('after_setup_theme',[$this,'default_attachment_display_settings']);

        // Automatically set the image title, alt-text, caption and description upon upload
        add_action('add_attachment',[$this,'add_attachment']);

        // Add image sizes
        add_action('after_setup_theme',[$this,'add_image_sizes']);

        // Generate favicons
        add_action('acf/save_post',[$this,'generate_favicons'],20);

    }

    /**
     * Custom footer admin.
     */
    public function admin_footer_text() : void {
        // Default value
        $footer = '';
        // Get logo
        $logo = get_field('logo_other_version','options');
        // Start output
        if( isset($logo['img']) ) {
            $footer .= wp_get_attachment_image( $logo['img'],'medium');
        }
        $footer .= ' <span>';
        $footer .= wp_get_theme()->name;
        $footer .= ', ' . sprintf( __('a theme by <a href="%s" target="_blank" rel="noopener noreferrer nofollow">Tenaglia Studio</a>','mklang'), 'https://micheletenaglia.com/' );
        $footer .= '</span>';
        echo $footer;
    }

    /**
     * Load Google Maps API Key in backend.
     * @param array $api
     */
    public function acf_google_map_api_backend( $api ) : ?array {
        // If API key is set
        if( get_field('google_maps_api_key','options') ) {
            $api['key'] = get_field('google_maps_api_key','options');
        }
        return $api;
    }

    /**
     * Add column for Notes.
     * @param array $columns
     */
    public function notes_field_backend_admin( $columns ) : array {
        // Add notes column
        return array_merge( $columns, [
            'backend_notes' => __('Notes','mklang'),
        ]);
    }

    /**
     * Add featured thumbnail to admin post columns.
     * @param array $columns
     */
    public function add_thumbnail_columns( $columns ) : array {
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
                    'featured_thumb'	=>	__('Image', 'mklang'),
                ];
                // Merge the new array with $columns
                $columns = array_merge( $new_columns, $columns );
            }
        }
        return $columns;
    }

    /**
     * The content of the preview image in backend post tables.
     * We are using a div with a background to allow the correct visualization of SVG images.
     * @param string $column
     * @param integer $post_id
     */
    public function add_thumbnail_columns_data( $column, $post_id ) : void {
        // Switch
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

    /**
     * Print terms as css classes in Admin posts table.
     * @param array $classes
     */
    public function admin_posts_lists_print_terms_css_classes( $classes ) : array {
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

    /**
     * Taxonomy columns.
     * Register and create columns of a list of custom post types in backend.
     * @param array $columns
     */
    public function taxonomy_columns( $columns ) : array {
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

    /**
     * Add class to admin body.
     * @param string $classes
     */
    public function admin_body_classes( $classes ) : string {
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
        // Add "mkt-page-acf" as body class to custom pages
        if( $pagenow == 'admin.php' && in_array($page_param,$custom_acf_pages) ) {	
            $classes .= ' mkt-page-acf';
        }
        // Add user role as body class
        $user_role = get_user_role(get_current_user_id());
        $classes .= ' role-' . $user_role;
        // Add mkt-user as body class
        if( current_user_can('manage_mkt_options') ) {
            $classes .= ' mkt-user';
        }
        return $classes;
    }

    /**
     * Add custom post states in page table.
     * - Label for "Cookie Policy Page".
     * - Label for "Terms &amp; Conditions Page".
     * - Label for "Contacts Page".
     * @param array $post_states
     * @param object $post
     */
    public function custom_post_states( $post_states, $post ) : array {
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
                $post_states['cookie-policy-page'] = __('Cookie Policy Page','mklang');
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
                $post_states['terms-conditions-page'] = __('Terms &amp; Conditions Page','mklang');
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
                $post_states['contacts-page'] = __('Contacts Page','mklang');
            }
        }
        return $post_states;
    }
        
    /**
     * Add custom pages in admin.
     * !!! This can be removed becuase now, WP adds the link by default under the Appearance menu.
     */
    public function admin_menu_pages() : void {
        // Patterns
        add_menu_page( 
            __('Patterns','mklang'),
            __('Patterns','mklang'), 
            'edit_pages', // Editor
            'edit.php?post_type=wp_block', 
            '', 
            'dashicons-block-default', 
            22 
        );
    }

    /**
     * Add theme support.
     */
    public function add_theme_support() : void {
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
     * !!! Doesnot work.
     */
    public function remove_theme_support() : void {
        remove_theme_support('post-formats',['post']);
    }

    /**
     * Register menus.
     */
    public function menus() : void {
        // menus
        register_nav_menus([
            'primary-menu'		=>	__('Primary Menu','mklang'),
            'secondary-menu'	=>	__('Secondary Menu','mklang'),
            'mobile-menu'		=>	__('Mobile Menu','mklang'),
        ]);
    }

    /**
     * Load project fonts in admin.
     * This is used in Gutenberg Blocks preview.
     * This function is used for Google and Adobe fonts, see admin_fonts_woff for WOFF fonts.
     * The 2 functions use different hooks.
     */
    public function admin_fonts( $hook_suffix ) : void {
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
     * This function is used for WOFF fonts, see admin_fonts for Google and Adobe fonts.
     * The 2 functions use different hooks.
     */
    public function admin_fonts_woff() : void {
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
     * Load custom CSS and JS in admin.
     */
    public function custom_admin_assets() : void {
        // Register styles and scripts
        // Register backend CSS file (all roles)
        wp_register_style( 
            'mkt-admin', 
            get_template_directory_uri() . '/project/assets/css/backend-admin.css',
            false,
            null,
            'all'
        );
        // Register backend CSS file (editor and downwards)
        wp_register_style( 
            'mkt-admin-editor', 
            get_template_directory_uri() . '/project//assets/admin/backend-admin-editor.css',
            false,
            null,
            'all'
        );
        // Register backend JS file
        wp_register_script(
            'mkt-admin', 
            get_template_directory_uri() . '/core/assets/admin/backend-admin.js', 
            ['jquery'], 
            '1.0.0',
            true
        );
        // Register Rainbow JS
        wp_register_script(
            'rainbow', 
            get_template_directory_uri() . '/core/assets/admin/rainbow/rainbow-custom.min.js', 
            [], 
            null,
            true
        );
        // Enqueue styles and scripts
        wp_enqueue_style('mkt-admin');
        wp_enqueue_script('mkt-admin');
        wp_enqueue_script('rainbow');
        // If current user is not an administrator
        if( !current_user_can( 'manage_options') ) {
            wp_enqueue_style('mkt-admin-editor');
        }
    }

    /**
     * Update user meta when user login.
     * @param string $user_login
     * @param object $user
     */
    public function user_last_login( $user_login, $user ) : void {
        // User last login
        update_user_meta( 
            $user->ID, 
            'last_login', 
            time() 
        );
    }

    /**
     * Dashicon.
     */
    public function dashicon() : void { 
        ?>
        <style>
            .dashicons-mkt {
                background-image: url("<?php echo get_template_directory_uri(); ?>/core/assets/icons/mkt-icon.svg");
                background-repeat: no-repeat;
                background-position: center;
                background-size: 16px 16px;
            }
            #wpadminbar .admin-bar-icon-mkt {
                display: inline-block;
                width: 12px;
                height: 12px;
                background-image: url("<?php echo get_template_directory_uri(); ?>/core/assets/icons/mkt-icon.svg");
                background-repeat: no-repeat;
                background-position: center;
                background-size: 12px 12px;
            }
        </style>
        <?php
    }

    /**
     * Populate column for Notes.
     * @param string $column
     * @param integer $post_id
     */
    public function notes_field_backend_admin_column( $column, $post_id ) : void {
        // Switch
        switch ($column) {
            case 'backend_notes':
                $notes = get_post_meta( $post_id, 'backend_notes', true );
                echo $notes;
                break;
        }
    }

    /**
     * Deregister jQuery Migrate in admin.
     * @param object $scripts
     */
    public function deregister_jquery_migrate_backend( $scripts ) : void {
        // If jQuery Migrate
        if( !empty($scripts->registered['jquery']) ) {
            // Deregister script
            $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
        }
    }

    /**
     * Order post table by menu order.
     * @param object $query
     */
    public function sort_pages_menu_order( $query ) : ?object {
        // Bail out early
        if( !is_admin() ) {
            return null;
        }
        // Check query
        if( $query->is_main_query() && in_array( $query->query_vars['post_type'], ['page'] ) ) {
            $query->set('order','ASC');
            $query->set('orderby','menu_order');
        }
        return $query;
    }

    /*
    * Taxonomy filters in Admin.
    * Print filters and columns of a list of custom post types in backend.
    */
    public function add_taxonomy_filters() : void {
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
                ?>
                <select name="<?php echo esc_attr($tax_name); ?>" id="<?php echo esc_attr($tax_name); ?>" class="postform">
                    <option value=""><?php echo __('Show','mklang') . ' ' . esc_html($tax_label); ?></option>
                    <?php foreach( $terms as $term ) : 
                        $selected = null;
                        if( isset($_GET[$tax_slug]) ) {
                            if( $_GET[$tax_slug] == $term->slug ) {
                                $selected = 'selected';
                            }
                        }
                        ?>
                        <option <?php echo esc_attr($selected); ?>value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php
            }
        }
    }

    /*
    * Taxonomy columns row.
    * Populate rows  of columns of a list of custom post types in backend.
    */
    public function taxonomy_columns_row( $column_name, $post_ID ) : void {
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
     * A div to create modals.
     */
    public function admin_footer() : void {
        // HTML
        echo '<div class="dummy-layer"></div><div class="mkcb-modals"></div>';
    }

    /**
     * Redirect any user trying to access comments page.
     * Remove recent comments from dashboard.
     * Remove comment support for all post types.
     * @link https://www.wpbeginner.com/wp-tutorials/how-to-completely-disable-comments-in-wordpress/
     */
    public function disable_comments() : void {
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
     */
    public function remove_comments_page() : void {
        // Remove menu page
        remove_menu_page('edit-comments.php');
    }

    /**
     * Remove comments links from admin bar.
     */
    public function remove_comments_link() : void {
        // Remove menu page
        remove_menu_page('edit-comments.php');

    }

    /**
     * Add custom admin color scheme.
     */
    public function admin_color_scheme() : void {
        // Add custom color scheme in backend
        wp_admin_css_color( 
            'mkcb', 
            'Mkt',
            get_template_directory_uri() . '/core/assets/color-scheme/mkcb-color-scheme.css',
            ['#263238','#455a64','#b0bec5','#ff5722',]
        );
    }  

    /**
     * Register taxonomies.
     * - Progress status
     * - Page categories
     */
    public function register_taxonomies() : void {
        // Default args
        // Args
        $args = [
            'public'						=> false,
            'publicly_queryable'			=> false,
            'hierarchical'					=> true,
            'show_ui'						=> true,
            'show_in_menu'					=> true,
            'show_in_nav_menus'				=> false,
            'query_var' 					=> true,
            'rewrite' 						=> [
                'with_front'	=> true,
            ],
            'show_admin_column'				=> true,
            'show_in_rest'					=> false,
            'show_tagcloud'					=> false,
            'rest_controller_class'			=> 'WP_REST_Terms_Controller',
            'rest_namespace'				=> 'wp/v2',
            'show_in_quick_edit'			=> true,
            'sort'							=> false,
            'show_in_graphql'				=> false,
        ];
        /*----------------------------------------------------------------------------*/
        // Progress status
        // Labels
        $labels = [
            'name'							=> esc_html__('Progress','mklang'),
            'singular_name'					=> esc_html__('Progress','mklang'),
            'menu_name'						=> esc_html__('Progress','mklang'),
        ];
        // Update args
        $args['label'] = esc_html__('Progress','mklang');
        $args['labels'] = $labels;
        $args['rewrite']['slug'] = 'progress_status';
        $args['rest_base'] = 'progress_status';
        $args['capabilities'] = [
            'manage_terms'	=>	'manage_options',
            'edit_terms'	=>	'manage_options',
            'delete_terms'	=>	'manage_options',
            'assign_terms'	=>	'manage_options',
        ];
        // Register only for custom post types, pages and posts
        $post_types = get_post_types(['_builtin' => false]);
        // Delete element by value
        if( ($key = array_search('acf-field-group',$post_types)) !== false ) {
            unset($post_types[$key]);
        }
        // Register taxonomy
        register_taxonomy('progress_status',array_merge(['page','post'],$post_types),$args);
        /*----------------------------------------------------------------------------*/
        // Page categories
        // Labels
        $labels = [
            'name'							=> esc_html__('Page categories','mklang'),
            'singular_name'					=> esc_html__('Page category','mklang'),
            'menu_name'						=> esc_html__('Page categories','mklang'),
        ];
        // Args
        $args['label'] = esc_html__('Page categories','mklang');
        $args['labels'] = $labels;
        $args['rewrite']['slug'] = 'page_category';
        $args['rest_base'] = 'page_category';
        // Register taxonomy
        register_taxonomy('page_category',['page'],$args);
    }

    /*---------------------------------------------------------------------------------------
     __  __ _____ ____ ___    _   
    |  \/  | ____|  _ \_ _|  / \   
    | |\/| |  _| | | | | |  / _ \  
    | |  | | |___| |_| | | / ___ \ 
    |_|  |_|_____|____/___/_/   \_\
    
    Media
    ---------------------------------------------------------------------------------------*/

    /**
     * Add MIME types.
     * Add the following line in wp-config.php to allow SVG uploads: define('ALLOW_UNFILTERED_UPLOADS', true);
     * @param array $mimes
     */
    public function upload_mimes( $mimes ) : array {
        // Allow SVG file upload
        $mimes['jpg']	= 'image/jpeg';
        $mimes['png']	= 'image/png';
        $mimes['gif']	= 'image/gif';
        $mimes['svg']	= 'image/svg';
        $mimes['svg']   = 'image/svg+xml';
        $mimes['svgz']	= 'image/svg';
        $mimes['webp']	= 'image/webp';
        $mimes['wav']	= 'audio/wav, audio/x-wav';
        $mimes['ogg']	= 'audio/ogg';
        $mimes['mp3']	= 'audio/mpeg3, audio/x-mpeg-3, video/mpeg, video/x-mpeg';
        $mimes['mp4']	= 'video/mp4';
        $mimes['m4v']	= 'video/x-m4v';
        $mimes['webm']	= 'video/webm';
        $mimes['pdf']	= 'application/pdf';
        $mimes['doc']	= 'application/msword';
        $mimes['docx']	= 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        $mimes['xlsx']	= 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        $mimes['xls']	= 'application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel';
        $mimes['odt']	= 'application/vnd.oasis.opendocument.text';
        $mimes['csv']	= 'text/csv';
        $mimes['woff']	= 'application/x-font-woff';
        $mimes['woff2']	= 'application/x-font-woff2';
        $mimes['ttf']	= 'font/ttf';
        return $mimes;
    }

    /**
     * Custom largest image threshold.
     * @param string $threshold
     * @param string $imagesize
     * @param string $file
     * @param integer $attachment_id
     */
    public function big_image_size_threshold( $threshold, $imagesize, $file, $attachment_id ) : int {
        return 2048;
    }

    /**
     * Set the maximum image size of the images uploaded in WP Media Library.
     * @param array $file
     */
    public function wp_handle_upload_prefilter( $file ) : array {
        // Bail out early
        if( !get_field('media_library_max_image_size','options') ) {
            return $file;
        }
        // Set limit
        $limit = intval( get_field('media_library_max_image_size','options') );
        // Get fiel size
        $size = $file['size'] / 1024;
        // Check if this is an image
        $is_image = str_contains($file['type'],'image');
        // If is an image and the size is voer the limit
        if( $is_image && $size > $limit ) {
            $file['error'] = sprintf(__('Image files must be smaller than %skb','mklang'),$limit);
        }
        return $file;
    }

    /**
     * Set default values in media uploader.
     */
    function default_attachment_display_settings() : void {
        // Update options
        update_option('image_default_align','none');
        update_option('image_default_link_type','none');
        update_option('image_default_size','large');
    }

    /**
     * Automatically set the image title, alt-text, caption and description upon upload.
     * @param integer $post_ID
     */
    function add_attachment( $post_ID ) : void {
        // If this is an attachment
        if( wp_attachment_is_image($post_ID) ) {
            // Get title
            $image_title = get_post($post_ID )->post_title;
            $image_title = preg_replace('%\s*[-_\s]+\s*%', ' ',$image_title);
            $image_title = ucwords( strtolower($image_title));
            $image_meta = array(
                'ID'            => $post_ID,
                'post_title'    => $image_title,
                //'post_excerpt'  => $image_title, // Set image Caption (Excerpt)
                //'post_content'  => $image_title, // Set image Description (Content)
            );
            // Update image alt attribute
            update_post_meta($post_ID, '_wp_attachment_image_alt', $image_title);
            // Update post
            wp_update_post($image_meta);
        }
    }

    /**
     * Add image sizes.
     */
    public function add_image_sizes() : void {
        // Remove image sizes
        remove_image_size('1536x1536');
        remove_image_size('2048x2048');
        remove_image_size('768x768');
        // Set default image sizes
        // Thumbnail
        update_option('thumbnail_size_w',320);
        update_option('thumbnail_size_h',320);
        // Medium
        update_option('medium_size_w',640);
        update_option('medium_size_h',null);
        // Large
        update_option('large_size_w',960);
        update_option('large_size_h',null);	
        // Add image sizes
        add_image_size('admin-list-thumb',80,80,true);
        add_image_size('full-hd-thumb',1920,1280,true);
        add_image_size('max-thumb',2048,2048,true);
        add_image_size('social',1200,630,['center','center']);
        // add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
    }

    /**
     * Generate favicon image file versions and code for head.
     * In order to generate all data correctly the SVG favicon image field and the PNG favicon image field are required. This function also writes into MS XML configuration file and Android Chrome JSON configuration file.
     */
    public function generate_favicons() : void {
        // Bail out is this is not an administrator
        if( !current_user_can( 'manage_options' ) ) {
            return;
        }
        // Get favicons option
        $favicons = get_field('favicons','options');
        // Check if 'regenerate_favicons' is flagged to avoid launching this action at every save
        if( $favicons ) {
            if( !$favicons['regenerate_favicons'] ) {
                return;
            }
        }
        // Get favicon file uploaded by user
        $filename = get_attached_file($favicons['favicon']);
        if( !$filename ) {
            return;
        }
        // Array of versions
        $versions = [
            // Generic
            // '16'	=>	'generic',
            '32'	=>	'generic',
            // '57'	=>	'generic',
            // '76'	=>	'generic',
            // '96'	=>	'generic',
            // '128'	=>	'generic',
            // '192'	=>	'generic',
            // '228'	=>	'generic',
            // Android
            // '196'	=>	'android',
            // iOS
            // '120'	=>	'apple',
            // '152'	=>	'apple',
            // '167'	=>	'apple',
            '180'	=>	'apple',
            // Android Chrome (JSON)
            '192'	=>	'android',
            '512'	=>	'android',
            // MS (XML)
            '70'	=>	'microsoft',
            '150'	=>	'microsoft',
            '310'	=>	'microsoft',
        ];
        // Favicon dirs
        $favicon_path = get_template_directory() . '/project/favicon/';
        $favicon_uri = get_template_directory_uri() . '/project/favicon/';
        // Get array of uploads directory info
        // $uploads = wp_upload_dir();
        // Get uploads directory url
        // $favicon_uri = $uploads['url'];
        // Generate files
        foreach( $versions as $size => $type ) {
            // Use object buffering to avoid issues with headers
            ob_start();
            // Set correct image header for PNG file
            header('Content-type: image/png');
            // Get file sizes
            list( $width, $height ) = getimagesize($filename);
            // write_log($image_p);
            // Duplicate content from PNG
            $image = imagecreatefrompng($filename);
            // Create image with transparent background
            $image_p = imagecreatetruecolor( $size, $size );	
            imagealphablending($image_p, false);
            imagesavealpha($image_p, true);		
            $color = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
            imagefill($image_p, 0, 0, $color);
            // Create the definitive image
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size, $size, $width, $height);
            // Set directory to save the image file
            // $dir = ABSPATH . 'wp-content/uploads/favicon-' . $size . 'x' . $size . '.png';
            $dir = $favicon_path . 'favicon-' . $size . 'x' . $size . '.png';
            // Save filed to directory
            imagepng($image_p, $dir, 0);
            // Destroy image
            imagedestroy( $image );
            // Clean object
            ob_end_clean();
        }
        // Empty var to store favicon code for head
        $favicon_code = null;
        // If an SVG version has been uploaded by user
        if( $favicons['favicon_svg'] ) {
            $svg_url = ( is_ssl() ) ? str_replace( 'http://', 'https://', wp_get_attachment_url( $favicons['favicon_svg'] ) ) : wp_get_attachment_url( $favicons['favicon_svg'] );
            $favicon_code .= '<link rel="icon" type="image/svg+xml" sizes="all" href="' . $svg_url . '">' . PHP_EOL;
        }
        // Loop through sizes
        foreach( $versions as $size => $type ) {	
            // Sizes (Ex: '16x16')
            $sizes = $size . 'x' . $size;
            // If is an icon for Windows
            if( $type == 'generic' ) {
                $favicon_code .= '<link rel="icon" type="image/png" sizes="' . $sizes . '" href="' . $favicon_uri . 'favicon-' . $sizes . '.png" />' . PHP_EOL;
            // If is an icon for Android
            /*}elseif( $type == 'android' ) {
                $favicon_code .= '<link rel="shortcut icon" type="image/png" sizes="' . $sizes . '" href="' . $favicon_uri . 'favicon-' . $sizes . '.png" />' . PHP_EOL;
            */
            // If is an icon for iOS
            }elseif( $type == 'apple' ) {
                $favicon_code .= '<link rel="apple-touch-icon" sizes="' . $sizes . '" href="' . $favicon_uri . 'favicon-' . $sizes . '.png" />' . PHP_EOL;
            }
        }
        // Generate code for manifest.webmanifest (Android Chrome)
        $manifest_192 = [
            'src'	=>	 $favicon_uri . 'favicon-192x192.png',
            'type'	=>	'image/png',
            'sizes'	=>	'192x192'
        ];
        $manifest_512 = [
            'src'	=>	 $favicon_uri . 'favicon-512x512.png',
            'type'	=>	'image/png',
            'sizes'	=>	'512x512'
        ];
        $manifest = [
            'icons'	=>	[
                (object) $manifest_192,
                (object) $manifest_512,
            ],
        ];
        $manifest_json = json_encode( $manifest );
        // Write into manifest.webmanifest
        $manifest_webmanifest = fopen( $favicon_path . 'manifest.webmanifest', 'w') or die( __('Unable to open file!','mklang') );
        fwrite( $manifest_webmanifest, $manifest_json );
        fclose( $manifest_webmanifest );
        // Add JSON file to $favicon_code
        // This was removed because manifest.webmanifest is not required and affects performance too much
        // $favicon_code .= '<link rel="manifest" href="' . $favicon_uri . 'manifest.webmanifest">' . PHP_EOL;
        // Generate code for browserconfig.xml (Microsoft)
        $mobile_bar_color = ( get_field( 'mobile_bar_color', 'options' ) ) ? get_field( 'mobile_bar_color', 'options' ) : '#FFFFFF';
        $favicon_xml = '<?xml version="1.0" encoding="utf-8"?>';
        $favicon_xml .= '<browserconfig>';
        $favicon_xml .= '<msapplication>';
        $favicon_xml .= '<tile>';
        $favicon_xml .= '<square70x70logo src="' . $favicon_uri . 'favicon-70x70.png"/>';
        $favicon_xml .= '<square150x150logo src="' . $favicon_uri . 'favicon-150x150.png"/>';
        $favicon_xml .= '<square310x310logo src="' . $favicon_uri . 'favicon-310x310.png"/>';
        $favicon_xml .= '<TileColor>' . $mobile_bar_color . '</TileColor>';
        $favicon_xml .=' </tile>';
        $favicon_xml .= '</msapplication>';
        $favicon_xml .= '</browserconfig>';
        // Write into browserconfig.xml
        $browserconfig = fopen( $favicon_path . 'browserconfig.xml', 'w') or die( __('Unable to open file!','mklang') );
        fwrite( $browserconfig, $favicon_xml );
        fclose( $browserconfig );
        // Add XML file to $favicon_code
        // This was removed because manifest.webmanifest is not required and affects performance too much
        // $favicon_code .= '<meta name="msapplication-config" content="' . $favicon_path . 'browserconfig.xml" />' . PHP_EOL;
        // Update 'favicon_code' field in layout options page
        update_field('favicons_favicon_code',$favicon_code,'options');
        // Update 'favicon_manifest_json' field in layout options page
        update_field('favicons_favicon_manifest_json',$manifest_json,'options');
        // Update 'favicon_xml' field in layout options page
        update_field('favicons_favicon_xml',$favicon_xml,'options');
        // Reset 'regenerate_favicons' field in layout options page
        update_field('favicons_regenerate_favicons',false,'options');
        // Note on updating field in groups: Suppose a Group field named "hero" with a sub field named "image"... it will be saved to the database using the meta name "hero_image"
    }



    /*---------------------------------------------------------------------------------------
      ____ _     _____    _    _   _ _   _ ____  
     / ___| |   | ____|  / \  | \ | | | | |  _ \ 
    | |   | |   |  _|   / _ \ |  \| | | | | |_) |
    | |___| |___| |___ / ___ \| |\  | |_| |  __/ 
     \____|_____|_____/_/   \_\_| \_|\___/|_|

    Cleanup
    ---------------------------------------------------------------------------------------*/

    /**
     * Remove Admin Menu Link in theme customizer.
     */
    public function remove_theme_customizer() : void {
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
     * @param array $buttons
     */
    public function remove_tmce_buttons_line_1( $buttons ) : array {
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
        return array_diff($buttons,$remove);
    }

    /**
     * Remove options in tinymce line 2.
     * @param array $buttons
     */
    public function remove_tmce_buttons_line_2( $buttons ) : array {
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
        return array_diff($buttons,$remove);
    }

    /**
     * Tinymce cleanup.
     * @param array $set
     */
    public function tinymce_cleanup( $set ) : array {
        // $set['valid_elements'] = '*[id|class|style|href|target|rel|title|alt|src]';
        $set['valid_elements'] = '*[id|href|target|rel]';
        $set['invalid_styles'] = 'display position color font-family font-size text-align line-height top bottom left right margin margin-top margin-bottom margin-left margin-right border border-top border-bottom border-left border-right';
        return $set;
    }

    /**
     * Disable the emoji's.
     */
    public function disable_emojis() : void {
        // Remove actions
        remove_action('wp_head','print_emoji_detection_script',7);
        remove_action('admin_print_scripts','print_emoji_detection_script');
        remove_action('wp_print_styles','print_emoji_styles');
        remove_action('admin_print_styles','print_emoji_styles'); 
        // Remove filters
        remove_filter('the_content_feed','wp_staticize_emoji');
        remove_filter('comment_text_rss','wp_staticize_emoji'); 
        remove_filter('wp_mail','wp_staticize_emoji_for_email');
        // Add filters
        /**
         * Filter function used to remove the tinymce emoji plugin.
         * 
         * @param array $plugins 
         * @return array Difference betwen the two arrays
         */
        add_filter('tiny_mce_plugins',function( $plugins ) {
            if ( is_array( $plugins ) ) {
                return array_diff( $plugins, array( 'wpemoji' ) );
            }else{
                return [];
            }
        });
        /**
         * Remove emoji CDN hostname from DNS prefetching hints.
         * @param array $urls
         * @param string $relation_type
         */
        add_filter('wp_resource_hints',function( $urls, $relation_type ) : array {
            if ( 'dns-prefetch' == $relation_type ) {
                /** This filter is documented in wp-includes/formatting.php */
                $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
                $urls = array_diff( $urls, array( $emoji_svg_url ) );
            }
            return $urls;    
        },10,2);
    }

    /**
     * Remove toolbar items.
     */
    public function remove_toolbar_nodes( $wp_admin_bar ) : void {
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
     * You can add a filter to the result: mkt_remove_menu_items.
     */
    public function remove_menu_items() : void {
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
        $roles = apply_filters('mkt_remove_menu_items',$roles);
        // If role is not included
        if( !in_array(get_user_role(),$roles) ) {
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
     */
    public function remove_dashboard_meta() : void {
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
     * @link https://www.tutorialswebsite.com/how-to-display-only-published-posts-by-default-in-the-admin-area/
     */
    public function default_published_post() : void {
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
     * @link https://www.tutorialswebsite.com/how-to-display-only-published-posts-by-default-in-the-admin-area/
     */
    public function default_published_custom_post_type() : void {
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
     * @link https://github.com/WordPress/gutenberg/issues/19796
     * @param array $editor_settings
     * @param mixed $editor_context
     */
    public function block_editor_settings( $editor_settings, $editor_context ) : array {
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
     */
    public function admin_logo() : void {
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

}

/**
 * Get the current post type in Admin.
 * @link https://gist.github.com/bradvin/1980309
 * @link https://gist.github.com/DomenicF/3ebcf7d53ce3182854716c4d8f1ab2e2
 */
function get_current_post_type() : string {
	// Get globals
	global $post, $typenow, $current_screen;
    // If post and post type are set
	if( $post && $post->post_type ) {
		// We have a post so we can just get the post type from that
		return $post->post_type;
	}elseif( $typenow) {
		// Check the global $typenow - set in admin.php
		return $typenow;
	}elseif( $current_screen && $current_screen->post_type ) {
		// Check the global $current_screen object - set in sceen.php
		return $current_screen->post_type;
	}
	// We do not know the post type!
	return '';
}