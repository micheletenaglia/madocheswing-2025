<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

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

// Version (dark or light)
$version = get_field('logo_version');

// With or without link
$logo_link = get_field('logo_link');

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('logo',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php echo mkt_get_logo($class_name,$version); ?>
		</div>
	</div>
<?php else :
	// Frontend
	if( $logo_link == 'link') : ?>
		<a aria-label="<?php _e('Homepage','mklang'); ?>" href="<?php echo get_home_url(); ?>"><?php echo mkt_get_logo($class_name,$version); ?></a>
	<?php else :
		echo mkt_get_logo($class_name,$version);
	endif;
endif;