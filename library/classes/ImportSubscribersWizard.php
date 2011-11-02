<?php
/**
 * Import subscribers into the mailing list.
 *
 * There doesn't seem much point in this being a class at the moment, it could
 * just be a function, but eventually it may be more advanced and therefore
 * justifiably a class.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 *
 * @todo This needs to give feedback on how many imports were successful
 */

class ImportSubscribersWizard {

	/**
	 * Import subscribers
	 *
	 * @param string $data List of data
	 */
	public function import ($data) {
	
		// let's perform some basic conversion
		$data = str_replace("\r", "", $data);
		$data = str_replace("\n", ";", $data);
		$data = str_replace(",", ";", $data);
		
		// now explode on semi colons
		$subscribers = explode(";", $data);
		
		// create a subscribers model
		require_once("models/SubscribersModel.php");
		$subscribersModel = new SubscribersModel();
		
		// loop through entries
		foreach ($subscribers as $subscriber) {
			$subscriber = trim($subscriber);
			$subscribersModel->create($subscriber);
		}
	
	}

}
