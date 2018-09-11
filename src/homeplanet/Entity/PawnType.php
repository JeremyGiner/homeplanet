<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\Transporter;
use homeplanet\Entity\attribute\TileCapacityRequirement;

/**
 * @ORM\Entity
 * @ORM\Table(name="pawntype")
 */
class PawnType {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 * @var string
	 */
	protected $_sLabel;
	
	/**
	 * @ORM\Column(type="integer", name="value_base")
	 * @var integer
	 */
	protected $_iValue;
	
	/**
	 * @ORM\Column(type="string", name="description")
	 * @var string
	 */
	protected $_sDescription;
	
	/**
	 * @ORM\ManyToMany(
	 *     targetEntity="homeplanet\Entity\attribute\ProductionType",
	 *     cascade={"persist"},
	 *     fetch="EAGER"
	 * )
	 * @ORM\JoinTable(
	 *     name="pawntype_prodtype_assoc",
	 *     joinColumns={@ORM\JoinColumn(name="pawntype_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="prodtype_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aProdType;
	
	/**
	 * @ORM\ManyToMany(
	 *     targetEntity="homeplanet\Entity\attribute\Attribute",
	 *     cascade={"persist"},
	 *     indexBy="label",
	 * )
	 * @ORM\JoinTable(
	 *     name="pawntype_attribute",
	 *     joinColumns={@ORM\JoinColumn(name="pawntype_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="attribute_id", referencedColumnName="id")}
	 * )
	 * @var \homeplanet\Entity\attribute\Attribute[]
	 */
	protected $_aAttribute;
	
	/**
	 * @ORM\ManyToOne(targetEntity="PawnTypeCategory", inversedBy="_aPawnType")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 * @var PawnTypeCategory
	 */
	protected $_oCategory;
	
	protected $_aAttributeObject = null;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="homeplanet\Entity\attribute\TileCapacityRequirement",
	 *     mappedBy="_oPawnType"
	 * )
	 * @var ArrayCollection
	 */
	protected $_aTileCapacityRequirement;
	
//_____________________________________________________________________________
//	Constructor
	
	
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	public function getValue() {
		return $this->_iValue;
	}
	
	public function getDescription() {
		return $this->_sDescription;
	}
	
	public function getAttribute( $s ) {
		
		if( $this->_aAttributeObject === null ) {
			$this->_aAttributeObject = [];
			foreach ( $this->_aAttribute as $key => $oAttribute ) {
				//TODO
				if( $key == 'transporter' )
					$this->_aAttributeObject[$oAttribute->getType()->getLabel()] = new Transporter( explode( ':', $oAttribute->getValue() ) );
			} 
		}
		return isset( $this->_aAttributeObject[$s] ) ?
			$this->_aAttributeObject[$s] :
			null;
	}
	
	/**
	 * @return ProductionType[]
	 */
	public function getProdTypeAr() {
		return $this->_aProdType->toArray();
	}
	
	public function getCategory() {
		return $this->_oCategory;
	}
	
	/**
	 * @var TileCapacityRequirement[]
	 */
	public function getTileCapacityRequirementAr() {
		return $this->_aTileCapacityRequirement->toArray();
	}
}