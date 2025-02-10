<?php 

// Get header
get_header(); 

// Get object
$object = get_queried_object();

?>
<main class="pr-sm pb-sm pl-sm">
    <header class="text-center mb-sm">
        <h1 class="title-xl"><?php echo $object->name; ?></h1>
        <?php if( $object->description ) : ?>
            <p><?php echo esc_html($object->description); ?></p>
        <?php endif; ?>
    </header>
    <?php if( have_posts() ) : ?>
        <div class="flex-1-3">
            <?php while( have_posts() ) : 
                the_post(); 
                mkt_get_template('post/post-card');
			endwhile; ?>
        </div>
        <?php else : ?>
            <p class="text-center"><?php _e('No news yet.','project'); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer();