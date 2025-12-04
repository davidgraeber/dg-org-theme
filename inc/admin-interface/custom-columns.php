<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Admin columns
 * */


global $pagenow; // for better filtering and not calling where not needed

/**
 *
 * Helper function to add any column
 *
 * @param string $column_title Column Title
 * @param string $post_type String Or Array of post types
 * @param callable $callback Column content render function
 */
function wtvr_add_admin_column( string $column_title, string $post_type, callable $callback ) {

	$column_slug = strtolower( sanitize_title( $column_title ) );

	// Add the column
	add_filter(
		'manage_' . $post_type . '_posts_columns',
		function ( $columns ) use ( $column_slug, $column_title ) {
			$columns[ $column_slug ] = $column_title;

			return $columns;
		}
	);

	// Make column sortable
	add_filter(
		'manage_edit-' . $post_type . '_sortable_columns',
		function ( $columns ) use ( $column_slug, $column_title ) {
			$columns[ $column_slug ] = $column_title;

			return $columns;
		}
	);

	// Renter column content
	add_action(
		'manage_' . $post_type . '_posts_custom_column',
		function ( $column, $post_id ) use ( $column_title, $callback ) {
			if ( sanitize_title( $column_title ) === $column ) {
				$callback( $post_id );
			}
		},
		10,
		2
	);

	// Sort the column
	add_action(
		'pre_get_posts',
		function ( $query ) use ( $column_slug ) {

			if ( isset( $_GET['orderby'] ) ) {
				$orderby = strtolower( $_GET['orderby'] );

				if ( $column_slug == $orderby ) {

					$meta_query = [
						'relation' => 'OR',
						[
							'key'     => $column_slug,
							'compare' => 'NOT EXISTS', // include not set
						],
						[
							'key' => $column_slug,
						],
					];

					$query->set( 'meta_query', $meta_query );
					$query->set( 'orderby', [
						'meta_value' => $_GET['order'],
						'title'      => 'ASC',
					] );
				}
			}
		}
	);

}

/**
 * Remove type everywhere
 */

// Publication year for Articles, Books, Papers
$works          = [ 'articles', 'books', 'papers' ];

if ( is_admin() && 'edit.php' == $pagenow ) {

	// Below are some filters by post type:
	if (isset($_GET['post_type'])) {
		$post_type = $_GET['post_type'];

		// Add YEAR column where needed
		if ( in_array( $post_type, $works ) ) {
			wtvr_add_admin_column( 'Year', $post_type, function ( $post_id ) {
				$year = get_post_meta( $post_id, 'year', true );
				echo $year;
			} );


			if ( class_exists( 'ACF' ) ) {

				wtvr_add_admin_column( 'Files', $post_type, function ( $post_id ) {

					$count = 0;
					$files = get_field( 'wtvr_acf_post_files' );
					if ( is_array( $files ) ) {
						$count = count( $files );
					}
					echo $count;
				} );
			}
		}
	}

	// Remove post type & date columns in ACF post types for less clutter
	/*if ( in_array( $post_type, $acf_post_types ) ) {
		add_filter( 'manage_' . $post_type . '_posts_columns', function ( $columns ) {

			unset(
			  //$columns['date'],
			  $columns['post_type']
			);

			return $columns;
		}, 20 );
	}*/
}

/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action( 'restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy' );
function tsm_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'articles'; // change to your post type
	$taxonomy  = 'mark'; // change to your taxonomy
	if ( $typenow == $post_type ) {
		$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
		$info_taxonomy = get_taxonomy( $taxonomy );
		wp_dropdown_categories( array(
			'show_option_all'  => sprintf( __( 'Any %s', 'wtvr' ), $info_taxonomy->label ),
			'show_option_none' => sprintf( __( '%s not set', 'wtvr' ), $info_taxonomy->label ),
			'taxonomy'         => $taxonomy,
			'name'             => $taxonomy,
			'orderby'          => 'name',
			'selected'         => $selected,
			'show_count'       => false,
			'hide_empty'       => false,
		) );
	};
}

/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter( 'parse_query', 'tsm_convert_id_to_term_in_query' );
function tsm_convert_id_to_term_in_query( $query ) {
	global $pagenow;
	$post_type = 'articles'; // change to your post type
	$taxonomy  = 'mark'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
		$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
		$q_vars[ $taxonomy ] = $term->slug;
	}
}

// Register the column for modified date
function bf_post_modified_column_register( $columns ) {
	$columns['post_modified'] = __( 'Modified Date', 'mytextdomain' );
	return $columns;
}
add_filter( 'manage_edit-post_columns', 'bf_post_modified_column_register' );
add_filter( 'manage_edit-page_columns', 'bf_post_modified_column_register' );

// Display the modified date column content
function bf_post_modified_column_display( $column_name, $post_id ) {
	if ( 'post_modified' != $column_name ){
		return;
	}
	$post_modified = get_post_field('post_modified', $post_id);
	if ( !$post_modified ){
		$post_modified = '' . __( 'undefined', 'mytextdomain' ) . '';
	}
	echo $post_modified;
}
add_action( 'manage_posts_custom_column', 'bf_post_modified_column_display', 10, 2 );
add_action( 'manage_pages_custom_column', 'bf_post_modified_column_display', 10, 2 );

// Register the modified date column as sortable
function bf_post_modified_column_register_sortable( $columns ) {
	$columns['post_modified'] = 'post_modified';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'bf_post_modified_column_register_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'bf_post_modified_column_register_sortable' );