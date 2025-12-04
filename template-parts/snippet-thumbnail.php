<?php
/**
 *
 * Snippet for images and thumbnails
 *
 * @var $args array Array with options. ID is required
 *
 */

$a = wtvr_localize_args( $args, [
  'class',
  'images',
  'captions',
  'cropping',
  'icon',
] );

if ( is_singular() && empty( $a['images'] ) ) {
	$a['class'] .= ' hidden';
}


?>

<div class="img-wrap <?php echo $a['class']; ?>">


	<?php if (is_array($a['images']) && count( $a['images'] ) > 1 ) : // Multiple images → slider ?>

        <div class="slider img-wrap <?php echo $a['class']; ?>">
            <div class="slides">
				<?php
                $counter = 0;
                foreach ( $a['images'] as $image ):
                    // Hide all slides but first, but show with CSS!
                    // (sass/components/media/_sliders.scss)
                    ?>

                    <div class="slide"<?php echo (0 !== $counter ? 'style="display:none;"' : '');?>>
						<?php

                        wtvr_thumbnail( $image, $a['cropping'] );

                        $counter++;
                        ?>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>

	<?php else : // Single image, if not, empty wrapper as placeholder

		// if there's a single image, use it
		if ( is_string( $a['images'] ) ) {
			$format = 'url string';
			$image = $a['images'];
		} else {
			$format = 'id array';
			$image = ( isset( $a['images'][0] ) ) ? $a['images'][0] : false;
		}
		wtvr_thumbnail( $image, $a['cropping'], $format );

	endif; ?>

	<?php if ( $a['captions'] ) : ?>

        <div class="text-wrap">

            <div class="text">
				<?php if ( count( $a['captions'] ) > 1 ) : ?>
                <div class="slider fade" data-autoplay="5000">
                    <div class="slides">
						<?php endif; ?>

						<?php foreach ( $a['captions'] as $row ) : ?>
                            <div class="slide"><p class="caption"><?php echo $row['caption'] ?></p></div>
						<?php endforeach; ?>

						<?php if ( count( $a['captions'] ) > 1 ) : ?>
                    </div>
                </div>
			<?php endif; ?>
			<div class="caption-icon-wrap">
				<?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/DGO-arrow.svg') ?>
			</div>
            </div>


        </div>


	<?php endif; ?>

</div>
