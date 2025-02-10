<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Simple Button .
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Link.
$link = get_field('button_link');

if( $link ) {
	// If is external link, add attributes
	$target_link = null;
	if( $link && '_blank' === $link['target'] ) {
		$target_link = 'target="' . esc_attr($link['target']) . '" rel="noopener noreferrer nofollow"';
	}
}

// CSS Classes.
$css_classes = [
	'button'	=>	'button',
	'style'		=>	get_field('button_style'),
	'size'		=>	get_field('button_size'),
];

$class_name = implode( ' ', $css_classes );
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('simple-button',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $link ) : ?>
				<a class="<?php echo esc_attr($class_name); ?>" href="#" <?php echo $target_link; ?>><?php echo esc_html($link['title']); ?></a>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>	
<?php else : 
	// Frontend
	if( $link ) : ?>
		<a class="<?php echo esc_attr($class_name); ?>" href="<?php echo esc_url($link['url']); ?>" <?php echo $target_link; ?>><?php echo esc_html($link['title']); ?></a>
	<?php endif;
endif;