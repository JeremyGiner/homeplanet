<?php
namespace homeplanet\Form;

use homeplanet\Entity\Knowledge;
use homeplanet\Entity\Character;

class KnowledgeTrade {

	/**
	 * @var Character
	 */
	private $_oCharacterSelf;
	
	/**
	 * @var Character
	 */
	private $_oCharacterTarget;
	
	/**
	 * @var Knowledge
	 */
	private $_oKnowledgeSelf;
	
	/**
	 * @var Knowledge
	 */	
	private $_oKnowledgeTarget;
	
//_____________________________________________________________________________
// Constructor
	
	public function __construct( 
			Character $oCharaterSelf, 
			Character $oCharacterTarget 
	) {
		$this->_oCharacterTarget = $oCharaterTarget;
		$this->_oCharacterSelf = $oCharaterSelf;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getCharacterSelf() {
		return $this->_oCharacterSelf;
	}
	public function getCharacterTarget() {
		return $this->_oCharacterTarget;
	}
	
	public function getKnowledgeSelf() {
		return $this->_oKnowledgeSelf;
	}
	public function getKnowledgeTarget() {
		return $this->_oKnowledgeTarget;
	}
	
//_____________________________________________________________________________
// Modifier
	
	public function setKnowledgeSelf( Knowledge $o ) {
		$this->_oKnowledgeSelf = $o;
		return $this;
	}
	public function setKnowledgeTarget( Knowledge $o ) {
		$this->_oKnowledgeTarget = $o;
		return $this;
	}
}
