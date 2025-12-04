<?php

use Whatever\Fields;

/** Feature options
 *
 */
acf_add_local_field_group( [
	'key'                   => 'wtvr_acf_feature_options_group',
	'title'                 => 'Feature options',
	'fields'                => [
		// featured gallery
		[
			'key'               => 'wtvr_acf_featured_gallery',
			'label'             => 'Featured gallery',
			'name'              => 'featured_gallery',
			'type'              => 'gallery',
			'instructions'      => 'Replaces Featured image',
			'required'          => 0,
			'conditional_logic' => [
				[
					[
						'field'    => 'wtvr_acf_feature_type',
						'operator' => '==',
						'value'    => 'gallery',
					],
				],
			],
			'wrapper'           => [
				'width' => '100',
				'class' => '',
				'id'    => '',
			],
			'return_format'     => 'id',
			'preview_size'      => 'thumbnail',
			'insert'            => 'append',
			'library'           => 'all',
			'min'               => '',
			'max'               => '',
			'min_width'         => '',
			'min_height'        => '',
			'min_size'          => '',
			'max_width'         => '',
			'max_height'        => '',
			'max_size'          => '',
			'mime_types'        => '',
		],
		// featured video
		[
			'key'               => 'wtvr_acf_featured_video',
			'label'             => 'Featured video',
			'name'              => 'featured_video',
			'type'              => 'oembed',
			'instructions'      => 'Replaces Featured image on top of page. Featured image still needed for archives!',
			'required'          => 0,
			'conditional_logic' => [
				[
					[
						'field'    => 'wtvr_acf_feature_type',
						'operator' => '==',
						'value'    => 'video',
					],
				],
			],
			'wrapper'           => [
				'width' => '100',
				'class' => '',
				'id'    => '',
			],
		],
		// feature options
		[
			'key'               => 'wtvr_acf_options',
			'label'             => '',
			'name'              => 'post-options',
			'type'              => 'group',
			'required'          => 0,
			'conditional_logic' => 0,
			'wrapper'           => [
				'width' => '100',
				'class' => '',
				'id'    => '',
			],
			'sub_fields'        => [
				[ // post feature type
					'key'               => 'wtvr_acf_feature_type',
					'label'             => 'Feature type',
					'name'              => 'feature-type',
					'type'              => 'select',
					'required'          => 0,
					'conditional_logic' => 0,
					'choices'           => [
						'image'   => 'Image',
						'gallery' => 'Gallery',
						'video'   => 'Video',
					],
					'default_value'     => 'image',
					'allow_null'        => 0,
					'multiple'          => 0,
					'ui'                => 0,
					'return_format'     => 'value',
					'ajax'              => 0,
					'placeholder'       => '',
				],
				// post image layout
				[
					'key'           => 'wtvr_acf_featured_layout',
					'label'         => 'Layout',
					'name'          => 'layout',
					'type'          => 'select',
					'choices'       => [ // todo layout choices
						'landscape'       => 'Landscape',
						'portrait'        => 'Portrait',
						'square'          => 'Square',
						'landscape-small' => 'Landscape (small)',
						'landscape-tiny'  => 'Landscape (tiny)',
						'square-tiny'     => 'Square (tiny)',
						'hidden'          => 'Hide Image',
					],
					'wrapper'       => [
						'width' => '50',
						'class' => '',
						'id'    => '',
					],
					'default_value' => false,
					'return_format' => 'value',
					'ajax'          => 0,
					'placeholder'   => '',
				],
				// image cropping
				[
					'key'           => 'wtvr_acf_featured_cropping',
					'label'         => 'Cropping',
					'name'          => 'cropping',
					'type'          => 'select',
					'choices'       => [ // todo cropping choices
						'cover'   => 'Cover',
						'contain' => 'Contain',
					],
					'wrapper'       => [
						'width' => '50',
						'class' => '',
						'id'    => '',
					],
					'default_value' => false,
					'return_format' => 'value',
					'ajax'          => 0,
					'placeholder'   => '',
				],

			],
		],
	],
	'location'              => Fields::get_locations()->options_enabled,
	'menu_order'            => 2,
	'position'              => 'side',
	//'style'                 => 'seamless',
	'label_placement'       => 'top',
	'instruction_placement' => 'label',
	'active'                => true,
	'description'           => '',
] );
