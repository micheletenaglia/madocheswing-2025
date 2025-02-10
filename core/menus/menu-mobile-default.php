<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Menu args
$menu_args = [
	'theme_location'	=>	'mobile-menu',
	'container'			=>	'',
	'menu_class'		=>	'menu-mobile'
];

?>
<div class="js-menu-mobile menu-mobile-default">
	<div class="nav-mobile">
		<div class="logo">
			<a title="<?php _e('Homepage','mklang'); ?>" href="<?php echo get_home_url(); ?>"><?php echo mkt_get_logo(); ?></a>
		</div>
		<?php mkt_get_template('menu/menu-mobile-toggle'); ?>
		<nav>
			<?php wp_nav_menu( $menu_args ); ?>
			<?php do_action('mkt_after_mobile_nav'); ?>
		</nav>
	</div>
</div>