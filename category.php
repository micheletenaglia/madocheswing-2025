<?php 

// Exit if accessed directly
defined('ABSPATH') || exit;

// Get header
get_header(); 

// Get object
$object = get_queried_object();

// Useful object fields
// term_id
// name
// slug
// term_taxonomy_id
// taxonomy
// description
// parent
// count 

// Available fields
// 1. toptitle
// string
$toptitle = get_field('toptitle',$object);

// 2. subtitle
// string
$subtitle = get_field('subtitle',$object);

// 3. term_featured_img
// id (Image ID)
$hero_bg = get_field('term_featured_img',$object);

// 4. term_gallery
// array
$term_gallery = get_field('term_gallery',$object);

// 5. menu_order
// integer
$menu_order = get_field('menu_order',$object);

// 6. term_color
// string (HEX)
$term_color = get_field('term_color',$object);

// 7. term_common_block
// id (Common block ID)
$term_common_block = get_field('term_common_block',$object);

?>
<main>
	<?php if( $term_common_block  ) :
		 mkt_get_content($term_common_block);
	else : ?>
		<div class="hero hero-<?php echo $object->taxonomy; ?> hero-<?php echo $object->slug; ?> bg-cover bg-center" <?php if( $hero_bg ) : ?>style ="background-image: url(<?php echo esc_url(wp_get_attachment_url($hero_bg)); ?>);"<?php endif; ?>>
			<header>
				<h1>
					<?php echo $toptitle ? '<span class="toptitle">' . esc_html($toptitle) . '</span>' : null; ?>
					<?php echo esc_html($object->name); ?>
					<?php echo $subtitle ? '<span class="subtitle">' . esc_html($subtitle) . '</span>' : null; ?>
				</h1>
				<?php if( $object->description ) : ?>
					<p><?php echo $object->description; ?></p>
				<?php endif; ?>
			</header>
		</div>
	<?php endif; ?>
	<div class="loop loop-<?php echo esc_attr($object->taxonomy); ?> loop-<?php echo esc_attr($object->slug); ?> " <?php if( $hero_bg ) : ?>style ="background-image: url(<?php echo esc_url(wp_get_attachment_url($hero_bg)); ?>);"<?php endif; ?>>
		<?php if( have_posts() ) : ?>
			<div>
				<?php while( have_posts() ) :
					the_post(); 
					?>
					<?php mkt_get_template('post/post-card'); ?>
				<?php endwhile; ?>
			</div>
		<?php endif; 
		wp_reset_postdata(); ?>
	</div>
</main>
<?php get_footer();