<?php
/**
 * Interface for models.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Core
 */

namespace Framework\Interfaces;

interface iModel {
	public function getById ($id);
}
