<?php
/**
 * Mailing list controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Generate function should look at members' emails too
 * @todo Convert to use instance variable model
 */

class MailinglistController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Generate a list of subscribers
	 */
	public function generate () {
	
		// get a subscribers model
		include_once("models/SubscriberModel.php");
		$subscriberModel = new SubscriberModel();
		
		// create a list
		$subscribers = $subscriberModel->getAsArray();
		$subscriberList = implode("; ", $subscribers);
		
		// output page
		$this->engine->assign("subscribers", $subscriberList);
		$this->engine->display("mailinglist/generate.tpl");
	
	}
	
	/**
	 * Default page
	 */
	public function index () {
	
		// create a subscriber model
		include_once("models/SubscriberModel.php");
		$subscriberModel = new SubscriberModel();
		
		// check for actions
		if (reqSet("action") == "create") {
			$subscriberModel->create($_REQUEST["email"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		} elseif (reqSet("action") == "delete") {
			$subscriberModel->deleteById($_REQUEST["id"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		} elseif (reqSet("action") == "deleteByEmail") {
			$subscriberModel->deleteByEmail($_REQUEST["email"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		}
		
		// get list of recent subscribers
		$recent = $subscriberModel->get();
		$this->engine->assign("recent", $recent);
		
		// output the page
		$this->engine->display("mailinglist/index.tpl");
	
	}

}
