<?php

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

/**
 * Functions for both frontend and backend media management.
 *
 * Do not edit directly!
 * The functions.php file must be used 
 * to add functionality to the site.
 * 
 * @since Hap Studio Theme 1.0
 */

 /****************************************************************************************
  __  __ _____ ____ ___    _    
 |  \/  | ____|  _ \_ _|  / \   
 | |\/| |  _| | | | | |  / _ \  
 | |  | | |___| |_| | | / ___ \ 
 |_|  |_|_____|____/___/_/   \_\

****************************************************************************************/

/* Filters ----------------------------------------------------------------------------*/

// Add lazy loading to iframes
add_filter( 'wp_iframe_tag_add_loading_attr', '__return_true' );

// !!! This works only sometimes
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

// Add mime types to media upload
add_filter('upload_mimes', 'hap_upload_mimes');

// Set largest image threshold
add_filter('big_image_size_threshold','hap_big_image_size_threshold',10,4);

// Unset default "Organize my uploads into month- and year-based folders"
add_filter('option_uploads_use_yearmonth_folders', '__return_false', 100);

// Set the maximum image size of the images uploaded in WP Media Library
add_filter( 'wp_handle_upload_prefilter', 'hap_max_upload_image_size' );

/* Actions ----------------------------------------------------------------------------*/

// Set default values in media uploader
add_action('after_setup_theme', 'hap_default_attachment_display_settings');

// Automatically set the image Title, Alt-Text, Caption & Description upon upload
add_action('add_attachment', 'hap_image_upload' );

// Generate favicons
add_action('acf/save_post', 'hap_generate_favicons', 20);

/* Functions --------------------------------------------------------------------------*/

/**
 * Add MIME types.
 * Add the following line in wp-config.php to allow SVG uploads:
 * define('ALLOW_UNFILTERED_UPLOADS', true);
 *
 * @param array $mimes
 * @return array $mimes
 */
function hap_upload_mimes( $mimes ) {
	// Allow SVG file upload
	$mimes['jpg']	= 'image/jpeg';
	$mimes['png']	= 'image/png';
	$mimes['gif']	= 'image/gif';
	$mimes['svg']	= 'image/svg';
	$mimes['svg']   = 'image/svg+xml';
	$mimes['svgz']	= 'image/svg';
	$mimes['webp']	= 'image/webp';
	$mimes['wav']	= 'audio/wav, audio/x-wav';
	$mimes['ogg']	= 'audio/ogg';
	$mimes['mp3']	= 'audio/mpeg3, audio/x-mpeg-3, video/mpeg, video/x-mpeg';
	$mimes['mp4']	= 'video/mp4';
	$mimes['m4v']	= 'video/x-m4v';
	$mimes['webm']	= 'video/webm';
	$mimes['pdf']	= 'application/pdf';
	$mimes['doc']	= 'application/msword';
	$mimes['docx']	= 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	$mimes['xlsx']	= 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$mimes['xls']	= 'application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel';
	$mimes['odt']	= 'application/vnd.oasis.opendocument.text';
	$mimes['csv']	= 'text/csv';
	$mimes['woff']	= 'application/x-font-woff';
	$mimes['woff2']	= 'application/x-font-woff2';
	$mimes['ttf']	= 'font/ttf';
	return $mimes;
}

/**
 * Automatically set the image title, alt-Text, caption and description upon upload.
 *
 * @param integer $post_ID
 * @return void
 */
function hap_image_upload($post_ID) {
    // If this is an attachment
	if( wp_attachment_is_image($post_ID) ) {
        // Get title
		$image_title = get_post($post_ID )->post_title;
        $image_title = preg_replace('%\s*[-_\s]+\s*%', ' ',$image_title);
        $image_title = ucwords( strtolower($image_title));
        $image_meta = array(
            'ID'            => $post_ID,
            'post_title'    => $image_title,
            //'post_excerpt'  => $image_title, // Set image Caption (Excerpt)
            //'post_content'  => $image_title, // Set image Description (Content)
        );
		// Update image alt attribute
        update_post_meta($post_ID, '_wp_attachment_image_alt', $image_title);
        // Update post
		wp_update_post($image_meta);
	}
}

/**
 * Set default values in media uploader.
 *
 * @return void.
 */
function hap_default_attachment_display_settings() {
	// Update options
	update_option('image_default_align', 'none');
	update_option('image_default_link_type', 'none');
	update_option('image_default_size', 'large');
}

