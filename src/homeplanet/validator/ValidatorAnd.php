<?php
namespace homeplanet\validator;


class ValidatorAnd /*extends IExpressionValidator*/ {
	
	/**
	 * @var IValidator[]
	 */
	private $_a;
	
	public function __construct( array $a ) {
		$this->_a = $a;
	}
	
	public function getValidatorAr() {
		return $this->_a;
	}
	
	public function validate( $o ) {
		foreach( $this->_a as $validator )
			if( !$validator->validate( $o ) ) return false;
		return true;
	}
}