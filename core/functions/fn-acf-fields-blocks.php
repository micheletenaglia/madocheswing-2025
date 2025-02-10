<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Register core blocks ACF fields.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
  ____  _     ___   ____ _  __  _____ ___ _____ _     ____  ____  
 | __ )| |   / _ \ / ___| |/ / |  ___|_ _| ____| |   |  _ \/ ___| 
 |  _ \| |  | | | | |   | ' /  | |_   | ||  _| | |   | | | \___ \ 
 | |_) | |__| |_| | |___| . \  |  _|  | || |___| |___| |_| |___) |
 |____/|_____\___/ \____|_|\_\ |_|   |___|_____|_____|____/|____/ 

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Programmatically populate ACF select field named "menu_id" with available menus.
add_filter('acf/load_field/name=menu_id', 'hap_populate_acf_field_menu_id');

// Programmatically populate ACF select field named "post_type"
add_filter('acf/load_field/name=post_type', 'hap_populate_post_types');

/* Actions ----------------------------------------------------------------------------*/

// Register core blocks fields.
add_action('acf/init', 'hap_load_fields_blocks');

/* Functions --------------------------------------------------------------------------*/

/**
 * Register core blocks fields
 *
 * @return void
 */
function hap_load_fields_blocks() {
	
	// Container
	acf_add_local_field_group(array(
		'key'		=> 'group_6388fb9362f89',
		'title'		=> __('Container','hap'),
		'fields'	=> array(
			array(
				'key'				=> 'field_640627f23056f',
				'label'				=> __('Admin label','hap'),
				'name'				=> 'admin_label',
				'type'				=> 'text',
			),		
			array(
				'key'				=> 'field_63890beaf629b',
				'label'				=> __('Show/Hide','hap'),
				'name'				=> 'toggle',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('Hide','hap'),
				'ui_off_text'		=> __('Show','hap'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_638915164e5d6',
				'label'				=> 'Layout',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-layout',
					'id'	=> '',
				),
			),
			// Display
			array(
				'key'				=> 'field_63ab25282952a',
				'label'				=> __('Preview grid','hap'),
				'name'				=> 'toggle_grid_preview',
				'type'				=> 'true_false',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6389152d4e5d7',
							'operator'	=> '!=',
							'value'		=> 'block',
						),
					),
				),
				'ui_on_text'		=> __('On','hap'),
				'ui_off_text'		=> __('Off','hap'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_63b2ee2afc206',
				'label'				=> __('Semantic tag','hap'),
				'name'				=> 'semantic_tag',
				'type'				=> 'select',
				'choices'			=> hap_block_values('semantic_tag'),
				'default_value'		=> 'div',
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6389152d4e5d7',
				'label'				=> 'Display',
				'name'				=> 'display',
				'type'				=> 'select',
				'choices'			=> hap_block_values('display'),
				'default_value'		=> 'block',
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6400ab7e724c5',
				'label'				=> 'Flex direction',
				'name'				=> 'flex_direction',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6389152d4e5d7',
							'operator'	=> '==',
							'value'		=> 'flex',
						),
					),
				),
				'choices'			=> hap_block_values('flex_direction'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_638915c0e3436',
				'label'				=> 'Justify content',
				'name'				=> 'justify_content',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6389152d4e5d7',
							'operator'	=> '!=',
							'value'		=> 'block',
						),
					),
				),
				'choices'			=> hap_block_values('justify_content'),
				'return_format'		=> 'value',
				'allow_null'		=>	1
			),
			array(
				'key'				=> 'field_638917c08398a',
				'label'				=> 'Align items',
				'name'				=> 'align_items',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6389152d4e5d7',
							'operator'	=> '!=',
							'value'		=> 'block',
						),
					),
				),
				'choices'			=> hap_block_values('align_items'),
				'return_format'		=> 'value',
				'allow_null'		=>	1,
			),
			array(
				'key'				=> 'field_6389183d86357',
				'label'				=> 'Grid',
				'name'				=> 'grid',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6389152d4e5d7',
							'operator'	=> '==',
							'value'		=> 'grid',
						),
					),
				),
				'choices'			=> hap_block_values('grid'),
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_639b214395fb0',
				'label'				=> 'Gap',
				'name'				=> 'gap',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6389152d4e5d7',
							'operator'	=> '==',
							'value'		=> 'grid',
						),
					),
				),
				'choices'			=> hap_block_values('gap'),
				'return_format'		=> 'value',
				'allow_null'		=>	1
			),
			array(
				'key'				=> 'field_63890ff63887b',
				'label'				=> 'Max width',
				'name'				=> 'container',
				'type'				=> 'select',
				'choices'			=> hap_block_values('container'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6400ab4a724c3',
				'label'				=> 'Height',
				'name'				=> 'height',
				'type'				=> 'select',
				'choices'			=> hap_block_values('height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6400ab6d724c4',
				'label'				=> 'Min height',
				'name'				=> 'min_height',
				'type'				=> 'select',
				'choices'			=> hap_block_values('min_height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_638906eb50a1f',
				'label'				=> 'Padding',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-padding',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_63890018eb1ce',
				'label'				=> 'Padding',
				'name'				=> 'padding',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_18eb6001893ce',
				'label'				=> 'Padding top',
				'name'				=> 'padding_t',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_18893eb6001ce',
				'label'				=> 'Padding bottom',
				'name'				=> 'padding_b',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_0018eb63891ce',
				'label'				=> 'Padding left',
				'name'				=> 'padding_l',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_0018918eb63ce',
				'label'				=> 'Padding right',
				'name'				=> 'padding_r',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_r'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_748950a106ebf',
				'label'				=> 'Margin',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-margin',
					'id'	=> '',
				),
			),			
			array(
				'key'				=> 'field_638902d1100d3',
				'label'				=> 'Margin',
				'name'				=> 'margin',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_18eb3c600189e',
				'label'				=> 'Margin top',
				'name'				=> 'margin_t',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_29904fc7112df',
				'label'				=> 'Margin bottom',
				'name'				=> 'margin_b',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_0018eb74902df',
				'label'				=> 'Margin left',
				'name'				=> 'margin_l',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_00eb63ce18918',
				'label'				=> 'Margin right',
				'name'				=> 'margin_r',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_r'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			// Background
			array(
				'key'				=> 'field_6390640a2a55c',
				'label'				=> 'Background',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-background',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_639064282a55d',
				'label'				=> 'Background color',
				'name'				=> 'bg_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('bg_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6388fb93d099b',
				'label'				=> 'Background image',
				'name'				=> 'bg_image',
				'type'				=> 'image',
				'return_format'		=> 'id',
				'library'			=> 'all',
				'mime_types'		=> 'jpg,jpeg,png,svg',
				'preview_size'		=> 'thumbnail',
			),
			array(
				'key'				=> 'field_63ab1cc654bbe',
				'label'				=> __('Show background image preview','hap'),
				'name'				=> 'toggle_bg_preview',
				'type'				=> 'true_false',
				'default_value'		=> 1,
				'ui_on_text'		=> __('On','hap'),
				'ui_off_text'		=> __('Off','hap'),
				'ui'				=> 1,
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_6388fb93d099b',
							'operator'	=> '!=empty',
						),
					),
				),
			),
			array(
				'key'				=> 'field_6400ab8e724c6',
				'label'				=> 'Background blending mode',
				'name'				=> 'bg_blend_mode',
				'type'				=> 'select',
				'choices'			=> hap_block_values('bg_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),			
			array(
				'key'				=> 'field_6405c7f404ada',
				'label'				=> 'Mix blend mode',
				'name'				=> 'mix_blend_mode',
				'type'				=> 'select',
				'choices'			=> hap_block_values('mix_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),			
			// Typography
			array(
				'key'				=> 'field_63890a6d45d71',
				'label'				=> __('Typography','hap'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-typography',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_6389115ede45b',
				'label'				=> __('Paragraph','hap'),
				'name'				=> 'paragraph',
				'type'				=> 'select',
				'choices'			=> hap_block_values('paragraph'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63890a7b45d72',
				'label'				=> __('Text color','hap'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('text_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/container',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Simple div
	acf_add_local_field_group(array(
		'key'					=> 'group_639064dcf19a1',
		'title'					=> 'Simple div',
		'fields'				=> array(
			array(
				'key'				=> 'field_64d020f7b9912',
				'label'				=> __('Admin label','hap'),
				'name'				=> 'admin_label',
				'type'				=> 'text',
			),		
			array(
				'key'				=> 'field_639064dd00110',
				'label'				=> __('Show/Hide','hap'),
				'name'				=> 'toggle',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('Hide','hap'),
				'ui_off_text'		=> __('Show','hap'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_63b05e3aadb5d',
				'label'				=> 'Layout',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-layout',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_63b05e39adb5c',
				'label'				=> __('Semantic tag','hap'),
				'name'				=> 'semantic_tag',
				'type'				=> 'select',
				'choices'			=> hap_block_values('semantic_tag'),
				'default_value'		=> 'div',
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6405c36aa203d',
				'label'				=> 'Height',
				'name'				=> 'height',
				'type'				=> 'select',
				'choices'			=> hap_block_values('height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6405c36aa2079',
				'label'				=> 'Min height',
				'name'				=> 'min_height',
				'type'				=> 'select',
				'choices'			=> hap_block_values('min_height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63b05e38adb5a',
				'label'				=> 'Col span',
				'name'				=> 'col_span',
				'type'				=> 'select',
				'choices'			=> hap_block_values('col_span'),
				'default_value'		=> 'block',
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63b2fbaa244ea',
				'label'				=> __('Vertically justified','hap'),
				'name'				=> 'vertically_justified',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('On','hap'),
				'ui_off_text'		=> __('Off','hap'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_639064dd00122',
				'label'				=> 'Padding',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-padding',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_639064dd0012a',
				'label'				=> 'Padding',
				'name'				=> 'padding',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2025b6535',
				'label'				=> 'Padding top',
				'name'				=> 'padding_t',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_639b2033b653c',
				'label'				=> 'Padding bottom',
				'name'				=> 'padding_b',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2033b653b',
				'label'				=> 'Padding left',
				'name'				=> 'padding_l',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2032b653a',
				'label'				=> 'Padding right',
				'name'				=> 'padding_r',
				'type'				=> 'select',
				'choices'			=> hap_block_values('padding_r'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2032b6539',
				'label'				=> 'Margin',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-margin',
					'id'	=> '',
				),
			),			
			array(
				'key'				=> 'field_639064dd0012d',
				'label'				=> 'Margin',
				'name'				=> 'margin',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2031b6538',
				'label'				=> 'Margin top',
				'name'				=> 'margin_t',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_639b2031b6537',
				'label'				=> 'Margin bottom',
				'name'				=> 'margin_b',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2030b6536',
				'label'				=> 'Margin left',
				'name'				=> 'margin_l',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b213595fa8',
				'label'				=> 'Margin right',
				'name'				=> 'margin_r',
				'type'				=> 'select',
				'choices'			=> hap_block_values('margin_r'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639064dd0012f',
				'label'				=> 'Background',
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-background',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_639064dd00132',
				'label'				=> 'Background color',
				'name'				=> 'bg_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('bg_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639064dd00135',
				'label'				=> 'Background image',
				'name'				=> 'bg_image',
				'type'				=> 'image',
				'return_format'		=> 'id',
				'library'			=> 'all',
				'mime_types'		=> 'jpg,jpeg,png,svg',
				'preview_size'		=> 'thumbnail',
			),
			array(
				'key'				=> 'field_63b05e39adb5b',
				'label'				=> __('Show background image preview','hap'),
				'name'				=> 'toggle_bg_preview',
				'type'				=> 'true_false',
				'default_value'		=> 1,
				'ui_on_text'		=> __('On','hap'),
				'ui_off_text'		=> __('Off','hap'),
				'ui'				=> 1,
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_639064dd00135',
							'operator'	=> '!=empty',
						),
					),
				),
			),
			array(
				'key'				=> 'field_6441429ed281f',
				'label'				=> __('Image for mobile','hap'),
				'name'				=> 'image_mobile',
				'type'				=> 'image',
				'return_format'		=> 'id',
				'library'			=> 'all',
				'mime_types'		=> 'jpg,jpeg,png,svg',
				'preview_size'		=> 'medium',
			),
			array(
				'key'				=> 'field_644142e3d2820',
				'label'				=> __('Mobile layout image position','hap'),
				'name' 				=> 'image_mobile_position',
				'type'				=> 'button_group',
				'choices'			=> array(
					'top'		=> 'Top',
					'bottom'	=> 'Bottom',
				),
				'default_value'		=> 'top',
				'return_format'		=> 'value',
				'allow_null'		=> 0,
				'layout'			=> 'horizontal',
			),
			array(
				'key'				=> 'field_6441505d44002',
				'label'				=> __('Mobile layout image CSS classes','hap'),
				'name'				=> 'image_mobile_css',
				'type'				=> 'text',
			),
			array(
				'key'				=> 'field_6405c36aa20ec',
				'label'				=> 'Background blending mode',
				'name'				=> 'bg_blend_mode',
				'type'				=> 'select',
				'choices'			=> hap_block_values('bg_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6405c7fa04adb',
				'label'				=> 'Mix blend mode',
				'name'				=> 'mix_blend_mode',
				'type'				=> 'select',
				'choices'			=> hap_block_values('mix_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),			
			array(
				'key'				=> 'field_639064dd00138',
				'label'				=> __('Typography','hap'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-typography',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_639082721b71c',
				'label'				=> __('Paragraph','hap'),
				'name'				=> 'paragraph',
				'type'				=> 'select',
				'choices'			=> hap_block_values('paragraph'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639064dd0013a',
				'label'				=> __('Text color','hap'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('text_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/simple-div',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Hero primary
	acf_add_local_field_group(array(
		'key'					=> 'group_638df89e9c4e5',
		'title'					=> __('Hero primary','hap'),
		'fields'				=> array(
			array(
				'key'				=> 'field_638df89e9f7e0',
				'label'				=> 'Background image',
				'name'				=> 'hero_primary_bg_image',
				'type'				=> 'image',
				'return_format'		=> 'id',
				'library'			=> 'all',
				'mime_types'		=> 'jpg,jpeg,png,svg',
				'preview_size'		=> 'thumbnail',
			),
			array(
				'key'				=> 'field_638df89e9f7e5',
				'label'				=> __('Show/Hide','hap'),
				'name'				=> 'hero_primary_toggle',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('Hide','hap'),
				'ui_off_text'		=> __('Show','hap'),
				'ui' => 1,
			),
			array(
				'key'				=> 'field_638e05c397fc1',
				'label'				=> __('Titles','hap'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-title',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_638e05d297fc2',
				'label'				=> __('Title','hap'),
				'name'				=> 'hero_primary_title',
				'type'				=> 'text',
			),
			array(
				'key'				=> 'field_638e05e697fc3',
				'label'				=> __('Subtitle','hap'),
				'name'				=> 'hero_primary_subtitle',
				'type'				=> 'text',
			),
			array(
				'key'				=> 'field_638df89e9f817',
				'label'				=> __('Typography','hap'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-typography',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_638df89e9f81d',
				'label'				=> __('Text color','hap'),
				'name'				=> 'hero_primary_text_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('text_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_638df92f55ef7',
				'label'				=> __('Filter','hap'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-filter',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_638df93e55ef8',
				'label'				=> __('Filter','hap'),
				'name'				=> 'hero_primary_filter',
				'type'				=> 'select',
				'choices'			=> [
					'default'			=> __('Default','hap'),
					'custom-filter-1'	=> __('Custom filter','hap') . ' 1',
					'custom-filter-2'	=> __('Custom filter','hap') . ' 2',
					'custom-filter-3'	=> __('Custom filter','hap') . ' 3',
				],
				'return_format' 	=> 'value',
				
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/hero-primary',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Simple button 
	acf_add_local_field_group(array(
		'key'					=> 'group_639b08f1d2c23',
		'title'					=> __('Simple button','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639b08f1b6365',
				'label'			=> __('Link','hap'),
				'name'			=> 'button_link',
				'type'			=> 'link',
				'return_format'	=> 'array',
				'required'		=> 1,
			),
			array(
				'key'			=> 'field_639b091cb6366',
				'label'			=> __('Style','hap'),
				'name'			=> 'button_style',
				'type'			=> 'select',
				'choices'		=> hap_block_values('button_style'),
				'return_format' => 'value',
			),
			array(
				'key'			=> 'field_639b0946b6367',
				'label'			=> __('Size','hap'),
				'name'			=> 'button_size',
				'type'			=> 'select',
				'choices'		=> hap_block_values('button_size'),
				'return_format' => 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/simple-button',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Contact Form 7 Modal
	acf_add_local_field_group(array(
		'key'					=> 'group_63a5f2da4bb81',
		'title'					=> __('Contact Form 7 Modal','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63a5f2daa2bff',
				'label'			=> __('CF7 Form','hap'),
				'name'			=> 'cf7_form',
				'type'			=> 'post_object',
				'required'		=> 1,
				'post_type' 	=> array(
					0	=> 'wpcf7_contact_form',
				),
				'return_format'	=> 'id',
				'ui'			=> 1,
			),
			array(
				'key'			=> 'field_63a6299fac82c',
				'label'			=> __('Label','hap'),
				'name'			=> 'label',
				'type'			=> 'text',
				'instructions'	=> '',
				'required'		=> 1,
			),
			array(
				'key'				=> 'field_63d1589abe23e',
				'label'				=> __('Text color','hap'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('text_color'),
				'allow_null'		=> 1,
			),
			array(
				'key'			=> 'field_63a627efe7eb5',
				'label'			=> __('Appearance','hap'),
				'name'			=> 'appearance',
				'type'			=> 'select',
				'required'		=> 1,
				'choices'		=> array(
					'link'		=> __('Link','hap'),
					'button'	=> __('Button','hap'),
				),
				'default_value'	=> 'button',
				'return_format'	=> 'value',
			),
			array(
				'key'				=> 'field_63a62826e7eb6',
				'label'				=> __('Style','hap'),
				'name'				=> 'button_style',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_63a627efe7eb5',
							'operator'	=> '==',
							'value'		=> 'button',
						),
					),
				),
				'choices'			=> hap_block_values('button_style'),
				'default_value'		=> false,
				'return_format'		=> 'value',
			),	
			array(
				'key'				=> 'field_63a6295dc92a6',
				'label'				=> __('Size','hap'),
				'name'				=> 'button_size',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_63a627efe7eb5',
							'operator'	=> '==',
							'value'		=> 'button',
						),
					),
				),
				'choices'			=> hap_block_values('button_size'),
				'return_format' 	=> 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/modal-form-cf7',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Anchor with inner blocks
	acf_add_local_field_group(array(
		'key'					=> 'group_639dab41a20f5',
		'title'					=> __('Anchor element','hap'),
		'fields'				=> array(
			array(
				'key'		=> 'field_639dae4f948f2',
				'label'		=> __('Anchor','hap'),
				'type'		=> 'accordion',
				'wrapper'		=> array(
					'width'	=> '',
					'class'	=> 'accordion-anchor',
					'id'	=> '',
				),
			),
			array(
				'key'			=> 'field_639dab41656e9',
				'label'			=> __('Link','hap'),
				'name'			=> 'link',
				'type'			=> 'link',
				'return_format' => 'array',
			),
			array(
				'key'			=> 'field_639dac4f0969b',
				'label'			=> __('Display','hap'),
				'name'			=> 'display',
				'type'			=> 'select',
				'choices'		=> hap_block_values('display'),
				'return_format' => 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/anchor-content',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Svg icon
	acf_add_local_field_group(array(
		'key'					=> 'group_639b214095fae',
		'title'					=> __('Svg icon','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639b214195faf',
				'label'			=> __('Image','hap'),
				'name'			=> 'svg_img',
				'type'			=> 'image',
				'return_format'	=> 'id',
				'required'		=> 1,
				'mime_types'	=> 'svg',
				'preview_size'	=> 'thumbnail',				
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/svg-image',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Icon and text
	acf_add_local_field_group(array(
		'key'					=> 'group_639b213e95fab',
		'title'					=> __('Icon &amp; text','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639b213e95faa',
				'label'			=> __('Image','hap'),
				'name'			=> 'svg_img',
				'type'			=> 'image',
				'return_format'	=> 'id',
				'required'		=> 1,
				'mime_types'	=> 'svg',
				'preview_size'	=> 'thumbnail',				
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/icon-text',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Action link
	acf_add_local_field_group(array(
		'key' => 'group_638f01d7ad213',
		'title' => __('Action link','hap'),
		'fields' => array(
			array(
				'key' => 'field_638f3097fbe39',
				'label' => 'Action link',
				'name' => 'action_link',
				'type' => 'link',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
			),
			array(
				'key' => 'field_638f01d71d7b8',
				'label' => 'Link style',
				'name' => 'link_style',
				'type' => 'button_group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'button' => 'Button',
					'default' => 'Regular',
				),
				'default_value' => 'button',
				'return_format' => 'value',
				'allow_null' => 0,
				'layout' => 'horizontal',
			),
			array(
				'key' => 'field_638f020f28456',
				'label' => 'Appearance',
				'name' => 'button_appearance',
				'type' => 'button_group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_638f01d71d7b8',
							'operator' => '==',
							'value' => 'button',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'default' => 'Regular',
					'hollow' => 'Hollow',
				),
				'return_format' => 'value',
				'allow_null' => 0,
				'layout' => 'horizontal',
			),
			array(
				'key' => 'field_638f023828457',
				'label' => 'Button width',
				'name' => 'button_width',
				'type' => 'button_group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_638f01d71d7b8',
							'operator' => '==',
							'value' => 'button',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'w-auto' => 'Width auto',
					'w-full' => 'Full width',
				),
				'return_format' => 'value',
				'allow_null' => 0,
				'layout' => 'horizontal',
			),
			array(
				'key' => 'field_638f0281be04e',
				'label' => 'Icon & texts',
				'name' => '',
				'type' => 'accordion',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'open' => 0,
				'multi_expand' => 0,
				'endpoint' => 0,
			),
			array(
				'key' => 'field_638f02afbe04f',
				'label' => 'Top title',
				'name' => 'top_title',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f02c0be050',
				'label' => 'Top title CSS classes',
				'name' => 'top_title_css_classes',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f0448cbcc7',
				'label' => 'Title',
				'name' => 'title',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f045bcbcc8',
				'label' => 'Title CSS classes',
				'name' => 'title_css_classes',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f02ddbe051',
				'label' => 'Subtitle',
				'name' => 'sub_title',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f02e8be052',
				'label' => 'Subtitle CSS classes',
				'name' => 'sub_title_css_classes',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f0331be053',
				'label' => 'Icon',
				'name' => 'icon',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
				'preview_size' => 'thumbnail',
			),
			array(
				'key' => 'field_638f035abe054',
				'label' => 'Icon CSS classes',
				'name' => 'icon_css_classes',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_638f024728458',
				'label' => 'Icon position',
				'name' => 'flex_direction',
				'type' => 'button_group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => hap_block_values('flex_direction'),
				'default_value' => 'flex-row',
				'return_format' => 'value',
				'allow_null' => 0,
				'layout' => 'horizontal',
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/action-link',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Post selector
	acf_add_local_field_group(array(
		'key'					=> 'group_638e1c094bbd9',
		'title'					=> __('Post selector','hap'),
		'fields'				=> array(
			array(
				'key'				=> 'field_638e1c094e81b',
				'label'				=> __('Select posts','hap'),
				'name'				=> 'post_selector_posts',
				'type'				=> 'relationship',
				'filters'			=> array(
					0	=> 'search',
					1	=> 'post_type',
					2	=> 'taxonomy',
				),
				'return_format'		=> 'id',
			),
			array(
				'key'				=> 'field_638e1c094e822',
				'label'				=> __('Template name','hap'),
				'name'				=> 'post_selector_template',
				'type'				=> 'text',
				'placeholder'		=> __('Ex:','hap') . ' post/post-card',
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/post-selector',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// WP Menu
	acf_add_local_field_group(array(
		'key'					=> 'group_639880b098c78',
		'title'					=> __('WP Menu','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639880b1d6602',
				'label'			=> __('Menu','hap'),
				'name'			=> 'menu_id',
				'type'			=> 'select',
				'choices'		=> [],
				'return_format'	=> 'value',
			),
		),
		'location' 				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/menu-wp',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Banner 2 columns
	acf_add_local_field_group(array(
		'key'					=> 'group_6398604453ca8',
		'title'					=> __('Banner 2 columns','hap'),
		'fields'				=> array(
			array(
				'key'				=> 'field_63986044e8bbb',
				'label'				=> __('Text color','hap'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('text_color'),
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b13e4dd748',
				'label'				=> __('Shadow color','hap'),
				'name'				=> 'shadow_color',
				'type'				=> 'select',
				'choices'			=> array(
					'gray'		=> __('Gray','hap'),
					'accent'	=> __('Accent color','hap'),
					'primary'	=> __('Primary color','hap'),
					'secondary'	=> __('Secondary color','hap'),
				),
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6398609ce8bbc',
				'label'				=> __('Background color','hap'),
				'name'				=> 'bg_color',
				'type'				=> 'select',
				'choices'			=> hap_block_values('bg_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6398611fe8bbd',
				'label'				=> 'Background image',
				'name'				=> 'bg_image',
				'type'				=> 'image',
				'return_format'		=> 'id',
				'library'			=> 'all',
				'mime_types'		=> 'jpg,jpeg,png,svg',
				'preview_size'		=> 'thumbnail',
			),
		),
		'location'					=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/banner-col-2',
				),
			),
		),
		'menu_order'				=> 0,
		'position'					=> 'normal',
		'style'						=> 'default',
		'label_placement'			=> 'top',
		'instruction_placement'		=> 'label',
		'hide_on_screen'			=> '',
		'active'					=> true,
		'description'				=> '',
		'show_in_rest'				=> 0,
	));

	// Custom attributes (all blocks)
	acf_add_local_field_group(array(
		'key'				=> 'group_639ca26c74b9c',
		'title'				=> __('Custom attributes','hap'),
		'fields' => array(
			array(
				'key'			=> 'field_639ca2e849580',
				'label'			=> __('Custom attributes','hap'),
				'type'			=> 'accordion',
				'wrapper'		=> array(
					'width'	=> '',
					'class'	=> 'accordion-custom-attrs',
					'id'	=> '',
				),
			),
			array(
				'key'	=> 'field_639ca26c80910',
				'label'	=> __('Custom attributes','hap'),
				'name'	=> 'custom_attributes',
				'type'	=> 'textarea',
			),
		),
		'location'			=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'all',
				),
			),
		),
		'menu_order'			=> 99,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Simple span
	acf_add_local_field_group(array(
		'key'					=> 'group_63b3622018165',
		'title'					=> __('Simple span','hap'),
		'fields'				=> array(
			array(
				'key'		=> 'field_63b3fb3c28052',
				'label'		=> __('Span content','hap'),
				'name'		=> 'span_content',
				'type'		=> 'text',
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/simple-span',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Advanced list
	acf_add_local_field_group(array(
		'key'					=> 'group_63b3622018164',
		'title'					=> 'Lists',
		'fields'					=> array(
			array(
				'key'		=> 'field_63b362201de07',
				'label'		=> __('List style','hap'),
				'name'		=> 'list_style',
				'type'		=> 'select',
				'choices' => [
					'default'				=> __('Default list','hap'),
					'list'					=> __('Formatted list','hap'),
					'list-check'			=> __('Check list','hap'),
					'list-inline'			=> __('Inline list','hap'),
					'list-inline-hyphen'	=> __('Inline list (hyphen)','hap'),
					'list-inline-comma'		=> __('Inline list (comma)','hap'),
					'list-justified'		=> __('Justified list','hap'),
					'list-icon'				=> __('Icons list','hap'),
				],
				'default_value' => false,
				'return_format' => 'value',
			),
			array(
				'key'			=> 'field_63b3daf7606e9',
				'label'			=> __('List columns','hap'),
				'name'			=> 'list_columns',
				'type'			=> 'select',
				'choices'		=> array(
					'list-1-2-2'	=> 'S1 M2 L2',
					'list-1-2-3'	=> 'S1 M2 L3',
					'list-1-2-4'	=> 'S1 M2 L4',
					'list-1-3-6'	=> 'S1 M3 L6',
				),
				'allow_null'	=> 1,
			),
			array(
				'key'				=> 'field_63b3dc1d606ea',
				'label'				=> __('Columns gap','hap'),
				'name'				=> 'list_columns_gap',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_63b3daf7606e9',
							'operator'	=> '!=empty',
						),
					),
				),
				'choices'			=> [
					'list-gap-sm'	=> 'S',
					'list-gap-md'	=> 'M',
					'list-gap-lg'	=> 'L',
				],
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63b3dca8606ec',
				'label'				=> __('Columns separator','hap'),
				'name'				=> 'list_columns_separator',
				'type'				=> 'true_false',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_63b3daf7606e9',
							'operator'	=> '!=empty',
						),
					),
				),
				'ui_on_text'		=> __('On','hap'),
				'ui_off_text'		=> __('Off','hap'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_63b3dc64606eb',
				'label'				=> __('Columns separator style','hap'),
				'name'				=> 'list_columns_separator_style',
				'type'				=> 'select',
				'conditional_logic' => array(
					array(
						array(
							'field'		=> 'field_63b3dca8606ec',
							'operator'	=> '==',
							'value'		=> '1',
						),
					),
				),
				'choices'			=> [
					'list-style-solid'	=> 'Solid',
					'list-style-dashed'	=> 'Dashed',
					'list-style-dotted'	=> 'Dotted',
				],
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63b3dcfe606ed',
				'label'				=> __('Columns separator color','hap'),
				'name'				=> 'list_columns_separator_color',
				'type'				=> 'select',
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_63b3dca8606ec',
							'operator'	=> '==',
							'value'		=> '1',
						),
					),
				),
				'choices' => array(
					'list-color-border'		=> __('Default','hap'),
					'list-color-primary'	=> __('Primary color','hap'),
				),
				'allow_null'		=> 1,
			),
		),
		'location'					=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/advanced-list',
				),
			),
		),
		'menu_order'				=> 0,
		'position'					=> 'normal',
		'style'						=> 'default',
		'label_placement'			=> 'top',
		'instruction_placement'		=> 'label',
		'hide_on_screen'			=> '',
		'active'					=> true,
		'description'				=> '',
		'show_in_rest'				=> 0,
	));
	
	// Description list item
	acf_add_local_field_group(array(
		'key'						=> 'group_63b45254a8eef',
		'title'						=> __('Description list item','hap'),
		'fields'					=> array(
			array(
				'key'		=> 'field_63b4525449081',
				'label'		=> __('Title','hap'),
				'name'		=> 'dt',
				'type'		=> 'text',
				'required'	=> 1,
			),
			array(
				'key'		=> 'field_63b4526949082',
				'label'		=> __('Description','hap'),
				'name'		=> 'dd',
				'type'		=> 'text',
				'required'	=> 1,
			),
		),
		'location'			=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/description-list-item',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Tab
	acf_add_local_field_group(array(
		'key'					=> 'group_63b41e05390d9',
		'title'					=> __('Tab','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63b41e05ce96f',
				'label'			=> __('Order','hap'),
				'name'			=> 'order',
				'type'			=> 'select',
				'choices' => [
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
					7 => '7',
					8 => '8',
				],
				'default_value'	=> 1,
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/tabs-item',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Tabs
	acf_add_local_field_group(array(
		'key'					=> 'group_63b415ba93692',
		'title'					=> __('Tabs','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63b415ba1ff7a',
				'label'			=> __('Tab titles','hap'),
				'name'			=> 'tab_titles',
				'type'			=> 'repeater',
				'required'		=> 1,
				'layout'		=> 'block',
				'collapsed'		=> 'field_63b41f6c4074a',
				'button_label'	=> 'Add title',
				'rows_per_page'	=> 20,
				'sub_fields'	=> array(
					array(
						'key'				=> 'field_63b41f6c4074a',
						'label'				=> __('Title','hap'),
						'name'				=> 'title',
						'type'				=> 'text',
						'required'			=> 1,
						'parent_repeater'	=> 'field_63b415ba1ff7a',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/tabs',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Accordion item
	acf_add_local_field_group( array(
		'key'					=> 'group_64bbce8ae8d54',
		'title'					=> __('Accordion item','hap'),
		'fields'				=> array(
			array(
				'key'				=> 'field_64bbce8b80919',
				'label'			=> __('Title','hap'),
				'name'			=> 'title',
				'type'			=> 'text',
				'required'		=> 1,
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/accordion-item',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Table of contents
	acf_add_local_field_group(array(
		'key'					=> 'group_63bc3cc68f88e',
		'title'					=> __('Table of contents','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63bc3cc6241f3',
				'label'			=> __('List type','hap'),
				'name'			=> 'list_type',
				'type'			=> 'select',
				'instructions'	=> __('Select the type of list and then click on the "Refresh Index" button. All h2 tags will be mapped to create the table of contents. In the modal click on the "Copy" button and then paste the html code into the block. Remember to check the links on the frontend as sometimes they may not match the anchors.','hap'),
				'choices'		=> [
					'ol'	=> __('Ordered list','hap'),
					'ul'	=> __('Unordered list','hap'),
				],
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/toc',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Logo
	acf_add_local_field_group(array(
		'key'					=> 'group_63f45c9626c6b',
		'title'					=> 'Logo',
		'fields'				=> array(
			array(
				'key'			=> 'field_63f48280ff5b6',
				'label'			=> __('Version','hap'),
				'name'			=> 'logo_version',
				'type'			=> 'select',
				'choices'		=> array(
					'light'	=> __('Light background','hap'),
					'dark'	=> __('Dark background','hap'),
				),
				'return_format'	=> 'value',
			),
			array(
				'key'			=> 'field_63f482bbff5b7',
				'label'			=> __('Link','hap'),
				'name'			=> 'logo_link',
				'type'			=> 'select',
				'choices'		=> array(
					'link'		=> __('With link (homepage)','hap'),
					'no_link'	=> __('Without link','hap'),
				),
				'return_format'	=> 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/logo',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));	
	
	// Get template
	acf_add_local_field_group(array(
		'key'					=> 'group_63f8b119cb279',
		'title'					=> __('Get template','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63f8b11ad97b0',
				'label'			=> __('Template path','hap'),
				'name'			=> 'template',
				'type'			=> 'text',
				'required'		=> 1,
				'placeholder'	=> 'example-directory/example-file',
			),
		),
		'location'			=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/get-template',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Hero video
	acf_add_local_field_group(array(
		'key'					=> 'group_63ed0ff3287c3',
		'title'					=> __('Hero video','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63ed0ff3339a1',
				'label'			=> __('Video','hap'),
				'name'			=> 'video',
				'type'			=> 'file',
				'required'		=> 1,
				'return_format'	=> 'url',
				'library'		=> 'all',
				'max_size'		=> '',
				'mime_types'	=> 'mp4',
			),
			array(
				'key'			=> 'field_640d8dd51fc38',
				'label'			=> __('Poster','hap'),
				'name'			=> 'poster',
				'type'			=> 'image',
				'required'		=> 1,
				'return_format'	=> 'id',
				'library'		=> 'all',
				'mime_types'	=> 'jpg,png,svg',
				'preview_size'	=> 'medium',
			),
			array(
				'key'			=> 'field_640ed97c60836',
				'label'			=> __('Video controls','hap'),
				'name'			=> 'video_controls',
				'type'			=> 'checkbox',
				'choices'		=> array(
					'autoplay'		=> 'Autoplay',
					'controls'		=> 'Controls',
					'loop'			=> 'Loop',
					'muted'			=> 'Muted',
				),
				'default_value' => array(
					0	=> 'autoplay',
					1	=> 'loop',
					2	=> 'muted',
				),
				'return_format'		=> 'value',
				'allow_custom'		=> 0,
				'layout'			=> 'vertical',
				'toggle'			=> 1,
				'save_custom'		=> 0,
				'custom_choice_button_text'	=> '',
			),
			array(
				'key'			=> 'field_640ee066781bd',
				'label'			=> __('Filter classes','hap'),
				'name'			=> 'filter_classes',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_640ee2cba4cbf',
				'label'			=> __('Play on scroll','hap'),
				'name'			=> 'play_on_scroll',
				'type'			=> 'true_false',
				'default_value'	=> 0,
				'ui'			=> 1,
				'ui_on_text'	=> __('On','hap'),
				'ui_off_text'	=> __('Off','hap'),
			),		
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/hero-video',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Bar chart
	acf_add_local_field_group(array(
		'key'					=> 'group_63f5cde857a04',
		'title'					=> __('Bar chart','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63f5cde8cbc77',
				'label'			=> __('Value','hap'),
				'name'			=> 'chart_value',
				'type'			=> 'number',
				'required'		=> 1,
				'max' => 100,
			),
			array(
				'key'			=> 'field_63f5cfc01bdd6',
				'label'			=> __('Label','hap'),
				'name'			=> 'chart_label',
				'type'			=> 'text',
				'required'		=> 1,
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/bar-chart',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Pie chart
	acf_add_local_field_group(array(
		'key'					=> 'group_63f5e02e415d2',
		'title'					=> __('Pie chart','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_6408edf59d43d',
				'label'			=> __('Title','hap'),
				'name'			=> 'title',
				'type'			=> 'text',
			),
			/*array(
				'key'			=> 'field_6408f1e6c7878',
				'label'			=> __('Center color','hap'),
				'name'			=> 'circle_color',
				'type'			=> 'color_picker',
				'return_format'	=> 'string',
			),*/
			array(
				'key'			=> 'field_63f5e02e67668',
				'label'			=> __('Values','hap'),
				'name'			=> 'chart_values',
				'type'			=> 'repeater',
				'instructions'	=> __('The sum of the values must be 100. If no color is set, the default colors will be used.','hap'),
				'required'		=> 1,
				'layout'		=> 'block',
				'min'			=> 2,
				'collapsed'		=> 'field_63f5e04567669',
				'button_label'	=> __('Add value','hap'),
				'rows_per_page'	=> 20,
				'sub_fields'	=> array(
					array(
						'key'				=> 'field_63f5e04567669',
						'label'				=> __('Value','hap'),
						'name'				=> 'value',
						'type'				=> 'number',
						'required'			=> 1,
						'min'				=> '0.01',
						'max'				=> '99.99',
						'append'			=> '%',
						'parent_repeater' => 'field_63f5e02e67668',
					),
					array(
						'key'				=> 'field_63f5e0886766a',
						'label'				=> __('Label','hap'),
						'name'				=> 'label',
						'type'				=> 'text',
						'required'			=> 1,
						'parent_repeater'	=> 'field_63f5e02e67668',
					),
					array(
						'key'				=> 'field_63f5e0b36766b',
						'label'				=> __('Color','hap'),
						'name'				=> 'color',
						'type'				=> 'color_picker',
						'enable_opacity'	=> 0,
						'return_format'		=> 'string',
						'parent_repeater'	=> 'field_63f5e02e67668',
					),
				),
			),
			array(
				'key'			=> 'field_63f5e288f7b81',
				'label'			=> __('Size','hap'),
				'name'			=> 'chart_size',
				'type'			=> 'number',
				'default_value'	=> 200,
				'min'			=> 120,
				'step'			=> 1,
				'append'		=> 'px',
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'	=> 'acf/pie-chart',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Photoswipe gallery
	acf_add_local_field_group( array(
		'key'					=> 'group_64c3849a755e1',
		'title'					=> __('Photoswipe gallery','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_64c3849aee9b0',
				'label'			=> __('Images','hap'),
				'name'			=> 'images',
				'type'			=> 'gallery',
				'required'		=> 1,
				'return_format'	=> 'array',
				'library'		=> 'all',
				'min'			=> 1,
				'max'			=> '',
				'min_width'		=> '',
				'min_height'	=> '',
				'min_size'		=> '',
				'max_width'		=> '',
				'max_height'	=> '',
				'max_size'		=> '',
				'mime_types'	=> 'jpg,jpeg,png,svg',
				'insert'		=> 'append',
				'preview_size'	=> 'medium',
			),
			array(
				'key'			=> 'field_64c38514ee9b1',
				'label'			=> __('Preview image size','hap'),
				'name'			=> 'preview_image_size',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_64c398c496236',
				'label'			=> __('Full image size','hap'),
				'name'			=> 'full_image_size',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_64c398e496237',
				'label'			=> __('Card template','hap'),
				'name'			=> 'card_template',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_64c39ce1e5c40',
				'label'			=> __('Remove wrapper','hap'),
				'name'			=> 'remove_wrapper',
				'type'			=> 'true_false',
				'instructions'	=> __('Add the class "hap-gallery" to the new wrapper if you remove the default wrapper element.','hap'),
				'default_value'	=> 0,
				'ui_on_text'	=> __('On','hap'),
				'ui_off_text'	=> __('Off','hap'),
				'ui'			=> 1,
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/photoswipe-gallery',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));	
	
	// Query
	acf_add_local_field_group( array(
		'key'					=> 'group_640c5dca37241',
		'title'					=> 'Query',
		'fields'				=> array(
			array(
				'key'			=> 'field_640c5e365857a',
				'label'			=> 'Template',
				'name'			=> 'query_template',
				'type'			=> 'text',
				'required'		=> 1,
				'default_value'	=> 'post/post-card',
			),
			array(
				'key'			=> 'field_640c5dca4a663',
				'label'			=> 'Post type',
				'name'			=> 'post_type',
				'type'			=> 'checkbox',
				'required'		=> 1,
				'choices'		=> hap_block_values('post_types'),
				'default_value'	=> array(
					0	=> 'post',
				),
				'return_format'	=> 'value',
				'allow_custom'	=> 1,
				'save_custom'	=> 1,
				'layout'		=> 'vertical',
				'toggle'		=> 0,
				'custom_choice_button_text'	=> __('Add new post type','hap'),
			),
			array(
				'key'			=> 'field_640c64a1a898e',
				'label'			=> __('Number','hap'),
				'name'			=> 'posts_per_page',
				'type'			=> 'number',
				'required'		=> 1,
				'default_value'	=> 12,
				'min'			=> -1,
				'max'			=> '',
				'step'			=> 1,
				'append'		=> __('Posts','hap'),
			),
			array(
				'key'			=> 'field_640c5dca4a6a0',
				'label'			=> __('Order','hap'),
				'name'			=> 'order',
				'type'			=> 'select',
				'choices'		=> array(
					'DESC'	=> __('Descending','hap'),
					'ASC'	=> __('Ascending','hap'),
				),
				'default_value'	=> false,
				'return_format'	=> 'value',
				'multiple'		=> 0,
				'allow_null'	=> 0,
				'ui'			=> 0,
				'ajax'			=> 0,
			),
			array(
				'key'			=> 'field_640c5dca4a6da',
				'label'			=> __('Order by','hap'),
				'name'			=> 'orderby',
				'type'			=> 'select',
				'choices' => array(
					'date'				=> __('Date','hap'),
					'title'				=> __('Title','hap'),
					'type'				=> __('Post type','hap'),
					'parent'			=> __('Parent post','hap'),
					'rand'				=> __('Random','hap'),
					'menu_order'		=> __('Menu order','hap'),
					'meta_value'		=> __('Meta value','hap'),
					'meta_value_num'	=> __('Meta value number','hap'),
				),
				'default_value'	=> false,
				'return_format'	=> 'value',
				'multiple'		=> 0,
				'allow_null'	=> 0,
				'ui'			=> 0,
				'ajax'			=> 0,
			),
			array(
				'key'			=> 'field_640c5dca4a6f0',
				'label'			=> 'Meta key',
				'name'			=> 'meta_key',
				'type'			=> 'text',
				'required'		=> 1,
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_640c5dca4a6da',
							'operator'	=> '==',
							'value'		=> 'meta_value',
						),
					),
					array(
						array(
							'field'		=> 'field_640c5dca4a6da',
							'operator'	=> '==',
							'value'		=> 'meta_value_num',
						),
					),
				),
			),
            array(
                'key'           => 'field_65f7423d673b7',
                'label'         => __('Taxonomy','hap'),
                'name'          => 'taxonomy',
                'type'          => 'text',
            ),
            array(
                'key'           => 'field_65f7428c673b8',
                'label'         => __('Term slug','hap'),
                'name'          => 'term',
                'type'          => 'text',
            ),
		),
		'location'			=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/query',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));
	
	// Icon link
	acf_add_local_field_group( array(
		'key'					=> 'group_64c79ce9aeaa8',
		'title'					=> __('Icon link','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_64c79ce9d456d',
				'label'			=> 'Link',
				'name'			=> 'link',
				'type'			=> 'link',
				'required'		=> 1,
				'return_format'	=> 'array',
			),
			array(
				'key'			=> 'field_64c79cf4d456e',
				'label'			=> __('Icon (only SVG)','hap'),
				'name'			=> 'icon',
				'type'			=> 'image',
				'return_format'	=> 'id',
				'library'		=> 'all',
				'min_width'		=> '',
				'min_height'	=> '',
				'min_size'		=> '',
				'max_width'		=> '',
				'max_height'	=> '',
				'max_size'		=> '',
				'mime_types'	=> 'svg',
				'preview_size'	=> 'medium',
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/link-with-icon',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

	// Map
	acf_add_local_field_group( array(
		'key'					=> 'group_640b8b3c1a602',
		'title'					=> __('Map','hap'),
		'fields'				=> array(
			array(
				'key'			=> 'field_640b8f3471b54',
				'label'			=> __('Post selection','hap'),
				'name'			=> 'post_selection',
				'type'			=> 'select',
				'choices'		=> array(
					'post_type'	=> 'Post type',
					'posts'		=> 'Posts',
				),
				'default_value'	=> false,
				'return_format'	=> 'value',
				'multiple'		=> 0,
				'allow_null'	=> 0,
				'ui'			=> 0,
				'ajax'			=> 0,
			),
			array(
				'key'			=> 'field_640b8efebadfe',
				'label'			=> __('Posts','hap'),
				'name'			=> 'posts',
				'type'			=> 'relationship',
				'required'		=> 1,
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_640b8f3471b54',
							'operator'	=> '==',
							'value'		=> 'posts',
						),
					),
				),
				'post_type'		=> '',
				'taxonomy'		=> '',
				'filters'		=> array(
					0	=> 'search',
					1	=> 'post_type',
					2	=> 'taxonomy',
				),
				'return_format'	=> 'id',
				'min'			=> '',
				'max'			=> '',
				'elements'		=> '',
			),
			array(
				'key'			=> 'field_640b8b3caaaff',
				'label'			=> __('Post type','hap'),
				'name'			=> 'post_type',
				'type'			=> 'checkbox',
				'required'		=> 1,
				'conditional_logic'	=> array(
					array(
						array(
							'field'		=> 'field_640b8f3471b54',
							'operator'	=> '==',
							'value'		=> 'post_type',
						),
					),
				),
				'choices'		=> [], // This populated by a filter
				'default_value'	=> [],
				'return_format'	=> 'value',
				'allow_custom'	=> 1,
				'save_custom'	=> 0,
				'layout'		=> 'vertical',
				'toggle'		=> 0,
				'custom_choice_button_text'	=> __('Add new post type','hap'),
			),
		),
		'location'				=> array(
			array(
				array(
					'param'		=> 'block',
					'operator'	=> '==',
					'value'		=> 'acf/map',
				),
			),
		),
		'menu_order'			=> 0,
		'position'				=> 'normal',
		'style'					=> 'default',
		'label_placement'		=> 'top',
		'instruction_placement'	=> 'label',
		'hide_on_screen'		=> '',
		'active'				=> true,
		'description'			=> '',
		'show_in_rest'			=> 0,
	));

    // Social links
    acf_add_local_field_group( array(
        'key'                   => 'group_6640528f23d26',
        'title'                 => __('Social links','hap'),
        'fields' => array(
            array(
                'key'           => 'field_6640528f283e4',
                'label'         => __('Social links','hap'),
                'name'          => 'social_links',
                'type'          => 'checkbox',
                'required'      => 1,
                'relevanssi_exclude'    => 1,
                'choices'       => array(
                    'facebook'      => 'Facebook',
                    'instagram'     => 'Instagram',
                    'twitter'       => 'X (Twitter)',
                    'youtube'       => 'Youtube',
                    'vimeo'         => 'Vimeo',
                    'linkedin'      => 'Linkedin',
                    'tiktok'        => 'Tiktok',
                    'spotify'       => 'Spotify',
                    'pinterest'     => 'Pinterest',
                    'google_maps'   => 'Google Maps',
                    'mailchimp'     => 'Newsletter',
                    'whatsapp'      => 'Whatsapp',
                    'telegram'      => 'Telegram',
                    'signal'        => 'Signal',
                ),
                'return_format' => 'value',
                'layout'        => 'vertical',
            ),
            array(
                'key'           => 'field_6640555c3de08',
                'label'         => __('Display options','hap'),
                'name'          => 'display_options',
                'type'          => 'select',
                'required'      => 1,
                'relevanssi_exclude'    => 1,
                'choices'       => array(
                    'show' => __('Show icon','hap'),
                    'hide' => __('Show label','hap'),
                    'both' => __('Show icon and label','hap'),
                ),
                'return_format' => 'value',
            ),
            array(
                'key'           => 'field_664056f076b39',
                'label'         => __('Icon classes','hap'),
                'name'          => 'icon_classes',
                'type'          => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'     => 'field_6640555c3de08',
                            'operator'  => '!=',
                            'value'     => 'hide',
                        ),
                    ),
                ),
                'relevanssi_exclude'    => 1,
            ),
            array(
                'key'           => 'field_6640571276b3a',
                'label'         => __('Link classes','hap'),
                'name'          => 'a_classes',
                'type'          => 'text',
                'conditional_logic'     => array(
                    array(
                        array(
                            'field'     => 'field_6640555c3de08',
                            'operator'  => '!=',
                            'value'     => 'icon',
                        ),
                    ),
                ),
                'relevanssi_exclude'    => 1,
            ),
            array(
                'key'           => 'field_6640574d17a15',
                'label'         => __('Wrapper','hap'),
                'name'          => 'wrapper',
                'type'          => 'select',
                'relevanssi_exclude'    => 1,
                'choices' => array(
                    'ul'    => __('Unordered list','hap'),
                    'none'  => __('None','hap'),
                ),
                'return_format' => 'value',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'block',
                    'operator'  => '==',
                    'value'     => 'acf/social-links',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));

    // Custom image
    acf_add_local_field_group( array(
        'key'                   => 'group_665998cb00be3',
        'title'                 => __('Custom image','hap'),
        'fields'                => array(
            array(
                'key'           => 'field_665998cb96291',
                'label'         => __('Image','hap'),
                'name'          => 'image_id',
                'type'          => 'image',
                'required'      => 1,
                'return_format' => 'id',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg,png,gif,webp,avif',
                'preview_size'  => 'medium',
            ),
            array(
                'key'           => 'field_66599d3d90a4e',
                'label'         => __('Size','hap'),
                'name'          => 'size',
                'type'          => 'select',
                'required'      => 1,
                'choices'       => array(
                    'thumbnail'     => __('Thumbnail','hap'),
                    'medium'        => __('Medium','hap'),
                    'medium_large'  => __('Medium large','hap'),
                    'large'         => __('Large','hap'),
                    'full-hd-thumb' => 'Full HD (1920x1280)',
                    'full'          => __('Full','hap'),
                    'post-thumbnail'=> __('Original','hap'),
                ),
                'default_value' => 'original',
                'return_format' => 'value',
            ),
            array(
                'key'           => 'field_66599a0f6e72b',
                'label'         => __('Above the fold','hap'),
                'name'          => 'priority',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui_on_text'    => 'On',
                'ui_off_text'   => 'Off',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_6659b0219435d',
                'label'         => __('Preload','hap'),
                'type'          => 'message',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'     => 'field_66599a0f6e72b',
                            'operator'  => '==',
                            'value'     => '1',
                        ),
                    ),
                ),
                'message'       => __('If this is the main Above the Fold image, you may want to preload it.','hap'),
            ),
            array(
                'key'           => 'field_66599be777c46',
                'label'         => __('Figure tag','hap'),
                'name'          => 'figure',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui_on_text'    => 'On',
                'ui_off_text'   => 'Off',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_66599b646e72c',
                'label'         => __('Figure class','hap'),
                'name'          => 'fig_class',
                'type'          => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'     => 'field_66599be777c46',
                            'operator'  => '==',
                            'value'     => '1',
                        ),
                    ),
                ),
            ),
            array(
                'key'           => 'field_66599b8b6e72d',
                'label'         => __('Figure caption','hap'),
                'name'          => 'fig_caption',
                'type'          => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'     => 'field_66599be777c46',
                            'operator'  => '==',
                            'value'     => '1',
                        ),
                    ),
                ),
            ),
            array(
                'key'           => 'field_6659a0580916c',
                'label'         => __('Style','hap'),
                'name'          => 'style',
                'type'          => 'text',
            ),
            array(
                'key'           => 'field_6659a0729a513',
                'label'         => __('Background image','hap'),
                'name'          => 'bg_image',
                'type'          => 'image',
                'return_format' => 'id',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg,png,gif,webp,avif',
                'preview_size'  => 'medium',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'block',
                    'operator'  => '==',
                    'value'     => 'acf/hap-image',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));

    // Company data and footer links
    acf_add_local_field_group( array(
        'key'                   => 'group_663e5314af88e',
        'title'                 => __('Company data and footer links','hap'),
        'fields'                => array(
            array(
                'key'       => 'field_663e5314839c4',
                'label'     => __('Company data and footer links','hap'),
                'name'      => 'company_data_footer_links',
                'type'      => 'flexible_content',
                'required'  => 1,
                'relevanssi_exclude'    => 1,
                'layouts'   => array(
                    'layout_663e536e839c5' => array(
                        'key'       => 'layout_663e536e839c5',
                        'name'      => 'privacy',
                        'label'     => __('Privacy','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'           => 'field_663e8c332de4f',
                                'label'         => __('Info','hap'),
                                'type'          => 'message',
                                'relevanssi_exclude' => 1,
                                'message'       => __('Add a link to the privacy policy page (set on the options page).','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e5329d857a' => array(
                        'key'       => 'layout_663e5329d857a',
                        'name'      => 'cookie',
                        'label'     => 'Cookie',
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'           => 'field_663e8cc92de50',
                                'label'         => __('Info','hap'),
                                'type'          => 'message',
                                'relevanssi_exclude' => 1,
                                'message'       => __('Add a link to the cookie policy page (set on the options page).','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e5379839c7' => array(
                        'key'       => 'layout_663e5379839c7',
                        'name'      => 'cookie_preferences',
                        'label'     => __('Cookie Preferences','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'           => 'field_663e8d202de51',
                                'label'         => __('Info','hap'),
                                'type'          => 'message',
                                'relevanssi_exclude' => 1,
                                'message'       => __('Add a link to cookie tracking preferences (only if you are using Iubenda).','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e53fb839cf' => array(
                        'key'       => 'layout_663e53fb839cf',
                        'name'      => 'terms_and_conditions',
                        'label'     => __('Terms and Conditions','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'           => 'field_663e8d332de52',
                                'label'         => __('Terms and Conditions','hap'),
                                'name'          => 'terms_and_conditions_page',
                                'type'          => 'post_object',
                                'required'      => 1,
                                'relevanssi_exclude' => 1,
                                'post_type'     => array(
                                    0 => 'page',
                                ),
                                'post_status'   => array(
                                    0 => 'publish',
                                ),
                                'return_format' => 'id',
                                'ui'            => 1,
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e5387839c9' => array(
                        'key'       => 'layout_663e5387839c9',
                        'name'      => 'copyright',
                        'label'     => 'Copyright',
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e8da22de53',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the copyright notice. Ex: ©2020/2024, Company name. All rights reserved.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e5da32783e' => array(
                        'key'       => 'layout_663e5da32783e',
                        'name'      => 'vat_number',
                        'label'     => __('VAT Number','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e8e282de54',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company VAT number.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663f2b3488dcb' => array(
                        'key'       => 'layout_663f2b3488dcb',
                        'name'      => 'cf_number',
                        'label'     => __('Fiscal Code','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663f2b3488dcc',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company fiscal code.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e5396839cd' => array(
                        'key'       => 'layout_663e5396839cd',
                        'name'      => 'whistleblowing',
                        'label'     => 'Whistleblowing',
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e8e382de55',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add a link with class "whistleblowing" to be used to display the whistleblowing modal. Whistleblowing compliance is mandatory only for companies with at least 50 employees.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_6641ea1f9351d' => array(
                        'key'       => 'layout_6641ea1f9351d',
                        'name'      => 'google_recaptcha',
                        'label'     => 'Google reCAPTCHA',
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_6641e9ae9351c',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add Google reCAPTCHA links.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e5392839cb' => array(
                        'key'       => 'layout_663e5392839cb',
                        'name'      => 'credits',
                        'label'     => __('Credits','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e8ebc2de56',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the Tenaglia Studio credit and link. Ex: Design & code by Tenaglia Studio.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e936da47d4' => array(
                        'key'       => 'layout_663e936da47d4',
                        'name'      => 'phone',
                        'label'     => __('Phone','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e9384a47d6',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company phone number.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e939ba47d8' => array(
                        'key'       => 'layout_663e939ba47d8',
                        'name'      => 'mobile_phone',
                        'label'     => __('Mobile phone','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e939ba47d9',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company mobile phone number.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e93b8a47da' => array(
                        'key'       => 'layout_663e93b8a47da',
                        'name'      => 'toll_free_phone',
                        'label'     => __('Toll free phone','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e93b8a47db',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company toll free phone number.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e93dfa47dc' => array(
                        'key'       => 'layout_663e93dfa47dc',
                        'name'      => 'email',
                        'label'     => 'Email',
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e93dfa47dd',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company email.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e946831854' => array(
                        'key'       => 'layout_663e946831854',
                        'name'      => 'pec_email',
                        'label'     => __('PEC Email','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e946831855',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company PEC email.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e608de2039' => array(
                        'key'       => 'layout_663e608de2039',
                        'name'      => 'company_name',
                        'label'     => __('Company Name','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e916e89dc2',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company name.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_66412b88f2c9c' => array(
                        'key'       => 'layout_66412b88f2c9c',
                        'name'      => 'business_name',
                        'label'     => __('Business Name','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_66412b7ef2c9b',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the business name.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e60a3e203b' => array(
                        'key'       => 'layout_663e60a3e203b',
                        'name'      => 'registered_office',
                        'label'     => __('Registered office','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e922189dc3',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company registered office address.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e60b8e203f' => array(
                        'key'       => 'layout_663e60b8e203f',
                        'name'      => 'rea_number',
                        'label'     => __('REA Number','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e923989dc4',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company REA number.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e92a6a47cf' => array(
                        'key'       => 'layout_663e92a6a47cf',
                        'name'      => 'legal_representative',
                        'label'     => __('Legal Representative','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e92b4a47d1',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company legal representative name.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e92cba47d2' => array(
                        'key'       => 'layout_663e92cba47d2',
                        'name'      => 'share_capital',
                        'label'     => __('Share Capital','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e92cba47d3',
                                'label'     => 'Info',
                                'type'      => 'message',
                                'relevanssi_exclude' => 1,
                                'message'   => __('Add the company share capital.','hap'),
                            ),
                        ),
                        'max'       => '1',
                    ),
                    'layout_663e60e6e2041' => array(
                        'key'       => 'layout_663e60e6e2041',
                        'name'      => 'custom_item',
                        'label'     => __('Custom Item','hap'),
                        'display'   => 'block',
                        'sub_fields'=> array(
                            array(
                                'key'       => 'field_663e60fee2043',
                                'label'     => __('Label','hap'),
                                'name'      => 'label',
                                'type'      => 'text',
                                'required'  => 1,
                                'relevanssi_exclude' => 1,
                            ),
                            array(
                                'key'       => 'field_663e610ce2044',
                                'label'     => 'URL',
                                'name'      => 'url',
                                'type'      => 'url',
                                'relevanssi_exclude' => 1,
                            ),
                            array(
                                'key'       => 'field_663e6114e2045',
                                'label'     => __('Open in a new tab','hap'),
                                'name'      => 'target_blank',
                                'type'      => 'true_false',
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field'     => 'field_663e610ce2044',
                                            'operator'  => '!=empty',
                                        ),
                                    ),
                                ),
                                'relevanssi_exclude' => 1,
                                'ui_on_text'    => __('On','project'),
                                'ui_off_text'   => __('Off','project'),
                                'ui'            => 1,
                            ),
                            array(
                                'key'           => 'field_663e6135e2046',
                                'label'         => __('CSS Classes','hap'),
                                'name'          => 'css_class',
                                'type'          => 'text',
                                'relevanssi_exclude' => 1,
                            ),
                        ),
                    ),
                ),
                'button_label' => __('Add item','hap'),
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'block',
                    'operator'  => '==',
                    'value'     => 'acf/company-data',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));    
	
}

/**
 * Programmatically populate ACF select field named "menu_id"
 * with available menus.
 * 
 * @param array $field
 * @return array $field
 */
function hap_populate_acf_field_menu_id( $field ) {
    
    // Reset choices
    $field['choices'] = [];
    
    // Get available menus
    $choices = wp_get_nav_menus();
    
    // Loop through array and add to field 'choices'
    if( $choices ) {
        
        foreach( $choices as $menu ) {
            
            $field['choices'][ $menu->term_id ] = $menu->name;
            
        }
        
    }
    
    // Return the field
    return $field;
    
}

/**
 * Programmatically populate ACF select field named "post_type"
 * with available public post types.
 * 
 * @param array $field
 * @return array $field
 */
function hap_populate_post_types( $field ) {
	
	// Args to get the custom post types
	$cpt_args = [
		'public'                =>  true,
		'publicly_queryable'    => true,
	];

	// Args to get the "page" post type which would otherwise be excluded
	$page_args = [
		'name' => 'page',
	];

	// Get the custom post type list (array of objects)
	$cpts = get_post_types($cpt_args,'objects');

	// Get the "page" post type (array of objects)
	$pages = get_post_types( $page_args, 'objects' );

	// Merge arrays
	$cpts = array_merge( $cpts, $pages );

	// Exclude media (attachemnts)
	unset( $cpts['attachment'] );

	// Sort array by key
	ksort( $cpts );	
	
    foreach ( $cpts as $post_type ) {
    
		$field['choices'][$post_type->name] = $post_type->label;
    
	}

    // Return the field
    return $field;
	
}