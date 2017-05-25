<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;

/**
 * @ORM\Entity
 * @ORM\Table(name="prodtype")
 */
class ProductionType {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Ressource")
	 * @ORM\JoinColumn(name="ressource_id", referencedColumnName="id")
	 * @var Ressource
	 */
	protected $_oRessource;
	
	/**
	 * @ORM\Column(type="integer", name="quantity")
	 * @var int
	 */
	protected $_iQuantity;
	
	/**
	 * @ORM\ManyToMany(targetEntity="\homeplanet\Entity\attribute\ProductionInputType",cascade={"persist"})
	 * @ORM\JoinTable(
     *     name="prodtype_prodinputtype_assoc",
     *     joinColumns={@ORM\JoinColumn(name="prodtype_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="prodinputtype_id", referencedColumnName="id")}
     * )
	 * @var ArrayCollection
	 */
	protected $_aProdInputType;
	
	/**
	 * @ORM\ManyToMany(targetEntity="\homeplanet\Entity\PawnType")
	 * @ORM\JoinTable(
	 *     name="pawntype_prodtype_assoc",
	 *     joinColumns={@ORM\JoinColumn(name="prodtype_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="pawntype_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aPawnType;
	
//______________________________________________________________________________
//	Constructor
	
	function __construct( $oRessource, $iQuantity ) {
		$this->_oRessource = $oRessource;
		$this->_iQuantity = $iQuantity;
		$this->_aProdInputType = new ArrayCollection();
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getRessource() {
		return $this->_oRessource;
	}
	
	public function getQuantity() {
		return $this->_iQuantity;
	}
	
	/**
	 * @return ProductionInputType[]
	 */
	public function getProdInputTypeAr() {
		return $this->_aProdInputType;
	}
	
	public function isSeller() {
		// True if produce credit
		return $this->getRessource()->getId() == 1;
	}
	
	public function isBuyer() {
		// True if firt produce input is credit
		$first = $this->_aProdInputType->first();
	
		if( $first === null )
			return false;
		return $first->getRessource()->getId() == 1;
	}
	
	public function isTransporter() {
		$first = $this->_aProdInputType->first();
	
		if( $first === null )
			return false;
	
		return $this->getRessource()->getId() == $first->getRessource()->getId();
	}
	
}