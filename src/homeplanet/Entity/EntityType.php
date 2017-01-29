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
 * @ORM\Table(name="entitytype")
 */
class EntityType {
	
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
	 * @ORM\ManyToMany(
	 *     targetEntity="\homeplanet\Entity\attribute\ProductionType",
	 *     cascade={"persist"},
	 *     fetch="EAGER"
	 * )
	 * @ORM\JoinTable(
	 *     name="entitytype_prodtype_assoc",
	 *     joinColumns={@ORM\JoinColumn(name="entitytype_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="prodtype_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aProdType;
	
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
	
	/**
	 * @return ProductionType[]
	 */
	public function getProdTypeAr() {
		return $this->_aProdType->toArray();
	}
}