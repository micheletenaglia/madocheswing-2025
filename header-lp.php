<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The template for displaying the header.
 *
 * Display all of the head element and everything up until the "#top" element.
 *
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script>
		document.documentElement.className = 'js';
	</script>
	<meta name="copyright" content="<?php bloginfo('name'); ?>" />
	<?php if( get_field('mobile_bar_color', 'options') ) : ?>
		<meta name="theme-color" content="<?php the_field('mobile_bar_color', 'options'); ?>" />
		<meta name="msapplication-navbutton-color" content="<?php the_field('mobile_bar_color', 'options'); ?>">
	<?php endif; ?>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php
	/**
	 * mkt_body_start_landing hook.
	 *
	 * @hooked esempio_fonction_hook - 1
	 */
	do_action('mkt_body_start_landing');
	?>
	<div id="top" <?php mkt_wrap_class(); ?>>	
		<?php
		/**
		 * mkt_container_start hook.
		 *
		 */
		do_action('mkt_container_start');