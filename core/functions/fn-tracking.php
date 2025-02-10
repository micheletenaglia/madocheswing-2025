<?php

/**
 * Action link button (Google).
 *
 * @param array $args
 * @return string $html
 */
function hap_get_action_link( $args = [] ) {
	
	extract(shortcode_atts([
		'url'					=> '',
		'target'				=> '',
		'button'				=> 'button',
		'icon'					=> '',
		'icon_css_classes'		=> '',
		'flex_direction'		=> '',
		'top_title'				=> '',
		'top_title_css_classes'	=> '',
		'title'					=> '',
		'title_css_classes'		=> '',
		'sub_title'				=> '',
		'sub_title_css_classes'	=> '',
	], $args));

	// Icon
	$icon_src = '';
	if( $icon ) {
		$icon_name = get_file_name( $icon['filename'] );
		$icon_src = get_svg_icon( $icon_name, $icon_css_classes, 'uploads' );
	}

	// Text alignment
	$text_align = '';
	if( $icon && $flex_direction == 'flex-row-reverse' ) {
		$text_align = 'text-right';
	}elseif( $icon && $flex_direction == 'flex-row') {
		$text_align = 'text-left';
	}

	// Create slug and event tracker
	$slug = wp_basename($url);
	// !!! Temporarily disabled, waiting for GA4 updates.
	// $track_event = hap_get_ga_event_tracker('Action-Link', 'click', $slug);
	$track_event = null;
	
	// Start output
	$html = '';

	// Anchor
	$html .= '<a class="action-link ' . esc_attr( $button . ' ' . $flex_direction) . '" href="' . esc_url($url) . '" ' . $target . ' ' . $track_event . '>';

		// Icon
		$html .= $icon_src;

		// Text
		$html .= '<div class="' . esc_attr('action-link-content ' . $text_align) . '">';

			if( $top_title ) {
				$html .= '<span class="action-link-top-title ' . esc_attr($top_title_css_classes) . '">';
					$html .= $top_title;
				$html .= '</span>';
			}

			if( $title ) {
				$html .= '<span class="action-link-title ' . esc_attr($title_css_classes) . '">';
					$html .= $title;
				$html .= '</span>';
			}

			if( $sub_title ) {
				$html .= '<span class="action-link-sub-title ' . esc_attr($sub_title_css_classes) . '">';
					$html .= $sub_title;
				$html .= '</span>';
			}

		$html .= '</div>';

	$html .= '</a>';

	return $html;
	
}

/**
 * Easily track Google Analytics events.
 *
 * @param string $event_category
 * @param string $event_action
 * @param string $event_label
 * @return string
 */
function hap_get_ga_event_tracker( $event_category = 'Action-Link', $event_action = 'click', $event_label = '' ) {
	
	if( get_field('google_analytics_id','options') ) {
		
		return 'onclick="gtag(\'event\', \'' . $event_action . '\', {\'event_category\': \'' . $event_category . '\', \'event_label\': \'' . $event_label . '\'});"';
	
	}else{
		
		return;
	
	}

}