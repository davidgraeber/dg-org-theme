<?php
/**
 *
 * Hooks into theme templates
 * Plugins and Child themes can hook into templates instead of overriding them
 *
 * todo: document available theme hooks
 *
 */

/**
 * Helper function to turn get_posts query into an array of language codes
 */
function wtvr_posts_to_languages_array( $posts ) {

	// get language codes form contracts
	$translations = array_map( function ( $post ) {
		return get_field( 'content_language', $post->ID );
	}, $posts );

	// get site languages
	$languages = wtvr_get_language_choices();

	// filter out lang codes that are not within site languages
	$lang_array = array_filter( $translations, function ( $lang_code ) use ( $languages ) {
		return isset( $languages[ $lang_code ] );
	} );

	// remove repetitions
	$lang_array = array_unique( $lang_array );
	// turn lang codes into readable languages
	$lang_array = array_map( function ( $lang_code ) use ( $languages ) {
		return $languages[ $lang_code ];
	}, $lang_array );

	// sort alphabetically
	sort( $lang_array );

	return $lang_array;
}

/**
 *
 * Render translations list for a book/article page
 *
 */
add_action( 'wtvr_after_content', 'wtvr_current_item_translations' );

function wtvr_current_item_translations() {

	// Bail if not book ar article
	if ( ! is_singular( [ 'books' ] ) ) {
		return false;
	}

	// Bail if there's no connected item
	$connected_item = get_field( 'connection' );
	if ( ! $connected_item ) {
		return false;
	}

	// Else, go to Estate
	// switch_to_blog( 3 );

	// get contracts connected to the book
	$contracts = get_posts( [
	  'post_type'  => 'contracts',
	  'nopaging'   => true,
	  'meta_query' => [
		[
		  'key'     => 'related_content',
		  'value'   => '"' . $connected_item . '"',
		  'compare' => 'LIKE'
		],
	  ],
	] );

	// If there's contracts
	if ( count( $contracts ) > 0 ) {

		$lang_array = wtvr_posts_to_languages_array( $contracts );

		$lang_list = join( ', ', $lang_array );

		// OUTPUT message
		echo sprintf( '<div class="call-to-action">
							<p>This book is translated to: %1$s</p>
							<p>If you’re a publisher, please contact <a href="%2$s">%2$s</a></p>
							<p>If a translation’s missing from this list, fill the
							<a href="/feedback-form/">feedback form</a> and let us know!</p>
						</div>',
		  $lang_list,
		  'estate@davidgraeber.org'
		);

	}
	// Dont' forget to
	// restore_current_blog();

}

add_action( 'wtvr_translations_section_display', 'wtvr_translations_section' );
// add_action( 'wtvr_before_archive_title', 'wtvr_add_translations_section_to_books' );

function wtvr_add_translations_section_to_books() {

	if ( is_post_type_archive( 'books' ) ) {

		do_action( 'wtvr_translations_section_display' );
	}
}

/**
 * Получить все языки переводов из книг с их term_id
 */
function wtvr_get_books_translation_languages() {
	// Получаем все книги
	$books = get_posts( [
		'post_type'      => 'books',
		'posts_per_page' => -1,
		'fields'         => 'ids'
	] );

	$translation_languages = [];

	// Проходим по всем книгам и собираем языки переводов
	foreach ( $books as $book_id ) {
		$translations = get_field( 'translations', $book_id );
		
		if ( $translations && is_array( $translations ) ) {
			foreach ( $translations as $translation ) {
				if ( isset( $translation['language'] ) && is_array( $translation['language'] ) ) {
					foreach ( $translation['language'] as $language_term ) {
						if ( isset( $language_term->name ) && isset( $language_term->term_id ) ) {
							$translation_languages[ $language_term->name ] = $language_term->term_id;
						}
					}
				}
			}
		}
	}

	return $translation_languages;
}

function wtvr_translations_section() {

	// Получаем языки переводов из книг (название => term_id)
	$translation_languages = wtvr_get_books_translation_languages();

	// Получаем все доступные языки из таксономии
	$all_langs           = wtvr_get_language_choices();
	$lang_array_prepared = [];

	foreach ( $all_langs as $code => $name ) {
		$is_available = isset( $translation_languages[ $name ] );
		$lang_available = $is_available ? 'available' : 'unavailable';
		
		$lang_array_prepared[ $code ] = [
		  'name'      => $name,
		  'available' => $lang_available,
		  'term_id'   => $is_available ? $translation_languages[ $name ] : null,
		];
	}

	// OUTPUT message
	echo '<section class="language-showcase">';

	echo '<div class="">
			<p>David\'s work has been published in the highlighted languages.</p>
			<p>If you would like to publish David\'s work in your language please <a href="mailto:info@davidgraeber.org">contact us</a></p>
			
		</div>';

	echo '<div class="showcase-options">';

	foreach ( $lang_array_prepared as $code => $lang ) {
		if ( $lang['available'] === 'available' && $lang['term_id'] ) {
			// Создаем ссылку для доступных языков
			$books_url = get_post_type_archive_link( 'books' );
			$filter_url = add_query_arg( 'book_language', $lang['term_id'], $books_url );
			
			echo sprintf( '<a href="%3$s" class="showcase-option %1$s">%2$s</a> ',
				$lang['available'],
				$lang['name'],
				esc_url( $filter_url )
			);
		} else {
			// Обычный span для недоступных языков
			echo sprintf( '<span class="showcase-option %1$s">%2$s</span> ',
				$lang['available'],
				$lang['name']
			);
		}
	}
	echo '</div>';
	

	echo '</section>';
}