/**
 * Custom largest image threshold.
 * 
 * @param string $threshold
 * @param string $imagesize
 * @param string $file
 * @param integer $attachment_id
 * @return integer $size
 */
function hap_big_image_size_threshold( $threshold, $imagesize, $file, $attachment_id ) {
	return 2048;
}

/**
 * Add image sizes.
 * 
 * @retrun void.
 */
if( function_exists('add_image_size') ) { 
	
	// Remove image sizes
	remove_image_size('1536x1536');
	remove_image_size('2048x2048');
	remove_image_size('768x768');
	
	// Set default image sizes
	// Thumbnail
	update_option( 'thumbnail_size_w', 320 );
	update_option( 'thumbnail_size_h', 320 );
	// Medium
	update_option( 'medium_size_w', 640 );
	update_option( 'medium_size_h', null );
	// Large
	update_option( 'large_size_w', 960 );
	update_option( 'large_size_h', null );	
	
	// Add image sizes
	add_image_size('admin-list-thumb', 80, 80, true);
	add_image_size('full-hd-thumb', 1920, 1280, true );
	add_image_size('max-thumb', 2048, 2048, true );
	add_image_size('social', 1200, 630, ['center','center'] );
	// add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
	
}

/**
 * Get iframe/oembed.
 * 
 * @param string $iframe
 * @return string $iframe
 */
function get_oembed($iframe) {
	// Use preg_match to find iframe src.
	preg_match('/src="(.+?)"/', $iframe, $matches);
	$src = $matches[1];
	// Add extra parameters to src and replace HTML.
	$params = array(
		'controls'  => 0,
		'hd'        => 1,
		'autohide'  => 1
	);
	$new_src = esc_url(add_query_arg($params, $src));
	$iframe = str_replace($src, $new_src, $iframe);
	// Add extra attributes to iframe HTML.
	$attributes = 'frameborder="0"';
	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
	// Display customized HTML.
	$iframe = '<div class="oembed">' . $iframe . '</div>';
	return $iframe;
}

/**
 * Get Html5 Video.
 * 
 * @param string $field
 * @return string $video
 */
function get_html_video( $field ) {
	// Attributes
	$attrs = [
		'width'		=>	'width="' . $field['width'] . '"',
		'width'		=>	'height="' . $field['height'] . '"',
		'controls'	=>	'controls=""',
	];
    // STart HTML
	$video = '<video ' . implode( ' ', $attrs ) . '>';
		$video .= '<source src="' . $field['url'] . '" type="video/mp4">';
		// <source src="movie.ogg" type="video/ogg">
		$video .= __('Your browser does not support the video tag.','hap');
	$video .= '</video>';
	return $video;
}

/**
 * Generate favicon image file versions and code for head.
 * Setup is made in ../wp-admin/admin.php?page=options-layout
 * In order to generate all data correctly the SVG favicon image field
 * and the PNG favicon image field are required. 
 * This function also writes into MS XML configuration file
 * and Android Chrome JSON configuration file.
 * 
 * @return void.
 */
