<?php

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

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'svg-image', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->
		
			<?php if( $svg_id ) : ?>

				<?php echo get_svg_img( $svg_id, 'svg-icon fill-current' ); ?>

			<?php else : ?>

				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>

			<?php endif; ?>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->

<?php else : ?>
		
	<?php if( $svg_id ) : ?>
		
		<?php if( $class_name ) : ?>
			
			<?php echo get_svg_img( $svg_id, $class_name ); ?>
		
		<?php else : ?>
		
			<?php echo get_svg_img( $svg_id ); ?>

		<?php endif; ?>

	<?php endif; ?>
		
<?php endif; ?>