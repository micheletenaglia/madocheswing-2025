<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Utility functions.
 *
 */

/*-------------------------------------------------------------------------------------*/
// Plugins

/**
 * Pugins activation check.
 * Other plugins
 * - limit-login-attempts-reloaded
 * - sg-cachepress
 * - sg-security
 * @param string $plugin
 */
function mkt_plugin_active( $plugin ) : bool {
    // Check if ACF is activated
    if( $plugin == 'acf' ) {
        return class_exists('acf') ? true : false;
    }
    // Check if WPML is activated
    elseif( $plugin == 'wpml' ) {
        return function_exists('icl_object_id') ? true : false;
    }
    // Check if Wordfence is activated
    elseif( $plugin == 'wordfence' ) {
        if( class_exists('wfWAFIPBlocksController') ) { 
            return true;
        }else{
            return false;
        }
    }
    // Check if WP Supercache is activated
    elseif( $plugin == 'wp-supercache' ) {
        if( function_exists('wpsc_init') ) { 
            return true;
        }else{
            return false;
        }
    }
    // Check if Contact Form 7 is activated
    elseif( $plugin == 'cf7' ) {
        return class_exists('WPCF7') ? true : false;
    }
    // Check if Flamingo is activated
    elseif( $plugin == 'flamingo' ) {
        return class_exists('Flamingo_Contact') ? true : false;
    }
    // Check if GTM4WP is activated
    elseif( $plugin == 'tag-manager' ) {
        return function_exists('gtm4wp_init') ? true : false;	
    }
    // Check if WooCommerce is activated
    elseif( $plugin == 'woocommerce' ) {
        return class_exists('woocommerce') ? true : false;
    } 
    // Check if WooCommerce Membership is activated
    elseif( $plugin == 'wc-memberships' ) {
        return class_exists('wc_memberships') ? true : false;
    } 
    // Check if WooCommerce Subscription is activated
    elseif( $plugin == 'wc-subscription' ) {
        return class_exists('wc_subscriptions') ? true : false;
    } 
    // Check if DK-PDF is activated
    elseif( $plugin == 'facetwp' ) {
        return class_exists('FacetWP') ? true : false;
    } 
    // Check if FacetWP is activated
    elseif( $plugin == 'dkpdf' ) {
        return class_exists('DKPDF') ? true : false;
    } 
    // Other plugins
    else{
        // Default values
        $path = $plugin . '/' . $plugin;
        // Yoast
        if( $plugin == 'yoast' ) {
            $path = 'wordpress-seo/wp-seo';
        }
        // Iubenda
        if( $plugin == 'iubenda' ) {
            $path = 'iubenda-cookie-law-solution/iubenda_cookie_solution';
        }
        // Simple History
        if( $plugin == 'simple-history' ) {
            $path = 'simple-history/index.php';
        }
        $path .= '.php';
        if( in_array($path,apply_filters('active_plugins',get_option('active_plugins'))) ) { 
            return true;
        }else{
            return false;
        }
    }
}

/*-------------------------------------------------------------------------------------*/
// Media

/**
 * Get SVG icon.
 * @link https://wordpress.stackexchange.com/questions/312625/escaping-svg-with-kses
 * @param string $name
 * @param string $css_classes
 * @param string $path
 */
function get_svg_icon( $name, $css_classes = 'svg-icon fill-current h-4', $path = 'core' ) : string {
	// Empty var
	$svg = '';
	// 1. Check if file exists 	
	if( $path == 'uploads' ) {
		// Set uploads directory path
		$path = ABSPATH . 'wp-content/uploads/';
	}elseif( $path == 'block-core' ) {
		// Set core block icons path
		$path = get_template_directory() . '/core/blocks/' . str_replace( '-preview', '', $name ) . '/';
	}elseif( $path == 'block-project' ) {
		// Set project block icons path
		$path = get_template_directory() . '/project/blocks/' . str_replace( '-preview', '', $name ) . '/';
	}elseif( $path == 'project' ) {
		// Set path to project
		$path = get_template_directory() . '/project/assets/icons/';
	}elseif( $path == 'core' ) {
		// Set default path
		$path = get_template_directory() . '/core/assets/icons/';
	}
	// Check if file exists
	if( file_exists( $path . $name . '.svg' ) ) {
		$svg = file_get_contents( $path . $name . '.svg' );
        // Sanitize attributes
        $svg = mkt_sanitize_attrs($svg);
        // if string contains not allowed code
        if( !$svg ) {
            return '';
        }
	}else{
		return '';
	}
    // Remove unwanted content
    $svg = strstr( $svg, '<svg');
    // Add class attribute
    $attr = '<svg class="' . esc_attr($css_classes) . '"';
    $svg = str_replace( '<svg', $attr, $svg );
	return $svg;
}

/**
 * Get SVG img.
 * @param string $name
 * @param string $css_classes
 */
function get_svg_img( $svg_id, $css_classes = 'svg-icon fill-current h-4' ) : string {
	// Check if file exists
	if( file_exists( wp_get_original_image_path($svg_id) ) ) {
		$svg = file_get_contents( wp_get_original_image_path($svg_id) );
        // Sanitize attributes
        $svg = mkt_sanitize_attrs($svg);
        // if string contains not allowed code
        if( !$svg ) {
            return '';
        }
	}else{
		return '';
	}
    // Remove unwanted content
    $svg = strstr( $svg, '<svg');
    // Add class attribute
    $attr = '<svg class="' . esc_attr($css_classes) . '"';
    $svg = str_replace( '<svg', $attr, $svg );
	return $svg;
}

/**
 * Get iframe/oembed.
 * @param string $iframe
 */
