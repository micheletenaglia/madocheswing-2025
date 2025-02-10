<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Link with content.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 * !!! Problem with duplicated IDs, now disabled.
 */

// Link
$link = get_field('link');
$target_link = null;

if( $link ) {
	// If is external link, add attributes
	if( $link && '_blank' === $link['target'] ) {
		$target_link = 'target="' . esc_attr($link['target']) . '" rel="noopener noreferrer nofollow"';
	}
}

// CSS classes.
$class_name = '';
if( get_field('display') ) {
	$class_name .= get_field('display');
}
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Restrict allowed blocks
// https://github.com/WordPress/WordPress/tree/master/wp-includes/blocks
$allowed_blocks = [
	'core/image',
	'core/heading',
	'core/paragraph',
	'core/list',
	'core/list-item',
	'core/quote',
	'core/html',
	'acf/simple-div',
	'acf/key-number',
	'acf/svg-image',
	'acf/image-sticker',
	'acf/icon-text',
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('anchor-content',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $link ) : ?>
				<div class="<?php echo esc_attr($class_name); ?>">
					<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
				</div>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	if( $link ) : ?>
		<a class="<?php echo esc_attr($class_name); ?>" href="<?php echo esc_url($link['url']); ?>" <?php echo $target_link; ?>>
			<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
		</a>
	<?php endif;
endif;