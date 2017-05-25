<?php
namespace homeplanet\Entity\attribute;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Tile;

/**
 * @ORM\Entity
 * @ORM\Table(name="prod")
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
	
//_____________________________________________________________________________
//	Constructor
	
	function __construct( 
			Pawn $oPawn, 
			Location $oLocation, 
			ProductionType $oProdType
	) {
		$this->_oPawn = $oPawn;
		$this->_iLocationX = $oLocation->getX();
		$this->_iLocationY = $oLocation->getY();
		$this->_oProdType = $oProdType;
		
		$this->_fRatioMax = 0;
		
		$this->_aProdInput = new ArrayCollection();
		
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
		return $this->getType()->getQuantity()*$this->getRatioMax();
	}
	
	public function isSeller() {
		// True if produce credit
		return $this->getType()->getRessource()->getId() == 1;
	}
	
	public function isBuyer() {
		// True if firt produce input is credit
		$first = $this->_aProdInput->first();
		
		if( $first === null )
			return false;
		return $first->getType()->getRessource()->getId() == 1;
	}
	
	public function isTransporter() {
		$first = $this->_aProdInput->first();
		
		if( $first === null )
			return false;
		
		return $this->getType()->getRessource()->getId() == $first->getType()->getRessource()->getId();
	}
	
//______________________________________________________________________________
//	Modifier
	
	public function setRatio( $f ) {
		$this->_fRatioMax = $f;
		return $this;
	}
	
}