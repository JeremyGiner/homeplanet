<?php
namespace homeplanet\Form;

use homeplanet\entity\EntityType;
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
		]);
	}
	
//_____________________________________________________________________________
//	Builder
	
	function buildForm( 
		FormBuilderInterface $oBuilder,
		array $aOption 
	) {
		parent::buildForm($oBuilder, $aOption);
		$oBuilder->addModelTransformer( new LocationTransformer() );
	}
	
//_____________________________________________________________________________
//	View
	
	
	public function buildView(FormView $oView, FormInterface $oForm, array $aOptions) {
		$oView->vars['gameview'] = $aOptions['gameview'];
		$oView->vars['data'] = $oForm->getData();
	}
	
}
