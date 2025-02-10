<?php
/**
 * The template for displaying the footer.
 *
 * Do not edit directly!
 * Hooks must be used to customize the content.
 * 
 * @since Hap Studio 1.0.0
 */
do_action('hap_container_end');
?>

</div> <!-- #top -->
<footer>
	<?php 
        do_action('hap_footer');
        do_action('hap_footer_credits');
    ?>
</footer>
<?php 
    do_action('hap_footer_after');
    wp_footer();
?>
</body>
</html>