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
	// Slugs
	$category_slugs = wp_list_pluck($categories, 'slug');
    // Return value
	return in_array('project_block_category', $category_slugs, true) ? $categories : array_merge(
		$categories,
		[
			[
				'slug'  => 'project_block_category',
				'title' => 'Airen',
				'icon'  => null,
            ],
        ]
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
            'name'              => 'sportelli',
            'title'             => __('Counters','project'),
            'description'       => __('Airen counters.','project'),
            'category'          => 'project_block_category',
            'render_template'   => 'project/blocks/sportelli/sportelli.php',
			'icon' 				=> get_svg_icon(
				'sportelli-preview', 
				null,
				'block-project',
				'sportelli'
			),
            'supports'          => array(
				'anchor'	=> true,
                'align'		=> false,
                'mode'		=> false,
            ),
        ));
	}
}

/**
 *
 * Update the whitelist of blocks with project blocks.
 *
 * @param array $allowed_blocks
 * @return array $project_allowed_blocks
 */
function project_allowed_blocks( $allowed_blocks ) {
	
	$project_allowed_blocks =  [
		'acf/sportelli',
	];
	
	$allowed_blocks = array_merge( $allowed_blocks, $project_allowed_blocks);
		
	return $allowed_blocks;
	
}