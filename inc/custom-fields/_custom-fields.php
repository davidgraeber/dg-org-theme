<?php
/**
 * Custom fields
 *
 * @package Whatever
 */

function wtvr_custom_fields() {

	// Check for ACF
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		// Post options
		require 'post-options.php';

		// Добавляем новый файл для шаблона страницы
		require 'page-template.php';

		// Post type options
		require 'custom-post-types.php';

		// Feature options
		require 'feature-options.php';

		// Relationships
		require 'relationships.php';

		// Bulk add posts
		require 'bulk-add-posts.php';

		// Language
		require 'language.php';

		// Cross-site connection
		require 'cross-site.php';

		// Cross-site connection
		require '_filters.php';

	}
}
add_action( 'init', 'wtvr_custom_fields',20);




