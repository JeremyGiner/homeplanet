<?php
namespace AppBundle\Twig;

use Symfony\Component\PropertyAccess\PropertyAccess;
use AppBundle\Tool\ArrayTool;
/**
 * 
 */
class Tool extends \Twig_Extension {
	
	/** @var  PropertyAccess */
	protected $accessor;
	
	
	protected $_oArrayTool = null;

//_____________________________________________________________________________
//	Twig extention stuff

	public function initRuntime(\Twig_Environment $oEnvironment) {
	}
	
	function getName() {
		return 'tool';
	}
	
	public function getFunctions() {
		return [
			'aggregate' => new \Twig_SimpleFunction(
				'aggregate',
				[
					$this, 
					'getAggregate',
				]
			),
			'indexBy' => new \Twig_SimpleFunction(
				'indexBy',
				[
					$this,
					'getIndexBy',
				]
			),
		];
	}
//_____________________________________________________________________________
	
	
	public function getArrayTool() {
		if( $this->_oArrayTool === null ) {
			$this->_oArrayTool = new ArrayTool();
		}
		return $this->_oArrayTool;
	}
	
	public function getAggregate( $mSubject, $sPropertyPath ) {
		
		return $this->getArrayTool()->aggregate($mSubject, $sPropertyPath);
	}
	
	public function getIndexBy( array $aSubject, $sPropertyPath ) {
	
		return $this->getArrayTool()->indexBy($aSubject, $sPropertyPath);
	}
	
//_____________________________________________________________________________
//	Sub-routine	
	
}
