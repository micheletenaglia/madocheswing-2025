<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Register theme core ACF fields.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0.0
 */

/****************************************************************************************
  _____ _   _ _____ __  __ _____   _____ ___ _____ _     ____  ____  
 |_   _| | | | ____|  \/  | ____| |  ___|_ _| ____| |   |  _ \/ ___| 
   | | | |_| |  _| | |\/| |  _|   | |_   | ||  _| | |   | | | \___ \ 
   | | |  _  | |___| |  | | |___  |  _|  | || |___| |___| |_| |___) |
   |_| |_| |_|_____|_|  |_|_____| |_|   |___|_____|_____|____/|____/ 

    !!! Acf only in backend
    https://stackoverflow.com/questions/40595832/wordpress-check-if-plugin-is-installed-acf
    https://www.billerickson.net/advanced-custom-fields-frontend-dependency/

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Allow wp_block post type in ACF
add_filter( 'acf/get_post_types', 'hap_acf_get_post_types_add_wp_block', 10, 1 );

// Programmatically populate ACF select field named "optimization_contact_form_7_post_types"
add_filter('acf/load_field/name=optimization_contact_form_7_post_types', 'hap_populate_cf7_post_types');

/* Actions ----------------------------------------------------------------------------*/

add_action('acf/init', 'hap_load_fields_theme');
add_action('acf/save_post', 'hap_acf_options_default_values', 20);

/* Functions --------------------------------------------------------------------------*/

/**
 * Add ACF options page.
 * 
 */
if( function_exists('acf_add_options_page') ) {

    // Options page: Main
    acf_add_options_page([
        'page_title'    =>	__('Mkt Theme Options','hap'),
        'menu_title'	=>	__('Hap options','hap'),
        'menu_slug' 	=>	'options',
        'capability'	=>	get_option('project_options_cap') ? get_option('project_options_cap') : 'edit_others_pages',
        'icon_url'		=>	'dashicons-hap',
        'redirect'		=>	false,
        'position'		=>	false,
        'post_id'       =>	'options',
        'update_button' =>	__('Save', 'acf'),
        'updated_message'=>	__('Options saved', 'acf'),
    ]);

    // Options page: Layout
    acf_add_options_sub_page([
        'page_title'    =>	__('Mkt Theme Layout','hap'),
        'menu_title'	=>	__('Layout', 'hap'),
        'parent_slug'	=>	'options',
        'menu_slug'		=>	'options-layout',
        'capability' 	=>	'activate_plugins',
    ]);
    
    // Options page: Other
    acf_add_options_sub_page([
        'page_title'    =>	__('Other options','hap'),
        'menu_title'	=>	__('Other options', 'hap'),
        'parent_slug'	=>	'options',
        'menu_slug'		=>	'options-other',
        'capability' 	=>	'activate_plugins',
    ]);

}

/****************************************************************************************
  _____ ___ _____ _     ____  ____  
 |  ___|_ _| ____| |   |  _ \/ ___| 
 | |_   | ||  _| | |   | | | \___ \ 
 |  _|  | || |___| |___| |_| |___) |
 |_|   |___|_____|_____|____/|____/ 

****************************************************************************************/

/**
 * Load ACF fields in theme.
 * 
 */
