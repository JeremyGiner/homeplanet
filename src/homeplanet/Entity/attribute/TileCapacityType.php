<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\City;
use homeplanet\Entity\PawnType;

/**
 * @ORM\Entity
 * @ORM\Table(name="tilecapacitytype")
 */
class TileCapacityType {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 */
	protected $_sLabel;
	
//_____________________________________________________________________________
//	Cosntructor
	
	
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	public function getLabel() {
		return $this->_sLabel;
	}
	
}