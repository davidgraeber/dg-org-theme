<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 *
 * @package Whatever
 */

use Whatever\Archive;

get_header();

$post_type = get_post_type();

$images = get_field( $post_type . '-gallery', 'option' );

?>

    <main id="primary" class="site-main">


        <?php  if ($images) : ?>

            <section class="feature">
                <?php get_template_part( 'template-parts/snippet', 'thumbnail', [
                    'class'  => 'narrow fade',
                    'images' => $images,
                ] ) ?>
            </section>

        <?php endif; ?>

		<?php

        // some archives, like folder, may have no posts in 'root' directory/taxonomy
        if ( have_posts() ) : ?>


            <?php do_action( 'wtvr_before_archive_title' );

            $archive = new Archive();

        else :

            get_template_part( 'template-parts/content', 'none' ); ?>

        <?php endif; ?>


    </main><!-- #main -->

<?php
get_sidebar();
get_footer();
