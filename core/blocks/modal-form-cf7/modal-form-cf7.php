<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

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
$label = ( get_field('label') ) ? get_field('label') : __('Show the form','mklang');

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

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('modal-form-cf7',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( !mkt_plugin_active('cf7') ) : ?>
				<strong class="text-error"><?php _e('Contact form 7 not found. This block only works with Contact Form 7 forms.','mklang'); ?></strong>
			<?php elseif( !$form ) : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php else : ?>
				<a href="#" class="<?php echo esc_attr($link_class); ?>"><?php echo esc_html($label); ?></a><br>
				<span style="font-size: .75rem;"><strong><?php _e('Title','mklang'); ?>: </strong> <span><?php echo get_the_title($form) . ' - <strong>ID:</strong> ' . esc_attr($form); ?></span></span>
			<?php endif; ?>
		</div>
	</div>
<?php else :
	// Frontend 
	if( $form ) : ?>
		<a href="#" class="<?php echo esc_attr($link_class); ?>" data-form="<?php echo esc_attr($form); ?>"><?php echo esc_html($label); ?></a>
		<div data-form="<?php echo esc_attr($form); ?>" data-form-id="<?php echo esc_attr($form); ?>" class="js-cf7-modal-form cf7-modal-form-layer">
		</div>
		<div data-form-id="<?php echo esc_attr($form); ?>" class="<?php echo esc_attr($class_name); ?>">
			<div class="cf7-modal-form-content">
			<div data-form="<?php echo esc_attr($form); ?>" class="js-cf7-modal-form cursor-pointer absolute top-3 right-3"><?php echo get_svg_icon('times','svg-icon fill-current h-6'); ?></div>
				<?php echo do_shortcode('[contact-form-7 id="' . $form . '"]'); ?>
			</div>
		</div>
	<?php endif;
endif;