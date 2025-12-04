<?php
/**
 * Customization of the theme
 *
 * @package Whatever
 */


/**
 * Add ACF theme options pages
 */
add_action( 'acf/init', 'wtvr_acf_theme_options' );

function wtvr_acf_theme_options() {

	// Check function exists.
	if ( function_exists( 'acf_add_options_sub_page' ) ) {

		// Add cpt creation and management
		acf_add_options_sub_page( [
		  'page_title'  => 'Theme Options',
		  'menu_title'  => 'Theme Options',
		  'parent_slug' => 'themes.php',
		  'capability'  => 'customize'
		] );
	}
}


if ( function_exists( 'acf_add_local_field_group' ) ):
	/**
	 * FOOTER
	 */

	acf_add_local_field_group( [
	  'key'                   => 'wtvr_acf_theme_options_group',
	  'title'                 => 'General Meta',
	  'fields'                => [

	  ],

	  'location'              => [
	    [
		  [
		    'param'    => 'options_page',
		    'operator' => '==',
		    'value'    => 'acf-options-theme-options',
		  ],
	    ],
	  ],
	  'menu_order'            => 0,
	  'position'              => 'acf_after_title',
	  'style'                 => 'seamless',
	  'label_placement'       => 'top',
	  'instruction_placement' => 'label',
	  'hide_on_screen'        => [
		'excerpt',
		'page_attributes'
	  ],
	  'active'                => true,
	  'description'           => '',
	] );

endif;