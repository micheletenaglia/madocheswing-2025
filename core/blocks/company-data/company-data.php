<?php

/**
 * Block Template: Company data and footer links.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Fields.
$footer_links = get_field('company_data_footer_links');

// CSS Classes.
$class_name = '';	
if( !empty( $block['className'] ) ) { 
	$class_name .= ' ' . $block['className'];
}

// Labels
$labels = [
    'privacy'               =>  __('Privacy Policy','hap'),
    'cookie'                =>  __('Cookie Policy','hap'),
    'cookie_preferences'    =>  __('Cookie Preferences','hap'),
    'terms_and_conditions'  =>  __('Terms and Conditions','hap'),
    'copyright'             =>  __('Copyright','hap'),
    'vat_number'            =>  __('VAT No.','hap'),
    'cf_number'             =>  __('Fiscal Code','hap'),
    'whistleblowing'        =>  __('Whistleblowing','hap'),
    'google_recaptcha'      =>  'Google reCAPTCHA',
    'credits'               =>  __('Credits','hap'),
    'phone'                 =>  __('Phone','hap'),
    'mobile_phone'          =>  __('Mobile Phone','hap'),
    'toll_free_phone'       =>  __('Toll Free Phone Number','hap'),
    'email'                 =>  __('Email','hap'),
    'pec_email'             =>  __('PEC Email','hap'),
    'company_name'          =>  __('Company Name','hap'),
    'business_name'         =>  __('Business Name','hap'),
    'registered_office'     =>  __('Registered office','hap'),
    'rea_number'            =>  __('REA Number','hap'),
    'legal_representative'  =>  __('Legal Representative','hap'),
    'share_capital'         =>  __('Share Capital','hap'),
    'custom_item'           =>  __('Custom Item','hap'),
];

$google_recaptcha_msg = sprintf( __('Site protected by Google reCAPTCHA. <a href="%s" target="_blank" rel="nofollow noopener noreferrer">Privacy</a> | <a href="%s" target="_blank" rel="nofollow noopener noreferrer">Terms</a>','hap'), 'https://policies.google.com/privacy', 'https://policies.google.com/terms' );

?>

<?php if( $is_preview ) : ?>
	<div class="hap-wp-block"><!-- Start preview -->
		<div class="hap-wp-block-info"><!-- Start preview header -->
			<div class="hap-wp-block-info-left">
				<figure class="hap-wp-block-info-icon">
					<?php echo get_svg_icon( 'company-data', null, 'block-core' ); ?>
				</figure>
				<div>
					<span class="hap-wp-block-title"><?php echo esc_attr($block['title']); ?></span>
					<span class="hap-wp-block-desc"><?php echo sprintf(__('Data and links filled in on the <a href="%s" target="_blank" rel="noopener noreferrer nofollow">options page</a>.','hap'), esc_url(add_query_arg('page','options',admin_url('admin.php')))); ?></span>
				</div>
			</div>
		</div><!-- End preview header -->
		<div class="hap-wp-block-content"><!-- Start preview content -->
			<?php if( !$footer_links ) : ?>
				<strong class="text-error"><?php _e('Fill in the required fields.','hap'); ?></strong>
			<?php else : ?>
                <ul>
                    <?php if( have_rows('company_data_footer_links') ) {
                        while( have_rows('company_data_footer_links') ) {
                            the_row();
                            if( get_row_layout() == 'privacy' ) {
                                // Privacy
                                $privacy = get_field('privacy_policy_page','options');
                                if( $privacy ) {
                                    echo '<li><a href="' . get_the_permalink($privacy) . '">' . $labels['privacy'] . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'cookie' ) {
                                // Cookies
                                $cookie = get_field('cookie_policy_page','options');
                                if( $cookie ) {
                                    echo '<li><a href="' . get_the_permalink($cookie) . '">' . __('Cookie policy','hap') . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'cookie_preferences' ) {
                                // Cookie preferences (if Iubenda is activated)
                                if( is_iubenda_activated() ) {
                                    echo '<li><a href="#" class="iubenda-cs-preferences-link">' . __('Update cookie tracking preferences','hap') . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . __('This option only works when the Iubenda plugin is installed.','hap') . '</li>';
                                }
                            }elseif( get_row_layout() == 'terms_and_conditions' ) {
                                // Terms and conditions
                                if( get_sub_field('terms_and_conditions_page') ) {
                                    echo '<li><a href="' . get_the_permalink($link['terms_and_conditions_page']) . '">' . $labels['terms_and_conditions'] . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . __('Select the terms and conditions page.','hap') . '</li>';
                                }
                            }elseif( get_row_layout() == 'vat_number' ) {
                                // VAT Number
                                $vat_number = get_field('vat_number','options');
                                if( $vat_number ) {
                                    echo '<li>' . $labels['vat_number'] . ': ' . $vat_number. '</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'cf_number' ) {
                                // Fiscal code
                                $cf_number = get_field('cf_number','options');
                                if( $cf_number ) {
                                    echo '<li>' . __('FC','hap') . ': ' . $cf_number. '</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'copyright' ) {
                                // Copyright
                                $copyright_year = ( get_field('copyright_year','options') ) ? get_field('copyright_year','options') :  '<span>' . __('Copyright start year is missing.','hap') . '</span>';
                                echo '<li>&copy; ' . $copyright_year . '/' . date( 'Y' ) . ', ' . get_field('company_name','options') .'</li>';
                                echo '<li>' . __('All rights reserved','hap') .'</li>';
                            }elseif( get_row_layout() == 'whistleblowing' ) {
                                // Whistleblowing
                                echo '<li><a href="#" class="whistleblowing-link">Whistleblowing</a></li>';
                            }elseif( get_row_layout() == 'google_recaptcha' ) {
                                // Google reCAPTCHA
                                // Check if the option is set in CF7
                                $wpcf7_option = get_option('wpcf7');
                                // If CF7 is installed
                                if( $wpcf7_option ) {
                                    // If reCAPTCHA keys are set
                                    if( isset($wpcf7_option['recaptcha']) && !empty($wpcf7_option['recaptcha']) ) {
                                        echo '<li>' . $google_recaptcha_msg . '</li>';
                                    }else{
                                        echo '<li class="text-error">' . sprintf(__('Contact Form 7 is installed but the Google reCAPTCHA keys are not set. Please visit <a href="%s" target="_blank" rel="noopener noreferrer nofollow">this page</a> to set up your keys.','hap'),esc_url(add_query_arg(['page'=>'wpcf7-integration','service'=>'recaptcha','action'=>'setup'],admin_url('admin.php')))) . '</li>';
                                    }
                                }else{
                                    echo '<li class="text-error">' . __('Contact Form 7 is not installed.','hap') . '</li>';
                                }
                            }elseif( get_row_layout() == 'credits' ) {
                                // Credits
                                echo '<li>Design &amp; code by <a target="_blank" rel="noopener noreferrer nofollow" title="Tenaglia Studio" href="https://micheletenaglia.com/">Tenaglia Studio</a></li>';
                            }elseif( get_row_layout() == 'phone' ) {
                                // Phone
                                $phone = get_field('phone','options');
                                if( $phone ) {
                                    echo '<li><a href="' . esc_url('tel:' . str_replace(' ','',$phone)) . '">' . $phone . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'mobile_phone' ) {
                                // Mobile phone
                                $mobile_phone = get_field('mobile_phone','options');
                                if( $mobile_phone ) {
                                    echo '<li><a href="' . esc_url('tel:' . str_replace(' ','',$mobile_phone)) . '">' . $mobile_phone . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'toll_free_phone' ) {
                                // Toll free phone
                                $toll_free_phone = get_field('toll_free_phone','options');
                                if( $toll_free_phone ) {
                                    echo '<li><a href="' . esc_url('tel:' . str_replace(' ','',$toll_free_phone)) . '">' . $toll_free_phone . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'email' ) {
                                // Email
                                $email = get_field('email','options');
                                if( $email ) {
                                    echo '<li><a href="' . esc_url('mailto:' . $email) . '">' . $email . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'pec_email' ) {
                                // PEC Email
                                $pec_email = get_field('pec_email','options');
                                if( $pec_email ) {
                                    echo '<li>PEC: <a href="' . esc_url('mailto:' . $pec_email) . '">' . $pec_email . '</a></li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'company_name' ) {
                                // Company name
                                $company_name = get_field('company_name','options');
                                if( $company_name ) {
                                    echo '<li>' . $company_name . '</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'business_name' ) {
                                // Business name
                                $business_name = get_field('company_name','options');
                                if( $business_name ) {
                                    echo '<li>' . __('Business Name','hap') . ': ' . $business_name . '</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), __('Company Name','hap') ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'legal_representative' ) {
                                // Legal representative
                                $legal_representative = get_field('legal_representative','options');
                                if( $legal_representative ) {
                                    echo '<li>' . $legal_representative . '</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'registered_office' ) {
                                // Registered office
                                // Items
                                $address_items = [];
                                // Fields
                                $address_fields = [
                                    'address',
                                    'postcode',
                                    'city',
                                    'country',
                                ];
                                // Loop and populate
                                foreach( $address_fields as $field ) {
                                    if( get_field($field,'options') ) {
                                        $address_items[] = get_field($field,'options');
                                    }
                                }
                                // If any field
                                if( $address_items ) {
                                    echo '<li>' . $labels['registered_office'] . ': ' . implode( ', ', $address_items ) . '</li>';
                                }else{
                                    echo '<li class="text-error">' . __('Address, postcode, city and country fields are missing.','hap') . '</li>';
                                }
                            }elseif( get_row_layout() == 'rea_number' ) {
                                // REA Number
                                $rea_number = get_field('rea_number','options');
                                if( $rea_number ) {
                                    echo '<li>' . $labels['rea_number'] . ': ' . $rea_number .'</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'share_capital' ) {
                                $share_capital = get_field('share_capital','options');
                                if( $share_capital ) {
                                    echo '<li>' . $labels['share_capital'] . ': ' . euro_format($share_capital) . '</li>';
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), $labels[get_row_layout()] ) . '</li>';
                                }
                            }elseif( get_row_layout() == 'custom_item' ) {
                                if( get_sub_field('label') ) {
                                    $label = get_sub_field('label');
                                    $slug = sanitize_title($label);
                                    // Custom item
                                    if( get_sub_field('url') ) {
                                        if( get_sub_field('target_blank') ) {
                                            echo '<li><a href="' . esc_url(get_sub_field('url')) . '" target="_blank" rel="noopener noreferrer nofollow">' . esc_html($label) . '</a></li>';
                                        }else{
                                            echo '<li><a href="' . esc_url(get_sub_field('url')) . '">' . esc_html($label) . '</a></li>';
                                        }
                                    }else{
                                        echo '<li>' . get_sub_field('label') .'</li>';
                                    }
                                }else{
                                    echo '<li class="text-error">' . sprintf( __('The field <strong>%s</strong> has no value.','hap'), __('Label','hap') ) . '</li>';
                                }
                            }
                        } 
                    } ?>
                </ul>
			<?php endif; ?>
		</div><!-- End preview content -->
	</div><!-- End preview -->

<?php else : 
    // Deafult value
    $items = [];
    // Conditions
    if( have_rows('company_data_footer_links') ) {    
        while( have_rows('company_data_footer_links') ) {
            the_row();
            // Conditions
            if( get_row_layout() == 'privacy' ) {
                // Privacy
                $privacy = get_field('privacy_policy_page','options');
                if( $privacy ) {
                    $items['privacy'] = '<a href="' . get_the_permalink($privacy) . '">' . $labels['privacy'] . '</a>';
                }
            }elseif( get_row_layout() == 'cookie' ) {
                // Cookies
                $cookie = get_field('cookie_policy_page','options');
                if( $cookie ) {
                    $items['cookie'] = '<a href="' . get_the_permalink($cookie) . '">' . __('Cookie policy','hap') . '</a>';
                }
            }elseif( get_row_layout() == 'cookie_preferences' ) {
                // Cookie preferences (if Iubenda is activated)
                if( is_iubenda_activated() ) {
                    $items['cookie-preferences'] = '<a href="#" class="iubenda-cs-preferences-link">' . __('Update cookie tracking preferences','hap') . '</a>';
                }
            }elseif( get_row_layout() == 'terms_and_conditions' ) {
                // Terms and conditions
                if( get_sub_field('terms_and_conditions_page') ) {
                    $items['terms_and_conditions'] = '<a href="' . get_the_permalink(get_sub_field('terms_and_conditions_page')) . '">' . $labels['terms_and_conditions'] . '</a>';
                }
            }elseif( get_row_layout() == 'vat_number' ) {
                // VAT Number
                $vat_number = get_field('vat_number','options');
                if( $vat_number ) {
                    $items['vat_number'] = $labels['vat_number'] . ': ' . $vat_number;
                }
            }elseif( get_row_layout() == 'cf_number' ) {
                // Fiscal code
                $cf_number = get_field('cf_number','options');
                if( $cf_number ) {
                    $items['cf_number'] = __('FC','hap') . ': ' . $cf_number;
                }
            }elseif( get_row_layout() == 'copyright' ) {
                // Copyright
                $copyright_year = ( get_field('copyright_year','options') ) ? get_field('copyright_year','options') :  date( 'Y' );
                $items['copyright'] = '&copy; ' . $copyright_year . '/' . date( 'Y' ) . ', ' . get_field('company_name','options');
                $items['copyright-statement'] = __('All rights reserved','hap');
            }elseif( get_row_layout() == 'whistleblowing' ) {
                // Whistleblowing
                $items['whistleblowing'] = '<a href="#" class="whistleblowing-link">Whistleblowing</a>';
            }elseif( get_row_layout() == 'google_recaptcha' ) {
                // Google reCAPTCHA
                // Check if the option is set in CF7
                $wpcf7_option = get_option('wpcf7');
                // If CF7 is installed
                if( $wpcf7_option ) {
                    // If reCAPTCHA keys are set
                    if( isset($wpcf7_option['recaptcha']) && !empty($wpcf7_option['recaptcha']) ) {
                        $items['google_recaptcha'] = $google_recaptcha_msg;
                    }
                }
            }elseif( get_row_layout() == 'credits' ) {
                // Credits
                $items['credits'] = 'Design &amp; code by <a target="_blank" rel="noopener noreferrer nofollow" title="Tenaglia Studio" href="https://micheletenaglia.com/">Tenaglia Studio</a>';
            }elseif( get_row_layout() == 'phone' ) {
                // Phone
                $phone = get_field('phone','options');
                if( $phone ) {
                    $items['phone'] = '<a href="' . esc_url('tel:' . str_replace(' ','',$phone)) . '">' . $phone . '</a>';
                }
            }elseif( get_row_layout() == 'mobile_phone' ) {
                // Mobile phone
                $mobile_phone = get_field('mobile_phone','options');
                if( $mobile_phone ) {
                    $items['mobile_phone'] = '<a href="' . esc_url('tel:' . str_replace(' ','',$mobile_phone)) . '">' . $mobile_phone . '</a>';
                }
            }elseif( get_row_layout() == 'toll_free_phone' ) {
                // Toll free phone
                $toll_free_phone = get_field('toll_free_phone','options');
                if( $toll_free_phone ) {
                    $items['toll_free_phone'] = '<a href="' . esc_url('tel:' . str_replace(' ','',$toll_free_phone)) . '">' . $toll_free_phone . '</a>';
                }
            }elseif( get_row_layout() == 'email' ) {
                // Email
                $email = get_field('email','options');
                if( $email ) {
                    $items['phone'] = '<a class="break-words" href="' . esc_url('mailto:' . $email) . '">' . $email . '</a>';
                }
            }elseif( get_row_layout() == 'pec_email' ) {
                // PEC Email
                $pec_email = get_field('pec_email','options');
                if( $pec_email ) {
                    $items['phone'] = 'PEC: <a class="break-words" href="' . esc_url('mailto:' . $pec_email) . '">' . $pec_email . '</a>';
                }
            }elseif( get_row_layout() == 'company_name' ) {
                // Company name
                $company_name = get_field('company_name','options');
                if( $company_name ) {
                    $items['company_name'] = $company_name;
                }
            }elseif( get_row_layout() == 'business_name' ) {
                // Business name
                $business_name = get_field('company_name','options');
                if( $business_name ) {
                    $items['business_name'] = __('Business Name','hap') . ': ' . $business_name;
                } 
            }elseif( get_row_layout() == 'legal_representative' ) {
                // Legal representative
                $legal_representative = get_field('legal_representative','options');
                if( $legal_representative ) {
                    $items['legal_representative'] = $legal_representative;
                }
            }elseif( get_row_layout() == 'registered_office' ) {
                // Registered office
                // Items
                $address_items = [];
                // Fields
                $address_fields = [
                    'address',
                    'postcode',
                    'city',
                    'country',
                ];
                // Loop and populate
                foreach( $address_fields as $field ) {
                    if( get_field($field,'options') ) {
                        $address_items[] = get_field($field,'options');
                    }
                }
                // If any field
                if( $address_items ) {
                    $items['registered_office'] = $labels['registered_office'] . ': ' . implode( ', ', $address_items );
                }else{
                    $items['registered_office'] = __('No data','hap');
                }
            }elseif( get_row_layout() == 'rea_number' ) {
                // REA Number
                $rea_number = get_field('rea_number','options');
                if( $rea_number ) {
                    $items['rea_number'] = $labels['rea_number'] . ': ' . $rea_number;
                }
            }elseif( get_row_layout() == 'share_capital' ) {
                $share_capital = get_field('share_capital','options');
                if( $share_capital ) {
                    $items['share_capital'] = $labels['share_capital'] . ': ' . euro_format($share_capital);
                }
            }elseif( get_row_layout() == 'custom_item' ) {
                if( get_sub_field('label') ) {
                    $label = get_sub_field('label');
                    $slug = sanitize_title($label);
                    $css_classes = get_sub_field('css_class') ? get_sub_field('css_class') : $slug;
                    // Custom item
                    if( get_sub_field('url') ) {
                        if( get_sub_field('target_blank') ) {
                            $items[$css_classes] = '<a href="' . esc_url(get_sub_field('url')) . '" target="_blank" rel="noopener noreferrer nofollow">' . esc_html($label) . '</a>';
                        }else{
                            $items[$css_classes] = '<a href="' . esc_url(get_sub_field('url')) . '">' . esc_html($label) . '</a>';
                        }
                    }else{
                        $items[$css_classes] = '<span>' . get_sub_field('label') . '</span>';
                    }
                }
            }
        }
	}
    // If items
    if( $items ) {
        echo '<ul class="' . esc_attr($class_name) . '">';
        foreach( $items as $name => $value ) {
            echo '<li class="' . $name . '">' . $value . '</li>';
        }
        echo '</ul>';
    }

endif;