<?php

/**
 *
 * Archive constructor and preparer
 *
 */

namespace Whatever;

class Archive {

	public function __construct(){

		global $wpdb;
		global $wp_query;

		$vars = [];

		// check if archive/taxonomy
		if ( !(is_tax() || is_post_type_archive()) ){
			echo '[Error: this is not an archive]';
			return;
		}

		// get definitive post type
		if ( is_tax() ){

			// for taxonomies:
			$vars['taxonomy'] = $wp_query->get_queried_object()->taxonomy ?? false;

			// find post type the taxonomy is connected to
			$option_query = "SELECT `option_name` FROM $wpdb->options
			WHERE `option_value` = 'shelf' AND `option_name` LIKE '%-folder-taxonomy'";
			// check if it is folder

			$result = $wpdb->get_row( $option_query )->option_name;

			if (is_string($result)) {
				// cut 'option_'
				$post_type_candidate = substr($result, 8);
				// cut '-folder-taxonomy'
				$post_type_candidate  = substr($post_type_candidate, 0, -16);

				// double check this is a folder archive;

				$archive_layout = get_field($post_type_candidate . '-archive-layout', 'option');

				if ('folders' === $archive_layout){
					$vars['layout'] = 'folders';
					$vars['post-type'] = $post_type_candidate;
					$vars['term_id']  = $wp_query->get_queried_object()->term_id;
				}

			}

		} else {

			$vars['post-type'] = get_queried_object()->name;

			$vars['layout'] = get_field($vars['post-type'] . '-archive-layout', 'option');

			if ('folders' === $vars['layout']){

				$vars['taxonomy'] = get_field($vars['post-type'] . '-folder-taxonomy', 'option');
				$vars['term_id'] = 0;

				if (!isset($vars['post-type']) || !isset($vars['taxonomy'])){
					echo '<i>Please connect post type and taxonomy in content type options</i>';
					return;
				}

			}

		}

		$classname = 'Whatever\\Archive_Layout_' . ucfirst(Archive_Layout::$choices[$vars['layout']]);

		$archive = new $classname($vars);

		$archive->render();
	}





}
