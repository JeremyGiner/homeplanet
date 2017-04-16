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
 * @ORM\Table(name="influence")
 */
class Influence {
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\City")
	 * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
	 * @var City
	 */
	protected $_oCity;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Sovereign")
	 * @ORM\JoinColumn(name="sovereign_id", referencedColumnName="id")
	 * @var Sovereign
	 */
	protected $_oSovereign;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\InfluenceType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 * @var InfluenceType
	 */
	protected $_oType;
	
	/**
	 * @ORM\Column(type="integer", name="value")
	 * @var int
	 */
	protected $_iValue;
	
//_____________________________________________________________________________
//	Constructor
	
	
//_____________________________________________________________________________
//	Accessor
	
	public function getCity() {
		return $this->_oCity;
	}
	
	public function getSovereign() {
		return $this->_oSovereign;
	}
	public function getType() {
		return $this->_oType;
	}
	public function getValue() {
		return $this->_iValue;
	}
	
	
	
//_____________________________________________________________________________
//	Modifier
	
	
	

}