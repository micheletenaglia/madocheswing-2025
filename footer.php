<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The template for displaying the footer.
 *
 * Do not edit directly!
 * Hooks must be used to customize the content.
 * 
 */
do_action('mkt_container_end');

?>
</div> <!-- #top -->
<footer>
	<?php 
        do_action('mkt_footer');
        do_action('mkt_footer_credits');
    ?>
</footer>
<?php 
    do_action('mkt_footer_after');
    wp_footer();
?>
</body>
</html>