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
	
	public function features () {
	
		// check for actions
		if (reqSet("action") == "update") {
			$rv = array (
				$this->model->setOption("feature_members", $_REQUEST["members"]),
				$this->model->setOption("feature_mailing_list", $_REQUEST["mailing_list"]),
				$this->model->setOption("feature_events", $_REQUEST["events"]),
				$this->model->setOption("feature_pages", $_REQUEST["pages"]),
				$this->model->setOption("feature_blog", $_REQUEST["blog"])
			);
			$this->engine->setMessage($this->model->getMessage());
			if (!in_array(false, $rv)) { $this->engine->assign("autoRefresh", true); }
		}
		
		// build a form
		$form = new \FormBuilder();
		$toggle = array ("on" => "On", "off" => "Off");
		$form->addSelect("members", LANG_MEMBERS, $toggle, \Configuration::get("feature_members"));
		$form->addSelect("mailing_list", LANG_MAILING_LIST, $toggle, \Configuration::get("feature_mailing_list"));
		$form->addSelect("events", LANG_EVENTS, $toggle, \Configuration::get("feature_events"));
		$form->addSelect("pages", LANG_PAGES, $toggle, \Configuration::get("feature_pages"));
		$form->addSelect("blog", LANG_BLOG, $toggle, \Configuration::get("feature_blog"));
		$form->addHidden("action", "update");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("config/features.tpl");
	
	}
	
	public function index () {
	
		// check for actions
		if (reqSet("action") == "update") {
			$rv = $this->model->setOption("group_name", $_REQUEST["group_name"]);
			$this->engine->setMessage($this->model->getMessage());
			if ($rv) { $this->engine->assign("autoRefresh", true); }
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
			$rv = $this->model->setOption("language", $_REQUEST["language"]);
			$this->engine->setMessage($this->model->getMessage());
			if ($rv) { $this->engine->assign("autoRefresh", true); }
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
	
	public function preferences () {
	
		// build an object
		$auth = \Authorisation::getInstance();
		
		// check for actions
		if (reqSet("action") == "update") {
		
			require_once("models/MembersModel.php");
			$membersModel = new \MembersModel();
			
			$member = $membersModel->getById($auth->getID());
			$member->setAdminStyle(reqSet("style"));
			$membersModel->save($member);
			
			$rv = $auth->setAdminStyle(reqSet("style"));
			
			$this->engine->setMessage($this->model->getMessage());
			if ($rv) { $this->engine->assign("autoRefresh", true); }
		
		}
		
		// build an array of options
		$options = array (
			0 => LANG_DEFAULT,
			1 => LANG_HIGH_CONTRAST
		);
		
		// build a form
		$form = new \FormBuilder();
		$form->addSelect("style", LANG_STYLE, $options, $auth->getAdminStyle());
		$form->addHidden("action", "update");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("config/preferences.tpl");
	
	}

}
