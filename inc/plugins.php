<?php
/**
 * This file represents the code that themes would use to register
 * the required plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Whatever
 * @version    2.6.1 for parent theme Whatever
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'wtvr_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function wtvr_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = [

		// Advanced Custom Fields (included in theme files)
		[
			'name'               => 'Advanced Custom Fields Pro',
			'slug'               => 'advanced-custom-fields-pro',
			'source'             => get_template_directory() . '/inc/plugins/advanced-custom-fields-pro.zip',
			'required'           => true,
			'version'            => '5.9.5',
			'force_activation'   => true,
			'force_deactivation' => false,
		],
		[
			'name'               => 'Simple Custom Post Order',
			'slug'               => 'simple-custom-post-order',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		],
	];

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 */
	$config = [
		'id'           => 'wtvr',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => false,
		'is_automatic' => true,
	];

	tgmpa( $plugins, $config );
}
