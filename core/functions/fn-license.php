<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// register Mkt Theme License
new mktLicense();

/**
 * Functions to register Mkt Theme License.
 *
 */
class mktLicense{

    /**
     * Actions and filters.
     * 
     */
    public function __construct() {

        // Conditionally display license key field
        add_filter('acf/load_field/name=bees_key',[$this,'theme_license_option']);

        // Conditionally show update theme option
        add_filter('acf/load_field/name=mkt_theme_update_option',[$this,'theme_update_option']);

        // Register license
        add_action('acf/save_post',[$this,'register_theme_license'],20);

        // Update theme
        add_action('acf/save_post',[$this,'update_theme_core'],20);
    
    }

    /**
     * Save or update theme license key.
     */
    public function register_theme_license() : void {
        // Bail out if is not admin or current screen is not available
        if( !is_admin() || !get_current_screen() ) {
            return;
        }
        // Get WP Admin page
        $screen = get_current_screen();
        // If this is not other options page
        if( $screen->id != 'theme-options_page_options-other' ) {
            return;
        }
        // Get license key (bees_key)
        $license_key = get_field('field_66634bd903602','options');
        // Delete field (the value will be encrypted and stored in a option)
        update_field('field_66634bd903602','','options');
        // Save key
        if( $license_key ) {
            // Check if string is 36 characters
            if( strlen($license_key) != 36 ) {
                // Update status code
                set_transient('mkt_theme_license_status',2,60);
                return;
            }
            // Check if string is alphanumeric
            if( !ctype_alnum( strval($license_key) ) ) {
                // Update status code
                set_transient('mkt_theme_license_status',3,60);
                return;
            }
            // Check if this is a valid key
            // Request response
            $check_license_key = wp_remote_get(
                esc_url_raw(add_query_arg(
                    [
                        'license'	=>  1,
                        'key'	    =>  $license_key,
                    ],
                    'https://repo.micheletenaglia.com/update.php'
                )),                    
                [
                    'timeout' => 10,
                    'headers' => [
                        'Accept' => 'application/json',
                    ]
                ]
            );
            if(
                is_wp_error($check_license_key)
                || 200 !== wp_remote_retrieve_response_code($check_license_key)
                || empty(wp_remote_retrieve_body($check_license_key))
            ) {
                // Delete key
                delete_option('bees_key');
                // Update status code
                set_transient('mkt_theme_license_status',4,60);
                return;
            }
            // If remote request is successful
            // Encrypt before saving
            $encrypted_key = $this->encrypt($license_key);
            update_option('bees_key',$encrypted_key);
            // Update status code
            set_transient('mkt_theme_license_status',5,60);
        }
    }

    /**
     * Modify theme license field option output.
     * @param array $field
     */
    public function theme_license_option( $field ) : array {
        // If license key is registered
        if( get_option('bees_key') ) {
            // Update instructions
            $field['instructions'] = '<span class="text-success">' . __('The license key is registered, updates are enabled.','mklang') . '</span>';
            $field['placeholder'] = '************************************';
        }
        // Check transient
        if( get_transient('mkt_theme_license_status') ) {
            // Get transient
            $status_temp = get_transient('mkt_theme_license_status');
            // Status index
            $status_code_index = [
                '1' =>  __('Register your license to enable updates.','mklang'),
                '2' =>  '<span class="text-error">' . __('The key must contain 36 characters.','mklang') . '</span>',
                '3' =>  '<span class="text-error">' . __('The key must contain only letters and numbers.','mklang') . '</span>',
                '4' =>  '<span class="text-error">' . __('This key is not valid.','mklang') . '</span>',
                '5' =>  __('The license key is registered, updates are enabled.','mklang'),
            ];
            // If array key exits
            if( array_key_exists($status_temp,$status_code_index) ) {
                // Update instructions
                $field['instructions'] = $status_code_index[$status_temp];
            }else{
                // Update instructions
                $field['instructions'] = '<span class="text-error">' . __('Something went wrong.','mklang') . '</span>';
            }
        }
        return $field;
    }

