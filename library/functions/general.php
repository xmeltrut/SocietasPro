<?php
/**
 * General functions library.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

/**
 * Attempt to load a class file that has not yet been loaded
 *
 * @param string $className Class name
 */
function autoload ($className) {

	$paths = array (
		"../library/classes/".$className.".php",
		"../library/exceptions/".$className.".php"
	);
	
	foreach ($paths as $path) {
		if (file_exists($path)) {
			require $path;
		}
	}

}

/**
 * Take an array and convert it into constants
 *
 * @param array $arr Associative arrays
 */
function arrayToConstants ($arr) {
	foreach ($arr as $key => $val) {
		define($key, $val);
	}
}

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
 * Log an error into the error log
 *
 * @param int $code Error code
 * @param string $details Error details
 * @param string $sql SQL statement
 * @return boolean Success
 */
function logError ($code, $details = "", $sql = "") {

	require_once("models/ErrorLogsModel.php");
	$errorLogsModel = new ErrorLogsModel();
	return $errorLogsModel->insert($code, $details, $sql);

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
 */
function redirect ($url = "") {
	Header("Location: ".ROOT.$url);
	echo('<a href="$url">'.ROOT.$url.'</a>');
	exit(0);
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
 * Get the SQL LIMIT statement for paging
 *
 * @param int $pageNum Page number
 * @param int $perPage Results per page
 * @return string SQL LIMIT statement
 */
function sqlLimit ($pageNum = 1, $perPage = ITEMS_PER_PAGE) {
	
	// check for a valid page number
	if ($pageNum < 1 || $pageNum === false) {
		$pageNum = 1;
	}
	
	// return string
	$str = "LIMIT " . (($pageNum * $perPage) - $perPage) . ", " . $perPage . " ";
	return $str;

}

/**
 * Calculate the total number of pages for a view
 *
 * @param int $totalRecords Total number of records
 * @param int $perPage Results per page
 */
function totalPages ($totalRecords, $perPage = ITEMS_PER_PAGE) {
	return ceil($totalRecords / $perPage);
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
