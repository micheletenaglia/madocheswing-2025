<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Key Number.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CSS classes.
$class_name = 'key-number';	
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'core/heading', 
	'core/paragraph'
];

// Template.
$template = [
	['core/heading', [
		'level'			=>	4,
		'className'		=>	'key-number-title',
		'placeholder'	=>	__('Number','mklang'),
	]],
	['core/paragraph', [
		'className'		=>	'key-number-subtitle',
		'placeholder'	=>	__('Subtitle','mklang'),
	]],
	['core/paragraph', [
		'className'		=>	'key-number-content',
		'placeholder'	=>	__('Content','mklang'),
	]],
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('key-number',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="<?php echo esc_attr($class_name); ?>">
			<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
		</div>
	</div>
<?php else :
	// Frontend
	?>
	<div class="<?php echo esc_attr($class_name); ?>">
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
	</div>
<?php endif;