<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Repository of ready to use functions.
 *
 */

// Uncomment, copy and past into functions.php if you want to disable WP Rest Api
// new mktRemoveAPI();

/**
 * Completely disable WP rest API.
 * Uncomment, copy and past into functions.php 
 * if you want to compeltely disable WP Rest Api.
 * 
 */
class mktRemoveAPI{
	
	/**
     * Actions and filters.
     * 
     */
    public function __construct() {
		// !!! Test what these functions make and if both hooks are necessary
		add_action('after_setup_theme',[$this,'remove']);
		add_action('after_setup_theme',[$this,'disable']);

	}

	/**
	 * Remove JSON API links in HTML head.
	*/
	public function remove() : void {
		// Remove the REST API lines from the HTML Header
		remove_action('wp_head','rest_output_link_wp_head',10 );
		remove_action('wp_head','wp_oembed_add_discovery_links',10 );
		// Remove the REST API endpoint.
		remove_action('rest_api_init','wp_oembed_register_route');
		// Turn off oEmbed auto discovery.
		add_filter('embed_oembed_discover','__return_false');
		// Don't filter oEmbed results.
		remove_filter('oembed_dataparse','wp_filter_oembed_result',10 );
		// Remove oEmbed discovery links.
		remove_action('wp_head','wp_oembed_add_discovery_links');
		// Remove oEmbed-specific JavaScript from the front-end and back-end.
		remove_action('wp_head','wp_oembed_add_host_js');
		// Remove all embeds rewrite rules.
		add_filter('rewrite_rules_array','disable_embeds_rewrites');
	}

	/**
	 * This snippet completely disables the REST API and shows {"code":"rest_disabled","message":"The REST API is disabled on this site."} when visiting http://example.com/wp-json/
	*/
	public function disable() : void {
		// Filters for WP-API version 1.x
		add_filter('json_enabled', '__return_false');
		add_filter('json_jsonp_enabled', '__return_false');
		// Filters for WP-API version 2.x
		add_filter('rest_enabled', '__return_false');
		add_filter('rest_jsonp_enabled', '__return_false');
	}

}

/**
 * Array manipulation functions.
 *
 */
class mktFnArray{

	/**
	 * Check if all values in array are null.
	 * @param array $array
	 * @param string $type
	 */
	function check_array_all_null( $array ) : bool {
		// Default value
		$check = 0;
		// Simple array
		if( array_is_list($array) ) {
			foreach( $array as $item ) {
				if( $item ) {
					$check++;
				}
			}
		}
		// Associative array
		else {
			foreach( $array as $index => $value ) {
				if( $value ) {
					$check++;
				}
			}
		}
		$empty = $check > 0 ?  false : true;
		return $empty;
	}

	/**
	 * Remove key from simple array. Like unset().
	 * @param array $array
	 * @param array $new_array
	 */
	function remove_array_keys( $array, $new_array ) : array {
		if( $new_array ) {
			foreach( $new_array as $item ) {
				// Remove key
				if( $key = array_search($item,$array) !== false ) {
					unset($array[$key]);
				}
			} 
		}
		return $array;
	}

	/**
	 * Insert key in array in specific position.
	 * @param array $array
	 * @param integer $position
	 * @param mixed $value
	 */
	function insert_key_in_position( $array, $position, $value ) : array {
		// New array
		$new_array = array_merge(
			array_slice(
				$array, 
				0, 
				$position
			), 
			[
				$value
			], 
			array_slice(
				$array, 
				$position
			)
		);
		return $new_array;
	}

	/**
	 * Array key replace.
	 * @param string $item
	 * @param string $replace_with
	 * @param array $array
	 */
	function array_key_replace( $item, $replace_with, $array ) : array {
		// Default value
		$updated_array = [];
		// Loop and populate main array
		foreach( $array as $key => $value ) {
			// Condition
			if( !is_array($value) && $key == $item ) {
				// Skip
				$updated_array = array_merge($updated_array,[$replace_with=>$value]);
				continue;
			}
			$updated_array = array_merge($updated_array,[$key=>$value]);
		}
		return $updated_array;
	}

