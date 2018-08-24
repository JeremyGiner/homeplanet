<?php
namespace homeplanet\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\Common\Proxy\Proxy;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DoctrineEntityNormalizer implements NormalizerInterface, DenormalizerInterface {
	
	private $_oEntityManager;
	
//_____________________________________________________________________________

	public function __construct( EntityManager $oEntityManager ) {
		$this->_oEntityManager = $oEntityManager;
	}
	
//_____________________________________________________________________________
// Normalizer

	/**
	 * Normalizes an object into a set of arrays/scalars.
	 *
	 * @param object $object  object to normalize
	 * @param string $format  format the normalization result will be encoded as
	 * @param array  $context Context options for the normalizer
	 *
	 * @return array|scalar
	 */
	public function normalize($object, $format = null, array $context = array()) {
		
		// TODO use class metadata
		return [ 
			'class' => (new \ReflectionClass($object))->getName(),
			'id' => $object->getId(),
		];
	}
	
	/**
	 * Checks whether the given class is supported for normalization by this normalizer.
	 *
	 * @param mixed  $data   Data to normalize
	 * @param string $format The format being (de-)serialized from or into
	 *
	 * @return bool
	*/
	public function supportsNormalization($data, $format = null) {
		
		return $this->isEntity($data);
	}
	
//_____________________________________________________________________________
//	Denormalizer
	
	/**
	 * Denormalizes data back into an object of the given class.
	 *
	 * @param mixed  $data    data to restore
	 * @param string $class   the expected class to instantiate
	 * @param string $format  format the given data was extracted from
	 * @param array  $context options available to the denormalizer
	 *
	 * @return object
	 */
	public function denormalize($data, $class, $format = null, array $context = array()) {
		$oRepo = $this->_oEntityManager->getRepository($data['class']);
		
		if( $oRepo === null )
			throw new \Exception($data['class'].' not a doctrine entity');
		
		return $oRepo->find($data['id']);
	}
	
	/**
	 * Checks whether the given class is supported for denormalization by this normalizer.
	 *
	 * @param mixed  $data   Data to denormalize from
	 * @param string $type   The class to which the data should be denormalized
	 * @param string $format The format being deserialized from
	 *
	 * @return bool
	*/
	public function supportsDenormalization($data, $type, $format = null) {
		
		if( !isset($data['class']) )
			return false;
			
		return $this->isEntity($data['class']);
	}
	
//_____________________________________________________________________________
//	Subroutine
	
	/**
	 * @param string|object $class
	 *
	 * @return boolean
	 */
	function isEntity($class) {
		if( is_string($class) ) {
			$class = is_subclass_of($class, Proxy::class)
				? get_parent_class($class)
				: $class
			;
		} elseif (is_object($class)) {
			$class = ($class instanceof Proxy)
				? get_parent_class($class)
				: get_class($class)
			;
		} else 
			return false;
		
		return ! $this->_oEntityManager->getMetadataFactory()->isTransient($class);
	}
}
