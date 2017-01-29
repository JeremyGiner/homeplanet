<?php
namespace homeplanet\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sold")
 */
class Sold {
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Ressource")
	 * @ORM\JoinColumn(name="ressource_id", referencedColumnName="id")
	 */
	protected $_oRessource;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\attribute\Location")
	 * @ORM\JoinColumns(
	 *     @ORM\JoinColumn(name="location_x", referencedColumnName="x"),
	 *     @ORM\JoinColumn(name="location_y", referencedColumnName="y")
	 * )
	 * @var Location
	 */
	//protected $_oLocation;
	
	/**
	 * @ORM\Column(type="integer", name="sold")
	 * @var int
	 */
	protected $_iSold;
	
//______________________________________________________________________________
//	Accessor
	
	public function getRessource() {
		return $this->_oRessource;
	}
	
	public function getLocation() {
		return $this->_oLocation;
	}
	
	public function getSold() {
		return $this->_iSold;
	}
	
}