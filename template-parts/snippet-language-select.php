<?php
/**
 *
 * Snippet for language select
 *
 * @var $args array Array with options. ID is required
 *
 */
$current_language = $args['lang'];
$post_type = $args['post_type'];
?>

<form method="get" action="">
    <select name="book_language" id="book-language" onchange="this.form.submit()">
        <option value="">All languages</option>
        <?php
        $unique_languages = [];

        //get unique languages from books
        if ("books" == $post_type ) {
            $books = get_posts([
                'post_type' => 'books',
                'posts_per_page' => -1,
                'fields' => 'ids'
            ]);
            
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

        //get unique languages from other cpts
        } else {
            $cpt_posts = get_posts([
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'fields' => 'ids'
            ]);

            if ( !empty($cpt_posts) ){
                foreach($cpt_posts as $post_id) {
                    $term = get_the_terms( $post_id, 'language' );
                    if( !empty($term) ){
                        //get first term from array
                        $lang = array_shift( $term );
                        $unique_languages[$lang->term_id] = $lang->name;
                    }
                }
            }
        }
        
        //sort languages in alphabetical order
        asort($unique_languages);
        
        //html form output
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