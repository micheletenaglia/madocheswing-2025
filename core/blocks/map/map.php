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

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Locations args
$locations_args = [];
if( get_field('post_selection') == 'post_type' ) {

	$locations_args = [
		'numberposts'	=>	-1,
		'fields'		=>	'ids',
		'post_type'		=>	get_field('post_type'),
	];

}elseif( get_field('post_selection') == 'posts' ) {

	$locations_args = [
		'post_type'		=>	'any',
		'numberposts'	=>	-1,
		'fields'		=>	'ids',
		'post__in'		=>	get_field('posts'),
	];

}

// Get locations
if( $locations_args ) {
	
	$locations = get_posts( $locations_args );

	// Args for map
	$args = [ 
		'locations'		=>	$locations, 
		'field'			=>	'address', 
		'wrap_style'	=>	$class_name,
		'map_style'		=>	null
	];

}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'map', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>
			
		</div><!-- End preview header -->

		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php if( $locations_args ) : ?>
				<ul>
					<?php foreach( $locations as $location ) : ?>
						<li><?php echo get_the_title( $location ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div><!-- End preview content -->
		
	</div><!-- End preview -->

<?php else : ?>

	<?php if( $locations_args ) : ?>

		<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?>>
			<?php hap_get_template( 'map/map', $args ); ?>
		</div>

	<?php endif; ?>

<?php endif;