<?php
/**
 * Template part for displaying post cards
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 * @var $args array
 */

$post_type = get_post_type();

$a = wtvr_localize_args( $args, [
  'archive',
  'columns',
] );

$layout = get_field( $post_type . '-layout', 'option' );

$row_style      = ( 'table' == $a['archive'] ? ' grid-tr' : '' );
$custom_feature = get_field( 'post-options' );


$attachments = get_field( 'post-attachments' );
$extenal     = isset( $attachments['external-link'] );

$images = wtvr_get_featured_images( get_the_ID() );


?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card ' . $a['archive'] ); ?>>
    <div class="inner">
		<?php if ( 'table' !== $layout ) : ?>
            <a class="card-link image-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">

				<?php get_template_part( 'template-parts/snippet', 'thumbnail', [
				  'class'    => $layout,
				  'images'   => $images,
				  'cropping' => ( isset( $custom_feature['cropping'] ) ) ? $custom_feature['cropping'] : 'cover'
				] ); ?>
            </a>
		<?php endif; ?>
        <div class="card-content<?php echo $row_style; ?>">
            <a class="card-link header-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                <header class="entry-header">
                    <h3 class="entry-title">
                        <span><?php echo get_the_title(); ?></span>
                    </h3>
					<?php if ( $subtitle = get_field( 'subtitle' ) ) : ?>
                        <h4 class="entry-subtitle">
                            <span><?php echo $subtitle; ?></span>
                        </h4>
					<?php endif; ?>
                </header><!-- .entry-header -->


            </a>

			<?php

			if ( $a['columns'] && count( $a['columns'] ) > 1 ) : ?>
				<?php foreach ( $a['columns'] as $column ):
					if ( 'default' === $column['type'] ) {
						continue;
					}

					?>


                    <div class="archive-td">
                        <p class="td-inner">

						<?php switch ( $column['type'] ) {
							case 'text':
								echo get_field( $column['field'] );
								break;
							case 'relationship':
								if ( ! empty( $related_IDs_sorted[ $column['field'] ] ) ) {
									$related_id = $related_IDs_sorted[ $column['field'] ][0];

									echo sprintf( '<a href="%s">%s</a> ',
									  get_the_permalink( $related_id ),
									  get_the_title( $related_id )
									);
								}
								break;
							case 'count':
								echo 'count';
						} ?>
                        </p>
                    </div>

				<?php endforeach; ?>
			<?php endif; ?>

            <div class="entry-content">
                <?php if ( $extenal && strlen( $attachments['external-link'] ) > 1 ) : ?>
                    <p class="external">
                        <a href="<?php echo $attachments['external-link']; ?>" target="_blank">
                            External link
                        </a>
                    </p>
                <?php endif; ?>


                <div class="content">
                    <?php the_content(); ?>
                </div>

            </div><!-- .entry-content -->
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
