<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The template to display menu mobile toggle icon. 
 */

echo get_svg_icon(
	'bars',
	'js-menu-mobile-toggle menu-mobile-toggle',
	'core'
);