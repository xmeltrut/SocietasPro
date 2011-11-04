<?php
/**
 * Blog posts model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Common
 *
 * @todo validateSlug() needs to ignore the current post ID
 */

require_once("basemodel.php");
require_once("objects/BlogPost.php");

class BlogPostsModel extends BaseModel {

	protected $tableName = "blog_posts";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Create a new post
	 *
	 * @param string $name Name
	 * @param string $slug URL
	 * @param array Array of date elements
	 * @param string $content Content
	 * @return boolean Success
	 */
	public function create ($name, $slug, $date, $content) {
	
		// create object
		$post = new BlogPost();
		
		// add data to object
		if (
			!$post->setName($name) ||
			!$post->setSlug($slug) ||
			!$post->setDateByArray($date) ||
			!$post->setContent($content)
		) {
			$this->setMessage($post->getMessage());
			return false;
		}
		
		// save object
		$this->setMessage(LANG_SUCCESS);
		return $this->save($post);
	
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

}
