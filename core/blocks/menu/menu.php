<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Menu.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$menu_term = null;
$menu_args = [];

// If field.
if( get_field('menu_id') ) {
	
	// Get menu term by ID
	$menu_term = get_term_by( 'term_taxonomy_id', get_field('menu_id') );
	
	// Get menu ID
	$menu_args['menu'] = get_field('menu_id');
	
	// Use a nav element
	$menu_args['container']	= 'nav';
	
	// Menu CSS class
	if( !empty( $block['className'] ) ) { 
		$menu_args['menu_class'] = $block['className'];
	}

	// Create id attribute allowing for custom "anchor" value.
	if( !empty( $block['anchor'] ) ) {
		$menu_args['menu_id'] = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" value.
	if( !empty( $block['className'] ) ) { 
		$menu_args['menu_class'] = $block['className'];
	}

}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('menu',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( !get_field('menu_id') ) : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php else : ?>
				<?php if( !$menu_term ) : ?>
					<strong class="text-error"><?php _e('Error: no menu found','mklang'); ?></strong>
				<?php else :
					wp_nav_menu($menu_args);
				endif;
			endif; ?>
		</div>
	</div>
<?php else :
	// Frontend
	if( $menu_term ) :
		wp_nav_menu($menu_args);
	endif;
endif;