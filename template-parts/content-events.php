<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 *
 * @var $args array
 */

$a = wtvr_localize_args( $args, [
  'no-thumbnail',
] );

$post_type        = get_post_type();
$post_type_layout = get_field( $post_type . '-layout', 'option' );

$custom_features = get_field( 'post-options' );

$attachments = get_field( 'post-attachments' );
$extenal = isset($attachments['external-link']);


if ( isset( $custom_features['layout'] ) ) {
	if ('landscape' !== $custom_features['layout']){
		$layout = $custom_features['layout'];
	} elseif ( $post_type_layout) {
		$layout = $post_type_layout;
	} else {
		$layout = 'landscape';
	}
} elseif ($post_type_layout ) {
	$layout = $post_type_layout;
} else {
	$layout = 'landscape';
}

$images = wtvr_get_featured_images( get_the_ID() );

$video = get_field( 'featured_video' );
?>

<div class="grid grid-3 grid-article">

	<?php if ( !$a['no-thumbnail'] ) : ?>

		<section class="feature <?php echo $layout; ?>">
			<?php if ( $video ) {
				get_template_part( 'template-parts/snippet', 'video', [
				  'url'   => $video,
				  'class' => $layout,
				] );

			} else {

				get_template_part( 'template-parts/snippet', 'thumbnail', [
				  'class'    => $layout,
				  'images'   => $images,
				  'cropping' => ( isset( $custom_features['cropping'] ) ) ? $custom_features['cropping'] : 'cover'
				] );
			} ?>
		</section>
	<?php endif; ?>

	<?php
	// get related IDs
	$related_IDs = get_field( 'related_content' );
	// Only show sidebar if there's related content
	if ( $related_IDs ) :

		// get frontpage ID (to remove it)
		$frontpage_id = get_option( 'page_on_front' );

		// if front frontpage is related, remove
		if ( ( $key = array_search( $frontpage_id, $related_IDs ) ) !== false ) {
			unset( $related_IDs[ $key ] );
		} // todo: replace with a reusable function

		// continue if anything left
		if ( ! empty( $related_IDs ) ) : ?>

			<section class="meta <?php echo $layout; ?>-meta">

				<?php
				// get related content style ('group' is default, 'everything' is optional
				$related_content_style = get_field( 'related_style' );

				// if one slider with custom title
				if ( 'everything' === $related_content_style ) {

					// get custom title is set
					$related_content_title = get_field( 'related_content_title' );

					// if not set, use default
					$title = ( $related_content_title ? $related_content_title : 'Related content' );

					// render custom title
					echo '<h4 class="related-items-title">' . $title . '</h4>';
					// render slider with every related item
					wtvr_posts_slider( $related_IDs );

				} else {
					// if style not set or not 'everything' (expectedly, is 'group')

					// prepare sorted bin for related posts by post type
					$related_IDs_sorted = [];

					// cycle related items
					foreach ( $related_IDs as $related_ID ) {
						// get each item post type
						$related_type = get_post_type( $related_ID );

						// put related id into the sorted basket under it's post type key
						$related_IDs_sorted[ $related_type ][] = $related_ID;

					}

					// now cycle sorted bin by post type
					foreach ( $related_IDs_sorted as $related_post_type => $sorted_IDs ) {

						// setup group title
						if ( 'post' === $related_post_type ) {
							// If post, use custom blog items naming
							$title = 'Updates'; // todo get blog namin
						} elseif ( 'page' === $related_post_type ) {
							// If post, use custom blog items naming
							$title = 'Related pages'; // todo get blog namin
						} else {
							// Else,just Capitalize post type slug
							$title = ucfirst( $related_post_type );
						}
						// render related post type title
						echo '<h4 class="related-items-title">' . $title . '</h4>';
						// render related post type slider
						wtvr_posts_slider( $sorted_IDs );

						?>

						<?php

					} // foreach $sorted_related
				} ?>

			</section>

		<?php endif; // if there are related items (after removal of frontpage)
		?>

	<?php endif; // if get_field('related_content')?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( $layout ); ?>>

		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			$subtitle = get_field( 'subtitle' );
			if ( $subtitle ) : ?>
				<h3 class="subtitle">
					<?php echo $subtitle; ?>
				</h3>
			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-content">


            <?php
            $attachment_links = [];
            // LINKS
            if ( strlen( $attachments['external-link'] ) > 1 ) :

                $attachment_links[] = sprintf( '<a class="attachment" href="%1$s" target="_blank">%2$s</a>',
                  $attachments['external-link'],
                  'External link',
                );
            ?>
            <p class="attachments">
                <?php echo join( '<span> | </span>', $attachment_links ); ?>

            </p>
            <?php endif; ?>


			<?php
			$summary = get_field( 'summary' );
			$hide_summary = get_field( 'hide_summary' );
			if ( $summary && !$hide_summary ) : ?>
				<div class="summary">
					<?php echo wpautop( $summary ); ?>
				</div>
			<?php endif; ?>

			<?php
			the_content(
			  sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				  __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wtvr' ),
				  [
					'span' => [
					  'class' => [],
					],
				  ]
				),
				wp_kses_post( get_the_title() )
			  )
			);

			wp_link_pages(
			  [
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wtvr' ),
				'after'  => '</div>',
			  ]
			);
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php // wtvr_entry_footer(); ?>
		</footer><!-- .entry-footer -->


	</article><!-- #post-<?php the_ID(); ?> -->
</div>