function hap_load_fields_theme() {

	if( function_exists('acf_add_local_field_group') ) {
		
		// Options page 1
		acf_add_local_field_group(array(
			'key'						=> 'group_608046bac074d',
			'title'						=> __('Main settings','hap'),
			'fields'					=> array(
				array(
					'key'				=> 'field_60805430e4c49',
					'label'				=> __('Contacts','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-contacts',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_687cac804a6',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-contacts',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can add all the details about the company.','hap'),
				),
				array(
					'key'				=> 'field_kag9dybce5ndiumk',
					'label'				=> __('Company Name','hap'),
					'name'				=> 'company_name',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_name]',
					'required'			=> 1,
				),
				array(
					'key'				=> 'field_z3pb37smqcc1xrdc',
					'label'				=> __('Legal Representative','hap'),
					'name' 				=> 'legal_representative',
					'type' 				=> 'text',
					'instructions' 		=> 'Shortcode: [company_legal_representative]',
				),
				array(
					'key'				=> 'field_6080543fe4c4a',
					'label'				=> __('Phone','hap'),
					'name'				=> 'phone',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_phone]',
				),
				array(
					'key'				=> 'field_60805464e4c4b',
					'label'				=> __('Mobile Phone','hap'),
					'name'				=> 'mobile_phone',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_mobile_phone]',
				),
				array(
					'key'				=> 'field_639b213e95fac',
					'label'				=> __('Toll Free Phone Number','hap'),
					'name'				=> 'toll_free_phone',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_toll_free_phone]',
				),
				array(
					'key'				=> 'field_62385b625033f',
					'label'				=> __('Email','hap'),
					'name'				=> 'email',
					'type'				=> 'email',
					'instructions'		=> 'Shortcode: [company_email]',
					'required'			=> 1
				),
				array(
					'key'				=> 'field_6080546ce4c4c',
					'label'				=> __('PEC Email','hap'),
					'name'				=> 'pec_email',
					'type'				=> 'email',
					'instructions'		=> 'Shortcode: [company_pec_email]',
				),
				array(
					'key'				=> 'field_60805471e4c4d',
					'label'				=> __('Address','hap'),
					'name'				=> 'address',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_address]',
				),
				array(
					'key'				=> 'field_60805488e4c4e',
					'label'				=> __('Postcode','hap'),
					'name'				=> 'postcode',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_zippostal_code]',
				),
				array(
					'key'				=> 'field_60805495e4c4f',
					'label'				=> __('City','hap'),
					'name'				=> 'city',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_city]',
				),
				array(
					'key'				=> 'field_6080549be4c50',
					'label'				=> __('Region','hap'),
					'name'				=> 'region',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_region]',
				),
				array(
					'key'				=> 'field_608054a1e4c51',
					'label'				=> __('Country','hap'),
					'name'				=> 'country',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_country]',
				),
				array(
					'key'				=> 'field_opdwhy342cf7dzm1',
					'label'				=> __('VAT Number','hap'),
					'name'				=> 'vat_number',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_vat_number]',
				),
				array(
					'key'				=> 'field_y1e2vey2f6rf3wkj',
					'label'				=> __('Fiscal Code','hap'),
					'name'				=> 'cf_number',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_cf_number]',
				),
				array(
					'key'				=> 'field_eueozakyetgivsma',
					'label'				=> __('REA number','hap'),
					'name'				=> 'rea_number',
					'type'				=> 'text',
					'instructions'		=> 'Shortcode: [company_rea_number]',
				),
				array(
					'key'				=> 'field_vp67k6upd08ndoo8',
					'label'				=> __('Share Capital','hap'),
					'name'				=> 'share_capital',
					'type'				=> 'number',
					'instructions'		=> 'Shortcode: [company_share_capital]',
				),
				array(
					'key'				=> 'field_5d265681364f2',
					'label'				=> __('Copyright start year','hap'),
					'name'				=> 'copyright_year',
					'aria-label'		=> '',
					'type'				=> 'number',
					'instructions'		=> __('This value will be printed in footer into the the copyright statement.','hap'),
					'min'				=> 2010,
				),
				array(
					'key'				=> 'field_608054a9e4c52',
					'label'				=> __('Social Media & Newsletter','hap'),
					'name'				=> '',
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-social',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_687caca8046',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-social',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can add any social media in use by the company. <br>Shortcode default values: <ul><li><strong>icon="show"</strong><br> Set to "hide" if you want to show only text</li><li><strong>icon_classes="svg-icon fill-current h-4"</strong><br> The CSS classes assigned to the icon element</li><li><strong>a_classes=""</strong><br> The CSS classes assigned to the anchor element</li><li><strong>path="core"</strong><br> The path from where the icon file is loaded: change to project if you have uploaded a custom icon in project folder</li></ul>','hap'),
					'esc_html'			=> 0,
				),
				array(
					'key'				=> 'field_608054bce4c53',
					'label'				=> 'Facebook',
					'name'				=> 'facebook',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="facebook" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_608054cae4c54',
					'label'				=> 'Instagram',
					'name'				=> 'instagram',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="instagram" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_608054d2e4c55',
					'label'				=> 'X (Twitter)',
					'name'				=> 'twitter',
					'type'				=> 'url',
					'instructions' 		=> 'Shortcode: [get_social_link name="twitter" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_608054dbe4c56',
					'label'				=> 'Youtube',
					'name'				=> 'youtube',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="youtube" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_608054e5e4c57',
					'label'				=> 'Vimeo',
					'name'				=> 'vimeo',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="vimeo" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_608054efe4c58',
					'label'				=> 'Linkedin',
					'name'				=> 'linkedin',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="linkedin" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_d2e4c56080545',
					'label'				=> 'Tiktok',
					'name'				=> 'tiktok',
					'type'				=> 'url',
					'instructions' 		=> 'Shortcode: [get_social_link name="tiktok" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_6091de931b13d',
					'label'				=> 'Spotify',
					'name'				=> 'spotify',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="spotify" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_6091dea91b13e',
					'label'				=> 'Pinterest',
					'name'				=> 'pinterest',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="pinterest" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_6091dec01b13f',
					'label'				=> 'Google Maps',
					'name'				=> 'google_maps',
					'type' 				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="google_maps" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
				array(
					'key'				=> 'field_60e5d38c1cc86',
					'label'				=> 'Mailchimp',
					'name'				=> 'mailchimp',
					'type'				=> 'url',
					'instructions'		=> 'Shortcode: [get_social_link name="mailchimp" icon="show/hide" icon_classes="" a_classes="" path=""]',
				),
                array(
                    'key'               => 'field_66d866776e597',
                    'label'             => 'Whatsapp',
                    'name'              => 'whatsapp',
                    'type'              => 'text',
					'instructions'		=> 'Shortcode: [get_social_link name="whatsapp" icon="show/hide" icon_classes="" a_classes="" path=""]',
                ),
                array(
                    'key'               => 'field_66d86730a213d',
                    'label'             => 'Telegram',
                    'name'              => 'telegram',
                    'type'              => 'text',
					'instructions'		=> 'Shortcode: [get_social_link name="telegram" icon="show/hide" icon_classes="" a_classes="" path=""]',
                ),
                array(
                    'key'               => 'field_66d86849a213e',
                    'label'             => 'Signal',
                    'name'              => 'signal',
                    'type'              => 'text',
					'instructions'		=> 'Shortcode: [get_social_link name="signal" icon="show/hide" icon_classes="" a_classes="" path=""]',
                ),
			),
			'location' => array(
				array(
					array(
						'param'			=> 'options_page',
						'operator'		=> '==',
						'value'			=> 'options',
					),
				),
			),
			'menu_order'				=> 0,
			'position'					=> 'normal',
			'style'						=> 'default',
			'label_placement'			=> 'left',
			'instruction_placement'		=> 'field',
			'hide_on_screen'			=> '',
			'active'					=> true,
			'description'				=> __('General settings for Mkt Theme (editable by editors).','hap'),
		));

		// Options page 2
		acf_add_local_field_group(array(
			'key'						=> 'group_608045fa9e5e1',
			'title'						=> __('Layout','hap'),
			'fields'					=> array(
				array(
					'key'				=> 'field_60804983069d0',
					'label'				=> __('Logo & Images','hap'),
					'type'				=> 'accordion',
					'conditional_logic'	=> 0,
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-image',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_6804a67cac8',
					'label'				=> __('About','hap'),
					'name'				=> '',
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-image',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can add the logo, favicon and placeholder image for this website. To be able to upload SVG files remember to add <strong>define(\'ALLOW_UNFILTERED_UPLOADS\', true);</strong> in wp-config.php','hap'),
				),
				array(
					'key'				=> 'field_608056a9f0266',
					'label'				=> __('Logo Light Mode','hap'),
					'name'				=> 'logo_light_mode',
					'type'				=> 'group',
					'instructions'		=> __('Upload the default logo image for this website. The allowed file types are svg, png and jpg but it is always advisable to use an svg file because it is lighter and more easily manipulated using CSS styles.','hap'),
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_608047715a452',
							'label'				=> __('Image','hap'),
							'name'				=> 'img',
							'type'				=> 'image',
							'wrapper'			=> array(
								'width'	=> '50',
								'class'	=> '',
								'id'	=> '',
							),
							'return_format'		=> 'array',
							'preview_size'		=> 'thumbnail',
							'library'			=> 'all',
							'mime_types'		=> 'svg,png,jpg,jpeg',
						),
						array(
							'key'				=> 'field_608048681e134',
							'label'				=> __('CSS Classes','hap'),
							'name'				=> 'css_classes',
							'type'				=> 'text',
							'wrapper'			=> array(
								'width'	=> '35',
								'class'	=> '',
								'id'	=> '',
							),
						),
						array(
							'key'				=> 'field_6091e00304bb2',
							'label'				=> __('SVG Inline','hap'),
							'name'				=> 'svg_inline',
							'type'				=> 'true_false',
							'wrapper'			=> array(
								'width'			=> '15',
								'class'			=> '',
								'id'			=> '',
							),
						),
					),
				),
				array(
					'key'				=> 'field_608056f8f0268',
					'label'				=> __('Logo Dark Mode','hap'),
					'name'				=> 'logo_dark_mode',
					'type'				=> 'group',
					'instructions'		=> __('Upload the logo image to be used on dark backgrounds. The allowed file types are svg, png and jpg but it is always advisable to use an svg file because it is lighter and more easily manipulated using CSS styles. If you have uploaded an svg file as the default logo image it may not be necessary to add a version for dark backgrounds because svg files, when included as inline HTML, can be manipulated using CSS rules.','hap'),
					'layout'	=> 'block',
					'sub_fields'=> array(
						array(
							'key'				=> 'field_608056f8f0269',
							'label'				=> __('Image','hap'),
							'name'				=> 'img',
							'type'				=> 'image',
							'wrapper'			=> array(
								'width'	=> '50',
								'class'	=> '',
								'id'	=> '',
							),
							'return_format'		=> 'array',
							'preview_size'		=> 'thumbnail',
							'library'			=> 'all',
							'mime_types'		=> 'svg,png,jpg',
						),
						array(
							'key'				=> 'field_608056f8f026a',
							'label'				=> __('CSS Classes','hap'),
							'name'				=> 'css_classes',
							'type'				=> 'text',
							'wrapper'			=> array(
								'width'	=> '35',
								'class'	=> '',
								'id'	=> '',
							),
						),
						array(
							'key'				=> 'field_6091e02704bb3',
							'label'				=> __('SVG Inline','hap'),
							'name'				=> 'svg_inline',
							'type'				=> 'true_false',
							'wrapper'			=> array(
								'width'	=> '15',
								'class'	=> '',
								'id'	=> '',
							),
						),
					),
				),
				array(
					'key'			=> 'field_63a58d72a31f4',
					'label'			=> __('Logo other version','hap'),
					'name'			=> 'logo_other_version',
					'type'			=> 'group',
					'instructions'		=> __('The logo in PNG or JPG format. This version is used in some specific cases such as signing Contact Form 7 forms.','hap'),
					'layout' => 'block',
					'sub_fields'	=> array(
						array(
							'key'			=> 'field_63a58deca31f5',
							'label'			=> __('Image','hap'),
							'name'			=> 'img',
							'type'			=> 'image',
							'instructions'	=> __('JPG and PNG only.','hap'),
							'wrapper'	=> array(
								'width'	=> '50',
								'class'	=> '',
								'id'	=> '',
							),
							'return_format'	=> 'id',
							'library'		=> 'all',
							'mime_types'	=> 'jpg,jpeg,png',
							'preview_size'	=> 'thumbnail',
						),
						array(
							'key'			=> 'field_63a58e30a31f6',
							'label'			=> __('Width','hap'),
							'name'			=> 'width',
							'type'			=> 'number',
							'wrapper'		=> array(
								'width'	=> '25',
								'class'	=> '',
								'id'	=> '',
							),
							'min'			=> 1,
							'step'			=> 1,
							'append'		=> 'px',
						),
						array(
							'key'			=> 'field_63a58e3ba31f7',
							'label'			=> __('Height','hap'),
							'name'			=> 'height',
							'type'			=> 'number',
							'wrapper'		=> array(
								'width'	=> '25',
								'class'	=> '',
								'id'	=> '',
							),
							'min'			=> 1,
							'step'			=> 1,
							'append'		=> 'px',
						),
					),
				),
				// Favicons
				array(
					'key'				=> 'field_4a17908094ae6',
					'label'				=> __('Favicons','hap'),
					'name'				=> 'favicons',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(						
						array(
							'key'				=> 'field_0496096c0878f',
							'label'				=> 'Favicon SVG',
							'name'				=> 'favicon_svg',
							'type'				=> 'image',
							'instructions'		=> __('Add a favicon to the website. The best way to reach cross-browsers compatibility is to add both SVG and PNG files. The file must be square and measure 512 x 512 pixels.','hap'),
							'return_format'		=> 'id',
							'preview_size'		=> 'thumbnail',
							'library'			=> 'all',
							'min_width'			=> '512',
							'min_height'		=> '512',
							'max_width'			=> '512',
							'max_height'		=> '512',
							'mime_types'		=> 'svg',
						),
						array(
							'key'				=> 'field_60804965069cf',
							'label'				=> 'Favicon PNG',
							'name'				=> 'favicon',
							'type'				=> 'image',
							'instructions'		=> __('Add a favicon to the website. The best way to reach cross-browsers compatibility is to add both SVG and PNG files. The file must be square and measure 512 x 512 pixels.','hap'),
							'return_format'		=> 'id',
							'preview_size'		=> 'thumbnail',
							'library'			=> 'all',
							'min_width'			=> '512',
							'min_height'		=> '512',
							'max_width'			=> '512',
							'max_height'		=> '512',
							'mime_types'		=> 'png',
						),
						array(
							'key'				=> 'field_040765acc617a',
							'label'				=> __('Regenerate favicon versions','hap'),
							'name'				=> 'regenerate_favicons',
							'type'				=> 'true_false',
							'instructions'		=> __('Activate this option if you want to generate: favicon versions for all devices and browsers, JSON code for "manifest.webmanifest" file and "browserconfig.xml" file.','hap'),
							'ui'				=> 1,
							'ui_on_text'		=> __('On','hap'),
							'ui_off_text'		=> __('Off','hap'),
						),
						array(
							'key'				=> 'field_6f4b0804c46ce',
							'label'				=> __('Favicon code in head','hap'),
							'name'				=> 'favicon_code',
							'type'				=> 'textarea',
							'instructions'		=> __('This value is generated automatically after adding a favicon file. If you have changed the favicon, flag "Regenerate favicon versions" field and then save this page. It is also possible to edit this field manually if you need to customize the code.','hap'),
							'wrapper'			=> array(
								'width'	=> '',
								'class'	=> 'hap-code',
								'id'	=> '',
							),
						),
						array(
							'key'				=> 'field_b6cf00468c44e',
							'label'				=> __('Favicon JSON file for Android apps','hap'),
							'name'				=> 'favicon_manifest_json',
							'type'				=> 'textarea',
							'instructions'		=> __('This JSON code is automatically generated and copied to "manifest.webmanifest" file located in theme/core/favicons directory.','hap'),
							'wrapper'			=> array(
								'width'	=> '',
								'class'	=> 'hap-code',
								'id'	=> '',
							),
						),
						array(
							'key'				=> 'field_6f08c44b6c04e',
							'label'				=> __('Favicon XML file for Windows','hap'),
							'name'				=> 'favicon_xml',
							'type'				=> 'textarea',
							'instructions'		=> __('This XML code is automatically generated and copied to "browserconfig.xml" file located in theme/core/favicons directory.','hap'),
							'wrapper'			=> array(
								'width'	=> '',
								'class'	=> 'hap-code',
								'id'	=> '',
							),
						),
					),
				),
				array(
					'key'				=> 'field_w1ochqb4g29sawba',
					'label'				=> __('Placeholder image','hap'),
					'name'				=> 'placeholder_image',
					'type'				=> 'image',
					'instructions'		=> __('Image to be used as fallback when the post has no related image.','hap'),
					'return_format'		=> 'id',
					'preview_size'		=> 'thumbnail',
					'library'			=> 'all',
					'mime_types'		=> 'png,jpg,svg',
				),
                array(
                    'key'               => 'field_663b61f648b0f',
                    'label'             => __('Max image size','hap'),
                    'name'              => 'media_library_max_image_size',
                    'type'              => 'number',
                    'instructions'      => __('The maximum size in kilobytes of the images uploaded in the media library. The image formats included are JPG, JPEG, PNG, SVG and any other image format.','hap'),
                    'default'           => 720,
                    'min'               => 320,
                    'step'              => 5,
                    'append'            => 'kb',
                ),
                array(
					'key'				=> 'field_608049fdff986',
					'label'				=> __('Colors','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-colors',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_a6cac687048',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-colors',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can set the color palette of the website. These values will be used to customize the backend and the login page.','hap'),
				),
				array(
					'key'				=> 'field_60804a13ff987',
					'label'				=> __('Primary Color','hap'),
					'name'				=> 'primary_color',
					'type'				=> 'color_picker',
					'instructions'		=> __('Set the primary color of the website.','hap'),
					'default_value'		=> '#ea4335',
				),
				array(
					'key'				=> 'field_60804a25ff988',
					'label'				=> __('Secondary Color','hap'),
					'name'				=> 'secondary_color',
					'type'				=> 'color_picker',
					'instructions'		=> __('Set the secondary color of the website.','hap'),
					'default_value' => '#000000',
				),
				array(
					'key'				=> 'field_608055dba2c7a',
					'label'				=> __('Mobile Bar Color','hap'),
					'name'				=> 'mobile_bar_color',
					'type'				=> 'color_picker',
					'instructions'		=> __('Set the color of browser bar on mobile devices.','hap'),
					'default_value'		=> '#ea4335',
				),
				array(
					'key'				=> 'field_60804a6194175',
					'label'				=> __('Fonts','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-fonts',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_6804a67cab7',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-fonts',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can set the fonts to be used in this website. You can choose to use Google Fonts, Adobe fonts, custom fonts, or a combination of the three options.','hap'),
					'new_lines'			=> 'wpautop',
				),
				array(
					'key'				=> 'field_608061f7c4edc',
					'label'				=> __('Google Fonts','hap'),
					'type'				=> 'tab',
					'placement'			=> 'top',
				),
				array(
					'key'				=> 'field_660022586da71',
					'label'				=> __('Google Fonts','hap'),
					'name'				=> 'google_fonts',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_6600e496b51eb',
							'label'				=> __('Font Url','hap'),
							'name'				=> 'url',
							'type'				=> 'url',
							'instructions'		=> __('Copy and paste the url of selected Google font stylesheet.','hap'),
							'default_value'	=> 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;600&display=swap',
							'placeholder'	=> 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;600&display=swap',
						),
						array(
							'key'				=> 'field_6600e4c8829dc',
							'label'				=> __('Preload','hap'),
							'name'				=> 'preload',
							'type'				=> 'true_false',
							'instructions'		=> __('Activate this option if you want to preload the font (better performances).','hap'),
							'ui'				=> 1,
							'ui_on_text'		=> __('On','hap'),
							'ui_off_text'		=> __('Off','hap'),
						),
					),
				),
				array(
					'key'				=> 'field_6080620dc4edd',
					'label'				=> __('Woff Fonts','hap'),
					'name'				=> '',
					'type'				=> 'tab',
					'placement'			=> 'top',
				),
				array(
					'key'				=> 'field_60804b590addd',
					'label'				=> __('Primary Font (Woff)','hap'),
					'name'				=> 'primary_font_woff',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_60804b590adde',
							'label'				=> __('Font File','hap'),
							'name'				=> 'url',
							'type'				=> 'file',
							'instructions'		=> __('Load a WOFF or WOFF2 font file.','hap'),
							'return_format'		=> 'url',
							'library'			=> 'all',
							'mime_types'		=> 'woff, woff2',
						),
						array(
							'key'				=> 'field_60804b590addf',
							'label'				=> __('Preload','hap'),
							'name'				=> 'preload',
							'type'				=> 'true_false',
							'instructions'		=> __('Activate this option if you want to preload the font (better performances).','hap'),
							'ui'				=> 1,
							'ui_on_text'		=> __('On','hap'),
							'ui_off_text'		=> __('Off','hap'),
						),
					),
				),
				array(
					'key'				=> 'field_60804c010ade3',
					'label'				=> __('Secondary Font (Woff)','hap'),
					'name'				=> 'secondary_font_woff',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_60804c010ade4',
							'label'				=> __('Font File','hap'),
							'name'				=> 'url',
							'type'				=> 'file',
							'instructions'		=> __('Load a WOFF or WOFF2 font file.','hap'),
							'return_format'		=> 'url',
							'library'			=> 'all',
							'mime_types'		=> 'woff, woff2',
						),
						array(
							'key'				=> 'field_60804c010ade5',
							'label'				=> __('Preload','hap'),
							'name'				=> 'preload',
							'type'				=> 'true_false',
							'instructions'		=> __('Activate this option if you want to preload the font (better performances).','hap'),
							'ui'				=> 1,
							'ui_on_text'		=> __('On','hap'),
							'ui_off_text'		=> __('Off','hap'),
						),
					),
				),
				array(
					'key'				=> 'field_60804c150ade6',
					'label'				=> __('Extra Font (Woff)','hap'),
					'name'				=> 'extra_font_woff',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_60804c150ade7',
							'label'				=> __('Font File','hap'),
							'name'				=> 'url',
							'type'				=> 'file',
							'instructions'		=> __('Load a WOFF or WOFF2 font file.','hap'),
							'return_format'		=> 'url',
							'library'			=> 'all',
							'mime_types'		=> 'woff, woff2',
						),
						array(
							'key'				=> 'field_60804c150ade8',
							'label'				=> __('Preload','hap'),
							'name'				=> 'preload',
							'type'				=> 'true_false',
							'instructions'		=> __('Activate this option if you want to preload the font (better performances).','hap'),
							'ui'				=> 1,
							'ui_on_text'		=> __('On','hap'),
							'ui_off_text'		=> __('Off','hap'),
						),
					),
				),
				array(
					'key'				=> 'field_6600224f6da70',
					'label'				=> __('Adobe Fonts','hap'),
					'type'				=> 'tab',
					'placement'			=> 'top',
				),
				array(
					'key'				=> 'field_6600225e6da78',
					'label'				=> __('Adobe Fonts','hap'),
					'name'				=> 'adobe_fonts',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_6600225e6da77',
							'label'				=> __('Font Url','hap'),
							'name'				=> 'url',
							'type'				=> 'url',
							'instructions'		=> __('Copy and paste the url of selected Adobe font stylesheet.','hap'),
							'placeholder'	=> 'https://use.typekit.net/example.css',
						),
						array(
							'key'				=> 'field_6600225d6da75',
							'label'				=> __('Preload','hap'),
							'name'				=> 'preload',
							'type'				=> 'true_false',
							'instructions'		=> __('Activate this option if you want to preload the font (better performances).','hap'),
							'ui'				=> 1,
							'ui_on_text'		=> __('On','hap'),
							'ui_off_text'		=> __('Off','hap'),
						),
					),
				),
				// Menus
				array(
					'key'				=> 'field_80498306960d0',
					'label'				=> __('Menus','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-menus',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_a67cac86804',
					'label'				=> __('About','hap'),
					'name'				=> '',
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-menus',
						'id'	=> '',
					),
					'message'			=> __('Select which menus to use for desktop and mobile, and other menu options.','hap'),
				),
				array(
					'key'				=> 'field_6397010049466',
					'label'				=> __('Desktop menu','hap'),
					'type'				=> 'tab',
					'placement'	=> 'top',
				),
				array(
					'key'				=> 'field_6397014849467',
					'label'				=> __('Type','hap'),
					'name'				=> 'menu_desktop',
					'type'				=> 'select',
					'choices'			=> array(
						'default'	=> __('Default','hap'),
						'centered'	=> __('Centered','hap'),
						'fade-in'	=> __('Fade in','hap'),
						'slide-in'	=> __('Slide in','hap'),
						'block'		=> __('Custom block','hap'),
						'template'	=> __('Custom template','hap'),
					),
					'default_value'		=> 'default',
					'return_format'		=> 'value',
				),
				array(
					'key'				=> 'field_63f45cb52729f',
					'label'				=> __('Menu block','hap'),
					'name'				=> 'menu_block',
					'type'				=> 'post_object',
					'required'			=> 1,
					'conditional_logic'	=> array(
						array(
							array(
								'field'		=> 'field_6397014849467',
								'operator'	=> '==',
								'value'		=> 'block',
							),
						),
					),
					'post_type' => array(
						0	=> 'wp_block',
					),
					'return_format'		=> 'id',
					'ui'				=> 1,
				),
				array(
					'key'				=> 'field_63f45cf7339dd',
					'label'				=> __('Menu template','hap'),
					'name'				=> 'menu_template',
					'type'				=> 'text',
					'required'			=> 1,
					'conditional_logic'	=> array(
						array(
							array(
								'field'		=> 'field_6397014849467',
								'operator'	=> '==',
								'value'		=> 'template',
							),
						),
					),
				),
				array(
					'key'				=> 'field_639701af09105',
					'label'				=> __('Position','hap'),
					'name'				=> 'menu_desktop_position',
					'type'				=> 'select',
					'choices'			=> array(
						'static'		=> __('Static','hap'),
						'absolute'		=> __('Absolute','hap'),
						'fixed'			=> __('Fixed','hap'),
					),
					'default_value'		=> 'static',
					'return_format'		=> 'value',
				),
				array(
					'key'				=> 'field_6397021e09106',
					'label'				=> __('Hide on scroll','hap'),
					'name'				=> 'menu_desktop_hide_on_scroll',
					'type'				=> 'true_false',
					'ui_on_text'		=> __('On','hap'),
					'ui_off_text'		=> __('Off','hap'),
					'ui'				=> 1,
				),
				array(
					'key'				=> 'field_6397028409107',
					'label'				=> __('Add custom items after menu','hap'),
					'name'				=> 'menu_desktop_after',
					'type'				=> 'flexible_content',
					'layouts'			=> array(
						'layout_6397029b9bc50'	=> array(
							'key'			=> 'layout_6397029b9bc50',
							'name'			=> 'hamburger',
							'label'			=> 'Hamburger',
							'display'		=> 'block',
							'sub_fields'	=> array(
							),
						),
						'layout_639702d709108'	=> array(
							'key'			=> 'layout_639702d709108',
							'name'			=> 'cart',
							'label'			=> __('Cart','hap'),
							'display'		=> 'block',
							'sub_fields'	=> array(
							),
						),
					),
					'button_label'			=> __('Add item','hap'),
				),
				// Footer
				array(
					'key'				=> 'field_60d09dd26dee0',
					'label'				=> 'Footer',
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-footer',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_7c6xd8c6632',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-footer',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can set the patterns to be used in footer and other info displayed in the footer.','hap'),
				),
				array(
					'key'				=> 'field_60d09ddd6dee1',
					'label'				=> __('Footer patterns','hap'),
					'name'				=> 'footer_common_blocks',
					'type'				=> 'post_object',
					'post_type'			=> array(
						0	=> 'wp_block',
					),
					'allow_null'		=> 1,
					'multiple'			=> 1,
					'return_format'		=> 'id',
					'ui'				=> 1,
				),
				array(
					'key'				=> 'field_63fe8bc6a4bbf',
					'label'				=> __('Hide credit in footer','hap'),
					'name'				=> 'hide_credit',
					'type'				=> 'true_false',
					'ui_on_text'		=> __('Hide','hap'),
					'ui_off_text'		=> __('Show','hap'),
					'ui'				=> 1,
				),
				array(
					'key'				=> 'field_60ddee009dd26',
					'label'				=> __('Page 404','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-404',
						'id'	=> 'tab-id-404',
					),
				),
				array(
					'key'				=> 'field_xd8c6637c62',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-404',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can set the pattern to be used in 404 page.','hap'),
				),
				array(
					'key'				=> 'field_60d6de09ddde1',
					'label'				=> __('404 Pattern','hap'),
					'name'				=> 'common_block_404',
					'type'				=> 'post_object',
					'post_type'			=> array(
						0	=> 'wp_block',
					),
					'allow_null'		=> 1,
					'return_format'		=> 'id',
					'ui'				=> 1,
				),
				array(
					'key'				=> 'field_5e6ffdd659d4e',
					'label'				=> __('Archives','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-archives',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_5e6fgded59d4f',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-archives',
						'id'	=> '',
					),
					'message'			=> sprintf( __('Enable or disable archives (author, date, category, tag). Some of these options are available also in <a href="%s" rel="noopener noreferrer nofollow" target="_blank">Yoast Seo plugin</a>.','hap'), get_admin_url() . 'admin.php?page=wpseo_titles#top#archives' ),
				),
				array(
					'key'				=> 'field_5e6ffe4a59d52',
					'label'				=> __('Archive by date','hap'),
					'name'				=> 'disable_date_archive',
					'type'				=> 'true_false',
					'instructions'		=> sprintf( __('Enable or disable archives by date. <br><a href="%s">Example</a>','hap' ), get_home_url() . '/' . date('Y') . '/' . date('m') ),
					'default_value'		=> 1,
					'ui'				=> 1,
					'ui_on_text'		=> __('Off','hap'),
					'ui_off_text'		=> __('On','hap'),
				),	
				array(
					'key'				=> 'field_5e6ffded59d4f',
					'label'				=> __('Archive by author','hap'),
					'name'				=> 'disable_author_archive',
					'type'				=> 'true_false',
					'instructions'		=> sprintf( __('Enable or disable archives by author. <br><a href="%s">Example</a>','hap' ), get_author_posts_url( get_current_user_id() ) ),
					'default_value'		=> 1,
					'ui'				=> 1,
					'ui_on_text'		=> __('Off','hap'),
					'ui_off_text'		=> __('On','hap'),
				),
				array(
					'key'				=> 'field_5e6ffe1e59d50',
					'label'				=> __('Category archive','hap'),
					'name'				=> 'disable_category_archive',
					'type'				=> 'true_false',
					// !!! To be fixed 'instructions'		=> sprintf( __('Enable or disable category terms archives. <br><a href="%s">Example</a>','hap' ), get_term_link( get_option('default_category') ) ),
					'ui'				=> 1,
					'ui_on_text'		=> __('Off','hap'),
					'ui_off_text'		=> __('On','hap'),
				),
				array(
					'key'				=> 'field_5e6ffe3d59d51',
					'label'				=> __('Tag archive','hap'),
					'name'				=> 'disable_tag_archive',
					'type'				=> 'true_false',
					'instructions'		=> __('Enable or disable tag terms archives.','hap' ),
					'ui'				=> 1,
					'ui_on_text'		=> __('Off','hap'),
					'ui_off_text'		=> __('On','hap'),
				),
				array(
					'key'				=> 'field_63a37e66cc571',
					'label'				=> __('Maps','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-maps',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_63a37e73cc572',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-maps',
						'id'	=> '',
					),
					'message'			=> __('API Keys and styles of Google Maps.','hap'),
				),
				array(
					'key'				=> 'field_60804d982329c',
					'label'				=> __('Google Maps Api Key','hap'),
					'name'				=> 'google_maps_api_key',
					'type'				=> 'text',
					'instructions'		=> __('The Google Map API KEY used to display the map in both backend and frontend.','hap'),
				),
				array(
					'key'				=> 'field_98082604d329c',
					'label'				=> __('Google Maps Api Key 2 (Used only for web service)','hap'),
					'name'				=> 'google_maps_api_key_web_service',
					'type'				=> 'text',
					'instructions'		=> __('The Google Map API KEY used to retrieve info about a place and save it into an ACF map field. This key is different form the previous key because it must have set IP address as restriction (previous key use http referrer as restriction). Places API must be activated for this key.','hap'),
				),
				array(
					'key'				=> 'field_6f980813f04a7',
					'label'				=> __('Google Map color light','hap'),
					'name'				=> 'map_color_light',
					'type'				=> 'color_picker',
					'instructions'		=> __('Set the lighter color of the customized Google Map.','hap'),
				),
				array(
					'key'				=> 'field_613ff980804a7',
					'label'				=> __('Google Map color dark','hap'),
					'name'				=> 'map_color_dark',
					'type'				=> 'color_picker',
					'instructions'		=> __('Set the darker color of the customized Google Map.','hap'),
				),
				array(
					'key'				=> 'field_60ad75880f643',
					'label'				=> __('Google Maps Style','hap'),
					'name'				=> 'google_maps_style',
					'type'				=> 'textarea',
					'instructions'		=> __('This field accepts a Google Maps JSON style. This option will overwrite the two previous settings (Google Map color light and Google Map color dark).','hap'),
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_5d7a69dcce82f',
					'label'				=> __('Map marker','hap'),
					'name'				=> 'google_maps_marker',
					'type'				=> 'image',
					'instructions'		=> __('Upload a PNG image to be used as default map marker in Google Maps.','hap'),
					'return_format'		=> 'url',
					'preview_size'		=> 'thumbnail',
					'library'			=> 'all',
					'min_width'			=> 48,
					'min_height'		=> 48,
					'max_width'			=> 48,
					'max_height'		=> 48,
					'mime_types'		=> 'png',
				),
				// Privacy GDPR
				array(
					'key'				=> 'field_1szdnpq6nvs6nn1o',
					'label'				=> __('Privacy GDPR','hap'),
					'type'				=> 'accordion',
					'instructions'		=> '',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-privacy',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_c07897c6xd8',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-privacy',
						'id'	=> '',
					),
					'message'			=> __('Set cookie and privacy policy pages.','hap'),
				),
				array(
					'key'				=> 'field_60804ef63743b',
					'label'				=> __('Cookie Policy Page','hap'),
					'name'				=> 'cookie_policy_page',
					'type'				=> 'post_object',
					'instructions'		=> sprintf( __('In case of new tracking scripts see <a target="_blank" rel="noopener noreferrer nofollow" href="%s">this page</a>.','hap'), 'https://www.iubenda.com/it/help/674-tagging-manuale-blocco-cookie'),
					'required'			=> 1,
					'post_type'			=> array(
						0		=> 'page',
					),
					'return_format'		=> 'id',
					'ui'				=> 1,
				),
				array(
					'key'				=> 'field_60804ef63521z',
					'label'				=> __('Privacy Policy Page','hap'),
					'name'				=> 'privacy_policy_page',
					'type'				=> 'post_object',
					'required'			=> 1,
					'post_type'			=> array(
						0		=> 'page',
					),
					'return_format'		=> 'id',
					'ui'				=> 1,
				),
				// Custom post types
				array(
					'key'				=> 'field_63a02f18a3b11',
					'label'				=> __('Custom post types','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-cpt',
						'id'	=> '',
					),
				),
				array(
					'key'			=> 'field_63a02f29a3b12',
					'label'			=> 'About',
					'type'			=> 'message',
					'wrapper'		=> array(
						'width'	=> '',
						'class'	=> 'about about-cpt',
						'id'	=> '',
					),
					'message'		=> __('Activate custom post types.','hap'),
				),
				array(
					'key'			=> 'field_63a02e8aa5414',
					'label'			=> __('Stores','hap'),
					'name'			=> 'cpt_store',
					'type'			=> 'true_false',
					'ui_on_text'	=> __('On','hap'),
					'ui_off_text'	=> __('Off','hap'),
					'ui'			=> 1,
				),
                // CSS			
				array(
					'key'				=> 'field_9bbd3637ca749',
					'label'				=> 'CSS',
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-css',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_ze7cab73a37c7',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-css',
						'id'	=> '',
					),
					'message'			=> __('Some options for handling CSS during development.','hap'),
					'new_lines'			=> 'wpautop',
				),
				array(
					'key'				=> 'field_064860a7b4ced',
					'label'				=> __('Custom CSS file','hap'),
					'name'				=> 'custom_css',
					'type'				=> 'true_false',
					'instructions'		=> __('To be used only if you don\'t have access to scss file system.','hap') . '<br><a target="_blank" rel="noopener noreferrer nofollow" href="' . HAP_PROJECT_CSS_URI . 'custom.css">custom.css</a>.',
					'ui'				=> 1,
					'ui_on_text'		=> __('On','hap'),
					'ui_off_text'		=> __('Off','hap'),
				),
				array(
					'key'				=> 'field_60804c4f4b6ec',
					'label'				=> __('CSS inline','hap'),
					'name'				=> 'css_inline',
					'type'				=> 'textarea',
					'instructions'		=> __('To be used only if you don\'t have access to scss file system.','hap') . '<br><a target="_blank" rel="noopener noreferrer nofollow" href="' . HAP_PROJECT_CSS_URI . 'custom.css">custom.css</a>.',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
				),                
				// Login style
				array(
					'key'				=> 'field_600804969d083',
					'label'				=> __('Login','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-login',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_667ca804a8',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-login',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can add custom styles for the login page.','hap'),
					'esc_html'			=> 0,
				),
				array(
					'key' 				=> 'field_614d90be6b105',
					'label'				=> __('Login page custom CSS','hap'),
					'name'				=> 'login_style_css',
					'type'				=> 'textarea',
					'instructions'		=> __('Font fields and color fields are used to automatically generate custom styles for the login page. You can add more CSS rules here if needed.','hap'),
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
					'rows'				=> 4,
				),
			),
			'location'=> array(
				array(
					array(
						'param'		=> 'options_page',
						'operator'	=> '==',
						'value'		=> 'options-layout',
					),
				),
			),
			'menu_order'			=> 0,
			'position'				=> 'normal',
			'style'					=> 'default',
			'label_placement'		=> 'left',
			'instruction_placement'	=> 'field',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> __('General layout settings for Mkt Theme.','hap'),
		));
		
		// Options page: Monitoring
		acf_add_local_field_group(array(
			'key'					=> 'group_63a049df0b296',
			'title'					=> __('Monitoring','hap'),
			'fields'				=> array(
				array(
					'key'				=> 'field_60804ce668ca8',
					'label'				=> __('Inline scripts','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-scripts',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_c0c6aa84867',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-scripts',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can add custom scripts in three different positions. Useful for monitoring codes like Google Analytics.','hap'),
				),
				array(
					'key'				=> 'field_60804cfb68ca9',
					'label'				=> __('Scripts before &lt;/head&gt;','hap'),
					'name'				=> 'scripts_head',
					'type'				=> 'textarea',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_u2zvo9fnjebbiidj',
					'label'				=> __('Scripts after &lt;body&gt;','hap'),
					'name'				=> 'scripts_body',
					'type'				=> 'textarea',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_60804d0a68caa',
					'label'				=> 'Scripts before &lt;/body&gt;',
					'name'				=> 'scripts_footer',
					'type'				=> 'textarea',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_60913f4fe13f2',
					'label'				=> 'Jquery Migrate',
					'name'				=> 'script_jquery_migrate',
					'type'				=> 'true_false',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
					'ui'				=> 1,
					'ui_on_text'		=> __('On','hap'),
					'ui_off_text'		=> __('Off','hap'),
				),
				/*
				array(
					'key' => 'field_60913efee13f1',
					'label' => 'Paroller',
					'name' => 'script_paroller',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'hap-code',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Active',
					'ui_off_text' => 'Inactive',
				),
				array(
					'key' => 'field_60913f64e13f3',
					'label' => 'Lottie',
					'name' => 'script_lottie',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'hap-code',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Active',
					'ui_off_text' => 'Inactive',
				),
				array(
					'key' => 'field_60913f76e13f4',
					'label' => 'List',
					'name' => 'script_list',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'hap-code',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Active',
					'ui_off_text' => 'Inactive',
				),
				*/
				array(
					'key'				=> 'field_60804d4623299',
					'label'				=>__('Google Tools','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-google',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_c0c6xd87897',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-google',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can set options for Google Analytics and Google Maps.','hap'),
				),
				array(
					'key'				=> 'field_60804d5e2329a',
					'label'				=> __('Google Analytics ID','hap'),
					'name'				=> 'google_analytics_id',
					'type'				=> 'text',
					'instructions'		=> __('The ID of the Google Analytics account associated with this domain.','hap'),
				),
				array(
					'key'				=> 'field_63b9c71907026',
					'label'				=> __('Google Tag Manager ID','hap'),
					'name'				=> 'google_tag_manager_id',
					'type'				=> 'text',
					'instructions'		=> __('The ID of the Google Tag Manager account associated with this domain.','hap'),
				),
				array(
					'key'				=> 'field_qig03gdw7ih686yf',
					'label'				=> __('Ip Anonymizer','hap'),
					'name'				=> 'google_analytics_ip_anonymizer',
					'type'				=> 'true_false',
					'instructions'		=> __('Toggle anonymize IP (this option will likely be deprecated starting with version 4 of Google Analytics).','hap'),
					'default_value'		=> 1,
					'ui'				=> 1,
					'ui_on_text'		=> __('On','hap'),
					'ui_off_text'		=> __('Off','hap'),
				),
				array(
					'key'				=> 'field_60804dc6b18c8',
					'label'				=> __('Facebook Tools','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-facebook',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_68704a6cac8',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-facebook',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can set Facebook Pixel Id and Facebook App id.','hap'),
				),
				array(
					'key'				=> 'field_60804dd1b18c9',
					'label'				=> 'Facebook Pixel ID',
					'name'				=> 'facebook_pixel_id',
					'type'				=> 'text',
				),
				array(
					'key'				=> 'field_60804de8b18ca',
					'label'				=> 'Facebook App ID',
					'name'				=> 'facebook_app_id',
					'type'				=> 'text',
				),
			),
			'location'				=> array(
				array(
					array(
						'param'		=> 'options_page',
						'operator'	=> '==',
						'value'		=> 'options-other',
					),
				),
			),
			'menu_order'			=> 0,
			'position'				=> 'normal',
			'style'					=> 'default',
			'label_placement'		=> 'left',
			'instruction_placement'	=> 'field',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
			'show_in_rest'			=> 0,
		));
		
		// Options page: Site mode
		acf_add_local_field_group(array(
			'key'					=> 'group_63a41e99c4964',
			'title'					=> __('Site mode','hap'),
			'fields'				=> array(
				// Staging
				array(
					'key'				=> 'field_63a423d4f1049',
					'label'				=> __('Staging','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-staging',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_63a423d3f1048',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-staging',
						'id'	=> '',
					),
					'message'			=> __('You can use this option to make conditionally changes based on production/staging status.','hap'),
				),
				array(
					'key'				=> 'field_680a7064b4ced',
					'label'				=> 'Staging',
					'name'				=> 'staging',
					'type'				=> 'true_false',
					'instructions'		=> __('Enable if this is a staging site.','hap'),
					'ui'				=> 1,
					'ui_on_text'		=> __('On','hap'),
					'ui_off_text'		=> __('Off','hap'),
				),
				// Maintenance Mode
				array(
					'key'				=> 'field_63a41e99c4503',
					'label'				=> __('Maintenance Mode','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-maintenance',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_63ae99c454103',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-maintenance',
						'id'	=> '',
					),
					'message'			=> __('In this tab you can activate the maintenance mode. This is useful when you have to work on the website and want to restrict access to users.','hap'),
				),
				array(
					'key'				=> 'field_60804ef636328',
					'label'				=> __('Maintenance Mode','hap'),
					'name'				=> 'maintenance_mode',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_60804ef636329',
							'label'				=> __('Maintenance Mode','hap'),
							'name'				=> 'maintenance_mode_option',
							'type'				=> 'true_false',
							'default_value'		=> 0,
							'ui'				=> 1,
						'ui_on_text'		=> __('On','hap'),
						'ui_off_text'		=> __('Off','hap'),
						),
						array(
                            'key'               => 'field_6660ef72ba706',
                            'label'             => __('Custom pattern','hap'),
                            'name'              => 'maintenance_custom_content',
							'type'				=> 'post_object',
                            'return_format'     => 'id',
                            'relevanssi_exclude' => 1,
							'ui'				=> 1,
                            'allow_null'	    => 1,
                            'instructions'      => __('Select a custom pattern if you don\'t want to show the default content.','hap'),
							'conditional_logic' => array(
								array(
									array(
										'field'		=> 'field_60804ef636329',
										'operator'	=> '==',
										'value'		=> '1',
									),
								),
							),
							'post_type'			=> array(
								0		=> 'wp_block',
							),
						),
                        array(
                            'key'               => 'field_6660ef11d823c',
                            'label'             => __('Excluded posts','hap'),
                            'name'              => 'maintenance_excluded_posts',
                            'type'              => 'relationship',
                            'instructions'      => __('Cookie and privacy pages are excluded by default. Add any other pages you want to exclude.','hap'),
                            'relevanssi_exclude' => 1,
                            'post_status'       => array(
                                0 => 'publish',
                            ),
                            'filters'           => array(
                                0 => 'search',
                                1 => 'post_type',
                                2 => 'taxonomy',
                            ),
                            'return_format'     => 'id',
							'conditional_logic'	=> array(
								array(
									array(
										'field'		=> 'field_60804ef636329',
										'operator'	=> '==',
										'value'		=> '1',
									),
								),
							),
                        ),
						array(
							'key'				=> 'field_608053d33632b',
							'label'				=> __('Token','hap'),
							'name'				=> 'token',
							'type'				=> 'text',
                            'instructions'      => sprintf(__('Enter a token of at least 8 alphanumeric characters and use it to bypass maintenance mode. Visit any page by adding the <strong>skip_token</strong> parameter with the token value as in  <a target="blank" rel="noopener noreferrer nofollow" href="%s">this example</a>.','hap'),esc_url(add_query_arg('skip_token','1234abcd',home_url()))),
							'conditional_logic'	=> array(
								array(
									array(
										'field'		=> 'field_60804ef636329',
										'operator'	=> '==',
										'value'		=> '1',
									),
								),
							),
                            'min'               => 8,
						),
						array(
							'key'				=> 'field_60804ef63632a',
							'label'				=> '<strong class="text-error">' . __('Deprecated','hap') . ' ' . __('Maintenance Mode Page','hap') . '</strong>',
							'name'				=> 'maintenance_mode_page',
							'type'				=> 'post_object',
							'conditional_logic' => array(
								array(
									array(
										'field'		=> 'field_60804ef636329',
										'operator'	=> '==',
										'value'		=> '1',
									),
								),
							),
							'post_type'			=> array(
								0		=> 'page',
							),
							'return_format'		=> 'id',
							'ui'				=> 1,
						),
					),
				),
			),
			'location'				=> array(
				array(
					array(
						'param'		=> 'options_page',
						'operator'	=> '==',
						'value'		=> 'options-other',
					),
				),
			),
			'menu_order'			=> 4,
			'position'				=> 'normal',
			'style'					=> 'default',
			'label_placement'		=> 'left',
			'instruction_placement'	=> 'field',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
			'show_in_rest'			=> 0,
		));
				
		// Options page: Plugins
		acf_add_local_field_group(array(
			'key'					=> 'group_63a3efd217c3b',
			'title'					=> __('Plugins','hap'),
			'fields'				=> array(
				// Plugin optimization
				array(
					'key'				=> 'field_63a239efaff80',
					'label'				=> 'Contact Form 7',
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-plugin-cf7',
						'id'	=> '',
					),
				),
				array(
					'key'		=> 'field_63a23a09aff81',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-plugin-cf7',
						'id'	=> '',
					),
					'message'			=> ( is_cf7_activated() ) ? sprintf(__('Additional options. See also the <a target="_blank" rel="noopener noreferrer nofollow" href="%s">shortcodes page</a> for other customizations.','hap'),esc_url(add_query_arg('page','hap-shortcodes',admin_url('admin.php#cf-7')))) : __('<strong class="text-error">Plugin not found.</strong>','hap'),
				),
				array(
					'key'			=> 'field_63a23909e5a9e',
					'label'			=> __('Plugin optimization','hap'),
					'name'			=> 'optimization_contact_form_7',
					'type'			=> 'group',
					'layout'		=> 'block',
					'instructions'	=>	__('Plugin assets are disabled globally to improve performance. The Contact Form 7 shortcode is automatically detected when included in the content of a post via the backend post editor. In these cases the assets are requeued. If you use the "do_shortcode" function within templates you need to set which post, post type or template it is used in.','hap'),
					'sub_fields'	=> array(
						array(
							'key'			=> 'field_63a238676a355',
							'label'			=> __('Post included','hap'),
							'name'			=> 'optimization_contact_form_7_post_ids',
							'type'			=> 'relationship',
							'filters'		=> array(
								0	=> 'search',
								1	=> 'post_type',
								2	=> 'taxonomy',
							),
                            'post_status'       => array(
                                0 => 'publish',
                            ),
							'return_format'	=> 'id',
							'instructions'	=>	__('Include Contact Form 7 assets only in these posts.','hap'),
						),
						array(
							'key'			=> 'field_63a237ed6a354',
							'label'			=> __('Post types included','hap'),
							'name'			=> 'optimization_contact_form_7_post_types',
							'type'			=> 'select',
							'choices'		=> [],
							'return_format'	=> 'value',
							'multiple'		=> 1,
							'allow_null'	=> 1,
							'instructions'	=>	__('Include Contact Form 7 assets only in these post types.','hap'),
						),
						array(
							'key'			=> 'field_63ad6a3237e54',
							'label'			=> __('Templates included','hap'),
							'name'			=> 'optimization_contact_form_7_templates',
							'type'			=> 'select',
							'choices'		=> hap_get_all_templates(),
							'return_format'	=> 'value',
							'multiple'		=> 1,
							'allow_null'	=> 1,
							'instructions'	=>	__('Include Contact Form 7 assets only in these templates.','hap'),
						),
					),
				),
				// WPML
				array(
					'key'		=> 'field_63a35916875c2',
					'label'		=> 'WPML',
					'type'		=> 'accordion',
					'wrapper'	=> array(
						'width'	=> '',
						'class'	=> 'accordion-plugin-wpml',
						'id'	=> '',
					),
				),
				array(
					'key'		=> 'field_63a35922875c3',
					'label'		=> __('About','hap'),
					'type'		=> 'message',
					'wrapper'	=> array(
						'width'	=> '',
						'class'	=> 'about about-plugin-wpml',
						'id'	=> '',
					),
					'message'			=> ( is_wpml_activated() ) ? __('Additional options.','hap') : __('<strong class="text-error">Plugin not found.</strong>','hap'),
				),
				array(
					'key'				=> 'field_63f3b7d61c6c6',
					'label'				=> 'WPML',
					'name'				=> 'wpml',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_621fa06432ae0',
							'label'				=> __('Append link in WPML lang switcher','hap'),
							'name'				=> 'append_link_wpml_switcher',
							'type'				=> 'link',
							'return_format'		=> 'array',
						),
					),
					'instructions'		=>	__('This option allows you to add a link to a language that is not supported by WPML, such as a language that is located in a subfolder, subdomain or other domain.','hap')
				),
				// DK PDF
				array(
					'key'				=> 'field_637caf54cce3a',
					'label'				=> 'DK PDF',
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-plugin-dk-pdf',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_6804aac867c',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-plugin-dk-pdf',
						'id'	=> '',
					),
					'message'			=> ( is_dkpdf_activated() ) ? __('Additional options.','hap') : __('<strong class="text-error">Plugin not found.</strong>','hap'),
				),
				array(
					'key'				=> 'field_637d61c6f3bc6',
					'label'				=> 'DK PDF',
					'name'				=> 'dk_pdf',
					'type'				=> 'group',
					'layout'			=> 'block',
					'sub_fields'		=> array(
						array(
							'key'				=> 'field_637d61ddf3bc7',
							'label'				=> __('Heading font','hap'),
							'name'				=> 'pdf_font_one',
							'type'				=> 'file',
							'instructions'		=> __('Upload the font to be used for PDF headings. Only TTF files are allowed.','hap'),
							'return_format'		=> 'array',
							'library'			=> 'all',
							'mime_types'		=> 'ttf',
						),
						array(
							'key'				=> 'field_637d6204f3bc8',
							'label'				=> __('Body font','hap'),
							'name'				=> 'pdf_font_two',
							'type'				=> 'file',
							'instructions'		=> __('Upload the font to be used for PDF bodycopy. Only TTF files are allowed.','hap'),
							'return_format'		=> 'array',
							'library'			=> 'all',
							'mime_types'		=> 'ttf',
						),
						array(
							'key'				=> 'field_637d6215f3bc9',
							'label'				=> __('Filename prefix','hap'),
							'name'				=> 'pdf_filename',
							'type'				=> 'text',
							'instructions'		=> __('The text to be used as a prefix for PDF files. No space allowed. Example of filename output: <br>prefix-post-title.pdf.','hap'),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'		=> 'options_page',
						'operator'	=> '==',
						'value'		=> 'options-other',
					),
				),
			),
			'menu_order'			=> 6,
			'position'				=> 'normal',
			'style'					=> 'default',
			'label_placement'		=> 'left',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
			'show_in_rest'			=> 0,
		));
		
		// Options page: Other options
		acf_add_local_field_group(array(
			'key'					=> 'group_63a41eb01e371',
			'title'					=> __('Other options','hap'),
			'fields'				=> array(
				// Email notifications
				array(
					'key'				=> 'field_61acd967143c3',
					'label'				=> __('Email notifications','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-email',
						'id'	=> '',
					),
				),
				array(
					'key'				=> 'field_6233385b6250f',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-email',
						'id'	=> '',
					),
					'message'			=> __('In this tab there are options useful if you are using custom email notifications sent directly form the website.','hap'),
				),
				array(
					'key'				=> 'field_62362503385bf',
					'label'				=> __('Email sender (name)','hap'),
					'name'				=> 'email_from_name',
					'type'				=> 'text',
					'instructions'		=> __('Set the name to be used in email header "from" field.','hap'),
					'default_value'		=> get_option( 'blogname' ),
					'placeholder'		=> __('Ex:','hap') . ' ' . get_option( 'blogname' ),
				),
				array(
					'key'				=> 'field_6236251c385c0',
					'label'				=> __('Email sender (email)','hap'),
					'name'				=> 'email_from',
					'type'				=> 'email',
					'instructions'		=> __('Set the email to be used in email header "from" field. The email must have the same domain of the website to avoid spam filters.','hap'),
					'placeholder'		=> __('Ex:','hap') . ' info@' . hap_url_label( get_site_url() ),
				),
				array(
					'key'				=> 'field_623625b4385c3',
					'label'				=> __('Reply to (name)','hap'),
					'name'				=> 'reply_to_name',
					'type'				=> 'text',
					'instructions'		=> __('Set the name to be used in email header "reply-to" field.','hap'),
					'placeholder'		=> __('Ex:','hap') . ' Arthur Dent',
				),
				array(
					'key'				=> 'field_62362577385c2',
					'label'				=> __('Reply to (email)','hap'),
					'name'				=> 'reply_to_email',
					'type'				=> 'email',
					'instructions'		=> __('Set the email to be used in email header "reply-to" field.','hap'),
					'placeholder'		=> __('Ex:','hap') . ' arthur.dent@galaxy.com',
				),
				array(
					'key'				=> 'field_62362565385c1',
					'label'				=> __('Notifications recipients','hap'),
					'name'				=> 'recipients',
					'type'				=> 'text',
					'instructions'		=> __('Set one or more emails separated by commas. These are the emails notifications are sent to.','hap'),
					'placeholder'		=> __('Ex:','hap') . ' ford.perfect@galaxy.com, marvin@galaxy.com',
				),
        		array(
					'key'				=> 'field_6232a08ae3823',
					'label'				=> __('Email disclaimer','hap'),
					'name'				=> 'email_disclaimer',
					'type'				=> 'textarea',
					'instructions'		=> '<strong>' . __('You can use this text as a starting point','hap') . '</strong><br>' . __('This e-mail and its attachments may contain confidential information only for the Recipient specified in the address. The information transmitted through this e-mail and its attachments are intended exclusively for the recipient and must be considered confidential with a ban on dissemination and use unless expressly authorized. If this e-mail and its attachments have been received by mistake from a person other than the addressee, please destroy everything received and inform the sender by the same means. Any use, disclosure or unauthorized copy of this communication is strictly prohibited and involves a violation of the provisions of the Law on the protection of personal data European Regulation 2016/679.','hap'),
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
					'default_value'		=> __('This e-mail and its attachments may contain confidential information only for the Recipient specified in the address. The information transmitted through this e-mail and its attachments are intended exclusively for the recipient and must be considered confidential with a ban on dissemination and use unless expressly authorized. If this e-mail and its attachments have been received by mistake from a person other than the addressee, please destroy everything received and inform the sender by the same means. Any use, disclosure or unauthorized copy of this communication is strictly prohibited and involves a violation of the provisions of the Law on the protection of personal data European Regulation 2016/679.','hap'),
				),
			),
			'location'					=> array(
				array(
					array(
						'param'		=> 'options_page',
						'operator'	=> '==',
						'value'		=> 'options-other',
					),
				),
			),
			'menu_order'				=> 5,
			'position'					=> 'normal',
			'style'						=> 'default',
			'label_placement'			=> 'left',
			'instruction_placement'		=> 'field',
			'hide_on_screen'			=> '',
			'active'					=> true,
			'description'				=> '',
			'show_in_rest'				=> 0,
		));

        // Theme license and updates
        acf_add_local_field_group( array(
            'key'                       => 'group_66634bd903f21',
            'title'                     => __('Theme license and updates','hap'),
            'fields'                    => array(
                array(
                    'key'           => 'field_66634bd903602',
                    'label'         => __('License key','hap'),
                    'name'          => 'hap_crm_key_uncrypted',
                    'type'          => 'text',
                    'instructions'  => __('Register your license to enable updates.','hap'),
                    'relevanssi_exclude' => 1,
                    'maxlength'     => 36,
                    'placeholder'   => __('36 Alphanumeric characters','hap'),
                ),
                array(
                    'key'           => 'field_66640b032c9f3',
                    'label'         => __('Update theme','hap'),
                    'name'          => 'hap_theme_update_option',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'relevanssi_exclude' => 1,
                    'default_value' => 0,
                    'ui_on_text'    => __('Update now','hap'),
                    'ui_off_text'   => __('Keep this version','hap'),
                    'ui'            => 1,
                ),         
            ),
            'location'                  => array(
                array(
                    array(
                        'param'     => 'options_page',
                        'operator'  => '==',
                        'value'     => 'options-other',
                    ),
                ),
            ),
            'menu_order'            => 99,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'left',
            'instruction_placement' => 'field',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'show_in_rest'          => 0,
        ));

		// Backend notes (only pages)
		acf_add_local_field_group(array(
			'key'					=> 'group_60c3857073aa8',
			'title'					=> 'Notes',
			'fields'				=> array(
				array(
					'key'				=> 'field_60c3859f5e17f',
					'label'				=> __('Notes','hap'),
					'name'				=> 'backend_notes',
					'type'				=> 'textarea',
					'new_lines'			=> 'br',
				),
			),
			'location'				=> array(
				array(
					array(
						'param'		=> 'post_type',
						'operator'	=> '==',
						'value'		=> 'post',
					),
				),
				array(
					array(
						'param'		=> 'post_type',
						'operator'	=> '==',
						'value'		=> 'page',
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
		));

		// Custom desktop navigation position (absolute, scroll or sticky) on pages 
		acf_add_local_field_group(array(
			'key'					=> 'group_60c15ea69cdcb',
			'title'					=> __('Desktop navigation','hap'),
			'fields'				=> array(
				array(
					'key'				=> 'field_60c15eb075d52',
					'label'				=> __('Desktop navigation','hap'),
					'name'				=> 'desktop_navigation',
					'type'				=> 'button_group',
					'choices'			=> array(
						'scroll-menu'	=> 'Scroll',
						'absolute-menu'	=> 'Absolute',
						'fixed-menu'	=> 'Fixed',
					),
					'layout'			=> 'horizontal',
					'return_format'		=> 'value',
				),
			),
			'location' => array(
				array(
					array(
						'param'		=> 'post_type',
						'operator'	=> '==',
						'value'		=> 'page',
					),
				),
			),
			'menu_order'			=> 0,
			'position'				=> 'side',
			'style'					=> 'default',
			'label_placement'		=> 'top',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
		));

		// Toggle navigation menu
		acf_add_local_field_group(array(
			'key'					=> 'group_63d14c9d374b8',
			'title'					=> __('Show/Hide navigation','hap'),
			'fields'				=> array(
				array(
					'key'			=> 'field_63d14c9dd4d4a',
					'label'			=> __('Show/Hide navigation','hap'),
					'name'			=> 'toggle_main_nav',
					'type'			=> 'true_false',
					'ui_on_text'	=> 'Show',
					'ui_off_text'	=> 'Hide',
					'ui'			=> 1,
				),
			),
			'location'				=> [
				[
					[
						'param'		=> 'post_type',
						'operator'	=> '!=',
						'value'		=> 'acf-field-group',
					],
				],
			],
			'menu_order'			=> 0,
			'position'				=> 'side',
			'style'					=> 'default',
			'label_placement'		=> 'top',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
			'show_in_rest'			=> 0,
		));

		// Featured icon (all cpts)
		acf_add_local_field_group([
			'key'					=> 'group_6179aa6250f5e',
			'title'					=> __('Featured Icon','hap'),
			'fields'				=> [
				[
					'key' => 'field_6179aa873bc51',
					'label'				=>  __('Featured Icon','hap'),
					'name'				=> 'featured_icon',
					'type'				=> 'image',
					'return_format'		=> 'id',
					'preview_size'		=> 'thumbnail',
					'library'			=> 'all',
					'mime_types'		=> 'svg,png,jpg',
				],
			],
			'location'				=> [
				[
					[
						'param'		=> 'post_type',
						'operator'	=> '!=',
						'value'		=> 'acf-field-group',
					],
				],
			],
			'menu_order'			=> 0,
			'position'				=> 'side',
			'style'					=> 'default',
			'label_placement'		=> 'top',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
		]);

		// Preload image
		acf_add_local_field_group(array(
			'key'					=> 'group_63bb6e94b4ce5',
			'title'					=> __('Preload image','hap'),
			'fields'				=> array(
				array(
					'key'			=> 'field_63bb6e958aa5e',
					'label'			=> __('Preload image','hap'),
					'name'			=> 'preload_image',
					'type'			=> 'image',
					'return_format'	=> 'id',
					'library'		=> 'all',
					'preview_size'	=> 'thumbnail',
				),
			),
			'location'				=> [
				[
					[
						'param'		=> 'post_type',
						'operator'	=> '!=',
						'value'		=> 'acf-field-group',
					],
				],
			],
			'menu_order'			=> 0,
			'position'				=> 'side',
			'style'					=> 'default',
			'label_placement'		=> 'top',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
			'show_in_rest'			=> 0,
		));
		
		// Maintenance mode (pages)
		acf_add_local_field_group(array(
			'key'					=> 'group_627a768c9a2bc',
			'title'					=> __('Maintenance mode for pages','hap'),
			'fields'				=> array(
				array(
					'key'				=> 'field_627a76a513a5a',
					'label'				=> __('Maintenance mode','hap'),
					'name'				=> 'page_maintenance_mode_toggle',
					'type'				=> 'true_false',
					'ui'				=> 1,
					'ui_on_text'		=> __('On','hap'),
					'ui_off_text'		=> __('Off','hap'),
					'instructions'		=> __('Hide page content and show a maintenance message.','hap'),
				),
				array(
					'key'				=> 'field_627a77ee13a5e',
					'label' 			=> __('Block','hap'),
					'name'				=> 'page_maintenance_mode_common_block',
					'type'				=> 'post_object',
					'post_type'			=> array(
						0	=> 'wp_block',
					),
					'return_format'		=> 'id',
					'allow_null'		=> 1,
					'ui'				=> 1,
					'instructions'		=> __('Select a block to override the default message.','hap'),
					'conditional_logic'	=> array(
						array(
							array(
								'field'		=> 'field_627a76a513a5a',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
				),
			),
			'location'				=> array(
				array(
					array(
						'param'		=> 'post_type',
						'operator'	=> '==',
						'value'		=> 'page',
					),
				),
			),
			'menu_order'			=> 0,
			'position'				=> 'normal',
			'style'					=> 'default',
			'label_placement'		=> 'left',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
		));
		
		acf_add_local_field_group(array(
			'key'					=> 'group_639bb4c48775d',
			'title'					=> __('Page Custom CSS','hap'),
			'fields'				=> array(
				array(
					'key'		=> 'field_639bb4c4e9403',
					'label'		=> __('Custom CSS','hap'),
					'name'		=> 'page_custom_css',
					'type'		=> 'textarea',
					'wrapper'	=> array(
						'width'	=> '',
						'class'	=> 'hap-code',
						'id'	=> '',
					),
				),
			),
			'location'				=> array(
				array(
					array(
						'param'		=> 'post_type',
						'operator'	=> '==',
						'value'		=> 'post',
					),
				),
				array(
					array(
						'param'		=> 'post_type',
						'operator'	=> '==',
						'value'		=> 'page',
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
		
		// Taxonomy fields
		acf_add_local_field_group([
			'key'		=> 'group_5c87a08a5f22d',
			'title'		=> __('Taxonomy Extra Fields','hap'),
			'fields'	=> [
				[
					'key'				=> 'field_80560e4c44309',
					'label'				=> __('Term options','hap'),
					'type'				=> 'accordion',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-options',
						'id'	=> '',
					),
				],
				[
					'key'				=> 'field_s6a68804ca7',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-options',
						'id'	=> '',
					),
					'message'			=> __('These fields can be used to add one or more of the following options to the term: order of appearance, colour, image and logo. The default header of the term shows only the title but it is possible to override it by filling in the fields of the "custom template" group or by selecting a block in "template block". In order, the "template block" overrides the "custom template" which in turn overrides the default template.','hap'),
				],
				[
					'key'				=> 'field_5d236465681f2',
					'label'				=> __('Menu order','hap'),
					'name'				=> 'menu_order',
					'type'				=> 'number',
					'instructions'		=> __('Set custom menu order for this term.','hap'),
					'placeholder'		=> __('Ex:','hap') . ' 3',
				],
				[
					'key'				=> 'field_6144b5fa7b6da',
					'label'				=> __('Color', 'hap'),
					'name'				=> 'term_color',
					'type'				=> 'color_picker',
					'instructions'		=> __('Select the color to associate with this term.','hap'),
				],
				[
					'key'				=> 'field_5c87a08a5f326',
					'label'				=> __('Featured image', 'hap'),
					'name'				=> 'term_featured_img',
					'type'				=> 'image',
					'return_format'		=> 'id',
					'preview_size'		=> 'thumbnail',
					'library'			=> 'all',
					'mime_types'		=> 'svg,jpg,png',
					'instructions'		=> __('Select the image to associate with this term.','hap'),
				],
				[
					'key'				=> 'field_5c87a08a5f360',
					'label'				=> __('Logo', 'hap'),
					'name'				=> 'term_logo',
					'type'				=> 'image',
					'return_format'		=> 'id',
					'preview_size'		=> 'thumbnail',
					'library'			=> 'all',
					'mime_types'		=> 'svg',
					'instructions'		=> __('Select the logo to associate with this term (SVGs only).','hap'),
				],
				// Custom term template
				[
					'key'				=> 'field_0e4c480564309',
					'label'				=> __('Custom template','hap'),
					'type'				=> 'accordion',
					'instructions'		=> '',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-template',
						'id'	=> '',
					),
				],
				[
					'key'				=> 'field_c804a687ca6',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-template',
						'id'	=> '',
					),
					'message'			=> __('Optional fields for the term template header.','hap'),
				],
				[
					'key'				=> 'field_5c87a08a5f272',
					'label'				=> __('Top title', 'hap'),
					'name'				=> 'toptitle',
					'type'				=> 'text',
					'placeholder'		=> __('Ex: News','hap'),
				],
				[
					'key'				=> 'field_5c87a08a5f2af',
					'label'				=> __('Title', 'hap'),
					'name'				=> 'title',
					'type'				=> 'text',
					'placeholder'		=> __('Ex: Company News','hap'),
				],
				[
					'key'				=> 'field_5c87a08a5f2eb',
					'label'				=> __('Subtitle', 'hap'),
					'name'				=> 'subtitle',
					'type'				=> 'text',
					'placeholder'		=> __('Ex: All the news about this company','hap'),
				],
				[
					'key'				=> 'field_616ed892681b3',
					'label'				=> __('Gallery', 'hap'),
					'name'				=> 'term_gallery',
					'type'				=> 'gallery',
					'return_format'		=> 'id',
					'preview_size'		=> 'thumbnail',
					'insert'			=> 'append',
					'library'			=> 'all',
					'mime_types'		=> 'svg,jpg,png',
				],
				// Block term template
				[
					'key'				=> 'field_63b05e2cadb59',
					'label'				=> __('Block template','hap'),
					'type'				=> 'accordion',
					'instructions'		=> '',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'accordion-block',
						'id'	=> '',
					),
				],
				[
					'key'				=> 'field_63b05e3aadb5e',
					'label'				=> __('About','hap'),
					'type'				=> 'message',
					'wrapper'			=> array(
						'width'	=> '',
						'class'	=> 'about about-block',
						'id'	=> '',
					),
					'message'			=> __('Choose a block to use as a header in the term template.','hap'),
				],
				[
					'key'				=> 'field_6399a1ea1ac34',
					'label' 			=> __('Term block','hap'),
					'name'				=> 'term_common_block',
					'type'				=> 'post_object',
					'post_type'			=> array(
						0	=> 'wp_block',
					),
					'return_format'		=> 'id',
					'allow_null'		=> 1,
					'ui'				=> 1,
				],
			],
			'location'				=> [
				[
					[
						'param'		=> 'taxonomy',
						'operator'	=> '==',
						'value'		=> 'all',
					],
				],
			],
			'menu_order'			=> 0,
			'position'				=> 'normal',
			'style'					=> 'default',
			'label_placement'		=> 'top',
			'instruction_placement'	=> 'label',
			'hide_on_screen'		=> '',
			'active'				=> true,
			'description'			=> '',
		]);	
		
		// Menu item fields
		acf_add_local_field_group( array(
			'key'					=> 'group_63f4c53d956c2',
			'title'					=> __('Menu item','hap'),
			'fields'				=> array(
				array(
					'key'			=> 'field_63f4c53d245c0',
					'label'			=> __('Image','hap'),
					'name'			=> 'image',
					'type'			=> 'image',
					'return_format'	=> 'id',
					'library'		=> 'all',
					'min_width'		=> '',
					'min_height'	=> '',
					'min_size'		=> '',
					'max_width'		=> '',
					'max_height'	=> '',
					'max_size'		=> '',
					'mime_types'	=> 'svg,png,jpg,jpeg',
					'preview_size'	=> 'medium',
				),
			),
			'location'				=> array(
				array(
					array(
						'param'		=> 'nav_menu_item',
						'operator'	=> '==',
						'value'		=> 'all',
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
		
		// Options available only to Hap Users
		acf_add_local_field_group( array(
			'key'					=> 'group_64d089327b3cb',
			'title'					=> __('Hap user options','hap'),
			'fields'				=> array(
				array(
					'key'					=> 'field_64d089326b102',
					'label'					=> __('Footer tools on frontend','hap'),
					'name'					=> 'hap_footer',
					'type'					=> 'true_false',
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b4a5d2337',
					'label'					=> __('Edit','hap'),
					'name'					=> 'hap_footer_edit',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b4d0d2338',
					'label'					=> 'Debug',
					'name'					=> 'hap_footer_debug',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b54ed2339',
					'label'					=> __('Notes','hap'),
					'name'					=> 'hap_footer_notes',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b583d233a',
					'label'					=> 'Post meta',
					'name'					=> 'hap_footer_post_meta',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b595d233b',
					'label'					=> __('Search','hap'),
					'name'					=> 'hap_footer_search',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b5add233c',
					'label'					=> __('Notices','hap'),
					'name'					=> 'hap_footer_notices',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b5c4d233d',
					'label'					=> 'SEO',
					'name'					=> 'hap_footer_seo',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b5e56215a',
					'label'					=> __('Hap theme options','hap'),
					'name'					=> 'hap_footer_theme_options',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b6156215b',
					'label'					=> __('Scripts','hap'),
					'name'					=> 'hap_footer_scripts',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b61c6215c',
					'label'					=> __('Styles','hap'),
					'name'					=> 'hap_footer_styles',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),
				array(
					'key'					=> 'field_64d0b66b6215d',
					'label'					=> __('Page load','hap'),
					'name'					=> 'hap_footer_page_load',
					'type'					=> 'true_false',
					'conditional_logic' => array(
						array(
							array(
								'field'		=> 'field_64d089326b102',
								'operator'	=> '==',
								'value'		=> '1',
							),
						),
					),
					'relevanssi_exclude'	=> 1,
					'ui_on_text'			=> __('On','hap'),
					'ui_off_text'			=> __('Off','hap'),
					'ui'					=> 1,
				),	
			),
			'location'						=> array(
				array(
					array(
						'param'		=> 'user_role',
						'operator'	=> '==',
						'value'		=> 'administrator',
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

        // Post type: Stores
        acf_add_local_field_group(array(
            'key'		=> 'group_63973e6cc4eb7',
            'title'		=> __('Stores','hap'),
            'fields'	=> array(
                array(
                    'key'			=> 'field_63973e6cc9351',
                    'label'			=> __('Business Name','hap'),
                    'name'			=> 'store_name',
                    'type'			=> 'text',
                    'placeholder'		=> __('Publicly known business name or company name','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc9391',
                    'label'			=> __('Contact person','hap'),
                    'name'			=> 'store_referent',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex: John Doe','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc93cd',
                    'label'			=> __('Address (map)','hap'),
                    'name'			=> 'store_address',
                    'type'			=> 'google_map',
                    'center_lat'	=> '',
                    'center_lng'	=> '',
                ),
                array(
                    'key'			=> 'field_63b2c134167e4',
                    'label'			=> __('Address (custom)','hap'),
                    'name'			=> 'address_custom',
                    'type'			=> 'text',
                ),
                array(
                    'key'			=> 'field_63b2c207167e5',
                    'label'			=> __('Postcode','hap'),
                    'name'			=> 'store_postcode',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex:','hap') . ' 10100',
                ),
                array(
                    'key'			=> 'field_63b2c215167e6',
                    'label'			=> __('City','hap'),
                    'name'			=> 'store_city',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex: London','hap'),
                ),
                array(
                    'key'			=> 'field_63b2c239167e7',
                    'label'			=> __('Province','hap'),
                    'name'			=> 'store_province',
                    'type'			=> 'select',
                    'choices'		=> array(
                        'gino' => 'Geeno',
                        'pino' => 'Peeno',
                    ),
                    'allow_null'	=> 1,
                    'placeholder'	=> '',
                ),
                array(
                    'key'			=> 'field_639a1fbce80da',
                    'label'			=> __('Region','hap'),
                    'name' 				=> 'store_region',
                    'type'			=> 'select',
                    'choices'		=> hap_get_italian_regions(),
                    'return_format'	=> 'value',
                    'allow_null'	=> 1,
                ),
                array(
                    'key'			=> 'field_63b2c263167e8',
                    'label'			=> __('Country','hap'),
                    'name'			=> 'store_country',
                    'type'			=> 'select',
                    'choices'		=> hap_get_countries(),
                    'return_format'	=> 'value',
                    'allow_null'	=> 1,
                    'ui'			=> 1,
                    'placeholder'	=> __('Ex: Italy','hap'),
                ),
                array(
                    'key'			=> 'field_63b2c30a167e9',
                    'label'			=> __('Continent','hap'),
                    'name'			=> 'store_continent',
                    'type'			=> 'select',
                    'choices'		=> hap_get_continents(),
                    'return_format'	=> 'value',
                    'allow_null'	=> 1,
                    'placeholder'	=> __('Ex: Europe','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc9407',
                    'label'			=> __('Email','hap') . ' 1',
                    'name'			=> 'store_email_1',
                    'type'			=> 'email',
                    'placeholder'	=> __('Ex: email@store.com','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc9440',
                    'label'			=> __('Email','hap') . ' 2',
                    'name'			=> 'store_email_2',
                    'type'			=> 'email',
                    'placeholder'	=> __('Ex: email@store.com','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc947a',
                    'label'			=> __('PEC Email','hap'),
                    'name'			=> 'store_pec_email',
                    'type'			=> 'email',
                    'placeholder'	=> __('Ex: email@pec.com','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc94b3',
                    'label'			=> __('Phone','hap') . ' 1',
                    'name'			=> 'store_phone_1',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex:','hap') . ' 3356175062',
                ),
                array(
                    'key'			=> 'field_63973e6cc94ee',
                    'label'			=> __('Phone','hap') . ' 2',
                    'name'			=> 'store_phone_2',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex:','hap') . ' 3356175062',
                ),
                array(
                    'key'			=> 'field_63973e6cc952c',
                    'label'			=> __('Toll-free phone number','hap'),
                    'name'			=> 'store_toll_free_phone',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex:','hap') . ' 8003402456',
                ),
                array(
                    'key'			=> 'field_63973e6cc9569',
                    'label'			=> 'WhatsApp',
                    'name'			=> 'store_whatsapp',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex:','hap') . ' 3356175062',
                ),
                array(
                    'key'			=> 'field_63973e6cc95a6',
                    'label'			=> 'Telegram',
                    'name'			=> 'store_telegram',
                    'type'			=> 'text',
                    'placeholder'	=> __('Ex:','hap') . ' 3356175062',
                ),
                array(
                    'key'			=> 'field_63973e6cc95e4',
                    'label'			=> __('Website','hap'),
                    'name'			=> 'store_website_url',
                    'type'			=> 'url',
                    'placeholder'	=> __('https://store.com','hap'),
                ),
                array(
                    'key'			=> 'field_63973e6cc9620',
                    'label'			=> __('Services','hap'),
                    'name'			=> 'store_services',
                    'type'			=> 'repeater',
                    'layout'		=> 'block',
                    'collapsed'		=> 'field_63973e6e741e8',
                    'button_label'	=> __('Add service','hap'),
                    'rows_per_page'	=> 20,
                    'sub_fields'	=> array(
                        array(
                            'key'				=> 'field_63973e6e741a3',
                            'label'				=> 'Icon',
                            'name'				=> 'icon',
                            'type'				=> 'image',
                            'wrapper'			=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'return_format'		=> 'array',
                            'library'			=> 'all',
                            'mime_types'		=> 'svg',
                            'preview_size'		=> 'thumbnail',
                            'parent_repeater'	=> 'field_63973e6cc9620',
                        ),
                        array(
                            'key'				=> 'field_63973e6e741e8',
                            'label'				=> __('Title','hap'),
                            'name'				=> 'title',
                            'type'				=> 'text',
                            'wrapper'			=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),

                            'parent_repeater'	=> 'field_63973e6cc9620',
                        ),
                        array(
                            'key'				=> 'field_63973e6e74229',
                            'label'				=> __('Color','hap'),
                            'name'				=> 'color',
                            'type'				=> 'color_picker',
                            'wrapper'			=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'parent_repeater'	=> 'field_63973e6cc9620',
                        ),
                    ),
                ),
                array(
                    'key'			=> 'field_63973e6cc9630',
                    'label'			=> __('Opening hours','hap'),
                    'name'			=> 'store_hours',
                    'type'			=> 'group',
                    'layout'		=> 'block',
                    'sub_fields'	=> array(
                        array(
                            'key'			=> 'field_63973e6f195fa',
                            'label'			=> __('Monday','hap'),
                            'name'			=> 'monday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',
                        ),
                        array(
                            'key'			=> 'field_63973e6f1964e',
                            'label'			=> __('Tuesday','hap'),
                            'name'			=> 'tuesday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',
                        ),
                        array(
                            'key'			=> 'field_63973e6f19698',
                            'label'			=> __('Wednesday','hap'),
                            'name'			=> 'wednesday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',

                        ),
                        array(
                            'key'			=> 'field_63973e6f196de',
                            'label'			=> __('Thursday','hap'),
                            'name'			=> 'thursday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',

                        ),
                        array(
                            'key'			=> 'field_63973e6f1971b',
                            'label'			=> __('Friday','hap'),
                            'name'			=> 'friday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',
                        ),
                        array(
                            'key'			=> 'field_63973e6f1975e',
                            'label'			=> __('Saturday','hap'),
                            'name'			=> 'saturday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',
                        ),
                        array(
                            'key'			=> 'field_63973e6f1979a',
                            'label'			=> __('Sunday','hap'),
                            'name'			=> 'sunday',
                            'type'			=> 'text',
                            'wrapper'		=> array(
                                'width'	=> '33',
                                'class'	=> '',
                                'id'	=> '',
                            ),
                            'placeholder'	=> __('Ex:','hap') . ' 09:00 - 13:00 15:00 - 19:00',
                        ),
                    ),
                ),
                array(
                    'key'			=> 'field_63973e6cc966d',
                    'label'			=> __('Photo Gallery','hap'),
                    'name'			=> 'store_photo_gallery',
                    'type'			=> 'gallery',
                    'return_format'	=> 'id',
                    'preview_size'	=> 'thumbnail',
                    'insert'		=> 'append',
                    'library'		=> 'all',
                    'mime_types'	=> 'jpg,jpeg,png,svg',
                ),
                array(
                    'key'			=> 'field_63973e6cc96e1',
                    'label'			=> __('Contact form','hap'),
                    'name'			=> 'store_cf7_form',
                    'type'			=> 'post_object',
                    'post_type'		=> array(
                        0	=> 'wpcf7_contact_form',
                    ),
                    'return_format'	=> 'id',
                    'multiple'		=> 0,
                    'allow_null'	=> 1,
                ),
            ),
            'location'		=> array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'store',
                    ),
                ),
            ),
            'menu_order'			=> 0,
            'position'				=> 'normal',
            'style'					=> 'default',
            'label_placement'		=> 'left',
            'instruction_placement'	=> 'label',
            'hide_on_screen'		=> '',
            'active'				=> true,
            'description'			=> '',
            'show_in_rest'			=> 0,
        ));
			
	}
	
}

/**
 * Set some ACF theme options default values.
 *
 * @return void.
 */
function hap_acf_options_default_values() {

	// Bail out if is not admin or current screen is not available
	if( !is_admin() || !get_current_screen() ) {
		return;
	}
	
	// Get WP Admin page
	$screen = get_current_screen();

	// If is ACF Options Layout
	if( $screen->id == 'hap-options_page_options-layout' ) {

		// Cookie policy
		$cookie_policy_field = get_field( 'cookie_policy_page', 'options' );

		if( !$cookie_policy_field ) {

			// Get cookie policy page by template
			$cookie_policy = get_posts([
				'post_type'		=>	'page',
				'numberposts'	=>	1,
				'fields'		=>	'ids',
				'nopaging'		=>	true,
				'meta_key'		=>	'_wp_page_template',
				'meta_value'	=>	'page-templates/page-cookie-policy.php'
			]);

			if( $cookie_policy ) {

				update_field( 'cookie_policy_page', $cookie_policy[0], 'options' );

			}

		}

		// Privacy policy
		$privacy_policy_field = get_field( 'privacy_policy_page', 'options' );

		if( !$privacy_policy_field ) {

			// Get cookie policy page by template
			$privacy_policy = get_posts([
				'post_type'		=>	'page',
				'numberposts'	=>	1,
				'fields'		=>	'ids',
				'nopaging'		=>	true,
				'meta_key'		=>	'_wp_page_template',
				'meta_value'	=>	'page-templates/page-privacy-policy.php'
			]);

			if( $privacy_policy ) {

				update_field( 'privacy_policy_page', $privacy_policy[0], 'options' );

			}

		}

		// Default placeholder
		$placeholder_field = get_field( 'placeholder_image', 'options' );

		if( !$placeholder_field ) {

			$placeholder = hap_get_page_by_title( 'Hap Placeholder', 'attachment' );

			if( $placeholder ) {

				update_field( 'placeholder_image', $placeholder->ID, 'options' );

			}

		}

	}

}

/**
 * Programmatically populate ACF select field named "optimization_contact_form_7_post_types"
 * with available public post types.
 * 
 * @param array $field
 * @return array $field
 */
function hap_populate_cf7_post_types( $field ) {
    
    // Reset choices
    $field['choices'] = [];
    
    // Get available jQuery files
    $choices = hap_get_cpts('string');
    
    // Loop through array and add to field 'choices'
    if( $choices ) {
        
        foreach( $choices as $slug => $label ) {
            
            $field['choices'][ $slug ] = $label;
            
        }
        
    }
    
    // Return the field
    return $field;
    
}

/**
 * Add wp_block post type to ACF post options.
 * 
 * https://github.com/AdvancedCustomFields/acf/issues/196
 * 
 * @param array $post_types
 * @return array $post_types
 */
function hap_acf_get_post_types_add_wp_block( $post_types ) {
	
	if( !in_array ('wp_block', $post_types ) ) {
		$post_types[] = 'wp_block';
	}
	
	return $post_types;
	
}