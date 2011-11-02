<?php
/**
 * Mailing list controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class MailinglistController extends BaseController implements iController {

	private $instance;
	
	function __construct () {
	
		parent::__construct();
		
		// create a model
		include_once("models/SubscribersModel.php");
		$this->model = new SubScribersModel();
	
	}
	
	/**
	 * Export as CSV
	 */
	public function csv () {
	
		// csv object
		require_once("csvbuilder.php");
		$csv = new CsvBuilder(LANG_MAILING_LIST);
		
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
		
		// output the result
		$csv->output();
	
	}
	
	/**
	 * Generate a list of subscribers
	 */
	public function generate () {
	
		// create a members model
		require_once("models/MembersModel.php");
		$membersModel = new MembersModel();
		
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
	 * Default page
	 */
	public function index () {
	
		// check for actions
		if (reqSet("action") == "create") {
			$this->model->create($_REQUEST["email"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		} elseif (reqSet("action") == "delete") {
			$this->model->deleteById($_REQUEST["id"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		} elseif (reqSet("action") == "deleteByEmail") {
			$this->model->deleteByEmail($_REQUEST["email"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		}
		
		// get list of recent subscribers
		$recent = $this->model->get();
		$this->engine->assign("recent", $recent);
		
		// output the page
		$this->engine->display("mailinglist/index.tpl");
	
	}

}
