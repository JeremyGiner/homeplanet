<?php
namespace homeplanet\EventListener;


use homeplanet\DBAL\Types\SymfonySerialized;
use homeplanet\Serializer\SerializerDefaultDoctrine;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class DBALTypeSymfonySerializedSetterOnLoadClass {
	public function loadClassMetadata (LoadClassMetadataEventArgs $eventArgs) {
		
		// TODO : only set once
		$oType = \Doctrine\DBAL\Types\Type::getType(SymfonySerialized::NAME);
		//$em = $this->container->get('doctrine')->getEntityManager();
		if( $oType->getSerializer() == null )
			$oType->setSerializer(new SerializerDefaultDoctrine( $eventArgs->getEntityManager() ));
	}
}
