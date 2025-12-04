<?php

namespace Whatever;

/**
 * Custom post types tools
 */
class Cpt {

	/// wtvr_get_acf_cpts

	/**
	 * Returns array of custom post types. Slugs or objects.
	 *
	 * @param array $include Array of pre-included Post Types
	 * @param string $objects Return format. True (Default) for slugs
	 *
	 * @return mixed Array of custom post type slugs or objects
	 */

	public static function list( array $include = [] , bool $objects = false ) {

		// If custom post types are created
		$cpts = get_field( 'cpts', 'option' );

		if ( is_array($cpts) ) {
			// add all cpt plural names as slug to output array
			foreach ($cpts as $cpt){
				$include[] = sanitize_title( $cpt['plural_name'] );
			}
		}

		// Return either slugs or post type objects
		if ( !$objects) {
			$cpts = $include;
		} else {
			$cpts = array_map( function ($cpt_slug){
				return get_post_type_object( $cpt_slug );
			}, $include );
		}

		return $cpts;
	}

	/**
	 * Add default types (and events) to the list
	 *
	 * @return array|mixed
	 */
	public static function list_include_default( array $include = [] ) {

		$include_complete = array_merge(
			$include,
			[ 'page', 'post', 'events' ]
		);

		return self::list( $include_complete );
	}

}