	/**
	 * Convert HTML table to PHP array.
	 * @param string $table
	 * @param integer $start
	 * @param integer $end
	 */
	function html_table_to_array( $table, $start = 0, $end = null ) : array {
		// Create new HTML document
		$dom = new DOMDocument();
		// Add meta to preserve the original characters
		$content_type = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		// Load HTML
		$dom->loadHTML( $content_type . $table );
		// Save HTML
		$dom->saveHTML();
		// Get table th
		$ths = $dom->getElementsByTagName('th');
		// Get table td
		$tds = $dom->getElementsByTagName('td');
		// Get header name of the table
		foreach( $ths as $node_header ) {
			$data[] = trim($node_header->textContent);
		}
		// Get row data/detail table without header name as key
		$i = 0;
		$j = 0;
		// Default values
		$new_data = [];
		$temp_data = [];
		foreach( $tds as $node_detail ) {
			$new_data[$j][] = trim($node_detail->textContent);
			$i = $i + 1;
			$j = $i % count($data) == 0 ? $j + 1 : $j;
			// Increment index
		}
		// Index
		$index = 0;
		// Get row data/detail table with header name as key and outer array index as row number
		for( $i = 0; $i < count($new_data); $i++ ) {
			// Check and skip iteration
			if( $start > $index ) {
				$index++;
				continue;
			}
			for($j = 0; $j < count($data); $j++) {
				$temp_data[$i][$data[$j]] = $new_data[$i][$j];
			}
			$index++;
			// Check and break loop
			if( $end !== null && $end < $index ) {
				break;
			}
		}
		// Clean new data
		$new_data = $temp_data; 
		unset($temp_data);
		return $new_data;
	}

}

/**
 * Get or extract data functions.
 *
 */
class mktFnGet{

	/**
	 * Remove default files from an array of files created with scandir().
	 * @param array $values
	 */
	function scandir_remove_defaults( $values ) : array {
		// Return value
		$clean_array = [];
		// Default values
		$default_values = [
			'.',
			'..',
			'.DS_Store',
			'index.php'
		];
		// If array is not empty
		if( $values ) {
			// Loop through array
			foreach( $values as $value ) {
				// If current value is not in default values
				if( !in_array( $value, $default_values ) ) {
					// Add value to clean array
					$clean_array[] = $value;
				}
			}
		}
		return $clean_array;
	}

	/**
	 * Get url from string.
	 * @param string $string
	 */ 
	function get_url_from_string( $string ) : string {
		// Manipulate string
		preg_match_all(
			'#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', 
			$string, 
			$match
		);
		return $match[0][0];
	}

	/**
	 * Get script source by handle.
	 * @link https://stackoverflow.com/questions/56314360/get-scripts-url-by-handle-in-wordpress
	 * @param string $handle
	 */
	function get_script_src_by_handle( $handle ) : string {
		// Get enqueued scripts
		global $wp_scripts;
		// Default value
		$src = null;
		// If handle is in array
		if( in_array($handle,$wp_scripts->queue) ) {
			// Get source
			$src = $wp_scripts->registered[$handle]->src;
		}
		return $src;
	}

	/**
	 * Get style source by handle.
	 * @link https://stackoverflow.com/questions/56314360/get-scripts-url-by-handle-in-wordpress
	 * @param string $handle
	 */
	function get_style_src_by_handle( $handle ) : string {
		// Get enqueued styles
		global $wp_styles;
		// Default value
		$src = null;
		// If handle is in array
		if( in_array($handle,$wp_styles->queue) ) {
			// Get source
			$src = $wp_styles->registered[$handle]->src;
		}
		return $src;
	}

	/**
	 * Return author ID from display_name field.
	 * @param string $display_name
	 */
	function get_user_id_by_display_name( $display_name ) : int {
		// Get database global
		global $wpdb;
		// MySql query
		$user_id = $wpdb->get_row( 
			$wpdb->prepare(
				"SELECT `ID` 
				FROM $wpdb->users 
				WHERE `display_name` = %s", 
				$display_name
			)
		);
		return $user_id;
	}

	/**
	 * Get JSON from url. !!! It's better using wp_remote_get()?
	 * @param string $url
	 */
	function get_json( $url ) : object {
		// Default value
		$object  = null;
		// Get fiel content
		$json = file_get_contents( $url );
		// If content
		if( $json ) {
			// Convert in PHP
			$object = json_decode($json);
		}	
		return $object;
	}

	/**
	 * Get the file extension without period. !!! Almost same as above, is this really needed?
	 * @param string $filename
	 */
	function file_ext( $filename ) : string {
		$extension = preg_match('/\./', $filename) ? preg_replace('/^.*\./', '', $filename) : '';
		return $extension;
	}

