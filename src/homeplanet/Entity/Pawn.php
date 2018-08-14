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
use homeplanet\Entity\attribute\PawnLocation;

/**
 * @ORM\Entity(repositoryClass="homeplanet\Repository\PawnRepository")
 * @ORM\Table(name="pawn")
 */
class Pawn {
	
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
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Player")
	 * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
	 * @var Player
	 */
	protected $_oPlayer;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\PawnType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 * @var PawnType
	 */
	protected $_oType;
	
	/**
	 * @ORM\Column(type="integer", name="grade")
	 */
	protected $_iGrade;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="homeplanet\Entity\Character",
	 *     mappedBy="_oWorkplace",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aWorker;
	
//_____________________________________
//	Attribute
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="homeplanet\Entity\attribute\PawnLocation",
	 *     mappedBy="_oPawn",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aPosition;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="homeplanet\Entity\attribute\Production",
	 *     mappedBy="_oPawn",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aProduction;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( PawnType $oType ) {
		//$this->_iId 
		$this->_oType = $oType;
		$this->_aPosition = new ArrayCollection();
		$this->_aProduction = new ArrayCollection();
		$this->_aDemand = new ArrayCollection();
		
		$this->_iGrade = 1;
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
	
	public function getPlayer() {
		return $this->_oPlayer;
	}
	
	public function getGrade() {
		return $this->_iGrade;
	}
	/**
	 * @return PawnLocation[]
	 */
	public function getPawnLocationAr() {
		return $this->_aPosition->toArray();
	}
	/**
	 * @return Location[]
	 */
	public function getLocationAr() {
		$a = [];
		foreach ( $this->getPawnLocationAr() as $oPawnLocation ) {
			$a[] = $oPawnLocation->getLocation();
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
	
	public function getAttribute( $s ) {
		return $this->_oType->getAttribute( $s );
	}
	
	
//_____________________________________________________________________________
//	Modifier

	public function setPlayer( Player $oPlayer = null ) {
		$this->_oPlayer = $oPlayer;
		return $this;
	}
	
	public function addLocation( Location $oLoc ) {
		$this->_aPosition->add( new PawnLocation($this, $oLoc));
		return $this;
	}
	
	public function resetLocation() {
		
		$this->_aPosition->clear();
		
		return $this;
	}
	
	public function addProduction( Production $oProd ) {
		$this->_aProduction->add( $oProd );
		return $this;
	}
	
	public function upgrade() {
		$this->_iGrade++;
		return $this;
	}

}