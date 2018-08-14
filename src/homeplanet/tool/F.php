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
	
	/**
	 * 
	 * @param float $value
	 * @param float $min include
	 * @param float $max exclude
	 * @throws \Exception
	 * @return number
	 */
	public static function circular( $value, $min, $max  ) {
		if( $min != 0 )
			throw new \Exception('Not implemented yet');
		if( $min >= $max )
			throw new \Exception('Invalid values');
		return $value - intdiv( $value, $max ) * $max;
	}
	
	public Static function clamp( $value, $min, $max ) {
		if( $value < $min )
			return $min;
		if( $value > $max )
			return $max;
		return $value;
	}
}
