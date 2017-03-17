<?php
namespace homeplanet\tool;

/**
 * 
 */
class F {
	public static function filterLow( $f, $fThreshold0, $fThreshold1 ) {
		if( $f >= $fThreshold1 )
			return 0;
		if( $f <= $fThreshold0 )
			return 1;
		$fSlope = (0-1) / ($fThreshold1 - $fThreshold0);
		return $f * $fSlope - $fSlope*$fThreshold1;
	}
	
	public static function filterHigh( $f, $fThreshold0, $fThreshold1 ) {
		if( $f >= $fThreshold1 )
			return 1;
		if( $f <= $fThreshold0 )
			return 0;
		$fSlope = (1-0) / ($fThreshold1 - $fThreshold0);
		return $f * $fSlope - $fSlope*$fThreshold0;
	}
	
	public static function interpolate( $iAlpha, $iOmega, $fPercent ) {
		return $iAlpha + ( $iOmega - $iAlpha ) * $fPercent;
	}
}
