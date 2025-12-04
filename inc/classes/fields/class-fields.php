<?php

namespace Whatever;

class Fields {

	/**
	 * Get Locations option for a field including custom post types
	 *
	 * @param array $include
	 *
	 * @return Fields_Locations
	 */
	public static function get_locations( array $include = []): Fields_Locations {

		return new Fields_Locations($include);

	}

	/**
	 * Get hierarchical taxonomy choices for a post type
	 *
	 * @param $post_type
	 *
	 * @return array
	 */
	public static function pt_hierarchy_taxonomy_choices($post_type) {

		// get a list of taxonomy slugs
		$taxonomies = get_field( $post_type . '-taxonomies', 'option' );

		// bail if nothing to work with
		if (!is_array($taxonomies) || empty($taxonomies)) return false;

		$choices = [];

		foreach ($taxonomies as $taxonomy){

			if ( isset( $taxonomy['plural'] ) && isset( $taxonomy['singular'] ) && $taxonomy['hierarchical'] ) {

				$taxonomy_slug = strtolower( $taxonomy['singular'] );

				$choices[$taxonomy_slug] =  $taxonomy['plural'];
			}

		}

		return $choices;
	}


}