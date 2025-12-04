<?php
/*
 * Custom actions on post save
 * */

/**
 * Saves data to a log file.
 *
 * @param mixed $data The data to be saved.
 * @param string $type The type of data being saved.
 * @return void
 */
 function save_data_to_log( $data, $type ) {
    $log_file = ('success' == $type) ? '/success_import.log' : '/fail_import.log';

    // format data
    $formatted_data = date( 'Y-m-d H:i:s' ) . ' - ' . $data . PHP_EOL;

    // Adding data to the log file
    file_put_contents( WP_CONTENT_DIR . $log_file, $formatted_data, FILE_APPEND );
}

/**
 * Update the specified fields in the database.
 *
 * @param object $query The query object.
 * @param array $data_arr An array of data.
 * @param string $data_key The key of the data.
 * @throws Exception
 * @return void
 */
function update_empty_fields( $query, $data_arr, $current_data_key) {
	$post_id = $query->posts[0]->ID;
	$post_title = $query->posts[0]->post_title;
	$meta_key_arr = [
		'subtitle' => 'subtitle',
		'summary' => 'summary',
		'post-attachments_external-author_external-author-name' => 'external-author-name',
		'post-attachments_external-author_external-author-link' => 'external-author-link'
	];
	$meta_fields = get_post_meta( $post_id );
	$updated_fields = '';
	foreach ( $meta_key_arr as $meta_key => $data_key ) {
		if ( empty( $meta_fields[ $meta_key ][0] )  && array_key_exists( $data_key, $data_arr ) ) {
			$result = update_post_meta( $post_id, $meta_key, wp_slash( $data_arr[ $data_key ] ));
			$updated_fields = ( $result ) ? $updated_fields . $data_key . ', ' : $updated_fields;
		}
	}
	$data = "Duplicated {$current_data_key} | base title: {$post_title} | import title: {$data_arr[ 'title' ]} | updated fields: {$updated_fields}";
	save_data_to_log( $data, 'fail' );
}

 /**
  * Checks if a post is duplicated based on the given parameters.
  *
  * @param string $post_type The post type to check against.
  * @param array $data_arr An array of data.
  * @param string $meta_key The meta key to compare.
  * @param string $data_key The data key to use for comparison.
  * @return bool Returns false if the post is not duplicated, true otherwise.
  */
 function is_duplicated_post( $post_type, array $data_arr, $meta_key, $data_key) {
	if ( !isset( $data_arr[ $data_key ] ) || !isset( $data_arr[ 'books' ] )) {
		return false;
	}

	$args = [
		'post_type' => $post_type,
		'meta_query' => [
			[
				'key' => $meta_key,
				'value' => $data_arr[ $data_key ],
			],
		]
	];

	// add current book to query with author name
	if ( 'external-author-name' == $data_key ){
		$get_book = new WP_Query([
			'post_type'   => 'books',
			'title'       => $data_arr[ 'books' ]
		] );
		$book_id_int = $get_book->posts[0]->ID;
		$book_id_str= strval($book_id_int);
		$args['meta_query'][1] = array(
			'key' => 'related_content',
			'value' => serialize([$book_id_str])
		);
	}
	$query = new WP_Query( $args );	
	// update empty fields & log data
	if ($query->have_posts()){
		update_empty_fields($query, $data_arr, $data_key);
		return true;
	}

	return $query->have_posts();
 }

