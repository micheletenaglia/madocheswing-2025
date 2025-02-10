<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Register theme shortcodes
new mktShortcodes();

// Register theme shortcodes
new mktPlugins();

/**
 * Register theme shortcodes.
 *
 */
class mktShortcodes{

    /**
     * Shortcodes.
     * 
     */
    public function __construct() {

		// WP
		add_shortcode('login_form',[$this,'login_form']);
		add_shortcode('home_url',[$this,'home_url']);
		add_shortcode('site_name',[$this,'site_name']);
		add_shortcode('post_url',[$this,'post_permalink']);
		add_shortcode('term_url',[$this,'term_permalink']);
		
		// Comapny data
		add_shortcode('company_name',[$this,'company_name']);
		add_shortcode('company_legal_representative',[$this,'legal_representative']);
		add_shortcode('company_address',[$this,'address']);
		add_shortcode('company_postcode',[$this,'postcode']);
		add_shortcode('company_city',[$this,'city']);
		add_shortcode('company_region',[$this,'region']);
		add_shortcode('company_country',[$this,'country']);
		add_shortcode('company_email',[$this,'email']);
		add_shortcode('company_pec_email',[$this,'pec_email']);
		add_shortcode('company_phone',[$this,'phone']);
		add_shortcode('company_mobile_phone',[$this,'mobile_phone']);
		add_shortcode('company_toll_free_phone',[$this,'toll_free_phone']);
		add_shortcode('company_vat_number',[$this,'vat']);
		add_shortcode('company_cf_number',[$this,'cf']);
		add_shortcode('company_share_capital',[$this,'share_capital']);
		add_shortcode('company_rea_number',[$this,'rea']);

		// Logo
		add_shortcode('get_logo',[$this,'logo']);

		// Social
		add_shortcode('get_social_link',[$this,'social']);

		// Icon
		add_shortcode('icon',[$this,'icon']);

	}

	/**
	 * Login form shortcode.
	 */
	public function login_form() : string {
		$args = [
			'echo'				=> true,
			'redirect'			=> get_the_permalink(get_the_ID()),
			'remember'			=> true,
			'value_remember'	=> true,
		];
		return wp_login_form($args);
	}

	/**
	 * Home URL shortcode.
	 */
	public function home_url() : string {
		return esc_url(home_url());
	}

	/**
	 * Sitename shortcode.
	 */
	public function site_name() : string {
		return esc_html(get_bloginfo('name'));
	}

	/**
	 * Post permalink shortcode.
	 * @param array $atts
	 */
	public function post_permalink( $atts ) : string {
		// Check if $id exists.
		$id = intval( $atts['id'] );
		if($id <= 0) {
			return '';
		}
		// Check id $id has a URL.
		$post_url = get_the_permalink($id);
		if('' != $post_url) {
			return esc_url($post_url);
		}
	}

	/**
	 * Term permalink shortcode.
	 * @param array $atts
	 */
	public function term_permalink( $atts ) : string {
		// Default value
		$term_url = null;
		// Extract vars
		extract(
			shortcode_atts(
				[
					'name'	=> '',
					'tax'	=> 'category',
				], 
			$atts
			)
		);
		// Get term object
		$term = get_term_by('name',$name,$tax); 
		// If term
		if( $term ) {
			$term_url = get_term_link($term->term_id);
		}
		return esc_url($term_url);
	}

	/*-------------------------------------------------------------------------------------*/
	// Custom options

	/**
	 * Company name shortcode.
	 */
	public function company_name() : string {
		return esc_html(get_field('company_name','options'));
	}

	/**
	 * Legal representative shortcode.
	 */
	public function legal_representative() : string {
		return esc_html(get_field('legal_representative','options'));
	}

	/**
	 * Company address shortcode.
	 */
	public function address() : string {
		return esc_html(get_field('address','options'));
	}

	/**
	 * Company postcode shortcode.
	 */
	public function postcode() : string {
		return esc_html(get_field('postcode','options'));
	}

	/**
	 * Company address shortcode.
	 */
	public function city() : string {
		return esc_html(get_field('city','options'));
	}

	/**
	 * Company region shortcode.
	 */
	public function region() : string {
		return esc_html(get_field('region','options'));
	}

	/**
	 * Company country shortcode.
	 */
	public function country() : string {
		return esc_html(get_field('country','options'));
	}

	/**
	 * Company email shortcode.
	 */
	public function email() : string {
		return esc_html(get_field('email','options'));
	}

	/**
	 * Company PEC email shortcode.
	 */
	public function pec_email() : string {
		return esc_html(get_field('pec_email','options'));
	}

	/**
	 * Company phone shortcode.
	 */
	public function phone() : string {
		return esc_html(get_field('phone','options'));
	}

	/**
	 * Company mobile phone shortcode.
	 */
	public function mobile_phone() : string {
		return esc_html(get_field('mobile_phone','options'));
	}

	/**
	 * Company toll free phone shortcode.
	 */
	public function toll_free_phone() : string {
		return esc_html(get_field('toll_free_phone','options'));
	}

	/**
	 * Company VAT number shortcode.
	 */
	public function vat() : string {
		return esc_html(get_field('vat_number','options'));
	}

	/**
	 * Company fiscal code shortcode.
	 */
	public function cf() : string {
		return esc_html(get_field('cf_number','options'));
	}

	/**
	 * Company share capital shortcode.
	 */
	public function share_capital() : string {
		return esc_html(get_field('share_capital','options'));
	}

	/**
	 * Company REA number shortcode.
	 */
	public function rea() : string {
		return esc_html(get_field('rea_number','options'));
	}

	/**
	 * Logo.
	 * @param array $atts
	 */
	function logo( $atts = [] ) : string {
		// Extract vars
		extract(
			shortcode_atts(
				[
					'class'			=> 'h-8 w-auto',
					'version'		=> 'light',
				], 
			$atts
			)
		);
		// Get logo
		$logo = mkt_get_logo($class,$version);
		return $logo;
	}

	/**
	 * Social links from theme options.
	 * @param array $atts
	 */
	public function social( $atts = [] ) : ?string {
		// Extract vars
		extract(
			shortcode_atts(
				[
					'name'			=> 'facebook',
					'icon'			=> 'show',
					'icon_classes'	=> 'svg-icon fill-current h-4',
					'a_classes'		=> '',
					'path'			=> 'core'
				], 
			$atts
			)
		);
		// Deafult values
		$html = null;
		$get_icon = null;
		$label = null;
		// Get URL
		$url = get_field($name,'options');
		// If URL
		if( $url ) {
			// Handle icon
			if( $icon == 'show' || $icon == 'both' ) {
				// Add custom classes
				if( $icon_classes ) {
					// Get icon
					$get_icon = get_svg_icon( 
						str_replace('_','-',esc_attr($name)), 
						esc_attr($icon_classes),
						esc_attr($path) 
					);
				}else{
					// Get icon with default classes
					$get_icon = get_svg_icon( 
						str_replace('_','-',esc_attr($name)),
						'svg-icon fill-current h-4',
						esc_attr($path)
					);
				}
			}
			// Handle label
			if( $icon != 'show' || $icon == 'both' ) {
				$label = ucfirst( esc_attr($name) );
				if( $label == 'Mailchimp' ) {
					$label = 'Newsletter';
				}
			}
			// Handle URLs
			if( $name == 'whatsapp' ) {
				// Whatsapp
				$url = 'https://wa.me/' . str_replace('+','',$url);
			}elseif( $name == 'telegram' ) {
				// Telegram
				$url = 'https://t.me/' . $url;
			}if( $name == 'signal' ) {
				// Signal
				$url = 'https://signal.me/#p/' . $url;
			}
			// HTML code
			$html = '<a aria-label="' . ucfirst(esc_attr($name)) . '" class="' . esc_attr('cta-social ' . esc_attr($name) . ' ' . esc_attr($a_classes)) . '" href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer nofollow">' . $get_icon . ' ' . esc_html($label) . '</a>';
		}
		return $html;
	}

	/**
	 * Get svg shortcode.
	 * @param array $atts
	 */
	public function icon( $atts ) : string {
		// Extract vars
		extract(
			shortcode_atts(
				[
					'name'			=> '',
					'icon_classes'	=> 'svg-icon fill-current h-4',
					'path'			=> 'core',
				], 
				$atts
			) 
		);
		return get_svg_icon($name,$icon_classes,$path);
	}

}

/**
 * Specific functions for plugins.
 * 
 * - Yoast SEO
 * - Contact Form 7
 * - Simple history
 * - WPML
 * - DK PDF
 */
class mktPlugins{

    /**
     * Shortcodes.
     * 
     */
    public function __construct() {

		// Yoast
		if( mkt_plugin_active('yoast') ) {
			// Yoast SEO override OG:Image Size
			add_filter('wpseo_image_sizes',[$this,'yoast_override_images_size']);
			// Move Yoast postbox to bottom
			add_filter('wpseo_metabox_prio',[$this,'yoast_to_bottom']);
			// Filters the canonical URL if is paged.
			add_filter('wpseo_canonical',[$this,'yoast_paged_filter_canonical']);
			// Exclude post types from XML sitemaps
			// add_filter('wpseo_sitemap_exclude_post_type',[$this,'exclude_sitemap_post_types'],10,2);
			// Remove Yoast SEO Prev/Next URL from all pages
			// add_filter('wpseo_next_rel_link','__return_false');
			// add_filter('wpseo_prev_rel_link','__return_false');
		}

		// Contact Form 7 (CF7)
		if( mkt_plugin_active('cf7') ) {
			// Remove autop from CF7 forms
			add_filter('wpcf7_autop_or_not','__return_false');
			// Enable shortcodes inside CF7 forms
			add_filter('wpcf7_form_elements','do_shortcode');
			// Optimize CF7 assets
			add_filter('wpcf7_load_js','__return_false');
			add_filter('wpcf7_load_css','__return_false');
			// Optimization
			add_action('wp_enqueue_scripts',[$this,'cf7_optimization']);
			// add_action('wp_print_scripts',[$this,'cf7_optimization']); !!! Verify this
			add_action('wp_enqueue_scripts',[$this,'cf7_recaptcha_no_refill'],15,0);
			// Email signature shortcode
			add_filter('wpcf7_special_mail_tags',[$this,'cf7_email_signature'],10,3);
		}	
		
		// Simple History
		// Change capability required to view main simple history page
		add_filter('simple_history/view_history_capability',[$this,'simple_history_capability']);

		// DKPDF
		// Set custom options for DKPDF plugin
		add_action('acf/init',[$this,'dkpdf_setup']);

		// WPML
		//  Do not load WPML CSS on frontend.
		add_action('wp_enqueue_scripts',[$this,'wpml_optimization'],PHP_INT_MAX);


	}

	/*-------------------------------------------------------------------------------------*/
	// Yoast

	/**
	 * Yoast SEO override OG:Image Size.
	 */
	public function yoast_override_images_size() : array {
		$sizes = [
			'social',
			'full-hd-thumb',
			'large'
		];
		return $sizes;
	}

	/**
	 * Move Yoast postbox to bottom.
	 */
	public function yoast_to_bottom() : string {
		return 'low';
	}

	/**
	 * Filters the canonical URL if is paged.
	 * @param string $canonical
	 */
	public function yoast_paged_filter_canonical( $canonical ) : string {
		// Bail out early
		if( !is_archive() ) {
			return $canonical;
		}
		// If this page 2, 3, etc. of an archive
		if( is_paged() ) {
			// Get object
			$object = get_queried_object();
			if( isset( $object->term_id ) ) {
				// If this is a term archive
				$canonical = get_term_link($object->term_id);
			}elseif( isset( $object->has_archive ) ) {
				// If this is a post type archive
				$canonical = get_post_type_archive_link( $object->name );
			}
		}
		return $canonical;
	}

	/**
	 * Exclude post types from XML sitemaps.
	 * @link https://developer.yoast.com/features/xml-sitemaps/api/#exclude-a-post-type
	 * @link https://wordpress.org/support/topic/exclude-multiple-post-types-from-sitemap/
	 * @param boolean $excluded  Whether the post type is excluded by default
	 * @param string  $post_type The post type to exclude
	 */
	/*
	public function exclude_sitemap_post_types( $excluded, $post_type ) : bool {
		$excluded_post_types = ['example'];
		if (in_array($post_type, $excluded_post_types) ) {
			 return true;
		}else{
			return false;
		}
	}
	*/

	/*-------------------------------------------------------------------------------------*/
	// Contact Form 7 (CF7)

	/**
	 * Load CF7 assets only when needed.
	 */
	public function cf7_optimization() : void {
		// Dequeue Google reCAPTCHA
		// Please note that this is necessary for best performance, 
		// although it is not recommended (see link)
		// https://contactform7.com/faq-about-recaptcha-v3/#stop-script-loading
		wp_dequeue_script('wpcf7-recaptcha');
		wp_dequeue_script('google-recaptcha');
		if( is_singular() ) {
			global $post;
			// Get optimization options (it is a grouped field)
			$cf7_optimization = get_field('optimization_contact_form_7','options');
			// Continue only if field has a value
			if( $cf7_optimization ) {
				// Get data
				$post_ids = [];
				$post_types = [];
				$post_templates = [];
				if( isset($cf7_optimization['optimization_contact_form_7_post_ids']) && !empty($cf7_optimization['optimization_contact_form_7_post_ids']) ) {
					$post_ids = $cf7_optimization['optimization_contact_form_7_post_ids'];
				}
				if( isset($cf7_optimization['optimization_contact_form_7_post_types']) && !empty($cf7_optimization['optimization_contact_form_7_post_types']) ) {
					$post_types = $cf7_optimization['optimization_contact_form_7_post_types'];
				}
				if( isset($cf7_optimization['optimization_contact_form_7_templates']) && !empty($cf7_optimization['optimization_contact_form_7_templates']) ) {
					$post_templates = $cf7_optimization['optimization_contact_form_7_templates'];   
				}
				// Include assets in selected posts 
				if( 
					in_array( $post->ID, $post_ids ) ||
					in_array( $post->post_type, $post_types ) ||
					is_page_template( $post_templates ) ||
					( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'contact-form-7') )
				) {
					wpcf7_enqueue_scripts();
					wp_enqueue_script( 'wpcf7-recaptcha' );
					wp_enqueue_script( 'google-recaptcha' );
					// Styles are included in frontend.css
					// wpcf7_enqueue_styles();
				}
			}else{
				// If the field is empty enqueue CF7 scipts on all singular templates
				wpcf7_enqueue_scripts();
			}
		}
	}

	/**
	 * Shortcode to generate Contact Form 7 email signature html output.
	 * @param string $output
	 * @param string $name
	 * @param string $html
	 */
	public function cf7_email_signature( $output, $name, $html ) : string {
		if( 'signature' == $name ) {
			$output = mkt_get_email_signature();
		}
		return $output;
	}

	/**
	 * Disable refill function in WPCF7 if Recaptcha is in use.
	 * @link https://gist.github.com/sitoexpress/428d4edf96b301ce5afad0512ae1bdc5
	 */
	public function cf7_recaptcha_no_refill() : void {
		$service = WPCF7_RECAPTCHA::get_instance();
		if( !$service->is_active() ) {
			return;
		}
		wp_add_inline_script('contact-form-7','wpcf7.cached = 0;','before');
	}

	/*-------------------------------------------------------------------------------------*/
	// Simple History

	/**
	 * Change capability required to view main simple history page.
	 */
	public function simple_history_capability( $capability ) : string {
		$capability = 'manage_options';
		return $capability;
	}

	/*-------------------------------------------------------------------------------------*/
	// DKPDF

	/**
	 * Set custom options for DKPDF plugin.
	 * @param string $font_dir
	 */
	public function dkpdf_setup() : void {
		/*if( !function_exists('is_plugin_active') ) {
			include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}	
		if( is_plugin_active( 'dk-pdf/dk-pdf.php' ) ) {*/
		if( mkt_plugin_active('dkpdf') ) {
			add_filter('dkpdf_mpdf_font_dir',[$this,'dkpdf_custom_font_dir']);
			add_filter('dkpdf_mpdf_font_data',[$this,'dkpdf_custom_font_data']);
			add_filter('dkpdf_pdf_filename',[$this,'dkpdf_custom_filename']);
		}
	}

	/**
	 * Set custom PDF font.
	 * @param array $font_dir
	 */
	public function mkt_dkpdf_custom_font_dir( $font_dir ) : array {
		$wp_content_dir = trailingslashit(WP_CONTENT_DIR) . 'uploads';
		// $fonts_path = get_template_directory() . '/core/assets/fonts';
		array_push($font_dir,$wp_content_dir);
		return $font_dir;
	}

	/**
	 * Set custom PDF font data.
	 * @param array $font_data
	 */
	public function mkt_dkpdf_custom_font_data( $font_data ) : array {
		$dk_pdf = get_field('dk_pdf','options');
		$font_data['theme-font'] = [
			'R'	=>	$dk_pdf['pdf_font_one']['filename'],
			'I'	=>	$dk_pdf['pdf_font_two']['filename'],
		];
		return $font_data;
	}

	/**
	 * Set custom PDF filename.
	 * @param string $filename
	 */
	public function mkt_dkpdf_custom_filename( $filename ) : string {
		$dk_pdf = get_field('dk_pdf','options');
		$filename = sanitize_title($dk_pdf['pdf_filename'] . '-' . get_the_title());
		return $filename;
	}

	/*-------------------------------------------------------------------------------------*/
	// WPML

	/**
	 * Do not load WPML CSS on frontend.
	 */
	public function wpml_optimization() : void {
		if( mkt_plugin_active('wpml') ) {
			wp_dequeue_style('wpml-blocks');
		}
	}

	/**
	 * Do not load WPML CSS on frontend. This is the official way but doesn't work.
	 * @link https://wpml.org/forums/topic/dequeue-styles/
	 */
	/*
	if( mkt_plugin_active('wpml') ) : void {
		define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS',true);
	}
	*/

}

/*-------------------------------------------------------------------------------------*/
// Yoast

/**
 * Display Yoast SEO breadcrumbs.
 */
function mkt_breadcrumbs() : void {
	if( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	}
}

/**
 * Get true category set by Yoast.
 * @param integer $post_id
 */
function mkt_yoast_true_category( $post_id ) : object {
	// Get true category asked by Yoast
	// if more than 1 term is set to the post
	$true_category = get_post_meta( $post_id, '_yoast_wpseo_primary_category',1 );
	// Conditionally get category
	if( $true_category ) {
		// Get category by true category field
		$category = get_term($true_category);
	}else{
		// Get normal category
		$category = get_the_terms( $post_id, 'category' );
		if( $category ) {
			$category = $category[0];
		}
	}
	return $category;
}

/*-------------------------------------------------------------------------------------*/
// WPML

/**
 * Get the languages used on this website.
 * It would be better using the native WPML function apply_filters('wpml_active_languages',NULL,'skip_missing=0'); but it doesn't always work when used in hooks.
 */
if( !function_exists('mkt_get_languages') ) {
    function mkt_get_languages( $output = 'full' ) : mixed {
		// Default languages
        $languages = [
            'it'	=>	'Italiano',
            'en'	=>	'English',
            'de'	=>	'Deutsch',
            'fr'	=>	'Français',
        ];
		// Allow a filter
        $languages = apply_filters('mkt_get_languages',$languages);
		// Conditionally return array or string
        if( $output == 'keys' ) {
            $languages = array_keys($languages);
        }
        return $languages;
    }
}

