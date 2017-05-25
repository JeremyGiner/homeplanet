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
use homeplanet\Entity\attribute\homeplanet\Entity\attribute;

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
	 * @var int
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
	 * @ORM\ManyToOne(targetEntity="PawnTypeCategory", inversedBy="_aPawnType")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 * @var PawnTypeCategory
	 */
	protected $_oCategory;
	
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
	
	/**
	 * @return ProductionType[]
	 */
	public function getProdTypeAr() {
		return $this->_aProdType->toArray();
	}
	
	function getCategory() {
		return $this->_oCategory;
	}
}