function get_oembed( $iframe ) : string {
	// Use preg_match to find iframe src.
	preg_match('/src="(.+?)"/',$iframe,$matches);
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
 * Get HTML5 Video.
 * @param string $field
 */
function get_html_video( $field ) : string {
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
		$video .= __('Your browser does not support the video tag.','mklang');
	$video .= '</video>';
	return $video;
}

/**
 * Get image markup by image or post ID.
 * - string  id
 * - boolean lazy
 * - boolean priority 
 * - string  img_class
 * - boolean figure
 * - string  fig_class
 * - string  caption
 * - string  style
 * - integer bg_image
 * - boolean return
 * @param integer $image_id
 * @param string $size
 * @param array $options
 */
function mkt_thumb( $image_id, $size = 'post-thumbnail', $options = [] ) : string {
    // Check if the ID is a post ID or an attachment ID
    if( get_post_type($image_id) != 'attachment' ) {
        // get the post thumbnail ID
        $image_id = get_post_thumbnail_id($image_id);
    }
    // Bail out early
    if( !$image_id ) {
        return '';
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
    if( !in_array($mime,$mimes) ) {
        return '';
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
    // Return options
    if( $return ) {
        return $img;
    }else{
        // Default
        echo $img;
    }
}

/**
 * Convert an image to base64.
 * @link https://stackoverflow.com/questions/3967515/how-to-convert-an-image-to-base64-encoding
 * @param integer $img_id
 * @param string $path
 * @example <img src="<?php echo mkt_img_to_base64(123); ?>" width="" height="" alt="" style="" />
 */
function mkt_img_to_base64( $img_id = 0, $path = '' ) : string {
	// Bail out if no values
	if( !wp_get_attachment_url($img_id) || !file_exists($path) ) {
		return '';
	}
	// Default value
	$base64 = null;
	// Conditionally get file path
	$path = $img_id ? get_attached_file($img_id) : $path;
	// Get file extension
	$type = pathinfo($path,PATHINFO_EXTENSION);
	// Get file content
	$data = file_get_contents($path);
	// If is a SVG file
	if( $type === 'svg' ) {
		$base64 = 'data:image/svg+xml;base64,' . base64_encode($data); 
	// If is a PNG or JPG file
	}else{
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	}
	return $base64;
}

/**
 * This is used to verify attributes inside HTML tags.
 * !!! There is no common way to do this so this maybe not the most secure solution to avoid XSS.
 * @param string $string
 */
function mkt_sanitize_attrs( $string ) : string {
    // Lowercase for better search
    $str_low = strtolower($string);
    // Check for malicious strings
    if( 
        // HTML tags
        str_contains( $str_low, '<html' )
        || str_contains( $str_low, '<body' )
        || str_contains( $str_low, '<script' )
        || str_contains( $str_low, '<object' )
        || str_contains( $str_low, '<iframe' )
        || str_contains( $str_low, '<applet' )
        || str_contains( $str_low, '<embed' )
        || str_contains( $str_low, '<form' )
        || str_contains( $str_low, '<input' )
        || str_contains( $str_low, '<button' )
        // PHP tags
        || str_contains( $str_low, '<?php' )
        // HTML attributes
        || str_contains( $str_low, 'onclick=' )
        || str_contains( $str_low, 'src=' )
        // Javascript
        || str_contains( $str_low, '$' )
        || str_contains( $str_low, '.write' )
        || str_contains( $str_low, 'function' )
        // Other
        || str_contains( $str_low, 'hidden' )
        || str_contains( $str_low, '"submit' )
        || str_contains( $str_low, 'entity' )
    ) {
        // Dump error
        write_log('Bad code in mkt_sanitize_attrs(): ' . $string );
        $string = '';
    }
    // return htmlspecialchars( $string, ENT_NOQUOTES );
    return $string;
}

/*-------------------------------------------------------------------------------------*/
// Custom locate template

/**
 * Cascading template path.
 * @param string $template_name
 * @param array $args
 */
function mkt_get_template( $template_name, $args = [] ) : void {
	if( file_exists( get_template_directory() . '/project/templates/' . $template_name . '.php' ) ) {
		get_template_part( 'project/templates/' . $template_name, null, $args );
	}elseif( file_exists( get_template_directory() . '/core/templates/' . $template_name . '.php' ) ) {
		get_template_part( 'core/templates/' . $template_name, null, $args );
	}
}

/*-------------------------------------------------------------------------------------*/
// Arrays

/**
 * Sanitize array.
 * @param array $array
 * @param string $type
 */
function mkt_sanitize_array( $array, $type = 'simple' ) : array {
	// Default value
	$sanitized_array = [];
	// Simple array
	if( $type == 'simple' ) {
		foreach( $array as $item ) {
			$sanitized_array[] = sanitize_text_field($item);
		}
	}
    // Indexed array
    elseif( $type = 'indexed' ) {
		foreach( $array as $index => $value ) {
			$sanitized_array[sanitize_text_field($index)] = sanitize_text_field($value);
		}
	}
    return $sanitized_array;
}

/*-------------------------------------------------------------------------------------*/
// Get data

/**
 * Array of ACF map data.
 * @param array $address
 */
function mkt_address_data( $address ) : array {
    // Data
	$address_data = [
		$address['street_name'] . ' ' . $address['street_number'],
		$address['post_code'] . ' ' . $address['city'] . ' (' . $address['state_short'] . ')',
		$address['country'] . ' (' . $address['country_short'] . ')',
		'<a target="_blank" rel="noopener noreferrer nofollow" href="https://www.google.it/maps/place/' . $address['lat'] . ',' . $address['lng'] . '">' . __('Get directions','mklang') . '</a>',
	];
	return $address_data;
}

/**
 * Get logo.
 * @param string $css_classes
 * @param string $version
 */
function mkt_get_logo( $css_classes = 'default', $version = 'light' ) : string {
	// Default value
	$logo = '';
	// Get field
	$field = 'logo_' . $version . '_mode';
	$logo_data = get_field($field,'options'); 
	// If field
	if( $logo_data ) {
		// Bail out if no image
		if( !isset($logo_data['img']) ) {
			return '';
		}
		// Get CSS classes
		if( isset($logo_data['css_classes']) ) {
			$logo_classes = $css_classes == 'default' ? $logo_data['css_classes'] : $css_classes;
		}else{
			$logo_classes = $css_classes;
		}
		// If SVG file
		if( $logo_data['img']['subtype'] == 'svg' || $logo_data['img']['subtype'] == 'svg+xml' && $logo_data['svg_inline'] ) {
			$logo_file_name = basename($logo_data['img']['filename'],'.svg');
			$logo = get_svg_icon($logo_file_name,esc_attr($logo_classes),'uploads');
		}else{
            $logo = mkt_thumb( 
                $logo_data['img']['id'], 
                'full', 
                [
                    'return'    =>  true,
                    'lazy'      =>  false,
                    'img_class' =>  esc_attr($logo_classes),
                ] 
            );
		}
	}
	return $logo;
}

/**
 * Conditionally render blocks or post_content.
 * @param integer $post_id
 */
function mkt_get_content( $post_id ) : void {
	// Check if post exists
	$object = get_post($post_id);
	// If post exists
	if( $object ) {
		// Parse blocks
		$blocks = parse_blocks($object->post_content);
		// If blocks were found
		if( $blocks ) {
			// Loop blocks
			foreach( $blocks as $block ) {
				// Render block
				echo render_block($block);
			}
		}else{
			// Print post content
			echo $object->post_content;
		}
	}
}

/**
 * Get array of social media icons with links.
 * @param string $style
 */
function mkt_get_social_media( $style = '' ) : string {
	// Default value
	$icons = [];
	// List of social media
	$socials = [
		'facebook',
		'instagram',
		'tiktok',
		'youtube',
		'linkedin'
	];
	// Loop
	foreach( $socials as $social ) {
		// Check if social media i set in options
		if( get_field($social,'options') ) {
			// Add link with icon
			$icons[] = '<a target="_blank" rel="noopener noreferrer nofollow" aria-label="' . ucfirst($social) . '" title="' . ucfirst($social) . '" href="' . esc_url(get_field($social,'options')) . '">' . get_svg_icon($social,$style) . '</a>';
		}
	}
	return $icons;
}

/**
 * Get post by slug.
 * @param string $slug
 * @param string $post_type
 */
function mkt_get_post_by_slug( $slug, $post_type = 'page' ) : object {
	// Bailout if no slug and return silently
	if( !$slug ) {
		return null;
	}
	// Get post by slug
	$posts = get_posts([
		'numberposts'	=>	1,
		'name'			=>	$slug,
		'post_type'		=>	$post_type,
	]);
	// If post return first post or null
	$post = $posts ? $posts[0] : null;
	return $post;
}

/**
 * Function to replace the deprecated WordPress function get_page_by_title()
 * @link https://make.wordpress.org/core/2023/03/06/get_page_by_title-deprecated/
 * @param string $page_title
 * @param string $post_type
 * @param boolean $filters
 * @param string/array $status
 */
function mkt_get_page_by_title( $page_title, $post_type = 'page', $filters = false, $status = '' ) : object {
    // Args
	$query_args = [
		'post_type'              => $post_type,
		'title'                  => $page_title,
		'post_status'            => $status,
		'numberposts'        	 => 1,
		/*'no_found_rows'          => true,
		'ignore_sticky_posts'    => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'orderby'                => 'post_date ID',
		'order'                  => 'ASC',*/
	];
    // If status
    if( $status && $post_type != 'attachment' ) {
        $query_args['post_status'] = $status;
    }
    // Suppress filters (useful for queries with WPML)
    if( $filters ) {
        $query_args['suppress_filters'] = false;
    }
	/* if( $post_type == 'attachment' ) {
		unset($query_args['post_status']);
	} */
	$query = get_posts($query_args);
    // If results return page object or null
	$page = $query ? $query[0] : null;
	return $page;
}

/**
 * Get public post types.
 * @param string $format
 */
function mkt_get_cpts( $format = 'objects' ) : array {
	// Default value
	$cpts = [];
    /*------------------------------------------------------*/
	// 1a. Args to get the list custom post types
	$cpt_args = [
		'public'                => true,
		'publicly_queryable'    => true,
		// 'exclude_from_search'	=> false,
		// 'show_in_rest'			=> true,
		// '_builtin'              => true, 
		// 'capability_type'    =>  true,
	];
	// 1b. Get the custom post type list (array of objects)
	$cpts = get_post_types( $cpt_args, 'objects' );
    /*------------------------------------------------------*/
	// 2a. Args to get the "page" post type which would otherwise be excluded
	$page_args = [
		'name' => 'page',
	];
	// 2b. Get the "page" post type (array of objects)
	$pages = get_post_types( $page_args, 'objects' );
    /*------------------------------------------------------*/
	// 3. Merge arrays
	$cpts = array_merge( $cpts, $pages );
    /*------------------------------------------------------*/
	// 4. Exclude media (attachemnts)
	unset( $cpts['attachment'] );
    /*------------------------------------------------------*/
	// Sort array by key
	ksort( $cpts );
    /*------------------------------------------------------*/
    // Return
	if( $format == 'string' ) {
		// Get labels
		$cpt_slug_label = [];
		foreach( $cpts as $slug => $object ) {
			$cpt_slug_label[$object->name] = $object->label;
		} 
		$cpts = $cpt_slug_label;
	}
	return $cpts;
}

/**
 * Get all theme templates.
 */
function mkt_get_all_templates() : array {
	// Default value
	$templates = [];
	// Get public post types
	$post_types = mkt_get_cpts('string');
	// Loop post types
	foreach( $post_types as $slug => $label ) {
		// Get post type templates
		$cpt_templates = wp_get_theme()->get_page_templates( null, $slug );
        // Add to main array
		$templates = array_merge( $cpt_templates, $templates );
	}
	// Sort array
	asort($templates);
	return $templates;
}

/**
 * Get WP roles.
 * @param string $role

 */
function mkt_get_role( $role ) : string {
	// Default role
	$selected_role = $role;
	// Default list of roles
	$roles = [
		// Default
		'administrator'	=>	__('Administrator','mklang'),
		'editor'		=>	__('Editor','mklang'),
		'author'		=>	__('Author','mklang'),
		'contributor'	=>	__('Contributor','mklang'),
		'subscriber'	=>	__('Subscriber','mklang'),
		// Yoast
		'wpseo_editor'	=>	__('SEO Editor','mklang'),
		'wpseo_manager'	=>	__('SEO Manager','mklang'),	
		// Woocommerce
		'shop_manager'	=>	__('Shop Manager','mklang'),
		'customer'		=>	__('Customer','mklang'),
		'wpseo_editor'	=>	__('SEO Editor','mklang'),
	];
	// Allow a filter to add other custom roles
	$roles = apply_filters('mkt_get_roles',$roles);
	// If role exists
	if( array_key_exists( $role, $roles ) ) {
        // Update role
		$selected_role = $roles[$role];
	}
	return $selected_role;
}

/**
 * Get percentage.
 * @param integer $total
 * @param integer $part
 * @param string $symbol
 */
function mkt_get_percent( $total, $part, $symbol = '' ) : float {
    // Handle null values
	if( $total === 0 || $part === 0 ) {
        // Set default value
		$percent = 0;
	}else{
        // Calculate percentage
		$percent = ($part * 100) / $total;
	}
    // Handle errors
	if( is_infinite($percent) || is_nan($percent) ) {
        // Set default value
		$percent = 0;
    }else{
        // Format number
        $percent = number_format((float)$percent, 2, '.', '') . $symbol;
    }
	return $percent;
}

/**
 * Get file extension.
 * @param string $file
 */
function get_file_extension( $file = '' ) : string {
	// Convert string to array
	$tmp = explode('.',$file);
    // Get last item in array
	$extension = end($tmp);
	return $extension ? $extension : false;
}

/**
 * Get current URL. !!! This is not accurate
 * @link https://wordpress.stackexchange.com/questions/274569/how-to-get-url-of-current-page-displayed
 */
function get_current_url() : string {
	// Get WP
	global $wp;
	// Get URL
	$current_url = home_url(
        add_query_arg(
            [], 
            $wp->request
        )
    );
	return esc_url($current_url);	
}

/**
 * Get Youtube video image thumb URL from embed URL.
 * @param string $url
 * @param string $size
 */
function get_youtube_thumb( $url, $size = 'hqdefault' ) : string {
    // Build image URL
    $img_url = 'http://img.youtube.com/vi/';
	$img_url .= str_replace('https://www.youtube.com/watch?v=','',$url );
	$img_url .= '/';
	$img_url .= esc_attr($size);
	$img_url .= '.jpg';
    return esc_url($img_url);
}

/**
 * Get youtube video data URL from embed URL.
 * @link https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=mIRhWB5XPLc&format=json
 * @param string $url
 */
function get_youtube_data( $url ) : mixed {
    // Add args to URL 
    $url = esc_url_raw(add_query_arg(
        [
            'url'       =>  esc_url($url),
            'format'    =>  'json'
        ],
        'https://www.youtube.com/oembed'
    ));
    // Get JSON data
    $remote = wp_remote_get(
        $url,
        [
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json'
			]
		]
    );
    // Check data and bail out if errors
    if(
        is_wp_error($remote)
        || 200 !== wp_remote_retrieve_response_code($remote)
        || empty(wp_remote_retrieve_body($remote))
    ) {
        return null;
    }
    // Convert JSON to PHP array
    $data = (array)json_decode($remote['body']);
    // Set minimum dimensions
    if( $data['width'] < 1920 ) {
        $height = intval( ( 1920 * $data['height'] ) / $data['width'] );
        $data['width'] = 1920;
        $data['height'] = $height;
    }
    return $data;
}

/*-------------------------------------------------------------------------------------*/
// Time, data etc.

/**
 * Get an array of weekdays.
 */
function mkt_get_weekdays() : array {
    // List of weekdays
    $weekdays = [
		'monday'	=>	__('Monday','mklang'),
        'tuesday'	=>	__('Tuesday','mklang'),
        'wednesday'	=>	__('Wednesday','mklang'),
        'thursday'	=>	__('Thursday','mklang'),
        'friday'	=>	__('Friday','mklang'),
        'saturday'	=>	__('Saturday','mklang'),
        'sunday'	=>	__('Sunday','mklang'),
    ];
	return $weekdays;
}

/**
 * Get an array of months.
 */
function mkt_get_months() : array {
    // Months
    $months = [
        1   =>  __('January','mklang'),
        2   =>  __('February','mklang'),
        3   =>  __('March','mklang'),
        4   =>  __('April','mklang'),
        5   =>  __('May','mklang'),
        6   =>  __('June','mklang'),
        7   =>  __('July','mklang'),
        8   =>  __('August','mklang'),
        9   =>  __('September','mklang'),
        10  =>  __('October','mklang'),
        11  =>  __('November','mklang'),
        12  =>  __('December','mklang'),
    ];
	return $months;
}

/**
 * Check if a date is a weekend day.
 * @param object $date
 */
function is_weekend( $date ) : bool {
	return date('N',strtotime($date)) >= 6 ? true : false;
}

/**
 * Check if a date is saturday. !!! Make same as is_weekend.
 * @param object $date
 */
function is_saturday( $date ) : bool {
	$weekday = date('l',strtotime($date));
	return 'Saturday' == $weekday ? true : false;
}

/**
 * Check if a date is sunday.  !!! Make same as is_weekend.
 * @param object $date
 */
function is_sunday( $date ) : bool {
	$weekday = date('l',strtotime($date));
	return 'Sunday' == $weekday ? true : false;
}

/*-------------------------------------------------------------------------------------*/
// Geographic

/**
 * Get an array of continents names and codes.
 */
function mkt_get_continents( $key = null ) : mixed {
    // Continents
	$continents = [
		'AF' => __('Africa','mklang'),
		'AS' => __('Asia','mklang'),
		'AM' => __('America','mklang'),
		'NA' => __('North America','mklang'),
		'SA' => __('South America','mklang'),
		'EU' => __('Europe','mklang'),
		'OC' => __('Oceania','mklang'),
		'AN' => __('Antarctica','mklang'),
	];
	// If $key
	if( $key ) {	
		// // If $key exists in array
		if( array_key_exists( $key, $continents ) ) {
			// Return name
			return $continents[$key];
		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $continents;
	}
}

/**
 * Get an array of countries names and codes.
 */
function mkt_get_countries( $key = null ) : array {
    // Countries
	$countries = [
		'AE' => __('United Arab Emirates','mklang'),
		'AF' => __('Afghanistan','mklang'),
		'AL' => __('Albania','mklang'),
		'DZ' => __('Algeria','mklang'),
		'AS' => __('American Samoa','mklang'),
		'AD' => __('Andorra','mklang'),
		'AO' => __('Angola','mklang'),
		'AI' => __('Anguilla','mklang'),
		'AQ' => __('Antarctica','mklang'),
		'AG' => __('Antigua and Barbuda','mklang'),
		'AR' => __('Argentina','mklang'),
		'AM' => __('Armenia','mklang'),
		'AW' => __('Aruba','mklang'),
		'AU' => __('Australia','mklang'),
		'AT' => __('Austria','mklang'),
		'AZ' => __('Azerbaijan','mklang'),
		'BS' => __('Bahamas','mklang'),
		'BH' => __('Bahrain','mklang'),
		'BD' => __('Bangladesh','mklang'),
		'BB' => __('Barbados','mklang'),
		'BY' => __('Belarus','mklang'),
		'BE' => __('Belgium','mklang'),
		'BZ' => __('Belize','mklang'),
		'BJ' => __('Benin','mklang'),
		'BM' => __('Bermuda','mklang'),
		'BT' => __('Bhutan','mklang'),
		'BO' => __('Bolivia','mklang'),
		'BA' => __('Bosnia and Herzegovina','mklang'),
		'BW' => __('Botswana','mklang'),
		'BV' => __('Bouvet Island','mklang'),
		'BR' => __('Brazil','mklang'),
		'IO' => __('British Indian Ocean Territory','mklang'),
		'BN' => __('Brunei Darussalam','mklang'),
		'BG' => __('Bulgaria','mklang'),
		'BF' => __('Burkina Faso','mklang'),
		'BI' => __('Burundi','mklang'),
		'KH' => __('Cambodia','mklang'),
		'CM' => __('Cameroon','mklang'),
		'CA' => __('Canada','mklang'),
		'CV' => __('Cape Verde','mklang'),
		'KY' => __('Cayman Islands','mklang'),
		'CF' => __('Central African Republic','mklang'),
		'TD' => __('Chad','mklang'),
		'CL' => __('Chile','mklang'),
		'CN' => __('China','mklang'),
		'CX' => __('Christmas Island','mklang'),
		'CC' => __('Cocos (Keeling) Islands','mklang'),
		'CO' => __('Colombia','mklang'),
		'KM' => __('Comoros','mklang'),
		'CG' => __('Congo','mklang'),
		'CD' => __('Democratic Republic of the Congo','mklang'),
		'CK' => __('Cook Islands','mklang'),
		'CR' => __('Costa Rica','mklang'),
		'CI' => __('Ivory Coast','mklang'),
		'HR' => __('Croatia','mklang'),
		'CU' => __('Cuba','mklang'),
		'CY' => __('Cyprus','mklang'),
		'CZ' => __('Czech Republic','mklang'),
		'DK' => __('Denmark','mklang'),
		'DJ' => __('Djibouti','mklang'),
		'DM' => __('Dominica','mklang'),
		'DO' => __('Dominican Republic','mklang'),
		'EC' => __('Ecuador','mklang'),
		'EG' => __('Egypt','mklang'),
		'SV' => __('El Salvador','mklang'),
		'GQ' => __('Equatorial Guinea','mklang'),
		'ER' => __('Eritrea','mklang'),
		'EE' => __('Estonia','mklang'),
		'ET' => __('Ethiopia','mklang'),
		'FK' => __('Falkland Islands (Malvinas)','mklang'),
		'FO' => __('Faroe Islands','mklang'),
		'FJ' => __('Fiji','mklang'),
		'FI' => __('Finland','mklang'),
		'FR' => __('France','mklang'),
		'GF' => __('French Guiana','mklang'),
		'PF' => __('French Polynesia','mklang'),
		'TF' => __('French Southern Territories','mklang'),
		'GA' => __('Gabon','mklang'),
		'GM' => __('Gambia','mklang'),
		'GE' => __('Georgia','mklang'),
		'DE' => __('Germany','mklang'),
		'GB' => __('United Kingdom','mklang'),
		'GH' => __('Ghana','mklang'),
		'GI' => __('Gibraltar','mklang'),
		'GR' => __('Greece','mklang'),
		'GL' => __('Greenland','mklang'),
		'GD' => __('Grenada','mklang'),
		'GP' => __('Guadeloupe','mklang'),
		'GU' => __('Guam','mklang'),
		'GT' => __('Guatemala','mklang'),
		'GN' => __('Guinea','mklang'),
		'GW' => __('Guinea-Bissau','mklang'),
		'GY' => __('Guyana','mklang'),
		'HT' => __('Haiti','mklang'),
		'HM' => __('Heard Island and Mcdonald Islands','mklang'),
		'VA' => __('Vatican City State','mklang'),
		'HN' => __('Honduras','mklang'),
		'HK' => __('Hong Kong','mklang'),
		'HU' => __('Hungary','mklang'),
		'IS' => __('Iceland','mklang'),
		'IN' => __('India','mklang'),
		'ID' => __('Indonesia','mklang'),
		// 'IR' => __('Iran, Islamic Republic of','mklang'),
		'IR' => __('Iran','mklang'),
		'IQ' => __('Iraq','mklang'),
		'IE' => __('Ireland','mklang'),
		'IL' => __('Israel','mklang'),
		'IT' => __('Italy','mklang'),
		'JM' => __('Jamaica','mklang'),
		'JP' => __('Japan','mklang'),
		'JO' => __('Jordan','mklang'),
		'KZ' => __('Kazakhstan','mklang'),
		'KE' => __('Kenya','mklang'),
		'KI' => __('Kiribati','mklang'),
		// 'KP' => __('Korea, Democratic People\'s Republic of','mklang'),
		'KP' => __('North Korea','mklang'),
		// 'KR' => __('Korea, Republic of','mklang'),
		'KR' => __('South Korea','mklang'),
		'KW' => __('Kuwait','mklang'),
		'KG' => __('Kyrgyzstan','mklang'),
		// 'LA' => __('Lao People\'s Democratic Republic','mklang'),
		'LA' => __('Laos','mklang'),
		'LV' => __('Latvia','mklang'),
		'LB' => __('Lebanon','mklang'),
		'LS' => __('Lesotho','mklang'),
		'LR' => __('Liberia','mklang'),
		'LY' => __('Libyan Arab Jamahiriya','mklang'),
		'LI' => __('Liechtenstein','mklang'),
		'LT' => __('Lithuania','mklang'),
		'LU' => __('Luxembourg','mklang'),
		'MO' => __('Macao','mklang'),
		// 'MK' => __('Macedonia, the Former Yugoslav Republic of','mklang'),
		// 'MK' => __('Republic of North Macedonia','mklang'),
		'MK' => __('North Macedonia','mklang'),
		'MG' => __('Madagascar','mklang'),
		'MW' => __('Malawi','mklang'),
		'MY' => __('Malaysia','mklang'),
		'MV' => __('Maldives','mklang'),
		'ML' => __('Mali','mklang'),
		'MT' => __('Malta','mklang'),
		'MH' => __('Marshall Islands','mklang'),
		'MQ' => __('Martinique','mklang'),
		'MR' => __('Mauritania','mklang'),
		'MU' => __('Mauritius','mklang'),
		'YT' => __('Mayotte','mklang'),
		'MX' => __('Mexico','mklang'),
		// 'FM' => __('Micronesia, Federated States of','mklang'),
		'FM' => __('Federated States of Micronesia','mklang'),
		// 'MD' => __('Moldova, Republic of','mklang'),
		'MD' => __('Moldova','mklang'),
		'MC' => __('Monaco','mklang'),
		'MN' => __('Mongolia','mklang'),
		'MS' => __('Montserrat','mklang'),
		'MA' => __('Morocco','mklang'),
		'MZ' => __('Mozambique','mklang'),
		'MM' => __('Myanmar','mklang'),
		'NA' => __('Namibia','mklang'),
		'NR' => __('Nauru','mklang'),
		'NP' => __('Nepal','mklang'),
		'NL' => __('Netherlands','mklang'),
		'AN' => __('Netherlands Antilles','mklang'),
		'NC' => __('New Caledonia','mklang'),
		'NZ' => __('New Zealand','mklang'),
		'NI' => __('Nicaragua','mklang'),
		'NE' => __('Niger','mklang'),
		'NG' => __('Nigeria','mklang'),
		'NU' => __('Niue','mklang'),
		'NF' => __('Norfolk Island','mklang'),
		'MP' => __('Northern Mariana Islands','mklang'),
		'NO' => __('Norway','mklang'),
		'OM' => __('Oman','mklang'),
		'PK' => __('Pakistan','mklang'),
		'PW' => __('Palau','mklang'),
		// 'PS' => __('Palestinian Territory, Occupied','mklang'),
		// 'PS' => __('Palestine, State of','mklang'),
		'PS' => __('Palestine','mklang'),
		'PA' => __('Panama','mklang'),
		'PG' => __('Papua New Guinea','mklang'),
		'PY' => __('Paraguay','mklang'),
		'PE' => __('Peru','mklang'),
		'PH' => __('Philippines','mklang'),
		'PN' => __('Pitcairn','mklang'),
		'PL' => __('Poland','mklang'),
		'PT' => __('Portugal','mklang'),
		'PR' => __('Puerto Rico','mklang'),
		'QA' => __('Qatar','mklang'),
		'RE' => __('Reunion','mklang'),
		'RO' => __('Romania','mklang'),
		'RU' => __('Russian Federation','mklang'),
		'RW' => __('Rwanda','mklang'),
		'SH' => __('Saint Helena','mklang'),
		'KN' => __('Saint Kitts and Nevis','mklang'),
		'LC' => __('Saint Lucia','mklang'),
		'PM' => __('Saint Pierre and Miquelon','mklang'),
		'VC' => __('Saint Vincent and the Grenadines','mklang'),
		'WS' => __('Samoa','mklang'),
		'SM' => __('San Marino','mklang'),
		'ST' => __('Sao Tome and Principe','mklang'),
		'SA' => __('Saudi Arabia','mklang'),
		'SN' => __('Senegal','mklang'),
		'CS' => __('Serbia and Montenegro','mklang'),
		'SC' => __('Seychelles','mklang'),
		'SL' => __('Sierra Leone','mklang'),
		'SG' => __('Singapore','mklang'),
		'SK' => __('Slovakia','mklang'),
		'SI' => __('Slovenia','mklang'),
		'SB' => __('Solomon Islands','mklang'),
		'SO' => __('Somalia','mklang'),
		'ZA' => __('South Africa','mklang'),
		'GS' => __('South Georgia and the South Sandwich Islands','mklang'),
		'ES' => __('Spain','mklang'),
		'LK' => __('Sri Lanka','mklang'),
		'SD' => __('Sudan','mklang'),
		'SR' => __('Suriname','mklang'),
		'SJ' => __('Svalbard and Jan Mayen','mklang'),
		'SZ' => __('Swaziland','mklang'),
		'SE' => __('Sweden','mklang'),
		'CH' => __('Switzerland','mklang'),
		// 'SY' => __('Syrian Arab Republic','mklang'),
		'SY' => __('Syria','mklang'),
		'TW' => __('Taiwan','mklang'),
		// 'TW' => __('Taiwan, Province of China','mklang'),
		'TJ' => __('Tajikistan','mklang'),
		'TZ' => __('Tanzania, United Republic of','mklang'),
		'TH' => __('Thailand','mklang'),
		'TL' => __('Timor-Leste','mklang'),
		'TG' => __('Togo','mklang'),
		'TK' => __('Tokelau','mklang'),
		'TO' => __('Tonga','mklang'),
		'TT' => __('Trinidad and Tobago','mklang'),
		'TN' => __('Tunisia','mklang'),
		'TR' => __('Turkey','mklang'),
		'TM' => __('Turkmenistan','mklang'),
		'TC' => __('Turks and Caicos Islands','mklang'),
		'TV' => __('Tuvalu','mklang'),
		'UG' => __('Uganda','mklang'),
		'UA' => __('Ukraine','mklang'),
		'US' => __('United States','mklang'),
		'UM' => __('United States Minor Outlying Islands','mklang'),
		'UY' => __('Uruguay','mklang'),
		'UZ' => __('Uzbekistan','mklang'),
		'VU' => __('Vanuatu','mklang'),
		'VE' => __('Venezuela','mklang'),
		'VN' => __('Viet Nam','mklang'),
		'VG' => __('Virgin Islands, British','mklang'),
		'VI' => __('Virgin Islands, US','mklang'),
		'WF' => __('Wallis and Futuna','mklang'),
		'EH' => __('Western Sahara','mklang'),
		'YE' => __('Yemen','mklang'),
		'ZM' => __('Zambia','mklang'),
		'ZW' => __('Zimbabwe','mklang'),
	];
	// If $key
	if( $key ) {
		// // If $key exists in array
		if( array_key_exists( $key, $countries ) ) {
			// Return name
			return $countries[$key];

		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $countries;
	}
}

/**
 * Get an array of italian regions.
 */
function mkt_get_italian_regions( $key = null ) : mixed {
    // Regions
	$regions = [
		'abruzzo'				=> __('Abruzzo','mklang'), 
		'basilicata'			=> __('Basilicata','mklang'), 
		'calabria'				=> __('Calabria','mklang'), 
		'campania'				=> __('Campania','mklang'), 
		'emilia-romagna'		=> __('Emilia-Romagna','mklang'), 
		'friuli-venezia-giulia'	=> __('Friuli Venezia Giulia','mklang'), 
		'lazio'					=> __('Lazio','mklang'), 
		'liguria'				=> __('Liguria','mklang'), 
		'lombardia'				=> __('Lombardy','mklang'), 
		'marche'				=> __('Marche','mklang'), 
		'molise'				=> __('Molise','mklang'), 
		'piemonte'				=> __('Piedmont','mklang'), 
		'puglia'				=> __('Apulia','mklang'), 
		'sardegna'				=> __('Sardinia','mklang'), 
		'sicilia'				=> __('Sicily','mklang'), 
		'toscana'				=> __('Tuscany','mklang'), 
		'umbria'				=> __('Umbria','mklang'), 
		'valle-d-aosta'			=> __('Aosta Valley','mklang'),  
		'veneto'				=> __('Veneto', 'mklang'), 
		'trentino-alto-adige'	=> __('Trentino-Alto Adige','mklang'), 
	];
	// If $key
	if( $key ) {	
		// // If $key exists in array
		if( array_key_exists( $key, $regions ) ) {
			// Return name
			return $regions[$key];
		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $regions;
	}
}

/**
 * Get an array of italian provinces.
 */
function mkt_get_italian_provinces( $key = null ) : array {
	// Provinces
	$provinces = [
		'AG'	=> __('Agrigento','mklang'),
		'AL'	=> __('Alessandria','mklang'),
		'AN'	=> __('Ancona','mklang'),
		'AO'	=> __('Aosta','mklang'),
		'AR'	=> __('Arezzo','mklang'),
		'AP'	=> __('Ascoli Piceno','mklang'),
		'AT'	=> __('Asti','mklang'),
		'AV'	=> __('Avellino','mklang'),
		'BA'	=> __('Bari','mklang'),
		'BT'	=> __('Barletta-Andria-Trani','mklang'),
		'BL'	=> __('Belluno','mklang'),
		'BN'	=> __('Benevento','mklang'),
		'BG'	=> __('Bergamo','mklang'),
		'BI'	=> __('Biella','mklang'),
		'BO'	=> __('Bologna','mklang'),
		'BZ'	=> __('Bolzano','mklang'),
		'BS'	=> __('Brescia','mklang'),
		'BR'	=> __('Brindisi','mklang'),
		'CA'	=> __('Cagliari','mklang'),
		'CL'	=> __('Caltanissetta','mklang'),
		'CB'	=> __('Campobasso','mklang'),
		'CE'	=> __('Caserta','mklang'),
		'CT'	=> __('Catania','mklang'),
		'CZ'	=> __('Catanzaro','mklang'),
		'CH'	=> __('Chieti','mklang'),
		'CO'	=> __('Como','mklang'),
		'CS'	=> __('Cosenza','mklang'),
		'CR'	=> __('Cremona','mklang'),
		'KR'	=> __('Crotone','mklang'),
		'CN'	=> __('Cuneo','mklang'),
		'EN'	=> __('Enna','mklang'),
		'FM'	=> __('Fermo','mklang'),
		'FE'	=> __('Ferrara','mklang'),
		'FI'	=> __('Florence','mklang'),
		'FG'	=> __('Foggia','mklang'),
		'FC'	=> __('Forlì-Cesena','mklang'),
		'FR'	=> __('Frosinone','mklang'),
		'GE'	=> __('Genova','mklang'),
		'GO'	=> __('Gorizia','mklang'),
		'GR'	=> __('Grosseto','mklang'),
		'IM'	=> __('Imperia','mklang'),
		'IS'	=> __('Isernia','mklang'),
		'SP'	=> __('La Spezia','mklang'),
		'AQ'	=> __('L\'Aquila','mklang'),
		'LT'	=> __('Latina','mklang'),
		'LE'	=> __('Lecce','mklang'),
		'LC'	=> __('Lecco','mklang'),
		'LI'	=> __('Livorno','mklang'),
		'LO'	=> __('Lodi','mklang'),
		'LU'	=> __('Lucca','mklang'),
		'MC'	=> __('Macerata','mklang'),
		'MN'	=> __('Mantua','mklang'),
		'MS'	=> __('Massa and Carrara','mklang'),
		'MT'	=> __('Matera','mklang'),
		'ME'	=> __('Messina','mklang'),
		'MI'	=> __('Milan','mklang'),
		'MO'	=> __('Modena','mklang'),
		'MB'	=> __('Monza and Brianza','mklang'),
		'NA'	=> __('Naples','mklang'),
		'NO'	=> __('Novara','mklang'),
		'NU'	=> __('Nuoro','mklang'),
		'OR'	=> __('Oristano','mklang'),
		'PD'	=> __('Padua','mklang'),
		'PA'	=> __('Palermo','mklang'),
		'PR'	=> __('Parma','mklang'),
		'PV'	=> __('Pavia','mklang'),
		'PG'	=> __('Perugia','mklang'),
		'PU'	=> __('Pesaro and Urbino','mklang'),
		'PE'	=> __('Pescara','mklang'),
		'PC'	=> __('Piacenza','mklang'),
		'PI'	=> __('Pisa','mklang'),
		'PT'	=> __('Pistoia','mklang'),
		'PN'	=> __('Pordenone','mklang'),
		'PZ'	=> __('Potenza','mklang'),
		'PO'	=> __('Prato','mklang'),
		'RG'	=> __('Ragusa','mklang'),
		'RA'	=> __('Ravenna','mklang'),
		'RC'	=> __('Reggio Calabria','mklang'),
		'RE'	=> __('Reggio Emilia','mklang'),
		'RI'	=> __('Rieti','mklang'),
		'RN'	=> __('Rimini','mklang'),
		'RM'	=> __('Rome','mklang'),
		'RO'	=> __('Rovigo','mklang'),
		'SA'	=> __('Salerno','mklang'),
		'SS'	=> __('Sassari','mklang'),
		'SV'	=> __('Savona','mklang'),
		'SI'	=> __('Siena','mklang'),
		'SR'	=> __('Syracuse','mklang'),
		'SO'	=> __('Sondrio','mklang'),
		'SU'	=> __('South Sardinia','mklang'),
		'TA'	=> __('Taranto','mklang'),
		'TE'	=> __('Teramo','mklang'),
		'TR'	=> __('Terni','mklang'),
		'TO'	=> __('Turin','mklang'),
		'TP'	=> __('Trapani','mklang'),
		'TN'	=> __('Trento','mklang'),
		'TV'	=> __('Treviso','mklang'),
		'TS'	=> __('Trieste','mklang'),
		'UD'	=> __('Udine','mklang'),
		'VA'	=> __('Varese','mklang'),
		'VE'	=> __('Venice','mklang'),
		'VB'	=> __('Verbano-Cusio-Ossola','mklang'),
		'VC'	=> __('Vercelli','mklang'),
		'VR'	=> __('Verona','mklang'),
		'VV'	=> __('Vibo Valentia','mklang'),
		'VI'	=> __('Vicenza','mklang'),
		'VT'	=> __('Viterbo','mklang'),
	];
	// If $key
	if( $key ) {	
		// // If $key exists in array
		if( array_key_exists( $key, $provinces ) ) {
			// Return name
			return $provinces[$key];
		}else{
			// Else return $key value
			return $key;
		}
	// If no $key
	}else{
		// Reurn array
		return $provinces;
	}
}

/*-------------------------------------------------------------------------------------*/
// Format data

/**
 * Money format 10,00 €.
 * @param integer $value
 * @param string $language
 * @param string $currency
 */ 
function euro_format( $value, $language = 'it_IT', $currency = 'EUR' ) : string {
    // If value is zero
	if( $value == 0 ) {
		// !!! This should be handled better
		$formatted_value = '0,00 ' . $currency;
	}else{
        // Format number class
		$fmt = new NumberFormatter( $language, NumberFormatter::CURRENCY );
        // FOrmat number
		$formatted_value = $fmt->formatCurrency( $value, $currency);
	}
	return $formatted_value;
}

/**
 * Return URL without http, https and www.
 */
function mkt_url_label( $url ) : string {
	// Find in string
	$find = [
		'https',
		'http',
		'://',
		'www.'
	];
	// Replace each with
	$replace = [
		'',
		'',
		'',
		''		
	];
	// Manipulate string
	$url = str_replace( $find, $replace, $url );
	// Remove last '/'
	$url = rtrim( $url, '/');
	return $url;
}

/**
 * Format phone number.
 * @param string $number
 * @param integer $local_prefix_size
 * @param integer $prefix_int
 */
function mkt_phone_format( $number, $local_prefix_size = 3, $prefix_int = '' ) : object {
	// URL ofr links
	$url = 'tel:' . $number;
	// Label
	// Remove international prefix
	$label = str_replace( $prefix_int, '', $number );
	// Format local prefix
	$label = substr( $label, 0, $local_prefix_size ) . ' ' . substr( $label, $local_prefix_size );
	// Retuen values
	$phone = [
		'url'	=>	$url,
		'label'	=>	$label,
	];
	return (object) $phone;
}

/**
 * Format file size according to size.
 * @param integer $file_size
 */
function mkt_format_file_size( $file_size ) : string {
    // Default value
	$formatted_value = null;
    if( $file_size < 1024 ) {
        // Bytes
        $formatted_value = $file_size . 'bytes';
    }else if( $file_size < 1024000 ) {
        // Kilobytes
		$formatted_value =  round( ( $file_size / 1024 ), 1 ) . 'kb';
    }else{
        // Megabytes
        $formatted_value =  round( ( $file_size / 1024000 ), 1 ) . 'Mb';
    }
	return $formatted_value;
}

/**
 * Convert a string to float and replace commas with dots.
 * @example 10,0 -> 10.0
 */
function string_to_float_comma_to_dot( $value ) : float {
    // Convert string to float and replace dots with commas
	$float = (float)str_replace(',', '.', $value);
	return $float;
}

/*-------------------------------------------------------------------------------------*/
// Minify code

/**
 * Minify HTML output code.
 * @param string $buffer
 */
function mkt_minifier( $buffer ) : string {
    // Search
    $search = [
        '/\>[^\S ]+/s',     // Strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // Strip whitespaces before tags, except space
        '/(\s)+/s',         // Shorten multiple whitespace sequences
        // '/<!--(.|\s)*?-->/' // Remove HTML comments
    ];
    // Replace
    $replace = [
        '>',
        '<',
        '\\1',
        ''
    ];
    // Replace
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

/*-------------------------------------------------------------------------------------*/
// Cookies

/**
 * Get/set a cookie in WordPress.
 * Returns the cookie value if only the $key is passed, true is successfully set a cookie, false otherwise. This function returns a cookie value when only the $key is passed, or sets a cookie when both the $key and $value are passed.
 * @example echo mkt_cookie('my_cookie');
 * @example unset($_COOKIE['my_cookie']);
 * @param string $key The cookie name/key
 * @param string $value Optional. The cookie value
 * @param string|int $expiration  Optional. Timestamp when the cookie expires
 */
function mkt_cookie( $key, $value = false, $expiration = false ) {
	// If value set cookie
	if( $value ) {
	   // Set a cookie
	   if( !is_admin() ) {
		   setcookie( 
			   $key, 
			   $value, 
               [
				   'expires'	=>	time()+$expiration,
				   'path'		=>	COOKIEPATH,
				   'domain'		=>	COOKIE_DOMAIN,
				   'secure'		=>	true,
				   'httponly'	=>	true,
				   'samesite'	=>	'None',
				]
			);   
	   }
   }
   // If no value get cookie
   else{
	   return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
   }
}

/**
 * Get a cookie in WordPress.
 * @param string $key
 */
function mkt_get_cookie( $key ) : string {
   return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
}

/**
 * Set a cookie in WordPress.
 * @param string $key
 * @param string $value
 * @param mixed $expiration
 */
function mkt_set_cookie( $key, $value, $expiration ) : void {
    // Set cookie
    mkt_cookie( $key, $value, $expiration );
}

/*-------------------------------------------------------------------------------------*/
// Users, roles and login

/**
 * Get user role.
 * @param integer $user_id
 */
function get_user_role( $user_id = 0 ) : string {
	// Conditionally get user by ID or current user
	$user = $user_id ? get_userdata($user_id) : wp_get_current_user();
	return current($user->roles);
}

/*-------------------------------------------------------------------------------------*/
// Maps

/**
 * Get Google Maps link.
 * @param array $address
 */
function get_gmap_link( $address, $text = null ) : string {
	// Default text
	$text = $text ? $text : __('Get directions','mklang');
	// Start output	
	$html = '<a target="_blank" rel="nofollow noopener nofollow" href="https://www.google.it/maps/place/';
	$html .= str_replace( ' ', '+', $address['address'] );
	$html .= '/">';
	$html .= $text;
	$html .= '</a>';
	return $html;
}

/*-------------------------------------------------------------------------------------*/
// Emails

/**
 * Get email signature.
 */
function mkt_get_email_signature( $logo_format = 'base64' ) : string {
    // Default value
	$signature = '';
	// Get logo
	$logo = get_field('logo_other_version','options');
    // Bail out and return site name if no logo
	if( !isset($logo['img']) || empty($logo['img']) ) {
		// Log error
		write_log('mkt_get_email_signature : No logos found');
		return get_bloginfo('name');
	}
	// Get home URL
	$home_url = get_home_url();
	// Formats
	if( $logo_format == 'base64' ) {
		// Base 64
		$logo_img = mkt_img_to_base64($logo['img']);
	}else{
		// Image
		$logo_img = wp_get_attachment_url( $logo['img'] );
	}
	// Start HTML
	$signature .= '<table class="cf7-signature" style="border: none; margin-top: 60px; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 18px; color: #646464;">';
		$signature .= '<tbody>';
			$signature .= '<tr style="border: none;">';
				// Left cell
				$signature .= '<td style="padding: 0; border: none; vertical-align: top; width: ' . ( $logo['width'] + 40 ) . 'px">';
					// Logo
					$signature .= '<a href="' . $home_url . '" target="_blank" rel="noopener noreferrer nofollow">';
						$signature .= '<img width="' . $logo['width'] . '" height="' . $logo['height'] . '" src="' . $logo_img. '" style="width:' . $logo['width'] . 'px; height: ' . $logo['height'] . 'px;" />';
					$signature .= '</a>';
				$signature .= '</td>';
				// Right cell
				$signature .= '<td style="padding: 0; border: none;">';
					// Company name
					$signature .= ( get_field('company_name','options') ) ? '<strong style="color: #000;">' . get_field('company_name','options') . '</strong><br>' : null;
					// Address
					$signature .= ( get_field('address','options') ) ? get_field('address','options') . '<br>' : null;
					// City
					$signature .= ( get_field('city','options') ) ? get_field('city','options') . '<br>' : null;
					// Phone
					$signature .= ( get_field('phone','options') ) ? '<a style="color: #000; text-decoration: none;" href="tel:' . get_field('phone','options') . '">T. ' . get_field('phone','options') . '</a><br>' : null;
					// Mobile
					$signature .= ( get_field('mobile_phone','options') ) ? '<a style="color: #000; text-decoration: none;" href="tel:' . get_field('mobile_phone','options') . '">M. ' . get_field('mobile_phone','options') . '</a><br>' : null;
					// Website
					$signature .= '<a href="' . $home_url . '" target="_blank" rel="noopener noreferrer nofollow" style="color: #000; text-decoration: none; font-weight: bold;">' . mkt_url_label($home_url) . '</a>';
				$signature .= '</td>';
			$signature .= '</tr>';
		$signature .= '</tbody>';
	$signature .= '</table>';
	// Discalimer
	if( get_field('email_disclaimer','options') ) {
		$signature .= '<p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #efefef; font-size: 12px; line-height: 18px;">' . get_field('email_disclaimer','options') . '</p>';
	}
	return $signature;
}

/**
 * Markup of first part of emails.
 */
function mkt_email_body_start() : string {
	// Starting div
	$body_start = '<div style="background-color: rgb(250,250,250); padding: 20px; font-size: 18px; color: #646464; margin-bottom: 5px;">';
	return $body_start;
}

/**
 * Markup of last part of emails.
 */
function mkt_email_body_end() : string {
	// Close div
	$body_end = '</div>';
	// Get email signature
	$body_end .= mkt_get_email_signature('img_url');
	return $body_end;
}

/**
 * Email body buttons.
 * @param string $button_link
 * @param string $button_text
 */
function mkt_email_body_button( $button_link, $button_text ) : string {
	// Button outp
	$button = '<a style="text-decoration: none; background-color: #2196F3; color: #ffffff; font-weight: 400; display: inline-block; padding: 20px 40px 16px 40px; font-size: 16px; margin: 0 10px 10px 0;" target="_blank" href="' . $button_link . '">' . $button_text . '</a>';
	return $button;
}

/*-------------------------------------------------------------------------------------*/
// Charts

/**
 * Generate a pie chart.
 * @link https://codeburst.io/how-to-pure-css-pie-charts-w-css-variables-38287aea161e
 * @param array $values
 * @param string $css_classes
 * @param array $colors
 * @param integer $size
 */
function mkt_pie_chart( $values, $css_classes = null, $colors = [], $size = 200 ) : string {
	// Default color palette
	$colors = $colors ? $colors : mkt_color_palette();
	// Index
	$index = 0;
	// Offset
	$offset = 0;
	// Start output
	$html = '<div class="stats_pie ' .  $css_classes . '" style="--size: ' . $size . ';">';
	// Loop values
	foreach( $values as $value ) {
		// Segment
		$html .= '<div class="pie__segment" style="';
		$html .= '--offset: ' . $offset . ';';
		$html .= '--value: ' . $value . ';';
		$html .= '--bg: ' . $colors[$index] . ';';
		if( $value > 50 ) {
			$html .= '--over50: 1;';
		}
		$html .= '"></div>';
		// Increment
		$index++;
		$offset += $value;
	}
	// End output
	$html .= '</div>';
	return $html;
}

/**
 * A set of default colors with a filter.
 * @link https://gist.github.com/Njengah/415fa17bd93d5520b263434a7ee3f314
 */
function mkt_color_palette() : array {
    // Colors
	$colors = [
		'var(--color-primary)',
		'var(--color-secondary)',
		'var(--color-accent)',
	];
	// Filter to add other custom colors
	$colors = apply_filters('mkt_color_palette',$colors);
	return $colors;
}

/*-------------------------------------------------------------------------------------*/
// Debug

/**
 * Write errors in debug.log.
 * @link https://wordpress.stackexchange.com/questions/260236/how-to-put-logs-in-wordpress
 * @param mixed $log
 */
if( !function_exists('write_log') ) {
    function write_log( $log ) : void {
		// Id debug is active
        if( true === WP_DEBUG ) {
			// Array and objects
			if( is_array($log) || is_object($log) ) {
				error_log(print_r($log,true));
			}
			// Null
			elseif( is_null($log) || !$log || empty($log) || $log == 0 ) {
				error_log('NULL');
			}
			// String, integers and floats
			else{
				error_log($log);
			}
		}
	}
}

/*-------------------------------------------------------------------------------------*/
// ACF Blocks

/** 
 * Array of values to be used in block fields.
 * @param string $key
 */
function mkt_block_values( $key ) : array {
	// Values
	$values = [
		// Display
		'display' => [
			'block'	=> 'Block',
			'flex'	=> 'Flex',
			'grid'	=> 'Grid',
		],
		// Justify content
		'justify_content' => [
			'justify-start'		=> 'Flex start',
			'justify-end'		=> 'Flex end',
			'justify-center'	=> 'Center',
			'justify-between'	=> 'Space between',
			'justify-around'	=> 'Space around',
			'justify-evenly'	=> 'Space evenly',	
		],
		// Align items
		'align_items' => [
			'items-start'		=> 'Start',
			'items-end'			=> 'End',
			'items-center'		=> 'Center',
			'items-baseline'	=> 'Baseline',
			'items-stretch'		=> 'Stretch',		
		],
		// Grid
		'grid' => [
			'grid'			=> 'S1 M1 L1',
			'grid-1-2'		=> 'S1 M2 L2',
			'grid-1-1-2'	=> 'S1 M1 L2',
			'grid-1-1-3'	=> 'S1 M1 L3',
			'grid-1-1-4'	=> 'S1 M1 L4',
			'grid-1-2-3'	=> 'S1 M2 L3',
			'grid-1-2-4'	=> 'S1 M2 L4',
			'grid-1-2-6'	=> 'S1 M2 L6',
			'grid-1-3'		=> 'S1 M3 L3',
			'grid-1-3-4'	=> 'S1 M3 L4',
			'grid-1-3-6'	=> 'S1 M3 L6',
			'grid-2'		=> 'S2 M2 L2',
			'grid-2-4'		=> 'S2 M4 L4',
			'grid-2-4-6'	=> 'S2 M4 L6',
			'grid-2-4-8'	=> 'S2 M4 L8',
		],
		// Gap
		'gap' => [
			'gap-0'				=> 'S0 M0 L0',
			'gap-2-4-4'			=> 'S2 M4 L4',
			'gap-2-4-8'			=> 'S2 M4 L8',
			'gap-4-8-8'			=> 'S4 M8 L8',
			'gap-4-8-16'		=> 'S4 M8 L16',
		],
		// Container
		'container' => [
			'w-full'		=> '100%',
			'container-sm'	=> 'S',
			'container-md'	=> 'M',
			'container-lg'	=> 'L',
		],
		// Padding
		'padding' => [
			'p-xs'	=> 'XS',
			'p-sm'	=> 'S',
			'p-md'	=> 'M',
			'p-lg'	=> 'L',
			'p-xl'	=> 'XL',
		],
		// Padding top
		'padding_t' => [
			'pt-xs'	=> 'XS',
			'pt-sm'	=> 'S',
			'pt-md'	=> 'M',
			'pt-lg'	=> 'L',
			'pt-xl'	=> 'XL',
		],
		// Padding bottom
		'padding_b' => [
			'pb-xs'	=> 'XS',
			'pb-sm'	=> 'S',
			'pb-md'	=> 'M',
			'pb-lg'	=> 'L',
			'pb-xl'	=> 'XL',
		],
		// Padding left
		'padding_l' => [
			'pl-xs'	=> 'XS',
			'pl-sm'	=> 'S',
			'pl-md'	=> 'M',
			'pl-lg'	=> 'L',
			'pl-xl'	=> 'XL',
		],
		// Padding right
		'padding_r' => [
			'pr-xs'	=> 'XS',
			'pr-sm'	=> 'S',
			'pr-md'	=> 'M',
			'pr-lg'	=> 'L',
			'pr-xl'	=> 'XL',
		],
		// Margin
		'margin' => [
			'm-xs'	=> 'XS',
			'm-sm'	=> 'S',
			'm-md'	=> 'M',
			'm-lg'	=> 'L',
			'm-xl'	=> 'XL',
		],
		// Margin top
		'margin_t' => [
			'mt-xs'	=> 'XS',
			'mt-sm'	=> 'S',
			'mt-md'	=> 'M',
			'mt-lg'	=> 'L',
			'mt-xl'	=> 'XL',
		],
		// Margin bottom
		'margin_b' => [
			'mb-xs'	=> 'XS',
			'mb-sm'	=> 'S',
			'mb-md'	=> 'M',
			'mb-lg'	=> 'L',
			'mb-xl'	=> 'XL',
		],
		// Margin left
		'margin_l' => [
			'ml-xs'	=> 'XS',
			'ml-sm'	=> 'S',
			'ml-md'	=> 'M',
			'ml-lg'	=> 'L',
			'ml-xl'	=> 'XL',
		],
		// Margin right
		'margin_r' => [
			'mr-xs'	=> 'XS',
			'mr-sm'	=> 'S',
			'mr-md'	=> 'M',
			'mr-lg'	=> 'L',
			'mr-xl'	=> 'XL',
		],
		// Background color
		'bg_color' => [
			'bg-default'		=> __('Transparent','mklang'),
			'bg-primary'		=> __('Primary color','mklang'),
			'bg-secondary'		=> __('Secondary color','mklang'),
			'bg-accent'			=> __('Accent color','mklang'),
			'bg-white'			=> __('White','mklang'),
			'bg-black'			=> __('Black','mklang'),
			'bg-gray-50'		=> __('Gray','mklang') . ' 50',
			'bg-gray-100'		=> __('Gray','mklang') . ' 100',
			'bg-gray-200'		=> __('Gray','mklang') . ' 200',
			'bg-gray-300'		=> __('Gray','mklang') . ' 300',
			'bg-gray-400'		=> __('Gray','mklang') . ' 400',
			'bg-gray-500'		=> __('Gray','mklang') . ' 500',
			'bg-gray-600'		=> __('Gray','mklang') . ' 600',
			'bg-gray-700'		=> __('Gray','mklang') . ' 700',
			'bg-gray-800'		=> __('Gray','mklang') . ' 800',
			'bg-gray-900'		=> __('Gray','mklang') . ' 900',
		],
		// Paragraph
		'paragraph' => [
			'text-left'		=> __('Left','mklang'),
			'text-right'	=> __('Right','mklang'),
			'text-center'	=> __('Center','mklang'),
		],
		// Text color
		'text_color' => [
			'islight'		=> __('Dark','mklang'),
			'isdark'		=> __('Light','mklang'),
		],
		// Button style
		'button_style' => [
			'primary'			=> __('Primary','mklang'),
			'secondary'			=> __('Secondary','mklang'),
			'secondary light'	=> __('Secondary light','mklang'),
			'hollow'			=> __('Hollow','mklang'),
			'hollow light'		=> __('Hollow light','mklang'),
		],
		// Button size
		'button_size' => [
			'w-auto'			=> __('Auto','mklang'),
			'w-full'			=> __('Full width','mklang'),
			'small'				=> __('Small','mklang'),
			'small w-full'		=> __('Small full width','mklang'),
		],
		// Semantic tag
		'semantic_tag' => [
			'div'		=> 'div (default)',
			'main'		=> 'main',
			'aside'		=> 'aside',
			'article'	=> 'article',
			'section'	=> 'section',
			'header'	=> 'header',
			'footer'	=> 'footer',
			'nav'		=> 'nav',
			'address'	=> 'address',
			'ul'		=> 'ul',
			'ol'		=> 'ol',
			'li'		=> 'li',
		],
		// Column span
		'col_span' => [
			'col-span-1-1-2'	=>	'S1 M1 L2',
			'col-span-1-1-3'	=>	'S1 M1 L3',
			'col-span-1-2-2'	=>	'S1 M2 L2',
			'col-span-1-2-3'	=>	'S1 M2 L3',
			'col-span-1-2-4'	=>	'S1 M2 L4',
			'col-span-1-3-3'	=>	'S1 M3 L3',
			'col-span-1-3-6'	=>	'S1 M3 L6',
		],
		// Background blending mode
		'bg_blend_mode' => [
			'bg-blend-normal'		=>	'Normal',
			'bg-blend-multiply'		=>	'Multiply',
			'bg-blend-screen'		=>	'Screen',
			'bg-blend-overlay'		=>	'Overlay',
			'bg-blend-darken'		=>	'Darken',
			'bg-blend-lighten'		=>	'Lighten',
			'bg-blend-color-dodge'	=>	'Color dodge',
			'bg-blend-color-burn'	=>	'Color burn',
			'bg-blend-hard-light'	=>	'Hard light',
			'bg-blend-soft-light'	=>	'Soft light',
			'bg-blend-difference'	=>	'Difference',
			'bg-blend-exclusion'	=>	'Exclusion',
			'bg-blend-hue'			=>	'Hue',
			'bg-blend-saturation'	=>	'Saturation',
			'bg-blend-color'		=>	'Color',
			'bg-blend-luminosity'	=>	'Luminosity',
		],
		// Blending mode
		'mix_blend_mode' => [
			'mix-blend-normal'		=>	'Normal',
			'mix-blend-multiply'	=>	'Multiply',
			'mix-blend-screen'		=>	'Screen',
			'mix-blend-overlay'		=>	'Overlay',
			'mix-blend-darken'		=>	'Darken',
			'mix-blend-lighten'		=>	'Lighten',
			'mix-blend-color-dodge'	=>	'Color dodge',
			'mix-blend-color-burn'	=>	'Color burn',
			'mix-blend-hard-light'	=>	'Hard light',
			'mix-blend-soft-light'	=>	'Soft light',
			'mix-blend-difference'	=>	'Difference',
			'mix-blend-exclusion'	=>	'Exclusion',
			'mix-blend-hue'			=>	'Hue',
			'mix-blend-saturation'	=>	'Saturation',
			'mix-blend-color'		=>	'Color',
			'mix-blend-luminosity'	=>	'Luminosity',
		],
		// Height
		'height' => [
			'h-full'		=>	'100%',
			'h-screen'		=>	'100vh',
			'h-screen-menu'	=>	'100vh - nav',
			'h-1/4'			=>	'1/4',
			'h-2/4'			=>	'1/2',
			'h-3/4'			=>	'3/4',
			'h-1/5'			=>	'1/5',
			'h-2/5'			=>	'2/5',
			'h-3/5'			=>	'3/5',
			'h-4/5'			=>	'4/5',
			'h-1/6'			=>	'1/6',
			'h-2/6'			=>	'1/3',
			'h-4/6'			=>	'2/3',
			'h-5/6'			=>	'5/6',
		],
		// Min height
		'min_height' => [
			'min-h-full'		=>	'100%',
			'min-h-screen'		=>	'100vh',
			'min-h-screen-menu'	=>	'100vh - nav',
			'min-h-75vh'		=>	'75vh',
			'min-h-50vh'		=>	'50vh',
			'min-h-33vh'		=>	'33vh',
			'min-h-25vh'		=>	'25vh',
			'min-h-100vw'		=>	'100vw',
			'min-h-75vw'		=>	'75vw',
			'min-h-50vw'		=>	'50vv',
			'min-h-33vw'		=>	'33vw',
			'min-h-25vw'		=>	'25vw',
			'min-h-0'			=>	'0',
		],
		// Flex direction
		'flex_direction' => [
			'flex-row'			=>	'row',
			'flex-row-reverse'	=>	'row-reverse',
			'flex-col'			=>	'column',
			'flex-col-reverse'	=>	'column-reverse',
		],
		// Post types
		'post_types' => [
			'post'	=>	__('Post','mklang'),
			'page'	=>	__('Page','mklang'),
		],
	];
	// Allow a filter
	$values = apply_filters('mkt_block_values',$values);
	// Default value
	$data = null;
	// If all data is requested
	if( $key == 'all' ) {
		$data = $values;
	}
	// If only one group
	else{
		$data = $values[ $key ];
	}
	return $data;
}

/**
 * Icon link. A link with an icon
 * @param array $link
 * @param string $class
 * @param string $icon
 */
function mkt_icon_link( $link, $class = null, $icon = null ) : string {
	// Default value
	$html = null;
	// If link is set
	if( $link ) {
		// Default icon
		if( !$icon ) {
			$icon = get_svg_icon('icon-link','svg-icon fill-current h-4','core');
		}
		// Start HTML
		$html = '<a href="' . esc_url($link['url']) . '" ';
		$html .= array_key_exists('target',$link) ? 'target="' . esc_attr($link['target']) . '" ' : null;
		$html .= ' class="icon-link ' . esc_attr($class) . '">';
		$html .= $icon;
		$html .= esc_html($link['title']);
		$html .= '</a>';
	}
	return $html;
}