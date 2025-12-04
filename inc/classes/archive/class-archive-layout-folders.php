<?php

namespace Whatever;


class Archive_Layout_Folders extends Archive_Layout {

	public function header(){

		echo '<p class="directory-route overtitle">';

		if (is_tax()) {

			echo sprintf(
			  '<a href="/%s">%s</a> / ',

			  $this->vars['post-type'],
			  str_replace( '-', ' ', ucwords( $this->vars['post-type'], '-' ) )

			);
		}

		$taxonomy = ( $this->vars['taxonomy'] ?? false );
		$term_id = ($this->vars['term_id'] ?? false);

		if ( !$term_id || 0 === $term_id || !$taxonomy ) return;

		echo get_term_parents_list($term_id, $taxonomy, [
	        'separator' => ' / ',
			'inclusive'=> false,
		]);

		echo '↓ </p>';

		parent::header();


	}

	// 'Folders' content
	public function content(){
		global $wp_query;

		echo '<ul class="directory-content">';

		// Check if paged and skip 'folders' otherwise
		$paged = isset($wp_query->query['paged']);

		if ( !$paged ) {

			// Check for 'folders' and skip otherwise
			$direct_children_terms = wtvr_direct_child_terms($this->vars['term_id'], $this->vars['taxonomy']);

			if ( is_array($direct_children_terms) ){

				// For each 'folder'
				foreach ( $direct_children_terms as $term ) {

					echo '<li class="directory">';

					// Build 'folder' line
					echo sprintf(

						'<div class="directory-title folder-title">
							%1$s <a href="%5$s" data-term="%4$s" class="folder-toggle">%2$s</a>%3$s
						</div>',

						wtvr_svg('folder'),
						$term->name,
						'<span class="directory-count">' . $term->count . '</span>',
						$term->term_id,
						get_term_link($term->term_id)

					);

					echo '</li>';

				}

			}

		}

		// Print 'files'
		while ( have_posts() ) :

			the_post();
			echo sprintf(
				'<li class="file"><div class="directory-title file-title">%1$s <span>%2$s</span></div></li>',
				wtvr_svg( 'book' ),
				get_the_title()
			);

		endwhile;



		echo '</ul>';

	}

}
