<?php

/**
 * Filter folder-like post type archive to show
 *
 * @param $query
 *
 * @return void
 */

function wtvr_folder_archive_filter( $query ) {

	// Bail in admin
	if ( is_admin() ) return;

	$post_type = $query->get( 'post_type' );

	if (!$post_type || !is_string($post_type)) return;

	// Bail on non-folder layouts
	if ('folders' !== get_field($post_type . '-archive-layout', 'option')) return;

	// Bail if folder taxonomy not specified
	$folder_taxonomy = get_field($post_type . '-folder-taxonomy', 'option');

	// Bail if taxonomy doesn't exist for some reason
	if ( !taxonomy_exists($folder_taxonomy) ) return;


	$query->set( 'tax_query', [
	  [
		'taxonomy' => $folder_taxonomy,
		'operator' => 'NOT EXISTS'
	  ]
	] );

}

add_action( 'pre_get_posts', 'wtvr_folder_archive_filter', 99 );

