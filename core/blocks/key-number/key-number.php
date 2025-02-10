<?php

/**
 * Block Template: Key Number.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CSS classes.
$class_name = 'key-number';	
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Allowed blocks.
$allowed_blocks = [
	'core/heading', 
	'core/paragraph'
];

// Template.
$template = [
	['core/heading', [
		'level'			=>	4,
		'className'		=>	'key-number-title',
		'placeholder'	=>	__('Number','hap'),
	]],
	['core/paragraph', [
		'className'		=>	'key-number-subtitle',
		'placeholder'	=>	__('Subtitle','hap'),
	]],
	['core/paragraph', [
		'className'		=>	'key-number-content',
		'placeholder'	=>	__('Content','hap'),
	]],
];

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'key-number', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->

		<div class="<?php echo esc_attr($class_name); ?>"><!-- Start preview content -->

			<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
		
		</div><!-- End preview content -->

	</div><!-- End preview -->

<?php else : ?>

	<div class="<?php echo esc_attr($class_name); ?>">

		<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />

	</div>
		
<?php endif; ?>