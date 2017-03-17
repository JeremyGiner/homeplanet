<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Pawn;

/**
 * @ORM\Entity
 * @ORM\Table(name="pawn_location_assoc")
 */
class PawnLocation {
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\Pawn")
	 * @ORM\JoinColumn(name="pawn_id", referencedColumnName="id")
	 * @var Pawn
	 */
	protected $_oPawn;
	
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
	
	function __construct( $oPawn, Location $oLocation ) {
		$this->_oPawn = $oPawn;
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