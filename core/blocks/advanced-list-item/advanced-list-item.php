<?php

/**
 * Block Template: Advanced List Item.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CSS classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'advanced-list-item', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->

		<div class="<?php echo esc_attr($class_name); ?>">

			<InnerBlocks />

		</div>

	</div><!-- End preview -->
		
<?php else : ?>
				
	<li class="<?php echo esc_attr($class_name); ?>">

		<InnerBlocks />

	</li>
		
<?php endif; ?>