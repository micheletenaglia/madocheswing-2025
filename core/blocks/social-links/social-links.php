<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Block Template: Social links.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$social_links = get_field('social_links');
$display = get_field('display_options');
$icon_classes = get_field('icon_classes');
$a_classes = get_field('a_classes');
$wrapper = get_field('wrapper');

// CSS Classes.
$class_name = '';	
if( !empty( $block['className'] ) ) { 
	$class_name .= $block['className'];
}

// Labels
$labels = [
    'facebook'      =>  'Facebook',
    'instagram'     =>  'Instagram',
    'twitter'       =>  'X (Twitter)',
    'youtube'       =>  'Youtube',
    'vimeo'         =>  'Vimeo',
    'linkedin'      =>  'Linkedin',
    'tiktok'        =>  'Tiktok',
    'spotify'       =>  'Spotify',
    'pinterest'     =>  'Pinterest',
    'google_maps'   =>  'Google Maps',
    'mailchimp'     =>  'Newsletter',
    'whatsapp'      =>  'Whatsapp',
    'telegram'      =>  'Telegram',
    'signal'        =>  'Signal',
];

// Backend
if( $is_preview ) : ?>
	<div class="mkcb-wp-block">
		<div class="mkcb-wp-block-info">
			<div class="mkcb-wp-block-info-left">
				<figure class="mkcb-wp-block-info-icon">
					<?php echo get_svg_icon('social-links',null,'block-core'); ?>
				</figure>
				<div>
					<span class="mkcb-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="mkcb-wp-block-desc"><?php echo sprintf(__('Social media links filled in on the <a href="%s" target="_blank" rel="nofollow noopener noreferrer">options page</a>.','mklang'),esc_url(add_query_arg('page','options',admin_url('admin.php')))); ?></span>
				</div>
			</div>
		</div>
		<div class="mkcb-wp-block-content">
			<?php if( !$social_links ) : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','mklang'); ?></strong>
			<?php else : ?>
                <ul>
                    <?php foreach( $labels as $field => $label ) :
                        if( in_array( $field, $social_links ) ) :
                            if( get_field( $field, 'options') ) :
                                ?>
                                <li><?php echo $label; ?></li>
                            <?php else : ?>
                                <li class="text-error"><?php echo sprintf( __('The field <strong>%s</strong> has no value.','mklang'), $label ); ?></li>
                            <?php endif;
                        endif;
                    endforeach; ?>
                </ul>
			<?php endif; ?>
		</div>
	</div>
<?php else :
    // Frontend
    if( $social_links ) :
        if( $wrapper == 'ul' ) :
            ?>
            <ul class="<?php echo esc_attr($class_name); ?>">
                <?php foreach( $labels as $field => $label ) :
                    if( in_array( $field, $social_links ) && get_field( $field, 'options') ) :
                        ?>
                        <li class="<?php echo esc_attr($field); ?>"><?php echo do_shortcode('[get_social_link name="' . esc_attr($field) . '" icon="' . esc_attr($display) . '" icon_classes="' . esc_attr($icon_classes) . '" a_classes="' . esc_attr($a_classes) . '"]'); ?></li>
                    <?php endif;
                endforeach; ?>
            </ul>
        <?php else : ?>
            <?php foreach( $labels as $field => $label ) :
                if( in_array( $field, $social_links ) && get_field( $field, 'options') ) :
                    ?>
                    <span class="<?php echo esc_attr($field); ?>"><?php echo do_shortcode('[get_social_link name="' . esc_attr($field) . '" icon="' . esc_attr($display) . '" icon_classes="' . esc_attr($icon_classes) . '" a_classes="' . esc_attr($a_classes) . '"]'); ?></span>
                <?php endif;
            endforeach; 
        endif;
    endif;
endif;