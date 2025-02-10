<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Template name: Terms & Conditions
 * 
 */

// Get header
get_header();

?>
<main class="container-md content p-4-8">
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</main>
<?php
// Get footer
get_footer();
