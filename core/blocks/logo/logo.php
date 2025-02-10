<?php

/**
 * Block Template: Logo.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CSS Classes.
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Version (dark or light)
$version = get_field('logo_version');

// With or without link
$logo_link = get_field('logo_link');

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'logo', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>
			
		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php echo hap_get_logo( $class_name, $version ); ?>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->

<?php else : ?>

	<?php if( $logo_link == 'link') : ?>

		<a title="<?php _e('Homepage','hap'); ?>" href="<?php echo get_home_url(); ?>"><?php echo hap_get_logo( $class_name, $version ); ?></a>

	<?php else : ?>

		<?php echo hap_get_logo( $class_name, $version ); ?>

	<?php endif; ?>		

<?php endif; ?>