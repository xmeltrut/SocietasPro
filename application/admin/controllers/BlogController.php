<?php
/**
 * Blog administration.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class BlogController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/BlogPostsModel.php");
		$this->model = new BlogPostsModel();
	
	}
	
	/**
	 * Create a new blog post
	 */
	public function create () {
	
		// check actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["name"], $_REQUEST["slug"], $_REQUEST["date"], $_REQUEST["content"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("create"));
		$this->engine->display("blog/create.tpl");
	
	}
	
	/**
	 * Edit an event
	 */
	public function edit () {
	
		// get the object
		$front = FrontController::getInstance();
		$post = $this->model->getById($front->getParam(0));
		
		// check for actions
		if (reqSet("action") == "edit") {
			$post->setName($_REQUEST["name"]);
			$post->setSlug($_REQUEST["slug"]);
			$post->setDateByArray($_REQUEST["date"]);
			$post->setContent($_REQUEST["content"]);
			$this->model->save($post);
		}
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $post->getAllData()));
		$this->engine->display("blog/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		$posts = $this->model->get();
		$this->engine->assign("posts", $posts);
		$this->engine->display("blog/index.tpl");
	
	}
	
	/**
	 * Create a standard form for editing posts
	 *
	 * @param string $action Form variable
	 * @param array $data Default values
	 */
	private function standardForm ($action, $data = array()) {
	
		require_once("classes/FormBuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("name", LANG_NAME, arrSet($data, "postName"));
		$form->addInput("slug", LANG_URL, arrSet($data, "postSlug"));
		$form->addDateTime("date", LANG_DATE, arrSet($data, "postDate"));
		$form->addVisualEditor("content", arrSet($data, "postContent"));
		$form->addHidden("id", arrSet($data, "postID"));
		$form->addHidden("action", $action);
		$form->addSubmit();
		
		return $form->build();
	
	}

}