function hap_generate_favicons() {
    // Bail out is this is not an administrator
	if( !current_user_can( 'manage_options' ) ) {
		return;
	}
 	// Get favicons option
	$favicons = get_field( 'favicons', 'options' );
	// Check if 'regenerate_favicons' is flagged to avoid launching this action at every save
	if( $favicons ) {
		if( !$favicons['regenerate_favicons'] ) {
			return;
		}
	}
	// Get favicon file uploaded by user
	$filename = get_attached_file( $favicons['favicon'] );
	if( !$filename ) {
		return;
	}
	// Array of versions
	$versions = [
		// Generic
		// '16'	=>	'generic',
		'32'	=>	'generic',
		// '57'	=>	'generic',
		// '76'	=>	'generic',
		// '96'	=>	'generic',
		// '128'	=>	'generic',
		// '192'	=>	'generic',
		// '228'	=>	'generic',
		// Android
		// '196'	=>	'android',
		// iOS
		// '120'	=>	'apple',
		// '152'	=>	'apple',
		// '167'	=>	'apple',
		'180'	=>	'apple',
		// Android Chrome (JSON)
		'192'	=>	'android',
		'512'	=>	'android',
		// MS (XML)
		'70'	=>	'microsoft',
		'150'	=>	'microsoft',
		'310'	=>	'microsoft',
	];
	// Favicon dirs
	$favicon_path = HAP_PROJECT . 'favicon/';
	$favicon_uri = HAP_PROJECT_URI . 'favicon/';
	// Get array of uploads directory info
	// $uploads = wp_upload_dir();
	// Get uploads directory url
	// $favicon_uri = $uploads['url'];
	// Generate files
	foreach( $versions as $size => $type ) {
		// Use object buffering to avoid issues with headers
		ob_start();
		// Set correct image header for PNG file
		header('Content-type: image/png');
		// Get file sizes
		list( $width, $height ) = getimagesize($filename);
		// write_log($image_p);
		// Duplicate content from PNG
		$image = imagecreatefrompng($filename);
		// Create image with transparent background
		$image_p = imagecreatetruecolor( $size, $size );	
		imagealphablending($image_p, false);
		imagesavealpha($image_p, true);		
		$color = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
		imagefill($image_p, 0, 0, $color);
		// Create the definitive image
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size, $size, $width, $height);
		// Set directory to save the image file
		// $dir = ABSPATH . 'wp-content/uploads/favicon-' . $size . 'x' . $size . '.png';
		$dir = $favicon_path . 'favicon-' . $size . 'x' . $size . '.png';
		// Save filed to directory
		imagepng($image_p, $dir, 0);
		// Destroy image
		imagedestroy( $image );
		// Clean object
		ob_end_clean();
	}
	// Empty var to store favicon code for head
	$favicon_code = null;
	// If an SVG version has been uploaded by user
	if( $favicons['favicon_svg'] ) {
		$svg_url = ( is_ssl() ) ? str_replace( 'http://', 'https://', wp_get_attachment_url( $favicons['favicon_svg'] ) ) : wp_get_attachment_url( $favicons['favicon_svg'] );
		$favicon_code .= '<link rel="icon" type="image/svg+xml" sizes="all" href="' . $svg_url . '">' . PHP_EOL;
	}
	// Loop through sizes
	foreach( $versions as $size => $type ) {	
		// Sizes (Ex: '16x16')
		$sizes = $size . 'x' . $size;
		// If is an icon for Windows
		if( $type == 'generic' ) {
			$favicon_code .= '<link rel="icon" type="image/png" sizes="' . $sizes . '" href="' . $favicon_uri . 'favicon-' . $sizes . '.png" />' . PHP_EOL;
		// If is an icon for Android
		/*}elseif( $type == 'android' ) {
			$favicon_code .= '<link rel="shortcut icon" type="image/png" sizes="' . $sizes . '" href="' . $favicon_uri . 'favicon-' . $sizes . '.png" />' . PHP_EOL;
		*/
		// If is an icon for iOS
		}elseif( $type == 'apple' ) {
			$favicon_code .= '<link rel="apple-touch-icon" sizes="' . $sizes . '" href="' . $favicon_uri . 'favicon-' . $sizes . '.png" />' . PHP_EOL;
		}
	}
	// Generate code for manifest.webmanifest (Android Chrome)
	$manifest_192 = [
		'src'	=>	 $favicon_uri . 'favicon-192x192.png',
		'type'	=>	'image/png',
		'sizes'	=>	'192x192'
	];
	$manifest_512 = [
		'src'	=>	 $favicon_uri . 'favicon-512x512.png',
		'type'	=>	'image/png',
		'sizes'	=>	'512x512'
	];
	$manifest = [
		'icons'	=>	[
			(object) $manifest_192,
			(object) $manifest_512,
		],
	];
	$manifest_json = json_encode( $manifest );
	// Write into manifest.webmanifest
	$manifest_webmanifest = fopen( $favicon_path . 'manifest.webmanifest', 'w') or die( __('Unable to open file!','hap') );
	fwrite( $manifest_webmanifest, $manifest_json );
	fclose( $manifest_webmanifest );
	// Add JSON file to $favicon_code
	// This was removed because manifest.webmanifest is not required and affects performance too much
	// $favicon_code .= '<link rel="manifest" href="' . $favicon_uri . 'manifest.webmanifest">' . PHP_EOL;
	// Generate code for browserconfig.xml (Microsoft)
	$mobile_bar_color = ( get_field( 'mobile_bar_color', 'options' ) ) ? get_field( 'mobile_bar_color', 'options' ) : '#FFFFFF';
	$favicon_xml = '<?xml version="1.0" encoding="utf-8"?>';
	$favicon_xml .= '<browserconfig>';
	$favicon_xml .= '<msapplication>';
	$favicon_xml .= '<tile>';
	$favicon_xml .= '<square70x70logo src="' . $favicon_uri . 'favicon-70x70.png"/>';
	$favicon_xml .= '<square150x150logo src="' . $favicon_uri . 'favicon-150x150.png"/>';
	$favicon_xml .= '<square310x310logo src="' . $favicon_uri . 'favicon-310x310.png"/>';
	$favicon_xml .= '<TileColor>' . $mobile_bar_color . '</TileColor>';
	$favicon_xml .=' </tile>';
	$favicon_xml .= '</msapplication>';
	$favicon_xml .= '</browserconfig>';
	// Write into browserconfig.xml
	$browserconfig = fopen( $favicon_path . 'browserconfig.xml', 'w') or die( __('Unable to open file!','hap') );
	fwrite( $browserconfig, $favicon_xml );
	fclose( $browserconfig );
	// Add XML file to $favicon_code
	// This was removed because manifest.webmanifest is not required and affects performance too much
	// $favicon_code .= '<meta name="msapplication-config" content="' . $favicon_path . 'browserconfig.xml" />' . PHP_EOL;
	// Update 'favicon_code' field in layout options page
	update_field( 'favicons_favicon_code', $favicon_code, 'options' );
	// Update 'favicon_manifest_json' field in layout options page
	update_field( 'favicons_favicon_manifest_json', $manifest_json, 'options' );
	// Update 'favicon_xml' field in layout options page
	update_field( 'favicons_favicon_xml', $favicon_xml, 'options' );
	// Reset 'regenerate_favicons' field in layout options page
	update_field( 'favicons_regenerate_favicons', false, 'options' );
	// Note on updating field in groups: Suppose a Group field named "hero" with a sub field named "image"... it will be saved to the database using the meta name "hero_image"
}

