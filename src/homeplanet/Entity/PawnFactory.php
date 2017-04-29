<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use homeplanet\Game;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\attribute\Demand;

/**
 * Default entity factory
 */
class PawnFactory extends Pawn {
	
	protected $_oType;
	
	protected $_aArg;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( PawnType $oType, array $aArg ) {
		$this->_oType = $oType;
		$this->_aArg = $aArg;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function create() {
		extract( $this->_aArg );
		
		$o = new Pawn( $this->_oType );
		$o->setPlayer( $oPlayer );
		
		// Location
		if( isset($oLocation) ) {
			$o->addLocation( $oLocation );
		}
		
		// Addon
		$aAddOn = [];
		
		// Regular prod (wood cutter, etc ...)
		if( isset($oLocation) ) {
			
			foreach( $this->_oType->getProdTypeAr() as $oProdType ) {
				$oProd = new Production($o, $oLocation, $oProdType );
				$o->addProduction( $oProd );
				
				foreach( $oProdType->getProdInputTypeAr() as $oProdInputType ) {
					// Case: natural ressource as input -> set prod ratio 
					// Assume there is a unique prod input
					$oProd->getProdInputAr()->add( 
						new ProductionInput( 
							$oProd, 
							$oLocation, 
							$oProdInputType 
						) 
					);
					
				}
				
				$aAddOn[] = $oProd;
				
				// TODO : clean up
				// Limit to 1
				break;
			}
		}
		
		// City pop
		if( isset($iPopulation) ) {
			//$o->_oPopulation = new Population($o, $iPopulation);
			$aAddOn[] = new Population($o, $iPopulation);
		}
		
		// City demand
		if( isset($aDemandDesc) ) {
			//$o->_aDemand = new ArrayCollection();
			foreach( $aDemandDesc as $aDesc ) {
				//$o->_aDemand->add( new Demand($o, $aDesc['ressource'], $aDesc['percent'] ) );
				$aAddOn[] = new Demand($o, $aDesc['ressource'], $aDesc['percent'] );
			}
		}
		
		return [
			'entity' => $o,
			'addOn' => $aAddOn
		];
	}
}