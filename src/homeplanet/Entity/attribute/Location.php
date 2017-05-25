<?php
namespace homeplanet\Entity\attribute;


class Location {
	
	protected $_x;
	
	protected $_y;
	
//______________________________________________________________________________
//	Constructor
	
	function __construct( $x, $y ) {
		$this->_x = $x;
		$this->_y = $y;
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getX() {
		return $this->_x;
	}
	public function getY() {
		return $this->_y;
	}
	
	public function getSectorX() {
		return floor( $this->_x / 169 );
	}
	public function getSectorY() {
		return floor( $this->_y / 169 );
	}
	
	public function getRegionX() {
		return floor( $this->_x / 13 );
	}
	public function getRegionY() {
		return floor( $this->_y / 13 );
	}
	
	public function getDist( Location $oLoc ) {
		return abs($this->_x - $oLoc->_x)+
			abs($this->_y - $oLoc->_y);
	}
	
	public function getString() {
		return (string) $this;
	}
	
//______________________________________________________________________________
//	Sub-routine
	
	public function __toString() {
		return $this->_x.':'.$this->_y;
	}
	
//______________________________________________________________________________
//	Utils
	
	static public function getFromString( $s ) {
		$a = explode(':',$s);
		for( $i=0; $i<count($a);$i++ ) {
			$a[$i] = ($a[$i] == '') ? null : intval($a[$i]);
		}
		if( !is_numeric($a[0]) || !is_numeric($a[1])  )
			return null;
		return new Location( $a[0], $a[1] );
	}
	
}