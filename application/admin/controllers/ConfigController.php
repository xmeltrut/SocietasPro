<?php
/**
 * Manage the configuration of your install.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class ConfigController extends BaseController implements iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		include_once("models/ConfigModel.php");
		$this->model = new ConfigModel();
	
	}
	
	public function index () {
	
		$this->engine->display("config/index.tpl");
	
	}
	
	public function language () {
	
		// check for actions
		if (reqSet("action") == "update") {
			$this->model->setOption("language", $_REQUEST["language"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// get a list of languages
		$language = Language::getInstance();
		$list = $language->listAsArray();
		
		// build a form
		require_once("formbuilder.php");
		$form = new FormBuilder();
		$form->addSelect("language", LANG_LANGUAGE, $list, Configuration::get("language"));
		$form->addHidden("action", "update");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("config/language.tpl");
	
	}

}
