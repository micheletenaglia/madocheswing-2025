<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Menu args
$menu_args = [
	'theme_location'	=>	'primary-menu',
	'container'			=>	'',
	'menu_class'		=>	'menu-popup'
];

?>
<div class="menu-fade-in">
	<div class="nav-desktop">
		<div class="logo">
			<a href="<?php echo get_home_url(); ?>"><?php echo mkt_get_logo(); ?></a>
		</div>
		<nav>
			<div class="js-desktop-menu-toggle icon-hamburger"></div>
			<?php do_action('mkt_after_desktop_nav'); ?>
		</nav>
	</div>
	<div class="js-menu-fade-in nav-fade-in">
		<div class="nav-fade-in-content">
			<?php wp_nav_menu($menu_args); ?>
		</div>
	</div>
	<div class="js-desktop-menu-toggle js-menu-fade-in menu-layer">
	</div>
</div>