add_action( 'acf/save_post', 'wtvr_acf_save_post' );
function wtvr_acf_save_post( $post_id ) {

	/**
	 * Bulk create post
	 */

	if ( is_admin() ) {

		$screen = get_current_screen();
		// if on BULK option page
		if ( strpos( $screen->id, "acf-options-bulk-add" ) == true ) {

			$bulk_post_type = get_field( 'bulk_post_type', 'option' );
			$bulk_post_source = get_field( 'bulk_posts_source', 'option' );
			$bulk_posts      = get_field( 'bulk_posts', 'option' );
			$bulk_posts_json = get_field( 'bulk_posts_json', 'option' );

			if ( ! $bulk_posts && ! $bulk_posts_json ) {
				return false;
			}

			if ( post_type_exists( $bulk_post_type ) && 'json' === $bulk_post_source && $bulk_posts_json ) {
				$bulk_posts = json_decode( trim( $bulk_posts_json ), true );
			}

			foreach ( $bulk_posts as $bulk_post ) {
				$row = [];
				foreach ($bulk_post as $column_key => $value){
					$row[strtolower($column_key)] = kstshn_empty_or_else( $bulk_post[$column_key] );
				}

				// check for duplicated posts
				$duplicated_link = is_duplicated_post($bulk_post_type, $row, 'post-attachments_external-link', 'external-link');
				$duplicated_author_and_book = false;
				if ( ! $duplicated_link ){
					$duplicated_author_and_book = is_duplicated_post($bulk_post_type, $row, 'post-attachments_external-author_external-author-name', 'external-author-name');
				}
				
				if ( false == $duplicated_link && false == $duplicated_author_and_book ) {
					// INSERT POST
					$bulk_id = wp_insert_post( [
						'post_type'   => $bulk_post_type,
						'post_title'  => $row['title'],
						'post_status' => 'draft',
					] );
					
					if ( isset( $bulk_id ) ) {
						// DEAL WITH EASY COLUMNS
						$str_columns = [
							'subtitle',
							'summary',
						];

						foreach ( $str_columns as $str_column ) {
							if (isset( $row[ $str_column ])) {
								update_field( $str_column, $row[ $str_column ], $bulk_id );
							}
						}


						if (isset( $row[ 'external-link' ])) {
							update_field( 'post-attachments', [ 'external-link' => $row[ 'external-link' ] ], $bulk_id );
						}


						if (isset( $row[ 'external-author-name' ] )) {
							update_field( 'post-attachments', [
								'external-author' => [
									'external-author-name' => $row[ 'external-author-name'],
								]
							], $bulk_id );
						}


						if (isset( $row[ 'external-author-link' ] )) {
							update_field( 'post-attachments', [
								'external-author' => [
									'external-author-link' => $row[ 'external-author-link'],
								]
							], $bulk_id );
						}

						// save imported data to log
						$data = $row[ 'title' ];
						save_data_to_log( $data, 'success' );
						
						// RELATABLE POST TYPES

						$r_on = 1;

						if ($r_on) {

							$relateables = [
								'books'   => false,
								'people'  => false
							];
							foreach ( $relateables as $relateable_type => $relateable_ID ) { //books => []


								if ( isset( $row[$relateable_type] )) { // 'Bullshit Jobs'

									// post_id / NULL
									//$exist_relatable = get_page_by_title( $row[ $relateable_type ], OBJECT, $relateable_type );
									$exist_relatable = get_posts([
										'post_type'   => $relateable_type,
										'title'       => $row[ $relateable_type ]
									] );
									if ( $exist_relatable ){
										$relateables[ $relateable_type ] = ( $exist_relatable[0] ) ? $exist_relatable[0]->ID : false;
									}
									/* // object doesn't exists
									if ( $exist_relatable === null ) {

										// push into array
										$relateables[ $relateable_type ] = wp_insert_post( [
											'post_title'  => $row[ $relateable_type ],
											'post_type'   => $relateable_type,
											'post_status' => 'publish',
										] );


									} elseif ( is_object( $exist_relatable ) ) { //object exists
										$relateables[ $relateable_type ] = $exist_relatable->ID;
									} */
								}
							}

							foreach ( $relateables as $relateable_type => $relateable_ID ) {
								if ( false !== $relateable_ID ) {

									// load existing related objects
									$related_IDs = get_field( 'related_content', $bulk_id, false );

									// allow for selected posts to not contain a value
									if ( empty( $related_IDs ) ) {
										$related_IDs = [];
									}

									// bail early if the current $post_id is already found in selected post's $value2
									if ( ! in_array( $relateable_ID, $related_IDs ) ) {

										// append the current $post_id to the selected post's 'related_posts' value
										$related_IDs[] = $relateable_ID;

										// update the selected post's value (use field's key for performance)
										update_field( 'related_content', $related_IDs, $bulk_id );
									}

									// LINK ALBUM TO ARTIST (ONCE)
									/* if ( 'albums' === $relateable_type ) {

										$albm_str_columns = [
											'genre',
											'track_count',
											'year',
										];

										foreach ( $albm_str_columns as $str_column ) {
											if ( isset( $row[ $str_column ] ) ) {
												update_field( $str_column, $row[ $str_column ], $bulk_id );
											}
										}

										$artist_id          = $relateables['artists'];
										$artist_related_IDs = get_field( 'related_content', $artist_id, false );

										// allow for selected posts to not contain a value
										if ( empty( $related_IDs ) ) {
											$artist_related_IDs = [];
										}

										// bail early if the current $post_id is already found in selected post's $value2
										if ( ! in_array( $relateable_ID, $artist_related_IDs ) ) {

											// append the current $post_id to the selected post's 'related_posts' value
											$artist_related_IDs[] = $relateable_ID;

											// update the selected post's value (use field's key for performance)
											update_field( 'related_content', $artist_related_IDs, $artist_id );
										}

									} */
								}
							}
						}
					}

					unset($bulk_id, $row, $bulk_post);
				}
			}
			delete_field( 'bulk_post_type', 'option' );
			delete_field( 'bulk_posts_source', 'option' );
			delete_field( 'bulk_posts_json', 'option' );
			delete_field( 'bulk_posts', 'option' );

		}
	}
}