<?php
/**
 * Blog posts model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 */

namespace Model;

use Framework\Abstracts\BaseModel;
use Framework\Interfaces\iModel;
use Framework\Utilities\Pagination;
use Framework\Logging\AuditTrail;

class BlogPostsModel extends BaseModel implements iModel {

	protected $tableName = "blog_posts";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Count the number of blog posts
	 *
	 * @return int Number of blog posts
	 */
	public function count () {
	
		$sql = "SELECT COUNT(postID) FROM ".DB_PREFIX."blog_posts ";
		return $this->db->fetchOne($sql);
	
	}
	
	/**
	 * Get a list of posts
	 *
	 * @param int $pageNum Page number
	 * @param boolean|string $statusFilter Filter on status
	 * @return array Array of posts
	 */
	public function get ($pageNum = 1, $statusFilter = false) {
	
		// initialise array
		$arr = array();
		
		// build filters
		$statusFilterSql = ($statusFilter) ? "WHERE postStatus = '".$statusFilter."'" : "";
		
		// query database
		$sql = "SELECT * FROM ".DB_PREFIX."blog_posts
				$statusFilterSql
				ORDER BY postDate DESC ".Pagination::sqlLimit($pageNum);
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[] = new BlogPost($row);
		}
		
		return $arr;
	
	}
	
	/**
	 * Get a specific post by ID
	 *
	 * @param int $id Post ID
	 * @return BlogPost
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."blog_posts WHERE postID = " . intval($id);
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new BlogPost($row);
		} else {
			return false;
		}
	
	}
	
	/**
	 * Get a specific post by slug
	 *
	 * @param string $slug Post slug
	 * @param boolean $ignoreStatus Ignore status
	 * @return BlogPost
	 */
	public function getBySlug ($slug, $ignoreStatus = true) {
	
		// ignore status sql
		$ignoreStatusSql = ($ignoreStatus) ? "" : "postStatus = 'Published'";
		
		// run query
		$sql = "SELECT * FROM ".DB_PREFIX."blog_posts WHERE postSlug = ? $ignoreStatusSql ";
		$rec = $this->db->prepare($sql);
		$rec->execute(array($slug));
		
		if ($row = $rec->fetch()) {
			return new BlogPost($row);
		} else {
			return false;
		}
	
	}
	
	/**
	 * Check a slug is unique and if not, generate a new one
	 *
	 * @param string $slug Slug
	 * @param int $id ID of the current post
	 * @return string Unique slug
	 */
	public function validateSlug ($slug, $id = 0) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."blog_posts
				WHERE postSlug = ?
				AND postID != ? ";
		$rec = $this->db->prepare($sql);
		$rec->execute(array($slug, $id));
		
		if ($rec->rowCount() == 0) {
			return $slug;
		} else {
			return $this->validateSlug(strIncrement($slug));
		}
	
	}
	
	/**
	 * Edit or create a blog post
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 6;
		} else {
			$object = new BlogPost();
			$auditAction = 5;
		}
		
		// make modifications
		$writes = array (
			$object->setName($d["name"]),
			$object->setSlug($d["slug"]),
			$object->setStatus($d["status"]),
			$object->setDateByArray($d["date"]),
			$object->setContent($d["content"])
		);
		
		if (in_array(false, $writes)) {
			$this->setMessage($object->getMessage());
			if ($id === false) { return false; }
		}
		
		if ($object->hasChanged()) {
			if ($this->save($object)) {
				AuditTrail::log($auditAction, $object->original(), $object);
				$this->setMessage(LANG_SUCCESS);
				return true;
			}
		}
		
		return false;
	
	}

}
