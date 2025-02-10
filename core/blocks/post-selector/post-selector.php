<?php

/**
 * Block Template: Post selector.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields
$items = get_field('post_selector_posts');
$template = ( get_field('post_selector_template') ) ? get_field('post_selector_template') : 'post/post-card';

// Query posts
$items_args = [
	'post_type'	=>	'any',
	'post__in'	=>	get_field('post_selector_posts'),
	'order'		=>	'ASC',
	'orderby'	=>	'post__in',
];
$items = new WP_Query( $items_args );

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'post-selector', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->

			<?php if( $items->have_posts() && get_field('post_selector_posts') ) : ?>

				<ul>

					<?php while ( $items->have_posts() ) : $items->the_post(); ?>

						<li><?php the_title(); ?></li>

					<?php endwhile; ?>

				</ul>

			<?php else : ?>

				<strong class="text-error"><?php _e('Select at least one post','hap'); ?></strong>

			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		</div><!-- End preview content -->

	</div><!-- End preview -->

<?php else : ?>
		
	<?php if( get_field('post_selector_posts') ) : ?>

		<?php if( $items->have_posts() ) : ?>

			<?php while ( $items->have_posts() ) : $items->the_post(); ?>

				<?php hap_get_template( $template ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	<?php endif; ?>
		
<?php endif; ?>