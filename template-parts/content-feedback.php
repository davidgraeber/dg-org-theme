<?php
/**
 * Template part for displaying feedback page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 *
 * @var $args array
 */

?>

<div class="grid grid-3 grid-article">


    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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
			$summary      = get_field( 'summary' );
			if ( $summary ) : ?>
                <div class="summary">
					<?php echo wpautop( $summary ); ?>
                </div>
			<?php endif; ?>

			<?php


			if ( ! current_user_can( 'edit_others_pages' ) ) {
				// if visitor
				acfe_form( 'publications-feedback' );

			} else {
				// if editor or admin
				$feedback = new WP_Query( [
				  'post_type' => 'feedback',
				] );

				if ( $feedback->have_posts() ) {
					while ( $feedback->have_posts() ) {
						$feedback->the_post();

						echo '<div class="feedback-card">';

						$name = get_field( 'name' );
						$email = get_field( 'email' );
						$message = get_field( 'message' );

						echo sprintf( '<p><b>%4$s</b> %5$s</p>
                                       <p>From %1$s (<a href="mailto:%2$s">%2$s</a>):</p>
                                       <div>%3$s</div>',
						  $name,
						  $email,
                          wpautop(sanitize_textarea_field($message)),
						  get_the_date(),
						  get_the_time(),
						);

						echo '</div>';

					}
				}

			}

			?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
			<?php // wtvr_entry_footer(); ?>
        </footer><!-- .entry-footer -->


    </article><!-- #post-<?php the_ID(); ?> -->
</div>
