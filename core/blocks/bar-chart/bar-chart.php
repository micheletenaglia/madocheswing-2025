<?php

/**
 * Block Template: Bar chart.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Chart value and label
$value = get_field('chart_value');
$label = get_field('chart_label');

// CSS Classes.
$class_name = 'chart-bar-wrap';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'bar-chart', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>
			
		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->
			
			<?php if( $value && $label ) : ?>
			
				<div class="<?php echo esc_attr($class_name); ?>">
					<div class="chart-label">
						<span><?php echo $label; ?></span>
						<span><?php echo $value; ?>%</span>
					</div>
					<div class="chart-bar-bg">
						<div class="chart-bar" style="width: <?php echo str_replace( ',', '.', $value ); ?>%;">
						</div>
					</div>
				</div>

			<?php else : ?>
			
				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
			
			<?php endif; ?>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->

<?php else : ?>

	<?php if( $value && $label ) : ?>

		<div class="<?php echo esc_attr($class_name); ?>">
			<div class="chart-label">
				<span><?php echo $label; ?></span>
				<span><?php echo $value; ?>%</span>
			</div>
			<div class="chart-bar-bg">
				<div class="chart-bar" style="width: <?php echo str_replace( ',', '.', $value ); ?>%;">
				</div>
			</div>
		</div>

	<?php endif; ?>

<?php endif; ?>