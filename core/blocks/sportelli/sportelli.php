<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Banner with 2 columns Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'block-' . $block['id'];
if( !empty( $block['anchor'] ) ) {
  $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" value.
$class_name = 'sportelli';	
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Sportelli
$sportelli_liguria = new WP_Query([
	'post_type'			=>	'store',
	'posts_per_page'	=>	-1,
	'order'				=>	'ASC',
	'orderby'			=>	'menu_order',
	'meta_key'			=>	'store_region',
	'meta_value'		=>	'liguria'
]);

$sportelli_piemonte = new WP_Query([
	'post_type'			=>	'store',
	'posts_per_page'	=>	-1,
	'order'				=>	'ASC',
	'orderby'			=>	'menu_order',
	'meta_key'			=>	'store_region',
	'meta_value'		=>	'piemonte'
]);

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon( 'sportelli', null, 'block-project' ); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if ( $sportelli_liguria->have_posts() ) : ?>
				<div>
					<h3 class="text-primary font-bold">Gli sportelli Airen in Liguria</h3>
					<p>Ci trovi a Genova, Savona, Chiavari e Sanremo</p>
					<ul>
						<?php while ( $sportelli_liguria->have_posts() ) :
							$sportelli_liguria->the_post(); 
							?>
							<li><?php the_title(); ?></li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php else : ?>
				<div>
					<h3 class="text-primary font-bold">Gli sportelli Airen in Liguria</h3>
					<span>Nessuno sportello trovato</span>
				</div>
			<?php endif;
			if ( $sportelli_piemonte->have_posts() ) : ?>
				<div>
					<h3 class="text-primary font-bold">Gli sportelli Airen in Piemonte</h3>
					<p>Ci trovi a Torino in Corso tassoni, Via Dante Di Nanni e Corso Orbassano</p>
					<ul>
						<?php while ( $sportelli_piemonte->have_posts() ) : 
							$sportelli_piemonte->the_post(); 
							?>
							<li><?php the_title(); ?></li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php else : ?>
				<div>
					<h3 class="text-primary font-bold">Gli sportelli Airen in Piemonte</h3>
					<span>Nessuno sportello trovato</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	?>
	<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($class_name); ?>">
		<?php if ( $sportelli_liguria->have_posts() ) : ?>
			<div class="sportelli-wrap">
				<div class="sportelli-regione">
					<div>
						<h3 class="text-primary font-bold">Gli sportelli Airen in Liguria</h3>
						<p>Ci trovi a Genova, Savona, Chiavari e Sanremo</p>
					</div>
				</div>
				<div class="sportelli-loop">
					<?php while ( $sportelli_liguria->have_posts() ) : 
						$sportelli_liguria->the_post();
						mkt_get_template('store/store-card');
					endwhile; ?>
				</div>
			</div>
		<?php wp_reset_postdata(); 
		endif;
		if ( $sportelli_piemonte->have_posts() ) : ?>
			<div class="sportelli-wrap">			
				<div class="sportelli-regione">
					<div>
						<h3 class="text-primary font-bold">Gli sportelli Airen in Piemonte</h3>
						<p>Ci trovi a Torino in Corso tassoni, Via Dante Di Nanni e Corso Orbassano</p>
					</div>
				</div>
				<div class="sportelli-loop">
					<?php while ( $sportelli_piemonte->have_posts() ) :
						$sportelli_piemonte->the_post();
						mkt_get_template('store/store-card');
					endwhile; ?>
				</div>
			</div>
		<?php wp_reset_postdata(); 
		endif; ?>
	</div>
<?php endif;