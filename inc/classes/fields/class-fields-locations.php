<?php

namespace Whatever;

class Fields_Locations {

	public array $all;
	public array $custom_include;
	public array $options_enabled;


	public function __construct($include = []){

		if ( empty($include) ) {

			$this->all = array_map(
				[ $this, 'cpt_list_to_location_rules' ],
				Cpt::list_include_default()
			);

		} else {

			$this->all = array_map(
				[ $this, 'cpt_list_to_location_rules' ],
				Cpt::list_include_default($include)
			);

		}

		$this->custom_include = array_map(
			[ $this, 'cpt_list_to_location_rules' ],
			Cpt::list($include)
		);

		// Only whare custom options are enabled
		$this->options_enabled = array_map(
			[ $this, 'cpt_list_to_location_rules_options_enabled' ],
			Cpt::list_include_default()
		);
	}

	// MAPS

	/**
	 * Turns post type list to ACF location rules
	 *
	 * @param $post_type
	 *
	 * @return array
	 */
	private function cpt_list_to_location_rules( $post_type ): array {
		return [
			[
				'param'    => 'post_type',
				'operator' => 'IN',
				'value'    => $post_type,
			]
		];
	}

	/**
	 * Turns post type list to ACF location rules
	 *
	 * @param $post_type
	 *
	 * @return array
	 */
	private function cpt_list_to_location_rules_options_enabled( $post_type ): array {

		$options_enabled = get_field( 'wtvr_acf_' . $post_type . '_options_enabled', 'option' );
		return ( 'off' === $options_enabled ) ?
			[] :
			[
				[
					'param'    => 'post_type',
					'operator' => 'IN',
					'value'    => $post_type,
				],
			];
	}

}