<?php


function wtvr_taxonomies() {

	register_taxonomy(
	  'language',
	  array('reviews', 'articles', 'papers', 'interviews', 'videos', 'audios', 'press', 'memorials', 'projects', 'unpublished'),
	  array(
		'hierarchical' => true,
		'labels'       => [
		  'name'              => 'Languages',
		  'singular_name'     => 'Language',
		  'search_items'      => 'Search Languages',
		  'all_items'         => 'All Languages',
		  'view_item '        => 'View Language',
		  'parent_item'       => 'Parent Language',
		  'parent_item_colon' => 'Parent Language:',
		  'edit_item'         => 'Edit Language',
		  'update_item'       => 'Update Language',
		  'add_new_item'      => 'Add New Language',
		  'new_item_name'     => 'New Language Name',
		  'menu_name'         => 'Languages',
		],
		'show_admin_column' => true,
		'query_var'    => true,
		'rewrite'      => false,
		'show_ui' => true,
		'meta_box_cb' => false,
	  )
	);

}

add_action( 'init', 'wtvr_taxonomies');
