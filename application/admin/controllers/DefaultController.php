<?php
/**
 * This is the default page for the admin panel
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

class DefaultController extends BaseController implements iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Control panel
	 */
	public function index () {
	
		// get a database object
		$db = Database::getInstance();
		
		// set variables
		$this->engine->assign("total_members", $db->fetchOne("SELECT COUNT(memberID) FROM ".DB_PREFIX."members"));
		$this->engine->assign("total_subscribers", $db->fetchOne("SELECT COUNT(subscriberID) FROM ".DB_PREFIX."subscribers"));
		
		// output age
		$this->engine->display("default/index.tpl");
	
	}
	
	/**
	 * Get a JSON string of our recent tweets
	 */
	public function tweets () {
	
		// get the tweets
		require_once("twitter/TwitterTimeline.php");
		$timeline = new TwitterTimeline("SocietasPro");
		$tweets = $timeline->get();
		
		// output page
		$this->engine->assign("tweets", $tweets);
		$this->engine->display("default/tweets.tpl");
	
	}

}
