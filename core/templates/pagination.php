<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

the_posts_pagination( 
	[
		'mid_size'	=>	2,
		'prev_text'	=>	get_svg_icon('chevron-left'),
		'next_text'	=>	get_svg_icon('chevron-right'),
	]
);

?>