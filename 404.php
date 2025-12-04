<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Whatever
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Sorry! That page can’t be found.', 'wtvr' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">

                <p><?php esc_html_e( 'It may’ve been renamed or moved.', 'wtvr' ); ?></p>

                <p><?php esc_html_e( 'You can explore', 'wtvr' ); ?> <a href="/">the homepage</a>, browse through the menu, or search with the form below:</p>

                <?php get_search_form(); ?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
