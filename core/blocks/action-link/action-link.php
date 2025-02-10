<?php

/**
 * Block Template: Action Link.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$action_link = get_field('action_link');

// ID for anchor.
$id = null;
if( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// CSS Classes.
$parent_class_name = 'action-link';
$child_class_name = '';
// Get class value
if( !empty($block['className'] ) ) {
	
	// If "|" pipe character is found, split string
	if( false !== strpos($block['className'], '|') ) {
		
		$className = explode('|', $block['className']);
		$parent_class_name .= ' ' . $className[0];
		$child_class_name = $className[1];
		
	}else{
		
		$parent_class_name .= ' ' . $block['className'];
		
	}

}

// If action link, add Google event tracker.
if( $action_link ) {
	
	$slug = wp_basename($action_link['url']);
	$track_event = hap_get_ga_event_tracker('Action-Link', 'click', $slug);

}

// If is external link, add attributes.
$target_link = null;
if( $action_link && '_blank' === $action_link['target'] ) {
	$target_link = 'target="' . esc_attr($action_link['target']) . '" rel="noopener noreferrer nofollow"';
}

// Link style.
$link_style = '';
if( get_field('link_style') == 'button' ) {	
	$link_style = get_field('link_style') .' ' . get_field('button_mode') . ' ' . get_field('button_appearance') . ' ' . get_field('button_width');
}

// Get action link markup.
$link  = null;
if( $action_link ) {
	
	$link = hap_get_action_link([
		'url'					=> esc_url( $action_link['url'] ),
		'target'				=> $target_link,
		'button'				=> esc_attr($link_style . ' ' . $child_class_name),
		'icon'					=> get_field('icon'),
		'icon_css_classes'		=> esc_attr(get_field('icon_css_classes')),
		'flex_direction'		=> get_field('flex_direction'),
		'top_title'				=> get_field('top_title'),
		'top_title_css_classes'	=> esc_attr(get_field('top_title_css_classes')),
		'title'					=> esc_html($action_link['title']),
		'title_css_classes'		=> esc_attr(get_field('title_css_classes')),
		'sub_title'				=> esc_html(get_field('sub_title')),
		'sub_title_css_classes'	=> esc_attr(get_field('sub_title_css_classes')),
	]);
}

?>

<?php if( $is_preview ) : ?>

	<div class="hap-wp-block"><!-- Start preview -->
		
		<div class="hap-wp-block-info"><!-- Start preview header -->

			<div class="hap-wp-block-info-left">

				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'action-link', null, 'block-core' ); ?>
				</figure>

				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>

			</div>

		</div><!-- End preview header -->
		
		<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($parent_class_name); ?>">

			<?php echo $link; ?>

		</div>
		
	</div><!-- End preview -->
		
<?php else : ?>
				
	<div <?php if($id) { echo 'id="' . esc_attr($id) . '"';} ?> class="<?php echo esc_attr($parent_class_name); ?>">

		<?php echo $link; ?>
		
	</div>
		
<?php endif; ?>