<?php
/**
 * Bog posts
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

namespace publica;

class BlogController extends \BaseController implements \iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/BlogPostsModel.php");
		$this->model = new \BlogPostsModel();
	
	}
	
	public function feed () {
	
		// build channel variables
		$title = \Configuration::get("group_name")." ".LANG_BLOG;
		$description = LANG_BLOG;
		$link = \Configuration::getUrl()."/public/blog";
		
		// create an rss object
		$rss = new \RssBuilder($title, $description, $link);
		
		// loop through events
		$posts = $this->model->get(1, "Published");
		foreach ($posts as $post) {
			$rss->addElement($post->postName, $post->postContent, $link."/post/".$post->postSlug, $post->postDate);
		}
		
		// and output
		$rss->output();
	
	}
	
	public function index () {
	
		// get a list of posts
		$posts = $this->model->get(1, "Published");
		
		// output page
		$this->engine->assign("posts", $posts);
		$this->engine->display("blog.tpl");
	
	}
	
	/**
	 * Display a specific post
	 */
	public function post () {
	
		// get blog post
		$post = $this->model->getBySlug(\FrontController::getParam(0), false);
		if ($post === false) { throw new \HttpErrorException(404); }
		
		// output page
		$this->engine->assign("post", $post);
		$this->engine->display("blogPost.tpl");
	
	}

}
