<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

$menu_args = [
	'theme_location'	=>	'primary-menu',
	'container'			=>	'',
	'menu_class'		=>	'menu-flex'
];

?>

<div class="menu-default">

	<div class="nav-desktop">
	
		<div class="logo">
			<a title="<?php _e('Homepage','hap'); ?>" href="<?php echo get_home_url(); ?>"><?php echo hap_get_logo(); ?></a>
		</div>

		<nav>
			<?php wp_nav_menu( $menu_args ); ?>
		</nav>

		<div class="nav-always">
			<?php do_action( 'hap_after_desktop_nav'); ?>
			<?php hap_get_template('menu/menu-mobile-toggle'); ?>
		</div>
		
	</div>
	
</div>