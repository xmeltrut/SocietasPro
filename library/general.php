<?php
/**
 * General functions library.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Rename the varSet function to reqSet
 */

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
 * Use this to avoid PHP notices for unset indexes
 *
 * @param string $index Array index
 */
function varSet ($index) {
	if (isset($_REQUEST[$index])) {
		return $_REQUEST[$index];
	} else {
		return false;
	}
}
