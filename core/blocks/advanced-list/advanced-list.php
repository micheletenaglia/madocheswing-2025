<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Advanced List.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// CSS classes.
$classes = [
	'list_style'	=>	get_field('list_style'),
	'list_columns'	=>	get_field('list_columns'),
];
if( $classes['list_columns'] ) {
	$classes['list-multi-cols'] = 'list-multi-cols';
	$classes['list_columns_gap'] = get_field('list_columns_gap');
	$classes['list_columns_separator'] = 'list-width-border';
	$classes['list_columns_separator_style'] = get_field('list_columns_separator_style');
	$classes['list_columns_separator_color'] = get_field('list_columns_separator_color');
}
$class_name = implode( ' ', $classes );
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'acf/advanced-list-item', 
];

// Template.
$template = [
	['acf/advanced-list-item', [
		'placeholder'	=>	__('Insert blocks','mklang'),
	]],
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('advanced-list',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
				<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
			</div>
		</div>
	</div>
<?php else :
	// Frontend
	?>
	<ul <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
	</ul>
<?php endif;