<?php
namespace homeplanet\Entity\attribute;
use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\attribute\ProductionInputType;

/**
 * @ORM\Entity
 * @ORM\Table(name="prodinput")
 */
class ProductionInput {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	protected $_iId;
	
	/**
	 * @ORM\ManyToOne(
	 *     targetEntity="homeplanet\Entity\attribute\Production",
	 *     inversedBy="_aProdInput", 
	 *     cascade={"persist"}
	 * )
	 * @ORM\JoinColumn(name="prod_id", referencedColumnName="id")
	 * @var Production
	 */
	protected $_oProd;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\attribute\ProductionInputType")
	 * @ORM\JoinColumn(name="prodinputtype_id", referencedColumnName="id")
	 * @var ProductionType
	 */
	protected $_oProdInputType;
	
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
	 * @ORM\OneToOne(targetEntity="ProductionInputDynamicQuantity", mappedBy="_oProductionInput")
	 * @var ProductionInputDynamicQuantity
	 */
	protected $_oDynamicQuantity;
	
//______________________________________________________________________________
//	Constructor
	
	function __construct( 
			Production $oProd, 
			Location $oLocation, 
			ProductionInputType $oType 
	) {
		$this->_oProd = $oProd;
		$this->_iLocationX = $oLocation->getX();
		$this->_iLocationY = $oLocation->getY();
		$this->_oProdInputType = $oType;
		
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getLocation() {
		return new Location( $this->_iLocationX, $this->_iLocationY );
	}
	
	public function getLocationX() {
		return $this->_iLocationX;
	}
	
	public function getLocationY() {
		return $this->_iLocationY;
	}
	
	public function getProduction() {
		return $this->_oProd;
	}
	
	public function getType() {
		return $this->_oProdInputType;
	}
	
	public function getQuantity() {
		
		if( $this->_oDynamicQuantity != null )
			return $this->_oDynamicQuantity->getQuantity();
		return $this->getType()->getQuantity()
			* $this->getProduction()->getRatioMax()
		;
	}
	
}