<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;

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