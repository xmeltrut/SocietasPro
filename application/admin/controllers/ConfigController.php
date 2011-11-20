<?php
/**
 * Manage the configuration of your install.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace admin;

class ConfigController extends \BaseController implements \iController {

	private $model;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/ConfigModel.php");
		$this->model = new \ConfigModel();
	
	}
	
	public function index () {
	
		// check for actions
		if (reqSet("action") == "update") {
			$this->model->setOption("group_name", $_REQUEST["group_name"]);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// build a form
		$form = new \FormBuilder();
		$form->addInput("group_name", LANG_GROUP." ".strtolower(LANG_NAME), \Configuration::get("group_name"));
		$form->addHidden("action", "update");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("config/index.tpl");
	
	}
	
	public function language () {
	
		// check for actions
		if (reqSet("action") == "update") {
			$this->model->setOption("language", $_REQUEST["language"]);
			$this->engine->setMessage($this->model->getMessage());
		}
		
		// get a list of languages
		$language = \Language::getInstance();
		$list = $language->listAsArray();
		
		// build a form
		$form = new \FormBuilder();
		$form->addSelect("language", LANG_LANGUAGE, $list, \Configuration::get("language"));
		$form->addHidden("action", "update");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("config/language.tpl");
	
	}

}
