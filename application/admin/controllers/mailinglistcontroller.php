<?php
/**
 * Mailing list controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class MailinglistController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Add a new subscriber
	 */
	public function create () {
	
		// build the form
		require("formbuilder.php");
		
		$form = new FormBuilder();
		$form->addInput("email", LANG_EMAIL);
		$form->addHidden("action", "create");
		$form->addSubmit();
		
		// output the page
		$this->engine->assign("form", $form->build());
		$this->engine->display("mailinglist/create.tpl");
	
	}
	
	/**
	 * Delete a subscriber based on their email address
	 *
	 * @param string $email Email address
	 * @return boolean Success
	 */
	public function deleteByEmail ($email) {
	
	public function index () {
	
		$this->engine->display("mailinglist/index.tpl");
	
	}

}
