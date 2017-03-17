<?php
namespace AppBundle\Twig;

/**
 * https://github.com/twigphp/Twig/issues/789
 */
class Fix extends \Twig_Extension {
	
	
//_____________________________________________________________________________
//	Twig extention stuff
	
	function getName() {
		return 'fix';
	}
	
	public function getFunctions() {
		return [
			'array_set' => new \Twig_SimpleFunction(
				'array_set',
				[
					$this, 
					'setArray',
				]
			),
		];
	}
//_____________________________________________________________________________
	
	
	public function setArray( array $a, $key, $value ) {
		
		$a[$key] = $value;
		
		return $a;
	}
	
}