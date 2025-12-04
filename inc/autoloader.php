<?php

/**
 * Automatic loading of plugin classes in namespace
 * @param $class
 */

namespace Whatever;
// get the relative class name
$len = strlen( __NAMESPACE__ . '\\');

// base directory for the namespace prefix
$base_dir = __DIR__ . DIRECTORY_SEPARATOR . 'classes';

// get subdirectories
$dirs = glob($base_dir . '/*' , GLOB_ONLYDIR | GLOB_NOSORT);

// include base directory
array_unshift($dirs, $base_dir);

foreach ($dirs as $index => $dir){

	$filename = basename($dir);

	$dirs[$filename] = $dir;

	unset($dirs[$index]);

}

function wtvr_check_and_require( $dir, $class_file ): bool {

	$full_path = $dir . $class_file;

	$is_readable = is_readable($full_path);

	if ( $is_readable ) {
		require_once $full_path;
	}

	return $is_readable;

}


spl_autoload_register(function ($class) use ( $dirs, $len) {

	// only use for the namespace
	if (strpos($class, __NAMESPACE__) !== 0) {
		return;
	}

	$relative_class = substr($class, $len);

	// Convert class name format to file name format
	$class_file = kstshn_uc_caps_to_lc_hyphens($relative_class);

	$hint = strtok($class_file, '-');

	$found = $dirs[$hint] ?? false;

	// prepare class file name
	$class_file = DIRECTORY_SEPARATOR . 'class-' . $class_file . '.php';

	// Return early if found in index
	if ($found && wtvr_check_and_require($found, $class_file)) return;

	//Find the class in each directory and then stop
	foreach ($dirs as $dir) {

		if ( wtvr_check_and_require($dir, $class_file) ) break;
	}

});

