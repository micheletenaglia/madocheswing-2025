<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Image with sticker.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// CSS classes.
$class_name = 'sticker-wrap';
if( !empty( $block['className'] ) ) { 
	$class_name .= $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'core/heading', 
	'core/paragraph'
];

// Template.
$template = [
	['core/image', [
		'placeholder'	=>	__('Image','mklang'),
	]],
	['acf/simple-div', [
		'className'		=>	'sticker',
		'placeholder'	=>	__('Sticker','mklang'),
        'content'		=>	__('Sticker','mklang'),
	]],
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('image-sticker',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
				<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
				<div class="sticker-preview"></div>
			</div>
		</div>
	</div>
<?php else :
	// Frontend
	?>	
	<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
	</div>
<?php endif;