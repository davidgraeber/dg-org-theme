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
  'columns',
] );

$attachments = get_field( 'post-attachments' );
$extenal     = isset( $attachments['external-link'] );

$related_IDs        = get_field( 'related_content' );
$related_IDs_sorted = [];

// cycle related items
foreach ( $related_IDs as $related_ID ) {
	// get each item post type
	$related_type = get_post_type( $related_ID );

	// put related id into the sorted basket under it's post type key
	if ( 'tracks' === $related_type ) {
		$track_n = get_field( 'track_number', $related_ID );

		$related_IDs_sorted[ $related_type ][ $track_n ] = $related_ID;
		ksort( $related_IDs_sorted[ $related_type ] );
	} else {
		$related_IDs_sorted[ $related_type ][] = $related_ID;
		sort( $related_IDs_sorted[ $related_type ] );
	}

}
?>

<?php if ( count( $a['columns'] ) > 1 ) : ?>
	<?php foreach ( $a['columns'] as $column ): ?>


        <div class="grid-td">
            <p class="td-inner">

				<?php switch ( $column['type'] ) {
					case 'default':

						switch ( $column['field'] ) {
							// If the cell is post title
							case 'post_title':

								// If has external link
								if ( $extenal && strlen( $attachments['external-link'] ) > 1 ) {
									echo sprintf( '<a href="%s" target="_blank">%s</a>',
									  $attachments['external-link'],
									  'External link' );
								}
								// Header
								echo sprintf(
								  '<a href="%s" id="post-%s">',
								  esc_url( get_permalink() ),
								  get_the_ID()
								);
								// Title itself
								echo sprintf( '<h3 class="entry-title">%s</h3>', get_the_title() );

								// Subtitle if any
								if ( $subtitle = get_field( 'subtitle' ) ) {
									sprintf( '<h4 class="entry-subtitle">%s</h4>', $subtitle );
								}
								// Close header
								echo '</a>';

								break;

						}
						break;

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