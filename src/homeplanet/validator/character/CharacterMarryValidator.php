<?php
namespace homeplanet\validator\character;

use homeplanet\Entity\Character;
use homeplanet\tool\F;
use Doctrine\DBAL\Query\QueryBuilder;

class CharacterMarryValidator /*extends IValidator*/ {
	
	private $_iTurn;
	
	const DELTA = 5;
	
	public function __construct( $iTurn ) {
		$this->_iTurn = $iTurn;
	}
	
	public function validate( array $aCharacter ) {
		
		return self::STvalidate( $this->_iTurn, $aCharacter );
	}
	
	static public function STvalidate( $iTurn, array $aCharacter ) {
		
		
		//TODO: get turn 
		$iTurn;
		
		if( count( $aCharacter ) != 2 || !$aCharacter[0] instanceof Character || !$aCharacter[0] instanceof Character )
			throw new \Exception('Expected 2 character');
		
		$oCharacterRef = $aCharacter[0];
		$oCharacter = $aCharacter[1];
		//TODO : character must be able
		if( $oCharacterRef === null ) return false;
		if( $oCharacterRef->getMate() !== null ) return false;
		if( $oCharacter === null ) return false;
		if( $oCharacter->getMate() !== null ) return false;
		if( $oCharacter->getGenre() == $oCharacterRef->getGenre() ) return false;
		if( $oCharacter->getId() == $oCharacterRef->getId() ) return false;
		
		$iDateRef = $oCharacterRef->getDateCreated();
		$iDate = $oCharacter->getDateCreated();
		if( !CharacterAbleValidator::STvalidate($iTurn, $oCharacter) ) return false;
		
		return F::isBetween( 
			$iDate, 
			$iDateRef - self::DELTA, 
			$iDateRef + self::DELTA
		);
	}
	
	// TODO : move to its own class
	static public function STmodify( QueryBuilder $oQueryBuilder, $sCharacterAlias, Character $oCharacterRef ) {
		
		if( $oCharacterRef == null || $oCharacterRef->getMate() != null )
			throw new \Exception('TODO : handle those case');
		
		return $oQueryBuilder
			->andWhere($sCharacterAlias.'._oMate IS NULL')
			->andWhere($sCharacterAlias.'._oCreated BETWEEN :'.$sCharacterAlias.'_too_young AND :'.$sCharacterAlias.'_too_old')
			->andWhere($sCharacterAlias.'._sGenre = :'.$sCharacterAlias.'genre')
			->andWhere($sCharacterAlias.'._iId != :'.$sCharacterAlias.'current_character_id')
			->setParameter( $sCharacterAlias.'_too_young', $oCharacterRef->getCreated()+self::DELTA )
			->setParameter( $sCharacterAlias.'_too_old', $oCharacterRef->getCreated()-self::DELTA )
			->setParameter( $sCharacterAlias.'genre', $oCharacterRef->getOppositeGenre() )
			->setParameter( $sCharacterAlias.'current_character_id', $oCharacterRef->getId() )
		;
	}
}