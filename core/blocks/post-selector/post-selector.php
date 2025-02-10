<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

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

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('post-selector',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( $items->have_posts() && get_field('post_selector_posts') ) : ?>
				<ul>
					<?php while ( $items->have_posts() ) : 
						$items->the_post(); ?>
						<li><?php the_title(); ?></li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<strong class="text-error"><?php _e('Select at least one post','mklang'); ?></strong>
			<?php endif;
			wp_reset_postdata(); ?>
		</div>
	</div>
<?php else : 
	// Frontend
	if( get_field('post_selector_posts') ) :
		if( $items->have_posts() ) :
			while ( $items->have_posts() ) :
				$items->the_post();
				mkt_get_template($template);
			endwhile; 
		endif;
		wp_reset_postdata();
	endif; 
endif;