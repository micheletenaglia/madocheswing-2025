<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

$menu_args = [
	'theme_location'	=>	'primary-menu',
	'container'			=>	'',
	'menu_class'		=>	'menu-popup'
];

?>

<div class="menu-slide-in">
	
	<div class="js-menu-slide-in nav-desktop">

		<div class="logo">
			<a href="<?php echo get_home_url(); ?>"><?php echo hap_get_logo(); ?></a>
		</div>

		<nav>
			<div class="js-desktop-menu-toggle icon-hamburger"></div>
			<?php do_action( 'hap_after_desktop_nav'); ?>
		</nav>

	</div>

	<div class="js-menu-slide-in nav-slide-in">

		<div class="nav-slide-in-content">
			<?php wp_nav_menu( $menu_args ); ?>
		</div>

	</div>

	<div class="js-desktop-menu-toggle js-menu-slide-in menu-layer">
	</div>
	
</div>