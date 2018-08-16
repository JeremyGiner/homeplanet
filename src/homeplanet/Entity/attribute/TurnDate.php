<?php
namespace homeplanet\Entity\attribute;

class TurnDate {

	protected $_iTurn;
	
	public function __construct( $iTurn ) {
		$this->_iTurn = $iTurn;
	}
	
	public function getTurn() {
		return $this->_iTurn;
	}
	
	public function getMonth() {
		return $this->_iTurn % 8 + 1;
	}
	
	public function getYear() {
		return floor( $this->_iTurn / 8 ) + 100;
	}
}

