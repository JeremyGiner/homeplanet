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
use Symfony\Component\Form\FormBuilder;

abstract class MultistepType extends AbstractType {
	
//_____________________________________________________________________________
//	Builder

	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'previous_form' => null,
			'step' => null,
			'isRecap' => false,
		]);
	}
	
	function buildForm(
		FormBuilderInterface $oBuilder,
		array $aOption
	) {
		
		if( $aOption['isRecap'] === true ) {
			$this->getRecap($oBuilder, $aOption);
			
			return;
		}
		
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
	
	function getRecap( FormBuilderInterface $oBuilder, array $aOption) {
		
		if( $aOption['step'] == 0 )
			return null;
			
		$oBuilder->setDisabled(true);
		
		foreach ( range( 0, $aOption['step']-1 ) as $i ) {
			$this->_buildFormByStep(
					$oBuilder,
					$i,
					$oBuilder->getData(),
					$aOption
			);
		}
		
		// Remove all submit
		/* @var $o FormBuilder */
		//TODO: make it dynamic
		//foreach( $oBuilder->all() as $o ) {
		//	var_dump( $o->getType()->getInnerType() );
		//}
		$oBuilder->remove('submit');
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