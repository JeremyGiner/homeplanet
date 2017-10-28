<?php
namespace homeplanet\Form;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Serializer\Serializer;
/**
 * 
 * Prototype for a multitep form solution
 */
class MultistepFormHandler {
	
	/**
	 * @var Session
	 */
	private $_oSession;
	/**
	 * @var Serializer
	 */
	private $_oSerializer;
	
	private $_sSerializerType;
	private $_sSerializerFormat;
	private $_aSerializerContext;
	
	private $_sSessionKey;
	
	private $_iStep;
	private $_oData;
	
//_____________________________________________________________________________
//	Constructor

	public function __construct( 
			Session $oSession,
			$sSessionKey = 'multitstep.data'
	) {
		$this->_sSessionKey = $sSessionKey;
		
		$this->setSerializer();
		$this->_oSession = $oSession;
		
		$this->_oData = null;
		$this->_iStep = null;
		
		$this->_aSerializerContext = [];
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getData( $oDefaultData = [] ) {
		
		if( $this->_iStep === null )
			$this->load();
		
		return $this->_oData === null ? $oDefaultData : $this->_oData;
	}
	
	public function getStep() {
		if( $this->_iStep === null )
			$this->load();
		
		return $this->_iStep;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setSerializer( 
			Serializer $oSerializer=null,
			$sType = '',
			$sFormat = 'json'
	) {
		$this->_oSerializer = $oSerializer;
		$this->_sSerializerType = $sType;
		$this->_sSerializerFormat = $sFormat;
	}
	
	public function setContext( array $a ) {
		$this->_aSerializerContext = $a;
	}
//_____________________________________________________________________________

	public function load() {
		if( $this->_oSession->has($this->_sSessionKey) ) {
			$a = $this->_oSession->get($this->_sSessionKey);
			
			$this->_iStep = $a['step'];
			$this->_oData = $this->_oSerializer == null ? 
				$a['data'] :
				$this->_oSerializer->deserialize(
						$a['data'], 
						$this->_sSerializerType, 
						$this->_sSerializerFormat,
						$this->_aSerializerContext
				);
		} else {
			$this->_iStep = 0;
			$this->_oData = null;
		}
	}
	
	public function save() {
		$this->_oSession->set( $this->_sSessionKey, [
			'step'=> $this->_iStep,
			'data' => $this->_oSerializer == null ? 
				$this->_oData :
				$this->_oSerializer->serialize(
						$this->_oData, 
						$this->_sSerializerFormat,
						$this->_aSerializerContext
				),
		]);
	}
	
	public function reset() {
		$this->_oSession->remove($this->_sSessionKey);
	}
	
	public function handleForm( Form $oForm ) {
		// Get data and step from session
		
		if( !$oForm->isSubmitted() )
			return false;
		
		// Case : Reset
		if( $oForm->has('_reset') && $oForm->get('_reset')->isClicked() ) {
			$this->reset();
			return true;
		}
		
		// Case : back
		if( $oForm->has('_prev') && $oForm->get('_prev')->isClicked() ) {
			$this->_iStep = max(0,$this->_iStep-1);
			$this->save();
			return true;
		}
		
		// Case : forward
		if( $oForm->isValid() ){
			$this->_iStep++;
			$this->_oData = $oForm->getData();
		}
		
		$this->save();
		return false;
	}
	
//_____________________________________________________________________________
//	Sub-routine 
	
	
	
	
}