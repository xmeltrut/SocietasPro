<?php
/**
 * Pagination helpers
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Framework\Utilities;

class Pagination {

	const ITEMS_PER_PAGE = 25;
	
	/**
	 * Convert a variable to a page number, with fallback
	 *
	 * @param int $page Page number
	 * @return int Page number
	 */
	public static function pageNum ($var) {
		$var = intval($var);
		if ($var < 1) { $var = 1; }
		return $var;
	}
	
	/**
	 * Get the SQL LIMIT statement for paging
	 *
	 * @param int $pageNum Page number
	 * @param int $perPage Results per page
	 * @return string SQL LIMIT statement
	 */
	public static function sqlLimit ($pageNum = 1, $perPage = self::ITEMS_PER_PAGE) {
		
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
	public static function totalPages ($totalRecords, $perPage = self::ITEMS_PER_PAGE) {
		return ceil($totalRecords / $perPage);
	}

}