<?php
/**
 * Autoloader
 *
 * @author Chris Worfolk <chris@societasrpo.org>
 */

namespace Framework\Core;

class Autoloader {

	/**
	 * Array of directories to search
	 */
	private static $directories = array();
	
	/**
	 * Load a class
	 *
	 * @return void
	 *
	 * @todo Rewrite this
	 */
	public static function load ($class) {
	
		$namespace = explode("\\", $class);
		
		if (count($namespace) > 1) {
		
			$path = "application/".str_replace("\\", "/", $class) . ".php";
			//echo($path."<br />");
			if (file_exists($path)) {
				require_once($path);
			} else {
				//echo("<strong>CLASS MISSING!</strong>");
				//debug_print_backtrace();
			}
		
		} else {
		
			foreach (self::$directories as $directory) {
				$path = $directory . "/" . $class . ".php";
				//echo("Checking $path<br />");
				if (file_exists($path)) {
					require_once($path);
				}
			}
		
		}
	
	}
	
	/**
	 * Register a directory
	 *
	 * @param string|array $dirs Directory path
	 *
	 * @return boolean
	 */
	public static function register ($dirs) {
	
		// enforce as array
		if (!is_array($dirs)) {
			$dirs = array($dirs);
		}
		
		// loop through array
		foreach ($dirs as $dir) {
			if (!in_array($dir, self::$directories)) {
				self::$directories[] = $dir;
			}
		}
	
	}

}

