<?php
/**
 * Snippet for videos
 */

$a = wtvr_localize_args( $args, [
    'url',
] );

if ( empty( $a['url'] ) ) {
    return;
}

// If ACF oEmbed already returned iframe HTML
if ( is_string( $a['url'] ) && strpos( $a['url'], '<iframe' ) !== false ) {
    $embed = $a['url'];
} else {
    // Plain URL, generate embed
    $embed = wp_oembed_get( esc_url( $a['url'] ) );
}

if ( empty( $embed ) ) {
    return;
}
?>

<div class="video-wrap">
    <div class="ratio-wrap">
        <?php echo $embed; ?>
    </div>
</div>