<?php
/**
 * This is the default page for the admin panel
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

namespace Controllers;

use Framework\Core\Controller;
use Framework\Database\Database;
use Framework\Utilities\RemoteRequest;
use Framework\Core\Kernel;
use Framework\Twitter\TwitterTimeline;

class DefaultController extends Controller {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Control panel
	 */
	public function index ($request) {
	
		// get a database object
		$db = Database::getInstance();
		
		// set variables
		$this->engine->assign("total_members", $db->fetchOne("SELECT COUNT(memberID) FROM ".DB_PREFIX."members"));
		$this->engine->assign("total_subscribers", $db->fetchOne("SELECT COUNT(subscriberID) FROM ".DB_PREFIX."subscribers"));
		$this->engine->assign("total_events", $db->fetchOne("SELECT COUNT(eventID) FROM ".DB_PREFIX."events"));
		$this->engine->assign("total_pages", $db->fetchOne("SELECT COUNT(pageID) FROM ".DB_PREFIX."pages"));
		$this->engine->assign("total_blog_posts", $db->fetchOne("SELECT COUNT(postID) FROM ".DB_PREFIX."blog_posts"));
		
		// output age
		$this->engine->display("default/index.tpl");
	
	}
	
	/**
	 * Get a JSON string of our recent tweets
	 */
	public function tweets () {
	
		// get the tweets
		$timeline = new TwitterTimeline("SocietasPro");
		$tweets = $timeline->get();
		
		// output page
		$this->engine->assign("tweets", $tweets);
		$this->engine->display("default/tweets.tpl");
	
	}
	
	/**
	 * Check version
	 */
	public function version () {
	
		// make a curl request
		$request = new RemoteRequest("http://www.societaspro.org/api");
		$request->setParam("action", "get_latest_version");
		$request->setParam("format", "json");
		
		if ($request->send()) {
		
			// get response
			$response = $request->getResponse();
			
			if ($responseArray = json_decode($response, true)) {
			
				// get version
				$latestVersion = $responseArray["version"];
				
				if ($latestVersion != Kernel::VERSION) {
				
					$this->engine->assign("latest_version", $latestVersion);
					$this->engine->assign("version_information", \Language::getContent("version_information"));
					$this->engine->display("default/version.tpl");
				
				}
			
			}
		
		}
	
	}

}
