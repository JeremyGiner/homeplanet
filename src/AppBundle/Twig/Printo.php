<?php
namespace AppBundle\Twig;

/**
 * @link http://stackoverflow.com/questions/22550368/how-can-we-get-class-name-of-the-entity-object-in-twig-view
 */
class Printo extends \Twig_Extension {
	
	/**
	 * @var \Twig_Environment
	 */
	private $oEnvironment;
	
//_____________________________________________________________________________
//	Twig extention stuff

	public function initRuntime(\Twig_Environment $oEnvironment) {
		$this->oEnvironment = $oEnvironment;
	}
	
	function getName() {
		return 'printo';
	}
	
	public function getFunctions() {
		return [
			'printo' => new \Twig_SimpleFunction(
				'printo',
				[
					$this, 
					'getPrintoRender',
				],
				['is_safe' => ['html']]
			),
		];
	}
//_____________________________________________________________________________
	
	
	public function getPrintoTemplate( $object, $aParam = [] ) {
		
		// Resolve template file from object 
		
		return $this->_resolve($object, $aParam);
	}
	
	public function getPrintoRender( $object, $aParam = []) {
		$sTemplate = $this->getPrintoTemplate( $object, $aParam );
		
		if( $sTemplate == null )
			return '';
		
		// Render
		return $this->oEnvironment->render(
			$sTemplate,
			[
				'o' => $object, 
				'param' => $aParam,
			]
		);
	}
	
//_____________________________________________________________________________
//	Sub-routine	
	/**
	 * @todo create and use IPrintoResolve
	 * @param mixed $object
	 * @param mixed[] $aParam
	 * @return NULL|string
	 */
	protected function _resolve( $object, $aParam ) {
		
		if( $object == null )
			return null;
		
		if( !is_object($object))
			throw new \Exception('this is not an object');
		
		$oReflexion = new \ReflectionClass($object);
		//$aName = explode('\\', $oReflexion->getName());
		
		$sSuffix = $this->_getSuffixe($aParam);
		return 'printo/'.$oReflexion->getShortName().$sSuffix.'.html.twig';
	}
	
	private function _getSuffixe( $aParam ) {
		
		$mSuffixeParam = null;
		$mSuffixeParam = isset( $aParam[0] ) ? $aParam[0] : $mSuffixeParam;
		$mSuffixeParam = isset( $aParam['_suffix'] ) ? $aParam['_suffix'] : $mSuffixeParam;
		
		if( $mSuffixeParam === null )
			return '';
		
		if( is_array($mSuffixeParam) )
			return '_'.implode('_',$mSuffixeParam);
		if( is_string($mSuffixeParam) )
			return '_'.$mSuffixeParam;
		
		throw new \Exception('Invalid param suffix');
		
	}
}