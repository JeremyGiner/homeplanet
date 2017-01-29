<?php
namespace homeplanet\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use homeplanet\Entity\attribute\Location;

class LocationTransformer implements DataTransformerInterface {
	
	public function transform( $oData ) {
		
		// Case : null
		if( $oData == null )
			return '';
		
		// Case not a Location
		if( !$oData instanceof Location )
			throw new \Exception( 'invalid data, must be '.Location::class );
		
		// Return string location
		return $oData;
		return (string)$oData;
	}
	public function reverseTransform( $sData ) {
		
		// Case : null
		if( $sData === '' )
			return null;
		// Return location
		return Location::getFromString( $sData );
	}
}