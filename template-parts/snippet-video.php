<?php
/**
 *
 * Snippet for videos
 *
 * @var $args array Array with options. ID is required
 *
 */

$a = wtvr_localize_args($args, [
	'url',
]);
?>


<div class="video-wrap">
	<div class="ratio-wrap">
		<?php echo $a['url']; ?>
	</div>
</div>
