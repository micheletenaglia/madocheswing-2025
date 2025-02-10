<?php

/**
 * Block Template: Pie chart.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Chart size
$size = get_field('chart_size');

// Chart values
$values = get_field('chart_values');

// Default palette if no color selected
$palette = hap_color_palette();

// Index to associate iteration and color keys
$index = 0;

// Check for values
if( $values ) {
	// Default values
	$get_values = [];
	// Default labels
	$get_labels = [];
	// Default labels
	$get_colors = [];
	// Loop and populate array
	foreach( $values as $value ) {
		$get_values[] = $value['value'];
		if( $value['color'] ) {
			// Set selected color
			$color = $value['color'];
		}else{
			// Set default color
			$color = $palette[$index];
		}
		$get_colors[] = $color;
		$get_labels[$value['label']] = [
			'color'	=>	$color,
			'value'	=>	$value['value']
		];
		$index++;
	}
}

// CSS Classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'pie-chart', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>
			
		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php if( $values ) : ?>
			
				<?php if( $get_labels ) : ?>

					<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="pie-chart <?php echo esc_attr($class_name); ?>">
						
						<div>
							<?php echo hap_pie_chart( $get_values, null, $get_colors, $size ); ?>
						</div>
						
						<div class="ml-4">
							<?php echo ( get_field('title') ) ? '<h6 class="mb-2">' . get_field('title') . '</h6>' : null; ?>
							<ul>
								<?php foreach( $get_labels as $label => $data ) : ?>
									<li class="chart-label">
										<span>
											<span class="dot" style="background-color: <?php echo $data['color']; ?>"></span>
											<?php echo $data['value'] . '% ' . $label; ?>
										</span>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

					</div>

					<?php else : ?>

					<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="pie-chart <?php echo esc_attr($class_name); ?>">
						<?php echo hap_pie_chart( $get_values, null, $get_colors, $size ); ?>
					</div>

				<?php endif; ?>

			<?php else : ?>
			
				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
			
			<?php endif; ?>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->

<?php else : // hap_pie_chart( $values, $css_classes = null, $colors = null, $size = 200 ) ?>

	<?php if( $values ) : ?>

		<?php if( $get_labels ) : ?>

			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="pie-chart flex items-center <?php echo esc_attr($class_name); ?>">
				
				<div>
					<?php echo hap_pie_chart( $get_values, null, $get_colors, $size ); ?>
				</div>
				
				<div class="ml-4">
					<?php echo ( get_field('title') ) ? '<h6 class="mb-2">' . get_field('title') . '</h6>' : null; ?>
					<ul>
						<?php foreach( $get_labels as $label => $data ) : ?>
							<li class="chart-label">
								<span>
									<span class="dot" style="background-color: <?php echo $data['color']; ?>"></span>
									<?php echo $data['value'] . '% ' . $label; ?>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

			</div>

		<?php else : ?>

			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="pie-chart <?php echo esc_attr($class_name); ?>">
				<?php echo hap_pie_chart( $get_values, null, $get_colors, $size ); ?>
			</div>

		<?php endif; ?>

	<?php endif; ?>

<?php endif; ?>