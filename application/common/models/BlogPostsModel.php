<?php
/**
 * Blog posts model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 *
 * @todo validateSlug() needs to ignore the current post ID
 * @todo TinyMCE doesn't handle apostrophies properly
 */

require_once("basemodel.php");
require_once("objects/BlogPost.php");

class BlogPostsModel extends BaseModel {

	protected $tableName = "blog_posts";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Get a list of posts
	 */
	public function get () {
	
		$arr = array();
		
		$sql = "SELECT * FROM ".DB_PREFIX."blog_posts ORDER BY postDate DESC ";
		$rec = $this->db->query($sql);
		
		while ($row = $rec->fetch()) {
			$arr[] = new BlogPost($row);
		}
		
		return $arr;
	
	}
	
	/**
	 * Get a specific post
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
	 * Check a slug is unique and if not, generate a new one
	 *
	 * @param string $slug Slug
	 * @return string Unique slug
	 */
	public function validateSlug ($slug) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."blog_posts WHERE postSlug = '".escape($slug)."' ";
		$rec = $this->db->query($sql);
		
		if ($rec->getRows() == 0) {
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
		if (
			!$object->setName($d["name"]) ||
			!$object->setSlug($d["slug"]) ||
			!$object->setDateByArray($d["date"]) ||
			!$object->setContent($d["content"])
		) {
			$this->setMessage($object->getMessage());
			return false;
		}
		
		// record in audit trail
		auditTrail($auditAction, $object->original(), $object);
		
		// save object
		$this->setMessage(LANG_SUCCESS);
		return $this->save($object);
	
	}

}
