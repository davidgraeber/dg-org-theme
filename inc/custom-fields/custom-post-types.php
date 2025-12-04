<?php

/**
 * CPT Options custom fields
 */

use Whatever\Archive_Layout;

$cpts = get_field( 'cpts', 'option' );

if ( is_array($cpts) ) {

	$post_type_tabs = [];

	foreach ( $cpts as $cpt ) {

		$plural_name = $cpt['plural_name'];
		$slug        = sanitize_title( $plural_name );

		$post_type_tab = [
			// CPT OPTIONS TAB --- OPEN POINT
			[
				'key'      => 'wtvr_acf_' . $slug . '_options_tab',
				'label'    => $plural_name,
				'type'     => 'tab',
				'endpoint' => 0,
			],
			// Basic settings ---
			[
				'key' => 'wtvr_acf_' . $slug . '_basic_accordion',
				'label' => 'Basic settings',
				'type' => 'accordion',
				'instructions' => '',
				'open' => 1,
				'multi_expand' => 1,
				'endpoint' => 0,
			],
			// CPT Description
			[
				'key'          => 'wtvr_acf_' . $slug . '_description',
				'label'        => 'Description',
				'name'         => $slug . '-description',
				'type'         => 'wysiwyg',
				'instructions' => '',
				'wrapper'      => [
					'width' => '50',
					'class' => 'wtvr_acf_cpt_setup_plural_name',
					'id'    => '',
				],
				'tabs'         => 'visual',
				'toolbar'      => 'basic',
				'media_upload' => 0,
				'delay'        => 1,
			],
			// CPT Gallery
			[
				'key'           => 'wtvr_acf_' . $slug . '_gallery',
				'label'         => 'Gallery',
				'name'          => $slug . '-gallery',
				'type'          => 'gallery',
				'instructions'  => '',
				'wrapper'       => [
					'width' => '50',
					'class' => 'wtvr_acf_cpt_setup_galery',
					'id'    => '',
				],
				'return_format' => 'id',
				'min'           => '',
				'max'           => '',
			],

			// Advanced settings ---
			[
				'key' => 'wtvr_acf_' . $slug . '_advanced_accordion',
				'label' => 'Advanced settings',
				'type' => 'accordion',
				'instructions' => '',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			],
			// CPT Archive layout
			[
				'key'           => 'wtvr_acf_' . $slug . '_archive_layout',
				'label'         => 'Show as',
				'name'          => $slug . '-archive-layout',
				'type'          => 'select',
				'wrapper'       => [
					'width' => '20',
					'class' => 'wtvr_acf_cpt_setup_layout',
				],
				'choices'       => Archive_Layout::choices(),
				'default_value' => 'list',
				'ui'            => 1,
				'ajax'          => 1,
				'return_format' => 'value',
			],
			// CPT Archive sorting
			[
				'key'           => 'wtvr_acf_' . $slug . '_archive_sorting',
				'label'         => 'Sort by',
				'name'          => $slug . '-archive-sorting',
				'type'          => 'select',
				'wrapper'       => [
					'width' => '20',
					'class' => 'wtvr_acf_cpt_setup_sorting',
				],
				'choices'       => [
					'menu_order' => 'Admin order',
					'title'      => 'Title',
					'subtitle'   => 'Subtitle',
				],
				'ui'            => 1,
				'ajax'          => 1,
				'return_format' => 'value',
			],
			// CPT Archive sorting
			[
				'key'           => 'wtvr_acf_' . $slug . '_archive_per_page',
				'label'         => 'Items on page',
				'name'          => $slug . '-archive-per-page',
				'type'          => 'select',
				'wrapper'       => [
					'width' => '20',
					'class' => 'wtvr_acf_cpt_setup_per_page',
				],
				'choices'       => [
					'default'   => 'Default',
					'12'        => '12',
					'24'        => '24',
					'36'        => '36',
					'48'        => '48',
					'60'        => '60',
				],
				'default_value' => 'default',
				'ui'            => 1,
				'ajax'          => 1,
				'return_format' => 'value',
			],
			// CPT Thumb layout
			[
				'key'           => 'wtvr_acf_' . $slug . '_layout',
				'label'         => 'Image',
				'name'          => $slug . '-layout',
				'type'          => 'select',
				'wrapper'       => [
					'width' => '20',
					'class' => 'wtvr_acf_cpt_setup_layout',
				],
				'choices'       => [ // todo replace with layout options
					'landscape' => 'Landscape',
					'portrait'  => 'Portrait',
					'none'      => 'No images',
				],
				'default_value' => 'landscape',
				'ui'            => 1,
				'ajax'          => 1,
				'return_format' => 'value',
			],
			// CPT disable options
			[
				'key'           => 'wtvr_acf_' . $slug . '_options_enabled',
				'label'         => 'Custom options',
				'name'          => $slug . '-option-enabled',
				'type'          => 'select',
				'wrapper'       => [
					'width' => '20',
				],
				'choices'       => [
					'on'  => 'Enabled',
					'off' => 'Disabled',
				],
				'default_value' => 'on',
				'ui'            => 1,
				'ajax'          => 1,
				'return_format' => 'value',
			],
			// Columns
			[
				'key'                           => 'wtvr_acf_' . $slug . '_archive_columns',
				'label'                         => 'Archive fields / columns',
				'name'                          => $slug . '-columns',
				'type'                          => 'repeater',
				'instructions'                  => 'If archive layout is <b>Table</b>,
													these will become sortable columns.',
				'required'                      => 0,
				'acfe_repeater_stylised_button' => 1,
				'collapsed'                     => 'title',
				'min'                           => 0,
				'max'                           => 0,
				'layout'                        => 'table',
				'button_label'                  => '',
				'conditional_logic'  => [
					[
						[
							'field'    => 'wtvr_acf_' . $slug . '_archive_layout',
							'operator' => '==',
							'value'    => 'table',
						],
					],
				],
				'sub_fields'                    => [
					[
						'key'               => 'wtvr_acf_' . $slug . '_archive_col_type',
						'label'             => 'Type',
						'name'              => 'type',
						'type'              => 'select',
						'instructions'      => 'Type of field',
						'required'          => 0,
						'choices'           => [
							'text'         => 'Text / Value',
							'default'      => 'Defalut',
							'relationship' => 'Relationship',
							'count'        => 'Count Related',
						],
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '25',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => 'text',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],
					[
						'key'               => 'wtvr_acf_' . $slug . '_archive_col_field',
						'label'             => 'Field',
						'name'              => 'field',
						'type'              => 'text',
						'instructions'      => 'Custom meta field, must exist, otherwise will be skipped',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '25',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],
					[
						'key'               => 'wtvr_acf_' . $slug . '_archive_col_title',
						'label'             => 'Title',
						'name'              => 'title',
						'type'              => 'text',
						'instructions'      => 'Custom title for this meta field / column header',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '25',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],

					[
						'key'               => 'wtvr_acf_' . $slug . '_archive_col_width',
						'label'             => 'Width',
						'name'              => 'width',
						'type'              => 'number',
						'instructions'      => 'Proportion, like in a cocktail!',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '25',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => 1,
						'min'               => 1,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					],
				],
			],
			// Folders
			[
				'key'           => 'wtvr_acf_' . $slug . '_folder_taxonomy',
				'label'         => 'Taxonomy used as folders',
				'name'          => $slug . '-folder-taxonomy',
				'instructions'  => 'You MUST create and select a hierarchical taxonomy to use for folders structure.
								   Otherwise the archive layout will fall back to default (list)',
				'type'          => 'select',
				'choices'       => [
					'default' => 'Default'
				],
				'default_value' => 'on',
				'ui'            => 1,
				'ajax'          => 1,
				'return_format' => 'value',
				'conditional_logic'  => [
					[
						[
							'field'    => 'wtvr_acf_' . $slug . '_archive_layout',
							'operator' => '==',
							'value'    => 'folders',
						],
					],
				],
			],

			// Advanced settings ---
			[
				'key' => 'wtvr_acf_' . $slug . '_taxonomies_accordion',
				'label' => 'Taxonomies',
				'type' => 'accordion',
				'instructions' => '',
				'open' => 0,
				'multi_expand' => 1,
				'endpoint' => 0,
			],
			// Taxonomies
			[
				'key' => 'wtvr_acf_setup_' . $slug . '_taxonomies',
				'label' => 'Taxonomies',
				'name' => $slug . '-taxonomies',
				'type' => 'repeater',
				'collapsed'  => 'wtvr_acf_' . $slug . '_taxonomy_plural',
				'button_label' => 'Add Taxonomy',
				'layout'       => 'table',
				'sub_fields' => [
					[
						'key' => 'wtvr_acf_' . $slug . '_taxonomy_plural',
						'label' => 'Plural',
						'name' => 'plural',
						'type' => 'text',
						'required' => 1,
						'placeholder'  => 'Categories',
						'wrapper' => [
							'width' => '40',
						],
					],
					[
						'key' => 'wtvr_acf_' . $slug . '_taxonomy_singular',
						'label' => 'Singular',
						'name' => 'singular',
						'type' => 'text',
						'required' => 1,
						'placeholder'  => 'Category',
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '40',
						],
					],
					[
						'key' => 'wtvr_acf_' . $slug . '_hierarchical',
						'label'         => 'Type',
						'label' => 'Hierarchical',
						'name' => 'hierarchical',
						'type' => 'true_false',
						'wrapper' => array(
							'width' => '20',
						),
						'default_value' => 1,
					],
				],
			],
			// Closer accordion ---
			[
				'key' => 'wtvr_acf_' . $slug . '_endponit_accordion',
				'type' => 'accordion',
				'instructions' => '',
				'open' => 0,
				'multi_expand' => 0,
				'endpoint' => 1,
			],

		];



		$post_type_tabs = array_merge($post_type_tabs, $post_type_tab);



	}


	$post_type_tabs = array_merge( $post_type_tabs, [
		// CPT OPTIONS TABS --- END POINT
		[
			'key'      => 'wtvr_acf_cpt_options_tabs_endpoint',
			'type'     => 'tab',
			'endpoint' => 1,
		]
	] );

	acf_add_local_field_group( [
		'key'        => 'wtvr-cpts-options',
		'title'      => 'Customize content types',
		'fields'     => $post_type_tabs,
		'location'   => [
			[
				[
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'acf-options-edit-customize',
				],
			],
		],
		'menu_order' => 1,
	] );


}