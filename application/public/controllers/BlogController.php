<?php
/**
 * Bog posts
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Public
 */

class BlogController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/BlogPostsModel.php");
		$this->model = new BlogPostsModel();
	
	}
	
	public function index () {
	
		// get a list of posts
		$posts = $this->model->get();
		
		print_r($posts);
		
		echo("<hr />");
		
		$post = $posts[0];
		echo($post->postName);
		
		$this->engine->assign("posts", $posts);
		
		$this->engine->display("blog.tpl");
	
	}

}
