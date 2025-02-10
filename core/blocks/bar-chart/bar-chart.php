<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

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

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('bar-chart',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $value && $label ) : ?>
				<div class="<?php echo esc_attr($class_name); ?>">
					<div class="chart-label">
						<span><?php echo $label; ?></span>
						<span><?php echo $value; ?>%</span>
					</div>
					<div class="chart-bar-bg">
						<div class="chart-bar" style="width: <?php echo str_replace(',','.',$value); ?>%;">
						</div>
					</div>
				</div>
			<?php else : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else :
	// Frontend
	if( $value && $label ) : ?>
		<div class="<?php echo esc_attr($class_name); ?>">
			<div class="chart-label">
				<span><?php echo esc_html($label); ?></span>
				<span><?php echo esc_html($value); ?>%</span>
			</div>
			<div class="chart-bar-bg">
				<div class="chart-bar" style="width: <?php echo str_replace( ',', '.', $value); ?>%;">
				</div>
			</div>
		</div>
	<?php endif;
endif;