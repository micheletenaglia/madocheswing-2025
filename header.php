<?php

/**
 * The template for displaying the header.
 *
 * Display all of the head element and everything up until the "#top" element.
 *
 * Do not edit directly!
 * Hooks must be used to customize the content.
 * 
 * @since Hap Studio Theme 1.0.0
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
	<meta name="author" content="Hap Studio" />
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
	 * hap_body_start hook.
	 *
	 */
	do_action('hap_body_start');
	?>
	<div id="top" <?php hap_wrap_class(); ?>>
		<?php
		/**
		 * hap_container_start hook.
		 *
		 */
		do_action('hap_container_start');