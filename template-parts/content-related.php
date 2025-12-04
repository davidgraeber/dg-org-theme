<?php
/**
 * Template part for displaying post cards
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 * @var $args array
 */


$a = wtvr_localize_args( $args, [
  'id'
] );

$post_type = get_post_type( $a['id'] );

$layout = get_field( $post_type . '-layout', 'option' );
$layout = ( $layout ? $layout : 'landscape' );


$custom_feature = get_field( 'post-options', $a['id'] );
$subtitle       = get_field( 'subtitle', $a['id'] );

$attachments = get_field( 'post-attachments', $a['id'] );
$external     = isset( $attachments['external-link'] );

$images = wtvr_get_featured_images( $a['id'] );
?>

<article id="post-<?php $a['id']; ?>" <?php post_class( 'related card' ); ?> data-updated>

    <div class="inner">
        <a class="card-link image-link" href="<?php echo esc_url( get_permalink( $a['id'] ) ); ?>" rel="bookmark">

			<?php get_template_part( 'template-parts/snippet', 'thumbnail', [
			  'class'    => $layout . ' fade',
			  'images'   => $images,
			  'cropping' => ( isset( $custom_feature['cropping'] ) ) ? $custom_feature['cropping'] : 'cover'
			] ); ?>
        </a>
        <div class="card-content">
            <a class="card-link header-link" href="<?php echo esc_url( get_permalink( $a['id'] ) ); ?>" rel="bookmark">
                <header class="entry-header">
                    <h3 class="entry-title">
                        <span><?php echo get_the_title( $a['id'] ); ?></span>
                    </h3>

					<?php if ( $subtitle ) : ?>
                        <h4 class="subtitle">
                            <span><?php echo $subtitle; ?></span>
                        </h4>
					<?php endif; ?>

                </header><!-- .entry-header -->
            </a>

            <div class="entry-content">
				<?php if ($external && isset($custom_feature['external-link']) && strlen( $custom_feature['external-link'] ) > 1 ) : ?>
                    <p class="external">
                        <a href="<?php echo $custom_feature['external-link']; ?>" target="_blank">
                            External link
                        </a>
                    </p>
				<?php endif; ?>

				<?php if ( $summary = get_field( 'summary', $a['id'] ) ) : ?>
                    <div class="summary">
						<?php echo wpautop( $summary ); ?>
                    </div>
				<?php endif; ?>

            </div><!-- .entry-content -->
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
