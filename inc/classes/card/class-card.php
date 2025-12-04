<?php

namespace Whatever;

abstract class Card {

	abstract protected function content();

	public function render(){

		echo sprintf(
			'<div class="card %s">',

			wtvr_class_short_file_name(get_class($this))
		);

		// content
		echo $this->content();

		// close card
		echo '</div>';
	}
}