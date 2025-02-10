<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Register core blocks with ACF.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
  ____  _     ___   ____ _  ______  
 | __ )| |   / _ \ / ___| |/ / ___| 
 |  _ \| |  | | | | |   | ' /\___ \ 
 | |_) | |__| |_| | |___| . \ ___) |
 |____/|_____\___/ \____|_|\_\____/ 

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Add core block category
add_filter('block_categories_all', 'hap_block_categories');

// Add project block category
add_filter('block_categories_all', 'hap_block_categories_project');

// Set allowed blocks
add_filter('allowed_block_types_all', 'hap_allowed_blocks', 10, 1);
add_filter('hap_block_list','project_allowed_blocks');

/* Actions ----------------------------------------------------------------------------*/

// Register core blocks
add_action('acf/init', 'hap_core_acf_blocks_init');

// Register project blocks
add_action('acf/init', 'hap_project_acf_blocks_init');

// Enqueue custom blocks scripts
add_action('enqueue_block_editor_assets', 'hap_block_editor_assets', PHP_INT_MAX);

/* Functions --------------------------------------------------------------------------*/

/**
 * Add category for blocks.
 *
 * @param array $categories
 * @return array $categories
 */
function hap_block_categories( $categories ) {
	
	$category_slugs = wp_list_pluck($categories, 'slug');
	
	return in_array ('custom_hap_block_category', $category_slugs, true ) ? $categories : array_merge(
		$categories,
		array(
			// This category is never assigned
			array(
				'slug'  => 'hap_block_category',
				'title' => __('Hap Core','hap'),
				'icon'  => null,
			),
			// Layout
			array(
				'slug'  => 'hap_block_category_layout',
				'title' => __('Hap / Layout','hap'),
				'icon'  => null,
			),
			// Images
			array(
				'slug'  => 'hap_block_category_images',
				'title' => __('Hap / Images','hap'),
				'icon'  => null,
			),
			// Buttons
			array(
				'slug'  => 'hap_block_category_buttons',
				'title' => __('Hap / Buttons and links','hap'),
				'icon'  => null,
			),
			// Modals
			array(
				'slug'  => 'hap_block_category_modals',
				'title' => __('Hap / Modals','hap'),
				'icon'  => null,
			),
			// Heros
			array(
				'slug'  => 'hap_block_category_heros',
				'title' => __('Hap / Heros','hap'),
				'icon'  => null,
			),
			// Get content
			array(
				'slug'  => 'hap_block_category_get_content',
				'title' => __('Hap / Get content','hap'),
				'icon'  => null,
			),
			// Lists
			array(
				'slug'  => 'hap_block_category_lists',
				'title' => __('Hap / Lists','hap'),
				'icon'  => null,
			),
			// UI Elements
			array(
				'slug'  => 'hap_block_category_ui_elements',
				'title' => __('Hap / UI Elements','hap'),
				'icon'  => null,
			),
			// Navigation
			array(
				'slug'  => 'hap_block_category_navigation',
				'title' => __('Hap / Navigation','hap'),
				'icon'  => null,
			),
			// Charts
			array(
				'slug'  => 'hap_block_category_charts',
				'title' => __('Hap / Charts','hap'),
				'icon'  => null,
			),
		)
	);
	
}

/**
 * Callback function to automate the inclusion 
 * of the path to the render template of the block
 * !!! Doesn't work, $is_preview is not found
 *
 * @param array $block
 * @return void
 */
function hap_block_callback( $block,  $is_preview ) {
	
	// Convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace( 
		[ 'acf/', '_' ], 
		[ '', '-' ], 
		$block['name']
	);
	
	$path = $slug . '/' . $slug . '.php';

	// Conditionally include a template part
	if (file_exists( HAP_PROJECT_BLOCKS . $path) ) {
		
		include( HAP_PROJECT_BLOCKS . $path );
	
	}elseif( file_exists( HAP_CORE_BLOCKS . $path ) ) {
		
		include( HAP_CORE_BLOCKS . $path );
	
	}

}

