<?php

/**
 *
 * Readonly fields
 *
 */

function wtvr_readonly_fields( $field ) {
	$field['disabled'] = 1;

	return $field;
}

// Apply to table_id filed
add_filter( 'acf/load_field/name=table_id', 'wtvr_readonly_fields' );



/**
 *
 * Post-type-dependant filters
 *
 */

function wtvr_default_columns( $post_type ) {
	return [
		[
			'wtvr_acf_' . $post_type . '_archive_col_type'  => 'default',
			'wtvr_acf_' . $post_type . '_archive_col_field' => 'post_title',
			'wtvr_acf_' . $post_type . '_archive_col_title' => 'Title',
			'wtvr_acf_' . $post_type . '_archive_col_width' => 1,
		]
	];
}

use Whatever\Fields;

if ( $cpts = get_field( 'cpts', 'option' ) ) {

	if (is_array($cpts)) {

		$cpt_fields = [];

		foreach ( $cpts as $cpt ) {

			/**
			 *
			 * Default table archive columns
			 *
			 */


			$plural_name = $cpt['plural_name'];
			$slug        = sanitize_title( $plural_name );

			add_filter(
				'acf/load_value/key=wtvr_acf_' . $slug . '_archive_columns',
				function ( $value) use ( $slug ) {

				if ( $value === false ) {
					$value = wtvr_default_columns( $slug );
				}

				return $value;
			}, 99 );

			/**
			 * Populate taxonomy options
			 *
			 */

			add_filter(
				'acf/load_field/key=wtvr_acf_' . $slug . '_folder_taxonomy',
				function ( $field ) use ($slug) {

				$field['choices'] = Fields::pt_hierarchy_taxonomy_choices($slug);

				// return the field
				return $field;

			});

		}
	}
}
