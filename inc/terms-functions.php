<?php

function wtvr_direct_child_terms( $parent, $taxonomy ){

	return get_terms( array(
		'taxonomy' => $taxonomy,
		'parent' => $parent,
		'hide_empty' => false,
	) );
}
