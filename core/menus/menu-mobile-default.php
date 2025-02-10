<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

$menu_args = [
	'theme_location'	=>	'mobile-menu',
	'container'			=>	'',
	'menu_class'		=>	'menu-mobile'
];

?>

<div class="js-menu-mobile menu-mobile-default">

	<div class="nav-mobile">
	
		<div class="logo">
			<a title="<?php _e('Homepage','hap'); ?>" href="<?php echo get_home_url(); ?>"><?php echo hap_get_logo(); ?></a>
		</div>

		<?php hap_get_template('menu/menu-mobile-toggle'); ?>

		<nav>
			<?php wp_nav_menu( $menu_args ); ?>
			<?php do_action( 'hap_after_mobile_nav'); ?>
		</nav>

	</div>
	
</div>