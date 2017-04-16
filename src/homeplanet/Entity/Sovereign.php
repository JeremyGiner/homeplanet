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
 * @ORM\Table(name="sovereign")
 */
class Sovereign {
	
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
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\City")
	 * @ORM\JoinColumn(name="capital", referencedColumnName="id")
	 * @var Entity
	 */
	protected $_oCapital;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\City")
	 * @ORM\JoinTable(
	 *     name="city_sovereign",
	 *     joinColumns={@ORM\JoinColumn(name="sovereign_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="city_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aCity;
	
	
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct( EntityType $oType ) {
		//$this->_iId 
		$this->_oType = $oType;
		$this->_aPosition = new ArrayCollection();
		$this->_aProduction = new ArrayCollection();
		$this->_aDemand = new ArrayCollection();
	}*/
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getCapital() {
		return $this->_oCapital;
	}
	
	/**
	 * @return City[]
	 */
	public function getCityAr() {
		return $this->_aCity->toArray();
	}
	
//_____________________________________________________________________________
//	Modifier
	
	public function addLocation( Location $oLoc ) {
		$this->_aPosition->add( new EntityLocation($this, $oLoc));
	}
	

}