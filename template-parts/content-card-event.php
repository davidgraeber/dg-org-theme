<?php
/**
 * Template part for displaying post cards
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 * @var $args array
 */

$a = wtvr_localize_args($args,[
  'id'
]);

$subtitle = get_field( 'subtitle', $a['id']);

?>

<div class="card-content">
    <a class="card-link header-link" href="<?php echo esc_url( get_permalink($a['id']) );?>" rel="bookmark">
        <header class="entry-header">
            <h3 class="entry-title">
                <span><?php echo get_the_title( $a['id'] ); ?></span>
            </h3>

            <?php if ( $subtitle ) : ?>
                <h4 class="subtitle">
                    <span><?php echo $subtitle; ?></span>
                </h4>

            <?php endif;

            $date = get_field( 'date', $a['id'] );
            $time = get_field( 'time', $a['id'] );

            echo '<p class="meta">';

            if ( $date ) {
	            echo '<span class="date">';
	            $nice_date = date( 'd F, Y', strtotime( $date ) );
	            echo $nice_date;
	            echo '</span>';
            }
            echo( $date && $time ? ' / ' : '' );
            if ( $time ) {
	            echo '<span class="time">';
	            echo $time;
	            echo '</span>';
            }

            echo '</p>';

            ?>

        </header><!-- .entry-header -->
    </a>

    <div class="entry-content">

        <?php if ( $summary = get_field('summary', $a['id']) ) : ?>
            <div class="summary">
                <?php  echo wpautop($summary); ?>
            </div>
        <?php endif;?>

    </div><!-- .entry-content -->
</div>