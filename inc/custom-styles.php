<?php

/**
 *
 * Concstuct CSS rules form ACF fields
 *
 * @param array $rules Keyed array 'selector' => ['css-rule' => 'acf-field-name']
 *
 * @return string CSS rule
 */

function wtvr_acf_css( array $rules ) {

	$group = '';

	foreach ( $rules as $selector => $options ) {

		$group .= $selector . '{';

		foreach ( $options as $option => $field ) {

			// in case we need to add something after value
			if ( is_array( $field ) ) {
				$value = wtvr_option( $field[0] );

				if ( $value ) {
					$group .= $option . ':' . $value . $field[1] . ';';
				}

			} else {
				$value = wtvr_option( $field );

				if ( $value ) {
					$group .= $option . ':' . $value . ';';
				}
			}
		}

		$group .= '}';
	}

	return $group;

}


add_action( 'wp_head', 'wtvr_custom_styles', 7 );
/*
 * Add styles via inline css
 */
function wtvr_custom_styles() {
	echo '<style title="whatever-options">';


	// shorthands
	$c  = 'color';
	$bg = 'background-color';
	$fz = 'font-size';
	$lh = 'line-height';


	echo wtvr_acf_css( [
		// PROPERTY-CLASSES
		// Colors
		'.c--main'                                                       => [ $c => 'col-main' ],
		'.c--accent'                                                     => [ $c => 'col-accent' ],
		'.c--bg'                                                         => [ $c => 'col-bg' ],
		'.c--light'                                                      => [ $c => 'col-light' ],
		'.c--secondary'                                                  => [ $c => 'col-secondary' ],
		// Backgrounds
		'.c--main-bg'                                                    => [ $bg => 'col-main' ],
		'.c--accent-bg'                                                  => [ $bg => 'col-accent' ],
		// Fills
		'.f--main'                                                       => [ $c => 'col-main' ],
		'.f--light'                                                      => [ $c => 'col-light' ],
		'.f--accent'                                                     => [ $c => 'col-accent' ],

		// Paddings
		'.p--main'                                                       => [ $c => [ 'padding-main', 'px' ] ],
		'.p--card'                                                       => [ $c => [ 'padding-card', 'px' ] ],


		// ELEMENTS
		// Body
		'body'                                                           => [
			$c  => 'col-main',
			$bg => 'col-bg'
		],
		// Menu
		'#site-navigation li'                                            => [
			$fz => [ 'menu-font-size', 'px' ],
		],
		// Footer
		'.footer-inverted #colophon'                                     => [
			$c  => 'col-light',
			$bg => 'col-main',
		],
		'.footer-inverted #colophon h2, .footer-inverted #colophon h3'   => [
			$c => 'col-accent',
		],
		'.footer-inverted #colophon a'                                   => [
			$c => 'col-light',
		],
		'.footer-inverted #colophon a:hover'                             => [
			$c => 'col-accent',
		],

		// BLOCKS
		'.boxlink'                                                       => [
			$c => 'col-accent'
		],

		'.boxes .inner' => [
			'border-color' => 'col-accent'
		],

		// Buttons
		// Menu
		'#buttons-menu li a.font-icon'                                   => [
			$bg => 'col-secondary',
			$c  => 'col-main',
		],
		'#buttons-menu li a.font-icon:hover'                             => [
			$bg => 'col-main',
			$c  => 'col-secondary',
		],

		// SVG layers
		// regular
		'a svg .st0'                                                     => [ 'fill' => 'col-main' ],
		'a:hover svg .st0, a:focus svg .st0'                             => [ 'fill' => 'col-accent' ],
		'a svg .st1'                                                     => [ 'fill' => 'col-light' ],
		'a:hover svg .st1, a:focus svg .st1'                             => [ 'fill' => 'col-main' ],
		// reverse
		'main a svg .st0'                                                => [ 'fill' => 'col-accent' ],
		'main a:hover svg .st0, main a:focus svg .st0'                   => [ 'fill' => 'col-main' ],
		'main a svg .st1'                                                => [ 'fill' => 'col-light' ],
		'main a:hover svg .st1, main a:focus svg .st1'                   => [ 'fill' => 'col-accent' ],
		// header-icons
		'#buttons-menu a svg .st0'                                       => [ 'fill' => 'col-secondary' ],
		'#buttons-menu a:hover svg .st0, #buttons-menu a:focus svg .st0' => [ 'fill' => 'col-main' ],
		'#buttons-menu a svg .st1'                                       => [ 'fill' => 'col-main' ],
		'#buttons-menu a:hover svg .st1, #buttons-menu a:focus svg .st1' => [ 'fill' => 'col-secondary' ],
		// invert accent-light
		'#colophon a svg .st0'                                           => [ 'fill' => 'col-accent' ],
		'#colophon a:hover svg .st0, #colophon a:focus svg .st0'         => [ 'fill' => 'col-light' ],
		'#colophon a svg .st1'                                           => [ 'fill' => 'col-light' ],
		'#colophon a:hover svg .st1, #colophon a:focus svg .st1'         => [ 'fill' => 'col-accent' ],


		// Headers
		'.headers-accent .page-title,.headers-accent .entry-title,.headers-accent .archive-title'=> [
			$c => 'col-accent'
		],

	] );

	// Conditional styles
	$link_highlight = wtvr_option( 'link-highlight' );
	switch ( $link_highlight ) {
		case 'color':
			echo wtvr_acf_css( [
				// Colors
				'a' => [
					$c => 'col-accent',
				]
			] );
			break;
		case 'underline':
			echo wtvr_acf_css( [
				// Colors
				'a' => [
					$c => 'col-main',
				]
			] );
			break;
	}

	echo '</style>
';
}