    /**
     * Update Mkt theme core.
     */
    public function update_theme_core() : void {
        // Bail out if is not admin or current screen is not available 
        // or key is not available or this is not and administrator
        // or the user did not request an update
        if( 
            !is_admin() 
            || !current_user_can('manage_options')
            || !get_current_screen() 
            || !get_option('bees_key') 
            || !get_field('mkt_theme_update_option','options') 
        ) {
            return;
        }
        // Get WP Admin page
        $screen = get_current_screen();
        // If this is not other options page
        if( $screen->id != 'theme-options_page_options-other' ) {
            return;
        }
        // Get API key
        $encrypted_key = get_option('bees_key');
        // Decrypt key
        $license_key = $this->decrypt($encrypted_key);
        // Get JSON data
        $remote = wp_remote_get(
            esc_url_raw(add_query_arg(
                [
                    'core'  =>  1,
                    'key'   =>  $license_key,
                ],
                'https://repo.micheletenaglia.com/update.php'
            )),                    
            [
                'timeout' => 10,
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]
        );
        // Bail out if error or no data
        if(
            is_wp_error($remote)
            || 200 !== wp_remote_retrieve_response_code($remote)
            || empty( wp_remote_retrieve_body($remote) )
        ) {
            // Reset field "mkt_theme_update_option"
            update_field('field_66640b032c9f3','','options');
            return;
        }
        // Decode JSON
        $remote = json_decode(wp_remote_retrieve_body($remote));
        // Get theme
        $mkt_theme = wp_get_theme();
        // Get current version
        $current_version = $mkt_theme->get('Version');
        // Compare versions and bail out
        if( version_compare($remote->version,$current_version,'<=') ) {
            // Reset field "mkt_theme_update_option"
            update_field('field_66640b032c9f3','','options');
            return;
        }
        // Get files
        $files = $remote->download_urls;
        $file_attrs = [
            'core'  =>  'zip',
            'style' =>  'css',
        ];
        // Loop and update
        foreach( $files as $key => $value ) {
            $get_file = wp_remote_get( 
                esc_url_raw($value),
                [
                    'timeout' => 10,
                    'headers' => [
                        'Authorization' =>  'Basic ' . base64_encode('pkjmnbhdt67uhbhyujbvgh:v[*1f@c13)^34#+14v_133{%ly1e4^^:+/*3'),
                        'Accept'        =>  'application/' . esc_attr($file_attrs[$key])
                    ]
                ]
            );
            // Handle error
            if( is_wp_error( $get_file ) ) {
                // Reset field "mkt_theme_update_option"
                update_field('field_66640b032c9f3','','options');
                return;
            }else{
                // Path of saved file
                $file = get_template_directory() . '/' . $key . '.' . $file_attrs[$key];
                // Save body to variable
                $zip = $get_file['body'];
                // Open file
                $fp = fopen( $file, 'w' );
                // Write file
                fwrite( $fp, $zip );
                // Close file
                fclose( $fp );
                // Unzip file
                if( $file_attrs[$key] == 'zip' ) {
                    // To unzip the file we use the Wordpress unzip_file() function
                    // You MUST declare WP_Filesystem() first
                    WP_Filesystem();
                    // Unzip file
                    $unzip = unzip_file($file,get_template_directory() . '/' );
                    if( is_wp_error($unzip) ) {
                        // Reset field "mkt_theme_update_option"
                        update_field('field_66640b032c9f3','','options');
                        return;
                    }else{
                        // Now that the zip file has been used, destroy it
                        unlink($file);
                        // Reset field "mkt_theme_update_option"
                        update_field('field_66640b032c9f3','','options');
                        return;
                    }
                }
            }
        }
    }

