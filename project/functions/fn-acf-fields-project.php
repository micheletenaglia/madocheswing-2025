<?php 

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Add project custom fields.
 * 
 * This function is called in 
 * core/functions/fn-acf-fields-theme.php
 * mktFieldsTheme::fields
 * 
 */
function project_fields() {
    // Bail out early
    if( !function_exists('acf_add_local_field_group') ) {
        return;
    }    
    // Post type: Dance class
	acf_add_local_field_group( array(
        'key'       => 'group_62adc5882c4b4',
        'title'     => 'Dance class',
        'fields'    => array(
            array(
                'key'           => 'field_62adc5c204a2a',
                'label'         => __('General info','project'),
                'type'          => 'tab',
                'placement'     => 'top',
            ),
            array(
                'key'           => 'field_62adc59e04a28',
                'label'         => __('Subhead','project'),
                'name'          => 'subhead',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_62adc6eef89a6',
                'label'         => __('Style','project'),
                'name'          => 'style',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type'     => array(
                    0 => 'style',
                ),
                'post_status'   => array(
                    0 => 'publish',
                ),
                'return_format' => 'id',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_633451823080a',
                'label'         => __('Level','project'),
                'name'          => 'level',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type'     => array(
                    0 => 'level',
                ),
                'post_status'   => array(
                    0 => 'publish',
                ),
                'return_format' => 'id',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_62b058a55e2c2',
                'label'         => __('Teachers','project'),
                'name'          => 'teachers',
                'type'          => 'relationship',
                'required'      => 1,
                'post_type' => array(
                    0 => 'teacher',
                ),
                'post_status'   => array(
                    0 => 'publish',
                ),
                'filters'       => array(
                    0 => 'search',
                ),
                'return_format' => 'id',
                'min'           => 1,
                'max'           => '',
            ),
            array(
                'key'           => 'field_62b0af2f2e5cd',
                'label'         => __('Location','project'),
                'name'          => 'location',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type'     => array(
                    0 => 'location',
                ),
                'post_status'   => array(
                    0 => 'publish',
                ),
                'return_format' => 'id',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_66d3809517edd',
                'label'         => __('Trial lesson'),'project',
                'name'          => 'trial_lesson',
                'type'          => 'true_false',
                'ui_on_text'    => __('Trial','project'),
                'ui_off_text'   => __('Regular','project'),
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_66d6ddea8f342',
                'label'         => __('Dates'),'project',
                'type'          => 'tab',
                'placement'     => 'top',
            ),
            array(
                'key'           => 'field_62ade448b621e',
                'label'         => __('Date'),'project',
                'name'          => 'date',
                'type'          => 'date_picker',
                'required'      => 1,
                'display_format'=> 'l j F Y',
                'return_format' => 'Ymd',
                'first_day'     => 1,
            ),
            array(
                'key'           => 'field_632f30f56bcd0',
                'label'         => __('Time'),'project',
                'name'          => 'time',
                'type'          => 'time_picker',
                'required'      => 1,
                'display_format'=> 'H:i',
                'return_format' => 'H:i',
            ),
            array(
                'key'           => 'field_6357b110df0da',
                'label'         => __('End date'),'project',
                'name'          => 'end_date',
                'type'          => 'date_picker',
                'required'      => 1,
                'display_format'=> 'l j F Y',
                'return_format' => 'Ymd',
                'first_day'     => 1,
            ),
            array(
                'key'           => 'field_6338986b07876',
                'label'         => __('Generate children','project'),
                'name'          => 'generate_children',
                'type'          => 'true_false',
                'ui_on_text'    => 'On',
                'ui_off_text'   => 'Off',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_62add8fb7a583',
                'label'         => __('Registration','project'),
                'type'          => 'tab',
                'placement'     => 'top',
            ),
            array(
                'key'           => 'field_6336a5324e4da',
                'label'         => __('Registration','project'),
                'name'          => 'registration',
                'type'          => 'button_group',
                'choices'       => array(
                    'open'      => __('Open','project'),
                    'closed'    => __('Closed','project'),
                ),
                'default_value' => 'open : Open',
                'return_format' => 'value',
                'layout'        => 'horizontal',
            ),
            array(
                'key'           => 'field_62add9127a584',
                'label'         => __('Fee','project'),
                'name'          => 'fee',
                'type'          => 'number',
                'required'      => 1,
                'append'        => '€',
            ),
            array(
                'key'           => 'field_66d4b0bc0a693',
                'label'         => __('Fee','project') . ' (' . __('yearly','project') . ')',
                'name'          => 'fee_yearly',
                'type'          => 'number',
                'append'        => '€',
            ),
            array(
                'key'           => 'field_66d4b0d90a694',
                'label'         => __('Fee','project') . ' (' . __('quarterly','project') . ')',
                'name'          => 'fee_quarterly',
                'type'          => 'number',
                'append'        => '€',
            ),
            array(
                'key'           => 'field_66d4b0e70a695',
                'label'         => __('Fee','project') . ' (' . __('monthly','project') . ')',
                'name'          => 'fee_monthly',
                'type'          => 'number',
                'append'        => '€',
            ),
            array(
                'key'           => 'field_66d4afecf7cc1',
                'label'         => 'Early birds',
                'name'          => 'early_birds_date',
                'type'          => 'date_picker',
                'display_format'=> 'l j F Y',
                'return_format' => 'Ymd',
                'first_day'     => 1,
            ),
            array(
                'key'           => 'field_66d4b016f7cc2',
                'label'         => __('Early birds fee','project'),
                'name'          => 'early_birds_fee',
                'type'          => 'number',
                'required'      => 1,
                'conditional_logic' => array(
                    array(
                        array(
                            'field'     => 'field_66d4afecf7cc1',
                            'operator'  => '!=empty',
                        ),
                    ),
                ),
                'append'        => '€',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'post_type',
                    'operator'  => '==',
                    'value'     => 'dance-class',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
    // Post type: Event
	acf_add_local_field_group( array(
        'key'       => 'group_632cc5992b5f7',
        'title'     => __('Event','project'),
        'fields'    => array(
            array(
                'key'           => 'field_632e52f1b8c3d',
                'label'         => __('Settings','project'),
                'type'          => 'tab',
                'placement'     => 'top',
            ),
            array(
                'key'           => 'field_632d6985308db',
                'label'         => __('Subhead','project'),
                'name'          => 'subhead',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_632ccd8b317e3',
                'label'         => __('Venue','project'),
                'name'          => 'location',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type'     => array(
                    0 => 'location',
                ),
                'post_status'   => array(
                    0 => 'publish',
                ),
                'taxonomy'      => array(
                    0 => 'location_category:ballroom',
                    1 => 'location_category:outdoor',
                ),
                'return_format' => 'id',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_632d7b1e0d950',
                'label'         => __('Entrance','project'),
                'name'          => 'entrance',
                'type'          => 'wysiwyg',
                'required'      => 1,
                'tabs'          => 'all',
                'toolbar'       => 'basic',
                'media_upload'  => 0,
                'delay'         => 1,
            ),
            array(
                'key'           => 'field_632e5310b8c3e',
                'label'         => __('Dates','project'),
                'type'          => 'tab',
                'placement'     => 'top',
            ),
            array(
                'key'           => 'field_632cc59a10222',
                'label'         => __('Start date','project'),
                'name'          => 'date',
                'type'          => 'date_picker',
                'required'      => 1,
                'display_format'=> 'l j F Y',
                'return_format' => 'Ymd',
                'first_day'     => 1,
            ),
            array(
                'key'           => 'field_632d68ffbdbff',
                'label'         => __('End date','project'),
                'name'          => 'end_date',
                'type'          => 'date_picker',
                'required'      => 0,
                'display_format'=> 'l j F Y',
                'return_format' => 'Ymd',
                'first_day'     => 1,
            ),
            array(
                'key'           => 'field_632d6919bdc00',
                'label'         => __('Start time','project'),
                'name'          => 'start_time',
                'type'          => 'time_picker',
                'required'      => 1,
                'display_format'=> 'H:i',
                'return_format' => 'H:i',
            ),
            array(
                'key'           => 'field_632d6944bdc01',
                'label'         => __('End time','project'),
                'name'          => 'end_time',
                'type'          => 'time_picker',
                'required'      => 0,
                'display_format'=> 'H:i',
                'return_format' => 'H:i',
            ),
            array(
                'key'           => 'field_66d61e244f60c',
                'label'         => __('Generate children','project'),
                'name'          => 'generate_children',
                'type'          => 'true_false',
                'default_value' => 0,
                'ui_on_text'    => 'On',
                'ui_off_text'   => 'Off',
                'ui'            => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'post_type',
                    'operator'  => '==',
                    'value'     => 'event',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
    // Post type: Level
	acf_add_local_field_group( array(
        'key'       => 'group_632e20ceba487',
        'title'     => __('Level','project'),
        'fields' => array(
            array(
                'key'           => 'field_632e400a55793',
                'label'         => __('Related dance style','project'),
                'name'          => 'style',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type' => array(
                    0 => 'style',
                ),
                'post_status'   => array(
                    0 => 'publish',
                ),
                'return_format' => 'id',
            ),
            array(
                'key'           => 'field_66d38a84fc3e0',
                'label'         => __('Label','project'),
                'name'          => 'label',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_632e20f418587',
                'label'         => __('Short description','project'),
                'name'          => 'short_description',
                'type'          => 'textarea',
                'required'      => 1,
                'maxlength'     => 200,
                'rows'          => 2,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'post_type',
                    'operator'  => '==',
                    'value'     => 'level',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
    // Post type: Location
	acf_add_local_field_group( array(
        'key'       => 'group_62b0ae648cddd',
        'title'     => __('Location','project'),
        'fields'    => array(
            array(
                'key'           => 'field_632f05255f190',
                'label'         => __('Category','project'),
                'name'          => 'type',
                'type'          => 'taxonomy',
                'required'      => 1,
                'taxonomy'      => 'location_category',
                'add_term'      => 0,
                'save_terms'    => 1,
                'load_terms'    => 1,
                'return_format' => 'id',
                'field_type'    => 'radio',
                'allow_null'    => 0,
            ),
            array(
                'key'           => 'field_6328e0faca659',
                'label'         => __('Website','project'),
                'name'          => 'website',
                'type'          => 'url',
            ),
            array(
                'key'           => 'field_62b0ae6b152fe',
                'label'         => __('Address','project'),
                'name'          => 'address',
                'type'          => 'google_map',
                'required'      => 1,
                'center_lat'    => '40.8177825292694',
                'center_lng'    => '-73.96026531558991',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'post_type',
                    'operator'  => '==',
                    'value'     => 'location',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
    // Post type: Style
	acf_add_local_field_group( array(
        'key'       => 'group_62b070ece29e9',
        'title'     => __('Style','project'),
        'fields'    => array(
            array(
                'key'           => 'field_6330b7ca79a04',
                'label'         => __('Subhead','project'),
                'name'          => 'subhead',
                'type'          => 'text',
                'required'      => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'post_type',
                    'operator'  => '==',
                    'value'     => 'style',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
    // Post type: Teacher
	acf_add_local_field_group( array(
        'key'       => 'group_62b050855297a',
        'title'     => __('Teacher','project'),
        'fields'    => array(
            array(
                'key'           => 'field_62b0508c57576',
                'label'         => __('Last name','project'),
                'name'          => 'last_name',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_62b0509857577',
                'label'         => __('First name','project'),
                'name'          => 'first_name',
                'type'          => 'text',
                'required'      => 1,
            ),
            array(
                'key'           => 'field_62b050a357578',
                'label'         => __('Styles','project'),
                'name'          => 'styles',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type'     => array(
                    0 => 'style',
                ),
                'taxonomy'      => '',
                'allow_null'    => 0,
                'multiple'      => 1,
                'return_format' => 'id',
                'ui'            => 1,
            ),
            array(
                'key'           => 'field_6340203a721c0',
                'label'         => 'Email',
                'name'          => 'email',
                'type'          => 'email',
            ),
            array(
                'key'           => 'field_62b050b857579',
                'label'         => __('Image','project'),
                'name'          => '_thumbnail_id',
                'type'          => 'image',
                'required'      => 1,
                'return_format' => 'id',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg',
                'preview_size'  => 'thumbnail',
            ),
            array(
                'key'           => 'field_66d596e61f05a',
                'label'         => __('Profile image','project'),
                'name'          => 'profile_image',
                'type'          => 'image',
                'required'      => 1,
                'return_format' => 'id',
                'library'       => 'all',
                'min_width'     => 640,
                'min_height'    => 640,
                'max_width'     => 640,
                'max_height'    => 640,
                'mime_types'    => 'jpg,jpeg',
                'preview_size'  => 'thumbnail',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'post_type',
                    'operator'  => '==',
                    'value'     => 'teacher',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'left',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
    // Block: Dance class card
	acf_add_local_field_group( array(
        'key'       => 'group_66d04f94b2340',
        'title'     => __('Dance class card','project'),
        'fields'    => array(
            array(
                'key'           => 'field_66d04f9624d50',
                'label'         => __('Dance class','project'),
                'name'          => 'dance_class',
                'type'          => 'post_object',
                'required'      => 1,
                'post_type'     => array(
                    0 => 'dance-class',
                ),
                'post_status' => array(
                    0 => 'publish',
                ),
                'return_format' => 'id',
                'ui'            => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'     => 'block',
                    'operator'  => '==',
                    'value'     => 'acf/dance-class-card',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'field',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));


}