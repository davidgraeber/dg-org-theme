<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Whatever
 */

?>

<footer id="colophon" class="site-footer">

	<?php if ( is_front_page() || is_page( 'newsletter' ) ) : ?>

        <!-- no duplicate sub form -->

	<?php else: ?>

        <?php //acfe_form('subscribe-to-newsletter'); ?>
        <!-- form -->

	<?php endif; ?>

    <div class="site-info grid grid-3">

		<?php for ( $i = 1; $i < 4; $i ++ ) :
			$col = wtvr_option( 'footer_column_' . $i );
			?>
			<?php if ( $col ) : ?>
            <div class="footer-column">
                <div class="inner <?php echo 'special-' . $i; ?>">
					<?php echo $col; ?>
                    <!-- <?php if ( $i == 1 ) { ?>
                        <section class="subscribe">
                            <?php acfe_form('subscribe-to-newsletter'); ?>
                        </section>
                    <?php } ?> -->
                </div>
            </div>
		<?php endif; ?>
		<?php endfor; ?>

    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer();

echo "<!--";
if (current_user_can('administrator')) {

    global $micro_time;

    $time_elapsed_secs = microtime( true ) - $micro_time;

    var_dump( $time_elapsed_secs );
}
echo "-->"
?>

</body>
</html>