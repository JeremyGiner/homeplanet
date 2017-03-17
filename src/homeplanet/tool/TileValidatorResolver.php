<?php
namespace homeplanet\tool;


use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Worldmap;

class TileValidatorResolver {
	
	public function resolve( $sName, $aOption ) {
		switch( $sName ) {
			case 'TileValidatorRange' :
				
				return unserialize( $aOption['validator_serialized'] );
				
				$oWorldmap = $aOption['worldmap'];
				
				$oLocation = Location::getFromString( $aOption['tile_ref'] );
				$oTileRef = $oWorldmap->getTile(
						$oLocation->getX(), 
						$oLocation->getY()
				);
				
				return new TileValidatorRange(
					$oTileRef, 
					$aOption['range']
				);
		}
		throw new Exception('Invalid name ['.$sName.']');
	}
}