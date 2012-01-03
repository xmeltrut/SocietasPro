<?php
/**
 * PostgreSQL driver
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

class PostgresDatabase implements iDatabase {

	/**
	 * Escape a string
	 *
	 * @param string $sql SQL
	 * @return string Escaped string
	 */
	public function escape ($sql) {
		return pg_escape_string($sql);
	}

}