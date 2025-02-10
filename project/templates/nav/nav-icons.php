<?php
    
/**
 * Navigation contact icons.
 * 
 */

// Icons
$icons = [
    'whatsapp' => [
        'label' =>  'Whatsapp',
        'icon'  =>  'whatsapp',
        'url'   =>  'https://wa.me/' . str_replace('+','',get_field('whatsapp','options')),
    ],
    'telephone' => [
        'label' =>  __('Telephone','project'),
        'icon'  =>  'mobile',
        'url'   =>  'tel:' . get_field('mobile_phone','options'),
    ],
    'email' => [
        'label' =>  'Email',
        'icon'  =>  'email',
        'url'   =>  'mailto:' . get_field('email','options'),
    ],
];

?>
<ul class="nav-icons">
    <?php foreach( $icons as $icon => $data ) : ?>
        <li data-icon="<?php echo esc_attr($icon); ?>">
            <a class="break-3" href="<?php echo esc_url($data['url']); ?>" title="<?php echo $data['label']; ?>"><?php echo get_svg_icon($data['icon']); ?></a>
        </li>
    <?php endforeach; ?>
    <li>
        <div class="js-menu-mobile-toggle menu-toggle-bars">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </li>
</ul>