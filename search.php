<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Whatever
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) :
			global $wp_query; ?>

			<header class="page-header">
				<h1 class="page-title">

					<?php

					/* translators: %s: search query. */
					printf( esc_html__( 'Search results for: %s (' . $wp_query->found_posts . ')', 'wtvr' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

            <section class="items">

                <p class="items-info">
                <span class="total">
	                <?php echo sprintf(
                        'There’re %s&nbsp;%s',
                        $wp_query->found_posts,
                        'results.'
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


                <div class="search-results">

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				endwhile;

				?>

                <p class="pagination">
					<?php next_posts_link( 'Older items' ); ?>
                </p>


            </section>



            <?php

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;?>



        <?php the_posts_pagination() ?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
