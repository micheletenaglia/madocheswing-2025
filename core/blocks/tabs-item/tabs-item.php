<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Tabs Item.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CSS classes.
$class_name = 'tab';
if( get_field('order') ) { 
	$class_name .= ' tab-' . get_field('order');
	if( get_field('order') == 1 ) {
		$class_name .= ' open';
	}
}
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('tabs-item',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="<?php echo esc_attr($class_name); ?>">
			<InnerBlocks />
		</div>
	</div>
<?php else : 
	// Frontend
	?>			
	<div class="<?php echo esc_attr($class_name); ?>">
		<InnerBlocks />
	</div>
<?php endif;