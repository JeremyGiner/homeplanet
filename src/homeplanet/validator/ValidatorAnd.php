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
	
	public function validate( $o ) {
		foreach( $validator as $this->_a )
			if( !$validator->validate( $o ) ) return false;
		return true;
	}
}