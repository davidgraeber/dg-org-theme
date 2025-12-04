<?php

use Whatever\Fields;

/**
 * RELATIONSHIPS
 */
acf_add_local_field_group( [
	'key'                   => 'wtvr_acf_relationship_group',
	'title'                 => 'Relationships',
	'fields'                => [
		// related content
		[
			'key'               => 'wtvr_acf_related_content',
			'label'             => 'Related content',
			'name'              => 'related_content',
			'type'              => 'relationship',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => [
				'width' => '',
				'class' => '',
				'id'    => '',
			],
			'post_type'         => '',
			'taxonomy'          => '',
			'filters'           => [
				0 => 'search',
				1 => 'post_type',
				//2 => 'taxonomy',
			],
			'elements'          => [
				0 => 'featured_image',
			],
			'min'               => '',
			'max'               => '',
			'return_format'     => 'id',
		],
		// related content style
		[
			'key'               => 'wtvr_acf_related_content_style',
			'label'             => 'Related content style',
			'name'              => 'related_style',
			'type'              => 'select',
			'instructions'      => 'If you have selected "Group by post type",
		    related content will be put into groups automatically. <br>Otherwise there will be a single group with
		    a custom header.',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => [
				'width' => '50',
				'class' => '',
				'id'    => '',
			],
			'choices'           => [
				'group'      => 'Group by post type',
				'everything' => 'One block with custom header',
			],
			'default_value'     => 'group',
			'allow_null'        => 0,
			'multiple'          => 0,
			'ui'                => 0,
			'return_format'     => 'value',
			'ajax'              => 0,
			'placeholder'       => '',
		],
		// related content custom title
		[
			'key'               => 'wtvr_acf_related_content_title',
			'label'             => 'Custom header',
			'name'              => 'related_content_title',
			'type'              => 'text',
			'required'          => 0,
			'conditional_logic' => [
				[
					[
						'field'    => 'wtvr_acf_related_content_style',
						'operator' => '==',
						'value'    => 'everything',
					],
				],
			],
			'wrapper'           => [
				'width' => '50',
				'class' => '',
				'id'    => '',
			],
			'default_value'     => 'Related content',
			'placeholder'       => '',
			'prepend'           => '',
			'append'            => '',
			'maxlength'         => '',
		],
	],
	'location'              => Fields::get_locations()->all,
	'menu_order'            => 0,
	'position'              => 'normal',
	'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen'        => '',
	'active'                => true,
	'description'           => '',
] );
