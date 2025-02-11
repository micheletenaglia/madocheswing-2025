<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// !!! Acf only in backend
// https://stackoverflow.com/questions/40595832/wordpress-check-if-plugin-is-installed-acf
// https://www.billerickson.net/advanced-custom-fields-frontend-dependency/

// Register theme core ACF fields, options pages and default values
new mktFieldsTheme();

/**
 * Register theme core ACF fields, options pages and default values.
 */
class mktFieldsTheme{

    /**
     * Actions and filters.
     * 
     */
    public function __construct() {

        // Option pages
        add_action('acf/init',[$this,'option_pages']);

        // Fields
        add_action('acf/init',[$this,'fields']);

        // Default values
        add_action('acf/save_post',[$this,'default_values'],20);

        // Allow wp_block post type in ACF
        add_filter('acf/get_post_types',[$this,'wp_block'],10,1);

        // Programmatically populate ACF select field named "optimization_contact_form_7_post_types"
        add_filter('acf/load_field/name=optimization_contact_form_7_post_types',[$this,'populate_cf7_post_types']);

        // Programmatically populate ACF select field named "menu_id" with available menus.
        add_filter('acf/load_field/name=menu_id',[$this,'populate_acf_field_menu_id']);

        // Programmatically populate ACF select field named "post_type"
        add_filter('acf/load_field/name=post_type',[$this,'populate_post_types']);

    }

    /**
     * Add ACF options pages.
     */
    public function option_pages() : void {
        // Bail out early
        if( !function_exists('acf_add_options_page') ) {
            return;
        }
        // Options page: Main
        acf_add_options_page([
            'page_title'    =>	__('Mkt Theme Options','mklang'),
            'menu_title'	=>	__('Theme options','mklang'),
            'menu_slug' 	=>	'options',
            // 'capability'	=>	get_option('project_options_cap') ? get_option('project_options_cap') : 'edit_others_pages',
            'capability'	=>	'edit_others_pages',
            'icon_url'		=>	'dashicons-mkt',
            'redirect'		=>	false,
            'position'		=>	false,
            'post_id'       =>	'options',
            'update_button' =>	__('Save', 'acf'),
            'updated_message'=>	__('Options saved', 'acf'),
        ]);

        // Options page: Layout
        acf_add_options_sub_page([
            'page_title'    =>	__('Mkt Theme Layout','mklang'),
            'menu_title'	=>	__('Layout','mklang'),
            'parent_slug'	=>	'options',
            'menu_slug'		=>	'options-layout',
            'capability' 	=>	'manage_options',
        ]);
        
        // Options page: Other
        acf_add_options_sub_page([
            'page_title'    =>	__('Other options','mklang'),
            'menu_title'	=>	__('Other options', 'mklang'),
            'parent_slug'	=>	'options',
            'menu_slug'		=>	'options-other',
            'capability' 	=>	'manage_options',
        ]);

    }

