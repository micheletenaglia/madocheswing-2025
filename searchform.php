<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="search-form">
		<input type="search" class="" placeholder="<?php _e('Search...', 'project'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo _e('Search', 'project'); ?>">
		<button type="submit" aria-label="<?php _e('Search','project'); ?>"><span><?php echo _e('Search','project'); ?></span></button>
	</div>
</form>