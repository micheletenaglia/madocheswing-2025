<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Swiper.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$toggle = get_field('toggle');

// CSS Classes.
$class_name = 'swiper';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'acf/swiper-slide',
];

// Template.
$template = [
	['acf/swiper-slide', [
		'placeholder'	=>	__('Insert blocks','mklang'),
	]],
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('swiper',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<div class="<?php echo esc_attr($class_name); ?>">
				<div class="swiper-wrapper" aria-live="polite">
					<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
				</div>
			</div>
		</div>
	</div>
<?php else :
	// Frontend
	?>			
	<div class="<?php echo esc_attr($class_name); ?>">
		<div class="swiper-wrapper" aria-live="polite">
			<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
		</div>
	</div>
<?php endif;