<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Population;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\EntityLocation;

/**
 * @ORM\Entity
 * @ORM\Table(name="relationship")
 */
class Relationship {
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Player")
	 * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
	 * @var Player
	 */
	protected $_oPlayer;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Sovereign")
	 * @ORM\JoinColumn(name="sovereign_id", referencedColumnName="id")
	 * @var Sovereign
	 */
	protected $_oSovereign;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\RelationshipType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 * @var RelationshipType
	 */
	protected $_oType;
	
//_____________________________________________________________________________
//	Accessor
	
	public function getPlayer() {
		return $this->_oPlayer;
	}
	
	public function getSovereign() {
		return $this->_oSovereign;
	}
	
	public function getType() {
		return $this->_oType;
	}
	

}