<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

$opening_hours = get_field('store_hours');
$weekdays = hap_get_weekdays();
$today = strtolower( date('l') );

$store_data = [

// !!!  'store_photo_gallery' 		=>	__('Photo gallery','hap'),
// !!! Map
];

?>

<main class="single-store">
	
	<div class="container-md pt-8-16 pb-8-16 pl-4-8 pr-4-8">
	
		<h1><?php echo ( get_field('store_name') ) ? get_field('store_name') : get_the_title(); ?></h1>
	
		<div class="grid-1-2 gap-16">

			<div>

				<div class="sticky top-8">
					
					<ul class="list-icon link-text">

						<?php if( get_field('store_referent') ) : ?>
							<li>
								<span><?php echo get_svg_icon('store','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Referent','hap'); ?><br>
									<?php echo get_field('store_referent'); ?>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_address') ) : ?>
							<li>
								<span><?php echo get_svg_icon('map-marker','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Address','hap'); ?><br>
									<?php echo get_field('store_address'); ?>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_email_1') ) : ?>
							<li>
								<span><?php echo get_svg_icon('email','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Email','hap'); ?><br>
									<a href="mailto:<?php echo get_field('store_email_1'); ?>"><?php echo get_field('store_email_1'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_email_2') ) : ?>
							<li>
								<span><?php echo get_svg_icon('email','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Secondary email','hap'); ?><br>
									<a href="mailto:<?php echo get_field('store_email_2'); ?>"><?php echo get_field('store_email_2'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_pec_email') ) : ?>
							<li>
								<span><?php echo get_svg_icon('pec-email','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('PEC Email','hap'); ?><br>
									<a href="mailto:<?php echo get_field('store_pec_email'); ?>"><?php echo get_field('store_pec_email'); ?></a>
								</span>
							</li>
						<?php endif; ?>


						<?php if( get_field('store_phone_1') ) : ?>
							<li>
								<span><?php echo get_svg_icon('phone','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Phone','hap'); ?><br>
									<a href="tel:<?php echo get_field('store_phone_1'); ?>"><?php echo get_field('store_phone_1'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_phone_2') ) : ?>
							<li>
								<span><?php echo get_svg_icon('mobile','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Mobile phone','hap'); ?><br>
									<a href="tel:<?php echo get_field('store_phone_2'); ?>"><?php echo get_field('store_phone_2'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_toll_free_phone','h-6 fill-current text-primary') ) : ?>
							<li>
								<span><?php echo get_svg_icon('phone'); ?></span>
								<span>
									<?php _e('Toll free phone','hap'); ?><br>
									<a href="tel:<?php echo get_field('store_toll_free_phone'); ?>"><?php echo get_field('store_toll_free_phone'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_whatsapp') ) : ?>
							<li>
								<span><?php echo get_svg_icon('whatsapp','h-6 fill-current text-primary'); ?></span>
								<span>
									Whatsapp<br>
									<a href="https://wa.me/<?php echo get_field('store_whatsapp'); ?>"><?php echo get_field('store_whatsapp'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_telegram') ) : ?>
							<li>
								<span><?php echo get_svg_icon('telegram','h-6 fill-current text-primary'); ?></span>
								<span>
									Telegram<br>
									<a href="https://telegram.me/<?php echo get_field('store_telegram'); ?>"><?php echo get_field('store_telegram'); ?></a>
								</span>
							</li>
						<?php endif; ?>

						<?php if( get_field('store_website_url') ) : ?>
							<li>
								<span><?php echo get_svg_icon('external-link','h-6 fill-current text-primary'); ?></span>
								<span>
									<?php _e('Website','hap'); ?><br>
									<a href="<?php echo get_field('store_website_url'); ?>"><?php echo get_field('store_website_url'); ?></a>
								</span>
							</li>
						<?php endif; ?>

					</ul>
				
					<?php the_post_thumbnail( 'medium', ['class'=>'block mt-4-8'] ); ?>
					
				</div>

			</div>
			
			<div>
				
				<?php the_content(); ?>
				
				<?php if( have_rows('store_services') ) : ?>
				
					<div class="mt-4-8">

						<h3 class="h4"><?php _e('Services','hap'); ?></h3>

						<?php while( have_rows('store_services') ) : the_row(); ?>
						
							<div class="flex items-center">
						
								<?php if( get_sub_field('icon') ) : ?>
												
									<?php $logo_file_name = get_file_name( get_sub_field('icon')['filename'] ); ?>

									<div class="mr-4" <?php echo ( get_sub_field('color') ) ? 'style="color: ' . get_sub_field('color') . ';"' : null; ?>>
										<?php echo get_svg_icon( $logo_file_name, 'h-12 fill-current', 'uploads' ); ?>
									</div>
									
								<?php endif; ?>

								<div>
									<?php echo get_sub_field('title'); ?>
								</div>

							</div>

						<?php endwhile; ?>
						
					</div>
				
				<?php endif; ?>

				<?php if( $opening_hours ) : ?>
				
					<div class="mt-4-8">
				
						<h3 class="h4"><?php _e('Opening hours','hap'); ?></h3>
						
						<dl>	

							<?php foreach( $opening_hours as $weekday => $time ) : ?>
							
								<?php $is_today = ( $today == $weekday ) ? 'class="is-today"' : null; ?>

								<dt><?php echo $weekdays[$weekday]; ?></dt>
								<dd <?php echo $is_today; ?>><?php echo $time; ?></dd>

							<?php endforeach; ?>

						</dl>
						
					</div>
				
				<?php endif; ?>
								
			</div>
			
		</div>
		
	</div>
	
	<?php if( get_field('store_cf7_form') ) : ?>

		<div class="bg-gray-100">

			<div class="container-md p-4-8">

				<?php echo do_shortcode( '[contact-form-7 id="' . get_field('store_cf7_form') . '"]' ); ?>
			</div>
			
		</div>

	<?php endif; ?>

</main>

