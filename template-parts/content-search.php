<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php
		global $post;

		$post_type_object = get_post_type_object( $post->post_type );
		$post_type_name   = esc_html( $post_type_object->labels->singular_name );

		echo '<em class="pt-prefix">— ' . lcfirst($post_type_name) . '</em>';

		the_title(
		  sprintf( '<h2 class="entry-title"><a href="%1$s" rel="bookmark">',
			esc_url( get_permalink() )
		  ),
		  '</a></h2>'
		); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
				<?php

				?>
            </div><!-- .entry-meta -->
		<?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-summary">
		<?php the_excerpt(); ?>
    </div><!-- .entry-summary -->

</article><!-- #post-<?php the_ID(); ?> -->
