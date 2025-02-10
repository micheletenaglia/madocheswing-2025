<?php

/**
 * Block Template: Container.
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
$toggle_grid_preview = get_field('toggle_grid_preview');
$toggle_class = ( $toggle ) ? 'hap-disabled' : null;
$bg_image = get_field('bg_image');

// Semantic tag index
$semantic_tag_index = [
	'div' => [
		'tag'	=>	'div',
		'label'	=>	__('A simple DIV.','hap'),
	],
	'main' => [
		'tag'	=>	'main',
		'label'	=>	__('The main content (can only be used once per page).','hap'),
	],
	'aside' => [
		'tag'	=>	'div',
		'label'	=>	__('Related content.','hap'),
	],
	'article' => [
		'tag'	=>	'article',
		'label'	=>	__('Article.','hap'),
	],
	'section' => [
		'tag'	=>	'section',
		'label'	=>	__('Section.','hap'),
	],
	'header' => [
		'tag'	=>	'header',
		'label'	=>	__('Header.','hap'),
	],
	'footer' => [
		'tag'	=>	'footer',
		'label'	=>	__('Footer.','hap'),
	],
	'nav' => [
		'tag'	=>	'nav',
		'label'	=>	__('Navigation.','hap'),
	],
	'address' => [
		'tag'	=>	'nav',
		'label'	=>	__('Address.','hap'),
	],
	'ul' => [
		'tag'	=>	'ul',
		'label'	=>	__('Unordered list.','hap'),
	],
	'ol' => [
		'tag'	=>	'ol',
		'label'	=>	__('Ordered list.','hap'),
	],
	'li' => [
		'tag'	=>	'li',
		'label'	=>	__('List item.','hap'),
	],
];

// CSS Classes.
$css_classes = [
	'toggle'		=>	$toggle_class,
	'display'		=>	get_field('display'),
	'container'		=>	get_field('container'),
	'padding'		=>	get_field('padding'),
	'padding_t'		=>	get_field('padding_t'),
	'padding_b'		=>	get_field('padding_b'),
	'padding_l'		=>	get_field('padding_l'),
	'padding_r'		=>	get_field('padding_r'),
	'margin'		=>	get_field('margin'),
	'margin_t'		=>	get_field('margin_t'),
	'margin_b'		=>	get_field('margin_b'),
	'margin_l'		=>	get_field('margin_l'),
	'margin_r'		=>	get_field('margin_r'),
	'bg_color'		=>	get_field('bg_color'),
	'text_color'	=>	get_field('text_color'),
	'paragraph'		=>	get_field('paragraph'),
	'height'		=>	get_field('height'),
	'min_height'	=>	get_field('min_height'),
	'bg_blend_mode'	=>	get_field('bg_blend_mode'),
	'mix_blend_mode'=>	get_field('mix_blend_mode'),
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

// CSS classes.
$class_name = 'container ';

// Style attribute.
$style = null;

// Background image.
if( $bg_image ) {
	$style = 'background-image: url(' . wp_get_attachment_url( $bg_image ) . ');';
	$css_classes['bg_classes'] = 'bg-cover bg-center';
}

// CSS classes.
if( $css_classes['display'] == 'flex' ) {
	$css_classes['justify_content'] = get_field('justify_content');
	$css_classes['align_items'] = get_field('align_items');
	$css_classes['flex_direction'] = get_field('flex_direction');
}elseif( $css_classes['display'] == 'grid' ) {
	$css_classes['justify_content'] = get_field('justify_content');
	$css_classes['align_items'] = get_field('align_items');
	$css_classes['grid'] = get_field('grid');
	$css_classes['gap'] = get_field('gap');
}
$class_name .= implode( ' ', $css_classes );
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// CSS classes preview.
$css_classes_preview = null;
if( $toggle_grid_preview ) {
	$css_classes_preview = $class_name;
}else{
	unset($css_classes['display']);
	unset($css_classes['grid']);
	$css_classes_preview = implode( ' ', $css_classes );
	if( !empty( $block['className'] ) ) { 
		$css_classes_preview .= ' ' . $block['className'];
	}	
}

// Custom attrs
$custom_attributes = null;
if( get_field('custom_attributes') ) {
	$custom_attributes = hap_sanitize_attrs(get_field('custom_attributes'));
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<?php if( get_field('admin_label') ) : ?>
			<div class="" style="font-size: 1.5rem; font-weight: 600; padding: .25rem .5rem; border-bottom: 1px dotted rgba(0, 0, 0, 0.2);">
				<?php echo get_field('admin_label'); ?>
			</div>
		<?php endif; ?>
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'container', null, 'block-core' ); ?>
				</figure>

				<div>
					<?php if( $semantic_tag ) : ?>
						<span class="hap-wp-block-title">
							<?php echo $semantic_tag_index[$semantic_tag]['tag']; ?>
							<?php if( get_field('admin_label') ) { echo ' / ' . get_field('admin_label'); } ?>
						</span>
						<span class="hap-wp-block-desc"><?php echo $semantic_tag_index[$semantic_tag]['label']; ?></span>
					<?php else : ?>
						<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
						<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
					<?php endif; ?>
				</div>

			</div>
			
			<?php if( $bg_image && !$bg_preview ) : ?>
			
				<div class="hap-wp-block-info-right">
					<div class="hap-wp-block-bg-preview">
						<?php echo wp_get_attachment_image( $bg_image, 'thumbnail' ); ?>
					</div>
				</div>
			
			<?php endif; ?>

		</div><!-- End preview header -->
		
		<div class="hap-wp-block-content"><!-- Start preview content -->

			<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($css_classes_preview); ?>" style="<?php echo ( $bg_preview ) ? esc_attr($style) : null; ?>">

				<InnerBlocks />

			</div>

		</div><!-- End preview content -->

	</div><!-- End preview -->
		
<?php else : ?>
		
	<?php if( !$toggle ) : ?>
		
		<<?php echo esc_html($semantic_tag); ?> <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($class_name); ?>" style="<?php echo esc_attr($style); ?>">
						
			<?php if( get_field('image_mobile_position') == 'top' ) {echo $img_mobile; } ?>

			<InnerBlocks />

			<?php if( get_field('image_mobile_position') == 'bottom' ) {echo $img_mobile; } ?>
			
		</<?php echo esc_html($semantic_tag); ?>>
		
	<?php endif; ?>
		
<?php endif; ?>