<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use homeplanet\entity\Entity;
/**
 * @ORM\Entity
 * @ORM\Table(name="demand")
 */
class Demand {
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Entity")
	 * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
	 * @var Entity
	 */
	protected $_oEntity;
	
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
			Entity $oEntity, 
			Ressource $oRessource, 
			$fPercent 
	) {
		$this->_fPercent = $fPercent;
		$this->_oEntity = $oEntity;
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