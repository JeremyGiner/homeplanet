<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;

/**
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="homeplanet\Repository\CityRepository")
 */
class City {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 */
	protected $_sLabel;
	
	/**
	 * @ORM\Column(type="integer", name="location_x")
	 * @var int
	 */
	protected $_x;
	
	/**
	 * @ORM\Column(type="integer", name="location_y")
	 * @var int
	 */
	protected $_y;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="\homeplanet\Entity\attribute\Demand",
	 *     mappedBy="_oCity",
	 *     cascade={"persist"}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aDemand;
	
	/**
	 * @ORM\OneToOne(
	 *     targetEntity="\homeplanet\Entity\attribute\Population", 
	 *     mappedBy="_oCity",
	 *     cascade={"persist"}
	 * )
	 * @var Population
	 */
	protected $_oPopulation;
	
	/**
	 * @ORM\ManyToMany(targetEntity="homeplanet\Entity\Sovereign")
	 * @ORM\JoinTable(
	 *     name="city_sovereign",
	 *     joinColumns={@ORM\JoinColumn(name="city_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="sovereign_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aSovereign;
	
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="\homeplanet\Entity\Influence",
	 *     mappedBy="_oCity"
	 * )
	 * @var ArrayCollection
	 */
	protected $_aInfluence;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getDemandAr() {
		return $this->_aDemand;
	}
	
	public function getPopulation() {
		return $this->_oPopulation;
	}
	
	public function getLocation() {
		return new Location($this->_x, $this->_y);
	}
	/**
	 * @return Sovereign
	 */
	public function getSovereign() {
		return $this->_aSovereign->first();
	}
	
	public function getInfluenceAr() {
		return $this->_aInfluence->toArray();
	}
	
//_____________________________________________________________________________
//	Modifier

}