<?php
namespace homeplanet\Serializer\Normalizer;

use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize array of data if possible.
 * 
 */
class CollectionDenormalizer implements DenormalizerInterface, SerializerAwareInterface {
	/**
	 * @var SerializerInterface|DenormalizerInterface
	 */
	private $serializer;
	
	/**
	 * {@inheritdoc}
	 *
	 * @throws UnexpectedValueException
	 */
	public function denormalize($data, $class, $format = null, array $context = array()) {
		
		if ($this->serializer === null) 
			throw new BadMethodCallException('Please set a serializer before calling denormalize()!');
		
		if (!is_array($data)) 
			throw new InvalidArgumentException('Data expected to be an array, '.gettype($data).' given.');
		
		$serializer = $this->serializer;
		
		foreach( $data as $key => $value ) {
			if( $serializer->supportsDenormalization( $value, $class, $format ) )
				$data[$key] = $serializer->denormalize($value, $class, $format, $context);
				
		}
		
		return $data;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function supportsDenormalization($data, $type, $format = null) {
		return is_array($data);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setSerializer(SerializerInterface $serializer) {
		if (!$serializer instanceof DenormalizerInterface) {
			throw new InvalidArgumentException('Expected a serializer that also implements DenormalizerInterface.');
		}
		
		$this->serializer = $serializer;
	}
}
