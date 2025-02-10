<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Icon and Text.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Icon.
$icon = null;

// Svg img.
$svg_id = get_field('svg_img');

// CSS Classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Get SVG image.
if( $svg_id ) {
	if( $class_name ) {
		$icon = get_svg_img($svg_id,$class_name);
	}else{
		$icon = get_svg_img($svg_id);
	}
	$icon_preview = get_svg_img($svg_id,'mkcb-svg-icon');
}

// Restrict allowed blocks.
// https://github.com/WordPress/WordPress/tree/master/wp-includes/blocks
$allowed_blocks = [
	'core/heading',
	'core/image', 
	'core/paragraph',
	'core/list',
	'core/list-item', 
	'core/html', 
	'acf/simple-button', 
];

// Template.
$template = [
	['core/heading', [
		'level'			=>	4,
		'placeholder'	=>	__('Title','mklang'),
	]],
	['core/paragraph', [
		'placeholder'	=>	__('Content','mklang'),
	]],
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('icon-text',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $svg_id ) : ?>
				<div class="mkcb-block icon-text">
					<div class="icon-text-svg">
						<?php echo $icon_preview; ?>
					</div>
					<div class="icon-text-content">
						<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
					</div>
				</div>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	if( $svg_id ) : ?>
		<div class="mkcf-block icon-text">
			<div class="icon-text-svg">
				<?php echo $icon; ?>
			</div>
			<div class="icon-text-content">
				<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
			</div>
		</div>
	<?php endif;
endif;