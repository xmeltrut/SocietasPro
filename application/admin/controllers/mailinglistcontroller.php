<?php
/**
 * Mailing list controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Generate function should look at members' emails too
 */

class MailinglistController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Generate a list of subscribers
	 */
	public function generate () {
	
		$subscribers = $subscriberModel->getAsArray();
		
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
			$subscriberModel->deleteByEmail($_REQUEST["email"]);
			$this->engine->assign("msg", $subscriberModel->getMessage());
		}
		
		// output the page
		$this->engine->display("mailinglist/index.tpl");
	
	}

}
