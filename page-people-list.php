<?php
/**
 * Template Name: People List
 *
 * This is the template that displays all people in alphabetical order
 *
 * @package Whatever
 */

get_header();
?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <?php 
        // Выводим описание страницы если оно есть
        if (get_the_content()) {
            echo '<div class="page-description">';
            the_content();
            echo '</div>';
        }
        ?>
    </header>

    <?php
    // Получаем все записи типа 'people', включая черновики
    $args = array(
        'post_type' => 'people',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'post_status' => array('publish', 'draft')
    );

    $people_query = new WP_Query($args);

    if ($people_query->have_posts()) : ?>
        <section class="people-list">
            <ul class="people-items">
                <?php
                while ($people_query->have_posts()) :
                    $people_query->the_post();
                    $post_status = get_post_status();
                    ?>
                    <li class="person-item">
                        <?php if ($post_status === 'publish') : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?>,</a>
                        <?php else : ?>
                            <span class="person-name"><?php the_title(); ?>,</span>
                        <?php endif; ?>
                    </li>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </ul>
        </section>

    <?php else : ?>
        <p><?php esc_html_e('Записи не найдены.', 'whatever'); ?></p>
    <?php endif; ?>

</main>

<?php
get_sidebar();
get_footer(); 