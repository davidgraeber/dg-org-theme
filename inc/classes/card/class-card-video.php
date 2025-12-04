<?php

namespace Whatever;

class Card_Video extends Card {


	public function content() {

		$video = get_field( 'featured_video' );

		if ( $video ) {
			get_template_part( 'template-parts/snippet', 'video', [
				'url'   => $video,
				'class' => 'grid',
			] );

		}

		echo sprintf(
			'<h4><a href="%s">%s</a></h4>',
			get_permalink(),
			get_the_title()
		);

	}
}