<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/*
 * Template Name: Landing Page
 * Template Post Type: page
 */

 // Get header
get_header('lp');

// Get content
the_content();

// Get footer
get_footer('lp');