/**
 * Register core blocks.
 *
 * @return void.
 */
function hap_core_acf_blocks_init() {

    //======================================================================
    // Layout
    //======================================================================

    // Register a container block.
    acf_register_block_type(array(
        'name'              => 'container',
        'title'             => __('Container','hap'),
        'description'       => __('A block for designing complex layouts.','hap'),
        'category'          => 'hap_block_category_layout',
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
        'title'             => __('Simple div','hap'),
        'description'       => __('A simple DIV block.','hap'),
        'category'          => 'hap_block_category_layout',
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
        'title'             => __('Logo','hap'),
        'description'       => __('The logo block.','hap'),
        'category'          => 'hap_block_category_navigation',
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
        'title'             => __('Hamburger','hap'),
        'description'       => __('The hamburger block.','hap'),
        'category'          => 'hap_block_category_navigation',
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
        'title'             => __('Company data and footer links','hap'),
        'description'       => __('Useful info and links that can be used in the footer or elsewhere.','hap'),
        'category'          => 'hap_block_category_navigation',
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
        'title'             => __('Social links','hap'),
        'description'       => __('Links to social media.','hap'),
        'category'          => 'hap_block_category_navigation',
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
        'title'             => __('Bar chart','hap'),
        'description'       => __('The bar chart block.','hap'),
        'category'          => 'hap_block_category_charts',
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
        'title'             => __('Pie chart','hap'),
        'description'       => __('The pie chart block.','hap'),
        'category'          => 'hap_block_category_charts',
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
        'title'             => __('Hero primary','hap'),
        'description'       => __('The main hero block.','hap'),
        'category'          => 'hap_block_category_heros',
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
        'title'             => __('Hero video','hap'),
        'description'       => __('The video hero block.','hap'),
        'category'          => 'hap_block_category_heros',
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
        'title'             => __('Custom image','hap'),
        'description'       => __('Add a custom image.','hap'),
        'category'          => 'hap_block_category_images',
        'render_template'   => 'core/blocks/hap-image/hap-image.php',
        'icon' 				=> get_svg_icon(
            'hap-image-preview', 
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
        'title'             => __('Svg image','hap'),
        'description'       => __('Add a svg image.','hap'),
        'category'          => 'hap_block_category_images',
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
        'title'             => __('Image with sticker','hap'),
        'description'       => __('Add an image with sticker.','hap'),
        'category'          => 'hap_block_category_images',
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
        'title'             => __('Simple button','hap'),
        'description'       => __('Add a simple button.','hap'),
        'category'          => 'hap_block_category_buttons',
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
    
    // Register an action link block.
    acf_register_block_type(array(
        'name'              => 'action-link',
        'title'             => __('Action link','hap'),
        'description'       => __('Add an action link to track events.','hap'),
        'category'          => 'hap_block_category_buttons',
        'render_template'   => 'core/blocks/action-link/action-link.php',
        'icon' 				=> get_svg_icon(
            'action-link-preview', 
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
        'title'             => __('Link with content','hap'),
        'description'       => __('Add a link with inner blocks.','hap'),
        'category'          => 'hap_block_category_buttons',
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
        'title'             => __('WPML Language switcher','hap'),
        'description'       => __('Add a language switcher.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Key number','hap'),
        'description'       => __('Add an infographic-style key number.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Icon text','hap'),
        'description'       => __('Add a block with icon and text.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Banner','hap'),
        'description'       => __('A banner on two columns with text and image.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Simple span','hap'),
        'description'       => __('Just a simple span.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Table of contents','hap'),
        'description'       => __('Add a table of contents.','hap'),
        'category'          => 'hap_block_category_ui_elements',
        'render_template'   => 'core/blocks/toc/toc.php',
        'textdomain'		=> 'hap',
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
        'title'             => __('Tabs','hap'),
        'description'       => __('Add a tab component.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Tab','hap'),
        'description'       => __('A tab item.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Accordion','hap'),
        'description'       => __('Add an accordion component.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Accordion item','hap'),
        'description'       => __('An accordion item.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Photoswipe gallery','hap'),
        'description'       => __('A Photoswipe gallery.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'description'       => __('Add a slider component.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Swiper slide','hap'),
        'description'       => __('A slide for Swiper Slider.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Map','hap'),
        'description'       => __('A map block.','hap'),
        'category'          => 'hap_block_category_ui_elements',
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
        'category'          => 'hap_block_category_ui_elements',
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
        'title'             => __('Query','hap'),
        'description'       => __('Query posts and apply custom template.','hap'),
        'category'          => 'hap_block_category_get_content',
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
        'title'             => __('Post selector','hap'),
        'description'       => __('Select posts and apply custom template.','hap'),
        'category'          => 'hap_block_category_get_content',
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
        'title'             => __('Menu','hap'),
        'description'       => __('Add a WP menu.','hap'),
        'category'          => 'hap_block_category_get_content',
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
        'title'             => __('Get template','hap'),
        'description'       => __('Get a template as a block.','hap'),
        'category'          => 'hap_block_category_get_content',
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
        'title'             => __('Contact Form 7 modal','hap'),
        'description'       => __('A link/button to open a Contact Form 7 form in a modal.','hap'),
        'category'          => 'hap_block_category_modals',
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
        'title'             => __('Advanced list','hap'),
        'description'       => __('Add an advanced list.','hap'),
        'category'          => 'hap_block_category_lists',
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
        'title'             => __('List item','hap'),
        'description'       => __('An advanced list item.','hap'),
        'category'          => 'hap_block_category_lists',
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
        'title'             => __('Description list','hap'),
        'description'       => __('Add a description list.','hap'),
        'category'          => 'hap_block_category_lists',
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
        'title'             => __('Description list item','hap'),
        'description'       => __('A description list item.','hap'),
        'category'          => 'hap_block_category_lists',
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
 *
 * @url https://rudrastyh.com/gutenberg/remove-default-blocks.html
 *
 * @return $allowed_blocks.
 */
function hap_allowed_blocks( $allowed_blocks ) {
	
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

		// Yoast
		'yoast/faq-block',
		'yoast/how-to-block',
		'yoast-seo/breadcrumbs',
		
		// ACF Blocks
		// 'acf/hero-slider',
		// 'acf/common-block-slider',
		// 'acf/posts-per-term-selector',
		// 'acf/modal',
		// 'acf/photobutton',
		// 'acf/testimonial',
		// 'acf/video-embed',
		
		// Layout
		'acf/container',
		'acf/simple-div',
		// Images
        'acf/hap-image',
		'acf/svg-image',
		'acf/image-sticker',
		// Buttons and links
		'acf/simple-button',
		'acf/action-link',
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

	// $allowed_blocks = array_merge( $allowed_blocks, (array) apply_filters('hap_block_list', [] ) );
	$allowed_blocks = apply_filters( 'hap_block_list', $allowed_blocks );
	
	return $allowed_blocks;

}

/**
 * Enqueue block scripts.
 *
 * @return void.
 */
function hap_block_editor_assets() {
	
	wp_enqueue_script(
		'hap-blocks', 
		HAP_CORE_URI . 'assets/admin/backend-blocks.js', 
		['wp-blocks', 'wp-element', 'wp-edit-post']
	);

	if( file_exists( HAP_PROJECT_URI . 'assets/admin/backend-blocks.js' ) ) {
		
		wp_enqueue_script(
			'hap-project-blocks', 
			HAP_PROJECT_URI . 'assets/admin/backend-blocks.js', 
			['wp-blocks', 'wp-element', 'wp-edit-post']
		);
		
	}

}