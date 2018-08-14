<?php
namespace homeplanet\factory;

use homeplanet\Entity\Character;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\part\CharacterBody;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use homeplanet\Entity\attribute\Location;

class CharacterBuilderByParent {
	
	protected $_oParent0, $_oParent1;
	protected $_oEntityManager;
	
	public function __construct( 
		EntityManager $oEM,
		Character $oParent0, 
		Character $oParent1
	) {
		$this->_oParent0 = $oParent0;
		$this->_oParent1 = $oParent1;
		$this->_oEntityManager = $oEM;
	}
	
	public function create() {
		$oNormalizer = new ObjectNormalizer();
		$aParent0Body = $oNormalizer->normalize($this->_oParent0->getBody());
		$aParent1Body = $oNormalizer->normalize($this->_oParent1->getBody());
		
		$aChildBody = [];
		
		//!\ Process only first depth
		foreach( $aParent0Body as $sKey => $oValue ) {
			
			// Inherit
			$oValue = ( rand(0,100) <= 50 ) ? 
				$aParent0Body[ $sKey ] : 
				$aParent1Body[ $sKey ]
			;
			
			if( !is_int($oValue) && !is_float($oValue) )
				throw new \Exception( $oValue.' invalid type, should be number' );
			
			// Mutation
			//!\ Assume value is int or float
			if( rand(0,100) <= 10 )
				$oValue = ( rand(0,100) <= 50 ) ? $oValue+1 : $oValue-1;
			
			$aChildBody[ $sKey ] = $oValue;
		}
		
		// TODO: location, lifegoal
		$oCharacter = new Character( 
			$this->_oEntityManager, 
			//TODO: use family name and generate new first name
			$this->_oParent0->getLabel().$this->_oParent1->getLabel(),
			( rand(0,100) > 50 ) ? 'male' : 'female', 
			$oNormalizer->denormalize( $aChildBody, CharacterBody::class )  
		);
		
		$oCharacter->setLocation(new Location( 
			$this->_oParent0->getLocationX(),
			$this->_oParent0->getLocationY()
		));
		$oCharacter->setLifegoal([ 
			Character::LIFEGOAL_SELF_PRESERVE, 
			Character::LIFEGOAL_FAMILY_CREATE, 
		]);
		
		return $oCharacter;
	}
}

