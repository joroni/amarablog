<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */
?>

		<div id="site-footer" class="boxed">
			<?php 
			do_action( 'fancythemes_credits' );
    		wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-menu' , 'fallback_cb' => false, 'depth'=>1 ) );
			if ( fancythemes_get_option('footer_credit') ):
            	echo fancythemes_get_option('footer_credit');
            else:
            ?>
            &copy; <?php bloginfo('name'); ?> <?php _e('is powered by', 'good'); ?> <a href="http://wordpress.org/" title="WordPress">WordPress</a> &amp; <a href="https://fancythemes.com" title="fancythemes" class="footer_bones_link"><?php _e('FancyThemes', 'good'); ?></a>.
            <?php endif; ?>
		</div>

	</div><!-- #main-content .site-main -->


</div><!-- #page .hfeed .site -->
<script type="text/javascript">

<?php if ( fancythemes_get_option('footer_script') ) echo fancythemes_get_option('footer_script'); ?>
</script>
<?php wp_footer(); ?>

</body>
</html>