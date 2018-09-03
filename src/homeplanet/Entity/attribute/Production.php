<?php
namespace homeplanet\Entity\attribute;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\Pawn;

/**
 * Note : production percent is updated using MySQL proc "prod_update_single" 
 * 
 * @ORM\Entity(repositoryClass="homeplanet\Repository\ProductionRepository")
 * @ORM\Table(name="prod")
 * ###ORM\EntityListeners({"homeplanet\EventListener\ProductionListener"})
 */
class Production {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	protected $_iId;
	
	/**
	 * @ORM\ManyToOne(
	 *     targetEntity="homeplanet\Entity\Pawn",
	 *     inversedBy="_aProduction"
	 * )
	 * @ORM\JoinColumn(name="pawn_id", referencedColumnName="id")
	 * @var Pawn
	 */
	protected $_oPawn;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\attribute\ProductionType")
	 * @ORM\JoinColumn(name="prodtype_id", referencedColumnName="id")
	 * @var ProductionType
	 */
	protected $_oProdType;
	
	/**
	 * @ORM\Column(type="integer", name="location_x")
	 * @var int
	 */
	protected $_iLocationX;
	
	/**
	 * @ORM\Column(type="integer", name="location_y")
	 * @var int
	 */
	protected $_iLocationY;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="\homeplanet\Entity\attribute\ProductionInput",
	 *     mappedBy="_oProd",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aProdInput;
	
	/**
	 * @ORM\Column(type="float", name="percent_max")
	 * @var float
	 */
	protected $_fRatioMax;
	
	/**
	 * @ORM\Column(type="integer", name="grade")
	 * @var int
	 */
	protected $_iGrade;

	
//_____________________________________________________________________________
//	Constructor
	
	function __construct( 
			Pawn $oPawn, 
			Location $oLocation, 
			ProductionType $oProdType,
			$iGrade = null
	) {
		$this->_oPawn = $oPawn;
		$this->_iLocationX = $oLocation->getX();
		$this->_iLocationY = $oLocation->getY();
		$this->_oProdType = $oProdType;
		
		$this->_fRatioMax = 0;
		
		$this->_aProdInput = new ArrayCollection();
		
		$this->_iGrade = ( is_null($iGrade) ) ? $oPawn->getGrade() : $iGrade;
	}
	
	static public function create(
			Pawn $oPawn,
			Location $oLocation,
			ProductionType $oProdType
	) {
		$o = new Production($oPawn, $oLocation, $oProdType);
		foreach( $oProdType->getProdInputTypeAr() as $oProdInputType ) {
			$o->_aProdInput->add(
					new ProductionInput(
							$o,
							$oLocation,
							$oProdInputType
					)
			);
		
		}
		return $o;
	}
	static public function createTransport(
			Pawn $oPawn,
			Location $oLocationBegin,
			Location $oLocationEnd,
			ProductionType $oProdType
	) {
		$o = new Production($oPawn, $oLocationEnd, $oProdType );
		foreach( $oProdType->getProdInputTypeAr() as $oProdInputType ) {
			$o->_aProdInput->add(
					new ProductionInput(
							$o,
							$oLocationBegin,
							$oProdInputType
					)
			);
	
		}
		
		return $o;
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	public function getLocation() {
		return new Location( $this->_iLocationX, $this->_iLocationY );
	}
	public function getPawn() {
		return $this->_oPawn;
	}
	public function getType() {
		return $this->_oProdType;
	}
	public function getGrade() {
		return $this->_iGrade;
	}
	
	public function getRatio() {
		return $this->getRatioMax();
	}
	public function getRatioMax() {
		return $this->_fRatioMax;
	}
	
	/**
	 * @return ProductionInput[]
	 */
	public function getProdInputAr() {
		return $this->_aProdInput;
	}
	
	public function getQuantity() {
		return $this->getType()->getQuantity()
			* $this->getRatioMax()
			//* $this->getGrade()
		;
	}
	
	public function isSeller() {
		// True if produce credit
		return $this->getType()->getRessource()->getId() == 1;
	}
	
	public function isBuyer() {
		// True if firt input is credit
		$first = $this->_aProdInput->first();
		
		if( $first === false )
			return false;
		return $first->getType()->getRessource()->getId() == 1;
	}
	
	public function isTransporter() {
		$first = $this->_aProdInput->first();
		
		if( $first === false )
			return false;
		
		return $this->getType()->getRessource()->getId() == $first->getType()->getRessource()->getId();
	}
	
	public function isHarvester() {
		// True if firt input is natural deposit
		$first = $this->_aProdInput->first();
		
		if( $first === false )
			return false;
		
		return $first->getType()->getRessource()->isNatural();
	}
	
//______________________________________________________________________________
//	Modifier
	
	public function setRatio( $f ) {
		if( !$this->isHarvester() )
			throw new \Exception('non-harvester is getting set ratio');
		
		$this->_fRatioMax = min( $this->getGrade(), $f);
		return $this;
	}
	
	public function setGrade( $i ) {
		$this->_iGrade = $i;
		$this->_fRatioMax = 0;
		return $this;
	}
	
}