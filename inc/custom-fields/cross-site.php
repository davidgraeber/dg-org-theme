<?php

/** CROSS-SITE connection
 *
 */
acf_add_local_field_group( [
	'key'                   => 'wtvr_acf_cross_connection_group',
	'title'                 => 'Connection',
	'fields'                => [
		// connected content style
		[
			'key'           => 'wtvr_acf_cross_connection',
			'label'         => 'Main site ←→ Estate link',
			'name'          => 'connection',
			'type'          => 'select',
			'choices'       => [],
			'allow_null'    => 1,
			'multiple'      => 0,
			'ui'            => 0,
			'return_format' => 'value',
			'ajax'          => 1,
			'placeholder'   => '',
		],

	],
	'location'              => [
		[
			[
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'books',
			],
		],
	],
	'menu_order'            => 20,
	'position'              => 'side',
	//'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'label',
	'active'                => true,
	'description'           => '',
] );
