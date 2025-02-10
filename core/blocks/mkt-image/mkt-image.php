<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Image.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$image_id = get_field('image_id');
$size = get_field('size') ? get_field('size') : 'full';

// Options
$options = [
    'priority'  =>  get_field('priority'),
    'figure'    =>  get_field('figure'),
    'fig_class' =>  get_field('fig_class'),
    'caption'   =>  get_field('fig_caption'),
    'style'     =>  get_field('style'),
    'bg_image'  =>  get_field('bg_image'),
];

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
    $options['id'] = $block['anchor'];
}

// CSS Classes.
if( !empty( $block['className'] ) ) { 
	$options['img_class'] = $block['className'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('mkt-image',null,'block-core'); ?>
				</figure>
				<div>
                    <span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
                    <span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
            <div class="mkcb-wp-block-content">
                <?php if( $image_id ) : ?>
                    <?php mkt_thumb( $image_id, $size, $options ); ?>
                    <?php else : ?>
                        <strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
                <?php endif; ?>
            </div>
		</div>
	</div>
<?php else :
    // Frontend
    if( $image_id ) :
        mkt_thumb($image_id,$size,$options);
    endif;
endif;