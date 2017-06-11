<?php
namespace homeplanet\Entity\attribute;
use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;

/**
 * @ORM\Entity
 * @ORM\Table(name="prodinputtype")
 */
class ProductionInputType {
	
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
	
	function __construct( $oRessource, $iQuantity ) {
		$this->_oRessource = $oRessource;
		$this->_iQuantity = $iQuantity;
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getRessource() {
		return $this->_oRessource;
	}
	
	public function getQuantity() {
		return $this->_iQuantity;
	}
	
}