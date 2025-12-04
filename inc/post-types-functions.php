<?php
/**
 * Custom post types functions
 *
 * @package Whatever
 */

/**
 * ACF dependant:
 */
if ( function_exists( 'acf_add_local_field_group' ) ) {




	/**
	 * Custom archive sorting and count
	 */

	function wtvr_custom_archive_sorting( $query ) {



		if (is_admin() ) return;

		$post_type = $query->get( 'post_type' );

		if ('wp_global_styles' === $post_type) return;

		if ('' === $post_type && isset($query->tax_query) ) {

			$post_types = [];

			foreach ($query->tax_query->queried_terms as $taxonomy_slug => $term_query){

				$taxonomy = get_taxonomy( $taxonomy_slug );

				$post_types = array_merge($post_types, $taxonomy->object_type);
			}

			if ( 1 === count($post_types) ) $post_type = $post_types[0];

		}

		if ( ! isset($post_type) || '' === $post_type) return;

		// SORTING

		if (is_string($post_type)){

			$sorting = get_field( 'wtvr_acf_' . $post_type . '_archive_sorting', 'option' );

			if ( is_string( $sorting ) ) {

				switch ( $sorting ) {

					case 'title' :
						$query->set( 'order', 'ASC' );
						$query->set( 'orderby', 'title' );
						break;

					case 'subtitle' :
						$query->set( 'order', 'ASC' );
						$query->set( 'meta_key', 'subtitle' );
						$query->set( 'orderby', 'meta_value' );
						break;

				}
			}

			// COUNT

			$count = get_field( 'wtvr_acf_' . $post_type . '_archive_per_page', 'option' );

			if ( $count !== 'default' ) {
				$query->set( 'posts_per_page', $count );
			}
		}






	}

	add_action( 'pre_get_posts', 'wtvr_custom_archive_sorting', 99 );

	function acf_load_main_site_posts_selector( $field ) {
		// Populate choices with posts of same post type from main site
		$field['choices'] = wtvr_get_main_site_content( get_post_type() );

		// return the field
		return $field;

	}

	add_filter( 'acf/load_field/key=wtvr_acf_cross_connection', 'acf_load_main_site_posts_selector' );


} // ends ACF dependant stuff

