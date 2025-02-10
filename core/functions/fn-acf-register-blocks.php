<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Register core blocks with ACF.
 *
 */

// Add core block category
add_filter('block_categories_all','mkt_block_categories');

// Add project block category
add_filter('block_categories_all','mkt_block_categories_project');

// Set allowed blocks
add_filter('allowed_block_types_all','mkt_allowed_blocks',10,1);
add_filter('mkt_block_list','project_allowed_blocks');

// Register core blocks
add_action('acf/init','mkt_core_acf_blocks_init');

// Register project blocks
add_action('acf/init','project_acf_blocks_init');

// Enqueue custom blocks scripts
add_action('enqueue_block_editor_assets','mkt_block_editor_assets',PHP_INT_MAX);

/**
 * Add category for blocks.
 * @param array $categories
 */
function mkt_block_categories( $categories ) : array {
	// Slugs
	$category_slugs = wp_list_pluck($categories,'slug');
	// Return value
	return in_array('custom_mkt_block_category', $category_slugs, true ) ? $categories : array_merge(
		$categories,
		[
			// This category is never assigned
			[
				'slug'  => 'mkt_block_category',
				'title' => __('Mkt Core','mklang'),
				'icon'  => null,
			],
			// Layout
			[
				'slug'  => 'mkt_block_category_layout',
				'title' => __('Mkt / Layout','mklang'),
				'icon'  => null,
			],
			// Images
			[
				'slug'  => 'mkt_block_category_images',
				'title' => __('Mkt / Images','mklang'),
				'icon'  => null,
			],
			// Buttons
			[
				'slug'  => 'mkt_block_category_buttons',
				'title' => __('Mkt / Buttons and links','mklang'),
				'icon'  => null,
			],
			// Modals
			[
				'slug'  => 'mkt_block_category_modals',
				'title' => __('Mkt / Modals','mklang'),
				'icon'  => null,
            ],
			// Heros
			[
				'slug'  => 'mkt_block_category_heros',
				'title' => __('Mkt / Heros','mklang'),
				'icon'  => null,
            ],
			// Get content
			[
				'slug'  => 'mkt_block_category_get_content',
				'title' => __('Mkt / Get content','mklang'),
				'icon'  => null,
            ],
			// Lists
			[
				'slug'  => 'mkt_block_category_lists',
				'title' => __('Mkt / Lists','mklang'),
				'icon'  => null,
            ],
			// UI Elements
			[
				'slug'  => 'mkt_block_category_ui_elements',
				'title' => __('Mkt / UI Elements','mklang'),
				'icon'  => null,
            ],
			// Navigation
			[
				'slug'  => 'mkt_block_category_navigation',
				'title' => __('Mkt / Navigation','mklang'),
				'icon'  => null,
            ],
			// Charts
			[
				'slug'  => 'mkt_block_category_charts',
				'title' => __('Mkt / Charts','mklang'),
				'icon'  => null,
            ],
        ]
	);
}

/**
 * Callback function to automate the inclusion of the path to the render template of the block
 * !!! Doesn't work, $is_preview is not found.
 * @param array $block
 */
function mkt_block_callback( $block,  $is_preview ) : void {
	// Convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace( 
		[ 'acf/', '_' ], 
		[ '', '-' ], 
		$block['name']
	);
	// Path
	$path = $slug . '/' . $slug . '.php';
	// Conditionally include a template part
	if (file_exists( get_template_directory() . '/project/blocks/' . $path) ) {
		include(get_template_directory() . '/project/blocks/' . $path);
	}elseif( file_exists( get_template_directory() . '/core/blocks/' . $path ) ) {
		include( get_template_directory() . '/core/blocks/' . $path );
	}
}

/**
 * Register core blocks.
 */
