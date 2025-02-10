<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

if ( have_comments() ) : ?>
	<span class="block h3" id="comments">
		<?php
		if( 1 == get_comments_number() ) {
			printf(
				/* translators: %s: Post title. */
				__('One response to %s','project'),
				'&#8220;' . get_the_title() . '&#8221;'
			);
		}else{
			printf(
				/* translators: 1: Number of comments, 2: Post title. */
				_n('%1$s response to %2$s','%1$s responses to %2$s',get_comments_number(),'project'),
				number_format_i18n( get_comments_number() ),
				'&#8220;' . get_the_title() . '&#8221;'
			);
		}
		?>
	</span>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>
	<ol class="commentlist">
	    <?php wp_list_comments(); ?>
	</ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>
<?php else : // This is displayed if there are no comments so far
	// If comments are open, but there are no comments
	if( comments_open() ) :
	// Comments are closed.
	else : ?>
		<p class="nocomments"><?php _e('Comments are closed.','project'); ?></p>
	<?php endif;
endif;
comment_form();