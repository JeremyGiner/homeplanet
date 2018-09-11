<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Form\data\PawnUpgradeBuy;

class PawnUpgradeBuyForm extends AbstractType {
	
	
	public 	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'data_class' => PawnUpgradeBuy::class,
		]);
	}
	
	public function getName() {
		return 'PawnUpgradeBuyForm';
	}
	
	public function buildForm(FormBuilderInterface $oBuilder, array $aOption ) {
		$oBuilder
			->add('submit',SubmitPawnUpgradeBuyType::class,[
				'label' => 'Upgrade ',
				'attr' => [
					'class' => 'btn-primary',
				],
				'data' => $oBuilder->getData(),
			])
		;
	}
}

