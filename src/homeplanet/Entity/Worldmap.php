<?php
namespace homeplanet\Entity;
use homeplanet\Entity\attribute\Location;
use homeplanet\tool\Perlin;
use homeplanet\tool\OpenSimplexNoise;
use homeplanet\tool\F;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Sector(169x169)>Region(13x13)>Location(1x1)
 */
class Worldmap {
	
	/**
	 * Index by x then y
	 * @var Tile[]
	 */
	protected $_aTile;
	
	protected $_iSeedElevation = 2581;
	protected $_iSeedHumidity = 2543;
	
	//_________________________________
	// Cache
	
	/**
	 * Indexed by concatened sector coordonate ('x:y')
	 * @var float[]
	 */
	protected $_aPerlinElevation;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
		$this->_aTile = [];
	}
	
//_____________________________________________________________________________
//	Accessor
	
	/**
	 * @return Tile
	 */
	public function getTile( $x, $y ) {
		$sKey = $x.':'.$y;
		
		if( !isset($this->_aTile[ $sKey ] ) ) {
			$oLoc = new Location($x,$y);
			$this->loadRegion($oLoc->getRegionX(), $oLoc->getRegionY());
		}
		return $this->_aTile[ $sKey ];
	}
	
	public function loadRegion( $iRegionX, $iRegionY ) {
		
		
		// Cache config
		$cache = new FilesystemAdapter();
		//$cache->clear();
		$sKey = 'worldmap.region.'.$iRegionX.'_'.$iRegionY;
		
		// remove the cache item
		//$cache->deleteItem($sKey);
		
		// Attempt to get from cache
		$oItem = $cache->getItem($sKey);
		if ($oItem->isHit()) {
			$this->_aTile = array_replace( $this->_aTile, $oItem->get());
			return;
		}
		
		//TODO : load only region
		$oLoc = new Location( $iRegionX*13, $iRegionY*13 );
		
		$iSectorX = $oLoc->getSectorX();
		$iSectorY = $oLoc->getSectorY();
		
		$this->_generateSector($iSectorX, $iSectorY);
		
	}
	
	
	
	public function loadSector( $iSectorX, $iSectorY ) {
		
		// Load each region of the sector
		for ($iRegionX = $iSectorX*13; $iRegionX < ($iSectorX+1)*13; $iRegionX++)
		for ($iRegionY = $iSectorY*13; $iRegionY < ($iSectorY+1)*13; $iRegionY++) {
			$this->loadRegion($iRegionX, $iRegionY);
		}
	}
	protected function _generateSector( $iSectorX, $iSectorY ) {
		
		// Generate noise
		$aElevation = $this->_getSectorElevation($iSectorX, $iSectorY);
		$aHumidity = $this->_getSectorHumidity($iSectorX, $iSectorY);
		$aNoiseSoil = $this->_getSectorSoil($iSectorX, $iSectorY);
		
		// Generate Tiles
		for ($x = $iSectorX*169; $x < ($iSectorX+1)*169; $x++)
		for ($y = $iSectorY*169; $y < ($iSectorY+1)*169; $y++) {
			$this->_aTile[ $x.':'.$y ] = $this->_createTile(
					$x, $y,
					$aElevation[$x.':'.$y],
					$aHumidity[$x.':'.$y],
					$aNoiseSoil[$x.':'.$y]
			);
		}
		
		// Cache each region
		for ($iRegionX = $iSectorX*13; $iRegionX < ($iSectorX+1)*13; $iRegionX++)
		for ($iRegionY = $iSectorY*13; $iRegionY < ($iSectorY+1)*13; $iRegionY++) {
			
			$a = $this->_getRegion($iRegionX, $iRegionY);
			
			// Update cache
			$cache = new FilesystemAdapter();
			$sKey = 'worldmap.region.'.$iRegionX.'_'.$iRegionY;
			$oItem = $cache->getItem($sKey);
			$oItem->set($a);
			$b = $cache->save($oItem);
		}
	}
	
	
	function _getRegion( $iRegionX, $iRegionY ) {
		$a = [];
		for ($x = $iRegionX*13; $x < ($iRegionX+1)*13; $x++)
		for ($y = $iRegionY*13; $y < ($iRegionY+1)*13; $y++) {
			$a[ $x.':'.$y ] = $this->_aTile[ $x.':'.$y ];
		}
		return $a;
	}
	
	//_________________________________
	
	protected function _getSectorElevation( $iSectorX, $iSectorY ) {
		
		// Cache config
		$cache = new FilesystemAdapter();
		$sKey = 'worldmap.elevation';
		
		// remove the cache item
		//$cache->deleteItem($sKey);
		
		// Attempt to get from cache
		$oItem = $cache->getItem($sKey);
		if ($oItem->isHit()) {
			return $oItem->get();		
		}
		
		$a = $this->_getNoise(
			$this->_iSeedElevation,
			5,
			0.025,
			169,
			169,
			$iSectorX*169,
			$iSectorY*169
		);
		
		// assign a value to the item and save it
		$oItem->set($a);
		$cache->save($oItem);
		
		return $a;
	}
	
	protected function _getSectorHumidity( $iSectorX, $iSectorY ) {
		// Cache config
		$cache = new FilesystemAdapter();
		$sKey = 'worldmap.humidity';
		
		// remove the cache item
		//$cache->deleteItem($sKey);
		
		// Attempt to get from cache
		$oItem = $cache->getItem($sKey);
		if ($oItem->isHit()) {
			return $oItem->get();
		}
		
		$a = $this->_getNoise(
				$this->_iSeedHumidity,
				6,
				0.025,
				169,
				169,
				$iSectorX*169,
				$iSectorY*169
		);
		
		// assign a value to the item and save it
		$oItem->set($a);
		$cache->save($oItem);
		
		return $a;
	}
	
	protected function _getSectorSoil( $iSectorX, $iSectorY ) {
		// Cache config
		$cache = new FilesystemAdapter();
		$sKey = 'worldmap.soil';
		
		// remove the cache item
		//$cache->deleteItem($sKey);
		
		// Attempt to get from cache
		$oItem = $cache->getItem($sKey);
		if ($oItem->isHit()) {
			return $oItem->get();
		}
		
		$a = $this->_getNoise(
				0,
				1,
				0.5,
				169,
				169,
				$iSectorX*169,
				$iSectorY*169
		);
		
		// assign a value to the item and save it
		$oItem->set($a);
		$cache->save($oItem);
		
		return $a;
	}
	