function mkt_core_acf_blocks_init() : void {

    //======================================================================
    // Layout
    //======================================================================

    // Register a container block.
    acf_register_block_type(array(
        'name'              => 'container',
        'title'             => __('Container','mklang'),
        'description'       => __('A block for designing complex layouts.','mklang'),
        'category'          => 'mkt_block_category_layout',
        'render_template'   => 'core/blocks/container/container.php',
        'icon' 				=> get_svg_icon(
            'container-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a simple div.
    acf_register_block_type(array(
        'name'              => 'simple-div',
        'title'             => __('Simple div','mklang'),
        'description'       => __('A simple DIV block.','mklang'),
        'category'          => 'mkt_block_category_layout',
        'render_template'   => 'core/blocks/simple-div/simple-div.php',
        'icon' 				=> get_svg_icon(
            'simple-div-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));
    
    //======================================================================
    // Navigation
    //======================================================================

    // Register the logo block.
    acf_register_block_type(array(
        'name'              => 'logo',
        'title'             => __('Logo','mklang'),
        'description'       => __('The logo block.','mklang'),
        'category'          => 'mkt_block_category_navigation',
        'render_template'   => 'core/blocks/logo/logo.php',
        'icon' 				=> get_svg_icon(
            'logo-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    // Register the hamburger block.
    acf_register_block_type(array(
        'name'              => 'hamburger',
        'title'             => __('Hamburger','mklang'),
        'description'       => __('The hamburger block.','mklang'),
        'category'          => 'mkt_block_category_navigation',
        'render_template'   => 'core/blocks/hamburger/hamburger.php',
        'icon' 				=> get_svg_icon(
            'hamburger-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    // Register the Company data and footer links block.
    acf_register_block_type(array(
        'name'              => 'company-data',
        'title'             => __('Company data and footer links','mklang'),
        'description'       => __('Useful info and links that can be used in the footer or elsewhere.','mklang'),
        'category'          => 'mkt_block_category_navigation',
        'render_template'   => 'core/blocks/company-data/company-data.php',
        'icon' 				=> get_svg_icon(
            'company-data-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    // Register the Social links block.
    acf_register_block_type(array(
        'name'              => 'social-links',
        'title'             => __('Social links','mklang'),
        'description'       => __('Links to social media.','mklang'),
        'category'          => 'mkt_block_category_navigation',
        'render_template'   => 'core/blocks/social-links/social-links.php',
        'icon' 				=> get_svg_icon(
            'social-links-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    //======================================================================
    // Charts
    //======================================================================

    // Register the bar chart block.
    acf_register_block_type(array(
        'name'              => 'bar-chart',
        'title'             => __('Bar chart','mklang'),
        'description'       => __('The bar chart block.','mklang'),
        'category'          => 'mkt_block_category_charts',
        'render_template'   => 'core/blocks/bar-chart/bar-chart.php',
        'icon' 				=> get_svg_icon(
            'bar-chart-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    // Register the pie chart block.
    acf_register_block_type(array(
        'name'              => 'pie-chart',
        'title'             => __('Pie chart','mklang'),
        'description'       => __('The pie chart block.','mklang'),
        'category'          => 'mkt_block_category_charts',
        'render_template'   => 'core/blocks/pie-chart/pie-chart.php',
        'icon' 				=> get_svg_icon(
            'pie-chart-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    //======================================================================
    // Heros
    //======================================================================

    // Register a hero primary block.
    acf_register_block_type(array(
        'name'              => 'hero-primary',
        'title'             => __('Hero primary','mklang'),
        'description'       => __('The main hero block.','mklang'),
        'category'          => 'mkt_block_category_heros',
        'render_template'   => 'core/blocks/hero-primary/hero-primary.php',
        'icon' 				=> get_svg_icon(
            'hero-primary-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a hero video block.
    acf_register_block_type(array(
        'name'              => 'hero-video',
        'title'             => __('Hero video','mklang'),
        'description'       => __('The video hero block.','mklang'),
        'category'          => 'mkt_block_category_heros',
        'render_template'   => 'core/blocks/hero-video/hero-video.php',
        'icon' 				=> get_svg_icon(
            'hero-video-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));


    //======================================================================
    // Images
    //======================================================================

    // Register a custom image block.
    acf_register_block_type(array(
        'name'              => 'hap-image',
        'title'             => __('Custom image','mklang'),
        'description'       => __('Add a custom image.','mklang'),
        'category'          => 'mkt_block_category_images',
        'render_template'   => 'core/blocks/mkt-image/mkt-image.php',
        'icon' 				=> get_svg_icon(
            'mkt-image-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> false
        ),
    ));
    
    // Register an svg icon block.
    acf_register_block_type(array(
        'name'              => 'svg-image',
        'title'             => __('Svg image','mklang'),
        'description'       => __('Add a svg image.','mklang'),
        'category'          => 'mkt_block_category_images',
        'render_template'   => 'core/blocks/svg-image/svg-image.php',
        'icon' 				=> get_svg_icon(
            'svg-image-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));
    
    // Register an image with sticker block.
    acf_register_block_type(array(
        'name'              => 'image-sticker',
        'title'             => __('Image with sticker','mklang'),
        'description'       => __('Add an image with sticker.','mklang'),
        'category'          => 'mkt_block_category_images',
        'render_template'   => 'core/blocks/image-sticker/image-sticker.php',
        'icon' 				=> get_svg_icon(
            'image-sticker-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));	
    
    //======================================================================
    // Buttons and links
    //======================================================================

    // Register a simple button block.
    acf_register_block_type(array(
        'name'              => 'simple-button',
        'title'             => __('Simple button','mklang'),
        'description'       => __('Add a simple button.','mklang'),
        'category'          => 'mkt_block_category_buttons',
        'render_template'   => 'core/blocks/simple-button/simple-button.php',
        'icon' 				=> get_svg_icon(
            'simple-button-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));
        
    // Register a anchor with content block.
    acf_register_block_type(array(
        'name'              => 'anchor-content',
        'title'             => __('Link with content','mklang'),
        'description'       => __('Add a link with inner blocks.','mklang'),
        'category'          => 'mkt_block_category_buttons',
        'render_template'   => 'core/blocks/anchor-content/anchor-content.php',
        'icon' 				=> get_svg_icon(
            'anchor-content-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    //======================================================================
    // UI Elements
    //======================================================================
    
    // Register a WPML language switcher block.
    acf_register_block_type(array(
        'name'              => 'wpml-switcher',
        'title'             => __('WPML Language switcher','mklang'),
        'description'       => __('Add a language switcher.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/wpml-switcher/wpml-switcher.php',
        'icon' 				=> get_svg_icon(
            'wpml-switcher-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));	
    
    // Register a key number block.
    acf_register_block_type(array(
        'name'              => 'key-number',
        'title'             => __('Key number','mklang'),
        'description'       => __('Add an infographic-style key number.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/key-number/key-number.php',
        'icon' 				=> get_svg_icon(
            'key-number-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));	
    
    // Register a icon text block.
    acf_register_block_type(array(
        'name'              => 'icon-text',
        'title'             => __('Icon text','mklang'),
        'description'       => __('Add a block with icon and text.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/icon-text/icon-text.php',
        'icon' 				=> get_svg_icon(
            'icon-text-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a banner with 2 columns.
    acf_register_block_type(array(
        'name'              => 'banner-col-2',
        'title'             => __('Banner','mklang'),
        'description'       => __('A banner on two columns with text and image.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/banner-col-2/banner-col-2.php',
        'icon' 				=> get_svg_icon(
            'banner-col-2-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a simple span.
    /*acf_register_block_type(array(
        'name'              => 'simple-span',
        'title'             => __('Simple span','mklang'),
        'description'       => __('Just a simple span.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/simple-span/simple-span.php',
        'icon' 				=> get_svg_icon(
            'simple-span-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));*/

    // Register a table of contents.
    acf_register_block_type(array(
        'name'              => 'toc',
        'title'             => __('Table of contents','mklang'),
        'description'       => __('Add a table of contents.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/toc/toc.php',
        'textdomain'		=> 'mklang',
        'icon' 				=> get_svg_icon(
            'toc-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a tab component.
    acf_register_block_type(array(
        'name'              => 'tabs',
        'title'             => __('Tabs','mklang'),
        'description'       => __('Add a tab component.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/tabs/tabs.php',
        'icon' 				=> get_svg_icon(
            'tabs-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a tab item.
    acf_register_block_type(array(
        'name'              => 'tabs-item',
        'title'             => __('Tab','mklang'),
        'description'       => __('A tab item.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/tabs-item/tabs-item.php',
        'icon' 				=> get_svg_icon(
            'tabs-item-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true,
        ),
        'parent'	=> ['acf/tabs']
    ));

    // Register an accordion component.
    acf_register_block_type(array(
        'name'              => 'accordion',
        'title'             => __('Accordion','mklang'),
        'description'       => __('Add an accordion component.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/accordion/accordion.php',
        'icon' 				=> get_svg_icon(
            'accordion-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register an accordion item.
    acf_register_block_type(array(
        'name'              => 'accordion-item',
        'title'             => __('Accordion item','mklang'),
        'description'       => __('An accordion item.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/accordion-item/accordion-item.php',
        'icon' 				=> get_svg_icon(
            'accordion-item-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true,
        ),
        'parent'	=> ['acf/accordion']
    ));

    // Register a Photoswipe gallery.
    acf_register_block_type(array(
        'name'              => 'photoswipe-gallery',
        'title'             => __('Photoswipe gallery','mklang'),
        'description'       => __('A Photoswipe gallery.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/photoswipe-gallery/photoswipe-gallery.php',
        'icon' 				=> get_svg_icon(
            'photoswipe-gallery-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> false
        ),
    ));		
    
    // Register a Swiper slider component.
    acf_register_block_type(array(
        'name'              => 'swiper',
        'title'             => 'Swiper Slider',
        'description'       => __('Add a slider component.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/swiper/swiper.php',
        'icon' 				=> get_svg_icon(
            'swiper-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a Swiper slide component.
    acf_register_block_type(array(
        'name'              => 'swiper-slide',
        'title'             => __('Swiper slide','mklang'),
        'description'       => __('A slide for Swiper Slider.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/swiper-slide/swiper-slide.php',
        'icon' 				=> get_svg_icon(
            'swiper-slide-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true,
        ),
        'parent'	=> ['acf/swiper']
    ));
    
    // Register a map block.
    acf_register_block_type(array(
        'name'              => 'map',
        'title'             => __('Map','mklang'),
        'description'       => __('A map block.','mklang'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/map/map.php',
        'icon' 				=> get_svg_icon(
            'map-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));
    
    // Register a link with icon block.
    acf_register_block_type(array(
        'name'              => 'link-with-icon',
        'title'             => __('Icon link','project'),
        'description'       => __('A link with an icon.','project'),
        'category'          => 'mkt_block_category_ui_elements',
        'render_template'   => 'core/blocks/link-with-icon/link-with-icon.php',
        'icon' 				=> get_svg_icon(
            'link-with-icon-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));		

    //======================================================================
    // Get content
    //======================================================================

    // Register a post query block.
    acf_register_block_type(array(
        'name'              => 'query',
        'title'             => __('Query','mklang'),
        'description'       => __('Query posts and apply custom template.','mklang'),
        'category'          => 'mkt_block_category_get_content',
        'render_template'   => 'core/blocks/query/query.php',
        'icon' 				=> get_svg_icon(
            'query-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));

    // Register a post selector block.
    acf_register_block_type(array(
        'name'              => 'post-selector',
        'title'             => __('Post selector','mklang'),
        'description'       => __('Select posts and apply custom template.','mklang'),
        'category'          => 'mkt_block_category_get_content',
        'render_template'   => 'core/blocks/post-selector/post-selector.php',
        'icon' 				=> get_svg_icon(
            'post-selector-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));
        
    // Register a WP menu block.
    acf_register_block_type(array(
        'name'              => 'menu-wp',
        'title'             => __('Menu','mklang'),
        'description'       => __('Add a WP menu.','mklang'),
        'category'          => 'mkt_block_category_get_content',
        'render_template'   => 'core/blocks/menu/menu.php',
        'icon' 				=> get_svg_icon(
            'menu-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));	

    // Register a get template block.
    acf_register_block_type(array(
        'name'              => 'get-template',
        'title'             => __('Get template','mklang'),
        'description'       => __('Get a template as a block.','mklang'),
        'category'          => 'mkt_block_category_get_content',
        'render_template'   => 'core/blocks/get-template/get-template.php',
        'icon' 				=> get_svg_icon(
            'get-template-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
        ),
    ));	


    //======================================================================
    // Modals
    //======================================================================
    
    // Register a modal to open a Contact Form 7 form.
    acf_register_block_type(array(
        'name'              => 'modal-form-cf7',
        'title'             => __('Contact Form 7 modal','mklang'),
        'description'       => __('A link/button to open a Contact Form 7 form in a modal.','mklang'),
        'category'          => 'mkt_block_category_modals',
        'render_template'   => 'core/blocks/modal-form-cf7/modal-form-cf7.php',
        'icon' 				=> get_svg_icon(
            'modal-form-cf7-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            // 'multiple'	=> false
        ),
    ));

    //======================================================================
    // Lists
    //======================================================================
    
    // Register an advanced list.
    acf_register_block_type(array(
        'name'              => 'advanced-list',
        'title'             => __('Advanced list','mklang'),
        'description'       => __('Add an advanced list.','mklang'),
        'category'          => 'mkt_block_category_lists',
        'render_template'   => 'core/blocks/advanced-list/advanced-list.php',
        'icon' 				=> get_svg_icon(
            'advanced-list-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> true,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register an advanced list item.
    acf_register_block_type(array(
        'name'              => 'advanced-list-item',
        'title'             => __('List item','mklang'),
        'description'       => __('An advanced list item.','mklang'),
        'category'          => 'mkt_block_category_lists',
        'render_template'   => 'core/blocks/advanced-list-item/advanced-list-item.php',
        'icon' 				=> get_svg_icon(
            'advanced-list-item-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true,
        ),
        'parent'	=> ['acf/advanced-list']
    ));

    // Register a description list.
    acf_register_block_type(array(
        'name'              => 'description-list',
        'title'             => __('Description list','mklang'),
        'description'       => __('Add a description list.','mklang'),
        'category'          => 'mkt_block_category_lists',
        'render_template'   => 'core/blocks/description-list/description-list.php',
        'icon' 				=> get_svg_icon(
            'description-list-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true
        ),
    ));

    // Register a description list item.
    acf_register_block_type(array(
        'name'              => 'description-list-item',
        'title'             => __('Description list item','mklang'),
        'description'       => __('A description list item.','mklang'),
        'category'          => 'mkt_block_category_lists',
        'render_template'   => 'core/blocks/description-list-item/description-list-item.php',
        'icon' 				=> get_svg_icon(
            'description-list-item-preview', 
            null,
            'block-core'
        ),
        'supports'          => array(
            'anchor'	=> false,
            'align'		=> false,
            'mode'		=> false,
            'jsx'		=> true,
        ),
        'parent'	=> ['acf/description-list']
    ));
}

/**
 * Generate the whitelist of blocks to be used in the project.
 * @link https://rudrastyh.com/gutenberg/remove-default-blocks.html
 */
function mkt_allowed_blocks( $allowed_blocks ) : array {
    // Listo f allwed blocks
	$allowed_blocks =  [
		// WP Core blocks
		'core/block', // Activate reusable blocks
		// 'core/group', // Activate block groups
		// 'core/columns',
		'core/image',
		'core/gallery',
		'core/heading',
		'core/paragraph',
		'core/list',
		'core/list-item',
		'core/table',
		'core/quote',
		'core/html',
		'core/shortcode',
		'core/embed',
		// 'core-embed/youtube',
		// 'core-embed/vimeo',
        /*----------------------------*/
		// Yoast
		'yoast/faq-block',
		'yoast/how-to-block',
		'yoast-seo/breadcrumbs',
		/*----------------------------*/
		// ACF Blocks
		// 'acf/hero-slider',
		// 'acf/common-block-slider',
		// 'acf/posts-per-term-selector',
		// 'acf/modal',
		// 'acf/photobutton',
		// 'acf/testimonial',
		// 'acf/video-embed',
		/*----------------------------*/
		// Layout
		'acf/container',
		'acf/simple-div',
		// Images
        'acf/hap-image',
		'acf/svg-image',
		'acf/image-sticker',
		// Buttons and links
		'acf/simple-button',
		'acf/anchor-content',
		// Modals
		'acf/modal-form-cf7',
		// Heros
		'acf/hero-primary',
		'acf/hero-video',
		// Get content
		'acf/get-template',
		'acf/query',
		'acf/post-selector',
		'acf/menu-wp',
		// Lists
		'acf/advanced-list',
		'acf/advanced-list-item',
		'acf/description-list',
		'acf/description-list-item',
		// UI Elements
		'acf/key-number',
		'acf/icon-text',
		'acf/banner-col-2',
		'acf/wpml-switcher',
		// 'acf/simple-span',
		'acf/toc',
		'acf/tabs',
		'acf/tabs-item',
		'acf/accordion',
		'acf/accordion-item',
		'acf/swiper',
		'acf/swiper-slide',
		'acf/photoswipe-gallery',
		'acf/map',
		'acf/link-with-icon',
		// Navigation
		'acf/logo',
		'acf/hamburger',
        'acf/company-data',
        'acf/social-links',
		// Charts
		'acf/bar-chart',
		'acf/pie-chart',
	];
	// $allowed_blocks = array_merge( $allowed_blocks, (array) apply_filters('mkt_block_list', [] ) );
	$allowed_blocks = apply_filters('mkt_block_list',$allowed_blocks);
	return $allowed_blocks;
}

/**
 * Enqueue block scripts.
 */
function mkt_block_editor_assets() : void {
	// Core JS block file
	wp_enqueue_script(
		'theme-blocks', 
		get_template_directory_uri() . '/core/assets/admin/backend-blocks.js', 
		['wp-blocks','wp-element','wp-edit-post']
	);
    // Project JS block file
	if( file_exists(get_template_directory() . '/project/assets/admin/backend-blocks.js') ) {
		wp_enqueue_script(
			'project-blocks', 
			get_template_directory_uri() . '/project/assets/admin/backend-blocks.js', 
			['wp-blocks','wp-element','wp-edit-post']
		);
	}
}