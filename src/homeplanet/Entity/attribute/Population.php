<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use homeplanet\entity\Entity;
use homeplanet\Entity\City;
/**
 * @ORM\Entity
 * @ORM\Table(name="population")
 */
class Population {
	
	/**
	 * @ORM\Id
	 * @ORM\OneToOne(targetEntity="\homeplanet\Entity\City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
	 * @var City
	 */
	protected $_oCity;
	
	/**
	 * @ORM\Column(type="integer", name="quantity")
	 * @var int
	 */
	protected $_iQuantity;
	
	/**
	 * Computed by DB : 
	 * @ORM\Column(type="float", name="growth")
	 * @var float
	 */
	protected $_fGrowth;
	
//_____________________________________________________________________________
//	Cosntructor
	
	public function __construct( 
			Entity $oCity, 
			$iQuantity
	) {
		$this->_oCity = $oCity;
		$this->_iQuantity = $iQuantity;
		$this->_fGrowth = 0;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getQuantity() {
		return $this->_iQuantity;
	}
	
	public function getGrowth() {
		return $this->_fGrowth;
	}
}