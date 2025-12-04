<?php

/**
 * Get svg code for icon
 *
 * @param string $icon search, etc
 *
 * @return false|string
 */
function wtvr_svg(string $icon){

	$svg = false;



	$svg = sprintf(
		'<svg class="svg-icon icon-%1$s"><use xlink:href="/wp-content/themes/wtvr/lib/icons/icons.svg#icon-%1$s"></use></svg>',
		$icon
	);


	return $svg;
}
