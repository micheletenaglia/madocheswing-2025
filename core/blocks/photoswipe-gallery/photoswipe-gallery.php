<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Photoswipe gallery.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get fields
$images = get_field('images');
$preview_image_size = ( get_field('preview_image_size') ) ? get_field('image_size') : 'medium';
$full_image_size = ( get_field('full_image_size') ) ? get_field('image_size') : 'max-thumb';
$card_template = get_field('card_template');
$remove_wrapper = get_field('remove_wrapper');

// CSS Classes.
$class_name = 'mkcf-gallery';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('photoswipe-gallery',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $images ) : ?>
				<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>" style="display: grids; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 2rem;">
					<?php foreach( $images as $image ): ?>
						<?php echo wp_get_attachment_image($image['ID'],'thumbnail',false,['style'=>'display: block;']); ?>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the mandatory fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else :
	// Frontend
	if( $images ) :
		if( !$remove_wrapper ) : ?>
			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
		<?php endif;
			if( $card_template ) :
				foreach( $images as $image ) :
					mkt_get_template($card_template,['image'=>$image]);
				endforeach;
			else :
			foreach( $images as $image ) : ?>
					<a title="<?php echo esc_attr($image['title']); ?>" href="<?php echo esc_url($image['sizes']['max-thumb']); ?>" data-pswp-width="<?php echo esc_attr($image['sizes']['max-thumb-width']); ?>" data-pswp-height="<?php echo esc_attr($image['sizes']['max-thumb-height']); ?>">
						<img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" width="<?php echo esc_attr($image['sizes']['medium-width']); ?>" height="<?php echo esc_attr($image['sizes']['medium-height']); ?>"/>
					</a>
				<?php endforeach;
			endif; 
		if( !$remove_wrapper ) : ?>
			</div>
		<?php endif;
	 endif;
endif;