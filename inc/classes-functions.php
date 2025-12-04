<?php

function kstshn_uc_caps_to_lc_hyphens($classname): string {

	return strtolower( str_replace('_', '-', $classname) );

}

function wtvr_class_short_file_name($classname): string {

	$classname = kstshn_uc_caps_to_lc_hyphens($classname);

	if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
	return $pos;

}

function wtvr_class_name_from_filename($filename): string {

	return str_replace('-','_',ucwords($filename,'-'));

	if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
	return $pos;

}

// ARCHIVES

