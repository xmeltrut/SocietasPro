<?php
/**
 * General functions library.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

/**
 * Check if an array key exists and if so, return it
 *
 * @param array $arr Array
 * @param string $index Array index
 * @return mixed
 */
function arrSet ($arr, $index) {
	if (array_key_exists($index, $arr)) {
		return $arr[$index];
	} else {
		return false;
	}
}

/**
 * Search include paths for a file
 *
 * @param string $file Filenam
 * @return boolean
 */
function fileExists ($file) {
  $ps = explode(":", ini_get('include_path'));
  print_r($ps);
  foreach($ps as $path)
  {
    if(file_exists($path.'/'.$file)) return true;
  }
  if(file_exists($file)) return true;
  return false;
}

/**
 * Shorthand function
 */
function h ($str) {
	return htmlspecialchars($str);
}

/**
 * Clean redirect function.
 *
 * @param string $url URL to redirect to
 */
function redirect ($url) {
	Header("Location: ".ROOT.$url);
	echo('<a href="$url">'.ROOT.$url.'</a>');
	die();
}

/**
 * Use this to avoid PHP notices for unset indexes with form variables
 *
 * @param string $index Array index
 * @return mixed
 */
function reqSet ($index) {
	if (isset($_REQUEST[$index])) {
		return $_REQUEST[$index];
	} else {
		return false;
	}
}

/**
 * Use this to avoid PHP notices for unset variables
 *
 * @param string $var Variable name
 * @return mixed
 */
function varSet ($var) {
	if (isset($var)) {
		return $var;
	} else {
		return false;
	}
}
