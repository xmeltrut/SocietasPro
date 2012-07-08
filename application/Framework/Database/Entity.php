<?php
/**
 * Base class for entities to extend from
 *
 * @author Chris Worfolk <chris@societaspro.org>
 */

namespace Framework\Database;

abstract class Entity {

	/**
	 * Get a property
	 *
	 * @param string $name Name
	 *
	 * @return mixed
	 */
	public function __get ($name) {
		if(property_exists($this, $name)){
			return $this->$name;
		}
	}
	
	/**
	 * Set a property
	 *
	 * @param string $name  Name
	 * @param mixed  $value Value
	 *
	 * @return void
	 */
	public function __set ($name, $value) {
		if(property_exists($this, $name)){
			$this->$name = $value;
		}
	}

}
