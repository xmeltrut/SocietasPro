<?php
/**
 * General function library
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package BugScanner
 */

/**
 * Autoload a missing class
 *
 * @param string $className Class name
 */
function __autoload ($className) {

	$filePath = "classes/".$className.".php";
	
	if (file_exists($filePath)) {
		require($filePath);
	} else {
		throw new Exception("Class " . $className . " missing.");
	}

}

/**
 * Colour code lines of code
 *
 * @param string $str Line of code
 * @return string HTML output
 */
function highlightSyntax ($str) {

	// variables
	preg_match_all('/\$([a-z0-9\-_]+)/i', $str, $matches);
	foreach($matches[0] as $match) {
		$str = str_replace($match, '<span class="codeVariable">'.$match.'</span>', $str);
	}
	
	// functions
	$functions = get_defined_functions();
	$functions = array_merge($functions["internal"], $functions["user"]);
	
	foreach ($functions as $function) {
		preg_match_all('/'.$function.'\(/', $str, $matches);
		foreach ($matches[0] as $match) {
			$str = str_replace($match, '<span class="codeFunction">'.substr($match,0,-1).'</span>(', $str);
		}
	}
	
	// keywords
	$keywords = array (
		"array",
		"class",
		"extends",
		"implements"
	);
	
	foreach ($keywords as $keyword) {
		preg_match_all('/(^| )'.$keyword.'( |\()/', $str, $matches);
		foreach ($matches[0] as $match) {
			if (substr($match, -1) == "(") {
				$str = str_replace($match, '<span class="codeKeyword">'.substr($match,0,-1).'</span>(', $str);
			} else {
				$str = str_replace($match, '<span class="codeKeyword">'.$match.'</span>', $str);
			}
		}
	}
	
	// return output
	return $str;

}

/**
 * This is a custom sorting function used in DirectoryCursor, but we can't
 * do it inline because it will attempt to redeclare itself.
 *
 * @param int $a Line number
 * @param int $b Line number
 * @return int Movement of element
 */
function sortByLineNumber($a, $b) {
	if ($a[2] == $b[2]) { return 0; }
	return ($a[2] < $b[2]) ? -1 : 1;
}
