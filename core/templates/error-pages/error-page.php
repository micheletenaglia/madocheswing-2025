<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Fonts
$fonts = [];

// Google fonts
$google_fonts = get_field('google_fonts', 'options');
// If Google fonts
if( isset($google_fonts['url']) && !empty($google_fonts['url']) ) {
    $fonts[] = $google_fonts['url'];
}

// Adobe fonts
$adobe_fonts = get_field('adobe_fonts', 'options');
// If Adobe fonts
if( isset($adobe_fonts['url']) && !empty($adobe_fonts['url']) ) {
    $fonts[] = $adobe_fonts['url'];
}

// Woff fonts
$primary_font_woff = get_field('primary_font_woff', 'options');
$secondary_font_woff = get_field('secondary_font_woff', 'options');
$extra_font_woff = get_field('extra_font_woff', 'options');
// If WOFF primary font
if( isset($primary_font_woff['url']) && !empty($primary_font_woff['url']) ) {
    $fonts[] = $primary_font_woff['url'];
}
// If WOFF secondary font
if( isset($secondary_font_woff['url']) && !empty($secondary_font_woff['url']) ) {
    $fonts[] = $secondary_font_woff['url'];
}
// If WOFF extra font
if( isset($extra_font_woff['url']) && !empty($extra_font_woff['url']) ) {
    $fonts[] = $extra_font_woff['url'];
}

// Logo
$logo_size = get_field('logo_other_version','options');
// If logo size
if( $logo_size ) {
    $logo_width = $logo_size['width'] . 'px';
    $logo_height = $logo_size['height'] . 'px';
}else{
    $logo_width = 'auto';
    $logo_height = '2rem';
}

// Texts
$captions = [
    401 =>  __('Unauthorized','mklang'),
    403 =>  __('Forbidden','mklang'),
];
$title = $_REQUEST['status'];
$caption = $captions[$title];

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php if( get_field('mobile_bar_color', 'options') ) : ?>
		<meta name="theme-color" content="<?php echo get_field('mobile_bar_color', 'options'); ?>" />
		<meta name="msapplication-navbutton-color" content="<?php echo get_field('mobile_bar_color', 'options'); ?>">
	<?php endif; ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="robots' content='noindex, nofollow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
    <?php foreach( $fonts as $font_url ) : ?>
        <link rel="stylesheet" href="<?php echo esc_url($font_url); ?>" media="all" />
    <?php endforeach; ?>
    <link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/project/assets/css/frontend.css'); ?>" media="all" />
    <?php echo get_option('options_favicons_favicon_code'); ?>
</head>
<body <?php body_class(); ?>>
    <div class="h-screen flex flex-col justify-center items-center bg-white text-primary">
        <div style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>;">
            <?php echo mkt_get_logo( 'w-full h-auto' ); ?>
        </div>
        <div class="font-bold text-9xl"><?php echo esc_html($title); ?></div>
        <strong><?php echo esc_html($caption); ?></strong>
    </div>
</body>
</html>