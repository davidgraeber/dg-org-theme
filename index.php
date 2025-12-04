<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 */

get_header();
$blog_page_id = get_option( 'page_for_posts' );
?>

    <main id="primary" class="site-main">
        <section class="feature">

			<?php // Featured image(s)
			if ( $images = wtvr_get_featured_images( $blog_page_id ) ) :
				get_template_part( 'template-parts/snippet', 'thumbnail', [
				  'images' => $images,
				  'class'  => 'narrow fade'
				] );
			endif; ?>
        </section>

		<?php if ( ! is_front_page() ) : ?>

            <header>
                <h1 class="page-title">
					<?php echo get_the_title( $blog_page_id ); ?>
                </h1>
            </header>
			<?php echo get_post_field( 'post_content', $blog_page_id ); ?>

            <!-- <div class="tnp tnp-subscription">
                <form method="post" action="https://davidgraeber.org/?na=s" class="subscription-minimal grid grid-3">

                    <input type="hidden" name="nlang" value="">
                    <div class="tnp-field tnp-field-email inner"><input class="tnp-email" type="email" name="ne" value="" required placeholder="Your email"></div>
                    <div class="tnp-field tnp-field-button inner"><input class="tnp-submit" type="submit" value="Subscribe to newsletter" >
                    </div>
                </form>
            </div> -->
            <section class="subscribe">
                <?php acfe_form('subscribe-to-newsletter'); ?>
            </section>

		<?php endif; ?>

		<?php if ( have_posts() ) : ?>

            <section class="items archive">

                <div class="grid grid-3">
					<?php // the loop
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'card', [
						  'archive' => 'list'
						] );

					endwhile;

					the_posts_navigation(); ?>
                </div>
            </section>
		<?php endif; ?>

    </main><!-- #main -->

<?php
get_sidebar();
get_footer();
