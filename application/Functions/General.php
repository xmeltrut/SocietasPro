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
 *
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
 * Shorthand for accessing encoding
 *
 * @param string $str String
 *
 * @return string Encoded string
 *
 * @todo Replace with view or templating system?
 */
function h ($str) {
	return htmlspecialchars($str);
}

/**
 * Rebuild the incoming $_REQUEST array, if required
 */
function rebuildRequestArray () {
	if (get_magic_quotes_gpc() == 1) {
		function stripFromRequest (&$val, $key) {
			$val = stripslashes($val);
		}
		array_walk_recursive($_REQUEST, "stripFromRequest");
	}
}


/**
 * Clean redirect function. You can leave the parameter blank to
 * simply redirect to the root page.
 *
 * @param string $url URL to redirect to
 *
 * @todo Replace with controller method?
 */
function redirect ($url = "") {
	Header("Location: ".ROOT.$url);
	echo('<a href="$url">'.ROOT.$url.'</a>');
	exit(0);
}