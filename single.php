<?php

/**
 * The template for post type "post".
 *
 * @since Hap Studio Theme 1.0.0
 */

// Get header
get_header();

// Get the ID
$post_id = get_the_ID();

// Get categories
$category = get_the_category($post_id);
$category = $category[0];

?>

<main class="pr-sm pb-sm pl-sm">
    <header class="container-md text-center mb-sm">
        <a href="<?php echo get_term_link($category); ?>" class="eyelet"><?php echo $category->name; ?></a>
        <h1 class="title-xl mt-4"><?php the_title(); ?></h1>
    </header>
    <div class="container-sm letterhead">
        <?php the_content(); ?>
	</div>
</main>
<?php get_footer();