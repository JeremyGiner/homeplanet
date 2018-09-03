<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\attribute\Location;

/**
 * @ORM\Table(name="tilecapacityovercrowd")
 * @ORM\Entity(repositoryClass="homeplanet\Repository\TileCapacityOvercrowdRepository")
 */
class TileCapacityOvercrowd {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="type_id")
	 */
	protected $_iTypeId;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="location_x")
	 */
	protected $_iLocationX;
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="location_y")
	 */
	protected $_iLocationY;
	
	/**
	 * @ORM\Column(type="integer", name="quantity")
	 */
	protected $_iQuantity;
	
//_____________________________________________________________________________
//	Accessor
	
	public function getQuantity() {
		return $this->_iQuantity;
	}

	public function getTypeId() {
		return $this->_iRessourceId;
	}
	
	public function getLocation() {
		return new Location($this->_iLocationX, $this->_iLocationY);
	}
}