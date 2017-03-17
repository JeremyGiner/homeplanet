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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;
use homeplanet\Entity\attribute\homeplanet\Entity\attribute;
use AppBundle\Form\datatransformer\LocationTransformer;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;


class MerchantCreationForm extends AbstractType {

	
	function getName() {
		return 'MerchantCreationForm';
	}
	
	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'game' => null,
			'ressource' => 'toto',
			
			'gameview' => null,
		]);
	}
	
	function buildForm(
			FormBuilderInterface $oBuilder,
			array $aOption
	) {
		if( !isset( $aOption['game'] ) )
			throw('argument "game" missing from option');

		/* @var $oGame Game */
		$oGame = $aOption['game'];
		
		$oBuilder->add('location', LocationType::class, [ 
				'label' => 'Location', 
				'gameview' => $aOption['gameview'],
		]);
		
		// Prod choice
		$a = $this->_getRessourceChoice( $oGame );
		$oBuilder->add('prodtype', ChoiceType::class, [
			'choices' => $a,
			'label' => false,
			'choice_value' => 'id',
		])
			->add('submit',SubmitType::class);
	}
	
	function _getRessourceChoice( Game $oGame ) {
		$a = [];
		foreach( $oGame->getPawnType(4/*Merchant*/)->getProdTypeAr() as $oProdType ) {
			$oRessource = $oProdType->getRessource();
	
			//$a[ $oEntityType->getLabel() ] = $oEntityType->getId();
			$a[ $oRessource->getLabel() ] = $oProdType;
		}
		return $a;
	}
}



