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
	
	private $_sSessionKey;
	
	private $_iStep;
	private $_oData;
	
//_____________________________________________________________________________
//	Constructor

	public function __construct( 
			Session $oSession
	) {
		$this->_sSessionKey = 'multitstep.data';
		
		$this->setSerializer();
		$this->_oSession = $oSession;
		
		$this->_oData = null;
		$this->_iStep = null;
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
						$this->_sSerializerFormat
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
						$this->_sSerializerFormat
				),
		]);
	}
	
	public function reset() {
		var_dump('hard reset');
		$this->_oSession->remove($this->_sSessionKey);
	}
	
	public function handleForm( Form $oForm ) {
		// Get data and step from session
		
		if( !($oForm->isSubmitted() && $oForm->isValid()) )
			return;
		
		$this->_updateStep( $oForm );
		
		$this->save();
	}
	
//_____________________________________________________________________________
//	Sub-routine 
	
	private function _updateStep( Form $oForm) {
		
		// Case : Reset
		if( $oForm->has('_reset') && $oForm->get('_reset')->isClicked() ) {
			var_dump('reset');
			$this->_iStep = 0;
			$this->_oData = null;
			return;
		}
		
		// Case : back
		if( $oForm->has('_prev') && $oForm->get('_prev')->isClicked() ) {
			var_dump('prev');
			$this->_iStep = max(0,$this->_iStep--);
			return;
		}
		
		// Case : forward
		$this->_iStep++;
		$this->_oData = $oForm->getData();
	}
	
	
	
}