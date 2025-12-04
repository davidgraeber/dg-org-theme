<?php
/**
 * Template Name: Debug page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Whatever
 * */







if ( $debug = get_field( 'debug' ) ) {

	kstshn_pre_print( $debug );
} else {

	kstshn_pre_print( 'nothing' );

}