<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

abstract class MultistepType extends AbstractType {
	
//_____________________________________________________________________________
//	Builder

	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'previous_form' => null,
			'step' => null,
		]);
	}
	
	function buildForm(
		FormBuilderInterface $oBuilder,
		array $aOption
	) {
		
		if( $aOption['step'] != 0 )
			$oBuilder->add('_prev', SubmitType::class, ['label'=>'Back'] );
		$oBuilder->add('_reset', SubmitType::class, ['label'=>'Reset'] );
		
		$this->_buildFormByStep(
			$oBuilder, 
			$aOption['step'], 
			$oBuilder->getData(), 
			$aOption
		);
		
	}
	 
	
//_____________________________________________________________________________
	
	
	/**
	 * 
	 * @param FormBuilderInterface $oBuilder
	 * @param int $iStep in [0;++]
	 * @param mixed $oData
	 * @return boolean if the step exist
	 */
	abstract protected function _buildFormByStep( 
			FormBuilderInterface $oBuilder,
			$iStep, $oData, $aOption 
	);
}