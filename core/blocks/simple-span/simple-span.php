<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Simple span.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Content.
$span_content = get_field('span_content');

// CSS classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'core/image', 
	'core/html',
	'acf/simple-button',
	'acf/svg-image',
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('simple-span',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<span class="<?php echo esc_attr($class_name); ?>">
			<?php echo $span_content; ?>
			<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
		</span>
	</div>
<?php else : 
	// Frontend
	?>
	<span class="<?php echo esc_attr($class_name); ?>">
		<?php echo $span_content; ?>
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
	</span>
<?php endif;