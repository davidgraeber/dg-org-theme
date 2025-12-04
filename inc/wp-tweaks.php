<?php
/**
 * Wordpress tweaks
 *
 * @package Whatever
 */

/*
 *
 * Disable gutenberg
 *
 * */
add_filter('use_block_editor_for_post_type', '__return_false', 100);

/**
 * Remove WordPress logo from admin bar
 */
add_action( 'wp_before_admin_bar_render', function () {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
}, 0 );

/**
 * Disable WordPress Events and News widget from the dashboard.
 */
function wtvr_wp_tweak_n_remove() {
	remove_meta_box( 'dashboard_primary', get_current_screen(), 'side' );
}
add_action( 'wp_network_dashboard_setup', 'wtvr_wp_tweak_n_remove', 20 );
add_action( 'wp_user_dashboard_setup',    'wtvr_wp_tweak_n_remove', 20 );
add_action( 'wp_dashboard_setup',         'wtvr_wp_tweak_n_remove', 20 );



/**
 * Remove archive labels.
 *
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
add_filter( 'get_the_archive_title', function ( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}
	return $title;
} );


/**
 * Add classes for parent menu items of current singular pages (by post type)
 */
add_filter( 'wp_nav_menu_objects', 'wtvr_menu_ancestry_classes', 10, 1 );

function wtvr_menu_ancestry_classes ( $items ) {
	if ( is_singular() ) {

		// Get post type of current page
		$p_t = get_post_type();

		// Bin for all parent items
		$parents = [];

		// Go through $items, getting index
		foreach ( $items as $menu_index => $item ) {

			// Case 1:
			// For parent menu items
			if ( in_array( 'menu-item-has-children', $item->classes ) ) {
				// Put menu index in parents bin under menu item ID
				$parents[ $item->ID ] = $menu_index;
			}

			// Case 2:
			// For child items (actual post type archives)
			$p_t_archive = in_array( 'menu-item-type-post_type_archive', $item->classes );

			if ( $p_t_archive ) {
				// if menu item is CURRENT item's archive
				if ( in_array( 'menu-item-object-' . $p_t, $item->classes ) ) {

					// set as current menu item (1st level)
					array_push( $item->classes, 'current-menu-item' );
					// set parent as current ancestor (2ns level)
					if ( array_key_exists( $item->menu_item_parent, $parents ) ) {
						$parent_item_key = $parents[ $item->menu_item_parent ];
						$items[ $parent_item_key ]->classes[] = 'current-menu-ancestor';
					}
				}
			}
		}
	}

	return $items;
}



/**
 * Disable comments
 */

add_action('admin_init', function () {
	// Redirect any user trying to access comments page
	global $pagenow;

	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}

	// Remove comments metabox from dashboard
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

	// Disable support for comments and trackbacks in post types
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
});


/**
 * Add class to archive navigation links for Masonry
 */
add_filter('next_posts_link_attributes', function () {
	return 'class="next-posts"';
});


function wtvr_mce_buttons_2($buttons) {
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'sup';
	$buttons[] = 'sub';

	return $buttons;
}
add_filter('mce_buttons_2', 'wtvr_mce_buttons_2');
