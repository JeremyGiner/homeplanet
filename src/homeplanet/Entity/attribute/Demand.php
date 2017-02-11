<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use homeplanet\entity\Entity;
use homeplanet\Entity\City;
/**
 * @ORM\Entity
 * @ORM\Table(name="demand")
 */
class Demand {
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\City")
	 * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
	 * @var City
	 */
	protected $_oCity;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Ressource")
	 * @ORM\JoinColumn(name="ressource_id", referencedColumnName="id")
	 * @var Ressource
	 */
	protected $_oRessource;
	
	/**
	 * Used in the calcul of the ressource price
	 * @ORM\Column(type="float", name="percent")
	 * @var float
	 */
	protected $_fPercent;
	
	/**
	 * @ORM\Column(type="integer", name="price_modifier")
	 * @var int
	 */
	protected $_iPriceModifier;
	
//_____________________________________________________________________________
//	Cosntructor
	
	public function __construct( 
			Entity $oCity, 
			Ressource $oRessource, 
			$fPercent 
	) {
		$this->_fPercent = $fPercent;
		$this->_oCity = $oCity;
		$this->_oRessource = $oRessource;
		$this->_iPriceModifier = 0;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	
	public function getRessource() {
		return $this->_oRessource;
	}
	
	public function getPercent() {
		return $this->_fPercent;
	}
	
	public function getPriceModifier() {
		return $this->_iPriceModifier;
	}
	
	public function getPrice() {
		return $this->_iPriceModifier * $this->_oRessource->getPriceBase();
	}
}