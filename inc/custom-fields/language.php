<?php

//use Whatever\Fields;

/** LANGUAGE
 *
 */
/* acf_add_local_field_group( [
	'key'                   => 'wtvr_acf_content_language_group',
	'title'                 => 'Language',
	'fields'                => [
		// related content style
		[
			'key'           => 'wtvr_acf_content_language',
			'label'         => 'Language',
			'name'          => 'content_language',
			'type'          => 'select',
			'choices'       => wtvr_get_language_choices(),
			'default_value' => 'group',
			'allow_null'    => 1,
			'multiple'      => 0,
			'ui'            => 0,
			'return_format' => 'value',
			'ajax'          => 1,
			'placeholder'   => '',
		],
	],
	'location'              => array_merge(
		Fields::get_locations()->all,
		[
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'contracts',
				],
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'translations',
				],
			],
		]
	),
	'menu_order'            => 0,
	'position'              => 'side',
	'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'label',
	'active'                => true,
	'description'           => '',
] ); */
