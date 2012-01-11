<?php
/**
 * This is a wrapper for the PDO class.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Database
 */

class PdoWrapper extends PDO {

	/**
	 * Store the error messages for external use
	 */
	private $error;
	private $errorNumber;
	
	/**
	 * Fetch one single value from the database.
	 *
	 * @param string $sql SQL statement
	 * @return mixed Value
	 */
	public function fetchOne ($sql) {
	
		$recordset = $this->query($sql);
		$row = $recordset->fetch(PDO::FETCH_NUM);
		return $row[0];
	
	}
	
	/**
	 * Get the last error message
	 *
	 * @return string Error message
	 */
	public function getError () {
		return $this->error;
	}
	
	/**
	 * Get the last error code
	 *
	 * @return int Error code
	 */
	public function getErrorNumber () {
		return $this->errorNumber;
	}
	
	/**
	 * Force queries to prepare and execute, so that we can
	 * grab any error messages they produce.
	 *
	 * @param string  $sql SQL
	 * @return PDOStatement
	 */
	public function query ($sql) {
	
		$sth = parent::prepare($sql);
		$query = $sth->execute(array());
		
		if ($query === false) {
			$info = $sth->errorInfo();
			$this->error = $info[2];
			$this->errorNumber = $info[1];
			throw new DatabaseException($sql);
		}
		
		return $sth;
	
	}

}