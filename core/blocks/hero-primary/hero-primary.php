<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Hero Primary.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields
$text_color = get_field('hero_primary_text_color');
$bg_image = get_field('hero_primary_bg_image');
$toggle = get_field('hero_primary_toggle');
$title = get_field('hero_primary_title');
$sub_title = get_field('hero_primary_subtitle');

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// CSS Classes.
$class_name = 'mkcf-block hero-primary';
if( $text_color ) { 
	$class_name .= ' ' . $text_color;
}
if( $toggle ) { 
	$class_name .= ' mkcf-disabled';
}
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Style attribute.
$style = null;
if( $bg_image ) {
	$style = 'background-image: url(' . wp_get_attachment_url( $bg_image ) . ');';
}

// Filter.
$filter = get_field('hero_primary_filter');

// Restrict allowed blocks
// https://github.com/WordPress/WordPress/tree/master/wp-includes/blocks
$allowed_blocks = [
	'core/heading',
	'core/image', 
	'core/paragraph',
	'core/list',
	'core/list-item', 
	'core/html', 
	'acf/simple-button', 
	'acf/modal-form-cf7',
];

// Template.
$template = array(
	array('core/heading', array(
		'level'		=> 2,
		'content'	=> __('Title goes here','mklang'),
	)),
    array('core/paragraph', array(
        'content'	=> __('Content goes here','mklang'),
    ))
);

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('hero-primary',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>" style="<?php echo esc_attr($style); ?>">
				<div class="hero-primary-content">
					<div>
						<h1><span class="hero-primary-title"><?php echo esc_html($title); ?></span> <?php if( $sub_title ) : ?><span class="hero-primary-subtitle"><?php echo esc_html($sub_title); ?></span><?php endif; ?></h1>
						<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
					</div>
				</div>
				<div class="hero-primary-filter"></div>
			</div>
		</div>
	</div>
<?php else :
	// Frontend
	if( !$toggle ) : ?>
		<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>" style="<?php echo esc_attr($style); ?>">
			<div class="hero-primary-content">
				<div>
					<?php if( $title ) : ?>
						<h1><span class="hero-primary-title"><?php echo esc_html($title); ?></span><?php if( $sub_title ) : ?><span class="hero-primary-subtitle"><?php echo $sub_title; ?></span><?php endif; ?></h1>
					<?php endif; ?>
					<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
				</div>
			</div>
			<div class="hero-primary-filter"></div>
			<?php if( $filter && $filter != 'default' ) : ?>
				<?php get_template_part('project/templates/block/hero-primary/' . $filter); ?>
			<?php endif; ?>
		</div>
	<?php endif;
endif;