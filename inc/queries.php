<?php

require 'query_filters.php';

/**
 *
 * Get post IDs with optional post_type, term_id and limit filter.
 *
 * @param $post_type
 * @param $term_id
 * @param $limit
 *
 * @return array|void
 */
function wtvr_get_posts_ids( $post_type = 'post', $term_id = '*', $limit = 1000) {

	global $wpdb;


	// A sql query to return all post titles
	$results = $wpdb->get_results(

		$wpdb->prepare(

			"SELECT p.ID
	        FROM $wpdb->posts AS p
	        INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id)
	        WHERE  p.post_status = 'publish'
	        AND  p.post_type = %s
	        AND  tr.term_taxonomy_id = %s
	        ORDER BY p.post_title ASC
			LIMIT %d",

			$post_type,
			$term_id,
			$limit

		),
		ARRAY_A

	);

	// Return null if we found no results
	if ( ! $results )
		return;

	$ids = array_map(function ($arr_id){
		return $arr_id['ID'];
	}, $results);


	// get the html
	return $ids;
}
