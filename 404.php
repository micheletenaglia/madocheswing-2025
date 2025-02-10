<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * The template for displaying 404 pages (Not Found)
 *
 * Do not edit directly!
 * Create a pattern to customize content 
 * and assign it to page 404 in options page.
 * 
 */

 // Get header
get_header();

// Get 404 block
$block = get_field('common_block_404','options');

// Custom 404
if( $block ) : ?>
    <div class="content">
        <?php mkt_get_content(get_post($block)); ?>
    </div>
<?php else : // Default 404 ?>
    <div class="content">
        <div class="default-404">
            <div>
                <h1 class="h2"><?php _e('Page not found','project'); ?></h1>
                <p><?php _e('The requested page does not exist or has been deleted.','project'); ?></p>
                <p><a class="button" href="<?php echo get_home_url(); ?>"><?php _e('Homepage','project'); ?></a></p>
            </div>
        </div>
    </div>
<?php endif;
get_footer();