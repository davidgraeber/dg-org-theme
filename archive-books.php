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

?>

    <main id="primary" class="site-main">

        

		<?php if ( have_posts() ) : ?>

        <header class="page-header archive-header">
            <h1 class="page-title archive-title">
				<?php echo get_the_archive_title(); ?>
            </h1>
            <div class="books-filter">
                <form method="get" action="">
                    <select name="book_language" id="book-language" onchange="this.form.submit()">
                        <option value="">All languages</option>
                        <?php 
                        // Получаем текущий выбранный язык
                        $current_language = isset($_GET['book_language']) ? intval($_GET['book_language']) : '';
                        
                        // Получаем все книги
                        $books = get_posts([
                            'post_type' => 'books',
                            'posts_per_page' => -1,
                            'fields' => 'ids'
                        ]);
                        
                        $unique_languages = [];
                        
                        // Собираем все уникальные языки из переводов
                        foreach($books as $book_id) {
                            if($translations = get_field('translations', $book_id)) {
                                foreach($translations as $translation) {
                                    if(isset($translation['language'][0])) {
                                        $lang = $translation['language'][0];
                                        $unique_languages[$lang->term_id] = $lang->name;
                                    }
                                }
                            }
                        }
                        
                        // Сортируем языки по алфавиту
                        asort($unique_languages);
                        
                        // Выводим опции
                        foreach($unique_languages as $term_id => $name) {
                            $selected = ($current_language !== '' && $current_language == $term_id) ? 'selected' : '';
                            echo sprintf(
                                '<option value="%s" %s>%s</option>',
                                esc_attr($term_id),
                                $selected,
                                esc_html($name)
                            );
                        }
                        ?>
                    </select>
                </form>
        </div>
        </header><!-- .page-header -->

        <section class="items">

            <div class="book-list">

				<?php
				while ( have_posts() ) :
					the_post();

                    get_template_part( 'template-parts/content', 'archive-book', [
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
