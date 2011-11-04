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
			$this->model->write($_REQUEST);
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
	
		// get a front controller
		$front = FrontController::getInstance();
		
		// check for actions
		if (reqSet("action") == "edit") {
			$this->model->write($_REQUEST, $front->getParam(0));
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// get the object
		$post = $this->model->getById($front->getParam(0));
		
		// output page
		$this->engine->assign("form", $this->standardForm("edit", $post->getAllData()));
		$this->engine->display("blog/edit.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "mass") {
			if ($info = $this->determineMassAction()) {
				switch ($info["action"]) {
					case "delete":
						$this->model->deleteById($info["ids"]);
						break;
				}
			}
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// output page
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
