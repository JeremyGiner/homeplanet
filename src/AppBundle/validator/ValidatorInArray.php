<?php
namespace AppBundle\validator;

class ValidatorInArray {
	
	protected $_a;
	
	public function __construct( array &$a ) {
		$this->_a = &$a;
	}
	
	public function validate( $o ) {
		return in_array($o, $this->_a);
	} 
}