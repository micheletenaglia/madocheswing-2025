<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

?>
<article class="search-card">
	<h4><?php echo strip_tags( get_the_title() ); ?></h4>
	<?php if( get_the_excerpt() ) : ?>
		<p class="truncate-2-lines"><?php echo get_the_excerpt(); ?></p>
	<?php endif; ?>
	<a href="<?php the_permalink(); ?>"><?php echo mkt_url_label(get_the_permalink()); ?></a>
</article>