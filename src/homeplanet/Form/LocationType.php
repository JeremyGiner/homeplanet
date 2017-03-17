<?php
namespace homeplanet\Form;

use homeplanet\Form\DataTransformer\LocationTransformer;
use homeplanet\Entity\attribute\Location;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;


class LocationType extends AbstractType {
	
	
	function getParent() {
		return TextType::class;
	}
	
//_____________________________________________________________________________
//	Builder
	
	function configureOptions( OptionsResolver $oResolver ) {
		parent::configureOptions($oResolver);
		$oResolver->setDefaults([
			'gameview' => null,	//todo : find proper way to do that
			'data_class' => null, // string
			'validator' => null,
		]);
	}
	
//_____________________________________________________________________________
//	Builder
	
	function buildForm( 
		FormBuilderInterface $oBuilder,
		array $aOption 
	) {
		
		$oBuilder->addModelTransformer( new LocationTransformer() );
	}
	
//_____________________________________________________________________________
//	View
	
	public function buildView(FormView $oView, FormInterface $oForm, array $aOptions) {
		$oView->vars['gameview'] = $aOptions['gameview'];
		$oView->vars['data'] = $oForm->getData();
		if( isset($aOptions['validator']) ) {
			$oView->vars['validator'] = $aOptions['validator'];
			$oView->vars['validator_serialized'] = serialize($aOptions['validator']);
		}
		
	}
	
}
