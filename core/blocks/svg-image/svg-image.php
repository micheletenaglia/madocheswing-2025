<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Simple button.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Link.
$svg_id = get_field('svg_img');

// CSS Classes.
$class_name = null;
if( !empty( $block['className'] ) ) { 
	$class_name .= 'svg-icon ' . $block['className'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('svg-image',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $svg_id ) :
				echo get_svg_img($svg_id,'svg-icon fill-current');
			else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else :
	// Frontend
	if( $svg_id ) :
		if( $class_name ) :
			echo get_svg_img($svg_id,$class_name);
		else :
			echo get_svg_img($svg_id);
		endif;
	endif;
endif;