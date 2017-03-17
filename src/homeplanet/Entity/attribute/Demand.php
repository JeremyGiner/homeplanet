<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Pawn;
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
	 * @ORM\Column(type="float", name="price_modifier")
	 * @var float
	 */
	protected $_fPriceModifier;
	
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
		$this->_fPriceModifier = 0;
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
		return $this->_fPriceModifier;
	}
	
	public function getPrice() {
		return floor($this->_fPriceModifier * $this->_oRessource->getPriceBase());
	}
}