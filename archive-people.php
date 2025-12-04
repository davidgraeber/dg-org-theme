<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 *
 * @package Whatever
 */

get_header();
$post_type = get_post_type();

$archive_style = get_field( $post_type . '-archive-layout', 'option' );

?>

    <main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>


		<?php do_action( 'wtvr_before_archive_title' ); ?>

        <header class="page-header archive-header">
            <h1 class="page-title archive-title">
				<?php echo get_the_archive_title(); ?>
            </h1>

            <div class="page-description">
				<?php if ( is_post_type_archive() ) {


					$post_type_data = get_post_type_object( $post_type );
					$post_type_slug = $post_type_data->rewrite['slug'];

					the_field( $post_type_slug . '-description', 'option' );


				} else {

					echo get_the_archive_description();

				} ?>

            </div>
        </header><!-- .page-header -->

		<?php do_action( 'wtvr_after_archive_title' ); ?>

        <section class="items">

            <p class="items-info">
                <span class="total">
	                <?php echo sprintf(
	                  'There’re %s&nbsp;%s',
	                  wp_count_posts( $post_type )->publish,
	                  'people.'
	                ) ?>
                </span>

				<?php
				$page  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$pages = ( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;

				if ( $pages > 1 ) :

					function wtvr_what_page( $page, $pages ) {

						$compare = $pages - $page;

						if ( 1 === $pages ) {
							return 'the only page';
						}

						switch ( $compare ) {
							case $pages - 1: // first page
								$message = sprintf( 'the first of %s pages', $pages );
								break;
							case 0: // last page
								$message = sprintf( 'the last of %s pages', $pages );
								break;
							default:
								$message = sprintf( 'page %s of %s', $page, $pages );

						}

						return $message;

					}


					?>

                    <span class="current-page">
                        <?php echo sprintf(
                          'You\'re viewing %s.',
                          wtvr_what_page( $page, $pages )
                        ) ?>
                    </span>
				<?php endif; ?>
            </p>


			<?php

			$grid_style = '';

			?>


            <div class="grid grid-3 grid-list">

				<?php
				while ( have_posts() ) :
					the_post();

                    get_template_part( 'template-parts/content', 'card-person', [
                      'archive' => 'list',
                    ] );


				endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
            </div>

			<?php the_posts_pagination() ?>

        </section>


    </main><!-- #main -->

<?php
get_sidebar();
get_footer();
