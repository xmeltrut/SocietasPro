<?php
/**
 * Mailing list controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace admin;

class MailinglistController extends \BaseController implements \iController {

	private $instance;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		require_once("models/SubscribersModel.php");
		$this->model = new \SubScribersModel();
	
	}
	
	/**
	 * Export as CSV
	 */
	public function csv () {
	
		// csv object
		$csv = new \CsvBuilder(LANG_MAILING_LIST);
		
		// get an array of members
		$subscribers = $this->model->getAsArray();
		
		// begin output
		$csv->addRow(array(LANG_EMAIL));
		
		// loop through subscribers
		foreach ($subscribers as $subscriber) {
			$data = array (
				$subscriber
			);
			$csv->addRow($data);
		}
		
		// log as an action in the audit trail
		auditTrail(13);
		
		// output the result
		$csv->output();
	
	}
	
	/**
	 * Generate a list of subscribers
	 */
	public function generate () {
	
		// create a members model
		require_once("models/MembersModel.php");
		$membersModel = new \MembersModel();
		
		// create a list
		$subscribers = $this->model->getAsArray();
		$members = $membersModel->getEmailsAsArray();
		$all = array_merge($subscribers, $members);
		$all = array_unique($all);
		
		$subscriberList = implode("; ", $all);
		
		// output page
		$this->engine->assign("subscribers", $subscriberList);
		$this->engine->display("mailinglist/generate.tpl");
	
	}
	
	/**
	 * Mass import members
	 */
	public function import () {
	
		// check for actions
		if (reqSet("action") == "import") {
		
			$wizard = new \ImportSubscribersWizard();
			
			if ($_REQUEST["emails"] != "") {
				$result = $wizard->import($_REQUEST["emails"]);
			} elseif ($_FILES["upload"]["size"] > 0) {
				$result = $wizard->import(file_get_contents($_FILES["upload"]["tmp_name"]));
			}
			
			if (isset($result)) {
				$this->engine->assign("msg", $result);
			}
		
		}
		
		// build a form
		$form = new \FormBuilder();
		$form->addTextArea("emails", LANG_SUBSCRIBERS);
		$form->addFile("upload", LANG_FILE);
		$form->addHidden("action", "import");
		$form->addSubmit();
		$form->setDefaultElement("emails");
		
		// output page
		$this->engine->assign("form", $form->build());
		$this->engine->display("mailinglist/import.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["email"]);
			$this->engine->assign("msg", $this->model->getMessage());
		} elseif (reqSet("action") == "delete") {
			$this->model->deleteById($_REQUEST["id"]);
			$this->engine->assign("msg", $this->model->getMessage());
		} elseif (reqSet("action") == "deleteByEmail") {
			$this->model->deleteByEmail($_REQUEST["email"]);
			$this->engine->assign("msg", $this->model->getMessage());
		}
		
		// get list of recent subscribers
		$recent = $this->model->get();
		$this->engine->assign("recent", $recent);
		
		// output the page
		$this->engine->display("mailinglist/index.tpl");
	
	}

}