    /**
     * Load ACF fields in theme.
     */
    public function fields() : void {
        // Bail out early
        if( !function_exists('acf_add_local_field_group') ) {
            return;
        }
        /*-------------------------------------------------------------------------------------*/
        // Options page 1
        acf_add_local_field_group(array(
            'key'						=> 'group_608046bac074d',
            'title'						=> __('Main settings','mklang'),
            'fields'					=> array(
                array(
                    'key'				=> 'field_60805430e4c49',
                    'label'				=> __('Contacts','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-contacts',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_687cac804a6',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-contacts',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can add all the details about the company.','mklang'),
                ),
                array(
                    'key'				=> 'field_kag9dybce5ndiumk',
                    'label'				=> __('Company Name','mklang'),
                    'name'				=> 'company_name',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_name]',
                    'required'			=> 1,
                ),
                array(
                    'key'				=> 'field_z3pb37smqcc1xrdc',
                    'label'				=> __('Legal Representative','mklang'),
                    'name' 				=> 'legal_representative',
                    'type' 				=> 'text',
                    'instructions' 		=> 'Shortcode: [company_legal_representative]',
                ),
                array(
                    'key'				=> 'field_6080543fe4c4a',
                    'label'				=> __('Phone','mklang'),
                    'name'				=> 'phone',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_phone]',
                ),
                array(
                    'key'				=> 'field_60805464e4c4b',
                    'label'				=> __('Mobile Phone','mklang'),
                    'name'				=> 'mobile_phone',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_mobile_phone]',
                ),
                array(
                    'key'				=> 'field_639b213e95fac',
                    'label'				=> __('Toll Free Phone Number','mklang'),
                    'name'				=> 'toll_free_phone',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_toll_free_phone]',
                ),
                array(
                    'key'				=> 'field_62385b625033f',
                    'label'				=> __('Email','mklang'),
                    'name'				=> 'email',
                    'type'				=> 'email',
                    'instructions'		=> 'Shortcode: [company_email]',
                    'required'			=> 1
                ),
                array(
                    'key'				=> 'field_6080546ce4c4c',
                    'label'				=> __('PEC Email','mklang'),
                    'name'				=> 'pec_email',
                    'type'				=> 'email',
                    'instructions'		=> 'Shortcode: [company_pec_email]',
                ),
                array(
                    'key'				=> 'field_60805471e4c4d',
                    'label'				=> __('Address','mklang'),
                    'name'				=> 'address',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_address]',
                ),
                array(
                    'key'				=> 'field_60805488e4c4e',
                    'label'				=> __('Postcode','mklang'),
                    'name'				=> 'postcode',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_zippostal_code]',
                ),
                array(
                    'key'				=> 'field_60805495e4c4f',
                    'label'				=> __('City','mklang'),
                    'name'				=> 'city',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_city]',
                ),
                array(
                    'key'				=> 'field_6080549be4c50',
                    'label'				=> __('Region','mklang'),
                    'name'				=> 'region',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_region]',
                ),
                array(
                    'key'				=> 'field_608054a1e4c51',
                    'label'				=> __('Country','mklang'),
                    'name'				=> 'country',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_country]',
                ),
                array(
                    'key'				=> 'field_opdwhy342cf7dzm1',
                    'label'				=> __('VAT Number','mklang'),
                    'name'				=> 'vat_number',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_vat_number]',
                ),
                array(
                    'key'				=> 'field_y1e2vey2f6rf3wkj',
                    'label'				=> __('Fiscal Code','mklang'),
                    'name'				=> 'cf_number',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_cf_number]',
                ),
                array(
                    'key'				=> 'field_eueozakyetgivsma',
                    'label'				=> __('REA number','mklang'),
                    'name'				=> 'rea_number',
                    'type'				=> 'text',
                    'instructions'		=> 'Shortcode: [company_rea_number]',
                ),
                array(
                    'key'				=> 'field_vp67k6upd08ndoo8',
                    'label'				=> __('Share Capital','mklang'),
                    'name'				=> 'share_capital',
                    'type'				=> 'number',
                    'instructions'		=> 'Shortcode: [company_share_capital]',
                ),
                array(
                    'key'				=> 'field_5d265681364f2',
                    'label'				=> __('Copyright start year','mklang'),
                    'name'				=> 'copyright_year',
                    'aria-label'		=> '',
                    'type'				=> 'number',
                    'instructions'		=> __('This value will be printed in footer into the the copyright statement.','mklang'),
                    'min'				=> 2010,
                ),
                array(
                    'key'				=> 'field_608054a9e4c52',
                    'label'				=> __('Social Media & Newsletter','mklang'),
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-social',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can add any social media in use by the company. <br>Shortcode default values: <ul><li><strong>icon="show"</strong><br> Set to "hide" if you want to show only text</li><li><strong>icon_classes="svg-icon fill-current h-4"</strong><br> The CSS classes assigned to the icon element</li><li><strong>a_classes=""</strong><br> The CSS classes assigned to the anchor element</li><li><strong>path="core"</strong><br> The path from where the icon file is loaded: change to project if you have uploaded a custom icon in project folder</li></ul>','mklang'),
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
            'description'				=> __('General settings for Mkt Theme (editable by editors).','mklang'),
        ));
        /*-------------------------------------------------------------------------------------*/
        // Options page 2
        acf_add_local_field_group(array(
            'key'						=> 'group_608045fa9e5e1',
            'title'						=> __('Layout','mklang'),
            'fields'					=> array(
                array(
                    'key'				=> 'field_60804983069d0',
                    'label'				=> __('Logo & Images','mklang'),
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
                    'label'				=> __('About','mklang'),
                    'name'				=> '',
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-image',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can add the logo, favicon and placeholder image for this website. To be able to upload SVG files remember to add <strong>define(\'ALLOW_UNFILTERED_UPLOADS\', true);</strong> in wp-config.php','mklang'),
                ),
                array(
                    'key'				=> 'field_608056a9f0266',
                    'label'				=> __('Logo Light Mode','mklang'),
                    'name'				=> 'logo_light_mode',
                    'type'				=> 'group',
                    'instructions'		=> __('Upload the default logo image for this website. The allowed file types are svg, png and jpg but it is always advisable to use an svg file because it is lighter and more easily manipulated using CSS styles.','mklang'),
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_608047715a452',
                            'label'				=> __('Image','mklang'),
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
                            'label'				=> __('CSS Classes','mklang'),
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
                            'label'				=> __('SVG Inline','mklang'),
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
                    'label'				=> __('Logo Dark Mode','mklang'),
                    'name'				=> 'logo_dark_mode',
                    'type'				=> 'group',
                    'instructions'		=> __('Upload the logo image to be used on dark backgrounds. The allowed file types are svg, png and jpg but it is always advisable to use an svg file because it is lighter and more easily manipulated using CSS styles. If you have uploaded an svg file as the default logo image it may not be necessary to add a version for dark backgrounds because svg files, when included as inline HTML, can be manipulated using CSS rules.','mklang'),
                    'layout'	=> 'block',
                    'sub_fields'=> array(
                        array(
                            'key'				=> 'field_608056f8f0269',
                            'label'				=> __('Image','mklang'),
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
                            'label'				=> __('CSS Classes','mklang'),
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
                            'label'				=> __('SVG Inline','mklang'),
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
                    'label'			=> __('Logo other version','mklang'),
                    'name'			=> 'logo_other_version',
                    'type'			=> 'group',
                    'instructions'		=> __('The logo in PNG or JPG format. This version is used in some specific cases such as signing Contact Form 7 forms.','mklang'),
                    'layout' => 'block',
                    'sub_fields'	=> array(
                        array(
                            'key'			=> 'field_63a58deca31f5',
                            'label'			=> __('Image','mklang'),
                            'name'			=> 'img',
                            'type'			=> 'image',
                            'instructions'	=> __('JPG and PNG only.','mklang'),
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
                            'label'			=> __('Width','mklang'),
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
                            'label'			=> __('Height','mklang'),
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
                /*-------------------------------------------------------------------------------------*/
                // Favicons
                array(
                    'key'				=> 'field_4a17908094ae6',
                    'label'				=> __('Favicons','mklang'),
                    'name'				=> 'favicons',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(						
                        array(
                            'key'				=> 'field_0496096c0878f',
                            'label'				=> 'Favicon SVG',
                            'name'				=> 'favicon_svg',
                            'type'				=> 'image',
                            'instructions'		=> __('Add a favicon to the website. The best way to reach cross-browsers compatibility is to add both SVG and PNG files. The file must be square and measure 512 x 512 pixels.','mklang'),
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
                            'instructions'		=> __('Add a favicon to the website. The best way to reach cross-browsers compatibility is to add both SVG and PNG files. The file must be square and measure 512 x 512 pixels.','mklang'),
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
                            'label'				=> __('Regenerate favicon versions','mklang'),
                            'name'				=> 'regenerate_favicons',
                            'type'				=> 'true_false',
                            'instructions'		=> __('Activate this option if you want to generate: favicon versions for all devices and browsers, JSON code for "manifest.webmanifest" file and "browserconfig.xml" file.','mklang'),
                            'ui'				=> 1,
                            'ui_on_text'		=> __('On','mklang'),
                            'ui_off_text'		=> __('Off','mklang'),
                        ),
                        array(
                            'key'				=> 'field_6f4b0804c46ce',
                            'label'				=> __('Favicon code in head','mklang'),
                            'name'				=> 'favicon_code',
                            'type'				=> 'textarea',
                            'instructions'		=> __('This value is generated automatically after adding a favicon file. If you have changed the favicon, flag "Regenerate favicon versions" field and then save this page. It is also possible to edit this field manually if you need to customize the code.','mklang'),
                            'wrapper'			=> array(
                                'width'	=> '',
                                'class'	=> 'mkcb-code',
                                'id'	=> '',
                            ),
                        ),
                        array(
                            'key'				=> 'field_b6cf00468c44e',
                            'label'				=> __('Favicon JSON file for Android apps','mklang'),
                            'name'				=> 'favicon_manifest_json',
                            'type'				=> 'textarea',
                            'instructions'		=> __('This JSON code is automatically generated and copied to "manifest.webmanifest" file located in theme/core/favicons directory.','mklang'),
                            'wrapper'			=> array(
                                'width'	=> '',
                                'class'	=> 'mkcb-code',
                                'id'	=> '',
                            ),
                        ),
                        array(
                            'key'				=> 'field_6f08c44b6c04e',
                            'label'				=> __('Favicon XML file for Windows','mklang'),
                            'name'				=> 'favicon_xml',
                            'type'				=> 'textarea',
                            'instructions'		=> __('This XML code is automatically generated and copied to "browserconfig.xml" file located in theme/core/favicons directory.','mklang'),
                            'wrapper'			=> array(
                                'width'	=> '',
                                'class'	=> 'mkcb-code',
                                'id'	=> '',
                            ),
                        ),
                    ),
                ),
                array(
                    'key'				=> 'field_w1ochqb4g29sawba',
                    'label'				=> __('Placeholder image','mklang'),
                    'name'				=> 'placeholder_image',
                    'type'				=> 'image',
                    'instructions'		=> __('Image to be used as fallback when the post has no related image.','mklang'),
                    'return_format'		=> 'id',
                    'preview_size'		=> 'thumbnail',
                    'library'			=> 'all',
                    'mime_types'		=> 'png,jpg,svg',
                ),
                array(
                    'key'               => 'field_663b61f648b0f',
                    'label'             => __('Max image size','mklang'),
                    'name'              => 'media_library_max_image_size',
                    'type'              => 'number',
                    'instructions'      => __('The maximum size in kilobytes of the images uploaded in the media library. The image formats included are JPG, JPEG, PNG, SVG and any other image format.','mklang'),
                    'default'           => 720,
                    'min'               => 320,
                    'step'              => 5,
                    'append'            => 'kb',
                ),
                array(
                    'key'				=> 'field_608049fdff986',
                    'label'				=> __('Colors','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-colors',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_a6cac687048',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-colors',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can set the color palette of the website. These values will be used to customize the backend and the login page.','mklang'),
                ),
                array(
                    'key'				=> 'field_60804a13ff987',
                    'label'				=> __('Primary Color','mklang'),
                    'name'				=> 'primary_color',
                    'type'				=> 'color_picker',
                    'instructions'		=> __('Set the primary color of the website.','mklang'),
                    'default_value'		=> '#ea4335',
                ),
                array(
                    'key'				=> 'field_60804a25ff988',
                    'label'				=> __('Secondary Color','mklang'),
                    'name'				=> 'secondary_color',
                    'type'				=> 'color_picker',
                    'instructions'		=> __('Set the secondary color of the website.','mklang'),
                    'default_value' => '#000000',
                ),
                array(
                    'key'				=> 'field_608055dba2c7a',
                    'label'				=> __('Mobile Bar Color','mklang'),
                    'name'				=> 'mobile_bar_color',
                    'type'				=> 'color_picker',
                    'instructions'		=> __('Set the color of browser bar on mobile devices.','mklang'),
                    'default_value'		=> '#ea4335',
                ),
                array(
                    'key'				=> 'field_60804a6194175',
                    'label'				=> __('Fonts','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-fonts',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_6804a67cab7',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-fonts',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can set the fonts to be used in this website. You can choose to use Google Fonts, Adobe fonts, custom fonts, or a combination of the three options.','mklang'),
                    'new_lines'			=> 'wpautop',
                ),
                array(
                    'key'				=> 'field_608061f7c4edc',
                    'label'				=> __('Google Fonts','mklang'),
                    'type'				=> 'tab',
                    'placement'			=> 'top',
                ),
                array(
                    'key'				=> 'field_660022586da71',
                    'label'				=> __('Google Fonts','mklang'),
                    'name'				=> 'google_fonts',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_6600e496b51eb',
                            'label'				=> __('Font Url','mklang'),
                            'name'				=> 'url',
                            'type'				=> 'url',
                            'instructions'		=> __('Copy and paste the url of selected Google font stylesheet.','mklang'),
                            'default_value'	=> 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;600&display=swap',
                            'placeholder'	=> 'https://fonts.googleapis.com/css2?family=Outfit:wght@300;600&display=swap',
                        ),
                        array(
                            'key'				=> 'field_6600e4c8829dc',
                            'label'				=> __('Preload','mklang'),
                            'name'				=> 'preload',
                            'type'				=> 'true_false',
                            'instructions'		=> __('Activate this option if you want to preload the font (better performances).','mklang'),
                            'ui'				=> 1,
                            'ui_on_text'		=> __('On','mklang'),
                            'ui_off_text'		=> __('Off','mklang'),
                        ),
                    ),
                ),
                array(
                    'key'				=> 'field_6080620dc4edd',
                    'label'				=> __('Woff Fonts','mklang'),
                    'name'				=> '',
                    'type'				=> 'tab',
                    'placement'			=> 'top',
                ),
                array(
                    'key'				=> 'field_60804b590addd',
                    'label'				=> __('Primary Font (Woff)','mklang'),
                    'name'				=> 'primary_font_woff',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_60804b590adde',
                            'label'				=> __('Font File','mklang'),
                            'name'				=> 'url',
                            'type'				=> 'file',
                            'instructions'		=> __('Load a WOFF or WOFF2 font file.','mklang'),
                            'return_format'		=> 'url',
                            'library'			=> 'all',
                            'mime_types'		=> 'woff, woff2',
                        ),
                        array(
                            'key'				=> 'field_60804b590addf',
                            'label'				=> __('Preload','mklang'),
                            'name'				=> 'preload',
                            'type'				=> 'true_false',
                            'instructions'		=> __('Activate this option if you want to preload the font (better performances).','mklang'),
                            'ui'				=> 1,
                            'ui_on_text'		=> __('On','mklang'),
                            'ui_off_text'		=> __('Off','mklang'),
                        ),
                    ),
                ),
                array(
                    'key'				=> 'field_60804c010ade3',
                    'label'				=> __('Secondary Font (Woff)','mklang'),
                    'name'				=> 'secondary_font_woff',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_60804c010ade4',
                            'label'				=> __('Font File','mklang'),
                            'name'				=> 'url',
                            'type'				=> 'file',
                            'instructions'		=> __('Load a WOFF or WOFF2 font file.','mklang'),
                            'return_format'		=> 'url',
                            'library'			=> 'all',
                            'mime_types'		=> 'woff, woff2',
                        ),
                        array(
                            'key'				=> 'field_60804c010ade5',
                            'label'				=> __('Preload','mklang'),
                            'name'				=> 'preload',
                            'type'				=> 'true_false',
                            'instructions'		=> __('Activate this option if you want to preload the font (better performances).','mklang'),
                            'ui'				=> 1,
                            'ui_on_text'		=> __('On','mklang'),
                            'ui_off_text'		=> __('Off','mklang'),
                        ),
                    ),
                ),
                array(
                    'key'				=> 'field_60804c150ade6',
                    'label'				=> __('Extra Font (Woff)','mklang'),
                    'name'				=> 'extra_font_woff',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_60804c150ade7',
                            'label'				=> __('Font File','mklang'),
                            'name'				=> 'url',
                            'type'				=> 'file',
                            'instructions'		=> __('Load a WOFF or WOFF2 font file.','mklang'),
                            'return_format'		=> 'url',
                            'library'			=> 'all',
                            'mime_types'		=> 'woff, woff2',
                        ),
                        array(
                            'key'				=> 'field_60804c150ade8',
                            'label'				=> __('Preload','mklang'),
                            'name'				=> 'preload',
                            'type'				=> 'true_false',
                            'instructions'		=> __('Activate this option if you want to preload the font (better performances).','mklang'),
                            'ui'				=> 1,
                            'ui_on_text'		=> __('On','mklang'),
                            'ui_off_text'		=> __('Off','mklang'),
                        ),
                    ),
                ),
                array(
                    'key'				=> 'field_6600224f6da70',
                    'label'				=> __('Adobe Fonts','mklang'),
                    'type'				=> 'tab',
                    'placement'			=> 'top',
                ),
                array(
                    'key'				=> 'field_6600225e6da78',
                    'label'				=> __('Adobe Fonts','mklang'),
                    'name'				=> 'adobe_fonts',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_6600225e6da77',
                            'label'				=> __('Font Url','mklang'),
                            'name'				=> 'url',
                            'type'				=> 'url',
                            'instructions'		=> __('Copy and paste the url of selected Adobe font stylesheet.','mklang'),
                            'placeholder'	=> 'https://use.typekit.net/example.css',
                        ),
                        array(
                            'key'				=> 'field_6600225d6da75',
                            'label'				=> __('Preload','mklang'),
                            'name'				=> 'preload',
                            'type'				=> 'true_false',
                            'instructions'		=> __('Activate this option if you want to preload the font (better performances).','mklang'),
                            'ui'				=> 1,
                            'ui_on_text'		=> __('On','mklang'),
                            'ui_off_text'		=> __('Off','mklang'),
                        ),
                    ),
                ),
                /*-------------------------------------------------------------------------------------*/
                // Menus
                array(
                    'key'				=> 'field_80498306960d0',
                    'label'				=> __('Menus','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-menus',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_a67cac86804',
                    'label'				=> __('About','mklang'),
                    'name'				=> '',
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-menus',
                        'id'	=> '',
                    ),
                    'message'			=> __('Select which menus to use for desktop and mobile, and other menu options.','mklang'),
                ),
                array(
                    'key'				=> 'field_6397010049466',
                    'label'				=> __('Desktop menu','mklang'),
                    'type'				=> 'tab',
                    'placement'	=> 'top',
                ),
                array(
                    'key'				=> 'field_6397014849467',
                    'label'				=> __('Type','mklang'),
                    'name'				=> 'menu_desktop',
                    'type'				=> 'select',
                    'choices'			=> array(
                        'default'	=> __('Default','mklang'),
                        'centered'	=> __('Centered','mklang'),
                        'fade-in'	=> __('Fade in','mklang'),
                        'slide-in'	=> __('Slide in','mklang'),
                        'block'		=> __('Custom block','mklang'),
                        'template'	=> __('Custom template','mklang'),
                    ),
                    'default_value'		=> 'default',
                    'return_format'		=> 'value',
                ),
                array(
                    'key'				=> 'field_63f45cb52729f',
                    'label'				=> __('Menu block','mklang'),
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
                    'label'				=> __('Menu template','mklang'),
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
                    'label'				=> __('Position','mklang'),
                    'name'				=> 'menu_desktop_position',
                    'type'				=> 'select',
                    'choices'			=> array(
                        'static'		=> __('Static','mklang'),
                        'absolute'		=> __('Absolute','mklang'),
                        'fixed'			=> __('Fixed','mklang'),
                    ),
                    'default_value'		=> 'static',
                    'return_format'		=> 'value',
                ),
                array(
                    'key'				=> 'field_6397021e09106',
                    'label'				=> __('Hide on scroll','mklang'),
                    'name'				=> 'menu_desktop_hide_on_scroll',
                    'type'				=> 'true_false',
                    'ui_on_text'		=> __('On','mklang'),
                    'ui_off_text'		=> __('Off','mklang'),
                    'ui'				=> 1,
                ),
                array(
                    'key'				=> 'field_6397028409107',
                    'label'				=> __('Add custom items after menu','mklang'),
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
                            'label'			=> __('Cart','mklang'),
                            'display'		=> 'block',
                            'sub_fields'	=> array(
                            ),
                        ),
                    ),
                    'button_label'			=> __('Add item','mklang'),
                ),
                /*-------------------------------------------------------------------------------------*/
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-footer',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can set the patterns to be used in footer and other info displayed in the footer.','mklang'),
                ),
                array(
                    'key'				=> 'field_60d09ddd6dee1',
                    'label'				=> __('Footer patterns','mklang'),
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
                    'label'				=> __('Hide credit in footer','mklang'),
                    'name'				=> 'hide_credit',
                    'type'				=> 'true_false',
                    'ui_on_text'		=> __('Hide','mklang'),
                    'ui_off_text'		=> __('Show','mklang'),
                    'ui'				=> 1,
                ),
                array(
                    'key'				=> 'field_60ddee009dd26',
                    'label'				=> __('Page 404','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-404',
                        'id'	=> 'tab-id-404',
                    ),
                ),
                array(
                    'key'				=> 'field_xd8c6637c62',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-404',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can set the pattern to be used in 404 page.','mklang'),
                ),
                array(
                    'key'				=> 'field_60d6de09ddde1',
                    'label'				=> __('404 Pattern','mklang'),
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
                    'label'				=> __('Archives','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-archives',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_5e6fgded59d4f',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-archives',
                        'id'	=> '',
                    ),
                    'message'			=> sprintf( __('Enable or disable archives (author, date, category, tag). Some of these options are available also in <a href="%s" rel="noopener noreferrer nofollow" target="_blank">Yoast Seo plugin</a>.','mklang'), get_admin_url() . 'admin.php?page=wpseo_titles#top#archives' ),
                ),
                array(
                    'key'				=> 'field_5e6ffe4a59d52',
                    'label'				=> __('Archive by date','mklang'),
                    'name'				=> 'disable_date_archive',
                    'type'				=> 'true_false',
                    'instructions'		=> sprintf( __('Enable or disable archives by date. <br><a href="%s">Example</a>','mklang' ), get_home_url() . '/' . date('Y') . '/' . date('m') ),
                    'default_value'		=> 1,
                    'ui'				=> 1,
                    'ui_on_text'		=> __('Off','mklang'),
                    'ui_off_text'		=> __('On','mklang'),
                ),	
                array(
                    'key'				=> 'field_5e6ffded59d4f',
                    'label'				=> __('Archive by author','mklang'),
                    'name'				=> 'disable_author_archive',
                    'type'				=> 'true_false',
                    'instructions'		=> sprintf( __('Enable or disable archives by author. <br><a href="%s">Example</a>','mklang' ), get_author_posts_url( get_current_user_id() ) ),
                    'default_value'		=> 1,
                    'ui'				=> 1,
                    'ui_on_text'		=> __('Off','mklang'),
                    'ui_off_text'		=> __('On','mklang'),
                ),
                array(
                    'key'				=> 'field_5e6ffe1e59d50',
                    'label'				=> __('Category archive','mklang'),
                    'name'				=> 'disable_category_archive',
                    'type'				=> 'true_false',
                    // !!! To be fixed 'instructions'		=> sprintf(__('Enable or disable category terms archives. <br><a href="%s">Example</a>','mklang'),get_term_link(get_option('default_category'))),
                    'ui'				=> 1,
                    'ui_on_text'		=> __('Off','mklang'),
                    'ui_off_text'		=> __('On','mklang'),
                ),
                array(
                    'key'				=> 'field_5e6ffe3d59d51',
                    'label'				=> __('Tag archive','mklang'),
                    'name'				=> 'disable_tag_archive',
                    'type'				=> 'true_false',
                    'instructions'		=> __('Enable or disable tag terms archives.','mklang' ),
                    'ui'				=> 1,
                    'ui_on_text'		=> __('Off','mklang'),
                    'ui_off_text'		=> __('On','mklang'),
                ),
                array(
                    'key'				=> 'field_63a37e66cc571',
                    'label'				=> __('Maps','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-maps',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_63a37e73cc572',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-maps',
                        'id'	=> '',
                    ),
                    'message'			=> __('API Keys and styles of Google Maps.','mklang'),
                ),
                array(
                    'key'				=> 'field_60804d982329c',
                    'label'				=> __('Google Maps Api Key','mklang'),
                    'name'				=> 'google_maps_api_key',
                    'type'				=> 'text',
                    'instructions'		=> __('The Google Map API KEY used to display the map in both backend and frontend.','mklang'),
                ),
                array(
                    'key'				=> 'field_98082604d329c',
                    'label'				=> __('Google Maps Api Key 2 (Used only for web service)','mklang'),
                    'name'				=> 'google_maps_api_key_web_service',
                    'type'				=> 'text',
                    'instructions'		=> __('The Google Map API KEY used to retrieve info about a place and save it into an ACF map field. This key is different form the previous key because it must have set IP address as restriction (previous key use http referrer as restriction). Places API must be activated for this key.','mklang'),
                ),
                array(
                    'key'				=> 'field_6f980813f04a7',
                    'label'				=> __('Google Map color light','mklang'),
                    'name'				=> 'map_color_light',
                    'type'				=> 'color_picker',
                    'instructions'		=> __('Set the lighter color of the customized Google Map.','mklang'),
                ),
                array(
                    'key'				=> 'field_613ff980804a7',
                    'label'				=> __('Google Map color dark','mklang'),
                    'name'				=> 'map_color_dark',
                    'type'				=> 'color_picker',
                    'instructions'		=> __('Set the darker color of the customized Google Map.','mklang'),
                ),
                array(
                    'key'				=> 'field_60ad75880f643',
                    'label'				=> __('Google Maps Style','mklang'),
                    'name'				=> 'google_maps_style',
                    'type'				=> 'textarea',
                    'instructions'		=> __('This field accepts a Google Maps JSON style. This option will overwrite the two previous settings (Google Map color light and Google Map color dark).','mklang'),
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_5d7a69dcce82f',
                    'label'				=> __('Map marker','mklang'),
                    'name'				=> 'google_maps_marker',
                    'type'				=> 'image',
                    'instructions'		=> __('Upload a PNG image to be used as default map marker in Google Maps.','mklang'),
                    'return_format'		=> 'url',
                    'preview_size'		=> 'thumbnail',
                    'library'			=> 'all',
                    'min_width'			=> 48,
                    'min_height'		=> 48,
                    'max_width'			=> 48,
                    'max_height'		=> 48,
                    'mime_types'		=> 'png',
                ),
                /*-------------------------------------------------------------------------------------*/
                // Privacy GDPR
                array(
                    'key'				=> 'field_1szdnpq6nvs6nn1o',
                    'label'				=> __('Privacy GDPR','mklang'),
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-privacy',
                        'id'	=> '',
                    ),
                    'message'			=> __('Set cookie and privacy policy pages.','mklang'),
                ),
                array(
                    'key'				=> 'field_60804ef63743b',
                    'label'				=> __('Cookie Policy Page','mklang'),
                    'name'				=> 'cookie_policy_page',
                    'type'				=> 'post_object',
                    'instructions'		=> sprintf( __('In case of new tracking scripts see <a target="_blank" rel="noopener noreferrer nofollow" href="%s">this page</a>.','mklang'), 'https://www.iubenda.com/it/help/674-tagging-manuale-blocco-cookie'),
                    'required'			=> 1,
                    'post_type'			=> array(
                        0		=> 'page',
                    ),
                    'return_format'		=> 'id',
                    'ui'				=> 1,
                ),
                array(
                    'key'				=> 'field_60804ef63521z',
                    'label'				=> __('Privacy Policy Page','mklang'),
                    'name'				=> 'privacy_policy_page',
                    'type'				=> 'post_object',
                    'required'			=> 1,
                    'post_type'			=> array(
                        0		=> 'page',
                    ),
                    'return_format'		=> 'id',
                    'ui'				=> 1,
                ),
                /*-------------------------------------------------------------------------------------*/
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-css',
                        'id'	=> '',
                    ),
                    'message'			=> __('Some options for handling CSS during development.','mklang'),
                    'new_lines'			=> 'wpautop',
                ),
                array(
                    'key'				=> 'field_064860a7b4ced',
                    'label'				=> __('Custom CSS file','mklang'),
                    'name'				=> 'custom_css',
                    'type'				=> 'true_false',
                    'instructions'		=> __('To be used only if you don\'t have access to scss file system.','mklang') . '<br><a target="_blank" rel="noopener noreferrer nofollow" href="' . get_template_directory_uri() . '/project/assets/css/custom.css">custom.css</a>.',
                    'ui'				=> 1,
                    'ui_on_text'		=> __('On','mklang'),
                    'ui_off_text'		=> __('Off','mklang'),
                ),
                array(
                    'key'				=> 'field_60804c4f4b6ec',
                    'label'				=> __('CSS inline','mklang'),
                    'name'				=> 'css_inline',
                    'type'				=> 'textarea',
                    'instructions'		=> __('To be used only if you don\'t have access to scss file system.','mklang') . '<br><a target="_blank" rel="noopener noreferrer nofollow" href="' . get_template_directory_uri() . '/project/assets/css/custom.css">custom.css</a>.',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
                        'id'	=> '',
                    ),
                ), 
                /*-------------------------------------------------------------------------------------*/              
                // Login style
                array(
                    'key'				=> 'field_600804969d083',
                    'label'				=> __('Login','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-login',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_667ca804a8',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-login',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can add custom styles for the login page.','mklang'),
                    'esc_html'			=> 0,
                ),
                array(
                    'key' 				=> 'field_614d90be6b105',
                    'label'				=> __('Login page custom CSS','mklang'),
                    'name'				=> 'login_style_css',
                    'type'				=> 'textarea',
                    'instructions'		=> __('Font fields and color fields are used to automatically generate custom styles for the login page. You can add more CSS rules here if needed.','mklang'),
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
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
            'description'			=> __('General layout settings for Mkt Theme.','mklang'),
        ));
        /*-------------------------------------------------------------------------------------*/
        // Options page: Monitoring
        acf_add_local_field_group(array(
            'key'					=> 'group_63a049df0b296',
            'title'					=> __('Monitoring','mklang'),
            'fields'				=> array(
                array(
                    'key'				=> 'field_60804ce668ca8',
                    'label'				=> __('Inline scripts','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-scripts',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_c0c6aa84867',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-scripts',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can add custom scripts in three different positions. Useful for monitoring codes like Google Analytics.','mklang'),
                ),
                array(
                    'key'				=> 'field_60804cfb68ca9',
                    'label'				=> __('Scripts before &lt;/head&gt;','mklang'),
                    'name'				=> 'scripts_head',
                    'type'				=> 'textarea',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_u2zvo9fnjebbiidj',
                    'label'				=> __('Scripts after &lt;body&gt;','mklang'),
                    'name'				=> 'scripts_body',
                    'type'				=> 'textarea',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
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
                        'class'	=> 'mkcb-code',
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
                        'class'	=> 'mkcb-code',
                        'id'	=> '',
                    ),
                    'ui'				=> 1,
                    'ui_on_text'		=> __('On','mklang'),
                    'ui_off_text'		=> __('Off','mklang'),
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
                        'class' => 'mkcb-code',
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
                        'class' => 'mkcb-code',
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
                        'class' => 'mkcb-code',
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
                    'label'				=>__('Google Tools','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-google',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_c0c6xd87897',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-google',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can set options for Google Analytics and Google Maps.','mklang'),
                ),
                array(
                    'key'				=> 'field_60804d5e2329a',
                    'label'				=> __('Google Analytics ID','mklang'),
                    'name'				=> 'google_analytics_id',
                    'type'				=> 'text',
                    'instructions'		=> __('The ID of the Google Analytics account associated with this domain.','mklang'),
                ),
                array(
                    'key'				=> 'field_63b9c71907026',
                    'label'				=> __('Google Tag Manager ID','mklang'),
                    'name'				=> 'google_tag_manager_id',
                    'type'				=> 'text',
                    'instructions'		=> __('The ID of the Google Tag Manager account associated with this domain.','mklang'),
                ),
                array(
                    'key'				=> 'field_qig03gdw7ih686yf',
                    'label'				=> __('Ip Anonymizer','mklang'),
                    'name'				=> 'google_analytics_ip_anonymizer',
                    'type'				=> 'true_false',
                    'instructions'		=> __('Toggle anonymize IP (this option will likely be deprecated starting with version 4 of Google Analytics).','mklang'),
                    'default_value'		=> 1,
                    'ui'				=> 1,
                    'ui_on_text'		=> __('On','mklang'),
                    'ui_off_text'		=> __('Off','mklang'),
                ),
                array(
                    'key'				=> 'field_60804dc6b18c8',
                    'label'				=> __('Facebook Tools','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-facebook',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_68704a6cac8',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-facebook',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can set Facebook Pixel Id and Facebook App id.','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Options page: Site mode
        acf_add_local_field_group(array(
            'key'					=> 'group_63a41e99c4964',
            'title'					=> __('Site mode','mklang'),
            'fields'				=> array(
                // Staging
                array(
                    'key'				=> 'field_63a423d4f1049',
                    'label'				=> __('Staging','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-staging',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_63a423d3f1048',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-staging',
                        'id'	=> '',
                    ),
                    'message'			=> __('You can use this option to make conditionally changes based on production/staging status.','mklang'),
                ),
                array(
                    'key'				=> 'field_680a7064b4ced',
                    'label'				=> 'Staging',
                    'name'				=> 'staging',
                    'type'				=> 'true_false',
                    'instructions'		=> __('Enable if this is a staging site.','mklang'),
                    'ui'				=> 1,
                    'ui_on_text'		=> __('On','mklang'),
                    'ui_off_text'		=> __('Off','mklang'),
                ),
                // Maintenance Mode
                array(
                    'key'				=> 'field_63a41e99c4503',
                    'label'				=> __('Maintenance Mode','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-maintenance',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_63ae99c454103',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-maintenance',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab you can activate the maintenance mode. This is useful when you have to work on the website and want to restrict access to users.','mklang'),
                ),
                array(
                    'key'				=> 'field_60804ef636328',
                    'label'				=> __('Maintenance Mode','mklang'),
                    'name'				=> 'maintenance_mode',
                    'type'				=> 'group',
                    'layout'			=> 'block',
                    'sub_fields'		=> array(
                        array(
                            'key'				=> 'field_60804ef636329',
                            'label'				=> __('Maintenance Mode','mklang'),
                            'name'				=> 'maintenance_mode_option',
                            'type'				=> 'true_false',
                            'default_value'		=> 0,
                            'ui'				=> 1,
                        'ui_on_text'		=> __('On','mklang'),
                        'ui_off_text'		=> __('Off','mklang'),
                        ),
                        array(
                            'key'               => 'field_6660ef72ba706',
                            'label'             => __('Custom pattern','mklang'),
                            'name'              => 'maintenance_custom_content',
                            'type'				=> 'post_object',
                            'return_format'     => 'id',
                            'relevanssi_exclude' => 1,
                            'ui'				=> 1,
                            'allow_null'	    => 1,
                            'instructions'      => __('Select a custom pattern if you don\'t want to show the default content.','mklang'),
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
                            'label'             => __('Excluded posts','mklang'),
                            'name'              => 'maintenance_excluded_posts',
                            'type'              => 'relationship',
                            'instructions'      => __('Cookie and privacy pages are excluded by default. Add any other pages you want to exclude.','mklang'),
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
                            'label'				=> __('Token','mklang'),
                            'name'				=> 'token',
                            'type'				=> 'text',
                            'instructions'      => sprintf(__('Enter a token of at least 8 alphanumeric characters and use it to bypass maintenance mode. Visit any page by adding the <strong>skip_token</strong> parameter with the token value as in  <a target="blank" rel="noopener noreferrer nofollow" href="%s">this example</a>.','mklang'),esc_url(add_query_arg('skip_token','1234abcd',home_url()))),
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
                            'label'				=> '<strong class="text-error">' . __('Deprecated','mklang') . ' ' . __('Maintenance Mode Page','mklang') . '</strong>',
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
        /*-------------------------------------------------------------------------------------*/
        // Options page: Plugins
        acf_add_local_field_group(array(
            'key'					=> 'group_63a3efd217c3b',
            'title'					=> __('Plugins','mklang'),
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-plugin-cf7',
                        'id'	=> '',
                    ),
                    'message'			=> mkt_plugin_active('cf7') ? sprintf(__('Additional options. See also the <a target="_blank" rel="noopener noreferrer nofollow" href="%s">shortcodes page</a> for other customizations.','mklang'),esc_url(add_query_arg('page','boost-shortcodes',admin_url('admin.php#cf-7')))) : __('<strong class="text-error">Plugin not found.</strong>','mklang'),
                ),
                array(
                    'key'			=> 'field_63a23909e5a9e',
                    'label'			=> __('Plugin optimization','mklang'),
                    'name'			=> 'optimization_contact_form_7',
                    'type'			=> 'group',
                    'layout'		=> 'block',
                    'instructions'	=>	__('Plugin assets are disabled globally to improve performance. The Contact Form 7 shortcode is automatically detected when included in the content of a post via the backend post editor. In these cases the assets are requeued. If you use the "do_shortcode" function within templates you need to set which post, post type or template it is used in.','mklang'),
                    'sub_fields'	=> array(
                        array(
                            'key'			=> 'field_63a238676a355',
                            'label'			=> __('Post included','mklang'),
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
                            'instructions'	=>	__('Include Contact Form 7 assets only in these posts.','mklang'),
                        ),
                        array(
                            'key'			=> 'field_63a237ed6a354',
                            'label'			=> __('Post types included','mklang'),
                            'name'			=> 'optimization_contact_form_7_post_types',
                            'type'			=> 'select',
                            'choices'		=> [],
                            'return_format'	=> 'value',
                            'multiple'		=> 1,
                            'allow_null'	=> 1,
                            'instructions'	=>	__('Include Contact Form 7 assets only in these post types.','mklang'),
                        ),
                        array(
                            'key'			=> 'field_63ad6a3237e54',
                            'label'			=> __('Templates included','mklang'),
                            'name'			=> 'optimization_contact_form_7_templates',
                            'type'			=> 'select',
                            'choices'		=> mkt_get_all_templates(),
                            'return_format'	=> 'value',
                            'multiple'		=> 1,
                            'allow_null'	=> 1,
                            'instructions'	=>	__('Include Contact Form 7 assets only in these templates.','mklang'),
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
                    'label'		=> __('About','mklang'),
                    'type'		=> 'message',
                    'wrapper'	=> array(
                        'width'	=> '',
                        'class'	=> 'about about-plugin-wpml',
                        'id'	=> '',
                    ),
                    'message'			=> mkt_plugin_active('wpml') ? __('Additional options.','mklang') : __('<strong class="text-error">Plugin not found.</strong>','mklang'),
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
                            'label'				=> __('Append link in WPML lang switcher','mklang'),
                            'name'				=> 'append_link_wpml_switcher',
                            'type'				=> 'link',
                            'return_format'		=> 'array',
                        ),
                    ),
                    'instructions'		=>	__('This option allows you to add a link to a language that is not supported by WPML, such as a language that is located in a subfolder, subdomain or other domain.','mklang')
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-plugin-dk-pdf',
                        'id'	=> '',
                    ),
                    'message'			=> mkt_plugin_active('dkpdf') ? __('Additional options.','mklang') : __('<strong class="text-error">Plugin not found.</strong>','mklang'),
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
                            'label'				=> __('Heading font','mklang'),
                            'name'				=> 'pdf_font_one',
                            'type'				=> 'file',
                            'instructions'		=> __('Upload the font to be used for PDF headings. Only TTF files are allowed.','mklang'),
                            'return_format'		=> 'array',
                            'library'			=> 'all',
                            'mime_types'		=> 'ttf',
                        ),
                        array(
                            'key'				=> 'field_637d6204f3bc8',
                            'label'				=> __('Body font','mklang'),
                            'name'				=> 'pdf_font_two',
                            'type'				=> 'file',
                            'instructions'		=> __('Upload the font to be used for PDF bodycopy. Only TTF files are allowed.','mklang'),
                            'return_format'		=> 'array',
                            'library'			=> 'all',
                            'mime_types'		=> 'ttf',
                        ),
                        array(
                            'key'				=> 'field_637d6215f3bc9',
                            'label'				=> __('Filename prefix','mklang'),
                            'name'				=> 'pdf_filename',
                            'type'				=> 'text',
                            'instructions'		=> __('The text to be used as a prefix for PDF files. No space allowed. Example of filename output: <br>prefix-post-title.pdf.','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Options page: Other options
        acf_add_local_field_group(array(
            'key'					=> 'group_63a41eb01e371',
            'title'					=> __('Other options','mklang'),
            'fields'				=> array(
                // Email notifications
                array(
                    'key'				=> 'field_61acd967143c3',
                    'label'				=> __('Email notifications','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-email',
                        'id'	=> '',
                    ),
                ),
                array(
                    'key'				=> 'field_6233385b6250f',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-email',
                        'id'	=> '',
                    ),
                    'message'			=> __('In this tab there are options useful if you are using custom email notifications sent directly form the website.','mklang'),
                ),
                array(
                    'key'				=> 'field_62362503385bf',
                    'label'				=> __('Email sender (name)','mklang'),
                    'name'				=> 'email_from_name',
                    'type'				=> 'text',
                    'instructions'		=> __('Set the name to be used in email header "from" field.','mklang'),
                    'default_value'		=> get_option( 'blogname' ),
                    'placeholder'		=> __('Ex:','mklang') . ' ' . get_option( 'blogname' ),
                ),
                array(
                    'key'				=> 'field_6236251c385c0',
                    'label'				=> __('Email sender (email)','mklang'),
                    'name'				=> 'email_from',
                    'type'				=> 'email',
                    'instructions'		=> __('Set the email to be used in email header "from" field. The email must have the same domain of the website to avoid spam filters.','mklang'),
                    'placeholder'		=> __('Ex:','mklang') . ' info@' . mkt_url_label(get_site_url()),
                ),
                array(
                    'key'				=> 'field_623625b4385c3',
                    'label'				=> __('Reply to (name)','mklang'),
                    'name'				=> 'reply_to_name',
                    'type'				=> 'text',
                    'instructions'		=> __('Set the name to be used in email header "reply-to" field.','mklang'),
                    'placeholder'		=> __('Ex:','mklang') . ' Arthur Dent',
                ),
                array(
                    'key'				=> 'field_62362577385c2',
                    'label'				=> __('Reply to (email)','mklang'),
                    'name'				=> 'reply_to_email',
                    'type'				=> 'email',
                    'instructions'		=> __('Set the email to be used in email header "reply-to" field.','mklang'),
                    'placeholder'		=> __('Ex:','mklang') . ' arthur.dent@galaxy.com',
                ),
                array(
                    'key'				=> 'field_62362565385c1',
                    'label'				=> __('Notifications recipients','mklang'),
                    'name'				=> 'recipients',
                    'type'				=> 'text',
                    'instructions'		=> __('Set one or more emails separated by commas. These are the emails notifications are sent to.','mklang'),
                    'placeholder'		=> __('Ex:','mklang') . ' ford.perfect@galaxy.com, marvin@galaxy.com',
                ),
                array(
                    'key'				=> 'field_6232a08ae3823',
                    'label'				=> __('Email disclaimer','mklang'),
                    'name'				=> 'email_disclaimer',
                    'type'				=> 'textarea',
                    'instructions'		=> '<strong>' . __('You can use this text as a starting point','mklang') . '</strong><br>' . __('This e-mail and its attachments may contain confidential information only for the Recipient specified in the address. The information transmitted through this e-mail and its attachments are intended exclusively for the recipient and must be considered confidential with a ban on dissemination and use unless expressly authorized. If this e-mail and its attachments have been received by mistake from a person other than the addressee, please destroy everything received and inform the sender by the same means. Any use, disclosure or unauthorized copy of this communication is strictly prohibited and involves a violation of the provisions of the Law on the protection of personal data European Regulation 2016/679.','mklang'),
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
                        'id'	=> '',
                    ),
                    'default_value'		=> __('This e-mail and its attachments may contain confidential information only for the Recipient specified in the address. The information transmitted through this e-mail and its attachments are intended exclusively for the recipient and must be considered confidential with a ban on dissemination and use unless expressly authorized. If this e-mail and its attachments have been received by mistake from a person other than the addressee, please destroy everything received and inform the sender by the same means. Any use, disclosure or unauthorized copy of this communication is strictly prohibited and involves a violation of the provisions of the Law on the protection of personal data European Regulation 2016/679.','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Theme license and updates
        acf_add_local_field_group( array(
            'key'                       => 'group_66634bd903f21',
            'title'                     => __('Theme license and updates','mklang'),
            'fields'                    => array(
                array(
                    'key'           => 'field_66634bd903602',
                    'label'         => __('License key','mklang'),
                    'name'          => 'bees_key',
                    'type'          => 'text',
                    'instructions'  => __('Register your license to enable updates.','mklang'),
                    'relevanssi_exclude' => 1,
                    'maxlength'     => 36,
                    'placeholder'   => __('36 Alphanumeric characters','mklang'),
                ),
                array(
                    'key'           => 'field_66640b032c9f3',
                    'label'         => __('Update theme','mklang'),
                    'name'          => 'mkt_theme_update_option',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'relevanssi_exclude' => 1,
                    'default_value' => 0,
                    'ui_on_text'    => __('Update now','mklang'),
                    'ui_off_text'   => __('Keep this version','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Backend notes (only pages)
        acf_add_local_field_group(array(
            'key'					=> 'group_60c3857073aa8',
            'title'					=> 'Notes',
            'fields'				=> array(
                array(
                    'key'				=> 'field_60c3859f5e17f',
                    'label'				=> __('Notes','mklang'),
                    'name'				=> 'backend_notes',
                    'type'				=> 'textarea',
                    'new_lines'			=> 'br',
                    'wrapper'	=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
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
            'menu_order'			=> 99,
            'position'				=> 'normal',
            'style'					=> 'default',
            'label_placement'		=> 'left',
            'instruction_placement'	=> 'label',
            'hide_on_screen'		=> '',
            'active'				=> true,
            'description'			=> '',
        ));
        /*-------------------------------------------------------------------------------------*/
        // Custom desktop navigation position (absolute, scroll or sticky) on pages 
        acf_add_local_field_group(array(
            'key'					=> 'group_60c15ea69cdcb',
            'title'					=> __('Desktop navigation','mklang'),
            'fields'				=> array(
                array(
                    'key'				=> 'field_60c15eb075d52',
                    'label'				=> __('Desktop navigation','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Toggle navigation menu
        acf_add_local_field_group(array(
            'key'					=> 'group_63d14c9d374b8',
            'title'					=> __('Show/Hide navigation','mklang'),
            'fields'				=> array(
                array(
                    'key'			=> 'field_63d14c9dd4d4a',
                    'label'			=> __('Show/Hide navigation','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Featured icon (all cpts)
        acf_add_local_field_group([
            'key'					=> 'group_6179aa6250f5e',
            'title'					=> __('Featured Icon','mklang'),
            'fields'				=> [
                [
                    'key' => 'field_6179aa873bc51',
                    'label'				=>  __('Featured Icon','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Preload image
        acf_add_local_field_group(array(
            'key'					=> 'group_63bb6e94b4ce5',
            'title'					=> __('Preload image','mklang'),
            'fields'				=> array(
                array(
                    'key'			=> 'field_63bb6e958aa5e',
                    'label'			=> __('Preload image','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Maintenance mode (pages)
        acf_add_local_field_group(array(
            'key'					=> 'group_627a768c9a2bc',
            'title'					=> __('Maintenance mode for pages','mklang'),
            'fields'				=> array(
                array(
                    'key'				=> 'field_627a76a513a5a',
                    'label'				=> __('Maintenance mode','mklang'),
                    'name'				=> 'page_maintenance_mode_toggle',
                    'type'				=> 'true_false',
                    'ui'				=> 1,
                    'ui_on_text'		=> __('On','mklang'),
                    'ui_off_text'		=> __('Off','mklang'),
                    'instructions'		=> __('Hide page content and show a maintenance message.','mklang'),
                ),
                array(
                    'key'				=> 'field_627a77ee13a5e',
                    'label' 			=> __('Block','mklang'),
                    'name'				=> 'page_maintenance_mode_common_block',
                    'type'				=> 'post_object',
                    'post_type'			=> array(
                        0	=> 'wp_block',
                    ),
                    'return_format'		=> 'id',
                    'allow_null'		=> 1,
                    'ui'				=> 1,
                    'instructions'		=> __('Select a block to override the default message.','mklang'),
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
        // Page custom CSS
        acf_add_local_field_group(array(
            'key'					=> 'group_639bb4c48775d',
            'title'					=> __('Page Custom CSS','mklang'),
            'fields'				=> array(
                array(
                    'key'		=> 'field_639bb4c4e9403',
                    'label'		=> __('Custom CSS','mklang'),
                    'name'		=> 'page_custom_css',
                    'type'		=> 'textarea',
                    'wrapper'	=> array(
                        'width'	=> '',
                        'class'	=> 'mkcb-code',
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
            'label_placement'		=> 'left',
            'instruction_placement'	=> 'label',
            'hide_on_screen'		=> '',
            'active'				=> true,
            'description'			=> '',
            'show_in_rest'			=> 0,
        ));
        /*-------------------------------------------------------------------------------------*/
        // Taxonomy fields
        acf_add_local_field_group([
            'key'		=> 'group_5c87a08a5f22d',
            'title'		=> __('Taxonomy Extra Fields','mklang'),
            'fields'	=> [
                [
                    'key'				=> 'field_80560e4c44309',
                    'label'				=> __('Term options','mklang'),
                    'type'				=> 'accordion',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'accordion-options',
                        'id'	=> '',
                    ),
                ],
                [
                    'key'				=> 'field_s6a68804ca7',
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-options',
                        'id'	=> '',
                    ),
                    'message'			=> __('These fields can be used to add one or more of the following options to the term: order of appearance, colour, image and logo. The default header of the term shows only the title but it is possible to override it by filling in the fields of the "custom template" group or by selecting a block in "template block". In order, the "template block" overrides the "custom template" which in turn overrides the default template.','mklang'),
                ],
                [
                    'key'				=> 'field_5d236465681f2',
                    'label'				=> __('Menu order','mklang'),
                    'name'				=> 'menu_order',
                    'type'				=> 'number',
                    'instructions'		=> __('Set custom menu order for this term.','mklang'),
                    'placeholder'		=> __('Ex:','mklang') . ' 3',
                ],
                [
                    'key'				=> 'field_6144b5fa7b6da',
                    'label'				=> __('Color', 'mklang'),
                    'name'				=> 'term_color',
                    'type'				=> 'color_picker',
                    'instructions'		=> __('Select the color to associate with this term.','mklang'),
                ],
                [
                    'key'				=> 'field_5c87a08a5f326',
                    'label'				=> __('Featured image', 'mklang'),
                    'name'				=> 'term_featured_img',
                    'type'				=> 'image',
                    'return_format'		=> 'id',
                    'preview_size'		=> 'thumbnail',
                    'library'			=> 'all',
                    'mime_types'		=> 'svg,jpg,png',
                    'instructions'		=> __('Select the image to associate with this term.','mklang'),
                ],
                [
                    'key'				=> 'field_5c87a08a5f360',
                    'label'				=> __('Logo', 'mklang'),
                    'name'				=> 'term_logo',
                    'type'				=> 'image',
                    'return_format'		=> 'id',
                    'preview_size'		=> 'thumbnail',
                    'library'			=> 'all',
                    'mime_types'		=> 'svg',
                    'instructions'		=> __('Select the logo to associate with this term (SVGs only).','mklang'),
                ],
                // Custom term template
                [
                    'key'				=> 'field_0e4c480564309',
                    'label'				=> __('Custom template','mklang'),
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-template',
                        'id'	=> '',
                    ),
                    'message'			=> __('Optional fields for the term template header.','mklang'),
                ],
                [
                    'key'				=> 'field_5c87a08a5f272',
                    'label'				=> __('Top title', 'mklang'),
                    'name'				=> 'toptitle',
                    'type'				=> 'text',
                    'placeholder'		=> __('Ex: News','mklang'),
                ],
                [
                    'key'				=> 'field_5c87a08a5f2af',
                    'label'				=> __('Title', 'mklang'),
                    'name'				=> 'title',
                    'type'				=> 'text',
                    'placeholder'		=> __('Ex: Company News','mklang'),
                ],
                [
                    'key'				=> 'field_5c87a08a5f2eb',
                    'label'				=> __('Subtitle', 'mklang'),
                    'name'				=> 'subtitle',
                    'type'				=> 'text',
                    'placeholder'		=> __('Ex: All the news about this company','mklang'),
                ],
                [
                    'key'				=> 'field_616ed892681b3',
                    'label'				=> __('Gallery', 'mklang'),
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
                    'label'				=> __('Block template','mklang'),
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
                    'label'				=> __('About','mklang'),
                    'type'				=> 'message',
                    'wrapper'			=> array(
                        'width'	=> '',
                        'class'	=> 'about about-block',
                        'id'	=> '',
                    ),
                    'message'			=> __('Choose a block to use as a header in the term template.','mklang'),
                ],
                [
                    'key'				=> 'field_6399a1ea1ac34',
                    'label' 			=> __('Term block','mklang'),
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
        /*-------------------------------------------------------------------------------------*/
        // Menu item fields
        acf_add_local_field_group( array(
            'key'					=> 'group_63f4c53d956c2',
            'title'					=> __('Menu item','mklang'),
            'fields'				=> array(
                array(
                    'key'			=> 'field_63f4c53d245c0',
                    'label'			=> __('Image','mklang'),
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
        // Block fields
        mkt_load_fields_blocks();
        // Project fields
        if( function_exists('project_fields') ) {
            project_fields();
        }
    }

    /**
     * Set some ACF theme options default values.
     */
    public function default_values() : void {
        // Bail out if is not admin or current screen is not available
        if( !is_admin() || !get_current_screen() ) {
            return;
        }
        // Get WP Admin page
        $screen = get_current_screen();
        // If is ACF Options Layout
        if( $screen->id == 'theme-options_page_options-layout' ) {
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
                // If policy
                if( $cookie_policy ) {
                    update_field('cookie_policy_page',$cookie_policy[0],'options');
                }
            }
            // Privacy policy
            $privacy_policy_field = get_field('privacy_policy_page','options');
            // If no policy
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
                // If policy
                if( $privacy_policy ) {
                    update_field('privacy_policy_page',$privacy_policy[0],'options');
                }
            }
            // Default placeholder
            $placeholder_field = get_field('placeholder_image','options');
            if( !$placeholder_field ) {
                $placeholder = mkt_get_page_by_title('Placeholder', 'attachment' );
                if( $placeholder ) {
                    update_field( 'placeholder_image', $placeholder->ID, 'options' );
                }
            }
        }
    }

    /**
     * Programmatically populate ACF select field named "optimization_contact_form_7_post_types" with available public post types.
     * @param array $field
     */
    public function populate_cf7_post_types( $field ) : array {
        // Reset choices
        $field['choices'] = [];
        // Get available jQuery files
        $choices = mkt_get_cpts('string');
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
     * @link https://github.com/AdvancedCustomFields/acf/issues/196
     * @param array $post_types
     */
    public function wp_block( $post_types ) : array {
        // Check if post type is already in array
        if( !in_array('wp_block',$post_types) ) {
            $post_types[] = 'wp_block';
        }
        return $post_types;
    }

    /**
     * Programmatically populate ACF select field named "menu_id" with available menus.
     * @param array $field
     */
    public function populate_acf_field_menu_id( $field ) : array {
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
     * Programmatically populate ACF select field named "post_type" with available public post types.
     * @param array $field
     */
    public function populate_post_types( $field ) : array {
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
        $pages = get_post_types($page_args,'objects');
        // Merge arrays
        $cpts = array_merge($cpts,$pages);
        // Exclude media (attachemnts)
        unset($cpts['attachment']);
        // Sort array by key
        ksort($cpts);	
        // Populate array
        foreach( $cpts as $post_type ) {
            $field['choices'][$post_type->name] = $post_type->label;
        }
        // Return the field
        return $field;
    }

}