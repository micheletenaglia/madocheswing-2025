<?php 

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add project blocks custom fields.
 * 
 * @return void.
 */
// add_action( 'acf/include_fields', function() {
if( function_exists('acf_add_local_field_group') ) {
    
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