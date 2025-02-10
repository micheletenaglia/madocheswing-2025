<?php

/**
 * Block Template: Hero Video.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Video URL
$video_url = get_field('video');

// Video controls
$controls = [];
if( get_field('video_controls') ) {
	$controls = get_field('video_controls');
}

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// CSS Classes.
$class_name = 'hap-block hero-video';	
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Restrict allowed blocks
// https://github.com/WordPress/WordPress/tree/master/wp-includes/blocks
$allowed_blocks = [
	'core/heading',
	'core/image', 
	'core/paragraph',
	'core/html', 
	'acf/simple-div', 
	'acf/container', 
	'acf/action-link', 
	'acf/simple-button', 
	'acf/modal-form-cf7',
];

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'hero-video', '', 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->
			
			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">

				<div class="hero-video-content">

					<div>

						<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />

					</div>

				</div>

				<div class="hero-primary-filter"></div>

			</div>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->
		
<?php else : ?>
		
	<?php if( $video_url ) : ?>
	<?php // if( !$toggle && $video_url ) : ?>
		
		<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>">
			
			<video <?php echo implode( ' ', $controls ); ?> id="<?php echo esc_attr($id) . '-video'; ?>" poster="<?php echo wp_get_attachment_url( get_field('poster') ); ?>" class="<?php if( get_field('play_on_scroll') ) { echo 'video-reveal'; }; ?>">
				<source src="<?php echo $video_url; ?>" type="video/mp4">
				<?php _e('Your browser does not support HTML5 video.','hap'); ?>
			</video>
			
			<div class="hero-video-filter <?php echo get_field('filter_classes'); ?>"></div>

			<div class="hero-video-content">
				
				<div>
	
					<InnerBlocks allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" />
					
				</div>

			</div>
			
			<?php // if( $filter && $filter != 'default' ) : ?>
				<?php // get_template_part( 'project/templates/block/hero-video/' . $filter ); ?>
			<?php // endif; ?>
			
		</div>
		
	<?php endif; ?>	
		
<?php endif; ?>