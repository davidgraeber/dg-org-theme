<?php
/**
 * Template part for displaying people content type
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 *
 * @var $args array
 */

$a = wtvr_localize_args($args, [
    'no-thumbnail',
]);

$post_type = get_post_type();
$post_type_layout = get_field($post_type . '-layout', 'option');
$custom_features = get_field('post-options');
$attachments = get_field('post-attachments');
$external = isset($attachments['external-link']);

if (isset($custom_features['layout'])) {
    if ('landscape' !== $custom_features['layout']) {
        $layout = $custom_features['layout'];
    } elseif ($post_type_layout) {
        $layout = $post_type_layout;
    } else {
        $layout = 'landscape';
    }
} elseif ($post_type_layout) {
    $layout = $post_type_layout;
} else {
    $layout = 'landscape';
}

$images = wtvr_get_featured_images(get_the_ID());
?>

<div class="people-layout">
    <article id="post-<?php the_ID(); ?>" <?php post_class([$layout, 'content', 'people-layout']); ?>>
        <div class="people-container">
            <!-- Левая колонка с аватаром -->
            <div class="people-avatar-column">
                <?php if ($images) : ?>
                    <div class="people-avatar">
                        <?php 
                        $image_url = wp_get_attachment_image_url($images[0], 'large');
                        $image_alt = get_post_meta($images[0], '_wp_attachment_image_alt', true);
                        ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                <?php endif; ?>
                <div class="people-links-column">
                    <?php   
                    $links = get_field('people_links');
                    if ($links) : ?>
                        <?php
                        echo '<h2>Links</h2>';
                        echo $links; 
                        ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Правая колонка с контентом -->
            <div class="people-header-column">
                <header class="entry-header">
                    <?php do_action('wtvr_before_title'); ?>

                    <?php
                    if (is_singular()) :
                        the_title('<h1 class="entry-title">', '</h1>');
                    else :
                        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    endif;

                    $subtitle = get_field('subtitle');
                    if ($subtitle) : ?>
                        <h3 class="subtitle">
                            <?php echo $subtitle; ?>
                        </h3>
                    <?php endif; ?>
                </header>
            </div>
            
            <div class="people-content-column">
                <div class="entry-content">
                    <?php
                    $summary = get_field('summary');
                    $hide_summary = get_field('hide_summary');
                    if ($summary && !$hide_summary) : ?>
                        <div class="summary">
                            <?php echo wpautop($summary); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    do_action('wtvr_before_content');
                    the_content();
                    ?>
                   

                    <?php
                    do_action('wtvr_after_content');
                    ?>
                </div>
            </div>
        </div>
    </article>

    <!-- Добавляем секцию related -->
    <?php
    // Получаем обычный related контент
    $related = get_field('related_content');

    // Получаем книги, где человек является переводчиком
    $books = get_posts(array(
        'post_type' => 'books',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));

    $translated_books = array();
    foreach ($books as $book) {
        // Проверяем существование книги
        if (!$book || !isset($book->ID)) {
            continue;
        }

        $translations = get_field('translations', $book->ID);
        if (!$translations || !is_array($translations)) {
            continue;
        }

        foreach ($translations as $translation) {
            // Проверяем корректность данных перевода
            if (!isset($translation['translators']) || !is_array($translation['translators'])) {
                continue;
            }

            foreach ($translation['translators'] as $translator) {
                // Проверяем корректность объекта переводчика
                if (!is_object($translator) || !isset($translator->ID)) {
                    error_log(sprintf(
                        'Invalid translator data found in book ID: %d. Translator data: %s',
                        $book->ID,
                        print_r($translator, true)
                    ));
                    continue;
                }

                if ($translator->ID == get_the_ID()) {
                    $translated_books[] = $book->ID;
                    break 2;
                }
            }
        }
    }

    // Добавляем дополнительную проверку перед слиянием массивов
    $related = is_array($related) ? array_filter($related) : array();
    $translated_books = array_filter($translated_books);
    $related_posts = array_unique(array_merge($related, $translated_books));

    // Дополнительная проверка на валидность всех постов
    $related_posts = array_filter($related_posts, function($post_id) {
        $post = get_post($post_id);
        return $post && 'publish' === $post->post_status && get_post_type($post);
    });

    // Проверяем, есть ли что показывать
    if (!empty($related_posts)): ?>
        <section class="related">
            <div class="related-header">
                <h3>Related materials</h3>
                <?php
                $post_types = array();
                foreach ($related_posts as $post_id) {
                    $post = get_post($post_id);
                    if (!$post) continue; // Пропускаем если пост не существует
                    
                    $post_type = get_post_type($post_id);
                    if (!$post_type) continue; // Пропускаем если нет типа записи
                    
                    if ($post_type === 'books' && in_array($post_id, $translated_books)) {
                        $post_types['translations'] = 'Translations';
                    } else {
                        $post_type_obj = get_post_type_object($post_type);
                        if ($post_type_obj && isset($post_type_obj->labels->singular_name)) {
                            $post_types[$post_type] = $post_type_obj->labels->singular_name;
                        } else {
                            $post_types[$post_type] = ucfirst($post_type); // Fallback
                        }
                    }
                }
                if (!empty($post_types)):
                ?>
                    <ul class="content-type-filter">
                        <?php foreach ($post_types as $type => $label): ?>
                            <li data-type="<?php echo esc_attr($type); ?>">
                                <?php 
                                if ($type === 'translations') {
                                    echo esc_html($label);
                                } else {
                                    $post_type_obj = get_post_type_object($type);
                                    echo esc_html($post_type_obj ? $post_type_obj->labels->singular_name : $type);
                                }
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="grid grid-3">
                <?php foreach ($related_posts as $post_id):
                    $post = get_post($post_id);
                    setup_postdata($post);
                    $post_type = get_post_type();
                    $card_type = ($post_type === 'books' && in_array($post_id, $translated_books)) ? 'translations' : $post_type;
                ?>
                    <article class="card related-post <?php echo esc_attr($card_type); ?>">
                        <a href="<?php echo get_permalink(); ?>" rel="bookmark">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="related-post-thumbnail">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="inner">
                                <div class="caption-icon-wrap">
                                    <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
                                </div>
                                <div class="related-post-content">
                                    <?php if (get_post_type() !== 'page'): ?>
                                        <div class="related-post-meta">
                                            <span class="related-post-type">
                                                <?php 
                                                if ($post_type === 'books' && in_array($post->ID, $translated_books)) {
                                                    echo 'Book Translation';
                                                } else {
                                                    $post_type_obj = get_post_type_object($post_type);
                                                    echo esc_html($post_type_obj ? $post_type_obj->labels->singular_name : $post_type);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="related-post-title"><?php the_title(); ?></h3>
                                    
                                    <?php if (!has_post_thumbnail()): ?>
                                        <div class="related-post-excerpt">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php 
                    endforeach;
                    wp_reset_postdata();
                ?>
            </div>
        </section>
    <?php endif; ?>
</div>
