<?php
/**
 * Add ACF theme options pages
 */
add_action( 'acf/init', 'wtvr_acf_option_pages' );

function wtvr_acf_option_pages() {

	// Check function exists.
	if ( function_exists( 'acf_add_options_sub_page' ) ) {


		// Theme Options
		acf_add_options_sub_page( [
		  'page_title'  => 'Theme Options',
		  'menu_title'  => 'Theme Options',
		  'parent_slug' => 'themes.php',
		  'capability'  => 'customize'
		] );

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