/**
 * WPML Custom language switcher.
 */
function mkt_wpml_switcher() : void {
    // Bail out early
    if( !mkt_plugin_active('wpml') ) {
        return;
    }
    // Default value of post ID
    $post_id = null;
    // If is singular
    if( is_singular() ) {
        global $post;
        $post_id = $post->ID;
    }
    // Get site URL
    $siteurl = get_option('siteurl');
    // Get home URL in current language
    $home_url = apply_filters( 'wpml_home_url', get_option( 'home' ) );
    // Get languages
    $languages = mkt_get_languages();
    // Get current language
    $current_lang = apply_filters( 'wpml_current_language', null );
    // Get default language
    $default_lang = apply_filters('wpml_default_language', NULL );	
    ?>
    <div class="mkcf-wpml-switcher-wrap">
        <span class="js-wpml-switcher"><?php echo esc_html($current_lang); ?></span>
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
<?php
}

/**
 * Get custom WPML langiage switcher. 
 * Usage: new mktWpmlSwitcher(); 
 * !!! This has never been tested.
 */
class mktWpmlSwitcher{

    /**
     * WPML Switcher.
     * 
     */
    public function __construct() {
		// Bail out early
		if( !mkt_plugin_active('wpml') ) {
			return;
		}
		// Get current language
		$current_lang = apply_filters('wpml_current_language',NULL);
		?>
		<div class="mkcf-wpml-switcher-wrap">
			<span class="js-wpml-switcher"><?php echo esc_html($current_lang); ?></span>
			<div class="mkcf-wpml-switcher">
				<?php $this->switcher(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Check if we can use the default WPML switcher.
	 */
	private function default() : bool {
		// Default value of post ID
		$post_id = null;
		// If is singular
		if( is_singular() ) {
			global $post;
			$post_id = $post->ID;
		}
		// If this is a translatable post type
		// or is 404 page
		// or is search result page
		if( 
			apply_filters('wpml_is_translated_post_type',NULL,get_post_type($post_id))
			|| is_404()
			|| is_search()
		) {
			return true;	
		}
		return false;
	}

	/**
	 * Get language URL and attrs.
	 * @param string $code
	 * @param integer $index
	 */
	private function lang( $code, $index ) : object {
		// Get site URL
		$siteurl = get_option('siteurl');
		// Get home URL in current language
		$home_url = apply_filters('wpml_home_url',get_option('home'));
		// Get current language
		$current_lang = apply_filters('wpml_current_language',NULL);
		// Get default language
		$default_lang = apply_filters('wpml_default_language',NULL);	
		// URL
		$url = str_replace( 
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
		// Check if is current language
		$current = $code == $current_lang ? 'wpml-ls-current-language' : null;
		// Add first item class
		$first = $index == 1 ? 'wpml-ls-first-item' : null;
		// CSS
		$css = 'wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-legacy-list-horizontal ';
		$css .= 'wpml-ls-item-' . esc_attr($code);
		$css .= esc_attr($current);
		$css .= esc_attr($first);
		// Return value
		$data = [
			'url'		=>	$url,
			'css'		=>	$css,
		];
		return (object)$data;
	}

	/**
	 * Print default or custom language switcher.
	 */
	public function switcher() : void {
		// If this is a default situation
		if( $this->default() ) {
			// Default WPML language switcher
			do_action('wpml_add_language_selector');
			// Stop
			return;
		}
		// Get languages
		$languages = mkt_get_languages();
		// Index
		$index = 0;
		?>
		<div class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-list-horizontal">
			<ul>
				<?php foreach( $languages as $code => $label ) : 
					// Increment
					$index++;
					// Get language
					$lang = $this->lang($code,$index);
					?>
					<li class="<?php echo esc_attr($lang->css); ?>">
						<a href="<?php echo esc_url($lang->url); ?>" class="wpml-ls-link"><span class="wpml-ls-native" lang="<?php echo esc_attr($code); ?>"><?php echo esc_html($label); ?></span></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}

}