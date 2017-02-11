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
 * @ORM\Table(name="entity")
 */
class Entity {
	
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 * @var User
	 */
	protected $_oUser;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\EntityType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 * @var EntityType
	 */
	protected $_oType;
	
//_____________________________________
//	Attribute
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="\homeplanet\Entity\attribute\EntityLocation",
	 *     mappedBy="_oEntity",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aPosition;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="\homeplanet\Entity\attribute\Production",
	 *     mappedBy="_oEntity",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aProduction;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( EntityType $oType ) {
		//$this->_iId 
		$this->_oType = $oType;
		$this->_aPosition = new ArrayCollection();
		$this->_aProduction = new ArrayCollection();
		$this->_aDemand = new ArrayCollection();
		/*
		foreach ( $this->_oType->getAttributeDefault( $this, 'production' ) as $oProd )
			$this->_aProduction->add( $oProd );
		
		
		$this->_oAttributeDef = [
			[  ]	
		];*/
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getType() {
		return $this->_oType;
	}
	
	public function getUser() {
		return $this->_oUser;
	}
	/**
	 * @return EntityLocation[]
	 */
	public function getEntityLocationAr() {
		return $this->_aPosition->toArray();
	}
	/**
	 * @return Location[]
	 */
	public function getLocationAr() {
		$a = [];
		foreach ( $this->getEntityLocationAr() as $oEntityLocation ) {
			$a[] = $oEntityLocation->getLocation();
		}
		return $a;
	}
	
	/**
	 * @return Production[]
	 */
	public function getProductionAr() {
		return $this->_aProduction->toArray();
	}
	
	public function getDemandAr() {
		return $this->_aDemand;
	}
	
	public function getPopulation() {
		return $this->_oPopulation;
	}
	
	
//_____________________________________________________________________________
//	Modifier

	public function setUser( User $oUser = null ) {
		$this->_oUser = $oUser;
		return $this;
	}
	
	public function addLocation( Location $oLoc ) {
		$this->_aPosition->add( new EntityLocation($this, $oLoc));
	}
	
	public function addProduction( Production $oProd ) {
		$this->_aProduction->add( $oProd );
	}

}