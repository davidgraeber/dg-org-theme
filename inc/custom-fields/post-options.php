<?php

/**
 * POST OPTIONS
 */

// ACF TABS
use Whatever\Fields;

$tab_info = [
	// TAB - OPTIONS
	[
		'key'               => 'wtvr_acf_post_options_tab',
		'label'             => 'Info',
		'name'              => '',
		'type'              => 'tab',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'placement'         => 'top',
		'endpoint'          => 0,
	],
	// Subtitle
	[
		'key'               => 'wtvr_acf_subtitle',
		'label'             => 'Subtitle',
		'name'              => 'subtitle',
		'type'              => 'text',
		'instructions'      => 'Entirely optional',
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
	// post summary / excerpt
	[
		'key'               => 'wtvr_acf_summary',
		'label'             => 'Summary',
		'name'              => 'summary',
		'type'              => 'textarea',
		'instructions'      => 'Keep clear and simple. 400 characters max. The less the better though',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '50',
			'class' => 'summary',
			'id'    => '',
		],
		'maxlength'         => '400',
		'rows'              => '5',
	],
	// hide summary
	[
		'key'               => 'wtvr_acf_hide_summary',
		'label'             => 'Hide summary',
		'name'              => 'hide_summary',
		'type'              => 'true_false',
		'instructions'      => 'When summary should be only displayed on links to this page,
		  not on the page itself. <br> Useful when summary is a reworked copy of the content.',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '25',
			'class' => '',
			'id'    => '',
		],
		'message'           => '',
		'default_value'     => 0,
		'ui'                => 0,
		'ui_on_text'        => '',
		'ui_off_text'       => '',
	],
];

$tab_links = [
	// TAB - LINKS
	[
		'key'               => 'wtvr_acf_post_links_tab',
		'label'             => 'Links',
		'name'              => '',
		'type'              => 'tab',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'placement'         => 'top',
		'endpoint'          => 0,
	],
	// post links
	[
		'key'               => 'wtvr_acf_attachments',
		'label'             => 'Links',
		'name'              => 'post-attachments',
		'type'              => 'group',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '100',
			'class' => '',
			'id'    => '',
		],
		'sub_fields'        => [

			[
				'key'               => 'wtvr_acf_external_link',
				'label'             => 'External link',
				'name'              => 'external-link',
				'type'              => 'url',
				'required'          => 0,
				'conditional_logic' => 0,
				'default_value'     => '',
				'placeholder'       => '',
			],

			[
				'key'               => 'wtvr_acf_external_author',
				'label'             => 'Author (external)',
				'name'              => 'external-author',
				'type'              => 'group',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '100',
					'class' => '',
					'id'    => '',
				],
				'sub_fields'        => [

					[
						'key'               => 'wtvr_acf_external_author_name',
						'label'             => 'Name',
						'name'              => 'external-author-name',
						'type'              => 'text',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '50',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '',
						'placeholder'       => '',
					],

					[
						'key'               => 'wtvr_acf_external_author_link',
						'label'             => 'Link',
						'name'              => 'external-author-link',
						'type'              => 'url',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '50',
							'class' => '',
							'id'    => '',
						],
						'default_value'     => '',
						'placeholder'       => '',
					],
				],
			],
		],
	],
];

$tab_files = [
	// TAB - FILES
	[
		'key'               => 'wtvr_acf_post_files_tab',
		'label'             => 'Files',
		'name'              => '',
		'type'              => 'tab',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'placement'         => 'top',
		'endpoint'          => 0,
	],
	// ATTACHED FILES
	[
		'key'                           => 'wtvr_acf_post_files',
		'label'                         => 'Files',
		'name'                          => 'files',
		'type'                          => 'repeater',
		'instructions'                  => '',
		'required'                      => 0,
		'conditional_logic'             => 0,
		'wrapper'                       => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'acfe_repeater_stylised_button' => 1,
		'collapsed'                     => '',
		'min'                           => 0,
		'max'                           => 0,
		'layout'                        => 'table',
		'button_label'                  => 'Add',
		'sub_fields'                    => [
			// File Label
			[
				'key'               => 'wtvr_acf_post_files_label',
				'label'             => 'Label (Optional)',
				'name'              => 'label',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '50',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			],
			// File itself
			[
				'key'               => 'wtvr_acf_post_files_file',
				'label'             => 'File',
				'button_label'      => 'Add File',
				'name'              => 'file',
				'type'              => 'file',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '50',
					'class' => '',
					'id'    => '',
				],
				'uploader'          => 'wp',
				'return_format'     => 'array',
				'library'           => 'all',
				'min_size'          => '',
				'max_size'          => 10,
				'mime_types'        => '',
			],
		],
	],

];

$tab_closer = [
	[
		'key'               => 'wtvr_acf_post_end_tab',
		'name'              => '',
		'type'              => 'tab',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => [
			'width' => '',
			'class' => '',
			'id'    => '',
		],
		'placement'         => 'top',
		'endpoint'          => 1,
	],
];

$post_tabs = array_merge(
	$tab_info,
	$tab_links,
	$tab_files,
	$tab_closer
);


/**
 * POST TABS
 */
acf_add_local_field_group( [
	'key'            => 'wtvr_acf_post_tabs',
	'title'          => 'Options',
	'fields'         => $post_tabs,
	'location'       => Fields::get_locations()->options_enabled,
	'menu_order'     => 0,
	'position'       => 'acf_after_title',
	'style'          => 'seamless',
	'hide_on_screen' => [
		'excerpt',
		'page_attributes'
	],
	'active'         => true,
] );
