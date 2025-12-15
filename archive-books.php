<?php
/**
 * The template for displaying book archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 *
 * @package Whatever
 */

get_header();
$post_type = get_post_type();
$current_language = !empty($_GET['book_language']) ? intval($_GET['book_language']) : '';
$post_type_menu = ( $current_language ) ? post_type_menu_filtered_by_language($post_type, $current_language) : '';
?>

    <main id="primary" class="site-main">

		<?php if ( have_posts() ) { ?>

            <header class="page-header archive-header">
                <div>
                    <h1 class="page-title archive-title"><?php echo get_the_archive_title(); ?></h1>
                    <?php if ( !empty($post_type_menu) ){ echo $post_type_menu; } ?>
                </div>
                
                <div class="books-filter">
                    <?php get_template_part( 'template-parts/snippet', 'language-select', [
                        'lang'  => $current_language,
                        'post_type' =>  $post_type
                    ] ) ?>
                </div>
            </header><!-- .page-header -->

            <section class="items">

                <div class="book-list">

                    <?php
                    while ( have_posts() ) {
                        the_post();

                        get_template_part( 'template-parts/content', 'archive-book', [
                        'archive' => 'list',
                        ] );
                    }
        } else {
            get_template_part( 'template-parts/content', 'none' );
        };
        ?>
            </div>

			<?php the_posts_pagination() ?>

            </section>


    </main><!-- #main -->

<?php
get_sidebar();
get_footer();