/*
 * Add styles via body classes
 */
add_filter( 'body_class', 'wtvr_optional_body_classes', 10 );
function wtvr_optional_body_classes( $classes ) {

	// LINKS
	// Highlighting
	$link_highlight = wtvr_option( 'link-highlight' );
	switch ( $link_highlight ) {
		case 'underline':
			$classes[] = 'links-underline';
			break;
	}

	// MENU
	// Separator
	$menu_sep = wtvr_option( 'menu-separator' );
	switch ( $menu_sep ) {
		case 'slash':
			$classes[] = 'menu-slash';
			break;
	}
	// Text transform
	$menu_transform = wtvr_option( 'menu-text-transform' );
	switch ( $menu_transform ) {
		case 'uppercase':
			$classes[] = 'menu-uc';
			break;
		case 'lowercase':
			$classes[] = 'menu-lc';
			break;
	}
	// Hover effect
	$menu_on_hover = wtvr_option( 'menu-hover-effect' );
	switch ( $menu_on_hover ) {
		case 'size':
			$classes[] = 'menu-upsize';
			break;
		case 'spacing':
			$classes[] = 'menu-letter-space';
			break;
	}

	// Current item highlight
	$menu_on_current = wtvr_option( 'menu-current-item' );
	if ( is_array( $menu_on_current ) ) {
		$current_item_options = [ 'color', 'bold', 'underline' ];
		foreach ( $current_item_options as $option ) {
			if ( in_array( $option, $menu_on_current ) ) {
				$classes[] = 'menu-current-' . $option;
			}
		}
	}

	// Headers location
	$headers_location = wtvr_option( 'headers-location' );
	switch ( $headers_location ) {
		case 'full':
			$classes[] = 'headers-full';
			break;
	}

	// Headers color
	$headers_color = wtvr_option( 'headers-color' );
	switch ( $headers_color ) {
		case 'accent':
			$classes[] = 'headers-accent';
			break;
	}

	// Headers text-transform
	$headers_text_transform = wtvr_option( 'headers-text-transform' );
	switch ( $headers_text_transform ) {
		case 'uppercase':
			$classes[] = 'headers-uc';
			break;
	}

	// Footer style
	$footer_style = wtvr_option( 'footer-style' );
	switch ( $footer_style ) {
		case 'inverted':
			$classes[] = 'footer-inverted';
			break;
	}

	return $classes;

}