/**
 * Get all the registered image sizes along with their dimensions
 *
 * @global array $_wp_additional_image_sizes
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 * @link https://wordpress.stackexchange.com/questions/33532/how-to-get-a-list-of-all-the-possible-thumbnail-sizes-set-within-a-theme
 *
 * @return array $image_sizes The image sizes
 */
function hap_get_all_thumb_sizes() {
    // Get global
	global $_wp_additional_image_sizes;
    // Default sizes
    $default_image_sizes = get_intermediate_image_sizes();
    // Loop sizes
    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }
    // Check for other sizea
    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        // Merge arrays
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }
    return $image_sizes;
}

/**
 * Set the maximum image size 
 * of the images uploaded in WP Media Library
 *
 * @param array $file
 * @return array $file
 */
function hap_max_upload_image_size( $file ) {
    // Bail out early
    if( !get_field( 'media_library_max_image_size', 'options' ) ) {
        return $file;
    }
    // Set limit
    $limit = intval( get_field( 'media_library_max_image_size', 'options' ) );
    // Get fiel size
    $size = $file['size'] / 1024;
    // Check if this is an image
    $is_image = strpos( $file['type'], 'image' ) !== false;
    // If is an image and the size is voer the limit
    if( $is_image && $size > $limit ) {
        $file['error'] = sprintf( __('Image files must be smaller than %skb','hap'), $limit );
    }
    return $file;
}

/**
 * Get image markup by image or post ID.
 *
 * @param integer $image_id
 * @param string $size
 * @param array $options
 *      string  id
 *      boolean lazy
 *      boolean priority 
 *      string  img_class
 *      boolean figure
 *      string  fig_class
 *      string  caption
 *      string  style
 *      integer bg_image
 *      boolean return
 * @return string $img
 */
