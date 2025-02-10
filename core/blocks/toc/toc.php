<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Table of Contents.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// List type.
$list_type = ( get_field('list_type') ) ? get_field('list_type') : 'ol';

// CSS classes.
$class_name = 'toc';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}else{
	$class_name .= ' list link-text';	
}

// Allowed blocks.
$allowed_blocks = [
	'core/list-item', 
];

// Tags.
$open_tag = '<' . $list_type . ' class="' . esc_attr($class_name) . '">';
$close_tag = '</' . $list_type . '>';
	
// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('toc',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
			<div class="mkcb-wp-block-info-right">
				<a class="js-toc button primary small">
					<?php _e('Refresh index','mklang'); ?>
				</a>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php echo $open_tag; ?>
				<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
			<?php echo $close_tag; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	echo $open_tag; ?>
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
	<?php echo $close_tag;
endif;