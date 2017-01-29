<?php
namespace homeplanet\Entity;
use homeplanet\Entity\attribute\Location;
use homeplanet\tool\Perlin;
use homeplanet\Entity\WorldmapChunk;

/**
 * Sector(169x169)>Region(13x13)>Location(1x1)
 */
class Worldmap {
	
	/**
	 * Index by x then y
	 * @var Tile[][]
	 */
	protected $_aTile;
	
	/**
	 * Indexed by concatenated offset ( 'x:y' )
	 * @var WorldmapChunk[]
	 */
	protected $_aChunk;
	
	protected $_iSeed = 2586;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $iSectorX, $iSectorY ) {
		
		$this->_aChunk = [];
		// Load tile sector 0:0
		$this->_load();
	}
	
//_____________________________________________________________________________
//	Accessor
	
	/**
	 * @return Tile
	 */
	public function getTile( $x, $y ) {
		return $this->_aTile[ $x ][ $y ];
	}
	
	public function getChunk( $iOffsetX, $iOffsetY ) {
		$s = $iOffsetX.':'.$iOffsetY;
		if( !isset( $this->_aChunk[ $s ] ) )
			$this->_aChunk[ $s ] = new WorldmapChunk($this, $iOffsetX, $iOffsetX+13, $iOffsetY, $iOffsetY+13);
		return $this->_aChunk[ $s ];
	}
	
//_____________________________________________________________________________
//	Sub-routine
	
	protected function _load() {
		
		$iSectorX = 0;
		$iSectorY = 0;
		
		$oPerlin = new Perlin( $this->_iSeed );
		
		$aPerlinElevation = $this->loadPerlinSectorResult(
				$oPerlin, 
				$iSectorX, 
				$iSectorY, 
				0 
		);
		$aPerlinHumidity = $this->loadPerlinSectorResult(new Perlin(2543), $iSectorX, $iSectorY, 0 );
		
		// Generate Tiles
		$this->_aTile = [];
		for ($x = $iSectorX*169; $x < ($iSectorX+1)*169; $x++)
		for ($y = $iSectorY*169; $y < ($iSectorY+1)*169; $y++) {
			if( !isset($this->_aTile[$x]) ) $this->_aTile[$x] = [];
			
			$fElevation = $aPerlinElevation[$x][$y];
			
			// Convertion [~-0.7;~0.7] -> [-1.0;1.0]
			$fElevation = $fElevation*1.42;
			
			// Trim
			$fElevation = ($fElevation>1)?1-($fElevation-1):$fElevation;
			$fElevation = ($fElevation<-1)?-1-($fElevation+1):$fElevation;
			
			// Erosion
			/*$f = $fElevation-0.3;
			if( $fElevation > 0);
			$fElevation *= $f*$f*$f/ (1/2.5)+0.1;*/
			
			$fHumidity = ($aPerlinHumidity[$x][$y]/2+0.5);
			$fVegetation = ( $fHumidity < 0.5 ) ? 
				$fHumidity * 2 : 
				2.0 - ($fHumidity*2 );
			
			$this->_aTile[$x][$y] = new Tile(
					new Location( $x, $y ), 
					$fElevation,
					$fHumidity, 
					-$fElevation+1,	// using elevation as temperature
					[
						34 => (int)($fVegetation*100),
						//37 => (int)($oPerlin->random2D($x, $y)*100),
					]
			);
		}
	}
	/**
	 * @source http://devmag.org.za/2011/04/05/bzier-curves-a-tutorial/
	 */
	private function _bezierPoint(
			$t,
			$p0, $p1, $p2, $p3
	) {
		$u = 1 - $t;
		$tt = $t*$t;
		$uu = $u*$u;
		$uuu = $uu * $u;
		$ttt = $tt * $t;
 
		$p = [uuu * $p0[0], $uuu * $p0[0]]; //first term
		$p += [
			$p[0] + 3 * $uu * $t * $p1[0],
			$p[1] + 3 * $uu * $t * $p1[1],
		]; //second term
		$p = [
			$p[0] + 3 * $u * $tt * $p2[0], 
			$p[1] + 3 * $u * $tt * $p2[1], 
		];//third term
		$p = [
			$p[0] + $ttt * $p3[0],
			$p[1] + $ttt * $p3[1],
		]; //fourth term
 
		return $p;
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
}