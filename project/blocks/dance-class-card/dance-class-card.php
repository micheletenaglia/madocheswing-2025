<?php

/**
 * Banner with 2 columns Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get fields
$dance_class = get_field('dance_class');

?>

<?php if( $is_preview ) : ?>
    <!-- Preview -->
	<div class="hap-wp-block">
		<div class="hap-wp-block-info">
			<div class="hap-wp-block-info-left">
				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'dance-class-card', null, 'block-project' ); ?>
				</figure>
				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="hap-wp-block-content">
			<?php if( $dance_class ) : ?>
				<div>
					<h4><?php echo get_the_title($dance_class); ?></h4>
				</div>
			<?php else : ?>
				<div>
    				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
				</div>
			<?php endif; ?>
		</div>		
	</div>
<?php else :
    if( $dance_class ) :
        hap_get_template(
            'dance-class/dance-class-card',
            ['post_id'=>$dance_class]
        );
    endif;
endif;