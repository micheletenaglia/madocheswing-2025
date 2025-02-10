<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Menu args
$menu_args = [
	'theme_location'	=>	'primary-menu',
	'container'			=>	'',
	'menu_class'		=>	'menu-flex'
];

?>
<div class="menu-default">
	<div class="nav-desktop">
		<div class="logo">
			<a title="<?php _e('Homepage','mklang'); ?>" href="<?php echo get_home_url(); ?>"><?php echo mkt_get_logo(); ?></a>
		</div>
		<nav>
			<?php wp_nav_menu($menu_args); ?>
		</nav>
		<div class="nav-always">
			<?php do_action('mkt_after_desktop_nav'); ?>
			<?php mkt_get_template('menu/menu-mobile-toggle'); ?>
		</div>
	</div>
</div>