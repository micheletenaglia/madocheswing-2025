<?php

/**
 * Template name: Search Page
 * 
 */

// Get header
get_header();

// List item: Contact 
$contact_item = null;
// Get contact page
$contact_page = get_posts([
	'post_type'		=> 'page',
	'numberposts'	=> 1,
	'fields'		=> 'ids',
	'meta_key'		=> '_wp_page_template',
	'meta_value'	=> 'page-templates/page-contacts.php'
]);
if( $contact_page ) {
    // If contact page
    $contact_item = '<li>' . sprintf( __('If you still can\'t find what you\'re looking for, send <a href="%s">feedback</a> to help improve our site.','project'), get_the_permalink($contact_page[0]) ) . '</li>';
}elseif( get_field('email','options') ) {
    // If email
	$contact_item = '<li>' . sprintf( __('If you still can\'t find what you\'re looking for, send <a href="mailto:%s">feedback</a> to help improve our site.','project'), get_field('email','options') ) . '</li>';
}

?>
<main>
	<div class="container-md p-4-8">
        <?php if( esc_attr($s) != '' ) :
            if( have_posts() ) : ?>
                <div class="search-results-wrap text-center">
                    <span class="eyelet"><?php _e('You have searched for','project'); ?></span>
                    <h1 class="title-xl mt-4 capitalize">"<?php echo esc_html($s); ?>"</h1>
                    <ul class="search-results container-sm">
                        <?php while( have_posts() ) : 
                            the_post(); 
                            ?>
                            <li><?php mkt_get_template('search/search-card'); ?></li>
                        <?php endwhile; ?>
                    </ul>
                    <?php mkt_get_template('pagination'); ?>
                </div>
            <?php else : ?>
                <div class="search-no-results-wrap text-center">
                    <span class="eyelet"><?php _e('No results for','project'); ?></span>
                    <h1 class="title-xl mt-4 capitalize">"<?php echo esc_html($s); ?>"</h1>
                    <p><?php echo __('We are sorry, we were not able to find a match.', 'project'); ?></p>
                    <div class="container-sm">
                        <ul>
                            <li><?php _e('Try a different word or phrase.','project'); ?></li>
                            <li><?php _e('Check your search for typos.','project'); ?></li>
                            <?php echo $contact_item ? $contact_item : null; ?>
                        </ul>
                        <div class="mt-sm mb-sm">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="text-center">
                <h1 class="title-xl mt-4"><?php _e('Search','project'); ?></h1>
                <p><?php _e('Enter at least three letters.','project'); ?></p>
                <div class="container-sm mt-sm mb-sm">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
	</div>
</main>
<?php get_footer();