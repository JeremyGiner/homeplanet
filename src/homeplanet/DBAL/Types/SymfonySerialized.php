<?php
namespace homeplanet\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Symfony\Component\Serializer\Serializer;

/**
 * TODO : use parameter to config $format and $type when serializing
 * TODO : use as service?
 *
 */
class SymfonySerialized extends Type {
	
	
	const NAME = 'symfony_serialized';
	
	/**
	 * @var Serializer
	 */
	protected $_oSerializer = null;
	
	public function getName() {
		return self::NAME;
	}
	
//_____________________________________________________________________________
//	DBAL\Types\Type
	
	public function getSQLDeclaration( array $fieldDeclaration, AbstractPlatform $platform ) {
		return $platform->getDoctrineTypeMapping('text');
	}
	
	public function convertToDatabaseValue( $value, AbstractPlatform $platform ) {
		if( $value == null )
			return null;
		if( $this->_oSerializer == null )
			throw new \Exception('Require a serializer');
		
		return $this->_oSerializer->serialize($value, 'json');
	}
	
	public function convertToPHPValue( $value, AbstractPlatform $platform ) {
		
		if( $value == null )
			return null;
		
		if( $this->_oSerializer == null )
			throw new \Exception('Require a serializer');
		
		return $this->_oSerializer->deserialize($value, null, 'json');
			
		//throw ConversionException::conversionFailed($value, self::NAME);
	}
	
//_____________________________________________________________________________
//	Accessor

	public function getSerializer() {
		return $this->_oSerializer;
	}
	
//_____________________________________________________________________________
//	Modifier
	
	public function setSerializer( Serializer $oSerializer ) {
		$this->_oSerializer = $oSerializer;
		return $this;
	}

	
}

