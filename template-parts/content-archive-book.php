<?php
/**
 * Template part for displaying book archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 * @var $args array
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'book-item grid' ); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="book-cover grid-item">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="book-info grid-item">
        <a href="<?php the_permalink(); ?>" class="book-link">
            <h2><?php the_title(); ?></h2>
            <?php
            $content = get_the_content();
            if (!empty($content)) {
                echo '<div class="book-content">' . $content . '</div>';
            } else {
                $excerpt = get_the_excerpt();
                echo '<div class="book-excerpt">' . $excerpt . '</div>';
            }
            ?>
        </a>
        
        <div class="book-meta">
            <?php
            $earliest_year = get_earliest_publication_date();
            if ($earliest_year) :
            ?>
                <span><b>First published</b> <?php echo esc_html($earliest_year); ?></span>
            <?php endif; ?>
            <?php
            $unique_languages = get_unique_languages();
            if (!empty($unique_languages)) :
            ?>
                <span><b>Translations:</b> <?php echo implode(', ', $unique_languages); ?></span>
            <?php endif; ?>
        </div>
        <div class="caption-icon-wrap">
            <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