//_____________________________________________________________________________
//	Sub-routine
	
	protected function _loadTile( $x, $y ) {
		
		$oPerlin = (new Perlin($this->_iSeedElevation));
		
		$this->_aTile[ $x.':'.$y ] = $this->_createTile(
			$x, $y,
			$oPerlin->noise($x, $y, 0, 50), 
			(new Perlin($this->_iSeedHumidity))->noise($x, $y, 0, 50), 
			$oPerlin->random2D($x, $y)
		);
		
	}
	
	protected function _createTile(
		$x,
		$y,
		$fPerlinElevation,
		$fPerlinHumidity,
		$fPerlinSoil
	) {
		$fElevation = $fPerlinElevation;
			
		// Convertion [~-0.7;~0.7] -> [-1.0;1.0]
		$fElevation = $fElevation*2;
			
		// Trim
		$fElevation = ($fElevation>1)?1-($fElevation-1):$fElevation;
		$fElevation = ($fElevation<-1)?-1-($fElevation+1):$fElevation;
			
		// Erosion
		if( $fElevation > 0)
		$fElevation = pow($fElevation,2);
		/*$f = $fElevation-0.3;
		 if( $fElevation > 0);
		 $fElevation *= $f*$f*$f/ (1/2.5)+0.1;*/
			
		$fTemperature = -$fElevation+1;	// using elevation as temperature
		$fHumidity = max(0,min(1.0,($fPerlinHumidity+0.4)*1.5));
		$fPerlinSoil = abs($fPerlinSoil);
		$fVegetation = $this->_getVegetation($fTemperature, $fHumidity);
		
		
		// Ressource
		$aRessource = [];
		if( $fElevation > 0 ) {
			// Field
			$aRessource[33] = (int)( 100
					* F::filterHigh($fVegetation, 0.0, 0.30)
					* F::filterLow($fVegetation, 0.30, 0.70)
			);
			//$aRessource[33] = (int)($fVegetation*100);
			
			// Forest
			$aRessource[34] = (int)( 100
					* F::filterHigh($fVegetation, 0.30, 0.70)
			);
			
			// Stone deposit
			$aRessource[37] = (int)(100
					* F::filterLow($fVegetation, 0.0, 0.2)	// vegetation block mining
					* $fPerlinSoil
			);
			// Iron deposit
			$aRessource[44] = (int)(100
					* F::filterLow($fVegetation, 0.0, 0.2)	// vegetation block mining
					* F::filterLow($fPerlinSoil, 0.0, 0.2)
			);
			// Gold deposit
			$aRessource[45] = (int)(100
					* F::filterLow($fVegetation, 0.0, 0.2)	// vegetation block mining
					* F::filterHigh($fPerlinSoil, 0.25, 0.3)
					* F::filterLow($fPerlinSoil, 0.3, 0.35)
			);
		} else {
			// Fish deposit
			$aRessource[35] = (int)(100
				* $fPerlinSoil
			);
		}
		
		// Remove zero
		foreach ( $aRessource as $key => $value ) {
			if( $value == 0 )
				unset($aRessource[$key]);
		}
			
			
		$oTileSouth = isset($this->_aTile[$x.':'.($y-1)])?
			$this->_aTile[$x.':'.($y-1)]:
			null;
		return new Tile(
				new Location( $x, $y ),
				$fElevation,
				$fHumidity,
				$fTemperature,
				$aRessource,
				$oTileSouth
		);
	}
	
	private function _getVegetation( $fTemp, $fHumi ) {
		
		$fVegetation =  F::filterHigh( 
					$fHumi , 
					0.25,
					1.0
			)
			* F::filterHigh( 
					$fTemp, 
					0.6,
					0.8
			);
		
		return $fVegetation;
	}
	
	private function loadPerlinSectorResult( Perlin $oPerlin, $iSectorX, $iSectorY, $z ) {
		$sKey = $oPerlin->seed.'_'.$iSectorX.'_'.$iSectorY.'_'.$z;
		
		// Case: laod from "cache"
		if( is_readable( $sKey ) ) {
			$recoveredData = file_get_contents( $sKey );
			return unserialize($recoveredData);
		}
		
		// Generate
		for ($x = $iSectorX*169; $x < ($iSectorX+1)*169; $x++) 
		for ($y = $iSectorY*169; $y < ($iSectorY+1)*169; $y++) {
			$aResult[$x][$y] = $oPerlin->noise($x, $y, $z, 50);
		}
		
		
		// Store in "cache"
		$serializedData = serialize($aResult); //where '$array' is your array
		file_put_contents($sKey, $serializedData);
		
		return $aResult;
	}
	
	private function _getNoise(
		$iSeed = 53317,
		$iOctaveQ = 5,
		$fFirtFreq = 0.025,
		$iWidth = 128,
		$iHeight = 128,
		$iOffsetX = 0,
		$iOffsetY = 0
	) {
		$aNoise = [];
		$aOctave = [];
		$aFreq = [];
		
		// Generate noises with their octaves and frequency
		$fFreq = $fFirtFreq;
		for ($i = 0; $i < $iOctaveQ; $i++) {
			$aNoise[] = OpenSimplexNoise::createBySeed($iSeed+$i);
			$aOctave[] = 1/($i+1);
			$aFreq[] = $fFreq;
		
			$fFreq *= 2;
		}
		
		// Add all the layers
		$aNoiseValue = [];
		for ($x = 0; $x < $iWidth; $x++)
		for ($y = 0; $y < $iHeight; $y++) {
			$aNoiseValue[$x.':'.$y] = 0;
			
			$fOctaveSum = 0;
			foreach( $aNoise as $i => $oNoise ) {
				$aNoiseValue[$x.':'.$y] += $oNoise->getValue3D(
						$x*$aFreq[$i],
						$y*$aFreq[$i],
						169
				)*$aOctave[$i];
	
				$fOctaveSum += $aOctave[$i];
			}
	
			$aNoiseValue[$x.':'.$y] /= $fOctaveSum;
		}
		
		return $aNoiseValue;
	}
}