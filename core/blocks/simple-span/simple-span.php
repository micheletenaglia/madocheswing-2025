<?php

/**
 * Block Template: Simple span.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Content.
$span_content = get_field('span_content');

// CSS classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'core/image', 
	'core/html',
	'acf/action-link',
	'acf/simple-button',
	'acf/svg-image',
];

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'simple-span', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<span class="<?php echo esc_attr($class_name); ?>">
			<?php echo $span_content; ?>
			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
		</span>

	</div><!-- End preview -->
		
<?php else : ?>

	<span class="<?php echo esc_attr($class_name); ?>">
		<?php echo $span_content; ?>
		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
	</span>
		
<?php endif; ?>