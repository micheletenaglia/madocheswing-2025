<?php

/**
 * Block Template: Image.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$image_id = get_field('image_id');
$size = get_field('size') ? get_field('size') : 'full';

// Options
$options = [
    'priority'  =>  get_field('priority'),
    'figure'    =>  get_field('figure'),
    'fig_class' =>  get_field('fig_class'),
    'caption'   =>  get_field('fig_caption'),
    'style'     =>  get_field('style'),
    'bg_image'  =>  get_field('bg_image'),
];

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
    $options['id'] = $block['anchor'];
}

// CSS Classes.
if( !empty( $block['className'] ) ) { 
	$options['img_class'] = $block['className'];
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		<div class="hap-wp-block-info"><!-- Start preview header -->
			<div class="hap-wp-block-info-left">
				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'hap-image', null, 'block-core' ); ?>
				</figure>
				<div>
                    <span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
                    <span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div><!-- End preview header -->
            <div class="hap-wp-block-content"><!-- Start preview content -->
                <?php if( $image_id ) : ?>
                    <?php hap_thumb( $image_id, $size, $options ); ?>
                    <?php else : ?>
                        <strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
                <?php endif; ?>
            </div>
		</div><!-- End preview content -->
	</div><!-- End preview -->

<?php else :
    
    if( $image_id ) :
        hap_thumb( $image_id, $size, $options );
    endif;

endif;