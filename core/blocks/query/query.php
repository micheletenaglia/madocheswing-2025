<?php

/**
 * Block Template: Query.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Template
$template = ( get_field('query_template') ) ? get_field('query_template') : 'post/post-card';

// Query args
$items_args = [
	'post_type'			=>	get_field('post_type'),
	'posts_per_page'	=>	get_field('posts_per_page'),
	'order'				=>	get_field('order'),
	'orderby'			=>	get_field('orderby'),
];

// If orderby meta key
if( get_field('meta_key') ) {
	$items_args['meta_key'] = get_field('meta_key');
}

// If taxonomy
if( get_field('taxonomy') && get_field('term') ) {
	$items_args['tax_query'] = [
        [
            'taxonomy'  => get_field('taxonomy'),
            'field'     => 'slug',
            'terms'     => get_field('term'),
        ]
    ];
}

// Get posts
$items = new WP_Query( $items_args );

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'query', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php if( get_field('query_template') && get_field('post_type') ) : ?>

				<?php if( $items->have_posts() ) : ?>

					<ul>

						<?php while ( $items->have_posts() ) : $items->the_post(); ?>

							<li><?php the_title(); ?></li>

						<?php endwhile; ?>

					</ul>

				<?php else : ?>

					<strong class="text-error"><?php _e('No posts match the query','hap'); ?></strong>

				<?php endif; ?>

				<?php wp_reset_postdata(); ?>
			
			<?php else : ?>

				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>

			<?php endif; ?>

		</div><!-- End preview content -->

	</div><!-- End preview -->

<?php else : ?>
		
	<?php if( get_field('query_template') && get_field('post_type') ) : ?>

		<?php if( $items->have_posts() ) : ?>

			<?php while ( $items->have_posts() ) : $items->the_post(); ?>

				<?php hap_get_template( $template ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	<?php endif; ?>
		
<?php endif; ?>