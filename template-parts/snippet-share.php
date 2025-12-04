<?php

$url = get_permalink();
$title = get_the_title();

$networks = [
	'facebook' => 'https://www.facebook.com/sharer.php?u=' . $url,
	'twitter' => 'https://twitter.com/share?url=' . $url . '&text=' . $title,
	'reddit' => 'https://reddit.com/submit?url=' . $url . '&title=' . $title,
];

?>

<div class="forward">

    <h3 class="cta">
        Share this:
    </h3>
	<?php
	foreach ($networks as $network => $link){
		echo sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			$link,
			wtvr_svg($network)


		);
	}

	?>
</div>
