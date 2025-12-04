<?php

if (1 === get_current_blog_id() ) {
	$role_adm = current_user_can( 'edit_others_posts' ); // todo remove


	if ( $role_adm && ! function_exists( 'wtvr_add_admin_menu' ) && ! function_exists( 'wtvr_display_admin_page' ) ) {

		function wtvr_add_admin_menus() {

			/*
			 * Languages
			 */

			# Settings for languages menu
			$page_title = 'Languages';
			$menu_title = 'Languages';
			$capability = 'post';
			$menu_slug  = 'edit-tags.php?taxonomy=language';
			$icon_url   = 'dashicons-translation';
			$position   = 6;

			# Add custom admin menu

			add_menu_page( $page_title, $menu_title, $capability, $menu_slug, null, $icon_url, $position );

			restore_current_blog();
		}

		add_action( 'admin_menu', 'wtvr_add_admin_menus', 1 );

	}
}
