<?php

namespace Whatever;

class Card_Memorial extends Card {


	public function content() {

		echo sprintf(
			'<div class="faded-excerpt">%s</div>',
			get_the_excerpt()
		);

		echo sprintf(
			'<p><a href="%s">— %s</a></p>',
			get_permalink(),
			get_the_title()
		);

	}
}