function hap_thumb( $image_id, $size = 'post-thumbnail', $options = [] ) {
    // Check if the ID is a post ID or an attachment ID
    if( get_post_type($image_id) != 'attachment' ) {
        // get the post thumbnail ID
        $image_id = get_post_thumbnail_id($image_id);
    }
    // Bail out early
    if( !$image_id ) {
        return;
    }
    // Get mime type
    $mime = get_post_mime_type($image_id);
    // Allowed mime types
    $mimes = [
        'image/avif',
        'image/gif',
        'image/jpeg',
        'image/png',
        // 'image/svg+xml',
        'image/webp',
    ];
    // Check mime and bail out if this is not one of the allowed type
    // For SVG use get_svg_img() instead
    if( !in_array( $mime, $mimes ) ) {
        return;
    }
    // Update options and set default values
    $id = isset($options['id']) ? $options['id'] : null;
    $lazy = isset($options['lazy']) ? $options['lazy'] : true;
    $priority = isset($options['priority']) ? $options['priority'] : false;
    $img_class = isset($options['img_class']) ? $options['img_class'] : '';
    $figure = isset($options['figure']) ? $options['figure'] : false;
    $fig_class = isset($options['fig_class']) ? $options['fig_class'] : '';
    $fig_caption = isset($options['caption']) ? $options['caption'] : '';
    $css_rules = isset($options['style']) ? $options['style'] : null;
    $bg_image = isset($options['bg_image']) ? $options['bg_image'] : null;
    $return = isset($options['return']) ? $options['return'] : false;
    // Default attributes
    $attrs = '';
    // Get sizes
    $sizes = [
        'thumbnail'     =>  wp_get_attachment_image_src($image_id,'thumbnail'),
        'medium'        =>  wp_get_attachment_image_src($image_id,'medium'),
        'medium_large'  =>  wp_get_attachment_image_src($image_id,'medium_large'),
        'large'         =>  wp_get_attachment_image_src($image_id,'large'),
        'full-hd-thumb' =>  wp_get_attachment_image_src($image_id,'full-hd-thumb'),
        'full'          =>  wp_get_attachment_image_src($image_id,'post-thumbnail'),
        'post-thumbnail'=>  wp_get_attachment_image_src($image_id,'post-thumbnail'),
        // Last two items are the same but the key is different for backwards compability
    ];
    $size_index = [
        // 'thumbnail'     =>  1,
        // 'medium'        =>  2,
        'medium_large'  =>  3,
        'large'         =>  4,
        'full-hd-thumb' =>  5,
        'full'          =>  6,
        'post-thumbnail'=>  7,
    ];
    // If ID
    if( $id ) {
        $attrs .= 'id="' . esc_html($id). '" ';
    }
    // If image is above the fold
    if( $priority ) {
        $attrs .= 'fetchpriority="high" ';
    }else{
        // Add lazy loading
        if( $lazy ) {
            $attrs .= 'loading="lazy" ';
        }
    }
    // Set async decoding
    $attrs .= 'decoding="async" ';
    // Set width, height and source
    // Set width
    $attrs .= 'width="' . esc_attr($sizes[$size][1]) . '" ';
    // Set height
    $attrs .= 'height="' . esc_attr($sizes[$size][2]) . '" ';
    // Set source
    $attrs .= 'src="' . esc_url($sizes[$size][0]) . '" ';
    // Set alt text
    $attrs .= 'alt="' . esc_html(get_post_meta($image_id, '_wp_attachment_image_alt', 1)) . '" ';
    // CSS Class
    $attrs .= 'class="img-' . esc_attr($image_id) . '-' . esc_attr($size) . ' ' . esc_attr($img_class) . '" ';
    // Build source set
    if( $size != 'thumbnail' && $size != 'medium' ) {
        // Medium 640
        $scrset = [
            $sizes['medium'][0] . ' 640w', // $sizes['medium'][1]
        ];
        // Medium large 768
        if( $sizes['medium_large'] && $size != 'medium_large' && $size_index[$size] > $size_index['medium_large'] ) {
            $scrset[] = $sizes['medium_large'][0] . ' 768w';
        }
        // Large 960
        if( $sizes['large'] && $size != 'large' && $size_index[$size] > $size_index['large'] ) {
            $scrset[] = $sizes['large'][0] . ' 960w';
        }
        // Over
        $scrset[] = $sizes['post-thumbnail'][0];
        // Add source set
        $attrs .= 'srcset="' . implode( ', ', $scrset ) . '" ';
        // Add max size;
        $attrs .= 'sizes="' . '(max-width: ' . esc_attr($sizes[$size][1]) . 'px) 100vw, ' . esc_attr($sizes[$size][1]) . 'px" ';
    }
    // If style or background image
    $style = '';
    if( $css_rules ) {
        $style = esc_attr( $css_rules );
    }
    if( $bg_image ) {
        // Get same size image
        $bg_image = wp_get_attachment_image_src( $bg_image,$size );
        $style .= ' background-image: url(' . esc_url($bg_image[0]) . ')';
    }
    if( $style ) {
        $attrs .= ' style="' . $style . '"';
    }
    // Output
    $img = '<img ' . $attrs . '/>';
    // If figure
    if( $figure ) {
        $img = '<figure class="' . esc_attr($fig_class) . '">' . $img;
        if( $fig_caption ) {
            $img .= '<figcaption>' . esc_html($fig_caption) . '</figcaption>';
        }
        $img .= '</figure>';
    }
    // Retrun options
    if( $return ) {
        return $img;
    }else{
        // Default
        echo $img;
    }
}