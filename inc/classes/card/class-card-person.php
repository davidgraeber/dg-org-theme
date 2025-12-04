<?php

namespace Whatever;

class Card_Person extends Card {


	public function content() {

		// Avatar
		$images = wtvr_get_featured_images( get_the_ID() );

		if (isset($images[0])){
			$images = $images[0];
		}

		wtvr_thumbnail($images);

		// Name
		echo sprintf(
			'<h4><a href="%s">%s</a></h4>',
			get_permalink(),
			get_the_title()
		);

	}
}
