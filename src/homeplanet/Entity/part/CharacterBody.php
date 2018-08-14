<?php
namespace homeplanet\Entity\part;

use homeplanet\tool\F;

class CharacterBody {
	
	
	protected $_fEyeHue;
	protected $_iEyePattern;
	
	protected $_iSkinHue0;
	protected $_fSkinHue1;
	protected $_iSkinPattern;
	//protected $_iSkinPatternPosition;
	protected $_fSkinPatternSize;
	
	protected $_fHornHue;
	protected $_iHornPattern;
	protected $_fHornSize;
	
	public function __construct(){
		$this->_fEyeHue = rand(0,360);
		$this->_iEyePattern = 0;
		
		$this->_iSkinHue0 = rand(0,360);
		$this->_fSkinHue1 = rand(0,360);
		$this->_iSkinPattern = 0;
		$this->_fSkinPatternSize = 1.0;
		
		$this->_fHornHue = rand(0,360);
		$this->_iHornPattern = 0;
		$this->_fHornSize = 1.0;
		
	}
	
//_____________________________________________________________________________
//	Accessor

	public function getEyeHue() {
		return $this->_fEyeHue;
	}

	public function getEyePattern() {
		return $this->_iEyePattern;
	}

	public function getSkinHue0() {
		return $this->_iSkinHue0;
	}

	public function getSkinHue1() {
		return $this->_fSkinHue1;
	}

	public function getSkinPattern() {
		return $this->_iSkinPattern;
	}

	public function getSkinPatternSize() {
		return $this->_fSkinPatternSize;
	}

	public function getHornHue() {
		return $this->_fHornHue;
	}

	public function getHornPattern() {
		return $this->_iHornPattern;
	}

	public function getHornSize() {
		return $this->_fHornSize;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setEyeHue($fEyeHue) {
		$this->_fEyeHue = F::circular($fEyeHue, 0, 360);
		return $this;
	}
	
	public function setEyePattern($iEyePattern) {
		$this->_iEyePattern = F::circular( $iEyePattern, 0, 1 );
		return $this;
	}
	
	public function setSkinHue0($iSkinHue0) {
		$this->_iSkinHue0 = F::circular($iSkinHue0, 0, 360);
		return $this;
	}
	
	public function setSkinHue1($fSkinHue1) {
		$this->_fSkinHue1 = F::circular($fSkinHue1, 0, 360);
		return $this;
	}
	
	public function setSkinPattern($iSkinPattern) {
		$this->_iSkinPattern = F::circular( $iSkinPattern, 0, 1 );
		return $this;
	}
	
	public function setSkinPatternSize($fSkinPatternSize) {
		$this->_fSkinPatternSize = F::clamp( $fSkinPatternSize, 0, 1.0 );
		return $this;
	}
	
	public function setHornHue( $fHornHue ) {
		$this->_fHornHue = F::circular( $fHornHue, 0, 360 );
		return $this;
	}
	
	public function setHornPattern( $iHornPattern ) {
		$this->_iHornPattern = F::circular( $iHornPattern, 0, 1 );
		return $this;
	}
	
	public function setFHornSize($fHornSize) {
		$this->_fHornSize = F::clamp( $fHornSize, 0, 1.0 );
		return $this;
	}
	
	
	
}

