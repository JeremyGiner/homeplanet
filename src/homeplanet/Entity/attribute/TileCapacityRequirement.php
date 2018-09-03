<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\City;
use homeplanet\Entity\PawnType;
/**
 * @ORM\Entity
 * @ORM\Table(name="tilecapacityrequirement")
 */
class TileCapacityRequirement {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\PawnType")
	 * @ORM\JoinColumn(name="pawntype_id", referencedColumnName="id")
	 * @var PawnType
	 */
	protected $_oPawnType;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\attribute\TileCapacityType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 * @var TileCapacityType
	 */
	protected $_oType;
	
	/**
	 * @ORM\Column(type="integer", name="quantity")
	 * @var int
	 */
	protected $_iQuantity;
	
	
//_____________________________________________________________________________
//	Cosntructor

	
//_____________________________________________________________________________
//	Accessor
	
	
	public function getPawnType() {
		return $this->_oPawnType;
	}
	
	public function getType() {
		return $this->_oType;
	}
	
	public function getQuantity() {
		return $this->_iQuantity;
	}
	
}