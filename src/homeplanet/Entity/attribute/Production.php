<?php
namespace homeplanet\Entity\attribute;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Entity;
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
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Entity")
	 * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
	 * @var ProductionType
	 */
	protected $_oEntity;
	
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
			Entity $oEntity, 
			Location $oLocation, 
			ProductionType $oProdType
	) {
		$this->_oEntity = $oEntity;
		$this->_iLocationX = $oLocation->getX();
		$this->_iLocationY = $oLocation->getY();
		$this->_oProdType = $oProdType;
		
		$this->_fRatioMax = 0;
		
		$this->_aProdInput = new ArrayCollection();
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	public function getLocation() {
		return new Location( $this->_iLocationX, $this->_iLocationY );
	}
	public function getEntity() {
		return $this->_oEntity;
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
	
//______________________________________________________________________________
//	Modifier
	
	public function setRatio( $f ) {
		$this->_fRatioMax = $f;
		return $this;
	}
}