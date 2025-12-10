<?php
/**
 *
 * Snippet for language select
 *
 * @var $args array Array with options. ID is required
 *
 */
$current_language = $args['lang'];
?>

<form method="get" action="">
    <select name="book_language" id="book-language" onchange="this.form.submit()">
        <option value="">All languages</option>
        <?php 
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