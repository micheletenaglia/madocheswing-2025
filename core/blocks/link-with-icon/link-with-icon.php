<?php

/**
 * Block Template: Icon link.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$link = get_field('link');
$icon = get_svg_icon( 'icon-link', 'svg-icon fill-current', 'core' );
if( get_field('icon') ) {
	$icon = get_svg_img( get_field('icon'), 'svg-icon fill-current' );
}
if( $is_preview ) {
	$icon = str_replace( 'class', 'style="height: 1rem;" class', $icon );
}

// Create class attribute allowing for custom "className" value.
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
					<?php echo get_svg_icon( 'link-with-icon', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->
			
			<?php if( !$link ) : ?>

				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
			
			<?php else : ?>
	
				<div class="<?php echo esc_attr($class_name); ?>">
					<?php echo $icon; ?> <?php echo $link['title']; ?>
				</div>
			
			<?php endif; ?>

		</div><!-- End preview content -->

	</div><!-- End preview -->

<?php else :
		
	if( $link ) :

		echo hap_icon_link( $link, $class_name, $icon );

	endif;
		
endif;