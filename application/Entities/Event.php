<?php
/**
 * Event entity
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Entities;

use Framework\Database\Entity;

/**
 * @Entity
 * @Table(name="tbl_events")
 */
class Event extends Entity {

	/** @Id @Column(name="eventID", type="integer") @GeneratedValue **/
	protected $id;
	
	/** @Column(name="eventName", type="string") **/
	protected $name;
	
	/**
	 * @ManyToOne(targetEntity="Location", fetch="EAGER")
	 * @JoinColumn(name="eventLocation", referencedColumnName="locationID")
	 */
	protected $location;
	
	/** @Column(name="eventDate", type="datetime") **/
	protected $date;
	
	/** @Column(name="eventDescription", type="text") **/
	protected $description;
	
	/**
	 * Return a formatted date
	 *
	 * @return Formatted date
	 */
	public function getFormattedDate () {
		return $this->date->format("j F Y H:i:s");
	}

}
