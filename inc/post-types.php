<?php
/**
 * Custom post types and related functions
 *
 * Whatever Theme follows horizontal structure for many types of content.
 * Post type groups are used to create a fake hierarchy level for easier navigation.
 *
 * @package Whatever
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get related functions
 *
 */
require get_template_directory() . '/inc/post-types-functions.php';

/**
 * Add an admin menu page for custom post types
 */
add_action( 'admin_menu', 'wtvr_post_type_menus' );

function wtvr_post_type_menus() {
	add_menu_page(
	  'Content', 'Content', 'read', 'custom-content.php', 'wtvr_cpt_page', 'dashicons-media-default', 4
	);
}

/**
 * Render when there's no subpages (no custom post types) in the Content menu
 *
 */

function wtvr_cpt_page() {
	echo '<h1>' . esc_html__( 'Custom content types', 'wtvr' ) . '</h1>';
	echo '<p>'
	     . esc_html__( 'There seems to be no custom content types yet.', 'wtvr' )
	     . '</p>';
}

/**
 * Add ACF options pages for CPTs
 */
add_action( 'acf/init', 'wtvr_acf_cpt_options_init' );

function wtvr_acf_cpt_options_init() {

	// Check function exists.
	if ( function_exists( 'acf_add_options_sub_page' ) ) {

		// Add cpt creation and management
		acf_add_options_sub_page( [
		  'page_title'  => 'Edit & Customize content types',
		  'menu_title'  => '[ Edit & Customize ]',
		  'parent_slug' => 'custom-content.php',
		  'capability'  => 'customize'
		] );

		if ( is_super_admin() ) {
			acf_add_options_sub_page( [
			  'page_title'  => 'Bulk add content',
			  'menu_title'  => 'Bulk add content',
			  'parent_slug' => 'custom-content.php',
			  'capability'  => 'customize'
			] );

		}
	}
}

/**
 * Setup content types on the options page
 */

add_action( 'acf/init', 'wtvr_acf_add_cpt_field_group' );

function wtvr_acf_add_cpt_field_group() {
	if ( function_exists( 'acf_add_local_field_group' ) ) {

		acf_add_local_field_group( [
		  'key'      => 'wtvr_acf_cpt_setup',
		  'title'    => 'Content types',
		  'fields'   => [

			// The CPTs repeater
			[
			  'key'          => 'wtvr_acf_cpt_setup_cpts',
			  'label'        => 'Add content types',
			  'name'         => 'cpts',
			  'type'         => 'repeater',
			  'instructions' => '<p style="color: red;">Be extremely careful.
								Do not delete or rename types that have content.</p>
								<p> Do not add too many types.</p>',
			  'collapsed'    => 'wtvr_acf_cpt_setup_plural_name',
			  'layout'       => 'table',
			  'button_label' => 'Add content type',
			  'sub_fields'   => [
				[ // Plural name
				  'key'          => 'wtvr_acf_cpt_setup_plural_name',
				  'label'        => 'Plural name',
				  'name'         => 'plural_name',
				  'instructions' => get_home_url() . '/<u><b>books</b></u>/a-great-book',
				  'type'         => 'text',
				  'required'     => 1,
				  'wrapper'      => [
					'width' => '50',
					'class' => 'wtvr_acf_cpt_setup_plural_name',
					'id'    => '',
				  ],
				  'placeholder'  => 'Books',
				  'maxlength'    => 22,
				],
				[ // Singular name
				  'key'         => 'wtvr_acf_cpt_setup_singular_name',
				  'label'       => 'Singular name',
				  'name'        => 'singular_name',
				  'type'        => 'text',
				  'required'    => 1,
				  'wrapper'     => [
					'width' => '50',
					'class' => 'wtvr_acf_cpt_setup_singular_name',
					'id'    => '',
				  ],
				  'placeholder' => 'Book',
				  'maxlength'   => 22,
				],
			  ],

		    ],

		  ],
		  'location' => [
			[
			  [
				'param'    => 'options_page',
				'operator' => '==',
				'value'    => 'acf-options-edit-customize',
			  ],
			],
		  ],
		] );

	}
}

/**
 * Create custom post types from ACF
 */
add_action( 'acf/init', 'wtvr_acf_post_types' , 10 );

function wtvr_acf_post_types() {

	// Get the types


	$GLOBALS['cpts'] = get_field( 'cpts', 'option' );

	if ( is_array($GLOBALS['cpts']) ) {

		$i = 0;

		foreach ( $GLOBALS['cpts'] as $cpt ) {

			// Re-check if all required fields are set
			if ( isset( $cpt['plural_name'] ) && isset( $cpt['singular_name'] ) ) {

				// Turn plural name into slug
				$plural_name   = $cpt['plural_name'];
				$slug = strtolower( sanitize_title( $plural_name ) );
				$slug_singular = strtolower( sanitize_title( $cpt['singular_name'] ) );

				$GLOBALS['cpts'][$i]['slug'] = $slug;
				$GLOBALS['cpts'][$i]['slug_singular'] = $slug_singular;

				// Skip if post type exists OR the slug is a reserved WP name
				if ( post_type_exists( $slug ) || wtvr_is_reserved( $slug ) ) continue;

				// Prepare capabilities
				$capabilities = [
				  'edit_post'          => 'edit_' . $slug_singular,
				  'edit_posts'         => 'edit_' . $slug,
				  'edit_others_posts'  => 'edit_other_' . $slug,
				  'publish_posts'      => 'publish_' . $slug,
				  'read_post'          => 'read_' . $slug_singular,
				  'read_private_posts' => 'read_private_' . $slug,
				  'delete_post'        => 'delete_' . $slug_singular,
				  'create_posts'       => 'create_' . $slug,
				];

				// Register!
				register_post_type( $slug,
				  [
					'labels'          => [ // todo make translatable
					  'name'               => $cpt['plural_name'],
					  'singular_name'      => $cpt['singular_name'],
					  'add_new_item'       => $plural_name . ' | Add a new item',
					  'edit_item'          => $cpt['singular_name'] . ' | Edit item',
					  'new_item'           => $cpt['singular_name'] . ' | New item',
					  'view_item'          => $cpt['singular_name'] . ' | View item',
					  'search_items'       => $plural_name . ' | Search items',
					  'not_found'          => $plural_name . ' | No items found',
					  'not_found_in_trash' => $plural_name . ' | No items found in trash'
					],
					'capabilities'    => $capabilities,
					'capability_type' => [ $slug_singular, $slug_singular ],
					'public'          => true,
					'supports'        => [ 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'author' ],
					'show_in_menu'    => 'custom-content.php',
					'show_in_rest'    => true,
					'menu_position'   => 20,
					'has_archive'     => true
				  ]
				);

				$admins  = get_role( 'administrator' );
				$editors = get_role( 'editor' );

				$role_slug = $slug . '_moderator';
				$role_name = $plural_name . ' Moderator';
				if ( ! $GLOBALS['wp_roles']->is_role( $role_slug ) ) {
					$subscribers = get_role( 'subscriber' );
					add_role( $role_slug, $role_name, $subscribers->capabilities );
				}

				$cpt_editors = get_role( $role_slug );

				foreach ( $capabilities as $default_cap => $cpt_cap ) {
					if ($admins) {
						$admins->add_cap( $cpt_cap );
					}
					if ($editors) {
						$editors->add_cap( $cpt_cap );
					}
					if ($cpt_editors) {
						$cpt_editors->add_cap( $cpt_cap );
					}
				}
			} // if plural & singular names are set

			$i++;
		} // each custom post type


		// Flush permalinks to enable pretty links
		flush_rewrite_rules();
	}
}

