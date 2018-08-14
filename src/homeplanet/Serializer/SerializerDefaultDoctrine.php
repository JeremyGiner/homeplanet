<?php
namespace homeplanet\Serializer;

use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManager;
use homeplanet\Serializer\Normalizer\DoctrineEntityNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

class SerializerDefaultDoctrine extends Serializer {
	public function __construct( EntityManager $em ) {
		parent::__construct(
			[
				new DoctrineEntityNormalizer( $em ),
				new ObjectNormalizer(null,null,null, new ReflectionExtractor()),
			],[
				new JsonEncoder(),
			]
		);
	}
}