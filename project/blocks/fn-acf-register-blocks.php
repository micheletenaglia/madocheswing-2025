<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Add category for project blocks.
 *
 * @param array $categories
 * @return array $categories
 */
function mkt_block_categories_project( $categories ) {
	// Get categories slugs
	$category_slugs = wp_list_pluck($categories, 'slug');
    // Add custom category
	return in_array('project_block_category', $category_slugs, true) ? $categories : array_merge(
		$categories,
		array(
			array(
				'slug'  => 'project_block_category',
				'title' => 'Mado\' che Swing',
				'icon'  => null,
			),
		)
	);
}

/**
 * Register project blocks.
 *
 * @return void.
 */
function project_acf_blocks_init() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a store cards loop block.
        acf_register_block_type(array(
            'name'              => 'dance-class-card',
            'title'             => __('Dance class card','project'),
            'description'       => __('Dance class card with minimal data.','project'),
            'category'          => 'project_block_category',
            'render_template'   => 'project/blocks/dance-class-card/dance-class-card.php',
			'icon' 				=> get_svg_icon(
				'dance-class-card-preview', 
				null,
				'block-project',
				'dance-class-card'
			),
            'supports'          => [
				'anchor'	=> false,
                'align'		=> false,
                'mode'		=> false,
            ],
        ));
		
	}
}

/**
 *
 * Update the whitelist of blocks with project blocks.
 *
 * @param array $allowed_blocks
 * @return array $allowed_blocks
 */
function project_allowed_blocks( $allowed_blocks ) {
    // Add to project blocks allowed blocks
	$project_allowed_blocks =  [
		'acf/dance-class-card',
	];
	// Merge arrays
	$allowed_blocks = array_merge($allowed_blocks,$project_allowed_blocks);
	return $allowed_blocks;
}