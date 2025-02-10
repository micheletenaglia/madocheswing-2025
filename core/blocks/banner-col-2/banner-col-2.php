<?php

/**
 * Banner with 2 columns Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields
$text_color = get_field('text_color');
$shadow_color = get_field('shadow_color');
$bg_color = get_field('bg_color');
$image = get_field('bg_image');

// ID fpr anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// CSS classes.
$class_name = 'banner-cols-2';	
if( $text_color ) { 
	$class_name .= ' ' . $text_color;
}
if( $shadow_color ) { 
	$class_name .= ' ' . $shadow_color;
}
if( $bg_color ) { 
	$class_name .= ' ' . $bg_color;
}
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Restrict allowed blocks
// https://github.com/WordPress/WordPress/tree/master/wp-includes/blocks
$allowed_blocks = [
	'core/heading',
	'core/paragraph',
	'core/list', 
	'core/image', 
	'core/html', 
	'acf/action-link',	
	'acf/simple-button',
	'acf/modal-form-cf7',
	'acf/svg-image',
	'acf/get-template',
];

?>

<?php if( $is_preview ) : ?>
	<div class="hap-wp-block"><!-- Start preview -->
		<div class="hap-wp-block-info"><!-- Start preview header -->
			<div class="hap-wp-block-info-left">
				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'banner-col-2', null, 'block-core' ); ?>
				</figure>
				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div><!-- End preview header -->
		<div class="hap-wp-block-content"><!-- Start preview content -->
			<?php if( $image ) : ?>
				<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
					<div class="banner-col-2-left">
						<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
					</div>
					<div class="banner-col-2-right">
						<?php echo wp_get_attachment_image( $image, 'full' ); ?>
					</div>
				</div>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
			<?php endif; ?>
		</div><!-- End preview content -->
	</div><!-- End preview -->

<?php else : ?>

	<?php if( $image ) : ?>	
		<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
			<div class="banner-col-2-left">
				<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
			</div>
			<div class="banner-col-2-right">
                <?php hap_thumb( $image, 'full' ); ?>
				<?php // echo wp_get_attachment_image( $image, 'full' ); ?>
			</div>
		</div>
	<?php endif; ?>

<?php endif;