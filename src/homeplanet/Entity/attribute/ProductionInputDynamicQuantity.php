<?php
namespace homeplanet\Entity\attribute;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Tile;

/**
 * @ORM\Entity
 * @ORM\Table(name="prodinput_dynamicquantity")
 */
class ProductionInputDynamicQuantity {
	
	/**
	 * @ORM\Id
	 * @ORM\OneToOne(targetEntity="ProductionInput", inversedBy="_oDynamicValue")
     * @ORM\JoinColumn(name="prodinput_id", referencedColumnName="id")
	 * @var ProductionInput
	 */
	protected $_oProductionInput;
	
	/**
	 * @ORM\Column(type="integer", name="quantity")
	 * @var int
	 */
	protected $_iQuantity;
	
//_____________________________________________________________________________
//	Constructor
	
	private function __construct() {}
	
//______________________________________________________________________________
//	Accessor
	
	public function getProductionInput() {
		return $this->_oProductionInput;
	}
	public function getQuantity() {
		return $this->_iQuantity;
	}
	
}