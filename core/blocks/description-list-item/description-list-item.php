<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Description List Item.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('description-list-item',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<h4><?php echo get_field('dt'); ?></h4>
			<span><?php echo get_field('dd'); ?></span>
		</div>
	</div>
<?php else : 
	// Frontend
	?>			
	<dt><?php echo get_field('dt'); ?></dt>
	<dd><?php echo get_field('dd'); ?></dd>
<?php endif;