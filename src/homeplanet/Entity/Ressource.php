<?php
namespace homeplanet\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ressource")
 */
class Ressource {
	
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
	 * @ORM\Column(type="integer", name="baseprice")
	 */
	protected $_iPriceBase;
	
	/**
	 * @ORM\Column(type="boolean", name="natural")
	 */
	protected $_bNatural;
	
	/**
	 * @ORM\ManyToMany(targetEntity="\homeplanet\Entity\ResCategory")
	 * @ORM\JoinTable(
	 *     name="ressource_rescategory",
	 *     joinColumns={@ORM\JoinColumn(name="res_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="rescat_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aCategory;
	
//______________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getPriceBase() {
		return $this->_iPriceBase;
	}
	
	public function isNatural() {
		return $this->_bNatural;
	}
	
}