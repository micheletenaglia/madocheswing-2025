<?php

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
			
		$icon = get_svg_img( $svg_id, $class_name );
		
	}else{
		
		$icon = get_svg_img( $svg_id );

	}
	
	$icon_preview = get_svg_img( $svg_id, 'hap-svg-icon' );

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
	'acf/action-link', 
	'acf/simple-button', 
];

// Template.
$template = [
	['core/heading', [
		'level'			=>	4,
		'placeholder'	=>	__('Title','hap'),
	]],
	['core/paragraph', [
		'placeholder'	=>	__('Content','hap'),
	]],
];

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'icon-text', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>
			
		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php if( $svg_id ) : ?>

				<div class="hap-block icon-text">

					<div class="icon-text-svg">
						<?php echo $icon_preview; ?>
					</div>

					<div class="icon-text-content">
						<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
					</div>

				</div>

			<?php else : ?>

				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>

			<?php endif; ?>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->

<?php else : ?>

	<?php if( $svg_id ) : ?>
		
		<div class="hap-block icon-text">

			<div class="icon-text-svg">
				<?php echo $icon; ?>
			</div>

			<div class="icon-text-content">
				<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" template="<?php echo esc_attr( wp_json_encode( $template ) ); ?>" />
			</div>

		</div>

	<?php endif; ?>
		
<?php endif; ?>