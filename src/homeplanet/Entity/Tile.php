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
	
	/**
	 * @var Tile
	 */
	protected $_oSouthTile;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( 
			$oLocation, 
			$fElevation, 
			$fHumidity, 
			$fTemp, 
			$aRessource,
			$oTileSouth
	) {
		$this->_oLocation = $oLocation;
		
		$this->_fElevation = $fElevation;
		
		$this->_fHumidity = $fHumidity;
		$this->_fTemperature = $fTemp;
		$this->_aRessourceSource = $aRessource;
		
		$this->_oSouthTile = $oTileSouth;
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
		
		
		// TEST
		/*
		$i = 37;
		$f = isset($this->_aRessourceSource[$i])? $this->_aRessourceSource[$i]: 0;
		$aColor = $this->_interpolateColor(
				[0,0,0],
				[255,255,255],
				$f/100
		);
		return $aColor;
		*/
		
		$fTemp = $this->_fTemperature;
		$fElevation = $this->_fElevation;
		$fHumi = $this->_fHumidity;
		
		// Case : sea
		if( $fElevation <= 0 ) {
			
			$aColor = $this->_interpolateColor( 
				[34,86,107], // Light blue
				[19,64,85], // Deep blue
				-$fElevation
			);
			
			// Shadow
			if( $this->_oSouthTile != null )
				$aColor = $this->_interpolateColor(
					$aColor,
					[0, 0, 0],
					max( 0, 
						$this->_oSouthTile->_fElevation - $this->_fElevation 
					) * 0.8
				);
			
			return $aColor;
		}
		
		//$fElevation = ($fElevation-0.5) * 2;
		//$fElevation = $fElevation * 10;
		//$fElevation = ( $fElevation * $fElevation ) / 100;
		
		// Filter function x=0.5 top
		$fVegetation = $this->_getVegetation();
		$i = 33;
		$fVegetation = isset($this->_aRessourceSource[$i])? $this->_aRessourceSource[$i]: 0;
		$fVegetation /= 50;
		
		$i = 34;
		$fForest =  isset($this->_aRessourceSource[$i])? $this->_aRessourceSource[$i]: 0;
		$fForest /= 100;
		
		
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
			//[112,141,59], 
			[94, 121, 66], 
			$fVegetation
		);
		
		//forest
		
		$aColor = $this->_interpolateColor(
				$aColor,
				[65, 98, 51],
				$fForest
		);
		
		// Snow
		if( $this->_fTemperature < 0.25 )
			$aColor = $this->_interpolateColor(
				[255,255,255], 
				$aColor, 
				max(0.0, ($this->_fTemperature-0.125)*8)
			);
		
		// Shadow
		if( $this->_oSouthTile != null )
		$aColor = $this->_interpolateColor(
			$aColor,
			[0, 0, 0],
			max( 0, $this->_oSouthTile->_fElevation - $this->_fElevation ) * 2.5
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