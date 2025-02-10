<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Get template.
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

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Template path
$template = get_field('template');

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('get-template',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $template ) : 
				// Get template
				mkt_get_template( $template );
			else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	mkt_get_template( $template );
endif;