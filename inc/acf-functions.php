<?php
/**
 *
 * ACF - related functions
 *
 */

use Whatever\Cpt;

require 'acf-bulk-create.php';

/*
 * Get ACF-created option with multisite support
 *
 */
function wtvr_option($field){
    // Check if site is set to stop inheriting main site options

    if ( false /*get_field('site-custom-options', 'option')*/ ) {

        // In such case, get the options for the current site
        // Main site doesn't have the "site-custom-options" field, so it will fall back to this
        return get_field( $field, 'option' );

    } else {

         switch_to_blog(1);

        $value = get_field( $field, 'option' );

        restore_current_blog();

        return $value;

    }
}

/*
 * Bi-directional posts relations
 *
 * Updating "Related content" updates all related items
 * */
add_filter( 'acf/update_value/key=wtvr_acf_related_content', 'wtvr_acf_many_to_many', 10, 3 );
function wtvr_acf_many_to_many( $value, $post_id, $field ) {

	// vars
	$field_name  = $field['name'];
	$field_key   = $field['key'];
	$global_name = 'is_updating_' . $field_name;

	// bail early if this filter was triggered from the update_field() function called within the loop below
	// - this prevents an infinite loop
	if ( ! empty( $GLOBALS[ $global_name ] ) ) {
		return $value;
	}

	// set global variable to avoid infinite loop
	// - could also remove_filter() then add_filter() again, but this is simpler
	$GLOBALS[ $global_name ] = 1;

	// loop over selected posts and add this $post_id
	if ( is_array( $value ) ) {
		foreach ( $value as $post_id2 ) {

			// load existing related posts
			$value2 = get_field( $field_name, $post_id2, false );

			// allow for selected posts to not contain a value
			if ( empty( $value2 ) ) {
				$value2 = array();
			}

			// bail early if the current $post_id is already found in selected post's $value2
			if ( in_array( $post_id, $value2 ) ) {
				continue;
			}

			// append the current $post_id to the selected post's 'related_posts' value
			$value2[] = $post_id;

			// update the selected post's value (use field's key for performance)
			update_field( $field_key, $value2, $post_id2 );
		}
	}

	// find posts which have been removed
	$old_value = get_field( $field_name, $post_id, false );

	if ( is_array( $old_value ) ) {

		foreach ( $old_value as $post_id2 ) {

			// bail early if this value has not been removed
			if ( is_array( $value ) && in_array( $post_id2, $value ) ) {
				continue;
			}

			// load existing related posts
			$value2 = get_field( $field_name, $post_id2, false );

			// bail early if no value
			if ( empty( $value2 ) ) {
				continue;
			}

			// find the position of $post_id within $value2 so we can remove it
			$pos = array_search( $post_id, $value2 );

			// remove
			unset( $value2[ $pos ] );

			// update the un-selected post's value (use field's key for performance)
			update_field( $field_key, $value2, $post_id2 );
		}
	}

	// reset global varibale to allow this filter to function as per normal
	$GLOBALS[ $global_name ] = 0;

	// return
	return $value;
}

/*
 * Bi-directional crossite relations
 *
 * Updating "connected" updates all related items
 * */
add_filter( 'acf/update_value/key=wtvr_acf_cross_connection', 'wtvr_acf_reverse_connection', 10, 4 );
function wtvr_acf_reverse_connection( $value, $post_id, $field, $original ) {

	// vars
	$field_name  = $field['name'];
	$field_key   = $field['key'];
	$global_name = 'is_updating_' . $field_name;
	$blog_ID     = get_current_blog_id();

	if ( $blog_ID == 1 ) {
		$connected_blog_ID = 3;
	} elseif ( $blog_ID == 3 ) {
		$connected_blog_ID = 1;
	} else {
		return $value;
	}

	// bail early if this filter was triggered from the update_field() function called within the loop below
	// - this prevents an infinite loop
	if ( ! empty( $GLOBALS[ $global_name ] ) ) {
		return $value;
	}

	// set global variable to avoid infinite loop
	// - could also remove_filter() then add_filter() again, but this is simpler
	$GLOBALS[ $global_name ] = 1;


	// loop over selected posts and add this $post_id
	if ( is_numeric( $original ) ) {

		switch_to_blog( $connected_blog_ID );

		update_field( $field_key, false, $original );

		restore_current_blog();
	}

	// loop over selected posts and add this $post_id
	if ( is_numeric( $value ) ) {

		switch_to_blog( $connected_blog_ID );

		update_field( $field_key, $post_id, $value );

		restore_current_blog();
	}

	// reset global varibale to allow this filter to function as per normal
	$GLOBALS[ $global_name ] = 0;

	// return
	return $value;
}


/**
 * Add ACF options to nav menu
 */

add_filter( 'wp_nav_menu_objects', 'wtvr_wp_nav_menu_objects', 10, 1 );
function wtvr_wp_nav_menu_objects( $items ) {
	// loop
	foreach ( $items as $item ) {
		// disabled
		$disabled = get_field( 'disabled', $item );
		// append icon
		if ( $disabled ) {
			$item->classes[] .= 'disabled';
		}
	}

	// return
	return $items;
}


/*
 * Limit post types and disable drafts in 'Relatable' content
 * */
add_filter( 'acf/fields/relationship/query', 'wtvr_acf_relationship_filter', 10, 1 );

function wtvr_acf_relationship_filter( $options ) {

	// 1. Limit types
	// get 'custom types' + page, post
	$allowed_post_types = Cpt::list(['page', 'post', 'events']);
	// intersect filtered and allowed arrays
	$options['post_type'] = array_intersect( $allowed_post_types, $options['post_type'] );

    // 2. Disable drafts
	$options['post_status'] = array( 'publish' );

	return $options;
}

/**
 * Hide forbidden post types from filter
 */
add_action( 'acf/render_field/type=relationship', 'my_acf_render_field' );
function my_acf_render_field( $field ) {
	?>
    <style>
        <?php
		// get all types
		$all_post_types = get_post_types();
		// get 'custom types' + page, post
		$allowed_post_types = Cpt::list(['page', 'post', 'events']);
		// get types to hide (all types NOT IN allowed types)
		$hidden_PTs = array_diff($all_post_types, $allowed_post_types);
		// map post type slugs to css option rules
		$rules_array = array_map( function ( $hidden_PT ){
			return 'option[value="' . $hidden_PT . '"]';
		}, $hidden_PTs);
		// echo css rules list
		echo join(',', $rules_array);
		// render the rule itself after closing php tag
		?>
        {
            display: none;
        }
    </style>
	<?php
	return $field;
}

/**
 * Prepend post type to selected items
 * */
add_filter( 'acf/fields/relationship/result', 'wtvr_acf_fields_relationship_result', 10, 2 );
function wtvr_acf_fields_relationship_result( $text, $post ) {

	$post_type = get_post_type_object( $post->post_type );

	return $post_type->labels->singular_name . ': ' . $text;
}

