<?php

/**
 * Block Template: Modal Form CF7.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// CF7 Form.
$form = get_field('cf7_form');

// Button.
$label = ( get_field('label') ) ? get_field('label') : __('Show the form','hap');

// CSS classes.
$class_name = 'cf7-modal-form';
if( get_field( 'text_color' ) ) { 
	$class_name .= ' ' . get_field( 'text_color' );
}
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Link class attribute.
$link_class = 'js-cf7-modal-form';
$link_class_preview = null;
if( get_field('appearance') == 'button' ) { 
	$link_class  .= ' button ' . get_field('button_style') . ' ' . get_field('button_size');
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'modal-form-cf7', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php if( !is_cf7_activated() ) : ?>

				<strong class="text-error"><?php _e('Contact form 7 not found. This block only works with Contact Form 7 forms.','hap'); ?></strong>

			<?php elseif( !$form ) : ?>

				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>

			<?php else : ?>

				<a href="#" class="<?php echo $link_class; ?>"><?php echo $label; ?></a><br>
				<span style="font-size: .75rem;"><strong><?php _e('Title','hap'); ?>: </strong> <span><?php echo get_the_title($form) . ' - <strong>ID:</strong> ' . $form; ?></span></span>

			<?php endif; ?>
		
		</div><!-- End preview content -->

	</div><!-- End preview -->
		
<?php else : ?>
		
	<?php if( $form ) : ?>
		
		<a href="#" class="<?php echo $link_class; ?>" data-form="<?php echo $form; ?>"><?php echo $label; ?></a>
			
		<div data-form="<?php echo esc_attr($form); ?>" data-form-id="<?php echo esc_attr($form); ?>" class="js-cf7-modal-form cf7-modal-form-layer">
		</div>
		
		<div data-form-id="<?php echo esc_attr($form); ?>" class="<?php echo esc_attr($class_name); ?>">
			
			<div class="cf7-modal-form-content">
				
			<div data-form="<?php echo esc_attr($form); ?>" class="js-cf7-modal-form cursor-pointer absolute top-3 right-3"><?php echo get_svg_icon( 'times', 'svg-icon fill-current h-6' ); ?></div>

				<?php echo do_shortcode('[contact-form-7 id="' . $form . '"]'); ?>
	
			</div>
			
		</div>
		
	<?php endif; ?>

<?php endif; ?>