<?php
/**
 * Location entity
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Entities;

use Framework\Database\Entity;

/**
 * @Entity
 * @Table(name="tbl_locations")
 */
class Location extends Entity {

	/** @Id @Column(name="locationID", type="integer") @GeneratedValue **/
	protected $id;
	
	/** @Column(name="locationName", type="string") **/
	protected $name;
	
	/** @Column(name="locationDescription", type="text") **/
	protected $description;

}
