<?php
/**
 * Interface for database abstraction layers
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

interface iDatabase {
	public function escape ($sql);
	public function getAffectedRows ();
	public function getError ();
	public function getErrorNumber ();
	public static function getInstance ();
	public function fetchOne ($sql);
	public function insertId ();
	public function query ($sql);
}
