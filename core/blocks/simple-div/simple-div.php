<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Simple Div.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$toggle = get_field('toggle');
$semantic_tag = ( get_field('semantic_tag') ) ? get_field('semantic_tag') : 'div';
$bg_preview = get_field('toggle_bg_preview');
$toggle_class = ( $toggle ) ? 'mkcb-disabled' : null;
$bg_image = get_field('bg_image');
$vertically_justified = ( get_field('vertically_justified') ) ? 'vertical-justified' : null;

// Semantic tag index
$semantic_tag_index = [
	'div' => [
		'tag'	=>	'div',
		'label'	=>	__('A simple DIV.','mklang'),
	],
	'main' => [
		'tag'	=>	'main',
		'label'	=>	__('The main content (can only be used once per page).','mklang'),
	],
	'aside' => [
		'tag'	=>	'div',
		'label'	=>	__('Related content.','mklang'),
	],
	'article' => [
		'tag'	=>	'article',
		'label'	=>	__('Article.','mklang'),
	],
	'section' => [
		'tag'	=>	'section',
		'label'	=>	__('Section.','mklang'),
	],
	'header' => [
		'tag'	=>	'header',
		'label'	=>	__('Header.','mklang'),
	],
	'footer' => [
		'tag'	=>	'footer',
		'label'	=>	__('Footer.','mklang'),
	],
	'nav' => [
		'tag'	=>	'nav',
		'label'	=>	__('Navigation.','mklang'),
	],
	'address' => [
		'tag'	=>	'nav',
		'label'	=>	__('Address.','mklang'),
	],
	'ul' => [
		'tag'	=>	'ul',
		'label'	=>	__('Unordered list.','mklang'),
	],
	'ol' => [
		'tag'	=>	'ol',
		'label'	=>	__('Ordered list.','mklang'),
	],
	'li' => [
		'tag'	=>	'li',
		'label'	=>	__('List item.','mklang'),
	],
];

// CSS Classes.
$css_classes = [
	'toggle'				=>	$toggle_class,
	'col_span'				=>	get_field('col_span'),
	'vertically_justified'	=>	$vertically_justified,
	'padding'				=>	get_field('padding'),
	'padding_t'				=>	get_field('padding_t'),
	'padding_b'				=>	get_field('padding_b'),
	'padding_l'				=>	get_field('padding_l'),
	'padding_r'				=>	get_field('padding_r'),
	'margin'				=>	get_field('margin'),
	'margin_t'				=>	get_field('margin_t'),
	'margin_b'				=>	get_field('margin_b'),
	'margin_l'				=>	get_field('margin_l'),
	'margin_r'				=>	get_field('margin_r'),
	'bg_color'				=>	get_field('bg_color'),
	'text_color'			=>	get_field('text_color'),
	'paragraph'				=>	get_field('paragraph'),
	'height'				=>	get_field('height'),
	'min_height'			=>	get_field('min_height'),
	'bg_blend_mode'			=>	get_field('bg_blend_mode'),
	'mix_blend_mode'		=>	get_field('mix_blend_mode'),
];

// Responsive hero image
$img_mobile = null;
if( get_field('image_mobile') ) {
	$css_classes['mobile_hero'] = 'hero-mobile-img-wrap';
	$img_mobile_css = 'hero-mobile-img';
	if( get_field('image_mobile') ) {
		$img_mobile_css .= ' ' . get_field('image_mobile_css');
	}
	$img_mobile = wp_get_attachment_image( get_field('image_mobile'), 'medium', false, ['class'=>$img_mobile_css] );
}

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// CSS Classes.
$class_name = null;
$style = null;

// Style attributes.
$style = null;
if( $bg_image ) {
	$style = 'background-image: url(' . wp_get_attachment_url( $bg_image ) . ');';
	$css_classes['bg_classes'] = 'bg-cover bg-center';
}

// CSS Classes.
$class_name = implode( ' ', $css_classes );
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Custom attrs
$custom_attributes = null;
if( get_field('custom_attributes') ) {
	$custom_attributes = mkt_sanitize_attrs(get_field('custom_attributes'));
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<?php if( get_field('admin_label') ) : ?>
			<div class="" style="font-size: 1.5rem; font-weight: 600; padding: .25rem .5rem; border-bottom: 1px dotted rgba(0, 0, 0, 0.2);">
				<?php echo get_field('admin_label'); ?>
			</div>
		<?php endif; ?>
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('simple-div',null,'block-core'); ?>
				</figure>
				<div>
					<?php if( $semantic_tag ) : ?>
						<span class="mkcb-wp-block-title">
							<?php echo $semantic_tag_index[$semantic_tag]['tag']; ?>
							<?php if( get_field('admin_label') ) { echo ' / ' . get_field('admin_label'); } ?>
						</span>
						<span class="mkcb-wp-block-desc"><?php echo $semantic_tag_index[$semantic_tag]['label']; ?></span>
					<?php else : ?>
						<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
						<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
					<?php endif; ?>
				</div>
			</div>
			<?php if( $bg_image && !$bg_preview ) : ?>
				<div class="mkcb-wp-block-info-right">
					<div class="mkcb-wp-block-bg-preview">
						<?php echo wp_get_attachment_image( $bg_image, 'thumbnail' ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="mkcb-wp-block-content">
			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>" style="<?php echo ( $bg_preview ) ? esc_attr($style) : null; ?>">
				<InnerBlocks />
			</div>
		</div>
	</div>
<?php else :
	// Frontend
	if( !$toggle ) : ?>
		<<?php echo esc_html($semantic_tag); ?> <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>" style="<?php echo esc_attr($style); ?>" <?php echo $custom_attributes; ?>>
			<?php if( get_field('image_mobile_position') == 'top' ) {
				echo $img_mobile; 
			} ?>
			<InnerBlocks />
			<?php if( get_field('image_mobile_position') == 'bottom' ) {
				echo $img_mobile; 
			} ?>
		</<?php echo esc_html($semantic_tag); ?>>
	<?php endif;
endif;