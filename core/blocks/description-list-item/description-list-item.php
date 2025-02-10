<?php

/**
 * Block Template: Description List Item.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'description-list-item', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->

			<h4><?php echo get_field('dt'); ?></h4>
			<span><?php echo get_field('dd'); ?></span>
			
		</div><!-- End preview content -->

	</div><!-- End preview -->
		
<?php else : ?>
				
	<dt><?php echo get_field('dt'); ?></dt>
	<dd><?php echo get_field('dd'); ?></dd>

<?php endif; ?>