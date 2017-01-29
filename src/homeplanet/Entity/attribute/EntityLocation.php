<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="entity_location_assoc")
 */
class EntityLocation {
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Entity")
	 * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
	 * @var Entity
	 */
	protected $_oEntity;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="location_x")
	 * @var int
	 */
	protected $_x;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="location_y")
	 * @var int
	 */
	protected $_y;
	
	/**
	 * Cache location object calc from _x and _y
	 * @var Location
	 */
	protected $_oLocation = null;
	
//______________________________________________________________________________
//	Constructor
	
	function __construct( $oEntity, Location $oLocation ) {
		$this->_oEntity = $oEntity;
		$this->_x = $oLocation->getX();
		$this->_y = $oLocation->getY();
		$this->_oLocation = $oLocation;
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getX() {
		return $this->_x;
	}
	public function getY() {
		return $this->_y;
	}
	
	public function getLocation() {
		if( $this->_oLocation == null )
			$this->_oLocation = new Location( $this->_x, $this->_y );
		return $this->_oLocation;
	}
	
}