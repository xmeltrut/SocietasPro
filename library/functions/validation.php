<?php
/**
 * These functions are used to run generic validation.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

/**
 * Check if a string is a well formed email address
 *
 * @param string $value String to test
 * @return boolean
 */
function validateEmail ($value) {
	return (preg_match("/(.+)@([a-z,0-9,\-]+).([a-z]+)/i", $value)) ? true : false;
}