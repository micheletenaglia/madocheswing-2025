<?php 

get_header(); 

$cat_args = [
	'title_li'		=>	'',
]
?>
<div class="hero hero-blog bg-cover bg-center">
    <header>
        <h1 class="mt-8 mb-1"><?php _e('Posts','project'); ?></h1>
    </header>
    <ul class="cat-list">
        <?php echo wp_list_categories($cat_args); ?>
    </ul>
</div>
<main class="loop loop-blog">
    <?php if( have_posts() ) : ?>
        <?php while( have_posts() ) : the_post(); ?>
            <?php hap_get_template('post/post-card'); ?>
        <?php endwhile; ?>
        <?php hap_get_template('pagination'); ?>
    <?php endif; wp_reset_postdata(); ?>
</main>

<?php get_footer();