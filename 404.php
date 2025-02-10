<?php

/**
 * The template for displaying 404 pages (Not Found)
 *
 * Do not edit directly!
 * Create a pattern to customize content 
 * and assign it to page 404 in options page.
 * 
 * @since Hap Studio Theme 1.0.0
 */

 // Get header
get_header();

if( get_field('common_block_404','options') ) : // Custom 404  ?>
    <div class="content">
        <?php hap_get_content( get_post( get_field('common_block_404','options') ) ); ?>
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