    /**
     * Show option to update theme only if current user is an administrator and key is registered.
     * @param array $field
     */
    public function theme_update_option( $field ) : array {
        // Fake field
        $fake_field = [
            'ID'            => $field['ID'],
            'key'           => $field['key'],
            'label'         => $field['label'],
            'name'          => $field['name'],
            'type'          => 'message',
            'message'       => __('Only administrators can update Mkt Theme.','mklang'),
            'new_lines'     => '',
            'esc_html'      => 0,
            'value'         => '',
        ];
        // Show field to administrators only and if key is registered
        if( current_user_can('manage_options') && get_option('bees_key') ) {
            // Remove "message" from fake field
            unset($fake_field['message']);
            // Get encrypted API key
            $encrypted_key = get_option('bees_key');
            // Bail out early if no API key
            if( !$encrypted_key ) {
                // Error 1. No key.
                $fake_field['instructions'] = __('Enter your Mkt license key to enable updates.','mklang');
                return $fake_field;
            }
            // Get theme
            $mkt_theme = wp_get_theme();
            // Get current version
            $current_version = $mkt_theme->get('Version');
            // Decrypt API key
            $license_key = $this->decrypt($encrypted_key);
            // Get JSON data
            $remote = wp_remote_get(
                esc_url_raw(add_query_arg(
                    [
                        'core'  =>  1,
                        'key'   =>  $license_key,
                    ],
                    'https://repo.micheletenaglia.com/update.php'
                )),                    
                [
                    'timeout' => 10,
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]
            );
            // Bail out if error or no data
            if(
                is_wp_error( $remote )
                || 200 !== wp_remote_retrieve_response_code( $remote )
                || empty( wp_remote_retrieve_body( $remote ) )
            ) {
                // Error 2. Remote get error.
                $fake_field['instructions'] = __('An error occurred while retrieving the file, Mkt Theme core cannot be updated.','mklang');
                return $fake_field;
            }
            // Decode JSON
            $remote = json_decode( wp_remote_retrieve_body( $remote ) );
            // Versions
            $versions = __('Current version','mklang') . ' ' . $current_version . ' - ' . __('Remote version','mklang') . ' ' . $remote->version;
            // Compare versions
            if( version_compare( $remote->version, $current_version, '<=') ) {
                // Error 3. Version is minor or equal error.
                $fake_field['instructions'] = __('Remote version is same or older than installed version, Mkt theme core cannot be updated.','mklang') . ' ' . $versions;
                return $fake_field;
            }else{
                // Ok
                $field['instructions'] = __('Remote version is older than current version.','mklang') . ' ' . $versions;
                return $field;
            }
        }
        return $fake_field;
    }

    /**
     * Encrypt data.
     * @link https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-a-php-string/
     * @link http://artofcoding.in/simple-way-encrypt-decrypt-data-php/
     * @link https://dev.to/manuthecoder/really-simple-encryption-in-php-3kk9
     * @param string $string.
     */
    private function encrypt( $string ) : string {
        // Store cipher method
        $ciphering = 'AES-128-CTR';
        // Use OpenSSl encryption method
        $iv_length = openssl_cipher_iv_length( $ciphering );
        $options = 0;
        // Non-NULL Initialization Vector for encryption
        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CTR'));
        $iv = '7846290857246738';
        // Store the encryption key
        // $key = get_option('website_key_three');
        $key = 'jbjb/UTG7oih89ye1io,ò,pi0';
        // Encryption of string process starts
        $encryption = openssl_encrypt(
            $string, 
            $ciphering,
            $key, 
            $options, 
            $iv
        );
        // Return the encrypted string
        return $encryption;
    }

    /**
     * Decrypt data.
     * @link https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-a-php-string/
     * @link http://artofcoding.in/simple-way-encrypt-decrypt-data-php/
     * @link https://dev.to/manuthecoder/really-simple-encryption-in-php-3kk9
     * @param string $string
     */
    function decrypt( $string ) : string {
        // Store cipher method
        $ciphering = 'AES-128-CTR';
        // Use OpenSSl encryption method
        $options = 0;
        // Decryption of string process starts
        // Used openssl_random_pseudo_bytes() 
        // which gives randomly 16 digit values
        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CTR'));
        $iv = '7846290857246738';
        // Store the decryption key
        $key = 'jbjb/UTG7oih89ye1io,ò,pi0';
        // Descrypt the string
        $decryption = openssl_decrypt(
            $string,
            $ciphering,
            $key,
            $options,
            $iv
        );
        // Return the decrypted string
        return $decryption;
    }

}