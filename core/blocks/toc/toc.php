<?php

/**
 * Block Template: Table of Contents.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// List type.
$list_type = ( get_field('list_type') ) ? get_field('list_type') : 'ol';

// CSS classes.
$class_name = 'toc';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}else{
	$class_name .= ' list link-text';	
}

// Allowed blocks.
$allowed_blocks = [
	'core/list-item', 
];

// Tags.
$open_tag = '<' . $list_type . ' class="' . esc_attr($class_name) . '">';
$close_tag = '</' . $list_type . '>';
	
?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'toc', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

			<div class="hap-wp-block-info-right">
				<a class="js-toc button primary small">
					<?php _e('Refresh index','hap'); ?>
				</a>
			</div>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php echo $open_tag; ?>
				<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
			<?php echo $close_tag; ?>

		</div><!-- End preview content -->

	</div><!-- End preview -->
		
<?php else : ?>

	<?php echo $open_tag; ?>
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
	<?php echo $close_tag; ?>
		
<?php endif; ?>