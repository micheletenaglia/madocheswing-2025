<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * The main PHP file of the theme.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 2.0.0
 */

/****************************************************************************************
  _____ ___ _     _____ ____  
 |  ___|_ _| |   | ____/ ___| 
 | |_   | || |   |  _| \___ \ 
 |  _|  | || |___| |___ ___) |
 |_|   |___|_____|_____|____/ 

****************************************************************************************/

require_once( get_template_directory() . '/core/functions/fn-core.php' );

require_once( get_template_directory() . '/core/functions/fn-utilities.php' ); // Constants are defined in this file

require_once( HAP_CORE_FN . 'fn-acf-fields-theme.php' );

require_once( HAP_CORE_FN . 'fn-backend-cleanup.php' );

require_once( HAP_CORE_FN . 'fn-backend.php');

require_once( HAP_CORE_FN . 'fn-acf-register-blocks.php');
require_once( HAP_PROJECT_BLOCKS . 'fn-acf-register-blocks.php');

require_once( HAP_CORE_FN . 'fn-acf-fields-blocks.php');
require_once( HAP_PROJECT_BLOCKS . 'fn-acf-fields-blocks.php');

require_once( HAP_CORE_FN . 'fn-media.php' );

require_once( HAP_CORE_FN . 'fn-cpt-register.php' );
require_once( HAP_CORE_FN . 'fn-cpt-stores.php' );

require_once( HAP_CORE_FN . 'fn-frontend-cleanup.php' );

require_once( HAP_CORE_FN . 'fn-frontend.php' );

require_once( HAP_CORE_FN . 'fn-tracking.php' );

require_once( HAP_CORE_FN . 'fn-shortcodes.php' );

require_once( HAP_CORE_FN . 'fn-plugins.php' );

require_once( HAP_CORE_FN . 'fn-license.php' );

// Note: Alternative way to get fields from options page
// get_field('xxx', 'options') = get_option('options_xxx')