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

<div class="menu-centered">
	
	<div class="nav-desktop">

		<div class="logo">
			<a href="<?php echo get_home_url(); ?>"><?php echo hap_get_logo(); ?></a>
		</div>

		<nav>
			<?php wp_nav_menu( $menu_args ); ?>
			<?php do_action( 'hap_after_desktop_nav'); ?>
		</nav>

	</div>
	
</div>