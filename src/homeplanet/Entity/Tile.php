<?php
namespace homeplanet\Entity;

class Tile {
	
	protected $_oLocation;
	
	/**
	 * inside [-1;1]
	 * sea level 0.0
	 * @var float
	 */
	protected $_fElevation;
	
	protected $_fHumidity;
	protected $_fTemperature;
	
	
//Calculable

	/**
	 * @var int[]
	 */
	protected $_aRessourceSource;
	protected $_iTerrainType;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( 
			$oLocation, $fElevation, $fHumidity, $fTemp, $aRessource ) {
		$this->_oLocation = $oLocation;
		
		$this->_fElevation = $fElevation;
		
		$this->_fHumidity = $fHumidity;
		$this->_fTemperature = $fTemp;
		$this->_aRessourceSource = $aRessource;
		
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getType() { 
		return $this->_iTerrainType; 
	}
	
	public function getLocation() {
		return $this->_oLocation;
	}
	
	public function getElevation() {
		return $this->_fElevation;
	}
	
	public function getHumidity() {
		return $this->_fHumidity;
	}
	
	public function getTemperature() {
		return $this->_fTemperature;
	}
	
	public function getRessNatQuantityAr() {
		return $this->_aRessourceSource;
	}
	
	public function getColorRGB() {
		
		$fTemp = $this->_fTemperature;
		$fElevation = $this->_fElevation;
		$fHumi = $this->_fHumidity;
		
		// Case : sea
		if( $fElevation < 0 )
			return $this->_interpolateColor( 
					[34,86,107], // Light blue
					[19,64,85], // Deep blue
					-$fElevation
			);
		
		//$fElevation = ($fElevation-0.5) * 2;
		//$fElevation = $fElevation * 10;
		//$fElevation = ( $fElevation * $fElevation ) / 100;
		
		// Filter function x=0.5 top
		$fVegetation = $this->_getVegetation();
		//$fVegetation = $fVegetation *$fHumi;
		
		// Elevation
		$aColor = $this->_interpolateColor(
			[233, 206, 179],
			[108,97,79],
			$fElevation
		);
		
		// Vegetation
		$aColor = $this->_interpolateColor(
			$aColor, 
			[112,141,59], 
			$fVegetation
		);
		
		// Snow
		if( $this->_fTemperature < 0.25 )
			$aColor = $this->_interpolateColor(
				[255,255,255], 
				$aColor, 
				max(0.0, ($this->_fTemperature-0.125)*8)
			);
		
		return $aColor;
	}
	
	
	/**
	 * @todo move to view
	 * @return string
	 */
	public function getColorHex() {
		$aRGB = $this->getColorRGB();
		return dechex($aRGB[0]).dechex($aRGB[1]).dechex($aRGB[2]);
	}
	
//_____________________________________________________________________________
//	Sub-routine
	
	private function _interpolate( $iAlpha, $iOmega, $fPercent ) {
		return $iAlpha + ( $iOmega - $iAlpha ) * $fPercent;
	}
	
	private function _interpolateColor( array $aAlpha, array $aOmega, $fPercent ) {
		return [
			(int)$this->_interpolate(
				$aAlpha[0],
				$aOmega[0], 
				$fPercent
			),
			(int)$this->_interpolate(
				$aAlpha[1],
				$aOmega[1], 
				$fPercent
			),
			(int)$this->_interpolate(
				$aAlpha[2],
				$aOmega[2], 
				$fPercent
			)
		];
	}
	
	private function _getVegetation() {
		//return 0;
		$max = 0.65;
		$max = 0.65;
		
		// Too cold
		if( $this->_fTemperature < 0.5 )
			return 0;
		
		$fHumi = $this->_fHumidity;
		/*$f = 0.05;
		if( $this->_fElevation < $f )
			$fHumi*=$this->_fElevation*(1/$f)+0.5;*/
		
		
		$fVegetation = ( $fHumi < 0.5 ) ? $fHumi * 2 : $fHumi*-2 + 2;

		
		if( $this->_fTemperature < 0.75)
			$fVegetation*=min(1.0,($this->_fTemperature-0.5)*4);
		return $fVegetation;
	}
	
}