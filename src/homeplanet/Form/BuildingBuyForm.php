<?php
namespace homeplanet\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Game;
use homeplanet\Entity\attribute\Location;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use homeplanet\Form\EntityTypeChoiceType;
use homeplanet\Form\BuildingBuy;
use Doctrine\ORM\EntityRepository;

class BuildingBuyForm extends AbstractType {

	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'data_class' => BuildingBuy::class,
			'game' => null,
			'location' => null,
			'block_name' => 'toto',
		]);
	}
	
	function getName() {
		return 'BuildingBuyForm';
	}

	function buildForm(
			FormBuilderInterface $oBuilder,
			array $aOption
	) {
		if( !isset( $aOption['game'] ) )
			throw('argument "game" missing from option');

		/* @var $oGame Game */
		$oGame = $aOption['game'];
		/* @var $oLocation Location */
		$oLocation = $aOption['location'];
		
		$a = $this->_getEntityTypeChoice( $oGame );
		
		$oBuilder
			->add('locationx', HiddenType::class)
			->add('locationy', HiddenType::class)
			->add('entitytype',EntityTypeChoiceType::class,[
				//'mapped' => false,
				'query_builder' => function(EntityRepository $er) {
					return $er->createQueryBuilder('u')
						->where('u._sLabel not in ( :filter)')
						->setParameter('filter', ['city','merchant','trade route']);
				},
			])
			->add('submit',SubmitType::class);
	}
	function _getEntityTypeChoice( Game $oGame ) {
		$a = [];
		foreach( $oGame->getEntityTypeAr() as $oEntityType ) {
				
			//Filter city
			if( $oEntityType->getLabel() == 'city' )
				continue;
			
			//Filter trade route
			if( $oEntityType->getLabel() == 'trade route' )
				continue;
			
			//Filter merchant
			if( $oEntityType->getLabel() == 'merchant' )
				continue;
				
			//$a[ $oEntityType->getLabel() ] = $oEntityType->getId();
			$a[ $oEntityType->getLabel() ] = $oEntityType;
		}
		return $a;
	}
}


