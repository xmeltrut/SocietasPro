<?php
/**
 * Send an email
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class Mailer {

	private $sender;
	private $recipients;
	private $subject;
	private $body;
	
	/**
	 * Add a recipient (or multiple recipients)
	 *
	 * @param string $value Email address
	 * @return boolean Success
	 */
	public function addRecipient ($value) {
		if (is_string($value)) {
			$this->recipients[] = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Get the default sender address
	 *
	 * @return string Default address
	 */
	private function getDefaultSender () {
	
		$addr = Configuration::get("group_name")." <mail-daemon@".$_SERVER["SERVER_NAME"].">";
		return $addr;
	
	}
	
	/**
	 * Send the email
	 *
	 * @return boolean Success
	 */
	public function send () {
	
		// check recipients
		if (!is_array($this->recipients)) {
			return false;
		} elseif (count($this->recipients) < 1) {
			return false;
		}
		
		// one day this will be a factory
		return $this->sendViaPhp();
	
	}
	
	/**
	 * Send the email using PHP's mail function
	 *
	 * @return boolean Success
	 */
	private function sendViaPhp () {
	
		// build information
		$recipients = implode(",", $this->recipients);
		
		// build headers
		$sender = ($this->sender != "") ? $this->sender : $this->getDefaultSender();
		$headers  = "From: " . $sender . "\r\n";
		$headers .= "X-Mailer: PHP/";
		
		// send email
		return mail($recipients, $this->subject, $this->body, $headers);
	
	}
	
	/**
	 * Set the body
	 *
	 * @param string $value Body
	 * @return boolean Success
	 */
	public function setBody ($value) {
		$this->body = $value;
		return true;
	}
	
	/**
	 * Set the sender
	 *
	 * @param string $value Sender
	 * @return boolean Success
	 */
	public function setSender ($value) {
		$this->sender = $value;
		return true;
	}
	
	/**
	 * Set the subject
	 *
	 * @param string $value Subject
	 * @return boolean Success
	 */
	public function setSubject ($value) {
		$this->subject = $value;
		return true;
	}

}
