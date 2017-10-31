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
use AppBundle\validator\ValidatorInArray;
use homeplanet\tool\TileValidatorLand;
use homeplanet\tool\TileValidatorNaval;
use homeplanet\tool\TileValidatorRange;


class LocationType extends AbstractType {
	
	
	function getParent() {
		return TextType::class;
	}
	
//_____________________________________________________________________________
//	Builder
	
	function configureOptions( OptionsResolver $oResolver ) {
		parent::configureOptions($oResolver);
		$oResolver
			->setDefaults([
				'data_class' => null, // string
				'validator' => null,
			])
			->remove('empty_data')
			->setRequired(['game', 'empty_data'])
		;
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
		
		$oLocation = $oForm->isEmpty() ? $aOptions['empty_data'] : $oForm->getData();
		$oView->vars['worldmap_view'] = $aOptions['game']->getWorldmapView( $oLocation );
		$oView->vars['data'] = $oForm->getData();
		$oView->vars['empty_data'] = $aOptions['empty_data'];
		if( isset($aOptions['validator']) ) {
			$oView->vars['validator'] = $aOptions['validator'];
			$oView->vars['validator_class'] = get_class( $aOptions['validator'] );
			
			switch( $oView->vars['validator_class'] ) {
				case ValidatorInArray::class :
					$oView->vars['validator_param'] = json_encode( $aOptions['validator']->getArray() );
					break;
				case TileValidatorLand::class :
				case TileValidatorNaval::class :
					$oView->vars['validator_param'] = json_encode( null );break;
				case TileValidatorRange::class :
					/*
					validator_serialized: '{{ validator_serialized is defined ? validator_serialized|escape('js') : null }}',
					tile_ref: '6:3',
					range: 3
					*/
				default :
					throw new \Exception('Invalid name ['.$oView->vars['validator_class'].']');
			}
		}
		
	}
	
}
