<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Accordion Item.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$title = get_field('title');

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('accordion-item',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $title ) : ?>
				<div class="accordion-trigger">
					<?php echo esc_html($title); ?>
				</div>
				<div class="accordion-content">
					<InnerBlocks />
				</div>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	if( $title ) : ?>
		<div class="accordion-trigger">
			<?php echo esc_html($title); ?>
		</div>
		<div class="accordion-content">
			<InnerBlocks />
		</div>
	<?php endif;
endif;