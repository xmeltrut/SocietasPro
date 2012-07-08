<?php
/**
 * This is a base singleton class, to provide some protection
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 *
 * @todo Move instance instance variable into here
 */

namespace Framework\Core;

abstract class Singleton {

	protected function __construct () {
	}
	
	final private function __clone () {
	}
	
	final private function __wakeup () {
	}

}
