<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Register core blocks ACF fields.
 *
 */

/**
 * Register core blocks fields.
 * This function is called in core/functions/fn-acf-fields-theme.php mktFieldsTheme::fields.
 */
function mkt_load_fields_blocks() : void {
	// Bail out early
	if( !function_exists('acf_add_local_field_group') ) {
		return;
	}
	// Container
	acf_add_local_field_group(array(
		'key'		=> 'group_6388fb9362f89',
		'title'		=> __('Container','mklang'),
		'fields'	=> array(
			array(
				'key'				=> 'field_640627f23056f',
				'label'				=> __('Admin label','mklang'),
				'name'				=> 'admin_label',
				'type'				=> 'text',
			),		
			array(
				'key'				=> 'field_63890beaf629b',
				'label'				=> __('Show/Hide','mklang'),
				'name'				=> 'toggle',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('Hide','mklang'),
				'ui_off_text'		=> __('Show','mklang'),
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
				'label'				=> __('Preview grid','mklang'),
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
				'ui_on_text'		=> __('On','mklang'),
				'ui_off_text'		=> __('Off','mklang'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_63b2ee2afc206',
				'label'				=> __('Semantic tag','mklang'),
				'name'				=> 'semantic_tag',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('semantic_tag'),
				'default_value'		=> 'div',
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6389152d4e5d7',
				'label'				=> 'Display',
				'name'				=> 'display',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('display'),
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
				'choices'			=> mkt_block_values('flex_direction'),
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
				'choices'			=> mkt_block_values('justify_content'),
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
				'choices'			=> mkt_block_values('align_items'),
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
				'choices'			=> mkt_block_values('grid'),
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
				'choices'			=> mkt_block_values('gap'),
				'return_format'		=> 'value',
				'allow_null'		=>	1
			),
			array(
				'key'				=> 'field_63890ff63887b',
				'label'				=> 'Max width',
				'name'				=> 'container',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('container'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6400ab4a724c3',
				'label'				=> 'Height',
				'name'				=> 'height',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6400ab6d724c4',
				'label'				=> 'Min height',
				'name'				=> 'min_height',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('min_height'),
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
				'choices'			=> mkt_block_values('padding'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_18eb6001893ce',
				'label'				=> 'Padding top',
				'name'				=> 'padding_t',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_18893eb6001ce',
				'label'				=> 'Padding bottom',
				'name'				=> 'padding_b',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_0018eb63891ce',
				'label'				=> 'Padding left',
				'name'				=> 'padding_l',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_0018918eb63ce',
				'label'				=> 'Padding right',
				'name'				=> 'padding_r',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_r'),
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
				'choices'			=> mkt_block_values('margin'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_18eb3c600189e',
				'label'				=> 'Margin top',
				'name'				=> 'margin_t',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_29904fc7112df',
				'label'				=> 'Margin bottom',
				'name'				=> 'margin_b',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_0018eb74902df',
				'label'				=> 'Margin left',
				'name'				=> 'margin_l',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_00eb63ce18918',
				'label'				=> 'Margin right',
				'name'				=> 'margin_r',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_r'),
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
				'choices'			=> mkt_block_values('bg_color'),
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
				'label'				=> __('Show background image preview','mklang'),
				'name'				=> 'toggle_bg_preview',
				'type'				=> 'true_false',
				'default_value'		=> 1,
				'ui_on_text'		=> __('On','mklang'),
				'ui_off_text'		=> __('Off','mklang'),
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
				'choices'			=> mkt_block_values('bg_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),			
			array(
				'key'				=> 'field_6405c7f404ada',
				'label'				=> 'Mix blend mode',
				'name'				=> 'mix_blend_mode',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('mix_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),			
			// Typography
			array(
				'key'				=> 'field_63890a6d45d71',
				'label'				=> __('Typography','mklang'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-typography',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_6389115ede45b',
				'label'				=> __('Paragraph','mklang'),
				'name'				=> 'paragraph',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('paragraph'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63890a7b45d72',
				'label'				=> __('Text color','mklang'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('text_color'),
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
				'label'				=> __('Admin label','mklang'),
				'name'				=> 'admin_label',
				'type'				=> 'text',
			),		
			array(
				'key'				=> 'field_639064dd00110',
				'label'				=> __('Show/Hide','mklang'),
				'name'				=> 'toggle',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('Hide','mklang'),
				'ui_off_text'		=> __('Show','mklang'),
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
				'label'				=> __('Semantic tag','mklang'),
				'name'				=> 'semantic_tag',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('semantic_tag'),
				'default_value'		=> 'div',
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6405c36aa203d',
				'label'				=> 'Height',
				'name'				=> 'height',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6405c36aa2079',
				'label'				=> 'Min height',
				'name'				=> 'min_height',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('min_height'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63b05e38adb5a',
				'label'				=> 'Col span',
				'name'				=> 'col_span',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('col_span'),
				'default_value'		=> 'block',
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_63b2fbaa244ea',
				'label'				=> __('Vertically justified','mklang'),
				'name'				=> 'vertically_justified',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('On','mklang'),
				'ui_off_text'		=> __('Off','mklang'),
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
				'choices'			=> mkt_block_values('padding'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2025b6535',
				'label'				=> 'Padding top',
				'name'				=> 'padding_t',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_639b2033b653c',
				'label'				=> 'Padding bottom',
				'name'				=> 'padding_b',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2033b653b',
				'label'				=> 'Padding left',
				'name'				=> 'padding_l',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2032b653a',
				'label'				=> 'Padding right',
				'name'				=> 'padding_r',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('padding_r'),
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
				'choices'			=> mkt_block_values('margin'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2031b6538',
				'label'				=> 'Margin top',
				'name'				=> 'margin_t',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_t'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),		
			array(
				'key'				=> 'field_639b2031b6537',
				'label'				=> 'Margin bottom',
				'name'				=> 'margin_b',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_b'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b2030b6536',
				'label'				=> 'Margin left',
				'name'				=> 'margin_l',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_l'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b213595fa8',
				'label'				=> 'Margin right',
				'name'				=> 'margin_r',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('margin_r'),
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
				'choices'			=> mkt_block_values('bg_color'),
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
				'label'				=> __('Show background image preview','mklang'),
				'name'				=> 'toggle_bg_preview',
				'type'				=> 'true_false',
				'default_value'		=> 1,
				'ui_on_text'		=> __('On','mklang'),
				'ui_off_text'		=> __('Off','mklang'),
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
				'label'				=> __('Image for mobile','mklang'),
				'name'				=> 'image_mobile',
				'type'				=> 'image',
				'return_format'		=> 'id',
				'library'			=> 'all',
				'mime_types'		=> 'jpg,jpeg,png,svg',
				'preview_size'		=> 'medium',
			),
			array(
				'key'				=> 'field_644142e3d2820',
				'label'				=> __('Mobile layout image position','mklang'),
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
				'label'				=> __('Mobile layout image CSS classes','mklang'),
				'name'				=> 'image_mobile_css',
				'type'				=> 'text',
			),
			array(
				'key'				=> 'field_6405c36aa20ec',
				'label'				=> 'Background blending mode',
				'name'				=> 'bg_blend_mode',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('bg_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_6405c7fa04adb',
				'label'				=> 'Mix blend mode',
				'name'				=> 'mix_blend_mode',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('mix_blend_mode'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),			
			array(
				'key'				=> 'field_639064dd00138',
				'label'				=> __('Typography','mklang'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-typography',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_639082721b71c',
				'label'				=> __('Paragraph','mklang'),
				'name'				=> 'paragraph',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('paragraph'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639064dd0013a',
				'label'				=> __('Text color','mklang'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('text_color'),
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
		'title'					=> __('Hero primary','mklang'),
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
				'label'				=> __('Show/Hide','mklang'),
				'name'				=> 'hero_primary_toggle',
				'type'				=> 'true_false',
				'ui_on_text'		=> __('Hide','mklang'),
				'ui_off_text'		=> __('Show','mklang'),
				'ui' => 1,
			),
			array(
				'key'				=> 'field_638e05c397fc1',
				'label'				=> __('Titles','mklang'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-title',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_638e05d297fc2',
				'label'				=> __('Title','mklang'),
				'name'				=> 'hero_primary_title',
				'type'				=> 'text',
			),
			array(
				'key'				=> 'field_638e05e697fc3',
				'label'				=> __('Subtitle','mklang'),
				'name'				=> 'hero_primary_subtitle',
				'type'				=> 'text',
			),
			array(
				'key'				=> 'field_638df89e9f817',
				'label'				=> __('Typography','mklang'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-typography',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_638df89e9f81d',
				'label'				=> __('Text color','mklang'),
				'name'				=> 'hero_primary_text_color',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('text_color'),
				'return_format'		=> 'value',
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_638df92f55ef7',
				'label'				=> __('Filter','mklang'),
				'type'				=> 'accordion',
				'wrapper'			=> array(
					'width'	=> '',
					'class'	=> 'accordion-filter',
					'id'	=> '',
				),
			),
			array(
				'key'				=> 'field_638df93e55ef8',
				'label'				=> __('Filter','mklang'),
				'name'				=> 'hero_primary_filter',
				'type'				=> 'select',
				'choices'			=> [
					'default'			=> __('Default','mklang'),
					'custom-filter-1'	=> __('Custom filter','mklang') . ' 1',
					'custom-filter-2'	=> __('Custom filter','mklang') . ' 2',
					'custom-filter-3'	=> __('Custom filter','mklang') . ' 3',
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
		'title'					=> __('Simple button','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639b08f1b6365',
				'label'			=> __('Link','mklang'),
				'name'			=> 'button_link',
				'type'			=> 'link',
				'return_format'	=> 'array',
				'required'		=> 1,
			),
			array(
				'key'			=> 'field_639b091cb6366',
				'label'			=> __('Style','mklang'),
				'name'			=> 'button_style',
				'type'			=> 'select',
				'choices'		=> mkt_block_values('button_style'),
				'return_format' => 'value',
			),
			array(
				'key'			=> 'field_639b0946b6367',
				'label'			=> __('Size','mklang'),
				'name'			=> 'button_size',
				'type'			=> 'select',
				'choices'		=> mkt_block_values('button_size'),
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
		'title'					=> __('Contact Form 7 Modal','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63a5f2daa2bff',
				'label'			=> __('CF7 Form','mklang'),
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
				'label'			=> __('Label','mklang'),
				'name'			=> 'label',
				'type'			=> 'text',
				'instructions'	=> '',
				'required'		=> 1,
			),
			array(
				'key'				=> 'field_63d1589abe23e',
				'label'				=> __('Text color','mklang'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('text_color'),
				'allow_null'		=> 1,
			),
			array(
				'key'			=> 'field_63a627efe7eb5',
				'label'			=> __('Appearance','mklang'),
				'name'			=> 'appearance',
				'type'			=> 'select',
				'required'		=> 1,
				'choices'		=> array(
					'link'		=> __('Link','mklang'),
					'button'	=> __('Button','mklang'),
				),
				'default_value'	=> 'button',
				'return_format'	=> 'value',
			),
			array(
				'key'				=> 'field_63a62826e7eb6',
				'label'				=> __('Style','mklang'),
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
				'choices'			=> mkt_block_values('button_style'),
				'default_value'		=> false,
				'return_format'		=> 'value',
			),	
			array(
				'key'				=> 'field_63a6295dc92a6',
				'label'				=> __('Size','mklang'),
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
				'choices'			=> mkt_block_values('button_size'),
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
		'title'					=> __('Anchor element','mklang'),
		'fields'				=> array(
			array(
				'key'		=> 'field_639dae4f948f2',
				'label'		=> __('Anchor','mklang'),
				'type'		=> 'accordion',
				'wrapper'		=> array(
					'width'	=> '',
					'class'	=> 'accordion-anchor',
					'id'	=> '',
				),
			),
			array(
				'key'			=> 'field_639dab41656e9',
				'label'			=> __('Link','mklang'),
				'name'			=> 'link',
				'type'			=> 'link',
				'return_format' => 'array',
			),
			array(
				'key'			=> 'field_639dac4f0969b',
				'label'			=> __('Display','mklang'),
				'name'			=> 'display',
				'type'			=> 'select',
				'choices'		=> mkt_block_values('display'),
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
		'title'					=> __('Svg icon','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639b214195faf',
				'label'			=> __('Image','mklang'),
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
		'title'					=> __('Icon &amp; text','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639b213e95faa',
				'label'			=> __('Image','mklang'),
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
		
	// Post selector
	acf_add_local_field_group(array(
		'key'					=> 'group_638e1c094bbd9',
		'title'					=> __('Post selector','mklang'),
		'fields'				=> array(
			array(
				'key'				=> 'field_638e1c094e81b',
				'label'				=> __('Select posts','mklang'),
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
				'label'				=> __('Template name','mklang'),
				'name'				=> 'post_selector_template',
				'type'				=> 'text',
				'placeholder'		=> __('Ex:','mklang') . ' post/post-card',
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
		'title'					=> __('WP Menu','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_639880b1d6602',
				'label'			=> __('Menu','mklang'),
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
		'title'					=> __('Banner 2 columns','mklang'),
		'fields'				=> array(
			array(
				'key'				=> 'field_63986044e8bbb',
				'label'				=> __('Text color','mklang'),
				'name'				=> 'text_color',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('text_color'),
				'allow_null'		=> 1,
			),
			array(
				'key'				=> 'field_639b13e4dd748',
				'label'				=> __('Shadow color','mklang'),
				'name'				=> 'shadow_color',
				'type'				=> 'select',
				'choices'			=> array(
					'gray'		=> __('Gray','mklang'),
					'accent'	=> __('Accent color','mklang'),
					'primary'	=> __('Primary color','mklang'),
					'secondary'	=> __('Secondary color','mklang'),
				),
				'return_format'		=> 'value',
			),
			array(
				'key'				=> 'field_6398609ce8bbc',
				'label'				=> __('Background color','mklang'),
				'name'				=> 'bg_color',
				'type'				=> 'select',
				'choices'			=> mkt_block_values('bg_color'),
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
		'title'				=> __('Custom attributes','mklang'),
		'fields' => array(
			array(
				'key'			=> 'field_639ca2e849580',
				'label'			=> __('Custom attributes','mklang'),
				'type'			=> 'accordion',
				'wrapper'		=> array(
					'width'	=> '',
					'class'	=> 'accordion-custom-attrs',
					'id'	=> '',
				),
			),
			array(
				'key'	=> 'field_639ca26c80910',
				'label'	=> __('Custom attributes','mklang'),
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
		'title'					=> __('Simple span','mklang'),
		'fields'				=> array(
			array(
				'key'		=> 'field_63b3fb3c28052',
				'label'		=> __('Span content','mklang'),
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
				'label'		=> __('List style','mklang'),
				'name'		=> 'list_style',
				'type'		=> 'select',
				'choices' => [
					'default'				=> __('Default list','mklang'),
					'list'					=> __('Formatted list','mklang'),
					'list-check'			=> __('Check list','mklang'),
					'list-inline'			=> __('Inline list','mklang'),
					'list-inline-hyphen'	=> __('Inline list (hyphen)','mklang'),
					'list-inline-comma'		=> __('Inline list (comma)','mklang'),
					'list-justified'		=> __('Justified list','mklang'),
					'list-icon'				=> __('Icons list','mklang'),
				],
				'default_value' => false,
				'return_format' => 'value',
			),
			array(
				'key'			=> 'field_63b3daf7606e9',
				'label'			=> __('List columns','mklang'),
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
				'label'				=> __('Columns gap','mklang'),
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
				'label'				=> __('Columns separator','mklang'),
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
				'ui_on_text'		=> __('On','mklang'),
				'ui_off_text'		=> __('Off','mklang'),
				'ui'				=> 1,
			),
			array(
				'key'				=> 'field_63b3dc64606eb',
				'label'				=> __('Columns separator style','mklang'),
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
				'label'				=> __('Columns separator color','mklang'),
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
					'list-color-border'		=> __('Default','mklang'),
					'list-color-primary'	=> __('Primary color','mklang'),
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
		'title'						=> __('Description list item','mklang'),
		'fields'					=> array(
			array(
				'key'		=> 'field_63b4525449081',
				'label'		=> __('Title','mklang'),
				'name'		=> 'dt',
				'type'		=> 'text',
				'required'	=> 1,
			),
			array(
				'key'		=> 'field_63b4526949082',
				'label'		=> __('Description','mklang'),
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
		'title'					=> __('Tab','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63b41e05ce96f',
				'label'			=> __('Order','mklang'),
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
		'title'					=> __('Tabs','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63b415ba1ff7a',
				'label'			=> __('Tab titles','mklang'),
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
						'label'				=> __('Title','mklang'),
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
		'title'					=> __('Accordion item','mklang'),
		'fields'				=> array(
			array(
				'key'				=> 'field_64bbce8b80919',
				'label'			=> __('Title','mklang'),
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
		'title'					=> __('Table of contents','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63bc3cc6241f3',
				'label'			=> __('List type','mklang'),
				'name'			=> 'list_type',
				'type'			=> 'select',
				'instructions'	=> __('Select the type of list and then click on the "Refresh Index" button. All h2 tags will be mapped to create the table of contents. In the modal click on the "Copy" button and then paste the html code into the block. Remember to check the links on the frontend as sometimes they may not match the anchors.','mklang'),
				'choices'		=> [
					'ol'	=> __('Ordered list','mklang'),
					'ul'	=> __('Unordered list','mklang'),
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
				'label'			=> __('Version','mklang'),
				'name'			=> 'logo_version',
				'type'			=> 'select',
				'choices'		=> array(
					'light'	=> __('Light background','mklang'),
					'dark'	=> __('Dark background','mklang'),
				),
				'return_format'	=> 'value',
			),
			array(
				'key'			=> 'field_63f482bbff5b7',
				'label'			=> __('Link','mklang'),
				'name'			=> 'logo_link',
				'type'			=> 'select',
				'choices'		=> array(
					'link'		=> __('With link (homepage)','mklang'),
					'no_link'	=> __('Without link','mklang'),
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
		'title'					=> __('Get template','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63f8b11ad97b0',
				'label'			=> __('Template path','mklang'),
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
		'title'					=> __('Hero video','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63ed0ff3339a1',
				'label'			=> __('Video','mklang'),
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
				'label'			=> __('Poster','mklang'),
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
				'label'			=> __('Video controls','mklang'),
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
				'label'			=> __('Filter classes','mklang'),
				'name'			=> 'filter_classes',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_640ee2cba4cbf',
				'label'			=> __('Play on scroll','mklang'),
				'name'			=> 'play_on_scroll',
				'type'			=> 'true_false',
				'default_value'	=> 0,
				'ui'			=> 1,
				'ui_on_text'	=> __('On','mklang'),
				'ui_off_text'	=> __('Off','mklang'),
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
		'title'					=> __('Bar chart','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_63f5cde8cbc77',
				'label'			=> __('Value','mklang'),
				'name'			=> 'chart_value',
				'type'			=> 'number',
				'required'		=> 1,
				'max' => 100,
			),
			array(
				'key'			=> 'field_63f5cfc01bdd6',
				'label'			=> __('Label','mklang'),
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
		'title'					=> __('Pie chart','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_6408edf59d43d',
				'label'			=> __('Title','mklang'),
				'name'			=> 'title',
				'type'			=> 'text',
			),
			/*array(
				'key'			=> 'field_6408f1e6c7878',
				'label'			=> __('Center color','mklang'),
				'name'			=> 'circle_color',
				'type'			=> 'color_picker',
				'return_format'	=> 'string',
			),*/
			array(
				'key'			=> 'field_63f5e02e67668',
				'label'			=> __('Values','mklang'),
				'name'			=> 'chart_values',
				'type'			=> 'repeater',
				'instructions'	=> __('The sum of the values must be 100. If no color is set, the default colors will be used.','mklang'),
				'required'		=> 1,
				'layout'		=> 'block',
				'min'			=> 2,
				'collapsed'		=> 'field_63f5e04567669',
				'button_label'	=> __('Add value','mklang'),
				'rows_per_page'	=> 20,
				'sub_fields'	=> array(
					array(
						'key'				=> 'field_63f5e04567669',
						'label'				=> __('Value','mklang'),
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
						'label'				=> __('Label','mklang'),
						'name'				=> 'label',
						'type'				=> 'text',
						'required'			=> 1,
						'parent_repeater'	=> 'field_63f5e02e67668',
					),
					array(
						'key'				=> 'field_63f5e0b36766b',
						'label'				=> __('Color','mklang'),
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
				'label'			=> __('Size','mklang'),
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
		'title'					=> __('Photoswipe gallery','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_64c3849aee9b0',
				'label'			=> __('Images','mklang'),
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
				'label'			=> __('Preview image size','mklang'),
				'name'			=> 'preview_image_size',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_64c398c496236',
				'label'			=> __('Full image size','mklang'),
				'name'			=> 'full_image_size',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_64c398e496237',
				'label'			=> __('Card template','mklang'),
				'name'			=> 'card_template',
				'type'			=> 'text',
			),
			array(
				'key'			=> 'field_64c39ce1e5c40',
				'label'			=> __('Remove wrapper','mklang'),
				'name'			=> 'remove_wrapper',
				'type'			=> 'true_false',
				'instructions'	=> __('Add the class "mkt-gallery" to the new wrapper if you remove the default wrapper element.','mklang'),
				'default_value'	=> 0,
				'ui_on_text'	=> __('On','mklang'),
				'ui_off_text'	=> __('Off','mklang'),
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
				'choices'		=> mkt_block_values('post_types'),
				'default_value'	=> array(
					0	=> 'post',
				),
				'return_format'	=> 'value',
				'allow_custom'	=> 1,
				'save_custom'	=> 1,
				'layout'		=> 'vertical',
				'toggle'		=> 0,
				'custom_choice_button_text'	=> __('Add new post type','mklang'),
			),
			array(
				'key'			=> 'field_640c64a1a898e',
				'label'			=> __('Number','mklang'),
				'name'			=> 'posts_per_page',
				'type'			=> 'number',
				'required'		=> 1,
				'default_value'	=> 12,
				'min'			=> -1,
				'max'			=> '',
				'step'			=> 1,
				'append'		=> __('Posts','mklang'),
			),
			array(
				'key'			=> 'field_640c5dca4a6a0',
				'label'			=> __('Order','mklang'),
				'name'			=> 'order',
				'type'			=> 'select',
				'choices'		=> array(
					'DESC'	=> __('Descending','mklang'),
					'ASC'	=> __('Ascending','mklang'),
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
				'label'			=> __('Order by','mklang'),
				'name'			=> 'orderby',
				'type'			=> 'select',
				'choices' => array(
					'date'				=> __('Date','mklang'),
					'title'				=> __('Title','mklang'),
					'type'				=> __('Post type','mklang'),
					'parent'			=> __('Parent post','mklang'),
					'rand'				=> __('Random','mklang'),
					'menu_order'		=> __('Menu order','mklang'),
					'meta_value'		=> __('Meta value','mklang'),
					'meta_value_num'	=> __('Meta value number','mklang'),
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
				'label'         => __('Taxonomy','mklang'),
				'name'          => 'taxonomy',
				'type'          => 'text',
			),
			array(
				'key'           => 'field_65f7428c673b8',
				'label'         => __('Term slug','mklang'),
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
		'title'					=> __('Icon link','mklang'),
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
				'label'			=> __('Icon (only SVG)','mklang'),
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
		'title'					=> __('Map','mklang'),
		'fields'				=> array(
			array(
				'key'			=> 'field_640b8f3471b54',
				'label'			=> __('Post selection','mklang'),
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
				'label'			=> __('Posts','mklang'),
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
				'label'			=> __('Post type','mklang'),
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
				'custom_choice_button_text'	=> __('Add new post type','mklang'),
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
		'title'                 => __('Social links','mklang'),
		'fields' => array(
			array(
				'key'           => 'field_6640528f283e4',
				'label'         => __('Social links','mklang'),
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
				'label'         => __('Display options','mklang'),
				'name'          => 'display_options',
				'type'          => 'select',
				'required'      => 1,
				'relevanssi_exclude'    => 1,
				'choices'       => array(
					'show' => __('Show icon','mklang'),
					'hide' => __('Show label','mklang'),
					'both' => __('Show icon and label','mklang'),
				),
				'return_format' => 'value',
			),
			array(
				'key'           => 'field_664056f076b39',
				'label'         => __('Icon classes','mklang'),
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
				'label'         => __('Link classes','mklang'),
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
				'label'         => __('Wrapper','mklang'),
				'name'          => 'wrapper',
				'type'          => 'select',
				'relevanssi_exclude'    => 1,
				'choices' => array(
					'ul'    => __('Unordered list','mklang'),
					'none'  => __('None','mklang'),
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
		'title'                 => __('Custom image','mklang'),
		'fields'                => array(
			array(
				'key'           => 'field_665998cb96291',
				'label'         => __('Image','mklang'),
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
				'label'         => __('Size','mklang'),
				'name'          => 'size',
				'type'          => 'select',
				'required'      => 1,
				'choices'       => array(
					'thumbnail'     => __('Thumbnail','mklang'),
					'medium'        => __('Medium','mklang'),
					'medium_large'  => __('Medium large','mklang'),
					'large'         => __('Large','mklang'),
					'full-hd-thumb' => 'Full HD (1920x1280)',
					'full'          => __('Full','mklang'),
					'post-thumbnail'=> __('Original','mklang'),
				),
				'default_value' => 'original',
				'return_format' => 'value',
			),
			array(
				'key'           => 'field_66599a0f6e72b',
				'label'         => __('Above the fold','mklang'),
				'name'          => 'priority',
				'type'          => 'true_false',
				'default_value' => 0,
				'ui_on_text'    => 'On',
				'ui_off_text'   => 'Off',
				'ui'            => 1,
			),
			array(
				'key'           => 'field_6659b0219435d',
				'label'         => __('Preload','mklang'),
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
				'message'       => __('If this is the main Above the Fold image, you may want to preload it.','mklang'),
			),
			array(
				'key'           => 'field_66599be777c46',
				'label'         => __('Figure tag','mklang'),
				'name'          => 'figure',
				'type'          => 'true_false',
				'default_value' => 0,
				'ui_on_text'    => 'On',
				'ui_off_text'   => 'Off',
				'ui'            => 1,
			),
			array(
				'key'           => 'field_66599b646e72c',
				'label'         => __('Figure class','mklang'),
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
				'label'         => __('Figure caption','mklang'),
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
				'label'         => __('Style','mklang'),
				'name'          => 'style',
				'type'          => 'text',
			),
			array(
				'key'           => 'field_6659a0729a513',
				'label'         => __('Background image','mklang'),
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
					'value'     => 'acf/custom-image',
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
		'title'                 => __('Company data and footer links','mklang'),
		'fields'                => array(
			array(
				'key'       => 'field_663e5314839c4',
				'label'     => __('Company data and footer links','mklang'),
				'name'      => 'company_data_footer_links',
				'type'      => 'flexible_content',
				'required'  => 1,
				'relevanssi_exclude'    => 1,
				'layouts'   => array(
					'layout_663e536e839c5' => array(
						'key'       => 'layout_663e536e839c5',
						'name'      => 'privacy',
						'label'     => __('Privacy','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'           => 'field_663e8c332de4f',
								'label'         => __('Info','mklang'),
								'type'          => 'message',
								'relevanssi_exclude' => 1,
								'message'       => __('Add a link to the privacy policy page (set on the options page).','mklang'),
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
								'label'         => __('Info','mklang'),
								'type'          => 'message',
								'relevanssi_exclude' => 1,
								'message'       => __('Add a link to the cookie policy page (set on the options page).','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e5379839c7' => array(
						'key'       => 'layout_663e5379839c7',
						'name'      => 'cookie_preferences',
						'label'     => __('Cookie Preferences','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'           => 'field_663e8d202de51',
								'label'         => __('Info','mklang'),
								'type'          => 'message',
								'relevanssi_exclude' => 1,
								'message'       => __('Add a link to cookie tracking preferences (only if you are using Iubenda).','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e53fb839cf' => array(
						'key'       => 'layout_663e53fb839cf',
						'name'      => 'terms_and_conditions',
						'label'     => __('Terms and Conditions','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'           => 'field_663e8d332de52',
								'label'         => __('Terms and Conditions','mklang'),
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
								'message'   => __('Add the copyright notice. Ex: ©2020/2024, Company name. All rights reserved.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e5da32783e' => array(
						'key'       => 'layout_663e5da32783e',
						'name'      => 'vat_number',
						'label'     => __('VAT Number','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e8e282de54',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company VAT number.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663f2b3488dcb' => array(
						'key'       => 'layout_663f2b3488dcb',
						'name'      => 'cf_number',
						'label'     => __('Fiscal Code','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663f2b3488dcc',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company fiscal code.','mklang'),
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
								'message'   => __('Add a link with class "whistleblowing" to be used to display the whistleblowing modal. Whistleblowing compliance is mandatory only for companies with at least 50 employees.','mklang'),
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
								'message'   => __('Add Google reCAPTCHA links.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e5392839cb' => array(
						'key'       => 'layout_663e5392839cb',
						'name'      => 'credits',
						'label'     => __('Credits','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e8ebc2de56',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the Tenaglia Studio credit and link. Ex: Design & code by Tenaglia Studio.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e936da47d4' => array(
						'key'       => 'layout_663e936da47d4',
						'name'      => 'phone',
						'label'     => __('Phone','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e9384a47d6',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company phone number.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e939ba47d8' => array(
						'key'       => 'layout_663e939ba47d8',
						'name'      => 'mobile_phone',
						'label'     => __('Mobile phone','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e939ba47d9',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company mobile phone number.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e93b8a47da' => array(
						'key'       => 'layout_663e93b8a47da',
						'name'      => 'toll_free_phone',
						'label'     => __('Toll free phone','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e93b8a47db',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company toll free phone number.','mklang'),
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
								'message'   => __('Add the company email.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e946831854' => array(
						'key'       => 'layout_663e946831854',
						'name'      => 'pec_email',
						'label'     => __('PEC Email','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e946831855',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company PEC email.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e608de2039' => array(
						'key'       => 'layout_663e608de2039',
						'name'      => 'company_name',
						'label'     => __('Company Name','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e916e89dc2',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company name.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_66412b88f2c9c' => array(
						'key'       => 'layout_66412b88f2c9c',
						'name'      => 'business_name',
						'label'     => __('Business Name','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_66412b7ef2c9b',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the business name.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e60a3e203b' => array(
						'key'       => 'layout_663e60a3e203b',
						'name'      => 'registered_office',
						'label'     => __('Registered office','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e922189dc3',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company registered office address.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e60b8e203f' => array(
						'key'       => 'layout_663e60b8e203f',
						'name'      => 'rea_number',
						'label'     => __('REA Number','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e923989dc4',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company REA number.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e92a6a47cf' => array(
						'key'       => 'layout_663e92a6a47cf',
						'name'      => 'legal_representative',
						'label'     => __('Legal Representative','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e92b4a47d1',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company legal representative name.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e92cba47d2' => array(
						'key'       => 'layout_663e92cba47d2',
						'name'      => 'share_capital',
						'label'     => __('Share Capital','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e92cba47d3',
								'label'     => 'Info',
								'type'      => 'message',
								'relevanssi_exclude' => 1,
								'message'   => __('Add the company share capital.','mklang'),
							),
						),
						'max'       => '1',
					),
					'layout_663e60e6e2041' => array(
						'key'       => 'layout_663e60e6e2041',
						'name'      => 'custom_item',
						'label'     => __('Custom Item','mklang'),
						'display'   => 'block',
						'sub_fields'=> array(
							array(
								'key'       => 'field_663e60fee2043',
								'label'     => __('Label','mklang'),
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
								'label'     => __('Open in a new tab','mklang'),
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
								'ui_on_text'    => __('On','mklang'),
								'ui_off_text'   => __('Off','mklang'),
								'ui'            => 1,
							),
							array(
								'key'           => 'field_663e6135e2046',
								'label'         => __('CSS Classes','mklang'),
								'name'          => 'css_class',
								'type'          => 'text',
								'relevanssi_exclude' => 1,
							),
						),
					),
				),
				'button_label' => __('Add item','mklang'),
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