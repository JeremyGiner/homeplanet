<?php
namespace homeplanet\tool;


use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Worldmap;
use AppBundle\validator\ValidatorInArray;
use homeplanet\tool\TileValidatorLand;
use homeplanet\tool\TileValidatorNaval;
use homeplanet\tool\TileValidatorRange;

class TileValidatorResolver {
	
	public function resolve( $sClassName, $mParam, Worldmap $oWorldmap ) {
		switch( $sClassName ) {
			case ValidatorInArray::class :
				return new ValidatorInArray( json_decode($mParam) );
			case TileValidatorLand::class :
			case TileValidatorNaval::class :
				return new $sClassName( $oWorldmap );
			case TileValidatorRange::class :
				
				throw new \Exception('TODO: update');
				
				return unserialize( $mParam['validator_serialized'] );
				
				$oWorldmap = $mParam['worldmap'];
				
				$oLocation = Location::getFromString( $mParam['tile_ref'] );
				$oTileRef = $oWorldmap->getTile(
						$oLocation->getX(), 
						$oLocation->getY()
				);
				
				return new TileValidatorRange(
					$oTileRef, 
					$mParam['range']
				);
		}
		throw new \Exception('Invalid name ['.$sClassName.']');
	}
}