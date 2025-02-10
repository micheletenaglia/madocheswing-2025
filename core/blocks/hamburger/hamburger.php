<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Hamburger.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CSS Classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('hamburger',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<div class="<?php echo esc_attr($class_name); ?> menu-toggle-bars">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
<?php else :
	// Frontend
	?>
	<div class="<?php echo esc_attr($class_name); ?> menu-toggle-bars">
		<span></span>
		<span></span>
		<span></span>
	</div>	
<?php endif;