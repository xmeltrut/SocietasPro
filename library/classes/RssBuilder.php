<?php
/**
 * RSS Builder. Use this to build an RSS feed.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class RssBuilder {

	/**
	 * Information variables
	 */
	private $title;
	private $description;
	private $link;
	private $channel = array();
	
	/**
	 * Constructor
	 *
	 * @param string $title Title
	 * @param string $description Description
	 * @param string $link Link
	 */
	public function __construct ($title, $description, $link) {
	
		$this->title = $title;
		$this->description = $description;
		$this->link = $link;
	
	}
	
	/**
	 * Add element
	 *
	 * @param string $title Title
	 * @param string $description Description
	 * @param string $link Link
	 * @param string $date PubDate
	 * @return boolean Success
	 */
	public function addElement ($title, $description, $link, $date) {
	
		// validate inputs
		if ($title == "") {					return false;	}
		if ($description == "") {			return false;	}
		if ($link == "") {					return false;	}
		if (strtotime($date) == false) {	return false;	}
		
		// add to data array
		$this->channel[] = array (
			"title" => htmlentities($title, ENT_QUOTES),
			"description" => htmlentities($description, ENT_QUOTES),
			"link" => $link,
			"pubDate" => date("r", strtotime($date))
		);
		
		return true;
	
	}
	
	/**
	 * Build and output the XML
	 */
	public function output () {
	
		// create an object
		$doc = new DOMDocument("1.0", "utf-8");
		$doc->formatOutput = true;
		
		// build root element
		$rss = $doc->createElement("rss");
		$doc->appendChild($rss);
		
		// add version
		$version = $doc->createAttribute("version");
		$version->appendChild($doc->createTextNode("2.0"));
		$rss->appendChild($version);
		
		// add namespace
		$content = $doc->createAttribute("xmlns:content");
		$content->appendChild($doc->createTextNode("http://purl.org/rss/1.0/modules/content/"));
		$rss->appendChild($content);
		
		// add channel element
		$channel = $doc->createElement("channel");
		$rss->appendChild($channel);
		
		// add channel information
		$title = $doc->createElement("title");
		$title->appendChild($doc->createTextNode($this->title));
		$channel->appendChild($title);
		
		$description = $doc->createElement("description");
		$description->appendChild($doc->createTextNode($this->description));
		$channel->appendChild($description);
		
		$link = $doc->createElement("link");
		$link->appendChild($doc->createTextNode($this->link));
		$channel->appendChild($link);
		
		$copyright = $doc->createElement("copyright");
		$copyright->appendChild($doc->createTextNode("(C) ".date("Y")." ".Configuration::get("group_name")));
		$channel->appendChild($copyright);
		
		// loop through elements
		foreach ($this->channel as $entry) {
		
			$item = $doc->createElement("item");
			
			$title = $doc->createElement("title");
			$title->appendChild($doc->createTextNode($entry["title"]));
			$item->appendChild($title);
			
			$description = $doc->createElement("description");
			$description->appendChild($doc->createTextNode($entry["description"]));
			$item->appendChild($description);
			
			$link = $doc->createElement("link");
			$link->appendChild($doc->createTextNode($entry["link"]));
			$item->appendChild($link);
			
			$pubDate = $doc->createElement("pubDate");
			$pubDate->appendChild($doc->createTextNode($entry["pubDate"]));
			$item->appendChild($pubDate);
			
			$channel->appendChild($item);
		
		}
		
		// output end result
		header("Content-type: text/xml\n\n");
		echo($doc->saveXML());
	
	}

}