	/**
	 * Get url from an img tag. !!! To be verified.
	 * @param string $input
	 */
	function get_img_src( $input ) : string {
		preg_match_all("/<img[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $input, $output);
		$return = [];
		if (isset($output[1][0])) {
			$return = $output[1];
		}
		foreach( (array) $return as $source ) {
			return $source . PHP_EOL;
		}
	}

	/**
	 * Get url from an iframe. !!! To be verified
	 * @param string $input
	 */
	function get_iframe_src( $input ) : string {
		preg_match_all('/<iframe[^>]+src="([^"]+)"/', $input, $output);
		$return = [];
		if (isset($output[1][0])) {
			$return = $output[1];
		}
		foreach ((array) $return as $source) {
			return $source . PHP_EOL;
		}
	}

	/**
	 * Get server public IP address.
	 */
	function get_server_ip() : string {
		// Bail out early
		if( !is_admin() ) {
			exit;
		}
		// Init cUrl
		$curl = curl_init();
		// Fetch data
		curl_setopt_array($curl, array(
			CURLOPT_URL				=> 'https://ipinfo.io/ip',
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_CUSTOMREQUEST	=> 'GET'
		));
		// Print value
		return 'https://ipinfo.io/ip = ' . curl_exec($curl);
	}

	/**
	 * Get all editable roles.
	 */ 
	function get_editable_roles() : array {
		// Glbal WP roles
		global $wp_roles;
		// All roles
		$all_roles = $wp_roles->roles;
		// Editable roles
		$editable_roles = apply_filters('editable_roles', $all_roles);
		return $editable_roles;
	}

	/**
	 * Get term list in array. !!! Use list pluck?
	 * @param integer $post_id
	 * @param string/array $tax
	 */ 
	function get_term_list( $post_id, $tax ) : array {
		// Get ther terms
		$terms = get_the_terms( $post_id, $tax );
		// Default value
		$list = [];
		// If terms
		if( $terms ) {
			// Loop terms
			foreach( $terms as $term ) {
				// Add values to main array
				$list['names'] = $term->name;
				$list['slugs'] = $term->slug;
			}
		}
		return $list;
	}

	/**
	 * Get number of months between two dates.
	 * @param string $date1
	 * @param string $date2
	 */
	function months_counter( $date_1, $date_2 ) : int {
		// Vars
		$start = new DateTime( $date_1 );
		$end = new DateTime( $date_2 );
		$end = $end->modify( '+1 month' );
		// Create interval
		$interval = DateInterval::createFromDateString('1 month');
		// Create period
		$period = new DatePeriod( $start, $interval, $end );
		// Counter index
		$counter = 0;
		// Loop and increment
		foreach( $period as $dt ) {
			++$counter;
		}
		return $counter;
	}

	/**
	 * Get Google Maps object requested through Google Maps Web Service.
	 * @link https://stackoverflow.com/questions/23212681/php-get-latitude-longitude-from-an-address
	 * See answer by FahadKhan
	 * @param string $address
	 */
	function get_gmap_object( $address ) : array {
		// Default value
		$acf_map = null;
		// Prepare address string to be emebedded in url by replacing spaces with plus
		// Get Google Maps APi Key
		// The key must have set IP address as restriction,
		// it won't work with restriction by HTTP referrer,
		// this means that you need two different Api Keys.
		// Places API must be activated.
		$apiKey = get_field('google_maps_api_key_web_service','options');
		// URL
		$url = add_query_arg(
			[
				'address'	=>	urlencode($address),
				'sensor'	=>	'false',
				'key'		=>	esc_attr($apiKey),
			],
			'https://maps.googleapis.com/maps/api/geocode/json'
		);
		// Request data
		$geocode = file_get_contents(esc_url_raw($url));
		// Decode json
		$output = json_decode($geocode);
		// If results
		if( $output->results ) {
			// Map data
			$map_data = $output->results[0];
			// Populate array for ACF map
			$acf_map = [
				'address'			=>	$map_data->formatted_address,
				'lat'				=>	$map_data->geometry->location->lat,
				'lng'				=>	$map_data->geometry->location->lng,
				'zoom'				=>	14,
				'place_id'			=>	$map_data->place_id,
				'street_number'		=>	$map_data->address_components[0]->long_name,
				'street_name'		=>	$map_data->address_components[1]->long_name,
				'street_name_short' =>	$map_data->address_components[1]->short_name,
				'city'				=>	$map_data->address_components[2]->long_name,
				'state'				=>	$map_data->address_components[4]->long_name,
				'state_short'		=>	$map_data->address_components[4]->short_name,
				'post_code'			=>	$map_data->address_components[7]->long_name,
				'country'			=>	$map_data->address_components[6]->long_name,
				'country_short'		=>	$map_data->address_components[6]->short_name,
			];
		}
		return $acf_map;
	}

	/**
	 * Implode array of post IDs in list items or string separated by custom glyph.
	 * @param array $ids
	 * @param string $format
	 * @param string $field
	 */
	function ids_to_list( $ids, $format, $field = null ) : string {
		// Default value	
		$list = [];
		if( $ids ) { 
			foreach( $ids as $item ) { 
				if( $field ) {
					$list[] = get_field($field,$item);				
				}else{
					$list[] = get_the_title($item);
				}
			}
			if( $format == 'list' ) {
				$list = '<li>' . implode('</li><li>',$list) . '</li>';
			}else {
				$list = implode($format,$list);
			}
		}else{
			$list = '<span class="text-error font-bold">' . __('Error! No data.','mklang') . '</span>';
		}
		return $list;
	}

	/**
	 * Extract acronym with first letters of a string.
	 * @param string $words
	 */
	function acronym( $words ) : string {
		// Default value
		$acronym = '';
		// Convert to array
		$words = explode(' ',$words);
		// Loop and add to default value
		foreach( $words as $w ) {
			$acronym .= mb_substr($w,0,1);
		}
		return $acronym;
	}

	/**
	 * Generate random string of a given number of characters.
	 * @param integer $length
	 */
	function generate_random_string( $length = 25 ) : string {
		// Set of characters
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		// String length
		$charactersLength = strlen($characters);
		// Default value
		$randomString = '';
		// Loop
		for( $i = 0; $i < $length; $i++ ) {
			// Build random string
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * Returns the client IP address.
	 */
	function get_client_ip() : string {
		// Default value
		$ip_address = '';
		if( getenv('HTTP_CLIENT_IP') ) {
			$ip_address = getenv('HTTP_CLIENT_IP');
		}
		elseif( getenv('HTTP_X_FORWARDED_FOR') ) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif( getenv('HTTP_X_FORWARDED') ) {
			$ip_address = getenv('HTTP_X_FORWARDED');
		}
		elseif( getenv('HTTP_FORWARDED_FOR') ) {
			$ip_address = getenv('HTTP_FORWARDED_FOR');
		}
		elseif( getenv('HTTP_FORWARDED') ) {
			$ip_address = getenv('HTTP_FORWARDED');
		}
		elseif( getenv('REMOTE_ADDR') ) {
			$ip_address = getenv('REMOTE_ADDR');
		}else{
			$ip_address = 'UNKNOWN';
		}
		return $ip_address;
	}

	/**
	 * Get time ago message based on seconds.
	 * @link https://gist.github.com/mokoshalb/8e2e1224cc3fb1f2c82c0d383ad67240
	 * @param integer $sec
	 */
	function time_ago( $sec ) : string {
		// Default value
		$label = '';
		// Starting seconds
		$date1 = new DateTime("@0");
		// Ending seconds
		$date2 = new DateTime("@$sec");
		// The time difference
		$interval = date_diff($date1, $date2);
		// Convert into Years, Months, Days, Hours, Minutes and Seconds
		$years = intval($interval->format('%y'));
		$months = intval($interval->format('%m'));
		$days = intval($interval->format('%d'));
		$hours = intval($interval->format('%h'));
		$minutes = intval($interval->format('%i'));
		$seconds = intval($interval->format('%s'));
		// Return value accroding to time
		if( $years > 0 ) {
			$label = sprintf(__('%s Years, %s months and %s days ago.','mklang'),$years,$months,$days);
		}elseif( $months > 0 ) {
			$label = sprintf(__('%s Months and %s days ago.','mklang'),$months,$days);
		}elseif( $days > 0 ) {
			$label = sprintf(__('%s Days and %s hours ago.','mklang'),$days,$hours);
		}elseif( $hours > 0 ) {
			$label = sprintf(__('%s Hours and %s minutes ago.','mklang'),$hours,$minutes);
		}elseif( $minutes > 0 ) {
			$label = sprintf(__('%s Minutes and %s seconds ago.','mklang'),$minutes,$seconds);
		}elseif( $seconds > 0 ) {
			$label = sprintf(__('%s Seconds ago.','mklang'),$seconds);
		}
		return $label;    
	}

	/**
	 * Delete text between 2 strings.
	 * @param string $beginning
	 * @param string $end
	 * @param string $string
	 */
	function delete_all_between( $beginning, $end, $string ) : string {
		// Start position
		$beginningPos = strpos($string,$beginning);
		// End position
		$endPos = strpos($string, $end);
		if( $beginningPos === false || $endPos === false ) {
			return $string;
		}
		// Text to delete
		$textToDelete = substr(
			$string,$beginningPos,
			($endPos + strlen($end)) - $beginningPos
		);
		// Recursion to ensure all occurrences are replaced
		return delete_all_between(
			$beginning, 
			$end, 
			str_replace($textToDelete, '', $string)
		);
	}
	
	/**
	 * Get user last login datetime.
	 * @param integer $user_id
	 */
	function get_last_login( $user_id ) : string {
		// Default value
		$login_date = __('Never logged in','mklang');
		// Get last login
		$last_login = get_user_meta($user_id,'last_login',true);
		// If last login
		if( $last_login ) {
			$login_date = date('l j F Y, H:i',$last_login);
		}
		return $login_date;
	}

	/**
	 * Get role capabilities. return $role_caps !!! Maybe $capabilities.
	 * @param string $role
	 */ 
	function get_role_caps( $role ) : array {
		// Default capabilities
		$capabilities = [];
		// Get role
		$get_role = get_role($role);
		// If role
		if( $get_role ) {
			// Get role capabilities
			$role_caps = $get_role->capabilities;
			// Add to main array
			foreach( wp_roles()->role_objects as $item ) {
				$capabilities[] = $item;
			}
		}
		return $role_caps; // !!! Maybe $capabilities
	}

}

/**
 * Check data functions.
 */
class mktFnCheck{

	/**
	 * Check if a url is from youtube, vimeo or facebook.
	 * @param string $url
	 * @param string $provider
	 */
	function is_url_from( $url, $provider = 'youtube' ) : bool {
		if( str_contains($url,$provider) ) {
			return true;
		}
	}

	/**
	 * Check if a value of a key is in an array.
	 * @param string $array_key
	 * @param string $value
	 * @param array $array
	 */
	function is_in_array( $array_key, $value, $array ) : bool {
		foreach( $array as $key => $val ) {
			if ($val[$array_key] === $value) {
				return true;
			}
		}
		return null;
	}

	/**
	 * Check if post is in a menu.
	 * @param integer $menu: int post object id of page
	 * @param  integer $object_id: int post object id of page
	 */
	function post_is_in_menu( $menu = null, $object_id = null ) : bool {
		// Get menu object
		$menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );
		// Bail out if this is not a menu
		if( !$menu_object ) {
			return false;
		}
		// Get the object_id field out of the menu object
		$menu_items = wp_list_pluck( $menu_object, 'object_id' );
		// Use the current post if object_id is not specified
		if( !$object_id ) {
			global $post;
			$object_id = get_queried_object_id();
		}
		// Test if the specified page is in the menu or not. return true or false.
		return in_array((int)$object_id,$menu_items);
	}

	/**
	 * Check if url is external.
	 * @param string $url
	 */
	function is_url_local( $url ) : bool {
		// Parse URL
		$parse = parse_url($url);
		// Get host
		$host = $parse['host'];
		// If no host
		if( !$host ) {
			// Maybe we have a relative link like: /wp-content/uploads/image.jpg
			// Add absolute path to begin and check if file exists
			// Check if file exists
			if( file_exists($_SERVER['DOCUMENT_ROOT'] . $url) ) {
				// Maybe you want to convert to full url?
				return true;
			}
		}
		// Strip www. if exists
		$host = str_replace('www.','',$host);
		$this_host = $_SERVER['HTTP_HOST'];
		// Strip www. if exists
		$this_host = str_replace('www.','', $this_host);
		// Check
		if( $host == $this_host ) {
			return true;
		}
		return false;
	}

	/**
	 * Add stats about server performances below everything.
	 */
	function show_wp_load_stats() : void {
		// Bail out early
		if( !current_user_can('manage_mkt_options') ) {
			return;
		}
		echo '<div id="admin-query" class="text-center text-sm">';
		echo get_num_queries();
		echo __(' queries in ','mklang');
		timer_stop(3);
		echo __(' seconds','mklang');
		echo '</div>';
	}

	/**
	 * Check user role.
	 * @param integer $role
	 */
	function is_user_role( $role = 'administrator' ) : bool {
		// Get current user
		$current_user = wp_get_current_user();
		// If user logged in and role match paramter
		if( is_user_logged_in() && get_user_role($current_user->ID) == $role ) {
			return true;
		}
		// Default to false
		return false;
	}

}