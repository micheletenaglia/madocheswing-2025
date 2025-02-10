<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: WPML Switcher.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get languages
$current_lang = null;
$default_lang = null;
$siteurl = get_option('siteurl');
$home_url = null;
$languages = mkt_get_languages();
if( mkt_plugin_active('wpml') ) {
	$current_lang = apply_filters( 'wpml_current_language', null );
	$default_lang = apply_filters('wpml_default_language', NULL );	
	$home_url = apply_filters( 'wpml_home_url', get_option( 'home' ) );
}

// CSS Classes
$class_name = '';
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// ID for anchor
$id = null;
if( !empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('wpml-switcher',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo esc_attr($block['description']); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( mkt_plugin_active('wpml') ) :
				do_action('wpml_add_language_selector');
			else : ?>
				<strong class="text-error"><?php _e('WPML is not active.','mklang'); ?></strong>
			<?php endif; ?>
		</div>
	</div>
<?php else : 
	// Frontend
	// !!! Use PHP class or function here
	if( mkt_plugin_active('wpml') ) : ?>
		<div class="mkcf-wpml-switcher-wrap">
			<span class="js-wpml-switcher"><?php echo $current_lang; ?></span>
            <?php if( 
                apply_filters( 'wpml_is_translated_post_type', NULL, get_post_type($post_id) ) ||
                is_404() ||
                is_search()
            ) : ?>
				<div class="mkcf-wpml-switcher">
					<?php do_action('wpml_add_language_selector'); ?>
				</div>
			<?php else : ?>
				<div class="mkcf-wpml-switcher">
					<div class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-list-horizontal">
						<ul>
							<?php $index = 0; foreach( $languages as $code => $label ) : $index++; ?>
								<?php $url = 
									str_replace( 
										$home_url, 
										($siteurl . '/' . esc_attr($code) . '/' ),
										get_current_url()
									);
									if( $code == $default_lang ) {
										$url = str_replace( 
											'/' . $code . '/',
											'/',
											$url
										);
									}
									$current = ( $code == $current_lang ) ? 'wpml-ls-current-language' : null;
									$first = ( $index == 1 ) ? 'wpml-ls-first-item' : null;
								?>
								<li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-<?php echo esc_attr($code); ?> <?php echo esc_attr($current); ?> <?php echo esc_attr($first); ?> wpml-ls-item-legacy-list-horizontal">
									<a href="<?php echo esc_url($url); ?>" class="wpml-ls-link">
										<span class="wpml-ls-native" lang="<?php echo esc_attr($code); ?>"><?php echo esc_html($label); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php endif;
 endif;